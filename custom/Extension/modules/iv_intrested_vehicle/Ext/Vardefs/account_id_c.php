<?php
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