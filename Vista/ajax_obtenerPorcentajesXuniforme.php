<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
$response = array("status" => "success");
// $log = new KLogger ( "ajaxPorcentajesXUniforme.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de variable coberturaEMP" . var_export ($coberturaEMP, true));
$tipoRecepcion=getValueFromPost("tipoRecepcionTexto");
$idUniforme   =getValueFromPost("idUniforme");
$cobertura    =getValueFromPost("cobertura");
$costo        =getValueFromPost("costoUniforme");

try{
    if($cobertura>=0) {
       $rangoCobertura= $negocio -> obtenerIDrangoCobertura($cobertura);
       $idrango=$rangoCobertura[0]["idRango"];
    }else{
        $idrango=1;
    }
    $columnaAConsultar="porcentaje".$tipoRecepcion."rango".$idrango;

        $porcentajes= $negocio -> obtenerPorcentajesXUniformeyTipoRecepcion($columnaAConsultar,$idUniforme);
        $porcentajeUniforme=$porcentajes[0]["porcentajeCorrespondiente"];
        $response["porcentaje"] = $porcentajeUniforme;
        $response["montoCobro"] = round(($costo/100)*$porcentajeUniforme,2);

        for($i=1; $i < 7; $i++) { //hasta que sea menor de 7 ya que solo son 6 rangos y se necesita saber el total del porcentaje de cada rango

            $columnaAConsultar="porcentaje".$tipoRecepcion."rango".$i;
            $porcentajes= $negocio -> obtenerPorcentajesXUniformeyTipoRecepcion($columnaAConsultar,$idUniforme);
            $porciento=$porcentajes[0]["porcentajeCorrespondiente"];
            if($porciento=='null' || $porciento=='NULL' || $porciento=='') {
               $response[$i]["porcentaje"]='0';
            }else{
               $response[$i]["porcentaje"]=$porcentajes[0]["porcentajeCorrespondiente"];
            }
        }
}catch(Exception $e ){
   	 $response["status"]="error";
	    $response["error"]="No se puede obtener Porcentaje por uniforme";
	   }
echo json_encode($response);
?>