<?php
/**
 * Custom ClearlyIP Password field for Users module
 * Password for ClearlyIP authentication
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$dictionary['User']['fields']['clearlyip_password_c'] = array(
    'name' => 'clearlyip_password_c',
    'vname' => 'LBL_CLEARLYIP_PASSWORD',
    'type' => 'varchar',
    'dbType' => 'varchar',
    'len' => '255',
    'audited' => false,
    'comment' => 'ClearlyIP password for authentication (stored as password for security)',
);

