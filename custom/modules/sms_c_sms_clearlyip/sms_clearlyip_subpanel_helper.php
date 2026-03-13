<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

function get_sms_clearlyip_for_parent($params) {
    // $params contains parent_id, parent_module
    $parent_id = isset($params['parent_id']) ? $params['parent_id'] : '';
    $parent_module = isset($params['parent_module']) ? $params['parent_module'] : '';

    if (empty($parent_id) || empty($parent_module)) return array('select' => '1=0');

    $bean = BeanFactory::newBean('sms_c_sms_clearlyip');
    $table = $bean->getTableName();

    // return simple select config for subpanel engine
    $query = "SELECT $table.* FROM $table WHERE related_parent_type = '" . $GLOBALS['db']->quote($parent_module) . "' AND related_parent_id = '" . $GLOBALS['db']->quote($parent_id) . "' ORDER BY date_entered DESC";
    return array('select' => $query);
}
