<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("../libs/phpmailer/class.phpmailer.php");
require_once ("Helpers.php");
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio ();
$response = array();
//$log = new KLogger("ajax_EnviarCorreo.log", KLogger::DEBUG);
$HistoricoCorreos        = array();
$prestamo                = $_POST["prestamo"];
$infonavit               = $_POST["infonavit"];
$fonacot                 = $_POST["fonacot"];
$pension                 = $_POST["pension"];
$diastrabajados          = $_POST["diastrabajados"];
$numempleado             = $_POST["numempleado"];
$netoAlPago              = $_POST["netoAlPago"];
$diasDeVacaciones        = $_POST["diasDeVacaciones"];
$nomemp                  = $_POST["nomemp"];
$diasDeVacaciones        = $_POST["diasDeVacaciones"];
$PensionFechaCarga       = $_POST["PensionFechaCarga"];
$FonacotFechaCarga       = $_POST["FonacotFechaCarga"];
$nombreEntidadFederativa = $_POST["nombreEntidadFederativa"];
$PrestamoFechaCarga      = $_POST["PrestamoFechaCarga"];
$InfonavitFechaCarga     = $_POST["InfonavitFechaCarga"];
$DíasTrabajadosFechaCarga= $_POST["DíasTrabajadosFechaCarga"];
$entidad                 = $_POST["entidad"];
$consecutivo             = $_POST["consecutivo"];
$categoria               = $_POST["categoria"];
$usuario                 = $_SESSION["userLog"]["usuario"];
$NombreUsuario           = $_POST["NombreUsuario"];
$apellidoPaternoUsuario  = $_POST["apellidoPaternoUsuario"];
$apellidoMaternoUsuario  = $_POST["apellidoMaternoUsuario"];

$Uniformesentregados     = $_POST["Uniformesentregados"];
$UniformesFechaHoraCarga = $_POST["UniformesFechaHoraCarga"];
//$log->LogInfo("Valor de la variable Uniformesentregados: " . var_export ($Uniformesentregados, true));
//$log->LogInfo("Valor de la variable UniformesFechaHoraCarga: " . var_export ($UniformesFechaHoraCarga, true));


 
  if($netoAlPago<0 && $prestamo >= 1 && $infonavit >= 1 && $fonacot >= 1 && $pension >= 1 && $diastrabajados >= 1 ){
  $EstatusNegociacion = '0';
  }
   else{
   $EstatusNegociacion = '1';
   }

try {

$HistoricoCorreos = $negocio -> InsertarHistorico($entidad,$consecutivo,$categoria,$nomemp,$nombreEntidadFederativa,$prestamo,$PrestamoFechaCarga,$infonavit,$InfonavitFechaCarga,$fonacot,$FonacotFechaCarga,$pension,$PensionFechaCarga,$diastrabajados,$DíasTrabajadosFechaCarga,$diasDeVacaciones,$netoAlPago,$EstatusNegociacion,$usuario); 


if($diasDeVacaciones == NULL || $diasDeVacaciones == "NULL"|| $diasDeVacaciones == null || $diasDeVacaciones == "null" || $diasDeVacaciones == ""){
//$log->LogInfo("Valor de la variable prestamo: " . var_export ($prestamo, true));

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host       = 'smtp.office365.com';
        $mail->Port       = 587;
        $mail->SMTPAuth   = true;
        $mail->Username   = 'registros@gifseguridad.com.mx';
        $mail->Password   = 'Har00112';
        $mail->SMTPSecure = 'tls';
        $mail->From       = 'registros@gifseguridad.com.mx';
        $mail->FromName   = 'Soporte Gif Seguridad';

      $mail->AddAddress('daniel.hernandez@gifseguridad.com.mx'); //ANEXAR AL CARGAR EN PRODUCCION

      $mail->IsHTML(true); // Set email format to HTML
      $mail->Subject = utf8_decode('CARGAR INFORMACION DE PRESTAMO');
      $mail->Body    = utf8_decode("SE REQUIERE QUE CARGUE LA INFORMACION DE LOS DIAS DE VACACIONES DEL EMPLEADO NO. ".$numempleado." A PETICION DE ".$NombreUsuario." ".$apellidoPaternoUsuario." ".$apellidoMaternoUsuario."");
  
       if (!$mail->Send()) {
          $response["status"]  = "error";
          $response["message"] = $mail->ErrorInfo;
        }
}
else{

  if ($prestamo == 0) {

      $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host       = 'smtp.office365.com';
        $mail->Port       = 587;
        $mail->SMTPAuth   = true;
        $mail->Username   = 'registros@gifseguridad.com.mx';
        $mail->Password   = 'Har00112';
        $mail->SMTPSecure = 'tls';
        $mail->From       = 'registros@gifseguridad.com.mx';
        $mail->FromName   = 'Soporte Gif Seguridad';

      $mail->AddAddress('comprobantes@gifseguridad.com.mx');      //ANEXAR AL CARGAR EN PRODUCCION
      $mail->AddAddress('roberto.ayala@gifseguridad.com.mx');

      $mail->IsHTML(true); // Set email format to HTML
      $mail->Subject = utf8_decode('CARGAR INFORMACION DE PRESTAMO');
      $mail->Body    = utf8_decode("SE REQUIERE QUE CARGUE LA INFORMACION DEL PRESTAMO DEL EMPLEADO NO. ".$numempleado." A PETICION DE ".$NombreUsuario." ".$apellidoPaternoUsuario." ".$apellidoMaternoUsuario."");
  
       if (!$mail->Send()) {
          $response["status"]  = "error";
          $response["message"] = $mail->ErrorInfo;
      }
  }

  if ($infonavit == 0) {

      $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host       = 'smtp.office365.com';
        $mail->Port       = 587;
        $mail->SMTPAuth   = true;
        $mail->Username   = 'registros@gifseguridad.com.mx';
        $mail->Password   = 'Har00112';
        $mail->SMTPSecure = 'tls';
        $mail->From       = 'registros@gifseguridad.com.mx';
        $mail->FromName   = 'Soporte Gif Seguridad';

      $mail->AddAddress('comprobantes@gifseguridad.com.mx');    //ANEXAR AL CARGAR EN PRODUCCION
      $mail->AddAddress('roberto.ayala@gifseguridad.com.mx');

      $mail->IsHTML(true); // Set email format to HTML
      $mail->Subject = utf8_decode('CARGAR INFORMACION DE AMORTIZACION');
      $mail->Body    = utf8_decode("SE REQUIERE QUE CARGUE LA INFORMACION DE AMORTIZACION DEL EMPLEADO NO. ".$numempleado." A PETICION DE ".$NombreUsuario." ".$apellidoPaternoUsuario." ".$apellidoMaternoUsuario."");
       if (!$mail->Send()) {
          $response["status"]  = "error";
          $response["message"] = $mail->ErrorInfo;
      }
  }
  
  if ($fonacot == 0) {

      $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host       = 'smtp.office365.com';
        $mail->Port       = 587;
        $mail->SMTPAuth   = true;
        $mail->Username   = 'registros@gifseguridad.com.mx';
        $mail->Password   = 'Har00112';
        $mail->SMTPSecure = 'tls';
        $mail->From       = 'registros@gifseguridad.com.mx';
        $mail->FromName   = 'Soporte Gif Seguridad';

      $mail->AddAddress('coordinación.foranea@gifseguridad.com.mx');  //ANEXAR AL CARGAR EN PRODUCCION

      $mail->IsHTML(true); // Set email format to HTML
      $mail->Subject = utf8_decode('CARGAR INFORMACION DE FONACOT');
      $mail->Body    = utf8_decode("SE REQUIERE QUE CARGUE LA INFORMACION DE FONACOT DEL EMPLEADO NO. ".$numempleado." A PETICION DE ".$NombreUsuario." ".$apellidoPaternoUsuario." ".$apellidoMaternoUsuario."");
       if (!$mail->Send()) {
          $response["status"]  = "error";
          $response["message"] = $mail->ErrorInfo;
      }
  }
  
  if ($pension == 0) {

      $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host       = 'smtp.office365.com';
        $mail->Port       = 587;
        $mail->SMTPAuth   = true;
        $mail->Username   = 'registros@gifseguridad.com.mx';
        $mail->Password   = 'Har00112';
        $mail->SMTPSecure = 'tls';
        $mail->From       = 'registros@gifseguridad.com.mx';
        $mail->FromName   = 'Soporte Gif Seguridad';
      
      $mail->AddAddress('coordinación.foranea@gifseguridad.com.mx'); //ANEXAR AL CARGAR EN PRODUCCION

      $mail->IsHTML(true); // Set email format to HTML
      $mail->Subject = utf8_decode('CARGAR INFORMACION DE PENSION');
      $mail->Body    = utf8_decode("SE REQUIERE QUE CARGUE LA INFORMACION DE PENSION DEL EMPLEADO NO. ".$numempleado." A PETICION DE ".$NombreUsuario." ".$apellidoPaternoUsuario." ".$apellidoMaternoUsuario."");
       if (!$mail->Send()) {
          $response["status"]  = "error";
          $response["message"] = $mail->ErrorInfo;
      }
  }
  
  if ($diastrabajados == 0) {

      $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host       = 'smtp.office365.com';
        $mail->Port       = 587;
        $mail->SMTPAuth   = true;
        $mail->Username   = 'registros@gifseguridad.com.mx';
        $mail->Password   = 'Har00112';
        $mail->SMTPSecure = 'tls';
        $mail->From       = 'registros@gifseguridad.com.mx';
        $mail->FromName   = 'Soporte Gif Seguridad';

      $mail->AddAddress('analista.asistencia@gifseguridad.com.mx');

      $mail->IsHTML(true); // Set email format to HTML
      $mail->Subject = utf8_decode('CARGAR INFORMACION DE LOS DIAS TRABAJADOS');
      $mail->Body    = utf8_decode("SE REQUIERE QUE CARGUE LA INFORMACION DE LOS DIAS TRABAJADOS DEL EMPLEADO NO. ".$numempleado." A PETICION DE ".$NombreUsuario." ".$apellidoPaternoUsuario." ".$apellidoMaternoUsuario."");
       if (!$mail->Send()) {
          $response["status"]  = "error";
          $response["message"] = $mail->ErrorInfo;
      }
  }

  if($netoAlPago< 0 && $prestamo >= 1 && $infonavit >= 1 && $fonacot >= 1 && $pension >= 1 && $diastrabajados >= 1 ){

      $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host       = 'smtp.office365.com';
        $mail->Port       = 587;
        $mail->SMTPAuth   = true;
        $mail->Username   = 'registros@gifseguridad.com.mx';
        $mail->Password   = 'Har00112';
        $mail->SMTPSecure = 'tls';
        $mail->From       = 'registros@gifseguridad.com.mx';
        $mail->FromName   = 'Soporte Gif Seguridad';

      $mail->AddAddress('daniel.hernandez@gifseguridad.com.mx');

      $mail->IsHTML(true); // Set email format to HTML
      $mail->Subject    = utf8_decode('CARGAR INFORMACION DE LOS DIAS TRABAJADOS');
      $mail->Body       = utf8_decode("SE REQUIERE INFORMACION DE LA NEGOCIACION DEL EMPLEADO NO. ".$numempleado." A PETICION DE ".$NombreUsuario." ".$apellidoPaternoUsuario." ".$apellidoMaternoUsuario."");
       if (!$mail->Send()) {
          $response["status"]  = "error";
          $response["message"] = $mail->ErrorInfo;
    }
  }

  if ($Uniformesentregados == 0) {

      $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host       = 'smtp.office365.com';
        $mail->Port       = 587;
        $mail->SMTPAuth   = true;
        $mail->Username   = 'registros@gifseguridad.com.mx';
        $mail->Password   = 'Har00112';
        $mail->SMTPSecure = 'tls';
        $mail->From       = 'registros@gifseguridad.com.mx';
        $mail->FromName   = 'Soporte Gif Seguridad';
      $mail->AddAddress('almacen@gifseguridad.com.mx');//almacen

     // $mail->AddAddress('coordinación.foranea@gifseguridad.com.mx');  //ANEXAR AL CARGAR EN PRODUCCION

      $mail->IsHTML(true); // Set email format to HTML
      $mail->Subject = utf8_decode('CARGAR INFORMACION DE UNIFORMES');
      $mail->Body    = utf8_decode("SE REQUIERE QUE CARGUE LA INFORMACION DE UNIFORMES DEL EMPLEADO NO. ".$numempleado." A PETICION DE ".$NombreUsuario." ".$apellidoPaternoUsuario." ".$apellidoMaternoUsuario."");
       if (!$mail->Send()) {
          $response["status"]  = "error";
          $response["message"] = $mail->ErrorInfo;
      }
  }



}

} catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}

echo json_encode($response);
