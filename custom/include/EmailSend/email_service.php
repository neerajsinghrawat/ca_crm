<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once 'data/BeanFactory.php';
require_once 'include/SugarPHPMailer.php';
require_once('custom/include/custom_utils.php');
require_once('modules/Emails/Email.php');

function sendAppraisalEmail($appraisalId, $row, $vin)
{
    global $db, $current_user, $log;


    // Notify users
    $notifyEmails = array(
        'yury@statuslease.com',
        'faisal@statuslease.com',
    );
    /*$notifyEmails = array(
        'rawat.neeraj.510@gmail.com'
    );*/

    $subject = 'New Trade-In Appraisal Submitted';
    $link = $GLOBALS['sugar_config']['site_url'] .
        "/index.php?module=ta_trade_appraisal&action=DetailView&record=" . $appraisalId;
    $body = "
        Hi Team,

        A new trade-in vehicle appraisal has been submitted.
        VIN: <a href='{$link}' target='_blank'><b>{$vin}</b></a><br><br>
        Please review it in SuiteCRM.

        Thanks";

    // get system email
     sendMailToNotifyUsers($notifyEmails, $subject, $body);
}

function sendMailToNotifyUsers($emails, $subject, $body)
{
    global $log;

    if (!is_array($emails)) {
        $emails = array($emails);
    }

    $emailObj = new Email();
    $defaults = $emailObj->getSystemDefaultEmail();

    foreach ($emails as $to) {

        if(empty($to)) continue;

        $mail = new SugarPHPMailer();
        $mail->setMailerForSystem();
        $mail->From     = $defaults['email'];
        $mail->FromName = $defaults['name'];
        $mail->Subject  = $subject;
        $mail->Body     = $body;
        $mail->IsHTML(true);
        $mail->prepForOutbound();
        $mail->AddAddress($to);

        if (!$mail->Send()) {
            $log->fatal('Email failed to '.$to.' Error: ' . $mail->ErrorInfo);
        } else {
            $log->fatal('Email sent to '.$to);
        }
    }
}
