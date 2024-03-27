<?php
include "config.php";
 
 
$user=$_GET['user_uid'];
 
 
$list=[];
 
/* todo icon
$user_earnings= readRowFromSql("SELECT *  FROM `users` WHERE `users`.`uid` = '$user'", true);
if($user_earnings){
     $botton['title_arabic']='أرباحي';
     $botton['title_english']='View my earnings';
     $botton['botton_icon']='botton_icon';
     $botton['link_to_open_on_click']='https://all-go.net/LiveFlutter/earnings/index.php';
     $list[]=$botton;
}
*/

//Create Agency

$user_create_agency = readRowFromSql("SELECT `users`.`agency_id` FROM `users` WHERE `users`.`uid` = '$user'", true)['agency_id'];

if ($user_create_agency === NULL) {    
    // تحقق مما إذا كان المستخدم غير موجود في جدول الوكالات بحقل owner_uid
    $agency_check = readRowFromSql("SELECT `owner_uid` FROM `agency` WHERE `owner_uid` = '$user'", true)['owner_uid'];
    
    if ($agency_check === NULL) {
        $botton['title_arabic'] = 'إنشاء وكالة';
        $botton['title_english'] = 'Create Agency';
        $botton['botton_icon'] = 'insurance.png';
        $botton['link_to_open_on_click'] = 'https://all-go.net/LiveFlutter/create_agency/index.php';
        $list[] = $botton;
    }
}


//JOIN Agency
$user_not_agency = readRowFromSql("SELECT `users`.`agency_id` FROM `users` WHERE `users`.`uid` = '$user'", true)['agency_id'];

if ($user_not_agency === NULL) {    
     $botton['title_arabic'] = 'انضم الى وكالة';
     $botton['title_english'] = 'Join Agency';
     $botton['botton_icon'] = 'insurance.png';
     $botton['link_to_open_on_click'] = 'https://all-go.net/LiveFlutter/agency/index.php';
     $list[] = $botton;
}


//View my agency
$user_in_agency= readRowFromSql("SELECT `users`.`agency_id`  FROM `users` WHERE `users`.`uid` = '$user'", true)['agency_id'];
 
if($user_in_agency!=NULL){    
     $botton['title_arabic']='عرض وكالتي';
     $botton['title_english']='View my agency';
     $botton['botton_icon']='insurance.png';
     $botton['link_to_open_on_click']='https://all-go.net/LiveFlutter/agency/index.php';
     $list[]=$botton;
}


//My Earnings

$user_earnings= readRowFromSql("SELECT `users`.`agency_id`  FROM `users` WHERE `users`.`uid` = '$user'", true)['agency_id'];
 
if($user_earnings!=NULL){    
     $botton['title_arabic']='أرباحي';
     $botton['title_english']='My Earnings';
     $botton['botton_icon']='insurance.png';
     $botton['link_to_open_on_click']='https://all-go.net/LiveFlutter/earnings/index.php';
     $list[]=$botton;
}


$user_owns_agency= readRowFromSql("SELECT `agency`.`id` FROM `agency` WHERE `agency`.`owner_uid`= '$user'", true);
if($user_owns_agency!=null){
     $botton['title_arabic']='ادارة وكالتي';
     $botton['title_english']='Manage my agency';
     $botton['botton_icon']='gear.png';
     $botton['link_to_open_on_click']='https://all-go.net/LiveFlutter/agency_panel/index.php';
     $list[]=$botton;
}
 

echo json_encode($list, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);



?>