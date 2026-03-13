<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

global $db;

$nextIndex = $_REQUEST['next_index'] ?? 0;

$key = (!empty($_REQUEST['key']) && $_REQUEST['key'] == 'pov')
        ? 'pov_last_index'
        : 'last_index';
// update config table with the new index
//$db->query("DELETE FROM config WHERE category='lead_assign' AND name='last_index'");
//$db->query("UPDATE config (category, name, value) VALUES ('lead_assign', 'last_index', '{$nextIndex}')");
$db->query("UPDATE config set value = '{$nextIndex}' where category ='lead_assign' and  name ='{$key}'");

echo "OK"; // return success for fetch()
exit;
