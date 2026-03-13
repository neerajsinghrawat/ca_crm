<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class SlackNotifier
{
    private static $slackWebhookUrl = 'demo';
    //private static $slackWebhookUrl = 'demo';

    /**
     * Send a message to Slack
     * @param array $payload - Slack message payload (text, blocks, etc.)
     * @param string|null $webhookUrl - Optional: override default webhook URL
     * @return bool - true on success, false on failure
     */
    public static function sendToSlack(array $payload, string $webhookUrl = null): bool
    {
        $url = $webhookUrl ?? self::$slackWebhookUrl;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error    = curl_error($ch);
        curl_close($ch);

        if ($error || $httpCode !== 200) {
            $GLOBALS['log']->error("SlackNotifier: Failed to send. HTTP $httpCode | cURL error: $error");
            return false;
        } 

        return true;
    }
}