<?php
session_start();
include('includes/header.php');
include('config/dbcon.php');


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
    <div class="container">
        <div class="card mb-2">
            <div class="card-body p-2">
                <!-- Search Box -->
                <div class="chat-search-box">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="search" id="search" autocomplete="off" placeholder="Search ID Agency Here ..." class="form-control float-right">
                    </div>
                </div>
            </div>
        </div>



        <!-- Element Heading -->
        
        <div class="element-heading">
        <h6 class="ps-1">Agency List</h6>
        </div>
        <!-- Chat User List -->
        <ul class="ps-0 chat-user-list" id="agency-list">
        <?php

$sql = "SELECT * FROM agency";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // إذا كانت هناك بيانات متاحة، ابدأ عرضها
    while($row = $result->fetch_assoc()) {
        // استخراج بيانات الوكالة وعرضها داخل العنصر
        echo '<li class="p-3 chat-unread"><a class="d-flex" href="agency_details.php?id=' . $row['id'] . '">';
        echo '<div class="chat-user-thumbnail me-3 shadow"><img class="img-circle" src="../images/' . $row['image'] . '" alt=""><span class="active-status"></span></div>';
        echo '<div class="chat-user-info">';
        echo '<h6 class="text-truncate mb-0">' . $row["name"] . '</h6>';
        echo '<p class="text-truncate mb-0"><img class="img-circle" src="../images/' . $row['flag'] . '" width="28" height="28" alt=""></p>';
        echo '<div class="last-chat"></div>';
        echo '</div></a>';
        // زر الانضمام
        echo '<div><button class="btn btn-primary" type="submit">View</button></div>';
        echo '</li>';
    }
} else {
    echo "0 نتائج";
}

$conn->close();
?>

          <!-- Single Chat User -->
          <li class="p-3 chat-unread"><a class="d-flex" href="#">
                </div>
              </div></a>
          </li>
        </ul>
      </div>
    </div>


    <script>
document.getElementById('search').addEventListener('input', function() {
    var searchQuery = this.value.trim();
    if (searchQuery.length > 0) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'livedatasearch.php?q=' + encodeURIComponent(searchQuery), true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Clear previous search results
                    document.getElementById('agency-list').innerHTML = '';
                    // Insert search results into the agency list
                    document.getElementById('agency-list').insertAdjacentHTML('beforeend', xhr.responseText);
                } else {
                    console.error('Request failed: ' + xhr.status);
                }
            }
        };
        xhr.send();
    } else {
        // Clear search results if the search query is empty
        document.getElementById('agency-list').innerHTML = '';
    }
});
</script>






<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

   <?php include('includes/script.php'); ?>

