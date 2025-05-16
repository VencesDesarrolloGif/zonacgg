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
//$log = new KLogger ( "ajaxRegistroHistoricoBaja.log" , KLogger::DEBUG );


    $numeroEmpleado=getValueFromPost("numeroEmpleado");
    $supervisorId=getValueFromPost("supervisorId");
    $puestoCubiertoId=getValueFromPost("puestoCubiertoId");



            $empleadoidd = explode("-", $numeroEmpleado);
/*
        $empleadoEntidad=substr($numeroEmpleado, 0,2);
        $empleadoConsecutivo=substr($numeroEmpleado, 3,4);
        $empleadoCategoria=substr($numeroEmpleado, 8,2);
*/
        $empleadoEntidad=$empleadoidd[0];
        $empleadoConsecutivo=$empleadoidd[1];
        $empleadoCategoria=$empleadoidd[2];




        $supervisorIdd = explode("-", $supervisorId);
/*
        $supervisorEntidad=substr($supervisorId, 0,2);
        $supervisorConsecutivo=substr($supervisorId, 3,4);
        $supervisorCategoria=substr($supervisorId, 8,2);
*/
        $supervisorEntidad=$supervisorIdd[0];
        $supervisorConsecutivo=$supervisorIdd[1];
        $supervisorCategoria=$supervisorIdd[2];
    $usuario = $_SESSION ["userLog"]["usuario"];

    $rolusuario=$_SESSION ["userLog"]["rol"];

     $estatusoperaciones=3;
    if($rolusuario!="Lider Unidad"){
         $estatusoperaciones=0;

    }

    $datosBaja= array (
    "banderaBetado" => strtoupper(getValueFromPost("banderaBetado")),
    "ComentarioBetado" => strtoupper(getValueFromPost("ComentarioBetado")),
    "empleadoEntidadBaja" =>$empleadoEntidad,
    "empleadoConsecutivoBaja" =>$empleadoConsecutivo, 
    "empleadoCategoriaBaja" =>$empleadoCategoria,
    "idMotivoBaja" => getValueFromPost("idMotivoBaja"),
    "fechaIngreso" => strtoupper(getValueFromPost("fechaIngreso")),
    "fechaCausaBaja" => strtoupper(getValueFromPost("fechaCausaBaja")),
    "comentarioBaja" => strtoupper(getValueFromPost("comentarioBaja")),
    "usuarioCapturaBaja" => $usuario,
    "tipoPeriodo" => getValueFromPost("tipoPeriodo"),
    "puntoServicioId" => getValueFromPost("puntoServicioId"),
    "idPlantillaServicio" => getValueFromPost("idPlantillaServicio"),
    "supervisorEntidadBaja" =>$supervisorEntidad,
    "supervisorConsecutivoBaja" =>$supervisorConsecutivo,
    "supervisorCategoriaBaja" =>$supervisorCategoria,
    "incidenciaId" =>"10",
    "puestoCubiertoId" => $puestoCubiertoId,
    "roloperativo" => getValueFromPost("roloperativo"), 
    "estatusoperaciones"=>$estatusoperaciones
    );

    $empleado ["entidadId"] = $empleadoEntidad;
    $empleado ["consecutivoId"] = $empleadoConsecutivo;
    $empleado ["tipoId"] = $empleadoCategoria; 

    $usuarioBloqueo=$empleadoEntidad.$empleadoConsecutivo.$empleadoCategoria;
    
   // $log->LogInfo("Valor de la variable \$datosBaja: " . var_export ($datosBaja, true));
    try
    {
        $negocio -> negocio_registrarHistoricoBaja($datosBaja,$rolusuario);
        $negocio -> bloqueoCuentaUsuario($usuarioBloqueo);
        
        
        $response ["status"] = "success";
        $response ["message"] = "REGISTRO DE BAJA CON EXITO";
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