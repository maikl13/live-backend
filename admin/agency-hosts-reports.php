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
            <h1 class="m-0">Agency Reports ( From Hosts )</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Agency Reports ( From Hosts )</li>
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
                <h3 class="card-title">Agency Reports ( From Hosts )
                </h3>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Reporter Name (From)</th>
                    <th>Agency Image</th>
                    <th>Report To Agency(To)</th>
                    <th>Report Details</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $query = "SELECT a.id AS idhostreport, b.id, a.user_uid, a.agency_id, a.message, b.uid, b.short_digital_id, b.full_name, b.profile_pic, a.datetime, c.name AS agency_name, c.image AS agency_image
                    FROM agency_hostsreports AS a
                    INNER JOIN users AS b ON a.user_uid = b.uid COLLATE utf8mb4_unicode_ci
                    INNER JOIN agency AS c ON a.agency_id = c.id
                    WHERE a.id";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                          ?>
                  <tr>
                    <td><?php echo $row['idhostreport']; ?></td>
                    <td><?php echo $row['full_name']; ?></td>
                    <td><img src="../images/<?php echo $row['agency_image']; ?>" width="70" height="70" /></td>
                    <td><?php echo $row['agency_name']; ?> (ID : <?php echo $row['agency_id']; ?>)</td>
                    <td><?php echo $row['message']; ?></td>
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