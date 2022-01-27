<?php

	require_once '../includes/connect.php';

	session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<?php
		require_once '../includes/components/head.php';
	?>
</head>
<body>
	<!-- Advantages -->
	<section id="before-game" class="before-game">
		<div class="container">

			<form action="../add-question.php" class="form-question form-question_add form-question_add-suggestion" method="post">
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
				<input type="hidden" name="tableName" value="suggestions">
				<button type="submit" class="form-btn form-btn_add form-btn_add-suggestion">Добавить</button>
                <a href="../index.php" class="btn btn-go-back btn-go-back-suggestion">Назад</a>
				<?php
					if($_SESSION["addMessage"]) {
				?>
					<div class="message">
						<p><?= $_SESSION["addMessage"] ?> </p>
					</div>
				<?php
					}
					$_SESSION["addMessage"] = 0;
				?>
			</form>
			
		</div>
	</section>
	<!-- Analyst -->
	<section id="analyst" class="analyst">
		<div class="container">

		</div>
	</section>
	<!-- Fonds -->
	<section id="fonds" class="fonds">
		<div class="container">

		</div>
	</section>
	<!-- Invest -->
	<section id="invest" class="invest">
		<div class="container">

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