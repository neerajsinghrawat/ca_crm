<?php 

include('modules/iv_intrested_vehicle/metadata/detailviewdefs.php'); // Load core DetailView layout


$viewdefs ['iv_intrested_vehicle'] =
array(
  'DetailView' =>
  array(
    'templateMeta' =>
    array(
      'form' =>
      array(
        'buttons' =>
        array(
            'SEND_CONFIRM_OPT_IN_EMAIL' => EmailAddress::getSendConfirmOptInEmailActionLinkDefs('Leads'),
          0 => 'EDIT',
          1 => 'DUPLICATE',
          2 => 'DELETE',
          4 => 'FIND_DUPLICATES',
          6 =>
          array(
            'customCode' => '<input title="{$APP.LBL_MANAGE_SUBSCRIPTIONS}" class="button" onclick="this.form.return_module.value=\'Leads\'; this.form.return_action.value=\'DetailView\';this.form.return_id.value=\'{$fields.id.value}\'; this.form.action.value=\'Subscriptions\'; this.form.module.value=\'Campaigns\'; this.form.module_tab.value=\'Leads\';" type="submit" name="Manage Subscriptions" value="{$APP.LBL_MANAGE_SUBSCRIPTIONS}">',
            'sugar_html' =>
            array(
              'type' => 'submit',
              'value' => '{$APP.LBL_MANAGE_SUBSCRIPTIONS}',
              'htmlOptions' =>
              array(
                'title' => '{$APP.LBL_MANAGE_SUBSCRIPTIONS}',
                'class' => 'button',
                'id' => 'manage_subscriptions_button',
                'onclick' => 'this.form.return_module.value=\'Leads\'; this.form.return_action.value=\'DetailView\';this.form.return_id.value=\'{$fields.id.value}\'; this.form.action.value=\'Subscriptions\'; this.form.module.value=\'Campaigns\'; this.form.module_tab.value=\'Leads\';',
                'name' => '{$APP.LBL_MANAGE_SUBSCRIPTIONS}',
              ),
            ),
          ),
          'AOS_GENLET' =>
          array(
            'customCode' => '<input type="button" class="button" onClick="showPopup();" value="{$APP.LBL_PRINT_AS_PDF}">',
          ),
        ),
        'headerTpl' => 'modules/Leads/tpls/DetailViewHeader.tpl',
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
          'file' => 'modules/Leads/Lead.js',
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
        'LBL_LEAD_INFORMATION' => 
  array(
     0 => array(
        0 => array('name' => 'lead_type', 'label' => 'LBL_LEAD_TYPE'),
        1 => array('name' => 'lead_name', 'label' => 'LBL_LEAD'),
        
      ),
    1 => 
      array(
        0 => array('name' => 'interested_year', 'label' => 'LBL_INTERESTED_YEAR'),
        1 => array('name' => 'interested_make', 'label' => 'LBL_INTERESTED_MAKE'),
      ),
    2 => 
      array(
        0 => array('name' => 'interested_model', 'label' => 'LBL_INTERESTED_MODEL'),
        1 => array('name' => 'stock_number', 'label' => 'LBL_STOCK_NUMBER'),
      ),

    6 => 
      array(
        0 => array('name' => 'current_lease', 'label' => 'LBL_CURRENT_LEASE'),
        1 => array('name' => 'lease_expiry', 'label' => 'LBL_LEASE_EXPIRY'),
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
        0 => array('name' => 'buyers_guide_signed', 'label' => 'LBL_BUYERS_GUIDE_SIGNED'),
        1 => array('name' => 'vehicle_delivered', 'label' => 'LBL_VEHICLE_DELIVERED'),
      ),
    4 => 
      array(
        0 => array('name' => 'delivery_date', 'label' => 'LBL_DELIVERY_DATE')
      ),
    5 => 
      array(
    
        0 => array('name' => 'dmv_lien', 'label' => 'LBL_DMV_LIEN'),
      ),
     6 => array(
            array('name' => 'dealership_c', 'label' => 'LBL_DEALERSHIP'),
            array('name' => 'received_date_c', 'label' => 'LBL_RECEIVED_DATE'),
        ),
       7 => array(
            array('name' => 'caller_state_c', 'label' => 'LBL_CALLER_STATE'),
            array('name' => 'callerid_c', 'label' => 'LBL_CALLERID'),
        ),
        /*8 => array(
            array('name' => 'duration_c', 'label' => 'LBL_DURATION'),
            array('name' => 'caller_state_c', 'label' => 'LBL_CALLER_STATE'),
        ),*/
        8 => array(
           
           0 => 'description',
           
           
        ),
        9 => array(
           
          array('name' => 'call_transcription_c', 'label' => 'LBL_CALL_VALUE'),
          
           
        ),
       10 => array(
            array('name' => 'listing_url_c', 'label' => 'LBL_LISTING_URL'),
             array('name' => 'assigned_user_name', 'label' => 'LBL_ASSIGNED_USER_NAME'),
        ),
       11 =>
        array(
          0 => 'status',
          1 => 'lead_source',
        ),
       12 =>
        array(
          1 => array('name' => 'account_name_c', 'label' => 'LBL_DEALERSHIP'),
        ),
       /*10 => array(
            array('name' => 'lead_url', 'label' => 'LBL_LEAD_URL'),
        ),
       11 => array(
            array('name' => 'comments', 'label' => 'LBL_COMMENTS'),
        ),*/
       

  ),

     


),
),

);


/*

if (!isset($viewdefs['Leads']['DetailView']['panels']['LBL_LEAD_INFORMATION'])) {
    $viewdefs['Leads']['DetailView']['panels']['LBL_LEAD_INFORMATION'] = array();
}

// Append your custom fields to the LBL_LEAD_INFORMATION panel in DetailView
$viewdefs['Leads']['DetailView']['panels']['LBL_LEAD_INFORMATION'][] =
    array(array('name' => 'lead_type', 'label' => 'LBL_LEAD_TYPE'));

$viewdefs['Leads']['DetailView']['panels']['LBL_LEAD_INFORMATION'][] =
    array(array('name' => 'trade_in', 'label' => 'LBL_TRADE_IN'), array('name' => 'trade_year', 'label' => 'LBL_TRADE_YEAR'));
$viewdefs['Leads']['DetailView']['panels']['LBL_LEAD_INFORMATION'][] =
    array(array('name' => 'trade_make', 'label' => 'LBL_TRADE_MAKE'), array('name' => 'trade_miles', 'label' => 'LBL_TRADE_MILES'));
$viewdefs['Leads']['DetailView']['panels']['LBL_LEAD_INFORMATION'][] =
    array(array('name' => 'finance_or_paid', 'label' => 'LBL_FINANCE_OR_PAID'), array('name' => 'finance_lender', 'label' => 'LBL_FINANCE_LENDER'));
$viewdefs['Leads']['DetailView']['panels']['LBL_LEAD_INFORMATION'][] =
    array(array('name' => 'amount_owed', 'label' => 'LBL_AMOUNT_OWED'));

$viewdefs['Leads']['DetailView']['panels']['LBL_LEAD_INFORMATION'][] =
    array(array('name' => 'current_lease', 'label' => 'LBL_CURRENT_LEASE'), array('name' => 'lease_expiry', 'label' => 'LBL_LEASE_EXPIRY'));
$viewdefs['Leads']['DetailView']['panels']['LBL_LEAD_INFORMATION'][] =
    array(array('name' => 'lease_miles_per_year', 'label' => 'LBL_LEASE_MILES_PER_YEAR'));

$viewdefs['Leads']['DetailView']['panels']['LBL_LEAD_INFORMATION'][] =
    array(array('name' => 'interested_year', 'label' => 'LBL_INTERESTED_YEAR'), array('name' => 'interested_make', 'label' => 'LBL_INTERESTED_MAKE'));

$viewdefs['Leads']['DetailView']['panels']['LBL_LEAD_INFORMATION'][] =
    array(array('name' => 'interested_model', 'label' => 'LBL_INTERESTED_MODEL'), array('name' => 'stock_number', 'label' => 'LBL_STOCK_NUMBER'));

$viewdefs['Leads']['DetailView']['panels']['LBL_LEAD_INFORMATION'][] =
    array(array('name' => 'form_of_payment', 'label' => 'LBL_FORM_OF_PAYMENT'));

$viewdefs['Leads']['DetailView']['panels']['LBL_LEAD_INFORMATION'][] =
    array(array('name' => 'appt_test_drive', 'label' => 'LBL_APPT_TEST_DRIVE'), array('name' => 'credit_application', 'label' => 'LBL_CREDIT_APPLICATION'));
$viewdefs['Leads']['DetailView']['panels']['LBL_LEAD_INFORMATION'][] =
    array(array('name' => 'finance_approved', 'label' => 'LBL_FINANCE_APPROVED'), array('name' => 'deposit_taken', 'label' => 'LBL_DEPOSIT_TAKEN'));
$viewdefs['Leads']['DetailView']['panels']['LBL_LEAD_INFORMATION'][] =
    array(array('name' => 'transport_setup', 'label' => 'LBL_TRANSPORT_SETUP'), array('name' => 'dmv_completed', 'label' => 'LBL_DMV_COMPLETED'));
$viewdefs['Leads']['DetailView']['panels']['LBL_LEAD_INFORMATION'][] =
    array(array('name' => 'dmv_lien', 'label' => 'LBL_DMV_LIEN'));


$viewdefs['Leads']['DetailView']['panels']['LBL_LEAD_INFORMATION'][] =
    array(
        array('name' => 'dealership_c', 'label' => 'LBL_DEALERSHIP'), 
        array('name' => 'received_date_c', 'label' => 'LBL_RECEIVED_DATE')
    );
$viewdefs['Leads']['DetailView']['panels']['LBL_LEAD_INFORMATION'][] =
    array(
        array('name' => 'duration_c', 'label' => 'LBL_DURATION'), 
        array('name' => 'callerid_c', 'label' => 'LBL_CALLERID')
    );
$viewdefs['Leads']['DetailView']['panels']['LBL_LEAD_INFORMATION'][] =
    array(
        array('name' => 'caller_phone_c', 'label' => 'LBL_CALLER_PHONE'), 
        array('name' => 'caller_state_c', 'label' => 'LBL_CALLER_STATE')
    );
$viewdefs['Leads']['DetailView']['panels']['LBL_LEAD_INFORMATION'][] =
    array(
        array('name' => 'call_transcription_c', 'label' => 'LBL_CALL_VALUE')
    );
$viewdefs['Leads']['DetailView']['panels']['LBL_LEAD_INFORMATION'][] =
    array(
        array('name' => 'listing_url_c', 'label' => 'LBL_LISTING_URL')
    );
*/