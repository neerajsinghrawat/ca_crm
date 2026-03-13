<?php

function sendPhoneToProxy($phone)
{
    $url = "http://129.212.197.53:5000/";
    $data = ["phonenumber" => $phone];
    $payload = json_encode($data);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($payload)
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    
    curl_close($ch);
    return $response; 
}

function createTaskFromMessageAPI($leadId, $message)
{
    $url = "https://leadgen.iconsolutions360.com/api/tasks/create-from-message";

    $payload = json_encode([
        "leadId"   => $leadId,
        "message"  => $message
    ]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Accept: application/json"
    ]);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

    // Optional: if SSL issue in local testing
    // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    $response = curl_exec($ch);
    $error    = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    return [
        "success"   => ($httpCode >= 200 && $httpCode < 300),
        "httpCode"  => $httpCode,
        "response"  => $response,
        "error"     => $error
    ];
}

function findLeadByPhoneNew($db, $phone)
{
    if (empty($phone)) return null;
    $phone = getLast10Digit($phone);
    $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
    if (empty($cleanPhone)) return null;

    $phoneNumber = $db->quote($cleanPhone);

    /*$query = "SELECT id
              FROM leads
              WHERE deleted = 0
              AND (
                  REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(phone_mobile, '(', ''), ')', ''), '-', ''), ' ', ''), '+', '') = $phoneNumber OR
                  REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(phone_work, '(', ''), ')', ''), '-', ''), ' ', ''), '+', '') = $phoneNumber OR
                  REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(phone_home, '(', ''), ')', ''), '-', ''), ' ', ''), '+', '') = $phoneNumber OR
                  REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(phone_other, '(', ''), ')', ''), '-', ''), ' ', ''), '+', '') = $phoneNumber
              )
              LIMIT 1";*/
    $query = "SELECT id, first_name, last_name,
          phone_mobile, phone_work, phone_home, phone_other
          FROM leads 
          WHERE deleted = 0 
          AND (
              RIGHT(REGEXP_REPLACE(phone_mobile, '[^0-9]', ''), 10) = $phoneNumber
              OR RIGHT(REGEXP_REPLACE(phone_work, '[^0-9]', ''), 10) = $phoneNumber
              OR RIGHT(REGEXP_REPLACE(phone_home, '[^0-9]', ''), 10) = $phoneNumber
              OR RIGHT(REGEXP_REPLACE(phone_other, '[^0-9]', ''), 10) = $phoneNumber
          ) LIMIT 1";


    $res = $db->query($query);

    if ($res && $row = $db->fetchByAssoc($res)) {
        return $row['id'];
    }

    return null;
}

// ✅ Email se lead find
function findLeadByEmailNew($db, $email)
{
    if (empty($email)) return null;

    $email = trim(strtolower($email));
    if (empty($email)) return null;

    $emailCaps = strtoupper($email);
    $emailQuoted = $db->quote($emailCaps);

    $query = "SELECT eabr.bean_id AS id
              FROM email_addresses ea
              INNER JOIN email_addr_bean_rel eabr ON eabr.email_address_id = ea.id
              WHERE ea.deleted = 0
              AND eabr.deleted = 0
              AND eabr.bean_module = 'Leads'
              AND ea.email_address_caps = '{$emailQuoted}'
              LIMIT 1";
              //echo "<pre>query==>";print_r($query);
    $res = $db->query($query);

    if ($res && $row = $db->fetchByAssoc($res)) {
        return $row['id'];
    }

    return null;
}
function custom_get_user_array_for_dropdown($bean = null, $field = '', $value = '', $view = '')
{
    return get_user_array(false);
}

function logActivity($module,$record_id,$action,$field='',$old='',$new='',$desc='',$parent_id='',$parent_type='',$name='')
{
    global $current_user;
    // Bean load
    $bean = BeanFactory::newBean('ual_user_activity_log');

    $bean->name = $name; // display name
    $bean->module_name = $module;
    $bean->record_id = $record_id;
    $bean->action = $action;
    $bean->field_name = $field;
    $bean->old_value = $old;
    $bean->new_value = $new;
    $bean->description = $desc;
    $bean->parent_id = $parent_id;
    $bean->parent_type = $parent_type;

    $bean->user_id_c = $current_user->id;

    $bean->save();
}
function getLast10Digit($number)
{
    if(empty($number)) return false;

    // remove all non numeric
    $number = preg_replace('/[^0-9]/', '', $number);

    // get last 10 digit
    $last10 = substr($number, -10);

    if(strlen($last10) == 10){
        return $last10;
    }

    return false;
}