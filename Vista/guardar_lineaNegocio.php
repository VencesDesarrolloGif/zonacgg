<?php 
include("conexion.php");
$idproducto=$_POST["idpuesto"];
$lineaN=$_POST["selectLineaNegocio"];
$tipoPuesto=$_POST["tipoPuesto"];
$descripcionPuesto=$_POST["descripcion"];
$opcion=$_POST["opcion"];
$informacion=[];
switch ($opcion) {
	case 'modificar':
	modificar($descripcionPuesto,$idproducto,$conexion);
	
		break;
		case 'eliminar':
			 eliminar($idproducto, $conexion);
			break;
			case 'registrar':
		if($descripcionPuesto != "" && $lineaN != "" && $tipoPuesto != ""){
				$existe = existe_producto($descripcionPuesto, $conexion);
				if ($existe>0) {
					$informacion["respuesta"]="EXISTE";
				}else{
					registrar($descripcionPuesto,$tipoPuesto,$lineaN, $conexion);
				}
								
			}else{
				$informacion["respuesta"] = "VACIO";
				echo json_encode($informacion);
			}
	break;
	

}


function modificar($descripcionPuesto,$idproducto,$conexion){ 
$query= "UPDATE catalogopuestos SET 
							descripcionPuesto='$descripcionPuesto'
 						 WHERE idPuesto=$idproducto";
$resultado = mysqli_query($conexion, $query);
verificar_resultado( $resultado );
cerrar( $conexion );
}

function existe_producto($descripcionPuesto, $conexion){
		$query = "SELECT descripcionPuesto FROM catalogopuestos  WHERE descripcionPuesto = '$descripcionPuesto';";
		$resultado = mysqli_query($conexion, $query);
		$existe_usuario = mysqli_num_rows( $resultado );
		return $existe_producto;
	}

	function registrar($descripcionPuesto,$tipoPuesto,$lineaN,$conexion){
		$query = "INSERT INTO catalogopuestos VALUES(0,'$descripcionPuesto', '$tipoPuesto', '$lineaN');";
		$resultado = mysqli_query($conexion, $query);		
		verificar_resultado($resultado);
		cerrar($conexion);
	}

function eliminar($idproducto, $conexion){
$query = "DELETE  FROM catalogopuestos  WHERE idPuesto= $idproducto";
$resultado = mysqli_query($conexion, $query);
verificar_resultado( $resultado );
cerrar( $conexion );
}

function verificar_resultado($resultado){
	if(!$resultado)
		$informacion["respuesta"]="Error";
	else $informacion["respuesta"]="Bien";
		echo json_encode($informacion);

}
function cerrar($conexion){
	mysqli_close($conexion);
}






 ?>