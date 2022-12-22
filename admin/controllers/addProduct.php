<?php
    require_once("../../core/connection.php");

    $result = $conn->query("SELECT COUNT(*) FROM products");
    $id = $result->fetch_row();
    $id = $id[0] + 1;

    $target_dir = "../../image/";

    $tmp_product = $_FILES['image']['tmp_name'];
    $pathinfo = pathinfo($_FILES['image']['name']);
    $extension = $pathinfo['extension'];

    $nama = $_REQUEST['name'];
    $description = $_REQUEST['description'];
    $berat = $_REQUEST['berat'];
    $stock = $_REQUEST['stock'];
    $harga = $_REQUEST['harga'];

    if ($extension != "jpg" && $extension != "jpeg" && $extension  != "png"){
        $_SESSION['swal'] = "error~Ekstensi Foto tidak sesuai!";
        header("location: ../index.php?content=Products&create=True");
        die;
    }

    if ($berat < 1){
        $_SESSION['swal'] = "error~Berat harus lebih besar dari 0";
        header("location: ../index.php?content=Products&create=True");
        die;
    }

    if ($stock < 1){
        $_SESSION['swal'] = "error~Stock harus lebih besar dari 0";
        header("location: ../index.php?content=Products&create=True");
        die;
    }

    if ($harga < 1){
        $_SESSION['swal'] = "error~Harga harus lebih besar dari 0";
        header("location: ../index.php?content=Products&create=True");
        die;
    }

    if ($_REQUEST['id_brands'] == "new"){
        $q = $conn->prepare("INSERT INTO brands(name) VALUES(?)");
        $q->bind_param("s", $_REQUEST['nama_brand']);
        $result =$q->execute();

        $id_brand = $conn->insert_id;
    } else {
        $id_brand = $_REQUEST['id_brands'];
    }

    $target_dir = $target_dir . $id . "." . $extension;

    move_uploaded_file($tmp_product, $target_dir);

    $alamat = "image/" . $id . "." . $extension;

    $q = $conn->prepare("INSERT INTO products(name, description, id_brands, berat, stock, harga, image) VALUES(?,?,?,?,?,?,?)");
    $q->bind_param("ssiiiis",$nama, $description, $id_brand, $berat, $stock, $harga, $alamat);
    $result =$q->execute();

    if (isset($_REQUEST['color'])){
        foreach ($_REQUEST['color'] as $col){
            $q = $conn->prepare("INSERT INTO products_colors(id_products, id_colors) VALUES(?,?)");
            $q->bind_param("ii", $id, $col);
            $result = $q->execute();
        }
    }

    if (isset($_REQUEST['newColor']) && trim($_REQUEST['newColor']) != ""){
        $new_arr = array_map('trim', explode(',', $_REQUEST['newColor']));

        foreach ($new_arr as $arr){
            $q = $conn->prepare("INSERT INTO colors(name) VALUES(?)");
            $q->bind_param("s", $arr);
            $result = $q->execute();
            $color_id = $conn->insert_id;

            $q = $conn->prepare("INSERT INTO products_colors(id_products, id_colors) VALUES(?,?)");
            $q->bind_param("ii", $id, $color_id);
            $result = $q->execute();
        }
    }

    if (isset($_REQUEST['category'])){
        foreach ($_REQUEST['category'] as $cat){
            $q = $conn->prepare("INSERT INTO products_categories(id_products, id_categories) VALUES(?,?)");
            $q->bind_param("ii", $id, $cat);
            $result = $q->execute();
        }
    }

    if (isset($_REQUEST['newCategory']) && trim($_REQUEST['newCategory']) != ""){
        $new_arr = array_map('trim', explode(',', $_REQUEST['newCategory']));

        foreach ($new_arr as $arr){
            $q = $conn->prepare("INSERT INTO categories(name) VALUES(?)");
            $q->bind_param("s", $arr);
            $result =$q->execute();
            $category_id = $conn->insert_id;

            $q = $conn->prepare("INSERT INTO products_categories(id_products, id_categories) VALUES(?,?)");
            $q->bind_param("ii", $id, $category_id);
            $result = $q->execute();
        }
    }

    $_SESSION['swal'] = "success~Berhasil menambah produk!";
    header("location: ../index.php?content=Products")

?>