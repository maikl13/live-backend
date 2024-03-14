<?php
session_start();
include('includes/header.php');
include('authentication.php');
include('includes/topbar.php');
include('includes/sidebar.php');
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
                  $query = "SELECT id FROM users ORDER BY id";
                  $query_run = mysqli_query($con, $query);

                  $row = mysqli_num_rows($query_run);

                  echo '<h1> '.$row.' </h1>';

                  ?>
                <p>Total Users</p>
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
                  require 'config/dbcon.php';
                  $query = "SELECT id FROM rooms ORDER BY id";
                  $query_run = mysqli_query($con, $query);

                  $row = mysqli_num_rows($query_run);

                  echo '<h1> '.$row.' </h1>';

                  ?>

                <p>Total Rooms</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">View All <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
              <?php
                  require 'config/dbcon.php';
                  $query = "SELECT * FROM user_rooms WHERE is_online > 0;";
                  $query_run = mysqli_query($con, $query);

                  $row = mysqli_num_rows($query_run);

                  echo '<h1> '.$row.' </h1>';

                  ?>
                <p>Online Users</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">View All <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
              <?php
                  require 'config/dbcon.php';
                  $query = "SELECT id FROM posts ORDER BY id";
                  $query_run = mysqli_query($con, $query);

                  $row = mysqli_num_rows($query_run);

                  echo '<h1> '.$row.' </h1>';

                  ?>
                <p>Total Posts</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">View All <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
              <?php
                                require 'config/dbcon.php';
                    $query = "SELECT  SUM(coins_packages.value_in_coins)  AS coins FROM `recharge` JOIN `users` ON users.id = recharge.user_id JOIN `coins_packages` ON recharge.coins_package_id = coins_packages.id WHERE recharge.recharge_datetime ORDER BY coins";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                        }
                      }
                          ?>
            <?php echo'<h1> ' .$row['coins'].'<h1>';?>
                <p>Total Recharge ( Golds )</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">View All <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
              <?php
                                require 'config/dbcon.php';
                    $query = "SELECT  SUM(coins_packages.value_in_real_money)  AS coins FROM `recharge` JOIN `users` ON users.id = recharge.user_id JOIN `coins_packages` ON recharge.coins_package_id = coins_packages.id WHERE recharge.recharge_datetime ORDER BY coins";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0) {
                      foreach($query_run as $row) {
                        $formatted_coins = number_format($row['coins'], 2); // تقصير النتيجة لتكون بـ 2 أرقام بعد الفاصلة
                        echo '<h1>' . $formatted_coins . '</h1>';
                        echo '<p>Total Recharge ( Dollars )</p>';
                                      }
                  }
                  ?>
                                </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">View All <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
              <?php
                  require 'config/dbcon.php';
                  $query = "SELECT id FROM agency ORDER BY id";
                  $query_run = mysqli_query($con, $query);

                  $row = mysqli_num_rows($query_run);

                  echo '<h1> '.$row.' </h1>';

                  ?>
                <p>Total Agency</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">View All <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
              <?php
                  require 'config/dbcon.php';
                  $query = "SELECT id FROM agent_coins ORDER BY id";
                  $query_run = mysqli_query($con, $query);

                  $row = mysqli_num_rows($query_run);

                  echo '<h1> '.$row.' </h1>';

                  ?>
                <p>Total Agent Coins</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">View All <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>


                      


       </div>
        </div>


        
        

        

        <!-- /.row -->
        </section>
        </div>



        

<?php include('includes/script.php'); ?>
<?php include('includes/footer.php'); ?>