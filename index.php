<?php
//include auth_session.php file on all user panel pages
include("auth_session.php");
require('db.php');

$username = $_SESSION['username'];
$query  = "SELECT * FROM `users` WHERE username='$username'";
$result = mysqli_fetch_assoc(mysqli_query($con, $query));
$user_group_number = $result['group_number'];
$saved_week1 = $result['saved_week1'];
$saved_week2 = $result['saved_week2'];
$saved_week3 = $result['saved_week3'];
$saved_week4 = $result['saved_week4'];
$main_group = '1';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JustSaveMore Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>


<style>
    .blackandwhite {
    filter: grayscale(100%);
    }

    table th {
   text-align: center;
   }
   
   .btn-xl {
    padding: 10px 20px;
    font-size: 45px;
    border-radius: 10px;
    width:220px; 
    height:220px;
    line-height:90px;
    border-color: black;
    border-width: 2px;
    background-color:#02460B;
   }
    .rectangle_leaderboard {
      height: 84%;
      width: 100%;
      background-color: #C3E6CB;
      margin-left:0.5em;
    }
    
    .rectangle_progressbar {
      height: 32px;
      width: 100%;
      background-color: #5cb85c;
    }
    
    .rectangle_green {
        height: 8.5em;
        width: 5.5em;
        background-color: #5cb85c;
        margin-bottom: 1em;

    }
    
    .rectangle_grey {
        height: 8.5em;
        width: 5.5em;
        background-color: #D3D3D3;
        margin-bottom: 1em;
    }
    
    
    body {
  width: 75em;
  height: 57em;
 }

}
</style>


<body class="text-center jumbotron text-dark" style = "background-color: #02460B; margin: 0 auto;">
    <div class='bg-light' style = "border-style:solid; border-width:8px; border-color:black; margin: 0 auto;">
    <h1>Welcome to your Savings Dashboard!</h1>
    </br>
    
    <div class="row">
        
        <!-- Leaderboard table -->
        <div class="col-lg-4">      
        <?php
        if($user_group_number == $main_group)
        {?>
            <table class="table table-bordered table-striped table-primary text-center" style='margin-left:0.5em;' >
                <tr style='background-color:#02460B; color:white;'>
                    <th>User Name</th>
                    <th>Percentage Saved</th>
                </tr>
                
                <?php 
                $leaderboard_num = $result['group_counter'];
                $query  = "SELECT * FROM `users` WHERE group_counter='$leaderboard_num' ORDER BY progress_bar DESC";
                $leaderboard_result = mysqli_query($con, $query);
                ?>
                <tr>
                    <?php
                    for ($x = 0; $x <= 9; $x++) { 
                    $leaderboard_user = mysqli_fetch_row($leaderboard_result);
                    ?>
                        
                    <tr>
                        <?php
                        if($username == $leaderboard_user[1])
                        {
                        ?>
                            <td style = 'background-color:#5cb85c'><?php echo $leaderboard_user[1] ?></td>
                            <td style = 'background-color:#5cb85c'><?php echo $leaderboard_user[6] ?></td>
                        
                        <?php
                        }
                        else
                        {?>
                            <td class="table-success"><?php echo $leaderboard_user[1] ?></td>
                            <td class="table-success"><?php echo $leaderboard_user[6] ?></td>
                        <?php
                        }
                        ?>
                       
                    </tr>
                    <?php } ?>
                    </td>
                </tr>
            </table>
        <?php
        }
        else 
        {?>
            <div class='rectangle_leaderboard'></div>
        <?php
        }
        ?>
            
        </div> <!-- End of Leaderboard table  -->
        
        
        <!-- Savings Goal, Current Savings and Progress bar -->
        <div class="col-lg-4" style='height: 40em; width: 23.5em;'>
            <h2>I have saved</h2>
            <h2>£ <?php echo $result['total_savings']; ?></h2>
            <h2>My goal is</h2>
            <h2>£ <?php echo $result['savings_goal']; ?></h2>
            
            <br>
            
            <a class="btn btn-success btn-xl" href="add_savings.php" role="button" style="border-radius: 50%;">Increase</br>Savings</a>
            <br><br><br>

            <a class="btn btn-danger btn-lg" href="remove_savings.php" role="button">Decrease savings</a>
            
             <a class="btn btn-primary btn-lg" href="upload.html" role="button">Upload Image</a>
            <br><br><br><br>

            <?php
            if($user_group_number == $main_group)
            {?>
                <!-- Progress Bar -->
                <div class="progress" style="height:32px">
                     <div class="progress-bar progress-bar-success progress-bar-striped progress-bar-animated bg-success" 
                          role="progressbar" aria-valuenow="70" aria-valuemin="0"
                          aria-valuemax="100" style="width:<?php if($result['progress_bar'] > 0) {echo $result['progress_bar'];}else{echo 0;} ?>%"><h4><?php if($result['progress_bar'] > 0) {echo $result['progress_bar'];}else{echo 0;} ?>%</h4>
                     </div>
                </div>    
             <?php
            }
            else 
            {?>
                <div class='rectangle_progressbar'></div>
            <?php
            }
            ?>

        </div> <!-- End of Savings Goal, Current savings and progress bar -->
            
        <!-- Badges -->
        <div class="col-lg-4" style='height: 38em; width: 23.5em;'>       
        
         <div class="container">
                
                <div class="row" style='height: 33.5em; width: 35em;'>
                    
                    <!-- Started Saving -->
                    <div class="col-xs-1">
                        <div class="col">
                            <?php
                            if($user_group_number == $main_group)
                            {?>
                                <div class="row-xs-2" style='height: 5.5em; width: 5em;'>
                                    <?php if(intval($result['total_savings'] > 0))
                                    { ?>
                                        <img src = "/static/Started Saving.png" alt='Started Saving'>
                                    <?php } else { ?>
                                        <img src = "/static/Started Saving.png" alt='Started Saving' class='blackandwhite'>
                                    <?php } ?>
                                </div>
                                
                                <div class="row-xs-2" style='height: 5.5em; width: 5em;'>
                                    
                                    <p>Started Saving</p>
                                </div>
                            <?php
                            }
                            else 
                            {?>
                                <div class="row-xs-2">
                                    <div class='rectangle_green'></div>
                                </div>
                            <?php
                            }
                            ?> 
                        </div>
                    </div>

                    <!-- Saving Times -->
                    <div class="col-xs-1">
                        <div class="col">
                            <?php
                            if($user_group_number == $main_group)
                            {?>
                            <!-- Saved Week 1 -->
                            <div class="row-xs-2" style='height: 5.5em; width: 5em;'>
                                <?php if($saved_week1 == '1')
                                { ?>
                                    <img src = "/static/Saved in Week 1.png" alt='Saved in Week 1'>
                                <?php } else { ?>
                                    <img src = "/static/Saved in Week 1.png" alt='Saved in Week 1' class='blackandwhite'>
                                <?php } ?>
                                
                            </div>
                            <div class = "row-xs-2" style='height: 5.5em; width: 5em;'>
                                <p>Saved in Week 1</p>
                            </div>
                             <?php
                            }
                            else 
                            {?>
                                <div class="row-xs-2">
                                    <div class='rectangle_grey'></div>
                                </div>
                                <br>

                            <?php
                            }
                            ?> 
                            
                            <?php
                            if($user_group_number == $main_group)
                            {?>
                            <!-- Saved Week 2 -->
                            <div class="row-xs-2" style='height: 5.5em; width: 5em;'>
                              
                                <?php if($saved_week2 == '1')
                                { ?>
                                    <img src = "/static/Saved in Week 2.png" alt='Saved in Week 2'>
                                <?php } else { ?>
                                    <img src = "/static/Saved in Week 2.png" alt='Saved in Week 2' class='blackandwhite'>
                                <?php } ?>
                               
                            </div>
                            <div class = "row-xs-2" style='height: 5.5em; width: 5em;'>
                                <p>Saved in Week 2</p>
                            </div>
                             <?php
                            }
                            else 
                            {?>
                                <div class="row-xs-2">
                                    <div class='rectangle_green'></div>
                                </div>
                                <br>

                            <?php
                            }
                            ?>
                            
                            <?php
                            if($user_group_number == $main_group)
                            {?>
                              <!-- Saved Week 3 -->
                            <div class="row-xs-2" style='height: 5.5em; width: 5em;'>
                                <?php if($saved_week3 == '1')
                                { ?>
                                    <img src = "/static/Saved in Week 3.png" alt='Saved in Week 3'>
                                <?php } else { ?>
                                    <img src = "/static/Saved in Week 3.png" alt='Saved in Week 3' class='blackandwhite'>
                                <?php } ?>
                                </div>
                                <div class = "row-xs-2" style='height: 5.5em; width: 5em;'>
                                    <p>Saved in Week 3</p>
                                </div>
                            <?php
                            }
                            else 
                            {?>
                                <div class="row-xs-2">
                                    <div class='rectangle_grey'></div>
                                </div>
                                <br>

                            <?php
                            }
                            ?>
                                
                            <?php
                            if($user_group_number == $main_group)
                            {?>
                            <!-- Saved All 4 Weeks -->
                            <div class="row-xs-2" style='height: 5.5em; width: 5em;'>
                                 <?php if($saved_week1 == '1' and $saved_week2 == '1' and $saved_week3 == '1' and $saved_week4 == '1')
                                { ?>
                                    <img src = "/static/Saved in all 4 Weeks.png" alt='Saved in Week 4'>
                                <?php } else { ?>
                                    <img src = "/static/Saved in all 4 Weeks.png" alt='Saved in Week 4' class='blackandwhite'>
                                <?php } ?>
                               
                            </div>
                            <div class = "row-xs-2" style='height: 5.5em; width: 5em;'>
                                <p>Saved in all 4 Weeks</p>
                            </div>
                            
                            <?php
                            }
                            else 
                            {?>
                                <div class="row-xs-2">
                                    <div class='rectangle_grey'></div>
                                </div>
                                <br>

                            <?php
                            }
                            ?>
                            
                            
                        </div>
                    </div> <!-- End of saving times column -->


                    <!-- Saving Amounts -->
                    <div class="col-xs-1">
                        <div class="col">
                            
                             <?php
                            if($user_group_number == $main_group)
                            {?>
                            <!-- Saved 10 Pounds -->
                            <div class="row-xs-2" style='height: 5.5em; width: 5em;'>
                                <?php if(intval($result['total_savings'] >= 10))
                                { ?>
                                    <img src = "/static/Saved 10 Pounds.png" alt='Saved 10 Pounds'>
                                <?php } else { ?>
                                    <img src = "/static/Saved 10 Pounds.png" alt='Saved 10 Pounds' class='blackandwhite'>
                                <?php } ?>
                            </div>
                            <div class = "row-xs-2" style='height: 5.5em; width: 5em;'>
                                <p>Saved 10 Pounds</p>
                            </div>
                             <?php
                            }
                            else 
                            {?>
                                <div class="row-xs-2">
                                    <div class='rectangle_green'></div>
                                </div>
                                <br>

                            <?php
                            }
                            ?>
                            
                             <?php
                            if($user_group_number == $main_group)
                            {?>
                            <!-- Saved 20 Pounds -->
                            <div class="row-xs-2" style='height: 5.5em; width: 5em;'>
                                <?php if(intval($result['total_savings'] >= 20))
                                { ?>
                                    <img src = "/static/Saved 20 Pounds.png" alt='Saved 20 Pounds'>
                                <?php } else { ?>
                                    <img src = "/static/Saved 20 Pounds.png" alt='Saved 20 Pounds' class='blackandwhite'>
                                <?php } ?>
                                
                            </div>
                            <div class = "row-xs-2" style='height: 5.5em; width: 5em;'>
                                <p>Saved 20 Pounds</p>
                            </div>
                            <?php
                            }
                            else 
                            {?>
                                <div class="row-xs-2">
                                    <div class='rectangle_grey'></div>
                                </div>
                                <br>

                            <?php
                            }
                            ?>
                            
                             <?php
                            if($user_group_number == $main_group)
                            {?>
                            
                            <!-- Saved 50 Pounds -->
                            <div class="row-xs-2" style='height: 5.5em; width: 5em;'>
                                <?php if(intval($result['total_savings'] >= 50))
                                { ?>
                                    <img src = "/static/Saved 50 Pounds.png" alt='Saved 50 Pounds'>
                                <?php } else { ?>
                                    <img src = "/static/Saved 50 Pounds.png" alt='Saved 50 Pounds' class='blackandwhite'>
                                <?php } ?>
                                
                            </div>
                            <div class = "row-xs-2" style='height: 5.5em; width: 5em;'>
                                <p>Saved 50 Pounds</p>
                            </div>
                            <?php
                            }
                            else 
                            {?>
                                <div class="row-xs-2">
                                    <div class='rectangle_grey'></div>
                                </div>
                                <br>

                            <?php
                            }
                            ?>
                            
                             <?php
                            if($user_group_number == $main_group)
                            {?>
                              <!-- Saved 100 Pounds -->
                            <div class="row-xs-2" style='height: 5.5em; width: 5em;'>
                                 <?php if(intval($result['total_savings'] >= 100))
                                { ?>
                                    <img src = "/static/Saved 100 Pounds.png" alt='Saved 100 Pounds'>
                                <?php } else { ?>
                                    <img src = "/static/Saved 100 Pounds.png" alt='Saved 100 Pounds' class='blackandwhite'>
                                <?php } ?>
                            </div>
                            <div class = "row-xs-2" style='height: 5.5em; width: 5em;'>
                                <p>Saved 100 Pounds</p>
                            </div>
                             <?php
                            }
                            else 
                            {?>
                                <div class="row-xs-2">
                                    <div class='rectangle_green'></div>
                                </div>
                                <br>

                            <?php
                            }
                            ?>
                            
                            
                            
                        </div>
                    </div> <!-- End of saving amounts column -->

                    
                </div> <!-- End of Row -->
            </div> <!-- End of Container -->   
        
        </div> <!-- End of Badges column -->


    </div> <!-- End of row -->
    
    
    <br><br>
    <h3><a href="logout.php">Logout</a></h3>
    </div>
</body>
</html>