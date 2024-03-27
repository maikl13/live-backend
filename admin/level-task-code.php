<?php
session_start();
include('config/dbcon.php');
include('authentication.php');

if(isset($_POST['updateleveltask']))
{
    $task_id = $_POST['task_id'];
    $title = $_POST['title'];
    $sub_title = $_POST['sub_title'];
    $more_info = $_POST['more_info'];
    $max_exp_per_day = $_POST['max_exp_per_day'];

    $query = "UPDATE level_tasks SET title='$title', sub_title='$sub_title', more_info='$more_info', max_exp_per_day='$max_exp_per_day' WHERE id='$task_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Daily Task Edit Successfully";
        $_SESSION['status_code'] = 'success';
        header("Location: level-task.php");
    }
    else
    {
        $_SESSION['status'] = "Daily Task Edit Failed";
        $_SESSION['status_code'] = 'error';
        header("Location: level-task.php");

    }

}
?>