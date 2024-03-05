<?php
include "config.php";

$user =$_GET['user'];
$task =$_GET['task'];
$room =$_GET['room'];
$pointsRepetitions =$_GET['pointsRepetitions'];
onTaskDone($user,$room,$task,$pointsRepetitions);
  
function onTaskDone($user,$room,$task,$pointsRepetitions)
{
     $userInRoomData=readRowFromSql("SELECT `userInRoomLevelTotal`.`currentLevel` ,`userInRoomLevelTotal`.`totalPoints` FROM `userInRoomLevelTotal` WHERE 
`userInRoomLevelTotal`.`user`='$user' AND
`userInRoomLevelTotal`.`room`='$room' "
  ,true  ) ;
 $userInRoomLevel=$userInRoomData['currentLevel'];
  $previusTotalPoints=$userInRoomData['totalPoints'];
  if($previusTotalPoints==null){
      $previusTotalPoints=0;
  }

 $max_daily_points = readRowFromSql("SELECT `userInRoomLevel_requiredPoints`.`maxDailyPoints` FROM `userInRoomLevel_requiredPoints` WHERE  `userInRoomLevel_requiredPoints`.`userInRoomLevel`='$userInRoomLevel'"
    ,true)['maxDailyPoints'];

   
    $task_reward_points= readRowFromSql("SELECT `tasksToLevelUpUsersInRooms`.`taskPoints` FROM `tasksToLevelUpUsersInRooms` WHERE `tasksToLevelUpUsersInRooms`.`id`='$task'
    ",true )['taskPoints'];
    if($task==4){
        $task_reward_points=$task_reward_points*$pointsRepetitions;
    }

   $this_task_max_daily_points= readRowFromSql("SELECT `tasksToLevelUpUsersInRooms`.`maxPoints` FROM `tasksToLevelUpUsersInRooms` WHERE `tasksToLevelUpUsersInRooms`.`id`='$task'",true
    )['maxPoints'];
    
 
    if($this_task_max_daily_points==null){
        $summaxPoints=
       readRowFromSql("SELECT SUM( `tasksToLevelUpUsersInRooms`.`maxPoints`) as summaxPoints FROM `tasksToLevelUpUsersInRooms`"
    )['summaxPoints'];
        $this_task_max_daily_points=$max_daily_points-$summaxPoints;
    }
    
    

    
    $this_task_points_for_today = readRowFromSql("
    SELECT `userInRoomLevelTasksProgress`.`todayPoints` FROM `userInRoomLevelTasksProgress` WHERE 
`userInRoomLevelTasksProgress`.`room`='$room' AND
`userInRoomLevelTasksProgress`.`user`='$user' AND
`userInRoomLevelTasksProgress`.`task`='$task'",true )['todayPoints'];

 
    
if($this_task_points_for_today==null){
    $this_task_points_for_today=0;
}

    if($this_task_points_for_today<$this_task_max_daily_points){
    
        if($this_task_points_for_today+$task_reward_points>$this_task_max_daily_points){
            $task_reward_points=$this_task_max_daily_points-$this_task_points_for_today;
        }
        $old_id=readRowFromSql("
  SELECT `userInRoomLevelTasksProgress`.`id` FROM `userInRoomLevelTasksProgress` WHERE 
 `userInRoomLevelTasksProgress`.`room`='$room' AND
 `userInRoomLevelTasksProgress`.`task`='$task' AND
 `userInRoomLevelTasksProgress`.`user`='$user'",true)['id'];
        if($old_id!=null){
            
              updateSql( "   UPDATE `userInRoomLevelTasksProgress` SET `todayPoints` =`todayPoints`+$task_reward_points WHERE `userInRoomLevelTasksProgress`.`id` = $old_id;" );
        }else{
             
 updateSql( "INSERT INTO `userInRoomLevelTasksProgress`
(`id`, `room`, `user`, `task`, `todayPoints`) VALUES
(NULL,'$room','$user','$task','$task_reward_points')
 " );
    }
    updateSql( "UPDATE `userInRoomLevelTotal` SET `userInRoomLevelTotal`.`totalPoints` = `totalPoints`+$task_reward_points WHERE
                 `userInRoomLevelTotal`.`room`='$room' AND
                 `userInRoomLevelTotal`.`user`='$user'" );
            }
    
            levelUpIfPossible($userInRoomLevel,$task_reward_points,$room,$previusTotalPoints,$user);
  
     
}
 
function levelUpIfPossible($userInRoomLevel,$task_reward_points,$room,$previusTotalPoints,$user) {
    $nextLevelRequiredPoints = readRowFromSql("SELECT `userInRoomLevel_requiredPoints`.`requiredPoints` FROM `userInRoomLevel_requiredPoints` WHERE  `userInRoomLevel_requiredPoints`.`userInRoomLevel` = $userInRoomLevel+1",true )['requiredPoints'];
    if($nextLevelRequiredPoints!=null){
    if ($previusTotalPoints + $task_reward_points >= $nextLevelRequiredPoints) {
        $update_level = updateSql( "UPDATE `userInRoomLevelTotal` SET `currentLevel` = currentLevel+1 WHERE
`userInRoomLevelTotal`.`room`='$room' AND
`userInRoomLevelTotal`.`user`='$user'" );
    }
    }
           
}
 
?>