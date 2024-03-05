<?php
  include "get_special_ids_manager.php";
   
$minDigits = 6;  
$maxDigits = 6; 
$is_room=$_GET['is_room'];
$id_max_value=$_GET['id_max_value'];
$id_min_value=$_GET['id_min_value'];

 $page =
    isset($_GET["page"]) && is_numeric($_GET["page"])
        ? intval($_GET["page"])
        : 1;
 $perPage =
    isset($_GET["perPage"]) && is_numeric($_GET["perPage"])
        ? intval($_GET["perPage"])
        : 10;
$searchWord = isset($_GET["searchWord"]) ? $_GET["searchWord"] : "";   

 $getBoughtIDs =readRowFromSql("SELECT `users_unique_ids`.`unique_id` FROM `users_unique_ids`
WHERE`users_unique_ids`.`for_room`='$is_room' ", false);
 $boughtIDs=[];
     foreach($getBoughtIDs as $boughtID){
         $boughtIDs[]=$boughtID['unique_id'];

     }
  $getSearchWordPattern= getPatternFromNumber($searchWord);
  
   $allPattern = ["aabb", "abab", "ababab", "abcabc", "abccba", "aabbcc", "aaabbb", "aaa", "aaaa", "aaaaa", "aaaaaa", "aaaaaaa", "abcd", "abcde", "abcdef", "abaca", "abcab", "bacab", "cabab"];
   
 
     $searchedPatterns=[];
  foreach($allPattern as $allPatternItem){
    
      if(strpos($allPatternItem, $getSearchWordPattern) !== false){
               $searchedPatterns[]= $allPatternItem;
      }

  }
 

  $output=[];

  function getPatternFromNumber($number) {
  $mapping = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];

    // Extract unique digits from the number while preserving their order
    $uniqueDigits = array_keys(array_flip(str_split((string)$number)));

    $pattern = '';
    foreach ($uniqueDigits as $index => $digit) {
        $pattern .= $mapping[$index % count($mapping)]; // Cycle through the mapping
    }

    $patternMap = array_combine($uniqueDigits, str_split($pattern));
    $result = '';

    foreach (str_split((string)$number) as $digit) {
        $result .= $patternMap[$digit];
    }

    return $result;
} 
 $price=0;
 foreach($searchedPatterns as $pattern){
     
       $price =readRowFromSql("SELECT `price`
FROM `special_ids_sub_sections`  WHERE `pattern`='$pattern' ", true)['price'];
 
   if($pattern=='aaa'||$pattern=='aaaa'||$pattern=='aaaaa'||$pattern=='aaaaaa'||$pattern=='aaaaaaa'){
         $times = strlen($pattern);;
         if($times==7){
              $minDigits = 7;  
         }
        
           $output = array_merge($output, findARepeatsNumbers($minDigits, $times, $searchWord, 1 , 1  ));
     }
      
     if($pattern=='abcd'||$pattern=='abcde'||$pattern=='abcdef'){
        
         $times = strlen($pattern);;
         if($times==7){
              $minDigits = 7;  
         }
      
        
             $output = array_merge($output, findAContinusNumbers($minDigits, $times, $searchWord, 1 , 1  )['data']);
  
     }
    
     switch($pattern){
    
 case 'aaabbb':
 
 $newOutput = findAAABBBNumbers(1,$searchWord)['data'];
 $output = array_merge($output,$newOutput);
 
 break;
 case 'aabb':
    
 $newOutput = findAABBNumbers(1, 1,$searchWord)['data'];
 
  $output = array_merge($output,$newOutput);

 break;
 case 'aabbcc':
 $newOutput = findAABBCCNumbers($minDigits, $maxDigits, 1, 1,$searchWord)['data'];
  $output = array_merge($output,$newOutput);
 break;
 case 'abab':
 $newOutput = findABABNumbers(1, 1,$searchWord)['data'];
  $output = array_merge($output,$newOutput);
 break;
 case 'ababab':
 $newOutput = findABABABNumbers(1, 1,$searchWord)['data'];
  $output = array_merge($output,$newOutput);
 break;
 case 'abcabc':
 $newOutput =findABCABCNumbers(1, 1,$searchWord)['data'];
  $output = array_merge($output,$newOutput);
 break;
 case 'abccba':
 $newOutput = findABCCBANumbers($minDigits, $maxDigits, 1, 1,$searchWord)['data'];
  $output = array_merge($output,$newOutput);
 break;
 
}
 $newOutput = findFiveNumbers(24, 1,$searchWord)['data'];
  $output = array_merge($output,$newOutput);
 }
 $finalOutput=[];

 if($id_max_value==0&&$id_min_value==0){
     $finalOutput=$output;
     
 }else{
      foreach($output as $outputItem){
     $idValue=$outputItem['number'];
     /*
        echo '$idValue:';
          echo $idValue;
             echo '$id_max_value:';
          echo $id_max_value;
             echo '$id_min_value:';
          echo $id_min_value;
          */
     if($idValue<$id_max_value&&$idValue>$id_min_value){
      
         $finalOutput[]=$outputItem;
     }
 }
 }
 $offset = ($page - 1) * $perPage;
   $output_array_slice = array_slice($finalOutput, $offset, $perPage);
 

  echo json_encode($output_array_slice, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
  
?>
