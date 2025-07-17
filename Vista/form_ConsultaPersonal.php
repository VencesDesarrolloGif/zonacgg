<div class="container" align="center">

  <form class="form-horizontal"  method="post" name='form_EditaEmpleado' id="form_EditaEmpleado" enctype="multipart/form-data">
    <input type="text" name="txtSearch" id="txtSearch"class="search-query" placeholder="Buscar  (00-0000-00)" aria-describedby="basic-addon2" onkeyup="verificaConsultaEmpleado();" onblur=""><img src="img/search.png">
    <input type="text" name="txtSearchName" id="txtSearchName"class="input-xlarge" placeholder="APELLIDOS NOMBRE(S)" aria-describedby="basic-addon2" ><img src="img/search.png">

    <input type="hidden" name="txtfechaquitarantesubirloscambios" id="txtfechaquitarantesubirloscambios"class="input-xlarge" placeholder="fecha de prueba" aria-describedby="basic-addon2" >

    <div id="listaDePersonalActivo" >

    </div>

  </br>


  <fieldset >

    <div class="tabbable">
      <ul class="nav nav-tabs" >

        <li id="Dgenerales"><a id="containerDatosGeneralesEdited1" href="#containerDatosGeneralesEdited" data-toggle="tab">Datos Generales<span id="spanDatosGenerales" class="glyphicon glyphicon-pencil"></span></a></li>
        <li id="DFiscales"><a id="containerDatosFiscalesEdited1" href="#containerDatosFiscalesEdited" data-toggle="tab">Datos Fiscales <span id="spanDatosFiscales" class="glyphicon glyphicon-pencil"></span></a></li>
        <li id="Dpersonales"><a id="containerDatosPersonalesEdited1" href="#containerDatosPersonalesEited" data-toggle="tab">Datos Personales <span id="spanDatosPersonales" class="glyphicon glyphicon-pencil"></span></a></li>
        <li id="Directorio"><a id="containerDirectorioEdited1" href="#containerDirectorioEdited" data-toggle="tab">Directorio <span id="spanDatosDireccion" class="glyphicon glyphicon-pencil"></span></a></li>
        <li id="Familiares"><a id="containerDatosFamiliaresEdited1" href="#containerDatosFamiliaresEdited" data-toggle="tab">Beneficiarios <span id="spanDatosFamiliares" class="glyphicon glyphicon-pencil"></span></a></li>
        <?php
        if ($usuario["rol"] =="Administrador" || $usuario["rol"] =="Contrataciones" || $usuario["rol"] =="Lider Unidad" || $usuario["rol"] =="Laborales" )
        {
          ?>


          <li id="Familiares"><a id="containerDocumentosDigitalizadosTab1" href="#containerDocumentosDigitalizadosEdited" data-toggle="tab">Documentos Digitalizados </a></li>

          <?php
        }
        ?>
        <li id="formatos"><a id="containerFormatosTab1" href="#containerFormatosEdited" data-toggle="tab">Generacion de Formatos </a></li>

      </ul>
    </div>

    <div class="tab-content">

      <!--Div datos generales -->
      <div align="center" class="tab-pane active" id="containerDatosGeneralesEdited" >
        <legend><h3>Datos Generales</h3></legend>
        <input id="inppuntoServicioanterior" name="inppuntoServicioanterior" type="hidden">
        <input id="inpestatusoperaciones"    name="inpestatusoperaciones" type="hidden">

        <table class="table1"> 
          <tr>
            <td><label class="control-label label " for="numeroEmpleado">N. Empleado</label> </td>
            <td> <input id="numeroEmpleadoEntidadEdited" name="numeroEmpleadoEntidadEdited" type="text" placeholder="00" class="input-mini-mini" maxlength="2" readonly>-
              <input id="numeroEmpleadoConsecutivoEdited" name="numeroEmpleadoConsecutivoEdited" type="text" placeholder="0000" class="input-small-mini" maxlength="4" readonly> -
              <input id="numeroEmpleadoTipoEdited" name="numeroEmpleadoTipoEdited" type="text" placeholder="00" class="input-mini-mini" maxlength="2" readonly>
            </td>

            <td ROWSPAN="8" valign="top" width="50%" style="padding:25px;">
              <div>Foto:</div>
              <div id="fotoEmpleadoEdited" style="width:150px;height:133px;border:1px solid;text-align:center;"></div>
              <input type="hidden" name="idFotoEmpleadoEdited" id="idFotoEmpleadoEdited" />
              <input type="file" id="fileFotoEmpleadoEdited" name="fileFotoEmpleadoEdited" >
              <output id="list"></output>
            </br><div id="divFirma" name="divFirma"></div><br>
            <div id="fotoFirma"></div>
          </td>
        </tr>
        <tr>
          <td><label class="control-label label " for="apellidoPaternoEmpleado">Apellido Paterno</label></td>
          <td><input id="apellidoPaternoEmpleadoEdited" name="apellidoPaternoEmpleadoEdited" type="text" placeholder="Solo Letras" class="input-large"></td>
        </tr>
        <tr >
          <td ><label class="control-label label" for="apellidoMaternoEmpleado">Apellido Materno</label></td>
          <td><input id="apellidoMaternoEmpleadoEdited" name="apellidoMaternoEmpleadoEdited" type="text" placeholder="Solo letras" class="input-large"></td>
        </tr>
        <tr>
          <td><label class="control-label label" for="nombreEmpleado">Nombre</label></td>
          <td><input id="nombreEmpleadoEdited" name="nombreEmpleadoEdited" type="text" placeholder="Solo letras" class="input-large" ></td>
        </tr>
        <tr>
          <td><label class="control-label label" for="txtClaveINET1Edited">Clave INE</label></td>
          <td><input id="txtClaveINET1Edited" name="txtClaveINET1Edited" type="text" placeholder="MAYÚSCULAS" class="soloLetras" style="width: 60px;" maxlength="6" minlength="6">
              <input id="txtClaveINET2Edited" name="txtClaveINET2Edited" type="text" placeholder="NUMEROS" class="soloNumeros"   style="width: 50px;" maxlength="6" minlength="6">
              <select id="IdEFClaveINE" name="IdEFClaveINE" style="width: 55px;">
                <option value="0">EF</option>
                 <?php
                 for ($i=0; $i<count($catalogoEntidadesFederativasALaborar); $i++)
                 {
                  echo "<option value='". $catalogoEntidadesFederativasALaborar[$i]["idEntidadFederativa"]."'>". $catalogoEntidadesFederativasALaborar[$i]["idEntidadFederativa"] ." </option>";
                }
                ?>
              </select>
              <select id="IdGeneroClaveINE" name="IdGeneroClaveINE" style="width: 50px;">
                <option value="1">H</option>
                <option value="2">M</option>
              </select>
              <input id="txtClaveINET3Edited" name="txtClaveINET3Edited" type="text" placeholder="NUMEROS" class="soloNumeros" style="width: 25px;" maxlength="3" minlength='3'></td>
        </tr>
        <tr>
          <td><label class="control-label label" for="numeroSeguroSocial">Numero SS</label></td>
          <td><input id="numeroSeguroSocialEdited" name="numeroSeguroSocialEdited" type="text" placeholder="Solo numeros" class="input-large" maxlength="11" ></td>
        </tr>
        <tr>
          <td><div id="divLblBanco" name="divLblBanco"></div></td>
          <td><div id="divSelBanco" name="divSelBanco"></div></td>
        </tr>
        <tr>
          <td><label class="control-label label" for="numeroCta">Numero Cta</label></td>
          <td><input id="txtNumeroCtaEdited" name="txtNumeroCtaEdited" type="text" placeholder="Solo numeros" class="input-large" maxlength="14" ></td>
        </tr>
        <tr>
          <td><label class="control-label label" for="numeroCta">Numero Cta Clabe</label></td>
          <td><input id="txtCtaClabeEdited" name="txtCtaClabeEdited" type="text" placeholder="Solo numeros" class="input-large" maxlength="18" ></td>
        </tr>
        <tr>
          <td><label class="control-label label" for="fechaIngreso">Fecha Ingreso</label></td>
          <td><input id="fechaIngresoEdited" name="fechaIngresoEdited" type="date" class="input-medium"></br><div id="divFechaBaja" name="divFechaBaja"></div></td>
        </tr>
        <tr id="trFechaBaja" name="trFechaBaja">

        </tr>
        <tr>
          <td><label class="control-label label" for="lineaNegocio" >Linea de Negocio</label></td>
          <td><select id="selectLineaNegocioEdited" name="selectLineaNegocioEdited" class="input-large " onChange="obtenerSupervisoresOperativos1(); seleccionarDepartamento();" >
           <option>LiNEA NEGOCIO</option>
           <?php
           for ($i=0; $i<count($catalogoLineaNegocio); $i++)
           {
            echo "<option value='". $catalogoLineaNegocio[$i]["idLineaNegocio"]."'>". $catalogoLineaNegocio[$i]["descripcionLineaNegocio"] ." </option>";
          }
          ?>
        </td>

      </tr>
      <tr>
        <td><label class="control-label label" for="entidadFederativa" >Entidad Federativa</label></td>
        <td><select id="idEndidadFederativaParaSucursalEdited" name="idEndidadFederativaParaSucursalEdited" class="input-large " onChange="GetSucursalesIngresadas();" >
         <option>ENTIDAD FEDERATIVA</option>
         <?php
         for ($i=0; $i<count($catalogoEntidadesFederativasALaborar); $i++)
         {
          echo "<option value='". $catalogoEntidadesFederativasALaborar[$i]["idEntidadFederativa"]."'>". $catalogoEntidadesFederativasALaborar[$i]["nombreEntidadFederativa"] ." </option>";
        }
        ?>
      </select>
    </td>
  </tr>
      <tr>
        <td><label class="control-label label" for="entidadFederativa" >Sucursales</label></td>
        <td><select id="IdSucursal" name="IdSucursal" class="input-large "></select>
          <td><input id="IdSucursalhiddeninput" name="IdSucursalhiddeninput" type="hidden"></td>
    </td>
  </tr>
  <tr id="trTarjetaDespensaEdit">
            <td><label class="control-label2 label" for="TajetaDespensaEdit">¿Dará Tarjeta De Despensa?</label></td>
            <td>
              <div class='radio'><input type='radio'  name='TarjetaDespensaSiEdit' id='TarjetaDespensaSiEdit'>Si</div>
              <div class='radio'><input type='radio'  name='TarjetaDespensaNoEdit' id='TarjetaDespensaNoEdit'>No</div>
            </td>
          </tr>
        <tr style="display:none;">
          <td><input id="txtnumeroFirmaempleadoEdit" name="txtnumeroFirmaempleadoEdit" type="text" class="input-large"></td>
          <td><input id="ContraseniaFirmaempEdit" name="ContraseniaFirmaempEdit" type="text" class="input-large"></td>
        </tr>
        <tr id="trTarjetaEdit" style="display:none;">
          <td><label class="control-label2 label" for="numeroIutEdited">Num IUT Tarjeta(Despensa)</label></td>
          <td><input id="txtnumeroIutEdited" name="txtnumeroIutEdited" type="text" class="input-large" style="background-color: #ABEBC6;"></td>
          <td><input id="txtnumeroIutEditedHidden" name="txtnumeroIutEditedHidden" type="hidden"></td>
          <td><input id="tieneIutConsulta" name="tieneIutConsulta" type="hidden" class="input-large"></td>
        </tr>
  <tr>
        <td><label class="control-label label" for="entidadFederativa" >Entidad Federativa Labor</label></td>
        <td><select id="idEndidadFederativaEdited" name="idEndidadFederativaEdited" class="input-large " onChange="obtenerListaPuntosServiciosPorEntidad1();" >
         <option>ENTIDAD FEDERATIVA</option>
         <?php
         for ($i=0; $i<count($catalogoEntidadesFederativasALaborar); $i++)
         {
          echo "<option value='". $catalogoEntidadesFederativasALaborar[$i]["idEntidadFederativa"]."'>". $catalogoEntidadesFederativasALaborar[$i]["nombreEntidadFederativa"] ." </option>";
        }
        ?>
      </select>
    </td>
  </tr>
  <tr>
    <td><label class="control-label label" for="tipoPuesto">Tipo Puesto</label></td>
    <td>
      <select id="tipoPuestoEdited" name="tipoPuestoEdited" class="input-large " onChange="obtenerSupervisoresOperativos1(); seleccionarDepartamento();">
        <option>TIPO PUESTO</option>
        <?php
        for ($i = 0; $i < count($catalogoTipoPuestos); $i++)
        {
          echo "<option value='" . $catalogoTipoPuestos [$i]["idCategoria"] . "' >" . $catalogoTipoPuestos [$i]["descripcionCategoria"] . " </option>";
        }
        ?>
      </select>
    </td>
  </tr>
  <tr id="trDeptos">
    <td><label class="control-label label" for="puesto">Departamento</label></td>
    <td><select id="idDepartamentoPuesto" name="idDepartamentoPuesto" class="input-large"></td>
  </tr>
   <tr>
    <td><label class="control-label label" for="puesto">Puesto</label></td>
    <td> 
      <select id="puestoEdited" name="puestoEdited" class="input-large" >
      </td>
    </tr>
    <tr>
    <td><label class="control-label label" for="gerenteRegEdited">Gerente Regional</label></td>
    <td> 
      <select id="gerenteRegEdited" name="gerenteRegEdited" class="input-large" >
      </td>
    </tr>
    <tr>
      <td><label class="control-label label" for="Dirigente">Jefe/Supervisor</label></td>
      <td><select id="dirigenteEdited" name="dirigenteEdited" class="input-large"></select></td>
      <td><div id="divdirigentes" ></div></td>
    </tr>
    <tr>
      <td><label class="control-label label" for="PuntodeServicio">Punto de Servicio</label></td>
      <td><select id='selectPuntoServicioEdited' class='input-large' onchange=" ObtenerestatusEmpleados(); obtenerClienteByPuntoServicioIdEdited();LimpiarDatosTabuladorSalarioDiarioEdit();cunsultaRPpuntoServ();" ><option value="0">PUNTO DE SERVICIO</option></select>
        <input id="txtClienteIdEdited" name="txtClienteIdEdited"  type="hidden" class="input-large" maxlength="14"></td>
      </tr>
      <tr>
        <td><label class="control-label label" for="Turno">Turno</label></td>
        <td>
          <select id="tipoTurnoEdited" name="tipoTurnoEdited" class="input-large ">
            <option>TURNO</option>
            <?php
            for ($i = 0; $i < count($catalogoTurnos); $i++)
            {
              echo "<option value='" . $catalogoTurnos [$i]["idTipoTurno"] . "' >" . $catalogoTurnos [$i]["descripcionTurno"] . " </option>";
            }
            ?>
          </select>
        </td>
      </tr>

      <tr>
        <td><label class="control-label label" for="Turno">Plantilla de Servicio</label></td>
        <td>
          <select id="selplantillaserv" name="selplantillaserv" class="input-large ">
            <option value="0">PLANTILLA</option>
          </select>
            <input type="hidden" id="txtidPlantillaOriginal" name="txtidPlantillaOriginal">
          <input type="hidden" name="idRolOpertaivoPorPlantilla" id="idRolOpertaivoPorPlantilla">
        </td>
      </tr>
      <tr>
        <td><label class="control-label2 label" for="selHorarioCons">Horarios</label></td>
        <td>
          <select id='selHorarioCons' name='selHorarioCons' class='input-xlarge'></select>
        </td>
      </tr>
      <tr id="trSalarioDiario">
        <td><label class="control-label label" for="SueldoEmpEdit">Salario Diario</label></td>
        <td>
          <input id="SalarioDiarioEmpEdit" name="SalarioDiarioEmpEdit" type="text" class="input-small" placeholder="S.D" readonly>
          <input id="SalarioDiarioEmpEditImss" name="SalarioDiarioEmpEditImss" type="text" class="input-small" placeholder="S.D" readonly style="display: none;">
          <input id="SalarioDiarioEmpEditAnterior" name="SalarioDiarioEmpEditAnterior" type="hidden" class="input-small" >
          <input id="BanderaSalarioEdit" name="BanderaSalarioEdit" type="hidden" class="input-small">
          <input id="SueldoSalarioDiarioEmpEdit" name="SueldoSalarioDiarioEmpEdit" type="hidden" class="input-small">
          <button id="btnGenrarSalarioDiarioEdit" name="btnGenrarSalarioDiarioEdit" class="btn btn-primary" type="button" style="display: none;">Generar</button>
          <button id="btnConfirmadoSalarioDiarioEdit" name="btnConfirmadoSalarioDiarioEdit" class="btn btn-success"  type="button">Confirmado</button>
          <button id="btnConfirmarSalarioDiarioEdit" name="btnConfirmarSalarioDiarioEdit" class="btn btn-warning" type="button" style="display: none;"> <span class="glyphicon glyphicon-floppy-save"></span>Confirmar</button> 
          <img src="img/rechazarImss.png" width="4%" id="imgMalSalarioDiarioEdit" style="display: none;">
          <img src="img/ok.png" width="4%" id="imgBienSalarioDiarioEdit" >
        </td>
          </tr>
      <tr>
        <td><label class="control-label label" for="licencia">Licencia de conducir</label></td>
        <td>
          <div class='radio'><input type='radio'  name='licenciaConducirEdited' id='licenciaConducirsiEMpEdited' value='1' >Si</div>
          <div class='radio'><input type='radio'  name='licenciaConducirEdited' id='licenciaConducirnoEMpEdited' value='0' >No</div>
        </td>
      </tr>


      <tr id="trlicenciapermanenteEdited" style="display:none">
        <td ><label class="control-label2 label" for="licenciapermanenteEdited">Permanente</label></td>
        <td>
          <div class='radio'><input type='radio'  name='licenciaConducirpermanenteEdited' id='licenciaConducirsipermanenteEdited' value='1' >Si</div>
          <div class='radio'><input type='radio'  name='licenciaConducirpermanenteEdited' id='licenciaConducirnopermanenteEdited' value='0' >No</div>
        </td>
      </tr>



      <tr id="trnumerolicenciaEdited" style="display:none">
        <td ><label class="control-label label" for="estaturaEmpleadoEdited">Número licencia</label></td>
        <td><input id="numerolicenciaEdited" name="numerolicenciaEdited" type="text" class="input-large"></td>
      </tr>
      <tr id="trvigencialicenciaEdited" style="display:none">
        <td ><label class="control-label label" for="fechavigencialicenciaEdited">Fecha Vigencia Licencia</label></td>
        <td><input id="inpfehavigencialicenciaEdited" name="inpfehavigencialicenciaEdited" type="date" class="input-large"></td>
      </tr>
      <tr>
        <td><label class="control-label label" for="Sexo">Sexo</label></td>
        <td>
          <?php
          for ( $i=0; $i<count($catalogoGeneros); $i++)
          {
            echo "<div class='radio'><input type='radio' name='generoEdited' id='".$catalogoGeneros[$i]["idGenero"] ."generoEdited' value='".$catalogoGeneros[$i]["idGenero"] ."' onclick='seleccionaEstatusCartilla1(".$catalogoGeneros[$i]["idGenero"].")'; >".$catalogoGeneros[$i]["nomenclaturaGenero"]."</div>";
          }
          ?>
        </td>
      </tr>

      <tr>
        <td><label class="control-label label" for="tesEdited">Tes</label></td>
        <td>
          <select id="tesEdited" name="tesEdited" class="input-large " >          
            <option value="1">CLARA</option>
            <option value="2">MORENA</option>
          </select>
        </td>
      </tr>

      <tr >
        <td ><label class="control-label label" for="estaturaEmpleadoEdited">Estatura</label></td>
        <td><input id="estaturaEmpleadoEdited" name="estaturaEmpleadoEdited" type="text" placeholder="Solo numeros" class="input-medium" ></td>
      </tr>

      <tr >
        <td ><label class="control-label label" for="tallaCEmpleadoEdited">Talla Camisa</label></td>
        <td><input id="tallaCEmpleadoEdited" name="tallaCEmpleadoEdited" type="text" placeholder="Solo numeros" class="input-medium" ></td>
      </tr>

      <tr >
        <td ><label class="control-label label" for="tallaPEmpleadoEdited">Talla Pantalón</label></td>
        <td><input id="tallaPEmpleadoEdited" name="tallaPEmpleadoEdited" type="text" placeholder="Solo numeros" class="input-medium" ></td>
      </tr>

      <tr >
        <td ><label class="control-label label" for="numEmpleadoEdited">Numero de Calzado</label></td>
        <td><input id="numEmpleadoEdited" name="numEmpleadoEdited" type="text" placeholder="Solo numeros" class="input-medium" ></td>
      </tr>

      <tr>
        <td ><label class="control-label label" for="pesoEmpleadoEdited">Peso</label></td>
        <td><input id="pesoEmpleadoEdited" name="pesoEmpleadoEdited" type="text" placeholder="Solo numeros" class="input-medium" ></td>
      </tr>

      <tr>
        <td ><label class="control-label label" for="txtContactoGifEdited">Contacto Gif</label></td>
        <td><input id="txtContactoGifEdited" name="txtContactoGifEdited" type="text" placeholder="NUMERO TELEFONICO GIF" class="soloNumeros" style="width: 150px;" maxlength="10" minlength="10"></td>
      </tr>

      <tr>
        <td ><label class="control-label label" for="txtCorreoGifEdited">Correo Gif</label></td>
        <td>
          <input id="txtCorreoGifEdited" name="txtCorreoGifEdited" type="text" placeholder="CORREO GIF" class="sinEspacios" style="width: 150px;">
          <input id="txteXTENSIONCorreoGifEdited" name="txteXTENSIONCorreoGifEdited" type="text" value="@gifseguridad.com.mx" style="width: 150px;" readonly>
        </td>
      </tr>


      <tr>
        <td><label class="control-label2 label" for="lblPeriodoEdited">Periodo</label></td>
        <td>
          <?php
          for ( $i=0; $i<count($catalogoPeriodos); $i++)
          {
            echo "<input type='radio' name='periodoEdited' id='".$catalogoPeriodos[$i]["tipoPeriodoId"]."periodoEdited' value='".$catalogoPeriodos[$i]["tipoPeriodoId"] ."' >".$catalogoPeriodos[$i]["descripcionTipoPeriodo"]."<br>";
          }
          ?>
        </td>
      </tr>

      <tr>

        <td><div name="divLbSelectSup" id="divLbSelectSup"></div></td>
        <td>
          <div id="divSelectSub" name="divSelectSub"></div>
        </td>         
      </tr>
      <tr>


        <tr>
          <td><div id="divLblReclutadorEdited" name="divLblReclutadorEdited"></div></td>
          <td><div id="divReclutadorEdited" name="divReclutadorEdited"></div></td>
        </tr>
        <tr>
          <td><div id="divLblMedioEdited" name="divLblMedioEdited"></div></td>
          <td><div id="divMedioInformacionEdited" name="divMedioInformacionEdited"></div></td>
        </tr>

        <tr>
          <td></td>
          <td>

            <div id='divButtonGuardarDatosGenerales' name='divButtonGuardarDatosGenerales'></div>

            <?php
            if ($usuario["rol"] =="Administrador" || $usuario["rol"] =="Contrataciones" || $usuario["rol"] =="Lider Unidad" || $usuario["rol"] =="Laborales" )
            {
              ?>
              <div id='divEditarDatosGenerales' name='divEditarDatosGenerales'><button id="desbloqueoDatosGenerales" name="desbloqueoDatosGenerales" class="btn btn-success" type="button" onclick="desbloquearDatosGenerales();"> <span class="glyphicon glyphicon-refresh"></span>Editar</button></div>



              <?php
            }
            ?>
          </td>
        </tr>

        

      </table>
    </div>
    <!--Fin Div datos generales -->
  <!-- incio de datos fiscales  -->

  <div align="center" class="tab-pane" id="containerDatosFiscalesEdited" >
    <div id="MesjaeErrorDatosFiscalesEdit"></div>
    <h2>Datos Fiscales</h2>
    <h4>Registrar La Informacón De La Cedula De Situación Fiscal </h4>
    <h5>DATOS DEL DOMICILIO REGISTRADO</h5>
    <img title='Consulta Datos Fiscales' src='img/start.png' class='cursorImg' onclick="obtenerDatosFiscalesGeneral();" width="50px"><br><br>
    <table align="center" class="table1">
      <tr>
        <td><label class="control-label label " for="cp">Codigo Postal</label></td>
        <td>
          <input id="CodigoPostalDatosFiscales" name="CodigoPostalDatosFiscales" type="text"  disabled="true" class="input-large"  maxlength="5" minlength="5">
        </td>
        <td>&nbsp;</td>
        <td style="width:400px;" rowspan="13" valign="top"><div id="multipleDireccionesDatosFiscales"></div></td>
      </tr>
      <tr >
        <td ><label class="control-label label" for="EntidadF">Entidad</label></td>
        <td><select id="EntidadDatosFiscales" name="EntidadDatosFiscales" class="input-large"  disabled="true"></select></td>
      </tr>
      <tr>
        <td ><label class="control-label label" for="municipio">Municipio o Demarcación</label></td>
        <td><select id="MunicipioDatosFiscales" name="MunicipioDatosFiscales" class="input-large"  disabled="true"></select></td>
      </tr>
      <tr>
        <td ><label class="control-label label" for="colonia">Localidad</label></td>
        <td><select id="LocalidadDatosFiscales" name="LocalidadDatosFiscales" class="input-large"  disabled="true"></select></td>
      </tr>
      <tr>
        <td ><label class="control-label label" for="Colonia">Colonia</label></td>
        <td><input id="ColoniaDatosFiscales" name="ColoniaDatosFiscales" type="text" placeholder="Colonia" disabled="true" class="input-large"></td>
      </tr>
      <tr>
        <td ><label class="control-label label" for="Vialidad">Nombre De Vialidad</label></td>
        <td><input id="VialidadDatosFiscales" name="VialidadDatosFiscales" type="text" placeholder="Vialidad" disabled="true" class="input-large"></td>
      </tr>
      <tr>
        <td ><label class="control-label label" for="TipoVidalidad">Tipo De Vialidad</label></td>
        <td><input id="TipoVidalidadDatosFiscales" name="TipoVidalidadDatosFiscales" type="text" placeholder="Tipo De Vidalidad" disabled="true" class="input-large"></td>
      </tr>
      <tr>
        <td ><label class="control-label label" for="numero">Numero</label></td>
        <td><input id="NumExternoDatosFiscales" name="NumExternoDatosFiscales" type="text" placeholder="EXT" disabled="true" class="input-small"><input id="NumInternoDatosFiscales" name="NumInternoDatosFiscales" type="text"   placeholder="INT" disabled="true" class="input-small"></td>
      </tr>
      <tr>
        <td ><label class="control-label label" for="EstadoDomicilio">Estado Del Domicilio</label></td>
        <td>
          <select id="EstadoDoicilioDatosFiscales" name="EstadoDoicilioDatosFiscales" class="input-large" disabled="true">
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
          <input id="IdArchivoHidden" name="IdArchivoHidden" type="hidden" class="input-large">
          <div id="ImagenObtenerCedulaSat" style="display:none; cursor: pointer;"><img src="img/pdf.png" width="50px" onclick="ObtenerCedulaSat();" title="Archivo de Cedula Sat"></div><br>
          <div id='divButtonGuardarDatosFiscales' name='divButtonGuardarDireccion'></div>
          <div id='divEditarDatosFiscales' name='divEditarDatosDireccion'>
            <button id="desbloqueoDatosFiscales" name="desbloqueoDatosDireccion" class="btn btn-success" type="button"onclick="desbloquearDatosFiscales();"> <span class="glyphicon glyphicon-refresh"></span>Editar</button>
          </div>
        </td>
      </tr>
    </table>
  </div>
    <!-- Fin de datos fiscales    -->

    <!--Comienza Div datos personales -->

    <div align="center" class="tab-pane" id="containerDatosPersonalesEited" >

      <legend><h3>Datos Personales</h3></legend>

      <table class="table1">
        <tr>
          <td><label class="control-label label " for="fechaNacimiento">Fecha Nacimiento</label></label> </td>
          <td><input id="txtFechaNacimientoEdited" name="txtFechaNacimientoEdited" type="date"  class="input-medium"></td>
        </tr>
        <tr>
            <td><label class="control-label label " for="Edad">Edad</label></td>
            <td><input id="txtEdadCP" name="txtEdadCP" type="number"  class="input-large" max="90" min="15"></td>
          </tr>
        <tr>
          <td><label class="control-label label " for="pais">Pais Nacimiento</label></label> </td>
          <td><select id="selectPaisNacimientoEdited" name="selectPaisNacimiento" class="input-large ">


            <?php
            for ($i = 0; $i < count($catalogosPaises); $i++)
            {
              echo "<option value='" . $catalogosPaises [$i]["idPais"] . "' >" . $catalogosPaises [$i]["nombrePais"] . " </option>";
            }
            ?>
            
          </select>
        </td>
      </tr>

      <tr >
        <td ><label class="control-label label" for="entidadN">Entidad Nacimiento</label></td>
        <td><select id="selectEntidadNacimientoEdited" name="selectEntidadNacimientoEdited" class="input-large" onChange="consultarMunicipiosPorEntidadE();" >
         <option>ENTIDAD FEDERATIVA</option>
         <?php
         for ($i=0; $i<count($catalogoEntidadesFederativas); $i++)
         {
          echo "<option value='". $catalogoEntidadesFederativas[$i]["idEntidadFederativa"]."'>". $catalogoEntidadesFederativas[$i]["nombreEntidadFederativa"] ." </option>";
        }

        ?>
      </td>
    </tr>
    <tr>
      <td ><label class="control-label label" for="municipioN">Municipio Nacimiento</label></td>
      <td><select id="selectMunicipioNacEdited" name="selectMunicipioNacEdited" class="input-large" ></td>
      </tr>
      <tr>
        <td ><label class="control-label label" for="curp">CURP</label></td>
        <td><input id="txtCurpEdited" name="txtCurpEdited" type="text" placeholder="" class="input-large" maxlength="18"></td>
        <td><input id="txtClaveEntidad" name="txtClaveEntidad" type="hidden" class="input-large"></td>
      </tr>
      <tr>
        <td ><label class="control-label label" id="LabelCurpInterno" for="curpintern" style="display: none;">CURP INTERNO</label></td>
        <td><input id="txtCurpInterno" name="txtCurpInterno" type="text" class="input-large" style="display: none;" readonly="true"></td>
      </tr>
      <tr>
        <td ><label class="control-label label" id="LabelCheckCurpInterno" for="curp" style="display: none;">¿Continuar Con EL CURP?</label></td>
        <td><input id="checkCurp" name="checkCurp" type="checkbox" style="transform: scale(1.5);display: none;"></td>
      </tr>
      <tr>
        <td ><label class="control-label label" for="rfc">RFC</label></td>
        <td><input id="txtRfcEdited" name="txtRfcEdited" type="text"  class="input-large" maxlength="13"></td>
      </tr>
      <tr>
        <td ><label class="control-label label" id="LabelCheckRfcInterno" for="curp" style="display: none;">¿Continuar Con El RFC?</label></td>
        <td><input id="checkRfc" name="checkRfc" type="checkbox" style="transform: scale(1.5);display: none;"></td>
      </tr>
      <tr>
        <td ><label class="control-label label" for="edoCivil">Estado Civil</label></td>
        <td><select id="selectEstadoCivilEdited" name="selectEstadoCivilEdited" class="input-large ">
          <option>ESTADO CIVIL</option>

          <?php
          for ($i = 0; $i < count($catalogoEstadoCivil); $i++)
          {
            echo "<option value='" . $catalogoEstadoCivil [$i]["idEstadoCivil"] . "' >" . $catalogoEstadoCivil [$i]["descripcionEstadoCivil"] . " </option>";
          }
          ?>

        </select>
      </td>
    </tr>
    <tr>
      <td ><label class="control-label label" for="gradoEstudios">Grado Estudios</label></td>
      <td><select id="selectGradoEstudiosEdited" name="selectGradoEstudiosEdited" class="input-large ">
        <option>GRADO ESTUDIOS</option>

        <?php
        for ($i = 0; $i < count($catalogoGradoEstudios); $i++)
        {
          echo "<option value='" . $catalogoGradoEstudios [$i]["idGradoEstudios"] . "' >" . $catalogoGradoEstudios [$i]["descripcionGradoEstudios"] . " </option>";
        }
        ?>

      </select>
    </td>
  </tr>
  <tr>
    <td><label class="control-label label" for="Sangre">Tipo Sangre</label></td>
    <td>
      <select id="selectTipoSangreEdited" name="selectTipoSangreEdited" class="input-large ">
        <option>TIPO SANGRE</option>
        <?php
        for ($i = 0; $i < count($catalogoTipoSangre); $i++)
        {
          echo "<option value='" . $catalogoTipoSangre [$i]["idTipoSangre"] . "' >" . $catalogoTipoSangre [$i]["tipoSangre"] . " </option>";
        }
        ?>
      </select>
    </td>
  </tr>
  <tr>
    <td><label class="control-label label" for="Oficio">Oficio</label></td>
    <td>
      <select id="selectOficioEdited" name="selectOficioEdited" class="input-large ">
        <option>OFICIO</option>
        <?php
        for ($i = 0; $i < count($catalogoOficios); $i++)
        {
          echo "<option value='" . $catalogoOficios [$i]["idOficio"] . "' >" . $catalogoOficios [$i]["descripcionOficio"] . " </option>";
        }
        ?>
      </select>
    </td>
  </tr>
  <tr>
    <td><label class="control-label label" for="cartilla">Cartilla</label></td>
    <td>
      <?php

      for ( $i=0; $i<count($catalogoEstatusCartilla); $i++)
      {
        echo "<div class='radio'><input type='radio' name='estatusCartillaEdited' id='".$catalogoEstatusCartilla[$i]["idEstatusCartilla"] ."estatusCartillaEdited' value='".$catalogoEstatusCartilla[$i]["idEstatusCartilla"] ."' >".$catalogoEstatusCartilla[$i]["descripcionEstatusCartilla"]."</div>";
      }
      ?>
    </td>
  </tr>
  <tr>
    <td ><label class="control-label label" for="numeroCartilla1">Numero Cartilla</label></td>
    <td><input id="txtNumeroCartillaEdited" name="txtNumeroCartillaEdited" type="text"  class="input-medium"></td>
  </tr>

  <tr>
    <td></td>
    <td>
      <div id='divButtonGuardarDatosPersonales' name='divButtonGuardarDatosPersonales'></div>

      <?php
      if ($usuario["rol"] =="Administrador" || $usuario["rol"] =="Contrataciones" || $usuario["rol"] =="Lider Unidad" || $usuario["rol"] =="Laborales")
      {
        ?>
        <div id='divEditarDatosPersonales' name='divEditarDatosPersonales'><button id="desbloqueoDatosPersonales" name="desbloqueoDatosPersonales" class="btn btn-success" type="button" onclick="desbloquearDatosPersonales();"> <span class="glyphicon glyphicon-refresh"></span>Editar</button>
        </div>

        <?php
      }
      ?>

        <!--
        <button id="btnGuardarDatosPersonales" name="btnGuardarDatosPersonales" class="btn btn-primary" type="button" onclick="guardarDatosPersonalesSubmit();"> <span class="glyphicon glyphicon-floppy-save"></span>Guardar</button>
        <button id="desbloqueoDatosGenerales" name="desbloqueoDatosGenerales" class="btn btn-success" type="button" onclick="desbloquearDatosGenerales();"> <span class="glyphicon glyphicon-refresh"></span>Editar</button>
      -->
    </td>
  </tr>


</table>

</div>
<!--Termina Div datos personales -->


<!--Inicia Div datos Directorio -->

<div align="center" class="tab-pane" id="containerDirectorioEdited" >

  <legend><h3>Directorio</h3></legend>
  <table align="center" class="table1">
    <tr>
      <td><label class="control-label label " for="cp">C.P Vivienda</label></label> </td>
      <td>
        <input id="txtCPEdited" name="txtCPEdited" type="text"  class="input-large"  maxlength="5" onkeyup="consultaCPEdited();">
        <input id="txtIdAsentamientoEdited" name="txtIdAsentamientoEdited" type="hidden" />
      </td>
      <td>&nbsp;</td>
      <td style="width:400px;" rowspan="13" valign="top"><div id="multipleDireccionesE"></div></td>
    </tr>
    <tr >
      <td ><label class="control-label label" for="Entidad">Entidad</label></td>
      <td><input id="txtEntidadViviendaEdited" name="txtEntidadViviendaEdited" type="text"  class="input-large" readonly></td>
    </tr>
    <tr>
      <td ><label class="control-label label" for="municipio">Municipio</label></td>
      <td><input id="txtMunicipioViviendaEdited" name="txtMunicipioViviendaEdited" type="text" placeholder="Municipio" class="input-large" readonly>
        <input id="txtIdMunicipioEdited" name="txtIdMunicipioEdited" type="hidden"></td></td>
      </tr>
      <tr>
        <td ><label class="control-label label" for="colonia">Colonia</label></td>
        <td><input id="txtColoniaEdited" name="txtColoniaEdited" type="text" placeholder="Colonia" class="input-large" readonly></td>
      </tr>
      <tr>
        <td ><label class="control-label label" for="calle">Calle</label></td>
        <td><input id="txtCalleEdited" name="txtCalleEdited" type="text" placeholder="Calle" class="input-large"></td>
      </tr>
      <tr>
        <td ><label class="control-label label" for="numero">Numero</label></td>
        <td><input id="txtNumeroExtEdited" name="txtNumeroExtEdited" type="text" placeholder="EXT" class="input-small"><input id="txtNumeroIntEdited" name="txtNumeroIntEdited" type="text" placeholder="INT" class="input-small"></td>
      </tr>
      <tr>
        <td ><label class="control-label label" for="TelefonoFijo">Telefono Fijo</label></td>
        <td><input id="txtTelefonoFijoEdited" name="txtTelefonoFijoEdited" type="text" class="input-large" maxlength="10"></td>
      </tr>
      <tr>
        <td ><label class="control-label label" for="TelefonoMovil">Telefono Movil</label></td>
        <td><input id="txtTelefonoMovilEdited" name="txtTelefonoMovilEdited" type="text"  class="input-large" maxlength="10"></td>
      </tr>
      <tr>
        <td ><label class="control-label label" for="correo">Correo</label></td>
        <td><input id="txtCorreoEdited" name="txtCorreoEdited" type="text"  class="input-large-email"></td>
      </tr>
      <tr>
        <td ><label class="control-label label" for="nombreDel">Nombre UMF</label></td>
        <td >
          <input id="txtNombreUmfEdited" name="txtNombreUmfEdited" type="text"  class="input-large" readonly>
          <input id="txtIdUmfEdited" name="txtIdUmfEdited"  type="hidden">
          
        </td>
        <td></td>
        <td style="width:400px;" rowspan="13" valign="top"><div id="multipleUmfE"></div></td>
      </tr>
      <tr>
        <td ><label class="control-label label" for="direccionUMF">Direccion UMF</label></td>
        <td ><textarea id="txtDireccionUmfEdited" name="txtDireccionUmfEdited" class="txtArea" readonly></textarea></td></td>
      </tr>
      <tr>
        <td></td>
        <td>
          <div id='divButtonGuardarDireccion' name='divButtonGuardarDireccion'></div>

          <?php
          if ($usuario["rol"] =="Administrador" || $usuario["rol"] =="Contrataciones" || $usuario["rol"] =="Lider Unidad" || $usuario["rol"] =="Laborales")
          {
            ?>
            <div id='divEditarDatosDireccion' name='divEditarDatosDireccion'><button id="desbloqueoDatosDireccion" name="desbloqueoDatosDireccion" class="btn btn-success" type="button" onclick="desbloquearDatosDireccion();"> <span class="glyphicon glyphicon-refresh"></span>Editar</button>
            </div>
            <?php
          }
          ?>
          <!--
          <button id="btnGuardarDatosDireccion" name="btnGuardarDatosDireccion" class="btn btn-primary" type="button" onclick="guardarDatosDireccionSubmit();"> <span class="glyphicon glyphicon-floppy-save"></span>Guardar</button>
         <button id="cancelar" name="guardar" class="btn btn-danger" type="button" onclick="" > <span class="glyphicon glyphicon-remove"></span>Cancelar</button>
         <button id="desbloqueoDatosGenerales" name="desbloqueoDatosGenerales" class="btn btn-success" type="button" onclick="desbloquearDatosGenerales();"> <span class="glyphicon glyphicon-refresh"></span>Editar</button>-->
       </td>
     </tr>
   </table>
 </div>
 <!--Termina Div datos Directorio -->

 <div align="center" class="tab-pane" id="containerDatosFamiliaresEdited" >

  <legend><h3>Beneficiarios</h3></legend>

      <!-- 
            <button type='button' id='btnActualizarPadre' name='btnActualizarPadre' class='btn btn-success' type='button' onclick="editarDatosPadre();"> <span class='glyphicon glyphicon-refresh'></span>Editar</button></td>

            <td><input type='checkbox' name='checkBeneficiarioE' id='checkBeneficiarioE' onclick="obtenerListaBeneficiariosEdited();" class='style3' >Otro Beneficiario</td>
                <button type='button' id='btnActualizarBeneficiario' name='btnActualizarBeneficiario' class='btn btn-success' type='button' onclick="editarDatosBeneficiario();"> <span class='glyphicon glyphicon-refresh'></span>Editar</button>

            -->
<br>
    <br>

    <table>
      <tr>
        <td><img src="img/addMenu.png" width="20" id="agregarBeneficiarioCP" title="Agregar beneficiario" ><label class="control-label label" for="Beneficiario">AGREGAR BENEFICIARIO</label></td>
        <td><img src="img/restar.png"  width="20" id="eliminarBeneficiarioCP" title="Eliminar Beneficiario" style="display: none;"></td>
      </tr>
    </table>

    <br>
    <br>
    <input type="hidden" id="conteoBeneficiariosCP" value="0">
    <table>
        <tr id="trTitulosBeneficiariosCP" style="display:none;">
          <td style="text-align: center;"><label>PARENTESCO</label></td>
          <td style="text-align: center;"><label>NOMBRE COMPLETO</label></td>
          <td style="text-align: center;"><label>%</label></td>
        </tr>
        <tr id="trBeneficiarioCP1" style="display:none;">
          <td><input id="txtParentescoBeneficiarioCP1" name="txtParentescoBeneficiarioCP1" type="text" class="input-medium" placeholder="PARENTESCO"></td>
          <td><input id="txtNombreBeneficiarioCP1" name="txtNombreBeneficiarioCP1" type="text"  class="input-xlarge" placeholder="NOMBRE COMPLETO BENEFICIARIO 1"></td>
          <!-- <td style="text-align: center;"><input type='checkbox' name='checkBeneficiario1' class='style3' id='checkBeneficiario1' disabled></td> -->
          <td style="text-align: center;"><input align="center" id="txtPorcentajeBeneficiarioCP1" name="txtPorcentajeBeneficiarioCP1" type="number" min="1" max="100" class="input-small-mini" placeholder="%"></td>
        </tr>

        <tr id="trBeneficiarioCP2" style="display:none;">
          <td><input id="txtParentescoBeneficiarioCP2" name="txtParentescoBeneficiarioCP2" type="text" class="input-medium" placeholder="PARENTESCO"></td>
          <td><input id="txtNombreBeneficiarioCP2" name="txtNombreBeneficiarioCP2" type="text"  class="input-xlarge" placeholder="NOMBRE COMPLETO BENEFICIARIO 2"></td>
          <!-- <td style="text-align: center;"><input type='checkbox' name='checkBeneficiario2' class='style3' id='checkBeneficiario2' readonly></td> -->
          <td style="text-align: center;"><input align="center" id="txtPorcentajeBeneficiarioCP2" name="txtPorcentajeBeneficiarioCP2" type="number" min="1" max="100" class="input-small-mini" placeholder="%"></td>
        </tr>

        <tr id="trBeneficiarioCP3" style="display:none;">
          <td><input id="txtParentescoBeneficiarioCP3" name="txtParentescoBeneficiarioCP3" type="text" class="input-medium" placeholder="PARENTESCO"></td>
          <td><input id="txtNombreBeneficiarioCP3" name="txtNombreBeneficiarioCP3" type="text"  class="input-xlarge" placeholder="NOMBRE COMPLETO BENEFICIARIO 3"></td>
          <!-- <td style="text-align: center;"><input type='checkbox' name='checkBeneficiario3' class='style3' id='checkBeneficiario3' readonly></td> -->
          <td style="text-align: center;"><input id="txtPorcentajeBeneficiarioCP3" name="txtPorcentajeBeneficiarioCP3" type="number" min="1" max="100" class="input-small-mini" placeholder="%"></td>
        </tr>

        <tr id="trBeneficiarioCP4" style="display:none;">
          <td><input id="txtParentescoBeneficiarioCP4" name="txtParentescoBeneficiarioCP4" type="text" class="input-medium" placeholder="PARENTESCO"></td>
          <td><input id="txtNombreBeneficiarioCP4" name="txtNombreBeneficiarioCP4" type="text"  class="input-xlarge" placeholder="NOMBRE COMPLETO BENEFICIARIO 4"></td>
          <!-- <td style="text-align: center;"><input type='checkbox' name='checkBeneficiario4' class='style3' id='checkBeneficiario4' readonly></td> -->
          <td style="text-align: center;"><input id="txtPorcentajeBeneficiarioCP4" name="txtPorcentajeBeneficiarioCP4" type="number" min="1" max="100" class="input-small-mini" placeholder="%"></td>
        </tr>

        <tr id="trBeneficiarioCP5" style="display:none;">
          <td><input id="txtParentescoBeneficiarioCP5" name="txtParentescoBeneficiarioCP5" type="text" class="input-medium" placeholder="PARENTESCO"></td>
          <td><input id="txtNombreBeneficiarioCP5" name="txtNombreBeneficiarioCP5" type="text"  class="input-xlarge" placeholder="NOMBRE COMPLETO BENEFICIARIO 5"></td>
          <!-- <td style="text-align: center;"><input type='checkbox' name='checkBeneficiario5' class='style3' id='checkBeneficiario5' readonly></td> -->
          <td style="text-align: center;"><input id="txtPorcentajeBeneficiarioCP5" name="txtPorcentajeBeneficiarioCP5" type="number" min="1" max="100" class="input-small-mini" placeholder="%"></td>
        </tr>

        <tr id="trBeneficiarioCP6" style="display:none;">
          <td><input id="txtParentescoBeneficiarioCP6" name="txtParentescoBeneficiarioCP6" type="text" class="input-medium" placeholder="PARENTESCO"></td>
          <td><input id="txtNombreBeneficiarioCP6" name="txtNombreBeneficiarioCP6" type="text"  class="input-xlarge" placeholder="NOMBRE COMPLETO BENEFICIARIO 6"></td>
          <!-- <td style="text-align: center;"><input type='checkbox' name='checkBeneficiario6' class='style3' id='checkBeneficiario6' readonly></td> -->
          <td style="text-align: center;"><input id="txtPorcentajeBeneficiarioCP6" name="txtPorcentajeBeneficiarioCP6" type="number" min="1" max="100" class="input-small-mini" placeholder="%"></td>
        </tr>

        <tr id="trBeneficiarioCP7" style="display:none;">
          <td><input id="txtParentescoBeneficiarioCP7" name="txtParentescoBeneficiarioCP7" type="text" class="input-medium" placeholder="PARENTESCO"></td>
          <td><input id="txtNombreBeneficiarioCP7" name="txtNombreBeneficiarioCP7" type="text"  class="input-xlarge" placeholder="NOMBRE COMPLETO BENEFICIARIO 7"></td>
          <!-- <td style="text-align: center;"><input type='checkbox' name='checkBeneficiario7' class='style3' id='checkBeneficiario7' readonly></td> -->
          <td style="text-align: center;"><input id="txtPorcentajeBeneficiarioCP7" name="txtPorcentajeBeneficiarioCP7" type="number" min="1" max="100" class="input-small-mini" placeholder="%"></td>
        </tr>

        <tr id="trBeneficiarioCP8" style="display:none;">
          <td><input id="txtParentescoBeneficiarioCP8" name="txtParentescoBeneficiarioCP8" type="text" class="input-medium" placeholder="PARENTESCO"></td>
          <td><input id="txtNombreBeneficiarioCP8" name="txtNombreBeneficiarioCP8" type="text"  class="input-xlarge" placeholder="NOMBRE COMPLETO BENEFICIARIO 8"></td>
          <!-- <td style="text-align: center;"><input type='checkbox' name='checkBeneficiario8' class='style3' id='checkBeneficiario8' readonly></td> -->
          <td style="text-align: center;"><input id="txtPorcentajeBeneficiarioCP8" name="txtPorcentajeBeneficiarioCP8" type="number" min="1" max="100" class="input-small-mini" placeholder="%"></td>
        </tr>

        <tr id="trBeneficiarioCP9" style="display:none;">
          <td><input id="txtParentescoBeneficiarioCP9" name="txtParentescoBeneficiarioCP9" type="text" class="input-medium" placeholder="PARENTESCO"></td>
          <td><input id="txtNombreBeneficiarioCP9" name="txtNombreBeneficiarioCP9" type="text"  class="input-xlarge" placeholder="NOMBRE COMPLETO BENEFICIARIO 9"></td>
          <!-- <td style="text-align: center;"><input type='checkbox' name='checkBeneficiario9' class='style3' id='checkBeneficiario9' readonly></td> -->
          <td style="text-align: center;"><input id="txtPorcentajeBeneficiarioCP9" name="txtPorcentajeBeneficiarioCP9" type="number" min="1" max="100" class="input-small-mini" placeholder="%"></td>
        </tr>

        <tr id="trBeneficiarioCP10" style="display:none;">
          <td><input id="txtParentescoBeneficiarioCP10" name="txtParentescoBeneficiarioCP10" type="text" class="input-medium" placeholder="PARENTESCO"></td>
          <td><input id="txtNombreBeneficiarioCP10" name="txtNombreBeneficiarioCP10" type="text"  class="input-xlarge" placeholder="NOMBRE COMPLETO BENEFICIARIO 10"></td>
          <!-- <td style="text-align: center;"><input type='checkbox' name='checkBeneficiario10' class='style3' id='checkBeneficiario10' readonly></td> -->
          <td style="text-align: center;"><input id="txtPorcentajeBeneficiarioCP10" name="txtPorcentajeBeneficiarioCP10" type="number" min="1" max="100" class="input-small-mini" placeholder="%"></td>
        </tr>
      </table>
      <br>

<button id="btnGuardarDatosFamiliares" name="btnGuardarDatosFamiliares" class="btn btn-primary" type="button" onclick="guardarDatosBeneficiarios();"> <span class="glyphicon glyphicon-floppy-save"></span>Guardar</button>


  </div>

  <div align="center" class="tab-pane" id="containerFormatosEdited" >

    <?php
    if ($usuario["rol"] =="Administrador" || $usuario["rol"] =="Contrataciones" || $usuario["rol"] =="Lider Unidad" || $usuario["rol"] =="Laborales")
    {
      ?>

      <table>
        <tr>
          <!-- <td><button class="btn btn-large" type="button" onclick="generarCredencialEdited();"> <img src="img/credencial2.png" >Credencial</button></td> -->
          <td><button class="btn btn-large" type="button" onclick="generadorNuevaCredencialEdited();"> <img src="img/new.png">Credencial</button></td>
          <td><button class="btn btn-large" type="button" onclick="generarCartaPatronalEdited();"> <img src="img/hojaDatos.png">Carta Patronal</button></td>
          <td><button class="btn btn-large" type="button" onclick="generarCartaPatronal2Edited();"> <img src="img/hojaDatos.png">Carta Patronal 2</button></td>

        </tr>
        <tr>
          <td><button class="btn btn-large" type="button" onclick="generarContratosTodos();"> <img src="img/contratos2.png">Contratos</button></td>
          <td><button class="btn btn-large" type="button" onclick="generarHojaDatosEdited();"> <img src="img/hojaDatos1.png">Hoja de Datos</button></td>
          <td><button class="btn btn-large" type="button" onclick="generarDocumentoBancoEdited();"> <img src="img/bank.png">Formato Banco</button></td>

        </tr>
        <tr>
          <!-- <td></td> -->
          <td><button class="btn btn-large" type="button" onclick="generadorFormatoDocumentosRecibidosEdited(); generadorCartaResponsivaEdited();"> <img src="img/checkDocumentos.png">Doc. Reci</button></td>
          <td><button class="btn btn-large" type="button" onclick="generadorFormatoBASC();"> <img src="img/basc.PNG" width="55PX">Politica BASC</button></td>



        </tr>

      </table>

      <?php
    } else if ($usuario["rol"] =="Socioeconomico" || $usuario["rol"] =="Consulta Rh" )
    {
      ?>

      <table>
        <tr>
          <td><button class="btn btn-large" type="button" onclick="generarHojaDatosEdited();"> <img src="img/hojaDatos1.png">Hoja de Datos</button></td>

        </tr>


      </table>

      <?php 
    }
    ?>
  </div>








  
  <?php //###Start_Section_DocumentosDigitalizados### ?>
  
  <div align="center" class="tab-pane" id="containerDocumentosDigitalizadosEdited" >
  <table>
    <tr>
      <td>  
        <legend><h3 align="center">Documentos Digitalizados</h3></legend>
        <table border="0" width="800px" class="table table-striped">
          <?php
          $documentos = $negocio -> negocio_traerListaDocumentos();
          foreach ($documentos as $documento):
          ?>
            <tr >
              <td width="250px">
                <b>
                  <?php echo $documento["nombreDocumento"]; ?>
                </b>
                <input type="file" id="documentoDigitalizado1_<?php echo $documento["idDocumento"]; ?>"  name="documentoDigitalizado1"  class="file-loading" />
              </td>
              <td><div id="icons_documentos_edited_<?php echo $documento["idDocumento"]; ?>"></div></td>
            </tr>
          <?php endforeach; ?>
        </table>
      </td>
      <td>
        <legend><h3>Documentos Recibidos</h3></legend>
        <table border="0" width="800px" class="table table-striped" id="tablaChecksEntregados">
           <tr>
            <td>DOCUMENTO</td>
            <td>ORIGINAL</td>
            <td>COPIA</td>
           </tr>
          <?php
          $documentos = $negocio -> negocio_traerListaDocumentos();
          foreach ($documentos as $documento):
          ?>
            <tr>
              <td>
                <b>
                  <?php echo $documento["nombreDocumento"]; ?>
                </b>
              </td>
              <td>
                <input type="checkbox" disabled="true" value="<?php echo $documento["idDocumento"]; ?>" id="documentoRecibidosOriginal_<?php echo $documento["idDocumento"]; ?>"  name="documentoRecibidosOriginal"  class="file-loading" />
              </td>
              <td>
                <input type="checkbox" disabled="true" value="<?php echo $documento["idDocumento"]; ?>" id="documentoRecibidosCopia_<?php echo $documento["idDocumento"]; ?>"  name="documentoRecibidosCopia"  class="file-loading" />
              </td>
            </tr>
          <?php endforeach; ?>
          <tr>
            <td style="display:none;" id="tdbtnGuardarDocuemntosChecks">
               <button type="button" id="btnGuardarDocuemntosChecks" class="btn btn-primary" onClick="GuardarDocumentosEntegados();">Guardar</button>
            </td>
            <td id="tdbtnEditarDocuemntosChecks">
               <button type="button" id="btnEditarDocuemntosChecks" class="btn btn-success" onClick="EditarDocumentosEntegados();">Editar</button>
            </td>
          </tr>
        </table>
      </td>
    </tr> 
  </table>
</div>


<?php //###End_Section_DocumentosDigitalizados### ?>

<div id="botonesExtras"></div>

</div> <!--TERMINA tab-content -->

<!-- Modal  -->

<div id="myModalDpocReingreso" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-header">
    <h4 class="modal-title" id="myModalLabel">Registro De Documentacion</h4>
  </div>
  <div class="modal-body">
    <div id="cajonleft">
      <label class="label-success"> Documentos Originales</label><br>
      <?php
      for($i = 0 ; $i < count($catalogoDocumentos); $i++)
      {
        echo "<input type='checkbox' value='".$catalogoDocumentos[$i]["idDocumento"]."' id='checkOriginalesEdit".$catalogoDocumentos[$i]["idDocumento"]."' name='checkOriginalesEdit' class='style3' ><label class='control-label label-Doc' for='lbl'>".$catalogoDocumentos[$i]["nombreDocumento"]."</label><br>";
      }
      ?>
    </div>
    <div id="cajonrightModal">
      <label class="label-success">Documentos Copia</label><br>
      <?php
      for($i = 0 ; $i < count($catalogoDocumentos); $i++)
      {
        echo "<input type='checkbox' value='".$catalogoDocumentos[$i]["idDocumento"]."' id='checkCopiaEdit".$catalogoDocumentos[$i]["idDocumento"]."' name='checkCopiaEdit' class='style3' ><label class='control-label label-Doc' for='lbl1'>".$catalogoDocumentos[$i]["nombreDocumento"]."</label><br>";
      }
      ?>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-primary" onClick="BorrarDocumentosEntregadosAnteriormente();" data-dismiss="modal">Save changes</button>
  </div>
</div> <!-- FIN MODAL REGISTRO DOCUMENTACION-->



<!-- Modal  Baja Empleado-->
<div id="myModalBajaEmpleado" name="myModalBajaEmpleado" class="modalEdit hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" >
  <div id="alertMsg1"> 
  </div>
  
  <div class="modal-header">

    <h4 class="modal-title" id="myModalLabel"> <img src="img/warning.png">¿DESEA APLICAR BAJA DEL EMPLEADO?</h4>
  </div>

  <div class="modal-body">


    <div class="input-prepend">
      <span class="add-on">NÚMERO EMPLEADO</span>
      <input id="txtNumeroEmpleadoModal" name="txtNumeroEmpleadoModal" type="text" class="input-medium" readonly>
    </div>
    <div class="input-prepend">
      <span class="add-on">NOMBRE EMPLEADO</span>
      <input id="txtNombreEmpleadoModal" name="txtNombreEmpleadoModal" type="text" class="input-xlarge" readonly>
    </div><br>
    <div class="input-prepend">
      <span class="add-on">FECHA INGRESO</span>
      <input id="txtFechaIngresoModal" name="txtFechaIngresoModal" type="date" class="input-medium" readonly>
    </div>
    <div class="input-prepend">
      <span class="add-on">FECHA BAJA</span>
      <input id="txtFechaBajaModal" name="txtFechaBajaModal" type="date" class="input-medium"  >

    </div><br>

    <div class="input-prepend">
      <span class="add-on">TIPO BAJA</span>
      <select id="selectTipoBaja" name="selectTipoBaja" class="input-large" onChange='selectMotivosBajaPorTipoBaja();'>
        <option>TIPO BAJA</option>
        <?php
        for ($i=0; $i<count($catalogoTipoBaja); $i++)
        {
          echo "<option value='". $catalogoTipoBaja[$i]["idTipoBaja"]."'>". $catalogoTipoBaja[$i]["descripcionTipoBaja"] ." </option>";
        }
        ?>
      </select>
    </div>

    <div class="input-prepend">
      <span class="add-on">MOTIVO BAJA</span>
      <select id="selectMotivoBaja" name="selectMotivoBaja" class="input-large ">
      </select>
    </div><br>

    <div class="input-prepend">
      <span class="add-on">COMENTARIO</span>
      <input id="txtComentarioBaja" name="txtComentarioBaja" type="text" class="input-xlarge">
      <input id="txtPuestoBajaModal" name="txtPuestoBajaModal" type="hidden" class="input-medium"  >
    </div><br>

    <input id="inproloperativo" name="inproloperativo" type="hidden" class="input-medium"  >
    <div class="input-prepend">

      <input id="txtTipoPeriodo" name="txtTipoPeriodo" type="hidden" class="input-small">
    </div>
    <div class="input-prepend">

      <input id="txtPuntoServicioBaja" name="txtPuntoServicioBaja" type="hidden" class="input-small">
    </div>
    <div class="input-prepend">

      <input id="txtTipoEmpleado" name="txtTipoEmpleado" type="hidden" class="input-small">
    </div>

    <div class="input-prepend">

      <input id="txtResponsableAsistencia" name="txtResponsableAsistencia" type="hidden" class="input-small">
      <input id="txtEstatusImss" name="txtEstatusImss" type="hidden" class="input-small">
    </div><br>
<!--
     <div class="input-prepend">
        <label class="control-label label " for="ArchivoBajaEmp" id="ArchivoBajaEmp11" >Archvio Baja</label>
        <input type='file' class='btn-success' id='ArchivoBajaEmp' name='ArchivoBajaEmp[]' multiple="" /> 
     </div>-->
     <div class="input-prepend">
         <button type="button" id="btnGuardarDocBajaEmp" name="btnGuardarDocBajaEmp" onclick="firmarDocumentoRh();" class="btn btn-success" >Firmar Documento (Administrativo)</button>
      </div><br>
      <div class="input-prepend">
        <span class="add-on">Nombe Solicitante:</span>
        <input type="text" id="NombreSolicitanteRh" class="input-xlarge"name="NombreSolicitanteRh" readonly="true">
        <span class="add-on">Firma Interna:</span>
        <input type="text" id="FirmaInternaRh" class="input-xlarge"name="FirmaInternaRh" readonly="true">
        <input type="hidden" class="input-medium" id="numempleadoFirmahiddenRh" name="numempleadoFirmahiddenRh" readonly="true">
        <input type="hidden" class="input-medium" id="clienteBajaRh" name="clienteBajaRh" readonly="true">
      </div><br>
      <div id="FirmaOperativoBaja" name="FirmaOperativoBaja" class="input-prepend" style="display: none;">
         <button type="button" id="btnGuardarDocBajaEmp" name="btnGuardarDocBajaEmp" onclick="firmarDocumentoGuardiaRh();" class="btn btn-success" >Firmar Documento (Gardia)</button>
      </div><br>
      <div class="input-prepend" id="FirmaAdministrativoBaja" name="FirmaAdministrativoBaja" style="display: none;">
         <button type="button" id="btnGuardarDocBajaEmp" name="btnGuardarDocBajaEmp" onclick="firmarDocumentoRhBajaAdministrativo();" class="btn btn-success" >Firmar Documento (Gardia)</button>
      </div><br>
      <div class="input-prepend">
        <span class="add-on">Nombe Solicitante:</span>
        <input type="text" id="NombreGuardiaRh" class="input-xlarge"name="NombreGuardiaRh" readonly="true">
        <span class="add-on">Firma Interna:</span>
        <input type="text" id="FirmaInternaGuardiaRh" class="input-xlarge"name="FirmaInternaGuardiaRh" readonly="true">
      </div><br>
      <div class="input-prepend">
        <img src='img/pdf.png' width="50px" class='cursorImg' id='btnguardar' onclick='abrirarchivoRenunciaRh()' title="Documento Renuncia De Gif Seguridad Privada">
      </div><br>
      <div class="input-prepend">
        <h4 class="modal-title" id="myModalLabel"> <img src="img/warning.png">¿ESTE ELEMENTO PODRÁ SER REINGRESADO POSTERIORMENTE?</h4>
      </div><br>
      <div class="input-prepend">
            <span class="add-on" >SI</span>
            <input type="checkbox" id="checkSireingreso" title="Si podra ser reingresado en caso de que vuelva a solicitar trabajo en el Corporativo" name="checkSireingreso" style="transform: scale(1.5);width: 30px;">
            <span class="add-on">NO</span>
            <input type="checkbox" id="checkNoreingreso" title="NO podra ser reingresado en Ningun caso dentro de este Corporativo" name="checkNoreingreso" style="transform: scale(1.5);width: 30px;">
      </div><br>
      <div class="input-prepend">
        <span class="add-on" style="color:red;">AL COLOCAR QUE NO EL EMPLEADO QUEDARÁ VETADO DE TODO EL CORPORATIVO GIF SEGURIDAD PRIVADA</span><br>
        <span class="add-on" style="color:red;">Y NO PODRÁ SER REINGRESADO EN NINGUNA PARTE DEL PAIS DENTRO DE ESTE CORPORATIVO!!!</span>
      </div><br>
      <div class="input-prepend" id="divComentarioMotivoBeto" style="display: none;">
      <span class="add-on">Motivo:</span>
        <textarea id="ComentarioBetado" name="ComentarioBetado" class="txtAreaIncidencia"  placeholder="Escriba el motivo por el cual el elemento será vetado"></textarea>
      </div><br>
      <input type="hidden" id="banderaBetado" class="input-xlarge"name="banderaBetado" readonly="true">


    
  </div>
  <div class="modal-footer" id="footerBajaEmpleado">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
    <button id="btnguardarbajaempleado" type="button" class="btn btn-primary" onclick='guardarHistoricoBajaSubmit();'>Guardar Cambios</button>
  </div>
</div>  <!-- FIN MODAL BAJA EMPLEADO -->

<!--/////////////////////////////////////////////////////////////////////////////////// modal FirmaBajaEmpleado ////////////////////////////////////////////////////////////////// -->

<div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaElectronicaRh" id="modalFirmaElectronicaRh" data-backdrop="static"> <!-- modal FirmaBajaEmpleado -->
  <div id="errorModalFirmaInternaRh"></div>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" align="center"><img src="img/alert.png">Escribe tu numero de empleado y la contraseña que generaste !!</h3>
      </div>
      <div class="modal-body" align="center">
        <span class="add-on"># Empleado</span>
        <input type="text" id="NumEmpModalBajaRh" class="input-medium" name="NumEmpModalBajaRh" placeholder="00-0000-00 Ó 00-00000-00">
        <span class="add-on">Contraseña</span>
        <input type="password" id="constraseniaFirmaRh" class="input-xlarge"name="constraseniaFirmaRh" title="El campo identifica entre mayusculas y minusculas favor de considerarlo">
      </div>
      <div class="modal-body" align="center">
        
        <button type="button" id="btnFirmarDocRh" name="btnFirmarDocRh" style="display: none;" onclick="RevisarFirmaInternaRH();" class="btn btn-primary" >Firmar</button>
        <button type="button" id="btnCancelarFirmaRh" name="btnCancelarFirmaRh"onclick="cancelarFirmaRH();" class="btn btn-danger" >Cancelar</button>
      </div>      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div> <!-- FIN modal FirmaBajaEmpleado -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////// modal Firma Guardia Operativo//////////////////////////////////////////////////////////////////-->



<div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaGuardiaBajaRh" id="modalFirmaGuardiaBajaRh" data-backdrop="static"> <!-- modal Firma Guardia --->
  <div id="errormodalFirmaElementoBajaRh"></div>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" align="center"><img src="img/alert.png">Firma De Recibido Del Elemento!!</h2>
      </div>
       <div class="modal-body" align="center">
          <h4 class="modal-title" align="center">Escriba la contraseña que recibe al activar su cuenta en la plataforma de Gif Seguridad Privada</h4>
      </div>
      <div class="modal-body" align="center">
          <span class="add-on">Contraseña</span>
        <input type="password" maxlength="10" id="constraseniaFirmaElementoBajaRh" class="input-xlarge"name="constraseniaFirmaElementoBajaRh" title="El campo identifica entre mayusculas y minusculas favor de considerarlo">
      </div>
      <div class="modal-body" id="ActivarActualizarCuentaBajaRh" align="center" style="display: none;">
          <p><a  href="form_activacionCuentaUsuario.php" target="_blank">Activar/Actualizar Cuenta</a></p>
      </div>
      <div class="modal-body" align="center">
        <button type="button" id="btnCancelarFirmaBajaRh" name="btnCancelarFirmaBajaRh"onclick="cancelarFirmaRHGuardia();" class="btn btn-danger" >Cancelar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////// modal Firma Guardia Administrativo////////////////////////////////////////////////////////////////// -->



<div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaElectronicaRhBajaAdmin" id="modalFirmaElectronicaRhBajaAdmin" data-backdrop="static"> <!-- modal FirmaBajaEmpleado -->
  <div id="errorModalFirmaBajaAdmin"></div>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" align="center"><img src="img/alert.png">Escribe tu numero de empleado y la contraseña que generaste !!</h3>
      </div>
      <div class="modal-body" align="center">
        <span class="add-on"># Empleado</span>
        <input type="text" id="NumEmpModalBajaAdmin" class="input-medium" name="NumEmpModalBajaAdmin" placeholder="00-0000-00 Ó 00-00000-00">
        <span class="add-on">Contraseña</span>
        <input type="password" id="constraseniaFirmaBajaAdminRh" class="input-xlarge"name="constraseniaFirmaBajaAdminRh" title="El campo identifica entre mayusculas y minusculas favor de considerarlo">
      </div>
      <div class="modal-body" align="center">
        
        <button type="button" id="btnFirmarDocBajaAdminRh" name="btnFirmarDocBajaAdminRh" style="display: none;" onclick="RevisarFirmaInternaRHBajaAdministrativo();" class="btn btn-primary" >Firmar</button>
        <button type="button" id="btnCancelarFirmaBajaAdminRh" name="btnCancelarFirmaBajaAdminRh"onclick="cancelarFirmaRHBajaAdministrativo();" class="btn btn-danger" >Cancelar</button>
      </div>      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div> <!-- FIN modal FirmaBajaEmpleado -->


<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<!-- Modal  reingreso Empleado-->
<div id="myModalReingresoEmpleado" name="myModalReingresoEmpleado" class="modalEdit hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" >
  <div id="alertMsg1R" name="alertMsg1R"> 
  </div>
  
  <div class="modal-header">

    <h4 class="modal-title" id="myModalLabel"> <img src="img/warning.png">¿DESEA APLICAR REINGRESO DEL EMPLEADO?</h4>
  </div>

  <div class="modal-body">
    <div class="input-prepend">
      <span class="add-on">NÚMERO EMPLEADO</span>
      <input id="txtNumeroEmpleadoModalR" name="txtNumeroEmpleadoModalR" type="text" class="input-medium" readonly>
    </div>
    <div class="input-prepend">
      <span class="add-on">NOMBRE EMPLEADO</span>
      <input id="txtNombreEmpleadoModalR" name="txtNombreEmpleadoModalR" type="text" class="input-xlarge" readonly>
    </div>
    <div class="input-prepend">
      <span class="add-on">FECHA REINGRESO</span>
      <input id="txtFechaIngresoModaloculto" name="txtFechaIngresoModaloculto" type="hidden" class="input-medium" readonly>
      <input id="txtFechaIngresoModalR" name="txtFechaIngresoModalR" type="text" class="input-medium" >
    </div>

    <div class="input-prepend">
      <span class="add-on">ENTIDAD PARA LABORAR</span>
      <select id="selectEntidadLaboralReingreso" name="selectEntidadLaboralReingreso" class="input-large " onChange="obtenerListaPuntosServiciosReingreso();" >
       <option>ENTIDAD FEDERATIVA</option>
       <?php
       for ($i=0; $i<count($catalogoEntidadesFederativas); $i++)
       {
        echo "<option value='". $catalogoEntidadesFederativas[$i]["idEntidadFederativa"]."'>". $catalogoEntidadesFederativas[$i]["nombreEntidadFederativa"] ." </option>";
      }
      ?>
    </select>
  </div>

  <div class="input-prepend">
    <span class="add-on">LINEA NEGOCIO</span>
    <select id="selectLineaNegocioModalR" name="selectLineaNegocioModalR" type="date" class="input-large" >
      <option>LiNEA NEGOCIO</option>
      <?php
      for ($i=0; $i<count($catalogoLineaNegocio); $i++)
      {
        echo "<option value='". $catalogoLineaNegocio[$i]["idLineaNegocio"]."'>". $catalogoLineaNegocio[$i]["descripcionLineaNegocio"] ." </option>";
      }
      ?>
    </select>
  </div>

  <div class="input-prepend">
    <span class="add-on">TIPO PUESTO</span>
    <select id="selectTipoPuestoReingreso" name="selectTipoPuestoReingreso" class="input-large " onChange="obtenerSupervisoresOperativosReingreso(); seleccionarDepartamentoReingreso();">
      <option>TIPO PUESTO</option>
      <?php
      for ($i = 0; $i < count($catalogoTipoPuestos); $i++)
      {
        echo "<option value='" . $catalogoTipoPuestos [$i]["idCategoria"] . "' >" . $catalogoTipoPuestos [$i]["descripcionCategoria"] . " </option>";
      }
      ?>
    </select>
  </div>

   <div class="input-prepend" id="divDeptosReingreso">
    <span class="add-on">DEPARTAMENTO</span>
    <select id="idDepartamentoPuestoReingreso" name="idDepartamentoPuestoReingreso" class="input-large"></select>
  </div>

  <div class="input-prepend">
    <span class="add-on">PUESTO</span>
    <select id="selectPuestoModalR" name="selectPuestoModalR"  class="input-large" >
      <option>PUESTO</option>
    </select>
  </div>

  <div class="input-prepend">
    <span class="add-on">GERENTE REGIONAL</span>
    <select id="gerenteRegReingreso" name="gerenteRegReingreso" class="input-large" >
      <option>GERENTE REGIONAL</option>
    </select>
    <input type="hidden" id="txtgerenteRegReingreso" name="txtgerenteRegReingreso">

  </div>

  <div class="input-prepend">
    <span class="add-on">PUNTO SERVICIO</span>
    <select id="selectPuntoServicioModalR" name="selectPuntoServicioModalR" class="input-large" >
      <option>PUNTOS SERVICIOS</option>
    </select>
    <input type="hidden" id="txtGeneroReingreso" name="txtGeneroReingreso">

  </div>

  <div class="input-prepend">
    <span class="add-on">TURNO</span>
    <select id="selectTurnoReingreso" name="selectTurnoReingreso" class="input-large ">
      <option>TURNO</option>
      <?php
      for ($i = 0; $i < count($catalogoTurnos); $i++)
      {
        echo "<option value='" . $catalogoTurnos [$i]["idTipoTurno"] . "' >" . $catalogoTurnos [$i]["descripcionTurno"] . " </option>";
      }
      ?>
    </select>
  </div>

  <div class="input-prepend">
    <span class="add-on">PLANTILLA DE SERVICIO</span>
    <select id="selplantillaservicioreingreso" name="selplantillaservicioreingreso" class="input-large ">
    </select>
  </div>
  <div class="input-prepend">
    <span class="add-on">HORARIOS</span>
    <select id="selHorarioReingreso" name="selHorarioReingreso" class="input-large ">
    </select>
  </div>

  <div id="divSlarioDiarioReingreso">
    <input id="SalarioDiarioEmpReingreso" name="SalarioDiarioEmpReingreso" type="text" class="input-small" placeholder="S.D" readonly>
    <input id="SalarioDiarioEmpReingresoImss" name="SalarioDiarioEmpReingresoImss" type="text" class="input-small" placeholder="S.D" readonly style="display: none;">
    <input id="BanderaSalarioReingreso" name="BanderaSalarioReingreso" type="hidden" class="input-small">
    <input id="SueldoSalarioDiarioEmpReingreso" name="SueldoSalarioDiarioEmpReingreso" type="hidden" class="input-small">
    <button id="btnGenrarSalarioDiarioReingreso" name="btnGenrarSalarioDiarioReingreso" class="btn btn-primary" type="button" >Generar</button>
    <button id="btnConfirmadoSalarioDiarioReingreso" name="btnConfirmadoSalarioDiarioReingreso" class="btn btn-success"  type="button" style="display: none;">Confirmado</button>
    <button id="btnConfirmarSalarioDiarioReingreso" name="btnConfirmarSalarioDiarioReingreso" class="btn btn-warning" type="button" style="display: none;"> <span class="glyphicon glyphicon-floppy-save"></span>Confirmar</button> 
    <img src="img/rechazarImss.png" width="3%" id="imgMalSalarioDiarioReingreso" >
    <img src="img/ok.png" width="3%" id="imgBienSalarioDiarioReingreso" style="display: none;" >
  </div>

  <div class="input-prepend">
    <span class="add-on">PERIODO</span>
    <select id="selectPeriodoReingreso" name="selectPeriodoReingreso" class="input-large ">
      <option>PERIODO</option>
      <?php
      for ($i = 0; $i < count($catalogoPeriodos); $i++)
      {
        echo "<option value='" . $catalogoPeriodos [$i]["tipoPeriodoId"] . "' >" . $catalogoPeriodos [$i]["descripcionTipoPeriodo"] . " </option>";
      }
      ?>
    </select>
  </div>
  <div class="input-prepend">
    <span class="add-on">SUPERVISOR</span>
    <select id="selectSupervisorModalR" name="selectSupervisorModalR" class="input-large" >
      <option>RESPONSABLE ASISTENCIA</option>

    </select>
  </div>
  <div class="input-prepend">
    <span class="add-on">BANCO</span>
    <select id="selectBancoReingreso" name="selectBancoReingreso" class="input-large" >
      <option>BANCO</option>
    </select>
  </div>
  <div class="input-prepend">
    <span class="add-on">N° CUENTA</span>
    <input type="text" id="inpNoCuentaReingreso" name="inpNoCuentaReingreso"  onkeypress='return validaNumericos(event)' > 
  </div>
  <div class="input-prepend">
    <span class="add-on">CUENTA CLABE</span>
    <input type="text" id="inpNoCuentaClabeReingreso" name="inpNoCuentaClabeReingreso"  onkeypress='return validaNumericos(event)'>
  </div><br>

  <div class="input-prepend">
    <span class="add-on">CONSERVA ANTIGUEDAD</span>
  </div>
  <div class="input-prepend">
    <span class="add-on">SI</span>
    <input type='radio' title="El elemento viene de un cambio proveniente del grupo de empresas GIF" name='antiguedadVacacionesReingresoS' id='AntiguedadVacacionesReingresoSi' value='' >
  </div>
  <div class="input-prepend">
    <span class="add-on">NO</span>
    <input type='radio' title="El elemento No conserva antigueadad de reingreso al grupo de empresas GIF " name='antiguedadVacacionesReingresoN' id='AntiguedadVacacionesReingresoNo' value='' >
  </div>

 



</div> 
<div class="input-prepend">
  <span class="add-on" for="docdigitalizado">AVISO INSCRIPCIÓN IMSS:</span>
  <input type='file' class='btn-success' id='docdigitalizado0' name='docdigitalizado0[]' />    
</div>
<div class="input-prepend">
  <span class="add-on" for="docdigitalizado">TICKET DE CUENTA:</span>
  <input type='file' class='btn-success' id='docdigitalizado1' name='docdigitalizado1[]'  />
</div>
<div class="input-prepend">
  <span class="add-on" for="docdigitalizado">CEDULA SAT(RFC):</span>
  <input type='file' class='btn-success' id='docdigitalizado2' name='docdigitalizado2[]'  />
</div>

<div id='divarchivolicencia' class="input-prepend" style='display: none'>
  <span class="add-on" for="docdigitalizado">LICENCIA DE CONDUCIR:</span>
  <input type='file' class='btn-success' id='docdigitalizado3' name='docdigitalizado3[]'  />
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
    <button type="button" class="btn btn-primary" onclick="actualizaFechaReingreso();"  >Guardar Cambios</button>

  <!-- <a id="containerDocumentosDigitalizadosTab1" href="#containerDocumentosDigitalizadosEdited" data-toggle="tab">Documentos Digitalizados </a>-->
</div>
</div>  <!-- FIN MODAL BAJA EMPLEADO -->
<!-- modal firma -->
<div id="modalFirma" name="modalFirma" class="modalFirma hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-header">
    <div id="divFirmaMsg" name="divFirmaMsg"></div>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Firma del elemento</h3>

  </div>
  <div class="modal-body" id="sketch_div">
    <p>Dibuje firma del elemento…</p>
    <canvas id="tools_sketch" class="divTrFirma" width="900" height="350" ><td></canvas>
    </div>
    <div class="modal-footer1">

      <button type="button" id="btnLimpiar" name="btnLimpiar"class="btn btn-secundary" onclick="limpiarCanvas();">Limpiar</button>

      <button type="button" class="btn btn-primary" onclick="saveImage();">Guardar Firma</button>

    </div>
  </div>

  <!--  fin modal firma -->

  <div class="modal fade" tabindex="-1" role="dialog" name="modalErrorBajaImss" id="modalErrorBajaImss" data-backdrop="static">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><img src="img/alert.png">No se puede procesar baja</h4>
        </div>
        <div class="modal-body">
          <p><strong>El empleado no puede darse de baja debido a que está en proceso de confirmación de alta en Imss, intente más tarde.</strong></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <div class="modal fade" tabindex="-1" role="dialog" name="modalErrorReingresoPorFiniquito" id="modalErrorReingresoPorFiniquito" data-backdrop="static">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><img src="img/alert.png">No se puede procesar reingreso</h4>
        </div>
        <div class="modal-body">
          <p><strong>El empleado no puede reingresar debido a que  tiene finiquitos por confirmar.</strong></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
</form>

</div>






<!-- Modal  reingreso Empleado-->
<div id="modalReingresoSolicituEmpleo" name="modalReingresoSolicituEmpleo" class="modalReingresoSolicitudEmpleo hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" >
  <?php
  $catalogoEntidadesF= $negocio -> negocio_obtenerListaEntidadesFeferativas();
  $catalogoTipoSangre= $negocio -> negocio_obtenerListaTipoSangre();
  $catalogoGradoEstudios=$negocio -> negocio_obtenerListaGradoEstudios();
  ?>
  <div id="alertMsg1RE" name="alertMsg1RE"> 
  </div>
  


  <div class="modal-bodyformSolicitudReingreso">
    <div class="container" align="center">

      <form class="form-horizontal"  method="post" id="form_registroPreseleccionReingresoEmpleado" name="form_registroPreseleccionReingresoEmpleado" target="_blank">
        <input id="txtFolioSolicitudRE" name="txtFolioSolicitudRE" type="hidden" class="input-mini" >   
        <input id="numempleadopreseleccionRE" name="numempleadopreseleccionRE" type="hidden" class="input-large">
        <input id="folioempleadopreseleccionRE" name="folioempleadopreseleccionRE" type="hidden" class="input-large">

        <fieldset >        
          <center><h2>Solicitud Empleado</h2></center>
        </fieldset>
        <div id="msginformativo"></div>        

        <table id="tablesolicitudEmpleoReingresoEmpleado" class="table1" border="3">

          <tr>
            <td>
              <table style="table-layout:fixed;" width="1800px">
                <tr><td colspan="2"><center><h4><u style="color: #369C1C">DATOS PERSONALES</u></h4></center></td>
                </tr>                     
                <tr>
                  <td><label class=" control-label label " for="empPuestoRE">PUESTO QUE SOLICITA:</label><br>   
                    <input id="empPuestoRE" name="empPuestoRE" type="text" class="input-large"> </td>

                    <td><label class=" control-label label " for="empApPaternoRE">APELLIDO PATERNO:</label><br>   
                      <input id="empApPaternoRE" name="empApPaternoRE" type="text" class="input-large"> </td>

                      <td><label class=" control-label label " for="empApMaternoRE">APELLIDO MATERNO:</label><br>   
                        <input id="empApMaternoRE" name="empApMaternoRE" type="text" class="input-large"> </td>

                        <td><label class=" control-label label " for="empNombreRE">NOMBRE (S):</label><br>   
                          <input id="empNombreRE" name="empNombreRE" type="text" class="input-large"> </td>

                          <td><label class=" control-label label " for="empEdadRE">EDAD:</label><br>     
                            <input style="margin-right: 120px; margin-left: 110px" id="empEdadRE" name="empEdad" type="text" class="input-mini"></td>

                          </tr>
                          <tr>

                            <td><label class=" control-label label " for="empPesoRE">PESO:</label><br>     
                              <input style="margin-right: 120px; margin-left: 110px" id="empPesoRE" name="empPesoRE" type="text" class="input-mini"></td>

                              <td><label class=" control-label label " for="empEstaturaRE">ESTATURA:</label><br>     
                                <input style="margin-right: 120px; margin-left: 110px" id="empEstaturaRE" name="empEstaturaRE" type="text" class="input-mini"></td>

                                <td><label class=" control-label label " for="empTallaCamisaRE">TALLA CAMISA:</label><br>     
                                  <input style="margin-right: 120px; margin-left: 110px" id="empTallaCamisaRE" name="empTallaCamisaRE" type="text" class="input-mini"></td>

                                  <td><label class=" control-label label " for="empTallaPantalonRE">TALLA PANTALON:</label><br>     
                                    <input style="margin-right: 120px; margin-left: 110px" id="empTallaPantalonRE" name="empTallaPantalonRE" type="text" class="input-mini"></td>

                                    <td><label class=" control-label label " for="empNumCalzadoRE">NUM CALZADO:</label><br>     
                                      <input style="margin-right: 120px; margin-left: 110px" id="empNumCalzadoRE" name="empNumCalzadoRE" type="text" class="input-mini"></td>

                                    </tr>

                                    <tr>

                                      <td><label class=" control-label label " for="selectEmpCivilRE">ESTADO CIVIL:</label><br>   
                                        <select id="selectEmpCivilRE" name="selectEmpCivilRE" class="input-large"> 
                                          <option value="">ESTADO CIVIL</option>
                                          <option value="1">SOLTERO (A)</option>
                                          <option value="2">CASADO (A)</option>
                                          <option value="3">VIUDO (A)</option>
                                          <option value="4">DIVORCIADO (A)</option>
                                          <option value="5">UNION LIBRE</option>
                                        </select> </td>

                                        <td><label class=" control-label label " for="selectEmpSexoRE">GENERO:</label><br>   
                                          <select id="selectEmpSexoRE" name="selectEmpSexoRE" class="input-medium"> 
                                            <option value="">GENERO</option>
                                            <option value="1">FEMENINO</option>
                                            <option value="2">MASCULINO</option>
                                          </select> </td>

                                          <td><label class=" control-label label " for="selectEmpTipoSangreRE">TIPO SANGRE:</label><br>   
                                            <select id="selectEmpTipoSangreRE" name="selectEmpTipoSangreRE" class="input-medium"> 
                                              <option value="">TIPO SANGRE</option>
                                              <?php
                                              for ($i=0; $i<count($catalogoTipoSangre); $i++)
                                              {
                                                echo "<option value='". $catalogoTipoSangre[$i]["idTipoSangre"]."'>". $catalogoTipoSangre[$i]["tipoSangre"] ." </option>";
                                              }
                                              ?>
                                            </select> </td>

                                            <td><label class=" control-label label " for="empFechaNacRE">FECHA NACIMIENTO:</label><br>   
                                              <input class="input-medium" id="empFechaNacRE" name="empFechaNacRE" type="date"> </td>

                                              <td><label class=" control-label label " for="selectEmpEntidadRE">ESTADO NACIMIENTO:</label><br>   
                                                <select id="selectEmpEntidadRE" name="selectEmpEntidadRE" class="input-large"> 
                                                  <option value="">ESTADO</option>
                                                  <?php
                                                  for ($i=0; $i<count($catalogoEntidadesF); $i++)
                                                  {
                                                    echo "<option value='". $catalogoEntidadesF[$i]["idEntidadFederativa"]."'>". $catalogoEntidadesF[$i]["nombreEntidadFederativa"] ." </option>";
                                                  }
                                                  ?>
                                                </select> </td>            

                                              </tr>
                                            </table>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>
                                            <table style="table-layout:fixed;" width="1800px">
                                              <tr ><td colspan="2"><center><h4><u style="color: #369C1C">DATOS DE DOMICILIO</u></h4></center></td>
                                              </tr>
                                              <tr>


                                                <td><label class=" control-label label " for="empCodPostalRE">C.P.:</label><br>     
                                                  <input style="margin-right: 120px; margin-left: 110px" id="empCodPostalRE" name="empCodPostalRE" type="text" class="input-mini"></td>


                                                  <td><label class=" control-label label " for="empCalleRE">CALLE:</label><br>   
                                                    <input id="empCalleRE" name="empCalleRE" type="text" class="input-large"> </td>

                                                    <td><label class=" control-label label " for="empNumeroCRE">NUMERO:</label><br>     
                                                      <input style="margin-right: 120px; margin-left: 110px" id="empNumeroCRE" name="empNumeroCRE" type="text" class="input-mini"></td>

                                                      <td><label class=" control-label label " for="empColoniaRE">COLONIA:</label><br>   
                                                        <input id="empColoniaRE" name="empColoniaRE" type="text" class="input-large"> </td>

                                                        <td><label class=" control-label label " for="empMunicipioRE">DELEGACION O MUNICIPIO:</label><br>   
                                                          <input id="empMunicipioRE" name="empMunicipioRE" type="text" class="input-large"> </td>

                                                        </tr>
                                                        <tr>                            


                                                          <td><label class=" control-label label " for="empCiudadRE">CIUDAD:</label><br>   
                                                            <input id="empCiudadRE" name="empCiudadRE" type="text" class="input-large"> </td>

                                                            <td><label class=" control-label label " for="empTelFijoRE">TEL. FIJO:</label><br>   
                                                              <input id="empTelFijoRE" name="empTelFijoRE" type="text" class="input-large"> </td>

                                                              <td><label class=" control-label label " for="empTelMovilRE">TEL. MOVIL:</label><br>   
                                                                <input id="empTelMovilRE" name="empTelMovilRE" type="text" class="input-large"> </td>

                                                                <td><label class=" control-label label " for="empEmailRE">EMAIL:</label><br>   
                                                                  <input id="empEmailRE" name="empEmailRE" type="email"> </td>

                                                                </tr>
                                                              </table>
                                                            </td>
                                                          </tr>
                                                          <tr>
                                                            <td>
                                                              <table style="table-layout:fixed;" width="1800px">
                                                                <tr ><td colspan="2"><center><h4><u style="color: #369C1C">DATOS DE AFILIACIONES</u></h4></center></td>
                                                                </tr>
                                                                <tr>
                                                                  <td><label class=" control-label label " for="checkEmpInfonavitRE">INFONAVIT:</label><br><br>
                                                                    <div style="margin-right: 120px; margin-left: 110px" class="material-switch pull-right">
                                                                      <input id="checkEmpInfonavitRE" name="checkEmpInfonavitRE" type="checkbox" />
                                                                      <label for="checkEmpInfonavitRE" class="label-success1"></label>
                                                                    </div>            
                                                                    <br></td> 

                                                                    <td><label class=" control-label label " for="checkEmpFonacotRE">FONACOT:</label><br><br>
                                                                      <div style="margin-right: 120px; margin-left: 110px" class="material-switch pull-right">
                                                                        <input id="checkEmpFonacotRE" name="checkEmpFonacotRE" type="checkbox" />
                                                                        <label for="checkEmpFonacotRE" class="label-success1"></label>
                                                                      </div>            
                                                                      <br></td>     

                                                                      <td><label class=" control-label label " for="checkEmpCartillaRE">CARTILLA LIBERADA:</label><br><br>
                                                                        <div style="margin-right: 120px; margin-left: 110px" class="material-switch pull-right">
                                                                          <input id="checkEmpCartillaRE" name="checkEmpCartillaRE" type="checkbox" />
                                                                          <label for="checkEmpCartillaRE" class="label-success1"></label>
                                                                        </div>            
                                                                        <br></td>     

                                                                        <td><label class=" control-label label " for="checkEmpLicenciaRE">LICENCIA:</label><br><br>
                                                                          <div style="margin-right: 120px; margin-left: 110px" class="material-switch pull-right">
                                                                            <input id="checkEmpLicenciaRE" name="checkEmpLicenciaRE" type="checkbox" />
                                                                            <label for="checkEmpLicenciaRE" class="label-success1"></label>
                                                                          </div>            
                                                                          <br></td>  

                                                                          <td id="tdnumlicenciaprecontratapermanenteRE" style="display: none"><label class=" control-label label " for="checkEmpLicenciaPermanenteRE">PERMANENETE:</label><br><br>
                                                                            <div style="margin-right: 120px; margin-left: 110px" class="material-switch pull-right">
                                                                              <input id="checkEmpLicenciaPermanenteRE" name="checkEmpLicenciaPermanenteRE" type="checkbox" />
                                                                              <label for="checkEmpLicenciaPermanenteRE" class="label-success1"></label>
                                                                            </div>            
                                                                            <br></td>




                                                                            <td id="tdnumlicenciaRE" style="display: none"><label class=" control-label label " for="numLicenciaRE">No LICENCIA:</label><br>   
                                                                              <input id="numLicenciaRE" name="numLicenciaRE" type="text" class="input-large" maxlength="20"> </td>




                                                                              <td id="tdfechalicenciaRE" style="display: none"><label class=" control-label label " for="fechaLicenciaRE">FECHA VIGENCIA LICENCIA:</label><br>   
                                                                                <input id="fechaLicenciaRE" name="fechaLicenciaRE" type="date" class="input-meium" > </td>


                                                                                <td><label class=" control-label label " for="empImssRE">No AFILIACIÓN IMSS:</label><br>   
                                                                                  <input id="empImssRE" name="empImssRE" type="text" class="input-large" maxlength="11"> </td>

                                                                                </tr> 
                                                                              </table>
                                                                            </td>
                                                                          </tr>
                                                                          <tr>
                                                                            <td> 
                                                                              <table style="table-layout:fixed;" width="1800px">            
                                                                                <tr ><td colspan="2"><center><h4><u style="color: #369C1C">DATOS LABORALES Y ACADEMICOS</u></h4></center></td>
                                                                                </tr>
                                                                                <tr>              

                                                                                  <td><label class=" control-label label " for="empNombreUERE">NOMBRE ULTIMA EMPRESA:</label><br>   
                                                                                    <input id="empNombreUERE" name="empNombreUERE" type="text" class="input-large"> </td>

                                                                                    <td><label class=" control-label label " for="empFecha1E1RE">DESDE:</label><br>   
                                                                                      <input class="input-medium" id="empFecha1E1RE" name="empFecha1E1RE" type="date"> </td>

                                                                                      <td><label class=" control-label label " for="empFecha2E1RE">HASTA:</label><br>   
                                                                                        <input class="input-medium" id="empFecha2E1RE" name="empFecha2E1RE" type="date"> </td>

                                                                                        <td><label class=" control-label label " for="empTelE1RE">TELEFONO:</label><br>   
                                                                                          <input id="empTelE1RE" name="empTelE1RE" type="text" class="input-large"> </td>

                                                                                          <td><label class=" control-label label " for="empCausaSepE1RE">CAUSA SEPARACION:</label><br>   
                                                                                            <input id="empCausaSepE1RE" name="empCausaSepE1RE" type="text" class="input-xlarge" maxlength="20"> </td>


                                                                                          </tr>
                                                                                          <tr>              

                                                                                            <td><label class=" control-label label " for="empNombreEARE">NOMBRE EMPRESA ANTERIOR:</label><br>   
                                                                                              <input id="empNombreEARE" name="empNombreEARE" type="text" class="input-large"> </td>

                                                                                              <td><label class=" control-label label " for="empFecha1E2RE">DESDE:</label><br>   
                                                                                                <input class="input-medium" id="empFecha1E2RE" name="empFecha1E2RE" type="date"> </td>

                                                                                                <td><label class=" control-label label " for="empFecha2E2RE">HASTA:</label><br>   
                                                                                                  <input class="input-medium" id="empFecha2E2RE" name="empFecha2E2RE" type="date"> </td>

                                                                                                  <td><label class=" control-label label " for="empTelE2RE">TELEFONO:</label><br>   
                                                                                                    <input id="empTelE2RE" name="empTelE2RE" type="text" class="input-large"> </td>

                                                                                                    <td><label class=" control-label label " for="empCausaSepE2RE">CAUSA SEPARACION:</label><br>   
                                                                                                      <input id="empCausaSepE2RE" name="empCausaSepE2RE" type="text" class="input-xlarge" maxlength="20"> </td>


                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                      <td><label class=" control-label label " for="checkEmpPersonasRE">HA TENIDO PERSONAS A SU CARGO?:</label><br><br> 
                                                                                                        <span style="margin-left: 60px;">No</span>  
                                                                                                        <span style="margin-left: 40px;">Si</span>    
                                                                                                        <div style="margin-right: 178px;margin-bottom: 20px" class="material-switch pull-right">
                                                                                                          <input id="checkEmpPersonasRE" name="checkEmpPersonasRE" type="checkbox" />
                                                                                                          <label for="checkEmpPersonasRE" class="label-success1"></label>
                                                                                                        </div> 

                                                                                                      </td>   

                                                                                                      <td><label class=" control-label label " for="selectEmpEstudioRE">GRADO DE ESTUDIOS:</label><br>   
                                                                                                        <select id="selectEmpEstudioRE" name="selectEmpEstudioRE" class="input-large"> 
                                                                                                          <option value="">GRADO</option>
                                                                                                          <?php
                                                                                                          for ($i=0; $i<count($catalogoGradoEstudios); $i++)
                                                                                                          {
                                                                                                            echo "<option value='". $catalogoGradoEstudios[$i]["idGradoEstudios"]."'>". $catalogoGradoEstudios[$i]["descripcionGradoEstudios"] ." </option>";
                                                                                                          }
                                                                                                          ?>
                                                                                                        </select> </td>

                                                                                                        <td><label class=" control-label label " for="empCursoEspecialRE">CURSO ESPECIAL:</label><br>   
                                                                                                          <input id="empCursoEspecialRE" name="empCursoEspecialRE" type="text" class="input-xlarge"> </td>
                                                                                                        </tr> 
                                                                                                      </table>
                                                                                                    </td>
                                                                                                  </tr>
                                                                                                  <tr>
                                                                                                    <td> 
                                                                                                      <table style="table-layout:fixed;" width="1800px">            
                                                                                                        <tr ><td colspan="2"><center><h4><u style="color: #369C1C">DATOS FAMILIARES Y REFERENCIAS</u></h4></center></td>
                                                                                                        </tr> 
                                                                                                        <tr>
                                                                                                          <td><label class=" control-label label " for="empEnfermedadRE">ENFERMEDAD O PADECIMIENTO</label><br>   
                                                                                                            <input id="empEnfermedadRE" name="empEnfermedadRE" type="text" class="input-large"> </td>

                                                                                                            <td><label class=" control-label label " for="empPadreRE">PADRE:</label><br>   
                                                                                                              <input id="empPadreRE" name="empPadreRE" type="text" class="input-large"> </td>

                                                                                                              <td><label class=" control-label label " for="empMadreRE">MADRE:</label><br>   
                                                                                                                <input id="empMadreRE" name="empMadreRE" type="text" class="input-large"> </td>

                                                                                                                <td><label class=" control-label label " for="empEsposaRE">ESPOSA (O):</label><br>   
                                                                                                                  <input id="empEsposaRE" name="empEsposaRE" type="text" class="input-large"> </td>

                                                                                                                  <td><label class=" control-label label " for="empHijoRE">HIJOS (HERMANOS):</label><br>   
                                                                                                                    <input id="empHijo1RE" name="empHijo1RE" type="text" class="input-large" placeholder="1:">
                                                                                                                    <input id="empHijo2RE" name="empHijo2RE" type="text" class="input-large" placeholder="2:"> 
                                                                                                                    <input id="empHijo3RE" name="empHijo3RE" type="text" class="input-large" placeholder="3:"> 
                                                                                                                    <input id="empHijo4RE" name="empHijo4RE" type="text" class="input-large" placeholder="4:">
                                                                                                                    <input id="empHijo5RE" name="empHijo5RE" type="text" class="input-large" placeholder="5:"> </td>
                                                                                                                  </tr>
                                                                                                                  <tr>
                                                                                                                    <td><label class=" control-label label " for="empNombreR1RE">NOMBRE REFERENCIA 1:</label><br>   
                                                                                                                      <input id="empNombreR1RE" name="empNombreR1RE" type="text" class="input-large"> </td>

                                                                                                                      <td><label class=" control-label label " for="empTelR1RE">TELEFONO:</label><br>   
                                                                                                                        <input id="empTelR1RE" name="empTelR1RE" type="text" class="input-large"> </td>

                                                                                                                        <td><label class=" control-label label " for="empNombreR2RE">NOMBRE REFERENCIA 2:</label><br>   
                                                                                                                          <input id="empNombreR2RE" name="empNombreR2RE" type="text" class="input-large"> </td>

                                                                                                                          <td><label class=" control-label label " for="empTelR2RE">TELEFONO:</label><br>   
                                                                                                                            <input id="empTelR2RE" name="empTelR2RE" type="text" class="input-large"> </td>
                                                                                                                          </tr>            
                                                                                                                          <tr id="mostrarbtnguardarsolicituReingreso">

                                                                                                                            <td colspan="5"><center><input style="margin-top: 20px; margin-bottom: 20px" id="btnGuardarRE" type="button" class="btn btn-primary"  value="Continuar" onclick="guardarSolicitudReingresoEmpleado();" /></center></td>



                                                                                                                          </tr>  

                                                                                                                          <tr id="mostrabtneditarsolicitudconsultaEmpleado" style="display: none">

                                                                                                                            <td colspan="5"><center><input style="margin-top: 20px; margin-bottom: 20px" id="btnGuardarRE" type="button" class="btn btn-primary"  value="Guardar" onclick="EditarSolicitEmpleo()" /></center></td>



                                                                                                                          </tr>             
                                                                                                                        </table>         
                                                                                                                      </td>
                                                                                                                    </tr>      
                                                                                                                  </table>
                                                                                                                </form>

                                                                                                              </div>

                                                                                                            </div>
                                                                                                          </div>

                                                                                                          <div class="modal fade" tabindex="-1" role="dialog" name="modalCurpInterno" id="modalCurpInterno" data-backdrop="static">
                                                                                                            <div class="modal-dialog" role="document">
                                                                                                              <div class="modal-content">
                                                                                                                <div class="modal-header">
                                                                                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                                                  <h4 class="modal-title"><img src="img/warning.png" id="TituloCurp">ALERTA !!!</h4>
                                                                                                                </div>
                                                                                                                <div class="modal-body">
                                                                                                                  <p><strong id="MensajeCurp"></strong></p>
                                                                                                                </div>
                                                                                                                <div class="modal-footer">
                                                                                                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                                                                                </div>
                                                                                                              </div><!-- /.modal-content -->
                                                                                                            </div><!-- /.modal-dialog -->
                                                                                                          </div><!-- /.modal -->  

    <input id='UltimaDeudahdn'                type='hidden'>
    <input id='EstatusDeudahdn'               type='hidden'>

    <input id='EstatusBetado'                type='hidden'>
    <input id='MotivoBetado'                type='hidden'>
    <input id='ModuloBaja'                type='hidden'>


    <input id='numeroEmpleadohdn'             type='hidden'>
    <input id='fechaIngresohdn'               type='hidden'>
    <input id='nombreCompletohdn'             type='hidden'>
    <input id='estatusEmpleadohdn'            type='hidden'>
    <input id='tipoPeriodohdn'                type='hidden'>
    <input id='empleadoIdPuntoServiciohdn'    type='hidden'>
    <input id='tipoEmpleadohdn'               type='hidden'>
    <input id='idResponsableAsistenciahdn'    type='hidden'>
    <input id='puestoCubiertoIdhdn'           type='hidden'>
    <input id='entidadTrabajohdn'             type='hidden'>
    <input id='empleadoIdGenerohdn'           type='hidden'>
    <input id='estatusImsshdn'                type='hidden'>
    <input id='roloperativohdn'               type='hidden'>
    <input id='foliopreseleccionhdn'          type='hidden'>
    <input id='estatusEmpleadoOperacioneshdn' type='hidden'>
    <input id='DescripcionEntidadTrhdn'       type='hidden'>
    <input id='DeudaEmphdn'                   type='hidden'>
    <input id='estatusEmpleadohidden'                   type='hidden'>

    <div class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="overflow-y: scroll; max-height:85%;  margin-top: 50px; margin-bottom:50px;" id="ModalArchivoDeuda" name="ModalArchivoDeuda">
    <div id="msgerrormodalArchivoDeuda"></div>
      <div class="input-prepend" align="center">
        <h3> Ingresa el Documento de Pago</h3>
      </div><br>
      <div class="input-prepend">
        <span class="add-on">Nombre Empleado</span>
        <input id="NombreEmpleadoDeuda" name="NombreEmpleadoDeuda" type="text" class="input-xlarge" readonly>
      </div><br>

      <div class="input-prepend">
        <span class="add-on">Numero Empleado</span>
        <input id="numempleadoDeuda" name="numempleadoDeuda" type="text" class="input-large" readonly>
      </div><br>

      <div class="input-prepend">
        <span class="add-on">Rol Operativo</span>
        <input id="RolOperativoEmpDeuda" name="RolOperativoEmpDeuda" type="text" class="input-medium" readonly>
      </div><br>

      <div class="input-prepend">
        <span class="add-on">Entidad</span>
        <input id="EntidadEmpDeuda" name="EntidadEmpDeuda" type="text" class="input-medium" readonly>

        <span class="add-on">Deuda</span>
        <input id="DeudaEmp" name="DeudaEmp" type="text" class="input-medium" readonly>
      </div><br>
      
      <div class="card border-success mb-3" style="max-width: 30rem;">
        <div class="card-header"><h4>Cargar Documento</h4></div>    
        <div class="card-body text-primary">
          <label class="control-label label" for="docPago">Selecciona archivo: </label>
          <form enctype='multipart/form-data' id='archivoPagoDeuda' name='archivoPagoDeuda'>
            <span class="btn btn-success btn-file" >Examinar
              <input type='file' class='btn-success' id='docPagoDeuda' name='docPagoDeuda[]' multiple="" /> 
            </span>
          </form>
        </div>            
      </div><br>
      <div class="input-prepend">
      <button id="botonGuardarPago" name="botonGuardarPago" type="button" class="btn btn-primary" style="margin-left: -20%;" >Guardar</button> 
        <button id="botonCancelarPago" name="botonCancelarPago" type="button" class="btn btn-danger" style="margin-left: 60%">Cancelar</button> 
      </div>
    </div>

  <div class="modal fade" tabindex="-1" role="dialog" name="modalErrorBajaImssCuota" id="modalErrorBajaImssCuota" data-backdrop="static">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><img src="img/alert.png">No se puede procesar baja</h4>
        </div>
        <div class="modal-body">
          <p><strong>El empleado carece de una Cuota en tabulares !!</strong></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <!-------------------------------Modales para las tarjetas de despensa------------------------------------------------------------------------------------------->

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

<div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalTarjetaDeDespensaEdit" id="modalTarjetaDeDespensaEdit" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
    
        <h4 class="modal-title"><img src="img/warning.png" id="TituloCurpRegistro">Es Correcto El Número De IUT a Entregar !!</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <label class="control-label label" for="Iut">Número Iut</label>
          <input id="txtNumeroIutModalEdit" name="txtNumeroIutModalEdit" type="text" class="input-xlarge" readonly="true">
          <input id="idTarjetaDespensaEdit" name="idTarjetaDespensaEdit" type="hidden" class="input-xlarge" readonly="true">
          
          <label class="control-label label" for="ComentarioIutEdit">Comentario Iut</label>
          <input id="txtComentarioIutEdit" name="txtComentarioIutEdit" type="text" class="input-xlarge">
        </div> <br>
        <h4> EN CASO DE QUE TENGA QUE CAMBIAR AL SIGUIENTE NÚMERO DE IUT ESPECIFIQUE EL MOTIVO EN EL COMENTARIO Y APLIQUE EN EL BOTON DE SIGUIENTE EN CASO CONTRARIO APLIQUE  ASIGNAR</h4>
        <h5> RECURDE QUE EL APLICAR EN SIGUIENTE EL NÚMERO DE IUT SE DARÁ DE BAJA Y NUNCA SE PODRÁ ASIGNAR</h5>
        <br>
        <center>
          <button type="button" class="btn btn-primary" onclick="CambiarModalesParaValidacionEdit();">Siguiente Iut</button>
        </center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="CambiarDeModalesIngresoEmpleadoEdit();">Asignar Iut</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  

<div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaElectronicaParaBajaTarjetaEdit" id="modalFirmaElectronicaParaBajaTarjetaEdit" data-backdrop="static">
            <div id="errorModalFirmaInternaParaBajaTarjetaEdit"></div>
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h3 class="modal-title" align="center"><img src="img/alert.png">Escribe tu numero de empleado y la contraseña que generaste !!</h3>
                </div>
                <div class="modal-body" align="center">
                  <span class="add-on"># Empleado</span>
                  <input type="text" id="NumEmpModalFirmaParaBajaTarjetaEdit" class="input-medium" name="NumEmpModalFirmaParaBajaTarjetaEdit" placeholder="00-0000-00 Ó 00-00000-00">
                  <input type="hidden" id="NumEmpModalFirmaParaBajaTarjetahiddenEdit" class="input-medium" name="NumEmpModalFirmaParaBajaTarjetahiddenEdit">
                  <span class="add-on">Contraseña</span>
                  <input type="password" id="constraseniaFirmaParaBajaTarjetaEdit" class="input-xlarge"name="constraseniaFirmaParaBajaTarjetaEdit" title="El campo identifica entre mayusculas y minusculas favor de considerarlo">
                  <input type="hidden" id="constraseniaFirmaParaBajaTarjetaHiddenEdit" class="input-xlarge"name="constraseniaFirmaParaBajaTarjetaHiddenEdit">
                </div>
                <div class="modal-body" align="center">
                  <button type="button" id="btnFirmarBajaTarjetaEdit" name="btnFirmarBajaTarjetaEdit" onclick="RevisarFirmaInternaParaBajaTarjetaEdit();" style="display: block;" class="btn btn-primary" >Firmar</button><br>
                  <button type="button" id="btnCancelarFirmaBajaTarjetaEdit" name="btnCancelarFirmaBajaTarjetaEdit"onclick="cancelarFirmaParaBajaTarjetaEdit();" class="btn btn-danger" >Cancelar</button>
                </div>      
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaElectronicaParaEditarEmpleado" id="modalFirmaElectronicaParaEditarEmpleado" data-backdrop="static">
            <div id="errorModalFirmaInternaParaEditarEmpleado12"></div>
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h3 class="modal-title" align="center"><img src="img/alert.png">Escribe tu numero de empleado y la contraseña que generaste !!</h3>
                </div>
                <div class="modal-body" align="center">
                  <span class="add-on"># Empleado</span>
                  <input type="text" id="NumEmpModalFirmaParaEditarEmpleado1" class="input-medium" name="NumEmpModalFirmaParaEditarEmpleado1" placeholder="00-0000-00 Ó 00-00000-00">
                  <span class="add-on">Contraseña</span>
                  <input type="password" id="constraseniaFirmaParaEditarEmpleado" class="input-xlarge"name="constraseniaFirmaParaEditarEmpleado" title="El campo identifica entre mayusculas y minusculas favor de considerarlo">
                </div>
                <div class="modal-body" align="center">
                  <button type="button" id="btnFirmarDoc" name="btnFirmarDoc" onclick="RevisarFirmaInternaParaEditarEmpleado12();" class="btn btn-primary" >Firmar</button><br>
                  <button type="button" id="btnCancelarFirma" name="btnCancelarFirma"onclick="cancelarFirmaParaEnvioDeTarjetaParaEditarEmpleado();" class="btn btn-danger" >Cancelar</button>
                </div>      
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaElectronicaDarDeBajaYCambiarIut" id="modalFirmaElectronicaDarDeBajaYCambiarIut" data-backdrop="static">
            <div id="errorModalFirmaInternaParaDarDeBajaYCambiarIut"></div>
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h3 class="modal-title" align="center"><img src="img/alert.png">Escribe tu numero de empleado y la contraseña que generaste !!</h3>
                </div>
                <div class="modal-body" align="center">
                  <span class="add-on"># Empleado</span>
                  <input type="text" id="NumEmpModalFirmaParaDarDeBajaYCambiarIut" class="input-medium" name="NumEmpModalFirmaParaDarDeBajaYCambiarIut" placeholder="00-0000-00 Ó 00-00000-00">
                  <span class="add-on">Contraseña</span>
                  <input type="password" id="constraseniaFirmaParaDarDeBajaYCambiarIut" class="input-xlarge"name="constraseniaFirmaParaDarDeBajaYCambiarIut" title="El campo identifica entre mayusculas y minusculas favor de considerarlo"><br>

                  <span class="add-on">Motivo Baja</span>
                  <input type="text" id="ComentarioBajaTarjeta" class="input-xlarge"name="ComentarioBajaTarjeta"><br>

                  <h3>Recuerda !!!!  Se dará de baja esta tarjeta de despensa asignada y si desea continuar siga el proceso en caso contrario cancele !!!!! </h3>
                </div>
                <div class="modal-body" align="center">
                  <button type="button" id="btnFirmarDoc" name="btnFirmarDoc" onclick="RevisarFirmaInternaParaDarDeBajaYCambiarIut();" style="display: block;" class="btn btn-primary" >Firmar</button><br>
                  <button type="button" id="btnCancelarFirma" name="btnCancelarFirma"onclick="cancelarFirmaParaDarDeBajaYCambiarIut();" class="btn btn-danger" >Cancelar</button>
                </div>      
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

<div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaReingresosEmpleado" id="modalFirmaReingresosEmpleado" data-backdrop="static">
  <div id="errormodalFirmaReingresoEmpleado"></div>
  <div class="modal-dialog" role="document">
    <div class="modal-content">  
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" align="center"><img src="img/alert.png">Escribe tu numero de empleado y la contraseña que generaste !!</h3>
      </div>
      <div class="modal-body" align="center">
        <span class="add-on"># Empleado</span>
        <input type="text" id="NumEmpModalFirmaParaReingresoEmpleado" class="input-medium" name="NumEmpModalFirmaParaReingresoEmpleado" placeholder="00-0000-00 Ó 00-00000-00">
        <input type="hidden" id="NumEmpModalFirmaParaReingresoEmpleadohidden" class="input-medium" name="NumEmpModalFirmaParaReingresoEmpleadohidden">
        <span class="add-on">Contraseña</span>
        <input type="password" id="constraseniaFirmaParaReingresoEmpleado" class="input-xlarge"name="constraseniaFirmaParaReingresoEmpleado" title="El campo identifica entre mayusculas y minusculas favor de considerarlo">
        <input type="hidden" id="constraseniaFirmaParaReingresoEmpleadoHidden" class="input-xlarge"name="constraseniaFirmaParaReingresoEmpleadoHidden">
      </div>
      <div class="modal-body" align="center">
        <button type="button" id="btnFirmarReingresoEmpleado" name="btnFirmarReingresoEmpleado" onclick="RevisarFirmaInternaParaReingresoEmpleado();" style="display: block;" class="btn btn-primary" >Firmar</button><br>
        <button type="button" id="btnCancelarFirmaReingresoEmpleado" name="btnCancelarFirmaReingresoEmpleado"onclick="cancelarFirmaParaReingresoEmpleado();" class="btn btn-danger" >Cancelar</button>
      </div>      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaConfirmacionSalarioDiarioEdit" id="modalFirmaConfirmacionSalarioDiarioEdit" data-backdrop="static">
  <div id="errormodalConfirmacionSalarioDiarioEdit"></div>
  <div class="modal-dialog" role="document">
    <div class="modal-content">  
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" align="center"><img src="img/alert.png">Escribe tu numero de empleado y la contraseña que generaste !!</h3>
      </div>
      <div class="modal-body" align="center">
        <span class="add-on"># Empleado</span>
        <input type="text" id="NumEmpModalFirmaParaConfirmacionSalarioDiarioEdit" class="input-medium" name="NumEmpModalFirmaParaConfirmacionSalarioDiarioEdit" placeholder="00-0000-00 Ó 00-00000-00">
        <input type="hidden" id="NumEmpModalFirmaParaConfirmacionSalarioDiariohiddenEdit" class="input-medium" name="NumEmpModalFirmaParaConfirmacionSalarioDiariohiddenEdit">
        <span class="add-on">Contraseña</span>
        <input type="password" id="constraseniaFirmaParaConfirmacionSalarioDiarioEmpleadoEdit" class="input-xlarge"name="constraseniaFirmaParaConfirmacionSalarioDiarioEmpleadoEdit" title="El campo identifica entre mayusculas y minusculas favor de considerarlo">
        <input type="hidden" id="constraseniaFirmaParaConfirmacionSalarioDiarioEmpleadoHiddenEdit" class="input-xlarge"name="constraseniaFirmaParaConfirmacionSalarioDiarioEmpleadoHiddenEdit">
      </div>
      <div class="modal-body" align="center">
        <button type="button" id="btnFirmarConfirmacionSalarioDiarioEdit" name="btnFirmarConfirmacionSalarioDiarioEdit" onclick="RevisarFirmaInternaParaConfirmacionSalarioDiarioEdit();" style="display: block;" class="btn btn-primary" >Firmar</button><br>
        <button type="button" id="btnCancelarFirmaConfirmacionSalarioDiarioEdit" name="btnCancelarFirmaConfirmacionSalarioDiarioEdit"onclick="cancelarFirmaParaConfirmacionSalarioDiarioEdit();" class="btn btn-danger" >Cancelar</button>
      </div>      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<input id="pshidden" name="pshidden" type="hidden" class="input-small">
<input id="rpHidden" name="rpHidden" type="hidden" class="input-small">
<!-- <input id="banderaCambioRHidden" name="banderaCambioRHidden" type="hidden" class="input-small" > -->
<input id="banderaCambioPS" name="banderaCambioPS" type="hidden" class="input-small">

<div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalCambioPS" id="modalCambioPS" data-backdrop="static">
  <div id="errormodalCambioPs"></div>
  <div class="modal-dialog" role="document">
    <div class="modal-content">  
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" align="center"><img src="img/alert.png">Escribe tu numero de empleado y la contraseña que generaste !!!</h3>
      </div>
      <div class="modal-body" align="center">
        <span class="add-on"># Empleado</span>
        <input type="text" id="NumEmpModalFirmaParaCambioPs" class="input-medium" name="NumEmpModalFirmaParaCambioPs" placeholder="00-0000-00 Ó 00-00000-00">
        <input type="hidden" id="NumEmpModalFirmaCambioPSDiariohidden" class="input-medium" name="NumEmpModalFirmaCambioPSDiariohidden">
        <span class="add-on">Contraseña</span>
        <input type="password" id="constraseniaFirmaParaConfirmacionCambioPS" class="input-xlarge"name="constraseniaFirmaParaConfirmacionCambioPS" title="El campo identifica entre mayusculas y minusculas favor de considerarlo">
        <input type="hidden" id="constraseniaFirmaParaConfirmacionCambioPSHidden" class="input-xlarge"name="constraseniaFirmaParaConfirmacionCambioPSHidden">
      </div>
      <div class="modal-body" align="center">
        <button type="button" id="btnFirmarCambioPs" name="btnFirmarCambioPs" onclick="RevisarFirmaInternaParaCambioPS();" style="display: block;" class="btn btn-primary" >Firmar</button><br>
        <button type="button" id="btnCancelarFirmaConfirmacionCambioPs" name="btnCancelarFirmaConfirmacionCambioPs"onclick="cancelarFirmaParaConfirmacionCambioPS();" class="btn btn-danger" >Cancelar</button>
      </div>      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaConfirmacionSalarioDiarioReingreso" id="modalFirmaConfirmacionSalarioDiarioReingreso" data-backdrop="static">
  <div id="errormodalConfirmacionSalarioDiarioReingreso"></div>
  <div class="modal-dialog" role="document">
    <div class="modal-content">  
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" align="center"><img src="img/alert.png">Escribe tu numero de empleado y la contraseña que generaste !!</h3>
      </div>
      <div class="modal-body" align="center">
        <span class="add-on"># Empleado</span>
        <input type="text" id="NumEmpModalFirmaParaConfirmacionSalarioDiarioReingreso" class="input-medium" name="NumEmpModalFirmaParaConfirmacionSalarioDiarioReingreso" placeholder="00-0000-00 Ó 00-00000-00">
        <input type="hidden" id="NumEmpModalFirmaParaConfirmacionSalarioDiariohiddenReingreso" class="input-medium" name="NumEmpModalFirmaParaConfirmacionSalarioDiariohiddenReingreso">
        <span class="add-on">Contraseña</span>
        <input type="password" id="constraseniaFirmaParaConfirmacionSalarioDiarioEmpleadoReingreso" class="input-xlarge"name="constraseniaFirmaParaConfirmacionSalarioDiarioEmpleadoReingreso" title="El campo identifica entre mayusculas y minusculas favor de considerarlo">
        <input type="hidden" id="constraseniaFirmaParaConfirmacionSalarioDiarioEmpleadoHiddenReingreso" class="input-xlarge"name="constraseniaFirmaParaConfirmacionSalarioDiarioEmpleadoHiddenReingreso">
      </div>
      <div class="modal-body" align="center">
        <button type="button" id="btnFirmarConfirmacionSalarioDiarioReingreso" name="btnFirmarConfirmacionSalarioDiarioReingreso" onclick="RevisarFirmaInternaParaConfirmacionSalarioDiarioReingreso();" style="display: block;" class="btn btn-primary" >Firmar</button><br>
        <button type="button" id="btnCancelarFirmaConfirmacionSalarioDiarioReingreso" name="btnCancelarFirmaConfirmacionSalarioDiarioReingreso"onclick="cancelarFirmaParaConfirmacionSalarioDiarioReingreso();" class="btn btn-danger" >Cancelar</button>
      </div>      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!------------------------------------------------------------------------------------------------------------------------------------>

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


  var existeDatosPersonales=0;
  var existeDirectorio=0;
  var cambio=0;
  var puntoServicioConsulta="";
  var puestoConsulta="";

  var rpNuevo=0;
  var banderaCambioRP=0;

$('#agregarBeneficiarioCP').click(function(){

  var conteoBenef=$("#conteoBeneficiariosCP").val();
  var conteoChecksBenef='0';  
  var ParentescoBeneficiario1=$("#txtParentescoBeneficiarioCP1").val();
  var NombreBeneficiario1=$("#txtNombreBeneficiarioCP1").val();
  var PorcentajeBeneficiario1=$("#txtPorcentajeBeneficiarioCP1").val();

  var ParentescoBeneficiario2=$("#txtParentescoBeneficiarioCP2").val();
  var NombreBeneficiario2=$("#txtNombreBeneficiarioCP2").val();
  var PorcentajeBeneficiario2=$("#txtPorcentajeBeneficiarioCP2").val();

  var ParentescoBeneficiario3=$("#txtParentescoBeneficiarioCP3").val();
  var NombreBeneficiario3=$("#txtNombreBeneficiarioCP3").val();
  var PorcentajeBeneficiario3=$("#txtPorcentajeBeneficiarioCP3").val();

  var ParentescoBeneficiario4=$("#txtParentescoBeneficiarioCP4").val();
  var NombreBeneficiario4=$("#txtNombreBeneficiarioCP4").val();
  var PorcentajeBeneficiario4=$("#txtPorcentajeBeneficiarioCP4").val();

  var ParentescoBeneficiario5=$("#txtParentescoBeneficiarioCP5").val();
  var NombreBeneficiario5=$("#txtNombreBeneficiarioCP5").val();
  var PorcentajeBeneficiario5=$("#txtPorcentajeBeneficiarioCP5").val();

  var ParentescoBeneficiario6=$("#txtParentescoBeneficiarioCP6").val();
  var NombreBeneficiario6=$("#txtNombreBeneficiarioCP6").val();
  var PorcentajeBeneficiario6=$("#txtPorcentajeBeneficiarioCP6").val();

  var ParentescoBeneficiario7=$("#txtParentescoBeneficiarioCP7").val();
  var NombreBeneficiario7=$("#txtNombreBeneficiarioCP7").val();
  var PorcentajeBeneficiario7=$("#txtPorcentajeBeneficiarioCP7").val();

  var ParentescoBeneficiario8=$("#txtParentescoBeneficiarioCP8").val();
  var NombreBeneficiario8=$("#txtNombreBeneficiarioCP8").val();
  var PorcentajeBeneficiario8=$("#txtPorcentajeBeneficiarioCP8").val();

  var ParentescoBeneficiario9=$("#txtParentescoBeneficiarioCP9").val();
  var NombreBeneficiario9=$("#txtNombreBeneficiarioCP9").val();
  var PorcentajeBeneficiario9=$("#txtPorcentajeBeneficiarioCP9").val();

  if(conteoBenef=="0"){
      // $("#checkBeneficiario1").prop("checked", true);
      $("#trBeneficiarioCP1").show();
      $("#conteoBeneficiariosCP").val(1);
      $("#eliminarBeneficiarioCP").show();
      $("#trTitulosBeneficiariosCP").show();
  }

  if(conteoBenef=="1" &&  ParentescoBeneficiario1!='' && NombreBeneficiario1!='' && PorcentajeBeneficiario1!='' && PorcentajeBeneficiario1>0 && PorcentajeBeneficiario1<100){
     $("#trBeneficiarioCP2").show();
     $("#conteoBeneficiariosCP").val(2);
     // $("#checkBeneficiario2").prop("checked", true);
     $("#txtParentescoBeneficiarioCP1").prop("disabled, true");
     $("#txtNombreBeneficiarioCP1").prop("disabled, true");
     $("#txtPorcentajeBeneficiarioCP1").prop("disabled, true");
  }else if(conteoBenef=="1" &&  (ParentescoBeneficiario1=='' || NombreBeneficiario1=='' || PorcentajeBeneficiario1=='' || PorcentajeBeneficiario1<=0 || PorcentajeBeneficiario1>100)){
    alert("INGRESE LOS DATOS COMPLETOS DEL BENEFICIARIO ANTERIOR PARA AGREGAR UNO NUEVO1");
  }

  if(conteoBenef=="2" && ParentescoBeneficiario2!='' && NombreBeneficiario2 !='' && PorcentajeBeneficiario2!='' && PorcentajeBeneficiario2>0 && PorcentajeBeneficiario2<100){
     $("#trBeneficiarioCP3").show();
     $("#conteoBeneficiariosCP").val(3);
      // $("#checkBeneficiario3").prop("checked", true);
  }else if(conteoBenef=="2" && (ParentescoBeneficiario2=='' || NombreBeneficiario2 =='' || PorcentajeBeneficiario2=='' || PorcentajeBeneficiario2<=0 || PorcentajeBeneficiario2>100)){
    alert("INGRESE LOS DATOS COMPLETOS DEL BENEFICIARIO ANTERIOR PARA AGREGAR UNO NUEVO2");
  }
  if(conteoBenef=="3" && ParentescoBeneficiario3!='' && NombreBeneficiario3 !='' && PorcentajeBeneficiario3!='' && PorcentajeBeneficiario3>0 && PorcentajeBeneficiario3<100){
     $("#trBeneficiarioCP4").show();
     $("#conteoBeneficiariosCP").val(4);
      // $("#checkBeneficiario4").prop("checked", true);
  }else if(conteoBenef=="3" && (ParentescoBeneficiario3=='' || NombreBeneficiario3 =='' || PorcentajeBeneficiario3=='' || PorcentajeBeneficiario3<=0 || PorcentajeBeneficiario3>100)){
    alert("INGRESE LOS DATOS COMPLETOS DEL BENEFICIARIO ANTERIOR PARA AGREGAR UNO NUEVO3");
  }
  if(conteoBenef=="4" && ParentescoBeneficiario4!='' && NombreBeneficiario4 !='' && PorcentajeBeneficiario4!='' && PorcentajeBeneficiario4>0 && PorcentajeBeneficiario4<100){
     $("#trBeneficiarioCP5").show();
     $("#conteoBeneficiariosCP").val(5);
      // $("#checkBeneficiario5").prop("checked", true);
  }else if(conteoBenef=="4" && (ParentescoBeneficiario4=='' || NombreBeneficiario4 =='' || PorcentajeBeneficiario4=='' || PorcentajeBeneficiario4<=0 || PorcentajeBeneficiario4>100)){
    alert("INGRESE LOS DATOS COMPLETOS DEL BENEFICIARIO ANTERIOR PARA AGREGAR UNO NUEVO4");
  }
  if(conteoBenef=="5" && ParentescoBeneficiario5!='' && NombreBeneficiario5 !='' && PorcentajeBeneficiario5!='' && PorcentajeBeneficiario5>0 && PorcentajeBeneficiario5<100){
     $("#trBeneficiarioCP6").show();
     $("#conteoBeneficiariosCP").val(6);
      // $("#checkBeneficiario6").prop("checked", true);
  }else if(conteoBenef=="5" && (ParentescoBeneficiario5=='' || NombreBeneficiario5 =='' || PorcentajeBeneficiario5=='' || PorcentajeBeneficiario5<=0 || PorcentajeBeneficiario5>100)){
    alert("INGRESE LOS DATOS COMPLETOS DEL BENEFICIARIO ANTERIOR PARA AGREGAR UNO NUEVO5");
  }
  if(conteoBenef=="6" && ParentescoBeneficiario6!='' && NombreBeneficiario6 !='' && PorcentajeBeneficiario6!='' && PorcentajeBeneficiario6>0 && PorcentajeBeneficiario6<100){
     $("#trBeneficiarioCP7").show();
     $("#conteoBeneficiariosCP").val(7);
      // $("#checkBeneficiario7").prop("checked", true);
  }else if(conteoBenef=="6" && (ParentescoBeneficiario6=='' || NombreBeneficiario6 =='' || PorcentajeBeneficiario6=='' || PorcentajeBeneficiario6<=0 || PorcentajeBeneficiario6>100)){
    alert("INGRESE LOS DATOS COMPLETOS DEL BENEFICIARIO ANTERIOR PARA AGREGAR UNO NUEVO6");
  }
  if(conteoBenef=="7" && ParentescoBeneficiario7!='' && NombreBeneficiario7 !='' && PorcentajeBeneficiario7!='' && PorcentajeBeneficiario7>0 && PorcentajeBeneficiario7<100){
     $("#trBeneficiarioCP8").show();
     $("#conteoBeneficiariosCP").val(8);
      // $("#checkBeneficiario8").prop("checked", true);
  }else if(conteoBenef=="7" && (ParentescoBeneficiario7=='' || NombreBeneficiario7 =='' || PorcentajeBeneficiario7=='' || PorcentajeBeneficiario7<=0 || PorcentajeBeneficiario7>100)){
    alert("INGRESE LOS DATOS COMPLETOS DEL BENEFICIARIO ANTERIOR PARA AGREGAR UNO NUEVO7");
  }

  if(conteoBenef=="8" && ParentescoBeneficiario8!='' && NombreBeneficiario8 !='' && PorcentajeBeneficiario8!='' && PorcentajeBeneficiario8>0 && PorcentajeBeneficiario8<100){
      if(conteoChecksBenef==2){
        alert("NO PUEDE TENER MAS DE 10 BENEFICIARIOS");
      }else{
         $("#trBeneficiarioCP9").show();
         $("#conteoBeneficiariosCP").val(9);
      // $("#checkBeneficiario9").prop("checked", true);
      }
  }else if(conteoBenef=="8" && (ParentescoBeneficiario8=='' || NombreBeneficiario8 =='' || PorcentajeBeneficiario8=='' || PorcentajeBeneficiario8<=0 || PorcentajeBeneficiario8>100)){
    alert("INGRESE LOS DATOS COMPLETOS DEL BENEFICIARIO ANTERIOR PARA AGREGAR UNO NUEVO8");

  }
  if(conteoBenef=="9" && ParentescoBeneficiario9!='' && NombreBeneficiario9 !='' && PorcentajeBeneficiario9!='' && PorcentajeBeneficiario9>0 && PorcentajeBeneficiario9<100){
      if(conteoChecksBenef==1){
        alert("NO PUEDE TENER MAS DE 10 BENEFICIARIOS");
      }else {
            $("#trBeneficiarioCP10").show();
            $("#conteoBeneficiariosCP").val(10);
            $("#agregarBeneficiarioCP").hide();
      }
  }else if(conteoBenef=="9" && (ParentescoBeneficiario9=='' || NombreBeneficiario9 =='' || PorcentajeBeneficiario9=='' || PorcentajeBeneficiario9<=0 || PorcentajeBeneficiario9>100)){
    alert("INGRESE LOS DATOS COMPLETOS DEL BENEFICIARIO ANTERIOR PARA AGREGAR UNO NUEVO9");
    
  }
});

$('#eliminarBeneficiarioCP').click(function() {
    var conteoBenef = $("#conteoBeneficiariosCP").val();

    if(conteoBenef=="10"){
       $("#trBeneficiarioCP10").hide();
       $("#txtNombreBeneficiarioCP10").val("");
       $("#txtParentescoBeneficiarioCP10").val("");
       $("#txtPorcentajeBeneficiario10").val("");
       $("#conteoBeneficiariosCP").val(9);
       $("#agregarBeneficiarioCP").show();
    }if(conteoBenef=="9"){
       $("#trBeneficiarioCP9").hide();
       $("#txtNombreBeneficiarioCP9").val("");
       $("#txtParentescoBeneficiarioCP9").val("");
       $("#txtPorcentajeBeneficiarioCP9").val("");
       $("#conteoBeneficiariosCP").val(8);
    }if(conteoBenef=="8"){
       $("#trBeneficiarioCP8").hide();
       $("#txtNombreBeneficiarioCP8").val("");
       $("#txtParentescoBeneficiarioCP8").val("");
       $("#txtPorcentajeBeneficiarioCP8").val("");
       $("#conteoBeneficiariosCP").val(7);
    }if(conteoBenef=="7"){
       $("#trBeneficiarioCP7").hide();
       $("#txtNombreBeneficiarioCP7").val("");
       $("#txtParentescoBeneficiarioCP7").val("");
       $("#txtPorcentajeBeneficiarioCP7").val("");
       $("#conteoBeneficiariosCP").val(6);
    }if(conteoBenef=="6"){
       $("#trBeneficiarioCP6").hide();
       $("#txtNombreBeneficiarioCP6").val("");
       $("#txtParentescoBeneficiarioCP6").val("");
       $("#txtPorcentajeBeneficiarioCP6").val("");
       $("#conteoBeneficiariosCP").val(5);
    }if(conteoBenef=="5"){
       $("#trBeneficiarioCP5").hide();
       $("#txtNombreBeneficiarioCP5").val("");
       $("#txtParentescoBeneficiarioCP5").val("");
       $("#txtPorcentajeBeneficiarioCP5").val("");
       $("#conteoBeneficiariosCP").val(4);
    }if(conteoBenef=="4"){
       $("#trBeneficiarioCP4").hide();
       $("#txtNombreBeneficiarioCP4").val("");
       $("#txtParentescoBeneficiarioCP4").val("");
       $("#txtPorcentajeBeneficiarioCP4").val("");
       $("#conteoBeneficiariosCP").val(3);
    }if(conteoBenef=="3"){
       $("#trBeneficiarioCP3").hide();
       $("#txtNombreBeneficiarioCP3").val("");
       $("#txtParentescoBeneficiarioCP3").val("");
       $("#txtPorcentajeBeneficiarioCP3").val("");
       $("#conteoBeneficiariosCP").val(2);
    }if(conteoBenef=="2"){
       $("#trBeneficiarioCP2").hide();
       $("#txtNombreBeneficiarioCP2").val("");
       $("#txtParentescoBeneficiarioCP2").val("");
       $("#txtPorcentajeBeneficiarioCP2").val("");
       $("#conteoBeneficiariosCP").val(1);
    }if(conteoBenef=="1"){
       $("#trBeneficiarioCP1").hide();
       $("#txtNombreBeneficiarioCP1").val("");
       $("#txtParentescoBeneficiarioCP1").val("");
       $("#txtPorcentajeBeneficiarioCP1").val("");
       $("#conteoBeneficiariosCP").val(0);
       $("#eliminarBeneficiarioCP").hide();
       $("#trTitulosBeneficiariosCP").hide();
    }
});


function guardarDatosBeneficiarios(){
  var datastring = $("#form_EditaEmpleado").serialize();

  var conteoBenef=$("#conteoBeneficiariosCP").val();
  var porcentajeTotal=0;
  for(var i = 1; i <= conteoBenef; i++) {
      var porcentaje=$("#txtPorcentajeBeneficiarioCP"+i).val();
      var porcentajeTotal=parseInt(porcentaje)+parseInt(porcentajeTotal);
  }
  if(porcentajeTotal>'100'){
    alertMsg1="<div id='msgAlert' class='alert alert-error'>'El porcentaje entre los beneficiarios no puede ser mayor a 100' <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#alertMsg").html(alertMsg1);
    $(document).scrollTop(0);
    $('#msgAlert').delay(3000).fadeOut('slow');
  }else{
        datastring += "&conteoBenef=" + conteoBenef;

              $.ajax({
                  type: "POST",
                  url: "ajax_registrarBeneficiariosCP.php",
                  data: datastring,
                  dataType: "json",
                  success: function(response) {
                      var mensaje=response.message;

                      if(response.status=="success") {
                         alertMsg1="<div id='msgAlert' class='alert alert-success'>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                         $("#alertMsg").html(alertMsg1);
                         $(document).scrollTop(0);
                         $('#msgAlert').delay(3000).fadeOut('slow');
                          verificaConsultaEmpleado();
                      } else if (response.status=="error"){
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
  }//else
}

function ocultarCamposBeneficiarios(){
       $("#trBeneficiarioCP10").hide();
       $("#txtNombreBeneficiarioCP10").val("");
       $("#txtParentescoBeneficiarioCP10").val("");
       $("#txtPorcentajeBeneficiario10").val("");

       $("#trBeneficiarioCP9").hide();
       $("#txtNombreBeneficiarioCP9").val("");
       $("#txtParentescoBeneficiarioCP9").val("");
       $("#txtPorcentajeBeneficiarioCP9").val("");

       $("#trBeneficiarioCP8").hide();
       $("#txtNombreBeneficiarioCP8").val("");
       $("#txtParentescoBeneficiarioCP8").val("");
       $("#txtPorcentajeBeneficiarioCP8").val("");

       $("#trBeneficiarioCP7").hide();
       $("#txtNombreBeneficiarioCP7").val("");
       $("#txtParentescoBeneficiarioCP7").val("");
       $("#txtPorcentajeBeneficiarioCP7").val("");

       $("#trBeneficiarioCP6").hide();
       $("#txtNombreBeneficiarioCP6").val("");
       $("#txtParentescoBeneficiarioCP6").val("");
       $("#txtPorcentajeBeneficiarioCP6").val("");

       $("#trBeneficiarioCP5").hide();
       $("#txtNombreBeneficiarioCP5").val("");
       $("#txtParentescoBeneficiarioCP5").val("");
       $("#txtPorcentajeBeneficiarioCP5").val("");

       $("#trBeneficiarioCP4").hide();
       $("#txtNombreBeneficiarioCP4").val("");
       $("#txtParentescoBeneficiarioCP4").val("");
       $("#txtPorcentajeBeneficiarioCP4").val("");

       $("#trBeneficiarioCP3").hide();
       $("#txtNombreBeneficiarioCP3").val("");
       $("#txtParentescoBeneficiarioCP3").val("");
       $("#txtPorcentajeBeneficiarioCP3").val("");

       $("#trBeneficiarioCP2").hide();
       $("#txtNombreBeneficiarioCP2").val("");
       $("#txtParentescoBeneficiarioCP2").val("");
       $("#txtPorcentajeBeneficiarioCP2").val("");

       $("#trBeneficiarioCP1").hide();
       $("#txtNombreBeneficiarioCP1").val("");
       $("#txtParentescoBeneficiarioCP1").val("");
       $("#txtPorcentajeBeneficiarioCP1").val("");
}
// hasta aqui


$('input[type="checkbox"].style3').checkbox({
  buttonStyle: 'btn-danger',
  buttonStyleChecked: 'btn-success',
  checkedClass: 'icon-check',
  uncheckedClass: 'icon-check-empty'
});

  function obtenerListaEmpleadosActivos()
  {

    var estatusEmpleado=1;
    var tipoEmpleado='03';
    //var fechaConsulta1 = $("#fechaConsulta1").val();

    $.ajax({

      type: "POST",
      url: "ajax_obtenerListaPersonalActivo.php",
      dataType: "json",
      success: function(response) {
        if (response.status == "success")
        {

          var listaPersonalActivo = response.listaPersonalActivo;


          listaPersonalActivoTable="<table class='table table-hover' id='Exportar_a_Excel'><thead><th>Estatus</th><th># Empleado</th><th>Nombre</th><th>Fecha Ingreso</th><th>#IMSS</th><th>Puesto</th><th>Tipo Puesto</th><th>Horario</th><th>Genero</th><th>Estatus Datos Personales</th><th>Estatus Directorio</th><th>Estatus Datos Familiares</th></thead><tbody>";

          for ( var i = 0; i < listaPersonalActivo.length; i++ ){
            var empleadoEntidad = listaPersonalActivo[i].entidadFederativaId;
            var empleadoConsecutivo = listaPersonalActivo[i].empleadoConsecutivoId;
            var empleadoCategoria = listaPersonalActivo[i].empleadoCategoriaId;
            var empleadoApellidoPaterno= listaPersonalActivo[i].apellidoPaterno;
            var empleadoApellidoMaterno= listaPersonalActivo[i].apellidoMaterno;
            var nombreEmpleado= listaPersonalActivo[i].nombreEmpleado;
            var fechaIngresoEmpleado = listaPersonalActivo[i].fechaIngresoEmpleado;
            var empleadoNumeroSeguroSocial =listaPersonalActivo[i].empleadoNumeroSeguroSocial;
            var descripcionPuesto= listaPersonalActivo[i].descripcionPuesto;
            var descripcionCategoria=listaPersonalActivo[i].descripcionCategoria;
            var descripcionTurno=listaPersonalActivo[i].descripcionTurno;
            var descripcionOficio=listaPersonalActivo[i].descripcionOficio;
            var descripcionGenero=listaPersonalActivo[i].descripcionGenero;
            var tipoSangre=listaPersonalActivo[i].tipoSangre;
            var descripcionEstatusEmpleado=listaPersonalActivo[i].descripcionEstatusEmpleado;
            var numeroEmpleadoCompleto=listaPersonalActivo[i].entidadFederativaId +"-"+ listaPersonalActivo[i].empleadoConsecutivoId+"-"+listaPersonalActivo[i].empleadoCategoriaId;
            var nombreCompleto=empleadoApellidoPaterno+" "+empleadoApellidoMaterno+" "+nombreEmpleado;
            var estatusDatosPersonales = listaPersonalActivo[i].datoPersonal;
            var estatusDatosDireccion = listaPersonalActivo[i].directorio;
            var estatusDatosFamiliares = listaPersonalActivo[i].datoFamiliar;
            var estatusEmpleado=listaPersonalActivo[i].empleadoEstatusId;
            var tooltipEstatusEmpleado=listaPersonalActivo[i].descripcionEstatusEmpleado;



            if (estatusDatosPersonales !=0)
            {
              imgEstatusDatosPersonales="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/folderok.png";
              tooltipDatosPersonales="OK";
            }else{
              imgEstatusDatosPersonales="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/notfolder.png";

              tooltipDatosPersonales="SIN INFORMACION";
            }

            if (estatusDatosDireccion !=0)
            {
              imgEstatusDatosDireccion="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/addressok.png";
            }else{
              imgEstatusDatosDireccion="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/notaddress.png";
            }
            if (estatusDatosFamiliares !=0)
            {
              imgEstatusDatosFamiliares="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/familyok.png";
            }else{
              imgEstatusDatosFamiliares="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/notFamily.png";
            }

            if (estatusEmpleado==1){
              imgEstatusEmpleado="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/empleadoActivo.png";

            }else if(estatusEmpleado==2){
              imgEstatusEmpleado="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/empleadoActivo.png";
            }else
            imgEstatusEmpleado="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/empleadoBaja.png";




            listaPersonalActivoTable += "<tr><td><img class='cursorImg' src='"+imgEstatusEmpleado+ "' data-toggle='tooltip' data-placement='right' title='"+tooltipEstatusEmpleado+"'></td><td>"+numeroEmpleadoCompleto+" </td><td>"+nombreCompleto+
            "</td><td>"+fechaIngresoEmpleado+"</td><td>"+empleadoNumeroSeguroSocial+"</td><td>"
            +descripcionPuesto+"</td><td>"+descripcionCategoria+"</td><td>"+descripcionTurno+"</td><td>"+descripcionGenero+"</td><td><img class='cursorImg' src='"+imgEstatusDatosPersonales+ "' data-toggle='tooltip' data-placement='right' title='"+tooltipDatosPersonales+"'></td><td><img class='cursorImg' src='"+imgEstatusDatosDireccion+ "'></td><td><img class='cursorImg' src='"+imgEstatusDatosFamiliares+ "' ></td><tr>";
          }

          listaPersonalActivoTable += "</tbody></table>";
          $('#listaDePersonalActivo').html(listaPersonalActivoTable); 

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


function verificaConsultaEmpleado()
{
  $("#conteoBeneficiariosCP").val(0);
  var txtSearch = $("#txtSearch").val ();
  var expreg = /^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/;
  var expreg1 = /^[0-9]{2}\-[0-9]{5}\-[0-9]{2}/;

   //alert(txtSearch.length);

   if (txtSearch.length != 10 && txtSearch.length != 11)
   {
    return;
  }

  if(expreg.test(txtSearch) || expreg1.test(txtSearch))
  {
    var numeroEmpleado = $("#txtSearch").val();
    $("#txtSearchName").val("");
    ocultarCamposBeneficiarios();
    consultaEmpleado(numeroEmpleado);


  }else{

  }
}
// AGREGAR CURP
function CreacionCurpInterno(Opcion){
//Decalracion De Los Campos Con Datso A Utilizar
  // alert("a");
var buscadorCP = $("#txtSearch").val();
var edadIngresada = $("#txtEdadCP").val();
var curpEdited1 = $("#txtCurpEdited").val();

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

if(anioEmpleadoXCurp!=edadIngresada){
  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong><center>INGRESE LA EDAD CORRECTA</center></strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
  $("#alertMsg").html(alertMsg1);
  $(document).scrollTop(0);
  $('#msgAlert').delay(3000).fadeOut('slow');
  return;
  }


if(buscadorCP==''){
   alertMsg1="<div id='msgAlert' class='alert alert-error'><strong><center>INGRESE UN NUMERO DE EMPLEADO</center></strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
   $("#alertMsg").html(alertMsg1);
   $(document).scrollTop(0);
   $('#msgAlert').delay(3000).fadeOut('slow');
   return;
  }else if(edadIngresada<18){
    alertMsg1="<div id='msgAlert' class='alert alert-error'><strong><center>LA EDAD DEBE SER MAYOR A 18 AÑOS</center></strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#alertMsg").html(alertMsg1);
    $(document).scrollTop(0);
    $('#msgAlert').delay(3000).fadeOut('slow');
    return;
  }else if(edadIngresada>60){
    alertMsg1="<div id='msgAlert' class='alert alert-error'><strong><center>LA EDAD DEBE SER MENOR A 60 AÑOS</center></strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#alertMsg").html(alertMsg1);
    $(document).scrollTop(0);
    $('#msgAlert').delay(3000).fadeOut('slow');
    return;
  }else if(anioEmpleadoXCurp!=edadIngresada){
    alertMsg1="<div id='msgAlert' class='alert alert-error'><strong><center>INGRESE LA EDAD CORRECTA DEL EMPLEADO</center></strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#alertMsg").html(alertMsg1);
    $(document).scrollTop(0);
    $('#msgAlert').delay(3000).fadeOut('slow');
    return;
  }

var empleadoApellidoPaterno = $("#apellidoPaternoEmpleadoEdited").val();
var empleadoApellidoMaterno = $("#apellidoMaternoEmpleadoEdited").val();
var nombreEmpleado = $("#nombreEmpleadoEdited").val();
var descripcionGenero = $( "input:radio[name=generoEdited]:checked" ).val();
var fechaNacimiento = $("#txtFechaNacimientoEdited").val();
var selectPaisNacimientoEdited = $("#selectPaisNacimientoEdited").val();
// txtCurpEdited
$("#txtCurpInterno").show();
$("#LabelCurpInterno").show();
//Se Agrega la clave de la entidad del empleado
if(selectPaisNacimientoEdited=="46"){
  var claveEntidadF = $("#txtClaveEntidad").val();
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
// Se cambian quitan las letras de excepciones    
if(LetraApellidoP == "Ñ" || LetraApellidoP == "ñ" || LetraApellidoP == "/" || LetraApellidoP == "-" || LetraApellidoP == "."){
  LetraApellidoP="X";
}if(PrimeraVocalApellidoP == "Ñ" || PrimeraVocalApellidoP == "ñ" || PrimeraVocalApellidoP == "/" || PrimeraVocalApellidoP == "-" || PrimeraVocalApellidoP == "." || PrimeraVocalApellidoP == ""){
  PrimeraVocalApellidoP="X";
}if((ConsonanteApellidoP == "Ñ" || ConsonanteApellidoP == "ñ" || ConsonanteApellidoP == "/" || ConsonanteApellidoP == "-" || ConsonanteApellidoP == "." || ConsonanteApellidoP == "") && ( LetraApellidoP != "M" && LetraApellidoP != "m" && LetraApellidoP != "j" && LetraApellidoP != "J")){
  ConsonanteApellidoP="X";
}if(LetraApellidoM == "Ñ" || LetraApellidoM == "ñ" || LetraApellidoM == "/" || LetraApellidoM == "-" || LetraApellidoM == "." || LetraApellidoM == ""){
  LetraApellidoM="X";                          
}if((ConsonanteApellidoM == "Ñ" || ConsonanteApellidoM == "ñ" || ConsonanteApellidoM == "/" || ConsonanteApellidoM == "-" || ConsonanteApellidoM == "." || ConsonanteApellidoM == "") && ( LetraApellidoM != "M" && LetraApellidoM != "m" && LetraApellidoM != "j" && LetraApellidoM != "J")){
  ConsonanteApellidoM="X";                          
}if(letraNombre == "Ñ" || letraNombre == "ñ" || letraNombre == "/" || letraNombre == "-" || letraNombre == "."){
  letraNombre="X";                          
}if((ConsonanteNombre == "Ñ" || ConsonanteNombre == "ñ" || ConsonanteNombre == "/" || ConsonanteNombre == "-" || ConsonanteNombre == ".") && ( letraNombre != "M" && letraNombre != "m" && letraNombre != "j" && letraNombre != "J")){
  ConsonanteNombre="X";                          
}
  // Se obtiene las iniciales de la fecha de nacimiento
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
//se le asigna la letra dependiendo el genero
if(descripcionGenero == "2"){
  var LetraGenero = "H";
}else if(descripcionGenero == "1"){
  var LetraGenero = "M";
}
//Se agrega una x dependiendo si los appellidos o nombres contiene una Ñ o vienen vacios
if((ConsonanteApellidoP == "Ñ" || ConsonanteApellidoP == "ñ" || ConsonanteApellidoP == "/" || ConsonanteApellidoP == "-" || ConsonanteApellidoP == "." || ConsonanteApellidoP == "") && ( LetraApellidoP != "M" && LetraApellidoP != "m" && LetraApellidoP != "j" && LetraApellidoP != "J")){
  ConsonanteApellidoP="X";
}
if((ConsonanteApellidoM == "Ñ" || ConsonanteApellidoM == "ñ" || ConsonanteApellidoM == "/" || ConsonanteApellidoM == "-" || ConsonanteApellidoM == "." || ConsonanteApellidoM == "") && ( LetraApellidoM != "M" && LetraApellidoM != "m" && LetraApellidoM != "j" && LetraApellidoM != "J")){
  ConsonanteApellidoM="X";                          
}
if((ConsonanteNombre == "Ñ" || ConsonanteNombre == "ñ" || ConsonanteNombre == "/" || ConsonanteNombre == "-" || ConsonanteNombre == ".") && ( letraNombre != "M" && letraNombre != "m" && letraNombre != "j" && letraNombre != "J")){
  ConsonanteNombre="X";                          
}
//Se quitan las diÈresis en caso de haber
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

//Se agrupa la palabra antisonante y se consulta para verificar que no sea incorrecta
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
      }
    },
    error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
  });
  var CurpInterno1 = palabraAntisonante+FechaAnio+FechaMes+FechaDia+LetraGenero+claveEntidadF+ConsonanteApellidoP+ConsonanteApellidoM+ConsonanteNombre;
  $("#txtCurpInterno").val(CurpInterno1);
  if(Opcion=="1"){
    RevisionDelCurpIngresadoConElInterno(curpEdited1);
  }
}
function RevisionDelCurpIngresadoConElInterno(curpEdited1){
  var curpInterno1 = $("#txtCurpInterno").val();
  var curpInternoDivididoRfc = curpInterno1.substr(0,10);
  var curpEditedDivididoRfc = curpEdited1.substr(0,10);
  var curpEditedSeparado = curpEdited1.substr(0,16);
  var txtRfcEdited1 = $("#txtRfcEdited").val();
  var rfcAño = txtRfcEdited1.substr(0,10);
  if(curpInterno1 != curpEditedSeparado){
    if($('#checkCurp').is(":checked")){
      if($('#checkRfc').is(":checked")){
        $("#modalCurpInterno").modal("show");
        $("#MensajeCurp").html("Movimiento registrado. La información de la no deducibilidad es responsabilidad de la confirmación con los datos y firma de usuario(Grupo Gif). Al tener  discrepancia con información de RENAPO e imss y sat con padrón activo y declaraciones de la persona físico como de la moral.");
        RevisonUltimosDosDigitosDelCurp();
      }else{
        if(curpEditedDivididoRfc != rfcAño){
          $("#modalCurpInterno").modal("show");
          $("#MensajeCurp").html("El RFC Ingresado : " + rfcAño +" No Coincide Con El Curp Ingresado : " + curpEditedDivididoRfc + " Favor De Revisar, Para Continuar Marque El Campo De '¿Continuar Con EL RFC?' ");
        }else{
          $("#modalCurpInterno").modal("show");
          $("#MensajeCurp").html("Movimiento registrado. La información de la no deducibilidad es responsabilidad de la confirmación con los datos y firma de usuario(Grupo Gif). Al tener  discrepancia con información de RENAPO e imss y sat con padrón activo y declaraciones de la persona físico como de la moral.");
          RevisonUltimosDosDigitosDelCurp(); 
        }
      }
    }else{
      $("#modalCurpInterno").modal("show");
      $("#MensajeCurp").html("Los Primeros 16 Caracteres Del Curp Ingresado : " + curpEditedSeparado +" No Coincide Con El Curp Interno : " + curpInterno1 + " Basado En Los Datos Proporcionados Del Empleado, Favor De Revisar, Si Esta Serguro De Continuar Precione EL Check 'Continuar Con EL CURP'");
      $("#txtCurpInterno").show();
      $("#checkCurp").show();
      $("#LabelCurpInterno").show();
      $("#LabelCheckCurpInterno").show();
      $("#LabelCheckRfcInterno").show();
      $("#checkRfc").show();
      //RevisonUltimosDosDigitosDelCurp();
    }
  }else if(curpInternoDivididoRfc != rfcAño){
    if($('#checkCurp').is(":checked")){
      if($('#checkRfc').is(":checked")){
        $("#modalCurpInterno").modal("show");
        $("#MensajeCurp").html("Movimiento registrado. La información de la no deducibilidad es responsabilidad de la confirmación con los datos y firma de usuario(Grupo Gif). Al tener  discrepancia con información de RENAPO e imss y sat con padrón activo y declaraciones de la persona físico como de la moral.");
        RevisonUltimosDosDigitosDelCurp();
      }else{
        if(curpEditedDivididoRfc != rfcAño){
          $("#modalCurpInterno").modal("show");
          $("#MensajeCurp").html("El RFC Ingresado : " + rfcAño +" No Coincide Con El Curp Ingresado : " + curpEditedDivididoRfc + " Favor De Revisar, Para Continuar Marque El Campo De '¿Continuar Con EL RFC?' ");
        }else{
          $("#modalCurpInterno").modal("show");
        $("#MensajeCurp").html("Movimiento registrado. La información de la no deducibilidad es responsabilidad de la confirmación con los datos y firma de usuario(Grupo Gif). Al tener  discrepancia con información de RENAPO e imss y sat con padrón activo y declaraciones de la persona físico como de la moral.");
          RevisonUltimosDosDigitosDelCurp();
        }
      } 
    }else{
      $("#modalCurpInterno").modal("show");
      $("#MensajeCurp").html("Los Primeros 10 Caracteres Del RFC Ingresado : " + rfcAño +" No Coincide Con El RFC Interno : " + curpInternoDivididoRfc + " Favor De Revisar, Si Esta Serguro De Continuar Precione EL Check 'Continuar Con EL CURP'");
      $("#txtCurpInterno").show();
      $("#checkCurp").show();
      $("#LabelCurpInterno").show();
      $("#LabelCheckCurpInterno").show();
      $("#LabelCheckRfcInterno").show();
      $("#checkRfc").show();
    }
  }else{
    $("#LabelCurpInterno").hide();
    $("#LabelCheckCurpInterno").hide();
    $("#LabelCheckRfcInterno").hide();
    $("#txtCurpInterno").hide();
    $("#checkCurp").hide();
    $("#checkCurp").prop("checked", false);  
    $("#checkRfc").hide();
    $("#checkRfc").prop("checked", false);
    RevisonUltimosDosDigitosDelCurp();
   // editarDatosPersonales();
 }

}
function RevisonUltimosDosDigitosDelCurp(){

  var txtFechaNacimientoEdited2 = $("#txtFechaNacimientoEdited").val();//split
  var txtFechaNacimientoEdited3 = txtFechaNacimientoEdited2.split("-");
  var AñoFecha1 = txtFechaNacimientoEdited3[0];
  var curpEdited2 = $("#txtCurpEdited").val();
  var DigitoAño = curpEdited2.substr(16,1);
  var DigitoUltimo = curpEdited2.substr(17,1);
  
  if((AñoFecha1<2000) && (!/^([0-9])*$/.test(DigitoAño))){
    //alert("entre menos de 2000");
    $("#modalCurpInterno").modal("show");
    $("#MensajeCurp").html("El Penultimo Digito : '" + DigitoAño +"' Debe Ser Numerico Unicamente Ya Que El Empleado Nacio Antes Del Año 2000");

  }else if((AñoFecha1>=2000) && (!/^([A-Z-a-z])*$/.test(DigitoAño))){
    //alert("entre mas de 2000");
    $("#modalCurpInterno").modal("show");
    $("#MensajeCurp").html("El Penultimo Digito : '" + DigitoAño +"' Debe Ser Alfabetico Unicamente Ya Que El Empleado Nacio Despues Del Año 2000");
  }else if(!/^([A-Z-a-z-0-9])*$/.test(DigitoUltimo)){
    //alert("entre Ultimo Digito Mal");
    $("#modalCurpInterno").modal("show");
    $("#MensajeCurp").html("El Ultimo Digito : '" + DigitoUltimo +"' Debe Ser Alfanumerico Unicamente No Se Acpetan Signos De Puntuacion (/.*-,)");
  }else if(!/^([A-Z-a-z-0-9])*$/.test(DigitoUltimo)){
    //alert("entre Ultimo Digito Mal");
    $("#modalCurpInterno").modal("show");
    $("#MensajeCurp").html("El Ultimo Digito : '" + DigitoUltimo +"' Debe Ser Alfanumerico Unicamente No Se Acpetan Signos De Puntuacion (/.*-,)");
  }else{
    //alert("entre todo bien");
    editarDatosPersonales();
  }
  
}
function consultaEmpleado (numeroEmpleado)
{
  $("#EstatusBetado").val(""); 
  $("#MotivoBetado").val("");
  $("#ModuloBaja").val("");
  var numeroEmpleado1 = numeroEmpleado;
   $.ajax({

    type: "POST",
    url: "ajax_obtenerEmpleadoPorId.php",
    data:{"numeroEmpleado":numeroEmpleado1},
    dataType: "json",
    async:false,
    success: function(response) {
              if (response.status == "success")
              {                   
               var empleadoEncontrado = response.empleado;
               if (empleadoEncontrado.length == 0){
                alertMsg1="<div id='msgAlert' class='alert alert-error'><strong><center>No existe Número de empleado</center></strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#alertMsg").html(alertMsg1);
                $(document).scrollTop(0);
                $('#msgAlert').delay(3000).fadeOut('slow');
                limpiarFormulario();
              }else{
                BorrarDatosFiscales();
                LimpiarChecks();
                listaPersonalActivoTable="<table class='table table-hover' id='Exportar_a_Excel'><thead><th>Estatus</th><th># Empleado</th><th>Nombre</th><th>Fecha Ingreso</th><th>#Cta</th><th>Cta Clabe</th><th>Puesto</th><th>Tipo Puesto</th><th>D.P.</th><th>Dir</th><th>D.F</th></thead><tbody>";
                for ( var i = 0; i < empleadoEncontrado.length; i++ ){

                  var claveEntidadF= empleadoEncontrado[i].claveEntidadF;
                  var empleadoEntidad = empleadoEncontrado[i].entidadFederativaId;
                  var empleadoConsecutivo = empleadoEncontrado[i].empleadoConsecutivoId;
                  var empleadoCategoria = empleadoEncontrado[i].empleadoCategoriaId;
                  var empleadoApellidoPaterno= empleadoEncontrado[i].apellidoPaterno;
                  var empleadoApellidoMaterno= empleadoEncontrado[i].apellidoMaterno;
                  var nombreEmpleado= empleadoEncontrado[i].nombreEmpleado;
                  var fechaIngresoEmpleado = empleadoEncontrado[i].fechaIngresoEmpleado;
                  var empleadoNumeroSeguroSocial =empleadoEncontrado[i].empleadoNumeroSeguroSocial;
                  var empleadoNumeroCta =empleadoEncontrado[i].numeroCta;
                  var empleadoNumeroCtaClabe =empleadoEncontrado[i].numeroCtaClabe;
                  var empleadoNumeroTarjetaDespensa =empleadoEncontrado[i].NumeroTarjetaEmpDesp;
                  var empleadoIUTDespensa =empleadoEncontrado[i].idIutTarjeta;
                  var descripcionPuesto= empleadoEncontrado[i].descripcionPuesto;
                  var descripcionCategoria=empleadoEncontrado[i].descripcionCategoria;
                  var descripcionTurno=empleadoEncontrado[i].descripcionTurno;
                  var tipoTurnoId=empleadoEncontrado[i].empleadoIdTurno;
                  var descripcionOficio=empleadoEncontrado[i].descripcionOficio;
                  var descripcionGenero=empleadoEncontrado[i].descripcionGenero;
                  var empleadoIdGenero=empleadoEncontrado[i].empleadoIdGenero;
                  var tipoSangre=empleadoEncontrado[i].tipoSangre;
                  var descripcionEstatusEmpleado=empleadoEncontrado[i].descripcionEstatusEmpleado;
                  var numeroEmpleadoCompleto=empleadoEncontrado[i].entidadFederativaId +"-"+ empleadoEncontrado[i].empleadoConsecutivoId+"-"+empleadoEncontrado[i].empleadoCategoriaId;
                  var nombreCompleto=empleadoApellidoPaterno+" "+empleadoApellidoMaterno+" "+nombreEmpleado;
                  var estatusDatosPersonales = empleadoEncontrado[i].datoPersonal;
                  var estatusDatosDireccion = empleadoEncontrado[i].directorio;
                  var estatusDatosFamiliares = empleadoEncontrado[i].datoFamiliar;
                  var estatusEmpleado=empleadoEncontrado[i].empleadoEstatusId;
                  var tooltipEstatusEmpleado=empleadoEncontrado[i].descripcionEstatusEmpleado;
                  var tipoEmpleado= empleadoEncontrado[i].idTipoPuesto;
                  var empleadoPuesto= empleadoEncontrado[i].empleadoIdPuesto;
                  var IdSucursal=empleadoEncontrado[i].idEntidadTarjeta;
                  var entidadTrabajo=empleadoEncontrado[i].idEntidadTrabajo;
                  var empleadoLocalizacion=empleadoEncontrado[i].empleadoLocalizacion;
                  var empleadoIdPuntoServicio=empleadoEncontrado[i].empleadoIdPuntoServicio;
                  var empleadoLineaNegocioId=empleadoEncontrado[i].empleadoLineaNegocioId;
                  var idResponsableAsistencia= empleadoEncontrado[i].idEntidadResponsableAsistencia+"-"+empleadoEncontrado[i].consecutivoResponsableAsistencia+"-"+empleadoEncontrado[i].tipoResponsableAsistencia;
                  var tipoPeriodo=empleadoEncontrado[i].tipoPeriodo;
                  var empleadoFechaBaja=empleadoEncontrado[i].fechaBajaEmpleado;
                  var clienteId= empleadoEncontrado[i].idCliente;
                  var razonSocial= empleadoEncontrado[i].razonSocial;
                  var medioInformacionVacanteId=empleadoEncontrado[i].medioInformacionVacanteId; 
                  var reclutadorId= empleadoEncontrado[i].reclutadorId;
                  var nombreReclutador=empleadoEncontrado[i].nombreReclutador;
                  var empleadoEstatusImss=empleadoEncontrado[i].empleadoEstatusImss;
                  var descripcionEstatusImss=empleadoEncontrado[i].descripcionEstatusImss;

                  var tesEmpleado=empleadoEncontrado[i].tesEmpleado;
                  var estaturaEmpleado=empleadoEncontrado[i].estaturaEmpleado;
                  var tallaCEmpleado=empleadoEncontrado[i].tallaCEmpleado;
                  var tallaPEmpleado=empleadoEncontrado[i].tallaPEmpleado;
                  var numCalzadoEmpleado=empleadoEncontrado[i].numCalzadoEmpleado;
                  var pesoEmpleado=empleadoEncontrado[i].pesoEmpleado;                        

                  var fechaNacimiento=empleadoEncontrado[i].fechaNacimiento;
                  var paisNacimientoId=empleadoEncontrado[i].paisNacimientoId;
                  var entidadNacimientoId=empleadoEncontrado[i].entidadNacimientoId;
                  var curpEmpleado=empleadoEncontrado[i].curpEmpleado;
                  var rfcEmpleado=empleadoEncontrado[i].rfcEmpleado;
                  var estadoCivilId=empleadoEncontrado[i].estadoCivilId;
                  var gradoEstudiosId=empleadoEncontrado[i].gradoEstudiosId;
                  var tipoSangreId=empleadoEncontrado[i].tipoSangreId;
                  var oficioId=empleadoEncontrado[i].oficioId;
                  var numeroCartilla=empleadoEncontrado[i].numeroCartilla;
                  var estatusCartillaId=empleadoEncontrado[i].estatusCartillaId;
                  var municipioNacimiento=empleadoEncontrado[i].municipioNacimientoId;

                  var codigoPostalAsentamiento=empleadoEncontrado[i].codigoPostalAsentamiento;
                  var nombreEntidadFederativa =empleadoEncontrado[i].nombreEntidadFederativa;
                  var nombreMunicipio=empleadoEncontrado[i].nombreMunicipio;
                  var idAsentamientoDireccion=empleadoEncontrado[i].idAsentamientoDireccion;
                  var nombreAsentamiento=empleadoEncontrado[i].nombreTipoAsentamiento+" "+empleadoEncontrado[i].nombreAsentamiento;
                  var calle=empleadoEncontrado[i].calle;
                  var numeroExterior=empleadoEncontrado[i].numeroExterior;
                  var numeroInterior=empleadoEncontrado[i].numeroInterior;
                  var telefonoFijoEmpleado=empleadoEncontrado[i].telefonoFijoEmpleado;
                  var telefonoMovilEmpleado=empleadoEncontrado[i].telefonoMovilEmpleado;
                  var correoEmpleado=empleadoEncontrado[i].correoEmpleado;
                  var descripcionPuesto=empleadoEncontrado[i].descripcionPuesto;
                  var nombreUnidad=empleadoEncontrado[i].nombreUnidad;
                  var domicilioUnidad=empleadoEncontrado[i].domicilioUnidad;
                  var idUnidadMedicaAsignada=empleadoEncontrado[i].idUnidadMedicaAsignada;
                  var imgEditarEmpleado="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/editarEmpleado.png";
                  var foto = empleadoEncontrado[i].fotoEmpleado;
                  var roloperativo=empleadoEncontrado[i].roloperativo;
                  var requisicionId=empleadoEncontrado[i].requisicionId;
                  
                  var servicioPlantillaId=empleadoEncontrado[i].servicioPlantillaId ;
                  var rolOperativoPlantilla=empleadoEncontrado[i].rolOperativoPlantilla;
                  var IdRolOperativoPlantilla=empleadoEncontrado[i].IdRolOperativoPlantillaEmp;
                  var foilioPreseleccion=empleadoEncontrado[i].foliopreseleccion;

                  var estatusEmpleadoOperaciones=empleadoEncontrado[i].estatusEmpleadoOperaciones;

                  puntoServicioConsulta=empleadoEncontrado[i].empleadoIdPuntoServicio;
                  puestoConsulta=empleadoEncontrado[i].empleadoIdPuesto;
                  var folio=empleadoEncontrado[i].foliopreseleccion;
                  var numlicencia=empleadoEncontrado[i].numlicencia; 
                  var fechavigencialicencia=empleadoEncontrado[i].fechavigencialicencia; 
                  var licenciapermanenente=empleadoEncontrado[i].licenciaconducirpermanente;
                  var DescripcionEntidadTr = empleadoEncontrado[i].nombreEntidadFederativa;
                  var DeudaEmp = empleadoEncontrado[i].DeudaEmp;

                  var edadEmp=empleadoEncontrado[i].edadEmp;
                  var banco=empleadoEncontrado[i].idCuentaBanco;
                  var claveINE=empleadoEncontrado[i].claveINE;
                  var salarioDiario=empleadoEncontrado[i].salarioDiario;

                  var contactoGif = empleadoEncontrado[i].contactoGif;
                  var correoGif = empleadoEncontrado[i].correoGif;
                  var registroPatronal = empleadoEncontrado[i].registroPatronal;
                  var idGerente = empleadoEncontrado[i].noGerenteRegAsignado;
                  var nameGerente = empleadoEncontrado[i].nameGerente;
                  $('#gerenteRegEdited').empty().append('<option value="'+idGerente+'" selected="selected">'+nameGerente+'</option>');
// alert(empleadoPuesto);
                  
                  $("#selBancoEdit").val(banco);
                  $("#txtContactoGifEdited").val(contactoGif);
                  $("#txtCorreoGifEdited").val(correoGif);
                  $("#pshidden").val(empleadoIdPuntoServicio);
                  $("#rpHidden").val(registroPatronal);


                 /* ////////////////////////Datos Fiscales ///////////////////////////////////////

                 var CodigoPostalFiscal = empleadoEncontrado[i].CodigoPostalFiscal;
                 var IdEntidadFiscal = empleadoEncontrado[i].IdEntidadFiscal;
                 var IdmunicipioFiscal = empleadoEncontrado[i].IdmunicipioFiscal;
                 var LocalidadFiscal = empleadoEncontrado[i].LocalidadFiscal;
                 var ColoniaFiscal = empleadoEncontrado[i].ColoniaFiscal;
                 var VialidadFiscal = empleadoEncontrado[i].VialidadFiscal;
                 var TipoVialidadFiscal = empleadoEncontrado[i].TipoVialidadFiscal;
                 var NumeroExtFiscal = empleadoEncontrado[i].NumeroExtFiscal;
                 var NumeroIntFiscal = empleadoEncontrado[i].NumeroIntFiscal;
                 var EstadoDomicilioFiscal = empleadoEncontrado[i].EstadoDomicilioFiscal;
                 $("#multipleDireccionesDatosFiscales").html ("");
      //           CargarSelectoresDatosFiscales1Edit();//Se manda para precargar los selectores De Datos Fiscales
                //////////////////////////////////////////////////////////////////////////////*/
                  $("#clienteBajaRh").val(razonSocial);
                  $("#SalarioDiarioEmpEdit").val(salarioDiario);
                  $("#SalarioDiarioEmpEditAnterior").val(salarioDiario);
                  $("#btnGenrarSalarioDiarioEdit").hide();
                  $("#btnConfirmarSalarioDiarioEdit").hide();
                  $("#btnConfirmadoSalarioDiarioEdit").show();
                  $("#imgMalSalarioDiarioEdit").hide();
                  $("#imgBienSalarioDiarioEdit").show();
                  $("#BanderaSalarioEdit").val(0);
                  if(tipoEmpleado=="02" || empleadoLineaNegocioId !="1"){selectLineaNegocioEdited
                    $("#trSalarioDiario").hide();
                  }else{
                    $("#trSalarioDiario").show();
                  }

                  $("#trlicenciapermanenteEdited").hide();
                  if((numlicencia!='null' && numlicencia!="" && numlicencia!='NULL' && numlicencia!=null  && numlicencia!=" ") ){

                    $("#licenciaConducirsiEMpEdited").prop('checked','cheked'); 
                    $("#numerolicenciaEdited").val(numlicencia);
                    $("#trnumerolicenciaEdited").show(); 
                    $("#trvigencialicenciaEdited").show(); 
                    $("#inpfehavigencialicenciaEdited").val(fechavigencialicencia);  

                    if(licenciapermanenente==1){
                      $("#trlicenciapermanenteEdited").show();
                      $("#licenciaConducirnopermanenteEdited").prop('checked','');
                      $("#licenciaConducirsipermanenteEdited").prop('checked','cheked');
                      $("#trvigencialicenciaEdited").hide(); 
                      $("#inpfehavigencialicenciaEdited").val("");
                    }
                    if(licenciapermanenente==0){
                      $("#trlicenciapermanenteEdited").show();
                      $("#licenciaConducirnopermanenteEdited").prop('checked','cheked');
                      $("#licenciaConducirsipermanenteEdited").prop('checked','');
                      $("#trvigencialicenciaEdited").show(); 
                      $("#inpfehavigencialicenciaEdited").val(fechavigencialicencia);
                    }
                  }else {
                    $("#licenciaConducirnoEMpEdited").prop('checked','cheked'); 
                    $("#numerolicenciaEdited").val("");
                    $("#trnumerolicenciaEdited").hide();
                    $("#trvigencialicenciaEdited").hide(); 
                    $("#inpfehavigencialicenciaEdited").val("");
                  }

                  obtenerSupervisoresOperativos1(idResponsableAsistencia);


                         // Carga la foto del empleado
                         $("#fotoEmpleadoEdited").html ("<img src='thumbs/" + empleadoEncontrado[i].fotoEmpleado + "' />");



                        if (estatusDatosPersonales !=0)
                        {
                          imgEstatusDatosPersonales="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/folderok.png";
                          existeDatosPersonales=1;
                          tooltipDatosPersonales="OK";

                          $("#selectPaisNacimientoEdited").val(paisNacimientoId);
                          $("#selectEntidadNacimientoEdited").val(entidadNacimientoId);
                          $("#selectEstadoCivilEdited").val(estadoCivilId);
                          $("#selectGradoEstudiosEdited").val(gradoEstudiosId);
                          $("#selectTipoSangreEdited").val(tipoSangreId);
                          $("#selectOficioEdited").val(oficioId);
                          $("#txtEdadCP").val(edadEmp);
                          


                        }else{
                          imgEstatusDatosPersonales="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/notfolder.png";
                          existeDatosPersonales=0;
                          tooltipDatosPersonales="SIN INFORMACIÓN";
                          $("#selectEntidadNacimientoEdited").prop('selectedIndex', 0);
                          $("#selectEstadoCivilEdited").prop('selectedIndex', 0);
                          $("#selectOficioEdited").prop('selectedIndex', 0);
                          $("#selectTipoSangreEdited").prop('selectedIndex', 0);
                          $("#selectGradoEstudiosEdited").prop('selectedIndex', 0);
                        }

                        if (estatusDatosDireccion !=0)
                        {
                          imgEstatusDatosDireccion="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/addressok.png";
                          tooltipDatosDireccion="OK";
                          existeDirectorio=1;
                        }else{
                          imgEstatusDatosDireccion="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/notaddress.png";
                          tooltipDatosDireccion="SIN INFORMACIÓN";
                          existeDirectorio=0;
                        }
                        if (estatusDatosFamiliares !=0)
                        {
                          imgEstatusDatosFamiliares="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/familyok.png";
                          tooltipDatosFamiliares="OK";
                          estatusDatosFamiliares =1;
                        }else{
                          imgEstatusDatosFamiliares="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/notFamily.png";
                          tooltipDatosFamiliares="SIN INFORMACIÓN";
                        }


                        if (estatusEmpleado==1){
                          imgEstatusEmpleado="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/empleadoActivo.png";
                          imgAcccion="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/remove.png";
                          tooltipAccion="DAR BAJA";
                          $("#divEditarDatosGenerales"). show();
                          $("#divEditarDatosPersonales").show();
                          $("#divEditarDatosDireccion"). show();
                        }else if(estatusEmpleado==2){
                          imgEstatusEmpleado="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/empleadoActivo.png";
                          imgAcccion="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/remove.png";
                          tooltipAccion="DAR BAJA";
                          $("#divEditarDatosGenerales"). show();
                          $("#divEditarDatosPersonales").show();
                          $("#divEditarDatosDireccion"). show();
                        }else {
                          imgEstatusEmpleado="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/empleadoBaja.png";
                          imgAcccion="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/reingreso.png";
                          tooltipAccion="REINGRESO";
                          $("#divEditarDatosGenerales").hide();
                          $("#divEditarDatosPersonales").hide();
                          $("#divEditarDatosDireccion").show();
                        }

                        $("#numeroEmpleadoEntidadEdited").val(empleadoEntidad);
                        $("#numeroEmpleadoConsecutivoEdited").val(empleadoConsecutivo);
                        $("#numeroEmpleadoTipoEdited").val(empleadoCategoria);
                        $("#apellidoPaternoEmpleadoEdited").val(empleadoApellidoPaterno);
                        $("#apellidoMaternoEmpleadoEdited").val(empleadoApellidoMaterno);
                        $("#nombreEmpleadoEdited").val(nombreEmpleado);
                        $("#numeroSeguroSocialEdited").val(empleadoNumeroSeguroSocial);
                        $("#txtNumeroCtaEdited").val(empleadoNumeroCta);
                        $("#txtCtaClabeEdited").val(empleadoNumeroCtaClabe);
                        $("#idEndidadFederativaEdited").val(entidadTrabajo);
                        $("#idEndidadFederativaParaSucursalEdited").val(empleadoLocalizacion);
                        GetSucursalesIngresadas();                        
                        $("#txtnumeroIutEdited").val(empleadoIUTDespensa); 
                        $("#txtnumeroIutEditedHidden").val(empleadoIUTDespensa);

                        $("#txtEdadCP").val(edadEmp);

                        // if(banco==""){
                        //    swal("Atención","Verifique la cuenta CLABE del empleado, no pertenece a ningún banco registrado por la empresa.", "warning"); 
                        // }

                        if(claveINE!="" && claveINE!="null" && claveINE!=null && claveINE!="NULL" && claveINE!="SIN INFORMACION"){
                           var letra1= claveINE[0];
                           var letra2= claveINE[1];
                           var letra3= claveINE[2];
                           var letra4= claveINE[3];
                           var letra5= claveINE[4];
                           var letra6= claveINE[5];
                           var claveT1Completo=letra1+letra2+letra3+letra4+letra5+letra6;
                           $("#txtClaveINET1Edited").val(claveT1Completo);
                            
                           var numero1= claveINE[6];
                           var numero2= claveINE[7];
                           var numero3= claveINE[8];
                           var numero4= claveINE[9];
                           var numero5= claveINE[10];
                           var numero6= claveINE[11];
                           var claveT2Completo=numero1+numero2+numero3+numero4+numero5+numero6;
                           $("#txtClaveINET2Edited").val(claveT2Completo);

                           var ef1= claveINE[12];
                           var ef2= claveINE[13];
                           var claveEFCompleto=ef1+ef2;
                           $("#IdEFClaveINE").val(claveEFCompleto);

                           var generoClaveINE= claveINE[14];
                           $("#IdGeneroClaveINE").val(generoClaveINE);

                           var alfaNumeric1= claveINE[15];
                           var alfaNumeric2= claveINE[16];
                           var alfaNumeric3= claveINE[17];
                           var alfaNumericCompleto=alfaNumeric1+alfaNumeric2+alfaNumeric3;
                           $("#txtClaveINET3Edited").val(alfaNumericCompleto);
                        }else{
                           $("#txtClaveINET1Edited").val("");
                           $("#txtClaveINET2Edited").val("");
                           $("#IdEFClaveINE").val(0);
                           $("#IdGeneroClaveINE").val(1);
                           $("#txtClaveINET3Edited").val("");
                        }

                        if(empleadoIUTDespensa =="0" || empleadoIUTDespensa=='' || empleadoIUTDespensa== "null" || empleadoIUTDespensa=="NULL" || empleadoIUTDespensa == null){
                          $("#TarjetaDespensaSiEdit").prop('checked','');
                          $("#TarjetaDespensaNoEdit").prop('checked','checked');
                          $("#tieneIutConsulta").val("0");
                          var traerDocumentoTarjeta = "0";

                          var ss = document.getElementById("txtnumeroIutEdited");
                          ss.style.backgroundColor = "#FFFFFF"; 
                          $("#trTarjetaEdit").hide();
                        }else{
 
                          $("#TarjetaDespensaSiEdit").prop('checked','checked');
                          $("#TarjetaDespensaNoEdit").prop('checked','');
                          $("#tieneIutConsulta").val("1");
                          var traerDocumentoTarjeta = "1";
                          
                          var ss = document.getElementById("txtnumeroIutEdited");
                          ss.style.backgroundColor = "#ABEBC6";
                          $("#trTarjetaEdit").show(); 
                        }                    
                        $("#IdSucursal").val(IdSucursal);  
                        $("#IdSucursalhiddeninput").val(IdSucursal);                                 
                        $("#fechaIngresoEdited").val(fechaIngresoEmpleado);

                        $("#tipoPuestoEdited").val(tipoEmpleado);
                        $("#selectLineaNegocioEdited").val(empleadoLineaNegocioId);

                        $("#tesEdited").val(tesEmpleado);
                        $("#estaturaEmpleadoEdited").val(estaturaEmpleado);                       
                        $("#tallaCEmpleadoEdited").val(tallaCEmpleado);                      
                        $("#tallaPEmpleadoEdited").val(tallaPEmpleado);
                        $("#numEmpleadoEdited").val(numCalzadoEmpleado);
                        $("#pesoEmpleadoEdited").val(pesoEmpleado);
                        $("#estatusEmpleadohidden").val(estatusEmpleado);

                        $("#inppuntoServicioanterior").val(empleadoIdPuntoServicio); 
                        $("#inpestatusoperaciones").val(estatusEmpleadoOperaciones);    
                      $("#idRolOpertaivoPorPlantilla").val(IdRolOperativoPlantilla);

                      $("#selplantillaserv").empty().append('<option value="'+requisicionId+'" selected="selected">' + roloperativo + '_' + requisicionId +'</option>');
                      var idHoario=empleadoEncontrado[i].idHoario ;

                      obtenerHorariosPorPlantillaEdicion(requisicionId,1,idHoario);
                      $("#txtidPlantillaOriginal").val(servicioPlantillaId);

                      var TarjetaDes="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-tarjetaSiVale.png";
                      var solicitudC="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-solicitud.png";
                      var PolizaDeVida="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-PolizaDeVida.png";
                      var editsolicitud="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/editIcon.png"; 

                      var testMedicoC="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-doctor.png";
                      var eticoC="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-etica.png";
                      var constanciaC="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-servicio.png";
                      var protestaC="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-protesta.png";
                      var dopingC="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-doping.png";
                      var renunciaC="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-renuncia.png";
                      var cCompromisoC="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-compromiso.png";
                      var privacidadC="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-privacidad.png";
                      var croquisC="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-croquis.png";
                      var cCompromisoMS="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/medidasSanitarias.png";








                      if(empleadoLineaNegocioId==3){

                        getMediosInformacionVacanteEdited(medioInformacionVacanteId);

                      }else if(empleadoLineaNegocioId==2){

                        getMediosInformacionVacanteEdited(medioInformacionVacanteId);

                      }else if(empleadoLineaNegocioId==1){                        
                        if(tipoEmpleado==2){

                          getMediosInformacionVacanteEdited(medioInformacionVacanteId);
                        }else if(tipoEmpleado==3){

                          if(medioInformacionVacanteId==6 || medioInformacionVacanteId==null ){
                            $("#divMedioInformacionEdited").html("");
                            $("#divLblMedioEdited").html("");
                            getReclutadoresSeguridadFisicaEdited(reclutadorId);

                          }else if (medioInformacionVacanteId!=6){
                            $("#divReclutadorEdited").html("");
                            $("#divLblReclutadorEdited").html("");

                            getMediosInformacionVacanteEdited(medioInformacionVacanteId);
                          }
                        }
                      } 
                      seleccionarDepartamento();
                      seleccionarPuestoPorTipo(empleadoPuesto);
                      obtenerSupervisoresOperativos1(idResponsableAsistencia);
                      obtenerListaPuntosServiciosPorEntidad1(empleadoIdPuntoServicio);
                      consultarMunicipiosPorEntidadE(municipioNacimiento);


                      $("#txtFechaNacimientoEdited").val(fechaNacimiento);
                      
                      //$("#txtMunicipioNacEdited").val(municipioNacimiento);
                      $("#txtCurpEdited").val(curpEmpleado);
                      $("#txtRfcEdited").val(rfcEmpleado);
                      
                      $("#txtNumeroCartillaEdited").val(numeroCartilla);
                      
                      $("#selectPuntoServicioEdited").val(empleadoIdPuntoServicio);

                      $("#txtClienteIdEdited").val(clienteId);

                      $("#txtCPEdited").val(codigoPostalAsentamiento);
                      $("#txtIdAsentamientoEdited").val(idAsentamientoDireccion);
                      $("#txtEntidadViviendaEdited").val(nombreEntidadFederativa);
                      $("#txtMunicipioViviendaEdited").val(nombreMunicipio);
                      $("#txtColoniaEdited").val(nombreAsentamiento);
                      $("#txtCalleEdited").val(calle);
                      $("#txtNumeroExtEdited").val(numeroExterior);
                      $("#txtNumeroIntEdited").val(numeroInterior);
                      $("#txtTelefonoMovilEdited").val(telefonoMovilEmpleado);
                      $("#txtTelefonoFijoEdited").val(telefonoFijoEmpleado);
                      $("#txtCorreoEdited").val(correoEmpleado);
                      $("#txtNombreUmfEdited").val(nombreUnidad);
                      $("#txtDireccionUmfEdited").val(domicilioUnidad);
                      $("#txtIdUmfEdited").val(idUnidadMedicaAsignada);
                      $("#tipoTurnoEdited").val(tipoTurnoId);
                      //*************************llenadno ocultos para comparar si alguno de los datos fuen modificado en la funcion que guardara el historico de ediciones***********************************////////////////
                      $("#hdnnumcuentaanterior").val(empleadoNumeroCta);
                      $("#hdnnumcuentaclabeanteriror").val(empleadoNumeroCtaClabe);
                      $("#hdncorreoanterior").val(correoEmpleado);

                      if (empleadoPuesto==6){
                    consultarGerentesRegXSup();
                  }

                    /*  /////////////////////Datos Fiscales ///////////////////////////////////
                      $("#CodigoPostalDatosFiscales").val(CodigoPostalFiscal);
                      $("#EntidadDatosFiscales").val(IdEntidadFiscal);
                      $("#MunicipioDatosFiscales").val(IdmunicipioFiscal);
                      $("#LocalidadDatosFiscales").val(LocalidadFiscal);
                      $("#ColoniaDatosFiscales").val(ColoniaFiscal);
                      $("#VialidadDatosFiscales").val(VialidadFiscal);
                      $("#TipoVidalidadDatosFiscales").val(TipoVialidadFiscal);
                      $("#NumExternoDatosFiscales").val(NumeroExtFiscal);
                      $("#NumInternoDatosFiscales").val(NumeroIntFiscal);
                      $("#EstadoDoicilioDatosFiscales").val(EstadoDomicilioFiscal);
                      //////////////////////////////////////////////////////////////////////*/
                      bloquearDatosFiscales();
consultarDocumentos();                                   

if (estatusEmpleado==0){
  var txtFechaBaja="<td><label class='control-label label' for='lblFechaBaja' name='lblFechaBaja' id='lblFechaBaja'>Fecha Baja</label></td><td><input type='date' name='txtfechaBajaEmpleado' id='txtfechaBajaEmpleado' class='input-medium'></td>";
  $("#trFechaBaja").html(txtFechaBaja);
  $("#txtfechaBajaEmpleado").val(empleadoFechaBaja);
  $( "#txtfechaBajaEmpleado" ).prop( "disabled", true );
}else
{
  $("#txtfechaBajaEmpleado").remove();
  $("#lblFechaBaja").remove();
}


if (empleadoIdGenero==1){

  jQuery("#1generoEdited").prop('checked', true);

}else if(empleadoIdGenero==2){
  jQuery("#2generoEdited").prop('checked', true);

}


if (tipoPeriodo==1){

  jQuery("#1periodoEdited").prop('checked', true);

}else if(tipoPeriodo==2){
  jQuery("#2periodoEdited").prop('checked', true);

} else if (tipoPeriodo==3){
  jQuery("#3periodoEdited").prop('checked', true);
}else{
  $("input[name=periodoEdited]").prop('checked', false);
}

$("#selectMedioInformacionEdited").prop('disabled', true);
$("#selectReclutadorEdited").prop('disabled', true);

jQuery("#"+estatusCartillaId+"estatusCartillaEdited").attr('checked', true);

listaPersonalActivoTable += "<tr><td><img class='cursorImg' src='"+imgEstatusEmpleado+ "' data-toggle='tooltip' data-placement='right' title='"+tooltipEstatusEmpleado+"'></td><td>"+numeroEmpleadoCompleto+
" </td><td>"+nombreCompleto+
"</td><td>"+fechaIngresoEmpleado+"</td><td>"+empleadoNumeroCta+"</td><td>"
+empleadoNumeroCtaClabe+"</td><td>"+descripcionPuesto+"</td><td>"+descripcionCategoria+"</td><td><img class='cursorImg' src='"+imgEstatusDatosPersonales+ 
"' data-toggle='tooltip' data-placement='right' title='"+tooltipDatosPersonales+"'></td><td><img class='cursorImg' src='"+imgEstatusDatosDireccion+ 
"' data-toggle='tooltip' data-placement='right' title='"+tooltipDatosDireccion+"'></td><td><img class='cursorImg' src='"+imgEstatusDatosFamiliares+ 
"' data-toggle='tooltip' data-placement='right' title='"+tooltipDatosFamiliares+
"'></td><td><img class='cursorImg' onclick='mostrarModalBajaEmpleado(\"" + numeroEmpleadoCompleto + "\",\"" +fechaIngresoEmpleado + "\",\"" + nombreCompleto + "\","+ estatusEmpleado+" ,"+ tipoPeriodo +", "+ empleadoIdPuntoServicio +",\"" + tipoEmpleado + "\",\"" + idResponsableAsistencia + "\","+empleadoPuesto+","+entidadTrabajo+", "+empleadoIdGenero+", "+empleadoEstatusImss+",\""+roloperativo+"\",\""+foilioPreseleccion+"\",\""+estatusEmpleadoOperaciones+"\",\""+DescripcionEntidadTr+"\");' src='"
+imgAcccion+ "' data-toggle='tooltip' data-placement='right' title='"
+tooltipAccion+"'></td><td><img class='cursorImg' src='"+imgEditarEmpleado+ 
"' data-toggle='tooltip' data-placement='right' title='EDITAR'></td>";
listaPersonalActivoTable+="<td style='width:2%' ><img style='width:100%' class='cursorImg' src='"+TarjetaDes+"' data-toggle='tooltip' data-placement='right' title='TARJETA DESPENSA SI VALE' onClick='generarResponsivaTarjetaDespensa(\""+traerDocumentoTarjeta+"\",\""+empleadoEntidad+"\",\""+empleadoConsecutivo+"\",\""+empleadoCategoria+"\");' ></td>";
listaPersonalActivoTable+="<td style='width:2%' ><img style='width:100%' class='cursorImg' src='"+solicitudC+"' data-toggle='tooltip' data-placement='right' title='SOLICITUD' onClick='generarSolicitud(\""+folio+"\");' ></td>";
listaPersonalActivoTable+="<td style='width:2%' ><img style='width:100%' class='cursorImg' src='"+PolizaDeVida+"' data-toggle='tooltip' data-placement='right' title='POLIZA DE VIDA' onClick='generarPolizaDeVida();' ></td>";



if(foilioPreseleccion!="null" && foilioPreseleccion!=null && foilioPreseleccion!="NULL"){
  listaPersonalActivoTable+="<td style='width:2%' ><img style='width:100%' class='cursorImg' src='"+editsolicitud+"' data-toggle='tooltip' data-placement='right' title='EDITAR SOLICITUD EMPLEO' onClick='editSolicitud(\""+folio+"\",\""+numeroEmpleadoCompleto+"\");' ></td>";
}
listaPersonalActivoTable+="<td style='width:2%'><img style='width:100%' class='cursorImg' src='"+testMedicoC+"' data-toggle='tooltip' data-placement='right' title='TEST MEDICO' onClick='generarTestMedico(\""+folio+"\");' ></td>";
listaPersonalActivoTable+="<td style='width:2%'><img style='width:100%' class='cursorImg' src='"+eticoC+"' data-toggle='tooltip' data-placement='right' title='PERFIL ÉTICO'  onClick='generarPerfilEtico(\""+folio+"\");' ></td>"; 
listaPersonalActivoTable+="<td style='width:2%'><img style='width:100%' class='cursorImg' src='"+constanciaC+"' data-toggle='tooltip' data-placement='right' title='CONSTANCIA DE SERVICIO'  onClick='generarConstanciaServ(\""+folio+"\");' ></td>";
listaPersonalActivoTable+="<td style='width:2%'><img style='width:100%' class='cursorImg' src='"+protestaC+"' data-toggle='tooltip' data-placement='right' title='PROTESTA' onClick='generarProtesta(\""+folio+"\");'></td>";
listaPersonalActivoTable+="<td style='width:2%'><img style='width:100%'  class='cursorImg' src='"+dopingC+"' data-toggle='tooltip' data-placement='right' title='DOPING' onClick='generarDoping(\""+folio+"\");'></td>";
listaPersonalActivoTable+="<td style='width:2%'><img style='width:100%' class='cursorImg' src='"+renunciaC+"' data-toggle='tooltip' data-placement='right' title='RENUNCIA' onClick='generarRenuncia(\""+folio+"\");' ></td>";
listaPersonalActivoTable+="<td style='width:2%'><img style='width:100%'  class='cursorImg' src='"+cCompromisoC+"' data-toggle='tooltip' data-placement='right' title='CARTA COMPROMISO' onClick='generarCartaCompromiso(\""+folio+"\");'></td>";
listaPersonalActivoTable+="<td style='width:2%'><img style='width:100%' class='cursorImg' src='"+privacidadC+"' data-toggle='tooltip' data-placement='right' title='AVISO DE PRIVACIDAD' onClick='generarAvisoPrivacidad(\""+folio+"\");'></td>";
listaPersonalActivoTable+="<td style='width:2%'><img style='width:100%' class='cursorImg' src='"+croquisC+"' data-toggle='tooltip' data-placement='right' title='CROQUIS' onClick='generarCroquis(\""+folio+"\");'></td>";
listaPersonalActivoTable+="<td style='width:2%'><img style='width:100%'  class='cursorImg' src='"+cCompromisoMS+"' data-toggle='tooltip' data-placement='right' title='CARTA COMPROMISO MEDIDAS SANITARIAS' onClick='generarCartaCompromisoMS(\""+folio+"\");'></td>";
listaPersonalActivoTable+="<tr>";
}

listaPersonalActivoTable += "</tbody></table>";
$('#listaDePersonalActivo').html(listaPersonalActivoTable); 
consultaDatosFamiliares(numeroEmpleadoCompleto);



var botones =$('#divEditarDatosGenerales');                     
var boton = "<button type='button' id='desbloqueoDatosGenerales' name='desbloqueoDatosGenerales' class='btn btn-success' type='button' onclick='desbloquearDatosGenerales();'> <span class='glyphicon glyphicon-refresh'></span>Editar</button>";
botones.html(boton);

$("#divButtonGuardarDatosGenerales").html("");




}
bloquearDatosGenerales();
$("#buttonGuardarDatosPersonales").remove();
$("#desbloqueoDatosPersonales").remove();
var botones =$('#divEditarDatosPersonales');                     
var boton = "<button type='button' id='desbloqueoDatosPersonales' name='desbloqueoDatosPersonales' class='btn btn-success' type='button' onclick='desbloquearDatosPersonales();'> <span class='glyphicon glyphicon-refresh'></span>Editar</button>";
botones.append (boton);
bloquearDatosPersonales();
$("#buttonGuardarDatosDireccion").remove();
$("#desbloqueoDatosDireccion").remove();
var botones =$('#divButtonGuardarDireccion');                     
var boton = "<button type='button' id='desbloqueoDatosDireccion' name='desbloqueoDatosDireccion' class='btn btn-success' type='button' onclick='desbloquearDatosDireccion();'> <span class='glyphicon glyphicon-refresh'></span>Editar</button>";
botones.append (boton);
bloquearDatosGeneralesDirectorio();
hoyFecha();
$("#multipleUmfE").empty();
$("#multipleDireccionesE").empty();

//Consulta Checks Que Ingresaron Al Contratar O Recontratar Al empleado
ConsultaChecksIngresadosInicialmente();
/////////////////////////////////////////////////////////////////////

}else if (response.status == "error" && response.message == "No autorizado")
{
  window.location = "login.php";
}
},
error: function (response)
{
  alert (response.responseText);

}
});



}

// cuando cambien la entidad reconsultar los supervisores
function consultarGerentesRegXSup(){
// alert("entre");
    var entLaborar= $("#idEndidadFederativaEdited").val();
    var lineaNeg= $("#selectLineaNegocioEdited").val();
    var idGerenteActual= $("#gerenteRegEdited").val();

    
    $.ajax({
      type: "POST",
      url: "ajax_ConsultarGerentesReg.php",
      data: {entLaborar,lineaNeg},
      dataType: "json",
      success: function(response) {
        if (response.status == "success"){
           datos = response.datos;
          $('#gerenteRegEdited').empty().append('<option value="0" selected="selected">GERENTE REGIONAL</option>');
          
          for ( var i = 0; i < datos.length; i++ ){
            var noGerente=datos[i].numeroEmpleado;
            if (noGerente == idGerenteActual){
            $('#gerenteRegEdited').append('<option value="' + datos[i].numeroEmpleado + '" selected>' + datos[i].nombreEmpleado+'</option>'); //verificar que rollo con esto
            }else{
              $('#gerenteRegEdited').append('<option value="' + datos[i].numeroEmpleado + '">' + datos[i].nombreEmpleado+'</option>'); //verificar que rollo con esto
            }
          };

          if($('#gerenteRegEdited option').length === 1){
            // de no quedar opciones disponibles en el selector de servicios (solo existiria la opción 0), limpio la lista y coloco una opcion 0 con un mensaje.
            $('#gerenteRegEdited').empty().append('<option value="0" selected="selected">No hay gerentes en esta región actualmente.</option>');
          } 
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });       
  }

function generarPolizaDeVida()
    {
      var folioA=$("#txtSearch").val();

    //  alert(apellido);
      window.open("generadorPolizaDeVida.php?folioAspirante="+folioA+"",'nombre','fullscreen=no');
     //
     //window.open("http://www.cnn.com/", "CNN_WindowName","menubar=yes,location=yes,resizable=yes,scrollbars=yes,status=yes");
      //parent.opener=top;
      //opener.close();

    }

function consultaEmpleadoPorNombre()
{
  var nombre = $("#txtSearchName").val();
  $.ajax({
    type: "POST",
    url: "ajax_obtenerEmpleadoPorNombre.php",
    data:{"nombre":nombre},
    dataType: "json",
    success: function(response) {
    //console.log(response);
    if (response.status == "success")
    {                    
      var empleadoEncontrado = response.empleado;
      listaPersonalActivoTable="<table class='table table-hover' id='Exportar_a_Excel'><thead><th>Estatus Emp</th><th># Empleado</th><th>Nombre</th><th>Fecha Ingreso</th><th>#Cta</th><th>Cta Clabe</th><th>Puesto</th><th>Tipo Puesto</th><th>D.P.</th><th>DIR.</th><th>D.F.</th></thead><tbody>";

      for ( var i = 0; i < empleadoEncontrado.length; i++ ){
        var empleadoEntidad = empleadoEncontrado[i].entidadFederativaId;
        var empleadoConsecutivo = empleadoEncontrado[i].empleadoConsecutivoId;
        var empleadoCategoria = empleadoEncontrado[i].empleadoCategoriaId;
        var empleadoApellidoPaterno= empleadoEncontrado[i].apellidoPaterno;
        var empleadoApellidoMaterno= empleadoEncontrado[i].apellidoMaterno;
        var nombreEmpleado= empleadoEncontrado[i].nombreEmpleado;
        var fechaIngresoEmpleado = empleadoEncontrado[i].fechaIngresoEmpleado;
        var empleadoNumeroSeguroSocial =empleadoEncontrado[i].empleadoNumeroSeguroSocial;
        var empleadoNumeroCta =empleadoEncontrado[i].numeroCta;
        var empleadoNumeroCtaClabe =empleadoEncontrado[i].numeroCtaClabe;
        var descripcionPuesto= empleadoEncontrado[i].descripcionPuesto;
        var descripcionCategoria=empleadoEncontrado[i].descripcionCategoria;
        var descripcionTurno=empleadoEncontrado[i].descripcionTurno;
        var tipoTurnoId=empleadoEncontrado[i].empleadoIdTurno;
        var descripcionOficio=empleadoEncontrado[i].descripcionOficio;
        var descripcionGenero=empleadoEncontrado[i].descripcionGenero;
        var empleadoIdGenero=empleadoEncontrado[i].empleadoIdGenero;
        var tipoSangre=empleadoEncontrado[i].tipoSangre;
        var descripcionEstatusEmpleado=empleadoEncontrado[i].descripcionEstatusEmpleado;
        var numeroEmpleadoCompleto=empleadoEncontrado[i].entidadFederativaId +"-"+ empleadoEncontrado[i].empleadoConsecutivoId+"-"+empleadoEncontrado[i].empleadoCategoriaId;
        var nombreCompleto=empleadoApellidoPaterno+" "+empleadoApellidoMaterno+" "+nombreEmpleado;
        var estatusDatosPersonales = empleadoEncontrado[i].datoPersonal;
        var estatusDatosDireccion = empleadoEncontrado[i].directorio;
        var estatusDatosFamiliares = empleadoEncontrado[i].datoFamiliar;
        var estatusEmpleado=empleadoEncontrado[i].empleadoEstatusId;
        var tooltipEstatusEmpleado=empleadoEncontrado[i].descripcionEstatusEmpleado;
        var tipoEmpleado= empleadoEncontrado[i].idTipoPuesto;
        var empleadoPuesto= empleadoEncontrado[i].empleadoIdPuesto;
        var entidadTrabajo=empleadoEncontrado[i].idEntidadTrabajo;
        var empleadoIdPuntoServicio=empleadoEncontrado[i].empleadoIdPuntoServicio;
        var empleadoLineaNegocioId=empleadoEncontrado[i].empleadoLineaNegocioId;
        var idResponsableAsistencia= empleadoEncontrado[i].idEntidadResponsableAsistencia+"-"+empleadoEncontrado[i].consecutivoResponsableAsistencia+"-"+empleadoEncontrado[i].tipoResponsableAsistencia;
        var tipoPeriodo = empleadoEncontrado[i].tipoPeriodo;
        var empleadoEstatusImss=empleadoEncontrado[i].empleadoEstatusImss;
        var descripcionEstatusImss=empleadoEncontrado[i].descripcionEstatusImss;

        var fechaNacimiento=empleadoEncontrado[i].fechaNacimiento;
        var paisNacimientoId=empleadoEncontrado[i].paisNacimientoId;
        var entidadNacimientoId=empleadoEncontrado[i].entidadNacimientoId;
        var curpEmpleado=empleadoEncontrado[i].curpEmpleado;
        var rfcEmpleado=empleadoEncontrado[i].rfcEmpleado;
        var estadoCivilId=empleadoEncontrado[i].estadoCivilId;
        var gradoEstudiosId=empleadoEncontrado[i].gradoEstudiosId;
        var tipoSangreId=empleadoEncontrado[i].tipoSangreId;
        var oficioId=empleadoEncontrado[i].oficioId;
        var numeroCartilla=empleadoEncontrado[i].numeroCartilla;
        var estatusCartillaId=empleadoEncontrado[i].estatusCartillaId;
        var municipioNacimiento=empleadoEncontrado[i].municipioNacimientoId;

        var codigoPostalAsentamiento=empleadoEncontrado[i].codigoPostalAsentamiento;
        var nombreEntidadFederativa =empleadoEncontrado[i].nombreEntidadFederativa;
        var nombreMunicipio=empleadoEncontrado[i].nombreMunicipio;
        var idAsentamientoDireccion=empleadoEncontrado[i].idAsentamientoDireccion;
        var nombreAsentamiento=empleadoEncontrado[i].nombreTipoAsentamiento+" "+empleadoEncontrado[i].nombreAsentamiento;
        var calle=empleadoEncontrado[i].calle;
        var numeroExterior=empleadoEncontrado[i].numeroExterior;
        var numeroInterior=empleadoEncontrado[i].numeroInterior;
        var telefonoFijoEmpleado=empleadoEncontrado[i].telefonoFijoEmpleado;
        var telefonoMovilEmpleado=empleadoEncontrado[i].telefonoMovilEmpleado;
        var correoEmpleado=empleadoEncontrado[i].correoEmpleado;
        var descripcionPuesto=empleadoEncontrado[i].descripcionPuesto;
        var nombreUnidad=empleadoEncontrado[i].nombreUnidad;
        var domicilioUnidad=empleadoEncontrado[i].domicilioUnidad;
        var idUnidadMedicaAsignada=empleadoEncontrado[i].idUnidadMedicaAsignada;

        puntoServicioConsulta=empleadoEncontrado[i].empleadoIdPuntoServicio;
        puestoConsulta=empleadoEncontrado[i].empleadoIdPuesto;

        var roloperativo=empleadoEncontrado[i].roloperativo;
        var folio=empleadoEncontrado[i].foliopreseleccion;
        var estatusEmpleadoOperaciones=empleadoEncontrado[i].estatusEmpleadoOperaciones;
        var DescripcionEntidadTr = empleadoEncontrado[i].nombreEntidadFederativa;
        var DeudaEmp = empleadoEncontrado[i].DeudaEmp;

        var imgEditarEmpleado="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/editarEmpleado.png";
                      //alert(estatusDatosDireccion);

                      if (estatusDatosPersonales !=0)
                      {
                        imgEstatusDatosPersonales="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/folderok.png";
                        existeDatosPersonales=1;
                        tooltipDatosPersonales="OK";
                      }else{
                        imgEstatusDatosPersonales="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/notfolder.png";
                        existeDatosPersonales=1;
                        tooltipDatosPersonales="SIN INFORMACIÓN";
                      }

                      if (estatusDatosDireccion !=0)
                      {
                        imgEstatusDatosDireccion="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/addressok.png";
                        tooltipDatosDireccion="OK";
                        existeDirectorio=1;
                      }else{
                        imgEstatusDatosDireccion="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/notaddress.png";
                        tooltipDatosDireccion="SIN INFORMACIÓN";
                        existeDirectorio=0;
                      }
                      if (estatusDatosFamiliares !=0)
                      {
                        imgEstatusDatosFamiliares="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/familyok.png";
                        tooltipDatosFamiliares="OK";
                        estatusDatosFamiliares =1;
                      }else{
                        imgEstatusDatosFamiliares="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/notFamily.png";
                        tooltipDatosFamiliares="SIN INFORMACIÓN";
                        estatusDatosFamiliares =0;
                      }

                      if (estatusEmpleado==1){
                        imgEstatusEmpleado="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/empleadoActivo.png";
                        imgAcccion="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/remove.png";
                        tooltipAccion="DAR BAJA";

                      }else if(estatusEmpleado==2){
                        imgEstatusEmpleado="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/empleadoActivo.png";
                        imgAcccion="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/remove.png";
                        tooltipAccion="DAR BAJA";
                      }else {
                        imgEstatusEmpleado="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/empleadoBaja.png";
                        imgAcccion="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/reingreso.png";
                        tooltipAccion="REINGRESO";
                      }
                      var solicitudC="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-solicitud.png";
                      var PolizaDeVida="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-PolizaDeVida.png";
                      var testMedicoC="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-doctor.png";
                      var eticoC="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-etica.png";
                      var constanciaC="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-servicio.png";
                      var protestaC="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-protesta.png";
                      var dopingC="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-doping.png";
                      var renunciaC="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-renuncia.png";
                      var cCompromisoC="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-compromiso.png";
                      var privacidadC="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-privacidad.png";
                      var croquisC="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/icon-croquis.png";
                      var editsolicitud="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]); ?>/img/editIcon.png"; 

                      listaPersonalActivoTable += "<tr><td><img class='cursorImg' src='"+imgEstatusEmpleado+ "' data-toggle='tooltip' data-placement='right' title='"+tooltipEstatusEmpleado+"'></td><td>"+numeroEmpleadoCompleto+" </td><td>"+nombreCompleto+
                      "</td><td>"+fechaIngresoEmpleado+"</td><td>"+empleadoNumeroCta+"</td><td>"
                      +empleadoNumeroCtaClabe+"</td><td>"+descripcionPuesto+"</td><td>"+descripcionCategoria+"</td><td><img class='cursorImg' src='"+imgEstatusDatosPersonales+ "' data-toggle='tooltip' data-placement='right' title='"+tooltipDatosPersonales+
                      "'></td><td><img class='cursorImg' src='"+imgEstatusDatosDireccion+ "' data-toggle='tooltip' data-placement='right' title='"+tooltipDatosDireccion+"'></td><td><img class='cursorImg' src='"+imgEstatusDatosFamiliares+ 
                      "' data-toggle='tooltip' data-placement='right' title='"+tooltipDatosFamiliares+"'></td><td><img class='cursorImg' onclick='mostrarModalBajaEmpleado(\"" + numeroEmpleadoCompleto + "\",\"" +fechaIngresoEmpleado + "\",\"" + nombreCompleto + "\","+ estatusEmpleado+", "+tipoPeriodo+", "+ empleadoIdPuntoServicio +" ,\"" + tipoEmpleado + "\",\"" + idResponsableAsistencia + "\", "+empleadoPuesto+", "+entidadTrabajo+", "+empleadoIdGenero+","+empleadoEstatusImss+" ,\""+roloperativo+"\",\""+folio+"\",\""+estatusEmpleadoOperaciones+"\",\""+DescripcionEntidadTr+"\");' src='"+imgAcccion+ "' data-toggle='tooltip' data-placement='right' title='"+tooltipAccion+
                      "'></td><td><img class='cursorImg'  src='"+imgEditarEmpleado+ 
                      "' data-toggle='tooltip' data-placement='right' title='EDITAR' onClick='consultaEmpleado(\"" + numeroEmpleadoCompleto + "\");'></td>";
                      listaPersonalActivoTable+="<td style='width:2%' ><img style='width:100%' class='cursorImg' src='"+solicitudC+"' data-toggle='tooltip' data-placement='right' title='SOLICITUD' onClick='generarSolicitud(\""+folio+"\");' ></td>";
                      listaPersonalActivoTable+="<td style='width:2%' ><img style='width:100%' class='cursorImg' src='"+PolizaDeVida+"' data-toggle='tooltip' data-placement='right' title='POLIZA DE VIDA' onClick='generarPolizaDeVida(\""+folio+"\");' ></td>";
                      if(folio!="null" && folio!=null && folio!="NULL"){
                        listaPersonalActivoTable+="<td style='width:2%' ><img style='width:100%' class='cursorImg' src='"+editsolicitud+"' data-toggle='tooltip' data-placement='right' title='EDITAR SOLICITUD EMPLEO' onClick='editSolicitud(\""+folio+"\",\""+numeroEmpleadoCompleto+"\");' ></td>";
                      }

                      listaPersonalActivoTable+="<td style='width:2%'><img style='width:100%' class='cursorImg' src='"+testMedicoC+"' data-toggle='tooltip' data-placement='right' title='TEST MEDICO' onClick='generarTestMedico(\""+folio+"\");' ></td>";
                      listaPersonalActivoTable+="<td style='width:2%'><img style='width:100%' class='cursorImg' src='"+eticoC+"' data-toggle='tooltip' data-placement='right' title='PERFIL ÉTICO'  onClick='generarPerfilEtico(\""+folio+"\");' ></td>"; 
                      listaPersonalActivoTable+="<td style='width:2%'><img style='width:100%' class='cursorImg' src='"+constanciaC+"' data-toggle='tooltip' data-placement='right' title='CONSTANCIA DE SERVICIO'  onClick='generarConstanciaServ(\""+folio+"\");' ></td>";
                      listaPersonalActivoTable+="<td style='width:2%'><img style='width:100%' class='cursorImg' src='"+protestaC+"' data-toggle='tooltip' data-placement='right' title='PROTESTA' onClick='generarProtesta(\""+folio+"\");'></td>";
                      listaPersonalActivoTable+="<td style='width:2%'><img style='width:100%'  class='cursorImg' src='"+dopingC+"' data-toggle='tooltip' data-placement='right' title='DOPING' onClick='generarDoping(\""+folio+"\");'></td>";
                      listaPersonalActivoTable+="<td style='width:2%'><img style='width:100%' class='cursorImg' src='"+renunciaC+"' data-toggle='tooltip' data-placement='right' title='RENUNCIA' onClick='generarRenuncia(\""+folio+"\");' ></td>";
                      listaPersonalActivoTable+="<td style='width:2%'><img style='width:100%'  class='cursorImg' src='"+cCompromisoC+"' data-toggle='tooltip' data-placement='right' title='CARTA COMPROMISO' onClick='generarCartaCompromiso(\""+folio+"\");'></td>";
                      listaPersonalActivoTable+="<td style='width:2%'><img style='width:100%' class='cursorImg' src='"+privacidadC+"' data-toggle='tooltip' data-placement='right' title='AVISO DE PRIVACIDAD' onClick='generarAvisoPrivacidad(\""+folio+"\");'></td>";
                      listaPersonalActivoTable+="<td style='width:2%'><img style='width:100%' class='cursorImg' src='"+croquisC+"' data-toggle='tooltip' data-placement='right' title='CROQUIS' onClick='generarCroquis(\""+folio+"\");'></td>";
                      listaPersonalActivoTable+="<tr>";
                    }
                    listaPersonalActivoTable += "</tbody></table>";
                    $('#listaDePersonalActivo').html(listaPersonalActivoTable); 
                    bloquearDatosGenerales();

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

function bloquearDatosGenerales()
{

  $("#apellidoPaternoEmpleadoEdited").prop("disabled", true );
  $("#apellidoMaternoEmpleadoEdited").prop("disabled", true );
  $("#nombreEmpleadoEdited").prop("disabled", true );
  $("#numeroSeguroSocialEdited").prop("disabled", true );
  $("#txtNumeroCtaEdited").prop("disabled", true );
  $("#txtCtaClabeEdited").prop("disabled", true );
  $("#txtnumeroIutEdited").prop("disabled", true );
  $("#TarjetaDespensaSiEdit").prop("disabled", true );
  $("#TarjetaDespensaNoEdit").prop("disabled", true );
  $("#fechaIngresoEdited").prop("disabled", true );
  $("#idEndidadFederativaEdited").prop("disabled", true );
  $("#idEndidadFederativaParaSucursalEdited").prop("disabled", true );
  $("#IdSucursal").prop("disabled", true );
  $("#idDepartamentoPuesto").prop("disabled", true );
  $("#tipoPuestoEdited").prop("disabled", true );
  $("#puestoEdited").prop("disabled", true );
  $("#dirigenteEdited").prop("disabled", true );
  $("#tipoTurnoEdited").prop("disabled", true );
  $("#1generoEdited").prop("disabled", true );
  $("#2generoEdited").prop("disabled", true );
  $("#selectPuntoServicioEdited").prop("disabled", true );
  $("#selectLineaNegocioEdited").prop("disabled", true);
  $("#fileFotoEmpleadoEdited").prop("disabled", true);
  $("input[name=periodoEdited]").attr('disabled', true);
  $("#selectMedioInformacionEdited").prop("disabled", true );
  $("#selectReclutadorEdited").prop("disabled", true );
  $("#tesEdited").prop("disabled", true);
  $("#estaturaEmpleadoEdited").prop("disabled", true);
  $("#tallaCEmpleadoEdited").prop("disabled", true);
  $("#tallaPEmpleadoEdited").prop("disabled", true);
  $("#pesoEmpleadoEdited").prop("disabled", true);
  $("#numEmpleadoEdited").prop("disabled", true);
  $("#selplantillaserv").prop("disabled", true);
  $("#selHorarioCons").prop("disabled", true);
  $("#numerolicenciaEdited").prop("disabled", true);
  $("#numerolicenciasiEdited").prop("disabled", true);
  $("#licenciaConducirsiEMpEdited").prop("disabled", true);
  $("#licenciaConducirnoEMpEdited").prop("disabled", true);
  $("#inpfehavigencialicenciaEdited").prop("disabled", true);
  $("#licenciaConducirsipermanenteEdited").prop("disabled", true);
  $("#licenciaConducirnopermanenteEdited").prop("disabled", true);
  $("#selBancoEdit").prop("disabled", true);
  $("#txtContactoGifEdited").prop("disabled", true);
  $("#txtCorreoGifEdited").prop("disabled", true);
  $("#gerenteRegEdited").prop("disabled", true);





}

function bloquearDatosPersonales()
{

  $("#txtFechaNacimientoEdited").prop("disabled", true );
  $("#selectPaisNacimientoEdited").prop("disabled", true );
  
  $("#txtMunicipioNacEdited").prop("disabled", true );
  $("#selectEntidadNacimientoEdited").prop("disabled", true );
  
  $("#txtCurpEdited").prop("disabled", true );
  $("#txtRfcEdited").prop("disabled", true );
  $("#selectEstadoCivilEdited").prop("disabled", true );
  $("#selectGradoEstudiosEdited").prop("disabled", true );
  $("#selectTipoSangreEdited").prop("disabled", true );
  $("#selectOficioEdited").prop("disabled", true );
  $("#txtNumeroCartillaEdited").prop("disabled", true );
  $("#1estatusCartillaEdited").prop("disabled", true );
  $("#2estatusCartillaEdited").prop("disabled", true );
  $("#3estatusCartillaEdited").prop("disabled", true );
  $("#4estatusCartillaEdited").prop("disabled", true );
  $("#5estatusCartillaEdited").prop("disabled", true );
  $("#txtEdadCP").prop("disabled", true );
  $("#selectMunicipioNacEdited").prop("disabled", true );

  $("#txtClaveINET1Edited").prop("disabled", true );
  $("#txtClaveINET2Edited").prop("disabled", true );
  $("#IdEFClaveINE").prop("disabled", true );
  $("#IdGeneroClaveINE").prop("disabled", true );
  $("#txtClaveINET3Edited").prop("disabled", true );
}




function bloquearDatosGeneralesDirectorio()
{

  $("#txtCPEdited").prop("disabled", true );
  $("#txtCalleEdited").prop("disabled", true );
  $("#txtNumeroIntEdited").prop("disabled", true );
  $("#txtNumeroExtEdited").prop("disabled", true );
  $("#txtTelefonoFijoEdited").prop("disabled", true );
  $("#txtTelefonoMovilEdited").prop("disabled", true );
  $("#txtCorreoEdited").prop("disabled", true );

}
// **************** Departementos edicion *******************************************//
function seleccionarDepartamento() 
{
  var lineaNegocio = $("#selectLineaNegocioEdited").val();
  var tipoPuesto = $("#tipoPuestoEdited").val();
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
            $("#trDeptos").show();
            $("#idDepartamentoPuesto").html (DeptosArray);
            $("#puestoEdited").empty();

          }
        },error: function(jqXHR, textStatus, errorThrown){
           alert(jqXHR.responseText);
        }
      });
    }else{
      $("#trDeptos").hide();
      $("#idDepartamentoPuesto").empty();
      seleccionarPuestoPorTipo();
    }
  }else{
    $("#puestoEdited").empty();
    $("#idDepartamentoPuesto").empty();
  }
}
$("#idDepartamentoPuesto").change(function(){
  var idDepartamentoPuesto = $("#idDepartamentoPuesto").val();
  $('#gerenteRegEdited').empty().append('<option value="0" selected="selected">GERENTE REGIONAL</option>');
  if(idDepartamentoPuesto!="0"){
     seleccionarPuestoPorTipo();
  }
});
function seleccionarPuestoPorTipo(empleadoIdPuesto) 
{
  var lineaNegocio = $("#selectLineaNegocioEdited").val();
  var valorTipo = $("#tipoPuestoEdited").val();
  if(valorTipo=="03"){
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
            puestosOptions += "<option value='" + puestos[i].IdPuesto + "'";
            if (puestos[i].IdPuesto == empleadoIdPuesto)
            {
              puestosOptions += " selected='selected' ";
            }
            puestosOptions += ">" + puestos[i].descripcionPuesto + "</option>";
          }
          $("#puestoEdited").html (puestosOptions);
        }
      },error: function(jqXHR, textStatus, errorThrown){
         alert(jqXHR.responseText);
      }
    });
  }else{
    var idDepartamentoPuesto = $("#idDepartamentoPuesto").val();
    $.ajax({
      type: "POST",
      url: "ajax_seleccionarPuestoPorDepartamento.php",
      data: {"idDepartamentoPuesto": idDepartamentoPuesto,"empleadoIdPuesto": empleadoIdPuesto},
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
            if (datos[i].idPuesto == empleadoIdPuesto){puestosOptions += " selected='selected' ";}
            puestosOptions += ">" + datos[i].descripcionPuesto + "</option>";
          }
            $("#puestoEdited").html (puestosOptions);
            if(idDepartamentoPuesto=="0"){
              $("#idDepartamentoPuesto").val(response.depto);
            }
        }
      },error: function(jqXHR, textStatus, errorThrown){
         alert(jqXHR.responseText);
      }
    });
  }
}
// ******************* Termina Departamentos edicion ***************************//////////


// **************** Departementos Reingreso *******************************************//
function seleccionarDepartamentoReingreso() 
{
  var lineaNegocio = $("#selectLineaNegocioModalR").val();
  var tipoPuesto = $("#selectTipoPuestoReingreso").val();
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
            $("#divDeptosReingreso").show();
            $("#idDepartamentoPuestoReingreso").html (DeptosArray);
            $("#selectPuestoModalR").empty();

          }
        },error: function(jqXHR, textStatus, errorThrown){
           alert(jqXHR.responseText);
        }
      });
    }else{
      $("#divDeptosReingreso").hide();
      $("#idDepartamentoPuestoReingreso").empty();
      seleccionarPuestoPorTipoReingreso();
    }
  }else{
    $("#selectPuestoModalR").empty();
    $("#idDepartamentoPuestoReingreso").empty();
  }
}
$("#idDepartamentoPuestoReingreso").change(function(){
  var idDepartamentoPuesto = $("#idDepartamentoPuestoReingreso").val();
  if(idDepartamentoPuesto!="0"){
     seleccionarPuestoPorTipoReingreso();
  }

  var puesto = $("#selectPuestoModalR").val();
  var entLaborar = $("#selectEntidadLaboralReingreso").val();
  var lineaNeg = $("#selectLineaNegocioModalR").val();

  if((puesto==6 || puesto==126 || puesto==93 || puesto==31 || puesto==144 || puesto==133 || puesto==44 || puesto==122 || puesto==117) && lineaNeg !="LiNEA NEGOCIO" && entLaborar!="ENTIDAD FEDERATIVA"){
          consultarGerentesParaReingreso(entLaborar,lineaNeg);
    }else{
        $('#gerenteRegReingreso').empty().append('<option value="0" selected="selected">GERENTE REGIONAL</option>');
  }
});

function seleccionarPuestoPorTipoReingreso()
{
  var valorTipo = $("#selectTipoPuestoReingreso").val();
  var lineaNegocio = $("#selectLineaNegocioModalR").val();
  if(valorTipo=="03" && lineaNegocio == "1"){
    $("#divSlarioDiarioReingreso").show();
  }else{
    $("#divSlarioDiarioReingreso").hide();
  }

  if(valorTipo=="03"){
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
            puestosOptions += "<option value='" + puestos[i].IdPuesto + "'";
            puestosOptions += ">" + puestos[i].descripcionPuesto + "</option>";
          }     
          $("#selectPuestoModalR").html (puestosOptions);
        }
      },error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }else{
    var idDepartamentoPuesto = $("#idDepartamentoPuestoReingreso").val();
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
            $("#selectPuestoModalR").html (puestosOptions);
        }
      },error: function(jqXHR, textStatus, errorThrown){
         alert(jqXHR.responseText);
      }
    });
  }
}

// ******************* Termina Departamentos Reingreso ***************************//////////


     


     function obtenerListaPuntosServiciosPorEntidad1(empleadoIdPuntoServicio)
     {
       //alert("punto servicio enviado: "+empleadoIdPuntoServicio);
       //var mitexto = $("#tipoPuesto option:selected").text();
       var idEntidad=$("#idEndidadFederativaEdited").val();
       var estatusEmpleadoh=$("#estatusEmpleadohidden").val();
       var estatusPunto=1;
        //alert(idEntidad);
        //alert(estatusPunto);

        $.ajax({
          type: "POST",
          url: "ajax_obtenerPuntoServicioPorEntidad.php",
          data: {"idEntidad": idEntidad, "estatusPunto":estatusPunto, "estatusEmpleadoh":estatusEmpleadoh},
          dataType: "json",
          success: function(response) {
            if (response.status == "success")
            {
              var puntosServicios = response.puntoServicio;

              puntosServiciosOptions = "<option>PUNTOS SERVICIOS</option>";
              for (var i = 0; i < puntosServicios.length; i++)
              {
                puntosServiciosOptions += "<option value='" + puntosServicios[i].idPuntoServicio + "'";

                if (puntosServicios[i].idPuntoServicio == empleadoIdPuntoServicio)
                {
                 puntosServiciosOptions += " selected='selected' "; 
               }

               puntosServiciosOptions += ">" + puntosServicios[i].puntoServicio + "</option>";
             }

             $("#selectPuntoServicioEdited").html (puntosServiciosOptions);
           }
         },
         error: function (response)
         {
          console.log (response);
        }
      });


      }

      function obtenerListaPuntosServiciosReingreso(empleadoIdPuntoServicio)
      {
       //alert("punto servicio enviado: "+empleadoIdPuntoServicio);
       //var mitexto = $("#tipoPuesto option:selected").text();
       var idEntidad=$("#selectEntidadLaboralReingreso").val();
       var estatusPunto=1;
        //alert(idEntidad);
        //alert(estatusPunto);

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
                puntosServiciosOptions += "<option id='opps_"+puntosServicios[i].idPuntoServicio+"' name='opps_"+puntosServicios[i].idPuntoServicio+"'value='" + puntosServicios[i].idPuntoServicio + "' idClientePunto='"+puntosServicios[i].idClientePunto+"'";

                if (puntosServicios[i].idPuntoServicio == empleadoIdPuntoServicio)
                {
                  puntosServiciosOptions += " selected='selected' "; 
                }

                puntosServiciosOptions += ">" + puntosServicios[i].puntoServicio + "</option>";
              }

              $("#selectPuntoServicioModalR").html (puntosServiciosOptions);
            }
          },
          error: function (response)
          {
            console.log (response);
          }
        });


      }

      function seleccionaEstatusCartilla1(genero)
      {

        var generoSeleccion=genero;

      //alert(generoSeleccion);

      if (generoSeleccion==1)
      {

        $("#1estatusCartillaEdited").prop("disabled",true);
        $("#2estatusCartillaEdited").prop("disabled",true);
        $("#3estatusCartillaEdited").prop("disabled",true);
        $("#5estatusCartillaEdited").prop("disabled",true);

        jQuery("#4estatusCartillaEdited").attr('checked',true);


        $("#txtNumeroCartillaEdited").val("NO APLICA");

      }else if (generoSeleccion==2) 
      {

        jQuery("#1estatusCartillaEdited").attr('checked', true);

        $("#4estatusCartillaEdited" ).prop( "disabled", true );

        $("#1estatusCartillaEdited").prop("disabled", false );
        $("#2estatusCartillaEdited").prop("disabled", false );
        $("#3estatusCartillaEdited").prop("disabled", false );
        $("#5estatusCartillaEdited").prop("disabled", false );
        //$("#txtNumeroCartillaEdited").prop("disabled", false );
        $("#txtNumeroCartillaEdited").val("");

      }
    }
    function desbloquearDatosGenerales(){
      
      $("#selBancoEdit").prop("disabled", false);
      $("#apellidoMaternoEmpleadoEdited").prop("disabled", false);
      $("#apellidoPaternoEmpleadoEdited").prop("disabled", false);
      $("#nombreEmpleadoEdited").prop("disabled", false);
      $("#numeroSeguroSocialEdited").prop("disabled", false);
      $("#txtNumeroCtaEdited").prop("disabled", false);
      $("#txtCtaClabeEdited").prop("disabled", false);
      //$("#txtnumeroIutEdited").prop("disabled", false);
      $("#TarjetaDespensaSiEdit").prop("disabled", false);
      $("#TarjetaDespensaNoEdit").prop("disabled", false);
      $("#fechaIngresoEdited").prop("readonly", true);
      $("#IdSucursal").prop("disabled", false);
      $("#idEndidadFederativaEdited").prop("disabled", false);
      $("#idEndidadFederativaParaSucursalEdited").prop("disabled", false);
      $("#tipoPuestoEdited").prop("disabled", false);
      $("#puestoEdited").prop("disabled", false);
      $("#idDepartamentoPuesto").prop("disabled", false);
      $("#dirigenteEdited").prop("disabled", false);
      $("#tipoTurnoEdited").prop("disabled", false);
      $("#1generoEdited").prop("disabled", false);
      $("#2generoEdited").prop("disabled", false);
      $("#selectPuntoServicioEdited").prop("disabled", false);
      $("#selectReclutadorEdited").prop("disabled", false);
      $("#selectMedioInformacionEdited").prop("disabled", false);
      $("#txtfechaBajaEmpleado").prop("disabled", false);
      $("#fileFotoEmpleadoEdited").prop("disabled", false);
      $("input[name=periodoEdited]").attr('disabled', false);

      $("#selectLineaNegocioEdited").prop("disabled", false);
      $("#tesEdited").prop("disabled", false);
      $("#estaturaEmpleadoEdited").prop("disabled", false);
      $("#tallaCEmpleadoEdited").prop("disabled", false);
      $("#tallaPEmpleadoEdited").prop("disabled", false);
      $("#pesoEmpleadoEdited").prop("disabled", false);
      $("#numEmpleadoEdited").prop("disabled", false);
      $("#selplantillaserv").prop("disabled", false);
      $("#selHorarioCons").prop("disabled", false);
      $("#numerolicenciaEdited").prop("disabled", false);
      $("#numerolicenciasiEdited").prop("disabled", false);
      $("#licenciaConducirsiEMpEdited").prop("disabled", false);
      $("#licenciaConducirnoEMpEdited").prop("disabled", false);
      $("#inpfehavigencialicenciaEdited").prop("disabled", false);
      $("#licenciaConducirnopermanenteEdited").prop("disabled", false);
      $("#licenciaConducirsipermanenteEdited").prop("disabled", false);

      $("#txtClaveINET1Edited").prop("disabled", false);
      $("#txtClaveINET2Edited").prop("disabled", false);
      $("#IdEFClaveINE").prop("disabled", false);
      $("#IdGeneroClaveINE").prop("disabled", false);
      $("#txtClaveINET3Edited").prop("disabled", false);

      $("#txtContactoGifEdited").prop("disabled", false);
      $("#txtCorreoGifEdited").prop("disabled", false);
      $("#gerenteRegEdited").prop("disabled", false);
      





      var boton = "<button type='button' class='btn btn-info' id='buttonGuardarDatosGenerales' name='buttonGuardarDatosGenerales' onclick='consultaCambioPS();'><span class='glyphicon glyphicon-save' ></span>Guardar</button>";

      $('#divButtonGuardarDatosGenerales').html(boton);
      $("#desbloqueoDatosGenerales").remove();
    }

function consultaCambioPS(){

  var puesto = $("#puestoEdited").val();
  var gerente = $("#gerenteRegEdited").val();

  if((puesto==6 || puesto==126 || puesto==93 || puesto==31 || puesto==144 || puesto==133 || puesto==44 || puesto==122 || puesto==117) && gerente==0){
    swal("ALTO","Seleccione el gerente regional","warning");
    return;
  }

  var banderaPS = $("#banderaCambioPS").val();
    // alert(banderaPS);
  
    if (banderaPS==1){//si hicieron cambio de punto de servicio al empleado se pide contraseña y se guarda en el historico
        $("#modalCambioPS").modal();
    }else{
          editarDatosGenerales();
    }
}

function editarDatosGenerales(){
  if($("#inppuntoServicioanterior").val() != $("#selectPuntoServicioEdited").val() && $("#inpestatusoperaciones").val()==3){
    alert("No puedes cambiar de punto de servicio al empleado debido que se encuentra en proceso de baja");
  }else{
    var apellidoPaternoEmpleadoEdited = $("#apellidoPaternoEmpleadoEdited").val();
    var apellidoMaternoEmpleadoEdited = $("#apellidoMaternoEmpleadoEdited").val();
    var nombreEmpleadoEdited = $("#nombreEmpleadoEdited").val();
    var apellidoPaternoEmpleadoEdited1 = $.trim(apellidoPaternoEmpleadoEdited);
    var apellidoMaternoEmpleadoEdited1 = $.trim(apellidoMaternoEmpleadoEdited);
    var nombreEmpleadoEdited1 = $.trim(nombreEmpleadoEdited);
    $("#apellidoPaternoEmpleadoEdited").val(apellidoPaternoEmpleadoEdited1);
    $("#apellidoMaternoEmpleadoEdited").val(apellidoMaternoEmpleadoEdited1);
    $("#nombreEmpleadoEdited").val(nombreEmpleadoEdited1);
    var IdRolOperativoPlantilla = $("#idRolOpertaivoPorPlantilla").val();
    var datastring = $("#form_EditaEmpleado").serialize();
    var entidadEmpleado=$("#numeroEmpleadoEntidadEdited").val();
    var empleadoConsecutivo=$("#numeroEmpleadoConsecutivoEdited").val();
    var empleadoTipo=$("#numeroEmpleadoTipoEdited").val();
    var puntoServicioConsultaSend=puntoServicioConsulta;
    var puestoConsultaSend=puestoConsulta;
    var fechaIngresoEdited=$("#fechaIngresoEdited").val();
    var txtCurpEdited = $("#txtCurpEdited").val();
    var txtRfcEdited = $("#txtRfcEdited").val();
    var txtnumeroIutEdited = $("#txtnumeroIutEdited").val();
    var combo = document.getElementById("selplantillaserv");
    var plantillaText1 = combo.options[combo.selectedIndex].text;
    var plantillaText2  = plantillaText1.split("_");
    var plantillaText    = plantillaText2[0];
    var plantillaText_ID= plantillaText2[1];
    var puntoServicio =$("#selectPuntoServicioEdited").val();
    var puestoNuevo =$("#puestoEdited").val();
    var selBancoEdit = $("#selBancoEdit").val();
    var txtClaveINET1 = $("#txtClaveINET1Edited").val();
    var txtClaveINET2 = $("#txtClaveINET2Edited").val();
    var eFClaveINE = $("#IdEFClaveINE").val();
    var generoClaveINE= $("#IdGeneroClaveINE").val();
    var txtClaveINET3 = $("#txtClaveINET3Edited").val();

    var txtContactoGif = $("#txtContactoGifEdited").val();
    var txtCorreoGif = $("#txtCorreoGifEdited").val();

    var gerenteReg = $("#gerenteRegEdited").val();

    var selHorarioCons = $("#selHorarioCons").val();
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
    var claveINECompleta=txtClaveINET1+txtClaveINET2+eFClaveINE+generoClaveINE+txtClaveINET3;
    }else{
          claveINECompleta="SIN INFORMACION";
    }


    var OpcionTarjetaDeDespensaEdit = "0";
    if($('#TarjetaDespensaSiEdit').is(":checked")){
      var OpcionTarjetaDeDespensaEdit = "1";         
    }
    if($('#TarjetaDespensaNoEdit').is(":checked")){
      var OpcionTarjetaDeDespensaEdit = "2";         
    }
    var SalarioDiarioEmpEdit = $("#SalarioDiarioEmpEdit").val();
    var numhide = $("#NumEmpModalFirmaParaConfirmacionSalarioDiariohiddenEdit").val();
    var contrahide = $("#constraseniaFirmaParaConfirmacionSalarioDiarioEmpleadoHiddenEdit").val();
    var BanderaSalario = $("#BanderaSalarioEdit").val();
    var salarioDiariAnterior = $("#SalarioDiarioEmpEditAnterior").val();
   
    datastring += "&puntoServicio=" + puntoServicio; 
    datastring += "&puntoServicioConsultaSend=" + puntoServicioConsultaSend; 
    datastring += "&puestoConsultaSend=" + puestoConsultaSend; 
    datastring += "&fechaIngresoEdited=" + fechaIngresoEdited;
    datastring += "&txtCurpEdited=" + txtCurpEdited;
    datastring += "&txtRfcEdited=" + txtRfcEdited;
    datastring += "&txtnumeroIutEdited=" + txtnumeroIutEdited;
    datastring += "&plantillaText=" + plantillaText;
    datastring += "&OpcionTarjetaDeDespensaEdit=" + OpcionTarjetaDeDespensaEdit;
    datastring += "&claveINE=" + claveINECompleta;

    datastring += "&ContactoGif=" + txtContactoGif;
    datastring += "&CorreoGif=" + txtCorreoGif;

    datastring += "&banderaCambioRP=" + banderaCambioRP;
    datastring += "&rpNuevo=" + rpNuevo;
    datastring += "&selHorarioCons=" + selHorarioCons;

    datastring += "&gerenteRegSupEdit=" + gerenteReg;

    if($("#tipoTurnoEdited").val()=="" || $("#tipoTurnoEdited").val()=="TURNO"){
      $(document).scrollTop(0);
      alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error : </strong> Selecciona Turno<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
      $("#alertMsg").html(alertMsg1);
      $('#msgAlert').delay(3000).fadeOut('slow');
    }else if(SalarioDiarioEmpEdit =="" && BanderaSalario=="1"){      
      swal("Alto", "Genera EL Salario Diario Del Empleado Para Continuar","error");
    }else if(SalarioDiarioEmpEdit !="" && BanderaSalario=="1" && (numhide =="" || contrahide =="")){
      swal("Alto", "Confima EL Salario Diario Del Empleado Para Continuar","error");
    }else if(salarioDiariAnterior > SalarioDiarioEmpEdit && BanderaSalario=="1"){
      swal("Alto", "EL Salario Diario Actual ("+SalarioDiarioEmpEdit+") Del Empleado No Puede Ser Menor Al Salario Diaro Anterior ("+salarioDiariAnterior+")","error");
    }else{
      var banderaPS = $("#banderaCambioPS").val();
      $.ajax({
        type: "POST",
        url: "ajax_actualizaDatosGenerales.php",
        data: datastring,
        dataType: "json",
        success: function(response) {
          var mensaje=response.message;
          if (response.status=="success") { 
            //if(BanderaSalario == "1"){ bbbbbbbbbbbbbbbb
              GuardarHistoricoMovimientosSalarioDiarioImssEdicion(plantillaText_ID);
            //}
            alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Datos Gegerales</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#alertMsg").html(alertMsg1);
            $(document).scrollTop(0);
            $('#msgAlert').delay(3000).fadeOut('slow');
              GuardarMovimientoPlantillaHistorico("EDICION",selHorarioCons);
            var elemento = document.getElementById("spanDatosGenerales");
            elemento.className = "glyphicon glyphicon-ok";
            var botones =$('#divEditarDatosGenerales');                     
            var boton = "<button type='button' id='desbloqueoDatosGenerales' name='desbloqueoDatosGenerales' class='btn btn-success' type='button' onclick='desbloquearDatosGenerales();'> <span class='glyphicon glyphicon-refresh'></span>Editar</button>";
            botones.html(boton);
            $("#buttonGuardarDatosGenerales").remove();
            bloquearDatosGenerales();
            var numeroEmpleado=$("#numeroEmpleadoEntidadEdited").val()+"-"+$("#numeroEmpleadoConsecutivoEdited").val()+"-"+$("#numeroEmpleadoTipoEdited").val();
            consultaEmpleado(numeroEmpleado);

            if (banderaPS==1){//si hicieron cambio de punto de servicio al empleado se pide contraseña y se guarda en el historico
              var NumEmpModalBaja = $("#NumEmpModalFirmaParaCambioPs").val();
              var constraseniaFirma = $("#constraseniaFirmaParaConfirmacionCambioPS").val();
              guardarHistoricoCambioPS(NumEmpModalBaja,constraseniaFirma);//enviar PS Nuevo.PS viejo, usr y pwd
            }

          }else if (response.status=="error"){
            $(document).scrollTop(0);
            alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error en el registro de Datos Generales:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#alertMsg").html(alertMsg1);
            $('#msgAlert').delay(3000).fadeOut('slow');
          }
          var mensajes = "";//¨???????????????????????????????????????????????
          for (var i = 0; i < response.messages.length; i++){
            mensajes += response.messages [i] + "\n";
          } 
          if(mensajes != ""){
            alert (mensajes);
          }
        },error: function(jqXHR, textStatus, errorThrown){
          alert(jqXHR.responseText); 
        }
      }); 
    } 
  }
}


  /////////////////////////////////////// Validacion Firma Salario Diario Empleado ///////////////////////////////////

function GuardarHistoricoMovimientosSalarioDiarioImssEdicion(idPlantilla){

  var sueldo = $("#SueldoSalarioDiarioEmpEdit").val();
  var salarioDiariAnterior = $("#SalarioDiarioEmpEditAnterior").val();
  var constrasenia = $("#constraseniaFirmaParaConfirmacionSalarioDiarioEmpleadoHiddenEdit").val();
  var numeroAdmin = $("#NumEmpModalFirmaParaConfirmacionSalarioDiariohiddenEdit").val();
  var numeroEmpleadoEntidad = $("#numeroEmpleadoEntidadEdited").val();
  var numeroEmpleadoConsecutivo = $("#numeroEmpleadoConsecutivoEdited").val();
  var numeroEmpleadoTipo = $("#numeroEmpleadoTipoEdited").val();
  var numeroEmpleado = numeroEmpleadoEntidad+"-"+numeroEmpleadoConsecutivo+"-"+numeroEmpleadoTipo;
  var origen = "3";// indicando que el origen es de edicion existe un catalogo llamado catalogoOrigenSalarioDiarioImss
  var BanderaSalario = $("#BanderaSalarioEdit").val();
  if(BanderaSalario=="1"){
    var salarioDiari = $("#SalarioDiarioEmpEdit").val();
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
          $("#SalarioDiarioEmpEditImss").val(salarioDiario2);
        }
      },error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
    var salarioDiari = $("#SalarioDiarioEmpEditImss").val();
  }
  $.ajax({
    type: "POST",
    url: "ajax_RegistrarHistoricoMovSDImss.php", 
    data: {"sueldo":sueldo,"salarioDiari":salarioDiari,"constrasenia":constrasenia,"numeroAdmin":numeroAdmin,"numeroEmpleado":numeroEmpleado,"origen":origen,"idPlantilla":idPlantilla},
    dataType: "json",
    async:false,
    success: function(response) {
      if (response.status != "success")
      {
        alert(response.message);
      }else{
        if(salarioDiariAnterior < salarioDiari){
          ActualizarDatosImssParaSalarioDiario(salarioDiari);
        }else{
          LimpiarDatosTabuladorSalarioDiarioEdit();
        }
      }
    },error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
  });
}

function ActualizarDatosImssParaSalarioDiario(salarioDiari){
  var numeroEmpleadoEntidad1 = $("#numeroEmpleadoEntidadEdited").val();
  var numeroEmpleadoConsecutivo1 = $("#numeroEmpleadoConsecutivoEdited").val();
  var numeroEmpleadoTipo1 = $("#numeroEmpleadoTipoEdited").val();
  var origen1 = "3";// indicando que el origen es de edicion existe un catalogo llamado catalogoOrigenSalarioDiarioImss
  var BanderaSalario1 = $("#BanderaSalarioEdit").val();
  var movimientoTXT = '7';
  if(BanderaSalario1=="1"){
    var salarioDiari1 = $("#SalarioDiarioEmpEdit").val();
  }else{      
    var salarioDiari1 = salarioDiari;
  }
  var idpunt = $("#selectPuntoServicioEdited").val();
  if(idpunt != "27" && idpunt != "19"){
    $.ajax({
    type: "POST",
    url: "ajax_ActualizaDatosImssParaSalarioDiario.php",
      data: {"salarioDiari":salarioDiari1,"numeroEmpleadoEntidad":numeroEmpleadoEntidad1,"numeroEmpleadoConsecutivo":numeroEmpleadoConsecutivo1,"numeroEmpleadoTipo":numeroEmpleadoTipo1,"origen":origen1,"movimientoTXT":movimientoTXT},
      dataType: "json",
      async:false,
      success: function(response) {
        if (response.status != "success")
        {
          alert(response.message);
        }else{
          InsertarHistoricoMovimientosImssPorActualizacionDeSalarioDiario();
        }
      },error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }else{
    LimpiarDatosTabuladorSalarioDiarioEdit();
  }
  
}

function InsertarHistoricoMovimientosImssPorActualizacionDeSalarioDiario(){
  var numeroEmpleadoEntidad1 = $("#numeroEmpleadoEntidadEdited").val();
  var numeroEmpleadoConsecutivo1 = $("#numeroEmpleadoConsecutivoEdited").val();
  var numeroEmpleadoTipo1 = $("#numeroEmpleadoTipoEdited").val();
  $.ajax({
    type: "POST",
    url: "ajax_InsertarHistoricoMovimientosImssPorActualizacionDeSalarioDiario.php",
    data: {"numeroEmpleadoEntidad":numeroEmpleadoEntidad1,"numeroEmpleadoConsecutivo":numeroEmpleadoConsecutivo1,"numeroEmpleadoTipo":numeroEmpleadoTipo1},
    dataType: "json",
    async:false,
    success: function(response) {
      if (response.status != "success")
      {
        alert(response.message);
      }else{
        LimpiarDatosTabuladorSalarioDiarioEdit();
      }
    },error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
  });
}

$('#btnGenrarSalarioDiarioEdit').click(function(){
  var idtipoTurnoSD = $("#tipoTurnoEdited").val();
  var idPuestoSD = $("#puestoEdited").val();
  var idPuntoServicioTabulador = $("#selectPuntoServicioEdited").val();
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
            $("#SueldoSalarioDiarioEmpEdit").val(sueldo);
            var resta = sueldo- SueldoBaseDescuento;
            if(resta > 0){
              var MontoADescontar = sueldo*("."+PorcentajeDescuento);
              var  salarioDiario1 = sueldo-MontoADescontar; 
              var salarioDiario = salarioDiario1/30;
              $("#SalarioDiarioEmpEdit").val(salarioDiario); 
            }else{
              $("#SalarioDiarioEmpEdit").val(SalarioDiarioDescuento); 
            }
            var salarioDiarioBefore = $("#SalarioDiarioEmpEdit").val(); 
            var salarioDiarioSplit =salarioDiarioBefore.split(".");
            var salarioDiariolength = salarioDiarioSplit.length;
            if(salarioDiariolength=="1"){$("#SalarioDiarioEmpEdit").val(salarioDiarioBefore+".00");}
            if(salarioDiariolength=="2"){
              var decimal = salarioDiarioSplit[1];
              if(decimal.length == "1"){
                $("#SalarioDiarioEmpEdit").val(salarioDiarioBefore+"0");
              }
            }
            $("#btnConfirmadoSalarioDiarioEdit").hide();
            $("#btnGenrarSalarioDiarioEdit").hide();
            $("#btnConfirmarSalarioDiarioEdit").show();
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

function LimpiarDatosTabuladorSalarioDiarioEdit(){
  var tipoPuestoEdited = $("#tipoPuestoEdited").val();
  var seleLineaNegocioEdi = $("#selectLineaNegocioEdited").val();
  var idpunt = $("#selectPuntoServicioEdited").val();

  if(tipoPuestoEdited != "02" && tipoPuestoEdited != "TIPO PUESTO" && seleLineaNegocioEdi=="1" && idpunt != "27" && idpunt != "19"){
    $("#SalarioDiarioEmpEdit").val("");
    $("#btnGenrarSalarioDiarioEdit").show();
    $("#btnConfirmarSalarioDiarioEdit").hide();
    $("#btnConfirmadoSalarioDiarioEdit").hide();
    $("#imgMalSalarioDiarioEdit").show();
    $("#imgBienSalarioDiarioEdit").hide();
    $("#NumEmpModalFirmaParaConfirmacionSalarioDiarioEdit").val("");
    $("#constraseniaFirmaParaConfirmacionSalarioDiarioEmpleadoEdit").val("");
    $("#constraseniaFirmaParaConfirmacionSalarioDiarioEmpleadoHiddenEdit").val("");
    $("#NumEmpModalFirmaParaConfirmacionSalarioDiariohiddenEdit").val("");
    $("#BanderaSalarioEdit").val(1);
    $("#trSalarioDiario").show();
  }else{$("#BanderaSalarioEdit").val(0); $("#trSalarioDiario").hide();}
}

$('#btnConfirmarSalarioDiarioEdit').click(function(){
  $("#modalFirmaConfirmacionSalarioDiarioEdit").modal();
});

$('#selectPuntoServicioEdited').change(function(){
  var psActual = $("#pshidden").val();
  var psNuevo  = $("#selectPuntoServicioEdited").val();
  var banderaPS  = 0;

  if(psActual==psNuevo){
     $("#banderaCambioPS").val(0);
     var banderaPS = $("#banderaCambioPS").val();
        // alert(banderaPS);
  }else{
        $("#banderaCambioPS").val(1);
        var banderaPS = $("#banderaCambioPS").val();
        // alert(banderaPS);
  }
});

function RevisarFirmaInternaParaConfirmacionSalarioDiarioEdit(){
  var NumEmpModalBaja = $("#NumEmpModalFirmaParaConfirmacionSalarioDiarioEdit").val();
  var constraseniaFirma = $("#constraseniaFirmaParaConfirmacionSalarioDiarioEmpleadoEdit").val();
  if(NumEmpModalBaja==""){
    cargaerroresFirmaInternaParaCOnfirmaciosDeSDEdit("El numero de empleado no puede estar vacio");
  }else if(constraseniaFirma==""){
    cargaerroresFirmaInternaParaCOnfirmaciosDeSDEdit("Escriba la contraseña para continuar");
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
            cargaerroresFirmaInternaParaCOnfirmaciosDeSDEdit("La Contraseña ingresada es incorrecta favor de escribirla exactamente como la ingreso en el registro");
          }else{
            var contraseniaInsertadaCifrada =response.datos["0"].ContraseniaFirma;
            $("#constraseniaFirmaParaConfirmacionSalarioDiarioEmpleadoHiddenEdit").val(contraseniaInsertadaCifrada);
            $("#NumEmpModalFirmaParaConfirmacionSalarioDiariohiddenEdit").val(NumEmpModalBaja);
            $("#modalFirmaConfirmacionSalarioDiarioEdit").modal("hide");
            $("#NumEmpModalFirmaParaConfirmacionSalarioDiarioEdit").val("");
            $("#constraseniaFirmaParaConfirmacionSalarioDiarioEmpleadoEdit").val("");
            $("#imgMalSalarioDiarioEdit").hide();
            $("#imgBienSalarioDiarioEdit").show();
            $("#btnConfirmadoSalarioDiarioEdit").show();
            $("#btnConfirmarSalarioDiarioEdit").hide();
          }
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
    });
  }
}

function RevisarFirmaInternaParaCambioPS(){
  var NumEmpModalBaja = $("#NumEmpModalFirmaParaCambioPs").val();
  var constraseniaFirma = $("#constraseniaFirmaParaConfirmacionCambioPS").val();
  if(NumEmpModalBaja==""){
    cargaerroresFirmaInternaParaConfirmacionCambioPS("El numero de empleado no puede estar vacio");
  }else if(constraseniaFirma==""){
    cargaerroresFirmaInternaParaConfirmacionCambioPS("Escriba la contraseña para continuar");
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
            cargaerroresFirmaInternaParaConfirmacionCambioPS("La Contraseña ingresada es incorrecta favor de escribirla exactamente como la ingreso en el registro");
          }else{
            var contraseniaInsertadaCifrada =response.datos["0"].ContraseniaFirma;
            $("#NumEmpModalFirmaCambioPSDiariohidden").val(NumEmpModalBaja);
            $("#constraseniaFirmaParaConfirmacionCambioPSHidden").val(contraseniaInsertadaCifrada);
            $("#modalCambioPS").modal("hide");
            // $("#imgMalSalarioDiarioEdit").hide();
            // $("#imgBienSalarioDiarioEdit").show();
            // $("#btnConfirmadoSalarioDiarioEdit").show();
            // $("#btnConfirmarSalarioDiarioEdit").hide();
            editarDatosGenerales();
          }
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
    });
  }
}

function cargaerroresFirmaInternaParaCOnfirmaciosDeSDEdit(mensaje){
  $('#errormodalConfirmacionSalarioDiarioEdit').fadeIn();
  msjerrorbaja="<div id='errormodalConfirmacionSalarioDiario1Edit' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errormodalConfirmacionSalarioDiarioEdit").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errormodalConfirmacionSalarioDiarioEdit').delay(4000).fadeOut('slow'); 
}

function cargaerroresFirmaInternaParaConfirmacionCambioPS(mensaje){
  $('#errormodalCambioPs').fadeIn();
  msjerrorbaja="<div id='errormodalCambioPsEdit' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errormodalCambioPs").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errormodalCambioPs').delay(4000).fadeOut('slow'); 
}

function cancelarFirmaParaConfirmacionSalarioDiarioEdit(){

  $("#modalFirmaConfirmacionSalarioDiarioEdit").modal("hide");
  $("#NumEmpModalFirmaParaConfirmacionSalarioDiarioEdit").val("");
  $("#constraseniaFirmaParaConfirmacionSalarioDiarioEmpleadoEdit").val("");
}

function cancelarFirmaParaConfirmacionCambioPS(){

  $("#modalCambioPS").modal("hide");
  $("#NumEmpModalFirmaParaCambioPs").val("");
  $("#constraseniaFirmaParaConfirmacionCambioPS").val("");
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////


  function editarDatosPersonales(){
    var datastring = $("#form_EditaEmpleado").serialize();
    var selectPaisNacimientoEdited = $("#selectPaisNacimientoEdited").val();
    var selectEntidadNacimientoEdited = $("#selectEntidadNacimientoEdited").val();
    var selectMunicipioNacEdited = $("#selectMunicipioNacEdited").val();
    var txtEdadCP = $("#txtEdadCP").val();

    if (existeDatosPersonales==0){
      $.ajax({
        type: "POST",
        url: "ajax_registrarEmpleadoDatosPersonalesDesdeEdicion.php",
        data: datastring,
        dataType: "json",
        success: function(response) {
          var mensaje=response.message;

          if (response.status=="success") {


            alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Datos Gegerales</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

            $("#alertMsg").html(alertMsg1);
            $(document).scrollTop(0);
            $('#msgAlert').delay(3000).fadeOut('slow');

            var elemento = document.getElementById("spanDatosGenerales");
            elemento.className = "glyphicon glyphicon-ok";



                    //$('#myModal').modal();
                    var botones =$('#divEditarDatosPersonales');                     
                    var boton = "<button type='button' id='desbloqueoDatosPersonales' name='desbloqueoDatosPersonales' class='btn btn-success' type='button' onclick='desbloquearDatosPersonales();'> <span class='glyphicon glyphicon-refresh'></span>Editar</button>";
                    botones.append (boton);

                    $("#buttonGuardarDatosPersonales").remove();
                    bloquearDatosPersonales();

                    var numeroEmpleado=$("#numeroEmpleadoEntidadEdited").val()+"-"+$("#numeroEmpleadoConsecutivoEdited").val()+"-"+$("#numeroEmpleadoTipoEdited").val();
                    //alert("numero empleado desde editar datos personales"+numeroEmpleado);aaaaaaaaaaa
                    consultaEmpleado(numeroEmpleado);


                  } else if (response.status=="error")
                  {
                    alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error en el registro de Datos Generales:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#alertMsg").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                  }
                },
                error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
                }
              });

    }else if (existeDatosPersonales==1){

      $.ajax({
        type: "POST",
        url: "ajax_actualizarDatosPersonales.php",
        data: datastring,
        dataType: "json",
        success: function(response) {
          var mensaje=response.message;

          if (response.status=="success") {


            alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Datos Gegerales</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

            $("#alertMsg").html(alertMsg1);
            $(document).scrollTop(0);
            $('#msgAlert').delay(3000).fadeOut('slow');

            $("#LabelCurpInterno").hide();
            $("#LabelCheckCurpInterno").hide();
            $("#LabelCheckRfcInterno").hide();
            $("#txtCurpInterno").hide();
            $("#checkCurp").hide();
            $("#checkRfc").hide();
            $("#checkCurp").prop("checked", false);
            $("#checkRfc").prop("checked", false);
            var elemento = document.getElementById("spanDatosGenerales");
            elemento.className = "glyphicon glyphicon-ok";

                    //$('#myModal').modal();
                    var botones =$('#divEditarDatosPersonales');                     
                    var boton = "<button type='button' id='desbloqueoDatosPersonales' name='desbloqueoDatosPersonales' class='btn btn-success' type='button' onclick='desbloquearDatosPersonales();'> <span class='glyphicon glyphicon-refresh'></span>Editar</button>";
                    botones.append (boton);

                    $("#buttonGuardarDatosPersonales").remove();
                    bloquearDatosPersonales();
                    var numeroEmpleado=$("#numeroEmpleadoEntidadEdited").val()+"-"+$("#numeroEmpleadoConsecutivoEdited").val()+"-"+$("#numeroEmpleadoTipoEdited").val();
                    consultaEmpleado(numeroEmpleado);


                  } else if (response.status=="error")
                  {
                    alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error en el registro de Datos Generales:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#alertMsg").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                  }
                },
                error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
                }
              });

    }       

      } // fin funcion editar datos personales

      function editarDatosDireccion(){


        var datastring = $("#form_EditaEmpleado").serialize();
        //alert(datastring);
        //alert(existeDirectorio);

        if (existeDirectorio==0){




          $.ajax({
            type: "POST",
            url: "ajax_registroDatosDireccionDesdeEdicion.php",
            data: datastring,
            dataType: "json",
            success: function(response) {
              var mensaje=response.message;

              if (response.status=="success") {
                $("#multipleUmfE").empty();
                $("#multipleDireccionesE").empty();
                alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Datos Gegerales</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                $("#alertMsg").html(alertMsg1);
                $(document).scrollTop(0);
                $('#msgAlert').delay(3000).fadeOut('slow');

               

                var elemento = document.getElementById("spanDatosGenerales");
                elemento.className = "glyphicon glyphicon-ok";

                var botones =$('#divButtonGuardarDireccion');                     
                var boton = "<button type='button' id='desbloqueoDatosDireccion' name='desbloqueoDatosDireccion' class='btn btn-success' type='button' onclick='desbloquearDatosDireccion();'> <span class='glyphicon glyphicon-refresh'></span>Editar</button>";
                botones.append (boton);

                $("#buttonGuardarDatosDireccion").remove();
                bloquearDatosGeneralesDirectorio();
                var numeroEmpleado=$("#numeroEmpleadoEntidadEdited").val()+"-"+$("#numeroEmpleadoConsecutivoEdited").val()+"-"+$("#numeroEmpleadoTipoEdited").val();
                consultaEmpleado(numeroEmpleado);


              } else if (response.status=="error")
              {
                alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error en el registro de Datos Generales:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                $("#alertMsg").html(alertMsg1);
                $(document).scrollTop(0);
                $('#msgAlert').delay(3000).fadeOut('slow');
              }
            },
            error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
            }
          });

        }else if (existeDirectorio==1){
          $.ajax({
            type: "POST",
            url: "ajax_actualizaDatosDireccion.php",
            data: datastring,
            dataType: "json",
            success: function(response) {
              var mensaje=response.message;

              if (response.status=="success") {

                $("#multipleDireccionesE").empty();
                $("#multipleUmfE").empty();
                alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Datos Gegerales</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                $("#alertMsg").html(alertMsg1);
                $(document).scrollTop(0);
                $('#msgAlert').delay(3000).fadeOut('slow');


                var elemento = document.getElementById("spanDatosGenerales");
                elemento.className = "glyphicon glyphicon-ok";

                var botones =$('#divButtonGuardarDireccion');                     
                var boton = "<button type='button' id='desbloqueoDatosDireccion' name='desbloqueoDatosDireccion' class='btn btn-success' type='button' onclick='desbloquearDatosDireccion();'> <span class='glyphicon glyphicon-refresh'></span>Editar</button>";
                botones.append (boton);

                $("#buttonGuardarDatosDireccion").remove();



                bloquearDatosGeneralesDirectorio();

                var numeroEmpleado=$("#numeroEmpleadoEntidadEdited").val()+"-"+$("#numeroEmpleadoConsecutivoEdited").val()+"-"+$("#numeroEmpleadoTipoEdited").val();
                consultaEmpleado(numeroEmpleado);


              } else if (response.status=="error")
              {
                alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error en el registro de Datos Generales:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                $("#alertMsg").html(alertMsg1);
                $(document).scrollTop(0);
                $('#msgAlert').delay(3000).fadeOut('slow');
              }
            },
            error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
            }
          });

        }       


      }


      function desbloquearDatosPersonales(){

        $("#txtFechaNacimientoEdited").prop("disabled", false);
        $("#selectPaisNacimientoEdited").prop("disabled", false);
        $("#txtFechaNacimientoEdited").prop("disabled", false);

        $("#selectMunicipioNacEdited").prop("disabled", false);
        $("#selectEntidadNacimientoEdited").prop("disabled", false);

        $("#txtCurpEdited").prop("disabled", false);
        $("#txtRfcEdited").prop("disabled", false);
        $("#selectEstadoCivilEdited").prop("disabled", false);
        $("#selectGradoEstudiosEdited").prop("disabled", false);
        $("#selectGradoEstudiosEdited").prop("disabled", false);
        $("#selectTipoSangreEdited").prop("disabled", false);
        $("#selectOficioEdited").prop("disabled",false);
        $("#txtNumeroCartillaEdited").prop("disabled",false);
        $("#1estatusCartillaEdited").prop("disabled",false);
        $("#2estatusCartillaEdited").prop("disabled",false);
        $("#3estatusCartillaEdited").prop("disabled",false);
        $("#4estatusCartillaEdited").prop("disabled",false);
        $("#5estatusCartillaEdited").prop("disabled",false);

        $("#selectReclutadorEdited").prop("disabled",false);
        $("#selectMedioInformacionEdited").prop("disabled",false);
        $("#txtEdadCP").prop("disabled", false);

        var botones =$('#divButtonGuardarDatosPersonales');                     
        var boton = "<button type='button' class='btn btn-info' id='buttonGuardarDatosPersonales' name='buttonGuardarDatosPersonales' onclick='CreacionCurpInterno(1);'><span class='glyphicon glyphicon-floppy-save' ></span>Guardar</button>";
        botones.append (boton);
        $("#desbloqueoDatosPersonales").remove();
      }

      function desbloquearDatosDireccion(){
       
          $("#txtCPEdited").prop("disabled", false);
          $("#txtCalleEdited").prop("disabled", false);
          $("#txtNumeroIntEdited").prop("disabled", false);
          $("#txtNumeroExtEdited").prop("disabled", false);
          $("#txtTelefonoFijoEdited").prop("disabled", false);
          $("#txtTelefonoMovilEdited").prop("disabled", false);
          $("#txtCorreoEdited").prop("disabled", false);
        var botones =$('#divButtonGuardarDireccion');                     
        var boton = "<button type='button' class='btn btn-info' id='buttonGuardarDatosDireccion' name='buttonGuardarDatosDireccion' onclick='editarDatosDireccion();'><span class='glyphicon glyphicon-floppy-save' ></span>Guardar</button>";
        botones.append (boton);
        $("#desbloqueoDatosDireccion").remove();
      }


      function consultaCPEdited()
      {
        var codigoPostal = $("#txtCPEdited").val ();
        $("#txtIdUmfEdited").val("");
        $("#txtNombreUmfEdited").val("");
        $("#txtDireccionUmfEdited").val("");

        $("#multipleDireccionesE").html ("");
        setDireccionData ("","","","","");

    // Si el código postal no tiene una longitud de 5 caracteres
    // entonces no hagas nada. Sal de la función.
    if (codigoPostal.length != 5)
    {
      return;
    }
    
    $.ajax({
      type: "POST",
      url: "ajax_obtenerDirecciones.php",
      data: {txtCP : codigoPostal},
      dataType: "json",
      success: function(response) {
        if (response.listaDirecciones.length == 0)
        {
          $.notify("El código postal es inválido", {autoHideDelay: 3000, className: 'error'});
          return;
        }
        else if (response.listaDirecciones.length == 1)
        {
          var direccion = response.listaDirecciones [0];

          setDireccionDataE (direccion.idAsentamiento,
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

                      displayDirecciones += "<p>" + (i + 1) + "<a href='javascript:setDireccionDataE(" + params + ")';>" + 
                      direccion.nombreTipoAsentamiento + " " +
                      direccion.nombreAsentamiento + " " +
                      direccion.nombreMunicipio + ", " +
                      direccion.nombreEntidadFederativa + "</a></p>";
                    }
                    
                    
                    $("#multipleDireccionesE").html (displayDirecciones);
                  }
                },
                error: function(){
                  alert('error handing here');
                }
              });
  }

  function setDireccionDataE (idAsentamiento, nombreEntidadFederativa, nombreMunicipio, nombreAsentamiento,municipioAsentamiento )
  {
    $("#txtIdAsentamientoEdited").val(idAsentamiento);
    $("#txtEntidadViviendaEdited").val (nombreEntidadFederativa);
    $("#txtMunicipioViviendaEdited").val(nombreMunicipio);
    $("#txtColoniaEdited").val(nombreAsentamiento);
    $("#txtIdMunicipioEdited").val(municipioAsentamiento);

    consultaUmfE();
    $("#txtIdUmfEdited").val("");
    $("#txtNombreUmfEdited").val("");
    $("#txtDireccionUmfEdited").val("");
  }

  function consultaUmfE ()
  {

    var idMunicipio = $("#txtIdMunicipioEdited").val ();

    $.ajax({
      type: "POST",
      url: "ajax_obtenerUmf.php",
      data: {idMunicipio : idMunicipio},
      dataType: "json",
      success: function(response) {
        if (response.listaUmf.length == 1)
        {
          var umf = response.listaUmf [0];

          setUmfDataE (umf.idUnidadMedica,
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

            displayUmf += "<p>" + (i + 1) + "<a href='javascript:setUmfDataE(" + params + ")';>" + 
            umf.nombreUnidad + "</a></p>";
          }


          $("#multipleUmfE").html (displayUmf);
        }
      },
      error: function(){
        alert('error handing here');
      }
    });
  }

  function setUmfDataE (idUnidadMedica,nombreUnidad, domicilioUnidad )
  {
    $("#txtIdUmfEdited").val(idUnidadMedica);
    $("#txtNombreUmfEdited").val (nombreUnidad);
    $("#txtDireccionUmfEdited").val(domicilioUnidad);

  }

  function consultarMunicipiosPorEntidadE(municipioNacimiento){
    var entidadId = $("#selectEntidadNacimientoEdited").val();
    $.ajax({
      type: "POST",
      url: "ajax_obtenerMunicipiosPorEntidad.php",
      data: {"entidadId": entidadId},
      dataType: "json",
      success: function(response) {
        if (response.status == "success"){
          var listaMunicipios = response.listaMunicipios;
          var EntidadCurp = response.EntidadCurp[0].claveEntidadF;
          municipiosNacOptions = "<option>MUNICIPIOS</option>";
          for ( var i = 0; i < listaMunicipios.length; i++ ){
            municipiosNacOptions += "<option value='" + listaMunicipios[i].idMunicipio + "'";
            if (listaMunicipios[i].idMunicipio == municipioNacimiento)
            {
              municipiosNacOptions += " selected='selected' ";
            }
            municipiosNacOptions += ">" + listaMunicipios[i].nombreMunicipio + "</option>";
          }
          $("#selectMunicipioNacEdited").html (municipiosNacOptions); 
          $("#txtClaveEntidad").val(EntidadCurp);
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });       
  }
  function generarCartaPatronalEdited()
  {
    var entidadEmpleado=$("#numeroEmpleadoEntidadEdited").val();
    var consecutivoEmpleado=$("#numeroEmpleadoConsecutivoEdited").val();
    var tipoEmpleado=$("#numeroEmpleadoTipoEdited").val();
    //  alert(apellido);
    window.open("generadorCartaPatronal.php?entidadEmpleado="+entidadEmpleado+"&consecutivoEmpleado="+consecutivoEmpleado+"&tipoEmpleado="+tipoEmpleado+"",'Informe3','fullscreen=no');
     //
      //parent.opener=top;
      //opener.close();

    }
    function generarCartaPatronal2Edited()
    {
      var entidadEmpleado=$("#numeroEmpleadoEntidadEdited").val();
      var consecutivoEmpleado=$("#numeroEmpleadoConsecutivoEdited").val();
      var tipoEmpleado=$("#numeroEmpleadoTipoEdited").val();
    //  alert(apellido);

    window.open("generadorCartaPatronal2.php?entidadEmpleado="+entidadEmpleado+"&consecutivoEmpleado="+consecutivoEmpleado+"&tipoEmpleado="+tipoEmpleado+"",'Informe3','fullscreen=no');
      //parent.opener=top;
      //opener.close();

    }
    function generarContratoSa1Edited()
    {
      var entidadEmpleado=$("#numeroEmpleadoEntidadEdited").val();
      var consecutivoEmpleado=$("#numeroEmpleadoConsecutivoEdited").val();
      var tipoEmpleado=$("#numeroEmpleadoTipoEdited").val();
    //  alert(apellido);
    window.open("generadorContratoSa1.php?entidadEmpleado="+entidadEmpleado+"&consecutivoEmpleado="+consecutivoEmpleado+"&tipoEmpleado="+tipoEmpleado+"",'_blank','fullscreen=no');

     //parent.opener=top;

   }
   function generarContratoSa2Edited()
   {

    var entidadEmpleado=$("#numeroEmpleadoEntidadEdited").val();
    var consecutivoEmpleado=$("#numeroEmpleadoConsecutivoEdited").val();
    var tipoEmpleado=$("#numeroEmpleadoTipoEdited").val();

    window.open("generadorContratoSa2.php?entidadEmpleado="+entidadEmpleado+"&consecutivoEmpleado="+consecutivoEmpleado+"&tipoEmpleado="+tipoEmpleado+"",'_blank','fullscreen=no');      
      //parent.opener=top;
      //opener.close();

    }

    function generarContratoScEdited()
    {
      var entidadEmpleado=$("#numeroEmpleadoEntidadEdited").val();
      var consecutivoEmpleado=$("#numeroEmpleadoConsecutivoEdited").val();
      var tipoEmpleado=$("#numeroEmpleadoTipoEdited").val();

      window.open("generadorContratoSc.php?entidadEmpleado="+entidadEmpleado+"&consecutivoEmpleado="+consecutivoEmpleado+"&tipoEmpleado="+tipoEmpleado+"",'_blank','fullscreen=no');
      //parent.opener=top;
      //opener.close();

    }

    function generarHojaDatosEdited()
    {
      var entidadEmpleado=$("#numeroEmpleadoEntidadEdited").val();
      var consecutivoEmpleado=$("#numeroEmpleadoConsecutivoEdited").val();
      var tipoEmpleado=$("#numeroEmpleadoTipoEdited").val();
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

     function generarCredencialEdited()
     {
       var entidadEmpleado=$("#numeroEmpleadoEntidadEdited").val();
       var consecutivoEmpleado=$("#numeroEmpleadoConsecutivoEdited").val();
       var tipoEmpleado=$("#numeroEmpleadoTipoEdited").val();
    //  alert(apellido);
    window.open("generadorCredencial.php?entidadEmpleado="+entidadEmpleado+"&consecutivoEmpleado="+consecutivoEmpleado+"&tipoEmpleado="+tipoEmpleado+"",'Informe3','fullscreen=no');
      //parent.opener=top;
      //opener.close();


    }

    function generadorNuevaCredencialEdited()
    {

      //alert("¡OPS! Estoy en construccion, aun no funciono pero quien me esta programando te notificara cuando este listo. Saludos :) ")
      
      var entidadEmpleado=$("#numeroEmpleadoEntidadEdited").val();
      var consecutivoEmpleado=$("#numeroEmpleadoConsecutivoEdited").val();
      var tipoEmpleado=$("#numeroEmpleadoTipoEdited").val();
    //  alert(apellido);
    window.open("generadorNuevaCredencial.php?entidadEmpleado="+entidadEmpleado+"&consecutivoEmpleado="+consecutivoEmpleado+"&tipoEmpleado="+tipoEmpleado+"",'_blank','fullscreen=no');
      //parent.opener=top;
      //opener.close();


    }

    function generarDocumentoBancoEdited()
    {
      var entidadEmpleado=$("#numeroEmpleadoEntidadEdited").val();
      var consecutivoEmpleado=$("#numeroEmpleadoConsecutivoEdited").val();
      var tipoEmpleado=$("#numeroEmpleadoTipoEdited").val();
    //  alert(apellido);
    window.open("generadorDocumentoBanco.php?entidadEmpleado="+entidadEmpleado+"&consecutivoEmpleado="+consecutivoEmpleado+"&tipoEmpleado="+tipoEmpleado+"",'Informe3','fullscreen=no');
      //parent.opener=top;
      //opener.close();


    }



    function generadorFormatoDocumentosRecibidosEdited()
    {
      var entidadEmpleado=$("#numeroEmpleadoEntidadEdited").val();
      var consecutivoEmpleado=$("#numeroEmpleadoConsecutivoEdited").val();
      var tipoEmpleado=$("#numeroEmpleadoTipoEdited").val();
      var nombreCompleto=$("#apellidoPaternoEmpleadoEdited").val()+" "+ $("#apellidoMaternoEmpleadoEdited").val()+" "+$ ("#nombreEmpleadoEdited").val();
          //  alert(apellido);
          window.open("generadorFormatoDocumentosRecibidos.php?entidadEmpleado="+entidadEmpleado+"&consecutivoEmpleado="+consecutivoEmpleado+"&tipoEmpleado="+tipoEmpleado+"&nombreCompleto="+nombreCompleto+"",'_blank','fullscreen=no');
      //parent.opener=top;
      //opener.close();
    }

    function generadorFormatoBASC(){
      window.open("../archivos/politicaBasc.pdf");
    }

    function generadorCartaResponsivaEdited()
    {
      var entidadEmpleado=$("#numeroEmpleadoEntidadEdited").val();
      var consecutivoEmpleado=$("#numeroEmpleadoConsecutivoEdited").val();
      var tipoEmpleado=$("#numeroEmpleadoTipoEdited").val();
      var nombreCompleto=$("#apellidoPaternoEmpleadoEdited").val()+" "+ $("#apellidoMaternoEmpleadoEdited").val()+" "+$ ("#nombreEmpleadoEdited").val();
          //  alert(apellido);
          window.open("generadorCartaResponsiva.php?entidadEmpleado="+entidadEmpleado+"&consecutivoEmpleado="+consecutivoEmpleado+"&tipoEmpleado="+tipoEmpleado+"&nombreCompleto="+nombreCompleto+"",'_blank','fullscreen=no');
      //parent.opener=top;
      //opener.close();


    }
    function obtenerListaBeneficiariosEdited(idParentesco)
    {
      if ( $('input[name=checkBeneficiarioE]').is(':checked'))
      {
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
               parentescosOptions += "<option value='" + parentescos[i].idParentesco + "'";

               if (parentescos[i].idParentesco == idParentesco)
               {
                parentescosOptions += " selected='selected' ";
              }

              parentescosOptions += ">" + parentescos[i].descripcionParentesco + "</option>";
            }



            $("#selectOtroBeneficiarioEdited").html (parentescosOptions);
          }
        },
        error: function (response)
        {
          console.log (response);

        }
      });

      }else
      {

        $("#contenidoOtroBeneficiarioEdited").remove();

      }

    }


    function obtenerSupervisoresOperativos1(idResponsableAsistencia)
    {
     var puestoId = $("#tipoPuestoEdited").val();
     var lineaNegocio = $("#selectLineaNegocioEdited").val();
       //alert(puestoId);
       if(puestoId=='03' && lineaNegocio==3){

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

                responsableAsistencia += "<option value='" + numeroEmpleado + "'";


                if (numeroEmpleado==idResponsableAsistencia)
                {
                  responsableAsistencia += " selected='selected' "; 
                }


                responsableAsistencia += ">" + listaSupervisoresOperativos[i].nombre + "</option>";
              }


              $("#dirigenteEdited").html (responsableAsistencia);

            }
          },
          error: function (response)
          {
            console.log (response);
          }
        });

      }

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

                responsableAsistencia += "<option value='" + numeroEmpleado + "'";


                if (numeroEmpleado==idResponsableAsistencia)
                {
                  responsableAsistencia += " selected='selected' "; 
                }


                responsableAsistencia += ">" + listaSupervisoresOperativos[i].nombre + "</option>";
              }


              $("#dirigenteEdited").html (responsableAsistencia);

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

                responsableAsistencia += "<option value='" + numeroEmpleado + "'";


                if (numeroEmpleado==idResponsableAsistencia)
                {
                  responsableAsistencia += " selected='selected' "; 
                }


                responsableAsistencia += ">" + listaSupervisoresOperativos[i].nombre + "</option>";
              }


              $("#dirigenteEdited").html (responsableAsistencia);

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
        $("#dirigenteEdited").html (responsableAsistencia);

      }
    }

    function obtenerSupervisoresOperativosReingreso(idResponsableAsistencia)
    {

     var puestoId = $("#selectTipoPuestoReingreso").val();
     var lineaNegocio = $("#selectLineaNegocioModalR").val();
       

       if( puestoId=='03' && lineaNegocio==1){

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

                responsableAsistencia += "<option value='" + numeroEmpleado + "'";


                if (numeroEmpleado==idResponsableAsistencia)
                {
                  responsableAsistencia += " selected='selected' "; 
                }


                responsableAsistencia += ">" + listaSupervisoresOperativos[i].nombre + "</option>";
              }


              $("#selectSupervisorModalR").html (responsableAsistencia);

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
        $("#selectSupervisorModalR").html (responsableAsistencia);

      }
    }


function consultaDatosFamiliares (numeroEmpleado){
      var numeroEmpleado = numeroEmpleado;
      var conteoBeneficiariosCP=$("#conteoBeneficiariosCP").val();


if( $('#checkMadreE1').prop('checked') ) {
  $('#checkMadreE1').checkbox('click');
  jQuery("#checkMadreE1").prop('checked',false);
}

if( $('#checkPadreE').prop('checked')){
  $('#checkPadreE').checkbox('click');
  jQuery("#checkPadreE").prop('checked',false);
}
  if( $('#checkBeneficiarioE').prop('checked')){
    $('#checkBeneficiarioE').checkbox('click');
    jQuery("#checkBeneficiarioE").prop('checked',false);
  }

  $("#txtNombrePadreEdited").val("");
  $("#txtNombreMadreEdited").val("");
  $("#txtOtroBeneficiarioE").val("");
  $("#selectOtroBeneficiarioEdited").prop('selectedIndex', 0);

$.ajax({
  type: "POST",
  url: "ajax_obtenerDatosFamiliares.php",
  data:{"numeroEmpleado":numeroEmpleado},
  dataType: "json",
  success: function(response) {
    if (response.status == "success"){

      var datosFamiliares = response.listaFamiliares;

      for ( var i = 0; i < datosFamiliares.length; i++ ){
        var nombreFamiliar=datosFamiliares[i].nombreFamiliar;
        var idParentescoFamiliar=datosFamiliares[i].idParentescoFamiliar;
        var beneficiario=datosFamiliares[i].beneficiario;
        var porcentaje=datosFamiliares[i].porcentajeBeneficiario;

        if(idParentescoFamiliar>=14){
          var descripcion=datosFamiliares[i].descripcion2;//descripcion ingresada a mano
        }else{
          var descripcion=datosFamiliares[i].descripcion1;//descripcion del catalogo
        }

        var noBeneficiario=1+i;

        $("#trBeneficiarioCP"+noBeneficiario).show();
        $("#txtParentescoBeneficiarioCP"+noBeneficiario).val(descripcion);
        $("#txtNombreBeneficiarioCP"+noBeneficiario).val(nombreFamiliar);
        $("#txtPorcentajeBeneficiarioCP"+noBeneficiario).val(porcentaje);
        conteoBeneficiariosCP++;
        $("#conteoBeneficiariosCP").val(conteoBeneficiariosCP);

      }//for
      $("#eliminarBeneficiarioCP").show();
    }else if (response.status == "error" && response.message == "No autorizado"){
        window.location = "login.php";

    }
  },error: function (response){
      console.log (response);

    }
  });
}

function cargarDatosBeneficiario(idParentescoFamiliar, nombreFamiliar)
{


  $("#txtOtroBeneficiarioE").val(nombreFamiliar);
  obtenerListaBeneficiariosEdited(idParentescoFamiliar);

   // $("#contenidoOtroBeneficiarioEdited").val(idParentescoFamiliar);

 }


 function editarDatosPadre(){

  var numeroEmpleadoEntidad=$("#numeroEmpleadoEntidadEdited").val();
  var numeroEmpleadoConsecutivo=$("#numeroEmpleadoConsecutivoEdited").val();
  var numeroEmpleadoTipo=$("#numeroEmpleadoTipoEdited").val();
  var nombreFamiliar=$("#txtNombrePadreEdited").val();
  var idParentescoFamiliar=4;
  var beneficiario=0;


  if( $('#checkPadreE').prop('checked') ) 

  {
   beneficiario=1

        } //fin if 

        $.ajax({
          type: "POST",
          url: "ajax_registroDatosFamiliares.php",
          data: {"numeroEmpleadoEntidad":numeroEmpleadoEntidad,"numeroEmpleadoConsecutivo":numeroEmpleadoConsecutivo,"numeroEmpleadoTipo":numeroEmpleadoTipo,
          "nombreFamiliar":nombreFamiliar,"idParentescoFamiliar":idParentescoFamiliar,"beneficiario":beneficiario},
          dataType: "json",
          success: function(response) {
            var mensaje=response.message;

            if (response.status=="success") {


              alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Datos Familoares</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

              $("#alertMsg").html(alertMsg1);
              $(document).scrollTop(0);
              $('#msgAlert').delay(3000).fadeOut('slow');

              var numeroEmpleado=$("#numeroEmpleadoEntidadEdited").val()+"-"+$("#numeroEmpleadoConsecutivoEdited").val()+"-"+$("#numeroEmpleadoTipoEdited").val();
              consultaEmpleado(numeroEmpleado);

            } else if (response.status=="error")
            {
              alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error en el registro de Datos Generales:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

              $("#alertMsg").html(alertMsg1);
              $(document).scrollTop(0);
              $('#msgAlert').delay(3000).fadeOut('slow');
            }
          },
          error: function(){
            alert('error handing here');
          }
        });

      }

      function editarDatosMadre(){

        var numeroEmpleadoEntidad=$("#numeroEmpleadoEntidadEdited").val();
        var numeroEmpleadoConsecutivo=$("#numeroEmpleadoConsecutivoEdited").val();
        var numeroEmpleadoTipo=$("#numeroEmpleadoTipoEdited").val();
        var nombreFamiliar=$("#txtNombreMadreEdited").val();
        var idParentescoFamiliar=5;
        var beneficiario=0;

        if( $('#checkMadreE1').prop('checked') ) 

        {
         beneficiario=1

        } //fin if 

        $.ajax({
          type: "POST",
          url: "ajax_registroDatosFamiliares.php",
          data: {"numeroEmpleadoEntidad":numeroEmpleadoEntidad,"numeroEmpleadoConsecutivo":numeroEmpleadoConsecutivo,"numeroEmpleadoTipo":numeroEmpleadoTipo,
          "nombreFamiliar":nombreFamiliar,"idParentescoFamiliar":idParentescoFamiliar,"beneficiario":beneficiario},
          dataType: "json",
          success: function(response) {
            var mensaje=response.message;

            if (response.status=="success") {


              alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Datos Familoares</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

              $("#alertMsg").html(alertMsg1);
              $(document).scrollTop(0);
              $('#msgAlert').delay(3000).fadeOut('slow');

              var numeroEmpleado=$("#numeroEmpleadoEntidadEdited").val()+"-"+$("#numeroEmpleadoConsecutivoEdited").val()+"-"+$("#numeroEmpleadoTipoEdited").val();
              consultaEmpleado(numeroEmpleado);

            } else if (response.status=="error")
            {
              alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error en el registro de Datos Generales:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

              $("#alertMsg").html(alertMsg1);
              $(document).scrollTop(0);
              $('#msgAlert').delay(3000).fadeOut('slow');
            }
          },
          error: function(){
            alert('error handing here');
          }
        });

      }


      function editarDatosBeneficiario(){


        var numeroEmpleadoEntidad=$("#numeroEmpleadoEntidadEdited").val();
        var numeroEmpleadoConsecutivo=$("#numeroEmpleadoConsecutivoEdited").val();
        var numeroEmpleadoTipo=$("#numeroEmpleadoTipoEdited").val();
        var nombreFamiliar=$("#txtOtroBeneficiarioE").val();
        var idParentescoFamiliar=$("#selectOtroBeneficiarioEdited").val();;
        var beneficiario=0;

        if( $('#checkBeneficiarioE').prop('checked') ) 

        {
          beneficiario=1;

          $.ajax({
            type: "POST",
            url: "ajax_insertaActualizaDatosBeneficiario.php",
            data: {"numeroEmpleadoEntidad":numeroEmpleadoEntidad,"numeroEmpleadoConsecutivo":numeroEmpleadoConsecutivo,"numeroEmpleadoTipo":numeroEmpleadoTipo,
            "nombreFamiliar":nombreFamiliar,"idParentescoFamiliar":idParentescoFamiliar,"beneficiario":beneficiario},
            dataType: "json",
            success: function(response) {
              var mensaje=response.message;

              if (response.status=="success") {


                alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Datos Familiares</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                $("#alertMsg").html(alertMsg1);
                $(document).scrollTop(0);
                $('#msgAlert').delay(3000).fadeOut('slow');

                var numeroEmpleado=$("#numeroEmpleadoEntidadEdited").val()+"-"+$("#numeroEmpleadoConsecutivoEdited").val()+"-"+$("#numeroEmpleadoTipoEdited").val();
                consultaEmpleado(numeroEmpleado);



              } else if (response.status=="error")
              {
                alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error en el registro de Datos Generales:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                $("#alertMsg").html(alertMsg1);
                $(document).scrollTop(0);
                $('#msgAlert').delay(3000).fadeOut('slow');
              }
            },
            error: function(){
              alert('error handing here');
            }
          });
        }
      }


      function limpiarFormulario(){


       $("#selectLineaNegocioEdited").prop('selectedIndex', 0);
       $("#tipoPuestoEdited").prop('selectedIndex', 0);
       $("#puestoEdited").prop('selectedIndex', 0);
       $("#dirigenteEdited").prop('selectedIndex', -1);
       $("#IdSucursal").val(0);
       $("#idDepartamentoPuesto").val(0);
       $("#idEndidadFederativaEdited").prop('selectedIndex', 0);
       $("#idEndidadFederativaParaSucursalEdited").prop('selectedIndex', 0);
       $("#selectPuntoServicioEdited").prop('selectedIndex', 0);
       $("#tipoTurnoEdited").prop('selectedIndex', 0);
       $("#selectEntidadNacimientoEdited").prop('selectedIndex', 0);
       $("#selectMunicipioNacEdited").prop('selectedIndex', 0);

       $("#selectEstadoCivilEdited").prop('selectedIndex', 0);
       $("#selectOtroBeneficiarioEdited").prop('selectedIndex', 0);
       $("#selectGradoEstudiosEdited").prop('selectedIndex', 0);
       $("#selectTipoSangreEdited").prop('selectedIndex', 0);
       $("#selectOficioEdited").prop('selectedIndex', 0);

       jQuery("#1generoEdited").prop('checked', false);
       jQuery("#2generoEdited").prop('checked', false);
       $("input[name=periodoEdited]").prop('checked', false);

 // Limpia el div de la foto del empleado
 $("#fotoEmpleadoEdited").html ("");

 if( $('#checkMadreE1').prop('checked') ) 
 {
  $('#checkMadreE1').checkbox('click');
  jQuery("#checkMadreE1").prop('checked',false);

   // alert('Seleccionado mama');
 }

 if( $('#checkPadreE').prop('checked') ) 
 {
  $('#checkPadreE').checkbox('click');
  jQuery("#checkPadreE").prop('checked',false);

    //alert('Seleccionado papa');
  }
  if( $('#checkBeneficiarioE').prop('checked') ) 
  {
    $('#checkBeneficiarioE').checkbox('click');
    jQuery("#checkBeneficiarioE").prop('checked',false);

    //alert('Seleccionado papa');
  }

  $('input[type=text]').each(function() {
    $(this).val("");
  });

  $("#txtDireccionUmfEdited").val("");
  $("#contenidoOtroBeneficiarioEdited").remove();

}

$('input[type="checkbox"].style3').checkbox({
  buttonStyle: 'btn-danger',
  buttonStyleChecked: 'btn-success',
  checkedClass: 'icon-check',
  uncheckedClass: 'icon-check-empty'
});

$(inicioConsultaPersonal());  

function inicioConsultaPersonal(){

  var sel="<select id='selBancoEdit' name='selBancoEdit'><option value='0' selected='selected'>BANCO</option>"; 
  $.ajax({
      async: false,
      type: "POST",
      url: "ajax_getBancos.php",
      dataType: "json",
      success: function(response) {
        $('#divSelBanco').append('');
        if(response.status == "success"){
          for(var i = 0; i < response.bancos.length; i++){
              sel+='<option value="' + (response.bancos[i].idCuentaBanco) + '">' + response.bancos[i].nombreBanco + '</option>';
         }
         $("#hiddebanderaselbanco").val(1);
       }else{
        alert("Error al cargar bancos");
      }
    },
    error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
  });
  sel+="</select>";
  $("#divSelBanco").html(sel);  
  $("#divLblBanco").html("<label class='control-label2 label' for='selBancoEdit'>Banco</label>");   
  $("#selBancoEdit").prop("disabled",true);
  
    $("#documentoDigitalizado1_7").prop("disabled",true);//se desabilitan los botones ya que estos archivos son cargados desde contrataciones AVISO INSCRIPCION IMSS
 // $("#documentoDigitalizado1_9").prop("disabled",true);//se desabilitan los botones ya que estos archivos son cargados desde contrataciones CEDULA SAT(RFC)
  //$("#documentoDigitalizado1_12").prop("disabled",true);//se desabilitan los botones ya que estos archivos son cargados desde contrataciones TICKET DE CUENTA

  var fileFotoEmpleadoEdited = $("#fileFotoEmpleadoEdited");

  fileFotoEmpleadoEdited.fileinput({
        uploadUrl: "upload_fotoempleadoEdited.php", // server upload action
        uploadAsync: false,
        showUpload: false, // hide upload button
        showRemove: false, // hide remove button
        showPreview: false,
        uploadExtraData: {'type' : 'Edited'}
      }).on("filebatchselected", function(event, files) {
        // trigger upload method immediately after files are selected
        fileFotoEmpleadoEdited.fileinput("upload");
      }).on('filebatchuploadsuccess', function(event, data, previewId, index) {
        var form = data.form, files = data.files, extra = data.extra, 
        response = data.response, reader = data.reader;
        
        if (response.status == "error")
        {
          alert (response.message);
          return;
        }

        $("#fotoEmpleadoEdited").html ("<img style='margin:0 auto;' src='thumbs/" + response.file + "'/>");
        $("#idFotoEmpleadoEdited").val (response.file);
        
      });

      <?php
      foreach ($documentos as $documento):
        ?>
        var $input_<?php echo $documento["idDocumento"]; ?> = $("#documentoDigitalizado1_<?php echo $documento["idDocumento"]; ?>");
        $input_<?php echo $documento["idDocumento"]; ?>.fileinput({
        uploadUrl: "upload_documentodigitalizadoEdited.php", // server upload action   download_file.php?id=b886440183cc3b81b9197039c4276abe
        uploadAsync: false,
        showUpload: false, // hide upload button
        showRemove: false, // hide remove button
        showPreview: false,
        uploadExtraData: function () {
          var data1 = {};

          data1 ["tipoDocumentoDigitalizado"] = <?php echo $documento["idDocumento"]; ?>;
          data1 ["numeroEmpleadoEntidadEdited"] = $("#numeroEmpleadoEntidadEdited").val();
          data1 ["numeroEmpleadoConsecutivoEdited"] = $("#numeroEmpleadoConsecutivoEdited").val();
          data1 ["numeroEmpleadoTipoEdited"] = $("#numeroEmpleadoTipoEdited").val();
          return data1;
        }
      }).on("filebatchselected", function(event, files) {
        // trigger upload method immediately after files are selected
        $input_<?php echo $documento["idDocumento"]; ?>.fileinput("upload");
      }).on('filebatchuploadsuccess', function(event, data1, previewId, index) {
        var form = data1.form, files = data1.files, extra = data1.extra, 
        response = data1.response, reader = data1.reader;
        console.log('File batch upload success');
        
        if (response.status == "error")
        {
          alert (response.message);
          return;
        }
        
        var icons_area = $("#icons_documentos_edited_<?php echo $documento["idDocumento"]; ?>");
        
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

function consultarDocumentos(){
  $("#IdArchivoHidden").val("");
  <?php
  foreach ($documentos as $documento):
    ?>

    var idDocumento=  <?php echo $documento["idDocumento"]; ?>;
    var tipoDocumentoDigitalizado= <?php echo $documento["idDocumento"]; ?>;
    var numeroEmpleadoEntidadEdited= $("#numeroEmpleadoEntidadEdited").val();
    var numeroEmpleadoConsecutivoEdited=$("#numeroEmpleadoConsecutivoEdited").val();
    var numeroEmpleadoTipoEdited= $("#numeroEmpleadoTipoEdited").val();
    $.ajax({
      type: "POST",
      url: "ajax_obtenerDocumentos.php",
      data: {"numeroEmpleadoEntidadEdited":numeroEmpleadoEntidadEdited,"numeroEmpleadoConsecutivoEdited":numeroEmpleadoConsecutivoEdited,
      "numeroEmpleadoTipoEdited":numeroEmpleadoTipoEdited, "tipoDocumentoDigitalizado":tipoDocumentoDigitalizado},
      dataType: "json",
      success: function(response) {
        if (response.status == "ok")
        {
                 // alert(response);

                 var icons_area = $("#icons_documentos_edited_<?php echo $documento["idDocumento"]; ?>");

                 var documentos = "";
                 for (var i = 0; i < response.documentos.length; i++)
                 {
                  documento = response.documentos[i];
                  if(documento.IdTipoArchivo=="9"){
                    $("#IdArchivoHidden").val(documento.id);
                  }
                  documentos += "<p><a href='download_file.php?id=" + documento.id + "'  title='Fecha Carga : "+ documento.documentoFechaRegistro +"'><img src='img/" + documento.icono + "' height='24px' width='24px'/>" + documento.nombreArchivo + "</a></p>";
                }

                icons_area.html (documentos);

        //alert (icons_area.html());

      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
  });


    
    <?php
  endforeach;
  ?>

}

function mostrarModalBajaEmpleado(numeroEmpleado, fechaIngreso, nombreCompleto, estatusEmpleado, tipoPeriodo, empleadoIdPuntoServicio, tipoEmpleado, idResponsableAsistencia, puestoCubiertoId, entidadTrabajo,empleadoIdGenero,estatusImss,roloperativo,foliopreseleccion,estatusEmpleadoOperaciones,DescripcionEntidadTr)
{
  var ValidacionesEstatusEmpleado = 0;
  var datosDirectorio = 0;
  $.ajax({
    type: "POST",
    url: "ajax_obtenerEstatusEmpleado.php",
    data: {"numeroEmpleado":numeroEmpleado},
    dataType: "json",
    async:false,
    success: function(response) {
      if (response.status == "success")
      {
        ValidacionesEstatusEmpleado = response.accion;
        datosDirectorio = response.datosDirectorio;
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }
  }); 
  if(ValidacionesEstatusEmpleado == 1 ){
    swal("Alto", "Por Proceso: El tiempo de movimiento aun NO se tiene la confirmación","error");
  }else if (ValidacionesEstatusEmpleado == 0){
    swal("Alto", "El empleado  se encuentra en Proceso De Baja en la pestaña 'Solicitud de baja' favor de revisar","error");
  }if (datosDirectorio == 1){
    swal("Alto", "Ingrese los datos del Directorio para continuar con el reingreso","error");
  }else{
    $("#numempleadoFirmahiddenRh").val("");
    $("#NombreGuardiaRh").val("");
    $("#FirmaInternaGuardiaRh").val("");
    $("#NombreSolicitanteRh").val("");
    $("#FirmaInternaRh").val("");
    $("#txtComentarioBaja").val("");
    $("#docPagoDeuda").val("");
    $("#mostrarbtnguardarsolicituReingreso").show();
    $("#mostrabtneditarsolicitudconsultaEmpleado").hide();
    $("#numeroEmpleadohdn").val(numeroEmpleado);
    $("#fechaIngresohdn").val(fechaIngreso);
    $("#nombreCompletohdn").val(nombreCompleto);
    $("#estatusEmpleadohdn").val(estatusEmpleado);
    $("#tipoPeriodohdn").val(tipoPeriodo);
    $("#empleadoIdPuntoServiciohdn").val(empleadoIdPuntoServicio);
    $("#tipoEmpleadohdn").val(tipoEmpleado);
    $("#idResponsableAsistenciahdn").val(idResponsableAsistencia); 
    $("#puestoCubiertoIdhdn").val(puestoCubiertoId);
    $("#entidadTrabajohdn").val(entidadTrabajo);
    $("#empleadoIdGenerohdn").val(empleadoIdGenero);
    $("#estatusImsshdn").val(estatusImss);
    $("#roloperativohdn").val(roloperativo);
    $("#foliopreseleccionhdn").val(foliopreseleccion);
    $("#estatusEmpleadoOperacioneshdn").val(estatusEmpleadoOperaciones);
    $("#DescripcionEntidadTrhdn").val(DescripcionEntidadTr);

    banderaincapacidad=consultaultimofolioincapacidad(numeroEmpleado,2); 
    consultaultimofiniquito(numeroEmpleado); //crissss
    consultarsielempleadoestabetado(numeroEmpleado);
    var UltimaDeuda1 = $("#UltimaDeudahdn").val();
    var EstatusDeuda1 = $("#EstatusDeudahdn").val();
    var Deuda1 = $("#DeudaEmphdn").val();
    var EstatusBetado = $("#EstatusBetado").val();
    var MotivoBetado = $("#MotivoBetado").val();
    var ModuloBaja = $("#ModuloBaja").val();
    var deuda2 = ((Deuda1)*(-1)); 
    if(!banderaincapacidad){
      var mmsssjjjreingressso="El Empleado no puede ser dado de baja debido a que se encuentra de incapacidad";
      alertMsgre="<div id='msgAlert1' class='alert alert-error'><strong>Reingreso Del Empleado : </strong>"+mmsssjjjreingressso+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
      $("#alertMsg").html(alertMsgre);
      $(document).scrollTop(0);
      $('#msgAlert1').delay(4000).fadeOut('slow');
    }else if(estatusEmpleadoOperaciones==3 ){
      var mmsssjjjreingressso="El Empleado Esta En Proceso De Baja Por Favor Termina Proceso";
      alertMsgre="<div id='msgAlert1' class='alert alert-error'><strong>Reingreso Del Empleado : </strong>"+mmsssjjjreingressso+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
      $("#alertMsg").html(alertMsgre);
      $(document).scrollTop(0);
      $('#msgAlert1').delay(4000).fadeOut('slow');
    }else if(UltimaDeuda1 !='0' && EstatusDeuda1=='0' ){
      $("#NombreEmpleadoDeuda").val(nombreCompleto);
      $("#numempleadoDeuda").val(numeroEmpleado);
      $("#RolOperativoEmpDeuda").val(roloperativo);
      $("#EntidadEmpDeuda").val(DescripcionEntidadTr);
      $("#DeudaEmp").val(deuda2);        
      $("#ModalArchivoDeuda").modal();
    }else if(EstatusBetado==="0"){
      window.open("generadorActaAdministrativaVatado.php?numempleado=" + numeroEmpleado+"&ModuloBaja=" + ModuloBaja,'fullscreen=no');
      $("#modalCurpInterno").modal("show");
      $("#MensajeCurp").html("El empleado No podrá ser reingresado debido a que esta vetado del corporativo favor de revisar el acta administrativa para saber el motivo");
    }else{
      //***CAMPOS PARA RESETEAR MODAL SOLICITUD REINGREO EMPLEADO**********////////////
      $("#form_registroPreseleccionReingresoEmpleado")[0].reset(); 
      $("#folioempleadopreseleccionRE").val("");
      $("#numempleadopreseleccionRE").val("");
      $("#txtFolioSolicitudRE").val("");
      $('#checkEmpInfonavitRE').removeAttr('checked');
      $('#checkEmpFonacotRE').removeAttr('checked');
      $('#checkEmpCartillaRE').removeAttr('checked');
      $('#checkEmpLicenciaRE').removeAttr('checked');
      $('#checkEmpPersonasRE').removeAttr('checked');
      $("#selectEmpCivilRE").val("");
      $("#selectEmpSexoRE").val("");
      $("#selectEmpTipoSangreRE").val("");
      $("#selectEmpSexoRE").val("");
      $("#selectEmpEntidadRE").val("");
      $("#selectEmpEstudioRE").val("");
      /////////////////////////////////////*******************///////////////////////////
      $("#txtFechaIngresoModaloculto").val(fechaIngreso);
      $("#inpNoCuentaReingreso").val("");
      $("#inpNoCuentaClabeReingreso").val("");
      $("#docdigitalizado0").val("");
      $("#docdigitalizado1").val("");
      $("#docdigitalizado2").val("");
      $("#inproloperativo").val(roloperativo);
      $("#numempleadopreseleccionRE").val(numeroEmpleado);
      if(foliopreseleccion=="null" || foliopreseleccion==null ||foliopreseleccion=="NULL"){
        foliopreseleccion="";
      }
      $("#folioempleadopreseleccionRE").val(foliopreseleccion);
      <?php
      if ($usuario["rol"] =="Administrador" || $usuario["rol"] =="Contrataciones" || $usuario["rol"] =="Lider Unidad" || $usuario["rol"] =="Laborales" )
      {
      ?>
        var estatusfiniquito=verificarestatusdefiniquito(numeroEmpleado);
        var SueldoEstatus=ConsultaSueldoEmpleadoBaja(numeroEmpleado);
        if (!estatusfiniquito){
          $("#modalErrorReingresoPorFiniquito").modal();
        }else{
          if (estatusEmpleado==1 || estatusEmpleado==2){
            if(estatusImss==1 || estatusImss==2 ){
              $("#modalErrorBajaImss").modal();
            }else{
              if(!SueldoEstatus){
                $("#modalErrorBajaImssCuota").modal();
              }else{
                $('#myModalBajaEmpleado').modal();
                $("#txtNumeroEmpleadoModal").val(numeroEmpleado);
                $("#txtFechaIngresoModal").val(fechaIngreso);
                $("#txtNombreEmpleadoModal").val(nombreCompleto);
                $("#txtFechaBajaModal").val(currentDate);
                $("#txtTipoPeriodo").val(tipoPeriodo);
                $("#txtPuntoServicioBaja").val(empleadoIdPuntoServicio);
                $("#txtTipoEmpleado").val(tipoEmpleado);
                $("#txtResponsableAsistencia").val(idResponsableAsistencia);
                $("#txtPuestoBajaModal").val(puestoCubiertoId);
                $("#txtEstatusImss").val(estatusImss);
                if(tipoEmpleado=="02"){
                  $("#FirmaOperativoBaja").hide();
                  $("#FirmaAdministrativoBaja").show();
                }else{
                  $("#FirmaOperativoBaja").show();
                  $("#FirmaAdministrativoBaja").hide();
                }
              }
            }
          }else if(estatusEmpleado==0){
            if(estatusImss==8){
              limpiarModalReingreso();
              $("#txtNumeroEmpleadoModalR").val(numeroEmpleado);
              $("#txtFechaIngresoModalR").val(currentDate);
              $("#txtNombreEmpleadoModalR").val(nombreCompleto);
              $("#txtGeneroReingreso").val(empleadoIdGenero);
              funcionmostrarFormSolicitudEmpleo(foliopreseleccion);
            }else{
              if(estatusImss!=7){
                var mensajereingreo="El Empleado Esta En Proceso De Baja No Puede Ser Reingresado,Termine Proceso De Finiquito.";
                alertMsgre="<div id='msgAlert1' class='alert alert-error'><strong>Reingreso Del Empleado : </strong>"+mensajereingreo+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>"; 
                $("#alertMsg").html(alertMsgre);
                $(document).scrollTop(0);
                $('#msgAlert1').delay(4000).fadeOut('slow');
              }else{
                limpiarModalReingreso();
                $("#txtNumeroEmpleadoModalR").val(numeroEmpleado);
                $("#txtFechaIngresoModalR").val(currentDate);
                $("#txtNombreEmpleadoModalR").val(nombreCompleto);
                $("#txtGeneroReingreso").val(empleadoIdGenero);
                funcionmostrarFormSolicitudEmpleo(foliopreseleccion);
              } 
            }
          }
        }
      <?php
      }//If del php
      ?>
    }// If Del Estatus Betado
  }//else de la validacion de estatus del empleado
}// Fin de la funcion

 var dateToDisable = new Date();
 var currentDate ="";

  $("#txtFechaIngresoModalR").datetimepicker({
  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',
  maxDate:  dateToDisable.setDate(dateToDisable.getDate()),
   //endDate: '+2d'
   minDate: currentDate,

  });

function ConsultaSueldoEmpleadoBaja(numeroEmpleado){
  var valor1;
        $.ajax({
            type: "POST",
            url: "ajax_ConsultaSueldoEmpleadoBaja.php",
            data: {"numeroEmpleado":numeroEmpleado},
            dataType: "json",
            async: false, 
            success: function(response) {
                var mensaje=response.message;
                if (response.status=="success") {
                    var ExisteEmpleado = response.datos[0]["ExisteEmpleado"];
                    var cuotaDiariaEmpleado = response.datos[0]["cuotaDiariaEmpleado"];
                    //alert(cuotaDiariaEmpleado);
                    if(ExisteEmpleado == "0"){
                        valor1 = false;
                    }else if(ExisteEmpleado != "0" && cuotaDiariaEmpleado <=0){
                        valor1 = false;
                    }else{
                        valor1 = true; 
                    }
                } else if (response.status=="error")
                {
                  valor1 = false;
                  alert(mensaje);
                }
              },
              error: function(){
                  alert(jqXHR.responseText);
            }
        });
        return valor1;
    }

function verificarestatusdefiniquito(numeroEmpleado){
  var valor;
  $.ajax({
    type: "POST",
    url: "ajax_consultaFiniquitoPorConfirmar.php",
    data: {"numeroEmpleado":numeroEmpleado},
    dataType: "json",
    async: false, 
    success: function(response) {
              //console.log(response);
              var numeroFiniquitos=response.numeroFiniquitos;
              if(numeroFiniquitos>0){
              //alert("retorno false");
              valor = false;

            }else{
               //alert("retorno true");
               valor = true; 
             }
           },
           error: function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText);

          }

        });

  return valor;
}
function mostrarModalFirma(){
  $('#modalFirma').modal();
}


function cerrarModalBajaEmpleado ()
{
  $("#myModalBajaEmpleado").modal("hide");

  configureFooterBajaEmpleado ();
}

function configureFooterBajaEmpleado ()
{
  $("#footerBajaEmpleado").html ("<button type='button' class='btn btn-danger' data-dismiss='modal'>Cancelar</button><button type='button' class='btn btn-primary' onclick='guardarHistoricoBajaSubmit();'>Guardar Cambios</button>");
}

function guardarHistoricoBajaSubmit ()
{
  var NombreSolicitanteRh = $("#NombreSolicitanteRh").val();
  var selectTipoBaja=$("#selectTipoBaja").val();
  var fechaIngreso=$("#txtFechaIngresoModal").val();
  var puntoServicioId=$("#txtPuntoServicioBaja").val();
  var tipoPeriodo=$("#txtTipoPeriodo").val();
  var supervisorId=$("#txtResponsableAsistencia").val();
  var puestoCubiertoId=$("#txtPuestoBajaModal").val();
  var estatusImss=$("#txtEstatusImss").val();
  var motivoBaja=$("#selectMotivoBaja").val();
  var comentarioBaja=$("#txtComentarioBaja").val();
  var numempleadoFirmahiddenRh=$("#numempleadoFirmahiddenRh").val();
  var FirmaInternaRh=$("#FirmaInternaRh").val();
  var fechaBaja=$("#txtFechaBajaModal").val();
  var numeroEmpleado=$("#txtNumeroEmpleadoModal").val();
  var txtNombreEmpleadoModal=$("#txtNombreEmpleadoModal").val();
  var idEndidadFederativaEdited = $("#idEndidadFederativaEdited option:selected" ).text();
  var selectPuntoServicioEdited = $("#selectPuntoServicioEdited option:selected" ).text();
  var clienteBajaRh=$("#clienteBajaRh").val();
  var dirigenteEdited = $("#dirigenteEdited option:selected" ).text();
  var FirmaInternaGuardiaRh = $("#FirmaInternaGuardiaRh").val();
  var NombreGuardiaRh = $("#NombreGuardiaRh").val();
  var ComentarioBetado = $("#ComentarioBetado").val();
  var banderaBetado = $("#banderaBetado").val();
  var selHorarioBaja1 = $("#selHorarioCons").val();
  if(selHorarioBaja1 =="" || selHorarioBaja1 =="undefined" || selHorarioBaja1 ==undefined || selHorarioBaja1 =="null" || selHorarioBaja1 =="NULL" || selHorarioBaja1 ==0 || selHorarioBaja1 =="0"){
    var selHorarioBaja=0;
  }else{
    var selHorarioBaja = selHorarioBaja1;
  }
  $("#footerBajaEmpleado").html ("<img src='img/loading-sm.gif' />");
  var roloperativo=$("#inproloperativo").val();
  $("#btnguardarbajaempleado").prop("disabled",true);
  var txtfechaquitarantesubirloscambios= $("#txtfechaquitarantesubirloscambios").val();//se evalua esteinput con la fecha del modal de baja para despues hacer la comparacion en la funcion consultaultimofolioincapacidad
  banderaincapacidad=consultaultimofolioincapacidad(numeroEmpleado,2);
  if(!banderaincapacidad){
    hoyFecha();
    configureFooterBajaEmpleado ();  
    cerrarModalBajaEmpleado();
  }else if(fechaBaja==""){
   errorModalBajaRh("Seleccione la fecha de baja");
   configureFooterBajaEmpleado ();
  }else if(fechaBaja<txtfechaquitarantesubirloscambios){
   errorModalBajaRh("La fecha de baja no puede ser menor a la fecha actual");
   configureFooterBajaEmpleado ();
  }else if(selectTipoBaja=="TIPO BAJA" || selectTipoBaja=="0" || selectTipoBaja==""){
   errorModalBajaRh("Seleccione el tipo de baja");
   configureFooterBajaEmpleado (); 
  }else if(motivoBaja=="MOTIVO BAJA" || motivoBaja=="0" || motivoBaja==""){
    errorModalBajaRh("Seleccione el motivo de baja");
    configureFooterBajaEmpleado ();
  }else if(comentarioBaja==""){
    errorModalBajaRh("Especifique la causa de baja en el campo (COMENTARIO)");
    configureFooterBajaEmpleado ();
  }else if(numempleadoFirmahiddenRh=="" || NombreSolicitanteRh==""){
    errorModalBajaRh("ingrese su firma del documento para continuar en caso de no tener crear una firma interna");
    configureFooterBajaEmpleado ();
  }else if(FirmaInternaGuardiaRh=="" || NombreGuardiaRh==""){
    errorModalBajaRh("ingrese la contraseña del guardia generada al activar su cuanta en contrataciones si no recuerda cual es actualize la contraseña");
    configureFooterBajaEmpleado ();
  }else if(banderaBetado=="" || banderaBetado=="null" || banderaBetado=="NULL" || banderaBetado==null){
    errorModalBajaRh("Seleccione una opcion de la pregunta ¿ESTE ELEMENTO PODRÁ SER REINGRESADO POSTERIORMENTE?");
    configureFooterBajaEmpleado ();
  }else if((banderaBetado=="0" || banderaBetado==0) && ComentarioBetado==""){
    errorModalBajaRh("Indique el motivo por el cual el elemento será vetado del Corporativo Gif Seguridad Privada");
    configureFooterBajaEmpleado ();
  }else{
    var formData = new FormData($("#form_EditaEmpleado")[0]);
        //for (var value of formData.values()) {}
    $.ajax({
      type: "POST", 
      url: "upload_ArchivoBaja1RH.php",
      data: {"motivoBaja":motivoBaja,"comentarioBaja":comentarioBaja, "numempleadoFirmahiddenRh":numempleadoFirmahiddenRh,"FirmaInternaRh":FirmaInternaRh,"fechaBaja":fechaBaja,"numeroEmpleado":numeroEmpleado,"txtNombreEmpleadoModal":txtNombreEmpleadoModal,"idEndidadFederativaEdited":idEndidadFederativaEdited,"selectPuntoServicioEdited":selectPuntoServicioEdited,"clienteBajaRh":clienteBajaRh,"dirigenteEdited":dirigenteEdited,"FirmaInternaGuardiaRh":FirmaInternaGuardiaRh,"ComentarioBetado":ComentarioBetado,"banderaBetado":banderaBetado},
      dataType: "json",
      success: function(response) {
        if(response.status=="success"){
          $.ajax({
            type: "POST",
            url: "ajax_registroHistoricoBaja.php",
            data: {"banderaBetado":banderaBetado,"ComentarioBetado":ComentarioBetado,"numeroEmpleado":numeroEmpleado,"idMotivoBaja":motivoBaja, "fechaIngreso":fechaIngreso,"fechaCausaBaja":fechaBaja,"comentarioBaja":comentarioBaja, puntoServicioId:puntoServicioId, tipoPeriodo:tipoPeriodo, supervisorId:supervisorId, puestoCubiertoId:puestoCubiertoId,roloperativo:roloperativo},
            dataType: "json",
            success: function(response) {
              var mensaje=response.message;
              if (response.status=="success") {
                alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Datos Gegerales</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#alertMsg1").html(alertMsg1);
                $(document).scrollTop(0);
                $('#msgAlert').delay(3000).fadeOut('slow');                     
                if(estatusImss!=8){
                  solicitaBajaImss();
                }
                GuardarMovimientoPlantillaHistorico("BAJA",selHorarioBaja);  
                $("#selectMotivoBaja").val("MOTIVO BAJA");
                $("#txtComentarioBaja").val("");
                $("#ArchivoBajaEmp").val("");
                $("#ArchivoBajaEmp").empty();
                $("#selectTipoBaja").val("TIPO BAJA");
                $("#footerBajaEmpleado").html ("<button class='btn btn-primary' onclick='cerrarModalBajaEmpleado ();' type='button'>Cerrar</button>");
                cerrarModalBajaEmpleado();
                consultaEmpleado(numeroEmpleado); 
                getSolicitudesBajas();
                $("#btnguardarbajaempleado").prop("disabled",false);
              }else if (response.status=="error")
              {
                alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Registro baja:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#alertMsg1").html(alertMsg1);
                $(document).scrollTop(0);
                $('#msgAlert').delay(3000).fadeOut('slow'); 
                configureFooterBajaEmpleado ();
                $("#btnguardarbajaempleado").prop("disabled",false);
              }
            },
            error: function(jqXHR, textStatus, errorThrown){
              alert(jqXHR.responseText); 
              alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Registro baja:</strong>Ocurrio un error en la comunicación con el servidor.<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
              $("#alertMsg1").html(alertMsg1);
              $(document).scrollTop(0);
              $('#msgAlert').delay(3000).fadeOut('slow');
              $("#btnguardarbajaempleado").prop("disabled",false);   
              configureFooterBajaEmpleado ();
            }
          });
        }else{
          var mensaje1 = response.message;
          alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Registro baja:</strong>"+mensaje1+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
          $("#alertMsg1").html(alertMsg1);
          $(document).scrollTop(0);
          $('#msgAlert').delay(3000).fadeOut('slow'); 
          configureFooterBajaEmpleado ();
          $("#btnguardarbajaempleado").prop("disabled",false);
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
        $("#btnguardarbajaempleado").prop("disabled",false);
              configureFooterBajaEmpleado ();


      }
    });
  }//termina el else
}



    function aplicarReingreso(plantillaTexto){

      var fechaReingreso=$("#txtFechaIngresoModalR").val();
      var numeroEmpleado=$("#txtNumeroEmpleadoModalR").val();
      var estatusEmpleado=2;

      var fechaBaja="";

      $.ajax({
        type: "POST",
        url: "ajax_actualizaEstatusEmpleado.php",
        data: {"fechaReingreso":fechaReingreso, "numeroEmpleado":numeroEmpleado, "estatusEmpleado":estatusEmpleado, "fechaBaja":fechaBaja, "plantillaTexto":plantillaTexto},
        dataType: "json",
        success: function(response) {
          var mensaje=response.message;

          if (response.status=="success") {

            alertMsg1="<div id='msgAlert' name='msgAlert' class='alert alert-success'><strong>Reingreso</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

            $("#alertMsg1").html(alertMsg1);
            $(document).scrollTop(0);
            $("#msgAlert").delay(3000).fadeOut('slow');
                   // actualizaFechaReingreso();
                   $('#myModalReingresoEmpleado').modal('hide');
                   consultaEmpleado(numeroEmpleado);


                 } else if (response.status=="error")
                 {
                  alertMsg1="<div id='msgAlert' name='msgAlert' class='alert alert-error'><strong>Reingreso:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                  $("#alertMsg1").html(alertMsg1);
                  $(document).scrollTop(0);
                  $("#msgAlert").delay(3000).fadeOut('slow');
                }
              },
              error: function(){
                alert('error handing here');
              }
            });

    }


    function solicitaReingresoImss(){

      var numeroEmpleado=$("#txtNumeroEmpleadoModalR").val();
      var folioTxt="";
      var empleadoEstatusImss="1";
      var numeroLote="";
      var fechaImss=$("#txtFechaIngresoModalR").val();
      var BanderaReingreso = $("#BanderaSalarioReingreso").val();
      if(BanderaReingreso == "1"){
        var SalarioDiarioReingreso = $("#SalarioDiarioEmpReingreso").val();
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
              $("#SalarioDiarioEmpReingresoImss").val(salarioDiario2);
            }
          },error: function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText);
          }
        });
        var SalarioDiarioReingreso = $("#SalarioDiarioEmpReingresoImss").val();
      }
      $.ajax({
        type: "POST",
        url: "ajax_actualizaEstatusEmpleadoImssReingreso.php",
        data: {"numeroEmpleado":numeroEmpleado,"folioTxt":folioTxt,"empleadoEstatusImss":empleadoEstatusImss, "numeroLote":numeroLote,"fechaImss":fechaImss,"SalarioDiarioReingreso":SalarioDiarioReingreso,"BanderaReingreso":BanderaReingreso },
        dataType: "json",
        async:false,
        success: function(response) {
          var mensaje=response.message;

          if (response.status=="success") {


          } else if (response.status=="error")
          {
            alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error al reingresar:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
 
            $("#alertMsg1").html(alertMsg1);
            $(document).scrollTop(0);
            $('#msgAlert').delay(3000).fadeOut('slow');
          }
        },
        error: function(){
          alert('error handing here');
        }
      });

    }

    function actualizaFechaReingreso(){
      //editarDatosGenerales****//////AQUI ESTASSSS
      var gerenteReingreso=$("#gerenteRegReingreso").val();
      var fechaReingreso=$("#txtFechaIngresoModalR").val();
      var fechaingresooculto=$("#txtFechaIngresoModaloculto").val();
      var numeroEmpleado=$("#txtNumeroEmpleadoModalR").val();
      var idEntidadTrabajo=$("#selectEntidadLaboralReingreso").val();
      var empleadoLineaNegocioId=$("#selectLineaNegocioModalR").val();
      var idTipoPuesto=$("#selectTipoPuestoReingreso").val();
      var empleadoIdPuesto=$("#selectPuestoModalR").val();

      if ((empleadoIdPuesto==6 || empleadoIdPuesto==126 || empleadoIdPuesto==93 || empleadoIdPuesto==31 || empleadoIdPuesto==144 || empleadoIdPuesto==133 || empleadoIdPuesto==44 || empleadoIdPuesto==122 || empleadoIdPuesto==117) && gerenteReingreso==0){
        swal("Alto", "Selecciona el gerente regional","error");
        return;
      }
      var supervisor=$("#selectSupervisorModalR").val();
      var empleadoIdPuntoServicio=$("#selectPuntoServicioModalR").val();
      var empleadoIdTurno=$("#selectTurnoReingreso").val();
      var idClientePunto=$("#opps_"+empleadoIdPuntoServicio).attr("idClientePunto");
      var empleadoIdGenero=$("#txtGeneroReingreso").val();
      var tipoPeriodo=$("#selectPeriodoReingreso").val();
      var selplantillaserviciorei=$("#selplantillaservicioreingreso").val();
      var combo = document.getElementById("selplantillaservicioreingreso");
      if(selplantillaserviciorei =="0" || selplantillaserviciorei=="null" || selplantillaserviciorei== null){
        swal("Alto", "Seleccione La Plantilla Para Continuar","error");
      }else{
        var plantillaText1 = combo.options[combo.selectedIndex].text;
        var plantillaText2  = plantillaText1.split("_");
        var plantillaservicioreingresoText    = plantillaText2[0];
        var plantillaservicioreingreso= plantillaText2[1];
        var bancoreingreso=$("#selectBancoReingreso").val();     
        var nocuentareingreso=$("#inpNoCuentaReingreso").val();  
        var cunetaclabereingreso=$("#inpNoCuentaClabeReingreso").val();  
        var avisoInscripcion0= $("#docdigitalizado0").val();    
        var avisoInscripcion1= $("#docdigitalizado1").val();   
        var avisoInscripcion2= $("#docdigitalizado2").val();   
        var avisoInscripcion3= $("#docdigitalizado3").val(); 
        var AntiguedadVacacionesReingresoNo = $("#AntiguedadVacacionesReingresoNo").val();
        var AntiguedadVacacionesReingresoSi = $("#AntiguedadVacacionesReingresoSi").val();  
        var fechaBaja="";
        var numLicencia=$("#numLicenciaRE").val();
        var fechavigenciaLicencia=$("#fechaLicenciaRE").val();
        var contraseniaFirmReingreso= $("#constraseniaFirmaParaReingresoEmpleadoHidden").val();
        var NumeroFirmReingreso= $("#NumEmpModalFirmaParaReingresoEmpleadohidden").val();
// ******* salario diario **********
        var SalarioDiarioReingreso = $("#SalarioDiarioEmpReingreso").val();
        var constraseniaReingresoSD = $("#constraseniaFirmaParaConfirmacionSalarioDiarioEmpleadoHiddenReingreso").val();
        var NumEmpReingreoSd = $("#NumEmpModalFirmaParaConfirmacionSalarioDiariohiddenReingreso").val();
        var BanderaReingreso = $("#BanderaSalarioReingreso").val();
//**********************************
        var horarioReingreso = $("#selHorarioReingreso").val();
        if(SalarioDiarioReingreso =="" && BanderaReingreso=="1"){      
          swal("Alto", "Genera EL Salario Diario Del Empleado Para Continuar","error");
        }else if(SalarioDiarioReingreso !="" && BanderaReingreso=="1" && (constraseniaReingresoSD =="" || NumEmpReingreoSd =="")){
          swal("Alto", "Confima EL Salario Diario Del Empleado Para Continuar","error");
        }else{
          $.ajax({
            type: "POST",
            url: "ajax_actualizaFechaReingreso.php",
            data: {"fechaReingreso":fechaReingreso,"fechaingresooculto":fechaingresooculto,"numeroEmpleado":numeroEmpleado, "fechaBaja":fechaBaja, idEntidadTrabajo:idEntidadTrabajo, empleadoLineaNegocioId:empleadoLineaNegocioId, idTipoPuesto:idTipoPuesto, empleadoIdPuesto:empleadoIdPuesto, supervisor:supervisor, empleadoIdPuntoServicio:empleadoIdPuntoServicio, empleadoIdTurno:empleadoIdTurno, idClientePunto:idClientePunto, empleadoIdGenero:empleadoIdGenero, tipoPeriodo:tipoPeriodo,plantillaservicioreingreso:plantillaservicioreingreso,bancoreingreso:bancoreingreso,nocuentareingreso:nocuentareingreso,cunetaclabereingreso:cunetaclabereingreso,"avisoInscripcion0":avisoInscripcion0,"avisoInscripcion1":avisoInscripcion1,"avisoInscripcion2":avisoInscripcion2,"avisoInscripcion3":avisoInscripcion3,"valorchecklicenciaRE":licenciaRE,"numLicencia":numLicencia,"fechavigenciaLicencia":fechavigenciaLicencia,"AntiguedadVacacionesReingresoNo":AntiguedadVacacionesReingresoNo,"AntiguedadVacacionesReingresoSi":AntiguedadVacacionesReingresoSi,"contraseniaFirmReingreso":contraseniaFirmReingreso,"NumeroFirmReingreso":NumeroFirmReingreso,"plantillaservicioreingresoText":plantillaservicioreingresoText,"horarioReingreso":horarioReingreso,"gerenteReingreso":gerenteReingreso},
            dataType: "json",
            success: function(response) {
              var mensaje=response.message;
              if (response.status=="success") {  
                //if(BanderaReingreso=="1"){
                  GuardarHistoricoMovimientosSalarioDiarioImssEdicionRE(plantillaservicioreingreso) 
                //}

                GuardarMovimientoPlantillaHistorico("REINGRESO",horarioReingreso);
                obtenerFolioPreseleccionRE();
                aplicarReingreso(plantillaservicioreingresoText);
                solicitaReingresoImss();
                enviarPdfreingressooo();
                var alertMsg1="<div id='msgAlert' name='msgAlert' class='alert alert-success'><strong>Reingreso</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#alertMsg1R").html(alertMsg1);
                $(document).scrollTop(0);
                $('#msgAlert').delay(3000).fadeOut('slow');
                $('#myModalReingresoEmpleado').modal('hide');
                $('#myModalDpocReingreso').modal(); 
                consultaEmpleado(numeroEmpleado);
              } else if (response.status=="error")
              {
                var alertMsg1="<div id='msgAlert' name='msgAlert' class='alert alert-error'><strong>Reingreso:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    
                $("#alertMsg1R").html(alertMsg1);
                $(document).scrollTop(0);
                $('#msgAlert').delay(3000).fadeOut('slow');
              }
            },
            error: function(jqXHR, textStatus, errorThrown){
              alert(jqXHR.responseText);
            }
          });
        }
      }
    }

$("#selectPuestoModalR").change(function(){
  LimpiarDatosTabuladorSalarioDiarioReignreso();

  var puesto = $("#selectPuestoModalR").val();
  var entLaborar = $("#selectEntidadLaboralReingreso").val();
  var lineaNeg = $("#selectLineaNegocioModalR").val();

  if((puesto==6 || puesto==126 || puesto==93 || puesto==31 || puesto==144 || puesto==133 || puesto==44 || puesto==122 || puesto==117) && lineaNeg !="LiNEA NEGOCIO" && entLaborar!="ENTIDAD FEDERATIVA"){
          consultarGerentesParaReingreso(entLaborar,lineaNeg);
    }else{
        $('#gerenteRegReingreso').empty().append('<option value="0" selected="selected">GERENTE REGIONAL</option>');
  }


});


$("#selectEntidadLaboralReingreso").change(function(){

  var puesto = $("#selectPuestoModalR").val();
  var entLaborar = $("#selectEntidadLaboralReingreso").val();
  var lineaNeg = $("#selectLineaNegocioModalR").val();

  if((puesto==6 || puesto==126 || puesto==93 || puesto==31 || puesto==144 || puesto==133 || puesto==44 || puesto==122 || puesto==117) && lineaNeg !="LiNEA NEGOCIO" && entLaborar!="ENTIDAD FEDERATIVA"){
          consultarGerentesParaReingreso(entLaborar,lineaNeg);
    }else{
        $('#gerenteRegReingreso').empty().append('<option value="0" selected="selected">GERENTE REGIONAL</option>');
  }

});

function consultarGerentesParaReingreso(entLaborar,lineaNeg){
// alert("entre");
    $.ajax({
      type: "POST",
      url: "ajax_ConsultarGerentesReg.php",
      data: {entLaborar,lineaNeg},
      dataType: "json",
      success: function(response) {
        if (response.status == "success"){
           datos = response.datos;
          $('#gerenteRegReingreso').empty().append('<option value="0" selected="selected">GERENTE REGIONAL</option>');
          
          for ( var i = 0; i < datos.length; i++ ){
              $('#gerenteRegReingreso').append('<option value="' + datos[i].numeroEmpleado + '">' + datos[i].nombreEmpleado+'</option>'); 
          };

          if($('#gerenteRegReingreso option').length === 1){
            // de no quedar opciones disponibles en el selector de servicios (solo existiria la opción 0), limpio la lista y coloco una opcion 0 con un mensaje.
            $('#gerenteRegReingreso').empty().append('<option value="0" selected="selected">No hay gerentes en esta región actualmente.</option>');
          } 
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });       
  }

$("#idEndidadFederativaEdited").change(function(){
var puesto = $("#puestoEdited").val();
  var entLaborar = $("#idEndidadFederativaEdited").val();
  var lineaNeg = $("#selectLineaNegocioEdited").val();
  // alert(entLaborar);
  //   alert(lineaNeg);
  //   alert(idGerenteActual);

  if((puesto==6 || puesto==126 || puesto==93 || puesto==31 || puesto==144 || puesto==133 || puesto==44 || puesto==122 || puesto==117) && lineaNeg !="LiNEA NEGOCIO" && entLaborar!="ENTIDAD FEDERATIVA"){
          consultarGerentesRegXSup();
    }
});



$("#selectLineaNegocioModalR").change(function(){
  var LineaNegocioSD = $("#selectLineaNegocioModalR").val();
  $("#selectTipoPuestoReingreso").val("TIPO PUESTO");
  if(LineaNegocioSD=="1"){
    $("#divSlarioDiarioReingreso").show();
    $("#BanderaSalarioReingreso").val(1);
  }else{
    $("#divSlarioDiarioReingreso").hide();
    $("#BanderaSalarioReingreso").val(0);
  }

  var puesto = $("#selectPuestoModalR").val();
  var entLaborar = $("#selectEntidadLaboralReingreso").val();

  if((puesto==6 || puesto==126 || puesto==93 || puesto==31 || puesto==144 || puesto==133 || puesto==44 || puesto==122 || puesto==117) && LineaNegocioSD !="LiNEA NEGOCIO" && entLaborar!="ENTIDAD FEDERATIVA"){
          consultarGerentesParaReingreso(entLaborar,LineaNegocioSD);
    }else{
        $('#gerenteRegReingreso').empty().append('<option value="0" selected="selected">GERENTE REGIONAL</option>');
  }
});

$("#selectTipoPuestoReingreso").change(function(){
  var puesto = $("#selectPuestoModalR").val();
  var entLaborar = $("#selectEntidadLaboralReingreso").val();
  var lineaNeg = $("#selectLineaNegocioModalR").val();

  if((puesto==6 || puesto==126 || puesto==93 || puesto==31 || puesto==144 || puesto==133 || puesto==44 || puesto==122 || puesto==117) && lineaNeg !="LiNEA NEGOCIO" && entLaborar!="ENTIDAD FEDERATIVA"){
     consultarGerentesParaReingreso(entLaborar,lineaNeg);
  }else{
        $('#gerenteRegReingreso').empty().append('<option value="0" selected="selected">GERENTE REGIONAL</option>');
  }
});
/////////////////////////////////////// Validacion Firma Salario Diario Empleado ///////////////////////////////////

function GuardarHistoricoMovimientosSalarioDiarioImssEdicionRE(idPlantilla){

  var sueldo = $("#SueldoSalarioDiarioEmpReingreso").val();
  var salarioDiari = $("#SalarioDiarioEmpReingreso").val();
  var constrasenia = $("#constraseniaFirmaParaConfirmacionSalarioDiarioEmpleadoHiddenReingreso").val();
  var numeroAdmin = $("#NumEmpModalFirmaParaConfirmacionSalarioDiariohiddenReingreso").val();
  var numeroEmpleadoEntidad = $("#numeroEmpleadoEntidadEdited").val();
  var numeroEmpleadoConsecutivo = $("#numeroEmpleadoConsecutivoEdited").val();
  var numeroEmpleadoTipo = $("#numeroEmpleadoTipoEdited").val();
  var numeroEmpleado = numeroEmpleadoEntidad+"-"+numeroEmpleadoConsecutivo+"-"+numeroEmpleadoTipo;
  var origen = "3";// indicando que el origen es de edicion existe un catalogo llamado catalogoOrigenSalarioDiarioImss
  $.ajax({
    type: "POST",
    url: "ajax_RegistrarHistoricoMovSDImss.php",
    data: {"sueldo":sueldo,"salarioDiari":salarioDiari,"constrasenia":constrasenia,"numeroAdmin":numeroAdmin,"numeroEmpleado":numeroEmpleado,"origen":origen,"idPlantilla":idPlantilla},
    dataType: "json",
    async:false,
    success: function(response) {
      alert(response.status);
      if (response.status != "success")
      {
        alert(response.message);
      }else{
        //ActualizarDatosImssParaSalarioDiarioReingreso();
      }
    },error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
  });
}

function ActualizarDatosImssParaSalarioDiarioReingreso(){ ///AAAA
  var salarioDiari1 = $("#SalarioDiarioEmpReingreso").val();
  var numeroEmpleadoEntidad1 = $("#numeroEmpleadoEntidadEdited").val();
  var numeroEmpleadoConsecutivo1 = $("#numeroEmpleadoConsecutivoEdited").val();
  var numeroEmpleadoTipo1 = $("#numeroEmpleadoTipoEdited").val();
  var origen1 = "2";// indicando que el origen es de edicion existe un catalogo llamado catalogoOrigenSalarioDiarioImss
  var movimientoTXT = '1';
  $.ajax({
    type: "POST",
    url: "ajax_ActualizaDatosImssParaSalarioDiario.php",
    data: {"salarioDiari":salarioDiari1,"numeroEmpleadoEntidad":numeroEmpleadoEntidad1,"numeroEmpleadoConsecutivo":numeroEmpleadoConsecutivo1,"numeroEmpleadoTipo":numeroEmpleadoTipo1,"origen":origen1,"movimientoTXT":movimientoTXT},
    dataType: "json",
    async:false,
    success: function(response) {
      if (response.status != "success")
      {
        alert(response.message);
      }else{
        LimpiarDatosTabuladorSalarioDiarioReignreso();
      }
    },error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
  });
}

$('#btnGenrarSalarioDiarioReingreso').click(function(){
  var idtipoTurnoSD = $("#selectTurnoReingreso").val();
  var idPuestoSD = $("#selectPuestoModalR").val();
  var idPuntoServicioTabulador = $("#selectPuntoServicioModalR").val();
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
            $("#SueldoSalarioDiarioEmpReingreso").val(sueldo);
            var resta = sueldo- SueldoBaseDescuento;
            if(resta > 0){
              var MontoADescontar = sueldo*("."+PorcentajeDescuento);
              var  salarioDiario1 = sueldo-MontoADescontar; 
              var salarioDiario = salarioDiario1/30;
              $("#SalarioDiarioEmpReingreso").val(salarioDiario); 
            }else{
              $("#SalarioDiarioEmpReingreso").val(SalarioDiarioDescuento); 
            }
            var salarioDiarioBefore = $("#SalarioDiarioEmpReingreso").val(); 
            var salarioDiarioSplit =salarioDiarioBefore.split(".");
            var salarioDiariolength = salarioDiarioSplit.length;
            if(salarioDiariolength=="1"){$("#SalarioDiarioEmpReingreso").val(salarioDiarioBefore+".00");}
            if(salarioDiariolength=="2"){
              var decimal = salarioDiarioSplit[1];
              if(decimal.length == "1"){
                $("#SalarioDiarioEmpEdit").val(salarioDiarioBefore+"0");
              }
            }
            $("#btnConfirmadoSalarioDiarioReingreso").hide();
            $("#btnGenrarSalarioDiarioReingreso").hide();
            $("#btnConfirmarSalarioDiarioReingreso").show();
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

function LimpiarDatosTabuladorSalarioDiarioReignreso(){
  var tipoPuestoEdited = $("#selectTipoPuestoReingreso").val();
  var selLineaNegocioModalR = $("#selectLineaNegocioModalR").val();
  if(tipoPuestoEdited != "02" && selLineaNegocioModalR=="1"){
    $("#SalarioDiarioEmpReingreso").val("");
    $("#btnGenrarSalarioDiarioReingreso").show();
    $("#btnConfirmarSalarioDiarioReingreso").hide();
    $("#btnConfirmadoSalarioDiarioReingreso").hide();
    $("#imgMalSalarioDiarioReingreso").show();
    $("#imgBienSalarioDiarioReingreso").hide();
    $("#NumEmpModalFirmaParaConfirmacionSalarioDiarioReingreso").val("");
    $("#constraseniaFirmaParaConfirmacionSalarioDiarioEmpleadoReingreso").val("");
    $("#constraseniaFirmaParaConfirmacionSalarioDiarioEmpleadoHiddenReingreso").val("");
    $("#NumEmpModalFirmaParaConfirmacionSalarioDiariohiddenReingreso").val("");
    $("#BanderaSalarioReingreso").val(1);
  }else{$("#BanderaSalarioReingreso").val(0);}
}

$('#btnConfirmarSalarioDiarioReingreso').click(function(){
  $("#modalFirmaConfirmacionSalarioDiarioReingreso").modal();
  $("#myModalReingresoEmpleado").modal('hide');
});

function RevisarFirmaInternaParaConfirmacionSalarioDiarioReingreso(){
  var NumEmpModalBaja = $("#NumEmpModalFirmaParaConfirmacionSalarioDiarioReingreso").val();
  var constraseniaFirma = $("#constraseniaFirmaParaConfirmacionSalarioDiarioEmpleadoReingreso").val();
  if(NumEmpModalBaja==""){
    cargaerroresFirmaInternaParaCOnfirmaciosDeSDReingreso("El numero de empleado no puede estar vacio");
  }else if(constraseniaFirma==""){
    cargaerroresFirmaInternaParaCOnfirmaciosDeSDReingreso("Escriba la contraseña para continuar");
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
            cargaerroresFirmaInternaParaCOnfirmaciosDeSDReingreso("La Contraseña ingresada es incorrecta favor de escribirla exactamente como la ingreso en el registro");
          }else{
            var contraseniaInsertadaCifrada =response.datos["0"].ContraseniaFirma;
            $("#constraseniaFirmaParaConfirmacionSalarioDiarioEmpleadoHiddenReingreso").val(contraseniaInsertadaCifrada);
            $("#NumEmpModalFirmaParaConfirmacionSalarioDiariohiddenReingreso").val(NumEmpModalBaja);
            $("#modalFirmaConfirmacionSalarioDiarioReingreso").modal("hide");
            $("#myModalReingresoEmpleado").modal();
            $("#NumEmpModalFirmaParaConfirmacionSalarioDiarioReingreso").val("");
            $("#constraseniaFirmaParaConfirmacionSalarioDiarioEmpleadoReingreso").val("");
            $("#imgMalSalarioDiarioReingreso").hide();
            $("#imgBienSalarioDiarioReingreso").show();
            $("#btnConfirmadoSalarioDiarioReingreso").show();
            $("#btnConfirmarSalarioDiarioReingreso").hide();
          }
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
    });
  }
}
function cargaerroresFirmaInternaParaCOnfirmaciosDeSDReingreso(mensaje){
  $('#errormodalConfirmacionSalarioDiarioReingreso').fadeIn();
  msjerrorbaja="<div id='errormodalConfirmacionSalarioDiario1Reingreso' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errormodalConfirmacionSalarioDiarioReingreso").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errormodalConfirmacionSalarioDiarioReingreso').delay(4000).fadeOut('slow'); 
}

function cancelarFirmaParaConfirmacionSalarioDiarioReingreso(){

  $("#modalFirmaConfirmacionSalarioDiarioReingreso").modal("hide");
  $("#NumEmpModalFirmaParaConfirmacionSalarioDiarioReingreso").val("");
  $("#constraseniaFirmaParaConfirmacionSalarioDiarioEmpleadoReingreso").val("");
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////






   function limpiarModalReingreso(){
    $("#txtFechaIngresoModalR").val("");
    $("#selectEntidadLaboralReingreso").val("ENTIDAD FEDERATIVA");
    $("#selectLineaNegocioModalR").val("LiNEA NEGOCIO");
    $("#selectTipoPuestoReingreso").val("TIPO PUESTO");
    $("#selectPuestoModalR").val("PUESTO");
    $("#idDepartamentoPuestoReingreso").val("");
    $("#selectTurnoReingreso").val("TURNO");
    $("#selectSupervisorModalR").val("RESPONSABLE ASISTENCIA");
    $("#selectPuntoServicioModalR").val("PUNTOS SERVICIOS");
    $("#selectPeriodoReingreso").val("PERIODO");
    $('#gerenteRegReingreso').empty().append('<option value="0" selected="selected">GERENTE REGIONAL</option>');
  }




  $('#txtSearchName').keypress(function(event){  
   var keycode = (event.keyCode ? event.keyCode : event.which);  
   if(keycode == '13'){  
           //alert('Se ha presionado Enter!');  
           consultaEmpleadoPorNombre();
           $("#txtSearch").val("");
         }   
       }); 


  function selectMotivosBajaPorTipoBaja()
  {

   var idTipoBaja = $("#selectTipoBaja").val();
   $.ajax({
    type: "POST",
    url: "ajax_obtenerMotivosBajaPorTipoBaja.php",
    data: {"idTipoBaja": idTipoBaja},
    dataType: "json",
    success: function(response) {
      if (response.status == "success")
      {

        var listaMotivos = response.motivosBaja;

        motivosOptions = "<option>MOTIVO BAJA</option>";
        for (var i = 0; i < listaMotivos.length; i++)
        {
          motivosOptions += "<option value='" + listaMotivos[i].idcatalogoMotivosBaja + "'>"+listaMotivos[i].descripcionMotivoBaja+ "</option>";
        }

        $("#selectMotivoBaja").html (motivosOptions);
                   // $("#selectMotivoBaja").val(idClaveMovimiento);
                 }
               },
               error: function (response)
               {
                console.log (response);
              }
            });
 }

 function solicitaBajaImss(){

  var numeroEmpleado=$("#txtNumeroEmpleadoModal").val();
  var empleadoEstatusImss="5";
  var idMotivoBajaImss="2";
  var fechaBajaImss=$("#txtFechaBajaModal").val();

  $.ajax({
    type: "POST",
    url: "ajax_registraBajaImss.php",
    data: {"numeroEmpleado":numeroEmpleado,"idMotivoBajaImss":idMotivoBajaImss,"empleadoEstatusImss":empleadoEstatusImss,"fechaBajaImss":fechaBajaImss },
    dataType: "json",
    async: false,
    success: function(response) {
      var mensaje=response.message;

      if (response.status=="success") {
                    //alert("si lo hizo");

                  } else if (response.status=="error")
                  {
                    alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error al reingresar:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#alertMsg1").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(3000).fadeOut('slow');

                    
                  }
                },
                error: function(){
                  alert('error handing here');
                }
              });

}

function checarPlantilla(){
  var puesto =$("#puestoEdited").val();
  var tipoTurno=$("#tipoTurnoEdited").val();
  var sexo=$( "input:radio[name=generoEdited]:checked" ).val();
  var puntoServicio=$("#selectPuntoServicioEdited").val();

        // alert("puesto: "+puesto+" tipoTurno:"+tipoTurno+" Sexo:"+sexo+" puntoServiio"+puntoServicio);
        $.ajax({
          type: "POST",
          url: "ajax_actualizaDatosGeneralesPlantilla.php",
          data:{"puesto":puesto,"tipoTurno":tipoTurno, "sexo":sexo,"puntoServicio":puntoServicio,"action":"consultar"},
          dataType: "json",
          async: false,
          success: function(response) {
            if (response.status == "success")
            {
              var continuar = confirm (response.message);

              if (continuar)
              {
                alert("Continua");
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

      function limpiarCanvas()
      {
        sketch_firma = null;
        $("#sketch_div").html ();

        $("#sketch_div").html ('<p>Dibuje firma del elemento…</p><canvas id="tools_sketch" class="divTrFirma" width="900" height="350" ><td></canvas>');


        sketch_firma = $('#tools_sketch').sketch();
      }

      function obtenerClienteByPuntoServicioIdEdited()
      {

       var idPuntoServicio = $("#selectPuntoServicioEdited").val();
       //var tipo = $("#numeroEmpleadoTipo").val();
       $("#tipoTurnoEdited").val("TURNO");  
       $("#selplantillaserv").val("PLANTILLA"); 

       $.ajax({
        type: "POST",
        url: "ajax_obtenerClienteByPuntoServicio.php",
        data: {"idPuntoServicio":idPuntoServicio},
        dataType: "json",
        success: function(response) {
          if (response.status == "success")
          {
            var clienteId = response.lista[0].idClientePunto;
            $("#txtClienteIdEdited").val(clienteId);
            // alert(clienteId);

          }
        },
        error: function (response)
        {
          console.log (response);
        }
      });

     }

     function saveImage(){

      var empleadoEntidad=$("#numeroEmpleadoEntidadEdited").val();
      var empleadoConsecutivo=$("#numeroEmpleadoConsecutivoEdited").val();
      var empleadoTipo=$("#numeroEmpleadoTipoEdited").val();

      var canvas = document.getElementById("tools_sketch");
      canvasData = canvas.toDataURL("image/png");

        // alert("puesto: "+puesto+" tipoTurno:"+tipoTurno+" Sexo:"+sexo+" puntoServiio"+puntoServicio);

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

                    alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Firma</strong>Firma guardada<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#divFirmaMsg").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                    $('#modalFirma').modal('hide');
                    //$("#modalFirma").hide();
                    //$("modalFirma").

                    limpiarCanvas();

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
      function getMediosInformacionVacanteEdited(id){        
        $.ajax({
          type: "POST",
          url: "ajax_getMediosInformacionVacante.php",
          dataType: "json",
          success: function(response) {
            if (response.status == "success")

            {

              var listaMediosInformacionVacante = response.mediosInformacion;
              var mediosInformacionOptionsEdited="<select id='selectMedioInformacionEdited' name='selectMedioInformacionEdited'>";
              mediosInformacionOptionsEdited += "<option>MEDIO INFORMACIÓN</option>";

              for ( var i = 0; i < listaMediosInformacionVacante.length; i++ ){
                mediosInformacionOptionsEdited += "<option value='"+ listaMediosInformacionVacante[i].idMedio+"'";

                if(listaMediosInformacionVacante[i].idMedio==id){
                  mediosInformacionOptionsEdited += " selected='selected' ";
                }

                mediosInformacionOptionsEdited+=">"+listaMediosInformacionVacante[i].nombreMedio+"</option>";
              }
              mediosInformacionOptionsEdited += "</select>";

              $("#divLblMedioEdited").html("<label class='control-label2 label' for='medioEdited'>¿Comó se entero de GIF?</label>");
              $("#divMedioInformacionEdited").html (mediosInformacionOptionsEdited);


              $("#selectMedioInformacionEdited").prop("disabled", false);
            }
            console.log (response);
          },
          error: function (response)
          {
            alert("Error INFORMACION");
          }
        });

      }

      function getReclutadoresSeguridadFisicaEdited(id){
        var ban=0;
        $.ajax({
          type: "POST",
          url: "ajax_getReclutadoresSeguridadFisica.php",
          dataType: "json",
          success: function(response) {
            if (response.status == "success")

            {

              var listaReclutadores = response.reclutadores;
              var reclutadoresOptions="<select name='selectReclutadorEdited' id='selectReclutadorEdited' onChange='optionReclutadorEdited();'><option>RECLUTADOR</option>";

              for ( var i = 0; i < listaReclutadores.length; i++ ){
                reclutadoresOptions += "<option value='" + listaReclutadores[i].reclutadorId + "'";

                if(listaReclutadores[i].reclutadorId==id){
                  reclutadoresOptions += " selected='selected' ";
                  ban=1;
                }
                reclutadoresOptions +=">" + listaReclutadores[i].nombre + "</option>";
              }                  
              if(ban==0)
                reclutadoresOptions+=getReclutadoresSup(id);
              reclutadoresOptions += "<option>OTRO</option></select>";
              $("#divReclutadorEdited").html (reclutadoresOptions);
              $("#divLblReclutadorEdited").html("<label class='control-label2 label' for='medio'>Reclutador</label>");
                  //$("#selectReclutadorEdited").prop("disabled", true );
                  
                }
                console.log (response);
              },
              error: function (response)
              {
                console.log (response);
              }
            });

      }

      function optionReclutadorEdited(){
        var lineaNegocio=$("#selectLineaNegocioEdited").val();
        var tipoEmpleado=$("#tipoPuestoEdited").val();
        var selectReclutadorEdited=$("#selectReclutadorEdited").val();
        if(selectReclutadorEdited=="OTRO"){

          $("#divReclutadorEdited").html("");
          $("#divLblReclutadorEdited").html("");
          getMediosInformacionVacanteEdited();


        }else if(lineaNegocio==1 && tipoEmpleado=='03'){

          $("#divMedioInformacionEdited").html("");
          $("#divLblMedioEdited").html("");
          //getReclutadoresSeguridadFisicaEdited();


        }else if( (lineaNegocio==1 || lineaNegocio==2 ) && tipoEmpleado=='02'){

          $("#divReclutadorEdited").html("");
          $("#divLblReclutadorEdited").html("");
          getMediosInformacionVacanteEdited();

        }else if( (lineaNegocio==1 || lineaNegocio==2 ) && tipoEmpleado=='03'){

          $("#divReclutadorEdited").html("");
          $("#divLblReclutadorEdited").html("");
          getMediosInformacionVacanteEdited();

        }
      }

      function generarContratosTodos(){
        var numEmpleadosGenerador=$("#txtSearch").val();
        //var txtSearch = $("#txtSearch").val ();
        var expregContratos = /^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/;
        var expregContratos1 = /^[0-9]{2}\-[0-9]{5}\-[0-9]{2}/;
        if (numEmpleadosGenerador.length != 10 && numEmpleadosGenerador.length != 11)
        {
          swal("Alto","Ingrese el numero de empleado para obteer el contrato","error");
        }
        if(expregContratos.test(numEmpleadosGenerador) || expregContratos1.test(numEmpleadosGenerador))
        {
          generarContratoSa1Edited();
          generarContratoSa2Edited();         
          generarContratoScEdited();
        }
        
      }

      function getReclutadoresSup(id){
        var reclutadoresOptions="";      
        $.ajax({
          type: "POST",
          url: "ajax_obtenerListaSupervisoresOperativos.php",
          async: false,
          dataType: "json",
          success: function(response) {
            if (response.status == "success")
            {
              var listaSupervisores = response.listaSupervisoresOperativos;                                      
              for ( var i = 0; i < listaSupervisores.length; i++ ){
                reclutadoresOptions += "<option value='" + listaSupervisores[i].supervisorId + "'" ;

                if(listaSupervisores[i].supervisorId==id){
                  reclutadoresOptions += " selected='selected' ";                      
                }

                reclutadoresOptions+=">" + listaSupervisores[i].nombre + "</option>";
              }                    

            }
          },
          error: function (response)
          {
            alert("Error");
          }
        });

        //alert(reclutadoresOptions);
        return reclutadoresOptions;
      }

      var sketch_firma;


      $(function() {
        sketch_firma = $('#tools_sketch').sketch();
      });



      $( "#txtNumeroCtaEdited" ).click(function() {
        if(cambio==0){
          cambio=1;
          var sel="<select id='selBancoEdit' name='selBancoEdit'><option value='0' selected='selected'>BANCO</option>"; 
          $.ajax({
            async: false,
            type: "POST",
            url: "ajax_getBancos.php",
            dataType: "json",
            success: function(response) {
              $('#divSelBanco').append('');
              if (response.status == "success")
              {
                for (var i = 0; i < response.bancos.length; i++)
                {
                 sel+='<option value="' + (response.bancos[i].idCuentaBanco) + '">' + response.bancos[i].nombreBanco + '</option>';
               }

               $("#hiddebanderaselbanco").val(1);

             }else{
              alert("Error al cargar bancos");
            }
          },
          error: function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText);
          }
        });
          sel+="</select>";
          $("#divSelBanco").html(sel);  
          $("#divLblBanco").html("<label class='control-label2 label' for='selBancoEdit'>Banco</label>");   
        }
    //alert('El select');
  });




      
</script>

<script language="javascript">
  $(document).ready(function() {

     jQuery("#checkMadreE1").prop('checked',false);
     jQuery("#checkPadreE").prop('checked',false);
     jQuery("#checkBeneficiarioE").prop('checked',false);


     bloquearDatosGenerales();
     bloquearDatosPersonales();
     bloquearDatosGeneralesDirectorio();

     <?php
     if ($usuario["rol"] =="Administrador" || $usuario["rol"] =="Contrataciones" || $usuario["rol"] =="Lider Unidad" || $usuario["rol"] =="Laborales")
     {
      ?>


      $("#divFirma").html("<button id='btnFirma' name='btnFirma' class='btn btn-primary' type='button' onClick='mostrarModalFirma();'> <span class='glyphicon glyphicon-pencil'></span>Firma</button>");

      <?php
    }
    ?>

    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    });


//$("#txtFechaIngresoModalR").val(currentDate);
//$("#txtFechaBajaModal").val(currentDate);



});

  $("#tipoTurnoEdited").change(function(){
    $('#selHorarioCons').empty();
    var puestoPlantillaId  = $("#puestoEdited").val();
    var tipoTurnoPlantillaId=$("#tipoTurnoEdited").val();
    var puntoServicioPlantillaId=$("#selectPuntoServicioEdited").val();
    var txtClienteIdEdited = $("#txtClienteIdEdited").val();
    var tipoPuesto =  $("#tipoPuestoEdited").val();
    LimpiarDatosTabuladorSalarioDiarioEdit();
    if(tipoTurnoPlantillaId==="TURNO" ){$("#selplantillaserv").empty();}
    if((tipoTurnoPlantillaId==4) && tipoPuesto=="02"){
        $.ajax({
        type: "POST",
        url: "ajax_ObtenerPlantillaParaAdmin.php",
        data: {"tipoTurnoPlantillaId":tipoTurnoPlantillaId,"puntoServicioPlantillaId":puntoServicioPlantillaId,"puestoPlantillaId":puestoPlantillaId},
        dataType: "json",
        success: function(response) {
          datos = response.datos;
          $('#selplantillaserv').empty().append('<option value="0" selected="selected">PLANTILLA</option>');
          $.each(datos, function(i) {
          $('#selplantillaserv').append('<option value="' + response.datos[i].servicioPlantillaId + '">' + response.datos[i].DescripcioRolOP + '_' + response.datos[i].servicioPlantillaId +'</option>'); //verificar que rollo con esto
          });
          if($('#selplantillaserv option').length ===1 ){
            // de no quedar opciones disponibles en el selector de servicios (solo existiria la opción 0), limpio la lista y coloco una opcion 0 con un mensaje.
              $('#selplantillaserv').empty().append('<option value="0" selected="selected">No hay plantilla disponible.</option>');
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
        }
      });

    }else{
     // alert(puestoPlantillaId+"->"+tipoTurnoPlantillaId+"->"+puntoServicioPlantillaId);
      $.ajax({
        type: "POST",
        url: "ajax_consultaplantillasparaselectorcontrataciones.php",
        data: {"puestoPlantillaId":puestoPlantillaId,"tipoTurnoPlantillaId":tipoTurnoPlantillaId,"puntoServicioPlantillaId":puntoServicioPlantillaId},
        dataType: "json",
        success: function(response) {
          datos = response.datos;
          $('#selplantillaserv').empty().append('<option value="0" selected="selected">PLANTILLA</option>');
          $.each(datos, function(i) {
            $('#selplantillaserv').append('<option value="' + response.datos[i].servicioPlantillaId + '">' + response.datos[i].DescripcioRolOP + '_' + response.datos[i].servicioPlantillaId +'</option>'); //verificar que rollo con esto
          });
          if($('#selplantillaserv option').length ===1 ){
            // de no quedar opciones disponibles en el selector de servicios (solo existiria la opción 0), limpio la lista y coloco una opcion 0 con un mensaje.
              $('#selplantillaserv').empty().append('<option value="0" selected="selected">No hay plantilla disponible.</option>');
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
        }
      });
   }
  });
$("#puestoEdited").change(function(){
  //($("#selplantillaservicio").empty();
  $("#selplantillaserv").val("PLANTILLA");
  $("#tipoTurnoEdited").val("TURNO");
  LimpiarDatosTabuladorSalarioDiarioEdit();

  var lineaNeg = $("#selectLineaNegocioEdited").val();
  var entLaborar = $("#idEndidadFederativaEdited").val();
  var puesto = $("#puestoEdited").val();

  if(puesto!=6 && puesto!=126 && puesto!=93 && puesto!=31 && puesto!=144 && puesto!=133 && puesto!=44 && puesto!=122 && puesto!=117){
    $('#gerenteRegEdited').empty().append('<option value="0" selected="selected">GERENTE REGIONAL</option>');
  }

  if((puesto==6 || puesto==126 || puesto==93 || puesto==31 || puesto==144 || puesto==133 || puesto==44 || puesto==122 || puesto==117) && lineaNeg !="LiNEA NEGOCIO" && entLaborar!="ENTIDAD FEDERATIVA"){
        cargarSelectorGerenteRegionalEdited(entLaborar,lineaNeg);
  }
}); 

function cargarSelectorGerenteRegionalEdited(entLaborar,lineaNeg){
  $.ajax({
        type: "POST",
        url: "ajax_ConsultarGerentesReg.php",
        data: {entLaborar,lineaNeg},
        dataType: "json",
        success: function(response) {
          datos = response.datos;
          $('#gerenteRegEdited').empty().append('<option value="0" selected="selected">GERENTE REGIONAL</option>');
          
          $.each(datos, function(i) {
            $('#gerenteRegEdited').append('<option value="' + datos[i].numeroEmpleado + '">' + datos[i].nombreEmpleado+'</option>'); //verificar que rollo con esto
          });

          if($('#gerenteRegEdited option').length === 1){
            // de no quedar opciones disponibles en el selector de servicios (solo existiria la opción 0), limpio la lista y coloco una opcion 0 con un mensaje.
            $('#gerenteRegEdited').empty().append('<option value="0" selected="selected">No hay gerentes en esta región actualmente.</option>');
          }                
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
        }
      });
}





$("#selplantillaserv").change(function(){
    var PlantillaIdRol=$("#selplantillaserv").val();
    $.ajax({
      type: "POST",
      url: "ajax_ObtenerIdRolOperativoPorPlantilla.php",
      data: {"PlantillaIdRol":PlantillaIdRol},
      dataType: "json",
      success: function(response) {
        if(response.status=="success"){
          $("#idRolOpertaivoPorPlantilla").val(response.datos[0].IdRolOperativoPlantilla);
        }else{
          alert("Error al obtener Rol operativo por plantilla");
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
    });
    // obtenemos los horarios de la plantilla

    obtenerHorariosPorPlantillaEdicion(PlantillaIdRol,11,0);
    /////////////////////////////////////////
 });

  $("#puestoEdited").change(function(){
//($("#selplantillaservicio").empty();
$("#selplantillaserv").val("PLANTILLA");
$("#tipoTurnoEdited").val("TURNO");
});  







  $('#selectBancoReingreso').change(function(){
    $("#inpNoCuentaReingreso").val("");
    $("#inpNoCuentaClabeReingreso").val("").attr("maxlength","18");
    var banco=$("#selectBancoReingreso").val();
    if(banco=='030'){
      $("#inpNoCuentaReingreso").attr("maxlength","12");
    }else if(banco=='012' || banco=='021'){
      $("#inpNoCuentaReingreso").attr("maxlength","10");
    }else if(banco=='014'){
      $("#inpNoCuentaReingreso").attr("maxlength","11");
    }else{
      $("#inpNoCuentaReingreso").attr("maxlength","14");
    }
  });


  function validaNumericos(event) {
    if(event.charCode >= 48 && event.charCode <= 57){
      return true;
    }
    return false;        
  }


///TENER EN CUENTA PARA REINGRESO INGRESAR EL ROLOPERATIVO QUE SE INSERTARA EN LAS TABALS DE EMPLEADOS Y INCIDENCIAS ESPECIALES Y ASISTENCIAS E INCIDENCIAS

$("#selectTurnoReingreso").change(function(){ 
  $("#selHorarioReingreso").empty();
  LimpiarDatosTabuladorSalarioDiarioReignreso();
  var puestoPlantillaId  = $("#selectPuestoModalR").val();
  var tipoTurnoPlantillaId=$("#selectTurnoReingreso").val();
  var puntoServicioPlantillaId=$("#selectPuntoServicioModalR").val();
  var tipoPuesto =  $("#selectTipoPuestoReingreso").val(); 
  if(tipoTurnoPlantillaId==="TURNO" ){$("#selplantillaservicioreingreso").empty();}
  if(tipoTurnoPlantillaId==4 && tipoPuesto=="02"){
    $.ajax({
        type: "POST",
        url: "ajax_ObtenerPlantillaParaAdmin.php",
        data: {"tipoTurnoPlantillaId":tipoTurnoPlantillaId,"puntoServicioPlantillaId":puntoServicioPlantillaId,"puestoPlantillaId":puestoPlantillaId},
        dataType: "json",
        success: function(response) {
          datos = response.datos;
          
          $('#selplantillaservicioreingreso').empty().append('<option value="0" selected="selected">PLANTILLA</option>');
          $.each(datos, function(i) {
            $('#selplantillaservicioreingreso').append('<option value="' + response.datos[i].servicioPlantillaId + '">' + response.datos[i].DescripcioRolOP + '_' + response.datos[i].servicioPlantillaId +'</option>'); //verificar que rollo con esto
          });
          if($('#selplantillaservicioreingreso option').length ===1 ){
            // de no quedar opciones disponibles en el selector de servicios (solo existiria la opción 0), limpio la lista y coloco una opcion 0 con un mensaje.
              $('#selplantillaservicioreingreso').empty().append('<option value="0" selected="selected">No hay plantilla disponible.</option>');
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
        $('#selplantillaservicioreingreso').empty().append('<option value="0" selected="selected">PLANTILLA</option>');
        $.each(datos, function(i) {
          $('#selplantillaservicioreingreso').append('<option value="' + response.datos[i].servicioPlantillaId + '">' + response.datos[i].DescripcioRolOP + '_' + response.datos[i].servicioPlantillaId +'</option>'); //verificar que rollo con esto
        });
        if($('#selplantillaservicioreingreso option').length ===1 ){
          // de no quedar opciones disponibles en el selector de servicios (solo existiria la opción 0), limpio la lista y coloco una opcion 0 con un mensaje.
          $('#selplantillaservicioreingreso').empty().append('<option value="0" selected="selected">No hay plantilla disponible.</option>');
        }
      },error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      } 
    });
  }
});

$("#selectPuntoServicioModalR").change(function(){
  $("#selectTurnoReingreso").val("TURNO");
  $("#selplantillaservicioreingreso").empty();
  LimpiarDatosTabuladorSalarioDiarioReignreso();
});  
$("#selectPeriodoReingreso").change(function(){
  $.ajax({
    async: false,
    type: "POST",
    url: "ajax_getBancos.php",
    dataType: "json",
    success: function(response) {

     var datos=response.bancos;
     $('#selectBancoReingreso').empty().append('<option value="0" selected="selected">BANCO</option>');
     $.each(datos, function(i) {
                         $('#selectBancoReingreso').append('<option value="' + datos[i].idCuentaBanco + '">' + datos[i].nombreBanco + '</option>'); //verificar que rollo con esto
                       });
   },
   error: function(jqXHR, textStatus, errorThrown){
    alert(jqXHR.responseText);
  }
});
});




function enviarPdfreingressooo() {
  var formData = new FormData($("#form_EditaEmpleado")[0]);
  for (var value of formData.values()) {}
    $.ajax({
      type: "POST",
      url: "uploadarchivosreingresoelemento.php",
      data: formData,
      dataType: "json",
      cache: false,
      contentType: false,
      processData: false,
      async:false,
      success: function(response) {
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
    });
}

$("#selectLineaNegocioEdited").change(function(){

  $("#selplantillaserv ").empty();


  $("#tipoTurnoEdited").val("TURNO");
});


$("#tipoPuestoEdited").change(function(){
  var tipoEmpleado1 = $("#tipoPuestoEdited").val(); 
  $("#selplantillaserv ").empty();
  $("#tipoTurnoEdited").val("TURNO");
  var seltLineaNegocioEdited = $("#selectLineaNegocioEdited").val();
  $('#gerenteRegEdited').empty().append('<option value="0" selected="selected">GERENTE REGIONAL</option>');
  if(tipoEmpleado1=="03" && seltLineaNegocioEdited == "1"){
    $("#trSalarioDiario").show();
  }else{
    $("#trSalarioDiario").hide();
  }
});





function funcionmostrarFormSolicitudEmpleo(foliopreseleccion){
 $("#modalReingresoSolicituEmpleo").modal();
//alert("el folio de preseleccion es: "+foliopreseleccion);
if(foliopreseleccion=='null' || foliopreseleccion==""){
  //alert("Por favor completa la siguiente información para poder reingresar al empleado");
  var mmsssjjjreingressso="Por favor completa la siguiente información.";
  alertMsgre="<div id='msgAlert1' class='alert alert-warning'><strong>Aviso: </strong> "+mmsssjjjreingressso+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#alertMsg1RE").html(alertMsgre);
  $(document).scrollTop(0);
  $('#msgAlert1').delay(8000).fadeOut('slow');

}else{
//alert("traer informacion del empleado en tbl preseleccion"); datosEmpleado
$.ajax({
  async : false,
  type: "POST",
  url: "ajax_obtenerFolioPrecontraReingresoEmpleado.php",
  data:{"curp":0,"numafiliacionimss":0,"folioPreseleccion":foliopreseleccion,},
  dataType: "json",
  success: function(response) {
               //console.log("datosre"); 
             //  console.log(response); 
             $("#empPuestoRE").val(response.datosAspitante[0].puestoPreseleccion);
             $("#empApPaternoRE").val(response.datosAspitante[0].apPaternoPreseleccion);
             $("#empApMaternoRE").val(response.datosAspitante[0].apMaternoPreseleccion);
             $("#empNombreRE").val(response.datosAspitante[0].nombrePreseleccion);
             $("#empEdadRE").val(response.datosAspitante[0].edadPreseleccion);
             $("#empPesoRE").val(response.datosAspitante[0].pesoPreseleccion);
             $("#empEstaturaRE").val(response.datosAspitante[0].estaturaPreseleccion);
             $("#empTallaCamisaRE").val(response.datosAspitante[0].tallaCamisaPreseleccion);
             $("#empTallaPantalonRE").val(response.datosAspitante[0].tallaPantalonPreseleccion);
             $("#empNumCalzadoRE").val(response.datosAspitante[0].numCalzadoPreseleccion);
                //$("#selectEmpCivilRE option:contains("+response.datosAspitante[0].edoCivil+")").attr('selected', true);
                //$("#selectEmpSexoRE option:contains("+response.datosAspitante[0].generoPreseleccion+")").attr('selected', true);
                $("#selectEmpCivilRE").val(response.datosAspitante[0].edoCivilPreseleccion);
                $("#selectEmpSexoRE").val(response.datosAspitante[0].generoPreseleccion);
                $("#selectEmpTipoSangreRE").val(response.datosAspitante[0].tipoSangrePreseleccion);
                //$("#selectEmpTipoSangreRE option:contains("+response.datosAspitante[0].tipoSangre+")").attr('selected', true);
                $("#empFechaNacRE").val(response.datosAspitante[0].fechaNacPreseleccion);
                $("#selectEmpEntidadRE").val(response.datosAspitante[0].entidadNacPreseleccion);
                //$("#selectEmpEntidadRE option:contains("+response.datosAspitante[0].entidadPre+")").attr('selected', true);
                $("#empCodPostalRE").val(response.datosAspitante[0].cpPreseleccion);
                $("#empCalleRE").val(response.datosAspitante[0].callePreseleccion);
                $("#empNumeroCRE").val(response.datosAspitante[0].numeroPreseleccion);
                $("#empColoniaRE").val(response.datosAspitante[0].coloniaPreseleccion);
                $("#empMunicipioRE").val(response.datosAspitante[0].municipioPreseleccion);
                $("#empCiudadRE").val(response.datosAspitante[0].ciudadPreseleccion);
                $("#empTelFijoRE").val(response.datosAspitante[0].telFijoPreseleccion);
                $("#empTelMovilRE").val(response.datosAspitante[0].telMovilPreseleccion);
                $("#empEmailRE").val(response.datosAspitante[0].emailPreseleccion);
                if(response.datosAspitante[0].infonavitPreseleccion==1){$("#checkEmpInfonavitRE").prop('checked','cheked');}
                if(response.datosAspitante[0].fonacotPreseleccion==1){$("#checkEmpFonacotRE").prop('checked','cheked');}
                if(response.datosAspitante[0].cartillaPreseleccion==1){$("#checkEmpCartillaRE").prop('checked','cheked');}
                if(response.datosAspitante[0].licenciaPreseleccion==1){
                  //alert(response.datosAspitante[0].licenciapermanente);
                  if(response.datosAspitante[0].licenciapermanente==1){
                    $("#checkEmpLicenciaPermanenteRE").prop('checked','cheked');
                    $("#fechaLicenciaRE").val("");
                    $("#tdfechalicenciaRE").hide(); 

                  }
                  if(response.datosAspitante[0].licenciapermanente==0){
                   $("#checkEmpLicenciaPermanenteRE").prop('checked','');
                   $("#fechaLicenciaRE").val(response.datosAspitante[0].fechavigencialicencia);
                   $("#tdfechalicenciaRE").show();

                 }
                 $("#checkEmpLicenciaRE").prop('checked','cheked'); 
                 $("#numLicenciaRE").val(response.datosAspitante[0].numlicenciapreseleccion);
                 $("#tdnumlicenciaRE").show(); 
                 $("#tdnumlicenciaprecontratapermanenteRE").show();

                 licenciaRE =1;
               }else{ $("#numLicenciaRE").val("");
               $("#tdnumlicenciaRE").hide();
               $("#fechaLicenciaRE").val("");
               $("#tdfechalicenciaRE").hide(); 
               licenciaRE =0;
             }
             $("#empImssRE").val(response.datosAspitante[0].nImssPreseleccion);
             $("#empNombreUERE").val(response.datosAspitante[0].nombreE1Preseleccion);
             $("#empFecha1E1RE").val(response.datosAspitante[0].fecha1E1Preseleccion);
             $("#empFecha2E1RE").val(response.datosAspitante[0].fecha2E1Preseleccion);
             $("#empTelE1RE").val(response.datosAspitante[0].telefonoE1Preseleccion);
             $("#empCausaSepE1RE").val(response.datosAspitante[0].causaE1Preseleccion);
             $("#empNombreEARE").val(response.datosAspitante[0].nombreE2Preseleccion);
             $("#empFecha1E2RE").val(response.datosAspitante[0].fecha1E2Preseleccion);
             $("#empFecha2E2RE").val(response.datosAspitante[0].fecha2E2Preseleccion);
             $("#empTelE2RE").val(response.datosAspitante[0].telefonoE2Preseleccion);
             $("#empCausaSepE2RE").val(response.datosAspitante[0].causaE2Preseleccion);
             if(response.datosAspitante[0].personasACargoPreseleccion==1){$("#checkEmpPersonasRE").prop('checked','cheked');}
             $("#selectEmpEstudioRE").val(response.datosAspitante[0].gradoEPreseleccion);
             $("#empCursoEspecialRE").val(response.datosAspitante[0].cursoEspecialPreseleccion);
             $("#empEnfermedadRE").val(response.datosAspitante[0].enfermedadPreseleccion);
             $("#empPadreRE").val(response.datosAspitante[0].padrePreseleccion);
             $("#empMadreRE").val(response.datosAspitante[0].madrePreseleccion);
             $("#empEsposaRE").val(response.datosAspitante[0].esposaPreseleccion);
             $("#empHijo1RE").val(response.datosAspitante[0].ben1Preseleccion);
             $("#empHijo2RE").val(response.datosAspitante[0].ben2Preseleccion);
             $("#empHijo3RE").val(response.datosAspitante[0].ben3Preseleccion);
             $("#empHijo4RE").val(response.datosAspitante[0].ben4Preseleccion);
             $("#empHijo5RE").val(response.datosAspitante[0].ben5Preseleccion);
             $("#empNombreR1RE").val(response.datosAspitante[0].nombreR1Preseleccion);
             $("#empTelR1RE").val(response.datosAspitante[0].telefonoR1);
             $("#empNombreR2RE").val(response.datosAspitante[0].nombreR2);
             $("#empTelR2RE").val(response.datosAspitante[0].telefonoR2);
           },
           error: function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText);

          }
        });

}
// $('#myModalReingresoEmpleado').modal();

}

function guardarSolicitudReingresoEmpleado(){

  if ($("#empPuestoRE").val() == "") {
   pintaerrorvalidacion("Proporcione el puesto que solicita");

 }

 else if ( $("#empApPaternoRE").val() == "") {
  pintaerrorvalidacion("Proporcione el apellido paterno del aspirante");
}

else if ($("#empApMaternoRE").val() == "") {
 pintaerrorvalidacion("Proporcione el apellido materno del aspirante");
}

else if ($("#empNombreRE").val() == "") {
  pintaerrorvalidacion("Proporcione el nombre del aspirante");
}

else if ($("#empEdadRE").val() == "") {
  pintaerrorvalidacion("Proporcione la edad del aspirante");
} else if (isNaN($("#empEdadRE").val())) {
  pintaerrorvalidacion("Edad del aspirante inválida");
}

else if ($("#empPesoRE").val() == "") {
  pintaerrorvalidacion("Proporcione el peso del aspirante");
} else if (isNaN($("#empPesoRE").val())) {
  pintaerrorvalidacion("Peso del aspirante inválido");
}

else if ( $("#empEstaturaRE").val() == "") {
  pintaerrorvalidacion("Proporcione la estatura del aspirante");
} else if (isNaN( $("#empEstaturaRE").val())) {
  pintaerrorvalidacion("Estatura del aspirante inválida");
}

else if ($("#empTallaCamisaRE").val() == "") {
  pintaerrorvalidacion("Proporcione la talla de camisa del aspirante");
} else if (isNaN($("#empTallaCamisaRE").val())) {
  pintaerrorvalidacion("Talla de camisa inválida");
}

else if ($("#empTallaPantalonRE").val() == "") {
  pintaerrorvalidacion("Proporcione la talla de pantalón del aspirante");
} else if (isNaN($("#empTallaPantalonRE").val())) {
  pintaerrorvalidacion("talla de pantalón inválida");
}

else if ( $("#empNumCalzadoRE").val() == "") {
  pintaerrorvalidacion("Proporcione el número de calzado del aspirante");
} else if (isNaN( $("#empNumCalzadoRE").val())) {
  pintaerrorvalidacion("Numero de calzado inválido");
}

else if ($("#selectEmpCivilRE").val() == "") {
  pintaerrorvalidacion("Proporcione el estado civil del aspirante");
}

else if ($("#selectEmpSexoRE").val() == "") {
  pintaerrorvalidacion("Proporcione el género del aspirante");
}

else if ($("#selectEmpTipoSangreRE").val() == "") {
  pintaerrorvalidacion("Proporcione el tipo de sangre del aspirante");
}

else if ($("#empFechaNacRE").val() == "") {
  pintaerrorvalidacion("Proporcione la fecha de nacimiento del aspirante");
}

else if ($("#selectEmpEntidadRE").val() == "") {
  pintaerrorvalidacion("Proporcione la entidad de nacimiento del aspirante");
}

else if ($("#empCalleRE").val() == "") {
  pintaerrorvalidacion("Proporcione la calle del aspirante");
}

else if ($("#empNumeroCRE").val() == "") {
  pintaerrorvalidacion("Proporcione el número de domicilio del aspirante");
}

else if ($("#empColoniaRE").val() == "") {
  pintaerrorvalidacion("Proporcione la colonia del aspirante");
}

else if ($("#empMunicipioRE").val() == "") {
  pintaerrorvalidacion("Proporcione el municipio del aspirante");
}

else if ($("#empCiudadRE").val() == "") {
  pintaerrorvalidacion("Proporcione la ciudad del aspirante");
}

else if ($("#empTelFijoRE").val() == "" && $("#empTelMovilRE").val() == "") {
  pintaerrorvalidacion("Proporcione por lo menos un teléfono del aspirante");
}

else if ($("#empEmailRE").val() == "") {
  pintaerrorvalidacion("Proporcione el correo electronico del aspirante");
} else if ($("#empEmailRE").val() != "" && !/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test($("#empEmailRE").val())) {

  pintaerrorvalidacion("El formato de correo electronico del aspirante es incorrecto");   
}else if(licenciaRE==1 && $("#numLicenciaRE").val()==""){
  pintaerrorvalidacion("Proporcione N° de licencia");

}else if(licenciaRE==1 &&  $("#fechaLicenciaRE").val()==""){
 pintaerrorvalidacion("Proporcione Fecha vigencia licencia");   

}else if ($("#selectEmpEstudioRE").val() == "") {
  pintaerrorvalidacion("Proporcione el ultimo grado de estudios del aspirante");
}

else if ($("#empPadreRE").val() == "") {
  pintaerrorvalidacion("Proporcione el nombre del padre del aspirante");
}

else if ($("#empMadreRE").val() == "") {
  pintaerrorvalidacion("Proporcione el nombre de la madre del aspirante");
}

else if ($("#empEsposaRE").val() == "") {
  pintaerrorvalidacion("Proporcione el nombre de la (el) esposa (o) del aspirante");
}

else if ($("#empNombreR1RE").val() == "" && $("#empNombreR2RE").val() == "") {
  alert("Proporcione por lo menos una referencia del aspirante");
}

else if ($("#empNombreR1RE").val() != "" &&  $("#empTelR1RE").val() == "") {
  pintaerrorvalidacion("Proporcione el teléfono de la referencia 1 del aspirante");
}

else if ($("#empNombreR2RE").val() != "" && $("#empTelR2RE").val() == "") {
  pintaerrorvalidacion("Proporcione el teléfono de la referencia 2 del aspirante");
}

else if ($("#empTelR2RE").val() != "" && $("#empNombreR2RE").val()  == "") {
  pintaerrorvalidacion("Proporcione el nombre de la referencia 2 del aspirante");
}

else if ($("#empTelR1RE").val() != "" && $("#empNombreR1RE").val() == "") {
  pintaerrorvalidacion("Proporcione el nombre de la referencia 1 del aspirante");
}else {
  $("#NumEmpModalFirmaParaBajaTarjetaEdit").val("");
  $("#NumEmpModalFirmaParaBajaTarjetahiddenEdit").val("");
  $("#constraseniaFirmaParaBajaTarjetaEdit").val("");
  $("#constraseniaFirmaParaBajaTarjetaHiddenEdit").val("");
  $("#modalReingresoSolicituEmpleo").modal('hide');
  $('#modalFirmaReingresosEmpleado').modal();
  $("#divarchivolicencia").hide();
  if(licenciaRE==1){
    $("#divarchivolicencia").show();

  }

}
}
function pintaerrorvalidacion(mensaje){
  $('#msgAlert11111').fadeIn();
  var mmsssjjjrjj=mensaje;
  alertMsgreeeeee="<div id='msgAlert11111' class='alert alert-error'><strong>ERROR:</strong> "+mmsssjjjrjj+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#alertMsg1RE").html(alertMsgreeeeee);
  $(document).scrollTop(0);
  $('#msgAlert11111').delay(4000).fadeOut('slow');
}

function obtenerFolioPreseleccionRE()
{
   // var rutalogo="img/logoGif.jpg";  

   if($("#numempleadopreseleccionRE").val()!="" && $("#folioempleadopreseleccionRE").val()==""){
    $.ajax({
      async : false,
      type: "POST",
      url: "ajax_obtenerFolioPres.php",
      dataType: "json",
      success: function(response) {
        if (response.status == "success")
        {                    
          var folio = response.folioPre.folioPres;                      
          $("#txtFolioSolicitudRE").val(folio);

        }              
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);

      }
    });
  }
  guardarSolicitudEmpleoReingreso();


}


function guardarSolicitudEmpleoReingreso(){

 var datos=Array(); //$("#form_registroPreseleccion").serialize();
 var infonavitRE=0;
 var fonacotRE=0;
 var cartillaRE=0;
 var licenciaRE=0;
 var personasRE=0;
 var licenciapeermanente=0;
 if( $('#checkEmpInfonavitRE').is(':checked') ) {
  infonavitRE=1;
}
if( $('#checkEmpFonacotRE').is(':checked') ) {
  fonacotRE=1;
}
if( $('#checkEmpCartillaRE').is(':checked') ) {
  cartillaRE=1;
}
if( $('#checkEmpLicenciaRE').is(':checked') ) {
  licenciaRE=1;
}
if( $('#checkEmpPersonasRE').is(':checked') ) {
  personasRE=1;
}
if( $('#checkEmpLicenciaPermanenteRE').is(':checked')  ){
  licenciapeermanente=1;

}
datos += "&infonavit=" + infonavitRE; 
datos += "&fonacot=" + fonacotRE; 
datos += "&cartilla=" + cartillaRE; 
datos += "&licencia=" + licenciaRE; 
datos += "&personas=" + personasRE; 
datos += "&txtFolioSolicitud=" + $("#txtFolioSolicitudRE").val(); 
datos += "&empPuesto=" + $("#empPuestoRE").val(); 
datos += "&empApPaterno=" + $("#empApPaternoRE").val();                        
datos += "&empApMaterno=" + $("#empApMaternoRE").val();
datos += "&empNombre=" + $("#empNombreRE").val();
datos += "&empEdad=" + $("#empEdadRE").val();
datos += "&empPeso=" + $("#empPesoRE").val();
datos += "&empEstatura=" + $("#empEstaturaRE").val();
datos += "&empTallaCamisa=" + $("#empTallaCamisaRE").val();
datos += "&empTallaPantalon=" + $("#empTallaPantalonRE").val();
datos += "&empNumCalzado=" + $("#empNumCalzadoRE").val();
datos += "&selectEmpCivil=" + $("#selectEmpCivilRE").val();
datos += "&selectEmpSexo=" + $("#selectEmpSexoRE").val();
datos += "&selectEmpTipoSangre=" + $("#selectEmpTipoSangreRE").val();
datos += "&empFechaNac=" + $("#empFechaNacRE").val();
datos += "&selectEmpEntidad=" + $("#selectEmpEntidadRE").val();
datos += "&empCodPostal=" + $("#empCodPostalRE").val();
datos += "&empCalle=" + $("#empCalleRE").val();
datos += "&empNumeroC=" + $("#empNumeroCRE").val();
datos += "&empColonia=" + $("#empColoniaRE").val();
datos += "&empMunicipio=" + $("#empMunicipioRE").val();
datos += "&empCiudad=" + $("#empCiudadRE").val();
datos += "&empTelFijo=" + $("#empTelFijoRE").val();
datos += "&empTelMovil=" + $("#empTelMovilRE").val();
datos += "&empEmail=" + $("#empEmailRE").val();
datos += "&empImss=" + $("#empImssRE").val();
datos += "&empNombreUE=" + $("#empNombreUERE").val();             
datos += "&empFecha1E1=" + $("#empFecha1E1RE").val();             
datos += "&empFecha2E1=" + $("#empFecha2E1RE").val();             
datos += "&empTelE1=" + $("#empTelE1RE").val();      
datos += "&empCausaSepE1=" + $("#empCausaSepE1RE").val();                 
datos += "&empNombreEA=" + $("#empNombreEARE").val();             
datos += "&empFecha1E2=" + $("#empFecha1E2RE").val();             
datos += "&empFecha2E2=" + $("#empFecha2E2RE").val();             
datos += "&empTelE2=" + $("#empTelE2RE").val();      
datos += "&empCausaSepE2=" + $("#empCausaSepE2RE").val();                           
datos += "&selectEmpEstudio=" + $("#selectEmpEstudioRE").val();                     
datos += "&empCursoEspecial=" + $("#empCursoEspecialRE").val();                      
datos += "&empEnfermedad=" + $("#empEnfermedadRE").val();                 
datos += "&empPadre=" + $("#empPadreRE").val();      
datos += "&empMadre=" + $("#empMadreRE").val();      
datos += "&empEsposa=" + $("#empEsposaRE").val();         
datos += "&empHijo1=" + $("#empHijo1RE").val();      
datos += "&empHijo2=" + $("#empHijo2RE").val();      
datos += "&empHijo3=" + $("#empHijo3RE").val();      
datos += "&empHijo4=" + $("#empHijo4RE").val();      
datos += "&empHijo5=" + $("#empHijo5RE").val();      
datos += "&empNombreR1=" + $("#empNombreR1RE").val();             
datos += "&empTelR1=" + $("#empTelR1RE").val();      
datos += "&empNombreR2=" + $("#empNombreR2RE").val();             
datos += "&empTelR2=" + $("#empTelR2RE").val();        
datos += "&numempleadopreseleccion=" + $("#numempleadopreseleccionRE").val();                                         
datos += "&folioempleadopreseleccion=" + $("#folioempleadopreseleccionRE").val();  
datos += "&numLicenciaPreseleccion=" + $("#numLicenciaRE").val();  
datos += "&fechavigencialicencia=" + $("#fechaLicenciaRE").val();  
datos += "&licenciapermanente=" + licenciapeermanente;  



      //console.log(datos);
      $.ajax({
        async : false,
        type: "POST",
        url: "ajax_registrarPreseleccion.php",
        data: datos,
        dataType: "json",
        success: function(response) {

          $("#modalReingresoSolicituEmpleo").modal('hide');
          alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Datos Actualizados</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

          $("#alertMsg").html(alertMsg1);
          $(document).scrollTop(0);
          $('#msgAlert').delay(3000).fadeOut('slow');

        },
        error: function(jqXHR, textStatus, errorThrown){
          alert(jqXHR.responseText);

        }
      });
      
    }

    function editSolicitud(folio,numeroempleado){
     $("#form_registroPreseleccionReingresoEmpleado")[0].reset(); 
     $("#folioempleadopreseleccionRE").val("");
     $("#numempleadopreseleccionRE").val("");
     $("#txtFolioSolicitudRE").val("");
     $('#checkEmpInfonavitRE').removeAttr('checked');
     $('#checkEmpFonacotRE').removeAttr('checked');
     $('#checkEmpCartillaRE').removeAttr('checked');
     $('#checkEmpLicenciaRE').removeAttr('checked');
     $('#checkEmpLicenciaPermanenteRE').removeAttr('checked');
     $('#checkEmpPersonasRE').removeAttr('checked');
     $("#selectEmpCivilRE").val("");
     $("#selectEmpSexoRE").val("");
     $("#selectEmpTipoSangreRE").val("");
     $("#selectEmpSexoRE").val("");
     $("#selectEmpEntidadRE").val("");
     $("#selectEmpEstudioRE").val("");
 /////////////////////////////////////*******************///////////////////////////
 $("#numempleadopreseleccionRE").val(numeroempleado);
 if(folio=="null" || folio==null ||folio=="NULL"){
  folio="";

}
$("#folioempleadopreseleccionRE").val(folio);
$("#mostrarbtnguardarsolicituReingreso").hide();
$("#mostrabtneditarsolicitudconsultaEmpleado" ).show();
  //obtenerFolioPreseleccionRE();
  funcionmostrarFormSolicitudEmpleo(folio);

}

function EditarSolicitEmpleo(){
 if ($("#empPuestoRE").val() == "") {
   pintaerrorvalidacion("Proporcione el puesto que solicita");

 }

 else if ( $("#empApPaternoRE").val() == "") {
  pintaerrorvalidacion("Proporcione el apellido paterno del aspirante");
}

else if ($("#empApMaternoRE").val() == "") {
 pintaerrorvalidacion("Proporcione el apellido materno del aspirante");
}

else if ($("#empNombreRE").val() == "") {
  pintaerrorvalidacion("Proporcione el nombre del aspirante");
}

else if ($("#empEdadRE").val() == "") {
  pintaerrorvalidacion("Proporcione la edad del aspirante");
} else if (isNaN($("#empEdadRE").val())) {
  pintaerrorvalidacion("Edad del aspirante inválida");
}

else if ($("#empPesoRE").val() == "") {
  pintaerrorvalidacion("Proporcione el peso del aspirante");
} else if (isNaN($("#empPesoRE").val())) {
  pintaerrorvalidacion("Peso del aspirante inválido");
}

else if ( $("#empEstaturaRE").val() == "") {
  pintaerrorvalidacion("Proporcione la estatura del aspirante");
} else if (isNaN( $("#empEstaturaRE").val())) {
  pintaerrorvalidacion("Estatura del aspirante inválida");
}

else if ($("#empTallaCamisaRE").val() == "") {
  pintaerrorvalidacion("Proporcione la talla de camisa del aspirante");
} else if (isNaN($("#empTallaCamisaRE").val())) {
  pintaerrorvalidacion("Talla de camisa inválida");
}

else if ($("#empTallaPantalonRE").val() == "") {
  pintaerrorvalidacion("Proporcione la talla de pantalón del aspirante");
} else if (isNaN($("#empTallaPantalonRE").val())) {
  pintaerrorvalidacion("talla de pantalón inválida");
}

else if ( $("#empNumCalzadoRE").val() == "") {
  pintaerrorvalidacion("Proporcione el número de calzado del aspirante");
} else if (isNaN( $("#empNumCalzadoRE").val())) {
  pintaerrorvalidacion("Numero de calzado inválido");
}

else if ($("#selectEmpCivilRE").val() == "") {
  pintaerrorvalidacion("Proporcione el estado civil del aspirante");
}

else if ($("#selectEmpSexoRE").val() == "") {
  pintaerrorvalidacion("Proporcione el género del aspirante");
}

else if ($("#selectEmpTipoSangreRE").val() == "") {
  pintaerrorvalidacion("Proporcione el tipo de sangre del aspirante");
}

else if ($("#empFechaNacRE").val() == "") {
  pintaerrorvalidacion("Proporcione la fecha de nacimiento del aspirante");
}

else if ($("#selectEmpEntidadRE").val() == "") {
  pintaerrorvalidacion("Proporcione la entidad de nacimiento del aspirante");
}

else if ($("#empCalleRE").val() == "") {
  pintaerrorvalidacion("Proporcione la calle del aspirante");
}

else if ($("#empNumeroCRE").val() == "") {
  pintaerrorvalidacion("Proporcione el número de domicilio del aspirante");
}

else if ($("#empColoniaRE").val() == "") {
  pintaerrorvalidacion("Proporcione la colonia del aspirante");
}

else if ($("#empMunicipioRE").val() == "") {
  pintaerrorvalidacion("Proporcione el municipio del aspirante");
}

else if ($("#empCiudadRE").val() == "") {
  pintaerrorvalidacion("Proporcione la ciudad del aspirante");
}

else if ($("#empTelFijoRE").val() == "" && $("#empTelMovilRE").val() == "") {
  pintaerrorvalidacion("Proporcione por lo menos un teléfono del aspirante");
}

else if ($("#empEmailRE").val() == "") {
  pintaerrorvalidacion("Proporcione el correo electronico del aspirante");
} else if ($("#empEmailRE").val() != "" && !/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test($("#empEmailRE").val())) {

  pintaerrorvalidacion("El formato de correo electronico del aspirante es incorrecto");   
}else if((licenciaRE==1 && (licenciapermanente==1 || licenciapermanente==0)) && $("#numLicenciaRE").val()==""){

  pintaerrorvalidacion("Proporcione N° de licencia");

}else if((licenciaRE==1 && licenciapermanente==0) && $("#fechaLicenciaRE").val()==""){
 pintaerrorvalidacion("Proporcione Fecha vigencia licencia");   






}else if ($("#selectEmpEstudioRE").val() == "") {
  pintaerrorvalidacion("Proporcione el ultimo grado de estudios del aspirante");
}

else if ($("#empPadreRE").val() == "") {
  pintaerrorvalidacion("Proporcione el nombre del padre del aspirante");
}

else if ($("#empMadreRE").val() == "") {
  pintaerrorvalidacion("Proporcione el nombre de la madre del aspirante");
}

else if ($("#empEsposaRE").val() == "") {
  pintaerrorvalidacion("Proporcione el nombre de la (el) esposa (o) del aspirante");
}

else if ($("#empNombreR1RE").val() == "" && $("#empNombreR2RE").val() == "") {
  alert("Proporcione por lo menos una referencia del aspirante");
}

else if ($("#empNombreR1RE").val() != "" &&  $("#empTelR1RE").val() == "") {
  pintaerrorvalidacion("Proporcione el teléfono de la referencia 1 del aspirante");
}

else if ($("#empNombreR2RE").val() != "" && $("#empTelR2RE").val() == "") {
  pintaerrorvalidacion("Proporcione el teléfono de la referencia 2 del aspirante");
}

else if ($("#empTelR2RE").val() != "" && $("#empNombreR2RE").val()  == "") {
  pintaerrorvalidacion("Proporcione el nombre de la referencia 2 del aspirante");
}

else if ($("#empTelR1RE").val() != "" && $("#empNombreR1RE").val() == "") {
  pintaerrorvalidacion("Proporcione el nombre de la referencia 1 del aspirante");
}else {
  obtenerFolioPreseleccionRE();
}


}



$("#licenciaConducirsiEMpEdited").click(function(){
//alert($('input:radio[name=licenciaConducir]:checked').val());
$("#trnumerolicenciaEdited").show();
//$("#trvigencialicenciaEdited").show();                        
//$("#numerolicenciaEdited").val("");


$("#trlicenciapermanenteEdited").show();
$("#trnumerolicenciaEdited").show();
//$("#numerolicencia").val("");
$("#licenciaConducirnopermanenteEdited").prop('checked','');
$("#licenciaConducirsipermanenteEdited").prop('checked','checked');



});

$("#licenciaConducirnoEMpEdited").click(function(){
//alert($('input:radio[name=licenciaConducir]:checked').val());
$("#trnumerolicenciaEdited").hide();
$("#numerolicenciaEdited").val("");
$("#trvigencialicenciaEdited").hide(); 
$("#inpfehavigencialicenciaEdited").val("");


$("#trlicenciapermanenteEdited").hide();
$("#trnumerolicenciaEdited").hide();
//$("#numerolicencia").val("");
$("#licenciaConducirnopermanenteEdited").prop('checked','checked');
$("#licenciaConducirsipermanenteEdited").prop('checked','');

});



$("#licenciaConducirsipermanenteEdited").click(function(){
  $("#trnumerolicenciaEdited").show();
  $("#numerolicenciaEdited").val("");
  $("#trvigencialicenciaEdited").hide();
  $("#inpfehavigencialicenciaEdited").val("");
});
$("#licenciaConducirnopermanenteEdited").click(function(){
  $("#trnumerolicenciaEdited").show();
  $("#numerolicenciaEdited").val("");
  $("#trvigencialicenciaEdited").show();
  $("#inpfehavigencialicenciaEdited").val("");
//$("#trarchivolicencia").show();
//$("#docdigitalizadoo3").val("");
});


//para el formulario de editar solicitud
$("#checkEmpLicenciaRE").click(function(){ 
 if( $('#checkEmpLicenciaRE').is(':checked') ) {

   $("#tdnumlicenciaRE").show();
   $("#tdfechalicenciaRE").show();
   $("#tdnumlicenciaprecontratapermanenteRE").show('slow');
   $("#checkEmpLicenciaPermanenteRE").prop('checked','');
   licenciaRE=1;
 }else{

  $("#tdnumlicenciaRE").hide();
  $("#tdfechalicenciaRE").hide();

  $("#tdnumlicenciaprecontratapermanenteRE").hide();
  $("#checkEmpLicenciaPermanenteRE").prop('checked','checked');
  licenciaRE=0;
}

$('#numLicenciaRE').val("");
$("#fechaLicenciaRE").val("");
$("#docdigitalizado3").val("");

});
var licenciapermanente=0;
var licenciaRE=0;
$("#checkEmpLicenciaPermanenteRE").click(function(){ 
 if( $('#checkEmpLicenciaPermanenteRE').is(':checked') ) {      
//$("#tdnumlicenciaRE").hide();
licenciapermanente=1;
$("#tdfechalicenciaRE").hide(); 
$("#fechaLicenciaRE").val("")   
}else{
  $("#tdnumlicenciaRE").show('slow');
  $("#tdfechalicenciaRE").show('slow');
  licenciapermanente=0;
}
$('#tdnumlicenciaRE').val("");
$('#tdfechalicenciaRE').val("");
});


function hoyFecha(){
  var hoy = new Date();
  var dd = hoy.getDate();
  var mm = hoy.getMonth()+1;
  var yyyy = hoy.getFullYear();
  dd = addZero(dd);
  mm = addZero(mm);
  $("#txtfechaquitarantesubirloscambios").val(yyyy+"-"+mm+"-"+dd);
     }
     function addZero(i) {
      if (i < 10) {
        i = '0' + i;
      }
      return i;
    }

    function consultaultimofolioincapacidad(numeroempleado,eleccion){
      var bandera=true;

var hoy=$("#txtfechaquitarantesubirloscambios").val();//quitar esta linea y el input cuando se suba el cambio
$.ajax({
  type: "POST",
  url: "ajax_getPuestosBylineanegocio.php",
  data: {"lineanegocio":"","opcion":eleccion,"numeroempleado":numeroempleado},
  dataType: "json",
  async:false,
  success: function(response) {
    var st_7=response.st7;
    var st_2=response.st2;
    var idincapacidad=response.idincapacidad;
                //alert(idincapacidad);
                var fechaBaja=response.fechaFInIncapacidad; 
                if(idincapacidad==2){
                  if(((st_7=="null"|| st_7==null || st_7=="NULL" || st_7==1 ) && (st_2=="null"|| st_2==null || st_2=="NULL" ||  st_2==0))){
           // $("#a_"+incidenciaAsistenciaId).addClass("elementoActivo");
           bandera=false;
           muestraerrorbajaempleadoporincapacidad("El empleado no puede ser dado de baja debido a que adeuda ST2","")
         }else if(fechaBaja>=hoy){
          bandera=false;
          muestraerrorbajaempleadoporincapacidad("El empleado no puede ser dado de baja debido a que se encuentra de incapacidad",fechaBaja)
        }
      }
      else  if(idincapacidad==1 || idincapacidad==3){
        if(fechaBaja>=hoy){
          muestraerrorbajaempleadoporincapacidad("El empleado no puede ser dado de baja debido a que se encuentra de incapacidad",fechaBaja)
                    //((st_7=="null"|| st_7==null || st_7=="NULL" || st_7==0 ) && (st_2=="null"|| st_2==null || st_2=="NULL" ||  st_2==0))
           // $("#a_"+incidenciaAsistenciaId).addClass("elementoActivo");
           bandera=false;
      //alert("el empleado no puede ser dado de baja");
    }
  }
},
error: function(jqXHR, textStatus, errorThrown){
  alert(jqXHR.responseText);
  alert("error");
}
});
return bandera;  
  //esta funcion debe retornar false si el empleado tiene una incapacidad sin cocluir el ciclo de st2
}

function muestraerrorbajaempleadoporincapacidad(mensaje,fechabaja){
  if(fechabaja!=""){
    mensaje=mensaje+" hasta el día: "+fechabaja;
  }
      //var mmsssjjjreingressso="El Empleado no puede ser dado de baja debido a que se encuentra de incapacidad";
      alertMsgre="<div id='msgAlert1' class='alert alert-error'><strong>Reingreso Del Empleado : </strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
      $("#alertMsg").html(alertMsgre);
      $(document).scrollTop(0);
      $('#msgAlert1').delay(4000).fadeOut('slow');

    }

  function consultaultimofiniquito(numeroempleado){

  var numeroempleadoD  = numeroempleado.split("-");
  var entidadempDeu    = numeroempleadoD[0];
  var consecutivoempDeu= numeroempleadoD[1];
  var categoriaempDeu  = numeroempleadoD[2];

     $.ajax({
     type: "POST",
     url: "ajax_getEstatusPago.php",
     data: {"entidadempDeu":entidadempDeu,"consecutivoempDeu":consecutivoempDeu,"categoriaempDeu":categoriaempDeu},
     dataType: "json",
     async:false,
     success: function(response) {
        $("#UltimaDeudahdn").val(response.datos[0]["UltimaDeuda"]); 
        $("#EstatusDeudahdn").val(response.datos[0]["EstatusDeuda"]);
        $("#DeudaEmphdn").val(response.datos[0]["DeudaEmp"]);
    },  

error: function(jqXHR, textStatus, errorThrown){
  alert(jqXHR.responseText);
  alert("error");
}
});
}

function consultarsielempleadoestabetado(numeroempleado){
  var numeroempleadoD  = numeroempleado.split("-");
  var entidadempDeu    = numeroempleadoD[0];
  var consecutivoempDeu= numeroempleadoD[1];
  var categoriaempDeu  = numeroempleadoD[2];

  $.ajax({
  type: "POST",
  url: "ajax_getEmpleadoestabetado.php",
  data: {"entidadempDeu":entidadempDeu,"consecutivoempDeu":consecutivoempDeu,"categoriaempDeu":categoriaempDeu},
  dataType: "json",
  async:false,
  success: function(response) {
    if(response.datos.length != "0"){
      $("#EstatusBetado").val(response.datos[0]["EstatusReingreso"]); 
      $("#MotivoBetado").val(response.datos[0]["MotivoReingreso"]);
      $("#ModuloBaja").val(response.datos[0]["ModuloBaja"]);
    }else{
      $("#EstatusBetado").val(""); 
      $("#MotivoBetado").val("");
      $("#ModuloBaja").val("");
    }
  },  

error: function(jqXHR, textStatus, errorThrown){
  alert(jqXHR.responseText);
  alert("error");
}
});
}

$( "#botonGuardarPago" ).click(function() {

  var numeroEmpleado = $("#numeroEmpleadohdn").val();
  var fechaIngreso = $("#fechaIngresohdn").val();
  var nombreCompleto = $("#nombreCompletohdn").val();
  var estatusEmpleado = $("#estatusEmpleadohdn").val();
  var tipoPeriodo = $("#tipoPeriodohdn").val();
  var empleadoIdPuntoServicio = $("#empleadoIdPuntoServiciohdn").val();
  var tipoEmpleado = $("#tipoEmpleadohdn").val();
  var idResponsableAsistencia = $("#idResponsableAsistenciahdn").val();
  var puestoCubiertoId = $("#puestoCubiertoIdhdn").val();
  var entidadTrabajo = $("#entidadTrabajohdn").val();
  var empleadoIdGenero = $("#empleadoIdGenerohdn").val();
  var estatusImss = $("#estatusImsshdn").val();
  var roloperativo = $("#roloperativohdn").val();
  var foliopreseleccion = $("#foliopreseleccionhdn").val();
  var estatusEmpleadoOperaciones = $("#estatusEmpleadoOperacioneshdn").val();
  var DescripcionEntidadTr = $("#DescripcionEntidadTrhdn").val();
  var DeudaEmp = $("#DeudaEmphdn").val();
  var docPagoDeuda= $("#docPagoDeuda").val();
  
  var formData = new FormData($("#archivoPagoDeuda")[0]);
      formData.append('numeroEmpleado', numeroEmpleado);
      formData.append('nombreCompleto', nombreCompleto);
      formData.append('entidadTrabajo', entidadTrabajo);
      formData.append('roloperativo', roloperativo);

      if (docPagoDeuda==""){

        alert("Ingrese un tipo de archivo correcto(.jpg , .png, .pdf)");

      }
      else{

  $.ajax({
          type: "POST",
          url: "ajax_GuardarDocPago.php",
          data: formData,
          dataType: "json",
          cache: false,
          contentType: false,
          processData: false,
          async:false,
          success: function(response) {
             $("#ModalArchivoDeuda").modal("hide");
             mostrarModalBajaEmpleado(numeroEmpleado, fechaIngreso, nombreCompleto, estatusEmpleado, tipoPeriodo, empleadoIdPuntoServicio, tipoEmpleado, idResponsableAsistencia, puestoCubiertoId, entidadTrabajo,empleadoIdGenero,estatusImss,roloperativo,foliopreseleccion,estatusEmpleadoOperaciones,DescripcionEntidadTr);
          //llamada a tu funcion principal
          },  
            error: function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText);
            alert("error");
            }
  });
}
});

$( "#botonCancelarPago" ).click(function() {

$("#ModalArchivoDeuda").modal("hide");

});


function abrirarchivoRenunciaRh(){ 
  var EntidadTreabajoRh = $("#idEndidadFederativaEdited option:selected" ).text();
  var NumeroEmpleadoModal = $("#txtNumeroEmpleadoModal").val();
  var NombreEmpleadoModal = $("#txtNombreEmpleadoModal").val();
  var NombreSolicitanteRh = $("#NombreSolicitanteRh").val();
  var FirmaInternaRh = $("#FirmaInternaRh").val();
  var FirmaInternaGuardiaRh = $("#FirmaInternaGuardiaRh").val();
  var NombreGuardiaRh = $("#NombreGuardiaRh").val();
  if(NombreSolicitanteRh=="" || FirmaInternaRh==""){
     errorModalBajaRh("Favor de firmar el documento (Administrativo )para poder abrirlo")
  }else if(FirmaInternaGuardiaRh=="" || NombreGuardiaRh==""){
     errorModalBajaRh("Favor de firmar el documento (Guardia) para poder abrirlo")
  }else{
    window.open("generadordocBajaEmpleadoRh.php?EntidadTreabajoRh=" + EntidadTreabajoRh+"&NumeroEmpleadoModal=" + NumeroEmpleadoModal+"&NombreEmpleadoModal=" + NombreEmpleadoModal+"&NombreSolicitanteRh=" + NombreSolicitanteRh+"&FirmaInternaRh=" + FirmaInternaRh+"&FirmaInternaGuardiaRh=" + FirmaInternaGuardiaRh,'fullscreen=no');    
  }
}

//////////////////Comienza Modal Firma Del Administrativo //////////////////////////////////

function firmarDocumentoRh(){
  $("#NumEmpModalBajaRh").val("");
  $("#constraseniaFirmaRh").val("");
  $("#modalFirmaElectronicaRh").modal();
  $("#myModalBajaEmpleado").modal("hide");
}

$("#NumEmpModalBajaRh").keyup(function () 
{

 var NumEmpModalBajaRh = $("#NumEmpModalBajaRh").val();
 var expreg = /^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/;
 var expreg1 = /^[0-9]{2}\-[0-9]{5}\-[0-9]{2}/;
 
 if(expreg.test(NumEmpModalBajaRh) || expreg1.test(NumEmpModalBajaRh)){
    consultaEmpleadoFirmaInternaBajaRh(NumEmpModalBajaRh);
  }else{
   // cargaerroresFirmaInternaBajaRh("El Formato Del Numero De Empleado Es Incorrecto");
  //  $("#NumEmpModalBajaRh").val("");
    $("#btnFirmarDocRh").hide();
    $("#constraseniaFirmaRh").val("");
  }
});

function consultaEmpleadoFirmaInternaBajaRh (numeroEmpleado){
  var caso = "1";
  $.ajax({
    type: "POST",
    url: "ajax_obtenerEmpleadoPorIdFirmaBaja.php",
    data:{"numeroEmpleado":numeroEmpleado,"caso":caso},
    dataType: "json",
    success: function(response) {
      if (response.status == "success"){
        var empleadoExtiste = response["empleado"].length;
        
        if(empleadoExtiste=="0"){
          cargaerroresFirmaInternaBajaRh("El Empleado No Existe En La Base De Registro De Firmas Favor De Verificar");
          $("#NumEmpModalBajaRh").val("");
          $("#btnFirmarDocRh").hide();
        }else{
          var EstatusFirmaInterna = response.empleado[0].EstatusFirmaInterna;
          if(EstatusFirmaInterna=="0"){
            cargaerroresFirmaInternaBajaRh("Esta Firma Fue Dada De Baja Favor de solicitar Otra o Comunicarse Con RH");
            $("#NumEmpModalBajaRh").val("");
            $("#btnFirmarDocRh").hide();
          }else{
            $("#btnFirmarDocRh").show();
          }
        }
      }else{
        cargaerroresFirmaInternaBajaRh(response.menssaje);
        $("#NumEmpModalBajaRh").val("");
        $("#btnFirmarDocRh").hide();
      }
    },error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }

  });
}
function cargaerroresFirmaInternaBajaRh(mensaje){
  $('#errorModalFirmaInternaRh').fadeIn();
  msjerrorbaja="<div id='errorModalFirmaInternaRh1' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errorModalFirmaInternaRh").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errorModalFirmaInternaRh').delay(4000).fadeOut('slow'); 
}


function RevisarFirmaInternaRH(){
  var NumEmpModalBaja = $("#NumEmpModalBajaRh").val();
  var constraseniaFirma = $("#constraseniaFirmaRh").val();
 
 if(NumEmpModalBaja==""){
   cargaerroresFirmaInternaBajaRh("El numero de empleado no puede estar vacio");
  }else if(constraseniaFirma==""){
     cargaerroresFirmaInternaBajaRh("Escriba la contraseña para continuar");
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
          cargaerroresFirmaInternaBajaRh("La Contraseña ingresada es incorrecta favor de escribrla exactamente como la ingreso en el registro");
        }else{
          var nombre = response.datos["0"].nombreEmpleado + " " + response.datos["0"].apellidoPaterno + " " + response.datos["0"].apellidoMaterno;
          var contraseniaInsertadaCifrada =response.datos["0"].ContraseniaFirma;
          $("#numempleadoFirmahiddenRh").val(NumEmpModalBaja);
          $("#NombreSolicitanteRh").val(nombre);
          $("#FirmaInternaRh").val(contraseniaInsertadaCifrada);
          $("#modalFirmaElectronicaRh").modal("hide");
          $("#myModalBajaEmpleado").modal();
          $("#NumEmpModalBajaRh").val("");
          $("#constraseniaFirmaRh").val("");
        }
         
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
    });
  }
}


function errorModalBajaRh(mensaje){
  $('#alertMsg1').fadeIn();
    msjerrorbaja="<div id='alertMsg11' class='alert alert-error'><strong>ALERTA:</strong>"+mensaje+"<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
    $("#alertMsg1").html(msjerrorbaja);
    $(document).scrollTop(0);
    $('#alertMsg1').delay(4000).fadeOut('slow');
}
function cancelarFirmaRH(){

  $("#NumEmpModalBajaRh").val("");
  $("#constraseniaFirmaRh").val("");
  $("#modalFirmaElectronicaRh").modal("hide");
  $("#myModalBajaEmpleado").modal();
}


//////////////////Termina Modal Firma Del Administrativo //////////////////////////////////

//////////////////Comienza Modal Firma Del Guardia 02 //////////////////////////////////

$("#txtCtaClabeEdited").blur(function (){

  var clabe= $("#txtCtaClabeEdited").val();
  if (clabe.length==18){

    $.ajax({
      type: "POST",
      url: "ajax_ConsultarBancoXClabe.php",
      data:{"clabe":clabe},
      dataType: "json",
      success: function(response) {
        if(response.status == "success"){
           var banco = response["idCuentaBanco"];
           $("#selBancoEdit").val(banco);
        }else{
            alertMsg1="<div id='msgAlert' class='alert alert-error'>NO SE HA ENCONTRADO UN BANCO ASOCIADO AL NUMERO DE CUENTA CLABE<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#alertMsg").html(alertMsg1);
            $(document).scrollTop(0);
            $('#msgAlert').delay(3000).fadeOut('slow');
        }
      },error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
    });
  }else{
    alertMsg1="<div id='msgAlert' class='alert alert-error'>EL NUMERO DE CUENTA DEBE SER DE 18 DIGITOS<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#alertMsg").html(alertMsg1);
            $(document).scrollTop(0);
            $('#msgAlert').delay(3000).fadeOut('slow');
  }

});

function firmarDocumentoGuardiaRh(){
  $("#constraseniaFirmaElementoBajaRh").val("");
  $("#modalFirmaGuardiaBajaRh").modal();
  $("#myModalBajaEmpleado").modal("hide");
}

$("#constraseniaFirmaElementoBajaRh").blur(function (){
  var contrasenia = $("#constraseniaFirmaElementoBajaRh").val();
  var numEmpleado = $("#txtNumeroEmpleadoModal").val();
  $.ajax({
    type: "POST",
    url: "ajax_obtenercontraseniaEmpASignacion.php",
    data:{"contrasenia":contrasenia,"numEmpleado":numEmpleado},
    dataType: "json",
    success: function(response) {
      if (response.status == "success"){
        var FirmaEmp = response.empleado["0"].contrasenia;
        var nombre = response.empleado["0"].nombre;
        var apellidoPaterno = response.empleado["0"].apellidoPaterno;
        var apellidoMaterno = response.empleado["0"].apellidoMaterno;
        $("#FirmaInternaGuardiaRh").val(FirmaEmp);
        $("#NombreGuardiaRh").val(nombre+" "+apellidoPaterno+" "+apellidoMaterno);
        $("#ActivarActualizarCuentaBajaRh").hide();
        $("#modalFirmaGuardiaBajaRh").modal("hide");
        $("#myModalBajaEmpleado").modal();
      }else{
        cargaerroresFirmaGuardiaBajaRh(response.menssaje); 
        $("#ActivarActualizarCuentaBajaRh").show();
        $("#constraseniaFirmaElementoBajaRh").val("");
      }
    },error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }

  });
});

function cargaerroresFirmaGuardiaBajaRh(mensaje){
  $('#errormodalFirmaElementoBajaRh1').fadeIn();
  msjerrorbaja="<div id='errormodalFirmaElementoBajaRh1' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errormodalFirmaElementoBajaRh").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errormodalFirmaElementoBajaRh1').delay(4000).fadeOut('slow'); 
}

function cancelarFirmaRHGuardia(){
  $("#constraseniaFirmaElementoBajaRh").val("");
  $("#modalFirmaGuardiaBajaRh").modal("hide");
  $("#myModalBajaEmpleado").modal();
}

//////////////////Termina Modal Firma Del Guardia 02 //////////////////////////////////


//////////////////Comienza Modal Firma Del Guardia 03 //////////////////////////////////

function firmarDocumentoRhBajaAdministrativo(){
  $("#NumEmpModalBajaAdmin").val("");
  $("#constraseniaFirmaBajaAdminRh").val("");
  $("#modalFirmaElectronicaRhBajaAdmin").modal();
  $("#myModalBajaEmpleado").modal("hide");
}

$("#NumEmpModalBajaAdmin").keyup(function () 
{
 var NumEmpModalBajaRh = $("#NumEmpModalBajaAdmin").val();
 var expreg = /^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/;
 var expreg1 = /^[0-9]{2}\-[0-9]{5}\-[0-9]{2}/;
 
 if(expreg.test(NumEmpModalBajaRh) || expreg1.test(NumEmpModalBajaRh)){
    consultaEmpleadoFirmaBajaAdministrativo(NumEmpModalBajaRh);
  }else{
    //cargaerroresFirmaBajaAdministrativo("El Formato Del Numero De Empleado Es Incorrecto");
    $("#constraseniaFirmaBajaAdminRh").val("");
    $("#btnFirmarDocBajaAdminRh").hide();
  }
});

function consultaEmpleadoFirmaBajaAdministrativo (numeroEmpleado){
  var caso = "0";
  $.ajax({
    type: "POST",
    url: "ajax_obtenerEmpleadoPorIdFirmaBaja.php",
    data:{"numeroEmpleado":numeroEmpleado,"caso":caso},
    dataType: "json",
    success: function(response) {
      if (response.status == "success"){
        var empleadoExtiste = response["empleado"].length;
        
        if(empleadoExtiste=="0"){
          cargaerroresFirmaBajaAdministrativo("El Empleado No Existe En La Base De Registro De Firmas Favor De Verificar");
          $("#NumEmpModalBajaAdmin").val("");
          $("#btnFirmarDocBajaAdminRh").hide();
        }else {
          var EstatusFirmaInterna = response.empleado[0].EstatusFirmaInterna;
          if(EstatusFirmaInterna=="0"){
            cargaerroresFirmaBajaAdministrativo("Esta Firma Fue Dada De Baja Favor de solicitar Otra o Comunicarse Con RH");
            $("#NumEmpModalBajaAdmin").val("");
            $("#btnFirmarDocBajaAdminRh").hide();
          }else{
            $("#btnFirmarDocBajaAdminRh").show();
          }
        }
      }else{
        cargaerroresFirmaBajaAdministrativo(response.menssaje);
        $("#NumEmpModalBajaAdmin").val("");
        $("#btnFirmarDocBajaAdminRh").hide();
      }
    },error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }
  });
}
function cargaerroresFirmaBajaAdministrativo(mensaje){
  $('#errorModalFirmaBajaAdmin1').fadeIn();
  msjerrorbaja="<div id='errorModalFirmaBajaAdmin1' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errorModalFirmaBajaAdmin").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errorModalFirmaBajaAdmin1').delay(4000).fadeOut('slow'); 
}


function RevisarFirmaInternaRHBajaAdministrativo(){
  var NumEmpModalBaja = $("#NumEmpModalBajaAdmin").val();
  var constraseniaFirma = $("#constraseniaFirmaBajaAdminRh").val();
  var txtNumeroEmpleadoModal = $("#txtNumeroEmpleadoModal").val();
 if(NumEmpModalBaja==""){
   cargaerroresFirmaBajaAdministrativo("El numero de empleado no puede estar vacio");
  }else if(constraseniaFirma==""){
     cargaerroresFirmaBajaAdministrativo("Escriba la contraseña para continuar");
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
          cargaerroresFirmaBajaAdministrativo("La Contraseña ingresada es incorrecta favor de escribirla exactamente como la ingreso en el registro");
          $("#constraseniaFirmaBajaAdminRh").val("");
        }else{
          var nombre = response.datos["0"].nombreEmpleado + " " + response.datos["0"].apellidoPaterno + " " + response.datos["0"].apellidoMaterno;
          var NumeroDuenioFirma = response.datos["0"].EntidadFirma + "-" + response.datos["0"].ConsecutivoFirma + "-" + response.datos["0"].CategoriaFirma;
          var contraseniaInsertadaCifrada =response.datos["0"].ContraseniaFirma;
          if(NumeroDuenioFirma != txtNumeroEmpleadoModal){
            cargaerroresFirmaBajaAdministrativo("La firma No pertenece Al Administrativo que se esta dando de baja Por Favor ingresar la firma interna de quien se esta dando de baja");
            $("#constraseniaFirmaBajaAdminRh").val("");
            $("#NumEmpModalBajaAdmin").val("");
          }else{
            $("#FirmaInternaGuardiaRh").val(contraseniaInsertadaCifrada);
            $("#NombreGuardiaRh").val(nombre);
            $("#modalFirmaElectronicaRhBajaAdmin").modal("hide");
            $("#myModalBajaEmpleado").modal();
          }
        }
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
    });
  }
}

function errorModalBajaRh(mensaje){
  $('#alertMsg1').fadeIn();
    msjerrorbaja="<div id='alertMsg11' class='alert alert-error'><strong>ALERTA:</strong>"+mensaje+"<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
    $("#alertMsg1").html(msjerrorbaja);
    $(document).scrollTop(0);
    $('#alertMsg1').delay(4000).fadeOut('slow');
}
function cancelarFirmaRHBajaAdministrativo(){

  $("#NumEmpModalBajaAdmin").val("");
  $("#constraseniaFirmaBajaAdminRh").val("");
  $("#modalFirmaElectronicaRhBajaAdmin").modal("hide");
  $("#myModalBajaEmpleado").modal();
}


/////////////////// Implementacion Del Bloqueo Permanente de un empleado conflictivo /////////////////////////////////////////////////////////
$('#checkSireingreso').change(function() {
    if ($('#checkSireingreso').is(":checked")) {
      $("#checkNoreingreso").prop("checked", false);
      $("#divComentarioMotivoBeto").hide();
      $("#banderaBetado").val(1);
    }
    else{
      $("#divComentarioMotivoBeto").hide();
      $("#banderaBetado").val("");
    } 
  });
$('#checkNoreingreso').change(function() {
    if ($('#checkNoreingreso').is(":checked")) {
      $("#checkSireingreso").prop("checked", false);
      $("#divComentarioMotivoBeto").show();
      $("#banderaBetado").val(0);
    }
    else{
      $("#divComentarioMotivoBeto").hide();
      $("#banderaBetado").val("");
    } 
  });

$("#AntiguedadVacacionesReingresoSi").click(function(){
//alert($('input:radio[name=licenciaConducir]:checked').val());
$("#AntiguedadVacacionesReingresoNo").prop('checked','');
$("#AntiguedadVacacionesReingresoSi").prop('checked','checked');
$("#AntiguedadVacacionesReingresoSi").val("1");
$("#AntiguedadVacacionesReingresoNo").val("0");

});
$("#AntiguedadVacacionesReingresoNo").click(function(){
$("#AntiguedadVacacionesReingresoNo").prop('checked','checked');
$("#AntiguedadVacacionesReingresoSi").prop('checked','');
$("#AntiguedadVacacionesReingresoSi").val("0");
$("#AntiguedadVacacionesReingresoNo").val("1");
});
  



////////////////////////// Se Agrega Funciones Para La Tarjeta de Despensa ///////////////////////////////////

$("#TarjetaDespensaSiEdit").click(function(){
  var idEndidadFederativaContratacion = $("#IdSucursal").val();
  var tieneIutConsulta = $("#tieneIutConsulta").val();
  if(idEndidadFederativaContratacion == "0" || idEndidadFederativaContratacion == "" || idEndidadFederativaContratacion == "null" || idEndidadFederativaContratacion == null || idEndidadFederativaContratacion == "NULL" || idEndidadFederativaContratacion == "SUCURSAL")
  { 
    $("#TarjetaDespensaSiEdit").prop('checked','');
    alert("Seleccione La Sucursal Antes De Asignar Una Tarjeta De Despensa");
  }else{
    $("#TarjetaDespensaNoEdit").prop('checked','');
    if(tieneIutConsulta == "1"){
      AbrirModalParaDarDeBajaYCambiarIut();
    }else{
      ObtenerNumeroDeIutSiguienteEdit();
      $("#txtnumeroIutEdited").val("");
    }
  }
});

$("#TarjetaDespensaNoEdit").click(function(){
$("#trTarjetaEdit").hide();
$("#TarjetaDespensaSiEdit").prop('checked','');
$("#TarjetaDespensaNoEdit").prop('checked','checked');
var tienetarjeta  = $("#tieneIutConsulta").val();
if(tienetarjeta=="1"){
  AbrirModalParaDarDeBajaYCambiarIut();
}else{
  alert("Este Elemento No Cuenta Con Tarjeta Asignada !!!");
}
});


function ObtenerNumeroDeIutSiguienteEdit()
{
  $("#TarjetaDespensaNoEdit").prop('checked','checked');
  $("#TarjetaDespensaSiEdit").prop('checked','');
  $("#trTarjetaEdit").hide();
  $("#txtnumeroIutEdited").val("");
  var idEndidadFederativaContratacion = $("#IdSucursal").val();
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
          $("#TarjetaDespensaSiEdit").prop('checked','');
          alert("No Cuentas Con Tarjetas De Despensa En Esta Sucursal Favor De Solicitar Mas Al Encargado De Su Matriz!!");
        }else{
          $("#TarjetaDespensaSiEdit").prop('checked','');
          var NumeroIUTObtenido = response.datos[0].idIutTarjeta; 
          var IdTarjetaDespensa = response.datos[0].IdTarjetaDespensa; 
          $("#txtNumeroIutModalEdit").val(NumeroIUTObtenido);
          $("#idTarjetaDespensaEdit").val(IdTarjetaDespensa);
          $("#modalTarjetaDeDespensaEdit").modal();
        }
      }else{
        $("#txtNumeroIutModalEdit").val("");
        $("#idTarjetaDespensaEdit").val("");
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }
  }); 
}

function CambiarModalesParaValidacionEdit(){
  var ComentarioIut = $("#txtComentarioIutEdit").val();
  var txtNumeroIutModal = $("#txtNumeroIutModalEdit").val();
  if(ComentarioIut == "")
  { 
    alert("Ingresa El Motivo Del Cambio de Tarjeta Ya Que La Tarjeta "+ txtNumeroIutModal+" Quedará En Estatus Baja");
  }else{
    $("#modalFirmaElectronicaParaBajaTarjetaEdit").modal();
    $("#modalTarjetaDeDespensaEdit").modal("hide");
  }

}

function RevisarFirmaInternaParaBajaTarjetaEdit(){

  var NumEmpModalBaja = $("#NumEmpModalFirmaParaBajaTarjetaEdit").val();
  var constraseniaFirma = $("#constraseniaFirmaParaBajaTarjetaEdit").val();
  if(NumEmpModalBaja==""){
   cargaerroresFirmaInternaBajaTarjetaDespensaEdit("El numero de empleado no puede estar vacio");
  }else if(constraseniaFirma==""){
     cargaerroresFirmaInternaBajaTarjetaDespensaEdit("Escriba la contraseña para continuar");
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
            cargaerroresFirmaInternaBajaTarjetaDespensaEdit("La Contraseña ingresada es incorrecta favor de escribirla exactamente como la ingreso en el registro");
          }else{
            var contraseniaInsertadaCifrada =response.datos["0"].ContraseniaFirma;
            $("#constraseniaFirmaParaBajaTarjetaHiddenEdit").val(contraseniaInsertadaCifrada);
            $("#NumEmpModalFirmaParaBajaTarjetahiddenEdit").val(NumEmpModalBaja);
            $("#modalFirmaElectronicaParaBajaTarjetaEdit").modal("hide");
            ObtenerSiguienteIdTarjetaDespensaEdit();
            $("#NumEmpModalFirmaParaBajaTarjetaEdit").val("");
            $("#constraseniaFirmaParaBajaTarjetaEdit").val("");

          }
           
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
    });
  }
}

function cargaerroresFirmaInternaBajaTarjetaDespensaEdit(mensaje){
  $('#errorModalFirmaInternaParaBajaTarjetaEdit').fadeIn();
  msjerrorbaja="<div id='errorModalFirmaInternaParaBajaTarjetaEdit1' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errorModalFirmaInternaParaBajaTarjetaEdit").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errorModalFirmaInternaParaBajaTarjetaEdit').delay(4000).fadeOut('slow'); 
}




function ObtenerSiguienteIdTarjetaDespensaEdit()
{
  waitingDialog.show();
  var txtNumeroIutModal = $("#txtNumeroIutModalEdit").val();
  var IdTarjetaDespensa = $("#idTarjetaDespensaEdit").val();
  var idEndidadFederativaContratacion = $("#IdSucursal").val();
  var contraseniaBajaTarjeta = $("#constraseniaFirmaParaBajaTarjetaHiddenEdit").val();
  var NumEmpBajaTarjeta = $("#NumEmpModalFirmaParaBajaTarjetahiddenEdit").val();
  var ComentarioIut = $("#txtComentarioIutEdit").val();
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
          $("#TarjetaDespensaSiEdit").prop('checked','');
          alert("No Cuentas Con Tarjetas De Despensa En Esta Sucursal Favor De Solicitar Mas Al Encargado De Su Matriz!!");
        }else{
          var NumeroIUTObtenido1 = response.datos[0].idIutTarjeta; 
          var IdTarjetaDespensa1 = response.datos[0].IdTarjetaDespensa; 
          $("#txtNumeroIutModalEdit").val(NumeroIUTObtenido1);
          $("#idTarjetaDespensaEdit").val(IdTarjetaDespensa1);
          $("#txtComentarioIutEdit").val("");
          $("#modalTarjetaDeDespensaEdit").modal();
          waitingDialog.hide();
        }
      }else{
        $("#txtNumeroIutModalEdit").val("");
        $("#idTarjetaDespensaEdit").val("");
        waitingDialog.hide();
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
      waitingDialog.hide();
    }
  });
}

function cancelarFirmaParaBajaTarjetaEdit(){

  $("#modalFirmaElectronicaParaBajaTarjetaEdit").modal("hide");
  $("#modalTarjetaDeDespensaEdit").modal();
  $("#NumEmpModalFirmaParaBajaTarjetaEdit").val("");
  $("#constraseniaFirmaParaBajaTarjetaEdit").val("");
  $("#txtComentarioIutEdit").val("");
}

function CambiarDeModalesIngresoEmpleadoEdit(){

  $("#NumEmpModalFirmaParaEditarEmpleado1").val("");
  $("#constraseniaFirmaParaEditarEmpleado").val("");
  $("#modalFirmaElectronicaParaEditarEmpleado").modal();
  $("#modalTarjetaDeDespensaEdit").modal("hide");

}



function RevisarFirmaInternaParaEditarEmpleado12(){
  var NumEmpModalBaja = $("#NumEmpModalFirmaParaEditarEmpleado1").val();
  var constraseniaFirma = $("#constraseniaFirmaParaEditarEmpleado").val();
 if(NumEmpModalBaja==""){
   cargaerroresFirmaInternaEnvioTarjetaEditarEmpleado12("El numero de empleado no puede estar vacio");
  }else if(constraseniaFirma==""){
     cargaerroresFirmaInternaEnvioTarjetaEditarEmpleado12("Escriba la contraseña para continuar");
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
          cargaerroresFirmaInternaEnvioTarjetaEditarEmpleado12("La Contraseña ingresada es incorrecta favor de escribirla exactamente como la ingreso en el registro");
        }else{
          var nombre = response.datos["0"].nombreEmpleado + " " + response.datos["0"].apellidoPaterno + " " + response.datos["0"].apellidoMaterno;
          var contraseniaInsertadaCifrada =response.datos["0"].ContraseniaFirma;
          $("#txtnumeroFirmaempleadoEdit").val(NumEmpModalBaja);
          $("#ContraseniaFirmaempEdit").val(contraseniaInsertadaCifrada);
          $("#NumEmpModalFirmaParaEditarEmpleado1").val("");
          $("#constraseniaFirmaParaEditarEmpleado").val("");
          AsignarIutAEmpleadoEdit();
        }
      }else{
        alert("error");
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
    });
  }
}
function cargaerroresFirmaInternaEnvioTarjetaEditarEmpleado12(mensaje){
  $('#errorModalFirmaInternaParaEditarEmpleado12').fadeIn();
  msjerrorbaja1="<div id='errorModalFirmaInternaParaEditarEmpleado121' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errorModalFirmaInternaParaEditarEmpleado12").html(msjerrorbaja1);
  $(document).scrollTop(0);
  $("#errorModalFirmaInternaParaEditarEmpleado12").delay(4000).fadeOut('slow'); 
}

function AsignarIutAEmpleadoEdit()
{
  var NumeroIutModal = $("#txtNumeroIutModalEdit").val();
  var ss = document.getElementById("txtnumeroIutEdited");
  ss.style.backgroundColor = "#F31818"; 
  $("#trTarjetaEdit").show();
  $("#txtnumeroIutEdited").val(NumeroIutModal);
  $("#TarjetaDespensaSiEdit").prop('checked','checked');
  $("#TarjetaDespensaNoEdit").prop('checked','');
  $("#modalFirmaElectronicaParaEditarEmpleado").modal("hide");
  alert("Recuerda Continuar Con El Guardado De Tu Modificación Ya Que Aún No Queda Registrada La Asignación De La Tarjeta de Despensa Hasta Que Le Des GUARDAR!!!");
}

function cancelarFirmaParaEnvioDeTarjetaParaEditarEmpleado(){
  $("#modalFirmaElectronicaParaEditarEmpleado").modal("hide");
  $("#modalTarjetaDeDespensaEdit").modal();
  $("#NumEmpModalFirmaParaEditarEmpleado1").val("");
  $("#constraseniaFirmaParaEditarEmpleado").val("");
}

function AbrirModalParaDarDeBajaYCambiarIut(){
  $("#modalFirmaElectronicaDarDeBajaYCambiarIut").modal();
  $("#TarjetaDespensaNoEdit").prop('checked','');
}


function RevisarFirmaInternaParaDarDeBajaYCambiarIut(){
  var NumEmpModalBaja = $("#NumEmpModalFirmaParaDarDeBajaYCambiarIut").val();
  var constraseniaFirma = $("#constraseniaFirmaParaDarDeBajaYCambiarIut").val();
  var ComentarioBajaTarjeta = $("#ComentarioBajaTarjeta").val();
 
 if(NumEmpModalBaja==""){
   cargaerroresFirmaInternaEnvioTarjetaEditarEmpleado("El numero de empleado no puede estar vacio");
  }else if(constraseniaFirma==""){
     cargaerroresFirmaInternaEnvioTarjetaEditarEmpleado("Escriba la contraseña para continuar");
  }else if(ComentarioBajaTarjeta==""){
     cargaerroresFirmaInternaEnvioTarjetaEditarEmpleado("Escriba el motivo del cambio de tarjeta para continuar");
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
          cargaerroresFirmaInternaEnvioTarjetaEditarEmpleado("La Contraseña ingresada es incorrecta favor de escribirla exactamente como la ingreso en el registro");
        }else{
          var nombre = response.datos["0"].nombreEmpleado + " " + response.datos["0"].apellidoPaterno + " " + response.datos["0"].apellidoMaterno;
          var contraseniaInsertadaCifrada =response.datos["0"].ContraseniaFirma;
          $("#txtnumeroFirmaempleadoEdit").val(NumEmpModalBaja);
          $("#ContraseniaFirmaempEdit").val(contraseniaInsertadaCifrada);
          $("#NumEmpModalFirmaParaDarDeBajaYCambiarIut").val("");
          $("#constraseniaFirmaParaDarDeBajaYCambiarIut").val("");
          DarDeBajaIutActualParareasignar();
         // AsignarIutAEmpleadoEdit();
        }
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
    });
  }
}

function DarDeBajaIutActualParareasignar(){
  var NumEmpModalBaja = $("#txtnumeroFirmaempleadoEdit").val();
  var constraseniaFirma = $("#ContraseniaFirmaempEdit").val();
  var ComentarioBajaTarjeta = $("#ComentarioBajaTarjeta").val();
  var txtnumeroIutEdited = $("#txtnumeroIutEditedHidden").val();
    $.ajax({
      type: "POST",
      url: "ajax_darDeBajaIutActual.php",
      data: {"NumEmpModalBaja":NumEmpModalBaja,"constraseniaFirma":constraseniaFirma,"ComentarioBajaTarjeta":ComentarioBajaTarjeta,"txtnumeroIutEdited":txtnumeroIutEdited},
      dataType: "json",
    success: function(response) {
      if (response.status == "success")
      {
        $("#tieneIutConsulta").val("0");
        $("#modalFirmaElectronicaDarDeBajaYCambiarIut").modal("hide");
        $("#txtnumeroIutEdited").val("");
        $("#ComentarioBajaTarjeta").val("");
        if($('#TarjetaDespensaSiEdit').is(":checked")){
         // $("#TarjetaDespensaNoEdit").prop('checked','');
          ObtenerNumeroDeIutSiguienteEdit();
        }else{
          $("#TarjetaDespensaNoEdit").prop('checked','checked');
        }
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
    });
}

function cargaerroresFirmaInternaEnvioTarjetaEditarEmpleado(mensaje){
  $('#errorModalFirmaInternaParaDarDeBajaYCambiarIut').fadeIn();
  msjerrorbaja="<div id='errorModalFirmaInternaParaDarDeBajaYCambiarIut1' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errorModalFirmaInternaParaDarDeBajaYCambiarIut").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errorModalFirmaInternaParaDarDeBajaYCambiarIut').delay(4000).fadeOut('slow'); 
}


function cancelarFirmaParaDarDeBajaYCambiarIut(){
  var tieneiut = $("#tieneIutConsulta").val();
  if(tieneiut=="1"){
    $("#TarjetaDespensaSiEdit").prop('checked','checked');
    $("#TarjetaDespensaNoEdit").prop('checked','');
    $("#trTarjetaEdit").show();
  }else{
    $("#TarjetaDespensaNoEdit").prop('checked','checked');
    $("#TarjetaDespensaSiEdit").prop('checked','');
    $("#trTarjetaEdit").hide();
    $("#txtnumeroIutEdited").val("");
  }  
  $("#modalFirmaElectronicaDarDeBajaYCambiarIut").modal("hide");
}

function generarResponsivaTarjetaDespensa(OpcionDocumento,entidadEmpleado,consecutivoEmpleado,tipoEmpleado)
    {
      if(OpcionDocumento =="0"){
        alert("Debe tener asignada una tarjeta De Despensa Para Despleagar La Responsiva");
      }else{
      window.open("generarResponsivaTarjetaDespensa.php?entidadEmpleado="+entidadEmpleado+"&consecutivoEmpleado="+consecutivoEmpleado+"&tipoEmpleado="+tipoEmpleado+"",'Informe3','fullscreen=no');
      }

    }

$("#IdSucursal").click(function(){
  var IdSucursal = $("#IdSucursal").val();
  var IdSucursalhiddeninput = $("#IdSucursalhiddeninput").val();
  if(IdSucursal == IdSucursalhiddeninput){
    $("#trTarjetaEdit").show();
    $("#TarjetaDespensaSiEdit").prop('checked','checked');
    $("#TarjetaDespensaNoEdit").prop('checked','');
  }else{
    $("#trTarjetaEdit").hide();
    $("#TarjetaDespensaSiEdit").prop('checked','');
    $("#TarjetaDespensaNoEdit").prop('checked','checked');
  }
  //$("#txtnumeroIutEdited").val("");
});

function GetSucursalesIngresadas(){
 
  var EndidadFederativa = $("#idEndidadFederativaParaSucursalEdited").val();
    $.ajax({
      type: "POST",
      url: "ajax_getSucursalesIngresadas.php",
      data: {"EndidadFederativa": EndidadFederativa},
      dataType: "json",
      async:false,
      success: function(response) {
        //console.log(response.placas);
        $("#IdSucursal").empty();
        $('#IdSucursal').append('<option value="0">SUCURSAL</option>');
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#IdSucursal').append('<option value="' + (response.datos[i].idSucursalI) + '">' + response.datos[i].nombreSucursal + '</option>');
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


////////////////////////////////////////////Funciones para Datos Ficales////////////////////////////////////////////////////


function desbloquearDatosFiscales(){
  var CodigoPostalFiscal = $("#CodigoPostalDatosFiscales").val();
  if(CodigoPostalFiscal != ""){
    $("#CodigoPostalDatosFiscales").prop("disabled", false);
  }else{
    CargaDeSelectoresDatosFiscalesEdit(1);
  }
  $("#ColoniaDatosFiscales").prop("disabled", false);
  $("#VialidadDatosFiscales").prop("disabled", false);
  $("#TipoVidalidadDatosFiscales").prop("disabled", false);
  $("#NumExternoDatosFiscales").prop("disabled", false);
  $("#NumInternoDatosFiscales").prop("disabled", false);
  $("#EstadoDoicilioDatosFiscales").prop("disabled", false);
  $("#EntidadDatosFiscales").prop("disabled",false);
  $("#MunicipioDatosFiscales").prop("disabled",false);
  $("#LocalidadDatosFiscales").prop("disabled",false);
  $("#ImagenObtenerCedulaSat").show();
         
  var botones =$('#divButtonGuardarDatosFiscales');                     
  var boton = "<button type='button' class='btn btn-info' id='ButtonGuardarDatosFiscales' name='ButtonGuardarDatosFiscales' onclick='GuardarDatosFiscalesEdicion();'><span class='glyphicon glyphicon-floppy-save' ></span>Guardar</button>";
  botones.append (boton);
  $("#desbloqueoDatosFiscales").remove();
}

function bloquearDatosFiscales(){
  $("#desbloqueoDatosFiscales").remove();
  $("#CodigoPostalDatosFiscales").prop("disabled", true);
  $("#ColoniaDatosFiscales").prop("disabled", true);
  $("#VialidadDatosFiscales").prop("disabled", true);
  $("#TipoVidalidadDatosFiscales").prop("disabled", true);
  $("#NumExternoDatosFiscales").prop("disabled", true);
  $("#NumInternoDatosFiscales").prop("disabled", true);
  $("#EstadoDoicilioDatosFiscales").prop("disabled", true);
  $("#EntidadDatosFiscales").prop("disabled",true);
  $("#MunicipioDatosFiscales").prop("disabled",true);
  $("#LocalidadDatosFiscales").prop("disabled",true);
  $("#ImagenObtenerCedulaSat").hide();
         
  var botones =$('#divEditarDatosFiscales');                     
  var boton = "<button type='button' class='btn btn-success' id='desbloqueoDatosFiscales' name='desbloqueoDatosFiscales' onclick='desbloquearDatosFiscales();'><span class='glyphicon glyphicon-floppy-save' ></span>Editar</button>";
  botones.append (boton);
  $("#ButtonGuardarDatosFiscales").remove();
}



function CargarSelectoresDatosFiscales1Edit(){
  $("#EntidadDatosFiscales").val(0);
  CargaDeSelectoresDatosFiscalesEdit(1);
  CargaDeSelectoresDatosFiscalesEdit(2);
  CargaDeSelectoresDatosFiscalesEdit(3);
}

function CargaDeSelectoresDatosFiscalesEdit(Caso){
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
          $("#EntidadDatosFiscales").html (entidadF);

        }else if(Caso=="2"){
          MunicipioF = "<option value='0'>MUNICIPIOS</option>";
          for (var i = 0; i < datos1.length; i++)
          {
            MunicipioF += "<option value='" + datos1[i].idMunicipio + "'>" + datos1[i].nombreMunicipio + "</option>";
          }
          $("#MunicipioDatosFiscales").html (MunicipioF);
        }else{
          LocalidadF = "<option value='0'>LOCALIDADES</option>";
          for (var i = 0; i < datos1.length; i++)
          {
            LocalidadF += "<option value='" + datos1[i].idAsentamiento + "'>" + datos1[i].nombreAsentamiento + "</option>";
          }
          $("#LocalidadDatosFiscales").html (LocalidadF);
        }
        
      }
    },
    error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
  });
} 

function ObtenerCedulaSat(){

  var documento = $("#IdArchivoHidden").val();
  alert(documento);
  if(documento == ""){
    erroresDatosFiscalesEdit("Achivo NO Cargado, Favor De Realizar La Carga Del Archivo En La Pestaña De 'Documentos Digitalizados(CEDULA SAT)'","error");
  }else{
  window.open("download_file.php?id="+documento+"",'CedulaSat','fullscreen=no');
  }
}


function consultaCpDatosFiscalesEdit() // Se desabilito las acciones del cp debido a la tardanza generada por las consulta es un onkeyou de CodigoPostalDatosFiscales
{
  var codigoPostal = $("#CodigoPostalDatosFiscales").val ();
  $("#multipleDireccionesDatosFiscales").html ("");
  setDatosFiscalesDataEdit ("0","0","0","");
  if (codigoPostal.length != 5)
  {
    return;
  }
  waitingDialog.show();
  CargarSelectoresDatosFiscales1Edit();
  $.ajax({
    type: "POST",
    url: "ajax_obtenerDirecciones.php",
    data: {txtCP : codigoPostal},
    dataType: "json",
    async:false,
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
        setDatosFiscalesDataEdit (direccion.idEntidadFederativa,direccion.idMunicipio,direccion.idAsentamiento,direccion.nombreAsentamiento);
        waitingDialog.hide();
      }
      else
      {
        var displayDirecciones = "";
        for (var i = 0; i < response.listaDirecciones.length; i++)
        {
          var direccion = response.listaDirecciones [i];
          var params = "\"" + direccion.idEntidadFederativa + "\"," +"\"" + direccion.idMunicipio + "\"," +"\"" + direccion.idAsentamiento + "\"," +"\"" + direccion.nombreAsentamiento + "\"";
          displayDirecciones += "<p>" + (i + 1) + "<a href='javascript:setDatosFiscalesDataEdit(" + params + ")';>" +direccion.nombreTipoAsentamiento + " " +direccion.nombreAsentamiento + " " +direccion.nombreMunicipio + ", " +direccion.nombreEntidadFederativa + "</a></p>";
        }
        $("#multipleDireccionesDatosFiscales").html (displayDirecciones);
        waitingDialog.hide();
      }
    },
    error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
      waitingDialog.hide();
    }
  });
}

function setDatosFiscalesDataEdit (idEntidadFederativa, idMunicipio, idAsentamiento, nombreAsentamiento)
{
    $("#EntidadDatosFiscales").val(idEntidadFederativa);
    $("#MunicipioDatosFiscales").val(idMunicipio);
    $("#LocalidadDatosFiscales").val(idAsentamiento);
    $("#ColoniaDatosFiscales").val(nombreAsentamiento);
}

$('#EntidadDatosFiscales').change(function(){
  waitingDialog.show();
  $("#multipleDireccionesDatosFiscales").html ("");
  var EntidadDatosFiscales=$("#EntidadDatosFiscales").val(); 
  $("#MunicipioDatosFiscales").empty();
  $("#LocalidadDatosFiscales").empty();
  $("#ColoniaDatosFiscales").val("");
  $("#CodigoPostalDatosFiscales").val("");
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
        $("#MunicipioDatosFiscales").html (municipioPorEntidad);
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

$('#MunicipioDatosFiscales').change(function(){
  waitingDialog.show();
  var MunicipioDatosFiscales=$("#MunicipioDatosFiscales").val(); 
  $("#LocalidadDatosFiscales").empty();
  $("#ColoniaDatosFiscales").val("");
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
          $("#LocalidadDatosFiscales").html (Localidad);
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

$('#LocalidadDatosFiscales').change(function(){
  waitingDialog.show();
  var LocalidadDatosFiscales=$("#LocalidadDatosFiscales").val(); 
  var LocalidadDatosFiscalesTest = $("#LocalidadDatosFiscales option:selected").text();
  $("#ColoniaDatosFiscales").val(LocalidadDatosFiscalesTest);
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
        $("#CodigoPostalDatosFiscales").val(codigpostalcreado);
        $("#CodigoPostalDatosFiscales").prop("disabled", false);
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

function GuardarDatosFiscalesEdicion(){
  var FolioPreseleccionDatosFiscales = $("#txtSearch").val();
  var CodigoPostalDatosFiscales = $("#CodigoPostalDatosFiscales").val();
  var EntidadDatosFiscales = $("#EntidadDatosFiscales").val();
  var MunicipioDatosFiscales = $("#MunicipioDatosFiscales").val();
  var LocalidadDatosFiscales = $("#LocalidadDatosFiscales").val();
  var ColoniaDatosFiscales = $("#ColoniaDatosFiscales").val();
  var VialidadDatosFiscales = $("#VialidadDatosFiscales").val();
  var TipoVidalidadDatosFiscales = $("#TipoVidalidadDatosFiscales").val();
  var NumExternoDatosFiscales = $("#NumExternoDatosFiscales").val();
  var NumInternoDatosFiscales = $("#NumInternoDatosFiscales").val();
  var EstadoDoicilioDatosFiscales = $("#EstadoDoicilioDatosFiscales").val();
  var entidadFederativaId = $("#numeroEmpleadoEntidadEdited").val();
  var empleadoConsecutivoId = $("#numeroEmpleadoConsecutivoEdited").val();
  var empleadoCategoriaId = $("#numeroEmpleadoTipoEdited").val();
  var caso = "Edicion";
  var documento = $("#IdArchivoHidden").val();
  var largo =( $("#CodigoPostalDatosFiscales").val()).length;
  if(FolioPreseleccionDatosFiscales==""){
    erroresDatosFiscalesEdit("Ingrese El Número Del Empleado A Buscar Para Continuar","error");
  }else if(CodigoPostalDatosFiscales==""){
    erroresDatosFiscalesEdit("Ingrese El Código Postal Correcto De La Cedúla De Situación Fiscal","error");
  }else if(largo!="5"){
    erroresDatosFiscalesEdit("Ingrese El Código Postal Correcto De La Cedúla De Situación Fiscal Minimo 5 Digitos Max 5 Digitos","error");
  }else if(EntidadDatosFiscales=="" || EntidadDatosFiscales=="0"){
    erroresDatosFiscalesEdit("Seleccione La Entidad Federativa Correcta De La Cedúla De Situación Fiscal","error");
  }else if(MunicipioDatosFiscales=="" || MunicipioDatosFiscales=="0"){
    erroresDatosFiscalesEdit("Seleccione El Municipio Correcto De La Cedúla De Situación Fiscal","error");
  }else if(LocalidadDatosFiscales=="" || LocalidadDatosFiscales=="0"){
    erroresDatosFiscalesEdit("Seleccione La Localidad Correcta De La Cedúla De Situación Fiscal","error");
  }else if(ColoniaDatosFiscales==""){
    erroresDatosFiscalesEdit("Ingrese La Colonia De La Cedúla De Situación Fiscal","error");
  }else if(VialidadDatosFiscales==""){
    erroresDatosFiscalesEdit("Ingrese El Nombre De La Vialidad Correcta De La Cedúla De Situación Fiscal","error");
  }else if(TipoVidalidadDatosFiscales==""){
    erroresDatosFiscalesEdit("Ingrese El Tipo De La Vialidad Correcta De La Cedúla De Situación Fiscal","error");
  }else if(NumExternoDatosFiscales==""){
    erroresDatosFiscalesEdit("Ingrese El Número Exterior Correcto De La Cedúla De Situación Fiscal","error");
  }else if(NumInternoDatosFiscales==""){
    erroresDatosFiscalesEdit("Ingrese El Número Interior Correcto De La Cedúla De Situación Fiscal","error");
  }else if(EstadoDoicilioDatosFiscales=="" || EstadoDoicilioDatosFiscales=="0" || EstadoDoicilioDatosFiscales=="null" || EstadoDoicilioDatosFiscales==null || EstadoDoicilioDatosFiscales=="NULL"){
    erroresDatosFiscalesEdit("Ingrese El Estado De Domicilio Correcto De La Cedúla De Situación Fiscal","error");
  }else if(documento == ""){
    alert("Achivo NO Cargado, Favor De Realizar La Carga Del Archivo En La Pestaña De 'Documentos Digitalizados(CEDULA SAT)'");
  }else{
    $.ajax({
      type: "POST",
      url: "ajax_registroDatosFiscales.php",
      data: {"FolioPreseleccionDatosFiscales":FolioPreseleccionDatosFiscales,"CodigoPostalDatosFiscales":CodigoPostalDatosFiscales,"EntidadDatosFiscales":EntidadDatosFiscales,"MunicipioDatosFiscales":MunicipioDatosFiscales,"LocalidadDatosFiscales":LocalidadDatosFiscales,"ColoniaDatosFiscales":ColoniaDatosFiscales,"VialidadDatosFiscales":VialidadDatosFiscales,"TipoVidalidadDatosFiscales":TipoVidalidadDatosFiscales,"NumExternoDatosFiscales":NumExternoDatosFiscales,"NumInternoDatosFiscales":NumInternoDatosFiscales,"EstadoDoicilioDatosFiscales":EstadoDoicilioDatosFiscales,"entidadFederativaId":entidadFederativaId,"empleadoConsecutivoId":empleadoConsecutivoId,"empleadoCategoriaId":empleadoCategoriaId,"caso":caso},
      dataType: "json",
      async:false,
      success: function(response) {
        var mensaje=response.message;
        if (response.status=="success") {
          erroresDatosFiscalesEdit(mensaje,"success");
          bloquearDatosFiscales();
          $("#multipleDireccionesDatosFiscales").html ("");
          waitingDialog.hide();
        }else if (response.status=="error"){
          erroresDatosFiscalesEdit(mensaje,"error");
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
}

function erroresDatosFiscalesEdit(mensaje,tipo){
  $('#MesjaeErrorDatosFiscalesEdit').fadeIn();
  msjerrorbaja="<div id='MesjaeErrorDatosFiscalesEdit1' class='alert alert-"+tipo+"'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";         
  $("#MesjaeErrorDatosFiscalesEdit").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#MesjaeErrorDatosFiscalesEdit').delay(4000).fadeOut('slow');
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////// Validacion Firma Alta Empleado ///////////////////////////////////

function RevisarFirmaInternaParaReingresoEmpleado(){
  var NumEmpModalBaja = $("#NumEmpModalFirmaParaReingresoEmpleado").val();
  var constraseniaFirma = $("#constraseniaFirmaParaReingresoEmpleado").val();
  if(NumEmpModalBaja==""){
    cargaerroresFirmaInternaReingresoEmpleado("El numero de empleado no puede estar vacio");
  }else if(constraseniaFirma==""){
    cargaerroresFirmaInternaReingresoEmpleado("Escriba la contraseña para continuar");
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
            cargaerroresFirmaInternaReingresoEmpleado("La Contraseña ingresada es incorrecta favor de escribirla exactamente como la ingreso en el registro");
          }else{
            var contraseniaInsertadaCifrada =response.datos["0"].ContraseniaFirma;
            $("#constraseniaFirmaParaReingresoEmpleadoHidden").val(contraseniaInsertadaCifrada);
            $("#NumEmpModalFirmaParaReingresoEmpleadohidden").val(NumEmpModalBaja);
            $("#modalFirmaReingresosEmpleado").modal("hide");
            $("#NumEmpModalFirmaParaReingresoEmpleado").val("");
            $("#constraseniaFirmaParaReingresoEmpleado").val("");
            $('#myModalReingresoEmpleado').modal();
          }
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
    });
  }
}

function cargaerroresFirmaInternaReingresoEmpleado(mensaje){
  $('#errormodalFirmaReingresoEmpleado').fadeIn();
  msjerrorbaja="<div id='errormodalFirmaReingresoEmpleado1' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errormodalFirmaReingresoEmpleado").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errormodalFirmaReingresoEmpleado').delay(4000).fadeOut('slow'); 
}

function cancelarFirmaParaReingresoEmpleado(){

  $("#modalFirmaReingresosEmpleado").modal("hide");
  $("#NumEmpModalFirmaParaReingresoEmpleado").val("");
  $("#constraseniaFirmaParaReingresoEmpleado").val("");
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////

 ////////////////////////// Consulta Temporal Datos Fiscales /////////////////////////////////////////////

 function obtenerDatosFiscalesGeneral(){
  waitingDialog.show();
  BorrarDatosFiscales();
  var numeroEmpleado = $("#txtSearch").val();
  if(numeroEmpleado != ""){
    $.ajax({
      type: "POST",
      url: "ajax_ObtenerDatosFiscalesGeneralTemporal.php",
      data: {"numeroEmpleado":numeroEmpleado},
      dataType: "json",
      success: function(response) {
        if (response.status == "success")
        {
          var RespuestaLargo = response["datos"].length;
          if(RespuestaLargo == "0"){
            alert("No Se Encontraron Datos Con El Numero De Empleado: "+numeroEmpleado);
            CargaDeSelectoresDatosFiscalesEdit(1);
            waitingDialog.hide();
          }else{
            CargarSelectoresDatosFiscales1Edit(); 
            var CodigoPostalFiscal = response.datos["0"].CodigoPostalDF;
            var IdEntidadFiscal = response.datos["0"].EntidadFedDF;
            var IdmunicipioFiscal = response.datos["0"].MunicipioDF;
            var LocalidadFiscal = response.datos["0"].LocalidadDF;
            var ColoniaFiscal = response.datos["0"].ColoniaDF;
            var VialidadFiscal = response.datos["0"].VialidadDF;
            var TipoVialidadFiscal = response.datos["0"].TipoVialidadDF;
            var NumeroExtFiscal = response.datos["0"].NumeroExternoDF;
            var NumeroIntFiscal = response.datos["0"].NumeroInternoDF;
            var EstadoDomicilioFiscal = response.datos["0"].EstadoDeDomicilioDF;
            //var contraseniaInsertadaCifrada =response.datos["0"].ContraseniaFirma;
            $("#CodigoPostalDatosFiscales").val(CodigoPostalFiscal);
            $("#EntidadDatosFiscales").val(IdEntidadFiscal);
            $("#MunicipioDatosFiscales").val(IdmunicipioFiscal);
            $("#LocalidadDatosFiscales").val(LocalidadFiscal);
            $("#ColoniaDatosFiscales").val(ColoniaFiscal);
            $("#VialidadDatosFiscales").val(VialidadFiscal);
            $("#TipoVidalidadDatosFiscales").val(TipoVialidadFiscal);
            $("#NumExternoDatosFiscales").val(NumeroExtFiscal);
            $("#NumInternoDatosFiscales").val(NumeroIntFiscal);
            $("#EstadoDoicilioDatosFiscales").val(EstadoDomicilioFiscal);
            waitingDialog.hide();
          }
        }else{
          alert("Error En La Busqueda de Datos Fiscales");
          waitingDialog.hide();
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
        waitingDialog.hide();
      }
    });
  }else{
    waitingDialog.hide();
    alert("Ingresa El Numero Del Empleado A Buscar");
  }
  
}

function BorrarDatosFiscales(){
  $("#multipleDireccionesDatosFiscales").html ("");
  $("#CodigoPostalDatosFiscales").val("");
  $("#EntidadDatosFiscales").empty();
  $("#MunicipioDatosFiscales").empty();
  $("#LocalidadDatosFiscales").empty();
  $("#ColoniaDatosFiscales").val("");
  $("#VialidadDatosFiscales").val("");
  $("#TipoVidalidadDatosFiscales").val("");
  $("#NumExternoDatosFiscales").val("");
  $("#NumInternoDatosFiscales").val("");
  $("#EstadoDoicilioDatosFiscales").val(0);
}
 
 //Nuevas Funciones checks Documentos AlReingresar Al Em¿lemento/////////

function BorrarDocumentosEntregadosAnteriormente(){
  var numeroEmpleado = $("#txtSearch").val();
  var explEmp = numeroEmpleado.split("-");
  var empleadoEntidad = explEmp[0];
  var empleadoConsecutivo = explEmp[1];
  var empleadoCategoria = explEmp[2];
  $.ajax({
      type: "POST",
      url: "ajax_DeleteDocumentacionAnterior.php",
      data: {"numeroEmpleadoEntidad":empleadoEntidad, "numeroEmpleadoConsecutivo":empleadoConsecutivo, "numeroEmpleadoTipo":empleadoCategoria},
      dataType: "json",
      success: function(response) {
        if (response.status == "success")
        {
          registrarEntregaDocumentosOriginalesReingreso();
          registrarEntregaDocumentosCopiasReingreso();
          $('#myModalDpocReingreso').modal('hide');
        }else{
          alert("No Se Pudo Agregar Correctamente Los Cehcks De Los Documentos");
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
    });  
}

function LimpiarChecks(){//Limpia Los Checks antes De La Consulta para Que no esten Pegados Con La Consulta Anterior
  var largotabladocuemtnos =$("#tablaChecksEntregados tr").length;
  var largoDocuemtnos = largotabladocuemtnos-2;// se Quitan dos por el titulo y el boton quedando unicamente el largo de los documentos obtenidos incialmente
  for(var i=1; i <= largoDocuemtnos; i++){
      $("#documentoRecibidosOriginal_"+i).prop('checked','');
      $("#documentoRecibidosCopia_"+i).prop('checked','');
    }
}


function registrarEntregaDocumentosOriginalesReingreso(){
  var numeroEmpleado = $("#txtSearch").val();
  var explEmp = numeroEmpleado.split("-");
  var empleadoEntidad = explEmp[0];
  var empleadoConsecutivo = explEmp[1];
  var empleadoCategoria = explEmp[2];  
  var tipoDocumento = 1;
  var documentoId=0;
  var idEstatusDocumentos=0;
  <?php
  if (isset($catalogoDocumentos)) {
    for ($i = 1; $i <= count($catalogoDocumentos); $i++) {
  ?>
      if($("#checkOriginalesEdit<?php echo $i; ?>").is(':checked')) {
        documentoId= $("#checkOriginalesEdit<?php echo $i; ?>").val() ;
        idEstatusDocumentos=1;
        $.ajax({
          type: "POST",
          url: "ajax_registrarDocumentacion.php",
          data: {"numeroEmpleadoEntidad":empleadoEntidad, "numeroEmpleadoConsecutivo":empleadoConsecutivo, "numeroEmpleadoTipo":empleadoCategoria, documentoId:documentoId, tipoDocumento:tipoDocumento, "idEstatusDocumentos":idEstatusDocumentos},
          dataType: "json",
          error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
          }
        });
      }
  <?php
    } // for
  } // if
  ?>
}


function registrarEntregaDocumentosCopiasReingreso(){
  var numeroEmpleado = $("#txtSearch").val();
  var explEmp = numeroEmpleado.split("-");
  var empleadoEntidad = explEmp[0];
  var empleadoConsecutivo = explEmp[1];
  var empleadoCategoria = explEmp[2];  
  var empleadoCategoria = explEmp[2];  
  var tipoDocumento = 2;
  var documentoId=0;
  var idEstatusDocumentos=0;
  <?php
  if (isset($catalogoDocumentos)) {
    for ($i = 1; $i <= count($catalogoDocumentos); $i++) {
  ?>
      if($("#checkCopiaEdit<?php echo $i; ?>").is(':checked')) {
        documentoId= $("#checkCopiaEdit<?php echo $i; ?>").val() ;
        idEstatusDocumentos=1;
        $.ajax({
          type: "POST",
          url: "ajax_registrarDocumentacion.php",
          data: {"numeroEmpleadoEntidad":empleadoEntidad, "numeroEmpleadoConsecutivo":empleadoConsecutivo, "numeroEmpleadoTipo":empleadoCategoria, documentoId:documentoId, tipoDocumento:tipoDocumento, "idEstatusDocumentos":idEstatusDocumentos},
          dataType: "json",
          error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
          }
        });
      } 
  <?php
    } // for
  } // if
  ?>
}

function ConsultaChecksIngresadosInicialmente(){
  BloquearChecksDocumentosEntregados();
  var empleado=$("#txtSearch").val();
  $.ajax({
    type: "POST",
    url: "ajax_ObtenerDocumentosRecibidos.php",
    data: {"empleado":empleado},
    dataType: "json",
    success: function(response) {
      if (response.status == "success")
      {
        var largoDocumentos = response.datos.length;
        if(largoDocumentos > "0"){
          for(var i=0; i < largoDocumentos; i++){
            var idDocumento = response.datos[i]["idDocumento"];
            var idTipoDocumento = response.datos[i]["idTipoDocumento"];
            if(idTipoDocumento=="1"){
              $("#documentoRecibidosOriginal_"+idDocumento).prop('checked','cheked');
            }else{
              $("#documentoRecibidosCopia_"+idDocumento).prop('checked','cheked');
            }
          }
        }
      }else{
        alert("No Se Pudo Agregar Correctamente Los Cehcks De Los Documentos");
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }
  });  
}
function BloquearChecksDocumentosEntregados(){
  var largotabladocuemtnos =$("#tablaChecksEntregados tr").length;
  var largoDocuemtnos = largotabladocuemtnos-2;// se Quitan dos por el titulo y el boton quedando unicamente el largo de los documentos obtenidos incialmente
  for(var i=1; i <= largoDocuemtnos; i++){
      $("#documentoRecibidosOriginal_"+i).prop('disabled',true);
      $("#documentoRecibidosCopia_"+i).prop('disabled',true);
    }
  $("#tdbtnEditarDocuemntosChecks").show();
  $("#tdbtnGuardarDocuemntosChecks").hide();
}
function DesbloquearChecksDocumentosEntregados(){
  var largotabladocuemtnos =$("#tablaChecksEntregados tr").length;
  var largoDocuemtnos = largotabladocuemtnos-2;// se Quitan dos por el titulo y el boton quedando unicamente el largo de los documentos obtenidos incialmente
  for(var i=1; i <= largoDocuemtnos; i++){
    $("#documentoRecibidosOriginal_"+i).prop('disabled',false);
    $("#documentoRecibidosCopia_"+i).prop('disabled',false);
  }
  $("#tdbtnEditarDocuemntosChecks").hide();
  $("#tdbtnGuardarDocuemntosChecks").show();
}
function EditarDocumentosEntegados(){
  DesbloquearChecksDocumentosEntregados();
}

function GuardarDocumentosEntegados(){
  var numeroEmpleado = $("#txtSearch").val();
  if(numeroEmpleado==""){
    alert("Ingresa EL Numero De Empleado");
  }else{
    var explEmp = numeroEmpleado.split("-");
    var empleadoEntidad = explEmp[0];
    var empleadoConsecutivo = explEmp[1];
    var empleadoCategoria = explEmp[2];
    $.ajax({
      type: "POST",
      url: "ajax_DeleteDocumentacionAnterior.php",
      data: {"numeroEmpleadoEntidad":empleadoEntidad, "numeroEmpleadoConsecutivo":empleadoConsecutivo, "numeroEmpleadoTipo":empleadoCategoria},
      dataType: "json",
      success: function(response) {
        if (response.status == "success")
        {
          registrarEntregaDocumentosOriginalesDocumentosD();
          registrarEntregaDocumentosCopiasDocumentosD();
        }else{
          alert("No Se Pudo Agregar Correctamente Los Cehcks De Los Documentos");
        }
      },error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
    });  
    BloquearChecksDocumentosEntregados();
  }
}

function registrarEntregaDocumentosOriginalesDocumentosD(){
  var numeroEmpleado = $("#txtSearch").val();
  var explEmp = numeroEmpleado.split("-");
  var empleadoEntidad = explEmp[0];
  var empleadoConsecutivo = explEmp[1];
  var empleadoCategoria = explEmp[2];  
  var tipoDocumento = 1;
  var documentoId=0;
  var idEstatusDocumentos=0;
  <?php
  if (isset($catalogoDocumentos)) {
    for ($i = 1; $i <= count($catalogoDocumentos); $i++) {
  ?>
      if($("#documentoRecibidosOriginal_<?php echo $i; ?>").is(':checked')) {
        documentoId= $("#documentoRecibidosOriginal_<?php echo $i; ?>").val();
        idEstatusDocumentos=1;
        $.ajax({
          type: "POST",
          url: "ajax_registrarDocumentacion.php",
          data: {"numeroEmpleadoEntidad":empleadoEntidad, "numeroEmpleadoConsecutivo":empleadoConsecutivo, "numeroEmpleadoTipo":empleadoCategoria, documentoId:documentoId, tipoDocumento:tipoDocumento, "idEstatusDocumentos":idEstatusDocumentos},
          dataType: "json",
          error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
          }
        });
      }
  <?php
    } // for
  } // if
  ?>
}


function registrarEntregaDocumentosCopiasDocumentosD(){
  var numeroEmpleado = $("#txtSearch").val();
  var explEmp = numeroEmpleado.split("-");
  var empleadoEntidad = explEmp[0];
  var empleadoConsecutivo = explEmp[1];
  var empleadoCategoria = explEmp[2];  
  var empleadoCategoria = explEmp[2];  
  var tipoDocumento = 2;
  var documentoId=0;
  var idEstatusDocumentos=0;
  <?php
  if (isset($catalogoDocumentos)) {
    for ($i = 1; $i <= count($catalogoDocumentos); $i++) {
  ?>
      if($("#documentoRecibidosCopia_<?php echo $i; ?>").is(':checked')) {
        documentoId= $("#documentoRecibidosCopia_<?php echo $i; ?>").val();
        idEstatusDocumentos=1;
        $.ajax({
          type: "POST",
          url: "ajax_registrarDocumentacion.php",
          data: {"numeroEmpleadoEntidad":empleadoEntidad, "numeroEmpleadoConsecutivo":empleadoConsecutivo, "numeroEmpleadoTipo":empleadoCategoria, documentoId:documentoId, tipoDocumento:tipoDocumento, "idEstatusDocumentos":idEstatusDocumentos},
          dataType: "json",
          error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
          }
        });
      }
  <?php
    } // for
  } // if
  ?>
}
 ////////////////////////////////////////////////////////////////////////////////////////////////////////

 function guardarHistoricoCambioPS(NumEmpModalBaja,constraseniaFirma){

  var entidadEmp=$("#numeroEmpleadoEntidadEdited").val();
  var consecutivoEmp=$("#numeroEmpleadoConsecutivoEdited").val();
  var categoriaEmp=$("#numeroEmpleadoTipoEdited").val();
  var psActual = $("#pshidden").val();
  var psNuevo  = $("#selectPuntoServicioEdited").val();
  
  $.ajax({
      type: "POST",
      url: "ajax_InsertHistoricoCambioPS.php",
      data:{"entidadEmp":entidadEmp,"consecutivoEmp":consecutivoEmp,"categoriaEmp":categoriaEmp,"psActual":psActual,"psNuevo":psNuevo,"NumEmpModalBaja":NumEmpModalBaja,"constraseniaFirma":constraseniaFirma},
      dataType: "json",
      success: function(response) {
        if (response.status == "success")
        {
            $("#NumEmpModalFirmaParaCambioPs").val("");
            $("#constraseniaFirmaParaConfirmacionCambioPS").val("");
          // editarDatosGenerales();
        }else{
          alert("No Se Pudo insertar en historico PS");
        }
      },error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
    });  
}


//////////////// Se agrega al hacer el cambio del punto para validar si el empleado esta en algun proceso detener el cambio si no dejarlo pasar //////////////////////

function ObtenerestatusEmpleados(){
  var Entidad = $("#numeroEmpleadoEntidadEdited").val();
  var Categoria = $("#numeroEmpleadoConsecutivoEdited").val();
  var Tipo = $("#numeroEmpleadoTipoEdited").val();
  var numeroEmpleado = Entidad+"-"+Categoria+"-"+Tipo;
  var ValidacionesEstatusEmpleadoCambioDePunto = 0;
  $.ajax({
    type: "POST",
    url: "ajax_obtenerEstatusEmpleado.php",
    data: {"numeroEmpleado":numeroEmpleado},
    dataType: "json",
    async:false,
    success: function(response) {
      if (response.status == "success")
      {
        ValidacionesEstatusEmpleadoCambioDePunto = response.accion;
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }
  }); 
  if(ValidacionesEstatusEmpleadoCambioDePunto == 1 || ValidacionesEstatusEmpleadoCambioDePunto == 0){
    swal("Alto", "Por Proceso: El tiempo de movimiento aun NO se tiene la confirmación","error");
    verificaConsultaEmpleado();
    // limpiarFormulario()
  }
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function cunsultaRPpuntoServ(){
  
  var rpActual = $("#rpHidden").val();
  var nuevoPS = $("#selectPuntoServicioEdited").val();

  var ValidacionRP=0;
  var banderaCambioRP=0;
 
  $.ajax({
    type: "POST",
    url: "ajax_consultaRPxPS.php",
    data: {"rpActual":rpActual, "nuevoPS":nuevoPS},
    dataType: "json",
    async:false,
    success: function(response) {
      if (response.status == "success")
      {
        ValidacionRP = response.accion;
        rpNuevo = response.rp;
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }
  }); 
  if(ValidacionRP == 1){//solo si cambia el rp se hace
     banderaCambioRP='1';
  }
}

function GuardarMovimientoPlantillaHistorico(TipoMovimiento,idHorario){

  var bandera="0";
  if(TipoMovimiento=="BAJA"){
    var bandera="1";
    var idPlantillaSeleccionada = $("#selplantillaserv").val();
    var PuntoServicioSeleccionado = $("#selectPuntoServicioEdited").val();
  }else if(TipoMovimiento=="REINGRESO"){
    var bandera="1";
    var idPlantillaSeleccionada = $("#selplantillaservicioreingreso").val();
    var PuntoServicioSeleccionado = $("#selectPuntoServicioModalR").val();
  }else{
    var idPlantillaSeleccionada = $("#selplantillaserv").val();
    var plantillaOriginal = $("#txtidPlantillaOriginal").val();
    var PuntoServicioSeleccionado = $("#selectPuntoServicioEdited").val();
    if(idPlantillaSeleccionada != plantillaOriginal ){
      var bandera="1";
    }
  }
  if(bandera=="1"){
    
    var EntidadEmp = $("#numeroEmpleadoEntidadEdited").val();
    var CategoriaEmp = $("#numeroEmpleadoConsecutivoEdited").val();
    var TipoEmp = $("#numeroEmpleadoTipoEdited").val();
    
    $.ajax({
      type: "POST",
      url: "ajax_RegistrarHistoricoMovPorPlantilla.php", 
      data: {"idPlantillaSeleccionada":idPlantillaSeleccionada,"PuntoServicioSeleccionado":PuntoServicioSeleccionado,"EntidadEmp":EntidadEmp,"CategoriaEmp":CategoriaEmp,"TipoEmp":TipoEmp,"TipoMovimiento":TipoMovimiento,"idHorarioPlantilla":idHorario},
      dataType: "json",
      async:false,
      success: function(response) {
        if (response.status != "success")
        {
          alert(response.message);
        }else{
          
        }
      },error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }
}


function obtenerHorariosPorPlantillaEdicion(idPlantilla,opcion,idHoario){
  $.ajax({
    type: "POST",
    url: "HorariosAdmin/ajax_ConsultarCatalogoHorariosPorPlantilla.php",
    data: {idPlantilla},
    dataType: "json",
    async: false,
    success: function(response) {
      if (response.status == "success")
      {
        var datos = response.datos;
        for (var i = 0; i < datos.length; i++)
        {
          if(opcion =="1" || opcion ==1 || opcion =="11" || opcion ==11){// Edicion
            $('#selHorarioCons').append('<option value="' + response.datos[i].idHorarios + '">' + response.datos[i].Jornada +  '_ENTRADA: ' + response.datos[i].HoraEntrada + ' SALIDA: ' + response.datos[i].Horasalida +'</option>'); //verificar que rollo con esto
          }else if(opcion =="2" || opcion ==2){// reingreso
            $('#selHorarioReingreso').append('<option value="' + response.datos[i].idHorarios + '">' + response.datos[i].Jornada +  '_ENTRADA: ' + response.datos[i].HoraEntrada + ' SALIDA: ' + response.datos[i].Horasalida +'</option>'); //verificar que rollo con esto
          }
        }
        if(opcion =="1" || opcion ==1){ // Edicion
          $('#selHorarioCons').val(idHoario);
        }
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }
  });
}

$("#selplantillaservicioreingreso").change(function(){
  var selplantillaservicioreingreso = $("#selplantillaservicioreingreso").val();
  obtenerHorariosPorPlantillaEdicion(selplantillaservicioreingreso,2,0);
}); 








</script>
