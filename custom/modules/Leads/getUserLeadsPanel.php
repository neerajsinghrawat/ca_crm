<?php
require_once('include/entryPoint.php');
global $db;

$user = $_POST['user'];
$type = $_POST['type'];

$whereDate = "";

if($type=='today'){
    $whereDate = "AND date_entered >= CURDATE()
                  AND date_entered < CURDATE() + INTERVAL 1 DAY";
}

echo '
<style>
.wrap{display:flex;height:560px;font-family:Arial}
.left{width:35%;border-right:1px solid #ddd;overflow:auto;background:#f7f7f7}
.leadrow{padding:10px;border-bottom:1px solid #eee;cursor:pointer}
.leadrow:hover{background:#eef2ff}
.right{width:65%;padding:20px;overflow:auto;background:#fff}
.card{background:#f7f7f7;padding:10px;margin-bottom:10px;border-radius:6px}
</style>

<div class="wrap">
<div class="left">
';

$q="SELECT id,first_name,last_name,phone_mobile,status
FROM leads
WHERE assigned_user_id='$user'
AND deleted=0
$whereDate
ORDER BY date_entered DESC";
$res=$db->query($q);

while($row=$db->fetchByAssoc($res)){

$name=$row['first_name'].' '.$row['last_name'];

echo "<div class='leadrow' 
onclick=\"loadLeadDetail('{$row['id']}')\">
👤 $name
<br><small>{$row['phone_mobile']} | {$row['status']}</small>
</div>";
}

echo '</div>
<div class="right" id="leadDetail">
Select lead to view details
</div>
</div>';
?>

<script>
function loadLeadDetail(leadId){

$("#leadDetail").html("Loading...");

$.ajax({
url:"index.php?entryPoint=getSingleLeadDetail",
type:"POST",
data:{lead:leadId},
success:function(res){
$("#leadDetail").html(res);
}
});
}
</script>