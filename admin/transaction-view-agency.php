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
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h1>Withdraw Agency - Invoice #INV-
            <?php
                if(isset($_GET['transaction_id']))
                {
                    $transaction_id = $_GET['transaction_id'];
                    $query = "SELECT * FROM withdraw_request_agency WHERE id='$transaction_id' LIMIT 1 ";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                            ?>
    
            <?php echo $row['id'] ?></h1>

            <?php
                        }
                    }
                    else
                    {
                        echo "<h4> </h4>";
                        
                    }
                }  
              
             
                ?>
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Invoice #INV-
              <?php
                if(isset($_GET['transaction_id']))
                {
                  $transaction_id = $_GET['transaction_id'];
                  $query = "SELECT * FROM withdraw_request_agency WHERE id='$transaction_id' LIMIT 1 ";   
                  $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                            ?>
    
            <?php echo $row['id'] ?></h1>

            <?php
                        }
                    }
                    else
                    {
                        echo "<h4>  </h4>";
                    }
                }  
              
             
                ?>

              </li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>




            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i>
                    <?php
                    $query = "SELECT * FROM websetting";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                        }
                      }
                          ?>
                            
                         
            <?php echo $row['sitename'];?>
                    <small class="float-right">
                    <?php
                if(isset($_GET['transaction_id']))
                {
                  $transaction_id = $_GET['transaction_id'];
                  $query = "SELECT * FROM withdraw_request WHERE id='$transaction_id' LIMIT 1 ";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                             echo $row['submission_time'];?>

                            <?php
                        }
                    }
                    else
                    {
                        echo "<h4>  </h4>";
                    }
                }  
              
             
            
                ?>

                    </small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                <strong>   From  </strong>
                  <address>
                    Agency Name :
                    <?php
                if(isset($_GET['transaction_id']))
                {
                  $transaction_id = $_GET['transaction_id'];
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
                  a.id='$transaction_id' LIMIT 1 ";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                             echo $row['name'];?>

                           
                  
                    <br>
                    Agency ID : <?php echo $row['agencyid']; ?><br>
                    Agency Owner : <?php echo $row['owner_full_name']; ?><br>
                  </address>
                  <?php
                        }
                    }
                    else
                    {
                        echo "<h4>  </h4>";
                    }
                }  
            
                ?>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                <strong>  Withdrawal Details </strong>
                  <address>
                    Payment Method :         
                        <?php
                if(isset($_GET['transaction_id']))
                {
                  $transaction_id = $_GET['transaction_id'];
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
                  a.id='$transaction_id' LIMIT 1 ";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                             echo $row['payment_method'];?>

                           
                   

                    <br>
                    First Name : <?php echo $row['firstname']; ?><br>
                    Last Name : <?php echo $row['lastname']; ?><br>
                    Country : <?php echo $row['country']; ?><br>
                    Phone Number : <?php echo $row['phone']; ?><br>
                    Bank Address : <?php echo $row['bank_address']; ?><br>
                    IBAN : <?php echo $row['iban']; ?><br>
                    SWIFTCODE : <?php echo $row['swiftcode']; ?><br>
                    Western Union Details : <?php echo $row['western_union_details']; ?><br>
                  </address>
                  <?php
                        }
                    }
                    else
                    {
                        echo "<h4>  </h4>";
                    }
                }  
            
                ?>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Paypal Method
                  <?php
                if(isset($_GET['transaction_id']))
                {
                  $transaction_id = $_GET['transaction_id'];
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
                  a.id='$transaction_id' LIMIT 1 ";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                             ?>


                  </b><br>
                  <br>
                  Paypal Email : <?php echo $row['paypal_email']; ?><br>
                </div>
                <!-- /.col -->
              </div>
              <?php
                        }
                    }
                    else
                    {
                        echo "<h4>  </h4>";
                    }
                }  
            
                ?>

              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Datetime</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                if(isset($_GET['transaction_id']))
                {
                  $transaction_id = $_GET['transaction_id'];
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
                  a.id='$transaction_id' LIMIT 1 ";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                             ?>
                  <tr>
                    <td><img src="../images/<?php echo $row['image']; ?>" width="70" height="70" /></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['submission_time']; ?></td>
                  </tr>
                  <?php
                        }
                    }
                    else
                    {
                        echo "<h4>  </h4>";
                    }
                }  
            
                ?>
                  </tbody>
                </table> 
                            </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                  <p class="lead"></p>

                  <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                    
                  </p>
                </div>
                <!-- /.col -->
                <div class="col-6">
                  <p class="lead">Withdrawal Date : 
                  <?php
                if(isset($_GET['transaction_id']))
                {
                  $transaction_id = $_GET['transaction_id'];
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
                  a.id='$transaction_id' LIMIT 1 ";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                             ?>

                            <?php echo $row['submission_time']; ?>
                  </p>

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Golds Amount :</th>
                        <td> <?php echo $row['amount']; ?></td>
                      </tr>
                      <tr>
                        <th>Dollars Amount:</th>
                        <td><?php echo $row['dollarsamount']; ?></td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <?php
                        }
                    }
                    else
                    {
                        echo "<h4>  </h4>";
                    }
                }  
            
                ?>

              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <form action="transaction-code-agency-withdraw.php" method="post">
              <?php
                if(isset($_GET['transaction_id']))
                {
                  $transaction_id = $_GET['transaction_id'];
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
                  a.id='$transaction_id' LIMIT 1 ";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                             ?>
              <div class="row no-print">
                <div class="col-12">
                <input type="hidden" name="transaction_id" value="<?php echo $row['idrequestagency'] ?>">
                  <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                  <button type="submit" name="updatetocompleted" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Approval</button>
                  <button type="submit" name="updatetoprocessing" class="btn btn-info float-right" style="margin-right: 5px;"><i class="fas fa-download"></i> Processing</button>
                  <button type="submit" name="updatetopending" class="btn btn-warning float-right" style="margin-right: 5px;"><i class="fas fa-download"></i> Pending</button>
                  <button type="submit" name="updatetofailed" class="btn btn-danger float-right" style="margin-right: 5px;"> Reject</button>
                </div>
                </form>
              </div>
              <?php
                        }
                    }
                    else
                    {
                        echo "<h4>  </h4>";
                    }
                }  
            
                ?>

            </div>

            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <!-- /.content -->
    </div>
  <!-- /.content-wrapper -->



</div>

<script>
 // window.addEventListener("load", window.print());
</script>



<?php include('includes/script.php'); ?>
<?php include('includes/footer.php'); ?>