<?php

$dictionary['Lead']['fields']['user_activity_log_link'] = array(
    'name' => 'user_activity_log_link',
    'type' => 'link',
    'relationship' => 'leads_user_activity_log',
    'source' => 'non-db',
    'module' => 'ual_user_activity_log',
    'bean_name' => 'ual_user_activity_log',
    'vname' => 'LBL_USER_ACTIVITY_LOG',
);

$dictionary['Lead']['relationships']['leads_user_activity_log'] = array(
    'lhs_module' => 'Leads',
    'lhs_table' => 'leads',
    'lhs_key' => 'id',

    'rhs_module' => 'ual_user_activity_log',
    'rhs_table' => 'ual_user_activity_log',
    'rhs_key' => 'parent_id',

    'relationship_type' => 'one-to-many',
);
