<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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

$viewdefs ['Contacts'] =
array(
  'DetailView' =>
  array(
    'templateMeta' =>
    array(
      'form' =>
      array(
        'buttons' =>
        array(
            'SEND_CONFIRM_OPT_IN_EMAIL' => EmailAddress::getSendConfirmOptInEmailActionLinkDefs('Contacts'),
          0 => 'EDIT',
          1 => 'DUPLICATE',
          2 => 'DELETE',
          3 => 'FIND_DUPLICATES',
          4 =>
          array(
            'customCode' => '<input type="submit" class="button" title="{$APP.LBL_MANAGE_SUBSCRIPTIONS}" onclick="this.form.return_module.value=\'Contacts\'; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$fields.id.value}\'; this.form.action.value=\'Subscriptions\'; this.form.module.value=\'Campaigns\'; this.form.module_tab.value=\'Contacts\';" name="Manage Subscriptions" value="{$APP.LBL_MANAGE_SUBSCRIPTIONS}"/>',
            'sugar_html' =>
            array(
              'type' => 'submit',
              'value' => '{$APP.LBL_MANAGE_SUBSCRIPTIONS}',
              'htmlOptions' =>
              array(
                'class' => 'button',
                'id' => 'manage_subscriptions_button',
                'title' => '{$APP.LBL_MANAGE_SUBSCRIPTIONS}',
                'onclick' => 'this.form.return_module.value=\'Contacts\'; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$fields.id.value}\'; this.form.action.value=\'Subscriptions\'; this.form.module.value=\'Campaigns\'; this.form.module_tab.value=\'Contacts\';',
                'name' => 'Manage Subscriptions',
              ),
            ),
          ),
          'AOS_GENLET' =>
          array(
            'customCode' => '<input type="button" class="button" onClick="showPopup();" value="{$APP.LBL_PRINT_AS_PDF}">',
          ),
          'AOP_CREATE' =>
          array(
            'customCode' => '{if !$fields.joomla_account_id.value && $AOP_PORTAL_ENABLED}<input type="submit" class="button" onClick="this.form.action.value=\'createPortalUser\';" value="{$MOD.LBL_CREATE_PORTAL_USER}"> {/if}',
            'sugar_html' =>
            array(
              'type' => 'submit',
              'value' => '{$MOD.LBL_CREATE_PORTAL_USER}',
              'htmlOptions' =>
              array(
                'title' => '{$MOD.LBL_CREATE_PORTAL_USER}',
                'class' => 'button',
                'onclick' => 'this.form.action.value=\'createPortalUser\';',
                'name' => 'buttonCreatePortalUser',
                'id' => 'createPortalUser_button',
              ),
              'template' => '{if !$fields.joomla_account_id.value && $AOP_PORTAL_ENABLED}[CONTENT]{/if}',
            ),
          ),
          'AOP_DISABLE' =>
          array(
            'customCode' => '{if $fields.joomla_account_id.value && !$fields.portal_account_disabled.value && $AOP_PORTAL_ENABLED}<input type="submit" class="button" onClick="this.form.action.value=\'disablePortalUser\';" value="{$MOD.LBL_DISABLE_PORTAL_USER}"> {/if}',
            'sugar_html' =>
            array(
              'type' => 'submit',
              'value' => '{$MOD.LBL_DISABLE_PORTAL_USER}',
              'htmlOptions' =>
              array(
                'title' => '{$MOD.LBL_DISABLE_PORTAL_USER}',
                'class' => 'button',
                'onclick' => 'this.form.action.value=\'disablePortalUser\';',
                'name' => 'buttonDisablePortalUser',
                'id' => 'disablePortalUser_button',
              ),
              'template' => '{if $fields.joomla_account_id.value && !$fields.portal_account_disabled.value && $AOP_PORTAL_ENABLED}[CONTENT]{/if}',
            ),
          ),
          'AOP_ENABLE' =>
          array(
            'customCode' => '{if $fields.joomla_account_id.value && $fields.portal_account_disabled.value && $AOP_PORTAL_ENABLED}<input type="submit" class="button" onClick="this.form.action.value=\'enablePortalUser\';" value="{$MOD.LBL_ENABLE_PORTAL_USER}"> {/if}',
            'sugar_html' =>
            array(
              'type' => 'submit',
              'value' => '{$MOD.LBL_ENABLE_PORTAL_USER}',
              'htmlOptions' =>
              array(
                'title' => '{$MOD.LBL_ENABLE_PORTAL_USER}',
                'class' => 'button',
                'onclick' => 'this.form.action.value=\'enablePortalUser\';',
                'name' => 'buttonENablePortalUser',
                'id' => 'enablePortalUser_button',
              ),
              'template' => '{if $fields.joomla_account_id.value && $fields.portal_account_disabled.value && $AOP_PORTAL_ENABLED}[CONTENT]{/if}',
            ),
          ),
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
      'includes' =>
      array(
        0 =>
        array(
          'file' => 'modules/Contacts/Contact.js',
        ),
      ),
      'useTabs' => false,
      'tabDefs' =>
      array(
        'LBL_CONTACT_INFORMATION' =>
        array(
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_PANEL_ADVANCED' =>
        array(
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_PANEL_ASSIGNMENT' =>
        array(
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' =>
    array(

'LBL_CONTACT_INFORMATION' =>
      array(
        0 =>
        array(
           0 =>
          array(
            'name' => 'first_name',
            'comment' => 'First name of the contact',
            'label' => 'LBL_FIRST_NAME',
          ),
          1 =>
          array(
            'name' => 'last_name',
            'comment' => 'Last name of the contact',
            'label' => 'LBL_LAST_NAME',
          ),
        ),
        1 =>
        array(
          0 => 'phone_mobile',
          1 => 'phone_work',
        ),
         2 =>
        array(
          0 => 'email1',
          1 =>
          array(
            'name' => 'account_name',
            'label' => 'LBL_ACCOUNT_NAME',
          ),
        ),
        3 =>
        array(
          0 =>
          array(
            'name' => 'primary_address_street',
            'hideLabel' => true,
            'type' => 'address',
            'displayParams' =>
            array(
              'key' => 'primary',
              'rows' => 2,
              'cols' => 30,
              'maxlength' => 150,
            ),
          ),
          1 =>
          array(
            'name' => 'alt_address_street',
            'hideLabel' => true,
            'type' => 'address',
            'displayParams' =>
            array(
              'key' => 'alt',
              'copy' => 'primary',
              'rows' => 2,
              'cols' => 30,
              'maxlength' => 150,
            ),
          ),
        ),
       
        4 =>
        array(
          0 => 'status',
          1 => 'lead_source',
        ),

        5 =>
        array(
          0 =>
          array(
            'name' => 'report_to_name',
            'label' => 'LBL_REPORTS_TO',
          ),
         1 =>
          array(
            'name' => 'description',
            'comment' => 'Full text of the note',
            'label' => 'LBL_DESCRIPTION',
          ),
        ),

       6 =>
        array(
         0 =>
          array(
            'name' => 'date_entered',
            'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
            'label' => 'LBL_DATE_ENTERED',
          ),
          1 =>
          array(
            'name' => 'date_modified',
            'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
            'label' => 'LBL_DATE_MODIFIED',
          ),
         ),

      ),



      'LBL_LEAD_INFORMATION' => 
  array(
     0 => array(
        0 => array('name' => 'lead_type', 'label' => 'LBL_LEAD_TYPE'),
        1 => array('name' => 'trade_in', 'label' => 'LBL_TRADE_IN'),
      ),
       1 => 
          array(
            'name' => 'trade_year', 
            'label' => 'LBL_TRADE_YEAR',
          ),
      2 => 
      array(
        0 => array('name' => 'trade_make', 'label' => 'LBL_TRADE_MAKE'),
        1 => array('name' => 'trade_miles', 'label' => 'LBL_TRADE_MILES'),
      ),
    3 => 
      array(
        0 => array('name' => 'finance_or_paid', 'label' => 'LBL_FINANCE_OR_PAID'),
        1 => array('name' => 'finance_lender', 'label' => 'LBL_FINANCE_LENDER'),
      ),
    4 => 
      array(
        0 => array('name' => 'current_lease', 'label' => 'LBL_CURRENT_LEA'),
        1 => array('name' => 'lease_expiry', 'label' => 'LBL_LEASE_EXPIRY'),
      ),
    5 => 
      array(
        0 => array('name' => 'interested_year', 'label' => 'LBL_INTERESTED_YEAR'),
        1 => array('name' => 'interested_make', 'label' => 'LBL_INTERESTED_MAKE'),
      ),
    6 => 
      array(
        0 => array('name' => 'interested_model', 'label' => 'LBL_INTERESTED_MODEL'),
        1 => array('name' => 'stock_number', 'label' => 'LBL_STOCK_NUMBER'),
      ),

    7 => 
      array(
        0 => array('name' => 'lease_miles_per_year', 'label' => 'LBL_LEASE_MILES_PER_YEAR'),
        1 => array('name' => 'vehicle_c', 'label' => 'LBL_VEHICLE'),
      ),
      

    8 => 
      array(
       
       array('name' => 'listed_price_c', 'label' => 'LBL_LISTED_PRICE'),
      array('name' => 'market_value_c', 'label' => 'LBL_MARKET_VALUE'),
      ),

    9 => 
      array(
        0 => array('name' => 'form_of_payment', 'label' => 'LBL_FORM_OF_PAYMENT'),
        1 => array('name' => 'amount_owed', 'label' => 'LBL_AMOUNT_OWED'),
      ),
    10 => 
      array(
        0 => array('name' => 'product_name_c', 'label' => 'LBL_PRODUCT'),
        1 => array('name' => 'stock_no_c', 'label' => 'LBL_STOCK_NO'),
      ),
  ),

  'LBL_LEAD_INFORMATION_TASK' => 
  array(
    0 => 
      array(
        0 => array('name' => 'appt_test_drive', 'label' => 'LBL_APPT_TEST_DRIVE'),
        1 => array('name' => 'credit_application', 'label' => 'LBL_CREDIT_APPLICATION'),
      ),
    1 => 
      array(
        0 => array('name' => 'finance_approved', 'label' => 'LBL_FINANCE_APPROVED'),
        1 => array('name' => 'deposit_taken', 'label' => 'LBL_DEPOSIT_TAKEN'),
      ),
    2 => 
      array(
        0 => array('name' => 'transport_setup', 'label' => 'LBL_TRANSPORT_SETUP'),
        1 => array('name' => 'dmv_completed', 'label' => 'LBL_DMV_COMPLETED'),
      ),
    3 => 
      array(
    
        0 => array('name' => 'dmv_lien', 'label' => 'LBL_DMV_LIEN'),
      ),
     4 => array(
            array('name' => 'dealership_c', 'label' => 'LBL_DEALERSHIP'),
            array('name' => 'received_date_c', 'label' => 'LBL_RECEIVED_DATE'),
        ),
       5 => array(
            array('name' => 'duration_c', 'label' => 'LBL_DURATION'),
            array('name' => 'callerid_c', 'label' => 'LBL_CALLERID'),
        ),
        6 => array(
            array('name' => 'caller_phone_c', 'label' => 'LBL_CALLER_PHONE'),
            array('name' => 'caller_state_c', 'label' => 'LBL_CALLER_STATE'),
        ),
        7 => array(
           
          
           array('name' => 'call_transcription_c', 'label' => 'LBL_CALL_VALUE'),
           
        ),
       8 => array(
            array('name' => 'listing_url_c', 'label' => 'LBL_LISTING_URL'),
             array('name' => 'assigned_user_name', 'label' => 'LBL_ASSIGNED_USER_NAME'),
        ),
       

  ),


   
    ),
  ),
);
