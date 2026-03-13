<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('modules/Leads/controller.php');
require_once 'data/BeanFactory.php';
require_once 'include/SugarPHPMailer.php';
require_once('custom/include/custom_utils.php');

class CustomLeadsController extends LeadsController
{
    public function action_requestAppraisal()
    {
        global $db, $current_user, $log;
        //echo "<pre>REQUEST_METHOD==>";print_r($_SERVER['REQUEST_METHOD']);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'msg' => 'Invalid request']);
            exit;
        }
        
        $leadId = (isset($_REQUEST['lead_id']) && !empty($_REQUEST['lead_id']))?$db->quote($_REQUEST['lead_id']): null; 
        $lead_phone_number = !empty($_REQUEST['lead_phone_number'])
            ?$_REQUEST['lead_phone_number']: null;

        $lead_email = !empty($_REQUEST['lead_email'])
            ?$_REQUEST['lead_email']: null;


        $token   = create_guid();
        $expires = date('Y-m-d H:i:s', strtotime('+48 hours'));

        $db->query("
            INSERT INTO tradein_appraisal_tokens
            (id, lead_id, token, assigned_user_id, expires_at, date_entered)
            VALUES
            (
                UUID(),
                " . ($leadId ? "'$leadId'" : "NULL") . ",
                '$token',
                '{$current_user->id}',
                '$expires',
                NOW()
            )
        ");

        $link = $GLOBALS['sugar_config']['site_url']. "/index.php?entryPoint=tradeinAppraisal&token=".$token;

            //echo "<pre>_REQUEST==>";print_r($link);die; 
        if (!empty($leadId)) {
            $lead = BeanFactory::getBean('Leads', $leadId);
            if (empty($lead->id)) {
                echo json_encode(['success' => false, 'error' => 'Lead not found']);
                exit;
            }
            $lead_phone_number = !empty($lead->phone_work) ? $lead->phone_work:
                                 (!empty($lead->phone_mobile) ? $lead->phone_mobile:
                                 (!empty($lead->phone_home) ? $lead->phone_home:
                                 (!empty($lead->phone_other) ? $lead->phone_other: null)));


            $lead_email = $this->getAccountEmail($leadId);            
        }else{
            $apiResponse = array();
            $firstName = 'appraisal';
            $lastName  = 'Email';
            $addresses = '';
            $city = '';
            $state = '';
            $zip = '';
            //echo "<pre>lead_phone_number==>";print_r($lead_phone_number);
            if (!empty($lead_phone_number) || !empty($lead_email)) {
                $existingLeadId = null;

                // 1) Phone se check
                if (!empty($lead_phone_number)) {
                    $existingLeadId = findLeadByPhoneNew($db, $lead_phone_number);
                }

                // 2) Email se check 
                if (empty($existingLeadId) && !empty($lead_email)) {
                    $existingLeadId = findLeadByEmailNew($db, $lead_email);
                }

                if (!empty($existingLeadId)) {
                    $leadId = $existingLeadId;
                }else{
                    if (!empty($lead_phone_number)) {
                        //echo "<pre>sendPhoneToProxy==>";print_r($lead_phone_number);
                        $apiResponse = sendPhoneToProxy($lead_phone_number);
                        //echo "<pre>apiResponse==>";print_r($apiResponse);
                        $apiResponse = json_decode($apiResponse, true);
                    }
                    
                    if (!empty($apiResponse) && isset($apiResponse['names'][0]) && !empty($apiResponse['names'][0])) {                
                        $firstName = $apiResponse['names'][0]['first'] ?? null;
                        $lastName  = $apiResponse['names'][0]['last'] ?? null;
                        $fullName  = $apiResponse['names'][0]['data'] ?? $fromName;
                        if (isset($apiResponse['addresses'][0]) && !empty($apiResponse['addresses'][0])) {
                            $addresses  = $apiResponse['addresses'][0]['data'] ?? null;
                            $city  = $apiResponse['addresses'][0]['city'] ?? null;
                            $state  = $apiResponse['addresses'][0]['state'] ?? null;
                            $zip  = $apiResponse['addresses'][0]['zip'] ?? null;
                            $log->fatal('ClearlyIP Webhook: addresses is coming');
                        }

                    }

                    $firstNameFinal = !empty($firstName) ? $firstName : 'appraisal';

                    $leadId = create_guid(); 
                    $db->query("INSERT INTO leads (id, first_name, last_name, phone_mobile, primary_address_street, primary_address_city, primary_address_state, primary_address_postalcode, assigned_user_id, lead_source, date_entered, date_modified, created_by, modified_user_id, deleted) VALUES ('$leadId', '$firstNameFinal', '$lastName', '$lead_phone_number', '$addresses', '$city', '$state', '$zip', '1', 'Cold Call', NOW(), NOW(), '1', '1', 0)"); 
                    if (!empty($lead_email)){
                        $email = trim(strtolower($lead_email));
                        $emailId = create_guid();

                        $emailCaps = strtoupper($email);

                        $db->query("
                        INSERT INTO email_addresses
                        (id, email_address, email_address_caps, invalid_email, opt_out, date_created, date_modified, deleted)
                        VALUES
                        ('$emailId', '$email', '$emailCaps', 0, 0, NOW(), NOW(), 0)
                        ");

                        $relId = create_guid();
                        $db->query("
                        INSERT INTO email_addr_bean_rel
                        (id, email_address_id, bean_id, bean_module, primary_address, reply_to_address, date_created, date_modified, deleted)
                        VALUES
                        ('$relId', '$emailId', '$leadId', 'Leads', 1, 0, NOW(), NOW(), 0)
                        ");
                    }

                }

                
            }            
            

        }


        $db->query("UPDATE tradein_appraisal_tokens
                SET phone_number = '{$db->quote($lead_phone_number)}',email_address = '{$db->quote($lead_email)}',lead_id = '{$db->quote($leadId)}',
                    date_modified = NOW()
                WHERE token = '{$db->quote($token)}'
                  AND is_used = 0");
        if (!empty($lead_phone_number)) {            
            
            $this->sendSms($lead_phone_number,$link,$leadId);
        }

        if (!empty($lead_email)) {
            $this->sendEmailToUser($lead_email,$link,$leadId);
        }

        echo json_encode([
            'status'  => 'success',
            'msg'     => 'Appraisal link generated',
            'lead_id' => $leadId,
            'link'    => $link
        ]);
        exit;
    }

    public function action_getProductByStockNumber()
    {
        global $db;

        $stock = isset($_REQUEST['stock_number']) ? trim($_REQUEST['stock_number']) : '';

        if ($stock == '') {
            echo json_encode([
                'status' => 'error',
                'message' => 'Stock number missing'
            ]);
            exit;
        }

        
        /*$sql = "SELECT id, name, 
                       year_c, make_c, model_c
                FROM aos_products
                WHERE deleted = 0
                  AND part_number = '".$db->quote($stock)."'
                LIMIT 1";*/
       $sql = "SELECT id, name, 
               year_c, make_c, model_c
        FROM aos_products
        WHERE deleted = 0
          AND (
                stocknumber_c = '".$db->quote($stock)."'
                OR part_number = '".$db->quote($stock)."'
              )
        LIMIT 1";

        $result = $db->query($sql);
        $row = $db->fetchByAssoc($result);

        if (!$row) {
            echo json_encode([
                'status' => 'error',
                'message' => 'No product found'
            ]);
            exit;
        }

        // Lead fields ke hisaab se output set karo
        echo json_encode([
            'status' => 'success',
            'data' => [
                'product_id' => $row['id'],
                'product_name_c' => $row['name'],
                'interested_year' => $row['year_c'],
                'interested_make' => $row['make_c'],
                'interested_model' => $row['model_c'],
                //'interested_trim_c' => $row['trim_c'],
            ]
        ]);
        exit;
    }

    function getAccountEmail($accountId) {
        global $db;
        $email = '';
        $q = "SELECT email_addresses.email_address AS email_1 FROM email_addr_bean_rel INNER JOIN email_addresses ON email_addresses.id = email_addr_bean_rel.email_address_id WHERE email_addr_bean_rel.deleted = 0  AND email_addr_bean_rel.primary_address = 1 and email_addr_bean_rel.bean_id='".$accountId."'";
        $r = $db->query($q);
        $row = $db->fetchByAssoc($r);
        $email = $row['email_1'];
        return $email;
    }

    public function sendSms($lead_phone_number, $link,$leadId)
    {
        global $current_user;

        $lead_phone_number = preg_replace('/\D+/', '', $lead_phone_number);
        if (empty($lead_phone_number)) return false;

        $did = !empty($current_user->clearlyip_did_c)
            ? $current_user->clearlyip_did_c
            : '13476144062';
        $toEmail = $lead_phone_number . '@' . $did . '.mysms.ai';
        $message = "Hi! To proceed with your trade-in appraisal, please share your vehicle details here: $link";
        return $this->sendMessage($toEmail, 'Trade-In Appraisal', $message, false,'sms',$leadId);
    }

    public function sendEmailToUser($lead_email, $link,$leadId)
    {
        if (!filter_var($lead_email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $message = "
        Hi,<br><br>
        To proceed with your trade-in appraisal, please click the link below:<br><br>
        <a href='$link'>$link</a><br><br>
        Thank you,<br>
        Status
        ";

        return $this->sendMessage($lead_email, 'Trade-In Appraisal', $message, true,'email',$leadId);
    }



    public function sendMessage($toEmail, $subject, $message, $isHtml = false, $sendtype,$leadId)
    {
        global $db, $current_user, $log;

        if (empty($toEmail)) {
            return false;
        }

        $query = "SELECT * FROM outbound_email
                  WHERE deleted = 0
                    AND mail_sendtype = 'SMTP'
                    AND assigned_user_id = '" . $db->quote($current_user->id) . "'";
        $result = $db->query($query);
        $oe = $db->fetchByAssoc($result);

        $mail = new SugarPHPMailer();

        if ($oe) {
            $mail->IsSMTP();
            $mail->Host = $oe['mail_smtpserver'];
            $mail->Port = (int)$oe['mail_smtpport'];
            $mail->SMTPAuth = !empty($oe['mail_smtpauth_req']);

            if (!empty($oe['mail_smtpuser'])) {
                $mail->Username = $oe['mail_smtpuser'];
            }

            $mail->Password = blowfishDecode(
                blowfishGetKey('OutBoundEmail'),
                $oe['mail_smtppass']
            );

            if ($mail->Port == 465) $mail->SMTPSecure = 'ssl';
            if ($mail->Port == 587) $mail->SMTPSecure = 'tls';

            $mail->From = $oe['smtp_from_addr'];
            $mail->FromName = $oe['smtp_from_name'];
        } else {
            $emailObj = new Email();
            $defaults = $emailObj->getSystemDefaultEmail();
            $mail->setMailerForSystem();
            $mail->From = $defaults['email'];
            $mail->FromName = $defaults['name'];
        }

        $mail->IsHTML($isHtml);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->prepForOutbound();
        $mail->AddAddress($toEmail);

        if (!$mail->Send()) {
            $log->fatal("Message send failed: " . $mail->ErrorInfo);
            return false;
        }

        logActivity(
                'ta_trade_appraisal',   // module
                $leadId,           // record id
                $sendtype.' sent',             // create/edit
                'Email',                  // field
                '',                  // old
                $toEmail,                  // new
                'Trade-In Appraisal Request Sent by '.$sendtype, //description
                $leadId,//parent_id
                'leads',//parent_type
                'Trade-In Appraisal Request'//parent_type
            );
        return true;
    }

}
