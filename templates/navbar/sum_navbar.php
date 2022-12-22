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
        
        if($action == "count_wishlist"){ // WISHLIST COUNT
            $stmt = $conn->query("SELECT COUNT(*) AS TOTAL_WISHLIST FROM wishlists WHERE id_user='$_SESSION[id_user]'");
            $row = $stmt->fetch_row();
            echo $row[0];
        } else { // CART TOTAL SUM
            $stmt = $conn->query("SELECT SUM(amount) FROM carts WHERE id_user='$_SESSION[id_user]'");
            $tmp_cart = $stmt->fetch_row();
            if($tmp_cart[0] != "")
                $count_cart = $tmp_cart[0];
            else 
                $count_cart = 0;

            $stmt = $conn->query("SELECT SUM(products.harga * carts.amount) AS TOTAL_CART FROM carts 
            LEFT JOIN products on products.id = carts.id_product WHERE carts.id_user = '$_SESSION[id_user]'");
            $sum_cart = $stmt->fetch_row();
            $total = number_format($sum_cart[0], 0, ".", ".");
            
            echo "Rp $total~$count_cart";
        }
    }
?>
