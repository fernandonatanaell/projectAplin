<?php
    require_once("../../core/connection.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>

    <?php require_once("../../core/cdn.php"); ?>
    <!-- WAJIB INCLUDE DI SEMUA PAGE -->
    <?php require_once("../../templates/sweet_alert/sweet_alert.php"); ?>
    <!-- INCLUDE JIKA PAKAI SWEET ALERT -->

    <link rel="stylesheet" href="../main.css">
    <link rel="stylesheet" type="text/css" href="style_cart.css">
    <link rel="stylesheet" type="text/css" href="cart_responsive.css">

</head>

<body>
    <?php
        if(!isset($_SESSION['id_user'])){
            header("location:../login/login.php");	
        }else{
            $idusercart = $_SESSION['id_user'];
            
        }     

        if(isset($_REQUEST['btncheckout'])){
            header("location:../checkout/checkout.php");
        }
        $result = $conn->query("SELECT id_product, id_color, amount from carts where id_user = '$idusercart'")->fetch_all(MYSQLI_ASSOC);
        $total = 0;
	?>

    <div class="super_container">
        <!-- NAVBAR -->
        <?php require_once("../../templates/navbar/navbar.php"); ?>

        <!-- CONTENT -->
        <div class="content_wrapper">

            <!-- TITLE -->
            <div class="cart_title mb-4">Shopping Cart</div>

            <!-- TABLE -->
            <div class="table_wrapper ">
                <div class="table">
                    <div class="row_table header">
                        <div class="cell cart_item_title">
                            Name
                        </div>
                        <div class="cell cart_item_title">
                            Color
                        </div>
                        <div class="cell cart_item_title cell_amount">
                            Quantity
                        </div>
                        <div class="cell cart_item_title">
                            Price
                        </div>
                        <div class="cell cart_item_title">
                            Total
                        </div>
                    </div>

                    <?php
                        foreach ($result as $r){
                            $product = $conn->query("SELECT * from products where id = '$r[id_product]'")->fetch_assoc();
                            $color = $conn->query("SELECT name from colors where id = '$r[id_color]'")->fetch_assoc();

                            $subtotal = $r['amount'] * $product['harga'];
                            $total += $subtotal;
                            ?>
                                <div class="row_table">
                                    <div class="cell" data-title="Name">
                                        <?= $product['name'] ?>
                                    </div>
                                    <div class="cell" data-title="Color">
                                        <?= $color['name'] ?>
                                    </div>
                                    <div class="cell cell_amount" data-title="Quantity">
                                        <?= $r['amount'] ?>
                                    </div>
                                    <div class="cell" data-title="Price">
                                        Rp <?= number_format($product['harga']) ?>
                                    </div>
                                    <div class="cell" data-title="Total">
                                        Rp <?= number_format($subtotal) ?>
                                    </div>
                                </div>
                            <?php
                        }
                    ?>
                </div>
            </div>

            <!-- Order Total -->
            <div class="order_total">
                <div class="order_total_content text-md-right">
                    <div class="order_total_title">Order Total :</div>
                    <div class="order_total_amount">Rp <?php echo number_format($total) ?></div>
                </div>
            </div>

            <div class="d-flex justify-content-end cart_buttons">
                <button type="button" name="btnclear" class="button cart_button_clear">Clear</button>
                <form action="#" method="POST">
                    <button type="submit" name="btncheckout" value=<?php echo count($result) ?> class="button cart_button_checkout">Check
                        out</button>
                </form>
            </div>

        </div>

        <!-- FOOTER -->
        <?php require_once("../../templates/footer/footer.php"); ?>

        <script>
        $(".cart_button_clear").click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Clear cart?',
                text: 'Apakah anda ingin clear cart?',
                showCancelButton: true,
                type: 'danger',
                cancelButtonText: "Batal",
                confirmButtonText: "Ya hapus!",
            }).then((result) => {
                if (result['value'] == true) {
                    $.ajax({
                        type: "get",
                        url: "clear.php",
                        success: function(response) {
                            Swal.fire(
                                'Yeay!!',
                                'Berhasil menghapus cart',
                                'success'
                            )
                            window.location = "../homepage/homepage.php";

                        }
                    })
                }
            })
        })
        </script>

    </div>
</body>

</html>