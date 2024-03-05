<?php

include "get_special_ids_manager.php";
$pattern =$_GET['pattern'];
 
$is_room=$_GET['is_room'];
 
 $perPage = isset($_GET['perPage']) && is_numeric($_GET['perPage']) ? intval($_GET['perPage']) : 10;
 
$minDigits = 6;  
$maxDigits = 6;  
 $page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
 
  $price =readRowFromSql("SELECT `price`
FROM `special_ids_sub_sections`  WHERE `pattern`='$pattern' ", true)['price'];
 $getBoughtIDs =readRowFromSql("SELECT `users_unique_ids`.`unique_id` FROM `users_unique_ids`
WHERE`users_unique_ids`.`for_room`='$is_room' ", false);
 $boughtIDs=[];
     foreach($getBoughtIDs as $boughtID){
         $boughtIDs[]=$boughtID['unique_id'];

     }
     if($pattern=='aaa'||$pattern=='aaaa'||$pattern=='aaaaa'||$pattern=='aaaaaa'||$pattern=='aaaaaaa'){
         $times = strlen($pattern);;
         if($times==7){
              $minDigits = 7;  
         }
          $output = findARepeatsNumbers($minDigits, $times, '', $perPage , $page  );
     }
     
     if($pattern=='abcd'||$pattern=='abcde'||$pattern=='abcdef'){
         $times = strlen($pattern);;
         if($times==7){
              $minDigits = 7;  
         }
      
          $output = findAContinusNumbers($minDigits, $times, '', $perPage , $page  );
           
          
         
     }
switch($pattern){
 case 'aaabbb':
 $output = findAAABBBNumbers($page,'');
 break;
 case 'aabb':
 $output = findAABBNumbers($perPage, $page,'');
 break;
 case 'aabbcc':
 $output = findAABBCCNumbers($minDigits, $maxDigits, $perPage, $page,'');
 break;
 case 'abab':
 $output = findABABNumbers($perPage, $page,'');
 break;
 case 'ababab':
 $output = findABABABNumbers($perPage, $page,'');
 break;
 case 'abcabc':
 $output =findABCABCNumbers($perPage, $page,'');
 break;
 case 'abccba':
 $output = findABCCBANumbers($minDigits, $maxDigits, $perPage, $page,'');
 break;
 case 'popular':
 $output = findPopularNumbers($page);
 break;
 case 'five-digit':
 $output = findFiveNumbers(24, $page);
 break;
}
 
 
  echo json_encode($output['data'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
 
?>