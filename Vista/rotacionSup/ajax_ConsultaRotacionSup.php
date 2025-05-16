<?php
session_start();
require "../conexion.php"; 
require_once("../../libs/logger/KLogger.php");
$log=new KLogger("ajax_ConsultaRotacionSup.log", KLogger::DEBUG);
if (!isset($_SESSION["userLog"])) {
    header ("Location: https://zonagifseguridad.com.mx//zonagif/Vista/LoginSuperUsuario/form_LoginSuperUsuario.php");
    exit;
}

$response = array();
$supervisores = array();
$puntoServicio = array();
$empleados = array();
$quinceSup = array();
$listaCompletaSup = array();
$mejoresSupervisores = array();
$altasReingresosSup  = array();
$elementosPorFechas  = array();
$arregloFechas  = array();
$response["status"] = "error";
    // $log->LogInfo("Valor de la variable _SESSION: " . var_export ($_SESSION, true));     

$fechai  = $_POST['fechai'];
$fechaf  = $_POST['fechaf'];
$lineaNeg= $_POST['lineaNeg'];
$region  = $_POST['region'];
$entidad = $_POST['entidad'];
$tipoB   = $_POST['tipoBusqueda'];
$rol = $_SESSION["userLog"]["rol"];

if($rol=="Supervisor"){

   $noSupervisor = $_SESSION["userLog"]["empleadoId"];
   $sql0 = "SELECT e.entidadFederativaId,
                   e.empleadoConsecutivoId,
                   e.empleadoCategoriaId,
                   concat_ws('-',e.entidadFederativaId, e.empleadoConsecutivoId,e.empleadoCategoriaId) as supervisorId,
                   concat( e.nombreEmpleado, ' ', e.apellidoPaterno, ' ', e.apellidoMaterno) AS nombre,
                   ef.nombreEntidadFederativa
            FROM empleados e
            LEFT JOIN entidadesfederativas ef on ef.idEntidadFederativa=e.idEntidadTrabajo
            WHERE concat_ws('-',e.entidadFederativaId, e.empleadoConsecutivoId,e.empleadoCategoriaId)='$noSupervisor'";

            $res0 = mysqli_query($conexion, $sql0);
            while ($reg0 = mysqli_fetch_array($res0, MYSQLI_ASSOC)) {
            $supervisores[] = $reg0;
            }

            $numeroSup=$supervisores[0]["supervisorId"];
            $nombreSup=$supervisores[0]["nombre"];

       $sql5 = "SELECT (SELECT count(e.empleadoEstatusId) as altas
                        FROM empleados e
                        LEFT JOIN empleados es on (e.idEntidadResponsableAsistencia=es.entidadFederativaId and e.consecutivoResponsableAsistencia=es.empleadoConsecutivoId and e.tipoResponsableAsistencia=es.empleadoCategoriaId)
                        WHERE concat_ws('-',e.idEntidadResponsableAsistencia,e.consecutivoResponsableAsistencia,e.tipoResponsableAsistencia)='$noSupervisor' 
                        AND e.idTipoPuesto='03'
                        AND  (e.empleadoEstatusId=1) AND (e.fechaIngresoEmpleado BETWEEN CAST('$fechai' AS DATE) AND CAST('$fechaf' AS DATE)) 
                        GROUP BY e.empleadoEstatusId) as empleadosA,

                        (SELECT count(e.empleadoEstatusId) as bajas
                        FROM empleados e
                        LEFT JOIN empleados es on (e.idEntidadResponsableAsistencia=es.entidadFederativaId and e.consecutivoResponsableAsistencia=es.empleadoConsecutivoId and e.tipoResponsableAsistencia=es.empleadoCategoriaId)
                        WHERE concat_ws('-',e.idEntidadResponsableAsistencia,e.consecutivoResponsableAsistencia,e.tipoResponsableAsistencia)='$noSupervisor' 
                        AND e.idTipoPuesto='03'
                        AND (e.empleadoEstatusId=0) AND (e.fechaBajaEmpleado BETWEEN CAST('$fechai' AS DATE) AND CAST('$fechaf' AS DATE)) 
                        GROUP BY e.empleadoEstatusId) as empleadosB,
                            
                            ifnull((SELECT ifnull(count(e.empleadoEstatusId),0) as reingresos
                        FROM empleados e
                        LEFT JOIN empleados es on (e.idEntidadResponsableAsistencia=es.entidadFederativaId and e.consecutivoResponsableAsistencia=es.empleadoConsecutivoId and e.tipoResponsableAsistencia=es.empleadoCategoriaId)
                        WHERE concat_ws('-',e.idEntidadResponsableAsistencia,e.consecutivoResponsableAsistencia,e.tipoResponsableAsistencia)='$noSupervisor' 
                        AND e.idTipoPuesto='03'
                        AND  (e.empleadoEstatusId=2) AND (e.fechaIngresoEmpleado BETWEEN CAST('$fechai' AS DATE) AND CAST('$fechaf' AS DATE)) 
                        GROUP BY e.empleadoEstatusId),0) as empleadosR,
                        '$noSupervisor' as noSup, '$nombreSup' as nombreSup
                  FROM empleados
                  LIMIT 1";
          // $log->LogInfo("Valor de la variable sql5: " . var_export ($sql5, true));     
          $res5 = mysqli_query($conexion, $sql5);
                 while ($reg5 = mysqli_fetch_array($res5, MYSQLI_ASSOC)) {
                 $listaCompletaSup[] = $reg5;
          }

          $quinceSup=$listaCompletaSup;

          ///////////////////////////////////////////////////////////////////////////////////////////////////////////

          $fechaini = new DateTime($fechai);
          $fechafin = new DateTime($fechaf);
          // $diasConsultados = date_diff($fechaini, $fechafin);
          $diasConsultados = $fechaini->diff($fechafin);
          // $aaa=$diasConsultados->days;

          // $log->LogInfo("Valor de la variable aaa: " . var_export ($aaa, true));     
          // $log->LogInfo("Valor de la variable diasConsultados1: " . var_export ($diasConsultados, true));     

          $conteoFechaRecorridas=0;
          
          for($h = $fechaini; $h <= $fechafin; $h->modify('+1 day')){

              $conteoBajasXdia=0;
              $conteoActivosXdia=0;
              $conteoReingresoXdia=0;
              $fechaFor=$h->format("d-m-Y");
              $fechaConsulta=$h->format("Y-m-d");
              $elementosPorFechas=[];

              // $log->LogInfo("Valor de la variable fechaFor: " . var_export ($fechaFor, true));   

              $sql7 = "SELECT empleadoEstatusId
                       FROM empleados 
                       WHERE idTipoPuesto='03'
                       AND concat_ws('-', idEntidadResponsableAsistencia,consecutivoResponsableAsistencia,tipoResponsableAsistencia)='$numeroSup'
                       AND ((empleadoEstatusId=0) AND (fechaBajaEmpleado = CAST('$fechaConsulta' AS DATE))
                       OR  ((empleadoEstatusId=1  OR empleadoEstatusId=2) AND (fechaIngresoEmpleado=CAST('$fechaConsulta' AS DATE))))";
   
            // $log->LogInfo("Valor de la variable sql7: " . var_export ($sql7, true));     
            $res7 = mysqli_query($conexion, $sql7);
                   while ($reg7 = mysqli_fetch_array($res7, MYSQLI_ASSOC)) {
                   $elementosPorFechas[] = $reg7;
            } 

            // $log->LogInfo("Valor de la variable elementosPorFechas: " . var_export ($elementosPorFechas, true));     
            if(count($elementosPorFechas)!=0) {
               for($i=0; $i < count($elementosPorFechas); $i++) { 
   
                  $estatusEmpleado=$elementosPorFechas[$i]["empleadoEstatusId"];
   
                  if($estatusEmpleado== '0'){
                        $conteoBajasXdia = $conteoBajasXdia+1;
                     }
                     if($estatusEmpleado== "1"){
                       $conteoActivosXdia = $conteoActivosXdia+1;
                     }
                     if($estatusEmpleado== "2"){
                        $conteoReingresoXdia = $conteoReingresoXdia+1;
                     }
   
                  $arregloFechas[$conteoFechaRecorridas]["fecha"]= $fechaFor;
                  $arregloFechas[$conteoFechaRecorridas]["bajas"]= $conteoBajasXdia;
                  $arregloFechas[$conteoFechaRecorridas]["altas"]= $conteoActivosXdia;
                  $arregloFechas[$conteoFechaRecorridas]["reingresos"]= $conteoReingresoXdia;
   
               }//for i
            }//si no trae nada en ese dia
            else{
               $arregloFechas[$conteoFechaRecorridas]["fecha"]= $fechaFor;
               $arregloFechas[$conteoFechaRecorridas]["bajas"]= 0;
               $arregloFechas[$conteoFechaRecorridas]["altas"]= 0;
               $arregloFechas[$conteoFechaRecorridas]["reingresos"]= 0;
            }
              $conteoFechaRecorridas=$conteoFechaRecorridas+1;
          }//for h


          ///////////////////////////////////////////////////////////////////////////////////////////////////////////

}else{
   
   $sql0 = "SELECT e.entidadFederativaId,
                   e.empleadoConsecutivoId,
                   e.empleadoCategoriaId,
                   concat_ws('-',e.entidadFederativaId, e.empleadoConsecutivoId,e.empleadoCategoriaId) as supervisorId,
                   concat( e.nombreEmpleado, ' ', e.apellidoPaterno, ' ', e.apellidoMaterno) AS nombre,
                   ef.nombreEntidadFederativa
            FROM empleados e
            LEFT JOIN entidadesfederativas ef on ef.idEntidadFederativa=e.idEntidadTrabajo
            WHERE (empleadoIdPuesto=6 or empleadoIdPuesto=88 or empleadoIdPuesto=61) and e.empleadoEstatusId<>0
            AND empleadoLineaNegocioId='1'";

            if($entidad!='0'){
               $sql0.=" AND e.idEntidadTrabajo='$entidad'";
            }else{

               $sql3 = "SELECT idEntidadI 
                        FROM index_regiones 
                        WHERE idLineaNegI=$lineaNeg
                        AND idRegionI=$region
                        AND idEntidadI!='33' 
                        AND idEntidadI!='50'";

               $res3 = mysqli_query($conexion, $sql3);
                      while ($reg3 = mysqli_fetch_array($res3, MYSQLI_ASSOC)) {
                      $entidades[] = $reg3;
               }

               $sql0.=" AND (";

               for($d=0; $d < count($entidades); $d++) { 
                   
                   $idEntidad=$entidades[$d]["idEntidadI"];

                   if ($d=='0') {
                      $sql0.="  e.idEntidadTrabajo='$idEntidad'";
                   }else{
                      $sql0.=" OR e.idEntidadTrabajo='$idEntidad'";
                   }

               }
               $sql0.=" )";
            }//else entidad
   $sql0.=" ORDER BY e.nombreEmpleado ASC";

   $res0 = mysqli_query($conexion, $sql0);
          while ($reg0 = mysqli_fetch_array($res0, MYSQLI_ASSOC)) {
          $supervisores[] = $reg0;
   }


      $sql4 = "SELECT count(e.empleadoEstatusId) as empleadosB,
                      concat_ws('-',e.idEntidadResponsableAsistencia,e.consecutivoResponsableAsistencia,e.tipoResponsableAsistencia) as noSup,
                      concat_ws(' ',es.nombreEmpleado,es.apellidoPaterno,es.apellidoMaterno) as nombreSup
               FROM empleados e
               LEFT JOIN empleados es on (e.idEntidadResponsableAsistencia=es.entidadFederativaId and e.consecutivoResponsableAsistencia=es.empleadoConsecutivoId and e.tipoResponsableAsistencia=es.empleadoCategoriaId)
               WHERE (";

               for($e=0; $e < count($supervisores); $e++){  

                  $noSupervisor= $supervisores[$e]["supervisorId"];
                  $nombreSup   = $supervisores[$e]["nombre"];

                  if($tipoB=='1'){//15 mejores SE METE AQUI PARA NO HACER OTRO FOR
                              // SOLO SE TRAEN 
                     $sql5 = "SELECT  ifnull((SELECT count(e.empleadoEstatusId) as bajas
                                      FROM empleados e
                                      LEFT JOIN empleados es on (e.idEntidadResponsableAsistencia=es.entidadFederativaId and e.consecutivoResponsableAsistencia=es.empleadoConsecutivoId and e.tipoResponsableAsistencia=es.empleadoCategoriaId)
                                      WHERE concat_ws('-',e.idEntidadResponsableAsistencia,e.consecutivoResponsableAsistencia,e.tipoResponsableAsistencia)='$noSupervisor' 
                                      AND e.idTipoPuesto='03'
                                      AND (e.empleadoEstatusId=0) AND (e.fechaBajaEmpleado BETWEEN CAST('$fechai' AS DATE) AND CAST('$fechaf' AS DATE)) 
                                      GROUP BY e.empleadoEstatusId),0) as empleadosB,
                                          
                                      ifnull((SELECT count(e.empleadoEstatusId) as altas
                                      FROM empleados e
                                      LEFT JOIN empleados es on (e.idEntidadResponsableAsistencia=es.entidadFederativaId and e.consecutivoResponsableAsistencia=es.empleadoConsecutivoId and e.tipoResponsableAsistencia=es.empleadoCategoriaId)
                                      WHERE concat_ws('-',e.idEntidadResponsableAsistencia,e.consecutivoResponsableAsistencia,e.tipoResponsableAsistencia)='$noSupervisor' 
                                      AND e.idTipoPuesto='03'
                                      AND  (e.empleadoEstatusId=1) AND (e.fechaIngresoEmpleado BETWEEN CAST('$fechai' AS DATE) AND CAST('$fechaf' AS DATE)) 
                                      GROUP BY e.empleadoEstatusId),0) as empleadosA,
                                          
                                      ifnull((SELECT ifnull(count(e.empleadoEstatusId),0) as reingresos
                                      FROM empleados e
                                      LEFT JOIN empleados es on (e.idEntidadResponsableAsistencia=es.entidadFederativaId and e.consecutivoResponsableAsistencia=es.empleadoConsecutivoId and e.tipoResponsableAsistencia=es.empleadoCategoriaId)
                                      WHERE concat_ws('-',e.idEntidadResponsableAsistencia,e.consecutivoResponsableAsistencia,e.tipoResponsableAsistencia)='$noSupervisor' 
                                      AND e.idTipoPuesto='03'
                                      AND  (e.empleadoEstatusId=2) AND (e.fechaIngresoEmpleado BETWEEN CAST('$fechai' AS DATE) AND CAST('$fechaf' AS DATE)) 
                                      GROUP BY e.empleadoEstatusId),0) as empleadosR,
                                      '$noSupervisor' as noSup, '$nombreSup' as nombreSup
                              FROM empleados
                              LIMIT 1";
                     // $log->LogInfo("Valor de la variable sql5: " . var_export ($sql5, true));     
                     $res5 = mysqli_query($conexion, $sql5);
                            while ($reg5 = mysqli_fetch_array($res5, MYSQLI_ASSOC)) {
                            $listaCompletaSup[] = $reg5;//se llena el arreglo con la info de los supervisores,Altas-Bajas-reingresos
                     }
                  }//if 15 mejores

                  if ($e=='0') {
                      $sql4.=" concat_ws('-',e.idEntidadResponsableAsistencia,e.consecutivoResponsableAsistencia,e.tipoResponsableAsistencia)='$noSupervisor'";
                   }else{
                      $sql4.="OR concat_ws('-',e.idEntidadResponsableAsistencia,e.consecutivoResponsableAsistencia,e.tipoResponsableAsistencia)='$noSupervisor'";
                   }
               }//for e SUPERVISOR

               $sql4.=") 
                       AND e.idTipoPuesto='03'
                       AND ((e.empleadoEstatusId=0) AND (e.fechaBajaEmpleado BETWEEN CAST('$fechai' AS DATE) AND CAST('$fechaf' AS DATE)))  
                       GROUP BY concat_ws('-',e.idEntidadResponsableAsistencia,e.consecutivoResponsableAsistencia,e.tipoResponsableAsistencia)";

               if($tipoB=='1'){//15 mejores
                  $sql4.=" ORDER BY empleadosB ASC";
               }else{//15 PEORES
                     $sql4.=" ORDER BY empleadosB DESC";
               }

                     $sql4.=" LIMIT 15";
                     // $log->LogInfo("Valor de la variable sql4: " . var_export ($sql4, true));     

               $res4 = mysqli_query($conexion, $sql4);
                      while ($reg4 = mysqli_fetch_array($res4, MYSQLI_ASSOC)) {
                      $quinceSup[] = $reg4;//obtiene supervisores con minimo 1 baja ordenados de menor a mayor para complementar la lista de los empleados con cero bajas y obtener los 15 mejores
               }
                     // $log->LogInfo("Valor de la variable listaCompletaSup: " . var_export ($listaCompletaSup, true));     

            if($tipoB=='1'){//15 mejores AQUI SE ORGANIZA LO DEL FOR DE ALLA ARRIBA (SQL5) 

               $conteoSupConCeroElem=0;
               for($f=0; $f < count($listaCompletaSup); $f++) { 
                  
                   $conteoAltas=$listaCompletaSup[$f]["empleadosA"];
                   $conteoBajas=$listaCompletaSup[$f]["empleadosB"];
                   $conteoReing=$listaCompletaSup[$f]["empleadosR"];

                   $nombreSupervisor=$listaCompletaSup[$f]["nombreSup"];
                   $numeroSupervisor=$listaCompletaSup[$f]["noSup"];
                  if($conteoBajas=='0'){//SON LOS SUPERVISORES CON CERO BAJAS EN ESE DIA

                     $mejoresSupervisores[$conteoSupConCeroElem]["nombreSup"] =$nombreSupervisor;
                     $mejoresSupervisores[$conteoSupConCeroElem]["noSup"] =$numeroSupervisor;
                     $mejoresSupervisores[$conteoSupConCeroElem]["empleadosB"] =$conteoBajas;
                     $mejoresSupervisores[$conteoSupConCeroElem]["empleadosA"] =$conteoAltas;
                     $mejoresSupervisores[$conteoSupConCeroElem]["empleadosR"] =$conteoReing;
                     $conteoSupConCeroElem=$conteoSupConCeroElem+1;
                  }
               }//for f

               $totalMejores=count($mejoresSupervisores);
                     // $log->LogInfo("Valor de la variable sql4: " . var_export ($sql4, true));     

               if($totalMejores>15){
                  $totalMejores=15;
               }else{
                     $totalMejoresMasUno=$totalMejores+1;

                     if($totalMejoresMasUno<16) {
                        // for($g=0; $g < $supervisoresFaltantes; $g++) { 
                        for($g=0; $g < count($quinceSup); $g++) { 
                            $peoresNombres=$quinceSup[$g]["nombreSup"];
                            $peoresNumeroEmp=$quinceSup[$g]["noSup"];
                            $peoresElementosBaja=$quinceSup[$g]["empleadosB"];

                            $sql6 = "SELECT ifnull((SELECT count(e.empleadoEstatusId) as altas
                                                    FROM empleados e
                                                    LEFT JOIN empleados es on (e.idEntidadResponsableAsistencia=es.entidadFederativaId and e.consecutivoResponsableAsistencia=es.empleadoConsecutivoId and e.tipoResponsableAsistencia=es.empleadoCategoriaId)
                                                    WHERE concat_ws('-',e.idEntidadResponsableAsistencia,e.consecutivoResponsableAsistencia,e.tipoResponsableAsistencia)='$peoresNumeroEmp' 
                                                    AND e.idTipoPuesto='03'
                                                    AND  (e.empleadoEstatusId=1) AND (e.fechaIngresoEmpleado BETWEEN CAST('$fechai' AS DATE) AND CAST('$fechaf' AS DATE)) 
                                                    GROUP BY e.empleadoEstatusId),0) as empleadosA,
                                             ifnull((SELECT ifnull(count(e.empleadoEstatusId),0) as reingresos
                                                     FROM empleados e
                                                     LEFT JOIN empleados es on (e.idEntidadResponsableAsistencia=es.entidadFederativaId and e.consecutivoResponsableAsistencia=es.empleadoConsecutivoId and e.tipoResponsableAsistencia=es.empleadoCategoriaId)
                                                     WHERE concat_ws('-',e.idEntidadResponsableAsistencia,e.consecutivoResponsableAsistencia,e.tipoResponsableAsistencia)='$peoresNumeroEmp' 
                                                     AND e.idTipoPuesto='03'
                                                     AND  (e.empleadoEstatusId=2) AND (e.fechaIngresoEmpleado BETWEEN CAST('$fechai' AS DATE) AND CAST('$fechaf' AS DATE)) 
                                                     GROUP BY e.empleadoEstatusId),0) as empleadosR
                              FROM empleados
                              LIMIT 1";

                            $res6 = mysqli_query($conexion, $sql6);
                                   while ($reg6 = mysqli_fetch_array($res6, MYSQLI_ASSOC)) {
                                   $altasReingresosSup[] = $reg6;//trae altas y reingresos de los mejores empleados que tienen al menos una baja
                            }

                            $peoresElementosAltas=$altasReingresosSup[0]["empleadosA"];
                            $peoresElementosReing=$altasReingresosSup[0]["empleadosR"];
      
                            $mejoresSupervisores[$totalMejores]["nombreSup"] =$peoresNombres;
                            $mejoresSupervisores[$totalMejores]["noSup"] =$peoresNumeroEmp;
                            $mejoresSupervisores[$totalMejores]["empleadosB"] =$peoresElementosBaja;
                            $mejoresSupervisores[$totalMejores]["empleadosA"] =$peoresElementosAltas;
                            $mejoresSupervisores[$totalMejores]["empleadosR"] =$peoresElementosReing;
                            $totalMejores=$totalMejores+1;
                        }//for g
                     }//if menor de 15
               }

            // $response["totalMejores"]  = $totalMejores;
            $quinceSup = $mejoresSupervisores;

            }//tipo 15 mejores se organizan


}//else supervisores por DG,CC, GR, Contrata, etc.

   for($a=0; $a < count($supervisores); $a++){ 

      $puntoServicio= [];
      $conteoActivos=0;
      $conteoBajas=0;
      $conteoReingreso=0;
      $entidadSup=$supervisores[$a]["entidadFederativaId"];
      $consecutivoSup=$supervisores[$a]["empleadoConsecutivoId"];
      $categoriaSup=$supervisores[$a]["empleadoCategoriaId"];

      $noEupervisor=$supervisores[$a]["supervisorId"];

      $nombreEntidadFederativaM=strtoupper($supervisores[$a]["nombreEntidadFederativa"]);
      $supervisores[$a]["nombreEntidadFederativa"]=$nombreEntidadFederativaM;

            $empleados=[];
   
            $sql2 = "SELECT empleadoEstatusId,fechaIngresoEmpleado,fechaBajaEmpleado
                     FROM empleados 
                     WHERE idTipoPuesto='03'
                     AND idEntidadResponsableAsistencia='$entidadSup'
                     AND consecutivoResponsableAsistencia='$consecutivoSup'
                     AND tipoResponsableAsistencia='$categoriaSup'
                     AND ((empleadoEstatusId=0) AND (fechaBajaEmpleado BETWEEN CAST('$fechai' AS DATE) AND CAST('$fechaf' AS DATE))  
                     OR  ((empleadoEstatusId=1  OR empleadoEstatusId=2) AND (fechaIngresoEmpleado BETWEEN CAST('$fechai' AS DATE) AND CAST('$fechaf' AS DATE))))";
   
            // $log->LogInfo("Valor de la variable consecutivoSup: " . var_export ($consecutivoSup, true));     
            $log->LogInfo("Valor de la variable sql2: " . var_export ($sql2, true));     
            $res2 = mysqli_query($conexion, $sql2);
                   while ($reg2 = mysqli_fetch_array($res2, MYSQLI_ASSOC)) {
                   $empleados[] = $reg2;
            }   

            if(count($empleados)==0 || count($empleados)=="" || count($empleados)=="NULL" || count($empleados)==NULL || count($empleados)=="null" || count($empleados)==null) {
               $supervisores[$a]["bajas"]     =0;
               $supervisores[$a]["ingresos"]  =0;
               $supervisores[$a]["reingresos"]=0;
            }else{
               for($c=0; $c < count($empleados); $c++) { 
   
                  $estatusEmp= $empleados[$c]["empleadoEstatusId"];
   
                  if($estatusEmp== '0' ){
                     $conteoBajas = $conteoBajas+1;
                     $estatusEmp= $empleados[$c]["empleadoEstatusId"];
                  }
                  if($estatusEmp== "1" ){
                    $conteoActivos = $conteoActivos+1;
                  }
                  if($estatusEmp== "2" ){
                     $conteoReingreso = $conteoReingreso+1;
                  }
               }  //for c

               $supervisores[$a]["ingresos"]  =$conteoActivos;
               $supervisores[$a]["bajas"]     =$conteoBajas;
               $supervisores[$a]["reingresos"]=$conteoReingreso;
            }
         // }//for b
     /* }else{
      }*/
   }//for a

    $response["status"] = "success";
    $response["datos"]  = $supervisores;//para tabla
    $response["quince"]  = $quinceSup;//para grafica
    $response["rol"]  = $rol;//para grafica
    $response["fechas"]  = $arregloFechas;//para grafica
    // $response["quince1"]  = $listaCompletaSup;//para grafica

// $log->LogInfo("Valor de la variable arregloFechas: " . var_export ($arregloFechas, true));     
// $log->LogInfo("Valor de la variable supervisores: " . var_export ($supervisores, true));     
// $log->LogInfo("Valor de la variable quinceSup: " . var_export ($quinceSup, true));     
    $response["mensaje"] = "Error al iniciar sesion";
echo json_encode($response);
//COMO ME QUEDE