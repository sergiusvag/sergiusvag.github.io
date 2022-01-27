<?php

	require_once '../includes/connect.php';

    session_start();
	
	if(!$_SESSION["gameUser"]) {
		header("Location: ../index.php");
	}

    $newAnswerState = "0000";
    $answerIndex = (int)($_POST["answerIndex"]);
    $gameId = $_SESSION["gameUser"]["gameId"];
    if ($answerIndex == 1) {
        $newAnswerState = "0100";
    }
    $newAnswerState[$answerIndex] = "1";

    $updateQuizState = mysqli_query($connection, "UPDATE `quizstate` SET `answerState` = '$newAnswerState' WHERE `quizstate`.`gameId` = $gameId");

    header("Location: ../online/game-waiting-room.php");
?>