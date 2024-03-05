<?php
include "config.php";
 
$room = $_GET['room'];
$action= $_GET['action'];
    $whereCode="";
   switch($action){
       case "removeFromRoom":
           $whereCode="`action_records`.`action`='removeFromRoom'";
           break;
              case "removeFromMic":
          $whereCode="`action_records`.`action`='removeFromMic'";
           break;
              case "banOrUnban":
         $whereCode="(`action_records`.`action`='ban' OR `action_records`.`action`='unban')";
           break;
   }
    $actions = readRowFromSql("SELECT  `action_records`.*,
`users`.`full_name`,`users`.`uid`,`users`.`profile_pic`,`users`.`gender` ,
   `users`.`current_premium_subscription`,
    `users`.`current_vip_subscription`
FROM `action_records` 
INNER JOIN `users` ON `users`.`uid`= `action_records`.`user`
WHERE
`action_records`.`room`='$room' AND
`action_records`.`datetime` + INTERVAL 30 DAY >= NOW() 
AND 
$whereCode
", false);
  $results=formatResult($actions);
  
  function formatResult($actions){
      $list=array();
  foreach ($actions as $action) {
      
          $result['user']=getUser($action);
          //$result['admin']=getAdmin($action);
          $result['id']=$action['id'];
        $result['action']=$action['action'];
        $result['datetime']=$action['datetime'];
       // $result['room']=$action['room'];
 
            $list[]=$result;
  }
    return $list;
  }
 function getUser($action){
        $user['uid']=$action['uid'];
        $user['profile_pic']=$action['profile_pic'];
       $user['gender']=$action['gender'];
        $user['full_name']=$action['full_name'];
        $user['current_premium_subscription']=$action['current_premium_subscription'];
         $user['current_vip_subscription']=$action['current_vip_subscription'];
         return $user;
  }
   function getAdmin($action){
        $user['uid']=$action['uid'];
        $user['profile_pic']=$action['profile_pic'];
       $user['gender']=$action['gender'];
        $user['full_name']=$action['full_name'];
        $user['current_premium_subscription']=$action['current_premium_subscription'];
         $user['current_vip_subscription']=$action['current_vip_subscription'];
         return $user;
  }
echo json_encode($results, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


?>


