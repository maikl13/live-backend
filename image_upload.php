<?php
$return["error"] = false;
$return["msg"] = "";
//return $_POST;
if(isset($_POST["image"])){
    $base64_string = $_POST["image"];
    $imageName = $_POST["imageName"];
    $outputfile = __DIR__."/images/$imageName";

    // Decode the base64 image data
    $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64_string));

    // Save the image file
    file_put_contents($outputfile, $fileData);

    // Check if the uploaded file is a GIF
    $imageInfo = getimagesize($outputfile);
    if ($imageInfo && $imageInfo["mime"] === "image/gif") {
        // Set the correct content type header
        header('Content-Type: image/gif');
        // Output the GIF image directly
        readfile($outputfile);
        exit;
    } else {
        $return["error"] = false;
        $return["msg"] = "The uploaded file is not a GIF image.";
    }
} else {
    $return["error"] = true;
    $return["msg"] = "No image is submitted.";
}

header('Content-Type: application/json');
echo json_encode($return);
