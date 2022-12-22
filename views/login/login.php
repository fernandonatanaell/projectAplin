<?php
    require_once("../../core/connection.php"); 


    if(isset($_REQUEST["login"])){
        $username = $_REQUEST["username"];
        $password = $_REQUEST["password"];
        $status = $title = $text = "";

        if($username == "" || $password == ""){
            $status = 'error';
            $title = 'Oops...';
            $text = 'Input tidak boleh ada yang kosong!';
        } else if($username == "admin" && $password == "admin"){
            $_SESSION['id_user'] = 0;
            $_SESSION['swal'] = "success~Selamat datang ADMIN!";
            header("Location: ../../admin/index.php");
            die;
        } else {
            $stmt = $conn->query("SELECT * FROM users WHERE username='$username'");

            if($stmt->num_rows > 0){
                $user = $stmt->fetch_assoc();
                
                if(password_verify($password, $user["password"])){
                    $_SESSION["id_user"] = $user["id"];
                    $_SESSION["swal"] = "success~Berhasil login!";
                } else {
                    $status = 'error';
                    $title = 'Oops...';
                    $text = 'Password Anda salah!';
                }
            } else {
                $status = 'error';
                $title = 'Oops...';
                $text = 'Username tidak ditemukan!';
            }
        }
    } else if(isset($_REQUEST["register"])){
        $name = $_REQUEST["name"];
        $username = $_REQUEST["username"];
        $password = $_REQUEST["password"];
        $status = $title = $text = "";

        if($username == "" || $password == "" || $name == ""){
            $status = 'error';
            $title = 'Oops...';
            $text = 'Input tidak boleh ada yang kosong!';
        } else if($username == "admin"){
            $status = 'error';
            $title = 'Oops...';
            $text = 'Username tidak boleh admin!';
        } else {
            $stmt = $conn->query("SELECT * FROM users WHERE username='$username'");
            $password = password_hash($password, PASSWORD_DEFAULT);

            if($stmt->num_rows == 0){
                $stmt = $conn->prepare("INSERT INTO users(name, username, password) VALUES(?,?,?)");
                $stmt->bind_param("sss", $name, $username, $password);
                $result = $stmt->execute();

                if($result){
                    $_SESSION["id_user"] = $stmt->insert_id;
                    $_SESSION["swal"] = "success~Berhasil register!";
                } else {
                    $status = 'error';
                    $title = 'Oops...';
                    $text = 'Gagal register!';
                }
            } else {
                $status = 'error';
                $title = 'Oops...';
                $text = 'Username telah dipakai!';
            }
        }
    }

    if(isset($_SESSION["id_user"])){
        header("Location: ../homepage/homepage.php");
        die;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <?php require_once("../../core/cdn.php"); ?> <!-- WAJIB INCLUDE DI SEMUA PAGE -->
    <?php require_once("../../templates/sweet_alert/sweet_alert.php"); ?> <!-- INCLUDE JIKA PAKAI SWEET ALERT -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../responsive.css">
    <link rel="shortcut icon" type="ico" href="../../favicon.ico"/>
</head>
<body>

    <div class="position-absolute ps-3 pt-3" style="left: 0; top: 0;">
        <a href="../homepage/homepage.php"><i class="fas fa-2x fa-arrow-left"></i></a>
    </div>

    <div class="container mt-3 container_login" id="container">
        <div class="form-container sign-up-container">
            <form action="#" method="POST">
                <h1>Create Account</h1>
                <span class="span-details">with your email for registration</span>
                <input type="text" placeholder="Name" name="name"/>
                <input type="text" placeholder="Username" name="username"/>
                <input type="password" placeholder="Password" name="password"/>
                <button type="submit" class="mt-3" name="register">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="#" method="POST">
                <h1>Sign in</h1>
                <span class="span-details">with your account</span>
                <input type="text" placeholder="Username" name="username"/>
                <input type="password" placeholder="Password" name="password"/>
                <button type="submit" class="mt-3" name="login">Sign In</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>

    <?php if(isset($status) && isset($title) && isset($text)){ ?>
        <script>
            let tmpTitle = "<?= $title ?>";
            let tmpText = "<?= $text ?>";
            let tmpStatus = "<?= $status ?>";
            swal({
                title: tmpTitle,
                text: tmpText,
                type: tmpStatus
            });
        </script>
    <?php
        }

        if(isset($_SESSION["user_action_login"])){
            $action = $_SESSION["user_action_login"];
            unset($_SESSION["user_action_login"]);
            
            if($action == "signup"){
                echo "<script>document.getElementById('container').classList.add('right-panel-active');</script>";
            }
        }
    ?>
</body>
</html>