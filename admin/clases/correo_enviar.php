<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require './phpMailer/src/Exception.php';
require './phpMailer/src/PHPMailer.php';
require './phpMailer/src/SMTP.php';



//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; //SMTP::DEBUG_OFF;                     //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'titokacique1.0@gmail.com';                     //SMTP username
    $mail->Password   = 'sg509la';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
 
    //Recipients
    $mail->setFrom('titokacique1.0@gmail.com', 'JOSEGASAM');
    $mail->addAddress('titokacique1.0@gmail.com', 'Jose pacheco');     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Detalles de pedido';
    $cuerpo ='<h4>Gracias por preferirnos</h4>';
    $cuerpo .='<p>El id del pedido es</p>';

    $mail->Body    = $cuerpo;
    $mail->AltBody = 'Se le envia el detalle del pedido.';

    
    $mail->send();
} catch (Exception $e) {
    //echo "Error al enviar el correo de detalle de pedido.{$mail->ErrorInfo}";
    exit;
}

?>