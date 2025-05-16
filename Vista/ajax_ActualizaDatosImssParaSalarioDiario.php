<?php
    session_start();
    require "conexion.php"; 
    require_once("../libs/logger/KLogger.php");
     // $log = new KLogger ( "ajax_ActualizaDatosImssParaSalarioDiario.log" , KLogger::DEBUG ); 
     // $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true)); 
    $response = array("status" => "success");
    $salarioDiari=$_POST["salarioDiari"];
    $numeroEmpleadoEntidad=$_POST["numeroEmpleadoEntidad"];
    $numeroEmpleadoConsecutivo=$_POST["numeroEmpleadoConsecutivo"]; 
    $numeroEmpleadoTipo=$_POST["numeroEmpleadoTipo"];
    $origen=$_POST["origen"];
    $movimientoTXT=$_POST["movimientoTXT"];
    $usuario = $_SESSION ["userLog"]["usuario"];
    try{
        $sql = "UPDATE datosimss 
                SET salarioDiario='$salarioDiari',empleadoEstatusImss='1',lastEditedImss=now(),lastUserEdited='$usuario',origenSalarioDiario='$origen',idTxtImssDatosImss='$movimientoTXT'
                WHERE empladoEntidadImss='$numeroEmpleadoEntidad'
                AND empleadoConsecutivoImss='$numeroEmpleadoConsecutivo'
                AND empleadoCategoriaImss='$numeroEmpleadoTipo'";  
        $res = mysqli_query($conexion, $sql);  
        if ($res !== true) {
            $response["status"] = "error";
            $response["message"]='error al actualizar petición';
            return;
        }else{
            $response["message"]='Se actualizó correctamente la petición';
        }
    } 
    catch( Exception $e )
    {
        $response["status"]="error";
        $response["message"]="No se registro el historico de salario diario para imss";
    }
    echo json_encode($response);
?>