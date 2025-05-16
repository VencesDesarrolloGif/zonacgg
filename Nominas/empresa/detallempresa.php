   <?php
include '../menu/menu.php';
?>
<!--FALATA PONER LA SESION PARA QUER EL USUARIO NO ENTRE SI SE SABE LA LIGA-->
<!DOCTYPE html>
<html lang="en">

<body>
  <div id="errorMsj" name="errorMsj"></div>
	<div id="displayfrmempresa" style="display: block;">
	<!-- <form id="frmdetalleempresaysuc"> -->

		<div style="border:2px;border-color:black;border-style:solid;width:100%;height:100%;">
			<div class="container" align="center">
				<h1>Domicilio Fiscal Empresa</h1>
			</div><br><br>

				<div class="container top-buffer-submenu vertical-buffer">
					
					<div class="row">
						<div class="col-md-12">
							<label  class="control-label">Nombre o Razón Social:</label>
							<input id="inprazonsocialempresa" name="inprazonsocialempresa" class="form-control" readonly required>
						</div>
					</div>

					<div class="row">
						<div class="col-md-2">
							<label  class="control-label">Codigo Postal:</label>
							<input id="inpcodigopostal" name="inpcodigopostal" class="form-control"  readonly>
						</div>
						<div class="col-md-6">
							<label  class="control-label">Representante Legal:</label>
							<input id="inprepresentantelegal" name="inprepresentantelegal" class="form-control" readonly >
						</div>
						<div class="col-md-4">
							<label  class="control-label">R.F.C:</label>
							<input id="inprfc" required name="inprfc" class="form-control" readonly >
						</div>
					</div>

					<div class="row">
						<div class="col-md-4">
							<label  class="control-label">Colonia:</label>
							<input id="inpcoloniaempresa" name="inpcoloniaempresa" class="form-control" readonly >
						</div>
						<div class="col-md-4">
							<label  class="control-label">Delegacion/Municipio:</label>
							<input id="inpdelmunempresa" name="inpdelmunempresa" class="form-control" readonly >
						</div>
						<div class="col-md-4">
							<label  class="control-label">Número Telefono:</label>
							<input id="inptelefonoempresa" name="inptelefonoempresa" class="form-control" readonly >
						</div>
					</div>

					<div class="row">
						<div class="col-md-4">
							<label  class="control-label">Calle:</label>
							<input id="inpcalleempresa"  name="inpcalleempresa" class="form-control" readonly >
						</div>
						<div class="col-md-4">
							<label  class="control-label">Numero Interior:</label>
							<input id="inpnuminteriorempresa" name="inpnuminteriorempresa" class="form-control" readonly >
						</div>
						<div class="col-md-4">
							<label  class="control-label">Número exterior:</label>
							<input id="inpnumexteriorempresa" name="inpnumexteriorempresa" class="form-control" readonly >
						</div>
					</div>
				</div>
		</div>

		<div style="border:2px;border-color:black;border-style:solid;width:100%;height:100%;">

			<div class="container" align="center" >
				<h1>Domicilio Sucursal</h1>
			</div><br><br>
			
			<div class="container top-buffer-submenu vertical-buffer">

				<div class="row">
					<div class="col-md-4">
						<label  class="control-label">Empresa:</label>
						<select id="selempresa" name="selempresa" class="form-control" ></select>
					</div>
					<div class="col-md-4">
						<label  class="control-label">Registro Patronal:</label>
						<select id="selregpatronal" name="selregpatronal"   class="form-control" ></select>
					</div>
					<div class="col-md-4">
						<label  class="control-label">Sucursal:</label>
						<select id="selsucursal" name="selsucursal"   class="form-control" ></select>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<label  class="control-label">Actividad Economica:</label>
						<input id="inpacteconomicasuc" name="inpacteconomicasuc" class="form-control" readonly>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<label  class="control-label">Calle,Numero y Colonia:</label>
						<input id="inpcallenumeroycolsuc" name="inpcallenumeroycolsuc" class="form-control" readonly>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label  class="control-label">Codigo Postal:</label>
						<input id="inpcodigopostalsuc" name="inpcodigopostalsuc" class="form-control" readonly>
					</div>
					<div class="col-md-3"></div>
					<div class="col-md-6">
						<label  class="control-label">Entidad:</label>
						<input id="inpentidadsuc" name="inpentidadsuc" class="form-control" readonly>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<label  class="control-label">Poblacion y Municipio/Delegación:</label>
						<select id="inppoblacionmunicipiosuc" name="inppoblacionmunicipiosuc" class="form-control"></select>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<label  class="control-label">Telefono:</label>
						<input id="inptelefonosuc" name="inptelefonosuc" class="form-control" readonly>
					</div>
					<div class="col-md-4">
						<label  class="control-label">Delegación IMSS:</label>
						<select id="seldelimsssuc" name="seldelimsssuc"   class="form-control" ></select>
					</div>
					<div class="col-md-4">
						<label  class="control-label">Subdelegación IMSS:</label>
						<select id="selsubdelegacionimsssuc" name="selsubdelegacionimsssuc"   class="form-control" ></select>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<label  class="control-label">Area Geográfica:</label>
						<select id="selareageosuc" name="selareageosuc" class="form-control" ></select>
					</div>
					<div class="col-md-4">
						<label  class="control-label">Mes de Inicio del Modulo de Afiliacion:</label>
						<select id="selmesiniciomodafisuc" name="selmesiniciomodafisuc" class="form-control" ></select>
					</div>
					<div class="col-md-4">
						<label  class="control-label">Año de Inicio del Modulo de Afiliacion:</label>
						<select id="selanioiniciomodafisuc" name="selanioiniciomodafisuc" class="form-control" ></select>
					</div>
				</div><br>

				<div align="center" style="color: rgb(166, 33, 24); background: rgb(230,230,230);border-style:double; margin-right: 1%">
						<h5>Clase - Fracción - Prima de Riesgo de Trabajo</h5>
				</div><br>
				
				<div class="row">
					<div class="table-responsive">
						<div class="col-md-12" id="datos"></div>
					</div>
				</div>

				<div id="selectoresparaagregarprima" style="display: none" class="row">
					<div class="col-md-4">
						<label  class="control-label">Mes:</label>
						<select id="selmesfraccionriesgodetrab" name="selmesfraccionriesgodetrab" class="form-control"></select>
					</div>
					<div class="col-md-4">
						<label  class="control-label">Año:</label>
						<select id="selaniofraccionriesgodetrab" name="selaniofraccionriesgodetrab" class="form-control" ></select>
					</div>
					<div class="col-md-4">
						<label  class="control-label">Prima:</label>
						<input id="inpprimainiciomodafisuc" name="inpprimainiciomodafisuc" class="form-control" >
					</div>
				</div>

				<div id="imagenagregar" style="display: none"class="clearfix">
				  <div class="pull-right">
		    		<img  style="display:none" src='../../Vista/img/save.png' class='cursorImg'  title="Guardar prima" id='btnguardarprima' onclick='guardarprima()'>&nbsp&nbsp
						<img  src='../../Vista/img/iconNuevo.png' class='cursorImg'  title="Agregar prima" id='btnagregar' onclick='agregarprima()'>
					</div>
				</div>
				
				<div  class="row">
					<div class="col-md-2">
						<label  class="control-label">Clase:</label>
						<select id="selclaseriegodetrab" name="selclaseriegodetrab" class="form-control" ></select>
					</div>
					<div class="col-md-10">
						<label  class="control-label">Fracción:</label>
						<select id="selfraccionriegodetrab" name="selfraccionriegodetrab" class="form-control" ></select>
					</div>
				</div>

				<div class="row">
					<div class="col-md-8">
						<label  class="control-label">Nombre del Patrón o Representante Legal:</label>
						<input id="inpnombrepatronoresponsable" name="inpnombrepatronoresponsable" class="form-control" readonly>
					</div>
				</div>

				<br>
				<br>
			</div>
		</div>
	</div> <!--displayfrmempresa -->
<br>
  <input id="idTarjetaActivaHidden" type="hidden">
	<div id='divMSGTarjetaPatronal' name='divMSGTarjetaPatronal' ></div>
	<div class="container" align="center"><h1>Tarjetas Patronales</h1></div><br><br>
  <div id="divErrorTarjetaPatronal" name="divErrorTarjetaPatronal"></div>
  <div style="margin-top: 2%"></div>

  <div class="container top-buffer-submenu vertical-buffer">
  	<div id="datosTarjetaPatronal"></div>
		<div id="msjSinTarjetas" class="container" align="center" style="display:none"><h1>SIN TARJETAS PATRONALES AGREGADAS</h1></div>
  </div>
  <input id="inpaccionTarjetaPatronal" type="hidden" value="Editar">
  
  <div id="divBotonesTP" class="container top-buffer-submenu vertical-buffer" style="display:none;">
     <button  id="btnagregarTarjetaPatronal" class="btn btn-default" onclick="agregarTarjetaPatronal()"><span class="glyphicon glyphicon-plus"></span>Agregar</button>
  </div>

  <div tabindex="-1" role="dialog" id="ModalTarjetaPatronal" name="ModalP" aria-labelledby="aaaa1" aria-hidden="true">
  	<h1 align="center" id="procesandoTarjetaPatronal" name="procesandoTarjetaPatronal" style="display:none;" >Procesando ....</h1>
  </div>  

  <!-- editar tarjeta patronal           -->

 <div class="modal fade" tabindex="-1" role="dialog" name="modalEditarTarjetaPatronal" id="modalEditarTarjetaPatronal" data-backdrop="static">
  <div class="modal-dialog" role="document">
      <div class="modal-header">
        <center>
        	<h4 class="modal-title">Edicion Tarjeta Patronal</h4>
        	<br>
        	<br>
        </center>
        <label  class="control-label">Registro Patronal:</label>
				<input type="text" name="selRegistroPatronal" id="selRegistroPatronal" readonly>

				<label  class="control-label">Fecha de Expedición:</label>
				<input  class="input-medium" type="date" name="selectFechaExpedicion" id="selectFechaExpedicion">

				<label  class="control-label">Fecha fin de vigencia:</label>
				<input  class="input-medium" type="date" name="selectFechaFinVigencia" id="selectFechaFinVigencia">
				<input  type="hidden" name="idTarjetaPatronalHidden" id="idTarjetaPatronalHidden">
				<div id="divDocAgregadosSAT">
					<form enctype='multipart/form-data' id='archivoEditTarjetaPatronal' name='archivoEditTarjetaPatronal'>
          	<label>Cargar Documento</label>
          	<input type='file' class='btn-success' id='documentoCargadoTarjetaPatronal' name='documentoCargadoTarjetaPatronal[]' multiple=""/> 
	        </form>
        </div>
      </div>
      <div class="modal-body">
        <p><strong id="errorpermsa"></strong></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="btnGuardarEdicion" onclick="verificarVigencia()">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  


<!-- cuando esta repetida: -->

 <div class="modal fade" tabindex="-1" role="dialog" name="modalTarjetaPatronalExistente" id="modalTarjetaPatronalExistente" data-backdrop="static">
  <div class="modal-dialog" role="document">
      <div class="modal-header">
        <center>
        	<h4 class="modal-title">Existe una tarjeta patronal activa, desea continuar? si su respuesta es "si" escriba el motivo</h4>
        	<br>
        	<br>
					<button type="button" class="btn btn-success" id="btnSiEdicionConTPExistente" onclick="continuarModalExistente()">Si</button>
					<button type="button" class="btn btn-warning" id="btnNoEdicionConTPExistente" onclick="cerrarModalEdicionExistente()">No</button>
					<br>
					<br>
   				<textarea class="txtArea" name="comentarioEdicion" id="comentarioEdicion"></textarea>
        </center>
      <div class="modal-body">
        <p><strong id="errorExistente"></strong></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
     </div>
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- termina edicion -->

<!-- AGREGAR -->
 <div class="modal fade" tabindex="-1" role="dialog" name="modalAgregarTarjetaPatronal" id="modalAgregarTarjetaPatronal" data-backdrop="static">
  <div class="modal-dialog" role="document">
      <div class="modal-header">
        <center>
        	<h4 class="modal-title">Agregar Tarjeta Patronal</h4>
        	<br>
        	<br>
        </center>
				<label  class="control-label">Fecha de Expedición:</label>
				<input  class="input-medium" type="date" name="selectFechaExpedicionAdd" id="selectFechaExpedicionAdd">

				<label  class="control-label">Fecha fin de vigencia:</label>
				<input  class="input-medium" type="date" name="selectFechaFinVigenciaAdd" id="selectFechaFinVigenciaAdd">
				
				<div id="divDocAgregadosSAT">
					<form enctype='multipart/form-data' id='archivoAddTarjetaPatronal' name='archivoAddTarjetaPatronal'>
          	<label>Cargar Documento</label>
          	<input type='file' class='btn-success' id='documentoCargadoTarjetaPatronalAdd' name='documentoCargadoTarjetaPatronalAdd[]' multiple=""/> 
	        </form>
        </div>

      </div>
      <div class="modal-body">
        <p><strong id="errorpermsa"></strong></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="btnGuardarEdicion" onclick="verificarVigenciaAdd()">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  

<!-- TERMINA AGREGAR -->
<!-- SI EXITE OTRA AL AGREGAR -->

<div class="modal fade" tabindex="-1" role="dialog" name="modalTarjetaPatronalExistenteAdd" id="modalTarjetaPatronalExistenteAdd" data-backdrop="static">
  <div class="modal-dialog" role="document">
      <div class="modal-header">
        <center>
        	<h4 class="modal-title">Existe una tarjeta patronal activa, desea continuar? si su respuesta es "si" escriba el motivo</h4>
        	<br>
        	<br>
					<button type="button" class="btn btn-success" id="btnSiEdicionConTPExistenteAdd" onclick="guardarTPAdd(2)">Si</button>
					<button type="button" class="btn btn-warning" id="btnNoEdicionConTPExistenteAdd" onclick="cerrarModalEdicionExistenteAdd()">No</button>
					<br>
					<br>
   				<textarea class="txtArea" name="comentarioAdd" id="comentarioAdd"></textarea>
        </center>
      <div class="modal-body">
        <p><strong id="errorExistenteAdd"></strong></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
     </div>
  </div><!-- /.modal-dialog -->
</div><!-- /.modal --> 

<!-- TERMINA DIV SI EXITE OTRA AL AGREGAR -->
</body>
	<link rel="stylesheet" href="../css/bootstrap-3.3.5/dist/css/bootstrap.min.css">
	<link href="../../Vista/css/bootstrap-responsive.css" rel="stylesheet">
	<link href="../../Vista/css/login.css" rel="stylesheet">
	<link href="../../Vista/css/animate-custom.css" rel="stylesheet">
	<script type="text/javascript" src="../../Vista/js/jquery-2.1.1.js"></script>
	<script type="text/javascript" src="../../Vista/js/bootstrap.js"></script>
	<link href="../../Vista/css/bootstrap.css" rel="stylesheet">
<style type="text/css"></style>
</html>
<script src="detallempresa.js"></script>