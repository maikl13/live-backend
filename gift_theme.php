<?php
include "config.php";
include "pay.php";
 
$theme =$_GET['theme'];
$sender =$_GET['sender'];
$receiver=$_GET['receiver'];

//todo
//started VIP 3 or above
$startedVIP3OrAboveDay="2023-07-29";
$data1=readRowFromSql("SELECT gifted_themes.id FROM `gifted_themes` WHERE `gifted_themes`.`sender`='$sender'", true);
$sent_theme_before=$data1!=null;
if($sent_theme_before){
    
    $currentDate =  date("Y-m-d");
    $firstPeridEndsDay=date('Y-m-d', strtotime($startedVIP3OrAboveDay. ' + 30 days'));
    $secondPeridEndsDay=date('Y-m-d', strtotime($startedVIP3OrAboveDay. ' + 60 days'));
    $thirdPeridEndsDay=date('Y-m-d', strtotime($startedVIP3OrAboveDay. ' + 90 days'));
    
    if ((strtotime($currentDate) >= strtotime($startedVIP3OrAboveDay)) && (strtotime($currentDate) <= strtotime($firstPeridEndsDay))){
    $myCurrentVIP_Period_start=$startedVIP3OrAboveDay;
     $myCurrentVIP_Period_end=$firstPeridEndsDay;
   
    } 
     if ((strtotime($currentDate ) >= strtotime( $firstPeridEndsDay)) && (strtotime( $currentDate) <= strtotime($secondPeridEndsDay ))){
    $myCurrentVIP_Period_start=$firstPeridEndsDay;
     $myCurrentVIP_Period_end=$secondPeridEndsDay;
    
    } 
     if ((strtotime( $currentDate) >= strtotime($secondPeridEndsDay )) && (strtotime($currentDate ) <= strtotime( $thirdPeridEndsDay))){
    $myCurrentVIP_Period_start=$secondPeridEndsDay;
     $myCurrentVIP_Period_end=$thirdPeridEndsDay;
     
    } 
 

    $sendBeforDuringTheSamePeriodCount=readRowFromSql("SELECT COUNT( gifted_themes.id ) as COUNT FROM `gifted_themes` WHERE `gifted_themes`.`sender`='$sender'
AND   gifted_themes.date BETWEEN '$myCurrentVIP_Period_start' AND '$myCurrentVIP_Period_end'", true)['COUNT'];
    
    if($sendBeforDuringTheSamePeriodCount==4){
        $result['message']='userHaveReachedTheirLimits';
         $result['success']=0;
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }else{
      
        insert($theme,$sender,$receiver);
    }
   
}else{
insert($theme,$sender,$receiver);
}
   
 

 function insert($theme,$sender,$receiver){
     $themeFoundAlreadyAsGift=readRowFromSql("SELECT `gifted_themes`.`id` FROM `gifted_themes` WHERE 
      `gifted_themes`.`receiver`='$receiver'
     AND `gifted_themes`.`theme`='$theme'
     ", true);
     
      $themeFoundAlreadyBought=readRowFromSql("SELECT `users_bought_themes`.`id` FROM `users_bought_themes` WHERE 
      `users_bought_themes`.`user_uid`='$receiver'
     AND `users_bought_themes`.`theme`='$theme'
     ", true);
     
         if($themeFoundAlreadyAsGift!=null||$themeFoundAlreadyBought!=null){
 $result['message']='themeFoundAlready';
$result['success']=0;
          }else{
               $price=readRowFromSql("SELECT `themes`.`golds` FROM `themes` WHERE `themes`.`id`=$theme", true)['golds'];
      if(payNow($sender,$price,'g')){
         
                      $insert = updateSql("INSERT INTO `gifted_themes` 
   (`id`, `theme`, `sender`, `receiver`, `date`)
   VALUES
   (NULL, '$theme', '$sender', '$receiver', CURDATE());


"); 
$result['message']='success';
$result['success']=1;
       }else{
      $result['message']='noEnoughGolds';
$result['success']=0;
       }
          }
  
     
        
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
 }
  
?>