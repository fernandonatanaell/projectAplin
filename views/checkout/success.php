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

    $id_user = $_SESSION['id_user'];
    $subtotal = $_REQUEST['subtotal'];
    $id_discount = $_REQUEST['idVoucher'];
    if (trim($id_discount) == "") $id_discount = null;

    $total = $_REQUEST['total'];
    
    $q = $conn->prepare("INSERT INTO history(id_user, subtotal, id_discount, total) VALUES(?,?,?,?)");
    $q->bind_param("iiii", $id_user, $subtotal, $id_discount, $total);
    $result =$q->execute();

    $id_history = $conn->insert_id;

    $items = $conn->query("SELECT * from carts where id_user = '$id_user'")->fetch_all(MYSQLI_ASSOC);

    foreach ($items as $i){
        $query = "INSERT INTO history_products(id_history, id_product, id_color, amount) values($id_history, $i[id_product], $i[id_color], $i[amount])";
        mysqli_query($conn, $query);

        $query = "UPDATE products SET(stock = stock - $i[amount]) where id = $i[id_product]";
        mysqli_query($conn, $query);
    }

    $query = "DELETE FROM carts where id_user = '$id_user'";
    mysqli_query($conn, $query);



