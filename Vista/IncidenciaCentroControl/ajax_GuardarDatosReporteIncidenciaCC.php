<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
date_default_timezone_set('America/Mexico_City');
$response = array();
$datos    = array();
$response = array("status" => "success");
$log = new KLogger ( "ajax_GuardarDatosReporteIncidenciaCC.log" , KLogger::DEBUG );
$log->LogInfo("Valor de la variable _POST1: " . var_export ($_POST, true));
$log->LogInfo("Valor de la variable _FILES: " . var_export ($_FILES, true));
try {
    $idEspecificacion = $_POST ["especificacion"];

    $IncidenciaAceptacion = $_POST ["IncidenciaAceptacion"];

    /*if($IncidenciaAceptacion=='1'){//robos
       $archivoEvidencia ="Doc7";
    }*/

    if(count($_FILES["Doc7"]["name"])>='17'){
       $response["status"]="error";
       $response["message"] ="Ingresé unicamente 16 imagenes de evidencia";

    }else{

        $noTestigos  = $_POST ["noTestigos"];
        $noTextorec  = $_POST ["noTextorec"];
        $noTxtRespons= $_POST ["noTxtRespons"];
        $noTxtOrdenes= $_POST ["noTxtOrdenes"];
        $noTxtEviden = $_POST ["noTxtEviden"];
        $noTxtSup    = $_POST ["noTxtSup"];

        $NumeroGuardiaIncidencia = $_POST ["NumeroGuardiaIncidencia"];
        $NumeroAdministrativoIncidencia = $_POST ["NumeroAdministrativoIncidencia"];
        $EntidadIncidencia = $_POST ["EntidadIncidencia"];
        $FechaIncidencia = $_POST ["FechaIncidencia"];
        $ExistePuntoSi = $_POST ["existepuntoSi"];
        $permitidos1 = "image/jpeg";
        $permitidos2 = "image/png";
        $correcto=true;
        $response["status"] = "success";

        if($ExistePuntoSi===true || $ExistePuntoSi==="true"){
            $PuntoServicioIncidencia = $_POST ["PuntoServicioIncidencia"];
            $PuntoServicioIncidencia1 = "";
            $ExistePunto="1";
        }else{
            $PuntoServicioIncidencia = "0";
            $PuntoServicioIncidencia1 = $_POST ["PuntoServicioEscritoCC"];
            $ExistePunto="2";
        } 

        $Testigos     = $_POST ["Testigos"];
        $Percataron   = $_POST ["Percataron"];
        $Recopilacion = $_POST ["Recopilacion"];
        $Tarea = $_POST ["Tarea"];
        $Responsabilidad = $_POST ["Responsabilidad"];
        $Ordenes    = $_POST ["Ordenes"];
        $Evidencia  = $_POST ["Evidencia"];
        $Supervision= $_POST ["Supervision"];

        /*if($IncidenciaAceptacion=="1"){
            $InicioFor = "1";
            $LargoFor = "7";
        }*/

        $ProcedeReporteSi = $_POST ["procedeSiCC"];

        if($ProcedeReporteSi===true || $ProcedeReporteSi==="true"){
            $Linea_Motivo = $_POST ["lineas"];
            $ProcedeReporte="2";
        }else{
            $Linea_Motivo = $_POST ["MotivoCancelacion"];
            $ProcedeReporte="1";
        }

        for($v=1; $v <=11 ; $v++){

            $contadorDocCargadosExtension=0;
            foreach($_FILES["Doc".$v]['tmp_name'] as $key => $tmp_name){
                $valor=$_FILES["Doc".$v]['type'][$contadorDocCargadosExtension];
                if($valor!=""){
                    if($valor!=$permitidos1 && $valor!=$permitidos2 && $ProcedeReporte=="2"){
                        $correcto=false;
                        break;
                    }
                }
                $contadorDocCargadosExtension++;
            }//foreach
        }

        if(!$correcto){
            $response["status"] = "error";
            $response["message"]= "Unos de los archivos seleccionados contiene una extención incorrecta favor de verificarla RECUERDA solo acepta(.PNG, .JPG)";
        }else{
            $NumEmpFirma = $_POST ["NumEmpFirma"];
            $constraseniaFirma = $_POST ["constraseniaFirma"];
            $usuario = $_SESSION ["userLog"]["usuario"];
    
            $ExplodeNumeroGuardiaIncidencia = explode("-", $NumeroGuardiaIncidencia);
            $NumeroGuardiaEntidad = $ExplodeNumeroGuardiaIncidencia[0];
            $NumeroGuardiaConsecutivo = $ExplodeNumeroGuardiaIncidencia[1];
            $NumeroGuardiaCategoria = $ExplodeNumeroGuardiaIncidencia[2];
    
            $ExplodeNumeroAdministrativoIncidencia = explode("-", $NumeroAdministrativoIncidencia);
            $NumeroAdministrativoEntidad = $ExplodeNumeroAdministrativoIncidencia[0];
            $NumeroAdministrativoConsecutivo = $ExplodeNumeroAdministrativoIncidencia[1];
            $NumeroAdministrativoCategoria = $ExplodeNumeroAdministrativoIncidencia[2];
    
            $sql = "SELECT ifnull(max(idinciIdenciaCC),0) as idReporteIncidencia from ReporteIncidenciaCentroControl";    
            // $log->LogInfo("Valor de la variable sql select incidencia actual: " . var_export ($sql, true));    
            $res = mysqli_query($conexion, $sql);
            while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
                $datos[] = $reg;
            }
          
            $idIncidencia = $datos[0]["idReporteIncidencia"];
            $IdInsidenciaSigiente = $idIncidencia+1;
            $hoy = date("Y-m-d H:i:s");
            $FolioIncidencia = "CGIF/AI/".$IdInsidenciaSigiente."/".$hoy;
        
            $sql100 = "INSERT INTO ReporteIncidenciaCentroControl(idinciIdenciaCC,FolioIncidenciaCC, idIncidenciaCC, EmpEntidadIncidenciaCC, EmpConsecutivoIncidenciaCC, EmpCategoriaIncidenciaCC, AdminEntidadIncidenciaCC, AdminConsecutivoIncidenciaCC, AdminCategoriaIncidenciaCC, IdEntidadIncidenciaCC, FechaIncidenciaCC, ExistePuntoIncidenciaCC, IdPuntoIncidenciaCC, PuntoServicioIncidenciaCC, TestigoIncidenciaCC, PercataronIncidenciaCC, RecopilacionIncidenciaCC, TareaIncidenciaCC, ResponsabilidadIncidenciaCC, OrdenesIncidenciaCC, EvidenciaIncidenciaCC, SupervisionIncidenciaCC, UsuarioregistroIncidenciaCC, FechaRegistroIncidenciaCC, EmpleadoRegistroIncidenciaCC, ContraseniaEmpIncidenciaCC, idEstatusReporteIncidenciaCC,idEspecificacion) VALUES ('$IdInsidenciaSigiente','$FolioIncidencia','$IncidenciaAceptacion','$NumeroGuardiaEntidad','$NumeroGuardiaConsecutivo','$NumeroGuardiaCategoria','$NumeroAdministrativoEntidad','$NumeroAdministrativoConsecutivo','$NumeroAdministrativoCategoria','$EntidadIncidencia','$FechaIncidencia','$ExistePunto','$PuntoServicioIncidencia','$PuntoServicioIncidencia1','$Testigos','$Percataron','$Recopilacion','$Tarea','$Responsabilidad','$Ordenes','$Evidencia','$Supervision','$usuario',NOW(),'$NumEmpFirma','$constraseniaFirma','$ProcedeReporte','$idEspecificacion')";
            $res100 = mysqli_query($conexion, $sql100);  

            $log->LogInfo("Valor de la variable sql insert: " . var_export ($sql100, true));
            if ($res100 !== true) {
                $response["status"] = "error";
                $response["message"]='error al registrar el reporte de incidencia para centro de control';
                return;
            }else{
                $response["status"]= "success";
                $response["message"]='El Reporte Se Realizó Correctamente';
            }
            // $log->LogInfo("Valor de la variable response[status]: " . var_export ($response["status"], true));
            // $log->LogInfo("Valor de la variable response[message]: " . var_export ($response["message"], true));

            $sql9 = "SELECT max(idinciIdenciaCC) as id
                 FROM reporteincidenciacentrocontrol";
            // $log->LogInfo("Valor de la variable sql9: " . var_export ($sql9, true));
            $res9 = mysqli_query($conexion, $sql9);  
            while (($reg9 = mysqli_fetch_array($res9, MYSQLI_ASSOC))) {
                $datos1[] = $reg9;
            }
            $idReporte=$datos1[0]["id"];
            // $log->LogInfo("Valor de la variable idReporte: " . var_export ($idReporte, true));
            for($a=1; $a <= $noTestigos; $a++){
                $testigo = $_POST ["testigo".$a];

                if($a=='1') {
                    $sql0 = "UPDATE reporteincidenciacentrocontrol
                       SET TestigoIncidenciaCC='$testigo'
                       WHERE idinciIdenciaCC=$idReporte";                                                
                }else{
                    $nombreColumna="TestigoIncidenciaCC".$a;
                    $sql0 = "UPDATE reporteincidenciacentrocontrol
                          SET $nombreColumna='$testigo'
                          WHERE idinciIdenciaCC=$idReporte";
                }   
                // $log->LogInfo("Valor de la variable sql0: " . var_export ($sql0, true));
                $res0 = mysqli_query($conexion, $sql0);  
                if ($res0 !== true) {
                    $response["status"] = "error";
                    $response["message"]='error al registrar testigo del reporte de incidencia para centro de control';
                return;
                }
            }

            for($b=1; $b <= $noTextorec; $b++){
                $recopilacion = $_POST ["recopilacion".$b];

                if($b=='1') {
                    $sqlb = "UPDATE reporteincidenciacentrocontrol
                        SET RecopilacionIncidenciaCC='$recopilacion'
                        WHERE idinciIdenciaCC=$idReporte";
                }else{
                    $nombreColumna="RecopilacionIncidenciaCC".$b;
                    $sqlb = "UPDATE reporteincidenciacentrocontrol
                           SET $nombreColumna='$recopilacion'
                           WHERE idinciIdenciaCC=$idReporte";
                }

                $resb = mysqli_query($conexion, $sqlb);  
                if ($resb !== true) {
                    $response["status"] = "error";
                    $response["message"]='error al registrar recopilacion del reporte de incidencia para centro de control';
                    return;
                }
            }

            for($c=1; $c <= $noTxtRespons; $c++){
                $responsabilidad = $_POST ["responsabilidad".$c];
                if($c=='1') {
                $sqlc = "UPDATE reporteincidenciacentrocontrol
                        SET ResponsabilidadIncidenciaCC='$responsabilidad'
                        WHERE idinciIdenciaCC=$idReporte";
                }else{
                    $nombreColumna="ResponsabilidadIncidenciaCC".$c;
                    $sqlc = "UPDATE reporteincidenciacentrocontrol
                           SET $nombreColumna='$responsabilidad'
                           WHERE idinciIdenciaCC=$idReporte";
                }
                // $log->LogInfo("Valor de la variable sqlc: " . var_export ($sqlc, true));

                $resc = mysqli_query($conexion, $sqlc);  
                if ($resc !== true) {
                    $response["status"] = "error";
                    $response["message"]='error al registrar responsabilidad del reporte de incidencia para centro de control';
                    return;
                }

            }
            for($d=1; $d <= $noTxtOrdenes; $d++){
                $ordenes = $_POST ["ordenes".$d];

                if($d=='1') {
                $sqld = "UPDATE reporteincidenciacentrocontrol
                        SET OrdenesIncidenciaCC='$ordenes'
                        WHERE idinciIdenciaCC=$idReporte";
                }else{
                    $nombreColumna="OrdenesIncidenciaCC".$d;
                    $sqld = "UPDATE reporteincidenciacentrocontrol
                           SET $nombreColumna='$ordenes'
                           WHERE idinciIdenciaCC=$idReporte";
                }
                // $log->LogInfo("Valor de la variable sqld: " . var_export ($sqld, true));
                $resd = mysqli_query($conexion, $sqld);  
                if ($resd !== true) {
                    $response["status"] = "error";
                    $response["message"]='error al registrar ordenes del reporte de incidencia para centro de control';
                    return;
                }
            }

            for($e=1; $e <= $noTxtEviden; $e++){
                $evidencia = $_POST ["evidencia".$e];

                if($e=='1') {
                    $sqle = "UPDATE reporteincidenciacentrocontrol
                        SET EvidenciaIncidenciaCC='$evidencia'
                        WHERE idinciIdenciaCC=$idReporte";
                }else{
                    $nombreColumna="EvidenciaIncidenciaCC".$e;
                    $sqle = "UPDATE reporteincidenciacentrocontrol
                           SET $nombreColumna='$evidencia'
                           WHERE idinciIdenciaCC=$idReporte";
                }
                // $log->LogInfo("Valor de la variable sqle: " . var_export ($sqle, true));

                $rese = mysqli_query($conexion, $sqle);  
                if ($rese !== true) {
                    $response["status"] = "error";
                    $response["message"]='error al registrar evidencia del reporte de incidencia para centro de control';
                    return;
                }
            }

            for($f=1; $f <= $noTxtSup; $f++){
                $supervision = $_POST ["supervision".$f];

                if($f=='1') {
                    $sqlf = "UPDATE reporteincidenciacentrocontrol
                     SET SupervisionIncidenciaCC='$supervision'
                     WHERE idinciIdenciaCC=$idReporte";
                }else{
                    $nombreColumna="SupervisionIncidenciaCC".$f;
                    $sqlf = "UPDATE reporteincidenciacentrocontrol
                        SET $nombreColumna='$supervision'
                        WHERE idinciIdenciaCC=$idReporte";
                }

                $resf = mysqli_query($conexion, $sqlf);  
                if ($resf !== true) {
                    $response["status"] = "error";
                    $response["message"]='error al registrar supervision del reporte de incidencia para centro de control';
                    return;
                }
            }

            if($ProcedeReporte=="2"){
                $explodeLinea_Motivo = explode(",", $Linea_Motivo);
                $largoexplodeLinea_Motivo = count($explodeLinea_Motivo);

                for($i=0; $i <$largoexplodeLinea_Motivo ; $i++) { 
                    if($i=="0"){
                        $lineaNegocio = $explodeLinea_Motivo[$i];
                        $bandera = "1"; 
                    }else{
                        $bandera3="0";
                        $Bandera1=$explodeLinea_Motivo[$i];
                        if($Bandera1=="1" || $Bandera1=="2" || $Bandera1=="3" || $Bandera1=="4" || $Bandera1=="5"){
                            $bandera3="1";
                            if($bandera=="1"){
                                $bandera = "2";
                            }else{
                                $bandera = "1";
                            }
                        }
                        if($bandera3=="1"){
                            $lineaNegocio = $explodeLinea_Motivo[$i];
                            $bandera3="0";
                        }else{
                            if($bandera=="1"){
                                if (($i % 2) == 0) {
                                    $NombreSup = $explodeLinea_Motivo[$i];
                                    $sql1 = "INSERT INTO ReporteIncidenciaSupervisoresCentroControl(idIncidenciaSupCC, SupEntidadIncidenciaCC, SupConsecutivoIncidenciaCC, SupCategoriaIncidenciaCC, NombreSupIncidenciaCC, IdLineaIncidenciaCC, FechaRegistroSupIncidenciaCC, EstatusRevisionIncidenciaCC) values ('$IdInsidenciaSigiente','$NumeroSupervisorEntidad','$NumeroSupervisorConsecutivo','$NumeroSupervisorCategoria','$NombreSup','$lineaNegocio',NOW(),'$ProcedeReporte')"; 
                                    $res1 = mysqli_query($conexion, $sql1);  
                                    // $log->LogInfo("Valor de la variable sql1: " . var_export ($sql1, true));
                                    if ($res1 !== true) {
                                        $response["status"] = "error";
                                        $response["message"]= 'error al registrar los supervisores del reporte de incidencia para centro de control';
                                        return;
                                    }else{
                                        $response["status"]= "success";
                                        $response["message"]='El Reporte Se Realizó Correctamente';
                                    }
                                }else{
                                    $NumeroSup = $explodeLinea_Motivo[$i];
                                    $ExplodeNumeroSup = explode("-", $NumeroSup);
                                    $NumeroSupervisorEntidad = $ExplodeNumeroSup[0];
                                    $NumeroSupervisorConsecutivo = $ExplodeNumeroSup[1];
                                    $NumeroSupervisorCategoria = $ExplodeNumeroSup[2];
                                }
                            }else{
                                if (($i % 2) == 0) {
                                    $NumeroSup = $explodeLinea_Motivo[$i];
                                    $ExplodeNumeroSup = explode("-", $NumeroSup);
                                    $NumeroSupervisorEntidad = $ExplodeNumeroSup[0];
                                    $NumeroSupervisorConsecutivo = $ExplodeNumeroSup[1];
                                    $NumeroSupervisorCategoria = $ExplodeNumeroSup[2];
                                }else{
                                    $NombreSup = $explodeLinea_Motivo[$i];
                                    $sql1 = "INSERT INTO ReporteIncidenciaSupervisoresCentroControl(idIncidenciaSupCC, SupEntidadIncidenciaCC, SupConsecutivoIncidenciaCC, SupCategoriaIncidenciaCC, NombreSupIncidenciaCC, IdLineaIncidenciaCC, FechaRegistroSupIncidenciaCC, EstatusRevisionIncidenciaCC) values ('$IdInsidenciaSigiente','$NumeroSupervisorEntidad','$NumeroSupervisorConsecutivo','$NumeroSupervisorCategoria','$NombreSup','$lineaNegocio',NOW(),'$ProcedeReporte')"; 
                                    $res1 = mysqli_query($conexion, $sql1);  
                                    if ($res1 !== true) {
                                        $response["status"] = "error";
                                        $response["message"]='error al registrar los supervisores del reporte de incidencia para centro de control2';
                                        return;
                                    }else{
                                        $response["status"]= "success";
                                        $response["message"]='El Reporte Se Realizó Correctamente';
                                    }
                                }
                            }
                        }   
                    }  
                }   
            }

            $k = 0;
            $explodeHoy = explode(" ",$hoy);
            $fechaHoy = $explodeHoy[0];
            $FolioIncidencia1 = "CGIF-AI-".$IdInsidenciaSigiente."-".$fechaHoy."_";
            for($j=1; $j <=11 ; $j++){

                if($j == "1"){$TipoDocumentoText = "INE DE INVOLUCRADOS";}
                else if($j == "2"){$TipoDocumentoText = "TICKET DE IMPORTE DE MERCANCIA";}
                else if($j == "3"){$TipoDocumentoText = "COTIZACIÓN";}
                else if($j == "4"){$TipoDocumentoText = "FICHA DE DEPOSITO";}
                else if($j == "5"){$TipoDocumentoText = "FACTURA";}
                else if($j == "6"){$TipoDocumentoText = "PAPELETA DE DESCUENTO";}
                else if($j == "7"){$TipoDocumentoText = "EVIDENCIA FOTOGRAFICA";}
                else if($j == "8"){$TipoDocumentoText = "DECTAMEN DE ASEGURADORA";}
                else if($j == "9"){$TipoDocumentoText = "RECONOCIMIENTO";}
                else if($j == "10"){$TipoDocumentoText= "ACTA ADMINISTRATIVA";}
                else if($j == "11"){$TipoDocumentoText= "DENUNCIA ANTE AUTORIDADES";}

                $contadorDocCargados=0;
                
                foreach($_FILES["Doc".$j]['tmp_name'] as $key => $tmp_name){

                    $tipoArchivo=$_FILES["Doc".$j]['type'][$contadorDocCargados];
                    if($tipoArchivo=="image/jpeg"){
                        $ext = ".jpg";
                    }else{
                        $ext = ".png";
                    }
                    if($_FILES["Doc".$j]["name"][$key]){
                        $filename  = $_FILES["Doc".$j]["name"][$key]; //Obtenemos el nombre original del archivo
                        $directorio= "../uploads/DocumentosReporteIncidenciaCentroControl";
                        $nombrearchivo1=$FolioIncidencia1.$k;
                        $nombrearchivo = $nombrearchivo1.$ext;
                        $idDoc="Doc".$j;


                        if($idDoc=="Doc7"){
                            $sumaDocumentos= count($_FILES["Doc".$j]["name"]);
                            if($sumaDocumentos!=0){
                                $w=$key;
                                $source = $_FILES["Doc".$j]["tmp_name"][$w]; //Obtenemos un nombre temporal del archivo   
                                $nombrearchivo = $nombrearchivo1.'_'.$w.$ext;

                                if(!file_exists($directorio)){
                                    mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");     
                                }
                                $dir=opendir($directorio); //Abrimos el directorio de destino
                                $target_path = $directorio.'/'.$nombrearchivo; //Indicamos la ruta de destino, así como el nombre del archivo
                                if(!move_uploaded_file($source, $target_path)){ 
                                    $response["status"] = "error";
                                    $response["message"]= "Error al subir archivos de evidencia";
                                }
                                closedir($dir);
                                $sql3 = "INSERT INTO ReporteIncidenciaDocumentosCentroControl(idIncidenciaDocCC, NombreDocIncidenciaCC, TipoDescripcionIncidenciaCC, IdTipoIncidenciaDoc,FechaRegistroDocIncidenciaCC) VALUES ('$IdInsidenciaSigiente','$nombrearchivo','$TipoDocumentoText','$IncidenciaAceptacion',NOW())"; 
                                $log->LogInfo("Valor de la variable sql3: " . var_export ($sql3, true));
                                $res3 = mysqli_query($conexion, $sql3); 
                                
                                if ($res3 !== true) {
                                    $response["status"] = "error";
                                    $response["message"]='error al registrar los supervisores del reporte de incidencia para centro de control';
                                    return;
                                }else{
                                    $response["status"]= "success";
                                    $response["message"]='El Reporte Se Realizó Correctamente1';
                                }
                                $log->LogInfo("Valor de la variable response[status]: " . var_export ($response["status"], true));
                                $log->LogInfo("Valor de la variable response[message]: " . var_export ($response["message"], true));
                            }
                                
                        }else{
                            $source    = $_FILES["Doc".$j]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo  
                            if(!file_exists($directorio)){
                                mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");     
                            }
                            $dir=opendir($directorio); //Abrimos el directorio de destino
                            $target_path = $directorio.'/'.$nombrearchivo; //Indicamos la ruta de destino, así como el nombre del archivo
                            if(!move_uploaded_file($source, $target_path)){ 
                                $response["status"] = "error";
                                $response["message"]= "Error al subir archivos";
                            }
                            closedir($dir);//Cerramos el directorio de destino
                            $sql2 = "INSERT INTO ReporteIncidenciaDocumentosCentroControl(idIncidenciaDocCC, NombreDocIncidenciaCC, TipoDescripcionIncidenciaCC, IdTipoIncidenciaDoc, FechaRegistroDocIncidenciaCC) values ('$IdInsidenciaSigiente','$nombrearchivo','$TipoDocumentoText','$IncidenciaAceptacion',NOW())"; 
                            $res2 = mysqli_query($conexion, $sql2); 
                            $log->LogInfo("Valor de la variable sql2: " . var_export ($sql2, true));
                            if ($res2 !== true) {
                                $response["status"] = "error";
                                $response["message"]='error al registrar los supervisores del reporte de incidencia para centro de control';
                                return;
                            }else{
                                $response["status"]= "success";
                                $response["message"]='El Reporte Se Realizó Correctamente2';
                            }
                            $log->LogInfo("Valor de la variable response[status]: " . var_export ($response["status"], true));
                            $log->LogInfo("Valor de la variable response[message]: " . var_export ($response["message"], true));
                            $k= $k+1;
                        }//else
                    }//if files
                    $contadorDocCargados++;
                }//for each
            }//for j
        }
    }
}catch (Exception $e) {    
    $response["status"]="error";
    $response["error"]="No se registró el reporte de incidencia para centro de control";
}
$log->LogInfo("Valor de la variable response[status]: " . var_export ($response["status"], true));
$log->LogInfo("Valor de la variable response[message]: " . var_export ($response["message"], true));
$log->LogInfo("Valor de la variable response " . var_export ($response, true));
echo json_encode($response);
?>