<?php
    require_once("../../core/connection.php");

    function time_elapsed_string($datetime) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
?>
<?php 
        
        $id = $_REQUEST['id_product'];
        $ratingtot = $conn->query("SELECT AVG(rate) as rata, COUNT(rate) as hitung from ratings where id_product = $id")->fetch_assoc();        
        $terjual = $conn->query("SELECT sum(amount) as hitung from history_products where id_product = $id")->fetch_assoc();
        $ulasan = $conn->query("SELECT count(id) as hitung from ratings where review is not null and id_product = $id")->fetch_assoc();        
        $result = $conn->query("SELECT * from products where id = '$id'")->fetch_assoc();
        $brand = $conn->query("SELECT b.name as name, b.id as id from products p, brands b where b.id = p.id_brands and p.id = '$id'")->fetch_assoc();
        $product = $result['name'];
        $description = $result['description'];
        $berat = $result['berat'];
        $stock = $result['stock'];
        $harga = number_format($result['harga']);
        $image = $result['image'];
        
        if(!isset($_SESSION['id_user'])){
            $iduserwishlist = 0;
        }else{
            $iduserwishlist = $_SESSION['id_user'];
            
        }
        $row2 = mysqli_query($conn, "SELECT * from wishlists WHERE id_user = $iduserwishlist AND id_product = $id");
        $result2 = mysqli_fetch_assoc($row2);
        if($result2 == null){
            $wishlist = 0;
        }else{
            $wishlist = 1;
        }


        if (isset($_REQUEST['addWishlist'])){
            if(!isset($_SESSION["id_user"])){
                header("Location: ../login/login.php");
            }else{
                $id_user = $_SESSION['id_user'];
                $query = "INSERT INTO wishlists(id_user, id_product) values($id_user, $id)";
                mysqli_query($conn, $query);
                $_SESSION['swal'] = "success~Berhasil ditambahkan ke Wishlist";
                header("Location:../product/product.php?id_product=$id");
            }
        }
        if (isset($_REQUEST['removeWishlist'])){
            $id_user = $_SESSION['id_user'];
            $query = "DELETE FROM wishlists WHERE id_user = $id_user AND id_product = $id";
            mysqli_query($conn, $query);
            $_SESSION['swal'] = "success~Berhasil dihapus dari Wishlist";
            header("Location:../product/product.php?id_product=$id");
        }
        if (isset($_REQUEST['addCart'])){
            if(!isset($_SESSION["id_user"])){
                header("Location: ../login/login.php");
            }else{
                $iduser = $_SESSION['id_user'];
                $jumlah = $_REQUEST['inputQuantity'];
                $warna = $_REQUEST['inputColor'];
                $query1 = "SELECT id from carts where id_user = $iduser and id_product = $id and id_color = $warna";
                $row1 = mysqli_query($conn, $query1);
                $result = mysqli_fetch_assoc($row1);
                    if($jumlah < 1){
                        $_SESSION['swal'] = "error~Jumlah yang dimasukkan kurang dari 1";
                        header("Location:../product/product.php?id_product=$id");
                    }else{
                        if($result == null){
                            $query2 = "INSERT INTO carts(id_user, id_product, id_color, amount) values($iduser, $id, $warna, $jumlah)";
                            mysqli_query($conn, $query2);
                            $_SESSION['swal'] = "success~Berhasil menambahkan ke keranjang";
                            header("Location:../product/product.php?id_product=$id");
                        }else{
                            $query3 = "UPDATE carts SET amount = amount + $jumlah WHERE id = '$result[id]'";
                            mysqli_query($conn, $query3);
                            $_SESSION['swal'] = "success~Berhasil menambahkan ke keranjang";
                            header("Location:../product/product.php?id_product=$id");
                        }
                    }
                    
                
            }
        }
        

        
    ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title><?= $product ?></title>
        <?php require_once("../../core/cdn.php"); 
            require_once("../../templates/sweet_alert/sweet_alert.php");
        ?> <!-- WAJIB INCLUDE DI SEMUA PAGE -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link rel="stylesheet" href="../main.css">
        <link rel="shortcut icon" type="ico" href="../../favicon.ico"/>
        <style>
            .button {
                background: #0e8ce4;
                border-radius: 5px;
                padding: 5px;
                color: white;
                text-align: center;
            }

            .button:hover {
                cursor: pointer;
            }
        </style>
    </head>
    <body>
    
        <!-- Navigation-->
        <?php  require_once("../../templates/navbar/navbar.php"); ?>
        <!-- Product section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5">
                    <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="../../<?=$image?>" alt="..." /></div>
                    <div class="col-md-6">
                        <div class="mb-1">
                        <?php
                            $con = 0;
                            $query = "SELECT c.name as catname, pc.id_categories as catid from categories c, products_categories pc where c.id = pc.id_categories and pc.id_products = $id";
                            $result = mysqli_query($conn, $query);
                            WHILE($row = mysqli_fetch_assoc($result)){
                                if ($con != 0){
                                    
                                    echo "<span>,</span>";
                                }
                                $con++;
                                echo "<span><a href='" . "../shop/shop.php?search_category=" . $row['catid'] . "'> " . $row['catname'] . "</a></span>";                                    
                            }
                        ?>
                        <span>/</span>
                        <span class="text-black-50"><?=$product?></span>
                        </div>
                        <h1 class="display-5 fw-bolder"><?=$product?></h1>
                        <span class="fw-normal">Terjual</span>
                        <!--Jumlah Terjual-->
                        <span class="text-black-50"><?=$terjual['hitung']?></span>
                        <span class="fw-bolder"> . </span>
                        <i class="bi-star-fill" style="font-size: 1rem; color:#ffc107;"></i>
                        <!--Jumlah Rating-->
                        <span class="fw-normal"><?=number_format($ratingtot['rata'], 1, ',')?></span>
                        <span class="text-black-50"> (</span>
                        <!--Jumlah Review-->
                        <span class="text-black-50"><?=$ratingtot['hitung']?></span>
                        <span class="text-black-50"> penilaian )</span>
                        
                        <div class="fs-5 mb-5">
                            <span>Rp. <?=$harga?></span>
                        </div>
                        <h4>Spesifikasi</h4>
                        <div class="row fs-6">
                            <div class="col-md-2 lead">Merek</div>
                            <div class="col-md-3"><a href="../shop/shop.php?search_brand=<?= $brand['id']?>"><?=$brand['name']?></a></div>
                        </div>
                        <div class="row fs-6">
                            <div class="col-md-2 lead">Stok</div>
                            <div class="col-md-3"><?=$stock?></div>
                        </div>
                        <div class="row fs-6 mb-3">
                            <div class="col-md-2 lead">Berat</div>
                            <div class="col-md-3"><span><?=$berat?></span> gram</div>
                        </div>
                        <h4>Deskripsi</h4>
                        <p class="lead text" style="white-space:pre-wrap;"><?=$description?></p>
                        <p class="button">Read more</p>
                        <form method="get" action="#" name="formOrder" id="formOrder">
                            <input type="hidden" name="id_product" value="<?=$id?>">
                        <div class="form-group w-25">
                            <label for = "color">Warna :</label>
                            
                            <select placeholder="Pilih Warna" class="product_color form-control" name="inputColor" id="color">
                                <?php
                                    $query = "SELECT c.name as colname, pc.id_colors as colid from products_colors pc, colors c where c.id = pc.id_colors and pc.id_products = $id";
                                    $result = mysqli_query($conn, $query);
                                    WHILE($row = mysqli_fetch_assoc($result)){
                                        echo "<option value='" . $row['colid'] . "'>" . $row['colname'] . "</option>";                                    
                                    }
                                ?>
                            </select>
                            
                        </div>
                        
                            <div class="d-flex mt-3">
                                <input class="form-control text-center me-3" name = "inputQuantity" id="inputQuantity" type="num" value="1" style="max-width: 3rem" />
                                <button id="addCart" name="addCart" class="btn btn-outline-dark flex-shrink-0" type="submit">
                                    <i class="bi-cart-fill me-1"></i>
                                    Add to cart
                                </button>
                                <span id = "btnWishlist">
                                    
                                </span>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
            
        </section>
        <!--Review section-->
        <section class="py-0 pb-5 bg-white">
            <div class="container px-4 px-lg-5">
                <!-- review count -->
                <h3 class="fw-bolder mb-4">ULASAN (<span><?=$ulasan['hitung']?></span>)
                    <span class="fw-bolder lead"> . </span>
                    <i class="bi-star-fill" style="font-size: 1rem; color:#ffc107;"></i>
                    <!--Jumlah Rating-->
                    
                    <span class="fw-normal lead"><?=number_format($ratingtot['rata'], 1, ',')?><span class="fw-normal text-black-50" style="font-size:11pt;">/5</span></span>
                        <span class="fw-normal" style="font-size:13pt;"> (</span>
                        <!--Jumlah Review-->
                        <span class="fw-normal" style="font-size:13pt;"><?=$ratingtot['hitung']?></span>
                        <span class="fw-normal" style="font-size:13pt;"> penilaian )</span>
                </h3>
                <?php
                    $result3 = mysqli_query($conn, "SELECT u.name as name, r.rate as rate, r.review as review, r.created_at as created_at  from users u, ratings r where u.id = r.id_user and r.id_product = $id order by r.review desc");
                    WHILE($row = mysqli_fetch_assoc($result3)){ 
                ?>
                <div class="row gx-4 gx-lg-5 row-cols-1 justify-content-center">
                    <div class="col mb-1">
                        <div class="card mb-3" style="max-width: 100%;">
                            <div class="row">
                              <div class="col-md-1">
                                <img
                                  src="https://dummyimage.com/600x700/dee2e6/6c757d.jpg"
                                  alt="..."
                                  class="mx-3 my-3"
                                  width="50px"
                                  height="50px"
                                  style="border-radius:50%;"
                                />
                              </div>
                              <div class="col-md-6">
                                  <div class="row">
                                      <div class="col-12" style="height:45px;">
                                        <h5 class="card-title mx-0 my-4"><?=$row['name']?></h5>
                                      </div>
                                      <div class="col" style="height:10px;">
                                      <?php
                                        for ($i = 1; $i <= $row['rate']; $i++){
                                      ?>
                                        <i class="bi-star-fill" style="font-size: 1rem; color:#ffc107;"></i>
                                    <?php
                                        }
                                        for ($i = 5; $i > $row['rate']; $i--){
                                    ?>
                                        <i class="bi-star" style="font-size: 1rem; color:#ffc107;"></i>
                                    <?php
                                        }
                                    ?>
                                    </div>
                                  </div>
                                
                              </div>
                            </div>
                            <div class="row g-0">
                              <div class="col-md-8">
                                
                                <div class="card-body">
                                  
                                  <p class="card-text">
                                    <?=$row['review']?>
                                  </p>
                                  <p class="card-text">
                                    <small class="text-muted">Created <?=time_elapsed_string($row['created_at'])?></small>
                                  </p>
                                </div>
                              </div>
                            </div>
                          </div>
                    </div>
                </div>
                <?php
                    }
                ?>
            </div>
        </section>
        <!-- Related items section-->
        
        <!-- Footer-->
        <?php require_once("../../templates/footer/footer.php"); ?>
        <script>
            $(document).ready(()=>{
                $stock = <?php echo $stock?>;
                $wishlist = <?php echo $wishlist?>;
                if($stock == 0){
                    $("#addCart").prop("disabled",true);
                }
                
                $("#inputQuantity").blur(function(){
                    $jumlah = $("#inputQuantity").val();
                    if($jumlah > $stock){
                        $("#addCart").prop("disabled",true);
                    }else{
                        $("#addCart").prop("disabled",false);
                    }
                })
                
                if($wishlist == 1){
                    $("#btnWishlist").html("<button id='removeWishlist' name='removeWishlist' class='btn btn-dark flex-shrink-0 mx-3 btnwishlist' type='submit'><i class='bi-heart-fill me-1 heart'></i>Remove from Wishlist</button>");
                }else{
                    $("#btnWishlist").html("<button id='addWishlist' name='addWishlist' class='btn btn-primary flex-shrink-0 mx-3 btnwishlist' type='submit'><i class='bi-heart-fill me-1 heart'></i>Add to Wishlist</button>");
                }

                var defaultHeight = 120; // height when "closed"
                var text = $(".text");
                var textHeight = text[0].scrollHeight; // the real height of the element
                var button = $(".button");

                text.css({"max-height": defaultHeight, "overflow": "hidden"});

                button.on("click", function(){
                var newHeight = 0;
                if (text.hasClass("active")) {
                    newHeight = defaultHeight;
                    text.removeClass("active");
                    button.html("Read more")
                } else {
                    newHeight = textHeight;
                    text.addClass("active");
                    button.html("Read less")
                }
                text.animate({
                    "max-height": newHeight
                }, 500);
                });

                

            })
        </script>
    </body>                            
</html>
