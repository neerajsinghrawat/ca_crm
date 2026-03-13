<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once 'custom/include/EmailSend/email_service.php';
require_once 'custom/include/Sms/sms_service.php';

class TradeAppraisalHooks
{
    public function saveVehiclePhotos(&$bean, $event, $arguments)
    {
        
        if (empty($bean->lead_id)) {
            $parentType = $_REQUEST['return_module'] ?? '';
            $parentId   = $_REQUEST['return_id'] ?? '';
            if ($parentType === 'Leads' && !empty($parentId)) {
                $bean->lead_id = $parentId;
            }
        }

        

        
        if (empty($_FILES['vehicle_photos_upload']['name'][0])) {
            return;
        }

        $allowedExt  = array('jpg','jpeg','png','gif','webp');
        $allowedMime = array('image/jpeg','image/png','image/gif','image/webp');

        $baseDir = 'upload/trade_in_vehicle_photos/';
        if (!is_dir($baseDir)) {
            mkdir($baseDir, 0777, true);
        }

        $photoUrls = array();

        foreach ($_FILES['vehicle_photos_upload']['name'] as $i => $name) {

            if ($_FILES['vehicle_photos_upload']['error'][$i] !== UPLOAD_ERR_OK) {
                continue;
            }

            $tmp = $_FILES['vehicle_photos_upload']['tmp_name'][$i];
            if (empty($tmp) || !file_exists($tmp)) {
                continue;
            }

            $ext  = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            $mime = mime_content_type($tmp);

            if (!in_array($ext, $allowedExt)) continue;
            if (!in_array($mime, $allowedMime)) continue;
            if (!getimagesize($tmp)) continue;

            $newName = $bean->id . '_' . time() . '_' . $i . '.' . $ext;
            $target  = $baseDir . $newName;

            if (move_uploaded_file($tmp, $target)) {
                $photoUrls[] = $target;
            }
        }

        if (!empty($photoUrls)) {
            $existing = array();

            if (!empty($bean->vehicle_photos)) {
                $existing = array_filter(explode(',', $bean->vehicle_photos));
            }

            $bean->vehicle_photos = implode(',', array_merge($existing, $photoUrls));
        }
    }

    public function sendEmailAppraisal(&$bean, $event, $arguments)
    {
        $row = $bean->fetched_row;

        if (empty($row)) {
            sendAppraisalEmail($bean->id, array(), $bean->vin);
            return;
        }

        $oldValue   = isset($row['appraisal_value']) ? $row['appraisal_value'] : '';
        $newValue   = $bean->appraisal_value;

        $oldComment = isset($row['appraisal_comment']) ? $row['appraisal_comment'] : '';
        $newComment = $bean->appraisal_comment;

        if ($oldValue != $newValue || $oldComment != $newComment) {
            /*$notifyEmails = array(
                'yury@statuslease.com',
                'faisal@statuslease.com',
            );*/
            /*$notifyEmails = array(
                'rawat.neeraj.510@gmail.com'
            );*/
            $notifyEmails = array();
            $notifyPhoneNUmber = array();
            $excludeUserId = $bean->modified_user_id;

            $roleBean = BeanFactory::newBean('ACLRoles');
            $role = $roleBean->retrieve_by_string_fields(['name'=>'Manager']);

            if($role){

                $sql = "SELECT user_id 
                        FROM acl_roles_users 
                        WHERE role_id = '".$role->id."' 
                        AND deleted = 0";

                $res = $GLOBALS['db']->query($sql);

                while($r = $GLOBALS['db']->fetchByAssoc($res)){

                    if($r['user_id'] == $excludeUserId){
                        continue; // jisne submit kiya usko skip
                    }
                    $uBean = BeanFactory::getBean('Users',$r['user_id']);
                    if($uBean && !empty($uBean->email1)){
                        $notifyEmails[] = $uBean->email1;
                    }

                    $salesUser_number = !empty($uBean->phone_work) ? $uBean->phone_work :
                    (!empty($uBean->phone_mobile) ? $uBean->phone_mobile :
                    (!empty($uBean->phone_home) ? $uBean->phone_home :
                    (!empty($uBean->phone_other) ? $uBean->phone_other : null)));

                    if(!empty($salesUser_number)){
                        $notifyPhoneNUmber[] = $salesUser_number; // add salesperson email
                    }
                }
            }

            //echo "<pre>notifyPhoneNUmber";print_r($notifyPhoneNUmber);die;

            if(!empty($bean->lead_id)){

                // Lead bean
                $leadBean = BeanFactory::getBean('Leads', $bean->lead_id);

                if($leadBean && !empty($leadBean->assigned_user_id) && $leadBean->assigned_user_id != $excludeUserId){

                    $salesUser = BeanFactory::getBean('Users', $leadBean->assigned_user_id);
                    if($salesUser && !empty($salesUser->email1)){
                        $notifyEmails[] = $salesUser->email1; // add salesperson email
                    }
                    $salesUser_number = !empty($salesUser->phone_work) ? $salesUser->phone_work :
                    (!empty($salesUser->phone_mobile) ? $salesUser->phone_mobile :
                    (!empty($salesUser->phone_home) ? $salesUser->phone_home :
                    (!empty($salesUser->phone_other) ? $salesUser->phone_other : null)));

                    if($salesUser_number && !empty($salesUser_number)){
                        $notifyPhoneNUmber[] = $salesUser_number; // add salesperson email
                    }

                }
            }

            // remove duplicate emails
            $notifyEmails = array_unique($notifyEmails);
            $notifyPhoneNUmber = array_unique($notifyPhoneNUmber);

            $userName = '';
            if(!empty($bean->modified_user_id)){
                $userBean = BeanFactory::getBean('Users', $bean->modified_user_id);
                if($userBean){
                    $userName = $userBean->first_name.' '.$userBean->last_name;
                }
            }
             $link = $GLOBALS['sugar_config']['site_url'] .
        "/index.php?module=ta_trade_appraisal&action=DetailView&record=" . $bean->id;
            $subject = 'Appraisal Value and comments Updated by '.$userName;
            $body = "
                Hi Team,<br><br>

                Appraisal updated.<br><br>

                VIN: <a href='{$link}'><b>{$bean->vin}</b></a><br>
                Value: <b>{$newValue}</b><br>
                Comments: <b>{$newComment}</b><br><br>

                Thanks
                ";
            $message = "
                Hi Team,

                Appraisal updated.

                VIN:{$bean->vin}
                Value: {$newValue}
                Comments: {$newComment}

                Thanks
                ";

            sendMailToNotifyUsers($notifyEmails, $subject, $body);
            
            sendSmsDirect($notifyPhoneNUmber,$message);
            
            
        }
    }
}

