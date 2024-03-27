<?php
 

 //set up notifications//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
  $API_ACCESS_KEY="AAAAsbanIxs:APA91bGkQswhEi9CnSb1W_zXoWAnswtsbxAHmeoEmtFe4zbVKLN-DJsyFMfKT2VBFBs_4Y-s7TFUB4ZOsR7UOc-wedtQFRh2F1OuThEucx6XJV_rGajdG1Hit_j4uc2OKC7Kk-razCE1";
     $notification= [
      "title"=> "Great News!",
      "body"=> "You've won the Auction!",
      "click_action"=> "OPEN_ACTIVITY_1"
  ];
  $extraNotificationData=[
      "message"=>$notification,"moredata"=>""];
      
         $headers = [
    'Authorization: key=' . $API_ACCESS_KEY,
    'Content-Type: application/json'
  ];
 
function updateAuctionsTimers(){
    global $pusher;
    $auctions=getAuctions();

    foreach($auctions as $auction){
       $remaining_seconds= $auction['remaining_seconds'];
       $place=$auction['place'];
   
       $data['place']= $place;
       $data['remaining_seconds']= $remaining_seconds;
       $update_timers_list[]=$data;
    //    $result = updateSql(" INSERT INTO `log`   (`id`, `text`, `created_at`) VALUES (NULL, 'place : ${place} , remaining_seconds : $remaining_seconds',NOW());");   
        if($remaining_seconds==0){
                onAuctionEnd($auction);
                if(($auction['biddersCount']>0)||($auction['sold']==1)){
            
               startAuction($place);
              
              //  $pusher->trigger('pin_on_top', 'auction_ended', '');
            }
             
        }else{
            //remain
        }
    }
    $pusher->trigger('pin_on_top', 'update_timer', $update_timers_list);
    
}

function onAuctionEnd($auction){
    global $extraNotificationData;
    global $notification;
    global $fcmUrl;
 
    $auction_id=$auction['id'];
   
    if($$auction['latest_bidder_uid']!=null){
        $lastBidder=$auction['latest_bidder_uid'];
        updateSql("UPDATE `counter` SET `ended`=1, `winner` = '$lastBidder' WHERE `counter`.`id` = $auction_id;");    

    }else{
        updateSql("UPDATE `counter` SET `ended`=1 WHERE `counter`.`id` = $auction_id;");    

    }
  
if($lastBidder!=NULL){ 
 
   
    /*
    $latest_bidder_fcm_token=$auction['latest_bidder_fcm_token'];
    //send notification   /////////////////////////////////////////////////////////////////
      $fcmNotificatio=[
      "to"=>"$latest_bidder_fcm_token",
      "notification"=>$notification,
      "data"=>$extraNotificationData,
     ];
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, $fcmUrl);
     curl_setopt($ch, CURLOPT_POST, true);
     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);  
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotificatio));
     $result = curl_exec($ch);           
     if ($result === FALSE) {
         die('Curl failed: ' . curl_error($ch));
     }
     curl_close($ch);
     echo $result;
     */
 
   $set_received_notification_and_win_true = updateSql("UPDATE `auctions_bidders` SET `win` = '1' ,`received_notification` = '1' WHERE `auctions_bidders`.`auction_id ` = '$auction_id' AND  
     `auctions_bidders`.`bidder_uid` = '$lastBidder'
 
  ");
    /////////////////////////////////////////////////////////////////////////////////////////
        
       }  
    
}
 function startAuction($place){
    global $pusher;
 updateSql("INSERT INTO `counter` (`id`, `started_at`, `winner`, `place`) VALUES (NULL, CURRENT_TIMESTAMP, NULL, '$place');"); 
 $pusher->trigger('pin_on_top', 'start_auction', '');      
}



function getAuctions(){
    $auctions= readRowFromSql("
    SELECT 
    c.id, 
    c.place, 
    c.sold, 
    GREATEST(0, 7200 - TIME_TO_SEC(TIMEDIFF(NOW(), c.started_at))) AS remaining_seconds, 
    COALESCE(biddersCount.biddersCount, 0) AS biddersCount,
    latestBid.bidder_uid AS latest_bidder_uid,
    u.fcm_token AS latest_bidder_fcm_token
FROM 
    (SELECT c1.id, c1.place, c1.sold, c1.started_at
     FROM counter c1
     JOIN (
         SELECT place, MAX(started_at) AS max_started_at
         FROM counter
         GROUP BY place
     ) AS max_dates ON c1.place = max_dates.place AND c1.started_at = max_dates.max_started_at) AS c
LEFT JOIN (
    SELECT 
        auction_id, 
        COUNT(id) AS biddersCount 
    FROM 
        auctions_bidders 
    GROUP BY 
        auction_id
) AS biddersCount ON biddersCount.auction_id = c.id
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
    ) AS latest_datetime ON ab.auction_id = latest_datetime.auction_id AND ab.datetime = latest_datetime.latest_datetime
) AS latestBid ON latestBid.auction_id = c.id
LEFT JOIN users u ON latestBid.bidder_uid = u.uid;

", false);
return $auctions;
}
          

 
?>

