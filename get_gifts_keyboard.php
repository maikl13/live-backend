<?php
include "config.php";

  
$gifts = readRowFromSql("SELECT gifts.* , sections_of_gifts.title AS section_name , sections_of_gifts.id AS section_id FROM gifts  RIGHT JOIN `sections_of_gifts` ON `sections_of_gifts`.`id`=`gifts`.`section` ORDER BY  section_id
", false);

$sections=array();
foreach ($gifts as $gift) {
    $section_id=$gift['section_id'];
    $section_name=$gift['section_name'];

if(!in_array( "$section_id" ,$sections ) )
{
     $sections[]=$section_id;    
}
    
}


$sectionsWithGifts=array();
foreach ($sections as $current_section_id) {
    $sectionWithGifts;
    
      $Gifts=array();
    foreach ($gifts as $gift1) {
          
        if($gift1['section_id']==$current_section_id){
              $sectionWithGifts["section_name"]=$gift1["section_name"];
        $sectionWithGifts["section_id"]=$gift1["section_id"];
        
        
        
        //////////
               $MyGift;
           $MyGift['id']=$gift1["id"];
        $MyGift['title']=$gift1["title"];
           $MyGift['value']=$gift1["value"];
             $MyGift['image']=$gift1['image'];
               $MyGift['currency_type']=$gift1['currency_type'];
              $MyGift['level']=$gift1['level'];
                $MyGift['icon']=$gift1['icon'];
            
             
             
             if($MyGift['id']!=null){
                 $Gifts[]=$MyGift;   
             }
     
        //////////
        
        
        
       // $Gifts[]=$gift1["title"];
    
        }
    }
     $sectionWithGifts["gifts"]=$Gifts;
 $sectionsWithGifts[]=$sectionWithGifts;

    
}

echo json_encode($sectionsWithGifts, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
 
?>