<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>

    <?php 
        require_once("../../core/connection.php"); 
        require_once("loadReviews.php"); 

        $stmt = $conn->query("SELECT * FROM products ORDER BY rand() LIMIT 24");
            $just_for_you = $stmt->fetch_all(MYSQLI_ASSOC);
    ?>
    
    <?php require_once("../../core/cdn.php"); ?> <!-- WAJIB INCLUDE DI SEMUA PAGE -->
    <?php require_once("../../templates/sweet_alert/sweet_alert.php"); ?> <!-- INCLUDE JIKA PAKAI SWEET ALERT -->
    <link rel="stylesheet" type="text/css" href="../../templates/plugins/OwlCarousel2-2.2.1/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="../../templates/plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
    <link rel="stylesheet" type="text/css" href="../../templates/plugins/OwlCarousel2-2.2.1/animate.css">
    <link rel="stylesheet" type="text/css" href="../../templates/plugins/slick-1.8.0/slick.css">

    <link rel="stylesheet" href="../main.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="card.css">
    <link rel="stylesheet" href="../../templates/loading/loading.css">
    <link rel="shortcut icon" type="ico" href="../../favicon.ico"/>
    
</head>
<body>
    <div class="super_container">

        <!-- NAVBAR -->
        <?php require_once("../../templates/navbar/navbar.php"); ?>

        <!-- CAROUSEL -->
        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner w-100">
                <div class="carousel-item item-1 active">
                </div>
                <div class="carousel-item item-2">
                </div>
                <div class="carousel-item item-3">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <!-- CHARACTERISTICS -->
        <div class="characteristics">
            <div class="container">
                <div class="row">

                    <!-- Char. Item -->
                    <div class="col-lg-3 col-md-6 char_col">
                        
                        <div class="char_item d-flex flex-row align-items-center justify-content-start">
                            <div class="char_icon"><img src="img/char_1.png" alt=""></div>
                            <div class="char_content">
                                <div class="char_title">freedelivery</div>
                                <div class="char_subtitle">Nikmati gratis ongkir ke seluruh Indonesia</div>
                            </div>
                        </div>
                    </div>

                    <!-- Char. Item -->
                    <div class="col-lg-3 col-md-6 char_col">
                        
                        <div class="char_item d-flex flex-row align-items-center justify-content-start">
                            <div class="char_icon"><img src="img/char_2.png" alt=""></div>
                            <div class="char_content">
                                <div class="char_title">backtobuy</div>
                                <div class="char_subtitle">Nikmati cashback Extra hingga 10%</div>
                            </div>
                        </div>
                    </div>

                    <!-- Char. Item -->
                    <div class="col-lg-3 col-md-6 char_col">
                        
                        <div class="char_item d-flex flex-row align-items-center justify-content-start">
                            <div class="char_icon"><img src="img/char_3.png" alt=""></div>
                            <div class="char_content">
                                <div class="char_title">savemoney</div>
                                <div class="char_subtitle">Nikmati gratis ongkir sampai dengan 5%</div>
                            </div>
                        </div>
                    </div>

                    <!-- Char. Item -->
                    <div class="col-lg-3 col-md-6 char_col">
                        
                        <div class="char_item d-flex flex-row align-items-center justify-content-start">
                            <div class="char_icon"><img src="img/char_4.png" alt=""></div>
                            <div class="char_content">
                                <div class="char_title">discount35%</div>
                                <div class="char_subtitle">Nikmati potongan harga hingga 35%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Deals of the week -->
        <div class="deals_featured">
            <div class="container" style="width: 90%;">
                <div class="row">
                    <div class="col d-flex flex-lg-row flex-row align-items-center justify-content-start">
                        
                        <!-- Featured -->
                        <div class="featured">
                            <div class="tabbed_container">
                                <div class="tabs">
                                    <ul class="clearfix">
                                        <li class="active tabs_slider">Featured</li>
                                        <li class="tabs_slider">Best Seller</li>
                                        <li class="tabs_slider">Best Price</li>
                                    </ul>
                                    <div class="tabs_line"><span></span></div>
                                </div>

                                <!-- Product Panel -->
                                <div class="product_panel panel active">
                                    <div class="featured_slider slider" id="product_slider">
                                        <!-- YOUR CONTENT -->
                                        
                                        <?php
                                            foreach ($just_for_you as $key => $value) {
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
                                                                        <div class="product_name"><div><a href="#"><?= cutString($value["name"], 30) ?></a></div></div>
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
                                        ?>

                                    </div>
                                    <div class="featured_slider_dots_cover"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- REVIEWS -->
        <div class="reviews">
            <div class="container">
                <div class="row">
                    <div class="col">
                        
                        <div class="reviews_title_container">
                            <h3 class="reviews_title">Latest Reviews</h3>
                        </div>

                        <div class="reviews_slider_container">
                            
                            <!-- Reviews Slider -->
                            <div class="owl-carousel owl-theme reviews_slider">

                                <?php
                                    foreach ($ratings as $key => $value) {
                                        $stmt = $conn->query("SELECT * FROM users WHERE id='$value[id_user]'");
                                        $user = $stmt->fetch_assoc();
                                        $stmt = $conn->query("SELECT * FROM products WHERE id='$value[id_product]'");
                                        $product = $stmt->fetch_assoc();
                                        ?>
                                            <!-- Reviews Slider Item -->
                                            <div class="owl-item">
                                                <div class="review d-flex flex-row align-items-start justify-content-start">
                                                    <div><div class="review_image"><img src="../../<?= $product["image"] ?>" alt=""></div></div>
                                                    <div class="review_content">
                                                        <div class="review_name"><?= $user["name"] ?></div>
                                                        <div class="review_rating_container">
                                                            <div class="review_rating"><?php
                                                                $ctr = $value["rate"];
                                                                for ($i=0; $i < 5; $i++) { 
                                                                    if($ctr > 0){
                                                                        echo "<i class='fas fa-star'></i>";
                                                                        $ctr--;
                                                                    } else {
                                                                        echo "<i class='far fa-star'></i>";
                                                                    }
                                                                }
                                                            ?></div>
                                                            <div class="review_time"><?= time_elapsed_string($value["created_at"]) ?></div>
                                                        </div>
                                                        <div class="review_text"><p><?= $value["review"] ?></p></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                    }
                                ?>

                            </div>
                            <div class="reviews_dots"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- NEWSLETTER -->
        <div class="newsletter">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="newsletter_container d-flex flex-lg-row flex-column align-items-lg-center align-items-center justify-content-lg-start justify-content-center">
                            <div class="newsletter_title_container">
                                <div class="newsletter_icon"><img src="img/send.png" alt=""></div>
                                <div class="newsletter_title">Sign up for Newsletter</div>
                                <div class="newsletter_text"><p>...and receive free one ginjal</p></div>
                            </div>
                            <div class="newsletter_content clearfix">
                                <form action="" class="newsletter_form">
                                    <input type="email" class="newsletter_input" required="required" placeholder="Enter your email address">
                                    <button class="newsletter_button">Subscribe</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <?php require_once("../../templates/footer/footer.php"); ?>

        <!-- LOADING OVERLAY -->
        <div id="overlay">
            <div class="cv-spinner">
                <span class="spinner"></span>
            </div>
        </div>

    </div>

    <script src="../../templates/plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
    <script src="../../templates/plugins/slick-1.8.0/slick.js"></script>
    <script src="script.js"></script>
    
    <script>
        $('document').ready(function () {
            $('.tabs_slider').on('click', function (e) {
                e.preventDefault();
                let value = $(this).html();

                if(value == "Featured"){
                    loadProduct("featured");
                } else if(value == "Best Price"){
                    loadProduct("best_price");
                } else {
                    loadProduct("best_seller");
                }
            });
        });

        function getSliderSettings(){
            return {
                rows:2,
				slidesToShow:4,
				slidesToScroll:4,
				infinite:false,
				arrows:false,
				dots:true,
				responsive:
				[
					{
						breakpoint:768, settings:
						{
							rows:2,
							slidesToShow:3,
							slidesToScroll:3,
							dots:true
						}
					},
					{
						breakpoint:575, settings:
						{
							rows:2,
							slidesToShow:2,
							slidesToScroll:2,
							dots:false
						}
					},
					{
						breakpoint:480, settings:
						{
							rows:1,
							slidesToShow:1,
							slidesToScroll:1,
							dots:false
						}
					}
				]
            }
        }

        function loadProduct(keyword) {
            $.ajax({
                type: "POST",
                url: "../controller/loadHomepage.php",
                data: {
                    'keyword' : keyword
                },
                beforeSend: function() {
                    $("#overlay").fadeIn(300);
                },
                success: function (data) {
                    $("#product_slider").slick('unslick');
                    $("#product_slider").html(data);
                    $("#product_slider").slick(getSliderSettings());
                    setTimeout(function(){
                        $("#overlay").fadeOut(300);
                    },500);
                }
            });
        }

        $('#product_slider').on('click', '.product_fav', function (e) {
            e.preventDefault();
            let element = $(this);
            let id_product = element.parent().find(".id_product_hidden").val();
            let id_user = $("#id_user_now").val();

            if(id_user != "-1"){
                $( this ).toggleClass("active");
                $.ajax({
                    type: "POST",
                    url: "../controller/products.php",
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

                            swal({
                                title: tmpTitle,
                                text: result[1],
                                type: result[0]
                            });
                            loadCountWishlist(id_user);
                        }
                    }
                });
            } else {
                window.location = "../login/login.php";
            }
        });

        $('.newsletter_content').on('click', '.newsletter_button', function (e) {
            e.preventDefault();
            let element = $(this);
            let email_user = element.parent().find(".newsletter_input").val();
            let id_user = $("#id_user_now").val();

            if(id_user != "-1"){
                $.ajax({
                    type: "POST",
                    url: "../controller/kirimEmail.php",
                    beforeSend: function(){
                        Swal.fire({
                            title: 'Wait...',
                            onBeforeOpen () {
                                Swal.showLoading ()
                            },
                            onAfterClose () {
                                Swal.hideLoading()
                            },
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false
                        })
                    },
                    data: {
                        'id_user' : id_user,
                        'email_user' : email_user,
                        'subject_mail' : "Subscribed",
                        'msg_mail' : "Thank you for subscribing!"
                    },
                    success: function (data) {
                        swal({
                            title: "Yeay!!",
                            text: "Harap check email Anda..",
                            type: "success"
                        });
                    }
                });
            } else {
                window.location = "../login/login.php";
            }
        });
    </script>

</body>
</html>