<?php
include "config.php";
include "pay.php";
include "notifications_manager.php";
include "room_level_manager.php";
//include "level_manager.php";

$sender_uid =$_GET['sender_uid'];

$place =$_GET['place'];
$count =$_GET['count'];
  $gift_id =$_GET['gift_id'];
$post_id="";
$room_id="";
$message_id="";
$uidsArray=array();
if($place=="moments"){
    $post_id =$_GET['post_id'];
   
}else if($place=="private"){
    
      $message_id =$_GET['message_id'];
   
}else{
    $room_id =$_GET['room_id'];
     $receivers_uids =$_GET['receivers_uids'];
    $uidsArray=json_decode($receivers_uids);
}




 

///////////////////////////////////////////////////////////////////////////////
$sender_data=readRowFromSql("SELECT `users`.`crystals`,`users`.`gold`
,`users`.`current_premium_subscription`
 ,`users`.`current_vip_subscription`
FROM `users` 
WHERE `users`.`uid`='$sender_uid'", true);
$sender_crystals=$sender_data['crystals'];
$sender_level=readRowFromSql("SELECT currentLevel
FROM  userInRoomLevelTotal 
WHERE userInRoomLevelTotal.user='$sender_uid'
AND userInRoomLevelTotal.room ='$room_id'", true)['currentLevel'];
if($sender_level==null){
    $sender_level=0;
}
$sender_gold=$sender_data['gold'];
$sender_is_premium=$sender_data['current_premium_subscription']==NULL?0:1;
$sender_is_vip=$sender_data['current_vip_subscription']==NULL?0:1;
 
 

///////////////////////////////////////////////////////////////////////////////
$gift_data=readRowFromSql("SELECT `gifts`.`value`, `gifts`.`section`,`gifts`.`currency_type`,`gifts`.`level`  FROM `gifts` WHERE `gifts`.`id`='$gift_id'", true);
$gift_value=$gift_data['value'];
$gift_currency_type=$gift_data['currency_type'];
$gift_level=$gift_data['level'];
$gift_section=$gift_data['section'];
///////////////////////////////////////////////////////////////////////////////
$usersCount=COUNT($uidsArray)==0?1:COUNT($uidsArray);
 $final_gift_value_according_to_count=($gift_value*$count)*$usersCount;
 
  $sentID="";
 $failingReasonCode="";
$sentSuccessfully=false;
$insertIt=false;


   

  
  if(
      ($gift_section==3 and $sender_is_premium) ||
      ($gift_section==4 and $sender_is_vip) ||
      ($place=="room" and $sender_level>=$gift_level and $gift_section ==2)||
     ( $gift_section!=2&& $gift_section!=3&& $gift_section!=4)
      ){
       
          if($gift_currency_type=="GOLD"){
             
              if($final_gift_value_according_to_count<=$sender_gold){
                     $failingReasonCode="Send"; 
                       //     echo 'ff';
                      // pay_gold($sender_gold//,$final_gift_value_according_to_count,$sender_uid);
                             payNow($sender_uid, $final_gift_value_according_to_count, 'g');
                       //rebate
                         
                       addGiftRebateToRebatesTable($sender_uid,$final_gift_value_according_to_count);
                 
                       $insertIt=true;
                  
              }else{
                  $failingReasonCode="NoEnoughGold"; 
               
              }
          }
          if($gift_currency_type=="CRYSTAL"){
              if($final_gift_value_according_to_count<=$sender_crystals){
                     $failingReasonCode="Send"; 
                     //pay_crystals($sender_crystals//,$final_gift_value_according_to_count,$sender_uid);
                     payNow($sender_uid, $final_gift_value_according_to_count, 'c');
                       $insertIt=true;
                   
              }else{
                  $failingReasonCode="NoEnoughCrystals"; 
              }
          }      
         
     }else{
 
      if($gift_section==3 and !$sender_is_premium){
      $failingReasonCode="NotPremium";
      }
      if($gift_section==4 and !$sender_is_vip){
      $failingReasonCode="NotVIP";
      }
     if($sender_level<$gift_level &&$place=="room"){
      $failingReasonCode="NotOnLevel";
      }
  }
   
 

$resultToBeBack=array();
$resultToBeBack["failingReasonCode"]=$failingReasonCode;
//$resultToBeBack["isJoined"]=false;

if($insertIt){
      
                   if($gift_currency_type=="GOLD"){

             $gift_currency_type_first_char='g';
       }else{
                $gift_currency_type_first_char='c';
       }
$app_owner_profit_percentage_from_golds_gifts=
readRowFromSql("SELECT  `value` FROM `constants` WHERE `constant_key`='app_owner_profit_percentage_from_golds_gifts'", true)['value'];

 

 

$owner_profit=(($gift_value*$count)*($app_owner_profit_percentage_from_golds_gifts/100));

    foreach($uidsArray as $receiver_uid){
        //
        $agency_profit=0;
 $user_in_agency= readRowFromSql("SELECT `agency`.`id` FROM `users`
INNER JOIN `agency` ON  `agency`.`id`= `users`.`agency_id`
WHERE `users`.`uid` = '$receiver_uid'", true);
if($user_in_agency!=null){
   $agency_profit_percentage=
readRowFromSql("SELECT  `value` FROM `constants` WHERE `constant_key`='agency_profit_percentage'", true)['value'];
$agency_profit=(($gift_value*$count)*($agency_profit_percentage/100));
$agency_id=$user_in_agency['id'];
 
  updateSql("UPDATE `agency` SET `balance` = balance+$agency_profit WHERE `agency`.`id` = $agency_id;");  
}
        //
        $received_gift_value=($gift_value*$count)-$owner_profit-$agency_profit;
         addToWallet($receiver_uid, $received_gift_value,$gift_currency_type_first_char);
         addHistory($sender_uid,$receiver_uid,$gift_id,$count,$agency_profit,$received_gift_value,$owner_profit);
    }
    

if($place=="moments"){
     $result = updateSql("INSERT INTO `posts_gifts` (`id`, `sender_uid`, `post_id`, `gift_id`, `count`, `send_datetime`) VALUES (NULL, '$sender_uid', $post_id, '$gift_id', '$count', CURRENT_TIMESTAMP);");
if($result){
  
     $resultToBeBack["sentSuccessfully"]=true; 
     
        $to_user= readRowFromSql("SELECT `posts`.`publisher_uid` FROM `posts` WHERE `posts`.`id`='$post_id'", true)['publisher_uid'];
      sendNotification( $to_user, $sender_uid,  'gift_post',   $post_id,   NULL);
         
}else{
     $resultToBeBack["sentSuccessfully"]=false; 
}
 
}else if($place=="private"){
     $result = updateSql("INSERT INTO `private_gifts` (`id`, `gift_id`, `count`, `send_datetime`, `message_id`) VALUES (NULL, '$gift_id', '$count', CURRENT_TIMESTAMP, '$message_id');");
if($result){
     $resultToBeBack["sentSuccessfully"]=true; 
}else{
     $resultToBeBack["sentSuccessfully"]=false; 
}

 
}else{

 
     foreach($uidsArray as $receiver_uid){

   
  
            
      $new = InsertAndGetId("INSERT INTO `users_gifts` (`id`, `sender_uid`, `receiver_uid`, `room_id`, `gift_id`, `count`, `send_datetime`) VALUES 
      (NULL, '$sender_uid', '$receiver_uid', $room_id, '$gift_id', '$count', CURRENT_TIMESTAMP);");
    

          $sentIDs[]=$new;
}
       $resultToBeBack["sentIDs"]=$sentIDs;
      $resultToBeBack["sentSuccessfully"]=true; 
    
       $repeats = floor($final_gift_value_according_to_count);

       if($gift_currency_type=="GOLD"){

           $task=1;
       }else{
           $task=2;
       }
           
   onRoomLevelTaskDone($sender_uid,$room_id,$task,$repeats);
    // onTaskDone($sender_uid,$repeats,1);
  
}

   
      
}else{
          $resultToBeBack["sentSuccessfully"]=false;
}
function addHistory($sender_uid,$receiver_uid,$gift_id,$count,$agency_profit,$receiver_profit,$owner_profit){
    InsertAndGetId("INSERT INTO `gifts_history_details`
(`id`, `sender_uid`, `receiver_uid`, `gift_id`, `count`, `agency_profit`, `receiver_profit`, `owner_profit`) VALUES
(NULL, '$sender_uid', '$receiver_uid', '$gift_id', '$count', '$agency_profit', '$receiver_profit', '$owner_profit');");
}

echo json_encode($resultToBeBack, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


?>