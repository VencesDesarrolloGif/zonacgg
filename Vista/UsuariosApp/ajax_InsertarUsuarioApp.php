<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php"); 
$response           = array();
$response["status"] = "error";
$datos1              = array();
 // $log = new KLogger ( "ajax_InsertarUsuarioApp.log" , KLogger::DEBUG );
 // $log->LogInfo("Valor de la variable _POST " . var_export ($_POST, true));
//
$usuario=$_SESSION ["userLog"]["usuario"];
$entidadEmp = $_POST["entidadEmp"];
$ConsecutivoEmp = $_POST["ConsecutivoEmp"];
$CategoriaEmp = $_POST["CategoriaEmp"];
$UsuarioNuevo = $_POST["UsuarioNuevo"];
$contraseniaUsuario = md5($_POST["contraseniaUsuario"]);
$NombreEmpApp = $_POST["NombreEmpApp"];
$ApellidoPApp = $_POST["ApellidoPApp"];
$ApelledoMApp = $_POST["ApelledoMApp"];
$idEntidaAppd = $_POST["idEntidaAppd"];
$opcion = $_POST["opcion"];
$datos              = array(); 
try {
    // se realiza la consulta para ver si los valores se repiten en caso de que si se bloquea y manda un mensaje en caso contrario se realiza el insert
    if(!empty($_POST)){
        if($opcion == "1" || $opcion==1){
            $sql1 = "SELECT * from usuarios where usuario='$UsuarioNuevo'"; 
            // $log->LogInfo("Valor de la variable sql1 " . var_export ($sql1, true));    
            $res1 = mysqli_query($conexion, $sql1);
            while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
                $datos[] = $reg1;
            }
            // $log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
            if(count($datos)==0){
                $sql = "INSERT INTO usuarios (usuario, contrasenia, usuarioRolId, usuarioId, apellidoPaterno, apellidoMaterno, nombre, entidadFederativaUsuario,  fechaCreacion, usuarioCreacion) VALUES ('$UsuarioNuevo','$contraseniaUsuario','19',null,'$ApellidoPApp','$ApelledoMApp','$NombreEmpApp','$idEntidaAppd',now(),'$usuario')";
             $log->LogInfo("Valor de la variable sql " . var_export ($sql, true));
                $res = mysqli_query($conexion, $sql);  
                if ($res !== true) {
                    $response["status"] = "error";
                    $response["message"]='error al registrar el nuevo usuario comunicate con el area de desarrollo';
                    return;
                }else{
                    $sql2 = "INSERT INTO usuario_empleado (usuario, entidadEmpleadoUsuario, consecutivoEmpleadoUsuario, categoriaEmpleadoUsuario) VALUES ('$UsuarioNuevo','$entidadEmp','$ConsecutivoEmp','$CategoriaEmp')";
                    // $log->LogInfo("Valor de la variable sql2 " . var_export ($sql2, true));
                    $res2 = mysqli_query($conexion, $sql2);
                    if ($res2 !== true) {
                        $response["status"] = "error";
                        $response["message"]='error al registrar el nuevo usuario comunicate con el area de desarrollo';
                        return;
                    }else{
                        $response["status"]= "success";
                        $response["message"]='El Usuario Se Registró Correctamente';
                    }
                }
            }else{
                $response["status"] = "error";
                $response["message"]='El usuario que intenta crear ya existe favor de ingresar uno diferente';
            }
        }else{
            $sql2 = "UPDATE usuarios SET contrasenia = '$contraseniaUsuario' WHERE (usuario = '$UsuarioNuevo')";
            // $log->LogInfo("Valor de la variable sql2 " . var_export ($sql2, true));
            $res2 = mysqli_query($conexion, $sql2);
            if ($res2 !== true) {
                $response["status"] = "error";
                $response["message"]='error al actualizar el nuevo usuario comunicate con el area de desarrollo';
                return;
            }else{
                $response["status"]= "success";
                $response["message"]='El Usuario Se Actualizó Correctamente';
            }

        }
    }
    
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
