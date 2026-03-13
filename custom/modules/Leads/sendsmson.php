<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once 'custom/include/Sms/sms_service.php';
class LeadSendSmsService {
    function onSmsService($bean, $event, $arguments) {
        
        if (!empty($bean->fetched_row)) return;
            $product_name_c='';
            if (isset($bean->product_name_c) && !empty($bean->product_name_c)) {
               $product_name_c=$bean->product_name_c;
            }

            $assigned_user_name='Status Salesperson';

            if(!empty($bean->assigned_user_id)){
                $userBean = BeanFactory::getBean('Users', $bean->assigned_user_id);
                if($userBean){
                    $assigned_user_name = trim($userBean->first_name . ' ' . $userBean->last_name);
                }
            }
            
        $message = "Thank you for reaching out to Status Auto Group regarding the. ".$product_name_c."To receive text messages from ".$assigned_user_name.", please reply YES. To stop messages at any time, reply StatusSTOP.";

        //sendSmsForLead($bean->id, $message);
        logActivity(
                'leads',   // module
                $bean->id,           // record id
                'sms sent',             // create/edit
                '',                  // field
                '',                  // old
                '',                  // new
                'Message Service ON Approval Request Sent by Sms', //description
                $bean->id,//parent_id
                'Leads',//parent_type
                'message service on approval'//parent_type
            );
       
    }

}
