<?php




function getRoomsEssentialData($rooms){
    foreach ($rooms as $room) {
         
    
        
       $country['id']=$room['country'];
$country['name']=$room['country_name'];
$country['flag']=$room['country_flag'];
$room['country']=$country;
 

 $hashtag['id']=$room['hashtag_id'];
$hashtag['title']=$room['hashtag_title'];
$room['hashtag']=$hashtag;

  unset($room['hashtag_id']);
       unset($room['hashtag_title']);
    $result[]= $room;
}
 return $result;
}
function getRoomsFullData($rooms){
    foreach ($rooms as $room) {
    $id = $room["id"];
    
  
    $members = readRowFromSql("SELECT user_rooms.is_joined
    , `users`.`uid`
    , `users`.`short_digital_id` 
    , `users`.`profile_pic` 
    , `users`.`full_name` 
    , `users`.`gender` 
    , `users`.`level` 
    , `users`.`bio` 
    FROM user_rooms
    INNER JOIN users ON users.uid=user_rooms.user_uid WHERE  room_id='$id' AND user_rooms.is_online", false);
     $room["members"]=$members;  
    $channel_name    = $room["channel_name"];
    $creator_uid    = $room["creator_uid"];
     $title    = $room["title"];
     $description    = $room["description"];
     $image    = $room["image"];
      $room_type   = $room["room_type"];
            $channel_token   = $room["channel_token"];
            
       $country['id']=$room['country'];
$country['name']=$room['country_name'];
$country['flag']=$room['country_flag'];
$room['country']=$country;
           $themeID=$room['theme'];
            switch($room['theme_type']){
              
                case "CUSTOM":
              $get_theme = readRowFromSql("SELECT `custom_themes`.`image` FROM `custom_themes` WHERE  `custom_themes`.`id`=$themeID", true);
                    break;
                case "PREMIUM":
             $get_theme = readRowFromSql("SELECT `premium_themes`.`image` FROM `premium_themes` WHERE `premium_themes`.`id`=$themeID", true);        
                    break;   
                   
                case "STORE":
                  
              $get_theme = readRowFromSql("SELECT `themes`.`image` FROM `themes` WHERE `themes`.`id`=$themeID", true);     
    
                    break; 
            }
            
            $theme   = $get_theme['image'];
            $room['theme']=$theme;        
            
    $result[]= $room;
}
  return $result;
}



function getRoomExtraData($room){
    
    
$room["members"]=[];  
           $id = $room["id"];
         
    
    $channel_name    = $room["channel_name"];
    $creator_uid    = $room["creator_uid"];
     $title    = $room["title"];
     $description    = $room["description"];
     $image    = $room["image"];
      $room_type   = $room["room_type"];
            $channel_token   = $room["channel_token"];
            
       $country['id']=$room['country'];
$country['name']=$room['country_name'];
$country['flag']=$room['country_flag'];
$room['country']=$country;
           $themeID=$room['theme'];
            switch($room['theme_type']){
              
                case "CUSTOM":
              $get_theme = readRowFromSql("SELECT `custom_themes`.`image` FROM `custom_themes` WHERE  `custom_themes`.`id`=$themeID", true);
                    break;
                case "PREMIUM":
             $get_theme = readRowFromSql("SELECT `premium_themes`.`image` FROM `premium_themes` WHERE `premium_themes`.`id`=$themeID", true);        
                    break;   
                   
                case "STORE":
                  
              $get_theme = readRowFromSql("SELECT `themes`.`image` FROM `themes` WHERE `themes`.`id`=$themeID", true);     
    
                    break; 
            }
            
            $theme   = $get_theme['image'];
            $room['theme']=$theme;        
             $hashtag['id']=$room['hashtag_id'];
$hashtag['title']=$room['hashtag_title'];
$room['hashtag']=$hashtag;

  unset($room['hashtag_id']);
       unset($room['hashtag_title']);
 
  return $room;
}

?>