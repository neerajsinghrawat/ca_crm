<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class ShowNumberInNoteName
{
    public function appendPhoneOnView($bean, $event, $arguments)
    {
        // Only if related to Leads
        if ($bean->parent_type !== 'Leads' || empty($bean->parent_id)) {
            return;
        }

        // Load Lead
        $lead = BeanFactory::getBean('Leads', $bean->parent_id);
        if (empty($lead) || empty($lead->id)) {
            return;
        }

        /*// Get phone number
        $phone = '';
        if (!empty($lead->phone_mobile)) {
            $phone = $lead->phone_mobile;
        } elseif (!empty($lead->phone_work)) {
            $phone = $lead->phone_work;
        }

        if (empty($phone)) {
            return;
        }

        // Prevent duplicate on refresh
        if (strpos($bean->name, $phone) !== false) {
            return;
        }

        // VIEW ONLY modification
        $bean->name .= ' (' . $phone . ')';*/
    }
}
