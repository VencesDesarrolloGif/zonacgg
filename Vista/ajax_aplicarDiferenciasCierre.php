<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio ();
$response = array ();
verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajax_aplicarDiferenciasCierre.log" , KLogger::DEBUG );
if (!empty ($_POST))
{
    $usuario = $_SESSION ["userLog"]["usuario"];
    $data=getValueFromPost("data");     
   // $log->LogInfo("Valor de la variable \$data: " . var_export ($data, true));
    try
    {
        for ($i = 0; $i < count($data); $i++){
            $empleado=$data[$i]["numeroEmpleado"];
            $empleadoidd = explode("-", $empleado);
            $supervisorId=$data[$i]["supervisorId"];
            $supervisoridd = explode("-", $supervisorId);
            $puestoCubierto=$data[$i]["puestoCubierto"];

            //$puntoServicioId=$data[$i]["centroCosto"];
            $puntoCierreName=$data[$i]["puntoServicioCierre"];
            $fechaAsistencia=$data[$i]["fechaAsistencia"];
            $comentarioIncidencia=$data[$i]["comentarioIncidencia"];
            $idNuevaIncidencia=$data[$i]["idNuevaIncidencia"];
            $diferencia=$data[$i]["diferencia"];
            $idEntidadTrabajo=$data[$i]["idEntidadTrabajo"];
            $incidenciaFecha=$data[$i]["fechaCambioPeriodo"];
/*          $empleadoEntidadId=substr($empleado,0,2);
            $empleadoConsecutivo=substr($empleado,3,4);
            $empleadoCategoria=substr($empleado,8,2);
*/          $empleadoEntidadId=$empleadoidd[0];
            $empleadoConsecutivo=$empleadoidd[1];
            $empleadoCategoria=$empleadoidd[2];
/*          $supervisorEntidadId=substr($supervisorId,0,2);
            $supervisorConsecutivo=substr($supervisorId,3,4);
            $supervisorCategoria=substr($supervisorId,8,2);
*/          $supervisorEntidadId=$supervisoridd[0];
            $supervisorConsecutivo=$supervisoridd[1];
            $supervisorCategoria=$supervisoridd[2];
            $numeroTurnos=substr($diferencia, 1);
            $neomenclaturaIncidencia=$data[$i]["neomenclaturaIncidencia"]; 
            $roloperativo=$data[$i]["roloperativo"];        
            $centroCosto=$negocio->getCentroCostoByEntidadTrabajo ($idEntidadTrabajo);
            //$log->LogInfo("Valor de la variable \$numeroTurnos: " . var_export ($numeroTurnos, true));
            $empleadoCategoriaid = explode("_", $empleadoCategoria);
            $empleadoCategoria1=$empleadoCategoriaid[0];

            if($centroCosto==""){
                $centroCosto=14;
            }

            $datos = array (
                "incidenciaEmpleadoEntidad" => $empleadoEntidadId,
                "incidenciaEmpleadoConsecutivo" => $empleadoConsecutivo,
                "incidenciaEmpleadoTipo" => $empleadoCategoria1,
                "incidenciaPuntoServicio" => $centroCosto,
                "incidenciaSupervisorEntidad" =>$supervisorEntidadId,
                "incidenciaSupervisorConsecutivo" => $supervisorConsecutivo,
                "incidenciaSupervisorTipo" => $supervisorCategoria,
                "incidenciaId" => $idNuevaIncidencia,
                "incidenciaUsuarioCaptura" => $usuario,
                "incidenciaComentario" =>"T x C Al Dia ".$fechaAsistencia." EN ".$puntoCierreName."," .$comentarioIncidencia.". ",
                "incidenciaPuesto" => $puestoCubierto,
                "numeroTurnos" => $numeroTurnos,
                "incidenciaFecha" => $incidenciaFecha,
                "neomenclaturaIncidencia"=>$neomenclaturaIncidencia,
                "fechaAsistencia"=>$fechaAsistencia,
                "roloperativo"=>$roloperativo,
            );
            //    $log->LogInfo("Valor de la variable datos: " . var_export ($datos, true));
            for($j=0; $j<$numeroTurnos; $j++){
                $negocio -> registroDiferencias($datos);                

            }
                //UPDATE PARA DESAPARECER LOS DATOS DEL FRONT Y NO PROCESAR 2 VECES LAS DIFERENCIAS
               $negocio -> negocio_actulizartblAsistenciaAPlicodiferencias($datos);                    
            $response ["status"] = "success";
            $response ["message"] ="Excelente";
        } //termina for
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