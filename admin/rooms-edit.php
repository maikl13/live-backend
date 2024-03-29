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
            <h1 class="m-0">Edit Room</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Room</li>
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
                <h3 class="card-title">EDIT ADMIN
                </h3>
                <a href="rooms.php" class="btn btn-danger float-right">Back</a>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                    <form action="code/code_rooms.php" method="POST">
            <div class="modal-body">
                <?php
                if(isset($_GET['room_id']))
                {
                    $room_id = $_GET['room_id'];
                    $query = "SELECT * FROM rooms WHERE id='$room_id' LIMIT 1 ";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                            ?>
                    <input type="hidden" name="room_id" value="<?php echo $row['id'] ?>">
            <div class="form-group">
                <label for="">Room ID</label>
                    <input type="text" name="short_digital_id" value="<?php echo $row['short_digital_id'] ?>" class="form-control" placeholder="Room ID">
              </div>
              <div class="form-group">
                <label for="">Room Name</label>
                    <input type="text" name="title" value="<?php echo $row['title'] ?>" class="form-control" placeholder="Room Name">
              </div>
              <div class="form-group">
                <label for="">Description</label>
                    <input type="text" name="description" value="<?php echo $row['description'] ?>" class="form-control" placeholder="Description">
              </div>
              <div class="form-group">
                <label for="">Room Level</label>
                    <input type="text" name="room_level" value="<?php echo $row['room_level'] ?>" class="form-control" placeholder="Room Level">
              </div>
              <div class="form-group">
                <label for="">Membership Fee</label>
                    <input type="text" name="membership_fee" value="<?php echo $row['membership_fee'] ?>" class="form-control" placeholder="Membership Fee">
              </div>
              <div class="form-group">
                <label for="">Room Password</label>
                    <input type="text" name="enter_lock" value="<?php echo $row['enter_lock'] ?>" class="form-control" placeholder="Room Password">
              </div>
              <div class="form-group">
                <label for="">Allow Guest To Join Room</label>
                    <input type="checkbox"  name="allow_guests_to_enter" <?php echo $row['allow_guests_to_enter'] =="1" ? 'checked':''; ?> >
              </div>
              <div class="form-group">
                <label for="">Mic For Member Only</label>
                    <input type="checkbox"  name="mic_for_members_only" <?php echo $row['mic_for_members_only'] =="1" ? 'checked':''; ?> >
              </div>
              <div class="form-group">
                <label for="">Allow Admin Manage Mic</label>
                    <input type="checkbox"  name="allow_admins_to_lock_or_unlock_the_mic" <?php echo $row['allow_admins_to_lock_or_unlock_the_mic'] =="1" ? 'checked':''; ?> >
              </div>
              <div class="form-group">
                <label for="">Allow Admin Manage Events</label>
                    <input type="checkbox"  name="allow_admins_to_manage_events" <?php echo $row['allow_admins_to_manage_events'] =="1" ? 'checked':''; ?> >
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
              <button type="submit" name="updateRoom" class="btn btn-info">Update</button>
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