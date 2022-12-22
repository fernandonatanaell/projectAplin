<?php
    require_once("../../core/connection.php");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>

    <?php require_once("../../core/cdn.php"); ?> <!-- WAJIB INCLUDE DI SEMUA PAGE -->
    <?php require_once("../../templates/sweet_alert/sweet_alert.php"); ?> <!-- INCLUDE JIKA PAKAI SWEET ALERT -->

    <link rel="stylesheet" href="../main.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="contact_responsive.css">
    <link rel="shortcut icon" type="ico" href="../../favicon.ico"/>

</head>
<body>
    <div class="super_container">

        <!-- NAVBAR -->
        <?php require_once("../../templates/navbar/navbar.php"); ?>

        <!-- Contact Form -->
        <div class="contact_form">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <div class="contact_form_container">
                            <div class="contact_form_title">Get in Touch</div>

                            <form action="" id="contact_form">
                                <div class="row mb-4">
                                    <div class="col pe-3">
                                        <input type="text" id="contact_form_name" class="contact_form_name input_field" placeholder="Your name" required="required" data-error="Name is required.">
                                    </div>
                                    <div class="col ps-3">
                                        <input type="email" id="contact_form_email" class="contact_form_email input_field" placeholder="Your email" required="required" data-error="Email is required.">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="contact_form_text">
                                            <textarea id="contact_form_message" class="text_field contact_form_message" rows="4" placeholder="Message" required="required" data-error="Please, write us a message."></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="contact_form_button">
                                    <button class="button contact_submit_button">Send Message</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <?php require_once("../../templates/footer/footer.php"); ?>

    </div>

    <script>
        $(".contact_submit_button").on('click', function(e){
            e.preventDefault();
            let element = $(this).parent().parent();
            let name_user = element.find(".contact_form_name").val();
            let email_user = element.find(".contact_form_email").val();
            let msg_mail = element.find(".contact_form_message").val();
            let id_user = $("#id_user_now").val();

            if(id_user != "-1"){
                $.ajax({
                    type: "POST",
                    url: "../controller/kirimEmail.php",
                    beforeSend: function(){
                        Swal.fire({
                            title: 'Wait...',
                            onBeforeOpen () {
                                Swal.showLoading ()
                            },
                            onAfterClose () {
                                Swal.hideLoading()
                            },
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false
                        })
                    },
                    data: {
                        'name_user' : name_user,
                        'email_user' : email_user,
                        'subject_mail' : "Hi, " + name_user,
                        'msg_mail' : "Pesanmu \"" + msg_mail + "\" sudah dikirimkan ke Admin. Harap bersabar untuk menunggu jawaban dari Admin.."
                    },
                    success: function (data) {
                        swal({
                            title: "Yeay!!",
                            text: "Pesanmu berhasil dikirimkan!",
                            type: "success"
                        });
                        element.find(".contact_form_name").val("");
                        element.find(".contact_form_email").val("");
                        element.find(".contact_form_message").val("");
                    }
                });
            } else {
                window.location = "../login/login.php";
            }
        })
    </script>
</body>
</html>