<?php
include "config.php";

  
$premium_subscriptions = readRowFromSql("SELECT * FROM vip_subscriptions", false);


  $vip_benefits = readRowFromSql("SELECT * FROM vip_benefits", false);

$result=array();
 $x = 0;
 
        foreach ($premium_subscriptions as $premium_subscription) {
      $x++;
      
       $currentCount=0;
       $countLimit=$premium_subscription["benefits_count"];
       
       
       
         $VIPBenefits=[];
     foreach ($vip_benefits as $vip_benefit) {
       
         $currentCount++;
      $VIPBenefits["id"]=$vip_benefit["id"];
      $VIPBenefits["title"]=$vip_benefit["title"];
      if($currentCount<=$countLimit){
     $VIPBenefits["available"]=true;
   }else{
     $VIPBenefits["available"]=false;
   }
  
   
   
switch($x){
           case 1:
               $VIPBenefits["icon"]=$vip_benefit["subscription1_icon"]; 
        break;
           case 2:
                  $VIPBenefits["icon"]=$vip_benefit["subscription2_icon"]; 
        break;    
           case 3:
                  $VIPBenefits["icon"]=$vip_benefit["subscription3_icon"]; 
        break;  
           case 4:
                  $VIPBenefits["icon"]=$vip_benefit["subscription4_icon"]; 
        break;  
           case 5:
                  $VIPBenefits["icon"]=$vip_benefit["subscription5_icon"]; 
        break;  
}


$premium_subscription["VIPBenefits"][]=$VIPBenefits;


     }
     $result[]=$premium_subscription;
            
        }
            
        

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>