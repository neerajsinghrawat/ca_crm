<?php
$viewdefs['ta_trade_appraisal']['DetailView'] = array(
    'templateMeta' => array(
        'maxColumns' => '2',
        'widths' => array(
            array('label' => '10', 'field' => '30'),
            array('label' => '10', 'field' => '30'),
        ),
    ),

    'panels' => array(
        'lbl_appraisal_information' => array(

            array('vin', 'vehicle_year'),
            array('vehicle_make', 'vehicle_model'),
            array('vehicle_state'),

            array('mileage', 'vehicle_condition'),
            array('has_modifications', 'modification_details'),

            array('has_payoff', 'payoff_amount'),
            array('carfax_link', 'phone_number'),

            array('lead_name', 'date_entered'),
            array('appraisal_value',array(
        'name' => 'date_modified',
        'label' => 'LBL_DATE_MODIFIED',
        'customCode' => '{$fields.date_modified.value} &nbsp; {$fields.modified_by_name.value}',
    )),
            array('appraisal_comment'),

            array(
                array(
                    'name' => 'vehicle_photos',
                    'label' => 'LBL_VEHICLE_PHOTOS',
                    'inline_edit' => false,
                    'customCode' => '{$VEHICLE_PHOTOS_HTML}',
                ),
            ),
        ),
    ),
);
