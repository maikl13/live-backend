<?php
include('config/dbcon.php');

if(isset($_GET['q'])) {
    $searchQuery = $_GET['q'];

    $sql = "SELECT * FROM agency WHERE id LIKE '%$searchQuery%' OR name LIKE '%$searchQuery%'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<li class="p-3 chat-unread"><a class="d-flex" href="agency_details.php?id=' . $row['id'] . '">';
            // إضافة الـ ID كـ hidden input
            echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
            echo '<div class="chat-user-thumbnail me-3 shadow"><img class="img-circle" src="../images/' . $row['image'] . '" alt=""><span class="active-status"></span></div>';
            echo '<div class="chat-user-info">';
            // عرض الاسم والباقي كما هو
            echo '<h6 class="text-truncate mb-0">' . $row['name'] . '</h6>';
            echo '<p class="text-truncate mb-0"><img class="img-circle" src="../images/' . $row['flag'] . '" width="28" height="28" alt=""></p>';
            echo '<div class="last-chat"></div>';
            echo '</div></a>';
            echo '<div class=""><button class="btn btn-primary" type="submit">View</button></div>';
            echo '</li>';
        }
    } else {
        echo '<li><p>No results found.</p></li>';
    }
} else {
    echo '<li><p>No search query provided.</p></li>';
}

$conn->close();
?>
