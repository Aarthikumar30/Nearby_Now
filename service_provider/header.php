<?php
    session_name('nearby'); 
    session_start();
    include "config.php";

    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }

    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
    $user_role = $_SESSION['role'];
    $level = $_SESSION['level'];

    if ($level == 1){
        $role = "Admin";
    } elseif ($level == 2){
        $role = "Provider";
    } elseif ($level == 3){
        $role = "User";
    }
?>


