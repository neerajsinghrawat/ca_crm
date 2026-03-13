<?php


$dictionary['ual_user_activity_log']['fields']['module_name'] = array(
    'name' => 'module_name',
    'vname' => 'LBL_MODULE',
    'type' => 'varchar',
    'len' => 100,
);

$dictionary['ual_user_activity_log']['fields']['action'] = array(
    'name' => 'action',
    'vname' => 'LBL_ACTION',
    'type' => 'varchar',
    'len' => 100,
);
$dictionary['ual_user_activity_log']['fields']['parent_type'] = array(
    'name' => 'parent_type',
    'vname' => 'LBL_PARENT_TYPE',
    'type' => 'varchar',
    'len' => 100,
);
$dictionary['ual_user_activity_log']['fields']['activity_type'] = array(
    'name' => 'activity_type',
    'vname' => 'LBL_ACTIVITY_TYPE',
    'type' => 'varchar',
    'len' => 100,
);

$dictionary['ual_user_activity_log']['fields']['user_id_c'] = array(
    'name' => 'user_id_c',
    'vname' => 'LBL_USER_ID_C',
    'type' => 'id',
    'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => false,
    'unified_search' => false,
    'merge_filter' => 'disabled',
);
$dictionary['ual_user_activity_log']['fields']['parent_id'] = array(
    'name' => 'parent_id',
    'vname' => 'LBL_PARENT_ID',
    'type' => 'id',
    'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => false,
    'unified_search' => false,
    'merge_filter' => 'disabled',
);
$dictionary['ual_user_activity_log']['fields']['record_id'] = array(
    'name' => 'record_id',
    'vname' => 'LBL_RECORD_ID',
    'type' => 'id',
    'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => false,
    'unified_search' => false,
    'merge_filter' => 'disabled',
);

// ===== Interested Vehicle =====
$dictionary['ual_user_activity_log']['fields']['field_name'] = array(
    'name' => 'field_name',
    'vname' => 'LBL_FIELD_NAME',
    'type' => 'varchar',
    'len' => 100,
);

$dictionary['ual_user_activity_log']['fields']['old_value'] = array(
    'name' => 'old_value',
    'vname' => 'LBL_OLD_VALUE',
    'type' => 'text',
    'audited' => false,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
    'required' => false,
    'dbType' => 'longtext',
    'comment' => '',
);

$dictionary['ual_user_activity_log']['fields']['new_value'] = array(
    'name' => 'new_value',
    'vname' => 'LBL_NEW_VALUE',
    'type' => 'text',
    'audited' => false,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
    'required' => false,
    'dbType' => 'longtext', 
    'comment' => '',
);

