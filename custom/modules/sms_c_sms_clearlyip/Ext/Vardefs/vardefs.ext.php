<?php 
 //WARNING: The contents of this file are auto-generated


// Add custom fields to sms_clearlyip module
$dictionary['sms_c_sms_clearlyip'] = array(
    'fields' => array(
        'from_number' => array(
            'name' => 'from_number',
            'vname' => 'LBL_FROM_NUMBER',
            'type' => 'varchar',
            'len' => 50,
            'comment' => 'Sender phone number',
        ),
        'to_number' => array(
            'name' => 'to_number',
            'vname' => 'LBL_TO_NUMBER',
            'type' => 'varchar',
            'len' => 50,
            'comment' => 'Recipient phone number',
        ),
        'type' => array(
            'name' => 'type',
            'vname' => 'LBL_type',
            'type' => 'varchar',
            'len' => 50,
            'comment' => 'Recipient phone number',
        ),
        'message' => array(
            'name' => 'message',
            'vname' => 'LBL_MESSAGE',
            'type' => 'text',
            'comment' => 'SMS body',
        ),
        'external_id' => array(
            'name' => 'external_id',
            'vname' => 'LBL_EXTERNAL_ID',
            'type' => 'varchar',
            'len' => 255,
            'comment' => 'ID from external provider',
        ),
        'related_parent_type' => array(
            'name' => 'related_parent_type',
            'vname' => 'LBL_RELATED_TO_TYPE',
            'type' => 'varchar',
            'len' => 255,
        ),
        'related_parent_id' => array(
            'name' => 'related_parent_id',
            'vname' => 'LBL_RELATED_TO_ID',
            'type' => 'id',
            'len' => 36,
        ),
    ),
);


?>