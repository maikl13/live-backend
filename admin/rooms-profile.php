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
                if(isset($_GET['room_id']))
                {
                    $room_id = $_GET['room_id'];
                    $query = "SELECT * FROM rooms WHERE id='$room_id' LIMIT 1 ";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                        }
                    }
                }
                            
                            ?>
            <h1>Room : <?php echo $row['title'];?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">
                <?php echo $row['title'];?>
              </li>
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
                if(isset($_GET['room_id']))
                {
                    $room_id = $_GET['room_id'];
                    $query = "SELECT * FROM rooms WHERE id='$room_id' LIMIT 1";
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
                       src="../images//<?php echo $row['image']; ?>" width="120" height="120" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?php echo $row['title']; ?></h3>

                <p class="text-muted text-center"><?php echo $row['description']; ?></p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Display ID</b> <a class="float-right"><?php echo $row['short_digital_id']; ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Room Level</b> <a class="float-right"><?php echo $row['room_level']; ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Room Grade Level</b> <a class="float-right"><?php echo $row['room_grade']; ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Total Members</b> <a class="float-right"><?php echo $row['members_count']; ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Number of Mic</b> <a class="float-right"><?php echo $row['number_of_mics']; ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Room Password</b> <a class="float-right"><?php echo $row['enter_lock']; ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Membership Fee</b> <a class="float-right"><?php echo $row['membership_fee']; ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Created at</b> <a class="float-right"><?php echo $row['create_datetime']; ?></a>
                    </li>

                </ul>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Room Owner info</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Room Owner Name</strong>

                <p class="text-muted">
                <?php
                    if(isset($_GET['room_id']))
                {
                    $room_id = $_GET['room_id'];
                    $query = "SELECT a.id, b.id, b.short_digital_id, a.title, b.uid, a.creator_uid, b.full_name, a.description FROM rooms AS a INNER JOIN users AS b ON a.creator_uid = b.uid WHERE a.id='$room_id' ";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                        
                    
                 
                             
                             echo $row['full_name'];?>

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

                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Room Owner uid</strong>

                <p class="text-muted">

                <?php
                    if(isset($_GET['room_id']))
                {
                    $room_id = $_GET['room_id'];
                    $query = "SELECT a.id, b.id, b.short_digital_id, a.title, b.uid, a.creator_uid, b.full_name, a.description FROM rooms AS a INNER JOIN users AS b ON a.creator_uid = b.uid WHERE a.id='$room_id' ";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                        
                    
                 
                             
                             echo $row['uid'];?>

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

                </p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Room Owner Display ID</strong>

                <p class="text-muted">
                  <span class="tag tag-danger">
                  <?php
                    if(isset($_GET['room_id']))
                {
                    $room_id = $_GET['room_id'];
                    $query = "SELECT a.id, b.id, b.short_digital_id, a.title, b.uid, a.creator_uid, b.full_name, a.description FROM rooms AS a INNER JOIN users AS b ON a.creator_uid = b.uid WHERE a.id='$room_id' ";
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


                  </span>
                </p>

                <hr>

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
                <li class="nav-item"><a class="nav-link active" href="#memberslist" data-toggle="tab">Members List</a></li>
                <li class="nav-item"><a class="nav-link" href="#banlist" data-toggle="tab">Ban List</a></li>
                <li class="nav-item"><a class="nav-link" href="#momentslist" data-toggle="tab">Moments</a></li>
                <li class="nav-item"><a class="nav-link" href="#actionrecord" data-toggle="tab">Action Record</a></li>
                <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Room Settings</a></li>
                </ul>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="memberslist">
                    <div class="post">
              <!-- /.card-header -->
              <form action="codebanuser.php" method="POST" enctype="multipart/form-data">
              <div class="col-12 table-responsive">
                <table id="example1" class="table">
                  <thead>
                  <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Level</th>
                    <th>Premium LVL</th>
                    <th>VIP LVL</th>
                    <th>Role</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                if(isset($_GET['room_id']))
                {
                  $room_id = $_GET['room_id'];
                  $query = "SELECT  
                    users.id,
                    users.uid,
                    users.full_name,
                    users.profile_pic,
                    users.level,
                    users.gender,
                    users.current_premium_subscription,
                    users.current_vip_subscription,
                     `user_rooms`.`is_joined`  ,
                     CASE WHEN CURDATE() =  DATE_FORMAT(user_rooms.enter_datetime, '%Y-%m-%d')
                     THEN 1 ELSE 0 END as active_today,
                    EXISTS (SELECT rooms_admins.id  FROM `rooms_admins` WHERE `rooms_admins`.`user`=`users`.`uid` AND `rooms_admins`.`room`='$room_id') AS is_admin
                    FROM `users`   
                    INNER JOIN `user_rooms` ON  `user_rooms`.`user_uid`=`users`.`uid` 
                     
                     
                    WHERE  `user_rooms`.`is_joined`  =1  AND `user_rooms`.`room_id`='$room_id'
                    GROUP BY users.id ORDER BY is_admin = 0 AND user_rooms.enter_datetime";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                            ?>
                  <tr>
                    <td><img src="../images/<?php echo $row['profile_pic']; ?>" width="70" height="70" /></td>
                    <td><?php echo $row['uid']; ?>(<?php echo $row['full_name']; ?>)</td>
                    <td><?php echo $row['gender']; ?></td>
                    <td><?php echo $row['level']; ?></td>
                    <td><?php echo $row['current_premium_subscription']; ?></td>
                    <td><?php echo $row['current_vip_subscription']; ?></td>
                    <td><?php if($row['is_admin']=="1")  echo "Admin"; else  echo "Member"; ?></td>
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
                }

                  ?>
                  </tbody>
                </table> 
            </div>
              </form>

                    </div>
                    <!-- /.post -->
                  </div>
                  
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="banlist">
                    <!-- The timeline -->

              <!-- /.card-header -->
              <form action="codebanuser.php" method="POST" enctype="multipart/form-data">
              <div class="col-12 table-responsive">
              <div class="post">
                    <div class="post">
                <table id="example3" class="table">
                  <thead>
                  <tr>
                    <th>User</th>
                    <th>Ban By(Admin)</th>
                    <th>Datetime</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                if(isset($_GET['room_id']))
                {
                  $room_id = $_GET['room_id'];
                  $query = "SELECT  `rooms_forbidden_users`.*,
 
                  forbidden_user.full_name as user_full_name,
                  forbidden_user.profile_pic as user_profile_pic,
                  forbidden_user.level as user_level,
                  forbidden_user.short_digital_id as short_digital_id,
                  forbidden_user.current_premium_subscription,
                  forbidden_user.current_vip_subscription,
                  user_rooms.is_joined AS is_joined,
                  admin.full_name as admin_name
                  FROM `rooms_forbidden_users`
                  INNER JOIN `users` admin ON  admin.`uid`=`rooms_forbidden_users`.`admin`
                  INNER JOIN `users` forbidden_user ON  forbidden_user.`uid`=`rooms_forbidden_users`.`user`
                  INNER JOIN `user_rooms` on  forbidden_user.`uid`=`user_rooms`.`user_uid` AND `user_rooms`.room_id = `rooms_forbidden_users`.`room`
                  WHERE `rooms_forbidden_users`.`room`='$room_id'
                  GROUP BY rooms_forbidden_users.user";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                            ?>
                  <tr>
                    <td><?php echo $row['user']; ?>(<?php echo $row['user_full_name']; ?>)</td>
                    <td><?php echo $row['admin']; ?>(<?php echo $row['admin_name']; ?>)</td>
                    <td><?php echo $row['datetime']; ?></td>
                    <td>
                    <button type="button" value="<?php echo $row['id']; ?>" class="btn btn-danger deletebtn">UnBan</a>
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
                }

                  ?>
                  </tbody>
                </table> 
            </div>
              </form>
                      </div>
                    </div>
                  </div>

                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="momentslist">
                    <!-- The timeline -->

              <!-- /.card-header -->
              <form action="codebanuser.php" method="POST" enctype="multipart/form-data">
              <div class="col-12 table-responsive">
              <div class="post">
                    <div class="post">
                <table id="example5" class="table">
                  <thead>
                  <tr>
                    <th>User</th>
                    <th>action</th>
                    <th>Admin UID</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                if(isset($_GET['room_id']))
                {
                  $room_id = $_GET['room_id'];
                  $query = "SELECT  `action_records`.*,
                  `users`.`full_name`,`users`.`uid`,`users`.`profile_pic`,`users`.`gender` ,
                     `users`.`current_premium_subscription`,
                      `users`.`current_vip_subscription`
                  FROM `action_records` 
                  INNER JOIN `users`  ON `users`.`uid`= `action_records`.`user`
                  WHERE
                  `action_records`.`room`='$room_id' AND
                  `action_records`.`datetime` + INTERVAL 30 DAY >= NOW() ";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                            ?>
                  <tr>
                  <td><img src="../images/<?php echo $row['profile_pic']; ?>" width="70" height="70"/> <?php echo $row['user']; ?>(<?php echo $row['full_name']; ?>) </td>
                  <td><?php echo $row['action']; ?></td>
                  <td><?php echo $row['admin']; ?></td>
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
                }

                  ?>
                  </tbody>
                </table> 
            </div>
              </form>
                      </div>
                    </div>
                  </div>

                                                      <!-- /.tab-pane -->
                                                      <div class="tab-pane" id="actionrecord">
                    <!-- The timeline -->

              <!-- /.card-header -->
              <form action="codebanuser.php" method="POST" enctype="multipart/form-data">
              <div class="col-12 table-responsive">
              <div class="post">
                    <div class="post">
                <table id="example4" class="table">
                  <thead>
                  <tr>
                    <th>User</th>
                    <th>action</th>
                    <th>Admin UID</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                if(isset($_GET['room_id']))
                {
                  $room_id = $_GET['room_id'];
                  $query = "SELECT  `action_records`.*,
                  `users`.`full_name`,`users`.`uid`,`users`.`profile_pic`,`users`.`gender` ,
                     `users`.`current_premium_subscription`,
                      `users`.`current_vip_subscription`
                  FROM `action_records` 
                  INNER JOIN `users`  ON `users`.`uid`= `action_records`.`user`
                  WHERE
                  `action_records`.`room`='$room_id' AND
                  `action_records`.`datetime` + INTERVAL 30 DAY >= NOW() ";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                            ?>
                  <tr>
                  <td><img src="../images/<?php echo $row['profile_pic']; ?>" width="70" height="70"/> <?php echo $row['user']; ?>(<?php echo $row['full_name']; ?>) </td>
                  <td><?php echo $row['action']; ?></td>
                  <td><?php echo $row['admin']; ?></td>
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
                }

                  ?>
                  </tbody>
                </table> 
            </div>
              </form>
                      </div>
                    </div>
                  </div>



                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="settings">
                      <div class="form-group">
                    <form action="code_rooms.php" method="POST"> 

                                        <?php
                if(isset($_GET['room_id']))
                {
                    $room_id = $_GET['room_id'];
                    $query = "SELECT * FROM rooms WHERE id='$room_id' LIMIT 1 ";   
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
    
                            ?>
                             <input type="hidden" name="user_id" value="<?php echo $row['id'] ?>">
                        <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Room Name</label>
                        <div class="col-sm-10">
                        <input type="text" name="full_name" value="<?php echo $row['title'] ?>" class="form-control" placeholder="Room Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Display ID</label>
                        <div class="col-sm-10">
                        <input type="text" name="short_digital_id" value="<?php echo $row['short_digital_id'] ?>" class="form-control" placeholder="Display ID">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                        <input type="text" name="description" value="<?php echo $row['description'] ?>" class="form-control" placeholder="description">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Room Level</label>
                        <div class="col-sm-10">
                        <input type="text" name="room_level" value="<?php echo $row['room_level'] ?>" class="form-control" placeholder="room_level">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Membership Fee</label>
                        <div class="col-sm-10">
                        <input type="text" name="membership_fee" value="<?php echo $row['membership_fee'] ?>" class="form-control" placeholder="Membership Fee">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Room Password</label>
                        <div class="col-sm-10">
                        <input type="text" name="enter_lock" value="<?php echo $row['enter_lock'] ?>" class="form-control" placeholder="Room Password">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="" class="">Allow Guest To Join Room</label>
                        <div class="col-sm-10">
                        <input type="checkbox"  name="allow_guests_to_enter" <?php echo $row['allow_guests_to_enter'] =="1" ? 'checked':''; ?> >
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="" class="">Mic For Member Only</label>
                        <div class="col-sm-10">
                        <input type="checkbox"  name="allow_guests_to_enter" <?php echo $row['mic_for_members_only'] =="1" ? 'checked':''; ?> >
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="" class="">Allow Admin Manage Mic</label>
                        <div class="col-sm-10">
                        <input type="checkbox"  name="allow_guests_to_enter" <?php echo $row['allow_admins_to_lock_or_unlock_the_mic'] =="1" ? 'checked':''; ?> >
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="" class="">Allow Admin Manage Events</label>
                        <div class="col-sm-10">
                        <input type="checkbox"  name="allow_guests_to_enter" <?php echo $row['allow_admins_to_manage_events'] =="1" ? 'checked':''; ?> >
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
                          <button type="submit" name="updateRoom" class="btn btn-info">Submit</button>
                          </div>
                      </div>
                    </form>
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
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->                        

<?php include('includes/script.php'); ?>
<?php include('includes/footer.php'); ?>
