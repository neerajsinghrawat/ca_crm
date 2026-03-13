<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class LeadAssignmentHook {
    function assignLeadRoundRobin($bean, $event, $arguments) {
        
        //echo "<pre>configKey";print_r($_REQUEST);die;
        /*if (!empty($bean->fetched_row)) {
            return; // Only on new record, not update
        }*/

         // Only assign if no user is already set
        //if (!empty($bean->assigned_user_id)) {
        //    return;
        //}

        //$isNew = !empty($arguments['new_with_id']);

        // OLD assigned user (from DB)
        $oldAssignedUser = '';
        $newAssignedUser ='';
        $oldAssignedUser = $bean->fetched_row['assigned_user_id'] ?? '';

        // NEW assigned user (after save)
        $newAssignedUser = $bean->assigned_user_id;
 
        global $db;

        if (strtolower($bean->category_c) == 'sales') {
            
            $isAdmin = false;
            if (!empty($newAssignedUser)) {
                $adminCheck = $db->query("SELECT user_name,id FROM users WHERE id = '{$newAssignedUser}' AND deleted = 0");
                $adminRow   = $db->fetchByAssoc($adminCheck);
                if (!empty($adminRow['user_name']) && $adminRow['user_name'] === 'admin') {
                    $isAdmin = true;
                }
                if (!empty($adminRow['id']) && $adminRow['id'] === '28cd850e-4af9-871b-dcfb-68af3faec1cc') {
                    $isAdmin = true;
                }
            }

            $isPreOwned = (!empty($bean->lead_type) && $bean->lead_type == 'used_car');

            $roleName = $isPreOwned ? 'Pre-Owned vehicle SP' : 'salesperson';
            $configKey = $isPreOwned ? 'pov_last_index' : 'last_index';

            if (empty($newAssignedUser) || $isAdmin) {

                $GLOBALS['log']->fatal('create lead blank assigned user');
                // Get salespersons (filter on role/team if needed)
                $result = $db->query("SELECT u.id FROM users u 
                    INNER JOIN acl_roles_users aru ON aru.user_id = u.id AND aru.deleted = 0 
                    INNER JOIN acl_roles ar ON ar.id = aru.role_id AND ar.deleted = 0 
                    WHERE u.deleted = 0 AND u.status = 'Active' 
                    AND ar.name = '{$roleName}' 
                    ORDER BY u.user_name ASC;");
                $users = [];
                while ($row = $db->fetchByAssoc($result)) {
                    $users[] = $row['id'];
                }

                
                if (empty($users)) return;

                // Get last assigned index (store in config table)
                $lastIndex = 0;
                $res = $db->query("SELECT value FROM config WHERE category='lead_assign' AND name='{$configKey}'");
                if ($row = $db->fetchByAssoc($res)) {
                    $lastIndex = (int)$row['value'];
                }
                
                // Next index
                $nextIndex = ($lastIndex + 1) % count($users);
                $nextUserId = $users[$nextIndex];
                $newAssignedUser =$nextUserId;
               
                $db->query("UPDATE leads SET assigned_user_id = '{$nextUserId}' WHERE id = '{$bean->id}'");
                $db->query("UPDATE tasks SET assigned_user_id = '{$nextUserId}' WHERE parent_type ='Leads' and parent_id = '{$bean->id}'");
                // Update config table
                $db->query("
                    UPDATE config 
                    SET value = '{$nextIndex}' 
                    WHERE category = 'lead_assign' 
                    AND name = '{$configKey}'
                ");
            }


            if ($oldAssignedUser === $newAssignedUser) {
                return; // ❌ No assignment change
            }
            
            $GLOBALS['log']->fatal('Assigned lead');

            $leadname = $bean->first_name.' '.$bean->last_name;
            $leadurl= 'index.php?module=Leads&action=DetailView&record='.$bean->id;

            $alert = BeanFactory::newBean('Alerts');
            $alert->name = 'A new lead has been assigned to you Lead:'.$leadname;
            $alert->description = '';
            $alert->target_module = 'Leads';
            $alert->url_redirect = $leadurl;
            $alert->assigned_user_id = $newAssignedUser;
            $alert->type = 'info'; 
            $alert->is_read = 0; 
            $alert->save();

            $GLOBALS['log']->fatal('create alert assigned user'.$newAssignedUser);

            $this->sendAssign($newAssignedUser,$bean);

        }
        if (strtolower($bean->category_c) == 'spam') {
            $db->query("UPDATE leads SET assigned_user_id = '7ece6313-5e55-9f20-de94-68a81e10756a' WHERE id = '{$bean->id}'");            
        }       

     
    }

    function getAccountEmail($accountId) {
        global $db;

        $q = "SELECT email_addresses.email_address AS email_1 FROM email_addr_bean_rel INNER JOIN email_addresses ON email_addresses.id = email_addr_bean_rel.email_address_id WHERE email_addr_bean_rel.deleted = 0  AND email_addr_bean_rel.primary_address = 1 and email_addr_bean_rel.bean_id='".$accountId."'";
        $r = $db->query($q);
        $row = $db->fetchByAssoc($r);
        $emails = $row['email_1'];
        return $emails;

    }

    function sendAssign($nextUserId, $bean) {
        require_once('modules/Emails/Email.php');
        require_once('include/SugarPHPMailer.php');

        global $db;
        $lead_phone_number = !empty($bean->phone_work) ? $bean->phone_work :
                     (!empty($bean->phone_mobile) ? $bean->phone_mobile :
                     (!empty($bean->phone_home) ? $bean->phone_home :
                     (!empty($bean->phone_other) ? $bean->phone_other : null)));

        $lead_email = $this->getAccountEmail($bean->id);

        $result = $db->query("SELECT first_name,last_name,phone_home,phone_mobile,phone_work,phone_other,clearlyip_did_c
                              FROM users WHERE id = '{$nextUserId}' AND deleted = 0");
        $row = $db->fetchByAssoc($result);

        $sp_phone_number = !empty($row['phone_work']) ? $row['phone_work'] :
                   (!empty($row['phone_mobile']) ? $row['phone_mobile'] :
                   (!empty($row['phone_home']) ? $row['phone_home'] :
                   (!empty($row['phone_other']) ? $row['phone_other'] : null)));

        $sp_phone_number = !empty($sp_phone_number) ? preg_replace('/[\s\-\(\)]+/', '', $sp_phone_number) : null; 
        $sp_name = (isset($row['first_name']) && !empty($row['first_name']))?$row['first_name'].' '.$row['last_name']:'';

        $sp_email = $this->getAccountEmail($nextUserId);

  
        //$email_1 = ($sp_phone_number && $lead_phone_number) ? $sp_phone_number.'@13476144062.mysms.ai' : '';

        $clearlyip_did_c=(!empty($current_user->clearlyip_did_c))?$current_user->clearlyip_did_c:'3476144062';
        //$clearlyip_did_c='3476144062';

        $email_1 = ($sp_phone_number)?trim($sp_phone_number).'@'.$clearlyip_did_c.'.mysms.ai' : '';

        /*$email_2 = ($sp_phone_number && $lead_phone_number) ? $lead_phone_number.'@'.$sp_phone_number.'.mysms.ai' : '';*/
  
        //$email_1 = '13476144062@13476144062.mysms.ai';
       // $email_2 = '17183147808@13476144062.mysms.ai';

        $data_sent = 0;

        $emailObj = new Email();
        $defaults = $emailObj->getSystemDefaultEmail();


        $lead_name     = trim($bean->first_name . ' ' . $bean->last_name);
        $lead_phone    = !empty($lead_phone_number) ? $lead_phone_number : 'N/A';
        $lead_mail     = !empty($lead_email) ? $lead_email : 'N/A';

        $site_url = rtrim($GLOBALS['sugar_config']['site_url'], '/');
        $lead_url   = $site_url.'index.php?module=Leads&action=DetailView&record=' . $bean->id;

        //-------------------- EMAIL 1: Salesperson --------------------
        if (!empty($email_1)) {            

            $subject = 'A New Lead Has Been Assigned';
            $body = 
            "Hello {$sp_name},\n" .
                    "A new lead has been assigned to you.\n\n" .
                    "Name: {$lead_name}\n" .
                    "Phone: {$lead_phone}\n" .
                    "Email: {$lead_mail}\n\n" .
                    "Please follow up promptly.";

            $mail = new SugarPHPMailer();
            $mail->setMailerForSystem();
            $mail->IsHTML(false);
            $mail->From = $defaults['email'];
            $mail->FromName = $defaults['name'];
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->prepForOutbound();
            $mail->AddAddress($email_1);

            if ($mail->Send()) {
                //echo "<pre>mail===>";print_r($mail);die;
                //   $GLOBALS['log']->fatal("email_1 mail ==>: " . print_r($mail, true));
                $data_sent = 1;
            }
        }


        if (!empty($sp_email)) {

            $subject = 'A New Lead Has Been Assigned to You';

            $body = "<html>
                    <head>
                      <style>
                        body { font-family: Arial, sans-serif; font-size: 14px; color: #333; }
                        .container { padding: 20px; max-width: 600px; margin: auto; }
                        .header { font-size: 18px; font-weight: bold; margin-bottom: 15px; color: #2c3e50; }
                        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
                        table td { padding: 8px 12px; border: 1px solid #ddd; }
                        table tr:nth-child(even) { background-color: #f9f9f9; }
                        .footer { margin-top: 20px; font-size: 12px; color: #888; }
                        .btn { display: inline-block; margin-top: 15px; padding: 10px 20px; 
                               background-color: #2980b9; color: #fff; text-decoration: none; 
                               border-radius: 4px; font-size: 14px; }
                      </style>
                    </head>
                    <body>
                      <div class='container'>
                        <div class='header'>New Lead Assigned to You</div>
                        <p>Hello <strong>{$sp_name}</strong>,</p>
                        <p>A new lead has been assigned to you in the CRM. Please review the details below and follow up promptly.</p>
                        <table>
                          <tr><td><strong>Lead Name</strong></td><td>{$lead_name}</td></tr>
                          <tr><td><strong>Email</strong></td><td>{$lead_mail}</td></tr>
                          <tr><td><strong>Phone</strong></td><td>{$lead_phone}</td></tr>
                        </table>
                        <a class='btn' href='{$lead_url}'>View Lead in CRM</a>
                        <div class='footer'>This is an automated message from your CRM system.</div>
                      </div>
                    </body>
                    </html>";

            $mail2 = new SugarPHPMailer();
            $mail2->setMailerForSystem();
            $mail2->IsHTML(true);
            $mail2->From     = $defaults['email'];
            $mail2->FromName = $defaults['name'];
            $mail2->Subject  = $subject;
            $mail2->Body     = $body;
            $mail2->prepForOutbound();
            $mail2->AddAddress($sp_email);

            if ($mail2->Send()) {
                $data_sent = 1;
                $GLOBALS['log']->fatal("Email sent successfully to: " . $sp_email);
            } else {
                $GLOBALS['log']->fatal("Email send FAILED to: " . $sp_email);
            }
        }
        // -------------------- EMAIL 2: Lead --------------------
        /*if (!empty($email_2)) {
            $subject = 'Thank You — Our Team Will Contact You Shortly';
            $body_html = "
            <div class='container'>
                <div class='header'>Thank You for Your Inquiry</div>
                <p>Hello {$bean->first_name},</p>
                <p>Thank you for reaching out. Our sales team has received your request and Salesperson:{$sp_name} will contact you shortly.</p>
                <p>If you have any urgent questions, feel free to reply to this email.</p>
                <p>Best regards,<br/>Status</p>
            </div>";

            $body = "<html>
                        <head>
                          <style>
                            body { font-family: Arial, sans-serif; font-size: 14px; color: #333; }
                            .container { padding: 20px; }
                            .header { font-size: 16px; font-weight: bold; margin-bottom: 10px; }
                          </style>
                        </head>
                        <body>{$body_html}</body>
                     </html>";

            $mail = new SugarPHPMailer();
            $mail->setMailerForSystem();
            $mail->IsHTML(true);
            $mail->From = $defaults['email'];
            $mail->FromName = $defaults['name'];
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->prepForOutbound();
            $mail->AddAddress($email_2);

            if ($mail->Send()) {
          
                $data_sent = 1;
            }
            

                // }
                */

        return $data_sent;
    }

}
