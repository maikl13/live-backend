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
            <h1 class="m-0">Room Members List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Room Members List</li>
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
                <h3 class="card-title">Room Members List
                </h3>
            </div>
              <!-- /.card-header -->
              <form action="codebanuser.php" method="POST" enctype="multipart/form-data">
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
                    users.id,
                    users.uid,
                    users.full_name,
                    users.profile_pic,
                    users.level,
                    users.gender,
                    users.current_premium_subscription,
                    users.current_vip_subscription,
                     `user_rooms`.`is_joined`  ,
                     CASE WHEN CURDATE() =  DATE_FORMAT(user_rooms.enter_datetime, '%Y-%m-%d')
                     THEN 1 ELSE 0 END as active_today,
                    EXISTS (SELECT rooms_admins.id  FROM `rooms_admins` WHERE `rooms_admins`.`user`=`users`.`uid` AND `rooms_admins`.`room`='$room_id') AS is_admin
                    FROM `users`   
                    INNER JOIN `user_rooms` ON  `user_rooms`.`user_uid`=`users`.`uid` 
                     
                     
                    WHERE  `user_rooms`.`is_joined`  =1  AND `user_rooms`.`room_id`='$room_id'
                    GROUP BY users.id ORDER BY user_rooms.enter_datetime";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                            ?>
                  <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><img src="../images/<?php echo $row['profile_pic']; ?>" width="70" height="70" /></td>
                    <td><?php echo $row['uid']; ?>(<?php echo $row['full_name']; ?>)</td>
                    <td><?php echo $row['gender']; ?></td>
                    <td><?php echo $row['level']; ?></td>
                    <td><?php echo $row['current_premium_subscription']; ?></td>
                    <td><?php echo $row['current_vip_subscription']; ?></td>
                    <td><?php if($row['is_admin']=="1")  echo "Admin"; else  echo "Member"; ?></td>
                    <td>
                    <button type="button" value="<?php echo $row['id']; ?>" class="btn btn-danger deletebtn">Delete</a>
                    <button type="submit" name="banuser" class="btn btn-primary">Ban</button>
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
              </form>
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