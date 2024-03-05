<?php
 

function sendNotification(
    $to_user,
    $from_user,
    $type,
    $post_id,
    $comment_id
) {
   if($comment_id==""||$comment_id==null){
       $comment_id=null;
        $update = updateSql(
     "INSERT INTO `moments_notifications` 
     (`id`, `to_user`, `from_user`, `type`, `post_id`,
     `comment_id`, `datetime`, `cleared`) VALUES 
     (NULL, '$to_user', '$from_user', '$type', $post_id,
     NULL, CURRENT_TIMESTAMP, '0');"
        );

   }else{
        $update = updateSql(
     "INSERT INTO `moments_notifications` 
     (`id`, `to_user`, `from_user`, `type`, `post_id`,
     `comment_id`, `datetime`, `cleared`) VALUES 
     (NULL, '$to_user', '$from_user', '$type', $post_id,
     $comment_id, CURRENT_TIMESTAMP, '0');"
        );
}
   }
  

?>
