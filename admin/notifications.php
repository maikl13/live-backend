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
            <h1 class="m-0">Send Notification</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Send Notification</li>
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
                <h3 class="card-title">Send Notification
                </h3>
                <a href="index.php" class="btn btn-danger float-right">Back</a>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                    <form action="send_notification.php" method="POST">
                      <div class="modal-body">
                      <div class="form-group">
                        <label for="title">Notification Title</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="Notification Title">
                    </div>
                    <div class="form-group">
                        <label for="body">Notification Content</label>
                        <input type="text" name="body" class="form-control" id="body" placeholder="Notification Content">
                    </div>
                    <button type="submit" name="updatePost" class="btn btn-info">Send Notification</button>
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