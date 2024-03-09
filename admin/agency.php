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




<!-- Delete Admin -->
<div class="modal fade" id="DeletModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Delete Agency</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="code.php" method="POST"  enctype="multipart/form-data">
            <div class="modal-body">
                <input type="hidden" name="delete_id" class="delete_user_id">
                <p>
                    Are your sure. you want delete this Data?
                </p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="DeleteAdminbtn" class="btn btn-danger">Yes, Delete !</button>
      </div>
    </form>

    </div>
  </div>
</div>
<!-- Delete Admin -->




    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Agency List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Agency List</li>
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
                <h3 class="card-title">Agency List
                </h3>
                <a href="add-agency.php"  class="btn btn-primary float-right"><i class="addicon"></i>  Add Agency</a>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Flag</th>
                    <th>Name</th>
                    <th>BIO</th>
                    <th>Founder</th>
                    <th>Balance</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $query = "SELECT a.id as agencyid, b.id, b.uid, a.name, b.short_digital_id, b.full_name, b.level, a.bio, a.owner_uid, a.co_founder_uid, a.image, a.flag, a.balance  FROM agency AS a  INNER JOIN users AS b ON a.owner_uid = b.uid";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                          ?>
                  <tr>
                    <td><?php echo $row['agencyid']; ?></td>
                    <td><img src="../images/<?php echo $row['image']; ?>" width="70" height="70" /></td>
                    <td><img src="../images/<?php echo $row['flag']; ?>" width="70" height="70" /></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['bio']; ?></td>
                    <td><?php echo $row['full_name']; ?>(ID:<?php echo $row['short_digital_id']; ?>)</td>
                    <td><?php echo $row['balance']; ?></td>
                    <td>
                    <a href="agency-edit.php?agency_id=<?php echo $row['id']; ?>" class="btn btn-info"><i class="editicon"></i>  Edit</a>
                    <button type="button" value="<?php echo $row['id']; ?>" class="btn btn-danger deletebtn"><i class="deleteicon"></i>  Delete</a>
                    </td>
                  </tr>

                          <?php
                        }
                    }
                    else
                    {
                        ?>
                        <tr>
                            <td>No Record Found</td>
                        </tr>
                        <?php
                    }
                  ?>
                  </tbody>
                </table> 
            </div>
         </div>

    </div>

    </div>
        </div>
        </div>

        </section>


     </div>

<?php include('includes/script.php'); ?>

<script>
    $(document).ready(function () {
        $('.deletebtn').click(function (e) {
            e.preventDefault();

            var user_id = $(this).val();
            //console.log(user_id);
            $('.delete_user_id').val(user_id);
            $('#DeletModal').modal('show');
             
        });
    });
</script>

<?php include('includes/footer.php'); ?>