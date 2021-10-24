<?php 
    session_start();
    if(!isset($_SESSION['session_user'])) {
        header("Location: index.php");
    } else {
        $user_name = $_SESSION['session_user'];

       include 'tools/functions.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>beVote ®</title>
        <link rel="stylesheet" href="css/main.css">
        <link rel="icon" href="img/icon.png" type="image/png">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script type="text/javascript" src="js/main.js"></script>
    </head>
    <body>
        <main>
            <div class="sidemain">
            <div class="sidebar">
                <div class="logint">
                    <h1 id="login_title"><?=$_SESSION['session_user']."<br>";?></h1>
                    <h1 id="login_rank">
                        <?php 
                        if (checkAdmin($user_name)) {
                            echo "[ ADMINISTRATOR ]";
                        };
                        ?>
                    </h1>
                    <div id ="line"></div>
                </div>
                <form class="votes" method='post'>
                    <?php 
                        $connectdb = connectDB();

                        $query = "SELECT * FROM votes";  
                        $result = mysqli_query($connectdb, $query);  
                        $number_of_result = mysqli_num_rows($result);  

                        if ($number_of_result > 0) {
                            while($row = mysqli_fetch_array($result)) { 

                                echo "<div class='radiodiv'>";
                                    echo "<label class='rad-label'>";
                                        echo    "<input type='radio' class='rad-input' name='radiocheck' value='". $row['nickname'] ."'>";
                                        echo    "<div class='rad-design'></div>";
                                        echo    "<div class='rad-text'>". $row['nickname'] ."</div>";
                                    echo "</label>";
                                echo "</div>";
                            }
                        } else {
                            echo "0 results";
                        }
                        mysqli_close($connectdb);
                    ?>
                    <input type='submit' class="btn" id="Submit_form" value="VOTE" name="submitradio">
                </form>
                <?php 
                if(isset($_POST["submitradio"])) {
                    if(!empty($_POST['radiocheck'])) {
                        $connectdb = connectDB();
                        $name = $_POST['radiocheck'];
                        
                        $query_vote_status = "SELECT * FROM users WHERE nickname='${user_name}'";  
                        $result_vote_status = mysqli_query($connectdb, $query_vote_status); 
                        $num_result = mysqli_num_rows($result_vote_status);  

                        if ($num_result > 0) {
                            while($row = mysqli_fetch_array($result_vote_status)) { 
                                if ($row['vote'] == 0) {
                                    $query_vote_update = "UPDATE `votes` SET numvotes = numvotes + 1 WHERE nickname='${name}'";  
                                    $result_vote_update = mysqli_query($connectdb, $query_vote_update); 

                                    $query_vote_status_update = "UPDATE `users` SET vote = 1 WHERE nickname='${user_name}'";  
                                    $result_vote_status_update = mysqli_query($connectdb, $query_vote_status_update); 

                                    header('Location: results.php');
                                } else {
                                    $error_text = "You've already voted, you can't vote twice!";
                                }
                            }
                        } else {
                            echo "0 results";
                        }
                        
                    

                        mysqli_close($connectdb);
                    } else {
                        $error_text = "You need to select someone to vote!";
                    }
                } 

                if (checkAdmin($user_name)) { ?>
                <div class="line3">
                    <div id ="line"></div>
                </div>
                <form class="addCandidate" method='post'>
                    <input type="text" id="candidate" name="candidate" class="btn" placeholder="candidate name"><br>
                    <div class="btn2main">
                        <input type="submit" class="btn2 btn2add" id="Submit_form" value="ADD" name="submitcandidate">
                        <input type="submit" class="btn2 btn2remove" id="Submit_form" value="REMOVE" name="removecandidate">
                    </div>
                </form>
                <?php } ?>

                <div class="line2">
                    <div id ="line"></div>
                </div>
                <div class="lastmenu">
                    <h3 id="results"><a href="results.php">Results</a></h3>
                    <h3 id="logout"><a href="tools/logout.php">Logout</a></h3>
                </div>
                <p name="error_text" id="error_text">

                <?php 
                if (isset($_POST['submitcandidate'])) {
                    if(!empty($_POST['candidate'])) {
                        $connectdb = connectDB();
                        $candidate = $_POST['candidate'];

                        $query_add_candidate = "INSERT INTO `votes` (nickname) VALUES ('${candidate}')";  
                        $result_add_candidate = mysqli_query($connectdb, $query_add_candidate);

                        header("Refresh:0");
                        mysqli_close($connectdb);
                    } else {
                        $error_text = "You should write a name";
                    }
                }

                if (isset($_POST['removecandidate'])) {
                    if(!empty($_POST['candidate'])) {
                        $connectdb = connectDB();
                        $candidate = $_POST['candidate'];

                        $query_remove_candidate = "DELETE FROM `votes` WHERE nickname='${candidate}'";  
                        $result_remove_candidate = mysqli_query($connectdb, $query_remove_candidate);

                        header("Refresh:0");
                        mysqli_close($connectdb);
                    } else {
                        $error_text = "You should write a name";
                    }
                }

                if (!empty($error_text)) {
                    echo $error_text;
                } else {
                    echo "";
                } 
                ?>
                </p>
            </div>
            </div>
        </main>
    </body>
</html>
<?php
    }
?>