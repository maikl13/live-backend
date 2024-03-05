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
              <h4 class="modal-title">Add New Vehicle</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="code/code-hats.php" method="POST">
            <div class="modal-body">
              <div class="form-group">
                <label for="">Vehicle Name</label>
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
                    <input type="price" name="price" class="form-control" placeholder="price">
              </div>
              <div class="form-group">
                <label for="">Min Premium</label>
                <select name="minimum_premium_position" class="form-control">
                <option value="0"> NO Premium</option>
                <option value="1"> Premium 1 </option>
                <option value="1"> Premium 2 </option>
                <option value="3"> Premium 3 </option>
                <option value="4"> Premium 4 </option>
                <option value="5"> Premium 5 </option>

                </select>
              </div>
              <div class="form-group">
                <label for="">Vehicle Image</label>
                    <input type="file" name="image" class="form-control" placeholder="Level">
              </div>
              <div class="form-group">
                <label for="">Animated Image</label>
                    <input type="file" name="animated_image" class="form-control" placeholder="Level">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="addvehicle" class="btn btn-primary">Add Vehicle</button>
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
              <h4 class="modal-title">Delete Vehicle</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="code/code-hats.php" method="POST">
            <div class="modal-body">
                <input type="hidden" name="delete_id" class="delete_user_id">
                <p>
                    Are your sure. you want delete this Data?
                </p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="DeleteThemebtn" class="btn btn-danger">Yes, Delete !</button>
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
            <h1 class="m-0">Store | Vehicles</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Vehicles List</li>
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
                <?php
                    unset($_SESSION['status_added']);
                        
                    include('message-sucssess.php');
                    ?>
                            </div>
                        </div>
                        </div>
    <div class="card">
              <div class="card-header">
                <h3 class="card-title">Vehicles List
                </h3>
                <a href="#" data-toggle="modal" data-target="#AddAdminModal" class="btn btn-primary float-right">Add Vehicle</a>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Animated image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Days</th>
                    <th>Min Premium lvl</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $query = "SELECT * FROM vehicles";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                          ?>
                  <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><img src="../images/<?php echo $row['image']; ?>" width="70" height="70" /></td>
                    <td><img src="../images/<?php echo $row['animated_image']; ?>" width="70" height="70" /></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td><?php echo $row['days']; ?></td>
                    <td><?php echo $row['minimum_premium_position']; ?></td>
                    <td>
                    <a href="admins-edit.php?user_id=<?php echo $row['id']; ?>" class="btn btn-info">Edit</a>
                    <button type="button" value="<?php echo $row['id']; ?>" class="btn btn-danger deletebtn">Delete</a>
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