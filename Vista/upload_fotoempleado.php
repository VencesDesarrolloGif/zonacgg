<?php

session_start ();

require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");

$negocio = new Negocio();

verificarInicioSesion($negocio);

$type = (isset($_POST ["type"]) ? "Edited"  : "");

$keyOfFileUpload = "fileFotoEmpleado" . $type;

$base_file_name = 
    date("Ymd_His") . "_" . 
    sha1(basename($_FILES[$keyOfFileUpload]["name"])) . ".jpg";


$target_dir = dirname (__FILE__) . 
    DIRECTORY_SEPARATOR . "uploads" . 
    DIRECTORY_SEPARATOR . "fotosempleados" . 
    DIRECTORY_SEPARATOR;
    
$target_file = $target_dir . $base_file_name;

$archivo = $_FILES[$keyOfFileUpload]["name"];
$temporal = $_FILES[$keyOfFileUpload]["tmp_name"];


if (!is_uploaded_file($_FILES[$keyOfFileUpload]['tmp_name']))
{
    $response = array (
        "status" => "error",
        "message" => "El archivo no pudo subirse en el servidor. Probablemente el archivo es mayor al limite permitido."
    );
    
    echo json_encode ($response);
    
    exit;
}

if (!move_uploaded_file($_FILES[$keyOfFileUpload]["tmp_name"], $target_file)) 
{
    $response = array (
        "status" => "error",
        "message" => "El archivo no pudo guardarse en el servidor. Error del servidor o el archivo no es válido."
    );
    
    echo json_encode ($response);
    
    exit;
}




$finfo = finfo_open(FILEINFO_MIME_TYPE);
$fileinfo = finfo_file($finfo, $target_file);
finfo_close($finfo);

if ($fileinfo != "image/jpeg")
{
	unlink ($target_file);
	
	$response = array (
        "status" => "error",
        "message" => "El archivo no es un archivo de fotografia JPG. Por favor, verifique."
    );
    
    echo json_encode ($response);
    
    exit;
}





$thumb_file = dirname (__FILE__) . 
    DIRECTORY_SEPARATOR . "thumbs" . 
    DIRECTORY_SEPARATOR . $base_file_name;

// load image and get image size
$img = imagecreatefromjpeg( $target_file );
$width = imagesx( $img );
$height = imagesy( $img );

// calculate thumbnail size
if ($width > $height)
{
	$new_width = 200;
	$new_height = floor( $height * ( $new_width / $width ) );
}
else
{
	$new_height = 133;
	$new_width = floor( $width * ( $new_height / $height ) );
}

// create a new temporary image
$tmp_img = imagecreatetruecolor( $new_width, $new_height );

// copy and resize old image into new image
imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

// save thumbnail into a file
imagejpeg( $tmp_img, $thumb_file );
	  

$response = array (
        "status" => "ok",
		"file" => $base_file_name
    );

echo json_encode ($response);
?> 
