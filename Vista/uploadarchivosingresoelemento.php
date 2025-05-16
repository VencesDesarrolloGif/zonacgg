<?php

session_start ();

require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion($negocio);
// Obtenemos los datos del empleado
//$log = new KLogger ( "ajaxuploadarchivosingresos.log" , KLogger::DEBUG );
$docdigitalizadoo3=$_FILES["docdigitalizadoo3"]['type'][0];
$iteracion=4;
$response = array ();
$response["status"] = "success";  
//$permitidos= "application/pdf";
$correcto=true;
/*$num=count($_FILES["docdigitalizado0"]['type']);
$num2=count($_FILES["docdigitalizado1"]['type']);
$totalarchivos=($num+$num2);*/
$numeroEmpleado=$_POST["NumeroEmpleadoModa"];
$explodenumemp=explode("-",$numeroEmpleado);
$entidadEmpleado=$explodenumemp[0];
$consecutivoEmpleado=$explodenumemp[1];
$categoriaEmpleado=$explodenumemp[2];
//$valorsiexistelicencia=$_POST["licenciaConducir"];

//$log->LogInfo("Valor de la variable \$docdigitalizadoo3 : " . var_export ($docdigitalizadoo3, true));
if($docdigitalizadoo3===""){
$iteracion=3;
}



//$listaDeDOcumentos=$negocio -> negocio_listarDocumentosDigitalizados($entidadEmpleado,$consecutivoEmpleado,$categoriaEmpleado);


    for($a=0;$a<$iteracion;$a++)
    {
        $valor=$_FILES["docdigitalizadoo".$a]['type'][0];
    if(!$correcto)
    {
        $response["status"] = "error";
        $response ["message"] = "Tipos de arhivos incorrecto o limite excedido";
    }
    else
    {
        foreach($_FILES["docdigitalizadoo".$a]['tmp_name'] as $key => $tmp_name)
        {
            if($_FILES["docdigitalizadoo".$a]["name"][$key])
            {
                $filename = $_FILES["docdigitalizadoo".$a]["name"][$key]; //Obtenemos el nombre original del archivo
                $source = $_FILES["docdigitalizadoo".$a]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
                $directorio = dirname (__FILE__).'\\'.'uploads\\documentosdigitalizados\\'; //Declaramos un  variable con la ruta donde guardaremos los archivos
                //Validamos si la ruta de destino existe, en caso de no existir la creamos
             
                if(!file_exists($directorio))
                {
                    mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
                }
                $dir=opendir($directorio); //Abrimos el directorio de destino
                $target_path = $directorio .  date("Ymd_His") . "_" . sha1(basename($filename)); //Indicamos la ruta de destino, así como el nombre del archivo
                if(!move_uploaded_file($source, $target_path)) 
                { 
                    $response["status"] = "error";
                    $response ["message"] = "Error al subir archivos";
                }
                closedir($dir); //Cerramos el directorio de destino
            }
if($a==0){
$documentoId=7;
}
if($a==1){
$documentoId=12;
}
if($a==2){
$documentoId=9;
}
if($a==3){
$documentoId=13;
}
$documentacion = array (
    "empleadoEntidadFederativaId" => $entidadEmpleado,
    "empleadoConsecutivo" => $consecutivoEmpleado,
    "empleadoCategoriaId" => $categoriaEmpleado,
    "documentoId" => $documentoId,//el id de documento el mismo que el catalogo es decir Licencia tiene el id 13.
    "tipoDocumentoId" => 1,
    "documentoEstatusId" => 1,
    "nombreArchivoSeleccionado" => $filename,
    "nombreArchivoGuardado" => $target_path
);
$numeroEmpleadoId = array (
    "entidadFederativaId" => $entidadEmpleado,
    "consecutivo" => $consecutivoEmpleado,
    "categoriaId" => $categoriaEmpleado
    );

$listaDocumentosDigitalizados = $negocio -> negocio_obtenerDocumentosDigitalizados ($numeroEmpleadoId, $documentoId);
//$log->LogInfo("Valor de la variable \$count : " . var_export (count($listaDocumentosDigitalizados), true));
for($i=0;$i<count($listaDocumentosDigitalizados);$i++){
$rutaArchivo=$listaDocumentosDigitalizados[$i]["RutaArchivo"];
unlink($rutaArchivo); 
}
 //$negocio -> negocio_deleteRegistrosDocumentosDigitalizados($numeroEmpleadoId, $documentoId);
$negocio -> negocio_registrarDocumentosDigitalizados($documentacion);
        }
    }

 }
if( $response["status"] =='success'){
   //   $log->LogInfo("Valor de la fecha: " . var_export ($fecha, true));
    $response["message"]='Archivos subidos correctamente';
    //unlink("C:/wamp/www/zonagif/Vista/uploads/documentosdigitalizados/20180722_013855_785b2b1ad2c09cb283f233df1b3916d05064a1a4");    
}
//$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
echo json_encode($response);

?> 