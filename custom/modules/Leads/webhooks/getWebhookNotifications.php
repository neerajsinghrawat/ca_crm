<?php
/**
 * Fetch pending webhook notifications for popup display
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/entryPoint.php');
global $current_user;

header('Content-Type: application/json');

$notificationFile = 'cache/webhook_notifications.json';

// Check if file exists
if (!file_exists($notificationFile)) {
    echo json_encode(['notifications' => []]);
    exit;
}

// Get current user ID
$currentUserId = null;
if (isset($current_user) && !empty($current_user->id)) {
    $currentUserId = $current_user->id;
} 

// If no current user ID, return empty notifications
if (empty($currentUserId)) {
    echo json_encode(['notifications' => []]);
    exit;
}

// Load notifications
$notifications = json_decode(file_get_contents($notificationFile), true) ?: [];

// Find unshown notifications that should show popup
// Only notifications with show_popup = true AND user_id matching current user will be displayed
$pendingNotifications = array_filter($notifications, function($n) use ($currentUserId) {
    // Check if notification should be shown
    // Must not be shown yet AND must have show_popup flag set to true AND user_id must match current user
    $userMatches = isset($n['user_id']) && $n['user_id'] === $currentUserId;
    $shouldShow = !$n['shown'] && isset($n['show_popup']) && $n['show_popup'] === true && $userMatches;
    return $shouldShow;
});

// If there are pending notifications, mark them as shown
if (!empty($pendingNotifications)) {
    foreach ($notifications as &$notification) {
        $userMatches = isset($notification['user_id']) && $notification['user_id'] === $currentUserId;
        if (!$notification['shown'] && isset($notification['show_popup']) && $notification['show_popup'] === true && $userMatches) {
            $notification['shown'] = true;
        }
    }
    file_put_contents($notificationFile, json_encode($notifications, JSON_PRETTY_PRINT));
}

// Return pending notifications
echo json_encode([
    'notifications' => array_values($pendingNotifications)
]);

