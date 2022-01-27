<?php

    $connection = new mysqli("localhost", "root", "", "xobible");

    if($connection->connect_error) {
        exit('Could not connect');
    }

	session_start();
    $login = $_SESSION["gameUser"]["login"];

    $allMyUserRows = mysqli_query($connection, "SELECT * FROM `chat_logedchatters` WHERE `login` = '$login'");
 
    if(mysqli_num_rows($allMyUserRows) < 1) {
        $addUser = mysqli_query($connection, "INSERT INTO `chat_logedchatters` (`id`, `login`) VALUES (NULL, '$login');");
    } 
?>