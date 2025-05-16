<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
// $log = new KLogger ( "ajax_PuntosServicioGeoParaRostro.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de _POST  " . var_export ($_POST, true));
$latitud=$_POST["latitud"];
$longitud=$_POST["longitud"];
$latitudg = (float)$latitud;
$longitudg =(float)$longitud;
try {
    $ListaPuntosServicioParaGeo   = $negocio->ObtenerPuntosParaGeo();
    $CountLista = count($ListaPuntosServicioParaGeo);
//$log->LogInfo("Valor de ListaPuntosServicioParaGeo  " . var_export ($ListaPuntosServicioParaGeo, true));
    $a=0;    
    for($i=0; $i<$CountLista;$i++){
        $idpunto=$ListaPuntosServicioParaGeo[$i]["idPuntoServicio"];
        $descripcionpunto = $ListaPuntosServicioParaGeo[$i]["puntoServicio"];
        $latitud1=(float)$ListaPuntosServicioParaGeo[$i]["latitudPunto"];
        $longitud1=(float)$ListaPuntosServicioParaGeo[$i]["longitudPunto"];
        $degrees1 = rad2deg(acos((sin(deg2rad($latitudg))*sin(deg2rad($latitud1))) + (cos(deg2rad($latitudg))*cos(deg2rad($latitud1))*cos(deg2rad($longitudg-$longitud1)))));
        // Conversión de la distancia en grados a la unidad escogida (kilómetros, millas o millas naúticas)
        $distance = $degrees1 * 111.13384; // 1 grado = 111.13384 km, basándose en el diametro promedio de la Tierra (12.735 km)
        $distancia = round($distance,4);
    // $log->LogInfo("Valor de distancia  " . var_export ($distancia, true));
    // $log->LogInfo("Valor de idpunto  " . var_export ($idpunto, true));
        
        if($distancia<= "0.5000"){
            $listadistancias[$a]["idpuntos"]=$idpunto;
            $listadistancias[$a]["puntoServicio"]=$descripcionpunto;
            $a++;
        }   
    }
    if($a==0){
        $listadistancias[0]["idpuntos"]=0;
        $listadistancias[0]["puntoServicio"]="Sin Punto De Servicio Cerca";
    }

    $response["datos"] = $listadistancias;

} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No Se Obtuvieron Los Dias Disponibles";
}

echo json_encode($response);
