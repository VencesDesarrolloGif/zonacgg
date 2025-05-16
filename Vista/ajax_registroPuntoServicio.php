<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/phpmailer/class.phpmailer.php");

$negocio = new Negocio ();
$response = array ();
verificarInicioSesion ($negocio);

if (!empty ($_POST))
{
// $log = new KLogger ( "ajaxRegistroPuntoServicio.log" , KLogger::DEBUG );
     // $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));

    $usuario = $_SESSION ["userLog"]["usuario"];
    $puntoServicio = array (
    "numeroOrden" =>  getValueFromPost("txtNumeroOrden"),
    "idClientePunto" => getValueFromPost("cliente"),
    "numeroCentroCosto" =>   strtoupper(getValueFromPost("txtNumeroCentro")),
    "puntoServicio" => strtoupper(getValueFromPost("txtPuntoServicio")),
    "idEntidadPunto" => getValueFromPost("entidad"),
    "direccionPuntoServicio" => strtoupper(getValueFromPost("txtDireccion")),
    "contactoFacturacion" =>strtoupper(getValueFromPost("txtContactoFacturacion")),
    "correoFacturacion" => getValueFromPost("txtCorreoFacturacion"),
    "telefonoFijoFacturacion" => getValueFromPost("txtTelefonoFijoFacturacion"),
    "telefonoMovilFacturacion" => getValueFromPost("txtTelefonoMovilFacturacion"),
    "contactoTesoreria" => strtoupper(getValueFromPost("txtContactoTesoreria")),
    "correoTesoreria" => getValueFromPost("txtCorreoTesoreria"),
    "telefonoFijoTesoreria" => getValueFromPost("txtTelefonoFijoTesoreria"),
    "telefonoMovilTesoreria" => getValueFromPost("txtTelefonoMovilTesoreria"),
    "contactoOperativo" => strtoupper(getValueFromPost("txtContactoOperativo")),
    "correoOperativo" =>  getValueFromPost("txtCorreoOperativo"),
    "telefonoFijoOperativo" => getValueFromPost("txtTelefonoFijoOperativo"),
    "telefonoMovilOperativo" => getValueFromPost("txtTelefonoMovilOperativo"),
    "esatusPunto" => getValueFromPost("esatusPunto"),
    "fechaInicioServicio" => getValueFromPost("txtFechaInicio"),
    "usuarioCapturaPunto" => $usuario,
    "terminoFacturacion" => strtoupper(getValueFromPost("txtTerminosFacturacion")),
    "fechaTerminoServicio" => strtoupper(getValueFromPost("txtFechaTerminoServicio")),
    "entidadFederativa" => getValueFromPost("entidadFederativa"),
    "cobraDescansos"=>getValueFromPost("cobraDescansos"),
    "cobraDiaFestivo"=>getValueFromPost("cobraDiaFestivo"),
    "cobra31"=>getValueFromPost("cobra31"),
    "cobra31"=>getValueFromPost("cobra31"),
    "latitudPunto"=>getValueFromPost("txtLatitud"),
    "longitudPunto"=>getValueFromPost("txtLongitud"),
    "clienteName"=>getValueFromPost("clienteName"),
    "turnoFlat"=>getValueFromPost("turnoFlat"),

     "turnoFlat"=>getValueFromPost("turnoFlat"),
      "selLineaNegocio"=>getValueFromPost("selLineaNegocio"),
      "idRegion"=>getValueFromPost("idRegion"),
      "visiblerh"=>getValueFromPost("visiblerh"),
      "cubredescanso"=>getValueFromPost("cubredescanso"),    
      "selmunicipiowalmrt"=>getValueFromPost("selmunicipiowalmrt"), 
      "txtunidad"=>getValueFromPost("txtunidad"), 
      "CpContrato" => getValueFromPost("txtCpContratoPuntoServicio"),
      "Asentamiento" => getValueFromPost("txtAsentamientoPuntoServicio"),
      "EntidadCliente" => getValueFromPost("txtEntidadClientePuntoServicio"),
      "Municipio" => getValueFromPost("txtMunicipioPuntoServicio"), 
      "ColoniaCliente" => getValueFromPost("txtColoniaClientePuntoServicio"),
      "CallePrincipal" => getValueFromPost("txtCallePrincipalPuntoServicio"),
      "NumeroInteriro" => getValueFromPost("txtNumeroInteriroPuntoServicio"),
      "NumeroExterior" => getValueFromPost("txtNumeroExteriorPuntoServicio"),
      "Calle1" => getValueFromPost("txtCalle1PuntoServicio"),
      "Calle2" => getValueFromPost("txtCalle2PuntoServicio"),
);

     // $log->LogInfo("Valor de la variable \$puntoServicio: " . var_export ($puntoServicio, true));
    try
    {
        $negocio -> negocio_registrarPuntoServicio($puntoServicio);
        $response ["status"] = "success";
        $response ["message"] = "Punto de Servicio registrado éxitosamente";

       $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host       = 'smtp.office365.com';
        $mail->Port       = 587;
        $mail->SMTPAuth   = true;
        $mail->Username   = 'registros@gifseguridad.com.mx';
        $mail->Password   = 'Har00112';
        $mail->SMTPSecure = 'tls';
        $mail->From       = 'registros@gifseguridad.com.mx';
        $mail->FromName = 'Ventas';

        //$mail->AddAddress('lourdes.herrera@gifseguridad.com.mx', 'Lourdes Herrera');  
        $mail->AddAddress('contrataciones@gifseguridad.com.mx', 'contrataciones');  
        //$mail->AddAddress('abril.sanroman@gifseguridad.com.mx','Abril San Roman');  
       // $mail->AddAddress('roberto.vences@gifseguridad.com.mx','Roberto Vences');


        // Name is optional

        $mail->IsHTML(true);                                  // Set email format to HTML

        $mail->Subject = utf8_decode('Registro de nuevo punto de punto de servicio');
        $mail->Body    = utf8_decode("Se registró un nuevo punto de servicio en el sistema con el nombre: <strong>".$puntoServicio['puntoServicio']. 
            "</strong> cliente <strong>". $puntoServicio['clienteName'] ."</strong> para la entidad: <strong>".$puntoServicio['entidadFederativa']."<br><br><br><h6> Correo generado desde sistema, favor de no contestar.</h6>");
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if(!$mail->Send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        exit;
            
        }
    } 
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();
    }
}
else
{
    $response ["status"] = "error";
    $response ["message"] = "No se proporcionaron datos";
}
echo json_encode ($response);
?>

