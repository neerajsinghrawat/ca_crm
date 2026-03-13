<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class ProductNameSaveName
{
    public function saveName($bean, $event, $arguments)
    {
    
        global $current_user,$db;
        //echo "<pre>";print_r($bean->product_name_c);die;
        if (isset($bean->product_name_c) && !empty($bean->product_name_c)) {
           $bean->name=$bean->product_name_c;
        }
        
    }
}
