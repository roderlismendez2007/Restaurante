<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once '../Confi/confi.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
require '../phpmailer/src/Exception.php';

//Create an instance; passing `true` enables exceptions
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
    $mail->setFrom('empresariosfuturos764@gmail.com');
    $mail->addAddress(Recibidor);     
    //Content
    $mail->isHTML(true);                              
    $mail->Subject = 'Detalles de su compra';

    $cuerpo = '<h4>Gracias por su compra</h4>';
    
    $cuerpo .= "<p><strong>Hola mucho gusto " . $_SESSION['use_name']. " estos son los detalles de tu compra</strong></p> ";
    $cuerpo .= '<p>Su ID de compras es <b><a href="http://localhost/PF/completado.php?orden=' . $id_transaccion . '">' . $id_transaccion . ' Dame click para mas informacion</a></b></p>';

    
    


    $mail->Body    = utf8_decode($cuerpo);
    $mail->AltBody = 'Le enviamos los detalles de su compra.';

    $mail->setLanguage('es', '../phpmailer/language/phpmailer.lang-es.php');

    $mail->send();
    echo "se envio correctamente";
} catch (Exception $e) {
    echo "Error al enviar el correo electronico de la compra: {$mail->ErrorInfo}";
    exit;

    //sb-ztkce29059488@personal.example.com
    //8iG$?*qU
}
