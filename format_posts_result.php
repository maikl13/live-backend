<?php
include "config.php";

$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit = isset($_GET['limit']) ? max(1, (int)$_GET['limit']) : 10;
$offset = ($page - 1) * $limit;

$paginationCode="LIMIT $limit OFFSET $offset";

$mustWhere=" WHERE   ( (`friend_requests`.`id` IS NOT null AND `posts`.`privacy` ='1') OR `posts`.`privacy` ='0')
AND
(
 
posts.publisher_uid NOT IN 
 (SELECT blocked_users.blocked FROM blocked_users WHERE  blocked_users.blocker='$user_uid')
)
AND
(
 
posts.publisher_uid NOT IN 
 (SELECT blocked_users.blocker FROM blocked_users WHERE  blocked_users.blocked='$user_uid')
)
";
 
 
$mustJoins=" 

INNER JOIN `users` ON `posts`.`publisher_uid` =`users`.`uid`
LEFT OUTER JOIN `comments` ON `comments`.`post_id` =`posts`.`id`
LEFT OUTER JOIN `posts_likes` all_likes_count ON `all_likes_count`.`post_id` =`posts`.`id`
LEFT OUTER JOIN `friend_requests`  ON (friend_requests.status ='Accepted') AND
 ((`posts`.`publisher_uid` !='$user_uid' AND `posts`.`publisher_uid`  =friend_requests.sender_uid   )OR
 (`posts`.`publisher_uid` !='$user_uid' AND `posts`.`publisher_uid`  =friend_requests.receiver_uid   ) )
 LEFT OUTER JOIN `rooms` ON `rooms`.`id` =`posts`.`shared_room`
 LEFT OUTER JOIN `countries` ON `countries`.`id` = `rooms`.`country`
 LEFT OUTER JOIN`hashtags` ON `hashtags`.`id` = `rooms`.`hashtag`
";

 $selectCodeNoPuplisher="  
 `rooms`.`id` as room_id,
`rooms`.`image` as room_image,
`rooms`.`title` as room_title,
`rooms`.`short_digital_id` as room_short_digital_id,
`rooms`.`description` as room_description,
`hashtags`.`id` as hashtag_id, `hashtags`.`title` as hashtag_title,
`countries`.`id` as country_id, `countries`.`name` as country_name, `countries`.`flag` as country_flag,
`rooms`.`country`,
rooms.members_count,
  `posts`.*,
EXISTS (SELECT * FROM `posts_likes` i_like_it WHERE `i_like_it`.`post_id`=posts.id AND `i_like_it`.`user_uid`='$user_uid') AS liked,
count(DISTINCT `all_likes_count`.`id`) AS likes_count,
count(DISTINCT `comments`.`id`) AS comments_count,
EXISTS (SELECT * FROM `followers` WHERE `followers`.`follower_uid`='$user_uid' AND `followers`.`followed_uid`=`posts`.`publisher_uid`) AS publisher_followed";
$selectCode="  
`users`.`full_name`,`users`.`uid`,`users`.`profile_pic`,`users`.`gender` ,
$selectCodeNoPuplisher";

function formatResult($posts){
 
     $results= array();
   foreach ($posts as $post) {
       
       $sharedPost=null;
       if($post['shared_post']!=null){
           $pid=$post['shared_post'];
           
         $sharedPost=   getPost( $pid);
       }
        $result['shared_post']=$sharedPost;
        //
         $sharedRoom=null;
       if($post['shared_room']!=null){
           $rid=$post['shared_room'];
           
         $sharedRoom['id']= $post['room_id'];
               $sharedRoom['short_digital_id']= $post['room_short_digital_id'];
           $sharedRoom['title']= $post['room_title'];
             $sharedRoom['description']= $post['room_description'];
            $sharedRoom['image']= $post['room_image'];
      $sharedRoom['members_count']= $post['members_count'];
        
        
       
                  
                  
$country['id']=$post['country'];
$country['name']=$post['country_name'];
$country['flag']=$post['country_flag'];
$sharedRoom['country']=$country;
$hashtag['id']=$post['hashtag_id'];
$hashtag['title']=$post['hashtag_title'];
$sharedRoom['hashtag']=$hashtag;
   
           
       }
        $result['shared_room']=$sharedRoom;
       
       $post_id=$post['id'];
        $imagesArray = readRowFromSql("SELECT  posts_images.image FROM posts_images WHERE posts_images.post = $post_id", false);
       foreach ($imagesArray as $item) {
    $images[]=$item['image'];
}
       
        $mentionsArray = readRowFromSql("SELECT users.full_name,users.uid FROM posts_mentions 
INNER JOIN users ON posts_mentions.mention_to = users.uid
WHERE posts_mentions.post =$post_id", false);
$mentions=[];
foreach ($mentionsArray as $item) {
    $fullName=$item['full_name'];
     $uid=$item['uid'];
    $finalString['fullname']="@$fullName";
      $finalString['uid']=$uid;
    $mentions[]=$finalString;
}       
      $result['mentions']=$mentions;
                $mentions=[];    
       $result['id']=$post['id'];
        $result['datetime']=$post['datetime'];
         $result['topic']=$post['topic'];
          $result['text']=$post['text'];
           $result['premium_notify']=$post['premium_notify'];
                $result['images']=$images;
                $images=[];
                $result['comments_count']=$post['comments_count'];
                 $result['likes_count']=$post['likes_count'];
                
                
                  $result['liked']=$post['liked'];
                  try{
                       $result['topic_title']=$post['topic_title'];
                  } catch (Exception $e) {
                      
                  }
                 
                   try{
                       $result['publisher_followed']=$post['publisher_followed'];
                  } catch (Exception $e) {
                      
                  }
                
                
          $writer['uid']=$post['uid'];
             $writer['profile_pic']=$post['profile_pic'];
       $writer['gender']=$post['gender'];
        $writer['full_name']=$post['full_name'];
        $writer['current_premium_subscription']=$post['current_premium_subscription'];
 
         $writer['current_vip_subscription']=$post['current_vip_subscription'];
 
        

       $result['writer']=$writer;
         $result['privacy']=$post['privacy'];
          $result['location']=$post['location'];
           $giftsValues = readRowFromSql("SELECT SUM(gifts.value ) as gift_value,users.profile_pic  FROM posts_gifts 
INNER JOIN gifts ON posts_gifts.gift_id=gifts.id
INNER JOIN users ON posts_gifts.sender_uid=users.uid
WHERE posts_gifts.post_id = $post_id 
GROUP BY users.uid
", false);

if(Count($giftsValues)==0){
    $result['gift_value']=0;
     $result['gifters_photos']=[];
}else{
    $gift_value=0;
    $gifters_photos=[];
    foreach($giftsValues as $item){
        $gift_value+=$item['gift_value'];
        $gifters_photos[]=$item['profile_pic'];
    }
    $result['gift_value']=$gift_value;
     $result['gifters_photos']=$gifters_photos;
}
            
     $results[]=$result;
    
   }
 
    return $results;
}
 

function getPost($post_id){
   $selectCode="  
 
`users`.`full_name`,`users`.`uid`,`users`.`profile_pic`,`users`.`gender` ,
  `posts`.*,
EXISTS (SELECT * FROM `posts_likes` i_like_it WHERE `i_like_it`.`post_id`=posts.id AND `i_like_it`.`user_uid`='$user_uid') AS liked,
count(DISTINCT `all_likes_count`.`id`) AS likes_count,
count(DISTINCT `comments`.`id`) AS comments_count,
EXISTS (SELECT * FROM `followers` WHERE `followers`.`follower_uid`='$user_uid' AND `followers`.`followed_uid`=`posts`.`publisher_uid`) AS publisher_followed";
$mustWhere=" WHERE   ( (`friend_requests`.`id` IS NOT null AND `posts`.`privacy` ='1') OR `posts`.`privacy` ='0')
";
 
 
$mustJoins=" 

INNER JOIN `users` ON `posts`.`publisher_uid` =`users`.`uid`
LEFT OUTER JOIN `comments` ON `comments`.`post_id` =`posts`.`id`
LEFT OUTER JOIN `posts_likes` all_likes_count ON `all_likes_count`.`post_id` =`posts`.`id`
LEFT OUTER JOIN `friend_requests`  ON (friend_requests.status ='Accepted') AND
 ((`posts`.`publisher_uid` !='$user_uid' AND `posts`.`publisher_uid`  =friend_requests.sender_uid   )OR
 (`posts`.`publisher_uid` !='$user_uid' AND `posts`.`publisher_uid`  =friend_requests.receiver_uid   ) )
 
";

    $req="SELECT 
$selectCode
 FROM `posts` 
$mustJoins   
LEFT OUTER JOIN `topics_for_posts` ON `topics_for_posts`.`id` =`posts`.`topic`
   $mustWhere
 AND
`posts`.`id` ='$post_id'
GROUP BY posts.id ORDER BY posts.datetime
";
 
      $posts = readRowFromSql($req, false);
    
  $results=formatResult($posts)[0];
 
  return $results;
}
////88888888888888888888888888888888888888

function get_all_followed_people_posts($user_uid){
    global $paginationCode;
global $selectCode;
global $mustJoins;
global $mustWhere;
    $customJoins="
LEFT OUTER JOIN `topics_for_posts` ON `topics_for_posts`.`id` =`posts`.`topic`
INNER JOIN `followers` ON `followers`.`follower_uid`='$user_uid' AND `posts`.`publisher_uid` = `followers`.`followed_uid`

";

$customSelectCode="
  ,`topics_for_posts`.`title` as topic_title, `users`.`current_premium_subscription`, `users`.`current_vip_subscription`
";
  $posts = readRowFromSql("
  SELECT 
$selectCode
$customSelectCode
 FROM `posts` 
$mustJoins
$customJoins
$mustWhere
GROUP BY posts.id ORDER BY posts.datetime
$paginationCode
"

, false);
return formatResult($posts);
    
}
 
////88888888888888888888888888888888888888
function get_featured_posts($user_uid){
global $paginationCode;
global $selectCode;
global $mustJoins;
global $mustWhere;
$customJoins="
LEFT OUTER JOIN `topics_for_posts` ON `topics_for_posts`.`id` =`posts`.`topic`
";

$customSelectCode="
  ,`topics_for_posts`.`title` as topic_title, `users`.`current_premium_subscription`, `users`.`current_vip_subscription`
";
$toRead="  SELECT 
$selectCode
$customSelectCode
 FROM `posts` 
$mustJoins
$customJoins
$mustWhere

GROUP BY posts.id  ORDER BY   likes_count DESC
$paginationCode
";
 
 
  $posts = readRowFromSql($toRead, false);

return formatResult($posts);
    
}
////88888888888888888888888888888888888888
function get_posts_by_person($user_uid,$followed_uid){
global $paginationCode;
global $selectCode;
global $mustJoins;
global $mustWhere;
global $selectCodeNoPuplisher;

$code="SELECT 
  $selectCodeNoPuplisher
  ,  `topics_for_posts`.`title` as topic_title
 FROM `posts` 
$mustJoins 
LEFT OUTER JOIN `topics_for_posts` ON `topics_for_posts`.`id` =`posts`.`topic`
 WHERE   ( (`friend_requests`.`id` IS NOT null AND `posts`.`privacy` ='1') OR (`posts`.`privacy` ='0') OR 
 (`posts`.`privacy` ='2' AND `posts`.`publisher_uid`='$user_uid') )
AND (`posts`.`publisher_uid` ='$followed_uid')
GROUP BY posts.id ORDER BY posts.datetime DESC
$paginationCode
";
 
 
  $posts = readRowFromSql($code, false);

   
 $followed = readRowFromSql("SELECT 
`users`.`full_name`,`users`.`uid`,`users`.`profile_pic`,`users`.`gender`  ,
`users`.`current_premium_subscription` ,`users`.`current_vip_subscription` 

FROM `users` 
WHERE `users`.`uid`='$followed_uid'

", true);


$postsToBeFormated=array();
 foreach ($posts as $post) {
 $postToBeFormated=$post;
     $postToBeFormated['uid']= $followed['uid'];
     $postToBeFormated['profile_pic']= $followed['profile_pic'];
     $postToBeFormated['gender']= $followed['gender'];
     $postToBeFormated['full_name']= $followed['full_name'];
           $postToBeFormated['current_premium_subscription']= $followed['current_premium_subscription'];
             $postToBeFormated['current_vip_subscription']= $followed['current_vip_subscription'];
     $postsToBeFormated[]=$postToBeFormated;
 }

 
 
return formatResult($postsToBeFormated);
    
}
////88888888888888888888888888888888888888
function get_posts_by_topic($user_uid,$topic_id,$sorting){
global $paginationCode;
global $selectCode;
global $mustJoins;
global $mustWhere;


switch($sorting){
    case 'popular':
        $sortCode='ORDER BY  pinned DESC, likes_count DESC , posts.datetime DESC';
        break;
    case 'latest':
        $sortCode='ORDER BY  pinned DESC, posts.datetime DESC';
        break;
        
}

$selectCode="
 SELECT  
$selectCode
,EXISTS (SELECT `topics_for_posts`.`id` FROM `topics_for_posts` WHERE `topics_for_posts`.`pinned_post`=`posts`.`id` AND `topics_for_posts`.`id`='$topic_id' ) AS pinned
FROM `posts`  
  $mustJoins
 $mustWhere
 AND `posts`.`topic`='$topic_id'
GROUP BY posts.id $sortCode
$paginationCode";
 
 $posts = readRowFromSql($selectCode, false);



 
 
 
return formatResult($posts);
    
}
////88888888888888888888888888888888888888
function get_room_moments($user_uid,$room_id){
    

global $paginationCode;
global $selectCode;
global $mustJoins;
global $mustWhere;

$customJoins="
LEFT OUTER JOIN `topics_for_posts` ON `topics_for_posts`.`id` =`posts`.`topic`
INNER JOIN `user_rooms` ON  `user_rooms`.`user_uid`=`users`.`uid` AND user_rooms.room_id =rooms.id

INNER JOIN `user_rooms` publisher_room ON  publisher_room.`user_uid`=posts.publisher_uid AND publisher_room.room_id ='$room_id' AND publisher_room.is_joined=1
";

$customSelectCode="
  `topics_for_posts`.`title` as topic_title, `users`.`current_premium_subscription`, `users`.`current_vip_subscription`
";
$r="
  SELECT 
$selectCode ,
$customSelectCode
 FROM `posts` 
$mustJoins
$customJoins
$mustWhere
AND ( `user_rooms`.`is_joined`  =1  )
AND (
EXISTS (SELECT user_rooms.id FROM  `user_rooms` publisher_room WHERE  publisher_room.`user_uid`=posts.publisher_uid AND publisher_room.room_id ='$room_id' AND publisher_room.is_joined=1) 
    OR
EXISTS (SELECT rooms.id FROM  `rooms` publisher_is_admin_rooms WHERE  publisher_is_admin_rooms.creator_uid=posts.publisher_uid AND publisher_is_admin_rooms.id ='$room_id' )    
    OR
EXISTS (SELECT rooms_admins.id FROM  `rooms_admins`  WHERE  rooms_admins.user=posts.publisher_uid AND rooms_admins.room ='$room_id' ) 
)
GROUP BY posts.id ORDER BY posts.datetime
$paginationCode
";
//  echo $r;
 
  $posts = readRowFromSql("$r", false);
 
// echo $posts;
return formatResult($posts);
    
}
?>