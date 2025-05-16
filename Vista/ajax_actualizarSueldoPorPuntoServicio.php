<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");

$negocio = new Negocio ();

$response = array ();

verificarInicioSesion ($negocio);
////$log = new KLogger ( "log_ajax_actualizarSueldoPorPuntoServicio.log" , KLogger::DEBUG );

if (!empty ($_POST))
{

    $usuario = $_SESSION ["userLog"]["usuario"];
    $empleadosConfirmadosParaActualizar=getValueFromPost("empleadosConfirmadosParaActualizar");     


     //$log->LogInfo("Valor de la variable \$empleadosConfirmadosParaActualizar: " . var_export ($empleadosConfirmadosParaActualizar, true));
    try
    {
        //$negocio -> insertSueldoEmpleado($datos);

        for ($i = 0; $i < count($empleadosConfirmadosParaActualizar); $i++){


            $empleado=$empleadosConfirmadosParaActualizar[$i];
            


             $empleadoidd = explode("-", $empleado);
/*
            $empleadoEntidadId=substr($empleado,0,2);
            $empleadoConsecutivo=substr($empleado,3,4);
            $empleadoCategoria=substr($empleado,8,2);
*/
        $empleadoEntidadId=$empleadoidd[0];
        $empleadoConsecutivo=$empleadoidd[1];
        $empleadoCategoria=$empleadoidd[2];
        
            //$log->LogInfo("Valor de la variable \$empleado: " . var_export ($empleadosConfirmadosParaActualizar[$i], true));
            
            $datosEmpleados= $negocio -> consultarEmpleadoById($empleadoEntidadId, $empleadoConsecutivo, $empleadoCategoria);
          
            $empleadoIdPuntoServicio=$datosEmpleados[0]["empleadoIdPuntoServicio"];
            $empleadoIdPuesto=$datosEmpleados[0]["empleadoIdPuesto"];
            $empleadoIdTurno=$datosEmpleados[0]["empleadoIdTurno"];
            
            //$log->LogInfo("Valor de la variable \$datosEmpleados: " . var_export ($datosEmpleados, true));

            $datos=array (
               "puntoServicio" => $empleadoIdPuntoServicio,
               "puestoId" => $empleadoIdPuesto,
               "rolId" => $empleadoIdTurno,
            );
    

            $datosTabulador= $negocio -> getCuotaDiariaByPerfil($datos); 
            //$log->LogInfo("Valor de la variable \$datosTabulador: " . var_export ($datosTabulador, true));

            if($datosTabulador==""){
                  
                $response ["status"] = "error";
                $response ["message"] = "Error: El perfil del elemento ".$empleado." no exiten en el tabulador";
                //$log->LogInfo("debe mandar error");

                break;
            }else{

                $sueldo=$datosTabulador["sueldo"];
                $cuotaDiaria=$datosTabulador["cuotaDiaria"];
                //$log->LogInfo("Valor de la variable \$sueldo: " . var_export ($sueldo, true));
                            
                $parametrosSueldoEmpleado=array( 
                    "empleadoEntidadCuota"=>$empleadoEntidadId,
                    "empleadoConsecutivoCuota"=>$empleadoConsecutivo,
                    "empleadoCategoriaCuota"=>$empleadoCategoria,
                );
                $existeSueldoEmpleado= $negocio -> verificarSueldoEmpleado($parametrosSueldoEmpleado);
                //$log->LogInfo("Valor de la variable \$existeSueldoEmpleado: " . var_export ($existeSueldoEmpleado, true));

                if($existeSueldoEmpleado==""){
                    $datosSueldo=array(
                        "sueldoEmpleado" =>$sueldo,
                        "cuotaDiariaEmpleado" => $cuotaDiaria,
                        "bonoAsistenciaEmpleado" =>"0",
                        "bonoPuntualidadEmpleado" =>"0",
                        "usuarioCapturaCuota" =>$usuario,
                        "empleadoEntidadCuota" =>$empleadoEntidadId,
                        "empleadoConsecutivoCuota" =>$empleadoConsecutivo,
                        "empleadoCategoriaCuota" =>$empleadoCategoria,
                    );
                    $negocio -> insertSueldoEmpleado($datosSueldo);
                    $response ["status"] = "success";
                    $response ["message"] = "Sueldos actualizados éxitosamente";
                }else{

                    $datosSueldo=array(
                        "sueldoEmpleado" =>$sueldo,
                        "cuotaDiariaEmpleado" => $cuotaDiaria,
                        "bonoAsistenciaEmpleado" =>"0",
                        "bonoPuntualidadEmpleado" =>"0",
                        "lastUserEditedCuota" =>$usuario,
                        "empleadoEntidadCuota" =>$empleadoEntidadId,
                        "empleadoConsecutivoCuota" =>$empleadoConsecutivo,
                        "empleadoCategoriaCuota" =>$empleadoCategoria,
                    );
                    $negocio -> updateSueldoEmpleado($datosSueldo);
                    
                    $response ["status"] = "success";
                    $response ["message"] = "Sueldos actualizados éxitosamente";
                }
                continue;
            }



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