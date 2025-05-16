<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
require_once("../../Negocio/Negocio.class.php");
require_once ("../Helpers.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
$response           = array();
$response["status"] = "error";
$datos              = array();
//$log = new KLogger ( "ajax_ConsultaPeticionesTurnosCapacitacion.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
//$log->LogInfo("Valor de la variable response " . var_export ($response, true));
$regionUsr          = array();
$entidades          = array();
$rolusr=$_SESSION['userLog']['rol'];
$usuarioId=$_SESSION['userLog']['usuarioId'];

try {
    if ($rolusr!="Gerente Regional") {

    $sql = "SELECT  ln.descripcionLineaNegocio,ef.nombreEntidadFederativa,p.NumeroPlaca,cmv.Marca,cmod.Modelo,ccol.Descripcion,p.AnioVehiculo,p.CentimetrosCubicos,p.EstatusDelVehiculo,concat_ws('-',a.entidadFederativaIdC,a.empleadoConsecutivoIdC,a.empleadoCategoriaIdC) as noEmp,concat_ws(' ',e.nombreEmpleado,e.apellidoPaterno,e.apellidoMaterno) as nombreEmp,empleadoEstatusId
            FROM parquevehicular p
            left join asignacionesparquevehicular a on (a.idvehiculoC=p.idvehiculo) 
            left join catalogocolores c on (c.idcolor=p.IdColorVehiculo) 
            left join catalogomarcasvehiculos m on (m.idMarca=p.idMarca) 
            left join catalogomodelosvehiculos md on (md.idModelo=p.idModelo) 
            left join empleados e on (a.entidadFederativaIdC=e.entidadFederativaId and a.empleadoConsecutivoIdC=e.empleadoConsecutivoId and a.empleadoCategoriaIdC=e.empleadoCategoriaId)
            left join catalogolineanegocio ln on ln.idLineaNegocio=p.idLineaNegocio
            left join entidadesfederativas ef on ef.idEntidadFederativa=p.idEntidadFederativa
            LEFT JOIN catalogomarcasvehiculos cmv on cmv.idMarca=p.idMarca
            left join catalogomodelosvehiculos cmod on cmod.idModelo=p.idModelo
            left join catalogocolores ccol on ccol.idcolor=p.IdColorVehiculo";   
    }else{

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

        $arregloEntidades = implode(',', $entidadesRegion);

        $sql = "SELECT  ln.descripcionLineaNegocio,ef.nombreEntidadFederativa,p.NumeroPlaca,cmv.Marca,cmod.Modelo,ccol.Descripcion,p.AnioVehiculo,p.CentimetrosCubicos,p.EstatusDelVehiculo,concat_ws('-',a.entidadFederativaIdC,a.empleadoConsecutivoIdC,a.empleadoCategoriaIdC) as noEmp,concat_ws(' ',e.nombreEmpleado,e.apellidoPaterno,e.apellidoMaterno) as nombreEmp,empleadoEstatusId
            FROM parquevehicular p
            left join asignacionesparquevehicular a on (a.idvehiculoC=p.idvehiculo) 
            left join catalogocolores c on (c.idcolor=p.IdColorVehiculo) 
            left join catalogomarcasvehiculos m on (m.idMarca=p.idMarca) 
            left join catalogomodelosvehiculos md on (md.idModelo=p.idModelo) 
            left join empleados e on (a.entidadFederativaIdC=e.entidadFederativaId and a.empleadoConsecutivoIdC=e.empleadoConsecutivoId and a.empleadoCategoriaIdC=e.empleadoCategoriaId)
            left join catalogolineanegocio ln on ln.idLineaNegocio=p.idLineaNegocio
            left join entidadesfederativas ef on ef.idEntidadFederativa=p.idEntidadFederativa
            LEFT JOIN catalogomarcasvehiculos cmv on cmv.idMarca=p.idMarca
            left join catalogomodelosvehiculos cmod on cmod.idModelo=p.idModelo
            left join catalogocolores ccol on ccol.idcolor=p.IdColorVehiculo
            WHERE p.idEntidadFederativa IN ($arregloEntidades)
            AND p.idLineaNegocio='$idLnGR'";

    }   
    
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
    for($i = 0; $i < count($datos); $i++){
        $estatusVehiculo = $datos[$i]["EstatusDelVehiculo"]; 
        
        $entidadMayusc = strtoupper($datos[$i]["nombreEntidadFederativa"]); 
        $entidadMayusc = str_replace(
                    array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
                    array('Á','A','A','A','A','A','A','A','A','É','E','E','E','E','E','E','E','Í','I','I','I','I','I','I','I','Ó','O','O','O','O','O','O','O','Ú','U','U','U','U','U','U','U'),
                    $entidadMayusc);
        $datos[$i]["nombreEntidadFederativa"]=$entidadMayusc; 


        $marcaMayusc = strtoupper($datos[$i]["Marca"]); 
        $marcaMayusc = str_replace(
                    array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
                    array('Á','A','A','A','A','A','A','A','A','É','E','E','E','E','E','E','E','Í','I','I','I','I','I','I','I','Ó','O','O','O','O','O','O','O','Ú','U','U','U','U','U','U','U'),
                    $marcaMayusc);
        $datos[$i]["Marca"]=$marcaMayusc; 

        $modeloMayusc = strtoupper($datos[$i]["Modelo"]); 
        $modeloMayusc = str_replace(
                    array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
                    array('Á','A','A','A','A','A','A','A','A','É','E','E','E','E','E','E','E','Í','I','I','I','I','I','I','I','Ó','O','O','O','O','O','O','O','Ú','U','U','U','U','U','U','U'),
                    $modeloMayusc);
        $datos[$i]["Modelo"]=$modeloMayusc; 

        $colorMayusc = strtoupper($datos[$i]["Descripcion"]); //COLOR
        $colorMayusc = str_replace(
                    array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
                    array('Á','A','A','A','A','A','A','A','A','É','E','E','E','E','E','E','E','Í','I','I','I','I','I','I','I','Ó','O','O','O','O','O','O','O','Ú','U','U','U','U','U','U','U'),
                    $colorMayusc);
        $datos[$i]["Descripcion"]=$colorMayusc; 

        if($estatusVehiculo == "1"){
            $datos[$i]["EstatusDelVehiculo"]= "<label style='color:green'>ACTIVO</label>";
        }else if($estatusVehiculo == "0"){
            $datos[$i]["EstatusDelVehiculo"]= "<label style='color:red'>INACTIVO</label>";
        }

        $estatusEmp = $datos[$i]["empleadoEstatusId"]; 
        if($estatusEmp == "1"){
            $datos[$i]["empleadoEstatusId"]= "<label style='color:green'>ACTIVO</label>";
        }else if($estatusEmp == "0"){
            $datos[$i]["empleadoEstatusId"]= "<label style='color:red'>INACTIVO</label>";
        }else if($estatusEmp == "2"){
            $datos[$i]["empleadoEstatusId"]= "<label style='color:blue'>REINGRESO</label>";
        }
    }
  
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
