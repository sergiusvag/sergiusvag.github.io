<?php

    require_once '../includes/connect.php';
        
    session_start();
    if(!$_SESSION["gameUser"]) {
        header("Location: ../index.php");
    }

    $gameId = $_SESSION["gameUser"]["gameId"];

    $updateGameWindowStatus = mysqli_query($connection, "UPDATE `gamewindowstatus` SET `quiz` = '', `roundBoard` = '', `answer` = '' WHERE `gamewindowstatus`.`gameId` = $gameId");

    header("Location: /online/game-waiting-room.php");
    exit();
?>