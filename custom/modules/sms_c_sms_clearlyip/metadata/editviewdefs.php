<?php
$viewdefs['sms_c_sms_clearlyip'] = array(
  'EditView' => array(
    'templateMeta' => array(
      'maxColumns' => '2',
      'widths' => array(array('label'=>'10','field'=>'30'), array('label'=>'10','field'=>'30')),
    ),
    'panels' => array(
      'default' => array(
        array('name','from_number'),
        array('to_number','type'),
        array('related_parent_type','related_parent_id'),
        array(array('name'=>'message','displayParams'=>array('rows'=>6,'cols'=>60))),
      ),
    ),
  ),
);
