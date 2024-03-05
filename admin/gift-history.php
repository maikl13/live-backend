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
            <h1 class="m-0">Gift History</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Gift History</li>
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
                if(isset($_SESSION['status']))
                {
                    echo"<h4>".$_SESSION['status']."</h4>";
                    unset($_SESSION['status']);
                }
                ?>
                        </div>
                        </div>
                        </div>
    <div class="card">
              <div class="card-header">
                <h3 class="card-title">Gift History
                </h3>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sender Name</th>
                    <th>Sender Uid</th>
                    <th>Receiver Uid</th>
                    <th>Room ID</th>
                    <th>Gift Name</th>
                    <th>count</th>
                    <th>Send at</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $query = "SELECT * FROM users_gifts INNER JOIN users ON users_gifts.sender_uid = users.uid INNER JOIN rooms ON users_gifts.room_id = rooms.id INNER JOIN gifts ON users_gifts.gift_id = gifts.title ORDER BY send_datetime DESC;";
               //    $query = "SELECT * FROM posts INNER JOIN users ON users_gifts.sender_uid = users.uid";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                          ?>
                  <tr>
                    <td><?php echo $row['full_name']; ?></td>
                    <td><?php echo $row['sender_uid']; ?></td>
                    <td><?php echo $row['receiver_uid']; ?></td>
                    <td><?php echo $row['room_id']; ?></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['count']; ?></td>
                    <td><?php echo $row['send_datetime']; ?></td>
                    <td>
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