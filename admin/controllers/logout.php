<?php
    require_once("../../core/connection.php");

    unset($_SESSION['id_user']);
    header("location: ../../index.php");
    die;
?>