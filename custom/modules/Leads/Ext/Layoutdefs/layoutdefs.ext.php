<?php 
 //WARNING: The contents of this file are auto-generated


/*$layout_defs['Leads']['subpanel_setup']['calls'] = array(
    'order' => 30,
    'module' => 'Calls',
    'subpanel_name' => 'default',
    'sort_order' => 'desc',
    'sort_by' => 'date_start',
    'title_key' => 'LBL_CALLS_SUBPANEL_TITLE',
    'get_subpanel_data' => 'function:get_lead_calls',
    'function_parameters' => array(
        'import_function_file' => 'custom/modules/Leads/LeadCallsHelper.php',
    ),
    'top_buttons' => array( 
        //array('widget_class' => 'SubpanelCreates', 'module' => 'Calls'),
    ),
);*/

$layout_defs['Leads']['subpanel_setup']['iv_intrested_vehicle'] = array(
    'order' => 100,
    'module' => 'iv_intrested_vehicle',
    'subpanel_name' => 'ForLeadsIv',
    'sort_by' => 'date_entered',
    'sort_order' => 'desc',
    'title_key' => 'LBL_IV_INTRESTED_VEHICLE_SUBPANEL',
    'get_subpanel_data' => 'iv_intrested_vehicle_link',
    'top_buttons' => array(
        //array('widget_class' => 'SubPanelTopButtonQuickCreate'),
        array('widget_class' => 'SubPanelTopCreateButton'),
    ),
);


$layout_defs['Leads']['subpanel_setup']['ta_trade_appraisal'] = array(
    'order' => 100,
    'module' => 'ta_trade_appraisal',
    'subpanel_name' => 'ForLeads',
    'sort_by' => 'date_entered',
    'sort_order' => 'desc',
    'title_key' => 'LBL_TA_TRADE_APPRAISAL_SUBPANEL',
    'get_subpanel_data' => 'ta_trade_appraisal_link',
    'top_buttons' => array(),
);


$layout_defs['Leads']['subpanel_setup']['ual_user_activity_log'] = array(
    'order' => 100,
    'module' => 'ual_user_activity_log',
    'subpanel_name' => 'ForLeadsUal',
    'sort_by' => 'date_entered',
    'sort_order' => 'desc',
    'title_key' => 'LBL_UAL_SUBPANEL',
    'get_subpanel_data' => 'user_activity_log_link',
    'top_buttons' => array(
        //array('widget_class' => 'SubPanelTopButtonQuickCreate'),
        //array('widget_class' => 'SubPanelTopCreateButton'),
    ),
);

?>