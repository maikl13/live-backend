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

        <!-- Content Header (Page header) -->
        <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">EDIT Upgrade Type</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">EDIT Upgrade Type</li>
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
                <h3 class="card-title">EDIT Upgrade Type
                </h3>
                <a href="roomsupgradetype.php" class="btn btn-danger float-right">Back</a>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                    <form action="code/roomsupgradetype-code.php" method="POST">
            <div class="modal-body">
                <?php
                if(isset($_GET['user_id']))
                {
                    $user_id = $_GET['user_id'];
                    $query = "SELECT * FROM room_upgrade_types WHERE id='$user_id' LIMIT 1 ";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                            ?>
                    <input type="hidden" name="user_id" value="<?php echo $row['id'] ?>">
              <div class="form-group">
                <label for="">Cost</label>
                    <input type="text" name="cost" value="<?php echo $row['cost'] ?>" class="form-control" placeholder="cost">
              </div>
              <div class="form-group">
                <label for="">Room Capacity ( Max All Users )</label>
                    <input type="text" name="room_capacity" value="<?php echo $row['room_capacity'] ?>" class="form-control" placeholder="room_capacity">
              </div>
              <div class="form-group">
                <label for="">MAX Admin in Room</label>
                    <input type="text" name="room_admin" value="<?php echo $row['room_admin'] ?>" class="form-control" placeholder="room_admin">
              </div>
              <div class="form-group">
                <label for="">MAX Member in Room</label>
                    <input type="text" name="room_member" value="<?php echo $row['room_member'] ?>" class="form-control" placeholder="Gift Name">
              </div>



                            <?php
                        }
                    }
                    else
                    {
                        echo "<h4> No Record Found </h4>";
                    }
                }
                ?>
            </div>
            <div class="modal-footer">
              <button type="submit" name="updateroomtypeupgrade" class="btn btn-info">Update</button>
      </div>
    </form>

                    </div>
                </div>
              </div>
         </div>
    </div>
    </div>
        </div>
        </div>
        </section>

</div>

<?php include('includes/script.php'); ?>
<?php include('includes/footer.php'); ?>