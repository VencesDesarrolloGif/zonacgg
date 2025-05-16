<?php
//$catalogoEntidades= $negocio -> negocio_obtenerListaEntidadesFeferativas();
$catalogoClientes= $negocio -> negocio_obtenerListaClientesActivos();
 $catalogoLineaNegocioRegistroPunto                = $negocio->negocio_obtenerListaLineaNegocio();
?>
<div class="container" align="center">
<form class="form-horizontal"  method="post" id="form_registroPuntoServicio" name="form_registroPuntoServicio" action="ficheroExcelMovimientos.php" target="_blank">
<div >
  <fieldset >        
    <legend>Registro de Punto de servicio
  </fieldset>
  <table>
  <tr>
    <td  rowspan="41"><img src="img/localizacion.jpg"></td>
    <td><label class="control-label1 label" for="numOrden">Numero Orden</label></td>
    <td><input id="txtNumeroOrden" name="txtNumeroOrden" type="text" class="input-small" readonly ></td>
  </tr>
  <tr><td> <label class="control-label1 label" for="rfc">Cliente</label></td>
    <td>
             <select id="cliente" name="cliente" class="input-xlarge " onChange="">
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
    <td><label class="control-label1 label" for="centroCosto">No. Centro Costo</label></td>
    <td><input id="txtNumeroCentro" name="txtNumeroCentro" type="text" class="input-xlarge" required="hey" maxlength="8"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="puntoServicio">Nombre Punto Servicio</label></td>
    <td><input id="txtPuntoServicio" name="txtPuntoServicio" type="text" class="input-xlarge" required="hey"></td>
  </tr>


    <tr>
    <td><label class="control-label1 label" for="lineNegocio">Line de Negocio</label></td>
    <td> <select id="selLineaNegocio" name="selLineaNegocio" class="input-xlarge">
                <option VALUE="0">LINEA DE NEGOCIO</option>
                <?php
              for ($i=0; $i<count($catalogoLineaNegocioRegistroPunto); $i++)
              {
                echo "<option value='". $catalogoLineaNegocioRegistroPunto[$i]["idLineaNegocio"]."'>". $catalogoLineaNegocioRegistroPunto[$i]["descripcionLineaNegocio"] ." </option>";
              }
              ?>
        </select></td>
  </tr>


  <tr><td> <label class="control-label1 label" for="txtLocalizacion">Localizacion</label></td>
    <td>
       <select id="entidad" name="entidad" class="input-xlarge " onChange="">
               
        </select>
      </td>
  </tr>

  <tr><td> <label class="control-label1 label" for="txtLocalizacion">Region</label></td>
    <td><input id="txtRegion" name="txtRegion" type="text" class="input-xlarge" readonly>
      <input id="idtxtRegion" name="idtxtRegion" type="hidden"></td> 
  </tr>
<!--este tr solo es por si el cliente es 43 walmart-->
<tr id="trselmunicipio" style="display: none"><td> <label class="control-label1 label" for="selmunicipiowalmrt">Delegación/Municipio</label></td>
    <td><select id="selmunicipiowalmrt" name="selmunicipiowalmrt" class="input-xlarge">
      
  </tr>


<tr id="trtxtunidadwalmrt" style="display: none"><td> <label class="control-label1 label" for="txtunidad">Unidad</label></td>
    <td><input id="txtunidad" name="txtunidad" type="text" class="input-xlarge">
      
  </tr>
<!--------------------------------------------------->
    <tr>
        <td> <label class="control-label1 label" for="CpContratoPuntoServicio">Codigo Postal</label></td>
        <td><input id="txtCpContratoPuntoServicio" name="txtCpContratoPuntoServicio" class="input-small" onkeyup="consultaCPClientePuntoServicio();" maxlength="5"></td>
    </tr>
     <tr>
        <td> <label class="control-label1 label" for="AsentamientoPuntoServicio">Asentamiento</label></td>
        <td><select id="txtAsentamientoPuntoServicio" name="txtAsentamientoPuntoServicio" class="input-xlarge "></select></td>
    </tr>
     <tr>
        <td> <label class="control-label1 label" for="EntidadClientePuntoServicio">Entidad Federativa</label></td>
        <td><select id="txtEntidadClientePuntoServicio" name="txtEntidadClientePuntoServicio" onchange="TraerMunicipiosPuntoServicio(0);" class="input-xlarge"></select></td>
    </tr>
     <tr>
        <td> <label class="control-label1 label" for="MunicipioPuntoServicio">Municipio o Alcaldia</label></td>
        <td><select id="txtMunicipioPuntoServicio" name="txtMunicipioPuntoServicio" onchange="TraerColoniasPuntoServicio(0);" type="text" class="input-xlarge"></select></td>
    </tr>
    <tr>
        <td> <label class="control-label1 label" for="ColoniaClientePuntoServicio">Colonia</label></td>
        <td><select id="txtColoniaClientePuntoServicio" name="txtColoniaClientePuntoServicio" type="text" class="input-xlarge"></select></td>
    </tr>
    <tr>
        <td> <label class="control-label1 label" for="CallePrincipalPuntoServicio">Calle Principal</label></td>
        <td><input id="txtCallePrincipalPuntoServicio" name="txtCallePrincipalPuntoServicio" type="text"></td>
    </tr>
  <tr> 
        <td> <label class="control-label1 label" for="NumeroInteriroPuntoServicio">Num Interior</label></td>
        <td><input id="txtNumeroInteriroPuntoServicio" name="txtNumeroInteriroPuntoServicio" type="text" class="input-small"></td>
    </tr>
    <tr> 
        <td> <label class="control-label1 label" for="NumeroExteriorPuntoServicio">Num Exterior</label></td>
        <td><input id="txtNumeroExteriorPuntoServicio" name="txtNumeroExteriorPuntoServicio" type="text" class="input-small"></td>
    </tr>
    <tr>
        <td> <label class="control-label1 label" for="Calle1PuntoServicio">Entre Calle</label></td>
        <td><input id="txtCalle1PuntoServicio" name="txtCalle1PuntoServicio" type="text" ></td>
    </tr>
    <tr>
        <td> <label class="control-label1 label" for="Calle2PuntoServicio">Y Calle</label></td>
        <td><input id="txtCalle2PuntoServicio" name="txtCalle2PuntoServicio" type="text"></td>
    </tr>
 <!-- <tr>
    <td> <label class="control-label1 label" for="direccion">Dirección</label></td>
    <td><textarea id="txtDireccion" name="txtDireccion" class="txtArea" required="hey"></textarea></td>
  </tr>
-->  
  <tr>
    <td> <label class="control-label1 label" for="latitud">Latitud</label></td>
    <td><input id="txtLatitud" name="txtLatitud" type="text" class="input-medium" maxlength="15"></td>
  </tr>
  <tr>
    <td> <label class="control-label1 label" for="latitud">Longitud</label></td>
    <td><input id="txtLongitud" name="txtLongitud" type="text" class="input-medium" maxlength="15"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="fechaInicio">Fecha Inicio</label></td>
    <td><input id="txtFechaInicio" name="txtFechaInicio" type="text" class="input-medium" required="hey"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="fechaInicio">Fecha Termino</label></td>
    <td><input id="txtFechaTerminoServicio" name="txtFechaTerminoServicio" type="text" class="input-medium" required="hey"></td>
  </tr>
  <tr>
        <td colspan='2'>
        <div>
                <!-- List group -->
                <ul class="list-group">
 
                    <li class="list-group-item">
                        Cobra Descanso
                        <div class="material-switch pull-right">
                            <input id="someSwitchOptionSuccess" name="cobraDescanso" type="checkbox"/>
                            <label for="someSwitchOptionSuccess" class="label-success1"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Cobra Dia Festivo
                        <div class="material-switch pull-right">
                            <input id="someSwitchOptionInfo" name="cobraDiaFestivo" type="checkbox"/>
                            <label for="someSwitchOptionInfo" class="label-success1"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Cobra Dia 31
                        <div class="material-switch pull-right">
                            <input id="someSwitchOptionWarning" name="cobraDia31" type="checkbox"/>
                            <label for="someSwitchOptionWarning" class="label-success1"></label>
                        </div>
                    </li>

                </ul>
            </div>
        </td>
  </tr>
  
  <tr><td colspan="3" align="center"> <label  align="center" class="label label-info" for="direccion">Contacto Administrativo</label></td></tr>
  <tr>
    <td><label class="control-label1 label" for="contactoFacturacion">Contacto Facturacion</label></td>
    <td><input id="txtContactoFacturacion" name="txtContactoFacturacion" type="text" class="input-xlarge"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="correoFacturacion">Correo Facturacion</label></td>
    <td><input id="txtCorreoFacturacion" name="txtCorreoFacturacion" type="text" class="input-xlarge-email"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="telefonoFijoFacturacion">Tel Fijo Facturacion</label></td>
    <td><input id="txtTelefonoFijoFacturacion" name="txtTelefonoFijoFacturacion" type="text" class="input-medium"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="telefonoMovilFacturacion">Tel Movil Facturacion</label></td>
    <td><input id="txtTelefonoMovilFacturacion" name="txtTelefonoMovilFacturacion" type="text" class="input-medium"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="telefonoMovilFacturacion">Terminos Facturación  </label></td>
    <td><textarea id="txtTerminosFacturacion" name="txtTerminosFacturacion" class="txtArea" required="hey"></textarea></td>
  </tr>
  <tr>
        <td>
        <label class="control-label1 label" for="telefonoMovilFacturacion">Turnos Presupuestados</label>
        </td>
        <td>
        <div style="margin-top: 20px">
                <!-- List group -->
                <ul class="list-group">
 
                    <li class="list-group-item">
                        Turnos FLAT
                        <div class="material-switch pull-right">
                            <input id="valorFlat" name="valorFlat" type="checkbox"/>
                            <label style="margin-top: 10px" for="valorFlat" class="label-success1"></label>
                        </div>
                    </li>

                </ul>
            </div>
            <span>Si no lo seleccionas, los turnos presupuestados los calculará como MES NATURAL</span>
        </td>
  </tr>
  <tr><td colspan="3" align="center"> <label  align="center" class="label label-info" for="direccion">Contacto Tesoreria</label></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="contactoTesoreria">Contacto Tesoreria</label></td>
    <td><input id="txtContactoTesoreria" name="txtContactoTesoreria" type="text" class="input-xlarge"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="correo">Correo Tesoreria</label></td>
    <td><input id="txtCorreoTesoreria" name="txtCorreoTesoreria" type="text" class="input-xlarge-emaile"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="telefonoFijoTesoreria">Tel Fijo Tesoreria</label></td>
    <td><input id="txtTelefonoFijoTesoreria" name="txtTelefonoFijoTesoreria" type="text" class="input-medium"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="telefonoMovilTesoreria">Tel Movil Tesoreria</label></td>
    <td><input id="txtTelefonoMovilTesoreria" name="txtTelefonoMovilTesoreria" required="hey" type="text" class="input-medium"></td>
  </tr>
  <tr><td colspan="3" align="center"> <label  align="center" class="label label-info" for="direccion">Contacto Operativo</label></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="contactoOperativo">Contacto Operativo</label></td>
    <td><input id="txtContactoOperativo" name="txtContactoOperativo" type="text" class="input-xlarge"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="correo">Correo Operativo</label></td>
    <td><input id="txtCorreoOperativo" name="txtCorreoOperativo" type="text" class="input-xlarge-email"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="telefonoFijoOperativo">Tel Fijo Operativo</label></td>
    <td><input id="txtTelefonoFijoOperativo" name="txtTelefonoFijoOperativo" type="text" class="input-medium"></td>
  </tr>
  <tr>
    <td><label class="control-label1 label" for="telefonoMovilOperativo">Tel Movil Operativo</label></td>
    <td><input id="txtTelefonoMovilOperativo" name="txtTelefonoMovilOperativo" required="hey" type="text" class="input-medium"></td>
  </tr>
  <tr>
    <td>
        <label class="control-label1 label" for="visiblerh"> Visible para RH</label>
        </td>
  <td>
    
         <div style="margin-top: 20px">
                <!-- List group -->
                <ul class="list-group">
 
                    <li class="list-group-item">
                        
                        <div class="material-switch pull-right">
                            <input id="visiblerh" name="visiblerh" type="checkbox"/>
                            <label style="margin-top: 0px" for="visiblerh" class="label-success1"></label>
                        </div>
                    </li>

                </ul>
            </div>
        </td>
      </tr>
      <tr id="trcubredescanso">
         <td>
        <label class="control-label1 label" for="cubredescanso">¿PUNTO DE SERVICIO CUBREDESCANSO?</label>
        </td>
        <td>

        <div style="margin-top: 20px;margin-left: 20%">
                <!-- List group -->
                <ul class="list-group">
 
                    <li class="list-group-item">
                        
                        <div class="material-switch pull-right">
                            <input id="cubredescanso" name="cubredescanso" type="checkbox"/>
                            <label style="margin-top: 0px" for="cubredescanso" class="label-success1"></label>
                        </div>
                    </li>

                </ul>
            </div>
        </td>
      </tr>
  <tr><td  colspan="3" align="center"><button id="guardar" name="guardar" class="btn btn-primary" type="button" onclick="guardarPuntoServicio();"> <span class="glyphicon glyphicon-floppy-save"></span>Guardar</button></td></tr>
  </table>
  </div>
<div id="modalPlantilla" name="modalPlantilla" class="modalPlantilla hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" >
        <div id="msgModalPlantilla" id="msgModalPlantilla">
        </div>
      <div class="modal-header">
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="limpiarCerrar();"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Requisición personal (Nuevo Punto Servicio)</h4>
      </div>
      <input id="txtLineaNegocioPlantilla" name="txtLineaNegocioPlantilla" type="hidden">
      <input id="idClientePunto" name="idClientePunto" type="hidden">
      <div class="modal-body-plantilla">
        <div class="input-prepend">
          <span class="add-on">Folio</span>
          <input class="input-mini" id="txtFolioRequisicion" name="txtFolioRequisicion" type="text" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">idPunto</span>
          <input class="input-mini" id="txtPuntoServicioIdRequisicion" name="txtPuntoServicioIdRequisicion" type="text" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">Cliente</span>
          <input class="input-xlarge" id="txtClienteModal" name="txtClienteModal" type="text" readonly>
        </div>

        <div class="input-prepend">
          <span class="add-on">Punto Servicio</span>
          <input class="input-xlarge" id="txtPuntoServicioModal" name="txtPuntoServicioModal" type="text" readonly>
        </div>
        <br>
        <div class="input-prepend">
        <div class="input-prepend">
          <span class="add-on">Fecha Punto Servicio</span>
          <input class="input-medium" id="txtFechaInicioPuntoServicioRequisicion" name="txtFechaInicioPuntoServicioRequisicion" type="date" readonly>
          <span class="add-on">Fecha montaje</span>
          <input class="input-medium" id="txtFechaInicioRequisicion" name="txtFechaInicioRequisicion" type="date" readonly>
        </div>
        <br>
        <div class="input-prepend">
          <span class="add-on">Fecha Termino Punto</span>
          <input class="input-medium" id="txtFechaTerminoPuntoServicioRequisicion" name="txtFechaTerminoPuntoServicioRequisicion" type="date" readonly>
          <span class="add-on">Fecha Termino Montaje</span>
          <input class="input-medium" id="txtFechaTerminoRequisicion" name="txtFechaTerminoRequisicion" type="date" readonly>
        </div>
        
      <br>
          <div class="input-prepend">
          <span class="add-on">LINEA NEGOCIO</span>
        
          <input class="input-medium" id="txtLineaNegocioRequisicion" name="txtLineaNegocioRequisicion" type="text" readonly>
          <input id="txtCobraDescanso" name="txtCobraDescanso" type="hidden" />
          <input id="txtCobraFestivo" name="txtCobraFestivo" type="hidden" />
          <input id="txtCobra31" name="txtCobra31" type="hidden" />
        </div>
       
        </div>

  <div id="divSeguridadFisica" align="left">

        <div class="input-prepend">
        <span class="add-on">Tipo Turno</span>
        <select id="selectTurnoRequisicion" name="selectTurnoRequisicion" class="input-large " onchange="limpiarDatos();mostrarRolOperativo();">
                    <option>TURNO</option>
                      <?php
                        for ($i = 0; $i < count($catalogoTurnos); $i++)
                        {
                    echo "<option value='" . $catalogoTurnos [$i]["idTipoTurno"] . "' >" . $catalogoTurnos [$i]["descripcionTurno"] . " </option>";
                        }
                      ?>
        </select>
      </div>

      <div class="input-prepend" id="divSelectRolOperativo" name='divSelectRolOperativo'>  
      
      </div>

      <div class="input-prepend" id="divRolOperativo" style="display: none;">  
        <span class="add-on">Tipo Rol Operativo</span>
        <input id="rolOperativoNuevo" name="rolOperativoNuevo" type="text" readonly>
      </div>

      <div class="input-prepend">
        <span class="add-on">No.Elementos</span>
        <input class="input-mini-mini" id="txtNumeroElementos" name="txtNumeroElementos" type="text"  onchange="calcularTurnosDiarios();">
      </div>

      <div class="input-prepend" id="divRelevos" name='divRelevos'>  
      
      </div>

      <div class="input-prepend">
        <span class="add-on">Puesto</span>
        <select id="selectPuestoRequisicion" name="selectPuestoRequisicion" class="input-large ">
            </select>
      </div>

      <br>
      <h4 id="TituloElementosNuevo" align="center" style="display: none;"> LOS ELEMENTOS DESCANSARAN EL MISMO DIA?</h4>
      <div id="DivElementosNuevo" align="center" style="display: none;">

        <span class="add-on" id="checkElementosNuevo1">Descansos De Los Elementos </span>
        <input id="checkElementosNuevo" name="checkElementosNuevo" type="checkbox" style="transform: scale(1.5);"><br>
      </div>

      <br>
      <h4 id="TituloDiasDescanso" align="center"> DESMARCA EL DIA QUE NO SE VA A LABORAR?</h4>

      <div class="input-prepend">
        <i><span class="add-on"><b>LUNES</b></span></i><br>

        <span class="add-on" id="checkLunes1">Dia Laborable</span>
        <input id="checkLunes" name="checkLunes" type="checkbox" checked="true" style="transform: scale(1.5);"><br>

        <span class="add-on">Turnos Dia</span>
        <input class="input-mini-mini" id="TDiaLunes" name="TDiaLunes" type="text" onblur="SumatoriaTurnos(1);"><br>

        <span class="add-on">Turnos Noche</span>
        <input class="input-mini-mini" id="TNocheLunes" name="TNocheLunes" type="text" onblur="SumatoriaTurnos(1);"><br>

        <span class="add-on">Total Tunos Lunes</span>
        <input class="input-mini-mini" id="TTotalesLunes" name="TTotalesLunes" type="text" readonly>
      </div>

      <div class="input-prepend">
        <i><span class="add-on"><b>MARTES</b></span></i><br>

        <span class="add-on" id="checkMartes1">Dia Laborable</span>
        <input id="checkMartes" name="checkMartes" type="checkbox" checked="true" style="transform: scale(1.5);"><br>

        <span class="add-on">Turnos Dia</span>
        <input class="input-mini-mini" id="TDiaMartes" name="TDiaMartes" type="text" onblur="SumatoriaTurnos(2);"><br>

        <span class="add-on">Turnos Noche</span>
        <input class="input-mini-mini" id="TNochesMartes" name="TNochesMartes" type="text" onblur="SumatoriaTurnos(2);"><br>

        <span class="add-on">Total Turnos Martes</span>
        <input class="input-mini-mini" id="TTotalesMartes" name="TTotalesMartes" type="text" readonly><br>  
      </div>

      <div class="input-prepend">
        <i><span class="add-on"><b>MIERCOLES</b></span></i><br>

        <span class="add-on" id="checkMiercoles1">Dia Laborable</span>
        <input id="checkMiercoles" name="checkMiercoles" type="checkbox" checked="true" style="transform: scale(1.5);"><br>

        <span class="add-on">Turnos Dia</span>
        <input class="input-mini-mini" id="TDiaMiercoles" name="TDiaMiercoles" type="text" onblur="SumatoriaTurnos(3);"><br>

        <span class="add-on">Turnos Noche</span>
        <input class="input-mini-mini" id="TNocheMiercoles" name="TNocheMiercoles" type="text" onblur="SumatoriaTurnos(3);"><br>

        <span class="add-on">Total Turnos Miercoles</span>
        <input class="input-mini-mini" id="TTotalesMiercoles" name="TTotalesMiercoles" type="text" readonly>
      </div>

      <div class="input-prepend">
        <i><span class="add-on"><b>JUEVES</b></span></i><br>

        <span class="add-on" id="checkJueves1">Dia Laborable</span>
        <input id="checkJueves" name="checkJueves" type="checkbox" checked="true" style="transform: scale(1.5);"><br>

        <span class="add-on">Turnos Dia</span>
        <input class="input-mini-mini" id="TDiaJueves" name="TDiaJueves" type="text" onblur="SumatoriaTurnos(4);"><br>

        <span class="add-on">Turnos Noche</span>
        <input class="input-mini-mini" id="TNocheJueves" name="TNocheJueves" type="text" onblur="SumatoriaTurnos(4);"><br>

        <span class="add-on">Total Turnos Jueves</span>
        <input class="input-mini-mini" id="TTotalesJueves" name="TTotalesJueves" type="text" readonly>
      </div>

      <div class="input-prepend">
        <i><span class="add-on"><b>VIERNES</b></span></i><br>

        <span class="add-on" id="checkViernes1">Dia Laborable</span>
        <input id="checkViernes" name="checkViernes" type="checkbox" checked="true" style="transform: scale(1.5);"><br>

        <span class="add-on">Turnos Dia</span>
        <input class="input-mini-mini" id="TDiaViernes" name="TDiaViernes" type="text" onblur="SumatoriaTurnos(5);"><br>

        <span class="add-on">Turnos Noche</span>
        <input class="input-mini-mini" id="TNocheViernes" name="TNocheViernes" type="text" onblur="SumatoriaTurnos(5);"><br>

        <span class="add-on">Total Turnos Viernes</span>
        <input class="input-mini-mini" id="TTotalesViernes" name="TTotalesViernes" type="text" readonly>
      </div>

      <div class="input-prepend">
        <i><span class="add-on"><b>SABADO</b></span></i><br>

        <span class="add-on" id="checkSabado1">Dia Laborable</span>
        <input id="checkSabado" name="checkSabado" type="checkbox" checked="true" style="transform: scale(1.5);"><br>

        <span class="add-on">Turnos Dia</span>
        <input class="input-mini-mini" id="TDiaSabado" name="TDiaSabado" type="text" onblur="SumatoriaTurnos(6);"><br>

        <span class="add-on">Turnos Noche</span>
        <input class="input-mini-mini" id="TNocheSabado" name="TNocheSabado" type="text" onblur="SumatoriaTurnos(6);"><br>

        <span class="add-on">Total Turnos Sabado</span>
        <input class="input-mini-mini" id="TtotalesSabado" name="TtotalesSabado" type="text" readonly>
      </div>

      <div class="input-prepend">
        <i><span class="add-on"><b>DOMINGO</b></span></i><br>

        <span class="add-on" id="checkDomingo1">Dia Laborable</span>
        <input id="checkDomingo" name="checkDomingo" type="checkbox" checked="true" style="transform: scale(1.5);"><br>

        <span class="add-on">Turnos Dia</span>
        <input class="input-mini-mini" id="TDiaDomingo" name="TDiaDomingo" type="text" onblur="SumatoriaTurnos(7);"><br>

        <span class="add-on">Turnos Noche</span>
        <input class="input-mini-mini" id="TNocheDomingo" name="TNocheDomingo" type="text" onblur="SumatoriaTurnos(7);"><br>

        <span class="add-on">Total Turos Domingo</span>
        <input class="input-mini-mini" id="TTotalesDomingo" name="TTotalesDomingo" type="text" readonly>
      </div>
            
      <br><br>
      <div class="input-prepend">
        <span class="add-on">Turnos a cubrir x Día</span>
        
        <input class="input-mini-mini" id="txtTurnosDiarios" name="txtTurnosDiarios" type="text" readonly>
      </div>

      <div class="input-prepend">
        <span class="add-on">Turnos a cubrir x Mes</span>
        
        <input class="input-mini" id="txtTurnosMensuales" name="txtTurnosMensuales" type="text" readonly>
      </div>

      <div class="input-prepend">
          <span class="add-on">Total Factura</span>
          <input class="input-small" id="txtTotalFactura" name="txtTotalFactura" type="text" onchange="calcularCostoTurno();" >
      </div>
      <div class="input-prepend">
          <span class="add-on">Subtotal</span>
          <input class="input-small" id="txtSubtotal" name="txtSubtotal" type="text" readonly>
      </div>
    
      <div class="input-prepend">
          <span class="add-on">IVA</span>
          <input class="input-small" id="txtIva" name="txtIva" type="text" readonly>
      </div>
      <div class="input-prepend">
          <span class="add-on">Costo Turno</span>
          <input class="input-small" id="txtCostoTurno" name="txtCostoTurno" type="text" readonly>
      </div>

      <div class="input-prepend">
        <span class="add-on">Comentarios de perfil</span>

        <textarea  id="txtComentariosRequisicion" name="txtComentariosRequisicion" class="txtAreaComentarios" rows="5" ></textarea>
      </div>

       <div class="input-prepend">
        <span class="add-on">Recursos Materiales</span>

        <textarea  id="txtRecursosMateriales" name="txtRecursosMateriales" class="txtAreaComentarios" rows="5" ></textarea>
      </div>
      
  </div> <!-- FIN divSeguridadElectronica-->

    <br>
    <br>
  <div class="modal-footer">
      <button type="button" class="btn btn-primary" onclick="guardarPlantilla();">Guardar</button>
  </div>
  <br>
    <div class="hero-unit" id="listPlantilla" name="listPlantilla">
      <h1>Requisición</h1>
    </div>

      <div class="modal-footer">
      <button type="button" class="btn btn-success" onclick="generadorFormatoRequisicion();">Formato</button>
      </div>

  </div> <!-- fin modal body-->

</div><!-- /.modal -->

</form>
</div>

<script type="text/javascript">
var cobraDescansoGlobal=0;

$(inicioRegPS());  

function inicioRegPS(){
    <?php
       if ($usuario["rol"] =="Ventas")
        {
    ?>
      CargarSelectoresMAnualesPuntoServicio();
      obtenerUltimoNueroOrden();
      obtenerListaClientesSelectModal();
      seleccionarPuestoSF();
      ocultarCamposDiasATrabajar(1);

      //displayDivSeguridadFisica();
      //displayDivSeguridadElectronica();
      
     <?php
        }
    ?>
}


$("#someSwitchOptionWarning").change(function(){
  
  if($('#someSwitchOptionWarning').is(":checked")){
     $("#someSwitchOptionWarning").val(1);
     $("#valorFlat").prop("checked", false);
     $("#valorFlat").val(0);
   }else{
         $("#someSwitchOptionWarning").val(0);
        }
});

$("#valorFlat").change(function(){
  
  if($('#valorFlat').is(":checked")){
     $("#valorFlat").val(1);
     $("#someSwitchOptionWarning").prop("checked", false);
     $("#someSwitchOptionWarning").val(0);
   }else{
         $("#valorFlat").val(0);
        }
});
  
  function guardarPuntoServicio()
  {
    
    var esatusPunto=1;
    var numeroOrden=1;
    var entidadFederativa=$("#entidad option:selected").text();

    var cobraDescansos=0;  
    var cobraDiaFestivo=0;
    var cobra31=0;
    var turnoFlat=0;
    var visiblerh=0;
    var cubredescanso=0;
    
  

      if($('input[name=cobraDescanso]').is(':checked')){
      var cobraDescansos=1;
      cobraDescansoGlobal=1;
      //alert(cobraDescanso);
    }

    if($('input[name=cobraDiaFestivo]').is(':checked')){
      var cobraDiaFestivo=1;
      //alert(cobraDiaFestivo);
    }

    if($('input[name=cobraDia31]').is(':checked')){
      var cobra31=1;
      //alert(cobraDia31);
    }

    if($('input[name=valorFlat]').is(':checked')){
      turnoFlat=1;
      //alert(cobraDia31);
    }

      if($('input[name=visiblerh]').is(':checked')){
      var visiblerh=1;
    }
     if($('input[name=cubredescanso]').is(':checked')){
      var cubredescanso=1;
    }
    //alert(cubredescanso);
        var idRegion=$("#idtxtRegion").val();
        var datastring = $("#form_registroPuntoServicio").serialize();   
        var clienteName=$("#cliente option:selected").text();

            datastring += "&esatusPunto=" + esatusPunto;  
            datastring += "&entidadFederativa=" + entidadFederativa;  
            datastring += "&cobraDescansos=" + cobraDescansos;
            datastring += "&cobraDiaFestivo=" + cobraDiaFestivo;
            datastring += "&cobra31=" + cobra31;
            datastring += "&clienteName=" + clienteName;
            datastring += "&turnoFlat=" + turnoFlat;
            datastring += "&idRegion=" + idRegion;
            datastring += "&visiblerh=" + visiblerh;
            datastring += "&cubredescanso=" + cubredescanso;
          waitingDialog.show();
        $.ajax({
            type: "POST",
            url: "ajax_registroPuntoServicio.php",
            data: datastring,
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;

                if (response.status=="success") {
                  
                    alertMsg1="<div id='msgAlert' class='alert alert-success'><trong>Registro Punto Servicio:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#alertMsg").html(alertMsg1);
                    $(document).scrollTop(0);
                    waitingDialog.hide();

                    //mostrarModal();
                    limpiarFormularioRequisicionSF();
                    consultaRequisicion();
                    ocultarCamposDiasATrabajar(1);
                    
                        

                    $('#msgAlert').delay(3000).fadeOut('slow');

                    $( "#cliente" ).val("CLIENTE");
                    //document.getElementById("form_registroPuntoServicio").reset();
                    obtenerUltimoNueroOrden();

                   // limpiarFormularioPuntoServicio();
                    
                              
                } else if (response.status=="error")
                {
                  waitingDialog.hide();
                  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error en el registro:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#alertMsg").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                }
              },error: function(jqXHR, textStatus, errorThrown) {
                waitingDialog.hide();
                  alert(jqXHR.responseText);
              }
        });
    
  }

function obtenerUltimoNueroOrden()
  {
   // var rutalogo="img/logoGif.jpg";
      $.ajax({
            
            type: "POST",
            url: "ajax_obtenerUltimoNumeroOrden.php",
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                
                    var numeroOrden = response.ultimoNumeroOrden.numeroOrden;
                    $("#txtNumeroOrden").val(numeroOrden);                  
                }              
            },
            error: function (response)
            {
                console.log (response);

            }
        });
  }

  function mostrarModal(){

    $("#selectTurnoRequisicion").val("TURNO");
    $("#selectTurnoRequisicion").prop('disabled', false);
    $("#divSelectRolOperativo").hide();
    $("#rolOselectRolOppNuevo").val("");

    $('#modalPlantilla').modal();
    var cliente=$("#cliente option:selected").text();
    var puntoServicio=$("#txtPuntoServicio").val();
    var fechaInicio=$("#txtFechaInicio").val();
    var fechaTermino=$("#txtFechaTerminoServicio").val();
    var fechaInicioPuntoServicio=$("#txtFechaInicio").val();
    var fechaTerminoPuntoServicio=$("#txtFechaTerminoServicio").val();
    //alert (fechaTermino);

    $("#txtClienteModal").val(cliente);
    $("#txtPuntoServicioModal").val(puntoServicio);
    $("#txtFechaInicioRequisicion").val(fechaInicio);
    $("#txtFechaTerminoRequisicion").val(fechaTermino);
    //$("#txtLineaNegocioRequisicion").val("SEGURIDAD FISICA");
    $("#txtFechaInicioPuntoServicioRequisicion").val(fechaInicioPuntoServicio);
    $("#txtFechaTerminoPuntoServicioRequisicion").val(fechaTerminoPuntoServicio);

    obtenerDatosPuntoServicioPorNombre();
    obtenerNumeroRequisicion();
  }

  function mostrarModalMediosComunicacion(){
    $("#modalMediosComunicacion").modal();
  }

  function obtenerPuntosServiciosPorClienteModal()
  {
      var clienteId=$("#selectClienteRequisicionModal").val();
      //alert(clienteId);

      $.ajax({
            
            type: "POST",
            url: "ajax_obtenerPuntosServiciosPorCliente.php",
            data:{"clienteId":clienteId},
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                     
                    var listaPuntos = response.listaPuntos;
                                    
                    listaPuntosSelect="<option>Cliente</option>";

                    for ( var i = 0; i < listaPuntos.length; i++ ){
                        var idPuntoServicio = listaPuntos[i].idPuntoServicio;
                        var numeroCentroCosto = listaPuntos[i].numeroCentroCosto;
                        var puntoServicio = listaPuntos[i].puntoServicio;
                        //var puntoServicio = listaPuntos[i].puntoServicio;
                                        

                      //var numeroEmpleado=listaSupervisoresOperativos[i].entidadFederativaId+"-"+listaSupervisoresOperativos[i].empleadoConsecutivoId+"-"+listaSupervisoresOperativos[i].empleadoCategoriaId;
                        listaPuntosSelect += "<option value='" + idPuntoServicio + "'>"+puntoServicio+"</option>";
                    }
                    
                    $("#selectPuntoServicioRequisicionModal").html (listaPuntosSelect);
                                      
                 }
            },           

            error: function (response)
            {
                console.log (response);

            }
        });
  }

  function obtenerListaClientesSelectModal()
  {
      $.ajax({
            
            type: "POST",
            url: "ajax_obtenerListaClientes.php",
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                     
                    var listaClientes = response.listaClientes;
                                    
                    listaClientesSelect="<option>Cliente</option>";

                    for ( var i = 0; i < listaClientes.length; i++ ){
                        var claveNomina = listaClientes[i].claveClienteNomina;
                        var razonSocial = listaClientes[i].razonSocial;
                        var nombreComercial = listaClientes[i].nombreComercial;
                        var rfcCliente = listaClientes[i].rfcCliente;
                        var contactoCliente = listaClientes[i].contactoCliente;
                        var telefonoFijoCliente =listaClientes[i].telefonoFijoCliente;
                        var telefonoMovilCliente= listaClientes[i].telefonoMovilCliente;
                        var correoCliente = listaClientes[i].correoCliente;
                        var estatusCliente=listaClientes[i].estatusCliente;
                        var idCliente=listaClientes[i].idCliente;
                                          
                      //var numeroEmpleado=listaSupervisoresOperativos[i].entidadFederativaId+"-"+listaSupervisoresOperativos[i].empleadoConsecutivoId+"-"+listaSupervisoresOperativos[i].empleadoCategoriaId;
                        listaClientesSelect += "<option value='" + idCliente + "'>" + razonSocial + "</option>";
                    }
                    
                    $("#selectClienteRequisicionModal").html (listaClientesSelect);
                                      
                 }
            },           

            error: function (response)
            {
                console.log (response);

            }
        });
  }

  function obtenerDatosPuntoServicioPorNombre()
  {
    var nombrePunto=$("#txtPuntoServicioModal").val();
    //alert(nombrePunto);


    $.ajax({
            
            type: "POST",
            url: "ajax_obtenerDatosPuntoServicioPorNombre.php",
            data:{"nombrePunto":nombrePunto},
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                     
                    var lpuntoServicio = response.puntoServicio;
                                    
                    listaClientesSelect="<option>Cliente</option>";

                    for ( var i = 0; i < lpuntoServicio.length; i++ ){
                        var idPuntoServicio = lpuntoServicio[i].idPuntoServicio;
                        var cobraDescansos = lpuntoServicio[i].cobraDescansos;
                        var cobraDiaFestivo = lpuntoServicio[i].cobraDiaFestivo;
                        var cobra31 = lpuntoServicio[i].cobra31;
                        var LineaNegocioPlantilla = lpuntoServicio[i].idLineaNegocioPunto;
                        var descripcionLineaNegocio = lpuntoServicio[i].descripcionLineaNegocio;
                        var idClientePunto = lpuntoServicio[i].idClientePunto;
                        //alert(cubredescanso1);
                        $("#idClientePunto").val("");
                        $("#txtLineaNegocioPlantilla").val("");
                        $("#txtPuntoServicioIdRequisicion").val(idPuntoServicio);
                        $("#txtCobraDescanso").val(cobraDescansos);
                        $("#txtCobraFestivo").val(cobraDiaFestivo);
                        $("#txtCobra31").val(cobra31);
                        $("#txtLineaNegocioPlantilla").val(LineaNegocioPlantilla);
                        $("#txtLineaNegocioRequisicion").val(descripcionLineaNegocio);
                        $("#idClientePunto").val(idClientePunto);

                        ocultarCamposDiasATrabajar(1);
                      
                    }

                 }
            },           

            error: function (response)
            {
                console.log (response);

            }
        });
  }

  function guardarPlantilla()
  {
        var diaDescanso=$("#txtCobraDescanso").val();
        var diaFestivo=$("#txtCobraFestivo").val();
        var dia31=$("#txtCobra31").val();
        var selectTurnoRequisicion = $("#selectTurnoRequisicion").val();

        var tipoRequisicion=1;



        if(diaDescanso==""){
         
          diaDescanso=0;

        }

        if(diaFestivo==""){
          
          diaFestivo=0;
          
        }

        if(dia31==""){
          
          dia31=0;
          
        }
           
        var datastring = $("#form_registroPuntoServicio").serialize();    

            datastring += "&diaDescanso=" + diaDescanso;  
            datastring += "&diaFestivo=" + diaFestivo;
            datastring += "&dia31=" + dia31;
            datastring += "&tipoRequisicion=" + tipoRequisicion;
            datastring += "&selectTurnoRequisicion=" + selectTurnoRequisicion;
            var alertMsg1="";
               

        $.ajax({
            type: "POST",
            url: "ajax_registroPlantilla.php",
            data: datastring,
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;

                if (response.status=="success") {
                  
                    alertMsg1="<div id='msgAlertPlant' class='alert alert-success'><trong>Requisicion:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#msgModalPlantilla").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlertPlant').delay(3000).fadeOut('slow');

                    limpiarFormularioRequisicionSF();
                    consultaRequisicion();
                    ocultarCamposDiasATrabajar(1);
                    cobraDescansoGlobal=0;


                    //$( "#cliente" ).val("CLIENTE");
                    //document.getElementById("form_registroPuntoServicio").reset();
                    //obtenerUltimoNueroOrden();
                              
                } else if (response.status=="error")
                {
                  alertMsg1="<div id='msgAlertPlant' class='alert alert-error'><strong>Error en el registro:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#msgModalPlantilla").html(alertMsg1);
                    $('#msgAlertPlant').delay(3000).fadeOut('slow');
                    //mostrarModalMediosComunicacion();
                }
              },
            error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
             }
        });
    
  }

  function calcularTurnos(){
      var tipoTurno =$("#selectTurnoRequisicion").val();
      var numeroElementos=$("#txtNumeroElementos").val();

      if (numeroElementos==""){
        alert("Proporcione el número de elementos");
        $("#selectTurnoRequisicion").val("TURNO");
         //$( "#txtTurnosDiarios" ).prop( "disabled", false );

      }

      if(tipoTurno==2 && numeroElementos!=""){

        //$("#txtTurnosDiarios").val(numeroElementos);
        //$( "#txtTurnosDiarios" ).prop( "disabled", true );


      }else if(tipoTurno!=1 && numeroElementos!=""){


         //$( "#txtTurnosDiarios" ).prop( "disabled", false );
         $("#txtTurnosDiarios").val("");

      }

    }

    function parametrosLinea(){

        var tipoLinea= $("#selectLineaNegocioRequisicion").val();
        //alert(tipoLinea);
        if (tipoLinea==1){

          displayDivSeguridadFisica();
          seleccionarPuestoSF();


        }else if(tipoLinea==2){
          displayDivSeguridadElectronica();
          seleccionarPuestoSE();
        }

      }

      function displayDivSeguridadFisica()
      {
        $("#divSeguridadFisica").toggle("slow");
      }

      function displayDivSeguridadElectronica()
      {
        $("#divSeguridadElectronica").toggle("slow");
      }

      function seleccionarPuestoSF()
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
                    
                    $("#selectPuestoRequisicion").html (puestosOptions);
                }
            },
            error: function (response)
            {
                console.log (response);
            }
        });
    }

    function seleccionarPuestoSE()
    {
              
       var valorTipo ="03";
       var lineaNegocio = $("#selectLineaNegocioRequisicion").val();
       
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
                    
                    $("#selectPuestoSE").html (puestosOptions);
                }
            },
            error: function (response)
            {
                console.log (response);
            }
        });
    }

function consultaRequisicion()
{
  var puntoServicio=$("#txtPuntoServicioIdRequisicion").val();
 $.ajax({
            
            type: "POST",
            url: "ajax_consultaRequisicion.php",
           data:{"puntoServicio":puntoServicio},
            dataType: "json",
             success: function(response) {
                if (response.status == "success")
                {
                  
                    var lista = response.lista;

                    document.getElementById("listPlantilla").innerHTML="";
                    
                    listaRequisicionTable="<table  class='table table-hover' id='Exportar_a_Excel_requisicion'><thead  style='color:#456789;font-size:100%;'><th>Cantidad</th><th>Concepto</th><th>Turnos x Dia</th><th>T. Mes</th><th>Costo x turno</th><th>Descanso</th><th>Día 31</th><th>Festivo</th><th>Subtotal</th><th>IVA</th><th>Total</th></thead><tbody>";

                    for ( var i = 0; i < lista.length; i++ ){
                      
                      var descripcionPuesto = lista[i].descripcionPuesto;
                      var descripcionTurno = lista[i].descripcionTurno;
                      var cobraDescanso=lista[i].cobraDescanso;
                      var cobraFestivos=lista[i].cobraFestivos;
                      var cobraDia31=lista[i].cobraDia31;
                      var numeroElementos=lista[i].numeroElementos;
                      var turnosPorDia=lista[i].turnosPorDia;
                      var cobraDescanso=lista[i].cobraDescanso;
                      var cobraFestivos=lista[i].cobraFestivos;
                      var cobraDia31=lista[i].cobraDia31;
                      var costoPorTurno=lista[i].costoPorTurno;
                      var nomenclaturaGenero=lista[i].nomenclaturaGenero;
                      var comentarioRequisicion=lista[i].comentarioRequisicion;
                      var tipoTurnoPlantillaId=lista[i].tipoTurnoPlantillaId;
                      var turnosMensuales="";
                      var costoTotalElemento="";
                      var subtotal="";
                      var iva="";
                      var total="";
                      var total1="";
                      var costoNetoFactura=lista[i].costoNetoFactura;

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


                      listaRequisicionTable += "<tr style='color:#456789;font-size:80%;'><td>"+numeroElementos+"</td><td>"+descripcionPuesto+" DE "+descripcionTurno+" "+nomenclaturaGenero+
                      " </td><td>"+turnosPorDia+"</td><td>"+turnosMensuales+"</td><td>"
                      +formatter.format(costoPorTurno)+"</td><td >"+cobDescanso+"</td><td>"+cob31+"</td><td>"+cobFestivos+"</td><td>"+
                      formatter.format(subtotal)+"</td><td>"+formatter.format(iva)+"</td><td>"+formatter.format(total)+"</td><td>"+comentarioRequisicion+"</td><tr>";
                    }

                    listaRequisicionTable += "</tbody></table>";
                    $('#listPlantilla').html(listaRequisicionTable); 
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

function obtenerNumeroRequisicion()
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
                    $("#txtFolioRequisicion").val(folioRequisicion);
                    consultaRequisicion();
                                      
                }
            },
            error: function (response)
            {
                console.log (response);
            }
        });
           
    }

function limpiarFormularioRequisicionSF(){
  $('#modalPlantilla').modal("hide");
  $("#divSelectRolOperativo").html("");
  $("#divRolOperativo").hide();
  $("#rolOperativoNuevo").val("");
  $("#txtNumeroElementos").val("");
  $("#selectTurnoRequisicion").val("TURNO");
  $("#selectPuestoRequisicion").val("PUESTO");
  $("#txtTurnosDiarios").val("");
  $("#txtCostoTurno").val("");
  $("#txtComentariosRequisicion").val("");
  $("#txtTurnosMensuales").val("");
  $("#txtTotalFactura").val("");
  $("#txtRecursosMateriales").val("");
  $("#txtIva").val("");
  $("#txtSubtotal").val("");
}

function limpiarFormularioPuntoServicio(){

$("#cliente").val("CLIENTE");
$("#txtNumeroCentro").val("");
$("#txtPuntoServicio").val("");
$("#entidad").val("ENTIDAD FEDERATIVA");
$("#txtDireccion").val("");
$("#txtFechaInicio").val("");
$("#txtContactoFacturacion").val("");
$("#txtCorreoFacturacion").val("");
$("#txtTelefonoFijoFacturacion").val("");
$("#txtTelefonoMovilFacturacion").val("");
$("#txtContactoTesoreria").val("");
$("#txtCorreoTesoreria").val("");
$("#txtTelefonoFijoTesoreria").val("");
$("#txtTelefonoMovilTesoreria").val("");
$("#txtContactoOperativo").val("");
$("#txtCorreoOperativo").val("");
$("#txtTelefonoFijoOperativo").val("");
$("#txtTelefonoMovilOperativo").val("");
$("#txtFechaTerminoServicio").val("");
$("#txtTerminosFacturacion").val("");
$("#txtLongitud").val("");
$("#txtLatitud").val("");
$('input[name=cobraDescanso]').prop("checked", "");
$('input[name=cobraDiaFestivo]').prop("checked", "");
$('input[name=cobraDia31]').prop("checked", "");
$("#txtCpContratoPuntoServicio").val('');
$("#txtAsentamientoPuntoServicio").val(0);
$("#txtEntidadClientePuntoServicio").val(0);
$("#txtMunicipioPuntoServicio").val(0);
$("#txtColoniaClientePuntoServicio").val(0);
$("#txtCallePrincipalPuntoServicio").val('');
$("#txtNumeroInteriroPuntoServicio").val('');
$("#txtNumeroExteriorPuntoServicio").val('');
$("#txtCalle1PuntoServicio").val('');
$("#txtCalle2PuntoServicio").val('');

}   

  function generadorFormatoRequisicion()
    {
      var idPuntoServicio=$("#txtPuntoServicioIdRequisicion").val();
      var folio=$("#txtFolioRequisicion").val();
      
      window.open("generadorFormatoRequisicionAlta.php?idPuntoServicio="+idPuntoServicio+"&folio="+folio+"",'_blank','fullscreen=no');
      //parent.opener=top;
      //opener.close();

    
    }

    function limpiarDatos(){
      $("#txtNumeroElementos").val("");
      $("#txtTurnosDiarios").val("");
      $("#txtTurnosMensuales").val("");
      $("#txtTotalFactura").val("");
      $("#txtIva").val("");
      $("#txtCostoTurno").val("");
      $("#txtSubtotal").val("");

    }

    function calcularCostoTurno(){
      var costoFactura=$("#txtTotalFactura").val();
      var tipoTurno=$("#selectTurnoRequisicion").val();
      var turnosMensuales=$("#txtTurnosMensuales").val();

      var subtotal=costoFactura/1.16;
      var iva=subtotal*0.16;

      var costoTurno=0;
      var costoTurno=subtotal/turnosMensuales;

      var costoSinIva=costoFactura-iva;
      var costoTurno=costoSinIva/turnosMensuales;

        $("#txtIva").val(formatter.format(iva));
        $("#txtCostoTurno").val(formatter.format(costoTurno));
        $("#txtSubtotal").val(formatter.format(subtotal));
      
    }

    function calcularTurnosDiarios(){
      var tipoTurno= $("#selectTurnoRequisicion").val();
      var numeroElementos=$("#txtNumeroElementos").val();
      var turnosMensuales=0;
      var idClientePunto = $("#idClientePunto").val();
      var tLineaNegocioPlantilla = $("#txtLineaNegocioPlantilla").val();
      $("#txtTotalFactura").val("");
      $("#txtIva").val();
      $("#txtCostoTurno").val();
      if(idClientePunto == "13" || tLineaNegocioPlantilla != "1"){
        $("#txtTurnosDiarios").val(numeroElementos);
        $("#txtTurnosMensuales").val(0);
        $("#txtTotalFactura").val(0);
        $("#txtSubtotal").val(0);
        $("#txtIva").val(0);
        $("#txtCostoTurno").val(0);
      }else{

      if (tipoTurno==2){

      if(numeroElementos % 2 == 0) {
        $("#txtTurnosDiarios").val(numeroElementos);
        turnosMensuales=numeroElementos*30;
        $("#txtTurnosMensuales").val(turnosMensuales);
        
        }
        else {
        alert("El numero de elementos para turno de 24x24 no debe ser menor a 1 y debe ser multiplos de 2");
      
        }
      }else if(tipoTurno==1){
        $("#txtTurnosDiarios").val(numeroElementos);
        turnosMensuales=numeroElementos*30;
        $("#txtTurnosMensuales").val(turnosMensuales);
      
      }else if(tipoTurno==6){

        if(numeroElementos % 3 == 0) {

          turnosDiarios=(numeroElementos*2)/3;
        $("#txtTurnosDiarios").val(turnosDiarios);
        turnosMensuales=turnosDiarios*30;
        $("#txtTurnosMensuales").val(turnosMensuales);
        
        }
        else {
        alert("El numero de elementos para turno de 12X24 no debe ser menor a 3 y debe ser multiplos de 3");
      
        }
     }else if(tipoTurno==3){

        if(numeroElementos % 4 == 0) {

          turnosDiarios=(numeroElementos*2)/4;
        $("#txtTurnosDiarios").val(turnosDiarios);
        turnosMensuales=turnosDiarios*30;
        $("#txtTurnosMensuales").val(turnosMensuales);
        
        }
        else {
        alert("El numero de elementos para turno de 12x36 no debe ser menor a 4 y debe ser multiplos de 4");
      
        }
      }
    }
      MostrarCamposDiasATrabajar(numeroElementos);
    }


    function mostrarRolOperativo(){
      $("#divRolOperativo").hide();
      var opcionTurno=document.getElementById("selectTurnoRequisicion").selectedIndex;
      cobraDescansoGlobal=1;
      if(opcionTurno==1){
        if(cobraDescansoGlobal==1){          
                var selectTipoRolOp="<span class='add-on'>Tipo Rol Operativo</span>";
                selectTipoRolOp+="<select name'selectRolOp' id='selectRolOp' onChange='cambiarRolOp();BorrarCampos();'>";
                selectTipoRolOp+="<option>12x12x7</option><option>12x12x6</option><option>12x12x5</option><option>12x12x3</option></select>";
                selectTipoRolOp+="<div id='fotoFatiga' style='width:170x;height:133px;border:1px solid;text-align:center;display: flex;flex-direction: column;' ></div> ";
                $("#rolOperativoNuevo").val("12x12x7");
                $("#divSelectRolOperativo").html(selectTipoRolOp);   
                $("#fotoFatiga").html ("<img src='uploads/fotocobertura/fatigax7.png' />");                 
        }else{        
                var selectTipoRolOp="<span class='add-on'>Tipo Rol Operativo</span>";
                selectTipoRolOp+="<input class='input-large' id='txtRolOp' name='txtRolOp' type='text' value='12x12x7' readonly>";
                selectTipoRolOp+="<div id='fotoFatiga' style='width:170x;height:133px;border:1px solid;text-align:center;display: flex;flex-direction: column;' ></div>";
                $("#rolOperativoNuevo").val("12x12x7");
                $("#divSelectRolOperativo").html(selectTipoRolOp);     
                $("#fotoFatiga").html ("<img src='uploads/fotocobertura/fatigax7.png' />");               

        }

      }else {
        $("#divSelectRolOperativo").html("");
        var turno=document.getElementById("selectTurnoRequisicion").options[opcionTurno].text;
        if(opcionTurno =="5" || opcionTurno =="6"){
          $("#rolOperativoNuevo").val(turno);
        }else{
          $("#rolOperativoNuevo").val(turno+"x7");
        }
        $("#divRolOperativo").show();
      }
      BorrarCampos();

    }


    function ocultarCamposDiasATrabajar(caso){
      var idClientePunto = $("#idClientePunto").val();
      var tLineaNegocioPlantilla = $("#txtLineaNegocioPlantilla").val();
      if((idClientePunto == "13") || ((tLineaNegocioPlantilla != "1") || (tLineaNegocioPlantilla != "3"))){

        $("#TituloDiasDescanso").hide();
        $("#checkLunes1").hide();
        $("#checkLunes").hide();
        $("#checkMartes1").hide();
        $("#checkMartes").hide();
        $("#checkMiercoles1").hide();
        $("#checkMiercoles").hide();
        $("#checkJueves1").hide();
        $("#checkJueves").hide();
        $("#checkViernes1").hide();
        $("#checkViernes").hide();
        $("#checkSabado1").hide();
        $("#checkSabado").hide();
        $("#checkDomingo1").hide();
        $("#checkDomingo").hide();

        $("#TDiaLunes").prop('readonly', true);
        $("#TNocheLunes").prop('readonly', true);
        $("#TDiaMartes").prop('readonly', true);
        $("#TNochesMartes").prop('readonly', true);
        $("#TDiaMiercoles").prop('readonly', true);
        $("#TNocheMiercoles").prop('readonly', true);
        $("#TDiaJueves").prop('readonly', true);
        $("#TNocheJueves").prop('readonly', true);
        $("#TNocheViernes").prop('readonly', true);
        $("#TDiaViernes").prop('readonly', true);
        $("#TNocheSabado").prop('readonly', true);
        $("#TDiaSabado").prop('readonly', true);
        $("#TDiaDomingo").prop('readonly', true);
        $("#TNocheDomingo").prop('readonly', true);
        $("#txtTotalFactura").prop('readonly', true);

        $("#selectTurnoRequisicion").val(5);
        $("#selectTurnoRequisicion").prop('disabled', true);
        $("#divSelectRolOperativo").show();
        $("#selectRolOp").val("NO DEFINIDO");

      }else {
        $("#txtTotalFactura").prop('readonly', false);
        if(caso=="1"){

          $("#TituloDiasDescanso").hide();
          $("#checkLunes1").hide();
          $("#checkLunes").hide();
          $("#checkMartes1").hide();
          $("#checkMartes").hide();
          $("#checkMiercoles1").hide();
          $("#checkMiercoles").hide();
          $("#checkJueves1").hide();
          $("#checkJueves").hide();
          $("#checkViernes1").hide();
          $("#checkViernes").hide();
          $("#checkSabado1").hide();
          $("#checkSabado").hide();
          $("#checkDomingo1").hide();
          $("#checkDomingo").hide();
        }else{

          $("#TituloDiasDescanso").show();
          $("#checkLunes1").show();
          $("#checkLunes").show();
          $("#checkMartes1").show();
          $("#checkMartes").show();
          $("#checkMiercoles1").show();
          $("#checkMiercoles").show();
          $("#checkJueves1").show();
          $("#checkJueves").show();
          $("#checkViernes1").show();
          $("#checkViernes").show();
          $("#checkSabado1").show();
          $("#checkSabado").show();
          $("#checkDomingo1").show();
          $("#checkDomingo").show();
        }

      $("#TDiaLunes").prop('readonly', false);
      $("#TNocheLunes").prop('readonly', false);
      $("#TDiaMartes").prop('readonly', false);
      $("#TNochesMartes").prop('readonly', false);
      $("#TDiaMiercoles").prop('readonly', false);
      $("#TNocheMiercoles").prop('readonly', false);
      $("#TDiaJueves").prop('readonly', false);
      $("#TNocheJueves").prop('readonly', false);
      $("#TNocheViernes").prop('readonly', false);
      $("#TDiaViernes").prop('readonly', false);
      $("#TNocheSabado").prop('readonly', false);
      $("#TDiaSabado").prop('readonly', false);
      $("#TDiaDomingo").prop('readonly', false);
      $("#TNocheDomingo").prop('readonly', false);
    }
      if(tLineaNegocioPlantilla == "3"){
        $("#txtTotalFactura").prop('readonly', true);
        $("#selectTurnoRequisicion").val(5);
        $("#selectTurnoRequisicion").prop('disabled', true);
        $("#divSelectRolOperativo").show();
        $("#selectRolOp").val("NO DEFINIDO");
      }
      $("#checkLunes").val(1);
      $("#checkMartes").val(1);
      $("#checkMiercoles").val(1);
      $("#checkJueves").val(1);
      $("#checkViernes").val(1);
      $("#checkSabado").val(1);
      $("#checkDomingo").val(1);
      
      $("#checkLunes").prop("checked", true);
      $("#checkMartes").prop("checked", true);
      $("#checkMiercoles").prop("checked", true);
      $("#checkJueves").prop("checked", true);
      $("#checkViernes").prop("checked", true);
      $("#checkSabado").prop("checked", true);
      $("#checkDomingo").prop("checked", true);

      $("#TDiaLunes").val("");
      $("#TNocheLunes").val("");
      $("#TDiaMartes").val("");
      $("#TNochesMartes").val("");
      $("#TDiaMiercoles").val("");
      $("#TNocheMiercoles").val("");
      $("#TDiaJueves").val("");
      $("#TNocheJueves").val("");
      $("#TNocheViernes").val("");
      $("#TDiaViernes").val("");
      $("#TNocheSabado").val("");
      $("#TDiaSabado").val("");
      $("#TDiaDomingo").val("");
      $("#TNocheDomingo").val("");

      $("#TTotalesLunes").val("");
      $("#TTotalesMartes").val("");
      $("#TTotalesMiercoles").val("");
      $("#TTotalesJueves").val("");
      $("#TTotalesViernes").val("");
      $("#TtotalesSabado").val("");
      $("#TTotalesDomingo").val("");
      
    }

    function SumatoriaTurnos(caso){
      var DiaLunes1 = $("#TDiaLunes").val();
      var NocheLunes1 = $("#TNocheLunes").val();
      var DiaMartes1 = $("#TDiaMartes").val();
      var NochesMartes1 = $("#TNochesMartes").val();
      var DiaMiercoles1 = $("#TDiaMiercoles").val();
      var NocheMiercoles1 = $("#TNocheMiercoles").val();
      var DiaJueves1 = $("#TDiaJueves").val();
      var NocheJueves1 = $("#TNocheJueves").val();
      var NocheViernes1 = $("#TNocheViernes").val();
      var DiaViernes1 = $("#TDiaViernes").val();
      var NocheSabado1 = $("#TNocheSabado").val();
      var DiaSabado1 = $("#TDiaSabado").val();
      var DiaDomingo1 = $("#TDiaDomingo").val();
      var NocheDomingo1 = $("#TNocheDomingo").val();
      var txtTurnosDiarios1 = $("#txtTurnosDiarios").val();

      var DiaLunesint = parseFloat(DiaLunes1);
      var NocheLunesint = parseFloat(NocheLunes1);
      var DiaMartesint = parseFloat(DiaMartes1);
      var NochesMartesint = parseFloat(NochesMartes1);
      var DiaMiercolesint = parseFloat(DiaMiercoles1);
      var NocheMiercolesint = parseFloat(NocheMiercoles1);
      var DiaJuevesint = parseFloat(DiaJueves1);
      var NocheJuevesint = parseFloat(NocheJueves1);
      var NocheViernesint = parseFloat(NocheViernes1);
      var DiaViernesint = parseFloat(DiaViernes1);
      var NocheSabadoint = parseFloat(NocheSabado1);
      var DiaSabadoint = parseFloat(DiaSabado1);
      var DiaDomingoint = parseFloat(DiaDomingo1);
      var NocheDomingoint = parseFloat(NocheDomingo1);
      var txtTurnosDiariosint = parseFloat(txtTurnosDiarios1);

      if(caso == 1){
        var sumatorialu=((DiaLunesint)+(NocheLunesint));
        $("#TTotalesLunes").val(sumatorialu);
      }else if(caso == 2){
        var sumatoriaMa=((DiaMartesint)+(NochesMartesint));
        $("#TTotalesMartes").val(sumatoriaMa);
      }else if(caso == 3){
        var sumatoriaMi=((DiaMiercolesint)+(NocheMiercolesint));
        $("#TTotalesMiercoles").val(sumatoriaMi);
      }else if(caso == 4){
        var sumatoriaJu=((DiaJuevesint)+(NocheJuevesint));
        $("#TTotalesJueves").val(sumatoriaJu);
      }else if(caso == 5){
        var sumatoriaVi=((NocheViernesint)+(DiaViernesint));
        $("#TTotalesViernes").val(sumatoriaVi);
      }else if(caso == 6){
        var sumatoriaSa=((NocheSabadoint)+(DiaSabadoint));
        $("#TtotalesSabado").val(sumatoriaSa);
      }else if(caso == 7){
        var sumatoriaDo=((NocheDomingoint)+(DiaDomingoint));
        $("#TTotalesDomingo").val(sumatoriaDo);
      }
    }
    function BorrarCampos(){
      $("#txtNumeroElementos").val("");
      $("#txtTurnosDiarios").val("");
      $("#txtTurnosMensuales").val("");
      $("#checkElementosNuevo").prop("checked", false);
      $("#checkElementosNuevo").val(0);
      $("#TituloElementosNuevo").hide();
      $("#DivElementosNuevo").hide();
      ocultarCamposDiasATrabajar(1);
    }

    function MostrarCamposDiasATrabajar(numeroElementos){
      var selectRolOp11 = $("#selectRolOp").val();  
      if((numeroElementos > "1") && (selectRolOp11 == "12x12x6" || selectRolOp11 == "12x12x5" || selectRolOp11 == "12x12x3")){
        $("#checkElementosNuevo").prop("checked", false);
        $("#checkElementosNuevo").val(0);
        $("#TituloElementosNuevo").show();
        $("#DivElementosNuevo").show();
        ocultarCamposDiasATrabajar(1);
      }else if((numeroElementos == "1") && (selectRolOp11 == "12x12x6" || selectRolOp11 == "12x12x5" || selectRolOp11 == "12x12x3")){
        $("#checkElementosNuevo").prop("checked", true);
        $("#checkElementosNuevo").val(1);
        $("#TituloElementosNuevo").hide();
        $("#DivElementosNuevo").hide();
        ocultarCamposDiasATrabajar(2);
      }else{
        $("#checkElementosNuevo").prop("checked", false);
        $("#checkElementosNuevo").val(0);
        $("#TituloElementosNuevo").hide();
        $("#DivElementosNuevo").hide();
        ocultarCamposDiasATrabajar(1);
      }
    }

    $('#checkElementosNuevo').change(function() {
      if($('#checkElementosNuevo').is(":checked")){
        $("#checkElementosNuevo").val(1);
        ocultarCamposDiasATrabajar(2);
      } 
      else {
        $("#checkElementosNuevo").val(0);
        ocultarCamposDiasATrabajar(1);
      }
    });


    $('#checkLunes').change(function() {
      if($('#checkLunes').is(":checked")){
      $("#checkLunes").val(1);
      $("#TDiaLunes").prop('readonly', false);
      $("#TNocheLunes").prop('readonly', false);
      } 
      else {
      $("#checkLunes").val(0);
      $("#TDiaLunes").val("");
      $("#TNocheLunes").val("");
      $("#TTotalesLunes").val("");
      $("#TDiaLunes").prop('readonly', true);
      $("#TNocheLunes").prop('readonly', true);
    }
    });
    $('#checkMartes').change(function() {
      if($('#checkMartes').is(":checked")){
      $("#checkMartes").val(1);
      $("#TDiaMartes").prop('readonly', false);
      $("#TNochesMartes").prop('readonly', false);
      }
      else {
      $("#checkMartes").val(0);
      $("#TDiaMartes").val("");
      $("#TNochesMartes").val("");
      $("#TTotalesMartes").val("");
      $("#TDiaMartes").prop('readonly', true);
      $("#TNochesMartes").prop('readonly', true);
    }
    });
    $('#checkMiercoles').change(function() {
      if($('#checkMiercoles').is(":checked")){
      $("#checkMiercoles").val(1);
      $("#TDiaMiercoles").prop('readonly', false);
      $("#TNocheMiercoles").prop('readonly', false);
      } 
      else {
      $("#checkMiercoles").val(0);
      $("#TDiaMiercoles").val("");
      $("#TNocheMiercoles").val("");
      $("#TTotalesMiercoles").val("");
      $("#TDiaMiercoles").prop('readonly', true);
      $("#TNocheMiercoles").prop('readonly', true);
    }
    });
    $('#checkJueves').change(function() {
      if($('#checkJueves').is(":checked")){
      $("#checkJueves").val(1);
      $("#TDiaJueves").prop('readonly', false);
      $("#TNocheJueves").prop('readonly', false);
      } 
      else {
      $("#checkJueves").val(0);
      $("#TDiaJueves").val("");
      $("#TNocheJueves").val("");
      $("#TTotalesJueves").val("");
      $("#TDiaJueves").prop('readonly', true);
      $("#TNocheJueves").prop('readonly', true);
    }
    });
    $('#checkViernes').change(function() {
      if($('#checkViernes').is(":checked")){
      $("#checkViernes").val(1);
      $("#TNocheViernes").prop('readonly', false);
      $("#TDiaViernes").prop('readonly', false);
      } 
      else {
      $("#checkViernes").val(0);
      $("#TNocheViernes").val("");
      $("#TDiaViernes").val("");
      $("#TTotalesViernes").val("");
      $("#TNocheViernes").prop('readonly', true);
      $("#TDiaViernes").prop('readonly', true);
    }
    });
    $('#checkSabado').change(function() {
      if($('#checkSabado').is(":checked")){
      $("#checkSabado").val(1);
      $("#TNocheSabado").prop('readonly', false);
      $("#TDiaSabado").prop('readonly', false);
      } 
      else {
      $("#checkSabado").val(0);
      $("#TNocheSabado").val("");
      $("#TDiaSabado").val("");
      $("#TtotalesSabado").val("");
      $("#TNocheSabado").prop('readonly', true);
      $("#TDiaSabado").prop('readonly', true);
    }
    });
    $('#checkDomingo').change(function() {
      if($('#checkDomingo').is(":checked")){
      $("#checkDomingo").val(1);
      $("#TDiaDomingo").prop('readonly', false);
      $("#TNocheDomingo").prop('readonly', false);
      } 
      else {
      $("#checkDomingo").val(0);
      $("#TDiaDomingo").val("");
      $("#TNocheDomingo").val("");
      $("#TTotalesDomingo").val("");
      $("#TDiaDomingo").prop('readonly', true);
      $("#TNocheDomingo").prop('readonly', true);
    }
    });

    function cambiarRolOp(){

        var opcionOperativo=document.getElementById("selectRolOp").selectedIndex;

        if(opcionOperativo==0){
            $("#fotoFatiga").show();
            $("#fotoFatiga").html ("<img src='uploads/fotocobertura/fatigax7.png' />");
            $("#rolOperativoNuevo").val("12x12x7");
        }else if(opcionOperativo==1){
            $("#fotoFatiga").show();
            $("#fotoFatiga").html ("<img src='uploads/fotocobertura/fatigax6.png' />");
            $("#rolOperativoNuevo").val("12x12x6");
        }else if(opcionOperativo==2){
            $("#fotoFatiga").show();
            $("#fotoFatiga").html ("<img src='uploads/fotocobertura/fatigax5.png' />");
            $("#rolOperativoNuevo").val("12x12x5");
        }else {
            $("#fotoFatiga").hide();
            $("#fotoFatiga").html ("");
            $("#rolOperativoNuevo").val("12x12x3");
        }
    }

var formatter = new Intl.NumberFormat('en-US', {
  style: 'currency',
  currency: 'USD',
  minimumFractionDigits: 2,
});


function limpiarCerrar(){
  document.getElementById("listPlantilla").innerHTML="";
}


$('#txtFechaInicio').datetimepicker({
 
  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',

});

$('#txtFechaTerminoServicio').datetimepicker({
 
  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',

});

$('#txtFechaInicioRequisicion').datetimepicker({
 
  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',

});

$('#txtFechaTerminoRequisicion').datetimepicker({
 
  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',

});

$("#selLineaNegocio").change(function(){
var idlineanegocio=$("#selLineaNegocio").val();
$('#selmunicipiowalmrt').empty();
if(idlineanegocio!=0){
 $.ajax({
              type: "POST",
              url: "ajax_consultaEntidadesRegionesXlineanegocio.php",
              data: {
                  "idlineanegocio": idlineanegocio,"idEntidad":0,"accion":1
              },
              dataType: "json",
              success: function(response) {
              // console.log(datos);
                  var datos = response.datos;
                  $('#entidad').empty().append('<option value="0" selected="selected">ENTIDAD FEDERATIVA</option>');
                  $.each(datos, function(i) {
                      $('#entidad').append('<option value="' + response.datos[i].idEntidadFederativa + '">' + response.datos[i].nombreEntidadFederativa + '</option>');
                  });
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
          });
}else{
$('#entidad').empty();
$("#txtRegion").val("");
$("#idtxtRegion").val("");

}
});


$('#entidad').change(function(){
var idlineanegocio=$("#selLineaNegocio").val();
$('#selmunicipiowalmrt').empty();
var idEntidad=$('#entidad').val();

if(idEntidad!=0){
    cargaselectormunicipio(idEntidad);
$.ajax({
              type: "POST",
              url: "ajax_consultaEntidadesRegionesXlineanegocio.php",
              data: {
                  "idlineanegocio": idlineanegocio,"idEntidad":idEntidad,"accion":2
              },
              dataType: "json",
              async:false,
              success: function(response) {
               
                  var datos = response.datos;
                  //console.log(response.datos[0].DescripcionI);
                     $("#txtRegion").val(datos[0].idRegionI+".-"+datos[0].DescripcionI);

                      $("#idtxtRegion").val(datos[0].idIncrementI);
                      

                 
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
          });
}else{
$("#txtRegion").val("");
$("#idtxtRegion").val("");

}
});
//

$("#cliente").change(function(){
  $("#cubredescanso").prop("checked","")
  if($("#cliente").val()==13){
$("#trcubredescanso").show();

  }else if($("#cliente").val()==43){
$("#trtxtunidadwalmrt").show();
$("#trselmunicipio").show();
  }else{
  $("#trcubredescanso").hide();
  //ocyultar las opcions tambien del cliente walmart
  $("#trtxtunidadwalmrt").hide();
  $("#trselmunicipio").hide(); 
  $("#txtunidad").val("");
  $("#selmunicipiowalmrt").val(0);
}

});
function cargaselectormunicipio(identidad){
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
                  $('#selmunicipiowalmrt').empty().append('<option value="0" selected="selected">DELEGACIÓN/MUNICIPIO</option>');
                  $.each(datos, function(i) {
                      $('#selmunicipiowalmrt').append('<option value="' + response.datos[i].idMunicipio + '">' + response.datos[i].nombreMunicipio + '</option>');
                  });  
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
          });
}
///////////////////////////////////////////////////////////

  function CargarSelectoresMAnualesPuntoServicio(){
 
    TraerEntidadesPuntoServicio();
    $('#txtMunicipioPuntoServicio').empty().append('<option value="0">Municipios</option>');
    $('#txtColoniaClientePuntoServicio').empty().append('<option value="0">Colonias</option>');
    $('#txtAsentamientoPuntoServicio').empty().append('<option value="0">Asentamiento</option>');
  }

  function TraerEntidadesPuntoServicio(){
    $.ajax({
        type: "POST",
        url: "ajax_TraerEntidadesCliente.php",
        dataType: "json",
        success: function(response) {
         // console.log(response);
          var datos = response.datos;
          $('#txtEntidadClientePuntoServicio').empty().append('<option value="0">Entidades</option>');
          $.each(datos, function(i) {
            $('#txtEntidadClientePuntoServicio').append('<option value="' + response.datos[i].idEntidadFederativa+ '">' + response.datos[i].nombreEntidadFederativa + '</option>');
          });     
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
        }
    });  
  }
  function TraerMunicipiosPuntoServicio(Accion){
    $('#txtColoniaClientePuntoServicio').empty().append('<option value="0">Colonias</option>');
    if(Accion=="0"){
        $('#txtAsentamientoPuntoServicio').val(0);
    }
    var txtEntidadCliente=$("#txtEntidadClientePuntoServicio").val();
    $.ajax({
        type: "POST",
        url: "ajax_TraerMunicipiosCliente.php",
        data: {txtEntidadCliente : txtEntidadCliente},
        dataType: "json",
        async:false,
        success: function(response) {
         // console.log(response);
          var datos = response.datos;
          $('#txtMunicipioPuntoServicio').empty().append('<option value="0">Municipios</option>');
          $.each(datos, function(i) {
            $('#txtMunicipioPuntoServicio').append('<option value="' + response.datos[i].idMunicipio+ '">' + response.datos[i].nombreMunicipio + '</option>');
          });     
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
        }
    });  
  }
  function TraerColoniasPuntoServicio(Accion){
    if(Accion=="0"){
        $('#txtAsentamientoPuntoServicio').val(0);
    }
    var txtMunicipio=$("#txtMunicipioPuntoServicio").val();
    $.ajax({
        type: "POST",
        url: "ajax_TraerColoniasCliente.php",
        data: {txtMunicipio : txtMunicipio},
        dataType: "json",
        async:false,
        success: function(response) {
         // console.log(response);
          var datos = response.datos;
          $('#txtColoniaClientePuntoServicio').empty().append('<option value="0">Colonias</option>');
          $.each(datos, function(i) {
            $('#txtColoniaClientePuntoServicio').append('<option value="' + response.datos[i].idAsentamiento+ '">' + response.datos[i].nombreAsentamiento + '</option>');
          });     
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
        }
    });  
  }
  function consultaCPClientePuntoServicio()
{
    var codigoPostal = $("#txtCpContratoPuntoServicio").val();
    if (codigoPostal.length == 5)
    {
        $.ajax({
            type: "POST",
            url: "ajax_obtenerDirecciones.php",
            data: {txtCP : codigoPostal},
            dataType: "json",
            success: function(response) {
                if (response.listaDirecciones.length == 0)
                {   
                    showMessage1 ("El código postal es inválido", "error");
                }else 
                {
                    $('#txtAsentamientoPuntoServicio').empty().append('<option value="0">Asentamiento</option>');
                    for (var i = 0; i < response.listaDirecciones.length; i++)
                    {
                        var direccion = response.listaDirecciones [i];
                        var params = "\"" + direccion.idAsentamiento + "\"," +
                            "\"" + direccion.nombreEntidadFederativa + "\"," +
                            "\"" + direccion.nombreMunicipio + "\"," +
                            "\"" + direccion.nombreAsentamiento + "\"," +
                            "\"" + direccion.municipioAsentamiento + "\"";
                        $('#txtAsentamientoPuntoServicio').append('<option value="'+direccion.idAsentamiento+'&'+direccion.municipioAsentamiento+'&'+direccion.idEstado+'">' + params + '</option>');
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
        $('#txtEntidadClientePuntoServicio').val(0);
    $('#txtMunicipioPuntoServicio').empty().append('<option value="0">Municipios</option>');
    $('#txtColoniaClientePuntoServicio').empty().append('<option value="0">Colonias</option>');
    }
}

$("#txtAsentamientoPuntoServicio").change(function()
{
    var txtAsentamiento = $("#txtAsentamientoPuntoServicio").val();
    var splitasentamiento = txtAsentamiento.split('&'); 
    var idColonia = splitasentamiento[0];
    var idmunicipio = splitasentamiento[1];
    var idEntidad = splitasentamiento[2];
    $("#txtEntidadClientePuntoServicio").val(idEntidad);
    TraerMunicipiosPuntoServicio(1);
    $("#txtMunicipioPuntoServicio").val(idmunicipio);
    TraerColoniasPuntoServicio(1);
    $("#txtColoniaClientePuntoServicio").val(idColonia);

});











</script>