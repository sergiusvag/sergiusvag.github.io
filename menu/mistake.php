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
			
			<form action="../add-mistake.php" class="form-question form-question_add form-question_add-mistake" method="post">
				<h3 class="form-question__title">Сообшить об ошибке по вопросу</h3>
				<div class="input-wrap id-wrap">
					<label for="id" class="input-label question-wrap__label">№ Вопроса</label>
					<input type="text" name="id" id="id" class="question-wrap__id">
				</div>
				
				<div class="input-wrap mistake-wrap">
					<label for="mistake" class="input-label question-wrap__label">Ошибка</label>
					<textarea type="text" name="mistake" id="mistake" class="question-wrap__mistake"></textarea>
				</div>
				<input type="hidden" name="tableName" value="mistakes">
				<button type="submit" class="form-btn form-btn_add form-btn_add-mistake">Добавить</button>
				<a href="../index.php" class="btn btn-go-back btn-go-back-mistake">Назад</a>
				<?php
					if($_SESSION["addmistake"]) {
				?>
					<div class="message">
						<p><?= $_SESSION["addmistake"] ?> </p>
					</div>
				<?php
					}
					$_SESSION["addmistake"] = 0;
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