<?php
/**
 * Register Click to Call Entry Point
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$entry_point_registry['ClickToCall'] = array(
    'file' => 'custom/modules/Leads/clickToCallHandler.php',
    'auth' => true, // Requires authentication
);

