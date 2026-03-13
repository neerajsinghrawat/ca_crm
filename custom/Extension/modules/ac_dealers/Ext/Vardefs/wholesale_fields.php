<?php

$dictionary['ac_dealers']['fields']['company'] = array(
    'name' => 'company',
    'vname' => 'LBL_COMPANY',
    'type' => 'varchar',
    'len' => '255',
    'audited' => true,
);

$dictionary['ac_dealers']['fields']['phone'] = array(
    'name' => 'phone',
    'vname' => 'LBL_PHONE',
    'type' => 'varchar',
    'len' => '100',
    'audited' => true,
);

$dictionary['ac_dealers']['fields']['license_number'] = array(
    'name' => 'license_number',
    'vname' => 'LBL_LICENSE_NUMBER',
    'type' => 'varchar',
    'len' => '100',
    'audited' => true,
);

$dictionary['ac_dealers']['fields']['dealer_status'] = array(
    'name' => 'dealer_status',
    'vname' => 'LBL_DEALER_STATUS',
    'type' => 'enum',
    'options' => 'dealer_status_list',
    'default' => 'active',
    'audited' => true,
);

$dictionary['ac_dealers']['fields']['wholesale_discount'] = array(
    'name' => 'wholesale_discount',
    'vname' => 'LBL_WHOLESALE_DISCOUNT',
    'type' => 'decimal',
    'len' => '5,2',
    'audited' => true,
);

$dictionary['ac_dealers']['fields']['preferred_vehicle_types'] = array(
    'name' => 'preferred_vehicle_types',
    'vname' => 'LBL_PREFERRED_VEHICLE_TYPES',
    'type' => 'multienum',
    'options' => 'vehicle_type_list',
    'audited' => true,
);

$dictionary['ac_dealers']['fields']['agreement_template'] = array(
    'name' => 'agreement_template',
    'vname' => 'LBL_AGREEMENT_TEMPLATE',
    'type' => 'enum',
    'options' => 'wholesale_agreement_template_list',
    'audited' => true,
);

$dictionary['ac_dealers']['fields']['docusign_email'] = array(
    'name' => 'docusign_email',
    'vname' => 'LBL_DOCUSIGN_EMAIL',
    'type' => 'varchar',
    'len' => '255',
    'audited' => true,
);
