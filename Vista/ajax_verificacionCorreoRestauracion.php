<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/phpmailer/class.phpmailer.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

//$log = new KLogger ( "ajax_getEmpleadoByCorreo.log" , KLogger::DEBUG );

$response = array("status" => "error");
            $correo=getValueFromPost("correo");
            //$log->LogInfo("Valor de variable de empleado correo" . var_export ($correo, true));
try{

    //$listaEmpleados= $negocio -> getListaEmpleadosPeriodoEmpleadoId($fecha1, $fecha2,$periodoId, $empleado);
    $listaEmpleados= $negocio -> getEmpleadoByCorreo($correo);

    if (count($listaEmpleados)<=0){

        $response["status"]="error";
        $response ["message"] ="El correo electrónico ".$correo." no existe en la base de datos. Por favor verifique e intente nuevamente";
    }else{

        //$log->LogInfo("Valor de la variable \$listaEmpleados: " . var_export ($listaEmpleados, true));
        for ($i = 0; $i < count($listaEmpleados); $i++)
        {
            $idTipoPuesto=$listaEmpleados[$i]["idTipoPuesto"];
            $numeroEmpleado=$listaEmpleados[$i]["numeroEmpleado"];            
            $estatus=$listaEmpleados[$i]["empleadoEstatusId"];
                        

            if($estatus !=0){
                //$response["status"]="success";

                //$response ["message"] ="si existe elemento";
                
                $mail = new PHPMailer;

                $mail->IsSMTP();                                    
                // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com';                 // Specify main and backup server
                $mail->Port = 587;                                  // Set the SMTP port
                $mail->SMTPAuth = true;                             // Enable SMTP authentication
                $mail->Username = 'CorporativoGifSeguridad@gmail.com';                // SMTP username
                $mail->Password = 'Corporativo_Gif_Seguridad_Privada1';                   // SMTP password
                $mail->SMTPSecure = 'tls';                          // Enable encryption, 'ssl' also accepted

                $mail->From = 'CorporativoGifSeguridad@gmail.com';
                $mail->FromName = 'Soporte Zona Gif';
                    
                $mail->AddAddress($correo);  
                
                
                $mail->IsHTML(true);                                  // Set email format to HTML

                $mail->Subject = utf8_decode('Restauración de contraseña ZONA GIF');
                $mail->Body    = utf8_decode("Hemos recibido una solicitud de restauración de contraseña de su cuenta
                    , para continuar con el proceso haga click en el siguiente enlace: 
                    <a href='http://".$_SERVER["SERVER_NAME"] .":" .$_SERVER["SERVER_PORT"].dirname ($_SERVER ["SCRIPT_NAME"])."/restauracionContrasena.php?usuario=".$numeroEmpleado."'><br>Reestablecer Contraseña</a> ");
                //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                if(!$mail->Send()) {
                    //echo 'Message could not be sent.';
                    //echo 'Mailer Error: ' . $mail->ErrorInfo;
                    //exit;
                    $response["status"]="error";
                    $response ["message"] ="No se pudo hacer él envió de correo electrónico de restauración de contraseña, por favor comuniquese a la oficina de contratación";
                }else{

                    $response["status"]="success";
                    $response ["message"] ="Correo electrónico enviado, por favor verifique su bandeja de entrada o la carpeta de correos no deseados para continuar con el proceso de restauración de contraseña";
                }
            }else{
                $response["status"]="error";
                $response ["message"] ="El empleado está dado de baja";
            }
        }
    }
} 
catch( Exception $e )
{
    $response["status"]="error";
    $response["error"]="No se puedo obtener consulta";
    $response ["message"] =  $e -> getMessage ();
}
echo json_encode($response);

?>