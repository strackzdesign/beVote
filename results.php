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
        <link rel="stylesheet" href="css/results.css">
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
                <div class="votes">
                    <?php 
                        $connectdb = connectDB();

                        $query = "SELECT * FROM votes";  
                        $result = mysqli_query($connectdb, $query);  
                        $number_of_result = mysqli_num_rows($result);  

                        if ($number_of_result > 0) {
                            while($row = mysqli_fetch_array($result)) { 
                    
                                echo "<div class='radiodiv'>";
                                    echo "<div class='rad-label'>";
                                        echo "<p class='rad-text'>". $row['nickname'] ." ( ". $row['numvotes'] ." )</p>";
                                        echo "<br>";
                                echo "</div>";
                            }
                        } else {
                            echo "0 results";
                        }
                        mysqli_close($connectdb);
                    ?>
                    </div>
                <?php 
                if (!empty($error_text)) {
                    echo $error_text;
                } else {
                    echo "";
                } 
                ?>
                </p>

                <div class="line2">
                    <div id ="line"></div>
                </div>
                <div class="lastmenu">
                    <h3 id="home"><a href="main.php">Home</a></h3>
                    <h3 id="logout"><a href="tools/logout.php">Logout</a></h3>
                </div>
                <p name="error_text" id="error_text">
            </div>
            </div>
        </main>
    </body>
</html>
<?php
    }
?>