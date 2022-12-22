<?php
    require_once("../../core/connection.php");


    if(isset($_REQUEST["search_category"])){
        if($_REQUEST["search_category"] == "All Categories" || $_REQUEST["search_category"] == ""){
            unset($_REQUEST["search_category"]);
        } else if(isset($_REQUEST["search_name"])) {
            $stmt = $conn->query("SELECT * FROM categories WHERE name LIKE '%$_REQUEST[search_category]%'");
            $tmp_category = $stmt->fetch_assoc();
            $_REQUEST["search_category"] = $tmp_category["id"];
        }
    }


    $stmt = $conn->query("SELECT * FROM colors");
        $colors_shop = $stmt->fetch_all(MYSQLI_ASSOC);

    $stmt = $conn->query("SELECT * FROM categories");
        $categories_shop = $stmt->fetch_all(MYSQLI_ASSOC);

    $stmt = $conn->query("SELECT * FROM brands");
        $brands_shop = $stmt->fetch_all(MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>

    <?php require_once("../../core/cdn.php"); ?> <!-- WAJIB INCLUDE DI SEMUA PAGE -->
    <?php require_once("../../templates/sweet_alert/sweet_alert.php"); ?> <!-- INCLUDE JIKA PAKAI SWEET ALERT -->
    <link rel="stylesheet" type="text/css" href="../../templates/plugins/slick-1.8.0/slick.css">
    <link rel="stylesheet" type="text/css" href="../../templates/plugins/jquery-ui-1.12.1.custom/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

    <link rel="stylesheet" href="../main.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="shop_responsive.css">
    <link rel="stylesheet" href="../../templates/card/style.css">
    <link rel="stylesheet" href="../../templates/loading/loading.css">
    <link rel="shortcut icon" type="ico" href="../../favicon.ico"/>
</head>
<body>
    <div class="super_container">
        <input type="hidden" id="hidden_name_product" value='<?php if(isset($_REQUEST["search_name"])) echo $_REQUEST["search_name"] ?>'>
        <input type="hidden" id="hidden_category_product" value='<?php if(isset($_REQUEST["search_category"])) echo $_REQUEST["search_category"] ?>'>
        <input type="hidden" id="hidden_brand_product" value='<?php if(isset($_REQUEST["search_brand"])) echo $_REQUEST["search_brand"] ?>'>

        <!-- NAVBAR -->
        <?php require_once("../../templates/navbar/navbar.php"); ?>

        <!-- SHOP -->
        <div class="shop">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">

                        <!-- Shop Sidebar -->
                        <div class="shop_sidebar">
                            <div class="sidebar_section">
                            <div class="sidebar_title">Filter By</div>

                                <div class="nameFilter_wrapper">
                                    <div class="sidebar_subtitle color_subtitle">Name</div>

                                    <div class="chip mt-3">
                                        <!-- Content -->
                                        <div class="chip__content" id="the_name">
                                            <script> 
                                                if($("#hidden_name_product").val() != ""){
                                                    document.write($("#hidden_name_product").val());
                                                } else {
                                                    if(!$('.nameFilter_wrapper').hasClass("d-none")){
                                                        $('.nameFilter_wrapper').addClass("d-none");
                                                    }
                                                }
                                            </script>
                                        </div>
                                        
                                        <!-- The close button -->
                                        <button type="button" class="btn btn-link btn_the_name p-0" style="margin-top: -1px;"><i class="fas fa-times fa-sm"></i></button>
                                    </div>
                                </div>

                                <div class="sidebar_subtitle color_subtitle">Categories</div>

                                <select class="sidebar_categories selectpicker" data-size="5" data-live-search="true" title="Choose Categories Products" id="category">\
                                    
                                    <option value="all" <?php
                                        if(!isset($_REQUEST["search_category"])){
                                            echo "selected";
                                        }
                                    ?>>All</option>
                                
                                    <?php foreach($categories_shop as $category) {
                                        ?>
                                            <option value="<?= $category['id'] ?>" <?php
                                                if(isset($_REQUEST["search_category"]) && $category["id"] == $_REQUEST["search_category"]){
                                                    echo "selected";
                                                }
                                            ?>><?= $category['name'] ?></option>
                                        <?php 
                                    } ?>

                                </select>
                            </div>
                            <div class="sidebar_section">
                                <div class="sidebar_subtitle">Price</div>
                                <div class="filter_price">
                                    <div id="slider-range" class="slider_range"></div>
                                    <p>Range: </p>
                                    <p><input type="text" id="amount" class="amount" readonly style="border:0; font-weight:bold;"></p>
                                </div>
                            </div>
                            <div class="sidebar_section">
                                <div class="sidebar_subtitle color_subtitle">Color</div>

                                <select class="colors_list selectpicker" data-size="5" data-live-search="true" title="Choose Color Products" id="color">\
                                    <option value="all" selected>All</option>
                                    <?php foreach($colors_shop as $color) {?>
                                        <option value=<?= $color['id']?>><?= $color['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="sidebar_section">
                                <div class="sidebar_subtitle brands_subtitle">Brands</div>

                                <select class="brands_list selectpicker" data-size="5" data-live-search="true" title="Choose Brands Products" id="brand">\
                                    
                                    <option value="all" <?php
                                        if(!isset($_REQUEST["search_brand"])){
                                            echo "selected";
                                        }
                                    ?>>All</option>
                                
                                    <?php foreach($brands_shop as $brand) {
                                        ?>
                                            <option value=<?= $brand['id']?> <?php
                                                if(isset($_REQUEST["search_brand"]) && $brand["id"] == $_REQUEST["search_brand"]){
                                                    echo "selected";
                                                }
                                            ?>><?= $brand['name'] ?></option>
                                        <?php 
                                    } ?>

                                    

                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-9">
                        
                        <!-- Shop Content -->

                        <div class="shop_content">
                            <div class="shop_bar clearfix">
                                <div class="shop_product_count"><span id="product_found">0</span> products found</div>

                                <div class="wrap_search">
                                    <input class="c-checkbox" type="checkbox" id="checkbox">
                                    <div class="c-formContainer">
                                        <form class="c-form" action="">
                                            <input class="c-form__input" placeholder="Input Product Name" type="text" id="search_input">
                                            <label class="c-form__buttonLabel" for="checkbox">
                                            <button class="c-form__button" type="button" id="btn_search"><img src="../../templates/navbar/resource/search.png" style="height: 70%;"></button>
                                            </label>
                                            <label class="c-form__toggle" for="checkbox" data-title="Search products name.."></label>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="product_grid">
                                <div class="product_grid_border"></div>
                                <div class="row" id="content_shop">
                                    <!-- YOUR CONTENT -->
                                    
                                </div>
                            </div>

                            <!-- Button Load More -->

                            <div class="loadMore_wraper">
                                <button type="button" class="btn">Load More</button>
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

    
    <script src="../../templates/plugins/slick-1.8.0/slick.js"></script>
    <script src="../../templates/plugins/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    
    <script src="script.js"></script>

</body>
</html>