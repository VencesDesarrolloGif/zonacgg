<?php
/**
* @file     download_file.php
* @author   Daniel Martínez <dazenbit@gmail.com>
* 
* Este archivo proporciona la funcionalidad para descargar un archivo de los documentos digitalizados
*/
session_start ();

require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");

$negocio = new Negocio();

verificarInicioSesion($negocio);



$id = isset ($_GET ["id"]) ? $_GET ["id"] : "";

if (empty ($id))
{
    exit;
}


$documento =$negocio -> negocio_obtenerDocumentoDigitalizado ($id);

if ($documento == null)
{
    exit;
}

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$fileinfo = finfo_file($finfo, $documento ["nombreArchivoGuardado"]);
finfo_close($finfo);       

$size   = filesize($documento["nombreArchivoGuardado"]);

header('Content-Description: File Transfer');
header('Content-Type: ' . $fileinfo);
header('Content-Disposition: attachment; filename=' . $documento["nombreArchivoSeleccionado"]); 
header('Content-Transfer-Encoding: binary');
header('Connection: Keep-Alive');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . $size);
readfile($documento["nombreArchivoGuardado"]);