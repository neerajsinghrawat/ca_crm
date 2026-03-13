<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}


$entry_point_registry['chat_fetch'] = array(
    'file' => 'custom/modules/Leads/chat_fetch.php',
    'auth' => true,
);

