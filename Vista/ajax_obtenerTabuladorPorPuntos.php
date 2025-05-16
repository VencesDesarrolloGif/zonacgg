<?php
    session_start();
    require "conexion.php";
    require_once("../libs/logger/KLogger.php");
    $response = array("status" => "success");
    // $log = new KLogger ( "ajax_obtenerTabuladorPorPuntos.log" , KLogger::DEBUG );
    // $log->LogInfo("Valor de la variable sql1 lista: " . var_export ($sql, true));  
    $puntoServicio=$_POST["idPuntoServicioTabulador"];
    $idtipoTurnoSD=$_POST["idtipoTurnoSD"];
    $idPuestoSD=$_POST["idPuestoSD"];
    $datos = array();
    $datos1 = array();
    try{
        $sql = "SELECT * from tabulador
                where puntoServicio='$puntoServicio'
                and rolId='$idtipoTurnoSD'
                and puestoId='$idPuestoSD'";      
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
        $sql1 = "SELECT * from CatalogoAjusteTabulador
                where idAjusteTabulador =(select max(idAjusteTabulador) from CatalogoAjusteTabulador)";  
        $res1 = mysqli_query($conexion, $sql1);
        while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
            $datos1[] = $reg1;
        }
        $response["datos"]= $datos;
        $response["datos1"]= $datos1;
    } 
    catch( Exception $e )
    {
        $response["status"]="error";
        $response["error"]="No se puedo datos de cliente";
    }
echo json_encode($response);

?>