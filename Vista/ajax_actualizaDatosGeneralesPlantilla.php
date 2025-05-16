<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("../libs/phpmailer/class.phpmailer.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio ();

$response = array ();

verificarInicioSesion ($negocio);

$response = array ();
$response ["status"] = "success";

$action = isset ($_POST ["action"]) ? $_POST ["action"] : "";
//$servicioPlantillaId = isset ($_POST ["servicioPlantillaId"]) ? $_POST ["servicioPlantillaId"] : "";
//$log = new KLogger ( "ajax_consultaPlantillaEdicion.log" , KLogger::DEBUG );

if ($action == "consultar" )
{
    //$plantilla= $negocio -> getServicioPlantillaById ($servicioPlantillaId);


    $puesto=getValueFromPost ("puesto");
    $tipoTurno=getValueFromPost ("tipoTurno");
    $sexo=getValueFromPost ("sexo");
    $puntoServicio=getValueFromPost ("puntoServicio");

    $listaPlantilla= $negocio -> getPlantillaByDatos ($tipoTurno, $puntoServicio, $puesto, $sexo);

   // $log->LogInfo("Valor de variable de plantilla" . var_export ($listaPlantilla, true));

    $numeroElementos= $plantilla[0]["numeroElementos"];
    $elementosContratados= $plantilla[0]["ElementosContratados"];

   // $log->LogInfo("Valor de variable de numeroElementos" . var_export ($numeroElementos, true));
   // $log->LogInfo("Valor de variable de elementosContratados" . var_export ($elementosContratados, true));

    if($elementosContratados>=$numeroElementos){

         $response ["message"] = "La plantilla asignada a este punto de servicio sera excedida si continua con el registro del nuevo elemento, Elementos solicitados:" . $numeroElementos . " elementos asignados " . $elementosContratados . ". ¿Desea continuar?";
    }

        //$plantillaServicioDescripcion = $plantillaservicio ["descripcionPuesto"] . " de " . 
        //$plantillaservicio ["descripcionTurno"] . " " . 
        //$plantillaservicio ["nomenclaturaGenero"];

    //$plantillaServicioFactorCrecimiento = $plantillaservicio ["factorcrecimiento"];
    //$plantillaPuntoServicio=$plantillaservicio["puntoServicio"];
   


}
else
{
    $response ["status"] = "error";
    $response ["message"] = "La petición es incorrecta. Por favor corregir los datos proporcionados.";
}


echo json_encode ($response);
?>