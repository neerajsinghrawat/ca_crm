<?php
include('modules/iv_intrested_vehicle/metadata/editviewdefs.php'); // Load core layout

$viewdefs ['iv_intrested_vehicle'] =
array(
  'EditView' =>
  array(
    'templateMeta' =>
    array(
        'enctype' => 'multipart/form-data',
       'includes' => array(
            
        array('file' => 'custom/modules/Leads/js/editview_custom.js'),
        array('file' => 'custom/modules/Leads/css/EditView.css'),
        array('file' => 'custom/modules/ta_trade_appraisal/js/vin_verify.js'),
        ), 
      'form' =>
      array(
        'hidden' =>
        array(
          0 => '<input type="hidden" name="prospect_id" value="{if isset($smarty.request.prospect_id)}{$smarty.request.prospect_id}{else}{$bean->prospect_id}{/if}">',
          1 => '<input type="hidden" name="account_id" value="{if isset($smarty.request.account_id)}{$smarty.request.account_id}{else}{$bean->account_id}{/if}">',
          2 => '<input type="hidden" name="contact_id" value="{if isset($smarty.request.contact_id)}{$smarty.request.contact_id}{else}{$bean->contact_id}{/if}">',
          3 => '<input type="hidden" name="opportunity_id" value="{if isset($smarty.request.opportunity_id)}{$smarty.request.opportunity_id}{else}{$bean->opportunity_id}{/if}">',
        ),
        'buttons' =>
        array(
         
          0 => array(
              'customCode' => '<input title="Save" accesskey="a" class="button primary" onclick="var _form = document.getElementById(\'EditView\'); _form.action.value=\'Save\'; if(check_form(\'EditView\') && validateAndSaveLead())SUGAR.ajaxUI.submitForm(_form);return false;" type="submit" name="button" value="Save" id="SAVE">',
          ),
          1 => 'CANCEL',
        ),
      ),
      'maxColumns' => '2',
      'widths' =>
      array(
        0 =>
        array(
          'label' => '20',
          'field' => '30',
        ),
        1 =>
        array(
          'label' => '20',
          'field' => '30',
        ),
      ),
      'javascript' => '<script type="text/javascript" language="Javascript">function copyAddressRight(form)  {ldelim} form.alt_address_street.value = form.primary_address_street.value;form.alt_address_city.value = form.primary_address_city.value;form.alt_address_state.value = form.primary_address_state.value;form.alt_address_postalcode.value = form.primary_address_postalcode.value;form.alt_address_country.value = form.primary_address_country.value;return true; {rdelim} function copyAddressLeft(form)  {ldelim} form.primary_address_street.value =form.alt_address_street.value;form.primary_address_city.value = form.alt_address_city.value;form.primary_address_state.value = form.alt_address_state.value;form.primary_address_postalcode.value =form.alt_address_postalcode.value;form.primary_address_country.value = form.alt_address_country.value;return true; {rdelim} </script>',
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
        0 => 
          array(
            0 => 
              array(
                'name' => 'lead_type', 
                'label' => 'LBL_LEAD_TYPE',
                'displayParams' => 
                  array(
                    'field' => 
                      array(
                        'onchange' => 'toggleLeadTypeFields();'
                      ),
                  ),
              ),
            1=> array('name' => 'account_name_c',
              'label' => 'LBL_DEALERSHIP',
              'displayParams' => array(
                    'initial_filter' => '&account_type_advanced=Dealer',
              ),
            ),
          ),
        1 => 
          array(
            0 => array('name' => 'interested_year', 'label' => 'LBL_INTERESTED_YEAR'),
            1 => array('name' => 'interested_make', 'label' => 'LBL_INTERESTED_MAKE'),
          ),
        2 =>
        array(
          0 => array('name' => 'interested_model', 'label' => 'LBL_INTERESTED_MODEL'),

          1 => array(
            'name' => 'stock_number',
            'label' => 'LBL_STOCK_NUMBER',
            'customCode' => '
              <div class="input-group" style="display:flex; width:100%; max-width:260px;">
                
                <input type="text"
                  name="stock_number"
                  id="stock_number"
                  value="{$fields.stock_number.value}"
                  style="flex:1; margin:0; border-right:0; border-radius:4px 0 0 4px;"
                />

                <span class="input-group-btn" style="margin:0;">
                  <button type="button"
                    class="button btn"
                    onclick="fetchProductByStockNumber();"
                    style="margin:0; border-radius:0 4px 4px 0;"
                  >
                    Check
                  </button>
                </span>

              </div>
            ',

          ),
        ),


        3 => 
          array(
            0 => 
              array(
                'name' => 'current_lease', 
                'label' => 'LBL_CURRENT_LEASE',
                'displayParams' => 
                  array(
                    'field' => 
                      array(
                        'onchange' => 'toggleLeaseExpiryOnCurrentLease();'
                      ),
                  ),
              ),
            1 => array('name' => 'lease_expiry', 'label' => 'LBL_LEASE_EXPIRY'),
          ),
        4 => 
          array(
            0 => array('name' => 'lease_miles_per_year', 'label' => 'LBL_LEASE_MILES_PER_YEAR'),
            1 => array('name' => 'vehicle_c', 'label' => 'LBL_VEHICLE'),
          ),
          

        5 => 
          array(
           
           array('name' => 'listed_price_c', 'label' => 'LBL_LISTED_PRICE'),
          array('name' => 'market_value_c', 'label' => 'LBL_MARKET_VALUE'),
          ),

        6 => 
          array(
            0 => array('name' => 'form_of_payment', 'label' => 'LBL_FORM_OF_PAYMENT'),
            1 => array('name' => 'amount_owed', 'label' => 'LBL_AMOUNT_OWED'),
          ),
        8 => 
          array(
            0 => array('name' => 'product_name_c', 'label' => 'LBL_PRODUCT'),
            1 => array('name' => 'lead_name', 'label' => 'LBL_LEAD_NAME'),
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
        0 => array('name' => 'delivery_date', 'label' => 'LBL_DELIVERY_DATE'),
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
            array('name' => 'caller_phone_c', 'label' => 'LBL_CALLER_PHONE'),
            //array('name' => 'duration_c', 'label' => 'LBL_DURATION'),
            array('name' => 'callerid_c', 'label' => 'LBL_CALLERID'),
        )/*,
        6 => array(
            array('name' => 'duration_c', 'label' => 'LBL_DURATION'),
            array('name' => 'caller_state_c', 'label' => 'LBL_CALLER_STATE'),
        )*/,
        8 => array(
            0 => 'description',
           // array('name' => 'stock_no_c', 'label' => 'LBL_STOCK_NO'),
          
           
        ),
     9 => array(
           
           array('name' => 'call_transcription_c', 'label' => 'LBL_CALL_VALUE'),
           
        ),
   
      10 => array(
            array('name' => 'listing_url_c', 'label' => 'LBL_LISTING_URL'),
             array('name' => 'assigned_user_name', 'label' => 'LBL_ASSIGNED_USER_NAME'),
        ),
       

  ),

      'LBL_PANEL_ADVANCED' =>
      array(
        0 =>
        array(
          0 => 'status',
          1 => 'lead_source',
        ),
        /*
        1 =>
        array(
          0 => 'is_want_converted'
        ),*/
        /*1 =>
        array(
          0 =>
          array(
            'name' => 'status_description',
          ),
          1 =>
          array(
            'name' => 'lead_source_description',
          ),
        ),
        2 =>
        array(
          0 => 'opportunity_amount',
          1 => 'refered_by',
        ),
        3 =>
        array(
          0 => 'campaign_name',
        ),*/
      ),
      /*'LBL_PANEL_ASSIGNMENT' =>
      array(
        0 =>
        array(
          0 =>
          array(
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO',
          ),
        ),
      ),*/
    ),
  ),
);

// Append our fields below default ones
/*$viewdefs['Leads']['EditView']['panels']['LBL_LEAD_INFORMATION'][] = 
    array(array(
        'name' => 'lead_type', 
        'label' => 'LBL_LEAD_TYPE',
        'displayParams' => array(
            'field' => array(
                'onchange' => 'toggleLeadTypeFields();'
            )
        )
    ));
    

// Used Car block
$viewdefs['Leads']['EditView']['panels']['LBL_LEAD_INFORMATION'][] =
    array(array('name' => 'trade_in', 'label' => 'LBL_TRADE_IN','displayParams' => array(
            'field' => array(
                'onchange' => 'toggleTradeInFields();'
            )
        )), array('name' => 'trade_year', 'label' => 'LBL_TRADE_YEAR'));
$viewdefs['Leads']['EditView']['panels']['LBL_LEAD_INFORMATION'][] =
    array(array('name' => 'trade_make', 'label' => 'LBL_TRADE_MAKE'), array('name' => 'trade_miles', 'label' => 'LBL_TRADE_MILES'));
$viewdefs['Leads']['EditView']['panels']['LBL_LEAD_INFORMATION'][] =
    array(array('name' => 'finance_or_paid', 'label' => 'LBL_FINANCE_OR_PAID'), array('name' => 'finance_lender', 'label' => 'LBL_FINANCE_LENDER'));
$viewdefs['Leads']['EditView']['panels']['LBL_LEAD_INFORMATION'][] =
    array(array('name' => 'amount_owed', 'label' => 'LBL_AMOUNT_OWED'));

// Lease block
$viewdefs['Leads']['EditView']['panels']['LBL_LEAD_INFORMATION'][] =
    array(array('name' => 'current_lease', 'label' => 'LBL_CURRENT_LEASE','displayParams' => array(
            'field' => array(
                'onchange' => 'toggleLeaseExpiryOnCurrentLease();'
            )
        )), array('name' => 'lease_expiry', 'label' => 'LBL_LEASE_EXPIRY'));
$viewdefs['Leads']['EditView']['panels']['LBL_LEAD_INFORMATION'][] =
    array(array('name' => 'lease_miles_per_year', 'label' => 'LBL_LEASE_MILES_PER_YEAR'));

// Interested vehicle
$viewdefs['Leads']['EditView']['panels']['LBL_LEAD_INFORMATION'][] =
    array(array('name' => 'interested_year', 'label' => 'LBL_INTERESTED_YEAR'), array('name' => 'interested_make', 'label' => 'LBL_INTERESTED_MAKE'));
$viewdefs['Leads']['EditView']['panels']['LBL_LEAD_INFORMATION'][] =
    array(array('name' => 'interested_model', 'label' => 'LBL_INTERESTED_MODEL'), array('name' => 'stock_number', 'label' => 'LBL_STOCK_NUMBER'));

// Payment
$viewdefs['Leads']['EditView']['panels']['LBL_LEAD_INFORMATION'][] =
    array(array('name' => 'form_of_payment', 'label' => 'LBL_FORM_OF_PAYMENT'));

// Tasks
$viewdefs['Leads']['EditView']['panels']['LBL_LEAD_INFORMATION_TASK'][] =
    array(array('name' => 'appt_test_drive', 'label' => 'LBL_APPT_TEST_DRIVE'), array('name' => 'credit_application', 'label' => 'LBL_CREDIT_APPLICATION'));
$viewdefs['Leads']['EditView']['panels']['LBL_LEAD_INFORMATION_TASK'][] =
    array(array('name' => 'finance_approved', 'label' => 'LBL_FINANCE_APPROVED'), array('name' => 'deposit_taken', 'label' => 'LBL_DEPOSIT_TAKEN'));
$viewdefs['Leads']['EditView']['panels']['LBL_LEAD_INFORMATION_TASK'][] =
    array(array('name' => 'transport_setup', 'label' => 'LBL_TRANSPORT_SETUP'), array('name' => 'dmv_completed', 'label' => 'LBL_DMV_COMPLETED'));
$viewdefs['Leads']['EditView']['panels']['LBL_LEAD_INFORMATION_TASK'][] =
    array(array('name' => 'dmv_lien', 'label' => 'LBL_DMV_LIEN'));*/