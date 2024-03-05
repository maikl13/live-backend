<?php
include "config.php";





$main_sections_of_topics = readRowFromSql("SELECT * FROM `main_sections_of_topics`
", false);



echo json_encode($main_sections_of_topics, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        


?>