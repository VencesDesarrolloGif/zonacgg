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
$usuarioLogeado=$_SESSION ["userLog"]["usuario"];
verificarInicioSesion ($negocio);
$log = new KLogger ( "actualizarAsignaciones.log" , KLogger::DEBUG );
$cobertura     =getValueFromPost("cobertura");
$NumeroEmpFirma= $_POST["NumeroEmpFirma"];//Empleado
$NombreEmp     = $_POST["NombreEmp"];//Empleado
$FirmaEmp      = $_POST["FirmaEmp"];//Empleado
$FirmaGuardia  = $_POST["FirmaGuardia"];//Guardia
$NumeroGuardia = $_POST["NumeroGuardia"];//Guardia
$NombreGuardia = $_POST["NombreGuardia"];//Guardia
$idfuncion     = $_POST["idfuncion"];
$valRsi        = $_POST["valRsi"];
$valRno        = $_POST["valRno"];
$banderaFiniquito= $_POST["banderaFiniquito"];
$estatusImssemp  = $_POST["estatusImss"];//Guardia
$estatusFiniquito= $_POST["estatusfiniquito"];//Guardia
$sucursalUsr= $_POST["sucursalUsr"];//Guardia
$entidadUsr = $_POST["entidadUsr"];//Guardia
$numeroExplo = explode("-", $NumeroEmpFirma);
$empleadoEntidad1    = $numeroExplo[0];
$empleadoConsecutivo1= $numeroExplo[1];
$empleadoCategoria1  = $numeroExplo[2];

$numeroGuardiaExplo = explode("-", $NumeroGuardia);
$empleadoEntidadGuardia1    = $numeroGuardiaExplo[0];
$empleadoConsecutivoGuardia1= $numeroGuardiaExplo[1];
$empleadoCategoriaGuardia1  = $numeroGuardiaExplo[2];
$log->LogInfo("Valor de la variable _POST : " . var_export ($_POST, true));  
    try{
        if($idfuncion==1) {//FIRMA DIRECTA
            $montoDur=0;
            $negocio -> negocio_consultarDatosFiniquito($empleadoEntidadGuardia1,$empleadoConsecutivoGuardia1,$empleadoCategoriaGuardia1,$montoDur,$valRsi);
            $negocio -> InsertdeudaDirectaFiniquito($empleadoEntidadGuardia1,$empleadoConsecutivoGuardia1,$empleadoCategoriaGuardia1,$montoDur);
            $negocio -> InserthistoricoBajasDirectasAlm($empleadoEntidad1,$empleadoConsecutivo1,$empleadoCategoria1,$empleadoEntidadGuardia1,$empleadoConsecutivoGuardia1,$empleadoCategoriaGuardia1,$FirmaEmp);
            $response["empleadoEntidad"] = $empleadoEntidadGuardia1; 
            $response["empleadoConsecutivo"]= $empleadoConsecutivoGuardia1; 
            $response["empleadoCategoria"]  = $empleadoCategoriaGuardia1; 
            $response["status"] = "success";
            $response["message"]= "Firma generada correctamente"; 

        }else{//BOTON CONFIRMAR
             $montoDurTotal=0;
             $uniformes = $negocio -> obtenerUniformeARecibir($usuarioLogeado);    
             $log->LogInfo("Valor de la variable uniformes : " . var_export ($uniformes, true));  
        
             for($i=0; $i < count($uniformes); $i++){
                 $idUniformeSup =$uniformes[$i]["idUniformeSup"];//cuando es de uso propio llega en "0"
                 $idUniforme =$uniformes[$i]["claveUniRecepcionTMP"];  
                 $fechaRecepcionTMP=$uniformes[$i]["fechaRecepcionTMP"];

                 $empleadoEntidad    =$uniformes[$i]["entidadEmpRecepcionTMP"];
                 $empleadoConsecutivo=$uniformes[$i]["consecutivoEmpRecepcionTMP"];
                 $empleadoCategoria  =$uniformes[$i]["categoriaEmpRecepcionTMP"];
                 $montoDur   =$uniformes[$i]["montoDeudaRUT"];
                 $cantidadUni='1'; //lo forzamos a uno ya que se recibe de a solo un articulo
                 $usuarioCaptura=$uniformes[$i]["usuarioRecepcionTMP"];
                 $entidadUsuario=$uniformes[$i]["entidadRecepcionTMP"];
                 $codigoUniforme=$uniformes[$i]["codigoUniforme"];
                 $descripcionUni=$uniformes[$i]["descripcionTipo"]; 
                 $fechaAsignacion=$uniformes[$i]["fechaAsigancionUniRUT"];  
                 $estatusRecibo  =$uniformes[$i]["estatusUniformeRecepcionTMP"];
                 $porcentajeCobrado=$uniformes[$i]["porcentajeCobrado"];
                 $precioDelUniforme=$uniformes[$i]["precioDelUniforme"];
                 $coberturaEmpleado=$uniformes[$i]["coberturaEmpleado"];

                 $orden='00';// no se sabe de que orden viene 
                 $pos = strpos($codigoUniforme, '-');
                 if($pos !== false){
                     $talla=substr($codigoUniforme, $pos+1,strlen($codigoUniforme)-1);
                 }else{
                     $talla='N/A';
                 } 

                 if($banderaFiniquito=="1"){//CUANDO YA ESTA DADO DE BAJA Y CUMPLE LAS CONDICIONES QUE ESTAN EN EL FORM(EN REVISAR CHECKS)
                    $montoDurTotal = $montoDurTotal+$montoDur;//sumaTOTAL para finiquito
                 }else{ //LOS CASOS EN LOS CUALES SIGUEN ACTIVOS Y SE INSERTA LA DEUDA EN LA TABLA DeudaUniformes
                    if(($cobertura <90) && ($estatusImssemp!='7') && ($valRsi == '1')){//para activos,uso propio

                        $negocio -> InsertDeudaDesdeRecepcion($NombreGuardia,$empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria,$idUniforme, $cantidadUni,$usuarioCaptura,$entidadUsuario,$montoDur,$FirmaGuardia,$NumeroEmpFirma,$FirmaEmp,$NombreEmp,$orden,$descripcionUni,$fechaAsignacion,$fechaRecepcionTMP,$porcentajeCobrado,$precioDelUniforme,$coberturaEmpleado,$sucursalUsr);
                         
                    }else if(($valRsi == '0') && ($estatusRecibo!='0')  && ($estatusImssemp!='7')){//activos uso plantilla, que no sea stock
                        $negocio -> InsertDeudaDesdeRecepcion($NombreGuardia,$empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria,$idUniforme, $cantidadUni,$usuarioCaptura,$entidadUsuario,$montoDur,$FirmaGuardia,$NumeroEmpFirma,$FirmaEmp,$NombreEmp,$orden,$descripcionUni,$fechaAsignacion,$fechaRecepcionTMP,$porcentajeCobrado,$precioDelUniforme,$coberturaEmpleado,$sucursalUsr);
                         
                    }else if(($cobertura >= 90) && ($estatusImssemp!='7') && ($valRsi == '1') && ($estatusRecibo!='0')){//para activos, uso propio,diferente de stock
                        $negocio -> InsertDeudaDesdeRecepcion($NombreGuardia,$empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria,$idUniforme, $cantidadUni,$usuarioCaptura,$entidadUsuario,$montoDur,$FirmaGuardia,$NumeroEmpFirma,$FirmaEmp,$NombreEmp,$orden,$descripcionUni,$fechaAsignacion,$fechaRecepcionTMP,$porcentajeCobrado,$precioDelUniforme,$coberturaEmpleado,$sucursalUsr);
                    }
                    $response[$i]["empleadoEntidad"]    ="$empleadoEntidad"; 
                    $response[$i]["empleadoConsecutivo"]="$empleadoConsecutivo"; 
                    $response[$i]["empleadoCategoria"]  ="$empleadoCategoria"; 
                 }//termina el else

                 if($valRsi==1){//uso propio no importa si esta activo o es baja
                    $negocio -> recibirUniformeEmpleado($empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria,$idUniforme,$estatusRecibo,$fechaAsignacion,$usuarioCaptura,$entidadUsuario,$codigoUniforme,$talla,$descripcionUni,$montoDur,$NombreEmp,$FirmaEmp,$FirmaGuardia,$orden,$NombreGuardia,$NumeroEmpFirma,$porcentajeCobrado,$precioDelUniforme,$coberturaEmpleado,$sucursalUsr); 
                 }else{//plantilla no importa si esta activo o es baja
                       $infoUniformeSup = $negocio -> obtenerDatosUniformeSupervisor($idUniformeSup); //para saber la cantidad y poner las condiciones en recibir uniforme 
                       $cantidadUniformeSup=$infoUniformeSup[0]["cantidadUniformeSup"];
                       $negocio -> recibirUniformeEmpleadoPlantilla($empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria,$idUniforme,$estatusRecibo,$fechaAsignacion,$usuarioCaptura,$entidadUsuario,$codigoUniforme,$talla,$descripcionUni,$montoDur,$NombreEmp,$FirmaEmp,$FirmaGuardia,$orden,$NombreGuardia,$NumeroEmpFirma,$idUniformeSup,$cantidadUniformeSup,$estatusImssemp,$porcentajeCobrado,$precioDelUniforme,$coberturaEmpleado,$sucursalUsr); 
                 }
             }//Termina el for revisar:
        if($banderaFiniquito=="1"){ //CUANDO YA ESTA DADO DE BAJA Y CUMPLE LAS CONDICIONES QUE ESTAN EN EL FORM(EN REVISAR CHECKS)
           $TotalACobro = $negocio -> negocio_consultarDatosFiniquito($empleadoEntidadGuardia1,$empleadoConsecutivoGuardia1,$empleadoCategoriaGuardia1,$montoDurTotal,$valRsi);
          $log->LogInfo("Valor de la variable TotalACobro : " . var_export ($TotalACobro, true));  
           $negocio -> InsertdeudaDirectaFiniquito($empleadoEntidadGuardia1,$empleadoConsecutivoGuardia1,$empleadoCategoriaGuardia1,$TotalACobro);
           $negocio -> InserthistoricoBajasDirectasAlm($empleadoEntidad1,$empleadoConsecutivo1,$empleadoCategoria1,$empleadoEntidadGuardia1,$empleadoConsecutivoGuardia1,$empleadoCategoriaGuardia1,$FirmaEmp);
           $response[0]["empleadoEntidad"] = $empleadoEntidadGuardia1; 
           $response[0]["empleadoConsecutivo"] = $empleadoConsecutivoGuardia1; 
           $response[0]["empleadoCategoria"] = $empleadoCategoriaGuardia1; 
         }
        $response ["status"] = "success";
        $response ["message"]= "Uniforme recibido"; 
    }
}catch(Exception $e){
    $response ["status"] = "error";
    $response ["message"] =  $e -> getMessage ();
}

echo json_encode ($response);
?>
