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
            <h1 class="m-0">Agent Coins List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">EDIT Agent Coins</li>
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
                <h3 class="card-title">EDIT Agent Coins
                </h3>
                <a href="agent-coins.php" class="btn btn-danger float-right">Back</a>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                    <form action="code-add-agentcoins.php" method="POST"  enctype="multipart/form-data">
            <div class="modal-body">
                <?php
                if(isset($_GET['agent_id']))
                {
                    $agent_id = $_GET['agent_id'];
                    $query = "SELECT * FROM agent_coins WHERE id='$agent_id' LIMIT 1 ";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                            ?>
                    <input type="hidden" name="agent_id" value="<?php echo $row['id'] ?>">
            <div class="form-group">
                <label for="">Agent Name</label>
                    <input type="text" name="name" value="<?php echo $row['name'] ?>" class="form-control" placeholder="Name">
              </div>
              <div class="form-group">
                <label for="">Agent Email</label>
                    <input type="text" name="email" value="<?php echo $row['email'] ?>" class="form-control" placeholder="Agent Email">
              </div>
              <div class="form-group">
                <label for="">Agent Password</label>
                    <input type="password" name="password" value="<?php echo $row['password'] ?>" class="form-control" placeholder="Agent Password">
              </div>
              <div class="form-group">
                <label for="">Agent Credit</label>
                    <input type="text" name="credit" value="<?php echo $row['credit'] ?>" class="form-control" placeholder="Agent Credit">
              </div>
              <div class="form-group">
                <label for="">Agent Image</label>
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
              <button type="submit" name="updateAgent" class="btn btn-info">Update <i class="sucss-icon"></i></button>
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