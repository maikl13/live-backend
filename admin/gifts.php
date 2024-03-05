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


<!-- Admins Modal -->
<div class="modal fade" id="AddGiftModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add New Gift</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="codegift.php" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="form-group">
                <label for="">Gift Name</label>
                <input type="text" name="title" class="form-control" placeholder="Gift Name">
                <div class="form-group">
                <label for="">Gift Category</label>
                <select name="section" class="form-control">
                <option value="0"> Hot </option>
                <option value="1"> Flags </option>
                <option value="2"> Member </option>
                <option value="3"> Premium </option>
                <option value="4"> VIP </option>
                </select>
              </div>
              <div class="form-group">
                <label for="">Price Type</label>
                <select name="currency_type" class="form-control">
                <option value="GOLD"> GOLD </option>
                <option value="CRYSTAL"> CRYSTAL </option>
                </select>
              </div>
              <div class="form-group">
                <label for="">Gift Price</label>
                    <input type="text" name="value" class="form-control" placeholder="Price">
              </div>
              <div class="form-group">
                <label for="">Gift Level</label>
                    <input type="text" name="level" class="form-control" placeholder="Level">
              </div>
            </div>
              <div class="form-group">
                <label for="">Gift Icon</label>
                <input type="file" name="icon" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="">Gift File ( Select GIF OR SVGA )</label>
                <input type="file" name="image" class="form-control" placeholder="image">
              </div>
              </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="addGift" class="btn btn-primary">Add Gift</button>
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
              <h4 class="modal-title">Delete Gift</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="codegift.php" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                <input type="hidden" name="delete_id" class="delete_gift_id">
                <p>
                    Are your sure. you want delete this Data?
                </p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="DeleteGiftbtn" class="btn btn-danger">Yes, Delete !</button>
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
            <h1 class="m-0">Gifts List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Gifts List</li>
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
                <h3 class="card-title">Gifts List
                </h3>
                <a href="#" data-toggle="modal" data-target="#AddGiftModal" class="btn btn-primary float-right"><i class="addicon"></i>  Add Gift</a>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Icon</th>
                    <th>Gift Effect</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>level</th>
                    <th>Price Type</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $query = "SELECT a.id as idgift, b.id, a.value, a.title as giftname, a.image, a.icon, a.section, b.title as giftcategory, a.currency_type, a.level FROM gifts AS a INNER JOIN sections_of_gifts AS b ON a.section = b.id WHERE a.id ORDER BY idgift DESC;";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                          ?>
                  <tr>
                    <td><?php echo $row['idgift']; ?></td>
                    <td><img src="../images/<?php echo $row['icon']; ?>" width="70" height="70" /></td>
                    <td><img src="../images/<?php echo $row['image']; ?>" width="70" height="70" /></td>
                    <td><?php echo $row['giftname']; ?></td>
                    <td><?php echo $row['giftcategory']; ?></td>
                    <td><?php echo $row['value']; ?></td>
                    <td><?php echo $row['level']; ?></td>
                    <td><?php echo $row['currency_type']; ?></td>

                    <td>
                    <a href="gifts-edit.php?gift_id=<?php echo $row['idgift']; ?>" class="btn btn-info"><i class="editicon"></i>  Edit</a>
                    <button type="button" value="<?php echo $row['idgift']; ?>" class="btn btn-danger deletebtn"><i class="deleteicon"></i>  Delete</a>
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

            var gift_id = $(this).val();
            //console.log(gift_id);
            $('.delete_gift_id').val(gift_id);
            $('#DeletModal').modal('show');
             
        });
    });
</script>

<?php include('includes/footer.php'); ?>