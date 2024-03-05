<?php
include "config.php";
include "themes_manager.php";

$category_id = $_GET['category_id'];
  $uid =$_GET['uid'];

$themes=getThemesByCategory($category_id,$uid);


echo json_encode($themes, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>