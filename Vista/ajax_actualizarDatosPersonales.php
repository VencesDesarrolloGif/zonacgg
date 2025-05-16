<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
$response = array ();
verificarInicioSesion($negocio);
//$log = new KLogger ( "ajaxActualizarDatosPersonales.log" , KLogger::DEBUG );
$usuario = $_SESSION ["userLog"]["usuario"];

$empleado = array (
	"empleadoEntidadPersonal" =>getValueFromPost("numeroEmpleadoEntidadEdited"),
    "empleadoConsecutivoPersonal" => getValueFromPost("numeroEmpleadoConsecutivoEdited"),
    "empleadoCategoriaPersonal" => getValueFromPost("numeroEmpleadoTipoEdited"),
    "fechaNacimiento" => getValueFromPost("txtFechaNacimientoEdited"),
    "paisNacimientoId" => getValueFromPost("selectPaisNacimiento"),
    "entidadNacimientoId" => getValueFromPost("selectEntidadNacimientoEdited"),
    "municipioNacimientoId" => getValueFromPost("selectMunicipioNacEdited"),
    "curpEmpleado" => strtoupper(getValueFromPost("txtCurpEdited")),
    "rfcEmpleado" => strtoupper(getValueFromPost("txtRfcEdited")),
    "estadoCivilId" =>getValueFromPost("selectEstadoCivilEdited"),
    "gradoEstudiosId" => getValueFromPost("selectGradoEstudiosEdited"),
     "tipoSangreId" => getValueFromPost("selectTipoSangreEdited"),
     "oficioId" => getValueFromPost("selectOficioEdited"),
     "estatusCartillaId" => getValueFromPost("estatusCartillaEdited"),
     "numeroCartilla" => strtoupper(getValueFromPost("txtNumeroCartillaEdited")),
     "edad" => getValueFromPost("txtEdadCP"),
     "usuarioCapturaDatoPersonal" => $usuario,
   	);
    try{
        $negocio -> negocio_editarDatosPersonales($empleado);
        $response ["status"] = "success";
        $response ["message"] = "Datos Personales Editados";
    }catch (Exception $e){
        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();
    }
echo json_encode ($response);
?>