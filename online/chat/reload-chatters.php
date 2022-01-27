<?php

    $connection = new mysqli("localhost", "root", "", "xobible");

    if($connection->connect_error) {
        exit('Could not connect');
    }

    session_start();
    $login = $_SESSION["gameUser"]["login"];
    $logedUsers = mysqli_query($connection, "SELECT * FROM chat_logedchatters WHERE NOT `login` = '$login';");
    $logedUsersList = [];

    while ($logedUser = mysqli_fetch_assoc($logedUsers)) {
        $logedUsersList[] = $logedUser;
    }

    echo json_encode($logedUsersList);
?>