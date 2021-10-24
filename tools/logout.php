<?php 
    session_start();
    unset($_SESSION['session_user']);
    session_destroy();
    header("Location: ../index.php");
?>