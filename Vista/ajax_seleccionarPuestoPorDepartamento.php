<?php
    session_start();
    require "conexion.php"; 
    require_once("../libs/logger/KLogger.php");
    // $log = new KLogger ( "ajax_seleccionarPuestoPorDepartamento.log" , KLogger::DEBUG );
    // $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));  
    $response = array("status" => "success");
    $idDepartamentoPuesto=$_POST["idDepartamentoPuesto"];
    $datos = array(); 
    $datos1 = array();
    try{
        if($idDepartamentoPuesto =="0"){
            $empleadoIdPuesto=$_POST["empleadoIdPuesto"];
            $sql1 = "SELECT * FROM relacionpuestosdepartamentos 
                    where idPuesto='$empleadoIdPuesto'";      
            $res1 = mysqli_query($conexion, $sql1);
            while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
                $datos1[] = $reg1;
            }
            $idDepartamentoPuesto = $datos1[0]["idDepartamento"];
            $response["depto"] = $idDepartamentoPuesto;
        }
        $sql = "SELECT * FROM relacionpuestosdepartamentos r
                left join catalogopuestos c on (c.idPuesto=r.idPuesto) 
                where r.idDepartamento='$idDepartamentoPuesto'
                order by descripcionPuesto";      
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
    $response["datos"] = $datos;
    
    } 
    catch( Exception $e )
    {
        $response["status"]="error";
        $response["message"]="No se obtubo los puestos por departamento";
    }
    echo json_encode($response);
?>