<?php
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