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


    if(isset($_REQUEST["keyword"])){
        $keyword = $_REQUEST["keyword"];
        $select;

        if($keyword == "best_price"){
            $select = "SELECT * FROM products ORDER BY harga ASC LIMIT 24";
        } else if($keyword == "best_seller") {
            $select = "SELECT p.id AS id, p.name AS name, p.image AS image, p.harga AS harga, COUNT(h.id_product) AS sum_history
                FROM products p
                LEFT JOIN history_products h
                ON p.id = h.id_product
                GROUP BY p.id, p.name
                ORDER BY sum_history DESC
                LIMIT 24";
        } else {
            $select = "SELECT * FROM products ORDER BY rand() LIMIT 24";
        }
        
        $stmt = $conn->prepare($select);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = $result->fetch_all(MYSQLI_ASSOC);
    }

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
            <div class="featured_slider_item">
                <div class="border_active"></div>
                    <a href="../product/product.php?id_product=<?= $value["id"] ?>" style="color: black;">
                        <div class="product_item d-flex flex-column align-items-center justify-content-center text-center">
                            <div class="product_image d-flex flex-column align-items-center justify-content-center">
                                <img src="../../<?= $value["image"] ?>">
                            </div> 
                            <div class="product_content">
                                <div class="product_price">Rp <?= number_format($value["harga"], 0, ".", ".") ?></div>
                                <div class="product_name"><div><a href="product.html"><?= cutString($value["name"], 30) ?></a></div></div>
                                <div class="product_extras">
                                    <a href="../product/product.php?id_product=<?= $value["id"] ?>">
                                        <button class="product_cart_button">Add to Cart</button>
                                    </a>
                                </div>
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
                        </div>
                    </a>
            </div>
        <?php
        }
    }
?>