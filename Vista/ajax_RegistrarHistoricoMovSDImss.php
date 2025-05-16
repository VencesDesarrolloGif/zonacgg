<?php
    session_start();
    require "conexion.php"; 
    require_once("../libs/logger/KLogger.php");
    $log = new KLogger ( "ajax_RegistrarHistoricoMovSDImss.log" , KLogger::DEBUG );
    $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true)); 
    $response = array("status" => "success");
    $sueldo=$_POST["sueldo"];
    $salarioDiari=$_POST["salarioDiari"];
    $constrasenia=$_POST["constrasenia"];
    $numeroAdmin=$_POST["numeroAdmin"];
    $numeroEmpleado=$_POST["numeroEmpleado"];
    $origen=$_POST["origen"];
    $idPlantilla=$_POST["idPlantilla"];
    $usuario = $_SESSION ["userLog"]["usuario"];
    $datos              = array();
    try{
        $sql = "SELECT max(idAjusteTabulador) as idAjusteTab from CatalogoAjusteTabulador";     
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
        $idAjusteTab = $datos[0]["idAjusteTab"];
        $sql1 = "INSERT INTO HistoricoMovSalarioDiarioParaImss (idAjusteTabuladorHist, NumeEmpleadoHistSDImss, IdPlantillaEmpHist, SalarioDiarioImss, SueldoSDImss, NumEmpFirmaSDImss, ContraEmpFirmaSDImss, usuarioRegistroSDImss, FechaRegistroSDImss, idOrigenSDImssHist) VALUES ('$idAjusteTab','$numeroEmpleado','$idPlantilla','$salarioDiari','$sueldo','$numeroAdmin','$constrasenia','$usuario',now(),'$origen')";      
        $res1 = mysqli_query($conexion, $sql1);  
        if ($res1 !== true) {
            $response["status"] = "error";
            $response["message"]='error al registrar El Historico Salario Diario Para Imss';
            return;
        }else{
            $response["message"]='La Asignación Se Realizó Correctamente';
        }
    } 
    catch( Exception $e )
    {
    $response["status"]="error";
    $response["message"]="No se registro el historico de salario diario para imss";
    }
echo json_encode($response);
?>