<?php
include "config.php";

$user =$_GET['user'];
$room =$_GET['room'];
 
 $is_joined=readRowFromSql("SELECT `user_rooms`.`user_uid`  FROM `user_rooms` WHERE `user_rooms`.`user_uid`='$user' AND `user_rooms`.`room_id`='$room'
 AND `user_rooms`.`is_joined`=1",true )['user_uid'];

if($is_joined!=null){
    $data=readRowFromSql("
 SELECT `userInRoomLevel_requiredPoints`.*,`userInRoomLevelTotal`.`totalPoints`
FROM `userInRoomLevelTotal` 
 INNER JOIN `userInRoomLevel_requiredPoints` ON   `userInRoomLevel_requiredPoints`.`userInRoomLevel`= `userInRoomLevelTotal`.`currentLevel`
WHERE   `userInRoomLevelTotal`.`user`='$user'
 AND  `userInRoomLevelTotal`.`room` ='$room'",true
    );
 $totalPoints=     $data['totalPoints'];
 $maxDailyPoints= $data['maxDailyPoints'];
 $userInRoomLevel= $data['userInRoomLevel'];
 $thisLevelRequiredPoints  =$data['requiredPoints'];
 
 
 
  $comingLevelData=readRowFromSql("
 SELECT `userInRoomLevel_requiredPoints`.`requiredPoints`
FROM `userInRoomLevel_requiredPoints` 
WHERE   `userInRoomLevel_requiredPoints`.`userInRoomLevel`=($userInRoomLevel+1)
",true    );
 

 

 $comingLevelRequiredPoints= $comingLevelData['requiredPoints'] ;
 $currentLevelAndComingLevelPointsDiff=0;
 if($comingLevelRequiredPoints!=null){
     $currentLevelAndComingLevelPointsDiff=$comingLevelRequiredPoints-$thisLevelRequiredPoints;
 
 
  $pointsGainedAfterReachingCurrentLevel=$totalPoints-$thisLevelRequiredPoints;
  
       
       
 $progressValue=$pointsGainedAfterReachingCurrentLevel/$currentLevelAndComingLevelPointsDiff;
 
     $reachedLasLevel=false;
     $remainingPointsToLevelUp=$currentLevelAndComingLevelPointsDiff-$pointsGainedAfterReachingCurrentLevel;
 }else{
         $progressValue=1;
         $reachedLasLevel=true;
         $remainingPointsToLevelUp=0;
 }



 $progress= readRowFromSql(" SELECT `tasksToLevelUpUsersInRooms`.*,
 CASE WHEN `userInRoomLevelTasksProgress`.`todayPoints`  IS NULL THEN 0 ELSE `userInRoomLevelTasksProgress`.`todayPoints` END as todayPoints
FROM `tasksToLevelUpUsersInRooms`
LEFT OUTER JOIN `userInRoomLevelTasksProgress` ON `userInRoomLevelTasksProgress`.`task` =`tasksToLevelUpUsersInRooms`.`id` AND `userInRoomLevelTasksProgress`.`user`='$user'
AND `userInRoomLevelTasksProgress`.`room`='$room'
  GROUP BY `tasksToLevelUpUsersInRooms`.`id`
"
    ,false);
$progressResult=array();
$sumOtherMaxPoints=0;
 foreach($progress as $item){
       if($item['maxPoints']!=null){
            $sumOtherMaxPoints+=$item['maxPoints'];
     }

 }
 foreach($progress as $item){
     if($item['maxPoints']==null){
         $item['maxPoints']=$maxDailyPoints-$sumOtherMaxPoints;
     }
     $progressResult[]=$item;
 }
$result['progress']=$progressResult;    
$result['maxDailyPoints']=$maxDailyPoints;    
$result['level']=$userInRoomLevel;    
$result['currentLevelAndComingLevelPointsDiff']=$currentLevelAndComingLevelPointsDiff;    
$result['thisLevelRequiredPoints']=$thisLevelRequiredPoints;    
$result['comingLevelRequiredPoints']=$comingLevelRequiredPoints;    
$result['progressValue']=$progressValue;  
$result['reachedLastLevel']=$reachedLasLevel;  
$result['remainingPointsToLevelUp']=$remainingPointsToLevelUp;  


echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

}else{
  $result['success']=false;  
$result['message']="user not a room member";  


echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
  
}

?>