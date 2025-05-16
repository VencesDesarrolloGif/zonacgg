<?php
session_start ();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response = array ();
$usuario = $_SESSION ["userLog"];
$response ["status"] = "success";
$response ["message"] = "La Factura fue generada con éxito ";
$log = new KLogger ( "ajaxNewFactura.log" , KLogger::DEBUG );
$log->LogInfo("Valor de la variable _POST : " . var_export ($_POST, true));

  
if (!empty ($_POST)){    
    $usuarioCaptura=$_SESSION ["userLog"]["usuario"];
    $listaUniformes=$_POST["listaUniformes"];
    $mercanciaEntregada=$_POST["mercanciaEntregada"];
    $tipoPago=$_POST["tipoPago"];
    $descripcionPago=$_POST["descripcionPago"];
    $totalFactura=$_POST["totalFactura"];
    $proveedor=$_POST["proveedor"] ;
    $facturaPagada=$_POST["facturaPagada"];
    $lineaNegocio=$_POST["lineaNegocio"];
    $entidadProducto=$_POST["entidadProducto"];
    $sucursalProducto=$_POST["sucursalProducto"];
    //$entidadProducto=$usuarioCaptura=$_SESSION ["userLog"]["entidadFederativaUsuario"];
    //$log->LogInfo("Valor de la variable entidadProducto : " . var_export ($entidadProducto, true));
    $registroStock= array();
    $folioFactura=$listaUniformes[0]["idFactura"];


    $anio = DATE('Y');
    if ($mercanciaEntregada == 1) {
        $fechaEntrega = date("Y-m-d");
    } else {
        $fechaEntrega = 'null';
    }

    if ($facturaPagada == 1) {
        $fechaPago = date("Y-m-d");
    } else {
        $fechaPago = 'null';
    }

    try{                                                                                                                                                                                                                                                                                                                                                                                                        
        $sql = "INSERT INTO facturauniforme(idFactura,
                                            fechaFactura,
                                            mercanciaEntregada,
                                            fechaMercanciaEntregada,
                                            formaPagoFactura,
                                            descripcionPago,
                                            totalFactura,
                                            idProveedorFactura,
                                            idLineaNegocioF,
                                            facturaPagada,
                                            entidadArecibir,
                                            fechaPagoFactura,
                                            sucursalArecibir) 
                VALUES ('$folioFactura',
                        now(),
                        '$mercanciaEntregada',";

                if ($mercanciaEntregada==1) {
                    $sql.="CAST('$fechaEntrega' AS DATE),";
                }else{
                    $sql.="null,";
                }

                $sql.="'$tipoPago',
                       '$descripcionPago',
                       '$totalFactura',
                       '$proveedor',
                       '$lineaNegocio',
                       '$facturaPagada',
                       '$entidadProducto',";

                if ($facturaPagada==1) {
                    $sql.="CAST('$fechaPago' AS DATE)";
                }else{
                    $sql.="null";
                }
                $sql.=", '$sucursalProducto')";
                      
        // if($fechaPago ==""){
            // $sql.= " null)";
        // }else{
            // $sql.= " CAST('$fechaPago' AS DATE))";
        // }
        $res = mysqli_query($conexion, $sql);
        $log->LogInfo("Valor de la variable sql : " . var_export ($sql, true));

        if($res !== true) {
           $response["status"]= "error";
           $response["message"] = "La Factura no se pudo generar facturauniforme";
           return;
        }else{
            for($i = 0; $i < count($listaUniformes); $i++) {
                $idFactura        = $listaUniformes[$i]["idFactura"];
                $claveUniforme    = $listaUniformes[$i]["tipoUniforme"];
                $cantidadUniforme = $listaUniformes[$i]["cantidadUni"];
                $precioUniforme   = $listaUniformes[$i]["precioUni"];

                $sql1 = "INSERT INTO comprauniforme VALUES ('$idFactura','$claveUniforme','$cantidadUniforme','$precioUniforme')";
                $res1 = mysqli_query($conexion, $sql1);

                $log->LogInfo("Valor de la variable sql1 : " . var_export ($sql1, true));


                if($res1 !== true) {
                   $response["status"]= "error";
                   $response["message"] = "La Factura no se pudo generar comprauniforme";
                   return;
                }else{
                    $fecha1=$anio.'-01-01';
                    $fecha2=$anio.'-12-31';
                    $sql2 = "UPDATE catalogotiposuniforme 
                             SET costoUniforme=(SELECT (SUM(precioUniforme)/count(*))
                                               FROM comprauniforme cu JOIN facturauniforme f ON (f.idFactura=cu.idFacturaCompra)
                                               WHERE claveUniformeCompra='$claveUniforme'
                                               AND f.fechaFactura between CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)) 
                             WHERE idTipoUniforme='$claveUniforme'";
                    $res2 = mysqli_query($conexion, $sql2);
                    $log->LogInfo("Valor de la variable sql2 : " . var_export ($sql2, true));

                    if($res2 !== true) {
                        $response["status"]= "error";
                        $response["message"] = "La Factura no se pudo generar catalogotiposuniforme";
                        return;
                    }else{
                        $sql3 = "SELECT count(claveUniforme)  as existe 
                                 FROM stockuniforme
                                 WHERE claveUniforme='$claveUniforme' 
                                 AND entidadUniforme='$entidadProducto'
                                 AND sucursalUniformeStock='$sucursalProducto'";

                        $res3 = mysqli_query($conexion, $sql3);
                        $log->LogInfo("Valor de la variable sql3 : " . var_export ($sql3, true));

                        while(($reg3 = mysqli_fetch_array($res3, MYSQLI_ASSOC))){
                               $registroStock[] = $reg3;
                        }

                        if($registroStock[0]["existe"]!=0) {
                            $sql4 = "UPDATE stockUniforme 
                                    SET cantidadUniformes=cantidadUniformes+$cantidadUniforme
                                    WHERE claveUniforme='$claveUniforme' 
                                    AND entidadUniforme='$entidadProducto'
                                    AND sucursalUniformeStock='$sucursalProducto'";

                            $res4 = mysqli_query($conexion, $sql4);
                            $log->LogInfo("Valor de la variable sql4 : " . var_export ($sql4, true));

                            if ($res4 !== true) {
                                $response["status"]= "error";
                                $response["message"] = "La Factura no se pudo generar stockUniforme update";
                            }
                        }else{
                            $sql4 = "INSERT INTO stockuniforme 
                                    VALUES ('$claveUniforme',
                                            '$entidadProducto',
                                            '$cantidadUniforme',
                                            '$sucursalProducto')";

                            $res4 = mysqli_query($conexion, $sql4);
                            $log->LogInfo("Valor de la variable sql4 : " . var_export ($sql4, true));
                            
                            if ($res4 !== true){
                                $response["status"]= "error";
                                $response["message"] = "La Factura no se pudo generar stockUniforme insert";
                            }
                        }
                    }//else res2
                }//else res1
            }//for
        }//else res
    } 
    catch (Exception $e){
        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();
    }
}
echo json_encode ($response);
?> 