<?php

$dictionary['ac_dealers']['fields']['email'] = array(
    'name'       => 'email',
    'vname'      => 'LBL_EMAIL',
    'type'       => 'varchar',
    'len'        => '255',
    'audited'    => true,
    'massupdate' => false,
    'reportable' => true,
    'studio'     => 'visible',
);

// Address field
$dictionary['ac_dealers']['fields']['address'] = array(
    'name'       => 'address',
    'vname'      => 'LBL_ADDRESS',
    'type'       => 'varchar',
    'len'        => '255',
    'audited'    => true,
    'massupdate' => false,
    'reportable' => true,
    'studio'     => 'visible',
);

// Representative field
$dictionary['ac_dealers']['fields']['representative'] = array(
    'name'       => 'representative',
    'vname'      => 'LBL_REPRESENTATIVE',
    'type'       => 'varchar',
    'len'        => '150',
    'audited'    => true,
    'massupdate' => false,
    'reportable' => true,
    'studio'     => 'visible',
);

// Is Wholesaler checkbox
$dictionary['ac_dealers']['fields']['is_wholesaler'] = array(
    'name'         => 'is_wholesaler',
    'vname'        => 'LBL_IS_WHOLESALER',
    'type'         => 'bool',
    'default'      => '0',
    'audited'      => true,
    'massupdate'   => false,
    'reportable'   => true,
    'studio'       => 'visible',
);
