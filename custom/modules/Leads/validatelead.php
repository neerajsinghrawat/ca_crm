<?php

global $db;

$stock_number = isset($_REQUEST['stock_number']) ? $db->quote($_REQUEST['stock_number']) : '';
$record_id    = isset($_REQUEST['record_id']) ? $db->quote($_REQUEST['record_id']) : '';

$response = ['duplicate' => false];

if (!empty($stock_number)) {
    $query = "SELECT id FROM leads
              WHERE stock_number = '{$stock_number}'
              AND deleted = 0
              AND id != '{$record_id}' LIMIT 1";
    $result = $db->query($query);
    //echo "<pre>";print_r($query);die;
    if ($row = $db->fetchByAssoc($result)) {
        $response['duplicate'] = true;
    }
}

//header('Content-Type: application/json');
echo json_encode($response);
exit;
