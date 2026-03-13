<?php
$subpanel_layout = array(
    'top_buttons' => array(
        // no create / select buttons
    ),

    'where' => '',

    'list_fields' => array(

        'vehicle_c' => array(
            'vname' => 'LBL_VEHICLE_C',
            'width' => '15%',
            'widget_class' => 'SubPanelDetailViewLink',
            'target_record_key' => 'id',
            'target_module' => 'iv_intrested_vehicle',
            'default' => true,
            'customCode' => '{if $VEHICLE_C neq ""}<a href="index.php?module=iv_intrested_vehicle&action=DetailView&record={$ID}">{$VEHICLE_C}</a>{else}<a href="index.php?module=iv_intrested_vehicle&action=DetailView&record={$ID}">{$NAME}</a>{/if}',
        ),

        'interested_year' => array(
            'vname' => 'LBL_INTERESTED_YEAR',
            'width' => '8%',
            'default' => true,
        ),

        'interested_make' => array(
            'vname' => 'LBL_INTERESTED_MAKE',
            'width' => '12%',
            'default' => true,
        ),

        'interested_model' => array(
            'vname' => 'LBL_INTERESTED_MODEL',
            'width' => '12%',
            'default' => true,
        ),

        'form_of_payment' => array(
            'vname' => 'LBL_FORM_OF_PAYMENT',
            'width' => '10%',
            'default' => true,
        ),

        'status' => array(
            'vname' => 'LBL_STATUS',
            'width' => '10%',
            'default' => true,
        ),

        'lead_source' => array(
            'vname' => 'LBL_LEAD_SOURCE',
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
        'todo_btn' => array(
            'vname' => 'ToDo',
            'widget_class' => 'SubPanelTodoButton',
            'width' => '6%',
            'default' => true,
        ),
    ),
);
