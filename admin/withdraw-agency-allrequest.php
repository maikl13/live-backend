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
            <h1 class="m-0">Withdraw Agency - All Request</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Withdraw Agency - All Request</li>
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
                <h3 class="card-title">Withdraw Agency - All Request
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
                    <th>Payment Method</th>
                    <th>Agency Owner</th>
                    <th>Status</th>
                    <th>Datetime</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $query = "SELECT 
                    a.id as idrequestagency, 
                    b.id, 
                    a.uid, 
                    a.agencyid, 
                    a.firstname,  
                    b.name, 
                    a.lastname, 
                    b.bio, 
                    b.co_founder_uid, 
                    b.owner_uid, 
                    b.image, 
                    b.flag, 
                    b.balance, 
                    a.payment_method, 
                    a.bank_address, 
                    a.iban, 
                    a.swiftcode, 
                    a.western_union_details, 
                    a.country, 
                    a.phone, 
                    a.amount, 
                    a.dollarsamount, 
                    a.status, 
                    a.submission_time, 
                    u.full_name as owner_full_name,
                    u.short_digital_id
                FROM 
                    withdraw_request_agency AS a 
                INNER JOIN 
                    agency AS b ON a.uid = b.owner_uid
                LEFT JOIN 
                    users AS u ON b.owner_uid = u.uid
                WHERE 
                    a.id";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                          ?>
                  <tr>
                    <td><?php echo $row['idrequestagency']; ?></td>
                    <td><img src="../images/<?php echo $row['image']; ?>" width="70" height="70" /></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['payment_method']; ?></td>
                    <td><?php echo $row['uid']; ?>(<?php echo $row['owner_full_name']; ?>)(ID:<?php echo $row['short_digital_id']; ?>)</td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['submission_time']; ?></td>
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