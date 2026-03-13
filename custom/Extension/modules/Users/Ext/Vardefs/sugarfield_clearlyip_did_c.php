<?php
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

