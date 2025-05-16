<?php

session_start ();

require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion($negocio);

//$log = new KLogger ( "ajax_uploadDeudores.log" , KLogger::DEBUG );
// Obtenemos los datos del empleado
//$log->LogInfo("Valor de la variable POST: " . var_export ($_POST, true));

$tipo=$_POST["tipo"];
$documento=$_POST["documento"];

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{

        //$log->LogInfo("Valor de la variable \$tipo: " . var_export ($tipo, true));
        $keyOfFileUpload = $documento;
        if($documento=="fonacotFini"){
            $target_dir = dirname (__FILE__) . 
            DIRECTORY_SEPARATOR . "uploads" . 
            DIRECTORY_SEPARATOR . "documentosContabilidad" . 
            DIRECTORY_SEPARATOR . "Fonacot" . 
            DIRECTORY_SEPARATOR;

        }else if($documento=="deudorInfonavitF"){
            $target_dir = dirname (__FILE__) . 
            DIRECTORY_SEPARATOR . "uploads" . 
            DIRECTORY_SEPARATOR . "documentosContabilidad" . 
            DIRECTORY_SEPARATOR . "Amortizacion" . 
            DIRECTORY_SEPARATOR;

        }else if($documento=="deudorPensionF"){
            $target_dir = dirname (__FILE__) . 
            DIRECTORY_SEPARATOR . "uploads" . 
            DIRECTORY_SEPARATOR . "documentosContabilidad" . 
            DIRECTORY_SEPARATOR . "Pension" . 
            DIRECTORY_SEPARATOR;

        }else if($documento=="prestamosF"){
            $target_dir = dirname (__FILE__) . 
            DIRECTORY_SEPARATOR . "uploads" . 
            DIRECTORY_SEPARATOR . "documentosContabilidad" . 
            DIRECTORY_SEPARATOR . "Prestamo" . 
            DIRECTORY_SEPARATOR;

        }else{
            $target_dir = dirname (__FILE__) . 
            DIRECTORY_SEPARATOR . "uploads" . 
            DIRECTORY_SEPARATOR . "documentosContabilidad" . 
            DIRECTORY_SEPARATOR;

        } 

        if($documento=="fonacotFini" || $documento=="deudorInfonavitF" || $documento=="deudorPensionF" || $documento=="prestamosF"){
            $idUltimoArchivo = $negocio -> obtenerIdUltimoArchivoDeudoresFini($tipo);
            $contador = $idUltimoArchivo[0]['contador']; 
            $Anexo = $contador+1;
            $target_file = $target_dir . $tipo . $Anexo;
            $NombreCompuesto = $tipo . $Anexo;
            $NombreOriginal = $tipo;
            $negocio -> GuardarIdUltimoArchivoDeudoresFini($documento,$target_dir,$NombreCompuesto,$NombreOriginal);
        }else{
            $target_file = $target_dir . $tipo;
        }      
            
       
        //obtenemos el archivo a subir
        //$file = $_FILES['documentoDeudores'];
     
        //comprobamos si existe un directorio para subir el archivo
        //si no es así, lo creamos

        if (!is_uploaded_file($_FILES[$keyOfFileUpload]['tmp_name']))
        {
            echo "<script>alert('Error en archivo');location.href ='/zonacgg/Vista/usuarioLogeado.php';</script>";
            
            exit;
        }

        if (!move_uploaded_file($_FILES[$keyOfFileUpload]["tmp_name"], $target_file.".xlsx")) 
        {   
            sleep(3);//retrasamos la petición 3 segundos
            echo "<script>alert('Error en el servidor');location.href ='/zonacgg/Vista/usuarioLogeado.php';</script>";
       //$log->LogInfo("hola no se movio");//devolvemos el nombre del archivo para pintar la imagen
        }
        //$direccion="/uploads/prueba/";
        //$direccion.=$numeroEmpleadoEntidad.$numeroEmpleadoConsecutivo.$numeroEmpleadoTipo.".jpeg";
        //$log->LogInfo("Valor de la variable \$target_file: " . var_export ($target_file, true));
    


    //comprobamos si el archivo ha subido
    
}else{
    throw new Exception("Error Processing Request", 1);   
}

?> 