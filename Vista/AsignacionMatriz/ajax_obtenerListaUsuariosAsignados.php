<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response              = array();
$response["status"]    = "error";
$datos                 = array();
$entidadFederativaId   = $_POST["entidadFederativaId"];
$empleadoConsecutivoId = $_POST["empleadoConsecutivoId"];
$empleadoCategoriaId   = $_POST["empleadoCategoriaId"];
//$log = new KLogger ( "ajax_ObtenerDatosEdicionMatriz.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
//$log->LogInfo("Valor de la variable response " . var_export ($response, true));
try {
    $sql = "SELECT * from usuario_empleado
            left join usuarios on (usuarios.usuario = usuario_empleado.usuario)
            left join catalogorolesusuarios on (catalogorolesusuarios.idRolUsuario=usuarios.usuarioRolId)
            where entidadEmpleadoUsuario ='$entidadFederativaId'
            and consecutivoEmpleadoUsuario='$empleadoConsecutivoId'
            and categoriaEmpleadoUsuario='$empleadoCategoriaId'
            and (usuarioRolId ='8' or usuarioRolId ='10')";      
    
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
    for($i = 0; $i < count($datos); $i++){
        $usuario     = $datos[$i]["usuario"]; 
        $nombre     = $datos[$i]["nombre"]; 
        $apellidoPaterno     = $datos[$i]["apellidoPaterno"]; 
        $apellidoMaterno     = $datos[$i]["apellidoMaterno"]; 
        $descripcionRolUsuario1     = $datos[$i]["descripcionRolUsuario"]; 
        $datos[$i]["NombreEmpleadoUsuario"] = $nombre." ".$apellidoPaterno." ".$apellidoMaterno;
        $descripcionRolUsuario = str_replace(" ","-",$descripcionRolUsuario1);

        $datos[$i]["accion"]= "<img style='width: 10%' title='Rechazar'src='img/ok.png' class='cursorImg' id='btnRechazar' onclick=AsignarUsuarioEmpleadoMatriz('$usuario','$descripcionRolUsuario')>";
    }
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
