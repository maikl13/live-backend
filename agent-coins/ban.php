<?php
session_start();

?>

<h1>
    your account is banned
</h1>

<li class="nav-item">
              <p>
              <form action="code.php" method="POST">
              <button type="submit" name="logout_btn" class="btn btn-danger btn-lg btn-block" >Logout</button>
              </form>
              </p>
            </a>
          </li>

<?php
if(isset($_SESSION['status']))
{
    echo $_SESSION['status'];
    unset($_SESSION['status']);
}
?>