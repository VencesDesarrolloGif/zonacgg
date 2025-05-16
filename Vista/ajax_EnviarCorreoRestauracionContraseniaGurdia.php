<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/phpmailer/class.phpmailer.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();
//$log = new KLogger ( "ajax_EnviarCorreoRestauracionContraseniaGurdia.log" , KLogger::DEBUG );
$response = array("status" => "error");
$correo=getValueFromPost("correo");
$numeroempleadoexiste=getValueFromPost("numeroempleadoexiste");
$empleadoidd = explode("-", $numeroempleadoexiste);
$empleadoEntidad=$empleadoidd[0];
$empleadoConsecutivo=$empleadoidd[1];
$empleadoCategoria=$empleadoidd[2];
$usuarioEmp = $empleadoEntidad.$empleadoConsecutivo.$empleadoCategoria.' '.$correo;
 //$log->LogInfo("Valor de variable de empleado correo" . var_export ($correo, true));
 //$log->LogInfo("Valor de variable de empleado numeroempleadoexiste" . var_export ($numeroempleadoexiste, true));
 //$log->LogInfo("Valor de variable de empleado empleadoidd" . var_export ($empleadoidd, true));
try
{
    //$log->LogInfo("Valor de la variable \$listaEmpleados: " . var_export ($listaEmpleados, true));
            //$response["status"]="success";
            //$response ["message"] ="si existe elemento";
            
    $mail = new PHPMailer;
                $mail->IsSMTP();
                $mail->Host       = 'smtp.office365.com';
                $mail->Port       = 587;
                $mail->SMTPAuth   = true;
                $mail->Username   = 'registros@gifseguridad.com.mx';
                $mail->Password   = 'Har00112';
                $mail->SMTPSecure = 'tls';
                $mail->From       = 'registros@gifseguridad.com.mx';
                $mail->FromName   = 'Soporte Grupo Gif';
        
    $mail->AddAddress($correo);  
    $mail->IsHTML(true);                                  // Set email format to HTML
    $mail->Subject = utf8_decode('Restauración De Contraseña para Guardias de Gif Seguridad Privada');
    $mail->Body    = utf8_decode("Hemos recibido una solicitud de restauración de su Contraseña para su cuenta
        , para continuar con el proceso haga click en el siguiente enlace: 
        <a href='http://".$_SERVER["SERVER_NAME"] .":" .$_SERVER["SERVER_PORT"].dirname ($_SERVER ["SCRIPT_NAME"])."/restauracionContraseniaParaGuardia.php?usuarioEmp=".$usuarioEmp."'><br>Reestablecer Contraseña</a> ");
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    if(!$mail->Send()) {
        //echo 'Message could not be sent.';
        //echo 'Mailer Error: ' . $mail->ErrorInfo;
        //exit;
        $response["status"]="error";
        $response ["message"] ="No se pudo hacer él envió de correo electrónico de restauración de Contraseña, por favor comuniquese a la oficina donde fue orientado";
    }else{
        $response["status"]="success";
        $response ["message"] ="Correo electrónico enviado, por favor verifique su bandeja de entrada o la carpeta de correos no deseados o span para continuar con el proceso de restauración de su Contraseña";
    }
} 
catch( Exception $e )
{
    $response["status"]="error";
    $response["error"]="No se puedo obtener consulta";
    $response ["message"] =  $e -> getMessage ();
}
echo json_encode($response);

?>