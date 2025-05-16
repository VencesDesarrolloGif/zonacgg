<?php
require_once ("../Negocio/Negocio.class.php");
$negocio = new Negocio ();
?>

<div class="container" align="center" >
  <div id="msgpeticionasistencia"></div> 
  <form class="form-horizontal" id="form_asistencia1" name="form_asistencia1">

    <div > <!-- div consulta -->
      <!-- <h1>PERIODO QUINCENAL</h1> -->
      <div class="btn-group" >
        <label class="btn btn-secondary">
          <input type="radio" name="optionPeriodo" id="optionPeriodoQuincenal" value="QUINCENAL" checked onclick="generarTablaPeriodo123();"> QUINCENAL
        </label>
        <label class="btn btn-secondary ">
          <input type="radio" name="optionPeriodo" id="optionPeriodoSemanal" value="SEMANAL" onclick="generarTablaPeriodo123();"> SEMANAL
        </label>

      </div>
      <br>
      <br>
      <?php
      if ($usuario["rol"] =="Analista Asistencia"):
        ?>

        Supervisor:
        <select id="selectSupervisor" name="selectSupervisor" class="input-large" onchange="puntosServiciosBySupervisor();" >
          <option>SUPERVISOR</option>
          <?php
          for ($i=0; $i<count($catalogoSupervisoresOperativos); $i++)
          {
            echo "<option value='". $catalogoSupervisoresOperativos[$i]["supervisorId"]."'>". $catalogoSupervisoresOperativos[$i]["nombre"] ." </option>";
          }
          ?>
        </select>
        <br>
        <br>
        <?php
      endif;
      ?>
      Punto de servicio:
      <select id="puntoServicioSupervisor" name="puntoServicioSupervisor" class="input-large" onchange="tableEmpleadosByPeriodoSupervisor();" ></select>
      <br>
      <br>
      <input type="text" name="txtSearchNumeroEmpleadoAsistencia" id="txtSearchNumeroEmpleadoAsistencia"class="search-query" placeholder="Buscar(00-0000-00)" aria-describedby="basic-addon2" onblur=""><img src="img/search.png">
      <input type="text" name="txtSearchNameAsistencia" id="txtSearchNameAsistencia"class="input-xlarge" placeholder="APELLIDOS NOMBRE(S)" aria-describedby="basic-addon2" ><img src="img/search.png">
      <input id="idClienteCondicion" name="idClienteCondicion" type="hidden" class="input-medium" readonly>
      <input id="visibleRhCondicion" name="visibleRhCondicion" type="hidden" class="input-medium" readonly>

      <div id="divtp" name="divtp"></div>
    </div> <!-- fin div consulta -->

    <br>
    <br>

    <div id="divTableEmpleadosAsistencia" name="divTableEmpleadosAsistencia" align="center" class='container'><br>

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

        </div>

        <div class="input-prepend">
          <span class="add-on">PUNTO SERVICIO</span>
          <select id="selectPuntoServicioAsistencia" name="selectPuntoServicioAsistencia" class="input-large"></select>
          
          
        </div>

        <div class="input-prepend">
          <span class="add-on">PUESTO</span>
          <select id="selectPuestoAsistecia" name="selectPuestoAsistecia" class="input-large " >
            <option>PUESTO</option>
            <?php
            for ($i=0; $i<count($catalogoPuestosOperativos); $i++)
            {
              echo "<option value='". $catalogoPuestosOperativos[$i]["IdPuesto"]."'>". $catalogoPuestosOperativos[$i]["descripcionPuesto"] ."</option>"; 
            }
            ?>
          </select>
          
          <input type="hidden" id="idCell" value="" />
        </div>
        <div class="input-prepend">
          <span class="add-on">PLANTILLA DE SERVICIO</span>
          <select id="selplantillaservicio" name="selplantillaservicio" class="input-large"></select>
        </div><br>
        <div class="input-prepend" id="divValorDia" style="display: none;">
      <h5>Si el turno es de 24x24 no seleccione turno</h5>
            <span class="add-on">Turno Dia</span>
            <input type="checkbox" id="CheckDiaPet" name="CheckDiaPet" style="transform: scale(1.5);">
          
            <span class="add-on" >Turno Noche</span>
            <input type="checkbox" id="CheckNochePet" name="CheckNochePet" style="transform: scale(1.5);">       
        </div>
        <input type="hidden" id="idlineanegociopunto" value="" />
        <input type="hidden" id="revisionPeticionA" />
        <input type="hidden" id="TIpoIncidencia1" />
        <input type="hidden" id="TIpoIncidencia2" />
        <input type="hidden" id="revisionIncidenciasMismoDia" />
        <input type="hidden" id="asistenciaIncidenciaMismoDia1" />
        <input type="hidden" id="asistenciaIncidenciaMismoDia2" />
        <input type="hidden" id="revicionIncidenciaCapacitacion" />

        <div class="input-prepend">
          <span class="add-on">COMENTARIO</span>
          <textarea id="txtComentarioIncidencia" name="txtComentarioIncidencia" class="txtAreaIncidencia" maxlength="200"></textarea>
          <input id="txtsupervisorId" name="txtsupervisorId" type="hidden" class="input-medium" readonly > 

        </div>


        <div class="list-group">

          <?php

          $estacion[1] = "background-color:#FEFF00";
          $estacion[2] = "background-color:#FFFFFF";
          $estacion[3] = "background-color:#FFFFFF";
          $estacion[4] = "background-color:#FF0000";
          $estacion[5] = "background-color:#538136";
          $estacion[6] = "background-color:#538136";
          $estacion[7] = "background-color:#01AFF5";
          $estacion[8] = "background-color:#90D24B";
          $estacion[9] = "background-color:#FFFFFF";
          $estacion[10] = "background-color:#FF0000";
          $estacion[11] = "background-color:#BDBDBD";
          $estacion[12] = "background-color:#538136";
          $estacion[13] = "background-color:#538136";
          $estacion[14] = "background-color:#FF8000";

          for ( $i=0; $i<count($catalogoIncidencias); $i++)
          {

            $nomenclaturaIncidencia= $catalogoIncidencias[$i]["incidenciaId"] ;

            if($i != "8" && $i != 8){
              echo "<a id='a_".$catalogoIncidencias[$i]["incidenciaId"]."' name='a_".$catalogoIncidencias[$i]["incidenciaId"]."' href='#' style='".$estacion[$nomenclaturaIncidencia]."' class='list-group-item-a font' onclick='registrarPaseDeLista(\"" . $catalogoIncidencias[$i]["incidenciaId"] . "\",\"" . $catalogoIncidencias[$i]["descripcionIncidencia"] . "\",\"" . $catalogoIncidencias[$i]["nomenclaturaIncidencia"] . "\");'>".$catalogoIncidencias[$i]["nomenclaturaIncidencia"]."(".$catalogoIncidencias[$i]["descripcionIncidencia"].")</a>";
            }
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
        </div>
        <div class="input-prepend">
          <span class="add-on">FECHA ASISTENCIA</span>
          <input id="txtFechaIncidencia" name="txtFechaIncidencia" type="date" class="input-medium" readonly >
          
        </div>
        <div class="input-prepend">
          <span class="add-on">PUNTO SERVICIO</span>
          <select id="selectPuntoIncidencia" name="selectPuntoIncidencia" class="input-large"></select>
          
          <input type="hidden" id="idCellIncidencia" value="" />
        </div>

        <div class="input-prepend">
          <span class="add-on">PUESTO</span>
          <select id="selectPuestoIncidencia" name="selectPuestoIncidencia" class="input-large">
            <option>PUESTO</option>
            <?php
            for ($i=0; $i<count($catalogoPuestosOperativos); $i++)
            {
              echo "<option value='". $catalogoPuestosOperativos[$i]["IdPuesto"]."'>". $catalogoPuestosOperativos[$i]["descripcionPuesto"] ."</option>";
            }
            ?>
          </select>

        </div>
        

        <div class="input-prepend">
          <span class="add-on">PLANTILLA DE SERVICIO</span>
          <select id="selplantillaservicioincidencia" name="selplantillaservicioincidencia" class="input-large">
            <option>PLANTILLA</option>
          </select>
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
          <span class="add-on">MOTIVO</span>
          <select id="selectMotivoIncidenciaEspecial" name="selectMotivoIncidenciaEspecial" class="input-xlarge " >
            <?php
            for ($i=0; $i<count($catalogoMotivoIncidenciasEspeciales); $i++)
            {
              echo "<option value='". $catalogoMotivoIncidenciasEspeciales[$i]["idMotivoIncidenciaEsp"]."'>". $catalogoMotivoIncidenciasEspeciales[$i]["descripcionMotivoIncidenciaEsp"] ."</option>";
            }
            ?>
          </select>

        </div>
        <input type="hidden" id="idlineanegocioincidenciaespecial" value="" />
     <!-- <div class="input-prepend" id="divdianoche">
          <span class="add-on">DIA/NOCHE</span>
          <select id="selectIncidenciaEspecialdianoche" name="selectIncidenciaEspecialdianoche" class="input-large " >
             
            </select>
         
          </div>-->


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
       <input type="hidden" name="ocultarBtnBorrarHiden" id="ocultarBtnBorrarHiden"  class="input-medium">
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

    <div class="modal fade" tabindex="-1" role="dialog" name="modalempleadobajaOperativos" id="modalempleadobajaOperativos" data-backdrop="static">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><img src="img/alert.png">No Es Posible Realizar Movimientos Ya Que El Empleado !!</h4>
          </div>
          <div class="modal-body">
            <p><strong id="NumeroConsulaEmpleadoBajaOperativo"></strong></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal --> 


  </div> <!-- fin div container -->


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

      <div class="input-prepend" id="divmuestraDictamen"  style="display:none;margin-left: 2.5%">
        <div  class="card border-success mb-3" style="max-width: 30rem;" align="center">
          <div class="card-header"><h4>DICTAMEN ST-7</h4></div>    
          <div class="card-body text-primary">
            <label class="control-label label" for="docuDic" title="ES EL DOCUMENTO SELLADO Y FIRMADO POR LA SUB DELEGACION DEL IMSS" >Selecciona archivo: </label>
            <form enctype='multipart/form-data' id='archivosDict' name='archivosDict'>
              <span class="btn btn-success btn-file" >Examinar
                <input type='file' class='btn-success' id='docuDic' name='docuDic[]' multiple="" /> 
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
        <span class="add-on">Para eliminar el archivo examine nuevamente y seleccione cancelar</span> 

      </div>
    </div>
  </div>

  <div class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="overflow-y: scroll; max-height:85%;  margin-top: 50px; margin-bottom:50px;" id="ModalVacaciones" name="ModalVacaciones">
    <div id="msgerrormodlavacaciones"></div>
    <div class="input-prepend" id="divmuestraVacacionesDisfrutadas" style="display:none;margin-left: 10%" align="center"><!--este div es para las vacaciones disfrutadas -->
      <div class="input-prepend" align="center">
        <h3> REGISTRO DE VACACIONES</h3>
      </div><br>
      <div class="input-prepend">
        <span class="add-on">Nombre Empleado</span>
        <input id="NombreEmpleadoVacaciones" name="NombreEmpleadoVacaciones" type="text" class="input-xlarge" readonly>
      </div><br>

      <div class="input-prepend">
        <span class="add-on">Numero Empleado</span>
        <input id="numempleadovacaciones" name="numempleadovacaciones" type="text" class="input-large" readonly>
      </div><br>

      <div class="input-prepend">
        <span class="add-on">Rol Operativo</span>
        <input id="RolOperativoVacaciones" name="RolOperativoVacaciones" type="text" class="input-medium" readonly>
      </div><br>

      <div class="input-prepend">
        <span class="add-on">Periodo Inicio</span>
        <input id="PeriodoInicio" name="PeriodoInicio" type="text" class="input-medium" readonly>

        <span class="add-on">Periodo Fin</span>
        <input id="PeriodoFin" name="PeriodoFin" type="text" class="input-medium" readonly>
      </div><br>

      <div class="input-prepend">
        <span class="add-on">Dias Restantes De Vacaciones</span>
        <input id="VacacionesRestntes" name="VacacionesRestntes" type="text" class="input-medium" readonly>
      </div><br>

      <div class="input-prepend">
        <span class="add-on">Aniversarios</span>
        <select id="selectPeriodoInicio" name="selectPeriodoInicio" class="input-large"></select>
      </div><br>

      <div class="input-prepend">
        <span class="add-on">Dias Computables</span>
        <input id="inpdiasvacaciones" name="inpdiasvacaciones" type="text" class="input-small" onblur="cargarFolio();">
      </div><br>
      
      <div id="divinputsfechas" name="divinputsfechas" align="center" class='container'>
      </div><br> 

      <div class="input-prepend" style="display: block;">
        <span class="add-on">Folio Vacaciones Es: </span>
        <input id="inpFoliovacaciones" name="inpFoliovacaciones" type="text" class="input-xlarge" readonly="true">
        <input id="nomeclaturavacaciones" name="nomeclaturavacaciones" type="hidden" class="input-medium">
        <input id="empleadoEntidadIdVacaciones" name="empleadoEntidadIdVacaciones" type="hidden" class="input-medium">
        <input id="empleadoConsecutivoIdVacaciones" name="empleadoConsecutivoIdVacaciones" type="hidden" class="input-medium">
        <input id="empleadoTipoIdVacaciones" name="empleadoTipoIdVacaciones" type="hidden" class="input-medium">
        <input id="empleadoPuntoServicioIdVacaciones" name="empleadoPuntoServicioIdVacaciones" type="hidden" class="input-medium">
        <input id="supervisorEntidadIdVacaciones" name="supervisorEntidadIdVacaciones" type="hidden" class="input-medium">
        <input id="supervisorConsecutivoIdVacaciones" name="supervisorConsecutivoIdVacaciones" type="hidden" class="input-medium">
        <input id="supervisorTipoIdVacaciones" name="supervisorTipoIdVacaciones" type="hidden" class="input-medium">
        <input id="incidenciaIdVacaciones" name="incidenciaIdVacaciones" type="hidden" class="input-medium">
        <input id="asistenciaFechaVacaciones" name="asistenciaFechaVacaciones" type="hidden" class="input-medium">
        <input id="comentariIncidenciaVacaciones" name="comentariIncidenciaVacaciones" type="hidden" class="input-medium">
        <input id="tipoPeriodoVacaciones" name="tipoPeriodoVacaciones" type="hidden" class="input-medium">
        <input id="puestoCubiertoIdVacaciones" name="puestoCubiertoIdVacaciones" type="hidden" class="input-medium">
        <input id="idClienteVacaciones" name="idClienteVacaciones" type="hidden" class="input-medium">
        <input id="plantilladeservicioVacaciones" name="plantilladeservicioVacaciones" type="hidden" class="input-medium">
        <input id="idlineanegocioPuntoVacaciones" name="idlineanegocioPuntoVacaciones" type="hidden" class="input-medium">
        <input id="incidenciaVacaciones" name="incidenciaVacaciones" type="hidden" class="input-medium">
        <input id="banderaVacaciones" name="banderaVacaciones" type="hidden" class="input-medium">
        <input id="RevisionAsistenciaDiaSeleccionado" name="RevisionAsistenciaDiaSeleccionado" type="hidden" class="input-medium">
        <input id="IteracionesCorrectasYValidadas" name="IteracionesCorrectasYValidadas" type="hidden" class="input-medium">
      </div>
      <div class="card border-success mb-3" style="max-width: 30rem;">
        <div class="card-header"><h4>PAPELETA VACACIONES</h4></div>    
        <div class="card-body text-primary">
          <label class="control-label label" for="docvacaciones">Selecciona archivo: </label>
          <form enctype='multipart/form-data' id='archivovacaciones' name='archivovacaciones'>
            <span class="btn btn-success btn-file" >Examinar
              <input type='file' class='btn-success' id='docvacaciones' name='docvacaciones[]' multiple="" /> 
            </span>
          </form>
        </div>            
      </div><br>
      <div class="input-prepend">
      <!-- <button id="botactualizar" name="botactualizar" type="button" class="btn btn-primary" style="margin-left: -20%;" >Actualizar</button> -->
      <button id="botonGuardarVacaciones" name="botonGuardarVacaciones" type="button" class="btn btn-primary" style="margin-left: -20%;" >Guardar</button> 
        <button id="botonCancelarVacaciones" name="botonCancelarVacaciones" type="button" class="btn btn-danger" style="margin-left: 60%">Cancelar</button> 
      </div>
    </div>
  </div>

  <div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalBajaEmpelado" id="modalBajaEmpelado" data-backdrop="static">
  <form enctype='multipart/form-data' id='archivobajamepleado' name='archivobajamepleado'>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div id="errorModalBajaEmpleado"></div>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" align="center"><img src="img/alert.png">Registra Los Datos E Ingresa Tu Firma Interna Para Realizar La Baja !!</h3>
      </div>
      <div class="modal-body" align="center">
        <span class="add-on">Fecha Baja Empleado</span>
        <input type="text" class="input-medium" id="FechaBajaEmpModal" name="FechaBajaEmpModal" readonly="true">
      </div>
      <div class="modal-body" align="center">
        <span class="add-on"># Empleado</span>
        <input type="text" id="NumEmpModal" class="input-medium" name="NumEmpModal" readonly="true">
        <span class="add-on">Nombe Empleado</span>
        <input type="text" id="NombreEMpModal" class="input-xlarge"name="NombreEMpModal" readonly="true">
      </div>
      <div class="modal-body" align="center">
        <span class="add-on">Punto Servicio</span>
        <input type="text" id="PuntoEmpModal" class="input-large" name="PuntoEmpModal" readonly="true">
        <span class="add-on">Puesto</span>
        <input type="text" id="PuestoEmpModal" class="input-medium" name="PuestoEmpModal" readonly="true">
      </div>
      <div class="modal-body" align="center">
        <h4>MARQUE SOLO UN CUADRO CON EL MOTIVO DE LA BAJA:</h4>
      </div>
      <div class="modal-body" align="center">
        <span class="add-on"><strong>FALTAS INJUSTIFICADAS</strong></span>
        <input id="faltasInjustiicadas" name="faltasInjustiicadas" type="checkbox" style="transform: scale(1.5);">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

        <span class="add-on"><strong>ABANDONO DE SERVICIO/EMPLEO</strong></span>
        <input id="abandonoServicio" name="abandonoServicio" type="checkbox" style="transform: scale(1.5);">
      </div>
      <div class="modal-body" align="center">
         <span class="add-on"><strong>INDICIPLINA</strong></span>
        <input id="indiciplina" name="indiciplina" type="checkbox" style="transform: scale(1.5);">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

        <span class="add-on"><strong>TERMINO DE SERVICIO</strong></span>
        <input id="terminoServicio" name="terminoServicio" type="checkbox" style="transform: scale(1.5);">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

        <span class="add-on"><strong>OTROS</strong></span>
        <input id="otros" name="otros" type="checkbox" style="transform: scale(1.5);">
      </div>
      <div class="modal-body" align="center">
         <textarea  id="especifiqueMotivo" name="especifiqueMotivo" style="transform: scale(1.5);" placeholder="Especifique el motivo de la baja"></textarea>
      </div>
      <div class="modal-body" align="center">
         <button type="button" id="btnFirmaDic" name="btnFirmaDic" onclick="firmarDocumento();" class="btn btn-success" >Firmar Documento</button>
      </div>
      <div class="modal-body" align="center">
        <span class="add-on">Nombe Solicitante:</span>
        <input type="text" id="NombreSolicitante" class="input-xlarge"name="NombreSolicitante" readonly="true">
        <span class="add-on">Firma Interna:</span>
        <input type="text" id="FirmaInterna" class="input-xlarge"name="FirmaInterna" readonly="true">
      </div>
      <div class="modal-body" align="center">
        <h4 class="modal-title" id="myModalLabel"> <img src="img/warning.png">¿ESTE ELEMENTO PODRÁ SER REINGRESADO POSTERIORMENTE?</h4>
      </div>
      <div class="modal-body" align="center">
            <span class="add-on" >SI</span>
            <input type="checkbox" id="checkSireingresoAsistencia" title="Si podra ser reingresado en caso de que vuelva a solicitar trabajo en el Corporativo" name="checkSireingresoAsistencia" style="transform: scale(1.5);width: 30px;">
            <span class="add-on">NO</span>
            <input type="checkbox" id="checkNoreingresoAsistencia" title="NO podra ser reingresado en Ningun caso dentro de este Corporativo" name="checkNoreingresoAsistencia" style="transform: scale(1.5);width: 30px;">
      </div>
      <div class="modal-body" align="center">
        <span class="add-on" style="color:red;">AL COLOCAR QUE NO EL EMPLEADO QUEDARÁ VETADO DE TODO EL CORPORATIVO GIF SEGURIDAD PRIVADA</span><br>
        <span class="add-on" style="color:red;">Y NO PODRÁ SER REINGRESADO EN NINGUNA PARTE DEL PAIS DENTRO DE ESTE CORPORATIVO!!!</span>
      </div><br>
      <div class="modal-body" id="divComentarioMotivoBetoAsistencia" style="display: none;" align="center"> 
      <span class="add-on">Motivo:</span>
        <textarea id="ComentarioBetadoAsistencia" name="ComentarioBetadoAsistencia" class="txtAreaIncidencia" placeholder="Escriba el motivo por el cual el elemento será vetado"></textarea>
      </div><br>
      <input type="hidden" id="banderaBetadoAsistencia" class="input-xlarge"name="banderaBetadoAsistencia" readonly="true">
        <input type="hidden" class="input-medium" id="FechaBajaSolicitadaEmp" name="FechaBajaSolicitadaEmp" readonly="true">
        <input type="hidden" class="input-medium" id="empleadoEntidadIdHiddenBajaEmp" name="empleadoEntidadIdHiddenBajaEmp" readonly="true">
        <input type="hidden" class="input-medium" id="empleadoConsecutivoIdHiddenBajaEmp" name="empleadoConsecutivoIdHiddenBajaEmp" readonly="true">
        <input type="hidden" class="input-medium" id="empleadoTipoIdHiddenBajaEmp" name="empleadoTipoIdHiddenBajaEmp" readonly="true">
        <input type="hidden" class="input-medium" id="empleadoPuntoServicioIdHiddenBajaEmp" name="empleadoPuntoServicioIdHiddenBajaEmp" readonly="true">
        <input type="hidden" class="input-medium" id="supervisorEntidadIdHiddenBajaEmp" name="supervisorEntidadIdHiddenBajaEmp" readonly="true">
        <input type="hidden" class="input-medium" id="supervisorConsecutivoIdHiddenBajaEmp" name="supervisorConsecutivoIdHiddenBajaEmp" readonly="true">
        <input type="hidden" class="input-medium" id="supervisorTipoIdHiddenBajaEmp" name="supervisorTipoIdHiddenBajaEmp" readonly="true">
        <input type="hidden" class="input-medium" id="incidenciaIdHiddenBajaEmp" name="incidenciaIdHiddenBajaEmp" readonly="true">
        <input type="hidden" class="input-medium" id="comentariIncidenciaHiddenBajaEmp" name="comentariIncidenciaHiddenBajaEmp" readonly="true">
        <input type="hidden" class="input-medium" id="tipoPeriodoHiddenBajaEmp" name="tipoPeriodoHiddenBajaEmp" readonly="true">
        <input type="hidden" class="input-medium" id="puestoCubiertoIdHiddenBajaEmp" name="puestoCubiertoIdHiddenBajaEmp" readonly="true">
        <input type="hidden" class="input-medium" id="idClienteHiddenBajaEmp" name="idClienteHiddenBajaEmp" readonly="true">
        <input type="hidden" class="input-medium" id="valordiaHiddenBajaEmp" name="valordiaHiddenBajaEmp" readonly="true">
        <input type="hidden" class="input-medium" id="plantilladeservicioHiddenBajaEmp" name="plantilladeservicioHiddenBajaEmp" readonly="true">
        <input type="hidden" class="input-medium" id="nomenclaturaIncidenciaHiddenBajaEmp" name="nomenclaturaIncidenciaHiddenBajaEmp" readonly="true">
        <input type="hidden" class="input-medium" id="busquedaHiddenBajaEmp" name="busquedaHiddenBajaEmp" readonly="true">
        <input type="hidden" class="input-medium" id="numempleadoFirmahidden" name="numempleadoFirmahidden" readonly="true">
      <div class="modal-body" align="center">
        
        <button type="button" id="btnGuardarDocBajaEmp" name="btnGuardarDocBajaEmp" onclick="GuardarDocumentoBaja();" class="btn btn-primary" >Guardar</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
  </form>
</div><!-- /.modal -->  

<div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaElectronica" id="modalFirmaElectronica" data-backdrop="static">
  <div id="errorModalFirmaInterna"></div>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" align="center"><img src="img/alert.png">Escribe tu numero de empleado y la contraseña que generaste !!</h3>
      </div>
      <div class="modal-body" align="center">
        <span class="add-on"># Empleado</span>
        <input type="text" id="NumEmpModalBaja" class="input-medium" name="NumEmpModalBaja" placeholder="00-0000-00 Ó 00-00000-00">
        <span class="add-on">Contraseña</span>
        <input type="password" id="constraseniaFirma" class="input-xlarge"name="constraseniaFirma" title="El campo identifica entre mayusculas y minusculas favor de considerarlo">
      </div>
      <div class="modal-body" align="center">
        
        <button type="button" id="btnFirmarDoc" name="btnFirmarDoc" onclick="RevisarFirmaInterna();" style="display: none;" class="btn btn-primary" >Firmar</button>
        <button type="button" id="btnCancelarFirma" name="btnCancelarFirma"onclick="cancelarFirma();" class="btn btn-danger" >Cancelar</button>
      </div>      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

  <script type="text/javascript">

    var turnosPresupuestados = 0;
    var turnosDeDia = 0;
    var turnosDeNoche = 0;
    var PorcentajeTotalDeDias = 0;
    var turnosCubiertos = {};
    var requisiciones = [];
    var busqueda="PuntoServicio";
    var dictamen="";
    var st7Falso="";



    <?php 
    if ($usuario["rol"] =="Supervisor" || $usuario["rol"] =="Analista Asistencia" || $usuario["rol"] =="Facturacion"):


      if ($usuario["rol"] =="Supervisor"):
        ?>

        puntosServiciosBySupervisor();
        puntosServiciosBySupervisorSelectIncidenciasEspeciales();
        <?php
      endif;
      ?>
      <?php
      if ($usuario["rol"] =="Analista Asistencia" || $usuario["rol"] =="Facturacion"):
        ?>
        puntosServiciosAnalista();
        <?php
      endif;
      ?>


      var resultAsistencia="";
      jQuery("#optionPeriodoQuincenal").attr('checked', true);
                 //alert($('input:radio[name=optionPeriodo]:checked').val());
                 
                 var fechasAsistencia123 = [];

                 var fecha1="";
                 var fecha2="";
                 var periodoId="1";


                 generarTablaPeriodo123();

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
                 styles ["V/P2"] = "background-color:#538136";
                 styles ["V/D2"] = "background-color:#538136";
                 styles ["CAP"] = "background-color:#FF8000";

                 <?php
               endif;
               ?>

  
    function crearCeldasParaPaseAsistencia (numeroEmpleado, nombreEmpleado, asistencia, empleadoIdPuntoServicio, supervisorId, empleadoIdPuesto,roloperativo,idlineanegociopunto,IdPlantillaServ)
               {


    var result = "";
    var sumaTurnosPeriodo=0;
    

    for (var i = 0; i < fechasAsistencia123.length; i++)
    {

      fechaAsistencia = fechasAsistencia123 [i];


      var capacitacion = "";
      var asistenciaText = "[__]";
      var puntoServiciosIncidencia="";
      var puntoServicioAsistenciaId=empleadoIdPuntoServicio;
      var comentarioIncidencia="";
      var incidenciaAsistenciaId="";
      var puestoCubiertoId=empleadoIdPuesto;
      var folioincapacidad="";
//puntoServicioAsistenciaId


      if (asistencia [fechaAsistencia] != null)
      {

        capacitacion= asistencia [fechaAsistencia]["Capacitacion"];
        asistenciaText = asistencia [fechaAsistencia]["nomenclaturaIncidencia"];
        puntoServiciosIncidencia= asistencia [fechaAsistencia]["puntoServicio"];
        puntoServicioAsistenciaId= asistencia [fechaAsistencia]["puntoServicioAsistenciaId"];
        comentarioIncidencia=asistencia [fechaAsistencia]["comentarioIncidencia"];
        incidenciaAsistenciaId=asistencia [fechaAsistencia]["incidenciaAsistenciaId"];
        valorAsistencia=asistencia [fechaAsistencia]["valorAsistencia"];
        puestoCubiertoId=asistencia[fechaAsistencia]["puestoCubiertoId"];
        folioincapacidad=asistencia[fechaAsistencia]["folioIncapacidad"];
              

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
           //alert(incidenciaAsistenciaId);

// en esat parte se modificara el href para cuando sea una incidencia 8 incapacidad no poder editar ni meter otra incidencia
result += "<td width='40px' align='center'  style='" + style + "' id='td_"+id+"' name='td_"+id+"' class='demo1' numeroEmpleado='" + numeroEmpleado + "' fechaAsistencia='" + fechaAsistencia + "' nombreEmpleado='" + nombreEmpleado + "' puntoServicioAsistenciaId='" + puntoServicioAsistenciaId + "' comentarioIncidencia='" + comentarioIncidencia + "', incidenciaAsistenciaId = '" +incidenciaAsistenciaId+ "' asistenciaText='" +asistenciaText+ "' supervisorId='"+supervisorId+"' empleadoIdPuesto='"+puestoCubiertoId+"'  plantillaservicio='"+roloperativo+"'  idlineanegociopunto='"+idlineanegociopunto+"' folioincapacidad='"+folioincapacidad+"' IdPlantillaServ='"+IdPlantillaServ+"'>";



if(incidenciaAsistenciaId!=8){
 result += "<a  id='" + id + "' href='javascript:mostrarOpcionesParaPaseDeLista (\"" + id + "\");' >" + asistenciaText +"</a></td>";
}else{

 result += "<a  id='" + id + "'>" + asistenciaText +"</a></td>";
}

}
result +="<td width='20px' id='td_tq_"+numeroEmpleado+"' name='td_tq_"+numeroEmpleado+"' sumaTurnosPeriodo='"+ sumaTurnosPeriodo +"'>"+sumaTurnosPeriodo+"</td>";

return result;
}



function crearResumenDeTurnos ()
{
    // Variables globales
    // turnosPresupuestados
    // fechasAsistencia123
    // turnosCubiertos

    var result = "";

    var primerColumna = "<td width='835px' align='right'>";

    var rowTurnosPresupuestados = "<tr>" + primerColumna + "Turnos Presupuestados</td>";
    var rowTurnosCubiertos = "<tr>" + primerColumna + "Turnos Totales</td>";
    var rowDiferenciaTurnos = "<tr>" + primerColumna + "Diferencia</td>";
    var rowTurnoDia = "<tr>" + primerColumna + "Turnos De Dia</td>";
    var rowTurnoNoche = "<tr>" + primerColumna + "Turnos De Noche</td>";
    var rowPorcentajeDias = "<tr>" + primerColumna + "Porcentaje</td>";
    var TCubiertosT = "<th width='160px' align='center'>Total Turnos Cubiertos</th>";
    var TPresupuestadosT = "<th width='160px' align='center'>Total Turnos Presupuestados</th>";
    var TPorcentaje = "<th width='160px' align='center'>Porcentaje Total</th>";
    var TturnosDia = "<th width='160px' align='center'>Total Turnos Dia</th>";
    var TrunosNoches = "<th width='160px' align='center'>Total Turnos Noche</th>";
    var sumTCubiertosT = 0;
    var sumTPresupuestadosT = 0;
    var sumTPorcentaje = 0;
    var sumTturnosDia = 0;
    var sumTrunosNoches = 0;
    for (var i = 0; i < fechasAsistencia123.length; i++)
    {
      fechaAsistencia = fechasAsistencia123 [i];
      turnoPresupuestado = turnosPresupuestados[fechaAsistencia].turnosPorDia;
      turnoCubierto = turnosPresupuestados [fechaAsistencia].turnosCubiertos;
      idLineaNegocioPunto = turnosPresupuestados [fechaAsistencia].idLineaNegocioPunto;
    
      rowTurnosPresupuestados += "<td width='40px'>" + turnoPresupuestado + "</td>";
      rowTurnosCubiertos += "<td width='40px'>" + turnoCubierto + "</td>";
      rowDiferenciaTurnos += "<td width='40px'>" + (turnoPresupuestado - turnoCubierto) + "</td>";
      
      if(idLineaNegocioPunto=="1"){

        sumTCubiertosT = sumTCubiertosT+turnoCubierto;
        sumTPresupuestadosT= sumTPresupuestadosT+turnoPresupuestado;
        turnoDeDia = turnosPresupuestados[fechaAsistencia].turnoDeDia;
        turnosDeNoche = turnosPresupuestados[fechaAsistencia].turnosDeNoche;
        PrcentajeTotalTunos = turnosPresupuestados[fechaAsistencia].PrcentajeTotalTunos;
        turnosCubiertosDia = turnosPresupuestados [fechaAsistencia].turnosCubiertosDia;
        turnosCubiertosNoche = turnosPresupuestados [fechaAsistencia].turnosCubiertosNoche;
        sumTPorcentaje = sumTPorcentaje + PrcentajeTotalTunos;

        sumTturnosDia = sumTturnosDia + turnosCubiertosDia;
        sumTrunosNoches = sumTrunosNoches + turnosCubiertosNoche;

        rowTurnoDia += "<td width='40px'>" + turnoDeDia + "</td>";
        rowTurnoNoche += "<td width='40px'>" + turnosDeNoche + "</td>";
        if(PrcentajeTotalTunos == "100"){
        rowPorcentajeDias += "<td width='40px' style = 'color: green;'>" + PrcentajeTotalTunos + "%" + "</td>";
        }else if(PrcentajeTotalTunos == "80" || (PrcentajeTotalTunos > "80" && PrcentajeTotalTunos < "100")){
        rowPorcentajeDias += "<td width='40px' style = 'color: orange;'>" + PrcentajeTotalTunos + "%" + "</td>";
        }else{
        rowPorcentajeDias += "<td width='40px' style = 'color: red;'>" + PrcentajeTotalTunos + "%" + "</td>";
        }
      } 
    }
    
    rowTurnosPresupuestados += "</tr>";
    rowTurnosCubiertos += "</tr>";
    rowDiferenciaTurnos += "</tr>";
    result += rowTurnosCubiertos;
    result += rowTurnosPresupuestados;
    result += rowDiferenciaTurnos;
    if(idLineaNegocioPunto=="1"){
      rowTurnoDia += "</tr>";
      rowTurnoNoche += "</tr>";
      rowPorcentajeDias += "</tr>";
      result += rowTurnoDia;
      result += rowTurnoNoche;
      result += rowPorcentajeDias;
      var TCT = "<td width='160px'>" + sumTCubiertosT + "</td>";
      var TPT = "<td width='160px'>" + sumTPresupuestadosT + "</td>";
      var sumTPorcentaje2 = sumTPorcentaje/(fechasAsistencia123.length); 
      var sumTPorcentaje1 = sumTPorcentaje2.toFixed(2);

      if(sumTPorcentaje1 == 100){
        var TPC = "<td width='160px' style = 'color: green;'>" + sumTPorcentaje1 + "%" + "</td>";
      }else if(sumTPorcentaje1 == 20 || (sumTPorcentaje1 > 20 && sumTPorcentaje1 < 100)){
        var TPC = "<td width='160px' style = 'color: orange;'>" + sumTPorcentaje1 + "%" + "</td>";
      }else{
        var TPC = "<td width='160px' style = 'color: red;'>" + sumTPorcentaje1 + "%" + "</td>";
      }
      var TTD = "<td width='160px'>" + sumTturnosDia + "</td>";
      var TTN = "<td width='160px'>" + sumTrunosNoches + "</td>";
      var as="<tr >";
      var ass="</tr>";
      result += as;
      result += TCubiertosT;
      result += TPresupuestadosT;
      result += TPorcentaje;
      result += TturnosDia;
      result += TrunosNoches;
      result += ass;
      result += as;
      result += TCT;
      result += TPT;
      result += TPC;
      result += TTD;
      result += TTN;
      result += ass;
    }
    
    return result;
  }

  function mostrarOpcionesParaPaseDeLista (id)
  {
    $("#CheckNochePet").prop("checked", false);
    $("#CheckDiaPet").prop("checked", false);
    $("#CheckNochePet").val(0);
    $("#CheckDiaPet").val(0);
    $("#divValorDia").hide();
    $("#revisionPeticionA").val("");
    $("#TIpoIncidencia1").val("");
    $("#TIpoIncidencia2").val("");
    var nombreEmpleado = $("#td_" + id).attr ("nombreEmpleado");
    var puntoServicioAsistenciaId = $("#td_" + id).attr ("puntoServicioAsistenciaId");
    var comentarioIncidencia = $("#td_" + id).attr ("comentarioIncidencia");
    var incidenciaAsistenciaId = $("#td_" + id).attr ("incidenciaAsistenciaId");
    var asistenciaText = $("#td_" + id).attr ("asistenciaText");
    var supervisorId= $("#td_" + id).attr ("supervisorId");
    var empleadoIdPuesto=$("#td_"+id).attr("empleadoIdPuesto");
    var plantillaservicioporempleado=  $("#td_"+id).attr("plantillaservicio");//corresponde al roloperativo 
    var IdPlantillaServ=  $("#td_"+id).attr("IdPlantillaServ");//corresponde al id de la plantilla 
    var idlineanegocioPuntoServicio=  $("#td_"+id).attr("idlineanegociopunto"); 
    var numeroEmpleado = $("#td_" + id).attr ("numeroEmpleado");
    var elementosNumeroEmpleado = numeroEmpleado.split ("-");
    var empleadoEntidadId = elementosNumeroEmpleado[0];
    var empleadoConsecutivoId = elementosNumeroEmpleado[1];
    var empleadoTipoId = elementosNumeroEmpleado[2];
    var fechaAsistencia = $("#td_" + id).attr ("fechaAsistencia");
    RevicionPeticionesCapacitacion(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,fechaAsistencia);// se manda la consulta para actualizar el estatus de capacitacion segun la accion que se realce
    var respuestaIncapacidad=consultarultimoestatusincapacidad(numeroEmpleado);
//alert(respuestaIncapacidad);
if(respuestaIncapacidad){

  consultapuestosbylineadenegocio(idlineanegocioPuntoServicio,empleadoIdPuesto);

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
        $("#modalempleadobajaOperativos").modal("show");
        $("#NumeroConsulaEmpleadoBajaOperativo").html(numeroEmpleado + " Se Encuentra En Estatus Baja");
      }else{
        if(plantillaservicioporempleado=='null' || plantillaservicioporempleado==""  || plantillaservicioporempleado=="No asignado"){
          alert("El elemento no fue asignado a una plantilla de servicio desde el área de contrataciones, por favor reportalo al área correspondiente");
        }else{
          if (incidenciaAsistenciaId!=11 && incidenciaAsistenciaId!= 10 ){
            //cargaselectorplantillaenmodalasistencia(puntoServicioAsistenciaId); //FUNCION FUE DESHABILITADO DEBIDO A QUE DE UN INICIO SE JALABA EL ROL OPERATIVO DEL PUNTO DE SERVICIO AHORA ES EL ROL OPERATIVO QUE TRAE CADA EMPLEADO
            $('#selplantillaservicio').empty().append('<option value="'+plantillaservicioporempleado+'_'+IdPlantillaServ+'" selected="selected">'+plantillaservicioporempleado+'_'+IdPlantillaServ+'</option>');
            $("#myModalAsistencia").modal();
            $("#txtComentarioIncidencia").val("");
            $("#txtsupervisorId").val(supervisorId);
            $("#txtNumeroEmpleadoAsistencia").val(numeroEmpleado);
            $("#txtFechaAsistencia").val(fechaAsistencia);
            $("#txtNombreEmpleadoAsistencia").val(nombreEmpleado);
            $("#selectPuntoServicioAsistencia").val(puntoServicioAsistenciaId);
            //$("#txtPuntoIncidencia").val(puntoServiciosIncidencia);
            $("#NombreEmpleadoVacaciones").val("");
            $("#numempleadovacaciones").val("");
            $("#RolOperativoVacaciones").val("");
            $("#NombreEmpleadoVacaciones").val(nombreEmpleado);
            $("#numempleadovacaciones").val(numeroEmpleado);
            $("#RolOperativoVacaciones").val(plantillaservicioporempleado);
            $("#txtComentarioIncidencia").val(comentarioIncidencia);
            $("#selectPuestoAsistecia").val(empleadoIdPuesto);
            $("#idlineanegociopunto").val(idlineanegocioPuntoServicio);
            
            // var idElemento="a_"+ 
            <?php
            for ( $i=0; $i<count($catalogoIncidencias); $i++)
            {
              if($i!="8"){

                echo "$('#a_" . $catalogoIncidencias[$i]["incidenciaId"] . "').removeClass ('elementoActivo');";
              }
              
            }
            ?>
            $("#a_"+incidenciaAsistenciaId).addClass("elementoActivo");
            $("#idCell").val (id);
          }
        }
      }
    },
    error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
  });
  }//termina if de respuesta de consultar si debe incapacidad

}

$('#CheckDiaPet').change(function() {
    if ($('#CheckDiaPet').is(":checked")) {
      $('#CheckDiaPet').val(1);
      $('#CheckNochePet').val(0);
      $("#CheckNochePet").prop("checked", false);  
    }else{
      $('#CheckDiaPet').val(0);
    }
  });

$('#CheckNochePet').change(function() {
    if ($('#CheckNochePet').is(":checked")) {
      $('#CheckNochePet').val(2);
      $('#CheckDiaPet').val(0);
      $("#CheckDiaPet").prop("checked", false);  
    }else{
      $('#CheckNochePet').val(0);
    }
  });

function RevisarPeticionesMerma(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,asistenciaFecha)
{
  $.ajax({
    type: "POST",
    url: "ajax_RevisionPeticionAsistenciaMerma.php",
    data : {"empleadoEntidadId":empleadoEntidadId,"empleadoConsecutivoId":empleadoConsecutivoId,"empleadoTipoId":empleadoTipoId,"asistenciaFecha":asistenciaFecha },
    dataType: "json",
    async:false,
    success: function(response) {
      if (response.status == "success")
      {
        //console.log(response);
        var resultRevisionAsistencia=response.datos.length;
        if(resultRevisionAsistencia=="1"){
          var TIpoIncidencia11 = response.datos[0]["turnoIncidencia"];
          $("#TIpoIncidencia1").val(TIpoIncidencia11);
        }else if(resultRevisionAsistencia=="2"){
          var TIpoIncidencia11 = response.datos[0]["IncidenciaId"];
          var TIpoIncidencia22 = response.datos[1]["turnoIncidencia"];
          $("#TIpoIncidencia1").val(TIpoIncidencia11);
          $("#TIpoIncidencia2").val(TIpoIncidencia22);
        }
        $("#revisionPeticionA").val(resultRevisionAsistencia);    
      }
    },
    error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
  });
}

function RevisarAsistecniasIncidenciasMismoDia(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,asistenciaFecha)
{
  $.ajax({
    type: "POST",
    url: "ajax_RevisarAsistecniasIncidenciasMismoDia.php",
    data : {"empleadoEntidadId":empleadoEntidadId,"empleadoConsecutivoId":empleadoConsecutivoId,"empleadoTipoId":empleadoTipoId,"asistenciaFecha":asistenciaFecha },
    dataType: "json",
    async:false,
    success: function(response) {
      if (response.status == "success")
      {
        var resultRevisionAsistencia=response.datos.length;
        if(resultRevisionAsistencia=="1"){
          var TIpoIncidencia11 = response.datos[0]["incidenciaId"];
          $("#asistenciaIncidenciaMismoDia1").val(TIpoIncidencia11);
        }else if(resultRevisionAsistencia=="2"){
          var TIpoIncidencia11 = response.datos[0]["incidenciaId"];
          var TIpoIncidencia22 = response.datos[1]["incidenciaId"];
          $("#asistenciaIncidenciaMismoDia1").val(TIpoIncidencia11);
          $("#asistenciaIncidenciaMismoDia2").val(TIpoIncidencia22);
        }
        $("#revisionIncidenciasMismoDia").val(resultRevisionAsistencia);    
      }
    },
    error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
  });
}

function UpdateRegistroPeticionMerma(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,asistenciaFecha,valordia){

  $.ajax({
    type: "POST",
    url: "ajax_UpdateRegistroPeticionMerma.php",
    data : {"empleadoEntidadId":empleadoEntidadId,"empleadoConsecutivoId":empleadoConsecutivoId,"empleadoTipoId":empleadoTipoId,"asistenciaFecha":asistenciaFecha,"valordia":valordia},
    dataType: "json",
    async:false,
    success: function(response) {
    },
    error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
  });

}

function RevisarIncapacidadPendiente(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,opcion){
  $.ajax({
        type: "POST",
        url: "ajax_RevisionIncapacidadPendiente.php",
        data : {"empleadoEntidadId":empleadoEntidadId,"empleadoConsecutivoId":empleadoConsecutivoId,"empleadoTipoId":empleadoTipoId},
        dataType: "json",
        async:false,
        success: function(response) {
          if (response.status == "success")
          {
            dictamen = response.dictamen;
            st7Falso = response.st7;
            if(response.st2=="0" || response.st2==0){
              $("#selectTipoIncapacidad").val(2);
              $("#divmuestraEnfermedadGeneral").show().val("");
             
              $("#divmuestrast2").show().val("");
              $("#selectTipoIncapacidad").prop("disabled",true);
              if(response.dictamen == "0" || response.dictamen == 0){
                $("#divmuestraDictamen").show();
              }else{
                $("#divmuestraDictamen").hide();
              }
            }else{
              $("#selectTipoIncapacidad").val(0);
              $("#divmuestraEnfermedadGeneral").hide();
              $("#divmuestrast7").hide(); 
              $("#divmuestrast2").hide();
              if(response.dictamen == "0" || response.dictamen == 0){
                $("#divmuestraDictamen").show();
              }else{
                $("#divmuestraDictamen").hide();
              }
              if(opcion == 0){
                $("#selectTipoIncapacidad").prop("disabled",false);
              }else{
                $("#selectTipoIncapacidad").prop("disabled",true);
              }
            }
            if(st7Falso == "1" || st7Falso == 1){
               $("#divmuestrast7").hide().val("");
            }
            
            guardardocumentoincapacidadRegistraincidencia(opcion);
          }
        },
        error: function(jqXHR, textStatus, errorThrown){
          alert(jqXHR.responseText);
        }
      });
}
function registrarPaseDeLista (incidenciaId, incidenciaText, nomenclaturaIncidencia)
{
  var diaHoy = moment().format("DD");
  var horaCompleta = moment().format("HH:mm:ss");
  var horaCompletasplit = horaCompleta.split(":");
  var horaCam = horaCompletasplit[0];
  var minutoCam = horaCompletasplit[1];
  var segundoCam = horaCompletasplit[2];
  var asistenciaFecha = $("#txtFechaAsistencia").val();
  var asistenciaFechaSplit = asistenciaFecha.split("-");
  var diaPaseAsis= asistenciaFechaSplit[2]; 
  var banderaFechaCierre = 0;
  
  if(diaHoy =="01"){
    // alert("1");
    if(diaPaseAsis == "01" ||  diaPaseAsis == "02" || diaPaseAsis == "03" || diaPaseAsis == "04" || diaPaseAsis == "05" || diaPaseAsis == "06" || diaPaseAsis == "07" || diaPaseAsis == "08" || diaPaseAsis == "09" || diaPaseAsis == "10" || diaPaseAsis == "11" || diaPaseAsis == "12" || diaPaseAsis == "13" || diaPaseAsis == "14" || diaPaseAsis == "15"){
      // alert("2");
      banderaFechaCierre = 1;  
    }else{
      // alert("3");
      if(horaCam >= "12"){
        // alert("4");
        banderaFechaCierre = 0;
      }else{
        // alert("5");
        if(horaCam == "11"){
          // alert("6");
          if(minutoCam == "59"){
            // alert("7");
            if(segundoCam>"10"){ 
              // alert("8");
              banderaFechaCierre = 0;
            }else{
              // alert("9");
              banderaFechaCierre = 1;
            }
          }else{
            // alert("10");
            banderaFechaCierre = 1;
          }
        }else{
          // alert("11");
          banderaFechaCierre = 1;
        }
      }
    }
  }else if(diaHoy =="16"){
    // alert("12");
    if(diaPaseAsis == "16" ||  diaPaseAsis == "17" || diaPaseAsis == "18" || diaPaseAsis == "19" || diaPaseAsis == "20" || diaPaseAsis == "21" || diaPaseAsis == "22" || diaPaseAsis == "23" || diaPaseAsis == "24" || diaPaseAsis == "25" || diaPaseAsis == "26" || diaPaseAsis == "27" || diaPaseAsis == "28" || diaPaseAsis == "28" || diaPaseAsis == "30" || diaPaseAsis == "31"){
      // alert("13");
      banderaFechaCierre = 1;  
    }else{
      // alert("14");
      if(horaCam > "12"){
        // alert("15");
        banderaFechaCierre = 0;
      }else{
        // alert("16");
        if(horaCam == "11"){
          // alert("17");
          if(minutoCam == "59"){
            // alert("18");
            if(segundoCam>"10"){
              // alert("19");
              banderaFechaCierre = 0;
            }else{
              // alert("20");
              banderaFechaCierre = 1;
            }
          }else{
            // alert("21");
            banderaFechaCierre = 1;
          }
        }else{
          // alert("22");
          banderaFechaCierre = 1;
        }
      }
    }
  }else{
    // alert("23 pase");
    banderaFechaCierre = 1;
  }
if(banderaFechaCierre=="1"){
  var  ban=0;
  var numeroEmpleado = $("#txtNumeroEmpleadoAsistencia").val ();
  var puestoCubiertoId= $("#selectPuestoAsistecia").val();

  var elementosNumeroEmpleado = numeroEmpleado.split ("-");
  var empleadoEntidadId = elementosNumeroEmpleado[0];
  var empleadoConsecutivoId = elementosNumeroEmpleado[1];
  var empleadoTipoId = elementosNumeroEmpleado[2];
  var empleadoPuntoServicioId = $("#selectPuntoServicioAsistencia").val();
  var comentariIncidencia=$("#txtComentarioIncidencia").val();
  var tipoPeriodo = $('input:radio[name=optionPeriodo]:checked').val();
  var supervisor=$("#txtsupervisorId").val();

  var supervisorElements = supervisor.split ("-");
  var supervisorEntidadId = supervisorElements [0];
  var supervisorConsecutivoId = supervisorElements [1];
  var supervisorTipoId = supervisorElements [2];

  //var idCliente=$("#op_"+empleadoPuntoServicioId).attr("idCliente");
  var valordia=0;
  //alert(supervisor);
  var plantilladeservicio1=$("#selplantillaservicio").val();
  var plantilladeservicio2 = plantilladeservicio1.split ("_");
  var plantilladeservicio = plantilladeservicio2[0];
  var idPlantillaServicio = plantilladeservicio2[1]; 

  var idlineanegocioPunto=$("#idlineanegociopunto").val();
  var idCliente = $("#idClienteCondicion").val();
  var visibleRh = $("#visibleRhCondicion").val();
  var CheckDiaPet = $("#CheckDiaPet").val();
  var CheckNochePet = $("#CheckNochePet").val();
  

  if(CheckDiaPet=="1"){
    valordia=CheckDiaPet;
  }
  if(CheckNochePet=="2"){
    valordia=CheckNochePet;
  }
  if(incidenciaId==8){ //verificar el tipo de puesto sea el correcto;
    if(puestoCubiertoId=="" || puestoCubiertoId=="0" || puestoCubiertoId=="PUESTO" || puestoCubiertoId=="null" || puestoCubiertoId=="NULL" || puestoCubiertoId==null ){
      alert("Selecciona un Puesto");
      $("#ModalIncapacidad").modal('hide');
      $("#myModalAsistencia").modal();
    }else if(empleadoPuntoServicioId=="PUNTOS DE SERVICIOS" || empleadoPuntoServicioId=="" || empleadoPuntoServicioId==0){
      alert("Selecciona una punto de servicio");
      $("#ModalIncapacidad").modal('hide');
      $("#myModalAsistencia").modal();
    }else if(plantilladeservicio==0 || plantilladeservicio=="PLANTILLA" || plantilladeservicio==""){
     alert("Selecciona una plantilla de servicio");
      $("#ModalIncapacidad").modal('hide');
      $("#myModalAsistencia").modal();
    }else if(idCliente=="2" && visibleRh=="0"){
     alert("No Es Posible Registrar una Incapacidad Con Un Punto De Servicio 'MERMA' Porfavor Selecciona Un Punto De Servicio Correcto!!");
      $("#ModalIncapacidad").modal('hide');
      $("#myModalAsistencia").modal();
    }else{
      st7="";
      st2="";
      dictamen="";
      st7Falso="";

      RevisarIncapacidadPendiente(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,2);
      $("#ModalIncapacidad").modal();
      $("#myModalAsistencia").modal('hide');
      $("#txtFechaIncapacidad").val(asistenciaFecha);
      $("#txtNumeroEmpleadoIncapacidad").val(numeroEmpleado);
      $("#txtNombreEmpleadoIncapacidad").val($("#txtNombreEmpleadoAsistencia").val());
      $("#inpfolioincapacidad").attr('maxlength','8');
      
      $("#inpfolioincapacidad").val("");
      $("#inpdiasincapacidad").val("");
      $("#archivost7").val("");
      $("#archivost2").val("");
      $("#archivosDict").val("");
      
    } //falta setear los inputs  
  }else if (incidenciaId==5 || incidenciaId==6 || incidenciaId==12 || incidenciaId==13 ){
    if(puestoCubiertoId=="" || puestoCubiertoId=="0" || puestoCubiertoId=="PUESTO" || puestoCubiertoId=="null" || puestoCubiertoId=="NULL" || puestoCubiertoId==null ){
      alert("Selecciona un Puesto");
      $("#ModalVacaciones").modal('hide');
      $("#divmuestraVacacionesDisfrutadas").hide();
      $("#myModalAsistencia").modal();
    }else if(empleadoPuntoServicioId=="PUNTOS DE SERVICIOS" || empleadoPuntoServicioId=="" || empleadoPuntoServicioId==0){
      alert("Selecciona una punto de servicio");
      $("#ModalVacaciones").modal('hide');
      $("#divmuestraVacacionesDisfrutadas").hide();
      $("#myModalAsistencia").modal();
    }else if(plantilladeservicio==0 || plantilladeservicio=="PLANTILLA" || plantilladeservicio==""){
     alert("Selecciona una plantilla de servicio");
      $("#ModalVacaciones").modal('hide');
      $("#divmuestraVacacionesDisfrutadas").hide();
      $("#myModalAsistencia").modal();
    }else if((idCliente=="2" && visibleRh=="1" && idlineanegocioPunto=='1') && (incidenciaId==5 || incidenciaId==12)){
     alert("No Es Posible Pasar Asistencias En Un Punto De Servicio 'CUBRE' Porfavor Selecciona Otro Punto De Servicio ó Pasa Asistencia En 'MERMA' !!RECUERDA EL PASE DE ASISTENCIA EN MERMA ESTA SUJETO A APROBACIÓN!!");
      $("#ModalVacaciones").modal('hide');
      $("#divmuestraVacacionesDisfrutadas").hide();
      $("#myModalAsistencia").modal();
    }else if((idCliente=="2" && visibleRh=="0") && (incidenciaId==5 || incidenciaId==12)){
     alert("No Es Posible Realizar Un Registro De Vacaciones Con Un Punto De Servicio 'MERMA' Porfavor Selecciona Un Punto De Servicio Correcto!!");
      $("#ModalVacaciones").modal('hide');
      $("#divmuestraVacacionesDisfrutadas").hide();
      $("#myModalAsistencia").modal();
    }else{
      $("#empleadoEntidadIdVacaciones").val(empleadoEntidadId);
      $("#empleadoConsecutivoIdVacaciones").val(empleadoConsecutivoId);
      $("#empleadoTipoIdVacaciones").val(empleadoTipoId);
      $("#empleadoPuntoServicioIdVacaciones").val(empleadoPuntoServicioId);
      $("#supervisorEntidadIdVacaciones").val(supervisorEntidadId);
      $("#supervisorConsecutivoIdVacaciones").val(supervisorConsecutivoId);
      $("#supervisorTipoIdVacaciones").val(supervisorTipoId);
      $("#incidenciaIdVacaciones").val(incidenciaId);
      $("#asistenciaFechaVacaciones").val(asistenciaFecha);
      $("#comentariIncidenciaVacaciones").val(comentariIncidencia);
      $("#tipoPeriodoVacaciones").val(tipoPeriodo);
      $("#puestoCubiertoIdVacaciones").val(puestoCubiertoId);
      $("#idClienteVacaciones").val(idCliente);
      $("#plantilladeservicioVacaciones").val(plantilladeservicio1);//Fatla editar esteeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee
      $("#idlineanegocioPuntoVacaciones").val(idlineanegocioPunto);
      $("#incidenciaVacaciones").val(incidenciaId);
      abrirmodalvacaciones(numeroEmpleado,nomenclaturaIncidencia);
    }
  }// este if es para las peticiones que son de vacaciones unicamente
  else{
    if(puestoCubiertoId=="" || puestoCubiertoId=="0" || puestoCubiertoId=="PUESTO" || puestoCubiertoId=="null" || puestoCubiertoId=="NULL" || puestoCubiertoId==null ){
      alert("Selecciona un Puesto");
    }else if(empleadoPuntoServicioId=="PUNTOS DE SERVICIOS" || empleadoPuntoServicioId=="" || empleadoPuntoServicioId==0){
      alert("Selecciona una punto de servicio");
    }else if(plantilladeservicio==0 || plantilladeservicio=="PLANTILLA"){
      alert("Selecciona una plantilla de servicio");
    }else if(incidenciaId != "4" && incidenciaId!= "10" && incidenciaId != "1" && incidenciaId != "7" && idCliente=="2" && visibleRh=="1" && idlineanegocioPunto=='1'){
      alert("No Es Posible Pasar Asistencias En Un Punto De Servicio 'CUBRE' Porfavor Selecciona Otro Punto De Servicio ó Pasa Asistencia En 'MERMA' !!RECUERDA EL PASE DE ASISTENCIA EN MERMA ESTA SUJETO A APROBACIÓN!!");
    }else if(incidenciaId!=2 && incidenciaId!=3 && idCliente=="2" && visibleRh=="0"){
      alert("Solo Puedes Registrar En 'MERMA' Los Turnos (12x12 ó 24x24) Porfavor Escoge Un Punto De Servicio Correcto");
    }else if((incidenciaId==2 || incidenciaId==3) && idCliente=="2" && visibleRh=="0" && comentariIncidencia=="" ){
      alert("Porfavor Indica En El Comentario El Motivo Por El Cúal Se Está Pasando La Asistencia En El Punto De (MERMA) !!RECUERDA EL PASE DE ASISTENCIA EN MERMA ESTA SUJETO A APROBACIÓN!!");
    }else if(incidenciaId==2  && idCliente=="2" && visibleRh=="0" && CheckDiaPet!="1" && CheckNochePet !="2"){
      alert("Favor De Indica El Turno De Asistencia !!RECUERDA EL PASE DE ASISTENCIA EN MERMA ESTA SUJETO A APROBACIÓN!!");
    }else if((incidenciaId==2 || incidenciaId==3) && idCliente=="2" && visibleRh=="0" && comentariIncidencia!="" ){
      RevisarPeticionesMerma(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,asistenciaFecha);
      var revisionPeticionA = $("#revisionPeticionA").val();
      var tipoIncidencia1 = $("#TIpoIncidencia1").val();
      var tipoIncidencia2 = $("#TIpoIncidencia2").val();
      var tipoIncidenciaPeticionM = "Incidencia_Normal";
      var PeticionesCapacitacionParaMerma = $("#revicionIncidenciaCapacitacion").val();
                      
      if(revisionPeticionA != "0"){
        alert("No Es Posible Realizar El Registro , El Empleado Cuenta Con Un Registro (Petición En Este Dia)");
      }else if(PeticionesCapacitacionParaMerma != "0"){
        alert("No Es Posible Realizar El Registro , El Empleado Cuenta Con Un Registro (Petición De Capacitacion En Este Dia)");
      }else{
        $.ajax({
          type: "POST",
          url: "ajax_insertPeticionAsistenciaMerma.php",//Ya se realizo el cambio por id de plantilla falta al recibir la merma
          data: {"empleadoEntidadId":empleadoEntidadId, "empleadoConsecutivoId": empleadoConsecutivoId, "empleadoTipoId":empleadoTipoId, "empleadoPuntoServicioId": empleadoPuntoServicioId, "supervisorEntidadId":supervisorEntidadId, "supervisorConsecutivoId": supervisorConsecutivoId, "supervisorTipoId":supervisorTipoId, "incidenciaId":incidenciaId, "asistenciaFecha":asistenciaFecha, "comentariIncidencia":comentariIncidencia, "tipoPeriodo":tipoPeriodo, "puestoCubiertoId":puestoCubiertoId, "idCliente":idCliente, "valordia": valordia,"plantilladeservicio":plantilladeservicio,"idlineanegocioPunto":idlineanegocioPunto,"tipoIncidenciaPeticionM":tipoIncidenciaPeticionM,"idPlantillaServicio":idPlantillaServicio,"selectMotivoIncidenciaEspecial":0},
          dataType: "json",
          async:false,
          success: function(response) {
            alert("PETICIÓN ENVIADA CORRECTAMENTE ESPERANDO APROBACIÓN");
            // if(busqueda=="puntoServicio"){
            //   tableEmpleadosByPeriodoSupervisor ();
            // }else if (busqueda=="numeroEmpleado"){
            //   consultaEmpleadoByIdByUser();
            // }else if(busqueda="nombreEmpleado"){
            //   consultaEmpleadoByNameByUser();
            // }       
            generarTablaPeriodo123();                    
            },
            error: function(jqXHR, textStatus, errorThrown){
              alert(jqXHR.responseText);
            }
        });
        $("#myModalAsistencia").modal("hide");
      }
    }else{
       RevisarAsistecniasIncidenciasMismoDia(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,asistenciaFecha);
       var asistenciaIncidenciaMismoDia1 = $("#asistenciaIncidenciaMismoDia1").val(); 
       var asistenciaIncidenciaMismoDia2 = $("#asistenciaIncidenciaMismoDia2").val(); 
       var revisionIncidenciasMismoDia = $("#revisionIncidenciasMismoDia").val();
       
      if(incidenciaId==2 || incidenciaId==9 || incidenciaId==1 || incidenciaId==4 || incidenciaId==7)
      {
        
      if(incidenciaId==1 && idCliente!="2" && puestoCubiertoId=="66"){
        $("#myModalAsistencia").modal("hide");
        var mensaje="No Es Posible Registrar, Debido A Que No Puedes Pasar Descanso En Puntos Cubre Descanso Que No Sea Del CLiente Gif Seguridad";
                  mostrarModalError(mensaje,'');
      }else{ 
        $.confirm({
          'title'   : 'Confirmación de Asistencia',
          'message' : 'Seleccione una opción',
          'buttons' : {
            'Dia' : {
              'class' : 'blue',
              'action': function()
              {
              if((revisionIncidenciasMismoDia=="2" || revisionIncidenciasMismoDia=="1") && (incidenciaId==2 || incidenciaId==9) && (asistenciaIncidenciaMismoDia1==1 || asistenciaIncidenciaMismoDia1==3 || asistenciaIncidenciaMismoDia1==7 || asistenciaIncidenciaMismoDia2==1 || asistenciaIncidenciaMismoDia2==3 || asistenciaIncidenciaMismoDia2==7) && (idlineanegocioPunto=="1")){
                  var mensaje="No Es Posible Registrar, Debido A Que Ya Existe Un Registro De Dia En Este Dia Con Este Empleado, Favor De Borrar El Registro Si Se Requiere Registrar Uno Diferente";
                  mostrarModalError(mensaje,'');
              }else{
                valordia=1;
                $.ajax ({            
                  type: "POST",
                  url: "ajax_registrarAsistencia.php",
                  data: {empleadoEntidadId:empleadoEntidadId, empleadoConsecutivoId: empleadoConsecutivoId, empleadoTipoId:empleadoTipoId, empleadoPuntoServicioId: empleadoPuntoServicioId, supervisorEntidadId:supervisorEntidadId, supervisorConsecutivoId: supervisorConsecutivoId, supervisorTipoId:supervisorTipoId, incidenciaId:incidenciaId, asistenciaFecha:asistenciaFecha, comentariIncidencia:comentariIncidencia, tipoPeriodo:tipoPeriodo, puestoCubiertoId:puestoCubiertoId, idCliente:idCliente, valordia: valordia,plantilladeservicio:plantilladeservicio,"idlineanegocioPunto":idlineanegocioPunto,"idPlantillaServicio":idPlantillaServicio},
                  dataType: "json",
                  async:false,
                  success: function (response) 
                  {
                    if (response.status == "error")
                    {                        
                      var mensaje=response.message;                                
                      valordia=0;
                      mostrarModalError(mensaje,'');
                    }else if(response.status=="errorRegistro"){                                
                      valordia=0;
                      alert (response.message);
                    }else if(response.status=="errorCobertura"){
                      var mensaje=response.message;
                      var puestosCobertura=response.puestosCobertura;                              
                      valordia=0;
                      mostrarModalError(mensaje,puestosCobertura);
                    }else
                    {
                      id = $("#idCell").val ();
                      $("#" + id).html (nomenclaturaIncidencia);
                      var style = styles [nomenclaturaIncidencia];
                      $("#td_"+id).attr("style",style); 
                      $("#" + id).attr ("incidenciaAsistenciaId", incidenciaId);
                      $("#" + id).attr ("incidenciaText",  nomenclaturaIncidencia);    
                      UpdateRegistroPeticionMerma(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,asistenciaFecha,valordia);   
                      ActualizarCampoCapacitacionEnAsistencia(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,asistenciaFecha,comentariIncidencia);                         
                      var PeticionesCapacitacionDescanso = $("#revicionIncidenciaCapacitacion").val();
                      if(PeticionesCapacitacionDescanso != "0"){
                        var EstatusCap = "5";
                        ActualizarEstatusPeticionCapacitacion(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,asistenciaFecha,EstatusCap);
                      }
                      valordia=0;
                      if (response.asistencia != null)
                      {
                        for (var k in response.asistencia)
                        {
                          fecha = k;
                          id = empleadoEntidadId + "-" + empleadoConsecutivoId + "-" + empleadoTipoId + empleadoPuntoServicioId + fecha;
                          nomenclaturaIncidencia = response.asistencia[k].nomenclaturaIncidencia;
                          incidenciaId = response.asistencia[k].incidenciaAsistenciaId;
                          $("#" + id).html (nomenclaturaIncidencia);
                          var style = styles [nomenclaturaIncidencia];
                          $("#td_"+id).attr("style",style);             
                          $("#" + id).attr ("incidenciaAsistenciaId", incidenciaId);
                          $("#" + id).attr ("incidenciaText",  nomenclaturaIncidencia);
                        }
                      }
                      // if(busqueda=="puntoServicio"){
                      //   tableEmpleadosByPeriodoSupervisor ();
                      // }else if (busqueda=="numeroEmpleado"){
                      //   consultaEmpleadoByIdByUser();
                      // }else if(busqueda="nombreEmpleado"){
                      //   consultaEmpleadoByNameByUser();
                      // }
                      generarTablaPeriodo123();

                    }
                  },
                  error: function (response) {                            
                    valordia=0;
                    alert(response.responseText);
                  }
                });
               }//else condicion un dia
               $("#myModalAsistencia").modal("hide");
              }///accion
            },//dia
            'Noche'  : {
              'class' : 'gray',
              'action': function(){
                if((revisionIncidenciasMismoDia=="2" || revisionIncidenciasMismoDia=="1") && (incidenciaId==2 || incidenciaId==9) && (asistenciaIncidenciaMismoDia1==2 || asistenciaIncidenciaMismoDia1==4 || asistenciaIncidenciaMismoDia1==6 || asistenciaIncidenciaMismoDia1==7 || asistenciaIncidenciaMismoDia2==2 || asistenciaIncidenciaMismoDia2==4 || asistenciaIncidenciaMismoDia2==6 || asistenciaIncidenciaMismoDia2==7) && (idlineanegocioPunto=="1")){
                  var mensaje="No Es Posible Registra, Debido A Que Ya Existe Un Registro De Noche En Este Dia Con Este Empleado, Favor De Borrar El Registro Si Se Requiere Registrar Uno Diferente";
                  mostrarModalError(mensaje,'');
              }else{
                valordia=2;
                $.ajax ({            
                  type: "POST",
                  url: "ajax_registrarAsistencia.php",
                  data: {empleadoEntidadId:empleadoEntidadId, empleadoConsecutivoId: empleadoConsecutivoId, empleadoTipoId:empleadoTipoId,empleadoPuntoServicioId: empleadoPuntoServicioId, supervisorEntidadId:supervisorEntidadId, supervisorConsecutivoId: supervisorConsecutivoId, supervisorTipoId, supervisorTipoId, incidenciaId:incidenciaId, asistenciaFecha:asistenciaFecha, comentariIncidencia:comentariIncidencia, tipoPeriodo:tipoPeriodo, puestoCubiertoId:puestoCubiertoId, idCliente:idCliente, valordia: valordia,plantilladeservicio,"idlineanegocioPunto":idlineanegocioPunto,"idPlantillaServicio":idPlantillaServicio},
                    dataType: "json",
                    async:false,
                  success: function (response) {
                    if (response.status == "error")
                    {
                      var mensaje=response.message;                                
                      valordia=0;
                      mostrarModalError(mensaje,'');
                    }else if(response.status=="errorRegistro"){
                      ban=0;
                      valordia=0;
                      alert (response.message);
                    }else if(response.status=="errorCobertura"){
                      var mensaje=response.message;
                      var puestosCobertura=response.puestosCobertura;                              
                      valordia=0;
                      mostrarModalError(mensaje,puestosCobertura);
                    }else
                    {
                      id = $("#idCell").val ();
                      $("#" + id).html (nomenclaturaIncidencia);
                      var style = styles [nomenclaturaIncidencia];
                      $("#td_"+id).attr("style",style);
                      $("#" + id).attr ("incidenciaAsistenciaId", incidenciaId);
                      $("#" + id).attr ("incidenciaText",  nomenclaturaIncidencia);
                      ActualizarCampoCapacitacionEnAsistencia(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,asistenciaFecha,comentariIncidencia);
                      UpdateRegistroPeticionMerma(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,asistenciaFecha,valordia);     
                      var PeticionesCapacitacionDescanso = $("#revicionIncidenciaCapacitacion").val();
                      if(PeticionesCapacitacionDescanso != "0"){
                        var EstatusCap = "5";
                        ActualizarEstatusPeticionCapacitacion(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,asistenciaFecha,EstatusCap);
                      }                           
                      valordia=0;
                      if (response.asistencia != null)
                      {
                        for (var k in response.asistencia)
                        {
                          fecha = k;
                          id = empleadoEntidadId + "-" + empleadoConsecutivoId + "-" + empleadoTipoId + empleadoPuntoServicioId + fecha;
                          nomenclaturaIncidencia = response.asistencia[k].nomenclaturaIncidencia;
                          incidenciaId = response.asistencia[k].incidenciaAsistenciaId;
                          $("#" + id).html (nomenclaturaIncidencia);
                          var style = styles [nomenclaturaIncidencia];
                          $("#td_"+id).attr("style",style);             
                          $("#" + id).attr ("incidenciaAsistenciaId", incidenciaId);
                          $("#" + id).attr ("incidenciaText",  nomenclaturaIncidencia);
                        }
                      }
                      // if(busqueda=="puntoServicio"){
                      //   tableEmpleadosByPeriodoSupervisor ();
                      // }else if (busqueda=="numeroEmpleado"){
                      //   consultaEmpleadoByIdByUser();
                      // }else if(busqueda="nombreEmpleado"){
                      //   consultaEmpleadoByNameByUser();
                      // }
                      generarTablaPeriodo123();
                    }
                  },
                  error: function(jqXHR, textStatus, errorThrown) {
                    valordia=0;
                    alert(jqXHR.responseText);
                  }
                });
               } //condicion un dia
               $("#myModalAsistencia").modal("hide");
              }  //accion
            }//cierra noche
          }//Cierra Botones
        });//Cierra confirmacion
      }
      }else if(incidenciaId==10){

        var estatusOP='';

        $.ajax({
        type: "POST",
        url: "ajax_consultaEstatusOperaciones.php",
        data : {"empleadoEntidadId":empleadoEntidadId,"empleadoConsecutivoId":empleadoConsecutivoId,"empleadoTipoId":empleadoTipoId},
        dataType: "json",
        async:false,
        success: function(response) {
          if (response.status == "success"){
            estatusOP=response.datos[0]["estatusEmpleadoOperaciones"];
          }
        },
        error: function(jqXHR, textStatus, errorThrown){
          alert(jqXHR.responseText);
        }
      });

        if (estatusOP!='1' && estatusOP!='4') {
          var mensaje="Este empleado ya cuenta con una solicitud de baja, por lo cual no se puede procesar la petición realizada";
                  mostrarModalError(mensaje,'');

        }else{

        var NombreE = $("#txtNombreEmpleadoAsistencia").val();//nombre empleado baja
        var NumeroE = $("#txtNumeroEmpleadoAsistencia").val();//numero mepleado baja
        var PuntoE = $("#selectPuntoServicioAsistencia option:selected" ).text();
        var PuestE = $("#selectPuestoAsistecia option:selected" ).text();
        $("#BajaEmpModal").val("");
        $("#BajaEmpModal").empty();
        $("#abandonoServicio").prop("checked", false);
        $("#faltasInjustiicadas").prop("checked", false);
        $("#indiciplina").prop("checked", false);
        $("#terminoServicio").prop("checked", false);
        $("#otros").prop("checked", false);
        $("#especifiqueMotivo").val("");
        $("#NombreSolicitante").val("");
        $("#FirmaInterna").val("");
        var fehcaBajaM1 = new Date;
        var fehcaBajaM=(fehcaBajaM1.getFullYear() + "-" + (fehcaBajaM1.getMonth() +1) + "-" + fehcaBajaM1.getDate());

          $("#FechaBajaEmpModal").val(fehcaBajaM);
          $("#NumEmpModal").val(NumeroE);
          $("#NumEmpModal1").val(NumeroE);
          $("#NombreEMpModal").val(NombreE);
          $("#PuestoEmpModal").val(PuestE);
          $("#PuntoEmpModal").val(PuntoE);
          $("#FechaBajaSolicitadaEmp").val(asistenciaFecha);
          $("#empleadoEntidadIdHiddenBajaEmp").val(empleadoEntidadId);
          $("#empleadoConsecutivoIdHiddenBajaEmp").val(empleadoConsecutivoId);
          $("#empleadoTipoIdHiddenBajaEmp").val(empleadoTipoId);
          $("#empleadoPuntoServicioIdHiddenBajaEmp").val(empleadoPuntoServicioId);
          $("#supervisorEntidadIdHiddenBajaEmp").val(supervisorEntidadId);
          $("#supervisorConsecutivoIdHiddenBajaEmp").val(supervisorConsecutivoId);
          $("#supervisorTipoIdHiddenBajaEmp").val(supervisorTipoId);
          $("#incidenciaIdHiddenBajaEmp").val(incidenciaId);
          $("#comentariIncidenciaHiddenBajaEmp").val(comentariIncidencia);
          $("#tipoPeriodoHiddenBajaEmp").val(tipoPeriodo);
          $("#puestoCubiertoIdHiddenBajaEmp").val(puestoCubiertoId);
          $("#idClienteHiddenBajaEmp").val(idCliente);
          $("#valordiaHiddenBajaEmp").val(valordia);
          $("#plantilladeservicioHiddenBajaEmp").val(plantilladeservicio1);
          $("#nomenclaturaIncidenciaHiddenBajaEmp").val(nomenclaturaIncidencia);
          $("#busquedaHiddenBajaEmp").val(busqueda);
          $("#modalBajaEmpelado").modal();
          $("#myModalAsistencia").modal("hide");
        }
      }else if(incidenciaId==14){
          RevicionPeticionesCapacitacion(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,asistenciaFecha);
          RevisarAsistecniasIncidenciasMismoDia(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,asistenciaFecha);
          var PeticionesCapacitacion = $("#revicionIncidenciaCapacitacion").val();
          var revisionIncidenciasMismoDia = $("#revisionIncidenciasMismoDia").val();
        
          if(PeticionesCapacitacion =="0" && revisionIncidenciasMismoDia=="0"){
            $.ajax({
              type: "POST",
              url: "ajax_RegistrarPeticionCapacitacion.php",
              data:{"asistenciaFecha":asistenciaFecha,
                    "puestoCubiertoId":puestoCubiertoId,
                    "empleadoEntidadId":empleadoEntidadId,
                    "empleadoConsecutivoId":empleadoConsecutivoId,
                    "empleadoTipoId":empleadoTipoId,
                    "empleadoPuntoServicioId":empleadoPuntoServicioId,
                    "supervisorEntidadId":supervisorEntidadId,
                    "supervisorConsecutivoId":supervisorConsecutivoId,
                    "supervisorTipoId":supervisorTipoId,
                    "plantilladeservicio":plantilladeservicio,
                    "idPlantillaServicio":idPlantillaServicio},

              dataType: "json",
              async:false,
              success: function(response) {
                if(response.status == "success"){
                  // if(busqueda=="puntoServicio"){
                  //   tableEmpleadosByPeriodoSupervisor ();
                  // }else if (busqueda=="numeroEmpleado"){
                  //   consultaEmpleadoByIdByUser();
                  // }else if(busqueda="nombreEmpleado"){
                  //   consultaEmpleadoByNameByUser();
                  // } 
                  generarTablaPeriodo123();
                  $("#myModalAsistencia").modal("hide");   
                  $("#revicionIncidenciaCapacitacion").val("");
                }else{
                  mostrarModalError(response.message,'');
                  $("#myModalAsistencia").modal("hide");
                }
              },
              error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
              }
            }); 
          }else{
            mostrarModalError("Ya Se Realizó Un Registro En Este Dia Si Requiere Registra Una Incidencia De Capaciatación Favor De Borrar El Registro ",'');
          }
      }else// Este es el if de  peticiones que tienen dia y noche
      {
       if((revisionIncidenciasMismoDia=="2" || revisionIncidenciasMismoDia=="1") && (incidenciaId==3) && (asistenciaIncidenciaMismoDia1==1 || asistenciaIncidenciaMismoDia1==2 || asistenciaIncidenciaMismoDia1==3  || asistenciaIncidenciaMismoDia1==4 || asistenciaIncidenciaMismoDia1==6 || asistenciaIncidenciaMismoDia1==7 || asistenciaIncidenciaMismoDia2==1 || asistenciaIncidenciaMismoDia2==2 || asistenciaIncidenciaMismoDia2==3 || asistenciaIncidenciaMismoDia2==4 || asistenciaIncidenciaMismoDia2==6 || asistenciaIncidenciaMismoDia2==7) && (idlineanegocioPunto=="1")){
                  var mensaje="No Es Posible Registra, Debido A Que Ya Existe Un Registro (Dia/Noche/24x24) En Este Dia Con Este Empleado, Favor De Borrar El Registro Si Se Requiere Registrar Uno Diferente";
                  mostrarModalError(mensaje,'');
       }else{
        $.ajax ({            
          type: "POST",
          url: "ajax_registrarAsistencia.php",
          data: {empleadoEntidadId:empleadoEntidadId, empleadoConsecutivoId: empleadoConsecutivoId, empleadoTipoId:empleadoTipoId,        empleadoPuntoServicioId: empleadoPuntoServicioId, supervisorEntidadId:supervisorEntidadId, supervisorConsecutivoId: supervisorConsecutivoId, supervisorTipoId, supervisorTipoId, incidenciaId:incidenciaId, asistenciaFecha:asistenciaFecha, comentariIncidencia:comentariIncidencia, tipoPeriodo:tipoPeriodo, puestoCubiertoId:puestoCubiertoId, idCliente:idCliente, valordia: valordia,plantilladeservicio,"idlineanegocioPunto":idlineanegocioPunto,"idPlantillaServicio":idPlantillaServicio},
          dataType: "json",
          async:false,
          success: function (response) {
            if (response.status == "error")
            {
              var mensaje=response.message;                    
              valordia=0;
              mostrarModalError(mensaje,'');
            }else if(response.status=="errorRegistro"){                    
              valordia=0;
              alert (response.message);
            }else if(response.status=="errorCobertura"){
              var mensaje=response.message;
              var puestosCobertura=response.puestosCobertura;                  
              valordia=0;
              mostrarModalError(mensaje,puestosCobertura);
            }else
            {
              id = $("#idCell").val ();
              $("#" + id).html (nomenclaturaIncidencia);
              var style = styles [nomenclaturaIncidencia];
              $("#td_"+id).attr("style",style);       
              $("#" + id).attr ("incidenciaAsistenciaId", incidenciaId);
              $("#" + id).attr ("incidenciaText",  nomenclaturaIncidencia);
              ActualizarCampoCapacitacionEnAsistencia(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,asistenciaFecha,comentariIncidencia);
              UpdateRegistroPeticionMerma(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,asistenciaFecha,valordia);   
              var PeticionesCapacitacion24x24 = $("#revicionIncidenciaCapacitacion").val();
              if(PeticionesCapacitacion24x24 != "0"){
                var EstatusCap = "5";
                ActualizarEstatusPeticionCapacitacion(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,asistenciaFecha,EstatusCap);
              }                                    
              valordia=0;
              if (response.asistencia != null)
              {
                for (var k in response.asistencia)
                {
                  fecha = k;
                  id = empleadoEntidadId + "-" + empleadoConsecutivoId + "-" + empleadoTipoId + empleadoPuntoServicioId + fecha;
                  nomenclaturaIncidencia = response.asistencia[k].nomenclaturaIncidencia;
                  incidenciaId = response.asistencia[k].incidenciaAsistenciaId;
                  $("#" + id).html (nomenclaturaIncidencia);
                  var style = styles [nomenclaturaIncidencia];
                  $("#td_"+id).attr("style",style);           
                  $("#" + id).attr ("incidenciaAsistenciaId", incidenciaId);
                  $("#" + id).attr ("incidenciaText",  nomenclaturaIncidencia);
                }
              }
              // if(busqueda=="puntoServicio"){
              //   tableEmpleadosByPeriodoSupervisor ();
              // }else if (busqueda=="numeroEmpleado"){
              //   consultaEmpleadoByIdByUser();
              // }else if(busqueda="nombreEmpleado"){
              //   consultaEmpleadoByNameByUser();
              // }
              generarTablaPeriodo123();
            }
          },
          error: function (response) {                
            valordia=0;
            alert (response.responseText);
          }
        });
       }//Condicion Registro De Un Solo Dia
       $("#myModalAsistencia").modal("hide"); 
      }//termina el else que separa la incidencias de dia y noche de las que no toman en cuenta eso
    }// es el else despues de la svalidaciones y el que manda sobre las incidencias
  }//cierra el else indicador que la incidencia no es 8 incapaciadas ni 5,6 vacaciones
 }else{
  alert("Haz pasado la hora permitada para el pase de asistencia despues del cierre");
  generarTablaPeriodo123();
 }
}

function GenerarPdfBajaEmpleado(){
  var NumEmpBaja = $("#NumEmpModal").val(); 
  var fechaBaj = $("#FechaBajaEmpModal").val(); 
  window.open("generadordocBajaEmpleado.php?numempleado=" + NumEmpBaja + "&" + "fechaBaj=" + fechaBaj,'fullscreen=no');
}

$('#faltasInjustiicadas').change(function() {
    if ($('#faltasInjustiicadas').is(":checked")) {
      $("#abandonoServicio").prop("checked", false);
      $("#indiciplina").prop("checked", false);
      $("#terminoServicio").prop("checked", false);
      $("#otros").prop("checked", false);
    } 
  });
$('#abandonoServicio').change(function() {
    if ($('#abandonoServicio').is(":checked")) {
      $("#faltasInjustiicadas").prop("checked", false);
      $("#indiciplina").prop("checked", false);
      $("#terminoServicio").prop("checked", false);
      $("#otros").prop("checked", false);

    } 
  });$('#indiciplina').change(function() {
    if ($('#indiciplina').is(":checked")) {
      $("#faltasInjustiicadas").prop("checked", false);
      $("#abandonoServicio").prop("checked", false);
      $("#terminoServicio").prop("checked", false);
      $("#otros").prop("checked", false);

    } 
  });$('#terminoServicio').change(function() {
    if ($('#terminoServicio').is(":checked")) {
      $("#faltasInjustiicadas").prop("checked", false);
      $("#abandonoServicio").prop("checked", false);
      $("#indiciplina").prop("checked", false);
      $("#otros").prop("checked", false);

    } 
  });$('#otros').change(function() {
    if ($('#otros').is(":checked")) {
      $("#faltasInjustiicadas").prop("checked", false);
      $("#abandonoServicio").prop("checked", false);
      $("#indiciplina").prop("checked", false);
      $("#terminoServicio").prop("checked", false);

    } 
  });

function firmarDocumento(){
  $("#NumEmpModalBaja").val("");
  $("#constraseniaFirma").val("");
  $("#modalFirmaElectronica").modal();
  $("#modalBajaEmpelado").modal("hide");
}

function cancelarFirma(){
  $("#modalFirmaElectronica").modal("hide");
  $("#modalBajaEmpelado").modal();
  $("#NumEmpModalBaja").val("");
  $("#constraseniaFirma").val("");
}

function RevisarFirmaInterna(){
  var NumEmpModalBaja = $("#NumEmpModalBaja").val();
  var constraseniaFirma = $("#constraseniaFirma").val();
 
 if(NumEmpModalBaja==""){
   cargaerroresFirmaInternaBaja("El numero de empleado no puede estar vaacio");
  }else if(constraseniaFirma==""){
     cargaerroresFirmaInternaBaja("Escriba la contraseña para continuar");
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
          cargaerroresFirmaInternaBaja("La Contraseña ingresada es incorrecta favor de escribirla exactamente como la ingreso en el registro");
        }else{
          var nombre = response.datos["0"].nombreEmpleado + " " + response.datos["0"].apellidoPaterno + " " + response.datos["0"].apellidoMaterno;
          var contraseniaInsertadaCifrada =response.datos["0"].ContraseniaFirma;
          $("#numempleadoFirmahidden").val(NumEmpModalBaja);
          $("#NombreSolicitante").val(nombre);
          $("#FirmaInterna").val(contraseniaInsertadaCifrada);
          $("#modalFirmaElectronica").modal("hide");
          $("#modalBajaEmpelado").modal();
          $("#NumEmpModalBaja").val("");
          $("#constraseniaFirma").val("");
        }
         
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
    });
  }
}

$("#NumEmpModalBaja").keyup(function () 
{

 var NumEmpModalBaja = $("#NumEmpModalBaja").val();
 var expreg = /^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/;
 var expreg1 = /^[0-9]{2}\-[0-9]{5}\-[0-9]{2}/;
 
 if(expreg.test(NumEmpModalBaja) || expreg1.test(NumEmpModalBaja)){
    consultaEmpleadoFirmaInternaBaja(NumEmpModalBaja);
  }else{
    //cargaerroresFirmaInternaBaja("El Formato Del Numero De Empleado Es Incorrecto");
    $("#constraseniaFirma").val("");
    $("#btnFirmarDoc").hide();
  }
});





function consultaEmpleadoFirmaInternaBaja (numeroEmpleado){
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
          cargaerroresFirmaInternaBaja("El Empleado No Existe En La Base De Registro De Firmas Favor De Verificar");
          $("#NumEmpModalBaja").val("");
          $("#btnFirmarDoc").hide();
        }else {
          var EstatusFirmaInterna = response.empleado[0].EstatusFirmaInterna;
          if(EstatusFirmaInterna=="0"){
            cargaerroresFirmaInternaBaja("Esta Firma Fue Dada De Baja Favor de solicitar Otra o Comunicarse Con RH"); 
            $("#NumEmpModalBaja").val("");
            $("#btnFirmarDoc").hide();
          }else{
            $("#btnFirmarDoc").show();
          }
        }
      }else{
        cargaerroresFirmaInternaBaja(response.menssaje); 
        $("#NumEmpModalBaja").val("");
        $("#btnFirmarDoc").hide();
      }
    },error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }

  });
}

function cargaerroresFirmaInternaBaja(mensaje){
  $('#errorModalFirmaInterna').fadeIn();
  msjerrorbaja="<div id='errorModalFirmaInterna1' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errorModalFirmaInterna").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errorModalFirmaInterna').delay(4000).fadeOut('slow'); 
}
function mensajeErrorModalBaja1(Tipo,mensaje){
  $('#msgerrormodalbaja').fadeIn();
  msjerrorbaja="<div id='msgerrormodalbaja' class='alert alert-"+Tipo+"'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errorModalBajaEmpleado").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#msgerrormodalbaja').delay(4000).fadeOut('slow'); 
}

function GuardarDocumentoBaja(){ 
  var MotivoBaja = "0";
  var especifiqueMotivo1 = $("#especifiqueMotivo").val();
  var numempleadoFirmahidden = $("#numempleadoFirmahidden").val();
  var FirmaInterna = $("#FirmaInterna").val();
  var asistenciaFecha = $("#FechaBajaSolicitadaEmp").val();//baja formulario
  var FechaBajaEmpModal = $("#FechaBajaEmpModal").val();//actual
  var empleadoEntidadId = $("#empleadoEntidadIdHiddenBajaEmp").val();
  var empleadoConsecutivoId = $("#empleadoConsecutivoIdHiddenBajaEmp").val();
  var empleadoTipoId = $("#empleadoTipoIdHiddenBajaEmp").val();
  var ComentarioBetadoAsistencia = $("#ComentarioBetadoAsistencia").val();
  var banderaBetadoAsistencia = $("#banderaBetadoAsistencia").val();
  var PeticionesCapacitacionBaja = $("#revicionIncidenciaCapacitacion").val();
  var plantilladeservicio1 = $("#plantilladeservicioHiddenBajaEmp").val();
    var plantilladeservicio2 = plantilladeservicio1.split ("_");
    var plantilladeservicio = plantilladeservicio2[0];
    var idPlantillaServicio = plantilladeservicio2[1];
  RevicionPeticionesCapacitacion(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,FechaBajaEmpModal);
  if ($('#terminoServicio').is(":checked")) {
    MotivoBaja = "6";
  }else if ($('#faltasInjustiicadas').is(":checked")) {
    MotivoBaja = "9";
  }else if ($('#abandonoServicio').is(":checked")) {
    MotivoBaja = "7";
  }else if ($('#indiciplina').is(":checked")) {
    MotivoBaja = "10";
  }else if ($('#otros').is(":checked")) {
    MotivoBaja = "12";
  }else{
    MotivoBaja = "0";
  }
  if(MotivoBaja=="0"){
     mensajeErrorModalBaja1("error","Marca una de las opciones del motivo de baja para continuar");
  }else if(especifiqueMotivo1==""){
    mensajeErrorModalBaja1("error","Especifique el motivo de la baja ");
  }else if(numempleadoFirmahidden=="" || FirmaInterna==""){
    mensajeErrorModalBaja1("error","El documento debe estar firmado para continuar Favor de firmar el documento con el boton verde")
  }else if(banderaBetadoAsistencia=="" || banderaBetadoAsistencia=="null" || banderaBetadoAsistencia=="NULL" || banderaBetadoAsistencia==null){
     mensajeErrorModalBaja1("error","Seleccione una opcion de la pregunta ¿ESTE ELEMENTO PODRÁ SER REINGRESADO POSTERIORMENTE?");
  }else if((banderaBetadoAsistencia=="0" || banderaBetadoAsistencia==0) && ComentarioBetadoAsistencia==""){
     mensajeErrorModalBaja1("error","Indique el motivo por el cual el elemento será vetado del Corporativo Gif Seguridad Privada");
  }else if(PeticionesCapacitacionBaja != "0"){
     mensajeErrorModalBaja1("error","No Es Posible Registra, Debido A Que Ya Existe Un Registro De Capacitacion En Este Dia Con Este Empleado, Favor De Borrar El Registro Si Se Requiere Registrar Uno Diferente");
  }else{

    $.ajax({
      type: "POST",
      url: "ajax_RegistrarDatosDocumentosBaja.php",
      data: {"banderaBetadoAsistencia":banderaBetadoAsistencia,"ComentarioBetadoAsistencia":ComentarioBetadoAsistencia,"MotivoBaja":MotivoBaja,"especifiqueMotivo1":especifiqueMotivo1,"numempleadoFirmahidden":numempleadoFirmahidden,"FirmaInterna":FirmaInterna,"asistenciaFecha":asistenciaFecha,"FechaBajaEmpModal":FechaBajaEmpModal,"empleadoEntidadId":empleadoEntidadId,"empleadoConsecutivoId":empleadoConsecutivoId,"empleadoTipoId":empleadoTipoId,"idPlantillaServicio":idPlantillaServicio},
      dataType: "json",
      success: function(response) {
        mensajeErrorModalBaja1(response.status,response.message);
        if (response.status=="success") {
          $("#modalBajaEmpelado").modal("hide");
            reigstrarBajaEmpleado();
        }      
      },error: function(jqXHR, textStatus, errorThrown){
          alert(jqXHR.responseText);
      }
    });

  } 
  }

  function reigstrarBajaEmpleado(){
    var asistenciaFecha = $("#FechaBajaSolicitadaEmp").val();
    var empleadoEntidadId = $("#empleadoEntidadIdHiddenBajaEmp").val();
    var empleadoConsecutivoId = $("#empleadoConsecutivoIdHiddenBajaEmp").val();
    var empleadoTipoId = $("#empleadoTipoIdHiddenBajaEmp").val();
    var empleadoPuntoServicioId = $("#empleadoPuntoServicioIdHiddenBajaEmp").val();
    var supervisorEntidadId = $("#supervisorEntidadIdHiddenBajaEmp").val();
    var supervisorConsecutivoId = $("#supervisorConsecutivoIdHiddenBajaEmp").val();
    var supervisorTipoId = $("#supervisorTipoIdHiddenBajaEmp").val();
    var incidenciaId = $("#incidenciaIdHiddenBajaEmp").val();
    var comentariIncidencia = $("#comentariIncidenciaHiddenBajaEmp").val();
    var tipoPeriodo = $("#tipoPeriodoHiddenBajaEmp").val();
    var puestoCubiertoId = $("#puestoCubiertoIdHiddenBajaEmp").val();
    var idCliente = $("#idClienteHiddenBajaEmp").val();
    var valordia = $("#valordiaHiddenBajaEmp").val();
    var plantilladeservicio1 = $("#plantilladeservicioHiddenBajaEmp").val();
    var plantilladeservicio2 = plantilladeservicio1.split ("_");
    var plantilladeservicio = plantilladeservicio2[0];
    var idPlantillaServicio = plantilladeservicio2[1];
    var nomenclaturaIncidencia = $("#nomenclaturaIncidenciaHiddenBajaEmp").val();
    var busqueda = $("#busquedaHiddenBajaEmp").val();
    $.ajax ({            
          type: "POST",
          url: "ajax_registrarAsistencia.php",
          data: {empleadoEntidadId:empleadoEntidadId, empleadoConsecutivoId: empleadoConsecutivoId, empleadoTipoId:empleadoTipoId, empleadoPuntoServicioId: empleadoPuntoServicioId, supervisorEntidadId:supervisorEntidadId, supervisorConsecutivoId: supervisorConsecutivoId, supervisorTipoId, supervisorTipoId, incidenciaId:incidenciaId, asistenciaFecha:asistenciaFecha, comentariIncidencia:comentariIncidencia, tipoPeriodo:tipoPeriodo, puestoCubiertoId:puestoCubiertoId, idCliente:idCliente, valordia: valordia,plantilladeservicio,"idPlantillaServicio":idPlantillaServicio},
          dataType: "json",
          async:false,
          success: function (response) {
            if (response.status == "error")
            {
              var mensaje=response.message;                    
              valordia=0;
              mostrarModalError(mensaje,'');
            }else if(response.status=="errorRegistro"){                    
              valordia=0;
              alert (response.message);
            }else if(response.status=="errorCobertura"){
              var mensaje=response.message;
              var puestosCobertura=response.puestosCobertura;                  
              valordia=0;
              mostrarModalError(mensaje,puestosCobertura);
            }else
            {
              id = $("#idCell").val ();
              $("#" + id).html (nomenclaturaIncidencia);
              var style = styles [nomenclaturaIncidencia];
              $("#td_"+id).attr("style",style);       
              $("#" + id).attr ("incidenciaAsistenciaId", incidenciaId);
              $("#" + id).attr ("incidenciaText",  nomenclaturaIncidencia);
              UpdateRegistroPeticionMerma(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,asistenciaFecha,valordia);                    
              valordia=0;
              if (response.asistencia != null)
              {
                for (var k in response.asistencia)
                {
                  fecha = k;
                  id = empleadoEntidadId + "-" + empleadoConsecutivoId + "-" + empleadoTipoId + empleadoPuntoServicioId + fecha;
                  nomenclaturaIncidencia = response.asistencia[k].nomenclaturaIncidencia;
                  incidenciaId = response.asistencia[k].incidenciaAsistenciaId;
                  $("#" + id).html (nomenclaturaIncidencia);
                  var style = styles [nomenclaturaIncidencia];
                  $("#td_"+id).attr("style",style);           
                  $("#" + id).attr ("incidenciaAsistenciaId", incidenciaId);
                  $("#" + id).attr ("incidenciaText",  nomenclaturaIncidencia); 
                }
              }
              // if(busqueda=="puntoServicio"){
              //   tableEmpleadosByPeriodoSupervisor ();
              // }else if (busqueda=="numeroEmpleado"){
              //   consultaEmpleadoByIdByUser();
              // }else if(busqueda="nombreEmpleado"){
              //   consultaEmpleadoByNameByUser();
              // }
              generarTablaPeriodo123();
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            valordia=0;
          alert(jqXHR.responseText);
          }
        });
  }


function puntosServiciosBySupervisor()
{
  var supervisorId='';
  <?php
  if($usuario["rol"] =="Analista Asistencia" || $usuario["rol"] =="Facturacion"):
    ?>
    supervisorId=$("#selectSupervisor").val();
    <?php
  endif;
  ?>

  $.ajax({
    type: "POST",
    url: "ajax_getPuntosBySupervisor.php",
    data: {"supervisorId":supervisorId},
    dataType: "json",
    success: function(response) {
      //console.log("consoleencargaselector");
     // console.log(response);
     if (response.status == "success")
     {
      var puntos = response.puntos;

      puntosOptions = "<option>PUNTOS DE SERVICIOS</option>";

      puntosOptions2 = "<option>PUNTOS DE SERVICIOS</option>";
      for (var i = 0; i < puntos.length; i++)
      {   
        valorCobraDiaFestivo=puntos[i].cobraDiaFestivo;
        valorCobra31=puntos[i].cobra31;
        idCliente=puntos[i].idClientePunto;
        idLineaNegocioPunto=puntos[i].idLineaNegocioPunto;

        puntosOptions += "<option id='op_"+puntos[i].puntoServicioId+"' value='" + puntos[i].puntoServicioId + "' cobraDescansos='"+ puntos[i].cobraDescansos +"' cobraDiaFestivo='"+valorCobraDiaFestivo+"' valorCobra31='"+valorCobra31+"' idCliente='"+idCliente+"'  lineanegociopunto='"+idLineaNegocioPunto+"'>" + puntos[i].puntoServicio + "</option>";
        puntosOptions2 += "<option id='opi_"+puntos[i].puntoServicioId+"' value='" + puntos[i].puntoServicioId + "' cobraDescansos='"+ puntos[i].cobraDescansos +"' cobraDiaFestivo='"+valorCobraDiaFestivo+"' valorCobra31='"+valorCobra31+"' idCliente='"+idCliente+"'   lineanegociopunto='"+idLineaNegocioPunto+"'  >" + puntos[i].puntoServicio + "</option>";
      }

      $("#puntoServicioSupervisor").html (puntosOptions);
      <?php
      if($usuario["rol"] =="Supervisor"):
        ?>
        $("#selectPuntoServicioAsistencia").html(puntosOptions);
        $("#selectPuntoIncidencia").html(puntosOptions2);
        $("#selectPuntoConsulta").html(puntosOptions);
                    //$("#selectPuntoServicioFatiga").html (puntosOptions);


                    var cobraDescanso=$("#selectPuntoServicioFatiga").attr("cobraDescansos");
                    //alert(cobraDescanso);
                    <?php
                  endif;
                  ?>


                }
              },
              error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
              }
            });
}

function puntosServiciosBySupervisorSelectIncidenciasEspeciales()
{
  var supervisorId='';
  <?php
  if($usuario["rol"] =="Analista Asistencia" || $usuario["rol"] =="Facturacion"):
    ?>
    supervisorId=$("#selectSupervisor").val();
    <?php
  endif;
  ?>

  $.ajax({
    type: "POST",
    url: "ajax_getPuntosBySupervisor.php",
    data: {"supervisorId":supervisorId},
    dataType: "json",
    success: function(response) {
      if (response.status == "success")
      {
        var puntos = response.puntos;

        puntosOptions = "<option>PUNTOS DE SERVICIOS</option>";
        for (var i = 0; i < puntos.length; i++)
        {   
          valorCobraDiaFestivo=puntos[i].cobraDiaFestivo;
          valorCobra31=puntos[i].cobra31;
          idCliente=puntos[i].idClientePunto;


          puntosOptions += "<option id='opi_"+puntos[i].puntoServicioId+"' name='opi_"+puntos[i].puntoServicioId+"' value='" + puntos[i].puntoServicioId + "' cobraDescansos='"+ puntos[i].cobraDescansos +"' cobraDiaFestivo='"+valorCobraDiaFestivo+"' valorCobra31='"+valorCobra31+"' idCliente='"+idCliente+"'>" + puntos[i].puntoServicio + "</option>";
        }



        <?php
        if($usuario["rol"] =="Supervisor"){
          ?>


          $("#selectPuntoIncidencia").html(puntosOptions);

          <?php
        }
        ?>

      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
       alert(jqXHR.responseText);
     }
            });
}

function puntosServiciosAnalista()
{



 $.ajax({
  type: "POST",
  url: "ajax_getPuntosByAnalista.php",
  dataType: "json",
  success: function(response) {
    if (response.status == "success")
    {
      var puntos = response.puntos;

      var puntosOptions = "<option>PUNTOS DE SERVICIOS</option>";
      var puntosOptions2 = "<option>PUNTOS DE SERVICIOS</option>";

      for (var i = 0; i < puntos.length; i++)
      {

        valorCobraDescanso=puntos[i].cobraDescansos;
        valorCobraDiaFestivo=puntos[i].cobraDiaFestivo;
        valorCobra31=puntos[i].cobra31;
        idCliente=puntos[i].idClientePunto;
        idLineaNegocioPunto=puntos[i].idLineaNegocioPunto;

        puntosOptions += "<option id='op_"+puntos[i].idPuntoServicio+"' value='" + puntos[i].idPuntoServicio + "'  cobraDescansos='"+ valorCobraDescanso +"' cobraDiaFestivo='"+valorCobraDiaFestivo+"' valorCobra31='"+valorCobra31+"' idCliente='"+idCliente+"' lineanegociopunto='"+idLineaNegocioPunto+"'>" + puntos[i].puntoServicio + "</option>";
        puntosOptions2 += "<option id='opi_"+puntos[i].idPuntoServicio+"' value='" + puntos[i].idPuntoServicio + "'  cobraDescansos='"+ valorCobraDescanso +"' cobraDiaFestivo='"+valorCobraDiaFestivo+"' valorCobra31='"+valorCobra31+"' idCliente='"+idCliente+"' lineanegociopunto='"+idLineaNegocioPunto+"'>" + puntos[i].puntoServicio + "</option>";
                        //alert(puntosOptions);
                      }

                      <?php
                      if($usuario["rol"] =="Analista Asistencia" || $usuario["rol"] =="Facturacion" ):
                        ?>

                        $("#selectPuntoServicioAsistencia").html (puntosOptions);
                        $("#selectPuntoIncidencia").html(puntosOptions2);
                        $("#selectPuntoConsulta").html(puntosOptions);
                    //$("#selectPuntoServicioFatiga").html(puntosOptions);
                    
                    
                    <?php
                  endif;
                  ?>
                }
              },
             error: function(jqXHR, textStatus, errorThrown) {
       alert(jqXHR.responseText);
     }
         });
}
function tableEmpleadosByPeriodoSupervisor()
{
  var supervisorId='';
  <?php
  if($usuario["rol"] =="Analista Asistencia"):
    ?>
    supervisorId=$("#selectSupervisor").val();
    <?php
  endif;
  ?>
  var puntoServicio=$("#puntoServicioSupervisor").val();  
  $("#tableEmpleadosAsistencia1").find("tr:gt(0)").remove();
  //alert(puntoServicio);
  ConsultaIdClientePorPunto(puntoServicio);

  $.ajax({

    type: "POST",
    url: "ajax_getEmpleadosBySupervisor_Periodo_PuntoServicio.php",
    data : {"fecha1":fecha1, "fecha2":fecha2, "periodoId":periodoId, "puntoServicio":puntoServicio, "supervisorId":supervisorId },
    dataType: "json",
    success: function(response) {
     // console.log(response);
     if (response.status == "success")
     {
      var empleadoEncontrado = response.listaEmpleados;


      for ( var i = 0; i < empleadoEncontrado.length; i++ ){
        var numeroEmpleado = empleadoEncontrado[i].numeroEmpleado;
        var nombreEmpleado = empleadoEncontrado[i].nombreEmpleado;
        var descripcionPuesto = empleadoEncontrado[i].descripcionPuesto;
        var descripcionTurno=empleadoEncontrado[i].descripcionTurno;
        var puntoServicio=empleadoEncontrado[i].puntoServicio;
        var empleadoIdPuntoServicio=empleadoEncontrado[i].empleadoIdPuntoServicio;
        var empleadoIdPuesto=empleadoEncontrado[i].empleadoIdPuesto;
        var asistencia = empleadoEncontrado[i].asistencia;
        var sumaTurnosExtras=empleadoEncontrado[i].turnosExtras.sumaTurnosExtras;
        var descuentos=empleadoEncontrado[i].descuentos.descuentos;
        var incidenciasEspeciales=empleadoEncontrado[i].incidenciasEspeciales.incidenciasEspeciales;
        var cliente=empleadoEncontrado[i].nombreComercial;
        var supervisorId = empleadoEncontrado[i].supervisorId;
        var sumaDiasFestivos=empleadoEncontrado[i].diasFestivos.diasFestivos;
        var rioloperativo=empleadoEncontrado[i].roloperativo;
        var idlineanegocioPunto=empleadoEncontrado[i].idLineaNegocioPunto;
        var idClientePunto=empleadoEncontrado[i].idClientePunto;
        var visiblerh=empleadoEncontrado[i].visiblerh;
        var IdPlantillaServ=empleadoEncontrado[i].IdPlantillaServ;

        if(rioloperativo==null || rioloperativo=="" ){
          rioloperativo="No asignado";
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

        if(sumaDiasFestivos==null){
          sumaDiasFestivos=0;
        }

    

        var result="<tr><td width='80px'>"+numeroEmpleado+"</td><td width='160px'>"+nombreEmpleado+"</td><td width='100px'>"+descripcionPuesto+"</td><td width='80px'>"+descripcionTurno+"</td><td width='80px'>"+rioloperativo+"</td>";
        result+="<td width='140px'>"+puntoServicio+"</td><td width='100px'>"+cliente+"</td>" + crearCeldasParaPaseAsistencia(numeroEmpleado, nombreEmpleado, asistencia, empleadoIdPuntoServicio, supervisorId, empleadoIdPuesto,rioloperativo,idlineanegocioPunto,IdPlantillaServ) +"";
        result +="<td width='20px' id='td_te_"+numeroEmpleado+"' name='td_te_"+numeroEmpleado+"' sumaTurnosExtras='"+sumaTurnosExtras+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fecha1='"+fecha1+"' fecha2='"+fecha2+"' tdTipo='turnosExtras'>"+ sumaTurnosExtras +"</td>";
        result += "<td width='20px' id='td_df_"+numeroEmpleado+"' name='td_df_"+numeroEmpleado+"' sumaDiasFestivos='"+sumaDiasFestivos+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fecha1='"+fecha1+"' fecha2='"+fecha2+"' tdTipo='diasFestivos'>"+ sumaDiasFestivos +"</td>";
        result+="<td width='30px' id='td_des_"+numeroEmpleado+"' class='tooltipster_item' name='td_des_"+numeroEmpleado+"' descuentos='"+descuentos+"' numeroEmpleado='"+numeroEmpleado+"' fecha1='"+fecha1+"' fecha2='"+fecha2+"' tdTipo='descuentos'>"+ descuentos+"</td>";
        result+= "<td width='20px' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fecha1='"+fecha1+"' fecha2='"+fecha2+"' tdTipo='incidenciasEspeciales'>"+ incidenciasEspeciales +"</td>";
        result += "<td name='td_tt_"+ numeroEmpleado+"' id='td_tt_"+numeroEmpleado+"'><div id='divTotal_"+numeroEmpleado+"' id='divTotal_"+numeroEmpleado+"'></div></td></tr>"

        $('#tableEmpleadosAsistencia1').append(result);


        var tQuicena=$("#td_tq_"+numeroEmpleado).attr("sumaTurnosPeriodo");
        var tExtras=$("#td_te_"+numeroEmpleado).attr("sumaTurnosExtras");
        var tDescuentos=$("#td_des_"+numeroEmpleado).attr("descuentos");
        var tDiasFestivos=$("#td_df_"+numeroEmpleado).attr("sumaDiasFestivos");

        var turnosTotales= parseInt(tQuicena) + parseInt(tExtras) + parseInt(tDiasFestivos) - Math.abs(tDescuentos);
        $("#divTotal_"+numeroEmpleado).html(turnosTotales);

      }  
      obtenerTurnosPresupuestados(IdPlantillaServ);

      loadContextMenu ();
      tooltipAjax();
      var puntoservsoloparacargarselector=$("#puntoServicioSupervisor").val();  
                    //cargaselectorplantillaenmodalasistenciadeincidencia(puntoservsoloparacargarselector);
                    
                  }
                  else if (response.status == "error" && response.message == "No autorizado")
                  {
                    //
                    window.location = "login.php";
                  }
                },
                error: function(jqXHR, textStatus, errorThrown) {
       alert(jqXHR.responseText);
     }
            });

}


function tableEmpleadosByPeriodoSupervisorName()
{
  var nombre=$("#txtSearchNameAsistencia").val();  
  $("#tableEmpleadosAsistencia1").find("tr:gt(0)").remove();


  $.ajax({

    type: "POST",
    url: "ajax_getEmpleadosBySupervisorPeriodoName.php",
    data : {"fecha1":fecha1, "fecha2":fecha2, "periodoId":periodoId, "nombre":nombre },
    dataType: "json",
    success: function(response) {
      if (response.status == "success")
      {

        var empleadoEncontrado = response.listaEmpleados;

        for ( var i = 0; i < empleadoEncontrado.length; i++ ){
          var numeroEmpleado = empleadoEncontrado[i].numeroEmpleado;
          var nombreEmpleado = empleadoEncontrado[i].nombreEmpleado;
          var descripcionPuesto = empleadoEncontrado[i].descripcionPuesto;
          var descripcionTurno=empleadoEncontrado[i].descripcionTurno;
          var puntoServicio=empleadoEncontrado[i].puntoServicio;
          var empleadoIdPuntoServicio=empleadoEncontrado[i].empleadoIdPuntoServicio;
          var empleadoIdPuesto=empleadoEncontrado[i].empleadoIdPuesto;
          var asistencia = empleadoEncontrado[i].asistencia;
          var sumaTurnosExtras=empleadoEncontrado[i].turnosExtras.sumaTurnosExtras;
          var descuentos=empleadoEncontrado[i].descuentos.descuentos;
          var incidenciasEspeciales=empleadoEncontrado[i].incidenciasEspeciales.incidenciasEspeciales;
          var cliente=empleadoEncontrado[i].nombreComercial;
          var supervisorId=empleadoEncontrado[i].supervisorId;
          var sumaDiasFestivos=empleadoEncontrado[i].diasFestivos.diasFestivos;
          var roloperativo=empleadoEncontrado[i].roloperativo;
          var idlineanegocioPunto=empleadoEncontrado[i].idLineaNegocioPunto;
          var idClientePunto=empleadoEncontrado[i].idClientePunto;
          var IdPlantillaServ=empleadoEncontrado[i].requisicionId;
          var visiblerh=empleadoEncontrado[i].visiblerh;

          if(roloperativo==null || roloperativo==""){
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

          $('#tableEmpleadosAsistencia1').append(
            "<tr><td width='80px'>"+numeroEmpleado+"</td><td width='160px'>"+nombreEmpleado+"</td><td width='100px'>"+descripcionPuesto+"</td><td width='80px'>"+descripcionTurno+"</td><td width='80px'>"+roloperativo+"</td><td width='140px'>"+puntoServicio+"</td><td width='100'>"+cliente+"</td>" + crearCeldasParaPaseAsistencia(numeroEmpleado, nombreEmpleado, asistencia, empleadoIdPuntoServicio, supervisorId, empleadoIdPuesto,roloperativo,idlineanegocioPunto,IdPlantillaServ) +"<td width='20px' id='td_te_"+numeroEmpleado+"' name='td_te_"+numeroEmpleado+"' sumaTurnosExtras='"+sumaTurnosExtras+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fecha1='"+fecha1+"' fecha2='"+fecha2+"' tdTipo='turnosExtras'>"+ sumaTurnosExtras +"</td><td width='20px' id='td_df_"+numeroEmpleado+"' name='td_df_"+numeroEmpleado+"' sumaDiasFestivos='"+sumaDiasFestivos+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fecha1='"+fecha1+"' fecha2='"+fecha2+"' tdTipo='diasFestivos'>"+ sumaDiasFestivos +"</td><td width='30px' id='td_des_"+numeroEmpleado+"' name='td_des_"+numeroEmpleado+"' descuentos='"+descuentos+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fecha1='"+fecha1+"' fecha2='"+fecha2+"' tdTipo='descuentos'>"+ descuentos+"</td><td width='20px' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fecha1='"+fecha1+"' fecha2='"+fecha2+"' tdTipo='incidenciasEspeciales'>"+ incidenciasEspeciales +"</td><td name='td_tt_"+ numeroEmpleado+"' id='td_tt_"+numeroEmpleado+"'><div id='divTotal_"+numeroEmpleado+"' id='divTotal_"+numeroEmpleado+"'></div></td></tr>");

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
                error: function(jqXHR, textStatus, errorThrown) {
       alert(jqXHR.responseText);
     }
            });


}

function tableEmpleadosByPeriodorName()
{
  var nombre=$("#txtSearchNameAsistencia").val();  
  $("#tableEmpleadosAsistencia1").find("tr:gt(0)").remove();


  $.ajax({

    type: "POST",
    url: "ajax_getListaEmpleadosByPeriodoNombre.php",
    data : {"fecha1":fecha1, "fecha2":fecha2, "periodoId":periodoId, "nombre":nombre },
    dataType: "json",
    success: function(response) {

      console.log(response);
      if (response.status == "success")
      {

        var empleadoEncontrado = response.listaEmpleados;

        for ( var i = 0; i < empleadoEncontrado.length; i++ ){
          var numeroEmpleado = empleadoEncontrado[i].numeroEmpleado;
          var nombreEmpleado = empleadoEncontrado[i].nombreEmpleado;
          var descripcionPuesto = empleadoEncontrado[i].descripcionPuesto;
          var descripcionTurno=empleadoEncontrado[i].descripcionTurno;
          var puntoServicio=empleadoEncontrado[i].puntoServicio;
          var empleadoIdPuntoServicio=empleadoEncontrado[i].empleadoIdPuntoServicio;
          var empleadoIdPuesto=empleadoEncontrado[i].empleadoIdPuesto;
          var asistencia = empleadoEncontrado[i].asistencia;
          var sumaTurnosExtras=empleadoEncontrado[i].turnosExtras.sumaTurnosExtras;
          var descuentos=empleadoEncontrado[i].descuentos.descuentos;
          var incidenciasEspeciales=empleadoEncontrado[i].incidenciasEspeciales.incidenciasEspeciales;
          var cliente = empleadoEncontrado[i].nombreComercial;
          var supervisorId=empleadoEncontrado[i].supervisorId;
          var sumaDiasFestivos=empleadoEncontrado[i].diasFestivos.diasFestivos;
          var roloperativo=empleadoEncontrado[i].roloperativo;
          var idlineanegocioPunto=empleadoEncontrado[i].idLineaNegocioPunto;
          var idClientePunto=empleadoEncontrado[i].idClientePunto;
          var IdPlantillaServ=empleadoEncontrado[i].requisicionId;
          var visiblerh=empleadoEncontrado[i].visiblerh;
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

          $('#tableEmpleadosAsistencia1').append(
            "<tr><td width='80px'>"+numeroEmpleado+"</td><td width='160px'>"+nombreEmpleado+"</td><td width='100px'>"+descripcionPuesto+"</td><td width='80px'>"+descripcionTurno+"</td><td width='80px'>"+roloperativo+"</td><td width='140px'>"+puntoServicio+"</td><td width='100px'>"+cliente+"</td>" + crearCeldasParaPaseAsistencia(numeroEmpleado, nombreEmpleado, asistencia, empleadoIdPuntoServicio, supervisorId, empleadoIdPuesto,roloperativo,idlineanegocioPunto,IdPlantillaServ) +"<td width='20px' id='td_te_"+numeroEmpleado+"' name='td_te_"+numeroEmpleado+"' sumaTurnosExtras='"+sumaTurnosExtras+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fecha1='"+fecha1+"' fecha2='"+fecha2+"' tdTipo='turnosExtras'>"+ sumaTurnosExtras +"</td><td width='20px' id='td_df_"+numeroEmpleado+"' name='td_df_"+numeroEmpleado+"' sumaDiasFestivos='"+sumaDiasFestivos+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fecha1='"+fecha1+"' fecha2='"+fecha2+"' tdTipo='diasFestivos'>"+ sumaDiasFestivos +"</td><td width='30px' id='td_des_"+numeroEmpleado+"' name='td_des_"+numeroEmpleado+"' descuentos='"+descuentos+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fecha1='"+fecha1+"' fecha2='"+fecha2+"' tdTipo='descuentos'>"+ descuentos+"</td><td width='20px' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fecha1='"+fecha1+"' fecha2='"+fecha2+"' tdTipo='incidenciasEspeciales'>"+ incidenciasEspeciales +"</td><td name='td_tt_"+ numeroEmpleado+"' id='td_tt_"+numeroEmpleado+"'><div id='divTotal_"+numeroEmpleado+"' id='divTotal_"+numeroEmpleado+"'></div></td></tr>");

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
                error: function(jqXHR, textStatus, errorThrown) {
       alert(jqXHR.responseText);
     }
           });


}

$('#txtSearchNumeroEmpleadoAsistencia').keypress(function(event){  
 var keycode = (event.keyCode ? event.keyCode : event.which);  
 if(keycode == '13'){  
           //alert('Se ha presionado Enter!');  
           //tableEmpleadosByPeriodoSupervisorName();
           $("#txtSearchName").val("");

           $("#puntoServicioSupervisor").val("PUNTOS DE SERVICIOS");
           consultaEmpleadoByIdByUser();

         }   
       });



function getAsistenciaByEmpleadoIdFecha(numeroEmpleado,fechaAsistencia)
{

  resultAsistencia="";

  $.ajax({
    type: "POST",
    url: "ajax_getAsistenciaByEmpleadoIdFecha.php",
    data : {"fechaAsistencia":fechaAsistencia,"empleadoId":numeroEmpleado },
    dataType: "json",
    success: function(response) {
      if (response.status == "success")
      {

        var asistencia = response.asistencia;

        for ( var i = 0; i < asistencia.length; i++ ){
          var descripcionIncidencia = asistencia[i].descripcionIncidencia;

          resultAsistencia=descripcionIncidencia;
          return resultAsistencia;
        }   
                  }
                },
               error: function(jqXHR, textStatus, errorThrown) {
       alert(jqXHR.responseText);
     }
            });
}

/*
function generarTablaPeriodo(){  
  $('#divTableEmpleadosAsistencia').html(""); 
  $('#tableEmpleadosAsistencia1').html(""); 
  $('#tableEmpleadosAsistencia1').empty(); 
  $("#tableEmpleadosAsistencia1").find("tr:gt(0)").remove();
  <?php $diasAsistencia11 = ""; ?>
  fechasAsistencia123 = [];
  a = [];
  fecha1="";
  fecha2="";
  var tableEmpleadosAsistencia ="";
  var tipoPeriodo = $('input:radio[name=optionPeriodo]:checked').val();
  alert(tipoPeriodo);
  if (tipoPeriodo=="QUINCENAL"){
    periodoId="1";

    <?php
      $diasAsistencia11= $negocio -> obtenerListaDiasParaAsistencia ("QUINCENAL");
      $diasAsistencia22=$diasAsistencia11;
      foreach ($diasAsistencia22 as $dia22): 
      echo "a.push ('" . $dia22["fecha"] ."-" . $dia22["leyenda"] . "-" . $dia22["dia"] . "');\n" 
    ?>
  <?php endforeach; ?>
    <?php foreach ($diasAsistencia11 as $dia1): ?>
    <?php echo "fechasAsistencia123.push ('" . $dia1["fecha"] . "');\n" ?>
    <?php endforeach; ?>

    console.log(fechasAsistencia123);
    console.log(a);

    fecha1 = fechasAsistencia123 [0];
    fecha2 = fechasAsistencia123 [fechasAsistencia123.length - 1];
   
    tableEmpleadosAsistencia="<table class='table table-fixedheader table-bordered table-striped' id='tableEmpleadosAsistencia1' name='tableEmpleadosAsistencia1'><thead><tr><th  width='80px'>#Empleado</th><th width='160px'>Nombre Empleado</th>";
    tableEmpleadosAsistencia += "<th width='100px'>Puesto</th><th width='80px'>Turno</th><th width='80px'>Plantilla servicio</th><th width='140px'>Punto Servicio</th><th width='100px'>Cliente</th> <?php foreach ($diasAsistencia11 as $dia1): ?> <th width='40px'><?php echo $dia1["dia"]; ?> <?php endforeach; ?></th>";
    tableEmpleadosAsistencia +="<th>T.Q</th><th>T.E</th><th>D.F</th><th>Des.</th><th>I.E</th><th>TOTAL</th></tr></thead><tbody></tbody></table>";
    $('#divTableEmpleadosAsistencia').html(tableEmpleadosAsistencia); 
  }else{
    periodoId="2";
    <?php
      $diasAsistencia11= $negocio -> obtenerListaDiasParaAsistencia ("SEMANAL");
    ?>
    <?php
      foreach ($diasAsistencia11 as $dia):?>
        <?php echo "fechasAsistencia123.push ('" . $dia["fecha"] . "');\n" ?><?php
          endforeach;
        ?>
      fecha1 = fechasAsistencia123 [0];
      fecha2 = fechasAsistencia123 [fechasAsistencia123.length - 1];
    tableEmpleadosAsistencia="<table class='table table-fixedheader table-bordered table-striped' id='tableEmpleadosAsistencia1' name='tableEmpleadosAsistencia1'><thead><tr><th  width='80px'>#Empleado</th><th width='160px'>Nombre Empleado</th><th width='100px'>Puesto</th><th width='80px'>Turno</th><th width='80px'>Plantilla servicio</th><th width='140px'>Punto Servicio</th><th width='100px'>Cliente</th> <?php foreach ($diasAsistencia11 as $dia): ?> <th width='40px'><?php echo $dia["dia"]; ?> <?php endforeach; ?></th><th>T.Q</th><th>T.E</th><th>D.F</th><th>DES</th><th>I.E</th><th>TOTAL</th></tr></thead><tbody></tbody></table>";
      $('#divTableEmpleadosAsistencia').html(tableEmpleadosAsistencia);
    }
    alert(busqueda);
    if(busqueda=="puntoServicio"){
      tableEmpleadosByPeriodoSupervisor ();
    }else if (busqueda=="numeroEmpleado"){
      consultaEmpleadoByIdByUser();
    }else if(busqueda=="nombreEmpleado"){
      consultaEmpleadoByNameByUser();
    }else{
      $("#puntoServicioSupervisor").val("PUNTOS DE SERVICIOS");
      $("#txtSearchNameAsistencia").val("");
      $("#txtNumeroEmpleadoAsistencia").val("");
    }
} 
*/
function generarTablaPeriodo123(){  
  $('#divTableEmpleadosAsistencia').html(""); 
  $('#tableEmpleadosAsistencia1').html(""); 
  $('#tableEmpleadosAsistencia1').empty(); 
  $("#tableEmpleadosAsistencia1").find("tr:gt(0)").remove();
  var tableEmpleadosAsistencia ="";
  fechasAsistencia123 = [];
  var tipoPeriodo = $('input:radio[name=optionPeriodo]:checked').val();
  if (tipoPeriodo=="QUINCENAL"){
    periodoId="1";
  }else{
    periodoId="2";
  }
  $.ajax({
    type: "POST",
    url: "ajax_obtenerListaDiasParaAsistencia.php",
    data : {"tipoPeriodo":tipoPeriodo},
    dataType: "json",
    success: function(response) {
      if (response.status == "success")
      {
        var result = response.result;
        console.log(result);
        fecha1 = result [0].fecha;
        fecha2 = result [result.length - 1].fecha;
        tableEmpleadosAsistencia="<table class='table table-fixedheader table-bordered table-striped' id='tableEmpleadosAsistencia1' name='tableEmpleadosAsistencia1'><thead><tr><th  width='80px'>#Empleado</th><th width='160px'>Nombre Empleado</th>";

        tableEmpleadosAsistencia += "<th width='100px'>Puesto</th><th width='80px'>Turno</th><th width='80px'>Plantilla servicio</th><th width='140px'>Punto Servicio</th><th width='100px'>Cliente</th>";
        for ( var i = 0; i < result.length; i++ ){
          var fecha = result [i].fecha;
          fechasAsistencia123.push(fecha);
          var dia = result [i].dia;
          tableEmpleadosAsistencia += "<th width='40px'>"+dia+"</th>";
        }
        console.log(fechasAsistencia123);
        tableEmpleadosAsistencia +="<th>T.Q</th><th>T.E</th><th>D.F</th><th>Des.</th><th>I.E</th><th>TOTAL</th></tr></thead><tbody></tbody></table>";
        $('#divTableEmpleadosAsistencia').html(tableEmpleadosAsistencia); 
      }
    },error: function(jqXHR, textStatus, errorThrown) {
       alert(jqXHR.responseText);
    }
  });
  if(busqueda=="puntoServicio"){
    tableEmpleadosByPeriodoSupervisor ();
  }else if (busqueda=="numeroEmpleado"){
    consultaEmpleadoByIdByUser();
  }else if(busqueda=="nombreEmpleado"){
    consultaEmpleadoByNameByUser();
  }else{
    $("#puntoServicioSupervisor").val("PUNTOS DE SERVICIOS");
    $("#txtSearchNameAsistencia").val("");
    $("#txtNumeroEmpleadoAsistencia").val("");
  }
} 



    function consultaEmpleadoByIdByUser(){

     <?php
     if($usuario["rol"] =="Analista Asistencia"){
      ?>
      tableEmpleadosByIdEmpleado();
      <?php
    }else if($usuario["rol"] =="Supervisor"){
      ?>
      tableEmpleadosByPeriodoSupervisorIdEmpleado();

      <?php
    }
    ?>
  }

  function consultaEmpleadoByNameByUser(){

   <?php
   if($usuario["rol"] =="Analista Asistencia"){
    ?>
    tableEmpleadosByPeriodorName();
    <?php
  }else if($usuario["rol"] =="Supervisor"){
    ?>
    tableEmpleadosByPeriodoSupervisorName();

    <?php
  }
  ?>
}


function tableEmpleadosByPeriodoSupervisorIdEmpleado()
{

  var numeroEmpleado = $("#txtSearchNumeroEmpleadoAsistencia").val ();
  $("#tableEmpleadosAsistencia1").find("tr:gt(0)").remove();


  var elementosNumeroEmpleado = numeroEmpleado.split ("-");

  var empleadoEntidadId = elementosNumeroEmpleado[0];
  var empleadoConsecutivoId = elementosNumeroEmpleado[1];
  var empleadoTipoId = elementosNumeroEmpleado[2];

  $.ajax({

    type: "POST",
    url: "ajax_getEmpleadosBySupervisorPeriodoEmpleadoId.php",
    data : {"fecha1":fecha1, "fecha2":fecha2, "periodoId":periodoId, "empleadoEntidadId":empleadoEntidadId, "empleadoConsecutivoId":empleadoConsecutivoId, "empleadoTipoId":empleadoTipoId },
    dataType: "json",
    success: function(response) {
      if (response.status == "success")
      {

        var empleadoEncontrado = response.listaEmpleados;

        for ( var i = 0; i < empleadoEncontrado.length; i++ ){
          var numeroEmpleado = empleadoEncontrado[i].numeroEmpleado;
          var nombreEmpleado = empleadoEncontrado[i].nombreEmpleado;
          var descripcionPuesto = empleadoEncontrado[i].descripcionPuesto;
          var descripcionTurno=empleadoEncontrado[i].descripcionTurno;
          var puntoServicio=empleadoEncontrado[i].puntoServicio;
          var empleadoIdPuntoServicio=empleadoEncontrado[i].empleadoIdPuntoServicio;
          var empleadoIdPuesto=empleadoEncontrado[i].empleadoIdPuesto;
          var asistencia = empleadoEncontrado[i].asistencia;
          var sumaTurnosExtras=empleadoEncontrado[i].turnosExtras.sumaTurnosExtras;
          var descuentos=empleadoEncontrado[i].descuentos.descuentos;
          var incidenciasEspeciales=empleadoEncontrado[i].incidenciasEspeciales.incidenciasEspeciales;
          var cliente=empleadoEncontrado[i].nombreComercial;
          var supervisorId=empleadoEncontrado[i].supervisorId;
          var sumaDiasFestivos=empleadoEncontrado[i].diasFestivos.diasFestivos;
          var roloperativo=empleadoEncontrado[i].roloperativo;
          var idlineanegocioPunto=empleadoEncontrado[i].idLineaNegocioPunto;
          var idClientePunto=empleadoEncontrado[i].idClientePunto;
          var IdPlantillaServ=empleadoEncontrado[i].requisicionId;
          var visiblerh=empleadoEncontrado[i].visiblerh;
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

          $('#tableEmpleadosAsistencia1').append(
            "<tr><td width='80px'>"+numeroEmpleado+"</td><td width='160px'>"+nombreEmpleado+"</td><td width='100px'>"+descripcionPuesto+"</td><td width='80px'>"+descripcionTurno+"</td>  <td width='80px'>"+roloperativo+"</td><td width='140px'>"+puntoServicio+"</td><td width='100px'>"+cliente+"</td>" + crearCeldasParaPaseAsistencia(numeroEmpleado, nombreEmpleado, asistencia, empleadoIdPuntoServicio, supervisorId, empleadoIdPuesto,roloperativo,idlineanegocioPunto,IdPlantillaServ)+"<td width='20px' id='td_te_"+numeroEmpleado+"' name='td_te_"+numeroEmpleado+"' sumaTurnosExtras='"+sumaTurnosExtras+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fecha1='"+fecha1+"' fecha2='"+fecha2+"' tdTipo='turnosExtras'>"+ sumaTurnosExtras +"</td><td width='20px' id='td_df_"+numeroEmpleado+"' name='td_df_"+numeroEmpleado+"' sumaDiasFestivos='"+sumaDiasFestivos+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fecha1='"+fecha1+"' fecha2='"+fecha2+"' tdTipo='diasFestivos'>"+ sumaDiasFestivos +"</td><td width='30px' id='td_des_"+numeroEmpleado+"' name='td_des_"+numeroEmpleado+"' descuentos='"+descuentos+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fecha1='"+fecha1+"' fecha2='"+fecha2+"' tdTipo='descuentos'>"+ descuentos+"</td><td width='20px' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fecha1='"+fecha1+"' fecha2='"+fecha2+"' tdTipo='incidenciasEspeciales'>"+ incidenciasEspeciales +"</td><td name='td_tt_"+ numeroEmpleado+"' id='td_tt_"+numeroEmpleado+"'><div id='divTotal_"+numeroEmpleado+"' id='divTotal_"+numeroEmpleado+"'></div></td></tr>");

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
                error: function(jqXHR, textStatus, errorThrown) {
       alert(jqXHR.responseText);
     }
            });


}

function tableEmpleadosByIdEmpleado()
{

  var numeroEmpleado = $("#txtSearchNumeroEmpleadoAsistencia").val ();
  $("#tableEmpleadosAsistencia1").find("tr:gt(0)").remove();


  var elementosNumeroEmpleado = numeroEmpleado.split ("-");

  var empleadoEntidadId = elementosNumeroEmpleado[0];
  var empleadoConsecutivoId = elementosNumeroEmpleado[1];
  var empleadoTipoId = elementosNumeroEmpleado[2];

  $.ajax({

    type: "POST",
    url: "ajax_consultaEmpleadoIdPeriodo.php",
    data : {"fecha1":fecha1, "fecha2":fecha2, "periodoId":periodoId, "empleadoEntidadId":empleadoEntidadId, "empleadoConsecutivoId":empleadoConsecutivoId, "empleadoTipoId":empleadoTipoId },
    dataType: "json",
    success: function(response) {
      if (response.status == "success")
      {
        var empleadoEncontrado = response.listaEmpleados;

        for ( var i = 0; i < empleadoEncontrado.length; i++ ){
          var numeroEmpleado = empleadoEncontrado[i].numeroEmpleado;
          var nombreEmpleado = empleadoEncontrado[i].nombreEmpleado;
          var descripcionPuesto = empleadoEncontrado[i].descripcionPuesto;
          var descripcionTurno=empleadoEncontrado[i].descripcionTurno;
          var puntoServicio=empleadoEncontrado[i].puntoServicio;
          var empleadoIdPuntoServicio=empleadoEncontrado[i].empleadoIdPuntoServicio;
          var empleadoIdPuesto=empleadoEncontrado[i].empleadoIdPuesto;
          var asistencia = empleadoEncontrado[i].asistencia;
          var sumaTurnosExtras=empleadoEncontrado[i].turnosExtras.sumaTurnosExtras;
          var descuentos=empleadoEncontrado[i].descuentos.descuentos;
          var incidenciasEspeciales=empleadoEncontrado[i].incidenciasEspeciales.incidenciasEspeciales;
          var cliente = empleadoEncontrado[i].nombreComercial;
          var supervisorId=empleadoEncontrado[i].supervisorId;
          var sumaDiasFestivos=empleadoEncontrado[i].diasFestivos.diasFestivos;
          var roloperativo=empleadoEncontrado[i].roloperativo;
          var idlineanegocioPunto=empleadoEncontrado[i].idLineaNegocioPunto;
          var folioincapacidad=empleadoEncontrado[i].folioIncapacidad;
          var idClientePunto=empleadoEncontrado[i].idClientePunto;
          var IdPlantillaServ=empleadoEncontrado[i].requisicionId;
          var visiblerh=empleadoEncontrado[i].visiblerh;
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

          $('#tableEmpleadosAsistencia1').append(
            "<tr><td width='80px'>"+numeroEmpleado+"</td><td width='160px'>"+nombreEmpleado+"</td><td width='100px'>"+descripcionPuesto+"</td><td width='80px'>"+descripcionTurno+"</td><td width='80px'>"+roloperativo+"</td><td width='140px'>"+puntoServicio+"</td><td width='100px'>"+cliente+"</td>" + crearCeldasParaPaseAsistencia(numeroEmpleado, nombreEmpleado, asistencia, empleadoIdPuntoServicio,supervisorId,empleadoIdPuesto,roloperativo,idlineanegocioPunto,IdPlantillaServ)+"<td width='20px' id='td_te_"+numeroEmpleado+"' name='td_te_"+numeroEmpleado+"' sumaTurnosExtras='"+sumaTurnosExtras+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fecha1='"+fecha1+"' fecha2='"+fecha2+"' tdTipo='turnosExtras'>"+ sumaTurnosExtras +"</td><td width='20px' id='td_df_"+numeroEmpleado+"' name='td_df_"+numeroEmpleado+"' sumaDiasFestivos='"+sumaDiasFestivos+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fecha1='"+fecha1+"' fecha2='"+fecha2+"' tdTipo='diasFestivos'>"+ sumaDiasFestivos +"</td><td width='30px' id='td_des_"+numeroEmpleado+"' name='td_des_"+numeroEmpleado+"' descuentos='"+descuentos+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fecha1='"+fecha1+"' fecha2='"+fecha2+"' tdTipo='descuentos'>"+ descuentos+"</td><td width='20px' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fecha1='"+fecha1+"' fecha2='"+fecha2+"' tdTipo='incidenciasEspeciales'>"+ incidenciasEspeciales +"</td><td name='td_tt_"+ numeroEmpleado+"' id='td_tt_"+numeroEmpleado+"'><div id='divTotal_"+numeroEmpleado+"' id='divTotal_"+numeroEmpleado+"'></div></td></tr>");

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
               error: function(jqXHR, textStatus, errorThrown) {
       alert(jqXHR.responseText);
     }
            });


}

function obtenerTurnosPresupuestados(IdPlantillaServ){
  var idPuntoServicio=$("#puntoServicioSupervisor").val();

  $.ajax({

    type: "POST",
    url: "ajax_generarResumenAsistencia.php",
    data: {"puntoServicioId": idPuntoServicio
    , "IdPlantillaServ": IdPlantillaServ
    , "fechaInicial": fechasAsistencia123[0]
    , "fechaFinal": fechasAsistencia123[fechasAsistencia123.length - 1] },
    dataType: "json",
    async:false,
    success: function(response) {
      if (response.status == "success")
      {

        turnosPresupuestados = response.result;
        var resumen = crearResumenDeTurnos ();
        $('#tableEmpleadosAsistencia1 tr:last').after(resumen);
      }
    },           
    error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText); }
  });
}


$('#txtSearchNameAsistencia').keypress(function(event){  
 var keycode = (event.keyCode ? event.keyCode : event.which);  
 if(keycode == '13'){  
           //alert('Se ha presionado Enter!');  
           //tableEmpleadosByPeriodoSupervisorName();
           consultaEmpleadoByNameByUser();
           //$("#txtSearchNameAsistencia").val("");
           $("#puntoServicioSupervisor").val("PUNTOS DE SERVICIOS");
           $("#txtSearchNumeroEmpleadoAsistencia").val("");
           

         }   
       }); 

$('#myModalAsistencia').on('hidden.bs.modal', function () {

  $("a").removeClass("elementoActivo");

});





function deleteAsistencia (idEmpleado,fechaAsistencia, puntoServicio, incidenciaId, incidenciaText, nomenclaturaIncidencia,folioincapacidad)
{

  var numeroEmpleado = idEmpleado;
  var asistenciaFecha = fechaAsistencia;

  var elementosNumeroEmpleado = numeroEmpleado.split ("-");

  var empleadoEntidadId = elementosNumeroEmpleado[0];
  var empleadoConsecutivoId = elementosNumeroEmpleado[1];
  var empleadoTipoId = elementosNumeroEmpleado[2];

  var empleadoPuntoServicioId =puntoServicio;
  var comentariIncidencia="";
  var tipoPeriodo = $('input:radio[name=optionPeriodo]:checked').val();
  var valordia1 = "borrar";


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
        UpdateRegistroPeticionMerma(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,asistenciaFecha,valordia1);
        var EstatusCapBorrar = "4"; 
        ActualizarEstatusPeticionCapacitacion(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,asistenciaFecha,EstatusCapBorrar)

        generarTablaPeriodo123();

      }
    },
    error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText); 
                  //alert("Error funcion")
                }
              });



}


function registrarIncidenciaEspecial ()
{
  var selectPuntoIncidencia = $("#selectPuntoIncidencia").val();
  ConsultaIdClientePorPunto(selectPuntoIncidencia);
  var numeroEmpleado = $("#txtNumeroEmpleadoIncidencia").val();
  var asistenciaFecha =$("#txtFechaIncidencia").val();

  var elementosNumeroEmpleado = numeroEmpleado.split("-");//09-10050-03   [{09},{10050,{03}]

  var empleadoEntidadId = elementosNumeroEmpleado[0];
  var empleadoConsecutivoId = elementosNumeroEmpleado[1];
  var empleadoTipoId = elementosNumeroEmpleado[2];

  var empleadoPuntoServicioId = $("#selectPuntoIncidencia").val();
  var comentariIncidencia=$("#txtComentarioIncidenciaEspecial").val();
  var selectMotivoIncidenciaEspecial=$("#selectMotivoIncidenciaEspecial").val();
  var tipoPeriodo = $('input:radio[name=optionPeriodo]:checked').val();

  var supervisor=$("#txtSupervisorIdIncidencia").val();

  var supervisorElements = supervisor.split ("-");

  var supervisorEntidadId = supervisorElements [0];
  var supervisorConsecutivoId = supervisorElements [1];
  var supervisorTipoId = supervisorElements [2];
  var incidenciaPuesto=$("#selectPuestoIncidencia").val();

  var incidenciaId=$("#selectIncidenciaEspecial").val();
  var idCliente=$("#opi_"+empleadoPuntoServicioId).attr("idCliente");

  var selplantillaservicioincidencia1=$("#selplantillaservicioincidencia").val();
  var selplantillaservicioincidenciaSplit = selplantillaservicioincidencia1.split("_");
  var selplantillaservicioincidencia = selplantillaservicioincidenciaSplit[0];
  var idPlantillaServicio = selplantillaservicioincidenciaSplit[1];
  var lineanegocioincidenciaespecial=$("#idlineanegocioincidenciaespecial").val();
  var visibleRh = $("#visibleRhCondicion").val();
  var idClienteCondicion = $("#idClienteCondicion").val();
  var tipoIncidenciaPeticionM = "Incidencia_Especial";

  var valordia="1";
  
  if(idCliente=="2" && visibleRh=="1" && lineanegocioincidenciaespecial=='1'){
      alert("No Es Posible Pasar Asistencias En Un Punto De Servicio 'CUBRE' Porfavor Selecciona Otro Punto De Servicio ó Pasa Asistencia En 'MERMA' !!RECUERDA EL PASE DE ASISTENCIA EN MERMA ESTA SUJETO A APROBACIÓN!!");
  }else if(idCliente=="2" && visibleRh=="0" && comentariIncidencia == "" && (incidenciaId=="6" || incidenciaId=="1") ){
    alert("Porfavor Indica En El Comentario El Motivo Por El Cúal Se Está Pasando La Asistencia En El Punto De (MERMA) !!RECUERDA EL PASE DE ASISTENCIA EN MERMA ESTA SUJETO A APROBACIÓN!!");
  }else if(incidenciaPuesto=="0" || incidenciaPuesto=="" || incidenciaPuesto=="null" || incidenciaPuesto=="NULL" || incidenciaPuesto==null){
    alert("Porfavor Indica Puesto");
  }else if(selplantillaservicioincidencia=="0" || selplantillaservicioincidencia=="" || selplantillaservicioincidencia=="null" || selplantillaservicioincidencia=="NULL" || selplantillaservicioincidencia==null){
    alert("Porfavor Indica La Plantilla ");
  }else if(idCliente=="2" && visibleRh=="0" && comentariIncidencia!="" && (incidenciaId=="6" || incidenciaId=="1")){
     RevisarPeticionesMerma(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,asistenciaFecha);
      var revisionPeticionA = $("#revisionPeticionA").val();
      var tipoIncidencia1 = $("#TIpoIncidencia1").val();
      var tipoIncidencia2 = $("#TIpoIncidencia2").val();
     if((revisionPeticionA=="2" || revisionPeticionA=="1") && (incidenciaId==1) && (tipoIncidencia1==1 || tipoIncidencia1==3 || tipoIncidencia1==7 || tipoIncidencia2==1 || tipoIncidencia2==3 || tipoIncidencia2==7) && (lineanegocioincidenciaespecial=="1")){
        var mensaje="No Es Posible Registrar, Debido A Que Ya Existe Un Registro De Dia En Este Dia Con Este Empleado, Favor De Borrar El Registro Si Se Requiere Registrar Uno Diferente";
        var bandera11 = 1;
    }else if((revisionPeticionA=="2" || revisionPeticionA=="1") && (incidenciaId==6) && (tipoIncidencia1==2 || tipoIncidencia1==4 || tipoIncidencia1==6 || tipoIncidencia1==7 || tipoIncidencia2==2 || tipoIncidencia2==4 || tipoIncidencia2==6 || tipoIncidencia2==7) && (lineanegocioincidenciaespecial=="1")){
        var mensaje="No Es Posible Registrar, Debido A Que Ya Existe Un Registro De Noche En Este Dia Con Este Empleado, Favor De Borrar El Registro Si Se Requiere Registrar Uno Diferente";
        var bandera11 = 1;
    }else {
      var bandera11 =0;
    }
      if(bandera11 != "0"){
        alert("No Es Posible Realizar El Registro , El Empleado Cuenta Con Un Registro (Petición En Este Dia)");
      }else{
        $.ajax({
          type: "POST",
          url: "ajax_insertPeticionAsistenciaMerma.php",
          data: {"empleadoEntidadId":empleadoEntidadId, "empleadoConsecutivoId": empleadoConsecutivoId, "empleadoTipoId":empleadoTipoId, "empleadoPuntoServicioId": empleadoPuntoServicioId, "supervisorEntidadId":supervisorEntidadId, "supervisorConsecutivoId": supervisorConsecutivoId, "supervisorTipoId":supervisorTipoId, "incidenciaId":incidenciaId, "asistenciaFecha":asistenciaFecha, "comentariIncidencia":comentariIncidencia, "tipoPeriodo":tipoPeriodo, "puestoCubiertoId":incidenciaPuesto, "idCliente":idCliente, "valordia": valordia,"plantilladeservicio":selplantillaservicioincidencia,"idlineanegocioPunto":lineanegocioincidenciaespecial,"tipoIncidenciaPeticionM":tipoIncidenciaPeticionM,"idPlantillaServicio":idPlantillaServicio,"selectMotivoIncidenciaEspecial":selectMotivoIncidenciaEspecial},
          dataType: "json",
          success: function(response) {
            alert("PETICIÓN ENVIADA CORRECTAMENTE ESPERANDO APROBACIÓN");
            $("#myModalIncidenciaEspecial").modal("hide");
            $("#txtComentarioIncidenciaEspecial").val("");
            if($("#puntoServicioSupervisor").val()!="null" && $("#puntoServicioSupervisor").val()!="NULL" && $("#puntoServicioSupervisor").val()!=null && $("#puntoServicioSupervisor").val()!=0){
            
            // if($("#puntoServicioSupervisor")!="PUNTOS DE SERVICIOS"){
              tableEmpleadosByPeriodoSupervisor();
            }                        
          },
          error: function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText);
          }
        });
        $("#myModalAsistencia").modal("hide");
      }
    }else{
    RevisarAsistecniasIncidenciasMismoDia(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,asistenciaFecha);

    var asistenciaIncidenciaMismoDia1 = $("#asistenciaIncidenciaMismoDia1").val(); 
    var asistenciaIncidenciaMismoDia2 = $("#asistenciaIncidenciaMismoDia2").val(); 
    var revisionIncidenciasMismoDia = $("#revisionIncidenciasMismoDia").val();
    
    if((revisionIncidenciasMismoDia=="2" || revisionIncidenciasMismoDia=="1") && (incidenciaId==1) && (asistenciaIncidenciaMismoDia1==1 || asistenciaIncidenciaMismoDia1==3 || asistenciaIncidenciaMismoDia1==7 || asistenciaIncidenciaMismoDia2==1 || asistenciaIncidenciaMismoDia2==3 || asistenciaIncidenciaMismoDia2==7) && (lineanegocioincidenciaespecial=="1")){
        var mensaje="No Es Posible Registrar, Debido A Que Ya Existe Un Registro De Dia En Este Dia Con Este Empleado, Favor De Borrar El Registro Si Se Requiere Registrar Uno Diferente";
        var bandera1 = 1;
    }else if((revisionIncidenciasMismoDia=="2" || revisionIncidenciasMismoDia=="1") && (incidenciaId==6) && (asistenciaIncidenciaMismoDia1==2 || asistenciaIncidenciaMismoDia1==4 || asistenciaIncidenciaMismoDia1==6 || asistenciaIncidenciaMismoDia1==7 || asistenciaIncidenciaMismoDia2==2 || asistenciaIncidenciaMismoDia2==4 || asistenciaIncidenciaMismoDia2==6 || asistenciaIncidenciaMismoDia2==7) && (lineanegocioincidenciaespecial=="1")){
        var mensaje="No Es Posible Registrar, Debido A Que Ya Existe Un Registro De Noche En Este Dia Con Este Empleado, Favor De Borrar El Registro Si Se Requiere Registrar Uno Diferente";
        var bandera1 = 1;
    }else {
      var bandera1 =0;
    }
    if(bandera1==1){
      mostrarModalError(mensaje,'');
      $("#myModalIncidenciaEspecial").modal("hide");
    }else{
   $.ajax ({
    type: "POST",
    url: "ajax_registrarIncidenciaEspecial.php",
    data: {empleadoEntidadId:empleadoEntidadId, empleadoConsecutivoId: empleadoConsecutivoId, empleadoTipoId:empleadoTipoId, empleadoPuntoServicioId: empleadoPuntoServicioId, supervisorEntidadId:supervisorEntidadId, supervisorConsecutivoId: supervisorConsecutivoId, supervisorTipoId, supervisorTipoId, incidenciaId:incidenciaId, asistenciaFecha:asistenciaFecha, comentariIncidencia:comentariIncidencia, tipoPeriodo:tipoPeriodo, incidenciaPuesto:incidenciaPuesto, idCliente:idCliente, selplantillaservicioincidencia:selplantillaservicioincidencia,lineanegocioincidenciaespecial:lineanegocioincidenciaespecial,"idPlantillaServicio":idPlantillaServicio,"selectMotivoIncidenciaEspecial":selectMotivoIncidenciaEspecial},
    dataType: "json",
    success: function (response){
      var mensaje=response.message;

      if (response.status=="success") {


        alertMsg1="<div id='msgAlert' class='alert alert-success'><trong>Incidencia Especial:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

        $("#alertMsgIncidencia").html(alertMsg1);
        $('#msgAlert').delay(3000).fadeOut('slow');
        $("#txtComentarioIncidenciaEspecial").val("");

        $("#myModalIncidenciaEspecial").modal("hide");
          UpdateRegistroPeticionMerma(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,asistenciaFecha,valordia);
        if($("#puntoServicioSupervisor").val()!="PUNTOS DE SERVICIOS"){
          tableEmpleadosByPeriodoSupervisor();
        }

               } else if (response.status=="error")
               {
                alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                $("#alertMsgIncidencia").html(alertMsg1);
                $('#msgAlert').delay(3000).fadeOut('slow');
              }else if(response.status=="errorCobertura"){

                $("#myModalIncidenciaEspecial").modal("hide");

                var mensaje=response.message;
                var puestosCobertura=response.puestosCobertura;

                mostrarModalError(mensaje,puestosCobertura);

              }else if(response.status=="error2"){

                alertMsg1="<div id='msgAlert' class='alert alert-warning'>"+"<h3>"+mensaje+"</h3>"+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                $("#msgpeticionasistencia").html(alertMsg1);
                $('#msgAlert').delay(7000).fadeOut('slow');
                $("#myModalIncidenciaEspecial").modal("hide");

              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
           }
         });
    }
  }//cierra else 
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

        //alert(id);
        
        var numeroEmpleado = $("#" + id).attr ("numeroEmpleado");
        var fechaAsistencia = $("#" + id).attr ("fechaAsistencia");
        var nombreEmpleado = $("#" + id).attr ("nombreEmpleado");
        var puntoServicioAsistenciaId = $("#" + id).attr ("puntoServicioAsistenciaId");
        var comentarioIncidencia = $("#" + id).attr ("comentarioIncidencia");
        var incidenciaAsistenciaId = $("#" + id).attr ("incidenciaAsistenciaId");
        var asistenciaText = $("#" + id).attr ("asistenciaText");
        var supervisorId =$("#" + id).attr ("supervisorId");
        var puestosCobertura=$("#" + id).attr("empleadoIdPuesto");
        var plantillaservicioporempleado=  $("#"+id).attr("plantillaservicio");  
        var IdPlantillaServ=  $("#"+id).attr("IdPlantillaServ");//corresponde al id de la plantilla 
        var lineanegocioPunto=$("#"+id).attr("idlineanegociopunto"); 

        $("#txtNombreEmpleadoIncidencia").val(nombreEmpleado);
        $("#txtNumeroEmpleadoIncidencia").val(numeroEmpleado);
        $("#txtFechaIncidencia").val(fechaAsistencia);
        $("#selectPuntoIncidencia").val(puntoServicioAsistenciaId);
        $("#txtSupervisorIdIncidencia").val(supervisorId);
        $("#selectPuestoIncidencia").val(puestosCobertura);
        $('#selplantillaservicioincidencia').empty().append('<option value="'+plantillaservicioporempleado+'_'+IdPlantillaServ+'" selected="selected">'+plantillaservicioporempleado+'_'+IdPlantillaServ+'</option>');
        $("#idlineanegocioincidenciaespecial").val(lineanegocioPunto);

      }
      function loadContextMenu ()
      {
        $(".demo1").contextMenu('myMenu1', {
          bindings: {
            'open': function(t) {
              alert('Trigger was '+t.id+'\nAction was Open');
            },
            'incidencia': function(t) {
              //cargaselectorlineanegociopuestosincidenciaespecial(); %%
              var id= t.id;
              console.log(t.id);
              var incidenciaAsistenciaId = $("#" + id).attr ("incidenciaAsistenciaId");
              var numeroEmpleado = $("#" + id).attr ("numeroEmpleado");
              var fechaAsistencia = $("#" + id).attr ("fechaAsistencia");

              var idpuntoservicio = $("#" + id).attr ("puntoservicioasistenciaid");
              cargaselectorlineanegociopuestosincidenciaespecial(idpuntoservicio);
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
                $("#modalempleadobajaOperativos").modal("show");
                $("#NumeroConsulaEmpleadoBajaOperativo").html(numeroEmpleado + " Se Encuentra En Estatus Baja");
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
              RevisarCierredePeriodo();
              var ocultarBtnBorrarHiden = $("#ocultarBtnBorrarHiden").val();
              if(ocultarBtnBorrarHiden=="1"){
                var id= t.id;
                var numeroEmpleado = $("#" + id).attr ("numeroEmpleado");
                var fechaAsistencia = $("#" + id).attr ("fechaAsistencia");
                var nombreEmpleado = $("#" + id).attr ("nombreEmpleado");
                var puntoServicioAsistenciaId = $("#" + id).attr ("puntoServicioAsistenciaId");
                var comentarioIncidencia = $("#" + id).attr ("comentarioIncidencia");
                var incidenciaAsistenciaId = $("#" + id).attr ("incidenciaAsistenciaId");
                var asistenciaText = $("#" + id).attr ("asistenciaText");
                var folioincapacidad=$("#" + id).attr ("folioincapacidad");
; 
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
                      $("#modalempleadobajaOperativos").modal("show");
                      $("#NumeroConsulaEmpleadoBajaOperativo").html(numeroEmpleado + " Se Encuentra En Estatus Baja");
                    }else{
                      if (incidenciaAsistenciaId != 10 && incidenciaAsistenciaId != 11 )
                      {
                        deleteAsistencia (numeroEmpleado,fechaAsistencia, puntoServicioAsistenciaId, incidenciaAsistenciaId, '', '[__]',folioincapacidad);
                      }
                    }
                  },
                  error: function(jqXHR, textStatus, errorThrown){
                    alert(jqXHR.responseText);
                  }
                });
              }else{
                alert("Solo es posible Editar, El periodo Actual fue cerrado");
              }
            }//Borrar
          }
        });
      }
      function RevisarCierredePeriodo(){
        $("#ocultarBtnBorrarHiden").val(1);
        $.ajax({
          type: "POST",
          url: "ajax_GetCierrePeridoParaBtnBorrar.php",
          dataType: "json",
          async:false,
          success: function(response) {
            var OpcionBtn = response.datos[0]["CondicionBoton"];
            // alert(OpcionBtn);
            $("#ocultarBtnBorrarHiden").val(OpcionBtn);
          },
          error: function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText);
          }
        });
      }



      $( "#txtSearchNumeroEmpleadoAsistencia" ).focus(function() {

        busqueda="numeroEmpleado";
        $("#txtSearchNameAsistencia" ).val("");
        $("#puntoServicioSupervisor").val("PUNTOS DE SERVICIOS");


      //alert(busqueda);
    });

      $( "#txtSearchNameAsistencia" ).focus(function() {

        busqueda="nombreEmpleado";

        $("#puntoServicioSupervisor").val("PUNTOS DE SERVICIOS");
        $( "#txtSearchNumeroEmpleadoAsistencia" ).val("");

      //alert(busqueda);
    });

      $( "#puntoServicioSupervisor" ).focus(function() {

        busqueda="puntoServicio";

        $("#txtSearchNameAsistencia" ).val("");
        $( "#txtSearchNumeroEmpleadoAsistencia" ).val("");

      //alert(busqueda);
    });

      function mostrarModalError(mensaje, puestosCobertura){
        $("#modalError").modal();
        var textomsg="<div id='msg' name='msg' ><h5>"+mensaje+" </h5> </div>";

        if (mensaje=='Puesto de cobertura invalido'){

          textomsg+="<p>El puesto del empleado no coincide con el puesto solicitado por el cliente, Por favor verifique</p><h5>Puestos solicitados:</h5>";


          for(var i=0; i<puestosCobertura.length;i++){

            var puesto= puestosCobertura[i];
            textomsg+="<p>*"+puesto+"</p>" ;

          }

        }


        $("#mensajeError").html(textomsg);
      }



      $("#selectPuntoServicioAsistencia").change(function()
      { 
        var idpuntoservicio=$("#selectPuntoServicioAsistencia").val();
        $("#selplantillaservicio").empty();

        $("#selectPuestoAsistecia").empty();

        
        if(idpuntoservicio!="PUNTOS DE SERVICIOS")
        {
          cargaselectorlineanegociopuestosincidencia(idpuntoservicio);

        }
      });
      function cargaselectorplantillaenmodalasistencia(idpuntoserv,idpuesto){
        $.ajax({
         type: "POST",
         url: "ajax_traeplatillasbypuntoserv.php",
         data: {"idpuntoserv":idpuntoserv,"idpuesto":idpuesto},
         dataType: "json",
         success: function(response) {
         // console.log(response);
         datos = response.plantillas;
                 //alert(datos[0].rolOperativoPlantilla);
                 if(datos.length==1 && (datos[0].rolOperativoPlantilla=="" || datos[0].rolOperativoPlantilla==null)){
                  $('#selplantillaservicio').empty().append('<option value="0" selected="selected">NO APLICA</option>');
                }else{
                  $('#selplantillaservicio').empty().append('<option value="0" selected="selected">PLANTILLA</option>');
                  $.each(datos, function(i) {
                       $('#selplantillaservicio').append('<option value="' + datos[i].rolOperativoPlantilla + '_'+ datos[i].servicioPlantillaId +'">' +datos[i].rolOperativoPlantilla + '_'+ datos[i].servicioPlantillaId +'</option>'); //verificar que rollo con esto
                     });
                  if($('#selplantillaservicio option').length === 1){
            // de no quedar opciones disponibles en el selector de servicios (solo existiria la opción 0), limpio la lista y coloco una opcion 0 con un mensaje.
            $('#selplantillaservicio').empty().append('<option value="0" selected="selected">No hay plantilla disponible.</option>');
          }
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
       alert(jqXHR.responseText);
     }
   });
      }

      $("#selectPuntoIncidencia").change(function(){
        var idpuntoservicioincidencia=$("#selectPuntoIncidencia").val();
        var idpuesto=$("#selectPuestoIncidencia").val();
        $("#selplantillaservicioincidencia").empty();
        $("#selectPuestoIncidencia").empty();
        if(idpuntoservicioincidencia!="PUNTOS DE SERVICIOS")
        {
          cargaselectorlineanegociopuestosincidenciaespecial(idpuntoservicioincidencia);

          //cargaselectorplantillaenmodalasistenciadeincidencia(idpuntoservicioincidencia,idpuesto);//esta funcion pasarla al change del selector de puesto
        }
      });
      function cargaselectorplantillaenmodalasistenciadeincidencia(idpuntoserv,idpuesto){
        $.ajax({
         type: "POST",
         url: "ajax_traeplatillasbypuntoserv.php",
         data: {"idpuntoserv":idpuntoserv,"idpuesto":idpuesto},
         dataType: "json",
         success: function(response) {
          //console.log(response);
          datos = response.plantillas;
                 //alert(datos[0].rolOperativoPlantilla);
                 if(datos.length==1 && (datos[0].rolOperativoPlantilla=="" || datos[0].rolOperativoPlantilla==null)){
                  $('#selplantillaservicioincidencia').empty().append('<option value="0" selected="selected">NO DEFINIDO GIF</option>');

                }else{
                  $('#selplantillaservicioincidencia').empty().append('<option value="0" selected="selected">PLANTILLA</option>');
                  $.each(datos, function(i) {
                       $('#selplantillaservicioincidencia').append('<option value="' + datos[i].rolOperativoPlantilla + '_' + datos[i].servicioPlantillaId + '">' +datos[i].rolOperativoPlantilla + '_' + datos[i].servicioPlantillaId + '</option>'); //verificar que rollo con esto
                     });
                }
                if($('#selplantillaservicioincidencia option').length === 1){
            // de no quedar opciones disponibles en el selector de servicios (solo existiria la opción 0), limpio la lista y coloco una opcion 0 con un mensaje.
            $('#selplantillaservicioincidencia').empty().append('<option value="0" selected="selected">No hay plantilla disponible.</option>');
          }

          //valuar el puesto
        },
        error: function(jqXHR, textStatus, errorThrown) {
         alert(jqXHR.responseText);
       }
     });
      }





      var st7="";
      var st2="";
     

      $("#selectTipoIncapacidad").change(function(){
        $("#divmuestrast7").hide();
        $("#divmuestrast2").hide();
        $("#docust7").val("");
        $("#docust2").val("");
        $("#docuincapacidad").val("");
        
        if($("#selectTipoIncapacidad").val()==0 ){
          $("#divmuestraDictamen").hide();
          $("#divmuestraEnfermedadGeneral").hide().val(""); 
        }else if($("#selectTipoIncapacidad").val()==1 ){

          $("#divmuestraEnfermedadGeneral").show().val("");
          $("#divmuestraDictamen").hide();
        }else if($("#selectTipoIncapacidad").val()==2){
          $("#divmuestraEnfermedadGeneral").show().val("");
          $("#divmuestrast7").show();
          $("#divmuestraDictamen").show();


          guardardocumentoincapacidadRegistraincidencia(2);

        }else if($("#selectTipoIncapacidad").val()==3){
          $("#divmuestraDictamen").hide();
          $("#divmuestraEnfermedadGeneral").show().val("");


        }


      });


    $("#btnguardarincapacidad").click(function(){
      var PeticionesCapacitacionIncapacidad = $("#revicionIncidenciaCapacitacion").val();
      if(PeticionesCapacitacionIncapacidad != "0"){
        alert("error","No Es Posible Registra, Debido A Que Ya Existe Un Registro De Capacitacion En Este Dia Con Este Empleado, Favor De Borrar El Registro Si Se Requiere Registrar Uno Diferente");
      }else{
        var nombredearchivo      = $("#docuincapacidad").val();
        var nombredearchivoArray = nombredearchivo.split('.');
        var tipoarchivo      = nombredearchivoArray[nombredearchivoArray.length - 1];
        tipoarchivo =tipoarchivo.toUpperCase();
        var bandera=true;
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
          }else if($("#selectTipoIncapacidad").val()==2 && $("#docust2").val()!="" && $("#docuDic").val()=="" && dictamen != 1){
            pintaerrormodalincapacidad("PARA CARGAR ARCHIVO ST-2 DEBE SELECCIONAR DICTAMEN ST-7 ");
            bandera=false;
          }else if($("#selectTipoIncapacidad").val()==2 && $("#docust2").val()==""){
            st2=0;
          }
        }
        if(bandera){
          if($("#selectTipoIncapacidad").val()==2 && $("#docuDic").val()!=""){
            dictamen = 1;
          }
          guardardocumentoincapacidadRegistraincidencia(1);
         //antes de guardar verificar el folio que no exista y verificar el tipo de puesto que exista
        } 
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
var puestoCubiertoId= $("#selectPuestoAsistecia").val();
var elementosNumeroEmpleado = numeroEmpleado.split("-");
var empleadoEntidadId = elementosNumeroEmpleado[0];
var empleadoConsecutivoId = elementosNumeroEmpleado[1];
var empleadoTipoId = elementosNumeroEmpleado[2];
var empleadoPuntoServicioId = $("#selectPuntoServicioAsistencia").val();
var comentariIncidencia=$("#txtComentarioIncidencia").val();
var tipoPeriodo = $('input:radio[name=optionPeriodo]:checked').val();
var supervisor=$("#txtsupervisorId").val();
var supervisorElements = supervisor.split ("-");
var supervisorEntidadId = supervisorElements [0];
var supervisorConsecutivoId = supervisorElements [1];
var supervisorTipoId = supervisorElements [2];
var idCliente=$("#op_"+empleadoPuntoServicioId).attr("idCliente");
        var valordia=0;//aquiva ir el valor del formulario de incapacidad
        var plantilladeservicio1=$("#selplantillaservicio").val();
        var plantilladeservicio2 = plantilladeservicio1.split ("_");
        var plantilladeservicio = plantilladeservicio2[0];
        var idPlantillaServicio = plantilladeservicio2[1];
        var idlineanegocioPunto=$("#idlineanegociopunto").val() 
        var incidenciaId=8;//corresponde a la incapacidad
        if(opcion==0 || opcion==1 || opcion==2){
          var formData = new FormData($("#archivoincapacidad")[0]);   
        } else if(opcion==3){ 
         var formData = new FormData($("#archivost7")[0]);  
       }else if(opcion==4){
        var formData = new FormData($("#archivost2")[0]);  
      }else if(opcion==5){
        var formData = new FormData($("#archivosDict")[0]);  
      }
      if(st7Falso == "1" || st7Falso == 1){
        st7 = 1;
      }
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
         formData.append('idPlantillaServicio', idPlantillaServicio);
         formData.append('idlineanegocioPunto', idlineanegocioPunto);              
         formData.append('st7', st7); 
         formData.append('st2', st2); 
         formData.append('dictamen', dictamen); 
            $.ajax({
             type: "POST",
             url: "ajax_guardadocumentoincapacidadRegistarincidencia.php",
             data:formData,
             dataType: "json",
             cache: false,
             contentType: false,
             processData: false,
             async:false, 
             success: function(response) {
               //console.log(response);
               if(response.status=="success"){
                UpdateRegistroPeticionMerma(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,asistenciaFecha,valordia);
                //alert("Se Registro Incapacidad correctamente");
                var mensaje ="Se Registro Incapacidad correctamente";
                alertMsg1="<div id='msgalertIncapacidad' class='alert alert-success'><strong>Alerta:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#msgerrormodlaincapacidad").html(alertMsg1);
                $(document).scrollTop(0);
                $('#msgalertIncapacidad').delay(3000).fadeOut('slow');
                if(opcion==1 && $("#selectTipoIncapacidad").val()==2 && $("#docust2").val()!=""){
                  gusradararchivost2();
                }else if(opcion==1 && $("#selectTipoIncapacidad").val()==2 && $("#docust7").val()!=""){
                  gusradararchivost7();
                }
                if(opcion==1 && $("#selectTipoIncapacidad").val()==2 && $("#docuDic").val()!=""){
                  gusradararchivoDictamen();
                }

                if((opcion==3 || opcion==4 || opcion==5)){
                  if($("#docuDic").val()!=""){
                  }
                }else{
                    resetmodalincapacidad();  
                }  
              }else if(response.status=="success1"){
  
              }else if(response.status=="success2"){
                if((response.st7 == "1" || response.st7 == 1) && (response.st2 == "1" || response.st2 == 1) && (response.Dictamen == "1" || response.Dictamen == 1)){
                  $("#divmuestrast7").show();
                  $("#divmuestrast2").hide();
                  st7=1;
                  st2="";
                  dictamen="";
                }else{
                  var idincapacidad=response.idincapacidad;
                  st7=response.st7;
                  st2=response.st2;
                  if(response.Dictamen == "" || response.Dictamen == null || response.Dictamen =="NULL" || response.Dictamen == "null" || response.Dictamen =="undefined"){
                    dictamen=0;
                  }else{
                    dictamen=response.Dictamen;
                  }
                  if(st7==1 && st2==0){
                    var mensaje ="Tienes Pendiente Por Comprobar ST2";
                    alertMsg1="<div id='msgalertIncapacidad' class='alert alert-warning'><strong>Atención:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#msgerrormodlaincapacidad").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgalertIncapacidad').delay(7000).fadeOut('slow');
                    $("#divmuestrast7").hide();
                    st2=1;
                    $("#divmuestrast2").show();
                  }else if(((st7==null || st7=="NULL" || st7=="null"  || st7==0)  && (st2==null || st2=="NULL" || st2=="null" || st2==0))){
                    $("#divmuestrast7").show();
                    $("#divmuestrast2").hide();
                    st7=1;
                  }else {
                    $("#divmuestrast7").show();
                    $("#divmuestrast2").hide();
                    st7=1;
                    st2="";
                  }
                }
             }else if(response.status=="error"){

              pintaerrormodalincapacidad(response.message);

            }else if(response.status=="error1"){
              pintaerrormodalincapacidad(response.message);
              $("#inpfolioincapacidad").val("");
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


          $("#inpfolioincapacidad").blur(function(){
            var a = $("#inpfolioincapacidad").val();
            var b = a.toUpperCase();
            $("#inpfolioincapacidad").val(b);
            if($("#inpfolioincapacidad").val()=="" || !/^(([a-zA-z]{2})+([0-9]{6}))*$/.test($("#inpfolioincapacidad").val())){
              pintaerrormodalincapacidad("Verifica FOLIO INCAPACIDAD");
              $("#selectTipoIncapacidad").val(0).prop("disabled",true);
              $("#divmuestrast7").hide();
              $("#divmuestrast2").hide();
              $("#divmuestraDictamen").hide();
              $("#inpfolioincapacidad").val("");
              $( "#divmuestraEnfermedadGeneral").hide();

            }else{
              var numeroEmpleado = $("#txtNumeroEmpleadoAsistencia").val ();
              var elementosNumeroEmpleado = numeroEmpleado.split ("-");
              var empleadoEntidadId = elementosNumeroEmpleado[0];
              var empleadoConsecutivoId = elementosNumeroEmpleado[1];
              var empleadoTipoId = elementosNumeroEmpleado[2];
              RevisarIncapacidadPendiente(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,0);
              // guardardocumentoincapacidadRegistraincidencia(0);

           }
         });

          function gusradararchivost7(){


            guardardocumentoincapacidadRegistraincidencia(3);
          }


          function gusradararchivost2(){


            guardardocumentoincapacidadRegistraincidencia(4);
          }

          function gusradararchivoDictamen(){


            guardardocumentoincapacidadRegistraincidencia(5);
          }


          function resetmodalincapacidad(){
            $("#ModalIncapacidad").modal('hide');
            $("#inpfolioincapacidad").val("");
            $("#selectTipoIncapacidad").val(0);
            $("#inpdiasincapacidad").val("");
            $("#docuincapacidad").val("");
            $("#docust2").val("");
            $("#docust7").val("");
            $("#docuDic").val("");
            $("#selectTipoIncapacidad").val(0).prop("disabled",false);
            $("#divmuestrast7").hide();
            $("#divmuestrast2").hide();
            $("#divmuestraDictamen").hide();
            $("#divmuestraEnfermedadGeneral").hide();
            // if(busqueda=="puntoServicio"){

            //   tableEmpleadosByPeriodoSupervisor ();

            // }else if (busqueda=="numeroEmpleado"){

            //   consultaEmpleadoByIdByUser();

            // }else if(busqueda="nombreEmpleado"){
            //   consultaEmpleadoByNameByUser();
            // }
            generarTablaPeriodo123();



          }

          function consultapuestosbylineadenegocio(idlineanegociopunto,idpuesto){
           //alert(idpuesto);
           $.ajax({
            type: "POST",
            url: "ajax_getPuestosBylineanegocio.php",
            data: {"lineanegocio":idlineanegociopunto,"opcion":0},
            dataType: "json",
            success: function(response) {
                //onsole.log(response);
                var datos=response.datos;

                //llenar el selector de puestos
                $('#selectPuestoAsistecia').empty().append('<option value="0" selected="selected">PUESTO</option>');
                $.each(datos, function(i) {
                       $('#selectPuestoAsistecia').append('<option value="' + datos[i].IdPuesto + '">' +datos[i].descripcionPuesto + '</option>'); //verificar que rollo con esto
                     });

                $("#selectPuestoAsistecia").val(idpuesto);
              },
              error: function(jqXHR, textStatus, errorThrown){
                alert(jqXHR.responseText);
              }
            });
         }

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
estacion[14] = "background-color:#FF8000";
for ( var i=0; i<15 ;i++)
{
  if(i=="9"){
    $("#a_"+i).prop('style',''+estacion[i]+';cursor: not-allowed;pointer-events: none;');
  }else{
    $("#a_"+i).prop('style',''+estacion[i]);
  }
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
                    for ( var i=0; i<15; i++)
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
      alert("error");
    }
  });
return bandera;  
            //$("#a_"+i).prop('style','visibility: hidden');//con esta propiedad desaparecen las etiquetas a
           //$("#a_1").css("visibility: hidden");
           
         }
         function cargaselectorlineanegociopuestosincidencia(idpuntoservicio){
          var idlineanegociopunto=$("#op_"+idpuntoservicio).attr("lineanegociopunto");
          $.ajax({
            type: "POST",
            url: "ajax_getPuestosBylineanegocio.php",
            data: {"lineanegocio":idlineanegociopunto,"opcion":0},
            dataType: "json",
            success: function(response) {
                //onsole.log(response);
                var datos=response.datos;
                //llenar el selector de puestos
                $('#selectPuestoAsistecia').empty().append('<option value="0" selected="selected">PUESTO</option>');
                $.each(datos, function(i) {
                       $('#selectPuestoAsistecia').append('<option value="' + datos[i].IdPuesto + '">' +datos[i].descripcionPuesto + '</option>'); //verificar que rollo con esto
                     });
               ConsultaIdClientePorPunto(idpuntoservicio);
              },
              error: function(jqXHR, textStatus, errorThrown){
                alert(jqXHR.responseText);
              }
            });
        }

        function ConsultaIdClientePorPunto(idpuntoservicio){
          $.ajax({
            type: "POST",
            url: "ajax_getIdClientePorPunto.php",
            data: {"idpuntoservicio":idpuntoservicio},
            dataType: "json",
            async: false,
            success: function(response) {
                console.log(response);
                var datos=response.datos;
                $("#idClienteCondicion").val(datos[0].idClientePunto);
                $("#visibleRhCondicion").val(datos[0].visiblerh); 
                var cliente = datos[0].idClientePunto;           
                var visiblerh = datos[0].visiblerh; 
                if(cliente == "2" && visiblerh=="0"){
                  $("#divValorDia").show();
                }else{
                  $("#divValorDia").hide();
                }          

              },
              error: function(jqXHR, textStatus, errorThrown){
                alert(jqXHR.responseText);
              }
            });
        }


$("#selectPuestoAsistecia").change(function(){ 
  var idpuesto=$("#selectPuestoAsistecia").val();
  var idpuntoservicio=$("#selectPuntoServicioAsistencia").val();
   //alert(idpuesto);
  if(idpuesto!=0){
    cargaselectorplantillaenmodalasistencia(idpuntoservicio,idpuesto);
  }else{
    $("#selplantillaservicio").empty();          
  }
});
        function cargaselectorlineanegociopuestosincidenciaespecial(idpuntoservicio){
          var idlineanegociopunto=$("#op_"+idpuntoservicio).attr("lineanegociopunto");
          $.ajax({
            type: "POST",
            url: "ajax_getPuestosBylineanegocio.php",
            data: {"lineanegocio":idlineanegociopunto,"opcion":0},
            dataType: "json",
            success: function(response) {
                //onsole.log(response);
                var datos=response.datos;

                //llenar el selector de puestos
                $('#selectPuestoIncidencia').empty().append('<option value="0" selected="selected">PUESTO</option>');
                $.each(datos, function(i) {
                       $('#selectPuestoIncidencia').append('<option value="' + datos[i].IdPuesto + '">' +datos[i].descripcionPuesto + '</option>'); //verificar que rollo con esto
                     });
                //$("#selectPuestoAsistecia").val(idpuesto);
              },
              error: function(jqXHR, textStatus, errorThrown){
                alert(jqXHR.responseText);
              }
            });

        }


$("#selectPuestoIncidencia").change(function(){ 
  var idpuesto=$("#selectPuestoIncidencia").val();
  var idpuntoservicio=$("#selectPuntoIncidencia").val();
  if(idpuesto!=0){
    cargaselectorplantillaenmodalasistenciadeincidencia(idpuntoservicio,idpuesto);
  }else{
    $("#selplantillaservicioincidencia").empty();
  }
});
        
$( "#botonCancelarVacaciones" ).click(function() {
  $("#ModalVacaciones").modal("hide");
  $("#divmuestraVacacionesDisfrutadas").hide();
});

function abrirmodalvacaciones(numeroEmpleado,nomenclaturaIncidencia){
  $("#banderaVacaciones").val("0");
  $("#selectPeriodoInicio").val("0");
  $("#inpdiasvacaciones").val("");
  $("#inpFoliovacaciones").val("");
  $("#docvacaciones").val("");
  $('#divinputsfechas').html("");
  $("#VacacionesRestntes").val("");
  $("#PeriodoInicio").val("");
  $("#PeriodoFin").val("");
  $("#numempleadovacaciones").val(numeroEmpleado);
  $("#nomeclaturavacaciones").val(nomenclaturaIncidencia);
  $("#inpdiasvacaciones").prop("readonly", true);
  CargarSelectorPeriodo();
  $("#myModalAsistencia").modal("hide");
  $("#ModalVacaciones").modal();
  $("#divmuestraVacacionesDisfrutadas").show();
}

function CargarSelectorPeriodo(){
  var empleadoEntidadId = $("#empleadoEntidadIdVacaciones").val();
  var empleadoConsecutivoId = $("#empleadoConsecutivoIdVacaciones").val();
  var empleadoTipoId = $("#empleadoTipoIdVacaciones").val();
  $.ajax({
    type: "POST",
    url: "ajax_getPeriodosanuales.php",
    data: {"empleadoEntidadId":empleadoEntidadId,"empleadoConsecutivoId":empleadoConsecutivoId,"empleadoTipoId":empleadoTipoId},
    dataType: "json",
    success: function(response) {
      var datos=response.datos;
      //llenar el selector de periodos
      $('#selectPeriodoInicio').empty().append('<option value="-1" selected="selected"></option>');
      $.each(datos, function(i) {
        $('#selectPeriodoInicio').append('<option value="' + datos[i].IdAnio + '">' +datos[i].Aniversario + '</option>');
      });
      },
    error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
  });
}inpdiasvacaciones

$("#selectPeriodoInicio").change(function()
{

  var Aniversario = $("#selectPeriodoInicio").val();
  var empleadoEntidadId = $("#empleadoEntidadIdVacaciones").val();
  var empleadoConsecutivoId = $("#empleadoConsecutivoIdVacaciones").val();
  var empleadoTipoId = $("#empleadoTipoIdVacaciones").val();
  $("#inpdiasvacaciones").val("");
  $("#inpFoliovacaciones").val("");
  $('#divinputsfechas').html("");
  $("#inpdiasvacaciones").prop("readonly", true);
  $("#PeriodoInicio").val("");
  $("#PeriodoFin").val("");
  $("#VacacionesRestntes").val("");
  if(Aniversario=="-1" || Aniversario==null || Aniversario=="null" || Aniversario=="NULL"){
    pintaerrormodalVacaciones("Seleccione Un Aniversario Para Continuar");
  }else
  {
    $.ajax({
      type: "POST",
      url: "ajax_getDiasRestantesVacacionesAsistencia.php",
      data:{"empleadoEntidadId":empleadoEntidadId,"empleadoConsecutivoId":empleadoConsecutivoId,"empleadoTipoId":empleadoTipoId,"Aniversario":Aniversario},
      dataType: "json",
      success: function(response) {
        $("#VacacionesRestntes").val("");
        $("#PeriodoInicio").val("");
        $("#PeriodoFin").val("");
        var datos=response.DiasDisponibles;
        var FechaUno=response.FechaUno;
        var FechaDos=response.FechaDos;
        $("#VacacionesRestntes").val(datos);
        $("#PeriodoInicio").val(FechaUno);
        $("#PeriodoFin").val(FechaDos);
        if(Aniversario!="-1" && datos!="0"){
          $("#inpdiasvacaciones").prop("readonly", false);
        }else{
          $("#inpdiasvacaciones").prop("readonly", true);
        }

        },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }
});//botactualizar

$( "#botactualizar" ).click(function() {

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



$( "#botonGuardarVacaciones" ).click(function() {

  var selectPeriodoInicio = $("#selectPeriodoInicio").val();
  var inpdiasvacaciones = $("#inpdiasvacaciones").val();
  var inpFoliovacaciones = $("#inpFoliovacaciones").val();
  var docvacaciones = $("#docvacaciones").val();
  var RolOperativoVacaciones = $("#RolOperativoVacaciones").val();
  var empleadoEntidadId = $("#empleadoEntidadIdVacaciones").val();
  var empleadoConsecutivoId = $("#empleadoConsecutivoIdVacaciones").val();
  var empleadoTipoId = $("#empleadoTipoIdVacaciones").val();
  var empleadoPuntoServicioId = $("#empleadoPuntoServicioIdVacaciones").val();
  var supervisorEntidadId = $("#supervisorEntidadIdVacaciones").val();
  var supervisorConsecutivoId = $("#supervisorConsecutivoIdVacaciones").val();
  var supervisorTipoId = $("#supervisorTipoIdVacaciones").val();
  var incidenciaId = $("#incidenciaIdVacaciones").val();
  var comentariIncidencia = $("#comentariIncidenciaVacaciones").val();
  var tipoPeriodo = $("#tipoPeriodoVacaciones").val();
  var puestoCubiertoId = $("#puestoCubiertoIdVacaciones").val();
  var idCliente = $("#idClienteVacaciones").val();
  var plantilladeservicio1 = $("#plantilladeservicioVacaciones").val();
  var plantilladeservicio2 = plantilladeservicio1.split ("_");
  var plantilladeservicio = plantilladeservicio2[0];
  var idPlantillaServicio = plantilladeservicio2[1];
  var idlineanegocioPunto = $("#idlineanegocioPuntoVacaciones").val();
  var bandera = $("#banderaVacaciones").val();
  var nomenclaturaIncidencia = $("#nomeclaturavacaciones").val();
  var primerfecha = $("#asistenciaFechaVacaciones").val();
  var incidenciaVacaciones =$("#incidenciaVacaciones").val();
  var bandera1 = "0";
  var a = "0";
  $("#IteracionesCorrectasYValidadas").val("");
  //Comienzan validaciones
  if(selectPeriodoInicio == "" || selectPeriodoInicio == "-1"){
    pintaerrormodalVacaciones("Seleccione El Periodo De Inicio");
  }else if(inpdiasvacaciones == ""){
    pintaerrormodalVacaciones("Ingrese Los Dias Computables (Solo Numeros)");
  }else{
     if(incidenciaVacaciones=="12" || incidenciaVacaciones=="13"){
      inpdiasvacaciones = (inpdiasvacaciones/2);
    }
    for(var i ="0"; i<inpdiasvacaciones; i++){
      var Uno = "1";
      var Vacacionesmenos = (parseInt(i) - parseInt(Uno));
      var Vacaciones = (parseInt(i) + parseInt(Uno));
      var DateVacaciones = $("#inputDateVacaciones"+i).val();
      var DateVacacionesSiguiente = $("#inputDateVacaciones"+Vacacionesmenos).val();
      RevicionPeticionesCapacitacion(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,DateVacaciones);
      RevisarAsistecniasIncidenciasMismoDia(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,DateVacaciones);
       var asistenciaIncidenciaMismoDia1 = $("#asistenciaIncidenciaMismoDia1").val(); 
       var asistenciaIncidenciaMismoDia2 = $("#asistenciaIncidenciaMismoDia2").val(); 
       var revisionIncidenciasMismoDia = $("#revisionIncidenciasMismoDia").val();
       RevisionAsistenciaDiaSeleccionado2(DateVacaciones,empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId); 
      var PeticionesCapacitacionVacaciones = $("#revicionIncidenciaCapacitacion").val();
      if($('#checkDia'+i).is(":checked")) {
        var DiaCheck = "1";
      }else{
        var DiaCheck = "0";
      }
      if($('#checkNoche'+i).is(":checked")){
        var NocheCheck = "1";
      }else{
        var NocheCheck = "0";
      }
      var RevisionAsistenciaDiaSeleccionado1 = $("#RevisionAsistenciaDiaSeleccionado").val();
      if(DateVacaciones == ""){
        pintaerrormodalVacaciones("Ingrese La Fecha Del Dia "+Vacaciones+" De Vacaciones");
        break;
      }else if(DateVacaciones < DateVacacionesSiguiente || DateVacaciones == DateVacacionesSiguiente){
        pintaerrormodalVacaciones("La Fecha De Vacaciones Ingresada No Puede Ser Menor Ni Igual Que La Anterior");
        break;
      }else if((incidenciaVacaciones=="5" || incidenciaVacaciones=="6") && (DiaCheck == "0" && NocheCheck == "0")){
        pintaerrormodalVacaciones("Marque Un Check De Dia o Noche En El Dia "+Vacaciones+" De Vacaciones");
        break;
      }else if((incidenciaVacaciones=="5" || incidenciaVacaciones=="6") && (DiaCheck == "1" && NocheCheck =="1")){
        pintaerrormodalVacaciones("Marque Solo Un Check De Dia o Noche En El Dia "+Vacaciones+" De Vacaciones");
        break;
      }else if((incidenciaVacaciones=="12" || incidenciaVacaciones=="13") && (DiaCheck == "0" || NocheCheck =="0")){
        pintaerrormodalVacaciones("Marque Ambos Checks De Dia Y Noche En El Dia "+Vacaciones+" De Vacaciones");
        break;
      }else if(docvacaciones == ""){
        pintaerrormodalVacaciones("Carge El Achivo De Vacaciones");
      }else if(RevisionAsistenciaDiaSeleccionado1!="0"){       
        pintaerrormodalVacaciones("La Fecha Del Dia "+Vacaciones+" De Vacaciones Ingresa Ya Tiene Un Registro Previo Favor De Verificar");
        break;
      }else if((revisionIncidenciasMismoDia=="2" || revisionIncidenciasMismoDia=="1") && (incidenciaVacaciones=="5" || incidenciaVacaciones=="6") && (DiaCheck == "1") && (asistenciaIncidenciaMismoDia1==1 || asistenciaIncidenciaMismoDia1==3 || asistenciaIncidenciaMismoDia1==7 || asistenciaIncidenciaMismoDia2==1 || asistenciaIncidenciaMismoDia2==3 || asistenciaIncidenciaMismoDia2==7)){
        pintaerrormodalVacaciones("No Es Posible Registrar, Debido A Que Ya Existe Un Registro De Dia En Este Dia Con Este Empleado, Favor De Borrar El Registro Si Se Requiere Registrar Uno Diferente");
        break;
      }else if((revisionIncidenciasMismoDia=="2" || revisionIncidenciasMismoDia=="1") && (incidenciaVacaciones=="5" || incidenciaVacaciones=="6") && (NocheCheck == "1") && (asistenciaIncidenciaMismoDia1==2 || asistenciaIncidenciaMismoDia1==4 || asistenciaIncidenciaMismoDia1==6 || asistenciaIncidenciaMismoDia1==7 || asistenciaIncidenciaMismoDia2==1 || asistenciaIncidenciaMismoDia2==3 || asistenciaIncidenciaMismoDia2==7)){
        pintaerrormodalVacaciones("No Es Posible Registrar, Debido A Que Ya Existe Un Registro De Noche En Este Dia Con Este Empleado, Favor De Borrar El Registro Si Se Requiere Registrar Uno Diferente");
        break;
      }else if((revisionIncidenciasMismoDia=="2" || revisionIncidenciasMismoDia=="1") && (incidenciaVacaciones=="12" || incidenciaVacaciones=="13") && (asistenciaIncidenciaMismoDia1==1 || asistenciaIncidenciaMismoDia1==2 || asistenciaIncidenciaMismoDia1==3  || asistenciaIncidenciaMismoDia1==4 || asistenciaIncidenciaMismoDia1==6 || asistenciaIncidenciaMismoDia1==7 || asistenciaIncidenciaMismoDia2==1 || asistenciaIncidenciaMismoDia2==2 || asistenciaIncidenciaMismoDia2==3 || asistenciaIncidenciaMismoDia2==4 || asistenciaIncidenciaMismoDia2==6 || asistenciaIncidenciaMismoDia2==7)){
        pintaerrormodalVacaciones("No Es Posible Registra, Debido A Que Ya Existe Un Registro (Dia/Noche/24x24) En Este Dia Con Este Empleado, Favor De Borrar El Registro Si Se Requiere Registrar Uno Diferente");
        break;
      }else if(PeticionesCapacitacionVacaciones != "0"){
        pintaerrormodalVacaciones("No Es Posible Registra, Debido A Que Ya Existe Un Registro De Capacitacion En Este Dia Con Este Empleado, Favor De Borrar El Registro Si Se Requiere Registrar Uno Diferente");
        break;
      }else{
        var Uno = "1";
        var iMas1 = (parseInt(i) + parseInt(Uno));
        $("#IteracionesCorrectasYValidadas").val(iMas1);
      }
    }//for
  }//else Validaciones
//Terminan las validaciones comienza la insercion y actualizacion en las tablas
  var IteracionesCorrectasYValidadas = $("#IteracionesCorrectasYValidadas").val();
  if(IteracionesCorrectasYValidadas ==inpdiasvacaciones){
    for(var i ="0"; i<inpdiasvacaciones; i++){
      var Uno = "1";
      var Vacacionesmenos = (parseInt(i) - parseInt(Uno));
      var Vacaciones = (parseInt(i) + parseInt(Uno));
      var DateVacaciones = $("#inputDateVacaciones"+i).val();
      var DateVacacionesSiguiente = $("#inputDateVacaciones"+Vacacionesmenos).val();
      if($('#checkDia'+i).is(":checked")) {
        var DiaCheck = "1";
      }else{
        var DiaCheck = "0";
      }
      if($('#checkNoche'+i).is(":checked")){
        var NocheCheck = "1";
      }else{
        var NocheCheck = "0";
      }
      if(DiaCheck=="1" && NocheCheck=="0"){
        var valordia=1;
      }else if(NocheCheck=="1" && DiaCheck=="0"){
        var valordia=2;
      }else if(NocheCheck=="1" && DiaCheck=="1"){
        var valordia=0;
      }
      var asistenciaFecha = DateVacaciones;
      var formData = new FormData($("#archivovacaciones")[0]);
      formData.append('inpdiasvacaciones', inpdiasvacaciones);
      formData.append('inpFoliovacaciones', inpFoliovacaciones);
      formData.append('RolOperativoVacaciones', RolOperativoVacaciones);
      formData.append('empleadoEntidadId', empleadoEntidadId);
      formData.append('empleadoConsecutivoId', empleadoConsecutivoId);
      formData.append('empleadoTipoId', empleadoTipoId);
      formData.append('nomenclaturaIncidencia', nomenclaturaIncidencia);
      formData.append('primerfecha', primerfecha);
      formData.append('selectPeriodoInicio', selectPeriodoInicio);
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
              InsertarAsistenciaVacaciones(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,empleadoPuntoServicioId,supervisorEntidadId,supervisorConsecutivoId,supervisorTipoId,incidenciaId,asistenciaFecha,comentariIncidencia,tipoPeriodo,puestoCubiertoId,idCliente,valordia,plantilladeservicio,idlineanegocioPunto,nomenclaturaIncidencia,inpdiasvacaciones,i,inpFoliovacaciones,selectPeriodoInicio,idPlantillaServicio);
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
        InsertarAsistenciaVacaciones(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,empleadoPuntoServicioId,supervisorEntidadId,supervisorConsecutivoId,supervisorTipoId,incidenciaId,asistenciaFecha,comentariIncidencia,tipoPeriodo,puestoCubiertoId,idCliente,valordia,plantilladeservicio,idlineanegocioPunto,nomenclaturaIncidencia,inpdiasvacaciones,i,inpFoliovacaciones,selectPeriodoInicio,idPlantillaServicio);
      }
    }//for
  }//if            
});

function RevisionAsistenciaDiaSeleccionado2(DateVacaciones,empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId){
  $.ajax({
    type: "POST",
    url: "ajax_RevisionAsistenciaDiaSeleccionado2.php",
    data:{"DateVacaciones":DateVacaciones,"empleadoEntidadId":empleadoEntidadId,"empleadoConsecutivoId":empleadoConsecutivoId,"empleadoTipoId":empleadoTipoId},
    dataType: "json",
    async:false,
    success: function(response) {
      $("#RevisionAsistenciaDiaSeleccionado").val("");
      var datos=response.datos;
      $("#RevisionAsistenciaDiaSeleccionado").val(datos);
     },
    error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
  });
}

function InsertarAsistenciaVacaciones(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,empleadoPuntoServicioId,supervisorEntidadId,supervisorConsecutivoId,supervisorTipoId,incidenciaId,asistenciaFecha,comentariIncidencia,tipoPeriodo,puestoCubiertoId,idCliente,valordia,plantilladeservicio,idlineanegocioPunto,nomenclaturaIncidencia,inpdiasvacaciones,i,inpFoliovacaciones,selectPeriodoInicio,idPlantillaServicio){
  var Uno = "1";
  var DiasVacacionesmenos = (parseInt(inpdiasvacaciones) - parseInt(Uno));
  $.ajax ({            
    type: "POST",
    url: "ajax_registrarAsistencia.php",
    data: {empleadoEntidadId:empleadoEntidadId, empleadoConsecutivoId: empleadoConsecutivoId, empleadoTipoId:empleadoTipoId,                empleadoPuntoServicioId: empleadoPuntoServicioId, supervisorEntidadId:supervisorEntidadId, supervisorConsecutivoId: supervisorConsecutivoId, supervisorTipoId, supervisorTipoId, incidenciaId:incidenciaId, asistenciaFecha:asistenciaFecha, comentariIncidencia:comentariIncidencia, tipoPeriodo:tipoPeriodo, puestoCubiertoId:puestoCubiertoId, idCliente:idCliente, valordia: valordia,plantilladeservicio,"idlineanegocioPunto":idlineanegocioPunto,"idPlantillaServicio":idPlantillaServicio},
    dataType: "json",
    async:false, 
    success: function (response) 
    {
      if (response.status == "error")
      {                        
        var mensaje=response.message;                                
        valordia=0;
        mostrarModalError(mensaje,'');
      }else if(response.status=="errorRegistro"){                                
        valordia=0;
        alert (response.message);
      }else if(response.status=="errorCobertura"){
        var mensaje=response.message;
        var puestosCobertura=response.puestosCobertura;                              
        valordia=0;
        mostrarModalError(mensaje,puestosCobertura);
      }else{
        if(i==DiasVacacionesmenos){
          id = $("#idCell").val();
          $("#" + id).html (nomenclaturaIncidencia);
          var style = styles [nomenclaturaIncidencia];
          $("#td_"+id).attr("style",style); 
          $("#" + id).attr ("incidenciaAsistenciaId", incidenciaId);
          $("#" + id).attr ("incidenciaText",  nomenclaturaIncidencia);                                
          valordia=0;
          if(response.asistencia != null)
          {
            for (var k in response.asistencia)
            {
              fecha = k;
              id = empleadoEntidadId + "-" + empleadoConsecutivoId + "-" + empleadoTipoId + empleadoPuntoServicioId + fecha;
              nomenclaturaIncidencia = response.asistencia[k].nomenclaturaIncidencia;
              incidenciaId = response.asistencia[k].incidenciaAsistenciaId;
              $("#" + id).html (nomenclaturaIncidencia);
              var style = styles [nomenclaturaIncidencia];
              $("#td_"+id).attr("style",style);             
              $("#" + id).attr ("incidenciaAsistenciaId", incidenciaId);
              $("#" + id).attr ("incidenciaText",  nomenclaturaIncidencia);
            }
          }
          // if(busqueda=="puntoServicio"){
          //   tableEmpleadosByPeriodoSupervisor ();
          // }else if (busqueda=="numeroEmpleado"){
          //   consultaEmpleadoByIdByUser();
          // }else if(busqueda="nombreEmpleado"){
          //   consultaEmpleadoByNameByUser();
          // }
          generarTablaPeriodo123();
        }
      UpdateAsistenciaAddFolioVacaciones(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,empleadoPuntoServicioId,inpFoliovacaciones,asistenciaFecha,selectPeriodoInicio); 
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      valordia=0;
      alert(jqXHR.responseText);
    }
  });
  if(i==DiasVacacionesmenos){
    $("#myModalAsistencia").modal("hide");
    $("#ModalVacaciones").modal("hide");
    $("#divmuestraVacacionesDisfrutadas").hide();
  }

}
function UpdateAsistenciaAddFolioVacaciones(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,empleadoPuntoServicioId,inpFoliovacaciones,asistenciaFecha,selectPeriodoInicio){
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

function cargarFolio(){
  $("#inpFoliovacaciones").val("");
  $('#divinputsfechas').html("");
  var numempleadovacaciones = $("#numempleadovacaciones").val();
  var nomeclaturavacaciones = $("#nomeclaturavacaciones").val();
  var inpdiasvacaciones = $("#inpdiasvacaciones").val();
  var primerfecha = $("#asistenciaFechaVacaciones").val();
  var VacacionesRestntes = $("#VacacionesRestntes").val();
  var incidenciaIdVacaciones = $("#incidenciaIdVacaciones").val();
  var a =VacacionesRestntes-inpdiasvacaciones;
  var numerodividido = (inpdiasvacaciones % 2);
  var incidenciaVacaciones =$("#incidenciaVacaciones").val();
  if(!/^([0-9])*$/.test($("#inpdiasvacaciones").val())){
    pintaerrormodalVacaciones(" Ingrese Solo Números En Dias Computables ");
    $("#inpdiasvacaciones").val("");
  }else if((VacacionesRestntes<"0") || (VacacionesRestntes=="0")){
    pintaerrormodalVacaciones(" El Empleado Ya Alcanó El Número Máximo De Vacaciones Otorgadas ");
    $("#inpdiasvacaciones").val("");  
  }else if((inpdiasvacaciones=="0") || (inpdiasvacaciones=="")){
    pintaerrormodalVacaciones(" Los Dias Computables No Pueden Ser Cero O Vacios ");
    $("#inpdiasvacaciones").val("");  
  }else if(a<"0"){
    pintaerrormodalVacaciones("Los Dias Computables No Puede Ser Mayor A Los dias Restantes De Vacaciones ");
    $("#inpdiasvacaciones").val("");  
  }else if((incidenciaVacaciones=="12" || incidenciaVacaciones=="13") && (numerodividido!="0")){
    pintaerrormodalVacaciones("Los (Dias Computables) Deben Ser Número Par Cuando El Turno Es De 24x24");
    $("#inpdiasvacaciones").val("");  
  }else{
    if((incidenciaVacaciones=="12" || incidenciaVacaciones=="13") && (numerodividido=="0")){
      inpdiasvacaciones = (inpdiasvacaciones/2);
    }
    for (var i = 0; i < inpdiasvacaciones; i++){
      var Uno = "1";
      var DiaVacacviones = (parseInt(i) + parseInt(Uno));
      if(i=="0"){
         var input = " <span class='add-on'>Dia "+DiaVacacviones+" De Vacaciones</span> <input id='inputDateVacaciones"+i+"' name='inputDateVacaciones"+i+"' type='date' class='input-medium' readonly> <span class='add-on' style='margin-left: 2%;'>Dia</span> <input id='checkDia"+i+"' name='checkDia"+i+"' type='checkbox' style='transform: scale(1.5); margin-left: 2%;'><span class='add-on' style='margin-left: 2%;'>Noche</span><input id='checkNoche"+i+"' name='checkNoche"+i+"' type='checkbox' style='transform: scale(1.5); margin-left: 2%;'><br><br>";
      }else{
        var input = " <span class='add-on'>Dia "+DiaVacacviones+" De Vacaciones</span> <input id='inputDateVacaciones"+i+"' name='inputDateVacaciones"+i+"' type='date' class='input-medium'> <span class='add-on' style='margin-left: 2%;'>Dia</span> <input id='checkDia"+i+"' name='checkDia"+i+"' type='checkbox' style='transform: scale(1.5); margin-left: 2%;'><span class='add-on' style='margin-left: 2%;'>Noche</span><input id='checkNoche"+i+"' name='checkNoche"+i+"' type='checkbox' style='transform: scale(1.5); margin-left: 2%;'><br><br>";
      }
      $('#divinputsfechas').append(input); 
    }
    $("#inputDateVacaciones0").val(primerfecha);
    var folio1 = "F_" + nomeclaturavacaciones + "_" + numempleadovacaciones + "_" + primerfecha + "_" + inpdiasvacaciones;
    $("#inpFoliovacaciones").val(folio1);
  }
}

function pintaerrormodalVacaciones(mensaje){
  alertMsg1="<div id='msErrorVacaciones' class='alert alert-error'><strong>Error:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
  $("#msgerrormodlavacaciones").html(alertMsg1);
  $(document).scrollTop(0);
  $('#msErrorVacaciones').delay(3000).fadeOut('slow');

}

/////////////////// Implementacion Del Bloqueo Permanente de un empleado conflictivo /////////////////////////////////////////////////////////
$('#checkSireingresoAsistencia').change(function() {
    if ($('#checkSireingresoAsistencia').is(":checked")) {
      $("#checkNoreingresoAsistencia").prop("checked", false);
      $("#divComentarioMotivoBetoAsistencia").hide();
      $("#banderaBetadoAsistencia").val(1);
    }else{
      $("#divComentarioMotivoBetoAsistencia").hide();
      $("#banderaBetadoAsistencia").val("");
    } 
  });
$('#checkNoreingresoAsistencia').change(function() {
    if ($('#checkNoreingresoAsistencia').is(":checked")) {
      $("#checkSireingresoAsistencia").prop("checked", false);
      $("#divComentarioMotivoBetoAsistencia").show();
      $("#banderaBetadoAsistencia").val(0);
    }else{
      $("#divComentarioMotivoBetoAsistencia").hide();
      $("#banderaBetadoAsistencia").val("");
    } 
  });

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////IMPLEMENTACION DE LA PETICION DE CAPACITACIÓN ////////////////////////////////////////////////////////////////////

function RevicionPeticionesCapacitacion(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,asistenciaFecha)
{
  var resultRevisionAsistencia = "";
  $.ajax({
    type: "POST",
    url: "ajax_RevisionPeticionCapacitacion.php",
    data : {"empleadoEntidadId":empleadoEntidadId,"empleadoConsecutivoId":empleadoConsecutivoId,"empleadoTipoId":empleadoTipoId,"asistenciaFecha":asistenciaFecha },
    dataType: "json",
    async:false,
    success: function(response) {
      if (response.status == "success")
      {
        resultRevisionAsistencia=response.datos.length;
        $("#revicionIncidenciaCapacitacion").val(resultRevisionAsistencia);
      }
    },
    error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
  });
}

function ActualizarEstatusPeticionCapacitacion(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,asistenciaFecha,EstatusCap){

  $.ajax({
    type: "POST",
    url: "ajax_UpdatePeticionCapacitacion.php",
    data : {"empleadoEntidadId":empleadoEntidadId,"empleadoConsecutivoId":empleadoConsecutivoId,"empleadoTipoId":empleadoTipoId,"asistenciaFecha":asistenciaFecha,"EstatusCap":EstatusCap},
    dataType: "json",
    async:false,
    success: function(response) {
      $("#revicionIncidenciaCapacitacion").val("");
    },
    error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
  });

}


function ActualizarCampoCapacitacionEnAsistencia(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,asistenciaFecha,comentariIncidencia){
  $.ajax({
    type: "POST",
    url: "ajax_UpdateCampoCapacitacionEnAsistencia.php",
    data : {"empleadoEntidadId":empleadoEntidadId,"empleadoConsecutivoId":empleadoConsecutivoId,"empleadoTipoId":empleadoTipoId,"asistenciaFecha":asistenciaFecha,"comentariIncidencia":comentariIncidencia},
    dataType: "json",
    async:false,
    success: function(response) {
    },
    error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
  });

}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////          

//********************************** Se agrega funcion para eliminar el enter en el comentario ******************************************

$("#especifiqueMotivo").keydown(function(e){
  if(e.which==13 || e.which==9){
      swal("Alto","No puede realizar esta acción", "warning"); 
  }
});
//***


//falta cargar los puestos cuando da clic en incidencia especial

</script>
