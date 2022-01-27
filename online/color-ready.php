<?php

	require_once '../includes/connect.php';

    
    session_start();
	if(!$_SESSION["gameUser"]) {
		header("Location: ../index.php");
	}
    $login = $_POST["login"];

    $mySettings = mysqli_query($connection, "SELECT * FROM `gamesettings` WHERE `login` = '$login'");

    $mySettings = mysqli_fetch_assoc($mySettings);

    if ($mySettings["isReady"] == 1) {
        $readyState = 0;
    } else if ($mySettings["isReady"] ==0) {
        $readyState = 1;
    }

    $updateSettings = mysqli_query($connection, 
    "UPDATE `gamesettings` SET `isReady` = '$readyState' WHERE `gamesettings`.`login` = '$login';");

    
    header("Location: /online/index.php");
?>