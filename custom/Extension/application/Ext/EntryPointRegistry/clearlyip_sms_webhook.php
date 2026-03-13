<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$entry_point_registry['clearlyip_sms_webhook'] = array(
    'file' => 'custom/modules/Leads/webhooks/clearlyip_sms_webhook.php',
    'auth' => false, // usually false for webhooks; you can add your own security token inside
);

