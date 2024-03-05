<?php

    $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
   $token= "fI4A74wUSMevQnJF1yn3yp:APA91bEBho4Qf0_1cQdnr5yeYlLe8QqlX6KGvujxCzzpMXY8_o4QF_ZQQraFt4pJCkv75H0Ti-_1tczhOCtSi5QMfrXsuEJP16VoN9qikecebelVVI-j-Y_LpZvEe6Np9u83FtigTrz5";
   $API_ACCESS_KEY="AAAAsbanIxs:APA91bGkQswhEi9CnSb1W_zXoWAnswtsbxAHmeoEmtFe4zbVKLN-DJsyFMfKT2VBFBs_4Y-s7TFUB4ZOsR7UOc-wedtQFRh2F1OuThEucx6XJV_rGajdG1Hit_j4uc2OKC7Kk-razCE1";
     $notification= [
      "title"=> "Test",
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