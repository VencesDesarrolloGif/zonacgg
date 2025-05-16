<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);



//$log = new KLogger ( "ajax_generarResumenAsistencia.log" , KLogger::DEBUG );

$response = array("status" => "success");

try{

    $puntoServicioId=getValueFromPost ("puntoServicioId");
    $fechaInicial = getValueFromPost ("fechaInicial");
    $fechaFinal = getValueFromPost ("fechaFinal");

    //$log->LogInfo("Valor de la variable \$puntoServicioId: " . var_export ($puntoServicioId, true));
    //$log->LogInfo("Valor de la variable \$fechaInicial: " . var_export ($fechaInicial, true));
    //$log->LogInfo("Valor de la variable \$fechaFinal: " . var_export ($fechaFinal, true));


    $lista= $negocio -> getDetalleRequisicionesByPuntoServicioId($puntoServicioId);


    // Calcula la cantidad de turnos por día
    $turnosPorDia = 0;
    foreach ($lista as $item)
    {
        $turnosPorDia += $item["turnosPorDia"];
        //$log->LogInfo("Valor de la variable \$turnosPorDia: " . var_export ($turnosPorDia, true));
    }

    $startDate = strtotime ($fechaInicial);
    $endDate = strtotime ($fechaFinal);

    $result = array ();
    $result [] = "";
    $result2[]="";

    $listaTurnosCubiertos = $negocio -> getTurnosCubiertosByPeriodoFechasAndPuntoServicio ($fechaInicial, $fechaFinal, $puntoServicioId); 


    

    // Crea los resultados
    /*while ( $startDate <= $endDate )
    {
        $fecha = date ("Y-m-d", $startDate);

        $turnosCubiertos = (isset ($listaTurnosCubiertos [$fecha]) ? $listaTurnosCubiertos [$fecha]["cantidadTurnos"] : 0);

        $result [$fecha]["turnosPorDia"] = $turnosPorDia;
        $result [$fecha]["turnosCubiertos"] = $turnosCubiertos;

        $startDate += 86400;

        $log->LogInfo("Valor de la variable \$fecha: " . var_export ($fecha, true));

    }
    */
//$log->LogInfo("Valor de la variable : " . var_export ($listaincidencias, true));
   // $log->LogInfo("Valor de la variable : " . var_export (count($listaincidencias[0]["fechaAsistencia"]=="2020-04-17"), true));


    for ($i =$fechaInicial; $i <=$fechaFinal; $i = date("Y-m-d", strtotime($i ."+ 1 days")))
    {   

        $fecha = $i;


       

//$log->LogInfo("Valor de la variable \$listaincidencias: " . var_export ($fecha) , true));
//$log->LogInfo("Valor de la variable \$listaincidencias: " . var_export ([""]) , true));
        $turnosCubiertos = (isset ($listaTurnosCubiertos [$fecha]) ? $listaTurnosCubiertos [$fecha]["cantidadTurnos"] : 0);

        $listaincidencias = $negocio -> getTurnosCubiertosByPeriodoFechasAndPuntoServicioconteo($fecha,$puntoServicioId);
        $bajasPorDia = $negocio -> getBajasPorDias($fecha,$puntoServicioId,1);
        $ingresosPorDia = $negocio -> getBajasPorDias($fecha,$puntoServicioId,2);
        $faltaspordia = $negocio -> getBajasPorDias($fecha,$puntoServicioId,3);
        $permisospordia = $negocio -> getBajasPorDias($fecha,$puntoServicioId,4);
        $incapacidadespordia = $negocio -> getBajasPorDias($fecha,$puntoServicioId,5);


        $turnosdedia = $negocio -> getTurnosdeDiaoNoche($fecha,$puntoServicioId,1);
        $turnosdenoche = $negocio -> getTurnosdeDiaoNoche($fecha,$puntoServicioId,2);
        
       // $turnos

        //$log->LogInfo("Valor de la variable \$listaincidencias: " . var_export ($listaincidencias, true));
       // $turnosdedia=0;

       // $log->LogInfo("Valor de la variable \$listaincidencias: " . var_export ($turnosdedia, true));
        //$log->LogInfo("Valor de la variable \$listaincidencias: " . var_export ($turnosdenoche, true));

if(count($listaincidencias)==0){
     $listaincidencias[0]["nomenclaturaIncidencia"]="na"; 
        $listaincidencias[0]["valorAsistencia"]=0;
        $listaincidencias[0]["cantidadTurnos"]=0;
         
}

       
           
        $result[$i]["incidencias"] = $listaincidencias;  
        $result [$i]["turnosPorDia"] = $turnosPorDia;
        $result [$i]["turnosCubiertos"] = $turnosCubiertos;
        $result[$i]["turnosdedia"]=$turnosdedia;
        $result[$i]["turnosdenoche"]=$turnosdenoche;
        $result[$i]["bajaspordia"]=$bajasPorDia;
        $result[$i]["ingresospordia"]=$ingresosPorDia;
        $result[$i]["faltaspordia"]=$faltaspordia;
        $result[$i]["permisospordia"]=$permisospordia;
        $result[$i]["incapacidadespordia"]=$incapacidadespordia;



        
        
        

        
}

    $response ["result"] = $result;

    

   // $log->LogInfo("Valor de la variable \$lista: " . var_export ($response, true));

} 
catch( Exception $e )
{
    $response["status"]="error";
    $response["error"]="No se puedo obtener consulta";
}

echo json_encode($response);

