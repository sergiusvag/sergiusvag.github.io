<?php

	require_once '../includes/connect.php';

    session_start();
	
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
        // header("Location: /online/game-waiting-room.php");
	}

	if(!$oPSettings || !$mySettings) {
        header("Location: ../logged-in-game.php");
	}
?>


<!DOCTYPE html>
<html lang="ru">
<head>
	<?php
		require_once '../includes/components/head.php';
	?>
    <link rel="stylesheet" href="/css/online-main.css">
</head>
<body>
	<div id="color-refresh"></div>
    
	<header id="header" class="header">
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
								if($mySettings["turn"] == ($i + 1)) {
									$curSettings = $mySettings;
									$allowChange = "true";
								} else {
									$curSettings = $oPSettings;
									$allowChange = "false";
								}
								
						?>
						<h2 class="color-picker__title_2 player-<?= $playerNum[$i] ?> title <?php 
								if($curSettings["color"] != "0") {
									echo "color-" . $curSettings["color"];
								} 
						?>"><?= $curSettings["login"]?></h2>
							<div class="color-picker-wrap flex-between color-picker-wrap_<?= $playerNum[$i] ?>">
								<?php
									for ($j = 0; $j < 5; $j++) {
								?>
								<form action="/online/color-pick.php" class="form-color-pick" method="POST">
									<input type="hidden" name="allowed" value="<?= $allowChange ?>">
									<input type="hidden" name="opLogin" value="<?= $oPSettings["login"] ?>">
									<input type="hidden" name="settingsId" value="<?= $curSettings["id"] ?>">
									<input type="hidden" name="color" value="<?= $colors[$j] ?>">
									<button type="submit" class="color-wrap <?php 
										if($curSettings["color"] == $colors[$j]) {
											echo "color-wrap-clicked";
										}
									?>">
										<img src="../img/<?= $playerSymbol[$i] ?>-<?= $colors[$j] ?>.png" alt="<?= $playerSymbol[$i] ?>-<?= $colors[$j] ?>" class="color-img color-img_<?= $colors[$j] ?>">
									</button>
								</form>
								<?php
									}
								?>
							</div>
						<?php
							}
						?>
						
						<form action="/online/color-ready.php" method="POST">
							<input type="hidden" name="login" value="<?= $mySettings["login"] ?>">
							<div class="ready-buttons-wrap">
								<button type="submit" class="btn btn-start ready-button ready-button_ready <?php
									if($mySettings["isReady"] == 1) { 
										echo "btn_dis";
									}
								?>">Не готов
								</button>
								<button type="submit" class="btn btn-start ready-button ready-button_not-ready <?php
									if($mySettings["isReady"] == 0) { 
										echo "btn_dis";
									}
								?>">Готов
								</button>
							</div>
						</form>
					</div>

				</div>
			</div>
		</div>
    <a href="../user/logout.php" class="btn-user btn-logout">Выйти</a>
	</header>


</body>
    <script src="../js/jquery-3.5.1.min.js"></script>
    <script src="../js/color-check.js"></script>
</html>