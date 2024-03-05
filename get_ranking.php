<?php
include "config.php";
///// our real code //////

$rank_groups = readRowFromSql("SELECT * FROM `rank_groups` ", false);
$result       = array();

foreach ($rank_groups as $rank_group) {
 

    // مفيش حاجة اسمها اكتر 30 واحد ااستقبلو هدايا وخلاص مثلا لا الموضوع متقسم حسب الفترة الزمنية يعنى مثلا مين اكتر 30 واحد اتبعتلهم هدايا فى اخر ساعة ؟ كدا يعنى
    
    $hour = array();
    $day = array();
    $week = array();
    $month = array();

 switch ($rank_group['key']) {
  case 0:
  //المرتبة حسب قيمة القطع الذهبية للهدايا الى اتبعت فى الغرفة (دى تبع الغرف مش الاشخاص يعنى )
//Room gifts
          $hour = getCase0List("HOUR");
          $day = getCase0List("DAY");
          $week = getCase0List("WEEK");
          $month = getCase0List("MONTH");
    break;
  case 1:
 //المرتبة حسب قيمة القطع الذهبية للهدايا الى المستخدم ارسلها (دى خاصة بالمستخدمين يعنى)
  //  Sent gifts
          $hour = getCase1List("HOUR");
          $day = getCase1List("DAY");
          $week = getCase1List("WEEK");
          $month = getCase1List("MONTH");
          
    break;
  case 2:
       //المرتبة حسب قيمة القطع الذهبية للهدايا الى المستخدم استقبلها من الناس التانية (دى خاصة بالمستخدمين يعنى)
  
   //Received gifts
          $hour = getCase3List("HOUR");
          $day = getCase3List("DAY");
          $week = getCase3List("WEEK");
          $month = getCase3List("MONTH");
          
    break;
   case 3:
     //المرتبة حسب اجمالى كمية القطع الذهبية الى قام المستخدم باعادة شحنها (دى خاصة بالمستخدمين يعنى)

   //Live billionaire
         
            $hour = getCase2List("HOUR");
          $day = getCase2List("DAY");
          $week = getCase2List("WEEK");
          $month = getCase2List("MONTH");
    break;
  
}


  
          
       
       

 
  
   
  
    $rank_group["hour"]=$hour;  
    $rank_group["day"]=$day;  
    $rank_group["week"]=$week;  
    $rank_group["month"]=$month; 
    $result[] = $rank_group;
}
 function getCase0List(String $period) {
       //المرتبة حسب قيمة القطع الذهبية للهدايا الى اتبعت فى الغرفة (دى تبع الغرف مش الاشخاص يعنى )
     $data=array();
      $data = readRowFromSql("SELECT rooms.id, rooms.title ,rooms.image AS icon , SUM(value) AS coins, users_gifts.send_datetime  FROM `rooms` 
          JOIN `users_gifts` 
          ON rooms.id = users_gifts.room_id 
          JOIN `gifts` 
          ON gifts.id = users_gifts.gift_id 
          WHERE users_gifts.send_datetime >= DATE_SUB(NOW(),INTERVAL 1 $period)
          GROUP BY rooms.id ORDER BY coins DESC LIMIT 30"
          , false);
  return $data;
}
 function getCase1List(String $period) {
      //المرتبة حسب قيمة القطع الذهبية للهدايا الى المستخدم ارسلها (دى خاصة بالمستخدمين يعنى)
    $data=array();
      $data = readRowFromSql("SELECT users.uid AS id,full_name AS title,users.profile_pic AS icon , SUM(value)  AS coins, users_gifts.send_datetime  FROM `users_gifts` 
          JOIN `users` 
          ON users.uid = users_gifts.sender_uid 
          JOIN `gifts` 
          ON gifts.id = users_gifts.gift_id 
          WHERE users_gifts.send_datetime >= DATE_SUB(NOW(),INTERVAL 1 $period)
          GROUP BY users.uid ORDER BY coins DESC LIMIT 30"
          , false);
  return $data;
}
 function getCase2List(String $period) {
      //المرتبة حسب اجمالى كمية القطع الذهبية الى قام المستخدم باعادة شحنها (دى خاصة بالمستخدمين يعنى)
     $data=array();
      $data = readRowFromSql("SELECT users.uid AS id,full_name AS title,users.profile_pic AS icon , SUM(coins_packages.value_in_coins)  AS coins, recharge.recharge_datetime  FROM `recharge` 
          JOIN `users` 
          ON users.uid = recharge.user_id 
          JOIN `coins_packages` 
          ON recharge.coins_package_id = coins_packages.id 
          WHERE recharge.recharge_datetime >= DATE_SUB(NOW(),INTERVAL 1 $period)
          GROUP BY users.uid ORDER BY coins DESC LIMIT 30"
          , false);
  return $data;
}
function getCase3List(String $period) {
      //المرتبة حسب قيمة القطع الذهبية للهدايا الى المستخدم استقبلها من الناس التانية (دى خاصة بالمستخدمين يعنى)
   
     $data=array();
      $data = readRowFromSql("SELECT users.uid AS id,full_name AS title,users.profile_pic AS icon , SUM(value)  AS coins, users_gifts.send_datetime  FROM `users_gifts` 
          JOIN `users` 
          ON users.uid = users_gifts.receiver_uid 
          JOIN `gifts` 
          ON gifts.id = users_gifts.gift_id 
          WHERE users_gifts.send_datetime >= DATE_SUB(NOW(),INTERVAL 1 $period)
          GROUP BY users.uid ORDER BY coins DESC LIMIT 30"
          , false);
  return $data;
}
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>