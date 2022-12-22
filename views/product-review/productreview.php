<?php
    require_once("../../core/connection.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shop Item - Start Bootstrap Template</title>
        <?php require_once("../../core/cdn.php"); ?> <!-- WAJIB INCLUDE DI SEMUA PAGE -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link rel="stylesheet" href="../main.css">
        <style>
            textarea:focus{
                outline-color:#0e8ce4;
            }
        </style>
    </head>
    <body>
        <?php
            $id = $_REQUEST['id_history_products'];
            $result = $conn->query("SELECT * from history_products where id = '$id'")->fetch_assoc();
            $product = $conn->query("SELECT * FROM products WHERE id = '$result[id_product]'")->fetch_assoc();
            $history = $conn->query("SELECT created_at, updated_at from history where id='$result[id_history]'")->fetch_assoc();
            $color = $conn->query("SELECT name from colors where id = '$result[id_color]'")->fetch_assoc();

        ?>
        <!-- Navigation-->
        <?php require_once("../../templates/navbar/navbar.php");?>
        <section class="py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" height="500px" src="../../<?=$product['image']?>" alt="..." /></div>
                    <div class="col-md-6">
                        <h2 class=" fw-bolder"><?=$product['name']?></h2>
                        <div class="row">
                            <div class="col-md-3 text-black-50">Jumlah Pembelian</div>
                            <div class="col-md-2"><?=$result['amount']?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-black-50">Warna</div>
                            <div class="col-md-2"><?=$color['name']?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-black-50">Tanggal Pembelian</div>
                            <div class="col-md-2"><?=$history['created_at']?></div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-3 text-black-50">Tanggal Diterima</div>
                            <div class="col-md-2"><?=$history['updated_at']?></div>
                        </div>
                        <div class="row">
                            <label class="text-black-50">Bagaimana kualitas produk ini</label>
                            <div class="col-md-12">
                                <i id="1star" onmouseover="star1()" class="bi-star-fill" style="font-size: 2rem; color:#ffc107;"></i>
                                <i id="2star" onmouseover="star2()" class="bi-star" style="font-size: 2rem; color:#ffc107;"></i>
                                <i id="3star" onmouseover="star3()" class="bi-star" style="font-size: 2rem; color:#ffc107;"></i>
                                <i id="4star" onmouseover="star4()" class="bi-star" style="font-size: 2rem; color:#ffc107;"></i>
                                <i id="5star" onmouseover="star5()" class="bi-star" style="font-size: 2rem; color:#ffc107;"></i>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <!--Form-->
                                <form>
                                    <label class="" style="font-size:12pt;">Berikan ulasan untuk produk ini</label>
                                    <textarea id="textDeskripsi" class="formcontrol p-2" style="width:90%; height:100px; border-radius: 5px;" placeholder="Tulis deskripsi anda mengenai produk ini"></textarea><br>
                                    <input id="btnAddreview" class="btn btn-primary p-2 mt-2 fw-bold" style="width:100px;" type="submit" value="Kirim">
                                </form>
                            </div>
                        </div>        
                    </div>
                </div>
            </div>
        </section>



        <!-- Footer-->
        <?php require_once("../../templates/footer/footer.php"); ?>
    </body>
</html>
<script>
    var rate = 1;
    function star1(){
        document.getElementById("1star").className = "bi-star-fill";
        document.getElementById("2star").className = "bi-star";
        document.getElementById("3star").className = "bi-star";
        document.getElementById("4star").className = "bi-star";
        document.getElementById("5star").className = "bi-star";
        rate = 1;
    }
    function star2(){
        document.getElementById("1star").className = "bi-star-fill";
        document.getElementById("2star").className = "bi-star-fill";
        document.getElementById("3star").className = "bi-star";
        document.getElementById("4star").className = "bi-star";
        document.getElementById("5star").className = "bi-star";
        rate = 2;
    }
    function star3(){
        document.getElementById("1star").className = "bi-star-fill";
        document.getElementById("2star").className = "bi-star-fill";
        document.getElementById("3star").className = "bi-star-fill";
        document.getElementById("4star").className = "bi-star";
        document.getElementById("5star").className = "bi-star";
        rate = 3;
    }
    function star4(){
        document.getElementById("1star").className = "bi-star-fill";
        document.getElementById("2star").className = "bi-star-fill";
        document.getElementById("3star").className = "bi-star-fill";
        document.getElementById("4star").className = "bi-star-fill";
        document.getElementById("5star").className = "bi-star";
        rate = 4;
    }
    function star5(){
        document.getElementById("1star").className = "bi-star-fill";
        document.getElementById("2star").className = "bi-star-fill";
        document.getElementById("3star").className = "bi-star-fill";
        document.getElementById("4star").className = "bi-star-fill";
        document.getElementById("5star").className = "bi-star-fill";
        rate = 5;
    }
    $("#btnAddreview").click(function(){
        $.ajax({
                type: "post",
                url: "insertreview.php",
                data: {
                    rate: rate,
                    review: $("#textDeskripsi").val(),
                    id_product: <?php echo $product['id']?>,
                    id_user: <?php echo $_SESSION["id_user"]?>,
                    id: <?php echo $id?>
                },
                success:function(response){
                    window.location = '../history/history.php';
                    
                }
            })
    })
</script>
