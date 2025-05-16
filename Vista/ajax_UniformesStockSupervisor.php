<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajaxUniformesStockSupervisor.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de variable de SESSION" . var_export ($_SESSION, true));
$Nosupervisor= $_SESSION["userLog"]["empleadoId"];
$StockUnido = array();
$cantidadtotalUnif=0;

try{
    $empleadoidd = explode("-", $Nosupervisor);
    $empleadoEntidad    =$empleadoidd[0];
    $empleadoConsecutivo=$empleadoidd[1];
    $empleadoCategoria  =$empleadoidd[2];

    $stock= $negocio -> stockSupervisor($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria);
    $total=count($stock);

if ($total==0) {
    $response["status"]="error";
    $response["error"] ="No cuenta con uniformes en stock para asignar";
}else{
    for($i=0; $i < count($stock); $i++){ 
        $cantidadTotalUniforme= $stock[$i]["cantidadUniformeSup"];
        $tipoUniforme= $stock[$i]["idTipoMercancia"];

        if($tipoUniforme==5 && $cantidadTotalUniforme==2) {
            $costocompleto = $stock[$i]["costoUniformeACTUALIZADO"];
            $costoMitad= ($costocompleto)/(2);
            $StockUnido[$cantidadtotalUnif]["costoUniforme"]  =$costoMitad;
          }else{
                $StockUnido[$cantidadtotalUnif]["costoUniforme"] = $stock[$i]["costoUniformeACTUALIZADO"];
               }
        $StockUnido[$cantidadtotalUnif]["codigoUniforme"] =$stock[$i]["codigoUniforme"];
        $StockUnido[$cantidadtotalUnif]["idTipoMercancia"]=$stock[$i]["idTipoMercancia"];
        $StockUnido[$cantidadtotalUnif]["descUniforme"]   =$stock[$i]["descUniforme"];
        $StockUnido[$cantidadtotalUnif]["idUniforme"]     =$stock[$i]["idUniforme"];
        $StockUnido[$cantidadtotalUnif]["fechaAsignacionASup"]=$stock[$i]["fechaAsignacionASup"];
        $StockUnido[$cantidadtotalUnif]["idAsignacionUniformeASupervisor"]=$stock[$i]["idAsignacionUniformeASupervisor"];
        $cantidadtotalUnif++;

        if($cantidadTotalUniforme==2){
            if($tipoUniforme==5) {
            $costocompleto = $stock[$i]["costoUniformeACTUALIZADO"];
            $costoMitad= ($costocompleto)/(2);
            $StockUnido[$cantidadtotalUnif]["costoUniforme"]  =$costoMitad;
          }else{
                $StockUnido[$cantidadtotalUnif]["costoUniforme"]  = $stock[$i]["costoUniformeACTUALIZADO"];
               }
           $StockUnido[$cantidadtotalUnif]["codigoUniforme"] =$stock[$i]["codigoUniforme"];
           $StockUnido[$cantidadtotalUnif]["idTipoMercancia"]=$stock[$i]["idTipoMercancia"];
           $StockUnido[$cantidadtotalUnif]["descUniforme"]   =$stock[$i]["descUniforme"];
           $StockUnido[$cantidadtotalUnif]["idUniforme"]     =$stock[$i]["idUniforme"];
           $StockUnido[$cantidadtotalUnif]["fechaAsignacionASup"]=$stock[$i]["fechaAsignacionASup"];
           $StockUnido[$cantidadtotalUnif]["idAsignacionUniformeASupervisor"]=$stock[$i]["idAsignacionUniformeASupervisor"];
           $cantidadtotalUnif++;
        }
      }
    }
    //$log->LogInfo("Valor de variable de StockUnido" . var_export ($StockUnido, true));
    $response["stock"]= $StockUnido;
   }catch( Exception $e ){
		$response["status"]="error";
		$response["error"] ="No se puedo obtener stock";
		}

echo json_encode($response);

?>