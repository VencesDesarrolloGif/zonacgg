<form class="form-horizontal"  method="post" id="form_registroMovimientos" action="ficheroExcelMovimientos.php" target="_blank" enctype='multipart/form-data'>
<!-- <td><label class="control-label1 label" for="fechaIngreso">AAAAAAAAAA</label></td> -->
<?php
//$log = new KLogger ( "vistaCatalogoTipoMovimientosFin.log" , KLogger::DEBUG );
if ($usuario["rol"] == "Finanzas" || $usuario["rol"] == "Tesoreria") {
    $catalogoTipoMovimientos   = $negocio->negocio_ListaTipoMovimientosFinancieros();
    $catalogoEmpresas          = $negocio->negocio_ListaEmpresas();
    $catalogoBancos            = $negocio->negocio_ListaBancos();
    $catalogoTipoTransacciones = $negocio->negocio_ListaTipoTransacciones();
//$catalogoClavesClasificaciones= $negocio -> negocio_ListaClavesClasificacionesPorTipo(2);
    // $catalogoDepartamentos               = $negocio->negocio_obtenerListaDepartamentos();
    $catalogoDepartamentos               = $negocio->CatalogoDepartamentosNegocio();
    $fechaActual                         = $negocio->negocio_consultaFecha();
    $catalogoTipoMovimientoSinObligacion = $negocio->negocio_ListaTipoMovimientosFinancierosSinObligaciones();
    $catalogoEntidadesFederativas        = $negocio->negocio_obtenerListaEntidadesFeferativas();
    $catalogoLineaNegocio                = $negocio->negocio_obtenerListaLineaNegocio();
    $listaBeneficiarios                  = $negocio->obtenerListaBeneficiarios();
    $listaConceptos                      = $negocio->obtenerListaConceptos();
    $catalogoIVA                         = $negocio->negocio_obteneriva();
    //$log->LogInfo("Valor de vistaCatalogoClavesClasificaciones en vista (catalogo)" . var_export ($catalogoClavesClasificaciones, true));
    $fechaActual= $negocio -> negocio_consultaFecha();

}
?>
<div id="mensajesdeerror"></div>

<!--------------------------------COMIENZA PANEL1 "CARGO" "REGISTRO MOVIMIENTOS"----------------------------------------------------->
<div class="tab-pane" id="cajonleft1" align="center">
  <div id="movimientoPanel1" style="display:none;">
        <a href="javascript:displayControlOfMovimientoPanel1();" id="movimientoPanelActivator" class="btn btn-default>">
        <span class="glyphicon glyphicon-hand-left"></span></a>
          <br> <legend>REGISTRO DE TRANSFERENCIA</legend>
    <table>
        <tr>
          <td><label class="control-label1 label" for="fechaRegistroCargo">Fecha Movimiento</label></td>
          <td><input id="fechaMovimientoCargo" name="fechaMovimientoCargo" type="date"   class="input-medium" value= <?php echo $fechaActual['0']["fechaActual"]; ?>></td>

          <td><label class="control-label1 label" for="lblEmpresaCargo">Empresa</label></td>
          <td>
            <select id="empresaCargo" name="empresaCargo" class="input-medium " onChange="">
              <option value="0">EMPRESA</option>
              <?php
                for ($i = 0; $i < count($catalogoEmpresas); $i++) {
                    echo "<option value='" . $catalogoEmpresas[$i]["idEmpresa"] . "'>" . $catalogoEmpresas[$i]["nombreEmpresa"] . " </option>    ";
                }
              ?>
            </select>
          </td>
        </tr>

        <tr>
          <td><label class="control-label1 label" for="selectLineaNegocioCargo">Linea de Negocio</label></td>
          <td>
            <select id="selectLineaNegocioCargo" name="selectLineaNegocioCargo" class="input-large " onChange="">
              <option value="0">LINEA NEGOCIO</option>
                <?php
                  for ($i = 0; $i < count($catalogoLineaNegocio); $i++) {
                      echo "<option value='" . $catalogoLineaNegocio[$i]["idLineaNegocio"] . "'>" . $catalogoLineaNegocio[$i]
                          ["descripcionLineaNegocio"] . " </option>";
                  }
                ?>
            </select>
          </td>
          <td><label class="control-label1 label" for="subtotalCargo">Sub Total</label></td>
          <td><input id="txtSubTotalCargo" name="txtSubTotalCargo" type="number" class="soloNumeros input-large" onblur="sumatoriaCargo();" style="text-align:right;"></td>
        </tr>
        <tr>
          <td><label class="control-label1 label" for="claveClasificacionCargo">Clave Categoria</label></td>
          <td>
          <select id="claveClasificacionCargo" name="claveClasificacionCargo" class="input-large " >
            <option value="0">CLAVES</option>
          </select>
          </td>

          <td><label class="control-label1 label" for="descuentoCargo">Descuento</label></td>
          <td><input id="txtDescuentoCargo" name="txtDescuentoCargo" type="text" class="soloNumeros input-large" onblur="sumatoriaCargo();" style="text-align:right;"></td>
        </tr>
        <tr>
          <td><label class="control-label1 label" for="selectEntidadesCargo">Entidad Destino</label></td>
          <td>
            <select id="selectEntidadesCargo" name="selectEntidadesCargo" disabled="true" class="input-large " onChange="">
              <option value="0">ENTIDAD</option>
              <?php
                for($i = 0; $i < count($catalogoEntidadesFederativas); $i++) {
                    echo "<option value='" . $catalogoEntidadesFederativas[$i]["idEntidadFederativa"] . "'>" .
                    $catalogoEntidadesFederativas[$i]["nombreEntidadFederativa"] . " </option>";
                }
              ?>
            </select>
          </td>
          <td><label class="control-label1 label" for="IvaCargo">Tasa De Iva </label></td>
          <td>
            <select id="txtIvaCargo" name="txtIvaCargo" class="soloNumeros input-large" onChange="" onblur="sumatoriaCargo();" style="text-align:right;">
              <option value="0">ELIJA EL IVA</option>
                <?php
                  for ($i = 0; $i < count($catalogoIVA); $i++) {
                      echo "<option value='" . $catalogoIVA[$i]["valor"] . "'>" . $catalogoIVA[$i]["descripcionIva"] . " </option>";
                  }
                ?>
            </select>
          </td>
        </tr>

        <tr>

          <td><label class="control-label1 label" for="selectTipoDeBancoCargo">N° De Banco Destino</label></td>
          <td>
            <select id="selectTipoDeBancoCargo" name="selectTipoDeBancoCargo" class="input-large " onChange="">
              <option value="0">Banco</option>
              <?php
                for ($i = 0; $i < count($catalogoBancos); $i++) {
                    echo "<option value='" . $catalogoBancos[$i]["idBanco"] . "'>" . $catalogoBancos[$i]["nombreBanco"] . " </option>";
                }
              ?>
            </select>
          </td>
          <td><label class="control-label1 label" for="IvaRetenidoCargo">Iva Retenido </label></td>
          <td><input id="txtIvaRetenidoCargo" name="txtIvaRetenidoCargo" type="text" class="soloNumeros input-large" onblur="sumatoriaCargo();" style="text-align:right;"></td>
        </tr>

        <tr>
          <td><label class="control-label1 label" for="selectNumCuentaCargo">N° De Cuenta Destino</label></td>
          <td><select id="selectNumCuentaCargo" name="selectNumCuentaCargo" class="input-large " onChange="">
            <option value="0">CUENTA</option>
          </select>
          </td>
          <td><label class="control-label1 label" for="montoCargo">Total </label></td>
          <td><input id="montoCargo" name="montoCargo" readonly="true" type="text" class="soloNumeros input-large" style="text-align:right;"></td>
        </tr>

        <tr>
          <td><label class="control-label1 label" for="transaccionCargo">Tipo De Transaccion</label></td>
          <td>
            <select id="tipoTransaccionCargo" name="tipoTransaccionCargo" class="input-large " onChange="">
              <option value="0">TIPO TRANSACCION</option>
                <?php
                  for ($i = 0; $i < count($catalogoTipoTransacciones); $i++) {
                      echo "<option value='" . $catalogoTipoTransacciones[$i]["idTipoTransaccion"] . "'>" .
                          $catalogoTipoTransacciones[$i]["descripcionTransaccion"] . " </option>";
                  }
                ?>
            </select>
          </td>

          <td><label class="control-label1 label" for="referenciaCargo"># Referencia </label></td>
          <td><input id="numeroReferenciaCargo" name="numeroReferenciaCargo" type="text" class="input-large"></td>
        </tr>

        <tr>
        
          <td><label class="control-label1 label" for="beneficiarioCargo">Beneficiario </label></td>
          <td><input id="txtbeneficiarioCargo" name="txtbeneficiarioCargo" type="text" class="input-large" readonly="true"  ></td>
          
          <td><label class="control-label1 label" for="conceptoCargo">Concepto</label></td>
          <td><input id="txtConceptoCargo" name="txtConceptoCargo" type="text" class="input-xlarge"></td>
           
        </tr>

       <tr>
          <div class="card-body text-primary">
            <td><label class="control-label" for="DocPdfCargo">Selecciona archivo: </label></td>
            <td> <input type='file' class='btn-success' id='DocPdfCargo' name='DocPdfCargo[]' accept=".pdf" /></td>
          </div>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td>
          <button id="guardarCargo" name="guardarCargo" class="btn btn-primary" type="button" onclick="guardarMovimientoCargo();"> <span class="    glyphicon glyphicon-floppy-save"></span>Guardar</button>
        </td>
        <td>
          <button id="cancelarCargo" name="guardarCargo" class="btn btn-danger" type="button" onclick="displayControlOfMovimientoPanel1();"> <span class="glyphicon glyphicon-remove"></span>Cancelar</button>
        </td>
      </tr>
    </table>
    <div id="datostablafini">
    </div>
  </div>
</div>
<!--------------------------------TERMINA PANEL1 "CARGO" "REGISTRO DE MOVIMIENTOS"--------------------------------------------------->



<!--------------------------------COMIENZA PANEL2 "ABONO" "REGISTRO MOVIMIENTOS"----------------------------------------------------->
<div class="tab-pane" id="cajonleft2"  align="center">
<div id="movimientoPanel2" style="display:none;">
  <div id="ocultarbtn">
    <a href="javascript:displayControlOfMovimientoPanel2();" id="movimientoPanelActivator" class="btn btn-default" >
    <span class="glyphicon glyphicon-hand-left"></span></a></div>
           <br> <legend>REGISTRO DE MOVIMIENTOS</legend>
<table>
    <tr>
      <td><label class="control-label1 label" id= "lblTotalDisponible" for="lblTotalDisponible">Saldo Disponible Banco : </label></td>
      <td><input  id="impTotalDisponible" name="impTotalDisponible" type="text" readonly></td>
    
      <td><label class="control-label1 label" id= "lblTotalDisponible" for="lblTotalDisponible">Saldo Disponible Cuenta : </label></td>
      <td><input  id="impTotalDisponibleCuenta" name="impTotalDisponibleCuenta" type="text" readonly></td>
      <input id="hdnbandera" name="hdnbandera" style="display: none" type="text" class="input-xlarge"  >
      <input id="estatus" name="estatus" style="display: none" type="text" class="input-xlarge"  >
    </tr>

  <tr>
    <td><label class="control-label1 label" for="fechaIngreso">Fecha Movimiento</label></td>
    <td><input id="fechaMovimiento" name="fechaMovimiento" type="date"  class="input-medium" value= <?php echo $fechaActual['0']["fechaActual"]; ?>></td>

    <td><label class="control-label1 label" for="lblCLienteCaja1" id="lblCLienteCaja1" style="display: none">Encargado Caja</label></td>
    <td>
      <select id="lblCLienteCaja" name="lblCLienteCaja" class="input-large " style="display: none">
        <option value="0">Elije Empleado</option>
        </select>
    </td><br>
    <td>  <div id="visualizarpdf"></div></td>
  </tr>

<tr>
    <td><label class="control-label1 label" for="Reembolso">Reembolso a Caja</label></td>
    <td>
      <div style="margin-bottom: 1.5%;margin-top: -3%">
        <a>No</a>&nbsp&nbsp<a >Si</a>
      </div>
      <div class="material-switch pull-center">
        <input id="Reembolso" name="Reembolso" type="checkbox" value="0">
        <label for="Reembolso" class="label-success1"></label>
      </div>
    </td>



    <td><label class="control-label1 label" for="lblEmpresa">Empresa</label></td>
    <td>
      <select id="empresa" name="empresa" class="input-large " onChange="">
        <option value="0">EMPRESA</option>
        <?php
for ($i = 0; $i < count($catalogoEmpresas); $i++) {
    echo "<option value='" . $catalogoEmpresas[$i]["idEmpresa"] . "'>" . $catalogoEmpresas[$i]["nombreEmpresa"] . " </option>";
}
?>
      </select>
    </td>
    <td>
      <label class="control-label1 label" id= "lblBancoDestinoAbono" style="display: none" for="lblBancoDestinoAbono">Banco Destino :</label>
      <input  id="impBancoDestinoAbono" name="impBancoDestinoAbono" style="display: none" type="text" >
    </td>

    <td><label class="control-label label " id="lblNumeroEmpleado" name="lblNumeroEmpleado" for="lblNumeroEmpleado" style="display: none">N° Empleado</label></td>
    <td><input type="text" name="impBusqueda" id="impBusqueda"class="search-query" style="display: none" placeholder="Buscar  (00-0000-00)" aria-describedby="basic-addon2" onblur="verificarEmpleado();"  ><img src="img/search.png" id="img" name="img" style="display: none"></td>

</tr>

  <tr>
     <td><label class="control-label1 label" for="selectLineaNegocio">Linea de Negocio</label></td>
    <td>
      <select id="selectLineaNegocio" name="selectLineaNegocio" class="input-large " onChange="consultarDepartamentos();">
        <option value="0">LINEA NEGOCIO</option>
        <?php
for ($i = 0; $i < count($catalogoLineaNegocio); $i++) {
    echo "<option value='" . $catalogoLineaNegocio[$i]["idLineaNegocio"] . "'>" . $catalogoLineaNegocio[$i]["descripcionLineaNegocio"] . " </option>";
}
?>
      </select>
    </td>

    <td><label class="control-label1 label" for="subtotal">Sub Total</label></td>
    <td><input id="txtSubTotal" name="txtSubTotal" type="int" class="soloNumeros input-large" onblur="sumatoria();" style="text-align:right;" value="0"></td>

    <td>
      <label class="control-label1 label" id= "lblCuentaDestinoAbono" style="display: none" for="lblCuentaDestinoAbono">N° Cuenta Destino :</label>
      <input  id="impCuentaDestinoAbono" name="impCuentaDestinoAbono" style="display: none" type="text" >
    </td>

  </tr>


  <tr>
    <td><label class="control-label1 label" for="claveClasificacion">Clave Categoria</label></td>
    <td>
    <select id="claveClasificacion" name="claveClasificacion" class="input-large " >
      <option value="0">CLAVES</option>
    </select>
    </td>
    
      <td><label class="control-label1 label" for="descuento">Descuento</label></td>
      <td><input id="txtDescuento" name="txtDescuento" type="text" class="soloNumeros input-large" onblur="sumatoria();" style="text-align:right;"></td>
    
    <td>
  <label class="control-label1 label" id= "lblCtaClaveDestinoAbono" style="display: none" for="lblCtaClaveDestinoAbono">Cuenta Clave Destino :</label>
      <input  id="impCtaClaveDestinoAbono" name="impCtaClaveDestinoAbono" style="display: none" type="text" >
    </td>
  </tr>

  <tr>
    <td><label class="control-label1 label" for="selectTipoDeBanco">Tipo De Banco</label></td>
    <td>
      <select id="selectTipoDeBanco" name="selectTipoDeBanco" class="input-large " onChange="">
        <option value="0">Banco</option>
        <?php
for ($i = 0; $i < count($catalogoBancos); $i++) {
    echo "<option value='" . $catalogoBancos[$i]["idBanco"] . "'>" . $catalogoBancos[$i]["nombreBanco"] . " </option>";
}
?>
      </select>
    </td>

    <td><label class="control-label1 label" for="Iva">Tasa De Iva </label></td>
    <td>
      <select id="txtIva" name="txtIva" class="soloNumeros input-large" onChange="" onblur="sumatoria();" style="text-align:right;">
        <option value="0">ELIJA EL IVA</option>
        <?php
for ($i = 0; $i < count($catalogoIVA); $i++) {
    echo "<option value='" . $catalogoIVA[$i]["valor"] . "'>" . $catalogoIVA[$i]["descripcionIva"] . " </option>";
}
?>
      </select>
    </td>
    <td>
      <label class="control-label1 label" id="verpdf1" for="verpdf">Solicitud De Pago </label>  
      <div id="visualizarpdfSolicitud" title='Abrir Pdf' class='fa fa-file-pdf-o' style= "font-size:30px;color:red;cursor:pointer;" onclick="cargarpdfSolicitud();">
      </div>
    </td>
  </tr>


  <tr>
    <td><label class="control-label1 label" for="selectNumCuenta">Numero De Cuenta</label></td>
    <td><select id="selectNumCuenta" name="selectNumCuenta" class="input-large " onChange="">
      <option value="0">CUENTA</option>
    </select></td>

    <td><label class="control-label1 label" for="IvaRetenido">Iva Retenido </label></td>
    <td><input id="txtIvaRetenido" name="txtIvaRetenido" type="text" class="soloNumeros input-large" onblur="sumatoria();" style="text-align:right;"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="transaccion">Tipo Transaccion</label></td>
    <td>
      <select id="tipoTransaccion" name="tipoTransaccion" class="input-large " onChange="">
        <option  value="0">TIPO TRANSACCION</option>
        <?php
for ($i = 0; $i < count($catalogoTipoTransacciones); $i++) {
    echo "<option value='" . $catalogoTipoTransacciones[$i]["idTipoTransaccion"] . "'>" . $catalogoTipoTransacciones[$i]["descripcionTransaccion"] . " </option>";
}
?>
      </select>
          </td>

            <td><label class="control-label1 label" for="monto">Total </label></td>
            <td><input id="monto" name="monto" type="text" class="soloNumeros input-large" readonly style="text-align:right;"></td>

  </tr>


  <tr>
    <td><label class="control-label1 label" for="beneficiario">Beneficiario </label></td>
    <td><input id="txtbeneficiario" name="txtbeneficiario" type="text" class="input-large"></td>
    <td><label class="control-label1 label" for="selectEntidades">Entidad</label></td>
    <td>
      <select id="selectEntidades" name="selectEntidades" class="input-large " onChange="">
        <option value="0">ENTIDAD</option>
        <?php
for ($i = 0; $i < count($catalogoEntidadesFederativas); $i++) {
    echo "<option value='" . $catalogoEntidadesFederativas[$i]["idEntidadFederativa"] . "'>" . $catalogoEntidadesFederativas[$i]["nombreEntidadFederativa"] . " </option>";
}
?>
      </select>
    </td>
  </tr>


  <tr>
    <td><label class="control-label1 label" for="Departamento">Departamento </label></td>
    <td>
      <select id="departamento" name="departamento" class="input-large " onChange="consultarSubDepartamentos();">
        <!-- <option value="0">DEPARTAMENTO</option> -->
      </select>
    </td>
    <div>
      <td><label class="control-label1 label" for="referencia"># Referencia </label></td>
     <td><input id="numeroReferencia" name="numeroReferencia" type="text" class="input-large"></td>
    </div>
  </tr>


  <tr>
    <td><label class="control-label1 label" for="SubDepartamento">Puestos</label></td>
    <td>
      <select id="subdepartamento" name="subdepartamento" class="input-large " onChange="">
        <!-- <option value="0"> SUB DEPARTAMENTO</option> -->
      </select>
    </td>
    <td><label class="control-label1 label" for="concepto">Concepto</label></td>
    <td><input id="txtConcepto" name="txtConcepto" type="text" class="input-large"></td>
  </tr>


  <tr>
    <div class="card-body text-primary">
      <td><label class="control-label" for="DocPdf">Selecciona archivo: </label></td>
      <td> <input type='file' class='btn-success' id='DocPdf' name='DocPdf[]' accept=".pdf" /></td>

    </div>

  </tr>

  <tr></tr>
  <tr>
    <td></td>
    <td></td>
    <td>
      <button id="guardar" name="guardar" class="btn btn-primary" type="button"  style="display: none" onclick="guardarMovimientoSubmit();"> <span class="glyphicon glyphicon-floppy-save"></span>Guardar</button>

      <button id="guardarSolicitud" name="guardarSolicitud" class="btn btn-primary" type="button" style="display: none" data-toggle='tab'onclick="guardarMovimientoSubmit();"> <span class="glyphicon glyphicon-floppy-save"></span>Guardar</button>

      <button id="regresarSolicitud" name="regresarSolicitud" class="btn btn-primary" type="button" href='#TablaSolicitudesDePagoFinanza' style="display: none" data-toggle='tab'> <span class="glyphicon glyphicon-floppy-save"></span>Guardar</button>
    </td>

    <td><button id="btncancelar" name="btncancelar" class="btn btn-danger" type="button" style="display: none" href='#contenedorFinanzas' data-toggle='tab'  onclick="displayControlOfMovimientoPanel22();" > <span class="glyphicon glyphicon-remove"></span>Cancelar</button>

    <button id="btncancelarSolicitud" name="btncancelarSolicitud" class="btn btn-danger" type="button" style="display: none" href='#TablaSolicitudesDePagoFinanza' data-toggle='tab'  onclick="displayControlOfMovimientoPanel22();" > <span class="glyphicon glyphicon-remove"></span>Cancelar</button>
    </td>
  </tr>
</table>

</div>

</div>

<!--------------------------------TERMINA PANEL2 "ABONO" "REGISTRO DE MOVIMIENTOS"--------------------------------------------------->
 <!-- </div> prueba modal -->
<!--
<div id="fecha" align="center" >
  *<input type="text" id="txtEmpresaSeleccionada" name='txtEmpresaSeleccionada' class="input-medium" readonly>
  <input type="date" id="txtfecha1" name='txtfecha1' class="input-medium" onchange="cambiarFechaConsultaMovimientos(); generarBotonesBancos();">
  <button type="button" class="btn btn-link" onclick="mostrarModalConsultaMovimientosPeriodo();">Consultar Periodo</button>
</div>
-->

<div id="btnTipoMovimientos">

</div>

<!---      DOM principal al click en registromovimientos
<div class="" align="center">
  <div id="btnEmpresas" align="center" >
  </div>
  <div id="btnBancos" align="center" >
  </div>
  <div id="consultaMovimientos" >
  </div>
  <div id="consultaMovimientos2" >
  </div>
</div>
--->

<!--
<div id="myModalEdit" class="modalEdit hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
  <div id="alertMsg1">
  </div>
  <div class="modal-header">
  <h4 class="modal-title" id="myModalLabel">Edicion de Movimiento</h4>
  </div>
  <div class="modal-body">
    <div class="input-prepend">
    <span class="add-on">Fecha</span>
    <input class="span2" id="fechaEdited" name="fechaEdited" type="date">
    </div>
    <div class="input-prepend">
      <span class="add-on">Banco</span>
      <select id="bancoEdited" name="bancoEdited">
        <option>BANCO</option>
        <?php
/*for ($i = 0; $i < count($catalogoBancos); $i++) {
echo "<option value='" . $catalogoBancos[$i]["idBanco"] . "'>" . $catalogoBancos[$i]["nombreBanco"] . " </option>";
}*/
?>
      </select>
    </div>
    <div class="input-prepend">
      <span class="add-on">TipoMovimiento</span>
      <select id="tipoMovimientoEdited" name="tipoMovimientoEdited" onChange="selectListaClavesPorTipoMovimientoEdited();">
        <option>TIPO MOVIMIENTO</option>
        <?php
/*for ($i = 0; $i < count($catalogoTipoMovimientoSinObligacion); $i++) {
echo "<option value='" . $catalogoTipoMovimientoSinObligacion[$i]["idTipoMovimientoFinanciero"] . "'>" . $catalogoTipoMovimientoSinObligacion[$i]["descripcionMovimientoFinanciero"] . " </option>";
}*/
?>
      </select>
    </div>
    <div class="input-prepend">
      <span class="add-on">Empresa</span>
      <select id="selectEmpresaEdited" name="selectEmpresaEdited">
        <option>EMPRESA</option>
        <?php
/*for ($i = 0; $i < count($catalogoEmpresas); $i++) {
echo "<option value='" . $catalogoEmpresas[$i]["idEmpresa"] . "'>" . $catalogoEmpresas[$i]["nombreEmpresa"] . " </option>";
}*/
?>
      </select>
    </div>
    <div class="input-prepend">
      <span class="add-on">Beneficiario</span>
      <input id="txtbeneficiarioEdited" name="txtbeneficiarioEdited" type="text" class="input-xlarge">
    </div>
    <div class="input-prepend">
      <span class="add-on">Concepto</span>
      <input id="txtConceptoEdited" name="txtConceptoEdited" type="text" class="input-xlarge">
    </div>
    <div class="input-prepend">
      <span class="add-on">TipoTransaccion</span>
      <select id="selectTipoTransaccionEdited" name="selectTipoTransaccionEdited">
        <option>TIPO TRANSACCION</option>
        <?php
/* for ($i = 0; $i < count($catalogoTipoTransacciones); $i++) {
echo "<option value='" . $catalogoTipoTransacciones[$i]["idTipoTransaccion"] . "'>" . $catalogoTipoTransacciones[$i]["descripcionTransaccion"] . " </option>";
}*/
?>
      </select>
    </div>
    <div class="input-prepend">
    <span class="add-on">Clave Categoria</span>
    <select id="claveClasificacionEdited" name="claveClasificacionEdited" class="input-large "></select>
    </div>
    <div class="input-prepend">
      <span class="add-on">Departamento</span>
      <select id="selectTipoDeptoEdited" name="selectTipoDeptoEdited">
        <option>DEPARTAMENTO</option>
        <?php
/* for ($i = 0; $i < count($catalogoDepartamentos); $i++) {
echo "<option value='" . $catalogoDepartamentos[$i]["idDepto"] . "'>" . $catalogoDepartamentos[$i]["nombreDepto"] . " </option>";
}*/
?>
      </select>
    </div>
    <div class="input-prepend">
      <span class="add-on">Referencia</span>
      <input id="txtreferenciaEdited" name="txtreferenciaEdited" type="text" class="input-medium">
    </div>
    <div class="input-prepend">
      <span class="add-on">Monto $</span>
      <input id="txtmontoEdited" name="txtmontoEdited" type="text" class="input-medium">
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick='actualizarMovimientoFinanciero();'>Guardar Cambios</button>
  </div>
</div>

--->
<!--Modal Confirmacion
<div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><div id="titleConfirmacion"></div></h4>
      </div>
      <div class="modal-body">
        <h5><div id="confirmacion"></div> </h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-success" data-dismiss="modal" onclick="actualizarEstatusMovimientoFinanciero();">Si</button>
      </div>
    </div>
  </div>
</div>fin modal Confirmacion-->


<!--Modal ConsultaMovimientosPeriodo
<div id="static" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Periodo de consulta</h4>
      </div>
      <div class="modal-body">
        Del
        <input type="date" id="fechaConsultaPeriodo1" name="fechaConsultaPeriodo1" class="input-medium">
        al
        <input type="date" id="fechaConsultaPeriodo2" name="fechaConsultaPeriodo2" class="input-medium">
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-success" data-dismiss="modal" onclick="seleccionarConsultaPeriodos();">Consultar</button>
      </div>
    </div>
  </div>
</div>fin modal ConsultaMovimientosPeriodo -->


<!-- div pie de pagina
<div id="piePagina" align="right">
  <button type="button" class="btn btn-link" id="descargar1" name="descargar1">
  <img class='cursorImg' src='img/exportExcel.png'> Descargar </button>
  <input type="hidden" id="datos_a_enviar1" name="datos_a_enviar1" />
</div>

 fin div pie pagina -->
</form>


<style>
  #movimientoPanel1 {
    padding:10px;
    width:1400px;
    background-color:#efefef;
    display:inline-block;
    position:padding-right;
    border: 4px solid;
    border-radius: 55px;

  }
#movimientoPanel2 {
    padding: 10px;
    width:1400px;
    background-color:#efefef;
    display:inline-block;
    position:padding-right;
    border: 4px solid;
    border-radius: 55px;
  }

</style>
<script type="text/javascript">
  var numeroBanco = "1";
  var nombreBanco = "BANCOMER";
  var idTipoMov = "2";
  var nombreMov = "ABONO";
  var idMovimiento = 0;
  var idClaveMovimiento = 0;
  var fechaConsultaMovimientos = $("#txtfecha1").val();
  var idEstatusMovimiento = 3;
  var idNuevoEstatusMovimiento = 0;
  var empresaId = 1;
  $("#txtEmpresaSeleccionada").val("GIF SEGURIDAD");
  $(document).ready(function() {

    $("#txtbeneficiarioCargo").val("Corporativo GIF");
    $("#selectEntidadesCargo").val("09");
      //generarBotonesEmpresas();
      if (rolUsuario == "Tesoreria" || rolUsuario == "Finanzas") {
          //generarBotonesBancos();
          obtenerListaTipoMovimientosFinancieros();
          //obtenerListaMovimientosDiaStore();
          insertarsaldodiario();
          //obtenerSaldosIniciales();
      }
      /*
                var hoy = new Date();
                var dd = hoy.getDate();
                var mm = hoy.getMonth()+1; //hoy es 0!
                var yyyy = hoy.getFullYear();



                // Obtiene la fecha actual en formato yyyy-mm-dd
                var currentDate = $.datepicker.formatDate('yy-mm-dd', new Date());



                $('#txtfecha1').val(currentDate);
                $('#fechaMovimiento').val(currentDate);

                fechaConsultaMovimientos= $('#txtfecha1').val();

                if (rolUsuario=="Tesoreria" || rolUsuario=="Finanzas")
                {

                generarBotonesBancos();

                obtenerListaTipoMovimientosFinancieros();

                obtenerListaMovimientosDiaStore();

                insertarsaldodiario();

                //obtenerSaldosIniciales();
              }*/
      // Carga los beneficiarios para el autocomplete
      <?php
/*
if (isset($listaBeneficiarios)):
foreach ($listaBeneficiarios as $beneficiario): ?>
beneficiarios.push("<?php echo $beneficiario["
beneficiario "]; ?>");
<?php
endforeach;
endif;?>
$("#txtbeneficiario").autocomplete({
source: beneficiarios
});
// Carga los conceptos para el autocomplete
<?php
if (isset($listaConceptos)):
foreach ($listaConceptos as $concepto):
?>
conceptos.push("<?php echo $concepto["
concepto "]; ?>");
<?php
endforeach;
endif;*/
?>
      /*  $( "#txtConcepto" ).autocomplete({
                                      source: conceptos
                                  });



                               $("#descargar1").click(function(event) {
                               $("#datos_a_enviar1").val( $("<div>").append( $("#Exportar_a_Excel1").eq(0).clone()).html());
                               $("#form_registroMovimientos").submit();
                              });*/
  }); //***************************************************************************TERMINA EL READY*****************************************************************
  function displayControlOfMovimientoPanel1() { //////***********************ESTE DIV SE DESPLIEGA CUANDO PRESIONAS BTN CARGO

      $("#movimientoPanel1").toggle("slide");
      $("#movimientoPanelActivator1").toggle("");
      $("#movimientoPanelActivator2").toggle("");
      $("#movimientoPanelActivator3").toggle("");
      $("#movimientoPanelActivator").hide("swing");


  }
  function displayControlOfMovimientoPanel2() { //////***********************ESTE DIV SE DESPLIEGA CUANDO PRESIONAS BTN abono
    $("#ocultarbtn").hide("swing");
      $("#hdnbandera").val(0);
      $('#guardarSolicitud').hide("swing");
      $('#guardar').show("swing");
      $('#btncancelarSolicitud').hide("swing");
      $('#btncancelar').show("swing");
      $('#lblBancoDestinoAbono').hide("swing");
      $('#impBancoDestinoAbono').hide("swing");
      $('#lblCuentaDestinoAbono').hide("swing");
      $('#impCuentaDestinoAbono').hide("swing");
      $('#lblCtaClaveDestinoAbono').hide("swing");
      $('#impCtaClaveDestinoAbono').hide("swing");
      $('#visualizarpdfSolicitud').hide("swing");
      $('#verpdf1').hide("swing");
      $('#txtDescuento').prop('readonly', false);
      $('#txtIvaRetenido').prop('readonly', false);
      $('#txtSubTotal').prop('readonly', false);
      $('#txtConcepto').prop('readonly', false);
      $('#txtbeneficiario').prop('readonly', false);
      $('#selectLineaNegocio').prop('disabled', false);
      $('#empresa').prop('disabled', false);
      $('#selectEntidades').prop('disabled', false);
      $("#movimientoPanel2").toggle("slide");
      $("#movimientoPanelActivator1").toggle("");
      $("#movimientoPanelActivator2").toggle("");
      $("#movimientoPanelActivator3").toggle("");
      estatuscancear = "success";
      mensajeCancelar= "Cancelar";
      showMessage (mensajeCancelar, estatuscancear);
  }
  function displayControlOfMovimientoPanel22() {

    $("#movimientoPanel2").toggle("slide");  
    $("#movimientoPanelActivator1").toggle("");
    $("#movimientoPanelActivator2").toggle("");
    $("#movimientoPanelActivator3").toggle("");
    estatuscancear = "success";
    mensajeCancelar= "Cancelar";
      showMessage (mensajeCancelar, estatuscancear);
  }

  function sumatoria() {
  var bandera=$("#hdnbandera").val();
  if(bandera==0){
      // var subtotales = $("#txtSubTotal").val();
      // var descuentos = $("#txtDescuento").val();
      var ivaporcent = $("#txtIva").val();
      // var ivareten = $("#txtIvaRetenido").val();

      var subtotales1 = $("#txtSubTotal").val();

    if(subtotales1 % 1 !=0){
       var subtotales= subtotales1;
       $("#txtSubTotal").val(subtotales);
    }else{
          var subtotales= Number.parseFloat(subtotales1).toFixed(2);
          $("#txtSubTotal").val(subtotales);
    }


      var descuentos1 = $("#txtDescuento").val();
      if (descuentos1!=""){

        if(descuentos1 % 1 !=0){
          var descuentos= descuentos1;
          $("#txtDescuento").val(descuentos);
        }else{
              var descuentos= Number.parseFloat(descuentos1).toFixed(2);
              $("#txtDescuento").val(descuentos);
        }
      }else{
        var descuentos = $("#txtDescuento").val();
      }


      var ivareten1   = $("#txtIvaRetenido").val();
      if (ivareten1!=""){

        if(ivareten1 % 1 !=0){
          var ivareten= ivareten1;
          $("#txtIvaRetenido").val(ivareten);
        }else{
              var ivareten= Number.parseFloat(ivareten1).toFixed(2);
              $("#txtIvaRetenido").val(ivareten);
        }
      }else{
              var ivareten   = $("#txtIvaRetenido").val();
      }
      var subtotalesint = parseFloat(subtotales);
      var descuentosint = parseFloat(descuentos);
      var ivaporcentint = parseFloat(ivaporcent);
      var ivaretenint = parseFloat(ivareten);

      if (subtotales == "" || descuentos == "" || ivareten == "") {
          $("#monto").val('');
      }else {
          var sumatoria = (subtotalesint - descuentosint);
          var resustaldoiva = (sumatoria * ivaporcentint);
          var resultadosumatoria = (sumatoria + resustaldoiva);
          var resultadototal = (resultadosumatoria - ivaretenint).toFixed(2.5);
      }
      $("#monto").val(resultadototal);
    }else {

      //$('#monto').show("swing");
      var totalSol = $("#monto").val();
      var ivaporcentSol = $("#txtIva").val();
      var descuentosSol = $("#txtDescuento").val();
      var ivaretenSol = $("#txtIvaRetenido").val();

      var totalintSol = parseFloat(totalSol);
      var descuentosintSol = parseFloat(descuentosSol);
      var ivaporcentintSol = parseFloat(ivaporcentSol);
      var ivaretenintSol = parseFloat(ivaretenSol);
      if (totalSol == "" || descuentosSol == "" || ivaporcentSol == 0 || ivaretenSol == "") {
          $("#txtSubTotal").val("");
      } else {
          var sumatoriaSol = (totalintSol * ivaporcentintSol);
          var resustaldoivaSol = ( totalintSol - sumatoriaSol ).toFixed(2.5);
      }
      $("#txtSubTotal").val(resustaldoivaSol);
    }
  }

  $("#txtIva").change(function() {
    var bandera1=$("#hdnbandera").val();
      var valorIva = $("#txtIva").val();
      
      if (bandera1==0 && valorIva ==0) {
          $("#monto").val("");
      }else if(bandera1==1 && valorIva ==0){
        $("#txtSubTotal").val("");
      }
  });
  $("#selectTipoDeBanco").change(function() {
      var valorselectorbanco = $("#selectTipoDeBanco").val();
      if (valorselectorbanco != 0) {
          $.ajax({
              type: "POST",
              url: "ajax_listaCuentasBancarias.php",
              data: {
                  "valorselectorbanco": valorselectorbanco
              },
              dataType: "json",
              success: function(response) {
                  var datos = response.datos;
                  $('#selectNumCuenta').empty().append('<option value="0" selected="selected">Cuenta</option>');
                  $.each(datos, function(i) {
                      $('#selectNumCuenta').append('<option value="' + response.datos[i].idCuentaBancaria + '">' + response.datos[i].numCuenta + '</option>');
                  });
                  obtenertotaldisponible(0);
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
          });
      } else {
          $('#selectNumCuenta').val("0");
          $("#impTotalDisponible").val("");
          $("#impTotalDisponibleCuenta").val("");
      }
  });
  $("#selectNumCuenta").change(function() {
      if ($("#selectNumCuenta").val() != 0) {
          obtenertotaldisponible(1);
      } else {
          $("#impTotalDisponibleCuenta").val("");
      }
  });

  /*$("#departamento").change(function() {
     var idDepto = $("#departamento").val();
      var valorsubdepartamento = $("#departamento").val();
      if (valorsubdepartamento != 0) {
          $.ajax({
              type: "POST",
              url: "ajax_listaSubDepartamentos.php",
              data: {
                  "valorsubdepartamento": valorsubdepartamento
              },
              dataType: "json",
              success: function(response) {
                  //console.log(response);
                  var datos = response.datos;
                  //console.log(datos);
                  $('#subdepartamento').empty().append('<option value="0" selected="selected">Sub Departamento</option>');
                  $.each(datos, function(i) {
                      $('#subdepartamento').append('<option value="' + response.datos[i].idSubDepto + '">' + response.datos[i].nombreSubDepto + '</option>');
                  });
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
          });
      } else {
          $('#subdepartamento').val("0");
      }
  });*/

  $("#selectLineaNegocio").change(function() {
      var valorClaves = $("#selectLineaNegocio").val();
      var check = $("#Reembolso").val();
      var CaseNegocioAbono = 0;
      if (valorClaves != 0) {
          obtenerclaveclasificacion(valorClaves,check,CaseNegocioAbono);
      } else {
          $('#claveClasificacion').empty().append('<option value="0" selected="selected">CLAVES</option>');
          $('#lblNumeroEmpleado').hide("swing");
          $('#impBusqueda').hide("swing");
          $('#img').hide("swing");
          $('#monto').prop('disabled', true);
          $('#empresa').prop('disabled', false);
          $('#txtSubTotal').prop('disabled', false);
          $('#txtDescuento').prop('disabled', false);
          $('#txtIva').prop('disabled', false);
          $('#txtIvaRetenido').prop('disabled', false);
          $('#impBusqueda').val("");
          $('#datostablafini').hide("swing");
          $('#impBusqueda').empty();
          $('#selectEntidades').prop('disabled', false);
          $('#selectEntidades').val("0");
          $('#monto').val("");
      }
  });

  function enviarPdf() {
      var fechamov = $("#fechaMovimiento").val();
      var NombreUsuario = 1;
      var CasePdfAbono = 0;
      var formData = new FormData($("#form_registroMovimientos")[0]);
      formData.append('fechamov', fechamov);
      formData.append('NombreUsuario', NombreUsuario);
      formData.append('CasePdf', CasePdfAbono);
      for (var value of formData.values()) {}
      $.ajax({
          type: "POST",
          url: "upload_ArchivoAbonoFin.php",
          data: formData,
          dataType: "json",
          cache: false,
          contentType: false,
          processData: false,
          success: function(response) {
              console.log(response);
          },
          error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
          }
      });
  }
  $('#Reembolso').change(function() {
    var bandera= $("#hdnbandera").val();
      if ($('#Reembolso').is(":checked")) {
          $('#Reembolso').val(1);
          $('#lblCLienteCaja1').show("swing");
          $('#lblCLienteCaja').show("swing");
          $('#lblNumeroEmpleado').hide("swing");
          $('#impBusqueda').hide("swing");
          $('#img').hide("swing");
          $('#monto').prop('disabled', true);
          $('#txtSubTotal').prop('disabled', false);
          $('#txtDescuento').prop('disabled', false);
          $('#txtIva').prop('disabled', false);
          $('#txtIvaRetenido').prop('disabled', false);
          $('#impBusqueda').val("");
          $('#datostablafini').hide("swing");
          $('#impBusqueda').empty();
          if(bandera==0){
          $('#selectLineaNegocio').val(0);
          $('#claveClasificacion').val("0");
          $('#empresa').prop('disabled', false);
          $('#selectEntidades').val("0");
          $('#monto').val("");
          $('#selectEntidades').prop('disabled', false);
          }
          cargaselclientecaja();
      } else {
          $('#Reembolso').val(0);
          $('#lblCLienteCaja1').hide("swing");
          $('#lblCLienteCaja').hide("swing");
          if(bandera==0){
          $('#selectLineaNegocio').val(0);
          $('#claveClasificacion').val("0");
          }
        }
  });

  function cargaselclientecaja() {
      //alert("despite de cargar selector");
      var valorCliente = $("#Reembolso").val();
      var lblCLienteCaja = $("#lblCLienteCaja").val();
      if (valorCliente != 0) {
          $.ajax({
              type: "POST",
              url: "ajax_ObtenerListaEmpleadosCaja.php",
              dataType: "json",
              cache: false,
              contentType: false,
              processData: false,
              //una vez finalizado correctamente
              success: function(response) {
                  //console.log(response);
                  var datos = response.datos;
                  $('#lblCLienteCaja').empty().append('<option value="0" selected="selected">Empleado</option>');
                  $.each(datos, function(i) {
                      $('#lblCLienteCaja').append('<option value="' + datos[i].EntidadEmpCaja + datos[i].consecutivoEmpCaja + datos[i].categoriaEmpCaja + '">' + datos[i].nombre + '</option>');
                      //$('#claveClasificacion').append('<option value="0">' + datos[i].claveLineaNegocio'</option>');
                  });
                  if ($('#lblCLienteCaja option').length === 1) {
                      // de no quedar opciones disponibles en el selector de servicios (solo existiria la opción 0), limpio la lista y coloco una opcion 0 con un mensaje.
                      $('#lblCLienteCaja').empty().append('<option value="0" selected="selected">No hay Empleados Asignados</option>');
                  }
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
          });
      } else {
          $('#lblCLienteCaja').empty();
      }
  }
  
  $('#claveClasificacion').change(function() {
      var datos = $("#claveClasificacion").val();
      var bandera= $("#hdnbandera").val();
      //console.log(datos);
      if (datos == "004-000" || datos == "003-012")
      //if(datos=="002-005" || datos=="004-003")
      {
          //  alert("entre al if : "+datos);
          $('#lblNumeroEmpleado').show("swing");
          $('#impBusqueda').show("swing");
          $('#img').show("swing");
      } else {
          //alert("entre al else : "+datos);
          $('#lblNumeroEmpleado').hide("swing");
          $('#impBusqueda').hide("swing");
          $('#img').hide("swing");
          $('#lblNumeroEmpleado').hide("swing");
          $('#impBusqueda').hide("swing");
          $('#lblNombre').hide("swing");
          $('#impNombre').hide("swing");
          $('#lblPagoNeto').hide("swing");
          $('#impPagoNeto').hide("swing");
          $('#img').hide("swing");
          $('#monto').prop('disabled', true);
          
          $('#txtSubTotal').prop('disabled', false);
          $('#txtDescuento').prop('disabled', false);
          $('#txtIva').prop('disabled', false);
          $('#txtIvaRetenido').prop('disabled', false);
          $('#impBusqueda').val("");
          $('#datostablafini').hide("swing");
          $("#datostablafini").empty();
          $('#impBusqueda').empty();
          if(bandera==0){
            $('#empresa').prop('disabled', false);
            $('#selectEntidades').prop('disabled', false);
            $('#selectEntidades').val("0");
            $('#monto').val(""); 
          }
      }
  });

  function verificarEmpleado() {
      var tSearch = $("#impBusqueda").val();
      var expregular = /^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/;
      if (tSearch.length != 10) {
          $('#datostablafini').hide("swing");
          $("#datostablafini").empty();
          $('#selectEntidades').val("0");
          $('#monto').val("");
          alert("Ingrese Un N° De Empleado Correcto");
          return;
      }
      if (expregular.test(tSearch)) {
          var numeroEmp = $("#impBusqueda").val();
          consultarTraeEmpleado(numeroEmp);
          $("#mensajesdeerror").html("");
      }

      function consultarTraeEmpleado(numeroEmp) {
          var numeroEmpleado1 = numeroEmp;
          $("#datostablafini").empty();
          $.ajax({
              type: "POST",
              url: "ajax_obtenerEmpleadoFini.php",
              data: {
                  "numeroEmpleado": numeroEmpleado1
              },
              dataType: "json",
              success: function(response) {
                  //console.log(response);
                  var datos = response.empleado;
                  $("#mensajesdeerror").show();
                  if (response.empleado[0] == null) {
                      $('#datostablafini').hide("swing");
                      alertMsg1 = "<div class='alert alert-error' id='mensajesdeerror'>No sé ha comprobado finiquito<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                      $("#mensajesdeerror").html(alertMsg1);
                  } else {
                      var NombreEmpleado = response.empleado[0].nombreempleado;
                      var entidad = response.empleado[0].entidadFederativaId;
                      var descentidad = response.empleado[0].nombreEntidadFederativa;
                      var busqueda = $("#impBusqueda").val();
                      $('#monto').prop('disabled', false);
                      $('#empresa').prop('disabled', true);
                      $('#txtSubTotal').prop('disabled', true);
                      $('#txtDescuento').prop('disabled', true);
                      $('#txtIva').prop('disabled', true);
                      $('#txtIvaRetenido').prop('disabled', true);
                      $('#selectEntidades').prop('disabled', true);
                      $('#lblNombre').show("swing");
                      $('#impNombre').show("swing");
                      $('#lblPagoNeto').show("swing");
                      $('#datostablafini').show("swing");
                      var tabla = "<table class='table table-bordered' style='position: absolute;left: 50%;top: 47%;'><thead><tr><td colspan='3'><label id='idNombre' name='idNombre'></td></tr><tr><td>N°</td><td>Neto al pago</td><td>Pdf</td></tr></thead><body>";
                      $.each(datos, function(i) {
                          tabla += "<tr><td > " + (i + 1) + " </td>";
                          tabla += "<td >" + "$" + (response.empleado[i].netoAlPago) + "</td>";
                          tabla += "<td><i  title='Generar pdf' class='fa fa-file-pdf-o' style='font-size:23px;color:red'    id='btnconfirmar' onclick='verpdffiniquito(\"" + response.empleado[i].numeroempleado + "\",\"" + response.empleado[i].fechaAlta + "\",\"" + response.empleado[i].fechaBaja + "\")'></i></td>";
                      });
                      $("#datostablafini").append(tabla);
                      $("#idNombre").html(NombreEmpleado);
                      $('#selectEntidades').val(entidad);
                  }
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
          });
      }
  }

  function obtenertotaldisponible(accion) {
      var idbanco = $("#selectTipoDeBanco").val();
      var idnumcuenta = $("#selectNumCuenta").val();
      $.ajax({
          type: "POST",
          url: "ajax_obtenertotaldisponible.php",
          dataType: "json",
          data: {
              "idbanco": idbanco,
              "idnumcuenta": idnumcuenta,
              "accion": accion
          },
          success: function(response) {
              if (response.datos.length > 0) {
                  var saldoDisponibleFin = response.datos[0].saldoDisponibleFin;
              } else {
                  saldoDisponibleFin = 0;
              }
              if (accion == 0) {
                  $("#impTotalDisponible").val(saldoDisponibleFin);
              } else if (accion == 1) {
                  $("#impTotalDisponibleCuenta").val(saldoDisponibleFin);
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
          }
      });
  }

  function insertarenlibrosaldosMovimientos(selectTipoDeBanco, selectNumCuenta, monto, Case) 
  {
    
      $.ajax({
          type: "POST",
          url: "upload_insertarlibrosaldosmovimientos.php",
          data: {
              "selectTipoDeBanco": selectTipoDeBanco,
              "selectNumCuenta": selectNumCuenta,
              "monto": monto,
              "Case": Case
          },
          dataType: "json",
          //una vez finalizado correctamente
          success: function(response) {
              // console.log(response);
          },
          error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
          }
      });
  }

  function insertarsaldodiario() {
      $.ajax({
          type: "POST",
          url: "ajax_insertarSaldoDiario.php",
          dataType: "json",
          success: function(response) {
              //console.log("insersaldodiario",response);
          },
          error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
          }
      });
  }
  $("#selectLineaNegocioCargo").change(function() {
      var ValorLinea = $("#selectLineaNegocioCargo").val();
      var check = 0;
      var CaseNegocioCargo = 1;
      if (ValorLinea != 0) {
          $.ajax({
              type: "POST",
              url: "ajax_obtenerListaClavesPorTipoMovimiento.php",
              data: {
                  "valorClaves": ValorLinea,
                  "check": check,
                  "case": CaseNegocioCargo
              },
              dataType: "json",
              success: function(response) {
                  var datos = response.listaClavesPorTipoMovimiento;
                  $('#claveClasificacionCargo').empty().append('<option value="0" selected="selected">CLAVES</option>');
                  $.each(datos, function(i) {
                      $('#claveClasificacionCargo').append('<option value="' + datos[i].claveClasificacion + '">' + datos[i].claveClasificacion + ":  " + datos[i].descripcionClasificacion + '</option>');
                  });
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
          });
      } else {
          $('#claveClasificacionCargo').empty().append('<option value="0" selected="selected">CLAVES</option>');
          $('#selectEntidadesCargo').val("0");
      }
  });
  $("#selectTipoDeBancoCargo").change(function() {
      var valorselectorbancoCargo = $("#selectTipoDeBancoCargo").val();
      if (valorselectorbancoCargo != 0) {
          $.ajax({
              type: "POST",
              url: "ajax_listaCuentasBancarias.php",
              data: {
                  "valorselectorbanco": valorselectorbancoCargo
              },
              dataType: "json",
              success: function(response) {
                  var datos = response.datos;
                  $('#selectNumCuentaCargo').empty().append('<option value="0" selected="selected">CUENTA</option>');
                  $.each(datos, function(i) {
                      $('#selectNumCuentaCargo').append('<option value="' + response.datos[i].idCuentaBancaria + '">' + response.datos[i].numCuenta + '</option>');
                  });
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
          });
      } else {
          $('#selectNumCuentaCargo').empty().append('<option value="0" selected="selected">CUENTA</option>');
      }
  });

  function enviarPdfCargo() {
      var fechamovCargo = $("#fechaMovimientoCargo").val();
      var NombreUsuarioCargo = 1;
      var CasePdfCargo = 1;
      var formData = new FormData($("#form_registroMovimientos")[0]);
      formData.append('fechamov', fechamovCargo);
      formData.append('NombreUsuario', NombreUsuarioCargo);
      formData.append('CasePdf', CasePdfCargo);
      for (var value of formData.values()) {}
      $.ajax({
          type: "POST",
          url: "upload_ArchivoAbonoFin.php",
          data: formData,
          dataType: "json",
          cache: false,
          contentType: false,
          processData: false,
          success: function(response) {
              console.log(response);
          },
          error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
          }
      });
  }

  function guardarMovimientoSubmit() {

      var bandera=$("#hdnbandera").val();
      var estatus = $("#estatus").val();
      var accion =5; 
      var beneficiario =0; 
      var concepto =0;
      var idempresa =0;
      var idtipotransaccion =0;
      var idlineanegocio =0;
      var idclaveclasi =0;
      var identidad =0;
      var total =0;
      var descripcionclaveclasi =0;

      var monto = $("#monto").val();
      var reembolso = $('#Reembolso').val(); //alert(a);
      var Archivo = $("#DocPdf").val();
      var idbanco = $("#selectTipoDeBanco").val();
      var numcuenta = $("#selectNumCuenta").val();
      var CaseMovimientoAbono=0;
      var txtIva=$("#txtIva").val();
      var selectLineaNegocio = $("#selectLineaNegocio").val();
      var empresa = $("#empresa").val();
      var selectEntidades = $("#selectEntidades").val();
      var datastring = $("#form_registroMovimientos").serialize();
      // alert(empresa);
      datastring += "&idbanco=" + idbanco;
      datastring += "&idTipoMov=" + idTipoMov;
      datastring += "&DocPdf=" + Archivo;
      datastring += "&monto=" + monto;
      datastring += "&reembolso=" + reembolso;
      datastring += "&txtIva=" + txtIva;
      datastring += "&selectLineaNegocio=" + selectLineaNegocio;
      datastring += "&empresa=" + empresa;
      datastring += "&selectEntidades=" + selectEntidades;
      $.ajax({
          type: "POST",
          url: "ajax_registroMovimiento.php",
          data: datastring,
          dataType: "json",
          success: function(response) {
              var estatusAbono = response.status;
              var mensajeAbono = response.message;
              if(estatusAbono!="error"){
                $("#movimientoPanel2").toggle("slide");  
                enviarPdf();
                insertarenlibrosaldosMovimientos(idbanco, numcuenta, monto, CaseMovimientoAbono);
                if(bandera==1){
                  datochecadoSolicituddepago(estatus,accion,beneficiario,concepto,idempresa,idtipotransaccion,idlineanegocio,idclaveclasi,identidad,total,descripcionclaveclasi);
                  $("#regresarSolicitud").click();
                }
                else
                {
                  $("#movimientoPanelActivator1").toggle("");
              $("#movimientoPanelActivator2").toggle("");
              $("#movimientoPanelActivator3").toggle("");
                }
              }
              showMessage(mensajeAbono, response.status);
          },
          error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
          }
      });
  }

  function guardarMovimientoCargo() {
    
          var montoCargo= $("#montoCargo").val();
          var txtSubTotalCargo = $("#txtSubTotalCargo").val();
          var ArchivoCargo=$("#DocPdfCargo").val();
          var idbancoCargo=$("#selectTipoDeBancoCargo").val();
          var numcuentaCargo=$("#selectNumCuentaCargo").val();
          var selectEntidadesCargo=$("#selectEntidadesCargo").val();
          var tipoTransaccionCargo=$("#tipoTransaccionCargo").val();
          var numeroReferenciaCargo=$("#numeroReferenciaCargo").val();
          var empresaCargo=$("#empresaCargo").val();
          var txtIvaCargo=$("#txtIvaCargo").val();
          var CaseMovimientoCargo=1;
          var datastring = $("#form_registroMovimientos").serialize();
              datastring += "&idbancoCargo=" + idbancoCargo;
              datastring += "&selectEntidadesCargo=" + selectEntidadesCargo;
              datastring += "&tipoTransaccionCargo=" + tipoTransaccionCargo;
              datastring += "&numeroReferenciaCargo=" + numeroReferenciaCargo;
              datastring += "&empresaCargo=" + empresaCargo;
              datastring += "&idTipoMov=" + idTipoMov;
              datastring += "&DocPdfCargo=" + ArchivoCargo;
              datastring += "&montoCargo=" + montoCargo;
              datastring += "&txtIvaCargo=" + txtIvaCargo;

          $.ajax({
            type: "POST",
            url: "ajax_registroMovimientoCargo.php",
            data: datastring,
            dataType: "json",
            success: function(response) {
              var estatusCargo=response.status;
              var mensajeCargo=response.message;
              
              if(estatusCargo!="error")
              {
                $("#movimientoPanel1").toggle("slide");
                insertarenlibrosaldosMovimientos(idbancoCargo,numcuentaCargo,txtSubTotalCargo,CaseMovimientoCargo);
                enviarPdfCargo();
                $("#movimientoPanelActivator1").toggle("");
          $("#movimientoPanelActivator2").toggle("");
          $("#movimientoPanelActivator3").toggle("");
              }
              showMessage (mensajeCargo, response.status);
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
            }
          });
  }

  function showMessage(mensaje, status) {
      //$("#msg").show();
      $(document).scrollTop(0);
      if (status =="success") {
        if(mensaje!= "Cancelar"){
          alertMsg1 = "<div class='alert alert-success' id='msg'>" + mensaje + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
          $("#alertMsg").html(alertMsg1);
        }
          $('#msg').delay(4000).fadeOut('slow');
          $("#fechaMovimiento").val("<?php echo date("Y-m-d"); ?>");
          $('#Reembolso').prop("checked",false);
          $('#Reembolso').val(0);
          $('#lblCLienteCaja').hide();
          $('#lblCLienteCaja1').hide();
          $("#selectLineaNegocio").val("0");
          $("#selectTipoDeBanco").val("0");
          $("#tipoTransaccion").val("0");
          $("#txtbeneficiario").val('');
          $("#departamento").val("0");
          $("#empresa").val("0");
          $("#txtSubTotal").val("");
          $("#txtDescuento").val("");
          $("#txtIva").val("0");
          $("#txtIvaRetenido").val("");
          $("#monto").val("");
          $("#numeroReferencia").val("");
          $("#txtConcepto").val("");
          $("#claveClasificacion").val("0");
          $("#selectNumCuenta").val("0");
          $("#DocPdf").val("");
          $("#selectEntidades").val("0");
          $("#impTotalDisponible").val("");
          $("#impTotalDisponibleCuenta").val("");
          $("#impBancoDestinoAbono").val("");
          $("#impCuentaDestinoAbono").val("");
          $("#impCtaClaveDestinoAbono").val("");

          $("#fechaMovimientoCargo").val("<?php echo date("Y-m-d"); ?>");
          $("#selectLineaNegocioCargo").val("0");
          $("#selectTipoDeBancoCargo").val("0");
          $("#tipoTransaccionCargo").val("0");
          $("#empresaCargo").val("0");
          $("#txtSubTotalCargo").val("");
          $("#txtDescuentoCargo").val("");
          $("#txtIvaCargo").val("0");
          $("#txtIvaRetenidoCargo").val("");
          $("#montoCargo").val("");
          $("#numeroReferenciaCargo").val("");
          $("#txtConceptoCargo").val("");
          $("#claveClasificacionCargo").val("0");
          $("#selectNumCuentaCargo").val("0");
          $("#DocPdfCargo").val("");
          
      } else if (status == "error") {
          alertMsg1 = "<div class='alert alert-error' id='msg'><strong>Error en el registro de movimiento:</strong>" + mensaje + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
          $("#alertMsg").html(alertMsg1);
          $('#msg').delay(3000).fadeOut('slow');

          /* var beneficiario = $("#txtbeneficiario").val();
    if ($.inArray(beneficiario, beneficiarios) == -1)
    {
        beneficiarios.push (beneficiario);
    }

    var concepto = $("#txtConcepto").val()
    if ($.inArray(concepto, conceptos) == -1)
    {
        conceptos.push (concepto);
    }
*/
      }
      /*

          $('#msg').delay(5000).fadeOut('slow');


          console.log (beneficiarios);
          console.log (conceptos);
          */
  }

  function obtenerListaTipoMovimientosFinancieros() {
      //funcion generadora de los botone cargo abono saldo del DOM inicial
      var bandera=$("#hdnbandera").val(); 
  
      $.ajax({
          type: "POST",
          url: "ajax_obtenerListaTipoMovimientosFinancieros.php",
          dataType: "json",
          success: function(response) {
              if (response.status == "success") 
              {
                  var listaMovimientos = response.listaTipoMovimientosFinancieros;
                  var botones = $('#btnTipoMovimientos');
                  var botonesMovimientos = "<div>";
                  //console.log (response);
                  for (var i = 0; i < listaMovimientos.length-1; i++) 
                  {
                      var idTipoMovimiento = listaMovimientos[i].idTipoMovimientoFinanciero;
                      var descripcionMovimiento = listaMovimientos[i].descripcionMovimientoFinanciero;
                      botonesMovimientos += " <a  align='left' href='javascript:displayControlOfMovimientoPanel" + idTipoMovimiento + "();' id='movimientoPanelActivator" + idTipoMovimiento + "' class='btn btn-default' onclick='obtenerTipoMovimiento(" + idTipoMovimiento + ",\"" + descripcionMovimiento + "\");'>" + descripcionMovimiento + " <span  class='glyphicon glyphicon-hand-right'></a></br>";
                  }
                  botonesMovimientos += "</div>";
                  $("#btnTipoMovimientos").html(botonesMovimientos);
                 
              }
          },
          error: function(response) {
              console.log(response);
          }
      });
  }

  function obtenerTipoMovimiento(idTipoMovimiento1, nombreMov1) {

      idTipoMov = idTipoMovimiento1;
      nombreMov = nombreMov1;
      $("#textTipoMovimientos").val(nombreMov);

  }

  jQuery('.soloNumeros').keypress(function (tecla) {
        if ((tecla.charCode < 48 || tecla.charCode > 57) && tecla.charCode != 46) return false;
    });

  function sumatoriaCargo() {
      var subtotalesCargo1 = $("#txtSubTotalCargo").val();
      // var subtotalesCargo2=Number.parseFloat(subtotalesCargo1);

    if(subtotalesCargo1 % 1 !=0){
       var subtotalesCargo= subtotalesCargo1;
       $("#txtSubTotalCargo").val(subtotalesCargo);
    }else{
          var subtotalesCargo= Number.parseFloat(subtotalesCargo1).toFixed(2);
          $("#txtSubTotalCargo").val(subtotalesCargo);
    }


      var descuentosCargo1 = $("#txtDescuentoCargo").val();
      if (descuentosCargo1!=""){

        if(descuentosCargo1 % 1 !=0){
          var descuentosCargo= descuentosCargo1;
          $("#txtDescuentoCargo").val(descuentosCargo);
        }else{
              var descuentosCargo= Number.parseFloat(descuentosCargo1).toFixed(2);
              $("#txtDescuentoCargo").val(descuentosCargo);
        }
      }else{
        var descuentosCargo = $("#txtDescuentoCargo").val();
      }


      var ivaretenCargo1   = $("#txtIvaRetenidoCargo").val();
      if (ivaretenCargo1!=""){

        if(ivaretenCargo1 % 1 !=0){
          var ivaretenCargo= ivaretenCargo1;
          $("#txtIvaRetenidoCargo").val(ivaretenCargo);
        }else{
              var ivaretenCargo= Number.parseFloat(ivaretenCargo1).toFixed(2);
              $("#txtIvaRetenidoCargo").val(ivaretenCargo);
        }
      }else{
              var ivaretenCargo   = $("#txtIvaRetenidoCargo").val();
      }


      var ivaporcentCargo = $("#txtIvaCargo").val();
      var subtotalesintCargo = parseFloat(subtotalesCargo);
      var descuentosintCargo = parseFloat(descuentosCargo);
      var ivaporcentintCargo = parseFloat(ivaporcentCargo);
      var ivaretenintCargo = parseFloat(ivaretenCargo);
      if (subtotalesCargo == "" || descuentosCargo == "" || ivaretenCargo == "") {
          $("#monto").val('');//aaaaaaaaaaaaa
      } else {
          var sumatoriaCargo = (subtotalesintCargo - descuentosintCargo);
          var resustaldoivaCargo = (sumatoriaCargo * ivaporcentintCargo);
          var resultadosumatoriaCargo = (sumatoriaCargo + resustaldoivaCargo);
          var resultadototalCargo = (resultadosumatoriaCargo - ivaretenintCargo).toFixed(2.5);
      }
      $("#montoCargo").val(resultadototalCargo);
  }

  $("#lblCLienteCaja").change(function() {
      var emp = $("#lblCLienteCaja").val();
      if (emp != 0) {
          $.ajax({
              type: "POST",
              url: "ajax_Generador.php",
              data: {
                  "emp": emp
              },
              dataType: "json",
              success: function(response) {
                  console.log(response);
                  var pdf = response.datos.pdf;
                  // console.log(pdf);
                  $("#visualizarpdf").html(pdf);
                  $('#visualizarpdf').show();
                  /* var datos = response.listaClavesPorTipoMovimiento;
                       console.log(datos);
                       $('#generador').empty().append('<option value="0" selected="selected">Claves</option>');
                       $.each(datos, function(i) {
                           $('#generador').append('<option value="' + datos[i].claveClasificacion + '">' + datos[i].claveLineaNegocio+"-"+datos[i].claveClasificacion+":  "+datos[i].descripcionClasificacion+ '</option>');

                       });   */
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
          });
      } else {
          $('#visualizarpdf').hide();
      }
  });

  function visualizarpdf(entidad, consecutivo, categoria, fecha, id) {
      //window.open("generadorpdfcobranza.php?entidad=" + entidad + "&" + "consecutivo=" + consecutivo + "&" + "categoria=" + categoria  + "&" + "fecha=" + fecha+ "&" + "id=" + id );
      //var fecha=$("#fecha").val();
      // window.open("uploads/responsivascajas/09_0050_02/09005002_27082019_1.pdf","_blank");
      //var str = "Hello world!";
      //var res = str.substr(1, 4);
      var año = fecha.substr(0, 4);
      var mes = fecha.substr(5, 2);
      var dia = fecha.substr(8, 2);
      window.open("uploads/responsivascajas/" + entidad + "_" + consecutivo + "_" + categoria + "/" + entidad + consecutivo + categoria + "_" + dia + mes + año + "_" + id + ".pdf", "_blank");
      //  window.open("uploads/responsivascajas/"+entidad+"_"+consecutivo+"_"+categoria+"/"+entidad+consecutivo+categoria+"_"+"27082019"+"_"+id+".pdf","_blank");
  }
  function cargarpdfSolicitud(){
    var idSulicitud =$("#estatus").val();
    //var idSulicitud =1;

     window.open("uploads/archivosSolicutudPago/" + "SolicitudPago"+ idSulicitud + ".pdf", "_blank");


  }

function consultarDepartamentos(){

    // alert("REGISTRE EL MOVIMIENTO");
    var lineaNegocio=$("#selectLineaNegocio").val(); 

    $.ajax({
            type: "POST",
            url: "ajax_consultaDepartamentos.php",
            data:{"lineaNegocio": lineaNegocio},
            dataType: "json",
            async:false,
            success: function(response) {
            //console.log(response.datos);
            $("#departamento").empty(); 
            $('#departamento').append('<option value="0">DEPARTAMENTO</option>');
        if(response.status == "success"){
           for(var i = 0; i < response.datos.length; i++){
               $('#departamento').append('<option value="' + (response.datos[i].idDepto) + '">' + response.datos[i].nombreDepto + '</option>');
              }
          }else{
                alert("Error Al Cargar Departamentos");
               }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }

function consultarSubDepartamentos(){

    var departamento=$("#departamento").val(); 

    $.ajax({
            type: "POST",
            url: "ajax_consultaSubDepartamentos.php",
            data:{"departamento": departamento},
            dataType: "json",
            success: function(response) {
            //console.log(response.datos);
            $("#subdepartamento").empty(); 
            $('#subdepartamento').append('<option value="0">PUESTOs</option>');
        if(response.status == "success"){
           for(var i = 0; i < response.datos.length; i++){
               $('#subdepartamento').append('<option value="' + (response.datos[i].idPuesto) + '">' + response.datos[i].descripcionPuesto + '</option>');
              }
          }else{
                alert("Error Al Cargar Sub Departamentos");
               }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }
</script>