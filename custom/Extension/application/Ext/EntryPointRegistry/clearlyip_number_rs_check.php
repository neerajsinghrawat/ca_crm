<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$entry_point_registry['clearlyip_number_rs_check'] = array(
    'file' => 'custom/modules/Leads/webhooks/clearlyip_number_rs_check.php',
    'auth' => false, // usually false for webhooks; you can add your own security token inside
);

