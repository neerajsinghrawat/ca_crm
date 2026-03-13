<?php 
 //WARNING: The contents of this file are auto-generated


// Path: custom/Extension/modules/iv_intrested_vehicle/Ext/Vardefs/accounts_relationship.php

$dictionary['iv_intrested_vehicle']['relationships']['accounts_iv_intrested_vehicle'] = array(
    'lhs_module'        => 'ac_dealers',
    'lhs_table'         => 'ac_dealers',
    'lhs_key'           => 'id',
    'rhs_module'        => 'iv_intrested_vehicle',
    'rhs_table'         => 'iv_intrested_vehicle',
    'rhs_key'           => 'account_id_c',
    'relationship_type' => 'one-to-many',
    'join_key_rhs'      => 'account_id_c',
);

// Foreign key field
$dictionary['iv_intrested_vehicle']['fields']['account_id_c'] = array(
    'name'       => 'account_id_c',
    'vname'      => 'LBL_ACCOUNT_ID',
    'type'       => 'id',
    'table'      => 'ac_dealers',
    'isnull'     => 'true',
    'module'     => 'ac_dealers',
    'dbType'     => 'id',
    'reportable' => false,
    'audited'    => true,
    'comment'    => 'Foreign key to Accounts (Dealer only)',
);

// Link field
$dictionary['iv_intrested_vehicle']['fields']['account_link'] = array(
    'name'         => 'account_link',
    'type'         => 'link',
    'relationship' => 'accounts_iv_intrested_vehicle',
    'module'       => 'ac_dealers',
    'bean_name'    => 'ac_dealers',
    'source'       => 'non-db',
    'vname'        => 'LBL_ACCOUNT',
);

$dictionary['iv_intrested_vehicle']['fields']['account_name_c'] = array(
    'name'          => 'account_name_c',
    'rname'         => 'name',
    'id_name'       => 'account_id_c',
    'vname'         => 'LBL_DEALERSHIP',
    'type'          => 'relate',
    'link'          => 'account_link',
    'table'         => 'ac_dealers',
    'isnull'        => 'true',
    'module'        => 'ac_dealers',
    'dbType'        => 'varchar',
    'len'           => '255',
    'source'        => 'non-db',
    'audited'       => true,
);

// Dropdown Lead Type
$dictionary['iv_intrested_vehicle']['fields']['lead_type'] = array(
    'name' => 'lead_type',
    'vname' => 'LBL_LEAD_TYPE',
    'type' => 'enum',
    'options' => 'lead_type_list', // you’ll define in dropdowns
    'len' => 100,
    'audited' => true,
    'required' => true,
);


$dictionary['iv_intrested_vehicle']['fields']['finance_or_paid'] = array(
    'name' => 'finance_or_paid',
    'vname' => 'LBL_FINANCE_OR_PAID',
    'type' => 'enum',
    'options' => 'finance_or_paid_list',
);

$dictionary['iv_intrested_vehicle']['fields']['finance_lender'] = array(
    'name' => 'finance_lender',
    'vname' => 'LBL_FINANCE_LENDER',
    'type' => 'varchar',
    'len' => 100,
);

$dictionary['iv_intrested_vehicle']['fields']['amount_owed'] = array(
    'name' => 'amount_owed',
    'vname' => 'LBL_AMOUNT_OWED',
    'type' => 'currency',
);

// ===== Interested Vehicle =====
$dictionary['iv_intrested_vehicle']['fields']['interested_year'] = array(
    'name' => 'interested_year',
    'vname' => 'LBL_INTERESTED_YEAR',
    'type' => 'varchar',
    'len' => 4,
);

$dictionary['iv_intrested_vehicle']['fields']['interested_make'] = array(
    'name' => 'interested_make',
    'vname' => 'LBL_INTERESTED_MAKE',
    'type' => 'varchar',
    'len' => 50,
);

$dictionary['iv_intrested_vehicle']['fields']['interested_model'] = array(
    'name' => 'interested_model',
    'vname' => 'LBL_INTERESTED_MODEL',
    'type' => 'varchar',
    'len' => 50,
);

$dictionary['iv_intrested_vehicle']['fields']['stock_number'] = array(
    'name' => 'stock_number',
    'vname' => 'LBL_STOCK_NUMBER',
    'type' => 'varchar',
    'len' => 50,
);

// ===== Form of Payment =====
$dictionary['iv_intrested_vehicle']['fields']['form_of_payment'] = array(
    'name' => 'form_of_payment',
    'vname' => 'LBL_FORM_OF_PAYMENT',
    'type' => 'enum',
    'options' => 'form_of_payment_list',
);

// ===== Task Section =====
$dictionary['iv_intrested_vehicle']['fields']['appt_test_drive'] = array(
    'name' => 'appt_test_drive',
    'vname' => 'LBL_APPT_TEST_DRIVE',
    'type' => 'bool',
);

$dictionary['iv_intrested_vehicle']['fields']['credit_application'] = array(
    'name' => 'credit_application',
    'vname' => 'LBL_CREDIT_APPLICATION',
    'type' => 'bool',
);

$dictionary['iv_intrested_vehicle']['fields']['finance_approved'] = array(
    'name' => 'finance_approved',
    'vname' => 'LBL_FINANCE_APPROVED',
    'type' => 'bool',
);

$dictionary['iv_intrested_vehicle']['fields']['deposit_taken'] = array(
    'name' => 'deposit_taken',
    'vname' => 'LBL_DEPOSIT_TAKEN',
    'type' => 'bool',
);

$dictionary['iv_intrested_vehicle']['fields']['transport_setup'] = array(
    'name' => 'transport_setup',
    'vname' => 'LBL_TRANSPORT_SETUP',
    'type' => 'bool',
);

$dictionary['iv_intrested_vehicle']['fields']['dmv_completed'] = array(
    'name' => 'dmv_completed',
    'vname' => 'LBL_DMV_COMPLETED',
    'type' => 'bool',
);

$dictionary['iv_intrested_vehicle']['fields']['dmv_lien'] = array(
    'name' => 'dmv_lien',
    'vname' => 'LBL_DMV_LIEN',
    'type' => 'bool',
);
$dictionary['iv_intrested_vehicle']['fields']['buyers_guide_signed'] = array(
    'name' => 'buyers_guide_signed',
    'vname' => 'LBL_BUYERS_GUIDE_SIGNED',
    'type' => 'bool',
);
$dictionary['iv_intrested_vehicle']['fields']['vehicle_delivered'] = array(
    'name' => 'vehicle_delivered',
    'vname' => 'LBL_VEHICLE_DELIVERED',
    'type' => 'bool',
);
$dictionary['iv_intrested_vehicle']['fields']['delivery_date'] = array(
    'name' => 'delivery_date',
    'vname' => 'LBL_DELIVERY_DATE',
    'type' => 'date',
);




// ===== Lease Car Fields =====
$dictionary['iv_intrested_vehicle']['fields']['current_lease'] = array(
    'name' => 'current_lease',
    'vname' => 'LBL_CURRENT_LEASE',
    'type' => 'bool',
);
$dictionary['iv_intrested_vehicle']['fields']['is_new_lead_c'] = array(
    'name' => 'is_new_lead_c',
    'vname' => 'LBL_NEW_LEAD',
    'type' => 'bool',
    'default' => 1,
    'audited' => false,
    'reportable' => true,
);
$dictionary['iv_intrested_vehicle']['fields']['is_sms_service_on'] = array(
    'name' => 'is_sms_service_on',
    'vname' => 'LBL_IS_SMS_SERVICE_ON',
    'type' => 'bool',
    'default' => 0,
    'audited' => false,
    'reportable' => true,
);

$dictionary['iv_intrested_vehicle']['fields']['lease_expiry'] = array(
    'name' => 'lease_expiry',
    'vname' => 'LBL_LEASE_EXPIRY',
    'type' => 'date',
);

$dictionary['iv_intrested_vehicle']['fields']['lease_miles_per_year'] = array(
    'name' => 'lease_miles_per_year',
    'vname' => 'LBL_LEASE_MILES_PER_YEAR',
    'type' => 'int',
);

$dictionary['iv_intrested_vehicle']['fields']['lead_source'] =
array(
    'name' => 'lead_source',
    'vname' => 'LBL_LEAD_SOURCE',
    'type' => 'enum',
    'options' => 'lead_source_dom',
    'len' => '50',
    'comment' => 'Source of the opportunity',
    'merge_filter' => 'enabled',
);

$dictionary['iv_intrested_vehicle']['fields']['status'] =
array(
    'name' => 'status',
    'vname' => 'LBL_STATUS',
    'type' => 'enum',
    'len' => '100',
    'options' => 'lead_status_dom',
    'audited' => true,
    'comment' => 'Status of the lead',
    'merge_filter' => 'enabled',
);


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

$dictionary['iv_intrested_vehicle']['fields']['lead_id'] = array(
    'name' => 'lead_id',
    'vname' => 'LBL_LEAD_ID',
    'type' => 'id',
    'audited' => true,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => false,
    'unified_search' => false,
    'merge_filter' => 'disabled',
);
$dictionary['iv_intrested_vehicle']['fields']['lead_name'] = array(
    'name' => 'lead_name',
    'vname' => 'LBL_LEAD_NAME',
    'type' => 'relate',
    'source' => 'non-db',
    'module' => 'Leads',
    'table' => 'leads',
    'id_name' => 'lead_id',
    'rname'      => 'name',   
    'link'       => 'lead_link', 
    'reportable' => true,
    'studio' => 'visible',
);
$dictionary['iv_intrested_vehicle']['fields']['lead_link'] = array(
    'name' => 'lead_link',
    'type' => 'link',
    'relationship' => 'leads_iv_intrested_vehicle',
    'module' => 'Leads',
    'bean_name' => 'Lead',
    'source' => 'non-db',
);

$dictionary['iv_intrested_vehicle']['relationships']['leads_iv_intrested_vehicle'] = array(
    'lhs_module' => 'Leads',
    'lhs_table'  => 'leads',
    'lhs_key'    => 'id',
    'rhs_module' => 'iv_intrested_vehicle',
    'rhs_table'  => 'iv_intrested_vehicle',
    'rhs_key'    => 'lead_id',
    'relationship_type' => 'one-to-many',
);

$dictionary['iv_intrested_vehicle']['fields']['aos_product_id_c'] = array(
    'name' => 'aos_product_id_c',
    'rname' => 'id',
    'vname' => 'LBL_PRODUCT',
    'type' => 'id',
    'table' => 'aos_products',
    'isnull' => 'true',
    'module' => 'AOS_Products',
    'dbType' => 'id',
    'reportable' => false,
    'audited' => true,
    'comment' => 'Relate to AOS_Products'
);

$dictionary['iv_intrested_vehicle']['fields']['product_name_c'] = array(
    'name' => 'product_name_c',
    'rname' => 'name',
    'id_name' => 'aos_product_id_c',
    'vname' => 'LBL_PRODUCT',
    'type' => 'relate',
    'link' => 'aos_products_link',
    'table' => 'aos_products',
    'isnull' => 'true',
    'module' => 'AOS_Products',
    'dbType' => 'varchar',
    'len' => '255',
    'source' => 'non-db',
);


/*$dictionary['iv_intrested_vehicle']['relationships']['lead_aos_products'] = array(
    'lhs_module' => 'AOS_Products',
    'lhs_table'  => 'aos_products',
    'lhs_key'    => 'id',

    'rhs_module' => 'iv_intrested_vehicle',
    'rhs_table'  => 'iv_intrested_vehicle',
    'rhs_key'    => 'aos_product_id_c',

    'relationship_type' => 'one-to-many',
);

$dictionary['iv_intrested_vehicle']['fields']['aos_products_link'] = array(
    'name' => 'aos_products_link',
    'type' => 'link',
    'relationship' => 'lead_aos_products',
    'module' => 'AOS_Products',
    'bean_name' => 'AOS_Products',
    'source' => 'non-db',
    'vname' => 'LBL_PRODUCT',
);*/

?>