<?php

session_start ();

require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion($negocio);

//$log = new KLogger ( "ajax_uploadCapa.log" , KLogger::DEBUG );
// Obtenemos los datos del empleado

$tipo=$_POST["tipo"];

if($tipo=='capacitacion'){    
    $cliente=$_POST["cliente"];
}

if($tipo=='permisoL'){    
    $entidad=$_POST["entidad"];
}

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{

    //$log->LogInfo("Valor de la variable \$tipo: " . var_export ($tipo, true));
        $keyOfFileUpload = $tipo;


        $target_dir = dirname (__FILE__) . 
            DIRECTORY_SEPARATOR . "uploads" . 
            DIRECTORY_SEPARATOR . "otrosDocumentos" .            
            DIRECTORY_SEPARATOR;

            
        if($tipo=='capacitacion'){
            $tipo.="_".$cliente;
        } 

        if($tipo=='permisoL'){
            $tipo.="_".$entidad;
        } 
        
        $target_file = $target_dir .$tipo;
       
        //obtenemos el archivo a subir        
     
        //comprobamos si existe un directorio para subir el archivo
        //si no es así, lo creamos

        if (!is_uploaded_file($_FILES[$keyOfFileUpload]['tmp_name']))
        {
            echo "<script>alert('Error en archivo');location.href ='/zonacgg/Vista/usuarioLogeado.php';</script>";
            
            exit;
        }

        if (!move_uploaded_file($_FILES[$keyOfFileUpload]["tmp_name"], $target_file.".pdf")) 
        {   
            sleep(3);//retrasamos la petición 3 segundos
            echo "<script>alert('Error en el servidor');location.href ='/zonacgg/Vista/usuarioLogeado.php';</script>";
       //$log->LogInfo("hola no se movio");//devolvemos el nombre del archivo para pintar la imagen
        }
        //$direccion="/uploads/prueba/";                                                                                                                                                                                                                                                                                                                                                                                                                                              
    //comprobamos si el archivo ha subido
    
}else{
    throw new Exception("Error Processing Request", 1);   
}

?> 