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


    if(isset($_REQUEST["data"])){
        $data = json_decode(stripslashes($_REQUEST['data']), true);
        $select = "SELECT * FROM products";

        for ($i=0; $i < count($data); $i++) { 
            if($i == 0){
                $select .= " WHERE ";
            } else {
                $select .= " AND ";
            }
            $select .= $data[$i];
        }

        $stmt = $conn->query($select);
    } else {
        $stmt = $conn->query("SELECT * FROM products");
    }

    $products = $stmt->fetch_all(MYSQLI_ASSOC);

    function cutString($string, $jumlah){
        $cutted = $string;
        if (strlen($string) > $jumlah){
            $cutted = explode( "\n", wordwrap($string, $jumlah));
            $cutted = $cutted[0] . "...";
        }
        return $cutted;
    }
?>

<?php
    if(isset($products) && $products !== null){
        foreach ($products as $key => $value) {
        ?>
            <div class="product_item">
                <a href="../product/product.php?id_product=<?= $value["id"] ?>" style="color: black;">
                    <div class="product_border"></div>
                    <div class="product_image mx-auto d-flex flex-column align-items-center justify-content-center">
                        <img src="../../<?= $value["image"] ?>">
                    </div>
                    <div class="product_content">
                        <div class="product_price">Rp <?= number_format($value["harga"], 0, ".", ".") ?></div>
                        <div class="product_name"><div><?= cutString($value["name"], 25); ?></div></div>
                    </div>
                    <input type="hidden" class="id_product_hidden" name="hidden" value='<?= $value["id"] ?>'>
                    <div class="product_fav <?php
                        if(isset($_SESSION["id_user"])){
                            $stmt = $conn->query("SELECT * FROM wishlists WHERE id_user='$_SESSION[id_user]' AND id_product='$value[id]'");

                            if($stmt->num_rows > 0){
                                echo "active";
                            }
                        }
                    ?>"><i class="fas fa-heart"></i></div>
                </a>
            </div>
        <?php
        }
    }
?>