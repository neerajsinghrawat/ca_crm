<?php
// Custom fields for Leads

$dictionary['iv_intrested_vehicle']['fields']['dealership_c'] = array(
    'name' => 'dealership_c',
    'vname' => 'LBL_DEALERSHIP',
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

$dictionary['iv_intrested_vehicle']['fields']['received_date_c'] = array(
    'name' => 'received_date_c',
    'vname' => 'LBL_RECEIVED_DATE',
    'type' => 'datetime',
    'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
);

$dictionary['iv_intrested_vehicle']['fields']['duration_c'] = array(
    'name' => 'duration_c',
    'vname' => 'LBL_DURATION',
    'type' => 'varchar',
    'len' => '50',
    'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
);

$dictionary['iv_intrested_vehicle']['fields']['callerid_c'] = array(
    'name' => 'callerid_c',
    'vname' => 'LBL_CALLERID',
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
$dictionary['iv_intrested_vehicle']['fields']['caller_firstname'] = array(
    'name' => 'caller_firstname',
    'vname' => 'LBL_CALLER_FIRSTNAME',
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
$dictionary['iv_intrested_vehicle']['fields']['caller_lastname'] = array(
    'name' => 'caller_lastname',
    'vname' => 'LBL_CALLER_LASTNAME',
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

$dictionary['iv_intrested_vehicle']['fields']['caller_phone_c'] = array(
    'name' => 'caller_phone_c',
    'vname' => 'LBL_CALLER_PHONE',
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

$dictionary['iv_intrested_vehicle']['fields']['caller_state_c'] = array(
    'name' => 'caller_state_c',
    'vname' => 'LBL_CALLER_STATE',
    'type' => 'varchar',
    'len' => '50',
    'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
);

$dictionary['iv_intrested_vehicle']['fields']['vehicle_c'] = array(
    'name' => 'vehicle_c',
    'vname' => 'LBL_VEHICLE',
    'type' => 'varchar',
    'len' => '200',
    'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
);

$dictionary['iv_intrested_vehicle']['fields']['stock_no_c'] = array(
    'name' => 'stock_no_c',
    'vname' => 'LBL_STOCK_NO',
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

$dictionary['iv_intrested_vehicle']['fields']['listing_url_c'] = array(
    'name' => 'listing_url_c',
    'vname' => 'LBL_LISTING_URL',
    'type' => 'varchar',
    'len' => '200',
    'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
);

$dictionary['iv_intrested_vehicle']['fields']['listed_price_c'] = array(
    'name' => 'listed_price_c',
    'vname' => 'LBL_LISTED_PRICE',
    'type' => 'int',
    'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
);

$dictionary['iv_intrested_vehicle']['fields']['market_value_c'] = array(
    'name' => 'market_value_c',
    'vname' => 'LBL_MARKET_VALUE',
    'type' => 'int',
    'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
);

$dictionary['iv_intrested_vehicle']['fields']['call_transcription_c'] = array(
    'name' => 'call_transcription_c',
    'vname' => 'LBL_CALL_VALUE',
    'type' => 'text',
    'audited' => false,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
    'required' => false,
    'dbType' => 'longtext', // can use 'text' if smaller
    'rows' => 6,
    'cols' => 80,
    'comment' => 'Save Transcription',
);

$dictionary['iv_intrested_vehicle']['fields']['comments'] = array(
    'name' => 'comments',
    'vname' => 'LBL_COMMENTS',
    'type' => 'text',
    'audited' => false,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
    'required' => false,
    'dbType' => 'longtext', // can use 'text' if smaller
    'rows' => 6,
    'cols' => 80,
    'comment' => 'Save Transcription',
);
$dictionary['iv_intrested_vehicle']['fields']['lead_url'] = array(
    'name' => 'lead_url',
    'vname' => 'LBL_LEAD_URL',
    'type' => 'varchar',
    'len' => '200',
    'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
);

$dictionary['iv_intrested_vehicle']['fields']['month_c'] = array(
    'name' => 'month_c',
    'vname' => 'LBL_MONTH',
    'type' => 'varchar',
    'len' => '150',
    'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
    'comment' => 'Loan/finance term in months',
);

$dictionary['iv_intrested_vehicle']['fields']['bank_c'] = array(
    'name' => 'bank_c',
    'vname' => 'LBL_BANK',
    'type' => 'varchar',
    'len' => '150',
    'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
    'comment' => 'Bank or financing institution name',
);

$dictionary['iv_intrested_vehicle']['fields']['trim_c'] = array(
    'name' => 'trim_c',
    'vname' => 'LBL_TRIM',
    'type' => 'varchar',
    'len' => '100',
    'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
    'comment' => 'Vehicle trim level',
);
$dictionary['iv_intrested_vehicle']['fields']['miles_per_year'] = array(
    'name' => 'miles_per_year',
    'vname' => 'LBL_MILES_PER_YEAR',
    'type' => 'varchar',
    'len' => '100',
    'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
    'comment' => 'Vehicle trim level',
);

$dictionary['iv_intrested_vehicle']['fields']['vin_c'] = array(
    'name' => 'vin_c',
    'vname' => 'LBL_VIN',
    'type' => 'varchar',
    'len' => '17',
    'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => true,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
    'comment' => 'Vehicle Identification Number (17 characters)',
);

$dictionary['iv_intrested_vehicle']['fields']['monthly_payments_c'] = array(
    'name'           => 'monthly_payments_c',
    'vname'          => 'LBL_MONTHLY_PAYMENTS',
    'type'           => 'decimal',
    'len'            => 10,    
    'precision'      => 4,     
    'audited'        => true,
    'massupdate'     => false,
    'importable'     => 'true',
    'reportable'     => true,
    'unified_search' => false,
    'merge_filter'   => 'disabled',
    'studio'         => 'visible',
    'comment'        => 'Monthly payment amount',
);

$dictionary['iv_intrested_vehicle']['fields']['start_date'] = array(
    'name' => 'start_date',
    'vname' => 'LBL_START_DATE',
    'type' => 'datetime',
    'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
);
$dictionary['iv_intrested_vehicle']['fields']['end_date'] = array(
    'name' => 'end_date',
    'vname' => 'LBL_END_DATE',
    'type' => 'datetime',
    'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
);