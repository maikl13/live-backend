<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="mpay" />
  <meta name="keywords" content="mpay" />
  <meta name="author" content="mpay" />
  <link rel="manifest" href="manifest.json" />
  <link rel="icon" href="assets/images/logo/favicon.png" type="image/x-icon" />
  <title>Members Income</title>
  <link rel="apple-touch-icon" href="assets/images/logo/favicon.png" />
  <meta name="theme-color" content="#122636" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black" />
  <meta name="apple-mobile-web-app-title" content="mpay" />
  <meta name="msapplication-TileImage" content="assets/images/logo/favicon.png" />
  <meta name="msapplication-TileColor" content="#FFFFFF" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <!--Google font-->
  <link rel="preconnect" href="https://fonts.googleapis.com/" />
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&amp;display=swap" rel="stylesheet" />

  <!-- bootstrap css -->
  <link rel="stylesheet" id="rtl-link" type="text/css" href="assets/css/vendors/bootstrap.min.css" />

  <!-- swiper css -->
  <link rel="stylesheet" type="text/css" href="assets/css/vendors/swiper-bundle.min.css" />

  <!-- Theme css -->
  <link rel="stylesheet" id="change-link" type="text/css" href="assets/css/style.css" />
  <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- تضمين مكتبة DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>


</head>

<body class="auth-body">
  <!-- header starts -->
  <div class="auth-header">
    <div class="help-head d-flex">
      <a href="index.php"> <i class="back-btn" data-feather="arrow-left"></i> </a>
      <h2>Members Income</h2>
    </div>
    <div class="head-img text-center">
      <img class="img-fluid img2" src="assets/images/authentication/help.svg" alt="v1" />
    </div>
  </div>
  <!-- header end -->



  
  <!-- banner section end -->


  <section>
    <div class="custom-container">
      <div class="title">
      <h2>All Agency Members</h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="tableContainer" class="table-responsive">
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">ID</th>
                            <th scope="col">Golds</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require 'config/dbcon.php';
                        $customHeaderName = 'UID';

                        if (isset($_SERVER['HTTP_' . $customHeaderName])) {
                            $userId = $_SERVER['HTTP_' . $customHeaderName];
                            $userId = $conn->real_escape_string($userId);

                            $currentMonth = date('m');
                            $currentYear = date('Y');

                            $sql = "SELECT owner_uid FROM agency WHERE owner_uid = '$userId'";
                            $result = $conn->query($sql);

                            if ($result && $result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $ownerUid = $row['owner_uid'];

                                $sql = "SELECT id FROM agency WHERE owner_uid = '$ownerUid'";
                                $result = $conn->query($sql);

                                if ($result && $result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $agencyId = $row['id'];

                                    $sql = "SELECT users.uid AS id, 
                                    full_name AS title, 
                                    users.profile_pic AS icon, 
                                    short_digital_id, 
                                    SUM(agency_profit) AS agency_profit, 
                                    SUM(owner_profit) AS owner_profit, 
                                    SUM(receiver_profit) AS receiver_profit, 
                                    gifts_history_details.created_at  
                             FROM `gifts_history_details` 
                             JOIN `users` ON users.uid = gifts_history_details.receiver_uid 
                             JOIN `gifts` ON gifts.id = gifts_history_details.gift_id 
                             WHERE users.agency_id = '$agencyId' 
                                   AND DAY(gifts_history_details.created_at) >= 1 
                                   AND DAY(gifts_history_details.created_at) <= 31 
                                   AND MONTH(gifts_history_details.created_at) = '$currentMonth' 
                                   AND YEAR(gifts_history_details.created_at) = '$currentYear'
                             GROUP BY users.uid";
                     
                                    $result = $conn->query($sql);

                                    if ($result && $result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td><img src='../images/" . $row['icon'] . "' class='rounded-circle' width='42' height='42'></td>";
                                            echo "<td>" . $row['title'] . "</td>";
                                            echo "<td>" . $row['short_digital_id'] . "</td>";
                                            echo "<td>" . $row['receiver_profit'] . "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='2'>No data found for agency with ID $agencyId for the current month.</td></tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='2'>No agency found for owner UID $ownerUid.</td></tr>";
                                }
                            } else {
                                echo "<tr><td colspan='2'>User with UID $userId not found in agency table.</td></tr>";
                            }

                            $conn->close();
                        } else {
                            echo "<tr><td colspan='2'>Custom header '$customHeaderName' not found in the request.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</section>

  
<style>
        .dataTables_info {
            display: none;
        }
    </style>

<style>
        #myTable tbody td:nth-child(2) {
            color: green;
        }
        #myTable tbody td:nth-child(3) {
            color: red; /* لون الذهبي */
        }
        #myTable tbody td:nth-child(4) {
            color: orange; /* لون الذهبي */
        }

    </style>


  <!-- feather js -->
  <script src="assets/js/feather.min.js"></script>
  <script src="assets/js/custom-feather.js"></script>

  <!-- bootstrap js -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>

  <!-- script js -->
  <script src="assets/js/script.js"></script>
  <!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    $('#myTable').DataTable({
        lengthChange: false
    });
});
    </script>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>



</body>

</html>