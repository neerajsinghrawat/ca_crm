<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once 'include/entryPoint.php';
require_once 'data/BeanFactory.php';
require_once 'include/SugarPHPMailer.php';

require_once('custom/include/custom_utils.php');
global $current_user, $db, $log;

header("Content-Type: application/json; charset=utf-8");

        // -------------------------------
        // 1. Read Request
        // -------------------------------
        /*echo "<pre>_FILES===>";print_r($_FILES);
        echo "<pre>";print_r($_REQUEST);die;*/
        $leadId  = $_POST['lead_id'] ?? '';
        $approval_message  = $_POST['approval_message'] ?? '';
        $message = trim($_POST['message'] ?? '');
        $todo = trim($_POST['todo'] ?? '');

        if (!$leadId || !$message) {
            echo json_encode(['success' => false, 'error' => 'Missing lead_id or message']);
            exit;
        }

        // -------------------------------
        // 2. Load Lead
        // -------------------------------
        $lead_phone_number = '';
        if ($todo != 1) {

            $lead = BeanFactory::getBean('Leads', $leadId);
            if (empty($lead->id)) {
                echo json_encode(['success' => false, 'error' => 'Lead not found']);
                exit;
            }

            $lead_phone_number = !empty($lead->phone_work) ? $lead->phone_work:
                             (!empty($lead->phone_mobile) ? $lead->phone_mobile:
                             (!empty($lead->phone_home) ? $lead->phone_home:
                             (!empty($lead->phone_other) ? $lead->phone_other: null)));
        }
        //echo "<pre>lead_phone_number==>";print_r($lead_phone_number);die;
        //$toEmail = ($lead_phone_number) ? $lead_phone_number.'@13476144062.mysms.ai' : '';
        if ($todo == 1) {
            try {
                $q = "SELECT id FROM notes 
                      WHERE parent_type='iv_intrested_vehicle' 
                      AND parent_id='{$leadId}' 
                      AND name='TODO History' 
                      AND deleted=0 
                      LIMIT 1";
                $r = $db->query($q);
                $row = $db->fetchByAssoc($r);

                if ($row && $row['id']) {
                    // Load existing chat note
                    $note = BeanFactory::getBean('Notes', $row['id']);
                } else {
                    // Create new chat history note
                    $note = BeanFactory::newBean('Notes');
                    $note->name = "TODO History";
                    $note->parent_type = "iv_intrested_vehicle";
                    $note->parent_id = $leadId;
                    $note->assigned_user_id = $current_user->id;
                    $note->description = ""; 
                }

                $timestamp = date("Y-m-d H:i:s");
                $userName = $current_user->full_name;

                $newBlock = "\n\n--- OUT | From: {$clearlyip_did_c} | To: {$toEmail} | At: {$timestamp} ---\n{$message}\n";

                /*if (!empty($imageBlocks)) {

                    $newBlock .= "<div class='sms-image-grid' style='margin-top:6px;'>";

                    foreach (array_chunk($imageBlocks, 3) as $row) {
                        $newBlock .= "<div class='sms-image-row' style='display:flex; gap:6px; margin-bottom:6px;'>";
                        foreach ($row as $imgHtml) {
                            $newBlock .= $imgHtml;
                        }
                        $newBlock .= "</div>";
                    }

                    $newBlock .= "</div>";
                }*/
                $note->description .= $newBlock;
                
                $note->save();
                $noteSaved = true;
            } catch (Exception $e) {
                $noteSaved = false;
                $log->fatal("NOTE SAVE ERROR: " . $e->getMessage());
            }
            echo json_encode([
                'success' => true,
                'email_sent' => true,
                'note_saved' => $noteSaved
            ]);
        }else{
                   
            $lead_phone_number = preg_replace('/\D+/', '', $lead_phone_number);
            $clearlyip_did_c=(!empty($current_user->clearlyip_did_c))?$current_user->clearlyip_did_c:'13476144062';                    
            //$toEmail = '17183147808@13476144062.mysms.ai'; //aj 
            //$toEmail = '17183147808@3473633167.mysms.ai'; //Wmalik 

            $toEmail = ($lead_phone_number)?trim($lead_phone_number).'@'.$clearlyip_did_c.'.mysms.ai' : '';

            $subject = 'Message From Status';
            if (empty($toEmail)){
                echo json_encode(['success' => false, 'error' => 'Lead has no valid email and Phone number']);
                exit;
            }

            $uploadedFiles = [];

            if (!empty($_FILES['images']['name'][0])) {

                $uploadDir = 'upload/sms_image/send/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                foreach ($_FILES['images']['name'] as $k => $name) {

                    if ($_FILES['images']['error'][$k] !== UPLOAD_ERR_OK) continue;

                    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                    if (!in_array($ext, ['jpg','jpeg','png','gif','webp'])) continue;

                    $newName = uniqid('sms_') . '.' . $ext;
                    $path = $uploadDir . $newName;

                    if (move_uploaded_file($_FILES['images']['tmp_name'][$k], $path)) {
                        $uploadedFiles[] = [
                            'path' => $path,
                            'name' => $name
                        ];
                    }
                }
            }


            // 3. Send Email (SugarPHPMailer)
            $query = "SELECT * FROM outbound_email
                      WHERE deleted = 0
                        AND mail_sendtype = 'SMTP'
                        AND assigned_user_id = '" . $db->quote($current_user->id) . "' ";
            $result = $db->query($query);

            // pick the first result
            $oe = $db->fetchByAssoc($result);

            if($oe){
                $mail = new SugarPHPMailer();
                $mail->IsSMTP();
                $mail->Mailer = 'smtp';
                $mail->Host     = isset($oe['mail_smtpserver']) ? $oe['mail_smtpserver'] : '';
                $mail->Port     = isset($oe['mail_smtpport']) ? intval($oe['mail_smtpport']) : 25;
                $mail->SMTPAuth = (isset($oe['mail_smtpauth_req']) && $oe['mail_smtpauth_req'] == 1) ? true : false;

                    // username (may be empty)
                    if (!empty($oe['mail_smtpuser'])) {
                        $mail->Username = $oe['mail_smtpuser'];
                    }
                    $smtpPass = blowfishDecode(blowfishGetKey('OutBoundEmail'), $oe['mail_smtppass']);                

                    $mail->Password = $smtpPass;
                    if (!empty($oe['mail_smtpport'])) {
                        $port = intval($oe['mail_smtpport']);
                        if ($port === 465) {
                            $mail->SMTPSecure = 'ssl';
                        } elseif ($port === 587) {
                            $mail->SMTPSecure = 'tls';
                        }
                    }

                    $fromEmail = !empty($oe['smtp_from_addr']) ? $oe['smtp_from_addr'] : $user->email1;
                    $fromName  = !empty($oe['smtp_from_name']) ? $oe['smtp_from_name'] : 'Status';
                    $mail->From     = $fromEmail;
                    $mail->FromName = $fromName;
            }else{
                $emailObj = new Email();
                $defaults = $emailObj->getSystemDefaultEmail();
                $mail = new SugarPHPMailer();
                $mail->setMailerForSystem();           
                $mail->From = $defaults['email'];
                $mail->FromName = $defaults['name'];
            }

            $mail->IsHTML(false);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->prepForOutbound();
            $mail->AddAddress($toEmail);
            $imageBlocks = [];
            foreach ($uploadedFiles as $file) {
                $webPath = $file['path'];
                $imageBlocks[] = "
                    <a href=\"{$webPath}\" style=\"margin:4px; display:inline-block;\">
                        <img src=\"{$webPath}\" style=\"width:70px; border:1px solid #ccc; border-radius:4px;\" />
                    </a>
                ";
                $mail->AddAttachment($file['path'], $file['name']);
            }

            
            $emailSent = false;
            if ($mail->Send()) {
                $emailSent = true;

            } else {
                $emailSent = false;
                $log->fatal("Email Send Failed: " . $mail->ErrorInfo);
            }

            // 4. Save Note Linked to Lead
            try {

                $apiTaskResult = createTaskFromMessageAPI($leadId, $message);

                if (!$apiTaskResult['success']) {
                    $log->fatal("Task API Failed: HTTP ".$apiTaskResult['httpCode']." | ".$apiTaskResult['response']." | Error: ".$apiTaskResult['error']);
                }

                $q = "SELECT id FROM notes 
                      WHERE parent_type='Leads' 
                      AND parent_id='{$leadId}' 
                      AND name='SMS History'
                      AND deleted=0 
                      LIMIT 1";
                $r = $db->query($q);
                $row = $db->fetchByAssoc($r);

                if ($row && $row['id']) {
                    // Load existing chat note
                    $note = BeanFactory::getBean('Notes', $row['id']);
                } else {
                    // Create new chat history note
                    $note = BeanFactory::newBean('Notes');
                    $note->name = "SMS History";
                    $note->parent_type = "Leads";
                    $note->parent_id = $leadId;
                    $note->assigned_user_id = $current_user->id;
                    $note->description = ""; // empty, will append below
                }

                $timestamp = date("Y-m-d H:i:s");
                $userName = $current_user->full_name;

                $newBlock = "\n\n--- OUT | From: {$clearlyip_did_c} | To: {$toEmail} | At: {$timestamp} ---\n{$message}\n";

                if (!empty($imageBlocks)) {

                    $newBlock .= "<div class='sms-image-grid' style='margin-top:6px;'>";

                    foreach (array_chunk($imageBlocks, 3) as $row) {
                        $newBlock .= "<div class='sms-image-row' style='display:flex; gap:6px; margin-bottom:6px;'>";
                        foreach ($row as $imgHtml) {
                            $newBlock .= $imgHtml;
                        }
                        $newBlock .= "</div>";
                    }

                    $newBlock .= "</div>";
                }
                $note->description .= $newBlock;
                
                $note->save();
                $noteSaved = true;
                if ($approval_message == 'approval_message') {
                    logActivity(
                        'leads',   // module
                        $leadId,           // record id
                        'sms sent',             // create/edit
                        '',                  // field
                        '',                  // old
                        '',                  // new
                        'Message Service ON Approval Request Sent by manual Sms', //description
                        $leadId,//parent_id
                        'Leads',//parent_type
                        'message service on approval manual sent'//name
                    );
                }
            } catch (Exception $e) {
                $noteSaved = false;
                $log->fatal("NOTE SAVE ERROR: " . $e->getMessage());
            }

            // -------------------------------
            // 5. Response back to popup
            // -------------------------------

            echo json_encode([
                'success' => true,
                'email_sent' => $emailSent,
                'note_saved' => $noteSaved
            ]);

        } 
        exit;

?>
