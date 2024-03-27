<?php

include('config/dbcon.php');


if(isset($_POST['updatePost'])) {
    $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
    $API_ACCESS_KEY = "AAAAsbanIxs:APA91bGkQswhEi9CnSb1W_zXoWAnswtsbxAHmeoEmtFe4zbVKLN-DJsyFMfKT2VBFBs_4Y-s7TFUB4ZOsR7UOc-wedtQFRh2F1OuThEucx6XJV_rGajdG1Hit_j4uc2OKC7Kk-razCE1";



    // Query to retrieve all tokens
    $sql = "SELECT fcm_token FROM users";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        // Array to store all tokens
        $tokens = array();

        // Fetch tokens from the result
        while($row = $result->fetch_assoc()) {
            $tokens[] = $row['fcm_token'];
        }

        // Close database connection
        $con->close();

        // Message content
        $title = $_POST['title'];
        $body = $_POST['body'];
        $notification = [
            "title" => $title,
            "body" => $body,
            "icon" => "Your Text",
            "sound" => "mySound",
            "click_action" => "OPEN_ACTIVITY_1"
        ];
        $extraNotificationData = [
            "message" => $notification,
            "moredata" => "dd"
        ];
        $fcmNotification = [
            "notification" => $notification,
            "data" => $extraNotificationData,
        ];

        // HTTP headers
        $headers = [
            'Authorization: key=' . $API_ACCESS_KEY,
            'Content-Type: application/json'
        ];

        // Initialize curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Loop through tokens and send notification to each one
        foreach ($tokens as $token) {
          $fcmNotification['to'] = $token;
          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
          $result = curl_exec($ch);
          if ($result === FALSE) {
              die('Curl failed: ' . curl_error($ch));
          }
      }

      // Close curl
      curl_close($ch);

      // Redirect to index.php after successful notification sending
      header("Location: notifications.php");
      exit();
  } else {
      echo "No tokens found in database.";
  }
}
?>
