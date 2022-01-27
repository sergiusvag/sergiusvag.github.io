<?php

	require_once '../includes/connect.php';

    session_start();
	if($_SESSION["gameUser"]) {
		header("Location: /logged-in-game.php");
	}
    
    $errorIndex = (int)$_GET["errorIndex"];

    $errorArray = array("",
                        "Ошибка: Пароли не совпадают", 
                        "Ошибка: Пароль пуст", 
                        "Ошибка: Такой пользователь уже существует", 
                        "Ошибка в создание пользователя");

    if($errorIndex != 0) {
        $usedLogin = $_GET["usedLogin"];
        $usedEmail = $_GET["usedEmail"];
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
	<section id="register" class="register">
		<div class="container">
        <h3>Регистрация</h3>
        <form action="/user/auth-register.php" method="post" class="form-user">
            <div class="form-group">
                <input type="text" name="login" class="form-control" id="login" placeholder="Логин" value="<?= $usedLogin ?>">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" id="password" placeholder="Пароль">
            </div>
            <div class="form-group">
                <input type="password" name="password-repeat" class="form-control" id="password" placeholder="Повторите пароль">
            </div>
            <div class="form-group">
                <input type="email" name="email" class="form-control" id="email" placeholder="Почта" value="<?= $usedEmail ?>">
            </div>
            <div class="form-group">
                <label class="log-message"><?= $errorArray[$errorIndex] ?></label>
            </div>
            <button type="submit" class="btn btn-admin btn_register">Регистрировать</button>
        </form>
		</div>
	</section>
	<!-- Connect JS -->
    <!-- <script src="/js/main.js"></script> -->
</body>
</html>