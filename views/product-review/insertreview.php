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
    $id_user = $_REQUEST['id_user'];
    $id_product = $_REQUEST['id_product'];
    $review = $_REQUEST['review'];
    $rate = $_REQUEST['rate'];
    $id = $_REQUEST['id'];
    $conn->query("INSERT INTO ratings(id_user, id_product, rate, review) values('$id_user', '$id_product', '$rate', '$review')");
    $id_rating = $conn->insert_id;
    $conn->query("UPDATE history_products SET id_ratings = $id_rating WHERE id = $id");
    
?>