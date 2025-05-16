
<form id="empleadosProcesoBaja" name ="empleadosProcesoBaja" method="post" action="ficheroDescargarPersonalSinImss.php" target="_blank">
<center>
  <img title='Consulta/Cargar/Actualizar Pagina' src='img/ActualizarEjecutar.jpg' class='cursorImg' onclick="inicioConfirmBajaImss();" width="50px"><br>
</center>
<div class="containerTable">
        <section>
            <table id="exampleProcesoBaja" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th># Empleado</th>
                        <th>Ap. Paterno</th>
                        <th>Ap. Materno</th>
                        <th>Nombre</th>
                        <th>Fecha Baja</th> 
                        <th>Registro Pat</th>
                        <th>Folio Txt</th>
                        <th>Rechazar</th>
                        </tr>
                </thead>
                <tbody></tbody>
            </table>
            <button class="btn btn-large" type="button" onclick="mostrarModalConfirmacionBajas();"> <img src="img/confirmarImss.png">Confirmar lote</button>
        </section>
</div>
  <!-- modal confirmacion imss -->
  <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="myModalConfirmacionBajaImss" name="myModalConfirmacionBajaImss" >
  <div id="alertMsgconfirmB">
  </div>
   <div class="modal-header">
      <h4 class="modal-title" id="myModalLabel"> <img src="img/ok.png">¿Desea confirmar baja de imss?</h4>
    </div>
    <div class="modal-body">
        <div class="input-prepend">
          <span class="add-on"># Lote generado txt</span>
          <input id="txtNumeroLoteTxtBaja" name="txtNumeroLoteTxtBaja" type="text" class="input-small" maxlength="10">
          <span class="add-on">#Lote Imss</span>
          <input id="txtNumeroLoteImssBaja" name="txtNumeroLoteImssBaja" type="text" class="input-small" maxlength="11">
        </div>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick='confirmaLoteImssBaja();'>Confirmar Imss</button>
      </div>
    </div>  <!-- FIN MODAL confirmacion imss-->

    <div id="myModalRechazadobajaimss" name="myModalRechazadobajaimss" class="modalEdit hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"  >
  <div id="alertMsg11">
  </div>
    <div class="modal-header">
      <h4 class="modal-title" id="myModalLabelrechazadobajaimss"> <img src="img/rechazarImss.png">¿Desea indicar que el empleado fue rechazado por IMSS?</h4>
    </div>
    <div class="modal-body">
        <div class="input-prepend">
          <span class="add-on"># EMPLEADO</span>
          <input id="NumeroEmpleadoModalrechazobajaImss" name="NumeroEmpleadoModalrechazobajaImss" type="text" class="input-medium" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">NOMBRE EMPLEADO</span>
          <input id="NombreEmpleadoModalrechazobajaImss" name="NombreEmpleadoModalrechazobajaImss" type="text" class="input-xlarge" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">FECHA BAJA</span>
          <input id="FechaImssModalrechazoImss" name="FechaImssModalrechazoImss" type="date" class="input-medium" readonly>
        </div>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick='rechazabajaimss();'>Si, rechazar</button>
      </div>
</div>
</form>
<script type="text/javascript">
var tableBajaImss1 = null;

var rolUsuario="<?php echo $usuario['rol']; ?>";

$(inicioConfirmBajaImss());  

function inicioConfirmBajaImss(){
  if(rolUsuario=="Coordinador Imss" ){
    styleTableImssBajas();
    }
}

function confirmar_imss_rechazo_baja(empleadoId, nombreEmpleado, fechaImss)
{
   // alert (empleadoId);
    $('#').modal();
    $("#txtNumeroEmpleadoModalImss").val(empleadoId);
    $("#txtNombreEmpleadoModalImss").val(nombreEmpleado);
    $("#txtFechaImssModal").val(fechaImss);
}

      function confirmaLoteImssBaja(){

          var folioTxtBaja=$("#txtNumeroLoteTxtBaja").val();
          var numeroLoteBaja=$("#txtNumeroLoteImssBaja").val();
          var empleadoEstatusImss=7;
          //var empleadoEstatusImss="1";
        $.ajax({
            async: false,
            type: "POST",
            url: "ajax_confirmaBajaImss.php",
            data: {"folioTxtBaja":folioTxtBaja,"numeroLoteBaja":numeroLoteBaja, "empleadoEstatusImss":empleadoEstatusImss},
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;
                if (response.status=="success") {
                    alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Datos Imss</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#alertMsgconfirmB").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                    $("#txtNumeroLoteTxtBaja").val("");
                    $("#txtNumeroLoteImssBaja").val("");
                    $('#myModalConfirmacionBajaImss').modal('hide');
                    //AQUI SE LLAMARIA A LA FUNCION PARA CALCULAR EL FINIQUITO DE ESTOS ELEMENTOS
                    //Se manda a consulta vacaciones pasadas antes del ultmio aniversario
                    consultaVacacionesTotales(folioTxtBaja,numeroLoteBaja);
                } else if (response.status=="error")
                {
                  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error en confirmación:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#alertMsgconfirmB").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                }
              },
            error: function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText);
      }
        });

      }

 function consultaVacacionesTotales(folioTxtBaja,numeroLoteBaja){ 
    var folioBaja = folioTxtBaja;
    $.ajax({
      async: false,
      type: "POST",
      url: "ajax_GetDatosEmpleadoFiniquito.php",
      data: {"folioBaja":folioBaja},
      dataType: "json",
      success: function(response1) {
       // console.log(response1);
        var largoresponse = response1.length; 
        for(var j=0; j<largoresponse; j++){
          if(response1[j].registroPatronal != "V8485152525"){
            var mensaje=response1[j].message; 
            var estatus1=response1[j].status;
            if(estatus1=="error"){
              var estatus = "error";
              j=largoresponse;
            }else{
              var estatus = "succses";
            }
          }
        }
        if (estatus=="error")
        {
          alert("Error Al ObtenerDatos Empleado Finiquito "+mensaje);
        }else{

          
          var bandera ="0";
          for(var j=0; j<largoresponse; j++){
            bandera=j;
            if(response1[j].registroPatronal != "V8485152525"){
              if(j==0){insertarDatosFiniquito(folioTxtBaja);}
              var response=response1[j];
              var datosEstatus = response.datos;
              var empleadoEntidadId = response.empleadoEntidadId;
              var empleadoConsecutivoId = response.empleadoConsecutivoId;
              var empleadoTipoId = response.empleadoTipoId;
              var FechaAltaEmpleadoLaborales = response.FechaAltaEmpleadoLaborales;
              //styleTableImss();
              if(datosEstatus=="2"){
                UpdateEstatusFiniquitosLaborales(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,FechaAltaEmpleadoLaborales);
              }
            }
          }
          if(bandera==largoresponse-1){

            for(var k=0; k<largoresponse; k++){
              if(response1[k].registroPatronal != "V8485152525"){
                var response=response1[k];
                var datosEstatus = response.datos;
                if(datosEstatus!="2"){
                  calculoFiniquito(folioTxtBaja); 
                }
              }
            }
            consultafiniquitocalculado();
            styleTableImssBajas();
            functioninserhistoricomovimientosbajaimss(folioTxtBaja,numeroLoteBaja);
          }
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText);
      }
       });
  }
  function UpdateEstatusFiniquitosLaborales(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,FechaAltaEmpleadoLaborales){

    $.ajax({
      async: false,
      type: "POST",
      url: "ajax_actualizarEstatusFiniquitoLaborales.php",
      data: {"empleadoEntidadId":empleadoEntidadId,"empleadoConsecutivoId":empleadoConsecutivoId,"empleadoTipoId":empleadoTipoId,"FechaAltaEmpleadoLaborales":FechaAltaEmpleadoLaborales},
      dataType: "json",
      success: function(response) {
        var mensaje=response.message;
        if (response.status=="error")
        {
            alert("Error al Actualizar finiquitos: "+mensaje);
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }

  function insertarDatosFiniquito(folioBaja){
         $.ajax({
           async: false,
           type: "POST",
           url: "ajax_insertaFiniquitosInicio.php",
           data: {"folioTxtBaja":folioBaja},
           dataType: "json",
           success: function(response) {
               var mensaje=response.message;
               if (response.status=="error")
               {
                   alert("Error al insertar finiquitos: "+mensaje);
               }
             },
           error: function(jqXHR, textStatus, errorThrown){
                 alert(jqXHR.responseText);
           }
       });
   }
      function mostrarModalConfirmacionBajas()
      {
   // alert (empleadoId);
        $('#myModalConfirmacionBajaImss').modal();

      }

function confirmar_imss_rechazo_baja(empleado,nombre,fechabaja){
  $("#NumeroEmpleadoModalrechazobajaImss").val(empleado);
  $("#NombreEmpleadoModalrechazobajaImss").val(nombre);
  $("#FechaImssModalrechazoImss").val(fechabaja);
 $('#myModalRechazadobajaimss').modal();
}
 function rechazabajaimss(){
  var numempleado=$("#NumeroEmpleadoModalrechazobajaImss").val();
         $.ajax({
           async: false,
           type: "POST",
           url: "ajax_rechazoBajaImss.php",
           data: {"numempleado":numempleado},
           dataType: "json",
           success: function(response) {
               var mensaje=response.message;
               if (response.status=="error")
               {
                   alert("Error al Rechazar empleado: "+mensaje);
               }
                $('#myModalRechazadobajaimss').modal('hide');
                styleTableImssBajas();
                tableBajasImss();

             },
           error: function(jqXHR, textStatus, errorThrown){
                 alert(jqXHR.responseText);
           }
       });
  //regresar a estatus 5
 }



function styleTableImssBajas(){
  //alert("HOLA");
  if (tableBajaImss1 != null)
        {
            tableBajaImss1.destroy ();
        }
        tableBajaImss1 = $('#exampleProcesoBaja').DataTable( {
        ajax: {
            url: 'ajax_obtenerEmpleadosProcesoBajaImss.php'
            ,type: 'POST'
            //,data : {"estatusEmpleado":2}
        }
        ,"columns": [
            { "data": "numeroEmpleado"}
            ,{ "data": "apellidoPaterno" }
            ,{ "data": "apellidoMaterno" }
            ,{ "data": "nombreEmpleado" }
            ,{ "data": "fechaBajaImss" }
            ,{ "data": "registroPatronal" }
            ,{ "data": "folioTxtBaja" }
            ,{ "data": "accion_confirmar_imss_baja" }]
        ,processing: true
        ,"bPaginate": false
        ,dom: 'Bfrtip'
        ,buttons: ['excel']
    } );

}
     $("#descargarEmpleadosSinImss").click(function(event) {
     $("#datos_a_enviar_sin_imss").val( $("<div>").append( $("#exampleProcesoBaja").eq(0).clone()).html());
     $("#datosPersonalSinImss").submit();
    });
      function functioninserhistoricomovimientosbajaimss(folioTxt,numeroLote){
        $.ajax({
            type: "POST",
            url: "ajax_historicomovimss.php",
            data: {"folioTxt":folioTxt,
            "accion":2,"numeroLote":numeroLote},
            dataType: "json",
            success: function(response) {
              },
             error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
        });

     }
</script>
