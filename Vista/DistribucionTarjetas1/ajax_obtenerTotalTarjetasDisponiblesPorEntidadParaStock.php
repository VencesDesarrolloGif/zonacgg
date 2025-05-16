<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
//$log = new KLogger ( "ajax_obtenerTotalTarjetasDisponiblesPorEntidadParaStock.log" , KLogger::DEBUG );
$response = array();
$datos    = array();
$response["status"]  = "success";
$IdEntidadARevisar            = $_POST["IdEntidadARevisar"];
$usuario             = $_SESSION ["userLog"]["usuario"];
date_default_timezone_set('America/Mexico_City');
try {
    $sql = "SELECT * from TarjetaDespensa
            left join matrices on (TarjetaDespensa.idMatrizAsiganda=matrices.IdMatriz)
            left join catalogo_estatustarjetadespensa on (TarjetaDespensa.idEstatusTarjeta=catalogo_estatustarjetadespensa.idEstatusTarjeta)
            left join entidadesfederativas on (TarjetaDespensa.idEntidadAsignada=entidadesfederativas.idEntidadFederativa)
            left join pedidotarjetas on (TarjetaDespensa.IdPedido=pedidotarjetas.IdPedidoT)
            left join Catalogo_EstatusAsignacionTarjetaDespensa on (TarjetaDespensa.idEstatusAsignacionEntidad=Catalogo_EstatusAsignacionTarjetaDespensa.idEstatusTarjetaAsignacion)
            left join empleados ON (TarjetaDespensa.EntidadEmpleadoTarjeta=empleados.entidadFederativaId and TarjetaDespensa.ConsecutivoEmpleadoTarjeta=empleados.empleadoConsecutivoId and TarjetaDespensa.TipoEmpleadoTarjeta=empleados.empleadoCategoriaId )
            where idEntidadAsignada='$IdEntidadARevisar'";      
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
        $datos[] = $reg;
    }

    for($i = 0; $i < count($datos); $i++){
        $IdAsignacionEmpleado     = $datos[$i]["IdEstatusAsignacionEmpleado"]; 
        $comentario               = $datos[$i]["ComentarioBajaTarjeta"]; 
        if($IdAsignacionEmpleado =="1"){
            $NumeroEmpleado = $datos[$i]["entidadFederativaId"] ."-".$datos[$i]["empleadoConsecutivoId"]."-".$datos[$i]["empleadoCategoriaId"];
            $NombreEmpleado = $datos[$i]["nombreEmpleado"] ." ".$datos[$i]["apellidoPaterno"]." ".$datos[$i]["apellidoMaterno"];

            $datos[$i]["IdASignacionEmp"]= "<label class='control-label label'>Asignado</label>";
            $datos[$i]["NumeroEmpleadoAsignado"]= $NumeroEmpleado;
            $datos[$i]["NombreEmpleadoAsignado"]= $NombreEmpleado;
        }else{
            $datos[$i]["IdASignacionEmp"]="<label class='control-label label'>Sin Asignar</label>";
            $datos[$i]["NumeroEmpleadoAsignado"]="<label class='control-label label'>Sin Número De Empleado</label>";
            $datos[$i]["NombreEmpleadoAsignado"]="<label class='control-label label'>Sin Nombre Del Empleado</label>";
        }

        if($comentario =="" || $comentario==null ||$comentario=='null'){
            $datos[$i]["comentario"]= "<label class='control-label label'>Sin Comentarios</label>";
        }else{
            $datos[$i]["comentario"]="<label class='control-label label'>".$comentario."</label>";
        }
    }
    $response["status"]= "success";
    $response["mensaje"] = "Cargado Con Exito";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";
    $response["status"]= "error";}
    //$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
echo json_encode($response);