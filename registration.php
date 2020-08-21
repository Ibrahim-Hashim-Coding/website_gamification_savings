<?php 
session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Registration</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body class="text-center jumbotron bg-light text-dark">

<?php
    require('db.php');
    // When form submitted, insert values into the database.
    if (isset($_REQUEST['username']))
    {
        // removes backslashes
        $username = stripslashes($_REQUEST['username']);
        //escapes special characters in a string
        $username = mysqli_real_escape_string($con, $username);
        
        // check if username exists
        $username_query = mysqli_query($con, "SELECT *
                                           FROM users
                                           WHERE username = '$username'");
                                           
        $count=mysqli_num_rows($username_query);
        
        if($count==0)
        {
            $email       = stripslashes($_REQUEST['email']);
            $email       = mysqli_real_escape_string($con, $email);
            $email_query = mysqli_query($con, "SELECT *
                                           FROM users
                                           WHERE email = '$email'");
                                           
            $count=mysqli_num_rows($email_query);
            
            if($count==0)
            {
                $user_age    = stripslashes($_REQUEST['user_age']);
                $user_age    = mysqli_real_escape_string($con, $user_age);
                
                if(is_numeric($user_age))
                {
                    $savings_goal = stripslashes($_REQUEST['savings_goal']);
                    $savings_goal = mysqli_real_escape_string($con, $savings_goal);
                    
                    if(is_numeric($savings_goal))
                    {
                        $password    = stripslashes($_REQUEST['password']);
                        $password    = mysqli_real_escape_string($con, $password);
                        $user_gender = stripslashes($_REQUEST['user_gender']);
                        $user_gender = mysqli_real_escape_string($con, $user_gender);
                        
                        
                        $group_options = array(0, 1);
                        $group_number = array_rand($group_options, 1);
                            
                        if($group_number==0)
                        {
                            $group_counter = 99999;
                            $group_leaderboard = 99999;
                        }
                        else
                        {
                            $group_counter_query = mysqli_query($con, "SELECT *
                                                   FROM users
                                                   WHERE group_number = 1");
                                                   
                            $count=mysqli_num_rows($group_counter_query);
                            if($count==0)
                            {
                                $group_counter = 0;
                                $group_leaderboard = 0;
                            }
                            else
                            {
                                $last_member_query = mysqli_fetch_assoc(mysqli_query($con, "SELECT group_leaderboard FROM users WHERE group_number = 1 ORDER BY id DESC LIMIT 1"));
                                $leader_num = $last_member_query['group_leaderboard'];
        
                                if(intval($leader_num)==9)
                                {
                                    $group_query = mysqli_fetch_assoc(mysqli_query($con, "SELECT group_counter FROM users WHERE group_number = 1 ORDER BY id DESC LIMIT 1"));
                                    $group_counter = $group_query['group_counter'];
                                    $group_counter = intval($group_c) + 1;
                                    $group_leaderboard = 0;
                                }
                                else
                                {
                                    $group_leaderboard = intval($leader_num) + 1;
                                    $group_query = mysqli_fetch_assoc(mysqli_query($con, "SELECT group_counter FROM users WHERE group_number = 1 ORDER BY id DESC LIMIT 1"));
                                    $group_counter = $group_query['group_counter'];
                                    $group_counter = intval($group_counter);
                                  
                                }
                            
                            }
                            
                        }
                        $query  = "INSERT into `users` (username, password, email, group_number, group_counter, group_leaderboard, user_age, user_gender, savings_goal)
                                         VALUES ('$username', '" . md5($password) . "', '$email', '$group_number', '$group_counter', '$group_leaderboard', '$user_age', '$user_gender', '$savings_goal')";
                                         
                        $result   = mysqli_query($con, $query);
                        if ($result) 
                        {
                            echo "<div class='form'>
                            <h3>You are registered successfully.</h3><br/>
                            <p class='link'>Click here to <a href='login.php'>Login</a></p>
                            </div>";
                        } 
                        else 
                        {
                            echo "<div class='form'>
                            <h3>Required fields are missing.</h3><br/>
                            <p class='link'>Click <a href='registration.php'>here</a> to try and register again.</p>
                            </div>";
                        }
                    }
                    else
                    {
                        echo "<div class='form'>
                        <h3>Savings goal has to be a number.</h3><br/>
                        <p class='link'>Click <a href='registration.php'>here</a> to try and register again.</p>
                        </div>";
                        exit;
                    }
                }
                else
                {
                    echo "<div class='form'>
                    <h3>Age has to be a number.</h3><br/>
                    <p class='link'>Click <a href='registration.php'>here</a> to try and register again.</p>
                    </div>";
                    exit;
                }
            }
            else
            {
                echo "<div class='form'>
                <h3>Email already exists.</h3><br/>
                <p class='link'>Click <a href='registration.php'>here</a> to try and register again.</p>
                </div>";
                exit;
            }
        }
        else
        {
            echo "<div class='form'>
            <h3>Username already exists.</h3><br/>
            <p class='link'>Click <a href='registration.php'>here</a> to try and register again.</p>
            </div>";
            exit;
        }
        
    } 
    else 
    {
?>
        <form action="" method="post">
            
            <div class="form-group">
                <h1>Registration</h1>
            </div>
            
            <div class="form-group">
                
            <p> Please fill in Prolific ID if row below is blank.</p>
            <input type="text" name="username" placeholder="Prolific ID" value=" <?php echo $_GET['PROLIFIC_PID']; ?>" required /> 
            </div>
            
            <div class="form-group">
                <input type="text"  name="email" placeholder="Email Adress" required/>
            </div>
            
            <div class="form-group">
                <input type="text" name="user_age" placeholder="Age" required />
            </div>
            
            <div class="form-group">
                <input type="text" name="savings_goal" placeholder="Your savings goal" required />
            </div>
            
            <div class="form-group">
                <input type="radio" id="male" name="user_gender" value="female" checked="checked">
                <label for="female">Female</label><br>
                <input type="radio" id="female" name="user_gender" value="male">
                <label for="male">Male</label><br>
                <input type="radio" id="other" name="user_gender" value="other">
                <label for="other">Other</label>
            </div>
            
            <div class="form-group">
                <input type="password" name="password" placeholder="Password">
            </div>
            
            <div class="form-group">
                <input type="submit" name="submit" value="Register">
            </div>
            
            <div class="form-group">
                <p class="link"><a href="login.php">Click to Login</a></p>
            </div>
        </form>
<?php
    }
?>
</div>
</body>
</html>