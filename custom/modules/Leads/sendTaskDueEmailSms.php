<?php
    global $db;

    $time12HoursAgo = date('Y-m-d H:i:s', strtotime('-12 hours'));

    // MEETINGS
    $queryMeetings = "
        SELECT m.id, m.name, m.date_entered,m.status,m.parent_id,
               u.first_name AS salesperson_first_name,
               u.last_name AS salesperson_last_name,
               u.id AS sales_email,
               l.first_name AS leads_first_name,
               l.last_name AS leads_last_name,
               um.id AS manager_email,               
               um.first_name AS manager_first_name,
               um.last_name AS manager_last_name
        FROM meetings m
        INNER JOIN leads l ON l.id = m.parent_id AND l.deleted=0
        LEFT JOIN users u ON u.id = m.assigned_user_id AND u.deleted=0
        LEFT JOIN users um ON um.id = u.reports_to_id AND um.deleted=0
        WHERE m.deleted = 0
        AND m.status NOT IN ('Held','Completed')
        AND m.parent_type ='Leads'
        AND m.date_entered < '$time12HoursAgo'
    ";

    $resultMeetings = $db->query($queryMeetings);

    while ($row = $db->fetchByAssoc($resultMeetings)) {
        sendEmail($row['sales_email'], $row['manager_email'], $row);        
    }

    // TASKS
    $queryTasks = "
        SELECT t.id, t.name, t.date_entered,t.status,t.parent_id,        
               u.first_name AS salesperson_first_name,
               u.last_name AS salesperson_last_name,
               u.phone_work AS salesperson_phone_work,
               u.phone_mobile AS salesperson_phone_mobile,
               u.phone_home AS salesperson_phone_home,
               u.phone_other AS salesperson_phone_other,
               u.id AS sales_email,
               l.first_name AS leads_first_name,
               l.last_name AS leads_last_name,
               um.id AS manager_email,           
               um.first_name AS manager_first_name,
               um.phone_work AS manager_phone_work,
               um.phone_mobile AS manager_phone_mobile,
               um.phone_home AS manager_phone_home,
               um.phone_other AS manager_phone_other,
               um.last_name AS manager_last_name
        FROM tasks t
        INNER JOIN leads l ON l.id = t.parent_id AND l.deleted=0
        LEFT JOIN users u ON u.id = t.assigned_user_id AND u.deleted=0
        LEFT JOIN users um ON um.id = u.reports_to_id AND um.deleted=0
        WHERE t.deleted = 0
        AND t.status NOT IN ('Completed')
        AND t.parent_type ='Leads'
        AND t.date_entered < '$time12HoursAgo'
    ";

    $resultTasks = $db->query($queryTasks);

    while ($row = $db->fetchByAssoc($resultTasks)) {
        sendEmail($row['sales_email'], $row['manager_email'], $row);
    }




function sendEmail($salesEmail, $managerEmail, $data) {
    require_once('modules/Emails/Email.php');
    require_once('include/SugarPHPMailer.php');

    global $db;    

    
    $sp_phone_number = !empty($data['salesperson_phone_work']) ? $data['salesperson_phone_work'] :
               (!empty($data['salesperson_phone_mobile']) ? $data['salesperson_phone_mobile'] :
               (!empty($data['salesperson_phone_home']) ? $data['salesperson_phone_home'] :
               (!empty($data['salesperson_phone_other']) ? $data['salesperson_phone_other'] : null)));

    $manager_phone_number = !empty($data['manager_phone_work']) ? $data['manager_phone_work'] :
               (!empty($data['manager_phone_mobile']) ? $data['manager_phone_mobile'] :
               (!empty($data['manager_phone_home']) ? $data['manager_phone_home'] :
               (!empty($data['manager_phone_other']) ? $data['manager_phone_other'] : null)));

    $sp_phone_number = !empty($sp_phone_number) ? preg_replace('/[\s\-\(\)]+/', '', $sp_phone_number) : null; 
    $manager_phone_number = !empty($manager_phone_number) ? preg_replace('/[\s\-\(\)]+/', '', $manager_phone_number) : null; 
    $sp_name = (isset($data['salesperson_first_name']) && !empty($data['salesperson_first_name']))?$data['salesperson_first_name'].' '.$data['salesperson_last_name']:'';
    $manager_name = (isset($data['manager_first_name']) && !empty($data['manager_first_name']))?$data['manager_first_name'].' '.$data['manager_last_name']:'';

    $sp_email = getAccountEmail($salesEmail);
    $manager_email = getAccountEmail($managerEmail);

    
    $site_url = rtrim($GLOBALS['sugar_config']['site_url'], '/');
    $lead_url   = $site_url.'/index.php?module=Leads&action=DetailView&record=' . $data['parent_id'];
    //$email_1 = ($sp_phone_number && $lead_phone_number) ? $sp_phone_number.'@13476144062.mysms.ai' : '';

    $clearlyip_did_c=(!empty($current_user->clearlyip_did_c))?$current_user->clearlyip_did_c:'3476144062';
    //$clearlyip_did_c='3476144062';

    $email_1 = ($sp_phone_number)?trim($sp_phone_number).'@'.$clearlyip_did_c.'.mysms.ai' : '';
    $email_2 = ($manager_phone_number)?trim($manager_phone_number).'@'.$clearlyip_did_c.'.mysms.ai' : '';

    $data_sent = 0;

    $emailObj = new Email();
    $defaults = $emailObj->getSystemDefaultEmail();


    $lead_name     = trim($data['leads_first_name'] . ' ' . $data['leads_last_name']);
    $name_task    = !empty($data['name']) ? $data['name'] : 'N/A';
    $status     = !empty($data['status']) ? $data['status'] : 'N/A';
    $date_created     = !empty($data['date_created']) ? date('m/d/Y',strtotime($data['date_created'])) : 'N/A';

    
    //-------------------- EMAIL 1: Salesperson --------------------
    if (!empty($email_1)) {            

        $subject = "Task Reminder - Pending 12+ Hours";
        $body = "Hello {$sp_name},\n\n".
                "Task: {$name_task}\n" .
                "Lead: {$lead_name}\n\n" .
                "This task is still not completed.\n" .
                "Please take necessary action.\n\n" .
                "CRM System";

        $mail = new SugarPHPMailer();
        $mail->setMailerForSystem();
        $mail->IsHTML(false);
        $mail->From = $defaults['email'];
        $mail->FromName = $defaults['name'];
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->prepForOutbound();
        $mail->AddAddress($email_1);

        if ($mail->Send()) {
            $data_sent = 1;
        }
    }
    if (!empty($email_2)) {            
        $subject_2 = "{$name_task} Task Reminder - Pending 12+ Hours";
        $body_2 = "Hello {$manager_name},\n\n".
                "Task: {$name_task}\n" .
                "Lead: {$lead_name}\n" .
                "Sales person: {$sp_name}\n\n" .
                "This task is still not completed.\n" .
                "Please take necessary action.\n\n" .
                "CRM System";

        $mail = new SugarPHPMailer();
        $mail->setMailerForSystem();
        $mail->IsHTML(false);
        $mail->From = $defaults['email'];
        $mail->FromName = $defaults['name'];
        $mail->Subject = $subject_2;
        $mail->Body = $body_2;
        $mail->prepForOutbound();
        $mail->AddAddress($email_2);

        if ($mail->Send()) {
            $data_sent = 1;
        }
    }


    if (!empty($sp_email)) {

        $subject = 'Task Reminder - Pending 12+ Hours';

        $body = "<html>
                <head>
                  <style>
                    body { font-family: Arial, sans-serif; font-size: 14px; color: #333; }
                    .container { padding: 20px; max-width: 600px; margin: auto; }
                    .header { font-size: 18px; font-weight: bold; margin-bottom: 15px; color: #2c3e50; }
                    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
                    table td { padding: 8px 12px; border: 1px solid #ddd; }
                    table tr:nth-child(even) { background-color: #f9f9f9; }
                    .footer { margin-top: 20px; font-size: 12px; color: #888; }
                    .btn { display: inline-block; margin-top: 15px; padding: 10px 20px; 
                           background-color: #2980b9; color: #fff; text-decoration: none; 
                           border-radius: 4px; font-size: 14px; }
                  </style>
                </head>
                <body>
                  <div class='container'>
                    <div class='header'>Task Reminder - Pending 12+ Hours</div>
                    <p>Hello <strong>{$sp_name}</strong>,</p>
                    <p>Task Reminder - Pending 12+ Hours</p>
                    <table>
                      <tr><td><strong>Task</strong></td><td>{$name_task}</td></tr>
                      <tr><td><strong>Lead</strong></td><td><a target='_blank' href='{$lead_url}'>{$lead_name}</a></td></tr>
                    </table>
                    <a class='btn' href='{$lead_url}'>View Lead in CRM</a>
                    <div class='footer'>This task is still not completed.</div>
                  </div>
                </body>
                </html>";

        $mail2 = new SugarPHPMailer();
        $mail2->setMailerForSystem();
        $mail2->IsHTML(true);
        $mail2->From     = $defaults['email'];
        $mail2->FromName = $defaults['name'];
        $mail2->Subject  = $subject;
        $mail2->Body     = $body;
        $mail2->prepForOutbound();
        $mail2->AddAddress($sp_email);

        if ($mail2->Send()) {
            $data_sent = 1;
            $GLOBALS['log']->fatal("Email sent successfully to: " . $sp_email);
        } else {
            $GLOBALS['log']->fatal("Email send FAILED to: " . $sp_email);
        }
    }
    if (!empty($manager_email)) {

        $subject = "{$name_task} Task Reminder - Pending 12+ Hours";

        $body = "<html>
                <head>
                  <style>
                    body { font-family: Arial, sans-serif; font-size: 14px; color: #333; }
                    .container { padding: 20px; max-width: 600px; margin: auto; }
                    .header { font-size: 18px; font-weight: bold; margin-bottom: 15px; color: #2c3e50; }
                    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
                    table td { padding: 8px 12px; border: 1px solid #ddd; }
                    table tr:nth-child(even) { background-color: #f9f9f9; }
                    .footer { margin-top: 20px; font-size: 12px; color: #888; }
                    .btn { display: inline-block; margin-top: 15px; padding: 10px 20px; 
                           background-color: #2980b9; color: #fff; text-decoration: none; 
                           border-radius: 4px; font-size: 14px; }
                  </style>
                </head>
                <body>
                  <div class='container'>
                    <div class='header'>{$name_task} Task Reminder - Pending 12+ Hours</div>
                    <p>Hello <strong>{$manager_name}</strong>,</p>
                    <p>This task is still not completed.</p>
                    <table>
                      <tr><td><strong>Task</strong></td><td>{$name_task}</td></tr>
                      <tr><td><strong>Lead</strong></td><td><a target='_blank' href='{$lead_url}'>{$lead_name}</a></td></tr>
                      <tr><td><strong>Sales Person</strong></td><td>{$sp_name}</td></tr>
                    </table>
                    <a class='btn' href='{$lead_url}'>View Lead in CRM</a>
                    <div class='footer'>This is an automated message from your CRM system.</div>
                  </div>
                </body>
                </html>";

        $mail2 = new SugarPHPMailer();
        $mail2->setMailerForSystem();
        $mail2->IsHTML(true);
        $mail2->From     = $defaults['email'];
        $mail2->FromName = $defaults['name'];
        $mail2->Subject  = $subject;
        $mail2->Body     = $body;
        $mail2->prepForOutbound();
        $mail2->AddAddress($manager_email);

        if ($mail2->Send()) {
            $data_sent = 1;
            $GLOBALS['log']->fatal("Email sent successfully to: " . $sp_email);
        } else {
            $GLOBALS['log']->fatal("Email send FAILED to: " . $sp_email);
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