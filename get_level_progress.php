<?php
include "config.php";


  $uid =$_GET['uid'];
 
 
  
 
  $total_exp = readRowFromSql(" SELECT total_exp  FROM users_main_level WHERE users_main_level.user = '$uid';",   true )['total_exp'];
  if($total_exp==null){
      $total_exp=0;
  }
 $user_level_data=readRowFromSql("
    SELECT 
        COALESCE(main_levels.level_required_exp, 0) AS level_required_exp,
    COALESCE(users.level, 0) AS level
    FROM users
INNER JOIN main_levels ON users.level = main_levels.level
WHERE users.uid = '$uid'
", true);


 
$exp_of_current_level=$user_level_data['level_required_exp'];

$current_level=$user_level_data['level'];

 $next_level_data=readRowFromSql("
    SELECT main_levels.level_required_exp   FROM main_levels
WHERE main_levels.level =  $current_level+1
", true);
$next_level_required_exp=$next_level_data['level_required_exp'];

    $tasks_max_exp_per_day_sum=(readRowFromSql("
      SELECT SUM(`level_tasks`.`max_exp_per_day`)  as max_exp_per_day FROM `level_tasks` ", true))['max_exp_per_day'];
      

     $level_speed=1; 
 $increase_to_level_speed=(readRowFromSql("
      SELECT `premium_subscription`.`increase_to_level_speed` 
      FROM  `premium_subscription`
INNER JOIN `users` ON
`premium_subscription`.`id` = `users`.`current_premium_subscription` 
WHERE `users`.`uid`='$uid'
", true))['increase_to_level_speed'];

 

if($increase_to_level_speed!=null){
    $level_speed=$increase_to_level_speed;
}

$tasks_max_exp_per_day_sum=$tasks_max_exp_per_day_sum*$level_speed;
 
      $progress=readRowFromSql(" SELECT  (`level_tasks_progress`.`exp`)as progress,
      (`level_tasks`.`max_exp_per_day`*$level_speed )as max_exp_per_day,
      `level_tasks`.`title`,  `level_tasks`.`sub_title`,  `level_tasks`.`id`,  `level_tasks`.`more_info`
      FROM `level_tasks`
LEFT OUTER JOIN `level_tasks_progress` ON `level_tasks_progress`.`task`=`level_tasks`.`id` AND
`level_tasks_progress`.`user`='$uid'
", false);

$modifiedProgress=array();
foreach($progress as $it){
  
    if($it['progress']==null){
    $it['progress']=0;
}
    $modifiedProgress[]=$it;
}

 ///////////
 $reachedLasLevel=0;
 if($next_level_data==null){
         $reachedLasLevel=1;
 } 
 ////////////////
 $remaining_required_exp=$next_level_required_exp-$total_exp;
$resault['tasks_max_exp_per_day_sum']=$tasks_max_exp_per_day_sum;
$resault['level_speed']=$level_speed;
$resault['total_exp']=$total_exp;
$resault['current_level']=$current_level;
$resault['remaining_exp_to_level_up']=$remaining_required_exp;
$resault['exp_of_current_level']=$exp_of_current_level;
$resault['exp_of_next_level']=$next_level_required_exp;
$resault['reached_last_level']=$reachedLasLevel;  

$resault['progress']=$modifiedProgress;
 echo json_encode($resault, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>


