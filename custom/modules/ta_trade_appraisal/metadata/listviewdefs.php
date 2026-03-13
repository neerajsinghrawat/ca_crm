<?php
$listViewDefs['ta_trade_appraisal'] = array(
    'form' => array(
        'buttons' => array(
            'CREATE',
            array(
                'customCode' =>
                    '<input type="button"
                            class="button"
                            value="Send Appraisal"
                            onclick="openSendAppraisalPopup()">'
            ),
        ),
    ),
    'VIN' => array(
        'width' => '15%',
        'label' => 'LBL_VIN',
        'link' => true,
        'default' => true,
    ),

    'LEAD_NAME' => array(
        'width'          => '12%',
        'label'          => 'LBL_LEAD_NAME',
        'default'        => true,
        'link'           => true,
        'relate'         => true,
        'module'         => 'Leads',
        'id'             => 'LEAD_ID',
        'name'           => 'lead_name',
        'rname'          => 'full_name',
        'id_name'        => 'lead_id',
        'related_fields' => array('lead_id'),
    ),
    'VEHICLE_YEAR' => array(
        'width' => '6%',
        'label' => 'LBL_VEHICLE_YEAR',
        'default' => true,
    ),

    'VEHICLE_MAKE' => array(
        'width' => '10%',
        'label' => 'LBL_VEHICLE_MAKE',
        'default' => true,
    ),

    'VEHICLE_MODEL' => array(
        'width' => '10%',
        'label' => 'LBL_VEHICLE_MODEL',
        'default' => true,
    ),

    'MILEAGE' => array(
        'width' => '8%',
        'label' => 'LBL_MILEAGE',
        'default' => true,
    ),

    'VEHICLE_CONDITION' => array(
        'width' => '10%',
        'label' => 'LBL_VEHICLE_CONDITION',
        'default' => true,
    ),

    'HAS_MODIFICATIONS' => array(
        'width' => '8%',
        'label' => 'LBL_HAS_MODIFICATIONS',
        'default' => true,
    ),

    'DATE_ENTERED' => array(
        'width' => '10%',
        'label' => 'LBL_DATE_ENTERED',
        'default' => true,
    ),
);
