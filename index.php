<?php
include 'tools/functions.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>beVote ®</title>
        <link rel="stylesheet" href="css/index.css">
        <link rel="icon" href="img/icon.png" type="image/png">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </head>
    <body>
        <?php 
            if(isset($_POST["submit"])) {
                if(!empty($_POST["nickname"]) && !empty($_POST["password"])) {
                    $user = $_POST["nickname"];
                    $pass = $_POST["password"];

                    $connectdb = connectDB();

                    $query = "SELECT nickname,password FROM users WHERE nickname='${user}'";

                    if ($stmt = $connectdb->prepare($query)) {

                        $stmt->execute();
                        $stmt->bind_result($nickname, $password_hashed);
                    
                        while ($stmt->fetch()) {
                            $nickname = $nickname;
                            $password_hashed = $password_hashed;
                        }
                        $stmt->close();
                    }
                    $verifyPass = password_verify($pass, $password_hashed);

                    if ($user == $nickname && $verifyPass === true) {
                        session_start();
                        $_SESSION['session_user'] = $user;

                        header("Location: main.php");
                    } else {
                        $error_text = "** You have to submit an existing username/password! **";
                    }
                } else {
                    $error_text = "** You should write your username/password! **";
                }
            }
        ?>
        <main>
            <section class="sidebar">
                <div class="logint">
                    <h1 id="login_title">Login Panel</h1>
                    <div id ="line"></div>
                </div>
                <form method="post" class="form">
                    <input type="text" id="nickname" name="nickname" class="btn" placeholder="nickname"><br>
                    <input type="password" id="password" name="password" class="btn" placeholder="password"><br>
                    <input type="submit" class="btn" id="Submit_form" value="Login" name="submit">
                </form>
                <div class="form">
                    <input type="submit" class="btn" id="Submit_form" value="Register Now!" name="register" onClick="window.location.href='tools/register.php'">
                </div>
                <p name="error_text" id="error_text">
                <?php 
                if (!empty($error_text)) {
                    echo $error_text;
                } else {
                    echo "";
                } 
                ?>
                </p>
            </section>
        </main>
        <?php 
            // mysqli_close($connectdb);
        ?>
    </body>
</html>