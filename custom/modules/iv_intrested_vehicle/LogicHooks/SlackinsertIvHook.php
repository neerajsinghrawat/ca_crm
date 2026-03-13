<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
//require_once('custom/utils/SlackNotifier.php');
require_once('custom/include/Sms/SlackNotifier.php');
class SlackIntrestedVehicleHook
{
    
    public function sendIntrestedVehicleNotification($bean, $event, $arguments)
    {
        // Only trigger when assigned user changes
        if (!empty($bean->fetched_row)) {
            return;
        }

        $siteUrl = rtrim($GLOBALS['sugar_config']['site_url'], '/');
        $iv_Url = "{$siteUrl}/index.php?module=iv_intrested_vehicle&action=DetailView&record={$bean->id}";

        

        $message = [
            'text' => ':rotating_light: *Intrested Vehicle*',
            'blocks' => [
                [
                    'type' => 'section',
                    'text' => [
                        'type' => 'mrkdwn',
                        'text' => "*Type:* <{$iv_Url}|{$bean->lead_type}>\n"
                            . "*Make:* {$bean->interested_make}\n"
                            . "*Model:* {$bean->interested_model}\n"
                            . "*Year:* {$bean->interested_year}\n"
                    ]
                ],
                [
                    'type' => 'context',
                    'elements' => [
                        [
                            'type' => 'mrkdwn',
                            'text' => "CRM ID: {$bean->id}"
                        ]
                    ]
                ]
            ]
        ];

        SlackNotifier::sendToSlack($message);
    }


}