<?php

session_start ();

require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion($negocio);
// Obtenemos los datos del empleado
//$log = new KLogger ( "ajax_uploadpdf.log" , KLogger::DEBUG );
$response = array ();
$usuario = $_SESSION ["userLog"]["nombre"];
$fechamov=$_POST['fechamov'];
$NombreUsuario=$_POST['NombreUsuario'];
$CasePdf=$_POST['CasePdf'];
$response["status"] = "success";  
$i=0;
$permitidos= "application/pdf";
$correcto=true;
$num=count($_FILES["DocPdf"]['type']);
$numCargo=count($_FILES["DocPdfCargo"]['type']);
$idMovimiento = array ();
$idMovimiento = $negocio->negocio_obtenerultimoid();

if($CasePdf==0)
{
    for($a=0;$a<$num;$a++)
    {
        $valor=$_FILES["DocPdf"]['type'][$a];
        if($valor!=$permitidos)
        {
            $correcto=false;
            break;
        }
    }
    if(!$correcto)
    {
        $response["status"] = "error";
        $response ["message"] = "Tipos de arhivos incorrecto o limite excedido";
    }
    else
    {
        foreach($_FILES["DocPdf"]['tmp_name'] as $key => $tmp_name)
        {
            if($_FILES["DocPdf"]["name"][$key])
            {
                $filename = $_FILES["DocPdf"]["name"][$key]; //Obtenemos el nombre original del archivo
                $source = $_FILES["DocPdf"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
                $directorio = 'uploads/archivosFinanzas/abono/'; //Declaramos un  variable con la ruta donde guardaremos los archivos
                //Validamos si la ruta de destino existe, en caso de no existir la creamos
                if(!file_exists($directorio))
                {
                    mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
                }
                $dir=opendir($directorio); //Abrimos el directorio de destino
                $target_path = $directorio. $idMovimiento[0]["idMovimiento"] . "_" . $fechamov .".pdf"; //Indicamos la ruta de destino, así como el nombre del archivo
                $i++;
                if(!move_uploaded_file($source, $target_path)) 
                { 
                    $response["status"] = "error";
                    $response ["message"] = "Error al subir archivos";
                }
                closedir($dir); //Cerramos el directorio de destino
            }
        }
    }
}
else
{
    for($a=0;$a<$numCargo;$a++)
    {
        $valorCargo=$_FILES["DocPdfCargo"]['type'][$a];
        if($valorCargo!=$permitidos)
        {
            $correcto=false;
            break;
        }
    }
    if(!$correcto)
    {
        $response["status"] = "error";
        $response ["message"] = "Tipos de arhivos incorrecto o limite excedido";
    }
    else
    {
        foreach($_FILES["DocPdfCargo"]['tmp_name'] as $key => $tmp_name)
        {
            if($_FILES["DocPdfCargo"]["name"][$key])
            {
                $filename = $_FILES["DocPdfCargo"]["name"][$key]; //Obtenemos el nombre original del archivo
                $source1 = $_FILES["DocPdfCargo"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
                $directorio1 = 'uploads/archivosFinanzas/cargo/'; //Declaramos un  variable con la ruta donde guardaremos los archivos
                //Validamos si la ruta de destino existe, en caso de no existir la creamos
                if(!file_exists($directorio1))
                {
                    mkdir($directorio1, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
                }
                $dir1=opendir($directorio1); //Abrimos el directorio de destino
                $target_path1 = $directorio1. $idMovimiento[0]["idMovimiento"] . "_" . $fechamov .".pdf"; //Indicamos la ruta de destino, así como el nombre del archivo
                $i++;
                if(!move_uploaded_file($source1, $target_path1)) 
                { 
                    $response["status"] = "error";
                    $response ["message"] = "Error al subir archivos";
                }
                closedir($dir1); //Cerramos el directorio de destino
            }
        }
    }
}

if( $response["status"] =='success'){
   //   $log->LogInfo("Valor de la fecha: " . var_export ($fecha, true));
    $response["message"]='Archivos subidos correctamente';
}

//$log->LogInfo("Valor de la variable response: " . var_export ($response, true));

echo json_encode($response);

?> 