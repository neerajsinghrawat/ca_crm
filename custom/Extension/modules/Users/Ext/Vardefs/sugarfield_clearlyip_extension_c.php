<?php
/**
 * Custom ClearlyIP Extension field for Users module
 * User's extension number
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$dictionary['User']['fields']['clearlyip_extension_c'] = array(
    'name' => 'clearlyip_extension_c',
    'vname' => 'LBL_CLEARLYIP_EXTENSION',
    'type' => 'varchar',
    'len' => '50',
    'audited' => true,
    'comment' => 'ClearlyIP extension number for this user',
);

