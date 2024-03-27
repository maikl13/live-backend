<?php
session_start();
include('includes/header.php');
include('authentication.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('config/dbcon.php');


// تحقق مما إذا كان المستخدم قد قام بتسجيل الدخول
if (!isset($_SESSION['auth_agentcoins'])) {
    header("Location: login.php");
    exit();
}

$agent_id = $_SESSION['auth_useragent']['agent_id'];

// استعراض بيانات المستخدم من قاعدة البيانات
$query = "SELECT * FROM agent_coins WHERE id = '$agent_id'";
$result = $con->query($query);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Error retrieving user data.";
    exit();
}

// تحديث بيانات المستخدم عند الضغط على زر التعديل
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $country = $_POST['country'];

    $updateQuery = "UPDATE agent_coins SET country = '$country' WHERE id = '$agent_id'";
    $updateResult = $con->query($updateQuery);

    if ($updateResult) {
        $_SESSION['status'] = 'Success';
        $_SESSION['status_code'] = 'success';
    } 
    else
     {
        $_SESSION['status'] = 'ERROR';
        $_SESSION['status_code'] = 'error';
    }
}

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Profile
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Profile</li>
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
            <h3 class="card-title">Edit Profile</h3>
            <a href="index.php" class="btn btn-danger float-right">Back</a>
            <div class="card-tools">
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"  enctype="multipart/form-data">

                                               <!-- /.form-group -->
                <div class="form-group">
                <label for="">Account Name</label>
                    <input type="text" name="agent_name" disabled="disabled" value="<?php echo $user['name']; ?>" class="form-control" placeholder="Account Name">
              </div>


                <div class="form-group">
                <label for="">Country</label>
                    <input type="text" name="country" value="<?php echo $user['country'] ?>" class="form-control" placeholder="Country">
              </div>


                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
              <div class="form-group">
                <label for="">Email Address</label>
                    <input type="text" name="short_digital_id" disabled="disabled" value="<?php echo $user['email']; ?>" class="form-control" placeholder="Gold">
              </div>



                <!-- /.form-group -->
              </div>

              <!-- /.col -->
            </div>
            <!-- /.row -->
            </div>
            <div class="modal-footer">
              <button type="submit" name="submit" class="btn btn-info float-right">Update <i class="sucss-icon"></i></button>
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
 