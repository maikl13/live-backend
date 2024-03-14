
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-blue elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">

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

      </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">
            <?php
            if(isset($_SESSION['auth']))
            {
              echo $_SESSION['auth_user']['user_name']; 
            }
            else
            {
              echo"Not Logged in";
            }           
             ?>
          </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-header">Menu</li>
          <li class="nav-item">
            <a href="index.php" class="nav-link">
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa-solid fa-bug-slash nav-icon"></i>
              <p>
                Banners
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="home-banners.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Homepage Banners</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="moments-banners.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Moments Banners</p>
                  </a>
            </li>
            </ul>
          <li class="nav-item">
            <a href="users.php" class="nav-link">
              <i class="users-solid nav-icon"></i>
              <span class="right badge rounded-pill bg-success">
                  <?php
                  require 'config/dbcon.php';
                  $query = "SELECT id FROM users ORDER BY id";
                  $query_run = mysqli_query($con, $query);

                  $row = mysqli_num_rows($query_run);

                  echo ' '.$row.' ';

                  ?>

                  </span>

              <p>
                Users
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="users.php" class="nav-link">
                  <i class="users-solid nav-icon"></i>
                  <span class="right badge rounded-pill bg-success">
                  <?php
                  require 'config/dbcon.php';
                  $query = "SELECT id FROM users ORDER BY id";
                  $query_run = mysqli_query($con, $query);

                  $row = mysqli_num_rows($query_run);

                  echo ' '.$row.' ';

                  ?>

                  </span>
                  <p>All Users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="users-vip.php" class="nav-link">
                  <i class="vip nav-icon"></i>
                  <span class="right badge rounded-pill bg-warning text-dark">
                  <?php
                  require 'config/dbcon.php';
                  $query = "SELECT id FROM users WHERE current_vip_subscription > 0 ORDER BY id";
                  $query_run = mysqli_query($con, $query);

                  $row = mysqli_num_rows($query_run);

                  echo ' '.$row.' ';

                  ?>

                  </span>
                  <p>VIP Users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="users-premium.php" class="nav-link">
                  <i class="premium nav-icon"></i>
                  <span class="right badge rounded-pill bg-info text-dark">
                  <?php
                  require 'config/dbcon.php';
                  $query = "SELECT id FROM users WHERE current_premium_subscription > 0 ORDER BY id";
                  $query_run = mysqli_query($con, $query);

                  $row = mysqli_num_rows($query_run);

                  echo ' '.$row.' ';

                  ?>

                  </span>
                  <p>Premium Users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="rebates.php" class="nav-link">
                  <i class="onlineusers nav-icon"></i>
                  <p>Rebates</p>
                  </a>
              </li>
            <li class="nav-item">
                <a href="users-banned.php" class="nav-link">
                  <i class="banusers nav-icon"></i>
                  <p>Banned Users</p>
                </a>
              </li>
            </ul>
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="people-roof-solid nav-icon"></i>
              <p>
                Rooms
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">
                <?php
                  require 'config/dbcon.php';
                  $query = "SELECT id FROM rooms ORDER BY id";
                  $query_run = mysqli_query($con, $query);

                  $row = mysqli_num_rows($query_run);

                  echo ' '.$row.' ';

                  ?>
                  
                </span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="rooms.php" class="nav-link">
                  <i class="people-roof-solid nav-icon"></i>
                  <span class="badge badge-info right">
                <?php
                  require 'config/dbcon.php';
                  $query = "SELECT id FROM rooms ORDER BY id";
                  $query_run = mysqli_query($con, $query);

                  $row = mysqli_num_rows($query_run);

                  echo ' '.$row.' ';

                  ?>
                  
                </span>
                  <p>Rooms List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="roomsupgradetype.php" class="nav-link">
                  <i class="upgraderooms nav-icon"></i>
                  <p>Rooms Upgrade Type</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="rooms-chat-ban.php" class="nav-link">
                  <i class="banusers nav-icon"></i>
                  <p>Rooms Ban Chat List</p>
                  </a>
            </li>
            <li class="nav-item">
                <a href="rooms-ban.php" class="nav-link">
                  <i class="banusers nav-icon"></i>
                  <p>Rooms Ban List</p>
                </a>
            </li>
            </ul>
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="gifts nav-icon"></i>
              <p>
                Gifts
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="gifts.php" class="nav-link">
                  <i class="gifts nav-icon"></i>
                  <p>Gift List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="gift-category.php" class="nav-link">
                  <i class="giftcate nav-icon"></i>
                  <p>Gift Category</p>
                </a>
                </li>
              <li class="nav-item">
                <a href="gift-history.php" class="nav-link">
                  <i class="history nav-icon"></i>
                  <p>Gift History</p>
                </a>
            </li>
            </ul>
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="stickersicon nav-icon"></i>
              <p>
                Sickers
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="stickers.php" class="nav-link">
                  <i class="stickersicon nav-icon"></i>
                  <p>Stickers List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="gift-category.php" class="nav-link">
                  <i class="stickercate nav-icon"></i>
                  <p>Stickers Category</p>
                </a>
                </li>
            </ul>
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="posticon nav-icon"></i>
              <p>
                Posts
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="posts.php" class="nav-link">
                  <i class="posticon nav-icon"></i>
                  <p>Posts List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="topics-posts.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Posts Topics</p>
                </a>
                </li>
              <li class="nav-item">
                <a href="gift-history.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Gift History</p>
                </a>
            </ul>
          </li>
          <li class="nav-item">
            <a href="hashtags.php" class="nav-link">
              <i class="fa-solid fa-hashtag nav-icon"></i>
              <p>
                Hashtags
                </p>
            </a>
            <li class="nav-header">Premium & VIP Management</li>
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa-solid fa-star nav-icon"></i>
              <p>
              Premium
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="premium-subscription.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Premium Manage</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="premium-privileges.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Premium Privileges</p>
                  </a>
            </li>
            </a>
              </li>
              <li class="nav-item">
                <a href="premium-logs.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Premium Logs</p>
                  </a>
            </li>
            </a>
              </li>
              <li class="nav-item">
                <a href="premium-themes.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Premium Themes</p>
                  </a>
            </li>
            </ul>
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa-solid fa-crown nav-icon"></i>
              <p>
                VIP
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="vip-subscriptions.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>VIP Subscriptions</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="vip-benefits.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>VIP Benefits</p>
                  </a>
            </li>
            </a>
              </li>
              <li class="nav-item">
                <a href="vip-logs.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>VIP Logs</p>
                  </a>
            </li>
            </a>
              </li>
              <li class="nav-item">
                <a href="vip-points-users.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>VIP Points Users</p>
                  </a>
            </li>
            </ul>
            </a>
            <li class="nav-header">Agency & Agents Coins</li>
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa-solid fa-star nav-icon"></i>
              <p>
              Agency
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="agency.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Agency List</p>
                </a>
            </ul>
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa-solid fa-crown nav-icon"></i>
              <p>
                Agent Coins
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="agent-coins.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Agent List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="hats-history.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Hats History</p>
                  </a>
            </li>
            </ul>
            </a>
            <li class="nav-header">Finance & Withdraw</li>
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa-solid fa-star nav-icon"></i>
              <p>
              Withdraw Users
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="withdraw-users-allrequest.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Request</p>
                </a>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="agency.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Completed</p>
                </a>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="agency.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pending</p>
                </a>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="agency.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Processing</p>
                </a>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="agency.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Failed</p>
                </a>
            </ul>
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa-solid fa-crown nav-icon"></i>
              <p>
              Withdraw Agency
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="agent-coins.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Agent List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="hats-history.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Hats History</p>
                  </a>
            </li>
            </ul>
            </a>
            <li class="nav-header">Accessories Users & Rooms</li>
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa-solid fa-synagogue nav-icon"></i>
              <p>
                Themes
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="themes.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Themes</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="themes-category.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Category Themes</p>
                  </a>
            </li>
            </a>
              </li>
              <li class="nav-item">
                <a href="themes-custom.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Custom Themes</p>
                  </a>
            </li>
            </a>
              </li>
              <li class="nav-item">
                <a href="themes-logs.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Themes Logs</p>
                  </a>
            </li>
            </ul>
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa-solid fa-hat-cowboy nav-icon"></i>
              <p>
                Hats
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="hats.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Hats</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="hats-logs.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Hats Logs</p>
                  </a>
            </li>
            </ul>
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa-regular fa-message nav-icon"></i>
              <p>
                Chat Box
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="chatbox.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>ChatBox</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="chatbox-logs.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>ChatBox Logs</p>
                  </a>
            </li>
            </ul>
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa-solid fa-car-burst nav-icon"></i>
              <p>
                Vehicles
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="vehicles.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Vehicles</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="vehicles-logs.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Vehicles Logs</p>
                  </a>
            </li>
            </ul>
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa-solid fa-address-card nav-icon"></i>
              <p>
              Special ID
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="special_ids_sections.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Special ID Category</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="special_ids_sub_sections.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Special ID Sub Category</p>
                  </a>
            </li>
            <li class="nav-item">
                <a href="users_unique_ids.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Users Special ID</p>
                  </a>
            </li>
            </li>
            <li class="nav-item">
                <a href="rooms_unique_ids.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Rooms Special ID</p>
                  </a>
            </li>
            </ul>
            <li class="nav-header">Reports & Feedback</li>
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa-solid fa-bug nav-icon"></i>
              <p>
                Feedback
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="feadback.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Feedback</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="themes-category.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Themes Category</p>
                  </a>
            </li>
            </ul>
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa-solid fa-bug-slash nav-icon"></i>
              <p>
                Reports Users
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="reports.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Reports</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="reports-category.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Reports Category</p>
                  </a>
            </li>
              <li class="nav-item">
                <a href="reports-subcategory.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Reports Sub Category</p>
                  </a>
            </li>
            </ul>
            <li class="nav-header">System Settings</li>
          <li class="nav-item">
            <a href="countries.php" class="nav-link">
              <i class="fa-solid fa-user-tie nav-icon"></i>
              <p>
              Country List
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="admins.php" class="nav-link">
              <i class="fa-solid fa-user-tie nav-icon"></i>
              <p>
              Admins
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="settings.php" class="nav-link">
              <i class="fa-solid fa-gear nav-icon"></i>
              <p>
                Settings
              </p>
            </a>
          </li>

          <li class="nav-item">
              <p>
              <form action="code.php" method="POST">
              <button type="submit" name="logout_btn" class="btn btn-danger btn-lg btn-block" >Logout</button>
              </form>
              </p>
            </a>
          </li>
           </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <style>
      .sidebar-dark-blue{
        background: #39425e !important;
      }
 </style>
