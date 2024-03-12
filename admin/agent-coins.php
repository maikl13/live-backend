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


  <!-- Admins Modal -->
<div class="modal fade" id="AddAdminModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add New Agent Coins</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="code-add-agentcoins.php" method="POST"  enctype="multipart/form-data">
            <div class="modal-body">
              <div class="form-group">
                <label for="">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Name">
              </div>
              <div class="form-group">
                <label for="">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Email">
              </div>
              <div class="form-group">
                <label for="">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group">
                <label for="">Credit</label>
                    <input type="text" name="credit" class="form-control" placeholder="Credit">
                    </div>
              <div class="form-group">
                <label for="">Agent Image</label>
                <input type="file" name="image" class="form-control" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="addAgentcoins" class="btn btn-primary">Add Agent</button>
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
              <h4 class="modal-title">Delete Agent</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="code-add-agentcoins.php" method="POST"  enctype="multipart/form-data">
            <div class="modal-body">
                <input type="hidden" name="delete_id" class="delete_agent_id">
                <p>
                    Are your sure. you want delete this Data?
                </p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="DeleteAgentbtn" class="btn btn-danger">Yes, Delete !</button>
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
            <h1 class="m-0">Agent Coins List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Agent Coins List</li>
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
                <h3 class="card-title">Agent Coins List
                </h3>
                <a href="#" data-toggle="modal" data-target="#AddAdminModal" class="btn btn-primary float-right"><i class="addicon"></i>  Add Agent Coins</a>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Credit</th>
                    <th>Created_at</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $query = "SELECT * FROM agent_coins";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                          ?>
                  <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><img src="../images/<?php echo $row['image']; ?>" width="70" height="70" /></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['credit']; ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                    <td>
                    <a href="agent-coins-edit.php?agent_id=<?php echo $row['id']; ?>" class="btn btn-info"><i class="editicon"></i>  Edit</a>
                    <a href="agent-coins-transactions.php?agent_id=<?php echo $row['id']; ?>" class="btn btn-info"><i class="editicon"></i>  Transactions</a>
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

            var agent_id = $(this).val();
            //console.log(user_id);
            $('.delete_agent_id').val(agent_id);
            $('#DeletModal').modal('show');
             
        });
    });
</script>

<?php include('includes/footer.php'); ?>