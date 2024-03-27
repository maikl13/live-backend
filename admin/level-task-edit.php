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
        <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Task -  
                
            <?php
                if(isset($_GET['task_id']))
                {
                  $task_id = $_GET['task_id'];
                  $query = "SELECT * FROM level_tasks WHERE id='$task_id' LIMIT 1 ";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                            ?>
    
            <?php echo $row['title'] ?></h1>

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
              <li class="breadcrumb-item active">Edit Level Task</li>
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
            <h3 class="card-title">Edit Level Task</h3>
            <a href="level-task.php" class="btn btn-danger float-right">Back</a>
            <div class="card-tools">
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
              <form action="level-task-code.php" method="POST"  enctype="multipart/form-data">
              <?php
                     $task_id = $_GET['task_id'];
                    $query = "SELECT * FROM level_tasks WHERE id='$task_id' LIMIT 1";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                          ?>
                          <input type="hidden" name="task_id" value="<?php echo $row['id'] ?>">

                                               <!-- /.form-group -->
                <div class="form-group">
                <label for="">Title ( Task Name )</label>
                    <input type="text" name="title"  value="<?php echo $row['title'] ?>" class="form-control" placeholder="Title">
              </div>

              <?php
                if(isset($_GET['task_id']))
                {
                  $task_id = $_GET['task_id'];
                  $query = "SELECT * FROM level_tasks WHERE id='$task_id' LIMIT 1 ";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                            ?>
                    <input type="hidden" name="task_id" value="<?php echo $row['id'] ?>">
                <div class="form-group">
                <label for="">Sub Title</label>
                    <input type="text" name="sub_title" value="<?php echo $row['sub_title'] ?>" class="form-control" placeholder="Account Name">
              </div>

                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
              <div class="form-group">
                <label for="">More Info</label>
                    <input type="text" name="more_info" value="<?php echo $row['more_info'] ?>" class="form-control" placeholder="More Info">
              </div>
              <div class="form-group">
                <label for="">Max EXP ( Daily )</label>
                    <input type="text" name="max_exp_per_day"  value="<?php echo $row['max_exp_per_day'] ?>" class="form-control" placeholder="Max EXP ( Daily )">
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
              <button type="submit" name="updateleveltask" class="btn btn-info float-right">Update <i class="sucss-icon"></i></button>
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