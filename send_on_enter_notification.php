<?php
 

//set up notifications//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function sendNotifications($fullname,$fcmNotificatio){
    $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
    $API_ACCESS_KEY="AAAAsbanIxs:APA91bGkQswhEi9CnSb1W_zXoWAnswtsbxAHmeoEmtFe4zbVKLN-DJsyFMfKT2VBFBs_4Y-s7TFUB4ZOsR7UOc-wedtQFRh2F1OuThEucx6XJV_rGajdG1Hit_j4uc2OKC7Kk-razCE1";
       $notification= [
        "title"=> "Wlcome Back $fullname!",
        "body"=> "Your friend on Live app have missed you!",
        "click_action"=> "OPEN_ROOM"
    ];
    $extraNotificationData=[
        "message"=>$notification,"moredata"=>""];
        
           $headers = [
      'Authorization: key=' . $API_ACCESS_KEY,
      'Content-Type: application/json'
    ];
   
  
   
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
  // echo 'fullname';
}

?>