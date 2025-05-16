<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_consultaFiniquitosParaComplemento.log" , KLogger::DEBUG );
$fechainicio=$_POST["fechainicio"];
$fechafin=$_POST["fechafin"];
//$log->LogInfo("Valor de _POST  " . var_export ($_POST, true));

try {
    $tableFiniquitosPrecesados   = $negocio->ObtenerFiniquitosPrecesados($fechainicio,$fechafin);
    $counttableFiniquitosPrecesados = count($tableFiniquitosPrecesados);
//$log->LogInfo("Valor de tableFiniquitosPrecesados  " . var_export ($tableFiniquitosPrecesados, true));

    for($i=0; $i<$counttableFiniquitosPrecesados;$i++){
        $EstatusComplemento = $tableFiniquitosPrecesados[$i]["EstatusComplemento"];
        $EntidadEmpleado = $tableFiniquitosPrecesados[$i]["EntidadEmpleado"];
        $ConsecutivoEmpleado = $tableFiniquitosPrecesados[$i]["ConsecutivoEmpleado"];
        $CategoriaEmlpeado = $tableFiniquitosPrecesados[$i]["CategoriaEmlpeado"];
        $netoAlPago = $tableFiniquitosPrecesados[$i]["netoAlPago"];
        $folioFiniquito = $tableFiniquitosPrecesados[$i]["FolioFiniquito"];

        if($EstatusComplemento=="0"){
            $tableFiniquitosPrecesados[$i]["accion"]   = "<a id='realizarAccionComplementosFiniquito' title='Solicitar un complemento' onclick=MostrarModalIngresoComplemento('$EntidadEmpleado','$ConsecutivoEmpleado','$CategoriaEmlpeado','$netoAlPago','$folioFiniquito') style='cursor: pointer;color:blue;' data-toggle='tab'>Ingresar Complemento</a>";
        }
        else if($EstatusComplemento=="1"){
            $tableFiniquitosPrecesados[$i]["accion"]   = "<a id='noRealizarAccionComplementosFiniquito' title='Ya Fue solicitado un complemento esperando respuesta de dirección geneal' style='cursor: pointer;color:orange;' data-toggle='tab'>Complemento Solicitado</a>";
        }
        else if($EstatusComplemento=="2"){
            $tableFiniquitosPrecesados[$i]["accion"]   = "<a id='realizarAccionComplementosFiniquito' title='El complemento solicitado fue rechazado por dirección general solicitar un nuevo complemento' onclick=MostrarModalIngresoComplemento('$EntidadEmpleado','$ConsecutivoEmpleado','$CategoriaEmlpeado','$netoAlPago','$folioFiniquito') style='cursor: pointer;color:red;' data-toggle='tab'>Complemento Rechazado Ingresar Nuevo</a>";
        }
        else if($EstatusComplemento=="3"){
            $tableFiniquitosPrecesados[$i]["accion"]   = "<a id='realizarAccionComplementosFiniquito' title='El complemento fue aceptadp por dirección general' style='cursor: pointer;color:green;' data-toggle='tab'>Complemento Aceptado</a>";
        }
        else if($EstatusComplemento=="4"){
            $tableFiniquitosPrecesados[$i]["accion"]   = "<a id='realizarAccionComplementosFiniquito' title='El complemento ya fue pagado no se puede realizar mas acciones' style='cursor: pointer;color:black;' data-toggle='tab'>Solicitud del complemento terminado</a>";
        }
    }
    /*
    Estatus Complemento
    0 -> No Se ha solicitado ningun complemento (azul)
    1 -> Se solicito un complemento a direccion General (naranja)
    2 -> Rechazado por direccion general tiene que solicitar uno nuevo (Rojo)
    3 -> Aceptado por direccion general pasa a contabilidad (verde)
    4 -> pagado por contabilidad ya no se puede hacer nada a ese finiquito (negro)
    */

    

    $response["datos"] = $tableFiniquitosPrecesados;

} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No Se Obtuvieron Los Dias Disponibles";
}

echo json_encode($response);
