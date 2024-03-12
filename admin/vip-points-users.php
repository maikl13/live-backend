<?php
session_start();
$page_title = "Voice Chat | Hashtags";
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
            <h1 class="m-0">VIP Users Points Logs</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">VIP Users Points Logs</li>
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
                    unset($_SESSION['status_added']);
                        
                    include('message-sucssess.php');
                    ?>
                        </div>
                        </div>
                        </div>
    <div class="card">
              <div class="card-header">
                <h3 class="card-title">VIP Users Points Logs
                </h3>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>UID</th>
                    <th>Name & ID</th>
                    <th>Points</th>
                    <th>VIP Started at</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $query = "SELECT a.user, b.id, a.started_accumulating_at, a.points, b.profile_pic,  b.full_name, b.short_digital_id, b.uid, a.id FROM users_vip_points_tracker AS a INNER JOIN users AS b ON a.user = b.uid WHERE a.id";
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
                    <td><?php echo $row['full_name']; ?>(ID:<?php echo $row['short_digital_id']; ?>)</td>
                    <td><?php echo $row['points']; ?></td>
                    <td><?php echo $row['started_accumulating_at']; ?></td>
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