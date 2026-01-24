<?php
    session_start ();
    require_once ("../../libs/logger/KLogger.php");
    require "../conexion.php";
    $log = new KLogger ( "ajax_ActualizarYCargarFotoEmpleado.log" , KLogger::DEBUG );
    $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
    $response= array();
    $NumeroFirma        = $_POST["NumeroFirma"];
    $ContraseniaFirma   = $_POST["ContraseniaFirma"];
    $numeroEmp          = $_POST["numeroEmp"];
    $usuarioCaptura     = $_SESSION ["userLog"]["usuario"];
    $NumeroExplde       = explode("-", $numeroEmp);

    $sql1 = "UPDATE datosimss set idRechazado='2',UsuarioConfirmacion='$usuarioCaptura',NumeroFirmaConfirmacion='$NumeroFirma',ContraseniaFirmaConfirmacion='$ContraseniaFirma',FechaConfirmacion=NOW()
            where empladoEntidadImss='$NumeroExplde[0]' 
            and empleadoConsecutivoImss='$NumeroExplde[1]' 
            and empleadoCategoriaImss='$NumeroExplde[2]'";
    $log->LogInfo("Ejecutando consulta  sql1: " . $sql1);
    $res1 = mysqli_query($conexion, $sql1);  
    if ($res1 !== true) {
        $response["status"] = "error";
        $response["message"]='Ocurrio Un Error Al Actualizar Imss.';
        return;
    }else{
        $response ["status"] = "success";
        $response ["message"] = "Empleado actualizado éxitosamente";
    }
echo json_encode($response);
?> 