<?php
session_start();
include('includes/header.php');
if(isset($_SESSION['auth']))
{
    $_SESSION['status'] = "You already Logged in";
    header("Location: index.php");   
    exit(0); 
}
?>

<div class="container">

<!-- Outer Row -->
<div class="row justify-content-center">

  <div class="col-xl-6 col-lg-6 col-md-6">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-12">
            <div class="p-5">
              <div class="text-center">
                <img src="https://cdn-icons-png.flaticon.com/512/295/295128.png" style="width:100px;height:100px;">
                <h1 class="h4 text-gray-900 mb-4">Login Here!</h1>
                <?php
                if(isset($_SESSION['auth_status']))
                    {
                 ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert"> 
                <strong>Hey!</strong> <?php echo $_SESSION['auth_status']; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
                 </button>
                </div>
                    <?php
                unset($_SESSION['auth_status']);
                    }
                    ?>
                <?php
                include('message.php');
                ?>
              </div>
                <form action="logincode.php" method="POST">

                    <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Enter Email Address...">
                    </div>
                    <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
            
                    <button type="submit" name="login_btn" class="btn btn-dark btn-user btn-block"> Login </button>
                    <hr>
                </form>


            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

</div>

</div>



<?php include('includes/script.php'); ?>
