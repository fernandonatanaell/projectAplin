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


    if(isset($_SESSION["id_user"])){
        $id_user = $_SESSION["id_user"];
        
        $stmt = $conn->query("SELECT * FROM wishlists WHERE id_user='$id_user'");
        if($stmt->num_rows > 0)
            $wishlists = $stmt->fetch_all(MYSQLI_ASSOC);
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
    if(isset($wishlists)){
        if($wishlists !== null){
            foreach ($wishlists as $key => $value) {
                $stmt = $conn->query("SELECT * FROM products WHERE id='$value[id_product]'");
                $products = $stmt->fetch_assoc();
                ?>
                    <div class="col col-md-3 col-xl-2 mx-3">
                        <a href="../product/product.php?id_product=<?= $products["id"] ?>" style="color: black;">
                            <div class="featured_slider_item card_product">
                                <div class="product_item d-flex flex-column align-items-center justify-content-center text-center">
                                    <div class="product_border"></div>
                                    <div class="product_image mx-auto d-flex flex-column align-items-center justify-content-center">
                                        <img src="../../<?= $products["image"] ?>">
                                    </div>
                                    <div class="product_content">
                                        <div class="product_price">Rp <?= number_format($products["harga"], 0, ".", ".") ?></div>
                                        <div class="product_name"><div><?= cutString($products["name"], 20); ?></div></div>
                                    </div>
                                    <input type="hidden" class="id_product_hidden" name="hidden" value='<?= $products["id"] ?>'>
                                    <div class="product_fav active"><i class="fas fa-heart"></i></div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php
            }
        } else {
            echo "<h3 class='text-center' style='color: grey; margin-top: 90px; margin-bottom: 40px;'>You don't have any wishlist yet..</h3>";
        }
    } else {
        echo "<h3 class='text-center' style='color: grey; margin-top: 90px; margin-bottom: 40px;'>You don't have any wishlist yet..</h3>";
    }
?>