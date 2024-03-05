<?php
include "config.php";
///// our real code //////
$counters = readRowFromSql("SELECT * FROM `counter` ", false);

$result= array();
$datetime = new DateTime();
$now= $datetime->format( 'Y-m-d H:i:s' );
$hours = 2; 
foreach ($counters as $counter) {
$endTime=$counter['end_time'];
$id=$counter['id'];

$enddate_with_auction_id=$endTime.$id;


$total_previous_bids=4000.0;
$latest_bidder_name="not_yet";
$latest_bidder_image="not_yet";
$latest_bidder_uid="";

 $bidders = readRowFromSql("SELECT users.uid , SUM(auctions_bidders.bid_value) AS total_previous_bids , users.profile_pic, CONCAT(users.first_name,' ', users.last_name) AS full_name  FROM `auctions_bidders` 
          JOIN `counter` 
          ON counter.id = auctions_bidders.auction_id
           JOIN `users` 
          ON users.uid = auctions_bidders.bidder_uid   WHERE auctions_bidders.enddate_with_auction_id = '$enddate_with_auction_id' 
           GROUP BY users.uid  ORDER BY auctions_bidders.id "
          , false);
          
          foreach ($bidders as $bidder) {
              $total_previous_bids+=$bidder['total_previous_bids'];
              $latest_bidder_name=$bidder['full_name'];
               $latest_bidder_image=$bidder['profile_pic'];
                $latest_bidder_uid=$bidder['uid'];
          }
         
$counter['total_previous_bids']=$total_previous_bids;
$counter['latest_bidder_name']=$latest_bidder_name;
$counter['latest_bidder_image']=$latest_bidder_image;
$counter['latest_bidder_uid']=$latest_bidder_uid;





 
if($endTime > $now){
    $result[]=$counter;
}else{
     $newEndDate=$endTime;
     while($newEndDate < $now){
          $modified = (clone new DateTime($newEndDate, new DateTimeZone( "Africa/Cairo" )))->add(new DateInterval("PT{$hours}H"));
     $newEndDate= $modified->format('Y-m-d H:i:s');
     }
    $UPDATE_Result=updateSql("UPDATE `counter` SET `end_time` = '$newEndDate' WHERE `counter`.`id` = $id");
    if($UPDATE_Result){
      
        $edited_counter = readRowFromSql("SELECT * FROM `counter` WHERE `counter`.`id` = '$id'", true);
        $edited_counter['total_previous_bids']=4000.0;;
$edited_counter['latest_bidder_name']="not_yet";
$edited_counter['latest_bidder_image']="not_yet";
$edited_counter['latest_bidder_uid']="";
    
       
   $result[]= $edited_counter; 
           
    }else{
        echo "UPDATE faild"; 
    }
    
}

 
}
    







  
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
   

 

?>