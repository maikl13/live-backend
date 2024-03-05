<?php

// Loop through all headers in the $_SERVER array
foreach ($_SERVER as $key => $value) {
    // Check if the key starts with 'HTTP_' to filter out non-header values
    if (strpos($key, 'HTTP_') === 0) {
        // Remove 'HTTP_' prefix and replace underscores with hyphens
        $headerName = str_replace('HTTP_', '', $key);
        $headerName = str_replace('_', '-', $headerName);

        // Output the header name and value
        echo $headerName . ': ' . $value . '<br>';
    }
}

?>
