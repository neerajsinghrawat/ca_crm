<?php
function get_lead_calls($params) {
    $db = DBManagerFactory::getInstance();
    
    global $focus;
    
    if (!empty($focus->id)) {
        $lead_id = $db->quote($focus->id);
    } else {
        return "SELECT calls.*, calls.id AS leads_id FROM calls WHERE 1=0";
    }

    $query = "SELECT calls.*, calls.id AS leads_id
              FROM calls
              WHERE calls.deleted = 0
              AND calls.parent_id = '$lead_id'
              AND calls.parent_type = 'Leads'";

    return $query;
}