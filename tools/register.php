<?php
include '../tools/functions.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>beVote ®</title>
        <link rel="stylesheet" href="../css/register.css">
        <link rel="icon" href="img/icon.png" type="image/png">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script type="text/javascript" src="../js/main.js"></script>
    </head>
    <body>
        <?php 
            if(isset($_POST["submit"])) {
                if($_POST["password"] == $_POST["password2"]) {
                    
                    $user = $_POST["nickname"];
                    $pass = $_POST["password"];
                    $mail = $_POST["email"];

                    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

                    $connectdb = connectDB();

                    $result = $connectdb->query("SELECT * FROM users WHERE nickname='${user}'");  
                    $number_of_result = mysqli_num_rows($result); 

                    if (!$number_of_result) {
                        $result2 = $connectdb->query("SELECT * FROM users WHERE email='${mail}'");  
                        $number_of_result2 = mysqli_num_rows($result2); 

                        if (!$number_of_result2) {
                            if ($connectdb->query("INSERT INTO users (nickname, password, email) VALUES ('${user}', '$hashed_password', '${mail}')") === TRUE) {
                                header("Location: ../index.php");
                            } else {
                                $error_text = "** Error, try to register again! **";
                            } 
                        } else {
                            $error_text = "** Your email already exists! **";
                        }
                    } else {
                        $error_text = "** Your nickname already exists! **";
                    }

                    mysqli_close($connectdb);
                } else {
                    $error_text = "** Both password must match! **";
                };
            };

        ?>
        <main>
            <section class="sidebar">
                <div class="logint">
                    <h1 id="login_title">Register Panel</h1>
                    <div id ="line"></div>
                </div>
                <form method="post" class="form">
                    <input type="text" id="nickname" name="nickname" class="btn" placeholder="nickname" required><br>
                    <input type="password" id="password" name="password" class="btn" placeholder="password" required onkeyup="checkMatch();"><br>
                    <input type="password" id="password2" name="password2" class="btn" placeholder="repeat password" required onkeyup="checkMatch();"> <br>
                    <input type="email" id="email" name="email" class="btn" placeholder="email" required><br>
                    <input type="submit" class="btn" id="Submit_form" value="Register" name="submit">
                </form>
                <p name="error_text" id="error_text">
                <div class="form">
                    <input type="submit" class="btn" id="Submit_form" value="Back to main page!" name="mainpage" onClick="window.location.href='../index.php'">
                </div>
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


        
        ?>
    </body>
</html>