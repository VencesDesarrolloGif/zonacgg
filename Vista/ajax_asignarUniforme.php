<?php
session_start ();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio (); 
$response = array ();
$response ["status"] = "error";
$usuario = $_SESSION ["userLog"]["usuario"];
verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajax_asignarUniforme.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de variable _POST" . var_export ($_POST, true));
$usuarioCaptura=$_SESSION ["userLog"]["usuario"];
$numEmpAlmacen      = $_POST["numempleadoFirmaAsignacion"];//hermes
$NombreEmpAlmacen   = $_POST["NombreSolicitanteAsignacion"];//hermes
$FirmaEmpAlmacen    = $_POST["FirmaInternaAsignacion"];//hermes
$nombreGuardia      = $_POST["NombreEmpleado"];//guardia
$numeroEmpleado     = $_POST["NumeroEmpleado"];//guardia
$numeroEmpleado1    = explode('-', $numeroEmpleado);
$empleadoEntidad    = $numeroEmpleado1[0];
$empleadoConsecutivo= $numeroEmpleado1[1];
$empleadoCategoria  = $numeroEmpleado1[2];
$FirmaGuardia       = $_POST["FirmaIntenaEmpleadoQueRecibe"];//guardia
$asignacionSup      = $_POST["asignacionSupervisor"];//cambio
$numeroEmpAlmacen= $negocio -> obtenerEntidadTrabajoEmpleadoQueAsigna($numEmpAlmacen);//puedo quitarlo
$EntidadEmpleadoUSR= $numeroEmpAlmacen["nombreEntidadFederativa"];

try{
    $idorden= $negocio -> obtenerMaxId();//historico almacen
    $maxid= $idorden["idMax"]+1;//historico almacen
    $Asignaciones= $negocio -> obtenerAsignacionesTemporales($numeroEmpleado,$usuarioCaptura);//temporales
    
    for($i=0; $i < count($Asignaciones); $i++){ 
        $datosAsignacion    = $Asignaciones[$i];
        $idUniforme         = $datosAsignacion["claveUniAsignacionTMP"]; 
        $cantidadUni        = $datosAsignacion["cantidadUniformeTMP"];
        $entidadUsuario     = $datosAsignacion["entidadUniformeAsigT"];
        $tipoUniforme       = $datosAsignacion["TipoUniAsignacionTMP"];
        $codigoUnif         = $datosAsignacion["codigoUniforme"];
        $costoIngresado1    = $datosAsignacion["montoDeudaAUT"];
        $sucursalUnifAsigTMP= $datosAsignacion["sucursalUnifAsigTMP"];
        
        $pos = strpos($codigoUnif, '-');
        if($pos !== false){
           $talla=substr($codigoUnif, $pos+1,strlen($codigoUnif)-1);
          }else{
                $talla='N/A';
               }
        $descripcionTipoUnif= $datosAsignacion["descripcionTipo"];
        $codigoUnif         = $datosAsignacion["codigoUniforme"];
        $negocio -> asignarUniforme($nombreGuardia,$empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria,$idUniforme,$cantidadUni,$usuarioCaptura,$entidadUsuario,$maxid,$tipoUniforme,$codigoUnif,$talla,$descripcionTipoUnif, $EntidadEmpleadoUSR,$numEmpAlmacen,$FirmaEmpAlmacen,$FirmaGuardia,$NombreEmpAlmacen,$costoIngresado1,$i,$asignacionSup,$sucursalUnifAsigTMP);  //cambio   
       }
    $response ["status"] = "success";
    $response ["message"] = "El uniforme fue asignado con éxito ";
   }catch(Exception $e){
          $response ["status"] = "error";
          $response ["message"] =  $e -> getMessage ();
         }    
echo json_encode ($response);
?>
