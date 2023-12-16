<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

// Configuración del servidor SMTP de Gmail
$smtpHost = 'smtp.gmail.com';
$smtpUsername = 'titokacique1.0@gmail.com';
$smtpPassword = 'sg509la';
$smtpPort = 587; // Usar 465 si estás utilizando SSL

$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP de Gmail
    $mail->isSMTP();
    $mail->Host       = $smtpHost;
    $mail->SMTPAuth   = true;
    $mail->Username   = $smtpUsername;
    $mail->Password   = $smtpPassword;
    $mail->SMTPSecure = 'tls'; // Usa 'ssl' si estás utilizando el puerto 465 con SSL
    $mail->Port       = $smtpPort;

    // Configuración del correo
    $mail->setFrom('titokacique1.0@gmail.com', 'Tu Nombre');
    $mail->addAddress('titokacique1.0@example.com', 'Nombre Destinatario');
    $mail->Subject = 'Asunto del Correo';
    $mail->Body    = 'Contenido del correo en HTML o texto plano';

    // Adjuntar archivos si es necesario
    // $mail->addAttachment('ruta/al/archivo.pdf');

    // Enviar el correo
    $mail->send();
    echo 'Correo enviado correctamente.';
} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
}
?>

