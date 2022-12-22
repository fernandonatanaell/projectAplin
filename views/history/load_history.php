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

    $action=$_REQUEST['action'];
    $idusercart=$_SESSION['id_user'];

    if($action=='all'){
        $history = $conn->query("SELECT * from history where id_user = '$idusercart' order by id desc")->fetch_all(MYSQLI_ASSOC);
    }else if($action=='awaiting'){
        $history = $conn->query("SELECT * from history where id_user = '$idusercart' and status=0 order by id desc")->fetch_all(MYSQLI_ASSOC);
    }else {
        $history = $conn->query("SELECT * from history where id_user = '$idusercart' and status=1 order by id desc")->fetch_all(MYSQLI_ASSOC);
    }

    
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
                                                        <div class=" col-md-6">
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
                                                        <div class="col-md-2"> 
                                                            <button onclick="window.location='../product-review/productreview.php?id_history_products=<?= $val['id']?>'" class="btn  
                                                            <?php
                                                                if($value['updated_at']==null) echo "btn-warning disabled";
                                                                 else if($val['id_ratings']==-1) echo "btn-primary";
                                                                  else echo "btn-success disabled"  ;

                                                            ?>"
                                                                style="height:40px; width:115px; font-size:15px; margin-top:100px; margin-left:100px;">
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
