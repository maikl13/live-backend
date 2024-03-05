<?php
include "config.php";
///// our real code //////



 $UPDATE_Result=updateSql("SET GLOBAL event_scheduler='ON'");


/*
$datetime = new DateTime( "now", new DateTimeZone( "Africa/Cairo" ) );
$now= $datetime->format( 'Y-m-d H:i:s' );
      $modified = (clone new DateTime($now, new DateTimeZone( "Africa/Cairo" )))->add(new DateInterval("PT{1}M"));
     $newEndDate= $modified->format('Y-m-d H:i:s');
  
 */    
/*
    $UPDATE_Result=updateSql("CREATE EVENT IF NOT EXISTS `session_cleaner_event`
  ON SCHEDULE AT '2021-09-01 15:30:00'
  DO 
  UPDATE `users` SET `first_name` = 'naikl' WHERE `users`.`id` = '1' ");
*/

/*
    $UPDATE_Result=updateSql("CREATE EVENT IF NOT EXISTS `dssdddddddddddd`
  ON SCHEDULE AT '2022-11-07 09:02:00'
  DO 
  UPDATE `users` SET `first_name` = 'Alana' WHERE `users`.`id` = '1' ");
*/

    $UPDATE_Result=updateSql("
    
    CREATE EVENT testdd_efffffffffffffvessnt_03
ON SCHEDULE EVERY 1 MINUTE
STARTS CURRENT_TIMESTAMP
ENDS CURRENT_TIMESTAMP + INTERVAL 1 HOUR
  DO 
  UPDATE `users` SET `first_name` = 'Alana' WHERE `users`.`id` = '1' ");


  
echo json_encode($UPDATE_Result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
   

 
?>