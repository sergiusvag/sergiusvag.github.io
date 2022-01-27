<?php

	require_once '../includes/connect.php';

    
    session_start();
	if(!$_SESSION["gameUser"]) {
		header("Location: ../index.php");
	}
    $settingsId = $_POST["settingsId"];
    $opLogin = $_POST["opLogin"];
    $color = $_POST["color"];
    $allowed = $_POST["allowed"];

    if ($allowed == "true") {


        $opSettings = mysqli_query($connection, "SELECT * FROM `gamesettings` WHERE `login` = '$opLogin'");

        $opSettings = mysqli_fetch_assoc($opSettings);

        if ($color != $opSettings["color"]) {
            $updateSettings = mysqli_query($connection, "UPDATE `gamesettings` SET `color` = '$color' WHERE `gamesettings`.`id` = $settingsId;");
        }
	   
    }
    
    header("Location: /online/index.php");
?>