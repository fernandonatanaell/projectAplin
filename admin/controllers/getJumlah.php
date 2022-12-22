<?php
    session_start();

    $connectionName = "bgiktzigtizcg5etbmcu-mysql.services.clever-cloud.com";
    $username = "ufzmbdhbnlbtliyj";
    $password = "6NEFoFcVMbxcLXAy5PS3";
    $db = "bgiktzigtizcg5etbmcu";
	
	$conn = new mysqli($connectionName, $username, $password, $db);
	if ($conn->connect_errno) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "select * from discounts";
    $discounts = mysqli_query($conn, $query);

    echo "Jumlah discount : " . mysqli_num_rows($discounts);

?>