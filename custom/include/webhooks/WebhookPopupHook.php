<?php
/**
 * Logic Hook to include Webhook Popup JavaScript on all pages
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

class WebhookPopupHook
{
    /**
     * Include the webhook popup JavaScript globally on all pages
     * This is called via the after_ui_footer logic hook
     */
    public function includeWebhookPopupScript($event, $arguments)
    {
        // Only include for authenticated users
        if (!isset($_SESSION["authenticated_user_id"])) {
            return;
        }
        // Don't include in AJAX requests - only on full page loads
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return;
        }
        // Output the script tag with proper escaping
        $scriptUrl = 'custom/include/webhooks/webhook_popup.js?v=' . time();
        echo '<script type="text/javascript" src="' . htmlspecialchars($scriptUrl, ENT_QUOTES, 'UTF-8') . '"></script>' . "\n";
    }
}

