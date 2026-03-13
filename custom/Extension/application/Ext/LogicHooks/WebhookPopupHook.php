<?php
/**
 * Register Webhook Popup Logic Hook
 * This will include the webhook popup JavaScript on all pages
 */

if (!isset($hook_array) || !is_array($hook_array)) {
    $hook_array = array();
}

if (!isset($hook_array['after_ui_footer']) || !is_array($hook_array['after_ui_footer'])) {
    $hook_array['after_ui_footer'] = array();
}

// Register the webhook popup hook to run after the UI footer is displayed
$hook_array['after_ui_footer'][] = Array(
    50, // Sort order
    'Include Webhook Popup Script', // Hook label
    'custom/include/webhooks/WebhookPopupHook.php', // File path
    'WebhookPopupHook', // Class name
    'includeWebhookPopupScript' // Method name
);

