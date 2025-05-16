<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
// $log = new KLogger("consultaDetalleTrabajadores.log", KLogger::DEBUG);
$negocio           = new Negocio ();
$response          = array();
$response["status"]= "error";
$datos             = array();

$cuatrimestre=$_POST['cuatrimestre'];
$anio=$_POST['anio'];

if($cuatrimestre==1) {
   $fechaInicio= $anio."-01-01";
   $fechaFin= $anio."-04-30";
  }
  else if($cuatrimestre==2) {
   $fechaInicio= $anio."-05-01";
   $fechaFin= $anio."-08-31";
  }
  else if($cuatrimestre==3) {
   $fechaInicio= $anio."-09-01";
   $fechaFin= $anio."-12-31";
  }

try {
    $datos = $negocio -> DetalleTrabajadores($fechaInicio,$fechaFin);
    $rfcSujetoObligado    = $negocio -> obtenerRFCSujetoObligado();//se utiliza en sujeto obligado tmbn

    for($i=0; $i < count($datos); $i++) { 
        $estatusEmp  =$datos[$i]["estatusID"];//descripcion
        $noEmpleado  =$datos[$i]["noEmpleado"];
        $fechaIngreso=$datos[$i]["fechaIngreso"];
        $fechaBaja   =$datos[$i]["fechaBaja"];
        $fechaEdicion=$datos[$i]["fechaEdicion"];
        $fechaBajaOp =$datos[$i]["fechaBajaOperaciones"];
        $origen      =$datos[$i]["origen"];
        $puntoServ   =$datos[$i]["puntoServicio"];
        $idPuntoServ   =$datos[$i]["idPuntoServ"];
        $entidadFederativaId   =$datos[$i]["entidadFederativaId"];
        $empleadoConsecutivoId =$datos[$i]["empleadoConsecutivoId"];
        $empleadoCategoriaId   =$datos[$i]["empleadoCategoriaId"];

        if($estatusEmp==1  && $origen=="empleados") {
            
           $fechaBaja=$fechaFin;//sera fecha fin para saber la cobertura hasta donde termina el cuatrimestre que se eligio, ya que no deben tener fecha de baja
        }else if($estatusEmp==1 && $origen=="empleadosEdit") {
       
            if ($fechaEdicion > $fechaFin) {
                $fechaBaja=$fechaFin;
            }else{
                  $fechaBaja=$fechaEdicion;
            }////////TEMINAN CASOS PARA ACTIVOS

        }else if($estatusEmp==0 && ($fechaBaja!="" && $fechaBaja!="null" && $fechaBaja!="NULL" && $fechaBaja!="0000-00-00")){//fecha baja no importa la tabla

            if($fechaBaja > $fechaFin){
               $fechaBaja=$fechaFin;
            }//no se pone un else ya que si no entra en la condicion fecha baja se queda igual

        }else if($estatusEmp==0 && ($fechaBaja=="" || $fechaBaja=="null" || $fechaBaja=="NULL" || $fechaBaja=="0000-00-00")){//fecha baja no importa la tabla
            
            if ($origen=="empleados") {
                if($fechaBajaOp!="" || $fechaBajaOp!="null" || $fechaBajaOp!="NULL" || $fechaBajaOp!="0000-00-00"){
                   if($fechaBajaOp > $fechaFin){
                         $fechaBaja=$fechaFin;
                     }else{
                          $fechaBaja=$fechaBajaOp;
                          }
                }else{//si la fecha de baja operaciones es nulo o cualquier otro caso
                      $fechaBaja=$fechaFin;
                     }
            }else{
                  $fechaBaja=$fechaFin;
                  }////////TERMINAN INACTIVOS
        }else if($estatusEmp==2 && ($fechaBaja=="" || $fechaBaja=="null" || $fechaBaja=="NULL" || $fechaBaja=="0000-00-00")){//fecha bajaoperaciones CON fecha edicion
            
                 $fechaBaja=$fechaFin;
        }
        $puntoServ= $negocio -> puntoservYCoberturaMaximaXemp($entidadFederativaId,$empleadoConsecutivoId,$empleadoCategoriaId,$fechaIngreso,$fechaBaja);//hace la suma de turnosCubiertos e incidencias, trae el ps donde hizo mas
        $inc= $negocio -> obtenerIncapacidadesDetalleTrab($entidadFederativaId,$empleadoConsecutivoId,$empleadoCategoriaId,$fechaIngreso,$fechaBaja);
        $datos[$i]["incapacidadesEmp"]= $inc[0]["incapacidades"];
        // $log->LogInfo("Valor de la variable puntoServ: " . var_export ($puntoServ, true));
        // $log->LogInfo("Valor de la variable noEmpleado: " . var_export ($noEmpleado, true));
        // $log->LogInfo("Valor de la variable fechaIngreso: " . var_export ($fechaIngreso, true));
        // $log->LogInfo("Valor de la variable fechaBaja: " . var_export ($fechaBaja, true));

        if(count($puntoServ) == '0' || count($puntoServ) == "NULL" || count($puntoServ) == "null" || count($puntoServ) == "") {//si no trae ningun PS ya que no hizo cobertura entonces traera el de la tabla empleados
           
           $InfopuntoServ = $negocio -> infoPSyContratoXEmp($idPuntoServ);//se busca numero de contrato,etc X el ps de la tabla "empleados" 

           if (count($InfopuntoServ) == 0 || count($InfopuntoServ) == "NULL" || count($InfopuntoServ) == "null" || count($InfopuntoServ) == "") {//si no tiene en empleados mandar mensaje
               $datos[$i]["puntoServicioEmp"] = "<label> Sin Punto de Servicio Asignado </label>";
               $datos[$i]["cobertura"] = "<label> Sin Punto de Servicio Asignado </label>";
               $datos[$i]["numeroContrato"] = "<label> Sin Punto de Servicio Asignado </label>";
               $datos[$i]["CallePrincipaPuntoS"]= "<label> Sin Punto de Servicio Asignado </label>";
               $datos[$i]["NumExteriorPuntoS"]= "<label> Sin Punto de Servicio Asignado </label>";
               $datos[$i]["NumInterirPuntoS"] = "<label> Sin Punto de Servicio Asignado </label>";
               $datos[$i]["ColPuntoS"]= "<label> Sin Punto de Servicio Asignado </label>";
               $datos[$i]["CPpuntoS"] = "<label> Sin Punto de Servicio Asignado </label>";
               $datos[$i]["MunPuntoS"]= "<label> Sin Punto de Servicio Asignado </label>";
               $datos[$i]["EntPuntoS"]= "<label> Sin Punto de Servicio Asignado </label>";
           }else{
                $datos[$i]["puntoServicioEmp"]= $idPuntoServ;//lo traigo desde "empleados"
                $numeroContrato =$InfopuntoServ[0]["numeroContratoCompleto"];
        
                if($numeroContrato=="" || $numeroContrato=="null" || $numeroContrato=="NULL" || $numeroContrato=="0000-00-00") {
                    $datos[$i]["numeroContrato"] = "<label> Sin Contrato Asignado </label>";
                }else{
                  $datos[$i]["numeroContrato"]= $InfopuntoServ[0]["numeroContratoCompleto"];
                 }

                 if ($InfopuntoServ[0]["CallePrincipaPuntoS"]=='' || $InfopuntoServ[0]["CallePrincipaPuntoS"]==' ' || $InfopuntoServ[0]["CallePrincipaPuntoS"]==NULL || $InfopuntoServ[0]["CallePrincipaPuntoS"]=='NULL' || $InfopuntoServ[0]["CallePrincipaPuntoS"]=='null') {
                    $datos[$i]["CallePrincipaPuntoS"]='0';
                }else{
                    $datos[$i]["CallePrincipaPuntoS"]= $InfopuntoServ[0]["CallePrincipaPuntoS"];
                }

                if ($InfopuntoServ[0]["NumeroExteriorPuntoS"]==NULL || $InfopuntoServ[0]["NumeroExteriorPuntoS"]=='' || $InfopuntoServ[0]["NumeroExteriorPuntoS"]=='n/a' || $InfopuntoServ[0]["NumeroExteriorPuntoS"]=='N/A' || $InfopuntoServ[0]["NumeroExteriorPuntoS"]=='N/a' || $InfopuntoServ[0]["NumeroExteriorPuntoS"]=='n/A' || $InfopuntoServ[0]["NumeroExteriorPuntoS"]=='S/N' || $InfopuntoServ[0]["NumeroExteriorPuntoS"]=='s/n' || $InfopuntoServ[0]["NumeroExteriorPuntoS"]=='S/n' || $InfopuntoServ[0]["NumeroExteriorPuntoS"]=='s/N' || $InfopuntoServ[0]["NumeroExteriorPuntoS"]=='S/N' || $InfopuntoServ[0]["NumeroExteriorPuntoS"]=='NA/' || $InfopuntoServ[0]["NumeroExteriorPuntoS"]=='na/' || $InfopuntoServ[0]["NumeroExteriorPuntoS"]=='SN/' || $InfopuntoServ[0]["NumeroExteriorPuntoS"]=='sn/' || $InfopuntoServ[0]["NumeroExteriorPuntoS"]=='null' || $InfopuntoServ[0]["NumeroExteriorPuntoS"]=='Null' || $InfopuntoServ[0]["NumeroExteriorPuntoS"]=='NULL' || $InfopuntoServ[0]["NumeroExteriorPuntoS"]==' ')
                {
                    $datos[$i]["NumExteriorPuntoS"]='0';
                }else{
                    $datos[$i]["NumExteriorPuntoS"]= $InfopuntoServ[0]["NumeroExteriorPuntoS"];
                }

                if ($InfopuntoServ[0]["NumeroInterirPuntoS"]==NULL || $InfopuntoServ[0]["NumeroInterirPuntoS"]=='' || $InfopuntoServ[0]["NumeroInterirPuntoS"]=='n/a' || $InfopuntoServ[0]["NumeroInterirPuntoS"]=='N/A' || $InfopuntoServ[0]["NumeroInterirPuntoS"]=='N/a' || $InfopuntoServ[0]["NumeroInterirPuntoS"]=='n/A' || $InfopuntoServ[0]["NumeroInterirPuntoS"]=='S/N' || $InfopuntoServ[0]["NumeroInterirPuntoS"]=='s/n' || $InfopuntoServ[0]["NumeroInterirPuntoS"]=='S/n' || $InfopuntoServ[0]["NumeroInterirPuntoS"]=='s/N' || $InfopuntoServ[0]["NumeroInterirPuntoS"]=='S/N' || $InfopuntoServ[0]["NumeroInterirPuntoS"]=='NA/' || $InfopuntoServ[0]["NumeroInterirPuntoS"]=='na/' || $InfopuntoServ[0]["NumeroInterirPuntoS"]=='SN/' || $InfopuntoServ[0]["NumeroInterirPuntoS"]=='sn/' || $InfopuntoServ[0]["NumeroInterirPuntoS"]=='null' || $InfopuntoServ[0]["NumeroInterirPuntoS"]=='Null' || $InfopuntoServ[0]["NumeroInterirPuntoS"]=='NULL' || $InfopuntoServ[0]["NumeroInterirPuntoS"]==' '){

                    $datos[$i]["NumInterirPuntoS"]='0';
                }else{
                     $datos[$i]["NumInterirPuntoS"]   = $InfopuntoServ[0]["NumeroInterirPuntoS"];
                }


                if ($InfopuntoServ[0]["nombreAsentamiento"]==NULL || $InfopuntoServ[0]["nombreAsentamiento"]=='' || $InfopuntoServ[0]["nombreAsentamiento"]=='n/a' || $InfopuntoServ[0]["nombreAsentamiento"]=='N/A' || $InfopuntoServ[0]["nombreAsentamiento"]=='N/a' || $InfopuntoServ[0]["nombreAsentamiento"]=='n/A' || $InfopuntoServ[0]["nombreAsentamiento"]=='S/N' || $InfopuntoServ[0]["nombreAsentamiento"]=='s/n' || $InfopuntoServ[0]["nombreAsentamiento"]=='S/n' || $InfopuntoServ[0]["nombreAsentamiento"]=='s/N' || $InfopuntoServ[0]["nombreAsentamiento"]=='S/N' || $InfopuntoServ[0]["nombreAsentamiento"]=='NA/' || $InfopuntoServ[0]["nombreAsentamiento"]=='na/' || $InfopuntoServ[0]["nombreAsentamiento"]=='SN/' || $InfopuntoServ[0]["nombreAsentamiento"]=='sn/' || $InfopuntoServ[0]["nombreAsentamiento"]=='null' || $InfopuntoServ[0]["nombreAsentamiento"]=='Null' || $InfopuntoServ[0]["nombreAsentamiento"]=='NULL' || $InfopuntoServ[0]["nombreAsentamiento"]==' '){

                    $datos[$i]["ColPuntoS"]='0';
                }else{
                     $datos[$i]["ColPuntoS"]= $InfopuntoServ[0]["nombreAsentamiento"];
                }

                if ($InfopuntoServ[0]["CodigoPostalPuntoS"]==NULL || $InfopuntoServ[0]["CodigoPostalPuntoS"]=='' || $InfopuntoServ[0]["CodigoPostalPuntoS"]=='n/a' || $InfopuntoServ[0]["CodigoPostalPuntoS"]=='N/A' || $InfopuntoServ[0]["CodigoPostalPuntoS"]=='N/a' || $InfopuntoServ[0]["CodigoPostalPuntoS"]=='n/A' || $InfopuntoServ[0]["CodigoPostalPuntoS"]=='S/N' || $InfopuntoServ[0]["CodigoPostalPuntoS"]=='s/n' || $InfopuntoServ[0]["CodigoPostalPuntoS"]=='S/n' || $InfopuntoServ[0]["CodigoPostalPuntoS"]=='s/N' || $InfopuntoServ[0]["CodigoPostalPuntoS"]=='S/N' || $InfopuntoServ[0]["CodigoPostalPuntoS"]=='NA/' || $InfopuntoServ[0]["CodigoPostalPuntoS"]=='na/' || $InfopuntoServ[0]["CodigoPostalPuntoS"]=='SN/' || $InfopuntoServ[0]["CodigoPostalPuntoS"]=='sn/' || $InfopuntoServ[0]["CodigoPostalPuntoS"]=='null' || $InfopuntoServ[0]["CodigoPostalPuntoS"]=='Null' || $InfopuntoServ[0]["CodigoPostalPuntoS"]=='NULL' || $InfopuntoServ[0]["CodigoPostalPuntoS"]==' '){

                    $datos[$i]["CPpuntoS"]='0';
                }else{
                     $datos[$i]["CPpuntoS"] = $InfopuntoServ[0]["CodigoPostalPuntoS"];
                }

                if ($InfopuntoServ[0]["nombreMunicipio"]==NULL || $InfopuntoServ[0]["nombreMunicipio"]=='n/a' || $InfopuntoServ[0]["nombreMunicipio"]=='n/a' || $InfopuntoServ[0]["nombreMunicipio"]=='N/A' || $InfopuntoServ[0]["nombreMunicipio"]=='N/a' || $InfopuntoServ[0]["nombreMunicipio"]=='n/A' || $InfopuntoServ[0]["nombreMunicipio"]=='S/N' || $InfopuntoServ[0]["nombreMunicipio"]=='s/n' || $InfopuntoServ[0]["nombreMunicipio"]=='S/n' || $InfopuntoServ[0]["nombreMunicipio"]=='s/N' || $InfopuntoServ[0]["nombreMunicipio"]=='S/N' || $InfopuntoServ[0]["nombreMunicipio"]=='NA/' || $InfopuntoServ[0]["nombreMunicipio"]=='na/' || $InfopuntoServ[0]["nombreMunicipio"]=='SN/' || $InfopuntoServ[0]["nombreMunicipio"]=='sn/' || $InfopuntoServ[0]["nombreMunicipio"]=='null' || $InfopuntoServ[0]["nombreMunicipio"]=='Null' || $InfopuntoServ[0]["nombreMunicipio"]=='NULL' || $InfopuntoServ[0]["nombreMunicipio"]==' '){

                    $datos[$i]["MunPuntoS"]='0';
                }else{
                     $datos[$i]["MunPuntoS"]= $InfopuntoServ[0]["nombreMunicipio"];
                }
                 if ($InfopuntoServ[0]["nombreEntidadFederativa"]=='' || $InfopuntoServ[0]["nombreEntidadFederativa"]==' ' || $InfopuntoServ[0]["nombreEntidadFederativa"]==NULL || $InfopuntoServ[0]["nombreEntidadFederativa"]=='NULL' || $InfopuntoServ[0]["nombreEntidadFederativa"]=='null') {
                    $datos[$i]["EntPuntoS"]='0';
                }else{
                    $datos[$i]["EntPuntoS"]= $InfopuntoServ[0]["nombreEntidadFederativa"];
                }
                $datos[$i]["rfc"] = $rfcSujetoObligado[0]["rfcCliente"];
            }//termina else(cuando si tine ps en empleados) 
        }//TERMIN if count
        else{
             $datos[$i]["puntoServicioEmp"]= $puntoServ[0]["puntoServicio"];
             $numeroContrato =$puntoServ[0]["numeroContratoCompleto"]; //traer ultimo
             
             if ($numeroContrato=="" || $numeroContrato=="null" || $numeroContrato=="NULL" || $numeroContrato=="0000-00-00") {
                 $datos[$i]["numeroContrato"] = "<label> Sin Contrato Asignado </label>";
             }else{
                 $datos[$i]["numeroContrato"] = $puntoServ[0]["numeroContratoCompleto"];
             }
			 
            if ($puntoServ[0]["CallePrincipaPuntoS"]=='' || $puntoServ[0]["CallePrincipaPuntoS"]==' ' || $puntoServ[0]["CallePrincipaPuntoS"]==NULL || $puntoServ[0]["CallePrincipaPuntoS"      ]=='NULL' || $puntoServ[0]["CallePrincipaPuntoS"]=='null') {
                               $datos[$i]["CallePrincipaPuntoS"]='0';
            }else{
                  $datos[$i]["CallePrincipaPuntoS"]= $puntoServ[0]["CallePrincipaPuntoS"];
            }

             if ($puntoServ[0]["NumeroExteriorPuntoS"]==NULL || $puntoServ[0]["NumeroExteriorPuntoS"]=='n/a' || $puntoServ[0]["NumeroExteriorPuntoS"]=='N/A' || $puntoServ[0]["NumeroExteriorPuntoS"]=='N/a' || $puntoServ[0]["NumeroExteriorPuntoS"]=='n/A' || $puntoServ[0]["NumeroExteriorPuntoS"]=='S/N' || $puntoServ[0]["NumeroExteriorPuntoS"]=='s/n' || $puntoServ[0]["NumeroExteriorPuntoS"]=='S/n' || $puntoServ[0]["NumeroExteriorPuntoS"]=='s/N' || $puntoServ[0]["NumeroExteriorPuntoS"]=='S/N' || $puntoServ[0]["NumeroExteriorPuntoS"]=='NA/' || $puntoServ[0]["NumeroExteriorPuntoS"]=='na/' || $puntoServ[0]["NumeroExteriorPuntoS"]=='SN/' || $puntoServ[0]["NumeroExteriorPuntoS"]=='sn/' || $puntoServ[0]["NumeroExteriorPuntoS"]=='null' || $puntoServ[0]["NumeroExteriorPuntoS"]=='Null' || $puntoServ[0]["NumeroExteriorPuntoS"]=='NULL' || $puntoServ[0]["NumeroExteriorPuntoS"]==' '){

                    $datos[$i]["NumExteriorPuntoS"]='0';
                }else{
                     $datos[$i]["NumExteriorPuntoS"]  = $puntoServ[0]["NumeroExteriorPuntoS"];
                }

                if ($puntoServ[0]["NumeroInterirPuntoS"]==NULL || $puntoServ[0]["NumeroInterirPuntoS"]=='n/a' || $puntoServ[0]["NumeroInterirPuntoS"]=='N/A' || $puntoServ[0]["NumeroInterirPuntoS"]=='N/a' || $puntoServ[0]["NumeroInterirPuntoS"]=='n/A' || $puntoServ[0]["NumeroInterirPuntoS"]=='S/N' || $puntoServ[0]["NumeroInterirPuntoS"]=='s/n' || $puntoServ[0]["NumeroInterirPuntoS"]=='S/n' || $puntoServ[0]["NumeroInterirPuntoS"]=='s/N' || $puntoServ[0]["NumeroInterirPuntoS"]=='S/N' || $puntoServ[0]["NumeroInterirPuntoS"]=='NA/' || $puntoServ[0]["NumeroInterirPuntoS"]=='na/' || $puntoServ[0]["NumeroInterirPuntoS"]=='SN/' || $puntoServ[0]["NumeroInterirPuntoS"]=='sn/' || $puntoServ[0]["NumeroInterirPuntoS"]=='null' || $puntoServ[0]["NumeroInterirPuntoS"]=='Null' || $puntoServ[0]["NumeroInterirPuntoS"]=='NULL' || $puntoServ[0]["NumeroInterirPuntoS"]==' '){

                    $datos[$i]["NumInterirPuntoS"]='0';
                }else{
                     $datos[$i]["NumInterirPuntoS"]   = $puntoServ[0]["NumeroInterirPuntoS"];
                }


             if ($puntoServ[0]["nombreAsentamiento"]==NULL || $puntoServ[0]["nombreAsentamiento"]=='n/a' || $puntoServ[0]["nombreAsentamiento"]=='N/A' || $puntoServ[0]["nombreAsentamiento"]=='N/a' || $puntoServ[0]["nombreAsentamiento"]=='n/A' || $puntoServ[0]["nombreAsentamiento"]=='S/N' || $puntoServ[0]["nombreAsentamiento"]=='s/n' || $puntoServ[0]["nombreAsentamiento"]=='S/n' || $puntoServ[0]["nombreAsentamiento"]=='s/N' || $puntoServ[0]["nombreAsentamiento"]=='S/N' || $puntoServ[0]["nombreAsentamiento"]=='NA/' || $puntoServ[0]["nombreAsentamiento"]=='na/' || $puntoServ[0]["nombreAsentamiento"]=='SN/' || $puntoServ[0]["nombreAsentamiento"]=='sn/' || $puntoServ[0]["nombreAsentamiento"]=='null' || $puntoServ[0]["nombreAsentamiento"]=='Null' || $puntoServ[0]["nombreAsentamiento"]=='NULL' || $puntoServ[0]["nombreAsentamiento"]==' '){

                    $datos[$i]["ColPuntoS"]='0';
                }else{
                     $datos[$i]["ColPuntoS"]= $puntoServ[0]["nombreAsentamiento"];
                }

             if ($puntoServ[0]["CodigoPostalPuntoS"]==NULL || $puntoServ[0]["CodigoPostalPuntoS"]=='n/a' || $puntoServ[0]["CodigoPostalPuntoS"]=='N/A' || $puntoServ[0]["CodigoPostalPuntoS"]=='N/a' || $puntoServ[0]["CodigoPostalPuntoS"]=='n/A' || $puntoServ[0]["CodigoPostalPuntoS"]=='S/N' || $puntoServ[0]["CodigoPostalPuntoS"]=='s/n' || $puntoServ[0]["CodigoPostalPuntoS"]=='S/n' || $puntoServ[0]["CodigoPostalPuntoS"]=='s/N' || $puntoServ[0]["CodigoPostalPuntoS"]=='S/N' || $puntoServ[0]["CodigoPostalPuntoS"]=='NA/' || $puntoServ[0]["CodigoPostalPuntoS"]=='na/' || $puntoServ[0]["CodigoPostalPuntoS"]=='SN/' || $puntoServ[0]["CodigoPostalPuntoS"]=='sn/' || $puntoServ[0]["CodigoPostalPuntoS"]=='null' || $puntoServ[0]["CodigoPostalPuntoS"]=='Null' || $puntoServ[0]["CodigoPostalPuntoS"]=='NULL' || $puntoServ[0]["CodigoPostalPuntoS"]==' '){

                    $datos[$i]["CPpuntoS"]='0';
                }else{
                     $datos[$i]["CPpuntoS"] = $puntoServ[0]["CodigoPostalPuntoS"];
                }

             if ($puntoServ[0]["nombreMunicipio"]==NULL || $puntoServ[0]["nombreMunicipio"]=='n/a' || $puntoServ[0]["nombreMunicipio"]=='N/A' || $puntoServ[0]["nombreMunicipio"]=='N/a' || $puntoServ[0]["nombreMunicipio"]=='n/A' || $puntoServ[0]["nombreMunicipio"]=='S/N' || $puntoServ[0]["nombreMunicipio"]=='s/n' || $puntoServ[0]["nombreMunicipio"]=='S/n' || $puntoServ[0]["nombreMunicipio"]=='s/N' || $puntoServ[0]["nombreMunicipio"]=='S/N' || $puntoServ[0]["nombreMunicipio"]=='NA/' || $puntoServ[0]["nombreMunicipio"]=='na/' || $puntoServ[0]["nombreMunicipio"]=='SN/' || $puntoServ[0]["nombreMunicipio"]=='sn/' || $puntoServ[0]["nombreMunicipio"]=='null' || $puntoServ[0]["nombreMunicipio"]=='Null' || $puntoServ[0]["nombreMunicipio"]=='NULL' || $puntoServ[0]["nombreMunicipio"]==' '){

                    $datos[$i]["MunPuntoS"]='0';
                }else{
                     $datos[$i]["MunPuntoS"]= $puntoServ[0]["nombreMunicipio"];
                }
			 if ($puntoServ[0]["nombreEntidadFederativa"]=='' || $puntoServ[0]["nombreEntidadFederativa"]==' ' || $puntoServ[0]["nombreEntidadFederativa"]==NULL || $puntoServ[0]["nombreEntidadFederativa"]=='NULL' || $puntoServ[0]["nombreEntidadFederativa"]=='null') {
                    $datos[$i]["EntPuntoS"]='0';
                }else{
                    $datos[$i]["EntPuntoS"]= $puntoServ[0]["nombreEntidadFederativa"];
                }
             $datos[$i]["rfc"] = $rfcSujetoObligado[0]["rfcCliente"];

        }
    }//termina for
    // $log->LogInfo("Valor de la variable datos: " . var_export ($datos, true));
    $response["status"] = "success";
    $response["datos"]  = $datos;
}catch (Exception $e) {
    $response["mensaje"]= "Error al iniciar sesion";}
echo json_encode($response);
