<meta charset="utf-8"/>
<legend>Lista De Vehiculos A Su Cargo </legend>

<div>
    <button id="btnConsultarVehiculosAcargo" style="width: 150px;height: 40px;border-radius: 20px;background-color: rgba(159, 209, 13, .8);color: blue;">Consultar</button>
</div><br>

<div class="containerTablePuntos" align="center" id="divtabla" style="display:none;">
        <section>
          <table id="tableVehiculosAsignados" class="display" cellspacing="0" width="150%">
            <thead>
              <tr>
                <th>N° ECONOMICO</th>
                <th>LINEA DE NEGOCIO</th>
                <th>N° PLACAS</th>
                <th>MARCA</th>
                <th>MODELO</th>
                <th>COLOR VEHICULO</th>
                <th>AÑO</th>
                <th>CILINDRADA</th>
                <th>COLOR ENGOMADO</th>
                <th>ENTIDAD ASIGNADA DEL VEHICULO</th>
                <th>EMPLEADO ASIGNADO</th>
                <th>POLIZA  DE SEGURO</th>
                <th>TARJETA DE CIRCULACIÓN</th>
                <th>LICENCIA</th>
                <th>TALON DE VERIFICACIÓN</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </section>
      </div>

<script type="text/javascript">

var tablavehiculoscalulo = null;
var rolUsuario="<?php echo $usuario['rol']; ?>";

$("#btnConsultarVehiculosAcargo").click(function(){
    MostrarTalbaVehiculosAsignados();
});

function MostrarTalbaVehiculosAsignados() {

     tablaVehiculosAsignados = [];
     $.ajax({
         type: "POST",
         url: "ajax_obtenerTablaVehiculosAsignados.php",
         dataType: "json",
         success: function(response) {
             if (response.status == "success") {
                   for (var i = 0; i < response.data.length; i++) {
                      // for (var j = 0; j < response.data[i].length; j++) {
                           var record = response.data[i];
                         //  console.log(record);
                           tablaVehiculosAsignados.push(record);
                           
                       // }
                   }
                       $("#tableVehiculosAsignados").show();
                       loadDatatoblevehiculosAsignados(tablaVehiculosAsignados);
             } else {
                 $("#tableVehiculosAsignados").hide();
                 var mensaje = response.message;
                 alert("mal");
             }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
 }


 function loadDatatoblevehiculosAsignados(data) {
     if (tablavehiculoscalulo != null) {
         tablavehiculoscalulo.destroy();
     }
     tablavehiculoscalulo = $('#tableVehiculosAsignados').DataTable({
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
       { "data": "NumeroEconomico"}
      ,{ "data": "DescripcionLineaNegocio"}
      ,{ "data": "Placas"}
      ,{ "data": "Marca"}
      ,{ "data": "Modelo"}
      ,{ "data": "ColorVehiculo"}
      ,{ "data": "AnioVehuiculo"}
      ,{ "data": "Cilindrada"}
      ,{ "data": "ColorEngomado"}
      ,{ "data": "nombreEntidadF"}
      ,{ "data": "empleadoasignado"}
      ,{ "data": "Poliza"}
      ,{ "data": "Tarjeta"}
      ,{ "data": "Licencia"}
      ,{ "data": "verificacion"}
      ],
         processing: true,
         dom: 'Bfrtip',
         buttons: ['excel',{orientation:'landscape',extend:'pdf',pageSize:'LEGAL'}]
     });
$("#divtabla").show();
 }

  function cargarpdfVehiculos1(caso, nombre)
 {
  if(caso==1){
       window.open("uploads/ParqueVehicular/fotospolizaseguros/" + nombre);  
  }else if(caso==2){
        window.open("uploads/ParqueVehicular/fotostarjetacirculacion/" + nombre);  
  }else if(caso==3){
        window.open("uploads/ParqueVehicular/DocumentosVerificaciones/TalonesVerificaciones/" + nombre);  
  }else if(caso==4){
        window.open("uploads/documentosdigitalizados/" + nombre);
  }
 }


  </script>

