<?php
include "config.php";


$uid =$_GET['uid'];
$frame =$_GET['frame'];

$frameExists = readRowFromSql("SELECT users_unlocked_frames.id FROM `users_unlocked_frames` WHERE `users_unlocked_frames`.`user`='$uid' AND frame='$frame'", true);


if($frameExists==null){
    
     
        $result = updateSql("INSERT INTO `users_unlocked_frames` (`id`, `user`, `frame`, `datetime`) VALUES (NULL, '$uid', '$frame', CURDATE());");
        
      
} 




  echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


?>