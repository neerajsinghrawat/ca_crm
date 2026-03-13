<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/entryPoint.php');
require_once 'include/SugarPHPMailer.php';
require_once 'custom/include/EmailSend/email_service.php';
require_once 'custom/include/custom_utils.php';

global $db;


$token = $_POST['token'] ?? '';

if (empty($token)) {
    die('Invalid request');
}

$res = $db->query("
    SELECT * FROM tradein_appraisal_tokens
    WHERE token = '{$db->quote($token)}'
      AND is_used = 0
    LIMIT 1
");

$row = $db->fetchByAssoc($res);
if (!$row) {
    die('Invalid or already used link');
}


$vin            = $db->quote($_POST['vin'] ?? '');
$vehicle_state  = $db->quote($_POST['vehicle_state'] ?? '');
$has_payoff     = isset($_POST['has_payoff']) ? (int)$_POST['has_payoff'] : 0;
$payoff_amount  = $db->quote($_POST['payoff_amount'] ?? '');
//$carfax_link    = $db->quote($_POST['carfax_link'] ?? '');
$carfax_link    = '';

$vehicle_year   = $db->quote($_POST['vehicle_year'] ?? '');
$vehicle_make   = $db->quote($_POST['vehicle_make'] ?? '');
$vehicle_model  = $db->quote($_POST['vehicle_model'] ?? '');
$vehicle_engine = $db->quote($_POST['vehicle_engine'] ?? '');

$mileage              = isset($_POST['mileage']) ? (int)$_POST['mileage'] : NULL;
$phone_number         = isset($_POST['phone_number']) ?$_POST['phone_number'] : NULL;
$email_address         = isset($_POST['email_address']) ?$_POST['email_address'] : NULL;
$vehicle_condition    = $db->quote($_POST['vehicle_condition'] ?? '');
$has_modifications    = isset($_POST['has_modifications']) ? (int)$_POST['has_modifications'] : 0;
$modification_details = $db->quote($_POST['modification_details'] ?? '');


$appraisalId = create_guid();

$photoUrls = array();

if (!empty($_FILES['vehicle_photos']['name'][0])) {

    $allowedExt  = array('jpg','jpeg','png','gif','webp');
    $allowedMime = array(
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp'
    );

    $baseDir = 'upload/trade_in_vehicle_photos/';
    if (!is_dir($baseDir)) {
        mkdir($baseDir, 0777, true);
    }

    foreach ($_FILES['vehicle_photos']['name'] as $i => $name) {

        if ($_FILES['vehicle_photos']['error'][$i] !== UPLOAD_ERR_OK) {
            continue;
        }

        $tmp  = $_FILES['vehicle_photos']['tmp_name'][$i];
        $ext  = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $mime = mime_content_type($tmp);

        if (!in_array($ext, $allowedExt) || !in_array($mime, $allowedMime)) {
            continue;
        }

        if (!getimagesize($tmp)) {
            continue;
        }

        $newName = $appraisalId . '_' . time() . '_' . $i . '.' . $ext;
        $target  = $baseDir . $newName;

        if (move_uploaded_file($tmp, $target)) {
            $photoUrls[] = $target; // relative URL
        }
    }
}

$vehiclePhotos = $db->quote(implode(',', $photoUrls));

$insertResult = $db->query("
    INSERT INTO ta_trade_appraisal
    (
        id,
        vin,
        vehicle_year,
        vehicle_make,
        vehicle_model,
        vehicle_engine,
        vehicle_state,
        has_payoff,
        payoff_amount,
        carfax_link,
        vehicle_photos,
        mileage,
        vehicle_condition,
        has_modifications,
        modification_details,
        phone_number,
        email_address,
        lead_id,
        date_entered
    )
    VALUES
    (
        '$appraisalId',
        '$vin',
        '$vehicle_year',
        '$vehicle_make',
        '$vehicle_model',
        '$vehicle_engine',
        '$vehicle_state',
        '$has_payoff',
        '$payoff_amount',
        '$carfax_link',
        '$vehiclePhotos',
        " . ($mileage !== NULL ? $mileage : "NULL") . ",
        '$vehicle_condition',
        '$has_modifications',
        '$modification_details',
        '$phone_number',
        '$email_address',
        " . ($row['lead_id'] ? "'{$row['lead_id']}'" : "NULL") . ",
        NOW()
    )
");

if ($insertResult && $db->getAffectedRowCount($insertResult) > 0) {

    $lead = BeanFactory::getBean('Leads', $row['lead_id']);
    $link = 'index.php?module=ta_trade_appraisal&action=DetailView&record='. $appraisalId;

    $alert = BeanFactory::newBean('Alerts');
    $alert->name = "New Trade-In Appraisal Received - VIN: " . $vin;
    $alert->description = '';
    $alert->target_module = 'ta_trade_appraisal';
    $alert->url_redirect = $link;
    $alert->assigned_user_id = $lead->assigned_user_id;
    $alert->type = 'info'; 
    $alert->is_read = 0; 
    $alert->save();

    sendAppraisalEmail($appraisalId, $row, $vin);

    logActivity(
        'ta_trade_appraisal',   // module
        $appraisalId,           // record id
        'formsubmit',             // create/edit
        'vin',                  // field
        '',                  // old
        $vin,                  // new
        'Trade-In Appraisal Form Submited by lead user', //description
        $row['lead_id'],//parent_id
        'Leads',//parent_type
        'lead submited form'//name
    );
}
$db->query("
    UPDATE tradein_appraisal_tokens
    SET is_used = 1,
        date_modified = NOW()
    WHERE id = '{$row['id']}'
");
/*function sendAppraisalEmail($appraisalId, $row, $vin)
{
    global $db, $current_user, $log;

    require_once('include/SugarPHPMailer.php');
    require_once('modules/Emails/Email.php');

    // Notify users
    $notifyEmails = array(
        'yury@statuslease.com',
        'faisal@statuslease.com',
    );
    

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
    $emailObj = new Email();
    $defaults = $emailObj->getSystemDefaultEmail();

    foreach ($notifyEmails as $to) {

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
            $log->fatal('Appraisal email failed: ' . $mail->ErrorInfo);
        }
    }
}*/

?>
<!DOCTYPE html>
<html>
<head>
    <title>Appraisal Submitted</title> <!-- Bootstrap 4 -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        body { background:#f4f6f9; }
        .card { margin-top:40px; }
        .required::after { content:" *"; color:red; }
        .td-cant {
            background: #ffffff;
            box-shadow: 0 15px 40px #00000017;
            border-radius: 10px;
            flex-direction: column;
            display: flex;
            height: 700px;
            justify-content: center;
            align-items: center;
        }

        .td-cant img {
            position: absolute;
            top: 14%;
        }

    </style>
</head>
<body class="suitep">

<div class="container td-cant" style="margin-top:50px;">
    <img src="https://crm.iconsolutions360.com/carcrm/custom/themes/default/images/company_logo.png">
    <h3>✅ Thank you!</h3>
    <p>Your vehicle appraisal has been submitted successfully.</p>
    <p>Our sales team will review it and contact you shortly.</p>
    <p>www.StatusLease.com</p>
</div>

</body>
</html>
