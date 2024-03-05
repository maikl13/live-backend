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
            <h1 class="m-0">Admin List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">EDIT ADMIN</li>
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
                <h3 class="card-title">EDIT ADMIN
                </h3>
                <a href="admins.php" class="btn btn-danger float-right">Back</a>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                    <form action="code.php" method="POST"  enctype="multipart/form-data">
            <div class="modal-body">
                <?php
                if(isset($_GET['user_id']))
                {
                    $user_id = $_GET['user_id'];
                    $query = "SELECT * FROM admins WHERE id='$user_id' LIMIT 1 ";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                            ?>
                    <input type="hidden" name="user_id" value="<?php echo $row['id'] ?>">
            <div class="form-group">
                <label for="">Name</label>
                    <input type="text" name="name" value="<?php echo $row['name'] ?>" class="form-control" placeholder="Name">
              </div>
              <div class="form-group">
                <label for="">Phone Number</label>
                    <input type="text" name="phone" value="<?php echo $row['phone'] ?>" class="form-control" placeholder="Phone Number">
              </div>
              <div class="form-group">
                <label for="">Email</label>
                    <input type="email" name="email" value="<?php echo $row['email'] ?>" class="form-control" placeholder="Email">
              </div>
              <div class="form-group">
                <label for="">Password</label>
                    <input type="password" name="password" value="<?php echo $row['password'] ?>" class="form-control" placeholder="Password">
              </div>
              <div class="form-group">
                <label for="">Admin Image</label>
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
              <button type="submit" name="updateAdmin" class="btn btn-info">Update <i class="sucss-icon"></i></button>
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