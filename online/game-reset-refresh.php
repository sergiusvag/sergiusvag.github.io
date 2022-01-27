<?php

    require_once '../includes/connect.php';

    session_start();

    if(!$_SESSION["gameUser"]) {
        header("Location: ../index.php");
    }
    $user = $_SESSION["gameUser"];
    $login = $_SESSION["gameUser"]["login"];
    $opUserLogin = $_SESSION["gameUser"]["opLogin"];
    $gameId = $_SESSION["gameUser"]["gameId"];
            
    $myPlayAgainSettings = mysqli_query($connection, "SELECT * FROM `playagain` WHERE `login` = '$login'");
    $myPlayAgainSettings = mysqli_fetch_assoc($myPlayAgainSettings);
    $isMeReady = $myPlayAgainSettings["isReady"] == 1;
    $opPlayAgainSettings = mysqli_query($connection, "SELECT * FROM `playagain` WHERE `login` = '$opUserLogin'");
    $opPlayAgainSettings = mysqli_fetch_assoc($opPlayAgainSettings);
    $isOpReady = $opPlayAgainSettings["isReady"] == 1;

    //if both ready, reset game
    if($isMeReady && $isOpReady) {
        $updateQuizState = mysqli_query($connection, "UPDATE `quizstate` SET `cellIndex` = -1, `answerState` = '0000' WHERE `quizstate`.`gameId` = $gameId");
        $updateBoard = mysqli_query($connection, "UPDATE `gamewindowstatus` SET `quiz` = '', `roundBoard` = 'active', `answer` = '' WHERE `gamewindowstatus`.`gameId` = $gameId");

        $updateGameState = mysqli_query($connection, 
        "UPDATE `gamestate` 
        SET `curPlayer` = '$login', 
        `playerOneScore` = 0, 
        `playerOneBonusScore` = 0,
        `playerTwoScore` = 0, 
        `playerTwoBonusScore` = 0,
        `cellsState` = '000000000',
        `roundNumber` = 1
        WHERE `gamestate`.`gameId` = $gameId");

        
        $updateSettings = mysqli_query($connection, 
        "UPDATE `playagain` SET `isReady` = 0 WHERE `playagain`.`login` = '$login';");
        $updateSettings = mysqli_query($connection, 
        "UPDATE `playagain` SET `isReady` = 0 WHERE `playagain`.`login` = '$opUserLogin';");
    }

    
    print "<script>document.location.href='/online/game-waiting-room.php'; </script>";
?>