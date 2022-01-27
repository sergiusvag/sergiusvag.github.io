<?php

	require_once '../includes/connect.php';

	session_start();
	if(!$_SESSION["gameUser"]) {
		header("Location: ../index.php");
	}

    $id = $_SESSION["gameUser"]["id"];

    $min = 10000;
    $max = 99999;

    do {
        $gameId = rand($min, $max);
        $lookForId = mysqli_query($connection, "SELECT * FROM `users` WHERE `gameId` = '$gameId'");
    } while (mysqli_num_rows($lookForId) > 0);

    $setId = mysqli_query($connection, "UPDATE `users` SET `gameId` = '$gameId' WHERE `users`.`id` = $id");


    if ($setId) {
        $updatedUser = mysqli_query($connection, "SELECT * FROM `users` WHERE `id` = '$id'");
        if($updatedUser) {
            $updatedUser = mysqli_fetch_assoc($updatedUser);
            $_SESSION["gameUser"] = $updatedUser;
        } else {
            $_SESSION["logMessage"] = "Ошибка в обновление пользователя";
        }
        header("Location: ../online/room.php");
    }
?>