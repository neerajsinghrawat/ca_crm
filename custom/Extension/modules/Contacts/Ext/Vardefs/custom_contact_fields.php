<?php
// Dropdown Lead Type
$dictionary['Contact']['fields']['lead_type'] = array(
    'name' => 'lead_type',
    'vname' => 'LBL_LEAD_TYPE',
    'type' => 'enum',
    'options' => 'lead_type_list', // you’ll define in dropdowns
    'len' => 100,
    'audited' => true,
    'required' => true,
);

// ===== Used Car Fields =====
$dictionary['Contact']['fields']['trade_in'] = array(
    'name' => 'trade_in',
    'vname' => 'LBL_TRADE_IN',
    'type' => 'bool',
);

$dictionary['Contact']['fields']['trade_year'] = array(
    'name' => 'trade_year',
    'vname' => 'LBL_TRADE_YEAR',
    'type' => 'varchar',
    'len' => 4,
);

$dictionary['Contact']['fields']['trade_make'] = array(
    'name' => 'trade_make',
    'vname' => 'LBL_TRADE_MAKE',
    'type' => 'varchar',
    'len' => 50,
);

$dictionary['Contact']['fields']['trade_miles'] = array(
    'name' => 'trade_miles',
    'vname' => 'LBL_TRADE_MILES',
    'type' => 'int',
);

$dictionary['Contact']['fields']['finance_or_paid'] = array(
    'name' => 'finance_or_paid',
    'vname' => 'LBL_FINANCE_OR_PAID',
    'type' => 'enum',
    'options' => 'finance_or_paid_list',
);

$dictionary['Contact']['fields']['finance_lender'] = array(
    'name' => 'finance_lender',
    'vname' => 'LBL_FINANCE_LENDER',
    'type' => 'varchar',
    'len' => 100,
);

$dictionary['Contact']['fields']['amount_owed'] = array(
    'name' => 'amount_owed',
    'vname' => 'LBL_AMOUNT_OWED',
    'type' => 'currency',
);

// ===== Interested Vehicle =====
$dictionary['Contact']['fields']['interested_year'] = array(
    'name' => 'interested_year',
    'vname' => 'LBL_INTERESTED_YEAR',
    'type' => 'varchar',
    'len' => 4,
);

$dictionary['Contact']['fields']['interested_make'] = array(
    'name' => 'interested_make',
    'vname' => 'LBL_INTERESTED_MAKE',
    'type' => 'varchar',
    'len' => 50,
);

$dictionary['Contact']['fields']['interested_model'] = array(
    'name' => 'interested_model',
    'vname' => 'LBL_INTERESTED_MODEL',
    'type' => 'varchar',
    'len' => 50,
);

$dictionary['Contact']['fields']['stock_number'] = array(
    'name' => 'stock_number',
    'vname' => 'LBL_STOCK_NUMBER',
    'type' => 'varchar',
    'len' => 50,
);

// ===== Form of Payment =====
$dictionary['Contact']['fields']['form_of_payment'] = array(
    'name' => 'form_of_payment',
    'vname' => 'LBL_FORM_OF_PAYMENT',
    'type' => 'enum',
    'options' => 'form_of_payment_list',
);

// ===== Task Section =====
$dictionary['Contact']['fields']['appt_test_drive'] = array(
    'name' => 'appt_test_drive',
    'vname' => 'LBL_APPT_TEST_DRIVE',
    'type' => 'bool',
);

$dictionary['Contact']['fields']['credit_application'] = array(
    'name' => 'credit_application',
    'vname' => 'LBL_CREDIT_APPLICATION',
    'type' => 'bool',
);

$dictionary['Contact']['fields']['finance_approved'] = array(
    'name' => 'finance_approved',
    'vname' => 'LBL_FINANCE_APPROVED',
    'type' => 'bool',
);

$dictionary['Contact']['fields']['deposit_taken'] = array(
    'name' => 'deposit_taken',
    'vname' => 'LBL_DEPOSIT_TAKEN',
    'type' => 'bool',
);

$dictionary['Contact']['fields']['transport_setup'] = array(
    'name' => 'transport_setup',
    'vname' => 'LBL_TRANSPORT_SETUP',
    'type' => 'bool',
);

$dictionary['Contact']['fields']['dmv_completed'] = array(
    'name' => 'dmv_completed',
    'vname' => 'LBL_DMV_COMPLETED',
    'type' => 'bool',
);

$dictionary['Contact']['fields']['dmv_lien'] = array(
    'name' => 'dmv_lien',
    'vname' => 'LBL_DMV_LIEN',
    'type' => 'bool',
);




// ===== Lease Car Fields =====
$dictionary['Contact']['fields']['current_lease'] = array(
    'name' => 'current_lease',
    'vname' => 'LBL_CURRENT_LEASE',
    'type' => 'bool',
);

$dictionary['Contact']['fields']['lease_expiry'] = array(
    'name' => 'lease_expiry',
    'vname' => 'LBL_LEASE_EXPIRY',
    'type' => 'date',
);

$dictionary['Contact']['fields']['lease_miles_per_year'] = array(
    'name' => 'lease_miles_per_year',
    'vname' => 'LBL_LEASE_MILES_PER_YEAR',
    'type' => 'int',
);


$dictionary['Contact']['fields']['dealership_c'] = array(
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

$dictionary['Contact']['fields']['received_date_c'] = array(
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

$dictionary['Contact']['fields']['duration_c'] = array(
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

$dictionary['Contact']['fields']['callerid_c'] = array(
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

$dictionary['Contact']['fields']['caller_phone_c'] = array(
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

$dictionary['Contact']['fields']['caller_state_c'] = array(
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

$dictionary['Contact']['fields']['vehicle_c'] = array(
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

$dictionary['Contact']['fields']['stock_no_c'] = array(
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

$dictionary['Contact']['fields']['listing_url_c'] = array(
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

$dictionary['Contact']['fields']['listed_price_c'] = array(
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

$dictionary['Contact']['fields']['market_value_c'] = array(
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

$dictionary['Contact']['fields']['call_transcription_c'] = array(
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


$dictionary['Contact']['fields']['quote_created_c'] = array(
    'name' => 'quote_created_c',
    'vname' => 'LBL_QUOTE_CREATE',
    'type' => 'bool',
);
