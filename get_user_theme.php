<?php
include "config.php";


$uid =$_GET['uid'];
$themes=array();
   $select=readRowFromSql("SELECT `rooms`.`theme` FROM `rooms` WHERE `rooms`.`creator_uid`='$uid'", true);
$user_room_theme=$select['theme'];

$free_themes= readRowFromSql("SELECT `themes`.* ,'$user_room_theme'=`themes`.`id` AS is_selected FROM `themes` WHERE`themes`.`golds`=0"
, false);


  foreach ($free_themes as $free_theme) {
       $free_theme['theme_type']="STORE";
         $free_theme['is_bought']=0;
       $themes[]=$free_theme;
   }
   
 $user_themes = readRowFromSql("SELECT `themes`.*,'$user_room_theme'=`themes`.`id` AS is_selected FROM `themes`
INNER JOIN `users_bought_themes` ON `users_bought_themes`.`user_uid` ='$uid' AND
`users_bought_themes`.`theme`=`themes`.`id` AND   `users_bought_themes`.`available`=1
", false);

  foreach ($user_themes as $user_theme) {
       $user_theme['theme_type']="STORE";
      $user_theme['is_bought']=1;
       $themes[]=$user_theme;
   }
 
 //////////GIFTED//////////
  $gifted_themes = readRowFromSql("SELECT `themes`.*,'$user_room_theme'=`themes`.`id` AS is_selected FROM `themes`
INNER JOIN `gifted_themes` ON `gifted_themes`.`receiver` ='$uid' AND
`gifted_themes`.`theme`=`themes`.`id`
AND   `gifted_themes`.`available`=1
", false);

  foreach ($gifted_themes as $gifted_theme) {
        foreach ($themes as $myTheme) {
            if($myTheme['id']!=$gifted_theme['id']){
                  $gifted_theme['theme_type']="STORE";
                 $gifted_theme['is_bought']=1;
                 $themes[]=$gifted_theme;  
            }
        }
    
   }
 /////////////////////////////
   $premiumSubscription=readRowFromSql("SELECT `users`.`current_premium_subscription`
FROM `users` WHERE `users`.`uid`=''", true)['current_premium_subscription'];


  
  $is_premuim=$premiumSubscription!=null;
  
   if($is_premuim){
    
   
     $premium_themes= readRowFromSql("SELECT *  ,'$user_room_theme'=`premium_themes`.`id` AS is_selected FROM `premium_themes` WHERE `premium_themes`.`subscription`=$premiumSubscription"
, false);


if(count( $premium_themes ) != 0 )
  foreach ($premium_themes as $premium_theme) {
         $premium_theme['theme_type']="PREMIUM";
         $premium_theme['is_bought']=0;
       $themes[]=$premium_theme;
   }  
   }



 

echo json_encode($themes, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>