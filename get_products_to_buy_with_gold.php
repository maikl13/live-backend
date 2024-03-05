<?php
include "config.php";
///// our real code //////
$products_to_buy_with_gold = readRowFromSql("SELECT * FROM `products_to_buy_with_gold` ", false);
$result  = array();
foreach ($products_to_buy_with_gold as $product_to_buy_with_gold) {
    $result[]= $product_to_buy_with_gold;
}
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>