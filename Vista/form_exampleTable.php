 
<?php

echo ("php");
?>

<div class="container">
<section>

<table id="example3" class="display" cellspacing="0" width="100%">
<thead>
<tr>
<th># Empleado</th>
<th>Nombre</th>
<th>Fecha Ingreso</th>
<th># Imss</th>
<th>Confirmar</th>

</tr>
</thead>

<tbody>
	<?php

	$log = new KLogger ( "vistaImss.log" , KLogger::DEBUG );

	$negocio = new Negocio ();

	$listaEmpleadosSinImss=$negocio -> negocio_obtenerListaEmpleadosPorEstatus(2);
	$numero=count($listaEmpleadosSinImss);

	$log->LogInfo("Valor de listaEmpleadosSinImss en vista (catalogo)" . var_export ($listaEmpleadosSinImss, true));
	$log->LogInfo("Valor de numero count" . var_export ($numero, true));

	for ($i=0 ; $i<count($listaEmpleadosSinImss); $i++){

		$numeroEmpleado=$listaEmpleadosSinImss[$i]['entidadFederativaId']."-".$listaEmpleadosSinImss[$i]['empleadoConsecutivoId']."-".$listaEmpleadosSinImss[$i]['empleadoCategoriaId'];
		$nombreEmpleado=$listaEmpleadosSinImss[$i]['apellidoPaterno']." ".$listaEmpleadosSinImss[$i]['apellidoMaterno']." ".$listaEmpleadosSinImss[$i]['nombreEmpleado'];
		$fi=$listaEmpleadosSinImss[$i]['fechaIngresoEmpleado'];
		$imss=$listaEmpleadosSinImss[$i]['empleadoNumeroSeguroSocial'];



		echo("<tr><td>".$numeroEmpleado."</td><td>".$nombreEmpleado."</td><td>".$fi."</td><td>".$imss."</td><td><img class='cursorImg' src='img/okUser.png'></td></tr>");
	}



	?>



</tbody>


<tfoot>
<tr>
<th># Empleado</th>
<th>Nombre</th>
<th>Fecha Ingreso</th>
<th># Imss</th>
<th>Confirmar</th>
</tr>
</tfoot>
</table>
</div>
</section>

<script type="text/javascript">

var rolUsuario="<?php echo $usuario['rol']; ?>";

$(inicioActSPS());  

function inicioActSPS(){
	$("#example3").dataTable();
	new $.fn.dataTable.KeyTable( $("#example3") );
}
</script>