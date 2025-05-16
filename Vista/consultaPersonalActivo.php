

<div class="container2" align="center"  > <!--   <div class="container2" align="center" style="background:pink" >Inicia div contaires 2-->
<form action="ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
  <input type="text" name="txtSearch" id="txtSearch"class="search-query" placeholder="Buscar" aria-describedby="basic-addon2" onkeyup="verificaConsultaEmpleado();" onblur=""><img src="img/search.png">
  <center>
  <!--<fieldset>

	 <STRONG>CONSULTA <input type="date" id="fechaConsulta1" onChange='obtenerListaVisitantesConFechaDe();' class='input-medium' ></input> </STRONG>
  </fieldset> -->
  </center>

  <div id="listaDePersonalActivo" >
	
  </div>

</br>
</br>
</br>


<div class="row" > <!--Inicia div row-->


  <div class="span8"  > <!--Inicia Div Datos Generales-->
    <table >
        
        <tr >
          <td><label class=" control-label label " for="numeroEmpleado">N. Empleado</label> </td>
          <td> <input id="numeroEmpleadoEntidadEdited" name="numeroEmpleadoEntidadEdited" type="text" placeholder="00" class="input-mini-mini" maxlength="2" >-
              <input id="numeroEmpleadoConsecutivoEdited" name="numeroEmpleadoConsecutivoEdited" type="text" placeholder="0000" class="input-small-mini" maxlength="4"> -
              <input id="numeroEmpleadoTipoEdited" name="numeroEmpleadoTipoEdited" type="text" placeholder="00" class="input-mini-mini" maxlength="2">
          </td>
          <td rowspan="7"> <img src="../img/09516003.jpg" alt="" class="img-rounded"></td>
        </tr>
        <tr>
          <td><label class="control-label label " for="apellidoPaternoEmpleado">Apellido Paterno</label></label> </td>
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
          <td><label class="control-label label" for="numeroSeguroSocial">Numero SS</label></td>
          <td><input id="numeroSeguroSocialEdited" name="numeroSeguroSocialEdited" type="text" placeholder="Solo letras" class="input-large" maxlength="11" ></td>
        </tr>
        <tr>
          <td><label class="control-label label" for="numeroCta">Numero Cta</label></td>
          <td><input id="txtNumeroCtaEdited" name="txtNumeroCtaEdited" type="text" placeholder="Solo letras" class="input-large" maxlength="14" ></td>
        </tr>
        <tr>
          <td><label class="control-label label" for="numeroCta">Numero Cta Clabe</label></td>
          <td><input id="txtCtaClabeEdited" name="txtCtaClabeEdited" type="text" placeholder="Solo letras" class="input-large" maxlength="18" ></td>
        </tr>
        <tr>
          <td><label class="control-label label" for="fechaIngreso">Fecha Ingreso</label></td>
          <td><input id="fechaIngresoEdited" name="fechaIngresoEdited" type="date" class="input-medium"></td>
        </tr>
        <tr>
          <td><label class="control-label label" for="entidadFederativa" >Entidad Federativa Labor</label></td>
          <td><select id="idEndidadFederativaEdited" name="idEndidadFederativaEdited" class="input-large " onChange="obtenerListaPuntosServiciosPorEntidad();" >
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
          <td><label class="control-label label" for="tipoPuesto">Tipo Puesto</label></td>
          <td>
            <select id="tipoPuestoEdited" name="tipoPuestoEdited" class="input-large " onChange="seleccionarTipoPuesto1();">
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
        <tr>
          <td><label class="control-label label" for="puesto">Puesto</label></td>
          <td> 
            <select id="puestoEdited" name="puestoEdited" class="input-large" >
          </td>
        </tr>
        <tr>
          <td><label class="control-label label" for="Dirigente">Jefe/Supervisor</label></td>
          <td><select id="dirigenteEdited" name="dirigenteEdited" class="input-large"></select></td>
          <td><div id="divdirigentes" ></div></td>
        </tr>
        <tr>
          <td><label class="control-label label" for="PuntodeServicio">Punto de Servicio</label></td>
          <td><select id='selectPuntoServicioEdited' class='input-large'><option>PUNTO DE SERVICIO</option></select></td>
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
          <td><label class="control-label label" for="Sexo">Sexo</label></td>
          <td>
            <?php
            for ( $i=0; $i<count($catalogoGeneros); $i++)
            {
              echo "<div class='radio'><input type='radio' name='genero' id='".$catalogoGeneros[$i]["idGenero"] ."genero' value='".$catalogoGeneros[$i]["idGenero"] ."' >".$catalogoGeneros[$i]["nomenclaturaGenero"]."</div>";
            }
            ?>
          </td>
        </tr>

        <tr>
          <td></td>
          <td><button id="guardar" name="guardar" class="btn btn-info" type="button" onclick="guardarSubmit(); obtenerListaVisitantesDelDia(0, 10); obtenerNumeroPaginas();"> <span class="glyphicon glyphicon-floppy-save"></span>Guardar</button>
            <button id="desbloqueoDatosGenerales" name="desbloqueoDatosGenerales" class="btn btn-success" type="button" onclick="desbloquearDatosGenerales();"> <span class="glyphicon glyphicon-refresh"></span>Editar</button></td>
          <!--<button id="cancelar" name="guardar" class="btn btn-danger" type="button" onclick="clearForm();" > <span class="glyphicon glyphicon-remove"></span>Cancelar</button>-->
          </td>
        </tr>
      </table>
  </div> <!--Fin Div Datos Generales-->

  <div class="span6" align="left"> <!--Inicia Div Datos Personales-->
<table >
        <tr>
          <td><label class="control-label label " for="fechaNacimiento">Fecha Nacimiento</label></label> </td>
          <td><input id="txtFechaNacimientoEdited" name="txtFechaNacimiento" type="date"  class="input-medium"></td>
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
        <td><select id="selectEntidadNacimientoEdited" name="selectEntidadNacimientoEdited" class="input-large" onChange="consultarMunicipiosPorEntidad();" >
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
        <td><input id="txtMunicipioNacEdited" name="txtMunicipioNacEdited" type="text" placeholder="Municipio Nacimiento" class="input-large"></td>
      </tr>
      <tr>
        <td ><label class="control-label label" for="curp">CURP</label></td>
        <td><input id="txtCurpEdited" name="txtCurpEdited" type="text" placeholder="" class="input-large" maxlength="18"></td>
      </tr>
      <tr>
        <td ><label class="control-label label" for="rfc">RFC</label></td>
        <td><input id="txtRfcEdited" name="txtRfcEdited" type="text"  class="input-large" maxlength="13"></td>
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
            echo "<div class='radio'><input type='radio' name='estatusCartilla' id='".$catalogoEstatusCartilla[$i]["idEstatusCartilla"] ."estatusCartillaEdited' value='".$catalogoEstatusCartilla[$i]["idEstatusCartilla"] ."' >".$catalogoEstatusCartilla[$i]["descripcionEstatusCartilla"]."</div>";
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
        <td><button id="btnGuardarDatosPersonales" name="btnGuardarDatosPersonales" class="btn btn-primary" type="button" onclick="guardarDatosPersonalesSubmit();"> <span class="glyphicon glyphicon-floppy-save"></span>Guardar</button>
        </td>
      </tr>
      
      
    </table>
  </div> <!--Fin  Div Datos Personales-->




  <div class="span6"  > <!--Inicia Div Datos Directorio-->
    <table align="center" >
        <tr>
          <td><label class="control-label label " for="cp">C.P Vivienda</label></label> </td>
          <td>
            <input id="txtCPEdited" name="txtCPEdited" type="text"  class="input-large"  maxlength="5" onkeyup="consultaCP();">
            <input id="txtIdAsentamientoEdited" name="txtIdAsentamientoEdited" type="hidden" />
          </td>
          <td>&nbsp;</td>
          <td style="width:400px;" rowspan="13" valign="top"><div id="multipleDirecciones"></div></td>
        </tr>
        <tr >
          <td ><label class="control-label label" for="Entidad">Entidad</label></td>
          <td><input id="txtEntidadViviendaEdited" name="txtEntidadViviendaEdited" type="text"  class="input-large" readonly></td>
        </tr>
        <tr>
          <td ><label class="control-label label" for="municipio">Municipio</label></td>
          <td><input id="txtMunicipioViviendaEdited" name="txtMunicipioViviendaEdited" type="text" placeholder="Municipio" class="input-large" readonly></td>
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
          <td><input id="txtTelefonoFijoEdited" name="txtTelefonoFijoEdited" type="text" class="input-large"></td>
        </tr>
        <tr>
          <td ><label class="control-label label" for="TelefonoMovil">Telefono Movil</label></td>
          <td><input id="txtTelefonoMovilEdited" name="txtTelefonoMovilEdited" type="text"  class="input-large"></td>
       </tr>
       <tr>
        <td ><label class="control-label label" for="correo">Correo</label></td>
        <td><input id="txtCorreoEdited" name="txtCorreoEdited" type="text"  class="input-large-email"></td>
       </tr>
       <tr>
        <td ><label class="control-label label" for="delegacion">Delegacion UMF</label></td>
        <td>
          <select id="selectDelegacion" name="selectDelegacion" class="input-medium">
            <option>DELEGACION</option>
          </select>
        </td>
      </tr>
      <tr>
        <td ><label class="control-label label" for="subdelegacion">Subdelegacion UMF</label></td>
        <td>
          <select id="selectSubdelegacion" name="selectSubdelegacion" class="input-medium">
            <option>SUBDELEGACION</option>
          </select>
        </td>
      </tr>
      <tr>
        <td ><label class="control-label label" for="subdelegacion">UMF</label></td>
        <td>
          <select id="selectUmf" name="selectUmf" class="input-medium">
            <option>UMF</option>
          </select>
        </td>
      </tr>
      <tr>
        <td ><label class="control-label label" for="subdelegacion">Descripción UMF</label></td>
        <td>
          <select id="descripcionUmf" name="descripcionUmf" class="input-medium">
            <option>Descripcion UMF</option>
          </select>
        </td>
      </tr>
      <tr>
        <td></td>
        <td>
          <button id="btnGuardarDatosDireccion" name="btnGuardarDatosDireccion" class="btn btn-primary" type="button" onclick="guardarDatosDireccionSubmit();"> <span class="glyphicon glyphicon-floppy-save"></span>Guardar</button>
         <!-- <button id="cancelar" name="guardar" class="btn btn-danger" type="button" onclick="" > <span class="glyphicon glyphicon-remove"></span>Cancelar</button>-->
        </td>
      </tr>
    </table>
  </div> <!--Fin  Div Datos Directorio-->
  
</div> <!-- Fin Div Row -->


<!--<button id="descargar" name="descargar" class="btn btn-success" type="button" onclick="" > <span class="glyphicon glyphicon-download-alt"></span>Descargar</button>
<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />-->
</form>


</div> <!-- Fin Div contaires 2-->


<script type="text/javascript">
	
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

                    
                    listaPersonalActivoTable="<table class='table table-hover' id='Exportar_a_Excel'><thead><th>Estatus Emp</th><th># Empleado</th><th>Nombre</th><th>Fecha Ingreso</th><th>#IMSS</th><th>Puesto</th><th>Tipo Puesto</th><th>Horario</th><th>Genero</th><th>Estatus Datos Personales</th><th>Estatus Directorio</th><th>Estatus Datos Familiares</th></thead><tbody>";

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
                        imgEstatusEmpleado="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/empleadoSinSeguro.png";
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
  var txtSearch = $("#txtSearch").val ();
  var expreg = /^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/;

  if (txtSearch.length != 10)
    {
        return;
    }

  if(expreg.test(txtSearch))
  {
   
    consultaEmpleado();


  }else{
    
  }
}


function consultaEmpleado ()
{
    var numeroEmpleado = $("#txtSearch").val();
    



    
    // Si el código postal no tiene una longitud de 5 caracteres
    // entonces no hagas nada. Sal de la función.

 $.ajax({
            
            type: "POST",
            url: "ajax_obtenerEmpleadoPorId.php",
            data:{"numeroEmpleado":numeroEmpleado},
            dataType: "json",
             success: function(response) {
                if (response.status == "success")
                {
                  
                    var empleadoEncontrado = response.empleado;

                    
                    listaPersonalActivoTable="<table class='table table-hover' id='Exportar_a_Excel'><thead><th>Estatus</th><th># Empleado</th><th>Nombre</th><th>Fecha Ingreso</th><th>#Cta</th><th>Cta Clabe</th><th>Puesto</th><th>Tipo Puesto</th><th>D.P.</th><th>Dir</th><th>D.F</th></thead><tbody>";

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

                     

                      if (estatusDatosPersonales !=0)
                      {
                        imgEstatusDatosPersonales="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/folderok.png";
                        tooltipDatosPersonales="OK";
                      }else{
                        imgEstatusDatosPersonales="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/notfolder.png";
                        
                        tooltipDatosPersonales="SIN INFORMACIÓN";
                      }

                      if (estatusDatosDireccion !=0)
                      {
                        imgEstatusDatosDireccion="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/addressok.png";
                        tooltipDatosDireccion="OK";
                      }else{
                        imgEstatusDatosDireccion="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/notaddress.png";
                        tooltipDatosDireccion="SIN INFORMACIÓN";
                      }
                      if (estatusDatosFamiliares !=0)
                      {
                        imgEstatusDatosFamiliares="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/familyok.png";
                        tooltipDatosFamiliares="OK";
                      }else{
                        imgEstatusDatosFamiliares="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/notFamily.png";
                        tooltipDatosFamiliares="SIN INFORMACIÓN";
                      }


                      if (estatusEmpleado==1){
                        imgEstatusEmpleado="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/empleadoActivo.png";

                      }else if(estatusEmpleado==2){
                        imgEstatusEmpleado="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/empleadoSinSeguro.png";
                      }else {
                        imgEstatusEmpleado="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/empleadoBaja.png";
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
                    $("#fechaIngresoEdited").val(fechaIngresoEmpleado);
                    $("#idEndidadFederativaEdited").val(entidadTrabajo);
                    $("#tipoPuestoEdited").val(tipoEmpleado);
                     seleccionarTipoPuesto1();
                     obtenerListaPuntosServiciosPorEntidad();
                     alert(empleadoIdPuntoServicio)

                    

                    //alert(empleadoPuesto);

                    $("#tipoTurnoEdited").val(tipoTurnoId);
                    $("#puestoEdited").val(empleadoPuesto);

                    $("#txtFechaNacimientoEdited").val(fechaNacimiento);
                    $("#selectPaisNacimientoEdited").val(paisNacimientoId);
                    $("#selectEntidadNacimientoEdited").val(entidadNacimientoId);
                    $("#txtMunicipioNacEdited").val(municipioNacimiento);
                    $("#txtCurpEdited").val(curpEmpleado);
                    $("#txtRfcEdited").val(rfcEmpleado);
                    $("#selectEstadoCivilEdited").val(estadoCivilId);
                    $("#selectGradoEstudiosEdited").val(gradoEstudiosId);
                    $("#selectTipoSangreEdited").val(tipoSangreId);
                    $("#txtNumeroCartillaEdited").val(numeroCartilla);
                    $("#selectOficioEdited").val(oficioId);
                    $("#selectPuntoServicioEdited").val(empleadoIdPuntoServicio)

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


                    if (empleadoIdGenero==1){
                     // alert(descripcionGenero); 

                      jQuery('#1genero').attr('checked', true);
                                           

                    }else if(empleadoIdGenero==2){
                      //alert(descripcionGenero); 

                       jQuery('#2genero').attr('checked', true);



                    }


        
                      listaPersonalActivoTable += "<tr><td><img class='cursorImg' src='"+imgEstatusEmpleado+ "' data-toggle='tooltip' data-placement='right' title='"+tooltipEstatusEmpleado+"'></td><td>"+numeroEmpleadoCompleto+" </td><td>"+nombreCompleto+
                      "</td><td>"+fechaIngresoEmpleado+"</td><td>"+empleadoNumeroCta+"</td><td>"
                      +empleadoNumeroCtaClabe+"</td><td>"+descripcionPuesto+"</td><td>"+descripcionCategoria+"</td><td><img class='cursorImg' src='"+imgEstatusDatosPersonales+ "' data-toggle='tooltip' data-placement='right' title='"+tooltipDatosPersonales+"'></td><td><img class='cursorImg' src='"+imgEstatusDatosDireccion+ "' data-toggle='tooltip' data-placement='right' title='"+tooltipDatosDireccion+"'></td><td><img class='cursorImg' src='"+imgEstatusDatosFamiliares+ "' data-toggle='tooltip' data-placement='right' title='"+tooltipDatosFamiliares+"'></td><tr>";
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





function consultaEmpleadoPorNombre()
{
    var nombre = $("#txtSearch").val();

 $.ajax({
            
            type: "POST",
            url: "ajax_obtenerEmpleadoPorNombre.php",
            data:{"nombre":nombre},
            dataType: "json",
             success: function(response) {
                if (response.status == "success")
                {
                  
                    var empleadoEncontrado = response.empleado;

                    
                    listaPersonalActivoTable="<table class='table table-hover' id='Exportar_a_Excel'><thead><th>Estatus Emp</th><th># Empleado</th><th>Nombre</th><th>Fecha Ingreso</th><th>#IMSS</th><th>Puesto</th><th>Tipo Puesto</th><th>Horario</th><th>Genero</th><th>Estatus Datos Personales</th><th>Estatus Directorio</th><th>Estatus Datos Familiares</th></thead><tbody>";

                    for ( var i = 0; i < empleadoEncontrado.length; i++ ){
                      var empleadoEntidad = empleadoEncontrado[i].entidadFederativaId;
                      var empleadoConsecutivo = empleadoEncontrado[i].empleadoConsecutivoId;
                      var empleadoCategoria = empleadoEncontrado[i].empleadoCategoriaId;
                      var empleadoApellidoPaterno= empleadoEncontrado[i].apellidoPaterno;
                      var empleadoApellidoMaterno= empleadoEncontrado[i].apellidoMaterno;
                      var nombreEmpleado= empleadoEncontrado[i].nombreEmpleado;
                      var fechaIngresoEmpleado = empleadoEncontrado[i].fechaIngresoEmpleado;
                      var empleadoNumeroSeguroSocial =empleadoEncontrado[i].empleadoNumeroSeguroSocial;
                      var descripcionPuesto= empleadoEncontrado[i].descripcionPuesto;
                      var descripcionCategoria=empleadoEncontrado[i].descripcionCategoria;
                      var descripcionTurno=empleadoEncontrado[i].descripcionTurno;
                      var descripcionOficio=empleadoEncontrado[i].descripcionOficio;
                      var descripcionGenero=empleadoEncontrado[i].descripcionGenero;
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
                      //var tooltipEstatusEmpleado=empleadoEncontrado[i].descripcionEstatusEmpleado;


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
                        imgEstatusEmpleado="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/empleadoSinSeguro.png";
                      }else {
                        imgEstatusEmpleado="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/empleadoBaja.png";
                      }
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

function bloquearDatosGenerales()
{
  
  $("#apellidoPaternoEmpleadoEdited").prop("disabled", true );
  $("#apellidoMaternoEmpleadoEdited").prop("disabled", true );
  $("#nombreEmpleadoEdited").prop("disabled", true );
  $("#numeroSeguroSocialEdited").prop("disabled", true );
  $("#txtNumeroCtaEdited").prop("disabled", true );
  $("#txtCtaClabeEdited").prop("disabled", true );
  $("#fechaIngresoEdited").prop("disabled", true );
  $("#idEndidadFederativaEdited").prop("disabled", true );
  $("#tipoPuestoEdited").prop("disabled", true );
  $("#puestoEdited").prop("disabled", true );
  $("#dirigenteEdited").prop("disabled", true );
  $("#tipoTurnoEdited").prop("disabled", true );
  $("#1genero").prop("disabled", true );
  $("#2genero").prop("disabled", true );
  $("#selectPuntoServicioEdited").prop("disabled", true );
  

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
  $("#selectGradoEstudiosEdited").prop("disabled", true );
  $("#selectTipoSangreEdited").prop("disabled", true );
  $("#selectOficioEdited").prop("disabled", true );
  $("#txtNumeroCartillaEdited").prop("disabled", true );
  $("#1estatusCartillaEdited").prop("disabled", true );
  $("#2estatusCartillaEdited").prop("disabled", true );
  $("#3estatusCartillaEdited").prop("disabled", true );
  $("#4estatusCartillaEdited").prop("disabled", true );
  $("#5estatusCartillaEdited").prop("disabled", true );
  
  

}


function bloquearDatosPersonales()
{
  
  $("#txtCurpEdited").prop("disabled", true );
  $("#selectPaisNacimientoEdited").prop("disabled", true );
  
  $("#txtMunicipioNacEdited").prop("disabled", true );
  $("#selectEntidadNacimientoEdited").prop("disabled", true );
  
  
  $("#txtCurpEdited").prop("disabled", true );
  $("#txtRfcEdited").prop("disabled", true );
  $("#selectEstadoCivilEdited").prop("disabled", true );
  $("#selectGradoEstudiosEdited").prop("disabled", true );
  $("#selectGradoEstudiosEdited").prop("disabled", true );
  $("#selectTipoSangreEdited").prop("disabled", true );
  $("#selectOficioEdited").prop("disabled", true );
  $("#txtNumeroCartillaEdited").prop("disabled", true );
  $("#1estatusCartillaEdited").prop("disabled", true );
  $("#2estatusCartillaEdited").prop("disabled", true );
  $("#3estatusCartillaEdited").prop("disabled", true );
  $("#4estatusCartillaEdited").prop("disabled", true );
  $("#5estatusCartillaEdited").prop("disabled", true );
  
  

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
 function seleccionarTipoPuesto1()
    {
       
       //var mitexto = $("#tipoPuesto option:selected").text();
       var valorTipo = $("#tipoPuestoEdited").val();
       var lineaNegocio = $("#linen").val();
       
   

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
                    
                    $("#puestoEdited").html (puestosOptions);
                }
            },
            error: function (response)
            {
                console.log (response);
            }
        });
    }


    function obtenerListaPuntosServiciosPorEntidad1()
    {
       
       //var mitexto = $("#tipoPuesto option:selected").text();
       var idEntidad=$("#idEndidadFederativaEdited").val();
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
                        puntosServiciosOptions += "<option value='" + puntosServicios[i].idPuntoServicio + "'>" + puntosServicios[i].puntoServicio + "</option>";
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



</script>




<script language="javascript">
$(inicioConsultaPersonalActivo());  
function inicioConsultaPersonalActivo(){

  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  });
}

</script>



