<?php
    session_start();

    $connectionName = "bgiktzigtizcg5etbmcu-mysql.services.clever-cloud.com";
    $username = "ufzmbdhbnlbtliyj";
    $password = "6NEFoFcVMbxcLXAy5PS3";
    $db = "bgiktzigtizcg5etbmcu";
	
	$conn = new mysqli($connectionName, $username, $password, $db);
	if ($conn->connect_errno) {
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Server Error</title>

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Maven+Pro:400,900" rel="stylesheet">

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="css/style.css" />

    <style>
    * {
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
    }

    body {
        padding: 0;
        margin: 0;
    }

    #notfound {
        position: relative;
        height: 100vh;
    }

    #notfound .notfound {
        position: absolute;
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }

    .notfound {
        max-width: 920px;
        width: 100%;
        line-height: 1.4;
        text-align: center;
        padding-left: 15px;
        padding-right: 15px;
    }

    .notfound .notfound-404 {
        position: absolute;
        height: 100px;
        top: 0;
        left: 50%;
        -webkit-transform: translateX(-50%);
        -ms-transform: translateX(-50%);
        transform: translateX(-50%);
        z-index: -1;
    }

    .notfound .notfound-404 h1 {
        font-family: 'Maven Pro', sans-serif;
        color: #ececec;
        font-weight: 900;
        font-size: 276px;
        margin: 0px;
        position: absolute;
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }

    .notfound h2 {
        font-family: 'Maven Pro', sans-serif;
        font-size: 46px;
        color: #000;
        font-weight: 900;
        text-transform: uppercase;
        margin: 0px;
    }

    .notfound p {
        font-family: 'Maven Pro', sans-serif;
        font-size: 16px;
        color: #000;
        font-weight: 400;
        text-transform: uppercase;
        margin-top: 15px;
    }

    .notfound a {
        font-family: 'Maven Pro', sans-serif;
        font-size: 14px;
        text-decoration: none;
        text-transform: uppercase;
        background: #189cf0;
        display: inline-block;
        padding: 16px 38px;
        border: 2px solid transparent;
        border-radius: 40px;
        color: #fff;
        font-weight: 400;
        -webkit-transition: 0.2s all;
        transition: 0.2s all;
    }

    .notfound a:hover {
        background-color: #fff;
        border-color: #189cf0;
        color: #189cf0;
    }

    @media only screen and (max-width: 480px) {
        .notfound .notfound-404 h1 {
            font-size: 162px;
        }

        .notfound h2 {
            font-size: 26px;
        }
    }
    </style>

</head>

<body>

    <div id="notfound">
        <div class="notfound">
            <div class="notfound-404">
                <h1>ERROR</h1>
            </div>
            <h2>Maaf... Server Database Mengalami Kendala.</h2>
            <p>Karena kami menggunakan <b> server gratisan </b>, server memasuki masa <b> non-active </b> secara random.
                <br> Lakukan <b>refresh</b> secara berkala hingga server <b>active kembali</b>.</p>
        </div>
    </div>

</body>

</html>

<?php
        die();
    } 

    // SWEET ALERT
    // Cara pakai tinggal buat $_SESSION["swal"] = "success/error~pesan"
    // Contoh: $_SESSION['swal"] = "success~Berhasil memasukkan data"

    echo "<script src='https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js'></script>";

    if (isset($_SESSION['swal'])){
        $data = explode("~", $_SESSION["swal"]);
        $type = $data[0];
        $message = $data[1];

        if ($type == "success"){
            $title = "Yeay!!";
        } else $title = "Oops!";

        unset($_SESSION["swal"]);

            echo "<script>
            
            window.onload=function(){
                swal({
                    title: '$title',
                    text: '$message',
                    type: '$type'
                });
            }
            </script>";
    }
?>