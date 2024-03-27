<?php
session_start();
include('includes/header.php');
include('authentication.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('config/dbcon.php');

if(isset($_SESSION['auth_agentcoins']))
{
  echo $_SESSION['auth_useragent']['agent_name']; 
}


?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>New Transaction To 
            <?php
                if(isset($_GET['user_id']))
                {
                  $user_id = $_GET['user_id'];
                  $query = "SELECT * FROM users WHERE id='$user_id' LIMIT 1 ";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                            ?>
    
            <?php echo $row['full_name'] ?> - <?php echo $row['short_digital_id'] ?></h1>

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
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">New Transaction</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">New Transaction</h3>
            <a href="new-transaction.php" class="btn btn-danger float-right">Back</a>
            <div class="card-tools">
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
              <form action="send-golds-code.php" method="POST"  enctype="multipart/form-data">
              <?php
                    $agent_id = $_SESSION['auth_useragent']['agent_id'];
                    $query = "SELECT * FROM agent_coins WHERE id='$agent_id' LIMIT 1";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                          ?>

                                               <!-- /.form-group -->
                <div class="form-group">
                <label for="">Agent Name ( Your Account Name )</label>
                    <input type="text" name="agent_name" disabled="disabled" value="<?php echo $row['name'] ?>" class="form-control" placeholder="Account Name">
              </div>

              <?php
                if(isset($_GET['user_id']))
                {
                  $user_id = $_GET['user_id'];
                  $query = "SELECT * FROM users WHERE id='$user_id' LIMIT 1 ";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                            ?>
                    <input type="hidden" name="user_id" value="<?php echo $row['id'] ?>">
                    <input type="hidden" name="user_uid" value="<?php echo $row['uid'] ?>">
                    <input type="hidden" name="full_name" value="<?php echo $row['full_name'] ?>">
                    <input type="hidden" name="short_digital_id" value="<?php echo $row['short_digital_id'] ?>">

                <div class="form-group">
                <label for="">Account Name</label>
                    <input type="text" name="full_name" disabled="disabled" value="<?php echo $row['full_name'] ?>" class="form-control" placeholder="Account Name">
              </div>
                <!-- /.form-group -->
                <div class="form-group">
                <label for="">Account BIO</label>
                    <input type="text" name="bio" disabled="disabled" value="<?php echo $row['bio'] ?>" class="form-control" placeholder="Account BIO">
              </div>

                      <!-- textarea -->
                      <div class="form-group">
                        <label>Notes</label>
                        <textarea name="notes" class="form-control" rows="4" placeholder="Your Notes Here"></textarea>
                      </div>


                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
              <div class="form-group">
                <label for="">Account ID</label>
                    <input type="text" name="short_digital_id" disabled="disabled" value="<?php echo $row['short_digital_id'] ?>" class="form-control" placeholder="Gold">
              </div>
              <div class="form-group">
                <label for="">Account Level</label>
                    <input type="text" name="level" disabled="disabled" value="<?php echo $row['level'] ?>" class="form-control" placeholder="Account Name">
              </div>
               <!-- /.form-group -->
                <div class="form-group">
                <label for="">Golds ( Amount Credits You want send to account in app )</label>
                    <input type="text" name="gold"  value="" class="form-control" placeholder="GOLD">
              </div>



                <?php
                        }
                    }
                    else
                    {
                        echo "<h4> No Record Found </h4>";
                    }
                }  
              
             } 
            } 
                ?>

                <!-- /.form-group -->
              </div>

              <!-- /.col -->
            </div>
            <!-- /.row -->
            </div>
            <div class="modal-footer">
              <button type="submit" name="sendGold" class="btn btn-info float-right">Send <i class="sucss-icon"></i></button>
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