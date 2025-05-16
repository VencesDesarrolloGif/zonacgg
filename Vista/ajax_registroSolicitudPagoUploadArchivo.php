<?php
session_start ();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion($negocio);
$usuario = $_SESSION ["userLog"]["rol"];
//$log = new KLogger ( "ajax_uploadpdfSolictudPago.log" , KLogger::DEBUG );
//$log->LogInfo("Variable sesion: " . var_export ($_SESSION, true));

$response = array ();
    $formulario = array(
        "idEmpresa"          => getValueFromPost("idEmpresa"),
        "numempleado"          => getValueFromPost("entidadEmpleadoSolicita")."-".getValueFromPost("ConsecutivoEmpleadoSolicita")."-".getValueFromPost("CategoriaEmpleadoSolicita"),
        "lineaNegocioSolicitante"          => getValueFromPost("hdnidLineanegSolicitante"),
        "entidadSolicitante"          => getValueFromPost("hdnidEntidadSolicitante"),
        "benificiario"          => getValueFromPost("benificiario"),
        "idBancoBeneficiario"          => getValueFromPost("idBancoBeneficiario"),
        "cuentaBeneficiario"          => getValueFromPost("cuentaSolicitante"),
         "cuentaClabeBeneficiario"          => getValueFromPost("cuentaClabeSolicitante"),
         "idClaveClasificacion"          => getValueFromPost("idClaveClasificacion"),
         "importe"          => getValueFromPost("inpImporte"),
         "conceptoDelPago"          => getValueFromPost("observacion"),
    );
//$log->LogInfo("formulario: " . var_export ($formulario, true));

//$log->LogInfo("Variable formulario: " . var_export ($formulario, true));
//$usuario = $_SESSION ["userLog"]["nombre"];
$response["status"] = "success";  
//aqui consulta del ultimo id insertado en la tabla solicituddepagos
   $ultimoId=$negocio->negocio_TraeUltimoId();

   $maxId=($ultimoId[0]["idSolicitudPago"]+1);
$permitidos= "application/pdf";
$correcto=true;
$num=count($_FILES["docuSolicitudPago"]['type']);
for($a=0;$a<$num;$a++){

    $valor=$_FILES["docuSolicitudPago"]['type'][$a];


    if($valor!=$permitidos){
        $correcto=false;
        break;
    }

} //$log->LogInfo("Valor de la fecha: " . var_export ($correcto, true));

    if(!$correcto){
      $response["status"] = "error";
      $response ["message"] = "Tipos de arhivos incorrecto o limite excedido";
    }
    else{
        foreach($_FILES["docuSolicitudPago"]['tmp_name'] as $key => $tmp_name)
    {
        //Validamos que el archivo exista

        if($_FILES["docuSolicitudPago"]["name"][$key]) {
            $filename = $_FILES["docuSolicitudPago"]["name"][$key]; //Obtenemos el nombre original del archivo
            $source = $_FILES["docuSolicitudPago"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
            $directorio = 'uploads/archivosSolicutudPago/'; //Declaramos un  variable con la ruta donde guardaremos los archivos
            //$fecha = $_FILE["fechaMovimiento"];
          

            //Validamos si la ruta de destino existe, en caso de no existir la creamos
            if(!file_exists($directorio)){
                mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
            }
            
            $dir=opendir($directorio); //Abrimos el directorio de destino
    
            $target_path = $directorio. "SolicitudPago".  $maxId . ".pdf"; //Indicamos la ruta de destino, así como el nombre del archivo
            
            //Movemos y validamos que el archivo se haya cargado correctamente
            //El primer campo es el origen y el segundo el destino
         
            if(!move_uploaded_file($source, $target_path)) { 
                $response["status"] = "error";
                $response ["message"] = "Error al subir archivos";
            }
            closedir($dir); //Cerramos el directorio de destino
        }
    }

    //aquifuncion que inserta  en la tabla
     $ultimoId=$negocio->negocio_InsertSolicitudPago($formulario,$usuario);


}

if( $response["status"] =='success'){
   //   $log->LogInfo("Valor de la fecha: " . var_export ($fecha, true));
    $response["message"]='Solicitud registrada con éxito';
}

//$log->LogInfo("Valor de la variable response: " . var_export ($response, true));

echo json_encode($response);

?> 