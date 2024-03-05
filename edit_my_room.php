<?php
include "config.php";

$user_uid =$_GET['user_uid'];
$key =$_GET['key'];
$value =$_GET['value'];

$keyAPI;
switch($key){
    case "roomName":
        $keyAPI="title";
        break;
         case "announcement":
        $keyAPI="description";
        break;  
           case "image":
        $keyAPI="image";
        break;  
            case "tag":
        $keyAPI="hashtag";
        break; 
             case "fee":
        $keyAPI="membership_fee";
        break; 
              case "numberOfMic":
        $keyAPI="number_of_mics";
        break; 
           case "allowAdminsToLockOrUnlockTheMic":
        $keyAPI="allow_admins_to_lock_or_unlock_the_mic";
        break; 
            case "allowAdminsToTurnOnOrOffTheMicApplication":
        $keyAPI="allow_admins_to_turn_on_or_off_the_mic_application";
        break; 
           case "allowAdminsToManageEvents":
        $keyAPI="allow_admins_to_manage_events";
        break; 
           case "allowGuestsToEnter":
        $keyAPI="allow_guests_to_enter";
        break; 
             case "roomPasscode":
        $keyAPI="enter_lock";
        break;
              case "micForMembersOnly":
        $keyAPI="mic_for_members_only";
        break; 
        
}



   
   
   $result = updateSql("UPDATE `rooms` SET `$keyAPI` = '$value' WHERE `rooms`.`creator_uid`='$user_uid';");
        

  


   
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>