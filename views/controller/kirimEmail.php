<?php
    require_once("../../core/connection.php");

    if(isset($_REQUEST["id_user"])){
        $stmt = $conn->query("SELECT * FROM users WHERE id='$_REQUEST[id_user]'");
        $user = $stmt->fetch_assoc();

        $name_user = $user["name"];
    } else if(isset($_REQUEST["name_user"])){
        $name_user = $_REQUEST["name_user"];
    }



// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// require '../vendor/autoload.php';

require("PHPMailer/src/PHPMailer.php");
require("PHPMailer/src/SMTP.php");
require("PHPMailer/src/Exception.php");


//Create a new PHPMailer instance
$mail = new PHPMailer\PHPMailer\PHPMailer();

//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
//SMTP::DEBUG_OFF = off (for production use)
//SMTP::DEBUG_CLIENT = client messages
//SMTP::DEBUG_SERVER = client and server messages
$mail->SMTPDebug = 0;

//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';
//Use `$mail->Host = gethostbyname('smtp.gmail.com');`
//if your network does not support SMTP over IPv6,
//though this may cause issues with TLS

//Set the SMTP port number:
// - 465 for SMTP with implicit TLS, a.k.a. RFC8314 SMTPS or
// - 587 for SMTP+STARTTLS
$mail->Port = 587;


//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = 'tukarginjalmuproyekweb@gmail.com';

//Password to use for SMTP authentication
$mail->Password = 'STTS12345';

//Set who the message is to be sent from
//Note that with gmail you can only use your account address (same as `Username`)
//or predefined aliases that you have configured within your account.
//Do not use user-submitted addresses in here
$mail->setFrom('cs@tukarginjalmu.com', 'tukarginjalmu.herokuapp.com');

//Set an alternative reply-to address
//This is a good place to put user-submitted addresses
$mail->addReplyTo('cs@tukarginjalmu.com', 'Admin Tukar Ginjalmu ini Reply-an');

//Set who the message is to be sent to
$mail->addAddress($_REQUEST["email_user"], $name_user);

//Set the subject line
$mail->Subject = $_REQUEST["subject_mail"];

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
$mail->msgHTML($_REQUEST["msg_mail"]);

//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';

//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message sent!';
    //Section 2: IMAP
    //Uncomment these to save your message in the 'Sent Mail' folder.
    #if (save_mail($mail)) {
    #    echo "Message saved!";
    #}
}

//Section 2: IMAP
//IMAP commands requires the PHP IMAP Extension, found at: https://php.net/manual/en/imap.setup.php
//Function to call which uses the PHP imap_*() functions to save messages: https://php.net/manual/en/book.imap.php
//You can use imap_getmailboxes($imapStream, '/imap/ssl', '*' ) to get a list of available folders or labels, this can
//be useful if you are trying to get this working on a non-Gmail IMAP server.
function save_mail($mail)
{
    //You can change 'Sent Mail' to any other folder or tag
    $path = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';

    //Tell your server to open an IMAP connection using the same username and password as you used for SMTP
    $imapStream = imap_open($path, $mail->Username, $mail->Password);

    $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
    imap_close($imapStream);

    return $result;
}