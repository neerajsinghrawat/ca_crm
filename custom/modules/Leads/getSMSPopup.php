<?php
require_once('include/entryPoint.php');
global $db;

$did  = $_POST['did'];
$type = $_POST['type'];

echo '<style>
.chatwrap{display:flex;height:550px;font-family:Arial}
.leads{width:30%;border-right:1px solid #ddd;overflow:auto;background:#f7f7f7}
.leads div{padding:10px;border-bottom:1px solid #eee;cursor:pointer}
.leads div:hover{background:#eaf1ff}
.chat{width:70%;padding:15px;overflow:auto;background:#f0f2f5}
.msg{margin:8px 0;max-width:60%;padding:10px;border-radius:10px}

.out{margin-left:auto}
.highlight{border:2px solid red}
</style>';
//.in{background:#fff}
//.out{background:#dcf8c6;margin-left:auto}
echo "<div class='chatwrap'>
<div class='leads'>";

if($type=='OUT'){
$cond="description LIKE '%--- OUT |%' 
AND description LIKE '%From: $did%'";
}
if($type=='IN'){
$cond="description LIKE '%--- IN |%' 
AND description LIKE '%To: $did%'";
}



if($type=='today_IN'){
$cond="description LIKE '%--- IN |%' 
AND description LIKE '%To: $did%'
AND description LIKE CONCAT('%At: ',CURDATE(),'%')";
}

if($type=='today_OUT'){
$cond="description LIKE '%--- OUT |%' 
AND description LIKE '%From: $did%'
AND description LIKE CONCAT('%At: ',CURDATE(),'%')";
}

$q = "SELECT DISTINCT parent_id
FROM notes
WHERE deleted=0
AND parent_type='Leads'
AND $cond";

$res = $db->query($q);

while($row=$db->fetchByAssoc($res)){

$leadId=$row['parent_id'];

$lead=BeanFactory::getBean('Leads',$leadId);
$name=$lead->first_name.' '.$lead->last_name;

echo "<div onclick=\"loadChat('$leadId','$did','$type','$name')\">👤 $name</div>";
}

echo "</div>
<div class='chat' id='chatbox'>Select lead</div>
</div>";

?>

<script>
function loadChat(lead,did,type,name){

$("#chatbox").html("Loading...");

$.ajax({
url:"index.php?entryPoint=getSalesUserMessages",
type:"POST",
data:{lead:lead,did:did,type:type,name:name},
success:function(res){
$("#chatbox").html(res);
}
});
}
</script>