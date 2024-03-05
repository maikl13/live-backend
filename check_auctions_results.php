<?php
include "config.php";

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
 

 
$counters = readRowFromSql("SELECT * FROM `counter` 
WHERE ABS(TIMESTAMPDIFF(MINUTE, counter.end_time , NOW())) <= 5 ", false);
 
$my_result= array();

foreach ($counters as $counter) {
$endTime=$counter['end_time'];
$id=$counter['id'];
$enddate_with_auction_id=$endTime.$id;


$latest_bidder_name="no_bidders_yet";
$latest_bidder_uid="no_bidders_yet";

 $bidder = readRowFromSql("SELECT users.uid, users.fcm_token ,auctions_bidders.received_notification, auctions_bidders.bid_value , users.profile_pic, CONCAT(users.first_name,' ', users.last_name) AS full_name  FROM `auctions_bidders` 
          JOIN `counter` 
          ON counter.id = auctions_bidders.auction_id
           JOIN `users` 
          ON users.uid = auctions_bidders.bidder_uid
          WHERE auctions_bidders.enddate_with_auction_id = '$enddate_with_auction_id' AND auctions_bidders.received_notification = '0'
         
           GROUP BY users.uid  ORDER BY auctions_bidders.id  DESC LIMIT 1"
          , true);
          if($bidder!=""){
               $latest_bidder_name=$bidder['full_name'];
                $latest_bidder_uid=$bidder['uid'];
                $latest_bidder_fcm_token=$bidder['fcm_token'];
        
                  if($latest_bidder_uid!=""){ 
               
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
            
              $set_received_notification_and_win_true = updateSql("UPDATE `auctions_bidders` SET `win` = '1' ,`received_notification` = '1' WHERE `auctions_bidders`.`enddate_with_auction_id` = '$enddate_with_auction_id' AND  
                `auctions_bidders`.`bidder_uid` = '$latest_bidder_uid'
            
             ");
               /////////////////////////////////////////////////////////////////////////////////////////
                         
    $my_result[]=$latest_bidder_name;
                  }  
          
     
     
    
}
}


    
  
echo json_encode($my_result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
   

 

?>