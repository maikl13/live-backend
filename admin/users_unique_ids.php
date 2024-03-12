<?php
session_start();
$page_title = "Voice Chat | Gifts";
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
            <h1 class="m-0">Users Special ID List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"> Users Special ID List</li>
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
                <h3 class="card-title"> Users Special ID List
                </h3>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>User</th>
                    <th>Special ID</th>
                    <th>Special ID Type</th>
                    <th>Datetime</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $query = "SELECT a.id as idspe, b.id as iduser, a.user, a.unique_id, a.datetime, b.uid, b.short_digital_id, b.full_name, b.profile_pic, b.gender, a.for_room FROM users_unique_ids AS a INNER JOIN users AS b ON a.user = b.uid WHERE 0 = a.for_room";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                          ?>
                  <tr>
                    <td><?php echo $row['idspe']; ?></td>
                    <td><img src="../images/<?php echo $row['profile_pic']; ?>" width="70" height="70" /></td>
                    <td><?php echo $row['user']; ?>(<?php echo $row['full_name']; ?>)</td>
                    <td><?php echo $row['unique_id']; ?></td>
                    <td><?php if($row['for_room']=="0")  echo "Account"; else  echo "Member"; ?></td>
                    <td><?php echo $row['datetime']; ?></td>
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

            var sticker_id = $(this).val();
            //console.log(sticker_id);
            $('.delete_sticker_id').val(sticker_id);
            $('#DeletModal').modal('show');
             
        });
    });
</script>

<?php include('includes/footer.php'); ?>