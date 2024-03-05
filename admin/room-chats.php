<?php
session_start();
include('includes/header.php');
include('authentication.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('config/dbcon.php');
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">



<!-- Delete Admin -->
<div class="modal fade" id="DeletModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Delete Ban</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="code.php" method="POST">
            <div class="modal-body">
                <input type="hidden" name="delete_id" class="delete_user_id">
                <p>
                    Are your sure. you want delete this Data?
                </p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="DeleteAdminbtn" class="btn btn-danger">Yes, Delete !</button>
      </div>
    </form>

    </div>
  </div>
</div>
<!-- Delete Admin -->




    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Room Chats History</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Room Chats History</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                        </div>
                        </div>
                        </div>
    <div class="card">
              <div class="card-header">
                <h3 class="card-title">Room Chats History
                </h3>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Level</th>
                    <th>Premium LVL</th>
                    <th>VIP LVL</th>
                    <th>Role</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                if(isset($_GET['room_id']))
                {
                  $room_id = $_GET['room_id'];
                  $query = "SELECT
                  `message`.`message_id`,
                  `message`.`body`,
                  `message`.`sent_datetime`,
                  `message`.`type`,
                  `message`.`sender_uid`,
                  `message`.`is_reply`,
                  `message`.`has_mention`,
                  `message`.`mention_to`,
                  
                  
                  `reply`.`message_id`as message_we_are_replying_to_id, 
                  `reply`.`body`as message_we_are_replying_to_body,
                  `reply`.`type`as message_we_are_replying_to_type,
                  `reply`.`sender_uid`as message_we_are_replying_to_sender_uid,
                  `reply`.`has_mention`as message_we_are_replying_to_has_mention,
                  `reply`.`mention_to`as message_we_are_replying_to_mention_to,
                  
                  
                  
                  `sender`.`full_name`,
                  `sender`.`level`,
                  `sender`  .`profile_pic`,
                  EXISTS (SELECT users_premium_subscriptions.subscription_id  FROM `users_premium_subscriptions` WHERE `users_premium_subscriptions`.`user_uid`=`message`.`sender_uid`) AS is_premium,
                  users_premium_subscriptions.subscription_id AS premium_subscription_id,
                  
                  `user_we_are_replying_to`.`full_name` as  message_we_are_replying_to_full_name,
                  `user_we_are_replying_to`.`level`as  message_we_are_replying_to_level,
                  `user_we_are_replying_to` .`profile_pic`as  message_we_are_replying_to_profile_pic
                  
                  
                  FROM `messages` message  
                  
                  
                  LEFT OUTER JOIN users_premium_subscriptions ON `users_premium_subscriptions`.`user_uid`=`message`.`sender_uid`
                  
                  
                  INNER JOIN `users` sender ON   message.sender_uid =  sender.uid
                  LEFT OUTER JOIN `messages` reply ON   reply.message_id =  message.message_we_are_replying_to AND  message.is_reply = 1
                  
                  LEFT OUTER JOIN `users` user_we_are_replying_to ON   reply.sender_uid =  user_we_are_replying_to.uid
                  
                  
                  WHERE message.room_id ='$room_id' ORDER BY `message`.`message_id`";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                            ?>
                            
                  <tr>
                    <td><?php echo $row['message_id']; ?></td>
                    <td><img src="../images/<?php echo $row['profile_pic']; ?>" width="70" height="70" /></td>
                    <td><?php echo $row['uid']; ?>(<?php echo $row['full_name']; ?>)</td>
                    <td><?php echo $row['gender']; ?></td>
                    <td><?php echo $row['level']; ?></td>
                    <td><?php echo $row['current_premium_subscription']; ?></td>
                    <td><?php echo $row['current_vip_subscription']; ?></td>
                    <td><?php if($row['is_admin']=="1")  echo "Admin"; else  echo "Member"; ?></td>
                    <td>
                    <button type="button" value="<?php echo $row['id']; ?>" class="btn btn-danger deletebtn">Delete</a>
                    </td>
                  </tr>

                          <?php
                        }
                    }
                    else
                    {
                        ?>
                        <tr>
                            <td>No Record Found</td>
                        </tr>
                        <?php
                    }
                }

                  ?>
                  </tbody>
                </table> 
            </div>
         </div>

    </div>

    </div>
        </div>
        </div>

        </section>


     </div>

<?php include('includes/script.php'); ?>

<script>
    $(document).ready(function () {
        $('.deletebtn').click(function (e) {
            e.preventDefault();

            var user_id = $(this).val();
            //console.log(user_id);
            $('.delete_user_id').val(user_id);
            $('#DeletModal').modal('show');
             
        });
    });
</script>



<?php include('includes/footer.php'); ?>