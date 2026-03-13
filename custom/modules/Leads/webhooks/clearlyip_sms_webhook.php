<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once 'include/entryPoint.php';
require_once 'include/utils.php';
require_once 'data/BeanFactory.php';

require_once('custom/include/custom_utils.php');

global $log, $db;

// 1) Read raw JSON payload
$rawBody = file_get_contents('php://input');
//$rawBody =' {"uuid":"9a0f3995-9f00-4ddb-ba2c-36e95700409d","type":"SMS","from":"17183147808","to":"+13476144062","content":"Hello Deepak","media":[]}';
$log->fatal('ClearlyIP SMS webhook RAW: ' . $rawBody);

/*
Thu Dec  4 19:07:14 2025 [1648934][-none-][FATAL] ClearlyIP SMS webhook RAW: 
{"uuid":"9e27b427-2d53-4983-b583-3a1d035b885c",
"type":"SMS",
"from":"13476144062",
"to":"+13476144062",
"content":"New Lead Assigned to You\n\nHello ILYA YAGYAYEV>
T
Fri Dec  5 03:23:30 2025 [1657293][-none-][FATAL] ClearlyIP SMS webhook RAW: {"uuid":"9a0f3995-9f00-4ddb-ba2c-36e95700409d","type":"SMS","from":"17183147808","to":"+13476144062","content":"Hello Deepak","media":[]}
Fri Dec  5 03:23:30 2025 [1657293][-none-][FATAL] ClearlyIP SMS webhook: Invalid token

*/

$data = json_decode($rawBody, true);
//echo "<pre>";print_r($data);die;
/*
if (json_last_error() !== JSON_ERROR_NONE || empty($data)) {
    $log->fatal('ClearlyIP SMS webhook: Invalid JSON');
    header('HTTP/1.1 400 Bad Request');
    echo 'Invalid JSON';
    sugar_cleanup(true);
}
*/

if (json_last_error() !== JSON_ERROR_NONE) {
    $log->fatal('ClearlyIP SMS webhook: Invalid JSON');
    header('HTTP/1.1 400 Bad Request');
    echo "JSON error: " . json_last_error_msg();
     sugar_cleanup(true);
}

if (empty($data)) {
     $log->fatal('ClearlyIP SMS webhook: empty Data');
    header('HTTP/1.1 400 Bad Request');
    echo "Data empty";
     sugar_cleanup(true);
}



// (Optional) Simple security token ?entryPoint=clearlyip_sms_webhook&token=YOUR_SECRET
$valid_token = '9f4c0d7e3b12f8e4c';
$received = isset($_GET['token']) ? $_GET['token'] : null;
$received_trim = trim($received);

// exact, timing-safe compare
/*if (!hash_equals($valid_token, $received_trim)) {
    $log->fatal('ClearlyIP SMS webhook: Invalid token');
    header('HTTP/1.1 403 Forbidden');
    echo 'Forbidden';
    sugar_cleanup(true);
}*/

// 2) Extract fields from payload
$uuid    = isset($data['uuid'])    ? $data['uuid']    : '';
$type    = isset($data['type'])    ? $data['type']    : '';
$from    = isset($data['from'])    ? $data['from']    : '';
$to      = isset($data['to'])      ? $data['to']      : '';
$content = isset($data['content']) ? $data['content'] : '';
$media   = isset($data['media'])   ? $data['media']   : array();

// Normalize phone numbers for matching
function normalize_phone($number)
{
    // remove spaces, dash, parentheses, plus, etc.
    $number = preg_replace('/[^0-9]/', '', $number);
    return $number;
}

$fromNorm = getLast10Digit($from);
//$toNorm   = getLast10Digit($to);
$toNorm   = normalize_phone($to);
// 3) Try to find related Lead / Contact / Account by phone number
$parentType = null;
$parentId   = null;

function findByPhone($module, $phoneNorm)
{
    global $db;

    $phoneNorm = preg_replace('/[^0-9]/', '', $phoneNorm);
    if (empty($phoneNorm)) {
        return null;
    }
    $query = "SELECT id, first_name, last_name,
          phone_mobile, phone_work, phone_home, phone_other
          FROM leads 
          WHERE deleted = 0 
          AND (
              RIGHT(REGEXP_REPLACE(phone_mobile, '[^0-9]', ''), 10) = $phoneNorm
              OR RIGHT(REGEXP_REPLACE(phone_work, '[^0-9]', ''), 10) = $phoneNorm
              OR RIGHT(REGEXP_REPLACE(phone_home, '[^0-9]', ''), 10) = $phoneNorm
              OR RIGHT(REGEXP_REPLACE(phone_other, '[^0-9]', ''), 10) = $phoneNorm
          )";
    
    $result = $db->query($query);
    $row = $db->fetchByAssoc($result);

    if ($row && !empty($row['id'])) {
        // Return a Lead bean (or return $row if you prefer)
        return BeanFactory::getBean('Leads', $row['id']);
    }

    return null;
}
/* ===============================
   ACTION KEYWORDS
================================ */
$timestamp = date("Y-m-d H:i:s");
if ($fromNorm) {
    $lead = findByPhone('Leads', $fromNorm);
    if ($lead) {

        $leadname = $lead->first_name.' '.$lead->last_name;

        $leadname=(empty($leadname))?$fromNorm:$leadname;
        $leadurl= 'index.php?module=Leads&action=DetailView&record='.$lead->id.'&opensms=1';

        $alert = BeanFactory::newBean('Alerts');
        $alert->name = 'New SMS '.$leadname;
        $alert->description = $content;
        $alert->target_module = 'Leads';
        $alert->url_redirect = $leadurl;
        $alert->assigned_user_id = $lead->assigned_user_id;
        $alert->type = 'info'; 
        $alert->is_read = 0; 
        $alert->reminder_id = $lead->id; 
        $alert->save();


        $apiTaskResult = createTaskFromMessageAPI($lead->id, $content);

        if (strtolower($content) == 'yes' && $lead->is_sms_service_on != 1) {

            $lead_data = BeanFactory::getBean('Leads', $lead->id);
            $lead_data->is_sms_service_on = 1;
            $lead_data->save();
            logActivity(
                'leads',   // module
                $lead->id,           // record id
                'sms receive',             // create/edit
                'is_sms_service_on',                  // field
                '',                  // old
                '1',                  // new
                'User Send Yes', //description
                $lead->id,//parent_id
                'Leads',//parent_type
                'User message service ON'//parent_type
            );
        } 
        if (strtolower($content) == 'StatusSTOP' && $lead->is_sms_service_on == 1) {

            $lead_data = BeanFactory::getBean('Leads', $lead->id);
            $lead_data->is_sms_service_on = 0;
            $lead_data->save();
            logActivity(
                'leads',   // module
                $lead->id,           // record id
                'sms receive',             // create/edit
                'is_sms_service_on',                  // field
                '1',                  // old
                '0',                  // new
                'User Send STOP Messages', //description
                $lead->id,//parent_id
                'Leads',//parent_type
                'User message service OFF'//parent_type
            );
        } 

        if (!$apiTaskResult['success']) {
            $log->fatal("Task API Failed: HTTP ".$apiTaskResult['httpCode']." | ".$apiTaskResult['response']." | Error: ".$apiTaskResult['error']);
        }

        $parentType = 'Leads';
        $parentId   = $lead->id;

        $q = "SELECT id FROM notes
          WHERE parent_type = 'Leads'
            AND name = 'SMS History'
            AND parent_id = '{$parentId}'
            AND deleted = 0
          LIMIT 1";
        try {
            $r = $db->query($q);
            $row = $db->fetchByAssoc($r);
        } catch (Exception $e) {
            $log->fatal('appendToChatHistoryNote select error: ' . $e->getMessage());
            $row = null;
        }

        if ($row && !empty($row['id'])) {
            $note = BeanFactory::getBean('Notes', $row['id']);
        }else{
            $note = BeanFactory::newBean('Notes');
            $note->name = 'SMS History';
            $note->parent_type = 'Leads';
            $note->parent_id = $parentId;
            $note->description = '';
            $note->assigned_user_id = $lead->assigned_user_id;
        }
        $newBlock = "\n\n--- IN | From: {$fromNorm} | To: {$toNorm} | At: {$timestamp} ---\n{$content}\n";
        
        $uploadDir = 'upload/sms_image/';        

        // Ensure directory exists and writable
        if (!is_dir($uploadDir)) {
            @mkdir($uploadDir, 0755, true);
        }

        if (!is_writable($uploadDir)) {
            $log->fatal("ClearlyIP SMS webhook: upload dir not writable: {$uploadDir}");
            // still continue but don't try to save files
        }

        // Process media items and save to upload dir, append <img> tag to newBlock
        $imageBlocks = [];
        if (!empty($media) && is_array($media)) {
            
            foreach ($media as $media_item) {
                $filename = $media_item['filename'] ?? ('attachment_' . time());
                $raw = $media_item['data'] ?? '';

                if (empty($raw)) {
                    $log->warn("ClearlyIP SMS webhook: Media item found but data is empty for {$filename}.");
                    continue;
                }

                // Normalize and prepare base64 body
                $raw = trim($raw);
                $raw = str_replace(' ', '+', $raw);

                $mime = null;
                $b64 = null;
                if (preg_match('#^data:(image/[\w+\-\.]+);base64,(.*)$#s', $raw, $m)) {
                    $mime = $m[1];
                    $b64 = $m[2];
                } else {
                    $b64 = $raw;
                }

                $b64 = preg_replace('/\s+/', '', $b64);
                $padding = strlen($b64) % 4;
                if ($padding > 0) {
                    $b64 .= str_repeat('=', 4 - $padding);
                }

                $cleaned_b64 = preg_replace('/[^a-zA-Z0-9\/\+=]/', '', $b64);
                $decoded = base64_decode($cleaned_b64, true);
                if ($decoded === false) {
                    $log->warn("ClearlyIP SMS webhook: base64_decode failed for {$filename}.");
                    continue;
                }

                $info = @getimagesizefromstring($decoded);
                if ($info === false) {
                    $log->warn("ClearlyIP SMS webhook: Decoded data for {$filename} is not a valid image.");
                    continue;
                }
                $mime = $mime ?? ($info['mime'] ?? 'application/octet-stream');

                // sanitize filename and build unique name
                $ext = '';
                if (strpos($mime, '/') !== false) {
                    $ext = substr($mime, strpos($mime, '/') + 1);
                    // normalize common variants
                    if ($ext === 'jpeg') $ext = 'jpg';
                }
                $baseName = pathinfo($filename, PATHINFO_FILENAME);
                $safeBase = preg_replace('/[^A-Za-z0-9_\-]/', '_', $baseName);
                $uniqueName = time() . '_' . bin2hex(random_bytes(4)) . '_' . $safeBase;
                $finalName = $uniqueName . ($ext ? '.' . $ext : '');

                $fullPath = rtrim($uploadDir, '/') . '/' . $finalName;

                // Write file
                $written = @file_put_contents($fullPath, $decoded);
                if ($written === false) {
                    $log->warn("ClearlyIP SMS webhook: Failed to write file to {$fullPath}");
                    continue;
                }

                // Try to set permisssions
                @chmod($fullPath, 0644);

                // Build accessible URL for the uploaded file.
                // Usually Sugar's upload/ is served as /upload/<file>. Adjust if your webserver serves from different path.
                $webPath = 'upload/sms_image/' . rawurlencode($finalName);

                // Append HTML snippet to newBlock (display inline)
                $escFilename = htmlspecialchars($filename, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                $imageBlocks[] = "
                    <a href=\"{$webPath}\" style=\"margin:4px; display:inline-block;\">
                        <img src=\"{$webPath}\" alt=\"{$escFilename}\"
                             style=\"width:70px; height:auto; border:1px solid #ccc; border-radius:4px;\" />
                    </a>
                ";
                /*$newBlock .= "<a style='font-size:11px; color:#999;' href=\"{$webPath}\" target=\"_blank\">";
                $newBlock .= "<img src=\"{$webPath}\" alt=\"{$escFilename}\" style=\"max-width:70px;height:auto;border:1px solid #ccc;\" /></a>\n";*/

                // Optionally, you can also save the file metadata to a custom DB table or custom field here.
                // e.g. log the filename and note id after saving the note.
            }
        }

        if (!empty($imageBlocks)) {
            $newBlock .= "<div class='sms-image-grid' style='margin-top:6px;'>";

            foreach (array_chunk($imageBlocks, 3) as $row) {
                $newBlock .= "<div class='sms-image-row' style='display:flex; gap:6px; margin-bottom:6px;'>";
                foreach ($row as $imgHtml) {
                    $newBlock .= $imgHtml;
                }
                $newBlock .= "</div>";
            }

            $newBlock .= "</div>";
        }
        //echo "<pre>";print_r($newBlock);die;
        $note->description .= $newBlock;
        $note->save();
    }else{

        /*$note = BeanFactory::newBean('Notes');
        $note->name        = "SMS History";
        $note->description = $content;
        $note->assigned_user_id = $GLOBALS['current_user']->id ?: '1';
        $note->save();*/
        if ($fromNorm != $toNorm) {
            $alert_n = BeanFactory::newBean('Alerts');
            $alert_n->name = 'New SMS from:'.$fromNorm.' TO:'.$toNorm;
            $alert_n->description = $content;
            $alert_n->target_module = 'Leads';
            $alert_n->type = 'info'; 
            $alert_n->is_read = 1; 
            $alert_n->save();
        }
    }
    
}








header('HTTP/1.1 200 OK');
echo 'OK';
sugar_cleanup(true);
