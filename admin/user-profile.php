<?php
session_start();
$page_title = "Voice Chat | Users";
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
          <?php
                if(isset($_GET['user_id']))
                {
                    $user_id = $_GET['user_id'];
                    $query = "SELECT * FROM users WHERE id='$user_id' LIMIT 1 ";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                        }
                    }
                }
                            
                            ?>
            <h1>Profile - <?php echo $row['full_name'];?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
            
          <div class="col-md-3">
            <tbody>


           
          <?php
                if(isset($_GET['user_id']))
                {
                    $user_id = $_GET['user_id'];
                    $query = "SELECT * FROM users INNER JOIN posts ON users.uid = posts.publisher_uid WHERE users.id='$user_id' LIMIT 5 ";
              //      $query = "SELECT a.id, b.id, b.publisher_uid, b.text, a.full_name, a.short_digital_id, a.uid, b.datetime, b.topic, a.profile_pic, a.profile_cover, a.crystals, a.gold, a.gender, a.date_of_birth, a.country, a.join_date, a.current_premium_subscription, a.current_vip_subscription, a.bio, b.datetime, b.text, a.level FROM users AS a INNER JOIN posts AS b ON a.id = b.id WHERE a.id='$user_id' LIMIT 1 ";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                        }
                    
                 }
                             }
                            ?>

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="../images/<?php echo $row['profile_pic']; ?>" width="120" height="120"  alt="User profile picture ">
                </div>

                <h3 class="profile-username text-center"><?php echo $row['full_name']; ?></h3>

                <p class="text-muted text-center"><?php echo $row['gender']; ?></p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>UID</b> <a class="float-right"><?php echo $row['uid']; ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Display ID</b> <a class="float-right"><?php echo $row['short_digital_id']; ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Level</b> <a class="float-right"><?php echo $row['level']; ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Gold</b> <a class="float-right"><?php echo $row['gold']; ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Crystals</b> <a class="float-right"><?php echo $row['crystals']; ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>VIP</b> <a class="float-right">VIP Level <?php echo $row['current_vip_subscription']; ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Premium</b> <a class="float-right">Premium Level <?php echo $row['current_premium_subscription']; ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Room ID</b> <a class="float-right">
                    <?php
                    if(isset($_GET['user_id']))
                {
                    $user_id = $_GET['user_id'];
                    $query = "SELECT a.id, b.creator_uid, a.uid, a.bio, a.country, b.title, a.join_date, a.date_of_birth, b.creator_uid, b.short_digital_id, b.title, b.description, a.full_name, b.short_digital_id, a.profile_cover, a.crystals, a.gold, a.gender, b.image, a.level FROM users AS a INNER JOIN rooms AS b ON a.uid = b.creator_uid WHERE a.id='$user_id' ";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                        
                    
                 
                             
                             echo $row['short_digital_id'];?>

                        <?php
                        }
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
                             
                            </a>
                    </li>
                  <li class="list-group-item">
                    <b>Room Name</b> <a class="float-right">

                    <?php
                    if(isset($_GET['user_id']))
                {
                    $user_id = $_GET['user_id'];
                    $query = "SELECT a.id, b.creator_uid, a.uid, a.bio, a.country, b.title, a.join_date, a.date_of_birth, b.creator_uid, b.short_digital_id, b.title, b.description, a.full_name, b.short_digital_id, a.profile_cover, a.crystals, a.gold, a.gender, b.image, a.level FROM users AS a INNER JOIN rooms AS b ON a.uid = b.creator_uid WHERE a.id='$user_id' ";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                        
                    
                 
                             
                             echo $row['title'];     ?>

                        <?php
                        }
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

                    </a>
                    </li>


                </ul>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> BIO</strong>

                <p class="text-muted">
                <?php echo $row['bio']; ?>
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Country</strong>

                <p class="text-muted"><?php echo $row['country']; ?></p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Join Date</strong>

                <p class="text-muted">
                  <span class="tag tag-danger"><?php echo $row['join_date']; ?></span>
                </p>

                <hr>

                <strong><i class="far fa-file-alt mr-1"></i> Birthday</strong>

                <p class="text-muted"><?php echo $row['date_of_birth']; ?></p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Account Details</a></li>
                </ul>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="settings">

                  <div class="tab-pane" id="settings">
                    <form action="codeusers.php" method="POST"> 

                                        <?php
                if(isset($_GET['user_id']))
                {
                    $user_id = $_GET['user_id'];
                    $query = "SELECT * FROM users WHERE id='$user_id' LIMIT 1 ";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
    
                            ?>
                             <input type="hidden" name="user_id" value="<?php echo $row['id'] ?>">
                        <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                        <input type="text" name="full_name" value="<?php echo $row['full_name'] ?>" class="form-control" placeholder="Full Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Display ID</label>
                        <div class="col-sm-10">
                        <input type="text" name="short_digital_id" value="<?php echo $row['short_digital_id'] ?>" class="form-control" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Gold</label>
                        <div class="col-sm-10">
                        <input type="text" name="gold" value="<?php echo $row['gold'] ?>" class="form-control" placeholder="Gold">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Crystals</label>
                        <div class="col-sm-10">
                        <input type="text" name="crystals" value="<?php echo $row['crystals'] ?>" class="form-control" placeholder="Crystal">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">BIO</label>
                        <div class="col-sm-10">
                        <input type="text" name="bio" value="<?php echo $row['bio'] ?>" class="form-control" placeholder="BIO">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">VIP Level</label>
                        <select name="current_vip_subscription" class="col-sm-2 form-control" value=" <?php echo $row['current_vip_subscription'] ?>">
                       <option value="0" <?php if($row["current_vip_subscription"]=="0"){echo "selected";} ?>>NO VIP</option>
                       <option value="1" <?php if($row["current_vip_subscription"]=="1"){echo "selected";} ?>>VIP 1</option>
                       <option value="2" <?php if($row["current_vip_subscription"]=="2"){echo "selected";} ?>>VIP 2</option>
                       <option value="3" <?php if($row["current_vip_subscription"]=="3"){echo "selected";} ?>>VIP 3</option>
                       <option value="4" <?php if($row["current_vip_subscription"]=="4"){echo "selected";} ?>>VIP 4</option>
                       <option value="5" <?php if($row["current_vip_subscription"]=="5"){echo "selected";} ?>>VIP 5</option>
                       </select>
                      </div>
                      </div>
                      <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Gender</label>
                       <select name="gender" id="" class="col-sm-2 col-form-label">
                       <option value="">Select</option>
                       <option value="MALE" <?php if($row["gender"]=="MALE"){echo "selected";} ?>>MALE</option>
                       <option value="FEMALE" <?php if($row["gender"]=="FEMALE"){echo "selected";} ?>>FEMALE</option>
                </select>
                      </div>
                      </div>
                      <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Account Status</label>
                       <select name="account_status" id="" class="col-sm-2 col-form-label">
                       <option value="">Select</option>
                       <option value="" <?php if($row["account_status"]==""){echo "selected";} ?>>Active</option>
                       <option value="banned" <?php if($row["account_status"]=="banned"){echo "selected";} ?>>Banned</option>
                </select>
                      </div>

                      
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
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" name="updateUser" class="btn btn-info">Submit</button>
                        </div>
                      </div>
                    </form>
                    <?php
      if(isset($_POST['submit'])){
        if(!empty($_POST['gender'])) {
          $selected = $_POST['gender'];
          echo 'You have chosen: ' . $selected;
        } else {
          echo 'Please select the value.';
        }
      }
    ?>

                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    </section>
    <!-- /.content -->
                        
                        
                        

<?php include('includes/script.php'); ?>
