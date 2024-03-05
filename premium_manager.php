 
<?php
 include "config.php";


function subscribeToPremium($user_uid,$subscription_level){
 $success = updateSql("UPDATE `users` SET `current_premium_subscription` = '$subscription_level' WHERE `users`.`uid` = '$user_uid';");
 $success = updateSql("INSERT INTO `premium_history` (`id`, `user`, `subscription`, `date`) VALUES (NULL, '$user_uid', '$subscription_level', NOW());");
 if($subscription_level>3){
     addMagicCardsToUser($user_uid,$subscription_level);
 }
 addActivationPost($user_uid,$subscription_level);
 return($success);
}
function subscriptionCancellation($user_uid){
 
 $success = updateSql("UPDATE `users` SET `current_premium_subscription` = NULL WHERE `users`.`uid` = '$user_uid'");
  
 return($success);
}
function addMagicCardsToUser($user_uid,$subscription_level){

    $count=0;
    if($subscription_level==4){
        $count=2;
    }
    if($subscription_level==5){
        $count=5;
    }
   
    //hats
    $mainTable='hats';
    $usersTable='users_hats';
    $column='hat';
     addMagicCardsToUserBySection($user_uid,$subscription_level,$mainTable,$usersTable,$column,$count);
  
    //crazywords
    $mainTable='crazy_words';
    $usersTable='users_crazywords';
    $column='crazyword';
     addMagicCardsToUserBySection($user_uid,$subscription_level,$mainTable,$usersTable,$column,$count);
    //voice_changers
 
    $mainTable='voice_changer';
    $usersTable='users_voice_changers';
    $column='voice_changer';
     addMagicCardsToUserBySection($user_uid,$subscription_level,$mainTable,$usersTable,$column,$count);
    
    
}
function addActivationPost($user_uid,$subscription_level){
    $title=readRowFromSql("SELECT  `premium_subscription`.`title`  FROM `premium_subscription` WHERE `premium_subscription`.`id`='$subscription_level'", true)['title'] ;
   $success = updateSql("INSERT INTO `posts` 
   (`id`, `publisher_uid`, `datetime`, `topic`, `text`, `privacy`, `location`, `shared_post`, `shared_room`, `premium_notify`) VALUES 
   (NULL, '$user_uid', CURRENT_TIMESTAMP, NULL, 'I got $title - Premium Membership', '0', '', NULL, NULL, '1');");
    
}
function addMagicCardsToUserBySection($user_uid,$subscription_level,$mainTable,$usersTable,$column,$count){
    $allInStore= readRowFromSql(" SELECT `$mainTable`.`id` FROM `$mainTable`", false) ;
   
    $allUserHave= readRowFromSql("SELECT `$usersTable`.`id` as id_in_users_table , `$usersTable`.`stock` ,`$mainTable`.`id` FROM `$mainTable` 
INNER JOIN `$usersTable` ON `$mainTable`.`id`=`$usersTable`.`$column` AND `$usersTable`.`user_uid`='$user_uid'
GROUP BY `$mainTable`.`id`", false);
  

    foreach($allInStore as $item){
 $id=$item['id'];
 $exist=false;
 $old_count_in_stock=0;
  $old_id;
  foreach($allUserHave as $allUserHaveItem){

      if($allUserHaveItem['id']==$id){
          $exist=true;
     $old_count_in_stock=$allUserHaveItem['stock'];
     $old_id=$allUserHaveItem['id_in_users_table'];
      }
  }
  
 if($exist){
   
 $newCount=$old_count_in_stock+$count;
 $result = updateSql("UPDATE `$usersTable` SET `stock` = $newCount WHERE `$usersTable`.`id` = $old_id;");
 
            }else{
 $result = updateSql("INSERT INTO `$usersTable` (`id`, `user_uid`, `$column`,
 `stock`) VALUES (NULL, '$user_uid', '$id', '$count');");
    }
  }
}
function getSubscriptionByProductId($product_id){
     switch ($product_id) {
          case 'premium1':
               $subscription_level=1;
        break;   
          case 'premium2':
               $subscription_level=2;
        break;   
          case 'premium3':
               $subscription_level=3;
        break;   
   }
  return $subscription_level;  
}
?>