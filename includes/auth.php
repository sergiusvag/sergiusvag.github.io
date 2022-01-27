<?php

	require_once '../includes/connect.php';

    $login = $_POST["login"];
    $password = $_POST["password"];

    $user = mysqli_query($connection, "SELECT * FROM `admins` WHERE `login` = '$login' AND `password` = '$password'");

    if(mysqli_num_rows($user) > 0) {
        $user = mysqli_fetch_assoc($user);
        session_start();
        $_SESSION["user"] = $user;
        $_SESSION["questionId"] = 0;
        header("Location: ../admin/index.php");
    } else {
        header("Location: ../admin/login.php");
    }
?>