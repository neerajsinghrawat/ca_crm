<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class AssignUserFromDropdown
{
    public function setAssignedUser(&$bean, $event, $arguments)
    {
        // dropdown field name
        if (!empty($_REQUEST['assigned_user_dropdown_c'])) {
            $bean->assigned_user_id = $_REQUEST['assigned_user_dropdown_c'];
        }else{
            $bean->assigned_user_dropdown_c = $bean->assigned_user_id;
        }
        if (!empty($_REQUEST['task_subject_dd_c'])) {
            $bean->name = $_REQUEST['task_subject_dd_c'];
        }

    }
}
