<?php
session_start();
$page_title = "Voice Chat | Admins";
include('includes/header.php');
include('authentication.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('config/dbcon.php');
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">


<!-- Admins Modal -->
<div class="modal fade" id="AddAdminModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add New Hat</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="code-hats.php" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="form-group">
                <label for="">Name Hat</label>
                    <input type="text" name="title" class="form-control" placeholder="Name">
              </div>
              <div class="form-group">
                <label for="">Days</label>
                <select name="days" class="form-control">
                <option value="7"> 7 days </option>
                <option value="30"> 30 Days </option>
                <option value="90"> 90 Days </option>
                <option value="365"> 365 Days </option>
                </select>
              </div>
              <div class="form-group">
                <label for="">Price</label>
                    <input type="golds" name="golds" class="form-control" placeholder="Golds">
              </div>
              <div class="form-group">
                <label for="">Using By</label>
                <select name="only_premium" class="form-control">
                <option value="0"> All Users </option>
                <option value="1"> Premium Users </option>
                </select>
              </div>
              <div class="form-group">
                <label for="">Hat Image</label>
                    <input type="file" name="image" class="form-control" placeholder="Level">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="addhat" class="btn btn-primary">Add Hat</button>
      </div>
    </form>

    </div>
  </div>
</div>

<!-- Delete Admin -->
<div class="modal fade" id="DeletModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Delete Hat</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="code-hats.php"  method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                <input type="hidden" name="delete_id" class="delete_hat_id">
                <p>
                    Are your sure. you want delete this Data?
                </p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="DeleteHatbtn" class="btn btn-danger">Yes, Delete !</button>
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
            <h1 class="m-0">Store | Hats</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Hats List</li>
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
                <h3 class="card-title">Hats List
                </h3>
                <a href="#" data-toggle="modal" data-target="#AddAdminModal" class="btn btn-primary float-right"><i class="addicon"></i>  Add Hat</a>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Hats Name</th>
                    <th>Price</th>
                    <th>Days</th>
                    <th>Only Premium</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $query = "SELECT * FROM hats";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                          ?>
                  <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><img src="../images/<?php echo $row['image']; ?>" width="70" height="70" /></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['golds']; ?></td>
                    <td><?php echo $row['days']; ?></td>
                    <td><?php echo $row['only_premium']; ?></td>
                    <td>
                    <a href="hat-edit.php?hat_id=<?php echo $row['id']; ?>" class="btn btn-info"><i class="editicon"></i>  Edit</a>
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

            var hat_id = $(this).val();
            //console.log(hat_id);
            $('.delete_hat_id').val(hat_id);
            $('#DeletModal').modal('show');
             
        });
    });
</script>

<?php include('includes/footer.php'); ?>