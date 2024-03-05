<?php
include "config.php";
include "pay.php";
 
$auction = $_GET['auction'];
$user = $_GET['user'];
 
 
 $price=4000;
  $result=payNow($user,$price,'g');
  if($result){
       updateSql("UPDATE `counter` SET `previous_winner` = '$user' WHERE `counter`.`id` = $auction;");    
       restartAuction($auction);
  }
  
   function restartAuction($auction_id){
 
   updateSql("UPDATE `auctions_bidders` SET `auction_done`=1
   WHERE `auctions_bidders`.`auction_id` = '$auction_id'");       
  updateSql("   UPDATE `counter` SET `end_time` = TIMESTAMPADD(HOUR, 2,
  CURDATE()) WHERE `counter`.`id` = $auction_id;");       
 
}
 echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

?>