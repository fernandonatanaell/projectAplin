<?php
    require_once("../../core/connection.php");

    $id = $_REQUEST['id'];

    $produk = $conn->query("SELECT * From products where id = '$id'")->fetch_assoc();

    $nama = $_REQUEST['name'];
    $description = $_REQUEST['description'];
    $berat = $_REQUEST['berat'];
    $stock = $_REQUEST['stock'];
    $harga = $_REQUEST['harga'];

    if ($berat < 1){
        $_SESSION['swal'] = "error~Berat harus lebih besar dari 0";
        header("location: ../index.php?content=Products");
        die;
    }

    if ($stock < 1){
        $_SESSION['swal'] = "error~Stock harus lebih besar dari 0";
        header("location: ../index.php?content=Products");
        die;
    }

    if ($harga < 1){
        $_SESSION['swal'] = "error~Harga harus lebih besar dari 0";
        header("location: ../index.php?content=Products");
        die;
    }

    if ($_FILES['image']['size'] != 0){
        $target_dir = "../../image/";

        $tmp_product = $_FILES['image']['tmp_name'];
        $pathinfo = pathinfo($_FILES['image']['name']);
        $extension = $pathinfo['extension'];

        if ($extension != "jpg" && $extension != "jpeg" && $extension  != "png"){
            $_SESSION['swal'] = "error~Ekstensi Foto tidak sesuai!";
            header("location: ../index.php?content=Products");
            die;
        }

        $target_dir = $target_dir . $id . "." . $extension;

        move_uploaded_file($tmp_product, $target_dir);

        $alamat = "image/" . $id . "." . $extension;
    } else {
        $alamat = $produk['image'];
    }

    if ($_REQUEST['id_brands'] == "new"){
        $q = $conn->prepare("INSERT INTO brands(name) VALUES(?)");
        $q->bind_param("s", $_REQUEST['nama_brand']);
        $result =$q->execute();

        $id_brand = $conn->insert_id;
    } else {
        $id_brand = $_REQUEST['id_brands'];
    }

    $res = $conn->prepare("UPDATE products SET name=?, description=?, id_brands=?, berat=?, stock=?, harga=?, image=? WHERE id=?");
    $res->bind_param("ssiiiisi", $nama, $description, $id_brand, $berat, $stock, $harga, $alamat, $id);
    $result = $res->execute();


    $_SESSION['swal'] = "success~Berhasil mengubah produk!";
    header("location: ../index.php?content=Products")

?>