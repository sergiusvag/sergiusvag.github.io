<?php

	require_once 'includes/connect.php';

	session_start();
	if(!$_SESSION["gameUser"]) {
		header("Location: index.php");
	}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<?php
		require_once 'includes/components/head.php';
	?>
</head>
<body>
	<!-- Header -->
	<header id="header" class="header hide">
		<div class="container">
			<div class="picker">
				<div class="wrap-in">
					<div class="color-picker">
						<h1 class="color-picker__title title">
							Крестики Нолики
						</h1>
						<?php
							$numOfPlayers = 2;
							$colors = array("red", "green", "blue", "pink", "orange");
							$playerNum = array("one", "two");
							$playerTitleText = array("Первый Игрок", "Второй Игрок");
							$playerSymbol = array("x", "o");
							for ($i = 0; $i < $numOfPlayers; $i++) {
						?>
						<h2 class="color-picker__title_2 player-<?= $playerNum[$i] ?> title">
							<?= $playerTitleText[$i] ?>
						</h2>
							<div class="color-picker-wrap flex-between color-picker-wrap_<?= $playerNum[$i] ?>">
								<?php
									for ($j = 0; $j < 5; $j++) {
								?>
								<div class="color-wrap">
									<img src="img/<?= $playerSymbol[$i] ?>-<?= $colors[$j] ?>.png" alt="<?= $playerSymbol[$i] ?>-<?= $colors[$j] ?>" class="color-img color-img_<?= $colors[$j] ?>">
								</div>
								<?php
									}
								?>
							</div>
						<?php
							}
						?>
						<button type="button" class="btn btn-start">
							Start
						</button>
					</div>

				</div>
			</div>
			<!-- Game -->
			<div class="game flex-between hide">
				<?php 
					function scoreBoard($index ,$playerNumArray, $playerTitleTextArray) {
				?>
					<div class="player-stats player-stats_<?= $playerNumArray[$index] ?>">
						<div class="player-stats-bg player-stats-bg_<?= $playerNumArray[$index] ?>"></div>
						<div class="player-stats-info player-stats-info_game">
							<h3 class="player-header player-header_game"><?= $playerTitleTextArray[$index] ?></h3>
							<div class="player-score-wrap player-score-wrap_game">
								<div class="offline-score flex-between">
									<div class="player-score-wins">
										<span class="player-score-txt">Счёт:
										</span>
									</div>
									<div class="player-score-count">
										<span class="player-score-count-txt player-score-turn-txt_game player-<?= $playerNumArray[$index] ?>-score">0</span>
									</div>
								</div>
								<div class="offline-score flex-between">
									<div class="player-score-wins">
										<span class="player-score-txt">Бонус: 
										</span>
									</div>
									<div class="player-score-count">
										<span class="player-score-count-txt player-score-turn-txt_game player-<?= $playerNumArray[$index] ?>-bonus-score">0</span>
									</div>
								</div>
							</div>
							<div class="player-score-turn player-score-turn_<?= $playerNumArray[$index] ?>">
								<span class="player-score-turn-txt player-score-turn-txt_game">Моя очередь!</span>
							</div>
						</div>
					</div>
				<?php
					}
				?>

				<?php
					scoreBoard(0, $playerNum, $playerTitleText);
				?>
	
				<div class="gameboard flex-between">
					<?php
						for($i = 0; $i < 9; $i++) {
					?>
					<div class="game-tile">
						<div class="game-tile__field">
							<div class="game-tile-xo">
								<img src="img/blank.jpg" alt="" class="game-tile-xo-img">
							</div>
						</div>
					</div>
					<?php
						}
					?>
				</div>
	
				<?php
					scoreBoard(1, $playerNum, $playerTitleText);
				?>
			</div>
			<div id="wrapper-modal_quiz" class="wrapper-modal">
				<div class="overlay"></div>
				<div class="modal-window">
					<div class="modal-content">
						<div class="message-wrap-out quiz-wrap-out">
							<div class="message-wrap-in quiz-wrap-in">
								<h3 class="the-question" id="question"></h3>
								<ul class="answers" id="answers">
									<?php
										for($i = 0; $i < 4; $i++) {
									?>
										<li class="answer__item">
											<p class="answer"></p>
										</li>
									<?php
										}
									?>
								</ul>
								<button type="button" class="btn btn-answer">Ответить</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="wrapper-modal_round" class="wrapper-modal">
				<div class="overlay" id="round-overlay"></div>
				<div class="modal-window">
					<div class="modal-content">
						<div class="message-wrap-out round-wrap-out">
							<div class="message-wrap-in round-wrap-in">
								<div class="bg-wrap bg-wrap_round round-title-wrap">
									<h3 class="round-title" id="round-title">Раунд <span id="round-number">1</span></h3>
								</div>
								<span class="round-txt bg-wrap bg-wrap_round">Счёт до сих пор</span>
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
													<span class="player-score-count-txt player-<?= $playerNum[$i] ?>-total-score">0</span>
												</div>
											</div>
										</div>
									<?php
										}
									?>
								</div>
								<div class="offline-back-wrap">
									<a href="/" class="btn btn-offline-back">Назад в меню</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="wrapper-modal_answer" class="wrapper-modal">
				<div class="overlay" id="answer-overlay"></div>
				<div class="modal-window">
					<div class="modal-content">
						<div class="message-wrap-out answer-wrap-out">
							<div class="message-wrap-in answer-wrap-in">
								<div class="bg-wrap bg-wrap_answer round-title-wrap">
									<h3 class="answer-title" id="answer-title">Верно</span></h3>
								</div>
								<div id="answer-location-wrap">
									<span class="answer-txt bg-wrap bg-wrap_round" id="answer-txt">Ответ в : <span id="answer-location">Место</span></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- Advantages -->
	<section id="before-game" class="before-game">
		<div class="container">
			<div class="before-wrap">
				<div class="user-login-wrap">
                    <span class="loged-user-info">Здраствуйте! <span class="loged-user"><?= $_SESSION["gameUser"]['login'] ?></span></span>
                    <a href="../user/logout.php" class="btn-user btn-logout">Выйти</a>
				</div>
				<div class="main-menu-buttons">
					<button type="button" class="btn btn-begin-game">Начать игру</button>
					<a href="./online/room.php" class="btn btn-begin-game">Онлайн игра</a>
					<a href="./menu/question.php" class="btn btn-make-suggestion">Послать вопрос</a>
					<a href="./menu/mistake.php" class="btn btn-make-mistake">Сообшить об ошибке</a>
				</div>
			</div>
		</div>
	</section>
	<!-- Footer -->
	<footer id="footer" class="footer">
		<div class="container">
			
		</div>
	</footer>
	<!-- Connect JS -->
    <script src="/js/main.js"></script>
</body>
</html>