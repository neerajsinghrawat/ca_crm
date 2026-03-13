<?php
class ActivityGlobal
{
    function track($bean, $event, $arguments)
    {
        global $current_user;

        if(empty($current_user->id)) return;      
        if(empty($bean->id)) return;
        if(!empty($bean->fetched_row)) return;

        $action = 'create';

        $record_name = '';
        $field ='';
        if(isset($bean->name)){
          if(!empty($bean->name)){
            $record_name = $bean->name;
            $field ='Name';
          }
        }
        if(isset($bean->vin)){
          $record_name = $bean->vin;
          $field ='Vin';
        }

        $name = $action.'-'.$bean->module_dir;

        if(function_exists('logActivity')){
            logActivity(
                $bean->module_dir,   // module
                $bean->id,           // record id
                $action,             // create/edit
                $field,                  // field
                '',                  // old
                $record_name,                  // new
                $bean->module_dir.' '.$action.' : '.$record_name,//description
                $_REQUEST['return_id'],//parent_id
                $_REQUEST['return_module'],//parent_type
                $name,//name
            );
        }
    }
}
