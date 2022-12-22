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

    $idVoucher = $_REQUEST['idVoucher'];
    $total = $_REQUEST['total'];

    $discounts = $conn->query("SELECT * from discounts where id = '$idVoucher'")->fetch_assoc();

    echo $total - (floor($total * ($discounts['potongan'] / 100) / 1000)*1000);