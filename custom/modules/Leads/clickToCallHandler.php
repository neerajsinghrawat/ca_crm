<?php
/**
 * Click to Call Handler
 * Entry point for AJAX calls from the Click to Call button
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

// Load ClearlyIP Helper
require_once('custom/modules/Leads/ClearlyIPHelper.php');

// Initialize logger
require_once('include/SugarLogger/LoggerManager.php');
$log = LoggerManager::getLogger();

// Set JSON response header
header('Content-Type: application/json');

// Get POST data
$input = json_decode(file_get_contents('php://input'), true);

// Get lead ID from request (for reference only)
$leadId = isset($input['lead_id']) ? $input['lead_id'] : null;
$leadNumber = isset($input['phone_number']) ? $input['phone_number'] : '';

try {
    // Get current user
    global $current_user;
    if (empty($current_user) || empty($current_user->id)) {
        throw new Exception('User not authenticated. Please log in and try again.');
    }
    
    // Load current user bean to get custom fields
    $userBean = BeanFactory::getBean('Users', $current_user->id);
    if (empty($userBean)) {
        throw new Exception('Unable to load user information.');
    }
    
    // Check global ClearlyIP configuration
    global $sugar_config;
    if (empty($sugar_config['clearlyip']['enabled']) || $sugar_config['clearlyip']['enabled'] != true) {
        throw new Exception('ClearlyIP is not enabled in system configuration. Please contact your administrator.');
    }
    
    // Validate required user-specific ClearlyIP fields
    $missingFields = array();
    if (empty($userBean->clearlyip_username_c)) {
        $missingFields[] = 'Username';
    }
    if (empty($userBean->clearlyip_password_c)) {
        $missingFields[] = 'Password';
    }
    if (empty($userBean->clearlyip_extension_c)) {
        $missingFields[] = 'Extension';
    }
    
    if (!empty($missingFields)) {
        $log->fatal("ClearlyIP: FATAL - User {$current_user->id} missing ClearlyIP configuration: " . implode(', ', $missingFields));
        throw new Exception('Your ClearlyIP configuration is incomplete. Missing: ' . implode(', ', $missingFields) . '. Please add it in your user profile.');
    }
    
    // Initialize ClearlyIP helper with user-specific credentials
    $clearlyIP = new ClearlyIPHelper($userBean->clearlyip_username_c, $userBean->clearlyip_password_c);
    
    // Get access token
    $accessToken = $clearlyIP->getAccessToken();
    
    // Get user details from ClearlyIP API to get user_id and realm_id
    $clearlyIPUser = $clearlyIP->getUserDetails();
    if (empty($clearlyIPUser['id']) || empty($clearlyIPUser['realm_id'])) {
        $missing = array();
        if (empty($clearlyIPUser['id'])) $missing[] = 'id';
        if (empty($clearlyIPUser['realm_id'])) $missing[] = 'realm_id';
        throw new Exception('Unable to retrieve required user details from ClearlyIP. Missing: ' . implode(', ', $missing) . '. Please check your credentials.');
    }
    
    // Use user-specific configuration
    $extension = $userBean->clearlyip_extension_c;
    $userId = $clearlyIPUser['id'];
    $realmId = $clearlyIPUser['realm_id'];
    $callee = preg_replace('/[^0-9+]/', '', $leadNumber);
    
    // Validate phone number
    if (empty($callee)) {
        throw new Exception('Invalid phone number provided.');
    }
    
    // Initiate the call
    $result = $clearlyIP->originateCallback($callee, $extension, $userId, $realmId);
    
    logActivity(
        'leads',   // module
        $leadId,           // record id
        'makecall',             // create/edit
        'phone_number',                  // field
        '',                  // old
        $callee,                  // new
        'Call initiated successfully', //description
        $leadId,//parent_id
        'Leads',//parent_type
        'Call initiated'//name
    );
    // Return success response
    echo json_encode(array(
        'success' => true,
        'message' => 'Call initiated successfully',
        'api_response' => $result
    ));
    
} catch (Exception $e) {
    // Log fatal error
    $log->fatal("ClearlyIP: FATAL EXCEPTION - Call failed: " . $e->getMessage());
    $log->fatal("ClearlyIP: Stack Trace: " . $e->getTraceAsString());
    
    // Return error response
    echo json_encode(array(
        'success' => false,
        'message' => $e->getMessage()
    ));
}
