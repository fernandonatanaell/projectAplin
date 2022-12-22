<?php

    // START CONNECTION
    session_start();

    $connectionName = "bgiktzigtizcg5etbmcu-mysql.services.clever-cloud.com";
    $username = "ufzmbdhbnlbtliyj";
    $password = "6NEFoFcVMbxcLXAy5PS3";
    $db = "bgiktzigtizcg5etbmcu";
	
	$conn = new mysqli($connectionName, $username, $password, $db);
	if ($conn->connect_errno) {
        die("Connection failed: " . $conn->connect_error);
    }
    // END CONNECTION


    if(isset($_REQUEST["action"])){
        $action = $_REQUEST["action"];
        $id_user = $_REQUEST["id_user"];
        $id_product = $_REQUEST["id_product"];

        $stmt = $conn->query("SELECT * FROM wishlists WHERE id_user='$id_user' AND id_product='$id_product'");

        if($stmt->num_rows > 0){
            $result = $conn->query("DELETE FROM wishlists WHERE id_user='$id_user' AND id_product='$id_product'");

            if($result){
                echo "success~Berhasil menghapus barang dari wishlist";
            } else {
                echo "error~Gagal menghapus barang dari wishlist";
            }
        } else {
            $stmt = $conn->prepare("INSERT INTO wishlists(id_user, id_product) VALUES(?,?)");
            $stmt->bind_param("ii", $id_user, $id_product);
            $result = $stmt->execute();

            if($result){
                echo "success~Berhasil menambah barang ke dalam wishlist";
            } else {
                echo "error~Gagal menambah barang ke dalam wishlist";
            }
        }
    }
?>