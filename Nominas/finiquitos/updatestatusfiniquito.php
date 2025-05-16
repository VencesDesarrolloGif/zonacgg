<?php
session_start();
require "../conexion/conexion.php";
require_once "../../libs/phpmailer/class.phpmailer.php";
require_once "../../libs/logger/KLogger.php";
$response = array();
$ban      = 0;
$datos    = array();
$datos1   = array();
$datos2   = array();
$datos3   = array();
$datos4   = array();

$numempleado = $_POST["numempleado"];
$empleadoidd = explode("-", $numempleado);

$entidademp=$empleadoidd[0];
$consecutivoemp=$empleadoidd[1];
$categoriaemp=$empleadoidd[2]; 

$sql0 = "SELECT montoIF FROM infonavit_finiquito
        where entidadEmpIF='$entidademp'
        and consecutivoEmpIF='$consecutivoemp'
        and categoriaEmpIF='$categoriaemp';";
$res0 = mysqli_query($conexion, $sql0);
while (($reg0 = mysqli_fetch_array($res0, MYSQLI_ASSOC))) {
    $datos[] = $reg0;
}
$conteo = count($datos);

$sql1 = "SELECT montoPeF FROM pension_finiquito
            where entidadEmpPeF='$entidademp'
            and consecutivoEmpPeF='$consecutivoemp'
            and categoriaEmpPeF='$categoriaemp';";
$res1 = mysqli_query($conexion, $sql1);
while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))) {
    $datos1[] = $reg1;
}
$conteo1 = count($datos1);
$sql2    = "SELECT montoPF FROM prestamo_finiquito
                where entidadEmpPF='$entidademp'
                and consecutivoEmpPF='$consecutivoemp'
                and categoriaEmpPF='$categoriaemp';";
$res2 = mysqli_query($conexion, $sql2);
while (($reg2 = mysqli_fetch_array($res2, MYSQLI_ASSOC))) {
    $datos2[] = $reg2;
}
$conteo2 = count($datos2);

$sql3 = "SELECT montoFF FROM fonacot_finiquito
where entidadEmpFF='$entidademp'
and consecutivoEmpFF='$consecutivoemp'
and categoriaEmpFF='$categoriaemp';";
$res3 = mysqli_query($conexion, $sql3);
while (($reg3 = mysqli_fetch_array($res3, MYSQLI_ASSOC))) {
    $datos3[] = $reg3;
}
$conteo3 = count($datos3);

if ($conteo == 0) {
    $response["msg"] = "error";
} elseif ($conteo1 == 0) {
    $response["msg"] = "error1";
} else if ($conteo2 == 0) {
    $response["msg"] = "error2";
} elseif ($conteo3 == 0) {
    $response["msg"] = "error3";
} else {
    $ban = 1;
//$monto = $datos[0]["montoIF"];
    //if ($monto == null || $monto == 0) {}
    // $entidadFederativa   = $datos[$i]["entidadEmpFiniquito"];
    //$empleadoConsecutivo = $datos[$i]["consecutivoEmpFiniquito"];
    //$empleadoCategoria   = $datos[$i]["categoriaEmpFiniquito"];
    try {
        $sql = "UPDATE finiquitos SET estatusFiniquito=1
where entidadEmpFiniquito=$entidademp
AND consecutivoEmpFiniquito=$consecutivoemp
AND categoriaEmpFiniquito=$categoriaemp
and estatusFiniquito=0";
        $res = mysqli_query($conexion, $sql);
        if ($res != true) {
            $response["mensaje"] = "Falló la actualización";
            $ban                 = 1;
        } else {
            $response["status"] = "success";}
    } catch (Exception $e) {
        $ban                 = 1;
        $response["mensaje"] = "Error al iniciar sesion";
    }
}
///////////////////EN PRODUCCION ESTAS LINEAS DEBEN SER MODIFICADAS CON LOS CORREOS A QUIAN VAYA DIRIGIDO EL MAIL
if ($ban == 0) {
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
    $mail->FromName   = 'Soporte zonacgg';
   // $mail->AddAddress('roberto.vences@gifseguridad.com.mx');
    $mail->AddAddress('comprobantes@gifseguridad.com.mx');  
	$mail->AddAddress('francisco.carbajal@gifseguridad.com.mx');
	$mail->AddAddress('Rodolfo.gonzalez@gifseguridad.com.mx');
	$mail->AddAddress('coordinación.foranea@gifseguridad.com.mx');
    $mail->IsHTML(true); // Set email format to HTML
    $mail->Subject = utf8_decode('ACTUALIZA LAS DEDUCCIONES PARA FINIQUITO');
    $mail->Body    = utf8_decode("No se pudieron generar los finiquitos actuales, es necesario actualizar los deudores para el empleado {".$numempleado."}, por favor inicie sesión en zonacgg para actualizarlos, enlace:  <a href='http://zona.gifseguridad.com.mx:" . $_SERVER["SERVER_PORT"] . "/zonacgg/Vista/form_login.php' ><br>Entra aquí</a> ");
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    if (!$mail->Send()) {
        //echo 'Message could not be sent.';
        //echo 'Mailer Error: ' . $mail->ErrorInfo;
        //exit;
        $response["status"]  = "error";
        $response["message"] = $mail->ErrorInfo;
    }
}
echo json_encode($response);
