<?php
include "config.php";



$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit = isset($_GET['limit']) ? max(1, (int)$_GET['limit']) : 10;
$offset = ($page - 1) * $limit;

$paginationCode="LIMIT $limit OFFSET $offset";


$user_uid = $_GET['user_uid'];
$main_section_id = $_GET['main_section_id'];

$result= array();
  
   

if($main_section_id==0||$main_section_id=="0"){
    //where انا متابع
        $topics = readRowFromSql("SELECT topics_for_posts.* , count(DISTINCT topics_followers.follower_uid) AS followers,
             sum(DISTINCT gifts.value) AS gifts,
        count(DISTINCT posts.id) AS posts 
        
        
        FROM topics_main_sections 
        LEFT OUTER JOIN topics_for_posts ON topics_for_posts.id=topics_main_sections.topic_id
        LEFT OUTER JOIN topics_followers ON topics_followers.topic_id =topics_main_sections.topic_id
        LEFT OUTER JOIN posts ON posts.topic =topics_for_posts.id 
                 LEFT OUTER JOIN posts_gifts ON topics_followers.topic_id =topics_for_posts.id 
           LEFT OUTER JOIN gifts ON gifts.id =posts_gifts.gift_id 
                   WHERE topics_followers.follower_uid='$user_uid'
        GROUP BY topics_for_posts.id
$paginationCode

", false);


foreach($topics as $topic){
    $topic['followed']=1;
    $result[]=$topic;
}
   
}else{
    
    if($main_section_id==2||$main_section_id=="2"||$main_section_id==1||$main_section_id=="1"){
        $codeOrderBy="";
   if($main_section_id==1||$main_section_id=="1"){
       $codeOrderBy='ORDER BY followers DESC';
   }else{
        $codeOrderBy='ORDER BY topics_for_posts.datetime DESC';
   }
       $topics = readRowFromSql("SELECT  topics_for_posts.* , count(DISTINCT topics_followers.follower_uid)  AS followers,
       sum(DISTINCT gifts.value) AS gifts,
 count(DISTINCT posts.id)  AS posts
FROM topics_main_sections

LEFT OUTER JOIN topics_for_posts ON topics_for_posts.id=topics_main_sections.topic_id 
LEFT OUTER JOIN topics_followers ON topics_followers.topic_id =topics_main_sections.topic_id
LEFT OUTER JOIN posts ON posts.topic =topics_for_posts.id
   LEFT OUTER JOIN posts_gifts ON topics_followers.topic_id =topics_for_posts.id 
           LEFT OUTER JOIN gifts ON gifts.id =posts_gifts.gift_id 
WHERE
'$user_uid' NOT IN (SELECT  topics_followers.follower_uid
FROM  `topics_followers` WHERE topics_followers.topic_id=topics_for_posts.id)
     GROUP BY topics_for_posts.id $codeOrderBy  
     $paginationCode
", false);

   foreach($topics as $topic){
    $topic['followed']=0;
    $result[]=$topic;
}

}else{
    
    $topics = readRowFromSql("SELECT  topics_for_posts.* , count(DISTINCT topics_followers.follower_uid)  AS followers,
       sum(DISTINCT gifts.value) AS gifts,
 count(DISTINCT posts.id)  AS posts
FROM topics_main_sections

LEFT OUTER JOIN topics_for_posts ON topics_for_posts.id=topics_main_sections.topic_id 
LEFT OUTER JOIN topics_followers ON topics_followers.topic_id =topics_main_sections.topic_id
LEFT OUTER JOIN posts ON posts.topic =topics_for_posts.id
LEFT OUTER JOIN posts_gifts ON topics_followers.topic_id =topics_for_posts.id 
           LEFT OUTER JOIN gifts ON gifts.id =posts_gifts.gift_id 
WHERE topics_main_sections.main_section_id ='$main_section_id'  
AND
'$user_uid' NOT IN (SELECT  topics_followers.follower_uid
FROM  `topics_followers` 
WHERE topics_followers.topic_id=topics_for_posts.id)
     GROUP BY topics_for_posts.id
    $paginationCode
", false);

     foreach($topics as $topic){
    $topic['followed']=0;
    $result[]=$topic;
} 
}
}






echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        


?>