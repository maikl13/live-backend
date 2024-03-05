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
            <h1 class="m-0">Premium Package List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Hashtags</li>
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
                <h3 class="card-title">Premium Package List
                </h3>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>icon</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Minimum Premium</th>
                    <th>Static Description</th>
                    <th>More Info</th>
                    <th>Moro Image</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $query = "SELECT * FROM premium_privileges";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                          ?>
                  <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><img src="../images/<?php echo $row['icon']; ?>" width="70" height="70" /></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['minimum_premium_subscription']; ?></td>
                    <td><?php echo $row['static_description']; ?></td>
                    <td><?php echo $row['more_info_text']; ?></td>
                    <td><?php echo $row['more_info_image']; ?></td>
                    <td>
                    <a href="premium-privedit.php?sub_id=<?php echo $row['id']; ?>" class="btn btn-info">Edit</a>
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