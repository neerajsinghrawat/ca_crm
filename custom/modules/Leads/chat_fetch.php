<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once 'include/entryPoint.php';
require_once 'data/BeanFactory.php';
require_once 'include/utils.php';

global $db, $log;

header('Content-Type: application/json; charset=utf-8');

$leadId = $_GET['lead_id'] ?? $_POST['lead_id'] ?? '';
$todo = $_GET['todo'] ?? $_POST['todo'] ?? 0;
if (!$leadId) {
    echo json_encode(['success'=>false,'error'=>'Missing lead_id']);
    exit;
}

$leadQ = $db->quote($leadId);

try {
    if ($todo == 1){
        $q = "SELECT id, description, date_modified FROM notes
          WHERE parent_type='iv_intrested_vehicle' AND parent_id='{$leadQ}'
            AND name='TODO History' AND deleted=0
          LIMIT 1";
    }else{
        $q = "SELECT id, description, date_modified FROM notes
          WHERE parent_type='Leads' AND parent_id='{$leadQ}'
            AND name='SMS History' AND deleted=0
          LIMIT 1";
    }
    
    $res = $db->query($q);
    $row = $db->fetchByAssoc($res);

    $db->query("
    UPDATE alerts
    SET is_read = 1
    WHERE deleted = 0
      AND reminder_id = '{$leadQ}'
      AND is_read = 0
    ");
} catch (Exception $e) {
    $log->fatal('chat_fetch select error: '.$e->getMessage());
    echo json_encode(['success'=>false,'error'=>'DB error']);
    exit;
}

$items = [];

if ($row && !empty($row['description'])) {
    $desc = $row['description'];
    $desc = str_replace("\r\n", "\n", $desc);
    $desc = str_replace("\r", "\n", $desc);
    $desc = html_entity_decode($desc, ENT_QUOTES);
    // Pattern A parser
    $pattern = '/---\s*(IN|OUT)\s*\|\s*From:\s*(.*?)\s*\|\s*To:\s*(.*?)\s*\|\s*At:\s*(.*?)\s*---\s*\n(.*?)(?=(\n\n---|$))/si';

    if (preg_match_all($pattern, $desc, $matches, PREG_SET_ORDER)) {
        foreach ($matches as $m) {
            $direction = strtolower(trim($m[1])) === 'out' ? 'outbound' : 'inbound';
            $items[] = [
                'type' => 'chat',
                'direction' => $direction,
                'from' => trim($m[2]),
                'to' => trim($m[3]),
                'date' => trim($m[4]),
                'body' => rtrim($m[5], "\n"),
            ];
        }
    } else {
        // fallback: whole description as a single inbound item
        if (trim($desc) !== '') {
            $items[] = [
                'type' => 'chat',
                'direction' => 'inbound',
                'from' => '',
                'to' => '',
                'date' => $row['date_modified'] ?? '',
                'body' => trim($desc)
            ];
        }
    }
}
$leadBean = BeanFactory::getBean('Leads',$leadId);
$is_sms_service_on = (!empty($leadBean->is_sms_service_on) && $leadBean->is_sms_service_on==1)?1:0;

// Sort by date
usort($items, function($a,$b){
    $ta = strtotime($a['date'] ?? '') ?: 0;
    $tb = strtotime($b['date'] ?? '') ?: 0;
    if ($ta == $tb) return 0;
    return ($ta < $tb) ? -1 : 1;
});
echo json_encode(['success'=>true,'items'=>$items,'is_sms_service_on'=>$is_sms_service_on]);
exit;
