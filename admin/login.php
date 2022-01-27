<?php

	require_once '../includes/connect.php';

    session_start();
	if($_SESSION["user"]) {
		header("Location: /admin");
	}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<?php
		require_once '../includes/components/head.php';
	?>
	<link rel="stylesheet" href="/css/admin.css">
</head>
<body>
	<!-- login -->
	<section id="login" class="login">
		<div class="container">
        <h3>Вход для администратора</h3>
        <form action="../includes/auth.php" method="post" class="form-admin">
            <div class="form-group">
                <!-- <label for="login" class="form-label">Логин</label> -->
                <input type="text" name="login" class="form-control" id="login" placeholder="Логин">
            </div>
            <div class="form-group">
                <!-- <label for="password" class="form-label">Пароль</label> -->
                <input type="password" name="password" class="form-control" id="password" placeholder="Пароль">
            </div>
            <button type="submit" class="btn btn-admin">Войти</button>
        </form>
		</div>
	</section>
	<!-- Connect JS -->
    <!-- <script src="/js/main.js"></script> -->
</body>
</html>