<?php
session_start();
$page_title = "Voice Chat | Hashtags";
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
            <h1 class="m-0">Withdraw Agency Logs</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Withdraw Agency Logs</li>
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
                <h3 class="card-title">Withdraw Agency Logs
                </h3>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Agency Name</th>
                    <th>Order ID</th>
                    <th>Amount ( Golds )</th>
                    <th>Status</th>
                    <th>Action By(Admin)</th>
                    <th>Datetime</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $query = "SELECT a.id as idwithagencylogs, b.id, a.order_id, a.agencyid, a.amount,  b.name, a.status, b.image, a.datelastaction, a.action_by FROM withdraw_request_agency_logs AS a INNER JOIN agency AS b ON a.agencyid = b.id WHERE a.id";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                          ?>
                  <tr>
                    <td><?php echo $row['idwithagencylogs']; ?></td>
                    <td><img src="../images/<?php echo $row['image']; ?>" width="70" height="70" /></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['order_id']; ?></td>
                    <td><?php echo $row['amount']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['action_by']; ?></td>
                    <td><?php echo $row['datelastaction']; ?></td>
                    <td>
                    <a href="transaction-view-agency.php?transaction_id=<?php echo $row['idrequestagency']; ?>" class="btn btn-info"><i class="profileicon"></i> VIEW</a>
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

     <script>
$(document).ready(function(){
    $('.btn-primary').click(function(){
        var id = $(this).val();
        $.ajax({
            url: 'get_data-withdraw.php', // اسم الملف الذي سيقوم بجلب البيانات
            type: 'POST',
            data: {id: id},
            success: function(response){
                $('#myModal .modal-body').html(response);
                $('#myModal').modal('show');
            }
        });
    });
});
</script>


<?php include('includes/script.php'); ?>
<?php include('includes/footer.php'); ?>