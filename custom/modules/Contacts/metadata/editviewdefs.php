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
  'EditView' =>
  array(
    'templateMeta' =>
    array(
      'form' =>
      array(
        'hidden' =>
        array(
          0 => '<input type="hidden" name="opportunity_id" value="{$smarty.request.opportunity_id}">',
          1 => '<input type="hidden" name="case_id" value="{$smarty.request.case_id}">',
          2 => '<input type="hidden" name="bug_id" value="{$smarty.request.bug_id}">',
          3 => '<input type="hidden" name="email_id" value="{$smarty.request.email_id}">',
          4 => '<input type="hidden" name="inbound_email_id" value="{$smarty.request.inbound_email_id}">',
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
      ),
    ),
    'panels' =>
    array(
      'lbl_contact_information' =>
      array(
        0 =>
        array(
          0 =>
          array(
            'name' => 'first_name',
            'customCode' => '{html_options name="salutation" id="salutation" options=$fields.salutation.options selected=$fields.salutation.value}&nbsp;<input name="first_name"  id="first_name" size="25" maxlength="25" type="text" value="{$fields.first_name.value}">',
          ),
          1 =>
          array(
            'name' => 'last_name',
          ),
        ),
        1 =>
        array(
          0 =>
          array(
            'name' => 'phone_work',
            'comment' => 'Work phone number of the contact',
            'label' => 'LBL_OFFICE_PHONE',
          ),
          1 =>
          array(
            'name' => 'phone_mobile',
            'comment' => 'Mobile phone number of the contact',
            'label' => 'LBL_MOBILE_PHONE',
          ),
        ),
       2 =>
        array(
         0 =>
          array(
            'name' => 'email1',
            'studio' => 'false',
            'label' => 'LBL_EMAIL_ADDRESS',
          ),
          1 => 'lead_source',
        ),
        3 =>
        array(
          0 =>
          array(
            'name' => 'account_name',
            'displayParams' =>
            array(
              'key' => 'billing',
              'copy' => 'primary',
              'billingKey' => 'primary',
              'additionalFields' =>
              array(
                'phone_office' => 'phone_work',
              ),
            ),
          ),
          1 =>
          array(
            'name' => 'phone_fax',
            'comment' => 'Contact fax number',
            'label' => 'LBL_FAX_PHONE',
          ),
        ),
       
        5 =>
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
        6 =>
        array(
          0 =>
          array(
            'name' => 'description',
            'label' => 'LBL_DESCRIPTION',
          ),
        
        ),
        7 =>
        array(
          0 =>
          array(
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO_NAME',
          ),
          1 =>
          array(
            'name' => 'report_to_name',
            'label' => 'LBL_REPORTS_TO',
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
