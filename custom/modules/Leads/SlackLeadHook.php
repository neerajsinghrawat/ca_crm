<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
//require_once('custom/utils/SlackNotifier.php');
require_once('custom/include/Sms/SlackNotifier.php');
class SlackLeadHook
{
    //private $slackWebhookUrl = 'done';
      //private $slackWebhookUrl = 'done';
   

    public function sendLeadAssignedNotification($bean, $event, $arguments)
    {
        // Only trigger when assigned user changes
        /*if (empty($bean->fetched_row)) {
            return;
        }*/

        if ($bean->assigned_user_id === $bean->fetched_row['assigned_user_id']) {
            return;
        }

        $assignedUser = BeanFactory::getBean('Users', $bean->assigned_user_id);

        $message = [
            'text' => ':rotating_light: *Lead Assigned*',
            'blocks' => [
                [
                    'type' => 'section',
                    'text' => [
                        'type' => 'mrkdwn',
                        'text' => "*Lead:* {$bean->first_name} {$bean->last_name}\n"
                            . "*Company:* {$bean->account_name}\n"
                            . "*Assigned To:* {$assignedUser->full_name}"
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

    /*private function sendToSlack($payload)
    {
        $ch = curl_init($this->slackWebhookUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }*/
}