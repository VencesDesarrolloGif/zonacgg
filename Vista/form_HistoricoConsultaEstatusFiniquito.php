<div id="mserrorHistoricoEstatisFiniquito"></div>
<center><h3>Historico de Consultas a Estatus de Finiquito</h3></center><br>
<div align="center">
<span class="add-on" style="align-content: center;">Fecha Baja  Del:</span>
    <input id="fechaInicio" name="fechaInicio" type="date" class="input-medium">
    <span class="add-on">Al:</span>
    <input id="fechaFin" name="fechaFin" type="date" class="input-medium" >
    <button id="btnBuscarCF" name="btnBuscarCF" onclick="consultaHistoric000o()">Buscar</button>
</div>
<div class="input-prepend" style="display: none;" id="divimg" name="divimg">
    <img title='Cargado' src='img/ok.png' class='cursorImg' width='45'>
</div>
<div class="input-prepend" style="display: none;" id="divimg1" name="divimg1">
<h3>Información Cargada</h3> 
</div>
<br>
<div class="input-prepend" style="display: none;" id="divimg2" name="divimg2">
    <img title='No Cargado' src='img/rechazarImss.png' class='cursorImg' width='45'>
</div>
<div class="input-prepend" style="display: none;" id="divimg3" name="divimg3">
<h3>Información No Cargada</h3>
</div>
   

<section>
     <table id="tablaHistoricoConsultaEstatus" style="display: none;"  class="records_list table table-striped table-bordered table-hover" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th style="text-align: center;background-color: #B0E76E">Numero Empleado Consultado</th>
                <th style="text-align: center;background-color: #B0E76E">Nombre</th> 
                <th style="text-align: center;background-color: #B0E76E">Entidad</th>  
                <th style="text-align: center;background-color: #B0E76E">Fecha Baja imss</th>            
                <th style="text-align: center;background-color: #B0E76E">Estatus Prestamo</th>
                <th style="text-align: center;background-color: #B0E76E">Fecha Carga Prestamo</th>
                <th style="text-align: center;background-color: #B0E76E">Estatus Amortizacion</th>
                <th style="text-align: center;background-color: #B0E76E">Fecha Carga Amortizacion</th>
                <th style="text-align: center;background-color: #B0E76E">Estatus Fonacot</th>
                <th style="text-align: center;background-color: #B0E76E">Fecha Carga Fonacot</th>
                <th style="text-align: center;background-color: #B0E76E">Estatus Pension</th>
                <th style="text-align: center;background-color: #B0E76E">Fecha Carga Pension</th>
                <th style="text-align: center;background-color: #B0E76E">Estatus Dias Trabajados</th>
                <th style="text-align: center;background-color: #B0E76E">Fecha Carga Dias Trabajados</th>
                <th style="text-align: center;background-color: #B0E76E">Dias Vacaciones</th>
                <th style="text-align: center;background-color: #B0E76E">Estatus Negociacion</th> 
                <th style="text-align: center;background-color: #B0E76E">Fecha que se Consultó</th> 
                <th style="text-align: center;background-color: #B0E76E">Usuario que Consultó</th> 
            </tr>  
        </thead>
    </table>
</section>
    
<script type="text/javascript"> 
function consultaHistoric000o() { 
var tableHistoricoConsulta1 = [];
   // validacaiones de las fechas 
    var x = new Date();
    var fechainicio =$("#fechaInicio").val(); 
    var fechafin = $("#fechaFin").val();
    if(fechainicio==""){
        mensajeErrorHistoricoConsultaEstatusFiniquito("Ingrese La Fecha 'Del:'");
    }else if(fechafin==""){
        mensajeErrorHistoricoConsultaEstatusFiniquito("Ingrese La Fecha 'Al:'");
    }else if(fechainicio >= fechafin){
        mensajeErrorHistoricoConsultaEstatusFiniquito("La Fecha 'Del:'' No Puede Ser Menor A La Fecha 'Al:'");
    }else{
        waitingDialog.show(); 
        $.ajax({
         type: "POST",
         url: "ajax_consultaHistoricoEstatusFiniquito.php",
         data:{"fechainicio":fechainicio,"fechafin":fechafin},
         dataType: "json",
         async:false,
         success: function(response) {
                 if (response.status == "success") {
                     for (var i = 0; i < response.datos.length; i++) {
                         var record = response.datos[i];
                         tableHistoricoConsulta1.push(record);
                        // console.log(tableHistoricoConsulta1);
                     }
                     loadDataIntableHistoricoConsulta11(tableHistoricoConsulta1);
                     $('#tablaHistoricoConsultaEstatus').show();
                     $('#divimg').show();
                     $('#divimg1').show();
                     $('#divimg2').show();
                     $('#divimg3').show();
                     waitingDialog.hide(); 
                 } else {
                    $('#tablaHistoricoConsultaEstatus').hide();
                    $('#divimg1').hide();
                    $('#divimg2').hide();
                    $('#divimg3').hide();
                    $('#divimg').hide();
                     var mensaje = response.message;
                     //console.log("mal");
                  }
             },
             error: function(jqXHR, textStatus, errorThrown) {
                $('#tablaHistoricoConsultaEstatus').hide();
                $('#divimg1').hide();
                $('#divimg2').hide();
                $('#divimg3').hide();
                $('#divimg').hide();
                alert(jqXHR.responseText);
             }
        });
    }
 }
       
 var tableHistoricoConsultaEst = null;

 function loadDataIntableHistoricoConsulta11(data) {
     if (tableHistoricoConsultaEst != null) {
         tableHistoricoConsultaEst.destroy();
     }
     tableHistoricoConsultaEst = $('#tablaHistoricoConsultaEstatus').DataTable({
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
             "data": "NombreEmp"
         },
         {   
             "data": "Entidad"
         },
         {   
             "data": "fechaBajaImss"
         }, 
         {   
             "data": "EstatusPrestamo"
         }, 
         {   
             "data": "FechaCargaPrest"
         }, 
         {   
             "data": "EstatusAmortizacion"
         }, 
         {   
             "data": "FechaCargaAmort"
         }, 
         {   
             "data": "EstatusFonacot"
         }, 
         {   
             "data": "FechaCargaFona"
         }, 
         {   
             "data": "EstatusPension"
         }, 
         {   
             "data": "FechaCargaPensi"
         }, 
         {   
             "data": "EstatusDiasTrabajados"
         }, 
         {   
             "data": "FechaCargaDiaTrab"
         },
         {   
             "data": "EstatusDiasVacaciones"
         }, 
         {   
             "data": "EstatusNegociacion"
         },
         {   
             "data": "FechaConsultaEstatus"
         },
         {   
             "data": "UsuarioConsulta"
         },  ], processing: true,
         dom: 'Bfrtip',

        buttons: {
        buttons: []
    }
         
     });
 }

 function mensajeErrorHistoricoConsultaEstatusFiniquito(mensaje){
    $("#mserrorHistoricoEstatisFiniquito").html("");
    $("#mserrorHistoricoEstatisFiniquito").fadeIn(); 
    alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+mensaje+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#mserrorHistoricoEstatisFiniquito").html(alertMsg1); 
    $("#mserrorHistoricoEstatisFiniquito").delay('3000').fadeOut('slow');
 }
  
 </script>