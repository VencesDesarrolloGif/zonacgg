<?php
require_once ("../Negocio/Negocio.class.php");
$negocio = new Negocio ();
    //$diasAsistencia = $negocio -> obtenerListaDiasParaAsistencia ("QUINCENAL");
    //$diasAsistencia2="";
?>
<div class="container" align="center" >
  <form class="form-horizontal" id="form_asistencia1" name="form_asistencia1">

    <div > <!-- div consulta -->
      <!-- <h1>PERIODO QUINCENAL</h1> -->
      <div class="btn-group" >
        <label class="btn btn-secondary">
          <input type="radio" name="optionPeriodo" id="optionPeriodoQuincenal" value="QUINCENAL" checked onclick="generarTablaPeriodo();"> QUINCENAL
        </label>
        <label class="btn btn-secondary ">
          <input type="radio" name="optionPeriodo" id="optionPeriodoSemanal" value="SEMANAL" onclick="generarTablaPeriodo();"> SEMANAL
        </label>

      </div>
      <br>
      <br>
      <input type="text" name="txtSearchNumeroEmpleadoAsistencia" id="txtSearchNumeroEmpleadoAsistencia"class="search-query" placeholder="Buscar(00-0000-00)" aria-describedby="basic-addon2" onblur=""><img src="img/search.png">
      <input type="text" name="txtSearchNameAsistencia" id="txtSearchNameAsistencia"class="input-xlarge" placeholder="APELLIDOS NOMBRE(S)" aria-describedby="basic-addon2" ><img src="img/search.png">

      <div id="divtp" name="divtp"></div>
    </div> <!-- fin div consulta -->

    <br>
    <br>

    <div id="divTableEmpleadosAsistencia" name="divTableEmpleadosAsistencia" align="center" class='container'>


    </div>

    <div class="modal hide fade" tabindex="-1" role="dialog" id="myModalAsistencia" name="myModalAsistencia">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        <h3>Registro de asistencia</h3><input id="txtFechaAsistencia" name="txtFechaAsistencia" type="text" class="input-small" readonly >
        
      </div>
      <div class="modal-bodyIncidencia">
        <div class="input-prepend">
          <!-- <span class="add-on">No. EMPLEADO</span> -->
          <input id="txtNumeroEmpleadoAsistencia" name="txtNumeroEmpleadoAsistencia" type="text" class="input-small" readonly>
          <input id="txtNombreEmpleadoAsistencia" name="txtNombreEmpleadoAsistencia" type="text" class="input-xlarge" readonly>
          
          <input type="hidden" id="idCell" value="" />
        </div>
        <div class="input-prepend">
          <span class="add-on">ENTIDAD TRABAJO</span>
          <input id="txtEntidadEmp" name="txtEntidadEmp" type="text" class="input-large" readonly>
          <input id="txtPuntoOculto" name="txtPuntoOculto" type="hidden" >   
          <input id="txtPuestoOculto" name="txtPuestoOculto" type="hidden" >          
          
        </div>
        <div class="input-prepend">
          <span class="add-on">COMENTARIO</span>
          <textarea id="txtComentarioIncidencia" name="txtComentarioIncidencia" class="txtAreaIncidencia" maxlength="100"></textarea>          
          
        </div>


        <div class="list-group">

          <?php
          
          $estacion[1] = "background-color:#FEFF00";
          $estacion[2] = "background-color:#FFFFFF";  
          $estacion[4] = "background-color:#FF0000";
          $estacion[5] = "background-color:#538136";
          $estacion[6] = "background-color:#538136";
          $estacion[7] = "background-color:#01AFF5";
          $estacion[8] = "background-color:#90D24B";
          $estacion[9] = "background-color:#FFFFFF";
          $estacion[10] = "background-color:#FF0000"; 


          $nombreI[0]= "DESCANSO";   
          $nombreI[1]= "TURNO";
          $nombreI[2]= "FALTA";
          $nombreI[3]= "VACACIONES PAGADAS";
          $nombreI[4]= "VACACIONES DISFRUTADAS";
          $nombreI[5]= "PERMISO";
          $nombreI[6]= "INCAPACIDAD";
          $nombreI[7]= "DESCANSO TRABAJADO";
          $nombreI[8]= "BAJA";

          for ( $i=0; $i<count($catalogoIncidencias); $i++)
          {

            $nomenclaturaIncidencia= $catalogoIncidencias[$i]["incidenciaId"] ;
            

            echo "<a id='a_".$catalogoIncidencias[$i]["incidenciaId"]."' name='a_".$catalogoIncidencias[$i]["incidenciaId"]."' href='#' style='".$estacion[$nomenclaturaIncidencia]."' class='list-group-item-a font' onclick='registrarPaseDeLista(\"" . $catalogoIncidencias[$i]["incidenciaId"] . "\",\"" . $catalogoIncidencias[$i]["descripcionIncidencia"] . "\",\"" . $catalogoIncidencias[$i]["nomenclaturaIncidencia"] . "\");'>".$nombreI[$i]."</a>";
          }
          ?>

        </div>

      </div> <!-- fin modal body -->

    </div> <!-- fin modal asistencia -->



    <div class="modal hide fade" tabindex="-1" role="dialog" id="myModalIncidenciaEspecial" name="myModalIncidenciaEspecial">
      <div class="modal-header">
        <div id="alertMsgIncidencia" name="alertMsgIncidencia"></div>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Registro de Incidencia Especial</h3>
      </div>
      <div class="modal-bodyIncidencia">
        <div class="input-prepend">
          <span class="add-on">No. EMPLEADO</span>
          <input id="txtNumeroEmpleadoIncidencia" name="txtNumeroEmpleadoIncidencia" type="text" class="input-small" readonly>
          
        </div>
        <div class="input-prepend">
          <span class="add-on">NOMBRE</span>
          <input id="txtNombreEmpleadoIncidencia" name="txtNombreEmpleadoIncidencia" type="text" class="input-xlarge" readonly>
          <input id="txtPuntoOcultoIE" name="txtPuntoOcultoIE" type="hidden" >   
          <input id="txtPuestoOcultoIE" name="txtPuestoOcultoIE" type="hidden" >    
        </div>
        <div class="input-prepend">
          <span class="add-on">FECHA ASISTENCIA</span>
          <input id="txtFechaIncidencia" name="txtFechaIncidencia" type="date" class="input-medium" readonly >
          
        </div>

        <div class="input-prepend">
          <span class="add-on">INCIDENCIA ESPECIAL</span>
          <select id="selectIncidenciaEspecial" name="selectIncidenciaEspecial" class="input-large " >
            <?php
            for ($i=0; $i<count($catalogoIncidenciasEspeciales); $i++)
            {
              echo "<option value='". $catalogoIncidenciasEspeciales[$i]["incidenciaEspecialId"]."'>". $catalogoIncidenciasEspeciales[$i]["nomenclaturaIncidenciaEspecial"] ." (".$catalogoIncidenciasEspeciales[$i]["descripcionIncidenciaEspecial"].") </option>";
            }
            ?>
          </select>
          
        </div>
        <div class="input-prepend">
          <span class="add-on">COMENTARIO</span>
          <textarea id="txtComentarioIncidenciaEspecial" name="txtComentarioIncidenciaEspecial" class="txtAreaIncidencia" maxlength="100"></textarea>
          <input type="hidden" name="txtSupervisorIdIncidencia" id="txtSupervisorIdIncidencia"  class="input-medium">
          
        </div>

      </div> <!-- fin modal body -->

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="registrarIncidenciaEspecial();">Registrar</button>
      </div>

    </div> <!-- fin modal asistencia -->

  </form>


  <div class="contextMenu" id="myMenu1">

    <ul>

      <li id="borrarIncidencia"><img src="img/borrarMenu.png" /> Borrar</li>
      <li id="incidencia"><img src="img/warningMenu.png" /> Incidencia</li>
      
    </ul>

  </div>



  <div id="modalError" name="modalError" class="modal hide fade" tabindex="-1" data-focus-on="input:first">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <img src="img/rechazarImss.png"> <strong>Error</strong>
    </div>
    <div class="modal-body">

      <div id="mensajeError" name="mensajeError"></div>

      
    </div>
    <div class="modal-footer">
      
      <button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>
    </div>
  </div>

</div> <!-- fin div container -->


<div class="modal fade" tabindex="-1" role="dialog" name="modalempleadobaja" id="modalempleadobaja" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><img src="img/alert.png">No Es Posible Realizar Movimientos Ya Que El Empleado !!</h4>
      </div>
      <div class="modal-body">
        <p><strong id="NumeroConsulaEMpleadoBaja"></strong></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal --> 



  <!-- inicia modal pra las incapacidades-->
  <div class="modal hide fade" tabindex="-1" role="dialog" id="ModalIncapacidad" name="ModalIncapacidad">
    <div id="msgerrormodlaincapacidad"></div>
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

      <h3 align="center">INCAPACIDAD</h3><input id="txtFechaIncapacidad" name="txtFechaIncapacidad" type="text" class="input-small" readonly >
    </div>

    <div class="modal-bodyIncidencia">
      <div class="input-prepend">
        <!-- <span class="add-on">No. EMPLEADO</span> -->
        <input id="txtNumeroEmpleadoIncapacidad" name="txtNumeroEmpleadoIncapacidad" type="text" class="input-small" readonly>
        <input id="txtNombreEmpleadoIncapacidad" name="txtNombreEmpleadoIncapacidad" type="text" class="input-xlarge" readonly>

        <input id="inppuntoservicioadministrativo" name="inppuntoservicioadministrativo" type="hidden" class="input-xlarge" readonly>
        <input id="inpsupervisoradministrativoid" name="inpsupervisoradministrativoid" type="hidden" class="input-xlarge" readonly>
        <input id="inpempleadoidpuesto" name="inpempleadoidpuesto" type="hidden" class="input-xlarge" readonly>
        <input id="roloperativoadministrativo" name="roloperativoadministrativo" type="hidden" class="input-xlarge" readonly>

      </div>

      <div class="input-prepend">
        <span class="add-on">FOLIO INCAPACIDAD</span>
        <input id="inpfolioincapacidad" name="inpfolioincapacidad" type="text" class="input-small"  >
      </div>
      <div class="input-prepend">

        <span class="add-on">TIPO INCAPACIDAD</span>
        <select id="selectTipoIncapacidad" name="selectTipoIncapacidad" class="input-large " >
          <option value="0">TIPO</option>
          <option value="1">ENFERMEDAD GENERAL</option>
          <option value="2">RIESGO DE TRABAJO</option>
          <option value="3">MATERNIDAD</option>

        </select>  
      </div>
    </div>

    <div class="input-prepend" id="divmuestraEnfermedadGeneral"  style="display:none;margin-left: 2.5%">
      <div class="input-prepend">
        <span class="add-on">DIAS DE INCAPACIDAD</span>
        <input id="inpdiasincapacidad" name="inpdiasincapacidad" type="text" class="input-small"  >
      </div>
      <div class="card border-success mb-3" style="max-width: 30rem;" align="center">
        <div class="card-header"><h4>ARCHIVO INCAPACIDAD</h4></div>    
        <div class="card-body text-primary">
          <label class="control-label label" for="docuincapacidad">Selecciona archivo: </label>
          <form enctype='multipart/form-data' id='archivoincapacidad' name='archivoincapacidad'>
            <span class="btn btn-success btn-file" >Examinar
              <input type='file' class='btn-success' id='docuincapacidad' name='docuincapacidad[]' multiple="" /> 
            </span>
            <!--<button type="button" class="btn btn-primary" onclick="enviar()">Cargar</button>-->
          </form>
        </div>            

        <!--<button class='btn btn-success' type='button' onclick='actualizarDeudores();'> <img src='img/hojaDatos.png' width='20%'>Formato Alta</button>-->
      </div> 





      <div class="input-prepend" id="divmuestrast7"  style="display:none;margin-left: 2.5%">
        <div class="card border-success mb-3" style="max-width: 30rem;" align="center">
          <div class="card-header"><h4>ARCHIVO ST-7</h4></div>    
          <div class="card-body text-primary">
            <label class="control-label label" for="docust7">Selecciona archivo: </label>
            <form enctype='multipart/form-data' id='archivost7' name='archivost7'>
              <span class="btn btn-success btn-file" >Examinar
                <input type='file' class='btn-success' id='docust7' name='docust7[]' multiple="" /> 
              </span>
              <!--<button type="button" class="btn btn-primary" onclick="enviar()">Cargar</button>-->
            </form>
          </div>            

          <!--<button class='btn btn-success' type='button' onclick='actualizarDeudores();'> <img src='img/hojaDatos.png' width='20%'>Formato Alta</button>-->
        </div>   
      </div>

      <div class="input-prepend" id="divmuestrast2"  style="display:none;margin-left: 2.5%">
        <div  class="card border-success mb-3" style="max-width: 30rem;" align="center">
          <div class="card-header"><h4>ARCHIVO ST-2</h4></div>    
          <div class="card-body text-primary">
            <label class="control-label label" for="docust2">Selecciona archivo: </label>
            <form enctype='multipart/form-data' id='archivost2' name='archivost2'>
              <span class="btn btn-success btn-file" >Examinar
                <input type='file' class='btn-success' id='docust2' name='docust2[]' multiple="" /> 
              </span>
              <!--<button type="button" class="btn btn-primary" onclick="enviar()">Cargar</button>-->
            </form>
          </div>            

          <!--<button class='btn btn-success' type='button' onclick='actualizarDeudores();'> <img src='img/hojaDatos.png' width='20%'>Formato Alta</button>-->
        </div> 
      </div> 


      <br>
      <div class="input-prepend" align="center">
        <!-- <span class="add-on">No. EMPLEADO</span> -->
        <button id="btnguardarincapacidad" type="button" class="btn btn-primary" >Guardar</button>-->   

      </div>
    </div>
  </div>

  <div class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="overflow-y: scroll; max-height:85%;  margin-top: 50px; margin-bottom:50px;" id="ModalVacacionesAdmin" name="ModalVacacionesAdmin">
    <div id="msgerrormodlavacacionesAdmin"></div>
    <div class="input-prepend" id="divmuestraVacacionesDisfrutadasAdmin" style="display:none;margin-left: 10%" align="center"><!--este div es para las vacaciones disfrutadas -->
      <div class="input-prepend" align="center">
        <h3> REGISTRO DE VACACIONES</h3>
      </div><br>
      <div class="input-prepend">
        <span class="add-on">Nombre Empleado</span>
        <input id="NombreEmpleadoVacacionesAdmin" name="NombreEmpleadoVacacionesAdmin" type="text" class="input-xlarge" readonly>
      </div><br>

      <div class="input-prepend">
        <span class="add-on">Numero Empleado</span>
        <input id="numempleadovacacionesAdmin" name="numempleadovacacionesAdmin" type="text" class="input-large" readonly>
      </div><br>

      <div class="input-prepend">
        <span class="add-on">Rol Operativo</span>
        <input id="RolOperativoVacacionesAdmin" name="RolOperativoVacacionesAdmin" type="text" class="input-medium" readonly>
      </div><br>

      <div class="input-prepend">
        <span class="add-on">Periodo Inicio</span>
        <input id="PeriodoInicioAdmin" name="PeriodoInicioAdmin" type="text" class="input-medium" readonly>

        <span class="add-on">Periodo Fin</span>
        <input id="PeriodoFinAdmin" name="PeriodoFinAdmin" type="text" class="input-medium" readonly>
      </div><br>

      <div class="input-prepend">
        <span class="add-on">Dias Restantes De Vacaciones</span>
        <input id="VacacionesRestntesAdmin" name="VacacionesRestntesAdmin" type="text" class="input-medium" readonly>
      </div><br>

      <div class="input-prepend">
        <span class="add-on">Aniversarios</span>
        <select id="selectPeriodoInicioAdmin" name="selectPeriodoInicioAdmin" class="input-large"></select>
      </div><br>

      <div class="input-prepend">
        <span class="add-on">Dias Computables</span>
        <input id="inpdiasvacacionesAdmin" name="inpdiasvacacionesAdmin" type="text" class="input-small" onblur="cargarFolioAdmin();">
      </div><br>
      
      <div id="divinputsfechasAdmin" name="divinputsfechasAdmin" align="center" class='container'>
      </div><br> 

      <div class="input-prepend" style="display: block;">
        <span class="add-on">Folio Vacaciones Es: </span>
        <input id="inpFoliovacacionesAdmin" name="inpFoliovacacionesAdmin" type="text" class="input-xlarge" readonly="true">
        <input id="nomeclaturavacacionesAdmin" name="nomeclaturavacacionesAdmin" type="hidden" class="input-medium">
        <input id="empleadoEntidadIdVacacionesAdmin" name="empleadoEntidadIdVacacionesAdmin" type="hidden" class="input-medium">
        <input id="empleadoConsecutivoIdVacacionesAdmin" name="empleadoConsecutivoIdVacacionesAdmin" type="hidden" class="input-medium">
        <input id="empleadoTipoIdVacacionesAdmin" name="empleadoTipoIdVacacionesAdmin" type="hidden" class="input-medium">
        <input id="empleadoPuntoServicioIdVacacionesAdmin" name="empleadoPuntoServicioIdVacacionesAdmin" type="hidden" class="input-medium">
        <input id="incidenciaIdVacacionesAdmin" name="incidenciaIdVacacionesAdmin" type="hidden" class="input-medium">
        <input id="asistenciaFechaVacacionesAdmin" name="asistenciaFechaVacacionesAdmin" type="hidden" class="input-medium">
        <input id="comentariIncidenciaVacacionesAdmin" name="comentariIncidenciaVacacionesAdmin" type="hidden" class="input-medium">
        <input id="tipoPeriodoVacacionesAdmin" name="tipoPeriodoVacacionesAdmin" type="hidden" class="input-medium">
        <input id="puestoCubiertoIdVacacionesAdmin" name="puestoCubiertoIdVacacionesAdmin" type="hidden" class="input-medium">
        <input id="plantilladeservicioVacacionesAdmin" name="plantilladeservicioVacacionesAdmin" type="hidden" class="input-medium">
        <input id="incidenciaVacacionesAdmin" name="incidenciaVacacionesAdmin" type="hidden" class="input-medium">
        <input id="banderaVacacionesAdmin" name="banderaVacacionesAdmin" type="hidden" class="input-medium">
        <input id="RevisionAsistenciaDiaSeleccionadoAdmin" name="RevisionAsistenciaDiaSeleccionadoAdmin" type="hidden" class="input-medium">
        <input id="IteracionesCorrectasYValidadasAdmin" name="IteracionesCorrectasYValidadasAdmin" type="hidden" class="input-medium">
      </div>
      <div class="card border-success mb-3" style="max-width: 30rem;">
        <div class="card-header"><h4>PAPELETA VACACIONES</h4></div>    
        <div class="card-body text-primary">
          <label class="control-label label" for="docvacacionesAdmin">Selecciona archivo: </label>
          <form enctype='multipart/form-data' id='archivovacacionesAdmin' name='archivovacacionesAdmin'>
            <span class="btn btn-success btn-file" >Examinar
              <input type='file' class='btn-success' id='docvacaciones' name='docvacaciones[]' multiple="" /> 
            </span>
          </form>
        </div>            
      </div><br>
      <div class="input-prepend">
      <!-- <button id="botactualizar" name="botactualizar" type="button" class="btn btn-primary" style="margin-left: -20%;" >Actualizar</button> -->
      <button id="botonGuardarVacacionesAdmin" name="botonGuardarVacacionesAdmin" type="button" class="btn btn-primary" style="margin-left: -20%;" >Guardar</button> 
        <button id="botonCancelarVacacionesAdmin" name="botonCancelarVacacionesAdmin" type="button" class="btn btn-danger" style="margin-left: 60%">Cancelar</button> 
      </div>
    </div>
  </div>


  <div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalBajaEmpeladoAdmin" id="modalBajaEmpeladoAdmin" data-backdrop="static">
  <form enctype='multipart/form-data' id='archivobajamepleadoAdmin' name='archivobajamepleadoAdmin'>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div id="errorModalBajaEmpleadoAdmin"></div>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" align="center"><img src="img/alert.png">Registra Los Datos E Ingresa Tu Firma Interna Para Realizar La Baja !!</h3>
      </div>
      <div class="modal-body" align="center">
        <span class="add-on">Fecha Baja Empleado</span>
        <input type="text" class="input-medium" id="FechaBajaEmpModalAdmin" name="FechaBajaEmpModalAdmin" readonly="true">
      </div>
      <div class="modal-body" align="center">
        <span class="add-on"># Empleado</span>
        <input type="text" id="NumEmpModalAdmin" class="input-medium" name="NumEmpModalAdmin" readonly="true">
        <span class="add-on">Nombe Empleado</span>
        <input type="text" id="NombreEMpModalAdmin" class="input-xlarge"name="NombreEMpModalAdmin" readonly="true">
      </div>
      <div class="modal-body" align="center">
        <span class="add-on">Punto Servicio</span>
        <input type="text" id="PuntoEmpModalAdmin" class="input-large" name="PuntoEmpModalAdmin" readonly="true">
        <span class="add-on">Puesto</span>
        <input type="text" id="PuestoEmpModalAdmin" class="input-medium" name="PuestoEmpModalAdmin" readonly="true">
      </div>
      <div class="modal-body" align="center">
        <h4>MARQUE SOLO UN CUADRO CON EL MOTIVO DE LA BAJA:</h4>
      </div>
      <div class="modal-body" align="center">
        <span class="add-on"><strong>FALTAS INJUSTIFICADAS</strong></span>
        <input id="faltasInjustiicadasAdmin" name="faltasInjustiicadasAdmin" type="checkbox" style="transform: scale(1.5);">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

        <span class="add-on"><strong>ABANDONO DE SERVICIO/EMPLEO</strong></span>
        <input id="abandonoServicioAdmin" name="abandonoServicioAdmin" type="checkbox" style="transform: scale(1.5);">
      </div>
      <div class="modal-body" align="center">
         <span class="add-on"><strong>INDICIPLINA</strong></span>
        <input id="indiciplinaAdmin" name="indiciplinaAdmin" type="checkbox" style="transform: scale(1.5);">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

        <span class="add-on"><strong>TERMINO DE SERVICIO</strong></span>
        <input id="terminoServicioAdmin" name="terminoServicioAdmin" type="checkbox" style="transform: scale(1.5);">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

        <span class="add-on"><strong>OTROS</strong></span>
        <input id="otrosAdmin" name="otrosAdmin" type="checkbox" style="transform: scale(1.5);">
      </div><br>
      <div class="modal-body" align="center">
         <textarea  id="especifiqueMotivoAdmin" name="especifiqueMotivoAdmin" style="transform: scale(1.5);" placeholder="Especifique el motivo de la baja"></textarea>
      </div>
      <div class="modal-body" align="center">
         <button type="button" id="btnGuardarDocBajaEmpAdmin" name="btnGuardarDocBajaEmpAdmin" onclick="firmarDocumentoAdmin();" class="btn btn-success" >Firmar Documento</button>  
      </div>
      <div class="modal-body" align="center">
        <span class="add-on">Nombe Solicitante:</span>
        <input type="text" id="NombreSolicitanteAdmin" class="input-xlarge"name="NombreSolicitanteAdmin" readonly="true">
        <span class="add-on">Firma Interna:</span>
        <input type="text" id="FirmaInternaAdmin" class="input-xlarge"name="FirmaInternaAdmin" readonly="true">
      </div>
      <div class="modal-body" align="center">
        <h4 class="modal-title" id="myModalLabel"> <img src="img/warning.png">¿ESTE ELEMENTO PODRÁ SER REINGRESADO POSTERIORMENTE?</h4>
      </div>
      <div class="modal-body" align="center">
            <span class="add-on" >SI</span>
            <input type="checkbox" id="checkSireingresoAsistenciaAdmin" title="Si podra ser reingresado en caso de que vuelva a solicitar trabajo en el Corporativo" name="checkSireingresoAsistenciaAdmin" style="transform: scale(1.5);width: 30px;">
            <span class="add-on">NO</span>
            <input type="checkbox" id="checkNoreingresoAsistenciaAdmin" title="NO podra ser reingresado en Ningun caso dentro de este Corporativo" name="checkNoreingresoAsistenciaAdmin" style="transform: scale(1.5);width: 30px;">
      </div>
      <div class="modal-body" align="center">
        <span class="add-on" style="color:red;">AL COLOCAR QUE NO EL EMPLEADO QUEDARÁ VETADO DE TODO EL CORPORATIVO GIF SEGURIDAD PRIVADA</span><br>
        <span class="add-on" style="color:red;">Y NO PODRÁ SER REINGRESADO EN NINGUNA PARTE DEL PAIS DENTRO DE ESTE CORPORATIVO!!!</span>
      </div><br>
      <div class="modal-body" id="divComentarioMotivoBetoAsistenciaAdmin" style="display: none;" align="center">
      <span class="add-on">Motivo:</span>
        <textarea id="ComentarioBetadoAsistenciaAdmin" name="ComentarioBetadoAsistenciaAdmin" class="txtAreaIncidencia" maxlength="200" placeholder="Escriba el motivo por el cual el elemento será vetado"></textarea>
      </div><br>
      <input type="hidden" id="banderaBetadoAsistenciaAdmin" class="input-xlarge"name="banderaBetadoAsistenciaAdmin" readonly="true">
        <input type="hidden" class="input-medium" id="PuestoDescripcionhdn" name="PuestoDescripcionhdn" readonly="true">
        <input type="hidden" class="input-medium" id="puntoServicioDescripcionhdn" name="puntoServicioDescripcionhdn" readonly="true">
        <input type="hidden" class="input-medium" id="nomenclaturaIncidenciaHiddenBajaEmpAdmin" name="nomenclaturaIncidenciaHiddenBajaEmpAdmin" readonly="true">
        <input type="hidden" class="input-medium" id="numempleadoFirmahiddenAdmin" name="numempleadoFirmahiddenAdmin" readonly="true">        
      <div class="modal-body" align="center">
        
        <button type="button" id="btnGuardarDocBajaEmp" name="btnGuardarDocBajaEmp" onclick="GuardarDocumentoBajaAdmin();" class="btn btn-primary" >Guardar</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
  </form>
</div><!-- /.modal -->  

<div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaElectronicaAdmin" id="modalFirmaElectronicaAdmin" data-backdrop="static">
  <div id="errorModalFirmaInternaAdmin"></div>
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
        <input type="password" id="constraseniaFirmaAdmin" class="input-xlarge"name="constraseniaFirmaAdmin" title="El campo identifica entre mayusculas y minusculas favor de considerarlo">
      </div>
      <div class="modal-body" align="center">
        
        <button type="button" id="btnFirmarDocAdmin" name="btnFirmarDocAdmin" onclick="RevisarFirmaInternaAdmin();" style="display: none;" class="btn btn-primary" >Firmar</button>
        <button type="button" id="btnCancelarFirmaAdmin" name="btnCancelarFirmaAdmin"onclick="cancelarFirmaAdmin();" class="btn btn-danger" >Cancelar</button>
      </div>      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

  <script type="text/javascript">
    var turnosPresupuestados = 0;
    var turnosCubiertos = {};
    var requisiciones = [];
    var busqueda="";
    var resultAsistencia="";
    jQuery("#optionPeriodoQuincenal").attr('checked', true);
    //alert($('input:radio[name=optionPeriodo]:checked').val());  
    var fechasAsistencia = [];
    var fecha1="";
    var fecha2="";
    var periodoId="1";
    generarTablaPeriodo();
    var styles = [];
    styles ["DES"] = "background-color:#FEFF00";
    styles ["F"] = "background-color:#FA5858";
    styles ["PER"] = "background-color:#01AFF5";
    styles ["V/P"] = "background-color:#538136";
    styles ["V/D"] = "background-color:#538136";
    styles ["INC"] = "background-color:#90D24B";
    styles ["F"] = "background-color:#FF0000";
    styles ["B"] = "background-color:#FF0000";
    styles ["ING"] = "background-color:#BDBDBD;";
    styles ["DT12"] = "background-color:#FEFF00";
    styles ["1"] = "background-color:#FFFFFF";
    styles ["2"] = "background-color:#FFFFFF";
    

    

    
    


    function generarTablaPeriodo(){

      var tipoPeriodo = $('input:radio[name=optionPeriodo]:checked').val();
      
      $("#txtSearchNameAsistencia").val("");
      $("#txtNumeroEmpleadoAsistencia").val("");

          //alert(tipoPeriodo);

          if (tipoPeriodo=="QUINCENAL"){

            periodoId="1";
            
            <?php
            $diasAsistencia= $negocio -> obtenerListaDiasParaAsistencia ("QUINCENAL");
        //echo $diasAsistencia;
            ?>
            fechasAsistencia = [];

            <?php
            foreach ($diasAsistencia as $dia):
              ?>
              
              <?php echo "fechasAsistencia.push ('" . $dia["fecha"] . "');\n" ?>
              <?php
            endforeach;
            ?>


            fecha1 = fechasAsistencia [0];
            fecha2 = fechasAsistencia [fechasAsistencia.length - 1];

        //console.log(fecha1);
        //console.log(fecha2);


        var tableEmpleadosAsistencia="<table class='table table-fixedheader table-bordered table-striped' id='tableEmpleadosAsistencia' name='tableEmpleadosAsistencia'><thead><tr><th  width='80px'>#Empleado</th><th width='160px'>Nombre Empleado</th>";
        tableEmpleadosAsistencia += "<th width='100px'>Puesto</th><th width='140px'>Entidad</th><th width='140px'>Punto Servicio</th><th width='160px'>Linea Negocio</th><?php foreach ($diasAsistencia as $dia): ?> <th width='40px'><?php echo $dia["dia"]; ?> <?php endforeach; ?></th>";
        tableEmpleadosAsistencia +="<th>T.Q</th><th>T.E</th><th>D.F</th><th>Des.</th><th>I.E</th><th>TOTAL</th></tr></thead><tbody></tbody></table>";
        $('#divTableEmpleadosAsistencia').html(tableEmpleadosAsistencia); 
        


      }else{
        
        periodoId="2";
        $("#puntoServicioSupervisor").val("PUNTOS DE SERVICIOS");
        $("#txtSearchNameAsistencia").val("");
        $("#txtNumeroEmpleadoAsistencia").val("");
        <?php
        $diasAsistencia= $negocio -> obtenerListaDiasParaAsistencia ("SEMANAL");
        
        ?>

        fechasAsistencia = [];
        <?php
        foreach ($diasAsistencia as $dia):
          ?>
          <?php echo "fechasAsistencia.push ('" . $dia["fecha"] . "');\n" ?>
          <?php
        endforeach;
        ?>

        fecha1 = fechasAsistencia [0];
        fecha2 = fechasAsistencia [fechasAsistencia.length - 1];

        var tableEmpleadosAsistencia="<table class='table table-fixedheader table-bordered table-striped' id='tableEmpleadosAsistencia' name='tableEmpleadosAsistencia'><thead><tr><th  width='80px'>#Empleado</th><th width='160px'>Nombre Empleado</th><th width='100px'>Puesto</th><th width='140px'>Entidad</th><th width='140px'>Punto Servicio</th><th width='160px'>Linea Negocio</th><?php foreach ($diasAsistencia as $dia): ?> <th width='40px'><?php echo $dia["dia"]; ?> <?php endforeach; ?></th><th>T.Q</th><th>T.E</th><th>D.F</th><th>DES</th><th>I.E</th><th>TOTAL</th></tr></thead><tbody></tbody></table>";
        $('#divTableEmpleadosAsistencia').html(tableEmpleadosAsistencia); 

      }

      consultaPersonalAdmin();

    } 


    function tableEmpleadosByIdEmpleado()
    {
      waitingDialog.show();
      var numeroEmpleado = $("#txtSearchNumeroEmpleadoAsistencia").val();
      $("#tableEmpleadosAsistencia").find("tr:gt(0)").remove();


      var elementosNumeroEmpleado = numeroEmpleado.split ("-");

      var empleadoEntidadId = elementosNumeroEmpleado[0];
      var empleadoConsecutivoId = elementosNumeroEmpleado[1];
      var empleadoTipoId = elementosNumeroEmpleado[2];


      $.ajax({
        
        type: "POST",
        url: "ajax_consultaAdminById.php",
        data : {"fecha1":fecha1, "fecha2":fecha2, "periodoId":periodoId, "empleadoEntidadId":empleadoEntidadId, "empleadoConsecutivoId":empleadoConsecutivoId, "empleadoTipoId":empleadoTipoId },
        dataType: "json",
        success: function(response) {

          if (response.status == "success")
          {
           
            var empleadoEncontrado = response.listaEmpleados;
            if(empleadoEncontrado.length ==0){
              alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Empleado no encontrado</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
              
              $("#alertMsg").html(alertMsg1);
              $(document).scrollTop(0);
              $('#msgAlert').delay(3000).fadeOut('slow');
            }
            
            for ( var i = 0; i < empleadoEncontrado.length; i++ ){
              var numeroEmpleado = empleadoEncontrado[i].numeroEmpleado;
              var nombreEmpleado = empleadoEncontrado[i].nombreEmpleado;
              var descripcionPuesto = empleadoEncontrado[i].descripcionPuesto;                      
              var puntoServicio=empleadoEncontrado[i].puntoServicio;
              var empleadoIdPuntoServicio=empleadoEncontrado[i].empleadoIdPuntoServicio;
              var empleadoIdPuesto=empleadoEncontrado[i].empleadoIdPuesto;

              var entidad=empleadoEncontrado[i].Entidad;

              var asistencia = empleadoEncontrado[i].asistencia;
              var sumaTurnosExtras=empleadoEncontrado[i].turnosExtras.sumaTurnosExtras;
              var descuentos=empleadoEncontrado[i].descuentos.descuentos;
              var incidenciasEspeciales=empleadoEncontrado[i].incidenciasEspeciales.incidenciasEspeciales;
              var cliente = empleadoEncontrado[i].nombreComercial;                      
              var sumaDiasFestivos=empleadoEncontrado[i].diasFestivos.diasFestivos;
              var supervisorId = empleadoEncontrado[i].supervisorId;
              var roloperativo=empleadoEncontrado[i].roloperativo;
              var descripcionLineaNegocio=empleadoEncontrado[i].descripcionLineaNegocio;
              if(roloperativo==null || roloperativo=="" ){
                roloperativo="No asignado";
              } 
              
              if(incidenciasEspeciales==null){
                incidenciasEspeciales=0;
              }

              if(descuentos==null){
                descuentos=0;
              }
              
              
              if(sumaTurnosExtras==null){
                sumaTurnosExtras=0;
              }
//supervisorid%%asis e llamara el campo dentro de las opciones del supervisor
//$('#tableEmpleadosAsistencia').html("");
$('#tableEmpleadosAsistencia').append(
  "<tr><td width='80px'>"+numeroEmpleado+"</td><td width='160px'>"+nombreEmpleado+"</td><td width='100px'>"+descripcionPuesto+"</td><td width='140px'>"+entidad+"</td><td width='140px'>"+puntoServicio+"</td><td width='160px'>"+descripcionLineaNegocio+"</td>" + crearCeldasParaPaseAsistencia(numeroEmpleado, nombreEmpleado, asistencia, empleadoIdPuntoServicio,empleadoIdPuesto,entidad,supervisorId,roloperativo,descripcionPuesto,puntoServicio)+"<td width='20px' id='td_te_"+numeroEmpleado+"' name='td_te_"+numeroEmpleado+"' sumaTurnosExtras='"+sumaTurnosExtras+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fecha1='"+fecha1+"' fecha2='"+fecha2+"' tdTipo='turnosExtras'>"+ sumaTurnosExtras +"</td><td width='20px' id='td_df_"+numeroEmpleado+"' name='td_df_"+numeroEmpleado+"' sumaDiasFestivos='"+sumaDiasFestivos+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fecha1='"+fecha1+"' fecha2='"+fecha2+"' tdTipo='diasFestivos'>"+ sumaDiasFestivos +"</td><td width='30px' id='td_des_"+numeroEmpleado+"' name='td_des_"+numeroEmpleado+"' descuentos='"+descuentos+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fecha1='"+fecha1+"' fecha2='"+fecha2+"' tdTipo='descuentos'>"+ descuentos+"</td><td width='20px' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fecha1='"+fecha1+"' fecha2='"+fecha2+"' tdTipo='incidenciasEspeciales'>"+ incidenciasEspeciales +"</td><td name='td_tt_"+ numeroEmpleado+"' id='td_tt_"+numeroEmpleado+"'><div id='divTotal_"+numeroEmpleado+"' id='divTotal_"+numeroEmpleado+"'></div></td></tr>");

var tQuicena=$("#td_tq_"+numeroEmpleado).attr("sumaTurnosPeriodo");
var tExtras=$("#td_te_"+numeroEmpleado).attr("sumaTurnosExtras")
var tDescuentos=$("#td_des_"+numeroEmpleado).attr("descuentos")
var tDiasFestivos=$("#td_df_"+numeroEmpleado).attr("sumaDiasFestivos");

var turnosTotales= parseInt(tQuicena) + parseInt(tExtras) + parseInt(tDiasFestivos) - Math.abs(tDescuentos);
$("#divTotal_"+numeroEmpleado).html(turnosTotales);
}                   
                    //$('#editinplace').html(listaPersonalActivoTable); 
                    loadContextMenu ();
                    tooltipAjax();
                  }
                  else if (response.status == "error" && response.message == "No autorizado")
                  {
                    //window.location = "login.php";
                  }
                },
                error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
                }
              });

waitingDialog.hide();
}



function tableEmpleadosByPeriodorName()
{
  waitingDialog.show();
  var nombre=$("#txtSearchNameAsistencia").val();  
  $("#tableEmpleadosAsistencia").find("tr:gt(0)").remove();


  $.ajax({
    
    type: "POST",
    url: "ajax_getListaEmpleadosAdminNombre.php",
    data : {"fecha1":fecha1, "fecha2":fecha2, "periodoId":periodoId, "nombre":nombre },
    dataType: "json",
    success: function(response) {
      if (response.status == "success")
      {
       
        var empleadoEncontrado = response.listaEmpleados;
        
        if(empleadoEncontrado.length ==0){
          alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>No se encontraron coincidencias</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
          
          $("#alertMsg").html(alertMsg1);
          $(document).scrollTop(0);
          $('#msgAlert').delay(3000).fadeOut('slow');
        }          
        for ( var i = 0; i < empleadoEncontrado.length; i++ ){
          var numeroEmpleado = empleadoEncontrado[i].numeroEmpleado;
          var nombreEmpleado = empleadoEncontrado[i].nombreEmpleado;
          var descripcionPuesto = empleadoEncontrado[i].descripcionPuesto;                      
          var puntoServicio=empleadoEncontrado[i].puntoServicio;
          var empleadoIdPuntoServicio=empleadoEncontrado[i].empleadoIdPuntoServicio;
          var empleadoIdPuesto=empleadoEncontrado[i].empleadoIdPuesto;

          var entidad=empleadoEncontrado[i].Entidad;

          var asistencia = empleadoEncontrado[i].asistencia;
          var sumaTurnosExtras=empleadoEncontrado[i].turnosExtras.sumaTurnosExtras;
          var descuentos=empleadoEncontrado[i].descuentos.descuentos;
          var incidenciasEspeciales=empleadoEncontrado[i].incidenciasEspeciales.incidenciasEspeciales;                                      
          var sumaDiasFestivos=empleadoEncontrado[i].diasFestivos.diasFestivos;
          var supervisorId = empleadoEncontrado[i].supervisorId;
          var roloperativo=empleadoEncontrado[i].roloperativo;
          var descripcionLineaNegocio=empleadoEncontrado[i].descripcionLineaNegocio;
          if(roloperativo==null || roloperativo=="" ){
            roloperativo="No asignado";
          } 

          if(incidenciasEspeciales==null){
            incidenciasEspeciales=0;
          }

          if(descuentos==null){
            descuentos=0;
          }
          
          
          if(sumaTurnosExtras==null){
            sumaTurnosExtras=0;
          }
       
          $('#tableEmpleadosAsistencia').append(
            "<tr><td width='80px'>"+numeroEmpleado+"</td><td width='160px'>"+nombreEmpleado+"</td><td width='100px'>"+descripcionPuesto+"</td><td width='140px'>"+entidad+"</td><td width='140px'>"+puntoServicio+"</td><td width='160px'>"+descripcionLineaNegocio+"</td>" + crearCeldasParaPaseAsistencia(numeroEmpleado, nombreEmpleado, asistencia, empleadoIdPuntoServicio, empleadoIdPuesto,entidad,supervisorId,roloperativo,descripcionPuesto,puntoServicio) +"<td width='20px' id='td_te_"+numeroEmpleado+"' name='td_te_"+numeroEmpleado+"' sumaTurnosExtras='"+sumaTurnosExtras+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fecha1='"+fecha1+"' fecha2='"+fecha2+"' tdTipo='turnosExtras'>"+ sumaTurnosExtras +"</td><td width='20px' id='td_df_"+numeroEmpleado+"' name='td_df_"+numeroEmpleado+"' sumaDiasFestivos='"+sumaDiasFestivos+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fecha1='"+fecha1+"' fecha2='"+fecha2+"' tdTipo='diasFestivos'>"+ sumaDiasFestivos +"</td><td width='30px' id='td_des_"+numeroEmpleado+"' name='td_des_"+numeroEmpleado+"' descuentos='"+descuentos+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fecha1='"+fecha1+"' fecha2='"+fecha2+"' tdTipo='descuentos'>"+ descuentos+"</td><td width='20px' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fecha1='"+fecha1+"' fecha2='"+fecha2+"' tdTipo='incidenciasEspeciales'>"+ incidenciasEspeciales +"</td><td name='td_tt_"+ numeroEmpleado+"' id='td_tt_"+numeroEmpleado+"'><div id='divTotal_"+numeroEmpleado+"' id='divTotal_"+numeroEmpleado+"'></div></td></tr>");

          var tQuicena=$("#td_tq_"+numeroEmpleado).attr("sumaTurnosPeriodo");
          var tExtras=$("#td_te_"+numeroEmpleado).attr("sumaTurnosExtras");
          var tDescuentos=$("#td_des_"+numeroEmpleado).attr("descuentos");
          var tDiasFestivos=$("#td_df_"+numeroEmpleado).attr("sumaDiasFestivos");

          var turnosTotales= parseInt(tQuicena) + parseInt(tExtras) + parseInt(tDiasFestivos) - Math.abs(tDescuentos);
          $("#divTotal_"+numeroEmpleado).html(turnosTotales);
        }                   
                    //$('#editinplace').html(listaPersonalActivoTable); 
                    loadContextMenu ();
                    tooltipAjax();

                  }
                  else if (response.status == "error" && response.message == "No autorizado")
                  {
                    //window.location = "login.php";
                  }
                },
                error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
                }
              });

waitingDialog.hide();
}


function crearCeldasParaPaseAsistencia (numeroEmpleado, nombreEmpleado, asistencia, empleadoIdPuntoServicio, empleadoIdPuesto,entidad,supervisorId,roloperativo,descripcionPuesto,puntoServicio)
{
    // Variables Globales
    // fechasAsistencia
    // turnosCubiertos

    var result = "";
    var sumaTurnosPeriodo=0;
    

    for (var i = 0; i < fechasAsistencia.length; i++)
    {


     
      fechaAsistencia = fechasAsistencia [i];
      

      var asistenciaText = "[__]";
      var puntoServiciosIncidencia="";
      var puntoServicioAsistenciaId=empleadoIdPuntoServicio;
      var comentarioIncidencia="";
      var incidenciaAsistenciaId="";
      var puestoCubiertoId=empleadoIdPuesto;
      var folioincapacidad="";
      

      if (asistencia [fechaAsistencia] != null)
      {
        asistenciaText = asistencia [fechaAsistencia]["nomenclaturaIncidencia"];
        puntoServiciosIncidencia= asistencia [fechaAsistencia]["puntoServicio"];
        puntoServicioAsistenciaId= asistencia [fechaAsistencia]["puntoServicioAsistenciaId"];
        comentarioIncidencia=asistencia [fechaAsistencia]["comentarioIncidencia"];
        incidenciaAsistenciaId=asistencia [fechaAsistencia]["incidenciaAsistenciaId"];
        valorAsistencia=asistencia [fechaAsistencia]["valorAsistencia"];  
        puestoCubiertoId=asistencia[fechaAsistencia]["puestoCubiertoId"]; 
        folioincapacidad=asistencia[fechaAsistencia]["folioIncapacidad"];         
        
            //console.log (asistencia);
            //console.log (puntoServicioAsistenciaId);

            if(valorAsistencia== null)
            {
              valorAsistencia=0;
            }

            sumaTurnosPeriodo = parseInt(sumaTurnosPeriodo) + parseInt(valorAsistencia);

            if (turnosCubiertos [fechaAsistencia] == null)
            {
              turnosCubiertos [fechaAsistencia] = 0;
            }

            if (asistencia [fechaAsistencia]["puntoServicioAsistenciaId"] == empleadoIdPuntoServicio)
            {
               turnosCubiertos [fechaAsistencia] += 1; //asistencia [fechaAsistencia]["valorAsistencia"];
             }
           }

           var id = numeroEmpleado + puntoServicioAsistenciaId + fechaAsistencia;

           var style = styles [asistenciaText];

           result += "<td width='40px' align='center'  style='" + style + "' id='td_"+id+"' name='td_"+id+"' class='demo1' numeroEmpleado='" + numeroEmpleado + "' fechaAsistencia='" + fechaAsistencia + "' nombreEmpleado='" + nombreEmpleado + "' puntoServicioAsistenciaId='" + puntoServicioAsistenciaId + "' comentarioIncidencia='" + comentarioIncidencia + "', incidenciaAsistenciaId = '" +incidenciaAsistenciaId+ "' asistenciaText='" +asistenciaText+ "' supervisorId='"+supervisorId+"'  empleadoIdPuesto='"+puestoCubiertoId+"' entidadTrabajo='"+entidad+"'  folioincapacidad='"+folioincapacidad+"' plantillaservicio='"+roloperativo+"' PuestoDescripcion='"+descripcionPuesto+"'puntoServicioDescripcion='"+puntoServicio+"'>";


           if(incidenciaAsistenciaId!=8){
             result += "<a  id='" + id + "' href='javascript:mostrarOpcionesParaPaseDeLista (\"" + id + "\");' >" + asistenciaText +"</a></td>";
           }else{

             result += "<a  id='" + id + "'>" + asistenciaText +"</a></td>";
           }

           
         }
         result +="<td width='20px' id='td_tq_"+numeroEmpleado+"' name='td_tq_"+numeroEmpleado+"' sumaTurnosPeriodo='"+ sumaTurnosPeriodo +"'>"+sumaTurnosPeriodo+"</td>";

         return result;
       }


       function loadContextMenu ()
       {
        $(".demo1").contextMenu('myMenu1', {
          bindings: {
            'open': function(t) {
              alert('Trigger was '+t.id+'\nAction was Open');
            },
            'incidencia': function(t) {
              var id= t.id;
              var incidenciaAsistenciaId = $("#" + id).attr ("incidenciaAsistenciaId");
              var numeroEmpleado = $("#" + id).attr ("numeroEmpleado");
              var fechaAsistencia = $("#" + id).attr ("fechaAsistencia");
              if(incidenciaAsistenciaId!=8){
                $.ajax({
                  type: "POST",
                  url: "ajax_getEstatusEmpleadoxFecha.php",
                  data: {"numeroEmpleado":numeroEmpleado},
                  dataType: "json",
                  success: function(response) {
                    var EmpleadoEstatus = response.datos[0]["EstatusEmpleado"];
                    var FechaEmpleadoEst = response.datos[0]["FechaBajaEmpleado"];
                    var FechaActual = response.datos[0]["FechaActual"];
              if(EmpleadoEstatus=='0'){// condicion con fecha ) && ((FechaEmpleadoEst <= FechaActual) || (FechaEmpleadoEst <= fechaAsistencia))
                $("#modalempleadobaja").modal("show");
                $("#NumeroConsulaEMpleadoBaja").html(numeroEmpleado + " Se Encuentra En Estatus Baja");
              }else{
                if (incidenciaAsistenciaId != 10 && incidenciaAsistenciaId != 11)
                {
                  modalIncidenciaEspecial(id);
                }
              }
            },
            error: function(jqXHR, textStatus, errorThrown){
              alert(jqXHR.responseText);
            }
          });
              }
            },
            'borrarIncidencia': function(t) {
              //alert(t);
              //console.log(t);
              var id= t.id;
              var numeroEmpleado = $("#" + id).attr ("numeroEmpleado");
              var fechaAsistencia = $("#" + id).attr ("fechaAsistencia");
              var nombreEmpleado = $("#" + id).attr ("nombreEmpleado");
              var puntoServicioAsistenciaId = $("#" + id).attr ("puntoServicioAsistenciaId");
              var comentarioIncidencia = $("#" + id).attr ("comentarioIncidencia");
              var incidenciaAsistenciaId = $("#" + id).attr ("incidenciaAsistenciaId");
              var asistenciaText = $("#" + id).attr ("asistenciaText");
              var folioincapacidad=$("#" + id).attr ("folioincapacidad");
              $.ajax({
                type: "POST",
                url: "ajax_getEstatusEmpleadoxFecha.php",
                data: {"numeroEmpleado":numeroEmpleado},
                dataType: "json",
                success: function(response) {
                  var EmpleadoEstatus = response.datos[0]["EstatusEmpleado"];
                  var FechaEmpleadoEst = response.datos[0]["FechaBajaEmpleado"];
                  var FechaActual = response.datos[0]["FechaActual"];
              if(EmpleadoEstatus=='0'){ // condicion con fecha ) && ((FechaEmpleadoEst <= FechaActual) || (FechaEmpleadoEst <= fechaAsistencia))
                $("#modalempleadobaja").modal("show");
                $("#NumeroConsulaEMpleadoBaja").html(numeroEmpleado + " Se Encuentra En Estatus Baja");
              }else{
                if (incidenciaAsistenciaId != 10 && incidenciaAsistenciaId != 11 )
                {
                  deleteAsistencia(numeroEmpleado,fechaAsistencia, puntoServicioAsistenciaId, incidenciaAsistenciaId, '', '[__]',folioincapacidad);
                }
              }
            },
            error: function(jqXHR, textStatus, errorThrown){
              alert(jqXHR.responseText);
            }
          });
            }
          }
        });
      }
      function tooltipAjax(){
        
        $(".tooltipster_item").tooltipster ({

          trigger: 'click',
          contentAsHTML: true,

          functionBefore: function(instance, helper) {
            
            var $origin = $(helper.origin);
            
                        // we set a variable so the data is only loaded once via Ajax, not every time the tooltip opens
                        if ($origin.data('loaded') !== true) {

                          var fecha1=$origin.attr('fecha1')
                          var fecha2=$origin.attr('fecha2');
                          var numeroEmpleado=$origin.attr('numeroEmpleado');
                          var tdTipo=$origin.attr('tdTipo');


                          if(tdTipo=='turnosExtras'){

                            $.get('ajax_getTurnosExtras.php?fecha1='+fecha1+'&fecha2='+fecha2+'&numeroEmpleado='+numeroEmpleado+'', function(data) {
                              
                              var html = "<div>";

                              data = $.parseJSON (data);
                              
                              if (data.lista.length === 0)
                              {
                                html += "Sin datos";
                              }

                              for (var i=0; i < data.lista.length; i++)
                              {
                                var incidenciaId = data.lista[i].incidenciaId;
                                var incidenciaFecha= data.lista[i].incidenciaFecha;
                                var incidenciaComentario = data.lista[i].incidenciaComentario;
                                var puntoServicio = data.lista[i].puntoServicio;
                                
                                html+= "TURNO EXTRA | fecha: "+incidenciaFecha+" | Punto:"+puntoServicio+" | Comentario: "+ incidenciaComentario+"<br>";
                              }

                              html+= "</div>";

                              instance.content(html);

                              // to remember that the data has been loaded
                              $origin.data('loaded', true);
                          }); //Fin ajax
                          }else if(tdTipo=='descuentos'){

                            $.get('ajax_getDescuentos.php?fecha1='+fecha1+'&fecha2='+fecha2+'&numeroEmpleado='+numeroEmpleado+'', function(data) {
                              
                              var html = "<div>";

                              data = $.parseJSON (data);
                              
                              if (data.lista.length === 0)
                              {
                                html += "Sin datos";
                              }

                              for (var i=0; i < data.lista.length; i++)
                              {
                                var incidenciaId = data.lista[i].incidenciaId;
                                var incidenciaFecha= data.lista[i].incidenciaFecha;
                                var incidenciaComentario = data.lista[i].incidenciaComentario;
                                
                                html+= "DESCUENTO | fecha: "+incidenciaFecha+" | Comentario: "+ incidenciaComentario+"<br>";
                              }

                              html+= "</div>";

                              instance.content(html);

                              // to remember that the data has been loaded
                              $origin.data('loaded', true);
                          }); //Fin ajax

                          }else if(tdTipo=='incidenciasEspeciales'){

                            $.get('ajax_getIncidenciasEspeciales.php?fecha1='+fecha1+'&fecha2='+fecha2+'&numeroEmpleado='+numeroEmpleado+'', function(data) {
                              
                              var html = "<div>";

                              data = $.parseJSON (data);
                              
                              if (data.lista.length === 0)
                              {
                                html += "Sin datos";
                              }

                              for (var i=0; i < data.lista.length; i++)
                              {
                                var descripcionIncidenciaEspecial = data.lista[i].descripcionIncidenciaEspecial;
                                var incidenciaFecha= data.lista[i].incidenciaFecha;
                                var incidenciaComentario = data.lista[i].incidenciaComentario;
                                
                                html+= descripcionIncidenciaEspecial+" | fecha: "+incidenciaFecha+" | Comentario: "+ incidenciaComentario+"<br>";
                              }

                              html+= "</div>";

                              instance.content(html);

                              // to remember that the data has been loaded
                              $origin.data('loaded', true);
                          }); //Fin ajax

                        } // fin if tipo de consulta
                        
                      }
                    }

                  });
}


function modalIncidenciaEspecial(id){
  $("#myModalIncidenciaEspecial").modal();
  
  var numeroEmpleado = $("#" + id).attr ("numeroEmpleado");
  var fechaAsistencia = $("#" + id).attr ("fechaAsistencia");
  var nombreEmpleado = $("#" + id).attr ("nombreEmpleado");
  var puntoServicioAsistenciaId = $("#" + id).attr ("puntoServicioAsistenciaId");
  var comentarioIncidencia = $("#" + id).attr ("comentarioIncidencia");
  var incidenciaAsistenciaId = $("#" + id).attr ("incidenciaAsistenciaId");
  var asistenciaText = $("#" + id).attr ("asistenciaText");        
  var puestosCobertura=$("#" + id).attr("empleadoIdPuesto");

  $("#txtNombreEmpleadoIncidencia").val(nombreEmpleado);
  $("#txtNumeroEmpleadoIncidencia").val(numeroEmpleado);
  $("#txtFechaIncidencia").val(fechaAsistencia);
  $("#selectPuntoIncidencia").val(puntoServicioAsistenciaId); 
  $("#txtPuntoOcultoIE").val(puntoServicioAsistenciaId);   
  $("#txtPuestoOcultoIE").val(puestosCobertura);            
}


function mostrarOpcionesParaPaseDeLista (id)
{    
  var numeroEmpleado = $("#td_" + id).attr ("numeroEmpleado");
  var fechaAsistencia = $("#td_" + id).attr ("fechaAsistencia");
  var nombreEmpleado = $("#td_" + id).attr ("nombreEmpleado");
  var puntoServicioAsistenciaId = $("#td_" + id).attr ("puntoServicioAsistenciaId");
  var comentarioIncidencia = $("#td_" + id).attr ("comentarioIncidencia");
  var incidenciaAsistenciaId = $("#td_" + id).attr ("incidenciaAsistenciaId");
  var asistenciaText = $("#td_" + id).attr ("asistenciaText");              
  var entidad = $("#td_" + id).attr ("entidadTrabajo"); 
  var empleadoIdPuesto=$("#td_"+id).attr("empleadoIdPuesto");
  var supervisorId=$("#td_"+id).attr("supervisorId");
  var roloperativoadministrativo=$("#td_"+id).attr("plantillaservicio");
  var PuestoDescripcion=$("#td_"+id).attr("PuestoDescripcion");
  var puntoServicioDescripcion=$("#td_"+id).attr("puntoServicioDescripcion");
  if(supervisorId==="--"  || supervisorId==="undefined" ||  supervisorId==undefined || supervisorId==null ){
        supervisorId="09-0017-02";//supervisor asignado fijamente para el pase de asistencia en este caso es del encargado del sistema que es el C.P JOSE LUIS LEON PEREZ
      }
  $("#inpsupervisoradministrativoid").val(supervisorId);
  $("#inppuntoservicioadministrativo").val(puntoServicioAsistenciaId);//campodel modalincapacidad
  $("#inpempleadoidpuesto").val(empleadoIdPuesto);
  $("#roloperativoadministrativo").val(roloperativoadministrativo);
  $("#PuestoDescripcionhdn").val(PuestoDescripcion);
  $("#puntoServicioDescripcionhdn").val(puntoServicioDescripcion);


      var respuestaIncapacidad=consultarultimoestatusincapacidad(numeroEmpleado);
      if(respuestaIncapacidad){

        $.ajax({
          type: "POST",
          url: "ajax_getEstatusEmpleadoxFecha.php",
          data: {"numeroEmpleado":numeroEmpleado},
          dataType: "json",
          success: function(response) {

            var EmpleadoEstatus = response.datos[0]["EstatusEmpleado"];
            var FechaEmpleadoEst = response.datos[0]["FechaBajaEmpleado"];
            var FechaActual = response.datos[0]["FechaActual"];
            

          if(EmpleadoEstatus=='0'){// restriccion con fecha ) && ((FechaEmpleadoEst <= FechaActual) || (FechaEmpleadoEst <= fechaAsistencia))
            $("#modalempleadobaja").modal("show");
            $("#NumeroConsulaEMpleadoBaja").html(numeroEmpleado + " Se Encuentra En Estatus Baja");
          }else{
            if (incidenciaAsistenciaId!=11 && incidenciaAsistenciaId!= 10 ){
              $("#myModalAsistencia").modal();
              $("#txtComentarioIncidencia").val("");        
              $("#txtNumeroEmpleadoAsistencia").val(numeroEmpleado);
              $("#txtFechaAsistencia").val(fechaAsistencia);
              $("#txtNombreEmpleadoAsistencia").val(nombreEmpleado);        
              $("#txtEntidadEmp").val(entidad);
              $("#txtPuntoOculto").val(puntoServicioAsistenciaId);
              $("#txtComentarioIncidencia").val(comentarioIncidencia); 
              $("#txtPuestoOculto").val(empleadoIdPuesto);
              $("#NombreEmpleadoVacacionesAdmin").val("");
              $("#numempleadovacacionesAdmin").val("");
              $("#RolOperativoVacacionesAdmin").val("");
              $("#NombreEmpleadoVacacionesAdmin").val(nombreEmpleado);
              $("#numempleadovacacionesAdmin").val(numeroEmpleado);
              $("#RolOperativoVacacionesAdmin").val(roloperativoadministrativo);

              <?php
              for ( $i=0; $i<count($catalogoIncidencias); $i++)
              {
                echo "$('#a_" . $catalogoIncidencias[$i]["incidenciaId"] . "').removeClass ('elementoActivo');";
              }
              ?>
              $("#a_"+incidenciaAsistenciaId).addClass("elementoActivo");        
              $("#idCell").val (id);
            }

          }
        },
        error: function(jqXHR, textStatus, errorThrown){
          alert(jqXHR.responseText);
        }
      });
      }
    }

    function registrarIncidenciaEspecial ()
    {

      var numeroEmpleado = $("#txtNumeroEmpleadoIncidencia").val();
      var asistenciaFecha =$("#txtFechaIncidencia").val();

      var elementosNumeroEmpleado = numeroEmpleado.split ("-");

      var empleadoEntidadId = elementosNumeroEmpleado[0];
      var empleadoConsecutivoId = elementosNumeroEmpleado[1];
      var empleadoTipoId = elementosNumeroEmpleado[2];

      var empleadoPuntoServicioId = $("#txtPuntoOcultoIE").val();
      var comentariIncidencia=$("#txtComentarioIncidenciaEspecial").val();
      var tipoPeriodo = $('input:radio[name=optionPeriodo]:checked').val();  

      var supervisorEntidadId = '09';
      var supervisorConsecutivoId = '0017';
      var supervisorTipoId = '02';
      var incidenciaPuesto=$("#txtPuestoOcultoIE").val();

      var incidenciaId=$("#selectIncidenciaEspecial").val();   
      var selplantillaservicioincidencia='HORARIO OFICINA'; 
    //alert(idCliente);

    $.ajax ({
      type: "POST",
      url: "ajax_registrarIncidenciaEspecialAdmin.php",
      data: {empleadoEntidadId:empleadoEntidadId, empleadoConsecutivoId: empleadoConsecutivoId, empleadoTipoId:empleadoTipoId, empleadoPuntoServicioId: empleadoPuntoServicioId, supervisorEntidadId:supervisorEntidadId, supervisorConsecutivoId: supervisorConsecutivoId, supervisorTipoId:supervisorTipoId, incidenciaId:incidenciaId, asistenciaFecha:asistenciaFecha, comentariIncidencia:comentariIncidencia, tipoPeriodo:tipoPeriodo, incidenciaPuesto:incidenciaPuesto, idCliente:2,selplantillaservicioincidencia:selplantillaservicioincidencia},
      dataType: "json",
      success: function (response){
        var mensaje=response.message;

        if (response.status=="success") {
         

          alertMsg1="<div id='msgAlert' class='alert alert-success'><trong>Incidencia Especial:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
          
          $("#alertMsgIncidencia").html(alertMsg1);
          $('#msgAlert').delay(3000).fadeOut('slow');
          $("#txtComentarioIncidenciaEspecial").val("");
          
          $("#myModalIncidenciaEspecial").modal("hide");

          consultaPersonalAdmin();
          
        } else if (response.status=="error")
        {
          alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
          
          $("#alertMsgIncidencia").html(alertMsg1);
          $('#msgAlert').delay(3000).fadeOut('slow');
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);                   
      }
    });
  }


  function deleteAsistencia (idEmpleado,fechaAsistencia, puntoServicio, incidenciaId, incidenciaText, nomenclaturaIncidencia,folioincapacidad)
  {
    //alert(incidenciaId);
    waitingDialog.show();

    var numeroEmpleado = idEmpleado;
    var asistenciaFecha = fechaAsistencia;

    var elementosNumeroEmpleado = numeroEmpleado.split ("-");

    var empleadoEntidadId = elementosNumeroEmpleado[0];
    var empleadoConsecutivoId = elementosNumeroEmpleado[1];
    var empleadoTipoId = elementosNumeroEmpleado[2];

    var empleadoPuntoServicioId =puntoServicio;
    
    var tipoPeriodo = $('input:radio[name=optionPeriodo]:checked').val();
    
    $.ajax ({
      type: "POST",
      url: "ajax_deleteAsistenciaFromAsistencia.php",
      data: {empleadoEntidadId:empleadoEntidadId, empleadoConsecutivoId: empleadoConsecutivoId, empleadoTipoId:empleadoTipoId, asistenciaFecha:asistenciaFecha, tipoPeriodo:tipoPeriodo,incidenciaId:incidenciaId,folioincapacidad:folioincapacidad},
      dataType: "json",
      async:false,
      success: function (response) {
        if (response.status == "error")
        {
          alert (response.message);
        }
        else
        {
          id = empleadoEntidadId + "-" + empleadoConsecutivoId + "-" + empleadoTipoId + empleadoPuntoServicioId + asistenciaFecha;

          $("#" + id).html (nomenclaturaIncidencia);

          var style = styles [nomenclaturaIncidencia];
          if (style == null)
          {
            style = "";
          }
          
          $("#td_"+id).attr("style",style);
          $("#" + id).attr ("incidenciaAsistenciaId", incidenciaId);
          $("#" + id).attr ("incidenciaText",  nomenclaturaIncidencia);

          if(busqueda=="numeroEmpleado"){

            tableEmpleadosByIdEmpleado();

          }else if(busqueda="nombreEmpleado"){
            tableEmpleadosByPeriodorName();
          }else{
            consultaPersonalAdmin();
          }
                          

        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText); 
                  //alert("Error funcion")
        }
    });
  waitingDialog.hide();    
  }

  function registrarPaseDeLista (incidenciaId, incidenciaText, nomenclaturaIncidencia)
  {
    var puntoServicio = $("#txtPuntoOculto").val();
    var asistenciaFecha = $("#txtFechaAsistencia").val();    
    var puestoCubiertoId = $("#txtPuestoOculto").val();  
    var numeroEmpleado = $("#txtNumeroEmpleadoAsistencia").val();
    var elementosNumeroEmpleado = numeroEmpleado.split("-");

    var empleadoEntidadId = elementosNumeroEmpleado[0];
    var empleadoConsecutivoId = elementosNumeroEmpleado[1];
    var empleadoTipoId = elementosNumeroEmpleado[2];
    
    var comentariIncidencia=$("#txtComentarioIncidencia").val();
    var tipoPeriodo = $('input:radio[name=optionPeriodo]:checked').val();   
    var selplantillaservicioincidencia='HORARIO OFICINA';      
    //alert(incidenciaId);

    if(incidenciaId==8){
      $("#ModalIncapacidad").modal();
      $("#myModalAsistencia").modal('hide');
      $("#txtFechaIncapacidad").val(asistenciaFecha);
      $("#txtNumeroEmpleadoIncapacidad").val(numeroEmpleado);
      $("#txtNombreEmpleadoIncapacidad").val($("#txtNombreEmpleadoAsistencia").val());
      $("#inpfolioincapacidad").attr('maxlength','8');
      $("#selectTipoIncapacidad").val(0).prop("disabled",false);
      $("#divmuestrast7").hide();
      $("#divmuestrast2").hide();
      $( "#divmuestraEnfermedadGeneral").hide();
      $("#inpfolioincapacidad").val("");
      $("#selectTipoIncapacidad").val(0);
      $("#inpdiasincapacidad").val("");
      $("#archivost7").val("");
      $("#archivost2").val("");
      st7="";
      st2="";

    }else if (incidenciaId==5 || incidenciaId==6 ){
    $("#empleadoEntidadIdVacacionesAdmin").val(empleadoEntidadId);
    $("#empleadoConsecutivoIdVacacionesAdmin").val(empleadoConsecutivoId);
    $("#empleadoTipoIdVacacionesAdmin").val(empleadoTipoId);
    $("#empleadoPuntoServicioIdVacacionesAdmin").val(puntoServicio);
    $("#incidenciaIdVacacionesAdmin").val(incidenciaId);
    $("#asistenciaFechaVacacionesAdmin").val(asistenciaFecha);
    $("#comentariIncidenciaVacacionesAdmin").val(comentariIncidencia);
    $("#tipoPeriodoVacacionesAdmin").val(tipoPeriodo);
    $("#puestoCubiertoIdVacacionesAdmin").val(puestoCubiertoId);
    $("#plantilladeservicioVacacionesAdmin").val(selplantillaservicioincidencia);
    $("#incidenciaVacacionesAdmin").val(incidenciaId);
    abrirmodalvacacionesAdmin(numeroEmpleado,nomenclaturaIncidencia);
  }// este if es para las peticiones que son de vacaciones unicamente
  else if(incidenciaId==10){

        var NombreE = $("#txtNombreEmpleadoAsistencia").val();//nombre empleado baja
        var NumeroE = $("#txtNumeroEmpleadoAsistencia").val();//numero mepleado baja
        var PuntoE = $("#puntoServicioDescripcionhdn").val();
        var PuestE = $("#PuestoDescripcionhdn").val();
        $("#abandonoServicioAdmin").prop("checked", false);
        $("#faltasInjustiicadasAdmin").prop("checked", false);
        $("#indiciplinaAdmin").prop("checked", false);
        $("#terminoServicioAdmin").prop("checked", false);
        $("#otrosAdmin").prop("checked", false);
        $("#especifiqueMotivoAdmin").val("");
        $("#NombreSolicitanteAdmin").val("");
        $("#FirmaInternaAdmin").val("");
        var fehcaBajaM1 = new Date;
        var fehcaBajaM=(fehcaBajaM1.getFullYear() + "-" + (fehcaBajaM1.getMonth() +1) + "-" + fehcaBajaM1.getDate());

          $("#FechaBajaEmpModalAdmin").val(fehcaBajaM);
          $("#NumEmpModalAdmin").val(NumeroE);
          $("#NumEmpModal1Admin").val(NumeroE);
          $("#NombreEMpModalAdmin").val(NombreE);
          $("#PuestoEmpModalAdmin").val(PuestE);
          $("#PuntoEmpModalAdmin").val(PuntoE);
          $("#nomenclaturaIncidenciaHiddenBajaEmpAdmin").val(nomenclaturaIncidencia);
          $("#modalBajaEmpeladoAdmin").modal();
          $("#myModalAsistencia").modal("hide");
      }//cierra El else de Baja
    else{
      $.ajax ({            
        type: "POST",
        url: "ajax_registrarAsistenciaAdmin.php",
        data: {empleadoEntidadId:empleadoEntidadId, empleadoConsecutivoId: empleadoConsecutivoId, empleadoTipoId:empleadoTipoId, 
          puntoServicio: puntoServicio, incidenciaId:incidenciaId, asistenciaFecha:asistenciaFecha, comentariIncidencia:comentariIncidencia, tipoPeriodo:tipoPeriodo, puestoCubiertoId:puestoCubiertoId,selplantillaservicioincidencia:selplantillaservicioincidencia},
          dataType: "json",
          success: function (response) {
            
            if (response.status == "error")
            {
                    //alert (response.message);
                    valordia=0;
                    alert (response.message);
                  }
                  else 
                  {
                    id = $("#idCell").val ();

                    $("#" + id).html (nomenclaturaIncidencia);

                    var style = styles [nomenclaturaIncidencia];
                    

                    $("#td_"+id).attr("style",style);
                    
                    $("#" + id).attr ("incidenciaAsistenciaId", incidenciaId);
                    $("#" + id).attr ("incidenciaText",  nomenclaturaIncidencia);                    
                    valordia=0;
                    if (response.asistencia != null)
                    {
                      for (var k in response.asistencia)
                      {
                        fecha = k;
                        id = empleadoEntidadId + "-" + empleadoConsecutivoId + "-" + empleadoTipoId + puntoServicio + fecha;

                            //console.log ("id: " + id);

                            nomenclaturaIncidencia = response.asistencia[k].nomenclaturaIncidencia;
                            incidenciaId = response.asistencia[k].incidenciaAsistenciaId;

                            $("#" + id).html (nomenclaturaIncidencia);

                            var style = styles [nomenclaturaIncidencia];
                            

                            $("#td_"+id).attr("style",style);
                            
                            $("#" + id).attr ("incidenciaAsistenciaId", incidenciaId);
                            $("#" + id).attr ("incidenciaText",  nomenclaturaIncidencia);
                          }
                        }
                      if(busqueda=="numeroEmpleado"){

                          tableEmpleadosByIdEmpleado();

                        }else if(busqueda="nombreEmpleado"){
                          tableEmpleadosByPeriodorName();
                        }else{
                            consultaPersonalAdmin();
                         }
                        
                      }
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                      alert(jqXHR.responseText);                   
                    }
                  });
      $("#myModalAsistencia").modal("hide");
    }
    //$("#myModalAsistencia").modal("hide");
    
    
  }

  /*////////////////////////////////////Modificacion Para La Baja De Un Elemento////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/

$('#faltasInjustiicadasAdmin').change(function() {
    if ($('#faltasInjustiicadasAdmin').is(":checked")) {
      $("#abandonoServicioAdmin").prop("checked", false);
      $("#indiciplinaAdmin").prop("checked", false);
      $("#terminoServicioAdmin").prop("checked", false);
      $("#otrosAdmin").prop("checked", false);
    } 
  });
$('#abandonoServicioAdmin').change(function() {
    if ($('#abandonoServicioAdmin').is(":checked")) {
      $("#faltasInjustiicadasAdmin").prop("checked", false);
      $("#indiciplinaAdmin").prop("checked", false);
      $("#terminoServicioAdmin").prop("checked", false);
      $("#otrosAdmin").prop("checked", false);

    } 
  });$('#indiciplinaAdmin').change(function() {
    if ($('#indiciplinaAdmin').is(":checked")) {
      $("#faltasInjustiicadasAdmin").prop("checked", false);
      $("#abandonoServicioAdmin").prop("checked", false);
      $("#terminoServicioAdmin").prop("checked", false);
      $("#otrosAdmin").prop("checked", false);

    } 
  });$('#terminoServicioAdmin').change(function() {
    if ($('#terminoServicioAdmin').is(":checked")) {
      $("#faltasInjustiicadasAdmin").prop("checked", false);
      $("#abandonoServicioAdmin").prop("checked", false);
      $("#indiciplinaAdmin").prop("checked", false);
      $("#otrosAdmin").prop("checked", false);

    } 
  });$('#otrosAdmin').change(function() {
    if ($('#otrosAdmin').is(":checked")) {
      $("#faltasInjustiicadasAdmin").prop("checked", false);
      $("#abandonoServicioAdmin").prop("checked", false);
      $("#indiciplinaAdmin").prop("checked", false);
      $("#terminoServicioAdmin").prop("checked", false);

    } 
  });

function firmarDocumentoAdmin(){
  $("#NumEmpModalBajaAdmin").val("");
  $("#constraseniaFirmaAdmin").val("");
  $("#modalFirmaElectronicaAdmin").modal();
  $("#modalBajaEmpeladoAdmin").modal("hide");
}

function cancelarFirmaAdmin(){
  $("#modalFirmaElectronicaAdmin").modal("hide");
  $("#modalBajaEmpeladoAdmin").modal();
  $("#NumEmpModalBajaAdmin").val("");
  $("#constraseniaFirmaAdmin").val("");
}

$("#NumEmpModalBajaAdmin").keyup(function () 
{

 var NumEmpModalBaja = $("#NumEmpModalBajaAdmin").val();
 var expreg = /^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/;
 var expreg1 = /^[0-9]{2}\-[0-9]{5}\-[0-9]{2}/;
 
 if(expreg.test(NumEmpModalBaja) || expreg1.test(NumEmpModalBaja)){
    consultaEmpleadoFirmaInternaBajaAdmin(NumEmpModalBaja);
  }else{
    //cargaerroresFirmaInternaBaja("El Formato Del Numero De Empleado Es Incorrecto");
    $("#constraseniaFirmaAdmin").val("");
    $("#btnFirmarDocAdmin").hide();
  }
});

function cargaerroresFirmaInternaBajaAdmin(mensaje){
  $('#errorModalFirmaInternaAdmin').fadeIn();
  msjerrorbaja="<div id='errorModalFirmaInternaAdmin1' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errorModalFirmaInternaAdmin").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errorModalFirmaInternaAdmin').delay(4000).fadeOut('slow'); 
}

function consultaEmpleadoFirmaInternaBajaAdmin(numeroEmpleado){
  var caso="1";
  $.ajax({
    type: "POST",
    url: "ajax_obtenerEmpleadoPorIdFirmaBaja.php",
    data:{"numeroEmpleado":numeroEmpleado,"caso":caso},
    dataType: "json",
    success: function(response) {
      if (response.status == "success"){
        var empleadoExtiste = response["empleado"].length;
        if(empleadoExtiste=="0"){
          cargaerroresFirmaInternaBajaAdmin("El Empleado No Existe En La Base De Registro De Firmas Favor De Verificar");
          $("#NumEmpModalBajaAdmin").val("");
          $("#btnFirmarDocAdmin").hide();
        }else {
          var EstatusFirmaInterna = response.empleado[0].EstatusFirmaInterna;
          if(EstatusFirmaInterna=="0"){
            cargaerroresFirmaInternaBajaAdmin("Esta Firma Fue Dada De Baja Favor de solicitar Otra o Comunicarse Con RH"); 
            $("#NumEmpModalBajaAdmin").val("");
            $("#btnFirmarDocAdmin").hide();
          }else{
            $("#btnFirmarDocAdmin").show();
          }
        }
      }else{
        cargaerroresFirmaInternaBajaAdmin(response.menssaje); 
        $("#NumEmpModalBajaAdmin").val("");
        $("#btnFirmarDocAdmin").hide();
      }
    },error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }

  });
}


function RevisarFirmaInternaAdmin(){
  var NumEmpModalBaja = $("#NumEmpModalBajaAdmin").val();
  var constraseniaFirma = $("#constraseniaFirmaAdmin").val();
 
 if(NumEmpModalBaja==""){
   cargaerroresFirmaInternaBajaAdmin("El numero de empleado no puede estar vaacio");
  }else if(constraseniaFirma==""){
     cargaerroresFirmaInternaBajaAdmin("Escriba la contraseña para continuar");
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
          cargaerroresFirmaInternaBajaAdmin("La Contraseña ingresada es incorrecta favor de escribrla exactamente como la ingreso en el registro");
        }else{
          var nombre = response.datos["0"].nombreEmpleado + " " + response.datos["0"].apellidoPaterno + " " + response.datos["0"].apellidoMaterno;
          var contraseniaInsertadaCifrada =response.datos["0"].ContraseniaFirma;
          $("#numempleadoFirmahiddenAdmin").val(NumEmpModalBaja);
          $("#NombreSolicitanteAdmin").val(nombre);
          $("#FirmaInternaAdmin").val(contraseniaInsertadaCifrada);
          $("#modalFirmaElectronicaAdmin").modal("hide");
          $("#modalBajaEmpeladoAdmin").modal();
          $("#NumEmpModalBajaAdmin").val("");
          $("#constraseniaFirmaAdmin").val("");
        }
         
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
    });
  }
}

function mensajeErrorModalBaja1Admin(Tipo,mensaje){
  $('#msgerrormodalbajaAdmin').fadeIn();
  msjerrorbaja="<div id='msgerrormodalbajaAdmin' class='alert alert-"+Tipo+"'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errorModalBajaEmpleadoAdmin").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#msgerrormodalbajaAdmin').delay(4000).fadeOut('slow'); 
}

function GuardarDocumentoBajaAdmin(){
  var txtNumeroEmpleadoAsistencia = $("#txtNumeroEmpleadoAsistencia").val();
  var numempBajaExplode = txtNumeroEmpleadoAsistencia.split ("-");
  var empleadoEntidadId = numempBajaExplode[0];
  var empleadoConsecutivoId = numempBajaExplode[1];
  var empleadoTipoId = numempBajaExplode[2];
  var MotivoBaja = "0";
  var especifiqueMotivo1 = $("#especifiqueMotivoAdmin").val();
  var numempleadoFirmahidden = $("#numempleadoFirmahiddenAdmin").val();
  var FirmaInterna = $("#FirmaInternaAdmin").val();
  var asistenciaFecha = $("#txtFechaAsistencia").val();//baja formulario
  var FechaBajaEmpModal = $("#FechaBajaEmpModalAdmin").val();//actual
  var ComentarioBetadoAsistencia = $("#ComentarioBetadoAsistenciaAdmin").val();
  var banderaBetadoAsistencia = $("#banderaBetadoAsistenciaAdmin").val();
  if ($('#terminoServicioAdmin').is(":checked")) {
    MotivoBaja = "6";
  }else if ($('#faltasInjustiicadasAdmin').is(":checked")) {
    MotivoBaja = "9";
  }else if ($('#abandonoServicioAdmin').is(":checked")) {
    MotivoBaja = "7";
  }else if ($('#indiciplinaAdmin').is(":checked")) {
    MotivoBaja = "10";
  }else if ($('#otrosAdmin').is(":checked")) {
    MotivoBaja = "12";
  }else{
    MotivoBaja = "0";
  }
  if(MotivoBaja=="0"){
     mensajeErrorModalBaja1Admin("error","Marca una de las opciones del motivo de baja para continuar");
  }else if(especifiqueMotivo1==""){
    mensajeErrorModalBaja1Admin("error","Especifique el motivo de la baja ")
  }else if(numempleadoFirmahidden=="" || FirmaInterna==""){
    mensajeErrorModalBaja1Admin("error","El documento debe estar firmado para continuar Favor de firmar el documento con el boton verde")
  }else if(banderaBetadoAsistencia=="" || banderaBetadoAsistencia=="null" || banderaBetadoAsistencia=="NULL" || banderaBetadoAsistencia==null){
     mensajeErrorModalBaja1Admin("error","Seleccione una opcion de la pregunta ¿ESTE ELEMENTO PODRÁ SER REINGRESADO POSTERIORMENTE?");
  }else if((banderaBetadoAsistencia=="0" || banderaBetadoAsistencia==0) && ComentarioBetadoAsistencia==""){
     mensajeErrorModalBaja1Admin("error","Indique el motivo por el cual el elemento será vetado del Corporativo Gif Seguridad Privada");
  }else{

    $.ajax({
      type: "POST",
      url: "ajax_RegistrarDatosDocumentosBaja.php",
      data: {"banderaBetadoAsistencia":banderaBetadoAsistencia,"ComentarioBetadoAsistencia":ComentarioBetadoAsistencia,"MotivoBaja":MotivoBaja,"especifiqueMotivo1":especifiqueMotivo1,"numempleadoFirmahidden":numempleadoFirmahidden,"FirmaInterna":FirmaInterna,"asistenciaFecha":asistenciaFecha,"FechaBajaEmpModal":FechaBajaEmpModal,"empleadoEntidadId":empleadoEntidadId,"empleadoConsecutivoId":empleadoConsecutivoId,"empleadoTipoId":empleadoTipoId},
      dataType: "json",
      success: function(response) {
        mensajeErrorModalBaja1Admin(response.status,response.message);
        if (response.status=="success") {
          $("#modalBajaEmpeladoAdmin").modal("hide");
            reigstrarBajaEmpleadoAdmin();
        }       
      },error: function(jqXHR, textStatus, errorThrown){
          alert(jqXHR.responseText);
      }
    });

  }}

  function reigstrarBajaEmpleadoAdmin(){
    var numeroEmpleado = $("#txtNumeroEmpleadoAsistencia").val();
    var elementosNumeroEmpleado = numeroEmpleado.split("-");
    var empleadoEntidadId = elementosNumeroEmpleado[0];
    var empleadoConsecutivoId = elementosNumeroEmpleado[1];
    var empleadoTipoId = elementosNumeroEmpleado[2];
    var puntoServicio = $("#txtPuntoOculto").val();
    var incidenciaId='10';
    var asistenciaFecha = $("#txtFechaAsistencia").val();    
    var comentariIncidencia = $("#especifiqueMotivoAdmin").val();
    var tipoPeriodo = $('input:radio[name=optionPeriodo]:checked').val();   
    var puestoCubiertoId = $("#txtPuestoOculto").val(); 
    var selplantillaservicioincidencia='HORARIO OFICINA';   
    var nomenclaturaIncidencia = $("#nomenclaturaIncidenciaHiddenBajaEmpAdmin").val();
    $.ajax ({            
      type: "POST",
      url: "ajax_registrarAsistenciaAdmin.php",
      data: {empleadoEntidadId:empleadoEntidadId, empleadoConsecutivoId: empleadoConsecutivoId, empleadoTipoId:empleadoTipoId, puntoServicio: puntoServicio, incidenciaId:incidenciaId, asistenciaFecha:asistenciaFecha, comentariIncidencia:comentariIncidencia, tipoPeriodo:tipoPeriodo, puestoCubiertoId:puestoCubiertoId,selplantillaservicioincidencia:selplantillaservicioincidencia},
      dataType: "json",
      success: function (response) 
      {  
        if (response.status == "error")
        {
          valordia=0;
          alert (response.message);
        }
        else 
        {
          id = $("#idCell").val ();
          $("#" + id).html (nomenclaturaIncidencia);
          var style = styles [nomenclaturaIncidencia];
          $("#td_"+id).attr("style",style);          
          $("#" + id).attr ("incidenciaAsistenciaId", incidenciaId);
          $("#" + id).attr ("incidenciaText",  nomenclaturaIncidencia);                    
          valordia=0;
          if (response.asistencia != null)
          {
            for (var k in response.asistencia)
            {
              fecha = k;
              id = empleadoEntidadId + "-" + empleadoConsecutivoId + "-" + empleadoTipoId + puntoServicio + fecha;
              nomenclaturaIncidencia = response.asistencia[k].nomenclaturaIncidencia;
              incidenciaId = response.asistencia[k].incidenciaAsistenciaId;
              $("#" + id).html (nomenclaturaIncidencia);
              var style = styles [nomenclaturaIncidencia];
              $("#td_"+id).attr("style",style);
              $("#" + id).attr ("incidenciaAsistenciaId", incidenciaId);
              $("#" + id).attr ("incidenciaText",  nomenclaturaIncidencia);
            }
          }
          if(busqueda=="numeroEmpleado"){
            tableEmpleadosByIdEmpleado();
          }else if(busqueda="nombreEmpleado"){
            tableEmpleadosByPeriodorName();
          }else{
            consultaPersonalAdmin();
          }          
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);                   
      }
    });
    $("#myModalAsistencia").modal("hide");
  }


/*/////////////////////////////////////////////////////Termina La Modificacion De La Baja De Un Elemento//////////////////////////////////////////////////////////////////////////////////////////////////////////*/



  function consultaPersonalAdmin()
  {          
    waitingDialog.show();
    $("#tableEmpleadosAsistencia").find("tr:gt(0)").remove();

        //alert(periodoId);
        
        $.ajax({
          
          type: "POST",
          url: "ajax_getAsistenciaAdministrativaGeneral.php",
          data : {"fecha1":fecha1, "fecha2":fecha2, "periodoId":periodoId,"opcion":1},
          dataType: "json",
          success: function(response) {
              //console.log(response);
              if (response.status == "success")
              {
                var empleadoEncontrado = response.listaEmpleados;
                    //alert(empleadoEncontrado.length);     
                    for ( var i = 0; i < empleadoEncontrado.length; i++ ){
                      var numeroEmpleado = empleadoEncontrado[i].numeroEmpleado;
                      var nombreEmpleado = empleadoEncontrado[i].nombreEmpleado;
                      var descripcionPuesto = empleadoEncontrado[i].descripcionPuesto;                      
                      var puntoServicio=empleadoEncontrado[i].puntoServicio;
                      var empleadoIdPuntoServicio=empleadoEncontrado[i].empleadoIdPuntoServicio;
                      var empleadoIdPuesto=empleadoEncontrado[i].empleadoIdPuesto;
                      var entidad=empleadoEncontrado[i].Entidad;
                      var asistencia = empleadoEncontrado[i].asistencia;
                      var sumaTurnosExtras=empleadoEncontrado[i].turnosExtras.sumaTurnosExtras;
                      var descuentos=empleadoEncontrado[i].descuentos.descuentos;
                      var incidenciasEspeciales=empleadoEncontrado[i].incidenciasEspeciales.incidenciasEspeciales;                                            
                      var sumaDiasFestivos=empleadoEncontrado[i].diasFestivos.diasFestivos;
                      var supervisorId = empleadoEncontrado[i].supervisorId;
                      var roloperativo=empleadoEncontrado[i].roloperativo;
                      var descripcionLineaNegocio=empleadoEncontrado[i].descripcionLineaNegocio;


                      

                      if(roloperativo==null || roloperativo=="" ){
                        roloperativo="No asignado";
                      }
                      if(incidenciasEspeciales==null){
                        incidenciasEspeciales=0;
                      }

                      if(descuentos==null){
                        descuentos=0;
                      }
                      
                      
                      if(sumaTurnosExtras==null){
                        sumaTurnosExtras=0;
                      }
//supervisorid//%%asis se llamara el campo del supervisor para las opciones
$('#tableEmpleadosAsistencia').append(
  "<tr><td width='80px'>"+numeroEmpleado+"</td><td width='160px'>"+nombreEmpleado+"</td><td width='100px'>"+descripcionPuesto+"</td><td width='140px'>"+entidad+"</td><td width='140px'>"+puntoServicio+"</td><td width='160px'>"+descripcionLineaNegocio+"</td>" + crearCeldasParaPaseAsistencia(numeroEmpleado, nombreEmpleado, asistencia, empleadoIdPuntoServicio, empleadoIdPuesto,entidad,supervisorId,roloperativo,descripcionPuesto,puntoServicio) +"<td width='20px' id='td_te_"+numeroEmpleado+"' name='td_te_"+numeroEmpleado+"' sumaTurnosExtras='"+sumaTurnosExtras+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fecha1='"+fecha1+"' fecha2='"+fecha2+"' tdTipo='turnosExtras'>"+ sumaTurnosExtras +"</td><td width='20px' id='td_df_"+numeroEmpleado+"' name='td_df_"+numeroEmpleado+"' sumaDiasFestivos='"+sumaDiasFestivos+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fecha1='"+fecha1+"' fecha2='"+fecha2+"' tdTipo='diasFestivos'>"+ sumaDiasFestivos +"</td><td width='30px' id='td_des_"+numeroEmpleado+"' name='td_des_"+numeroEmpleado+"' descuentos='"+descuentos+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fecha1='"+fecha1+"' fecha2='"+fecha2+"' tdTipo='descuentos'>"+ descuentos+"</td><td width='20px' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fecha1='"+fecha1+"' fecha2='"+fecha2+"' tdTipo='incidenciasEspeciales'>"+ incidenciasEspeciales +"</td><td name='td_tt_"+ numeroEmpleado+"' id='td_tt_"+numeroEmpleado+"'><div id='divTotal_"+numeroEmpleado+"' id='divTotal_"+numeroEmpleado+"'></div></td></tr>");

var tQuicena=$("#td_tq_"+numeroEmpleado).attr("sumaTurnosPeriodo");
var tExtras=$("#td_te_"+numeroEmpleado).attr("sumaTurnosExtras");
var tDescuentos=$("#td_des_"+numeroEmpleado).attr("descuentos");
var tDiasFestivos=$("#td_df_"+numeroEmpleado).attr("sumaDiasFestivos");

var turnosTotales= parseInt(tQuicena) + parseInt(tExtras) + parseInt(tDiasFestivos) - Math.abs(tDescuentos);
$("#divTotal_"+numeroEmpleado).html(turnosTotales);
}                   
                    //$('#editinplace').html(listaPersonalActivoTable); 
                    loadContextMenu ();
                    tooltipAjax();
                    waitingDialog.hide();

                  }
                  else if (response.status == "error" && response.message == "No autorizado")
                  {
                    //window.location = "login.php";
                    waitingDialog.hide();
                  }
                },
                error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText); 
                  waitingDialog.hide();
                }
              });


}



$( "#txtSearchNumeroEmpleadoAsistencia" ).focus(function() {
  
  busqueda="numeroEmpleado";
  $("#txtSearchNameAsistencia" ).val("");      


      //alert(busqueda);
    });

$( "#txtSearchNameAsistencia" ).focus(function() {
  
  busqueda="nombreEmpleado";
  
  $( "#txtSearchNumeroEmpleadoAsistencia" ).val("");

      //alert(busqueda);
    });

$('#txtSearchNameAsistencia').keypress(function(event){  
 var keycode = (event.keyCode ? event.keyCode : event.which);  
 if(keycode == '13'){  
           //alert('Se ha presionado Enter!');  
           //tableEmpleadosByPeriodoSupervisorName();
           tableEmpleadosByPeriodorName();
           //$("#txtSearchNameAsistencia").val("");           
           $("#txtSearchNumeroEmpleadoAsistencia").val("");
         }   
       }); 

$('#txtSearchNumeroEmpleadoAsistencia').keypress(function(event){  
 var keycode = (event.keyCode ? event.keyCode : event.which);  
 if(keycode == '13'){  
           //alert('Se ha presionado Enter!');  
           //tableEmpleadosByPeriodoSupervisorName();
           $("#txtSearchName").val("");
           
           tableEmpleadosByIdEmpleado();
           
         }   
       });

$('#myModalAsistencia').on('hidden.bs.modal', function () {

  $("a").removeClass("elementoActivo");

});




var st7="";
var st2="";

$("#selectTipoIncapacidad").change(function(){
  $("#divmuestrast7").hide();
  $("#divmuestrast2").hide();
  $("#docust7").val("");
  $("#docust2").val("");
  $("#docuincapacidad").val("");
  
  if($("#selectTipoIncapacidad").val()==0 ){

    $("#divmuestraEnfermedadGeneral").hide().val(""); 
  }else if($("#selectTipoIncapacidad").val()==1 ){

    $("#divmuestraEnfermedadGeneral").show().val("");
  }else if($("#selectTipoIncapacidad").val()==2){
    $("#divmuestraEnfermedadGeneral").show().val("");
    $("#divmuestrast7").show();
    guardardocumentoincapacidadRegistraincidencia(2);

  }else if($("#selectTipoIncapacidad").val()==3){
    $("#divmuestraEnfermedadGeneral").show().val("");


  }


});

function consultarultimoestatusincapacidad(numeroempleado){
            //alert(numeroempleado);
//$("#myModalAsistencia").modal();//deshabilitar
var bandera=true;
var estacion=Array();



estacion[1] = "background-color:#FEFF00";
estacion[2] = "background-color:#FFFFFF";
estacion[3] = "background-color:#FFFFFF";
estacion[4] = "background-color:#FF0000";
estacion[5] = "background-color:#538136";
estacion[6] = "background-color:#538136";
estacion[7] = "background-color:#01AFF5";
estacion[8] = "background-color:#90D24B";
estacion[9] = "background-color:#FFFFFF";
estacion[10] = "background-color:#FF0000";
estacion[11] = "background-color:#BDBDBD";
estacion[12] = "background-color:#538136";
estacion[13] = "background-color:#538136";
for ( var i=0; i<14 ;i++)
{
  $("#a_"+i).prop('style',''+estacion[i]);

}

$.ajax({
  type: "POST",
  url: "ajax_getPuestosBylineanegocio.php",
  data: {"lineanegocio":"","opcion":1,"numeroempleado":numeroempleado},
  dataType: "json",
  async:false,
  success: function(response) {
    //console.log(response);
    var st_7=response.st7;
    var st_2=response.st2;
    var idincapacidad=response.idincapacidad;
                //alert(st_2);
                if(idincapacidad!=""){
                  if(((st_7=="null"|| st_7==null || st_7=="NULL" || st_7==1 ) && (st_2=="null"|| st_2==null || st_2=="NULL" ||  st_2==0))){


                    for ( var i=0; i<14; i++)
                    {
                      if(i!=8){
                       $("#a_"+i).prop('style','visibility: hidden');
                     }
                   }

           // $("#a_"+incidenciaAsistenciaId).addClass("elementoActivo");
           bandera=true;

         }
       }


     },
     error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
     // alert("error");
    }
  });
return bandera;  
            //$("#a_"+i).prop('style','visibility: hidden');//con esta propiedad desaparecen las etiquetas a
            


           //$("#a_1").css("visibility: hidden");
           
         }


         $("#inpfolioincapacidad").blur(function(){
          if($("#inpfolioincapacidad").val()=="" || !/^(([a-zA-z]{2})+([0-9]{6}))*$/.test($("#inpfolioincapacidad").val())){
            pintaerrormodalincapacidad("Verifica FOLIO INCAPACIDAD");
            $("#selectTipoIncapacidad").val(0).prop("disabled",true);
            $("#divmuestrast7").hide();
            $("#divmuestrast2").hide();
            $( "#divmuestraEnfermedadGeneral").hide();

          }else{

           guardardocumentoincapacidadRegistraincidencia(0);

         }
       });


         function guardardocumentoincapacidadRegistraincidencia(opcion){
        //esta opcion sera 0 para verificar el puesto que exista y en uno para guardar el documento y registrar la incidencia
//alert("estoy en guardardocumentoincapacidadRegistraincidencia");
var  ban=0;
var folioIncapacidad=$("#inpfolioincapacidad").val();
var tipoIncapacidad=$("#selectTipoIncapacidad").val();
var diasIncapacidad=$("#inpdiasincapacidad").val();
var numeroEmpleado = $("#txtNumeroEmpleadoAsistencia").val ();
var asistenciaFecha = $("#txtFechaAsistencia").val ();
var puestoCubiertoId= $("#inpempleadoidpuesto").val();
var elementosNumeroEmpleado = numeroEmpleado.split ("-");
var empleadoEntidadId = elementosNumeroEmpleado[0];
var empleadoConsecutivoId = elementosNumeroEmpleado[1];
var empleadoTipoId = elementosNumeroEmpleado[2];
var empleadoPuntoServicioId = $("#inppuntoservicioadministrativo").val();//meter en un hidden
var comentariIncidencia=$("#txtComentarioIncidencia").val();
var tipoPeriodo = $('input:radio[name=optionPeriodo]:checked').val();//meter en un hidden
var supervisor=$("#inpsupervisoradministrativoid").val();//meter en un hidden
var supervisorElements = supervisor.split ("-");
var supervisorEntidadId = supervisorElements [0];
var supervisorConsecutivoId = supervisorElements [1];
var supervisorTipoId = supervisorElements [2];
var idCliente=$("#op_"+empleadoPuntoServicioId).attr("idCliente");
        var valordia=0;//aquiva ir el valor del formulario de incapacidad
        var plantilladeservicio=$("#roloperativoadministrativo").val();//meter en un hidden
        var idlineanegocioPunto=$("#idlineanegociopunto").val() 
        var incidenciaId=8;//corresponde a la incapacidad
        if(opcion==0 || opcion==1 || opcion==2){
          var formData = new FormData($("#archivoincapacidad")[0]);   
        } else if(opcion==3){ 
         var formData = new FormData($("#archivost7")[0]);  
       }else if(opcion==4){
        var formData = new FormData($("#archivost2")[0]);  
      }
         //archivost2 

         formData.append('opcion', opcion);
         formData.append('folioIncapacidad', folioIncapacidad);
         formData.append('tipoIncapacidad', tipoIncapacidad);
         formData.append('diasIncapacidad', diasIncapacidad);
         formData.append('empleadoEntidadId', empleadoEntidadId);
         formData.append('empleadoConsecutivoId', empleadoConsecutivoId);
         formData.append('empleadoTipoId', empleadoTipoId);
         formData.append('empleadoPuntoServicioId', empleadoPuntoServicioId);
         formData.append('supervisorEntidadId', supervisorEntidadId);
         formData.append('supervisorConsecutivoId', supervisorConsecutivoId);
         formData.append('supervisorTipoId', supervisorTipoId);
         formData.append('incidenciaId', incidenciaId);
         formData.append('asistenciaFecha', asistenciaFecha);
         formData.append('comentariIncidencia', comentariIncidencia);
         formData.append('tipoPeriodo', tipoPeriodo);
         formData.append('puestoCubiertoId', puestoCubiertoId);
         formData.append('idCliente', idCliente);
         formData.append('valordia', valordia);
         formData.append('plantilladeservicio', plantilladeservicio);
         formData.append('idlineanegocioPunto', idlineanegocioPunto);              
         formData.append('st7', st7); 
         formData.append('st2', st2); 
        //var message = ""; 
        //hacemos la petición ajax  
       /* for (var value of formData.values()) {
              console.log(value); 
            } */
            $.ajax({
             type: "POST",
             url: "ajax_guardadocumentoincapacidadRegistarincidenciaAdmin.php",
             data:formData,
             dataType: "json",
             cache: false,
             contentType: false,
             processData: false,
             async:false, 
             success: function(response) {
               //console.log(response);
               if(response.status=="success"){
                //alert("Se Registro Incapacidad correctamente");
                var mensaje ="Se Registro Incapacidad correctamente";
                alertMsg1="<div id='msgalertIncapacidad' class='alert alert-success'><strong>Error:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#msgerrormodlaincapacidad").html(alertMsg1);
                $(document).scrollTop(0);
                $('#msgalertIncapacidad').delay(3000).fadeOut('slow');
                if(opcion==1 && $("#selectTipoIncapacidad").val()==2 && $("#docust2").val()!=""){
                  gusradararchivost2();
                }else if(opcion==1 && $("#selectTipoIncapacidad").val()==2 && $("#docust7").val()!=""){
                  gusradararchivost7();
                }

                resetmodalincapacidad();

              }else if(response.status=="success1"){
                $("#selectTipoIncapacidad").val(0).prop("disabled",false);


              }else if(response.status=="success2"){
                var idincapacidad=response.idincapacidad;
                st7=response.st7;
                st2=response.st2;
               // console.log(st2); 
               if(st7==1 && st2==0){
                  //alert("no ha ingresado st2");
                  var mensaje ="Tienes Pendiente Por Comprobar ST2";
                  alertMsg1="<div id='msgalertIncapacidad' class='alert alert-warning'><strong>Atención:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                  $("#msgerrormodlaincapacidad").html(alertMsg1);
                  $(document).scrollTop(0);
                  $('#msgalertIncapacidad').delay(7000).fadeOut('slow');
                  $("#divmuestrast7").hide();
                  st2=1;
                  $("#divmuestrast2").show();
                }
                
                else if(((st7==null || st7=="NULL" || st7=="null"  || st7==0)  && (st2==null || st2=="NULL" || st2=="null" || st2==0))){
                  //NO HA INGRESADO ST7
                  //alert("no ha ingresado st7 primerocacion");
                  $("#divmuestrast7").show();
                  $("#divmuestrast2").hide();
                  st7=1;

                }/*else if(((st7!=null || st7!="NULL" || st7!="null" )  && (st2==null || st2=="NULL" || st2=="null" ))){
 
                }*/else {
                 //alert("continuar con nueva incidencia");
                 $("#divmuestrast7").show();
                 $("#divmuestrast2").hide();
                 st7=1;
                 st2="";
               }




             }else if(response.status=="error"){
              pintaerrormodalincapacidad(response.message);

            }else if(response.status=="error1"){


              pintaerrormodalincapacidad(response.message);
              $("#selectTipoIncapacidad").val(0).prop("disabled",true);
              $("#divmuestrast7").hide();
              $("#divmuestraEnfermedadGeneral").hide();

            }


          },
          error: function(jqXHR, textStatus, errorThrown) {
           alert(jqXHR.responseText);
         }


       });
          }
          function pintaerrormodalincapacidad(mensaje){
            alertMsg1="<div id='msgalertIncapacidad' class='alert alert-error'><strong>Error:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#msgerrormodlaincapacidad").html(alertMsg1);
            $(document).scrollTop(0);
            $('#msgalertIncapacidad').delay(3000).fadeOut('slow');

          }
          function gusradararchivost7(){


            guardardocumentoincapacidadRegistraincidencia(3);
          }


          function gusradararchivost2(){


            guardardocumentoincapacidadRegistraincidencia(4);
          }


          function resetmodalincapacidad(){
            $("#ModalIncapacidad").modal('hide');
            $("#inpfolioincapacidad").val("");
            $("#selectTipoIncapacidad").val(0);
            $("#inpdiasincapacidad").val("");
            $("#docuincapacidad").val("");
            $("#docust2").val("");
            $("#docust7").val("");
            $("#selectTipoIncapacidad").val(0).prop("disabled",false);
            $("#divmuestrast7").hide();
            $("#divmuestrast2").hide();
            $("#divmuestraEnfermedadGeneral").hide();

            if(busqueda=="numeroEmpleado"){

              tableEmpleadosByIdEmpleado();

                     // tableEmpleadoByIdByUser();

                   }else if(busqueda="nombreEmpleado"){
                      //tableEmpleadoByNameByUser();
                      tableEmpleadosByPeriodorName();
                    }else{
                      consultaPersonalAdmin();
                     }
                    
                  }


                  $("#btnguardarincapacidad").click(function(){
                    var nombredearchivo      = $("#docuincapacidad").val();
                    var nombredearchivoArray = nombredearchivo.split('.');
                    var tipoarchivo      = nombredearchivoArray[nombredearchivoArray.length - 1];
                    tipoarchivo =tipoarchivo.toUpperCase();
                    var bandera=true;
        //alert($("#selectTipoIncapacidad").val());
        //alert(st7);
        //alert(st2);
        if($("#selectTipoIncapacidad").val()==0){
          pintaerrormodalincapacidad("Selecciona TIPO INCAPACIDAD");
          bandera=false;
        }else if($("#selectTipoIncapacidad").val()==1 || $("#selectTipoIncapacidad").val()==2 || $("#selectTipoIncapacidad").val()==3){
          if($("#inpfolioincapacidad").val()=="" || !/^(([a-zA-z]{2})+([0-9]{6}))*$/.test($("#inpfolioincapacidad").val())){
            pintaerrormodalincapacidad("Verifica FOLIO INCAPACIDAD");
            bandera=false;
          }else if($("#inpdiasincapacidad").val()=="" || !/^([0-9])*$/.test( $("#inpdiasincapacidad").val()) ){
            pintaerrormodalincapacidad("Verifica DIAS DE INCAPACIDAD, solo números");
            bandera=false;
          }else if((($("#selectTipoIncapacidad").val()==2 && $("#inpdiasincapacidad").val()>30 )  || $("#inpdiasincapacidad").val()==0)){
            pintaerrormodalincapacidad("Verifica DIAS DE INCAPACIDAD,cantidad de días excedido");
            bandera=false;

          }else if($("#docuincapacidad").val()==""){

            pintaerrormodalincapacidad("Selecciona ARCHIVO INCAPACIDAD");
            bandera=false;
          }else if (tipoarchivo!="PDF" && tipoarchivo!="JPG" && tipoarchivo!="JPEG" && tipoarchivo!="PNG" ){
            pintaerrormodalincapacidad("Formato de archivo no permitido,solo se admite PDF,JPG,PNG");
            bandera=false;
          }else if(($("#selectTipoIncapacidad").val()==2 && $("#docust7").val()=="" && st7==1 && (st2=="" || st2==null || st2=="null" || st2=="NULL") )){
           pintaerrormodalincapacidad("Selecciona ARCHIVO ST-7");
           bandera=false;


         }else if($("#selectTipoIncapacidad").val()==2 && $("#docust2").val()==""){

          st2=0;
          
        }
      }
      
      if(bandera){

       guardardocumentoincapacidadRegistraincidencia(1);

         //antes de guardar verificar el folio que no exista y verificar el tipo de puesto que exista
       }       
     });

  ///////////////////////////////comienza vacaciones ////////////////////

  $( "#botonCancelarVacacionesAdmin" ).click(function() {
  $("#ModalVacacionesAdmin").modal("hide");
  $("#divmuestraVacacionesDisfrutadasAdmin").hide();
});

function abrirmodalvacacionesAdmin(numeroEmpleado,nomenclaturaIncidencia){
  $("#banderaVacacionesAdmin").val("0");
  $("#selectPeriodoInicioAdmin").val("0");
  $("#inpdiasvacacionesAdmin").val("");
  $("#inpFoliovacacionesAdmin").val("");
  $("#docvacaciones").val("");
  $('#divinputsfechasAdmin').html("");
  $("#VacacionesRestntesAdmin").val("");
  $("#PeriodoInicioAdmin").val("");
  $("#PeriodoFinAdmin").val("");
  $("#numempleadovacacionesAdmin").val(numeroEmpleado);
  $("#nomeclaturavacacionesAdmin").val(nomenclaturaIncidencia);
  $("#inpdiasvacacionesAdmin").prop("readonly", true);
  CargarSelectorPeriodoAdmin();
  $("#myModalAsistencia").modal("hide");
  $("#ModalVacacionesAdmin").modal();
  $("#divmuestraVacacionesDisfrutadasAdmin").show();
}

function CargarSelectorPeriodoAdmin(){
  var empleadoEntidadId = $("#empleadoEntidadIdVacacionesAdmin").val();
  var empleadoConsecutivoId = $("#empleadoConsecutivoIdVacacionesAdmin").val();
  var empleadoTipoId = $("#empleadoTipoIdVacacionesAdmin").val();
  $.ajax({
    type: "POST",
    url: "ajax_getPeriodosanuales.php",
    data: {"empleadoEntidadId":empleadoEntidadId,"empleadoConsecutivoId":empleadoConsecutivoId,"empleadoTipoId":empleadoTipoId},
    dataType: "json",
    success: function(response) {
      var datos=response.datos;
      //llenar el selector de periodos
      $('#selectPeriodoInicioAdmin').empty().append('<option value="-1" selected="selected"></option>');
      $.each(datos, function(i) {
        $('#selectPeriodoInicioAdmin').append('<option value="' + datos[i].IdAnio + '">' +datos[i].Aniversario + '</option>');
      });
      },
    error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
  });
}

$("#selectPeriodoInicioAdmin").change(function()
{

  var Aniversario = $("#selectPeriodoInicioAdmin").val();
  var empleadoEntidadId = $("#empleadoEntidadIdVacacionesAdmin").val();
  var empleadoConsecutivoId = $("#empleadoConsecutivoIdVacacionesAdmin").val();
  var empleadoTipoId = $("#empleadoTipoIdVacacionesAdmin").val();
  $("#inpdiasvacacionesAdmin").val("");
  $("#inpFoliovacacionesAdmin").val("");
  $('#divinputsfechasAdmin').html("");
  $("#inpdiasvacacionesAdmin").prop("readonly", true);
  $("#PeriodoInicioAdmin").val("");
  $("#PeriodoFinAdmin").val("");
  $("#VacacionesRestntesAdmin").val("");
  if(Aniversario=="-1" || Aniversario==null || Aniversario=="null" || Aniversario=="NULL"){
    pintaerrormodalVacacionesAdmin("Seleccione Un Aniversario Para Continuar");
  }else
  {
    $.ajax({
      type: "POST",
      url: "ajax_getDiasRestantesVacacionesAsistencia.php",
      data:{"empleadoEntidadId":empleadoEntidadId,"empleadoConsecutivoId":empleadoConsecutivoId,"empleadoTipoId":empleadoTipoId,"Aniversario":Aniversario},
      dataType: "json",
      success: function(response) {
        $("#VacacionesRestntesAdmin").val("");
        $("#PeriodoInicioAdmin").val("");
        $("#PeriodoFinAdmin").val("");
        var datos=response.DiasDisponibles;
        var FechaUno=response.FechaUno;
        var FechaDos=response.FechaDos;
        $("#VacacionesRestntesAdmin").val(datos);
        $("#PeriodoInicioAdmin").val(FechaUno);
        $("#PeriodoFinAdmin").val(FechaDos);
        if(Aniversario!="-1" && datos!="0"){
          $("#inpdiasvacacionesAdmin").prop("readonly", false);
        }else{
          $("#inpdiasvacacionesAdmin").prop("readonly", true);
        }

        },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }
});//botactualizar

$( "#botactualizarAdmin" ).click(function() {

  $.ajax({
    type: "POST",
    url: "ajax_ActualizarAnivrsariosEmpleados.php",
    dataType: "json",
    success: function(response) {
      alert("Termnie Con Exito")
      },
    error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
  });

});



$( "#botonGuardarVacacionesAdmin" ).click(function() {

  var selectPeriodoInicio = $("#selectPeriodoInicioAdmin").val();
  var inpdiasvacaciones = $("#inpdiasvacacionesAdmin").val();
  var inpFoliovacaciones = $("#inpFoliovacacionesAdmin").val();
  var docvacaciones = $("#docvacaciones").val();
  var RolOperativoVacaciones = $("#RolOperativoVacacionesAdmin").val();
  var empleadoEntidadId = $("#empleadoEntidadIdVacacionesAdmin").val();
  var empleadoConsecutivoId = $("#empleadoConsecutivoIdVacacionesAdmin").val();
  var empleadoTipoId = $("#empleadoTipoIdVacacionesAdmin").val();
  var empleadoPuntoServicioId = $("#empleadoPuntoServicioIdVacacionesAdmin").val();
  var incidenciaId = $("#incidenciaIdVacacionesAdmin").val();
  var comentariIncidencia = $("#comentariIncidenciaVacacionesAdmin").val();
  var tipoPeriodo = $("#tipoPeriodoVacacionesAdmin").val();
  var puestoCubiertoId = $("#puestoCubiertoIdVacacionesAdmin").val();
  var plantilladeservicio = $("#plantilladeservicioVacacionesAdmin").val();
  var bandera = $("#banderaVacacionesAdmin").val();
  var nomenclaturaIncidencia = $("#nomeclaturavacacionesAdmin").val();
  var primerfecha = $("#asistenciaFechaVacacionesAdmin").val();
  var incidenciaVacaciones =$("#incidenciaVacacionesAdmin").val();
  var bandera1 = "0";
  var a = "0";
  $("#IteracionesCorrectasYValidadasAdmin").val("");
  //Comienzan validaciones
  if(selectPeriodoInicio == "" || selectPeriodoInicio == "-1"){
    pintaerrormodalVacacionesAdmin("Seleccione El Periodo De Inicio");
  }else if(inpdiasvacaciones == ""){
    pintaerrormodalVacacionesAdmin("Ingrese Los Dias Computables (Solo Numeros)");
  }else{
    for(var i ="0"; i<inpdiasvacaciones; i++){
      var Uno = "1";
      var Vacacionesmenos = (parseInt(i) - parseInt(Uno));
      var Vacaciones = (parseInt(i) + parseInt(Uno));
      var DateVacaciones = $("#inputDateVacacionesAdmin"+i).val();
      var DateVacacionesSiguiente = $("#inputDateVacacionesAdmin"+Vacacionesmenos).val();
      RevisionAsistenciaDiaSeleccionado2Admin(DateVacaciones,empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId);
      var RevisionAsistenciaDiaSeleccionado1 = $("#RevisionAsistenciaDiaSeleccionadoAdmin").val();
      if(DateVacaciones == ""){
        pintaerrormodalVacacionesAdmin("Ingrese La Fecha Del Dia "+Vacaciones+" De Vacaciones");
        break;
      }else if(DateVacaciones < DateVacacionesSiguiente || DateVacaciones == DateVacacionesSiguiente){
        pintaerrormodalVacacionesAdmin("La Fecha De Vacaciones Ingresada No Puede Ser Menor Ni Igual Que La Anterior");
        break;
      }else if(docvacaciones == ""){
        pintaerrormodalVacacionesAdmin("Carge El Achivo De Vacaciones");
      }else if(RevisionAsistenciaDiaSeleccionado1!="0"){       
        pintaerrormodalVacacionesAdmin("La Fecha Del Dia "+Vacaciones+" De Vacaciones Ingresa Ya Tiene Un Registro Previo Favor De Verificar");
        break;
      }else{
        var Uno = "1";
        var iMas1 = (parseInt(i) + parseInt(Uno));
        $("#IteracionesCorrectasYValidadasAdmin").val(iMas1);
      }
    }//for
  }//else Validaciones
//Terminan las validaciones comienza la insercion y actualizacion en las tablas

  
  var IteracionesCorrectasYValidadas = $("#IteracionesCorrectasYValidadasAdmin").val();
  if(IteracionesCorrectasYValidadas ==inpdiasvacaciones){
    $("#ModalVacacionesAdmin").modal("hide");
    waitingDialog.show();
    for(var i ="0"; i<inpdiasvacaciones; i++){
      var Uno = "1";
      var Vacacionesmenos = (parseInt(i) - parseInt(Uno));
      var Vacaciones = (parseInt(i) + parseInt(Uno));
      var DateVacaciones = $("#inputDateVacacionesAdmin"+i).val();
      var DateVacacionesSiguiente = $("#inputDateVacacionesAdmin"+Vacacionesmenos).val();
      var asistenciaFecha = DateVacaciones;
      var formData = new FormData($("#archivovacacionesAdmin")[0]);
      formData.append('inpdiasvacaciones', inpdiasvacaciones);
      formData.append('inpFoliovacaciones', inpFoliovacaciones);
      formData.append('RolOperativoVacaciones', RolOperativoVacaciones);
      formData.append('empleadoEntidadId', empleadoEntidadId);
      formData.append('empleadoConsecutivoId', empleadoConsecutivoId);
      formData.append('empleadoTipoId', empleadoTipoId);
      formData.append('nomenclaturaIncidencia', nomenclaturaIncidencia);
      formData.append('primerfecha', primerfecha);
      formData.append('selectPeriodoInicio', selectPeriodoInicio);

      console.log(formData);
      if(bandera1==0){
        $.ajax({
          type: "POST",
          url: "ajax_GuardarDocYFolioVacaciones.php",
          data:formData,
          dataType: "json",
          cache: false,
          contentType: false,
          processData: false,
          async:false, 
          success: function(response) {
            if(response.status=="success"){
              var mensaje = response.message;
              InsertarAsistenciaVacacionesAdmin(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,empleadoPuntoServicioId,incidenciaId,asistenciaFecha,comentariIncidencia,tipoPeriodo,puestoCubiertoId,plantilladeservicio,nomenclaturaIncidencia,inpdiasvacaciones,i,inpFoliovacaciones,selectPeriodoInicio);
               bandera1="1";
             }else if(response.status == "error"){
               var mensaje = response.message;
               bandera1="2";
             }
           },
           error: function(jqXHR, textStatus, errorThrown) {
             bandera1="2";
             alert(jqXHR.responseText);
           }
         });
      }else if(bandera1==1){
        InsertarAsistenciaVacacionesAdmin(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,empleadoPuntoServicioId,incidenciaId,asistenciaFecha,comentariIncidencia,tipoPeriodo,puestoCubiertoId,plantilladeservicio,nomenclaturaIncidencia,inpdiasvacaciones,i,inpFoliovacaciones,selectPeriodoInicio);
      }
    }//for
    if(busqueda=="numeroEmpleado"){
      tableEmpleadosByIdEmpleado();
    }else if(busqueda="nombreEmpleado"){
      tableEmpleadosByPeriodorName();
    }else{
      consultaPersonalAdmin();
    }
    waitingDialog.hide();
  }//if            
});

function RevisionAsistenciaDiaSeleccionado2Admin(DateVacaciones,empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId){
  $.ajax({
    type: "POST",
    url: "ajax_RevisionAsistenciaDiaSeleccionado2.php",
    data:{"DateVacaciones":DateVacaciones,"empleadoEntidadId":empleadoEntidadId,"empleadoConsecutivoId":empleadoConsecutivoId,"empleadoTipoId":empleadoTipoId},
    dataType: "json",
    async:false,
    success: function(response) {
      $("#RevisionAsistenciaDiaSeleccionadoAdmin").val("");
      var datos=response.datos;
      $("#RevisionAsistenciaDiaSeleccionadoAdmin").val(datos);
     },
    error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
  });
}

function InsertarAsistenciaVacacionesAdmin(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,puntoServicio,incidenciaId,asistenciaFecha,comentariIncidencia,tipoPeriodo,puestoCubiertoId,selplantillaservicioincidencia,nomenclaturaIncidencia,inpdiasvacaciones,i,inpFoliovacaciones,selectPeriodoInicio){
  var Uno = "1";
  var DiasVacacionesmenos = (parseInt(inpdiasvacaciones) - parseInt(Uno));
  $.ajax ({            
        type: "POST",
        url: "ajax_registrarAsistenciaAdmin.php",
        data: {empleadoEntidadId:empleadoEntidadId, empleadoConsecutivoId: empleadoConsecutivoId, empleadoTipoId:empleadoTipoId, 
          puntoServicio: puntoServicio, incidenciaId:incidenciaId, asistenciaFecha:asistenciaFecha, comentariIncidencia:comentariIncidencia, tipoPeriodo:tipoPeriodo, puestoCubiertoId:puestoCubiertoId,selplantillaservicioincidencia:selplantillaservicioincidencia},
          dataType: "json",
          async:false,
          success: function (response) {
            
            if (response.status == "error")
            {
                    //alert (response.message);
                    valordia=0;
                    alert (response.message);
                  }
                  else 
                  {
                    id = $("#idCell").val ();

                    $("#" + id).html (nomenclaturaIncidencia);

                    var style = styles [nomenclaturaIncidencia];
                    

                    $("#td_"+id).attr("style",style);
                    
                    $("#" + id).attr ("incidenciaAsistenciaId", incidenciaId);
                    $("#" + id).attr ("incidenciaText",  nomenclaturaIncidencia);                    
                    valordia=0;
                    if (response.asistencia != null)
                    {
                      for (var k in response.asistencia)
                      {
                        fecha = k;
                        id = empleadoEntidadId + "-" + empleadoConsecutivoId + "-" + empleadoTipoId + puntoServicio + fecha;

                            //console.log ("id: " + id);

                            nomenclaturaIncidencia = response.asistencia[k].nomenclaturaIncidencia;
                            incidenciaId = response.asistencia[k].incidenciaAsistenciaId;

                            $("#" + id).html (nomenclaturaIncidencia);

                            var style = styles [nomenclaturaIncidencia];
                            

                            $("#td_"+id).attr("style",style);
                            
                            $("#" + id).attr ("incidenciaAsistenciaId", incidenciaId);
                            $("#" + id).attr ("incidenciaText",  nomenclaturaIncidencia);
                          }
                        }
                        UpdateAsistenciaAddFolioVacacionesAdmin(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,puntoServicio,inpFoliovacaciones,asistenciaFecha,selectPeriodoInicio);
                        
                      }
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                      alert(jqXHR.responseText);                   
                    }
                  });
  if(i==DiasVacacionesmenos){
    $("#myModalAsistencia").modal("hide");
    $("#ModalVacacionesAdmin").modal("hide");
    $("#divmuestraVacacionesDisfrutadasAdmin").hide();
  }

}
function UpdateAsistenciaAddFolioVacacionesAdmin(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,empleadoPuntoServicioId,inpFoliovacaciones,asistenciaFecha,selectPeriodoInicio){
  $.ajax ({            
    type: "POST",
    url: "ajax_UpdateAsistenciaAddFolioVacaciones.php",
    data: {"empleadoEntidadId":empleadoEntidadId,"empleadoConsecutivoId":empleadoConsecutivoId,"empleadoTipoId":empleadoTipoId,"empleadoPuntoServicioId":empleadoPuntoServicioId,"inpFoliovacaciones":inpFoliovacaciones,"asistenciaFecha":asistenciaFecha,"selectPeriodoInicio":selectPeriodoInicio},
    dataType: "json",
    async:false, 
    success: function (response) 
    {
      if (response.status == "error")
      {                        
        var mensaje=response.message;                                
      }else if(response.status == "success"){
        var mensaje=response.message;                                
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }
  });
}

function cargarFolioAdmin(){
  $("#inpFoliovacacionesAdmin").val("");
  $('#divinputsfechasAdmin').html("");
  var numempleadovacaciones = $("#numempleadovacacionesAdmin").val();
  var nomeclaturavacaciones = $("#nomeclaturavacacionesAdmin").val();
  var inpdiasvacaciones = $("#inpdiasvacacionesAdmin").val();
  var primerfecha = $("#asistenciaFechaVacacionesAdmin").val();
  var VacacionesRestntes = $("#VacacionesRestntesAdmin").val();
  var a =VacacionesRestntes-inpdiasvacaciones;
  if(!/^([0-9])*$/.test($("#inpdiasvacacionesAdmin").val())){
    pintaerrormodalVacacionesAdmin(" Ingrese Solo Números En Dias Computables ");
    $("#inpdiasvacacionesAdmin").val("");
  }else if((VacacionesRestntes<"0") || (VacacionesRestntes=="0")){
    pintaerrormodalVacacionesAdmin(" El Empleado Ya Alcanó El Número Máximo De Vacaciones Otorgadas ");
    $("#inpdiasvacacionesAdmin").val("");  
  }else if((inpdiasvacaciones=="0") || (inpdiasvacaciones=="")){
    pintaerrormodalVacacionesAdmin(" Los Dias Computables No Pueden Ser Cero O Vacios ");
    $("#inpdiasvacacionesAdmin").val("");  
  }else if(a<"0"){
    pintaerrormodalVacacionesAdmin(" Los Dias Computables No Puede Ser Mayor A Los dias Restantes De Vacaciones ");
    $("#inpdiasvacacionesAdmin").val("");  
  }else{
    for (var i = 0; i < inpdiasvacaciones; i++){
      var Uno = "1";
      var DiaVacacviones = (parseInt(i) + parseInt(Uno));
      if(i=="0"){
         var input = " <span class='add-on'>Dia "+DiaVacacviones+" De Vacaciones</span> <input id='inputDateVacacionesAdmin"+i+"' name='inputDateVacacionesAdmin"+i+"' type='date' class='input-medium' readonly><br><br>";
      }else{
        var input = " <span class='add-on'>Dia "+DiaVacacviones+" De Vacaciones</span> <input id='inputDateVacacionesAdmin"+i+"' name='inputDateVacacionesAdmin"+i+"' type='date' class='input-medium'><br><br>";
      }
      $('#divinputsfechasAdmin').append(input); 
    }
    $("#inputDateVacacionesAdmin0").val(primerfecha);
    var folio1 = "F_" + nomeclaturavacaciones + "_" + numempleadovacaciones + "_" + primerfecha + "_" + inpdiasvacaciones;
    $("#inpFoliovacacionesAdmin").val(folio1);
  }
}

function pintaerrormodalVacacionesAdmin(mensaje){
  alertMsg1="<div id='msErrorVacacionesAdmin' class='alert alert-error'><strong>Error:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
  $("#msgerrormodlavacacionesAdmin").html(alertMsg1);
  $(document).scrollTop(0);
  $('#msErrorVacacionesAdmin').delay(3000).fadeOut('slow');

}

/////////////////// Implementacion Del Bloqueo Permanente de un empleado conflictivo /////////////////////////////////////////////////////////
$('#checkSireingresoAsistenciaAdmin').change(function() {
    if ($('#checkSireingresoAsistenciaAdmin').is(":checked")) {
      $("#checkNoreingresoAsistenciaAdmin").prop("checked", false);
      $("#divComentarioMotivoBetoAsistenciaAdmin").hide();
      $("#banderaBetadoAsistenciaAdmin").val(1);
    }else{
      $("#banderaBetadoAsistenciaAdmin").val("");
      $("#divComentarioMotivoBetoAsistenciaAdmin").hide();
    } 
  });
$('#checkNoreingresoAsistenciaAdmin').change(function() {
    if ($('#checkNoreingresoAsistenciaAdmin').is(":checked")) {
      $("#checkSireingresoAsistenciaAdmin").prop("checked", false);
      $("#divComentarioMotivoBetoAsistenciaAdmin").show();
      $("#banderaBetadoAsistenciaAdmin").val(0);
    }else{
      $("#banderaBetadoAsistenciaAdmin").val("");
      $("#divComentarioMotivoBetoAsistenciaAdmin").hide();
    }
  });
          







                  


   </script>
