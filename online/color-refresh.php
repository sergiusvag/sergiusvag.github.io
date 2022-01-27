<?php

	require_once '../includes/connect.php';

    session_start();
    $_SESSION["cellIndex"] = -1;
	if(!$_SESSION["gameUser"]) {
		header("Location: ../index.php");
	}
    $user = $_SESSION["gameUser"];
    $opUserLogin = $_SESSION["gameUser"]["opLogin"];
    $opUserRow = mysqli_query($connection, "SELECT * FROM `users` WHERE `login` = '$opUserLogin'");

    if($opUserRow) {
        $opUserRow = mysqli_fetch_assoc($opUserRow);
        $_SESSION["opUser"] = $opUserRow;
    }
	$myUserLogin = $user["login"];

	$mySettings = mysqli_query($connection, "SELECT * FROM `gamesettings` WHERE `login` = '$myUserLogin'");
	$mySettings = mysqli_fetch_assoc($mySettings);
	$oPSettings = mysqli_query($connection, "SELECT * FROM `gamesettings` WHERE `login` = '$opUserLogin'");
	$oPSettings = mysqli_fetch_assoc($oPSettings);

	if ($mySettings["isReady"] > 0 && $oPSettings["isReady"] > 0) {
        //set gameState

        $gameId = $mySettings["gameId"];

        $checkGameId = mysqli_query($connection, "SELECT * FROM `gamestate` WHERE `gameId` = '$gameId'");

        if(mysqli_num_rows($checkGameId) < 1) {
            $stateId = 0;
            do {
                $stateId += 1;
                $lookForEmpty = mysqli_query($connection, "SELECT * FROM `gamestate` WHERE `id` = '$stateId'");
            } while (mysqli_num_rows($lookForEmpty) > 0);
    
            if($mySettings["turn"] == 1) {
                $playerOne = $mySettings["login"];
                $playerTwo = $oPSettings["login"];
                $playerOneColor = $mySettings["color"];
                $playerTwoColor = $oPSettings["color"];
            } else {
                $playerTwo = $mySettings["login"];
                $playerOne = $oPSettings["login"];
                $playerTwoColor = $mySettings["color"];
                $playerOneColor = $oPSettings["color"];
            }
    
            $setMyGameState = mysqli_query($connection, 
            "INSERT INTO `gamestate` (`id`, `gameId`, `playerOne`, `playerTwo`, `playerOneColor`, `playerTwoColor`,
            `curPlayer`, `playerOneScore`, `playerOneBonusScore`, `playerTwoScore`, `playerTwoBonusScore`, `cellsState`, `roundNumber`) 
            VALUES ('$stateId', '$gameId', '$playerOne', '$playerTwo', '$playerOneColor', '$playerTwoColor',
            '$playerOne', '0', '0', '0', '0', '000000000', '1');");
        }


        $checkGameId = mysqli_query($connection, "SELECT * FROM `gamewindowstatus` WHERE `gameId` = '$gameId'");

        if(mysqli_num_rows($checkGameId) < 1) {
            $windowStateId = 0;
            do {
                $windowStateId += 1;
                $lookForEmpty = mysqli_query($connection, "SELECT * FROM `gamewindowstatus` WHERE `id` = '$windowStateId'");
            } while (mysqli_num_rows($lookForEmpty) > 0);

            $setMyGameWindowsState = mysqli_query($connection, 
            "INSERT INTO `gamewindowstatus` (`id`, `gameId`, `quiz`, `roundBoard`, `answer`) 
            VALUES ('$windowStateId', '$gameId', '', 'active', '');");
        }
        
        $checkGameId = mysqli_query($connection, "SELECT * FROM `quizstate` WHERE `gameId` = '$gameId'");

        if(mysqli_num_rows($checkGameId) < 1) {
            $quizStateId = 0;
            do {
                $quizStateId += 1;
                $lookForEmpty = mysqli_query($connection, "SELECT * FROM `quizstate` WHERE `id` = '$quizStateId'");
            } while (mysqli_num_rows($lookForEmpty) > 0);

            $setMyGameQuizState = mysqli_query($connection, 
            "INSERT INTO `quizstate` (`id`, `gameId`, `cellIndex`, `answerState`) 
            VALUES ('$quizStateId', '$gameId', -1, '0000');");
        }
        
        $checkGameId = mysqli_query($connection, "SELECT * FROM `playagain` WHERE `gameId` = '$gameId'");

        if(mysqli_num_rows($checkGameId) < 1) {
            $playAgainId = 0;
            do {
                $playAgainId += 1;
                $lookForEmpty = mysqli_query($connection, "SELECT * FROM `playagain` WHERE `id` = '$playAgainId'");
            } while (mysqli_num_rows($lookForEmpty) > 0);

            $setPlayAgain = mysqli_query($connection, 
            "INSERT INTO `playagain` (`id`, `gameId`, `login`, `isReady`) 
            VALUES ('$playAgainId', '$gameId', '$myUserLogin', 0);");
            $setPlayAgain = mysqli_query($connection, 
            "INSERT INTO `playagain` (`id`, `gameId`, `login`, `isReady`) 
            VALUES ('$playAgainId', '$gameId', '$opUserLogin', 0);");
        }

        //randomize and load questions
        // $indexArray = array();
        // $questions = mysqli_query($connection, "SELECT * FROM `questions`");
        // $questionsQuantity = mysqli_num_rows($questions);
        // $_SESSION["questionsQuantity"] = $questionsQuantity;

        // $randomNumber = -1;
        // $foundFree = false;
        // $alreadyUsed = false;
        // for ($i = 0; $i < $questionsQuantity; $i++) {
        //     $foundFree = false;
        //     while($foundFree == false) {
        //         $alreadyUsed = false;
        //         $randomNumber = rand(0, ($questionsQuantity - 1));
        //         for ($j = 0; $j < count($indexArray); $j++) {
        //             if($indexArray[$j] == $randomNumber) {
        //                 $alreadyUsed = true;
        //             }
        //         }
                
        //         if ($alreadyUsed == false) {
        //             array_push($indexArray, $randomNumber);
        //             $foundFree = true;
        //         } else {
        //             $foundFree = false;
        //         }
        //     }
        // }

        // $k = 0;
        // while($question = mysqli_fetch_assoc($questions)) {
        //     $p = $indexArray[$k];
        //     $_SESSION["questions".$p] = $question;
        //     $k++;
        // }

        $questions = mysqli_query($connection, "SELECT * FROM `questions`");
        $questionsQuantity = mysqli_num_rows($questions);
        $_SESSION["questionsQuantity"] = $questionsQuantity;

        $k = 0;
        while($question = mysqli_fetch_assoc($questions)) {
            $_SESSION["questions".$k] = $question;
            $k++;
        }

        print "<script>document.location.href='/online/game-waiting-room.php'; </script>";
        exit();
	}
    print "<script>document.location.href='/online/index.php'; </script>";
?>