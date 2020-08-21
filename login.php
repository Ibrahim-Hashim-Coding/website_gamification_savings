<?php 
session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body class="text-center jumbotron bg-light text-dark">
<?php
    require('db.php');
    // When form submitted, check and create user session.
    if (isset($_POST['username'])) {
        $username = stripslashes($_REQUEST['username']);    // removes backslashes
        $username = mysqli_real_escape_string($con, $username);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        // Check user is exist in the database
        $query    = "SELECT * FROM `users` WHERE username='$username'
                     AND password='" . md5($password) . "'";
        $result = mysqli_query($con, $query) or die(mysql_error());
        $rows = mysqli_num_rows($result);
        if ($rows == 1) {
            $_SESSION['username'] = $username;
            // Redirect to user dashboard page
            echo "<script>window.location.href='index.php'</script>";
            exit();
        } else {
            echo "<div class='form'>
                  <h3>Incorrect Username/password.</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a> again.</p>
                  </div>";
        }
    } else {
?>
    <form method="post" name="login">
        
        <div class="form-group">
        <h1 class="login-title">Login</h1>
        </div>
        
        <div class="form-group">
        <input type="text" name="username" placeholder="Username" autofocus="true"/>
        </div>
        
        <div class="form-group">
        <input type="password" name="password" placeholder="Password"/>
        </div>
        
        <div class="form-group">
        <input type="submit" value="Login" name="submit"/>
        </div>
        
        <div class="form-group">
        <p class="link"><a href="registration.php">New Registration</a></p>
        </div>
  </form>
<?php
    }
?>
</body>
</html>