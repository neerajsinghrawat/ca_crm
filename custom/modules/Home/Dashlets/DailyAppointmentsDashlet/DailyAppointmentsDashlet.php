<?php
require_once('include/Dashlets/Dashlet.php');

class DailyAppointmentsDashlet extends Dashlet {

    function DailyAppointmentsDashlet($id, $def = null) {
        parent::Dashlet($id);
        $this->title = 'Today Appointments';
    }

    function display() {
        global $db;

        $html = '
        <style>
        .appt-table{
            width:100%;
            border-collapse:collapse;
            font-family:Arial;
            background:#fff;
        }

        .appt-table th{
            background:#f2f2f2;
            color:#000;
            padding:8px;
            font-size:12px;
            text-align:left;
        }

        .appt-table td{
            padding:8px;
            font-size:12px;
            border-bottom:1px solid #eee;
        }

        .appt-table tr:hover{
            background:#f2f6ff;
        }

        .time{
            font-weight:bold;
            color:#e74a3b;
        }
        </style>

        <table class="appt-table">
        <tr>
            <th>Time</th>
            <th>Customer</th>
            <th>Salesperson</th>
        </tr>
        ';

        $query = "
        SELECT 
            m.id,
            m.date_start,
            l.first_name,
            l.last_name,
            u.first_name AS sales_first,
            u.last_name AS sales_last

        FROM meetings m

        LEFT JOIN leads l 
            ON l.id = m.parent_id 
            AND m.parent_type = 'Leads'

        LEFT JOIN users u 
            ON u.id = m.assigned_user_id

        WHERE 
            m.deleted = 0
            AND DATE(m.date_start) = CURDATE()

        ORDER BY m.date_start ASC
        ";

        $res = $db->query($query);

        while($row = $db->fetchByAssoc($res)){

            $time = date("h:i A", strtotime($row['date_start']));
            $customer = trim($row['first_name'].' '.$row['last_name']);
            $salesperson = trim($row['sales_first'].' '.$row['sales_last']);
            $vehicle = '';

            $html .= "
            <tr>
                <td class='time'>$time</td>
                <td>$customer</td>
                <td>$salesperson</td>
            </tr>
            ";
        }

        $html .= "</table>";

        return $html;
    }
}