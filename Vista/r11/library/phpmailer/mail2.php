<?php
require_once ('class.phpmailer.php');
$Mail = new PHPMailer();
$Mail->IsSMTP();
$mail->Host = 'smtp.custodiasgif.com.mx';  
$Mail->SMTPDebug = 2; //no olvides quitar el debug
$Mail->SMTPAuth = true;
$Mail->SMTPSecure = '';
$Mail->Port = 1025;
$mail->Username = 'seguimiento@custodiasgif.com.mx';                // SMTP username
$mail->Password = 'seguimiento'; 
$Mail->Priority = 1;
$Mail->CharSet = 'UTF-8';
$Mail->Encoding = '8bit';
$Mail->Subject = 'Mensaje de prueba Gmail';
$Mail->ContentType = 'text/html; charset=utf-8\r\n';
$Mail->From = 'seguimiento@custodiasgif.com.mx';
$Mail->FromName = 'seguimiento@custodiasgif.com.mx';
$Mail->WordWrap = 900;
 
$Mail->AddAddress('seguimiento@custodiasgif.com.mx');
$Mail->isHTML(TRUE);
$Mail->Body = 'Hola este es mi mensaje';
$Mail->Send();
$Mail->SmtpClose();
 
if(!$mail->Send()) {
   echo 'Message could not be sent.';
   echo 'Mailer Error: ' . $mail->ErrorInfo;
   exit;
}

echo 'Message has been sent';