<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$negocio = new Negocio ();
$response = array (); 
verificarInicioSesion ($negocio);
$permitidos= "application/pdf";
$correcto=true;
// $log = new KLogger ( "ajaxRegistroCliente.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
//$log->LogInfo("Valor de la variable _FILES: " . var_export ($_FILES, true));
$NumeroCliente = getValueFromPost ("txtNumeroCliente");
$NumeroContrato = getValueFromPost ("txtNumeroContrato");
$AnexoContrato = getValueFromPost ("txtAnexoContrato");
$FechaInicioC = getValueFromPost ("txtFechaInicioC");
$nombrearchivo = "";
if (!empty ($_POST))
{

    $CLientePrevio = $negocio -> negocio_ConsultaPreviaCliente($NumeroCliente);
   $valor=$_FILES["txtArchivoContrato"]['type'][0];
    if($valor!=$permitidos){
        $correcto=false;

    }
    if(!$correcto){
        $response["status"] = "error";
        $response ["message"] = "Adjunta El Contrato y Revisa Que El Tipo De Archivo Sea PDF";
    }
    else if($NumeroCliente == ""){
        $response["status"] = "error";
        $response ["message"] = "Por favor ingrese: Numero de cliente proporcionado por nomina";
    }
    else if($NumeroContrato == "0"){
        $response["status"] = "error";
        $response ["message"] = "Por favor Seleccione: Número De Contrato";
    }
    else if($AnexoContrato == "LETRAS"){
        $response["status"] = "error";
        $response ["message"] = "Por favor Seleccione: Anexo Contrato";
    }
    else if($FechaInicioC == ""){
        $response["status"] = "error";
        $response ["message"] = "Por favor Seleccione: Fecha De Inicio Del Contrato";
    }
    else if($CLientePrevio == "true"){
        $response["status"] = "error";
        $response ["message"] = "El numero de cliente ya se encuantra registrado en la base";
    }
    else
    {
        //Validamos que el archivo exista
        foreach($_FILES["txtArchivoContrato"]['tmp_name'] as $key => $tmp_name)
        {
            if($_FILES["txtArchivoContrato"]["name"][$key]) {
                $filename = $_FILES["txtArchivoContrato"]["name"][$key]; //Obtenemos el nombre original del archivo
                $source = $_FILES["txtArchivoContrato"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
                $directorio = "uploads/ContratosClientes/".$NumeroCliente."/"; //Declaramos un  variable con la ruta donde guardaremos los archivos
                //Validamos si la ruta de destino existe, en caso de no existir la creamos
                if(!file_exists($directorio)){
                    mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");     
                }
                $dir=opendir($directorio); //Abrimos el directorio de destino
                $nombrearchivo="Contrato_".$NumeroCliente."_".$NumeroContrato."_".$AnexoContrato."_".$FechaInicioC;
                $target_path = $directorio.'/'.$nombrearchivo.".pdf"; //Indicamos la ruta de destino, así como el nombre del archivo
                //Movemos y validamos que el archivo se haya cargado correctamente
                //El primer campo es el origen y el segundo el destino
                if(!move_uploaded_file($source, $target_path)) { 
                    $response["status"] = "error";
                    $response["message"] = "Error al subir archivos";
                }
            closedir($dir);//Cerramos el directorio de destino
            }
        }
        $usuario = $_SESSION ["userLog"]["usuario"];
        $cliente = array (
        "razonSocial" => strtoupper(getValueFromPost("txtRazonSocial")),
        "nombreComercial" => strtoupper(getValueFromPost("txtNombreComercial")),
        "rfcCliente" => strtoupper(getValueFromPost("txtRfcCliente")),
        "contactoCliente" => strtoupper(getValueFromPost("txtNombreContacto")),
        "telefonoFijoCliente" => getValueFromPost("txtTelefonoFijoCliente"),
        "telefonoMovilCliente" => getValueFromPost("txtTelefonoMovilCliente"),
        "correoCliente" => getValueFromPost("txtCorreoCliente"),
        "claveClienteNomina" => getValueFromPost("txtNumeroCliente"),
        "Persona" => getValueFromPost("Persona"),
        "estatusCliente" => getValueFromPost("estatusCliente"),
        "NumeroContrato" => getValueFromPost("txtNumeroContrato"),
        "TipoContrato" => getValueFromPost("txtTipoContrato"),
        "ObjetoContrato" => getValueFromPost("txtObjetoContrato"),
        "VigenciaAnio" => getValueFromPost("txtVigenciaAnio"),
        "VigenciaMes" => getValueFromPost("txtVigenciaMes"),
        "FechaInicioC" => getValueFromPost("txtFechaInicioC"),
        "FechafinC" => getValueFromPost("txtFechafinC"),
        "RegistroPatronalC" => getValueFromPost("txtRegistroPatronalC"),
        "CpContrato" => getValueFromPost("txtCpContrato"),
        "Asentamiento" => getValueFromPost("txtAsentamiento"), 
        "EntidadCliente" => getValueFromPost("txtEntidadCliente"),
        "Municipio" => getValueFromPost("txtMunicipio"),
        "ColoniaCliente" => getValueFromPost("txtColoniaCliente"),
        "CallePrincipal" => getValueFromPost("txtCallePrincipal"),
        "NumeroInteriro" => getValueFromPost("txtNumeroInteriro"),
        "NumeroExterior" => getValueFromPost("txtNumeroExterior"),
        "Calle1" => getValueFromPost("txtCalle1"),
        "Calle2" => getValueFromPost("txtCalle2"),
        "MontoContrato" => getValueFromPost("txtMontoContrato"),
        "ArchivoContrato" => $nombrearchivo,
        "RfcContratante" => strtoupper(getValueFromPost("txtRfcContratante")),
        "NombreContratante" => getValueFromPost("txtNombreContratante"),
        "PrimerApellidoContratante" => getValueFromPost("txtPrimerApellidoContratante"),
        "SegundoApellidoContratante" => getValueFromPost("txtSegundoApellidoContratante"),
        "CorreoContratante" => getValueFromPost("txtCorreoContratante"),
        "TelMovilContratante" => getValueFromPost("txtTelMovilContratante"),
        "TelFijoContratante" => getValueFromPost("txtTelFijoContratante"),
        "AnexoContrato" => getValueFromPost ("txtAnexoContrato"),
        "personaCapturaCliente" => $usuario,
        );
//$log->LogInfo("Valor de la variable cliente: " . var_export ($cliente, true));

        try
        {
            $negocio -> negocio_registrarCliente($cliente);
            
            $response ["status"] = "success";
            $response ["message"] = "Cliente registrado éxitosamente";
        } 
        catch (Exception $e)
        {
            $response ["status"] = "error";
            $response ["message"] =  $e -> getMessage ();
        }
    }
    
}
else
{
    $response ["status"] = "error";
    $response ["message"] = "No se proporcionaron datos";
}

echo json_encode ($response);
?>

