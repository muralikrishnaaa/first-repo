<?php
// Specify the target directory where files will be uploaded
$targetDirectory = "uploads/";

// Check if the directory exists, if not, create it
if (!file_exists($targetDirectory)) {
    mkdir($targetDirectory, 0777, true);
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $uploadFile = $targetDirectory . basename($_FILES["file"]["name"]);

    // Check if file already exists
    if (file_exists($uploadFile)) {
        echo "File already exists.";
    } else {
        // Try to move uploaded file to target directory
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        //checking if the file is image format or not
        if($check !== false){
            echo "<pre>File is an image - " . $check["mime"] . ".</pre>";
            $uploaded = 1;
            if($_FILES["file"]["size"] < 5000000){//if it is image then check the size of the file
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $uploadFile)) {//if file size is small then upload it
                    echo "File uploaded successfully.";
                }
            } else {//file is above 5mb's
                echo "file is too large";
            }
        } else {//given file is not an image
            unlink($uploadFile);
            echo "File is not an image.";
            $uploaded = 0;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="file" id="file">
        <input type="submit" value="Upload File" name="submit">
    </form>
</body>
</html>
