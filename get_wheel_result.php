<?php
include "config.php";


$round=getRoundData(); 
getGameResult($round);

 
function getRoundData(){
 $current_round=readRowFromSql("SELECT  `wheel_rounds`.`id`   FROM `wheel_rounds`    
 WHERE ADDTIME(`wheel_rounds`.`starts_at`, '00:00:42') > NOW() ORDER BY id DESC LIMIT 1",true);
 return $current_round['id'];
//return $round;
}
 
 function getGameResult($round){
    $winnerItemId=getWinner($round);
    echo ' winnerItemId : '.$winnerItemId;
    $topThree = readRowFromSql("SELECT
    SUM(`wheel_rounds_bidders`.`value`* `wheel_rounds_bidders`.`multiplier`) AS won_value,
    `users`.`full_name`,
    `users`.`profile_pic`
FROM
    `wheel_rounds_bidders`
INNER JOIN `users` ON `users`.`uid` = `wheel_rounds_bidders`.`bidder`
WHERE
    `wheel_rounds_bidders`.`round` = '$round'
    AND `wheel_rounds_bidders`.`item` = '1'
GROUP BY
    `users`.`uid` 
ORDER BY
 SUM(`wheel_rounds_bidders`.`value`* `wheel_rounds_bidders`.`multiplier`) DESC
LIMIT 3;",false);   

echo '/n topThree : ';
echo json_encode($topThree, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    $allBidders = readRowFromSql("SELECT `wheel_rounds_bidders`.`bidder` ,
    `users`.`last_wheel_pusher_id`
          FROM `wheel_rounds_bidders` 
          INNER JOIN `users` ON  `users`.`uid`= `wheel_rounds_bidders`.`bidder` 
           WHERE `wheel_rounds_bidders`.`round`='$round' GROUP BY `users`.`uid`
       ",false);     
       $allBiddersPotAndWonValue=[];
    foreach($allBidders as $bidder){
        $bidderUID=$bidder['bidder'];
        $bidderPusherId=$bidder['last_wheel_pusher_id'];

        $potValue = readRowFromSql("SELECT 
        SUM(`wheel_rounds_bidders`.`value`) AS potValue
           FROM 
           `wheel_rounds_bidders` 
           WHERE 
             `wheel_rounds_bidders`.`round` = '$round' AND 
              `wheel_rounds_bidders`.`bidder`='$bidderUID'   
        ",true)['potValue'];    
          $wonValue = readRowFromSql("SELECT
           SUM(`wheel_rounds_bidders`.`value`*`wheel_rounds_bidders`.`multiplier`)
            AS wonValue FROM `wheel_rounds_bidders`
             WHERE `wheel_rounds_bidders`.`round` = '$round' 
             AND `wheel_rounds_bidders`.`bidder`='$bidderUID'
          AND `wheel_rounds_bidders`.`item`='1'
          ;",true)['wonValue'];     
          $thisBidder['potValue']=$potValue;
          $thisBidder['wonValue']=$wonValue;
          $thisBidder['uid']=$bidderUID;
 $allBiddersPotAndWonValue[]=$thisBidder;
    }
   // $result['potValue']=$potValue;
   // $result['wonValue']=$wonValue;
   $result['allBiddersPotAndWonValue']=$allBiddersPotAndWonValue;
    $result['winnerItem']=$winnerItemId;
    $result['biggest_winner_this_round']=$topThree ;
  //todo  pusher.sendToUser("$bidderPusherId", "game_ended",$result);
  echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
 
}

 
?>