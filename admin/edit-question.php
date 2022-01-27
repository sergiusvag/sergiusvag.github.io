<?php

    require_once '../includes/connect.php';	

	session_start();
	if(!$_SESSION["user"]) {
		header("Location: login.php");
	}

    $questionId = $_GET["id"];
    $tableName = $_GET["tableName"];
    $checkmistakes = $_GET["check"];
	$backTo = $_GET["backTo"];

    $question = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM `$tableName` WHERE `id` = '$questionId'"));
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
				<a href="./menu/show.php"  class="admin-panel-btn admin-panel-btn_show">Показать</a>
				<a href="./menu/add.php" class="admin-panel-btn admin-panel-btn_add">Добавить</a>
				<a href="./menu/new.php" class="admin-panel-btn admin-panel-btn_new">Новое</a>
				<a href="./menu/mistakes.php" class="admin-panel-btn admin-panel-btn_mistake">Ошибки</a>
			</div>
			<div class="container">
				<div class="form-wrapper form-wrapper-edit">
					<form action="save-question.php" class="form-question form-question_edit" method="post">
						<h3 class="form-question__title">Редактировать вопрос №<?= $question["id"] ?></h3>
                        
                        <input type="hidden" name="id" value="<?= $question["id"] ?>">
						<input type="hidden" name="backTo" value="<?= $backTo ?>">
						<div class="input-wrap question-wrap">
							<label for="question" class="input-label question-wrap__label">Вопрос</label>
							<input type="text" name="question" id="question" class="question-wrap__question" value="<?= $question["question"] ?>">
						</div>
						<div class="input-wrap options-wrap">
							<span class="options-wrap__title">Варианты</span>
						<?php
							for($i = 1; $i < 5; $i++) {
						?>
							<div class="option-wrap">
								<label for="option-<?= $i ?>" class="input-label options-wrap__label_<?= $i ?>">Вариант №<?= $i ?></label>
								<input type="text" 
                                       name="option-<?= $i ?>" 
                                       id="option-<?= $i ?>" 
                                       class="options-wrap__option options-wrap__option_<?= $i ?>" 
                                       value="<?= $question["option$i"] ?>">
							</div>
						<?php
							}
						?>
						</div>
						
						<div class="input-wrap answer-wrap">
							<label for="answer" class="input-label answer-wrap__label">Ответ</label>
							<input type="text" name="answer" id="answer" class="answer-wrap__question" value="<?= $question["answer"] ?>">
						</div>
						
						<div class="input-wrap location-wrap">
							<label for="location" class="input-label location-wrap__label">Место в Библии</label>
							<input type="text" name="location" id="location" class="location-wrap__question" value="<?= $question["location"] ?>">
						</div>
						<input type="hidden" name="tableName" value="<?= $tableName ?>">
            			<button type="submit" class="form-btn form-btn_add">Сохранить</button>
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
					</form>
					<?php
						if($checkmistakes) {
							$mistakes = mysqli_query($connection, "SELECT * FROM `mistakes` WHERE `questionId` = '$questionId'");
							
							if(mysqli_num_rows($mistakes) > 0) {
					?>

								<div class="edit-questions-mistakes">
								<?php
								while ($mistake = mysqli_fetch_assoc($mistakes)){
								?>
									<div class="single-mistake">
										<span class="single-mistake__number">Ошибка №<?= $mistake["id"] ?></span>
										<div class="single-mistake__buttons">
											<button type="button" class="btn-show btn-mistake btn-mistake-show">Показать</button>
											<button type="button" class="btn-show btn-mistake btn-mistake-show hide">Скрыть</button>
											<form action="../admin/delete-question.php" method="post" class="form-mistake-delete">
												<input type="hidden" name="id" value="<?= $mistake["id"] ?>">
												<input type="hidden" name="backTo" value="<?= $backTo ?>">
												<input type="hidden" name="questionId" value="<?= $questionId ?>">
												<input type="hidden" name="tableName" value="mistakes">
												<input type="hidden" name="item" value="Ошибка">
                                				<input type="hidden" name="return" value="true">
												<button type="submit" class="btn-show btn-mistake btn-mistake-delete">Удалить</button>
											</form>
										</div>
										<p class="single-mistake__the-mistake hide"><?= $mistake["mistake"] ?></p>
									</div>
								<?php
								}
								?>
								</div>
					<?php
							} else {
					?>
							<p class="no-mistakes">Нет ошибок</p>
					<?php
							}
						}
					?>
				</div>
			</div>
		</div>
	</section>
	<!-- Connect JS -->
    <script src="../admin/js/admin-edit.js"></script>
</body>
</html>