<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 

$hook_version = 1;
$hook_array = array();

$hook_array['after_retrieve'][] = array(
    20,
    'Show Lead phone in Note name (view only)',
    'custom/modules/Notes/ShowNumberInNoteName.php',
    'ShowNumberInNoteName',
    'appendPhoneOnView'
);

?>