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

    $products = $conn->query("SELECT * From history_products where id_history = '$id'")->fetch_all(MYSQLI_ASSOC);
    $sel = mysqli_query($conn,"select subtotal as allcount from history where id = '$id'");
    $records = mysqli_fetch_assoc($sel);
    $subtotal = $records['allcount'];

?>
    <table class="table" border=1 style="width: 100%; height: 60%; overflow-y: scroll;">
        <thead>
            <tr>
                <th>Product</th>
                <th>Color</th>
                <th>Amount</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
    <?php

    foreach ($products as $product){
        $theProduct = $conn->query("select * from products where id = '$product[id_product]'")->fetch_assoc();
        $color = $conn->query("select * from colors where id = '$product[id_color]'")->fetch_assoc();

        ?>
        <tr>
            <td><?= $theProduct['name'] ?></td>
            <td><?= $color['name'] ?></td>
            <td><?= $product['amount'] ?></td>
            <td><?= number_format($theProduct['harga'])?></td>
            <td><?= number_format($theProduct['harga'] * $product['amount'])?></td>
        </tr>
<?php
    }

?>
    </tbody>
    </table>

    <h2>Subtotal : Rp <?= number_format($subtotal) ?></h2>