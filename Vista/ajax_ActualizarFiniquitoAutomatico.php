<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio); 
$response = array();
//$response["status"] = "error";
//$log = new KLogger ( "ajax_ActualizarFiniquitoAuto.log" , KLogger::DEBUG );

$ban    = 0;
$numempleado    = $_POST["numempleado"];
$empleadoidd = explode("-", $numempleado);
$entidademp=$empleadoidd[0];
$consecutivoemp=$empleadoidd[1];
$categoriaemp=$empleadoidd[2]; 
 try {
//$log->LogInfo("Valor de la variable entidademp:  " . var_export($entidademp, true));

       $negocio->UpdateFiniquitoCreacionPdfAutomatico1($entidademp,$consecutivoemp,$categoriaemp);//Dias De Vacaciones Tomadas
        $response["status"] = "success";
    } catch (Exception $e) {
        $response["status"] = "error";
        $ban                 = 1;
        $response["mensaje"] = "Error al iniciar sesion";
    }
///////////////////EN PRODUCCION ESTAS LINEAS DEBEN SER MODIFICADAS CON LOS CORREOS A QUIAN VAYA DIRIGIDO EL MAIL
/*if ($ban == 0) {
    $mail = new PHPMailer;
    $mail->IsSMTP();
    // Set mailer to use SMTP
    $mail->Host       = 'smtp.office365.com'; // Specify main and backup server
    $mail->Port       = 587; // Set the SMTP port
    $mail->SMTPAuth   = true; // Enable SMTP authentication
    $mail->Username   = 'noreply@gifseguridad.com.mx'; // SMTP username
    $mail->Password   = 'SomverYhuU1@'; // SMTP password
    $mail->SMTPSecure = 'tls'; // Enable encryption, 'ssl' also accepted
    $mail->From       = 'noreply@gifseguridad.com.mx';
    $mail->FromName   = 'Soporte zonagif';
    $mail->AddAddress('roberto.vences@gifseguridad.com.mx');
    $mail->IsHTML(true); // Set email format to HTML
    $mail->Subject = utf8_decode('ACTUALIZA LAS DEDUCCIONES PARA FINIQUITO');
    $mail->Body    = utf8_decode("No se pudieron generar los finiquitos actuales, es necesario actualizar los deudores para el empleado {".$numempleado."}, por favor inicie sesión en zonagif para actualizarlos, enlace:  <a href='http://zona.gifseguridad.com.mx:" . $_SERVER["SERVER_PORT"] . "/zonagif/Vista/form_login.php' ><br>Entra aquí</a> ");
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    if (!$mail->Send()) {
        //echo 'Message could not be sent.';
        //echo 'Mailer Error: ' . $mail->ErrorInfo;
        //exit;
        $response["status"]  = "error";
        $response["message"] = $mail->ErrorInfo;
    }
}*/
echo json_encode($response);
