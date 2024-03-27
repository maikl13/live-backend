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
            <h1 class="m-0">Package Edit</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Package</li>
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
                <h3 class="card-title">Edit Package
                </h3>
                <a href="package-price.php" class="btn btn-danger float-right">Back</a>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                    <form action="code-packageprice.php" method="POST"  enctype="multipart/form-data">
            <div class="modal-body">
                <?php
                if(isset($_GET['package_id']))
                {
                    $package_id = $_GET['package_id'];
                    $query = "SELECT * FROM coins_packages WHERE id='$package_id' LIMIT 1 ";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                            ?>
                    <input type="hidden" name="package_id" value="<?php echo $row['id'] ?>">
            <div class="form-group">
                <label for="">Coins</label>
                    <input type="text" name="value_in_coins" value="<?php echo $row['value_in_coins'] ?>" class="form-control" placeholder="Coins">
              </div>
              <div class="form-group">
                <label for="">Price</label>
                    <input type="text" name="value_in_real_money" value="<?php echo $row['value_in_real_money'] ?>" class="form-control" placeholder="Price">
                    </div>
              <div class="form-group">
                <label for="">Payment ID ( Google play & Apple store )</label>
                    <input type="text" name="payment_id" value="<?php echo $row['payment_id'] ?>" class="form-control" placeholder="Payment ID">


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
              <button type="submit" name="updatePackage" class="btn btn-info">Update <i class="sucss-icon"></i></button>
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