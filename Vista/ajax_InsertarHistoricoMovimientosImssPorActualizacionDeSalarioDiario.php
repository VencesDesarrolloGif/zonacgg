<?php
    session_start();
    require "conexion.php"; 
    require_once("../libs/logger/KLogger.php");
     // $log = new KLogger ( "ajax_InsertarHistoricoMovimientosImssPorActualizacionDeSalarioDiario.log" , KLogger::DEBUG ); 
     // $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true)); 
    $response = array("status" => "success");
    $numeroEmpleadoEntidad=$_POST["numeroEmpleadoEntidad"]; 
    $numeroEmpleadoConsecutivo=$_POST["numeroEmpleadoConsecutivo"];
    $numeroEmpleadoTipo=$_POST["numeroEmpleadoTipo"];
    $usuario = $_SESSION ["userLog"]["usuario"];
    $datos = array();
    $tipoMovimiento='7';//Es 7 ya qeu en el catalogo_movimientosimss se enexo SBC oara identificar el movimiento de acrtualizacion de salario diario
    try{
        $sql = "SELECT registroPatronal FROM datosimss
                where empladoEntidadImss='$numeroEmpleadoEntidad'
                and empleadoConsecutivoImss='$numeroEmpleadoConsecutivo'
                and empleadoCategoriaImss='$numeroEmpleadoTipo'";      
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
        $RegistroPatronal = $datos[0]["registroPatronal"]; 
        // $log->LogInfo("Valor de la variable RegistroPatronal: " . var_export ($RegistroPatronal, true));

        $sql1 = "INSERT INTO historicomovimientosimss(empEntidadMovimiento, EmpConsecutivoMovimiento, empCategoriaMovimiento, tipoMovimiento, fechaMovimiento,usuarioEdicion,registroMovimiento,estatusmov) values ('$numeroEmpleadoEntidad','$numeroEmpleadoConsecutivo','$numeroEmpleadoTipo','$tipoMovimiento',now(),'$usuario','$RegistroPatronal',0)"; 
        // $log->LogInfo("Valor de la variable sql1: " . var_export ($sql1, true)); 
        $res1 = mysqli_query($conexion, $sql1);  
        if ($res1 !== true) {
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