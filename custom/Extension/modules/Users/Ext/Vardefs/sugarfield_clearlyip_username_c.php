<?php
/**
 * Custom ClearlyIP Username field for Users module
 * Username for ClearlyIP authentication
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$dictionary['User']['fields']['clearlyip_username_c'] = array(
    'name' => 'clearlyip_username_c',
    'vname' => 'LBL_CLEARLYIP_USERNAME',
    'type' => 'varchar',
    'len' => '100',
    'audited' => true,
    'comment' => 'ClearlyIP username for authentication',
);

