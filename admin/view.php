<?php
    if (!isset($_REQUEST['content'])) $_REQUEST['content'] = "";

    require_once('partials/top.php');
    require_once('partials/navbar.php');
    require_once('partials/sidebar.php');

    if ($_REQUEST['content'] == '')
    require_once('views/dashboard.php');

    if ($_REQUEST['content'] == 'Users')
    require_once('views/users.php');

    if ($_REQUEST['content'] == 'Overview')
    require_once('views/overview.php');

    if ($_REQUEST['content'] == 'Product')
    require_once('views/product.php');

    if ($_REQUEST['content'] == 'Category')
    require_once('views/category.php');

    if ($_REQUEST['content'] == 'Brand')
    require_once('views/brand.php');

    if ($_REQUEST['content'] == 'User')
    require_once('views/user.php');

    if ($_REQUEST['content'] == 'Products'){
        if (isset($_REQUEST['create'])) require_once('views/createproducts.php');
        else if (isset($_REQUEST['edit'])) require_once('views/editProduct.php');
        else require_once('views/products.php');
    }

    if ($_REQUEST['content'] == 'Discounts'){
        require_once('views/discounts.php');
    }
    


    require_once('partials/bottom.php');
?>