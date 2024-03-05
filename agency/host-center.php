

<?php
include('includes/host-header.php');
include('config/dbcon.php');

?>

        <!-- page content here -->
        <div class="container-fluid bg-template">
            <div class="row hn-114 position-relative">
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-auto">
                    <figure class="avatar avatar-120 top-30 position-relative">
                      
                    <?php
require 'config/dbcon.php';
$customHeaderName = 'UID';

// Check if the custom header is set in the request
if (isset($_SERVER['HTTP_' . $customHeaderName])) {
    // Retrieve the value of the custom header
    $userId = $_SERVER['HTTP_' . $customHeaderName];

    // Sanitize the user ID to prevent SQL injection
    $userId = $conn->real_escape_string($userId);

    // Query to retrieve user data based on the user ID
    $sql = "SELECT agency.image FROM users INNER JOIN agency ON users.agency_id = agency.id WHERE users.uid = '$userId'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch user data
        $userData = $result->fetch_assoc();

        // Use user data as needed
        echo "<img src='../images/{$userData['image']}'  alt=''>";
    } else {
        echo "User with UID $userId not found.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Custom header '$customHeaderName' not found in the request.";
}
?>

                    </figure>
                </div>
                <div class="col pl-0">
                    <p class="mt-3 mb-2">

                    <?php
require 'config/dbcon.php';
$customHeaderName = 'UID';

// Check if the custom header is set in the request
if (isset($_SERVER['HTTP_' . $customHeaderName])) {
    // Retrieve the value of the custom header
    $userId = $_SERVER['HTTP_' . $customHeaderName];

    // Sanitize the user ID to prevent SQL injection
    $userId = $conn->real_escape_string($userId);

    // Query to retrieve user data based on the user ID
    $sql = "SELECT agency.flag FROM users INNER JOIN agency ON users.agency_id = agency.id WHERE users.uid = '$userId'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch user data
        $userData = $result->fetch_assoc();

        // Use user data as needed
        echo "<img src='../images/{$userData['flag']}'  alt='' width='28' height='28'>";
    } else {
        echo "User with UID $userId not found.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Custom header '$customHeaderName' not found in the request.";
}
?>


                    </p>
                    <h5 class="font-weight-normal mb-0">

                    <?php
require 'config/dbcon.php';
$customHeaderName = 'UID';

// Check if the custom header is set in the request
if (isset($_SERVER['HTTP_' . $customHeaderName])) {
    // Retrieve the value of the custom header
    $userId = $_SERVER['HTTP_' . $customHeaderName];

    // Sanitize the user ID to prevent SQL injection
    $userId = $conn->real_escape_string($userId);

    // Query to retrieve user data based on the user ID
    $sql = "SELECT agency.name FROM users INNER JOIN agency ON users.agency_id = agency.id WHERE users.uid = '$userId'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch user data
        $userData = $result->fetch_assoc();

        // Use user data as needed
        echo "{$userData['name']}";
          } else {
        echo "User with UID $userId not found.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Custom header '$customHeaderName' not found in the request.";
}
?>

                    </h5>
                    <p class="my-0 text-secondary text-mute">

                    <?php
require 'config/dbcon.php';
$customHeaderName = 'UID';

// Check if the custom header is set in the request
if (isset($_SERVER['HTTP_' . $customHeaderName])) {
    // Retrieve the value of the custom header
    $userId = $_SERVER['HTTP_' . $customHeaderName];

    // Sanitize the user ID to prevent SQL injection
    $userId = $conn->real_escape_string($userId);

    // Query to retrieve user data based on the user ID
    $sql = "SELECT agency.bio FROM users INNER JOIN agency ON users.agency_id = agency.id WHERE users.uid = '$userId'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch user data
        $userData = $result->fetch_assoc();

        // Use user data as needed
        echo "{$userData['bio']}";
          } else {
        echo "User with UID $userId not found.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Custom header '$customHeaderName' not found in the request.";
}
?>
                    </p>
                </div>
                <div class="col-auto pl-0">
                </div>
            </div>
        </div>
        <div class="container-fluid border-top border-bottom">
            <div class="row">
                <div class="container text-center py-3">
                    <div class="row">
                        <div class="col">
                            <h5 class="font-weight-normal mb-0">

                            <?php
require 'config/dbcon.php';
$customHeaderName = 'UID';

// Check if the custom header is set in the request
if (isset($_SERVER['HTTP_' . $customHeaderName])) {
    // Retrieve the value of the custom header
    $userId = $_SERVER['HTTP_' . $customHeaderName];

    // Sanitize the user ID to prevent SQL injection
    $userId = $conn->real_escape_string($userId);

    // Query to retrieve user data based on the user ID
    $sql = "SELECT * FROM users WHERE uid = '$userId'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch user data
        $userData = $result->fetch_assoc();

        // Use user data as needed
        echo "{$userData['agency_id']}";
    } else {
        echo "User with UID $userId not found.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Custom header '$customHeaderName' not found in the request.";
}
?>

                            </h5>
                            <p class="my-0 text-secondary text-mute">Agency ID</p>
                        </div>
                        <div class="col border-left-dashed">
                            <h5 class="font-weight-normal mb-0">3.2k</h5>
                            <p class="my-0 text-secondary text-mute">Monthly Golds</p>
                        </div>
                        <div class="col border-left-dashed">
                            <h5 class="font-weight-normal mb-0">1</h5>
                            <p class="my-0 text-secondary text-mute">Host Rank</p>
                        </div>
                    </div>
                </div>


    </div>
    <!-- wrapper ends -->

    <div class="container my-5">
            <div class="row mb-4">
                <div class="col text-uppercase">
                    <h4 style="color: red;" class="mb-0">Agency Founder</h4>
                </div>
                <div class="col-auto align-self-end"></div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 mb-4">
                    <div class="row mb-2">
                        <div class="col-auto">
                            <figure class="avatar avatar-60">
                            <?php
require 'config/dbcon.php';
$customHeaderName = 'UID';

// Check if the custom header is set in the request
if (isset($_SERVER['HTTP_' . $customHeaderName])) {
    // Retrieve the value of the custom header
    $userId = $_SERVER['HTTP_' . $customHeaderName];

    // Sanitize the user ID to prevent SQL injection
    $userId = $conn->real_escape_string($userId);

    // Query to retrieve user data based on the user ID
    $sql = "SELECT a.id, b.id, a.uid, a.short_digital_id, a.full_name as userfullname, a.profile_pic, a.level, b.name, b.owner_uid, b.image, a.agency_id, u.profile_pic as owner_profilepic
    FROM users AS a
    INNER JOIN agency AS b ON a.agency_id = b.id
    INNER JOIN users AS u ON u.uid = b.owner_uid
    WHERE a.uid = '$userId'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch user data
        $userData = $result->fetch_assoc();

        // Use user data as needed
        echo "<img src='../images/{$userData['owner_profilepic']}'  alt=''>";
    } else {
        echo "User with UID $userId not found.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Custom header '$customHeaderName' not found in the request.";
}
?>

                            </figure>
                        </div>
                        <div class="col pl-0">
                            <h6 class="mb-2 font-weight-normal">
                            <?php
require 'config/dbcon.php';
$customHeaderName = 'UID';

// Check if the custom header is set in the request
if (isset($_SERVER['HTTP_' . $customHeaderName])) {
    // Retrieve the value of the custom header
    $userId = $_SERVER['HTTP_' . $customHeaderName];

    // Sanitize the user ID to prevent SQL injection
    $userId = $conn->real_escape_string($userId);

    // Query to retrieve user data based on the user ID
    $sql = "SELECT a.id, b.id, a.uid, a.short_digital_id, a.full_name as userfullname, a.profile_pic, a.level, b.name, b.owner_uid, b.image, a.agency_id, u.full_name as owner_name
    FROM users AS a
    INNER JOIN agency AS b ON a.agency_id = b.id
    INNER JOIN users AS u ON u.uid = b.owner_uid
    WHERE a.uid = '$userId'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch user data
        $userData = $result->fetch_assoc();

        // Use user data as needed
        echo "{$userData['owner_name']}";
          } else {
        echo "User with UID $userId not found.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Custom header '$customHeaderName' not found in the request.";
}
?>

                            </h6>
                            <p class="small text-mute">ID :
                            <?php
require 'config/dbcon.php';
$customHeaderName = 'UID';

// Check if the custom header is set in the request
if (isset($_SERVER['HTTP_' . $customHeaderName])) {
    // Retrieve the value of the custom header
    $userId = $_SERVER['HTTP_' . $customHeaderName];

    // Sanitize the user ID to prevent SQL injection
    $userId = $conn->real_escape_string($userId);

    // Query to retrieve user data based on the user ID
    $sql = "SELECT a.id, b.id, a.uid, a.short_digital_id, a.full_name as userfullname, a.profile_pic, a.level, b.name, b.owner_uid, b.image, a.agency_id, u.short_digital_id as owner_displayid
    FROM users AS a
    INNER JOIN agency AS b ON a.agency_id = b.id
    INNER JOIN users AS u ON u.uid = b.owner_uid
    WHERE a.uid = '$userId'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch user data
        $userData = $result->fetch_assoc();

        // Use user data as needed
        echo "{$userData['owner_displayid']}";
          } else {
        echo "User with UID $userId not found.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Custom header '$customHeaderName' not found in the request.";
}
?>

                            </p>
                        </div>

                <div class="container my-5">
            <div class="row mb-4">
                <div class="col text-uppercase">
                    <h4  style="color: orange;" class="mb-0">Agency Co-Founder</h4>
                </div>
                <div class="col-auto align-self-end"></div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 mb-4">
                    <div class="row mb-2">
                        <div class="col-auto">
                            <figure class="avatar avatar-60">
                            <?php
require 'config/dbcon.php';
$customHeaderName = 'UID';

// Check if the custom header is set in the request
if (isset($_SERVER['HTTP_' . $customHeaderName])) {
    // Retrieve the value of the custom header
    $userId = $_SERVER['HTTP_' . $customHeaderName];

    // Sanitize the user ID to prevent SQL injection
    $userId = $conn->real_escape_string($userId);

    // Query to retrieve user data based on the user ID
    $sql = "SELECT a.id, b.id, a.uid, a.short_digital_id, a.full_name as userfullname, a.profile_pic, a.level, b.name, b.co_founder_uid, b.image, a.agency_id, u.profile_pic as owner_profilepic
    FROM users AS a
    INNER JOIN agency AS b ON a.agency_id = b.id
    INNER JOIN users AS u ON u.uid = b.co_founder_uid
    WHERE a.uid = '$userId'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch user data
        $userData = $result->fetch_assoc();

        // Use user data as needed
        echo "<img src='../images/{$userData['owner_profilepic']}'  alt=''>";
    } else {
        echo "User with UID $userId not found.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Custom header '$customHeaderName' not found in the request.";
}
?>

                            </figure>
                        </div>
                        <div class="col pl-0">
                            <h6 class="mb-2 font-weight-normal">
                            <?php
require 'config/dbcon.php';
$customHeaderName = 'UID';

// Check if the custom header is set in the request
if (isset($_SERVER['HTTP_' . $customHeaderName])) {
    // Retrieve the value of the custom header
    $userId = $_SERVER['HTTP_' . $customHeaderName];

    // Sanitize the user ID to prevent SQL injection
    $userId = $conn->real_escape_string($userId);

    // Query to retrieve user data based on the user ID
    $sql = "SELECT a.id, b.id, a.uid, a.short_digital_id, a.full_name as userfullname, a.profile_pic, a.level, b.name, b.co_founder_uid, b.image, a.agency_id, u.full_name as owner_name
    FROM users AS a
    INNER JOIN agency AS b ON a.agency_id = b.id
    INNER JOIN users AS u ON u.uid = b.co_founder_uid
    WHERE a.uid = '$userId'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch user data
        $userData = $result->fetch_assoc();

        // Use user data as needed
        echo "{$userData['owner_name']}";
          } else {
        echo "User with UID $userId not found.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Custom header '$customHeaderName' not found in the request.";
}
?>

                            </h6>
                            <p class="small text-mute">ID :
                            <?php
require 'config/dbcon.php';
$customHeaderName = 'UID';

// Check if the custom header is set in the request
if (isset($_SERVER['HTTP_' . $customHeaderName])) {
    // Retrieve the value of the custom header
    $userId = $_SERVER['HTTP_' . $customHeaderName];

    // Sanitize the user ID to prevent SQL injection
    $userId = $conn->real_escape_string($userId);

    // Query to retrieve user data based on the user ID
    $sql = "SELECT a.id, b.id, a.uid, a.short_digital_id, a.full_name as userfullname, a.profile_pic, a.level, b.name, b.co_founder_uid, b.image, a.agency_id, u.short_digital_id as owner_displayid
    FROM users AS a
    INNER JOIN agency AS b ON a.agency_id = b.id
    INNER JOIN users AS u ON u.uid = b.co_founder_uid
    WHERE a.uid = '$userId'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch user data
        $userData = $result->fetch_assoc();

        // Use user data as needed
        echo "{$userData['owner_displayid']}";
          } else {
        echo "User with UID $userId not found.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Custom header '$customHeaderName' not found in the request.";
}
?>

                            </p>
                        </div>
                    </div>
                </div>




<?php include('includes/host-script.php');?>
