<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class leadDuplicateclass{

    function leadDuplicatemethod(&$bean, $event, $arguments) {
		global  $app_list_strings,$db;

		if (!empty($bean->stock_number)) {
            $query = "SELECT id FROM {$bean->table_name} 
                      WHERE stock_number = '{$bean->stock_number}'
                      AND deleted = 0 
                      AND id != '{$bean->id}' LIMIT 1";
            $result = $db->query($query);

            if ($db->fetchByAssoc($result)) {
                // Prevent save
                sugar_die("Duplicate Stock Number found! Please use a unique value.");
            }
        }
    }
}
