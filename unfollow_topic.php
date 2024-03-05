<?php
include "config.php";

$topic_id = $_GET['topic_id'];
$follower_uid = $_GET['follower_uid'];



$following = readRowFromSql("SELECT * FROM `topics_followers` WHERE `topics_followers`.`topic_id`='$topic_id' AND `topics_followers`.`follower_uid`='$follower_uid'", true);


if($following!=null&&$following!=""){
     
      
        $result = updateSql("DELETE FROM `topics_followers` WHERE `topics_followers`.`topic_id`=$topic_id AND `topics_followers`.`follower_uid`='$follower_uid'");
}


          
          
          
      


echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>