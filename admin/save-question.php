<?php

    require_once '../includes/connect.php';	

    $questionId = $_POST["id"];
    $question = $_POST["question"];
    $optionOne = $_POST["option-1"];
    $optionTwo = $_POST["option-2"];
    $optionThree = $_POST["option-3"];
    $optionFour = $_POST["option-4"];
    $answer = $_POST["answer"];
    $location = $_POST["location"];
    $tableName = $_POST["tableName"];
    $backTo = $_POST["backTo"];

    $save = mysqli_query($connection, "UPDATE `$tableName` SET `id` = '$questionId', `question` = '$question', `option1` = '$optionOne', `option2` = '$optionTwo', `option3` = '$optionThree', `option4` = '$optionFour', `answer` = '$answer', `location` = '$location' WHERE `$tableName`.`id` = $questionId");

	session_start();

    if ($save) {
        $_SESSION["Message"] = "Вопрос сохранён";
        header("Location: ../admin/menu/$backTo.php");
    }
?>