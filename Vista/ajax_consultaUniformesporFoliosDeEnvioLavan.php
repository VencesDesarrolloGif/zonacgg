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
$log = new KLogger ( "ajax_consultaUniformesporFoliosDeEnvioLavan.log" , KLogger::DEBUG );
$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true)); 
$log->LogInfo("Valor de la variable _SESSION: " . var_export ($_SESSION, true)); 
$accion=$_POST["accion"];
$folio =$_POST["folio"];
$array =$_POST["arrayDatos"];
$costoNotaFactura  =$_POST["costoNotaFactura"];
$folioRecibidoLavan=$_POST["folioRecibidoLavan"];
$usuarioEntidad    =$_SESSION ["userLog"]["entidadFederativaUsuario"];// es un array
$sucursalesActuales = array();

    for($i = 0; $i < count($_SESSION['userLog']['sucursalesUsuario']); $i++){
        $sucursalesActuales[] = $_SESSION['userLog']['sucursalesUsuario'][$i];  // Guardamos solo los idSucursalUsr
        // $log->LogInfo("Valor de sucursalesActuales" . var_export($sucursalesActuales, true));
    }
    $sucursalesArreglo = implode(',', $sucursalesActuales);

    try{   
        if($accion==1){ //simple consulta inicial  
            $FoliUniformes=$negocio -> negocio_consultaFoliosdeUniformesEnviadosLavan($usuarioEntidad,$sucursalesArreglo);
            for($i=0;$i<count($FoliUniformes);$i++){
                $FoliUniformes[$i]["folios"] = "<a href='javascript:mostrarListaParaRecibirUniformes(\"".$FoliUniformes[$i]["folioEnvioLavanderia"]."\");'>". $FoliUniformes[$i]["folioEnvioLavanderia"]."</a>";
                $FoliUniformes[$i]["accion_ver_detallessss"] = "<a href='javascript:mostrarModalDetalleFoliosUniformesLavanderia(\"" . $FoliUniformes[$i]["folioEnvioLavanderia"] . "\");'>Ver Detalle</a>";
            }
                $response ["status"] = "success"; 
                $response["data"]=$FoliUniformes;  
        }else if($accion==2){
                $detalleuniformes=$negocio -> negocio_consultaDetallesEnvioLavanderia($folio);
                $response ["status"] = "success"; 
                $response["data"]=$detalleuniformes;
        }else if($accion==3){
                for($i=0;$i<count($array);$i++){
                    $miarray = explode(";", $array[$i]);
                    $valorRadio=$miarray[0];
                    $idsUniformes=$miarray[1];
                    $idunicoBajaUniforme=$miarray[2];
                    if($valorRadio==1){
                        $usuarioEntidadStock=$_POST["usuarioEntidadStock"];
                         $negocio ->negocio_RecepcionAStockFromLavanderia($idsUniformes,$usuarioEntidadStock,$idunicoBajaUniforme);

                    }else if($valorRadio==2){
                         $negocio ->negocio_DestruccionFromLavanderia($idunicoBajaUniforme);
                        }else if($valorRadio==3){
                                $negocio ->negocio_ReturnConsultaRecibidos($idunicoBajaUniforme);
                            }
            $negocio ->negocio_UpdateFolioRecibidoFromLavanderia($folio,$costoNotaFactura,$folioRecibidoLavan);                  
            }
        }
    $log->LogInfo("Valor de la variable response: " . var_export ($response, true)); 

    }catch (Exception $e){
        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();
    }
echo json_encode ($response);
?> 