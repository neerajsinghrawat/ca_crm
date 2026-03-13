<?php 
 //WARNING: The contents of this file are auto-generated


/**
 * Custom ClearlyIP DID field for Users module
 * Direct Inward Dialing number for this user
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$dictionary['User']['fields']['clearlyip_did_c'] = array(
    'name' => 'clearlyip_did_c',
    'vname' => 'LBL_CLEARLYIP_DID',
    'type' => 'varchar',
    'len' => '50',
    'audited' => true,
    'comment' => 'ClearlyIP Direct Inward Dialing (DID) number for this user',
);



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




$dictionary['User']['fields']['current_session_id_c'] = array(
    'name' => 'current_session_id_c',
    'vname' => 'LBL_CURRENT_SESSION_ID_C',
    'type' => 'varchar',
    'len' => '255',
    'audited' => false,
    'required' => false,
    'massupdate' => false,
    'comment' => 'Stores last active PHP session id for single session login',
);


?>