<?php
/**
 * Entry Point for fetching webhook notifications
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$entry_point_registry['GetWebhookNotifications'] = array(
    'file' => 'custom/modules/Leads/webhooks/getWebhookNotifications.php',
    'auth' => true  // Requires authentication
);

