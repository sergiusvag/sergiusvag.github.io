<?php

	session_start();
	if(!$_SESSION["user"]) {
		header("Location: login.php");
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
	<!-- questions -->
	<section id="questions" class="questions">
		<div class="user-wrap">
			<p class="user-info">Добро пожаловать, <span class="user-name"><?= $_SESSION["user"]["login"] ?></span></p>
			<a href="../admin/logout.php" class="btn btn-logout">Выйти</a>
		</div>
		<div class="admin-panel">
			<div class="menu menu-buttons">
				<a href="./menu/show.php" class="admin-panel-btn admin-panel-btn_show">Показать</a>
				<a href="./menu/add.php" class="admin-panel-btn admin-panel-btn_add">Добавить</a>
				<a href="./menu/new.php" class="admin-panel-btn admin-panel-btn_new">Новое</a>
				<a href="./menu/mistakes.php" class="admin-panel-btn admin-panel-btn_mistake">Ошибки</a>
			</div>
			<div class="container">
				<div class="form-wrapper">
					<div class="form-question welcome">
						<h1 class="welcome__title">Добро пожаловать!</h1>
						<p class="welcome_text">
							Здесь вы можете добовлять, редактировать вопросы
						</p>
					</div>
					
				</div>
			</div>
		</div>
	</section>
	<!-- Connect JS -->
    <script src="../admin/js/admin.js"></script>
</body>
</html>