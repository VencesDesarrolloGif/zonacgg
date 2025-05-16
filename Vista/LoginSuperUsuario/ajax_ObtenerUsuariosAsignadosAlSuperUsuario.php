<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
require_once ("../../Negocio/Negocio.class.php");
require_once ("../Helpers.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
 // $log = new KLogger ( "ajax_ObtenerUsuariosAsignadosAlSuperUsuario.log" , KLogger::DEBUG );
 // $log->LogInfo("Valor de la variable _POST " . var_export ($_POST, true));
//$log->LogInfo("Valor de la variable response " . var_export ($response, true));
if (!empty ($_POST))
{
    $UsuarioAMostrar = $_POST ["UsuarioAMostrar"];
    $sql = "SELECT u.usuario as Usuario,cr.descripcionRolUsuario as Rol,u.contrasenia as Contrasenia,concat_ws(' ',e.nombreEmpleado,e.apellidoPaterno) as Nombre,concat_ws('-',su.empleadoEntidadSuperU,su.empleadoConsecutivoSuperU,su.empleadoCategoriaSuperU) as NumeroE
        from superusuarios su
        left join usuario_empleado ue ON(ue.entidadEmpleadoUsuario=su.empleadoEntidadSuperU and ue.consecutivoEmpleadoUsuario=su.empleadoConsecutivoSuperU and ue.categoriaEmpleadoUsuario=su.empleadoCategoriaSuperU)
        left join usuarios u ON (u.usuario=ue.usuario)
        left join catalogorolesusuarios cr ON(cr.idRolUsuario=u.usuarioRolId)
        left join empleados e ON(e.entidadFederativaId=su.empleadoEntidadSuperU and e.empleadoConsecutivoId=su.empleadoConsecutivoSuperU and e.empleadoCategoriaId=su.empleadoCategoriaSuperU)
        where su.UsuarioS='$UsuarioAMostrar'
        and u.contrasenia!='BLOQUEO'
        and (e.empleadoEstatusId='1' or e.empleadoEstatusId='2')
        order by cr.descripcionRolUsuario,u.usuario";   
        // $log->LogInfo("Valor de la variable sql " . var_export ($sql, true));  
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
        $response["status"]= "success";
        $response["datos"] = $datos;
        echo json_encode($response);
}else{
    $response["datos"] = $datos;
    $response["mensaje"] = "Error al iniciar sesion";
    include ("LoginSuperUsuario/form_LoginSuperUsuario.php");
    echo json_encode($response);
}
