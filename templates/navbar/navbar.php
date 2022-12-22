<?php
    if(isset($_REQUEST["navbar-login"])){
        $_SESSION["user_action_login"] = $_REQUEST["navbar-login"];
        header("Location: ../login/login.php");
        die;
    }

    if(isset($_REQUEST["logout"])){
        unset($_SESSION["id_user"]);
        $_SESSION['swal'] = "success~Berhasil logout!";
        header("Location: ../homepage/homepage.php");
        die;
    }


    $count_wishlist = $count_cart = 0;
    $sum_cart = "Rp 0";

    if(isset($_SESSION["id_user"])){
        $id_user = $_SESSION["id_user"];
        if($id_user == 0){
            $name_user = "ADMIN";
        } else {
            $stmt = $conn->query("SELECT * FROM users WHERE id='$id_user'");
            $user = $stmt->fetch_assoc();
            $name_user = $user["name"];
        }

        // WISHLIST COUNT
        $stmt = $conn->query("SELECT COUNT(*) AS TOTAL_WISHLIST FROM wishlists WHERE id_user='$_SESSION[id_user]'");
            $count_wishlist = $stmt->fetch_row();
            $count_wishlist = $count_wishlist[0];

        // CART TOTAL COUNT & SUM
        $count_cart = 0;
        $stmt = $conn->query("SELECT SUM(amount) FROM carts WHERE id_user='$_SESSION[id_user]'");
            $tmp_cart = $stmt->fetch_row();
            if($tmp_cart[0] != "")
                $count_cart = $tmp_cart[0];
            

        $stmt = $conn->query("SELECT SUM(products.harga * carts.amount) AS TOTAL_CART FROM carts 
            LEFT JOIN products on products.id = carts.id_product WHERE carts.id_user = '$_SESSION[id_user]'");
            $sum_cart = $stmt->fetch_row();
            $sum_cart = "Rp " . number_format($sum_cart[0], 0, ".", ".");
    }

    $stmt = $conn->query("SELECT * FROM categories LIMIT 7");
        $categories = $stmt->fetch_all(MYSQLI_ASSOC);

    $stmt = $conn->query("SELECT * FROM brands ORDER BY rand() LIMIT 4");
        $brands = $stmt->fetch_all(MYSQLI_ASSOC);

    $stmt = $conn->query("SELECT * FROM products ORDER BY harga LIMIT 4");
        $super_deals = $stmt->fetch_all(MYSQLI_ASSOC);

    function cutString($string, $jumlah){
        $cutted = $string;
        if (strlen($string) > $jumlah){
            $cutted = explode( "\n", wordwrap($string, $jumlah));
            $cutted = $cutted[0] . "...";
        }
        return $cutted;
    }
?>

<link rel="stylesheet" href="../../templates/navbar/navbar.css">
<link rel="stylesheet" href="../responsive.css">

<div class="container-fluid p-0">

    <!-- INPUT HIDDEN BUAT DAPET ID USER SEKARANG -->
    <input type="hidden" id="id_user_now" value="<?php 
        if(isset($_SESSION["id_user"])){
            echo $_SESSION["id_user"];
        } else {
            echo "-1";
        }
    ?>">
    
    <!-- Header -->
    <header class="header">

        <!-- Top Bar -->

        <div class="top_bar">
            <div class="container-fluid">
                <div class="row">
                    <div class="col d-flex flex-row">
                        <div class="top_bar_contact_item"><i class="fas fa-bullhorn me-3"></i>COVID-19 RELATED CARRIER DELAYS MAY IMPACT DELIVERY</div>
                        <div class="top_bar_content ms-auto">
                            <?php
                                if(isset($name_user)){
                                    ?>
                                        <div class="top_bar_user" style="margin-left: 20px; margin-top: -3px;">
                                            <div class="btn-group d-flex">
                                                <p style="font-size: 17px; padding: 16px 9px 0px 0px; color: black;">Hi, </p>  
                                                <button type="button" class="btn btn-name dropdown-toggle p-0" data-bs-toggle="dropdown" aria-expanded="false"><?= $name_user ?></button>
                                                <ul class="dropdown-menu" z-index: 30;>
                                                    <li><a class="dropdown-item" href="../wishlist/wishlist.php" style="line-height: 36px; z-index: 30;">Wishlist</a></li>
                                                    <li><a class="dropdown-item" href="../cart/cart.php" style="line-height: 36px; z-index: 30;">My Cart</a></li>
                                                    <li><a class="dropdown-item" href="../history/history.php" style="line-height: 36px; z-index: 30;">History Order</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form action="#" method="POST">
                                                            <button class="btn btn-link btn-logout" name="logout">Logout</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    <?php
                                } else {
                                    ?>
                                        <div class="top_bar_user">
                                            <div class="user_icon"><img src="../../templates/navbar/resource/user.svg" alt=""></div>
                                            <div>
                                                <form action="#" method="POST">
                                                    <button class="btn_link_navbar" name="navbar-login" value="signup">Register</button>
                                                </form>
                                            </div>
                                            <div>
                                                <form action="#" method="POST">
                                                    <button class="btn_link_navbar" name="navbar-login" value="signin">Sign in</button>
                                                </form>
                                            </div>
                                        </div>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>		
        </div>

        <!-- Header Main -->

        <div class="header_main">
            <div class="container-fluid">
                <div class="row">

                    <!-- Logo -->
                    <div class="col-lg-2 col-sm-3 col-3 order-1">
                        <div class="logo_container">
                            <div class="logo"><a href="../homepage/homepage.php">tukar <br> <span class="p-1" style="background-color: #0e8ce4; color: white;">ginjalmu</span> </a></div>
                        </div>
                    </div>

                    <!-- Search -->
                    <div class="col-lg-6 col-12 order-lg-2 order-3 text-lg-left text-right">
                        <div class="header_search">
                            <div class="header_search_content">
                                <div class="header_search_form_container">
                                    <form action="../shop/shop.php" method="POST" class="header_search_form clearfix">
                                        <input type="search" required="required" class="header_search_input" name="search_name" placeholder="Search for products...">
                                        <input type="hidden" name="search_category" id="input_hidden_category" value="">
                                        <div class="custom_dropdown">
                                            <div class="custom_dropdown_list">
                                                <span class="custom_dropdown_placeholder clc">All Categories</span>
                                                <i class="fas fa-chevron-down"></i>
                                                <ul class="custom_list clc">
                                                    <?php
                                                        foreach ($categories as $key => $value) {
                                                            ?>
                                                                <li><a class="clc" href="#"><?= $value["name"] ?></a></li>
                                                            <?php
                                                        }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <button type="submit" class="header_search_button trans_300" value="Submit"><img src="../../templates/navbar/resource/search.png" alt=""></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Wishlist -->
                    <div class="col-lg-4 col-9 order-lg-3 order-2 text-lg-left text-right">
                        <div class="wishlist_cart d-flex flex-row align-items-center justify-content-end">
                            <a href="../wishlist/wishlist.php" style="color: black;">
                                <div class="wishlist d-flex flex-row align-items-center justify-content-end">
                                    <div class="wishlist_icon"><img src="../../templates/navbar/resource/heart.png" alt=""></div>
                                    <div class="wishlist_content">
                                        <div class="wishlist_text">Wishlist</div>
                                        <div class="wishlist_count" id="wishlist_count_navbar"><?= $count_wishlist ?></div>
                                    </div>
                                </div>
                            </a>

                            <!-- Cart -->
                            <a href="../cart/cart.php" style="color: black;">
                                <div class="cart">
                                    <div class="cart_container d-flex flex-row align-items-center justify-content-end">
                                        <div class="cart_icon">
                                            <img src="../../templates/navbar/resource/cart.png" alt="">
                                            <div class="cart_count"><span id="cart_count_navbar"><?= $count_cart ?></span></div>
                                        </div>
                                        <div class="cart_content">
                                            <div class="cart_text">Cart</div>
                                            <div class="cart_price" id="cart_price_navbar"><?= $sum_cart ?></div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Navigation -->

        <nav class="main_nav">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        
                        <div class="main_nav_content d-flex flex-row">

                            <!-- Categories Menu -->

                            <div class="cat_menu_container">
                                <div class="cat_menu_title d-flex flex-row align-items-center justify-content-start">
                                    <div class="cat_burger"><span></span><span></span><span></span></div>
                                    <div class="cat_menu_text">categories</div>
                                </div>

                                <ul class="cat_menu">
                                    <li><a href="../shop/shop.php?search_category=1">Smartphone<i class="fas fa-chevron-right ms-auto"></i></a></li>
                                    <li><a href="../shop/shop.php?search_category=2">Smartwatch<i class="fas fa-chevron-right"></i></a></li>
                                    <li><a href="../shop/shop.php?search_category=3">Earphone<i class="fas fa-chevron-right"></i></a></li>
                                    <li><a href="../shop/shop.php?search_category=4">Tablet<i class="fas fa-chevron-right"></i></a></li>
                                    <li><a href="../shop/shop.php?search_category=5">Camera<i class="fas fa-chevron-right"></i></a></li>
                                </ul>
                            </div>

                            <!-- Main Nav Menu -->

                            <div class="main_nav_menu ms-auto">
                                <ul class="standard_dropdown main_nav_dropdown">
                                    <li><a href="../homepage/homepage.php">Home<i class="fas fa-chevron-down"></i></a></li>
                                    <li><a href="../shop/shop.php">Shop<i class="fas fa-chevron-down"></i></a></li>
                                    <li class="hassubs">
                                        <a href="#">Super Deals<i class="fas fa-chevron-down"></i></a>
                                        <ul>
                                            <?php
                                                foreach ($super_deals as $key => $value) {
                                                    ?>
                                                        <li><a href="../product/product.php?id_product=<?= $value["id"] ?>"><?= cutString($value["name"], 25); ?><i class="fas fa-chevron-down"></i></a></li>
                                                    <?php
                                                }
                                            ?>
                                        </ul>
                                    </li>
                                    <li class="hassubs">
                                        <a href="#">Featured Brands<i class="fas fa-chevron-down"></i></a>
                                        <ul>
                                            <?php
                                                foreach ($brands as $key => $value) {
                                                    ?>
                                                        <li><a href="../shop/shop.php?search_brand=<?= $value["id"] ?>"><?= $value["name"] ?><i class="fas fa-chevron-down"></i></a></li>
                                                    <?php
                                                }
                                            ?>
                                        </ul>
                                    </li>
                                    <li><a href="../contact/contact.php">Contact<i class="fas fa-chevron-down"></i></a></li>
                                </ul>
                            </div>

                            <!-- Menu Trigger -->

                            <div class="menu_trigger_container ms-auto">
                                <div class="menu_trigger d-flex flex-row align-items-center justify-content-end">
                                    <div class="menu_burger">
                                        <div class="menu_trigger_text">menu</div>
                                        <div class="cat_burger menu_burger_inner"><span></span><span></span><span></span></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Menu -->

		<div class="page_menu">
			<div class="container-fluid">
				<div class="row">
					<div class="col">
						
						<div class="page_menu_content">
							
							<div class="page_menu_search">
								<form action="../shop/shop.php" method="GET">
									<input type="search" required="required" class="page_menu_search_input" name="search_name" placeholder="Search for products...">
								</form>
							</div>
							<ul class="page_menu_nav">
								<li class="page_menu_item"><a href="../homepage/homepage.php">Home<i class="fa fa-angle-down"></i></a></li>
                                <li class="page_menu_item"><a href="../shop/shop.php">Shop<i class="fa fa-angle-down"></i></a></li>

                                <li class="page_menu_item has-children">
									<a href="">Super Deals<i class="fa fa-angle-down"></i></a>
									<ul class="page_menu_selection">
                                        <?php
                                            foreach ($super_deals as $key => $value) {
                                                ?>
                                                
                                                    <li><a href="../product/product.php?id_product=<?= $value["id"] ?>"><?= $value["name"] ?><i class="fa fa-angle-down"></i></a></li>
                                                <?php
                                            }
                                        ?>
									</ul>
								</li>

								<li class="page_menu_item has-children">
									<a href="">Featured Brands<i class="fa fa-angle-down"></i></a>
									<ul class="page_menu_selection">
                                        <?php
                                            foreach ($brands as $key => $value) {
                                                ?>
                                                    <li><a href="../shop/shop.php?search_brand=<?= $value["id"] ?>"><?= $value["name"] ?><i class="fa fa-angle-down"></i></a></li>
                                                <?php
                                            }
                                        ?>
									</ul>
								</li>
                                
								<li class="page_menu_item"><a href="../contact/contact.php">contact<i class="fa fa-angle-down"></i></a></li>
							</ul>

                            <div class="menu_contact">
                                <?php
                                if(isset($name_user)){
                                    ?>
                                        <div class="top_bar_user" style="margin-left: 30px; margin-top: -3px;">
                                            <div class="btn-group d-flex">
                                                <p style="font-size: 17px; padding: 16px 9px 0px 0px; color: black;">Hi, </p>
                                                <button type="button" class="btn btn-name dropdown-toggle p-0" data-bs-toggle="dropdown" aria-expanded="false" style="color: black;"><?= $name_user ?></button>
                                                <ul class="dropdown-menu" z-index: 30;>
                                                    <li><a class="dropdown-item" href="../wishlist/wishlist.php" style="line-height: 36px; z-index: 30;">Wishlist</a></li>
                                                    <li><a class="dropdown-item" href="../cart/cart.php" style="line-height: 36px; z-index: 30;">My Cart</a></li>
                                                    <li><a class="dropdown-item" href="../history/history.php" style="line-height: 36px; z-index: 30;">History Order</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form action="#" method="POST">
                                                            <button class="btn btn-link btn-logout" name="logout">Logout</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    <?php
                                } else {
                                    ?>
                                        <div class="top_bar_user">
                                            <div class="user_icon" style="filter: brightness(0) invert(1);"><img src="../../templates/navbar/resource/user.svg" alt=""></div>
                                            <div>
                                                <form action="#" method="POST">
                                                    <button class="btn_link_navbar" name="navbar-login" value="signup" style="color: white;">Register</button>
                                                </form>
                                            </div>
                                            <div>
                                                <form action="#" method="POST">
                                                    <button class="btn_link_navbar" name="navbar-login" value="signin" style="color: white;">Sign in</button>
                                                </form>
                                            </div>
                                        </div>
                                    <?php
                                }
                            ?>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>

    </header>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="../../templates/plugins/greensock/TweenMax.min.js"></script>
<script src="../../templates/navbar/navbar.js"></script>

<script>
    $(window).on('load', function() {
        let id_user = $("#id_user_now").val();
        loadCountWishlist(id_user);
        loadSumCart(id_user);
    });

    function loadAjax(idElement, action, id_user){
        $.ajax({
            type: "POST",
            url: "../../templates/navbar/sum_navbar.php",
            data: {
                'action' : action,
                'id_user' : id_user
            },
            success: function (data) {
                let tmpData = data.trim();
                
                if(tmpData != ""){
                    if(idElement == "wishlist"){
                        $("#wishlist_count_navbar").html(tmpData);
                    } else {
                        tmpData = tmpData.split("~");
                        $("#cart_price_navbar").html(tmpData[0]);
                        $("#cart_count_navbar").html(tmpData[1]);
                    }
                }
            }
        });
    }

    function loadCountWishlist(id_user){
        if(id_user != -1){
            loadAjax("wishlist", "count_wishlist", id_user);
        }
    }

    function loadSumCart(id_user){
        if(id_user != -1){
            loadAjax("cart", "sum_cart", id_user);
        }
    }

</script>