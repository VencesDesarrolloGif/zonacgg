<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link  href="css-Bootstrap-V4.1.3/css/bootstrap.min.css" >
  <link rel="stylesheet" href="css-Bootstrap-V4.1.3/popper.min.js">
</head>

<body>
  <div class="container" align="center">
  <legend><h3>Recepción de tarjetas</h3></legend>
  <div id="divMensajeRecepcionTarjeta"></div>
  <div id="divSelectTipoRecepcion">
    <table class="tabletipoRecepcion">
      <tr>
        <td><label  class="control-label1 label" for="selectTipoRecepcion">Tipo de recepcion</label></td>
        <td><select id="selectTipoRecepcion" name="selectTipoRecepcion" class="input-medium">
              <option value="0">TIPO</option>
              <option value="1">PARA UNA ENTIDAD</option>
              <option value="3">PARA UNA MATRIZ</option>
              <option value="2">EXTERNO</option>
            </select>
        </td>
      </tr>
    </table>
  </div>

  <div id="divRecepcionTarjetasInternas" style="display:none;">
    <div class="row" id="EntidadesParaMandarAMatriz" >
        <h4>Seleccione La Entidad De Recepcion</h4>
        <label class="control-label label" for="SelectEntidadDeRecepcion">Entidades</label>
        <select class="span3" id="SelectEntidadDeRecepcion" name="SelectEntidadDeRecepcion"></select>  
    </div> 
    <div class="row" id="SucursalParaRecibirTarjetas" style="display:none;">
        <h4>Seleccione La Sucursal De Recepcion</h4>
        <label class="control-label label" for="SelectSucursalDeRecepcion">Sucursales</label>
        <select class="span3" id="SelectSucursalDeRecepcion" name="SelectSucursalDeRecepcion"></select>  
    </div>
    <div class="row" id="MensajeSinTarjetasDisponiblesParaRecepcion" style="display:none">
      <h3 style="color: red;">No Cuentas Con Tarjetas Disponibles Para Recibir</h3>
    </div>
    <div id="DivListaTarjetasDisponiblesParaMatriz" style="display:none">
      <div class="row" >
        <label class="control-label label" for="txtTotalTarjetasARecibirEntidad">Total De Tarjetas </label>
        <input id="txtTotalTarjetasARecibirEntidad" name="txtTotalTarjetasARecibirEntidad" type="text" class="input-medium" readonly="true">
      </div>
      <form class="form-horizontal" id="form_TarjetasParaRecepcionarTarjetasInternas1" name="form_TarjetasParaRecepcionarTarjetasInternas1">
          <center><h3>Información De Las Tarjetas Disponibles</h3></center>
              <input id="NumeroFirmaEnvioTarjetasHidden" name="NumeroFirmaEnvioTarjetasHidden" type="hidden" class="input-medium" readonly="true">
              <input id="ContraseniaFirmaEnvioTarjetasHidden" name="ContraseniaFirmaEnvioTarjetasHidden" type="hidden" class="input-medium" readonly="true">
          <div id="divTarjetasDisponiblesParaRecibirPorEntidad" align="center"></div>  
      </form>
    </div>
  </div>


  <div id="divRecepcionTarjetasInternaParaMatrizR" style="display:none;">
     <div class="row" id="MensajeSinPermisosNecesariosParaMatrizR" style="display:none">
      <h3 style="color: red;">No Cuentas Con Permisos Necesarios Para Recibir A Matriz</h3>
    </div>
    <div class="row" id="MensajeSinTarjetasDisponiblesParaMatrizR" style="display:none">
      <h3 style="color: red;">No Cuentas Con Tarjetas Disponibles Para Recibir A Matriz</h3>
    </div>
    <div id="DivListaTarjetasDisponiblesParaMatrizR" style="display:none">
      <div class="row" >
        <h4>Matriz De Recepcion</h4>
        <label class="control-label label" for="txtEntidadDeRecepcionParaMatrizR">Matriz</label>
         <input id="txtEntidadDeRecepcionParaMatrizR" name="txtEntidadDeRecepcionParaMatrizR" type="text" class="input-medium" readonly="true">
       </div>
         <div class="row" >
              <label class="control-label label" for="txtTotalTarjetasARecibirMatrizR">Total De Tarjetas </label>
              <input id="txtTotalTarjetasARecibirMatrizR" name="txtTotalTarjetasARecibirMatrizR" type="text" class="input-medium" readonly="true">
          </div>
      <form class="form-horizontal" id="form_TarjetasParaRecepcionarTarjetasMatrizR" name="form_TarjetasParaRecepcionarTarjetasMatrizR">
          <center><h3>Información De Las Tarjetas Disponibles</h3></center>
              <input id="NumeroFirmaTarjetasMatrizRHidden" name="NumeroFirmaTarjetasMatrizRHidden" type="hidden" class="input-medium" readonly="true">
              <input id="ContraseniaFirmaTarjetasMatrizRHidden" name="ContraseniaFirmaTarjetasMatrizRHidden" type="hidden" class="input-medium" readonly="true">
          <div id="divTarjetasDisponiblesParaRecibirPorMatrizR" align="center"></div>  
      </form>
    </div>
  </div>

    <form class="form-horizontal"  method="post" name='form_cargarTarjetas' id="form_cargarTarjetas" enctype="multipart/form-data"><br><br>
      <div id="divTablaRecepcionExterna" style="display: none;">
      <table class="tableRecepcionExterna" >
        <tr><td  rowspan="10"><img src="img/tarjeta.png"></td>
          <td><label class="control-label1 label " for="selectMatrizRecepcion">Matriz de la recepción</label></td>
          <td><select id="selectMatrizRecepcion" name="selectMatrizRecepcion" class="input-medium"></select>
          </td>
        </tr>
        <tr>
            <td><label class="control-label1 label" for="txtNoPedido">Numero de pedido</label></td>
            <td><input id="txtNoPedido" name="txtNoPedido" type="text" class="input-small" placeholder="Pedido" disabled="true"></td>
        </tr>
        <tr>
          <td><label class="control-label1 label " for="inpFechaRecep">Fecha Recepción</label></td>
          <td><input id="inpFechaRecep" name="inpFechaRecep" type="text" class="input-medium" placeholder="Seleccione Fecha" disabled="true"/></td>
        </tr>
        <tr>
            <td><label class="control-label1 label " for="documentoDePedido">Documento de pedido</label></td>
            <td><input type='file' class='btn-success' id='documentoDePedido' name='documentoDePedido[]' disabled="true" multiple=""/></td>
        </tr>
        <tr>
            <td><label class="control-label1 label " for="excelTarjetas">Documento EXCEL tarjetas</label></td>
            <td><input type='file' class='btn-success' id='excelTarjetas' name='excelTarjetas[]' disabled="true" multiple=""/></td>
        </tr>
      </table>
      </div><br>
    </form>
      <button style="display: none;" type='button' class='btn btn-success' id='btnRegistrarRecepcion' name='btnRegistrarRecepcion' disabled="true">Registrar</button>
  </div>
</body>


<div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaElectronicaRecepcionTarjetas" id="modalFirmaElectronicaRecepcionTarjetas" data-backdrop="static">
  <div id="errorModalFirmaRecepcionTarjetas"></div>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" align="center"><img src="img/alert.png">Escribe tu numero de empleado y contraseña que generaste</h3>
      </div>
      <div class="modal-body" align="center">
        <h5>Recepción de Tarjetas</h5>
      </div>
      <div class="modal-body" align="center">
        <span class="add-on">No.Empleado</span>
        <input type="text" id="NoEmpModalFirmaRecepcionTarjetas" class="input-medium" name="NoEmpModalFirmaRecepcionTarjetas" placeholder="00-0000-00 Ó 00-00000-00">
        <span class="add-on">Contraseña</span>
        <input type="password" id="constraseniaFirmaRecepcionTarjetas" class="input-xlarge"name="constraseniaFirmaRecepcionTarjetas" title="El campo identifica entre mayusculas y minusculas favor de considerarlo">
      </div>
      <div class="modal-body" align="center">
        <button type="button" id="btnFirmarRecepcionTarjetas" name="btnFirmarRecepcionTarjetas" style="display: none;" onclick="revisarFirmaRecepcionTarjeta();" class="btn btn-primary" >Firmar</button>
        <button type="button" id="btnCancelarFirmaRecepcionTarjetas" name="btnCancelarFirmaRecepcionTarjetas"onclick="cancelarFirmaRecepcionTarjetas();" class="btn btn-danger" >Cancelar</button>
      </div>      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</html>
<script src="recepcionTarjetas/funciones_RecepcionTarjetas.js"></script>