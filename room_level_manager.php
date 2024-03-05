<?php
 
function onRoomLevelTaskDone($user,$room,$task,$expRepetitions)
{


 $previusTotalExp= readRowFromSql("SELECT `rooms`.`total_exp` FROM  `rooms` WHERE `rooms`.`id`='$room'",true
    )['total_exp'];
 $room_max_daily_exp = readRowFromSql("
  SELECT `constants`.`value` FROM `constants` WHERE
  `constants`.`constant_key`='room_max_daily_exp'",true
    )['value'];

 $userCurrentTodayExpToSpendInRooms = readRowFromSql("SELECT `users_todayExpToSpendInRooms`.`todayExpToSpendInRooms` FROM `users_todayExpToSpendInRooms` WHERE `users_todayExpToSpendInRooms`.`user`='$user'"
    ,true)['todayExpToSpendInRooms'];
    
    $task_reward_exp= readRowFromSql("SELECT `tasksToLevelUpRooms`.`taskExp` FROM `tasksToLevelUpRooms` WHERE `tasksToLevelUpRooms`.`id`='$task'
    ",true )['taskExp'];

 
  if($userCurrentTodayExpToSpendInRooms==null){
      $userCurrentTodayExpToSpendInRooms= readRowFromSql("SELECT `constants`.`value` FROM `constants` WHERE
      `constants`.`constant_key`='users_daily_exp_to_spend_in_rooms'
    ",true )['value'];
  }

  if($userCurrentTodayExpToSpendInRooms!=0&&
  $userCurrentTodayExpToSpendInRooms-$task_reward_exp>=0){

        $this_task_max_daily_percentage= readRowFromSql("SELECT `tasksToLevelUpRooms`.`maxPercentage` FROM `tasksToLevelUpRooms` WHERE `tasksToLevelUpRooms`.`id`='$task'",true
    )['maxPercentage'];

      $this_task_max_daily_exp =(1/$this_task_max_daily_percentage)*$room_max_daily_exp*$expRepetitions;
     
    $this_task_exp_for_today = readRowFromSql("
    SELECT `roomLevelTasksProgress`.`todayExp` FROM `roomLevelTasksProgress` WHERE  `roomLevelTasksProgress`.`room` ='$room' AND
     `roomLevelTasksProgress`.`task`='$task'",true )['todayExp'];
     if($this_task_exp_for_today==null){
    $this_task_exp_for_today=0;
}
          
       
    if($this_task_exp_for_today<$this_task_max_daily_exp){
     
         if($this_task_exp_for_today+$task_reward_exp>$this_task_max_daily_exp){
            $task_reward_exp=$this_task_max_daily_exp-$this_task_exp_for_today;
        }
        
           
        $old_id=readRowFromSql("
  SELECT `roomLevelTasksProgress`.`id` FROM `roomLevelTasksProgress` WHERE 
 `roomLevelTasksProgress`.`room`='$room' AND
 `roomLevelTasksProgress`.`task`='$task' AND
 `roomLevelTasksProgress`.`user`='$user'",true)['id'];
   
        if($old_id!=null){
              updateSql( "   UPDATE `roomLevelTasksProgress` SET `todayExp` =`todayExp`+$task_reward_exp WHERE `roomLevelTasksProgress`.`id` = $old_id;" );
        }else{
        
             updateSql( " INSERT INTO `roomLevelTasksProgress` 
             (`id`, `room`, `task`, `todayExp`, `user`) VALUES 
             (NULL, '$room', '$task', $task_reward_exp, '$user');" );
      
             
            
            }
             updateSql( " UPDATE `rooms` SET  `total_exp`=  `total_exp`+$task_reward_exp WHERE  `rooms`.`id`='$room'" );
          levelUpIfPossible22($current_room_level,$task_reward_exp,$room,$previusTotalExp);
    }
  }
 
}

function levelUpIfPossible22($current_room_level,$task_reward_exp,$room,$previusTotalExp) {
    // in case there are on higher levels
    
    
    
      $roomNextLevel=$current_room_level+1;
        $appMaxRoomLevel=readRowFromSql( "SELECT  `roomLevel_requiredExp`.`roomLevel`  FROM `roomLevel_requiredExp` ORDER  BY
        `roomLevel_requiredExp`.`roomLevel` DESC  LIMIT 1 ", true )["roomLevel"];
       
    
    
     if ($roomNextLevel<=$appMaxRoomLevel){
          
           $nextLevelRequiredExp = readRowFromSql("SELECT `roomLevel_requiredExp`.`requiredExp` FROM `roomLevel_requiredExp` WHERE  `roomLevel_requiredExp`.`roomLevel` = $current_room_level+1",true )['requiredExp'];
    if($nextLevelRequiredExp!=null){
       
 
    if ($previusTotalExp + $task_reward_exp >= $nextLevelRequiredExp) {
        $update_level = updateSql( "UPDATE `rooms` SET  `room_level`= room_level+1 WHERE `rooms`.`id`='$room'" );
    }
    }
          
        }
    
    
   
    
}
 
?>