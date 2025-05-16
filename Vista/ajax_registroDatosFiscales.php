<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$negocio = new Negocio ();
$response = array ();
verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajax_registroDatosFiscales.log" , KLogger::DEBUG );
if (!empty ($_POST))
{
    $usuario = $_SESSION ["userLog"]["usuario"];
    $caso = getValueFromPost("caso");
    //$log->LogInfo("Valor de la variable caso: " . var_export ($caso, true));

    $datosFiscales= array (
    "FolioPreseleccionDatosFiscales"=>getValueFromPost("FolioPreseleccionDatosFiscales"),
    "CodigoPostalDatosFiscales"=>getValueFromPost("CodigoPostalDatosFiscales"),
    "EntidadDatosFiscales"=>getValueFromPost("EntidadDatosFiscales"),
    "MunicipioDatosFiscales"=>getValueFromPost("MunicipioDatosFiscales"),
    "LocalidadDatosFiscales"=>getValueFromPost("LocalidadDatosFiscales"),
    "ColoniaDatosFiscales"=>getValueFromPost("ColoniaDatosFiscales"),
    "VialidadDatosFiscales"=>getValueFromPost("VialidadDatosFiscales"),
    "TipoVidalidadDatosFiscales"=>getValueFromPost("TipoVidalidadDatosFiscales"),
    "NumExternoDatosFiscales"=>getValueFromPost("NumExternoDatosFiscales"),
    "NumInternoDatosFiscales"=>getValueFromPost("NumInternoDatosFiscales"), 
    "EstadoDoicilioDatosFiscales"=>getValueFromPost("EstadoDoicilioDatosFiscales"),
    "entidadFederativaId"=>getValueFromPost("entidadFederativaId"),
    "empleadoConsecutivoId"=>getValueFromPost("empleadoConsecutivoId"),
    "usuario"=>$usuario,
    "empleadoCategoriaId"=>getValueFromPost("empleadoCategoriaId")
    );

    $datosEmpleado= array (
    "entidadFederativa"=>getValueFromPost("entidadFederativaId"),
    "empleadoConsecutivo"=>getValueFromPost("empleadoConsecutivoId"),
    "empleadoCategoria"=>getValueFromPost("empleadoCategoriaId")
    );

    try
    {
        $datos= $negocio -> negocio_ObtenerEmpleadoYaHaSidoRegistradoDatosFiscales($datosEmpleado);
        //$log->LogInfo("Valor de la variable datos: " . var_export ($datos, true));

        $existe = $datos[0]["LargoEmpleado"];
        if($existe=="0"){
            $negocio -> negocio_insertaDatosFiscales($datosFiscales);
            $response ["status"] = "success";
            $response ["message"] = "Datos Fiscales Del Empleado Registrados Éxitosamente";
        }else{
            if($caso=="Edicion"){
                $negocio -> negocio_ActualizarDatosFiscales($datosFiscales);
                $response ["status"] = "success";
                $response ["message"] = "Datos Fiscales Del Empleado Actualizados Éxitosamente";
            }else{
                $response ["status"] = "error";
                $response ["message"] = "Los Datos Del Empleado Ya Han Sido Registrados Si Quiere Modificar Vaya Al Modulo De: Consulta Empleado";
            }
        } 
    } 
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();
    }
}else{
    $response ["status"] = "error";
    $response ["message"] = "No se proporcionaron datos";
}
echo json_encode ($response);
?>