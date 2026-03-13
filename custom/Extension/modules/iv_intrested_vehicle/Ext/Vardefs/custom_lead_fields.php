<?php
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
