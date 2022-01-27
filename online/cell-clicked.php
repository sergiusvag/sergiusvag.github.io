<?php

	require_once '../includes/connect.php';

    session_start();
	
	if(!$_SESSION["gameUser"]) {
		header("Location: ../index.php");
	}

    $cellIndex = $_POST["cellIndex"];

    $gameId = $_SESSION["gameUser"]["gameId"];
    $updateQuizState = mysqli_query($connection, "UPDATE `quizstate` SET `cellIndex` = $cellIndex WHERE `quizstate`.`gameId` = $gameId");

    // $_SESSION["cellIndex"] = $cellIndex;
    $updateBoard = mysqli_query($connection, "UPDATE `gamewindowstatus` SET `quiz` = 'active' WHERE `gamewindowstatus`.`gameId` = $gameId");
    header("Location: ../online/game-waiting-room.php");
?>