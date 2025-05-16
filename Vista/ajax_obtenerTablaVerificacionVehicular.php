<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
require "conexion.php";
// $log = new KLogger ( "ajaxObtenerVehiculosVerificacion.log" , KLogger::DEBUG );
$response = array("status" => "success");
$color=$_POST['color'];
$consulta=$_POST['consulta'];
// $entidadesusuarioVerificacion=$_SESSION ["userLog"]["entidadFederativaUsuario"];
$nombreusuarioVerificacion=$_SESSION ["userLog"]["usuario"];
$rolusr=$_SESSION ["userLog"]["rol"];
$fecha = date("m"); 
//$fecha = "12";
$year1 = date('Y')-1;
$year = date('Y');
//$year = "2021";
// $log->LogInfo("Valor de la variable _POST " . var_export ($_POST, true));

$usuarioId=$_SESSION['userLog']['usuarioId'];
$regionUsr          = array();
$entidades          = array();

try{

  if ($rolusr=="Gerente Regional") {


    $sql1 = "SELECT idRegionI,idLineaNegocioRUR  
             FROM relacionusuarios_regiones
             WHERE idUsuario='$usuarioId'";

             $res1 = mysqli_query($conexion, $sql1);
             while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
                     $regionUsr[] = $reg1;
             }

             $idRegion= $regionUsr[0]["idRegionI"];
         $idLnGR= $regionUsr[0]["idLineaNegocioRUR"];

         $sql2 ="SELECT idEntidadI
                 FROM index_regiones ir
                 LEFT JOIN entidadesfederativas ef on (ef.idEntidadFederativa=ir.idEntidadI)
                 WHERE ir.idRegionI='$idRegion'
                 AND ir.idLineaNegI='$idLnGR'";

          $res2 = mysqli_query($conexion, $sql2);
          while (($reg2 = mysqli_fetch_array($res2, MYSQLI_ASSOC))){
              $entidades[] = $reg2;
          }

          for ($i = 0; $i < count($entidades); $i++) {
            $entidadesRegion[] = $entidades[$i]['idEntidadI'];  // Guardamos solo los idSucursalUsr
            }

        $entidadesusuarioVerificacion = implode(',', $entidadesRegion);
  }else{
        $entidadesusuarioLic = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32'];
        $entidadesusuarioVerificacion = implode(',', $entidadesusuarioLic);

  } 


  $listaVehiculosVerificacion= $negocio -> traerCatalogoVehiculosVerificacion($entidadesusuarioVerificacion,$nombreusuarioVerificacion,$fecha,$consulta,$color,$year1,$rolusr);
  $listaVehiculosVerificacion=array_merge($listaVehiculosVerificacion);// merge sirve para eliminar los campos vacion y hacer el consecutivo del array
  for ($i = 0; $i < count($listaVehiculosVerificacion); $i++)
    {

        $NumEconomico = $listaVehiculosVerificacion[$i]["NumEconomico"];
        $Placas = $listaVehiculosVerificacion[$i]["Placas"];
        $MarCaVehiculo = $listaVehiculosVerificacion[$i]["MarCaVehiculo"];
        $ModeloVehiculo = $listaVehiculosVerificacion[$i]["ModeloVehiculo"];
        $ColorEngomado = $listaVehiculosVerificacion[$i]["ColorEngomado"];
        $estatuscongif = $listaVehiculosVerificacion[$i]["estatuscongif"];
        $EmpleadoUnoCon = $listaVehiculosVerificacion[$i]["EmpleadoUnoCon"];
        $empleadodoscon = $listaVehiculosVerificacion[$i]["empleadodoscon"];
        $empleadotrescon = $listaVehiculosVerificacion[$i]["empleadotrescon"];
        $estatusSingif = $listaVehiculosVerificacion[$i]["estatusSingif"];
        $ApellidoP = $listaVehiculosVerificacion[$i]["ApellidoP"];
        $apellidoM = $listaVehiculosVerificacion[$i]["apellidoM"];
        $Nombre = $listaVehiculosVerificacion[$i]["Nombre"];
        $PrimerSemestre = $listaVehiculosVerificacion[$i]["PrimerSemestre"];
        $SegundoSemestre = $listaVehiculosVerificacion[$i]["SegundoSemestre"];
        $FechaUnoSemestreUno = $listaVehiculosVerificacion[$i]["FechaUnoSemestreUno"];
        $FechaDosSemestreUno = $listaVehiculosVerificacion[$i]["FechaDosSemestreUno"];
        $FechaUnoSemestreDos = $listaVehiculosVerificacion[$i]["FechaUnoSemestreDos"];
        $FechaDosSemestreDos = $listaVehiculosVerificacion[$i]["FechaDosSemestreDos"];
        $idColorEngomado = $listaVehiculosVerificacion[$i]["idColorEngomado"];
        $fechaUltimaVerificacion = $listaVehiculosVerificacion[$i]["fechaUltimaVerificacion"];
        $NombreEntidades = $listaVehiculosVerificacion[$i]["NombreEntidades"];
        $NombreLineaNegocio = $listaVehiculosVerificacion[$i]["NombreLineaNegocio"];
  //$log->LogInfo("Valor de la variable fechaUltimaVerificacion : " . var_export ($fechaUltimaVerificacion, true));

        if($fechaUltimaVerificacion != null && $fechaUltimaVerificacion != "null" ){ // Se hace el explode para comparr el año del registro con el año actual
          $ExplodeFecha = explode("-", $fechaUltimaVerificacion);
          $ExplodeAño = $ExplodeFecha[0];
          if($PrimerSemestre=="1"){            
            $listaVehiculosVerificacion[$i]["fechaUltimaVerificacion"] = ($fechaUltimaVerificacion . " " ."Primer Semestre");
          }else if($PrimerSemestre=="0"){
            $listaVehiculosVerificacion[$i]["fechaUltimaVerificacion"] = ($fechaUltimaVerificacion . " " ."Segundo Semestre");            
          }else if($PrimerSemestre=="2"){
            $listaVehiculosVerificacion[$i]["fechaUltimaVerificacion"] = ("Sin Fecha No Se Verifica");            
          }
        }else{
          $listaVehiculosVerificacion[$i]["fechaUltimaVerificacion"] = ("Nunca Ha Sido Verificada");
        }

        if($estatuscongif=="ACTIVO"){
          $listaVehiculosVerificacion[$i]["Empleado"]=($empleadotrescon . "-" . $EmpleadoUnoCon . "-" . $empleadodoscon . " " .  $Nombre . " " . $ApellidoP . " " . $apellidoM);
        }else{
          $listaVehiculosVerificacion[$i]["Empleado"]=("09" . "-" . "0350" . "-" . "02" . " " .  "RICARDO" . " " . "ROSAS" . " " . "ORTIZ");
        }
        if($PrimerSemestre=="2" || $SegundoSemestre=="2"){
          $fechalim = "Sin Fecha Limite";
          $listaVehiculosVerificacion[$i]["FechaLimite"]=($fechalim);
          $listaVehiculosVerificacion[$i]["imagenverificado"]="<img style='cursor: pointer' src='img/ok.png' width='25'></img>";
          $listaVehiculosVerificacion[$i]["verificacion"]="Este Vehiculo fue Confirmado Para No Recibir Verificaciones";
        }else{
          if($fecha<="06"){
            $PrimerSemestre1 = "1";
            $SegundoSemetre1 = "0";
            $month=$FechaDosSemestreUno;
            $day = date("d", mktime(0,0,0, $month+1, 0, $year)); 
            $day1 = "01";
            $month1=$FechaUnoSemestreUno;
            $listaVehiculosVerificacion[$i]["FechaInicial"]=($year . "-" . $month1 . "-" . $day1);
            $FechaInicial = $listaVehiculosVerificacion[$i]["FechaInicial"];
            $listaVehiculosVerificacion[$i]["FechaLimite"]=($day . "-" . $month . "-" . $year);
            $listaVehiculosVerificacion[$i]["FechaLimite1"]=($year . "-" . $month . "-" . $day);
            $FechaLimite1 = $listaVehiculosVerificacion[$i]["FechaLimite1"];
  //jalar la fecha que se inserto y comparar con la actual para habilitar la funcion de insertar verificacion   
            if($PrimerSemestre == null || $PrimerSemestre == NULL || $PrimerSemestre == "null" || $PrimerSemestre=="0"){
              $listaVehiculosVerificacion[$i]["imagenverificado"]="<img style='cursor: pointer' src='img/rechazarImss.png' width='25'></img>";

              $listaVehiculosVerificacion[$i]["verificacion"]="<a href='javascript:RegistrarVerificacion(\"" . $NumEconomico . "\",\"" . $Placas . "\",\"" . $idColorEngomado . "\",\"" . $MarCaVehiculo . "\",\"" . $ModeloVehiculo . "\",\"" . $ColorEngomado . "\",\"" . $FechaInicial . "\",\"" . $FechaLimite1 . "\",\"" . $PrimerSemestre1 . "\",\"" . $SegundoSemetre1 . "\");'>Ingresar Nueva Verificación</a>";
            }else{
              if(($fechaUltimaVerificacion != null && $ExplodeAño != $year ) && ($fechaUltimaVerificacion != NULL && $ExplodeAño != $year) && ($fechaUltimaVerificacion != "null" && $ExplodeAño != $year)){
                $listaVehiculosVerificacion[$i]["imagenverificado"]="<img style='cursor: pointer' src='img/rechazarImss.png' width='25'></img>";
                $listaVehiculosVerificacion[$i]["verificacion"]="<a href='javascript:RegistrarVerificacion(\"" . $NumEconomico . "\",\"" . $Placas . "\",\"" . $idColorEngomado . "\",\"" . $MarCaVehiculo . "\",\"" . $ModeloVehiculo . "\",\"" . $ColorEngomado . "\",\"" . $FechaInicial . "\",\"" . $FechaLimite1 . "\",\"" . $PrimerSemestre1 . "\",\"" . $SegundoSemetre1 . "\");'>Ingresar Nueva Verificación</a>";
              }else{
              
                $listaVehiculosVerificacion[$i]["imagenverificado"]="<img style='cursor: pointer' src='img/ok.png' width='25'></img>";
                $listaVehiculosVerificacion[$i]["verificacion"]="Vehiculo Verificado Espere al Segundo Semestre";
              }
            }

          }else{
            $PrimerSemestre2 = "0";
            $SegundoSemetre2= "1";
            $month=$FechaDosSemestreDos;
            $day = date("d", mktime(0,0,0, $month+1, 0, $year));
            $day1 = "01";
            $month1=$FechaUnoSemestreDos;
            $listaVehiculosVerificacion[$i]["FechaInicial"]=($year . "-" . $month1 . "-" . $day1);
            $FechaInicial = $listaVehiculosVerificacion[$i]["FechaInicial"];
            $listaVehiculosVerificacion[$i]["FechaLimite"]=($day . "-" . $month . "-" . $year);
            $listaVehiculosVerificacion[$i]["FechaLimite1"]=($year . "-" . $month . "-" . $day);
            $FechaLimite1 = $listaVehiculosVerificacion[$i]["FechaLimite1"];

            if($SegundoSemestre == null || $PrimerSemestre == NULL || $PrimerSemestre == "null" || $SegundoSemestre=="0"){
              $listaVehiculosVerificacion[$i]["imagenverificado"]="<img style='cursor: pointer' src='img/rechazarImss.png' width='25'></img>";

              $listaVehiculosVerificacion[$i]["verificacion"]="<a href='javascript:RegistrarVerificacion(\"" . $NumEconomico . "\",\"" . $Placas . "\",\"" . $idColorEngomado . "\",\"" . $MarCaVehiculo . "\",\"" . $ModeloVehiculo . "\",\"" . $ColorEngomado . "\",\"" . $FechaInicial . "\",\"" . $FechaLimite1 . "\",\"" . $PrimerSemestre2 . "\",\"" . $SegundoSemetre2 . "\");'>Ingresar Nueva Verificación</a>";
            }else{
              if(($fechaUltimaVerificacion != null && $ExplodeAño != $year ) && ($fechaUltimaVerificacion != NULL && $ExplodeAño != $year) && ($fechaUltimaVerificacion != "null" && $ExplodeAño != $year)){
                $listaVehiculosVerificacion[$i]["imagenverificado"]="<img style='cursor: pointer' src='img/rechazarImss.png' width='25'></img>";

              $listaVehiculosVerificacion[$i]["verificacion"]="<a href='javascript:RegistrarVerificacion(\"" . $NumEconomico . "\",\"" . $Placas . "\",\"" . $idColorEngomado . "\",\"" . $MarCaVehiculo . "\",\"" . $ModeloVehiculo . "\",\"" . $ColorEngomado . "\",\"" . $FechaInicial . "\",\"" . $FechaLimite1 . "\",\"" . $PrimerSemestre2 . "\",\"" . $SegundoSemetre2 . "\");'>Ingresar Nueva Verificación</a>";
              }else{
                $listaVehiculosVerificacion[$i]["imagenverificado"]="<img style='cursor: pointer' src='img/ok.png' width='25'></img>";
                $listaVehiculosVerificacion[$i]["verificacion"]="Vehiculo Verificado Espere al Primer Semestre Del Siguiente Año";
              }
            }
          }
        }

  } // for I
	$response["data"]= $listaVehiculosVerificacion;
}catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se pudo obtener lista de los Vehiculos Con Verificacion";
	}
echo json_encode($response);
?>