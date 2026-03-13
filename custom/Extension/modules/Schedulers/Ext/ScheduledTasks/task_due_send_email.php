<?php

$job_strings[] = 'task_due_send_email';

function task_due_send_email() {
    require_once('custom/modules/Leads/sendTaskDue.php');
    return true;
}

