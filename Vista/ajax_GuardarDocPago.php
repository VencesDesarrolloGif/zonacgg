<?php
session_start ();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion($negocio); 
//$log = new KLogger ( "ajax_UploadDocumentospagos.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable tipo: " . var_export ($valor, true));
// Obtenemos los datos del empleado

$response = array ();
$numeroEmpleado = getValueFromPost("numeroEmpleado");
$nombreCompleto = getValueFromPost("nombreCompleto");
$entidadTrabajo = getValueFromPost("entidadTrabajo");
$roloperativo   = getValueFromPost("roloperativo");
$fechaActual    = date('d-m-Y');

    $response["status"] = "success";

    $permitidospdf = "application/pdf";
    $permitidosjpeg= "image/jpeg";
    $permitidospng = "application/png";
    $permitidosjpg = "application/jpg";
    $correcto=true;
    $num=count($_FILES["docPagoDeuda"]['type']);

    for($a=0;$a<$num;$a++){
        $valor=$_FILES["docPagoDeuda"]['type'][$a];
        if($valor!=$permitidospdf && $valor!=$permitidosjpeg && $valor!=$permitidospng && $valor!=$permitidosjpg){
            $correcto=false;
            break;
        }
    }
    if(!$correcto){
        $response["status"] = "error";
        $response ["message"] = "Tipos De Arhivos Vacaciones Incorrecto O Limite Excedido Revise El Documento Nuevamente";
     }else{
        $extencionArchivo= explode("/", $_FILES["docPagoDeuda"]['type'][0]);    
        $extencionArchivooriginal=$extencionArchivo[1];
        foreach($_FILES["docPagoDeuda"]['tmp_name'] as $key => $tmp_name)
        {
        //Validamos que el archivo exista
            if($_FILES["docPagoDeuda"]["name"][$key]) {
            $filename = $_FILES["docPagoDeuda"]["name"][$key]; //Obtenemos el nombre original del archivo
            $source = $_FILES["docPagoDeuda"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
            $directorio = 'uploads/DocumentosPagoDeudaReingreso/'.$numeroEmpleado."/"; //Declaramos un  variable con la ruta donde guardaremos los archivos
            
            //Validamos si la ruta de destino existe, en caso de no existir la creamos
            if(!file_exists($directorio)){
                mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
            }
            $dir=opendir($directorio); //Abrimos el directorio de destino
            //$NombreArchivo = "Vacaciones_".$nomenclaturaIncidencia."_".$peridosVacaciones."_".$inpdiasvacaciones;
            $target_path = $directorio.'/'."Pago_".$fechaActual.".".$extencionArchivooriginal; //Indicamos la ruta de destino, así como el nombre del archivo
            //Movemos y validamos que el archivo se haya cargado correctamente
            //El primer campo es el origen y el segundo el destino
            if(!move_uploaded_file($source, $target_path)) { 
                $response["status"] = "error";
                $response ["message"] = "Error al subir archivos De Vacaciones";
            }
            closedir($dir);//Cerramos el directorio de destino
        }
    }
    $response ["message"] = "Archivo Subido Correctamente";
    // $NombreTempArchivo ="Vacaciones_".$primerfecha."_".$RolOperativoVacaciones."_".$peridosVacaciones."_".$inpdiasvacaciones.".".$extencionArchivooriginal;
    $NombreTempArchivo1 ="Pago_".$fechaActual.".".$extencionArchivooriginal;
   // $log->LogInfo("Valor de la variable NombreTempArchivo: " . var_export ($NombreTempArchivo1, true));
    $negocio ->updateDatosDeuda($NombreTempArchivo1,$numeroEmpleado);
}
//$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
echo json_encode($response);
?> 