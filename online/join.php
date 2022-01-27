<?php

	require_once '../includes/connect.php';

	session_start();
	
	if(!$_SESSION["gameUser"]) {
		header("Location: ../index.php");
	}
    $id = $_SESSION["gameUser"]["id"];
    $gameId = $_POST["room-id"];
    $login = $_SESSION["gameUser"]["login"];
	// $opLogin = $_SESSION["gameUser"]["opLogin"];
	
    $lookForId = mysqli_query($connection, "SELECT * FROM `users` WHERE `gameId` = '$gameId'");
    $deleteFromChat = mysqli_query($connection, "DELETE FROM `chat_logedchatters` WHERE `chat_logedchatters`.`login` = '$login'");
    
    if (mysqli_num_rows($lookForId) == 1) {
        $opUser = mysqli_fetch_assoc($lookForId);
        if($opUser["login"] != $_SESSION["gameUser"]["login"]) {
            
            $opId = $opUser["id"];
            $opLogin = $opUser["login"];
            
            $setOpGameId = mysqli_query($connection, "UPDATE `users` SET `opLogin` = '$login' WHERE `users`.`id` = $opId");
            $setMyOpLogin = mysqli_query($connection, "UPDATE `users` SET `opLogin` = '$opLogin' WHERE `users`.`id` = $id");
            $setMyGameId = mysqli_query($connection, "UPDATE `users` SET `gameId` = '$gameId' WHERE `users`.`id` = $id");

            $updatedUser = mysqli_query($connection, "SELECT * FROM `users` WHERE `id` = '$id'");
            if($updatedUser) {
                $updatedUser = mysqli_fetch_assoc($updatedUser);
                $_SESSION["gameUser"] = $updatedUser;
            }

            // id, gameId, player, turn, color, score, threeScore
            // Set game settings
            $mySettingsId = 0;
            $opSettingsId = 0;
            do {
                $mySettingsId += 1;
                $lookForEmpty = mysqli_query($connection, "SELECT * FROM `gamesettings` WHERE `id` = '$mySettingsId'");
            } while (mysqli_num_rows($lookForEmpty) > 0);
            
            $opSettingsId = $mySettingsId;
            do {
                $opSettingsId += 1;
                $lookForEmpty = mysqli_query($connection, "SELECT * FROM `gamesettings` WHERE `id` = '$opSettingsId'");
            } while (mysqli_num_rows($lookForEmpty) > 0);

            $setMySettings = mysqli_query($connection, 
            "INSERT INTO `gamesettings` (`id`, `gameId`, `login`, `turn`, `color`, `isReady`) 
            VALUES ('$mySettingsId', '$gameId', '$login', '2', '0', '0')");

            $setOpSettings = mysqli_query($connection, 
            "INSERT INTO `gamesettings` (`id`, `gameId`, `login`, `turn`, `color`, `isReady`) 
            VALUES ('$opSettingsId', '$gameId', '$opLogin', '1', '0', '0')");

            header("Location: /online/index.php");
        }
    } 
    header("Location: /online/room.php");

?>