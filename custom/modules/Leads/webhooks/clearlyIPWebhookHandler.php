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

try {
    // Get POST data
    $rawData = file_get_contents('php://input');
    $webhookData = json_decode($rawData, true);
    $log->fatal('ClearlyIP Webhook===>New TEst++==>: '.print_r($webhookData,true));
    if (!$webhookData || empty($webhookData['id'])) {
        $log->fatal('ClearlyIP Webhook: FATAL ERROR - Invalid or empty webhook data');
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Invalid webhook data']);
        exit;
    }

    // Extract ClearlyIP fields
    $callId = $webhookData['id'];
    $threadId = $webhookData['thread_id'] ?? '';
    $subtype = $webhookData['subtype'] ?? $webhookData['sub_type'] ?? '';
    $type = $webhookData['type'] ?? '';
    $from = $webhookData['from'] ?? '';
    $to = $webhookData['to'] ?? '';
    $fromName = $webhookData['from_name'] ?? '';
    $toName = $webhookData['to_name'] ?? '';
    $addresses = '';
    $city = '';
    $state = '';
    $zip = '';
    $timestamp = $webhookData['timestamp'] ?? null;

    // Fetch user ID by matching $to with clearlyip_extension_c or clearlyip_did_c
    $user_id = null;
    if (!empty($to)) {
        // Clean the $to value (strip formatting, keep only digits)
        $cleanTo = preg_replace('/[^0-9]/', '', $to);
        $toValue = $db->quote($cleanTo);
        
        $userQuery = "SELECT id 
                      FROM users 
                      WHERE deleted = 0 
                      AND (
                          REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(clearlyip_extension_c, '(', ''), ')', ''), '-', ''), ' ', ''), '+', '') = $toValue OR 
                          REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(clearlyip_did_c, '(', ''), ')', ''), '-', ''), ' ', ''), '+', '') = $toValue
                      )
                      LIMIT 1";
        
        $userResult = $db->query($userQuery);
        if ($userResult && $userRow = $db->fetchByAssoc($userResult)) {
            $user_id = $userRow['id'];
        } else {
            $log->fatal('ClearlyIP Webhook: No user found matching to number: ' . $to);
        }
    }

    // Find or create Call record
    $call = BeanFactory::newBean('Calls');
    $existingCallId = null;
    
    if ($threadId) {
        $query = "SELECT id FROM calls 
                  WHERE clearlyip_call_id = " . $db->quoted($threadId) . " 
                  AND deleted = 0 LIMIT 1";
        $result = $db->query($query);
        if ($result && $row = $db->fetchByAssoc($result)) {
            $existingCallId = $row['id'];
        }
    }
    
    if ($existingCallId) {
        $call = BeanFactory::getBean('Calls', $existingCallId);
    }
    
    $isNewCall = empty($call->id);
    
    // Check if this is an incoming call with ringing status (for popup notifications)
    $isIncomingRinging = ($type === 'incoming_call' && (strtolower($subtype) === 'ringing' || strtolower($subtype) === 'missed'));
    
    // Search for matching leads by phone number (can be multiple)
    // For incoming calls, search by "from", for outgoing calls, search by "to"
    $searchPhone = ($type === 'incoming_call') ? $from : $to;
    $shouldShowPopup = false;
    $matchedLeads = [];
    $leadIds = [];
    
    $searchPhonenew = $searchPhone;
    $searchPhone = getLast10Digit($searchPhone);
    
    if (!empty($searchPhone)) {
        // Strip all formatting characters from phone number (keep only digits)
        $cleanPhone = preg_replace('/[^0-9]/', '', $searchPhone);
        
        $phoneNumber = $db->quote($cleanPhone);
        
        // Get detailed lead information (for notifications and call linking)
        $query = "SELECT id, first_name, last_name,
          phone_mobile, phone_work, phone_home, phone_other
          FROM leads 
          WHERE deleted = 0 
          AND (
              RIGHT(REGEXP_REPLACE(phone_mobile, '[^0-9]', ''), 10) = $phoneNumber
              OR RIGHT(REGEXP_REPLACE(phone_work, '[^0-9]', ''), 10) = $phoneNumber
              OR RIGHT(REGEXP_REPLACE(phone_home, '[^0-9]', ''), 10) = $phoneNumber
              OR RIGHT(REGEXP_REPLACE(phone_other, '[^0-9]', ''), 10) = $phoneNumber
          )";

        
        $result = $db->query($query);
        
        if ($result) {
            $leadCount = 0;
            while ($row = $db->fetchByAssoc($result)) {
                $leadCount++;
                $leadIds[] = $row['id'];
                
                // Only build matchedLeads array if this is an incoming ringing call (for notifications)
                if ($isIncomingRinging) {
                    $matchedLeads[] = [
                        'id' => $row['id'],
                        'first_name' => $row['first_name'],
                        'last_name' => $row['last_name'],
                        'full_name' => trim($row['first_name'] . ' ' . $row['last_name']),
                        'phone' => $row['phone_mobile'] ?? $row['phone_work'] ?? $row['phone_home'] ?? $row['phone_other'] ?? null,
                        'addresses' => '',
                        'is_new' => false,
                    ];
                }
            }
            
            // If no leads found and this is an incoming ringing call, create a "New Lead" entry for notifications
            if ($leadCount === 0 && $isIncomingRinging) {

                



                /*$lead = BeanFactory::newBean('Leads');
                $lead->first_name =(!empty($firstName))?$firstName:$fullName;
                $lead->last_name = $lastName;
                $lead->phone_mobile = $searchPhone;
                $lead->primary_address_street = $addresses;
                $lead->primary_address_city = $city;
                $lead->primary_address_state = $state;
                $lead->primary_address_postalcode = $zip;
                $lead->assigned_user_id = 1;
                $lead->lead_source = 'Cold Call';
                $lead->save();*/

                $cleanPhone_new = preg_replace('/[^0-9]/', '', $searchPhone);
                $phoneNumber_new = $db->quote($cleanPhone_new);

                /*$query_new = "
                    SELECT COUNT(*) AS total_leads
                    FROM leads
                    WHERE deleted = 0
                    AND (
                        REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(phone_mobile, '(', ''), ')', ''), '-', ''), ' ', ''), '+', '') = $phoneNumber_new OR
                        REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(phone_work, '(', ''), ')', ''), '-', ''), ' ', ''), '+', '') = $phoneNumber_new OR
                        REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(phone_home, '(', ''), ')', ''), '-', ''), ' ', ''), '+', '') = $phoneNumber_new OR
                        REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(phone_other, '(', ''), ')', ''), '-', ''), ' ', ''), '+', '') = $phoneNumber_new
                    )
                ";*/
                 $query_new = "SELECT COUNT(*) AS total_leads
                  FROM leads 
                  WHERE deleted = 0 
                  AND (
                      RIGHT(REGEXP_REPLACE(phone_mobile, '[^0-9]', ''), 10) = $phoneNumber_new
                      OR RIGHT(REGEXP_REPLACE(phone_work, '[^0-9]', ''), 10) = $phoneNumber_new
                      OR RIGHT(REGEXP_REPLACE(phone_home, '[^0-9]', ''), 10) = $phoneNumber_new
                      OR RIGHT(REGEXP_REPLACE(phone_other, '[^0-9]', ''), 10) = $phoneNumber_new
                  )";

                $result_new = $db->query($query_new);
                $row_new = $db->fetchByAssoc($result_new);
                if (isset($row_new['total_leads']) && $row_new['total_leads'] > 0) {
                    // code...
                }else{
                    $apiResponse = sendPhoneToProxy($searchPhonenew);
                    $apiResponse = json_decode($apiResponse, true);
                    if (!empty($apiResponse) && isset($apiResponse['names'][0]) && !empty($apiResponse['names'][0])) {
                        
                        $firstName = $apiResponse['names'][0]['first'] ?? null;
                        $lastName  = $apiResponse['names'][0]['last'] ?? null;
                        $fullName  = $apiResponse['names'][0]['data'] ?? $fromName;
                        if (isset($apiResponse['addresses'][0]) && !empty($apiResponse['addresses'][0])) {
                            $addresses  = $apiResponse['addresses'][0]['data'] ?? null;
                            $city  = $apiResponse['addresses'][0]['city'] ?? null;
                            $state  = $apiResponse['addresses'][0]['state'] ?? null;
                            $zip  = $apiResponse['addresses'][0]['zip'] ?? null;
                            $log->fatal('ClearlyIP Webhook: addresses is coming');
                        }

                    }else{
                        $log->fatal('ClearlyIP Webhook: addresses is not coming');
                        $firstName = null;
                        $lastName  = null;
                        $fullName  = $fromName;

                    }
                    $firstNameFinal = !empty($firstName) ? $firstName : $fullName;
                    $db->query("INSERT INTO leads (id, first_name, last_name, phone_mobile, primary_address_street, primary_address_city, primary_address_state, primary_address_postalcode, assigned_user_id, lead_source, date_entered, date_modified, created_by, modified_user_id, deleted, category_c) VALUES (UUID(), '$firstNameFinal', '$lastName', '$searchPhone', '$addresses', '$city', '$state', '$zip', '1', 'Cold Call', NOW(), NOW(), '1', '1', 0, 'Spam')"); 
                }
                


                $matchedLeads[] = [
                    'id' => null,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'full_name' => $fullName,
                    'phone' => $searchPhone,
                    'addresses' => $addresses,
                    'is_new' => true,
                ];
            }
            // Only show popup for incoming calls with ringing status
            if ($isIncomingRinging) {
                $shouldShowPopup = true;
            }
        }
    }

    if ($isNewCall) {
        if (strtolower($subtype) === 'answered') {

            $call->clearlyip_call_id = $threadId; // Store thread_id as it's consistent across webhook events
            $call->direction = ($type === 'incoming_call') ? 'Inbound' : 'Outbound';
            $call->name = ($type === 'incoming_call') ? 'Incoming Call from ' . ($fromName .'('.$from.')'?: $from) : 'Outgoing Call to ' . ($toName ?: $to);
            //echo "<pre>";print_r($call->name);die;
             
            if ($timestamp) {
                try {
                    $dateTime = new DateTime($timestamp);
                    $call->date_start = $dateTime->format('Y-m-d H:i:s');
                } catch (Exception $e) {
                    $call->date_start = $timedate->nowDb();
                }
            } else {
                $call->date_start = $timedate->nowDb();
            }

            // Assign user - prefer matched user_id, then current_user, then fallback
            if (!empty($user_id)) {
                $call->assigned_user_id = $user_id;
            } else {
                global $current_user;
                if (!empty($current_user->id)) {
                    $call->assigned_user_id = $current_user->id;
                }
            }
            
            // Set Related To Lead if we found matching leads (use first lead as parent)
            if (!empty($leadIds) && count($leadIds) > 0) {
                $call->parent_type = 'Leads';
            }
            // code...
        }
    }
    // Set status
    $statusMap = [
        'ringing' => 'Ringing',
        'answered' => 'Answered',
        'ended' => 'Ended',
        'missed' => 'no answer',
        'rejected' => 'Rejected',
        'busy' => 'Busy',
        'invalid' => 'Invalid',
        'blocked' => 'Blocked',
        'not_available' => 'no answer',
        'notavailable' => 'no answer',
        'no_answer' => 'no answer',
    ];
    if (strtolower($subtype) === 'answered') {

        $call->status = $statusMap[strtolower($subtype)] ?? 'Invalid';
            
        $call->description = "";
        $call->duration_hours = 0;
        $call->duration_minutes = 0;
        

        $call->save(false);

        // Link to all matching Leads
        if (!empty($leadIds) && $call->id) {
            $call->load_relationship('leads');
            $existingLeads = $call->leads->get();
            foreach ($leadIds as $leadId) {
                if (!in_array($leadId, $existingLeads)) {
                    $call->leads->add($leadId);
                }
            }
        }
    }

    // Store for popup notification - ONLY for incoming calls with ringing status
    if ($isIncomingRinging) {
        $notificationFile = 'cache/webhook_notifications.json';
        $notifications = [];
        
        if (file_exists($notificationFile)) {
            $notifications = json_decode(file_get_contents($notificationFile), true) ?: [];
        }
        
        // Add new notification
        $notifications[] = [
            'id' => uniqid(),
            'timestamp' => date('Y-m-d H:i:s'),
            'call_id' => $callId,
            'thread_id' => $threadId,
            'from' => $from,
            'to' => $to,
            'from_name' => $fromName,
            'to_name' => $toName,
            'type' => $type,
            'subtype' => $subtype,
            'event_timestamp' => $timestamp,
            'data' => $webhookData,
            'shown' => false,
            'show_popup' => $shouldShowPopup,  
            'matched_leads' => $matchedLeads,
            'user_id' => $user_id,
            'sugar_call_id' => $call->id ?? null
        ];  

        /*echo "<pre>notifications===>";print_r($matchedLeads);
        echo "<pre>notifications";print_r($notifications);die;*/
        // Keep only last 50
        if (count($notifications) > 50) {
            $notifications = array_slice($notifications, -50);
        }
        
        file_put_contents($notificationFile, json_encode($notifications, JSON_PRETTY_PRINT));
        
    }

    // Success response
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'success',
        'message' => 'Webhook received',
        'call_id' => $call->id ?? null,
        'lead_ids' => $leadIds,
        'lead_count' => count($leadIds),
        'user_id' => $user_id,
        'show_popup' => $shouldShowPopup
    ]);

} catch (Exception $e) {
    $log->fatal('ClearlyIP Webhook: FATAL EXCEPTION - ' . $e->getMessage());
    $log->fatal('ClearlyIP Webhook: Stack Trace - ' . $e->getTraceAsString());
    
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Internal server error'
    ], JSON_PRETTY_PRINT);
}
