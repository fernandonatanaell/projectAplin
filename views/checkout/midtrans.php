<?php
    namespace Midtrans;
    require_once("../../core/Midtrans.php");
    session_start();

    $connectionName = "bgiktzigtizcg5etbmcu-mysql.services.clever-cloud.com";
    $username = "ufzmbdhbnlbtliyj";
    $password = "6NEFoFcVMbxcLXAy5PS3";
    $db = "bgiktzigtizcg5etbmcu";

    $conn = new \mysqli($connectionName, $username, $password, $db);
    if ($conn->connect_errno) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    

    // MIDTRANS
    
    Config::$serverKey = 'SB-Mid-server-sflLw7nCXe5RuJ0j5Ar6hC5S';
    Config::$clientKey = 'SB-Mid-client-Ngy3me4GyFzaauNa';
    Config::$isSanitized = true;
    Config::$is3ds = true;

    $idusercart = $_SESSION['id_user'];

    $enable_payments = array('credit_card');

    $transaction_details = array(
        'order_id' => rand(),
        'gross_amount' => 100000, // no decimal allowed for creditcard
    );

    $items = $conn->query("SELECT products.name as name, products.harga as price, carts.id_product as id, colors.name as color, carts.amount as quantity from carts, products, colors where products.id = carts.id_product and colors.id = carts.id_color and carts.id_user = '$idusercart'")->fetch_all(MYSQLI_ASSOC);

    $item_details = array();

    foreach($items as $i){
        array_push($item_details, array(
            'id' => $i['id'],
            'price' => $i['price'],
            'quantity' => $i['quantity'],
            'name' => $i['name'] . " (" . $i['color'] . ") "
        ));
    }


    if (trim($_REQUEST['idVoucher']) != ""){
        $discount = $conn->query("SELECT kode from discounts where id = '$_REQUEST[idVoucher]'")->fetch_assoc();
        array_push($item_details, array(
            'id' => 'D' . $_REQUEST['idVoucher'],
            'price' => $_REQUEST['total'] - $_REQUEST['subtotal'],
            'quantity' => 1,
            'name' => $discount['kode']
        ));
    }

    $customer = $conn->query("SELECT name from users where id = '$idusercart'")->fetch_assoc();

    $customer_details = array(
        'first_name' => $customer['name']
    );

    $transaction = array(
        'enabled_payments' => $enable_payments,
        'transaction_details' => $transaction_details,
        'customer_details' => $customer_details,
        'item_details' => $item_details
    );

    $snap_token = '';

    try {
        $snap_token = Snap::getSnapToken($transaction);
        echo $snap_token;
    }
    catch (\Exception $e) {
        echo $e->getMessage();
    }

?>