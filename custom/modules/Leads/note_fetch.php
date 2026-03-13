<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once 'include/entryPoint.php';
require_once 'data/BeanFactory.php';
require_once 'include/utils.php';

global $db, $log, $current_user;

header('Content-Type: application/json; charset=utf-8');

// Accept GET or POST
$noteId = $_GET['note_id'] ?? $_POST['note_id'] ?? '';

if (empty($noteId)) {
    echo json_encode(['success' => false, 'error' => 'Missing note_id']);
    exit;
}

// Basic sanitation
$noteId = preg_replace('/[^A-Za-z0-9-]/', '', $noteId);

try {
    $note = BeanFactory::getBean('Notes', $noteId);
    if (empty($note) || empty($note->id)) {
        echo json_encode(['success' => false, 'error' => 'Note not found']);
        exit;
    }

    // Optionally: restrict to Chat Message names only
    // if ($note->name !== 'Chat Message') { echo json_encode(['success'=>false,'error'=>'Not allowed']); exit; }

    // Return minimal fields; escape server-side only in case
    $desc = $note->description ?? '';
    // Do not strip markup — but return raw and let client escape or render safely.
    // For safety, return description as-is and client will escape to avoid XSS.
    $result = [
        'success' => true,
        'id' => $note->id,
        'name' => $note->name,
        'description' => $desc,
        'date_modified' => $note->date_modified ?? ''
    ];

    echo json_encode($result);
    exit;

} catch (Exception $e) {
    $log->fatal("note_fetch error: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'Server error']);
    exit;
}
