<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio (); 

$response = array ();
$response ["status"] = "error";

verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajax_RegistrarFirmaElectronica.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable poos: " . var_export ($_POST, true));
$usuarioRegistroFirma = $_SESSION ["userLog"]["usuario"];
$NumeroEmpleado = getValueFromPost("impNumeroEmpleadoFirma");
$empleadofirma = explode("-", $NumeroEmpleado);
$idEntidadEmpleadoFirma=$empleadofirma[0];
$consecutivoEmpleadoFirma=$empleadofirma[1];
$tipoResponsableEmpleadoFirma=$empleadofirma[2];
$selPreguntaUnoFirma = getValueFromPost("selPreguntaUnoFirma");
$impPrimerPregunta = getValueFromPost("impPrimerPregunta");
$selPreguntaDosFirma = getValueFromPost("selPreguntaDosFirma");
$impSegundaPregunta = getValueFromPost("impSegundaPregunta");
$selPreguntaTresFirma = getValueFromPost("selPreguntaTresFirma");
$impTerceraPregunta = getValueFromPost("impTerceraPregunta");
$ContraseniaFirma1 = getValueFromPost("ContraseniaFirma");
$ContraseniaFirma = md5($ContraseniaFirma1);

$RevisionSiExisteFirma = $negocio -> RevisionRegistroPrevioDeFirma($idEntidadEmpleadoFirma,$consecutivoEmpleadoFirma,$tipoResponsableEmpleadoFirma);
if($RevisionSiExisteFirma[0]["REgistrosPreviosFirma"]!="0"){
    $response ["status"] = "error";
    $response ["message"] = "Este Empleado Ya Cuenta Con Un Registro De Firma Anterior Si No Recuerda La Contraseña Ingrese En La Pestaña De 'Recuperacion De Contraeña'";
}else{
    $negocio -> RegistrarFirmaElectronica($idEntidadEmpleadoFirma,$consecutivoEmpleadoFirma,$tipoResponsableEmpleadoFirma,$selPreguntaUnoFirma,$impPrimerPregunta,$selPreguntaDosFirma,$impSegundaPregunta,$selPreguntaTresFirma,$impTerceraPregunta,$ContraseniaFirma,$usuarioRegistroFirma);
    $response ["status"] = "success";
    $response ["message"] = "Firma Registrada Exitosamente";
}
echo json_encode ($response);

?> 
