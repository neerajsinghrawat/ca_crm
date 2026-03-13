<?php

$dictionary['Task']['fields']['task_subject_dd_c'] = array(
    'name' => 'task_subject_dd_c',
    'vname' => 'LBL_TASK_SUBJECT_DD',
    'type' => 'enum',
    'options' => 'task_subject_dd_list',
    'len' => 100,
    'audited' => true,
    'reportable' => true,
    'massupdate' => 0,
    'importable' => true,
    'duplicate_merge' => 'enabled',
    'merge_filter' => 'enabled',
);
$dictionary['Task']['fields']['task_type'] = array(
    'name' => 'task_type',
    'vname' => 'LBL_TASK_TYPE',
    'type' => 'enum',
    'options' => 'task_type_list',
    'len' => 100,
    'audited' => true,
    'reportable' => true,
    'massupdate' => 0,
    'importable' => true,
    'duplicate_merge' => 'enabled',
    'merge_filter' => 'enabled',
);

$dictionary['Task']['fields']['assigned_user_dropdown_c'] = array(
  'name' => 'assigned_user_dropdown_c',
  'vname' => 'LBL_ASSIGNED_USER_DROPDOWN',
  'type' => 'enum',
  'len' => 36,
  'function' => array(    
    'name' => 'custom_get_user_array_for_dropdown',
    'include' => 'custom/include/custom_utils.php',
  ),
);

