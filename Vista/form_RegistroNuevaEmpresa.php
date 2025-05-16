<?php
//$catalogoEntidades= $negocio -> negocio_obtenerListaEntidadesFeferativas();
$catalogoClientes= $negocio -> negocio_obtenerListaClientesActivos();
 $catalogoLineaNegocioRegistroPunto                = $negocio->negocio_obtenerListaLineaNegocio();
?>
<div class="container" align="center">
<form class="form-horizontal"  method="post" id="form_RegistroNuevaEmpresa" name="form_RegistroNuevaEmpresa" action="ficheroExcelMovimientos.php" target="_blank">
<div id="mensajeerroeelectronic"></div>
<div id="TablaFormularioNuevaEmpresa">
  <fieldset >        
    <legend>Registro De Nueva Sucursal
  </fieldset>

  <table >
  <tr>
    <td  rowspan="38"><img src="img/localizacion.jpg"></td>
    <td><label class="control-label1 label" for="rfc">Cliente</label></td>
    <td>
             <select id="clienteSucursal" name="clienteSucursal" class="input-xlarge " onChange="">
                <option>CLIENTE</option>
                <?php
              for ($i=0; $i<count($catalogoClientes); $i++)
              {
                echo "<option value='". $catalogoClientes[$i]["idCliente"]."'>". $catalogoClientes[$i]["razonSocial"] ." </option>";
              }
              ?>
            </select>    
    </td>
  </tr>

  <tr>
    <td><label class="control-label1 label" for="EconomicoCliente">No. Economico Cliente</label></td>
    <td><input id="txtEconomicoCliente" name="txtEconomicoCliente" type="text" class="input-xlarge" maxlength="6"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="Economico">No. Economico Sucursal</label></td>
    <td><input id="txtNumeroEconomico" name="txtNumeroEconomicoSucursal" type="text" class="input-xlarge" maxlength="4"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="NombreSucursal">Nombre Nueva Sucursal</label></td>
    <td><input id="txtNombreSucursal" name="txtNombreSucursal" type="text" class="input-xlarge" ></td>
  </tr>
    <tr>
    <td><label class="control-label1 label" for="lineNegociosucursal">Line de Negocio</label></td>
    <td> <select id="sellineNegociosucursal" name="sellineNegociosucursal" class="input-xlarge">
        </select></td>
  </tr>
  <tr><td> <label class="control-label1 label" for="RGN">RGN</label></td>
    <td>
       <select id="selRGN" name="selRGN" class="input-xlarge ">    
        </select>
      </td>
  </tr>
  <tr>
    <td> <label class="control-label1 label" for="CodigoPostal">Codigo Postal:</label></td>
    <td><input id="txCodigoPostal" name="txCodigoPostal" placeholder="12345" maxlength="5"type="text" class="input-mini" onblur="ObtenerEntidadesYMunicipios();"pattern="^([0-9]{5})*$" required></td>
  </tr>
  <tr><td> <label class="control-label1 label" for="txtEstado">Estado</label></td>
    <td>
       <select id="Estado" name="Estado" class="input-xlarge ">    
        </select>
      </td>
  </tr>
    <tr>
    <td> <label class="control-label1 label" for="txtMunicipio">Delegacion/Municipio</label></td>
    <td>
       <select id="Municipio" name="Municipio" class="input-xlarge ">    
        </select>
      </td>
  </tr>
  <tr>
    <td> <label class="control-label1 label" for="Colonia">Colonia</label></td>
    <td>
       <select id="selColonia" name="selColonia" class="input-xlarge ">    
        </select>
      </td>
  </tr>
  <tr>
    <td> <label class="control-label1 label" for="direccionSucursal">Dirección</label></td>
    <td><textarea id="txtDireccionSucursal" name="txtDireccionSucursal" class="txtArea"></textarea></td>
  </tr>
  <tr>
    <td> <label class="control-label1 label" for="latitudSucursal">Latitud</label></td>
    <td><input id="txtlatitudSucursal" name="txtlatitudSucursal" type="text" class="input-medium" maxlength="15"></td>
  </tr>
  <tr>
    <td> <label class="control-label1 label" for="LongitudSucursal">Longitud</label></td>
    <td><input id="txtLongitudSucursal" name="txtLongitudSucursal" type="text" class="input-medium" maxlength="15"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="fechaAltaSucursal">Fecha Alta</label></td>
    <td><input id="txtfechaAltaSucursal" name="txtfechaAltaSucursal" type="date" class="input-medium"></td>
  </tr><br>
  <tr><td colspan="3" align="center"> 
    <label  align="center" class="label label-info" for="direccion" >Contacto Administrativo</label></td></tr>
  <tr>
    <td><label class="control-label1 label" for="contactoFacturacionSucursal">Contacto Facturacion</label></td>
    <td><input id="txtContactoFacturacionSucursal" name="txtContactoFacturacionSucursal" type="text" class="input-xlarge"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="correoFacturacionSucursal">Correo Facturacion</label></td>
    <td><input id="txtCorreoFacturacionSucursal" name="txtCorreoFacturacionSucursal" type="text" class="input-xlarge-email"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="telefonoFijoFacturacionSucursal">Tel Fijo Facturacion</label></td>
    <td><input id="txtTelefonoFijoFacturacionSucursal" name="txtTelefonoFijoFacturacionSucursal"onkeypress='return validaNumericosSucursal(event)' type="text" class="input-medium" maxlength="12"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="telefonoMovilFacturacionSucursal">Tel Movil Facturacion</label></td>
    <td><input id="txtTelefonoMovilFacturacionSucursal" name="txtTelefonoMovilFacturacionSucursal"onkeypress='return validaNumericosSucursal(event)' type="text" class="input-medium" maxlength="12"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="telefonoMovilFacturacionSucursal">Terminos Facturación  </label></td>
    <td><textarea id="txtTerminosFacturacionSucursal" name="txtTerminosFacturacionSucursal" class="txtArea"></textarea></td>
  </tr>
  <tr><td colspan="3" align="center"> <label  align="center" class="label label-info" for="direccion">Contacto Tesoreria</label></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="contactoTesoreriaSucursal">Contacto Tesoreria</label></td>
    <td><input id="txtContactoTesoreriaSucursal" name="txtContactoTesoreriaSucursal" type="text" class="input-xlarge"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="correoSucursal">Correo Tesoreria</label></td>
    <td><input id="txtCorreoTesoreriaSucursal" name="txtCorreoTesoreriaSucursal" type="text" class="input-xlarge-emaile"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="telefonoFijoTesoreriaSucursal">Tel Fijo Tesoreria</label></td>
    <td><input id="txtTelefonoFijoTesoreriaSucursal" name="txtTelefonoFijoTesoreriaSucursal" onkeypress='return validaNumericosSucursal(event)' type="text" class="input-medium" maxlength="12"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="telefonoMovilTesoreriaSucursal">Tel Movil Tesoreria</label></td>
    <td><input id="txtTelefonoMovilTesoreriaSucursal" name="txtTelefonoMovilTesoreriaSucursal" onkeypress='return validaNumericosSucursal(event)' type="text" class="input-medium" maxlength="12"></td>
  </tr>
  <tr><td colspan="3" align="center"> <label  align="center" class="label label-info" for="direccion">Contacto Operativo</label></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="contactoOperativoSucursal">Contacto Operativo</label></td>
    <td><input id="txtContactoOperativoSucursal" name="txtContactoOperativoSucursal" type="text" class="input-xlarge"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="correoSucursal">Correo Operativo</label></td>
    <td><input id="txtCorreoOperativoSucursal" name="txtCorreoOperativoSucursal" type="text" class="input-xlarge-email"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="telefonoFijoOperativoSucursal">Tel Fijo Operativo</label></td>
    <td><input id="txtTelefonoFijoOperativoSucursal" name="txtTelefonoFijoOperativoSucursal" onkeypress='return validaNumericosSucursal(event)' type="text" class="input-medium" maxlength="12"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="telefonoMovilOperativoSucursal">Tel Movil Operativo</label></td>
    <td><input id="txtTelefonoMovilOperativoSucursal" name="txtTelefonoMovilOperativoSucursal"onkeypress='return validaNumericosSucursal(event)' type="text" class="input-medium" maxlength="12"></td>
  </tr>
  </table>
  <div style="margin-right: -30%;">
    <button id="guardarSucursal" name="guardarSucursal" class="btn btn-primary" type="button" onclick="ValidarFormulario();"> <span class="glyphicon glyphicon-floppy-save"></span>Guardar</button>
  </div>
  </div>
<div id="modalServicio" name="modalServicio" class="modalPlantilla hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" >
  <div id="msgmodalServicio" id="msgmodalServicio"></div>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="limpiarCerrar1();"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Requisición Personal Y Material(Nueva Sucursal)</h4>
  </div>
  <div class="modal-body-plantilla">

    <div class="input-prepend">
      <span class="add-on">Cliente</span>
      <input class="input-mini" id="inpClienteServicio" name="inpClienteServicio" type="text" readonly>
    </div>
    <div class="input-prepend">
      <span class="add-on">idSucursal</span>
      <input class="input-mini-mini" id="inpIdSucursalServicio" name="inpIdSucursalServicio" type="text" readonly>
    </div>
    <div class="input-prepend">
      <span class="add-on">N°Eco Cliente</span>
      <input class="input-medium" id="inpNumEcoClienteServicio" name="inpNumEcoClienteServicio" type="text" readonly>
    </div>
    <div class="input-prepend">
      <span class="add-on">N°Eco Sucursal</span>
      <input class="input-medium" id="inpNumEcoSucursalServicio" name="inpNumEcoSucursalServicio" type="text" readonly>
    </div>
    <br>
    <div class="input-prepend">
      <span class="add-on">Sucursal</span>
      <input class="input-xlarge" id="inNumSucursalServicio" name="inNumSucursalServicio" type="text" readonly>
    </div>
    <div class="input-prepend">
      <span class="add-on">Fecha Alta Sucursal</span>
      <input class="input-medium" id="fechaInicioSucursalServicio" name="fechaInicioSucursalServicio" type="date" readonly>
    </div>  
    <br>
    <div class="input-prepend">
      <span class="add-on">LINEA NEGOCIO</span>
       <input class="input-medium" id="LineaNegocioServicio" name="LineaNegocioServicio" type="text" readonly>
    </div>
    <br>
<div align="center" >
    <div  class="input-prepend" >
      <span  class="add-on">¿El Servicio Es Una Nuevo Proyecto(Instalacion)?</span>
    </div>
    <div class="material-switch pull-right" align="left" style="margin-right: 40%;margin-left: -30%;">
      <span  class="add-on">NO  SI</span><br><br>
      <input class="input-large" id="checkProyecto" name="checkProyecto" type="checkbox">        
      <label for="checkProyecto" class="label-success1"></label>
    </div>
    <br><br>
    <div id="divFechaInicioInstalacionServicio" class="input-prepend" style="display: none;">
      <span class="add-on">Fecha Inicio Servicio(Proyecto)</span>
      <input class="input-medium" id="FechaInicioProyectoServicio" name="FechaInicioProyectoServicio" type="date" readonly>
      <span class="add-on">Fecha Termino Servicio(Proyecto)</span>
      <input class="input-medium" id="FechaTerminoProyectoServicio" name="FechaTerminoProyectoServicio" type="date">
    </div><br>
    <div class="input-prepend" >
      <span  class="add-on">¿Al Servicio Se Le Dara Mantenimiento Preventivo?</span>
    </div>
    <div class="material-switch pull-right" align="left" style="margin-right: 40%; margin-left: -29%;">
      <span  class="add-on">NO  SI</span><br><br>
      <input class="input-large" id="checkMantenimiento" name="checkMantenimiento" type="checkbox">        
      <label for="checkMantenimiento" class="label-success1"></label>
    </div><br><br>
    <div id="divTiempomantenimientoServicio" class="input-prepend" style="display: none;">
      <span class="add-on">¿Cada Cuanto Tiempo?</span>
      <select id="selTiempoMantenimientoServicio" name="selTiempoMantenimientoServicio" class="input-large"></select>
    </div><br>
     <div class="input-prepend">
      <span  class="add-on">¿Al Servicio Se Le Hará Un Correctivo?</span>
    </div>
    <div class="material-switch pull-right" align="left" style="margin-right: 40%;margin-left: -35%;">
      <span  class="add-on">NO  SI</span><br><br>
      <input class="input-large" id="checkCorrectivo" name="checkCorrectivo" type="checkbox">        
      <label for="checkCorrectivo" class="label-success1"></label>
    </div>
    <br><br>
    <div class="input-prepend">
      <span  class="add-on">¿El Servicio Será A Travez De Un Contratista?</span>
    </div>
    <div class="material-switch pull-right" align="left" style="margin-right: 40%;margin-left: -32%;">
      <span  class="add-on">NO  SI</span><br><br>
        <input class="input-large" id="Contratisteswich" name="Contratisteswich" type="checkbox">        
        <label for="Contratisteswich" class="label-success1"></label>
    </div>
    <br><br>
    <div class="input-prepend" id="divContratistaServicio" style="display: none;">
        <span class="add-on">Contratista</span>
        <select id="selContratista" name="selContratista" class="input-large"></select>
    </div><br>
    <div  class="input-prepend">
        <span  class="add-on">¿El Servicio Se Cobrara Como Igualas?</span>
    </div>
    <div class="material-switch pull-right" align="left" style="margin-right: 40%;margin-left: -35%;">
      <span  class="add-on">NO  SI</span><br><br>
      <input class="input-large" id="IgualasSwitch" name="IgualasSwitch" type="checkbox">        
      <label for="IgualasSwitch" class="label-success1"></label>
    </div>
    <br><br>
    <div id="divCantidadFijaServicio" class="input-prepend" style="display:none;">
      <span class="add-on">Cantidad Fija A Cobrar En Este Servicio</span>
      <input class="input-mini" id="inpCantidadFija" name="inpCantidadFija" type="text">
    </div>
    <div id="divCantidadDinamicaServicio" class="input-prepend" style="display:block;">
      <span class="add-on">Cantidad A Cobrar Por Este Servicio</span>
      <input class="input-mini" id="inpCantidadDinamica" name="inpCantidadDinamica" type="text">
    </div>
</div>
    <div class="input-prepend">
        <span class="add-on">Analista</span>
        <select id="selAnalista" name="selAnalista" class="input-large"></select>
    </div>
    <div class="input-prepend" >
        <span class="add-on">Area A Dar Servicio</span>
        <select id="selCanal" name="selCanal" class="input-large"></select>
    </div>
    <div style="display: none;" id="tablacreadaelectro">
      <table id='CreaciontablaChecks' class='table table-bordered'>
        <thead>
          <th>N°</th>
          <th>idCanal</th>
          <th>Descripcion</th>
          <th>Abreviatura</th>
        </thead><tbody></tbody>
      </table>
    </div>
    <div><li><a href='#' data-toggle='tab' onclick="AbrirModalMAterial1();">Agregar Material A Utilizar</a></li></div>
    <div align="center">
      <div class="input-prepend">
        <span class="add-on">Tipo Turno</span>
        <select id="selTurnoEmpresaServicio" name="selTurnoEmpresaServicio" class="input-large"></select>
      </div>
      <div class="input-prepend">
        <span class="add-on">No.Elementos</span>
        <input class="input-mini-mini" id="inpNumeroElementosServicio" name="inpNumeroElementosServicio" type="text"  onchange="calcularTurnosDiarios();">
      </div>
      <div class="input-prepend">
        <span class="add-on">Puesto</span>
        <select id="SelPuestoEmpleadoServicio" name="SelPuestoEmpleadoServicio" class="input-large "></select>
      </div>
      <br>
      <div class="input-prepend" id="divTotalMaterial">
        <span class="add-on">Total Material</span>
        <input class="input-small" id="inpTotalMaterialServicio" name="inpTotalMaterialServicio" type="text" readonly>
      </div>
      <div class="input-prepend" id="divTotalFactura">
        <span class="add-on">Total Factura</span>
        <input class="input-small" id="inpTotalFacturaServicio" name="inpTotalFacturaServicio" type="text" onchange="calcularCostoTurno();" >
      </div>
      <div class="input-prepend" id="divTotalRetenido">
        <span class="add-on">Retención</span>
        <input class="input-small" id="inpRetenidoServicio" name="inpRetenidoServicio" type="text" >
      </div>
      <div class="input-prepend" id="divSubtotal">
        <span class="add-on">Subtotal</span>
        <input class="input-small" id="inpSubTotalServicio" name="inpSubTotalServicio" type="text" readonly>
      </div>
      <div class="input-prepend" id="divIva">
        <span class="add-on">IVA</span>
        <input class="input-small" id="inpIvaServicio" name="inpIvaServicio" type="text" readonly>
      </div>
      <div class="input-prepend" id="divneto">
        <span class="add-on">NETO</span>
        <input class="input-small" id="inpNetoServicio" name="inpNetoServicio" type="text" readonly>
      </div>
      <div class="input-prepend">
        <span class="add-on">Comentarios de perfil</span>
        <textarea  id="areaComentariosServicio" name="areaComentariosServicio" class="txtAreaComentarios" rows="5" ></textarea>
      </div>
       <div class="input-prepend">
        <span class="add-on">Recursos Materiales</span>
        <textarea  id="areaRecursosServicio" name="areaRecursosServicio" class="txtAreaComentarios" rows="5" ></textarea>
      </div>
    </div> <!-- FIN divSeguridadElectronica-->
    <br><br>
    <div class="modal-footer">
      <button type="button" class="btn btn-primary" onclick="gghjj();">Guardar</button>
    </div>
  </div> <!-- fin modal body-->
</div><!-- /.modal -->

  <div id="modalProyectoMaterial" name="modalProyectoMaterial" class="modalPlantilla hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" >
    <div id="msgModalProyecto" id="msgModalProyecto"></div>
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="limpiarmodalMaterialproyecto();">
        <span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">Registro Del Material A Utilizar (Nuevo Proyecto)</h4>
    </div>

    <div class="modal-body-plantilla">

    <div>
       <div class="input-prepend" id="divFOL">
          <span class="add-on">N° Economico</span>
          <input class="input-small" id="NumEconomic" name="NumEconomic" type="text" readonly >
      </div>
   
      <div class="input-prepend">
        <span class="add-on">Letra Inicial</span>
        <select id="selectLetraInicial" name="selectLetraInicial" class="input-large " >
                    <option value="0">LETRA INICIAL</option>
        </select>
      </div>

      <div class="input-prepend">
        <span class="add-on">Elija El Material</span>
        <select id="selectMaterial" name="selectMaterial" class="input-large " >
                    <option value="0">MATERIAL</option>
        </select>
      </div>

      <div class="input-prepend" id="divCantidadMaterial">
          <span class="add-on">Cantidad </span>
          <input class="input-small" id="txCantidadMaterial" name="txCantidadMaterial" onblur="CalcularCostoTotalMaterial();" type="text" >
      </div>

     </div><br>

     <div>
      <div class="input-prepend" id="divPrecioUnitario">
          <span class="add-on">Precio Unitario</span>
          <input class="input-small" id="txtPrecioUnitario" name="txtPrecioUnitario" type="text" readonly>
      </div>
       <div class="input-prepend">
      <span class="add-on">X</span>
    </div>
      <div class="input-prepend" id="divCantidadtotalmaterial">
          <span class="add-on">Cantidad Total De Material</span>
          <input class="input-small" id="txtdivCantidadtotalmaterial" name="txtdivCantidadtotalmaterial" type="text" readonly>
      </div>
       <div class="input-prepend">
        <span class="add-on">=</span>
       </div>
      <div class="input-prepend" id="divTotalSumatoriamaterial">
          <span class="add-on">Total</span>
          <input class="input-small" id="txtTotalSumatoriamaterial" name="txtTotalSumatoriamaterial" type="text" readonly>
      </div>
     </div><br>

     <div>
      <div class="modal-footer">
        <button type="button" id="AgragarMaterial" class="btn btn-primary">Agregar</button>
      </div>
     </div><br>

     <div style="display: none;" id="tablaMaterial">
    </div><br>
   <div id="totalMaterialTabla" style="display: none">
    <span class="add-on">NETO </span>
    <input class="input-small" id="totalmaterial" name="totalmaterial" type="text"  readonly="readonly" >
    </div><br>

     <div>
      <div class="modal-footer">
        <button id="BtnGuardarMaterial" type="button" class="btn btn-primary" onclick="GuardarMaterial();">Guardar</button>
      </div>
     </div><br>



    </div> <!-- fin modal body-->

  </div><!-- /.modal -->

</form>
</div>

<script type="text/javascript">
var cobraDescansoGlobal=0;

$(inicioRegNEmpresa());  

function inicioRegNEmpresa(){
    <?php
       if ($usuario["rol"] == "Administracion Seguridad Electronica")
        {
    ?>
      obtenrlineanegociosucursal(); 
      obtener_rgn(); 
      obtener_Proveedor(); 
      obtener_Analista();
      obtener_Canal();
      ObtenerAbedecadrioConsulta();
         
     <?php
        }
    ?>
}

function obtenrlineanegociosucursal(){
$.ajax({
            type: "POST",
            url: "ajax_obtenerlineanegocio.php",
            dataType: "json",
            success: function(response) {
              //console.log (response);
                if (response.status == "success")
                {
                    var lineaneg = response.datos;
                    $('#sellineNegociosucursal').empty().append('<option value="0" selected="selected">LINEA DE NEGOCIO</option>');
                      $('#sellineNegociosucursal').append('<option value="' + lineaneg[1].idLineaNegocio + '">' + lineaneg[1].descripcionLineaNegocio + '</option>');
                      $('#sellineNegociosucursal').append('<option value="' + lineaneg[3].idLineaNegocio + '">' + lineaneg[3].descripcionLineaNegocio + '</option>'); 
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
             }
        });
}
function obtener_rgn(){
$.ajax({
            type: "POST",
            url: "ajax_obtener_rgn.php",
            dataType: "json",
            success: function(response) {
              //console.log (response);
                if (response.status == "success")
                {
                  $('#selRGN').empty().append('<option value="0" selected="selected">REGIÓN</option>'); 
                  var datos_rgn=response.datos;
                  for ( var i = 0; i < datos_rgn.length; i++ ){
                    $('#selRGN').append('<option value="' + datos_rgn[i].idRGN + '">' + datos_rgn[i].abreviatura + '</option>');
                  }                        
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
             }
        });
}
function obtener_Proveedor(){
$.ajax({
            type: "POST",
            url: "ajax_obtener_Proveedor.php",
            dataType: "json",
            success: function(response) {
              //console.log (response);
                if (response.status == "success")
                {
                  $('#selContratista').empty().append('<option value="0" selected="selected">CONTRATISTA</option>'); 
                  var datos_Proveedor=response.datos;
                  for ( var i = 0; i < datos_Proveedor.length; i++ ){
                    $('#selContratista').append('<option value="' + datos_Proveedor[i].idProveedor + '">' + datos_Proveedor[i].Abreviatura + '</option>');
                  }                        
                }
            },
           error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
             }
        });
}

function obtener_Analista(){
$.ajax({
            type: "POST",
            url: "ajax_obtener_Analista.php",
            dataType: "json",
            success: function(response) {
              //console.log (response);
                if (response.status == "success")
                {
                  $('#selAnalista').empty().append('<option value="0" selected="selected">ANALISTA</option>'); 
                  var datos_Analista=response.datos;
                  for ( var i = 0; i < datos_Analista.length; i++ ){
                    $('#selAnalista').append('<option value="' + datos_Analista[i].idAnalistaElectro + '">' + datos_Analista[i].Abreviatura + '</option>');
                  }                        
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
             }
        });
}

function obtener_Canal(){
$.ajax({
            type: "POST",
            url: "ajax_obtener_Canal.php",
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                  $('#selCanal').empty().append('<option value="0" selected="selected">CANAL</option>'); 
                  var datos_Canal=response.datos;
                  for ( var i = 0; i < datos_Canal.length; i++ ){
                    $('#selCanal').append('<option value="' + datos_Canal[i].idCanal + '">'+ datos_Canal[i].Descripcion+ " -- "+ datos_Canal[i].Abreviatura + '</option>');
                  }                        
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
             }
        });
}
$("#selCanal").change(function(){
  var selCanal=$("#selCanal").val();

  if(selCanal!=0){
    var b = $("#CreaciontablaChecks tr").length;
    var table = document.getElementById("CreaciontablaChecks");
    var row = table.insertRow(b);
    var contfila = row.insertCell(0);
    var cell1 = row.insertCell(1);
    var cell2 = row.insertCell(2);
    var cell3 = row.insertCell(3);

    for (var i = 0; i < b; i++) {
     

        contfila.innerHTML = " <td > " + (i + 1) + " </td>";

        cell1.innerHTML = "<input class='input-mini' id='idCanalTabla" + i + "' type='text' readonly><input class='input-large' id='inidCanalTabla" + i + "' type='hidden' readonly>   ";
        cell2.innerHTML = "<input class='input-large' id='DescripcionCanalTabla" + i + "' type='text' readonly>";
        cell3.innerHTML = "<input class='input-mini' id='AbreviaturaCanalTabla" + i + "' type='text' readonly>";
    }

   
    var selCanaltexto=$( "#selCanal option:selected" ).text();
    var selCanalTextoSeparado =selCanaltexto.split(" -- ");
    var selCanalDescripcion=selCanalTextoSeparado[0];
    var selCanalAbreviatura=selCanalTextoSeparado[1]; 

    $("#tablacreadaelectro").show();
    $("#idCanalTabla"+(b-1)).val(selCanal);
    $("#inidCanalTabla"+(b-1)).val(selCanal);
    $("#DescripcionCanalTabla"+(b-1)).val(selCanalDescripcion);
    $("#AbreviaturaCanalTabla"+(b-1)).val(selCanalAbreviatura);
     var selCanal=$("#selCanal").val(0);
}  
});

 function ObtenerEntidadesYMunicipios() {
     var codigop = $("#txCodigoPostal").val();
     if (codigop == "" || !/^([0-9]{5})*$/.test(codigop)) {
        cargaerroresSucursal("El Codigo Postal NO Es Valido");
         $("#inpnuevocodigopostalsuc").css('border', '#D0021B 1px solid');
         $("#selColonia").empty().append('<option value="0" selected="selected">Ingrese Codigo Postal valido </option>');
         $("#Municipio").empty().append('<option value="0" selected="selected">Ingrese Codigo Postal valido</option>');
         $("#Estado").empty().append('<option value="0" selected="selected">Ingrese Codigo Postal valido</option>');
         $(document).scrollTop(0);
         codigop = 0;
     } else {         
         $.ajax({
             type: "POST",
             url: "../Nominas/empresa/ajax_llenaselectoreentidadcolnuevaempresa.php",
             data: {
                 "cp": codigop,
                 accion: 1,
             },
             dataType: "json",
             success: function(response) {
                 //console.log(response);
                 datos = response.datos;
                 $("#txCodigoPostal").css('border', '#AEB6BF 1px solid');
                 $('#selColonia').empty().append('<option value="0" selected="selected">Colonia</option>');
                 $('#Municipio').empty().append('<option value="0" selected="selected">Delegacion/Mucicipio</option>');
                 $('#Estado').empty().append('<option value="0" selected="selected">Entidad Federativa/Mucicipio</option>');
                 $.each(datos, function(i) {
                     $('#selColonia').append('<option value="' + response.datos[i].idAsentamiento + '">' + response.datos[i].nombreAsentamiento + '</option>'); //verificar que rollo con esto
                 });
                 if (datos == 0) {
                     cargaerroresSucursal("El Codigo Postal NO Es Valido");
                     $("#txCodigoPostal").css('border', '#D0021B 1px solid');
                     $("#Municipio").empty();
                     $("#Estado").empty();
                     $("#selColonia").empty();
                     $(document).scrollTop(0);
                 } else {                     
                     $('#Municipio').append('<option value="' + response.datos[0].idMunicipio + '">' + response.datos[0].nombreMunicipio + '</option>'); //verificar que rollo con esto
                     $('#Estado').append('<option value="' + response.datos[0].idEstado + '">' + response.datos[0].nombreEntidadFederativa + '</option>');
                 }
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
             }
         });
     }
 }
 function validaNumericosSucursal(event) {
    if(event.charCode >= 48 && event.charCode <= 57){
      return true;
     }
     return false;        
}
function ValidarFormulario(){
  //$("#mensajeerroeelectronic").removeClass('alert alert-error').html('');
  var patron=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
//$patronTelefono = '/\(+[0-9]{1,4}+\)-+[0-9]{4}+\-+[0-9]{4}/';

  var clienteSucursal=$("#clienteSucursal").val();
  var txtEconomicoCliente=$("#txtEconomicoCliente").val();
  var txtNumeroEconomico=$("#txtNumeroEconomico").val();
  var txtNombreSucursal=$("#txtNombreSucursal").val();
  var sellineNegociosucursal=$("#sellineNegociosucursal").val();
  var selRGN=$("#selRGN").val();
  var txCodigoPostal=$("#txCodigoPostal").val();
  var Estado=$("#Estado").val();
  var Municipio=$("#Municipio").val();
  var selColonia=$("#selColonia").val();
  var txtDireccionSucursal=$("#txtDireccionSucursal").val();
  var txtlatitudSucursal=$("#txtlatitudSucursal").val();
  var txtLongitudSucursal=$("#txtLongitudSucursal").val();
  var txtfechaAltaSucursal=$("#txtfechaAltaSucursal").val();
  var txtContactoFacturacionSucursal=$("#txtContactoFacturacionSucursal").val();
  var txtCorreoFacturacionSucursal=$("#txtCorreoFacturacionSucursal").val();
  var txtTelefonoFijoFacturacionSucursal=$("#txtTelefonoFijoFacturacionSucursal").val();
  var txtTelefonoMovilFacturacionSucursal=$("#txtTelefonoMovilFacturacionSucursal").val();
  var txtTerminosFacturacionSucursal=$("#txtTerminosFacturacionSucursal").val();
  var txtContactoTesoreriaSucursal=$("#txtContactoTesoreriaSucursal").val();
  var txtCorreoTesoreriaSucursal=$("#txtCorreoTesoreriaSucursal").val();
  var txtTelefonoFijoTesoreriaSucursal=$("#txtTelefonoFijoTesoreriaSucursal").val();
  var txtTelefonoMovilTesoreriaSucursal=$("#txtTelefonoMovilTesoreriaSucursal").val();
  var txtContactoOperativoSucursal=$("#txtContactoOperativoSucursal").val();
  var txtCorreoOperativoSucursal=$("#txtCorreoOperativoSucursal").val();
  var txtTelefonoFijoOperativoSucursal=$("#txtTelefonoFijoOperativoSucursal").val();
  var txtTelefonoMovilOperativoSucursal=$("#txtTelefonoMovilOperativoSucursal").val();


  //if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3,4})+$/.test(valor)){  }
  if(clienteSucursal=="" || clienteSucursal=="CLIENTE"){
    cargaerroresSucursal("Seleccione El Cliente A Dar Servicio","clienteSucursal");}
  else if(txtEconomicoCliente==""){
    cargaerroresSucursal("Ingrese Los 6 Digitos Del Numero Economico Del Cliente (Solo Numeros)","txtEconomicoCliente");}
  else if(txtNumeroEconomico==""){
    cargaerroresSucursal("Ingrese De 3 a 4 Digitosd Del Numero Economico De La Sucursal (Solo Numeros)","txtNumeroEconomico");}
  else if(txtNombreSucursal==""){
    cargaerroresSucursal("Ingrese EL Nombre De La Sucursal","txtNombreSucursal");}
  else if(sellineNegociosucursal=="" || sellineNegociosucursal=="0"){
    cargaerroresSucursal("Seleccione La Linea De Negocio","sellineNegociosucursal");}
  else if(selRGN=="" || selRGN=="0"){
    cargaerroresSucursal("Seleccione La Reigión","selRGN");}
  else if(txCodigoPostal==""){
    cargaerroresSucursal("Ingrese El Codigo Postal","txCodigoPostal");}
  else if(Estado=="" || Estado=="0"){
    cargaerroresSucursal("Seleccione El Estado De La Nueva Sucursal","Estado");}
  else if(Municipio=="" || Municipio=="0"){
    cargaerroresSucursal("Seleccione El Municipio De La Nueva Sucursal","Municipio");}
  else if(selColonia=="" || selColonia=="0"){
    cargaerroresSucursal("Seleccione La Colonia De La Nueva Sucursal","selColonia");}
  else if(txtDireccionSucursal==""){
    cargaerroresSucursal("Ingrese La Dirección De La Nueva Sucursal","txtDireccionSucursal");}
  else if(txtlatitudSucursal==""){
    cargaerroresSucursal("Ingrese La Latitud De La Nueva Sucursal","txtlatitudSucursal");}
  else if(txtLongitudSucursal==""){
    cargaerroresSucursal("Ingrese La Longitud De La Nueva Sucursal","txtLongitudSucursal");}
  else if(txtfechaAltaSucursal==""){
    cargaerroresSucursal("Ingrese La  De La Nueva Sucursal","txtfechaAltaSucursal");}
  else if(txtContactoFacturacionSucursal==""){
    cargaerroresSucursal("Ingrese El Nombre De Contacto Del Area De Facturacion De La Nueva Sucursal","txtContactoFacturacionSucursal");}
   else if(txtCorreoFacturacionSucursal=="" || patron.test(txtCorreoFacturacionSucursal)!=true){
    cargaerroresSucursal("Ingrese El Correo Del Area De Facturacion de La Nueva Sucursal","txtCorreoFacturacionSucursal");}
  else if(txtTelefonoFijoFacturacionSucursal==""){
    cargaerroresSucursal("Ingrese El Telefono Fijo Del Area De Facturacion De La Nueva Sucursal(Solo Numeros)","txtTelefonoFijoFacturacionSucursal");}
  else if(txtTelefonoMovilFacturacionSucursal==""){
    cargaerroresSucursal("Ingrese El Telefono Celular Del Area De Facturacion De La Nueva Sucursal(Solo Numeros)","txtTelefonoMovilFacturacionSucursal");}
  else if(txtTerminosFacturacionSucursal==""){
    cargaerroresSucursal("Ingrese Los Terminos Del Area De Facturacion De La Nueva Sucursal","txtTerminosFacturacionSucursal");}
  else if(txtContactoTesoreriaSucursal==""){
    cargaerroresSucursal("Ingrese El Nombre De Contacto Del Area De Tesoreria De La Nueva Sucursal","txtContactoTesoreriaSucursal");}
  else if(txtCorreoTesoreriaSucursal=="" || patron.test(txtCorreoTesoreriaSucursal)!=true){
    cargaerroresSucursal("Ingrese El Correo Del Area De Tesoreria De La Nueva Sucursal","txtCorreoTesoreriaSucursal");}
  else if(txtTelefonoFijoTesoreriaSucursal==""){
    cargaerroresSucursal("Ingrese El Telefono Fijo Del Area De Tesoreria De La Nueva Sucursal(Solo Numeros)","txtTelefonoFijoTesoreriaSucursal");}
  else if(txtTelefonoMovilTesoreriaSucursal==""){
    cargaerroresSucursal("IngreseEl Telefono Celular Del Area De Tesoreria De La Nueva Sucursal(Solo Numeros)","txtTelefonoMovilTesoreriaSucursal");}
  else if(txtContactoOperativoSucursal==""){
    cargaerroresSucursal("Ingrese El Nombre De Contacto Del Area Operativa De La Nueva Sucrsal","txtContactoOperativoSucursal");}
  else if(txtCorreoOperativoSucursal=="" || patron.test(txtCorreoOperativoSucursal)!=true){
    cargaerroresSucursal("Ingrese El Correo Del Area Operativa De La Nueva Sucursal","txtCorreoOperativoSucursal");}
  else if(txtTelefonoFijoOperativoSucursal==""){
    cargaerroresSucursal("Ingrese El Telefono Fijo Del Area Operativo De La Nueva Sucursal(Solo Numeros)","txtTelefonoFijoOperativoSucursal");}
  else if(txtTelefonoMovilOperativoSucursal=="" || txtTelefonoMovilOperativoSucursal=="0"){
    cargaerroresSucursal("Ingrese El Telefono Celular Del Area Operativo De La Nueva Sucursal(Solo Numeros)","txtTelefonoMovilOperativoSucursal");}
  else{
    guardarSucursal();
  }
}
 
  function guardarSucursal()
  {
        var datastring = $("#form_RegistroNuevaEmpresa").serialize();   
            /*
            var idRegion=$("#idtxtRegion").val();
            var clienteName=$("#cliente option:selected").text();

            datastring += "&esatusPunto=" + esatusPunto;  
            datastring += "&entidadFederativa=" + entidadFederativa;  
            datastring += "&cobraDescansos=" + cobraDescansos;
            datastring += "&cobraDiaFestivo=" + cobraDiaFestivo;
            datastring += "&cobra31=" + cobra31;
            datastring += "&clienteName=" + clienteName;
            datastring += "&turnoFlat=" + turnoFlat;
            datastring += "&idRegion=" + idRegion;*/

        $.ajax({
            type: "POST",
            url: "ajax_RegistroSucursal.php",
            data: datastring,
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;

                if (response.status=="success") {
                  alert("entre");
                  MsgAlertSucursal1="<div id='MsgAlertSucursal' class='alert alert-success'><trong>Registro Punto Servicio:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                  $("#alertMsg").html(MsgAlertSucursal1);
                  $(document).scrollTop(0);

                  $('#MsgAlertSucursal').delay(3000).fadeOut('slow');
                  /*
                    $(document).scrollTop(0);
                    waitingDialog.hide();
                    cargarselectortipodeturno();
                    seleccionarPuestoSF();
                    mostrarModal();
                    $( "#cliente" ).val("CLIENTE");
                    //document.getElementById("form_registroPuntoServicio").reset();
                    obtenerUltimoNueroOrden();
                    limpiarFormularioPuntoServicio(); 
                    */  
                  cargarselectortipodeturnoSucursal();
                  seleccionarPuestosegElectro();
                  cargarimputconvaloresanteriores();
                  mostrarModal1();
                } else if (response.status=="error")
                {alert("No entre");
                  //waitingDialog.hide();
                  MsgAlertSucursal1="<div id='MsgAlertSucursal' class='alert alert-error'><strong>Error en el registro:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#alertMsg").html(MsgAlertSucursal1);
                    $(document).scrollTop(0);
                    $('#MsgAlertSucursal').delay(3000).fadeOut('slow');
                }
              },error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
             }
        });
    
  }
function cargarimputconvaloresanteriores(){
    $("#inpClienteServicio").val($("#clienteSucursal").val());          
    $("#inpIdSucursalServicio").val(1);   
    $("#inpNumEcoClienteServicio").val($("#txtEconomicoCliente").val());    
    $("#inpNumEcoSucursalServicio").val($("#txtNumeroEconomico").val());   
    $("#inNumSucursalServicio").val($("#txtNombreSucursal").val());       
    $("#fechaInicioSucursalServicio").val($("#txtfechaAltaSucursal").val()); 
    var lns=$("#sellineNegociosucursal").val();
    if(lns==2){
      var lns2 ="SEGURIDAD ELECTRÓNICA";
    }else if(lns==4){
      var lns2 ="SEGURIDAD SATELITAL";
    }
    $("#LineaNegocioServicio").val(lns2); 
    var fechahoy = new Date();
    var mes = ("0" + (fechahoy.getMonth() + 1)).slice(-2);
    var anio=fechahoy.getFullYear();
    var dia = fechahoy.getDate();
    var fecha=anio+'-'+mes+'-'+dia;
    $("#FechaInicioProaaaaaaaayectoServicio").val(fecha);
  }

$('#checkProyecto').change(function() {
  if($('#checkProyecto').is(":checked")) {
    $("#divFechaInicioInstalacionServicio").show();
  }else{
    $("#divFechaInicioInstalacionServicio").hide();
  }
});
$('#checkMantenimiento').change(function() {
  if($('#checkMantenimiento').is(":checked")) {
    $("#divTiempomantenimientoServicio").show();
  }else{ 
    $("#divTiempomantenimientoServicio").hide();
  }
});  
$('#Contratisteswich').change(function() {
  if($('#Contratisteswich').is(":checked")) {
    $("#divContratistaServicio").show();
  }else{ 
    $("#divContratistaServicio").hide();
  }
});  
$('#IgualasSwitch').change(function() {
  if($('#IgualasSwitch').is(":checked")) {
    $("#divCantidadFijaServicio").show();
    $("#divCantidadDinamicaServicio").hide();
  }else{ 
    $("#divCantidadFijaServicio").hide();
    $("#divCantidadDinamicaServicio").show();
  }
});
  function limpiarCerrar1(){
  document.getElementById("listPlantilla").innerHTML="";
  }



  function cargarselectortipodeturnoSucursal()
    {
         $('#selTurnoEmpresaServicio').empty().append('<option value="0">TURNO</option>');
         $('#selTurnoEmpresaServicio').append('<option value="5">DESTAJO</option>');
    }
   function seleccionarPuestosegElectro()
    {
      
       var valorTipo ="03";
       var lineaNegocio =$("#sellineNegociosucursal").val();

       
       $.ajax({
            type: "POST",
            url: "ajax_seleccionarPuestoPorTipo.php",
            data: {"tipoPuesto": valorTipo, "lineaNegocio":lineaNegocio},
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                    var puestos = response.puestos;
                    
                    puestosOptions = "<option>PUESTO</option>";
                    for (var i = 0; i < puestos.length; i++)
                    {
                        puestosOptions += "<option value='" + puestos[i].IdPuesto + "'>" + puestos[i].descripcionPuesto + "</option>";
                    }
                    
                    $("#SelPuestoEmpleadoServicio").html (puestosOptions);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
             }
        });
    }
    function ObtenerAbedecadrioConsulta()
    {     
       $.ajax({
            type: "GET",
            url: "ajax_ObtenerAbedecadrioConsulta.php",
            dataType: "json",
            success: function(response) {
              console.log(response);
                if (response.status == "success")
                {
                    var datos = response.datos;
                    
                    var letras = "<option>LETRA INICIAL</option>";
                    for (var i = 0; i < datos.length; i++)
                    {
                        letras += "<option value='" + datos[i].idLetra + "'>" + datos[i].Descripcion + "</option>";
                    }
                    
                    $("#selectLetraInicial").html (letras);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
             }
        });
    }
$("#selectLetraInicial").change(function(){
  var selectLetraInicial1=$("#selectLetraInicial").val();
  var selectLetraInicial=$( "#selectLetraInicial option:selected" ).text();
  if(selectLetraInicial1!=0){
    $.ajax({
      type: "POST",
      url: "ajax_MaterialxLetra.php",
      data: {"selectLetraInicial": selectLetraInicial},
      dataType: "json",
      success: function(response) {
      // console.log(datos);
          var datos = response.datos;
          $('#selectMaterial').empty().append('<option value="0" selected="selected">MATERIAL</option>');
          $.each(datos, function(i) {
              $('#selectMaterial').append('<option value="' + response.datos[i].idEquipo + '">' + response.datos[i].Descripcion + '</option>');
          });
      },
      error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
      }
  
   });
}  
});
$("#selectMaterial").change(function(){
  var selectMaterial=$("#selectMaterial").val();
  if(selectMaterial!=0){
    $.ajax({
      type: "POST",
      url: "ajax_CostoMaterial.php",
      data: {"selectMaterial": selectMaterial},
      dataType: "json",
      success: function(response) {
      // console.log(datos);
          var datos = response.datos[0].CostoUnitario;
          $("#txtPrecioUnitario").val(datos);
      },
      error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
      }
  
   });

  }  
});

function CalcularCostoTotalMaterial(){
  
     
  var txtPrecioUnitario=$("#txtPrecioUnitario").val();
  var txCantidadMaterial=$("#txCantidadMaterial").val();
  $("#txtdivCantidadtotalmaterial").val(txCantidadMaterial);

  var multiplicacion=txtPrecioUnitario*txCantidadMaterial;
  $("#txtTotalSumatoriamaterial").val(multiplicacion);
}

  function AbrirModalMAterial1(){
    $("#NumEconomic").val($("#txtNumeroEconomico").val());
    $('#modalServicio').modal('hide');
    $('#modalProyectoMaterial').modal();

  }
$("#AgragarMaterial").click(function(){

  var TotalSumatoriamaterial= $("#txtTotalSumatoriamaterial").val();
  if(TotalSumatoriamaterial!=0){
var z = $("#CracionTablaMaterial tr").length;
if(z==0){
    $("#tablaMaterial").html("<table id='CracionTablaMaterial'class='table table-bordered'><thead><th>N°</th><th>Materia</th><th>Costo Unitario</th><th>Cantidad</th><th>Total</th></thead><tbody></tbody>");
}
    var b = $("#CracionTablaMaterial tr").length;
    var table = document.getElementById("CracionTablaMaterial");
    var row = table.insertRow(b);
    var contfila = row.insertCell(0);
    var cell1 = row.insertCell(1);
    var cell2 = row.insertCell(2);
    var cell3 = row.insertCell(3);
    var cell4 = row.insertCell(4);
    for (var i = 0; i < b; i++) {
     
        contfila.innerHTML = " <td> " + (i + 1) + " </td>";
        cell1.innerHTML = "<input class='input-xlarge' id='MatrialTable" + i + "' type='text' readonly><input class='input-large' id='inMatrialTable" + i + "' type='hidden' readonly>";
        cell2.innerHTML = "<input class='input-mini' id='CostoUnitarioTable" + i + "' type='text' readonly>";
        cell3.innerHTML = "<input class='input-mini' id='CantidadTable" + i + "' type='text' readonly><input class='input-large' id='inCantidadTable" + i + "' type='hidden' readonly>";
        cell4.innerHTML = "<input class='input-mini' id='TotalTable" + i + "' type='text' readonly>";
    }

    var selectMaterial=$("#selectMaterial").val();
    var selectMaterialtexto=$( "#selectMaterial option:selected" ).text();
    var txtPrecioUnitario=$("#txtPrecioUnitario").val();
    var txCantidadMaterial=$("#txCantidadMaterial").val();
    var txtTotalSumatoriamaterial=$("#txtTotalSumatoriamaterial").val();
    var totalmaterial=$("#totalmaterial").val();
    if(totalmaterial==""){
      totalmaterial=0;
    }
    $("#tablaMaterial").show();
    $("#MatrialTable"+(b-1)).val(selectMaterialtexto);
    $("#inMatrialTable"+(b-1)).val(selectMaterial);
    $("#CostoUnitarioTable"+(b-1)).val(txtPrecioUnitario);
    $("#CantidadTable"+(b-1)).val(txCantidadMaterial);
    $("#inCantidadTable"+(b-1)).val(txCantidadMaterial);
    $("#TotalTable"+(b-1)).val(txtTotalSumatoriamaterial);

    var txtTotalSumatoriamaterial1=parseFloat(txtTotalSumatoriamaterial);
    var totalmaterial1=parseFloat(totalmaterial);
    var totaldetotales=(txtTotalSumatoriamaterial1+totalmaterial1).toFixed(2.5);
    $("#totalmaterial").val(totaldetotales);  
    $("#totalMaterialTabla").show();
    limpiarFormularioMaterial();
  } 

});
  function limpiarFormularioMaterial(){
  $("#selectLetraInicial").val("LETRA INICIAL");
  $("#selectMaterial").val("0");
  $("#txCantidadMaterial").val("");
  $("#txtPrecioUnitario").val("");
  $("#txtdivCantidadtotalmaterial").val("");
  $("#txtTotalSumatoriamaterial").val("");
  }
  function limpiarmodalMaterialproyecto(){
    limpiarFormularioMaterial();
    $('#modalProyectoMaterial').modal('hide');
    $('#modalServicio').modal();
    document.getElementById("CracionTablaMaterial").innerHTML="";
    $("#totalmaterial").val("");
    $("#totalMaterialTabla").hide();
  }
  function GuardarMaterial(){
  $("#inpTotalMaterialServicio").val($("#totalmaterial").val());
  $('#modalProyectoMaterial').modal('hide');
  $('#modalServicio').modal();
}
  function mostrarModal1(){

    $('#modalServicio').modal();
    /*
    cargarselectortipodeturno();
    seleccionarPuestoSF();
    
    var cliente=$("#cliente option:selected").text();
    var puntoServicio=$("#txtPuntoServicio").val();
    var fechaInicio=$("#txtFechaInicio").val();
    var fechaTermino=$("#txtFechaTerminoServicio").val();
    var fechaInicioPuntoServicio=$("#txtFechaInicio").val();
    var fechaTerminoPuntoServicio=$("#txtFechaTerminoServicio").val();
    var lineanegrequisicion=$("#selLineaNegocio").val();
    var lienarequisicion=$('select[name="selLineaNegocio"] option:selected').text();

    $("#txtClienteModal").val(cliente);
    $("#txtPuntoServicioModal").val(puntoServicio);
    $("#txtFechaInicioRequisicion").val(fechaInicio);
    $("#txtFechaTerminoRequisicion").val(fechaTermino);
    $("#txtLineaNegocioRequisicion").val(lineanegrequisicion);
    $("#txtLineaNegocioRequisicion1").val(lienarequisicion);
    $("#txtFechaInicioPuntoServicioRequisicion").val(fechaInicioPuntoServicio);
    $("#txtFechaTerminoPuntoServicioRequisicion").val(fechaTerminoPuntoServicio);

    obtenerDatosPuntoServicioPorNombre();
    obtenerNumeroRequisicion();*/
  }
function cargaerroresSucursal(mensaje,idtxt){
//form_RegistroNuevaEmpresa

  $(":input").removeAttr("style");
  $('#mensajeerroeelectronic').fadeIn('slow');
  alertmensajeerror="<div class='alert alert-error' id='mensajeerroeelectronic'>"+mensaje+"<data-dismiss='alert'>";
  $("#mensajeerroeelectronic").html(alertmensajeerror);
  $('#mensajeerroeelectronic').delay(3000).fadeOut('slow');
  $(document).scrollTop(0);
  $("#"+idtxt).css('border', '#D0021B 1px solid');
}



</script>


