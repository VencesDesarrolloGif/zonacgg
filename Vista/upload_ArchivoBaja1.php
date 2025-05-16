<?php
session_start ();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion($negocio);
// Obtenemos los datos del empleado
//$log = new KLogger ( "upload_ArchivoBaja1.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _FILES : " . var_export ($_FILES, true));
//$log->LogInfo("Valor de la variable _POST : " . var_export ($_POST, true));
$response = array ();
$response["status"] = "success";  

$FechaBajaEmpModal=$_POST["FechaBajaEmpModal"];
$FechaBajaSolicitadaEmp=$_POST["FechaBajaSolicitadaEmp"];
$numeroEmpleado=$_POST["NumEmpModal"];
$explodenumemp=explode("-",$numeroEmpleado);
$entidadEmpleado=$explodenumemp[0];
$consecutivoEmpleado=$explodenumemp[1];
$categoriaEmpleado=$explodenumemp[2];
$usuarioCapturaBaja = $_SESSION ["userLog"]["usuario"];
foreach($_FILES["BajaEmpModal"]['tmp_name'] as $key => $tmp_name)
{
//$log->LogInfo("Valor de response" . var_export ($target_file, true));
    if ($_FILES["BajaEmpModal"]['tmp_name'][0]=="")
    {
        $response = array (
            "status" => "error",
            "message" => "No Se Encontro Archivo, Favor De Seleccionar El Archivo A Guardar"
        );
        echo json_encode ($response);
        exit;
    }

    if (!is_uploaded_file($_FILES["BajaEmpModal"]['tmp_name'][0]))
    {
        $response = array (
            "status" => "error",
            "message" => "El archivo no pudo subirse en el servidor. Probablemente el archivo es mayor al limite permitido."
        );
        echo json_encode ($response);
        exit;
    }
    $fileinfo = $_FILES["BajaEmpModal"]['type'][0];
    if ($fileinfo != "image/jpeg" && $fileinfo != "application/pdf" &&  $fileinfo != "image/png")
    { 
        $response = array (
            "status" => "error",
            "message" => "El archivo no es un archivo compatible .JPG, .PNG, .PDF  Por favor, verifique."
        );
        echo json_encode ($response);
        exit;
    }
    if($_FILES["BajaEmpModal"]["name"][$key])
    {
        $filename = $_FILES["BajaEmpModal"]["name"][$key]; //Obtenemos el nombre original del archivo
        $filenameExtencion=explode(".",$filename);
        $largoExtencion = count($filenameExtencion);
        $UltimaExtencion=$filenameExtencion[$largoExtencion-1];
        $source = $_FILES["BajaEmpModal"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo  
        $directorio = dirname (__FILE__).'\\'.'uploads\\ArchivosBaja\\'.$numeroEmpleado.'\\'; //Declaramos un  variable con la ruta donde guardaremos los archivos
        $NombrearchivoBaja = "ArchivoBaja_" . $FechaBajaSolicitadaEmp . "_" . $numeroEmpleado;
        //Validamos si la ruta de destino existe, en caso de no existir la creamos
        if(!file_exists($directorio))
        {
            mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
        }
        $dir=opendir($directorio); //Abrimos el directorio de destino
        $target_path = $directorio . $NombrearchivoBaja; //Indicamos la ruta de destino, así como el nombre del archivo
        if(!move_uploaded_file($source, $target_path)) 
        { 
            $response["status"] = "error";
            $response ["message"] = "Error al subir archivos"; 
        }
        closedir($dir); //Cerramos el directorio de destino
        $negocio -> InsertarRegistoArchivoBajaEmpleado($entidadEmpleado,$consecutivoEmpleado,$categoriaEmpleado,$FechaBajaEmpModal,$FechaBajaSolicitadaEmp,$NombrearchivoBaja,$usuarioCapturaBaja);

    }
}
if( $response["status"] =='success'){
    $response["message"]='Archivos subidos correctamente';
}
echo json_encode($response);

?> 