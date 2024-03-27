<?php
session_start();

include('includes/header.php');
include('authentication.php');
include('includes/topbar.php');
include('includes/sidebar.php');

if(isset($_SESSION['agent_id']))
{

}


?>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


        <!-- Main content -->
        <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="col md 12">
          
            <?php 
            include('message.php');
             ?>
          </div>
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">

                  <?php
                  require 'config/dbcon.php';
                  $agent_id = $_SESSION['auth_useragent']['agent_id'];
                  $query = "SELECT * FROM agent_coins_transactions WHERE agent_id='$agent_id'";
                  $query_run = mysqli_query($con, $query);

                  $row = mysqli_num_rows($query_run);

                  echo '<h1> '.$row.' </h1>';

                  ?>
                <p>Total Transactions</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="users.php" class="small-box-footer">View All <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
              <?php
                    $agent_id = $_SESSION['auth_useragent']['agent_id'];
                    $query = "SELECT * FROM agent_coins WHERE id='$agent_id' LIMIT 1";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                          ?>
                           <?php echo'<h1> ' .$row['credit'].'<h1>';?>
                <p>Total Credit</p>
                <?php
                        }
                    }
                    else
                    {
                        echo "<h4> No Record Found </h4>";
                    }
                ?>

              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">View All <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </section>
        </div>



        

<?php include('includes/script.php'); ?>
<?php include('includes/footer.php'); ?>