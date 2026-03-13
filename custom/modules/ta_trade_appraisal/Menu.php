<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$module_menu = array();

if(ACLController::checkAccess('ta_trade_appraisal', 'edit', true)){
    $module_menu[]=array('index.php?module=ta_trade_appraisal&action=EditView&return_module=ta_trade_appraisal&return_action=DetailView', $mod_strings['LNK_NEW_RECORD'], 'Add', 'ta_trade_appraisal');
}
if(ACLController::checkAccess('ta_trade_appraisal', 'list', true)){
    $module_menu[]=array('index.php?module=ta_trade_appraisal&action=index&return_module=ta_trade_appraisal&return_action=DetailView', $mod_strings['LNK_LIST'],'View', 'ta_trade_appraisal');
}

$module_menu[] = array(
    'javascript:openSendAppraisalPopup();',
    'Send Appraisal',
    'Import', 'ta_trade_appraisal'
);


