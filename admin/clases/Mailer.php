<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class Mailer{

    function enviarEmail($correo,$asunto,$cuerpo){
        require_once './config/config.php';
        require './phpmailer/src/Exception.php';
        require './phpmailer/src/PHPMailer.php';
        require './phpmailer/src/SMTP.php';
        
        $mail = new PHPMailer(true);

        try {
                //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER; //SMTP::DEBUG_OFF;                     //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = MAIL_HOST;                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = MAIL_USER;                     //SMTP username
            $mail->Password   = MAIL_PASS;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = MAIL_PORT;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
            $mail->setFrom(MAIL_USER, 'JOSEGASAM');

            //Recipients
            $mail->addAddress($correo);     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $asunto;



            if($mail->send()){
                return true;

            }else{
                return false;
            }

        } catch (Exception $e) {
            //echo "Error al enviar el correo de detalle de pedido.{$mail->ErrorInfo}";
            return false;   
        }
    }
}


 
