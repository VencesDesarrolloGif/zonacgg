<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();
require "../conexion/conexion.php";
require_once "../../libs/logger/KLogger.php";
$log= new KLogger("ajax_guardarnuevoregpatronal.log", KLogger::DEBUG);
$log->LogInfo("contador de post:  " . var_export($_POST, true));
$log->LogInfo("contador de sesion:  " . var_export($_SESSION, true));

$idempresa           = $_POST['selenuevompresa'];
$entidadregistro     = $_POST['hdnnuevoentidadsuc'];
$regpatronal         = $_POST['inpnuevoregpatronal'];
$descripcionsucursal = $_POST['inpnuevosucursal'];
$actividadeconomica  = $_POST['inpnuevoacteconomicasuc'];
$callenumero         = $_POST['inpnuevocallenumeroycolsuc'];
$codigopostal        = $_POST['cp'];
$poblacionmunicipio  = $_POST['selnuevopoblacionmunicipiosuc'];
$telefono            = $_POST['inpnuevotelefonosuc'];
$delegacionimss      = $_POST['selnuevodelimsssuc'];
$subdelegacionimss   = $_POST['selnuevosubdelegacionimsssuc'];
$areageografica      = $_POST['selnuevoareageosuc'];
$mes                 = $_POST['selnuevomesiniciomodafisuc'];
$anio                = $_POST['selnuevoanioiniciomodafisuc'];
$idfraccion          = $_POST['selnuevofraccionriegodetrab'];
$nombreresponsable   = $_POST['inpnuevonombrepatronoresponsable'];
$mesprimar           = $_POST['selnuevomesfraccionriesgodetrab'];
$anioprimar          = $_POST['selnuevoaniofraccionriesgodetrab'];
$cantprimar          = $_POST['inpnuevoprimainiciomodafisuc'];
$selnuevoclaseriegodetrab=$_POST['selnuevoclaseriegodetrab'];

$arregloEntidaes  =$_POST['tblEntSeleccionadasID'];
$arregloMunicipios=$_POST['tblMunicipiosSeleccionadosID'];

$usuario = $_SESSION["userLog"];

$response            = array();
$response["status"]  = "error";
$datos               = array();
$municipiosXent      = array();
// $idSucursalNueva     = array();

// $municipiosXentDeRegPatronal = array();

// $puntosXMunicipio= array();
// $puntosXMunicipio2= array();
// $empleadosXPS    = array();
// $empleadosXPS2   = array();

try {
    $sqlexistregpatron = "SELECT  *
                          FROM catalogoregistrospatronales
                          WHERE idcatalogoRegistrosPatronales='$regpatronal'";

    $resexistregp = mysqli_query($conexion, $sqlexistregpatron);
    $numrowsres   = mysqli_num_rows($resexistregp);
    
    $log->LogInfo("contador del query:  " . var_export($numrowsres, true));

    if($numrowsres > 0) {
       $response["status"] = "existereg";
    }else{

          $sql0 = "SELECT max(IdSuc)+1 as idSiguiente
                   FROM sucursal";
          
          $log->LogInfo("contador del query sql0:  " . var_export($sql0, true));
          $res0 = mysqli_query($conexion, $sql0);
          
          while (($reg0 = mysqli_fetch_array($res0, MYSQLI_ASSOC))) {
                      $idSucursalNueva[] = $reg0;
              }

          $idsucursal = $idSucursalNueva[0]["idSiguiente"];

          $sql = "INSERT INTO catalogoregistrospatronales(idcatalogoRegistrosPatronales, entidadRegistro)
                  VALUES('$regpatronal','$entidadregistro')";
          
          $log->LogInfo("contador del query sql:  " . var_export($sql, true));
          $res = mysqli_query($conexion, $sql);
        
          $sql1 = "INSERT INTO sucursal(IdRegistroPatronal, ActividadEconomica, CalleNumero, CodigoPostal, PoblacionMunicipio, Telefono, AreaGeografica, DelegacionImss, SubdelegacionImss, Mes, Anio, descripcionSucursal, nombreResponsable, idFraccion,idEmpresaSuc)VALUES('$regpatronal','$actividadeconomica','$callenumero','$codigopostal','$poblacionmunicipio','$telefono','$areageografica','$delegacionimss','$subdelegacionimss','$mes','$anio','$descripcionsucursal','$nombreresponsable','$idfraccion','$idempresa')";

          $log->LogInfo("contador del query sql1:  " . var_export($sql1, true));
          $res1 = mysqli_query($conexion, $sql1);

          $sql3 = "INSERT INTO primariesgotrabajo(idRegistro, anioPrimaR, mesPrimaR, cantPrimaRiesgo)
                   VALUES('$regpatronal','$anioprimar','$mesprimar','$cantprimar')";
    
          $log->LogInfo("contador del query sql3:  " . var_export($sql3, true));
          $res3 = mysqli_query($conexion, $sql3);


          // ////////////////////////////////////////////

          // SI SOLO SOLO SE LE ASIGNA A LA ENTIDAD DEL CODIGO POSTAL ELEGIDO

     /*       $sql7 = "SELECT idMunicipio,nombreMunicipio 
                                FROM catalogomunicipios cm
                                LEFT JOIN entidadesfederativas ef on ef.idEntidadFederativa=cm.idEstado
                                WHERE idEstado='$entidadregistro'";
                   
                       $log->LogInfo("contador del query sql7:  " . var_export($sql7, true));
                       $res7 = mysqli_query($conexion, $sql7);
      
                       while (($reg7 = mysqli_fetch_array($res7, MYSQLI_ASSOC))) {
                               $municipiosXentDeRegPatronal[] = $reg7;
                       }

                       for($z=0; $z < count($municipiosXentDeRegPatronal); $z++) { 

                           $municipioEntRP= $municipiosXentDeRegPatronal[$z]["idMunicipio"];

                           $sql8 = "UPDATE asentamientos SET idRegPatAsignado=$idsucursal WHERE municipioAsentamiento='$municipioEntRP'";// SE DEBE CAMBIAR EL NOMBRE POR EL DE SUCURSALID P/E
    
                           $log->LogInfo("contador del query sql8:  " . var_export($sql8, true));
                           $res8 = mysqli_query($conexion, $sql8);
                       }//for z*/
           // }
         

// /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
          if($arregloEntidaes!="SIN INFORMACION"){

                if(count($arregloEntidaes)>=0){

                   for($a=0; $a < count($arregloEntidaes);$a++){ 

                       $municipiosXent=[];
                       $entidad= $arregloEntidaes[$a];

                       $sql4 = "SELECT idMunicipio,nombreMunicipio 
                                FROM catalogomunicipios cm
                                LEFT JOIN entidadesfederativas ef on ef.idEntidadFederativa=cm.idEstado
                                WHERE idEstado='$entidad'";
                   
                       $log->LogInfo("contador del query sql4:  " . var_export($sql4, true));
                       $res4 = mysqli_query($conexion, $sql4);
      
                       while (($reg = mysqli_fetch_array($res4, MYSQLI_ASSOC))) {
                               $municipiosXent[] = $reg;
                       }

                       for($b=0; $b < count($municipiosXent); $b++) { //(municipio)

                           // $puntosXMunicipio=[];
                           $municipio= $municipiosXent[$b]["idMunicipio"];

                           $sql5 = "UPDATE asentamientos SET idRegPatAsignado=$idsucursal WHERE municipioAsentamiento='$municipio'";// SE DEBE CAMBIAR EL NOMBRE POR EL DE SUCURSALID P/E
    
                           $log->LogInfo("contador del query sql5:  " . var_export($sql5, true));
                           $res5 = mysqli_query($conexion, $sql5);

// ********************************************************************************************************************************************************************************
                            /*$sql9 = "SELECT idPuntoServicio 
                                     FROM catalogopuntosservicios
                                     WHERE esatusPunto='1'
                                     AND MunicipioPuntoS='$municipio'";
                   
                            $log->LogInfo("contador del query sql9:  " . var_export($sql9, true));
                            $res9 = mysqli_query($conexion, $sql9);

                            while (($reg9 = mysqli_fetch_array($res9, MYSQLI_ASSOC))) {
                               $puntosXMunicipio[] = $reg9;
                            }

                            $log->LogInfo("count psxmunicipio:" . var_export(count($puntosXMunicipio), true));
                            //agregAR IF DEL COUNT

                                for($d=0; $d < count($puntosXMunicipio); $d++){ //puntos de servicio

                                    $empleadosXPS=[];
                                    $puntoServicio= $puntosXMunicipio[$d]["idPuntoServicio"];

                                    $sql10 = "SELECT *
                                              FROM empleados
                                              WHERE empleadoIdPuntoServicio='$puntoServicio'
                                              AND (empleadoEstatusId=1 OR empleadoEstatusId=2) ";
                   
                                    $log->LogInfo("contador del query sql10:  " . var_export($sql10, true));
                                    $res10 = mysqli_query($conexion, $sql10);
    
                                    while (($reg10 = mysqli_fetch_array($res10, MYSQLI_ASSOC))) {
                                       $empleadosXPS[] = $reg10; //AGREGAR EL ARRAY
                                    }

                                    //OTRO IF DE EMPLEADOS

                                    for ($e=0; $e < count($empleadosXPS); $e++) { 

                                        $entidadFederativaId= $empleadosXPS[$e]["entidadFederativaId"];
                                        $empleadoConsecutivoId= $empleadosXPS[$e]["empleadoConsecutivoId"];
                                        $empleadoCategoriaId= $empleadosXPS[$e]["empleadoCategoriaId"];

                                        $sql11 = "UPDATE datosimss 
                                                 SET registroPatronal='$regpatronal' ,idMotivoBajaImss='B',empleadoEstatusImss='5'
                                                 WHERE empladoEntidadImss='$entidadFederativaId'
                                                 AND empleadoConsecutivoImss='$empleadoConsecutivoId'
                                                 AND empleadoCategoriaImss ='$empleadoCategoriaId'";
                                        $log->LogInfo("contador del query sql11:  " . var_export($sql11, true));
                                        $res11 = mysqli_query($conexion, $sql11);

                                        $sql12 = "INSERT INTO historicomovimientosimss(empEntidadMovimiento, EmpConsecutivoMovimiento, empCategoriaMovimiento, tipoMovimiento, fechaMovimiento,usuarioEdicion,registroMovimiento,estatusmov) values ('$entidadFederativaId','$empleadoConsecutivoId','$empleadoCategoriaId',5,now(),'$usuario','$regpatronal',0)";
                                        $log->LogInfo("contador del query sql12:  " . var_export($sql12, true));
                                        $res12 = mysqli_query($conexion, $sql12);

                                    }//for e // empleados
                                }//for d //puntos de servicio*/
// ********************************************************************************************************************************************************************************
                       }//for b (municipio)
                   }//for a
                }//IF COUNT ARREGLO ENTIDADES
          }//if SIN INFORMACION de entidades

          if($arregloMunicipios!="SIN INFORMACION"){

             if(count($arregloMunicipios)>=0){

                for($c=0; $c < count($arregloMunicipios); $c++) { 
                   // $puntosXMunicipio2=[];
                   $municipio= $arregloMunicipios[$c];
    
                   $sql6 = "UPDATE asentamientos SET idRegPatAsignado=$idsucursal WHERE municipioAsentamiento='$municipio'";// SE DEBE CAMBIAR EL NOMBRE POR EL DE SUCURSALID P/E
        
                   $log->LogInfo("contador del query sql6:  " . var_export($sql6, true));
                   $res6 = mysqli_query($conexion, $sql6);

                   /*$sql13 = "SELECT idPuntoServicio 
                            FROM catalogopuntosservicios
                            WHERE esatusPunto='1'
                            AND MunicipioPuntoS='$municipio'";
                   
                   $log->LogInfo("contador del query sql13:  " . var_export($sql13, true));
                   $res13 = mysqli_query($conexion, $sql13);

                   while (($reg13 = mysqli_fetch_array($res13, MYSQLI_ASSOC))) {
                      $puntosXMunicipio2[] = $reg13;
                   }
                   $log->LogInfo("count psxmunicipio2:" . var_export(count($puntosXMunicipio2), true));

                   for($f=0; $f < count($puntosXMunicipio2); $f++){ //puntos de servicio

                       $empleadosXPS2=[];
                       $puntoServicio= $puntosXMunicipio2[$f]["idPuntoServicio"];

                       $sql14 = "SELECT *
                                 FROM empleados
                                 WHERE empleadoIdPuntoServicio='$puntoServicio'
                                 AND (empleadoEstatusId=1 OR empleadoEstatusId=2)";
                   
                       $log->LogInfo("contador del query sql14:  " . var_export($sql14, true));
                       $res14 = mysqli_query($conexion, $sql14);
    
                       while (($reg14 = mysqli_fetch_array($res14, MYSQLI_ASSOC))) {
                          $empleadosXPS2[] = $reg14; //AGREGAR EL ARRAY
                       }

                       for($g=0; $g < count($empleadosXPS2); $g++) { 

                            $entidadFederativaId= $empleadosXPS2[$g]["entidadFederativaId"];
                            $empleadoConsecutivoId= $empleadosXPS2[$g]["empleadoConsecutivoId"];
                            $empleadoCategoriaId= $empleadosXPS2[$g]["empleadoCategoriaId"];

                            $sql15 = "UPDATE datosimss 
                                     SET registroPatronal='$regpatronal' ,idMotivoBajaImss='B',empleadoEstatusImss='5'
                                     WHERE empladoEntidadImss='$entidadFederativaId'
                                     AND empleadoConsecutivoImss='$empleadoConsecutivoId'
                                     AND empleadoCategoriaImss ='$empleadoCategoriaId'";
                            $log->LogInfo("contador del query sql15:  " . var_export($sql15, true));
                            $res15 = mysqli_query($conexion, $sql15);

                            $sql16 = "INSERT INTO historicomovimientosimss(empEntidadMovimiento, EmpConsecutivoMovimiento, empCategoriaMovimiento, tipoMovimiento, fechaMovimiento,usuarioEdicion,registroMovimiento,estatusmov) values ('$entidadFederativaId','$empleadoConsecutivoId','$empleadoCategoriaId',5,now(),'$usuario','$regpatronal',0)";
                            $log->LogInfo("contador del query sql16:  " . var_export($sql16, true));
                            $res16 = mysqli_query($conexion, $sql16);

                        }//for g // empleados
                    }//for f //puntos de servicio*/
                 }//for c
             }//if count arregloMUNICIPIOS
          }//if SIN INFORMACION de Municipios
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//**************************** ACTUALIZACIION DE RP DE EMPLEADOS POR PS.////////////////////////////////////////////////////////
          $response["status"] = "success";
    }
    // $response["datos"]  = $IdSuc;
}catch (Exception $e) {
    $response["message"] = "Error al iniciar sesion";
}
echo json_encode($response);
