<?php
//include auth_session.php file on all user panel pages
include("auth_session.php");
require('db.php');

$username = $_SESSION['username'];
$query  = "SELECT * FROM `users` WHERE username='$username'";
$result = mysqli_fetch_assoc(mysqli_query($con, $query));

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Upload Results</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body class="text-center jumbotron bg-white text-dark">


<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is an actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {?>
  <h3><?php echo "Sorry, file already exists. ";?></h3>
  <?php
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {?>
  <h3><?php echo "Sorry, your file is too large. ";?></h3>
  <?php
  
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {?>
  <h3><?php echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed. ";?></h3>
  <?php
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {?>
  <h3><?php echo "Sorry, your file was not uploaded.";?></h3>
  <?php

// if everything is ok, try to upload file
} else {
    $target_file = $target_dir . $username . basename($_FILES["fileToUpload"]["name"]);

  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded. ";
  } else {?>
  <h3><?php echo "Sorry, there was an error uploading your file. ";?></h3>
  <?php
   
  }
}
?>
<br><br><br>
<h3>Back to the <a href="index.php">dashboard</a>.</h3>


</body>
</html>