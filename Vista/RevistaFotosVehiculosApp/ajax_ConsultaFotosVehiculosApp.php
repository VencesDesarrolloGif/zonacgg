<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
$regionUsr          = array();
$entidades          = array();
$log = new KLogger ( "ajax_ConsultaFotosVehiculosApp.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
//$log->LogInfo("Valor de la variable response " . var_export ($response, true));
$rolusr=$_SESSION['userLog']['rol'];
$usuarioId=$_SESSION['userLog']['usuarioId'];
try {
    $FechaInicio = $_POST["FechaInicio"];
    $FechaFinal  = $_POST["FechaFinal"];

    if ($rolusr!="Gerente Regional") {
        $sql = "SELECT f.NumeroEmpleado,concat_ws(' ',e.nombreEmpleado,e.apellidoPaterno,e.apellidoMaterno) as NombreEmpleado,f.NumeroPlacaVehiculo as Placa,c.Descripcion as Color, m.Marca as Marca,md.Modelo as Modelo,p.AnioVehiculo as Anio,p.CentimetrosCubicos as Cilindrada,f.FechaApp as Fecha
            FROM fotosvehiculosappasistencia f
            left join parquevehicular p on(f.NumeroPlacaVehiculo=p.NumeroPlaca)
            left join catalogocolores c on (c.idcolor=p.IdColorVehiculo) 
            left join catalogomarcasvehiculos m on (m.idMarca=p.idMarca) 
            left join catalogomodelosvehiculos md on (md.idModelo=p.idModelo) 
            left join empleados e on (f.NumeroEmpleado=concat_ws('-',e.entidadFederativaId,e.empleadoConsecutivoId,e.empleadoCategoriaId))
            where f.FechaApp BETWEEN CAST('$FechaInicio' AS DATE) AND CAST('$FechaFinal' AS DATE)
            group by f.NumeroPlacaVehiculo,f.FechaApp
            order by f.NumeroPlacaVehiculo,f.FechaApp";   
    }else{

        $sql1 = "SELECT idRegionI,idLineaNegocioRUR  
                 FROM relacionusuarios_regiones
                 WHERE idUsuario='$usuarioId'";

                $res1 = mysqli_query($conexion, $sql1);
                while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
                        $regionUsr[] = $reg1;
                }
// $log->LogInfo("Valor de la variable sql1 " . var_export ($sql1, true));

        $idRegion= $regionUsr[0]["idRegionI"];
        $idLnGR= $regionUsr[0]["idLineaNegocioRUR"];

        $sql2 ="SELECT idEntidadI
                FROM index_regiones ir
                LEFT JOIN entidadesfederativas ef on (ef.idEntidadFederativa=ir.idEntidadI)
                WHERE ir.idRegionI='$idRegion'
                AND ir.idLineaNegI='$idLnGR'";
// $log->LogInfo("Valor de la variable sql2 " . var_export ($sql2, true));

        $res2 = mysqli_query($conexion, $sql2);
        while (($reg2 = mysqli_fetch_array($res2, MYSQLI_ASSOC))){
            $entidades[] = $reg2;
        }

        for ($i = 0; $i < count($entidades); $i++) {
            $entidadesRegion[] = $entidades[$i]['idEntidadI'];  // Guardamos solo los idSucursalUsr
        }

        $arregloEntidades = implode(',', $entidadesRegion);

        $sql = "SELECT f.NumeroEmpleado,
                       concat_ws(' ',e.nombreEmpleado,e.apellidoPaterno,e.apellidoMaterno) as NombreEmpleado,
                       f.NumeroPlacaVehiculo as Placa,
                       c.Descripcion as Color,
                       m.Marca as Marca,
                       md.Modelo as Modelo,
                       p.AnioVehiculo as Anio,
                       p.CentimetrosCubicos as Cilindrada,
                       f.FechaApp as Fecha
                FROM fotosvehiculosappasistencia f
                left join parquevehicular p on(f.NumeroPlacaVehiculo=p.NumeroPlaca)
                left join catalogocolores c on (c.idcolor=p.IdColorVehiculo) 
                left join catalogomarcasvehiculos m on (m.idMarca=p.idMarca) 
                left join catalogomodelosvehiculos md on (md.idModelo=p.idModelo) 
                left join empleados e on (f.NumeroEmpleado=concat_ws('-',e.entidadFederativaId,e.empleadoConsecutivoId,e.empleadoCategoriaId))
                where f.FechaApp BETWEEN CAST('$FechaInicio' AS DATE) AND CAST('$FechaFinal' AS DATE)
                and P.idEntidadFederativa IN ($arregloEntidades)
                AND P.idLineaNegocio='$idLnGR'
                group by f.NumeroPlacaVehiculo,f.FechaApp
                order by f.NumeroPlacaVehiculo,f.FechaApp";
    }//else gerente regional
        // $log->LogInfo("Valor de la variable sql " . var_export ($sql, true));

        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
        $log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
        $log->LogInfo("Valor de la variable COUNT " . var_export (count($datos), true));


    for($i = 0; $i < count($datos); $i++){
        $log->LogInfo("Valor de la variable i " . var_export ($i, true));

        $NumeroEmpleado = $datos[$i]["NumeroEmpleado"];
        $NumeroEmpleado1 = str_replace('-',"", $NumeroEmpleado);
        $Fecha = $datos[$i]["Fecha"];
        $Fecha1 = str_replace('-',"", $Fecha);
        $Placa = $datos[$i]["Placa"];

        $ruta1 ="FotosVehiculos/".$Placa."/".$Fecha."/".$NumeroEmpleado1."_".$Fecha1."_".$Placa."_Frente.png";
        $ruta2 ="FotosVehiculos/".$Placa."/".$Fecha."/".$NumeroEmpleado1."_".$Fecha1."_".$Placa."_LadoDerecho.png";
        $ruta3 ="FotosVehiculos/".$Placa."/".$Fecha."/".$NumeroEmpleado1."_".$Fecha1."_".$Placa."_LadoIzquierdo.png";
        $ruta4 ="FotosVehiculos/".$Placa."/".$Fecha."/".$NumeroEmpleado1."_".$Fecha1."_".$Placa."_Atras.png";
        
        $datos[$i]["Ruta1"]= "<img style='width: 30%' title='Abrir Documento' src='img/pdf.png' class='cursorImg' id='btnAbrirDoc' onclick=btnAbrirFotoVehiculoApp('$ruta1')><br>";
        $datos[$i]["Ruta2"]= "<img style='width: 22%' title='Abrir Documento' src='img/pdf.png' class='cursorImg' id='btnAbrirDoc' onclick=btnAbrirFotoVehiculoApp('$ruta2')><br>";
        $datos[$i]["Ruta3"]= "<img style='width: 22%' title='Abrir Documento' src='img/pdf.png' class='cursorImg' id='btnAbrirDoc' onclick=btnAbrirFotoVehiculoApp('$ruta3')><br>";
        $datos[$i]["Ruta4"]= "<img style='width: 30%' title='Abrir Documento' src='img/pdf.png' class='cursorImg' id='btnAbrirDoc' onclick=btnAbrirFotoVehiculoApp('$ruta4')><br>";
        
    }
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
