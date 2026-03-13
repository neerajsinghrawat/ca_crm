<?php
/**
 * Entry Point for ClearlyIP Webhook
 * Registers the webhook endpoint that ClearlyIP will call
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$entry_point_registry['ClearlyIPWebhook'] = array(
    'file' => 'custom/modules/Leads/webhooks/clearlyIPWebhookHandler.php',
    'auth' => false
);

