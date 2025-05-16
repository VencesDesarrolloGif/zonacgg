<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
//$log = new KLogger ( "ajaxInsertAsigUniTMP.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de Unifor" . var_export ($Unifor, true));
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array ();
$response ["status"] = "error";
$numeroEmpleado = $_POST["numeroEmpleado"];
$numeroEmpleado=getValueFromPost("numeroEmpleado");
$empleadoidd = explode("-", $numeroEmpleado);
$empleadoEntidad=$empleadoidd[0];
$empleadoConsecutivo=$empleadoidd[1];
$empleadoCategoria=$empleadoidd[2];
$idUniforme = $_POST["idTipoUniforme"];
$cantidadUni = $_POST["cantidadElegida"];
$usuarioCaptura=$_SESSION ["userLog"]["usuario"];
$entidadUsuario = $_POST["entidadUsuario"];
$idTipoMercan = $_POST["idTipoMercan"];
$costoIngresado1 = $_POST["costoIngresado1"];
$sucursalSeleccionada = $_POST["sucursalSeleccionada"];

try {
     $insertUni = $negocio->InsertTMP($empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria,$idUniforme,$cantidadUni,$usuarioCaptura,$entidadUsuario,$idTipoMercan,$costoIngresado1,$sucursalSeleccionada);
     $Unifor = $negocio->ConsultaUniformesAsig($usuarioCaptura);
     for($i=0; $i < count($Unifor); $i++){ 

      $entidadAsig = $Unifor[$i]["entidadUniformeAsigT"];
      $idUniformeComp = $Unifor[$i]["claveUniAsignacionTMP"];
      $peticionesUnif= $Unifor[$i]["suma"];
      $sucursalUnifAsigTMP= $Unifor[$i]["sucursalUnifAsigTMP"];
      $cantidadStock = $negocio->obtenerCantidadStock($idUniformeComp, $entidadAsig,$sucursalSeleccionada);
      $sumaStock = $cantidadStock[0]["cantidadUniformes"];

      if ($peticionesUnif > $sumaStock) {
          $response["status"] = "error";
          $response["error"]  = "No hay suficientes uniformes en stock";
          $eliminar = $negocio->EliminarUltimoReg($usuarioCaptura);
         }else{
            $response ["status"] = "success";
            $response ["message"] = "éxito ";
         }
     }
}catch(Exception $e){
    $response["status"] = "error";
    $response["error"]  = "No Se Puedo insertar uniformes Del Usuario";
}
echo json_encode($response);
?>