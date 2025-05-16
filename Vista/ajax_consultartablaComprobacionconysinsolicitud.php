<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$negocio = new Negocio ();
$response = array ();
$datossoli=array();
$usuario = $_SESSION ["userLog"]["usuario"];
$usuario1 = $_SESSION ["userLog"]["rol"];
$usuarioentidad = $_SESSION ["userLog"]["entidadFederativaUsuario"][0];
// $usuarioentidad = $_SESSION ["userLog"]["entidadFederativaUsuario"];
$caso  = $_POST['caso'];
$log = new KLogger ( "ajaxinsertarhistorico.log" , KLogger::DEBUG );
verificarInicioSesion ($negocio);
$log->LogInfo("Valor de la variable sesion: " . var_export ($_SESSION, true));
if (!empty ($_POST))
{
    try
    { 
        $datos2= $negocio->negocio_obteneridlineanegocio($usuario,$usuarioentidad);// no se modifico nada

                $idlinea= $datos2[0]["idLinea"];

        $datos1 = $negocio->negocio_obtenerlistacomprobacionesconysinsolicitud($caso,$usuarioentidad,$idlinea,$usuario1);
        for($i=0;$i<(count($datos1));$i++)
            {
                $compro=0;
                $datossoli[$i]["Estatus"]      =$datos1[$i]["Estatus"];
                $datossoli[$i]["Folio"]        =$datos1[$i]["Folio"];
                $datossoli[$i]["Fecha"]        =$datos1[$i]["Fecha"]; 
                $datossoli[$i]["Clave"]        =$datos1[$i]["Clave"]; 
                $datossoli[$i]["Beneficiario"] =$datos1[$i]["Beneficiario"]; 
                $datossoli[$i]["Concepto"]     =$datos1[$i]["Concepto"]; 
                $datossoli[$i]["Total"]        =$datos1[$i]["Total"];
                if($caso==0){
                $datossoli[$i]["Comprobar"]    ="<img href='#contenedorFinanzas' data-toggle='tab' style='cursor: pointer' src='img/confirmarImss.png' id='imgComprobar' name='imgComprobar' width='25' value='0'  onclick='comprobarComprobacionconysinsolicitud(
                                                    \"" . $datos1[$i]['Linea'] . "\",\"" . $datos1[$i]['Clave'] . "\",
                                                    \"" . $datos1[$i]['Banco'] . "\",\"" . $datos1[$i]['Cuenta'] . "\",
                                                    \"" . $datos1[$i]['Transaccion'] . "\",\"" . $datos1[$i]['Departamento'] . "\",
                                                    \"" . $datos1[$i]['SubDepartamento'] . "\",\"" . $datos1[$i]['Empresa'] . "\",
                                                    \"" . $datos1[$i]['Entidad'] . "\",\"" . $datos1[$i]['Total'] . "\",\"" . $datos1[$i]['Folio'] . "\");' ></img>";}            
                else {
                $datossoli[$i]["Comprobar"]    ="<img href='#contenedorFinanzas' data-toggle='tab' style='cursor: pointer' src='img/confirmarImss.png' id='imgComprobar' name='imgComprobar' width='25' value='0'  onclick='comprobarComprobacionconysinsolicitud(
                                                    \"" . $datos1[$i]['Linea'] . "\",\"" . $datos1[$i]['Clave'] . "\",
                                                    \"" . $compro . "\",\"" . $compro . "\",\"" . $datos1[$i]['Transaccion'] . "\",
                                                    \"" . $datos1[$i]['Departamento'] . "\",\"" . $datos1[$i]['SubDepartamento'] . "\",
                                                    \"" . $datos1[$i]['Empresa'] . "\",\"" . $datos1[$i]['Entidad'] . "\",
                                                    \"" . $datos1[$i]['Total'] . "\",\"" . $datos1[$i]['Folio'] . "\");' ></img>";}
            }
        $response ["status"] = "success";
        $response ["datos"] = $datossoli; 
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

echo json_encode ($response);
?>