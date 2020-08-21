<?php
//include auth_session.php file on all user panel pages
include("auth_session.php");
require('db.php');

$username = $_SESSION['username'];
$query  = "SELECT * FROM `users` WHERE username='$username'";
$old_result = mysqli_fetch_assoc(mysqli_query($con, $query));

$saved_week1 = $old_result['saved_week1'];
$saved_week2 = $old_result['saved_week2'];
$saved_week3 = $old_result['saved_week3'];
$saved_week4 = $old_result['saved_week4'];

$date_week1 = date("2020-08-01 00:00:00");
$date_week2 = date("2020-08-08 00:00:00");
$date_week3 = date("2020-08-15 00:00:00");
$date_week4 = date("2020-08-22 00:00:00");
$date_week5 = date("2020-08-29 00:00:00");

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>JustSaveMore Increase Savings</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<style>
   .btn-xl {
    padding: 10px 20px;
    font-size: 30px;
    border-radius: 50%;
    width:150px; 
    height:150px;
}
</style>



<body class="text-center jumbotron bg-light text-dark"
    <div style = "border-width:8px; border-color:#5cb85c; border-style:solid;"

 <?php

            // When form submitted, check and create user session.
            if (isset($_REQUEST['savings_value'])) {
                $savings_value = stripslashes($_REQUEST['savings_value']);   
                $savings_value = mysqli_real_escape_string($con, $savings_value);
                
                if(is_numeric($savings_value)){
                    
                    $total_savings = $old_result['total_savings'];
                    $total_savings = intval($total_savings) + intval($savings_value);
                    
                    date_default_timezone_set('Europe/London');
                    $sTime = date("Y-m-d h:i:sa");
                    $TimeZone = 'Europe/London';
                    $query  = "INSERT into `individual_savings` (user_id, saving_value, saving_time, r_time_zone) VALUES ('$username', '$savings_value', '$sTime', '$TimeZone')";
                                             
                            $result   = mysqli_query($con, $query);
                            if ($result) 
                            {
                                $progress_bar = strval(100*($total_savings/intval($old_result['savings_goal'])));
                                
                                
                                if($sTime > $date_week1 and $sTime < $date_week2)
                                {
                                    $saved_week1 = '1';
                                }
                                elseif($sTime > $date_week2 and $sTime < $date_week3)
                                {
                                    $saved_week2 = '1';
    
                                }
                                elseif($sTime > $date_week3 and $sTime < $date_week4)
                                {
                                    $saved_week3 = '1';
    
                                }
                                elseif($sTime > $date_week4 and $sTime < $date_week5)
                                {
                                    $saved_week4 = '1';
    
                                }
                                else{
                                    $saved_week4 = '2';
                                }
                                
                                $total_savings = strval($total_savings);
                                $query = "UPDATE users SET total_savings='$total_savings', progress_bar='$progress_bar', saved_week1='$saved_week1', saved_week2='$saved_week2',saved_week3='$saved_week3',saved_week4='$saved_week4' WHERE username='$username'";
    
                                $result = mysqli_query($con, $query);
                                
                               if ($result) {
                                    echo "<div class='form'>
                                    <h1>Savings updated!</h1><br/>
                                    </div>";
                               } else {
                                    echo "<div class='form'>
                                    <h1>An error occure while trying to update your savings. Please contact support under service@justsavemore.net</h1><br/>
                                    <p class='link'>Click <a href='index.php'>here</a> to return to the dashboard again.</p>
                                    </div>";
                               }
                                                        
                            } 
                            else 
                            {
                                echo "<div class='form'>
                                <h3>Required fields are missing.</h3><br/>
                                <p class='link'>Click <a href='index.php'>here</a> to return to dashboard.</p>
                                </div>";
                            }
               
                }
                else
                {
                    echo "<div class='form'>
                    <h3>Input has to be a number.</h3><br/>
                    <p class='link'>Click <a href='index.php'>here</a> to return to the dashboard.</p>
                    </div>";
                    exit;
                }
             } else {
            ?>
            
             
            <!--Update Savings Form -->
            <form action="" method="post">
                <div class="form-group">
                <h1>Increase Savings</h1>
                </br>
                </div>
                
                <div class="form-group">
                <input type="text" class = "text-center" style = "font-size: 20px;" name="savings_value" placeholder="Enter amount here" autofocus="true" required/>
                </div>
                </br>
                <div class="form-group">
                <input type="submit" class="btn btn-success btn-xl" value="Increase" name="submit"/>
                </div>
            </form>
            <?php
            }?>
            </br></br></br>
    <h2>Back to the <a href='index.php'>dashboard</a>.</h2>
    </div>
</body>
</html>

