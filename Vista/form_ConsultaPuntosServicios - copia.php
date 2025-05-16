<?php

$catalogoEntidades = $negocio->negocio_obtenerListaEntidadesFeferativas();
$catalogoClientes  = $negocio->negocio_obtenerListaClientesActivos();
 $catalogoLineaNegocioRegistroPunto                = $negocio->negocio_obtenerListaLineaNegocio();
?>
<div align="center">
  <form class="form-horizontal"  method="post" id="form_catalogoPuntosServicios1" name="form_catalogoPuntosServicios1" action="" target="_blank">
      <fieldset ><legend>Catalogo puntos servicios</legend></fieldset>
      <!-- Modal  modalEditarPlantilla-->
      <div id="modalEditarPlantilla1" name="modalEditarPlantilla1" style="display:none;" class="modalEdit4 hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" >
        <div class="modal-header">
          <div id="msgEdicionReq" name="msgEdicionReq"></div>
          <h4 class="modal-title">Edición de plantilla</h4>
        </div>
        <div class="modal-body-requisicion">
          <div class="input-prepend">
            <span class="add-on">idPunto</span>
            <input class="input-mini" id="txtPuntoServicioIdEdited" name="txtPuntoServicioIdEdited" type="text" readonly>
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
            <input class="input-large" id="txtLineaNegocioRequisicionEdited" name="txtLineaNegocioRequisicionEdited" type="text" readonly value="1">
            <input id="txtIdLineaNegocioRequisicionEdited" name="txtIdLineaNegocioRequisicionEdited" type="hidden" />
            <input id="txtCobraDescansoE" name="txtCobraDescansoE" type="hidden" />
            <input id="txtCobraFestivoE" name="txtCobraFestivoE" type="hidden" />
            <input id="txtCobra31E" name="txtCobra31E" type="hidden" />
          </div>
          <br>
          <div class="input-prepend">
            <span class="add-on">Tipo Turno</span>
            <select id="selectTurnoRequisicionEdited" name="selectTurnoRequisicionEdited" class="input-large " onchange="limpiarDatosEdited();mostrarRolOperativoEdicion();MostrarCamposDiasATrabajarEdit();">
              <option>TURNO</option>
              <?php
                for ($i = 0; $i < count($catalogoTurnos); $i++) {
                  echo "<option value='" . $catalogoTurnos[$i]["idTipoTurno"] . "' >" . $catalogoTurnos[$i]["descripcionTurno"] . " </option>";
                }
              ?>
            </select>
          </div>
          <div class="input-prepend" id="divSelectRolOperativoEdited" name='divSelectRolOperativoEdited'></div>
          <div id="divRolTotal"  class="input-prepend" style="display: none;">
            <span class="add-on">Tipo Rol Operativo</span>
            <input id="rolOpEdit" name="rolOpEdit" type="text" readonly>
          </div><br>
          <div class="input-prepend">
            <span class="add-on">No.Elementos</span>
            <input class="input-mini-mini" id="txtNumeroElementosEdited" name="txtNumeroElementosEdited" type="text"  onchange="calcularTurnosDiariosEdited();">
          </div>

          <div class="input-prepend">
            <span class="add-on">Puesto</span>
            <select id="selectPuestoRequisicionEdited" name="selectPuestoRequisicionEdited" class="input-large "></select>
          </div>
          <br>
          <h4 id="TituloElementosEdit" align="center" style="display: none;"> LOS ELEMENTOS DESCANSARAN EL MISMO DIA?</h4>
          <div id="DivElementosEdit" align="center" style="display: none;">
            <span class="add-on" id="checkElementos1Edit">Descansos De Los Elementos </span>
            <input id="checkElementosEdit" name="checkElementosEdit" type="checkbox" style="transform: scale(1.5);"><br>
          </div>
          <br>
          <h4 id="TituloDiasDescansoEdit" align="center"> DESMARCA EL DIA QUE NO SE VA A LABORAR !!</h4>
          <input id="ElementosPlantillas" name="ElementosPlantillas" type="hidden">
          <input id="TipoRolOperativoPlantilla" name="TipoRolOperativoPlantilla" type="hidden">
          <div class="input-prepend" align="left">
            <i><span class="add-on"><b>LUNES</b></span></i><br>
            <span class="add-on" id="checkLunes1Edit">Dia Laborable</span>
            <input id="checkLunesEdit" name="checkLunesEdit" type="checkbox" checked="true" style="transform: scale(1.5);"><br>

            <span class="add-on">Turnos Dia</span>
            <input class="input-mini-mini" id="TDiaLunesEdit" name="TDiaLunesEdit" type="text" onblur="SumatoriaTurnosEdit(1);"><br>

            <span class="add-on">Turnos Noche</span>
            <input class="input-mini-mini" id="TNocheLunesEdit" name="TNocheLunesEdit" type="text" onblur="SumatoriaTurnosEdit(1);"><br>

            <span class="add-on">Total Turnos Lunes</span>
            <input class="input-mini-mini" id="TTotalesLunesEdit" name="TTotalesLunesEdit" type="text" readonly>
          </div>
          <div class="input-prepend">
            <i><span class="add-on"><b>MARTES</b></span></i><br>
    
            <span class="add-on" id="checkMartes1Edit">Dia Laborable</span>
            <input id="checkMartesEdit" name="checkMartesEdit" type="checkbox" checked="true" style="transform: scale(1.5);"><br>
    
            <span class="add-on">Turnos Dia</span>
            <input class="input-mini-mini" id="TDiaMartesEdit" name="TDiaMartesEdit" type="text" onblur="SumatoriaTurnosEdit(2);"><br>
    
            <span class="add-on">Turnos Noche</span>
            <input class="input-mini-mini" id="TNochesMartesEdit" name="TNochesMartesEdit" type="text" onblur="SumatoriaTurnosEdit(2);"><br>
    
            <span class="add-on">Total Turnos Martes</span>
            <input class="input-mini-mini" id="TTotalesMartesEdit" name="TTotalesMartesEdit" type="text" readonly><br>  
          </div>
          <div class="input-prepend">
            <i><span class="add-on"><b>MIERCOLES</b></span></i><br>
    
            <span class="add-on" id="checkMiercoles1Edit">Dia Laborable</span>
            <input id="checkMiercolesEdit" name="checkMiercolesEdit" type="checkbox" checked="true" style="transform: scale(1.5);"><br>
    
            <span class="add-on">Turnos Dia</span>
            <input class="input-mini-mini" id="TDiaMiercolesEdit" name="TDiaMiercolesEdit" type="text" onblur="SumatoriaTurnosEdit(3);"><br>
    
            <span class="add-on">Turnos Noche</span>
            <input class="input-mini-mini" id="TNocheMiercolesEdit" name="TNocheMiercolesEdit" type="text" onblur="SumatoriaTurnosEdit(3);"><br>
    
            <span class="add-on">Total Turnos Miercoles</span>
            <input class="input-mini-mini" id="TTotalesMiercolesEdit" name="TTotalesMiercolesEdit" type="text" readonly>
          </div>
          <div class="input-prepend">
            <i><span class="add-on"><b>JUEVES</b></span></i><br>
    
            <span class="add-on" id="checkJueves1Edit">Dia Laborable</span>
            <input id="checkJuevesEdit" name="checkJuevesEdit" type="checkbox" checked="true" style="transform: scale(1.5);"><br>
    
            <span class="add-on">Turnos Dia</span>
            <input class="input-mini-mini" id="TDiaJuevesEdit" name="TDiaJuevesEdit" type="text" onblur="SumatoriaTurnosEdit(4);"><br>
    
            <span class="add-on">Turnos Noche</span>
            <input class="input-mini-mini" id="TNocheJuevesEdit" name="TNocheJuevesEdit" type="text" onblur="SumatoriaTurnosEdit(4);"><br>
    
            <span class="add-on">Total Turnos Jueves</span>
            <input class="input-mini-mini" id="TTotalesJuevesEdit" name="TTotalesJuevesEdit" type="text" readonly>
          </div>
          <div class="input-prepend">
            <i><span class="add-on"><b>VIERNES</b></span></i><br>
    
            <span class="add-on" id="checkViernes1Edit">Dia Laborable</span>
            <input id="checkViernesEdit" name="checkViernesEdit" type="checkbox" checked="true" style="transform: scale(1.5);"><br>
    
            <span class="add-on">Turnos Dia</span>
            <input class="input-mini-mini" id="TDiaViernesEdit" name="TDiaViernesEdit" type="text" onblur="SumatoriaTurnosEdit(5);"><br>
    
            <span class="add-on">Turnos Noche</span>
            <input class="input-mini-mini" id="TNocheViernesEdit" name="TNocheViernesEdit" type="text" onblur="SumatoriaTurnosEdit(5);"><br>
    
            <span class="add-on">Total Turnos Viernes</span>
            <input class="input-mini-mini" id="TTotalesViernesEdit" name="TTotalesViernesEdit" type="text" readonly>
          </div>
          <div class="input-prepend">
            <i><span class="add-on"><b>SABADO</b></span></i><br>
    
            <span class="add-on" id="checkSabado1Edit">Dia Laborable</span>
            <input id="checkSabadoEdit" name="checkSabadoEdit" type="checkbox" checked="true" style="transform: scale(1.5);"><br>
    
            <span class="add-on">Turnos Dia</span>
            <input class="input-mini-mini" id="TDiaSabadoEdit" name="TDiaSabadoEdit" type="text" onblur="SumatoriaTurnosEdit(6);"><br>
    
            <span class="add-on">Turnos Noche</span>
            <input class="input-mini-mini" id="TNocheSabadoEdit" name="TNocheSabadoEdit" type="text" onblur="SumatoriaTurnosEdit(6);"><br>
    
            <span class="add-on">Total Turnos Sabado</span>
            <input class="input-mini-mini" id="TtotalesSabadoEdit" name="TtotalesSabadoEdit" type="text" readonly>
          </div>
          <div class="input-prepend">
            <i><span class="add-on"><b>DOMINGO</b></span></i><br>
    
            <span class="add-on" id="checkDomingo1Edit">Dia Laborable</span>
            <input id="checkDomingoEdit" name="checkDomingoEdit" type="checkbox" checked="true" style="transform: scale(1.5);"><br>
    
            <span class="add-on">Turnos Dia</span>
            <input class="input-mini-mini" id="TDiaDomingoEdit" name="TDiaDomingoEdit" type="text" onblur="SumatoriaTurnosEdit(7);"><br>
    
            <span class="add-on">Turnos Noche</span>
            <input class="input-mini-mini" id="TNocheDomingoEdit" name="TNocheDomingoEdit" type="text" onblur="SumatoriaTurnosEdit(7);"><br>
    
            <span class="add-on">Total Turnos Domingo</span>
            <input class="input-mini-mini" id="TTotalesDomingoEdit" name="TTotalesDomingoEdit" type="text" readonly>
          </div>
          <br><br>
          <div class="input-prepend">
            <span class="add-on">Turnos a cubrir x Día</span>
            <input class="input-mini-mini" id="txtTurnosDiariosEdited" name="txtTurnosDiariosEdited" type="text" readonly>
          </div>
          <div class="input-prepend">
            <span class="add-on">Turnos a cubrir x Mes</span>
            <input class="input-mini" id="txtTurnosMensualesEdited" name="txtTurnosMensualesEdited" type="text" readonly>
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
      <div id="myModalBajaPuntoServicio1"  style="display:none;" name="myModalBajaPuntoServicio1" class="modalEdit hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" >
        <div id="alertMsgBajaModal"></div>
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
      <div id="myModalReactivarPuntoServicio1" style="display:none;" name="myModalReactivarPuntoServicio1" class="modalEdit hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" >
        <div id="alertMsgReactivacion"></div>
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

    <div id="modalPlantillaAlta1"  style="display:none;" name="modalPlantillaAlta1" class="modalPlantilla hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" >
        <div id="msgModalPlantillaAlta" id="msgModalPlantillaAlta">
        </div>

        <input id="LineaNegocioPlantilla" name="LineaNegocioPlantilla" type="hidden">
        <input id="IdClientePunto" name="IdClientePunto" type="hidden" />

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
          <input class="input-mini" id="txtPuntoServicioIdAlta" name="txtPuntoServicioIdAlta" type="text" readonly>
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

          <input class="input-large" id="txtLineaNegocioRequisicionAlta" name="txtLineaNegocioRequisicionAlta" type="text" readonly value="1">
           <input id="txtIdLineaNegocioRequisicionAlta" name="txtIdLineaNegocioRequisicionAlta" type="hidden" />
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
        
      </div>


      <div class="input-prepend" id="divSelectRolOperativoAlta" name='divSelectRolOperativoAlta'>

      </div>

      <div class="input-prepend" id="divVistaAltaRolOp" style="display: none;">
        <span class="add-on">Tipo Rol Operativo</span>
        <input id="rolOpNuevo" name="rolOpNuevo" type="text" readonly>
        
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

      <br><br>
      <h4 id="TituloElementos" align="center" style="display: none;"> LOS ELEMENTOS DESCANSARAN EL MISMO DIA?</h4>
      <div id="DivElementos" align="center" style="display: none;">

        <span class="add-on" id="checkElementosAlta1">Descansos De Los Elementos </span>
        <input id="checkElementosAlta" name="checkElementosAlta" type="checkbox" style="transform: scale(1.5);"><br>
      </div>

      <br><br>
      <h4 id="TituloDiasDescansoAlta" align="center"> DESMARCA EL DIA QUE NO SE VA A LABORAR?</h4>
      <div class="input-prepend">
        <i><span class="add-on"><b>LUNES</b></span></i><br>

        <span class="add-on" id="checkLunes1Alta">Dia Laborable</span>
        <input id="checkLunesAlta" name="checkLunesAlta" type="checkbox" checked="true" style="transform: scale(1.5);"><br>

        <span class="add-on">Turnos Dia</span>
        <input class="input-mini-mini" id="TDiaLunesAlta" name="TDiaLunesAlta" type="text" onblur="SumatoriaTurnosAlta(1);"><br>

        <span class="add-on">Turnos Noche</span>
        <input class="input-mini-mini" id="TNocheLunesAlta" name="TNocheLunesAlta" type="text" onblur="SumatoriaTurnosAlta(1);"><br>

        <span class="add-on">Total Turnos Lunes</span>
        <input class="input-mini-mini" id="TTotalesLunesAlta" name="TTotalesLunesAlta" type="text" readonly>
      </div>

      <div class="input-prepend">
        <i><span class="add-on"><b>MARTES</b></span></i><br>

        <span class="add-on" id="checkMartes1Alta">Dia Laborable</span>
        <input id="checkMartesAlta" name="checkMartesAlta" type="checkbox" checked="true" style="transform: scale(1.5);"><br>

        <span class="add-on">Turnos Dia</span>
        <input class="input-mini-mini" id="TDiaMartesAlta" name="TDiaMartesAlta" type="text" onblur="SumatoriaTurnosAlta(2);"><br>

        <span class="add-on">Turnos Noche</span>
        <input class="input-mini-mini" id="TNochesMartesAlta" name="TNochesMartesAlta" type="text" onblur="SumatoriaTurnosAlta(2);"><br>

        <span class="add-on">Total Turnos Martes</span>
        <input class="input-mini-mini" id="TTotalesMartesAlta" name="TTotalesMartesAlta" type="text" readonly><br>  
      </div>

      <div class="input-prepend">
        <i><span class="add-on"><b>MIERCOLES</b></span></i><br>

        <span class="add-on" id="checkMiercoles1Alta">Dia Laborable</span>
        <input id="checkMiercolesAlta" name="checkMiercolesAlta" type="checkbox" checked="true" style="transform: scale(1.5);"><br>

        <span class="add-on">Turnos Dia</span>
        <input class="input-mini-mini" id="TDiaMiercolesAlta" name="TDiaMiercolesAlta" type="text" onblur="SumatoriaTurnosAlta(3);"><br>

        <span class="add-on">Turnos Noche</span>
        <input class="input-mini-mini" id="TNocheMiercolesAlta" name="TNocheMiercolesAlta" type="text" onblur="SumatoriaTurnosAlta(3);"><br>

        <span class="add-on">Total Turnos Miercoles</span>
        <input class="input-mini-mini" id="TTotalesMiercolesAlta" name="TTotalesMiercolesAlta" type="text" readonly>
      </div>

      <div class="input-prepend">
        <i><span class="add-on"><b>JUEVES</b></span></i><br>

        <span class="add-on" id="checkJueves1Alta">Dia Laborable</span>
        <input id="checkJuevesAlta" name="checkJuevesAlta" type="checkbox" checked="true" style="transform: scale(1.5);"><br>

        <span class="add-on">Turnos Dia</span>
        <input class="input-mini-mini" id="TDiaJuevesAlta" name="TDiaJuevesAlta" type="text" onblur="SumatoriaTurnosAlta(4);"><br>

        <span class="add-on">Turnos Noche</span>
        <input class="input-mini-mini" id="TNocheJuevesAlta" name="TNocheJuevesAlta" type="text" onblur="SumatoriaTurnosAlta(4);"><br>

        <span class="add-on">Total Turnos Jueves</span>
        <input class="input-mini-mini" id="TTotalesJuevesAlta" name="TTotalesJuevesAlta" type="text" readonly>
      </div>

      <div class="input-prepend">
        <i><span class="add-on"><b>VIERNES</b></span></i><br>

        <span class="add-on" id="checkViernes1Alta">Dia Laborable</span>
        <input id="checkViernesAlta" name="checkViernesAlta" type="checkbox" checked="true" style="transform: scale(1.5);"><br>

        <span class="add-on">Turnos Dia</span>
        <input class="input-mini-mini" id="TDiaViernesAlta" name="TDiaViernesAlta" type="text" onblur="SumatoriaTurnosAlta(5);"><br>

        <span class="add-on">Turnos Noche</span>
        <input class="input-mini-mini" id="TNocheViernesAlta" name="TNocheViernesAlta" type="text" onblur="SumatoriaTurnosAlta(5);"><br>

        <span class="add-on">Total Turnos Viernes</span>
        <input class="input-mini-mini" id="TTotalesViernesAlta" name="TTotalesViernesAlta" type="text" readonly>
      </div>

      <div class="input-prepend">
        <i><span class="add-on"><b>SABADO</b></span></i><br>

        <span class="add-on" id="checkSabado1Alta">Dia Laborable</span>
        <input id="checkSabadoAlta" name="checkSabadoAlta" type="checkbox" checked="true" style="transform: scale(1.5);"><br>

        <span class="add-on">Turnos Dia</span>
        <input class="input-mini-mini" id="TDiaSabadoAlta" name="TDiaSabadoAlta" type="text" onblur="SumatoriaTurnosAlta(6);"><br>

        <span class="add-on">Turnos Noche</span>
        <input class="input-mini-mini" id="TNocheSabadoAlta" name="TNocheSabadoAlta" type="text" onblur="SumatoriaTurnosAlta(6);"><br>

        <span class="add-on">Total Turnos Sabado</span>
        <input class="input-mini-mini" id="TtotalesSabadoAlta" name="TtotalesSabadoAlta" type="text" readonly>
      </div>

      <div class="input-prepend">
        <i><span class="add-on"><b>DOMINGO</b></span></i><br>

        <span class="add-on" id="checkDomingo1Alta">Dia Laborable</span>
        <input id="checkDomingoAlta" name="checkDomingoAlta" type="checkbox" checked="true" style="transform: scale(1.5);"><br>

        <span class="add-on">Turnos Dia</span>
        <input class="input-mini-mini" id="TDiaDomingoAlta" name="TDiaDomingoAlta" type="text" onblur="SumatoriaTurnosAlta(7);"><br>

        <span class="add-on">Turnos Noche</span>
        <input class="input-mini-mini" id="TNocheDomingoAlta" name="TNocheDomingoAlta" type="text" onblur="SumatoriaTurnosAlta(7);"><br>

        <span class="add-on">Total Turnos Domingo</span>
        <input class="input-mini-mini" id="TTotalesDomingoAlta" name="TTotalesDomingoAlta" type="text" readonly>
      </div>
      <br><br>

      <div class="input-prepend">
        <span class="add-on">Turnos a cubrir x Día</span>

        <input class="input-mini-mini" id="txtTurnosDiariosAlta" name="txtTurnosDiariosAlta" type="text" readonly>
      </div>

      <div class="input-prepend">
        <span class="add-on">Turnos a cubrir x Mes</span>

        <input class="input-mini" id="txtTurnosMensualesAlta" name="txtTurnosMensualesAlta" type="text" readonly>
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

<div id="modalTurnoDiaNoche1"  style="display:none;" name="modalTurnoDiaNoche1" class="modalEdit hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div id="mensajeerroeturnos"></div>
  <h3 id="TituloIncremento" style="display: none;">¿En Qué Turnos Trabajarán Los Nuevos Elementos?</h3>
  <h3 id="TituloDecremento" style="display: none;">¿Qué Turnos Se Dejarán De Utilizar En La Plantilla?</h3>
  <h5 id="TituloAgregar" style="display: none;">DATOS A AGREGAR</h5>
  <h5 id="TituloEliminar" style="display: none;">DATOS A ELIMINAR</h5>
  <div align="center">
    <div class="input-prepend">
        <i><span class="add-on"><b>LUNES</b></span></i><br>

        <span class="add-on">Turnos Dia</span>
        <input class="input-mini-mini" id="TDiaLunesInDec" name="TDiaLunesInDec" type="text" onblur="SumatoriaTurnosInDec(1);"><br>

        <span class="add-on">Turnos Noche</span>
        <input class="input-mini-mini" id="TNocheLunesInDec" name="TNocheLunesInDec" type="text" onblur="SumatoriaTurnosInDec(1);"><br>

        <span class="add-on">Total Turnos Lunes</span>
        <input class="input-mini-mini" id="TTotalesLunesInDec" name="TTotalesLunesInDec" type="text" readonly>
      </div>

      <div class="input-prepend">
        <i><span class="add-on"><b>MARTES</b></span></i><br>

        <span class="add-on">Turnos Dia</span>
        <input class="input-mini-mini" id="TDiaMartesInDec" name="TDiaMartesInDec" type="text" onblur="SumatoriaTurnosInDec(2);"><br>

        <span class="add-on">Turnos Noche</span>
        <input class="input-mini-mini" id="TNochesMartesInDec" name="TNochesMartesInDec" type="text" onblur="SumatoriaTurnosInDec(2);"><br>

        <span class="add-on">Total Turnos Martes</span>
        <input class="input-mini-mini" id="TTotalesMartesInDec" name="TTotalesMartesInDec" type="text" readonly><br>  
      </div>

      <div class="input-prepend">
        <i><span class="add-on"><b>MIERCOLES</b></span></i><br>

        <span class="add-on">Turnos Dia</span>
        <input class="input-mini-mini" id="TDiaMiercolesInDec" name="TDiaMiercolesInDec" type="text" onblur="SumatoriaTurnosInDec(3);"><br>

        <span class="add-on">Turnos Noche</span>
        <input class="input-mini-mini" id="TNocheMiercolesInDec" name="TNocheMiercolesInDec" type="text" onblur="SumatoriaTurnosInDec(3);"><br>

        <span class="add-on">Total Turnos Miercoles</span>
        <input class="input-mini-mini" id="TTotalesMiercolesInDec" name="TTotalesMiercolesInDec" type="text" readonly>
      </div>

      <div class="input-prepend">
        <i><span class="add-on"><b>JUEVES</b></span></i><br>

        <span class="add-on">Turnos Dia</span>
        <input class="input-mini-mini" id="TDiaJuevesInDec" name="TDiaJuevesInDec" type="text" onblur="SumatoriaTurnosInDec(4);"><br>

        <span class="add-on">Turnos Noche</span>
        <input class="input-mini-mini" id="TNocheJuevesInDec" name="TNocheJuevesInDec" type="text" onblur="SumatoriaTurnosInDec(4);"><br>

        <span class="add-on">Total Turnos Jueves</span>
        <input class="input-mini-mini" id="TTotalesJuevesInDec" name="TTotalesJuevesInDec" type="text" readonly>
      </div>

      <div class="input-prepend">
        <i><span class="add-on"><b>VIERNES</b></span></i><br>

        <span class="add-on">Turnos Dia</span>
        <input class="input-mini-mini" id="TDiaViernesInDec" name="TDiaViernesInDec" type="text" onblur="SumatoriaTurnosInDec(5);"><br>

        <span class="add-on">Turnos Noche</span>
        <input class="input-mini-mini" id="TNocheViernesInDec" name="TNocheViernesInDec" type="text" onblur="SumatoriaTurnosInDec(5);"><br>

        <span class="add-on">Total Turnos Viernes</span>
        <input class="input-mini-mini" id="TTotalesViernesInDec" name="TTotalesViernesInDec" type="text" readonly>
      </div>

      <div class="input-prepend">
        <i><span class="add-on"><b>SABADO</b></span></i><br>

        <span class="add-on">Turnos Dia</span>
        <input class="input-mini-mini" id="TDiaSabadoInDec" name="TDiaSabadoInDec" type="text" onblur="SumatoriaTurnosInDec(6);"><br>

        <span class="add-on">Turnos Noche</span>
        <input class="input-mini-mini" id="TNocheSabadoInDec" name="TNocheSabadoInDec" type="text" onblur="SumatoriaTurnosInDec(6);"><br>

        <span class="add-on">Total Turnos Sabado</span>
        <input class="input-mini-mini" id="TtotalesSabadoInDec" name="TtotalesSabadoInDec" type="text" readonly>
      </div>

      <div class="input-prepend">
        <i><span class="add-on"><b>DOMINGO</b></span></i><br>

        <span class="add-on">Turnos Dia</span>
        <input class="input-mini-mini" id="TDiaDomingoInDec" name="TDiaDomingoInDec" type="text" onblur="SumatoriaTurnosInDec(7);"><br>

        <span class="add-on">Turnos Noche</span>
        <input class="input-mini-mini" id="TNocheDomingoInDec" name="TNocheDomingoInDec" type="text" onblur="SumatoriaTurnosInDec(7);"><br>

        <span class="add-on">Total Turnos Domingo</span>
        <input class="input-mini-mini" id="TTotalesDomingoInDec" name="TTotalesDomingoInDec" type="text" readonly>
      </div>


    <span id="spamturnosA" style="display: none;">Total De Turnos a Agregar</span>
    <span id="spamturnosE" style="display: none;">Total De Turnos a Eliminar</span>
    <input id="CantidadDeTurnos"type="text" class="input-small" readonly>
  </div>
  <h5>DATOS ACTUALES</h5>
  <div align="center">

    <div class="input-prepend">
        <i><span class="add-on"><b>LUNES</b></span></i><br>

        <span class="add-on">Turnos Dia</span>
        <input class="input-mini-mini" id="TDiaLunesDAactual" name="TDiaLunesDAactual" type="text" readonly><br>

        <span class="add-on">Turnos Noche</span>
        <input class="input-mini-mini" id="TNocheLunesDAactual" name="TNocheLunesDAactual" type="text" readonly><br>

        <span class="add-on">Total Turnos Lunes</span>
        <input class="input-mini-mini" id="TTotalesLunesDAactual" name="TTotalesLunesDAactual" type="text" readonly>
      </div>

      <div class="input-prepend">
        <i><span class="add-on"><b>MARTES</b></span></i><br>

        <span class="add-on">Turnos Dia</span>
        <input class="input-mini-mini" id="TDiaMartesDAactual" name="TDiaMartesDAactual" type="text" readonly><br>

        <span class="add-on">Turnos Noche</span>
        <input class="input-mini-mini" id="TNochesMartesDAactual" name="TNochesMartesDAactual" type="text" readonly><br>

        <span class="add-on">Total Turnos Martes</span>
        <input class="input-mini-mini" id="TTotalesMartesDAactual" name="TTotalesMartesDAactual" type="text" readonly><br>  
      </div>

      <div class="input-prepend">
        <i><span class="add-on"><b>MIERCOLES</b></span></i><br>

        <span class="add-on">Turnos Dia</span>
        <input class="input-mini-mini" id="TDiaMiercolesDAactual" name="TDiaMiercolesDAactual" type="text" readonly><br>

        <span class="add-on">Turnos Noche</span>
        <input class="input-mini-mini" id="TNocheMiercolesDAactual" name="TNocheMiercolesDAactual" type="text" readonly><br>

        <span class="add-on">Total Turnos Miercoles</span>
        <input class="input-mini-mini" id="TTotalesMiercolesDAactual" name="TTotalesMiercolesDAactual" type="text" readonly>
      </div>

      <div class="input-prepend">
        <i><span class="add-on"><b>JUEVES</b></span></i><br>

        <span class="add-on">Turnos Dia</span>
        <input class="input-mini-mini" id="TDiaJuevesDAactual" name="TDiaJuevesDAactual" type="text" readonly><br>

        <span class="add-on">Turnos Noche</span>
        <input class="input-mini-mini" id="TNocheJuevesDAactual" name="TNocheJuevesDAactual" type="text" readonly><br>

        <span class="add-on">Total Turnos Jueves</span>
        <input class="input-mini-mini" id="TTotalesJuevesDAactual" name="TTotalesJuevesDAactual" type="text" readonly>
      </div>

      <div class="input-prepend">
        <i><span class="add-on"><b>VIERNES</b></span></i><br>

        <span class="add-on">Turnos Dia</span>
        <input class="input-mini-mini" id="TDiaViernesDAactual" name="TDiaViernesDAactual" type="text" readonly><br>

        <span class="add-on">Turnos Noche</span>
        <input class="input-mini-mini" id="TNocheViernesDAactual" name="TNocheViernesDAactual" type="text" readonly><br>

        <span class="add-on">Total Turnos Viernes</span>
        <input class="input-mini-mini" id="TTotalesViernesDAactual" name="TTotalesViernesDAactual" type="text" readonly>
      </div>

      <div class="input-prepend">
        <i><span class="add-on"><b>SABADO</b></span></i><br>

        <span class="add-on">Turnos Dia</span>
        <input class="input-mini-mini" id="TDiaSabadoDAactual" name="TDiaSabadoDAactual" type="text" readonly><br>
        <span class="add-on">Turnos Noche</span>
        <input class="input-mini-mini" id="TNocheSabadoDAactual" name="TNocheSabadoDAactual" type="text" readonly><br>

        <span class="add-on">Total Turnos Sabado</span>
        <input class="input-mini-mini" id="TtotalesSabadoDAactual" name="TtotalesSabadoDAactual" type="text" readonly>
      </div>

      <div class="input-prepend">
        <i><span class="add-on"><b>DOMINGO</b></span></i><br>

        <span class="add-on">Turnos Dia</span>
        <input class="input-mini-mini" id="TDiaDomingoDAactual" name="TDiaDomingoDAactual" type="text" readonly><br>

        <span class="add-on">Turnos Noche</span>
        <input class="input-mini-mini" id="TNocheDomingoDAactual" name="TNocheDomingoDAactual" type="text" readonly><br>

        <span class="add-on">Total Turnos Domingo</span>
        <input class="input-mini-mini" id="TTotalesDomingoDAactual" name="TTotalesDomingoDAactual" type="text" readonly>
      </div>
   
    <span>Total De Turnos Actual</span>
    <input id="TotalDeTurnoActual" name="TotalDeTurnoActual" type="text" class="input-small" readonly>
  </div>
  <input id="BanderaTurnos"type="hidden">
  <input id="ServicioPlantillaConsulta" type="hidden">

 <div class="modal-footer">
  <button type="button" class="btn btn-danger" onclick="CancelarTurnos();">Cancelar</button>

  <button type="button" class="btn btn-success" onclick="condicionesturnos();">Confirmar</button> 
  </div>

</div><!-- Modal -->

      <div id="modalEditarPunto1"  style="display:none;" name="modalEditarPunto1" class="modalEdit2 hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
          <div id="alertMsg1PE"></div>
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
              <td>
                <select id="selLineaNegocioEdited" name="selLineaNegocioEdited" class="input-xlarge">
                  <option value="0">LINEA DE NEGOCIO</option>
                  <?php
                    for ($i=0; $i<count($catalogoLineaNegocioRegistroPunto); $i++)
                    {
                      echo "<option value='". $catalogoLineaNegocioRegistroPunto[$i]["idLineaNegocio"]."'>". $catalogoLineaNegocioRegistroPunto[$i]["descripcionLineaNegocio"] ." </option>";
                    }
                  ?>
                </select>
              </td>
            </tr>
            <tr>
              <td> <label class="control-label1 label" for="txtLocalizacionEdited">Localizacion</label></td>
              <td>
                <select id="entidadEdited" name="entidadEdited" class="input-xlarge " onChange=""></select>
              </td>
            </tr>
            <tr>
              <td> <label class="control-label1 label" for="txtLocalizacion">Region</label></td>
              <td><input id="txtRegionEdited" name="txtRegionEdited" type="text" class="input-xlarge" readonly>
                <input id="idtxtRegionEdited" name="idtxtRegionEdited" type="hidden">
              </td>
            </tr>
            <tr>
              <td><label id="lbDelMun" class="control-label1 label" for="DelegacionMunicipioE">Delegación/Municipio</label></td>
              <td> 
                <select id="selDelMunE" name="selDelMunE" class="input-xlarge">
                  <option value="0">DELEGACIÓN/MUNICIPIO</option>
                  <?php
                    for ($i=0; $i<count($catalogomunicipios); $i++)
                    {
                      echo "<option value='". $catalogomunicipios[$i]["idMunicipio"]."'>". $catalogomunicipios[$i]["nombreMunicipio"] ." </option>";
                    }
                  ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><label id="lbUnidadE" class="control-label1 label" for="UnidadE">Unidad</label></td>
              <td><input id="txtUnidadE" name="txtUnidadE" type="text" class="input-xlarge"></td>
            </tr>

            <tr>
                <td> <label class="control-label1 label" for="CpContratoPuntoServicioEdit">Codigo Postal</label></td>
                <td><input id="txtCpContratoPuntoServicioEdit" name="txtCpContratoPuntoServicioEdit" class="input-small" onkeyup="consultaCPClientePuntoServicioEdit();" maxlength="5"></td>
            </tr>
             <tr>
                <td> <label class="control-label1 label" for="AsentamientoPuntoServicioEdit">Asentamiento</label></td>
                <td><select id="txtAsentamientoPuntoServicioEdit" name="txtAsentamientoPuntoServicioEdit" class="input-xlarge "></select></td>
            </tr>
            <tr>
                <td> <label class="control-label1 label" for="EntidadClientePuntoServicioEdit">Entidad Federativa</label></td>
                <td><select id="txtEntidadClientePuntoServicioEdit" name="txtEntidadClientePuntoServicioEdit" onchange="TraerMunicipiosPuntoServicioEdit(0);" class="input-xlarge"></select></td>
            </tr>
            <tr>
                <td> <label class="control-label1 label" for="MunicipioPuntoServicioEdit">Municipio o Alcaldia</label></td>
                <td><select id="txtMunicipioPuntoServicioEdit" name="txtMunicipioPuntoServicioEdit" onchange="TraerColoniasPuntoServicioEdit(0);" type="text" class="input-xlarge"></select></td>
            </tr>
            <tr>
                <td> <label class="control-label1 label" for="ColoniaClientePuntoServicioEdit">Colonia</label></td>
                <td><select id="txtColoniaClientePuntoServicioEdit" name="txtColoniaClientePuntoServicioEdit" type="text" class="input-xlarge"></select></td>
            </tr>
            <tr>
                <td> <label class="control-label1 label" for="CallePrincipalPuntoServicioEdit">Calle Principal</label></td>
                <td><input id="txtCallePrincipalPuntoServicioEdit" name="txtCallePrincipalPuntoServicioEdit" type="text"></td>
            </tr>
            <tr> 
                <td> <label class="control-label1 label" for="NumeroInteriroPuntoServicioEdit">Num Interior</label></td>
                <td><input id="txtNumeroInteriroPuntoServicioEdit" name="txtNumeroInteriroPuntoServicioEdit" type="text" class="input-small"></td>
            </tr>
            <tr> 
                <td> <label class="control-label1 label" for="NumeroExteriorPuntoServicioEdit">Num Exterior</label></td>
                <td><input id="txtNumeroExteriorPuntoServicioEdit" name="txtNumeroExteriorPuntoServicioEdit" type="text" class="input-small"></td>
            </tr>
            <tr>
                <td> <label class="control-label1 label" for="Calle1PuntoServicioEdit">Entre Calle</label></td>
                <td><input id="txtCalle1PuntoServicioEdit" name="txtCalle1PuntoServicioEdit" type="text" ></td>
            </tr>
            <tr>
                <td> <label class="control-label1 label" for="Calle2PuntoServicioEdit">Y Calle</label></td>
                <td><input id="txtCalle2PuntoServicioEdit" name="txtCalle2PuntoServicioEdit" type="text"></td>
            </tr>

            <tr>
              <td> <label class="control-label1 label" style="display: none;" for="direccion">Dirección</label></td>
              <td><textarea id="txtDireccionE" name="txtDireccionE" style="display: none;" class="txtAreaEdited" readonly="true"></textarea></td>
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
            <tr>
              <td><label class="control-label1 label" for="fechaInicio">Fecha Termino</label></td>
              <td><input id="txtFechaTerminoServicioE" name="txtFechaTerminoServicioE" type="text" class="input-medium" required="hey"></td>
            </tr>
            <tr>
              <td colspan="3" align="center"> <label  align="center" class="label label-info" for="direccion">Contacto Administrativo</label></td>
            </tr>
            <tr>
              <td><label class="control-label1 label" for="contactoFacturacion">Contacto Facturacion</label></td>
              <td><input id="txtContactoFacturacionE" name="txtContactoFacturacionE" type="text" class="input-xlarge"></td>
              <td rowspan='5'>
                <table>
                <tr>
                  <td colspan="2"><label style="margin-left: 50px" class="control-label1 label" for="contactoFacturacion">Turnos Presupuestados</label></td>
                </tr>
                <tr>  
                  <td>
                    <div>
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
                    </div>
                  </td>
                  <span>Si no lo seleccionas, los turnos presupuestados los calculará como MES NATURAL</span>
                </tr>
                <tr>
                  <td><label class="control-label1 label" for="visiblerhEdited"> Visible para RH</label></td>
                  <td>    
                    <div style="margin-top: 20px">
                      <!-- List group -->
                      <ul class="list-group">
                        <li class="list-group-item">  
                          <div class="material-switch pull-right">
                            <input id="visiblerhEdited" name="visiblerhEdited" type="checkbox"/>
                            <label style="margin-top: 0px" for="visiblerhEdited" class="label-success1"></label>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </td>
                </tr>
                <tr id="trcuredescansoEdited">
                  <td><label class="control-label1 label" for="cubredescansoEdited">¿PUNTO DE SERVICIO CUBREDESCANSO?</label></td>
                  <td>
                    <div style="margin-top: 20px;margin-left: 20%">
                      <!-- List group -->
                      <ul class="list-group">
                        <li class="list-group-item">
                          <div class="material-switch pull-right">
                            <input id="cubredescansoEdited" name="cubredescansoEdited" type="checkbox"/>
                            <label style="margin-top: 0px" for="cubredescansoEdited" class="label-success1"></label>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </td>
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
          <tr>
            <td colspan="3" align="center"> <label  align="center" class="label label-info" for="direccion">Contacto Operativo</label></td>
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
        </table>
        </div>
        <div class="modal-footer">
          <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
          <button type="button" class="btn btn-primary" onclick="updatePuntosServicio();">Guardar</button>
        </div>
      </div> <!--  fin modal edicion punto de servicio -->
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
                        <th>LINEA DE NEGOCIO</th>
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

     $('#myModalBajaPuntoServicio1').modal();
     $("#txtPuntoServicioM").val(puntoServicio);
     $("#txtIdPuntoBaja").val(idPuntoServicio);
     var currentDate = $.datepicker.formatDate('yy-mm-dd', new Date());
     $("#txtFechaBajaPuntoServicio").val(currentDate);

  }

  function mostrarModalReactivacionPuntoServicio(idPuntoServicio, puntoServicio){

     $('#myModalReactivarPuntoServicio1').modal();
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
              console.log(response);
                var mensaje=response.message;

                if (response.status=="success") {

                    alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+mensaje+"</strong> <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#alertMsgBajaModal").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                    $('#myModalBajaPuntoServicio1').modal('hide');

                    styleTablePuntosServicios();

                } else if (response.status=="error")
                {
                  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+mensaje+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#alertMsgBajaModal").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                }
              },
            error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
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
                    $('#myModalReactivarPuntoServicio1').modal('hide');

                    styleTablePuntosServicios();

                } else if (response.status=="error")
                {
                  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+mensaje+" </strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#alertMsgReactivacion").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                }
              },
            error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
        });
    }

  function mostrarModalPlantilla(puntoServicioId, razonSocial, puntoServicio,cobraDescansos, cobraDiaFestivo,cobra31, fechaInicioServicio, fechaTerminoServicio,descripcionLineaNegocio,idLineanNegocio,idClientePunto){
    $("#selectTurnoRequisicionAlta").val("TURNO");
    $("#selectTurnoRequisicionAlta").prop('disabled', false);
    $("#divVistaAltaRolOp").hide();
    $("#rolOpNuevo").val("");
    $("#LineaNegocioPlantilla").val(idLineanNegocio);
    $("#IdClientePunto").val(idClientePunto);
    seleccionarPuestoAlta();
    limpiarFormularioRequisicionAlta();
    obtenerNumeroRequisicionAlta();
    ocultarCamposDiasATrabajarAlta(1);
    $('#modalPlantillaAlta1').modal("show");
    consultaRequisicion1(puntoServicioId);

    $("#txtPuntoServicioModalAlta").val(puntoServicio);
    $("#txtPuntoServicioIdAlta").val(puntoServicioId);
    $("#txtClienteModalAlta").val(razonSocial);
    $("#txtIdLineaNegocioRequisicionAlta").val(idLineanNegocio);
    $("#txtLineaNegocioRequisicionAlta").val(descripcionLineaNegocio);
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
            error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
        });

    }

function styleTablePuntosServicios(){


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
            ,{ "data": "descripcionLineaNegocio" }
            ,{ "data": "razonSocial" }
            ,{ "data": "nombreEntidadFederativa" }
            ,{ "data": "direccionPuntoServicio1" }
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
      $("#txtSubtotalAlta").val("");
        

    }

  function limpiarDatosEdited(){
      $("#txtNumeroElementosEdited").val("");
      $("#txtTurnosDiariosEdited").val("");
      $("#txtTDiaEdited").val("");
      $("#txtTNocheEdited").val("");
      $("#txtTurnosMensualesEdited").val("");
      $("#txtTotalFacturaEdited").val("");
      $("#txtIvaEdited").val("");
      $("#txtCostoTurnoEdited").val("");

    }


//obtiene el catalogo de puestos para dar de alta la requisicion
    function seleccionarPuestoAlta()
    {
      var valorTipo ="03";
      var lineaNegocio = $("#LineaNegocioPlantilla").val();
      if(lineaNegocio==""){
        var lineaNegocio ="1";
      }
  
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
            error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
        });
    }


    function seleccionarPuestoEdited()
    {

       var valorTipo ="03";
       var lineaNegocio = $("#LineaNegocioPlantilla").val();
     
       $.ajax({
            type: "POST",
            url: "ajax_seleccionarPuestoPorTipo.php",
            data: {"tipoPuesto": valorTipo, "lineaNegocio":lineaNegocio},
            dataType: "json",
            async:false,
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
            error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
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
      var LineaNegocioPlantilla = $("#LineaNegocioPlantilla").val();
      var IdClientePunto = $("#IdClientePunto").val();
      if(IdClientePunto == "2" || LineaNegocioPlantilla != "1"){
        $("#txtTurnosDiariosEdited").val(numeroElementos);
        $("#txtTotalFacturaEdited").val(0);
        $("#txtTurnosMensualesEdited").val(0);
        $("#txtSubtotalEdited").val(0);
        $("#txtIvaEdited").val(0);
        $("#txtCostoTurnoEdited").val(0);
      }else{
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
      MostrarCampoElementosEdit();
    }

    function calcularTurnosDiariosAlta(){
      var tipoTurno= $("#selectTurnoRequisicionAlta").val();

      var numeroElementos=$("#txtNumeroElementosAlta").val();
      var turnosMensuales=0;
      $("#txtTotalFacturaAlta").val("");
      $("#txtIvaAlta").val("");
      $("#txtCostoTurnoAlta").val("");
      $("#txtSubtotalAlta").val("");
      var LineaNegocioPlantilla = $("#LineaNegocioPlantilla").val();

      var IdClientePunto = $("#IdClientePunto").val();
      if(IdClientePunto == "2" || LineaNegocioPlantilla != "1"){
        $("#txtTurnosMensualesAlta").val(0);
        $("#txtTotalFacturaAlta").val(0);
        $("#txtSubtotalAlta").val(0);
        $("#txtIvaAlta").val(0);
        $("#txtCostoTurnoAlta").val(0);
        $("#txtTurnosDiariosAlta").val(numeroElementos);
      }else{
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
          else{
            alert("El numero de elementos para turno de 12x36 no debe ser menor a 4 y debe ser multiplos de 4");
          }
        }
      }
      MostrarCheckDescasnos(numeroElementos);
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
        var selectTurnoRequisicionAlta = $("#selectTurnoRequisicionAlta").val();
        var tipoRequisicion=1;

        var datastring = $("#form_catalogoPuntosServicios1").serialize();

            datastring += "&diaDescanso=" + diaDescanso;
            datastring += "&diaFestivo=" + diaFestivo;
            datastring += "&dia31=" + dia31;
            datastring += "&tipoRequisicion=" + tipoRequisicion;
            datastring += "&selectTurnoRequisicionAlta=" + selectTurnoRequisicionAlta;
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
                    ocultarCamposDiasATrabajarAlta(1);


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
              },error: function(jqXHR, textStatus, errorThrown) {
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
    var CantidadElementos = $("#ElementosPlantillas").val();
    var TipoRolOperativoPlantilla = $("#TipoRolOperativoPlantilla").val();
    var rolOpEdit = $("#rolOpEdit").val();
    var selectTurnoRequisicionEdited = $("#selectTurnoRequisicionEdited").val();

    if(diaDescanso==""){diaDescanso=0;}
    if(diaFestivo==""){diaFestivo=0;}
    if(dia31==""){dia31=0;}

    if(TipoRolOperativoPlantilla != rolOpEdit && CantidadElementos > "0"){
      errorplantillaedit("No Es Posible Editar Está Plantilla Ya Que Contiene Elementos Asignados(Quite Los Elementos Para Poder Editar La Plantilla)");
    }else{//Para Evitar Una Actualizacion Con Elementos Asignados

    var datastring = $("#form_catalogoPuntosServicios1").serialize();
        datastring += "&diaDescanso=" + diaDescanso;
        datastring += "&diaFestivo=" + diaFestivo;
        datastring += "&dia31=" + dia31;
        datastring += "&tipoRequisicion=" + tipoRequisicion;
        datastring += "&idRequisicion=" + idRequisicion;
        datastring += "&selectTurnoRequisicionEdited=" + selectTurnoRequisicionEdited;

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
          $("#modalEditarPlantilla1").modal('hide');
          mostrarPlantillaEdited();
        }else if (response.status=="error"){
          alertMsg1="<div id='msgAlertPlant' class='alert alert-error'><strong>Error en la edición:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
          $("#msgEdicionReq").html(alertMsg1);
          $('#msgAlertPlant').delay(3000).fadeOut('slow');
        }
      },error : function (jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
   }
  }

  function errorplantillaedit(mensaje){

    var alertMsg1="";
    alertMsg1="<div id='msgAlertPlant' class='alert alert-error'><strong>Error en la edición:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#msgEdicionReq").html(alertMsg1);
    $('#msgAlertPlant').delay(3000).fadeOut('slow');
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
  $("#divSelectRolOperativoAlta").html("");
  $("#txtTotalFacturaAlta").prop('readonly', false);

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
            error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
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
    success: function(response) 
    {
      if (response.status == "success")
      {
        var lista = response.lista;
        document.getElementById("listPlantillaAlta").innerHTML="";
        listaRequisicionTable="<table  class='table table-hover' id='Exportar_a_Excel_requisicion'><thead  style='color:#456789;font-size:100%;'><th>Cantidad</th><th>Concepto</th><th>Turnos x Dia</th><th>T. Mes</th><th>Costo x turno</th><th>Descanso</th><th>Día 31</th><th>Festivo</th><th>Subtotal</th><th>IVA</th><th>Total</th></thead><tbody>";
        for ( var i = 0; i < lista.length; i++ )
        {
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
          var servicioPlantillaId=lista[i].idPlantilla;
          var puntoServicioPlantillaId=lista[i].puntoServicioPlantillaId;
          var puntoservicio=lista[i].puntoservicio;
          var razonSocial=lista[i].razonSocial;
          var fechaInicio=lista[i].fechaInicio;
          var fechaTerminoPlantilla=lista[i].fechaTerminoPlantilla;
          var puestoPlantillaId=lista[i].puestoPlantillaId;
          var recursosMateriales=lista[i].recursosMateriales;
          var cobraDescanso=lista[i].cobraDescansos;
          var cobraFestivos=lista[i].cobraDiaFestivo;
          var cobraDia31=lista[i].cobra31;
          var fechaInicioServicio=lista[i].fechaInicioServicio;
          var fechaTerminoServicio=lista[i].fechaTerminoServicio;
          var DescansoMismoDia = lista[i].DescansoMismoDia;
          var LunesTurnoDia = lista[i].LunesTurnoDia;
          var LunesTurnoNoche = lista[i].LunesTurnoNoche;
          var MartesTurnoDia = lista[i].MartesTurnoDia;
          var MartesTurnoNoche = lista[i].MartesTurnoNoche;
          var MiercolesTurnoDia = lista[i].MiercolesTurnoDia;
          var MiercolesTurnoNoche = lista[i].MiercolesTurnoNoche;
          var JuevesTurnoDia = lista[i].JuevesTurnoDia;
          var JuevesTurnoNoche = lista[i].JuevesTurnoNoche;
          var ViernesTurnoDia = lista[i].ViernesTurnoDia;
          var ViernesTurnoNoche = lista[i].ViernesTurnoNoche;
          var SabadoTurnoDia = lista[i].SabadoTurnoDia;
          var SabadoTurnoNoche = lista[i].SabadoTurnoNoche;
          var DomingoTurnoDia = lista[i].DomingoTurnoDia;
          var DomingoTurnoNoche = lista[i].DomingoTurnoNoche;
          var lineaNegocio=lista[i].descripcionLineaNegocio;
          var idCliente=lista[i].idClientePunto;
          var idLineaNegocioA=lista[i].idLineaNegocioPunto;
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
          if(idCliente == "2" || idLineaNegocioA != "1"){
            turnosMensuales=0;
            subtotal=0;
          }else{
            turnosMensuales=turnosPorDia*30;
            subtotal=turnosMensuales*costoPorTurno;
          }
          var costoSinIva = costoNetoFactura/1.16;
          iva = costoNetoFactura - costoSinIva;
          total=costoNetoFactura;
          subtotal = costoSinIva;
          btnAdd="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/sumaR.png";
          btnDelete="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/restar.png";
          btnEditar="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/edit.png";

          listaRequisicionTable += "<tr style='color:#456789;font-size:60%;'><td>"+numeroElementos+"</td><td>"+descripcionPuesto+" DE "+descripcionTurno+" </td><td>"+turnosPorDia+"</td><td>"+turnosMensuales+"</td><td>"+formatter.format(costoPorTurno)+"</td><td >"+cobDescanso+"</td><td>"+cob31+"</td><td>"+cobFestivos+"</td><td>"+formatter.format(subtotal)+"</td><td>"+formatter.format(iva)+"</td><td>"+formatter.format(total)+"</td>";
            
          if(idLineaNegocioA=="1" && idCliente!="2"){
            listaRequisicionTable += "<td><img class='cursorImg' src='"+btnAdd+"' data-toggle='tooltip' data-placement='right' title='ADD'  onclick='incrementarPlantilla(\"" +servicioPlantillaId+ "\")'></td><td><img class='cursorImg' src='"+btnDelete+"' data-toggle='tooltip' data-placement='right' title='DISMINUIR' onclick='disminuirPlantilla(\"" + servicioPlantillaId + "\")'></td>";
          }else {
            listaRequisicionTable += "<td>No Es Posible Agregar</td><td>No Es Posible Eliminar</td>";
          }
          listaRequisicionTable += "<td><img class='cursorImg' src='"+btnEditar+"' data-toggle='tooltip' data-placement='right' title='EDITAR' onclick='updatePlantilla("+puntoServicioPlantillaId+",\"" +puntoservicio+ "\",\"" +razonSocial+ "\",\"" +fechaInicio+ "\",\"" +fechaTerminoPlantilla+ "\",\"" +lineaNegocio+ "\",\"" +tipoTurnoPlantillaId+ "\",\"" +numeroElementos+ "\",\"" +puestoPlantillaId+ "\",\"" +costoNetoFactura+ "\",\"" +turnosPorDia+ "\",\"" +turnosMensuales+ "\",\""+subtotal+ "\",\"" +iva+ "\",\"" +costoPorTurno+ "\",\"" +comentarioRequisicion+ "\",\"" +recursosMateriales+ "\",\"" +cobraDescanso+ "\",\"" +cobraFestivos+ "\",\"" +cobraDia31+ "\",\"" +servicioPlantillaId+ "\",\"" +fechaInicioServicio+ "\",\"" +fechaTerminoServicio+ "\",\"" +rolOperativo+ "\",\"" +DescansoMismoDia+ "\",\"" +LunesTurnoDia+ "\",\"" +LunesTurnoNoche+ "\",\"" +MartesTurnoDia+ "\",\"" +MartesTurnoNoche+ "\",\"" +MiercolesTurnoDia+ "\",\"" +MiercolesTurnoNoche+ "\",\"" +JuevesTurnoDia+ "\",\"" +JuevesTurnoNoche+ "\",\"" +ViernesTurnoDia+ "\",\"" +ViernesTurnoNoche+ "\",\"" +SabadoTurnoDia+ "\",\"" +SabadoTurnoNoche+ "\",\"" +DomingoTurnoDia+ "\",\"" +DomingoTurnoNoche+ "\",\"" +idLineaNegocioA+ "\");' ></td><tr>"; 
        }
        listaRequisicionTable += "</tbody></table>";
        $('#listPlantillaAlta').html(listaRequisicionTable);
      }
      else if (response.status == "error" && response.message == "No autorizado")
      {
        window.location = "login.php";
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
  });
}

function modalEditarPunto(idPuntoServicio, idCliente, centroCosto, puntoServicio, entidad, direccion, fechaInicio, fechaTermino, cf, tff, tmf, cof, tf, ct, cot, tft, tmt, co, coo, tfo, tmo, cdes, cfes,c31,lat,lon,turnoFlat,idlineanegocio,idautoincrementindex,idRegion,descripcionregion,nombreEntidadPunto,visiblerh,cubredescansos,municipiodelegacion,unidad,CodigoPostalPuntoS,AsentamientoPuntoS,EntidadPuntoS,MunicipioPuntoS,ColoniaPuntoS,CallePrincipaPuntoS,NumeroExteriorPuntoS,NumeroInterirPuntoS,PrimerCallePuntoS,SegundaCallePuntoS){

if(EntidadPuntoS !="" && EntidadPuntoS !="NULL" && EntidadPuntoS !="null" && EntidadPuntoS !=null  && EntidadPuntoS !="0"){
  $("#txtCpContratoPuntoServicioEdit").val(CodigoPostalPuntoS);
  //$("#txtAsentamientoPuntoServicioEdit").val(AsentamientoPuntoS);
  consultaCPClientePuntoServicioEdit();
  TraerEntidadesPuntoServicioEdit();
  $("#txtEntidadClientePuntoServicioEdit").val(EntidadPuntoS);
  TraerMunicipiosPuntoServicioEdit(0);
  $("#txtMunicipioPuntoServicioEdit").val(MunicipioPuntoS);
  TraerColoniasPuntoServicioEdit(0);
  $("#txtColoniaClientePuntoServicioEdit").val(ColoniaPuntoS);
  $("#txtCallePrincipalPuntoServicioEdit").val(CallePrincipaPuntoS);
  $("#txtNumeroInteriroPuntoServicioEdit").val(NumeroExteriorPuntoS);
  $("#txtNumeroExteriorPuntoServicioEdit").val(NumeroInterirPuntoS);
  $("#txtCalle1PuntoServicioEdit").val(PrimerCallePuntoS);
  $("#txtCalle2PuntoServicioEdit").val(SegundaCallePuntoS);
}else{
  CargarSelectoresMAnualesPuntoServicioEdit();
  $("#txtCpContratoPuntoServicioEdit").val("");
  $("#txtAsentamientoPuntoServicioEdit").val(0);
  $("#txtEntidadClientePuntoServicioEdit").val(0);
  $("#txtMunicipioPuntoServicioEdit").val(0);
  $("#txtColoniaClientePuntoServicioEdit").val(0);
  $("#txtCallePrincipalPuntoServicioEdit").val("");
  $("#txtNumeroInteriroPuntoServicioEdit").val("");
  $("#txtNumeroExteriorPuntoServicioEdit").val("");
  $("#txtCalle1PuntoServicioEdit").val("");
  $("#txtCalle2PuntoServicioEdit").val("");
}

$("#modalEditarPunto1").modal();
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

if(idCliente == "43"){
  $("#selDelMunE").val(municipiodelegacion);
  $("#txtUnidadE").val(unidad);
  $("#lbDelMun").show();
  $("#lbUnidadE").show();
  $("#selDelMunE").show();
  $("#txtUnidadE").show();
}else{
  $("#selDelMunE").val("");
  $("#txtUnidadE").val("");
  $("#lbDelMun").hide();
  $("#lbUnidadE").hide();
  $("#selDelMunE").hide();
  $("#txtUnidadE").hide();
}


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

if(visiblerh==1){
  $('input[name=visiblerhEdited]').prop("checked", "true");
}else{
  $('input[name=visiblerhEdited]').prop("checked", "");
}





if(idCliente==2){
   $("#trcuredescansoEdited").show();
if(cubredescansos==1){
  $('input[name=cubredescansoEdited]').prop("checked", "true");
}else{
  $('input[name=cubredescansoEdited]').prop("checked", "");
}

}else{
  $("#trcuredescansoEdited").hide();
 $('input[name=cubredescansoEdited]').prop("checked", "");
}

}

  $(document).ready (function ()
  {
    if (rolUsuario=="Ventas")
    {
  styleTablePuntosServicios();
  ocultarCamposDiasATrabajarAlta(1);
    }

  });

  function disminuirPlantilla (servicioPlantillaId)
  {
    $.ajax({
      type: "POST",
      url: "ajax_disminuirplantilla.php",
      data:{"servicioPlantillaId":servicioPlantillaId, "action":"consultar"},
      dataType: "json",
      async: false,
      success: function(response) {
        if(response.status == "success"){
          var continuar = confirm (response.message);
          var CantidadDeTurnos1 = response.CantidadDeTurnos;
          var turnosPorDiaActual = response.turnosPorDiaActual;
          var TDiaLunesDAactualsum1 = response.datos["LunesTurnoDia"];
          var TNocheLunesDAactualsum1 = response.datos["LunesTurnoNoche"];
          var TDiaMartesDAactualsum1 = response.datos["MartesTurnoDia"];
          var TNochesMartesDAactualsum1 = response.datos["MartesTurnoNoche"];
          var TDiaMiercolesDAactualsum1 = response.datos["MiercolesTurnoDia"];
          var TNocheMiercolesDAactualsum1 = response.datos["MiercolesTurnoNoche"];
          var TDiaJuevesDAactualsum1 = response.datos["JuevesTurnoDia"];
          var TNocheJuevesDAactualsum1 = response.datos["JuevesTurnoNoche"];
          var TNocheViernesDAactualsum1 = response.datos["ViernesTurnoNoche"];
          var TDiaViernesDAactualsum1 = response.datos["ViernesTurnoDia"];
          var TNocheSabadoDAactualsum1 = response.datos["SabadoTurnoNoche"];
          var TDiaSabadoDAactualsum1 = response.datos["SabadoTurnoDia"];
          var TDiaDomingoDAactualsum1 = response.datos["DomingoTurnoDia"];
          var TNocheDomingoDAactualsum1 = response.datos["DomingoTurnoNoche"];
          $("#TDiaLunesDAactual").val(TDiaLunesDAactualsum1);
          $("#TNocheLunesDAactual").val(TNocheLunesDAactualsum1);
          $("#TDiaMartesDAactual").val(TDiaMartesDAactualsum1);
          $("#TNochesMartesDAactual").val(TNochesMartesDAactualsum1);
          $("#TDiaMiercolesDAactual").val(TDiaMiercolesDAactualsum1);
          $("#TNocheMiercolesDAactual").val(TNocheMiercolesDAactualsum1);
          $("#TDiaJuevesDAactual").val(TDiaJuevesDAactualsum1);
          $("#TNocheJuevesDAactual").val(TNocheJuevesDAactualsum1);
          $("#TNocheViernesDAactual").val(TNocheViernesDAactualsum1);
          $("#TDiaViernesDAactual").val(TDiaViernesDAactualsum1);
          $("#TNocheSabadoDAactual").val(TNocheSabadoDAactualsum1);
          $("#TDiaSabadoDAactual").val(TDiaSabadoDAactualsum1);
          $("#TDiaDomingoDAactual").val(TDiaDomingoDAactualsum1);
          $("#TNocheDomingoDAactual").val(TNocheDomingoDAactualsum1);
          var TDiaLunesDAactualsum2 = parseFloat(TDiaLunesDAactualsum1);
          var TNocheLunesDAactualsum2 = parseFloat(TNocheLunesDAactualsum1);
          var TDiaMartesDAactualsum2 = parseFloat(TDiaMartesDAactualsum1);
          var TNochesMartesDAactualsum2 = parseFloat(TNochesMartesDAactualsum1);
          var TDiaMiercolesDAactualsum2 = parseFloat(TDiaMiercolesDAactualsum1);
          var TNocheMiercolesDAactualsum2 = parseFloat(TNocheMiercolesDAactualsum1);
          var TDiaJuevesDAactualsum2 = parseFloat(TDiaJuevesDAactualsum1);
          var TNocheJuevesDAactualsum2 = parseFloat(TNocheJuevesDAactualsum1);
          var TNocheViernesDAactualsum2 = parseFloat(TNocheViernesDAactualsum1);
          var TDiaViernesDAactualsum2 = parseFloat(TDiaViernesDAactualsum1);
          var TNocheSabadoDAactualsum2 = parseFloat(TNocheSabadoDAactualsum1);
          var TDiaSabadoDAactualsum2 = parseFloat(TDiaSabadoDAactualsum1);
          var TDiaDomingoDAactualsum2 = parseFloat(TDiaDomingoDAactualsum1);
          var TNocheDomingoDAactualsum2 = parseFloat(TNocheDomingoDAactualsum1);
          var LunesSuma = ((TDiaLunesDAactualsum2)+(TNocheLunesDAactualsum2));
          var MartesSuma = ((TDiaMartesDAactualsum2)+(TNochesMartesDAactualsum2));
          var MiercolesSuma = ((TDiaMiercolesDAactualsum2)+(TNocheMiercolesDAactualsum2));
          var JuevesSuma = ((TDiaJuevesDAactualsum2)+(TNocheJuevesDAactualsum2));
          var ViernesSuma = ((TNocheViernesDAactualsum2)+(TDiaViernesDAactualsum2));
          var SabadoSuma = ((TNocheSabadoDAactualsum2)+(TDiaSabadoDAactualsum2));
          var DomingoSuma = ((TDiaDomingoDAactualsum2)+(TNocheDomingoDAactualsum2));
          if(TDiaLunesDAactualsum1 =="" && TNocheLunesDAactualsum1 == ""){
            $("#TTotalesLunesDAactual").val("");
            $("#TDiaLunesInDec").prop('readonly', true);
            $("#TNocheLunesInDec").prop('readonly', true);
          }else{
            $("#TTotalesLunesDAactual").val(LunesSuma);
            $("#TDiaLunesInDec").prop('readonly', false);
            $("#TNocheLunesInDec").prop('readonly', false);
          }
          if(TDiaMartesDAactualsum1 =="" && TNochesMartesDAactualsum1 == ""){
            $("#TTotalesMartesDAactual").val("");
            $("#TDiaMartesInDec").prop('readonly', true);
            $("#TNochesMartesInDec").prop('readonly', true);
          }else{
            $("#TTotalesMartesDAactual").val(MartesSuma);
            $("#TDiaMartesInDec").prop('readonly', false);
            $("#TNochesMartesInDec").prop('readonly', false);
          }
          if(TDiaMiercolesDAactualsum1 =="" && TNocheMiercolesDAactualsum1 == ""){
            $("#TTotalesMiercolesDAactual").val("");
            $("#TDiaMiercolesInDec").prop('readonly', true);
            $("#TNocheMiercolesInDec").prop('readonly', true);
          }else{
            $("#TTotalesMiercolesDAactual").val(MiercolesSuma);
            $("#TDiaMiercolesInDec").prop('readonly', false);
            $("#TNocheMiercolesInDec").prop('readonly', false);
          }
          if(TDiaJuevesDAactualsum1 =="" && TNocheJuevesDAactualsum1 == ""){
            $("#TTotalesJuevesDAactual").val("");
            $("#TDiaJuevesInDec").prop('readonly', true);
            $("#TNocheJuevesInDec").prop('readonly', true);
          }else{
            $("#TTotalesJuevesDAactual").val(JuevesSuma);
            $("#TDiaJuevesInDec").prop('readonly', false);
            $("#TNocheJuevesInDec").prop('readonly', false);
          }
          if(TNocheViernesDAactualsum1 =="" && TDiaViernesDAactualsum1 == ""){
            $("#TTotalesViernesDAactual").val("");
            $("#TNocheViernesInDec").prop('readonly', true);
            $("#TDiaViernesInDec").prop('readonly', true);
          }else{
            $("#TTotalesViernesDAactual").val(ViernesSuma);
            $("#TNocheViernesInDec").prop('readonly', false);
            $("#TDiaViernesInDec").prop('readonly', false);
          }
          if(TNocheSabadoDAactualsum1 =="" && TDiaSabadoDAactualsum1 == ""){
            $("#TtotalesSabadoDAactual").val("");
            $("#TNocheSabadoInDec").prop('readonly', true);
            $("#TDiaSabadoInDec").prop('readonly', true);
          }else{
            $("#TtotalesSabadoDAactual").val(SabadoSuma);
            $("#TNocheSabadoInDec").prop('readonly', false);
            $("#TDiaSabadoInDec").prop('readonly', false);
          }
          if(TDiaDomingoDAactualsum1 =="" && TNocheDomingoDAactualsum1 == ""){
            $("#TTotalesDomingoDAactual").val("");
            $("#TDiaDomingoInDec").prop('readonly', true);
            $("#TNocheDomingoInDec").prop('readonly', true);
          }else{
            $("#TTotalesDomingoDAactual").val(DomingoSuma);
            $("#TDiaDomingoInDec").prop('readonly', false);
            $("#TNocheDomingoInDec").prop('readonly', false);
          }
          if (continuar){
            $.ajax({
              type: "POST",
              url: "ajax_ObtenerEspacioDisponibleParaDisminuir.php",
              data:{"servicioPlantillaId":servicioPlantillaId},
              dataType: "json",
              async: false,
              success: function(response) {
                if (response.status == "success")
                {
                  var EspacioDisponible = response.datos;
                  if(EspacioDisponible == "0"){
                    alert("No Es Posible Disminuir La Plantilla Debido Que Tiene Todos Los Espacios Asignados Quite Una Asignación Para Disminuir");
                  }else{
                    $("#TituloIncremento").hide();
                    $("#TituloAgregar").hide();
                    $("#spamturnosA").hide();
                    $("#TituloEliminar").show();
                    $("#spamturnosE").show();
                    $("#TituloDecremento").show();
                    $("#modalPlantillaAlta1").modal("hide");
                    $("#modalTurnoDiaNoche1").modal("show");
                    $("#BanderaTurnos").val(2);
                    $("#ServicioPlantillaConsulta").val(servicioPlantillaId);
                    $("#CantidadDeTurnos").val(CantidadDeTurnos1);
                    $("#TotalDeTurnoActual").val(turnosPorDiaActual);
                  }
                }else
                {
                    alert (response.message);
                }
              },
              error: function(jqXHR, textStatus, errorThrown){
                alert(jqXHR.responseText);
              }
            });
          }
        }
        else{
          alert (response.message);
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
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
                  CancelarTurnos();// SeColoca En Caso De Que El Usuario Salga sin presionar Los Botones(Guardar,Cancelar)
                  var continuar = confirm (response.message);
                  var CantidadDeTurnos = response.CantidadDeTurnos;
                  var turnosPorDiaActual = response.turnosPorDiaActual;

                  var TDiaLunesDAactualsum1 = response.datos["LunesTurnoDia"];
                  var TNocheLunesDAactualsum1 = response.datos["LunesTurnoNoche"];
                  var TDiaMartesDAactualsum1 = response.datos["MartesTurnoDia"];
                  var TNochesMartesDAactualsum1 = response.datos["MartesTurnoNoche"];
                  var TDiaMiercolesDAactualsum1 = response.datos["MiercolesTurnoDia"];
                  var TNocheMiercolesDAactualsum1 = response.datos["MiercolesTurnoNoche"];
                  var TDiaJuevesDAactualsum1 = response.datos["JuevesTurnoDia"];
                  var TNocheJuevesDAactualsum1 = response.datos["JuevesTurnoNoche"];
                  var TNocheViernesDAactualsum1 = response.datos["ViernesTurnoNoche"];
                  var TDiaViernesDAactualsum1 = response.datos["ViernesTurnoDia"];
                  var TNocheSabadoDAactualsum1 = response.datos["SabadoTurnoNoche"];
                  var TDiaSabadoDAactualsum1 = response.datos["SabadoTurnoDia"];
                  var TDiaDomingoDAactualsum1 = response.datos["DomingoTurnoDia"];
                  var TNocheDomingoDAactualsum1 = response.datos["DomingoTurnoNoche"];

                  $("#TDiaLunesDAactual").val(TDiaLunesDAactualsum1);
                  $("#TNocheLunesDAactual").val(TNocheLunesDAactualsum1);
                  $("#TDiaMartesDAactual").val(TDiaMartesDAactualsum1);
                  $("#TNochesMartesDAactual").val(TNochesMartesDAactualsum1);
                  $("#TDiaMiercolesDAactual").val(TDiaMiercolesDAactualsum1);
                  $("#TNocheMiercolesDAactual").val(TNocheMiercolesDAactualsum1);
                  $("#TDiaJuevesDAactual").val(TDiaJuevesDAactualsum1);
                  $("#TNocheJuevesDAactual").val(TNocheJuevesDAactualsum1);
                  $("#TNocheViernesDAactual").val(TNocheViernesDAactualsum1);
                  $("#TDiaViernesDAactual").val(TDiaViernesDAactualsum1);
                  $("#TNocheSabadoDAactual").val(TNocheSabadoDAactualsum1);
                  $("#TDiaSabadoDAactual").val(TDiaSabadoDAactualsum1);
                  $("#TDiaDomingoDAactual").val(TDiaDomingoDAactualsum1);
                  $("#TNocheDomingoDAactual").val(TNocheDomingoDAactualsum1);

                  var TDiaLunesDAactualsum2 = parseFloat(TDiaLunesDAactualsum1);
                  var TNocheLunesDAactualsum2 = parseFloat(TNocheLunesDAactualsum1);
                  var TDiaMartesDAactualsum2 = parseFloat(TDiaMartesDAactualsum1);
                  var TNochesMartesDAactualsum2 = parseFloat(TNochesMartesDAactualsum1);
                  var TDiaMiercolesDAactualsum2 = parseFloat(TDiaMiercolesDAactualsum1);
                  var TNocheMiercolesDAactualsum2 = parseFloat(TNocheMiercolesDAactualsum1);
                  var TDiaJuevesDAactualsum2 = parseFloat(TDiaJuevesDAactualsum1);
                  var TNocheJuevesDAactualsum2 = parseFloat(TNocheJuevesDAactualsum1);
                  var TNocheViernesDAactualsum2 = parseFloat(TNocheViernesDAactualsum1);
                  var TDiaViernesDAactualsum2 = parseFloat(TDiaViernesDAactualsum1);
                  var TNocheSabadoDAactualsum2 = parseFloat(TNocheSabadoDAactualsum1);
                  var TDiaSabadoDAactualsum2 = parseFloat(TDiaSabadoDAactualsum1);
                  var TDiaDomingoDAactualsum2 = parseFloat(TDiaDomingoDAactualsum1);
                  var TNocheDomingoDAactualsum2 = parseFloat(TNocheDomingoDAactualsum1);
                  var LunesSuma = ((TDiaLunesDAactualsum2)+(TNocheLunesDAactualsum2));
                  var MartesSuma = ((TDiaMartesDAactualsum2)+(TNochesMartesDAactualsum2));
                  var MiercolesSuma = ((TDiaMiercolesDAactualsum2)+(TNocheMiercolesDAactualsum2));
                  var JuevesSuma = ((TDiaJuevesDAactualsum2)+(TNocheJuevesDAactualsum2));
                  var ViernesSuma = ((TNocheViernesDAactualsum2)+(TDiaViernesDAactualsum2));
                  var SabadoSuma = ((TNocheSabadoDAactualsum2)+(TDiaSabadoDAactualsum2));
                  var DomingoSuma = ((TDiaDomingoDAactualsum2)+(TNocheDomingoDAactualsum2));

                  if(TDiaLunesDAactualsum1 =="" && TNocheLunesDAactualsum1 == ""){
                    $("#TTotalesLunesDAactual").val("");
                    $("#TDiaLunesInDec").prop('readonly', true);
                    $("#TNocheLunesInDec").prop('readonly', true);
                  }else{
                    $("#TTotalesLunesDAactual").val(LunesSuma);
                    $("#TDiaLunesInDec").prop('readonly', false);
                    $("#TNocheLunesInDec").prop('readonly', false);
                  }
                  if(TDiaMartesDAactualsum1 =="" && TNochesMartesDAactualsum1 == ""){
                    $("#TTotalesMartesDAactual").val("");
                    $("#TDiaMartesInDec").prop('readonly', true);
                    $("#TNochesMartesInDec").prop('readonly', true);
                  }else{
                    $("#TTotalesMartesDAactual").val(MartesSuma);
                    $("#TDiaMartesInDec").prop('readonly', false);
                    $("#TNochesMartesInDec").prop('readonly', false);
                  }
                  if(TDiaMiercolesDAactualsum1 =="" && TNocheMiercolesDAactualsum1 == ""){
                    $("#TTotalesMiercolesDAactual").val("");
                    $("#TDiaMiercolesInDec").prop('readonly', true);
                    $("#TNocheMiercolesInDec").prop('readonly', true);
                  }else{
                    $("#TTotalesMiercolesDAactual").val(MiercolesSuma);
                    $("#TDiaMiercolesInDec").prop('readonly', false);
                    $("#TNocheMiercolesInDec").prop('readonly', false);
                  }
                  if(TDiaJuevesDAactualsum1 =="" && TNocheJuevesDAactualsum1 == ""){
                    $("#TTotalesJuevesDAactual").val("");
                    $("#TDiaJuevesInDec").prop('readonly', true);
                    $("#TNocheJuevesInDec").prop('readonly', true);
                  }else{
                    $("#TTotalesJuevesDAactual").val(JuevesSuma);
                    $("#TDiaJuevesInDec").prop('readonly', false);
                    $("#TNocheJuevesInDec").prop('readonly', false);
                  }
                  if(TNocheViernesDAactualsum1 =="" && TDiaViernesDAactualsum1 == ""){
                    $("#TTotalesViernesDAactual").val("");
                    $("#TNocheViernesInDec").prop('readonly', true);
                    $("#TDiaViernesInDec").prop('readonly', true);
                  }else{
                    $("#TTotalesViernesDAactual").val(ViernesSuma);
                    $("#TNocheViernesInDec").prop('readonly', false);
                    $("#TDiaViernesInDec").prop('readonly', false);
                  }
                  if(TNocheSabadoDAactualsum1 =="" && TDiaSabadoDAactualsum1 == ""){
                    $("#TtotalesSabadoDAactual").val("");
                    $("#TNocheSabadoInDec").prop('readonly', true);
                    $("#TDiaSabadoInDec").prop('readonly', true);
                  }else{
                    $("#TtotalesSabadoDAactual").val(SabadoSuma);
                    $("#TNocheSabadoInDec").prop('readonly', false);
                    $("#TDiaSabadoInDec").prop('readonly', false);
                  }
                  if(TDiaDomingoDAactualsum1 =="" && TNocheDomingoDAactualsum1 == ""){
                    $("#TTotalesDomingoDAactual").val("");
                    $("#TDiaDomingoInDec").prop('readonly', true);
                    $("#TNocheDomingoInDec").prop('readonly', true);
                  }else{
                    $("#TTotalesDomingoDAactual").val(DomingoSuma);
                    $("#TDiaDomingoInDec").prop('readonly', false);
                    $("#TNocheDomingoInDec").prop('readonly', false);
                  }if(turnosPorDiaActual == null || turnosPorDiaActual == "null" || turnosPorDiaActual == "NULL" || turnosPorDiaActual == ""){
                        turnosPorDiaActual = "0";    
                    }
                    if (continuar)
                    {
                      $("#TituloIncremento").show();
                      $("#TituloAgregar").show();
                      $("#spamturnosA").show();
                      $("#TituloEliminar").hide();
                      $("#spamturnosE").hide();
                      $("#TituloDecremento").hide();
                      $("#modalPlantillaAlta1").modal("hide");
                      $("#modalTurnoDiaNoche1").modal("show");
                      $("#BanderaTurnos").val(1);
                      $("#ServicioPlantillaConsulta").val(servicioPlantillaId);
                      $("#CantidadDeTurnos").val(CantidadDeTurnos);
                      $("#TotalDeTurnoActual").val(turnosPorDiaActual);
                    }
                }
                else
                {
                    alert (response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
             }
       });
  }

  function CancelarTurnos(){

    $("#modalTurnoDiaNoche1").modal("hide");
    $("#modalPlantillaAlta1").modal("show");

    $("#TDiaLunesDAactual").val("");
    $("#TNocheLunesDAactual").val("");
    $("#TDiaMartesDAactual").val("");
    $("#TNochesMartesDAactual").val("");
    $("#TDiaMiercolesDAactual").val("");
    $("#TNocheMiercolesDAactual").val("");
    $("#TDiaJuevesDAactual").val("");
    $("#TNocheJuevesDAactual").val("");
    $("#TNocheViernesDAactual").val("");
    $("#TDiaViernesDAactual").val("");
    $("#TNocheSabadoDAactual").val("");
    $("#TDiaSabadoDAactual").val("");
    $("#TDiaDomingoDAactual").val("");
    $("#TNocheDomingoDAactual").val("");
    $("#TTotalesLunesDAactual").val("");
    $("#TTotalesMartesDAactual").val("");
    $("#TTotalesMiercolesDAactual").val("");
    $("#TTotalesJuevesDAactual").val("");
    $("#TTotalesViernesDAactual").val("");
    $("#TtotalesSabadoDAactual").val("");
    $("#TTotalesDomingoDAactual").val("");


    $("#TDiaLunesInDec").val("");
    $("#TNocheLunesInDec").val("");
    $("#TDiaMartesInDec").val("");
    $("#TNochesMartesInDec").val("");
    $("#TDiaMiercolesInDec").val("");
    $("#TNocheMiercolesInDec").val("");
    $("#TDiaJuevesInDec").val("");
    $("#TNocheJuevesInDec").val("");
    $("#TNocheViernesInDec").val("");
    $("#TDiaViernesInDec").val("");
    $("#TNocheSabadoInDec").val("");
    $("#TDiaSabadoInDec").val("");
    $("#TDiaDomingoInDec").val("");
    $("#TNocheDomingoInDec").val("");
    $("#TTotalesLunesInDec").val("");
    $("#TTotalesMartesInDec").val("");
    $("#TTotalesMiercolesInDec").val("");
    $("#TTotalesJuevesInDec").val("");
    $("#TTotalesViernesInDec").val("");
    $("#TtotalesSabadoInDec").val("");
    $("#TTotalesDomingoInDec").val("");

    $("#CantidadDeTurnos").val(""); 
    $("#TotalDeTurnoActual").val("");

    $("#ServicioPlantillaConsulta").val("");
    $("#BanderaTurnos").val("");    
    consultaRequisicionAlta();

  }

  function SumatoriaTurnosInDec(caso){
      var DiaLunes1InDec = $("#TDiaLunesInDec").val();
      var NocheLunes1InDec = $("#TNocheLunesInDec").val();
      var DiaMartes1InDec = $("#TDiaMartesInDec").val();
      var NochesMartes1InDec = $("#TNochesMartesInDec").val();
      var DiaMiercoles1InDec = $("#TDiaMiercolesInDec").val();
      var NocheMiercoles1InDec = $("#TNocheMiercolesInDec").val();
      var DiaJueves1InDec = $("#TDiaJuevesInDec").val();
      var NocheJueves1InDec = $("#TNocheJuevesInDec").val();
      var NocheViernes1InDec = $("#TNocheViernesInDec").val();
      var DiaViernes1InDec = $("#TDiaViernesInDec").val();
      var NocheSabado1InDec = $("#TNocheSabadoInDec").val();
      var DiaSabado1InDec = $("#TDiaSabadoInDec").val();
      var DiaDomingo1InDec = $("#TDiaDomingoInDec").val();
      var NocheDomingo1InDec = $("#TNocheDomingoInDec").val();
      var CantidadDeTurnos = $("#CantidadDeTurnos").val(); 

      var DiaLunesintInDec = parseFloat(DiaLunes1InDec);
      var NocheLunesintInDec = parseFloat(NocheLunes1InDec);
      var DiaMartesintInDec = parseFloat(DiaMartes1InDec);
      var NochesMartesintInDec = parseFloat(NochesMartes1InDec);
      var DiaMiercolesintInDec = parseFloat(DiaMiercoles1InDec);
      var NocheMiercolesintInDec = parseFloat(NocheMiercoles1InDec);
      var DiaJuevesintInDec = parseFloat(DiaJueves1InDec);
      var NocheJuevesintInDec = parseFloat(NocheJueves1InDec);
      var NocheViernesintInDec = parseFloat(NocheViernes1InDec);
      var DiaViernesintInDec = parseFloat(DiaViernes1InDec);
      var NocheSabadointInDec = parseFloat(NocheSabado1InDec);
      var DiaSabadointInDec = parseFloat(DiaSabado1InDec);
      var DiaDomingointInDec = parseFloat(DiaDomingo1InDec);
      var NocheDomingointInDec = parseFloat(NocheDomingo1InDec);
      var txtTurnosDiariosintInDec = parseFloat(CantidadDeTurnos);

      if(caso == 1){
        var sumatorialuInDec=((DiaLunesintInDec)+(NocheLunesintInDec));
        $("#TTotalesLunesInDec").val(sumatorialuInDec);
      }else if(caso == 2){
        var sumatoriaMaInDec=((DiaMartesintInDec)+(NochesMartesintInDec));
        $("#TTotalesMartesInDec").val(sumatoriaMaInDec);
      }else if(caso == 3){
        var sumatoriaMiInDec=((DiaMiercolesintInDec)+(NocheMiercolesintInDec));
        $("#TTotalesMiercolesInDec").val(sumatoriaMiInDec);
      }else if(caso == 4){
        var sumatoriaJuInDec=((DiaJuevesintInDec)+(NocheJuevesintInDec));
        $("#TTotalesJuevesInDec").val(sumatoriaJuInDec);
      }else if(caso == 5){
        var sumatoriaViInDec=((NocheViernesintInDec)+(DiaViernesintInDec));
        $("#TTotalesViernesInDec").val(sumatoriaViInDec);
      }else if(caso == 6){
        var sumatoriaSaInDec=((NocheSabadointInDec)+(DiaSabadointInDec));
        $("#TtotalesSabadoInDec").val(sumatoriaSaInDec);
      }else if(caso == 7){
        var sumatoriaDoInDec=((NocheDomingointInDec)+(DiaDomingointInDec));
        $("#TTotalesDomingoInDec").val(sumatoriaDoInDec);
      }
    }

  function condicionesturnos(){

    var TotalDeTurnoActual = $("#TotalDeTurnoActual").val();
    var BanderaTurnos = $("#BanderaTurnos").val();
    var servicioPlantillaId = $("#ServicioPlantillaConsulta").val();
    var CantidadDeTurnos = $("#CantidadDeTurnos").val();

    // Obtenemos Los Campos Ingresados Para Las Condicionales 
    var DiaLunesC = $("#TDiaLunesInDec").val();
    var NocheLunesC = $("#TNocheLunesInDec").val();
    var DiaMartesC = $("#TDiaMartesInDec").val();
    var NochesMartesC = $("#TNochesMartesInDec").val();
    var DiaMiercolesC = $("#TDiaMiercolesInDec").val();
    var NocheMiercolesC = $("#TNocheMiercolesInDec").val();
    var DiaJuevesC = $("#TDiaJuevesInDec").val();
    var NocheJuevesC = $("#TNocheJuevesInDec").val();
    var NocheViernesC = $("#TNocheViernesInDec").val();
    var DiaViernesC = $("#TDiaViernesInDec").val();
    var NocheSabadoC = $("#TNocheSabadoInDec").val();
    var DiaSabadoC = $("#TDiaSabadoInDec").val();
    var DiaDomingoC = $("#TDiaDomingoInDec").val();
    var NocheDomingoC = $("#TNocheDomingoInDec").val();
    var CantidadDeTurnosC = $("#CantidadDeTurnos").val(); 

    var DiaLunesDAactual = $("#TDiaLunesDAactual").val();
    var NocheLunesDAactual = $("#TNocheLunesDAactual").val();
    var DiaMartesDAactual = $("#TDiaMartesDAactual").val();
    var NochesMartesDAactual = $("#TNochesMartesDAactual").val();
    var DiaMiercolesDAactual = $("#TDiaMiercolesDAactual").val();
    var NocheMiercolesDAactual = $("#TNocheMiercolesDAactual").val();
    var DiaJuevesDAactual = $("#TDiaJuevesDAactual").val();
    var NocheJuevesDAactual = $("#TNocheJuevesDAactual").val();
    var NocheViernesDAactual = $("#TNocheViernesDAactual").val();
    var DiaViernesDAactual = $("#TDiaViernesDAactual").val();
    var NocheSabadoDAactual = $("#TNocheSabadoDAactual").val();
    var DiaSabadoDAactual = $("#TDiaSabadoDAactual").val();
    var DiaDomingoDAactual = $("#TDiaDomingoDAactual").val();
    var NocheDomingoDAactual = $("#TNocheDomingoDAactual").val();

    var TTotalesLunesC = $("#TTotalesLunesInDec").val();
    var TTotalesMartesC = $("#TTotalesMartesInDec").val();
    var TTotalesMiercolesC = $("#TTotalesMiercolesInDec").val();
    var TTotalesJuevesC = $("#TTotalesJuevesInDec").val();
    var TTotalesViernesC = $("#TTotalesViernesInDec").val();
    var TtotalesSabadoC = $("#TtotalesSabadoInDec").val();
    var TTotalesDomingoC = $("#TTotalesDomingoInDec").val();

    var TTotalesLunesDAactualC = $("#TTotalesLunesDAactual").val();
    var TTotalesMartesDAactualC = $("#TTotalesMartesDAactual").val();
    var TTotalesMiercolesDAactualC = $("#TTotalesMiercolesDAactual").val();
    var TTotalesJuevesDAactualC = $("#TTotalesJuevesDAactual").val();
    var TTotalesViernesDAactualC = $("#TTotalesViernesDAactual").val();
    var TtotalesSabadoDAactualC = $("#TtotalesSabadoDAactual").val();
    var TTotalesDomingoDAactualC = $("#TTotalesDomingoDAactual").val();

    if(BanderaTurnos == "1"){
      var A = "Agregar";
    }else{
      var A = "Eliminar";
    } 

    if(((TTotalesLunesDAactualC != "") && (DiaLunesC == "")) || ((TTotalesLunesDAactualC != "") && (!/^([0-9])*$/.test(DiaLunesC)))){
      cargaerroresTurnos("Ingrese La Cantidad De Turnos A Cubrir En Lunes (Dia) Si No Hay Coloque 0 (Solo Numeros)");
    }else if((BanderaTurnos == "2") && (DiaLunesDAactual=="0") && (DiaLunesC!="0")){
      cargaerroresTurnos("No Se Puede Eliminar Un Turno En Lunes (Dia) Ya Que No Existe Registros En El Actualmente");
    }else if((BanderaTurnos == "2") && (DiaLunesDAactual < DiaLunesC)){
      cargaerroresTurnos("El Turno De Lunes (Dia) A Eliminar No Puede Ser Mayor Al Turno De Lunes (Dia) Actual");
    }else if(((TTotalesLunesDAactualC != "") && (NocheLunesC == "")) || ((TTotalesLunesDAactualC != "") && (!/^([0-9])*$/.test(NocheLunesC)))){
      cargaerroresTurnos("Ingrese La Cantidad De Turnos A Cubrir En Lunes (Noche) Si No Hay Coloque 0 (Solo Numeros)");
    }else if((BanderaTurnos == "2") && (NocheLunesDAactual=="0") && (NocheLunesC!="0")){
      cargaerroresTurnos("No Se Puede Eliminar Un Turno En Lunes (Noche) Ya Que No Existe Registros En El Actualmente");
    }else if((BanderaTurnos == "2") && (NocheLunesDAactual < NocheLunesC)){
      cargaerroresTurnos("El Turno De Lunes (Noche) A Eliminar No Puede Ser Mayor Al Turno De Lunes (Noche) Actual");
    }else if((TTotalesLunesDAactualC != "") && (TTotalesLunesC != CantidadDeTurnosC) && (BanderaTurnos=="1")){
      cargaerroresTurnos("El (Total Turnos Lunes) No Puede Ser Mayor Ni Menor Que El (Total De Turnos A " + A + ")" );
    }else if((TTotalesLunesDAactualC != "") && (TTotalesLunesC != CantidadDeTurnosC) && (BanderaTurnos!="1") && (TTotalesLunesDAactualC >= "1")){
      cargaerroresTurnos("El (Total Turnos Lunes) No Puede Ser Mayor Ni Menor Que El (Total De Turnos A " + A + " Mientras Existan Registros)" );
    }else if(((TTotalesMartesDAactualC != "") && (DiaMartesC == "")) || ((TTotalesMartesDAactualC != "") && (!/^([0-9])*$/.test(DiaMartesC)))){
      cargaerroresTurnos("Ingrese La Cantidad De Turnos A Cubrir En Martes (Dia) Si No Hay Coloque 0 (Solo Numeros)");
    }else if((BanderaTurnos == "2") && (DiaMartesDAactual=="0") && (DiaMartesC!="0")){
      cargaerroresTurnos("No Se Puede Eliminar Un Turno En Martes (Dia) Ya Que No Existe Registros En El Actualmente");
    }else if((BanderaTurnos == "2") && (DiaMartesDAactual < DiaMartesC)){
      cargaerroresTurnos("El Turno De Martes (Dia) A Eliminar No Puede Ser Mayor Al Turno De Martes (Dia) Actual");
    }else if(((TTotalesMartesDAactualC != "") && (NochesMartesC == "")) || ((TTotalesMartesDAactualC != "") && (!/^([0-9])*$/.test(NochesMartesC)))){
      cargaerroresTurnos("Ingrese La Cantidad De Turnos A Cubrir En Martes (Noche) Si No Hay Coloque 0 (Solo Numeros)");
    }else if((BanderaTurnos == "2") && (NochesMartesDAactual=="0") && (NochesMartesC!="0")){
      cargaerroresTurnos("No Se Puede Eliminar Un Turno En Martes (Noche) Ya Que No Existe Registros En El Actualmente");
    }else if((BanderaTurnos == "2") && (NochesMartesDAactual < NochesMartesC)){
      cargaerroresTurnos("El Turno De Martes (Noche) A Eliminar No Puede Ser Mayor Al Turno De Martes (Noche) Actual");
    }else if((TTotalesMartesDAactualC != "") && (TTotalesMartesC != CantidadDeTurnosC) && (BanderaTurnos=="1")){
      cargaerroresTurnos("El (Total Turnos Martes) No Puede Ser Mayor Ni Menor Que El (Total De Turnos A " + A + ")" );
    }else if((TTotalesMartesDAactualC != "") && (TTotalesMartesC != CantidadDeTurnosC) && (BanderaTurnos!="1") && (TTotalesMartesDAactualC >= "1")){
      cargaerroresTurnos("El (Total Turnos Martes) No Puede Ser Mayor Ni Menor Que El (Total De Turnos A " + A + " Mientras Existan Registros)" );
    }else if(((TTotalesMiercolesDAactualC != "") && (DiaMiercolesC == "")) || ((TTotalesMiercolesDAactualC != "") && ( !/^([0-9])*$/.test(DiaMiercolesC)))){
      cargaerroresTurnos("Ingrese La Cantidad De Turnos A Cubrir En Miercoles (Dia) Si No Hay Coloque 0 (Solo Numeros)");
    }else if((BanderaTurnos == "2") && (DiaMiercolesDAactual=="0") && (DiaMiercolesC!="0")){
      cargaerroresTurnos("No Se Puede Eliminar Un Turno En Miercoles (Dia)Ya Que No Existe Registros En El Actualmente");
    }else if((BanderaTurnos == "2") && (DiaMiercolesDAactual < DiaMiercolesC)){
      cargaerroresTurnos("El Turno De Miercoles (Dia) A Eliminar No Puede Ser Mayor Al Turno De Miercoles (Dia) Actual");
    }else if(((TTotalesMiercolesDAactualC != "") && (NocheMiercolesC == "")) || ((TTotalesMiercolesDAactualC != "") && ( !/^([0-9])*$/.test(NocheMiercolesC)))){
      cargaerroresTurnos("Ingrese La Cantidad De Turnos A Cubrir En Miercoles (Noche) Si No Hay Coloque 0 (Solo Numeros)");
    }else if((BanderaTurnos == "2") && (NocheMiercolesDAactual=="0") && (NocheMiercolesC!="0")){
      cargaerroresTurnos("No Se Puede Eliminar Un Turno En Miercoles (Noche)Ya Que No Existe Registros En El Actualmente");
    }else if((BanderaTurnos == "2") && (NocheMiercolesDAactual < NocheMiercolesC)){
      cargaerroresTurnos("El Turno De Miercoles (Noche) A Eliminar No Puede Ser Mayor Al Turno De Miercoles (Noche) Actual");
    }else if((TTotalesMiercolesDAactualC != "") && (TTotalesMiercolesC != CantidadDeTurnosC) && (BanderaTurnos=="1")){
      cargaerroresTurnos("El (Total Turnos Miercoles) No Puede Ser Mayor Ni Menor Que El (Total De Turnos A " + A + ")" );
    }else if((TTotalesMiercolesDAactualC != "") && (TTotalesMiercolesC != CantidadDeTurnosC) && (BanderaTurnos!="1") && (TTotalesMiercolesDAactualC >= "1")){
      cargaerroresTurnos("El (Total Turnos Miercoles) No Puede Ser Mayor Ni Menor Que El (Total De Turnos A " + A + " Mientras Existan Registros)" );
    }else if(((TTotalesJuevesDAactualC != "") && (DiaJuevesC == "")) || ((TTotalesJuevesDAactualC != "") && ( !/^([0-9])*$/.test(DiaJuevesC)))){
      cargaerroresTurnos("Ingrese La Cantidad De Turnos A Cubrir En Jueves (Dia) Si No Hay Coloque 0 (Solo Numeros)");
    }else if((BanderaTurnos == "2") && (DiaJuevesDAactual=="0") && (DiaJuevesC!="0")){
      cargaerroresTurnos("No Se Puede Eliminar Un Turno En Jueves (Dia) Ya Que No Existe Registros En El Actualmente");
    }else if((BanderaTurnos == "2") && (DiaJuevesDAactual < DiaJuevesC)){
      cargaerroresTurnos("El Turno De Jueves (Dia) A Eliminar No Puede Ser Mayor Al Turno De Jueves (Dia) Actual");
    }else if(((TTotalesJuevesDAactualC != "") && (NocheJuevesC == "")) || ((TTotalesJuevesDAactualC != "") && ( !/^([0-9])*$/.test(NocheJuevesC)))){
      cargaerroresTurnos("Ingrese La Cantidad De Turnos A Cubrir En Jueves (Noche) Si No Hay Coloque 0 (Solo Numeros)");
    }else if((BanderaTurnos == "2") && (NocheJuevesDAactual=="0") && (NocheJuevesC!="0")){
      cargaerroresTurnos("No Se Puede Eliminar Un Turno En Jueves (Noche) Ya Que No Existe Registros En El Actualmente");
    }else if((BanderaTurnos == "2") && (NocheJuevesDAactual < NocheJuevesC)){
      cargaerroresTurnos("El Turno De Jueves (Noche) A Eliminar No Puede Ser Mayor Al Turno De Jueves (Noche) Actual");
    }else if((TTotalesJuevesDAactualC != "") && (TTotalesJuevesC != CantidadDeTurnosC) && (BanderaTurnos=="1")){
      cargaerroresTurnos("El (Total Turnos Jueves) No Puede Ser Mayor Ni Menor Que El (Total De Turnos A " + A + ")" );
    }else if((TTotalesJuevesDAactualC != "") && (TTotalesJuevesC != CantidadDeTurnosC) && (BanderaTurnos!="1") && (TTotalesJuevesDAactualC >= "1")){
      cargaerroresTurnos("El (Total Turnos Jueves) No Puede Ser Mayor Ni Menor Que El (Total De Turnos A " + A + " Mientras Existan Registros)" );
    }else if(((TTotalesViernesDAactualC != "") && (DiaViernesC == "")) || ((TTotalesViernesDAactualC != "") && (!/^([0-9])*$/.test(DiaViernesC)))){
      cargaerroresTurnos("Ingrese La Cantidad De Turnos A Cubrir En Viernes (Dia) Si No Hay Coloque 0 (Solo Numeros)");
    }else if((BanderaTurnos == "2") && (DiaViernesDAactual=="0") && (DiaViernesC!="0")){
      cargaerroresTurnos("No Se Puede Eliminar Un Turno En Viernes (Dia) Ya Que No Existe Registros En El Actualmente");
    }else if((BanderaTurnos == "2") && (DiaViernesDAactual < DiaViernesC)){
      cargaerroresTurnos("El Turno De Viernes (Dia) A Eliminar No Puede Ser Mayor Al Turno De Viernes (Dia) Actual");
    }else if(((TTotalesViernesDAactualC != "") && (NocheViernesC == "")) || ((TTotalesViernesDAactualC != "") && (!/^([0-9])*$/.test(NocheViernesC)))){
      cargaerroresTurnos("Ingrese La Cantidad De Turnos A Cubrir En Viernes (Noche) Si No Hay Coloque 0 (Solo Numeros)");
    }else if((BanderaTurnos == "2") && (NocheViernesDAactual=="0") && (NocheViernesC!="0")){
      cargaerroresTurnos("No Se Puede Eliminar Un Turno En Viernes (Noche) Ya Que No Existe Registros En El Actualmente");
    }else if((BanderaTurnos == "2") && (NocheViernesDAactual < NocheViernesC)){
      cargaerroresTurnos("El Turno De Viernes (Noche) A Eliminar No Puede Ser Mayor Al Turno De Viernes (Noche) Actual");
    }else if((TTotalesViernesDAactualC != "") && (TTotalesViernesC != CantidadDeTurnosC) && (BanderaTurnos=="1")){
      cargaerroresTurnos("El (Total Turnos Viernes) No Puede Ser Mayor Ni Menor Que El (Total De Turnos A " + A + ")" );
    }else if((TTotalesViernesDAactualC != "") && (TTotalesViernesC != CantidadDeTurnosC) && (BanderaTurnos!="1") && (TTotalesViernesDAactualC >= "1")){
      cargaerroresTurnos("El (Total Turnos Viernes) No Puede Ser Mayor Ni Menor Que El (Total De Turnos A " + A + " Mientras Existan Registros)" );
    }else if(((TtotalesSabadoDAactualC != "") && (DiaSabadoC == "")) || ((TtotalesSabadoDAactualC != "") && (!/^([0-9])*$/.test(DiaSabadoC)))){
      cargaerroresTurnos("Ingrese La Cantidad De Turnos A Cubrir En Sabado (Dia) Si No Hay Coloque 0 (Solo Numeros)");
    }else if((BanderaTurnos == "2") && (DiaSabadoDAactual=="0") && (DiaSabadoC!="0")){
      cargaerroresTurnos("No Se Puede Eliminar Un Turno En Sabado (Dia) Ya Que No Existe Registros En El Actualmente");
    }else if((BanderaTurnos == "2") && (DiaSabadoDAactual < DiaSabadoC)){
      cargaerroresTurnos("El Turno De Sabado (Dia) A Eliminar No Puede Ser Mayor Al Turno De Sabado (Dia) Actual");
    }else if(((TtotalesSabadoDAactualC != "") && (NocheSabadoC == "")) || ((TtotalesSabadoDAactualC != "") && (!/^([0-9])*$/.test(NocheSabadoC)))){
      cargaerroresTurnos("Ingrese La Cantidad De Turnos A Cubrir En Sabado (Noche) Si No Hay Coloque 0 (Solo Numeros)");
    }else if((BanderaTurnos == "2") && (NocheSabadoDAactual=="0") && (NocheSabadoC!="0")){
      cargaerroresTurnos("No Se Puede Eliminar Un Turno En Sabado (Noche) Ya Que No Existe Registros En El Actualmente");
    }else if((BanderaTurnos == "2") && (NocheSabadoDAactual < NocheSabadoC)){
      cargaerroresTurnos("El Turno De Sabado (Noche) A Eliminar No Puede Ser Mayor Al Turno De Sabado (Noche) Actual");
    }else if((TtotalesSabadoDAactualC != "") && (TtotalesSabadoC != CantidadDeTurnosC) && (BanderaTurnos=="1")){
      cargaerroresTurnos("El (Total Turnos Sabado) No Puede Ser Mayor Ni Menor Que El (Total De Turnos A " + A + ")" );
    }else if((TtotalesSabadoDAactualC != "") && (TtotalesSabadoC != CantidadDeTurnosC) && (BanderaTurnos!="1") && (TtotalesSabadoDAactualC >= "1")){
      cargaerroresTurnos("El (Total Turnos Sabado) No Puede Ser Mayor Ni Menor Que El (Total De Turnos A " + A + " Mientras Existan Registros)" );
    }else if(((TTotalesDomingoDAactualC != "") && (DiaDomingoC == "")) || ((TTotalesDomingoDAactualC != "") && (!/^([0-9])*$/.test(DiaDomingoC)))){
      cargaerroresTurnos("Ingrese La Cantidad De Turnos A Cubrir En Domingo (Dia) Si No Hay Coloque 0 (Solo Numeros)");
    }else if((BanderaTurnos == "2") && (DiaDomingoDAactual=="0") && (DiaDomingoC!="0")){
      cargaerroresTurnos("No Se Puede Eliminar Un Turno En Domingo (Dia) Ya Que No Existe Registros En El Actualmente");
    }else if((BanderaTurnos == "2") && (DiaDomingoDAactual < DiaDomingoC)){
      cargaerroresTurnos("El Turno De Domingo (Dia) A Eliminar No Puede Ser Mayor Al Turno De Domingo (Dia) Actual");
    }else if(((TTotalesDomingoDAactualC != "") && (NocheDomingoC == "")) || ((TTotalesDomingoDAactualC != "") && (!/^([0-9])*$/.test(NocheDomingoC)))){
      cargaerroresTurnos("Ingrese La Cantidad De Turnos A Cubrir En Domingo (Noche) Si No Hay Coloque 0 (Solo Numeros)");
    }else if((BanderaTurnos == "2") && (NocheDomingoDAactual=="0") && (NocheDomingoC!="0")){
      cargaerroresTurnos("No Se Puede Eliminar Un Turno En Domingo (Noche) Ya Que No Existe Registros En El Actualmente");
    }else if((BanderaTurnos == "2") && (NocheDomingoDAactual < NocheDomingoC)){
      cargaerroresTurnos("El Turno De Domingo (Noche) A Eliminar No Puede Ser Mayor Al Turno De Domingo (Noche) Actual");
    }else if((TTotalesDomingoDAactualC != "") && (TTotalesDomingoC != CantidadDeTurnosC) && (BanderaTurnos=="1")){
      cargaerroresTurnos("El (Total Turnos Domingo) No Puede Ser Mayor Ni Menor Que El (Total De Turnos A " + A + ")" );
    }else if((TTotalesDomingoDAactualC != "") && (TTotalesDomingoC != CantidadDeTurnosC) && (BanderaTurnos!="1") && (TTotalesDomingoDAactualC >= "1")){
      cargaerroresTurnos("El (Total Turnos Domingo) No Puede Ser Mayor Ni Menor Que El (Total De Turnos A " + A + " Mientras Existan Registros)" );
    }else{
      if(BanderaTurnos == "1"){
        $.ajax({
          type: "POST",
          url: "ajax_incrementaPlantilla.php",
          data:{"servicioPlantillaId":servicioPlantillaId, "action":"incrementar","DiaLunesC":DiaLunesC,"NocheLunesC":NocheLunesC,"DiaMartesC":DiaMartesC,"NochesMartesC":NochesMartesC,"DiaMiercolesC":DiaMiercolesC,"NocheMiercolesC":NocheMiercolesC,"DiaJuevesC":DiaJuevesC,"NocheJuevesC":NocheJuevesC,"NocheViernesC":NocheViernesC,"DiaViernesC":DiaViernesC,"NocheSabadoC":NocheSabadoC,"DiaSabadoC":DiaSabadoC,"DiaDomingoC":DiaDomingoC,"NocheDomingoC":NocheDomingoC},
          dataType: "json",
          async: false,
          success: function(response) {
            alert (response.message);
            CancelarTurnos();
          },
          error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
             }
        });   
      }else if(BanderaTurnos == "2"){
        $.ajax({
          type: "POST",
          url: "ajax_disminuirplantilla.php",
          data:{"servicioPlantillaId":servicioPlantillaId, "action":"disminuir","DiaLunesC":DiaLunesC,"NocheLunesC":NocheLunesC,"DiaMartesC":DiaMartesC,"NochesMartesC":NochesMartesC,"DiaMiercolesC":DiaMiercolesC,"NocheMiercolesC":NocheMiercolesC,"DiaJuevesC":DiaJuevesC,"NocheJuevesC":NocheJuevesC,"NocheViernesC":NocheViernesC,"DiaViernesC":DiaViernesC,"NocheSabadoC":NocheSabadoC,"DiaSabadoC":DiaSabadoC,"DiaDomingoC":DiaDomingoC,"NocheDomingoC":NocheDomingoC},
          dataType: "json",
          async: false,
          success: function(response) {
              alert (response.message);
              CancelarTurnos();
          },
          error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
             }
        });

        
      }
      
    }
  }

  function cargaerroresTurnos(mensaje){
  $('#mensajeerroeturnos').fadeIn();
  alertmensajeerror="<div class='alert alert-error' id='mensajeerroeturnos'>"+mensaje+"<data-dismiss='alert'>";
  $("#mensajeerroeturnos").html(alertmensajeerror);
  $('#mensajeerroeturnos').delay(3000).fadeOut('slow');
  $(document).scrollTop(0);
  //$("#"+idtxt).css('border', '#D0021B 1px solid');
}  

  function updatePuntosServicio()
    {
      //alert("hola");
    var cobraDescansos=0;
    var cobraDiaFestivo=0;
    var cobra31=0;
    var turnoFlat=0;
    var visiblerhEdited=0;
    var cubredescansoEdited=0;


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

     if($('input[name=visiblerhEdited]').is(':checked')){
      var visiblerhEdited=1;
    }
     if($('input[name=cubredescansoEdited]').is(':checked')){
      var cubredescansoEdited=1;
    }
		var clienteedited=$("#clienteE").val();
        var idPuntoServicio=$("#txtIdPuntoServicioE").val();
        var datastring = $("#form_catalogoPuntosServicios1").serialize();
            datastring += "&idPuntoServicio=" + idPuntoServicio;
            datastring += "&cobraDescansos=" + cobraDescansos;
            datastring += "&cobraDiaFestivo=" + cobraDiaFestivo;
            datastring += "&cobra31=" + cobra31;
            datastring += "&turnoFlat=" + turnoFlat;
			     datastring += "&clienteE=" + clienteedited;
            datastring += "&visiblerhEdited=" + visiblerhEdited;
            datastring += "&cubredescansoEdited=" + cubredescansoEdited;
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
                    $('#modalEditarPunto1').modal('hide');
                 }else if (response.status=="error")
                {
                  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Edicion:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#alertMsg1PE").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                }
            },

            error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
             }
        });
    }

    //}

    function existenElementosEnPlantilla(idPuntosDeServicio,idPlantilla){

      $.ajax({
        type: "POST",
        url: "ajax_cantidadEmpleadosPlantilla.php",
        data: {"idPuntosDeServicio":idPuntosDeServicio, "idPlantilla":idPlantilla,},
        dataType: "json",
        success: function(response) {
          var mensaje=response.message;
          if (response.status=="success") {
            $("#ElementosPlantillas").val("");
            var NumeroElementos1 = response.datos[0]["NumeroDeElementos"];
            $("#ElementosPlantillas").val(NumeroElementos1);
          }else if (response.status=="error"){
            alert(mensaje);      
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
        }
      });
    }
    function MostrarCheckDescasnoEdit(DescansoMismoDia,numeroElementos,rolOp){
      if((DescansoMismoDia=="1" && (numeroElementos > "1")) || ((DescansoMismoDia=="" || DescansoMismoDia=="null" || DescansoMismoDia=="NULL" || DescansoMismoDia==null) && ((rolOp == "12x12x6") || (rolOp== "12x12x5") || (rolOp== "12x12x3")) && (numeroElementos > "1"))){
        $("#checkElementosEdit").prop('checked', true);
        $("#TituloElementosEdit").show();
        $("#DivElementosEdit").show();
        $("#checkElementosEdit").val(1);
        ocultarCamposDiasATrabajarEdit(2);
      }else if((DescansoMismoDia=="1" && (numeroElementos <= "1")) || ((DescansoMismoDia=="" || DescansoMismoDia=="null" || DescansoMismoDia=="NULL" || DescansoMismoDia==null) && ((rolOp == "12x12x6") || (rolOp== "12x12x5") || (rolOp== "12x12x3")) && (numeroElementos <= "1"))){
        $("#checkElementosEdit").prop('checked', true);
        $("#TituloElementosEdit").hide();
        $("#DivElementosEdit").hide();
        $("#checkElementosEdit").val(1);
        ocultarCamposDiasATrabajarEdit(2);
      }else if((DescansoMismoDia=="0") && (numeroElementos > "1") && ((rolOp == "12x12x6") || (rolOp== "12x12x5") || (rolOp== "12x12x3"))){
        $("#checkElementosEdit").prop('checked', false);
        $("#TituloElementosEdit").show();
        $("#DivElementosEdit").show();
        $("#checkElementosEdit").val(0);
        ocultarCamposDiasATrabajarEdit(1);
      }else{
        $("#checkElementosEdit").prop('checked', false);
        $("#TituloElementosEdit").hide();
        $("#DivElementosEdit").hide();
        $("#checkElementosEdit").val(0);
        ocultarCamposDiasATrabajarEdit(1);
      } 
    }

    function updatePlantilla(idPuntoServicio, nombrePunto, razonSocial, fechaInicio, fechaTermino, lineaNegocio,tipoTurnoPlantillaId, numeroElementos, puesto, costoNetoFactura, turnosPorDia, turnosMes, subtotal, iva, costoTurno, comentarioRequisicion, recursosMateriales, cobraDescanso, cobraFestivo,cobra31,idRequisicion, fips, ftps,rolOp,DescansoMismoDia,LunesTurnoDia,LunesTurnoNoche,MartesTurnoDia,MartesTurnoNoche,MiercolesTurnoDia,MiercolesTurnoNoche,JuevesTurnoDia,JuevesTurnoNoche,ViernesTurnoDia,ViernesTurnoNoche,SabadoTurnoDia,SabadoTurnoNoche,DomingoTurnoDia,DomingoTurnoNoche,idLineaNegocioEdit){
      $("#selectTurnoRequisicionEdited").prop('disabled', false);
      $("#txtTotalFacturaEdited").prop('readonly', false);
      $("#selectTurnoRequisicionEdited").val(tipoTurnoPlantillaId);
      MostrarCheckDescasnoEdit(DescansoMismoDia,numeroElementos,rolOp);
      existenElementosEnPlantilla(idPuntoServicio,idRequisicion);
      seleccionarPuestoEdited();
      selectPuestoRequisicionEdited
      $("#TipoRolOperativoPlantilla").val("");
      $("#TipoRolOperativoPlantilla").val(rolOp);
      $("#divSelectRolOperativoEdited").html("");
      $("#modalPlantillaAlta1").modal('hide');
      $("#modalEditarPlantilla1").modal();
      $("#txtPuntoServicioIdEdited").val(idPuntoServicio);
      $("#txtPuntoServicioModalEdited").val(nombrePunto);
      $("#txtClienteModalEdited").val(razonSocial);
      $("#txtFechaInicioRequisicionEdited").val(fechaInicio);
      $("#txtFechaTerminoRequisicionEdited").val(fechaTermino);
      $("#txtIdLineaNegocioRequisicionEdited").val(idLineaNegocioEdit);
      $("#txtLineaNegocioRequisicionEdited").val(lineaNegocio);
      $("#txtNumeroElementosEdited").val(numeroElementos);
      $("#selectPuestoRequisicionEdited").val(puesto);
      $("#txtTotalFacturaEdited").val(costoNetoFactura);
      $("#txtTurnosDiariosEdited").val(turnosPorDia);
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


      $("#TDiaLunesEdit").val(LunesTurnoDia);
      $("#TNocheLunesEdit").val(LunesTurnoNoche);
      $("#TDiaMartesEdit").val(MartesTurnoDia);
      $("#TNochesMartesEdit").val(MartesTurnoNoche);
      $("#TDiaMiercolesEdit").val(MiercolesTurnoDia);
      $("#TNocheMiercolesEdit").val(MiercolesTurnoNoche);
      $("#TDiaJuevesEdit").val(JuevesTurnoDia);
      $("#TNocheJuevesEdit").val(JuevesTurnoNoche);
      $("#TNocheViernesEdit").val(ViernesTurnoNoche);
      $("#TDiaViernesEdit").val(ViernesTurnoDia);
      $("#TNocheSabadoEdit").val(SabadoTurnoNoche);
      $("#TDiaSabadoEdit").val(SabadoTurnoDia);
      $("#TDiaDomingoEdit").val(DomingoTurnoDia);
      $("#TNocheDomingoEdit").val(DomingoTurnoNoche);

      var TDiaLunesEdit01 = $("#TDiaLunesEdit").val();
      var TNocheLunesEdit01 = $("#TNocheLunesEdit").val();
      var TDiaMartesEdit01 = $("#TDiaMartesEdit").val();
      var TNochesMartesEdit01 = $("#TNochesMartesEdit").val();
      var TDiaMiercolesEdit01 = $("#TDiaMiercolesEdit").val();
      var TNocheMiercolesEdit01 = $("#TNocheMiercolesEdit").val();
      var TDiaJuevesEdit01 = $("#TDiaJuevesEdit").val();
      var TNocheJuevesEdit01 = $("#TNocheJuevesEdit").val();
      var TNocheViernesEdit01 = $("#TNocheViernesEdit").val();
      var TDiaViernesEdit01 = $("#TDiaViernesEdit").val();
      var TNocheSabadoEdit01 = $("#TNocheSabadoEdit").val();
      var TDiaSabadoEdit01 = $("#TDiaSabadoEdit").val();
      var TDiaDomingoEdit01 = $("#TDiaDomingoEdit").val();
      var TNocheDomingoEdit01 = $("#TNocheDomingoEdit").val();
      
      SumatoriaTurnosEdit(1);
      SumatoriaTurnosEdit(2);
      SumatoriaTurnosEdit(3);
      SumatoriaTurnosEdit(4);
      SumatoriaTurnosEdit(5);
      SumatoriaTurnosEdit(6);
      SumatoriaTurnosEdit(7);

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
    
      if(rolOp =="12x12x5" && rolOp!=null){
        $("#fotoFatigaE").show();
        $('#selectRolOpE > option[value="3"]').attr('selected','selected');
        $("#fotoFatigaE").html ("<img src='uploads/fotocobertura/fatigax5.png' />");
      }else if(rolOp =="12x12x6" && rolOp!=null){
        $("#fotoFatigaE").show();
        $('#selectRolOpE > option[value="2"]').attr('selected','selected');
        $("#fotoFatigaE").html ("<img src='uploads/fotocobertura/fatigax6.png' />");
      }else if(rolOp =="12x12x3" && rolOp!=null){
        $("#fotoFatigaE").hide();
        $('#selectRolOpE > option[value="4"]').attr('selected','selected');
        $("#fotoFatigaE").html ("");
      }
      mostrarRolOperativoEdicion();
    }

    function SumatoriaTurnosEdit(caso){
      var DiaLunes1Edit = $("#TDiaLunesEdit").val();
      var NocheLunes1Edit = $("#TNocheLunesEdit").val();
      var DiaMartes1Edit = $("#TDiaMartesEdit").val();
      var NochesMartes1Edit = $("#TNochesMartesEdit").val();
      var DiaMiercoles1Edit = $("#TDiaMiercolesEdit").val();
      var NocheMiercoles1Edit = $("#TNocheMiercolesEdit").val();
      var DiaJueves1Edit = $("#TDiaJuevesEdit").val();
      var NocheJueves1Edit = $("#TNocheJuevesEdit").val();
      var NocheViernes1Edit = $("#TNocheViernesEdit").val();
      var DiaViernes1Edit = $("#TDiaViernesEdit").val();
      var NocheSabado1Edit = $("#TNocheSabadoEdit").val();
      var DiaSabado1Edit = $("#TDiaSabadoEdit").val();
      var DiaDomingo1Edit = $("#TDiaDomingoEdit").val();
      var NocheDomingo1Edit = $("#TNocheDomingoEdit").val();
      var txtTurnosDiariosEdit = $("#txtTurnosDiariosEdited").val(); 

      var DiaLunesintEdit = parseFloat(DiaLunes1Edit);
      var NocheLunesintEdit = parseFloat(NocheLunes1Edit);
      var DiaMartesintEdit = parseFloat(DiaMartes1Edit);
      var NochesMartesintEdit = parseFloat(NochesMartes1Edit);
      var DiaMiercolesintEdit = parseFloat(DiaMiercoles1Edit);
      var NocheMiercolesintEdit = parseFloat(NocheMiercoles1Edit);
      var DiaJuevesintEdit = parseFloat(DiaJueves1Edit);
      var NocheJuevesintEdit = parseFloat(NocheJueves1Edit);
      var NocheViernesintEdit = parseFloat(NocheViernes1Edit);
      var DiaViernesintEdit = parseFloat(DiaViernes1Edit);
      var NocheSabadointEdit = parseFloat(NocheSabado1Edit);
      var DiaSabadointEdit = parseFloat(DiaSabado1Edit);
      var DiaDomingointEdit = parseFloat(DiaDomingo1Edit);
      var NocheDomingointEdit = parseFloat(NocheDomingo1Edit);
      var txtTurnosDiariosintEdit = parseFloat(txtTurnosDiariosEdit);

      if(caso == 1){
        var sumatorialuEdit=((DiaLunesintEdit)+(NocheLunesintEdit));
        $("#TTotalesLunesEdit").val(sumatorialuEdit);
      }else if(caso == 2){
        var sumatoriaMaEdit=((DiaMartesintEdit)+(NochesMartesintEdit));
        $("#TTotalesMartesEdit").val(sumatoriaMaEdit);
      }else if(caso == 3){
        var sumatoriaMiEdit=((DiaMiercolesintEdit)+(NocheMiercolesintEdit));
        $("#TTotalesMiercolesEdit").val(sumatoriaMiEdit);
      }else if(caso == 4){
        var sumatoriaJuEdit=((DiaJuevesintEdit)+(NocheJuevesintEdit));
        $("#TTotalesJuevesEdit").val(sumatoriaJuEdit);
      }else if(caso == 5){
        var sumatoriaViEdit=((NocheViernesintEdit)+(DiaViernesintEdit));
        $("#TTotalesViernesEdit").val(sumatoriaViEdit);
      }else if(caso == 6){
        var sumatoriaSaEdit=((NocheSabadointEdit)+(DiaSabadointEdit));
        $("#TtotalesSabadoEdit").val(sumatoriaSaEdit);
      }else if(caso == 7){
        var sumatoriaDoEdit=((NocheDomingointEdit)+(DiaDomingointEdit));
        $("#TTotalesDomingoEdit").val(sumatoriaDoEdit);
      }
    }

    $('#checkElementosEdit').change(function() {
      if($('#checkElementosEdit').is(":checked")){
      $("#checkElementosEdit").val(1);
      ocultarCamposDiasATrabajarEdit(2);
    } 
    else {
      $("#checkElementosEdit").val(0);
      ocultarCamposDiasATrabajarEdit(1);
    }
    });

    function MostrarCamposDiasATrabajarEdit(){

      $("#txtNumeroElementosEdited").val("");
      $("#txtTurnosDiariosEdited").val("");
      $("#txtTurnosMensualesEdited").val("");
      $("#TituloElementosEdit").hide();
      $("#DivElementosEdit").hide();
      $("#checkElementosEdit").prop("checked", false);
      $("#checkElementosEdit").val(0);
       ocultarCamposDiasATrabajarEdit(1);
    }

    function MostrarCampoElementosEdit(){
      var numeroElementos=$("#txtNumeroElementosEdited").val();
      var selectRolOpE11 = $("#selectRolOpE").val();
      $("#checkElementosEdit").prop("checked", false);
      $("#checkElementosEdit").val(0);
      ocultarCamposDiasATrabajarEdit(1);
      if(numeroElementos > "1" && ((selectRolOpE11 == 2) || (selectRolOpE11 == 3) || (selectRolOpE11 == 4))){
        $("#TituloElementosEdit").show();
        $("#DivElementosEdit").show();
      }else if(numeroElementos = "1" && ((selectRolOpE11 == 2) || (selectRolOpE11 == 3) || (selectRolOpE11 == 4))){
        ocultarCamposDiasATrabajarEdit(2);
        $("#TituloElementosEdit").hide();
        $("#DivElementosEdit").hide();
        $("#checkElementosEdit").prop("checked", true);
        $("#checkElementosEdit").val(1);
      }else{
        $("#TituloElementosEdit").hide();
        $("#DivElementosEdit").hide();
      }
    }
    function ocultarCamposDiasATrabajarEdit(caso){
      var LineaNegocioPlantilla = $("#LineaNegocioPlantilla").val();
      var IdClientePunto = $("#IdClientePunto").val();
      if((IdClientePunto == "2") ||(LineaNegocioPlantilla != "1" && LineaNegocioPlantilla != "3")){

          $("#TituloDiasDescansoEdit").hide();
          $("#checkLunes1Edit").hide();
          $("#checkLunesEdit").hide();
          $("#checkMartes1Edit").hide();
          $("#checkMartesEdit").hide();
          $("#checkMiercoles1Edit").hide();
          $("#checkMiercolesEdit").hide();
          $("#checkJueves1Edit").hide();
          $("#checkJuevesEdit").hide();
          $("#checkViernes1Edit").hide();
          $("#checkViernesEdit").hide();
          $("#checkSabado1Edit").hide();
          $("#checkSabadoEdit").hide();
          $("#checkDomingo1Edit").hide();
          $("#checkDomingoEdit").hide();

          $("#TDiaLunesEdit").prop('readonly', true);
          $("#TNocheLunesEdit").prop('readonly', true);
          $("#TDiaMartesEdit").prop('readonly', true);
          $("#TNochesMartesEdit").prop('readonly', true);
          $("#TDiaMiercolesEdit").prop('readonly', true);
          $("#TNocheMiercolesEdit").prop('readonly', true);
          $("#TDiaJuevesEdit").prop('readonly', true);
          $("#TNocheJuevesEdit").prop('readonly', true);
          $("#TNocheViernesEdit").prop('readonly', true);
          $("#TDiaViernesEdit").prop('readonly', true);
          $("#TNocheSabadoEdit").prop('readonly', true);
          $("#TDiaSabadoEdit").prop('readonly', true);
          $("#TDiaDomingoEdit").prop('readonly', true);
          $("#TNocheDomingoEdit").prop('readonly', true);
          $("#txtTotalFacturaEdited").prop('readonly', true);

          $("#selectTurnoRequisicionEdited").prop('disabled', true);
          $("#selectTurnoRequisicionEdited").val(5);
          $("#rolOpEdit").val("NO DEFINIDO");

      }else{

        if(caso=="1"){
  
          $("#TituloDiasDescansoEdit").hide();
          $("#checkLunes1Edit").hide();
          $("#checkLunesEdit").hide();
          $("#checkMartes1Edit").hide();
          $("#checkMartesEdit").hide();
          $("#checkMiercoles1Edit").hide();
          $("#checkMiercolesEdit").hide();
          $("#checkJueves1Edit").hide();
          $("#checkJuevesEdit").hide();
          $("#checkViernes1Edit").hide();
          $("#checkViernesEdit").hide();
          $("#checkSabado1Edit").hide();
          $("#checkSabadoEdit").hide();
          $("#checkDomingo1Edit").hide();
          $("#checkDomingoEdit").hide();
        }else{

          $("#TituloDiasDescansoEdit").show();
          $("#checkLunes1Edit").show();
          $("#checkLunesEdit").show();
          $("#checkMartes1Edit").show();
          $("#checkMartesEdit").show();
          $("#checkMiercoles1Edit").show();
          $("#checkMiercolesEdit").show();
          $("#checkJueves1Edit").show();
          $("#checkJuevesEdit").show();
          $("#checkViernes1Edit").show();
          $("#checkViernesEdit").show();
          $("#checkSabado1Edit").show();
          $("#checkSabadoEdit").show();
          $("#checkDomingo1Edit").show();
          $("#checkDomingoEdit").show();
        }
          if(LineaNegocioPlantilla == "3"){
            $("#txtTotalFacturaEdited").prop('readonly', true);
            $("#selectTurnoRequisicionEdited").prop('disabled', true);
            $("#selectTurnoRequisicionEdited").val(5);
            $("#rolOpEdit").val("NO DEFINIDO");
          }
          $("#checkLunesEdit").val(1);
          $("#checkMartesEdit").val(1);
          $("#checkMiercolesEdit").val(1);
          $("#checkJuevesEdit").val(1);
          $("#checkViernesEdit").val(1);
          $("#checkSabadoEdit").val(1);
          $("#checkDomingoEdit").val(1);
          
          $("#checkLunesEdit").prop("checked", true);
          $("#checkMartesEdit").prop("checked", true);
          $("#checkMiercolesEdit").prop("checked", true);
          $("#checkJuevesEdit").prop("checked", true);
          $("#checkViernesEdit").prop("checked", true);
          $("#checkSabadoEdit").prop("checked", true);
          $("#checkDomingoEdit").prop("checked", true);
          
          $("#TDiaLunesEdit").prop('readonly', false);
          $("#TNocheLunesEdit").prop('readonly', false);
          $("#TDiaMartesEdit").prop('readonly', false);
          $("#TNochesMartesEdit").prop('readonly', false);
          $("#TDiaMiercolesEdit").prop('readonly', false);
          $("#TNocheMiercolesEdit").prop('readonly', false);
          $("#TDiaJuevesEdit").prop('readonly', false);
          $("#TNocheJuevesEdit").prop('readonly', false);
          $("#TNocheViernesEdit").prop('readonly', false);
          $("#TDiaViernesEdit").prop('readonly', false);
          $("#TNocheSabadoEdit").prop('readonly', false);
          $("#TDiaSabadoEdit").prop('readonly', false);
          $("#TDiaDomingoEdit").prop('readonly', false);
          $("#TNocheDomingoEdit").prop('readonly', false);
    
          $("#TDiaLunesEdit").val("");
          $("#TNocheLunesEdit").val("");
          $("#TDiaMartesEdit").val("");
          $("#TNochesMartesEdit").val("");
          $("#TDiaMiercolesEdit").val("");
          $("#TNocheMiercolesEdit").val("");
          $("#TDiaJuevesEdit").val("");
          $("#TNocheJuevesEdit").val("");
          $("#TNocheViernesEdit").val("");
          $("#TDiaViernesEdit").val("");
          $("#TNocheSabadoEdit").val("");
          $("#TDiaSabadoEdit").val("");
          $("#TDiaDomingoEdit").val("");
          $("#TNocheDomingoEdit").val("");
    
          $("#TTotalesLunesEdit").val("");
          $("#TTotalesMartesEdit").val("");
          $("#TTotalesMiercolesEdit").val("");
          $("#TTotalesJuevesEdit").val("");
          $("#TTotalesViernesEdit").val("");
          $("#TtotalesSabadoEdit").val("");
          $("#TTotalesDomingoEdit").val("");
      }
    }

    $('#checkLunesEdit').change(function() {
      if($('#checkLunesEdit').is(":checked")){
      $("#checkLunesEdit").val(1);
      $("#TDiaLunesEdit").prop('readonly', false);
      $("#TNocheLunesEdit").prop('readonly', false);
    } 
    else {
      $("#checkLunesEdit").val(0);
      $("#TDiaLunesEdit").val("");
      $("#TNocheLunesEdit").val("");
      $("#TTotalesLunesEdit").val("");
      $("#TDiaLunesEdit").prop('readonly', true);
      $("#TNocheLunesEdit").prop('readonly', true);
    }
    });
    $('#checkMartesEdit').change(function() {
      if($('#checkMartesEdit').is(":checked")){
      $("#checkMartesEdit").val(1);
      $("#TDiaMartesEdit").prop('readonly', false);
      $("#TNochesMartesEdit").prop('readonly', false);
    }
    else {
      $("#checkMartesEdit").val(0);
      $("#TDiaMartesEdit").val("");
      $("#TNochesMartesEdit").val("");
      $("#TTotalesMartesEdit").val("");
      $("#TDiaMartesEdit").prop('readonly', true);
      $("#TNochesMartesEdit").prop('readonly', true);
    }
    });
    $('#checkMiercolesEdit').change(function() {
      if($('#checkMiercolesEdit').is(":checked")){
      $("#checkMiercolesEdit").val(1);
      $("#TDiaMiercolesEdit").prop('readonly', false);
      $("#TNocheMiercolesEdit").prop('readonly', false);
    } 
    else {
      $("#checkMiercolesEdit").val(0);
      $("#TDiaMiercolesEdit").val("");
      $("#TNocheMiercolesEdit").val("");
      $("#TTotalesMiercolesEdit").val("");
      $("#TDiaMiercolesEdit").prop('readonly', true);
      $("#TNocheMiercolesEdit").prop('readonly', true);
    }
    });
    $('#checkJuevesEdit').change(function() {
      if($('#checkJuevesEdit').is(":checked")){
      $("#checkJuevesEdit").val(1);
      $("#TDiaJuevesEdit").prop('readonly', false);
      $("#TNocheJuevesEdit").prop('readonly', false);
    } 
    else {
      $("#checkJuevesEdit").val(0);
      $("#TDiaJuevesEdit").val("");
      $("#TNocheJuevesEdit").val("");
      $("#TTotalesJuevesEdit").val("");
      $("#TDiaJuevesEdit").prop('readonly', true);
      $("#TNocheJuevesEdit").prop('readonly', true);
    }
    });
    $('#checkViernesEdit').change(function() {
      if($('#checkViernesEdit').is(":checked")){
      $("#checkViernesEdit").val(1);
      $("#TNocheViernesEdit").prop('readonly', false);
      $("#TDiaViernesEdit").prop('readonly', false);
    } 
    else {
      $("#checkViernesEdit").val(0);
      $("#TNocheViernesEdit").val("");
      $("#TDiaViernesEdit").val("");
      $("#TTotalesViernesEdit").val("");
      $("#TNocheViernesEdit").prop('readonly', true);
      $("#TDiaViernesEdit").prop('readonly', true);
    }
    });
    $('#checkSabadoEdit').change(function() {
      if($('#checkSabadoEdit').is(":checked")){
      $("#checkSabadoEdit").val(1);
      $("#TNocheSabadoEdit").prop('readonly', false);
      $("#TDiaSabadoEdit").prop('readonly', false);
    } 
    else {
      $("#checkSabadoEdit").val(0);
      $("#TNocheSabadoEdit").val("");
      $("#TDiaSabadoEdit").val("");
      $("#TtotalesSabadoEdit").val("");
      $("#TNocheSabadoEdit").prop('readonly', true);
      $("#TDiaSabadoEdit").prop('readonly', true);
    }
    });
    $('#checkDomingoEdit').change(function() {
      if($('#checkDomingoEdit').is(":checked")){
      $("#checkDomingoEdit").val(1);
      $("#TDiaDomingoEdit").prop('readonly', false);
      $("#TNocheDomingoEdit").prop('readonly', false);
    } 
    else {
      $("#checkDomingoEdit").val(0);
      $("#TDiaDomingoEdit").val("");
      $("#TNocheDomingoEdit").val("");
      $("#TTotalesDomingoEdit").val("");
      $("#TDiaDomingoEdit").prop('readonly', true);
      $("#TNocheDomingoEdit").prop('readonly', true);
    }
    });

    function mostrarPlantillaEdited(){

      var puntoServicioId=$("#txtPuntoServicioIdEdited").val();
      var razonSocial=$("#txtClienteModalEdited").val();
      var puntoServicio=$("#txtPuntoServicioModalEdited").val();
      var fechaInicioPuntoServicio=$("#txtFechaInicioPuntoServicioEdited").val();
      var fechaTerminoServicio=$("#txtFechaTerminoPuntoServicioEdited").val();
      var cobraDiaFestivo=$("#txtCobraFestivoE").val();
      var cobra31=$("#txtCobra31E").val();
      var cobraDescansos=$("#txtCobraDescansoE").val();
      var txtLineaNegocioRequisicionAlta = $("#txtLineaNegocioRequisicionAlta").val();
      var txtIdLineaNegocioRequisicionAlta = $("#txtIdLineaNegocioRequisicionAlta").val();
      var IdClientePunto = $("#IdClientePunto").val();

      mostrarModalPlantilla(puntoServicioId, razonSocial, puntoServicio,cobraDescansos, cobraDiaFestivo,cobra31,fechaInicioPuntoServicio,fechaTerminoServicio,txtLineaNegocioRequisicionAlta,txtIdLineaNegocioRequisicionAlta,IdClientePunto);

    }

    function mostrarRolOperativoEdicion(){
      $("#divRolTotal").hide();
      var cobraDescanso=$("#txtCobraDescansoE").val();
      var opcionTurno=document.getElementById("selectTurnoRequisicionEdited").selectedIndex;
      if(opcionTurno==1){
        if(cobraDescanso==1){
                var selectTipoRolOp="<span class='add-on'>Tipo Rol Operativo</span>";
                selectTipoRolOp+="<select name'selectRolOpE' id='selectRolOpE' onChange='cambiarRolOpE();MostrarCamposDiasATrabajarEdit();'>";
                var TipoRolOperativoPlantilla1 = $("#TipoRolOperativoPlantilla").val();
      
                if(TipoRolOperativoPlantilla1 == "12x12x6"){
                  selectTipoRolOp+="<option value='2'>12x12x6</option><option value='1'>12x12x7</option><option value='3'>12x12x5</option><option value='4'>12x12x3</option></select> ";
                   selectTipoRolOp+="<div id='fotoFatigaE' style='width:608px;height:136px;border:1px solid;text-align:center;display:flex;flex-direction: column;'></div> ";
                  $("#selectRolOpE").val("2");
                }else if(TipoRolOperativoPlantilla1 == "12x12x5"){
                  selectTipoRolOp+="<option value='3'>12x12x5</option><option value='1'>12x12x7</option><option value='2'>12x12x6</option><option value='4'>12x12x3</option></select> ";
                   selectTipoRolOp+="<div id='fotoFatigaE' style='width:608px;height:136px;border:1px solid;text-align:center;display:flex;flex-direction: column;'></div> ";
                  $("#selectRolOpE").val("3");
                }else if(TipoRolOperativoPlantilla1 == "12x12x3"){
                  selectTipoRolOp+="<option value='4'>12x12x3</option><option value='3'>12x12x5</option><option value='1'>12x12x7</option><option value='2'>12x12x6</option></select> ";
                   selectTipoRolOp+="<div id='fotoFatigaE' style='width:608px;height:136px;border:1px solid;text-align:center;display:flex;flex-direction: column;'></div> ";
                  $("#selectRolOpE").val("3");
                }else{
                  selectTipoRolOp+="<option value='1'>12x12x7</option><option value='2'>12x12x6</option><option value='3'>12x12x5</option><option value='4'>12x12x3</option></select> ";
                   selectTipoRolOp+="<div id='fotoFatigaE' style='width:608px;height:136px;border:1px solid;text-align:center;display:flex;flex-direction: column;'></div> ";
                  $("#selectRolOpE").val("1");
                }
                $("#divSelectRolOperativoEdited").html(selectTipoRolOp);
                cambiarRolOpE();
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
        if(opcionTurno=="5" || opcionTurno =="6"){
          $("#rolOpEdit").val(turno);

        }else{
          $("#rolOpEdit").val(turno+"x7"); 
        } 
        $("#divRolTotal").show();
      }
    }

    function cambiarRolOpE(){
      var selectRolOpE = $("#selectRolOpE").val(); 
      
        if(selectRolOpE==1){
          $("#fotoFatigaE").show();
            $("#fotoFatigaE").html ("<img src='uploads/fotocobertura/fatigax7-1.png' />");
            $("#rolOpEdit").val("12x12x7");
        }else if(selectRolOpE==2){
          $("#fotoFatigaE").show();
            $("#fotoFatigaE").html ("<img src='uploads/fotocobertura/fatigax6.png' />");
            $("#rolOpEdit").val("12x12x6");
        }else if(selectRolOpE==3){
          $("#fotoFatigaE").show();
            $("#fotoFatigaE").html ("<img src='uploads/fotocobertura/fatigax5.png' />");
            $("#rolOpEdit").val("12x12x5");
        }else{
            $("#fotoFatigaE").hide();
            $("#fotoFatigaE").html ("");
            $("#rolOpEdit").val("12x12x3");
        }
    }

    function mostrarRolOperativoAlta(){
      $("#divVistaAltaRolOp").hide();
       var cobraDescanso=$("#txtCobraDescansoRA").val();
      var opcionTurno=document.getElementById("selectTurnoRequisicionAlta").selectedIndex;
      if(opcionTurno==1){
        if(cobraDescanso==1){
                var selectTipoRolOp="<span class='add-on'>Tipo Rol Operativo</span>";
                selectTipoRolOp+="<select name'selectRolOpA' id='selectRolOpA' onChange='cambiarRolOpA();BorrarCantidadDeEmpeado();'>";
                selectTipoRolOp+="<option value='1'>12x12x7</option><option value='2'>12x12x6</option><option value='3'>12x12x5</option><option value='4'>12x12x3</option></select> ";
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
        if(opcionTurno =="5" || opcionTurno =="6"){
          $("#rolOpNuevo").val(turno);
        }else{
          $("#rolOpNuevo").val(turno+"x7");
        }
        $("#divVistaAltaRolOp").show();
      }
      BorrarCantidadDeEmpeado();
    }
    function BorrarCantidadDeEmpeado(){
      $("#txtNumeroElementosAlta").val("");
      $("#txtTurnosDiariosAlta").val("");
      $("#txtTurnosMensualesAlta").val("");
      ocultarCamposDiasATrabajarAlta(1);
      $("#checkElementosAlta").prop("checked", false);
      $("#checkElementosAlta").val(0);
      $("#TituloElementos").hide();
      $("#DivElementos").hide();

    }
    function MostrarCheckDescasnos(numeroElementos){
      var selectRolOpA11 = $("#selectRolOpA").val();
      if(numeroElementos > 1 && ((selectRolOpA11 == 2) || (selectRolOpA11 == 3) || (selectRolOpA11 == 4))){
        $("#checkElementosAlta").prop("checked", false);
        $("#TituloElementos").show();
        $("#DivElementos").show();
        ocultarCamposDiasATrabajarAlta(1);
      }else if(numeroElementos == 1 && ((selectRolOpA11 == 2) || (selectRolOpA11 == 3) || (selectRolOpA11 == 4))){
        $("#checkElementosAlta").prop("checked", true);
        $("#checkElementosAlta").val(1);
        $("#TituloElementos").hide();
        $("#DivElementos").hide();
        ocultarCamposDiasATrabajarAlta(2);
      }else{
        $("#checkElementosAlta").prop("checked", false);
        $("#checkElementosAlta").val(0);
        $("#TituloElementos").hide();
        $("#DivElementos").hide();
        ocultarCamposDiasATrabajarAlta(1);
      }
    }

    $('#checkElementosAlta').change(function() {
      if($('#checkElementosAlta').is(":checked")){
        $("#checkElementosAlta").val(1);
        ocultarCamposDiasATrabajarAlta(2);
      } 
      else {
        $("#checkElementosAlta").val(0);
        ocultarCamposDiasATrabajarAlta(1);
      }
    });

    function ocultarCamposDiasATrabajarAlta(caso){
      var LineaNegocioPlantilla = $("#LineaNegocioPlantilla").val();
      var IdClientePunto = $("#IdClientePunto").val();
      if((IdClientePunto == "2") || (LineaNegocioPlantilla != "1" && LineaNegocioPlantilla != "3")){

        $("#TituloDiasDescansoAlta").hide();
        $("#checkLunes1Alta").hide();
        $("#checkLunesAlta").hide();
        $("#checkMartes1Alta").hide();
        $("#checkMartesAlta").hide();
        $("#checkMiercoles1Alta").hide();
        $("#checkMiercolesAlta").hide();
        $("#checkJueves1Alta").hide();
        $("#checkJuevesAlta").hide();
        $("#checkViernes1Alta").hide();
        $("#checkViernesAlta").hide();
        $("#checkSabado1Alta").hide();
        $("#checkSabadoAlta").hide();
        $("#checkDomingo1Alta").hide();
        $("#checkDomingoAlta").hide();
        $("#TituloElementos").hide();
        $("#DivElementos").hide();

        $("#TDiaLunesAlta").prop('readonly', true);
        $("#TNocheLunesAlta").prop('readonly', true);
        $("#TDiaMartesAlta").prop('readonly', true);
        $("#TNochesMartesAlta").prop('readonly', true);
        $("#TDiaMiercolesAlta").prop('readonly', true);
        $("#TNocheMiercolesAlta").prop('readonly', true);
        $("#TDiaJuevesAlta").prop('readonly', true);
        $("#TNocheJuevesAlta").prop('readonly', true);
        $("#TNocheViernesAlta").prop('readonly', true);
        $("#TDiaViernesAlta").prop('readonly', true);
        $("#TNocheSabadoAlta").prop('readonly', true);
        $("#TDiaSabadoAlta").prop('readonly', true);
        $("#TDiaDomingoAlta").prop('readonly', true);
        $("#TNocheDomingoAlta").prop('readonly', true);
        $("#txtTotalFacturaAlta").prop('readonly', true);

        $("#selectTurnoRequisicionAlta").val(5);
        $("#selectTurnoRequisicionAlta").prop('disabled', true);
        $("#divVistaAltaRolOp").show();
        $("#rolOpNuevo").val("NO DEFINIDO");

    }else{

      

      if(caso=="1"){

        $("#TituloDiasDescansoAlta").hide();
        $("#checkLunes1Alta").hide();
        $("#checkLunesAlta").hide();
        $("#checkMartes1Alta").hide();
        $("#checkMartesAlta").hide();
        $("#checkMiercoles1Alta").hide();
        $("#checkMiercolesAlta").hide();
        $("#checkJueves1Alta").hide();
        $("#checkJuevesAlta").hide();
        $("#checkViernes1Alta").hide();
        $("#checkViernesAlta").hide();
        $("#checkSabado1Alta").hide();
        $("#checkSabadoAlta").hide();
        $("#checkDomingo1Alta").hide();
        $("#checkDomingoAlta").hide();
      }else{

        $("#TituloDiasDescansoAlta").show();
        $("#checkLunes1Alta").show();
        $("#checkLunesAlta").show();
        $("#checkMartes1Alta").show();
        $("#checkMartesAlta").show();
        $("#checkMiercoles1Alta").show();
        $("#checkMiercolesAlta").show();
        $("#checkJueves1Alta").show();
        $("#checkJuevesAlta").show();
        $("#checkViernes1Alta").show();
        $("#checkViernesAlta").show();
        $("#checkSabado1Alta").show();
        $("#checkSabadoAlta").show();
        $("#checkDomingo1Alta").show();
        $("#checkDomingoAlta").show();
      }
      
      $("#TDiaLunesAlta").prop('readonly', false);
      $("#TNocheLunesAlta").prop('readonly', false);
      $("#TDiaMartesAlta").prop('readonly', false);
      $("#TNochesMartesAlta").prop('readonly', false);
      $("#TDiaMiercolesAlta").prop('readonly', false);
      $("#TNocheMiercolesAlta").prop('readonly', false);
      $("#TDiaJuevesAlta").prop('readonly', false);
      $("#TNocheJuevesAlta").prop('readonly', false);
      $("#TNocheViernesAlta").prop('readonly', false);
      $("#TDiaViernesAlta").prop('readonly', false);
      $("#TNocheSabadoAlta").prop('readonly', false);
      $("#TDiaSabadoAlta").prop('readonly', false);
      $("#TDiaDomingoAlta").prop('readonly', false);
      $("#TNocheDomingoAlta").prop('readonly', false);
      if(LineaNegocioPlantilla == "3"){
        $("#txtTotalFacturaAlta").prop('readonly', true);
        $("#selectTurnoRequisicionAlta").val(5);
        $("#selectTurnoRequisicionAlta").prop('disabled', true);
        $("#divVistaAltaRolOp").show();
        $("#rolOpNuevo").val("NO DEFINIDO");
      }

    }
      $("#checkLunesAlta").val(1);
      $("#checkMartesAlta").val(1);
      $("#checkMiercolesAlta").val(1);
      $("#checkJuevesAlta").val(1);
      $("#checkViernesAlta").val(1);
      $("#checkSabadoAlta").val(1);
      $("#checkDomingoAlta").val(1);
      
      $("#checkLunesAlta").prop("checked", true);
      $("#checkMartesAlta").prop("checked", true);
      $("#checkMiercolesAlta").prop("checked", true);
      $("#checkJuevesAlta").prop("checked", true);
      $("#checkViernesAlta").prop("checked", true);
      $("#checkSabadoAlta").prop("checked", true);
      $("#checkDomingoAlta").prop("checked", true);

      $("#TDiaLunesAlta").val("");
      $("#TNocheLunesAlta").val("");
      $("#TDiaMartesAlta").val("");
      $("#TNochesMartesAlta").val("");
      $("#TDiaMiercolesAlta").val("");
      $("#TNocheMiercolesAlta").val("");
      $("#TDiaJuevesAlta").val("");
      $("#TNocheJuevesAlta").val("");
      $("#TNocheViernesAlta").val("");
      $("#TDiaViernesAlta").val("");
      $("#TNocheSabadoAlta").val("");
      $("#TDiaSabadoAlta").val("");
      $("#TDiaDomingoAlta").val("");
      $("#TNocheDomingoAlta").val("");

      $("#TTotalesLunesAlta").val("");
      $("#TTotalesMartesAlta").val("");
      $("#TTotalesMiercolesAlta").val("");
      $("#TTotalesJuevesAlta").val("");
      $("#TTotalesViernesAlta").val("");
      $("#TtotalesSabadoAlta").val("");
      $("#TTotalesDomingoAlta").val("");
    }

    $('#checkLunesAlta').change(function() {
      if($('#checkLunesAlta').is(":checked")){
      $("#checkLunesAlta").val(1);
      $("#TDiaLunesAlta").prop('readonly', false);
      $("#TNocheLunesAlta").prop('readonly', false);
      } 
      else {
      $("#checkLunesAlta").val(0);
      $("#TDiaLunesAlta").val("");
      $("#TNocheLunesAlta").val("");
      $("#TTotalesLunesAlta").val("");
      $("#TDiaLunesAlta").prop('readonly', true);
      $("#TNocheLunesAlta").prop('readonly', true);
    }
    });
    $('#checkMartesAlta').change(function() {
      if($('#checkMartesAlta').is(":checked")){
      $("#checkMartesAlta").val(1);
      $("#TDiaMartesAlta").prop('readonly', false);
      $("#TNochesMartesAlta").prop('readonly', false);
      }
      else {
      $("#checkMartesAlta").val(0);
      $("#TDiaMartesAlta").val("");
      $("#TNochesMartesAlta").val("");
      $("#TTotalesMartesAlta").val("");
      $("#TDiaMartesAlta").prop('readonly', true);
      $("#TNochesMartesAlta").prop('readonly', true);
    }
    });
    $('#checkMiercolesAlta').change(function() {
      if($('#checkMiercolesAlta').is(":checked")){
      $("#checkMiercolesAlta").val(1);
      $("#TDiaMiercolesAlta").prop('readonly', false);
      $("#TNocheMiercolesAlta").prop('readonly', false);
      } 
      else {
      $("#checkMiercolesAlta").val(0);
      $("#TDiaMiercolesAlta").val("");
      $("#TNocheMiercolesAlta").val("");
      $("#TTotalesMiercolesAlta").val("");
      $("#TDiaMiercolesAlta").prop('readonly', true);
      $("#TNocheMiercolesAlta").prop('readonly', true);
    }
    });
    $('#checkJuevesAlta').change(function() {
      if($('#checkJuevesAlta').is(":checked")){
      $("#checkJuevesAlta").val(1);
      $("#TDiaJuevesAlta").prop('readonly', false);
      $("#TNocheJuevesAlta").prop('readonly', false);
      } 
      else {
      $("#checkJuevesAlta").val(0);
      $("#TDiaJuevesAlta").val("");
      $("#TNocheJuevesAlta").val("");
      $("#TTotalesJuevesAlta").val("");
      $("#TDiaJuevesAlta").prop('readonly', true);
      $("#TNocheJuevesAlta").prop('readonly', true);
    }
    });
    $('#checkViernesAlta').change(function() {
      if($('#checkViernesAlta').is(":checked")){
      $("#checkViernesAlta").val(1);
      $("#TNocheViernesAlta").prop('readonly', false);
      $("#TDiaViernesAlta").prop('readonly', false);
      } 
      else {
      $("#checkViernesAlta").val(0);
      $("#TNocheViernesAlta").val("");
      $("#TDiaViernesAlta").val("");
      $("#TTotalesViernesAlta").val("");
      $("#TNocheViernesAlta").prop('readonly', true);
      $("#TDiaViernesAlta").prop('readonly', true);
    }
    });
    $('#checkSabadoAlta').change(function() {
      if($('#checkSabadoAlta').is(":checked")){
      $("#checkSabadoAlta").val(1);
      $("#TNocheSabadoAlta").prop('readonly', false);
      $("#TDiaSabadoAlta").prop('readonly', false);
      } 
      else {
      $("#checkSabadoAlta").val(0);
      $("#TNocheSabadoAlta").val("");
      $("#TDiaSabadoAlta").val("");
      $("#TtotalesSabadoAlta").val("");
      $("#TNocheSabadoAlta").prop('readonly', true);
      $("#TDiaSabadoAlta").prop('readonly', true);
    }
    });
    $('#checkDomingoAlta').change(function() {
      if($('#checkDomingoAlta').is(":checked")){
      $("#checkDomingoAlta").val(1);
      $("#TDiaDomingoAlta").prop('readonly', false);
      $("#TNocheDomingoAlta").prop('readonly', false);
      } 
      else {
      $("#checkDomingoAlta").val(0);
      $("#TDiaDomingoAlta").val("");
      $("#TNocheDomingoAlta").val("");
      $("#TTotalesDomingoAlta").val("");
      $("#TDiaDomingoAlta").prop('readonly', true);
      $("#TNocheDomingoAlta").prop('readonly', true);
    }
    });

    function SumatoriaTurnosAlta(caso){
      var DiaLunes1Alta = $("#TDiaLunesAlta").val();
      var NocheLunes1Alta = $("#TNocheLunesAlta").val();
      var DiaMartes1Alta = $("#TDiaMartesAlta").val();
      var NochesMartes1Alta = $("#TNochesMartesAlta").val();
      var DiaMiercoles1Alta = $("#TDiaMiercolesAlta").val();
      var NocheMiercoles1Alta = $("#TNocheMiercolesAlta").val();
      var DiaJueves1Alta = $("#TDiaJuevesAlta").val();
      var NocheJueves1Alta = $("#TNocheJuevesAlta").val();
      var NocheViernes1Alta = $("#TNocheViernesAlta").val();
      var DiaViernes1Alta = $("#TDiaViernesAlta").val();
      var NocheSabado1Alta = $("#TNocheSabadoAlta").val();
      var DiaSabado1Alta = $("#TDiaSabadoAlta").val();
      var DiaDomingo1Alta = $("#TDiaDomingoAlta").val();
      var NocheDomingo1Alta = $("#TNocheDomingoAlta").val();
      var txtTurnosDiarios1Alta = $("#txtTurnosDiariosAlta").val();

      var DiaLunesintAlta = parseFloat(DiaLunes1Alta);
      var NocheLunesintAlta = parseFloat(NocheLunes1Alta);
      var DiaMartesintAlta = parseFloat(DiaMartes1Alta);
      var NochesMartesintAlta = parseFloat(NochesMartes1Alta);
      var DiaMiercolesintAlta = parseFloat(DiaMiercoles1Alta);
      var NocheMiercolesintAlta = parseFloat(NocheMiercoles1Alta);
      var DiaJuevesintAlta = parseFloat(DiaJueves1Alta);
      var NocheJuevesintAlta = parseFloat(NocheJueves1Alta);
      var NocheViernesintAlta = parseFloat(NocheViernes1Alta);
      var DiaViernesintAlta = parseFloat(DiaViernes1Alta);
      var NocheSabadointAlta = parseFloat(NocheSabado1Alta);
      var DiaSabadointAlta = parseFloat(DiaSabado1Alta);
      var DiaDomingointAlta = parseFloat(DiaDomingo1Alta);
      var NocheDomingointAlta = parseFloat(NocheDomingo1Alta);
      var txtTurnosDiariosintAlta = parseFloat(txtTurnosDiarios1Alta);

      if(caso == 1){
        var sumatorialuAlta=((DiaLunesintAlta)+(NocheLunesintAlta));
        $("#TTotalesLunesAlta").val(sumatorialuAlta);
      }else if(caso == 2){
        var sumatoriaMaAlta=((DiaMartesintAlta)+(NochesMartesintAlta));
        $("#TTotalesMartesAlta").val(sumatoriaMaAlta);
      }else if(caso == 3){
        var sumatoriaMiAlta=((DiaMiercolesintAlta)+(NocheMiercolesintAlta));
        $("#TTotalesMiercolesAlta").val(sumatoriaMiAlta);
      }else if(caso == 4){
        var sumatoriaJuAlta=((DiaJuevesintAlta)+(NocheJuevesintAlta));
        $("#TTotalesJuevesAlta").val(sumatoriaJuAlta);
      }else if(caso == 5){
        var sumatoriaViAlta=((NocheViernesintAlta)+(DiaViernesintAlta));
        $("#TTotalesViernesAlta").val(sumatoriaViAlta);
      }else if(caso == 6){
        var sumatoriaSaAlta=((NocheSabadointAlta)+(DiaSabadointAlta));
        $("#TtotalesSabadoAlta").val(sumatoriaSaAlta);
      }else if(caso == 7){
        var sumatoriaDoAlta=((NocheDomingointAlta)+(DiaDomingointAlta));
        $("#TTotalesDomingoAlta").val(sumatoriaDoAlta);
      }
    }

    function cambiarRolOpA(){
        var opcionOperativo=document.getElementById("selectRolOpA").selectedIndex;
        if(opcionOperativo==0){
          $("#fotoFatigaA").show();
            $("#fotoFatigaA").html ("<img src='uploads/fotocobertura/fatigax7-1.png' />");
            $("#rolOpNuevo").val("12x12x7");
        }else if(opcionOperativo==1){
          $("#fotoFatigaA").show();
             $("#fotoFatigaA").html ("<img src='uploads/fotocobertura/fatigax6.png' />");
            $("#rolOpNuevo").val("12x12x6");
        }else if(opcionOperativo==2){
          $("#fotoFatigaA").show();
            $("#fotoFatigaA").html ("<img src='uploads/fotocobertura/fatigax5.png' />");
            $("#rolOpNuevo").val("12x12x5");
        }else{
            $("#fotoFatigaA").hide();
            $("#fotoFatigaA").html("");
            $("#rolOpNuevo").val("12x12x3");
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
  cargaselectormunicipioEdited(idEntidadEdited);
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

function cargaselectormunicipioEdited(identidad){
  //alert("cargar municioio conforme la entidad "+identidad);
  $.ajax({
              type: "POST",
              url: "ajax_consultamunicipiosbyentidad.php",
              data: {
                "idEntidad":identidad
              },
              dataType: "json",
               async:false, 
              success: function(response) {
                //console.log(response);
                var datos = response.datos;
                  $('#selDelMunE').empty().append('<option value="0" selected="selected">DELEGACIÓN/MUNICIPIO</option>');
                  $.each(datos, function(i) {
                      $('#selDelMunE').append('<option value="' + response.datos[i].idMunicipio + '">' + response.datos[i].nombreMunicipio + '</option>');
                  });  
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              } 
          });
}


function CargarSelectoresMAnualesPuntoServicioEdit(){
 
    TraerEntidadesPuntoServicioEdit();
    $('#txtMunicipioPuntoServicioEdit').empty().append('<option value="0">Municipios</option>');
    $('#txtColoniaClientePuntoServicioEdit').empty().append('<option value="0">Colonias</option>');
    $('#txtAsentamientoPuntoServicioEdit').empty().append('<option value="0">Asentamiento</option>');
  }

  function TraerEntidadesPuntoServicioEdit(){
    $.ajax({
        type: "POST",
        url: "ajax_TraerEntidadesCliente.php",
        dataType: "json",
        async:false,
        success: function(response) {
         // console.log(response);
          var datos = response.datos;
          $('#txtEntidadClientePuntoServicioEdit').empty().append('<option value="0">Entidades</option>');
          $.each(datos, function(i) {
            $('#txtEntidadClientePuntoServicioEdit').append('<option value="' + response.datos[i].idEntidadFederativa+ '">' + response.datos[i].nombreEntidadFederativa + '</option>');
          });     
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
        }
    });  
  }

function consultaCPClientePuntoServicioEdit()
{
    var codigoPostal = $("#txtCpContratoPuntoServicioEdit").val();
    if (codigoPostal.length == 5)
    {
        $.ajax({
            type: "POST",
            url: "ajax_obtenerDirecciones.php",
            data: {txtCP : codigoPostal},
            dataType: "json",
            async: false,
            success: function(response) {
                if (response.listaDirecciones.length == 0)
                {   
                    showMessage1 ("El código postal es inválido", "error");
                }else 
                {
                    $('#txtAsentamientoPuntoServicioEdit').empty().append('<option value="0">Asentamiento</option>');
                    for (var i = 0; i < response.listaDirecciones.length; i++)
                    {
                        var direccion = response.listaDirecciones [i];
                        var params = "\"" + direccion.idAsentamiento + "\"," +
                            "\"" + direccion.nombreEntidadFederativa + "\"," +
                            "\"" + direccion.nombreMunicipio + "\"," +
                            "\"" + direccion.nombreAsentamiento + "\"," +
                            "\"" + direccion.municipioAsentamiento + "\"";
                        $('#txtAsentamientoPuntoServicioEdit').append('<option value="'+direccion.idAsentamiento+'&'+direccion.municipioAsentamiento+'&'+direccion.idEstado+'">' + params + '</option>');
                        /*displayDirecciones += "<p>" + (i + 1) + "<a href='javascript:setDireccionData(" + params + ")';>" +
                            direccion.nombreTipoAsentamiento + " " +
                            direccion.nombreAsentamiento + " " +
                            direccion.nombreMunicipio + ", " +
                            direccion.nombreEntidadFederativa + "</a></p>";*/
                    }
                   // $("#multipleDirecciones").html (displayDirecciones);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
        });
        $('#txtEntidadClientePuntoServicioEdit').val(0);
    $('#txtMunicipioPuntoServicioEdit').empty().append('<option value="0">Municipios</option>');
    $('#txtColoniaClientePuntoServicioEdit').empty().append('<option value="0">Colonias</option>');
    }
}

function TraerMunicipiosPuntoServicioEdit(Accion){
    $('#txtColoniaClientePuntoServicioEdit').empty().append('<option value="0">Colonias</option>');
    if(Accion=="0"){
        $('#txtAsentamientoPuntoServicioEdit').val(0);
    }
    var txtEntidadCliente=$("#txtEntidadClientePuntoServicioEdit").val();
    $.ajax({
        type: "POST",
        url: "ajax_TraerMunicipiosCliente.php",
        data: {txtEntidadCliente : txtEntidadCliente},
        dataType: "json",
        async:false,
        success: function(response) {
         // console.log(response);
          var datos = response.datos;
          $('#txtMunicipioPuntoServicioEdit').empty().append('<option value="0">Municipios</option>');
          $.each(datos, function(i) {
            $('#txtMunicipioPuntoServicioEdit').append('<option value="' + response.datos[i].idMunicipio+ '">' + response.datos[i].nombreMunicipio + '</option>');
          });     
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
        }
    });  
  }

  function TraerColoniasPuntoServicioEdit(Accion){
    if(Accion=="0"){
        $('#txtAsentamientoPuntoServicioEdit').val(0);
    }
    var txtMunicipio=$("#txtMunicipioPuntoServicioEdit").val();
    $.ajax({
        type: "POST",
        url: "ajax_TraerColoniasCliente.php",
        data: {txtMunicipio : txtMunicipio},
        dataType: "json",
        async:false,
        success: function(response) {
         // console.log(response);
          var datos = response.datos;
          $('#txtColoniaClientePuntoServicioEdit').empty().append('<option value="0">Colonias</option>');
          $.each(datos, function(i) {
            $('#txtColoniaClientePuntoServicioEdit').append('<option value="' + response.datos[i].idAsentamiento+ '">' + response.datos[i].nombreAsentamiento + '</option>');
          });     
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
        }
    });  
  }

  $("#txtAsentamientoPuntoServicioEdit").change(function()
{
  alert("entree");
    var txtAsentamiento = $("#txtAsentamientoPuntoServicioEdit").val();
    if(txtAsentamiento=="0"){
      TraerEntidadesPuntoServicioEdit();
      $('#txtMunicipioPuntoServicioEdit').empty().append('<option value="0">Municipios</option>');
      $('#txtColoniaClientePuntoServicioEdit').empty().append('<option value="0">Colonias</option>');
    }else{
      var splitasentamiento = txtAsentamiento.split('&'); 
      var idColonia = splitasentamiento[0];
      var idmunicipio = splitasentamiento[1];
      var idEntidad = splitasentamiento[2];
      $("#txtEntidadClientePuntoServicioEdit").val(idEntidad);
      TraerMunicipiosPuntoServicioEdit(1);
      $("#txtMunicipioPuntoServicioEdit").val(idmunicipio);
      TraerColoniasPuntoServicioEdit(1);
      $("#txtColoniaClientePuntoServicioEdit").val(idColonia);
    }
});














  </script>
