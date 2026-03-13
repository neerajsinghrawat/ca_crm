<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

/**
 * Custom subpanel layout for Calls in Activities
 * Added direction field to show Inbound/Outbound status
 */

$subpanel_layout = [
    'where' => "(calls.status != 'Held' AND calls.status != 'Not Held')",
    'list_fields' => [
        'object_image' => [
            'vname' => 'LBL_OBJECT_IMAGE',
            'widget_class' => 'SubPanelIcon',
            'width' => '2%',
        ],
        'name' => [
            'vname' => 'LBL_LIST_SUBJECT',
            'widget_class' => 'SubPanelDetailViewLink',
            'width' => '25%',
        ],
        'direction' => [
            'vname' => 'LBL_DIRECTION',
            'width' => '10%',
        ],
        'status' => [
            'widget_class' => 'SubPanelActivitiesStatusField',
            'vname' => 'LBL_LIST_STATUS',
            'width' => '12%',
        ],
        'date_start' => [
            'vname' => 'LBL_LIST_DUE_DATE',
            'width' => '10%',
        ],
        'assigned_user_name' => [
            'name' => 'assigned_user_name',
            'vname' => 'LBL_LIST_ASSIGNED_TO_NAME',
            'widget_class' => 'SubPanelDetailViewLink',
            'target_record_key' => 'assigned_user_id',
            'target_module' => 'Employees',
            'width' => '10%',
        ],
        'edit_button' => [
            'vname' => 'LBL_EDIT_BUTTON',
            'widget_class' => 'SubPanelEditButton',
            'width' => '2%',
        ],
        'close_button' => [
            'widget_class' => 'SubPanelCloseButton',
            'vname' => 'LBL_LIST_CLOSE',
            'width' => '6%',
            'sortable' => false,
        ],
        'remove_button' => [
            'vname' => 'LBL_REMOVE',
            'widget_class' => 'SubPanelRemoveButton',
            'width' => '2%',
        ],
        'time_start' => [
            'usage' => 'query_only',
        ],
        'recurring_source' => [
            'usage' => 'query_only',
        ],
    ],
];

