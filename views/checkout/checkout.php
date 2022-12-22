<?php
    namespace Midtrans;

    require_once("../../core/connection.php");

    // MIDTRANS
    require_once("../../core/Midtrans.php");
    Config::$serverKey = 'SB-Mid-server-sflLw7nCXe5RuJ0j5Ar6hC5S';
    Config::$clientKey = 'SB-Mid-client-Ngy3me4GyFzaauNa';
    Config::$isSanitized = true;
    Config::$is3ds = true;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>

    <?php require_once("../../core/cdn.php"); ?>
    <!-- WAJIB INCLUDE DI SEMUA PAGE -->
    <?php require_once("../../templates/sweet_alert/sweet_alert.php"); ?>
    <!-- INCLUDE JIKA PAKAI SWEET ALERT -->

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="../main.css">
    <link rel="stylesheet" type="text/css" href="style_checkout.css">
    <link rel="stylesheet" href="checkout_responsive.css">
</head>

<body>
    <?php
        if(!isset($_SESSION['id_user'])){
            header("location:../login/login.php");	
        }else{
            $idusercart = $_SESSION['id_user'];
            
        }     
        $result = $conn->query("SELECT id_product, id_color, amount from carts where id_user = '$idusercart'")->fetch_all(MYSQLI_ASSOC);

        if(count($result) == 0){
            $_SESSION['swal'] = "error~Pilih items dahulu sebelum checkout!";
            header("Location:../cart/cart.php");
        }

        $subtotal = 0;

        $discounts = $conn->query("SELECT * from discounts")->fetch_all(MYSQLI_ASSOC);
    ?>

    <div class="super_container">

        <!-- NAVBAR -->
        <?php require_once("../../templates/navbar/navbar.php"); ?>

        <!-- CONTENT -->
        <div class="content_wrapper">

            <!-- TITLE -->
            <div class="cart_title mb-4">Checkout</div>

            <div class="row">

                <!-- TABLE -->
                <div class="col-12 col-xl-8 mb-3">
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
                            </div>

                            <?php
                                foreach ($result as $r){
                                        $product = $conn->query("SELECT * from products where id = '$r[id_product]'")->fetch_assoc();
                                        $color = $conn->query("SELECT name from colors where id = '$r[id_color]'")->fetch_assoc();

                                        $subtotal += $r['amount'] * $product['harga'];

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
                                    Rp <?= number_format($product['harga'], 0, ".", ".");  ?>
                                </div>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>

                <!-- PAYMENT -->
                <div class="col-10 col-xl-4">
                    <div class="payment_wrapper">
                        <h3 class="text-center">Payment</h3>
                        <hr class="mx-auto mb-4" style="margin-top: 0px; width: 62%;">

                        <div class="isi px-3">
                            <div class="row">
                                <div class="col-6 col-md-4 col-lg-2 col-xl-5">
                                    <p class="pcheckout" style="font-weight: bold;">Subtotal : </p>
                                </div>
                                <div class="col text-end">
                                    <p class="pcheckout">Rp <?= number_format($subtotal, 0, ".", ".");  ?></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <p class="pcheckout" style="font-weight: bold;">Voucher : </p>
                                </div>
                                <div class="col text-end">
                                    <select class="selectpicker" data-size="5" data-width="100%" title="Pilih voucher"
                                        data-style="btn-primary" id="voucher" name="voucher" required>
                                        <?php foreach($discounts as $discount) {?>
                                        <option value=<?php echo $discount['id']?> data-subtext=<?= $discount['potongan'] . "%" ?>><?php echo $discount['name']?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-4 col-lg-2 col-xl-5">
                                    <p class="pcheckout" style="font-weight: bold;">Total : </p>
                                </div>
                                <div class="col text-end">
                                    <p class="pcheckout marginLeftminus" id="tuotal">Rp <?= number_format($subtotal) ?></p>
                                </div>
                            </div>

                            <!-- Order Total -->
                            <div class=" d-flex justify-content-end cart_buttons">
                                    <input type="hidden" id="total" value=<?= $subtotal ?>>
                                    <button type="submit" id="pay"
                                        class="button d-flex justify-content-center align-items-center cart_button_checkout">Pay</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- FOOTER -->
        <?php require_once("../../templates/footer/footer.php"); ?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo Config::$clientKey;?>"></script>

    <script>
    $(document).ready(function() {
        $("#voucher").change(function(){
            let idVoucher = $(this).val();
            let total = <?= $subtotal ?>;

            if (idVoucher != "")
            $.ajax({
                type: "get",
                url: "./hitung.php",
                beforeSend: function() {
                    Swal.showLoading();
                },
                data: {
                    'idVoucher': idVoucher,
                    'total' : total
                },
                success: function(response) {
                    $("#total").val(response);
                    $("#tuotal").html("Rp " + new Intl.NumberFormat().format(response))
                    Swal.close()
                }
            })


        })

        $("#pay").click(function(){
            let idVoucher = $("#voucher").val();
            let total = $("#total").val();

            $.ajax({
                type: "get",
                url: "./midtrans.php",
                beforeSend: function() {
                    Swal.showLoading();
                },
                data: {
                    'idVoucher': idVoucher,
                    'total' : total,
                    'subtotal' : <?= $subtotal ?>
                },
                success: function(response) {
                    Swal.close()
                    snap.pay(response, {
                        onSuccess: function(){
                            $.ajax({
                                type: "get",
                                url: "./success.php",
                                beforeSend: function() {
                                    Swal.showLoading();
                                },
                                data: {
                                    'idVoucher' : idVoucher,
                                    'total' : total,
                                    'subtotal' : <?= $subtotal ?>,
                                },
                                success: function(){
                                    Swal.close()
                                    window.location = "../history/history.php";
                                }
                            })
                        }
                    })
                }
            })

        })


    })
    </script>
</body>

</html>