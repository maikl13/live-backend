<?php
 $targetDirectory = "audio/voice_messages/" ;
//$targetDirectory = 'path/to/upload/directory/';
$targetFile = $targetDirectory . basename($_FILES['audio']['name']);
$uploadOk = 1;
$fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Check if the file is a valid audio file
if ($fileType !== 'wav') {
    echo 'Invalid audio file format.';
    $uploadOk = 0;
}

// Check if the file was successfully uploaded
if ($uploadOk === 0) {
    echo 'Failed to upload the audio file.';
} else {
    if (move_uploaded_file($_FILES['audio']['tmp_name'], $targetFile)) {
        // File uploaded successfully, you can now process and save the audio file as needed
        echo 'Audio file uploaded successfully.';
    } else {
        echo 'Failed to upload the audio file.';
    }
}
?>