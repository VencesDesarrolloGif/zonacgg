<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio (); 


$response = array ();
$response ["status"] = "error";

verificarInicioSesion ($negocio);
// $log = new KLogger ( "ajaxRegistroNomina.log" , KLogger::DEBUG );
  

if (!empty ($_POST))
{
    // $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
    // Creo que hace falta considerar el campo: Puesto que provienen del formulario.
    // Y hace falta que el formulario envie la foto del empleado.
    // el campo numeroSeguroSocial no se utiliza en persistencia.

    $usuarioCaptura=$_SESSION ["userLog"]["usuario"];
    $numeroEmpleado=getValueFromPost("numeroEmpleado");
    // $log->LogInfo("Valor de la variable numeroEmpleado: " . var_export ($numeroEmpleado, true));   
     $empleadoidd = explode("-", $numeroEmpleado);
/*
            $empleadoEntidad=substr($empleadoId, 0,2);
            $empleadoConsecutivo=substr($empleadoId, 3,4);
            $empleadoCategoria=substr($empleadoId, 8,2);
*/
        $empleadoEntidad=$empleadoidd[0];
        $empleadoConsecutivo=$empleadoidd[1];
        $empleadoCategoria=$empleadoidd[2];
	
	$datos = array (
    "idEntidadEmpleadoNomina" => $empleadoEntidad,
    "consecutivoEmpleadoNomina" => $empleadoConsecutivo,
    "tipoEmpleadoNomina" => $empleadoCategoria,
    "peridoNomina" => strtoupper(getValueFromPost("tipoPeriodo")),
    "fechaPeriodo1" =>strtoupper( getValueFromPost("fechaConsulta1")),
    "fechaPeriodo2" => strtoupper(getValueFromPost("fechaConsulta2")),
    "puestoEmpleadoNomina" => getValueFromPost("empleadoIdPuesto"),
    "puntoServicioEmpleadoNomina" => getValueFromPost("empleadoIdPuntoServicio"),
    "turnosTotales" => getValueFromPost("turnosTotales"),
    "cuotaPagadaTurno" =>getValueFromPost("cuotaDiariaEmpleado"),
    "bonoAsistenciaPagado" => getValueFromPost("bonoAsistenciaEmpleado"),
	"bonoPuntualidadPagado" => getValueFromPost("bonoPuntualidadEmpleado"),
    "bonoAplicado" => getValueFromPost("bonoAplicado"),
    "montoVacacionesPagadas" => getValueFromPost("montoVacacionesPagadas"),
	"primaVacacional" => getValueFromPost("primaVacacional"),
	"sueldoBruto" => getValueFromPost("sueldoBruto"),
    "montofonacot" => getValueFromPost("montofonacot"),
    "montoinfonavit" => getValueFromPost("montoinfonavit"),
    "montopension" => getValueFromPost("montopension"),
    "montoprestamo" => getValueFromPost("montoprestamo"),
    "montoalimentos" => getValueFromPost("montoalimentos"),
    "netoalpago" => getValueFromPost("netoalpago"),
	"usuarioRegistroNomina" => $usuarioCaptura,
    "usuarioEdicionNomina" => $usuarioCaptura,
    );
        
    try
    {

        // $log->LogInfo("Valor de la variable datos: " . var_export ($datos, true));
        
        $registro=$negocio -> registroNomina($datos);
        //$log->LogInfo("Valor de la variable \$registro: " . var_export ($registro, true));
            
        $response ["status"] = "success";
        $response ["message"] = "Nomina cerrada";

        
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
