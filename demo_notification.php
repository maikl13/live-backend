<?php

    $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
   $token= "cpL_BNQnTZOtpcC3nS1HNs:APA91bEaQhHlJQnNSj0oFpppYzEqGuQZHjNlyONfwbX3YgSK7dY8zcIRNB39dUbU6LTy-ixKOGtH3ObgO0mHvt_j7owXlHHbnhIIPuLfmu-PAlMjkP4igrvvjxPGQ2HTKfbfvJbQfB9k";
   $API_ACCESS_KEY="AAAAsbanIxs:APA91bGkQswhEi9CnSb1W_zXoWAnswtsbxAHmeoEmtFe4zbVKLN-DJsyFMfKT2VBFBs_4Y-s7TFUB4ZOsR7UOc-wedtQFRh2F1OuThEucx6XJV_rGajdG1Hit_j4uc2OKC7Kk-razCE1";
     $notification= [
      "title"=> "Your Title",
      "body"=> "Your Text",
      "icon"=> "Your Text",
      "sound"=> "mySound",
      "click_action"=> "OPEN_ACTIVITY_1"
  ];
  $extraNotificationData=[
      "message"=>$notification,"moredata"=>"dd"];
      
      $fcmNotificatio=[
      "to"=>"$token",
      "notification"=>$notification,
      "data"=>$extraNotificationData,
      
      ];
    
   
         $headers = [
    'Authorization: key=' . $API_ACCESS_KEY,
    'Content-Type: application/json'
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

    
    
    
    
    
    
    
    
    
    
    
    
?>