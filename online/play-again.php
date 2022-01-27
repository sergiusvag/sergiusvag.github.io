<?php

    require_once '../includes/connect.php';

    session_start();

    if(!$_SESSION["gameUser"]) {
        header("Location: ../index.php");
    }

    //set ready
    $login = $_SESSION["gameUser"]["login"];

    $playAgainSettings = mysqli_query($connection, "SELECT * FROM `playagain` WHERE `login` = '$login'");

    $playAgainSettings = mysqli_fetch_assoc($playAgainSettings);

    if ($playAgainSettings["isReady"] == 1) {
        $readyState = 0;
    } else {
        $readyState = 1;
    }

    $updateSettings = mysqli_query($connection, 
    "UPDATE `playagain` SET `isReady` = '$readyState' WHERE `playagain`.`login` = '$login';");
    
    header("Location: /online/game-waiting-room.php");
?>