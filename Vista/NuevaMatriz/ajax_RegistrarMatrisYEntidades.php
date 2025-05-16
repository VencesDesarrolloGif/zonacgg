<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
//$log = new KLogger ( "ajax_RegistrarMatrisYEntidades.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
$response = array();
$datos    = array();
$response["status"]     = "success";

$idNuevaMatriz     = $_POST["selectNuevaMatriz"];
$nombreNuevaMatriz = $_POST["inpNuevaMatriz"];
$idEntidadMat = $_POST["idEntidadMat"];
$nombreEntidadMat = $_POST["nombreEntidadMat"];
$usuario           = $_SESSION ["userLog"]["usuario"];
$Estatusinicial    = "1";
$EstatusinicialAsignacion    = "0";

try{

    $sql = "insert into matrices(IdEntidadmatriz, nombreEntidadmatriz, UsuarioeRegistroMatriz, FechaRegistroMatriz,EstatusMatriz,EstatusAsignacion) values ('$idNuevaMatriz','$nombreNuevaMatriz','$usuario',now(),'$Estatusinicial','$EstatusinicialAsignacion')";
    //$log->LogInfo("Ejecutando matrices: " . $sql);
    $res = mysqli_query($conexion, $sql);  
    if ($res !== true) {
        $response["status"] = "error";
        $response["message"]='error al registrar la matriz';
        return;
    }else{
        //se actualiza asistencia
        $response["message"]='Se Realizó Correctamente El Registro ';
    }

    $sql1 = "SELECT * FROM matrices
            where IdEntidadmatriz='$idNuevaMatriz'
            and EstatusMatriz='1'";      
    $res1 = mysqli_query($conexion, $sql1);
    while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
        $datos[] = $reg1;
    }
    $IdMatriz = $datos[0]["IdMatriz"]; 
    for ($i=0; $i < count($idEntidadMat); $i++) { 
       $idEnti = $idEntidadMat[$i];
       $nomEnti = $nombreEntidadMat[$i];
    
    $sql2 = "insert into matricesEntidades(IdMatrizPrincipal, IdEntidadAsignada, nombreEntidadAsignada, UsuarioRegistroEntidad, FechaRegistroEntidad, EstatusEntidadesMatriz) values ('$IdMatriz','$idEnti','$nomEnti','$usuario',now(),'$Estatusinicial')";
    $res2 = mysqli_query($conexion, $sql2);  
    if ($res2 !== true) {
        $response["status"] = "error";
        $response["message"]='error al registrar la matriz';
        return;
    }else{
        //se actualiza asistencia
        $response["message"]='Se Realizó Correctamente El Registro ';
    }

    }
}catch (Exception $e) {
    $response["message"] = "Error al Registrar Matriz";
}
echo json_encode($response);
?> 