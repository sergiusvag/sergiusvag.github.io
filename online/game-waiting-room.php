<?php

	require_once '../includes/connect.php';

    session_start();
	
	if(!$_SESSION["gameUser"]) {
		header("Location: ../index.php");
	}
    $user = $_SESSION["gameUser"];
	$login = $_SESSION["gameUser"]["login"];
    $opUserLogin = $_SESSION["gameUser"]["opLogin"];
    $opUserRow = mysqli_query($connection, "SELECT * FROM `users` WHERE `login` = '$opUserLogin'");

    if($opUserRow) {
        $opUserRow = mysqli_fetch_assoc($opUserRow);
        $_SESSION["opUser"] = $opUserRow;
    }
	$gameId = $user["gameId"];

	$gameState = mysqli_query($connection, "SELECT * FROM `gameState` WHERE `gameId` = '$gameId'");
	$gameState = mysqli_fetch_assoc($gameState);

	$gameWindowState = mysqli_query($connection, "SELECT * FROM `gamewindowstatus` WHERE `gameId` = '$gameId'");
	$gameWindowState = mysqli_fetch_assoc($gameWindowState);

	
	$refreshNeeded = ($gameState["curPlayer"] != $user["login"]);
	$clickable = !$refreshNeeded;
	$isPlayerOneCurrent = $gameState["playerOne"] == $gameState["curPlayer"];
	$isPlayerTwoCurrent = $gameState["playerTwo"] == $gameState["curPlayer"];

	// $questions = mysqli_query($connection, "SELECT * FROM `questions`");
	// $questionsQuantity = mysqli_num_rows($questions);
	// echo $questionsQuantity;
	// var_dump($_SESSION["questions2"]);
	
    $quizState = mysqli_query($connection, "SELECT * FROM `quizstate` WHERE `gameId` = '$gameId'");
	$quizState = mysqli_fetch_assoc($quizState);

    $selectedCellIndex = $quizState["cellIndex"];
	$selectedCellIndex = $selectedCellIndex + (($gameState["roundNumber"] - 1) * 9);
	$currentQuestionSelector = "questions" . $selectedCellIndex;
	$currentQuestion = $_SESSION[$currentQuestionSelector];

	// echo "================================================================";
	$curRound = "Раунд ".$gameState["roundNumber"];
	$questionsQuantity = $_SESSION["questionsQuantity"];
	$maxRounds = (int)($questionsQuantity / 9);

	$gameFinished = false;
	if ($gameState["roundNumber"] == $maxRounds) {
		$curRound = "Последний раунд";
	} else if ($gameState["roundNumber"] > $maxRounds) {
		$curRound = "Игра закончена";
		$gameFinished = true;
	}

    $myPlayAgainSettings = mysqli_query($connection, "SELECT * FROM `playagain` WHERE `login` = '$login'");
    $myPlayAgainSettings = mysqli_fetch_assoc($myPlayAgainSettings);
	$isMeReady = $myPlayAgainSettings["isReady"] == 1;
	$opPlayAgainSettings = mysqli_query($connection, "SELECT * FROM `playagain` WHERE `login` = '$opUserLogin'");
    $opPlayAgainSettings = mysqli_fetch_assoc($opPlayAgainSettings);
	$isOpReady = $opPlayAgainSettings["isReady"] == 1;

	if($user["login"] == $gameState["playerOne"]){
		$isPlayerOneReady = $isMeReady;
		$isPlayerTwoReady = $isOpReady;
	} else {
		$isPlayerOneReady = $isOpReady;
		$isPlayerTwoReady = $isMeReady;
	}
?>


<!DOCTYPE html>
<html lang="ru">
<head>
	<?php
		require_once '../includes/components/head.php';
	?>
    <link rel="stylesheet" href="/css/online-game.css">
</head>
<body>
	<div id="waiting-refresh"></div>
	<header id="header" class="header">
		<div class="container">
			<?php
				$numOfPlayers = 2;
				$colors = array("red", "green", "blue", "pink", "orange");
				$playerNum = array("one", "two");
				$playerTitleText = array($gameState["playerOne"], $gameState["playerTwo"]);
				$playerSymbol = array("x", "o");
				$playerOneTotalScore = $gameState["playerOneScore"] + $gameState["playerOneBonusScore"];
				$playerTwoTotalScore = $gameState["playerTwoScore"] + $gameState["playerTwoBonusScore"];
				$playerScore = array($playerOneTotalScore, $playerTwoTotalScore);
			?>
			<!-- Game -->
			<div class="game flex-between">
				<div class="player-stats player-stats_one">
					<div class="player-stats-bg player-stats-bg_one <?php 
						if($isPlayerOneCurrent) { 
							$playerOneColor = $gameState['playerOneColor'];
							echo "bg-".$playerOneColor; 
						}?>"></div>
					<div class="player-stats-info player-stats-info_game">
						<h3 class="player-header player-header_game"><?= $gameState["playerOne"] ?></h3>
						<div class="player-score-wrap player-score-wrap_game">
							<div class="online-score flex-between">
								<div class="player-score-wins">
									<span class="player-score-txt">Счёт: 
									</span>
								</div>
								<div class="player-score-count">
									<span class="player-score-count-txt player-score-turn-txt_game player-one-score"><?= $gameState["playerOneScore"] ?></span>
								</div>
							</div>
							<div class="online-score flex-between">
								<div class="player-score-wins">
									<span class="player-score-txt">Бонус: 
									</span>
								</div>
								<div class="player-score-count">
									<span class="player-score-count-txt player-score-turn-txt_game player-one-score"><?= $gameState["playerOneBonusScore"] ?></span>
								</div>
							</div>
						</div>
						<?php
							if($isPlayerOneCurrent) {
						?>
							<div class="player-score-turn player-score-turn_one player-score-turn_on">
								<span class="player-score-turn-txt player-score-turn-txt_game">Моя очередь!</span>
							</div>
						<?php
							}
						?>
					</div>
				</div>

					<div class="gameboard flex-between">
						<?php
							$cellsState = $gameState["cellsState"];
							for($i = 0; $i < 9; $i++) {
								if ($cellsState[$i] == "1") {
									$bgColor = "bg-".$gameState["playerOneColor"];
									$cellSymbol = "../img/x.png";
								} else if ($cellsState[$i] == "2") {
									$bgColor = "bg-".$gameState["playerTwoColor"];
									$cellSymbol = "../img/o.png";
								} else {
									$bgColor = "";
									$cellSymbol = "../img/blank.jpg";
								}
						?>
							<form action="/online/cell-clicked.php" method="POST">
								<input type="hidden" name="cellIndex" value="<?= $i ?>">
								<button type="submit" class="game-tile <?= $bgColor ?> <?php 
									if(!$clickable || $cellsState[$i] != "0") { 
										echo "btn_dis";
									}?>">
								<div class="game-tile__field">
									<div class="game-tile-xo">
										<img src=<?= $cellSymbol ?> alt="" class="game-tile-xo-img">
									</div>
								</div>
								</button>
							</form>		
						<?php
							}
						?>
					</div>	

				<div class="player-stats player-stats_two">
					<div class="player-stats-bg player-stats-bg_two <?php 
						if($isPlayerTwoCurrent) { 
							$playerTwoColor = $gameState['playerTwoColor'];
							echo "bg-".$playerTwoColor; 
						}?>"></div>
					<div class="player-stats-info player-stats-info_game">
						<h3 class="player-header player-header_game"><?= $gameState["playerTwo"] ?></h3>
						<div class="player-score-wrap player-score-wrap_game">
							<div class="online-score flex-between">
								<div class="player-score-wins">
									<span class="player-score-txt">Счёт: 
									</span>
								</div>
								<div class="player-score-count">
									<span class="player-score-count-txt player-score-turn-txt_game player-two-score"><?= $gameState["playerTwoScore"] ?></span>
								</div>
							</div>
							<div class="online-score flex-between">
								<div class="player-score-wins">
									<span class="player-score-txt">Бонус: 
									</span>
								</div>
								<div class="player-score-count">
									<span class="player-score-count-txt player-score-turn-txt_game player-two-score"><?= $gameState["playerTwoBonusScore"] ?></span>
								</div>
							</div>
						</div>
						<?php
							if($isPlayerTwoCurrent) {
						?>
							<div class="player-score-turn player-score-turn_two player-score-turn_on">
								<span class="player-score-turn-txt player-score-turn-txt_game">Моя очередь!</span>
							</div>
						<?php
							}
						?>
					</div>
				</div>
			</div>
			<?php
				if($gameWindowState["quiz"] == "active") {
					if ($gameState["curPlayer"] == $gameState["playerOne"]) {
						$curColor = $gameState["playerOneColor"];
					} else {
						$curColor = $gameState["playerTwoColor"];
					}

					$bgColor = "bg-".$curColor;
					$textColor = "color-".$curColor;
					$selectedTextColor = "color-white";
					$answerState = $quizState["answerState"];
			?>
				<div id="wrapper-modal_quiz" class="wrapper-modal <?= $gameWindowState["quiz"] ?>">
					<div class="overlay"></div>
					<div class="modal-window">
						<div class="modal-content">
							<div class="message-wrap-out quiz-wrap-out <?= $bgColor ?>">
								<div class="message-wrap-in quiz-wrap-in">
									<h3 class="the-question" id="question">№<?= $currentQuestion["id"] ?> <?= $currentQuestion["question"] ?></h3>
									<div class="answers" id="answers">
										<?php
											for($i = 0; $i < 4; $i++) {
										?>
											<form action="/online/answer-selected.php" method="post" class="answers__form">
												<input type="hidden" name="answerIndex" value="<?= $i ?>">
												<button type="submit" class="answer__item <?= $textColor ?> <?php 
														if ($answerState[$i] != "0") {
															echo $bgColor;
														}
													?> <?php 
													if(!$clickable) { 
														echo "btn_dis";
													}?>">
														<p class="answer <?php 
														if ($answerState[$i] != "0") {
															echo $selectedTextColor;
														}
													?>"><?= $currentQuestion["option".($i+1)] ?></p>
												</button>
											</form>
										<?php
											}
										?>
									</div>
									<form action="/online/check-answer.php" method="post">
										<button type="submit" class="btn btn-answer <?php 
											if(!$clickable || $answerState=="0000") { 
												echo "btn_round-dis";
											}?>">Ответить
										</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
				}
				if($gameWindowState["roundBoard"] == "active") {
			?>
				<div id="wrapper-modal_round" class="wrapper-modal <?= $gameWindowState["roundBoard"] ?>">
					<div class="overlay" id="round-overlay"></div>
					<div class="modal-window">
						<div class="modal-content">
							<div class="message-wrap-out round-wrap-out">
								<div class="message-wrap-in round-wrap-in">
									<div class="bg-wrap bg-wrap_round round-title-wrap">
										<h3 class="round-title" id="round-title"><?= $curRound ?></span></h3>
									</div>
									<span class="round-txt bg-wrap bg-wrap_round">Итоговый счёт<?php 
										if (!$gameFinished) {
											echo " до сих пор";
										}
									?></span>
									<div class="round-score-wrap flex-between">
										<?php
											for($i = 0; $i < $numOfPlayers; $i++) {
										?>
											<div class="player-stats-info player-stats-info_round bg-wrap bg-wrap_round">
												<h3 class="player-header"><?= $playerTitleText[$i] ?></h3>
												<div class="player-score-wrap flex-between">
													<div class="player-score-wins">
														<span class="player-score-txt">Счёт:
														</span>
													</div>
													<div class="player-score-count">
														<span class="player-score-count-txt player-<?= $playerNum[$i] ?>-score"><?= $playerScore[$i] ?></span>
													</div>
												</div>
											</div>
										<?php
											}
										?>
									</div>
									<?php
										if(!$gameFinished) {
									?>
										<form action="/online/round-start.php" method="post">
											<button class="btn btn_round <?php 
											if(!$clickable) { 
												echo "btn_round-dis";
											}?>">Продолжить
											</button>
										</form>
									<?php
										} else {
									?>
										<form action="/online/play-again.php" method="post">
											<div class="buttons-player-again">
												<button class="btn btn_round btn_round-again btn_round-left <?php 
													if($user["login"] != $gameState["playerOne"]) {
														echo "btn_round-dis";
													}
													?> <?php 
													if ($isPlayerOneReady) {
														echo "btn-round-again-ready";
													}
													?>"><?= $gameState["playerOne"] ?> Готов
												</button>
												<button class="btn btn_round btn_round-again btn_round-right <?php 
													if($user["login"] != $gameState["playerTwo"]) {
														echo "btn_round-dis";
													}
													?> <?php 
													if ($isPlayerTwoReady) {
														echo "btn-round-again-ready";
													}
													?>">Готов <?= $gameState["playerTwo"] ?>
												</button>
											</div>
										</form>
										<form action="/online/reset-game.php" method="post">
											<button class="btn btn_round btn_round-reset">
												Выход
											</button>
										</form>
									<?php
										}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
				}
				if($gameWindowState["answer"] == "active") {
					$answerState = $quizState["answerState"];
					
					if ($answerState == "1000") {
						$selectedanswer = "option". 1 ;
					} else if ($answerState == "0100") {
						$selectedanswer = "option". 2;
					} else if ($answerState == "0010") {
						$selectedanswer = "option". 3;
					} else if ($answerState == "0001") {
						$selectedanswer = "option". 4;
					}

					$isCorrect = $currentQuestion[$selectedanswer] == $currentQuestion["answer"];
					if ($isCorrect) {
						$isCorrectText = "Верно";
						$messageWrapColor = "message-wrap-in-correct";
					} else {
						$messageWrapColor = "message-wrap-in-wrong";
						$isCorrectText = "Не верно";
					}

			?>
				<div id="wrapper-modal_answer" class="wrapper-modal <?= $gameWindowState["answer"] ?>">
					<div class="overlay" id="answer-overlay"></div>
					<div class="modal-window">
						<div class="modal-content">
							<div class="message-wrap-out answer-wrap-out">
								<div class="message-wrap-in answer-wrap-in <?= $messageWrapColor ?>">
									<div class="bg-wrap bg-wrap_answer round-title-wrap">
										<h3 class="answer-title" id="answer-title"><?= $isCorrectText ?></span></h3>
									</div>
									<?php
										if($isCorrect) {
									?>
										<div class="correct-answer"><?= $currentQuestion[$selectedanswer] ?></div>
										<div id="answer-location-wrap">
											<span class="answer-txt bg-wrap bg-wrap_round" id="answer-txt">Ответ в : <span id="answer-location"><?= $currentQuestion["location"] ?></span></span>
										</div>
									<?php
										}
									?>
									<form action="/online/round-next.php" method="post">
										<input type="hidden" name="isCorrect" value="<?= $isCorrectText ?>">
										<button class="btn btn_round <?php 
										if(!$clickable) { 
											echo "btn_round-dis";
										}?>">Продолжить
										</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
				}
			?>
		</div>
    	<a href="../user/logout.php" class="btn-user btn-logout">Выйти</a>
	</header>


</body>
    <script src="../js/jquery-3.5.1.min.js"></script>
	<?php
		if ($refreshNeeded && !$gameFinished) {
	?>
    	<script src="../js/waiting-room-check.js"></script>
	<?php
		}
		if ($gameFinished) {
	?>
    	<script src="../js/game-reset-check.js"></script>
	<?php
		}
	?>
</html>