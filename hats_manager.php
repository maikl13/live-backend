<?php




function getHatsInGoldStore(){
$hats = readRowFromSql("SELECT *
FROM `hats`", false);
  return $hats;
}



?>



