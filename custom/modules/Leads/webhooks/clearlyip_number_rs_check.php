<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/entryPoint.php');
require_once('custom/include/custom_utils.php');
global $db, $timedate, $log;

// ===== POPUP FILTER CONFIGURATION =====
// Popup notifications will be shown ONLY for incoming calls with "ringing" status
// where the "from" number matches a lead's phone number (mobile, work, home, or other) in the database
// ======================================
$rawPhone = (isset($_GET['phone']))?$_GET['phone']:'7183147808';
try {

    $apiResponse = sendPhoneToProxy($rawPhone);
    echo "<pre>apiResponse";print_r($apiResponse);
    $apiResponse = json_decode($apiResponse, true);
    echo "<pre>apiResponse";print_r($apiResponse);die;
}catch (Exception $e) {
    $log->fatal('ClearlyIP Webhook: FATAL EXCEPTION - ' . $e->getMessage());
    $log->fatal('ClearlyIP Webhook: Stack Trace - ' . $e->getTraceAsString());
    
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Internal server error'
    ], JSON_PRETTY_PRINT); 
}