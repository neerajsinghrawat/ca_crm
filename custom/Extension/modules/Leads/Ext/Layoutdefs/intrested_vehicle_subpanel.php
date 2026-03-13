<?php
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
