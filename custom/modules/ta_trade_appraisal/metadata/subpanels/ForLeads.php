<?php
$subpanel_layout = array(
    'top_buttons' => array(
        // no create / select buttons
    ),

    'where' => '',

    'list_fields' => array(

        'vin' => array(
            'vname' => 'LBL_VIN',
            'width' => '15%',
            'widget_class' => 'SubPanelDetailViewLink',
            'target_record_key' => 'id',
            'target_module' => 'ta_trade_appraisal',
            'default' => true,
        ),

        'vehicle_year' => array(
            'vname' => 'LBL_VEHICLE_YEAR',
            'width' => '8%',
            'default' => true,
        ),

        'vehicle_make' => array(
            'vname' => 'LBL_VEHICLE_MAKE',
            'width' => '12%',
            'default' => true,
        ),

        'vehicle_model' => array(
            'vname' => 'LBL_VEHICLE_MODEL',
            'width' => '12%',
            'default' => true,
        ),

        'mileage' => array(
            'vname' => 'LBL_MILEAGE',
            'width' => '10%',
            'default' => true,
        ),

        'vehicle_condition' => array(
            'vname' => 'LBL_VEHICLE_CONDITION',
            'width' => '10%',
            'default' => true,
        ),

        'date_entered' => array(
            'vname' => 'LBL_DATE_ENTERED',
            'width' => '10%',
            'default' => true,
        ),

        'edit_button' => array(
            'widget_class' => 'SubPanelEditButton',
            'width' => '4%',
            'default' => true,
        ),

        'remove_button' => array(
            'widget_class' => 'SubPanelRemoveButton',
            'width' => '4%',
            'default' => true,
        ),
    ),
);
