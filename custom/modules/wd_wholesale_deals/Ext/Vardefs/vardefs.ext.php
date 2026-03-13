<?php 
 //WARNING: The contents of this file are auto-generated



$dictionary['wd_wholesale_deals']['fields']['deal_id'] = array('name' => 'deal_id', 'vname' => 'LBL_DEAL_ID', 'type' => 'varchar', 'len' => '50', 'audited' => true);
$dictionary['wd_wholesale_deals']['fields']['wholesaler_id'] = array('name' => 'wholesaler_id', 'vname' => 'LBL_WHOLESALER_ID', 'type' => 'id');
$dictionary['wd_wholesale_deals']['fields']['wholesaler_name'] = array('name' => 'wholesaler_name', 'vname' => 'LBL_WHOLESALER_NAME', 'type' => 'varchar', 'len' => '255');
$dictionary['wd_wholesale_deals']['fields']['total_vehicle_count'] = array('name' => 'total_vehicle_count', 'vname' => 'LBL_TOTAL_VEHICLES', 'type' => 'int');
$dictionary['wd_wholesale_deals']['fields']['total_amount'] = array('name' => 'total_amount', 'vname' => 'LBL_TOTAL_AMOUNT', 'type' => 'currency');
$dictionary['wd_wholesale_deals']['fields']['deal_date'] = array('name' => 'deal_date', 'vname' => 'LBL_DEAL_DATE', 'type' => 'date');
$dictionary['wd_wholesale_deals']['fields']['status'] = array('name' => 'status', 'vname' => 'LBL_STATUS', 'type' => 'enum', 'options' => 'wholesale_deal_status_list', 'default' => 'draft');
$dictionary['wd_wholesale_deals']['fields']['agreement_status'] = array('name' => 'agreement_status', 'vname' => 'LBL_AGREEMENT_STATUS', 'type' => 'enum', 'options' => 'agreement_status_list', 'default' => 'draft');
$dictionary['wd_wholesale_deals']['fields']['docusign_status'] = array('name' => 'docusign_status', 'vname' => 'LBL_DOCUSIGN_STATUS', 'type' => 'enum', 'options' => 'docusign_status_list', 'default' => 'not_sent');
$dictionary['wd_wholesale_deals']['fields']['docusign_envelope_id'] = array('name' => 'docusign_envelope_id', 'vname' => 'LBL_DOCUSIGN_ENVELOPE_ID', 'type' => 'varchar', 'len' => '150');
$dictionary['wd_wholesale_deals']['fields']['wholesale_price'] = array('name' => 'wholesale_price', 'vname' => 'LBL_WHOLESALE_PRICE', 'type' => 'currency');
$dictionary['wd_wholesale_deals']['fields']['agreement_template'] = array('name' => 'agreement_template', 'vname' => 'LBL_AGREEMENT_TEMPLATE', 'type' => 'enum', 'options' => 'wholesale_agreement_template_list');
$dictionary['wd_wholesale_deals']['fields']['notes'] = array('name' => 'notes', 'vname' => 'LBL_NOTES', 'type' => 'text');

?>