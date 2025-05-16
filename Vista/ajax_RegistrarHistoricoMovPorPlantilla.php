<?php
    session_start(); 
    require "conexion.php"; 
    require_once("../libs/logger/KLogger.php");
    // $log = new KLogger ( "ajax_RegistrarHistoricoMovPorPlantilla.log" , KLogger::DEBUG );
    // $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true)); 
    $response = array("status" => "success");
    $idPlantilla=$_POST["idPlantillaSeleccionada"];
    $PuntoServicio=$_POST["PuntoServicioSeleccionado"];
    $Entidad=$_POST["EntidadEmp"];
    $Categoria=$_POST["CategoriaEmp"];
    $Tipo=$_POST["TipoEmp"];
    $TipoMovimiento=$_POST["TipoMovimiento"];
    $idHorarioPlantilla=$_POST["idHorarioPlantilla"];
     
    $usuario = $_SESSION ["userLog"]["usuario"];
    $datos              = array();
    try{
        $sql1 = "INSERT INTO hisotico_movimintos_plantillas (idhistoricoplantilla, EmpleadoEntidad, EmpleadoConsecutivo, EmpleadoCategoria, idPuntoServicio, idPlantilla, idHorario, Usuario, FechaRegistro, Procedencia) VALUES (null,'$Entidad','$Categoria','$Tipo','$PuntoServicio','$idPlantilla','$idHorarioPlantilla','$usuario',now(),'$TipoMovimiento')";      
        $res1 = mysqli_query($conexion, $sql1);  
        if ($res1 !== true) {
            $response["status"] = "error";
            $response["message"]='error al registrar el historico de movimientos de las plantillas';
            return;
        }else{
            $response["message"]='El registró se realizó correctamente';
        }
    } 
    catch( Exception $e )
    {
    $response["status"]="error";
    $response["message"]="No se registro el historico de movimientos de las plantillas";
    }
echo json_encode($response);
?>