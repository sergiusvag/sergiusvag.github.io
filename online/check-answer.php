<?php

	require_once '../includes/connect.php';

    session_start();
	
	if(!$_SESSION["gameUser"]) {
		header("Location: ../index.php");
	}



    $gameId = $_SESSION["gameUser"]["gameId"];

    $updateGameWindowState = mysqli_query($connection, "UPDATE `gamewindowstatus` SET `quiz` = '', `answer` = 'active' WHERE `gamewindowstatus`.`gameId` = $gameId");

    // $updateQuizState = mysqli_query($connection, "UPDATE `quizstate` SET `answerState` = '0000' WHERE `quizstate`.`gameId` = $gameId");

    header("Location: ../online/game-waiting-room.php");
?>