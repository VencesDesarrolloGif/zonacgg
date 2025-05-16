<?php

session_start ();

require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion($negocio);
//$log = new KLogger ( "AJAX_UPLOADRESPONSIVACAJA.log" , KLogger::DEBUG );
// Obtenemos los datos del empleado
$response = array ();
$entidademp=$_POST["entidademp"];
$consecutivo =$_POST["consecutivo"];
$categoriaemp=$_POST["categoriaemp"];
$fecha_dia= date('d');
$fecha_mes=date('m');
$fecha_anio=date('Y');
$fechActual=($fecha_dia.$fecha_mes.$fecha_anio);
$response["status"] = "success";
    $empleadoCaja= $negocio -> negocio_obtenerEmpleadoAuthCaja($entidademp, $consecutivo, $categoriaemp);//funcion consulta el ultimo id insertado por empleado
//$response["empleado"]= $empleado;
$id=($empleadoCaja["numero"]+1);
       // $log->LogInfo("Valor de variable de fecha_actual " . var_export ($fechActual, true));
$permitidos= "application/pdf";
$correcto=true;
//$log->LogInfo("Valor de la variable file: " . var_export ($_FILES["docuAfil06"], true));
$num=count($_FILES["docuaAbono"]['type']);
for($a=0;$a<$num;$a++){
    $valor=$_FILES["docuaAbono"]['type'][$a];
    //$log->LogInfo("Valor de la variable tipo: " . var_export ($valor, true));
    if($valor!=$permitidos){
        $correcto=false;
        break;
    }
}
if(!$correcto){
    $response["status"] = "error";
    $response ["message"] = "Tipos de arhivos incorrecto o limite excedido";
}else{
    foreach($_FILES["docuaAbono"]['tmp_name'] as $key => $tmp_name)
    {
        //Validamos que el archivo exista
        if($_FILES["docuaAbono"]["name"][$key]) {
            $filename = $_FILES["docuaAbono"]["name"][$key]; //Obtenemos el nombre original del archivo
            $source = $_FILES["docuaAbono"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
            $directorio = 'uploads/responsivascajas/'.$entidademp."_".$consecutivo."_".$categoriaemp."/"; //Declaramos un  variable con la ruta donde guardaremos los archivos       
            //Validamos si la ruta de destino existe, en caso de no existir la creamos
            if(!file_exists($directorio)){
                mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
            } 
            $dir=opendir($directorio); //Abrimos el directorio de destino
            $target_path = $directorio.$entidademp.$consecutivo.$categoriaemp."_".$fechActual."_".$id.".pdf"; //Indicamos la ruta de destino, así como el nombre del archivo
            //Movemos y validamos que el archivo se haya cargado correctamente
            //El primer campo es el origen y el segundo el destino
            if(!move_uploaded_file($source, $target_path)) { 
                $response["status"] = "error";
                $response ["message"] = "Error al subir archivos";
            }
            closedir($dir); //Cerramos el directorio de destino
        }
    }
        $negocio -> negocio_insertAuthCaja($entidademp, $consecutivo, $categoriaemp,$id);//funcion para insertar
}

if( $response["status"] =='success'){
    $response["message"]='Archivos subidos correctamente';
}
//$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
echo json_encode($response);

?> 