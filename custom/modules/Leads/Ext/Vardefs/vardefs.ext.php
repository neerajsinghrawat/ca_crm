<?php 
 //WARNING: The contents of this file are auto-generated


// Dropdown Lead Type
$dictionary['Lead']['fields']['lead_type'] = array(
    'name' => 'lead_type',
    'vname' => 'LBL_LEAD_TYPE',
    'type' => 'enum',
    'options' => 'lead_type_list', // you’ll define in dropdowns
    'len' => 100,
    'audited' => true,
    'required' => true,
);

// ===== Used Car Fields =====
$dictionary['Lead']['fields']['trade_in'] = array(
    'name' => 'trade_in',
    'vname' => 'LBL_TRADE_IN',
    'type' => 'bool',
);

$dictionary['Lead']['fields']['trade_year'] = array(
    'name' => 'trade_year',
    'vname' => 'LBL_TRADE_YEAR',
    'type' => 'varchar',
    'len' => 4,
);

$dictionary['Lead']['fields']['trade_make'] = array(
    'name' => 'trade_make',
    'vname' => 'LBL_TRADE_MAKE',
    'type' => 'varchar',
    'len' => 50,
);

$dictionary['Lead']['fields']['trade_miles'] = array(
    'name' => 'trade_miles',
    'vname' => 'LBL_TRADE_MILES',
    'type' => 'int',
);

$dictionary['Lead']['fields']['finance_or_paid'] = array(
    'name' => 'finance_or_paid',
    'vname' => 'LBL_FINANCE_OR_PAID',
    'type' => 'enum',
    'options' => 'finance_or_paid_list',
);

$dictionary['Lead']['fields']['finance_lender'] = array(
    'name' => 'finance_lender',
    'vname' => 'LBL_FINANCE_LENDER',
    'type' => 'varchar',
    'len' => 100,
);

$dictionary['Lead']['fields']['amount_owed'] = array(
    'name' => 'amount_owed',
    'vname' => 'LBL_AMOUNT_OWED',
    'type' => 'currency',
);

// ===== Interested Vehicle =====
$dictionary['Lead']['fields']['interested_year'] = array(
    'name' => 'interested_year',
    'vname' => 'LBL_INTERESTED_YEAR',
    'type' => 'varchar',
    'len' => 4,
);

$dictionary['Lead']['fields']['interested_make'] = array(
    'name' => 'interested_make',
    'vname' => 'LBL_INTERESTED_MAKE',
    'type' => 'varchar',
    'len' => 50,
);

$dictionary['Lead']['fields']['interested_model'] = array(
    'name' => 'interested_model',
    'vname' => 'LBL_INTERESTED_MODEL',
    'type' => 'varchar',
    'len' => 50,
);

$dictionary['Lead']['fields']['stock_number'] = array(
    'name' => 'stock_number',
    'vname' => 'LBL_STOCK_NUMBER',
    'type' => 'varchar',
    'len' => 50,
);

// ===== Form of Payment =====
$dictionary['Lead']['fields']['form_of_payment'] = array(
    'name' => 'form_of_payment',
    'vname' => 'LBL_FORM_OF_PAYMENT',
    'type' => 'enum',
    'options' => 'form_of_payment_list',
);

// ===== Task Section =====
$dictionary['Lead']['fields']['appt_test_drive'] = array(
    'name' => 'appt_test_drive',
    'vname' => 'LBL_APPT_TEST_DRIVE',
    'type' => 'bool',
);

$dictionary['Lead']['fields']['credit_application'] = array(
    'name' => 'credit_application',
    'vname' => 'LBL_CREDIT_APPLICATION',
    'type' => 'bool',
);

$dictionary['Lead']['fields']['finance_approved'] = array(
    'name' => 'finance_approved',
    'vname' => 'LBL_FINANCE_APPROVED',
    'type' => 'bool',
);

$dictionary['Lead']['fields']['deposit_taken'] = array(
    'name' => 'deposit_taken',
    'vname' => 'LBL_DEPOSIT_TAKEN',
    'type' => 'bool',
);

$dictionary['Lead']['fields']['transport_setup'] = array(
    'name' => 'transport_setup',
    'vname' => 'LBL_TRANSPORT_SETUP',
    'type' => 'bool',
);

$dictionary['Lead']['fields']['dmv_completed'] = array(
    'name' => 'dmv_completed',
    'vname' => 'LBL_DMV_COMPLETED',
    'type' => 'bool',
);

$dictionary['Lead']['fields']['dmv_lien'] = array(
    'name' => 'dmv_lien',
    'vname' => 'LBL_DMV_LIEN',
    'type' => 'bool',
);
$dictionary['Lead']['fields']['buyers_guide_signed'] = array(
    'name' => 'buyers_guide_signed',
    'vname' => 'LBL_BUYERS_GUIDE_SIGNED',
    'type' => 'bool',
);
$dictionary['Lead']['fields']['vehicle_delivered'] = array(
    'name' => 'vehicle_delivered',
    'vname' => 'LBL_VEHICLE_DELIVERED',
    'type' => 'bool',
);
$dictionary['Lead']['fields']['delivery_date'] = array(
    'name' => 'delivery_date',
    'vname' => 'LBL_DELIVERY_DATE',
    'type' => 'date',
);




// ===== Lease Car Fields =====
$dictionary['Lead']['fields']['current_lease'] = array(
    'name' => 'current_lease',
    'vname' => 'LBL_CURRENT_LEASE',
    'type' => 'bool',
);
$dictionary['Lead']['fields']['is_new_lead_c'] = array(
    'name' => 'is_new_lead_c',
    'vname' => 'LBL_NEW_LEAD',
    'type' => 'bool',
    'default' => 1,
    'audited' => false,
    'reportable' => true,
);
$dictionary['Lead']['fields']['is_sms_service_on'] = array(
    'name' => 'is_sms_service_on',
    'vname' => 'LBL_IS_SMS_SERVICE_ON',
    'type' => 'bool',
    'default' => 0,
    'audited' => false,
    'reportable' => true,
);

$dictionary['Lead']['fields']['lease_expiry'] = array(
    'name' => 'lease_expiry',
    'vname' => 'LBL_LEASE_EXPIRY',
    'type' => 'date',
);

$dictionary['Lead']['fields']['lease_miles_per_year'] = array(
    'name' => 'lease_miles_per_year',
    'vname' => 'LBL_LEASE_MILES_PER_YEAR',
    'type' => 'int',
);

$dictionary['Lead']['fields']['category_c'] = array(
    'name' => 'category_c',
    'vname' => 'LBL_CATEGORY',
    'type' => 'enum',
    'options' => 'category_list',
    'len' => 100,
    'studio' => true,
    'reportable' => true,
    'sortable' => true,
    'massupdate' => true,
    'importable' => true,
);


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

$dictionary['Lead']['unified_search'] = true;
$dictionary['Lead']['unified_search_default_enabled'] = true;

$dictionary['Lead']['fields']['phone_mobile']['unified_search'] = true;
$dictionary['Lead']['fields']['phone_work']['unified_search'] = true;
$dictionary['Lead']['fields']['phone_home']['unified_search'] = true;
$dictionary['Lead']['fields']['phone_other']['unified_search'] = true;




$dictionary['Lead']['fields']['iv_intrested_vehicle_link'] = array(
    'name' => 'iv_intrested_vehicle_link',
    'type' => 'link',
    'relationship' => 'leads_iv_intrested_vehicle',
    'module' => 'iv_intrested_vehicle',
    'bean_name' => 'iv_intrested_vehicle',
    'source' => 'non-db',
);


$dictionary['Lead']['fields']['aos_product_id_c'] = array(
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

$dictionary['Lead']['fields']['product_name_c'] = array(
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


$dictionary['Lead']['relationships']['lead_aos_products'] = array(
    'lhs_module' => 'AOS_Products',
    'lhs_table'  => 'aos_products',
    'lhs_key'    => 'id',

    'rhs_module' => 'Leads',
    'rhs_table'  => 'leads',
    'rhs_key'    => 'aos_product_id_c',

    'relationship_type' => 'one-to-many',
);


$dictionary['Lead']['fields']['aos_products_link'] = array(
    'name' => 'aos_products_link',
    'type' => 'link',
    'relationship' => 'lead_aos_products',
    'module' => 'AOS_Products',
    'bean_name' => 'AOS_Products',
    'source' => 'non-db',
    'vname' => 'LBL_PRODUCT',
);



$dictionary['Lead']['fields']['ta_trade_appraisal_link'] = array(
    'name' => 'ta_trade_appraisal_link',
    'type' => 'link',
    'relationship' => 'leads_ta_trade_appraisal',
    'module' => 'ta_trade_appraisal',
    'bean_name' => 'ta_trade_appraisal',
    'source' => 'non-db',
);



$dictionary['Lead']['fields']['user_activity_log_link'] = array(
    'name' => 'user_activity_log_link',
    'type' => 'link',
    'relationship' => 'leads_user_activity_log',
    'source' => 'non-db',
    'module' => 'ual_user_activity_log',
    'bean_name' => 'ual_user_activity_log',
    'vname' => 'LBL_USER_ACTIVITY_LOG',
);

$dictionary['Lead']['relationships']['leads_user_activity_log'] = array(
    'lhs_module' => 'Leads',
    'lhs_table' => 'leads',
    'lhs_key' => 'id',

    'rhs_module' => 'ual_user_activity_log',
    'rhs_table' => 'ual_user_activity_log',
    'rhs_key' => 'parent_id',

    'relationship_type' => 'one-to-many',
);


 // created: 2025-08-08 05:42:49
$dictionary['Lead']['fields']['jjwg_maps_address_c']['inline_edit']=1;

 

 // created: 2025-08-08 05:42:49
$dictionary['Lead']['fields']['jjwg_maps_geocode_status_c']['inline_edit']=1;

 

 // created: 2025-08-08 05:42:49
$dictionary['Lead']['fields']['jjwg_maps_lat_c']['inline_edit']=1;

 

 // created: 2025-08-08 05:42:49
$dictionary['Lead']['fields']['jjwg_maps_lng_c']['inline_edit']=1;

 
?>