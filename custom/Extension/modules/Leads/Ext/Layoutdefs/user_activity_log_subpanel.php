<?php
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
