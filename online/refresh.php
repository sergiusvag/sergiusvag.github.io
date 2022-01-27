<?php

    require_once '../includes/connect.php';
    
    session_start();
	if(!$_SESSION["gameUser"]) {
		header("Location: ../index.php");
	}
    $id = $_SESSION["gameUser"]["id"];
    $login = $_SESSION["gameUser"]["login"];
    $userRow = mysqli_query($connection, "SELECT * FROM `users` WHERE `id` = '$id'");

    
    if($userRow) {
        $user = mysqli_fetch_assoc($userRow);
        $_SESSION["gameUser"] = $user;
    }

    if($_SESSION["gameUser"]["opLogin"] != "0" ) {
        $deleteFromChat = mysqli_query($connection, "DELETE FROM `chat_logedchatters` WHERE `chat_logedchatters`.`login` = '$login'");
        print "<script>document.location.href='/online/index.php'; </script>";
    }

?>