<?php
/**
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2024 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

$module_name = 'AOS_Products';
$viewdefs [$module_name] =
array(
  'DetailView' =>
  array(
    'templateMeta' =>
    array(
      'form' =>
      array(
        'buttons' =>
        array(
          0 => 'EDIT',
          1 => 'DUPLICATE',
          2 => 'DELETE',
        ),
      ),
      'maxColumns' => '2',
      'widths' =>
      array(
        0 =>
        array(
          'label' => '10',
          'field' => '30',
        ),
        1 =>
        array(
          'label' => '10',
          'field' => '30',
        ),
      ),
      'useTabs' => true,
      'tabDefs' =>
      array(
        'DEFAULT' =>
        array(
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' =>
    array(
      'default' =>
      array(
        0 =>
        array(
          0 =>
          array(
            'name' => 'name',
            'label' => 'LBL_NAME',
          ),
          1 =>
          array(
            'name' => 'part_number',
            'label' => 'LBL_VIN',
          ),
        ),
        1 =>
        array(
          0 =>
          array(
            'name' => 'aos_product_category_name',
            'label' => 'LBL_AOS_PRODUCT_CATEGORYS_NAME',
          ),
          /*1 =>
          array(
            'name' => 'type',
            'label' => 'LBL_TYPE',
          ),*/
        ),
         2 =>array('stocknumber_c' , 1 =>
          array(
            'name' => 'currency_id',
            'studio' => 'visible',
            'label' => 'LBL_CURRENCY',
          ),),
        3 =>array('year_c', 'make_c'),
        4 =>array('model_c', 'trim_c'),
       5   =>   array('odometer_c', 'specialprice_c'),
        6   => array('exteriorcolor_c', 'interiorcolor_c'),
        7 =>
        array(
          0 =>
          array(
            'name' => 'cost',
            'label' => 'LBL_COST',
          ),
          1 =>
          array(
            'name' => 'price',
            'label' => 'LBL_SPECIALPRICE',
          ),
        ),
         8   =>  array( 0 =>
          array(
            'name' => 'url',
            'label' => 'LBL_PHOTOURLS',
            'displayParams' =>
            array(
             'link_target' => '_blank',
            ),
          ),
        ),
        9   =>  array( 0 =>
          array(
            'name' => 'carlistingurl_c',
            'label' => 'LBL_LISTINGURL',
           ),
        ),
        10 =>
        array(
          0 =>
          array(
            'name' => 'status',
            'label' => 'LBL_STATUS',
          ),
          1 =>
          array(
            'name' => 'sold',
            'label' => 'LBL_SOLD',
          ),
        ),
         11 =>
        array(
          0 =>
          array(
            'name' => 'sold_datetime',
            'label' => 'LBL_sold_datetime',
          ),
          
        ),
        12 =>
        array(
          0 =>
          array(
            'name' => 'contact',
            'label' => 'LBL_CONTACT',
          ),
          'transmission_c'
        
        ),
        
        13 =>
        array(
          0 =>
          array(
            'name' => 'description',
            'label' => 'LBL_WEBADDESCRIPTION',
          ),
        ),
        14=>
        array(
          0 =>
          array(
            'name' => 'product_image',
            'label' => 'LBL_PRODUCT_IMAGE',
            'customCode' => '<img src="{$fields.product_image.value}"/>',
          ),
        ),15 => array(
    0 => array(
        'name' => 'images_gallery',
        'label' => 'LBL_IMAGES_GALLERY',
        'customCode' => '
        {if !empty($bean->gallery_images)}
            <div style="display:flex; flex-wrap:wrap;">
                {foreach from=$bean->gallery_images item=image}
                    <div style="margin:5px; text-align:center;">
                        <a href="{$image.link}" target="_blank">
                            <img src="{$image.url}" style="max-width:150px; max-height:150px; border:1px solid #ccc; padding:2px;" />
                        </a>
                        <div style="font-size:12px;">{$image.name}</div>
                    </div>
                {/foreach}
            </div>
        {else}
            No images found.
        {/if}'
    ),
),
        16=>
        array(
          0 =>
          array(
              'name' => 'photo_url',
              'label' => 'LBL_PHOTO_URL',
              'customCode' => '{$PHOTO_GALLERY_HTML}',
          ),
        ),



      ),
         

    ),
  ),
);
