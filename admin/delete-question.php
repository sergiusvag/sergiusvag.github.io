<?php

    require_once '../includes/connect.php';	

    $idToDelete = $_POST["id"];
    $questionId = $_POST["questionId"];
    $tableName = $_POST["tableName"];
    $item = $_POST["item"];
    $return = $_POST["return"];

    $backTo = $_GET["backTo"];

    if (!$backTo) {
        $backTo = $_POST["backTo"];
    }

    $delete = mysqli_query($connection, "DELETE FROM `$tableName` WHERE `$tableName`.`id` = '$idToDelete'");

	session_start();

    if ($delete) {
        $_SESSION["Message"] = "$item №$idToDelete удалён/а";
        if($item == "Ошибка" && $return == 'true') {
            header("Location: ../admin/edit-question.php?id=$questionId&tableName=questions&check=true&backTo=$backTo");
        } else {
            header("Location: ../admin/menu/$backTo.php");
        }
    }
?>