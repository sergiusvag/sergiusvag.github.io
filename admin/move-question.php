<?php

    require_once '../includes/connect.php';	

    $questionIdToMove = $_POST["id"];

	session_start();

    do {
        $id += 1;
        $idRowSql = mysqli_query($connection, "SELECT * FROM `questions` WHERE id = '$id'");
    } while (mysqli_num_rows($idRowSql) > 0);

    $questionRow = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM `suggestions` WHERE `id` = '$questionIdToMove'"));

    if ($questionRow) {
        $question = $questionRow["question"];
        $optionOne = $questionRow["option1"];
        $optionTwo = $questionRow["option2"];
        $optionThree = $questionRow["option3"];
        $optionFour = $questionRow["option4"];
        $answer = $questionRow["answer"];
        $location = $questionRow["location"];
    
        $insertSql = "INSERT INTO `questions` (`id`, `question`, `option1`, `option2`, `option3`, `option4`, `answer`, `location`) VALUES ('$id', '$question', '$optionOne', '$optionTwo', '$optionThree', '$optionFour', '$answer', '$location')";
        $insert = mysqli_query($connection, $insertSql);

        if($insert) {
            $delete = mysqli_query($connection, "DELETE FROM `suggestions` WHERE `suggestions`.`id` = '$questionIdToMove'");
            if ($delete) {
                $_SESSION["Message"] = "Вопрос успешно добавлен в базу";
            } else {
                $_SESSION["Message"] = "Ошибка удаления";
            }
        } else {
            $_SESSION["Message"] = "Ошибка добавления";
        }
    } else {
        $_SESSION["Message"] = "Ошибка вопрос не найден";
    }
    header("Location: ../admin/index.php");





?>