<?php
session_start ();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php"); 

$negocio = new Negocio();
verificarInicioSesion($negocio);
 //$log = new KLogger ( "ajax_uploadNomina.log" , KLogger::DEBUG );
 //$log->LogInfo("Valor de la variable Post: " . var_export ($_POST, true));
 //$log->LogInfo("Valor de la variable Files: " . var_export ($_FILES, true));
$response = array ();
$cliente=$_POST['cliente'];
$mesCFDI=$_POST['mesCFDI'];
$anio=$_POST['anio'];
$response["status"] = "success";
$i=0;
$permitidos= "application/pdf";
$permitidos1= "application/x-zip-compressed";
$permitidos2= "application/octet-stream";
$permitidos3= "text/xml";
$correcto=true;
$num=count($_FILES["docuNomina"]['type']);
for($a=0;$a<$num;$a++){
    $valor=$_FILES["docuNomina"]['type'][$a];
    if($valor!=$permitidos && $valor!=$permitidos1 && $valor!=$permitidos2 && $valor!=$permitidos3){
        $correcto=false;
        break;
    }
}

if(!$correcto){
    $response["status"] = "error";
    $response ["message"] = "Tipos de arhivos incorrecto o limite excedido";
}else{
    foreach($_FILES["docuNomina"]['tmp_name'] as $key => $tmp_name)
    {
        if($_FILES["docuNomina"]["name"][$key]) {
            $filename = $_FILES["docuNomina"]["name"][$key]; //Obtenemos el nombre original del archivo
            $source = $_FILES["docuNomina"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
            $directorio = 'uploads/nomina/'.$cliente."_".$mesCFDI."_".$anio."/"; //Declaramos un  variable con la ruta donde guardaremos los archivos
            if(!file_exists($directorio)){
                mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
            }
            $dir=opendir($directorio); //Abrimos el directorio de destino

            if($_FILES["docuNomina"]['type'][$i]== $permitidos || $_FILES["docuNomina"]['type'][$i]== $permitidos3){
                if($_FILES["docuNomina"]['type'][$i]== $permitidos){
                    $extencion = ".pdf";
                }else{
                    $extencion = ".xml";
                }
                // Obtenemos EL Nombre Original Y Lo Separamos por _ ya que esta es la estructura utilizada en este momento
                // se obtiene el Numero de empleado del Nombre original del archivo para realizar las consultas
                $ExplodeNombreOrigin = explode('_', $filename);
                $PeriodoQuincena = $ExplodeNombreOrigin[4];
                $NumeroempleadoOr1 = $ExplodeNombreOrigin[5];
                $NumeroempleadoOr2 = substr($NumeroempleadoOr1, 2, 1);
                    $SubNumero1= substr($NumeroempleadoOr1, 0, 2);
                    $SubNumero3= substr($NumeroempleadoOr1, 7, 2);
                if($NumeroempleadoOr2 =="0"){// Se Condiciona ya que el numero de empleado se rellena con un cero al no alcanzar la capacidad minima y necesitamos el numero real
                    $SubNumero2= substr($NumeroempleadoOr1, 3, 4);
                }else{
                    $SubNumero2= substr($NumeroempleadoOr1, 2, 5);
                }
                $NumeroempleadoOr = $SubNumero1."-".$SubNumero2."-".$SubNumero3;
                //$log->LogInfo("Valor de la variable NumeroempleadoOr: " . var_export ($NumeroempleadoOr, true));
                $Emp= $negocio -> negocio_obtenerDatosEmpleadoNomina($NumeroempleadoOr);
                //$log->LogInfo("Valor de la variable Emp: " . var_export ($Emp, true));
                $NombreEmpleado=$Emp[0]["NombreEmpleado"];
                $Entidad1=$Emp[0]["Entidad"];
                $Entidad = strtoupper($Entidad1);
                $NuevoNombre = $NombreEmpleado."_".$PeriodoQuincena."_".$NumeroempleadoOr."_".$Entidad;
                $NombreArchivo = "/".$NuevoNombre.$extencion;
            }else if($_FILES["docuNomina"]['type'][$i]== $permitidos1){
                $extencion = ".zip";
                $NombreArchivo = "/nomina".$i.$extencion;
            }else if($_FILES["docuNomina"]['type'][$i]== $permitidos2){
                $extencion = ".rar";
                $NombreArchivo = "/nomina".$i.$extencion;
            }

            $target_path = $directorio.$NombreArchivo; //Indicamos la ruta de destino, así como el nombre del archivo
            if(!move_uploaded_file($source, $target_path)) { 
                $response["status"] = "error";
                $response ["message"] = "Error al subir archivos";
            }
            closedir($dir); //Cerramos el directorio de destino
            $i++;
        }
    }
}

if( $response["status"] =='success'){
    $response["message"]='Archivo subidos correctamente';
}
// $log->LogInfo("Valor de la variable response: " . var_export ($response, true));

echo json_encode($response);

?> 