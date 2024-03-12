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
            <h1 class="m-0">VIP Subscriptions List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">VIP Subscriptions List</li>
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
                <h3 class="card-title">VIP Subscriptions List
                </h3>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>icon</th>
                    <th>Title Image</th>
                    <th>Card Image</th>
                    <th>Benefits image</th>
                    <th>Profile Room card</th>
                    <th>Title</th>
                    <th>Benefits Count</th>
                    <th>Main Color</th>
                    <th>Dark Color</th>
                    <th>Required Points</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $query = "SELECT * FROM vip_subscriptions";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                          ?>
                  <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><img src="../images/<?php echo $row['icon']; ?>" width="70" height="70" /></td>
                    <td><img src="../images/<?php echo $row['title_image']; ?>" width="70" height="70" /></td>
                    <td><img src="../images/<?php echo $row['card_image']; ?>" width="70" height="70" /></td>
                    <td><img src="../images/<?php echo $row['benefits_count_border_image']; ?>" width="70" height="70" /></td>
                    <td><img src="../images/<?php echo $row['profile_in_room_card']; ?>" width="70" height="70" /></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['benefits_count']; ?></td>
                    <td><?php echo $row['main_color']; ?></td>
                    <td><?php echo $row['dark_color']; ?></td>
                    <td><?php echo $row['required_points']; ?></td>
                    <td>
                    <a href="vip-subscriptions-edit.php?vipsub_id=<?php echo $row['id']; ?>" class="btn btn-info">Edit</a>
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