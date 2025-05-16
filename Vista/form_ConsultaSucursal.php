<?php

$catalogoEntidades = $negocio->negocio_obtenerListaEntidadesFeferativas();
$catalogoClientes  = $negocio->negocio_obtenerListaClientesActivos();
 $catalogoLineaNegocioRegistroPunto                = $negocio->negocio_obtenerListaLineaNegocio();
?>
<div align="center">
<form class="form-horizontal"  method="post" id="form_catalogoPuntosServicios" name="form_catalogoPuntosServicios" action="" target="_blank">

        <div align="center">

      <fieldset >
            <legend>Catalogo puntos servicios</legend>
      </fieldset>
       <!--

        <div id="consultaPuntosServicios">

        </div>
        -->
  <!-- Modal  modalEditarPlantilla-->
    <div id="modalEditarPlantilla" name="modalEditarPlantilla" class="modalEdit4 hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" >
          <div class="modal-header">
            <div id="msgEdicionReq" name="msgEdicionReq">
            </div>

            <h4 class="modal-title">Edición de plantilla</h4>
        </div>

        <div class="modal-body-requisicion">

          <div class="input-prepend">
          <span class="add-on">idPunto</span>
          <input class="input-mini-mini" id="txtPuntoServicioIdEdited" name="txtPuntoServicioIdEdited" type="text" readonly>
          <input id="txtIdRequisicion" name="txtIdRequisicion" type="hidden"  class="input-small" readonly> <!-- type="hidden" -->
        </div>
        <div class="input-prepend">
          <span class="add-on">Cliente</span>
          <input class="input-xlarge" id="txtClienteModalEdited" name="txtClienteModalEdited" type="text" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">Punto Servicio</span>
          <input class="input-xlarge" id="txtPuntoServicioModalEdited" name="txtPuntoServicioModalEdited" type="text" readonly>
        </div>
         <br>

        <div class="input-prepend">
          <span class="add-on">Fecha Inicio Punto Servicio</span>
          <input class="input-medium" id="txtFechaInicioPuntoServicioEdited" name="txtFechaInicioPuntoServicioEdited" type="text" readonly >
          <span class="add-on">Fecha Montaje</span>
          <input class="input-medium" id="txtFechaInicioRequisicionEdited" name="txtFechaInicioRequisicionEdited" type="text"  >
        </div>
        <br>
        <div class="input-prepend">
          <span class="add-on">Fecha Termino Punto Servicio</span>
          <input class="input-medium" id="txtFechaTerminoPuntoServicioEdited" name="txtFechaTerminoPuntoServicioEdited" type="text" readonly >
          <span class="add-on">Fecha Termino</span>
          <input class="input-medium" id="txtFechaTerminoRequisicionEdited" name="txtFechaTerminoRequisicionEdited" type="text" >
        </div>
      <br>
          <div class="input-prepend">
          <span class="add-on">LINEA NEGOCIO</span>

          <input class="input-medium" id="txtLineaNegocioRequisicionEdited" name="txtLineaNegocioRequisicionEdited" type="text" readonly value="1">
          <input id="txtCobraDescansoE" name="txtCobraDescansoE" type="hidden" />
          <input id="txtCobraFestivoE" name="txtCobraFestivoE" type="hidden" />
          <input id="txtCobra31E" name="txtCobra31E" type="hidden" />
          </div>
      <br>

    <div class="input-prepend">
        <span class="add-on">Tipo Turno</span>
        <select id="selectTurnoRequisicionEdited" name="selectTurnoRequisicionEdited" class="input-large " onchange="limpiarDatosEdited();mostrarRolOperativoEdicion();">
                    <option>TURNO</option>
                      <?php
for ($i = 0; $i < count($catalogoTurnos); $i++) {
    echo "<option value='" . $catalogoTurnos[$i]["idTipoTurno"] . "' >" . $catalogoTurnos[$i]["descripcionTurno"] . " </option>";
}
?>
        </select>
        <input id="rolOpEdit" name="rolOpEdit" type="hidden" />
        </div>

        <div class="input-prepend" id="divSelectRolOperativoEdited" name='divSelectRolOperativoEdited'>

      </div>

        <div class="input-prepend">
        <span class="add-on">No.Elementos</span>
        <input class="input-mini-mini" id="txtNumeroElementosEdited" name="txtNumeroElementosEdited" type="text"  onchange="calcularTurnosDiariosEdited();">
      </div>

      <div class="input-prepend">
        <span class="add-on">Puesto</span>
        <select id="selectPuestoRequisicionEdited" name="selectPuestoRequisicionEdited" class="input-large ">
            </select>
      </div>

      <br>

      <div class="input-prepend">
        <span class="add-on">Turnos a cubrir x Día</span>

        <input class="input-mini-mini" id="txtTurnosDiariosEdited" name="txtTurnosDiariosEdited" type="text" readonly>
      </div>
      <div class="input-prepend">
        <span class="add-on">Turnos a cubrir x Mes</span>

        <input class="input-mini-mini" id="txtTurnosMensualesEdited" name="txtTurnosMensualesEdited" type="text" readonly>
      </div>

      <div class="input-prepend">
          <span class="add-on">Total Factura</span>
          <input class="input-small" id="txtTotalFacturaEdited" name="txtTotalFacturaEdited" type="text" onchange="calcularCostoTurnoEdited();" >
      </div>
      <div class="input-prepend">
          <span class="add-on">Subtotal</span>
          <input class="input-small" id="txtSubtotalEdited" name="txtSubtotalEdited" type="text" readonly>
      </div>

      <div class="input-prepend">
          <span class="add-on">IVA</span>
          <input class="input-small" id="txtIvaEdited" name="txtIvaEdited" type="text" readonly>
      </div>
      <div class="input-prepend">
          <span class="add-on">Costo Turno</span>
          <input class="input-small" id="txtCostoTurnoEdited" name="txtCostoTurnoEdited" type="text" readonly>


          <input class="input-small" id="txtCostoTurnoEditedAnterior" name="txtCostoTurnoEditedAnterior" type="hidden" readonly>
      </div>
      <br>
      <div class="input-prepend">
        <span class="add-on">Comentarios de perfil</span>

        <textarea  id="txtComentariosRequisicionEdited" name="txtComentariosRequisicionEdited" class="txtAreaComentarios" rows="5" ></textarea>
      </div>
      <br>
      <div class="input-prepend">
        <span class="add-on">Recursos Materiales</span>

        <textarea  id="txtRecursosMaterialesEdited" name="txtRecursosMaterialesEdited" class="txtAreaComentarios" rows="5" ></textarea>
      </div>

        </div> <!-- fin body modal -->

        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="mostrarPlantillaEdited();">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="editarRequisicion();">Guardar Cambios</button>
      </div>
    </div>  <!-- FIN modalEditarPlantilla -->


    <!-- Modal  Baja Empleado-->
    <div id="myModalBajaPuntoServicio" name="myModalBajaPuntoServicio" class="modalEdit hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" >
  <div id="alertMsgBajaModal">
  </div>

   <div class="modal-header">

      <h4 class="modal-title" id="myModalLabel"> <img src="img/warning.png">¿DESEA APLICAR BAJA DEL PUNTO DE SERVICIO?</h4>
    </div>

    <div class="modal-body">

        <div class="input-prepend">
          <span class="add-on">PUNTO SERVICIO</span>
          <input id="txtPuntoServicioM" name="txtPuntoServicioM" type="text" class="input-xlarge" readonly>
          <span class="add-on">ID PUNTO SERVICIO</span>
          <input id="txtIdPuntoBaja" name="txtIdPuntoBaja" type="text" class="input-small" readonly>
        </div>
       <div class="input-prepend">
          <span class="add-on">FECHA BAJA</span>
          <input id="txtFechaBajaPuntoServicio" name="txtFechaBajaPuntoServicio" type="text" class="input-medium"  >
        </div>


    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>

        <button type="button" class="btn btn-primary" onclick='actualizaEstatusPuntoServicio();'>Guardar Cambios</button>
      </div>
    </div>  <!-- FIN MODAL BAJA EMPLEADO -->



    <!-- Modal  reactivacion punto servicio-->
    <div id="myModalReactivarPuntoServicio" name="myModalReactivarPuntoServicio" class="modalEdit hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" >
  <div id="alertMsgReactivacion">
  </div>

   <div class="modal-header">

      <h4 class="modal-title" id="myModalLabel"> <img src="img/warning.png">¿DESEA REACTIVAR EL PUNTO DE SERVICIO?</h4>
    </div>

    <div class="modal-body">

        <div class="input-prepend">
          <span class="add-on">PUNTO SERVICIO</span>
          <input id="txtPuntoServicioReactivacion" name="txtPuntoServicioReactivacion" type="text" class="input-xlarge" readonly>
          <span class="add-on">ID PUNTO SERVICIO</span>
          <input id="txtIdPuntosServicioReactivacion" name="txtIdPuntosServicioReactivacion" type="text" class="input-small" readonly>
        </div>
       <div class="input-prepend">
          <span class="add-on">FECHA REACTIVACIÓN</span>
          <input id="fechaInicioServicioReactivacion" name="fechaInicioServicioReactivacion" type="text" class="input-medium"  >
        </div>


    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>

        <button type="button" class="btn btn-primary" onclick='reactivarPuntoServicio();'>Guardar Cambios</button>
      </div>
    </div>  <!-- FIN MODAL reactivacion punto de servicio-->

    <!-- modal para dar de alta la requisicion de los puntos de servicios que no tienen alta previa -->

    <div id="modalPlantillaAlta" name="modalPlantillaAlta" class="modalPlantilla hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" >
        <div id="msgModalPlantillaAlta" id="msgModalPlantillaAlta">
        </div>
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Requisición personal</h4>
      </div>

      <div class="modal-body-plantilla">
        <div class="input-prepend">
          <span class="add-on">Folio</span>
          <input class="input-mini" id="txtFolioRequisicionAlta" name="txtFolioRequisicionAlta" type="h" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">idPunto</span>
          <input class="input-mini-mini" id="txtPuntoServicioIdAlta" name="txtPuntoServicioIdAlta" type="text" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">Cliente</span>
          <input class="input-xlarge" id="txtClienteModalAlta" name="txtClienteModalAlta" type="text" readonly>
        </div>

        <div class="input-prepend">
          <span class="add-on">Punto Servicio</span>
          <input class="input-xlarge" id="txtPuntoServicioModalAlta" name="txtPuntoServicioModalAlta" type="text" readonly>
        </div>
        <br>
        <div class="input-prepend">
        <div class="input-prepend">

          <span class="add-on">Fecha Inicio Punto Servicio</span>

          <input class="input-medium" id="txtFechaInicioPuntoServicioAlta" name="txtFechaInicioPuntoServicioAlta" type="text" readonly>

          <span class="add-on">Fecha Monjate</span>

          <input class="input-medium" id="txtFechaInicioRequisicionAlta" name="txtFechaInicioRequisicionAlta" type="text" >
        </div>
        <br>
        <div class="input-prepend">
          <span class="add-on">Fecha Termino Punto Servicio</span>

          <input class="input-medium" id="txtFechaTerminoPuntoServicioAlta" name="txtFechaTerminoPuntoServicioAlta" type="text" readonly>
          <span class="add-on">Fecha Termino</span>

          <input class="input-medium" id="txtFechaTerminoRequisicionAlta" name="txtFechaTerminoRequisicionAlta" type="text" >
        </div>
        <br>
          <div class="input-prepend">
          <span class="add-on">LINEA NEGOCIO</span>

          <input class="input-medium" id="txtLineaNegocioRequisicionAlta" name="txtLineaNegocioRequisicionAlta" type="text" readonly value="1">
           <input id="txtCobraDescansoRA" name="txtCobraDescansoRA" type="hidden" />
          <input id="txtCobraFestivoRA" name="txtCobraFestivoRA" type="hidden" />
          <input id="txtCobra31RA" name="txtCobra31RA" type="hidden" />
        </div>

        </div>

  <div id="divSeguridadFisica" align="left">

        <div class="input-prepend">
        <span class="add-on">Tipo Turno</span>
        <select id="selectTurnoRequisicionAlta" name="selectTurnoRequisicionAlta" class="input-large " onchange="limpiarDatosAlta();mostrarRolOperativoAlta();">
                    <option>TURNO</option>
                      <?php
for ($i = 0; $i < count($catalogoTurnos); $i++) {
    echo "<option value='" . $catalogoTurnos[$i]["idTipoTurno"] . "' >" . $catalogoTurnos[$i]["descripcionTurno"] . " </option>";
}
?>
        </select>
        <input id="rolOpNuevo" name="rolOpNuevo" type="hidden" />
      </div>


      <div class="input-prepend" id="divSelectRolOperativoAlta" name='divSelectRolOperativoAlta'>

      </div>

      <div class="input-prepend">
        <span class="add-on">No.Elementos</span>
        <input class="input-mini-mini" id="txtNumeroElementosAlta" name="txtNumeroElementosAlta" type="text"  onchange="calcularTurnosDiariosAlta();">
      </div>

      <div class="input-prepend">
        <span class="add-on">Puesto</span>
        <select id="selectPuestoRequisicionAlta" name="selectPuestoRequisicionAlta" class="input-large ">
            </select>
      </div>

      <br>

      <div class="input-prepend">
        <span class="add-on">Turnos a cubrir x Día</span>

        <input class="input-mini-mini" id="txtTurnosDiariosAlta" name="txtTurnosDiariosAlta" type="text" readonly>
      </div>

      <div class="input-prepend">
        <span class="add-on">Turnos a cubrir x Mes</span>

        <input class="input-mini-mini" id="txtTurnosMensualesAlta" name="txtTurnosMensualesAlta" type="text" readonly>
      </div>

      <div class="input-prepend">
          <span class="add-on">Total Factura</span>
          <input class="input-small" id="txtTotalFacturaAlta" name="txtTotalFacturaAlta" type="text" onchange="calcularCostoTurnoAlta();" >
      </div>
      <div class="input-prepend">
          <span class="add-on">Subtotal</span>
          <input class="input-small" id="txtSubtotalAlta" name="txtSubtotalAlta" type="text" readonly>
      </div>
      <div class="input-prepend">
          <span class="add-on">IVA</span>
          <input class="input-small" id="txtIvaAlta" name="txtIvaAlta" type="text" readonly>
      </div>
      <div class="input-prepend">
          <span class="add-on">Costo Turno</span>
          <input class="input-small" id="txtCostoTurnoAlta" name="txtCostoTurnoAlta" type="text" readonly>
      </div>

      <div class="input-prepend">
        <span class="add-on">Comentarios de perfil</span>

        <textarea  id="txtComentariosRequisicionAlta" name="txtComentariosRequisicionAlta" class="txtAreaComentarios" rows="5" ></textarea>
      </div>

       <div class="input-prepend">
        <span class="add-on">Recursos Materiales</span>

        <textarea  id="txtRecursosMaterialesAlta" name="txtRecursosMaterialesAlta" class="txtAreaComentarios" rows="5" ></textarea>
      </div>

  </div> <!-- FIN divSeguridadElectronica-->

    <br>
    <br>
  <div class="modal-footer">
      <button type="button" class="btn btn-primary" onclick="guardarPlantillaAlta();">Guardar</button>
  </div>
  <br>
    <div class="hero-unit" id="listPlantillaAlta" name="listPlantillaAlta">
      <h1>Requisición</h1>
    </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-success" onclick="generadorFormatoRequisicionAlta();">Formato</button>
      </div>

  </div> <!-- fin modal body-->

</div><!--  fin modal para dar de alta la requisicion de los puntos de servicios que no tienen alta previa -->

<!-- Modal -->
<div id="modalEditarPunto" name="modalEditarPunto" class="modalEdit2 hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">

      <div id="alertMsg1PE">
      </div>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Edicion de punto de servicio</h3>
  </div>
  <div class="modal-body-punto">
    <table>

  <tr>
    <td> <label class="control-label1 label" for="rfc">Cliente</label></td>
    <td>
             <select id="clienteE" name="clienteE" class="input-xlarge " onChange="" disabled>
                <option>CLIENTE</option>

                 <?php
for ($i = 0; $i < count($catalogoClientes); $i++) {
    echo "<option value='" . $catalogoClientes[$i]["idCliente"] . "'>" . $catalogoClientes[$i]["razonSocial"] . " </option>";
}
?>

            </select>
    </td>
    <td rowspan='5'>
        <div>
                <!-- List group -->
                <ul class="list-group">

                    <li class="list-group-item">
                        Cobra Descanso
                        <div class="material-switch pull-right">
                            <input id="someSwitchOptionSuccess1" name="cobraDescansoE" type="checkbox"/>
                            <label for="someSwitchOptionSuccess1" class="label-success1"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Cobra Dia Festivo
                        <div class="material-switch pull-right">
                            <input id="someSwitchOptionInfo1" name="cobraDiaFestivoE" type="checkbox"/>
                            <label for="someSwitchOptionInfo1" class="label-success1"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Cobra Dia 31
                        <div class="material-switch pull-right">
                            <input id="someSwitchOptionWarning1" name="cobraDia31E" type="checkbox"/>
                            <label for="someSwitchOptionWarning1" class="label-success1"></label>
                        </div>
                    </li>

                </ul>
            </div>
        </td>
  </tr>
  <tr>
    <tr>
      <td><label class="control-label1 label" for="puntoServicio">Id Punto Servicio</label></td>
      <td><input id="txtIdPuntoServicioE" name="txtIdPuntoServicioE" type="text" class="input-xlarge" readonly></td>
    </tr>
    <td><label class="control-label1 label" for="centroCosto">No. Centro Costo</label></td>

    <td><input id="txtNumeroCentroE" name="txtNumeroCentroE" type="text" class="input-xlarge" required="hey" maxlength="8"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="puntoServicio">Nombre Punto Servicio</label></td>
    <td><input id="txtPuntoServicioE" name="txtPuntoServicioE" type="text" class="input-xlarge" required="hey"></td>
  </tr>
 <tr>
    <td><label class="control-label1 label" for="lineNegocio">Line de Negocio</label></td>
    <td> <select id="selLineaNegocioEdited" name="selLineaNegocioEdited" class="input-xlarge">
                <option value="0">LINEA DE NEGOCIO</option>
                <?php
              for ($i=0; $i<count($catalogoLineaNegocioRegistroPunto); $i++)
              {
                echo "<option value='". $catalogoLineaNegocioRegistroPunto[$i]["idLineaNegocio"]."'>". $catalogoLineaNegocioRegistroPunto[$i]["descripcionLineaNegocio"] ." </option>";
              }
              ?>
        </select></td>
  </tr>
   <tr><td> <label class="control-label1 label" for="txtLocalizacionEdited">Localizacion</label></td>
    <td>
       <select id="entidadEdited" name="entidadEdited" class="input-xlarge " onChange="">
               
        </select>
      </td>
  </tr>

  <tr><td> <label class="control-label1 label" for="txtLocalizacion">Region</label></td>
    <td><input id="txtRegionEdited" name="txtRegionEdited" type="text" class="input-xlarge" readonly>
      <input id="idtxtRegionEdited" name="idtxtRegionEdited" type="hidden"></td>
  </tr>
  <tr>
    <td> <label class="control-label1 label" for="direccion">Dirección</label></td>
    <td><textarea id="txtDireccionE" name="txtDireccionE" class="txtAreaEdited" required="hey"></textarea></td>
    <td rowspan="2">
      <label class="control-label1 label" for="latitud">Latitud</label>
      <input id="txtLatitudE" name="txtLatitudE" type="text" class="input-medium" maxlength="15"><br>
      <label class="control-label1 label" for="latitud">Longitud</label>
      <input id="txtLongitudE" name="txtLongitudE" type="text" class="input-medium" maxlength="15">
    </td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="fechaInicio">Fecha Inicio</label></td>
    <td><input id="txtFechaInicioE" name="txtFechaInicioE" type="text" class="input-medium" required="hey"></td>

  </tr>
  <tr><td><label class="control-label1 label" for="fechaInicio">Fecha Termino</label></td>
    <td><input id="txtFechaTerminoServicioE" name="txtFechaTerminoServicioE" type="text" class="input-medium" required="hey"></td>
  </tr>

  <tr><td colspan="3" align="center"> <label  align="center" class="label label-info" for="direccion">Contacto Administrativo</label></td></tr>
  <tr>
    <td><label class="control-label1 label" for="contactoFacturacion">Contacto Facturacion</label></td>
    <td><input id="txtContactoFacturacionE" name="txtContactoFacturacionE" type="text" class="input-xlarge"></td>
    <td rowspan='5'>
      <table>
        <tr>
        <td colspan="2"><label style="margin-left: 50px" class="control-label1 label" for="contactoFacturacion">Turnos Presupuestados</label></tr></td>
        <tr><td><div>
                <!-- List group -->

                <ul class="list-group">

                    <li class="list-group-item">
                        Turnos FLAT &nbsp&nbsp
                        <div class="material-switch pull-right">
                            <input id="valorFlatE" name="valorFlatE" type="checkbox"/>
                            <label style="margin-top: 10px" for="valorFlatE" class="label-success1"></label>
                        </div>
                    </li>

                </ul>
            </div></td>

              <span>Si no lo seleccionas, los turnos presupuestados los calculará como MES NATURAL</span>

          </tr>
           
      </table>
    </td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="correoFacturacion">Correo Facturacion</label></td>
    <td><input id="txtCorreoFacturacionE" name="txtCorreoFacturacionE" type="text" class="input-xlarge-email"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="telefonoFijoFacturacion">Tel Fijo Facturacion</label></td>
    <td><input id="txtTelefonoFijoFacturacionE" name="txtTelefonoFijoFacturacionE" type="text" class="input-medium"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="telefonoMovilFacturacion">Tel Movil Facturacion</label></td>
    <td><input id="txtTelefonoMovilFacturacionE" name="txtTelefonoMovilFacturacionE" type="text" class="input-medium"></td>
  </tr>
    <tr>
    <td><label class="control-label1 label" for="telefonoMovilFacturacion">Terminos Facturación  </label></td>
    <td><textarea id="txtTerminosFacturacionE" name="txtTerminosFacturacionE" class="txtAreaEdited" required="hey"></textarea></td>
  </tr>
  <tr><td colspan="3" align="center"> <label  align="center" class="label label-info" for="direccion">Contacto Tesoreria</label></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="contactoTesoreria">Contacto Tesoreria</label></td>
    <td><input id="txtContactoTesoreriaE" name="txtContactoTesoreriaE" type="text" class="input-xlarge"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="correo">Correo Tesoreria</label></td>
    <td><input id="txtCorreoTesoreriaE" name="txtCorreoTesoreriaE" type="text" class="input-xlarge-emaile"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="telefonoFijoTesoreria">Tel Fijo Tesoreria</label></td>
    <td><input id="txtTelefonoFijoTesoreriaE" name="txtTelefonoFijoTesoreriaE" type="text" class="input-medium"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="telefonoMovilTesoreria">Tel Movil Tesoreria</label></td>
    <td><input id="txtTelefonoMovilTesoreriaE" name="txtTelefonoMovilTesoreriaE" required="hey" type="text" class="input-medium"></td>
  </tr>
  <tr><td colspan="3" align="center"> <label  align="center" class="label label-info" for="direccion">Contacto Operativo</label></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="contactoOperativo">Contacto Operativo</label></td>
    <td><input id="txtContactoOperativoE" name="txtContactoOperativoE" type="text" class="input-xlarge"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="correo">Correo Operativo</label></td>
    <td><input id="txtCorreoOperativoE" name="txtCorreoOperativoE" type="text" class="input-xlarge-email"></td></tr>
  <tr>
    <td><label class="control-label1 label" for="telefonoFijoOperativo">Tel Fijo Operativo</label></td>
    <td><input id="txtTelefonoFijoOperativoE" name="txtTelefonoFijoOperativoE" type="text" class="input-medium"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="telefonoMovilOperativo">Tel Movil Operativo</label></td>
    <td><input id="txtTelefonoMovilOperativoE" name="txtTelefonoMovilOperativoE" required="hey" type="text" class="input-medium"></td>
  </tr>
    <!--<tr><td  colspan="3" align="center"><button id="btnmostrarModal" name="btnmostrarModal" class="btn btn-primary" type="button" onclick="mostrarModal();"> <span class="glyphicon glyphicon-floppy-save"></span>Guardar</button></td></tr>
  -->
  </table>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>

    <button type="button" class="btn btn-primary" onclick="updatePuntosServicio();">Guardar</button>
  </div>
</div> <!--  fin modal edicion punto de servicio -->

</div>
</form>
</div>
<div class="containerTablePuntos"  align="left">
        <section>

            <table id="tablePuntosServicios" class="display" cellspacing="0" width="150%">
                <thead>
                    <tr>
                        <th>#CENTRO COSTO</th>
                        <th>ID PUNTO</th>
                        <th>PUNTO SERVICIO</th>
                        <th>CLIENTE</th>
                        <th>UBICACIÓN</th>
                        <th>DIRECCIÓN</th>
                        <th>TERMINAR SERVICIO</th>
                        <th>EDITAR</th>
                        <th>PLANTILLA</th>
                        </tr>
                </thead>

                <tbody></tbody>

            </table>

        </section>

</div>

<script type="text/javascript">

var tableServicios = null;

function mostrarModalTerminoServicio(idPuntoServicio, puntoServicio){

     $('#myModalBajaPuntoServicio').modal();
     $("#txtPuntoServicioM").val(puntoServicio);
     $("#txtIdPuntoBaja").val(idPuntoServicio);
     var currentDate = $.datepicker.formatDate('yy-mm-dd', new Date());
     $("#txtFechaBajaPuntoServicio").val(currentDate);

  }

  function mostrarModalReactivacionPuntoServicio(idPuntoServicio, puntoServicio){

     $('#myModalReactivarPuntoServicio').modal();
     $("#txtPuntoServicioReactivacion").val(puntoServicio);
     $("#txtIdPuntosServicioReactivacion").val(idPuntoServicio);
     var currentDate = $.datepicker.formatDate('yy-mm-dd', new Date());
     $("#fechaInicioServicioReactivacion").val(currentDate);

  }

//funcion para dar de baja un punto de servicio
    function actualizaEstatusPuntoServicio ()
    {

      var idPuntoServicio=$("#txtIdPuntoBaja").val();
      var esatusPunto=0;
      var fechaTerminoServicio=$("#txtFechaBajaPuntoServicio").val();

        $.ajax({
            type: "POST",
            url: "ajax_actualizaEstatusPuntoServicio.php",
            data: {"idPuntoServicio": idPuntoServicio,"esatusPunto":esatusPunto, "fechaTerminoServicio":fechaTerminoServicio },
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;

                if (response.status=="success") {

                    alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+mensaje+"</strong> <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#alertMsgBajaModal").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                    $('#myModalBajaPuntoServicio').modal('hide');

                    styleTablePuntosServicios();

                } else if (response.status=="error")
                {
                  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+mensaje+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#alertMsgBajaModal").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                }
              },
            error: function(){
                  alert('error handing here');
            }
        });
    }

    function reactivarPuntoServicio ()
    {

      var idPuntoServicio=$("#txtIdPuntosServicioReactivacion").val();
      var esatusPunto=1;
      var fechaInicioServicio=$("#fechaInicioServicioReactivacion").val();

        $.ajax({
            type: "POST",
            url: "ajax_reactivarPuntoServicio.php",
            data: {"idPuntoServicio": idPuntoServicio,"esatusPunto":esatusPunto, "fechaInicioServicio":fechaInicioServicio },
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;

                if (response.status=="success") {

                    alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+mensaje+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#alertMsgReactivacion").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                    $('#myModalReactivarPuntoServicio').modal('hide');

                    styleTablePuntosServicios();

                } else if (response.status=="error")
                {
                  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+mensaje+" </strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#alertMsgReactivacion").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                }
              },
            error: function(){
                  alert('error handing here');
            }
        });
    }

  function mostrarModalPlantilla(puntoServicioId, razonSocial, puntoServicio,cobraDescansos, cobraDiaFestivo,cobra31, fechaInicioServicio, fechaTerminoServicio){

    $('#modalPlantillaAlta').modal();
    limpiarFormularioRequisicionAlta();
    //document.getElementById("listPlantillaModalServicio").innerHTML="";
    $("#divSelectRolOperativoAlta").html("");
    obtenerNumeroRequisicionAlta();
    //consultaRequisicionAlta();

    consultaRequisicion1(puntoServicioId);


    $("#txtPuntoServicioModalAlta").val(puntoServicio);
    $("#txtPuntoServicioIdAlta").val(puntoServicioId);
    $("#txtClienteModalAlta").val(razonSocial);
    $("#txtLineaNegocioRequisicionAlta").val("SEGURIDAD FISICA");
    $("#txtFechaInicioPuntoServicioAlta").val(fechaInicioServicio);
    $("#txtFechaTerminoPuntoServicioAlta").val(fechaTerminoServicio);

    $("#txtFechaTerminoRequisicionAlta").val(fechaTerminoServicio);

    if(cobraDescansos==""){
      cobraDescansos=0;
    }
    if(cobraDiaFestivo==""){
      cobraDiaFestivo=0;
    }
    if(cobra31==""){
      cobra31=0;
    }

    $("#txtCobraDescansoRA").val(cobraDescansos);
    $("#txtCobraFestivoRA").val(cobraDiaFestivo);
    $("#txtCobra31RA").val(cobra31);

    //$("#txtFechaInicioRequisicion").val(fechaInicio);


    var currentDate = $.datepicker.formatDate('yy-mm-dd', new Date());
    $('#txtFechaInicioRequisicionAlta').val(currentDate);

  }

  function obtenerNumeroRequisicionAlta()
    {

      $.ajax({
            type: "POST",
            url: "ajax_obtenerFolioRequisicion.php",
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                    //alert(response);
                    var folioRequisicion = response.folioRequisicion.folioRequisicion;
                    $("#txtFolioRequisicionAlta").val(folioRequisicion);
                    //consultaRequisicion();

                }
            },
            error: function (response)
            {
                console.log (response);
            }
        });

    }

function styleTablePuntosServicios(){
  //alert("HOLA");

  if (tableServicios != null)
        {
            tableServicios.destroy ();

        }

        tableServicios = $('#tablePuntosServicios').DataTable( {
        ajax: {
            url: 'ajax_obtenerPuntosServiciosTable.php'
            ,type: 'POST'
            //,data : {"estatusEmpleado":2}
        }
        ,"columns": [
            { "data": "numeroCentroCosto"}
            ,{ "data": "idPuntoServicio" }
            ,{ "data": "puntoServicio" }
            ,{ "data": "razonSocial" }
            ,{ "data": "nombreEntidadFederativa" }
            ,{ "data": "direccionPuntoServicio" }
            ,{ "data": "accion_baja_punto" }
            ,{ "data": "accion_edita_punto" }
            ,{ "data": "accion_ver_plantilla" }

       ]
        //,serverSide: true
        ,processing: true
        ,"bPaginate": false


    } );

}

  function limpiarDatosAlta(){
      $("#txtNumeroElementosAlta").val("");
      $("#txtTurnosDiariosAlta").val("");
      $("#txtTurnosMensualesAlta").val("");
      $("#txtTotalFacturaAlta").val("");
      $("#txtIvaAlta").val("");
      $("#txtCostoTurnoAlta").val("");

    }

  function limpiarDatosEdited(){
      $("#txtNumeroElementosEdited").val("");
      $("#txtTurnosDiariosEdited").val("");
      $("#txtTurnosMensualesEdited").val("");
      $("#txtTotalFacturaEdited").val("");
      $("#txtIvaEdited").val("");
      $("#txtCostoTurnoEdited").val("");

    }


//obtiene el catalogo de puestos para dar de alta la requisicion
    function seleccionarPuestoAlta()
    {
       var valorTipo ="03";
       var lineaNegocio = 1;

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

                    $("#selectPuestoRequisicionAlta").html (puestosOptions);
                }
            },
            error: function (response)
            {
                console.log (response);
            }
        });
    }


    function seleccionarPuestoEdited()
    {

       var valorTipo ="03";
       var lineaNegocio = 1;

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

                    $("#selectPuestoRequisicionEdited").html (puestosOptions);
                }
            },
            error: function (response)
            {
                console.log (response);
            }
        });
    }

//funcio para calcular turnos al dia y al mes
// segun el tipo de turno seleccionado seran los turnos a cubrir al dia presupuestando por 30 dias al mes
    function calcularTurnosDiariosEdited(){
      var tipoTurno= $("#selectTurnoRequisicionEdited").val();
      var numeroElementos=$("#txtNumeroElementosEdited").val();
      var turnosMensuales=0;
      $("#txtTotalFacturaEdited").val("");
      $("#txtIvaEdited").val("");
      $("#txtCostoTurnoEdited").val("");
      $("#txtSubtotalEdited").val("");


      if (tipoTurno==2){

      if(numeroElementos % 2 == 0) {
        $("#txtTurnosDiariosEdited").val(numeroElementos);
        turnosMensuales=numeroElementos*30;
        $("#txtTurnosMensualesEdited").val(turnosMensuales);

        }
        else {
        alert("El numero de elementos para turno de 24x24 no debe ser menor a 1 y debe ser multiplos de 2");

        }
      }else if(tipoTurno==1){
        $("#txtTurnosDiariosEdited").val(numeroElementos);
        turnosMensuales=numeroElementos*30;
        $("#txtTurnosMensualesEdited").val(turnosMensuales);

      }else if(tipoTurno==6){

        if(numeroElementos % 3 == 0) {

         turnosDiarios=(numeroElementos*3)/3;
        $("#txtTurnosDiariosEdited").val(turnosDiarios);
        turnosMensuales=turnosDiarios*30;
        $("#txtTurnosMensualesEdited").val(turnosMensuales);

        }
        else {
        alert("El numero de elementos para turno de 12X24 no debe ser menor a 3 y debe ser multiplos de 3");

        }
     }else if(tipoTurno==3){


        if(numeroElementos % 4 == 0) {
        turnosDiarios=(numeroElementos*2)/4;
        $("#txtTurnosDiariosEdited").val(turnosDiarios);
        turnosMensuales=turnosDiarios*30;
        $("#txtTurnosMensualesEdited").val(turnosMensuales);

        }
        else {
        alert("El numero de elementos para turno de 12x36 no debe ser menor a 4 y debe ser multiplos de 4");

        }

      }
    }

    function calcularTurnosDiariosAlta(){
      var tipoTurno= $("#selectTurnoRequisicionAlta").val();
      var numeroElementos=$("#txtNumeroElementosAlta").val();
      var turnosMensuales=0;
      $("#txtTotalFacturaAlta").val("");
      $("#txtIvaAlta").val("");
      $("#txtCostoTurnoAlta").val("");
      $("#txtSubtotalAlta").val("");


      if (tipoTurno==2){

      if(numeroElementos % 2 == 0) {
        $("#txtTurnosDiariosAlta").val(numeroElementos);
        turnosMensuales=numeroElementos*30;
        $("#txtTurnosMensualesAlta").val(turnosMensuales);

        }
        else {
        alert("El numero de elementos para turno de 24x24 no debe ser menor a 1 y debe ser multiplos de 2");

        }
      }else if(tipoTurno==1){
        $("#txtTurnosDiariosAlta").val(numeroElementos);
        turnosMensuales=numeroElementos*30;
        $("#txtTurnosMensualesAlta").val(turnosMensuales);

      }else if(tipoTurno==6){
       
        if((numeroElementos % 3) == 0) {

 turnosDiarios=((numeroElementos*3)/3);
        $("#txtTurnosDiariosAlta").val(turnosDiarios);
        turnosMensuales=turnosDiarios*30;
        $("#txtTurnosMensualesAlta").val(turnosMensuales);

        }
        else {
        alert("El numero de elementos para turno de 12X24 no debe ser menor a 3 y debe ser multiplos de 3");

        }
     }else if(tipoTurno==3){



        if(numeroElementos % 4 == 0) {

          turnosDiarios=(numeroElementos*2)/4;
        $("#txtTurnosDiariosAlta").val(turnosDiarios);
        turnosMensuales=turnosDiarios*30;
        $("#txtTurnosMensualesAlta").val(turnosMensuales);

        }
        else {
        alert("El numero de elementos para turno de 12x36 no debe ser menor a 4 y debe ser multiplos de 4");

        }

      }
    }


    function calcularCostoTurnoAlta(){
      var costoFactura=$("#txtTotalFacturaAlta").val();
      var tipoTurno=$("#selectTurnoRequisicionAlta").val();
      var turnosMensuales=$("#txtTurnosMensualesAlta").val();

      var subtotal=costoFactura/1.16;
      var iva=subtotal*0.16;

      var costoTurno=0;

      var costoTurno=subtotal/turnosMensuales;

        $("#txtIvaAlta").val(formatter.format(iva));
        $("#txtCostoTurnoAlta").val(formatter.format(costoTurno));
        $("#txtSubtotalAlta").val(formatter.format(subtotal));

    }

    function calcularCostoTurnoEdited(){
      var costoFactura=$("#txtTotalFacturaEdited").val();
      var tipoTurno=$("#selectTurnoRequisicionEdited").val();
      var turnosMensuales=$("#txtTurnosMensualesEdited").val();

      var subtotal=costoFactura/1.16;
      var iva=subtotal*0.16;

      var costoTurno=0;

      var costoTurno=subtotal/turnosMensuales;

        $("#txtIvaEdited").val(formatter.format(iva));
        $("#txtCostoTurnoEdited").val(formatter.format(costoTurno));
        $("#txtSubtotalEdited").val(formatter.format(subtotal));

    }


    function guardarPlantillaAlta()
  {
        var diaDescanso=$("#txtCobraDescansoRA").val();
        var diaFestivo=$("#txtCobraFestivoRA").val();
        var dia31=$("#txtCobra31RA").val();

        var tipoRequisicion=1;

        var datastring = $("#form_catalogoPuntosServicios").serialize();

            datastring += "&diaDescanso=" + diaDescanso;
            datastring += "&diaFestivo=" + diaFestivo;
            datastring += "&dia31=" + dia31;
            datastring += "&tipoRequisicion=" + tipoRequisicion;
            var alertMsg1="";
        //console.log(datastring);
        $.ajax({
            type: "POST",
            url: "ajax_registroPlantillaAlta.php",
            data: datastring,
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;

                if (response.status=="success") {

                    alertMsg1="<div id='msgAlertPlant' class='alert alert-success'><trong>Requisicion:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#msgModalPlantillaAlta").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlertPlant').delay(3000).fadeOut('slow');

                    limpiarFormularioRequisicionAlta();
                    consultaRequisicionAlta();


                    //$( "#cliente" ).val("CLIENTE");
                    //document.getElementById("form_registroPuntoServicio").reset();
                    //obtenerUltimoNueroOrden();

                } else if (response.status=="error")
                {
                  alertMsg1="<div id='msgAlertPlant' class='alert alert-error'><strong>Error en el registro:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#msgModalPlantillaAlta").html(alertMsg1);
                    $('#msgAlertPlant').delay(3000).fadeOut('slow');
                    //mostrarModalMediosComunicacion();
                }
              },error : function (jqXHR, textStatus, errorThrown)
            {
                alert(jqXHR.responseText);
            }
        });
  }

  function editarRequisicion()
  {

        var diaDescanso=$("#txtCobraDescansoE").val();
        var diaFestivo=$("#txtCobraFestivoE").val();
        var dia31=$("#txtCobra31E").val();

        var tipoRequisicion=1;
        var idRequisicion=$("#txtIdRequisicion").val();

      if(diaDescanso==""){

          diaDescanso=0;

        }

        if(diaFestivo==""){

          diaFestivo=0;

        }

        if(dia31==""){

          dia31=0;

        }




        var datastring = $("#form_catalogoPuntosServicios").serialize();

            datastring += "&diaDescanso=" + diaDescanso;
            datastring += "&diaFestivo=" + diaFestivo;
            datastring += "&dia31=" + dia31;
            datastring += "&tipoRequisicion=" + tipoRequisicion;
            datastring += "&idRequisicion=" + idRequisicion;


            var alertMsg1="";

        $.ajax({
            type: "POST",
            url: "ajax_updateRequisicion.php",
            data: datastring,
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;

                if (response.status=="success") {

                    alertMsg1="<div id='msgAlertPlant' class='alert alert-success'><trong>Edicion:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#msgEdicionReq").html(alertMsg1);
                    $('#msgAlertPlant').delay(3000).fadeOut('slow');

                    //limpiarFormularioRequisicionAlta();
                    //consultaRequisicionAlta();
                    $("#modalEditarPlantilla").modal('hide');

                    mostrarPlantillaEdited();

                    //$( "#cliente" ).val("CLIENTE");
                    //document.getElementById("form_registroPuntoServicio").reset();
                    //obtenerUltimoNueroOrden();

                } else if (response.status=="error")
                {
                  alertMsg1="<div id='msgAlertPlant' class='alert alert-error'><strong>Error en la edición:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#msgEdicionReq").html(alertMsg1);
                    $('#msgAlertPlant').delay(3000).fadeOut('slow');
                    //mostrarModalMediosComunicacion();
                }

             },error : function (jqXHR, textStatus, errorThrown)
            {
                alert(jqXHR.responseText);
}
        });
  }

  function limpiarFormularioRequisicionAlta(){

  $("#txtNumeroElementosAlta").val("");
  $("#selectTurnoRequisicionAlta").val("TURNO");
  $("#selectPuestoRequisicionAlta").val("PUESTO");
  $("#txtTurnosDiariosAlta").val("");
  $("#txtCostoTurnoAlta").val("");
  $("#txtComentariosRequisicionAlta").val("");
  $("#txtTurnosMensualesAlta").val("");
  $("#txtTotalFacturaAlta").val("");
  $("#txtRecursosMaterialesAlta").val("");
  $("#txtIvaAlta").val("");
  $("#txtSubtotalAlta").val("");
  //$("#txtFechaTerminoRequisicionAlta").val("");

}

// esta funcion consulta la requisicon del punto de servicio y la muestra dentro del mismo formulario
//cada vez que se da de alta un nuevo requerimiento desde el modal. Reutiliza la funcion consultaRequisicion1
function consultaRequisicionAlta()
{
    var puntoServicioId=$("#txtPuntoServicioIdAlta").val();

    consultaRequisicion1(puntoServicioId);
}

function limpiarCerrarAlta(){

  document.getElementById("listPlantillaAlta").innerHTML="";


}

function generadorFormatoRequisicionAlta()
    {
      var idPuntoServicio=$("#txtPuntoServicioIdAlta").val();
      var folio=$("#txtFolioRequisicionAlta").val();

      window.open("generadorFormatoRequisicionAlta.php?idPuntoServicio="+idPuntoServicio+"&folio="+folio+"",'_blank','fullscreen=no');
      //parent.opener=top;
      //opener.close();

    }

    function aumentaPlantilla(servicioPlantillaId,subtotal,costoPorTurno,numeroElementos,tipoTurnoPlantillaId,iva)
    {

      var servicioPlantillaId=servicioPlantillaId;

      var costoPorTurno=costoPorTurno;
      var numeroElementos=numeroElementos;
      var tipoTurnoPlantillaId=tipoTurnoPlantillaId;
      var turnosMensuales=0;
      var turnosPorDia=0;
      var subtotal=subtotal;
      var iva=iva;
      var costoNetoFactura=0;
      var subtotal2=0;
      var iva2=0;

      //alert("numero elementos:"+numeroElementos+", turnos mensuales:"+turnosMensuales);


      if (tipoTurnoPlantillaId==1){

        numeroElementos=numeroElementos+1;
        turnosMensuales=numeroElementos*30;
        turnosPorDia=numeroElementos;

        subtotal2=costoPorTurno*turnosMensuales;

        iva2=(subtotal2*iva)/subtotal;

        costoNetoFactura=iva2+subtotal2;

        //alert("numero elementos:"+numeroElementos+", turnos mensuales:"+turnosMensuales+", turnos por dia:"+turnosPorDia+", subtotal: "+subtotal2+ ",iva:"+iva2+", total:"+costoNetoFactura);
        //alert("numero elementos:"+numeroElementos+", turnos mensuales:"+turnosMensuales);

      }else if (tipoTurnoPlantillaId==2){
        numeroElementos=numeroElementos+2;
        turnosPorDia=numeroElementos;
        turnosMensuales=numeroElementos*30;

        subtotal2=costoPorTurno*turnosMensuales;

        iva2=(subtotal2*iva)/subtotal;

        costoNetoFactura=iva2+subtotal2;
        //alert("numero elementos:"+numeroElementos+", turnos mensuales:"+turnosMensuales+", turnos por dia:"+turnosPorDia+", subtotal: "+subtotal2+ ",iva:"+iva2+", total:"+costoNetoFactura);

      }
      else if (tipoTurnoPlantillaId==3){
        numeroElementos=numeroElementos+4;
        turnosPorDia=(numeroElementos*2)/4;
        turnosMensuales=turnosPorDia*30;

        subtotal2=costoPorTurno*turnosMensuales;

        iva2=(subtotal2*iva)/subtotal;

        costoNetoFactura=iva2+subtotal2;
        //alert("numero elementos:"+numeroElementos+", turnos mensuales:"+turnosMensuales+", turnos por dia:"+turnosPorDia+", subtotal: "+subtotal2+ ",iva:"+iva2+", total:"+costoNetoFactura);

      }
      else if (tipoTurnoPlantillaId==6){
        numeroElementos=numeroElementos+3;
        turnosPorDia=(numeroElementos*2)/3;
        turnosMensuales=turnosPorDia*30;

        subtotal2=costoPorTurno*turnosMensuales;

        iva2=(subtotal2*iva)/subtotal;

        costoNetoFactura=iva2+subtotal2;
        //alert("numero elementos:"+numeroElementos+", turnos mensuales:"+turnosMensuales+", turnos por dia:"+turnosPorDia+", subtotal: "+subtotal2+ ",iva:"+iva2+", total:"+costoNetoFactura);


      }

      $.ajax({
            type: "POST",
            url: "ajax_incrementaPlantilla.php",
            data: {"numeroElementos":numeroElementos, "turnosPorDia":turnosPorDia, "costoNetoFactura":costoNetoFactura, "servicioPlantillaId":servicioPlantillaId },
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;

                if (response.status=="success") {

                  alertMsg1="<div id='msgAlertPlant' class='alert alert-success'><trong>Requisicion:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#msgModalPlantillaAlta").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlertPlant').delay(3000).fadeOut('slow');

                    consultaRequisicionAlta();

                    //$( "#cliente" ).val("CLIENTE");
                    //document.getElementById("form_registroPuntoServicio").reset();
                    //obtenerUltimoNueroOrden();

                } else if (response.status=="error")
                {
                  alertMsg1="<div id='msgAlertPlant' class='alert alert-error'><strong>Error en el registro:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#msgModalPlantillaAlta").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlertPlant').delay(3000).fadeOut('slow');
                    //mostrarModalMediosComunicacion();
                }
              },
            error: function(){
                  alert('error handing here');

            }
        });

    }

function consultaRequisicion1(puntoServicioId)
{
  var puntoServicio=puntoServicioId;
 $.ajax({

            type: "POST",
            url: "ajax_consultaRequisicion.php",
           data:{"puntoServicio":puntoServicio},
            dataType: "json",
             success: function(response) {
                if (response.status == "success")
                {

                    var lista = response.lista;

                    document.getElementById("listPlantillaAlta").innerHTML="";

                    listaRequisicionTable="<table  class='table table-hover' id='Exportar_a_Excel_requisicion'><thead  style='color:#456789;font-size:100%;'><th>Cantidad</th><th>Concepto</th><th>Turnos x Dia</th><th>T. Mes</th><th>Costo x turno</th><th>Descanso</th><th>Día 31</th><th>Festivo</th><th>Subtotal</th><th>IVA</th><th>Total</th></thead><tbody>";

                    for ( var i = 0; i < lista.length; i++ ){

                      var descripcionPuesto = lista[i].descripcionPuesto;
                      var descripcionTurno = lista[i].descripcionTurno;
                      var numeroElementos=lista[i].numeroElementos;
                      var turnosPorDia=lista[i].turnosPorDia;
                      var costoPorTurno=lista[i].costoPorTurno;
                      var comentarioRequisicion=lista[i].comentarioRequisicion;
                      var tipoTurnoPlantillaId=lista[i].tipoTurnoPlantillaId;
                      var turnosMensuales="";
                      var costoTotalElemento="";
                      var subtotal="";
                      var iva="";
                      var total="";
                      var total1="";
                      var costoNetoFactura=lista[i].costoNetoFactura;
                      var servicioPlantillaId=lista[i].servicioPlantillaId;
                      var puntoServicioPlantillaId=lista[i].puntoServicioPlantillaId;
                      var puntoservicio=lista[i].puntoservicio;
                      var razonSocial=lista[i].razonSocial;
                      var fechaInicio=lista[i].fechaInicio;
                      var fechaTerminoPlantilla=lista[i].fechaTerminoPlantilla;
                      var lineaNegocio="SEGURIDAD FISICA";
                      var puestoPlantillaId=lista[i].puestoPlantillaId;
                      var recursosMateriales=lista[i].recursosMateriales;

                      var cobraDescanso=lista[i].cobraDescansos;
                      var cobraFestivos=lista[i].cobraDiaFestivo;
                      var cobraDia31=lista[i].cobra31;
                      var fechaInicioServicio=lista[i].fechaInicioServicio;
                      var fechaTerminoServicio=lista[i].fechaTerminoServicio;

                      var rolOperativo= lista[i].rolOperativoPlantilla;



                      var cobDescanso="";

                      if (cobraDescanso==1)
                      {
                        cobDescanso="SE COBRA";
                      }else{
                         cobDescanso="NO SE COBRA";
                      }
                      if (cobraFestivos ==1)
                      {
                        cobFestivos="SE COBRA";
                      }else{
                        cobFestivos="NO SE COBRA";
                      }
                      if (cobraDia31 ==1)
                      {
                        cob31="SE COBRA";
                      }else{
                        cob31="NO SE COBRA";
                      }
                        turnosMensuales=turnosPorDia*30;
                        subtotal=turnosMensuales*costoPorTurno;

                        var costoSinIva = costoNetoFactura/1.16;
                        iva = costoNetoFactura - costoSinIva;
                        total=costoNetoFactura;
                        subtotal = costoSinIva;
                        /*
                        console.log ("ServicioPlantillaId:" + servicioPlantillaId);
                        console.log ("CostoNetoFactura:" + costoNetoFactura);
                        console.log ("CostoSinIva:" + costoSinIva);
                        console.log ("Subtotal:" + subtotal);
                        console.log ("IVA:" + iva);
                        console.log ("Total:" + total);
                        console.log ("------------------------");
                        */

                        btnAdd="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/sumaR.png";
                        btnDelete="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/restar.png";
                        btnEditar="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/edit.png";

                      listaRequisicionTable += "<tr style='color:#456789;font-size:80%;'><td>"+numeroElementos+"</td><td>"+descripcionPuesto+" DE "+descripcionTurno+
                      " </td><td>"+turnosPorDia+"</td><td>"+turnosMensuales+"</td><td>"
                      +formatter.format(costoPorTurno)+"</td><td >"+cobDescanso+"</td><td>"+cob31+"</td><td>"+cobFestivos+"</td><td>"+
                      formatter.format(subtotal)+"</td><td>"+formatter.format(iva)+"</td><td>"+formatter.format(total)+"</td><td><img class='cursorImg' src='"+btnAdd+
                      "' data-toggle='tooltip' data-placement='right' title='ADD'  onclick='incrementarPlantilla(\"" +servicioPlantillaId+ "\")'></td><td><img class='cursorImg' src='"+btnDelete+
                      "' data-toggle='tooltip' data-placement='right' title='DISMINUIR' onclick='disminuirPlantilla(\"" + servicioPlantillaId
                        + "\")'></td><td><img class='cursorImg' src='"+btnEditar+
                      "' data-toggle='tooltip' data-placement='right' title='EDITAR' onclick='updatePlantilla("+puntoServicioPlantillaId+",\"" +puntoservicio
                        + "\",\"" +razonSocial+ "\",\"" +fechaInicio+ "\",\"" +fechaTerminoPlantilla+ "\",\"" +lineaNegocio+ "\",\"" +tipoTurnoPlantillaId
                        + "\",\"" +numeroElementos+ "\",\"" +puestoPlantillaId+ "\",\"" +costoNetoFactura+ "\",\"" +turnosPorDia+ "\",\"" +turnosMensuales+ "\",\""
                        +subtotal+ "\",\"" +iva+ "\",\"" +costoPorTurno+ "\",\"" +comentarioRequisicion+ "\",\"" +recursosMateriales+ "\",\""
                        +cobraDescanso+ "\",\"" +cobraFestivos+ "\",\"" +cobraDia31+ "\",\"" +servicioPlantillaId+ "\",\"" +fechaInicioServicio+ "\",\"" +fechaTerminoServicio+ "\",\"" +rolOperativo+ "\");' ></td><tr>";
                    }

                    listaRequisicionTable += "</tbody></table>";
                    $('#listPlantillaAlta').html(listaRequisicionTable);
                    //obtenerNumeroRequisicion();
                }
                else if (response.status == "error" && response.message == "No autorizado")
                {
                    window.location = "login.php";
                }
            },
            error: function (response)
            {
                console.log (response);

            }
        });

}

function modalEditarPunto(idPuntoServicio, idCliente, centroCosto, puntoServicio, entidad, direccion, fechaInicio, fechaTermino, cf, tff, tmf, cof, tf, ct, cot, tft, tmt, co, coo, tfo, tmo, cdes, cfes,c31,lat,lon,turnoFlat,idlineanegocio,idautoincrementindex,idRegion,descripcionregion,nombreEntidadPunto){

//alert("HOLA");
//alert (tf);
//alert(idlineanegocio+" "+idautoincrementindex+ " " +idRegion+ " " + descripcionregion + " " + entidad);
$("#modalEditarPunto").modal();
$("#clienteE").val(idCliente);
$("#txtNumeroCentroE").val(centroCosto);
$("#txtPuntoServicioE").val(puntoServicio);
$("#txtDireccionE").val(direccion);
$("#txtFechaInicioE").val(fechaInicio);
$("#txtFechaTerminoServicioE").val(fechaTermino);

$("#txtContactoFacturacionE").val(cf);
$("#txtCorreoFacturacionE").val(cof);
$("#txtTelefonoFijoFacturacionE").val(tff);
$("#txtTelefonoMovilFacturacionE").val(tmf);
$("#txtTerminosFacturacionE").val(tf);

$("#txtContactoTesoreriaE").val(ct);
$("#txtCorreoTesoreriaE").val(cot);
$("#txtTelefonoFijoTesoreriaE").val(tft);
$("#txtTelefonoMovilTesoreriaE").val(tmt);

$("#txtContactoOperativoE").val(co);
$("#txtCorreoOperativoE").val(coo);
$("#txtTelefonoFijoOperativoE").val(tfo);
$("#txtTelefonoMovilOperativoE").val(tmo);
$("#txtIdPuntoServicioE").val(idPuntoServicio);
$("#txtLatitudE").val(lat);
$("#txtLongitudE").val(lon);
$("#selLineaNegocioEdited").val(idlineanegocio);
//$("#entidadEdited").empty().append(idautoincrementindex+"sfvsfvsfvnvb");
$('#entidadEdited').empty().append('<option value="'+entidad+'" selected="selected">'+nombreEntidadPunto+'</option>');

$('#txtRegionEdited').val(idRegion+".-"+descripcionregion);
$('#idtxtRegionEdited').val(idautoincrementindex);



if(cdes==1){
  $('input[name=cobraDescansoE]').prop("checked", "true");
}else{
  $('input[name=cobraDescansoE]').prop("checked", "");
}

if(cfes==1){
  $('input[name=cobraDiaFestivoE]').prop("checked", "true");
}else{
  $('input[name=cobraDiaFestivoE]').prop("checked", "");
}

if(c31==1){
  $('input[name=cobraDia31E]').prop("checked", "true");
}else{
  $('input[name=cobraDia31E]').prop("checked", "");
}

if(turnoFlat==1){
  $('input[name=valorFlatE]').prop("checked", "true");
}else{
  $('input[name=valorFlatE]').prop("checked", "");
}

}

var rolUsuario="<?php echo $usuario['rol']; ?>";

$(inicioConsultaSuc());  

function inicioConsultaSuc(){
    if(rolUsuario=="Administracion Seguridad Electronica"){
      styleTablePuntosServicios();
      seleccionarPuestoAlta();
      seleccionarPuestoEdited();
    }
}

  function disminuirPlantilla (servicioPlantillaId)
  {
       $.ajax({
            type: "POST",
            url: "ajax_disminuirplantilla.php",
            data:{"servicioPlantillaId":servicioPlantillaId, "action":"consultar"},
            dataType: "json",
            async: false,
            success: function(response) {
                if (response.status == "success")
                {
                    var continuar = confirm (response.message);

                    if (continuar)
                    {
                        $.ajax({
                            type: "POST",
                            url: "ajax_disminuirplantilla.php",
                            data:{"servicioPlantillaId":servicioPlantillaId, "action":"disminuir"},
                            dataType: "json",
                            async: false,
                            success: function(response) {
                                alert (response.message);
                                consultaRequisicionAlta();
                            },
                            error: function (response)
                            {
                                alert ("Ocurrio un error al realizar la disminución de los datos de la plantilla");
                            }
                        });
                    }
                }
                else
                {
                    alert (response.message);
                }
            },
            error: function (response)
            {
                alert ("Ocurrio un error al consultar los datos de la plantilla");
            }
       });
  }

  function incrementarPlantilla (servicioPlantillaId)
  {
       $.ajax({
            type: "POST",
            url: "ajax_incrementaPlantilla.php",
            data:{"servicioPlantillaId":servicioPlantillaId, "action":"consultar"},
            dataType: "json",
            async: false,
            success: function(response) {
                if (response.status == "success")
                {
                    var continuar = confirm (response.message);

                    if (continuar)
                    {
                        $.ajax({
                            type: "POST",
                            url: "ajax_incrementaPlantilla.php",
                            data:{"servicioPlantillaId":servicioPlantillaId, "action":"incrementar"},
                            dataType: "json",
                            async: false,
                            success: function(response) {
                                alert (response.message);
                                consultaRequisicionAlta();
                            },
                            error: function (response)
                            {
                                alert ("Ocurrio un error al realizar el incremento de los datos de la plantilla");
                            }
                        });
                    }
                }
                else
                {
                    alert (response.message);
                }
            },
            error: function (response)
            {
                alert ("Ocurrio un error al consultar los datos de la plantilla");
            }
       });
  }

  function updatePuntosServicio()
    {
      //alert("hola");
    var cobraDescansos=0;
    var cobraDiaFestivo=0;
    var cobra31=0;
    var turnoFlat=0;

    if($('input[name=cobraDescansoE]').is(':checked')){
      var cobraDescansos=1;
      //alert(cobraDescanso);
    }

    if($('input[name=cobraDiaFestivoE]').is(':checked')){
      var cobraDiaFestivo=1;
      //alert(cobraDiaFestivo);
    }

    if($('input[name=cobraDia31E]').is(':checked')){
      var cobra31=1;
      //alert(cobraDia31);
    }

    if($('input[name=valorFlatE]').is(':checked')){
      turnoFlat=1;
      //alert(cobraDia31);
    }
		var clienteedited=$("#clienteE").val();
        var idPuntoServicio=$("#txtIdPuntoServicioE").val();
        var datastring = $("#form_catalogoPuntosServicios").serialize();
            datastring += "&idPuntoServicio=" + idPuntoServicio;
            datastring += "&cobraDescansos=" + cobraDescansos;
            datastring += "&cobraDiaFestivo=" + cobraDiaFestivo;
            datastring += "&cobra31=" + cobra31;
            datastring += "&turnoFlat=" + turnoFlat;
			 datastring += "&clienteE=" + clienteedited;
            //datastring += "&idEstatusM=" + idEstatusMovimiento;
            //datastring += "&idBancoM=" + numeroBanco;
            //datastring.val().toUpperCase();
        $.ajax({
            type: "POST",
            url: "ajax_updatePuntoServicio.php",
            data: datastring,
            dataType: "json",
            success: function(response) {
            var mensaje=response.message;
                if (response.status == "success")
                {

                  alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Edicion:</strong>"+mensaje+"<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#alertMsg1PE").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                    styleTablePuntosServicios();
                    $('#modalEditarPunto').modal('hide');
                 }else if (response.status=="error")
                {
                  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Edicion:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#alertMsg1PE").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                }
            },

            error: function(){
                  alert('error handing here');
            }
        });
    }

    //}

    function updatePlantilla(idPuntoServicio, nombrePunto, razonSocial, fechaInicio, fechaTermino, lineaNegocio,tipoTurnoPlantillaId, numeroElementos, puesto, costoNetoFactura, turnosDia, turnosMes, subtotal, iva, costoTurno, comentarioRequisicion, recursosMateriales, cobraDescanso, cobraFestivo, cobra31,idRequisicion, fips,ftps,rolOp){
      //alert("EN DESARROLLO");
      $("#divSelectRolOperativoEdited").html("");
      $("#modalPlantillaAlta").modal('hide');
      $("#modalEditarPlantilla").modal();
      $("#txtPuntoServicioIdEdited").val(idPuntoServicio);
      $("#txtPuntoServicioModalEdited").val(nombrePunto);
      $("#txtClienteModalEdited").val(razonSocial);
      $("#txtFechaInicioRequisicionEdited").val(fechaInicio);
      $("#txtFechaTerminoRequisicionEdited").val(fechaTermino);
      $("#txtLineaNegocioRequisicionEdited").val(lineaNegocio);
      $("#selectTurnoRequisicionEdited").val(tipoTurnoPlantillaId);
      $("#txtNumeroElementosEdited").val(numeroElementos);
      $("#selectPuestoRequisicionEdited").val(puesto);
      $("#txtTotalFacturaEdited").val(costoNetoFactura);
      $("#txtTurnosDiariosEdited").val(turnosDia);
      $("#txtTurnosMensualesEdited").val(turnosMes);
      $("#txtSubtotalEdited").val(formatter.format(subtotal));
      $("#txtIvaEdited").val(formatter.format(iva));
      $("#txtCostoTurnoEdited").val(formatter.format(costoTurno));
      $("#txtComentariosRequisicionEdited").val(comentarioRequisicion);
      $("#txtRecursosMaterialesEdited").val(recursosMateriales);
      $("#txtIdRequisicion").val(idRequisicion);
      $("#txtFechaInicioPuntoServicioEdited").val(fips);
      $("#txtFechaTerminoPuntoServicioEdited").val(ftps);



      $("#txtCostoTurnoEditedAnterior").val(costoTurno);







      //document.getElementById("selectRolOpE").selectedIndex= "1";


      if(cobraDescanso=="" || cobraDescanso=='null'){

        cobraDescanso=0;
      }

      if(cobraFestivo=="" || cobraFestivo=='null'){

        cobraFestivo=0;
      }

      if(cobra31=="" || cobra31=='null'){

        cobra31=0;
      }

      $("#txtCobraDescansoE").val(cobraDescanso);
      $("#txtCobraFestivoE").val(cobraFestivo);
      $("#txtCobra31E").val(cobra31);
      mostrarRolOperativoEdicion();


      if(rolOp =="12x12x5" && rolOp!=null){
        $('#selectRolOpE > option[value="3"]').attr('selected','selected');
        $("#fotoFatigaE").html ("<img src='uploads/fotocobertura/fatigax5.png' />");
      }else if(rolOp =="12x12x6" && rolOp!=null){
        $('#selectRolOpE > option[value="2"]').attr('selected','selected');
        $("#fotoFatigaE").html ("<img src='uploads/fotocobertura/fatigax6.png' />");
      }
    }

    function mostrarPlantillaEdited(){

      var puntoServicioId=$("#txtPuntoServicioIdEdited").val();
      var razonSocial=$("#txtClienteModalEdited").val();
      var puntoServicio=$("#txtPuntoServicioModalEdited").val();
      var fechaInicioPuntoServicio=$("#txtFechaInicioPuntoServicioEdited").val();
      var fechaTerminoServicio=$("#txtFechaTerminoPuntoServicioEdited").val();
      var cobraDiaFestivo=$("#txtCobraFestivoE").val();
      var cobra31=$("#txtCobra31E").val();
      var cobraDescansos=$("#txtCobraDescansoE").val();

      mostrarModalPlantilla(puntoServicioId, razonSocial, puntoServicio,cobraDescansos, cobraDiaFestivo,cobra31,fechaInicioPuntoServicio,fechaTerminoServicio);

    }


    function mostrarRolOperativoAlta(){
       var cobraDescanso=$("#txtCobraDescansoRA").val();
      var opcionTurno=document.getElementById("selectTurnoRequisicionAlta").selectedIndex;
      if(opcionTurno==1){
        if(cobraDescanso==1){
                var selectTipoRolOp="<span class='add-on'>Tipo Rol Operativo</span>";
                selectTipoRolOp+="<select name'selectRolOpA' id='selectRolOpA' onChange='cambiarRolOpA();'>";
                selectTipoRolOp+="<option value='1'>12x12x7</option><option value='2'>12x12x6</option><option value='3'>12x12x5</option></select> ";
                selectTipoRolOp+="<div id='fotoFatigaA' style='width:608px;height:136px;border:1px solid;text-align:center;display: flex;flex-direction: column;' ></div> ";
                $("#rolOpNuevo").val("12x12x7");
                $("#divSelectRolOperativoAlta").html(selectTipoRolOp);
                $("#fotoFatigaA").html ("<img src='uploads/fotocobertura/fatigax7-1.png' />");
        }else{
                var selectTipoRolOp="<span class='add-on'>Tipo Rol Operativo</span>";
                selectTipoRolOp+="<input class='input-large' id='txtRolOp' name='txtRolOp' type='text' value='12x12x7' readonly/> ";
                selectTipoRolOp+="<div id='fotoFatigaA' style='width:608px;height:136px;border:1px solid;text-align:center;display: flex;flex-direction: column;' ></div>";
                $("#divSelectRolOperativoAlta").html(selectTipoRolOp);
                $("#rolOpNuevo").val("12x12x7");
                $("#fotoFatigaA").html ("<img src='uploads/fotocobertura/fatigax7.png' />");

        }

      }else{
        $("#divSelectRolOperativoAlta").html("");
        var turno=document.getElementById("selectTurnoRequisicionAlta").options[opcionTurno].text;
        $("#rolOpNuevo").val(turno+"x7");
      }

    }


    function mostrarRolOperativoEdicion(){
      var cobraDescanso=$("#txtCobraDescansoE").val();
      var opcionTurno=document.getElementById("selectTurnoRequisicionEdited").selectedIndex;
      if(opcionTurno==1){
        if(cobraDescanso==1){
                var selectTipoRolOp="<span class='add-on'>Tipo Rol Operativo</span>";
                selectTipoRolOp+="<select name'selectRolOpE' id='selectRolOpE' onChange='cambiarRolOpE();'>";
                selectTipoRolOp+="<option value='1'>12x12x7</option><option value='2'>12x12x6</option><option value='3'>12x12x5</option></select> ";
                selectTipoRolOp+="<div id='fotoFatigaE' style='width:608px;height:136px;border:1px solid;text-align:center;display:flex;flex-direction: column;'></div> ";
                $("#rolOpEdit").val("12x12x7");
                $("#divSelectRolOperativoEdited").html(selectTipoRolOp);
                $("#fotoFatigaE").html ("<img src='uploads/fotocobertura/fatigax7-1.png' />");
        }else{
                var selectTipoRolOp="<span class='add-on'>Tipo Rol Operativo</span>";
                selectTipoRolOp+="<input class='input-large' id='txtRolOp' name='txtRolOp' type='text' value='12x12x7' readonly/> ";
                selectTipoRolOp+="<div id='fotoFatigaE' style='width:608px;height:136px;border:1px solid;text-align:center;display: flex;flex-direction: column;' ></div>";
                $("#rolOpEdit").val("12x12x7");
                $("#divSelectRolOperativoEdited").html(selectTipoRolOp);
                $("#fotoFatigaE").html ("<img src='uploads/fotocobertura/fatigax7.png' />");

        }

      }else{
        $("#divSelectRolOperativoEdited").html("");
        var turno=document.getElementById("selectTurnoRequisicionEdited").options[opcionTurno].text;
        $("#rolOpEdit").val(turno+"x7");
      }

    }



    function cambiarRolOpE(){
        var opcionOperativo=document.getElementById("selectRolOpE").selectedIndex;
        if(opcionOperativo==0){
            $("#fotoFatigaE").html ("<img src='uploads/fotocobertura/fatigax7-1.png' />");
            $("#rolOpEdit").val("12x12x7");
        }else if(opcionOperativo==1){
            $("#fotoFatigaE").html ("<img src='uploads/fotocobertura/fatigax6.png' />");
            $("#rolOpEdit").val("12x12x6");
        }else{
            $("#fotoFatigaE").html ("<img src='uploads/fotocobertura/fatigax5.png' />");
            $("#rolOpEdit").val("12x12x5");
        }
    }


    function cambiarRolOpA(){
        var opcionOperativo=document.getElementById("selectRolOpA").selectedIndex;
        if(opcionOperativo==0){
            $("#fotoFatigaA").html ("<img src='uploads/fotocobertura/fatigax7-1.png' />");
            $("#rolOpNuevo").val("12x12x7");
        }else if(opcionOperativo==1){
             $("#fotoFatigaA").html ("<img src='uploads/fotocobertura/fatigax6.png' />");
            $("#rolOpNuevo").val("12x12x6");
        }else{
            $("#fotoFatigaA").html ("<img src='uploads/fotocobertura/fatigax5.png' />");
            $("#rolOpNuevo").val("12x12x5");
        }
    }


$('#txtFechaInicioRequisicionAlta').datetimepicker({

  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',

});

$('#txtFechaTerminoRequisicionAlta').datetimepicker({

  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',

});

$('#txtFechaInicioRequisicionEdited').datetimepicker({

  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',

});

$('#txtFechaTerminoRequisicionEdited').datetimepicker({

  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',

});

$('#txtFechaBajaPuntoServicio').datetimepicker({

  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',

});

$('#fechaInicioServicioReactivacion').datetimepicker({

  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',

});

$('#txtFechaInicioE').datetimepicker({

  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',

});

$('#txtFechaTerminoServicioE').datetimepicker({

  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',

});



$("#selLineaNegocioEdited").change(function(){
var idlineanegocioEdited=$("#selLineaNegocioEdited").val();
if(idlineanegocioEdited!=0){
 $.ajax({
              type: "POST",
              url: "ajax_consultaEntidadesRegionesXlineanegocio.php",
              data: {
                  "idlineanegocio": idlineanegocioEdited,"idEntidad":0,"accion":1
              },
              dataType: "json",
              success: function(response) {
              // console.log(datos);
                  var datos = response.datos;
                  $('#entidadEdited').empty().append('<option value="0" selected="selected">ENTIDAD FEDERATIVA</option>');
                  $.each(datos, function(i) {
                      $('#entidadEdited').append('<option value="' + response.datos[i].idEntidadFederativa + '">' + response.datos[i].nombreEntidadFederativa + '</option>');
                  });
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
          });
}else{
$('#entidadEdited').empty();
$("#txtRegionEdited").val("");
$("#idtxtRegionEdited").val("");

}
});


$('#entidadEdited').change(function(){
var idlineanegocioEdited=$("#selLineaNegocioEdited").val();
var idEntidadEdited=$('#entidadEdited').val();

if(idEntidadEdited!=0){
$.ajax({
              type: "POST",
              url: "ajax_consultaEntidadesRegionesXlineanegocio.php",
              data: {
                  "idlineanegocio": idlineanegocioEdited,"idEntidad":idEntidadEdited,"accion":2
              },
              dataType: "json",
              success: function(response) {
               
                  var datos = response.datos;
                 
                     $("#txtRegionEdited").val(datos[0].idRegionI+".-"+datos[0].DescripcionI);

                      $("#idtxtRegionEdited").val(datos[0].idIncrementI);
                      

                 
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
          });
}else{
$("#txtRegionEdited").val("");
$("#idtxtRegionEdited").val("");

}
});


  </script>
