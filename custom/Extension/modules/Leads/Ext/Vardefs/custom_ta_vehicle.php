<?php

$dictionary['Lead']['fields']['vin'] = array(
    'name' => 'vin',
    'vname' => 'LBL_VIN',
    'type' => 'varchar',
    'len' => '100',
    'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
);


$dictionary['Lead']['fields']['appraisal_vehicle_model'] = array(
    'name' => 'appraisal_vehicle_model',
    'vname' => 'LBL_VEHICLE_MODEL',
    'type' => 'varchar',
    'len' => '100',
    'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
);
$dictionary['Lead']['fields']['appraisal_vehicle_engine'] = array(
    'name' => 'appraisal_vehicle_engine',
    'vname' => 'LBL_VEHICLE_ENGINE',
    'type' => 'varchar',
    'len' => '100',
    'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
);
$dictionary['Lead']['fields']['appraisal_vehicle_state'] = array(
    'name' => 'appraisal_vehicle_state',
    'vname' => 'LBL_VEHICLE_STATE',
    'type' => 'varchar',
    'len' => '100',
    'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
);
$dictionary['Lead']['fields']['appraisal_has_payoff'] = array(
    'name' => 'appraisal_has_payoff',
    'vname' => 'LBL_HAS_PAYOFF',
    'type' => 'bool',
    'default' => '0',
    'audited' => true,
    'reportable' => true,
    'studio' => 'visible',
);
$dictionary['Lead']['fields']['appraisal_payoff_amount'] = array(
    'name' => 'appraisal_payoff_amount',
    'vname' => 'LBL_PAYOFF_AMOUNT',
    'type' => 'varchar',
    'len' => '100',
    'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
);
$dictionary['Lead']['fields']['appraisal_appraisal_comment'] = array(
    'name' => 'appraisal_appraisal_comment',
    'vname' => 'LBL_APPRAISAL_COMMENT',
    'type' => 'text',          // LONGTEXT ke liye
    'rows' => 6,
    'cols' => 80,
    'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
);
$dictionary['Lead']['fields']['appraisal_vehicle_photos'] = array(
    'name' => 'appraisal_vehicle_photos',
    'vname' => 'LBL_VEHICLE_PHOTOS',
    'type' => 'text',          // LONGTEXT ke liye
    'rows' => 6,
    'cols' => 80,
    'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
);

$dictionary['Lead']['fields']['appraisal_mileage'] = array(
    'name' => 'appraisal_mileage',
    'vname' => 'LBL_MILEAGE',
    'type' => 'varchar',
    'len' => '100',
    'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
);
$dictionary['Lead']['fields']['appraisal_value'] = array(
    'name' => 'appraisal_value',
    'vname' => 'LBL_APPRAISAL_VALUE',
    'type' => 'varchar',
    'len' => '255',
    'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
);

$dictionary['Lead']['fields']['appraisal_vehicle_condition'] = array(
    'name' => 'appraisal_vehicle_condition',
    'vname' => 'LBL_VEHICLE_CONDITION',
    'type' => 'enum',
    'options' => 'vehicle_condition_list',
    'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'studio' => 'visible',
);

$dictionary['Lead']['fields']['appraisal_has_modifications'] = array(
    'name' => 'appraisal_has_modifications',
    'vname' => 'LBL_HAS_MODIFICATIONS',
    'type' => 'bool',
    'default' => '0',
    'audited' => true,
    'reportable' => true,
    'studio' => 'visible',
);
$dictionary['Lead']['fields']['appraisal_modification_details'] = array(
    'name' => 'appraisal_modification_details',
    'vname' => 'LBL_MODIFICATION_DETAILS',
    'type' => 'text',
    'rows' => 4,
    'cols' => 80,
    'audited' => true,
    'reportable' => true,
    'studio' => 'visible',
);