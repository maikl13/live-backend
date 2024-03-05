<?php
 
 
function getEvents($uid,$section,$sort,$room){
    
     
$requiredJoins="
LEFT JOIN events_interested_users eiu ON e.id = eiu.event
LEFT JOIN rooms r ON e.room = r.id LEFT JOIN `user_rooms` m 
ON r.id = m.room_id AND m.is_joined
INNER JOIN `countries` ON `countries`.`id` = r.`country`
INNER JOIN `hashtags` ON `hashtags`.`id` = r.`hashtag`
";

    $uniqueJoins="";
    $whereCommand="";
    $sortCode="";
    if($section=='createdByUser'){
      $whereCommand="WHERE e.creator_uid='$uid'";  
    }
      if($section=='userInterestedIn'){
      $uniqueJoins="INNER JOIN events_interested_users i_am_interested1 ON e.id = i_am_interested1.event AND i_am_interested1.`user_uid`='$uid'";
    }
    if($section=='all'){
          $whereCommand="WHERE e.start_at <= NOW() ";  
        if($sort=='popularSort'){
                    $sortCode="ORDER BY COUNT(m.id) DESC";
                   
        }
     if($sort=='newSort'){
                    $sortCode="ORDER BY e.creating_datetime DESC";
        }
    }
     if($section=='eventsOfJoinedRooms'){
      $uniqueJoins="INNER JOIN user_rooms i_am_joined ON e.room = i_am_joined.room_id AND i_am_joined.`user_uid`='$uid'";
    }
 
    if($section=='eventsOfRoom'){
         $whereCommand="WHERE r.id='$room'";  
         if($sort=='pastSort'){
      $whereCommand="$whereCommand AND  e.end_at < NOW() ";  
               $sortCode="ORDER BY e.start_at DESC";
         }
          if($sort=='todaySort'){
     
      $whereCommand="$whereCommand AND  DATE(e.start_at) = NOW()";  
         }
           if($sort=='nextWeekSort'){
     
      $whereCommand="$whereCommand AND  DATE(e.start_at) BETWEEN NOW() + INTERVAL 1 DAY AND NOW() + INTERVAL 7 DAY";  
         }
          if($sort=='liveSort'){
      $whereCommand="$whereCommand AND e.start_at <= NOW() AND e.end_at >= NOW()";  
         }
        if($sort=='liveOrInLessThan30minSort'){
     
        $whereCommand="$whereCommand AND e.start_at <= NOW() + INTERVAL 30 MINUTE AND e.end_at >= NOW() ";  
         }
         
 
    }

 
$sql = "SELECT
    e.id AS event_id,
    e.title AS event_title,
    e.description AS event_description,
      e.image AS event_image,
      
     e.start_at,
      e.end_at ,
    CASE WHEN e.start_at <= NOW() AND e.end_at >= NOW() THEN 1 ELSE 0 END AS is_live,
    COUNT(eiu.id) AS interested_users_count,
    r.id AS room_id,
    r.image as room_image,
    r.title AS room_title,
    r.description AS room_description,
     
`hashtags`.`id` as hashtag_id, `hashtags`.`title` as hashtag_title,
`countries`.`id` as country_id, `countries`.`name` as country_name, `countries`.`flag` as country_flag,
 
    
    COUNT(m.id) AS room_members_count,
 
 
 EXISTS (SELECT * FROM `events_interested_users` i_am_interested WHERE `i_am_interested`.event =e.id AND `i_am_interested`.`user_uid`='$uid') AS interested
 
FROM events e
$requiredJoins
$uniqueJoins
$whereCommand
GROUP BY e.id, r.id
$sortCode
";
 
 
$list = readRowFromSql($sql,false);
 $list=formatResault($list);
  
   if($sort=='pastSort'){
       $list=formatListchronologically($list);
   }
return $list;
}

 function formatResault($list){
 $resultsList=array();
 foreach($list as $item){
     $results['event_id'] = $item['event_id'];
     $results['event_title'] = $item['event_title'];
     $results['event_description'] = $item['event_description'];
   $results['event_image'] = $item['event_image'];
     $results['interested']= $item['interested'];
     $results['start_at'] = $item['start_at'];
       $results['end_at'] = $item['end_at'];
         $results['is_live'] = $item['is_live'];
          $results['interested_users_count'] = $item['interested_users_count'];
          $room_data['id']= $item['room_id'];
           $room_data['title']= $item['room_title'];
            $room_data['description']= $item['room_description'];
             $room_data['image']= $item['room_image'];
              $room_data['members_count']= $item['room_members_count'];
              $room_data['short_digital_id']= $item['short_digital_id'];
              
              
              
          $country['id']=$item['country_id'];
$country['name']=$item['country_name'];
$country['flag']=$item['country_flag'];
$room_data['country']=$country;
 $hashtag['id']=$item['hashtag_id'];
$hashtag['title']=$item['hashtag_title'];
$room_data['hashtag']=$hashtag;
           $results['room_data'] = $room_data;
           $resultsList[]=$results;
 } 
 return $resultsList;
    
}

 
function checkJoinedRoomsOnlineEvents($uid){
 
 
$sql = "SELECT
 EXISTS (SELECT * FROM `events` e WHERE `e`.room =r.id AND e.start_at <= NOW() AND e.end_at >=NOW() ) AS has_live_event,
    r.id AS room_id,
    r.image AS room_image,
    r.title AS room_title,
        COUNT(m.id) AS room_members_count,
    r.short_digital_id AS room_short_digital_id
 
FROM rooms r
INNER JOIN user_rooms i_am_joined ON r.id = i_am_joined.room_id AND i_am_joined.`user_uid`='$uid'
LEFT JOIN `user_rooms` m 
ON r.id = m.room_id AND m.is_joined
WHERE EXISTS (SELECT * FROM `events` e WHERE `e`.room =r.id ) 
GROUP BY room_id
";

 
$list = readRowFromSql($sql,false);
return $list;
}
 
 function formatListchronologically($list){
     $dates=array();
     
 foreach($list as $item){
       $itemDate = date("Y-m-d",strtotime($item['start_at']));
        foreach($dates as $date){
            $exist=false;
            if($date==$itemDate){
                $exist=true;
            }
        }
        if(!$exist){
                  $dates[]=$itemDate;
        }

 }
 
 $results=array();
 foreach($dates as $date){
        $events=array();
      foreach($list as $item){
       $eventDate = date("Y-m-d",strtotime($item['start_at']));
       if($eventDate==$date){
           $events[]=$item;
       }
 }
  $resultItem['events']=$events;
       $resultItem['date']=$date;
       $results[]=$resultItem;
 }
 return $results;
    
}
 

 


?>