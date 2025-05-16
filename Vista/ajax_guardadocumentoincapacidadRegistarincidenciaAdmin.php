<?php
session_start ();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion($negocio); 
// $log = new KLogger ( "ajax_guardadocumentoincapacidadRegistarincidenciaAdmin.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable tipo: " . var_export ($_POST, true));
// Obtenemos los datos del empleado
$response = array ();
$opcion=$_POST['opcion'];
$folioIncapacidad = getValueFromPost ("folioIncapacidad");
$tipoIncapacidad = getValueFromPost ("tipoIncapacidad");
$diasIncapacidad = getValueFromPost ("diasIncapacidad");
$empleado ["entidadId"] = getValueFromPost ("empleadoEntidadId");
$empleado ["consecutivoId"] = getValueFromPost ("empleadoConsecutivoId");
$empleado ["tipoId"] = getValueFromPost ("empleadoTipoId");
$empleado ["puntoServicioId"] = getValueFromPost ("empleadoPuntoServicioId");
$supervisor ["entidadId"] = getValueFromPost ("supervisorEntidadId");
$supervisor ["consecutivoId"] = getValueFromPost ("supervisorConsecutivoId");
$supervisor ["tipoId"] = getValueFromPost ("supervisorTipoId");
$incidenciaId = getValueFromPost ("incidenciaId");
$asistenciaFecha = getValueFromPost ("asistenciaFecha");
$comentariIncidencia=strtoupper(getValueFromPost ("comentariIncidencia"));
$usuarioCapturaAsistencia = $_SESSION ["userLog"]["usuario"];
$tipoPeriodo=getValueFromPost ("tipoPeriodo");
$puestoCubiertoId=getValueFromPost("puestoCubiertoId");
$idCliente=getValueFromPost("idCliente");
$valordia=getValueFromPost("valordia");//1 si es de dia 2 si es de noche 0 si es 24X24
$plantilladeservicio=getValueFromPost("plantilladeservicio");//roloperativo
$idPlantillaServicio=getValueFromPost("idPlantillaServicio");//Id plantilla
$idlineanegocioPunto=getValueFromPost("idlineanegocioPunto");//Linea
if($diasIncapacidad != ""){
    $rangofechafinal = strtotime('+'.($diasIncapacidad-1).' days', strtotime($asistenciaFecha));
}else{
    $rangofechafinal = strtotime('+'.($diasIncapacidad).' days', strtotime($asistenciaFecha));
}
$fechafinalincidencia = date ('Y-m-d', $rangofechafinal);
$st7 = getValueFromPost("st7");
$st2 = getValueFromPost("st2");
$supervisor_entidadId = getValueFromPost ("supervisorEntidadId");
$supervisor_consecutivoId = getValueFromPost ("supervisorConsecutivoId");
$supervisor_tipoId = getValueFromPost ("supervisorTipoId");
if($supervisor_entidadId =="09" && $supervisor_consecutivoId =="0017" && $supervisor_tipoId=="02"){
    $CondicionFecha='1';
}else{
    $Vigenciaplantilla = $negocio -> consultaVigenciaplantilla($idPlantillaServicio);
    // $log->LogInfo("Valor de la variable Vigenciaplantilla: " . var_export ($Vigenciaplantilla, true));
    $fecha_actual1 = $asistenciaFecha;
    // $log->LogInfo("Valor de la variable fecha_actual1: " . var_export ($fecha_actual1, true));
    $Fechaplantilla1 = $Vigenciaplantilla[0]["fechaTerminoPlantilla"]; 
    // $log->LogInfo("Valor de la variable Fechaplantilla1: " . var_export ($Fechaplantilla1, true));
    $fecha_actual = explode('-', $fecha_actual1);
    // $log->LogInfo("Valor de la variable fecha_actual: " . var_export ($fecha_actual, true));
    $fecha_actual_Anio = $fecha_actual[0];
    $fecha_actual_Mes = $fecha_actual[1];
    $fecha_actual_Dia = $fecha_actual[2];
    $Fechaplantilla = explode('-', $Fechaplantilla1);
    // $log->LogInfo("Valor de la variable Fechaplantilla: " . var_export ($Fechaplantilla, true));
    $Fechaplantilla_Anio = $Fechaplantilla[0];
    $Fechaplantilla_Mes = $Fechaplantilla[1];
    $Fechaplantilla_Dia = $Fechaplantilla[2];
    if($Fechaplantilla_Anio > $fecha_actual_Anio){
        $CondicionFecha = "1";
    }else{
        if($Fechaplantilla_Mes > $fecha_actual_Mes){
            $CondicionFecha = "1";
        }else{
            if($Fechaplantilla_Dia >= $fecha_actual_Dia){
                $CondicionFecha = "1";
            }else{
                $CondicionFecha = "0";
            }
        }
    }
}
if($CondicionFecha=="1"){
    if($st7==""){
        $st7="0";
    }
    if($st2==""){
        $st2="0";
    }
    $empleado ["st7"] = $st7;//st7
    $empleado ["st2"]  = $st2;//st2
    if($opcion==0){
        $response["status"] = "success1";
        $response ["message"] ="";
        $resultado=$negocio -> insertandupdatefolioincapacidadAdmin($folioIncapacidad,$asistenciaFecha,$fechafinalincidencia,$empleado,$tipoIncapacidad,$diasIncapacidad,$opcion);
        if(count($resultado)!=0){
            $response["status"] = "error1";
            $response ["message"] = "El número de folio ya se encuentra registrado";
        }      
    }else if($opcion==1){
        $response["status"] = "success";
        $permitidospdf= "application/pdf";
        $permitidosjpeg= "image/jpeg";
        $permitidospng= "application/png";
        $permitidosjpg= "application/jpg";
        $correcto=true;
        $num=count($_FILES["docuincapacidad"]['type']);
        for($a=0;$a<$num;$a++){
            $valor=$_FILES["docuincapacidad"]['type'][$a];
        // $log->LogInfo("Valor de la variable tipo: " . var_export ($valor, true));
            if($valor!=$permitidospdf && $valor!=$permitidosjpeg && $valor!=$permitidospng && $valor!=$permitidosjpg){
                $correcto=false;
                break;
            }
        }
        if(!$correcto){
            $response["status"] = "error";
            $response ["message"] = "Tipos de arhivo Incapacidad incorrecto o limite excedido";
        }else{
            $extencionArchivo= explode("/", $_FILES["docuincapacidad"]['type'][0]);    
            $extencionArchivooriginal=$extencionArchivo[1];
            foreach($_FILES["docuincapacidad"]['tmp_name'] as $key => $tmp_name)
            {
                if($_FILES["docuincapacidad"]["name"][$key]) {
                    $filename = $_FILES["docuincapacidad"]["name"][$key]; //Obtenemos el nombre original del archivo
                    $source = $_FILES["docuincapacidad"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
                    $directorio = 'uploads/DocumentosIncapacidad/'.$empleado ["entidadId"]."-". $empleado ["consecutivoId"]."-".$empleado ["tipoId"]."/"; //Declaramos un  variable con la ruta donde guardaremos los archivos
                    if(!file_exists($directorio)){
                        mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
                    }
                    $dir=opendir($directorio); //Abrimos el directorio de destino
                    $target_path = $directorio.'/'.$folioIncapacidad."_INC-".$tipoIncapacidad."_".$asistenciaFecha."_".$fechafinalincidencia.".".$extencionArchivooriginal; //Indicamos la ruta de destino, así como el nombre del archivo
                    if(!move_uploaded_file($source, $target_path)) { 
                        $response["status"] = "error";
                        $response ["message"] = "Error al subir archivos incapacidad";
                    }
                    closedir($dir); //Cerramos el directorio de destino
                }
            }
        }
        if( $response["status"] =='success'){
            $response["message"]='Se Registro Incapacidad correctamente';
            $asistenciaFecha = date($asistenciaFecha);
        
            for($i=0;$i<$diasIncapacidad;$i++){
                $fechaasistencia = strtotime('+'.$i.' days', strtotime($asistenciaFecha));
                $fechaasistencia = date ('Y-m-d', $fechaasistencia);
        
               $respuesta= $negocio -> registrarAsistencia (
                    $empleado, 
                    $supervisor, 
                    $incidenciaId, 
                    $fechaasistencia, 
                    $usuarioCapturaAsistencia,
                    $comentariIncidencia,
                    $tipoPeriodo, $puestoCubiertoId,$plantilladeservicio,$idPlantillaServicio);
        
           // $log->LogInfo("Valor de la variable respuesta: " . var_export ($respuesta, true));
            }
        //update para agregar el folio en asistencia e insert en la nueva tabla de folio 
            $negocio -> insertandupdatefolioincapacidadAdmin($folioIncapacidad,$asistenciaFecha,$fechafinalincidencia,$empleado,$tipoIncapacidad,$diasIncapacidad,$opcion);
        }
    }else if($opcion==2){
        $response["status"] ='success2';
        $response["message"]='';
        $conteoincapacidades2= $negocio -> insertandupdatefolioincapacidadAdmin($folioIncapacidad,$asistenciaFecha,$fechafinalincidencia,$empleado,$tipoIncapacidad,$diasIncapacidad,$opcion);
        if(count($conteoincapacidades2)!=0){
           $response["idincapacidad"]= $conteoincapacidades2[0]["tipoIncapacidad"];
           $response["st7"]= $conteoincapacidades2[0]["st7"];
           $response["st2"]= $conteoincapacidades2[0]["st2"];
    
        }else{
            $response["idincapacidad"]="";
            $response["st7"]= null;
            $response["st2"]= null;
        }
    }else if($opcion==3){//opcion para subir el st7
        $response["status"] = "success";
        $permitidospdf= "application/pdf";
        $permitidosjpeg= "image/jpeg";
        $permitidospng= "application/png";
        $permitidosjpg= "application/jpg";
        $correcto=true;
        $num=count($_FILES["docust7"]['type']);
        for($a=0;$a<$num;$a++){
            $valor=$_FILES["docust7"]['type'][$a];
        // $log->LogInfo("Valor de la variable tipo: " . var_export ($valor, true));
            if($valor!=$permitidospdf && $valor!=$permitidosjpeg && $valor!=$permitidospng && $valor!=$permitidosjpg){
                $correcto=false;
                break;
            }
        }
        if(!$correcto){
            $response["status"] = "error";
            $response ["message"] = "Tipos de arhivos st7 sincorrecto o limite excedido";
        }else{
            $extencionArchivo= explode("/", $_FILES["docust7"]['type'][0]);    
            $extencionArchivooriginal=$extencionArchivo[1];
            foreach($_FILES["docust7"]['tmp_name'] as $key => $tmp_name)
            {
                if($_FILES["docust7"]["name"][$key]) {
                    $filename = $_FILES["docust7"]["name"][$key]; //Obtenemos el nombre original del archivo
                    $source = $_FILES["docust7"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
                    $directorio = 'uploads/DocumentosIncapacidad/'.$empleado ["entidadId"]."-". $empleado ["consecutivoId"]."-".$empleado ["tipoId"]."/"; //Declaramos un  variable con la ruta donde guardaremos los archivos
                    if(!file_exists($directorio)){
                        mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
                    }
                    $dir=opendir($directorio); //Abrimos el directorio de destino
                    $target_path = $directorio.'/'.$folioIncapacidad."_ST7_".$tipoIncapacidad."_".$asistenciaFecha."_".$fechafinalincidencia.".".$extencionArchivooriginal; //Indicamos la ruta de destino, así como el nombre del archivo
                    if(!move_uploaded_file($source, $target_path)) { 
                        $response["status"] = "error";
                        $response ["message"] = "Error al subir archivos st7";
                    }
                    closedir($dir); //Cerramos el directorio de destino
                }
            }
        }
    }else if($opcion==4){
        $response["status"] = "success";
        $permitidospdf= "application/pdf";
        $permitidosjpeg= "image/jpeg";
        $permitidospng= "application/png";
        $permitidosjpg= "application/jpg";
        $correcto=true;
        $num=count($_FILES["docust2"]['type']);
        for($a=0;$a<$num;$a++){
            $valor=$_FILES["docust2"]['type'][$a];
            if($valor!=$permitidospdf && $valor!=$permitidosjpeg && $valor!=$permitidospng && $valor!=$permitidosjpg){
                $correcto=false;
                break;
            }
        }
        if(!$correcto){
            $response["status"] = "error";
            $response ["message"] = "Tipos de arhivos st7 sincorrecto o limite excedido"; 
        }else{
            $extencionArchivo= explode("/", $_FILES["docust2"]['type'][0]);    
            $extencionArchivooriginal=$extencionArchivo[1];
            foreach($_FILES["docust2"]['tmp_name'] as $key => $tmp_name)
            {
                if($_FILES["docust2"]["name"][$key]) {
                    $filename = $_FILES["docust2"]["name"][$key]; //Obtenemos el nombre original del archivo
                    $source = $_FILES["docust2"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
                    $directorio = 'uploads/DocumentosIncapacidad/'.$empleado ["entidadId"]."-". $empleado ["consecutivoId"]."-".$empleado ["tipoId"]."/"; //Declaramos un  variable con la ruta donde guardaremos los archivos
                    if(!file_exists($directorio)){
                        mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
                    }
                    $dir=opendir($directorio); //Abrimos el directorio de destino
                    $target_path = $directorio.'/'.$folioIncapacidad."_ST2-".$tipoIncapacidad."_".$asistenciaFecha."_".$fechafinalincidencia.".".$extencionArchivooriginal; //Indicamos la ruta de destino, así como el nombre del archivo
                    if(!move_uploaded_file($source, $target_path)) { 
                        $response["status"] = "error";
                        $response ["message"] = "Error al subir archivos st7";
                    }
                    closedir($dir); //Cerramos el directorio de destino
                }
            }
        }
    }
}else{
    $response ["status"] = "error";
    $response ["message"] = "Error en la plantilla seleccionada, Ya culmino la vigencia de esta plantilla"; 
}
echo json_encode($response);

?> 