

<?php
//require_once ("../Negocio/Negocio.class.php");
$negocio = new Negocio ();
$listaInvitados = $negocio ->  negocio_obtenerListaDeVisitantesDelDia();
echo "<legend>Libro de Visitas</legend>";
echo "<div class='tab-pane'>";
echo "<table class='table table-hover'><thead><th>Apellido Paterno</th><th>Apellido Materno</th><th>Nombre</th>
<th>Area Visita</th><th>Asunto</th><th>Hora Entrada</th></thead><tbody>";

	for($i=0; $i<count($listaInvitados); $i++)                                          
	{

		echo "<tr><td>". $listaInvitados[$i]['visitanteApPaterno']." </td> <td>".$listaInvitados[$i]['visitanteApMaterno']."</td><td>".$listaInvitados[$i]['visitanteNombre']."</td><td>".$listaInvitados[$i]['nombreDepto'].
		"</td><td>".$listaInvitados[$i]['descripcionAsunto']."</td><td>".$listaInvitados[$i]['horarioEntrada']."</td><td><button id='btnregistrarSalida' name='guardar' class='btn btn-warning' type='button' >Registrar Salida</button></</td><tr>";
	}

echo "</tbody></table>";
echo "<div>";
?>