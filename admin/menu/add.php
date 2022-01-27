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
		require_once '/OpenServer/domains/XO/includes/components/head.php';
	?>
	<link rel="stylesheet" href="/css/admin.css">
</head>
<body>
	<!-- questions -->
	<section id="questions" class="questions">
		<div class="user-wrap">
			<p class="user-info">Добро пожаловать, <span class="user-name"><?= $_SESSION["user"]["login"] ?></span></p>
			<a href="../logout.php" class="btn btn-logout">Выйти</a>
		</div>
		<div class="admin-panel">
			<div class="menu menu-buttons">
                <a href="./show.php"  class="admin-panel-btn admin-panel-btn_show">Показать</a>
                <a href="./add.php" class="admin-panel-btn admin-panel-btn_add">Добавить</a>
                <a href="./new.php" class="admin-panel-btn admin-panel-btn_new">Новое</a>
                <a href="./mistakes.php" class="admin-panel-btn admin-panel-btn_mistake">Ошибки</a>
			</div>
			<div class="container">
				<div class="form-wrapper d-block">
					
					<form action="../add-question.php" class="form-question form-question_add" method="post">
						<h3 class="form-question__title">Добавить новый вопрос</h3>
						<div class="input-wrap question-wrap">
							<label for="question" class="input-label question-wrap__label">Вопрос</label>
							<input type="text" name="question" id="question" class="question-wrap__question">
						</div>
						<div class="input-wrap options-wrap">
							<span class="options-wrap__title">Варианты ответов</span>
						<?php
							for($i = 1; $i < 5; $i++) {
						?>
							<div class="option-wrap">
								<label for="option-<?= $i ?>" class="input-label options-wrap__label_<?= $i ?>">Вариант №<?= $i ?></label>
								<input type="text" name="option-<?= $i ?>" id="option-<?= $i ?>" class="options-wrap__option options-wrap__option_<?= $i ?>">
							</div>
						<?php
							}
						?>
						</div>
						
						<div class="input-wrap answer-wrap">
							<label for="answer" class="input-label answer-wrap__label">Ответ</label>
							<input type="text" name="answer" id="answer" class="answer-wrap__question">
						</div>
						
						<div class="input-wrap location-wrap">
							<label for="location" class="input-label location-wrap__label">Место в Библии</label>
							<input type="text" name="location" id="location" class="location-wrap__question">
						</div>
						<input type="hidden" name="tableName" value="questions">
            			<button type="submit" class="form-btn form-btn_add">Добавить</button>
					</form>

					<?php
						if ($_SESSION["Message"]) {
					?>
						<div class="message error-message">
							<p><?= $_SESSION["Message"] ?> </p>
						</div>
					<?php
						}

						$_SESSION["Message"] = 0;
					?>
				</div>
			</div>
		</div>
	</section>
	<!-- Connect JS -->
    <!-- <script src="../admin/js/admin.js"></script> -->
</body>
</html>