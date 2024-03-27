
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
                            
                         
            <?php echo $row['sitename'];?> Agent

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
            if(isset($_SESSION['auth_agentcoins']))
            {
              echo $_SESSION['auth_useragent']['agent_name']; 
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
          <li class="nav-item">
            <a href="transactions.php" class="nav-link">
              <i class="users-solid nav-icon"></i>
              <span class="right badge rounded-pill bg-success">
              <?php
                  require 'config/dbcon.php';
                  $agent_id = $_SESSION['auth_useragent']['agent_id'];
                  $query = "SELECT * FROM agent_coins_transactions WHERE agent_id='$agent_id'";
                  $query_run = mysqli_query($con, $query);

                  $row = mysqli_num_rows($query_run);

                  echo ''.$row.' ';

                  ?>
                  </span>

              <p>
              Transactions
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="transactions.php" class="nav-link">
                  <i class="users-solid nav-icon"></i>
                  <span class="right badge rounded-pill bg-success">
                  <?php
                  require 'config/dbcon.php';
                  $agent_id = $_SESSION['auth_useragent']['agent_id'];
                  $query = "SELECT * FROM agent_coins_transactions WHERE agent_id='$agent_id'";
                  $query_run = mysqli_query($con, $query);

                  $row = mysqli_num_rows($query_run);

                  echo ''.$row.' ';

                  ?>
                  </span>
                  <p>All Transactions</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="new-transaction.php" class="nav-link">
                  <i class="vip nav-icon"></i>
                  <p>New Transaction</p>
                </a>
              </li>
          </ul>
            <li class="nav-header">Account Settings</li>
          <li class="nav-item">
            <a href="update-profile.php" class="nav-link">
              <i class="fa-solid fa-user-tie nav-icon"></i>
              <p>
              Profile Settings
              </p>
            </a>
          </li>
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
