<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$negocio = new Negocio ();
$response = array ();
verificarInicioSesion ($negocio);
if (!empty ($_POST)){
// $log = new KLogger ( "ajaxRegistroDatosPersonales.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable poos: " . var_export ($_POST, true));
    $usuario = $_SESSION ["userLog"]["usuario"];

    $datoPersonal = array (
    "empleadoEntidadPersonal" =>getValueFromPost("numeroEmpleadoEntidad"),
    "empleadoConsecutivoPersonal" => getValueFromPost("numeroEmpleadoConsecutivo"),
    "empleadoCategoriaPersonal" => getValueFromPost("numeroEmpleadoTipo"),
    "fechaNacimiento" => getValueFromPost("txtFechaNacimiento"),
    "paisNacimientoId" => getValueFromPost("selectPaisNacimiento"),
    "entidadNacimientoId" => getValueFromPost("selectEntidadNacimiento"),
    "municipioNacimientoId" => getValueFromPost("selectMunicipioNac"),
    "curpEmpleado" => strtoupper(getValueFromPost("txtCurp")),
    "rfcEmpleado" => strtoupper(getValueFromPost("txtRfc")),
    "estadoCivilId" =>getValueFromPost("selectEstadoCivil"),
    "gradoEstudiosId" => getValueFromPost("selectGradoEstudios"),
     "tipoSangreId" => getValueFromPost("selectTipoSangre"),
     "oficioId" => getValueFromPost("selectOficio"),
     "estatusCartillaId" => getValueFromPost("estatusCartilla"),
     "numeroCartilla" => getValueFromPost("txtNumeroCartilla"),
     "edad" => getValueFromPost("edadDP"),
     "usuarioCapturaDatoPersonal" => $usuario,
    );
    // $log->LogInfo("Valor de la variable \$datoPersonal: " . var_export ($datoPersonal, true));
    try{
        $negocio -> negocio_registroDatosPersonalesEmpleado($datoPersonal);
        $response ["status"] = "success";
        $response ["message"] = "Empleado registrado éxitosamente";
    }catch (Exception $e){
        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();
    }
}else{
    $response ["status"] = "error";
    $response ["message"] = "No se proporcionaron datos";
}
echo json_encode ($response);
?>