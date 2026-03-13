<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}


$entry_point_registry['note_fetch'] = array(
    'file' => 'custom/modules/Leads/note_fetch.php',
    'auth' => true,
);

