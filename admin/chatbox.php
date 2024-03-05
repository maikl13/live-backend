<?php
session_start();
$page_title = "Voice Chat | Users";
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
              <h4 class="modal-title">Delete ChatBox</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="code/codeusers.php" method="POST">
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
            <h1 class="m-0">ChatBox List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">ChatBox List</li>
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
                <h3 class="card-title">ChatBox List
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>PNG</th>
                    <th>size_1</th>
                    <th>size_2</th>
                    <th>Price</th>
                    <th>Type</th>
                    <th>Premium Level</th>
                    <th>Padding Top</th>
                    <th>padding_bottom</th>
                    <th>padding_start</th>
                    <th>padding_end</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $query = "SELECT * FROM chat_box";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                          ?>
                  <tr>
                  <td><?php echo $row['id']; ?></td>
                    <td><img src="../images/<?php echo $row['image']; ?>" width="70" height="70" /></td>
                    <td><img src="../images/<?php echo $row['png']; ?>" width="70" height="70" /></td>
                    <td><img src="../images/<?php echo $row['size_1']; ?>" width="70" height="70" /></td>
                    <td><img src="../images/<?php echo $row['size_2']; ?>" width="70" height="70" /></td>
                    <td><?php echo $row['golds']; ?></td>
                    <td><?php echo $row['type']; ?></td>
                    <td><?php echo $row['premium_type']; ?></td>
                    <td><?php echo $row['padding_top']; ?></td>
                    <td><?php echo $row['padding_bottom']; ?></td>
                    <td><?php echo $row['padding_start']; ?></td>
                    <td><?php echo $row['padding_end']; ?></td>
                    <td>
                    <a href="chatbox-edit.php?chatbox_id=<?php echo $row['id']; ?>" class="btn btn-info"><i class="editicon"></i> Edit</a>
                    <button type="button" value="<?php echo $row['id']; ?>" class="btn btn-danger deletebtn"><i class="fa-regular deleteicon"></i> Delete</a>
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
var table = $('#example1').DataTable();
table.ajax.reload();


<?php include('includes/footer.php'); ?>