<?php

    require_once '../includes/connect.php';
    
    session_start();
	if(!$_SESSION["gameUser"]) {
        print "<script>document.location.href='../index.php'; </script>";
	} else {
        $id = $_SESSION["gameUser"]["id"];
        $user = mysqli_query($connection, "SELECT * FROM `users` WHERE `id` = '$id'");
        $user = mysqli_fetch_assoc($user);
        $_SESSION["gameUser"] = $user;
        if($_SESSION["gameUser"]["opLogin"] == "0") {
            print "<script>document.location.href='../index.php'; </script>";
        } else {
            print "<script>document.location.href='/online/game-waiting-room.php'; </script>";
        }
    }

?>