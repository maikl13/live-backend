<?php
session_start();
include('config/dbcon.php');

if(isset($_POST['input'])){

    $input = $_POST['input'];
    $query = "SELECT * FROM users WHERE short_digital_id LIKE '{$input}%'";
    $query_run = mysqli_query($con, $query);

    if(mysqli_num_rows($query_run) > 0)
    {        
        ?>

    <table class="table table-bordered table-striped mt-4">
    <thead>
        <tr>
        <th>#</th>
        <th>Profile Image</th>
        <th>Account ID</th>
        <th>Account Name</th>
        <th>Account BIO</th>
        <th>Send Golds</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php
                    while($row = mysqli_fetch_assoc($query_run)){
                        $id = $row['id'];
                        $profile_pic = $row['profile_pic'];
                        $short_digital_id = $row['short_digital_id'];
                        $full_name = $row['full_name'];
                        $bio = $row['bio'];

                        ?>
                  <tr>
                  <td><?php echo $id; ?></td>
                  <td><img src="../images/<?php echo $profile_pic; ?> " width="70" height="70" /></td>
                  <td><?php echo $short_digital_id; ?></td>
                  <td><?php echo $full_name; ?></td>
                  <td><?php echo $bio; ?></td>
                  <td>
                    <a href="send-golds.php?user_id=<?php echo $id; ?>" class="btn btn-primary"><i class="editicon"></i>  Send Golds</a>
                    </td>
                  </tr>
                  <?php
                   }
                   ?>
                  </tbody>
                </table> 
<?php

    }else{
        echo "<h6 class='text-danger text-center mt-3'>NO DATA FOUND</h6>";
    }
}

?>