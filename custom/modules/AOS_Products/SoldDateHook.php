<?php
class SoldDateHook
{
    public function saveDate($bean, $event, $args)
    {
        if (!empty($_REQUEST['sold_datetime'])) {

            $date = $_REQUEST['sold_datetime'];            
            // If time missing → add midnight
            if (strlen($date) === 10) {
                $date = date('Y-m-d',strtotime($date));
                $date .= ' ' . date('H:i:s');
            }else{
                $date = date('Y-m-d H:i:s',strtotime($date));
            }
            //echo "<pre>$bean->sold_datetime";print_r($date);die;
            $bean->sold_datetime = $date;
            
        }
    }
}
