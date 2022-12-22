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

    $id = $_REQUEST['id'];

    date_default_timezone_set('Asia/Jakarta');
    $date = date("Y-m-d H:i:s");

    $res = $conn->prepare("UPDATE history SET status='1', updated_at = '$date' WHERE id='$id'");

    $res->execute();
?>
    