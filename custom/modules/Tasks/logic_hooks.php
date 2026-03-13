<?php
$hook_version = 1;
$hook_array = array();

$hook_array['before_save'][] = array(
    1,
    'Assign user from dropdown',
    'custom/modules/Tasks/AssignUserFromDropdown.php',
    'AssignUserFromDropdown',
    'setAssignedUser'
);
