<?php

    require_once 'includes/connect.php';

    if($connection->connect_error) {
        exit('Could not connect');
    } else {
        $sql = "SELECT * FROM `questions`";    
        $questions = mysqli_query($connection, $sql);
        $questionsList = [];

        while ($question = mysqli_fetch_assoc($questions)) {
            $questionsList[] = $question;
        }
        echo json_encode($questionsList);
    }
?>
