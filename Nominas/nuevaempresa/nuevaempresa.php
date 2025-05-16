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





<div id="muestranuevosinputsdefrmempresa" style="display: block;">
	<div style="border:2px;border-color:black;border-style:solid;width:100%;height:100%;">
		<div class="container" align="center" ><h1>Domicilio Fiscal Empresa</h1></div><br><br>
			<div class="container top-buffer-submenu vertical-buffer">
				<form id="frmempresa" name="frmempresa" role="form" accept-charset="UTF-8" class="clearfix" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-12">
							<label  class="control-label">Nombre o Razón Social:</label>
							<input id="inprazonsocialnuevaempresa" name="inprazonsocialnuevaempresa" class="form-control" required >
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
								<label  class="control-label">Nombre representante legal:</label>
								<input id="inpnombrereplegalempresa"  name="inpnombrereplegalempresa" class="form-control"  required pattern="^([A-Za-zÁÉÍÓÚñáéíóúÑ])*$">
						</div>
						<div class="col-md-4">
								<label  class="control-label">Apellido Paterno Representante Legal:</label>
								<input id="inpapepaternoreplegalempresa" name="inpapepaternoreplegalempresa" class="form-control"  required pattern="^([A-Za-zÁÉÍÓÚñáéíóúÑ])*$">
						</div>
						<div class="col-md-4">
								<label  class="control-label">Apellido Materno Representante Legal:</label>
								<input id="inpapematernoreplegalempresa" name="inpapematernoreplegalempresa" class="form-control"  required pattern="^([A-Za-zÁÉÍÓÚñáéíóúÑ])*$">
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label  class="control-label">R.F.C:</label>
							<span class="glyphicon glyphicon-info-sign"  data-toggle="tooltip"  title="'EJEMPLO DE R.F.C:' ABC123456AB1 Ó ABC-123456-AB1 Ó ABC1234567AB" ></span>
							<input id="inprfnuevoempresa"  name="inprfnuevoempresa" class="form-control" pattern="^([a-zA-Z]{3}[0-9]{6}[a-zA-Z]{2}[0-9]{1})||([a-zA-Z]{3}[-][0-9]{6}[-][a-zA-Z]{2}[0-9]{1})||([a-zA-Z]{3}[0-9]{7}[a-zA-Z]{2})*$"  required >
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-2">
							<label  class="control-label">Codigo Postal:</label>
							<input id="inpcodigopostalnuevoempresa" name="inpcodigopostalnuevoempresa" placeholder="12345" class="form-control" maxlength="5" onblur="consultaentidadymunicipio();" pattern="^([0-9]{5})*$" required>
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-4">
							<label  class="control-label">Delegacion/Municipio:</label>
							<select id="inpdelmunnuevaempresa" name="inpdelmunnuevaempresa" class="form-control" required ></select>
						</div>
						<div class="col-md-4">
							<label  class="control-label">Colonia:</label>
							<select id="inpcolonianuevaempresa" name="inpcolonianuevaempresa" class="form-control" required ></select>
						</div>
						<div class="col-md-4">
							<label  class="control-label">Calle:</label>
							<input id="inpcallenuevaempresa"  name="inpcallenuevaempresa" class="form-control"  required>
						</div>
						<div class="col-md-4">
							<label  class="control-label">Numero Interior:</label>
							<input id="inpnuminteriornuevaempresa" name="inpnuminteriornuevaempresa" class="form-control">
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label  class="control-label">Número exterior:</label>
							<input id="inpnumexteriornuevaempresa" name="inpnumexteriornuevaempresa" class="form-control" required>
						</div>
						<div class="col-md-4">
							<label  class="control-label">Número Telefono:</label>
							<input id="inptelefononuevaempresa" name="inptelefononuevaempresa" class="form-control" required>
						</div>
					</div>
					<div class="clearfix">
						     <!--BOTONES CANCELAR LIMPIAR--><br>
				    	<div class="pull-right">							
							<input id="btnguardarfrmempresa" name="btnguardarfrmempresa" class="btn btn-primary" type="submit" value="Guardar" >
							
						</div>
					</div>
				</form>
			</div>
	</div>
</div>

	<script src="nuevaempresa.js"></script>
</body>
</html>























