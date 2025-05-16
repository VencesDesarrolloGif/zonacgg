<?php

	include ("conexion.php");

	$query = "select a.idPuesto,a.descripcionpuesto,b.descripcionLineaNegocio,c.descripcionCategoria
	from  catalogopuestos a
	inner join  catalogolineanegocio b on a.puestoLineaNegocioId=b.idLineaNegocio
	inner join catalogocategoriastipopuestos c on a.puestoIdCategoria=c.idCategoria; ";
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

	