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
            <h1 class="m-0">Banned Users List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Banned Users List</li>
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
                <?php
                if(isset($_SESSION['status']))
                {
                    echo"<h4>".$_SESSION['status']."</h4>";
                    unset($_SESSION['status']);
                }
                ?>
                        </div>
                        </div>
                        </div>
    <div class="card">
              <div class="card-header">
                <h3 class="card-title">Banned Users List
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>UID</th>
                    <th>Display ID</th>
                    <th>Full Name</th>
                    <th>Level</th>
                    <th>Gender</th>
                    <th>Gold</th>
                    <th>Crystals</th>
                    <th>Login By</th>
                    <th>VIP LVL</th>
                    <th>Join Date</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  //  $query = "SELECT * FROM users";
                    $query = "SELECT * FROM users WHERE account_status='banned';";
                  $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                          ?>
                  <tr>
                  <td><?php echo $row['id']; ?></td>
                    <td><img src="../images/<?php echo $row['profile_pic']; ?>" width="70" height="70" /></td>
                    <td><?php echo $row['uid']; ?></td>
                    <td><?php echo $row['short_digital_id']; ?></td>
                    <td><?php echo $row['full_name']; ?></td>
                    <td><?php echo $row['level']; ?></td>
                    <td><?php echo $row['gender']; ?></td>
                    <td><?php echo $row['gold']; ?></td>
                    <td><?php echo $row['crystals']; ?></td>
                    <td><?php echo $row['login_method']; ?></td>
                    <td><?php echo $row['current_vip_subscription']; ?></td>
                    <td><?php echo $row['join_date']; ?></td>
                    <td>
                    <a href="user-profile.php?user_id=<?php echo $row['id']; ?>" class="btn btn-info">Profile</a>
                    <a href="" class="btn btn-danger">Delete</a>
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
<?php include('includes/footer.php'); ?>