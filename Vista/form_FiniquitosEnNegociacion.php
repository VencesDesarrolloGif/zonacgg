<div id='msgerrorinputmonto' name='msgerrorinputmonto' ></div>
<div id='msgerrorinputmontomenor' name='msgerrorinputmontomenor' ></div>
<center><h3>Finiquitos en Negociacion</h3></center>
<br>
<center>
    <img title='Cargar/Actualizar Pagina' src='img/ActualizarEjecutar.jpg' class='cursorImg' id='btnguardar' onclick="ConsultaFiniquitosNeg();" width="50px">
</center>
<br>
<section>
    <center>
        <table id="tablaNegociacion"  width="100%" class="records_list table table-striped table-bordered table-hover" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th style="text-align: center;background-color: #B0E76E">Número empleado</th>
                    <th style="text-align: center;background-color: #B0E76E">Nombre</th>
                    <th style="text-align: center;background-color: #B0E76E">Puesto</th>
                    <th style="text-align: center;background-color: #B0E76E">Entidad</th>
                    <th style="text-align: center;background-color: #B0E76E">Cobertura</th>
                    <th style="text-align: center;background-color: #B0E76E">Monto Uniformes</th>
                    <th style="text-align: center;background-color: #B0E76E">Monto Contabilidad</th>
                    <th style="text-align: center;background-color: #B0E76E">Monto Pension</th>
                    <th style="text-align: center;background-color: #B0E76E">Monto Infonavit</th>
                    <th style="text-align: center;background-color: #B0E76E">Monto Fonacot</th>
                    <th style="text-align: center;background-color: #B0E76E">Deuda Total</th>
                    <th style="text-align: center;background-color: #B0E76E">Piramidar a $1</th> 
                    <th style="text-align: center;background-color: #B0E76E">Estatus</th>
                    <th style="text-align: center;background-color: #B0E76E">Tiempo Para Realizar Negociación</th>
                </tr>
            </thead>
        </table>
    </center>
</section>
<div id="ModalMontoNegociado" name="ModalMontoNegociado" class="modalEdit hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div id='msgerrormodalpiramidar' name='msgerrormodalpiramidar' ></div>
    <div class="modal-header">
    <h4 class="modal-title" id="myModalLabelrechazadobajaimss" align="center"> <img src="img/money.png">Ingresa Finiquito Negociado</h4>
    </div>
    <div class="modal-body" align="center">
        <div class="input-prepend">
          <span class="add-on"># Empleado</span>
          <input id="NumEmpleadoModal" name="NumEmpleadoModal" type="text" class="input-medium" readonly>
          <input id="NumeroEmpleadohiden" name="NumeroEmpleadohiden" type="hidden" class="input-medium">
        </div>
          <div class="input-prepend">
          <span class="add-on">Monto Deuda</span>
          <input id="MontoDeudaModal" name="MontoDeudaModal" type="text" class="input-medium" readonly>
          <span class="add-on">Monto Negociado</span>
          <input id="MontoAcuerdo" name="MontoAcuerdo" type="text" class="input-medium">
        </div>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick='ConfirmarMonto();'>Confirmar</button>
        <button type="button" class="btn btn-danger" onclick='Cancelar();'>Cancelar</button>
      </div>
</div>

<script type="text/javascript"> //empieza lo de js

$(inicioFiniNegociacion());  

function inicioFiniNegociacion(){
    setInterval("ConsultaFiniquitosNeg();",600000);
    ConsultaFiniquitosNeg();
}

 function ConsultaFiniquitosNeg() { //finiquitos calculados con piramidar
     tableFiniquitosNegociacion = [];
     $.ajax({
         type: "POST",
         url: "ajax_consultafiniquitosnegativos.php",
         dataType: "json",
         success: function(response) {
             if (response.status == "success") {
                 for (var i = 0; i < response.datos.length; i++) {
                    var record = response.datos[i];
                    var DiasTotales = record["DiasTotales"];
                    var numempleado = record["numempleado"];
                    var netoAlPago = record["netoAlPago"];
                    var fechaBajaImss = record["fechaBajaImss"];
                    if(DiasTotales <= "0"){
                        var DiasTotales1 = Math.abs(DiasTotales);
                        alert("El Numero De Empleado "+numempleado+" Con Una Deuda De "+netoAlPago+" Dado De Baja El Dia "+fechaBajaImss+" Tiene Que Ser Piramidado, Excedio El Tiempo De Espera para Su Negociacion Por "+DiasTotales1+" Dias (Mensaje De Seguimiento)");
                    }else if(DiasTotales > "0" && DiasTotales <= "5"){
                        alert("El Numero De Empleado "+numempleado+" Con Una Deuda De "+netoAlPago+" Dado De Baja El Dia "+fechaBajaImss+" Tiene Que Ser Piramidado, Está A "+DiasTotales+" Dias De Pasar El Tiempo De Espera Para Su Negociación (Mensaje de Seguimiento)");
                    }
                    tableFiniquitosNegociacion.push(record); 
                 }
                 loadDataInTableFiniquitosNegociacion(tableFiniquitosNegociacion);
             } else {
                 var mensaje = response.message;
             }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
 }
 var tableFiniquitosEnNegociacion = null;

 function loadDataInTableFiniquitosNegociacion(data) {
     if (tableFiniquitosEnNegociacion != null) {
         tableFiniquitosEnNegociacion.destroy();
     }
     tableFiniquitosEnNegociacion = $('#tablaNegociacion').DataTable({
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
          "data": "numempleado"
         }, 
         { 
           "data": "nombreempleado"
         }, 
         {   
             "data": "descripcionPuesto"
         }, 
         {   
             "data": "nombreEntidadFederativa"
         },
         {   
             "data": "Cobertura"
         },
         {   
             "data": "uniformesFiniquito"
         },
         {   
             "data": "DeudaContabilidad"
         },
         {   
             "data": "pensionFiniquito"
         }, 
         {   
             "data": "infonavitFiniquito"
         }, 
         {   
             "data": "fonacotFiniquito"
         },  
         {   "className": "dt-body-right",
             "data": "netoAlPago" 
         }, 
         {   "className": "dt-body-center",
             "data": "piramidar1" 
         }, 
         {   
             "data": "estatusFiniquito"
         },
         {   
             "data": "TiempoPirAuto"
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
 
function Cancelar(){
    
    $("#ModalMontoNegociado").modal("hide");
}

function ConfirmarMonto(){
   var numempleado    = $("#NumeroEmpleadohiden").val();
    var MontoAcuerdo  = $("#MontoAcuerdo").val();
    var empleadosplit = numempleado.split("-");
    var entidademp    = empleadosplit[0];
    var consecutivoemp= empleadosplit[1];
    var categoriaemp  = empleadosplit[2];

  if(entidademp=="1" || entidademp=="2" ||entidademp=="3" ||entidademp=="4" ||entidademp=="5" ||entidademp=="6" ||entidademp=="7" ||entidademp=="8" ||entidademp=="9"){
         entidademp= "0"+entidademp;
    }
    if(categoriaemp=="1" || categoriaemp=="2" ||categoriaemp=="3" ||categoriaemp=="4" ||categoriaemp=="5" ||categoriaemp=="6" ||categoriaemp=="7" ||categoriaemp=="8" ||categoriaemp=="9"){
        categoriaemp= "0"+categoriaemp;
    }

    if(MontoAcuerdo == "" || MontoAcuerdo < "1"){
         var mensaje ="Ingrese el monto negociado";
         alertMsg="<div id='msgalertmontononumerico' class='alert alert-error'><strong>Error:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#msgerrormodalpiramidar").html(alertMsg);
            $(document).scrollTop(0);
            $('#msgalertmontononumerico').delay(6000).fadeOut('slow');
    }

    else if(MontoAcuerdo == "1"){
         var mensaje ="No puede hacer una petición de $1, por favor regrese a la pagina principal y acepte piramidar a $!";
         alertMsg="<div id='msgalertmontononumerico' class='alert alert-error'><strong>Error:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#msgerrormodalpiramidar").html(alertMsg);
            $(document).scrollTop(0);
            $('#msgalertmontononumerico').delay(6000).fadeOut('slow');

    }else if(!/^([0-9])*$/.test(MontoAcuerdo)){ 
            
        var mensaje ="Solo valores numericos ";
         alertMsg="<div id='msgalertmontononumerico' class='alert alert-error'><strong>Error:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#msgerrormodalpiramidar").html(alertMsg);
            $(document).scrollTop(0);
            $('#msgalertmontononumerico').delay(6000).fadeOut('slow');

        }else{ 

     $.ajax({
         type: "POST",
         url: "ajax_actualizarEstatusyMonto.php",
          data:{"entidademp":entidademp,"consecutivoemp":consecutivoemp,"categoriaemp":categoriaemp, "MontoAcuerdo":MontoAcuerdo},
         dataType: "json",
         success: function(response) {

             if (response.status == "success") {
                $("#ModalMontoNegociado").modal("hide");
                ConsultaFiniquitosNeg();
              } else {
                 var mensaje = response.message;
                 alert(mensaje);
             }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
    
 }
}

function btnpiramidarA1(folioBajaImss,numempleado,netoAlPago,netoAlPagocalculado,fechabaja,fechaingreso) {

    var empleadosplit = numempleado.split("-");
    var entidademp = empleadosplit[0];
    var consecutivoemp = empleadosplit[1];
    var categoriaemp = empleadosplit[2];
    var fechabaja = fechabaja;
    var fechaalta = fechaingreso;

    if(entidademp=="1" || entidademp=="2" ||entidademp=="3" ||entidademp=="4" ||entidademp=="5" ||entidademp=="6" ||entidademp=="7" ||entidademp=="8" ||entidademp=="9"){
         entidademp= "0"+entidademp;
    }
    if(categoriaemp=="1" || categoriaemp=="2" ||categoriaemp=="3" ||categoriaemp=="4" ||categoriaemp=="5" ||categoriaemp=="6" ||categoriaemp=="7" ||categoriaemp=="8" ||categoriaemp=="9"){
        categoriaemp= "0"+categoriaemp;
    }
     $.ajax({
         type: "POST",
         url: "ajax_actualizarPiramidar1.php",
          data:{"entidademp":entidademp,"consecutivoemp":consecutivoemp,"categoriaemp":categoriaemp,"netoAlPago":netoAlPago,"netoAlPagocalculado":netoAlPagocalculado},
         dataType: "json",
         async: false,
         success: function(response) {
             if (response.status == "success") {
                calculoFiniquito(folioBajaImss);
                window.open("../Nominas/finiquitos/generadordocfiniquito.php?numempleado=" + numempleado + "&" + "fechabaja=" + fechabaja + "&" + "fechaalta=" + fechaalta, 'fullscreen=no');
                eliminadeducciones(numempleado);
                if(Bandera=="Piramidacion De Laborales"){
                    ConsultaFiniquitosNeg();
                }
             }else{
                var mensaje = response.message;
                alert(mensaje);
             }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     }); 
 } 

  function eliminadeducciones(numempleado) {
     //aqui se eliminaran las deducciones de infonavit fonacot prestamo pension finiquitos
     $.ajax({
         type: "POST",
         url: "../Nominas/finiquitos/ajax_deleteDeducciones.php",
         dataType: "json",
         data: {
             "numempleado": numempleado
         },
         success: function(response) {
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
 }

 function btninsertarmonto(numempleado,netoAlPago) {
    //alert(numempleado);
    //alert(netoAlPago);
    $("#MontoAcuerdo").val("");
    $("#NumEmpleadoModal").val("");
    $("#MontoDeudaModal").val("");
    $("#NumeroEmpleadohiden").val("");
    $("#NumEmpleadoModal").val(numempleado);
    $("#MontoDeudaModal").val(netoAlPago);
    $("#NumeroEmpleadohiden").val(numempleado);
    $("#ModalMontoNegociado").modal();
 }
 </script>