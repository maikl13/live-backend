<?php
include "config.php";
 

$counters= readRowFromSql("
SELECT 
    `counter`.*, 
    GREATEST(0, 7200 - TIME_TO_SEC(TIMEDIFF(NOW(), counter.started_at))) < 1 AS time_is_up, 
    COALESCE(biddersCount.biddersCount, 0) AS biddersCount,
    latestBid.bidder_uid AS latest_bidder_uid
FROM 
    `counter`
LEFT JOIN (
    SELECT 
        auction_id, 
        COUNT(id) AS biddersCount 
    FROM 
        auctions_bidders 
    GROUP BY 
        auction_id
) AS biddersCount ON biddersCount.auction_id = counter.id
LEFT JOIN (
    SELECT 
        ab.auction_id, 
        ab.bid_value AS latest_bid_value, 
        ab.bidder_uid
    FROM 
        auctions_bidders ab
    INNER JOIN (
        SELECT 
            auction_id, 
            MAX(datetime) AS latest_datetime
        FROM 
            auctions_bidders 
        GROUP BY 
            auction_id
    ) AS latest_datetime ON ab.auction_id = latest_datetime.auction_id
    AND ab.datetime = latest_datetime.latest_datetime
) AS latestBid ON latestBid.auction_id = counter.id
WHERE 
      `counter`.`winner` IS NULL
ORDER BY 
    `place`;

", false);
 

$result= array();

foreach ($counters as $counter) {
 
$id=$counter['id'];




$total_previous_bids=4000.0;
$latest_bidder_name="not_yet";
$latest_bidder_image="not_yet";
$latest_bidder_uid="";

 $bidders = readRowFromSql("SELECT users.uid ,
  SUM(auctions_bidders.bid_value) AS total_previous_bids ,
   users.profile_pic,users.full_name   FROM `auctions_bidders` 
 JOIN `counter` 
 ON counter.id = auctions_bidders.auction_id
  JOIN `users` 
 ON users.uid = auctions_bidders.bidder_uid 
 WHERE auctions_bidders.auction_id = '$id' 
  GROUP BY users.uid  ORDER BY auctions_bidders.id  "
          , false);
          
          foreach ($bidders as $bidder) {
              $total_previous_bids+=$bidder['total_previous_bids'];
              $latest_bidder_name=$bidder['full_name'];
               $latest_bidder_image=$bidder['profile_pic'];
                $latest_bidder_uid=$bidder['uid'];
          }
 
$counter['latest_bid_value']=$total_previous_bids;
$counter['latest_bidder_name']=$latest_bidder_name;
$counter['latest_bidder_image']=$latest_bidder_image;
$counter['latest_bidder_uid']=$latest_bidder_uid;

 
$result[]=$counter;
 
}
    







  
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
   

 

?>