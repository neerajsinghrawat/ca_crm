<?php 
 //WARNING: The contents of this file are auto-generated



if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}


$entry_point_registry['chat_fetch'] = array(
    'file' => 'custom/modules/Leads/chat_fetch.php',
    'auth' => true,
);




if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}


$entry_point_registry['chat_save'] = array(
    'file' => 'custom/modules/Leads/chat_save.php',
    'auth' => true,
);



/**
 * Entry Point for ClearlyIP Webhook
 * Registers the webhook endpoint that ClearlyIP will call
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$entry_point_registry['ClearlyIPWebhook'] = array(
    'file' => 'custom/modules/Leads/webhooks/clearlyIPWebhookHandler.php',
    'auth' => false
);




if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$entry_point_registry['clearlyip_number_rs_check'] = array(
    'file' => 'custom/modules/Leads/webhooks/clearlyip_number_rs_check.php',
    'auth' => false, // usually false for webhooks; you can add your own security token inside
);




if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$entry_point_registry['clearlyip_sms_webhook'] = array(
    'file' => 'custom/modules/Leads/webhooks/clearlyip_sms_webhook.php',
    'auth' => false, // usually false for webhooks; you can add your own security token inside
);



/**
 * Register Click to Call Entry Point
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$entry_point_registry['ClickToCall'] = array(
    'file' => 'custom/modules/Leads/clickToCallHandler.php',
    'auth' => true, // Requires authentication
);



$entry_point_registry['getSalesUserMessages'] = array(
 'file' => 'custom/modules/Leads/getSalesUserMessages.php',
 'auth' => true, 
);

$entry_point_registry['getSingleLeadDetail'] = array(
 'file' => 'custom/modules/Leads/getSingleLeadDetail.php',
 'auth' => true, 
);

$entry_point_registry['getUserLeadsPanel'] = array(
 'file' => 'custom/modules/Leads/getUserLeadsPanel.php',
 'auth' => true, 
);


if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}


$entry_point_registry['note_fetch'] = array(
    'file' => 'custom/modules/Leads/note_fetch.php',
    'auth' => true,
);



$entry_point_registry['getSMSPopup'] = array(
 'file' => 'custom/modules/Leads/getSMSPopup.php',
 'auth' => true, 
);


if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$entry_point_registry['tradeinAppraisal'] = array(
    'file' => 'custom/modules/Leads/tradeinAppraisal.php',
    'auth' => false,
);




if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$entry_point_registry['tradeinAppraisalSubmit'] = array(
    'file' => 'custom/modules/Leads/tradeinAppraisalSubmit.php',
    'auth' => false,
);



/**
 * Entry Point for fetching webhook notifications
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$entry_point_registry['GetWebhookNotifications'] = array(
    'file' => 'custom/modules/Leads/webhooks/getWebhookNotifications.php',
    'auth' => true  // Requires authentication
);


?>