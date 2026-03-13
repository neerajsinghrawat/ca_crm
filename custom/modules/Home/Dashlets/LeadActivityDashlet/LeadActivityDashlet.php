<?php
require_once('include/Dashlets/Dashlet.php');

class LeadActivityDashlet extends Dashlet {

    function __construct($id, $def = null) {
        parent::__construct($id);
        $this->title = 'Lead Activity Log';
    }

    function display() {

        global $db,$timedate;

        $query = "SELECT 
                    ual.id,
                    ual.date_entered,
                    ual.parent_id,
                    ual.action,
                    ual.field_name,
                    ual.old_value,
                    ual.new_value,
                    ual.name as ual_name,
                    ual.description as ual_description,
                    CONCAT(u.first_name,' ',u.last_name) user_name,
                    l.first_name lead_first,
                    l.last_name lead_last
                  FROM ual_user_activity_log ual
                  LEFT JOIN users u ON u.id = ual.created_by AND u.deleted=0
                  LEFT JOIN leads l ON l.id = ual.parent_id AND l.deleted=0
                  WHERE ual.deleted=0
                  ORDER BY ual.date_entered DESC
                  LIMIT 20";

        $res = $db->query($query);

        $html = '<table width="100%" style="font-size:12px">';
        $html .= '<tr style="background:#f2f2f2">                    
                    <th>Lead</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>Activity</th>
                    <th>Date</th>
                  </tr>';

        while($row = $db->fetchByAssoc($res)){

            $leadName = trim($row['lead_first'].' '.$row['lead_last']);

            // Lead link
            $leadLink = "index.php?module=Leads&action=DetailView&record=".$row['parent_id'];

            // Activity detail link (your custom module)
            $activityLink = "index.php?module=ual_user_activity_log&action=DetailView&record=".$row['id'];
            $desc = htmlspecialchars($row['ual_description'], ENT_QUOTES);
            $html .= '<tr>';
            $html .= '<td><a href="'.$leadLink.'" target="_blank">'.$leadName.'</a></td>';
            $html .= '<td>'.$row['user_name'].'</td>';
            $html .= '<td>'.$row['action'].'</td>';
            $html .= '<td><a href="'.$activityLink.'" target="_blank" title="'.$desc.'">'.$row['ual_name'].'</a></td>';
            $html .= '<td>'.$timedate->to_display_date_time($row['date_entered'], true).'</td>';
            $html .= '</tr>';
        }

        $html .= '</table>';

        return $html;
    }
}