<?php
require_once('include/entryPoint.php');
global $db;

$leadId=$_POST['lead'];
$lead=BeanFactory::getBean('Leads',$leadId);

echo "<style>
.card{
background:#f7f7f7;
padding:8px;
margin:5px 0;
border-radius:6px;
}
table{
border-collapse:collapse;
}
th{
background:#333;
color:#fff;
}
</style>";

echo "
<h2><a href='index.php?module=Leads&action=DetailView&record={$lead->id}' target='_blnak'>{$lead->first_name} {$lead->last_name}</a></h2>

<div class='card'><b>Phone:</b> {$lead->phone_mobile}</div>
<div class='card'><b>Email:</b> {$lead->email1}</div>
<div class='card'><b>Status:</b> {$lead->status}</div>
<div class='card'><b>Source:</b> {$lead->lead_source}</div>
<div class='card'><b>Assigned:</b> {$lead->assigned_user_name}</div>
<div class='card'><b>Description:</b><br>{$lead->description}</div>
";

echo "<hr><h3>Interested Vehicles</h3>";

/* interested vehicle query */
$query = "SELECT iv.name,
                 iv.id,
                 iv.status,
                 iv.lead_source,
                 iv.date_entered
          FROM iv_intrested_vehicle iv
          WHERE iv.lead_id = '".$leadId."'
          AND iv.deleted = 0
          ORDER BY iv.date_entered DESC";

$result = $db->query($query);

echo "<table width='100%' border='1' cellpadding='5' cellspacing='0'>
<tr style='background:#f2f2f2'>
    <th>Vehicle</th>
    <th>Status</th>
    <th>Lead Source</th>
    <th>Date Entered</th>
</tr>";

while($row = $db->fetchByAssoc($result)){
    $iv_id = $row['id'];
    echo "<tr>
            <td><a href='index.php?module=iv_intrested_vehicle&action=DetailView&record={$iv_id}' target='_blnak'>{$row['name']}</a></td>
            <td>{$row['status']}</td>
            <td>{$row['lead_source']}</td>
            <td>".date('m/d/y H:i',strtotime($row['date_entered']))."</td>
          </tr>";
}

echo "</table>";

echo "<hr><h3>Trade Appraisal</h3>";
/* interested vehicle query */
$taquery = "SELECT ta.vin,
                 ta.id,
                 ta.vehicle_year,
                 ta.vehicle_make,
                 ta.vehicle_model,
                 ta.date_entered
          FROM ta_trade_appraisal ta
          WHERE ta.lead_id = '".$leadId."'
          AND ta.deleted = 0
          ORDER BY ta.date_entered DESC";

$tbresult = $db->query($taquery);

echo "<table width='100%' border='1' cellpadding='5' cellspacing='0'>
<tr style='background:#f2f2f2'>
    <th>VIN</th>
    <th>Year</th>
    <th>Make</th>
    <th>Model</th>
    <th>Date Entered</th>
</tr>";

while($tarow = $db->fetchByAssoc($tbresult)){
    $ta_id = $tarow['id'];
    echo "<tr>
            <td><a href='index.php?module=ta_trade_appraisal&action=DetailView&record={$ta_id}' target='_blnak'>{$tarow['vin']}</a></td>
            <td>{$tarow['vehicle_year']}</td>
            <td>{$tarow['vehicle_make']}</td>
            <td>{$tarow['vehicle_model']}</td>
            <td>".date('m/d/y H:i',strtotime($tarow['date_entered']))."</td>
          </tr>";
}

echo "</table>";