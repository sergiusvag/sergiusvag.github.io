<?php

	require_once '../includes/connect.php';

    $login = $_POST["login"];
    $password = $_POST["password"];

    $user = mysqli_query($connection, "SELECT * FROM `users` WHERE `login` = '$login'");
    if(mysqli_num_rows($user) < 1) {
        // errorIndex=1 = "Ошибка: Пользователь не существует";
        header("Location: ../user/login.php?errorIndex=1");
        exit();
    } else {

        $user = mysqli_query($connection, "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");

        if(mysqli_num_rows($user) > 0) {
            $user = mysqli_fetch_assoc($user);
            session_start();
            $_SESSION["gameUser"] = $user;
            header("Location: ../logged-in-game.php");
        } else {
            // errorIndex=2 = "Ошибка: не верный пароль";
            header("Location: ../user/login.php?usedLogin=$login&errorIndex=2");
        }
    }

?>