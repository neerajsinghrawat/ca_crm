<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 

 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['before_save'] = Array(); 

$hook_array['before_save'][] = Array(1, 'Leads push feed', 'modules/Leads/SugarFeeds/LeadFeed.php','LeadFeed', 'pushFeed'); 
$hook_array['before_save'][] = Array(79, 'duplicate number', 'custom/modules/Leads/LogicHooks/leadDuplicate.php','leadDuplicateclass', 'leadDuplicatemethod');

$hook_array['before_save'][] = Array(77, 'updateGeocodeInfo', 'modules/Leads/LeadsJjwg_MapsLogicHook.php','LeadsJjwg_MapsLogicHook', 'updateGeocodeInfo'); 

$hook_array['before_save'][] = array(
    11,
    'Mark lead as new on create',
    'custom/modules/Leads/SetNewLead.php',
    'SetNewLead',
    'markNew',
);

$hook_array['after_save'] = Array(); 

$hook_array['after_save'][] = Array(
    2,
    'Round Robin Lead Assignment',
    'custom/modules/Leads/leadassignmenthook.php',
    'LeadAssignmentHook',
    'assignLeadRoundRobin'
);

$hook_array['after_save'][] = Array(
    88,
    'create trade in ',
    'custom/modules/Leads/LogicHooks/savetradein.php',
    'SaveTradein',
    'saveDataAppraisal'
);
$hook_array['after_save'][] = Array(
    22,
    'Send sms for sms on',
    'custom/modules/Leads/sendsmson.php',
    'LeadSendSmsService',
    'onSmsService'
);
$hook_array['after_save'][] = Array(7, 'updateRelatedMeetingsGeocodeInfo', 'modules/Leads/LeadsJjwg_MapsLogicHook.php','LeadsJjwg_MapsLogicHook', 'updateRelatedMeetingsGeocodeInfo'); 
$hook_array['after_save'][] = Array(
    77,
    'Create Quote after Lead Conversion',
    'custom/modules/Leads/leadtoquotehook.php',
    'LeadToQuoteHook',
    'createQuote'
);
$hook_array['after_retrieve'][] = array(
    25,
    'Remove NEW when opened',
    'custom/modules/Leads/SetNewLead.php',
    'SetNewLead',
    'removeNewOnView',
);



$hook_array['after_save'][] = [
    1,
    'Send Slack notification when Lead assigned',
    'custom/modules/Leads/SlackLeadHook.php',
    'SlackLeadHook',
    'sendLeadAssignedNotification'
];

?>