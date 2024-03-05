<?php
session_start();
include('config/dbcon.php');
include('includes/header.php');


if(isset($_POST['input'])){

    $input = $_POST['input'];
    $query = "SELECT * FROM agency WHERE id LIKE '{$input}%'";
    $query_run = mysqli_query($con, $query);

    if(mysqli_num_rows($query_run) > 0)
    {        
        ?>
                          <?php
                    while($row = mysqli_fetch_assoc($query_run)){
                        $image = $row['image'];
                        $id = $row['id'];

                        ?>

              <div class="chat-user-thumbnail me-3 shadow"><img class="img-circle" src="../images/<?php echo $image; ?>" width="70" height="70" alt=""><span class="active-status"></span></div>
              <div class="chat-user-info">
                <h6 class="text-truncate mb-0"><?php echo $id; ?></h6>
                </div>
              </div>
            </a>
            <!-- Options -->
            <div class="">
              <button class="btn btn-primary" type="submit">JOIN</button>



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