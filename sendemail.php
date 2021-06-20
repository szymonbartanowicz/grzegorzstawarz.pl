<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


define("RECIPIENT_NAME", "Grzegorz Stawarz");
//define( "RECIPIENT_EMAIL", "kontakt@grzegorzstawarz.pl" );
define("RECIPIENT_EMAIL", "szymonbartanowicz@gmail.com");


$success = false;
$senderName = isset($_POST['name']) ? preg_replace("/[^\.\-\' a-zA-Z0-9]/", "", $_POST['name']) : "";
$senderEmail = isset($_POST['email']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['email']) : "";
$message = isset($_POST['message']) ? preg_replace("/(From:|To:|BCC:|CC:|Subject:|Content-Type:)/", "", $_POST['message']) : "";

if ($senderName && $senderEmail && $message) {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.example.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = 'user@example.com';                     //SMTP username
        $mail->Password = 'secret';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        $mail->setFrom($senderEmail, 'Mailer');
        $mail->addAddress(RECIPIENT_EMAIL, RECIPIENT_NAME);


        $mail->isHTML(true);
        $mail->Subject = 'Here is the subject';
        $mail->Body = $message;

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    header('Location: kontakt.html?message=Successfull');
} else {
    header('Location: kontakt.html?message=Failed');
}
