<div id='msgAccion' name='msgAccion' ></div>
<center><h3>Acuerdos</h3></center>
<br>
<section>
    <table id="tablaAcuerdos"  class="records_list table table-striped table-bordered table-hover" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th style="text-align: center;background-color: #B0E76E">Número empleado</th>
                <th style="text-align: center;background-color: #B0E76E">Nombre</th>
                <th style="text-align: center;background-color: #B0E76E">Puesto</th>
                <th style="text-align: center;background-color: #B0E76E">Entidad</th>       
                <th style="text-align: center;background-color: #B0E76E">Finiquito Acordado</th>
                <th style="text-align: center;background-color: #B0E76E">Acción</th> 
            </tr>
        </thead>
   </table>
</section>
<script type="text/javascript"> 

 $(document).ready(function() {
 consultaAcuerdosSeparacionesLaborales();
 });
 function consultaAcuerdosSeparacionesLaborales(){ 
     tableAcuerdosSL = [];
     $.ajax({
         type: "POST",
         url: "ajax_consultapiramidarDG.php",
         dataType: "json",
         success: function(response) {
             if (response.status == "success") {
                 for (var i = 0; i < response.datos.length; i++) {
                     var record = response.datos[i];
                     tableAcuerdosSL.push(record);
                 }
                 loadDataIntableAcuerdosSL(tableAcuerdosSL);
             } else {
                 var mensaje = response.message;
             }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
 }
 var tableAcuerdosSeparacionesLaborales = null;

 function loadDataIntableAcuerdosSL(data) {
     if (tableAcuerdosSeparacionesLaborales != null) {
         tableAcuerdosSeparacionesLaborales.destroy();
     }
     tableAcuerdosSeparacionesLaborales = $('#tablaAcuerdos').DataTable({
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
         {   "className": "dt-body-right",
             "data": "MontoAcordado"
         }, 
         {   "className": "dt-body-center",
             "data": "Acción"
         }, ],
         processing: true,
         dom: 'Bfrtip',

          buttons: {
        buttons: []
    }
         
     });
 } 

function confirmarbtn(folioBajaImss,numempleado,netoAlPago,opcion,MontoAcordadoCalculado,fechabaja, fechaingreso) {

    waitingDialog.show();
    var numempleadodg = numempleado.split("-");
    var entidademp    = numempleadodg[0];
    var consecutivoemp= numempleadodg[1];
    var categoriaemp  = numempleadodg[2];
    var fechabaja     = fechabaja;
    var fechaalta     = fechaingreso;

    if(entidademp=="1" || entidademp=="2" ||entidademp=="3" ||entidademp=="4" ||entidademp=="5" ||entidademp=="6" ||entidademp=="7" ||entidademp=="8" ||entidademp=="9"){
         entidademp= "0"+entidademp;
    }
    if(categoriaemp=="1" || categoriaemp=="2" ||categoriaemp=="3" ||categoriaemp=="4" ||categoriaemp=="5" ||categoriaemp=="6" ||categoriaemp=="7" ||categoriaemp=="8" ||categoriaemp=="9"){
        categoriaemp= "0"+categoriaemp;
    }

    $.ajax({
        type: "POST",
        url: "ajax_actualizarPiramidarDG.php",
        data:{"entidademp":entidademp,"consecutivoemp":consecutivoemp,"categoriaemp":categoriaemp,"netoAlPago":netoAlPago,"opcion":opcion,"MontoAcordadoCalculado":MontoAcordadoCalculado},
        dataType: "json",
        async:false,
        success: function(response) {
            $("#msgAccion").html("");
            $("#msgAccion").fadeIn();          

            if (response.status == "success") { 
                if(opcion==1){
                    var mensajePegar = "Se aceptó el finiquito correctamente"
                    calculoFiniquito(folioBajaImss);
                    eliminadeducciones(numempleado); 
                }else{
                    var mensajePegar = "Rechazado correctamente"
                }
                consultaAcuerdosSeparacionesLaborales();                
                waitingDialog.hide(); 
                alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+mensajePegar+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#msgAccion").html(alertMsg1); 
                $("#msgAccion").delay('3000').fadeOut('slow');     
            }else{
                var mensaje = response.message;
                 alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+mensaje+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#msgAccion").html(alertMsg1); 
                $("#msgAccion").delay('3000').fadeOut('slow');
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
             //console.log(response); //RESPUESTA MENSAJE SUCCES POR SI SE AGREGA UN MENSAJE DE CONFIRMADO
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
 }
</script>