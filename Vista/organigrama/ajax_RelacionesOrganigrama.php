<?php
session_start();
require "../conexion.php";
require_once ("../../libs/logger/KLogger.php");
date_default_timezone_set('America/Mexico_City');
$response = array();
$arraytemporal = array();
$arraytemporal1 = array();
$catalogoNiveles = array();
$catalogoRelDepaNiv = array();
$catalogoRelPuestoDepa = array();
$catalogoRelIdDepaAcargo = array();
$catalogoDepaAcargo = array();
$catalogoEmpleados = array();
$catalogoJefe = array();
$catalogoPuestoJefe = array();
$catalogoInfoJefe = array();
$catalogoDepartamentoAcargoJefe = array();
$catalogoDepaCargoGerente = array();
$catalogoHijosDepa = array();
$catalogoEntidadesF = array();
$catalogoEntXReg = array();
$catalogoRegxEnt = array();
$catalogoDescEnt = array();
$response["status"] = "error";
$log = new KLogger ("ajax_RelacionesOrganigrama.log" , KLogger::DEBUG );
$entidadesarray=$_POST['entidadesarrayID'];
$linea=$_POST['linea'];
// $log->LogInfo("Valor de variable _SESSION" . var_export ($_SESSION, true));
// $entidad=$entidadesarray[0];

try {

$rol = $_SESSION["userLog"]["rol"];

if($rol=="Gerente Regional"){

    $usuario = $_SESSION["userLog"]["usuario"];

    $sqlNoGerente = "SELECT entidadEmpleadoUsuario, consecutivoEmpleadoUsuario, categoriaEmpleadoUsuario
                          FROM usuario_empleado
                          WHERE usuario='$usuario'";
    $resNoGerente = mysqli_query($conexion, $sqlNoGerente);
    while(($regNoGerente = mysqli_fetch_array($resNoGerente, MYSQLI_ASSOC))){
           $catalogoNoGerente[] = $regNoGerente;
    }

    $entidadGerente= $catalogoNoGerente[0]["entidadEmpleadoUsuario"];
    $consecutivoGerente= $catalogoNoGerente[0]["consecutivoEmpleadoUsuario"];
    $categoriaGerente= $catalogoNoGerente[0]["categoriaEmpleadoUsuario"];

    $sqlDetalleGerente = "SELECT empleadoIdPuesto,
                                 descripcionPuesto,
                                 rpd.idDepartamento,
                                 descripcionDepartamento,
                                 idNivel,
                                 idRelacionDN,
                                 concat_ws(' ', emp.nombreEmpleado,emp.apellidoPaterno,emp.apellidoMaterno) AS nombreGerente,
                                 ef.nombreEntidadFederativa,
                                 ifnull(contactoGif,'SIN INFORMACIÓN') AS contactoGif,
                                 ifnull(correoGif,'SIN INFORMACIÓN') as correoGif,
                                 fotoEmpleado,
                                 departamentoACargo,
                                 idRegionI
                          FROM empleados emp
                          LEFT JOIN catalogopuestos cp on (cp.idPuesto=emp.empleadoIdPuesto)
                          LEFT JOIN relacionpuestosdepartamentos rpd on (rpd.idPuesto=emp.empleadoIdPuesto)
                          LEFT JOIN catalogo_organigramadepartamentos cd on (cd.idDepartamentoOrg=rpd.idDepartamento)
                          LEFT JOIN relaciondepartamentosniveles rdn on (rdn.idDepartamento=rpd.idDepartamento)
                          LEFT JOIN catalogo_organigramaniveles cn on (cn.idNivelOrg=rdn.idNivel)
                          LEFT JOIN entidadesfederativas ef on (ef.idEntidadFederativa=emp.idEntidadTrabajo)
                          LEFT JOIN index_regiones ir ON (ir.idEntidadI=emp.idEntidadTrabajo)
                          WHERE entidadFederativaId='$entidadGerente'
                          AND empleadoConsecutivoId='$consecutivoGerente'
                          AND empleadoCategoriaId='$categoriaGerente'";

    $resDetalleGerente = mysqli_query($conexion, $sqlDetalleGerente);
    while(($regDetalleGerente = mysqli_fetch_array($resDetalleGerente, MYSQLI_ASSOC))){
           $catalogoDetalleGerente[] = $regDetalleGerente;
    }
    //INFORMACION DEL GERENTE QUE INGRESO A CONSULTAR EL ORGANIGRAMA
    
    $nombreG  = $catalogoDetalleGerente[0]["nombreGerente"];
    $idPuestoG= $catalogoDetalleGerente[0]["empleadoIdPuesto"];
    $puestoG  = $catalogoDetalleGerente[0]["descripcionPuesto"];
    $entidadG = $catalogoDetalleGerente[0]["nombreEntidadFederativa"];
    $idDepaG  = $catalogoDetalleGerente[0]["idDepartamento"];
    $depaG    = $catalogoDetalleGerente[0]["descripcionDepartamento"];
    $idRelacionDN = $catalogoDetalleGerente[0]["idRelacionDN"];
    $contactoG= $catalogoDetalleGerente[0]["contactoGif"];
    $correoG  = $catalogoDetalleGerente[0]["correoGif"];
    $fotoG = $catalogoDetalleGerente[0]["fotoEmpleado"];
    $idNivelgerente1 = $catalogoDetalleGerente[0]["idNivel"];
    $idRegionG = $catalogoDetalleGerente[0]["idRegionI"];
    $departamentoACargo = $catalogoDetalleGerente[0]["departamentoACargo"];//11
    $idNivelgerente = $idNivelgerente1-1;
    $aa=$idNivelgerente1;

    /////////////////////CONSULTA PARA SABER CUANTOS GERENTES REGIONALES SE CREARAN, DEPENDIENDO EL SELECTOR (TODOS Ó ENT,ENT,ENT);
    $sqlEntXReg = "SELECT idEntidadI,nombreEntidadFederativa 
                   FROM index_regiones
                   LEFT JOIN entidadesfederativas ef ON ef.idEntidadFederativa= index_regiones.idEntidadI
                   WHERE idRegionI='$idRegionG'
                   AND idLineaNegI='$linea'";

    if($entidadesarray[0]!='100'){
       for($gg=0; $gg < count($entidadesarray); $gg++) { 

           if($gg==0){
              $sqlEntXReg .= " AND (idEntidadI='$entidadesarray[$gg]'";  
           }else{
              $sqlEntXReg .= " OR idEntidadI='$entidadesarray[$gg]'";  
           }
       }//for gg
       $sqlEntXReg .= ")";
    }else{
        $sqlEntXReg .=" AND idEntidadI!='33'
                       AND idEntidadI!='50'";
    }

    $resEntXReg = mysqli_query($conexion, $sqlEntXReg);
    while(($regEntXReg = mysqli_fetch_array($resEntXReg, MYSQLI_ASSOC))){
           $catalogoEntXReg[] = $regEntXReg;
    }
    

    ///////////// CONSULTAS INFORMACION DE LOS PUESTOS QUE ESTAN ARRIBA DEL GERENTE REGIONAL
    
    $sqlJefe = "SELECT idRelacionDN, rdn.idDepartamento, descripcionDepartamento, idNivel, departamentoACargo 
                              FROM relaciondepartamentosniveles rdn
                              LEFT JOIN relacionpuestosdepartamentos rpd ON (rpd.idDepartamento =rdn.idDepartamento)
                              LEFT JOIN catalogopuestos cp ON (cp.idPuesto=rpd.idPuesto)
                              LEFT JOIN catalogo_organigramadepartamentos cd ON (cd.idDepartamentoOrg=rdn.idDepartamento)
                              WHERE idRelacionDN='$departamentoACargo'";

    $resJefe = mysqli_query($conexion, $sqlJefe);
    while(($regJefe = mysqli_fetch_array($resJefe, MYSQLI_ASSOC))){
           $catalogoJefe[] = $regJefe;
    }
    $departamentoAcargoGerente1 = $catalogoJefe[0]["idDepartamento"];//36
    $idRelaciondepartamentoACargojefe = $catalogoJefe[0]["departamentoACargo"];//relacion 3
    //////////////////////////////////////////////////////////////////////////////////////////////

    ////////////PUESTOS A SU CARGO:////////////////////////////////////////////////////////
    $sqlPuestosAcargo = "SELECT rpd.idPuesto,descripcionPuesto 
                          FROM relaciondepartamentosniveles rdn
                          LEFT JOIN relacionpuestosdepartamentos rpd on (rpd.idDepartamento =rdn.idDepartamento)
                          LEFT JOIN catalogopuestos cp on (cp.idPuesto=rpd.idPuesto)
                          WHERE departamentoACargo='$idRelacionDN'";

    $resPuestosAcargo = mysqli_query($conexion, $sqlPuestosAcargo);
    while(($regPuestosAcargo = mysqli_fetch_array($resPuestosAcargo, MYSQLI_ASSOC))){
           $catalogoPuestosAcargo[] = $regPuestosAcargo;
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////

    $DepaACargoJefeDeJefes = $departamentoACargo;
        $uu=0;
    for($u=$idNivelgerente-1; $u >= 0; $u--){
        $catalogoJefe=[];
        $catalogoPuestoJefe=[];
        $catalogoInfoJefe=[];
        $catalogoDepartamentoAcargoJefe=[];

         ////////////PUESTOS JEFES:////////////////////////////////////////////////////////
        $sqlJefe = "SELECT idRelacionDN, rdn.idDepartamento, descripcionDepartamento, idNivel, departamentoACargo 
                              FROM relaciondepartamentosniveles rdn
                              LEFT JOIN relacionpuestosdepartamentos rpd on (rpd.idDepartamento =rdn.idDepartamento)
                              LEFT JOIN catalogopuestos cp on (cp.idPuesto=rpd.idPuesto)
                              LEFT JOIN catalogo_organigramadepartamentos cd on (cd.idDepartamentoOrg=rdn.idDepartamento)
                              WHERE idRelacionDN='$DepaACargoJefeDeJefes'";

        $resJefe = mysqli_query($conexion, $sqlJefe);
        while(($regJefe = mysqli_fetch_array($resJefe, MYSQLI_ASSOC))){
               $catalogoJefe[] = $regJefe;
        }
        $departamentoAcargoGerente = $catalogoJefe[0]["idDepartamento"];//36, 7
        $descripcionDepartamentojefe = $catalogoJefe[0]["descripcionDepartamento"];//direccion de op,recluta
        $idRelaciondepartamentoACargojefe = $catalogoJefe[0]["departamentoACargo"];//relacion 3,12
        $DepaACargoJefeDeJefes = $idRelaciondepartamentoACargojefe;

        $sqlPuestoJefe = "SELECT rpd.idPuesto,descripcionPuesto 
                      FROM relacionpuestosdepartamentos rpd
                      LEFT JOIN catalogopuestos cp on (cp.idPuesto=rpd.idPuesto)
                      WHERE idDepartamento='$departamentoAcargoGerente'
                      ORDER BY idPuesto";

        $resPuestoJefe = mysqli_query($conexion, $sqlPuestoJefe);
        while(($regPuestoJefe = mysqli_fetch_array($resPuestoJefe, MYSQLI_ASSOC))){
               $catalogoPuestoJefe[] = $regPuestoJefe;
        }

        $puestoJefe = $catalogoPuestoJefe[0]["idPuesto"];//98
        $descripcionPuestoJefe = $catalogoPuestoJefe[0]["descripcionPuesto"];//direccion de op

        $sqlInfoJefe = " SELECT idRelacionDN,
                                concat_ws(' ', emp.nombreEmpleado,emp.apellidoPaterno,emp.apellidoMaterno) AS nombre,
                                ef.nombreEntidadFederativa,
                                ifnull(contactoGif,'SIN INFORMACIÓN') AS contactoGif,
                                ifnull(correoGif,'SIN INFORMACIÓN') as correoGif,
                                fotoEmpleado,
                                departamentoACargo,
                                idEntidadTrabajo,
                                concat_ws('-',emp.entidadFederativaId, emp.empleadoConsecutivoId,emp.empleadoCategoriaId) as noEmpJefe,
                                ef.idEntidadFederativa
                     FROM empleados emp
                     LEFT JOIN catalogopuestos cp on (cp.idPuesto=emp.empleadoIdPuesto)
                     LEFT JOIN relacionpuestosdepartamentos rpd on (rpd.idPuesto=emp.empleadoIdPuesto)
                     LEFT JOIN catalogo_organigramadepartamentos cd on (cd.idDepartamentoOrg=rpd.idDepartamento)
                     LEFT JOIN relaciondepartamentosniveles rdn on (rdn.idDepartamento=rpd.idDepartamento)
                     LEFT JOIN catalogo_organigramaniveles cn on (cn.idNivelOrg=rdn.idNivel)
                     LEFT JOIN entidadesfederativas ef on (ef.idEntidadFederativa=emp.idEntidadTrabajo)
                     WHERE empleadoIdPuesto='$puestoJefe'";

        $resInfoJefe = mysqli_query($conexion, $sqlInfoJefe);
        while(($regInfoJefe = mysqli_fetch_array($resInfoJefe, MYSQLI_ASSOC))){
               $catalogoInfoJefe[] = $regInfoJefe;//LLEGA VACIO
        }

        if($idRelaciondepartamentoACargojefe!='0'){
           $sqlDepartamentoAcargoJefe = "SELECT  idDepartamento as depaAcargoJefe
                                         FROM relaciondepartamentosniveles rdn
                                         LEFT JOIN catalogo_organigramadepartamentos cd ON (cd.idDepartamentoOrg=rdn.idDepartamento)
                                         WHERE idRelacionDN='$idRelaciondepartamentoACargojefe'";

           $resDepartamentoAcargoJefe = mysqli_query($conexion, $sqlDepartamentoAcargoJefe);
           while(($regDepartamentoAcargoJefe = mysqli_fetch_array($resDepartamentoAcargoJefe, MYSQLI_ASSOC))){
                  $catalogoDepartamentoAcargoJefe[] = $regDepartamentoAcargoJefe;
           }
           $depaAcargoJefe =  $catalogoDepartamentoAcargoJefe[0]["depaAcargoJefe"];
        }else{
            $depaAcargoJefe='0';
        }
        
        //JEFES CUANDO TRAEN INFO Y CUANDO NO
        if(count($catalogoInfoJefe) === 0){
           $arraytemporal[$uu]["idDepa"]  = $departamentoAcargoGerente;
           $arraytemporal[$uu]["departamentoAcargo"] = $depaAcargoJefe;
           $arraytemporal[$uu]["Nombre"]="SIN INFORMACION";
           $arraytemporal[$uu]["puesto"]=$descripcionPuestoJefe;
           $arraytemporal[$uu]["idPuesto"]=$puestoJefe;
           $arraytemporal[$uu]["entidad"]="SIN_INFORMACION";
           $arraytemporal[$uu]["nombreEntidad"]="SIN_INFORMACION";
           $arraytemporal[$uu]["tel"]="SIN INFORMACION";
           $arraytemporal[$uu]["email"]="SIN INFORMACION";
           $arraytemporal[$uu]["ImgUrl"]= "img/persona.png";
           $arraytemporal[$uu]["empleadoNum"]="SIN_INFORMACION";
           $uu=$uu+1;
        }else{
             $nombre      = $catalogoInfoJefe[0]["nombre"];
             $entidadJefe = $catalogoInfoJefe[0]["idEntidadTrabajo"];
             $nombreEntidadFederativaJefe= $catalogoInfoJefe[0]["nombreEntidadFederativa"];
             $idEntidadFederativaJefe    = $catalogoInfoJefe[0]["idEntidadFederativa"];
             $contactoGif = $catalogoInfoJefe[0]["contactoGif"];
             $correoGif   = $catalogoInfoJefe[0]["correoGif"];
             $fotoEmpleado= $catalogoInfoJefe[0]["fotoEmpleado"];
             $noEmpJefe   = $catalogoInfoJefe[0]["noEmpJefe"];

             $arraytemporal[$uu]["idDepa"]= $departamentoAcargoGerente;
             $arraytemporal[$uu]["empleadoNum"] = $noEmpJefe;
             $arraytemporal[$uu]["departamentoAcargo"] = $depaAcargoJefe;
             $arraytemporal[$uu]["Nombre"] = $nombre;
             $arraytemporal[$uu]["puesto"] = $descripcionPuestoJefe;
             $arraytemporal[$uu]["idPuesto"] = $puestoJefe;
             $arraytemporal[$uu]["entidad"]= $idEntidadFederativaJefe;
             $arraytemporal[$uu]["nombreEntidad"]= $nombreEntidadFederativaJefe;
             $arraytemporal[$uu]["tel"]   = $contactoGif;
             $arraytemporal[$uu]["email"] = $correoGif;

             $rutaImagenJ = "../uploads/fotosempleados/" . $fotoEmpleado;
             
             if(file_exists ($rutaImagenJ)){
                $fotoEmpleado = "uploads/fotosempleados/".$fotoEmpleado;
             }else if(!file_exists ($rutaImagenJ)){
                 $rutaImagenJ2 = "../thumbs/". $fotoEmpleado;
                 if(file_exists ($rutaImagenJ2)){
                     $fotoEmpleado = "thumbs/".$fotoEmpleado;
                 }else if(!file_exists ($rutaImagenJ2)){
                     $fotoEmpleado = "img/persona.png";
                 }
             }
             $arraytemporal[$uu]["ImgUrl"]= $fotoEmpleado;
             $uu=$uu+1;
        }
    }//for u
    //////////////ORGANIZACION DEL ARRAY
    $tt=0;
    $yy = count($arraytemporal);
    for ($t=$yy-1; $t >= 0; $t--) { 
           
        $arraytemporal1[$t]["idDepa"]  = $arraytemporal[$tt]["idDepa"];
        $arraytemporal1[$t]["empleadoNum"]=$arraytemporal[$tt]["empleadoNum"];
        $arraytemporal1[$t]["departamentoAcargo"] = $arraytemporal[$tt]["departamentoAcargo"];
        $arraytemporal1[$t]["Nombre"]=$arraytemporal[$tt]["Nombre"];
        $arraytemporal1[$t]["puesto"]=$arraytemporal[$tt]["puesto"];
        $arraytemporal1[$t]["idPuesto"]=$arraytemporal[$tt]["idPuesto"];
        $arraytemporal1[$t]["entidad"]=$arraytemporal[$tt]["entidad"];
        $arraytemporal1[$t]["nombreEntidad"]=$arraytemporal[$tt]["nombreEntidad"];
        $arraytemporal1[$t]["tel"]=$arraytemporal[$tt]["tel"];
        $arraytemporal1[$t]["email"]=$arraytemporal[$tt]["email"];
        $arraytemporal1[$t]["ImgUrl"]=$arraytemporal[$tt]["ImgUrl"];
        $tt=$tt+1;
    }

    for ($s=0; $s <count($arraytemporal1) ; $s++){
        $response["datos"][$s]["idDepa"] = $arraytemporal1[$s]["idDepa"];
        $response["datos"][$s]["empleadoNum"] = $arraytemporal1[$s]["empleadoNum"];
        $response["datos"][$s]["departamentoAcargo"] = $arraytemporal1[$s]["departamentoAcargo"];
        $response["datos"][$s]["Nombre"] = $arraytemporal1[$s]["Nombre"];
        $response["datos"][$s]["puesto"] = $arraytemporal1[$s]["puesto"];
        $response["datos"][$s]["idPuesto"] = $arraytemporal1[$s]["idPuesto"];
        $response["datos"][$s]["entidad"] = $arraytemporal1[$s]["entidad"];
        $response["datos"][$s]["nombreEntidad"] = $arraytemporal1[$s]["nombreEntidad"];
        $response["datos"][$s]["tel"] = $arraytemporal1[$s]["tel"];
        $response["datos"][$s]["email"] = $arraytemporal1[$s]["email"];
        $response["datos"][$s]["ImgUrl"] = $arraytemporal1[$s]["ImgUrl"];
    }
//GERENTE

    for ($ff=0; $ff <count($catalogoEntXReg) ; $ff++) { 
        $rutaImagen="";
        $response["datos"][$idNivelgerente]["idDepa"]= $idDepaG;
        $response["datos"][$idNivelgerente]["empleadoNum"] = $entidadGerente."-".$consecutivoGerente."-".$categoriaGerente;
        $response["datos"][$idNivelgerente]["departamentoAcargo"] = $departamentoAcargoGerente1;
        $response["datos"][$idNivelgerente]["Nombre"] = $nombreG;
        $response["datos"][$idNivelgerente]["puesto"] = $puestoG;
        $response["datos"][$idNivelgerente]["idPuesto"] = $idPuestoG;
        $response["datos"][$idNivelgerente]["entidad"]= $catalogoEntXReg[$ff]["idEntidadI"];
        $response["datos"][$idNivelgerente]["nombreEntidad"] = $catalogoEntXReg[$ff]["nombreEntidadFederativa"];
        $response["datos"][$idNivelgerente]["tel"] = $contactoG;

        $response["datos"][$idNivelgerente]["email"] = $correoG;
        $rutaImagen = "../uploads/fotosempleados/" . $fotoG;    
                 
        if(file_exists ($rutaImagen)){
           $fotoEncontradaG = "uploads/fotosempleados/".$fotoG;
        }else if(!file_exists ($rutaImagen)){
            $rutaImagen2 = "../thumbs/". $fotoG;
            if(file_exists ($rutaImagen2)){
                $fotoEncontradaG = "thumbs/".$fotoG;
            }else if(!file_exists ($rutaImagen2)){
                $fotoEncontradaG = "img/persona.png";
            }
        }
    
        $response["datos"][$idNivelgerente]["ImgUrl"]= $fotoEncontradaG;
        $idNivelgerente=$idNivelgerente+1;

    }
    $aa=$idNivelgerente;
////////////////////////////////

    for($z=0; $z < count($catalogoPuestosAcargo); $z++){

        $catalogoEmpleados=[];
        $idPuestoAcargo= $catalogoPuestosAcargo[$z]["idPuesto"];
        $descripcionPuestoAcargo = $catalogoPuestosAcargo[$z]["descripcionPuesto"];

        $sqlEmpleados = "SELECT concat_ws(' ',nombreEmpleado,apellidoPaterno,apellidoMaterno) nombreEmp,
                                empleadoIdPuesto,
                                descripcionPuesto,
                                ef.nombreEntidadFederativa,
                                idEntidadTrabajo,
                                ifnull(contactoGif,'SIN INFORMACIÓN') AS contactoGif,
                                ifnull(correoGif,'SIN INFORMACIÓN') as correoGif,
                                fotoEmpleado,
                                idDepartamento,
                                concat_ws('-',empleados.entidadFederativaId, empleados.empleadoConsecutivoId,empleados.empleadoCategoriaId) as empleadoNum 
                        FROM empleados
                        LEFT JOIN catalogopuestos ON (empleados.empleadoIdPuesto=catalogopuestos.idPuesto)
                        LEFT JOIN entidadesfederativas ef ON (ef.idEntidadFederativa=empleados.idEntidadTrabajo)
                        LEFT JOIN relacionpuestosdepartamentos RD ON (RD.idPuesto=empleados.empleadoIdPuesto)
                        WHERE (empleadoEstatusId='1' OR empleadoEstatusId='2')
                        AND empleadoLineaNegocioId='$linea'";

        for($y=0; $y < count($entidadesarray); $y++){
            if($y==0){
               $sqlEmpleados .= " AND (idEntidadTrabajo='$entidadesarray[$y]'";  
            }else{
               $sqlEmpleados .= " OR idEntidadTrabajo='$entidadesarray[$y]'";  
            }
        }//for y
        $sqlEmpleados .= " ) AND empleadoIdPuesto='$idPuestoAcargo'";

        $resEmpleados = mysqli_query($conexion, $sqlEmpleados);
        while(($regEmpleados = mysqli_fetch_array($resEmpleados, MYSQLI_ASSOC))){
               $catalogoEmpleados[] = $regEmpleados;
        }
        
        for($x=0; $x < count($catalogoEmpleados); $x++) { 
            $iteracion = $aa;
            $response["datos"][$iteracion]["idDepa"]= $catalogoEmpleados[$x]["idDepartamento"];
            $response["datos"][$iteracion]["empleadoNum"]= $catalogoEmpleados[$x]["empleadoNum"];
            $response["datos"][$iteracion]["departamentoAcargo"] = $idDepaG;
            $response["datos"][$iteracion]["Nombre"] = $catalogoEmpleados[$x]["nombreEmp"];
            $response["datos"][$iteracion]["puesto"] = $catalogoEmpleados[$x]["descripcionPuesto"];
            $response["datos"][$iteracion]["idPuesto"] = $catalogoEmpleados[$x]["empleadoIdPuesto"];
            $response["datos"][$iteracion]["entidad"]= $catalogoEmpleados[$x]["idEntidadTrabajo"];
            $response["datos"][$iteracion]["nombreEntidad"]= $catalogoEmpleados[$x]["nombreEntidadFederativa"];
            $response["datos"][$iteracion]["tel"]    = $catalogoEmpleados[$x]["contactoGif"];
            $response["datos"][$iteracion]["email"]  = $catalogoEmpleados[$x]["correoGif"];

            $fotoEmp= $catalogoEmpleados[$x]["fotoEmpleado"];

            $rutaImagenEmp = "../uploads/fotosempleados/" . $fotoEmp;
             
            if(file_exists ($rutaImagenEmp)){
               $fotoEmp = "uploads/fotosempleados/".$fotoEmp;
            }else if(!file_exists ($rutaImagenEmp)){
                $rutaImagenEmp2 = "../thumbs/". $fotoEmp;
                if(file_exists ($rutaImagenEmp2)){
                    $fotoEmp = "thumbs/".$fotoEmp;
                }else if(!file_exists ($rutaImagenEmp2)){
                    $fotoEmp = "img/persona.png";
                }
            }
            $response["datos"][$iteracion]["ImgUrl"] = $fotoEmp;
            $aa = $aa+1;
        }//for x
    }//for z
    $response["status"] = "success";
}

//DIRECCION GENERAL
else{
    $aa=0;
    // OBTENER NIVELES
    $sqlNiveles = " SELECT * 
                    FROM catalogo_organigramaniveles
                    ORDER BY idNivelOrg";

    $resNiveles = mysqli_query($conexion, $sqlNiveles);
    while(($regNiveles = mysqli_fetch_array($resNiveles, MYSQLI_ASSOC))){
           $catalogoNiveles[] = $regNiveles;
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    

    for($i=0; $i < count($catalogoNiveles); $i++){ 

        $catalogoRelDepaNiv=[];
        $idNivel= $catalogoNiveles[$i]["idNivelOrg"];

        // OBTENER DEPARTAMENTOS DEL NIVEL
        $sqlRelDepaNiv = "SELECT * 
                          FROM relaciondepartamentosniveles
                          WHERE idNivel='$idNivel'";

        $resRelDepaNiv = mysqli_query($conexion, $sqlRelDepaNiv);
        while(($regRelDepaNiv = mysqli_fetch_array($resRelDepaNiv, MYSQLI_ASSOC))){
               $catalogoRelDepaNiv[] = $regRelDepaNiv;
        }
        /////////////////////////////////////////////////////////////////////////////////////////////////////////

        for($j=0; $j < count($catalogoRelDepaNiv); $j++){//FOR DEPARTAMENTOS

            $catalogoRelIdDepaAcargo=[];
            $catalogoDepaAcargo=[];
            $catalogoRelPuestoDepa=[];
            $idDepa = $catalogoRelDepaNiv[$j]["idDepartamento"];
            $idRelacionParaHijos= $catalogoRelDepaNiv[$j]["idRelacionDN"];//idRelacion donde esta el departamento

            // OBTENER ID RELACION DEL DEPARTAMENTO PARA SABER QUIEN ES SU DEPARTAMENTO A CARGO
            $sqlRelIdDepaAcargo = "SELECT departamentoACargo AS idRelacionDepACargo 
                                   FROM relaciondepartamentosniveles
                                   WHERE idDepartamento='$idDepa'";

            $resRelIdDepaAcargo = mysqli_query($conexion, $sqlRelIdDepaAcargo);
            while(($regRelIdDepaAcargo = mysqli_fetch_array($resRelIdDepaAcargo, MYSQLI_ASSOC))){
                   $catalogoRelIdDepaAcargo[] = $regRelIdDepaAcargo;
            }
            ////////////////////////////////////////////////////////////////////////////////////////////////////

            // OBTENEMOS EL DEPARTAMENTO A CARGO
            $idRelacion = $catalogoRelIdDepaAcargo[0]["idRelacionDepACargo"];//RELACION DE DEPARTAMENTO A CARGO

            $sqlDepaAcargo = "SELECT idDepartamento as depaAcargo
                                  FROM relaciondepartamentosniveles
                                  WHERE idRelacionDN='$idRelacion'";
            $resDepaAcargo = mysqli_query($conexion, $sqlDepaAcargo);
            while(($regDepaAcargo = mysqli_fetch_array($resDepaAcargo, MYSQLI_ASSOC))){
                   $catalogoDepaAcargo[] = $regDepaAcargo;
            }
            ///////////////////////////////////////////////////////////////////////////////////////////////

            // OBTENEMOS LOS PUESTOS QUE TIENE A CARGO EL DEPARTAMENTO
            $sqlRelPuestoDepa = "SELECT *
                                 FROM relacionpuestosdepartamentos
                                 LEFT JOIN catalogopuestos ON (relacionpuestosdepartamentos.idPuesto=catalogopuestos.idPuesto)
                                 WHERE idDepartamento='$idDepa'";

            $resRelPuestoDepa = mysqli_query($conexion, $sqlRelPuestoDepa);
            while(($regRelPuestoDepa = mysqli_fetch_array($resRelPuestoDepa, MYSQLI_ASSOC))){
                    $catalogoRelPuestoDepa[] = $regRelPuestoDepa;
            }
            ///////////////////////////////////////////////////////////////////////////////////////////////

            for($k=0; $k < count($catalogoRelPuestoDepa); $k++){ //FOR PUESTOS DEL DEPARTAMENTO
                $catalogoEmpleados=[];
                $catalogoHijosDepa=[];
                $idPuesto    = $catalogoRelPuestoDepa[$k]["idPuesto"];
                $idPuestodesc= $catalogoRelPuestoDepa[$k]["descripcionPuesto"];

                if($idPuesto=='42'){//SI ES GERENTE REGIONAL


                    for ($kkk=0; $kkk < count($entidadesarray); $kkk++){// TRAE LAS ENTIDADES SELECCIONADAS O TODAS

                        $catalogoRegxEnt=[];
                        $entidadConsult=$entidadesarray[$kkk];

                        //OBTENER LAS REGIONES POR LAS ENTIDADES SOLICITADAS
                        $sqlRegxEnt = "SELECT idRegionI
                                       FROM index_regiones
                                       WHERE idLineaNegI='$linea'
                                       AND idEntidadI='$entidadConsult'";
 
                        $resRegxEnt = mysqli_query($conexion, $sqlRegxEnt);
                        while(($regRegxEnt = mysqli_fetch_array($resRegxEnt, MYSQLI_ASSOC))){
                               $catalogoRegxEnt[] = $regRegxEnt;
                        }

                    $log->LogInfo("Valor de variable catalogoRegxEnt" . var_export ($catalogoRegxEnt, true));
                    // $log->LogInfo("Valor de variable sqlRegxEnt" . var_export ($sqlRegxEnt, true));
                        $idRegionXEnt =$catalogoRegxEnt[0]["idRegionI"];

                        /////CONSULTA PARA OBTENER LA DESCRIPCION DE LA ENTIDAD

                        $sqlEmpleados = "SELECT DISTINCT '$entidadConsult' as entidadConsultada,
                                         concat_ws(' ',nombreEmpleado,apellidoPaterno,apellidoMaterno) nombreEmp,
                                         empleadoIdPuesto,
                                         descripcionPuesto,
                                         ef.nombreEntidadFederativa,
                                         ifnull(contactoGif,'SIN INFORMACIÓN') AS contactoGif,
                                         ifnull(correoGif,'SIN INFORMACIÓN') as correoGif,
                                         fotoEmpleado,
                                         concat_ws('-',empleados.entidadFederativaId, empleados.empleadoConsecutivoId,empleados.empleadoCategoriaId) as empleadoNum,
                                         idRegionI,
                                         idEntidadTrabajo,
                                         efe.nombreEntidadFederativa as entidad2
                                     FROM empleados
                                     LEFT JOIN catalogopuestos ON (empleados.empleadoIdPuesto=catalogopuestos.idPuesto)
                                     LEFT JOIN entidadesfederativas ef ON (ef.idEntidadFederativa=empleados.idEntidadTrabajo)
                                     LEFT JOIN entidadesfederativas efe ON (efe.idEntidadFederativa='$entidadConsult')
                                     LEFT JOIN index_regiones ir ON (ir.idEntidadI=empleados.idEntidadTrabajo AND empleados.empleadoLineaNegocioId='$linea')
                                     WHERE (empleadoEstatusId='1' OR empleadoEstatusId='2')
                                     AND empleadoLineaNegocioId='$linea'
                                     AND empleadoIdPuesto='$idPuesto'
                                     AND idRegionI='$idRegionXEnt'";

                        $resEmpleados = mysqli_query($conexion, $sqlEmpleados);
                        while(($regEmpleados = mysqli_fetch_array($resEmpleados, MYSQLI_ASSOC))){
                               $catalogoEmpleados[] = $regEmpleados;
                        }
                    }
                    // $log->LogInfo("Valor de variable sqlEmpleados" . var_export ($sqlEmpleados, true));
                    // $log->LogInfo("Valor de variable catalogoEmpleados" . var_export ($catalogoEmpleados, true));
                }else{//si el puesto no es regional

                $sqlEmpleados = "SELECT DISTINCT concat_ws(' ',nombreEmpleado,apellidoPaterno,apellidoMaterno) nombreEmp,
                                     empleadoIdPuesto,
                                     descripcionPuesto,
                                     ef.nombreEntidadFederativa,
                                     ifnull(contactoGif,'SIN INFORMACIÓN') AS contactoGif,
                                     ifnull(correoGif,'SIN INFORMACIÓN') as correoGif,
                                     fotoEmpleado,
                                     concat_ws('-',empleados.entidadFederativaId, empleados.empleadoConsecutivoId,empleados.empleadoCategoriaId) as empleadoNum,
                                     idRegionI,
                                     idEntidadTrabajo
                                 FROM empleados
                                 LEFT JOIN catalogopuestos ON (empleados.empleadoIdPuesto=catalogopuestos.idPuesto)
                                 LEFT JOIN entidadesfederativas ef ON (ef.idEntidadFederativa=empleados.idEntidadTrabajo)
                                 LEFT JOIN index_regiones ir ON (ir.idEntidadI=empleados.idEntidadTrabajo AND empleados.empleadoLineaNegocioId='$linea')
                                 WHERE (empleadoEstatusId='1' OR empleadoEstatusId='2')
                                 AND empleadoLineaNegocioId='$linea'";

                    for ($m=0; $m < count($entidadesarray); $m++){
                        if($m==0){
                            $sqlEmpleados .= " AND (idEntidadTrabajo='$entidadesarray[$m]'";  
                         }else{
                            $sqlEmpleados .= " OR idEntidadTrabajo='$entidadesarray[$m]'";  
                         }
                    }//for m

                    $sqlEmpleados .= " ) AND empleadoIdPuesto='$idPuesto'";

                    $resEmpleados = mysqli_query($conexion, $sqlEmpleados);
                    while(($regEmpleados = mysqli_fetch_array($resEmpleados, MYSQLI_ASSOC))){
                           $catalogoEmpleados[] = $regEmpleados;
                    }
                }//termina else si no es regional el puesto

                if(count($catalogoEmpleados)=== 0){ // PRESIDENCIA, VICEPRESIDENCIA, DIRECTOR GENERAL,DIRECTOR DE OPERACIONES

                    $sqlHijosDepa = "SELECT ifnull(SUM(departamentoACargo),0) AS hijos
                                     FROM relaciondepartamentosniveles
                                     WHERE departamentoACargo=$idRelacionParaHijos";

                    $resHijosDepa = mysqli_query($conexion, $sqlHijosDepa);
                    while(($regHijosDepa = mysqli_fetch_array($resHijosDepa, MYSQLI_ASSOC))){
                            $catalogoHijosDepa[] = $regHijosDepa;
                    }

                    $hijos= $catalogoHijosDepa[0]["hijos"];

                    if($hijos!=0){// SI TIENE HIJOS DEBE LLENAR EL NODO, SI NO , NO HACER NADA
                       $iteracion = $aa;
                       $response["datos"][$iteracion]["idDepa"] = $idDepa;
                       $response["datos"][$iteracion]["empleadoNum"] = "SIN_INFORMACION";

                       if(count($catalogoDepaAcargo) === 0){//SOLO PARA PRESIDENTE QUE NO TIENE NADIE A CARGO
                           $response["datos"][$iteracion]["departamentoAcargo"] = 0;
                       }else{
                           $response["datos"][$iteracion]["departamentoAcargo"] = $catalogoDepaAcargo[0]["depaAcargo"];
                       }

                       $response["datos"][$iteracion]["Nombre"]  = "SIN_INFORMACION";
                       $response["datos"][$iteracion]["puesto"]  = $idPuestodesc;
                       $response["datos"][$iteracion]["idPuesto"]= $idPuesto;
                       $response["datos"][$iteracion]["entidad"] = "SIN INFORMACION";
                       $response["datos"][$iteracion]["nombreEntidad"] = "SIN INFORMACION";
                       $response["datos"][$iteracion]["tel"]     = "SIN INFORMACION";
                       $response["datos"][$iteracion]["email"]   = "SIN INFORMACION";
                       $response["datos"][$iteracion]["ImgUrl"]  = "img/persona.png";
                       // $response["datos"][$iteracion]["idRegion"]= "SIN_INFORMACION";
                       // response["datos"][$iteracion]["nivel"]  = $idNivel;
                       $aa =$aa+1;
                    }
                }else{//SI SI SE OBTUVIERON EMPLEADOS
                    for($o=0; $o < count($catalogoEmpleados); $o++){ 
                        // $response["datos"][$iteracion]["nivel"]  = $idNivel;
                        $iteracion = $aa;
                        $response["datos"][$iteracion]["idDepa"]     = $idDepa;
                        $response["datos"][$iteracion]["empleadoNum"]= $catalogoEmpleados[$o]["empleadoNum"];

                        if(count($catalogoDepaAcargo) === 0){//SOLO PARA PRESIDENTE QUE NO TIENE NADIE A CARGO
                            $response["datos"][$iteracion]["departamentoAcargo"] = 0;
                        }else{
                            $response["datos"][$iteracion]["departamentoAcargo"] =$catalogoDepaAcargo[0]["depaAcargo"];
                        }

                        $response["datos"][$iteracion]["Nombre"]  = $catalogoEmpleados[$o]["nombreEmp"];
                        $response["datos"][$iteracion]["puesto"]  = $catalogoEmpleados[$o]["descripcionPuesto"];
                        $response["datos"][$iteracion]["idPuesto"]= $idPuesto;

                        if($idPuesto=='42' ){

                           $response["datos"][$iteracion]["entidad"]     = $catalogoEmpleados[$o]["entidadConsultada"];
                           $response["datos"][$iteracion]["nombreEntidad"]= $catalogoEmpleados[$o]["entidad2"];
                        }else{
                           $response["datos"][$iteracion]["entidad"]      = $catalogoEmpleados[$o]["idEntidadTrabajo"];
                           $response["datos"][$iteracion]["nombreEntidad"]= $catalogoEmpleados[$o]["nombreEntidadFederativa"];
                        }

                        $response["datos"][$iteracion]["tel"]  = $catalogoEmpleados[$o]["contactoGif"];
                        $response["datos"][$iteracion]["email"]= $catalogoEmpleados[$o]["correoGif"];

                        $imgEmp = $catalogoEmpleados[$o]["fotoEmpleado"];
                        $rutaImagenEmp = "../uploads/fotosempleados/" . $imgEmp;
             
                        if(file_exists ($rutaImagenEmp)){
                           $imgEmp = "uploads/fotosempleados/".$imgEmp;
                        }else if(!file_exists ($rutaImagenEmp)){
                            $rutaimgEmp2 = "../thumbs/". $imgEmp;
                            if(file_exists ($rutaimgEmp2)){
                                $imgEmp = "thumbs/".$imgEmp;
                            }else if(!file_exists ($rutaimgEmp2)){
                                $imgEmp = "img/persona.png";
                            }
                        }
                        $response["datos"][$iteracion]["ImgUrl"] = $imgEmp;
                        $aa = $aa+1;
                    }//for o
                }//ELSE
            }//for k
        }//for j
    }//for i
    $response["status"] = "success";
}//else del rol
     $log->LogInfo("Valor de variable response" . var_export ($response, true));
}catch(Exception $e){
       $response["message"] = "Error al iniciar sesion";
}
echo json_encode($response);