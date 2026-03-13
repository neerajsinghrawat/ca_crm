<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('data/SugarBean.php');

class sms_c_sms_clearlyip extends SugarBean {
    public $new_schema = true;
    public $module_dir = 'sms_c_sms_clearlyip';
    public $object_name = 'sms_c_sms_clearlyip';
    public $table_name = 'sms_c_sms_clearlyip';

    // define default fields array (optional)
    public $id;
    public $name;
    public $date_entered;
    public $date_modified;
    public $modified_user_id;
    public $created_by;
    public $from_number;
    public $to_number;
    public $message;
    public $type;
    public $related_parent_type;
    public $related_parent_id;

    public function __construct() {
        parent::__construct();
    }
}
