<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("../libs/phpmailer/class.phpmailer.php");
require_once ("Helpers.php");

$negocio = new Negocio ();

$response = array ();

verificarInicioSesion ($negocio);

$response = array ();
$response ["status"] = "success";
//$log = new KLogger ( "ajaxObtenerPlantillaIncremento.log" , KLogger::DEBUG );
$action = isset ($_POST ["action"]) ? $_POST ["action"] : "";
$servicioPlantillaId = isset ($_POST ["servicioPlantillaId"]) ? $_POST ["servicioPlantillaId"] : "";
//$log->LogInfo("Valor de variable _POST" . var_export ($_POST, true));

if ($action == "consultar" && intval($servicioPlantillaId) > 0)
{
    $datosconsulta = array();
    $plantillaservicio = $negocio -> getServicioPlantillaById ($servicioPlantillaId);
    //$log->LogInfo("Valor de variable plantillaservicio1" . var_export ($plantillaservicio, true));

    $plantillaServicioDescripcion = $plantillaservicio ["descripcionPuesto"] . " de " . 
        $plantillaservicio ["descripcionTurno"];        

    $plantillaServicioFactorCrecimiento = $plantillaservicio ["factorcrecimiento"];
    $plantillaPuntoServicio=$plantillaservicio["puntoServicio"];
    $turnosPorDiaActual = $plantillaservicio ["turnosPorDia"];

    $response ["turnosPorDiaActual"] = $turnosPorDiaActual;
    $response ["CantidadDeTurnos"] = $plantillaServicioFactorCrecimiento;
    $response ["datos"] = $plantillaservicio;
    $response ["message"] = "Incrementar la plantilla " . $plantillaServicioDescripcion . " en " . $plantillaServicioFactorCrecimiento . " elementos. ¿Desea continuar?";


}
else if ($action == "incrementar" && intval($servicioPlantillaId) > 0)
{
    $DiaLunesC = $_POST['DiaLunesC'];
    $NocheLunesC = $_POST['NocheLunesC'];
    $DiaMartesC = $_POST['DiaMartesC'];
    $NochesMartesC = $_POST['NochesMartesC'];
    $DiaMiercolesC = $_POST['DiaMiercolesC'];
    $NocheMiercolesC = $_POST['NocheMiercolesC'];
    $DiaJuevesC = $_POST['DiaJuevesC'];
    $NocheJuevesC = $_POST['NocheJuevesC'];
    $NocheViernesC = $_POST['NocheViernesC'];
    $DiaViernesC = $_POST['DiaViernesC'];
    $NocheSabadoC = $_POST['NocheSabadoC'];
    $DiaSabadoC = $_POST['DiaSabadoC'];
    $DiaDomingoC = $_POST['DiaDomingoC'];
    $NocheDomingoC = $_POST['NocheDomingoC'];
    
    $plantillaservicio = $negocio -> getServicioPlantillaById ($servicioPlantillaId);
   // $log->LogInfo("Valor de variable plantillaservicio2" . var_export ($plantillaservicio, true));
    $plantillaServicioDescripcion = $plantillaservicio ["descripcionPuesto"] . " de " . 
        $plantillaservicio ["descripcionTurno"];

    $plantillaServicioFactorCrecimiento = $plantillaservicio ["factorcrecimiento"];
    $plantillaPuntoServicio=$plantillaservicio["puntoServicio"];


    if ($plantillaservicio ["numeroElementos"] >= 0)
    {
        $datosPlantilla = array ();

        if($plantillaservicio ["LunesTurnoDia"] == null || $plantillaservicio ["LunesTurnoDia"] == "null" || $plantillaservicio ["LunesTurnoDia"] == NULL || $plantillaservicio ["LunesTurnoDia"] == "NULL" || $plantillaservicio ["LunesTurnoDia"] == ""){  $LunesDia = "";  }
        else{  $LunesDia = $plantillaservicio ["LunesTurnoDia"] + $DiaLunesC;  }

        if($plantillaservicio ["LunesTurnoNoche"] == null || $plantillaservicio ["LunesTurnoNoche"] == "null" || $plantillaservicio ["LunesTurnoNoche"] == NULL || $plantillaservicio ["LunesTurnoNoche"] == "NULL" || $plantillaservicio ["LunesTurnoNoche"] == ""){  $LunesNoche = "";  }
        else{  $LunesNoche = $plantillaservicio ["LunesTurnoNoche"] + $NocheLunesC;  }

        if($plantillaservicio ["MartesTurnoDia"] == null || $plantillaservicio ["MartesTurnoDia"] == "null" || $plantillaservicio ["MartesTurnoDia"] == NULL || $plantillaservicio ["MartesTurnoDia"] == "NULL" || $plantillaservicio ["MartesTurnoDia"] == ""){  $MartesDia = "";  }
        else{  $MartesDia = $plantillaservicio ["MartesTurnoDia"] + $DiaMartesC;  }

        if($plantillaservicio ["MartesTurnoNoche"] == null || $plantillaservicio ["MartesTurnoNoche"] == "null" || $plantillaservicio ["MartesTurnoNoche"] == NULL || $plantillaservicio ["MartesTurnoNoche"] == "NULL" || $plantillaservicio ["MartesTurnoNoche"] == ""){  $MartesNoche = "";  }
        else{  $MartesNoche = $plantillaservicio ["MartesTurnoNoche"] + $NochesMartesC;  }

        if($plantillaservicio ["MiercolesTurnoDia"] == null || $plantillaservicio ["MiercolesTurnoDia"] == "null" || $plantillaservicio ["MiercolesTurnoDia"] == NULL || $plantillaservicio ["MiercolesTurnoDia"] == "NULL" || $plantillaservicio ["MiercolesTurnoDia"] == ""){  $MiercolesDia = "";  }
        else{  $MiercolesDia = $plantillaservicio ["MiercolesTurnoDia"] + $DiaMiercolesC;  }

        if($plantillaservicio ["MiercolesTurnoNoche"] == null || $plantillaservicio ["MiercolesTurnoNoche"] == "null" || $plantillaservicio ["MiercolesTurnoNoche"] == NULL || $plantillaservicio ["MiercolesTurnoNoche"] == "NULL" || $plantillaservicio ["MiercolesTurnoNoche"] == ""){  $MiercolesNoche = "";  }
        else{  $MiercolesNoche = $plantillaservicio ["MiercolesTurnoNoche"] + $NocheMiercolesC;  }

        if($plantillaservicio ["JuevesTurnoDia"] == null || $plantillaservicio ["JuevesTurnoDia"] == "null" || $plantillaservicio ["JuevesTurnoDia"] == NULL || $plantillaservicio ["JuevesTurnoDia"] == "NULL" || $plantillaservicio ["JuevesTurnoDia"] == ""){  $JuevesDia = "";  }
        else{  $JuevesDia = $plantillaservicio ["JuevesTurnoDia"] + $DiaJuevesC;  }

        if($plantillaservicio ["JuevesTurnoNoche"] == null || $plantillaservicio ["JuevesTurnoNoche"] == "null" || $plantillaservicio ["JuevesTurnoNoche"] == NULL || $plantillaservicio ["JuevesTurnoNoche"] == "NULL" || $plantillaservicio ["JuevesTurnoNoche"] == ""){  $JuevesNoche = "";  }
        else{  $JuevesNoche = $plantillaservicio ["JuevesTurnoNoche"] + $NocheJuevesC;  }

        if($plantillaservicio ["ViernesTurnoNoche"] == null || $plantillaservicio ["ViernesTurnoNoche"] == "null" || $plantillaservicio ["ViernesTurnoNoche"] == NULL || $plantillaservicio ["ViernesTurnoNoche"] == "NULL" || $plantillaservicio ["ViernesTurnoNoche"] == ""){  $ViernesNoche = "";  }
        else{  $ViernesNoche = $plantillaservicio ["ViernesTurnoNoche"] + $NocheViernesC;  }

        if($plantillaservicio ["ViernesTurnoDia"] == null || $plantillaservicio ["ViernesTurnoDia"] == "null" || $plantillaservicio ["ViernesTurnoDia"] == NULL || $plantillaservicio ["ViernesTurnoDia"] == "NULL" || $plantillaservicio ["ViernesTurnoDia"] == ""){  $VienesDia = "";  }
        else{  $VienesDia = $plantillaservicio ["ViernesTurnoDia"] + $DiaViernesC;  }

        if($plantillaservicio ["SabadoTurnoNoche"] == null || $plantillaservicio ["SabadoTurnoNoche"] == "null" || $plantillaservicio ["SabadoTurnoNoche"] == NULL || $plantillaservicio ["SabadoTurnoNoche"] == "NULL" || $plantillaservicio ["SabadoTurnoNoche"] == ""){  $SabadoNoche = "";  }
        else{  $SabadoNoche = $plantillaservicio ["SabadoTurnoNoche"] + $NocheSabadoC;  }

        if($plantillaservicio ["SabadoTurnoDia"] == null || $plantillaservicio ["SabadoTurnoDia"] == "null" || $plantillaservicio ["SabadoTurnoDia"] == NULL || $plantillaservicio ["SabadoTurnoDia"] == "NULL" || $plantillaservicio ["SabadoTurnoDia"] == ""){  $SabadoDia = "";  }
        else{  $SabadoDia = $plantillaservicio ["SabadoTurnoDia"] + $DiaSabadoC;  }

        if($plantillaservicio ["DomingoTurnoDia"] == null || $plantillaservicio ["DomingoTurnoDia"] == "null" || $plantillaservicio ["DomingoTurnoDia"] == NULL || $plantillaservicio ["DomingoTurnoDia"] == "NULL" || $plantillaservicio ["DomingoTurnoDia"] == ""){  $DomingoDia = "";  }
        else{  $DomingoDia = $plantillaservicio ["DomingoTurnoDia"] + $DiaDomingoC;  }

        if($plantillaservicio ["DomingoTurnoNoche"] == null || $plantillaservicio ["DomingoTurnoNoche"] == "null" || $plantillaservicio ["DomingoTurnoNoche"] == NULL || $plantillaservicio ["DomingoTurnoNoche"] == "NULL" || $plantillaservicio ["DomingoTurnoNoche"] == ""){  $DomingoNoche = "";  }
        else{  $DomingoNoche = $plantillaservicio ["DomingoTurnoNoche"] + $NocheDomingoC;  }

        $turnosPorDia = ($plantillaservicio ["numeroElementos"] + $plantillaservicio ["factorcrecimiento"]) / $plantillaservicio["factorturnos"];
        $costoNetoFactura = $plantillaservicio ["costoNetoFactura"];

        $response ["plantillaServicio"] = $plantillaservicio;
        $response ["turnosPorDia"] = $turnosPorDia;

        $datosPlantilla ["numeroElementos"] = $plantillaservicio ["numeroElementos"] + $plantillaservicio ["factorcrecimiento"];
        $datosPlantilla ["turnosPorDia"] = $turnosPorDia;
        $datosPlantilla ["costoNetoFactura"] = $turnosPorDia * 30 * $plantillaservicio ["costoPorTurno"] * 1.16 ;
        $datosPlantilla ["servicioPlantillaId"] = $servicioPlantillaId;
        $datosPlantilla ["LunesDia"] = $LunesDia;
        $datosPlantilla ["LunesNoche"] = $LunesNoche;
        $datosPlantilla ["MartesDia"] = $MartesDia;
        $datosPlantilla ["MartesNoche"] = $MartesNoche;
        $datosPlantilla ["MiercolesDia"] = $MiercolesDia;
        $datosPlantilla ["MiercolesNoche"] = $MiercolesNoche;
        $datosPlantilla ["JuevesDia"] = $JuevesDia;
        $datosPlantilla ["JuevesNoche"] = $JuevesNoche;
        $datosPlantilla ["ViernesNoche"] = $ViernesNoche;
        $datosPlantilla ["VienesDia"] = $VienesDia;
        $datosPlantilla ["SabadoNoche"] = $SabadoNoche;
        $datosPlantilla ["SabadoDia"] = $SabadoDia;
        $datosPlantilla ["DomingoDia"] = $DomingoDia;
        $datosPlantilla ["DomingoNoche"] = $DomingoNoche;

        //$log->LogInfo("Valor de variable turnosDia1" . var_export ($turnosDia1, true));
        //$log->LogInfo("Valor de variable turnosNoche1" . var_export ($turnosNoche1, true));

        $negocio -> actualizarPlantillaAumento ($datosPlantilla);
        //$log->LogInfo("Valor de variable aa" . var_export ($aa, true));
        $response ["message"] = "La plantilla " . $plantillaServicioDescripcion . " se incremento en " . $plantillaServicioFactorCrecimiento . " elementos";

        $mail = new PHPMailer;

        $mail->IsSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                 // Specify main and backup server
        $mail->Port = 587;                                    // Set the SMTP port
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'CorporativoGifSeguridad@gmail.com';                // SMTP username
        $mail->Password = 'Corporativo_Gif_Seguridad_Privada1';                  // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

        $mail->From = 'CorporativoGifSeguridad@gmail.com';
        $mail->FromName = 'Ventas';
        
       // $mail->AddAddress('lourdes.herrera@gifseguridad.com.mx', 'Lourdes Herrera');  
        $mail->AddAddress('contrataciones@gifseguridad.com.mx', 'contrataciones');  
        $mail->AddAddress('alfredo.velasco@gifseguridad.com.mx','Alfredo Velasco');  
        //$mail->AddAddress('roberto.vences@gifseguridad.com.mx','Roberto Vences');
 


        $mail->IsHTML(true);                                  // Set email format to HTML

        $mail->Subject = utf8_decode('Incremento de plantilla');
        $mail->Body    = utf8_decode('Se registró un incremento de plantilla<br><strong> +'.$plantillaServicioFactorCrecimiento.' '.$plantillaServicioDescripcion.' en el punto de servicio '.$plantillaPuntoServicio.'</strong>');
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if(!$mail->Send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        exit;

            
        }

    }
    else
    {
        $response ["status"] = "error";
        $response ["message"] = "La plantilla " . $plantillaServicioDescripcion . " no puede incrementar. No contiene elementos suficientes.";
    }
}
else
{
    $response ["status"] = "error";
    $response ["message"] = "La petición es incorrecta. Por favor corregir los datos proporcionados.";
}


echo json_encode ($response);
?>