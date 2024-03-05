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
            <h1 class="m-0">Settings</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Settings</li>
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
                <h3 class="card-title">Settings
                </h3>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                    <form action="codesettings.php" method="POST">
            <div class="modal-body">
                <?php
                    $query = "SELECT * FROM websetting";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                        }
                      }
                      
                       
                          
                            ?>
                    <input type="hidden" name="user_id" value="<?php echo $row['id'] ?>">
            <div class="form-group">
                <label for="">Website Name</label>
                    <input type="text" name="sitename" value="<?php echo $row['sitename'] ?>" class="form-control" placeholder="Website Name">
              </div>
              <div class="form-group">
                <label for="">Copyright</label>
                    <input type="text" name="copyright" value="<?php echo $row['copyright'] ?>" class="form-control" placeholder="Copyright">
              </div>
              <div class="form-group">
                <label for="">Version</label>
                    <input type="text" name="version" value="<?php echo $row['version'] ?>" class="form-control" placeholder="Version">
              </div>
                
                 
                
            </div>
            <div class="modal-footer">
              <button type="submit" name="editsettings" class="btn btn-info">Save</button>
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