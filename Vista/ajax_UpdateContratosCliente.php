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
// $log = new KLogger ( "ajax_UpdateContratosCliente.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true)); 
// $log->LogInfo("Valor de la variable FILES: " . var_export ($_FILES, true)); 
$NumeroCliente = getValueFromPost ("txtNumeroClienteEditarCliente");
$NumeroContrato = getValueFromPost ("txtNumeroEditarCliente");
$AnexoContrato = getValueFromPost ("txtAnexoEditarCliente");
$FechaInicioC = getValueFromPost ("txtFechaInicioEditarCliente");
$BanderaCliente = getValueFromPost ("BanderaCliente");
// $NumEmpModalNC = getValueFromPost ("NumEmpModalNC");
// $contraseniaInsertadaCifrada = getValueFromPost ("contraseniaInsertadaCifrada");

$nombrearchivo = "";
$archivopdf=$_FILES["contratoEditado"]["name"][0];

if (!empty ($_POST)){
    if ($BanderaCliente!=2) {
        $valor=$_FILES["txtArchivoEditarCliente"]['type'][0];
    }else{
        $valor=$_FILES["contratoEditado"]['type'][0];
    }
    if($valor!=$permitidos){
        $correcto=false;
    }
    if(!$correcto && ($BanderaCliente =="1" || $BanderaCliente =="4" || ($BanderaCliente =="2" && $archivopdf!=''))){
        $response["status"] = "error";
        $response ["message"] = "Adjunta El Contrato y Revisa Que El Tipo De Archivo Sea PDF";
    }
    else if($NumeroCliente == "" && ($BanderaCliente =="1" || $BanderaCliente =="4")){
        $response["status"] = "error";
        $response ["message"] = "Por favor ingrese: Numero de cliente proporcionado por nomina";
    }
    else if($NumeroContrato == "0" && ($BanderaCliente =="1" || $BanderaCliente =="4")){
        $response["status"] = "error";
        $response ["message"] = "Por favor Seleccione: Número De Contrato";
    }
    else if($AnexoContrato == "LETRAS" && ($BanderaCliente =="1" || $BanderaCliente =="4")){
        $response["status"] = "error";
        $response ["message"] = "Por favor Seleccione: Anexo Contrato";
    }
    else if($FechaInicioC == "" && ($BanderaCliente =="1" || $BanderaCliente =="4")){
        $response["status"] = "error";
        $response ["message"] = "Por favor Seleccione: Fecha De Inicio Del Contrato";
    }
    else{
        // $log->LogInfo("Valor de la variable BanderaCliente: " . var_export ($BanderaCliente, true)); 
        if($BanderaCliente =="1" || $BanderaCliente =="4"){

            //Validamos que el archivo exista
            foreach($_FILES["txtArchivoEditarCliente"]['tmp_name'] as $key => $tmp_name)
            {
                if($_FILES["txtArchivoEditarCliente"]["name"][$key]) {
                    $filename = $_FILES["txtArchivoEditarCliente"]["name"][$key]; //Obtenemos el nombre original del archivo
                    $source = $_FILES["txtArchivoEditarCliente"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
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
        }

        if($BanderaCliente =="2" && $archivopdf!=''){
            //Validamos que el archivo exista
            foreach($_FILES["contratoEditado"]['tmp_name'] as $key => $tmp_name)
            {
                if($_FILES["contratoEditado"]["name"][$key]) {
                    $filename = $_FILES["contratoEditado"]["name"][$key]; //Obtenemos el nombre original del archivo
                    $source = $_FILES["contratoEditado"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
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
        }
        $usuario = $_SESSION ["userLog"]["usuario"];
        $clienteEdit = array (
       
        "NumeroClienteEditarCliente" => getValueFromPost ("txtNumeroClienteEditarCliente"),
        "NumeroEditarCliente" => getValueFromPost ("txtNumeroEditarCliente"),
        "AnexoEditarCliente" => getValueFromPost ("txtAnexoEditarCliente"),
        "TipoEditarCliente" => getValueFromPost ("txtTipoEditarCliente"),
        "ObjetoEditarCliente" => getValueFromPost ("txtObjetoEditarCliente"),
        "FechafinEditarCliente" => getValueFromPost ("txtFechafinEditarCliente"),
        "VigenciaAnioEditarCliente" => getValueFromPost ("txtVigenciaAnioEditarCliente"),
        "VigenciaMesEditarCliente" => getValueFromPost ("txtVigenciaMesEditarCliente"),
        "FechaInicioEditarCliente" => getValueFromPost ("txtFechaInicioEditarCliente"),
        "RfcEditarCliente" => strtoupper(getValueFromPost ("txtRfcEditarCliente")),
        "RazonSocialEditarCliente" => getValueFromPost ("txtRazonSocialEditarCliente"),
        "RegistroPatronalEditarCliente" => getValueFromPost ("txtRegistroPatronalEditarCliente"),
        "NombreComercialEditarCliente" => getValueFromPost ("txtNombreComercialEditarCliente"),
        "NombreContactoEditarCliente" => getValueFromPost ("txtNombreContactoEditarCliente"),
        "TelefonoFijoEditarCliente" => getValueFromPost ("txtTelefonoFijoEditarCliente"),
        "TelefonoMovilEditarCliente" => getValueFromPost ("txtTelefonoMovilEditarCliente"),
        "CpContratoEditarCliente" => getValueFromPost ("txtCpContratoEditarCliente"),
        "AsentamientoEditarCliente" => getValueFromPost ("txtAsentamientoEditarCliente"),
        "EntidadEditarCliente" => getValueFromPost ("txtEntidadEditarCliente"),
        "MunicipioEditarCliente" => getValueFromPost ("txtMunicipioEditarCliente"),
        "ColoniaEditarCliente" => getValueFromPost ("txtColoniaEditarCliente"),
        "CallePrincipalEditarCliente" => getValueFromPost ("txtCallePrincipalEditarCliente"),
        "NumeroInteriroEditarCliente" => getValueFromPost ("txtNumeroInteriroEditarCliente"),
        "NumeroExteriorEditarCliente" => getValueFromPost ("txtNumeroExteriorEditarCliente"),
        "Calle1EditarCliente" => getValueFromPost ("txtCalle1EditarCliente"),
        "Calle2EditarCliente" => getValueFromPost ("txtCalle2EditarCliente"),
        "CorreoEditarCliente" => getValueFromPost ("txtCorreoEditarCliente"),
        "MontotxtCorreoEditarCliente" => getValueFromPost ("txtMontotxtCorreoEditarCliente"),
        "RfcContratantetxtCorreoEditarCliente" => strtoupper(getValueFromPost ("txtRfcContratantetxtCorreoEditarCliente")),
        "NombreContratantetxtCorreoEditarCliente" => getValueFromPost ("txtNombreContratantetxtCorreoEditarCliente"),
        "PrimerApellidoContratantetxtCorreoEditarCliente" => getValueFromPost ("txtPrimerApellidoContratantetxtCorreoEditarCliente"),
        "SegundoApellidoContratantetxtCorreoEditarCliente" => getValueFromPost ("txtSegundoApellidoContratantetxtCorreoEditarCliente"),
        "CorreoContratantetxtCorreoEditarCliente" => getValueFromPost ("txtCorreoContratantetxtCorreoEditarCliente"),
        "TelMovilContratantetxtCorreoEditarCliente" => getValueFromPost ("txtTelMovilContratantetxtCorreoEditarCliente"),
        "TelFijoContratantetxtCorreoEditarCliente" => getValueFromPost ("txtTelFijoContratantetxtCorreoEditarCliente"),
        "BanderaCliente" => getValueFromPost ("BanderaCliente"),
        "idCliente" => getValueFromPost ("idCliente"),
        "idContratoCliente" => getValueFromPost ("idContratoCliente"),
        "ArchivoContrato" => $nombrearchivo,
        "personaCapturaCliente" => $usuario,
        "NumEmpModalNC" => getValueFromPost ("NumEmpModalNC"),
        "contraseniaInsertadaCifrada" => getValueFromPost ("contraseniaInsertadaCifrada"),
        );
// $log->LogInfo("Valor de la variable clienteEdit: " . var_export ($clienteEdit, true)); 
        try{
            $negocio -> negocio_UpdateContratosCLientes($clienteEdit); 
            $response ["status"] = "success";
            $response ["message"] = "Cliente registrado éxitosamente";
        } 
        catch (Exception $e){
            $response ["status"] = "error";
            $response ["message"] =  $e -> getMessage ();
        }
    }
}
else{
    $response ["status"] = "error";
    $response ["message"] = "No se proporcionaron datos";
}
echo json_encode ($response);
?>