<?php
    require_once("../../core/connection.php");

    if(!isset($_SESSION["id_user"])){
        header("Location: ../login/login.php");
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>

    <?php require_once("../../core/cdn.php"); ?> <!-- WAJIB INCLUDE DI SEMUA PAGE -->
    <?php require_once("../../templates/sweet_alert/sweet_alert.php"); ?> <!-- INCLUDE JIKA PAKAI SWEET ALERT -->
    <link rel="stylesheet" type="text/css" href="../../templates/plugins/slick-1.8.0/slick.css">

    <link rel="stylesheet" href="../main.css">
    <link rel="stylesheet" href="../../templates/card/style.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../../templates/loading/loading.css">
    <link rel="shortcut icon" type="ico" href="../../favicon.ico"/>

</head>
<body>
    <div class="super_container">

        <!-- NAVBAR -->
        <?php require_once("../../templates/navbar/navbar.php"); ?>

        <!-- CONTENT -->
        <div class="container mb-5" style="width: 90%;">
            <h2 class="text-center mt-4">Wishlist</h3>
            <div class="row" id="content_card" style="margin-top: -5px;">
                <!-- YOUR CONTENT -->

            </div>
        </div>

        <br>

        <!-- FOOTER -->
        <?php require_once("../../templates/footer/footer.php"); ?>

        <!-- LOADING OVERLAY -->
        <div id="overlay">
            <div class="cv-spinner">
                <span class="spinner"></span>
            </div>
        </div>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="../../templates/plugins/slick-1.8.0/slick.js"></script>

    <script>
        function loadProduct() {
            $.ajax({
                type: "POST",
                url: "../controller/loadWishlist.php",
                beforeSend: function() {
                    $("#overlay").fadeIn(300);
                },
                success: function (data) {
                    $("#content_card").html(data);
                    setTimeout(function(){
                        $("#overlay").fadeOut(300);
                    },500);
                }
            });
        }

        $('#content_card').on('click', '.product_fav', function (e) {
            e.preventDefault();
            let element = $(this);
            let id_product = element.parent().find(".id_product_hidden").val();
            let id_user = $("#id_user_now").val();

            if(id_user != "-1"){
                $( this ).toggleClass("active");
                $.ajax({
                    type: "POST",
                    url: "../controller/products.php",
                    beforeSend: function() {
                        $("#overlay").fadeIn(300);
                    },
                    data: {
                        'action' : "wishlist",
                        'id_user' : id_user,
                        'id_product' : id_product
                    },
                    success: function (data) {
                        let tmpData = data.trim();
                        if(tmpData != ""){
                            let result = tmpData.split("~");
                            let tmpTitle;

                            if(result[0] == "success") tmpTitle = "Yeay!!";
                            else tmpTitle = "Oops!";

                            loadProduct();
                            // AMBIL FUNCTION DARI SCRIPT NAVBAR
                            loadCountWishlist(id_user);

                            swal({
                                title: tmpTitle,
                                text: result[1],
                                type: result[0]
                            });
                        }
                        setTimeout(function(){
                            $("#overlay").fadeOut(300);
                        },500);
                    }
                });
            } else {
                window.location = "../login/login.php";
            }
        });

        loadProduct();
    </script>

</body>
</html>