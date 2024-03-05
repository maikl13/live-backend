<?php
include "config.php";

$room=$_GET['room'];
$user=$_GET['user'];
 
 $exist = readRowFromSql("SELECT `rooms_forbidden_users`.`id` ,`rooms_forbidden_users`.`permanently`,
TIMESTAMPDIFF(HOUR, `rooms_forbidden_users`.`datetime`, NOW()) AS hours_different
FROM `rooms_forbidden_users` WHERE 
`rooms_forbidden_users`.`room`= '$room'
AND 
`rooms_forbidden_users`.`user`= '$user'", true);

 
if($exist==null){
  
     $result= false;
}else{
 if($exist['permanently']==1){
      $result= true;
 }else if($exist['hoursDiff']<3){
    $result= true; 
 }else{
    readRowFromSql("DELETE FROM `rooms_forbidden_users` WHERE 
`rooms_forbidden_users`.`room`= '$room'
AND 
`rooms_forbidden_users`.`user`= '$user'", true);
    $result= false;
  
 }
}
    


echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>