<?php
$hook_version = 1; 
$hook_array = Array(); 

$hook_array['before_save'] = Array(); 

$hook_array['before_save'][] = Array(
    1,
    'save product name in name field',
    'custom/modules/iv_intrested_vehicle/LogicHooks/saveName.php',
    'ProductNameSaveName',
    'saveName'
);


$hook_array['after_save'][] = Array(
    2,
    'Activity Log',
    'custom/modules/activity_global.php',  // file path
    'ActivityGlobal',                      // class
    'track'                                // function
);


$hook_array['after_save'][] = [
    3,
    'Send Slack notification when intrested_vehicle insert',
    'custom/modules/iv_intrested_vehicle/LogicHooks/SlackinsertIvHook.php',
    'SlackIntrestedVehicleHook',
    'sendIntrestedVehicleNotification'
];
?>
