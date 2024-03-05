<?php
include "config.php";

$premium_subscription = $_GET['premium_subscription'];
//$premium_subscription_title = $_GET['premium_subscription_title'];

  
  
$premium_privileges = readRowFromSql("SELECT premium_privileges.* ,`premium_subscription`.`title` AS minimum_premium_subscription_title , `premium_privileges`.`minimum_premium_subscription`
<= '$premium_subscription' AS available  FROM `premium_privileges` 
 INNER JOIN premium_subscription ON `premium_subscription`.`id` = `premium_privileges`.`minimum_premium_subscription`
", false);

$current_premium_subscription_title = readRowFromSql("SELECT *  FROM premium_subscription WHERE `id`= '$premium_subscription'
", true);


 $result = array();

   foreach ($premium_privileges as $premium_privilege) {
         $static_description=$premium_privilege["static_description"];
         
          $available=$premium_privilege["available"];
          if($available){
               if($static_description){
          $description=$premium_privilege["description"];
      }else{
          //todo switch
          switch($premium_privilege["id"]){
              case "1":
                  $description="Exclusive ${current_premium_subscription_title['title']} badge";
                break;
              case "13":
                  $description="Add up to ${current_premium_subscription_title['max_friends_num']} friends";
                break;
               case "14":
                  $description="Add up to ${current_premium_subscription_title['max_followers_num']} followers";
                break;
            case "15":
                  $description="${current_premium_subscription_title['increase_to_level_speed']} times increase to level speed";
            break; 
               case "18":
                  $description="Complete set of magic cards x ${current_premium_subscription_title['max_magic_cards']}  ";
            break; 
               case "20":
                  $description="${current_premium_subscription_title['sending_gifts_discount']}% coins discount on sending gifts";
            break; 
                      case "21":
                  $description="${current_premium_subscription_title['store_discount']}% discount on store purchases";
            break; 
                
          }
      } 
          }else{
             
          $description="Available only to ${premium_privilege['minimum_premium_subscription_title']} and above";
          }
         
         $premium_privilege['description']=$description;
    $result[]=$premium_privilege;
      
    
   }
   




echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>