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
<div class="modal fade" id="AddStickerModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add New Sticker</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="codestickers.php" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="form-group">
                <label for="">Sticker Name</label>
                <input type="text" name="title" class="form-control" placeholder="Sticker Name">
                <div class="form-group">
                <label for="">Sticker Type</label>
                <select name="section" class="form-control">
                <option value="1"> Premium </option>
                <option value="2"> VIP 2 </option>
                <option value="3"> Free </option>
                <option value="4"> Free </option>
                </select>
              </div>
              </div>
              <div class="form-group">
                <label for="">Sticker Image</label>
                <input type="file" name="image" class="form-control" required>
              </div>
              </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="addSticker" class="btn btn-primary">Add Sticker</button>
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
              <h4 class="modal-title">Delete Sticker</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="codestickers.php" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                <input type="hidden" name="delete_id" class="delete_sticker_id">
                <p>
                    Are your sure. you want delete this Data?
                </p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="DeleteStickerbtn" class="btn btn-danger">Yes, Delete !</button>
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
            <h1 class="m-0">Stickers List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Stickers List</li>
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
                <h3 class="card-title">Stickers List
                </h3>
                <a href="#" data-toggle="modal" data-target="#AddStickerModal" class="btn btn-primary float-right"><i class="addicon"></i>  Add Sticker</a>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $query = "SELECT a.id as idsticker, b.id, a.image, a.title as stickername, a.section, b.icon as stickericon, a.section FROM stickers AS a INNER JOIN stickers_sections AS b ON a.section = b.id WHERE a.id ORDER BY idsticker DESC;";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                          ?>
                  <tr>
                    <td><?php echo $row['idsticker']; ?></td>
                    <td><img src="../images/<?php echo $row['image']; ?>" width="70" height="70" /></td>
                    <td><?php echo $row['stickername']; ?></td>
                    <td><img src="../images/<?php echo $row['stickericon']; ?>" width="70" height="70" /></td>

                    <td>
                    <a href="stickers-edit.php?sticker_id=<?php echo $row['idsticker']; ?>" class="btn btn-info"><i class="editicon"></i>  Edit</a>
                    <button type="button" value="<?php echo $row['idsticker']; ?>" class="btn btn-danger deletebtn"><i class="deleteicon"></i>  Delete</a>
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

            var sticker_id = $(this).val();
            //console.log(sticker_id);
            $('.delete_sticker_id').val(sticker_id);
            $('#DeletModal').modal('show');
             
        });
    });
</script>

<?php include('includes/footer.php'); ?>