<?php

require_once('include/MVC/Controller/SugarController.php');

class iv_intrested_vehicleController extends SugarController
{

    public function action_lease_sold()
    {
        $_REQUEST['form_of_payment'] = 'lease';
        $this->view = 'lease_sold';
    }

    public function action_finance_sold()
    {
        $_REQUEST['form_of_payment'] = 'finance';
        $this->view = 'lease_sold';
    }

    public function action_getSoldVehicles()
    {
        global $db;

        $type = $_REQUEST['type'];

        if($type == 'lease'){
            $payment = "Lease";
        }else{
            $payment = "Finance";
        }

        $query = "SELECT 
            iv.id,
            iv.name,
            iv.status,
            iv.form_of_payment,
            iv.start_date,
            iv.monthly_payments_c,
            iv.vin_c,
            iv.trim_c,
            iv.bank_c,
            iv.month_c,
            iv.miles_per_year,
            iv.interested_year,
            iv.interested_make,
            iv.interested_make,
            iv.vehicle_c,
            iv.date_entered,

            l.id AS lead_id,
            CONCAT(l.first_name,' ',l.last_name) AS lead_name,

            p.id AS product_id,
            p.name AS product_name

        FROM iv_intrested_vehicle iv

        LEFT JOIN leads l 
            ON l.id = iv.lead_id
            AND l.deleted = 0

        LEFT JOIN aos_products p
            ON p.id = iv.aos_product_id_c
            AND p.deleted = 0

        WHERE iv.deleted = 0
        AND iv.lead_type = 'lease_car'
        AND iv.status = 'Sold'

        ORDER BY iv.date_entered DESC
        ";

        $result = $db->query($query);

        $html = '<table cellpadding="0" cellspacing="0" border="0" class="list view table-responsive">';
        $html .= '<thead>
        <tr height="20">

        <th class="td_alt">&nbsp;</th>

        <th><div>Vehicle</div></th>
        <th><div>Lead Name</div></th>
        <th><div>Status</div></th>
        <th><div>Payment Type</div></th>

        <th><div>VIN</div></th>
        <th><div>Year</div></th>
        <th><div>Make</div></th>';
        /*if($type == 'finance'){*/
            $html .= '
            <th><div>Start Date</div></th>
            <th><div>End Date</div></th>
            <th><div>Term</div></th>
            <th><div>Miles / Year</div></th>
            <th><div>Monthly Payment</div></th>
            <th><div>Bank</div></th>
            <th><div>Month</div></th>';
        /*}*/
        $html .= '<th><div>Date Created</div></th>
        </tr>
        </thead><tbody>';

        $i = 0;

        while($row = $db->fetchByAssoc($result)){

            $rowClass = ($i % 2 == 0) ? "oddListRowS1" : "evenListRowS1";
            $row['date_entered'] = date('m/d/Y',strtotime($row['date_entered']));
            $row['start_date'] = (!empty($row['start_date']) && $row['start_date'] !='0000-00-00 00:00:00')?date('m/d/Y',strtotime($row['start_date'])):'';
            $row['end_date'] = (!empty($row['end_date']) && $row['end_date'] !='0000-00-00 00:00:00')?date('m/d/Y',strtotime($row['end_date'])):'';
            if (!empty($row['product_name'])) {
                $row['vehicle_c'] = $row['product_name'];
            }
            $html .= "<tr class='{$rowClass}' height='20'>";
            $html .= "<td>
            <input type='checkbox' class='listview-checkbox' name='mass[]' value='".$row['id']."'>
            </td>";
            $html .= "<td scope='row'>
            <a target='_blank' href='index.php?module=iv_intrested_vehicle&action=DetailView&record=".$row['id']."'>
            ".$row['vehicle_c']."
            </a>
            </td>";
            $html .= "<td><a target='_blank' href='index.php?module=Leads&action=DetailView&record=".$row['lead_id']."'>".$row['lead_name']."</a></td>";
            $html .= "<td>".$row['status']."</td>";
            $html .= "<td>".$row['form_of_payment']."</td>";

            $html .= "<td>".$row['vin_c']."</td>";
            $html .= "<td>".$row['interested_year']."</td>";
            $html .= "<td>".$row['interested_make']."</td>";

            /*if($type == 'finance'){*/

                $html .= "<td>".$row['start_date']."</td>";
                $html .= "<td>".$row['end_date']."</td>";

                $html .= "<td>".$row['trim_c']."</td>";
                $html .= "<td>".$row['miles_per_year']."</td>";
                $html .= "<td>".$row['monthly_payments_c']."</td>";
                $html .= "<td>".$row['bank_c']."</td>";
                $html .= "<td>".$row['month_c']."</td>";

            /*}*/

            $html .= "<td>".$row['date_entered']."</td>";
            

            $html .= "</tr>";

            $i++;
        }

        $html .= "</table>";

        echo $html;
        sugar_cleanup(true);
    }
    public function action_updateVehicleFields()
    {
        global $db;

        $ids = $_POST['ids'];

        foreach ($ids as $id) {

            $fields = array();

            if (!empty($_POST['trim_c'])) {
                $fields[] = "trim_c='".$db->quote($_POST['trim_c'])."'";
            }

            if (!empty($_POST['start_date'])) {
                $fields[] = "start_date='".$db->quote($_POST['start_date'])."'";
            }

            if (!empty($_POST['monthly_payments_c'])) {
                $fields[] = "monthly_payments_c='".$db->quote($_POST['monthly_payments_c'])."'";
            }

            if (!empty($_POST['bank_c'])) {
                $fields[] = "bank_c='".$db->quote($_POST['bank_c'])."'";
            }

            if (!empty($_POST['month_c'])) {
                $fields[] = "month_c='".$db->quote($_POST['month_c'])."'";
            }

            if (!empty($_POST['miles_per_year'])) {
                $fields[] = "miles_per_year='".$db->quote($_POST['miles_per_year'])."'";
            }
            if (!empty($_POST['end_date'])) {
                $fields[] = "end_date='".$db->quote($_POST['end_date'])."'";
            }

            if (!empty($fields)) {
                $query = "UPDATE iv_intrested_vehicle 
                          SET ".implode(",", $fields)."
                          WHERE id='".$db->quote($id)."'";

                $db->query($query);
            }
        }

        echo "success";
        sugar_cleanup(true);
    }

    public function action_getVehicleData()
    {

        global $db;

        $id = $_POST['id'];

        $query = "SELECT 
                    vin_c,
                    trim_c,
                    miles_per_year,
                    interested_year,
                    interested_make,
                    interested_model,
                    start_date,
                    monthly_payments_c,
                    bank_c,
                    month_c
                  FROM iv_intrested_vehicle
                  WHERE id='".$db->quote($id)."'";

        $result = $db->query($query);

        $row = $db->fetchByAssoc($result);

        echo json_encode($row);

        sugar_cleanup(true);

    }
}