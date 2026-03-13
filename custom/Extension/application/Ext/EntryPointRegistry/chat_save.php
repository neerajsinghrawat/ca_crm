<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}


$entry_point_registry['chat_save'] = array(
    'file' => 'custom/modules/Leads/chat_save.php',
    'auth' => true,
);

