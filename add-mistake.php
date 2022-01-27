<?php

	require_once '../XO/includes/connect.php';

	session_start();

    $questionId = $_POST["id"];
    $mistake = $_POST["mistake"];

    $id = 0;
    $tableNameToAdd = $_POST["tableName"];

    $questionById = mysqli_query($connection, "SELECT * FROM `questions` WHERE `id` = '$questionId'");

    if(mysqli_num_rows($questionById) > 0) {
        if($questionId == '' || $mistake == ''){
            $_SESSION["addmistake"] = "Ошибка: Пустое Поле";
        } else {

            do {
                $id += 1;
                $idRowSql = mysqli_query($connection, "SELECT * FROM `$tableNameToAdd` WHERE id = '$id'");
            } while (mysqli_num_rows($idRowSql) > 0);

            $insertSql = "INSERT INTO `$tableNameToAdd` (`id`, `questionId`, `mistake`) VALUES ('$id', '$questionId', '$mistake')";
            mysqli_query($connection, $insertSql);

            
            $_SESSION["addmistake"] = "Ошибка успешно добавлена";
        }
    } else {
        $_SESSION["addmistake"] = "Вопрос под номером №'$questionId' не найден";
    }

    header("Location: ../menu/mistake.php");
?>