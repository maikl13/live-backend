<?php

 
function onTaskDone($uid, $repeats, $task)
{

   
    
    


    $level_speed = 1;
     $increase_to_level_speed = readRowFromSql(
        "
      SELECT `premium_subscription`.`increase_to_level_speed` 
      FROM `users`
INNER JOIN `premium_subscription` ON
`users`.`current_premium_subscription` = `premium_subscription`.`id`
WHERE `users`.`uid`='$uid'
",
        true
    )["increase_to_level_speed"];
    if ($increase_to_level_speed != null) {
        $level_speed = $increase_to_level_speed;
    }
    
    $task_max_exp_per_day =
        readRowFromSql(
            "
      SELECT `level_tasks`.`max_exp_per_day` FROM `level_tasks` WHERE `level_tasks`.`id`='$task'",
            true
        )["max_exp_per_day"] * $level_speed;
         $expValue = 10 * $level_speed ;
  
    $finalExpValue = 0;
    $task_current_exp_for_today = readRowFromSql(
        " SELECT `level_tasks_progress`.`exp`
       FROM `level_tasks_progress` WHERE `level_tasks_progress`.`user`='$uid'
       AND `level_tasks_progress`.`task`='$task'",
        true
    )["exp"];
    if($task_current_exp_for_today==null){
        $task_current_exp_for_today=0;
    }

 
    for ($x = 0; $x <= $repeats; $x++) {

   if ($task_current_exp_for_today < $task_max_exp_per_day) {
            $remein = $task_max_exp_per_day - $task_current_exp_for_today;
            if ($expValue > $remein) {
                $finalExpValue = $remein;
            } else {
                $finalExpValue = $expValue;
            }
            
            
            
            
                
    $user_total_exp =
        readRowFromSql( " SELECT `users_main_level`.`total_exp` FROM `users_main_level` WHERE `users_main_level`.`user`='$uid'", true  )["total_exp"];
            
            if($user_total_exp==null){
      $update_users_main_levele = updateSql("INSERT INTO `users_main_level` (`id`, `user`, `total_exp`, `date`) VALUES (NULL, '$uid', $finalExpValue,CURDATE());"  ); 
            }else{
        $update_users_main_levele = updateSql("UPDATE `users_main_level` SET `total_exp` = total_exp+$finalExpValue WHERE `users_main_level`.`user`='$uid'"  ); 
            }
       
       
        $user_level_tasks_progress =
        readRowFromSql( " SELECT `level_tasks_progress`.`exp` FROM `level_tasks_progress` WHERE `level_tasks_progress`.`user`='$uid' AND `level_tasks_progress`.`task`='$task'", true  )["exp"];
            
        
           if($user_level_tasks_progress==null){
      $update_level_tasks_progress = updateSql("INSERT INTO `level_tasks_progress` 
      (`id`, `user`, `task`, `exp`) 
      VALUES
      (NULL, '$uid', '$task', '$finalExpValue');"  ); 
            }else{
      $update_level_tasks_progress = updateSql("UPDATE `level_tasks_progress` SET `exp`= exp+$finalExpValue 
          WHERE `level_tasks_progress`.`user`='$uid' AND `level_tasks_progress`.`task`='$task'");
        
            }
               levelUpIfPossible(
                $uid
            );
       
        }
 
}
   
   
}

function levelUpIfPossible(
    $uid
) {
 
   // echo 'levelUpIfPossible   ';
  
  $current_level = readRowFromSql(
        "
    SELECT users.level FROM users
WHERE users.uid = '$uid'
",
        true
    )['level'];

    
    $next_level_data = readRowFromSql(
        "
    SELECT main_levels.level_required_exp   FROM main_levels
WHERE main_levels.level =  $current_level+1
",
        true
    );
    $next_level_required_exp = $next_level_data["level_required_exp"];
 
   $currentExpTotal = readRowFromSql(" SELECT total_exp  FROM users_main_level WHERE users_main_level.user = '$uid';",   true )['total_exp'];
  if($currentExpTotal==null){
      $currentExpTotal=0;
  }
  
  // echo "next_level_required_exp: ";
 //   echo $next_level_required_exp;
  //   echo "currentExpTotal: ";
 ////  echo $currentExpTotal;
    
    if ( $currentExpTotal>= $next_level_required_exp) {
 
        $userNextLevel=readRowFromSql("SELECT `users`.`level` FROM `users` WHERE  `users`.`uid`='$uid'", true )["level"]+1;
               
        $appMaxLevel=readRowFromSql( "SELECT  `main_levels`.`level` FROM `main_levels` ORDER  BY    `main_levels`.`level` DESC  LIMIT 1 ", true )['level'];
 
        if ($userNextLevel<=$appMaxLevel){
              $update_level_tasks_progress = updateSql(
            "UPDATE `users` SET `users`.`level` =level+1 WHERE `users`.`uid`='$uid'");
        }
      
        
    
    }
 
}

?>
