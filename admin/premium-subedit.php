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
            <h1 class="m-0">Premium Package</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit - Premium Package</li>
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
                <h3 class="card-title">Edit - Premium Package
                </h3>
                <a href="gifts.php" class="btn btn-danger float-right">Back</a>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                    <form action="code/premiumsubcode.php" method="POST">
            <div class="modal-body">
                <?php
                if(isset($_GET['sub_id']))
                {
                    $sub_id = $_GET['sub_id'];
                    $query = "SELECT * FROM premium_subscription WHERE id='$sub_id' LIMIT 1 ";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                            ?>
                    <input type="hidden" name="sub_id" value="<?php echo $row['id'] ?>">
            <div class="form-group">
                <label for="">Premium Package Name</label>
                    <input type="text" name="title" value="<?php echo $row['title'] ?>" class="form-control" placeholder="Gift Name">
              </div>
              <div class="form-group">
                <label for="">Price</label>
                    <input type="text" name="price" value="<?php echo $row['price'] ?>" class="form-control" placeholder="Email">
              </div>
              <div class="form-group">
                <label for="">Max Friends</label>
                    <input type="text" name="max_friends_num" value="<?php echo $row['max_friends_num'] ?>" class="form-control" placeholder="max_friends_num">
                    </div>
              <div class="form-group">
                <label for="">Max Followers</label>
                    <input type="text" name="max_followers_num" value="<?php echo $row['max_followers_num'] ?>" class="form-control" placeholder="max_followers_num">
                    </div>
              <div class="form-group">
                <label for="">increase to level Speed</label>
                    <input type="text" name="increase_to_level_speed" value="<?php echo $row['increase_to_level_speed'] ?>" class="form-control" placeholder="increase_to_level_speed">
              </div>
              <div class="form-group">
                <label for="">Max Magic Cards</label>
                    <input type="text" name="max_magic_cards" value="<?php echo $row['max_magic_cards'] ?>" class="form-control" placeholder="max_magic_cards">
              </div>
              <div class="form-group">
                <label for="">Sending Gifts Discount</label>
                    <input type="text" name="sending_gifts_discount" value="<?php echo $row['sending_gifts_discount'] ?>" class="form-control" placeholder="sending_gifts_discount">
              </div>
              <div class="form-group">
                <label for="">Store Discount</label>
                    <input type="text" name="store_discount" value="<?php echo $row['store_discount'] ?>" class="form-control" placeholder="store_discount">
              </div>
              <div class="form-group">
                <label for="">Rebate</label>
                    <input type="text" name="rebate" value="<?php echo $row['rebate'] ?>" class="form-control" placeholder="rebate">
              </div>
              <div class="form-group">
                <label for="">Renewal</label>
                    <input type="text" name="renewal" value="<?php echo $row['renewal'] ?>" class="form-control" placeholder="renewal">
              </div>
              <div class="form-group">
                <label for="">Color</label>
                    <input type="text" name="color" value="<?php echo $row['color'] ?>" class="form-control" placeholder="color">
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
              <button type="submit" name="updatePremiumsub" class="btn btn-info">Update</button>
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