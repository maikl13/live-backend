<?php
include "config.php";
include "hats_manager.php";
include "themes_manager.php";


$uid = $_GET['uid'];
$result  = array();


$products_to_buy_with_crystal = readRowFromSql("SELECT products_to_buy_with_crystal.* ,
CASE
WHEN themes.title IS NOT NULL THEN EXISTS (SELECT `users_bought_themes`.`user_uid` FROM `users_bought_themes` 
WHERE `users_bought_themes`.`user_uid`='$uid' AND `users_bought_themes`.`theme`=`themes`.`id`)
   
END  AS is_bought


,
CASE
WHEN products_to_buy_with_crystal.product_type ='THEME' THEN themes.title 
WHEN products_to_buy_with_crystal.product_type ='HAT' THEN hats.title 
WHEN products_to_buy_with_crystal.product_type ='CRAZYWORDS' THEN crazy_words.title 
END AS product_title,
CASE
WHEN products_to_buy_with_crystal.product_type ='THEME' THEN themes.image 
WHEN products_to_buy_with_crystal.product_type ='HAT' THEN hats.image 
WHEN products_to_buy_with_crystal.product_type ='CRAZYWORDS' THEN crazy_words.image 
END AS product_image
FROM `products_to_buy_with_crystal`  
LEFT OUTER JOIN themes ON themes.id = products_to_buy_with_crystal.product_id
LEFT OUTER JOIN hats ON hats.id = products_to_buy_with_crystal.product_id
LEFT OUTER JOIN crazy_words ON crazy_words.id = products_to_buy_with_crystal.product_id
GROUP BY products_to_buy_with_crystal.id", false);

/*
foreach($products_to_buy_with_crystal as $product){
    if ($product['is_bought']==0){
        $result[]=$product;
    }
}
*/
foreach($products_to_buy_with_crystal as $product){
    if ($product['is_bought']==null){
        unset($product['is_bought']);
    }
       $result[]=$product;
}

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>