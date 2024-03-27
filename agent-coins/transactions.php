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
            <h1 class="m-0">Transactions List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Transactions List</li>
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
                <h3 class="card-title">Transactions List
                </h3>
                <a href="new-transaction.php"  class="btn btn-primary float-right"><i class="addicon"></i>  New Transaction</a>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example6" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Invoice</th>
                    <th>Account ID</th>
                    <th>Account Name</th>
                    <th>Credit(Golds)</th>
                    <th>Created By</th>
                    <th>Created_at</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $agent_id = $_SESSION['auth_useragent']['agent_id'];
                    $query = "SELECT * FROM agent_coins_transactions WHERE agent_id='$agent_id'";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                          ?>
                  <tr>
                    <td>#INV-<?php echo $row['order_id']; ?></td>
                    <td><?php echo $row['short_digital_id']; ?></td>
                    <td><?php echo $row['user_fullname']; ?></td>
                    <td><?php echo $row['golds']; ?></td>
                    <td><?php echo $row['agent_name']; ?></td>
                    <td><?php echo $row['datetime']; ?></td>

                    <td>
                    <a href="transaction-view.php?transaction_id=<?php echo $row['order_id']; ?>" class="btn btn-info"><i class="editicon"></i>  View</a>
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
<?php include('includes/footer.php'); ?>