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
              <h4 class="modal-title">Delete Level</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="code-add-agency.php" method="POST"  enctype="multipart/form-data">
            <div class="modal-body">
                <input type="hidden" name="delete_id" class="delete_agency_id">
                <p>
                    Are your sure. you want delete this Data?
                </p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="DeleteAgencybtn" class="btn btn-danger">Yes, Delete !</button>
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
            <h1 class="m-0">Account Levels List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Account Levels List</li>
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
                <h3 class="card-title">Account Levels List
                </h3>
                <a href="add-agency.php"  class="btn btn-primary float-right"><i class="addicon"></i>  Add Level</a>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Level</th>
                    <th>EXP</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $query = "SELECT * FROM main_levels";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                          ?>
                  <tr>
                    <td><?php echo $row['level']; ?></td>
                    <td><?php echo $row['level_required_exp']; ?></td>
                    <td>
                    <a href="account-level-edit.php?level_id=<?php echo $row['level']; ?>" class="btn btn-info"><i class="editicon"></i>  Edit</a>
                    <button type="button" value="<?php echo $row['level']; ?>" class="btn btn-danger deletebtn"><i class="deleteicon"></i>  Delete</a>
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

            var agency_id = $(this).val();
            //console.log(user_id);
            $('.delete_agency_id').val(agency_id);
            $('#DeletModal').modal('show');
             
        });
    });
</script>

<?php include('includes/footer.php'); ?>