<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once 'data/BeanFactory.php';
require_once 'include/SugarPHPMailer.php';
require_once('custom/include/custom_utils.php');

function sendSmsForLead($leadId, $message, $uploadedFiles = [])
{
    global $current_user, $db, $log;

    $lead = BeanFactory::getBean('Leads', $leadId);
    if (empty($lead->id)) {
        return ['success' => false, 'error' => 'Lead not found'];
    }

    $lead_phone_number = !empty($lead->phone_work) ? $lead->phone_work :
        (!empty($lead->phone_mobile) ? $lead->phone_mobile :
        (!empty($lead->phone_home) ? $lead->phone_home :
        (!empty($lead->phone_other) ? $lead->phone_other : null)));

    $lead_phone_number = preg_replace('/\D+/', '', $lead_phone_number);
    $clearlyip_did_c = (!empty($current_user->clearlyip_did_c)) ? $current_user->clearlyip_did_c : '13476144062';

    $toEmail = ($lead_phone_number) ? trim($lead_phone_number).'@'.$clearlyip_did_c.'.mysms.ai' : '';
    if (empty($toEmail)) {
        return ['success' => false, 'error' => 'Lead has no valid phone number'];
    }

    $query = "SELECT * FROM outbound_email
              WHERE deleted = 0
                AND mail_sendtype = 'SMTP'
                AND assigned_user_id = '" . $db->quote($current_user->id) . "' ";
    $result = $db->query($query);
    $oe = $db->fetchByAssoc($result);

    if($oe){
        $mail = new SugarPHPMailer();
        $mail->IsSMTP();
        $mail->Mailer = 'smtp';
        $mail->Host     = $oe['mail_smtpserver'] ?? '';
        $mail->Port     = !empty($oe['mail_smtpport']) ? intval($oe['mail_smtpport']) : 25;
        $mail->SMTPAuth = (!empty($oe['mail_smtpauth_req']) && $oe['mail_smtpauth_req'] == 1);

        if (!empty($oe['mail_smtpuser'])) {
            $mail->Username = $oe['mail_smtpuser'];
        }
        $smtpPass = blowfishDecode(blowfishGetKey('OutBoundEmail'), $oe['mail_smtppass']);
        $mail->Password = $smtpPass;

        $fromEmail = !empty($oe['smtp_from_addr']) ? $oe['smtp_from_addr'] : $current_user->email1;
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
    $mail->Subject = 'Message From Status';
    $mail->Body = $message;
    $mail->prepForOutbound();
    $mail->AddAddress($toEmail);

    $emailSent = false;
    if ($mail->Send()) {
        $emailSent = true;
    } else {
        $log->fatal("Email Send Failed: " . $mail->ErrorInfo);
    }

    $noteSaved = false;
    try {


        $q = "SELECT id FROM notes 
              WHERE parent_type='Leads' 
              AND parent_id='".$db->quote($leadId)."' 
              AND deleted=0 
              LIMIT 1";
        $r = $db->query($q);
        $row = $db->fetchByAssoc($r);

        if ($row && $row['id']) {
            $note = BeanFactory::getBean('Notes', $row['id']);
        } else {
            $note = BeanFactory::newBean('Notes');
            $note->name = "SMS History";
            $note->parent_type = "Leads";
            $note->parent_id = $leadId;
            $note->assigned_user_id = $current_user->id;
            $note->description = "";
        }

        $timestamp = date("Y-m-d H:i:s");
        $newBlock = "\n\n--- OUT | From: {$clearlyip_did_c} | To: {$toEmail} | At: {$timestamp} ---\n{$message}\n";
        $note->description .= $newBlock;
        $note->save();
        $noteSaved = true;

    } catch (Exception $e) {
        $log->fatal("NOTE SAVE ERROR: " . $e->getMessage());
    }

    return [
        'success' => true,
        'email_sent' => $emailSent,
        'note_saved' => $noteSaved
    ];
}
function sendSmsDirect($allnumber, $message)
{
    global $current_user, $db, $log;
    //echo "<pre>";print_r($allnumber);die;
    $query = "SELECT * FROM outbound_email
              WHERE deleted = 0
                AND mail_sendtype = 'SMTP'
                AND assigned_user_id = '" . $db->quote($current_user->id) . "' ";
    $result = $db->query($query);
    $oe = $db->fetchByAssoc($result);

    if($oe){
        $mail = new SugarPHPMailer();
        $mail->IsSMTP();
        $mail->Mailer = 'smtp';
        $mail->Host     = $oe['mail_smtpserver'] ?? '';
        $mail->Port     = !empty($oe['mail_smtpport']) ? intval($oe['mail_smtpport']) : 25;
        $mail->SMTPAuth = (!empty($oe['mail_smtpauth_req']) && $oe['mail_smtpauth_req'] == 1);

        if (!empty($oe['mail_smtpuser'])) {
            $mail->Username = $oe['mail_smtpuser'];
        }
        $smtpPass = blowfishDecode(blowfishGetKey('OutBoundEmail'), $oe['mail_smtppass']);
        $mail->Password = $smtpPass;

        $fromEmail = !empty($oe['smtp_from_addr']) ? $oe['smtp_from_addr'] : $current_user->email1;
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
    $mail->Subject = 'Message From Status';
    $mail->Body = $message;
    $mail->prepForOutbound();

    foreach ($allnumber as $key => $number) {
        $number = preg_replace('/\D+/', '', $number);
        $clearlyip_did_c = (!empty($current_user->clearlyip_did_c)) ? $current_user->clearlyip_did_c : '13476144062';
        $toEmail = ($number) ? trim($number).'@'.$clearlyip_did_c.'.mysms.ai' : '';
        $mail->AddAddress($toEmail);
    }


    $emailSent = false;
    if ($mail->Send()) {
        $emailSent = true;
    } else {
        $log->fatal("Email Send Failed: " . $mail->ErrorInfo);
    }

    $noteSaved = false;

    return [
        'success' => true,
        'email_sent' => $emailSent,
        'note_saved' => $noteSaved
    ];
}
