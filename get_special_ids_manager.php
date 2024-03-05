<?php
include "config.php";


 
 
 
 
 function findARepeatsNumbers($digitsCount, $times, $searchNumber, $perPage = 10, $page = 1) {
    $searchMode=$searchNumber!='';
    global $boughtIDs;
    global $price;
    $result = [];
    if(($page==1&&$searchMode)||!$searchMode){
           $startIndex = ($page - 1) * $perPage;

    $startLoop = pow(10, $digitsCount - 1);
    $endLoop = pow(10, $digitsCount) - 1;

    for ($num = $startLoop; $num <= $endLoop; $num++) {
        if (!in_array($num, $boughtIDs)) {
            $numStr = strval($num);

            // Check if the number contains the pattern "aaa"
            $exist = false;
            $part_that_matches_the_pattern = '';

            for ($i = 0; $i <= 9; $i++) {
                $repeatedNumber = str_repeat($i, $times);
                $repeatedNumber = (string) $repeatedNumber;
                if (strpos($numStr, $repeatedNumber) !== false) {
                    $exist = true;
                    $part_that_matches_the_pattern = $repeatedNumber;
                }
            }

    if ($exist && (strpos($numStr, $searchNumber) !== false||!$searchMode)) {
                // Check if the number contains the searchNumber
                $result[] = [
                    'number' => $num,
                    'price' => $price,
                    'part_that_matches_the_pattern' => $part_that_matches_the_pattern
                ];
            }
        }
    }
    }
 
    if($searchMode){
      
          return [
        'data' => $result];
    }else{
       return [
        'data' => array_slice($result, $startIndex, $perPage)
    ];   
    }
  
}
//

 
      
 function findAAABBBNumbers($page,$searchNumber='') {
      global $boughtIDs;
  global $price;
         $searchMode=$searchNumber!='';
       $numbers = [];
    if($page==1){
        for ($a = 1; $a <= 9; $a++) {
        for ($b = 0; $b <= 9; $b++) {
            if ($a != $b) {
                $number = "{$a}{$a}{$a}{$b}{$b}{$b}";
                
                
                if (!in_array($number, $boughtIDs) && (strpos($number, $searchNumber) !== false||!$searchMode)) {
                        $numbers[] = [
                                    'number' => $number,  'price' => $price,
                                    'part_that_matches_the_pattern' => $number
                                ];
                     }
            
            }
        }
    }  
    }
 $result['data']=$numbers;
     return $result;
}
function findABCABCNumbers($perPage, $page,$searchNumber='') {
    

        $searchMode=$searchNumber!='';
             global $boughtIDs;
    global $price;
    $numbers = [];
    
    for ($a = 1; $a <= 9; $a++) {
        for ($b = 0; $b <= 9; $b++) {
            for ($c = 0; $c <= 9; $c++) {
                $number = $a * 100 + $b * 10 + $c;
                $s = (string)$number;
                if ($s[0] != $s[1] && $s[0] != $s[2] && $s[1] != $s[2]) {
                    $item = "$number$number";
                    if (!in_array($item, $boughtIDs)&&( strpos($number, $searchNumber) !== false||!$searchMode)) {
                        $numbers[] = [
                            'number' => $item,
                            'price' => $price,
                            'part_that_matches_the_pattern' => $item
                        ];
                    }
                }
            }
        }
    }
  if($searchMode){
       $paginatedNumbers=$numbers;
   }else{
       $offset = ($page - 1) * $perPage;
    $paginatedNumbers = array_slice($numbers, $offset, $perPage);
   }
 
  $result['data']=$paginatedNumbers;
    return $result;
 
}
function findAABBNumbers($perPage = 10, $page = 1,$searchNumber='') {
         global $boughtIDs;

        $searchMode=$searchNumber!='';
       $fourDigitNumbers = [];
    for ($a = 1; $a <= 9; $a++) {
        for ($b = 0; $b <= 9; $b++) {
            if ($a != $b) {
                $number = "{$a}{$a}{$b}{$b}";
           
                  if ( strpos($number, $searchNumber) !== false||!$searchMode) {
                         $fourDigitNumbers[] = $number;
                  }
                
               
            
            }
        }
    }
   
 $sixDigitNumbers=generateSixDigitNumbers($fourDigitNumbers);
     
   if($searchMode){
       $paginatedNumbers=$sixDigitNumbers;
       
   }else{
       $offset = ($page - 1) * $perPage;
    $paginatedNumbers = array_slice($sixDigitNumbers, $offset, $perPage);
   }
 
  $result['data']=$paginatedNumbers;

    return $result;
}
function generateSixDigitNumbers($fourDigitNumbers) {
      global $price;
      global $boughtIDs;
    $ids = [];

    foreach ($fourDigitNumbers as $fourDigitNumber) {
        ///get string data
          $fourDigitNumberString = (string)$fourDigitNumber;
                 $firstTwoChars = substr($fourDigitNumberString, 0, 2);
                  $stringNumber = strval($number);

// Calculate the length of the string
$length = strlen($stringNumber);

// Extract the last two characters
$lastTwoChars = substr($stringNumber, $length - 2, 2);
////////
        // Loop from 10aabb to 19aabb
        for ($x = 10; $x < 20; $x++) {
              
            if($x!=$firstTwoChars){
                 $sixDigitNumbers= $x . $fourDigitNumber;
             if(!in_array($sixDigitNumbers, $boughtIDs)){
                     
                     $ids[] = [
                            'number' => $sixDigitNumbers,
                            'price' => $price,
                            'part_that_matches_the_pattern' => $fourDigitNumber
                        ];
             }  
            }
         
        
        }

        // Loop from 1aabb0 to 1aabb9
        for ($i = 0; $i <= 9; $i++) {
            $sixDigitNumbers = '1' . $fourDigitNumber . $i;
            if(!in_array($sixDigitNumbers, $boughtIDs)){
                       $ids[] = [
                            'number' => $sixDigitNumbers,
                            'price' => $price,
                            'part_that_matches_the_pattern' => $fourDigitNumber
                        ];
             }
        }

        // Loop from aabb01 to aabb98
        for ($i = 1; $i <= 98; $i++) {
            $fourDigitNumberString = (string)$fourDigitNumber;
               
            if($x!=$lastTwoChars){
                 $sixDigitNumbers= $fourDigitNumber . sprintf("%02d", $i);
         if(!in_array($sixDigitNumbers, $boughtIDs)){
                        $ids[] = [
                            'number' => $sixDigitNumbers,
                            'price' => $price,
                            'part_that_matches_the_pattern' => $fourDigitNumber
                        ];
             }
            }
            
        
        }

        // Loop from 1xaabb to 17aabb
        for ($x = 1; $x <= 7; $x++) {
            // Check if the second character is not equal to the first character
            if ($fourDigitNumber[0] != $fourDigitNumber[1]) {
               $sixDigitNumbers= $x . $fourDigitNumber;
               if(!in_array($sixDigitNumbers, $boughtIDs)){
                        $ids[] = [
                            'number' => $sixDigitNumbers,
                            'price' => $price,
                            'part_that_matches_the_pattern' => $fourDigitNumber
                        ];
             }
            }
        }
    }
 
    return $ids;
}
 
function findAABBCCNumbers($minDigits, $maxDigits, $perPage = 10, $page = 1,$searchNumber='') {
      $searchMode=$searchNumber!='';
     global $boughtIDs;
    global $price;
    $result = [];
    $count = 0;
    $startIndex = ($page - 1) * $perPage;

    for ($digits = $minDigits; $digits <= $maxDigits; $digits++) {
        for ($a = 0; $a <= 9; $a++) { // A can be 0-9
            for ($b = 0; $b <= 9; $b++) { // B can be 0-9
                for ($c = 0; $c <= 9; $c++) { // C can be 0-9
                    if ($a != $b && $a != $c && $b != $c) {  // A, B, and C should be distinct
                        $number = intval("{$a}{$a}{$b}{$b}{$c}{$c}");  // Construct the number
                          if(!in_array($number, $boughtIDs)&& ( strpos($number, $searchNumber) !== false||!$searchMode)){
                                if ($number >= pow(10, $digits - 1) && $number <= pow(10, $digits) - 1) {
                            $result[] = [
                                'number' => $number,  'price' => $price,
                                'part_that_matches_the_pattern' => "{$a}{$a}{$b}{$b}{$c}{$c}"
                            ];

                            $count++;

                            if ($count >= $startIndex + $perPage) {
                                return [
                                    'total_pages' => ceil($count / $perPage),
                                    'current_page' => $page,
                                    'per_page' => $perPage,
                                    'data' => array_slice($result, $startIndex, $perPage)
                                ];
                            }
                        }
                          }

                      
                    }
                }
            }
        }
    }
    if($searchMode){
        $finalListResult=$result;
    }else{
       $finalListResult= array_slice($result, $startIndex, $perPage);
    }
    return [
        'total_pages' => ceil($count / $perPage),
        'current_page' => $page,
        'per_page' => $perPage,
        'data' => $finalListResult
    ];
}
function findABABNumbers(  $perPage = 10, $page = 1,$searchNumber='') {
      $searchMode=$searchNumber!='';
       $fourDigitNumbers = [];
    for ($i = 10; $i <= 98; $i++) {
        $s = (string)$i;
         if ($s[0] != $s[1]) {
          $pattern = $i . $i;
          if( strpos($pattern, $searchNumber) !== false||!$searchMode){
               $fourDigitNumbers[] = $pattern;
            }
          }
          
  
    }
  $sixDigitNumbers=generateSixDigitNumbers($fourDigitNumbers);
 



    
       if($searchMode){
        $paginatedNumbers=$sixDigitNumbers;
    }else{
     $offset = ($page - 1) * $perPage;
    $paginatedNumbers = array_slice($sixDigitNumbers, $offset, $perPage);

    }
  $result['data']=$paginatedNumbers;
    return $result;
    
}
function findABABABNumbers($perPage, $page,$searchNumber='') {
      $searchMode=$searchNumber!='';
     global $boughtIDs;
    global $price;
       $numbers = [];
    for ($i = 10; $i <= 98; $i++) {
        $s = (string)$i;
                if ($s[0] != $s[1]) {
                       $pattern = $i . $i . $i;
     if (!in_array($pattern, $boughtIDs)&&( strpos($pattern, $searchNumber) !== false||!$searchMode)) {
                        $numbers[] = [
                            'number' => $pattern,
                            'price' => $price,
                            'part_that_matches_the_pattern' => $pattern
                        ];
                    }
                }
  
    }
     if($searchMode){
        $paginatedNumbers=$numbers;
    }else{
     $offset = ($page - 1) * $perPage;
    $paginatedNumbers = array_slice($numbers, $offset, $perPage);

    }
  $result['data']=$paginatedNumbers;
    return $result;
 
}
 
function findABCCBANumbers($minDigits, $maxDigits, $perPage = 10, $page = 1,$searchNumber='') {
      $searchMode=$searchNumber!='';
     global $boughtIDs;
    global $price;
    $result = [];
   
    $startIndex = ($page - 1) * $perPage;

    for ($digits = $minDigits; $digits <= $maxDigits; $digits++) {
        for ($a = 1; $a <= 9; $a++) { // A can be 1-9 (non-zero)
            for ($b = 0; $b <= 9; $b++) { // B can be 0-9
                for ($c = 0; $c <= 9; $c++) { // C can be 0-9
                    if ($a != $b && $b != $c && $a != $c) {  // A should not be equal to B or C
                        $number = intval("{$a}{$b}{$c}{$c}{$b}{$a}");  // Construct the number
                            if(!in_array($number, $boughtIDs)&&( strpos($number, $searchNumber) !== false||!$searchMode)){
                                       if ($number >= pow(10, $digits - 1) && $number <= pow(10, $digits) - 1) {
                             $result[] = [
                                    'number' => $number,  'price' => $price,
                                    'part_that_matches_the_pattern' => "{$a}{$b}{$c}{$c}{$b}{$a}"
                                ];
                            }
                 
                        }
                    }
                }
            }
        }
    }
 if($searchMode){
        $data=$result;
    }else{
   $data=array_slice($result, $startIndex, $perPage);
    }
 
 
    return [
        
        'data' => $data
    ];
}
 function findAContinusNumbers(
    $digitsCount,
    $times,
    $searchNumber,
    $perPage = 10,
    $page = 1) {
    $searchMode = $searchNumber != "";
    global $boughtIDs;
    global $price;
    $result = [];
    $toBeMatchedWith=[];
      for ($i = 0; $i <= 9  ; $i++) {
                     if($i+$times<10){
                     
                        $continusNumber='';
                          for ($dig = 1; $dig <= $times  ; $dig++) {
                              $newCharacter=$i+$dig;
                              $continusNumber = $continusNumber . $newCharacter;
                          }
                         
                         $toBeMatchedWith[]= $continusNumber;
   
                         
                     }
                         
               
                }

    if (($page == 1 && $searchMode) || !$searchMode) {
        $startIndex = ($page - 1) * $perPage;

        $startLoop = pow(10, $digitsCount - 1);
        $endLoop = pow(10, $digitsCount) - 1;

        for ($num = $startLoop; $num <= $endLoop; $num++) {
            if (!in_array($num, $boughtIDs)) {
                $numStr = strval($num);
                $exist = false;
                $part_that_matches_the_pattern = "";
                //
                foreach($toBeMatchedWith as $continusNumber){
                    if (strpos($numStr, $continusNumber) !== false||$numStr== $continusNumber) {
                            $exist = true;
                            $part_that_matches_the_pattern = $continusNumber;
                        }
                }
                
                if (
                    $exist &&
                    (strpos($numStr, $searchNumber) !== false || !$searchMode)
                ) {
                    $result[] = [
                        "number" => $num,
                        "price" => $price,
                        "part_that_matches_the_pattern" => $part_that_matches_the_pattern,
                    ];
                }
            }
        }
    }

    if ($searchMode) {
        return [
            "data" => $result,
        ];
    } else {
        return [
            "data" => array_slice($result, $startIndex, $perPage),
        ];
    }
}


function findPopularNumbers($page){
    $resultNumbers=[];
         if($page==1){
                global $price;
 $price =readRowFromSql("SELECT `price`
  FROM `special_ids_sub_sections`  WHERE `pattern`='abcdef' ", true)['price'];
   $output1 = findAContinusNumbers(6, 6, '', 5 , 1  )['data'];
    $price =readRowFromSql("SELECT `price`
  FROM `special_ids_sub_sections`  WHERE `pattern`='aaaaaaa' ", true)['price'];
   $output2 = findARepeatsNumbers(7, 7, '', 5 , 1  )['data'];
   $resultNumbers= array_merge($output2,$output1);
    
         }
 $result['data']=$resultNumbers; 
    return $result;
}

 
 function generateNumbers($length, $chars, $currentNumber = '') {
    $result = [];

    // Base case: If the current number is of the desired length, add it to the result array.
    if (strlen($currentNumber) === $length) {
        $result[] = $currentNumber;
    } else {
        // Determine the index of the first character.
        $startCharIndex = (strlen($currentNumber) === 0) ? 1 : 0;

        // Loop through the characters starting from the determined index and append them to the current number.
        $prevChar = ($currentNumber === '') ? '' : $currentNumber[strlen($currentNumber) - 1];
        for ($i = $startCharIndex; $i < count($chars); $i++) {
            $char = $chars[$i];
            if ($char !== $prevChar) {
                // Recursively generate numbers and merge the results into the current result array.
                $result = array_merge($result, generateNumbers($length, $chars, $currentNumber . $char));
            }
        }
    }

    return $result;
}
 
function findFiveNumbers( $perPage , $page ,$searchNumber='') {
      $searchMode=$searchNumber!='';
          global $boughtIDs;
    global $price;
    $paginatedNumbers=[];
    if($page==1){
        $resultNumbers=[];
    $charsList=[];
     $char1=0;
     $char2=1;
     $char3=7;
     $char4=3;
    $chars = [strval($char1), strval($char2), strval($char3), strval($char4)];
   $charsList[]=$chars;
     for ($i = $char4; $i <= 9; $i++) {
   $newChars = [strval($char1), strval($char2), strval($char3), strval($i)]; 
            $charsList[]=$newChars;
     }
     for ($i = $char3; $i <= 9; $i++) {
  $newChars = [strval($char1), strval($char2), strval($i), strval($char4)]; 
           $charsList[]=$newChars;
     }
     for ($i = $char2; $i <= 9; $i++) {
  $newChars = [strval($char1), strval($i), strval($char3), strval($char4)]; 
           $charsList[]=$newChars;
     }
      for ($i = $char1; $i <= 9; $i++) {
  $newChars = [strval($i), strval($char2), strval($char3), strval($char4)]; 
         $charsList[]=$newChars;
     }
     
     $length = 5;
     $fiveDigitNumbers=[];
     foreach($charsList as $charsListItem){
  $fiveDigitNumbers = array_merge($fiveDigitNumbers, generateNumbers($length, $charsListItem));
     }

 

       foreach($fiveDigitNumbers as $fiveDigitNumber){
                    if(!in_array($fiveDigitNumber, $boughtIDs)&&!in_array($fiveDigitNumber, $resultNumbers)&& (strpos($numStr, $searchNumber) !== false || !$searchMode)){
                        $resultNumbers[] = [
                    'number' => $fiveDigitNumber,   
                    'price' => $price,
                    'part_that_matches_the_pattern' => $fiveDigitNumber
                ];
                    }
       }
 
        
    }
     if($searchMode){
        $data=$resultNumbers;
    }else{
 
   $data = array_slice($resultNumbers, $page, $perPage);
    }
  $result['data']=$data;
    return $result;
}

 

?>