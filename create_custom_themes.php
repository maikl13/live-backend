<?php
include "config.php";
include "pay.php";


$creator_uid = $_GET['creator_uid'];
$image = $_GET['image'];
$customtheme_paying_mode = $_GET['customtheme_paying_mode'];


$user = readRowFromSql("SELECT  `users`.`current_vip_subscription`, `users`.`current_premium_subscription` FROM `users` WHERE  `users`.`uid`='$creator_uid'", true);

$result=false;
$canCreateTheme=false;
if($user['current_vip_subscription']!=null||$user['current_premium_subscription']!=null){
    $canCreateTheme=true;
    
}else{
       echo "NotPremiumNorVIP";
}
if($canCreateTheme){
     
      
      
        $select=readRowFromSql("SELECT `customtheme_paying_modes`.`golds` FROM `customtheme_paying_modes` WHERE `customtheme_paying_modes`.`id`='$customtheme_paying_mode'", true);

$price=$select['golds'];

       if(payNow($creator_uid,$price,'g')){
           
            $result = updateSql("INSERT INTO `custom_themes`
      (`id`, `paying_mode`, `created_at`, `image`, `creator_uid`,`available`)
      VALUES 
      (NULL, '$customtheme_paying_mode', CURRENT_TIMESTAMP, '$image', '$creator_uid',1);");
      echo "Success";
      
       }else{
           echo "NotEnoughGold";
       }
}


          

//echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>