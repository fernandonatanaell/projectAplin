<?php
    require_once("../../core/connection.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>

    <?php require_once("../../core/cdn.php"); ?>
    <!-- WAJIB INCLUDE DI SEMUA PAGE -->
    <?php require_once("../../templates/sweet_alert/sweet_alert.php"); ?>
    <!-- INCLUDE JIKA PAKAI SWEET ALERT -->

    <link rel="stylesheet" href="../main.css">
    <link rel="stylesheet" type="text/css" href="style_history.css">

</head>

<body>
    <?php
        if(!isset($_SESSION['id_user'])){
            header("location:../login/login.php");	
        }else{
            $idusercart = $_SESSION['id_user'];
            
        }     
        $history = $conn->query("SELECT * from history where id_user = '$idusercart' order by id desc")->fetch_all(MYSQLI_ASSOC);
    ?>

    <!-- NAVBAR -->
    <?php require_once("../../templates/navbar/navbar.php"); ?>

    <div class="history_section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="history_container">
                        <div class="history_title">Transaction History</div>
                        <div class="history_items">
                            <ul class="history_list">
                                <li class="history_item clearfix">
                                    <div class="history_item_info d-flex flex-md-row flex-column justify-content-between">
                                        <div class="history_status">
                                            Status :
                                            <div class="btn-toolbar status ms-3" role="toolbar"
                                                aria-label="Toolbar with button groups">
                                                <div class="btn-group me-2" role="group" aria-label="First group">
                                                    <button type="button" class="btn btn-primary" id="all">All</button>
                                                    <button type="button" class="btn btn-primary" id="awaiting">Awaiting
                                                        Confirmation</button>
                                                    <button type="button" class="btn btn-primary" id="done">Done</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- loop card -->
                    <div id="loopcard"> 
                    <?php
                            foreach ($history as $key => $value) {
                                $stmt = $conn->query("SELECT * FROM history_products where id_history ='$value[id]' ");
                                $history_product= $stmt->fetch_all(MYSQLI_ASSOC);
                                if($value['id_discount']!=null){
                                    $myquery = $conn->query("SELECT kode FROM discounts where id='$value[id_discount]'")->fetch_assoc();
                                    $discount=$myquery['kode'];
                                }else{
                                    $discount="-";
                                }
                                
                        ?>
                            <div class="card w-100">
                                <div class="card-body">
                                    <div style="margin-bottom:20px;">
                                        <span class="text-black-50">Tanggal Beli : <?= $value['created_at'] ?></span>
                                        <span class="text-black-50"> | </span>
                                        <span class="text-black-50">Tanggal Diterima : <?php 
                                            if($value['updated_at']!==null) {
                                                echo $value['updated_at'];
                                            }else{
                                                echo "-";
                                            }
                                            ?></span>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-9">
                                        <?php
                                            foreach ($history_product as $key => $val) {
                                                $stmt = $conn->query("SELECT * FROM products where id ='$val[id_product]' ");
                                                $product= $stmt->fetch_assoc();
                                                $stmt = $conn->query("SELECT * FROM colors where id ='$val[id_color]' ");
                                                $color= $stmt->fetch_assoc();
                                        ?>
                                                <div class="col">
                                                    <div class="row mb-2">
                                                        <div class="col-md-2">
                                                            <img src="../../<?php echo $product['image'] ?>" width="75px" height="95px">
                                                        </div>
                                                        <div class=" col-md-7">
                                                            <h4><?= $product['name']?></h4>
                                                            <div class="row fs-6">
                                                                <div class="col-md-3 lead" style="font-size:12px;">Warna</div>
                                                                <div class="col-md-5" style="font-size:12px;"> <?= $color['name'] ?></div>
                                                            </div>
                                                            <div class="row fs-6" style="font-size:10px;">
                                                                <div class="col-md-3 lead" style="font-size:12px;">Jumlah</div>
                                                                <div class="col-md-5" style="font-size:12px;"><?= $val['amount']?></div>
                                                            </div>
                                                            <div class="row fs-6">
                                                                <div class="col-md-3 lead" style="font-size:12px;">Harga</div>
                                                                <div class="col-md-5" style="font-size:12px;">Rp <?= number_format($product["harga"], 0, ".", ".") ?></div>
                                                            </div>
                                                            <div class="row fs-6">
                                                                <div class="col-md-3 lead" style="font-size:12px;">Total</div>
                                                                <div class="col-md-5" style="font-size:12px;">Rp <?= number_format($product["harga"]* $val['amount'], 0, ".", ".") ?></div>
                                                            </div>
                                                        </div>
                                                        <div class="col d-flex justify-content-end align-items-end pe-3"> 
                                                            <button onclick="window.location='../product-review/productreview.php?id_history_products=<?= $val['id']?>'" class="btn  
                                                            <?php
                                                                if($value['updated_at']==null) echo "btn-warning disabled";
                                                                else if($val['id_ratings']==-1) echo "btn-primary";
                                                                else echo "btn-success disabled"  ;

                                                            ?>"
                                                                style="height:40px; width:115px; font-size:15px;">
                                                                <?php 
                                                                if($value['updated_at']==null) echo "processed";
                                                                else if($val['id_ratings']==-1) echo "Tulis Review"; 
                                                                else echo "Reviewed" ;
                                                                ?>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <hr style="border:0.5px solid grey;">
                                                    <!-- loop row sampe sini -->
                                                </div>
                                        <?php
                                            }
                                        ?>
                                        </div>
                                        <div class="col-lg-3 col-md-3" style="border-left:0.5px solid grey;">
                                            <div class="row fs-6 mb-2">
                                                <div class="col-md-5 lead fs-6">Subtotal</div>
                                                <div class="col-md-7">Rp <?= number_format($value['subtotal']) ?></div>
                                            </div>
                                            <div class="row fs-6 mb-2">
                                                <div class="col-md-5 lead fs-6">Diskon</div>
                                                <div class="col-md-7"> <?= $discount ?> <hr></div>
                                            </div>
                                            <div class="row fs-6 mb-2">
                                                <div class="col-md-5 lead fs-6">Total</div>
                                                <div class="col-md-7">Rp <?= number_format($value['total']) ?></div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                            }
                        ?>
                        </div>
                    <!-- sampe sini -->
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <?php require_once("../../templates/footer/footer.php"); ?>

    <script> 
        $(document).ready(function(){
            $("#all").click(function(){
                $.ajax({
                    type: "get",
                    url: "./load_history.php",
                    beforeSend: function() {
                        Swal.showLoading();
                    },
                    data: {
                        'action' : "all",
                    },
                    success: function(response){
                        Swal.close()
                        $('#loopcard').html(response);
                    }
                })
            })

            $("#awaiting").click(function(){
                $.ajax({
                    type: "get",
                    url: "./load_history.php",
                    beforeSend: function() {
                        Swal.showLoading();
                    },
                    data: {
                        'action' : "awaiting",
                    },
                    success: function(response){
                        Swal.close()
                        $('#loopcard').html(response);
                    }
                })
            })

            $("#done").click(function(){
                $.ajax({
                    type: "get",
                    url: "./load_history.php",
                    beforeSend: function() {
                        Swal.showLoading();
                    },
                    data: {
                        'action' : "done",
                    },
                    success: function(response){
                        Swal.close()
                        $('#loopcard').html(response);
                    }
                })
            })
        })
    </script>
</body>

</html>