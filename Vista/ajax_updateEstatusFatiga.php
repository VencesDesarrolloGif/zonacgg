<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$negocio = new Negocio ();
$response = array ();
verificarInicioSesion ($negocio);

if (!empty ($_POST))
{
    //$log = new KLogger ( "ajaxUpdateEstatusFatiga.log" , KLogger::DEBUG );


    $usuario = $_SESSION ["userLog"]["usuario"];

    $nuevoEstatusFatiga=getValueFromPost("nuevoEstatusFatiga");
    $fechaCambioEstatus=getValueFromPost("fechaCambioEstatus");
    $idPuntoServicio=getValueFromPost("idPuntoServicio");
    $quincena=getValueFromPost("quincena");
    $month=getValueFromPost("month");
    $estatusFatiga=getValueFromPost("estatusFatiga");
    $year=getValueFromPost("year");

    //$log->LogInfo("Valor de la variable \$nuevoestatus de fatiga: " . var_export ($nuevoEstatusFatiga, true));
    //$log->LogInfo("Valor de la variable \$fechaCambioEstatus de fatiga: " . var_export ($fechaCambioEstatus, true));
    //$log->LogInfo("Valor de la variable \$idPuntoServicio: " . var_export ($idPuntoServicio, true));
    //$log->LogInfo("Valor de la variable \$idquincena: " . var_export ($quincena, true));
    //$log->LogInfo("Valor de la variable \$month: " . var_export ($month, true));
    //$log->LogInfo("Valor de la variable \$estatusFatiga: " . var_export ($estatusFatiga, true));
    try
    {
        //$negocio -> negocio_registroDatosPersonalesEmpleado($datoPersonal);
        if($nuevoEstatusFatiga=="Nuevo estatus" ){
            $response ["status"] = "error";
            $response ["message"] = "Seleccione el nuevo estatus de la fatiga";

        }else if($fechaCambioEstatus==""){
            $response ["status"] = "error";
            $response ["message"] = "Seleccione fecha del cambio de estatus";

        }elseif ($nuevoEstatusFatiga==$estatusFatiga) {

            //los estatus de la fatiga deben ser diferentes
            $response ["status"] = "error";
            $response ["message"] = "Verifique el nuevo estatus de la fatiga";
            # code...
        }elseif ($estatusFatiga==4 and $nuevoEstatusFatiga==3) {

            $response ["status"] = "error";
            $response ["message"] = "El estatus de esta fatiga no puede cambiar a Recibida";
            # code...
        }elseif ($nuevoEstatusFatiga<=$estatusFatiga) {

            $response ["status"] = "error";
            $response ["message"] = "El nuevo estatus de la fatiga";
            # code...
        }
        else{

            if($quincena==1){
                    $fecha1=$year. "-" . str_pad($month, 2, "0", STR_PAD_LEFT) . "-" . str_pad(1, 2, "0", STR_PAD_LEFT); 
                    $fecha2=$year. "-" . str_pad($month, 2, "0", STR_PAD_LEFT) . "-" . str_pad(15, 2, "0", STR_PAD_LEFT);
                    //$log->LogInfo("Valor de la variable \$fecha1: " . var_export ($fecha1, true));
                    //$log->LogInfo("Valor de la variable \$fecha2: " . var_export ($fecha2, true));
                }elseif($quincena==2){
                    $fecha1=$year. "-" . str_pad($month, 2, "0", STR_PAD_LEFT) . "-" . str_pad(16, 2, "0", STR_PAD_LEFT); 
                    $lastDay= date("d", mktime(0,0,0, $month+1, 0, $year));
                    $fecha2=$year. "-" . str_pad($month, 2, "0", STR_PAD_LEFT) . "-" . str_pad($lastDay, 2, "0", STR_PAD_LEFT); 
                    //$log->LogInfo("Valor de la variable \$fecha1: " . var_export ($fecha1, true));
                    //$log->LogInfo("Valor de la variable \$fecha2: " . var_export ($fecha2, true));
                }

            if($estatusFatiga==0 and $nuevoEstatusFatiga==3){
                //si la fatiga no fue enviada por correo electronico  pero ya fue recibida fisicamente con firmas
                //cambia el estatus a Recibida
                //Inserta registro 
                $negocio -> registroRecepcionFatiga ($idPuntoServicio, $fecha1, $fecha2, $quincena, $fechaCambioEstatus,$usuario);
                $response ["status"] = "success";
                $response ["message"] = "";

            }
            elseif(($estatusFatiga==1 or $estatusFatiga=2) and $nuevoEstatusFatiga==3){

                $negocio -> actualizarEstatusFatiga($nuevoEstatusFatiga,$fechaCambioEstatus,$usuario,$idPuntoServicio, $fecha1, $fecha2);
                $response ["status"] = "success";
                $response ["message"] = "";

            }elseif($estatusFatiga==3 and $nuevoEstatusFatiga==4){

                $negocio -> actualizarEstatusFatiga($nuevoEstatusFatiga,$fechaCambioEstatus,$usuario,$idPuntoServicio, $fecha1, $fecha2);
                $response ["status"] = "success";
                $response ["message"] = "";

            }
            elseif($estatusFatiga==0 and $nuevoEstatusFatiga==4){

                $negocio -> registroFacturacionFatiga ($idPuntoServicio, $fecha1, $fecha2, $quincena, $fechaCambioEstatus,$usuario);
                $response ["status"] = "success";
                $response ["message"] = "";

            }elseif($estatusFatiga==0 and $nuevoEstatusFatiga==5){

                $negocio -> registroContrarecibo($idPuntoServicio, $fecha1, $fecha2, $quincena, $fechaCambioEstatus,$usuario);
                $response ["status"] = "success";
                $response ["message"] = "";

            }elseif($estatusFatiga<>0 and $nuevoEstatusFatiga==5){

                $negocio -> actualizarEstatusFatigaContrarecibo($nuevoEstatusFatiga,$fechaCambioEstatus,$usuario,$idPuntoServicio, $fecha1, $fecha2);
                $response ["status"] = "success";
                $response ["message"] = "";

            }
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
//$log->LogInfo("Valor de la variable \$response: " . var_export ($response, true));
echo json_encode ($response);
?>