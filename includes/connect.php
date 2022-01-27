<?php

	$connection = new mysqli("localhost", "root", "", "xobible");

    if($connection->connect_error) {
		  exit('Could not connect');
    }
?>