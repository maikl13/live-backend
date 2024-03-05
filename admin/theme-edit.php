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
            <h1 class="m-0">Theme List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">EDIT Theme</li>
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
                <h3 class="card-title">EDIT Theme
                </h3>
                <a href="themes.php" class="btn btn-danger float-right">Back</a>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                    <form action="themeaddcode.php" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                <?php
                if(isset($_GET['theme_id']))
                {
                    $theme_id = $_GET['theme_id'];
                    $query = "SELECT * FROM themes WHERE id='$theme_id' LIMIT 1 ";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                            ?>
                    <input type="hidden" name="theme_id" value="<?php echo $row['id'] ?>">
                <div class="form-group">
                <label for="">Theme Name</label>
                    <input type="text" name="title" value="<?php echo $row['title'] ?>" class="form-control" placeholder="Theme Name">
              </div>
              <div class="form-group">
                <label for="">Theme Days</label>
                <select name="days" class="form-control" value=" <?php echo $row['days'] ?>">
                <option value="7" <?php if($row["days"]=="7"){echo "selected";} ?>>7 Days</option>
                <option value="30" <?php if($row["days"]=="30"){echo "selected";} ?>>30 Days</option>
                <option value="90" <?php if($row["days"]=="90"){echo "selected";} ?>>90 Days</option>
                <option value="365" <?php if($row["days"]=="365"){echo "selected";} ?>>365 Days</option>
                </select>
              </div>
              <div class="form-group">
                <label for="">Theme Price</label>
                    <input type="text" name="golds" value="<?php echo $row['golds'] ?>" class="form-control" placeholder="Price">
              </div>
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
                 <option value="<?= $categoryitem['id'] ?>" <?= $categoryitem['id'] == $row['category'] ? 'selected':'' ?> >
                 <?= $categoryitem['title'] ?>
                </option>
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
              <div class="col-md-8">   
              <div class="form-group">
                <label for="">Theme Image</label>
                <input type="hidden" name="old_image" value="<?php echo $row['image'] ?>">
                    <input type="file" name="image" class="form-control" placeholder="image"> 

              </div>
              <img src="../images/<?php echo $row['image']; ?>" width="100px" height="100px"  alt="Image">


                            <?php
                        }
                    }
                    else
                    {
                        echo "<h4> No Record Found </h4>";
                    }
                }
                ?>
            </div>
            <div class="modal-footer">
              <button type="submit" name="updateTheme" class="btn btn-info">Update</button>
      </div>
    </form>

                    </div>
                </div>
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