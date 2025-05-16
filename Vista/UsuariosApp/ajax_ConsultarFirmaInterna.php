<?php
session_start();
require "../conexion.php"; 
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array(); 
$datos1              = array(); 
// $log = new KLogger ( "ajax_ConsultarFirmaInterna.log" , KLogger::DEBUG );
$NumeroEmpleadoFirma = $_POST["NumeroEmpleadoFirma"];
$contraseniaFirma = md5($_POST["contraseniaFirma"]);
$usuarioApp = "";
try {
    $sql = "SELECT * from firmainterna 
            left join empleados e on (firmainterna.EntidadFirma = e.entidadFederativaId and firmainterna.ConsecutivoFirma = e.empleadoConsecutivoId and firmainterna.CategoriaFirma = e.empleadoCategoriaId)
            where concat_ws('-',EntidadFirma,ConsecutivoFirma,CategoriaFirma) = '$NumeroEmpleadoFirma'";     
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
        $datos[] = $reg;
    }
    if(count($datos)==0){
        $opcion=0;// error de que el numero de empleado no tiene una firma interna
    }else{
        if($datos[0]["ContraseniaFirma"]==$contraseniaFirma){
            $sql1 = "SELECT * from usuario_empleado ue
                    left join usuarios u on (u.usuario= ue.usuario)
                    where concat_ws('-', ue.entidadEmpleadoUsuario,ue.consecutivoEmpleadoUsuario,ue.categoriaEmpleadoUsuario)='$NumeroEmpleadoFirma'
                    and u.usuarioRolId='19'";     
            $res1 = mysqli_query($conexion, $sql1);
            while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
                $datos1[] = $reg1;
            }
            if(count($datos1) == 0){
                if($datos[0]["empleadoEstatusId"]=="0" || $datos[0]["empleadoEstatusId"]==0){
                    $opcion=4; //error el empleado Esta dado de baja
                }else{
                    $opcion=1;// ok de que el empleado tiene una firna interna pero no un usuario 
                }
            }else{
                $contrasenia = $datos1[0]["contrasenia"];
                $usuarioApp = $datos1[0]["usuario"];
                if($contrasenia == "BLOQUEO"){
                    $opcion=5;// error el empleado ya tiene una firma interna y un usuario de asistencia para la app per esta bloqueado
                }else{
                    $opcion=3;// error el empleado ya tiene una firma interna y un usuario de asistencia para la app
                }
            }
        }else{
            $opcion=2;// error el empleado tiene una firma interna pero se equivoco en la contraseña 
        }
    }
// $log->LogInfo("Valor de la variable opcion " . var_export ($opcion, true));
    
    $response["status"]= "success";
    $response["usuarioApp"] = $usuarioApp;
    $response["opcion"] = $opcion;
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);


