<?php
class SetNewLead
{
    // When lead is created
    public function markNew($bean, $event, $args)
    {
        if (empty($bean->fetched_row)) {
            $bean->is_new_lead_c = 1;
        }
    }

    // When any user opens DetailView
    public function removeNewOnView($bean, $event, $args)
    {

        if ($_REQUEST['action'] !== 'DetailView') {
            return;
        }
        
        if ($bean->is_new_lead_c == 1) {
            $bean->is_new_lead_c = 0;
            $bean->save(false);
        }
    }
}
