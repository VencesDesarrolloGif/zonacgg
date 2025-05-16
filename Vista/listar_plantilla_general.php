<?php

	include ("conexion.php");

	$query = "select
                cps.idPuntoServicio
                , cps.puntoServicio
                , cps.idEntidadPunto
                , ef.nombreEntidadFederativa
                ,cps.numeroCentroCosto
                ,cps.latitudPunto
                ,cps.longitudPunto
                , cps.idClientePunto
                , ifnull(c1.elementosContratados,0) elementosContratados
                , ifnull(c2.elementosSolicitados,0 ) elementosSolicitados
                ,cc.razonsocial
                ,cc.direccionFiscalCliente
                , ifnull(c3.elementosAsignados,0) elementosAsignados 
                 ,ifnull((elementosContratados-elementosSolicitados),CONCAT('-' ,elementosSolicitados)) as diferencia
                 ,ir.DescripcionI,cln.descripcionLineaNegocio
                 ,if(cps.EntidadPuntoS is null ,cps.direccionPuntoServicio,concat_ws(' ',cps.CallePrincipaPuntoS ,cps.NumeroExteriorPuntoS,',' ,ca.nombreAsentamiento ,',' 
                 ,cps.CodigoPostalPuntoS ,cm.nombreMunicipio ,',' ,efe.nombreEntidadFederativa)) as direccionPuntoServicio
                from catalogopuntosservicios cps
                left join catalogolineanegocio cln on cps.idLineaNegocioPunto=cln.idLineaNegocio
                left join catalogoclientes cc on (cps.idClientePunto=cc.idCliente)
                left join entidadesfederativas ef on (ef.idEntidadFederativa=cps.idEntidadPunto)
                left join index_regiones ir on(cps.idIncrementRegionPuntoServ=ir.idIncrementI)
                left join entidadesfederativas efe ON (cps.EntidadPuntoS = efe.idEntidadFederativa)
                left join catalogomunicipios cm ON (cps.MunicipioPuntoS =cm.idMunicipio)
                left join asentamientos ca ON (cps.ColoniaPuntoS =ca.idAsentamiento)
                left join (
                -- consulta elementos contratados en el punto de servicio
                select count(e.empleadoNumeroSeguroSocial) as elementosContratados, e.empleadoIdPuntoServicio,cps.idPuntoServicio, cps.puntoservicio, cc.razonSocial
                from empleados e
                left join catalogopuntosservicios cps on (cps.idPuntoServicio=e.empleadoIdPuntoServicio)
                left join catalogoclientes cc on (cps.idClientePunto=cc.idCliente)
                where (e.empleadoEstatusId= 2 or e.empleadoEstatusId=1) and e.idTipoPuesto='03'  
                group by cps.puntoservicio
                ) c1 on (c1.idPuntoServicio=cps.idPuntoServicio)
                left join (
                -- consulta elementos soliitados en requisiciones por ventas
                select 
                sp.servicioPlantillaId
                , sp.puntoServicioPlantillaId
                , sp.numeroElementos
                , sum(numeroElementos) as elementosSolicitados
                from servicios_plantillas sp 
                where sp.estatusPlantilla='1'
                group by puntoServicioPlantillaId
                ) c2 on puntoServicioPlantillaId=cps.idPuntoServicio
                left join (
                select p.plantillaId
                , p.requisicionId
                , p.empleadoEntidadPlantilla
                , p.empleadoConsecutivoPlantilla
                , p.empleadoCategoriaPlantilla
                , sp.puntoServicioPlantillaId
                , cps.puntoServicio
                , cps.idPuntoServicio
                , cc.idCliente
                , cc.razonSocial
                 , count(p.plantillaId) elementosAsignados
                from plantilla p
                left join servicios_plantillas sp on (sp.servicioPlantillaId=p.requisicionId)
                left join catalogopuntosservicios cps on (cps.idPuntoServicio=sp.puntoServicioPlantillaId)
                left join catalogoclientes cc on (cc.idCliente=cps.idClientePunto)
                left join empleados e on (e.entidadFederativaId=p.empleadoEntidadPlantilla and e.empleadoConsecutivoId=p.empleadoConsecutivoPlantilla and e.empleadoCategoriaId=p.empleadoCategoriaPlantilla)
                where (e.empleadoEstatusId=1 or e.empleadoEstatusId=2) and (e.estatusEmpleadoOperaciones=1 or e.estatusEmpleadoOperaciones=4 )
                group by idCliente, sp.puntoServicioPlantillaId
                )c3 on (c3.puntoServicioPlantillaId=cps.idPuntoServicio)
                where cps.esatusPunto=1
               order by cps.puntoServicio asc limit 10000";
	mysqli_set_charset($conexion, "utf8");
	$resultado = mysqli_query($conexion, $query);

	if(!$resultado){
		die("error");

	}else{
		while ($data=mysqli_fetch_assoc($resultado)) {
			$arreglo["data"][]=$data;
		}
		echo json_encode($arreglo);
	}
	mysqli_free_result($resultado);
	mysqli_close($conexion);

	?>

	