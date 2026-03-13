<?php

$job_strings[] = 'task_due_send_email_sms';

function task_due_send_email_sms() {
    require_once('custom/modules/Leads/sendTaskDueEmailSms.php');
    return true;
}

