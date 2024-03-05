<?php
session_start();
include('config/dbcon.php');


// استرجاع قيمة حقل البحث
$searchTerm = $_POST['searchTerm'];

// استعلام للبحث في قاعدة البيانات
$sql = "SELECT * FROM agency WHERE id LIKE '%$searchTerm%'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    ?>
                          <?php
    // عرض النتائج
    while ($row = $result->fetch_assoc()) {
        $image = $row['image'];
        $id = $row['id'];

        ?>
        
        <!-- Element Heading -->
        <div  class="element-heading">
        </div>
        <!-- Chat User List -->
        <ul class="ps-0 chat-user-list" id="agentcoinsresult">
                    <!-- Single Chat User -->
                    <li  class="p-3"><a class="d-flex">
              <!-- Thumbnail -->
              <div class="chat-user-thumbnail me-3 shadow"><img class="img-circle" src="../images/<?php echo $row['image']; ?>" width="75" height="75" alt=""><span class="active-status"></span></div>

              <!-- Info -->
              <div class="chat-user-info">
                <h6 class="text-truncate mb-0"><?php echo $row['name']; ?></h6>
                <p class="text-truncate mb-0" ><img class="img-circle" src="../images/<?php echo $row['flag']; ?>" width="28" height="28" alt=""></p>
                <div class="last-chat">
                </div>
              </div></a>
            <!-- Options -->
            <div class="">
              <button class="btn btn-primary" type="submit">Join</button>

            </div>
          </li>
          <?php
                   }
                   ?>
<?php


} else {
    echo "No results found.";
}


// إغلاق اتصال قاعدة البيانات
$con->close();
?>
