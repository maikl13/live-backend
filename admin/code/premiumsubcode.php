<?php
session_start();
include('../config/dbcon.php');
include('../authentication.php');





if(isset($_POST['updatePremiumsub']))
{
    $sub_id = $_POST['sub_id'];
    $title = $_POST['title'];
    $price = $_POST['price'];
    $max_friends_num = $_POST['max_friends_num'];
    $max_followers_num = $_POST['max_followers_num'];
    $increase_to_level_speed = $_POST['increase_to_level_speed'];
    $max_magic_cards = $_POST['max_magic_cards'];
    $sending_gifts_discount = $_POST['sending_gifts_discount'];
    $store_discount = $_POST['store_discount'];
    $rebate = $_POST['rebate'];
    $color = $_POST['color'];

    $query = "UPDATE premium_subscription SET title='$title', price='$price', max_friends_num='$max_friends_num', max_followers_num='$max_followers_num',increase_to_level_speed='$increase_to_level_speed',max_magic_cards='$max_magic_cards',sending_gifts_discount='$sending_gifts_discount',store_discount='$store_discount',rebate='$rebate',renewal='$renewal',color='$color'  WHERE id='$sub_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Premium Package Edited";
        header("Location: ../premium-subscription.php");
    }
    else
    {
        $_SESSION['status'] = "Premium Package EDIT Failed";
        header("Location: ../premium-subscription.php");

    }

}


?>