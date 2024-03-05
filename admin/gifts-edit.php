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
            <h1 class="m-0">Gift List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">EDIT Gift</li>
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
                <h3 class="card-title">EDIT Gift
                </h3>
                <a href="gifts.php" class="btn btn-danger float-right">Back</a>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                    <form action="codegift.php" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                <?php
                if(isset($_GET['gift_id']))
                {
                    $gift_id = $_GET['gift_id'];
                    $query = "SELECT * FROM gifts WHERE id='$gift_id' LIMIT 1 ";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                            ?>
                    <input type="hidden" name="gift_id" value="<?php echo $row['id'] ?>">
                <div class="form-group">
                <label for="">Gift Name</label>
                    <input type="text" name="title" value="<?php echo $row['title'] ?>" class="form-control" placeholder="Gift Name">
              </div>
              <div class="form-group">
                <label for="">Gift Type</label>
                <select name="section" class="form-control" value=" <?php echo $row['section'] ?>">
                <option value="0" <?php if($row["section"]=="0"){echo "selected";} ?>>Hot</option>
                <option value="1" <?php if($row["section"]=="1"){echo "selected";} ?>>Flags</option>
                <option value="2" <?php if($row["section"]=="2"){echo "selected";} ?>>Member</option>
                <option value="3" <?php if($row["section"]=="3"){echo "selected";} ?>>Premium</option>
                <option value="4" <?php if($row["section"]=="4"){echo "selected";} ?>>VIP</option>
                </select>
              </div>
              <div class="form-group">
                <label for="">Gift Price</label>
                    <input type="text" name="value" value="<?php echo $row['value'] ?>" class="form-control" placeholder="Email">
              </div>
              <div class="form-group">
                <label for="">Level</label>
                    <input type="text" name="level" value="<?php echo $row['level'] ?>" class="form-control" placeholder="Password">
              </div>
                <div class="form-group">
                <label for="">Price Type</label>
                <select name="currency_type" id="" class="form-control">
                    <option value="">Select</option>
                    <option value="GOLD" <?php if($row["currency_type"]=="GOLD"){echo "selected";} ?>>GOLD</option>
                    <option value="CRYSTAL" <?php if($row["currency_type"]=="CRYSTAL"){echo "selected";} ?>>CRYSTAL</option>
                </select>

              </div>
              <div class="col-md-8">   
              <div class="form-group">
                <label for="">Gift Image</label>
                <input type="hidden" name="old_image" value="<?php echo $row['image'] ?>">
                    <input type="file" name="image" class="form-control" placeholder="image"> 

              </div>
              <img src="../images/<?php echo $row['image']; ?>" width="100px" height="100px"  alt="Image">
              </div>
              <div class="col-md-8">   
              <div class="form-group">
                <label for="">Gift Icon</label>
                <input type="hidden" name="old_icon" value="<?php echo $row['icon'] ?>">
                    <input type="file" name="icon" class="form-control" placeholder="image"> 

              </div>
              <img src="../images/<?php echo $row['icon']; ?>" width="100px" height="100px"  alt="Image">


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
              <button type="submit" name="updateGift" class="btn btn-info">Update</button>
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