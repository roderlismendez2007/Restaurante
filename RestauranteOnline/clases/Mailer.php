<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer{

    function enviaremail($email, $asunto, $cuerpo){

        require_once '/xampp/htdocs/PF/Confi/confi.php';

        require '/xampp/htdocs/PF/phpmailer/src/PHPMailer.php';
        require '/xampp/htdocs/PF/phpmailer/src/SMTP.php';
        require '/xampp/htdocs/PF/phpmailer/src/Exception.php';

        $mail = new PHPMailer(true);

        // ... resto del código de la clase Mailer ...
    



        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;   //SMTP::DEBUG_OFF; 
            $mail->isSMTP();                                          
            $mail->Host       = 'smtp.gmail.com';                   
            $mail->SMTPAuth   = true;                                   
            $mail->Username   = Cuneta;                    
            $mail->Password   = CONS;                              
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           
            $mail->Port       = 465;  //TCP port to connect to; use 587   PHPMailer::ENCRYPTION_STARTTLS`
            //Recipients            
            $mail->addAddress(Recibidor);     
            //Content
            $mail->isHTML(true);                              
            $mail->Subject = $asunto;

            $mail->Body    = utf8_decode($cuerpo);

            $mail->setLanguage('es', '../phpmailer/language/phpmailer.lang-es.php');

            
            if($mail->send()){
                return true;
            }else{
                return false;
            }
            echo "se envio correctamente";
            } catch (Exception $e) {
            echo "Error al enviar el correo electronico de la compra: {$mail->ErrorInfo}";
            return false;

            exit;

            //sb-ztkce29059488@personal.example.com
            //8iG$?*qU
        }
    }
}