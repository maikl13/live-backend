<?php




function getThemesByCategory($category_id,$uid){
        $select=readRowFromSql("SELECT `rooms`.`theme` FROM `rooms` WHERE `rooms`.`creator_uid`='$uid'", true);
$user_room_theme=$select['theme'];
$themes = readRowFromSql("SELECT `themes`.* , '$user_room_theme'=`themes`.`id` AS is_selected,
EXISTS (SELECT `users_bought_themes`.`user_uid` FROM `users_bought_themes` 
WHERE (`users_bought_themes`.`user_uid`='$uid' AND `users_bought_themes`.`theme`=`themes`.`id` AND users_bought_themes.available=1 ))||
EXISTS (SELECT `gifted_themes`.`id` FROM `gifted_themes` 
WHERE (`gifted_themes`.`receiver`='$uid' AND `gifted_themes`.`theme`=`themes`.`id` AND gifted_themes.available=1 ))

AS is_bought
FROM `themes` WHERE  `themes`.`category`=$category_id
", false);

  return $themes;
}

?>



