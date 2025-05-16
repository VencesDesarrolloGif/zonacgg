<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajaxConfirmarAsignacionSupervisor.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de variable de datastring" . var_export ($datastring, true));
//$log->LogInfo("Valor de variable de montoACobrar" . var_export ($montoACobrar, true));
$usuarioCaptura=$_SESSION ["userLog"]["usuario"];
$rolUsuario=$_SESSION ["userLog"]["rol"];
$costoIngresado1    = $_POST["montoACobrar"];
$idcheckUniforme    = $_POST["check"];
$ordenID            = $_POST["idOrden"];
$numEmpAlmacen      = $_POST["numempleadoFirmaAsignacion"];//hermes
$NombreEmpAlmacen   = $_POST["NombreSolicitanteAsignacionSup"];//hermes
$FirmaEmpAlmacen    = $_POST["FirmaInternaAsignacionSup"];//hermes
$FirmaGuardia       = $_POST["FirmaIntenaEmpleadoQueRecibeSup"];//guardia
$nombreGuardia      = $_POST["NombreEmpleado"];//guardia
$numeroEmpleado     = $_POST["NumeroEmpleado"];//guardia
$numeroEmpleado1    = explode('-', $numeroEmpleado);
$empleadoEntidad    = $numeroEmpleado1[0];
$empleadoConsecutivo= $numeroEmpleado1[1];
$empleadoCategoria  = $numeroEmpleado1[2];

$numeroEmpAlmacen= $negocio -> obtenerEntidadTrabajoEmpleadoQueAsigna($numEmpAlmacen);
$EntidadEmpleadoUSR= $numeroEmpAlmacen["nombreEntidadFederativa"];

try{
    if ($ordenID==0) {
        $idorden= $negocio -> obtenerMaxId();
        $maxid= $idorden["idMax"]+1;
    }else{
        $maxid= $ordenID;
        }
    $Asignaciones= $negocio -> obtenerUniformesElegidos($idcheckUniforme);//revisar entidad debe ser la del uniforme
//$log->LogInfo("Valor de variable de maxid" . var_export ($maxid, true));

    //for($i=0; $i < count($Asignaciones); $i++){ 
        //$datosAsignacion= $Asignaciones;
        $entidadUniforme= $Asignaciones[0]["entidadUniformeAsigSup"];
        $tipoUniforme   = $Asignaciones[0]["TipoUniAsignacionSup"];
        $idUniforme     = $Asignaciones[0]["claveUniAsignacionSup"]; 
        $cantidadUni    = $Asignaciones[0]["cantidadUniformeSup"];
        $cantidadUniINICIAL= $Asignaciones[0]["cantidadUniformeSupiNICIAL"];
        $codigoUnif     = $Asignaciones[0]["codigoUniforme"];
        $descripcionTipoUnif= $Asignaciones[0]["descripcionTipo"];
        $pos = strpos($codigoUnif, '-');
        if($pos !== false){
           $talla=substr($codigoUnif, $pos+1,strlen($codigoUnif)-1);
          }else{
                $talla='N/A';
               }
        $negocio -> asignarUniformeSupervisor($nombreGuardia,$empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria,$idUniforme,$cantidadUni,$usuarioCaptura,$entidadUniforme,$maxid,$tipoUniforme,$codigoUnif,$talla,$descripcionTipoUnif, $EntidadEmpleadoUSR,$numEmpAlmacen,$FirmaEmpAlmacen,$FirmaGuardia,$NombreEmpAlmacen,$costoIngresado1,$idcheckUniforme,$cantidadUniINICIAL,$rolUsuario);  //cambio   
       //}
    $response ["IdOrden"] = $maxid;
    $response ["status"] = "success";
    $response ["message"] = "El uniforme fue asignado con éxito ";
//$log->LogInfo("Valor de variable de response" . var_export ($response, true));

   }catch(Exception $e){
          $response ["status"] = "error";
          $response ["message"] =  $e -> getMessage ();
         }    


echo json_encode($response);

?>