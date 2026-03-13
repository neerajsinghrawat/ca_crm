<?php
global $db;

$today = date('Y-m-d');
$GLOBALS['log']->fatal('today : '.$today);
$query = "SELECT tasks.*, users.reports_to_id AS user_reports_to_id, CONCAT(users.first_name ,' ',users.last_name) AS salesperson_name
          FROM tasks
          LEFT JOIN users ON users.id = tasks.assigned_user_id
          WHERE tasks.parent_type = 'Leads'
          AND tasks.status = 'Pending Input'
          AND DATE(tasks.date_due) < '$today'";
$result = $db->query($query);

while ($row = $db->fetchByAssoc($result)) {
   
    $is_sent = sendReminderEmail($row);

    if ($is_sent == 1) {
         $db->query("UPDATE tasks SET status = 'Urgent Work' WHERE id = '".$row['id']."'");
    }
       
    
}

//die;
function sendReminderEmail($row) {
    require_once('modules/EmailTemplates/EmailTemplate.php');
    require_once('modules/Emails/Email.php');
    require_once('include/SugarPHPMailer.php');
    ob_start();

    $userId=$row['assigned_user_id'];
    $user_reports_to_id=$row['user_reports_to_id'];
    $templateId = 'task due';

    $email_1 = getAccountEmail($user_reports_to_id);
    //$email_1 = 'rawat.neeraj.510@gmail.com';
    
   
    $data_sent = 0;

    if ($email_1 != '') {
        $template = new EmailTemplate();
        //$template->retrieve($templateId);
        $template->retrieve_by_string_fields(array('name' => $templateId, 'type' => 'email'));
        if (!empty($template->subject) || !empty($template->body_html)) {
            $GLOBALS['log']->fatal('template : '.json_encode($template->body_html));
            //unset($template);
            $GLOBALS['log']->fatal('after detstry-id : '.json_encode($template->body_html));
            $body = $template->body_html;

            // Replace merge fields manually if needed
            
            $template->body_html = str_replace("\$contact_user_user_name", $row['salesperson_name'], $template->body_html);
            $template->body_html = str_replace("\$task_name", $row['name'], $template->body_html);

            $emailObj = new Email();
            $defaults = $emailObj->getSystemDefaultEmail();

            $mail = new SugarPHPMailer();
            $mail->setMailerForSystem();
            $mail->IsHTML(true);
            $mail->From = $defaults['email'];
            $mail->FromName = $defaults['name'];

            if (!empty($template->subject))
                $mail->Subject = $template->subject;
            else
                $mail->Subject = "";


            $mail->Body = $template->body_html;
            $mail->prepForOutbound();
            //$mail->AddAddress($email_1); 
            $mail->AddAddress($email_1); 
            if ($mail->Send()) {
                $data_sent = 1;
            } 
            
        }
        
        
    } 
    return $data_sent;

}

function getAccountEmail($accountId) {
    global $db;

    $q = "SELECT email_addresses.email_address AS email_1 FROM email_addr_bean_rel INNER JOIN email_addresses ON email_addresses.id = email_addr_bean_rel.email_address_id WHERE email_addr_bean_rel.deleted = 0  AND email_addr_bean_rel.primary_address = 1 and email_addr_bean_rel.bean_id='".$accountId."'";
    $r = $db->query($q);
    $row = $db->fetchByAssoc($r);
    $emails = $row['email_1'];
    return $emails;

}

/*function getAccountName($accountId) {
    global $db;
    $acc_name = '';

    
    $accq = "SELECT CONCAT(contacts.first_name ,' ',contacts.last_name) AS acc_name  FROM contacts WHERE contacts.deleted = 0  AND contacts.id='".$accountId."'";
    $accr = $db->query($accq);
    $accrow = $db->fetchByAssoc($accr); 
    $acc_name = $accrow['acc_name'];       


    return $acc_name;

}*/