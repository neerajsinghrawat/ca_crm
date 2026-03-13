<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once 'custom/include/EmailSend/email_service.php';

class SaveTradein
{
    public function saveDataAppraisal($bean, $event, $arguments)
    {
    
        global $current_user,$db;

        if (!empty($bean->fetched_row)) {
            return; // Only on new record, not update
        }
        
        if (!empty($_REQUEST['vin']) && !empty($_REQUEST['trade_year']) && !empty($_REQUEST['trade_make'])) {
            $vin            = $db->quote($_REQUEST['vin'] ?? '');
            $vehicle_state  = $db->quote($_POST['appraisal_vehicle_state'] ?? '');
            $has_payoff     = isset($_POST['appraisal_has_payoff']) ? (int)$_POST['appraisal_has_payoff'] : 0;
            $payoff_amount  = $db->quote($_POST['appraisal_payoff_amount'] ?? '');
            $carfax_link    = '';
            $vehicle_year   = $db->quote($_POST['trade_year'] ?? '');
            $vehicle_make   = $db->quote($_POST['trade_make'] ?? '');
            $vehicle_model  = $db->quote($_POST['appraisal_vehicle_model'] ?? '');
            $vehicle_engine = $db->quote($_POST['appraisal_vehicle_engine'] ?? '');
            $mileage              = isset($_POST['appraisal_mileage']) ? (int)$_POST['appraisal_mileage'] : NULL;
            $vehicle_condition    = $db->quote($_POST['appraisal_vehicle_condition'] ?? '');
            $has_modifications    = isset($_POST['appraisal_has_modifications']) ? (int)$_POST['appraisal_has_modifications'] : 0;
            $modification_details = $db->quote($_POST['appraisal_modification_details'] ?? '');
            $appraisal_value = $db->quote($_POST['appraisal_value'] ?? '');
            $appraisal_appraisal_comment = $db->quote($_POST['appraisal_appraisal_comment'] ?? '');


            $appraisalId = create_guid();

            $photoUrls = array();

            if (!empty($_FILES['vehicle_photos_upload']['name'][0])) {

                $allowedExt  = array('jpg','jpeg','png','gif','webp');
                $allowedMime = array(
                    'image/jpeg',
                    'image/png',
                    'image/gif',
                    'image/webp'
                );

                $baseDir = 'upload/trade_in_vehicle_photos/';
                if (!is_dir($baseDir)) {
                    mkdir($baseDir, 0777, true);
                }

                foreach ($_FILES['vehicle_photos_upload']['name'] as $i => $name) {

                    if ($_FILES['vehicle_photos_upload']['error'][$i] !== UPLOAD_ERR_OK) {
                        continue;
                    }

                    $tmp  = $_FILES['vehicle_photos_upload']['tmp_name'][$i];
                    $ext  = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                    $mime = mime_content_type($tmp);

                    if (!in_array($ext, $allowedExt) || !in_array($mime, $allowedMime)) {
                        continue;
                    }

                    if (!getimagesize($tmp)) {
                        continue;
                    }

                    $newName = $appraisalId . '_' . time() . '_' . $i . '.' . $ext;
                    $target  = $baseDir . $newName;

                    if (move_uploaded_file($tmp, $target)) {
                        $photoUrls[] = $target; // relative URL
                    }
                }
            }

            $vehiclePhotos = $db->quote(implode(',', $photoUrls));

            $insertResult = $db->query("
                INSERT INTO ta_trade_appraisal
                (
                    id,
                    vin,
                    vehicle_year,
                    vehicle_make,
                    vehicle_model,
                    vehicle_engine,
                    vehicle_state,
                    has_payoff,
                    payoff_amount,
                    carfax_link,
                    vehicle_photos,
                    mileage,
                    vehicle_condition,
                    has_modifications,
                    modification_details,
                    appraisal_comment,
                    appraisal_value,
                    lead_id,
                    date_entered
                )
                VALUES
                (
                    '$appraisalId',
                    '$vin',
                    '$vehicle_year',
                    '$vehicle_make',
                    '$vehicle_model',
                    '$vehicle_engine',
                    '$vehicle_state',
                    '$has_payoff',
                    '$payoff_amount',
                    '$carfax_link',
                    '$vehiclePhotos',
                    " . ($mileage !== NULL ? $mileage : "NULL") . ",
                    '$vehicle_condition',
                    '$has_modifications',
                    '$modification_details',
                    '$appraisal_appraisal_comment',
                    '$appraisal_value',
                    " . ($bean->id ? "'{$bean->id}'" : "NULL") . ",
                    NOW()
                )
            ");
            $row=array();   
            sendAppraisalEmail($appraisalId, $row, $vin);
            logActivity(
                'ta_trade_appraisal',   // module
                $appraisalId,           // record id
                'create',             // create/edit
                'vin',                  // field
                '',                  // old
                $vin,                  // new
                'create trade in appraisal on lead creation', //description
                $bean->id,//parent_id
                'Leads',//parent_type
                'create trade in appraisal'//parent_type
            );
        }
        
    }
}
