<?php
require_once('include/entryPoint.php');
global $db;

$lead=$_POST['lead'];
$did=$_POST['did'];
$type=$_POST['type'];
$name=$_POST['name'];

if($type=='OUT'){
$cond="description LIKE '%--- OUT |%' AND description LIKE '%From: $did%'";
}else{
$cond="description LIKE '%--- IN |%' AND description LIKE '%To: $did%'";
}

$q="SELECT description,date_entered 
FROM notes 
WHERE parent_id='$lead'
AND parent_type='Leads'
AND deleted=0
AND $cond
ORDER BY date_entered ASC";

$res=$db->query($q);

echo "<div><h2><a href='index.php?module=Leads&action=DetailView&record={$lead}' target='_blank'>$name</a></h2></div>";
echo "<div>";

while($row=$db->fetchByAssoc($res)){

$desc=html_entity_decode($row['description']);

$pattern='/---\s*(IN|OUT)\s*\|\s*From:\s*(.*?)\s*\|\s*To:\s*(.*?)\s*\|\s*At:\s*(.*?)\s*---\s*(.*?)(?=(---|$))/si';

if(preg_match_all($pattern,$desc,$m,PREG_SET_ORDER)){

foreach($m as $v){

$dir=strtolower($v[1])=='out'?'out':'in';
$from=$v[2];
$to=$v[3];
$date=$v[4];
$msg=nl2br(htmlspecialchars(trim($v[5])));

$highlight='';

if($type=='OUT' && $from==$did){
    $highlight='highlight';
}

if($type=='IN' && $to==$did){
    $highlight='highlight';
}
echo "<div class='msg $dir $highlight'>
$msg<br><small>$date</small>
</div>";

}
}
}

echo "</div>";