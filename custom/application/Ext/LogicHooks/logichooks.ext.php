<?php 
 //WARNING: The contents of this file are auto-generated


/**
 * Advanced OpenWorkflow, Automating SugarCRM.
 * @package Advanced OpenWorkflow for SugarCRM
 * @copyright SalesAgility Ltd http://www.salesagility.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author SalesAgility <info@salesagility.com>
 */

if (!isset($hook_array) || !is_array($hook_array)) {
    $hook_array = array();
}
if (!isset($hook_array['after_save']) || !is_array($hook_array['after_save'])) {
    $hook_array['after_save'] = array();
}
$hook_array['after_save'][] = Array(99, 'AOW_Workflow', 'modules/AOW_WorkFlow/AOW_WorkFlow.php','AOW_WorkFlow', 'run_bean_flows');

/**
 * Register Webhook Popup Logic Hook
 * This will include the webhook popup JavaScript on all pages
 */

if (!isset($hook_array) || !is_array($hook_array)) {
    $hook_array = array();
}

if (!isset($hook_array['after_ui_footer']) || !is_array($hook_array['after_ui_footer'])) {
    $hook_array['after_ui_footer'] = array();
}

// Register the webhook popup hook to run after the UI footer is displayed
$hook_array['after_ui_footer'][] = Array(
    50, // Sort order
    'Include Webhook Popup Script', // Hook label
    'custom/include/webhooks/WebhookPopupHook.php', // File path
    'WebhookPopupHook', // Class name
    'includeWebhookPopupScript' // Method name
);


?>