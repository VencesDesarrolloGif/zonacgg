<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$negocio = new Negocio ();
$response = array ();
$datosCompro=array();
$usuario = $_SESSION ["userLog"]["rol"];
//$log = new KLogger ( "ajaxttraetotalesentidades.log" , KLogger::DEBUG );
$lineanegociocomprobacionesdeabonos = $_POST['lineanegociocomprobacionesdeabonos'];
$accioncomprobacionesdeabonos=$_POST['accioncomprobacionesdeabonos'];
$entidadescomprobacionesdeabonos=$_POST['entidadescomprobacionesdeabonos'];
$fechafinalcomprobacionesdeabonos=$_POST['fechafinalcomprobacionesdeabonos'];
$fechainiciocomprobacionesdeabonos=$_POST['fechainiciocomprobacionesdeabonos'];

verificarInicioSesion ($negocio);
if (!empty ($_POST))
{
    try
    {
      $datos1 = $negocio->negocio_obtenerlistacomprobaciones($accioncomprobacionesdeabonos,$lineanegociocomprobacionesdeabonos,$entidadescomprobacionesdeabonos,$fechafinalcomprobacionesdeabonos,$fechainiciocomprobacionesdeabonos);

      for($i=0;$i<(count($datos1));$i++)
        {    
                $datosCompro[$i]["tipomovimiento"]       =$datos1[$i]["tipomovimiento"];
                $datosCompro[$i]["Estatus"]              =$datos1[$i]["Estatus"];
                $datosCompro[$i]["FechaComprobación"]    =$datos1[$i]["FechaComprobación"];
                $datosCompro[$i]["LineaNegocio"]         =$datos1[$i]["LineaNegocio"]; 
                $datosCompro[$i]["Entidad"]              =$datos1[$i]["Entidad"]; 
                $datosCompro[$i]["Departamento"]         =$datos1[$i]["Departamento"]; 
                $datosCompro[$i]["SubDepartamento"]      =$datos1[$i]["SubDepartamento"]; 
                $datosCompro[$i]["Beneficiario"]         =$datos1[$i]["Beneficiario"]; 
                $datosCompro[$i]["ClaveClasificacion"]   =$datos1[$i]["ClaveClasificacion"]; 
                $datosCompro[$i]["Concepto"]             =$datos1[$i]["Concepto"]; 
                $datosCompro[$i]["Referencia"]           =$datos1[$i]["Referencia"];
                $datosCompro[$i]["Monto"]                =$datos1[$i]["Monto"]; 

                $datos2 = $negocio->negocio_obtenertamañoporid($datos1[$i]['idmovimiento'],$datos1[$i]["tipomovimiento"]);
               // $idsolic=$datos2[0]["idSolicitudPago"];
             //   $log->LogInfo("Valor de la variable \$idsolic: " . var_export ($idsolic, true));
                if($datos1[$i]["tipomovimiento"]=="CARGO"){
                    $accionSoli="0"; // SI ES CERO VIENE DE UN ABONO CUALQUIERA
                }else{
                    $accionSoli="1";  // SI ES UNO VIENE DE UN ABONO POR SOLICITUD
                }
             //   $log->LogInfo("Valor de la variable \$accionSoli: " . var_export ($accionSoli, true));



                    for($j=0;$j<(count($datos2));$j++)
                    {   
                        if($datos1[$i]["tipomovimiento"]=="ABONO"){
                            $idcompro=$datos2[$j]['idMovimientoCompro'];
                            $fecha=$datos2[$j]['fechaMovimientoCompro'];
                            $datosCompro [$i]["DocumentoPDFAnexado"][$j] ="<div id='verpdfcomprobacion' title='Abrir Pdf' class='fa fa-file-pdf-o' style= 'font-size:30px;color:red;cursor:pointer;' onclick='cargarpdfComprobaciondeabono(\"" . $datos1[$i]['idmovimientofinanciero'] . "\",\"" . $idcompro . "\",\"" . $datos1[$i]['idmovimiento'] . "\",\"" . $fecha . "\");'> </div>";

                        }else{
                            $idcompro="0";
                             $fecha=$datos1[$i]['fechacargo'];
                             $datosCompro[$i]["DocumentoPDFAnexado"][0]  ="<div id='verpdfcomprobacion' title='Abrir Pdf' class='fa fa-file-pdf-o' style= 'font-size:30px;color:red;cursor:pointer;' onclick='cargarpdfComprobaciondeabono(\"" . $datos1[$i]['idmovimientofinanciero'] . "\",\"" . $idcompro . "\",\"" . $datos1[$i]['idmovimiento'] . "\",\"" . $fecha . "\");'> </div>";
                        }
                            
                        }
                        
                $datosCompro[$i]["Revisado"] ="<img style='cursor: pointer' src='img/confirmarImss.png' id='imgrevisado' name='imgrevisado'  width='25' value='0' onclick='datochecadoComprobaciondeabono(\"" . $datos1[$i]['idmovimiento'] . "\",\"" . $accionSoli . "\");'></img>"; 
            }
            $response ["status"] = "success";
            $response ["datos"] = $datosCompro; 
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