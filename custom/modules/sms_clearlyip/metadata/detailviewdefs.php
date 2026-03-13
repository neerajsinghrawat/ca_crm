<?php
$viewdefs['sms_clearlyip'] = array(
  'DetailView' => array(
    'templateMeta' => array(
      'form' => array('buttons' => array('EDIT','DUPLICATE','DELETE','FIND_DUPLICATES')),
      'maxColumns' => '2',
    ),
    'panels' => array(
      'default' => array(
        array(
          array('name'=>'name', 'label'=>'LBL_NAME'),
          array('name'=>'from_number', 'label'=>'LBL_FROM_NUMBER'),
        ),
        array(
          array('name'=>'to_number', 'label'=>'LBL_TO_NUMBER'),
          array('name'=>'type', 'label'=>'LBL_TYPE'),
        ),
        array(
          array('name'=>'related_parent_type', 'label'=>'LBL_RELATED_TO_TYPE'),
          array('name'=>'related_parent_id', 'label'=>'LBL_RELATED_TO_ID'),
        ),
        array(
          array('name'=>'message', 'label'=>'LBL_MESSAGE'),
        ),
      ),
    ),
  ),
);
