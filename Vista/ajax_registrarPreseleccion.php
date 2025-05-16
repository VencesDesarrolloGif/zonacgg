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
$usuario = $_SESSION ["userLog"];

verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajaxNewPreseleccion.log" , KLogger::DEBUG );
  
//$log->LogInfo("Valor de la variable \$post: " . var_export ($_POST, true));
if (!empty ($_POST))
{    
    $reclutador=$usuario["nombre"]." ".$usuario["apellidoPaterno"];    

    $datos = array (    
    "folioEmp" => getValueFromPost("txtFolioSolicitud"),
    "puestoEmp" => getValueFromPost("empPuesto"),
    "apPaternoEmp" =>getValueFromPost("empApPaterno"),
    "apMaternoEmp" => getValueFromPost("empApMaterno"),
    "nombreEmp" => getValueFromPost("empNombre"),
    "edadEmp" => getValueFromPost("empEdad"),
    "pesoEmp" => getValueFromPost("empPeso"),
    "estaturaEmp" => getValueFromPost("empEstatura"),
    "tallaCamisaEmp" => getValueFromPost("empTallaCamisa"),
    "tallaPantalonEmp" => getValueFromPost("empTallaPantalon"),
    "numCalzadoEmp" => getValueFromPost("empNumCalzado"),
    "edoCivilEmp" => getValueFromPost("selectEmpCivil"),
    "sexoEmp" => getValueFromPost("selectEmpSexo"),
    "tipoSangreEmp" => getValueFromPost("selectEmpTipoSangre"),
    "fechaNacEmp" => getValueFromPost("empFechaNac"),
    "entidadNacEmp" => getValueFromPost("selectEmpEntidad"),
    "codPostalEmp" => getValueFromPost("empCodPostal"),
    "calleEmp" => getValueFromPost("empCalle"),
    "numeroCEmp" => getValueFromPost("empNumeroC"),
    "coloniaEmp" => getValueFromPost("empColonia"),
    "municipioEmp" => getValueFromPost("empMunicipio"),
    "ciudadEmp" => getValueFromPost("empCiudad"),
    "telFijoEmp" => getValueFromPost("empTelFijo"),
    "telMovilEmp" => getValueFromPost("empTelMovil"),
    "emailEmp" => getValueFromPost("empEmail"),
    "infonavitEmp" => getValueFromPost("infonavit"),
    "fonacotEmp" => getValueFromPost("fonacot"),
    "cartillaEmp" => getValueFromPost("cartilla"),
    "licenciaEmp" => getValueFromPost("licencia"),
    "nImssEmp" => getValueFromPost("empImss"),
    "nombreE1Emp" => getValueFromPost("empNombreUE"),
    "fecha1E1Emp" => getValueFromPost("empFecha1E1"),
    "fecha2E1Emp" => getValueFromPost("empFecha2E1"),
    "telE1Emp" => getValueFromPost("empTelE1"),
    "causaSepE1Emp" => getValueFromPost("empCausaSepE1"),
    "nombreE2Emp" => getValueFromPost("empNombreEA"),
    "fecha1E2Emp" => getValueFromPost("empFecha1E2"),
    "fecha2E2Emp" => getValueFromPost("empFecha2E2"),
    "telE2Emp" => getValueFromPost("empTelE2"),
    "causaSepE2Emp" => getValueFromPost("empCausaSepE2"),
    "personasCargoEmp" => getValueFromPost("personas"),
    "gradoEstudioEmp" => getValueFromPost("selectEmpEstudio"),
    "cursoEspecialEmp" => getValueFromPost("empCursoEspecial"),
    "enfermedadEmp" => getValueFromPost("empEnfermedad"),
    "padreEmp" => getValueFromPost("empPadre"),
    "madreEmp" => getValueFromPost("empMadre"),
    "esposaEmp" => getValueFromPost("empEsposa"),
    "hijo1Emp" => getValueFromPost("empHijo1"),
    "hijo2Emp" => getValueFromPost("empHijo2"),
    "hijo3Emp" => getValueFromPost("empHijo3"),
    "hijo4Emp" => getValueFromPost("empHijo4"),
    "hijo5Emp" => getValueFromPost("empHijo5"),
    "nombreR1Emp" => getValueFromPost("empNombreR1"),
    "telR1Emp" => getValueFromPost("empTelR1"),
    "nombreR2Emp" => getValueFromPost("empNombreR2"),
    "telR2Emp" => getValueFromPost("empTelR2"),    
    "reclutadorEmp" => $reclutador,
    "numempleadopreseleccion" => getValueFromPost("numempleadopreseleccion"),  
    "folioempleadopreseleccion" => getValueFromPost("folioempleadopreseleccion"),  
    "numLicenciaPreseleccion" => getValueFromPost("numLicenciaPreseleccion"),  
    "fechavigencialicencia" => getValueFromPost("fechavigencialicencia"),  
     "licenciapermanente" => getValueFromPost("licenciapermanente"),




    


    );
    			  
    try
    {        
        //$log->LogInfo("Valor de la variable \$datos: " . var_export ($datos, true));
        $negocio -> negocio_registrarEmpleadoPreseleccion($datos);
        $response ["status"] = "success";
        $response ["message"] = $datos["nombreEmp"].$datos["apPaternoEmp"]." fué registrado en preselección con éxito ";
        //$log->LogInfo("Valor de la variable \$datos: " . var_export ($datos, true));      
    } 
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();
    }
}
echo json_encode ($response);
?> 