<?php
// file: ajax_registrarAsistencia.php

// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo. 
session_start ();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/phpmailer/class.phpmailer.php");
$negocio = new Negocio ();
verificarInicioSesion ($negocio);
$response = array ();
$usuarioEliminaRegistro = $_SESSION ["userLog"]["usuario"];
if (!empty ($_POST))
{
    //$log = new KLogger ( "ajax_deleteAsistenciaFromAsistencia.log" , KLogger::DEBUG );
    //$log->LogInfo("Valor de la variable \_POST negocio: " . var_export ($_POST, true));

    $incidencia["empleadoEntidad"] = getValueFromPost ("empleadoEntidadId"); 
    $incidencia["empleadoConsecutivo"] = getValueFromPost ("empleadoConsecutivoId");
    $incidencia["empleadoTipo"] = getValueFromPost ("empleadoTipoId");
    $incidencia["fechaAsistencia"] = getValueFromPost ("asistenciaFecha");
    $incidencia["usuario"] = $usuarioEliminaRegistro;
    $tipoPeriodo=getValueFromPost ("tipoPeriodo");
    $incidenciaId=getValueFromPost ("incidenciaId");
    $folioincapacidad=getValueFromPost ("folioincapacidad");
    if($incidenciaId==5 || $incidenciaId==6 || $incidenciaId==12 || $incidenciaId==13)
    {
        $ConsultaFolioVacaciones = $negocio -> obtenerFolioVacaciones($incidencia);
    //$log->LogInfo("Valor de la variable ConsultaFolioVacaciones negocio: " . var_export ($ConsultaFolioVacaciones, true));

        $folioVacaciones = $ConsultaFolioVacaciones[0]["folioVacaciones"];
    //$log->LogInfo("Valor de la variable folioVacaciones: " . var_export ($folioVacaciones, true));

        $response = $negocio -> deleteIncidenciaVacacionesByFolio($incidencia, $folioVacaciones);
        
    }else{
        if($incidenciaId!=8 || ($incidenciaId==8 && $folioincapacidad=="null")){
            $response = $negocio -> deleteAsistenciaFromAsistencia ($incidencia );
        }else if($incidenciaId==8 && $folioincapacidad !="null"){
            $response = $negocio -> deleteIncidenciaIncapacidadByFolio ($incidencia,$incidenciaId, $folioincapacidad);
        }
    }
    
   if($response ["status"] == "success"){
    $negocio -> negocio_deleteTipoTurno ($incidencia);
}

    $fechasPeriodo = $negocio -> obtenerListaDiasParaAsistencia ($tipoPeriodo);
    //$log->LogInfo("Valor de la variable \$fechasPeriodo: " . var_export ($fechasPeriodo, true));
    // Recupera la lista de asistencias del empleado por todo el periodo
    $response ["asistencia"] =  $negocio -> getAsistenciaByEmpleadoPeriodo ($fechasPeriodo[0]["fecha"], 
    $fechasPeriodo[count($fechasPeriodo) - 1]["fecha"], 
    $incidencia["empleadoEntidad"], 
    $incidencia ["empleadoConsecutivo"], 
    $incidencia ["empleadoTipo"]);

    try
    {

    $PeticionAceptada = $negocio -> getestatusPeticionesincidenciaespecial($incidencia); // Se consulta para saber si la peticion de incidencia especial fue aceptada por direccion general en caso de ser asi mandar correo a direccion general
    $MaxIdPeticion = $PeticionAceptada[0]["idPeticionIncidencia"];
    if($MaxIdPeticion != "NULL" && $MaxIdPeticion != "null" && $MaxIdPeticion != NULL && $MaxIdPeticion != null && $MaxIdPeticion != ""){

        $PincidenciaEmpleadoEntidad =  $PeticionAceptada[0]["PincidenciaEmpleadoEntidad"];
        $PincidenciaEmpleadoConsecutivo =  $PeticionAceptada[0]["PincidenciaEmpleadoConsecutivo"];
        $PincidenciaEmpleadoTipo =  $PeticionAceptada[0]["PincidenciaEmpleadoTipo"];
        $PincidenciaSupervisorEntidad =  $PeticionAceptada[0]["PincidenciaSupervisorEntidad"];
        $PincidenciaSupervisorConsecutivo =  $PeticionAceptada[0]["PincidenciaSupervisorConsecutivo"];
        $PincidenciaSupervisorTipo =  $PeticionAceptada[0]["PincidenciaSupervisorTipo"];
        $PincidenciaFecha =  $PeticionAceptada[0]["PincidenciaFecha"];
        $PincidenciaFechaRegistro =  $PeticionAceptada[0]["PincidenciaFechaRegistro"];
        $PincidenciaUsuarioCaptura =  $PeticionAceptada[0]["PincidenciaUsuarioCaptura"];
        $PincidenciaLastEdited =  $PeticionAceptada[0]["PincidenciaLastEdited"];
        $PincidenciaUsuarioEdited =  $PeticionAceptada[0]["PincidenciaUsuarioEdited"];
        $FechaConfirmacionRechazoP =  $PeticionAceptada[0]["FechaConfirmacionRechazoP"];
        $FechaBorradoSup =  $PeticionAceptada[0]["FechaBorradoSup"];
        $UsuarioEliminate =  $PeticionAceptada[0]["UsuarioEliminate"];
    
        $NumEmpleadoP = $PincidenciaEmpleadoEntidad . "-" . $PincidenciaEmpleadoConsecutivo . "-" . $PincidenciaEmpleadoTipo;
    
        $NumSupervisorP = $PincidenciaSupervisorEntidad . "-" . $PincidenciaSupervisorConsecutivo . "-" . $PincidenciaSupervisorTipo;
    
        if($PincidenciaLastEdited == null || $PincidenciaLastEdited == NULL || $PincidenciaLastEdited=="" || $PincidenciaLastEdited== "null" || $PincidenciaLastEdited == "NULL"){
            $PincidenciaLastEdited=" Sin Registro";
        }
        if($PincidenciaUsuarioEdited == null || $PincidenciaUsuarioEdited == NULL || $PincidenciaUsuarioEdited=="" || $PincidenciaUsuarioEdited== "null" || $PincidenciaUsuarioEdited == "NULL"){
            $PincidenciaUsuarioEdited=" Sin Registro";
        }

       // $log->LogInfo("Valor de la variable  NumEmpleadoP : " . var_export ($NumEmpleadoP, true));
       // $log->LogInfo("Valor de la variable  NumSupervisorP : " . var_export ($NumSupervisorP, true));
      $mail = new PHPMailer;

        $mail->IsSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.office365.com';                 // Specify main and backup server
        $mail->Port = 587;                                    // Set the SMTP port
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'noreply@gifseguridad.com.mx';                // SMTP username
        $mail->Password = 'SomverYhuU1@';                 // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

        $mail->From = 'noreply@gifseguridad.com.mx';
        $mail->FromName = 'Ventas';

        //$mail->AddAddress('lourdes.herrera@gifseguridad.com.mx', 'Lourdes Herrera');  
        //$mail->AddAddress('contrataciones@gifseguridad.com.mx', 'contrataciones');  
        //$mail->AddAddress('abril.sanroman@gifseguridad.com.mx','Abril San Roman');  
        $mail->AddAddress('roberto.vences@gifseguridad.com.mx','Roberto Vences');
        // Name is optional
        $mail->IsHTML(true);                                  // Set email format to HTML
        $mail->Subject = utf8_decode('Eliminación De Una Petición De Incidencia Especial');
        $mail->Body    = utf8_decode("Se Eliminó la petición de incidencia especial del empleado : <strong>".$NumEmpleadoP."</strong> de la fecha : <strong>".$PincidenciaFecha."</strong> registrada el dia : <strong>".$PincidenciaFechaRegistro."</strong> por el usuario : <strong>".$PincidenciaUsuarioCaptura."</strong> y editada el dia :  <strong>".$PincidenciaLastEdited."</strong> por el usuario :  <strong>".$PincidenciaUsuarioEdited."</strong> confirmada por usted el dia : <strong>".$FechaConfirmacionRechazoP."</strong> y eliminada por el usuario : <strong>".$UsuarioEliminate."</strong> el dia : <strong>".$FechaBorradoSup."<br><br><br><h6> Correo generado desde sistema, favor de no contestar.</h6>");
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if(!$mail->Send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            exit;   
        }
      }
    }
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();
    }
}
else
{
    $response ["status"] = "error";
    $response ["message"] = "No se proporcionaron datos";
}
//$log->LogInfo("Valor de la variable \$response: " . var_export ($response, true));
echo json_encode ($response);

?>
