<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
date_default_timezone_set('America/Mexico_City');
$response = array();
$datosORIGINALESIncidenciaModificada    = array();
$datos    = array();
$datos1    = array();
$response = array("status" => "success");
$log = new KLogger ( "ajax_GuardarDatosEditedReporteIncidenciaCC.php.log" , KLogger::DEBUG );
$log->LogInfo("Valor de la variable _POST 1 aaa: " . var_export ($_POST, true));
try {
        $response["status"] = "success";
        $usuario = $_SESSION ["userLog"]["usuario"];
        $percataronEdit = $_POST ["txtAreaPercataronEdit"];
        $tareaEdit = $_POST ["txtAreaTareaEdit"];
        $idIncidencia = $_POST ["IdIncidenciaEdit"];//COLOCA EL ID DE LA INCIDENCIA A MODIFICAR PARA EL UPDATE (AUTOINCREMENT)

        $responsabilidadEdit1=$_POST['txtResponsabilidadEdit1'];
        $responsabilidadEdit2=$_POST['txtResponsabilidadEdit2'];

        $NumEmpFirmaQueEdita = $_POST ["NumEmpModalFirmaReporteincidenciaEmpleadohiddenEdit"];//FALTAAAAAAAAAAAAAAAAAAAAAAAAAAAA
        $constraseniaFirmaQueEdita = $_POST ["constraseniaFirmaParaReporteincidenciaEmpleadoHiddenEdit"];//FALTAAAAAAAAAAAAAAAAAAAAAAAAAAAA

        $sql99 = "SELECT * 
                  FROM reporteincidenciacentrocontrol
                  WHERE idinciIdenciaCC='$idIncidencia'";
$log->LogInfo("Valor de la variable sql99: " . var_export ($sql99, true));

        $res99 = mysqli_query($conexion, $sql99);  
        while (($reg99 = mysqli_fetch_array($res99, MYSQLI_ASSOC))) {
            $datosORIGINALESIncidenciaModificada[] = $reg99;
        }

// $log->LogInfo("Valor de la variable datosORIGINALESIncidenciaModificada: " . var_export ($datosORIGINALESIncidenciaModificada, true));


        $TestigoIncidenciaCC= $datosORIGINALESIncidenciaModificada[0]["TestigoIncidenciaCC"];
        $TestigoIncidenciaCC2= $datosORIGINALESIncidenciaModificada[0]["TestigoIncidenciaCC2"];
        $TestigoIncidenciaCC3= $datosORIGINALESIncidenciaModificada[0]["TestigoIncidenciaCC3"];
        $TestigoIncidenciaCC4= $datosORIGINALESIncidenciaModificada[0]["TestigoIncidenciaCC4"];
        $TestigoIncidenciaCC5= $datosORIGINALESIncidenciaModificada[0]["TestigoIncidenciaCC5"];
        $TestigoIncidenciaCC6= $datosORIGINALESIncidenciaModificada[0]["TestigoIncidenciaCC6"];
        $TestigoIncidenciaCC7= $datosORIGINALESIncidenciaModificada[0]["TestigoIncidenciaCC7"];
        $PercataronIncidenciaCC= $datosORIGINALESIncidenciaModificada[0]["PercataronIncidenciaCC"];
        $RecopilacionIncidenciaCC= $datosORIGINALESIncidenciaModificada[0]["RecopilacionIncidenciaCC"];
        $RecopilacionIncidenciaCC2= $datosORIGINALESIncidenciaModificada[0]["RecopilacionIncidenciaCC2"];
        $RecopilacionIncidenciaCC3= $datosORIGINALESIncidenciaModificada[0]["RecopilacionIncidenciaCC3"];
        $RecopilacionIncidenciaCC4= $datosORIGINALESIncidenciaModificada[0]["RecopilacionIncidenciaCC4"];
        $RecopilacionIncidenciaCC5= $datosORIGINALESIncidenciaModificada[0]["RecopilacionIncidenciaCC5"];
        $RecopilacionIncidenciaCC6= $datosORIGINALESIncidenciaModificada[0]["RecopilacionIncidenciaCC6"];
        $RecopilacionIncidenciaCC7= $datosORIGINALESIncidenciaModificada[0]["RecopilacionIncidenciaCC7"];
        $RecopilacionIncidenciaCC8= $datosORIGINALESIncidenciaModificada[0]["RecopilacionIncidenciaCC8"];
        $RecopilacionIncidenciaCC9= $datosORIGINALESIncidenciaModificada[0]["RecopilacionIncidenciaCC9"];
        $RecopilacionIncidenciaCC10= $datosORIGINALESIncidenciaModificada[0]["RecopilacionIncidenciaCC10"];
        $TareaIncidenciaCC= $datosORIGINALESIncidenciaModificada[0]["TareaIncidenciaCC"];
        $ResponsabilidadIncidenciaCC= $datosORIGINALESIncidenciaModificada[0]["ResponsabilidadIncidenciaCC"];
        $ResponsabilidadIncidenciaCC2= $datosORIGINALESIncidenciaModificada[0]["ResponsabilidadIncidenciaCC2"];
        $OrdenesIncidenciaCC= $datosORIGINALESIncidenciaModificada[0]["OrdenesIncidenciaCC"];
        $OrdenesIncidenciaCC2= $datosORIGINALESIncidenciaModificada[0]["OrdenesIncidenciaCC2"];
        $EvidenciaIncidenciaCC= $datosORIGINALESIncidenciaModificada[0]["EvidenciaIncidenciaCC"];
        $EvidenciaIncidenciaCC2= $datosORIGINALESIncidenciaModificada[0]["EvidenciaIncidenciaCC2"];
        $SupervisionIncidenciaCC= $datosORIGINALESIncidenciaModificada[0]["SupervisionIncidenciaCC"];
        $SupervisionIncidenciaCC2= $datosORIGINALESIncidenciaModificada[0]["SupervisionIncidenciaCC2"];
        $UsuarioregistroIncidenciaCC= $datosORIGINALESIncidenciaModificada[0]["UsuarioregistroIncidenciaCC"];
        $FechaRegistroIncidenciaCC= $datosORIGINALESIncidenciaModificada[0]["FechaRegistroIncidenciaCC"];
        $EmpleadoRegistroIncidenciaCC= $datosORIGINALESIncidenciaModificada[0]["EmpleadoRegistroIncidenciaCC"];
        $ContraseniaEmpIncidenciaCC= $datosORIGINALESIncidenciaModificada[0]["ContraseniaEmpIncidenciaCC"];
        $idEstatusReporteIncidenciaCC= $datosORIGINALESIncidenciaModificada[0]["idEstatusReporteIncidenciaCC"];


        $sql101 = "INSERT INTO edicionReporteIncidenciaCC(idinciIdenciaCCEdit,TestigoIncidenciaCCEdit,TestigoIncidenciaCCEdit2,TestigoIncidenciaCCEdit3,TestigoIncidenciaCCEdit4,TestigoIncidenciaCCEdit5,TestigoIncidenciaCCEdit6,TestigoIncidenciaCCEdit7,PercataronIncidenciaCCEdit,RecopilacionIncidenciaCCEdit,RecopilacionIncidenciaCCEdit2,RecopilacionIncidenciaCCEdit3,RecopilacionIncidenciaCCEdit4,RecopilacionIncidenciaCCEdit5,RecopilacionIncidenciaCCEdit6,RecopilacionIncidenciaCCEdit7,RecopilacionIncidenciaCCEdit8,RecopilacionIncidenciaCCEdit9,RecopilacionIncidenciaCCEdit10,TareaIncidenciaCCEdit,ResponsabilidadIncidenciaCCEdit,ResponsabilidadIncidenciaCCEdit2,OrdenesIncidenciaCCEdit,OrdenesIncidenciaCCEdit2,EvidenciaIncidenciaCCEdit,EvidenciaIncidenciaCCEdit2,SupervisionIncidenciaCCEdit,SupervisionIncidenciaCCEdit2,UsuarioEditRegIncidenciaCC,FechaRegIncidenciaCCEdit,EmpleadoEditRegIncidenciaCC,ContraseniaEmpEditIncidenciaCC,idEstatusReporteEdit,FechaDeEdición) VALUES ($idIncidencia,'$TestigoIncidenciaCC','$TestigoIncidenciaCC2','$TestigoIncidenciaCC3','$TestigoIncidenciaCC4','$TestigoIncidenciaCC5','$TestigoIncidenciaCC6','$TestigoIncidenciaCC7','$PercataronIncidenciaCC','$RecopilacionIncidenciaCC','$RecopilacionIncidenciaCC2','$RecopilacionIncidenciaCC3','$RecopilacionIncidenciaCC4','$RecopilacionIncidenciaCC5','$RecopilacionIncidenciaCC6','$RecopilacionIncidenciaCC7','$RecopilacionIncidenciaCC8','$RecopilacionIncidenciaCC9','$RecopilacionIncidenciaCC10','$TareaIncidenciaCC','$ResponsabilidadIncidenciaCC','$ResponsabilidadIncidenciaCC2','$OrdenesIncidenciaCC','$OrdenesIncidenciaCC2','$EvidenciaIncidenciaCC','$EvidenciaIncidenciaCC2','$SupervisionIncidenciaCC','$SupervisionIncidenciaCC2','$UsuarioregistroIncidenciaCC','$FechaRegistroIncidenciaCC','$EmpleadoRegistroIncidenciaCC','$ContraseniaEmpIncidenciaCC',$idEstatusReporteIncidenciaCC,now())";

            $res101 = mysqli_query($conexion,$sql101);  
$log->LogInfo("Valor de la variable sql101: " . var_export ($sql101, true));

            if($res101 !== true) {
                $response["status"] = "error";
                $response["message"]='error al registrar la edicion del reporte';
                return;
            }

        if($idEstatusReporteIncidenciaCC=='1') {
           $estatusNuevo=1;
        }else{
           $estatusNuevo=2;

           $sql120 = "UPDATE reporteincidenciasupervisorescentrocontrol
                      SET EstatusRevisionIncidenciaCC= $estatusNuevo;
                      WHERE idIncidenciaSupCC=$idIncidencia";

            $res120 = mysqli_query($conexion, $sql120); 
$log->LogInfo("Valor de la variable sql120: " . var_export ($sql120, true));

        }
        
        $sql100 = "UPDATE ReporteIncidenciaCentroControl
                   SET PercataronIncidenciaCC='$percataronEdit',
                       TareaIncidenciaCC='$tareaEdit',
                       UsuarioregistroIncidenciaCC='$usuario',
                       FechaRegistroIncidenciaCC=now(),
                       EmpleadoRegistroIncidenciaCC='$NumEmpFirmaQueEdita',
                       ContraseniaEmpIncidenciaCC='$constraseniaFirmaQueEdita',
                       idEstatusReporteIncidenciaCC=$estatusNuevo
                    WHERE idinciIdenciaCC=$idIncidencia";

        $res100 = mysqli_query($conexion, $sql100);  

$log->LogInfo("Valor de la variable sql100: " . var_export ($sql100, true));


        if ($res100 !== true) {
            $response["status"] = "error";
            $response["message"]='error al actualizar el reporte de incidencia para centro de control';
            return;
        }

        for($a=1; $a <= 7; $a++){
  // $log->LogInfo("Valor de la variable testigosEdit1 for: " . var_export ($testigosEdit.$a;, true));

            $testigo=$_POST["txtAreaTestigosEdit"."$a"];

            if($a=='1') {
               $sql0 = "UPDATE reporteincidenciacentrocontrol
                        SET TestigoIncidenciaCC='$testigo'
                        WHERE idinciIdenciaCC=$idIncidencia";                                                
            }else{
                  $nombreColumna="TestigoIncidenciaCC".$a;
                  $sql0 = "UPDATE reporteincidenciacentrocontrol
                           SET $nombreColumna='$testigo'
                           WHERE idinciIdenciaCC=$idIncidencia";
            }
            $log->LogInfo("Valor de la variable sql0: " . var_export ($sql0, true));
            
            $res0 = mysqli_query($conexion, $sql0);  
            if ($res0 !== true) {
                $response["status"] = "error";
                $response["message"]= 'error al actualizar testigo del reporte de incidencia para centro de control';
                return;
            }
        }//for a

        for($b=1; $b <= 10; $b++){

            $recopilacion=$_POST["txtAreaRecopilacionEdit"."$b"];


            if($b=='1') {
                $sqlb = "UPDATE reporteincidenciacentrocontrol
                         SET RecopilacionIncidenciaCC='$recopilacion'
                         WHERE idinciIdenciaCC=$idIncidencia";
            }else{
                $nombreColumna="RecopilacionIncidenciaCC".$b;
                $sqlb = "UPDATE reporteincidenciacentrocontrol
                         SET $nombreColumna='$recopilacion'
                         WHERE idinciIdenciaCC=$idIncidencia";
            }
$log->LogInfo("Valor de la variable sqlb: " . var_export ($sqlb, true));

            $resb = mysqli_query($conexion, $sqlb);  
            if ($resb !== true) {
                $response["status"] = "error";
                $response["message"]='error al editar recopilacion del reporte de incidencia para centro de control';
                return;
            }
        }//for b

        for($c=1; $c <= 2; $c++){

            $responsabilidad=$_POST["txtResponsabilidadEdit"."$c"];

            if($c=='1') {
               $sqlc = "UPDATE reporteincidenciacentrocontrol
                        SET ResponsabilidadIncidenciaCC='$responsabilidad'
                        WHERE idinciIdenciaCC=$idIncidencia";
            }else{
                $nombreColumna="ResponsabilidadIncidenciaCC".$c;
                $sqlc = "UPDATE reporteincidenciacentrocontrol
                         SET $nombreColumna='$responsabilidad'
                         WHERE idinciIdenciaCC=$idIncidencia";
            }
$log->LogInfo("Valor de la variable sqlc: " . var_export ($sqlc, true));

            $resc = mysqli_query($conexion, $sqlc);  
            if ($resc !== true) {
                $response["status"] = "error";
                $response["message"]='error al registrar responsabilidad del reporte de incidencia para centro de control';
                return;
            }
        }//for c

        for($d=1; $d <= 2; $d++){

            $ordenes=$_POST["txtAreaOrdenesEdit"."$d"];

            if($d=='1') {
               $sqld = "UPDATE reporteincidenciacentrocontrol
                        SET OrdenesIncidenciaCC='$ordenes'
                        WHERE idinciIdenciaCC=$idIncidencia";
            }else{
                $nombreColumna="OrdenesIncidenciaCC".$d;
                $sqld = "UPDATE reporteincidenciacentrocontrol
                         SET $nombreColumna='$ordenes'
                         WHERE idinciIdenciaCC=$idIncidencia";
            }
        
            $resd = mysqli_query($conexion, $sqld);  
$log->LogInfo("Valor de la variable sqld: " . var_export ($sqld, true));

            if ($resd !== true) {
                $response["status"] = "error";
                $response["message"]='error al editar ordenes del reporte de incidencia para centro de control';
                return;
            }
        }//for d

        for($e=1; $e <= 2; $e++){

            $evidencia=$_POST["txtAreaEvidenciaEdit"."$e"];

            if($e=='1') {
                $sqle = "UPDATE reporteincidenciacentrocontrol
                         SET EvidenciaIncidenciaCC='$evidencia'
                         WHERE idinciIdenciaCC=$idIncidencia";
            }else{
                $nombreColumna="EvidenciaIncidenciaCC".$e;
                $sqle = "UPDATE reporteincidenciacentrocontrol
                         SET $nombreColumna='$evidencia'
                         WHERE idinciIdenciaCC=$idIncidencia";
            }

            $rese = mysqli_query($conexion, $sqle);  
$log->LogInfo("Valor de la variable sqle: " . var_export ($sqle, true));

            if ($rese !== true) {
                $response["status"] = "error";
                $response["message"]='error al editar evidencia del reporte de incidencia para centro de control';
                return;
            }
        }//for e

        for($f=1; $f <= 2; $f++){

            $supervisor=$_POST["txtAreaSupervisionEdit"."$f"];

            if($f=='1') {
                $sqlf = "UPDATE reporteincidenciacentrocontrol
                         SET SupervisionIncidenciaCC='$supervisor'
                         WHERE idinciIdenciaCC=$idIncidencia";
            }else{
                $nombreColumna="SupervisionIncidenciaCC".$f;
                $sqlf = "UPDATE reporteincidenciacentrocontrol
                         SET $nombreColumna='$supervisor'
                         WHERE idinciIdenciaCC=$idIncidencia";
            }
$log->LogInfo("Valor de la variable sqlf: " . var_export ($sqlf, true));

            $resf = mysqli_query($conexion, $sqlf);  
            if ($resf !== true) {
                $response["status"] = "error";
                $response["message"]='error al editar supervision del reporte de incidencia para centro de control';
                return;
            }
        }//for f
$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
}catch (Exception $e) {    
    $response["status"]="error";
    $response["error"]="No se registró el reporte de incidencia para centro de control";
$log->LogInfo("Valor de la variable response: " . var_export ($response, true));

}
echo json_encode($response);
$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
?>