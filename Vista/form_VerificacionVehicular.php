<meta charset="utf-8"/>

<legend>VERIFICACIONES DE VEHICULOS</legend>
<div>
    <button id="btnConsultarVerificacionesVehiculares" style="width: 150px;height: 40px;border-radius: 20px;background-color: rgba(159, 209, 13, .8);color: blue;">Consultar</button>
</div><br>


<table border="1" width="80%" id="tablacolores" style="display: none">
  <tr style="height: 70px;">
    <td style="background-color: yellow;text-align: center;cursor: pointer;" onclick="mostrartabla(1)">AMARILLO</td>
    <td style="background-color: pink;text-align: center;cursor: pointer;" onclick="mostrartabla(11)">ROSA &nbsp;</td>
    <td style="background-color: red;text-align: center;cursor: pointer;" onclick="mostrartabla(2)">ROJO &nbsp;</td>
    <td style="background-color: green;text-align: center;cursor: pointer;" onclick="mostrartabla(4)">VERDE </td>
    <td style="background-color: blue;text-align: center;cursor: pointer;" onclick="mostrartabla(3)">AZUL &nbsp;</td>
  </tr>
</table><br><br>
<a id="proximosaverificar"onclick="MostrarTalbaVehiculosproximosaverificar(0)"style="cursor: pointer;display: none;" data-toggle="tab">LISTA DE LOS VEHICULOS URGENTE A VERIFICAR EN EL SEMESTRE POR FECHA</a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
<a id="generalverificacdos"onclick="MostrarTalbaVehiculosproximosaverificar(3)"style="cursor: pointer;display: none;" data-toggle="tab">LISTA DE LOS VEHICULOS VERIFICADOS EN EL SEMESTRE POR FECHA</a><br><br>
<span class="add-on" id="spancolor" style="display: none">Color Seleccionado: </span>
<input id="impcolorseleccionado" name="impcolorseleccionado" style="display: none" type="text"><br>
<a id="listasinverificacion" onclick=" MostrarTalbaVehiculosproximosaverificar(2);" style="cursor: pointer;display: none;" data-toggle="tab">LISTA DE LOS VEHICULOS SIN VERIFICACIÓN POR COLOR Y SEMESTRE</a>
 &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
<a  id="listaconverificacion" onclick=" MostrarTalbaVehiculosproximosaverificar(1);" style="cursor: pointer;display: none;" data-toggle="tab">LISTA DE LOS VEHICULOS CON VERIFICACIÓN POR COLOR Y SEMESTRE</a><br>

<input id="imphidencolor" name="imphidencolor" type="hidden"><br>
<input id="casotabla" name="casotabla" type="hidden"><br>
<h3 id="listavehiculosurgente" style="display: none;">LISTA DE LOS VEHICULOS URGENTE A VERIFICAR EN EL SEMESTRE</h3>
<h3 id="listavehiculosverificados" style="display: none;">LISTA DE LOS VEHICULOS VERIFICADOS DEL SEMESTRE</h3>
<h3 id="listavehiculosConverificacion" style="display: none;">LISTA DE LOS VEHICULOS CON VERIFICACIÓN POR COLOR Y SEMESTRE</h3>
<h3 id="listaehiuclosSinverificacion" style="display: none;">LISTA DE LOS VEHICULOS SIN VERIFICACIÓN POR COLOR Y SEMESTRE</h3>
<dir id="MensajeFormularioVerificacion"></dir>
<div align="center" id="divtablavehiculo" style="display: none;">
        <section>
          <table id="tablaverificacionvehicular" align="center" border="1" cellspacing="0" width="90%">
            <thead>
              <tr>
                <th>N° ECONOMICO</th>
                <th>N° PLACAS</th>
                <th>MARCA</th>
                <th>MODELO</th>
                <th>COLOR ENGOMADO</th>
                <th>LINEA DE NEGOCIO</th>
                <th>ENTIDAD FEDERATIVA</th>
                <th>EMPLEADO ASIGNADO</th>
                <th>FECHA ULTIMA VERIFICACIÓN</th>
                <th>FECHA LIMITE VERIFICACIÓN</th>
                <th>VEHICULO VERIFICADO</th>
                <th>VERIFICACION</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </section>
      </div>
<form method="post" id="form_VerificacionesVehiculares" name="form_VerificacionesVehiculares" action="" target="_blank">
  <div id="modalverificacionvehicular" name="modalverificacionvehicular" class="modalEdit hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" >
    <div id="MensajeDeErrorVerificacionVehicular"></div>
    <div class="modal-header">
      <h4 class="modal-title" id="myModalLabel"> <img src="img/warning.png">VERIFICACIÓN DE EL VEHICULO!!</h4>
    </div>
    <div class="input-prepend">
    
      <span  class="add-on" style="margin-top: 3%; margin-left: -10%;">¿El Vehiculo Será Para Verificación Constante?</span>
    <div class="material-switch pull-right" align="left" >
      <span  class="add-on">NO  SI</span><br><br>
        <input class="input-large" id="SeVerifica" name="SeVerifica" type="checkbox">        
        <label for="SeVerifica" class="label-success1"></label>
    </div>
  </div>
  <div id="DivFechaDeCalendarios" style="display: none;">
      <label class="control-label label" for="checkCalendarionormal">Se Verifica Con El Calendario Normal</label>
      <input id="checkCalendarionormal" name="checkCalendarionormal" type="checkbox" style="transform: scale(1.5);">

      <label class="control-label label" for="checkCalendarioExtra">Se Verifica Con Un Calendario Extraordinario</label>
      <input id="checkCalendarioExtra" name="checkCalendarioExtra" type="checkbox" style="transform: scale(1.5);">
  </div>
    <div class="modal-body" id="divVerificacionVehicular" style="display: none;">

      <div class="input-prepend">
        <input id="SeVerificahiden" name="SeVerificahiden" type="hidden">
        <input id="checkCalendarionormalhiden" name="checkCalendarionormalhiden" type="hidden">
        <input id="checkCalendarioExtrahiden" name="checkCalendarioExtrahiden" type="hidden">
        <input id="checkSePagoMultahiden" name="checkSePagoMultahiden" type="hidden">
        <input id="checkVerificacionATiempohiden" name="checkVerificacionATiempohiden" type="hidden">
        
        <input id="PrimerSemestrHiden" name="PrimerSemestrHiden" type="hidden">
        <input id="SegundosemestreHiden" name="SegundosemestreHiden" type="hidden">
        <span class="add-on">N° Economico Vehiculo</span>
        <input id="inpNumroEcoVehiculoVerificacion" name="inpNumroEcoVehiculoVerificacion" type="text" class="input-small" readonly>
        <span class="add-on">N° De Placas Del Vehiculo</span>
        <input id="inpNumeroPlacasVerificacion" name="inpNumeroPlacasVerificacion" type="text" class="input-medium" readonly>
         <span class="add-on">Color Del Engomado</span>
        <input id="inpcolorEngomadoVerificacion" name="inpcolorEngomadoVerificacion" type="text" class="input-small" readonly>
      </div><br>

      <div class="input-prepend">
        <span class="add-on">Marca</span>
        <input id="inpMarcaVerificacion" name="inpMarcaVerificacion" type="text" class="input-medium" readonly>
         <span class="add-on">Modelo</span>
        <input id="inpModeloverificacion" name="inpModeloverificacion" type="text" class="input-medium" readonly>
      </div><br>

      <div class="input-prepend">
        <span class="add-on">Fecha Inicial</span>
        <input id="FechaInicialVerificacion" name="FechaInicialVerificacion" type="date" class="input-medium" readonly>
        <span class="add-on">Fecha Final</span>
        <input id="FechaFinalVerificacion" name="FechaFinalVerificacion" type="date" class="input-medium" readonly>
      </div><br>

      <div class="input-prepend">
        <span class="add-on">Monto Verifiación</span>
        <input id="MontoVerificacion" name="MontoVerificacion" type="text" class="input-medium">

        <span class="add-on">Foto Talón De Verificación</span>
        <input id="FototalnVer" name="FototalnVer[]" type="file" class="btn-success">
        <input id="fotoverificacionhiden" name="fotoverificacionhiden[]" type="hidden">
      </div><br>
      <div class="input-prepend">
        <span  class="add-on" style="margin-top: 3%; margin-left: -10%;">¿Se Verifica En Tiempo Y Forma?</span>
        <div class="material-switch pull-right" align="left" >
          <span  class="add-on">NO  SI</span><br><br>
          <input class="input-large" id="checkVerificacionATiempo" name="checkVerificacionATiempo" type="checkbox">        
          <label for="checkVerificacionATiempo" class="label-success1"></label>
        </div>
      </div><br>

      <div class="input-prepend" id="DivPreguntaMulta" style="display: none;">
        <span  class="add-on" style="margin-top: 3%; margin-left: -10%;">¿Se Pago Multa?</span>
        <div class="material-switch pull-right" align="left" >
          <span  class="add-on">NO  SI</span><br><br>
          <input class="input-large" id="checkSePagoMulta" name="checkSePagoMulta" type="checkbox">        
          <label for="checkSePagoMulta" class="label-success1"></label>
        </div>
      </div><br>

      <div class="input-prepend" id="Divmulta" style="display: none;">
        <span class="add-on">Monto Multa</span>
        <input id="MontoMulta" name="MontoMulta" type="text" class="input-medium">
        <span class="add-on">Folio De La Multa</span>
        <input id="FolioMulta" name="FolioMulta" type="text" class="input-medium">
        <br><br>
         <span class="add-on">Formato De La Multa</span>
        <input id="FormatoMulta" name="FormatoMulta[]" type="file" class="btn-success">
        <input id="formatomultahiden" name="formatomultahiden[]" type="text">
      </div><br>

      <div class="input-prepend" id="DivPorque" style="display: none;">
        <span class="add-on">¿Porque?</span>
        <textarea  id="PorqueMulta" name="PorqueMulta" class="txtAreaComentarios" rows="5" maxlength="100"></textarea>
      </div>
    </div><br>
    <div id="DivComentariosGenerales" style="display: none;">
      <span class="add-on">Comentarios Generales</span>
      <textarea  id="ComentariosGenerales" name="ComentariosGenerales" class="txtAreaComentarios" rows="5" maxlength="100" ></textarea>

    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" onclick='resetearformularioVerificacionvehicular();' data-dismiss="modal">Cancelar</button>
      <button type="button" class="btn btn-primary" onclick='validarModalVerificacion();'>Guardar</button>
    </div>
  </div>  <!-- FIN MODAL reactivacion punto de servicio-->


</form>
<script type="text/javascript">
var tablavehiculoscaluloVerificacion = null;

var rolUsuario="<?php echo $usuario['rol']; ?>";

// $(inicioVerifV());  

// function inicioVerifV(){
   // if (rolUsuario=="Gerente Vehicular" || rolUsuario=="Control Vehicular"){
      // MostrarTalbaVerificacionVehicular();
    // }
// }

$("#btnConsultarVerificacionesVehiculares").click(function(){
    MostrarTalbaVerificacionVehicular();
});

function MostrarTalbaVerificacionVehicular() {
  $("#divtablavehiculo").hide();
  $("#tablacolores").show();
  $("#proximosaverificar").show();
  $("#generalverificacdos").show();
 }

function mostrartabla(caso){
   $("#impcolorseleccionado").val("");
  if(caso=="1"){
    $("#impcolorseleccionado").val("AMARILLO");
  }else if(caso=="11"){
    $("#impcolorseleccionado").val("ROSA");
  }else if(caso=="2"){
    $("#impcolorseleccionado").val("ROJO");
  }else if(caso=="4"){
    $("#impcolorseleccionado").val("VERDE");
  }else if(caso=="3"){
    $("#impcolorseleccionado").val("AZUL");
  }
  $("#listavehiculosurgente").hide();
  $("#listavehiculosverificados").hide();
  $("#listavehiculosConverificacion").hide();
  $("#listaehiuclosSinverificacion").hide();
  $("#divtablavehiculo").hide();
  $("#imphidencolor").val(caso);
  $("#listaconverificacion").show();
  $("#listasinverificacion").show();
  $("#impcolorseleccionado").show();
  $("#spancolor").show();
}
function MostrarTalbaVehiculosproximosaverificar(consulta1) {
  $("#casotabla").val(consulta1);
  var consulta =$("#casotabla").val();
  if(consulta==0){
    $("#listavehiculosurgente").show();
    $("#listavehiculosverificados").hide();
    $("#listavehiculosConverificacion").hide();
    $("#listaehiuclosSinverificacion").hide();
    $("#imphidencolor").val(consulta);
    $("#listaconverificacion").hide();
    $("#listasinverificacion").hide();
     $("#impcolorseleccionado").hide();
     $("#spancolor").hide();
  }else if(consulta==1){
    $("#listavehiculosurgente").hide();
    $("#listavehiculosverificados").hide();
    $("#listavehiculosConverificacion").show();
    $("#listaehiuclosSinverificacion").hide();
     $("#impcolorseleccionado").show();
     $("#spancolor").show();
  }else if(consulta==2){
    $("#listavehiculosurgente").hide();
    $("#listavehiculosverificados").hide();
    $("#listavehiculosConverificacion").hide();
    $("#listaehiuclosSinverificacion").show();
     $("#impcolorseleccionado").show();
     $("#spancolor").show();
  }else if (consulta==3) {
    $("#listavehiculosverificados").show();
    $("#listavehiculosurgente").hide();
    $("#listavehiculosConverificacion").hide();
    $("#listaehiuclosSinverificacion").hide();
    $("#imphidencolor").val(consulta);
    $("#listaconverificacion").hide();
    $("#listasinverificacion").hide();
     $("#impcolorseleccionado").hide();
     $("#spancolor").hide();
  }
  var color = $("#imphidencolor").val();
     tablaVehiculosVerificados = [];
     $.ajax({
         type: "POST",
         url: "ajax_obtenerTablaVerificacionVehicular.php",
         data:{"color": color,"consulta": consulta},
         dataType: "json",
         success: function(response) {
             if (response.status == "success") {
                   for (var i = 0; i < response.data.length; i++) {
                      var record = response.data[i];
                      //console.log(record);
                      tablaVehiculosVerificados.push(record);
                    }  
                       loadDatatoblevehiculosVerificacdos(tablaVehiculosVerificados);
             } else {
                 var mensaje = response.message;
                 alert("mal");
             }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
 }

 function loadDatatoblevehiculosVerificacdos(data) {
     if (tablavehiculoscaluloVerificacion != null) {
         tablavehiculoscaluloVerificacion.destroy();
     }
     tablavehiculoscaluloVerificacion = $('#tablaverificacionvehicular').DataTable({
         "language": {
             "emptyTable": "No hay registro disponible",
             "info": "Del _START_ al _END_ de _TOTAL_",
             "infoEmpty": "Mostrando 0 registros de un total de 0.",
             "infoFiltered": "(filtrados de un total de _MAX_ registros)",
             "infoPostFix": "(actualizados)",
             "lengthMenu": "Mostrar _MENU_ registros",
             "loadingRecords": "Cargando....",
             "processing": "Procesando....",
             "search": "Buscar:",
             "searchPlaceholder": "Dato para buscar",
             "zeroRecords": "no se han encontrado coincidencias",
             "paginate": {
                 "first": "Primera",
                 "last": "Ultima",
                 "next": "Siguiente",
                 "previous": "Anterior"
             },
             "aria": {
                 "sortAscending": "Ordenación ascendente",
                 "sortDescending": "Ordenación descendente"
             }
         },
         data: data,
         destroy: true
      ,"columns": [
       { "data": "NumEconomico"}
      ,{ "data": "Placas"}
      ,{ "data": "MarCaVehiculo"}
      ,{ "data": "ModeloVehiculo"}
      ,{ "data": "ColorEngomado"}
      ,{ "data": "NombreLineaNegocio"}
      ,{ "data": "NombreEntidades"}
      ,{ "data": "Empleado"}
      ,{ "data": "fechaUltimaVerificacion"}
      ,{ "data": "FechaLimite"}
      ,{ "data": "imagenverificado"}
      ,{ "data": "verificacion"}
      ],
         // ]
         //,serverSide: true
         processing: true,
         dom: 'Bfrtip',
         buttons: ['excel',{orientation:'landscape',extend:'pdf',pageSize:'LEGAL'}]
     });
$("#divtablavehiculo").show();
 }

  function cargarpdfVehiculos(caso, nombre)
 {
  if(caso==1){

       window.open("uploads/ParqueVehicular/fotospolizaseguros/" + nombre);  
  }else if(caso==2){
        window.open("uploads/ParqueVehicular/fotostarjetacirculacion/" + nombre);  
  }

  }

  function RegistrarVerificacion(NumEconomico,Placas,idColorEngomado,Marca,Modelo,corlorengomado,FechaIicial,FechaFinal,PrimerSemestre,
SegundoSemetre){

    $("#PrimerSemestrHiden").val(PrimerSemestre);
    $("#SegundosemestreHiden").val(SegundoSemetre);
    if($('#SeVerifica').is(":checked")) {
      $('#SeVerifica').val(1);
      $("#DivFechaDeCalendarios").show();
      $("#DivComentariosGenerales").show();
    }else{
      $('#SeVerifica').val(0);
      $('#checkCalendarionormal').val(0);
      $('#checkCalendarioExtra').val(0);
      $('#checkSePagoMulta').val(0);
      $('#checkVerificacionATiempo').val(0);
      $("#DivFechaDeCalendarios").hide();
      $("#DivComentariosGenerales").show();
    }
    $("#FechaInicialVerificacion").val(FechaIicial);
    $("#FechaFinalVerificacion").val(FechaFinal);
    $("#inpNumroEcoVehiculoVerificacion").val(NumEconomico);
    $("#inpNumeroPlacasVerificacion").val(Placas);
    $("#inpcolorEngomadoVerificacion").val(corlorengomado);
    $("#inpMarcaVerificacion").val(Marca);
    $("#inpModeloverificacion").val(Modelo);
    $("#modalverificacionvehicular").modal("show");
  }
  $('#SeVerifica').change(function() {
    if($('#SeVerifica').is(":checked")) {
      $('#SeVerifica').val(1);
      $("#DivFechaDeCalendarios").show();
      $("#DivComentariosGenerales").show();
      $("#checkVerificacionATiempo").prop("checked", true);
      $('#checkVerificacionATiempo').val(1);
      $("#checkSePagoMulta").prop("checked", false);
      $('#checkSePagoMulta').val(0);
    } 
    else {
      $('#SeVerifica').val(0);
      $("#DivFechaDeCalendarios").hide();
      $("#DivComentariosGenerales").show();
      $("#checkCalendarionormal").prop("checked", false);
      $('#checkCalendarionormal').val(0);
      $("#checkCalendarioExtra").prop("checked", false);
      $('#checkCalendarioExtra').val(0);
      $("#divVerificacionVehicular").hide();
      $("#checkVerificacionATiempo").prop("checked", true);
      $('#checkVerificacionATiempo').val(1);
      $("#DivPreguntaMulta").hide();
      $("#DivPorque").hide();
      $("#Divmulta").hide();

    }
  });

  $('#checkCalendarionormal').change(function() {
    if($('#checkCalendarionormal').is(":checked")) {
      $('#checkCalendarionormal').val(1);
      $("#checkCalendarioExtra").prop("checked", false);
      $('#checkCalendarioExtra').val(0);
      $("#divVerificacionVehicular").show();
      $("#FechaFinalVerificacion").prop('readonly', true);
    } 
    else {
      $('#checkCalendarionormal').val(0);
      $("#divVerificacionVehicular").hide();
    }
  });

  $('#checkCalendarioExtra').change(function() {
    if($('#checkCalendarioExtra').is(":checked")) {
      $('#checkCalendarioExtra').val(1);
      $("#checkCalendarionormal").prop("checked", false);
      $('#checkCalendarionormal').val(0);
      $("#divVerificacionVehicular").show();
      $("#FechaFinalVerificacion").prop('readonly', false);
    } 
    else {
      $('#checkCalendarioExtra').val(0);
      $("#divVerificacionVehicular").hide();
    }
  });

  $('#checkVerificacionATiempo').change(function() {
    if($('#checkVerificacionATiempo').is(":checked")) {
      $('#checkVerificacionATiempo').val(1);
      $("#DivPreguntaMulta").hide();
      $("#DivPorque").hide();
      $("#Divmulta").hide();
    } 
    else {
      $("#checkSePagoMulta").prop("checked", false);
      $('#checkSePagoMulta').val(0);
      $('#checkVerificacionATiempo').val(0);
      $("#DivPreguntaMulta").show();
      $("#DivPorque").show();
    }
  });

  $('#checkSePagoMulta').change(function() {
    if($('#checkSePagoMulta').is(":checked")) {
      $('#checkSePagoMulta').val(1);
      $("#Divmulta").show();
      $("#DivPorque").hide();
    } 
    else {
      $('#checkSePagoMulta').val(0);
      $("#Divmulta").hide();
      $("#DivPorque").show();
    }
  });

  function validarModalVerificacion(){
  var SeVerifica = $("#SeVerifica").val(); 
  var checkCalendarionormal = $("#checkCalendarionormal").val();
  var checkCalendarioExtra = $("#checkCalendarioExtra").val();
  var FechaFinalVerificacion = $("#FechaFinalVerificacion").val();
  var FechaInicialVerificacion = $("#FechaInicialVerificacion").val();
  var MontoVerificacion = $("#MontoVerificacion").val();
  var FototalnVer = $("#FototalnVer").val();
  var checkVerificacionATiempo = $("#checkVerificacionATiempo").val();
  var checkSePagoMulta = $("#checkSePagoMulta").val();
  var PorqueMulta = $("#PorqueMulta").val();
  var MontoMulta = $("#MontoMulta").val();
  var FolioMulta = $("#FolioMulta").val();
  var FormatoMulta = $("#FormatoMulta").val();
  var ComentariosGenerales = $("#ComentariosGenerales").val();

  if(SeVerifica=="1"){
    if((checkCalendarionormal=="on" || checkCalendarionormal=="0") && (checkCalendarioExtra=="on" || checkCalendarioExtra=="0")){ 
      cargaerroresModaVerficacion("Seleccione El Calendario A Utilizar Para La Siguiente Verificación");
    }else if(checkCalendarioExtra== "1" && (FechaFinalVerificacion == "" || FechaFinalVerificacion<FechaInicialVerificacion)){
      cargaerroresModaVerficacion("La Fecha Final No Pude Ser Menor A La Fecha Inicial Ni Ir Vacia");
    }else if(MontoVerificacion==""){
      cargaerroresModaVerficacion("Ingrese El Monto De La Verificación (Sin Recargo En Caso De tener Multa)");
    }else if(FototalnVer==""){
      cargaerroresModaVerficacion("Carge La Foto Del Talón Solo Acepta(.JPEG,.PNG,.PDF)");
    }else if(checkVerificacionATiempo=="0" && checkSePagoMulta=="0" && PorqueMulta==""){
      cargaerroresModaVerficacion("Ingrese El Motivo De Por Que No Pago Multa AL No Verificar A Tiempo");
    }else if(checkVerificacionATiempo=="0" && checkSePagoMulta=="1" && MontoMulta==""){
      cargaerroresModaVerficacion("Ingrese El Monto Total Del Recargo Por La Multa");
    }else if(checkVerificacionATiempo=="0" && checkSePagoMulta=="1" && FolioMulta==""){
      cargaerroresModaVerficacion("Ingrese El Folio De La Multa");
    }else if(checkVerificacionATiempo=="0" && checkSePagoMulta=="1" && FormatoMulta==""){
      cargaerroresModaVerficacion("Cargue El Formato De La Multa Acepta(.jpeg,.png,.pdf)");
    }else{
      enviardocumentosVerficacionesVehiculares();
      //GuardarVerificacionDelVehiculo();
      
    }
  }else{
    if(ComentariosGenerales==""){
      cargaerroresModaVerficacion("Ingrese El Por Que Esta Unidad No Se Verificara Nunca");
    }else{
      GuardarVerificacionDelVehiculo();
      
    }
  }
}

  function GuardarVerificacionDelVehiculo(){
      
      var SeVerifica =$("#SeVerifica").val();
      var checkCalendarionormal =$("#checkCalendarionormal").val();
      var checkSePagoMulta =$("#checkSePagoMulta").val();
      var checkVerificacionATiempo =$("#checkVerificacionATiempo").val();

      $("#SeVerificahiden").val(SeVerifica);
      $("#checkCalendarionormalhiden").val(checkCalendarionormal);
      $("#checkSePagoMultahiden").val(checkSePagoMulta);
      $("#checkVerificacionATiempohiden").val(checkVerificacionATiempo); 
      if($("#SeVerificahiden").val()=="0"){
        $("#PrimerSemestrHiden").val(2);
        $("#SegundosemestreHiden").val(2);
      }
      var datastring = $("#form_VerificacionesVehiculares").serialize();
      $.ajax({
      type: "POST",
      data: datastring,
      url: "ajax_RegistrarVerificacion.php",
      dataType: "json",
      async:false,
      success: function(response) {
       
        var mensaje=response.message; 
        var estatus=response.status;
        if (estatus=="success") {
          
          $("#modalverificacionvehicular").modal("hide");
          $('#MensajeFormularioVerificacion').fadeIn();
          alertMsgregistrado="<div id='msgAlert' class='alert alert-success'><strong>Datos Gegerales</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
          $("#MensajeFormularioVerificacion").html(alertMsgregistrado);
          $(document).scrollTop(0);
          $('#MensajeFormularioVerificacion').delay(3000).fadeOut('slow');
          var casoconsulta = $("#casotabla").val();
          MostrarTalbaVehiculosproximosaverificar(casoconsulta);
          resetearformularioVerificacionvehicular()
            }else{
              alert("Error Al Registrar Verificación");
            }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
    }

    function enviardocumentosVerficacionesVehiculares(){

  var formData = new FormData($("#form_VerificacionesVehiculares")[0]);   
  //hacemos la petición ajax  
  for (var value of formData.values()) {
    //console.log(value); 
  }       
  $.ajax({
    type: "POST",
    url: "upload_ArchivosVerificaciones.php",
    data:formData,
    dataType: "json",
    cache: false,
    contentType: false,
    processData: false, 
    async:false,       
    //una vez finalizado correctamente
    success: function(response) {
    // console.log(response);
    var DocVerificacion= response.DocVerificacion;
    var DocMulta= response.DocMulta;
    var estatus = response.status;
    var mensaje =response.message;
    if(estatus=="success"){
      $("#fotoverificacionhiden").val(DocVerificacion);
      $("#formatomultahiden").val(DocMulta);
      GuardarVerificacionDelVehiculo();
    }else{
      $("#FototalnVer").val("");
      $("#fotoverificacionhiden").val("");
      cargaerroresModaVerficacion("Error:"+ mensaje);
    }
    
    },
    error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }
  });
}

  function cargaerroresModaVerficacion(mensaje){
  $('#MensajeDeErrorVerificacionVehicular').fadeIn('slow');
  alerterror="<div class='alert alert-error' id='MensajeDeErrorVerificacionVehicular'>"+mensaje+"<data-dismiss='alert'>";
  $("#MensajeDeErrorVerificacionVehicular").html(alerterror);
  $('#MensajeDeErrorVerificacionVehicular').delay(3000).fadeOut('slow');
  $(document).scrollTop(0);
}


function resetearformularioVerificacionvehicular(){
    $("#form_VerificacionesVehiculares")[0].reset();
    $("#DivFechaDeCalendarios").hide();
    $("#divVerificacionVehicular").hide();    
    $("#DivPreguntaMulta").hide();    
    $("#Divmulta").hide();    
    $("#DivPorque").hide();    
    
  }

  </script>

