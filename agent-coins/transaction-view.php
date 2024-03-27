<?php
session_start();
include('includes/header.php');
include('authentication.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('config/dbcon.php');

if(isset($_SESSION['auth_agentcoins']))
{
  echo $_SESSION['auth_useragent']['agent_name']; 
}

$auth_agentcoins = $_SESSION['auth_agentcoins'];

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Invoice #INV-
            <?php
                if(isset($_GET['transaction_id']))
                {
                    $auth_useragent = $_SESSION['auth_useragent']['agent_id'];
                    $transaction_id = $_GET['transaction_id'];
                    $query = "SELECT * FROM agent_coins_transactions WHERE order_id='$transaction_id' AND agent_id='$auth_useragent' LIMIT  1 ";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                            ?>
    
            <?php echo $row['order_id'] ?></h1>

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
                    $auth_useragent = $_SESSION['auth_useragent']['agent_id'];
                    $transaction_id = $_GET['transaction_id'];
                    $query = "SELECT * FROM agent_coins_transactions WHERE order_id='$transaction_id' AND agent_id='$auth_useragent' LIMIT  1 ";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                            ?>
    
            <?php echo $row['order_id'] ?></h1>

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
                  $auth_useragent = $_SESSION['auth_useragent']['agent_id'];
                  $transaction_id = $_GET['transaction_id'];
                  $query = "SELECT * FROM agent_coins_transactions WHERE order_id='$transaction_id' AND agent_id='$auth_useragent' LIMIT 1 ";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                             echo $row['datetime'];?>

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
                  From
                  <?php
                if(isset($_GET['transaction_id']))
                {
                    $auth_useragent = $_SESSION['auth_useragent']['agent_id'];
                    $auth_useragent2 = $_SESSION['auth_useragent']['agent_email'];
                    $transaction_id = $_GET['transaction_id'];
                  $query = "SELECT * FROM agent_coins_transactions WHERE order_id='$transaction_id' AND agent_id='$auth_useragent' LIMIT 1 ";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                            ?>
                             

                  <address>
                    <strong><?php echo $row['agent_name'] ?></strong>
                    <br>
                    Account ID : <?php echo $row['agent_id'] ?>
                    <br>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  To
                  <address>
                    <strong><?php echo $row['user_fullname'] ?></strong>
                    <br>
                    Account ID : <?php echo $row['short_digital_id'] ?>
                    <br>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Invoice #INV<?php echo $row['order_id'] ?> </b><br>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                  <thead>
                  <tr>
                    <th>Invoice</th>
                    <th>Account ID</th>
                    <th>Account Name</th>
                    <th>Credit(Golds)</th>
                    <th>Created By</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td>#INV-<?php echo $row['order_id']; ?></td>
                    <td><?php echo $row['short_digital_id']; ?></td>
                    <td><?php echo $row['user_fullname']; ?></td>
                    <td><?php echo $row['golds']; ?></td>
                    <td><?php echo $row['agent_name']; ?></td>

                  </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                  <p class="lead">Notes:</p>

                  <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                  <?php echo $row['notes'] ?>
                  </p>
                </div>
                <!-- /.col -->
                <div class="col-6">
                  <p class="lead">Sending Datetime: <?php echo $row['datetime'] ?></p>

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th>Total Golds ( Credit ):</th>
                        <td> <?php echo $row['golds'] ?></td>
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
              <div class="row no-print">
                <div class="col-12">
                  <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                  <button type="button" class="btn btn-success float-right" style="margin-right: 5px;">
                    <i class="fas fa-download"></i> Generate PDF
                  </button>
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



</div>

<script>
 // window.addEventListener("load", window.print());
</script>

<?php include('includes/script.php'); ?>
<?php include('includes/footer.php'); ?>