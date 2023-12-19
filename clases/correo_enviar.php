<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



require __DIR__ . '/../phpmailer/phpmailer/src/Exception.php';
require __DIR__ . '/../phpmailer/phpmailer/src/PHPMailer.php';
require __DIR__ . '/../phpmailer/phpmailer/src/SMTP.php';

// Configuración del servidor SMTP de Gmail
$smtpHost = 'smtp.gmail.com';
$smtpUsername = 'titokacique1.0@gmail.com';
$smtpPassword = 'vczf bkrl pfoo qfhk';
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
    $mail->setFrom('titokacique1.0@gmail.com', 'JOSEGASAM');
    $mail->addAddress('titokacique1.0@gmail.com', 'Jose');

    $mail->isHTML (true);
    $mail->Subject = 'Detalle de compra';

    $cuerpo = '<h4>Gracias por su compra</h4>';
    $cuerpo.= '<p>El id de su compra es <b>'.$id_transaccion.'</b></p>';
    

    $mail->Body    = utf8_decode($cuerpo);
    $mail->AltBody    = 'Contenido del correo en HTML o texto plano';

    // Adjuntar archivos si es necesario
    // $mail->addAttachment('ruta/al/archivo.pdf');

    // Enviar el correo
    $mail->send();

} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
    exit;
}

?>

