<?php
include "config.php";

$user= $_GET['user'];
 

$auctions=getAuctions();

foreach($auctions as $auction){
    if($auction['done']==1){
            $auction_id=$auction['id'];
        if($auction['biddersCount']>0){
        
            $lastBidder=$auction['bidder_uid'];
            setWinnerToTheOldAuction($auction_id,$lastBidder);
             restartAuction($auction_id);
        }
         
    }
}
$result=getAuctions();
function setWinnerToTheOldAuction($auction_id){
   
   updateSql("UPDATE `counter` SET `previous_winner` = '$lastBidder' WHERE `counter`.`id` = $auction_id;");    
   updateSql("UPDATE `auctions_bidders` SET `win` = '1' WHERE 
   `auctions_bidders`.`auction_id` = '$auction_id' AND 
   `auctions_bidders`.`bidder_uid` = '$lastBidder'");       
        
}
 function restartAuction($auction_id){
 
   updateSql("UPDATE `auctions_bidders` SET `auction_done`=1
   WHERE `auctions_bidders`.`auction_id` = '$auction_id'");       
  updateSql("   UPDATE `counter` SET `end_time` = TIMESTAMPADD(HOUR, 2,
  CURDATE()) WHERE `counter`.`id` = $auction_id;");       
 
}


function getAuctions(){
    $auctions= readRowFromSql("
SELECT 
    counter.*,
    (counter.end_time < CURDATE()) AS done,
    COALESCE(biddersCount.biddersCount, 0) AS biddersCount,
    lastBidder.latest_bidder_name,
     lastBidder.latest_bidder_image,
    lastBidder.latest_bid_value
FROM
    `counter`
LEFT JOIN (
    SELECT
        auction_id,
        COUNT(id) AS biddersCount
    FROM
        auctions_bidders
    WHERE
        auction_done = 0
    GROUP BY
        auction_id
) AS biddersCount
ON
    biddersCount.auction_id = counter.id
LEFT JOIN (
    SELECT
        auction_id,
        bidder_uid,
        bid_value as latest_bid_value,
        users.full_name  as latest_bidder_name,
        users.profile_pic  as latest_bidder_image
    FROM
        auctions_bidders
 INNER JOIN users on users.uid= auctions_bidders.bidder_uid
    WHERE
        auction_done = 0
    ORDER BY
        datetime DESC
) AS lastBidder
ON
    lastBidder.auction_id = counter.id
GROUP BY
    counter.id;
", false);
return $auctions;
}
          

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>

