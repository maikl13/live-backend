<?php
include "config.php";


$room =$_GET['room'];
 
 
$data=readRowFromSql("
 SELECT `roomLevel_requiredExp`.*,`rooms`.`total_exp`
FROM `rooms` 
 INNER JOIN `roomLevel_requiredExp` ON   `roomLevel_requiredExp`.`roomLevel`= `rooms`.`room_level`
WHERE   `rooms`.`id`='$room'",true);

 $totalExp=$data['total_exp'];
  $maxDailyExp = readRowFromSql("
  SELECT `constants`.`value` FROM `constants` WHERE
  `constants`.`constant_key`='room_max_daily_exp'",true
    )['value'];
    
 $roomLevel= $data['roomLevel'];
 
 $thisLevelRequiredExp  =$data['requiredExp'];
 
  $comingLevelData=readRowFromSql("
 SELECT `roomLevel_requiredExp`.`requiredExp`
FROM `roomLevel_requiredExp` 
WHERE   `roomLevel_requiredExp`.`roomLevel`=$roomLevel+1
",true    );
 $comingLevelRequiredExp= $comingLevelData['requiredExp'] ;
 $currentLevelAndComingLevelExpDiff=0;
 if($comingLevelRequiredExp!=null){
     $currentLevelAndComingLevelExpDiff=$comingLevelRequiredExp-$thisLevelRequiredExp;
     $expGainedAfterReachingCurrentLevel=$totalExp-$thisLevelRequiredExp;
 $progressValue=$expGainedAfterReachingCurrentLevel/$currentLevelAndComingLevelExpDiff;
  $reachedLasLevel=false;
 }else{
       $progressValue=1;
         $reachedLasLevel=true;
 }
 
 $progress= readRowFromSql(" SELECT `tasksToLevelUpRooms`.*,
 CASE WHEN `roomLevelTasksProgress`.`todayExp`  IS NULL THEN 0 ELSE `roomLevelTasksProgress`.`todayExp` END as todayExp
FROM `tasksToLevelUpRooms`
LEFT OUTER JOIN `roomLevelTasksProgress` ON `roomLevelTasksProgress`.`task` =`tasksToLevelUpRooms`.`id` AND `roomLevelTasksProgress`.`room`='$room'
  GROUP BY `tasksToLevelUpRooms`.`id`
"
    ,false);
    
    $progressResult=array();
    foreach($progress as $item){
       // $item['maxExp']=$maxDailyExp*(1/$item['maxPercentage']) ;
       $item['maxExp'] = ceil($maxDailyExp * (1 / $item['maxPercentage']));
        $progressResult[]=$item;
}

 
 
$result['progress']=$progressResult;    
$result['maxDailyExp']=$maxDailyExp;    
$result['level']=$roomLevel;    
$result['currentLevelAndComingLevelExpDiff']=$currentLevelAndComingLevelExpDiff;
$result['thisLevelRequiredExp']=$thisLevelRequiredExp;    
$result['comingLevelRequiredExp']=$comingLevelRequiredExp;    
$result['progressValue']=$progressValue;  
$result['reachedLastLevel']=$reachedLasLevel;  
$result['expGainedAfterReachingCurrentLevel']=$expGainedAfterReachingCurrentLevel;
 

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

?>