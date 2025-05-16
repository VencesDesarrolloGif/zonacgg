<?php
  require '../libs/fpdf/fpdf.php';
  // require '../libs/fpdi/fpdi.php';
?>

<label for="txtBuscarPreseleccion" class=" control-label label ">FOLIO PRESELECCIÓN:</label>
<input type="text" id="txtBuscarPreseleccion" name="txtBuscarPreseleccion" class="input-small" placeholder="0000000">
<input type="hidden" id="inpbanderafoliopreseleccion" name="inpbanderafoliopreseleccion" >
<div class="container" align="center">
  <div id="listaConsultaPreseleccion" ></div>
  <form class="form-horizontal" action='ajax_registrarEmpleado.php' method="post" id="form_registrarEmpleado" enctype="multipart/form-data">
    <fieldset><legend>Campos Obligatorios </legend></fieldset>
    <input id="numeroVisitante" name="numeroVisitante" type="hidden" class="input-large">
    <div class="tabbable">
      <ul class="nav nav-tabs" >
        <li id="Dgenerales"><a id="containerDatosGenerales1" href="#containerDatosGenerales" data-toggle="tab">Datos Generales<span id="spanDatosGenerales" class="glyphicon glyphicon-remove"></span></a></li>
        <li id="DFiscales"><a id="containerDatosFiscalesR1" href="#containerDatosFiscalesR" data-toggle="tab">Datos Fiscales <span id="spanDatosFiscales" class="glyphicon glyphicon-pencil"></span></a></li>
        <li id="Dpersonales"><a id="containerDatosPersonales1" href="#containerDatosPersonales" data-toggle="tab">Datos Personales <span id="spanDatosPersonales" class="glyphicon glyphicon-remove"></span></a></li>
        <li id="Directorio"><a id="containerDirectorio1" href="#containerDirectorio" data-toggle="tab">Directorio <span id="spanDatosDireccion" class="glyphicon glyphicon-remove"></span></a></li>
        <li id="Familiares"><a id="containerDatosFamiliares1" href="#containerDatosFamiliares" data-toggle="tab">Beneficiarios<span id="spanDatosFamiliares" class="glyphicon glyphicon-remove"></span></a></li>
        <li id="Familiares"><a id="containerDocumentosDigitalizadosTab" href="#containerDocumentosDigitalizados" data-toggle="tab">Documentos Digitalizados </a></li>
        <li id="formatos"><a id="containerFormatosTab" href="#containerFormatos" data-toggle="tab">Generacion de Formatos </a></li>
      </ul>
    </div>
    
    <div class="tab-content">
    <!--Div datos generales -->
      <div align="" class="tab-pane active" id="containerDatosGenerales" >
        <legend><h3>Datos Generales</h3></legend>
        <table  border="1" class="table1" name='tableDP' id='tableDP'>
          <tr>
            <input id="NumeroEmpleadoModa" name="NumeroEmpleadoModa" type="hidden" class="input-medium" readonly>
            <td><label class=" control-label label " for="numeroEmpleado">N. Empleado</label> </td>
            <td> 
              <input id="numeroEmpleadoEntidad" name="numeroEmpleadoEntidad" type="text" placeholder="00" class="input-mini-mini" maxlength="2" readonly >-
              <input id="numeroEmpleadoConsecutivo" name="numeroEmpleadoConsecutivo" type="text" placeholder="00000" class="input-small-mini" maxlength="5" readonly > -
              <input id="numeroEmpleadoTipo" name="numeroEmpleadoTipo" type="text" placeholder="00" class="input-mini-mini" maxlength="2" readonly>
            </td>
            <td ROWSPAN="8" valign="top" width="50%" style="padding:25px;">
              <div>Foto:</div>
              <div id="fotoEmpleado" style="width:150px;height:133px;border:1px solid;text-align:center;"></div>
              <input type="hidden" name="idFotoEmpleado" id="idFotoEmpleado" />
              <input type="file" id="fileFotoEmpleado" name="fileFotoEmpleado" >
              <output id="list"></output>
            </td>
          </tr>
          <tr>
            <td><label class="control-label2 label " for="apellidoPaternoEmpleado">Apellido Paterno</label></label> </td>
            <td><input id="apellidoPaternoEmpleado" name="apellidoPaternoEmpleado" type="text" class="input-large"></td>
          </tr>
          <tr >
            <td ><label class="control-label label" for="apellidoMaternoEmpleado">Apellido Materno</label></td>
            <td><input id="apellidoMaternoEmpleado" name="apellidoMaternoEmpleado" type="text" class="input-large"></td>
          </tr>
          <tr>
            <td><label class="control-label2 label" for="nombreEmpleado">Nombre</label></td>
            <td><input id="nombreEmpleado" name="nombreEmpleado" type="text" class="input-large" ></td>
          </tr>
          <tr>
          <td><label class="control-label label" for="txtClaveINET1">Clave INE</label></td>
          <td><input id="txtClaveINET1" name="txtClaveINET1" type="text" placeholder="MAYÚSCULAS" class="soloLetras" style="width: 60px;" maxlength="6" minlength="6">
              <input id="txtClaveINET2" name="txtClaveINET2" type="text" placeholder="NUMEROS" class="soloNumeros"   style="width: 50px;" maxlength="6" minlength="6">
              <select id="IdEFClaveINERE" name="IdEFClaveINERE" style="width: 55px;">
                <option value="0">EF</option>
                 <?php
                 for ($i=0; $i<count($catalogoEntidadesFederativasALaborar); $i++)
                 {
                  echo "<option value='". $catalogoEntidadesFederativasALaborar[$i]["idEntidadFederativa"]."'>". $catalogoEntidadesFederativasALaborar[$i]["idEntidadFederativa"] ." </option>";
                }
                ?>
              </select>
              <select id="IdGeneroClaveINERE" name="IdGeneroClaveINERE" style="width: 50px;">
                <option value="1">H</option>
                <option value="2">M</option>
              </select>
              <input id="txtClaveINET3" name="txtClaveINET3" type="text" class="soloNumeros" style="width: 25px;" maxlength="3" minlength='3'></td>
        </tr>
          <tr>
            <td><label class="control-label label" for="lblnumeroSeguroSocial">Numero SS</label></td>
            <td><input id="numeroSeguroSocial" name="numeroSeguroSocial" type="text" class="input-large" maxlength="11" onblur="verificarNumeroImssDuplicado();" ></td>
          </tr>
          <tr>
            <td><label class="control-label2 label" for="banco">Banco</label></td>
            <td><select id="selbanco" name="selbanco"></select></td>
          </tr>
          <tr>
            <td><label class="control-label2 label" for="numeroCta">Numero Cta</label></td>
            <td><input id="txtNumeroCta" name="txtNumeroCta" type="text" class="input-large"  onblur = "verificarNumeroCuentaDuplicado();" ></td>
          </tr>
          <tr>
            <td><label class="control-label label" for="numeroCta">Numero Cta Clabe</label></td>
            <td><input id="txtCtaClabe" name="txtCtaClabe" type="text" class="input-large" maxlength="18" onblur="verificarNumeroCuentaClaveDuplicado();"></td>
          </tr>
          <tr>
            <td><label class="control-label2 label" for="fechaIngreso">Fecha Ingreso</label></td>
            <td><input id="fechaIngreso" name="fechaIngreso" type="text" class="input-medium"></td>
          </tr>
          <tr>
            <td><label class="control-label label" for="entidadFederativa" >Linea de Negocio</label></td>
            <td><select id="selectLineaNegocio" name="selectLineaNegocio" class="input-large "onChange="obtenerSupervisoresOperativos(); seleccionarDepartamentoIngreso();">
              <option>LINEA NEGOCIO</option>
              <?php
                for ($i = 0; $i < count($catalogoLineaNegocio); $i++) {
                  echo "<option value='" . $catalogoLineaNegocio[$i]["idLineaNegocio"] . "'>" . $catalogoLineaNegocio[$i]["descripcionLineaNegocio"] . " </option>";
                }
              ?>
            </td>
          </tr>
          <tr>
            <td><label class="control-label label" for="entidadFederativa" >Entidad Federativa</label><br><label class="control-label label" for="entidadFederativa" >Contratacion</label></td>
            <td><select id="idEndidadFederativa" name="idEndidadFederativa" class="input-large " >
              <option>ENTIDAD FEDERATIVA</option>
              <?php
                for ($i = 0; $i < count($catalogoEntidadesFederativas); $i++) {
                  echo "<option value='" . $catalogoEntidadesFederativas[$i]["idEntidadFederativa"] . "'>" . $catalogoEntidadesFederativas[$i]["nombreEntidadFederativa"] . " </option>";
                }
              ?>
            </td>
          </tr>
          <tr>
            <td><label class="control-label2 label" for="licencia">¿Dará Tarjeta De Despensa?</label></td>
            <td>
              <div class='radio'><input type='radio'  name='TarjetaDespensaSi' id='TarjetaDespensaSi' value='1' >Si</div>
              <div class='radio'><input type='radio'  name='TarjetaDespensaNo' id='TarjetaDespensaNo' value='0' >No</div>
            </td>
          </tr>
          <tr style="display:none">
            <td><input id="txtnumeroFirmaempleado" name="txtnumeroFirmaempleado" type="text" class="input-large" readonly="true"></td>
            <td><input id="ContraseniaFirmaemp" name="ContraseniaFirmaemp" type="text" class="input-large" readonly="true"></td>
          </tr>
          <tr id="TrIutTarjeta" style="display:none">
            <td><label class="control-label2 label" for="numeroIut">Num IUT Tarjeta(Despensa)</label></td>
            <td><input id="txtnumeroIut" name="txtnumeroIut" type="text" class="input-large" readonly="true"></td>
          </tr>
          <tr>
            <td><label class="control-label label" for="SucursalIngreso" >Sucursales</label></td>
            <td><select id="idSucursalIngreso" name="idSucursalIngreso" class="input-large "></td>
          </tr>
          <tr>
            <td><label class="control-label2 label" for="lbltipoPuesto">Tipo Puesto</label></td>
            <td>
              <select id="tipoPuesto" name="tipoPuesto" class="input-large " onChange="obtenerUltimoNumeroEmpleado(); obtenerSupervisoresOperativos(); optionReclutador();seleccionarDepartamentoIngreso();">
                <option>TIPO PUESTO</option>
                <?php
                  for ($i = 0; $i < count($catalogoTipoPuestos); $i++) {
                    echo "<option value='" . $catalogoTipoPuestos[$i]["idCategoria"] . "' >" . $catalogoTipoPuestos[$i]["descripcionCategoria"] . " </option>";
                  }
                ?>
              </select>
            </td>
          </tr>
          <tr id="trDeptoIngreso">
            <td><label class="control-label label" for="DeptoIngreso">Departamento</label></td>
            <td><select id="DeptoIngreso" name="DeptoIngreso" class="input-large"></select></td>
          </tr>
          <tr>
            <td><label class="control-label label" for="puesto">Puesto</label></td>
            <td><select id="puesto" name="puesto" class="input-large"></select></td>
          </tr>
          <tr>
            <td><label class="control-label2 label" for="Dirigente">Supervisor(Resp Asis)</label></td>
            <td><select id="dirigente" name="dirigente" class="input-large"></select></td>
            <td><div id="divdirigentes" ></div></td>
          </tr>
          <tr>
            <td><label class="control-label label" for="entidadFederativa" >Entidad Federativa</label><br><label class="control-label label" for="entidadFederativa" >para laborar</label></td>
            <td><select id="selectEndidadFederativaLabor" name="selectEndidadFederativaLabor" class="input-large ">
              <option>ENTIDAD FEDERATIVA</option>
              <?php
                for ($i = 0; $i < count($catalogoEntidadesFederativasALaborar); $i++) {
                  echo "<option value='" . $catalogoEntidadesFederativasALaborar[$i]["idEntidadFederativa"] . "'>" . $catalogoEntidadesFederativasALaborar[$i]["nombreEntidadFederativa"] . " </option>";
                }
              ?>
            </td>
          </tr>
          <tr>
            <td><label class="control-label label" for="gerenteReg">Gerente Regional</label></td>
            <td>
              <select id="gerenteReg" name="gerenteReg" class="input-large">
                <option value="0">GERENTE REGIONAL</option>
              </select>
            </td>
          </tr>
          <tr>
            <td><label class="control-label2 label" for="PuntodeServicio">Punto de Servicio</label></td>
            <td>
              <select id='selectPuntoServicio' name='selectPuntoServicio' class='input-large' onchange="obtenerClienteByPuntoServicioId();LimpiarDatosTabuladorSalarioDiario();"><option>PUNTO DE SERVICIO</option></select>
              <input id="txtClienteId" name="txtClienteId" type="hidden" class="input-large" maxlength="14">
            </td>
            <tr>
              <td><label class="control-label label" for="Turno">Turno</label></td>
              <td>
                <select id="tipoTurno" name="tipoTurno" class="input-large ">
                  <option>TURNO</option>
                  <?php
                    for ($i = 0; $i < count($catalogoTurnos); $i++) {
                      echo "<option value='" . $catalogoTurnos[$i]["idTipoTurno"] . "' >" . $catalogoTurnos[$i]["descripcionTurno"] . " </option>";
                    }
                  ?>
                </select>
              </td>
            </tr>
          </tr>
          <tr>
            <td><label class="control-label2 label" for="PuntodeServicio">Plantilla de Servicio</label></td>
            <td>
              <select id='selplantillaservicio' name='selplantillaservicio' class='input-large'><option>PLANTILLA</option></select>
            </td>
            <input type="hidden" name="idRolOpertaivoPorPlantillaAlta" id="idRolOpertaivoPorPlantillaAlta">
            <input type="hidden" name="roloperativoTexto" id="roloperativoTexto">
          </tr>
          <tr>
            <td><label class="control-label2 label" for="selHorarioAlta">Horarios</label></td>
            <td>
              <select id='selHorarioAlta' name='selHorarioAlta' class='input-xlarge'></select>
            </td>
          </tr>
          <tr >
            <td><label class="control-label label" for="SueldoEmp">Salario Diario</label></td>
            <td>
                <input id="SalarioDiarioEmp" name="SalarioDiarioEmp" type="text" class="input-small" placeholder="S.D" readonly>
                <input id="SalarioDiarioEmpImss" name="SalarioDiarioEmpImss" type="text" class="input-small" placeholder="S.D" readonly style="display: none;">
                <input id="SueldoSalarioDiarioEmp" name="SueldoSalarioDiarioEmp" type="hidden" class="input-small">
                <button id="btnGenrarSalarioDiario" name="btnGenrarSalarioDiario" class="btn btn-primary" type="button">Generar</button>
                <button id="btnConfirmadoSalarioDiario" name="btnConfirmadoSalarioDiario" class="btn btn-success"style="display: none;"  type="button">Confirmado</button>
                <button id="btnConfirmarSalarioDiario" name="btnConfirmarSalarioDiario" class="btn btn-warning" type="button" style="display: none;"> <span class="glyphicon glyphicon-floppy-save"></span>Confirmar</button> 
                <img src="img/rechazarImss.png" width="4%" id="imgMalSalarioDiario">
                <img src="img/ok.png" width="4%" id="imgBienSalarioDiario" style="display: none;">
            </td>
          </tr>
          <tr>
            <td><label class="control-label2 label" for="licencia">Licencia de conducir</label></td>
            <td>
              <div class='radio'><input type='radio'  name='licenciaConducir' id='licenciaConducirsiEMp' value='1' >Si</div>
              <div class='radio'><input type='radio'  name='licenciaConducir' id='licenciaConducirnoEMp' value='0' >No</div>
            </td>
          </tr>
          <tr id="trlicenciapermanente" style="display:none">
            <td ><label class="control-label2 label" for="licenciapermanente">Permanente</label></td>
            <td>
              <div class='radio'><input type='radio'  name='licenciaConducirpermanente' id='licenciaConducirsipermanente' value='1' >Si</div>
              <div class='radio'><input type='radio'  name='licenciaConducirpermanente' id='licenciaConducirnopermanente' value='0' >No</div>
            </td>
          </tr>
          <tr id="trnumerolicencia" style="display:none">
            <td ><label class="control-label2 label" for="estaturaEmpleado">Número licencia</label></td>
            <td><input id="numerolicencia" name="numerolicencia" type="text" class="input-large"></td>
          </tr>
          <tr id="trvigencialicencia" style="display:none">
            <td ><label class="control-label2 label" for="fechavigencialicencia">Fecha Vigencia Licencia</label></td>
            <td><input id="inpfehavigencialicencia" name="inpfehavigencialicencia" type="date" class="input-large"></td>
          </tr>
          <tr>
            <td><label class="control-label2 label" for="Sexo">Sexo</label></td>
            <td>
              <?php
                for ($i = 0; $i < count($catalogoGeneros); $i++) {
                  echo "<div class='radio'><input type='radio' name='genero' id='" . $catalogoGeneros[$i]["idGenero"] . "' value='" . $catalogoGeneros[$i]["idGenero"] . "' >" . $catalogoGeneros[$i]["nomenclaturaGenero"] . "</div>";
                }
              ?>
            </td>
          </tr>
<!--NUEVO SOBRE CARACTERISTICAS FISICA-->
          <tr>
            <td><label class="control-label label" for="tesEmpleado" >Tes</label></td>
            <td><select id="tesEmpleado" name="tesEmpleado" class="input-large ">
              <option value="1">CLARA</option>
              <option value="2">MORENA</option>
            </td>
          </tr>
          <tr >
            <td ><label class="control-label label" for="estaturaEmpleado">Estatura</label></td>
            <td><input id="estaturaEmpleado" name="estaturaEmpleado" type="text" class="input-medium"></td>
          </tr>
          <tr>
            <td ><label class="control-label label" for="tallaCEmpleado">Talla Camisa</label></td>
            <td><input id="tallaCEmpleado" name="tallaCEmpleado" type="text" class="input-medium"></td>
          </tr>
          <tr>
            <td ><label class="control-label label" for="tallaPEmpleado">Talla Pantalón</label></td>
            <td><input id="tallaPEmpleado" name="tallaPEmpleado" type="text" class="input-medium"></td>
          </tr>
          <tr>
            <td ><label class="control-label label" for="numCalzadoEmpleado">Numero de Calzado</label></td>
            <td><input id="numCalzadoEmpleado" name="numCalzadoEmpleado" type="text" class="input-medium"></td>
          </tr>
          <tr>
            <td ><label class="control-label label" for="pesoEmpleado">Peso</label></td>
            <td><input id="pesoEmpleado" name="pesoEmpleado" type="text" class="input-medium"></td>
          </tr>

          <tr>
            <td ><label class="control-label label" for="txtContactoGif">Contacto Gif</label></td>
            <td><input id="txtContactoGif" name="txtContactoGif" type="text" placeholder="NUMERO TELEFONICO GIF" class="soloNumeros" style="width: 150px;" maxlength="10" minlength="10"></td>
          </tr>

          <tr>
            <td ><label class="control-label label" for="txtCorreoGif">Correo Gif</label></td>
            <td>
              <input id="txtCorreoGif" name="txtCorreoGif" type="text" placeholder="CORREO GIF" class="sinEspacios" style="width: 150px;">
              <input id="txteXTENSIONCorreoGifEdited" name="txteXTENSIONCorreoGifEdited" type="text" value="@gifseguridad.com.mx" style="width: 150px;" readonly>
            </td>
            
          </tr>

          <tr>
            <td><label class="control-label2 label" for="lblPeriodo">Periodo</label></td>
            <td>
              <?php
                for ($i = 0; $i < count($catalogoPeriodos); $i++) {
                  echo "<input type='radio' name='periodo' id='" . $catalogoPeriodos[$i]["tipoPeriodoId"] . "' value='" . $catalogoPeriodos[$i]["tipoPeriodoId"] . "' >" . $catalogoPeriodos[$i]["descripcionTipoPeriodo"] . "<br>";
                }
              ?>
            </td>
          </tr>
          <tr>
            <td><label class="control-label2 label" for="Antiguedad">Conserva Antiguedad</label></td>
            <td>
              <div class='radio'><input type='radio' title="El elemento viene de un cambio proveniente del grupo de empresas GIF" name='antiguedadVacacionesS' id='AntiguedadVacacionesSi' value='2' >Si</div>
              <div class='tooltips'><input type='radio' title="El elemento es nuevo no ha pertenecido al grupo de empresas GIF " name='antiguedadVacacionesN' id='AntiguedadVacacionesNo' value='2' >No</div>
            </td>
          </tr>
          <tr>
            <td><div name="divLbSelectSup" id="divLbSelectSup"></div></td>
            <td><div id="divSelectSub" name="divSelectSub"></div></td>
          </tr>
          <tr>
            <td><div name="divLblReclutador" id="divLblReclutador"></div></td>
            <td><div id="divReclutador" name="divReclutador"></div></td>
          </tr>
          <tr>
            <td><div id="divLblMedio" name="divLblMedio"></div></td>
            <td><div id="divMedioInformacion" name="divMedioInformacion"></div></td>
          </tr><!--van dentro de un form -->
          <tr>
            <td><div name="divLbSelectSup" id="divLbSelectSup"></div></td>
            <td><div id="divSelectSub" name="divSelectSub"></div></td>
          </tr>
          <tr>
            <td><div name="divLblReclutador" id="divLblReclutador"></div></td>
            <td><div id="divReclutador" name="divReclutador"></div></td>
          </tr>
          <tr>
            <td><div id="divLblMedio" name="divLblMedio"></div></td>
            <td><div id="divMedioInformacion" name="divMedioInformacion"></div></td>
          </tr>
          <tr>
            <tr>
              <div class="input-prepend">
                <td ><span class="add-on" for="docdigitalizadoo">AVISO INSCRIPCIÓN IMSS:</span></td>
                <td ><input type='file' class='btn-success' id='docdigitalizadoo0' name='docdigitalizadoo0[]' /></td>    
              </div>
            </tr>
            <tr>
              <div class="input-prepend">
                <td ><span class="add-on" for="docdigitalizadoo">TICKET DE CUENTA:</span></td>
                <td ><input type='file' class='btn-success' id='docdigitalizadoo1' name='docdigitalizadoo1[]'  /></td>
              </div>
            </tr>
            <tr>
              <div class="input-prepend">
                <td ><span class="add-on" for="docdigitalizadoo">CEDULA SAT(RFC):</span></td>
                <td ><input type='file' class='btn-success' id='docdigitalizadoo2' name='docdigitalizadoo2[]'  /></td>
              </div>
            </tr>
            <tr id="trarchivolicencia" style="display: none">
              <div class="input-prepend">
                <td ><span class="add-on" for="docdigitalizadoo">LICENCIA CONDUCIR:</span></td>
                <td ><input type='file' class='btn-success' id='docdigitalizadoo3' name='docdigitalizadoo3[]'  /></td>
              </div>
            </tr>
          </tr>
          <tr>
            <td><button id="MostrarModalAltaEmp" name="MostrarModalAltaEmp" class="btn btn-warning" type="button" onclick="mostrarModalFirmaALtaEmpleado();"> <span class="glyphicon glyphicon-floppy-save"></span>Abrir Firma Alta Empleado</button></td>
            <td><button id="guardar" name="guardar" class="btn btn-primary" type="button" onclick="verificarTipoEmpleado();"> <span class="glyphicon glyphicon-floppy-save"></span>Guardar</button></td>
          </tr>
        </table><!--Fin Tabla Datos Generales -->
      </div><!--Fin Div datos generales -->

      <!-- incio de datos fiscales  -->

  <div align="center" class="tab-pane" id="containerDatosFiscalesR" >
    <div id="MesjaeErrorDatosFiscales"></div>
    <h2>Datos Fiscales</h2>
    <h4>Registrar La Informacón De La Cedula De Situación Fiscal </h4>
    <h5>DATOS DEL DOMICILIO REGISTRADO</h5>
    <table align="center" class="table1">
      <tr>
        <td><label class="control-label label " for="cp">Codigo Postal</label></td>
        <td>
          <input id="CodigoPostalDatosFiscalesR" name="CodigoPostalDatosFiscalesR" type="text"  class="input-large"  maxlength="5" onkeyup="consultaCpDatosFiscales();">
          <!--<input id="txtIdAsentamientoEdited" name="txtIdAsentamientoEdited" type="hidden" />  -->
        </td>
        <td>&nbsp;</td>
        <td style="width:400px;" rowspan="13" valign="top"><div id="multipleDireccionesDatosFiscalesR"></div></td>
      </tr>
      <tr >
        <td ><label class="control-label label" for="EntidadFR">Entidad</label></td>
        <td><select id="EntidadDatosFiscalesR" name="EntidadDatosFiscalesR" class="input-large"></select></td>
      </tr>
      <tr>
        <td ><label class="control-label label" for="municipioR">Municipio o Demarcación</label></td>
        <td><select id="MunicipioDatosFiscalesR" name="MunicipioDatosFiscalesR" class="input-large"></select></td>
      </tr>
      <tr>
        <td ><label class="control-label label" for="LocalidadR">Localidad</label></td>
        <td><select id="LocalidadDatosFiscalesR" name="LocalidadDatosFiscalesR" class="input-large"></select></td>
      </tr>
      <tr>
        <td ><label class="control-label label" for="ColoniaR">Colonia</label></td>
        <td><input id="ColoniaDatosFiscalesR" name="ColoniaDatosFiscalesR" type="text" placeholder="Colonia" class="input-large"></td>
      </tr>
      <tr>
        <td ><label class="control-label label" for="VialidadR">Nombre De Vialidad</label></td>
        <td><input id="VialidadDatosFiscalesR" name="VialidadDatosFiscalesR" type="text" placeholder="Vialidad" class="input-large"></td>
      </tr>
      <tr>
        <td ><label class="control-label label" for="TipoVidalidadR">Tipo De Vialidad</label></td>
        <td><input id="TipoVidalidadDatosFiscalesR" name="TipoVidalidadDatosFiscalesR" type="text" placeholder="Tipo De Vidalidad" class="input-large"></td>
      </tr>
      <tr>
        <td ><label class="control-label label" for="numero">Numero</label></td>
        <td><input id="NumExternoDatosFiscalesR" name="NumExternoDatosFiscalesR" type="text" placeholder="EXT" class="input-small"><input id="NumInternoDatosFiscalesR" name="NumInternoDatosFiscalesR" type="text"   placeholder="INT" class="input-small"></td>
      </tr>
      <tr>
        <td ><label class="control-label label" for="EstadoDomicilioR">Estado Del Domicilio</label></td>

        <td>
          <select id="EstadoDoicilioDatosFiscalesR" name="EstadoDoicilioDatosFiscalesR" class="input-large">
            <option value="0">ENTIDAD FEDERATIVA</option>
            <?php
              for ($i=0; $i<count($catalogoEntidadesFederativas); $i++)
              {
                echo "<option value='". $catalogoEntidadesFederativas[$i]["idEntidadFederativa"]."'>". $catalogoEntidadesFederativas[$i]["nombreEntidadFederativa"] ." </option>";
              }
            ?>
          </select>
        </td>
      </tr>
      <tr>
        <td></td>
        <td>
          <button id="GuardarDatosFiscalesR" name="GuardarDatosFiscalesR" class="btn btn-success" type="button">Guardar</button>
        </td>
      </tr>
    </table>
  </div>
    <!-- Fin de datos fiscales    -->


      <!--Comienza Div datos personales Otra Pestaña -->
      <div align="center" class="tab-pane" id="containerDatosPersonales">
        <legend><h3>Datos Personales</h3></legend>
        <table class="table1">
          <tr>
            <td><label class="control-label label " for="fechaNacimiento">Fecha Nacimiento</label></td>
            <td><input id="txtFechaNacimiento" name="txtFechaNacimiento" type="date"  class="input-large"></td>
          </tr>
          <tr>
            <td><label class="control-label label " for="Edad">Edad</label></td>
            <td><input id="txtEdad" name="txtEdad" type="number"  class="input-large" max="90" min="15"></td>
          </tr>
          <tr>
            <td><label class="control-label label " for="pais">Pais Nacimiento</label></td>
            <td>
              <select id="selectPaisNacimiento" name="selectPaisNacimiento" class="input-large ">
                <?php
                  for ($i = 0; $i < count($catalogosPaises); $i++) {
                    echo "<option value='" . $catalogosPaises[$i]["idPais"] . "' >" . $catalogosPaises[$i]["nombrePais"] . " </option>";
                  }
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <td><label class="control-label label" for="entidadN">Entidad Nacimiento</label></td>
            <td>
              <select id="selectEntidadNacimiento" name="selectEntidadNacimiento" class="input-large" onChange="consultarMunicipiosPorEntidad();" >
                <option>ENTIDAD FEDERATIVA</option>
                <?php
                  for ($i = 0; $i < count($catalogoEntidadesFederativas); $i++) {
                    echo "<option value='" . $catalogoEntidadesFederativas[$i]["idEntidadFederativa"] . "'>" . $catalogoEntidadesFederativas[$i]["nombreEntidadFederativa"] . " </option>";
                  }
                ?>
              </select>  
            </td>
          </tr>
          <tr>
            <td ><label class="control-label label" for="municipioN">Municipio Nacimiento</label></td>
            <td><select id="selectMunicipioNac" name="selectMunicipioNac" class="input-large" ></td>
          </tr>
          <tr>
            <td ><label class="control-label label" for="curp">CURP</label></td>
            <td><input id="txtCurp" name="txtCurp" type="text" placeholder="" class="input-large" maxlength="18"></td>
            <td><input id="ClaveEntidadFederativaRegidtro" name="ClaveEntidadFederativaRegidtro" type="hidden" class="input-large"></td>
          </tr>
          <tr>
            <td ><label class="control-label label" id="LabelCurpInternoRegistro" for="curpintern" style="display: none;">CURP INTERNO</label></td>
            <td><input id="txtCurpInternoRegistro" name="txtCurpInternoRegistro" type="text" class="input-large" style="display: none;" readonly="true"></td>
          </tr>
          <tr>
            <td ><label class="control-label label" id="LabelCheckCurpInternoRegistro" for="curp" style="display: none;">¿Continuar Con EL CURP?</label></td>
            <td><input id="checkCurpRegistro" name="checkCurpRegistro" type="checkbox" style="transform: scale(1.5);display: none;"></td>
          </tr>
          <tr>
            <td ><label class="control-label label" for="rfc">RFC</label></td>
            <td><input id="txtRfc" name="txtRfc" type="text"  class="input-large" maxlength="13"></td>
          </tr>
          <tr>
            <td ><label class="control-label label" id="LabelCheckRfcInternocheckRfcRegistro" for="curp" style="display: none;">¿Continuar Con El RFC?</label></td>
            <td><input id="checkRfcRegistro" name="checkRfcRegistro" type="checkbox" style="transform: scale(1.5);display: none;"></td>
          </tr>
          <tr>
            <td ><label class="control-label label" for="edoCivil">Estado Civil</label></td>
            <td>
              <select id="selectEstadoCivil" name="selectEstadoCivil" class="input-large ">
                <option>ESTADO CIVIL</option>
                <?php
                  for ($i = 0; $i < count($catalogoEstadoCivil); $i++) {
                    echo "<option value='" . $catalogoEstadoCivil[$i]["idEstadoCivil"] . "' >" . $catalogoEstadoCivil[$i]["descripcionEstadoCivil"] . " </option>";
                  }
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <td ><label class="control-label label" for="gradoEstudios">Grado Estudios</label></td>
            <td>
              <select id="selectGradoEstudios" name="selectGradoEstudios" class="input-large ">
                <option>GRADO ESTUDIOS</option>
                <?php
                  for ($i = 0; $i < count($catalogoGradoEstudios); $i++) {
                    echo "<option value='" . $catalogoGradoEstudios[$i]["idGradoEstudios"] . "' >" . $catalogoGradoEstudios[$i]["descripcionGradoEstudios"] . " </option>";
                  }
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <td><label class="control-label label" for="Sangre">Tipo Sangre</label></td>
            <td>
              <select id="selectTipoSangre" name="selectTipoSangre" class="input-large ">
                <option>TIPO SANGRE</option>
                <?php
                  for ($i = 0; $i < count($catalogoTipoSangre); $i++) {
                      echo "<option value='" . $catalogoTipoSangre[$i]["idTipoSangre"] . "' >" . $catalogoTipoSangre[$i]["tipoSangre"] . " </option>";
                  }
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <td><label class="control-label label" for="Oficio">Oficio</label></td>
            <td>
              <select id="selectOficio" name="selectOficio" class="input-large ">
                <option>OFICIO</option>
                <?php
                  for ($i = 0; $i < count($catalogoOficios); $i++) {
                      echo "<option value='" . $catalogoOficios[$i]["idOficio"] . "' >" . $catalogoOficios[$i]["descripcionOficio"] . " </option>";
                  }
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <td><label class="control-label label" for="cartilla">Cartilla</label></td>
            <td>
              <?php
                for ($i = 0; $i < count($catalogoEstatusCartilla); $i++) {
                echo "<div class='radio'><input type='radio' name='estatusCartilla' id='" . $catalogoEstatusCartilla[$i]["idEstatusCartilla"] . "estatusCartilla' value='" . $catalogoEstatusCartilla[$i]["idEstatusCartilla"] . "' >" . $catalogoEstatusCartilla[$i]["descripcionEstatusCartilla"] . "</div>";
                }
              ?>
            </td>
          </tr>
          <tr>
            <td ><label class="control-label label" for="numeroCartilla">Numero Cartilla</label></td>
            <td><input id="txtNumeroCartilla" name="txtNumeroCartilla" type="text"  class="input-medium"></td>
          </tr>
          <tr>
            <td>
              <button id="btnGuardarDatosPersonales" name="btnGuardarDatosPersonales" class="btn btn-primary" type="button" onclick="CreacionCurpInternRegistro();"> <span class="glyphicon glyphicon-floppy-save"></span>Guardar</button>
            </td>
          </tr>
        </table>
      </div><!--Termina Div datos personales -->


  <!--Inicia Div datos Directorio -->

  <div align="center" class="tab-pane" id="containerDirectorio" >

    <legend><h3>Directorio</h3></legend>
      <table class="table1" >
        <tr>
          <td><label class="control-label label " for="cp">C.P Vivienda</label></label> </td>
          <td>
            <input id="txtCP" name="txtCP" type="text"  class="input-large"  maxlength="5" onkeyup="consultaCP(); ">
            <input id="txtIdAsentamiento" name="txtIdAsentamiento" type="hidden" />
          </td>
          <td>&nbsp;</td>
          <td style="width:400px;" rowspan="13" valign="top"><div id="multipleDirecciones"></div></td>
        </tr>
        <tr >
          <td ><label class="control-label label" for="Entidad">Entidad</label></td>
          <td><input id="txtEntidad" name="txtEntidad" type="text"  class="input-large" readonly></td>
        </tr>
        <tr>
          <td ><label class="control-label label" for="municipio">Municipio</label></td>
          <td><input id="txtMunicipio" name="txtMunicipio" type="text" placeholder="Municipio" class="input-large" readonly>
          <input id="txtIdMunicipio" name="txtIdMunicipio" type="hidden">
          <input id="municipioTexto" name="municipioTexto" type="hidden"></td>

        </tr>
        <tr>
          <td ><label class="control-label label" for="colonia">Colonia</label></td>
          <td><input id="txtColonia" name="txtColonia" type="text" placeholder="Colonia" class="input-large" readonly>
            <input id="coloniaTexto" name="coloniaTexto" type="hidden"></td>
        </tr>
        <tr>
          <td ><label class="control-label label" for="calle">Calle</label></td>
          <td><input id="txtCalle" name="txtCalle" type="text" placeholder="Calle" class="input-large"></td>
        </tr>
        <tr>
          <td ><label class="control-label label" for="numero">Numero</label></td>
          <td><input id="txtNumeroExt" name="txtNumeroExt" type="text" placeholder="EXT" class="input-small"><input id="txtNumeroInt" name="txtNumeroInt" type="text" placeholder="INT" class="input-small"></td>
        </tr>
        <tr>
          <td ><label class="control-label label" for="TelefonoFijo">Telefono Fijo</label></td>
          <td><input id="txtTelefonoFijo" name="txtTelefonoFijo" type="text" class="input-large" maxlength="10"></td>
        </tr>
        <tr>
          <td ><label class="control-label label" for="TelefonoMovil">Telefono Movil</label></td>
          <td><input id="txtTelefonoMovil" name="txtTelefonoMovil" type="text"  class="input-large" maxlength="10"></td>
       </tr>
       <tr>
        <td ><label class="control-label label" for="correo">Correo</label></td>
        <td><input id="txtCorreo" name="txtCorreo" type="text"  class="input-large-email"></td>
       </tr>
        <tr>
        <td ><label class="control-label label" for="nombreDel">Nombre UMF</label></td>
        <td >
          <input id="txtNombreUmf" name="txtNombreUmf" type="text"  class="input-large" readonly>
          <input id="txtIdUmf" name="txtIdUmf"  type="hidden">

        </td>
        <td></td>
        <td style="width:400px;" rowspan="13" valign="top"><div id="multipleUmf"></div></td>
      </tr>
       <tr>
          <td ><label class="control-label label" for="direccionUMF">Direccion UMF</label></td>
          <td ><textarea id="txtDireccionUmf" name="txtDireccionUmf" class="txtArea" readonly></textarea></td></td>
       </tr>

      <tr>
        <td></td>
        <td>
          <button id="btnGuardarDatosDireccion" name="btnGuardarDatosDireccion" class="btn btn-primary" type="button" onclick="guardarDatosDireccionSubmit();"> <span class="glyphicon glyphicon-floppy-save"></span>Guardar</button>
         <!-- <button id="cancelar" name="guardar" class="btn btn-danger" type="button" onclick="" > <span class="glyphicon glyphicon-remove"></span>Cancelar</button>-->
        </td>
      </tr>
    </table>
  </div>
  <!--Termina Div datos Directorio -->

<div align="center" class="tab-pane" id="containerDatosFamiliares" >

    <legend><h3>Beneficiarios</h3></legend>
      <!-- <table> 
        <tr>
        <tr >
          <td ><label class="control-label label" for="Entidad">Nombre Padre</label></td>
          <td><input id="txtNombrePadre" name="txtNombrePadre" type="text"  class="input-xlarge" ></td>
          <td><input type='checkbox' name='checkPadre' class='style3' id='checkPadre'  >Beneficiario</td>
          <td><input id="txtPorcentajePadre" name="txtPorcentajePadre" type="number" min="1" max="100" class="input-small-mini"></td>
          <td><label>%</label></td>
        </tr>
        <tr>
          <td ><label class="control-label label" for="municipio">Nombre Madre</label></td>
          <td><input id="txtNombreMadre" name="txtNombreMadre" type="text" placeholder="" class="input-xlarge" ></td>
          <td><input type='checkbox' name='checkMadre' id='checkMadre' class='style3' checked  >Beneficiario</td>
          <td><input id="txtPorcentajeMadre" name="txtPorcentajeMadre" type="number" min="1" max="100" class="input-small-mini"></td>
          <td><label>%</label></td>
        </tr>
    </table>
-->
    <br>
    <br>

    <table>
      <tr>
        <td><img src="img/addMenu.png" width="20" id="agregarBeneficiario" title="Agregar beneficiario" ><label class="control-label label" for="Beneficiario">AGREGAR BENEFICIARIO</label></td>
        <td><img src="img/restar.png"  width="20" id="eliminarBeneficiario" title="Eliminar Beneficiario" style="display: none;"></td>
      </tr>
    </table>

    <br>
    <br>
    <input type="hidden" id="conteoBeneficiarios" value="0">
    <table>
        <tr id="trTitulosBeneficiarios" style="display:none;">
          <td style="text-align: center;"><label>PARENTESCO</label></td>
          <td style="text-align: center;"><label>NOMBRE COMPLETO</label></td>
          <!-- <td><label>BENEFICIARIO</label></td> -->
          <td style="text-align: center;"><label>%</label></td>
        </tr>
        <tr id="trBeneficiario1" style="display:none;">
          <td><input id="txtParentescoBeneficiario1" name="txtParentescoBeneficiario1" type="text" class="input-medium" placeholder="PARENTESCO"></td>
          <td><input id="txtNombreBeneficiario1" name="txtNombreBeneficiario1" type="text"  class="input-xlarge" placeholder="NOMBRE COMPLETO BENEFICIARIO 1"></td>
          <!-- <td style="text-align: center;"><input type='checkbox' name='checkBeneficiario1' class='style3' id='checkBeneficiario1' disabled></td> -->
          <td style="text-align: center;"><input align="center" id="txtPorcentajeBeneficiario1" name="txtPorcentajeBeneficiario1" type="number" min="1" max="100" class="input-small-mini" placeholder="%"></td>
        </tr>

        <tr id="trBeneficiario2" style="display:none;">
          <td><input id="txtParentescoBeneficiario2" name="txtParentescoBeneficiario2" type="text" class="input-medium" placeholder="PARENTESCO"></td>
          <td><input id="txtNombreBeneficiario2" name="txtNombreBeneficiario2" type="text"  class="input-xlarge" placeholder="NOMBRE COMPLETO BENEFICIARIO 2"></td>
          <!-- <td style="text-align: center;"><input type='checkbox' name='checkBeneficiario2' class='style3' id='checkBeneficiario2' readonly></td> -->
          <td style="text-align: center;"><input align="center" id="txtPorcentajeBeneficiario2" name="txtPorcentajeBeneficiario2" type="number" min="1" max="100" class="input-small-mini" placeholder="%"></td>
        </tr>

        <tr id="trBeneficiario3" style="display:none;">
          <td><input id="txtParentescoBeneficiario3" name="txtParentescoBeneficiario3" type="text" class="input-medium" placeholder="PARENTESCO"></td>
          <td><input id="txtNombreBeneficiario3" name="txtNombreBeneficiario3" type="text"  class="input-xlarge" placeholder="NOMBRE COMPLETO BENEFICIARIO 3"></td>
          <!-- <td style="text-align: center;"><input type='checkbox' name='checkBeneficiario3' class='style3' id='checkBeneficiario3' readonly></td> -->
          <td style="text-align: center;"><input id="txtPorcentajeBeneficiario3" name="txtPorcentajeBeneficiario3" type="number" min="1" max="100" class="input-small-mini" placeholder="%"></td>
        </tr>

        <tr id="trBeneficiario4" style="display:none;">
          <td><input id="txtParentescoBeneficiario4" name="txtParentescoBeneficiario4" type="text" class="input-medium" placeholder="PARENTESCO"></td>
          <td><input id="txtNombreBeneficiario4" name="txtNombreBeneficiario4" type="text"  class="input-xlarge" placeholder="NOMBRE COMPLETO BENEFICIARIO 4"></td>
          <!-- <td style="text-align: center;"><input type='checkbox' name='checkBeneficiario4' class='style3' id='checkBeneficiario4' readonly></td> -->
          <td style="text-align: center;"><input id="txtPorcentajeBeneficiario4" name="txtPorcentajeBeneficiario4" type="number" min="1" max="100" class="input-small-mini" placeholder="%"></td>
        </tr>

        <tr id="trBeneficiario5" style="display:none;">
          <td><input id="txtParentescoBeneficiario5" name="txtParentescoBeneficiario5" type="text" class="input-medium" placeholder="PARENTESCO"></td>
          <td><input id="txtNombreBeneficiario5" name="txtNombreBeneficiario5" type="text"  class="input-xlarge" placeholder="NOMBRE COMPLETO BENEFICIARIO 5"></td>
          <!-- <td style="text-align: center;"><input type='checkbox' name='checkBeneficiario5' class='style3' id='checkBeneficiario5' readonly></td> -->
          <td style="text-align: center;"><input id="txtPorcentajeBeneficiario5" name="txtPorcentajeBeneficiario5" type="number" min="1" max="100" class="input-small-mini" placeholder="%"></td>
        </tr>

        <tr id="trBeneficiario6" style="display:none;">
          <td><input id="txtParentescoBeneficiario6" name="txtParentescoBeneficiario6" type="text" class="input-medium" placeholder="PARENTESCO"></td>
          <td><input id="txtNombreBeneficiario6" name="txtNombreBeneficiario6" type="text"  class="input-xlarge" placeholder="NOMBRE COMPLETO BENEFICIARIO 6"></td>
          <!-- <td style="text-align: center;"><input type='checkbox' name='checkBeneficiario6' class='style3' id='checkBeneficiario6' readonly></td> -->
          <td style="text-align: center;"><input id="txtPorcentajeBeneficiario6" name="txtPorcentajeBeneficiario6" type="number" min="1" max="100" class="input-small-mini" placeholder="%"></td>
        </tr>

        <tr id="trBeneficiario7" style="display:none;">
          <td><input id="txtParentescoBeneficiario7" name="txtParentescoBeneficiario7" type="text" class="input-medium" placeholder="PARENTESCO"></td>
          <td><input id="txtNombreBeneficiario7" name="txtNombreBeneficiario7" type="text"  class="input-xlarge" placeholder="NOMBRE COMPLETO BENEFICIARIO 7"></td>
          <!-- <td style="text-align: center;"><input type='checkbox' name='checkBeneficiario7' class='style3' id='checkBeneficiario7' readonly></td> -->
          <td style="text-align: center;"><input id="txtPorcentajeBeneficiario7" name="txtPorcentajeBeneficiario7" type="number" min="1" max="100" class="input-small-mini" placeholder="%"></td>
        </tr>

        <tr id="trBeneficiario8" style="display:none;">
          <td><input id="txtParentescoBeneficiario8" name="txtParentescoBeneficiario8" type="text" class="input-medium" placeholder="PARENTESCO"></td>
          <td><input id="txtNombreBeneficiario8" name="txtNombreBeneficiario8" type="text"  class="input-xlarge" placeholder="NOMBRE COMPLETO BENEFICIARIO 8"></td>
          <!-- <td style="text-align: center;"><input type='checkbox' name='checkBeneficiario8' class='style3' id='checkBeneficiario8' readonly></td> -->
          <td style="text-align: center;"><input id="txtPorcentajeBeneficiario8" name="txtPorcentajeBeneficiario8" type="number" min="1" max="100" class="input-small-mini" placeholder="%"></td>
        </tr>

        <tr id="trBeneficiario9" style="display:none;">
          <td><input id="txtParentescoBeneficiario9" name="txtParentescoBeneficiario9" type="text" class="input-medium" placeholder="PARENTESCO"></td>
          <td><input id="txtNombreBeneficiario9" name="txtNombreBeneficiario9" type="text"  class="input-xlarge" placeholder="NOMBRE COMPLETO BENEFICIARIO 9"></td>
          <!-- <td style="text-align: center;"><input type='checkbox' name='checkBeneficiario9' class='style3' id='checkBeneficiario9' readonly></td> -->
          <td style="text-align: center;"><input id="txtPorcentajeBeneficiario9" name="txtPorcentajeBeneficiario9" type="number" min="1" max="100" class="input-small-mini" placeholder="%"></td>
        </tr>

        <tr id="trBeneficiario10" style="display:none;">
          <td><input id="txtParentescoBeneficiario10" name="txtParentescoBeneficiario10" type="text" class="input-medium" placeholder="PARENTESCO"></td>
          <td><input id="txtNombreBeneficiario10" name="txtNombreBeneficiario10" type="text"  class="input-xlarge" placeholder="NOMBRE COMPLETO BENEFICIARIO 10"></td>
          <!-- <td style="text-align: center;"><input type='checkbox' name='checkBeneficiario10' class='style3' id='checkBeneficiario10' readonly></td> -->
          <td style="text-align: center;"><input id="txtPorcentajeBeneficiario10" name="txtPorcentajeBeneficiario10" type="number" min="1" max="100" class="input-small-mini" placeholder="%"></td>
        </tr>
      </table>
      <br>
        <!-- <tr>
          <td colspan="3"><div id="divOtroBeneficiario"></div></td>
          <td ><div id="etiquedaBeneficiario"></div></td>
          <td><div id="datoBeneficiario" ></div></td>
        </tr> -->
          <!-- <button id="btnGuardarDatosFamiliares" name="btnGuardarDatosFamiliares" class="btn btn-primary" type="button" onclick="guardarDatosMadre(); guardarDatosOtroBeneficiario();  "> <span class="glyphicon glyphicon-floppy-save"></span>Guardar</button> -->
          <button id="btnGuardarDatosFamiliares" name="btnGuardarDatosFamiliares" class="btn btn-primary" type="button" onclick="guardarDatosBeneficiariosRegistro();"> <span class="glyphicon glyphicon-floppy-save"></span>Guardar</button>
  </div>

  <div align="center" class="tab-pane" id="containerFormatos" >



    <table>
      <tr>
        <!-- <td><button class="btn btn-large" type="button" onclick="generarCredencial();"> <img src="img/credencial2.png" >Credencial</button></td> -->
        <td><button class="btn btn-large" type="button" onclick="generadorNuevaCredencial();"> <img src="img/new.png">Credencial</button></td>
        <td><button class="btn btn-large" type="button" onclick="generarCartaPatronal();"> <img src="img/hojaDatos.png">Carta Patronal</button></td>
        <td><button class="btn btn-large" type="button" onclick="generarCartaPatronal2();"> <img src="img/hojaDatos.png">Carta Patronal 2</button></td>

      </tr>
      <tr>
        <td><button class="btn btn-large" type="button" onclick="generarContratoSa1(); generarContratoSa2(); generarContratoSc();"> <img src="img/contratos2.png">Contratos</button></td>
        <td><button class="btn btn-large" type="button" onclick="generarHojaDatos();"> <img src="img/hojaDatos1.png">Hoja de Datos</button></td>
        <td><button class="btn btn-large" type="button" onclick="generarDocumentoBanco();"> <img src="img/bank.png">Formato Banco</button></td>

      </tr>
         <tr>
        <td></td>
        <td><button class="btn btn-large" type="button" onclick="generadorFormatoDocumentosRecibidos(); generadorCartaResponsiva();"> <img src="img/checkDocumentos.png">Doc. Reci</button></td>


      </tr>

    </table>
  </div>





<?php //###Start_Section_DocumentosDigitalizados### ?>
<div align="center" class="tab-pane" id="containerDocumentosDigitalizados" >
    <legend><h3>Documentos Digitalizados</h3></legend>

    <table border="0" width="800px" class="table table-striped">
    <?php
$documentos = $negocio->negocio_traerListaDocumentos();

foreach ($documentos as $documento):
?>
    <tr>
    <td width="250px"><b>
    <?php echo $documento["nombreDocumento"]; ?>
    </b>
    <input type="file" id="documentoDigitalizado_<?php echo $documento["idDocumento"]; ?>" name="documentoDigitalizado" class="file-loading" />
    </td>
    <td><div id="icons_documentos_<?php echo $documento["idDocumento"]; ?>"></div></td>
    </tr>
    <?php endforeach;?>
    </table>
</div>
<?php //###End_Section_DocumentosDigitalizados### ?>






<div id="botonesExtras"></div>

</div> <!--TERMINA tab-content -->

<!-- Modal -->

<div id="myModal" class="modal_d hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">

      <div class="modal-header">

        <h4 class="modal-title" id="myModalLabel">Registro De Documentacion</h4>
      </div>
      <div class="modal-body-d">

      <div id="cajonleft">
       <label class="label-success"> Documentos Originales</label><br>

      <?php
for ($i = 0; $i < count($catalogoDocumentos); $i++) {
  if($i == 6 || $i == 8 || $i == 11){
       echo "<input type='checkbox' value='" . $catalogoDocumentos[$i]["idDocumento"] . "' id='checkOriginales" . $catalogoDocumentos[$i]["idDocumento"] . "' name='checkOriginales' class='style3' checked ><label class='control-label_d label-Doc' for='lbl'>" . $catalogoDocumentos[$i]["nombreDocumento"] . "</label><br>";
  }else{
      echo "<input type='checkbox' value='" . $catalogoDocumentos[$i]["idDocumento"] . "' id='checkOriginales" . $catalogoDocumentos[$i]["idDocumento"] . "' name='checkOriginales' class='style3' ><label class='control-label_d label-Doc' for='lbl'>" . $catalogoDocumentos[$i]["nombreDocumento"] . "</label><br>";
  }
}
?>
     </div>
     <div id="cajonrightModal">
      <label class="label-success">Documentos Copia</label><br>
 <?php          
for ($i = 0; $i < count($catalogoDocumentos); $i++) {
    if($i == 6 || $i == 8 || $i == 11){
      echo "<input type='checkbox' value='" . $catalogoDocumentos[$i]["idDocumento"] . "' id='checkCopia" . $catalogoDocumentos[$i]["idDocumento"] . "' name='checkCopia' class='style3' checked><label class='control-label_d label-Doc' for='lbl1'>" . $catalogoDocumentos[$i]["nombreDocumento"] . "</label><br>";
    }else{
    echo "<input type='checkbox' value='" . $catalogoDocumentos[$i]["idDocumento"] . "' id='checkCopia" . $catalogoDocumentos[$i]["idDocumento"] . "' name='checkCopia' class='style3' ><label class='control-label_d label-Doc' for='lbl1'>" . $catalogoDocumentos[$i]["nombreDocumento"] . "</label><br>";
}
}
?>
     </div>

      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-primary" onClick="registrarEntregaDocumentosOriginales(); registrarEntregaDocumentosCopias(); mostrarModalFirmaRegistro();" data-dismiss="modal">Save changes</button>
      </div>
    </div>

    <!-- Fin modalDocumentos -->

    <div class="modal fade" tabindex="-1" role="dialog" id='modalPlantillaNoDefinida' name='modalPlantillaNoDefinida' data-keyboard="false" data-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title">Error </h3>
      </div>
      <div class="modal-body" id='divMsg' nme='divMsg'>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="cerrarModalPlantillaNoDefinida();">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->




    <!-- modal firma -->
    <div id="modalFirmaR" name="modalFirmaR" class="modalFirma hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-header">
        <div id="divFirmaMsgR" name="divFirmaMsgR"></div>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Firma del elemento</h3>

      </div>
     <div class="modal-body" id="sketch_divR">
        <p>Dibuje firma del elemento…</p>
        <canvas id="tools_sketchR" class="divTrFirma" width="900" height="350" ><td></canvas>
      </div>
      <div class="modal-footer">

        <button type="button" id="btnLimpiar" name="btnLimpiar"class="btn btn-secundary" onclick="limpiarCanvasR();">Limpiar</button>

        <button type="button" class="btn btn-primary" onclick="saveImageR();">Guardar Firma</button>

      </div>
  </div>

    <!--  fin modal firma -->

</form>

</div>

<div class="modal fade" tabindex="-1" role="dialog" name="modalCurpInternoRegistro" id="modalCurpInternoRegistro" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><img src="img/warning.png" id="TituloCurpRegistro">ALERTA !!!!</h4>
      </div>
      <div class="modal-body">
        <p><strong id="MensajeCurpRegistro"></strong></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  

<div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalTarjetaDeDespensa" id="modalTarjetaDeDespensa" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
    
        <h4 class="modal-title"><img src="img/warning.png" id="TituloCurpRegistro">Es Correcto El Número De IUT a Entregar !!!</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <label class="control-label label" for="Iut">Número Iut</label>
          <input id="txtNumeroIutModal" name="txtNumeroIutModal" type="text" class="input-xlarge" readonly="true">
          <input id="idTarjetaDespensa" name="idTarjetaDespensa" type="hidden" class="input-xlarge" readonly="true">
          
          <label class="control-label label" for="ComentarioIut">Comentario Iut</label>
          <input id="txtComentarioIut" name="txtComentarioIut" type="text" class="input-xlarge">
        </div> <br>
        <h4> EN CASO DE QUE TENGA QUE CAMBIAR AL SIGUIENTE NÚMERO DE IUT ESPECIFIQUE EL MOTIVO EN EL COMENTARIO Y APLIQUE EN EL BOTON DE SIGUIENTE EN CASO CONTRARIO APLIQUE  ASIGNAR</h4>
        <h5> RECURDE QUE EL APLICAR EN SIGUIENTE EL NÚMERO DE IUT SE DARÁ DE BAJA Y NUNCA SE PODRÁ ASIGNAR</h5>
        <br>
        <center>
          <button type="button" class="btn btn-primary" onclick="CambiarModalesParaValidacionDeContrase();">Siguiente Iut</button>
        </center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="CambiarDeModalesIngresoEmpleado();">Asignar Iut</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  

<div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaElectronicaParaBajaTarjeta" id="modalFirmaElectronicaParaBajaTarjeta" data-backdrop="static">
            <div id="errorModalFirmaInternaParaBajaTarjeta"></div>
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h3 class="modal-title" align="center"><img src="img/alert.png">Escribe tu numero de empleado y la contraseña que generaste !!</h3>
                </div>
                <div class="modal-body" align="center">
                  <span class="add-on"># Empleado</span>
                  <input type="text" id="NumEmpModalFirmaParaBajaTarjeta" class="input-medium" name="NumEmpModalFirmaParaBajaTarjeta" placeholder="00-0000-00 Ó 00-00000-00">
                  <input type="hidden" id="NumEmpModalFirmaParaBajaTarjetahidden" class="input-medium" name="NumEmpModalFirmaParaBajaTarjetahidden">
                  <span class="add-on">Contraseña</span>
                  <input type="password" id="constraseniaFirmaParaBajaTarjeta" class="input-xlarge"name="constraseniaFirmaParaBajaTarjeta" title="El campo identifica entre mayusculas y minusculas favor de considerarlo">
                  <input type="hidden" id="constraseniaFirmaParaBajaTarjetaHidden" class="input-xlarge"name="constraseniaFirmaParaBajaTarjetaHidden">
                </div>
                <div class="modal-body" align="center">
                  <button type="button" id="btnFirmarBajaTarjeta" name="btnFirmarBajaTarjeta" onclick="RevisarFirmaInternaParaBajaTarjeta();" style="display: block;" class="btn btn-primary" >Firmar</button><br>
                  <button type="button" id="btnCancelarFirmaBajaTarjeta" name="btnCancelarFirmaBajaTarjeta"onclick="cancelarFirmaParaBajaTarjeta();" class="btn btn-danger" >Cancelar</button>
                </div>      
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaElectronicaParaRegistrarEmpleado" id="modalFirmaElectronicaParaRegistrarEmpleado" data-backdrop="static">
            <div id="errorModalFirmaInternaParaRegistrarEmpleado"></div>
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h3 class="modal-title" align="center"><img src="img/alert.png">Escribe tu numero de empleado y la contraseña que generaste !!</h3>
                </div>
                <div class="modal-body" align="center">
                  <span class="add-on"># Empleado</span>
                  <input type="text" id="NumEmpModalFirmaParaRegistrarEmpleado" class="input-medium" name="NumEmpModalFirmaParaRegistrarEmpleado" placeholder="00-0000-00 Ó 00-00000-00">
                  <span class="add-on">Contraseña</span>
                  <input type="password" id="constraseniaFirmaParaRegistrarEmpleado" class="input-xlarge"name="constraseniaFirmaParaRegistrarEmpleado" title="El campo identifica entre mayusculas y minusculas favor de considerarlo">
                </div>
                <div class="modal-body" align="center">
                  <button type="button" id="btnFirmarDoc" name="btnFirmarDoc" onclick="RevisarFirmaInternaParaRegistrarEmpleado();" style="display: block;" class="btn btn-primary" >Firmar</button><br>
                  <button type="button" id="btnCancelarFirma" name="btnCancelarFirma"onclick="cancelarFirmaParaEnvioDeTarjetaParaRegistrarEmpleado();" class="btn btn-danger" >Cancelar</button>
                </div>      
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

<div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaAltaEmpleado" id="modalFirmaAltaEmpleado" data-backdrop="static">
  <div id="errormodalFirmaAltaEmpleado"></div>
  <div class="modal-dialog" role="document">
    <div class="modal-content">  
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" align="center"><img src="img/alert.png">Escribe tu numero de empleado y la contraseña que generaste !!</h3>
      </div>
      <div class="modal-body" align="center">
        <span class="add-on"># Empleado</span>
        <input type="text" id="NumEmpModalFirmaParaFirmaAltaEmpleado" class="input-medium" name="NumEmpModalFirmaParaFirmaAltaEmpleado" placeholder="00-0000-00 Ó 00-00000-00">
        <input type="hidden" id="NumEmpModalFirmaParaFirmaAltaEmpleadohidden" class="input-medium" name="NumEmpModalFirmaParaFirmaAltaEmpleadohidden">
        <span class="add-on">Contraseña</span>
        <input type="password" id="constraseniaFirmaParaParaFirmaAltaEmpleado" class="input-xlarge"name="constraseniaFirmaParaParaFirmaAltaEmpleado" title="El campo identifica entre mayusculas y minusculas favor de considerarlo">
        <input type="hidden" id="constraseniaFirmaParaParaFirmaAltaEmpleadoHidden" class="input-xlarge"name="constraseniaFirmaParaParaFirmaAltaEmpleadoHidden">
      </div>
      <div class="modal-body" align="center">
        <button type="button" id="btnFirmarAltaEmpleado" name="btnFirmarAltaEmpleado" onclick="RevisarFirmaInternaParaAltaEmpleado();" style="display: block;" class="btn btn-primary" >Firmar</button><br>
        <button type="button" id="btnCancelarFirmaAltaEmpleado" name="btnCancelarFirmaAltaEmpleado"onclick="cancelarFirmaParaAltaEmpleado();" class="btn btn-danger" >Cancelar</button>
      </div>      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaConfirmacionSalarioDiario" id="modalFirmaConfirmacionSalarioDiario" data-backdrop="static">
  <div id="errormodalConfirmacionSalarioDiario"></div>
  <div class="modal-dialog" role="document">
    <div class="modal-content">  
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" align="center"><img src="img/alert.png">Escribe tu numero de empleado y la contraseña que generaste !!</h3>
      </div>
      <div class="modal-body" align="center">
        <span class="add-on"># Empleado</span>
        <input type="text" id="NumEmpModalFirmaParaConfirmacionSalarioDiario" class="input-medium" name="NumEmpModalFirmaParaConfirmacionSalarioDiario" placeholder="00-0000-00 Ó 00-00000-00">
        <input type="hidden" id="NumEmpModalFirmaParaConfirmacionSalarioDiariohidden" class="input-medium" name="NumEmpModalFirmaParaConfirmacionSalarioDiariohidden">
        <span class="add-on">Contraseña</span>
        <input type="password" id="constraseniaFirmaParaConfirmacionSalarioDiarioEmpleado" class="input-xlarge"name="constraseniaFirmaParaConfirmacionSalarioDiarioEmpleado" title="El campo identifica entre mayusculas y minusculas favor de considerarlo">
        <input type="hidden" id="constraseniaFirmaParaConfirmacionSalarioDiarioEmpleadoHidden" class="input-xlarge"name="constraseniaFirmaParaConfirmacionSalarioDiarioEmpleadoHidden">
      </div>
      <div class="modal-body" align="center">
        <button type="button" id="btnFirmarConfirmacionSalarioDiario" name="btnFirmarConfirmacionSalarioDiario" onclick="RevisarFirmaInternaParaConfirmacionSalarioDiario();" style="display: block;" class="btn btn-primary" >Firmar</button><br>
        <button type="button" id="btnCancelarFirmaConfirmacionSalarioDiario" name="btnCancelarFirmaConfirmacionSalarioDiario"onclick="cancelarFirmaParaConfirmacionSalarioDiario();" class="btn btn-danger" >Cancelar</button>
      </div>      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">

jQuery('.soloLetras').keypress(function (tecla) {
  if (tecla.charCode < 65 || tecla.charCode > 90) return false;
});

jQuery('.soloNumeros').keypress(function (tecla) {
  if (tecla.charCode < 48 || tecla.charCode > 57) return false;
});

jQuery('.soloAlfanumerico').keypress(function (tecla) {
  if (tecla.charCode < 48 || tecla.charCode > 90 ) return false;
});

jQuery('.sinEspacios').keypress(function (tecla) {
  if (tecla.charCode == 32) return false;
});

/*$('#checkPadre').click(function(){

  var conteoBenef=$("#conteoBeneficiarios").val();
  alert(conteoBenef);
  if($('#checkMadre').is(":checked")){
    conteoBenef=conteoBenef+1;
  }

  if (conteoBenef=='10'){
    alert("NO PUEDE SELECCIONAR MAS DE 10 BENEFICIARIOS 111111");
    $("#checkPadre").attr('checked', false);
  }
  alert(conteoBenef+"aa");
});

$('#checkMadre').click(function(){

  var conteoBenef=$("#conteoBeneficiarios").val();
  alert(conteoBenef);
  if($('#checkPadre').is(":checked")){
    conteoBenef=conteoBenef+1;
  }

  if (conteoBenef=='10'){
    alert("NO PUEDE SELECCIONAR MAS DE 10 BENEFICIARIOS 22222");
    $("#checkMadre").attr('checked', false);
  }
  alert(conteoBenef+"bb");
});*/


$('#agregarBeneficiario').click(function(){
  
  var conteoBenef=$("#conteoBeneficiarios").val();
  var conteoChecksBenef='0';  
  /*if($('#checkPadre').is(":checked")){
    conteoChecksBenef++;
  }
  if($('#checkMadre').is(":checked")){
    conteoChecksBenef++;         
  }*/

  var ParentescoBeneficiario1=$("#txtParentescoBeneficiario1").val();
  var NombreBeneficiario1=$("#txtNombreBeneficiario1").val();
  var PorcentajeBeneficiario1=$("#txtPorcentajeBeneficiario1").val();

  var ParentescoBeneficiario2=$("#txtParentescoBeneficiario2").val();
  var NombreBeneficiario2=$("#txtNombreBeneficiario2").val();
  var PorcentajeBeneficiario2=$("#txtPorcentajeBeneficiario2").val();

  var ParentescoBeneficiario3=$("#txtParentescoBeneficiario3").val();
  var NombreBeneficiario3=$("#txtNombreBeneficiario3").val();
  var PorcentajeBeneficiario3=$("#txtPorcentajeBeneficiario3").val();

  var ParentescoBeneficiario4=$("#txtParentescoBeneficiario4").val();
  var NombreBeneficiario4=$("#txtNombreBeneficiario4").val();
  var PorcentajeBeneficiario4=$("#txtPorcentajeBeneficiario4").val();

  var ParentescoBeneficiario5=$("#txtParentescoBeneficiario5").val();
  var NombreBeneficiario5=$("#txtNombreBeneficiario5").val();
  var PorcentajeBeneficiario5=$("#txtPorcentajeBeneficiario5").val();

  var ParentescoBeneficiario6=$("#txtParentescoBeneficiario6").val();
  var NombreBeneficiario6=$("#txtNombreBeneficiario6").val();
  var PorcentajeBeneficiario6=$("#txtPorcentajeBeneficiario6").val();

  var ParentescoBeneficiario7=$("#txtParentescoBeneficiario7").val();
  var NombreBeneficiario7=$("#txtNombreBeneficiario7").val();
  var PorcentajeBeneficiario7=$("#txtPorcentajeBeneficiario7").val();

  var ParentescoBeneficiario8=$("#txtParentescoBeneficiario8").val();
  var NombreBeneficiario8=$("#txtNombreBeneficiario8").val();
  var PorcentajeBeneficiario8=$("#txtPorcentajeBeneficiario8").val();

  var ParentescoBeneficiario9=$("#txtParentescoBeneficiario9").val();
  var NombreBeneficiario9=$("#txtNombreBeneficiario9").val();
  var PorcentajeBeneficiario9=$("#txtPorcentajeBeneficiario9").val();

  if(conteoBenef=="0"){
      // $("#checkBeneficiario1").prop("checked", true);
      $("#trBeneficiario1").show();
      $("#conteoBeneficiarios").val(1);
      $("#eliminarBeneficiario").show();
      $("#trTitulosBeneficiarios").show();
  }

  if(conteoBenef=="1" &&  ParentescoBeneficiario1!='' && NombreBeneficiario1!='' && PorcentajeBeneficiario1!='' && PorcentajeBeneficiario1>0 && PorcentajeBeneficiario1<100){
     $("#trBeneficiario2").show();
     $("#conteoBeneficiarios").val(2);
     // $("#checkBeneficiario2").prop("checked", true);
     $("#txtParentescoBeneficiario1").prop("disabled, true");
     $("#txtNombreBeneficiario1").prop("disabled, true");
     $("#txtPorcentajeBeneficiario1").prop("disabled, true");
  }else if(conteoBenef=="1" &&  (ParentescoBeneficiario1=='' || NombreBeneficiario1=='' || PorcentajeBeneficiario1=='' || PorcentajeBeneficiario1<=0 || PorcentajeBeneficiario1>100)){
    alert("INGRESE LOS DATOS COMPLETOS DEL BENEFICIARIO ANTERIOR PARA AGREGAR UNO NUEVO1");
  }

  if(conteoBenef=="2" && ParentescoBeneficiario2!='' && NombreBeneficiario2 !='' && PorcentajeBeneficiario2!='' && PorcentajeBeneficiario2>0 && PorcentajeBeneficiario2<100){
     $("#trBeneficiario3").show();
     $("#conteoBeneficiarios").val(3);
      // $("#checkBeneficiario3").prop("checked", true);
  }else if(conteoBenef=="2" && (ParentescoBeneficiario2=='' || NombreBeneficiario2 =='' || PorcentajeBeneficiario2=='' || PorcentajeBeneficiario2<=0 || PorcentajeBeneficiario2>100)){
    alert("INGRESE LOS DATOS COMPLETOS DEL BENEFICIARIO ANTERIOR PARA AGREGAR UNO NUEVO2");
  }
  if(conteoBenef=="3" && ParentescoBeneficiario3!='' && NombreBeneficiario3 !='' && PorcentajeBeneficiario3!='' && PorcentajeBeneficiario3>0 && PorcentajeBeneficiario3<100){
     $("#trBeneficiario4").show();
     $("#conteoBeneficiarios").val(4);
      // $("#checkBeneficiario4").prop("checked", true);
  }else if(conteoBenef=="3" && (ParentescoBeneficiario3=='' || NombreBeneficiario3 =='' || PorcentajeBeneficiario3=='' || PorcentajeBeneficiario3<=0 || PorcentajeBeneficiario3>100)){
    alert("INGRESE LOS DATOS COMPLETOS DEL BENEFICIARIO ANTERIOR PARA AGREGAR UNO NUEVO3");
  }
  if(conteoBenef=="4" && ParentescoBeneficiario4!='' && NombreBeneficiario4 !='' && PorcentajeBeneficiario4!='' && PorcentajeBeneficiario4>0 && PorcentajeBeneficiario4<100){
     $("#trBeneficiario5").show();
     $("#conteoBeneficiarios").val(5);
      // $("#checkBeneficiario5").prop("checked", true);
  }else if(conteoBenef=="4" && (ParentescoBeneficiario4=='' || NombreBeneficiario4 =='' || PorcentajeBeneficiario4=='' || PorcentajeBeneficiario4<=0 || PorcentajeBeneficiario4>100)){
    alert("INGRESE LOS DATOS COMPLETOS DEL BENEFICIARIO ANTERIOR PARA AGREGAR UNO NUEVO4");
  }
  if(conteoBenef=="5" && ParentescoBeneficiario5!='' && NombreBeneficiario5 !='' && PorcentajeBeneficiario5!='' && PorcentajeBeneficiario5>0 && PorcentajeBeneficiario5<100){
     $("#trBeneficiario6").show();
     $("#conteoBeneficiarios").val(6);
      // $("#checkBeneficiario6").prop("checked", true);
  }else if(conteoBenef=="5" && (ParentescoBeneficiario5=='' || NombreBeneficiario5 =='' || PorcentajeBeneficiario5=='' || PorcentajeBeneficiario5<=0 || PorcentajeBeneficiario5>100)){
    alert("INGRESE LOS DATOS COMPLETOS DEL BENEFICIARIO ANTERIOR PARA AGREGAR UNO NUEVO5");
  }
  if(conteoBenef=="6" && ParentescoBeneficiario6!='' && NombreBeneficiario6 !='' && PorcentajeBeneficiario6!='' && PorcentajeBeneficiario6>0 && PorcentajeBeneficiario6<100){
     $("#trBeneficiario7").show();
     $("#conteoBeneficiarios").val(7);
      // $("#checkBeneficiario7").prop("checked", true);
  }else if(conteoBenef=="6" && (ParentescoBeneficiario6=='' || NombreBeneficiario6 =='' || PorcentajeBeneficiario6=='' || PorcentajeBeneficiario6<=0 || PorcentajeBeneficiario6>100)){
    alert("INGRESE LOS DATOS COMPLETOS DEL BENEFICIARIO ANTERIOR PARA AGREGAR UNO NUEVO6");
  }
  if(conteoBenef=="7" && ParentescoBeneficiario7!='' && NombreBeneficiario7 !='' && PorcentajeBeneficiario7!='' && PorcentajeBeneficiario7>0 && PorcentajeBeneficiario7<100){
     $("#trBeneficiario8").show();
     $("#conteoBeneficiarios").val(8);
      // $("#checkBeneficiario8").prop("checked", true);
  }else if(conteoBenef=="7" && (ParentescoBeneficiario7=='' || NombreBeneficiario7 =='' || PorcentajeBeneficiario7=='' || PorcentajeBeneficiario7<=0 || PorcentajeBeneficiario7>100)){
    alert("INGRESE LOS DATOS COMPLETOS DEL BENEFICIARIO ANTERIOR PARA AGREGAR UNO NUEVO7");
  }

  if(conteoBenef=="8" && ParentescoBeneficiario8!='' && NombreBeneficiario8 !='' && PorcentajeBeneficiario8!='' && PorcentajeBeneficiario8>0 && PorcentajeBeneficiario8<100){
      if(conteoChecksBenef==2){
        alert("NO PUEDE TENER MAS DE 10 BENEFICIARIOS");
      }else{
         $("#trBeneficiario9").show();
         $("#conteoBeneficiarios").val(9);
      // $("#checkBeneficiario9").prop("checked", true);
      }
  }else if(conteoBenef=="8" && (ParentescoBeneficiario8=='' || NombreBeneficiario8 =='' || PorcentajeBeneficiario8=='' || PorcentajeBeneficiario8<=0 || PorcentajeBeneficiario8>100)){
    alert("INGRESE LOS DATOS COMPLETOS DEL BENEFICIARIO ANTERIOR PARA AGREGAR UNO NUEVO8");

  }
  if(conteoBenef=="9" && ParentescoBeneficiario9!='' && NombreBeneficiario9 !='' && PorcentajeBeneficiario9!='' && PorcentajeBeneficiario9>0 && PorcentajeBeneficiario9<100){
      if(conteoChecksBenef==1){
        alert("NO PUEDE TENER MAS DE 10 BENEFICIARIOS");
      }else {
            $("#trBeneficiario10").show();
            $("#conteoBeneficiarios").val(10);
            // $("#checkBeneficiario10").prop("checked", true);
            $("#agregarBeneficiario").hide();
      }
  }else if(conteoBenef=="9" && (ParentescoBeneficiario9=='' || NombreBeneficiario9 =='' || PorcentajeBeneficiario9=='' || PorcentajeBeneficiario9<=0 || PorcentajeBeneficiario9>100)){
    alert("INGRESE LOS DATOS COMPLETOS DEL BENEFICIARIO ANTERIOR PARA AGREGAR UNO NUEVO9");
    
  }
});

$('#eliminarBeneficiario').click(function() {
    var conteoBenef = $("#conteoBeneficiarios").val();

    if(conteoBenef=="10"){
       $("#trBeneficiario10").hide();
       $("#trBeneficiario10").val("");
       $("#conteoBeneficiarios").val(9);
       $("#agregarBeneficiario").show();
    }if(conteoBenef=="9"){
       $("#trBeneficiario9").hide();
       $("#trBeneficiario9").val("");
       $("#conteoBeneficiarios").val(8);
    }if(conteoBenef=="8"){
       $("#trBeneficiario8").hide();
       $("#trBeneficiario8").val("");
       $("#conteoBeneficiarios").val(7);
    }if(conteoBenef=="7"){
       $("#trBeneficiario7").hide();
       $("#trBeneficiario7").val("");
       $("#conteoBeneficiarios").val(6);
    }if(conteoBenef=="6"){
       $("#trBeneficiario6").hide();
       $("#trBeneficiario6").val("");
       $("#conteoBeneficiarios").val(5);
    }if(conteoBenef=="5"){
       $("#trBeneficiario5").hide();
       $("#trBeneficiario5").val("");
       $("#conteoBeneficiarios").val(4);
    }if(conteoBenef=="4"){
       $("#trBeneficiario4").hide();
       $("#trBeneficiario4").val("");
       $("#conteoBeneficiarios").val(3);
    }if(conteoBenef=="3"){
       $("#trBeneficiario3").hide();
       $("#trBeneficiario3").val("");
       $("#conteoBeneficiarios").val(2);
    }if(conteoBenef=="2"){
       $("#trBeneficiario2").hide();
       $("#trBeneficiario2").val("");
       $("#conteoBeneficiarios").val(1);
    }if(conteoBenef=="1"){
       $("#trBeneficiario1").hide();
       $("#trBeneficiario1").val("");
       $("#conteoBeneficiarios").val(0);
       $("#eliminarBeneficiario").hide();
       $("#trTitulosBeneficiarios").hide();
    }
});


function guardarDatosBeneficiariosRegistro(){

  var datastring = $("#form_registrarEmpleado").serialize();
  var conteoBenef = $("#conteoBeneficiarios").val();
  // for(var i = 1; i <= conteoBenef; i++) {

  //     var parentescoB=$("#txtParentescoBeneficiario"+i).val();
  //     var nombreB=$("#txtNombreBeneficiario"+i).val();
  //     var porcentajeB=$("#txtPorcentajeBeneficiario"+i).val();

  //     datastring += "&parentescoB"+i+"=" + parentescoB;
  //     datastring += "&nombreB"+i+"=" + nombreB;
  // }
        datastring += "&conteoBenef=" + conteoBenef;

        $.ajax({
            type: "POST",
            url: "ajax_registroDatosFamiliares.php",
            data: datastring,
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;

                if (response.status=="success") {

                  datosGuardadosBeneficiario=1;

                    alertMsg1="<div id='msgAlert' class='alert alert-success'>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                     $("#alertMsg").html(alertMsg1);
                     $(document).scrollTop(0);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                    $( "#txtOtroBeneficiario" ).prop( "disabled", true );
                    $( "#selectOtroBeneficiario" ).prop( "disabled", true );
                    bloquearElementosDatosFamiliares();
                } else if (response.status=="error")
                {
                  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error en el registro de datos familiares:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#alertMsg").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                }
              },
            error: function(){
                  alert('error handing here guardarDatosOtroBeneficiario');
            }
        });
          bloquearElementosDatosFamiliares();//estaba en el else
}

var cambioFolio=0;

function registrarEntregaDocumentosOriginales(){

  var idEstatusDocumentos=0;
  var empleadoEntidad = $("#numeroEmpleadoEntidad").val();
  var empleadoConsecutivo = $("#numeroEmpleadoConsecutivo").val();
  var empleadoCategoria = $("#numeroEmpleadoTipo").val();  
  var tipoDocumento = 1;
  var documentoId=0;
  var idEstatusDocumentos=0;

  <?php
    if (isset($catalogoDocumentos)) {
      for ($i = 1; $i <= count($catalogoDocumentos); $i++) {
  ?>

        if($("#checkOriginales<?php echo $i; ?>").is(':checked')) {
            documentoId= $("#checkOriginales<?php echo $i; ?>").val() ;
            idEstatusDocumentos=1;

            $.ajax({
            type: "POST",
            url: "ajax_registrarDocumentacion.php",
            data: {"numeroEmpleadoEntidad":empleadoEntidad, "numeroEmpleadoConsecutivo":empleadoConsecutivo, "numeroEmpleadoTipo":empleadoCategoria, documentoId:documentoId, tipoDocumento:tipoDocumento, "idEstatusDocumentos":idEstatusDocumentos},
            dataType: "json",
            error: function(){
                  alert('error handing here registrarEntregaDocumentosOriginales');
            }
        });
        } else {
            //alert("No está activado");
        }
       <?php
} // for
} // if
?>
}

function registrarEntregaDocumentosCopias(){

  var idEstatusDocumentos=0;
  var empleadoEntidad = $("#numeroEmpleadoEntidad").val();
  var empleadoConsecutivo = $("#numeroEmpleadoConsecutivo").val();
  var empleadoCategoria = $("#numeroEmpleadoTipo").val();
  var tipoDocumento = 2;
  var documentoId=0;
  var idEstatusDocumentos=0;

    <?php
if (isset($catalogoDocumentos)) {
    for ($i = 1; $i <= count($catalogoDocumentos); $i++) {
        ?>

        if($("#checkCopia<?php echo $i; ?>").is(':checked')) {
            documentoId= $("#checkCopia<?php echo $i; ?>").val() ;
            idEstatusDocumentos=1;

            $.ajax({
            type: "POST",
            url: "ajax_registrarDocumentacion.php",
            data: {"numeroEmpleadoEntidad":empleadoEntidad, "numeroEmpleadoConsecutivo":empleadoConsecutivo, "numeroEmpleadoTipo":empleadoCategoria, documentoId:documentoId, tipoDocumento:tipoDocumento, "idEstatusDocumentos":idEstatusDocumentos},
            dataType: "json",
            error: function(){
                  alert('error handing here registrarEntregaDocumentosCopias');
            }
        });
        } else {
           // alert("No está activado");
        }
        <?php
} // for
} // if
?>
}

var currentDate = $.datepicker.formatDate('yy-mm-dd', new Date());

function guardarSubmit (){
  var banderafolio=$("#inpbanderafoliopreseleccion").val();
  var ContraseniaAltEmp= $("#constraseniaFirmaParaParaFirmaAltaEmpleadoHidden").val();
  var NumeroAltEmp = $("#NumEmpModalFirmaParaFirmaAltaEmpleadohidden").val();

  var txtContactoGif = $("#txtContactoGif").val();
  var txtCorreoGif = $("#txtCorreoGif").val();

  if(banderafolio==0){
    alertmmsssgg="<div id='msgAlert' class='alert alert-danger'><strong>Verifique Folio Preseleción</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#alertMsg").html(alertmmsssgg);
    $(document).scrollTop(0);
    $('#msgAlert').delay(3000).fadeOut('slow');
  }else if (ContraseniaAltEmp == "" || NumeroAltEmp == ""){
    alertmmsssgg="<div id='msgAlert' class='alert alert-danger'><strong>Ingrese La Firma Del Administrativo Que Dará De Alta Al Empleado (Presione El Boton 'Abrir Firma Alta Empleado')</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#alertMsg").html(alertmmsssgg);
    $(document).scrollTop(0);
    $('#msgAlert').delay(3000).fadeOut('slow');
  }else{
    var datastring = $("#form_registrarEmpleado").serialize();
    var avisoInscripcion0= $("#docdigitalizadoo0").val();    
    var avisoInscripcion1= $("#docdigitalizadoo1").val();   
    var avisoInscripcion2= $("#docdigitalizadoo2").val();
    var avisoInscripcion3= $("#docdigitalizadoo3").val();
    var horarioAlta = $("#selHorarioAlta").val();
    var ContraseniaAltEmpleado= $("#constraseniaFirmaParaParaFirmaAltaEmpleadoHidden").val();
    var NumeroAltEmpleado= $("#NumEmpModalFirmaParaFirmaAltaEmpleadohidden").val();
    var OpcionTarjetaDeDespensa = "0";
    if($('#TarjetaDespensaSi').is(":checked")){
      var OpcionTarjetaDeDespensa = "1";         
    }
    if($('#TarjetaDespensaNo').is(":checked")){
      var OpcionTarjetaDeDespensa = "2";         
    }
    var folio=$('#txtBuscarPreseleccion').val();
    datastring += "&folioConsulta=" + folio;
    datastring += "&docdigitalizadoo0=" + avisoInscripcion0;
    datastring += "&docdigitalizadoo1=" + avisoInscripcion1;
    datastring += "&docdigitalizadoo2=" + avisoInscripcion2;
    datastring += "&docdigitalizadoo3=" + avisoInscripcion3;
    datastring += "&ContraseniaAltEmpleado=" + ContraseniaAltEmpleado;
    datastring += "&NumeroAltEmpleado=" + NumeroAltEmpleado;
    datastring += "&OpcionTarjetaDeDespensa=" + OpcionTarjetaDeDespensa;
    datastring += "&horarioAlta=" + horarioAlta;
    var IdRolOperativoPlantilla = $("#idRolOpertaivoPorPlantillaAlta").val();
    var apellidoPaternoEmpleado = $("#apellidoPaternoEmpleado").val();
    var apellidoMaternoEmpleado = $("#apellidoMaternoEmpleado").val();
    var nombreEmpleado = $("#nombreEmpleado").val();
    var apellidoPaternoEmpleado1 = $.trim(apellidoPaternoEmpleado);
    var apellidoMaternoEmpleado1 = $.trim(apellidoMaternoEmpleado);
    var nombreEmpleado1 = $.trim(nombreEmpleado);
    $("#apellidoPaternoEmpleado").val(apellidoPaternoEmpleado1);
    $("#apellidoMaternoEmpleado").val(apellidoMaternoEmpleado1);
    $("#nombreEmpleado").val(nombreEmpleado1);
    var constraseniaValidacion = $("#constraseniaFirmaParaConfirmacionSalarioDiarioEmpleadoHidden").val();
    var numeroAdminValidacion = $("#NumEmpModalFirmaParaConfirmacionSalarioDiariohidden").val();
    var tipoPuestoBandera = $("#tipoPuesto").val();

    var txtClaveINET1 = $("#txtClaveINET1").val();
    var txtClaveINET2 = $("#txtClaveINET2").val();
    var eFClaveINE = $("#IdEFClaveINERE").val();
    var generoClaveINE= $("#IdGeneroClaveINERE").val();
    var txtClaveINET3 = $("#txtClaveINET3").val();
    var gerenteReg = $("#gerenteReg").val();

    var selLineaNegocio = $("#selectLineaNegocio").val();

    if(txtClaveINET1!="" || txtClaveINET2!="" || txtClaveINET3!=""){
      if(txtClaveINET1.length!=6){
        alertMsg1="<div id='msgAlert' class='alert alert-error'>ESCRIBA LAS PRIMERAS 6 LETRAS DE LA CLAVE INE<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
        $("#alertMsg").html(alertMsg1);
        $(document).scrollTop(0);
        $('#msgAlert').delay(3000).fadeOut('slow');
        return;
      }

      if(txtClaveINET2.length!=6){
        alertMsg1="<div id='msgAlert' class='alert alert-error'>ESCRIBA LOS PRIMEROS 6 NUMEROS DE LA CLAVE INE<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
        $("#alertMsg").html(alertMsg1);
        $(document).scrollTop(0);
        $('#msgAlert').delay(3000).fadeOut('slow');
        return;
      }

      if(eFClaveINE==0){
        alertMsg1="<div id='msgAlert' class='alert alert-error'>SELECCIONE LA ENTIDAD FEDERATIVA DE LA CLAVE INE<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
        $("#alertMsg").html(alertMsg1);
        $(document).scrollTop(0);
        $('#msgAlert').delay(3000).fadeOut('slow');
        return;
      }

      if(txtClaveINET3.length!=3){
        alertMsg1="<div id='msgAlert' class='alert alert-error'>ESCRIBA LOS 3 ULTIMOS NUMEROS DE LA CLAVE INE<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
        $("#alertMsg").html(alertMsg1);
        $(document).scrollTop(0);
        $('#msgAlert').delay(3000).fadeOut('slow');
        return;
      }
    }

    if(txtClaveINET1=='' || txtClaveINET2=='' || eFClaveINE=='0' || txtClaveINET3==''){
          var claveINECompleta='';
    }else{
          var claveINECompleta=txtClaveINET1+txtClaveINET2+eFClaveINE+generoClaveINE+txtClaveINET3;
    }
    var selplantillaserviciorei=$("#selplantillaservicio").val();
    var combo = document.getElementById("selplantillaservicio");
    if(selplantillaserviciorei =="0" || selplantillaserviciorei=="null" || selplantillaserviciorei== null){
      swal("Alto", "Seleccione La Plantilla Para Continuar","error");
    }else{
      var plantillaText1 = combo.options[combo.selectedIndex].text;
      var plantillaText2  = plantillaText1.split("_");
      var plantillaservicioreingresoText    = plantillaText2[0];
      var plantillaservicioingreso= plantillaText2[1];
    datastring += "&claveINE=" + claveINECompleta;
    datastring += "&plantillaservicioingreso=" + plantillaservicioingreso;

    datastring += "&txtContactoGifR=" + txtContactoGif;
    datastring += "&txtCorreoGifR=" + txtCorreoGif;
    datastring += "&gerenteRegSup=" + gerenteReg;

    if((constraseniaValidacion == "" || numeroAdminValidacion == "") && tipoPuestoBandera == "03" && selLineaNegocio=="1"){
      swal("Alto", "Confima EL Salario Diario Del Empleado Para Continuar","error"); 
    }else{
      $.ajax({
        type: "POST",
        url: "ajax_registrarEmpleado.php",
        data: datastring,
        dataType: "json",
        success: function(response) {
          var mensaje=response.message;
          if (response.status=="success") {   
            //var cuota = response.datos;       
            var numeroVisitante = $("#numeroVisitante").val();
            $("#NumeroEmpleadoModa").val($("#numeroEmpleadoEntidad").val()+"-"+$("#numeroEmpleadoConsecutivo").val()+"-"+$("#numeroEmpleadoTipo").val());
            insertarDatosImssAuto();
            alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Datos Gegerales</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#alertMsg").html(alertMsg1);
            $(document).scrollTop(0);
            $('#msgAlert').delay(3000).fadeOut('slow');
            if(cambioFolio==1){
              actualizaDatosGeneralesPreseleccion(datastring);
            }
            GuardarMovimientoPlantillaHistoricoIngreso("INGRESO");
            enviarPdfreingressoo();
            $( "#numeroEmpleado" ).prop( "disabled", true );
            $( "#apellidoPaternoEmpleado" ).prop( "disabled", true );
            $( "#apellidoMaternoEmpleado" ).prop( "disabled", true );
            $( "#nombreEmpleado" ).prop( "disabled", true );
            $( "#fechaIngreso" ).prop( "disabled", true );
            $( "#numeroSS" ).prop( "disabled", true );
            $( "#numeroCta" ).prop( "disabled", true );
            $( "#tipoPuesto" ).prop( "disabled", true );
            $( "#puesto" ).prop( "disabled", true );
            $( "#guardar" ).prop( "disabled", true );
            $( "#idEndidadFederativa").prop("disabled",true);
            $( "#idSucursalIngreso").prop("disabled",true);
            $( "#dirigente2").prop("disabled",true);
            $( "#dirigente").prop("disabled",true);
            $( "#numeroSeguroSocial").prop("disabled",true);
            $( "#selectPuntoServicio").prop("disabled",true);
            $( "#tipoTurno").prop("disabled",true);
            $( "#sexo").prop("disabled",true);
            $( "#oficio").prop("disabled",true);
            $( "#tipoSangre").prop("disabled",true);
            $( "#txtNumeroCta").prop("disabled",true);
            $( "#txtCtaClabe").prop("disabled",true);
            $( "#selectEndidadFederativaLabor").prop("disabled",true);
            $( "#selectLineaNegocio").prop("disabled",true);
            $("input[name=periodo]").attr('disabled', true);
            $( "#selectReclutador" ).prop( "disabled", true );
            $( "#selectMedioInformacion" ).prop( "disabled", true );
            $( "#txtClaveINET1").prop( "disabled", true );
            $( "#txtClaveINET2").prop( "disabled", true );
            $( "#IdEFClaveINERE").prop( "disabled", true );
            $( "#IdGeneroClaveINERE").prop( "disabled", true );
            $( "#txtClaveINET3").prop( "disabled", true );

            $( "#txtContactoGif").prop( "disabled", true );
            $( "#txtCorreoGif").prop( "disabled", true );

            $( "#1").prop("disabled",true);
            $( "#2").prop("disabled",true);
            var elemento = document.getElementById("spanDatosGenerales");
            elemento.className = "glyphicon glyphicon-ok";
            GuardarHistoricoMovimientosSalarioDiarioImss(plantillaservicioingreso);
            $('#myModal').modal(); 
          }else if (response.status=="error")
          {
            alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error en el registro de Datos Generales:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#alertMsg").html(alertMsg1);
            $(document).scrollTop(0);
            $('#msgAlert').delay(3000).fadeOut('slow');
          }
        },error: function(jqXHR, textStatus, errorThrown)
        {
          alert(jqXHR.responseText);
        }
      });
    }
   }
  }
}

function GuardarHistoricoMovimientosSalarioDiarioImss(idPlantilla){
  var sueldo = $("#SueldoSalarioDiarioEmp").val();
  var salarioDiari = $("#SalarioDiarioEmp").val();
  var constrasenia = $("#constraseniaFirmaParaConfirmacionSalarioDiarioEmpleadoHidden").val();
  var numeroAdmin = $("#NumEmpModalFirmaParaConfirmacionSalarioDiariohidden").val();
  var numeroEmpleadoEntidad = $("#numeroEmpleadoEntidad").val();
  var numeroEmpleadoConsecutivo = $("#numeroEmpleadoConsecutivo").val();
  var numeroEmpleadoTipo = $("#numeroEmpleadoTipo").val();
  var numeroEmpleado = numeroEmpleadoEntidad+"-"+numeroEmpleadoConsecutivo+"-"+numeroEmpleadoTipo;
  var origen = "Registro";
  $.ajax({
    type: "POST",
    url: "ajax_RegistrarHistoricoMovSDImss.php",
    data: {"sueldo":sueldo,"salarioDiari":salarioDiari,"constrasenia":constrasenia,"numeroAdmin":numeroAdmin,"numeroEmpleado":numeroEmpleado,"origen":origen,"idPlantilla":idPlantilla},
    dataType: "json",
    success: function(response) {
      if (response.status != "success")
      {
        alert(response.message);
      }
    },error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
  });
}

function documentoschecados(){
  $("#checkOriginales7").prop("checked","checked");
  $("#checkOriginales9").attr("checked","checked");
  $("#checkOriginales12").prop("checked",true);
  $("#checkCopia7").prop("checked",true);
  $("#checkCopia9").prop("checked",true);
  $("#checkCopia12").prop("checked",true);
}

function enviarPdfreingressoo() {
  
  var formData = new FormData($("#form_registrarEmpleado")[0]);
  
  for (var value of formData.values()) {}
  $.ajax({
      type: "POST",
      url: "uploadarchivosingresoelemento.php",
      data: formData,
      dataType: "json",
      cache: false,
      contentType: false,
      processData: false,
      async:false,
      success: function(response) {
        var mensaje = response.message;
      },
      error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
      }
  });
}

function insertarDatosImssAuto(){
  var numeroEmpleadoEntidad=$("#numeroEmpleadoEntidad").val();
  var numeroEmpleadoConsecutivo=$("#numeroEmpleadoConsecutivo").val();
  var numeroEmpleadoTipo=$("#numeroEmpleadoTipo").val();
  var fechaImss=$("#fechaIngreso").val();
  var tipoTrabajador=1;
  // var registroPatronal='Y6055712100';
  var registroPatronal=consulraRegistroPatronal();
  var empleadoEstatusImss=1;
  var Origen=1; // se utiliza el orien ya que siempre sera 1 y el estatus del txt de alta es 1 var movimientoTXT = '1';
  var selectLineaNegocioImss=$("#selectLineaNegocio").val();
  var tipoPuestoImss=$("#tipoPuesto").val();
  if(selectLineaNegocioImss == "1" && tipoPuestoImss == "03"){
    var salarioDiario=$("#SalarioDiarioEmp").val();
  }else{
    $.ajax({
      type: "POST",
      url: "ajax_obtenerTabuladoActual.php",
      dataType: "json",
      async:false,
      success: function(response) {
        if (response.status == "success")
        {
          var salarioDiario2 = response.datos1[0].SalarioDiarioDescuento;
          $("#SalarioDiarioEmpImss").val(salarioDiario2);
        }
      },error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
    var salarioDiario = $("#SalarioDiarioEmpImss").val();
  }
  var idTxtImss='1';
  $.ajax({
    type: "POST",
    url: "ajax_registroDatosImss.php",
    data: {"empladoEntidadImss":numeroEmpleadoEntidad, "empleadoConsecutivoImss":numeroEmpleadoConsecutivo, "empleadoCategoriaImss":numeroEmpleadoTipo,"fechaImss":fechaImss, "salarioDiario":salarioDiario, "registroPatronal":registroPatronal, "tipoTrabajador":tipoTrabajador, "empleadoEstatusImss":empleadoEstatusImss, "Origen":Origen,"idTxtImss":idTxtImss},
    dataType: "json",
    async:false,
    success: function(response) {
      var mensaje=response.message;
      if (response.status=="success") {
        alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Datos Imss</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
        $("#alertMsg").html(alertMsg1);
        $(document).scrollTop(0);
        $('#msgAlert').delay(3000).fadeOut('slow');
      } else if (response.status=="error")
      {
        alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error en confirmación de alta Imss:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
        $("#alertMsg").html(alertMsg1);
        $(document).scrollTop(0);
        $('#msgAlert').delay(3000).fadeOut('slow');
      }
    },error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
  });
}

// ********************

function consulraRegistroPatronal(){

  var puntoServicio = $("#selectPuntoServicio").val();
  var registroPatronal = "";

    $.ajax({
      type: "POST",
      url: "ajax_consultarRPxPS.php",
      data: {"puntoServicio": puntoServicio},
      dataType: "json",
      async:false,
      success: function(response) {
        if(response.status == "success"){
          var datos = response.datos;
          registroPatronal = datos[0].IdRegistroPatronal;
        }
      },error: function(jqXHR, textStatus, errorThrown){
         alert(jqXHR.responseText);
      }
    });
    return registroPatronal;
}

// **************** Departementos Ingreso *******************************************//

function seleccionarDepartamentoIngreso(){

  var lineaNegocio = $("#selectLineaNegocio").val();
  var tipoPuesto = $("#tipoPuesto").val();
  if(lineaNegocio !="LiNEA NEGOCIO" && lineaNegocio !="" && lineaNegocio !="0" && tipoPuesto !="TIPO PUESTO" && tipoPuesto !="" && tipoPuesto !="0"){
    if(tipoPuesto =="02"){
      $.ajax({
        type: "POST",
        url: "ajax_seleccionarDepartamento.php",
        data: {"tipoPuesto": tipoPuesto, "lineaNegocio":lineaNegocio},
        dataType: "json",
        async:false,
        success: function(response) {
          if (response.status == "success")
          {
            var deptos = response.datos;
            DeptosArray = "<option  value='0'>DEPARTAMENTOS</option>";
            for (var i = 0; i < deptos.length; i++)
            {
              DeptosArray += "<option value='" + deptos[i].idDepartamentoOrg + "'";
              DeptosArray += ">" + deptos[i].descripcionDepartamento + "</option>";
            }
            $("#trDeptoIngreso").show();
            $("#DeptoIngreso").html (DeptosArray);
            $("#puesto").empty();
          }
        },error: function(jqXHR, textStatus, errorThrown){
           alert(jqXHR.responseText);
        }
      });
    }else{
      $("#trDeptoIngreso").hide();
      $("#DeptoIngreso").empty();
      seleccionarTipoPuesto();
    }
  }else{
    $("#puesto").empty();
    $("#DeptoIngreso").empty();
  }
}
$("#DeptoIngreso").change(function(){
  var idDepartamentoPuesto = $("#DeptoIngreso").val();
  if(idDepartamentoPuesto!="0"){
     seleccionarTipoPuesto();
  }
});

function seleccionarTipoPuesto()
{
  var mitexto = $("#tipoPuesto option:selected").text();
  var valorTipo = $("#tipoPuesto").val();
  var lineaNegocio = $("#selectLineaNegocio").val();
  var idDepartamentoPuesto = $("#DeptoIngreso").val();
  if(valorTipo=="02" || lineaNegocio !="1"){
     $("#imgMalSalarioDiario").hide();
     $("#imgBienSalarioDiario").show();
     $("#btnConfirmadoSalarioDiario").show();
     $("#btnConfirmarSalarioDiario").hide();
     $("#btnGenrarSalarioDiario").hide();
  }else{
     $("#imgMalSalarioDiario").show();
     $("#imgBienSalarioDiario").hide();
     $("#btnConfirmadoSalarioDiario").hide();
     $("#btnConfirmarSalarioDiario").hide();
     $("#btnGenrarSalarioDiario").show();
  }
  $("#selplantillaservicio").empty();
  $("#tipoTurno").val("TURNO");
  //$("#numeroEmpleadoTipo").val(valorTipo);

  if(valorTipo=="02"){
    $.ajax({
      type: "POST",
      url: "ajax_seleccionarPuestoPorDepartamento.php",
      data: {"idDepartamentoPuesto": idDepartamentoPuesto},
      dataType: "json",
      async:false,
       success: function(response) {
        if (response.status == "success")
        {
          var datos = response.datos;
          puestosOptions = "<option>PUESTO</option>";
          for (var i = 0; i < datos.length; i++)
          {
            puestosOptions += "<option value='" + datos[i].idPuesto + "'";
            puestosOptions += ">" + datos[i].descripcionPuesto + "</option>";
          }
            $("#puesto").html (puestosOptions);
        }
      },error: function(jqXHR, textStatus, errorThrown){
         alert(jqXHR.responseText);
      }
    });
  }else{
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
          $("#puesto").html (puestosOptions);
        }
      },error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }
}

// ******************* Termina Departamentos Ingreso ***************************//////////
    function obtenerPosiblesJefesPorPuesto()
    {

       var mitexto = $("#puesto option:selected").text();
       var puestoId = $("#puesto").val();

      $.ajax({
            type: "POST",
            url: "ajax_obtenerPosiblesJefesPorPuesto.php",
            data: {"puestoId": puestoId},
            dataType: "json",
            success: function(response) {
                if (response.status == "success"){
                    var posiblesJefes = response.posiblesJefes;
                    posiblesJefesOptions = "<option>JEFE</option>";
                    for (var i = 0; i < posiblesJefes.length; i++){
                        posiblesJefesOptions += "<option value='" + posiblesJefes[i].numeroEmpleado + "'>" + posiblesJefes[i].nombre + "</option>";
                    }
                    $("#dirigente").html (posiblesJefesOptions);
                  //  $("#dirigente2").html (posiblesJefesOptions);
                }
            },
            error: function (response)
            {
               // console.log (response);
            }
        });
    /*
       if(puestoId==3)
       {

         var select =$('#divdirigentes');
        var createSelect = "<div id='contenidoOtroJefe'><label class='control-label label' for='Dirigente2'>Jefe/Supervisor</label> <div class='controls'> <select id='dirigente2' name='dirigente2' class='input-large'> </select></div></div>";

        select.append(createSelect);
       } else {

        $("#contenidoOtroJefe").remove();
       } */
    }


    function verificarDisponibilidadDeNumeroEmpleado(){

      var numeroEmpleado = $("#numeroEmpleado").val();

      $.ajax({
            type: "POST",
            url: "ajax_verificarDisponibilidadDeNumeroEmpleado.php",
            data: {"numeroEmpleado": numeroEmpleado},
            dataType: "json",
            success: function(response) {
                if (response.status == "existe")
                {
                    alert("El numero de empleado Ya existe en la base de datos");
                }
            },
            error: function (response)
            {
               // console.log (response);
            }
        });
    }

    function verificarNumeroCuentaDuplicado(){

      var numeroCuenta = $("#txtNumeroCta").val();

      $.ajax({
          type:"POST",
          url: "ajax_veficarNumeroCuentaDuplicado.php",
          data: {"numeroCta": numeroCuenta},
          dataType:"json",
          success: function(response){
            if (response.status=="existe")
            {
              alert("El número de cuenta ya esta registrado en la base de datos");
            }

          },
          error: function(response)
          {
            console.log(response);
          }
      });
    }

    function verificarNumeroCuentaClaveDuplicado(){

      var numeroCuentaClabe = $("#txtCtaClabe").val();

      $.ajax({
          type:"POST",
          url: "ajax_verificarNumeroCtaClabeDuplicado.php",
          data: {"numeroCuentaClabe": numeroCuentaClabe},
          dataType:"json",
          success: function(response){
            if (response.status=="existe"){
              alert("El número de cuenta clabe ya esta registrado en la base de datos");
            }
          },
          error: function(response)
          {
            console.log(response);
          }
      });
    }

    function verificarNumeroImssDuplicado(){

    var numeroSeguroSocial1 = $("#numeroSeguroSocial").val();

      $.ajax({
          type:"POST",
          url: "ajax_verificarNumeroImssDuplicado.php",
          data: {"numeroSeguroSocial": numeroSeguroSocial1},
          dataType:"json",
          success: function(response){

            if (response.status=="existe")
            {

              alert("El número de imss ya esta registrado en la base de datos");
              $("#numeroSeguroSocial").val("");
            }

          },
          error: function(response)
          {
            //console.log(response);
          }
      });
    }

  function seleccionarEntidadFederativa(){

    var claveEdo = $("#idEndidadFederativa").val();

    $("#numeroEmpleadoEntidad").val(claveEdo) ;
    }

    function obtenerUltimoNumeroEmpleado(){
      var valorTipo = $("#tipoPuesto").val();
       $("#numeroEmpleadoTipo").val(valorTipo);
       var entidad = $("#numeroEmpleadoEntidad").val();
       var tipo = $("#tipoPuesto").val();

      $.ajax({
            type: "POST",
            url: "ajax_obtenerUltimoNumeroEmpleado.php",
            data: {"entidad": entidad, "tipo":tipo},
            dataType: "json",
            success: function(response) {
                //console.log (response);
               if (response.status == "success")
                {
                    var obtenerUltimoNumeroEmpleado = response.ultimoNumeroEmpleado;
                    $("#numeroEmpleadoConsecutivo").val(obtenerUltimoNumeroEmpleado);
                }
            },
            error: function (response)
            {
                console.log (response);
            }
        });

    }


    function copiarDatosVisitanteParaContratacion (apellidoPaterno, apellidoMaterno, nombre, numeroVisitante){
        $("#apellidoPaternoEmpleado").val (apellidoPaterno);
        $("#apellidoMaternoEmpleado").val (apellidoMaterno);
        $("#nombreEmpleado").val (nombre);
        $("#numeroVisitante").val(numeroVisitante);
    }



function obtenerListaDocumentos(){

      $.ajax({

            type: "POST",
            url: "ajax_obtenerListaDocumentos.php",
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {

                    var listaDocumentos = response.listaDocumentos;

                    for ( var i = 0; i < listaDocumentos.length; i++ ){

                      var nombreDocumento = listaDocumentos[i].nombreDocumento;

                    var checkboxsOriginales =$('#documentosOriginales');
                    var checkboxsCopias =$('#documentosCopias');

                    var checkOriginal = "<input type='checkbox' class='style3'>"+nombreDocumento+"<br>";
                    var checkCopia = "<input type='checkbox' class='style3'>"+nombreDocumento+"<br>";

                    checkboxsOriginales.append (checkOriginal);
                    checkboxsCopias.append (checkCopia);

                    }
                }
            },
            error: function (response)
            {
                console.log (response);
                console.log (listaDocumentos);

            }
        });
    }


$('input[type="checkbox"].style3').checkbox({
    buttonStyle: 'btn-danger',
    buttonStyleChecked: 'btn-success',
    checkedClass: 'icon-check',
    uncheckedClass: 'icon-check-empty'
});

function limpiarCamposTxt()
{
  $(":text").each(function(){
                    $($(this)).val('');
                    });

                    $( "#numeroEmpleado" ).prop( "disabled", false );
                    $( "#apellidoPaternoEmpleado" ).prop( "disabled", false );
                    $( "#apellidoMaternoEmpleado" ).prop( "disabled", false );
                    $( "#nombreEmpleado" ).prop( "disabled", false );
                    $( "#fechaIngreso" ).prop( "disabled", false );
                    $( "#numeroSS" ).prop( "disabled", false );
                    $( "#numeroCta" ).prop( "disabled", false );
                    $( "#tipoPuesto" ).prop( "disabled", false );
                    $( "#puesto" ).prop( "disabled", false );
                    $( "#guardar" ).prop( "disabled", false );
                    $( "#idEndidadFederativa").prop("disabled",false);
                    $( "#idSucursalIngreso").prop("disabled",false);
                    $( "#dirigente2").prop("disabled",false);
                    $( "#dirigente").prop("disabled",false);
                    $( "#numeroSeguroSocial").prop("disabled",false);
                    $( "#selectPuntoServicio").prop("disabled",false);
                    $( "#tipoTurno").prop("disabled",false);
                    $( "#sexo").prop("disabled",false);
                    $( "#oficio").prop("disabled",false);
                    $( "#numeroVisitante").prop("disabled",false);
                    $( "#selectMunicipioNac").prop("disabled",false);
                    $( "#selectReclutador").prop("disabled",false);
                    $( "#selectMedioInformacion").prop("disabled",false);

                    $("#divReclutador").html("");
                    $("#divLblReclutador").html("");

                    $("#divMedioInformacion").html("");
                    $("#divLblMedio").html("");
                    $("#botonesExtras").remove();
}


function clearForm(){

     datosGuardadosMadre=0;
     datosGuardadosPadre=0;
     datosGuardadosBeneficiario=0;
$('#form_registrarEmpleado').clearForm();
                    $( "#numeroEmpleado" ).prop( "disabled", false );
                    $( "#apellidoPaternoEmpleado" ).prop( "disabled", false );
                    $( "#apellidoMaternoEmpleado" ).prop( "disabled", false );
                    $( "#nombreEmpleado" ).prop( "disabled", false );
                    $( "#fechaIngreso" ).prop( "disabled", false );
                    $( "#numeroSS" ).prop( "disabled", false );
                    $( "#numeroCta" ).prop( "disabled", false );
                    $( "#tipoPuesto" ).prop( "disabled", false );
                    $( "#puesto" ).prop( "disabled", false );
                    $( "#guardar" ).prop( "disabled", false );
                    $( "#idEndidadFederativa").prop("disabled",false);
                    $( "#idSucursalIngreso").prop("disabled",false);
                    $( "#dirigente2").prop("disabled",false);
                    $( "#dirigente").prop("disabled",false);
                    $( "#numeroSeguroSocial").prop("disabled",false);
                    $( "#selectPuntoServicio").prop("disabled",false);
                    $( "#tipoTurno").prop("disabled",false);
                    $( "#sexo").prop("disabled",false);
                    $( "#oficio").prop("disabled",false);
                    $( "#tipoSangre").prop("disabled",false);
                    $( "#numeroVisitante").prop("disabled",false);
                    $( "#txtNumeroCta").prop("disabled",false);
                    $( "#txtCtaClabe").prop("disabled",false);
                    $( "#1").prop("disabled",false);
                    $( "#2").prop("disabled",false);
                    $( "#selectEndidadFederativaLabor").prop("disabled",false);
                    $( "#selectLineaNegocio").prop("disabled",false);
                    $("input[name=periodo]").attr('disabled', false);
                    // $("input[name=periodo]").attr('disabled', false);

                    $("#fotoEmpleado").html ("<img style='margin:0 auto;' src='img/person.png'/>");
                    $("#idFotoEmpleado").val("");

                    $( "#txtFechaNacimiento").prop("disabled",false);
                    $( "#selectPaisNacimiento").prop("disabled",false);
                    $( "#selectEntidadNacimiento").prop("disabled",false);
                    $( "#selectMunicipioNac").prop("disabled",false);
                    $( "#txtMunicipioNac").prop("disabled",false);
                    $( "#txtCurp").prop("disabled",false);
                    $( "#txtRfc").prop("disabled",false);
                    $( "#selectEstadoCivil").prop("disabled",false);
                    $( "#selectGradoEstudios").prop("disabled",false);
                    $( "#selectTipoSangre").prop("disabled",false);
                    $( "#selectOficio").prop("disabled",false);
                    $( "#estatusCartilla").prop("disabled",false);
                    $( "#txtNumeroCartilla").prop("disabled",false);
                    $( "#btnGuardarDatosPersonales").prop("disabled",false);

                    $( "#txtCP").prop("disabled",false);
                    $( "#txtCalle").prop("disabled",false);
                    $( "#txtNumeroInt").prop("disabled",false);
                    $( "#txtNumeroExt").prop("disabled",false);
                    $( "#txtTelefonoMovil").prop("disabled",false);
                    $( "#txtTelefonoFijo").prop("disabled",false);
                    $( "#txtCorreo").prop("disabled",false);
                    $( "#btnGuardarDatosDireccion").prop("disabled",false);

                    $( "#btnGuardarDatosFamiliares").prop("disabled",false);
                    $( "#txtNombreMadre").prop("disabled",false);
                    $( "#txtNombrePadre").prop("disabled",false);

                    $( "#checkBeneficiario").prop("disabled",false);
                    $( "#checkMadre").prop("disabled",false);
                    $( "#checkPadre").prop("disabled",false);
                   // $( "#selectBeneficiario").prop("disabled",false);
                    $( "#txtOtroBeneficiario").prop("disabled",false);
                    $( "#selectOtroBeneficiario").prop("disabled",false);

                    $( "#selectReclutador").prop("disabled",false);
                    $( "#selectMedioInformacion").prop("disabled",false);

                    $("#divReclutador").html("");
                    $("#divLblReclutador").html("");

                    $("#divMedioInformacion").html("");
                    $("#divLblMedio").html("");

                    jQuery("#checkMadre").attr('checked', true);
                    jQuery("#checkPadre").attr('checked', false);
                    jQuery("#checkBeneficiario").attr('checked', false);

                    $("#contenidoOtroBeneficiario").remove();

                        datosGuardadosMadre=0;
                        datosGuardadosPadre=0;
                        datosGuardadosBeneficiario=0;

                    var elemento1 = document.getElementById("spanDatosGenerales");
                    elemento1.className = "glyphicon glyphicon-remove";

                    var elemento2 = document.getElementById("spanDatosPersonales");
                    elemento2.className = "glyphicon glyphicon-remove";

                    var elemento3 = document.getElementById("spanDatosDireccion");
                    elemento3.className = "glyphicon glyphicon-remove";

                    var elemento3 = document.getElementById("spanDatosFamiliares");
                    elemento3.className = "glyphicon glyphicon-remove";

                    $('#selectPaisNacimiento').val(46);
                    $("#fechaIngreso").val(currentDate);

                    $("#buttonNuevoRegistro").remove();
                    $("#divdirigentes").remove();
}

function clearTipoPuesto(){
    $('#tipoPuesto').clearForm();
    $('#puesto').clearForm();
    $( "#tipoPuesto" ).prop( "disabled", false );
    $( "#puesto" ).prop( "disabled", false );
}

function CreacionCurpInternRegistro(){

  var paisNac = $("#selectPaisNacimiento").val();
  var efNac = $("#selectEntidadNacimiento").val();
  var municipioNac = $("#selectMunicipioNac").val();
  var curpDP = $("#txtCurp").val();
  var rfcDP = $("#txtRfc").val();
  var estadoCivilDP = $("#selectEstadoCivil").val();

  if(paisNac == "SIN PAIS" || paisNac == "" || paisNac == "NULL" || paisNac == "null" || paisNac == null || paisNac == "0") {
     alertMsg1="<div id='msgAlert' class='alert alert-error'>Seleccione El País De Nacimiento<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
     $("#alertMsg").html(alertMsg1);
     $(document).scrollTop(0);
     $('#msgAlert').delay(3000).fadeOut('slow');
    }
    if(efNac == "ENTIDAD FEDERATIVA" || efNac == "" || efNac == "NULL" || efNac == "null" || efNac == null) {
       alertMsg1="<div id='msgAlert' class='alert alert-error'>Seleccione La Entidad De Nacimiento<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
       $("#alertMsg").html(alertMsg1);
       $(document).scrollTop(0);
       $('#msgAlert').delay(3000).fadeOut('slow');
    }
    if(municipioNac == "MUNICIPIOS" || municipioNac == "" || municipioNac == "NULL" || municipioNac == "null" || municipioNac == null || municipioNac == "0"){
        alertMsg1="<div id='msgAlert' class='alert alert-error'>Seleccione El Municipio De Nacimiento<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
       $("#alertMsg").html(alertMsg1);
       $(document).scrollTop(0);
       $('#msgAlert').delay(3000).fadeOut('slow');

    }
    if (curpDP == "") {
        alertMsg1="<div id='msgAlert' class='alert alert-error'>El CURP NO Pude Estar Vacio Proporcione CURP (18 Caracteres)<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
       $("#alertMsg").html(alertMsg1);
       $(document).scrollTop(0);
       $('#msgAlert').delay(3000).fadeOut('slow');

    }
    if (curpDP != "") {
        if ( curpDP.length != 18) {
            alertMsg1="<div id='msgAlert' class='alert alert-error'>El CURP NO Contiene Los (18 Caracteres) Correspondientes<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
              $("#alertMsg").html(alertMsg1);
              $(document).scrollTop(0);
              $('#msgAlert').delay(3000).fadeOut('slow');
        }
    }

    if(rfcDP == "") {
        alertMsg1="<div id='msgAlert' class='alert alert-error'>Proporcione RFC (13 Caracteres)<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
       $("#alertMsg").html(alertMsg1);
       $(document).scrollTop(0);
       $('#msgAlert').delay(3000).fadeOut('slow');
    }

    if(rfcDP != "") {
      if(rfcDP.length != 13) {
         alertMsg1="<div id='msgAlert' class='alert alert-error'>RFC inválido<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#alertMsg").html(alertMsg1);
         $(document).scrollTop(0);
         $('#msgAlert').delay(3000).fadeOut('slow');
     }
    }
  var estadoCivilDP = $("#selectEstadoCivil").val();
  var gradoEstudiosDP = $("#selectGradoEstudios").val();
  var tipoSangre = $("#selectTipoSangre").val();
  var oficio = $("#selectOficio").val();


    if (estadoCivilDP == "ESTADO CIVIL") {
        alertMsg1="<div id='msgAlert' class='alert alert-error'>Seleccione estado civil<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#alertMsg").html(alertMsg1);
         $(document).scrollTop(0);
         $('#msgAlert').delay(3000).fadeOut('slow');
    }
    if (gradoEstudiosDP == "GRADO ESTUDIOS") {
        alertMsg1="<div id='msgAlert' class='alert alert-error'>Seleccione Grado de estudios<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#alertMsg").html(alertMsg1);
         $(document).scrollTop(0);
         $('#msgAlert').delay(3000).fadeOut('slow');
    }

    if (tipoSangre == "TIPO SANGRE") {
        alertMsg1="<div id='msgAlert' class='alert alert-error'>Seleccione tipo de sangre<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#alertMsg").html(alertMsg1);
         $(document).scrollTop(0);
         $('#msgAlert').delay(3000).fadeOut('slow');
    }
    if (oficio == "OFICIO") {
        alertMsg1="<div id='msgAlert' class='alert alert-error'>Seleccione Oficio<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#alertMsg").html(alertMsg1);
         $(document).scrollTop(0);
         $('#msgAlert').delay(3000).fadeOut('slow');
    }


  var buscadorPreseleccion = $("#txtBuscarPreseleccion").val();
  var edadIngresada = $("#txtEdad").val();
  var curpEdited1 = $("#txtCurp").val();
  var curpModificado = curpEdited1.match( /^\w{4}(\w{2})(\w{2})(\w{2})(\w{6})(\w{2})/);
  var anioCurpModif = parseInt(curpModificado[1],10)+1900;
  if( anioCurpModif < 1950 ) anioCurpModif += 100;
  var mesModif = parseInt(curpModificado[2], 10)-1;
  if(mesModif < 9 ){
     mesModif= "0" + mesModif;
  } 
  var diaModif = parseInt(curpModificado[3], 10);
  if(diaModif < 9 ){
     diaModif= "0" + diaModif;
  } 

  var fechaCompletaCURP= new Date( anioCurpModif, mesModif, diaModif );
  var fechaActual = new Date();

  var diff = fechaCompletaCURP - fechaActual;
  var aniosObtenidoCrup= (diff/(31556900000));
  var anioTotal= Math.trunc(aniosObtenidoCrup);
  var anioEmpleadoXCurp= Math.abs(anioTotal);

  if(buscadorPreseleccion==''){
    alertMsg1="<div id='msgAlert' class='alert alert-error'>INGRESE UN NUMERO DE PRESELECCIÓN<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
     $("#alertMsg").html(alertMsg1);
     $(document).scrollTop(0);
     $('#msgAlert').delay(3000).fadeOut('slow');
    return;
  }else if(edadIngresada<15 || edadIngresada>90){
    alertMsg1="<div id='msgAlert' class='alert alert-error'>INGRESE UNA EDAD VALIDA<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
     $("#alertMsg").html(alertMsg1);
     $(document).scrollTop(0);
     $('#msgAlert').delay(3000).fadeOut('slow');
    return;
  }else if(edadIngresada<15 || edadIngresada>90){
    alertMsg1="<div id='msgAlert' class='alert alert-error'>INGRESE UNA EDAD VALIDA<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
     $("#alertMsg").html(alertMsg1);
     $(document).scrollTop(0);
     $('#msgAlert').delay(3000).fadeOut('slow');
    return;
  }else if(anioEmpleadoXCurp!=edadIngresada){
    alertMsg1="<div id='msgAlert' class='alert alert-error'>INGRESE LA EDAD CORRECTA<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
     $("#alertMsg").html(alertMsg1);
     $(document).scrollTop(0);
     $('#msgAlert').delay(3000).fadeOut('slow');
    return;
  }

  var empleadoApellidoPaterno = $("#apellidoPaternoEmpleado").val();
  var empleadoApellidoMaterno = $("#apellidoMaternoEmpleado").val();
  var nombreEmpleado = $("#nombreEmpleado").val();
  var fechaNacimiento = $("#txtFechaNacimiento").val();
  var descripcionGenero = $("#2").val();
  var selectPaisNacimiento = $("#selectPaisNacimiento").val();

  if($('#2').is(":checked")) {
    var LetraGenero = "H";
  }else if($('#1').is(":checked")) {
    var LetraGenero = "M";
  }
  if(selectPaisNacimiento=="46"){
    var claveEntidadF = $("#ClaveEntidadFederativaRegidtro").val();
  }else{
    var claveEntidadF ="NE";
  }
// Se Obtiene Las Vocales y Consonantes del apellido paterno
  var apellidoPCompleto = empleadoApellidoPaterno.split(" ");
  var largoapellidoPCompleto = apellidoPCompleto.length;
  if(largoapellidoPCompleto > "1"){
    for(var i=0; i < largoapellidoPCompleto; i++){
      var apellidoPat =  apellidoPCompleto[i];
      if((apellidoPat != "DA") && (apellidoPat != "DAS") && (apellidoPat != "DE") && (apellidoPat != "DEL") && (apellidoPat != "DER") && (apellidoPat != "DI") && (apellidoPat != "DIE") && (apellidoPat != "DD") && (apellidoPat != "EL") && (apellidoPat != "LA") && (apellidoPat != "LOS") && (apellidoPat != "LAS") && (apellidoPat != "LE") && (apellidoPat != "LES") && (apellidoPat != "MAC") && (apellidoPat != "MC") && (apellidoPat != "VAN") && (apellidoPat != "VON") && (apellidoPat != "Y") && (apellidoPat != "CON")){
        var LetraApellidoP = apellidoPat.substr(0,1);
        var PrimeraVocalApellidoP = apellidoPat.substring(1).replace (/[^ a, e, i, o, u, A, E, I, O, U]/g,'').substring(0, 1);
        var ConsonanteApellidoP = apellidoPat.trim().substring(1).replace(/[AEIOU]/ig, '').substring(0, 1);
        i=largoapellidoPCompleto;
      } 
    }
  }else{
    var LetraApellidoP = empleadoApellidoPaterno.substr(0,1);
    var PrimeraVocalApellidoP = empleadoApellidoPaterno.substring(1).replace (/[^ a, e, i, o, u, A, E, I, O, U]/g,'').substring(0, 1);
    var ConsonanteApellidoP = empleadoApellidoPaterno.trim().substring(1).replace(/[AEIOU]/ig, '').substring(0, 1);
  }
// Se Obtiene Las Vocales y Consonantes del apellido Materno
  if(empleadoApellidoMaterno=="" || empleadoApellidoMaterno=="null" || empleadoApellidoMaterno==null || empleadoApellidoMaterno=="NULL"){
    var LetraApellidoM = "";
    var ConsonanteApellidoM = "";
  }else{
    var apellidoMCompleto = empleadoApellidoMaterno.split(" ");
      var largoapellidoMCompleto = apellidoMCompleto.length;
      if(largoapellidoMCompleto > "1"){
        for(var i=0; i < largoapellidoMCompleto; i++){
          var apellidoMat =  apellidoMCompleto[i];
          if((apellidoMat != "DA") && (apellidoMat != "DAS") && (apellidoMat != "DE") && (apellidoMat != "DEL") && (apellidoMat != "DER") && (apellidoMat  != "DI") && (apellidoMat != "DIE") && (apellidoMat != "DD") && (apellidoMat != "EL") && (apellidoMat != "LA") && (apellidoMat != "LOS") &&  (apellidoMat != "LAS") && (apellidoMat != "LE") && (apellidoMat != "LES") && (apellidoMat != "MAC") && (apellidoMat != "MC") && (  apellidoMat != "VAN") && (apellidoMat != "VON") && (apellidoMat != "Y") && (apellidoMat != "CON")){
            var LetraApellidoM = apellidoMat.substr(0,1);
            var ConsonanteApellidoM = apellidoMat.trim().substring(1).replace(/[AEIOU]/ig, '').substring(0, 1);
            i=largoapellidoMCompleto;
          } 
        }
      }else{
        var LetraApellidoM = empleadoApellidoMaterno.substr(0,1);
        var ConsonanteApellidoM = empleadoApellidoMaterno.trim().substring(1).replace(/[AEIOU]/ig, '').substring(0, 1);
      }
  }
    // Se Obtiene Las Vocales y Consonantes de Los Nombres
    var nombreSplit = nombreEmpleado.split(" ");
    var LargoNombreSplit = nombreSplit.length;
    if(LargoNombreSplit > "1"){
      for(var i=0; i < LargoNombreSplit; i++){  
          var primerNombre =  nombreSplit[i];
        if((primerNombre != "MARIA") && (primerNombre != "MA.") && (primerNombre != "MA") && (primerNombre != "maria") && (primerNombre != "ma.") && (primerNombre != "ma") && (primerNombre != "Maria") && (primerNombre != "Ma.") && (primerNombre != "Ma") && (primerNombre != "JOSE") && (primerNombre != "J.") && (primerNombre != "J") && (primerNombre != "jose") && (primerNombre != "j.") && (primerNombre != "j") && (primerNombre != "Jose") && (primerNombre != "DA") && (primerNombre != "DAS") && (primerNombre != "DE") && (primerNombre != "DEL") && (primerNombre != "DER") && (primerNombre != "DI") && (primerNombre != "DIE") && (primerNombre != "DD") && (primerNombre != "EL") && (primerNombre != "LA") && (primerNombre != "LOS") &&  (primerNombre != "LAS") && (primerNombre != "LE") && (primerNombre != "LES") && (primerNombre != "MAC") && (primerNombre != "MC") && ( primerNombre != "VAN") && (primerNombre != "VON") && (primerNombre != "Y")){
            var letraNombre = primerNombre.substr(0,1);
            var ConsonanteNombre = primerNombre.trim().substring(1).replace(/[AEIOU]/ig, '').substring(0, 1);
            i=LargoNombreSplit;
        }else{
          if(i == LargoNombreSplit-1){
            var letraNombre = primerNombre.substr(0,1);
              var ConsonanteNombre = primerNombre.trim().substring(1).replace(/[AEIOU]/ig, '').substring(0, 1);
            }
        }
      }
    }else{
      var primerNombre =  nombreSplit[0];
      var letraNombre = primerNombre.substr(0,1);
      var ConsonanteNombre = primerNombre.trim().substring(1).replace(/[AEIOU]/ig, '').substring(0, 1);
    }
    if(LetraApellidoP == "Ñ" || LetraApellidoP == "ñ" || LetraApellidoP == "/" || LetraApellidoP == "-" || LetraApellidoP == "."){
      LetraApellidoP="X";
    }if(PrimeraVocalApellidoP == "Ñ" || PrimeraVocalApellidoP == "ñ" || PrimeraVocalApellidoP == "/" || PrimeraVocalApellidoP == "-" || PrimeraVocalApellidoP == "." || PrimeraVocalApellidoP == ""){
      PrimeraVocalApellidoP="X";
    }if(LetraApellidoM == "Ñ" || LetraApellidoM == "ñ" || LetraApellidoM == "/" || LetraApellidoM == "-" || LetraApellidoM == "." || LetraApellidoM == ""){
      LetraApellidoM="X";                          
    }if(letraNombre == "Ñ" || letraNombre == "ñ" || letraNombre == "/" || letraNombre == "-" || letraNombre == "."){
      letraNombre="X";                          
    }
    if(fechaNacimiento=="" || fechaNacimiento=="null" || fechaNacimiento==null || fechaNacimiento=="NULL"){
      var FechaMes = "00";
      var FechaDia = "00";
      var FechaAnio = "00";
    }else{
      var echa11 = fechaNacimiento.split("-");
      var fechaAnio1 = echa11[0];
      var FechaMes = echa11[1];
      var FechaDia = echa11[2];
      var FechaAnio = fechaAnio1.substr(2,3);
    }  
    if((ConsonanteApellidoP == "Ñ" || ConsonanteApellidoP == "ñ" || ConsonanteApellidoP == "/" || ConsonanteApellidoP == "-" || ConsonanteApellidoP == "." || ConsonanteApellidoP == "") && ( LetraApellidoP != "M" && LetraApellidoP != "m" && LetraApellidoP != "j" && LetraApellidoP != "J")){
      ConsonanteApellidoP="X";
    }
    if((ConsonanteApellidoM == "Ñ" || ConsonanteApellidoM == "ñ" || ConsonanteApellidoM == "/" || ConsonanteApellidoM == "-" || ConsonanteApellidoM == "." || ConsonanteApellidoM == "") && ( LetraApellidoM != "M" && LetraApellidoM != "m" && LetraApellidoM != "j" && LetraApellidoM != "J")){
      ConsonanteApellidoM="X";
    }
    if((ConsonanteNombre == "Ñ" || ConsonanteNombre == "ñ" || ConsonanteNombre == "/" || ConsonanteNombre == "-" || ConsonanteNombre == ".") && ( letraNombre != "M" && letraNombre != "m" && letraNombre != "j" && letraNombre != "J")){
      ConsonanteNombre="X";
    }

    if(LetraApellidoP=="Ä"){LetraApellidoP = "A";} if(PrimeraVocalApellidoP=="Ä"){PrimeraVocalApellidoP = "A";} if(LetraApellidoM=="Ä"){LetraApellidoM = "A";}
    if(LetraApellidoP=="ä"){LetraApellidoP = "a";} if(PrimeraVocalApellidoP=="ä"){PrimeraVocalApellidoP = "a";} if(LetraApellidoM=="ä"){LetraApellidoM = "a";} 
    if(LetraApellidoP=="Ë"){LetraApellidoP = "E";} if(PrimeraVocalApellidoP=="Ë"){PrimeraVocalApellidoP = "E";} if(LetraApellidoM=="Ë"){LetraApellidoM = "E";} 
    if(LetraApellidoP=="ë"){LetraApellidoP = "e";} if(PrimeraVocalApellidoP=="ë"){PrimeraVocalApellidoP = "e";} if(LetraApellidoM=="ë"){LetraApellidoM = "e";} 
    if(LetraApellidoP=="Ï"){LetraApellidoP = "I";} if(PrimeraVocalApellidoP=="Ï"){PrimeraVocalApellidoP = "I";} if(LetraApellidoM=="Ï"){LetraApellidoM = "I";} 
    if(LetraApellidoP=="ï"){LetraApellidoP = "i";} if(PrimeraVocalApellidoP=="ï"){PrimeraVocalApellidoP = "i";} if(LetraApellidoM=="ï"){LetraApellidoM = "i";} 
    if(LetraApellidoP=="Ö"){LetraApellidoP = "O";} if(PrimeraVocalApellidoP=="Ö"){PrimeraVocalApellidoP = "O";} if(LetraApellidoM=="Ö"){LetraApellidoM = "O";} 
    if(LetraApellidoP=="ö"){LetraApellidoP = "o";} if(PrimeraVocalApellidoP=="ö"){PrimeraVocalApellidoP = "o";} if(LetraApellidoM=="ö"){LetraApellidoM = "o";} 
    if(LetraApellidoP=="Ü"){LetraApellidoP = "U";} if(PrimeraVocalApellidoP=="Ü"){PrimeraVocalApellidoP = "U";} if(LetraApellidoM=="Ü"){LetraApellidoM = "U";} 
    if(LetraApellidoP=="ü"){LetraApellidoP = "u";} if(PrimeraVocalApellidoP=="ü"){PrimeraVocalApellidoP = "u";} if(LetraApellidoM=="ü"){LetraApellidoM = "u";}
    
    if(letraNombre=="Ä"){letraNombre = "A";} if(ConsonanteApellidoP=="Ä"){ConsonanteApellidoP = "A";} if(ConsonanteApellidoM=="Ä"){ConsonanteApellidoM = "A";}
    if(letraNombre=="ä"){letraNombre = "a";} if(ConsonanteApellidoP=="ä"){ConsonanteApellidoP = "a";} if(ConsonanteApellidoM=="ä"){ConsonanteApellidoM = "a";}
    if(letraNombre=="Ë"){letraNombre = "E";} if(ConsonanteApellidoP=="Ë"){ConsonanteApellidoP = "E";} if(ConsonanteApellidoM=="Ë"){ConsonanteApellidoM = "E";}
    if(letraNombre=="ë"){letraNombre = "e";} if(ConsonanteApellidoP=="ë"){ConsonanteApellidoP = "e";} if(ConsonanteApellidoM=="ë"){ConsonanteApellidoM = "e";}
    if(letraNombre=="Ï"){letraNombre = "I";} if(ConsonanteApellidoP=="Ï"){ConsonanteApellidoP = "I";} if(ConsonanteApellidoM=="Ï"){ConsonanteApellidoM = "I";}
    if(letraNombre=="ï"){letraNombre = "i";} if(ConsonanteApellidoP=="ï"){ConsonanteApellidoP = "i";} if(ConsonanteApellidoM=="ï"){ConsonanteApellidoM = "i";}
    if(letraNombre=="Ö"){letraNombre = "O";} if(ConsonanteApellidoP=="Ö"){ConsonanteApellidoP = "O";} if(ConsonanteApellidoM=="Ö"){ConsonanteApellidoM = "O";}
    if(letraNombre=="ö"){letraNombre = "o";} if(ConsonanteApellidoP=="ö"){ConsonanteApellidoP = "o";} if(ConsonanteApellidoM=="ö"){ConsonanteApellidoM = "o";}
    if(letraNombre=="Ü"){letraNombre = "U";} if(ConsonanteApellidoP=="Ü"){ConsonanteApellidoP = "U";} if(ConsonanteApellidoM=="Ü"){ConsonanteApellidoM = "U";}
    if(letraNombre=="ü"){letraNombre = "u";} if(ConsonanteApellidoP=="ü"){ConsonanteApellidoP = "u";} if(ConsonanteApellidoM=="ü"){ConsonanteApellidoM = "u";}

    if(ConsonanteNombre=="Ä"){ConsonanteNombre = "A";}
    if(ConsonanteNombre=="ä"){ConsonanteNombre = "a";}
    if(ConsonanteNombre=="Ë"){ConsonanteNombre = "E";}
    if(ConsonanteNombre=="ë"){ConsonanteNombre = "e";}
    if(ConsonanteNombre=="Ï"){ConsonanteNombre = "I";}
    if(ConsonanteNombre=="ï"){ConsonanteNombre = "i";}
    if(ConsonanteNombre=="Ö"){ConsonanteNombre = "O";}
    if(ConsonanteNombre=="ö"){ConsonanteNombre = "o";}
    if(ConsonanteNombre=="Ü"){ConsonanteNombre = "U";}
    if(ConsonanteNombre=="ü"){ConsonanteNombre = "u";}

    var palabraAntisonante = LetraApellidoP+PrimeraVocalApellidoP+LetraApellidoM+letraNombre; 
    //var palabraAntisonante ="COCA"
    $.ajax({
      type: "POST",
      url: "ajax_ObtenerPalabrasAntisonantes.php",
      data: {"palabraAntisonante": palabraAntisonante},
      dataType: "json",
      async:false,
      success: function(response) {
        if (response.status == "success")
        {
          var catalogoPalabraAntison = response.CatalogoPalabraAntison.length;
          if(catalogoPalabraAntison == "1"){
            var PlabraAntisonanteSustitucion = response.CatalogoPalabraAntison[0].PalabraSustitucion;
            palabraAntisonante = PlabraAntisonanteSustitucion;
          }
          var curpInterno1 = palabraAntisonante+FechaAnio+FechaMes+FechaDia+LetraGenero+claveEntidadF+ConsonanteApellidoP+ConsonanteApellidoM+ConsonanteNombre;
          var CurpInterno2 = curpInterno1.toUpperCase();
          $("#txtCurpInternoRegistro").val(CurpInterno2);
          RevisionDelCurpIngresadoConElInternoRegistro(curpEdited1);
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  // }
}//fin else preseleccion

function RevisionDelCurpIngresadoConElInternoRegistro(curpEdited1){
  var curpInterno1 = $("#txtCurpInternoRegistro").val();
  var curpInternoDivididoRfc = curpInterno1.substr(0,10);
  var curpEditedDivididoRfc = curpEdited1.substr(0,10);
  var curpEditedSeparado = curpEdited1.substr(0,16);
  var txtRfcEdited1 = $("#txtRfc").val();
  var rfcAño = txtRfcEdited1.substr(0,10);
  if(curpInterno1 != curpEditedSeparado){
    if($('#checkCurpRegistro').is(":checked")){
      if($('#checkRfcRegistro').is(":checked")){
        $("#modalCurpInternoRegistro").modal("show");
        $("#MensajeCurpRegistro").html("Movimiento registrado. La información de la no deducibilidad es responsabilidad de la confirmación con los datos y firma de usuario(zona Gif). Al tener  discrepancia con información de RENAPO e imss y sat con padrón activo y declaraciones de la persona físico como de la moral.");
        RevisonUltimosDosDigitosDelCurpRegistro();
      }else{
        if(curpEditedDivididoRfc != rfcAño){
          $("#modalCurpInternoRegistro").modal("show");
          $("#MensajeCurpRegistro").html("El RFC Ingresado : " + rfcAño +" No Coincide Con El Curp Ingresado : " + curpEditedDivididoRfc + " Favor De Revisar, Para Continuar Marque El Campo De '¿Continuar Con EL RFC?' ");
        }else{
          $("#modalCurpInternoRegistro").modal("show");
        $("#MensajeCurpRegistro").html("Movimiento registrado. La información de la no deducibilidad es responsabilidad de la confirmación con los datos y firma de usuario(zona Gif). Al tener  discrepancia con información de RENAPO e imss y sat con padrón activo y declaraciones de la persona físico como de la moral.");
          RevisonUltimosDosDigitosDelCurpRegistro();
        }
      }
    }else{
      $("#modalCurpInternoRegistro").modal("show");
      $("#MensajeCurpRegistro").html("Los Primeros 16 Caracteres Del Curp Ingresado : " + curpEditedSeparado +" No Coinciden Con El Curp Interno : " + curpInterno1 + " Basado En Los Datos Proporcionados Del Empleado, Favor De Revisar, Si Esta Serguro De Continuar Precione EL Check 'Continuar Con EL CURP'");
      $("#txtCurpInternoRegistro").show();
      $("#checkCurpRegistro").show();
      $("#LabelCurpInternoRegistro").show();
      $("#LabelCheckCurpInternoRegistro").show();
      $("#LabelCheckRfcInternoRegistro").show();
      $("#checkRfcRegistro").show();
    }
  }else if(curpInternoDivididoRfc != rfcAño){
    if($('#checkCurpRegistro').is(":checked")){
      if($('#checkRfcRegistro').is(":checked")){
        $("#modalCurpInternoRegistro").modal("show");
        $("#MensajeCurpRegistro").html("Movimiento registrado. La información de la no deducibilidad es responsabilidad de la confirmación con los datos y firma de usuario(zona Gif). Al tener  discrepancia con información de RENAPO e imss y sat con padrón activo y declaraciones de la persona físico como de la moral.");
        RevisonUltimosDosDigitosDelCurpRegistro();
      }else{
        if(curpEditedDivididoRfc != rfcAño){
          $("#modalCurpInternoRegistro").modal("show");
          $("#MensajeCurpRegistro").html("El RFC Ingresado : " + rfcAño +" No Coincide Con El Curp Ingresado : " + curpEditedDivididoRfc + " Favor De Revisar, Para Continuar Marque El Campo De '¿Continuar Con EL RFC?' ");
        }else{
          $("#modalCurpInternoRegistro").modal("show");
        $("#MensajeCurpRegistro").html("Movimiento registrado. La información de la no deducibilidad es responsabilidad de la confirmación con los datos y firma de usuario(zona Gif). Al tener  discrepancia con información de RENAPO e imss y sat con padrón activo y declaraciones de la persona físico como de la moral.");
          RevisonUltimosDosDigitosDelCurpRegistro();
        }
      }
    }else{
      $("#modalCurpInternoRegistro").modal("show");
      $("#MensajeCurpRegistro").html("Los Primeros 10 Caracteres Del RFC Ingresado : " + rfcAño +" No Coincide Con El RFC Interno : " + curpInternoDivididoRfc + " Favor De Revisar, Si Esta Serguro De Continuar Precione EL Check 'Continuar Con EL CURP'");
      $("#txtCurpInternoRegistro").show();
      $("#checkCurpRegistro").show();
      $("#LabelCurpInternoRegistro").show();
      $("#LabelCheckCurpInternoRegistro").show();
      $("#LabelCheckRfcInternoRegistro").show();
      $("#checkRfcRegistro").show();
    }
  }else{
    $("#LabelCurpInternoRegistro").hide();
    $("#LabelCheckCurpInternoRegistro").hide();
    $("#txtCurpInternoRegistro").hide();
    $("#checkCurpRegistro").hide();
    $("#checkCurpRegistro").prop("checked", false);  
    $("#checkRfcRegistro").hide();
    $("#checkRfcRegistro").prop("checked", false);
    $("#LabelCheckRfcInternoRegistro").hide();
    RevisonUltimosDosDigitosDelCurpRegistro();
   // editarDatosPersonales();
  }
}

function RevisonUltimosDosDigitosDelCurpRegistro(){

  var txtFechaNacimientoEdited2 = $("#txtFechaNacimiento").val();//split
  var txtFechaNacimientoEdited3 = txtFechaNacimientoEdited2.split("-");
  var AñoFecha1 = txtFechaNacimientoEdited3[0];
  var curpEdited2 = $("#txtCurp").val();
  var DigitoAño = curpEdited2.substr(16,1);
  var DigitoUltimo = curpEdited2.substr(17,1);
  
  if((AñoFecha1<2000) && (!/^([0-9])*$/.test(DigitoAño))){
    //alert("entre menos de 2000");
    $("#modalCurpInternoRegistro").modal("show");
    $("#MensajeCurpRegistro").html("El Penultimo Digito : '" + DigitoAño +"' Debe Ser Numerico Unicamente Ya Que El Empleado Nacio Antes Del Año 2000");

  }else if((AñoFecha1>=2000) && (!/^([A-Z-a-z])*$/.test(DigitoAño))){
    //alert("entre mas de 2000");
    $("#modalCurpInternoRegistro").modal("show");
    $("#MensajeCurpRegistro").html("El Penultimo Digito : '" + DigitoAño +"' Debe Ser Alfabetico Unicamente Ya Que El Empleado Nacio Despues Del Año 2000");
  }else if(!/^([A-Z-a-z-0-9])*$/.test(DigitoUltimo)){
    //alert("entre Ultimo Digito Mal");
    $("#modalCurpInternoRegistro").modal("show");
    $("#MensajeCurpRegistro").html("El Ultimo Digito : '" + DigitoUltimo +"' Debe Ser Alfanumerico Unicamente No Se Acpetan Signos De Puntuacion (/.*-,)");
  }else if(!/^([A-Z-a-z-0-9])*$/.test(DigitoUltimo)){
    //alert("entre Ultimo Digito Mal");
    $("#modalCurpInternoRegistro").modal("show");
    $("#MensajeCurpRegistro").html("El Ultimo Digito : '" + DigitoUltimo +"' Debe Ser Alfanumerico Unicamente No Se Acpetan Signos De Puntuacion (/.*-,)");
  }else{
    guardarDatosPersonalesSubmit();
  } 
}


function guardarDatosPersonalesSubmit(){
        var datastring = $("#form_registrarEmpleado").serialize();
        var edadDP = $("#txtEdad").val();
        datastring += "&edadDP=" + edadDP;

        $.ajax({
            type: "POST",
            url: "ajax_registroDatosPersonalesEmpleado.php",
            data: datastring,
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;

                if (response.status=="success") {
                    $( "#txtFechaNacimiento" ).prop( "disabled", true );
                    $( "#selectPaisNacimiento" ).prop( "disabled", true );
                    $( "#selectEntidadNacimiento" ).prop( "disabled", true );
                    $( "#selectMunicipioNac" ).prop( "disabled", true );
                    $( "#txtCurp" ).prop( "disabled", true );
                    $( "#txtRfc" ).prop( "disabled", true );
                    $( "#selectEstadoCivil" ).prop( "disabled", true );
                    $( "#selectGradoEstudios").prop("disabled",true);
                    $( "#selectTipoSangre").prop("disabled",true);
                    $( "#selectOficio").prop("disabled",true);
                    $( "#estatusCartilla").prop("disabled",true);
                    $( "#txtNumeroCartilla").prop("disabled",true);
                    $( "#btnGuardarDatosPersonales").prop("disabled",true);
                    $( "#txtEdad").prop("disabled",true);

                    alertMsg1="<div id='msgAlert'class='alert alert-success'><strong>Datos Personales</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#alertMsg").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(3000).fadeOut('slow');

                    var elemento = document.getElementById("spanDatosPersonales");
                    elemento.className = "glyphicon glyphicon-ok";
                } else if (response.status=="error")
                {
                  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error en el registro de Datos Personales:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#alertMsg").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                }
              },
            error: function(){
                  alert('error handing here guardar datos personales');
            }
        });
    }

function consultaCP (){
    var codigoPostal = $("#txtCP").val ();

    $("#multipleDirecciones").html ("");
    setDireccionData ("","","","","");

    // Si el código postal no tiene una longitud de 5 caracteres
    // entonces no hagas nada. Sal de la función.
    if (codigoPostal.length != 5){
        return;
    }

    $.ajax({
            type: "POST",
            url: "ajax_obtenerDirecciones.php",
            data: {txtCP : codigoPostal},
            dataType: "json",
            success: function(response) {
                if (response.listaDirecciones.length == 0){
                    $.notify("El código postal es inválido", {autoHideDelay: 3000, className: 'error'});
                    return;
                }
                else if (response.listaDirecciones.length == 1)
                {
                    var direccion = response.listaDirecciones [0];

                    setDireccionData (direccion.idAsentamiento,
                        direccion.nombreEntidadFederativa,
                        direccion.nombreMunicipio,
                        direccion.nombreAsentamiento,
                        direccion.municipioAsentamiento);
                    consultaUmf();
                    //console.log (direccion);
                }
                else
                {
                    var displayDirecciones = "";
                    for (var i = 0; i < response.listaDirecciones.length; i++)
                    {
                        var direccion = response.listaDirecciones [i];

                        var params = "\"" + direccion.idAsentamiento + "\"," +
                            "\"" + direccion.nombreEntidadFederativa + "\"," +
                            "\"" + direccion.nombreMunicipio + "\"," +
                            "\"" + direccion.nombreAsentamiento + "\"," +
                            "\"" + direccion.municipioAsentamiento + "\"";

                        displayDirecciones += "<p>" + (i + 1) + "<a href='javascript:setDireccionData(" + params + ")';>" +
                            direccion.nombreTipoAsentamiento + " " +
                            direccion.nombreAsentamiento + " " +
                            direccion.nombreMunicipio + ", " +
                            direccion.nombreEntidadFederativa + "</a></p>";
                    }
                   // console.log (displayDirecciones);
                    $("#multipleDirecciones").html (displayDirecciones);
                }
            },
            error: function(){
                  alert('error handing here obtener direccion cp');
            }
    });
}

function setDireccionData (idAsentamiento, nombreEntidadFederativa, nombreMunicipio, nombreAsentamiento,municipioAsentamiento )
{
    $("#txtIdAsentamiento").val(idAsentamiento);
    $("#txtEntidad").val (nombreEntidadFederativa);
    $("#txtMunicipio").val(nombreMunicipio);
    $("#municipioTexto").val(nombreMunicipio);
    $("#txtColonia").val(nombreAsentamiento);
    $("#coloniaTexto").val(nombreAsentamiento);
    $("#txtIdMunicipio").val(municipioAsentamiento);
    consultaUmf();
}

var municipios = [];

function consultarMunicipiosPorEntidad(){

  $("#txtMunicipioNac").val("");
  var entidadId = $("#selectEntidadNacimiento").val();
 
      $.ajax({
            type: "POST",
            url: "ajax_obtenerMunicipiosPorEntidad.php",
            data: {"entidadId": entidadId},
            dataType: "json",
            success: function(response) {
                if (response.status == "success"){
                  $("#ClaveEntidadFederativaRegidtro").val("");
                     var listaMunicipios = response.listaMunicipios;
                     var listaMunicipios1 = response.listaMunicipios[0].claveEntidadF;
                     $("#ClaveEntidadFederativaRegidtro").val(listaMunicipios1);
                     //municipios.length = 0;
                     municipiosNacOptions = "<option>MUNICIPIOS</option>";
                    for ( var i = 0; i < listaMunicipios.length; i++ ){
                       municipiosNacOptions += "<option value='" + listaMunicipios[i].idMunicipio + "'>" + listaMunicipios[i].nombreMunicipio + "</option>";
                      //municipios.push(listaMunicipios[i].nombreMunicipio)
                    }
                    $("#selectMunicipioNac").html (municipiosNacOptions);
                }
            },
            error: function (response)
            {
                console.log (response);
            }
        });
    }


function guardarDatosDireccionSubmit ()
    {
        var datastring = $("#form_registrarEmpleado").serialize();

        var folio=$('#txtBuscarPreseleccion').val();
        datastring += "&folioConsulta=" + folio;

        $.ajax({
            type: "POST",
            url: "ajax_registroDatosDireccion.php",
            data: datastring,
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;

                if (response.status=="success") {

                    alertMsg1="<div id='msgAlert' class='alert alert-success'><trong>Directorio:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#alertMsg").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                    $( "#txtCP" ).prop( "disabled", true );
                    $( "#txtEntidad" ).prop( "disabled", true );
                    $( "#txtMunicipio" ).prop( "disabled", true );
                    $( "#txtColonia" ).prop( "disabled", true );
                    $( "#txtCalle" ).prop( "disabled", true );
                    $( "#txtNumeroExt" ).prop( "disabled", true );
                    $( "#txtNumeroInt" ).prop( "disabled", true );
                    $( "#txtTelefonoMovil").prop("disabled",true);
                    $( "#txtTelefonoFijo").prop("disabled",true);
                    $( "#txtCorreo").prop("disabled",true);
                    $( "#btnGuardarDatosDireccion").prop("disabled",true);

                    if(cambioFolio==1){
                        actualizaDatosDireccionPreseleccion(datastring);
                    }
                    var elemento = document.getElementById("spanDatosDireccion");
                    elemento.className = "glyphicon glyphicon-ok";
                    var botones =$('#botonesExtras');
                    var boton = "<div id='buttonNuevoRegistro' name='buttonNuevoRegistro'><button type='button' class='btn btn-info' id='reset' onclick='clearForm(); limpiarCamposTxt();'><span class='glyphicon glyphicon-refresh' ></span> Nuevo Registro</button></div>";
                    botones.append (boton);
                } else if (response.status=="error")
                {
                  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error en el registro Direccion:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#alertMsg").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                }
              },
            error: function(){
                  alert('error handing here guardarDatosDireccionSubmit');
            }
        });
    }
/*
function seleccionaEstatusCartilla(genero){
      var generoSeleccion=genero;
      if (generoSeleccion==1){

      $("#1estatusCartilla").prop("disabled",true);
      $("#2estatusCartilla").prop("disabled",true);
      $("#3estatusCartilla").prop("disabled",true);
      $("#5estatusCartilla").prop("disabled",true);

      jQuery("#4estatusCartilla").attr('checked',true);
      $("#txtNumeroCartilla").val("NO APLICA");

      }else if (generoSeleccion==2)
      {
        jQuery("#1estatusCartilla").attr('checked', true);

        $( "#4estatusCartilla" ).prop( "disabled", true );

        $( "#1estatusCartilla" ).prop( "disabled", false );
        $( "#2estatusCartilla" ).prop( "disabled", false );
        $( "#3estatusCartilla" ).prop( "disabled", false );
        $( "#5estatusCartilla" ).prop( "disabled", false );
        $( "#txtNumeroCartilla" ).prop( "disabled", false );
        $( "#txtNumeroCartilla" ).val("");
      }
    }
*/

function seleccionarBeneficiario(){
       var parentescoBeneficiario= $("#selectBeneficiario").val()

       if (parentescoBeneficiario !=4 && parentescoBeneficiario != 5)
       {
        var cajaBeneficiario="<input type='text' id='txtBeneficiario' class='input-xlarge'>";
        $("#datoBeneficiario").html (cajaBeneficiario);

        var cajaEtiquetaBeneficiario = "<label id='etiquetaBeneficiario' class='control-label label' for='nombreBen'>Nombre Beneficiario</label>";
        $("#etiquedaBeneficiario").html (cajaEtiquetaBeneficiario);
       } else
       {
        $("#txtBeneficiario").remove();
        $("#etiquetaBeneficiario").remove();
       }
    }

    function obtenerListaBeneficiarios(){
       var mitexto = $("#otroBeneficiario option:selected").text();
       var valorTipo = $("#otroBeneficiario").val();

        if ( $('input[name=checkBeneficiario]').is(':checked')){
          $.ajax({
            type: "POST",
            url: "ajax_obtenerListaParentescos.php",
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                    var parentescos = response.listaParentescos;

                    parentescosOptions = "<option>PARENTESCO</option>";
                    for (var i = 0; i < parentescos.length; i++)
                    {
                        parentescosOptions += "<option value='" + parentescos[i].idParentesco + "'>" + parentescos[i].descripcionParentesco + "</option>";
                    }
                  //  $("#otroBeneficiario").html (parentescosOptions);
                    var select =$('#divOtroBeneficiario');
                    var createSelect = "<div id='contenidoOtroBeneficiario'><label class='control-label label' for='Beneficiario'>Otro Beneficiario</label> <select id='selectOtroBeneficiario' name='selectOtroBeneficiario' class='input-large'> </select> <input type='text' id='txtOtroBeneficiario' class='input-xlarge' placeholder='NOMBRE BENEFICIARIO'  ></div>";
                    select.append(createSelect);

                     $("#selectOtroBeneficiario").html (parentescosOptions);
                }
            },
            error: function (response)
            {
                console.log (response);

             }
          });

        }else
        {
          $("#contenidoOtroBeneficiario").remove();
        }
    }

  var datosGuardadosMadre=0;
  var datosGuardadosPadre=0;
  var datosGuardadosBeneficiario=0;

function guardarDatosMadre(){

  if (datosGuardadosMadre==0){
      var datastring = $("#form_registrarEmpleado").serialize();
      var estatusBeneficiario=1;
      var idParentescoFamiliar=5;
      var nombreFamiliar=$("#txtNombreMadre").val();

      if ( $('input[name=checkMadre]').is(':checked'))
        {
          estatusBeneficiario=1;
        } else{
          var estatusBeneficiario=0;
        }

        datastring += "&nombreFamiliar=" + nombreFamiliar;
        datastring += "&idParentescoFamiliar=" + idParentescoFamiliar;
        datastring += "&beneficiario=" + estatusBeneficiario;

        $.ajax({
            type: "POST",
            url: "ajax_registroDatosFamiliares.php",
            data: datastring,
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;

                if (response.status=="success") {

                    datosGuardadosMadre=1;
                    alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Datos personales</strong"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#alertMsg").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(3000).fadeOut('slow');

                    $( "#txtNombreMadre" ).prop( "disabled", true );
                    $( "#checkMadre" ).prop( "disabled", true );

                    guardarDatosPadre();
                } else if (response.status=="error")
                {
                  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error en el registro de datos familiares (Datos Madre):</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#alertMsg").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                }
              },
            error: function(){
                  alert('error handing here guardarDatosMadre');
            }
        });
  }else{
    guardarDatosPadre();
  }

}

function guardarDatosPadre(){

  if (datosGuardadosPadre==0){
      var datastring = $("#form_registrarEmpleado").serialize();
      var estatusBeneficiario=0;
      var idParentescoFamiliar=4;
      var nombreFamiliar=$("#txtNombrePadre").val();

      if ($('input[name=checkPadre]').is(':checked')){
          estatusBeneficiario=1;
        } else{
          var estatusBeneficiario=0;
        }

        datastring += "&nombreFamiliar=" + nombreFamiliar;
        datastring += "&idParentescoFamiliar=" + idParentescoFamiliar;
        datastring += "&beneficiario=" + estatusBeneficiario;

        $.ajax({
            type: "POST",
            url: "ajax_registroDatosFamiliares.php",
            data: datastring,
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;

                if (response.status=="success") {
                  datosGuardadosPadre=1;

                    alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Registro Datos Familiares</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#alertMsg").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                    $( "#txtNombrePadre" ).prop( "disabled", true );
                    $( "#checkPadre" ).prop( "disabled", true );
                    guardarDatosOtroBeneficiario();
                } else if (response.status=="error")
                {
                  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error en el registro de datos familiares (Datos Padre):</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#alertMsg").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                }
              },
            error: function(){
                  alert('error handing here guardarDatosPadre');
            }
        });
    }
  }


function guardarDatosOtroBeneficiario(){

  var estatusBeneficiario=0;

   if ( $('input[name=checkBeneficiario]').is(':checked'))
        {
          estatusBeneficiario=1;
        } else{
          estatusBeneficiario=0;
        }
    if (estatusBeneficiario==1 &&  datosGuardadosBeneficiario==0){

      var datastring = $("#form_registrarEmpleado").serialize();
      var idParentescoFamiliar=$("#selectOtroBeneficiario").val();
      var nombreFamiliar=$("#txtOtroBeneficiario").val();
      datastring += "&nombreFamiliar=" + nombreFamiliar;
      datastring += "&idParentescoFamiliar=" + idParentescoFamiliar;
      datastring += "&beneficiario=" + estatusBeneficiario;

      $.ajax({
            type: "POST",
            url: "ajax_registroDatosFamiliares.php",
            data: datastring,
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;

                if (response.status=="success") {

                  datosGuardadosBeneficiario=1;
                    alertMsg1="<div id='msgAlert' class='alert alert-success'>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                     $("#alertMsg").html(alertMsg1);
                     $(document).scrollTop(0);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                    $( "#txtOtroBeneficiario" ).prop( "disabled", true );
                    $( "#selectOtroBeneficiario" ).prop( "disabled", true );
                    bloquearElementosDatosFamiliares();
                } else if (response.status=="error")
                {
                  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error en el registro de datos familiares:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#alertMsg").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                }
              },
            error: function(){
                  alert('error handing here guardarDatosOtroBeneficiario');
            }
        });
      }else {
              bloquearElementosDatosFamiliares();
      }
}


function consultaUmf (){

    var idMunicipio = $("#txtIdMunicipio").val ();

    $.ajax({
            type: "POST",
            url: "ajax_obtenerUmf.php",
            data: {idMunicipio : idMunicipio},
            dataType: "json",
            success: function(response) {
              if (response.listaUmf.length == 1)
                {
                    var umf = response.listaUmf [0];
                    setUmfData (umf.idUnidadMedica,
                        umf.nombreUnidad,
                        umf.domicilioUnidad);
                }
                else
                {
                    var displayUmf = "";
                    for (var i = 0; i < response.listaUmf.length; i++)
                    {
                        var umf = response.listaUmf [i];

                        var params = "\"" + umf.idUnidadMedica + "\"," +
                            "\"" + umf.nombreUnidad + "\"," +
                            "\"" + umf.domicilioUnidad + "\"";

                        displayUmf += "<p>" + (i + 1) + "<a href='javascript:setUmfData(" + params + ")';>" +
                            umf.nombreUnidad + "</a></p>";
                    }
                    $("#multipleUmf").html (displayUmf);
                }
            },
            error: function(){
                  alert('error handing here consultaUmf');
            }
    });
}

function setUmfData (idUnidadMedica,nombreUnidad, domicilioUnidad ){
    $("#txtIdUmf").val(idUnidadMedica);
    $("#txtNombreUmf").val (nombreUnidad);
    $("#txtDireccionUmf").val(domicilioUnidad);
}

function obtenerListaPuntosServiciosPorEntidad(){

       var idEntidad  = $("#selectEndidadFederativaLabor").val();
       var estatusPunto=1;

       $.ajax({
            type: "POST",
            url: "ajax_obtenerPuntoServicioPorEntidad.php",
            data: {"idEntidad": idEntidad, "estatusPunto":estatusPunto},
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                    var puntosServicios = response.puntoServicio;

                    puntosServiciosOptions = "<option>PUNTOS SERVICIOS</option>";
                    for (var i = 0; i < puntosServicios.length; i++)
                    {
                        puntosServiciosOptions += "<option value='" + puntosServicios[i].idPuntoServicio + "'>" + puntosServicios[i].puntoServicio + "</option>";
                    }

                    $("#selectPuntoServicio").html (puntosServiciosOptions);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }
        });
    }



    function autoseleccionarEntidadLabor()
    {//se quito la auto seleccion por que se creo el campo de gerente regional

      var entidad= $("#idEndidadFederativa").val();
      $("#selectEndidadFederativaLabor").val(entidad);
      obtenerListaPuntosServiciosPorEntidad();

    }
     function bloquearElementosDatosFamiliares(){

      if ((datosGuardadosBeneficiario==1 && datosGuardadosPadre==1 && datosGuardadosMadre==1) || (datosGuardadosBeneficiario==0 && datosGuardadosPadre==1 && datosGuardadosMadre==1) || (datosGuardadosBeneficiario==1 && datosGuardadosPadre==0 && datosGuardadosMadre==0) )
      {
      $( "#btnGuardarDatosFamiliares" ).prop( "disabled", true );
      var elemento = document.getElementById("spanDatosFamiliares");
      elemento.className = "glyphicon glyphicon-ok";

      }
     }

    function generarCartaPatronal(){
      var entidadEmpleado=$("#numeroEmpleadoEntidad").val();
      var consecutivoEmpleado=$("#numeroEmpleadoConsecutivo").val();
      var tipoEmpleado=$("#numeroEmpleadoTipo").val();
      window.open("generadorCartaPatronal.php?entidadEmpleado="+entidadEmpleado+"&consecutivoEmpleado="+consecutivoEmpleado+"&tipoEmpleado="+tipoEmpleado+"",'Informe3','fullscreen=no');
      //parent.opener=top;
      //opener.close();
    }

    function generadorNuevaCredencial(){
      //alert("¡OPS! Estoy en construccion, aun no funciono pero quien me esta programando te notificara cuando este listo. Saludos :) ")
      var entidadEmpleado=$("#numeroEmpleadoEntidad").val();
      var consecutivoEmpleado=$("#numeroEmpleadoConsecutivo").val();
      var tipoEmpleado=$("#numeroEmpleadoTipo").val();
      window.open("generadorNuevaCredencial.php?entidadEmpleado="+entidadEmpleado+"&consecutivoEmpleado="+consecutivoEmpleado+"&tipoEmpleado="+tipoEmpleado+"",'Informe3','fullscreen=no');

    }

    function generarCartaPatronal2(){
      var entidadEmpleado=$("#numeroEmpleadoEntidad").val();
      var consecutivoEmpleado=$("#numeroEmpleadoConsecutivo").val();
      var tipoEmpleado=$("#numeroEmpleadoTipo").val();
      window.open("generadorCartaPatronal2.php?entidadEmpleado="+entidadEmpleado+"&consecutivoEmpleado="+consecutivoEmpleado+"&tipoEmpleado="+tipoEmpleado+"",'Informe3','fullscreen=no');
      //parent.opener=top;
      //opener.close();
    }
    function generarContratoSa1()
    {
      var entidadEmpleado=$("#numeroEmpleadoEntidad").val();
      var consecutivoEmpleado=$("#numeroEmpleadoConsecutivo").val();
      var tipoEmpleado=$("#numeroEmpleadoTipo").val();
      window.open("generadorContratoSa1.php?entidadEmpleado="+entidadEmpleado+"&consecutivoEmpleado="+consecutivoEmpleado+"&tipoEmpleado="+tipoEmpleado+"",'_blank','fullscreen=no');
     // parent.opener=top;
    }

    function generarContratoSa2()
    {
      var entidadEmpleado=$("#numeroEmpleadoEntidad").val();
      var consecutivoEmpleado=$("#numeroEmpleadoConsecutivo").val();
      var tipoEmpleado=$("#numeroEmpleadoTipo").val();
      window.open("generadorContratoSa2.php?entidadEmpleado="+entidadEmpleado+"&consecutivoEmpleado="+consecutivoEmpleado+"&tipoEmpleado="+tipoEmpleado+"",'_blank','fullscreen=no');
      //parent.opener=top;
      //opener.close();

    }

    function generarContratoSc()
    {
      var entidadEmpleado=$("#numeroEmpleadoEntidad").val();
      var consecutivoEmpleado=$("#numeroEmpleadoConsecutivo").val();
      var tipoEmpleado=$("#numeroEmpleadoTipo").val();
      window.open("generadorContratoSc.php?entidadEmpleado="+entidadEmpleado+"&consecutivoEmpleado="+consecutivoEmpleado+"&tipoEmpleado="+tipoEmpleado+"",'_blank','fullscreen=no');
      //parent.opener=top;
      //opener.close();

    }

    function generarHojaDatos()
    {
      var entidadEmpleado=$("#numeroEmpleadoEntidad").val();
      var consecutivoEmpleado=$("#numeroEmpleadoConsecutivo").val();
      var tipoEmpleado=$("#numeroEmpleadoTipo").val();
    //  alert(apellido);
      window.open("generadorHojaDatos.php?entidadEmpleado="+entidadEmpleado+"&consecutivoEmpleado="+consecutivoEmpleado+"&tipoEmpleado="+tipoEmpleado+"",'Informe2','fullscreen=no');
      parent.opener=top;

      /*
      var strPrimerApellido="RUIZ ESPARZA";
      var strSegundoAplido="GARCIA";
      var strNombre="LUCIA ITZEL";
      var strdia="03";
      var strmes="05";
      var stranio="1990";
      var sEntidadA="DF";
      var sSexoA="M";
*/
       //window.open("http://consultas.curp.gob.mx/CurpSP/curp1.do?strPrimerApellido=" & strPrimerApellido & "&strSegundoAplido=" & strSegundoAplido & "&strNombre=" & strNombre & "&strdia=" & strdia & "&strmes=" & strmes & "&stranio=" & stranio & "&sEntidadA=" & sEntidadA & "&sSexoA=" & sSexoA & "&strTipo=" & "A")
    }

    function generarCredencial()
    {
      var entidadEmpleado=$("#numeroEmpleadoEntidad").val();
      var consecutivoEmpleado=$("#numeroEmpleadoConsecutivo").val();
      var tipoEmpleado=$("#numeroEmpleadoTipo").val();
    //  alert(apellido);
      window.open("generadorCredencial.php?entidadEmpleado="+entidadEmpleado+"&consecutivoEmpleado="+consecutivoEmpleado+"&tipoEmpleado="+tipoEmpleado+"",'Informe3','fullscreen=no');
      //parent.opener=top;
      //opener.close();


    }

    function generarDocumentoBanco()
    {
      var entidadEmpleado=$("#numeroEmpleadoEntidad").val();
      var consecutivoEmpleado=$("#numeroEmpleadoConsecutivo").val();
      var tipoEmpleado=$("#numeroEmpleadoTipo").val();
      window.open("generadorDocumentoBanco.php?entidadEmpleado="+entidadEmpleado+"&consecutivoEmpleado="+consecutivoEmpleado+"&tipoEmpleado="+tipoEmpleado+"",'Informe3','fullscreen=no');
    }

function generadorFormatoDocumentosRecibidos()
    {
      var entidadEmpleado=$("#numeroEmpleadoEntidad").val();
      var consecutivoEmpleado=$("#numeroEmpleadoConsecutivo").val();
      var tipoEmpleado=$("#numeroEmpleadoTipo").val();
      var nombreCompleto=$("#apellidoPaternoEmpleado").val()+" "+ $("#apellidoMaternoEmpleado").val()+" "+$ ("#nombreEmpleado").val();
      window.open("generadorFormatoDocumentosRecibidos.php?entidadEmpleado="+entidadEmpleado+"&consecutivoEmpleado="+consecutivoEmpleado+"&tipoEmpleado="+tipoEmpleado+"&nombreCompleto="+nombreCompleto+"",'_blank','fullscreen=no');
    }

    function generadorCartaResponsiva()
    {
      var entidadEmpleado=$("#numeroEmpleadoEntidad").val();
      var consecutivoEmpleado=$("#numeroEmpleadoConsecutivo").val();
      var tipoEmpleado=$("#numeroEmpleadoTipo").val();
      var nombreCompleto=$("#apellidoPaternoEmpleado").val()+" "+ $("#apellidoMaternoEmpleado").val()+" "+$ ("#nombreEmpleado").val();
      window.open("generadorCartaResponsiva.php?entidadEmpleado="+entidadEmpleado+"&consecutivoEmpleado="+consecutivoEmpleado+"&tipoEmpleado="+tipoEmpleado+"&nombreCompleto="+nombreCompleto+"",'_blank','fullscreen=no');
    }

    function obtenerSupervisoresOperativos(){

       var puestoId = $("#tipoPuesto").val();
       var lineaNegocio = $("#selectLineaNegocio").val();
       if( puestoId=='03' && lineaNegocio==3){

      $.ajax({
            type: "POST",
            url: "ajax_obtenerListaSupervisoresOperativosTransporte.php",

            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                    var listaSupervisoresOperativos = response.listaSupervisoresOperativos;

                    responsableAsistencia = "<option>RESPONSABLE ASISTENCIA</option>";
                    for (var i = 0; i < listaSupervisoresOperativos.length; i++)
                    {
                      var numeroEmpleado=listaSupervisoresOperativos[i].entidadFederativaId+"-"+listaSupervisoresOperativos[i].empleadoConsecutivoId+"-"+listaSupervisoresOperativos[i].empleadoCategoriaId;
                        responsableAsistencia += "<option value='" + numeroEmpleado + "'>" + listaSupervisoresOperativos[i].nombre + "</option>";
                    }
                    $("#dirigente").html (responsableAsistencia);
                }
            },
            error: function (response)
            {
                console.log (response);
            }
        });
      }//fin if
     else if( puestoId=='03' && lineaNegocio==2){

      $.ajax({
            type: "POST",
            url: "ajax_obtenerListaSupervisoresOperativoselectronica.php",

            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                    var listaSupervisoresOperativos = response.listaSupervisoresOperativos;

                    responsableAsistencia = "<option>RESPONSABLE ASISTENCIA</option>";
                    for (var i = 0; i < listaSupervisoresOperativos.length; i++)
                    {
                      var numeroEmpleado=listaSupervisoresOperativos[i].entidadFederativaId+"-"+listaSupervisoresOperativos[i].empleadoConsecutivoId+"-"+listaSupervisoresOperativos[i].empleadoCategoriaId;
                        responsableAsistencia += "<option value='" + numeroEmpleado + "'>" + listaSupervisoresOperativos[i].nombre + "</option>";
                    }
                    $("#dirigente").html (responsableAsistencia);
                }
            },
            error: function (response)
            {
                console.log (response);
            }
        });
      }//fin if
    else if( puestoId=='03' && lineaNegocio==1){

      $.ajax({
            type: "POST",
            url: "ajax_obtenerListaSupervisoresOperativos.php",

            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                    var listaSupervisoresOperativos = response.listaSupervisoresOperativos;

                    responsableAsistencia = "<option>RESPONSABLE ASISTENCIA</option>";
                    for (var i = 0; i < listaSupervisoresOperativos.length; i++)
                    {
                      var numeroEmpleado=listaSupervisoresOperativos[i].entidadFederativaId+"-"+listaSupervisoresOperativos[i].empleadoConsecutivoId+"-"+listaSupervisoresOperativos[i].empleadoCategoriaId;
                        responsableAsistencia += "<option value='" + numeroEmpleado + "'>" + listaSupervisoresOperativos[i].nombre + "</option>";
                    }

                    $("#dirigente").html (responsableAsistencia);
                }
            },
            error: function (response)
            {
                console.log (response);
            }
        });
      }//fin if
      else{
        responsableAsistencia = "<option>NO APLICA</option>";
        $("#dirigente").html (responsableAsistencia);

      }
    }


function verificarTipoEmpleado(){
  var banderafolio=$("#inpbanderafoliopreseleccion").val();

    var puesto = $("#puesto").val();
    var gerente = $("#gerenteReg").val();

    //PUESTOS DE LOGISTICA Y OPERACION (VER EN NOMIGIF)
    if((puesto==6 || puesto==126 || puesto==93 || puesto==31 || puesto==144 || puesto==133 || puesto==44 || puesto==122 || puesto==117) && gerente==0){
      swal("ALTO","Seleccione el gerente regional","warning");
      return;
    }
    /*var tipoPuesto = $("#tipoPuesto").val();
    var clienteId=$("#txtClienteId").val();
    if (tipoPuesto=='03' && clienteId != 13 ){
      obtenerPlantillaPerfil();
    }
    else if (tipoPuesto=='02' || clienteId==13){
      guardarSubmit();
    }else*/
  if(banderafolio==0){
    alertmmsssgg="<div id='msgAlert' class='alert alert-danger'><strong>Verifique Folio Preseleción</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#alertMsg").html(alertmmsssgg);
    $(document).scrollTop(0);
    $('#msgAlert').delay(3000).fadeOut('slow');
  }else{
    guardarSubmit();
  } 
}

  function obtenerPlantillaPerfil()
    {
       //var mitexto = $("#tipoPuesto option:selected").text();
       var puestoPlantillaId  = $("#puesto").val();
       var tipoTurnoPlantillaId=$("#tipoTurno").val();
       var puntoServicioPlantillaId=$("#selectPuntoServicio").val();

       //alert("puesto:"+puestoPlantillaId+" turno:"+tipoTurnoPlantillaId+" genero "+generoElementoId+" puntoServicio"+ puntoServicioPlantillaId);
       //alert(puntoServicioPlantillaId);

       $.ajax({
            type: "POST",
            url: "ajax_consultaPlantillaPerfil.php",
            data: {"puestoPlantillaId": puestoPlantillaId, "tipoTurnoPlantillaId":tipoTurnoPlantillaId, "puntoServicioPlantillaId":puntoServicioPlantillaId},
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                    //var continuar = confirm (response.message);
                    var continuar = false;

                    if(response.confirm==0){
                      //alert(response.message);
                      $("#divMsg").append("<img src='img/warning.png'><h4>"+response.message+"</h4>");
                      $("#modalPlantillaNoDefinida").modal("show");
                    }
                    else if(response.confirm==1)
                    {
                          continuar = confirm(response.message);
                          continuar=false;//agregado para prueba quitar si no funciona
                          //alert("El elemento no fue contratado,por favor verifica los datos de pantilla a la que deseas asignar al elemento");
                          alertMsg100="<div id='msgAlert'class='alert alert-danger'><strong>El elemento no fue contratado,por favor verifica los datos de pantilla a la que deseas asignar al elemento</strong> <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#alertMsg").html(alertMsg100);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                    }
                    else if(response.confirm==2)
                    {
                      continuar=true;
                    }

                    if (continuar)
                    {
                        guardarSubmit();
                    }

                }else{
                  var continuar = confirm (response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
        });

    }

    function cerrarModalPlantillaNoDefinida()
    {
      document.getElementById("divMsg").innerHTML="";
      $("#modalPlantillaNoDefinida").modal("hide");
    }

function mostrarModalFirmaRegistro(){

  $('#modalFirmaR').modal();

}


function obtenerClienteByPuntoServicioId()
{
  var idPuntoServicio = $("#selectPuntoServicio").val();
  $("#tipoTurno").val("TURNO");  
  $("#selplantillaservicio").val("PLANTILLA"); 
  $.ajax({
    type: "POST",
    url: "ajax_obtenerClienteByPuntoServicio.php",
    data: {"idPuntoServicio":idPuntoServicio},
    dataType: "json",
    success: function(response) {
      if (response.status == "success")
      {
        var clienteId = response.lista[0].idClientePunto;
        $("#txtClienteId").val(clienteId);
      }
    },error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
  });
}

/////////////////////////////////////// Validacion Firma Salario Diario Empleado ///////////////////////////////////
$('#btnGenrarSalarioDiario').click(function(){
  var idtipoTurnoSD = $("#tipoTurno").val();
  var idPuestoSD = $("#puesto").val();
  var idPuntoServicioTabulador = $("#selectPuntoServicio").val();
  if(idPuestoSD == "PUESTO" || idPuestoSD == "" || idPuestoSD == null || idPuestoSD == "null" || idPuestoSD == "0"){
    swal("ALTO","Seleccione El PUESTO Para generar El Salario Diario","error");
  }else if(idPuntoServicioTabulador == "PUNTOS SERVICIOS" || idPuntoServicioTabulador =="" || idPuntoServicioTabulador == null || idPuntoServicioTabulador == "null" || idPuntoServicioTabulador == "0"){
    swal("ALTO","Seleccione El PUNTOS DE SERVICIO Para generar El Salario Diario","error");
  }else if(idtipoTurnoSD == "TURNO" || idtipoTurnoSD == "" || idtipoTurnoSD == null || idtipoTurnoSD == "null" || idtipoTurnoSD == "0"){
    swal("ALTO","Seleccione El TURNO Para generar El Salario Diario","error");
  }else{
    $.ajax({
      type: "POST",
      url: "ajax_obtenerTabuladorPorPuntos.php",
      data: {"idtipoTurnoSD":idtipoTurnoSD,"idPuestoSD":idPuestoSD,"idPuntoServicioTabulador":idPuntoServicioTabulador},
      dataType: "json",
      success: function(response) {
        if (response.status == "success")
        {
          if(response.datos.length > '0' ) {
            var sueldo = response.datos[0].sueldo;
            var PorcentajeDescuento = response.datos1[0].PorcentajeDescuento;
            var SueldoBaseDescuento = response.datos1[0].SueldoBaseDescuento;
            var SalarioDiarioDescuento = response.datos1[0].SalarioDiarioDescuento;
            $("#SueldoSalarioDiarioEmp").val(sueldo);
            var resta = sueldo- SueldoBaseDescuento;
            if(resta > 0){
              var MontoADescontar = sueldo*("."+PorcentajeDescuento);
              var  salarioDiario1 = sueldo-MontoADescontar; 
              var salarioDiario = salarioDiario1/30;
              $("#SalarioDiarioEmp").val(salarioDiario); 
            }else{
              $("#SalarioDiarioEmp").val(SalarioDiarioDescuento); 
            }
            var salarioDiarioBefore = $("#SalarioDiarioEmp").val(); 
            var salarioDiarioSplit =salarioDiarioBefore.split(".");
            var salarioDiariolength = salarioDiarioSplit.length;
            if(salarioDiariolength=="1"){$("#SalarioDiarioEmp").val(salarioDiarioBefore+".00");}


            $("#btnConfirmadoSalarioDiario").hide();
            $("#btnGenrarSalarioDiario").hide();
            $("#btnConfirmarSalarioDiario").show();
          }else{
            swal("ALTO","Este punto de servicio con este puesto no tiene un tabular ingresado, ingresele el tabular","error");
          }
        }
      },error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }
});

function LimpiarDatosTabuladorSalarioDiario(){
  $("#SalarioDiarioEmp").val("");
  $("#btnGenrarSalarioDiario").show();
  $("#btnConfirmarSalarioDiario").hide();
  $("#btnConfirmadoSalarioDiario").hide();
  $("#imgMalSalarioDiario").show();
  $("#imgBienSalarioDiario").hide();
  $("#NumEmpModalFirmaParaConfirmacionSalarioDiario").val("");
  $("#constraseniaFirmaParaConfirmacionSalarioDiarioEmpleado").val("");
  $("#constraseniaFirmaParaConfirmacionSalarioDiarioEmpleadoHidden").val("");
  $("#NumEmpModalFirmaParaConfirmacionSalarioDiariohidden").val("");
  var tipoPuestoBanderalimpia = $("#tipoPuesto").val();
  var LineaNegocio = $("#selectLineaNegocio").val();
  if(tipoPuestoBanderalimpia == "02" || LineaNegocio != "1"){
    $("#imgMalSalarioDiario").hide();
    $("#imgBienSalarioDiario").show();
    $("#btnConfirmadoSalarioDiario").show();
    $("#btnConfirmarSalarioDiario").hide();
    $("#btnGenrarSalarioDiario").hide();
  }
}

$('#btnConfirmarSalarioDiario').click(function(){
  $("#modalFirmaConfirmacionSalarioDiario").modal();
});

function RevisarFirmaInternaParaConfirmacionSalarioDiario(){
  var NumEmpModalBaja = $("#NumEmpModalFirmaParaConfirmacionSalarioDiario").val();
  var constraseniaFirma = $("#constraseniaFirmaParaConfirmacionSalarioDiarioEmpleado").val();
  if(NumEmpModalBaja==""){
    cargaerroresFirmaInternaParaCOnfirmaciosDeSD("El numero de empleado no puede estar vacio");
  }else if(constraseniaFirma==""){
    cargaerroresFirmaInternaParaCOnfirmaciosDeSD("Escriba la contraseña para continuar");
  }else{
    $.ajax({
      type: "POST",
      url: "ajax_getFirmaSolicitada.php",
      data: {"NumEmpModalBaja":NumEmpModalBaja,"constraseniaFirma":constraseniaFirma},
      dataType: "json",
      success: function(response) {
        if (response.status == "success")
        {
          var RespuestaLargo = response["datos"].length;
          if(RespuestaLargo == "0"){
            cargaerroresFirmaInternaParaCOnfirmaciosDeSD("La Contraseña ingresada es incorrecta favor de escribirla exactamente como la ingreso en el registro");
          }else{
            var contraseniaInsertadaCifrada =response.datos["0"].ContraseniaFirma;
            $("#constraseniaFirmaParaConfirmacionSalarioDiarioEmpleadoHidden").val(contraseniaInsertadaCifrada);
            $("#NumEmpModalFirmaParaConfirmacionSalarioDiariohidden").val(NumEmpModalBaja);
            $("#modalFirmaConfirmacionSalarioDiario").modal("hide");
            $("#NumEmpModalFirmaParaConfirmacionSalarioDiario").val("");
            $("#constraseniaFirmaParaConfirmacionSalarioDiarioEmpleado").val("");
            $("#imgMalSalarioDiario").hide();
            $("#imgBienSalarioDiario").show();
            $("#btnConfirmadoSalarioDiario").show();
            $("#btnConfirmarSalarioDiario").hide();
          }
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
    });
  }
}
function cargaerroresFirmaInternaParaCOnfirmaciosDeSD(mensaje){
  $('#errormodalConfirmacionSalarioDiario').fadeIn();
  msjerrorbaja="<div id='errormodalConfirmacionSalarioDiario1' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errormodalConfirmacionSalarioDiario").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errormodalConfirmacionSalarioDiario').delay(4000).fadeOut('slow'); 
}

function cancelarFirmaParaConfirmacionSalarioDiario(){

  $("#modalFirmaConfirmacionSalarioDiario").modal("hide");
  $("#NumEmpModalFirmaParaConfirmacionSalarioDiario").val("");
  $("#constraseniaFirmaParaConfirmacionSalarioDiarioEmpleado").val("");
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////

 function saveImageR(){

        var empleadoEntidad=$("#numeroEmpleadoEntidad").val();
        var empleadoConsecutivo=$("#numeroEmpleadoConsecutivo").val();
        var empleadoTipo=$("#numeroEmpleadoTipo").val();

        var canvas = document.getElementById("tools_sketchR");
        canvasData = canvas.toDataURL("image/png");

        $.ajax({
            type: "POST",
            url: "save.php",
            data:{"empleadoEntidad":empleadoEntidad,"imgData":canvasData, "empleadoConsecutivo":empleadoConsecutivo, "empleadoTipo":empleadoTipo},
            dataType: "json",
            async: false,
            success: function(response) {
                if (response.status == "success")
                {
                    //alert("correcto");

                    alertMsg1="<div id='msgAlertR' class='alert alert-success'><strong>Firma</strong>Firma guardada<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#divFirmaMsgR").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlertR').delay(3000).fadeOut('slow');
                    $('#modalFirmaR').modal('hide');
                    limpiarCanvasR();
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

      function limpiarCanvasR()
      {
          sketch_firmaR = null;
          $("#sketch_divR").html ();
          $("#sketch_divR").html ('<p>Dibuje firma del elemento…</p><canvas id="tools_sketchR" class="divTrFirma" width="900" height="350" ><td></canvas>');
          sketch_firmaR = $('#tools_sketchR').sketch();
      }

      function optionReclutador(){
          var lineaNegocio=$("#selectLineaNegocio").val();
          var tipoEmpleado=$("#tipoPuesto").val();

          if((lineaNegocio==1 || lineaNegocio==2 || lineaNegocio==3) && tipoEmpleado=='03'){

            $("#divMedioInformacion").html("");
            $("#divLblMedio").html("");
            mostrarOpcionReclutador();
            getReclutadoresSeguridadFisica();
             //getMediosInformacionVacante();
          }else if( (lineaNegocio==1 || lineaNegocio==2  || lineaNegocio==3) && tipoEmpleado=='02'){
            $("#divLbSelectSup").html("");
            $("#divSelectSub").html("");
            $("#divReclutador").html("");
            $("#divLblReclutador").html("");
            getMediosInformacionVacante();
          }
          /*else if( (lineaNegocio==1 || lineaNegocio==2 ) && tipoEmpleado=='03'){
            $("#divReclutador").html("");
            $("#divLblReclutador").html("");
            getMediosInformacionVacante();
          }*/
      }

      function getReclutadoresSeguridadFisica(){

        $.ajax({
              type: "POST",
              url: "ajax_getReclutadoresSeguridadFisica.php",

              dataType: "json",
              success: function(response) {
                  if (response.status == "success"){

                    var listaReclutadores = response.reclutadores;
                    var reclutadoresOptions="<select name='selectReclutador' id='selectReclutador' onChange='optionValue();'>";

                    for ( var i = 0; i < listaReclutadores.length; i++ ){
                      reclutadoresOptions += "<option value='" + listaReclutadores[i].reclutadorId + "'>" + listaReclutadores[i].nombre + "</option>";
                    }
                    reclutadoresOptions += "<option value='otro'>OTRO</option></select>";
                    $("#divReclutador").html (reclutadoresOptions);
                    $("#divLblReclutador").html("<label class='control-label2 label' for='medio'>Reclutador</label>");
                  }
              },
              error: function (response)
              {
                  console.log (response);
              }
          });

      }

      function mostrarOpcionReclutador(){
          var reclutadorTipo="<select name'selectTipoRec' id='selectTipoRec' onChange='cambiarOpcionReclutador();'>";
          reclutadorTipo+="<option>RECLUTADOR</option><option>SUPERVISOR</option></select>";
          $("#divSelectSub").html(reclutadorTipo);
          $("#divLbSelectSup").html("<label class='control-label2 label' for='selectTipoRec'>Tipo Reclutador</label>");
      }

      function cambiarOpcionReclutador(){
          var opcionRec=document.getElementById("selectTipoRec").selectedIndex;
          if(opcionRec == 0){
              getReclutadoresSeguridadFisica();
          }else{
              getSupervisoresRec();
          }
          $("#divMedioInformacion").html("");
          $("#divLblMedio").html("");

      }

      function getSupervisoresRec(){
          $.ajax({
              type: "POST",
              url: "ajax_obtenerListaSupervisoresOperativos.php",

              dataType: "json",
              success: function(response) {
                  if (response.status == "success"){
                    var listaSupervisores = response.listaSupervisoresOperativos;
                    var reclutadoresOptions="<select name='selectReclutador' id='selectReclutador' onChange='optionValue();'>";

                    for ( var i = 0; i < listaSupervisores.length; i++ ){
                      reclutadoresOptions += "<option value='" + listaSupervisores[i].supervisorId + "'>" + listaSupervisores[i].nombre + "</option>";
                    }
                    reclutadoresOptions += "<option value='otro'>OTRO</option></select>";
                    $("#divReclutador").html (reclutadoresOptions);
                    $("#divLblReclutador").html("<label class='control-label2 label' for='medio'>Supervisor</label>");
                  }
                  //console.log (response);
              },
              error: function (response)
              {
                  console.log (response);
              }
          });

      }

       function getMediosInformacionVacante(){
      $.ajax({
            type: "POST",
            url: "ajax_getMediosInformacionVacante.php",
            dataType: "json",
            async:false,
            success: function(response) {
                if (response.status == "success")

                {

                  var listaMediosInformacionVacante = response.mediosInformacion;
                  var mediosInformacionOptions="<select id='selectMedioInformacion' name='selectMedioInformacion'>";

                  for ( var i = 0; i < listaMediosInformacionVacante.length; i++ ){
                    mediosInformacionOptions += "<option value='" + listaMediosInformacionVacante[i].idMedio + "'>" + listaMediosInformacionVacante[i].nombreMedio + "</option>";
                  }
                  mediosInformacionOptions += "</select>";

                  $("#divLblMedio").html("<label class='control-label2 label' for='medio'>¿Comó se entero de GIF?</label>");
                  $("#divMedioInformacion").html (mediosInformacionOptions);
                }
                //console.log (response);
            },
            error: function (response)
            {
                console.log (response);
            }
        });

      }

      function optionValue(){
        var valSelectReclutador=$("#selectReclutador").val();

        if(valSelectReclutador=="otro"){
          getMediosInformacionVacante();

        }else{
          $("#divMedioInformacion").html("");
          $("#divLblMedio").html("");

        }
      }



  var sketch_firmaR;





  $(function() {

    sketch_firmaR = null;
          $("#sketch_divR").html ();

          $("#sketch_divR").html ('<p>Dibuje firma del elemento…</p><canvas id="tools_sketchR" class="divTrFirma" width="900" height="350" ><td></canvas>');


          sketch_firmaR = $('#tools_sketchR').sketch();

  });



       $( "#txtMunicipioNac" ).autocomplete({
            source: municipios
        });

         $('#selectPaisNacimiento').val(46);
         $("#fechaIngreso").val(currentDate);


  var dateToDisable = new Date();

  $('#fechaIngreso').datetimepicker({
  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',
  maxDate:  dateToDisable.setDate(dateToDisable.getDate()),
   //endDate: '+2d'
   minDate: currentDate,

  });

         jQuery("#checkMadre").attr('checked', true);

$(inicioRegEmp());  

function inicioRegEmp(){

  $("#documentoDigitalizado_7").prop("disabled",true);//se desabilitan los botones ya que estos archivos son cargados desde contrataciones AVISO INSCRIPCION IMSS
  $("#documentoDigitalizado_9").prop("disabled",true);//se desabilitan los botones ya que estos archivos son cargados desde contrataciones CEDULA SAT(RFC)
  $("#documentoDigitalizado_12").prop("disabled",true);//se desabilitan los botones ya que estos archivos son cargados desde contrataciones TICKET DE CUENTA
  llenarselbanco();
  CargarSelectoresDatosFiscales1();
  $('#inpbanderafoliopreseleccion').val(0);
  cambioFolio=0;
  $("#fotoEmpleado").html ("<img style='margin:0 auto;' src='img/person.png'/>");
  var fileFotoEmpleado = $("#fileFotoEmpleado");
  fileFotoEmpleado.fileinput({
    uploadUrl: "upload_fotoempleado.php", // server upload action
    uploadAsync: false,
    showUpload: false, // hide upload button
    showRemove: false, // hide remove button
    showPreview: false
  }).on("filebatchselected", function(event, files) {
    fileFotoEmpleado.fileinput("upload");
  }).on('filebatchuploadsuccess', function(event, data, previewId, index) {
    var form = data.form, files = data.files, extra = data.extra,
    response = data.response, reader = data.reader;
    if (response.status == "error")
    {
      alert (response.message);
      return;
    }
    $("#fotoEmpleado").html ("<img style='margin:0 auto;' src='thumbs/" + response.file + "'/>");
    $("#idFotoEmpleado").val (response.file);
  });
  <?php
  foreach ($documentos as $documento):
  ?>
    var $input_<?php echo $documento["idDocumento"]; ?> = $("#documentoDigitalizado_<?php echo $documento["idDocumento"]; ?>");
    $input_<?php echo $documento["idDocumento"]; ?>.fileinput({
      uploadUrl: "upload_documentodigitalizado.php", // server upload action
      uploadAsync: false,
      showUpload: false, // hide upload button
      showRemove: false, // hide remove button
      showPreview: false,
      uploadExtraData: function () {
        var data = {};
        data ["tipoDocumentoDigitalizado"] = <?php echo $documento["idDocumento"]; ?>;
        data ["numeroEmpleadoEntidad"] = $("#numeroEmpleadoEntidad").val ();
        data ["numeroEmpleadoConsecutivo"] = $("#numeroEmpleadoConsecutivo").val ();
        data ["numeroEmpleadoTipo"] = $("#numeroEmpleadoTipo").val ();
        return data;
      }
    }).on("filebatchselected", function(event, files) {
      $input_<?php echo $documento["idDocumento"]; ?>.fileinput("upload");
    }).on('filebatchuploadsuccess', function(event, data, previewId, index) {
      var form = data.form, files = data.files, extra = data.extra,
      response = data.response, reader = data.reader;
      if (response.status == "error")
      {
          alert (response.message);
          return;
      }
      var icons_area = $("#icons_documentos_<?php echo $documento["idDocumento"]; ?>");
      var documentos = "";
      for (var i = 0; i < response.documentos.length; i++)
      {
        documento = response.documentos[i];
        documentos += "<p><a href='download_file.php?id=" + documento.id + "'><img src='img/" + documento.icono + "' height='24px' width='24px'/>" + documento.nombreArchivo + "</a></p>";
      }
      icons_area.html (documentos);
    });
  <?php
  endforeach;
  ?>

}

  $('#txtBuscarPreseleccion').keydown(function(event){
       var keycode = (event.keyCode ? event.keyCode : event.which);
       var folio=$('#txtBuscarPreseleccion').val();
       cambioFolio=0;
      if(keycode == '13' && folio.length==7){
           //alert('consultar!');
           //AQUI VAMOS A CONSULTAR LA TABLA PRESELECCIÓN CON EL FOLIO
           consultarFolioRegistro(folio);

      }else if(keycode == '13' && folio.length!=7){
          alertMsg1="<div id='msgAlert' class='alert alert-error'>Error: El folio debe ser de 7 digitos<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
          $("#form_registrarEmpleado")[0].reset();
          $("#alertMsg").html(alertMsg1);
          $('#listaConsultaPreseleccion').html("");
          $(document).scrollTop(0);
          $('#msgAlert').delay(3000).fadeOut('slow');
          $('#inpbanderafoliopreseleccion').val(0);
          
      }else if(folio.length!=7){
          $('#listaConsultaPreseleccion').html("");
          $("#form_registrarEmpleado")[0].reset();
          $('#inpbanderafoliopreseleccion').val(0);
      }else if(keycode == '8'){
          $('#listaConsultaPreseleccion').html("");
          $("#form_registrarEmpleado")[0].reset();
          $('#inpbanderafoliopreseleccion').val(0);
      }
  });

  function consultarFolioRegistro(folio){
      $.ajax({
            type: "POST",
            url: "ajax_consultaFolioAspirante.php",
            data:{"folioAspirante":folio},
            dataType: "json",
            success: function(response) {
              console.log(response);
                if (response.status == "success")
                {
                    var aspirantes=response.aspirante;
                    if(aspirantes.length !=0 ){
                        cambioFolio=1;
                        $('#inpbanderafoliopreseleccion').val(1);
                        var preseleccionTable="<table class='table table-hover' id='tablePreseleccion'><thead><th>Nombre Completo</th><th>Edad</th><th>Puesto Solicitado</th><th>Expediente</th></thead><tbody>";
                        $("#selectMedioInformacion").empty();
                        getMediosInformacionVacante();
                        var nombre=aspirantes[0].nombrePreseleccion;
                        var apPaterno=aspirantes[0].apPaternoPreseleccion;
                        var apMaterno=aspirantes[0].apMaternoPreseleccion;
                        var puestoSolicitado=aspirantes[0].puestoPreseleccion;
                        var edad=aspirantes[0].edadPreseleccion;
                        var edoCivil=aspirantes[0].edoCivilPreseleccion;
                        var peso=aspirantes[0].pesoPreseleccion;
                        var estatura=aspirantes[0].estaturaPreseleccion;
                        var tallaCamisa=aspirantes[0].tallaCamisaPreseleccion;
                        var tallaPantalon=aspirantes[0].tallaPantalonPreseleccion;
                        var numCalzado=aspirantes[0].numCalzadoPreseleccion;
                        var genero=aspirantes[0].generoPreseleccion;
                        var tipoSangre=aspirantes[0].tipoSangrePreseleccion;
                        var fechaNac=aspirantes[0].fechaNacPreseleccion;
                        var entidadNac=aspirantes[0].entidadNacPreseleccion;
                        var codigoPostal=aspirantes[0].cpPreseleccion;
                        var calle=aspirantes[0].callePreseleccion;
                        var numeroC=aspirantes[0].numeroPreseleccion;
                        var telFijo=aspirantes[0].telFijoPreseleccion;
                        var telMovil=aspirantes[0].telMovilPreseleccion;
                        var email=aspirantes[0].emailPreseleccion;
                        var nImss=aspirantes[0].nImssPreseleccion;
                        var gradoEstudios=aspirantes[0].gradoEPreseleccion;
                        var padre=aspirantes[0].padrePreseleccion;
                        var madre=aspirantes[0].madrePreseleccion;
                        var nombreCompleto= nombre+" "+apPaterno+" "+apMaterno;
                        var licencia=aspirantes[0].licenciaPreseleccion;
                        var licenciapermanente=aspirantes[0].licenciapermanente; 
                        var idEntidadALaborar=aspirantes[0].idEntidadALaborar;
                        var idPuestoSeleccionado=aspirantes[0].idPuestoSeleccionado;
                      if(licencia==1){
                        $("#licenciaConducirsiEMp").prop('checked','cheked'); 
                         $("#trlicenciapermanente").show();
                         $("#trarchivolicencia").show();
                          $("#docdigitalizadoo3").val("");                     
                        if(licenciapermanente==1){
                            $("#licenciaConducirnopermanente").prop('checked','');
                            $("#licenciaConducirsipermanente").prop('checked','checked');
                            $("#numerolicencia").val("");
                            $("#trnumerolicencia").hide();
                            $("#trvigencialicencia").hide();
                            $("#inpfehavigencialicencia").val(""); 
                        }
                         if(licenciapermanente==0){
                            $("#numerolicencia").val(aspirantes[0].numlicenciapreseleccion);
                            $("#trnumerolicencia").show();
                            $("#trvigencialicencia").show();
                            $("#inpfehavigencialicencia").val(aspirantes[0].fechavigencialicencia); 
                            $("#licenciaConducirnopermanente").prop('checked','checked');
                            $("#licenciaConducirsipermanente").prop('checked','');
                          
                          }   
                      }else {
                        $("#licenciaConducirnoEMp").prop('checked','cheked'); 
                        $("#numerolicencia").val("");
                        $("#trnumerolicencia").hide();
                        $("#trvigencialicencia").hide();
                        $("#inpfehavigencialicencia").val("");
                        $("#licenciaConducirnopermanente").prop('checked','');
                        $("#licenciaConducirsipermanente").prop('checked','');
                        $("#trlicenciapermanente").hide();
                        $("#trarchivolicencia").hide();
                        $("#docdigitalizadoo3").val("");
                      }
                        //LLENADO DE DATOS GENERALES
                        $( "#apellidoPaternoEmpleado" ).val(apPaterno);
                        $( "#apellidoMaternoEmpleado" ).val(apMaterno);
                        $( "#nombreEmpleado" ).val(nombre);
                        $( "#numeroSeguroSocial").val(nImss);
                        $( "#tipoSangre").val(tipoSangre);
                        $( "#estaturaEmpleado").val(estatura);
                        $( "#tallaCEmpleado").val(tallaCamisa);
                        $( "#tallaPEmpleado").val(tallaPantalon);
                        $( "#numCalzadoEmpleado").val(numCalzado);
                        $( "#pesoEmpleado").val(peso);

                        //LLENADO DE DATOS FISCALES
                        $( "#CodigoPostalDatosFiscalesR" ).val(codigoPostal);
                        consultaCpDatosFiscales();

                        //LLENADO DE DATOS PERSONALES
                        $( "#txtFechaNacimiento" ).val(fechaNac);
                        $( "#selectEntidadNacimiento" ).val(entidadNac);
                        consultarMunicipiosPorEntidad();
                        $( "#selectEstadoCivil" ).val(edoCivil);
                        $( "#selectGradoEstudios").val(gradoEstudios);
                        $( "#selectTipoSangre").val(tipoSangre);

                        //LLENADO DE DATOS DE DIRECCION
                        $( "#txtCP" ).val(codigoPostal);
                        consultaCP();
                        $( "#txtCalle" ).val(calle);
                        $( "#txtNumeroExt" ).val(numeroC);
                        $( "#txtTelefonoMovil").val(telMovil);
                        $( "#txtTelefonoFijo").val(telFijo);
                        $( "#txtCorreo").val(email);

                        //DATOS MADRE Y PADRE
                        $( "#txtNombrePadre" ).val(padre);
                        $( "#txtNombreMadre").val(madre);

                        var solicitud="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-solicitud.png";
                        var testMedico="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-doctor.png";
                        var etico="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-etica.png";

                        var constancia="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-servicio.png";
                        var protesta="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-protesta.png";
                        var doping="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-doping.png";
                        var renuncia="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-renuncia.png";
                        var cCompromiso="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-compromiso.png";
                        var privacidad="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-privacidad.png";
                        var croquis="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-croquis.png";

                        preseleccionTable+="<tr><td>"+nombreCompleto+"</td><td>"+edad+" AÑOS</td><td>"+puestoSolicitado+"</td><td>";

                        preseleccionTable+="<button type='button' onClick='generarSolicitud(\""+folio+"\");'><img class='cursorImg' src='"+solicitud+"' data-toggle='tooltip' data-placement='right' title='SOLICITUD' ></button>";

                        preseleccionTable+="<button  type='button' onClick='generarTestMedico(\""+folio+"\");'><img class='cursorImg' src='"+testMedico+"' data-toggle='tooltip' data-placement='right' title='TEST MEDICO' ></button>";

                        preseleccionTable+="<button  type='button' onClick='generarPerfilEtico(\""+folio+"\");'><img class='cursorImg' src='"+etico+"' data-toggle='tooltip' data-placement='right' title='PERFIL ÉTICO' ></button>";

                        preseleccionTable+="<button  type='button' onClick='generarConstanciaServ(\""+folio+"\");'><img class='cursorImg' src='"+constancia+"' data-toggle='tooltip' data-placement='right' title='CONSTANCIA DE SERVICIO' ></button>";

                        preseleccionTable+="<button  type='button' onClick='generarProtesta(\""+folio+"\");'><img class='cursorImg' src='"+protesta+"' data-toggle='tooltip' data-placement='right' title='PROTESTA' ></button>";

                        preseleccionTable+="<button  type='button' onClick='generarDoping(\""+folio+"\");'><img class='cursorImg' src='"+doping+"' data-toggle='tooltip' data-placement='right' title='DOPING' ></button>";

                        preseleccionTable+="<button  type='button' onClick='generarRenuncia(\""+folio+"\");'><img class='cursorImg' src='"+renuncia+"' data-toggle='tooltip' data-placement='right' title='RENUNCIA' ></button>";

                        preseleccionTable+="<button  type='button' onClick='generarCartaCompromiso(\""+folio+"\");'><img class='cursorImg' src='"+cCompromiso+"' data-toggle='tooltip' data-placement='right' title='CARTA COMPROMISO' ></button>";

                        preseleccionTable+="<button  type='button' onClick='generarAvisoPrivacidad(\""+folio+"\");'><img class='cursorImg' src='"+privacidad+"' data-toggle='tooltip' data-placement='right' title='AVISO DE PRIVACIDAD' ></button>";

                        preseleccionTable+="<button  type='button' onClick='generarCroquis(\""+folio+"\");'><img class='cursorImg' src='"+croquis+"' data-toggle='tooltip' data-placement='right' title='CROQUIS' ></button>";

                        preseleccionTable+="</td></tr></tbody><table>";

                        $('#listaConsultaPreseleccion').html(preseleccionTable);

                        $('#listaConsultaPreseleccion').html(preseleccionTable);
                        if(idEntidadALaborar!="null" && idEntidadALaborar!="NULL" && idEntidadALaborar!=null && idEntidadALaborar!=""){
                          var IdMedio = 10; // Medio POSTULATE
                          $("#selectMedioInformacion").val(IdMedio);
                        }
                        $("#modalFirmaAltaEmpleado").modal();

                    }else{
                         alertMsg1="<div id='msgAlert' class='alert alert-error'>Error: No existe el Folio en Preselección<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                        $("#form_registrarEmpleado")[0].reset();
                        $("#alertMsg").html(alertMsg1);
                        $('#listaConsultaPreseleccion').html("");
                        cambioFolio=0;
                        $(document).scrollTop(0);
                        $('#msgAlert').delay(3000).fadeOut('slow');
                    }

                }
            },
             error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
            }
       });

  }

  function generarSolicitud(folio)
    {
      var folioA=folio;

    //  alert(apellido);
      window.open("generadorSolicitudEmpleo.php?folioAspirante="+folioA+"",'nombre','fullscreen=no');
     //
     //window.open("http://www.cnn.com/", "CNN_WindowName","menubar=yes,location=yes,resizable=yes,scrollbars=yes,status=yes");
      //parent.opener=top;
      //opener.close();

    }

    function generarTestMedico(folio){
      var folioAs=folio;
      window.open("generadorTestMedico.php?folioAspirante="+folioAs+"",'Informe3','fullscreen=no');
    }

    function generarPerfilEtico(folio){
      var folioAs=folio;
      window.open("generadorPerfilEtico.php?folioAspirante="+folioAs+"",'Informe3','fullscreen=no');
    }

    function generarConstanciaServ(folio){
      var folioAs=folio;
      window.open("generadorConstanciaServicio.php?folioAspirante="+folioAs+"",'Informe3','fullscreen=no');
    }

    function generarProtesta(folio){
      var folioAs=folio;
      window.open("generadorProtesta.php?folioAspirante="+folioAs+"",'Informe3','fullscreen=no');
    }

     function generarDoping(folio){
      var folioAs=folio;
      window.open("generadorPruebaDoping.php?folioAspirante="+folioAs+"",'Informe3','fullscreen=no');
    }

     function generarRenuncia(folio){
      var folioAs=folio;
      window.open("generadorVoluntaria.php?folioAspirante="+folioAs+"",'Informe3','fullscreen=no');
    }

    function generarCartaCompromiso(folio){
      var folioAs=folio;
      window.open("generadorCartaCompromiso.php?folioAspirante="+folioAs+"",'Informe3','fullscreen=no');
    }

    function generarAvisoPrivacidad(folio){
      var folioAs=folio;
      window.open("generadorAvisoPrivacidad.php?folioAspirante="+folioAs+"",'Informe3','fullscreen=no');
    }

    function generarCroquis(folio){
      var folioAs=folio;
      window.open("generadorCroquis.php?folioAspirante="+folioAs+"",'Informe3','fullscreen=no');
    }

    function generarCartaCompromisoMS(folio){
      var folioAs=folio;
      window.open("generadorCartaCompromisoMS.php?folioAspirante="+folioAs+"",'Informe3','fullscreen=no');
    }

    function actualizaDatosGeneralesPreseleccion(datos){

        $.ajax({
            type: "POST",
            url: "ajax_actualizaPersonalesPreseleccion.php",
            data: datos,
            dataType: "json",
            success: function(response) {
                if (response.status != "success")
                {
                    alert("Error al actualizar Preseleccion");
                }
            },
             error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
            }
       });
    }

    function actualizaDatosDireccionPreseleccion(datos){
        $.ajax({
            type: "POST",
            url: "ajax_actualizaDireccionPreseleccion.php",
            data: datos,
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                }else{
                    alert("Error al actualizar Direccion Preseleccion");
                }
            },
             error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
            }
       });
    }

    function llenarselbanco(){
     $.ajax({
            type: "POST",
            url: "ajax_getBancos.php",
            dataType: "json",
            success: function(response) {
                  $('#selbanco').append('<option value="0" selected="selected">BANCO</option>');
                if (response.status == "success")
                {
                  for (var i = 0; i < response.bancos.length; i++)
                  {
                   $('#selbanco').append('<option value="' + (response.bancos[i].idCuentaBanco) + '">' + response.bancos[i].nombreBanco + '</option>');
                  }

                }else{
                    alert("Error al cargar bancos");
                }
            },
             error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
            }
       });
    }


    $('#selbanco').change(function(){
        var banco=$("#selbanco").val();
       
        if(banco=='030'){
            $("#txtNumeroCta").attr("maxlength","12");
        }else if(banco=='012' || banco=='021'){
            $("#txtNumeroCta").attr("maxlength","10");
        }else if(banco=='014'){
            $("#txtNumeroCta").attr("maxlength","11");
        }else{
            $("#txtNumeroCta").attr("maxlength","14");
        }
    });


   

  $("#tipoTurno").change(function(){
    $('#selHorarioAlta').empty();
    var puestoPlantillaId  = $("#puesto").val();
    var tipoTurnoPlantillaId=$("#tipoTurno").val(); 
    var puntoServicioPlantillaId=$("#selectPuntoServicio").val();
    var tipoPuesto =  $("#tipoPuesto").val(); 
    LimpiarDatosTabuladorSalarioDiario();
    if(tipoTurnoPlantillaId==="TURNO" ){$("#selplantillaservicio").empty();}
    if( tipoTurnoPlantillaId == 4 && tipoPuesto=="02"){
      $.ajax({
        type: "POST",
        url: "ajax_ObtenerPlantillaParaAdmin.php",
        data: {"tipoTurnoPlantillaId":tipoTurnoPlantillaId,"puntoServicioPlantillaId":puntoServicioPlantillaId,"puestoPlantillaId":puestoPlantillaId},
        dataType: "json",
        success: function(response) { 
          datos = response.datos;
          $('#selplantillaservicio').empty().append('<option value="0" selected="selected">PLANTILLA</option>');
          $.each(datos, function(i) {
            $('#selplantillaservicio').append('<option value="' + response.datos[i].servicioPlantillaId + '">' + response.datos[i].DescripcioRolOP + '_' + response.datos[i].servicioPlantillaId +'</option>'); //verificar que rollo con esto
          });
          if($('#selplantillaservicio option').length ===1 ){
            // de no quedar opciones disponibles en el selector de servicios (solo existiria la opción 0), limpio la lista y coloco una opcion 0 con un mensaje.
              $('#selplantillaservicio').empty().append('<option value="0" selected="selected">No hay plantilla disponible.</option>');
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
        }
      });

    }else{
      $.ajax({
        type: "POST",
        url: "ajax_consultaplantillasparaselectorcontrataciones.php",
        data: {"puestoPlantillaId":puestoPlantillaId,"tipoTurnoPlantillaId":tipoTurnoPlantillaId,"puntoServicioPlantillaId":puntoServicioPlantillaId},
        dataType: "json",
        success: function(response) {
          datos = response.datos;
          $('#selplantillaservicio').empty().append('<option value="0" selected="selected">PLANTILLA</option>');
          $.each(datos, function(i) {
            $('#selplantillaservicio').append('<option value="' + response.datos[i].servicioPlantillaId + '">' + response.datos[i].DescripcioRolOP + '_' + response.datos[i].servicioPlantillaId +'</option>'); //verificar que rollo con esto
          });
          if($('#selplantillaservicio option').length === 1){
            // de no quedar opciones disponibles en el selector de servicios (solo existiria la opción 0), limpio la lista y coloco una opcion 0 con un mensaje.
            $('#selplantillaservicio').empty().append('<option value="0" selected="selected">No hay plantilla disponible.</option>');
          }                
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
        }
      });
    }
  });

$("#selplantillaservicio").change(function(){
  var PlantillaIdRol=$("#selplantillaservicio").val();
  var opcionTurno=document.getElementById("selplantillaservicio").selectedIndex
  var turno1 = document.getElementById("selplantillaservicio").options[opcionTurno].text;
  var turno2 = turno1.split("_");
  var turno =  turno2[0];
  $("#roloperativoTexto").val(turno);
  $.ajax({
    type: "POST",
    url: "ajax_ObtenerIdRolOperativoPorPlantilla.php",
    data: {"PlantillaIdRol":PlantillaIdRol},
    dataType: "json",
    success: function(response) {
      if(response.status=="success"){
        $("#idRolOpertaivoPorPlantillaAlta").val(response.datos[0].IdRolOperativoPlantilla);
      }else{
        alert("Error al obtener Rol operativo por plantilla");
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }
  });
  // obtenemos los horarios de la plantilla
  obtenerHorariosPorPlantilla(PlantillaIdRol);
  /////////////////////////////////////////
});

function obtenerHorariosPorPlantilla(idPlantilla){
  $.ajax({
    type: "POST",
    url: "HorariosAdmin/ajax_ConsultarCatalogoHorariosPorPlantilla.php",
    data: {idPlantilla},
    dataType: "json",
    success: function(response) {
      if (response.status == "success")
      {
        var datos = response.datos;
        for (var i = 0; i < datos.length; i++)
        {
          $('#selHorarioAlta').append('<option value="' + response.datos[i].idHorarios + '">' + response.datos[i].Jornada + '_ENTRADA: ' + response.datos[i].HoraEntrada + ' SALIDA: ' + response.datos[i].Horasalida +'</option>'); //verificar que rollo con esto
        }
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }
  });
}


$("#puesto").change(function(){
  $("#selplantillaservicio").val("PLANTILLA");
  $("#tipoTurno").val("TURNO");
  LimpiarDatosTabuladorSalarioDiario();
  var lineaNeg = $("#selectLineaNegocio").val();
  var entLaborar = $("#selectEndidadFederativaLabor").val();
  var puesto = $("#puesto").val();

  if(puesto!=6 && puesto!=126 && puesto!=93 && puesto!=31 && puesto!=144 && puesto!=133 && puesto!=44 && puesto!=122 && puesto!=117){
    $('#gerenteReg').empty().append('<option value="0" selected="selected">GERENTE REGIONAL</option>');
  }

  if((puesto==6 || puesto==126 || puesto==93 || puesto==31 || puesto==144 || puesto==133 || puesto==44 || puesto==122 || puesto==117) && lineaNeg !="LiNEA NEGOCIO" && entLaborar!="ENTIDAD FEDERATIVA"){
        cargarSelectorGerenteRegional(entLaborar,lineaNeg);
  }
});  


$("#selectEndidadFederativaLabor").change(function(){
  obtenerListaPuntosServiciosPorEntidad();
  var puesto = $("#puesto").val();
  var entLaborar = $("#selectEndidadFederativaLabor").val();
  var lineaNeg = $("#selectLineaNegocio").val();
  if(puesto==6 || puesto==126 || puesto==93 || puesto==31 || puesto==144 || puesto==133 || puesto==44 || puesto==122 || puesto==117){
    cargarSelectorGerenteRegional(entLaborar,lineaNeg);
  }
});  


function cargarSelectorGerenteRegional(entLaborar,lineaNeg){
  $.ajax({
        type: "POST",
        url: "ajax_ConsultarGerentesReg.php",
        data: {entLaborar,lineaNeg},
        dataType: "json",
        success: function(response) {
          datos = response.datos;
          $('#gerenteReg').empty().append('<option value="0" selected="selected">GERENTE REGIONAL</option>');
          
          $.each(datos, function(i) {
            $('#gerenteReg').append('<option value="' + datos[i].numeroEmpleado + '">' + datos[i].nombreEmpleado+'</option>'); //verificar que rollo con esto
          });

          if($('#gerenteReg option').length === 1){
            // de no quedar opciones disponibles en el selector de servicios (solo existiria la opción 0), limpio la lista y coloco una opcion 0 con un mensaje.
            $('#gerenteReg').empty().append('<option value="0" selected="selected">No hay gerentes en esta región actualmente.</option>');
          }                
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
        }
      });
}


$("#licenciaConducirsiEMp").click(function(){
$("#trarchivolicencia").show();
$("#docdigitalizadoo3").val("");
$("#trlicenciapermanente").show();
$("#trnumerolicencia").show();
$("#numerolicencia").val("");
$("#licenciaConducirnopermanente").prop('checked','');
$("#licenciaConducirsipermanente").prop('checked','checked');
});
$("#licenciaConducirnoEMp").click(function(){
$("#trlicenciapermanente").hide();
$("#trnumerolicencia").hide();
$("#numerolicencia").val("");
$("#trvigencialicencia").hide();
$("#inpfehavigencialicencia").val("");
$("#trarchivolicencia").hide();
$("#docdigitalizadoo3").val("");
$("#licenciaConducirnopermanente").prop('checked','checked');
$("#licenciaConducirsipermanente").prop('checked','');
});
$("#licenciaConducirsipermanente").click(function(){
$("#trnumerolicencia").show();
$("#numerolicencia").val("");
$("#trvigencialicencia").hide();
$("#inpfehavigencialicencia").val("");
});
$("#licenciaConducirnopermanente").click(function(){
$("#trnumerolicencia").show();
$("#numerolicencia").val("");
$("#trvigencialicencia").show();
$("#inpfehavigencialicencia").val("");
//$("#trarchivolicencia").show();
//$("#docdigitalizadoo3").val("");
});



$("#AntiguedadVacacionesSi").click(function(){
//alert($('input:radio[name=licenciaConducir]:checked').val());
$("#AntiguedadVacacionesNo").prop('checked','');
$("#AntiguedadVacacionesSi").prop('checked','checked');
$("#AntiguedadVacacionesSi").val("1");
$("#AntiguedadVacacionesNo").val("0");

});
$("#AntiguedadVacacionesNo").click(function(){
$("#AntiguedadVacacionesNo").prop('checked','checked');
$("#AntiguedadVacacionesSi").prop('checked','');
$("#AntiguedadVacacionesSi").val("0");
$("#AntiguedadVacacionesNo").val("1");
});

////////////////////////// Se Agrega Funciones Para La Tarjeta de Despensa ///////////////////////////////////

$("#TarjetaDespensaSi").click(function(){
  var idEndidadFederativaContratacion = $("#idSucursalIngreso").val();
  if(idEndidadFederativaContratacion == "0" || idEndidadFederativaContratacion == "" || idEndidadFederativaContratacion == "null" || idEndidadFederativaContratacion == null || idEndidadFederativaContratacion == "NULL" || idEndidadFederativaContratacion == "SUCURSAL")
  { 
    $("#TarjetaDespensaSi").prop('checked','');
    alert("Seleccione La Sucursal Antes De Asignar Una Tarjeta De Despensa");
  }else{
    ObtenerNumeroDeIutSiguiente();
    $("#txtnumeroIut").val("");
    $("#TarjetaDespensaNo").prop('checked','');
  }
});

$("#TarjetaDespensaNo").click(function(){
$("#TrIutTarjeta").hide();
$("#txtnumeroIut").val("");
$("#TarjetaDespensaSi").prop('checked','');
$("#TarjetaDespensaNo").prop('checked','checked');
});


function ObtenerNumeroDeIutSiguiente()
{
   $("#TrIutTarjeta").hide();
  var idEndidadFederativaContratacion = $("#idSucursalIngreso").val();
  $.ajax({
    type:"POST",
    url: "ajax_verificarIutTarjetaDespensa.php",
    data: {"idEndidadFederativaContratacion": idEndidadFederativaContratacion},
    dataType:"json",
    success: function(response){
     if(response.status=="success")
     {
        if(response.datos.length == "0")
        {
          $("#TarjetaDespensaSi").prop('checked','');
          alert("No Cuentas Con Tarjetas De Despensa En Esta Sucursal Favor De Solicitar Mas Al Encargado De Su Matriz!!");
        }else{
          $("#TarjetaDespensaSi").prop('checked','');
          var NumeroIUTObtenido = response.datos[0].idIutTarjeta; 
          var IdTarjetaDespensa = response.datos[0].IdTarjetaDespensa; 
          $("#txtNumeroIutModal").val(NumeroIUTObtenido);
          $("#idTarjetaDespensa").val(IdTarjetaDespensa);
          $("#modalTarjetaDeDespensa").modal();
        }
      }else{
        $("#txtNumeroIutModal").val("");
        $("#idTarjetaDespensa").val("");
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }
  }); 
}

function CambiarModalesParaValidacionDeContrase(){
  var ComentarioIut = $("#txtComentarioIut").val();
  var txtNumeroIutModal = $("#txtNumeroIutModal").val();
  if(ComentarioIut == "")
  { 
    alert("Ingresa El Motivo Del Cambio de Tarjeta Ya Que La Tarjeta "+ txtNumeroIutModal+" Quedará En Estatus Baja");
  }else{
    $("#modalFirmaElectronicaParaBajaTarjeta").modal();
    $("#modalTarjetaDeDespensa").modal("hide");
  }

}

function RevisarFirmaInternaParaBajaTarjeta(){

  var NumEmpModalBaja = $("#NumEmpModalFirmaParaBajaTarjeta").val();
  var constraseniaFirma = $("#constraseniaFirmaParaBajaTarjeta").val();
  if(NumEmpModalBaja==""){
   cargaerroresFirmaInternaBajaTarjetaDespensa("El numero de empleado no puede estar vacio");
  }else if(constraseniaFirma==""){
     cargaerroresFirmaInternaBajaTarjetaDespensa("Escriba la contraseña para continuar");
  }else{
    $.ajax({
      type: "POST",
      url: "ajax_getFirmaSolicitada.php",
      data: {"NumEmpModalBaja":NumEmpModalBaja,"constraseniaFirma":constraseniaFirma},
      dataType: "json",
      success: function(response) {
        if (response.status == "success")
        {
          var RespuestaLargo = response["datos"].length;
          if(RespuestaLargo == "0"){
            cargaerroresFirmaInternaBajaTarjetaDespensa("La Contraseña ingresada es incorrecta favor de escribirla exactamente como la ingreso en el registro");
          }else{
            var contraseniaInsertadaCifrada =response.datos["0"].ContraseniaFirma;
            $("#constraseniaFirmaParaBajaTarjetaHidden").val(contraseniaInsertadaCifrada);
            $("#NumEmpModalFirmaParaBajaTarjetahidden").val(NumEmpModalBaja);
            $("#modalFirmaElectronicaParaBajaTarjeta").modal("hide");
            ObtenerSiguienteIdTarjetaDespensa();
            $("#NumEmpModalFirmaParaBajaTarjeta").val("");
            $("#constraseniaFirmaParaBajaTarjeta").val("");
          }
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
    });
  }
}

function cargaerroresFirmaInternaBajaTarjetaDespensa(mensaje){
  $('#errorModalFirmaInternaParaBajaTarjeta').fadeIn();
  msjerrorbaja="<div id='errorModalFirmaInternaParaBajaTarjeta1' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errorModalFirmaInternaParaBajaTarjeta").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errorModalFirmaInternaParaBajaTarjeta').delay(4000).fadeOut('slow'); 
}

function ObtenerSiguienteIdTarjetaDespensa(){
  waitingDialog.show();
  var txtNumeroIutModal = $("#txtNumeroIutModal").val();
  var IdTarjetaDespensa = $("#idTarjetaDespensa").val();
  var idEndidadFederativaContratacion = $("#idSucursalIngreso").val();
  var contraseniaBajaTarjeta = $("#constraseniaFirmaParaBajaTarjetaHidden").val();
  var NumEmpBajaTarjeta = $("#NumEmpModalFirmaParaBajaTarjetahidden").val();
  var ComentarioIut = $("#txtComentarioIut").val();
  $.ajax({
    type:"POST",
    url: "ajax_ObatenerLaSigienteTarjetaDeDespensa.php",
    data: {"IdTarjetaDespensa": IdTarjetaDespensa,"idEndidadFederativaContratacion": idEndidadFederativaContratacion,"ComentarioIut": ComentarioIut,"contraseniaBajaTarjeta": contraseniaBajaTarjeta,"NumEmpBajaTarjeta": NumEmpBajaTarjeta},
    dataType:"json",
    success: function(response){
     if(response.status=="success")
     {
        if(response.datos.length == "0")
        {
          $("#TarjetaDespensaSi").prop('checked','');
          alert("No Cuentas Con Tarjetas De Despensa En Esta Sucursal Favor De Solicitar Mas Al Encargado De Su Matriz!!");
        }else{
          var NumeroIUTObtenido1 = response.datos[0].idIutTarjeta; 
          var IdTarjetaDespensa1 = response.datos[0].IdTarjetaDespensa; 
          $("#txtNumeroIutModal").val(NumeroIUTObtenido1);
          $("#idTarjetaDespensa").val(IdTarjetaDespensa1);
          $("#txtComentarioIut").val("");
          $("#modalTarjetaDeDespensa").modal();
          waitingDialog.hide();
        }
      }else{
        $("#txtNumeroIutModal").val("");
        $("#idTarjetaDespensa").val("");
        waitingDialog.hide();
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
      waitingDialog.hide();
    }
  });
}

function cancelarFirmaParaBajaTarjeta(){
  $("#modalFirmaElectronicaParaBajaTarjeta").modal("hide");
  $("#modalTarjetaDeDespensa").modal();
  $("#NumEmpModalFirmaParaBajaTarjeta").val("");
  $("#constraseniaFirmaParaBajaTarjeta").val("");
  $("#txtComentarioIut").val("");
}

function CambiarDeModalesIngresoEmpleado(){

  $("#NumEmpModalFirmaParaRegistrarEmpleado").val("");
  $("#constraseniaFirmaParaRegistrarEmpleado").val("");
  $("#modalFirmaElectronicaParaRegistrarEmpleado").modal();
  $("#modalTarjetaDeDespensa").modal("hide");
}

function RevisarFirmaInternaParaRegistrarEmpleado(){
  var NumEmpModalBaja = $("#NumEmpModalFirmaParaRegistrarEmpleado").val();
  var constraseniaFirma = $("#constraseniaFirmaParaRegistrarEmpleado").val();
 
 if(NumEmpModalBaja==""){
   cargaerroresFirmaInternaEnvioTarjetaRegistrarEmpleado("El numero de empleado no puede estar vacio");
  }else if(constraseniaFirma==""){
     cargaerroresFirmaInternaEnvioTarjetaRegistrarEmpleado("Escriba la contraseña para continuar");
  }else{
    $.ajax({
      type: "POST",
      url: "ajax_getFirmaSolicitada.php",
      data: {"NumEmpModalBaja":NumEmpModalBaja,"constraseniaFirma":constraseniaFirma},
      dataType: "json",
    success: function(response) {
      if (response.status == "success")
      {
        var RespuestaLargo = response["datos"].length;
        if(RespuestaLargo == "0"){
          cargaerroresFirmaInternaEnvioTarjetaRegistrarEmpleado("La Contraseña ingresada es incorrecta favor de escribirla exactamente como la ingreso en el registro");
        }else{
          var nombre = response.datos["0"].nombreEmpleado + " " + response.datos["0"].apellidoPaterno + " " + response.datos["0"].apellidoMaterno;
          var contraseniaInsertadaCifrada =response.datos["0"].ContraseniaFirma;
          $("#txtnumeroFirmaempleado").val(NumEmpModalBaja);
          $("#ContraseniaFirmaemp").val(contraseniaInsertadaCifrada);
          $("#NumEmpModalFirmaParaRegistrarEmpleado").val("");
          $("#constraseniaFirmaParaRegistrarEmpleado").val("");
          AsignarIutAEmpleado();
        }
         
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
    });
  }
}
function cargaerroresFirmaInternaEnvioTarjetaRegistrarEmpleado(mensaje){
  $('#errorModalFirmaInternaParaRegistrarEmpleado').fadeIn();
  msjerrorbaja="<div id='errorModalFirmaInternaParaRegistrarEmpleado1' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errorModalFirmaInternaParaRegistrarEmpleado").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errorModalFirmaInternaParaRegistrarEmpleado').delay(4000).fadeOut('slow'); 
}

function AsignarIutAEmpleado()
{
  var NumeroIutModal = $("#txtNumeroIutModal").val();
  $("#TrIutTarjeta").show();
  $("#txtnumeroIut").val(NumeroIutModal);
  $("#TarjetaDespensaSi").prop('checked','checked');
  $("#modalFirmaElectronicaParaRegistrarEmpleado").modal("hide");
  
}

function cancelarFirmaParaEnvioDeTarjetaParaRegistrarEmpleado(){
  $("#modalFirmaElectronicaParaRegistrarEmpleado").modal("hide");
  $("#modalTarjetaDeDespensa").modal();
  $("#NumEmpModalFirmaParaRegistrarEmpleado").val("");
  $("#constraseniaFirmaParaRegistrarEmpleado").val("");
}

$("#idSucursalIngreso").click(function(){
  $("#TrIutTarjeta").hide();
  $("#txtnumeroIut").val("");
  $("#TarjetaDespensaSi").prop('checked','');
  $("#TarjetaDespensaNo").prop('checked','checked');
  
});
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////// Funciones Datos Fiscales //////////////////////////////////////////////////


function CargarSelectoresDatosFiscales1(){
  CargaDeSelectoresDatosFiscales(1);
  CargaDeSelectoresDatosFiscales(2);
  CargaDeSelectoresDatosFiscales(3);
}

function CargaDeSelectoresDatosFiscales(Caso){
  $.ajax({
    type: "POST",
    url: "ajax_CargarSelectoresDatosFiscales.php",
    data: {"Caso": Caso},
    dataType: "json",
    async:false,
    success: function(response) {
      if (response.status == "success")
      {
        var datos1 = response.datos;
        if(Caso=="1"){
          entidadF = "<option value='0'>ENTIDADES</option>";
          for (var i = 0; i < datos1.length; i++)
          {
            entidadF += "<option value='" + datos1[i].idEntidadFederativa + "'>" + datos1[i].nombreEntidadFederativa + "</option>";
          }
          $("#EntidadDatosFiscalesR").html (entidadF);

        }else if(Caso=="2"){
          MunicipioF = "<option value='0'>MUNICIPIOS</option>";
          for (var i = 0; i < datos1.length; i++)
          {
            MunicipioF += "<option value='" + datos1[i].idMunicipio + "'>" + datos1[i].nombreMunicipio + "</option>";
          }
          $("#MunicipioDatosFiscalesR").html (MunicipioF);
        }else{
          LocalidadF = "<option value='0'>LOCALIDADES</option>";
          for (var i = 0; i < datos1.length; i++)
          {
            LocalidadF += "<option value='" + datos1[i].idAsentamiento + "'>" + datos1[i].nombreAsentamiento + "</option>";
          }
          $("#LocalidadDatosFiscalesR").html (LocalidadF);
        }
        
      }
    },
    error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
  });
}

function consultaCpDatosFiscales()
{
  var codigoPostal = $("#CodigoPostalDatosFiscalesR").val ();
  $("#multipleDireccionesDatosFiscalesR").html ("");
  setDatosFiscalesData ("0","0","0","");
  if (codigoPostal.length != 5)
  {
    return;
  }
  waitingDialog.show();
  CargarSelectoresDatosFiscales1();
  $.ajax({
    type: "POST",
    url: "ajax_obtenerDirecciones.php",
    data: {txtCP : codigoPostal},
    dataType: "json",
    success: function(response) {
      if (response.listaDirecciones.length == 0)
      {
        $.notify("El código postal es inválido", {autoHideDelay: 3000, className: 'error'});
        waitingDialog.hide();
        return;
      }
      else if (response.listaDirecciones.length == 1)
      {
        var direccion = response.listaDirecciones [0];
        setDatosFiscalesData (direccion.idEntidadFederativa,direccion.idMunicipio,direccion.idAsentamiento,direccion.nombreAsentamiento);
        waitingDialog.hide();
      }
      else
      {
        var displayDirecciones = "";
        for (var i = 0; i < response.listaDirecciones.length; i++)
        {
          var direccion = response.listaDirecciones [i];
          var params = "\"" + direccion.idEntidadFederativa + "\"," +"\"" + direccion.idMunicipio + "\"," +"\"" + direccion.idAsentamiento + "\"," +"\"" + direccion.nombreAsentamiento + "\"";
          displayDirecciones += "<p>" + (i + 1) + "<a href='javascript:setDatosFiscalesData(" + params + ")';>" +direccion.nombreTipoAsentamiento + " " +direccion.nombreAsentamiento + " " +direccion.nombreMunicipio + ", " +direccion.nombreEntidadFederativa + "</a></p>";
        }
        $("#multipleDireccionesDatosFiscalesR").html (displayDirecciones);
        waitingDialog.hide();
      }
    },
    error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
      waitingDialog.hide();
    }
  });
}

function setDatosFiscalesData (idEntidadFederativa, idMunicipio, idAsentamiento, nombreAsentamiento)
{
    $("#EntidadDatosFiscalesR").val(idEntidadFederativa);
    $("#MunicipioDatosFiscalesR").val(idMunicipio);
    $("#LocalidadDatosFiscalesR").val(idAsentamiento);
    $("#ColoniaDatosFiscalesR").val(nombreAsentamiento);
}

$('#EntidadDatosFiscalesR').change(function(){
  waitingDialog.show();
  $("#multipleDireccionesDatosFiscalesR").html ("");
  var EntidadDatosFiscales=$("#EntidadDatosFiscalesR").val(); 
  $("#MunicipioDatosFiscalesR").empty();
  $("#LocalidadDatosFiscalesR").empty();
  $("#ColoniaDatosFiscalesR").val("");
  $("#CodigoPostalDatosFiscalesR").val("");
  $.ajax({
    type: "POST",
    url: "ajax_SelectMunicipioDatosFiscales.php",
    data: {"EntidadDatosFiscales": EntidadDatosFiscales},
    dataType: "json",
    async:false,
    success: function(response) {
      if (response.status == "success")
      {
        var datos1 = response.datos;
        municipioPorEntidad = "<option value='0'>MUNICIPIO</option>";
        for (var i = 0; i < datos1.length; i++)
        {
          municipioPorEntidad += "<option value='" + datos1[i].idMunicipio + "'>" + datos1[i].nombreMunicipio + "</option>";
        }
        $("#MunicipioDatosFiscalesR").html (municipioPorEntidad);
        waitingDialog.hide();
      }else{
        waitingDialog.hide();
      }
    },
    error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
      waitingDialog.hide();
    }
  });
});

$('#MunicipioDatosFiscalesR').change(function(){
  waitingDialog.show();
  var MunicipioDatosFiscales=$("#MunicipioDatosFiscalesR").val(); 
  $("#LocalidadDatosFiscalesR").empty();
  $("#ColoniaDatosFiscalesR").val("");
  $.ajax({
    type: "POST",
    url: "ajax_SelectLocalidadDatosFiscales.php",
    data: {"MunicipioDatosFiscales": MunicipioDatosFiscales},
    dataType: "json",
    async:false,
    success: function(response) {
      if (response.status == "success")
      {
        var datos1 = response.datos;
        Localidad = "<option value='0'>LOCALIDADES</option>";
          for (var i = 0; i < datos1.length; i++)
          {
            Localidad += "<option value='" + datos1[i].idAsentamiento + "'>" + datos1[i].nombreAsentamiento + "</option>";
          }
          $("#LocalidadDatosFiscalesR").html (Localidad);
          waitingDialog.hide();
      }else{
        waitingDialog.hide();
      }
    },
    error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
      waitingDialog.hide();
    }
  });
});

$('#LocalidadDatosFiscalesR').change(function(){
  waitingDialog.show();
  var LocalidadDatosFiscales=$("#LocalidadDatosFiscalesR").val(); 
  var LocalidadDatosFiscalesTest = $("#LocalidadDatosFiscalesR option:selected").text();
  $("#ColoniaDatosFiscalesR").val(LocalidadDatosFiscalesTest);
  $.ajax({
    type: "POST",
    url: "ajax_ObtenerCpFiscal.php",
    data: {"LocalidadDatosFiscales": LocalidadDatosFiscales},
    dataType: "json",
    async:false,
    success: function(response) {
      if (response.status == "success")
      {
        var codigpostalcreado = response.datos[0].codigoPostalAsentamiento;
        $("#CodigoPostalDatosFiscalesR").val(codigpostalcreado);
        waitingDialog.hide();
      }else{
        waitingDialog.hide();
      }
    },
    error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
      waitingDialog.hide();
    }
  });
});

$('#GuardarDatosFiscalesR').click(function(){
  var FolioPreseleccionDatosFiscales = $("#txtBuscarPreseleccion").val();
  var CodigoPostalDatosFiscales = $("#CodigoPostalDatosFiscalesR").val();
  var EntidadDatosFiscales = $("#EntidadDatosFiscalesR").val();
  var MunicipioDatosFiscales = $("#MunicipioDatosFiscalesR").val();
  var LocalidadDatosFiscales = $("#LocalidadDatosFiscalesR").val();
  var ColoniaDatosFiscales = $("#ColoniaDatosFiscalesR").val();
  var VialidadDatosFiscales = $("#VialidadDatosFiscalesR").val();
  var TipoVidalidadDatosFiscales = $("#TipoVidalidadDatosFiscalesR").val();
  var NumExternoDatosFiscales = $("#NumExternoDatosFiscalesR").val();
  var NumInternoDatosFiscales = $("#NumInternoDatosFiscalesR").val();
  var EstadoDoicilioDatosFiscales = $("#EstadoDoicilioDatosFiscalesR").val();

  if(FolioPreseleccionDatosFiscales==""){
    erroresDatosFiscales("Ingrese El Folio De Preselección Para Continuar","error");
  }else if(CodigoPostalDatosFiscales==""){
    erroresDatosFiscales("Ingrese El Código Postal Correcto De La Cedúla De Situación Fiscal","error");
  }else if(EntidadDatosFiscales=="" || EntidadDatosFiscales=="0"){
    erroresDatosFiscales("Seleccione La Entidad Federativa Correcta De La Cedúla De Situación Fiscal","error");
  }else if(MunicipioDatosFiscales=="" || MunicipioDatosFiscales=="0"){
    erroresDatosFiscales("Seleccione El Municipio Correcto De La Cedúla De Situación Fiscal","error");
  }else if(LocalidadDatosFiscales=="" || LocalidadDatosFiscales=="0"){
    erroresDatosFiscales("Seleccione La Localidad Correcta De La Cedúla De Situación Fiscal","error");
  }else if(ColoniaDatosFiscales==""){
    erroresDatosFiscales("Ingrese La Colonia De La Cedúla De Situación Fiscal","error");
  }else if(VialidadDatosFiscales==""){
    erroresDatosFiscales("Ingrese El Nombre De La Vialidad Correcta De La Cedúla De Situación Fiscal","error");
  }else if(TipoVidalidadDatosFiscales==""){
    erroresDatosFiscales("Ingrese El Tipo De La Vialidad Correcta De La Cedúla De Situación Fiscal","error");
  }else if(NumExternoDatosFiscales==""){
    erroresDatosFiscales("Ingrese El Número Exterior Correcto De La Cedúla De Situación Fiscal","error");
  }else if(NumInternoDatosFiscales==""){
    erroresDatosFiscales("Ingrese El Número Interior Correcto De La Cedúla De Situación Fiscal","error");
  }else if(EstadoDoicilioDatosFiscales==""){
    erroresDatosFiscales("Ingrese El Estado De Domicilio Correcto De La Cedúla De Situación Fiscal","error");
  }else{
    $.ajax({
      type: "POST",
      url: "ajax_ObtenerEmpleadoSiExisteParaDatosFiscales.php",
      data: {"FolioPreseleccionDatosFiscales": FolioPreseleccionDatosFiscales},
      dataType: "json",
      async:false,
      success: function(response) {
        if (response.status == "success")
        {
          var LargoDatos = response.datos.length;
          if(LargoDatos=="0"){
            waitingDialog.hide();
            erroresDatosFiscales("Debe Realizar El Registro De DATOS GENERALES Antes De Registrar Los Datos Fiscales Del Empleado","error");
          }else{
            var entidadFederativaId = response.datos[0].entidadFederativaId;
            var empleadoConsecutivoId = response.datos[0].empleadoConsecutivoId;
            var empleadoCategoriaId = response.datos[0].empleadoCategoriaId;
            RegistrarDatosFiscales(FolioPreseleccionDatosFiscales,CodigoPostalDatosFiscales,EntidadDatosFiscales,MunicipioDatosFiscales,LocalidadDatosFiscales,ColoniaDatosFiscales,VialidadDatosFiscales,TipoVidalidadDatosFiscales,NumExternoDatosFiscales,NumInternoDatosFiscales,EstadoDoicilioDatosFiscales,entidadFederativaId,empleadoConsecutivoId,empleadoCategoriaId);
          }
        }else{
          waitingDialog.hide();
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
        waitingDialog.hide();
      }
    });
  }
});

function RegistrarDatosFiscales(FolioPreseleccionDatosFiscales,CodigoPostalDatosFiscales,EntidadDatosFiscales,MunicipioDatosFiscales,LocalidadDatosFiscales,ColoniaDatosFiscales,VialidadDatosFiscales,TipoVidalidadDatosFiscales,NumExternoDatosFiscales,NumInternoDatosFiscales,EstadoDoicilioDatosFiscales,entidadFederativaId,empleadoConsecutivoId,empleadoCategoriaId){
  var caso = "Registro";
  $.ajax({
    type: "POST",
    url: "ajax_registroDatosFiscales.php",
    data: {"FolioPreseleccionDatosFiscales":FolioPreseleccionDatosFiscales,"CodigoPostalDatosFiscales":CodigoPostalDatosFiscales,"EntidadDatosFiscales":EntidadDatosFiscales,"MunicipioDatosFiscales":MunicipioDatosFiscales,"LocalidadDatosFiscales":LocalidadDatosFiscales,"ColoniaDatosFiscales":ColoniaDatosFiscales,"VialidadDatosFiscales":VialidadDatosFiscales,"TipoVidalidadDatosFiscales":TipoVidalidadDatosFiscales,"NumExternoDatosFiscales":NumExternoDatosFiscales,"NumInternoDatosFiscales":NumInternoDatosFiscales,"EstadoDoicilioDatosFiscales":EstadoDoicilioDatosFiscales,"entidadFederativaId":entidadFederativaId,"empleadoConsecutivoId":empleadoConsecutivoId,"empleadoCategoriaId":empleadoCategoriaId,"caso":caso},
    dataType: "json",
    async:false,
    success: function(response) {
      var mensaje=response.message;
      if (response.status=="success") {
        erroresDatosFiscales(mensaje,"success");
        LimpiarFormularioDatosFicales();
        waitingDialog.hide();
      }else if (response.status=="error"){
        erroresDatosFiscales(mensaje,"error");
        waitingDialog.hide();
      }else{
        waitingDialog.hide();
      }
    },error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
        waitingDialog.hide();
    }
  });
}

function erroresDatosFiscales(mensaje,tipo){
  $('#MesjaeErrorDatosFiscales').fadeIn();
  msjerrorbaja="<div id='MesjaeErrorDatosFiscales1' class='alert alert-"+tipo+"'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";         
  $("#MesjaeErrorDatosFiscales").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#MesjaeErrorDatosFiscales').delay(4000).fadeOut('slow');
}

function LimpiarFormularioDatosFicales(){
  $("#CodigoPostalDatosFiscalesR").val("");
  $("#EntidadDatosFiscalesR").val(0);
  $("#MunicipioDatosFiscalesR").val(0);
  $("#LocalidadDatosFiscalesR").val(0);
  $("#ColoniaDatosFiscalesR").val("");
  $("#VialidadDatosFiscalesR").val("");
  $("#TipoVidalidadDatosFiscalesR").val("");
  $("#NumExternoDatosFiscalesR").val("");
  $("#NumInternoDatosFiscalesR").val("");
  $("#EstadoDoicilioDatosFiscalesR").val(0);
}


/////////////////////////////////////// Validacion Firma Alta Empleado ///////////////////////////////////
function RevisarFirmaInternaParaAltaEmpleado(){
  var NumEmpModalBaja = $("#NumEmpModalFirmaParaFirmaAltaEmpleado").val();
  var constraseniaFirma = $("#constraseniaFirmaParaParaFirmaAltaEmpleado").val();
  if(NumEmpModalBaja==""){
    cargaerroresFirmaInternaAltaEmpleado("El numero de empleado no puede estar vacio");
  }else if(constraseniaFirma==""){
    cargaerroresFirmaInternaAltaEmpleado("Escriba la contraseña para continuar");
  }else{
    $.ajax({
      type: "POST",
      url: "ajax_getFirmaSolicitada.php",
      data: {"NumEmpModalBaja":NumEmpModalBaja,"constraseniaFirma":constraseniaFirma},
      dataType: "json",
      success: function(response) {
        if (response.status == "success")
        {
          var RespuestaLargo = response["datos"].length;
          if(RespuestaLargo == "0"){
            cargaerroresFirmaInternaAltaEmpleado("La Contraseña ingresada es incorrecta favor de escribirla exactamente como la ingreso en el registro");
          }else{
            var contraseniaInsertadaCifrada =response.datos["0"].ContraseniaFirma;
            $("#constraseniaFirmaParaParaFirmaAltaEmpleadoHidden").val(contraseniaInsertadaCifrada);
            $("#NumEmpModalFirmaParaFirmaAltaEmpleadohidden").val(NumEmpModalBaja);
            $("#modalFirmaAltaEmpleado").modal("hide");
            $("#NumEmpModalFirmaParaFirmaAltaEmpleado").val("");
            $("#constraseniaFirmaParaParaFirmaAltaEmpleado").val("");
          }
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
    });
  }
}

function cargaerroresFirmaInternaAltaEmpleado(mensaje){
  $('#errormodalFirmaAltaEmpleado').fadeIn();
  msjerrorbaja="<div id='errormodalFirmaAltaEmpleado1' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errormodalFirmaAltaEmpleado").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errormodalFirmaAltaEmpleado').delay(4000).fadeOut('slow'); 
}

function cancelarFirmaParaAltaEmpleado(){

  $("#modalFirmaAltaEmpleado").modal("hide");
  $("#NumEmpModalFirmaParaFirmaAltaEmpleado").val("");
  $("#constraseniaFirmaParaParaFirmaAltaEmpleado").val("");
}

function mostrarModalFirmaALtaEmpleado(){
  $("#modalFirmaAltaEmpleado").modal();
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////

function GetSucursalesIngresadasRegistro(){
  var EndidadFederativa = $("#idEndidadFederativa").val();
    $.ajax({
      type: "POST",
      url: "ajax_getSucursalesIngresadas.php",
      data: {"EndidadFederativa": EndidadFederativa},
      dataType: "json",
      async:false,
      success: function(response) {
        //console.log(response.placas);
        $("#idSucursalIngreso").empty();
        $('#idSucursalIngreso').append('<option value="0">SUCURSAL</option>');
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#idSucursalIngreso').append('<option value="' + (response.datos[i].idSucursalI) + '">' + response.datos[i].nombreSucursal + '</option>');
          }
        }else{
          alert("Error al cargar datos");
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }



///////////////////////////////////////////////////////////////////////////////////////////////////////////////


$("#idEndidadFederativa").change(function(){
  var tipoPuesto=$("#tipoPuesto").val();
  seleccionarEntidadFederativa();
  // clearTipoPuesto();
  // autoseleccionarEntidadLabor(); 
  GetSucursalesIngresadasRegistro();
  
  if(tipoPuesto!="TIPO PUESTO"){
    obtenerUltimoNumeroEmpleado();
  }
});


function GuardarMovimientoPlantillaHistoricoIngreso(TipoMovimiento){
  var idPlantillaSeleccionada = $("#selplantillaservicio").val();
  var PuntoServicioSeleccionado = $("#selectPuntoServicio").val();
  var EntidadEmp = $("#numeroEmpleadoEntidad").val();
  var CategoriaEmp = $("#numeroEmpleadoConsecutivo").val();
  var TipoEmp = $("#numeroEmpleadoTipo").val();
  var idHorarioAlta = $("#selHorarioAlta").val();
  $.ajax({
    type: "POST",
    url: "ajax_RegistrarHistoricoMovPorPlantilla.php", 
    data: {"idPlantillaSeleccionada":idPlantillaSeleccionada,"PuntoServicioSeleccionado":PuntoServicioSeleccionado,"EntidadEmp":EntidadEmp,"CategoriaEmp":CategoriaEmp,"TipoEmp":TipoEmp,"TipoMovimiento":TipoMovimiento,"idHorarioPlantilla":idHorarioAlta},
    dataType: "json",
    async:false,
    success: function(response) {
      if (response.status != "success")
      {   
      }else{
        alert(response.message);
      }
    },error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
  });
}
</script>