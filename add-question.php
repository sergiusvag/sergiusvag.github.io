<?php

	require_once '../XO/includes/connect.php';

	session_start();

    $question = $_POST["question"];
    $optionOne = $_POST["option-1"];
    $optionTwo = $_POST["option-2"];
    $optionThree = $_POST["option-3"];
    $optionFour = $_POST["option-4"];
    $answer = $_POST["answer"];
    $location = $_POST["location"];
    $id = 0;
    $tableNameToAdd = $_POST["tableName"];

    if($question == '' ||
    $optionOne == '' ||
    $optionTwo == '' ||
    $optionThree == '' ||
    $optionFour == '' ||
    $answer == '' ||
    $location == ''){
        $_SESSION["Message"] = "Ошибка: Пустое Поле";
    } else {

        do {
            $id += 1;
            $idRowSql = mysqli_query($connection, "SELECT * FROM `$tableNameToAdd` WHERE id = '$id'");
        } while (mysqli_num_rows($idRowSql) > 0);

        $insertSql = "INSERT INTO `$tableNameToAdd` (`id`, `question`, `option1`, `option2`, `option3`, `option4`, `answer`, `location`) VALUES ('$id', '$question', '$optionOne', '$optionTwo', '$optionThree', '$optionFour', '$answer', '$location')";
        mysqli_query($connection, $insertSql);

        
        $_SESSION["addMessage"] = "Вопрос успешно добавлен";
    }

    header("Location: ../menu/question.php");
?>