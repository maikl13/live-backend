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
            <h1 class="m-0">Hats List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Edit Hat</li>
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
                <h3 class="card-title">Edit Hat
                </h3>
                <a href="hats.php" class="btn btn-danger float-right">Back</a>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                    <form action="code-hats.php" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                <?php
                if(isset($_GET['hat_id']))
                {
                    $hat_id = $_GET['hat_id'];
                    $query = "SELECT * FROM hats WHERE id='$hat_id' LIMIT 1 ";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                            ?>
                    <input type="hidden" name="hat_id" value="<?php echo $row['id'] ?>">
                <div class="form-group">
                <label for="">Hat Name</label>
                    <input type="text" name="title" value="<?php echo $row['title'] ?>" class="form-control" placeholder="Hat Name">
              </div>
              <div class="form-group">
                <label for="">Hat Days</label>
                <select name="days" class="form-control" value=" <?php echo $row['days'] ?>">
                <option value="7" <?php if($row["days"]=="7"){echo "selected";} ?>>7 Days</option>
                <option value="30" <?php if($row["days"]=="30"){echo "selected";} ?>>30 Days</option>
                <option value="90" <?php if($row["days"]=="90"){echo "selected";} ?>>90 Days</option>
                <option value="365" <?php if($row["days"]=="365"){echo "selected";} ?>>365 Days</option>
                </select>
              </div>
              <div class="form-group">
                <label for="">Hat Price</label>
                    <input type="text" name="golds" value="<?php echo $row['golds'] ?>" class="form-control" placeholder="Price">
              </div>
              <div class="form-group">
                <label for="">Using By</label>
                <select name="only_premium" class="form-control" value=" <?php echo $row['only_premium'] ?>">
                <option value="0" <?php if($row["only_premium"]=="0"){echo "selected";} ?>>All Users</option>
                <option value="1" <?php if($row["only_premium"]=="1"){echo "selected";} ?>>Premium Users</option>
                </select>
              </div>
              <div class="col-md-8">   
              <div class="form-group">
                <label for="">Hat Image</label>
                <input type="hidden" name="old_image" value="<?php echo $row['image'] ?>">
                    <input type="file" name="image" class="form-control" placeholder="image"> 

              </div>
              <img src="../images/<?php echo $row['image']; ?>" width="100px" height="100px"  alt="Image">


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
              <button type="submit" name="updateHat" class="btn btn-info">Update</button>
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