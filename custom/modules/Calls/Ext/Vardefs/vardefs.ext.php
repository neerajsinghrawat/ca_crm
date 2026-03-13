<?php 
 //WARNING: The contents of this file are auto-generated


// Custom field for storing ClearlyIP Call ID
$dictionary['Call']['fields']['clearlyip_call_id'] = [
    'name' => 'clearlyip_call_id',
    'vname' => 'LBL_CLEARLYIP_CALL_ID',
    'type' => 'varchar',
    'len' => 100,
];

$dictionary['Call']['fields']['call_transcription'] = array(
    'name' => 'call_transcription',
    'vname' => 'LBL_CALL_TRANSCRIPTION',
    'type' => 'text',
    'audited' => false,
    'massupdate' => false,
    'importable' => 'true',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'studio' => 'visible',
    'required' => false,
    'dbType' => 'longtext', // can use 'text' if smaller
    'rows' => 6,
    'cols' => 80,
    'comment' => 'Save Transcription',
);
?>