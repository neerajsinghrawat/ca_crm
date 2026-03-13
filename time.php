<?php
define('sugarEntry', true);
require_once 'include/entryPoint.php';

global $timedate;

echo "SuiteCRM Timezone: ".$timedate->getUserTimeZone()."<br>";
echo "Server Timezone: ".date_default_timezone_get();