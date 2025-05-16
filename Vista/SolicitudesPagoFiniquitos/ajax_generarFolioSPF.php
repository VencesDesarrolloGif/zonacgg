<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
if (!isset($_SESSION["userLog"])) {
    header ("Location: https://zonagifseguridad.com.mx//zonagif/Vista/LoginSuperUsuario/form_LoginSuperUsuario.php");
    exit;
}
// $log = new KLogger ( "ajax_generarfolioSPF.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable sql2: " . var_export ($sql2, true));
$response = array("status" => "success");
$listaAgregados= $_POST['listaAgregados'];
$ultimoID= array();
$usuario=$_SESSION['userLog']['usuario'];

try{
    $sql = "SELECT max(ifnull(folioSPF,0))+1 AS idSiguiente 
            FROM finiquitos
            LIMIT 1";

    $res = mysqli_query($conexion, $sql);
    while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
          $ultimoID[] = $reg;
    }

    for($i=0; $i < count($listaAgregados); $i++) { 

        $idFiniquitoSel=$listaAgregados[$i];
        $idSiguiente=$ultimoID[0]["idSiguiente"];
        $sql1 ="UPDATE finiquitos 
                SET folioSPF=$idSiguiente,
                    estatusPagoFiniquito='4'
                WHERE idFiniquito=$idFiniquitoSel";

        $res = mysqli_query($conexion, $sql1);

        $sql2 ="INSERT INTO historicomovimientosFiniquitosPago(idFiniquito,idEstatusActual,idEstatusNuevo,fechamovimiento,usuarioMovimiento) VALUES ($idFiniquitoSel,'3', '4',now(),'$usuario')";
        $res2 = mysqli_query($conexion, $sql2);
    }
}catch( Exception $e ){
	$response["status"]="error";
	$response["error"]="No se puedo obtener consulta";
}
echo json_encode($response);
?>