<?php
    session_start();
    require "conexion.php"; 
    require_once("../libs/logger/KLogger.php");
    //$log = new KLogger ( "ajax_seleccionarDepartamento.log" , KLogger::DEBUG );
    //$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));  
    $response = array("status" => "success");
    $lineaNegocio=$_POST["lineaNegocio"];
    $tipoPuesto=$_POST["tipoPuesto"];
    $datos = array(); 
    try{
        $sql = "SELECT * FROM catalogo_organigramadepartamentos
                where lineaNegocio='$lineaNegocio'
                and categoria='$tipoPuesto'
                order by descripcionDepartamento";      
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
    $response["datos"] = $datos;
    } 
    catch( Exception $e )
    {
        $response["status"]="error";
        $response["message"]="No se registro el historico de salario diario para imss";
    }
    echo json_encode($response);
?>