<?php

	require_once '../includes/connect.php';

	session_start();
	
    $id = $_SESSION["gameUser"]["id"];
	$myLogin = $_SESSION["gameUser"]["login"];
	$opLogin = $_SESSION["gameUser"]["opLogin"];
	$gameId = $_SESSION["gameUser"]["gameId"];
	
	$lookForId = mysqli_query($connection, "SELECT * FROM `users` WHERE `login` = '$opLogin'");

	$opUser = mysqli_fetch_assoc($lookForId);
	$opId = $opUser["id"];
    $setOpGameId = mysqli_query($connection, "UPDATE `users` SET `gameId` = '0' WHERE `users`.`id` = $opId");
    $setOpOpLogin = mysqli_query($connection, "UPDATE `users` SET `opLogin` = '0' WHERE `users`.`id` = $opId");
    $setMyGameId = mysqli_query($connection, "UPDATE `users` SET `gameId` = '0' WHERE `users`.`id` = $id");
    $setMyOpLogin = mysqli_query($connection, "UPDATE `users` SET `opLogin` = '0' WHERE `users`.`id` = $id");
	$deleteMySettings = mysqli_query($connection, "DELETE FROM `gamesettings` WHERE `gamesettings`.`login` = '$myLogin'");
	$deleteOpSettings = mysqli_query($connection, "DELETE FROM `gamesettings` WHERE `gamesettings`.`login` = '$opLogin'");
	$deleteGameWindowStatus = mysqli_query($connection, "DELETE FROM `gamewindowstatus` WHERE `gamewindowstatus`.`gameId` = $gameId");
	$deleteGameState = mysqli_query($connection, "DELETE FROM `gamestate` WHERE `gamestate`.`gameId` = $gameId");
	$deleteQuizState = mysqli_query($connection, "DELETE FROM `quizstate` WHERE `quizstate`.`gameId` = $gameId");
	$deleteMyPlayAgain = mysqli_query($connection, "DELETE FROM `playagain` WHERE `playagain`.`login` = $myLogin");
	$deleteOpPlayAgain = mysqli_query($connection, "DELETE FROM `playagain` WHERE `playagain`.`login` = $opLogin");


	unset($_SESSION["gameUser"]);
    header("Location: /index.php");
?>