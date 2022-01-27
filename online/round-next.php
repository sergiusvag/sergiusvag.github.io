<?php

	require_once '../includes/connect.php';

    session_start();
	
	if(!$_SESSION["gameUser"]) {
		header("Location: ../index.php");
	}

    $gameId = $_SESSION["gameUser"]["gameId"];
    $isCorrect = $_POST["isCorrect"];
    if($isCorrect == "Верно") {
        $isCorrect = true;
    } else {
        $isCorrect = false;
    }
    
    $gameState = mysqli_query($connection, "SELECT * FROM `gamestate` WHERE `gameId` = '$gameId'");
	$gameState = mysqli_fetch_assoc($gameState);

     

    $quizState = mysqli_query($connection, "SELECT * FROM `quizstate` WHERE `gameId` = '$gameId'");
	$quizState = mysqli_fetch_assoc($quizState);

    $cellIndex = $quizState["cellIndex"];
    $cellsState = $gameState["cellsState"];
    $playerOneScore = $gameState["playerOneScore"];
    $playerTwoScore = $gameState["playerTwoScore"];
    $playerOneBonusScore = $gameState["playerOneBonusScore"];
    $playerTwoBonusScore = $gameState["playerTwoBonusScore"];


    $isAllAnswered = true;
    if($gameState["playerOne"] == $gameState["curPlayer"]) {
        $curPlayer = $gameState["playerOne"];
        $nextPlayer = $gameState["playerTwo"];
        $newCellState = "1";

        
        if ($isCorrect) {
            $playerOneScore = $playerOneScore + 1;
            $cellsState[$cellIndex] = $newCellState;
            var_dump($playerOneScore);
            //check if all cells answered
            for ($i = 0; $i < 9; $i++) {
                if($cellsState[$i] == '0') {
                    $isAllAnswered = false;
                }
            }
        }
    } else {
        $curPlayer = $gameState["playerTwo"];
        $nextPlayer = $gameState["playerOne"];
        $newCellState = "2";

        if ($isCorrect) {
            $playerTwoScore = $playerTwoScore + 1;
            $cellsState[$cellIndex] = $newCellState;
    
            //check if all cells answered
            for ($i = 0; $i < 9; $i++) {
                if($cellsState[$i] == '0') {
                    $isAllAnswered = false;
                }
            }
        }
    }
    
    if (!$isCorrect) {
        $isAllAnswered = false;
    }

    $roundNumber = $gameState["roundNumber"];
    $roundBoard = "";
    if($isAllAnswered) {

        //check all three in a row for bonus score
        // 012 345 678, 036 147 258, 048 246
        // rows 012 345 678
        if ($cellsState[0] == $cellsState[1] && $cellsState[0] == $cellsState[2]) {
            if ($cellsState[0] == '1') {
                $playerOneBonusScore++;
            } else {
                $playerTwoBonusScore++;
            }
        }
        if ($cellsState[3] == $cellsState[4] && $cellsState[3] == $cellsState[5]) {
            if ($cellsState[3] == '1') {
                $playerOneBonusScore++;
            } else {
                $playerTwoBonusScore++;
            }
        }
        if ($cellsState[6] == $cellsState[7] && $cellsState[6] == $cellsState[8]) {
            if ($cellsState[6] == '1') {
                $playerOneBonusScore++;
            } else {
                $playerTwoBonusScore++;
            }
        }
        // columns 036 147 258
        if ($cellsState[0] == $cellsState[3] && $cellsState[0] == $cellsState[6]) {
            if ($cellsState[0] == '1') {
                $playerOneBonusScore++;
            } else {
                $playerTwoBonusScore++;
            }
        }
        if ($cellsState[1] == $cellsState[4] && $cellsState[1] == $cellsState[7]) {
            if ($cellsState[1] == '1') {
                $playerOneBonusScore++;
            } else {
                $playerTwoBonusScore++;
            }
        }
        if ($cellsState[2] == $cellsState[5] && $cellsState[2] == $cellsState[8]) {
            if ($cellsState[2] == '1') {
                $playerOneBonusScore++;
            } else {
                $playerTwoBonusScore++;
            }
        }
        // diagonal 048 246
        if ($cellsState[0] == $cellsState[4] && $cellsState[0] == $cellsState[8]) {
            if ($cellsState[0] == '1') {
                $playerOneBonusScore++;
            } else {
                $playerTwoBonusScore++;
            }
        }
        if ($cellsState[2] == $cellsState[4] && $cellsState[2] == $cellsState[6]) {
            if ($cellsState[2] == '1') {
                $playerOneBonusScore++;
            } else {
                $playerTwoBonusScore++;
            }
        }

        $cellsState = "000000000";
        $roundNumber++;
        $roundBoard = "active";
    }

    echo $cellsState;
    $updateGameState = mysqli_query($connection, 
                                    "UPDATE `gamestate` 
                                    SET `curPlayer` = '$nextPlayer', 
                                    `playerOneScore` = '$playerOneScore', 
                                    `playerOneBonusScore` = '$playerOneBonusScore',
                                    `playerTwoScore` = '$playerTwoScore', 
                                    `playerTwoBonusScore` = '$playerTwoBonusScore',
                                    `cellsState` = '$cellsState',
                                    `roundNumber` = '$roundNumber'
                                    WHERE `gamestate`.`gameId` = $gameId");
    $updateQuizState = mysqli_query($connection, "UPDATE `quizstate` SET `cellIndex` = -1, `answerState` = '0000' WHERE `quizstate`.`gameId` = $gameId");


    $updateGameWindowStatus = mysqli_query($connection, 
    "UPDATE `gamewindowstatus` 
    SET `quiz` = '', `roundBoard` = '$roundBoard', `answer` = '' 
    WHERE `gamewindowstatus`.`gameId` = $gameId");

    header("Location: ../online/game-waiting-room.php");
?>