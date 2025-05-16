<?php
    session_start();
    require "conexion.php";
    require_once("../libs/logger/KLogger.php");
    //$log = new KLogger ( "ajax_ActualizaEmpleadoEspejo.log" , KLogger::DEBUG );
    //$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true)); 
    $response = array("status" => "success");
    $usuario=$_POST["usuario"];
    $NumEmpEspejo=$_POST["NumEmpEspejo"];
    try{

        $sql = "UPDATE usuarios 
                SET NumeroEspejo='$NumEmpEspejo'
                WHERE usuario='$usuario'";  
                //$log->LogInfo("Valor de la variable sql1 sql: " . var_export ($sql, true));   
        $res = mysqli_query($conexion, $sql);  
        if ($res !== true) {
            $response["status"] = "error";
            $response["message"]='error al actualizar petición';
            return;
        }else{
            //se actualiza asistencia
            $response["message"]='Se actualizó correctamente la petición';
        }
            
        } 
    catch( Exception $e )
    {
        $response["status"]="error";
        $response["message"]="No se registro el empleado espejo";
    }
    echo json_encode($response);

?>