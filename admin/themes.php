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


<!-- Add Themes Modal -->
<div class="modal fade" id="AddAdminModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Add New Theme</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="themeaddcode.php" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
            <div class="form-group">
                <label for="">Theme Category</label>
                <?php
                  $category = "SELECT * FROM categories_of_themes";
                  $category_run = mysqli_query($con, $category);

                  if(mysqli_num_rows($category_run) > 0)
                  {
                      ?>
                <select name="category" required class="form-control">
                <option value="">-- Select Category --</option>
                <?php
                foreach($category_run as $categoryitem)
                {
                  ?>
                 <option value="<?= $categoryitem['id'] ?>"><?= $categoryitem['title'] ?></option>
                  <?php
                }
                ?>
                </select>

                      <?php
                  }
                  else
                  {
                    ?>
                    <h5>No Category</h5>
                    <?php
                  }
                ?>
              </div>
              <div class="form-group">
                <label for="">Theme Name</label>
                    <input type="text" name="title" class="form-control" placeholder="Name">
              </div>
              <div class="form-group">
                <label for="">Days</label>
                <select name="days" class="form-control">
                <option value="7"> 7 days </option>
                <option value="30"> 30 Days </option>
                <option value="90"> 90 Days </option>
                <option value="365"> 365 Days </option>
                </select>
              </div>
              <div class="form-group">
                <label for="">Price</label>
                    <input type="text" name="golds" class="form-control" placeholder="Price">
              </div>
              <div class="form-group">
                <label for="">Theme Image</label>
                    <input type="file" name="image" class="form-control" placeholder="image">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="addTheme" class="btn btn-primary">Add Theme</button>
      </div>
    </form>

    </div>
  </div>
</div>

<!-- Delete Theme -->
<div class="modal fade" id="DeletModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Delete Theme</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="themeaddcode.php" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                <input type="hidden" name="delete_id" class="delete_theme_id">
                <p>
                    Are your sure. you want delete this Data?
                </p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="DeleteThemebtn" class="btn btn-danger">Yes, Delete !</button>
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
            <h1 class="m-0">Store | Themes</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Themes List</li>
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
                <h3 class="card-title">Themes List
                </h3>
                <a href="#" data-toggle="modal" data-target="#AddAdminModal" class="btn btn-primary float-right">Add Theme</a>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Theme Name</th>
                    <th>Theme Category</th>
                    <th>Price</th>
                    <th>Days</th>
                    <th>datetime</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $query = "SELECT a.id as theme_id, b.id as categorythemeid, a.title as themename, a.image, a.golds, b.title as themecategory, a.category, a.datetime, a.days FROM themes AS a INNER JOIN categories_of_themes AS b ON a.category = b.id WHERE a.category";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                          ?>
                  <tr>
                    <td><?php echo $row['theme_id']; ?></td>
                    <td><img src="../images/<?php echo $row['image']; ?>" width="70" height="70" /></td>
                    <td><?php echo $row['themename']; ?></td>
                    <td><?php echo $row['themecategory']; ?></td>
                    <td><?php echo $row['golds']; ?></td>
                    <td><?php echo $row['days']; ?></td>
                    <td><?php echo $row['datetime']; ?></td>
                    <td>
                    <a href="theme-edit.php?theme_id=<?php echo $row['theme_id']; ?>" class="btn btn-info"><i class="editicon"></i>  Edit</a>
                    <button type="button" value="<?php echo $row['theme_id']; ?>" class="btn btn-danger deletebtn"><i class="deleteicon"></i> Delete</a>
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

            var theme_id = $(this).val();
            //console.log(theme_id);
            $('.delete_theme_id').val(theme_id);
            $('#DeletModal').modal('show');
             
        });
    });
</script>

<?php include('includes/footer.php'); ?>