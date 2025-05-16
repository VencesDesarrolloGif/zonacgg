<div class="container" align="center">
<form class="form-horizontal"  method="post" name='form_asignarUniforme' id="form_asignarUniforme" enctype="multipart/form-data">
  <legend><h3>Asignar Uniforme</h3></legend>  
  <div id="divMensajealmacen"></div>   
  <h3 style="color: red;"><img src="img/alert.png"> TIPO DE ASIGNACIÓN</h3>
     <table>
       <tr>
           <td>
               <div class="chart-container" style="width:2vw">
                <center>
                   <input type="radio" id="siAsigSup" name="siAsigSup" value="">
                   </center>
                   <h4>USO PLANTILLA</h4>
               </div>
           </td>
           <td>
               <div class="chart-container" style="width:2vw">
                   <input type="hidden" id="ESPACIO" name="ESPACIO" value="">
                   <h4></h4>                                        
               </div>
           </td>
            <td>
               <div class="chart-container" style="width:2vw">
                   <input type="hidden" id="ESPACIO2" name="ESPACIO2" value="">
                   <h4></h4>                                        
               </div>
           </td>
           <td>
               <div class="chart-container" style="width:2vw">
                   <input type="radio" id="noAsigSup" name="NoAsigSup" value="">
                   <h4>USO PROPIO</h4>                                        
               </div>
           </td> 
       </tr>      
     </table>
</center><br>
  <div id="fotoEmpleado" style="width:140px;height:133px;border:1px solid;text-align:center;"></div> 
  <br>   
  <table class="table1">
        <tr>
          <td><label class="control-label label " for="nombreEmpleado">Nombre Empleado</label></td>
          <td><input id="nombreEmpleado" name="nombreEmpleado" type="text" class="input-XLarge" readonly /></td>        
        </tr>
        <tr>
          <td><label class="control-label label " for="txtTallaC">Talla Camisa</label></td>
          <td><input id="txtTallaC" name="txtTallaC" type="text" class="input-mini" readonly /></td>        
        </tr>
        <tr>
          <td><label class="control-label label " for="txtTallaP">Talla Pantalón</label></td>
          <td><input id="txtTallaP" name="txtTallaP" type="text" class="input-mini" readonly /></td>        
        </tr>
        <tr>
          <td><label class="control-label label " for="txtNumCalzado">Numero Calzado</label></td>
          <td><input id="txtNumCalzado" name="txtNumCalzado" type="text" class="input-mini" readonly /></td>        
        </tr>
        <tr>
          <td><label class="control-label label " for="txtPuntoServ">Punto de Servicio</label></td>
          <td><input id="txtPuntoServ" name="txtPuntoServ" type="text" class="input-large" readonly /></td>        
        </tr>
        <tr >
          <td><label class="control-label label " for="claveEmpleado">No. de Empleado</label> </td>          
          <td><input type="text" name="txtSearch" id="txtSearch"class="search-query" placeholder="Buscar  (00-0000-00)" aria-describedby="basic-addon2" onkeyup="consultaEmpleadoParaAsignacion();"><img src="img/search.png"></td>
         </tr>
         <tr>
          <td><label class="control-label label " for="selEntidadesAignacion">Entidad (Uniforme)</label></td>
          <td><select id="selEntidadesAignacion" name="selEntidadesAignacion" disabled="true">
            <option value="0">ENTIDAD FEDERATIVA</option>
          </td>
        </tr> 
        <tr>
          <td><label class="control-label label " for="selSucursalAsignacion">Sucursal (Uniforme)</label></td>
          <td><select id="selSucursalAsignacion" name="selSucursalAsignacion" disabled="true">
              <option value="0">SUCURSAL</option>  
          </select></td>
        </tr> 

         <tr>
          <td><label class="control-label label " for="selectTipoM">Tipo de Mercancia</label></td>          
            <td><select id="selectTipoM" name="selectTipoM" disabled="true">
                <option>TIPO MERCANCIA</option>
              <?php
                for($i=0; $i<count($catalogoTiposMercancia); $i++){
                    echo "<option value='". $catalogoTiposMercancia[$i]["idTipoMercancia"]."'>". $catalogoTiposMercancia[$i]["descripcionTipoMercancia"] ." </option>";
                   }
              ?>
                </select>
            </td>
        </tr>
        <tr>
          <td><label class="control-label label " for="txtUniforme">Uniforme</label></td>
          <td><input disabled="true" id="txtUniforme" name="txtUniforme" type="text" class="input-small" />
          <select disabled="true" id="selectUniforme" name="selectUniforme" onchange="cambioUniforme()" class="input-medium">
            <option value="0">UNIFORME</option>
          </select></td>
        </tr>
        <tr>
          <td><label class="control-label label " for="stockUniforme">Stock</label></td>
          <td><input type="text" id="stockUniforme" name="stockUniforme" readonly class="input-mini"></td>
        </tr> 
        <tr>
          <td><label class="control-label label " for="selectCantidad">Cantidad a asignar</label></td>
          <td><select id="selectCantidad" name="selectCantidad" class="input-mini" disabled="true">
              <option>1</option>  
              <option>2</option>
          </select></td>  
        </tr>
        <tr>
          <td><label class="control-label label " for="inpCostoCalzado">Costo "TOTAL" del calzado</label></td>
          <td><input type="text" id="inpCostoCalzado" name="inpCostoCalzado" readonly="" placeholder="COSTO TOTAL DEL CALZADO A ASIGNAR" title="RECUERDA EL COSTO ES POR EL TOTAL DE LA CANTIDAD ELEGIDA"></td>
        </tr> 
         <tr>
          <td></td>
          <td><button id="AgregarUniALista" name="AgregarUniALista" class="btn btn-primary " type="button" disabled="true"> 
              <span class="glyphicon glyphicon-floppy-save"></span>Agregar Uniforme</button>
              <!--<button id="botonFAlta" class='btn btn-warning' type='button'  disabled="true"> <img src='img/hojaDatos.png' width='20%'>Formato Alta</button>-->
          </td>
        </tr> 
        <tr>
          <td></td>
          <td><button type='button' class='btn btn-success' id='btnAsignarUniforme' name='btnAsignarUniforme' disabled="true">Asignar Uniforme</button></td>
        </tr> 
      <input type="hidden" class="input-medium" id="numempleadoFirmaAsignacionhidden" name="numempleadoFirmaAsignacionhidden" readonly="true">
      <input type="hidden" class="input-medium" id="NombreSolicitanteAsignacion" name="NombreSolicitanteAsignacion" readonly="true">
      <input type="hidden" class="input-medium" id="FirmaInternaAsignacion" name="FirmaInternaAsignacion" readonly="true">
      <input type="hidden" class="input-medium" id="FirmaIntenaEmpleadoQueRecibe" name="FirmaIntenaEmpleadoQueRecibe" readonly="true">
      <input type="hidden" class="input-medium" id="idTipoPuesto" name="idTipoPuesto" readonly="true">
   </table>
   <br>
   <div id="divTablaVistaUni" name="divTablaVistaUni">
    <form enctype='multipart/form-data' id='formAlta'>
    <table id='tablaVistaUni' class='table table-bordered' style="display: none;">
      <thead>
        <th>N°</th>
        <th>TIPO UNIFORME</th>
        <th>UNIFORME</th>
        <th>CANTIDAD</th>
        <th>ENTIDAD</th>
      </thead>
    </table>
   </form>
  </div>
</form>
</div>
<div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaElectronicaAsignacion" id="modalFirmaElectronicaAsignacion" data-backdrop="static">
  <div id="errorModalFirmaInternaAsignacion"></div>
   <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" align="center"><img src="img/alert.png">Escribe tu numero de empleado y la contraseña que generaste !!</h3>
      </div>
      <div class="modal-body" align="center">
        <h5>ADMINISTRATIVO</h5>
      </div>
      <div class="modal-body" align="center">
        <span class="add-on"># Empleado</span>
        <input type="text" id="NumEmpModalBajaAsignacion" class="input-medium" name="NumEmpModalBajaAsignacion" placeholder="00-0000-00 Ó 00-00000-00">
        <span class="add-on">Contraseña</span>
        <input type="password" id="constraseniaFirmaAsignacion" class="input-xlarge"name="constraseniaFirmaAsignacion" title="El campo identifica entre mayusculas y minusculas favor de considerarlo">
      </div>
      <div class="modal-body" align="center">
        <button type="button" id="btnFirmarDoc" name="btnFirmarDoc" style="display: none;" onclick="RevisarFirmaInternaAsignacion();" class="btn btn-primary" >Firmar</button>
        <button type="button" id="btnCancelarFirma" name="btnCancelarFirma"onclick="cancelarFirmaAsignacion();" class="btn btn-danger" >Cancelar</button>
      </div>      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaElementoAsignacion" id="modalFirmaElementoAsignacion" data-backdrop="static">
  <div id="errormodalFirmaElementoAsignacion"></div>
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
        <input type="password" maxlength="10" id="constraseniaFirmaElementoAsignacion" class="input-xlarge"name="constraseniaFirmaElementoAsignacion" title="El campo identifica entre mayusculas y minusculas favor de considerarlo">
      </div>
      <div class="modal-body" id="ActivarActualizarCuenta" align="center" style="display: none;">
          <p><a  href="form_activacionCuentaUsuario.php" target="_blank">Activar/Actualizar Cuenta</a></p>
      </div>
      <div class="modal-body" align="center">
        <button type="button" id="btnFirmarDocGuardia" name="btnFirmarDocGuardia" style="display: none;" onclick="asignarUniforme1(0);" class="btn btn-primary" >Continuar</button>
        <button type="button" id="btnCancelarFirma" name="btnCancelarFirma"onclick="cancelarFirmaEmpleadoAsignacion();" class="btn btn-danger" >Cancelar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////// modal Firma Guardia Administrativo////////////////////////////////////////////////////////////////// -->
<div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaElementoAsignacionAdmin" id="modalFirmaElementoAsignacionAdmin" data-backdrop="static"> <!-- modal FirmaBajaEmpleado -->
  <div id="errormodalFirmaElementoAsignacionAdmin"></div>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" align="center"><img src="img/alert.png">Escribe tu numero de empleado y la contraseña que generaste !!</h3>
      </div>
      <div class="modal-body" align="center">
        <h5>GUARDIA</h5>
      </div>
      <div class="modal-body" align="center">
        <span class="add-on"># Empleado</span>
        <input type="text" id="NumEmpModalBajaAsignacionAdmin" class="input-medium" name="NumEmpModalBajaAsignacionAdmin" placeholder="00-0000-00 Ó 00-00000-00">
        <span class="add-on">Contraseña</span>
        <input type="password" id="constraseniaFirmaAsignacionAdmin" class="input-xlarge"name="constraseniaFirmaAsignacionAdmin" title="El campo identifica entre mayusculas y minusculas favor de considerarlo">
      </div>
      <div class="modal-body" align="center">
        <button type="button" id="btnFirmarAsignacionAdmin" name="btnFirmarAsignacionAdmin" style="display: none;" onclick="RevisarFirmaInternaAsigAdmin();" class="btn btn-primary" >Continuar</button>
        <button type="button" id="btnCancelarFirmaAsignacionAdmin" name="btnCancelarFirmaAsignacionAdmin"onclick="cancelarFirmaIntAsigAdmin();" class="btn btn-danger" >Cancelar</button>
      </div>      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div> <!-- FIN modal FirmaBajaEmpleado -->

<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<script type="text/javascript">

$("#noAsigSup").change(function(){
  if($('#noAsigSup').is(":checked")){
     $("#noAsigSup").val(1);
     $("#siAsigSup").prop("checked", false);
     $("#siAsigSup").val(0);
  }else{
         $("#noAsigSup").val(0);
  }
});

$("#siAsigSup").change(function(){
  if($('#siAsigSup').is(":checked")){
     $("#siAsigSup").val(1);
     $("#noAsigSup").prop("checked", false);
     $("#noAsigSup").val(0);
  }else{
     $("#siAsigSup").val(0);
  }
});

function consultaEmpleadoParaAsignacion(){
  
  limpiarFormulario();
  var txtSearch = $("#txtSearch").val ();
  var expreg = /^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/;
  var expreg1 = /^[0-9]{2}\-[0-9]{5}\-[0-9]{2}/;
  var b = $("#tablaVistaUni tr").length;//cuenta las filas como solo es el titulo vale 1

  if(expreg.test(txtSearch) || expreg1.test(txtSearch)){
    waitingDialog.show();
     var numeroEmpleado = $("#txtSearch").val();    
     consultaEmpleadoAsignacion(numeroEmpleado);
    }
  if(b >= 2){
     for(var i = 0; i < b-1; i++){
         var tablaVistaUni = document.getElementById("tablaVistaUni").deleteRow(1);  
        }
    } 
}

function consultaEmpleadoAsignacion (numeroEmpleado){

    var numeroEmpleado1 = numeroEmpleado;
    $.ajax({
            type: "POST",
            url: "ajax_obtenerEmpleadoPorId.php",
            data:{"numeroEmpleado":numeroEmpleado1},
            dataType: "json",
            success: function(response) {
              if (response.status == "success"){
                var empleadoEncontrado = response.empleado;
                if(empleadoEncontrado.length == 0){
                  waitingDialog.hide();
                  mensaje="No existe Número de empleado";
                  cargarmensajeerrorAlmacen(mensaje,"error");
                  $("#AgregarUniALista").prop("disabled",true);
                  $("#selectTipoM").val("TIPO MERCANCIA");
                  $("#selectTipoM").prop("disabled",true);
                  $("#selectUniforme").prop("disabled",true);
                  $("#txtUniforme").prop("disabled",true);
                  $("#selectCantidad").prop("disabled",true);
                  $("#selEntidadesAignacion").prop("disabled",true);
                  $("#selSucursalAsignacion").prop("disabled",true);
                  //$("#botonFAlta").prop("disabled",true);
                }else{                                          
                      for(var i = 0; i < empleadoEncontrado.length; i++ ){
                          var empleadoEntidad = empleadoEncontrado[i].entidadFederativaId;
                          var empleadoConsecutivo = empleadoEncontrado[i].empleadoConsecutivoId;
                          var empleadoCategoria = empleadoEncontrado[i].empleadoCategoriaId;
                          var empleadoApellidoPaterno= empleadoEncontrado[i].apellidoPaterno;
                          var empleadoApellidoMaterno= empleadoEncontrado[i].apellidoMaterno;
                          var nombreEmpleado= empleadoEncontrado[i].nombreEmpleado;
                          var estatusEmpleado= empleadoEncontrado[i].empleadoEstatusId;
                          var tallaCamisa=empleadoEncontrado[i].tallaCamisa;
                          var tallaPantalon=empleadoEncontrado[i].tallaPantalon;
                          var numCalzado=empleadoEncontrado[i].numCalzado;
                          var puntoServicio=empleadoEncontrado[i].puntoServicio;
                          var foto = empleadoEncontrado[i].fotoEmpleado;
                          var idTipoPuesto11 = empleadoEncontrado[i].idTipoPuesto;
                          $("#idTipoPuesto").val(idTipoPuesto11);
                          
                          if(estatusEmpleado!=0){
                            $("#fotoEmpleado").html ("<img src='thumbs/" + foto + "' />");
                            $("#nombreEmpleado").val(nombreEmpleado+" "+empleadoApellidoPaterno+" "+empleadoApellidoMaterno);
                            $("#txtTallaC").val(tallaCamisa);
                            $("#txtTallaP").val(tallaPantalon);
                            $("#txtNumCalzado").val(numCalzado);
                            $("#txtPuntoServ").val(puntoServicio);
                            // $("#selectTipoM").prop("disabled",false);
                            // $("#selectUniforme").prop("disabled",false);
                            // $("#txtUniforme").prop("disabled",false);
                            // $("#selectCantidad").prop("disabled",false);
                            $("#selEntidadesAignacion").prop("disabled",false);
                            // $("#selSucursalAsignacion").prop("disabled",false);
                            waitingDialog.hide();
                          }else{
                              mensaje="Empleado dado de baja";
                              cargarmensajeerrorAlmacen(mensaje,"error");
                              $("#AgregarUniALista").prop("disabled",true);
                              $("#selectTipoM").prop("disabled",true);
                              $("#selectUniforme").prop("disabled",true);
                              $("#txtUniforme").prop("disabled",true);
                              $("#selectCantidad").prop("disabled",true);
                              $("#selEntidadesAignacion").prop("disabled",true);
                              $("#selSucursalAsignacion").prop("disabled",true);
                              // $("#botonFAlta").prop("disabled",true);
                              waitingDialog.hide();
                          }
                      }//FOR 
                } //else
                cargarSelectorEntidadesAsignacion();
                eliminarTablaTemporal(); 
                waitingDialog.hide();                   
              }else if (response.status == "error"){
                          alert(response.error);
                          waitingDialog.hide();
              }
            },error: function (response){
                console.log (response);
                waitingDialog.hide();
            }
        });
}

let valorAnterior;

$("#selEntidadesAignacion").focus(function() {
  valorAnterior = $(this).val(); // Almacena el valor actual antes del cambio
});

$("#selEntidadesAignacion").change(function(){
  const idEntidadElegida=$("#selEntidadesAignacion").val();
  if (valorAnterior!=0){//trae una entidad
    var numUniformesAsignadosTmp = $("#tablaVistaUni tr").length - 1; // Resta 1 para excluir la fila de encabezado
    if(numUniformesAsignadosTmp!=0){
      Swal.fire({
        title: '¿Deseas cambiar la entidad?',
        text: 'Al cambiar se eliminará toda la información cargada previamente.',
        icon: 'warning',
        showCancelButton: true, // Muestra el botón "No"
        confirmButtonText: 'Sí',
        cancelButtonText: 'No',
        reverseButtons: true, // Invierte los botones, haciendo que el "No" sea el primero
      }).then((result) => {
        if (result.isConfirmed) {
          // Si el usuario hace clic en "Sí", ejecuta la función limpiarFormulario
          $("#selSucursalAsignacion").val(0);
          // limpiarDatosXcambioEntoSuc();
          consultaEmpleadoParaAsignacion();
        }else {
          $("#selEntidadesAignacion").val(valorAnterior);
        }
      });
    }//uniformes asignados
    else{
      if(idEntidadElegida==0){
       $("#selSucursalAsignacion").val(0);
       $("#selSucursalAsignacion").prop("disabled",true);
       limpiarDatosXcambioEntoSuc();
      }else{
        consultaSucursalesAsignacion(idEntidadElegida);
      }
    }
  }else{
    $("#selSucursalAsignacion").prop("disabled",false);
    consultaSucursalesAsignacion(idEntidadElegida);
  }
});

function consultaSucursalesAsignacion(EntidadSeleccionada){

  $.ajax({
    type: "POST",
    url: "ajax_SucursalesXent.php",
    data:{"EntidadSeleccionada":EntidadSeleccionada},
    dataType: "json",
    success: function(response) {
      console.log(response);
      $("#stockUniforme").val(""); 
      $("#selSucursalAsignacion").empty(); 
      $('#selSucursalAsignacion').append('<option value="0">SUCURSAL</option>');
      if(response.status == "success"){
      $("#selSucursalAsignacion").prop("disabled",false);
        for(var i = 0; i < response.datos.length; i++){
             $('#selSucursalAsignacion').append('<option value="' + (response.datos[i].idSucursalI) + '">' + response.datos[i].nombreSucursal + '</option>');
        }
      }else{
            alert("Error Al Cargar Las Entidades");
      }
    },
    error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
  });
}

let valorAnteriorSucursal;

$("#selSucursalAsignacion").focus(function() {
  valorAnteriorSucursal = $(this).val(); // Almacena el valor actual antes del cambio
});

$("#selSucursalAsignacion").change(function(){

  const idSucursalElegida=$("#selSucursalAsignacion").val();

  if (valorAnteriorSucursal!=0){//trae una entidad
    var numUniformesAsignadosTmp = $("#tablaVistaUni tr").length - 1; // Resta 1 para excluir la fila de encabezado

    if(numUniformesAsignadosTmp!=0){
      Swal.fire({
         title: '¿Deseas cambiar la sucursal?',
         text: 'Al cambiar se eliminará toda la información cargada previamente.',
         icon: 'warning',
         showCancelButton: true, // Muestra el botón "No"
         confirmButtonText: 'Sí',
         cancelButtonText: 'No',
         reverseButtons: true, // Invierte los botones, haciendo que el "No" sea el primero
       }).then((result) => {
         if (result.isConfirmed){
           $("#btnAsignarUniforme").prop("disabled",true);
           $("#selSucursalAsignacion").val(0);
           $("#AgregarUniALista").prop("disabled",true);
           $("#selectTipoM").val("TIPO MERCANCIA");
           $("#selectUniforme").val(0);
           $("#txtUniforme").val(0);
           $("#inpCostoCalzado").val(0);
           $("#stockUniforme").val(0);
           $("#tablaVistaUni").hide();
           var b = $("#tablaVistaUni tr").length;//cuenta las filas como solo es el titulo vale 1
           if(b >= 2){
              for(var i = 0; i < b-1; i++){
                  var tablaVistaUni = document.getElementById("tablaVistaUni").deleteRow(1);  
                 }
             } 
         }else {
           $("#selSucursalAsignacion").val(valorAnteriorSucursal);
         }
      });
    }//if uniformes asignados
    else{//no hay uniformes entregados
         $("#selectUniforme").empty(); $('#selectUniforme').append('<option value="0">UNIFORME</option>');
         $("#selectUniforme").prop("disabled",true);
         $("#txtUniforme").val("");
         $("#stockUniforme").val("0");
         $("#inpCostoCalzado").val("");
         $("#inpCostoCalzado").prop("readonly",true);
         $('#selectTipoM').val("TIPO MERCANCIA");
      if (idSucursalElegida==0){
         $("#selectTipoM").prop("disabled",true);
      }else{
        $("#selectTipoM").prop("disabled",false);
      }
    }
  }else{
    $("#selectTipoM").prop("disabled",false);
  }
});

$("#selectTipoM").change(function(){
  $("#AgregarUniALista").prop("disabled",true);
  $("#stockUniforme").val(0);

  const tipoM=$("#selectTipoM").val();

  if(tipoM=='5'){
     $("#inpCostoCalzado").prop("readonly", false);
  }else{
        $("#inpCostoCalzado").val(0);
        $("#inpCostoCalzado").prop("readonly", true);
  }

  if(tipoM!=0){
    $.ajax({
          type: "POST",
          url: "ajax_getUniformesByTipo.php",
          data:{"tipoMerca":tipoM},
          dataType: "json",
           success: function(response){
              var mensaje=response.error;
              if(response.status == "success"){
                  var uniformes=response.listaUni;
                  //alert(uniformes.length);
                  $('#selectUniforme').empty().append('<option value="0" selected="selected">UNIFORME</option>');
                  $("#txtUniforme").val("");
                  $.each(uniformes, function(i){
                          $('#selectUniforme').append("<option value='"+uniformes[i].idTipoUniforme+"' title='"+uniformes[i].descripcionTipo+"'>"+uniformes[i].codigoUniforme+"</option>");
                        });
                $('#selectUniforme').focus();                  
                $("#selectUniforme").prop("disabled",false);
              }else{
                    cargarmensajeerrorAlmacen(mensaje,"error");
                   }
           },
           error: function(jqXHR, textStatus, errorThrown){
                alert(jqXHR.responseText); 
          }
      });
  }else{

  }
});

$("#selectUniforme").change(function(){
  var uniformeSeleccionado = $("#selectUniforme").val();
  $("#AgregarUniALista").prop("disabled",true);

  if(uniformeSeleccionado==0){
    $("#stockUniforme").val(0);
  }else{
       consultaStock(uniformeSeleccionado);
  }
});

function consultaStock(uniformeSeleccionado){

  var EntidadSeleccionada  = $("#selEntidadesAignacion").val();
  var sucursalSeleccionada = $("#selSucursalAsignacion").val();
  $.ajax({
    type: "POST",
    url: "ajax_ConsultaStock.php",
    data:{"uniformeSeleccionado":uniformeSeleccionado, "EntidadSeleccionada":EntidadSeleccionada, "sucursalSeleccionada":sucursalSeleccionada},
    dataType: "json",
    success: function(response) {
      $("#stockUniforme").val(""); 
      if(response.status == "success"){
         var cantidadTotal=response.datos;
         $('#stockUniforme').val(cantidadTotal);
          if(cantidadTotal==0){
             $("#AgregarUniALista").prop("disabled",true);
             $("#selectCantidad").prop("disabled",true);
             }else{
                   $("#AgregarUniALista").prop("disabled",false);
                   $("#selectCantidad").prop("disabled",false);
                  }
      }else{
            mensaje="Error Al Cargar Las Entidades";
            cargarmensajeerrorAlmacen(mensaje,"error");
           }
    },
    error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
  });
}

$("#AgregarUniALista").click(function (){
 var tipoMerca= $('select[name="selectTipoM"] option:selected').text(); 
 var idTipoMercan=$("#selectTipoM").val();
 var claveUniforme=$("#txtUniforme").val();
 var cantidadStock=$("#stockUniforme").val();
 var cantidadElegida=$("#selectCantidad").val();
 var entidadUsuario = $("#selEntidadesAignacion").val();
 var sucursalSeleccionada = $("#selSucursalAsignacion").val();
 var nombreEmpleado=$("#nombreEmpleado").val();    
 var idTipoUniforme=obtenerTipoUniforme(claveUniforme);        
 var resta = cantidadStock - cantidadElegida;
 var costoIngresado1=$("#inpCostoCalzado").val();
 var costoIngresado11 = (costoIngresado1*1);
 var costoCondecimal=(costoIngresado11).toFixed(2.5);
 if(nombreEmpleado == ""){
    var mensaje="No hay empleado para asignar";
    cargarmensajeerrorAlmacen(mensaje,"error");
    waitingDialog.hide(); 
   }else if(claveUniforme == ""){
            var mensaje="Seleccione o introduzca el tipo de uniforme";
            cargarmensajeerrorAlmacen(mensaje,"error");
            waitingDialog.hide(); 
           }else if(idTipoUniforme == 0 ){
                    var mensaje="Tipo de uniforme invalido";
                    cargarmensajeerrorAlmacen(mensaje,"error");
                    waitingDialog.hide(); 
                   }else if(entidadUsuario =="" || entidadUsuario =="null" || entidadUsuario =="NULL" || entidadUsuario ==null || entidadUsuario =="0"){
                             var mensaje="Seleccione La Entidad Del Uniforme";
                             cargarmensajeerrorAlmacen(mensaje,"error");
                             waitingDialog.hide();
                            }else if(sucursalSeleccionada==0){
                                     var mensaje="Seleccione La Sucursal Del Uniforme"; 
                                     cargarmensajeerrorAlmacen(mensaje,"error");
                                      waitingDialog.hide(); 
                            }else if(resta < "0"){
                                     var mensaje="No hay en existencia la cantidad de uniformes seleccionados"; 
                                     cargarmensajeerrorAlmacen(mensaje,"error");
                                      waitingDialog.hide(); 
                                    }else if ((!/^([0-9])*$/.test(costoCondecimal)) && (!/^(([0-9]+)?(.[0-9]+)?)$/.test(costoCondecimal))){//
                                        var mensaje="Ingrese un costo valido";
                                        cargarmensajeerrorAlmacen(mensaje,"error");
                                        }else if ((costoIngresado1=='0' || costoIngresado1=='') && idTipoMercan=='5'){//
                                        var mensaje="Ingrese el costo del calzado";
                                        cargarmensajeerrorAlmacen(mensaje,"error");     
 }else{
       $("#btnAsignarUniforme").prop("disabled",false);
       waitingDialog.show();
       insertarTablaTemporal(idTipoUniforme,cantidadElegida,entidadUsuario,tipoMerca,idTipoMercan,claveUniforme,costoIngresado1);
       $("#docoumentoAlta").prop("disabled",false);
      }
  waitingDialog.hide();
});

function insertarTablaTemporal(idTipoUniforme,cantidadElegida,entidadUsuario,tipoMerca,idTipoMercan,claveUniforme,costoIngresado1){//se inserta para obtener los datos y mostarlos en el pdf

 var tipoMerca= $('select[name="selectTipoM"] option:selected').text(); 
 var idTipoMercan=$("#selectTipoM").val();
 var claveUniforme=$("#txtUniforme").val();
 var nombreEmpleado=$("#nombreEmpleado").val();    
 var numeroEmpleado =$("#txtSearch").val();
 var sucursalSeleccionada = $("#selSucursalAsignacion").val();
$.ajax({
    type: "POST",
    url: "ajax_insertarAsignaUniTemporales.php",
    data:{"numeroEmpleado":numeroEmpleado,"idTipoUniforme":idTipoUniforme,"cantidadElegida":cantidadElegida,"entidadUsuario":entidadUsuario,"idTipoMercan":idTipoMercan,"costoIngresado1":costoIngresado1, "sucursalSeleccionada":sucursalSeleccionada},
    dataType: "json",
    success: function(response){
           if(response.status == "success"){
              waitingDialog.hide();
              $("#tablaVistaUni").show(); 
              var b = $("#tablaVistaUni tr").length;//cuenta las filas como solo es el titulo vale 1
              var table = document.getElementById("tablaVistaUni");
              var row = table.insertRow(b);
              var contfila = row.insertCell(0);
              var cell1 = row.insertCell(1);
              var cell2 = row.insertCell(2);
              var cell3 = row.insertCell(3);
              var cell4 = row.insertCell(4);

              for(var i = 0; i < b; i++){
                  contfila.innerHTML = " <td > " + (i + 1) + " </td>"; //hace el conteo del autoincrement
                  cell1.innerHTML = "<input class='span2' type='text' readonly id='inpTipoMerca" + i + "'><input class='span2' id='inpIDTipoMerca" + i + "' type='hidden' readonly>   ";// el "+i" es para que tenga id dinamico
                  cell2.innerHTML = "<input class='span2' type='text' readonly id='inpclaveUniforme" + i + "'>";
                  cell3.innerHTML = "<input class='span2' type='text' readonly id='inpCantidad" + i + "'>";
                  cell4.innerHTML = "<input class='span2' type='text' readonly id='inpEntidad" + i + "'>";
                 }
                  $("#inpTipoMerca"+(b-1)).val(tipoMerca);
                  $("#inpIDTipoMerca"+(b-1)).val(idTipoMercan);
                  $("#inpclaveUniforme"+(b-1)).val(claveUniforme);
                  $("#inpCantidad"+(b-1)).val(cantidadElegida);
                  $("#inpEntidad"+(b-1)).val(entidadUsuario);
             }else{
                   var mensaje=response.error;
                   cargarmensajeerrorAlmacen(mensaje,"error");
                   waitingDialog.hide();
                  //var eliminarCol = document.getElementById("tablaVistaUni").deleteRow(1);  
                  }
    },
    error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
  });
}

function cargarSelectorEntidadesAsignacion(){
    $.ajax({
            type: "POST",
            url: "ajax_getEntidadesUsuario.php",
            dataType: "json",
            success: function(response) {
            $("#selEntidadesAignacion").empty(); 
            $('#selEntidadesAignacion').append('<option value="0">ENTIDAD FEDERATIVA</option>');
        if(response.status == "success"){
           for(var i = 0; i < response.datos.length; i++){
               $('#selEntidadesAignacion').append('<option value="' + (response.datos[i].idEntidadFederativa) + '">' + response.datos[i].nombreEntidadFederativa + '</option>');
              }
          }else{
                alert("Error Al Cargar Las Entidades");
               }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }

function eliminarTablaTemporal(){
    $.ajax({
      type: "POST",
      url: "ajax_eliminarAsignaUniTemporales.php",
      dataType: "json",
      success: function(response) {
           /*  if(response.status == "success"){alert("borradoBien")}*/
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
}

function obtenerTipoUniforme(txtMercancia){        
  var totalOpciones=document.form_asignarUniforme.selectUniforme.length;
  for(var i = 1; i < totalOpciones; i++){
      var opcionUniforme=document.form_asignarUniforme.selectUniforme.options[i].text;            
      if(txtMercancia == opcionUniforme){
         var valor=document.form_asignarUniforme.selectUniforme.options[i].value;                
         return valor;
        }
    }
  return 0;
}

function cambioUniforme(){    
  var select=document.getElementById("selectUniforme");
  var opcion=select.selectedIndex;
  var nombreTipoUniforme=select.options[opcion].text; 
  if(opcion!=0)         
        $("#txtUniforme").val(nombreTipoUniforme);
    else
        $("#txtUniforme").val("");
}

$("#btnAsignarUniforme").click(function(){
     
  var valorSI= $("#siAsigSup").val();
  var valorNO= $("#noAsigSup").val();
  if((valorSI== '' || valorSI== 'NULL' || valorSI== 'null' || valorSI== null) || valorNO== '' || valorNO== 'NULL' || valorNO== 'null' || valorNO== null){
     mensaje="Responda la pregunta de asignación";
              cargarmensajeerrorAlmacen(mensaje,"error");
   }else{
        $("#modalFirmaElectronicaAsignacion").modal();
        }
});

function asignarUniforme1(opcion){
//revisar el ajax que inserte en historico
  var asignacionSupervisor = $("#siAsigSup").val();
  var numempleadoFirmaAsignacion = $("#numempleadoFirmaAsignacionhidden").val();
  var NombreSolicitanteAsignacion = $("#NombreSolicitanteAsignacion").val();
  var FirmaInternaAsignacion = $("#FirmaInternaAsignacion").val();
  var FirmaIntenaEmpleadoQueRecibe = $("#FirmaIntenaEmpleadoQueRecibe").val();
  var contrasenia = $("#constraseniaFirmaElementoAsignacion").val();
  var NombreEmpleado = $("#nombreEmpleado").val();
  var NumeroEmpleado = $("#txtSearch").val();
  //var costoIngresado1=$("#inpCostoCalzado").val();
  if(contrasenia=="" && opcion=="0"){
    cargaerroresFirmaInternaElementoAsignacion("Ingrese la contraseña generada al activar la cuenta del elemento en la plataforma de Gif Segurdad Privda");
  }else{
    $.ajax({
      type: "POST",
      url: "ajax_asignarUniforme.php",
      data:{"numempleadoFirmaAsignacion":numempleadoFirmaAsignacion,"NombreSolicitanteAsignacion":NombreSolicitanteAsignacion,"FirmaInternaAsignacion":FirmaInternaAsignacion,"FirmaIntenaEmpleadoQueRecibe":FirmaIntenaEmpleadoQueRecibe,"NombreEmpleado":NombreEmpleado,"NumeroEmpleado":NumeroEmpleado,"asignacionSupervisor":asignacionSupervisor},
      dataType: "json",
       success: function(response) {
          if(response.status == "success"){
             waitingDialog.hide();
             var mensaje=response.message;
             cargarmensajeerrorAlmacen(mensaje,response.status);
             limpiarFormulario();
             $("#txtSearch").val("");
             $("#modalFirmaElementoAsignacion").modal("hide");
             $("#constraseniaFirmaElementoAsignacion").val("");
             $("#siAsigSup").val("");
             $("#noAsigSup").val("");
             $("#siAsigSup").prop("checked", false);
             $("#noAsigSup").prop("checked", false);
            }else{
              var mensaje=response.message;
              cargaerroresFirmaInternaElementoAsignacion(mensaje);  
              waitingDialog.hide();
                 }
       },
       error: function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText); 
             waitingDialog.hide();
      }
    }); 
  }
}

$("#NumEmpModalBajaAsignacion").keyup(function (){

 var NumEmpModalBaja = $("#NumEmpModalBajaAsignacion").val();
 var expreg = /^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/;
 var expreg1 = /^[0-9]{2}\-[0-9]{5}\-[0-9]{2}/;
 
 if(expreg.test(NumEmpModalBaja) || expreg1.test(NumEmpModalBaja)){
    consultaEmpleadoFirmaInternaBajaAsignacion(NumEmpModalBaja);
  }else{
    //cargaerroresFirmaInternaBajaAsignacion("El Formato Del Numero De Empleado Es Incorrecto");
    $("#constraseniaFirmaAsignacion").val("");
    $("#btnFirmarDoc").hide();
  }
});

function consultaEmpleadoFirmaInternaBajaAsignacion(numeroEmpleado){
  $.ajax({
    type: "POST",
    url: "ajax_obtenerEmpleadoPorIdFirmaBaja.php",
    data:{"numeroEmpleado":numeroEmpleado},
    dataType: "json",
    success: function(response) {
      if (response.status == "success"){
        var empleadoExtiste = response["empleado"].length;
        if(empleadoExtiste=="0"){
          cargaerroresFirmaInternaBajaAsignacion("El Empleado No Existe En La Base De Registro De Firmas Favor De Verificar");
          $("#NumEmpModalBajaAsignacion").val("");
          $("#btnFirmarDoc").hide();
        }else {
          var EstatusFirmaInterna = response.empleado[0].EstatusFirmaInterna;
          if(EstatusFirmaInterna=="0"){
            cargaerroresFirmaInternaBajaAsignacion("Esta Firma Fue Dada De Baja Favor de solicitar Otra o Comunicarse Con RH"); 
            $("#NumEmpModalBajaAsignacion").val("");
            $("#btnFirmarDoc").hide();
          }else{
            $("#btnFirmarDoc").show();
          }
        }
      }else{
        cargaerroresFirmaInternaBajaAsignacion(response.menssaje); 
        $("#NumEmpModalBajaAsignacion").val("");
        $("#btnFirmarDoc").hide();
      }
    },error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }

  });
}

function RevisarFirmaInternaAsignacion(){

  var NumEmpModalBaja = $("#NumEmpModalBajaAsignacion").val();
  var constraseniaFirma = $("#constraseniaFirmaAsignacion").val();
 
 if(NumEmpModalBaja==""){
   cargaerroresFirmaInternaBajaAsignacion("El numero de empleado no puede estar vaacio");
  }else if(constraseniaFirma==""){
     cargaerroresFirmaInternaBajaAsignacion("Escriba la contraseña para continuar");
  }else{
    $.ajax({
      type: "POST",
      url: "ajax_getFirmaSolicitada.php",
      data: {"NumEmpModalBaja":NumEmpModalBaja,"constraseniaFirma":constraseniaFirma},
      dataType: "json",
    success: function(response) {
      if (response.status == "success"){
        var RespuestaLargo = response["datos"].length;
        if(RespuestaLargo == "0"){
          cargaerroresFirmaInternaBajaAsignacion("La Contraseña ingresada es incorrecta favor de escribrla exactamente como la ingreso en el registro");
        }else{
              var idTipoPuesto1 = $("#idTipoPuesto").val();
              var nombre = response.datos["0"].nombreEmpleado + " " + response.datos["0"].apellidoPaterno + " " + response.datos["0"].apellidoMaterno;
              var contraseniaInsertadaCifrada =response.datos["0"].ContraseniaFirma;
              $("#numempleadoFirmaAsignacionhidden").val(NumEmpModalBaja);
              $("#NombreSolicitanteAsignacion").val(nombre);
              $("#FirmaInternaAsignacion").val(contraseniaInsertadaCifrada);
              $("#modalFirmaElectronicaAsignacion").modal("hide");
              
              $("#NumEmpModalBajaAsignacion").val("");
              $("#constraseniaFirmaAsignacion").val("");
              if(idTipoPuesto1 == "02"){
                $("#NumEmpModalBajaAsignacionAdmin").val("");
                $("#constraseniaFirmaAsignacionAdmin").val("");
                $("#modalFirmaElementoAsignacionAdmin").modal();
                $("#btnFirmarAsignacionAdmin").hide();
              }else{
                $("#modalFirmaElementoAsignacion").modal();
                $("#constraseniaFirmaElementoAsignacion").val("");
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

function cancelarFirmaAsignacion(){
  $("#modalFirmaElectronicaAsignacion").modal("hide");
  $("#NumEmpModalBajaAsignacion").val("");
  $("#constraseniaFirmaAsignacion").val("");
}

function cargaerroresFirmaInternaBajaAsignacion(mensaje){
  $('#errorModalFirmaInternaAsignacion1').fadeIn();
  msjerrorbaja="<div id='errorModalFirmaInternaAsignacion1' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errorModalFirmaInternaAsignacion").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errorModalFirmaInternaAsignacion1').delay(4000).fadeOut('slow'); 
}

function cancelarFirmaEmpleadoAsignacion(){
  $("#modalFirmaElementoAsignacion").modal("hide");
  $("#modalFirmaElectronicaAsignacion").modal();
  $("#constraseniaFirmaElementoAsignacion").val("");
}

$("#constraseniaFirmaElementoAsignacion").blur(function (){
  $("#btnFirmarDocGuardia").hide();
  var contrasenia = $("#constraseniaFirmaElementoAsignacion").val();
  var numEmpleado = $("#txtSearch").val();
  $.ajax({
    type: "POST",
    url: "ajax_obtenercontraseniaEmpASignacion.php",
    data:{"contrasenia":contrasenia,"numEmpleado":numEmpleado},
    dataType: "json",
    success: function(response) {
      if (response.status == "success"){
        var FirmaEmp = response.empleado["0"].contrasenia;
        $("#FirmaIntenaEmpleadoQueRecibe").val(FirmaEmp);
        $("#ActivarActualizarCuenta").hide();
        $("#btnFirmarDocGuardia").show();
      }else{
        cargaerroresFirmaInternaElementoAsignacion(response.menssaje); 
        $("#ActivarActualizarCuenta").show();
        $("#constraseniaFirmaElementoAsignacion").val("");
        $("#btnFirmarDocGuardia").hide();
      }
    },error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }

  });
});

function cargaerroresFirmaInternaElementoAsignacion(mensaje){
  $('#errormodalFirmaElementoAsignacion1').fadeIn();
  msjerrorbaja="<div id='errormodalFirmaElementoAsignacion1' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errormodalFirmaElementoAsignacion").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errormodalFirmaElementoAsignacion1').delay(4000).fadeOut('slow'); 
}
//////////////////////////////////////////////// Modal Firma Recepcion cuando el empleado es administrativo ////////////////////////////////////////////////

$("#NumEmpModalBajaAsignacionAdmin").keyup(function (){

 var NumEmpModalBajaRh = $("#NumEmpModalBajaAsignacionAdmin").val();
 var expreg = /^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/;
 var expreg1 = /^[0-9]{2}\-[0-9]{5}\-[0-9]{2}/;
 
 if(expreg.test(NumEmpModalBajaRh) || expreg1.test(NumEmpModalBajaRh)){
    consultaEmpleadoFirmaAsignacionAdmin(NumEmpModalBajaRh);
  }else{
   // cargaerroresFirmaAsigAdmin("El Formato Del Numero De Empleado Es Incorrecto");
    $("#constraseniaFirmaAsignacionAdmin").val("");
    $("#btnFirmarAsignacionAdmin").hide();
  }
});

function consultaEmpleadoFirmaAsignacionAdmin (numeroEmpleado){
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
          cargaerroresFirmaAsigAdmin("El Empleado No Existe En La Base De Registro De Firmas Favor De Verificar");
          $("#NumEmpModalBajaAsignacionAdmin").val("");
          $("#btnFirmarAsignacionAdmin").hide();
        }else {
          var EstatusFirmaInterna = response.empleado[0].EstatusFirmaInterna;
          if(EstatusFirmaInterna=="0"){
            cargaerroresFirmaAsigAdmin("Esta Firma Fue Dada De Baja Favor de solicitar Otra o Comunicarse Con RH");
            $("#NumEmpModalBajaAsignacionAdmin").val("");
            $("#btnFirmarAsignacionAdmin").hide();
          }
          else{
           $("#btnFirmarAsignacionAdmin").show(); 
          }
        }
      }else{
        cargaerroresFirmaAsigAdmin(response.menssaje);
        $("#NumEmpModalBajaAsignacionAdmin").val("");
        $("#btnFirmarAsignacionAdmin").hide();
      }
    },error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }
  });
}
function cargaerroresFirmaAsigAdmin(mensaje){
  $('#errormodalFirmaElementoAsignacionAdmin1').fadeIn();
  msjerrorbaja="<div id='errormodalFirmaElementoAsignacionAdmin1' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errormodalFirmaElementoAsignacionAdmin").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errormodalFirmaElementoAsignacionAdmin1').delay(4000).fadeOut('slow'); 
}

function RevisarFirmaInternaAsigAdmin(){
  var NumEmpModalBaja = $("#NumEmpModalBajaAsignacionAdmin").val();
  var constraseniaFirma = $("#constraseniaFirmaAsignacionAdmin").val();
  var txtNumeroEmpleadoModal = $("#txtSearch").val();
 if(NumEmpModalBaja==""){
   cargaerroresFirmaAsigAdmin("El numero de empleado no puede estar vacio");
  }else if(constraseniaFirma==""){
     cargaerroresFirmaAsigAdmin("Escriba la contraseña para continuar");
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
          cargaerroresFirmaAsigAdmin("La Contraseña ingresada es incorrecta favor de escribirla exactamente como la ingreso en el registro");
          $("#constraseniaFirmaAsignacionAdmin").val("");
        }else{
          var NumeroDuenioFirma = response.datos["0"].EntidadFirma + "-" + response.datos["0"].ConsecutivoFirma + "-" + response.datos["0"].CategoriaFirma;
          var contraseniaInsertadaCifrada =response.datos["0"].ContraseniaFirma;
          //alert(NumeroDuenioFirma + " " + "NumeroDuenioFirma");
          //alert(txtNumeroEmpleadoModal + " " + "txtNumeroEmpleadoModal");
          if(NumeroDuenioFirma != txtNumeroEmpleadoModal){
            cargaerroresFirmaAsigAdmin("La firma No pertenece Al Administrativo que se esta asignando uniformes, Por Favor ingresar la firma interna del empleado administrativo");
            $("#constraseniaFirmaAsignacionAdmin").val("");
            $("#NumEmpModalBajaAsignacionAdmin").val("");
            $("#btnFirmarAsignacionAdmin").hide();
          }else{
            $("#modalFirmaElementoAsignacionAdmin").modal("hide");
            $("#FirmaIntenaEmpleadoQueRecibe").val(contraseniaInsertadaCifrada);
            asignarUniforme1(1);
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

function cancelarFirmaIntAsigAdmin(){
  $("#NumEmpModalBajaAsignacionAdmin").val("");
  $("#constraseniaFirmaAsignacionAdmin").val("");
  $("#modalFirmaElementoAsignacionAdmin").modal("hide");
  $("#modalFirmaElectronicaAsignacion").modal();
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function cargarmensajeerrorAlmacen(mensaje,tipo){
  $('#divMensajealmacen').fadeIn('slow');
  mensajeAlert="<div id='msgAlert' class='alert alert-"+tipo+"'>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
  $("#divMensajealmacen").html(mensajeAlert);
  $(document).scrollTop(0);
  $('#divMensajealmacen').delay(3000).fadeOut('slow');
}

function limpiarFormulario(){
  $("#tablaVistaUni").hide();
  $("#AgregarUniALista").prop("disabled",true);
  $("#btnAsignarUniforme").prop("disabled",true);
  //$("#btnExaminar").prop("disabled",true);
  //$("#btnExaminar").val("");
  $("#selectTipoM").val("TIPO MERCANCIA");
  $("#selectUniforme").val(0);
  $("#txtUniforme").val("");
  $("#selEntidadesAignacion").val(0);
  $("#selSucursalAsignacion").val(0);
  $("#stockUniforme").val("");
  $("#selectTipoM").prop("disabled",true);
  $("#selectUniforme").prop("disabled",true);
  $("#txtUniforme").prop("disabled",true);
  $("#selectCantidad").prop("disabled",true);
  $("#selectCantidad").val(1);
  $("#selEntidadesAignacion").prop("disabled",true);
  $("#selSucursalAsignacion").prop("disabled",true);
  //$("#botonFAlta").prop("disabled",true);
  $("#fotoEmpleado").html ("");
  $("#nombreEmpleado").val("");
  $("#txtTallaC").val("");
  $("#txtTallaP").val("");
  $("#txtNumCalzado").val("");
  $("#txtPuntoServ").val("");
  $("#inpCostoCalzado").val("");
  $("#inpCostoCalzado").prop("readonly",true);
}

function limpiarDatosXcambioEntoSuc(){
  $("#tablaVistaUni").hide();
  $("#AgregarUniALista").prop("disabled",true);
  $("#btnAsignarUniforme").prop("disabled",true);
  //$("#btnExaminar").prop("disabled",true);
  //$("#btnExaminar").val("");
  $("#selectTipoM").val("TIPO MERCANCIA");
  $("#selectUniforme").val(0);
  $("#txtUniforme").val("");
  $("#stockUniforme").val("");
  $("#inpCostoCalzado").val("");
  $("#inpCostoCalzado").prop("readonly",true);
  $("#selEntidadesAignacion").val(0);
  $("#selectTipoM").prop("disabled",true);
  $("#selectUniforme").prop("disabled",true);
  $("#txtUniforme").prop("disabled",true);
  $("#selectCantidad").prop("disabled",true);
  $("#selectCantidad").val(1);
  // $("#selEntidadesAignacion").prop("disabled",true);
  $("#selSucursalAsignacion").prop("disabled",true);
}
</script>