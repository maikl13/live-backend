
<?php
include "config.php";

$parent_reason = $_GET['parent_reason'];
$reason_section = $_GET['reason_section'];
$reason = $_GET['reason'];
$reported_part_type = $_GET['reported_part_type'];
$reported_part_id = $_GET['reported_part_id'];
$reporter = $_GET['reporter'];


$result = updateSql("INSERT INTO `reports` 
(`id`, `parent_reason`, `reason_section`, `reason`, 
`reported_part_type`, `reported_part_id`, `reporter`, `datetime`) 

VALUES
(NULL, '$parent_reason', '$reason_section', $reason,
'$reported_part_type', '$reported_part_id', '$reporter', CURRENT_TIMESTAMP);", true);


 

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>



