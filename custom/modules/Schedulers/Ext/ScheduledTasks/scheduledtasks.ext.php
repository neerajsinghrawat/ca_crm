<?php 
 //WARNING: The contents of this file are auto-generated



$job_strings[] = 'task_due_send_email';

function task_due_send_email() {
    require_once('custom/modules/Leads/sendTaskDue.php');
    return true;
}




$job_strings[] = 'task_due_send_email_sms';

function task_due_send_email_sms() {
    require_once('custom/modules/Leads/sendTaskDueEmailSms.php');
    return true;
}


?>