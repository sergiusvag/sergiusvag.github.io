<?php

	require_once '../includes/connect.php';

    session_start();
	if($_SESSION["gameUser"]) {
		header("Location: /logged-in-game.php");
	}
    
    $errorIndex = (int)$_GET["errorIndex"];
    $errorArray = array("",
                        "Ошибка: Пользователь не существует", 
                        "Ошибка: не верный пароль", );

    if($errorIndex == 2) {
        $usedLogin = $_GET["usedLogin"];
    }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<?php
		require_once '../includes/components/head.php';
	?>
	<link rel="stylesheet" href="/css/user-log.css">
</head>
<body>
	<!-- login -->
	<section id="login" class="login">
		<div class="container">
        <h3>Вход</h3>
        <form action="/user/auth.php" method="post" class="form-admin">
            <div class="form-group">
                <input type="text" name="login" class="form-control" id="login" placeholder="Логин" value="<?= $usedLogin ?>">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" id="password" placeholder="Пароль">
            </div>
            <div class="form-group">
                <label class="log-message"><?= $errorArray[$errorIndex] ?></label>
            </div>
            <button type="submit" class="btn btn-admin">Войти</button>
        </form>
		</div>
	</section>
	<!-- Connect JS -->
    <!-- <script src="/js/main.js"></script> -->
</body>
</html>