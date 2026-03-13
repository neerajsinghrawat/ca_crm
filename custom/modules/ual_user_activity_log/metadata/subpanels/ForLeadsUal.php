<?php
$subpanel_layout = array(
    'top_buttons' => array(
        // no create / select buttons
    ),

    'where' => '',

    'list_fields' => array(

        'name' => array(
            'vname' => 'LBL_NAME',
            'width' => '15%',
            'widget_class' => 'SubPanelDetailViewLink',
            'target_record_key' => 'id',
            'target_module' => 'ual_user_activity_log',
            'default' => true,
        ),


        'date_entered' => array(
            'vname' => 'LBL_DATE_ENTERED',
            'width' => '10%',
            'default' => true,
        ),
    ),
);
