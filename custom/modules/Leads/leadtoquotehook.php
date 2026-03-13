<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class LeadToQuoteHook
{
    public function createQuote($bean, $event, $arguments)
    {

        if (!empty($bean->fetched_row)) {
           return;
       }

        global $current_user;
        // Run only when lead is converted
      /*  if ($bean->status != 'Converted') {
            return;
        }

        // Avoid duplicate quotes
        if (!empty($bean->quote_created_c) && $bean->quote_created_c == 1) {
            return;
        }*/

        require_once 'modules/AOS_Quotes/AOS_Quotes.php';
        require_once 'modules/AOS_Line_Item_Groups/AOS_Line_Item_Groups.php';
        require_once 'modules/AOS_Products_Quotes/AOS_Products_Quotes.php';


         $fieldsToCopy = [
                    'first_name',
                    'last_name',
                    'phone_mobile',
                    'phone_work',
                    'email1',
                    'assigned_user_id',
                    'lead_type',
                    'trade_in',
                    'trade_year',
                    'trade_make',
                    'trade_miles',
                    'finance_or_paid',
                    'finance_lender',
                    'amount_owed',
                    'interested_year',
                    'interested_make',
                    'interested_model',
                    'stock_number',
                    'form_of_payment',
                    'appt_test_drive',
                    'credit_application',
                    'finance_approved',
                    'deposit_taken',
                    'transport_setup',
                    'dmv_completed',
                    'dmv_lien',
                    'current_lease',
                    'lease_expiry',
                    'lease_miles_per_year',
                    'dealership_c',
                    'received_date_c',
                    'duration_c',
                    'callerid_c',
                    'caller_phone_c',
                    'caller_state_c',
                    'vehicle_c',
                    'stock_no_c',
                    'listing_url_c',
                    'listed_price_c',
                    'market_value_c',
                    'call_transcription_c',
                    'quote_created_c'
                ];

             

   

        // Create Account
        $account = BeanFactory::newBean('Accounts');
        $account->name = !empty($bean->company) ? $bean->company : $bean->first_name . " " . $bean->last_name;
        $account->phone_office = $bean->phone_work;
        $account->email1 = $bean->email1;
        $account->assigned_user_id = $bean->assigned_user_id;
        $account->save();

        // Create Contact
        $contact = BeanFactory::newBean('Contacts');
    

        foreach ($fieldsToCopy as $field) {
                    if (isset($bean->$field)) {
                        $contact->$field = $bean->$field;
         }
        }

        // Link contact to account
        $contact->account_id = $account->id;
        $contact->save();

        // Optionally link the lead with converted contact/account
       // $bean->contact_id = $contact->id;
       // $bean->account_id = $account->id;
       // $bean->converted = 1; // mark as converted
       // $bean->save();

global $db;
$db->query("
    UPDATE leads 
    SET converted = 1, contact_id = '{$contact->id}', account_id = '{$account->id}'
    WHERE id = '{$bean->id}'
");






        // Create Quote
        $quote = new AOS_Quotes();
        $quote->name = "Quote for " . $bean->name;
        $quote->billing_account_id = $account->id;
        $quote->billing_contact_id = $contact->id;
        $quote->parent_type = 'Leads';
        $quote->parent_id = $bean->id;
        $quote->assigned_user_id = $bean->assigned_user_id;
        $quote->save();

        // Create Line Item Group
        $lineGroup = new AOS_Line_Item_Groups();
        $lineGroup->name = "Default Group";
        $lineGroup->parent_type = 'AOS_Quotes';
        $lineGroup->parent_id = $quote->id;
        $lineGroup->assigned_user_id = $bean->assigned_user_id;
        $lineGroup->save();


 

        // Create Product Line Item if product is selected in lead
        if (!empty($bean->aos_product_id_c)) {
                   // Load product
             $product = BeanFactory::getBean('AOS_Products', $bean->aos_product_id_c);

        if ($product && !empty($product->id)) {
            $productQuote = new AOS_Products_Quotes();
            $productQuote->parent_type = 'AOS_Quotes';
            $productQuote->parent_id = $quote->id;
            $productQuote->group_id = $lineGroup->id;
            $productQuote->name = $product->name; // 👈 Add this
            $productQuote->part_number = $product->part_number;   // 👈 product code
            $productQuote->description = $product->description;   // 👈 description
            $productQuote->product_id = $bean->aos_product_id_c;
            $productQuote->product_qty = 1;
             $productQuote->product_list_price = $product->price;
             $productQuote->product_unit_price = $product->price; // 👈 use actual price
           //  $productQuote->product_total_price = $product->listed_price_c ;
            $productQuote->assigned_user_id = $bean->assigned_user_id;
            $productQuote->save();
        } else {
                $product_name = 'Unknown Product';
        }       


          
        }

        // Mark that quote was created
       // $bean->quote_created_c = 1;
//$bean->save();

$db->query(" 
    UPDATE leads     SET quote_created_c = 1    WHERE id = '{$bean->id}'
");


        // Debug Log
         $GLOBALS['log']->fatal("Line Item Created with product: {$product->name}");
        $GLOBALS['log']->fatal("Quote Created for Lead ID: " . $bean->id . " -> Quote ID: " . $quote->id ." => product id :".$bean->aos_product_id_c);
    }
}
