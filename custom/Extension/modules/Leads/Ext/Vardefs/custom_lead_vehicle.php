<?php
// Custom fields for Leads

$dictionary['Lead']['fields']['dealership_c'] = array(
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

$dictionary['Lead']['fields']['received_date_c'] = array(
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

$dictionary['Lead']['fields']['duration_c'] = array(
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

$dictionary['Lead']['fields']['callerid_c'] = array(
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
$dictionary['Lead']['fields']['caller_firstname'] = array(
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
$dictionary['Lead']['fields']['caller_lastname'] = array(
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

$dictionary['Lead']['fields']['caller_phone_c'] = array(
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

$dictionary['Lead']['fields']['caller_state_c'] = array(
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

$dictionary['Lead']['fields']['vehicle_c'] = array(
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

$dictionary['Lead']['fields']['stock_no_c'] = array(
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

$dictionary['Lead']['fields']['listing_url_c'] = array(
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

$dictionary['Lead']['fields']['listed_price_c'] = array(
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

$dictionary['Lead']['fields']['market_value_c'] = array(
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

$dictionary['Lead']['fields']['call_transcription_c'] = array(
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

$dictionary['Lead']['fields']['comments'] = array(
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
$dictionary['Lead']['fields']['lead_url'] = array(
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

$dictionary['Lead']['fields']['quote_created_c'] = array(
    'name' => 'quote_created_c',
    'vname' => 'LBL_QUOTE_CREATE',
    'type' => 'bool',
);
$dictionary['Lead']['fields']['is_want_converted'] = array(
    'name' => 'is_want_converted',
    'vname' => 'LBL_IS_WANT_CONVERTED',
    'type' => 'bool',
);

$dictionary['Lead']['indices'][] = array(
    'name' => 'idx_unique_phone_mobile',
    'type' => 'unique',
    'fields' => array('phone_mobile'),
);


