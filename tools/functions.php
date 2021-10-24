<?php
    function connectDB() {
        $connectdb = new mysqli("localhost", "root", null, "bevote");

        if ($connectdb -> connect_errno) {
            echo "Connection Failed: " . $connectdb -> connect_error;
            exit();
        } else {
            return $connectdb;
        }
        mysqli_close($connectdb);
    };

    function checkAdmin($user) {
        $connectdb = connectDB();

        if(!$connectdb) {
            echo "Connection Failed";
        } else {
            if ($stmt = $connectdb->prepare("SELECT `group` FROM users WHERE nickname='$user'")) {

                $stmt->execute();
                $stmt->bind_result($group);
            
                while ($stmt->fetch()) {
                    $group = $group;
                }

                if ($group == "admin") {
                    return true;
                } else {
                    return false;
                }
                $stmt->close();
            }
        }
        mysqli_close($connectdb);
    };
?>