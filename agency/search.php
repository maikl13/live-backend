<?php
session_start();
include('includes/header.php');
include('config/dbcon.php');

$uid = $_SESSION['uid']; // قم بتغيير هذا بالطريقة التي تحمل بها معرف المستخدم

?>

<body class="pe-0">
    <!-- Preloader -->
    <div id="preloader">
      <div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
    </div>
    <!-- Internet Connection Status -->
    <!-- # This code for showing internet connection status -->
    <div class="internet-connection-status" id="internetStatus"></div>
    <!-- Header Area -->
    <div class="header-area" id="headerArea">
      <div class="container">
        <!-- Header Content -->
        <div class="header-content header-style-five position-relative d-flex align-items-center justify-content-between">
          <!-- Back Button -->
          <div class="back-button"><a href="#"><i class=""></i></a></div>
          <!-- Page Title -->
          <div class="page-heading">
            <h6 class="mb-0">Agency List</h6>
          </div>
          <!-- Navbar Toggler -->
          <div class="navbar--toggler" aria-controls="affanOffcanvas"><span class="d-block"></span><span class="d-block"></span><span class="d-block"></span></div>
        </div>
      </div>
    </div>


    <div class="page-content-wrapper py-3"> 
      <!-- Add New Contact -->
      <div class="container">
        <div class="card mb-2">
          <div class="card-body p-2">
            <div class="chat-search-box">
                <div class="input-group"><span class="input-group-text"><i class="bi bi-search"></i></span>
                  <input type="search" id="search" autocomplete="off" placeholder="Search ID Agency Here ..." class="form-control float-right">
                </div>
            </div>
          </div>
        </div>

        <h5>HERE TEXT</h5>

        <!-- Element Heading -->
        <div id="search-results" class="element-heading">
        </ul>
      </div>
    </div>



    <script>
document.getElementById('search').addEventListener('input', function() {
    var searchTerm = this.value;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'livesearch2.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById('search-results').innerHTML = xhr.responseText;
        }
    };
    
    xhr.send('searchTerm=' + searchTerm);
});
</script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

   <?php include('includes/script.php'); ?>

