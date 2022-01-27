<?php

	require_once '../includes/connect.php';

    $login = $_POST["login"];
    $password = $_POST["password"];
    $passwordRepeat = $_POST["password-repeat"];
    $email = $_POST["email"];

    $id = 1;
    $user = mysqli_query($connection, "SELECT * FROM `users` WHERE `login` = '$login'");

    $errorString = "?usedLogin=$login&usedEmail=$email";
    if($password != $passwordRepeat) {
        // errorIndex=1 = "Пароли не совпадают";
        $errorString = $errorString . "&errorIndex=1";
    } else if ($password == "") {
        // errorIndex=2 = ""Ошибка: Пароль пуст"";
        $errorString = $errorString . "&errorIndex=2";
    } else if(mysqli_num_rows($user) > 0) {
        // errorIndex=3 = "Такой пользователь уже существует";
        $errorString = $errorString . "&errorIndex=3";
    } else {
        do {
            $id += 1;
            $idRowSql = mysqli_query($connection, "SELECT * FROM `users` WHERE id = '$id'");
        } while (mysqli_num_rows($idRowSql) > 0);

        $newuser = mysqli_query($connection, 
        "INSERT INTO `users` (`id`, `login`, `password`, `email`, `gameId`, `opLogin`) 
         VALUES ('$id', '$login', '$password', '$email', '0' , '0')");

        $newuser = mysqli_query($connection, "SELECT * FROM `users` WHERE `login` = '$login'");
        if($newuser) {
            $newuser = mysqli_fetch_assoc($newuser);
            session_start();
            $_SESSION["gameUser"] = $newuser;
            header("Location: ../logged-in-game.php");
        } else {
            // errorIndex=4 = "Ошибка в создание пользователя";
            $errorString = $errorString . "&errorIndex=4";
        }
    }
    header("Location: ../user/register.php$errorString");
?>