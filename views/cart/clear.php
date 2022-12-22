<?php
    require_once("../../core/connection.php");
    $id = $_SESSION['id_user'];
    $result = $conn->query("DELETE FROM carts WHERE id_user='$id'");

?>

