<?php
include "config.php";
include "pay.php";
 
 
 $user=$_GET['user'];
 $auction =$_GET['auction'];
 $bid_value=$_GET['bid_value'];
 $result=array();

$biddedBeforeInSameAuction=readRowFromSql("
SELECT `auctions_bidders`.`id` FROM `auctions_bidders` 
WHERE `auctions_bidders`.`auction_id`='$auction' 
AND `auctions_bidders`.`bidder_uid`='$user' ",
 true)!=null;

$biddedBeforeInOtherAuction=readRowFromSql("SELECT `auctions_bidders`.`id`
 FROM `auctions_bidders` WHERE `auctions_bidders`.`auction_id`!='$auction'
  AND `auctions_bidders`.`bidder_uid`='$user'", true)!=null;

$outbidded=readRowFromSql("SELECT `auctions_bidders`.`bidder_uid` 
FROM `auctions_bidders` WHERE `auctions_bidders`.`auction_id`='$auction' 
ORDER BY `auctions_bidders`.`datetime` DESC",
true)['bidder_uid']!=$user;




if($biddedBeforeInOtherAuction){
     $result['succeeded']='false';
    $result['message']='you can not bid in two auctions at the same time';  
   
}else{
  
  if($biddedBeforeInSameAuction){
   
     if($outbidded){
       $result=  bid($user,$auction,$bid_value);
     }else{
    $result['succeeded']='false';
    $result['message']='you can not outbid yourself';  
     }
 
 }else{

      $result=  bid($user,$auction,$bid_value);
 }  
}
 
function bid($user,$auction,$bid_value){

  if(payNow($user,$bid_value,'g')){
      refundThePreviousBidderIfFound($auction);
    //  echo 'dd';
   
    updateSql("INSERT INTO `auctions_bidders`
     (`id`, `auction_id`, `bidder_uid`, `bid_value`, `win`,
      `received_notification`, `datetime`) VALUES 
      (NULL, '$auction', '$user', '$bid_value',
       '0', '0',   CURRENT_TIMESTAMP);");  
    $result['succeeded']='true';
    $result['message']='';  

  }else{
    $result['succeeded']='false';
    $result['message']='you do not have enough money';  
  }
return $result;
      

}
 function refundThePreviousBidderIfFound($auction){
     $lastBidder=readRowFromSql("SELECT `auctions_bidders`.`bidder_uid`,
      `auctions_bidders`.`bid_value` FROM `auctions_bidders` 
      WHERE `auctions_bidders`.`auction_id`='$auction' 
ORDER BY `auctions_bidders`.`datetime` DESC",
true);
$bidder_uid=$lastBidder['bidder_uid'];
$bid_value=$lastBidder['bid_value'];
 updateSql("INSERT INTO `wallet_transfers` 
 (`id`, `value`, `wallet_type`, `reason`, `transfer_type`, `datetime`, `user`)
 VALUES 
 (NULL, '$bid_value', 'g', 'bidRefund', 'deposit', CURRENT_TIMESTAMP, '$bidder_uid');");
  addToWallet($bidder_uid, $bid_value, 'g');

 }


echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>