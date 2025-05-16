<?php
    session_start();
    require "conexion.php";
    require_once("../libs/logger/KLogger.php");
    $response = array("status" => "success");
     $log = new KLogger ( "ajax_obtenerTabuladoActual.log" , KLogger::DEBUG );
    // $log->LogInfo("Valor de la variable sql1 lista: " . var_export ($sql, true));  
    $datos1 = array();
    try{
        $sql1 = "SELECT * from CatalogoAjusteTabulador
                where idAjusteTabulador =(select max(idAjusteTabulador) from CatalogoAjusteTabulador)";  
        $res1 = mysqli_query($conexion, $sql1);
        while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
            $datos1[] = $reg1;
        }
        $response["datos1"]= $datos1;
        $log->LogInfo("Valor de la variable sql1 response: " . var_export ($response, true));  
    } 
    catch( Exception $e )
    {
        $response["status"]="error";
        $response["error"]="No se puedo datos de cliente";
    }
echo json_encode($response);

?>