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
            <h1 class="m-0">Rooms Ban List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Rooms Ban List</li>
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
                <h3 class="card-title">Rooms Ban List
                </h3>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>User ( uid )</th>
                    <th>Ban By ( Admin Uid )</th>
                    <th>Permanently</th>
                    <th>Datetime</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                if(isset($_GET['room_id']))
                {
                    $room_id = $_GET['room_id'];
                    $query = "SELECT  `rooms_forbidden_users`.*,
 
                    forbidden_user.full_name as user_full_name,
                    forbidden_user.profile_pic as user_profile_pic,
                    forbidden_user.level as user_level,
                    forbidden_user.short_digital_id as short_digital_id,
                    forbidden_user.current_premium_subscription,
                    forbidden_user.current_vip_subscription,
                    user_rooms.is_joined AS is_joined,
                    admin.full_name as admin_name
                    FROM `rooms_forbidden_users`
                    INNER JOIN `users` admin ON  admin.`uid`=`rooms_forbidden_users`.`admin`
                    INNER JOIN `users` forbidden_user ON  forbidden_user.`uid`=`rooms_forbidden_users`.`user`
                    INNER JOIN `user_rooms` on  forbidden_user.`uid`=`user_rooms`.`user_uid` AND `user_rooms`.room_id = `rooms_forbidden_users`.`room`
                    WHERE `rooms_forbidden_users`.`room`='$room_id'
                    GROUP BY rooms_forbidden_users.user";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                            ?>
                  <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['user']; ?>(<?php echo $row['user_full_name']; ?>)</td>
                    <td><?php echo $row['admin']; ?>(<?php echo $row['admin_name']; ?>)</td>
                    <td><?php echo $row['permanently']; ?></td>
                    <td><?php echo $row['datetime']; ?></td>
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