<?php
    require_once("../core/connection.php");
    // Ketika Login Jalan
    if (isset($_SESSION['id_user']) && $_SESSION['id_user'] == 0){
        require_once('view.php');
    } else header('Location: ../index.php');
    
?>