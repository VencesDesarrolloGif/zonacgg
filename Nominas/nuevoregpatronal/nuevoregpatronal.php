 <?php
include '../menu/menu.php';
?>
<!--FALATA PONER LA SESION PARA QUER EL USUARIO NO ENTRE SI SE SABE LA LIGA-->
<!DOCTYPE html>
<html lang="en">
  <head>
  </head>
  <body>
  	 <div id="errorMsj" name="errorMsj"> </div>
<div id="displaynuevofrmsuc" style="display: block;">
	<div style="border:2px;border-color:black;border-style:solid;width:100%;height:100%;">
		<div class="container" align="center" ><h1>Registro patronal</h1></div><br><br>
			<div class="container top-buffer-submenu vertical-buffer">
				<form id="frmnuevasucursal" name="frmnuevasucursal" role="form" accept-charset="UTF-8" class="clearfix" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-4">
							<label  class="control-label">Empresa:</label>
							<select id="selenuevompresa" name="selenuevompresa" class="form-control" required></select>
						</div>
						<div class="col-md-4">
							<label  class="control-label">Registro Patronal:</label>
							<span class="glyphicon glyphicon-info-sign"  data-toggle="tooltip"  title="'EJEMPLO DE Registro Patronal:' A1234567890 Ó A12-34567-89-0" ></span>
							<input id="inpnuevoregpatronal" name="inpnuevoregpatronal" class="form-control" pattern="^([a-zA-Z]{1}[0-9]{10})||([a-zA-Z]{1}[0-9]{2}[-][0-9]{5}[-][0-9]{2}[-][0-9]{1})*$" required>
						</div>
						<div class="col-md-4">
							<label  class="control-label">Nombre de Sucursal:</label>
							<input id="inpnuevosucursal" name="inpnuevosucursal"   class="form-control" required></select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<label  class="control-label">Actividad Economica:</label>
							<input id="inpnuevoacteconomicasuc" name="inpnuevoacteconomicasuc" class="form-control" required>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<label  class="control-label">Calle,Numero y Colonia:</label>
							<input id="inpnuevocallenumeroycolsuc" name="inpnuevocallenumeroycolsuc" class="form-control" required>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<label  class="control-label">Codigo Postal:</label>
							<input id="inpnuevocodigopostalsuc" name="inpnuevocodigopostalsuc" class="form-control" placeholder="12345" maxlength="5" onblur="consultaentidadydelegacionesimssfrmnuevasucursal();" pattern="^([0-9]{5})*$" required>
						</div>
						<div class="col-md-3"><input id="hdnnuevoentidadsuc" name="hdnnuevoentidadsuc" class="form-control" type="hidden" ></div>
						<div class="col-md-6">
							<label  class="control-label">Entidad:</label>
							<input id="inpnuevoentidadsuc" name="inpnuevoentidadsuc" class="form-control" readonly >
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<label  class="control-label">Poblacion y Municipio/Delegación:</label>
							<select id="inpnuevopoblacionmunicipiosuc" name="inpnuevopoblacionmunicipiosuc" class="form-control" required></select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label  class="control-label">Telefono:</label>
							<input id="inpnuevotelefonosuc" name="inpnuevotelefonosuc" class="form-control" required>
						</div>
						<div class="col-md-4">
							<label  class="control-label">Delegación IMSS:</label>
							<select id="selnuevodelimsssuc" name="selnuevodelimsssuc"   class="form-control" required></select>
						</div>
						<div class="col-md-4">
							<label  class="control-label">Subdelegación IMSS:</label>
							<select id="selnuevosubdelegacionimsssuc" name="selnuevosubdelegacionimsssuc"   class="form-control" required></select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label  class="control-label">Area Geográfica:</label>
							<select id="selnuevoareageosuc" name="selnuevoareageosuc" class="form-control" required></select>
						</div>
						<div class="col-md-4">
							<label  class="control-label">Mes de Inicio del Modulo de Afiliacion:</label>
							<select id="selnuevomesiniciomodafisuc" name="selnuevomesiniciomodafisuc" class="form-control" required></select>
						</div>
						<div class="col-md-4">
							<label  class="control-label">Año de Inicio del Modulo de Afiliacion:</label>
							<select id="selnuevoanioiniciomodafisuc" name="selnuevoanioiniciomodafisuc" class="form-control" required></select>
						</div>
					</div><br>
					<div   align="center" style="color: rgb(166, 33, 24); background: rgb(230,230,230);border-style:double; margin-right: 1%"><h5>Clase - Fracción - Prima de Riesgo de Trabajo</h5></div><br>
					<div class="row">
						<div class="col-md-4">
							<label  class="control-label">Mes:</label>
							<select id="selnuevomesfraccionriesgodetrab" name="selnuevomesfraccionriesgodetrab" class="form-control" required></select>
						</div>
						<div class="col-md-4">
							<label  class="control-label">Año:</label>
							<select id="selnuevoaniofraccionriesgodetrab" name="selnuevoaniofraccionriesgodetrab" class="form-control" required></select>
						</div>
						<div class="col-md-4">
							<label  class="control-label">Prima:</label>
							<input id="inpnuevoprimainiciomodafisuc" name="inpnuevoprimainiciomodafisuc" class="form-control" required>
						</div>
					</div><br>
					<div class="row">
						<div class="col-md-12" id="datos"></div>
					</div>
					<div class="row">
						<div class="col-md-2">
							<label  class="control-label">Clase:</label>
							<select id="selnuevoclaseriegodetrab" name="selnuevoclaseriegodetrab" class="form-control" required></select>
						</div>
						<div class="col-md-10">
							<label  class="control-label">Fracción:</label>
							<select id="selnuevofraccionriegodetrab" name="selnuevofraccionriegodetrab" class="form-control" required></select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-8">
							<label  class="control-label">Nombre del Patrón o Representante Legal:</label>
							<input id="inpnuevonombrepatronoresponsable" name="inpnuevonombrepatronoresponsable" class="form-control" required>
						</div>
					</div>

					<br>
					<div class="clearfix">
				     <!--BOTONES CANCELAR LIMPIAR-->
				    	
					</div>
				</form>

				<h3>ASIGNAR REGISTRO PATRONAL:</h3>
				<h5 style="color: red;">NOTA: RECUERDA QUE SI LA ENTIDAD TENDRÁ MÁS DE UN REGISTRO PATRONAL, LA ASIGNACION DEBE SER POR MUNICIPIO FORZOSAMENTE.</h5>
					<br>

					<div class="row" id="divEntidad">
							<label  class="col-md-1">Entidad:</label>
							<!-- <input id="inpnuevoentidadsuc" name="inpnuevoentidadsuc" class="form-control"> -->
							<select  id="entidadesSucursales" name="entidadesSucursales">
								<option id="0">ENTIDADES</option>
							</select>
							<button  id="btnAgregarEntidad" style="display:none;" onclick="cargaTablaEntidades(1);">AGREGAR</button>
							<br>
							<br>
							<table>
									<td valign="top">
										<div id="divTablaEntidadesAsignadas"></div>
									</td>
									<td valign="top">
										<div id="divTablaMunicipiosAsignados"></div>
									</td>
							</table>

						</div>
						<br>
						<div class="row" align="center">
							<div class="col-md-1">
				  					<label>ASIGNAR POR:</label>
							</div>
							<div class="col-md-1">
										<input type="radio" id="radioEntidad" value="1" disabled><h4>Entidad</h4> 
							</div>
							<div class="col-md-1">
										<input type="radio" id="radioMunicipio" value="2" disabled><h4>Municipio</h4>
							</div>
						</div>
					<br>
						<div class="row" style="display:none" id="divMunicipio">
							<label  class="col-md-1">Municipio:</label>
							<select  id="selectMunicipios">
								<option value="0">SELECCIONAR</option>
							</select>
							<button id="btnAgregarMunicipio" style="display:none;" onclick="cargaTablaMunicipios(1);">AGREGAR</button>
							<br>
							<br>
						</div>

						<div class="pull-right">

							<!-- <input id="btnguardafrmsucursal" name="btnguardafrmsucursal" class="btn btn-primary" type="submit" value="Guardar"> -->
							<input id="btnguardafrmsucursal" name="btnguardafrmsucursal" class="btn btn-primary" value="Guardar">
						</div>
			</div>
	</div>
	<script src="nuevoregpatronal.js"></script>
</body>
</html>
































