<?php
$listViewDefs ['AOS_Products'] =
array(
  'NAME' =>
  array(
    'width' => '15%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'STATUS' =>
  array(
    'width' => '10%',
    'label' => 'LBL_STATUS',
    'default' => true,
  ),
  'SOLD' =>
  array(
    'width' => '10%',
    'label' => 'LBL_SOLD',
    'default' => true,
  ),
  'sold_datetime' =>
  array(
    'width' => '10%',
    'label' => 'LBL_sold_datetime',
    'default' => true,
  ),
  'PART_NUMBER' =>
  array(
    'width' => '10%',
    'label' => 'LBL_VIN',
    'default' => true,
  ),
  'STOCKNUMBER_C' =>
  array(
    'width' => '10%',
    'label' => 'LBL_STOCKNUMBER',
    'default' => true,
  ),
  'COST' =>
  array(
    'width' => '10%',
    'label' => 'LBL_COST',
    'currency_format' => true,
    'default' => true,
  ),
  'PRICE' =>
  array(
    'width' => '10%',
    'label' => 'LBL_PRICE',
    'currency_format' => true,
    'default' => true,
  ),
  'AOS_PRODUCT_CATEGORY_NAME' =>
  array(
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_AOS_PRODUCT_CATEGORYS_NAME',
    'id' => 'AOS_PRODUCT_CATEGORY_ID',
    'link' => true,
    'width' => '10%',
    'default' => true,
    'related_fields' =>
      array(
          'aos_product_category_id',
      ),
  ),
  'CREATED_BY_NAME' =>
  array(
    'width' => '10%',
    'label' => 'LBL_CREATED',
    'default' => true,
    'module' => 'Users',
    'link' => true,
    'id' => 'CREATED_BY',
  ),
  'DATE_ENTERED' =>
  array(
    'width' => '5%',
    'label' => 'LBL_DATE_ENTERED',
    'default' => true,
  ),
);
