<?php
$hook_version = 1;
$hook_array = array();

$hook_array['before_save'][] = array(
    1,
    'Save Vehicle Photos Upload',
    'custom/modules/ta_trade_appraisal/TradeAppraisalHooks.php',
    'TradeAppraisalHooks',
    'saveVehiclePhotos'
);
$hook_array['after_save'] = Array(); 

$hook_array['after_save'][] = Array(
    2,
    'send email on appraisal',
    'custom/modules/ta_trade_appraisal/TradeAppraisalHooks.php',
    'TradeAppraisalHooks',
    'sendEmailAppraisal'
);

$hook_array['after_save'][] = Array(
    3,
    'Activity Log',
    'custom/modules/activity_global.php',  // file path
    'ActivityGlobal',                      // class
    'track'                                // function
);
