<div id='msgErrorComplementoFiniquito' name='msgErrorComplementoFiniquito' ></div>
<center><h3>Negociación De Complemento Para Finiquitos</h3></center>
<br>
<div align="center">  
    <span class="add-on">Del:</span>
    <input class="input-medium" id="fechaInicioComplementoFiniquito" name="fechaInicioComplementoFiniquito" type="date">
    <span class="add-on">A:</span>
    <input class="input-medium" id="fechaTerminoComplementoFiniquito" name="fechaTerminoComplementoFiniquito" type="date">
    &nbsp<button style="margin-bottom: 0.5%" type="button" class="btn btn-primary" onclick="ConsultaFiniquitosParaComplemento();">Buscar</button>
</div>
<section>
    <center>
        <table id="tablaComplementoFiniquito" style="display: none;" width="100%" class="records_list table table-striped table-bordered table-hover" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th style="text-align: center;background-color: #B0E76E">Número empleado</th>
                    <th style="text-align: center;background-color: #B0E76E">Nombre</th>
                    <th style="text-align: center;background-color: #B0E76E">Entidad</th>
                    <th style="text-align: center;background-color: #B0E76E">Fecha Ingreso</th>
                    <th style="text-align: center;background-color: #B0E76E">Fecha Baja</th> 
                    <th style="text-align: center;background-color: #B0E76E">Neto Al Pago</th>
                    <th style="text-align: center;background-color: #B0E76E">Accion</th>
                </tr>
            </thead>
        </table>
    </center>
</section>
<div id="ModalComplementoF" name="ModalComplementoF" class="modalEdit hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div id='msmErrorCompelementoF' name='msmErrorCompelementoF' ></div>
    <div class="modal-header">
    <h4 class="modal-title"  align="center"> <img src="img/money.png">INGRESA EL COMPLEMENTOS PARA EL FINIQUITO</h4>
    </div>
    <div class="modal-body" align="center">
        <div class="input-prepend">
          <span class="add-on"># Empleado</span>
          <input id="numEmpleadoComp" name="numEmpleadoComp" type="text" class="input-medium" readonly>
        </div>
          <div class="input-prepend">
          <span class="add-on">Monto Finiquito</span>
          <input id="montoFiniquitoComp" name="montoFiniquitoComp" type="text" title="Este Monto Es El Otrorgado al Empleado Por A Travez Del Finiquito" class="input-medium" readonly>
          <span class="add-on">Monto Total A Dar </span>
          <input id="montoTotalComp" name="montoTotalComp" title="Este Es El Monto Total A Dar Para El Emplado Incluido El MOnto Del Finiquito" type="text" class="input-medium">
          <span class="add-on">Monto Total A Solicitar</span>
          <input id="montoSolicitarComp" name="montoSolicitarComp" title="Este Es El Monto Total A Solicitar Para ALcanzar El 'Monto Total A Dar' Al Empleado" type="text" class="input-medium" readonly>
          <input id="FolioFiniquito" name="FolioFiniquito" type="hidden" class="input-medium" readonly>

        </div>
    </div>
      <div class="modal-footer">
        <button id="btnConfirmarComp" name="btnConfirmarComp" type="button" class="btn btn-primary">Confirmar</button>
        <button id="btnCancelarComp" name="btnCancelarComp" type="button" class="btn btn-danger">Cancelar</button>
      </div>
</div>

<div id="ModalMsm" name="ModalMsm" class="modalEdit hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
    <h2 class="modal-title"  align="center"> <img src="img/alert.png">RECUERDA !!!</h2>
    <br>
    <br>
    <h4 class="modal-title"  align="center">AL PAGAR COMPLEMENTO POR SC GENERA DISCREPANCIA PARA LAS AUTORIDADES</h4>
    </div>
     <div class="modal-footer">
        <button id="btnConfirmarMensaje" name="btnConfirmarMensaje" type="button" class="btn btn-primary">Confirmar</button>
      </div>
</div>
<script type="text/javascript"> //empieza lo de js

 function ConsultaFiniquitosParaComplemento() { //finiquitos calculados con piramidar

    var fechainicio = $("#fechaInicioComplementoFiniquito").val();
    var fechafin = $("#fechaTerminoComplementoFiniquito").val();
    var fechainiciobusquedafiniquito = Date.parse(fechainicio);
    var fechafinbusquedafiniquito = Date.parse(fechafin);
    if (fechainicio == "") {
       mensajeDeErrorComplementoFiniquito("error","Debe introducir fecha Del:");
    } else if (fechafin == "") {
       mensajeDeErrorComplementoFiniquito("error","Debe introducir fecha A:");
    } else if (fechainiciobusquedafiniquito > fechafinbusquedafiniquito) {
       mensajeDeErrorComplementoFiniquito("error","La fecha A: no puede ser menor a la fecha DEL:");
    } else {
       // waitingDialog.show();
        tableFiniquitosComplementos = [];
        $.ajax({
            type: "POST",
            url: "ajax_consultaFiniquitosParaComplemento.php",
            dataType: "json",
            data: {"fechainicio": fechainicio,"fechafin": fechafin},
            async:false,
            success: function(response) {
                if (response.status == "success") {
                    for (var i = 0; i < response.datos.length; i++) {
                        var record = response.datos[i];
                        tableFiniquitosComplementos.push(record);
                        $("#tablaComplementoFiniquito").show();
                       // waitingDialog.hide();
                    }
                    loadDataInTableFiniquitosComplementos(tableFiniquitosComplementos);

                } else {
                    var mensaje = response.message;
                    $("#tablaComplementoFiniquito").hide();
                   // waitingDialog.hide();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
                $("#tablaComplementoFiniquito").hide();
               // waitingDialog.hide();
            }
        });
    }
}
 var tableFiniquitosParaComplementos = null;

 function loadDataInTableFiniquitosComplementos(data) {
     if (tableFiniquitosParaComplementos != null) {
         tableFiniquitosParaComplementos.destroy();
     }
     tableFiniquitosParaComplementos = $('#tablaComplementoFiniquito').DataTable({
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
         destroy: true,
         "columns": [

         {
          "data": "NumeroEmpleado"
         }, 
         { 
           "data": "NombreEmpleado"
         }, 
         {   
             "data": "EntidadFederativa"
         }, 
         {
             "data": "fechaAlta" 
         }, 
         {   
             "data": "fechaBaja" 
         }, 
         {   "className": "dt-body-center",
             "data": "netoAlPago" 
         }, 
         {   
             "data": "accion"
         }, ],
         // ]
         //,serverSide: true
         processing: true,
         dom: 'Bfrtip',
        buttons: {
        buttons: []
    }    
     });
 }

 function MostrarModalIngresoComplemento(EntidadEmpleado,ConsecutivoEmpleado,CategoriaEmlpeado,MontoFiniquito,folioFiniquito){
    var NumeroEmpleadocompleto = EntidadEmpleado + "-" + ConsecutivoEmpleado + "-" +CategoriaEmlpeado;
    $("#numEmpleadoComp").val(NumeroEmpleadocompleto);
    $("#montoFiniquitoComp").val(MontoFiniquito);
    $("#montoTotalComp").val("");
    $("#montoSolicitarComp").val("");
    $("#ModalComplementoF").modal();
    $("#FolioFiniquito").val(folioFiniquito);
 }

$("#montoTotalComp").blur(function (){
   var montoF = $("#montoFiniquitoComp").val();
   var montoS = $("#montoTotalComp").val();
   var montoFF = parseInt(montoF);
   var montoSS = parseInt(montoS);
   
   if(montoS == ""){
        cargaerroresModaComplementosFiniquitos("Ingrese Un monto");
        $("#montoSolicitarComp").val("");
        $("#montoTotalComp").val("");
   }else if(montoSS<montoFF){
        cargaerroresModaComplementosFiniquitos("El Monto Total A Dar No Puede Ser Menor AL Monto Del Finiquito Del Empleado");
        $("#montoSolicitarComp").val("");
        $("#montoTotalComp").val("");
   }else if(!/^([0-9])*$/.test(montoS)){
        cargaerroresModaComplementosFiniquitos("El Monto Ingresado Debe Ser Entero Sin Punto Decimal !!!");
        $("#montoSolicitarComp").val("");
        $("#montoTotalComp").val("");
   }else{
    var montoASolicitar = montoSS - montoFF;
    $("#montoSolicitarComp").val(montoASolicitar);
   }
});

 function cargaerroresModaComplementosFiniquitos(mensaje){
  $('#msmErrorCompelementoF').fadeIn('slow');
  alerterror="<div class='alert alert-error' id='msmErrorCompelementoF'>"+mensaje+"<data-dismiss='alert'>";
  $("#msmErrorCompelementoF").html(alerterror);
  $('#msmErrorCompelementoF').delay(3000).fadeOut('slow');
}

$("#btnConfirmarComp").click(function (){
    var montoTotalC = $("#montoTotalComp").val();
    var montoSolicitadoC = $("#montoSolicitarComp").val();
    var FolioFiniquito = $("#FolioFiniquito").val();
    var numEmpleadoComp = $("#numEmpleadoComp").val();
    if(montoSolicitadoC=="" || montoTotalC==""){
        cargaerroresModaComplementosFiniquitos("Ingresa Un Monto Valido!!!");
    }else{

        $.ajax({
        type: "POST",
        url: "ajax_SolicitarComplementoFiniquito.php",
        data:{"montoSolicitadoC":montoSolicitadoC,"FolioFiniquito":FolioFiniquito,"numEmpleadoComp":numEmpleadoComp},
        dataType: "json",
        success: function(response) {
            var mensajee = "Solicitud Enviada Correctamente Esperando Respuesta !!"
            $('#msgErrorComplementoFiniquito').fadeIn('slow');
            alerterror="<div class='alert alert-success' id='msgErrorComplementoFiniquito'>"+mensajee+"<data-dismiss='alert'>";
            $("#msgErrorComplementoFiniquito").html(alerterror);
            $('#msgErrorComplementoFiniquito').delay(3000).fadeOut('slow');
            $("#ModalComplementoF").modal("hide");
            $("#ModalMsm").modal();
            ConsultaFiniquitosParaComplemento();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
        }
      }); 
    }
});
$("#btnConfirmarMensaje").click(function (){
    $("#ModalMsm").modal("hide");
});
$("#btnCancelarComp").click(function (){
    $("#ModalComplementoF").modal("hide");
});

 </script>