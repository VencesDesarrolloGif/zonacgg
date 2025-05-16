<meta charset="utf-8"/>
<legend>ACTUALIZACIONES DE LICENCIAS</legend>
<div>
    <button id="btnConsultarActLicencias" style="width: 150px;height: 40px;border-radius: 20px;background-color: rgba(159, 209, 13, .8);color: blue;">Consultar</button>
</div><br>
<a id="LicenciaconVigencia"onclick="MostrarTablaVigenciaLicencias(0)"style="cursor: pointer;display: none;" data-toggle="tab">LISTA DE LICENCIAS VIGENTES</a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
<a id="LicenciaProximasAvencer"onclick="MostrarTablaVigenciaLicencias(1)"style="cursor: pointer;display: none;" data-toggle="tab">LISTA DE LICENCIAS PROXIMAS A VENCER</a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
<a id="LicenciaVencidas" onclick="MostrarTablaVigenciaLicencias(2);" style="cursor: pointer;display: none;" data-toggle="tab">LISTA DE LICENCIAS VENCIDAS</a><br><br>

<h3 id="listalicenciasvegente" style="display: none;">LISTA DE LICENCIAS VIGENTES</h3>
<h3 id="listalicenciasproximaavencer" style="display: none;">LISTA DE LICENCIAS PROXIMAS A VENCER</h3>
<h3 id="listalicenciasvencias" style="display: none;">LISTA DE LICENCIAS VENCIDAS</h3>

<div align="center" id="divtablalicencias" style="display: none;">
        <section>
          <table id="tablalicenciasempleados" align="center" border="1" cellspacing="0" width="90%">
            <thead>
              <tr>
                <th>N° DEL EMPLEADO</th>
                <th>NOMBRE DEL EMPLEADO</th>
                <th>LINEA DE NEGOCIO</th>
                <th>ENTIDAD FEDERATIVA</th>
                <th>ESTATUS EMPLEADO</th>
                <th>N° DE LICENCIA</th>
                <th>FECHA DE VENCIMIENTO</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </section>
      </div>

<script type="text/javascript">

var tablalicenciaactualizaciones = null;
var rolUsuario="<?php echo $usuario['rol']; ?>";

$("#btnConsultarActLicencias").click(function(event) {
     MostrarTalbaActualizacionDeLicencias();
});

function MostrarTalbaActualizacionDeLicencias() {
  $("#divtablalicencias").hide();
  $("#LicenciaconVigencia").show();
  $("#LicenciaProximasAvencer").show();
  $("#LicenciaVencidas").show();
 }

function MostrarTablaVigenciaLicencias(consulta) {

  if(consulta==0){
    $("#listalicenciasvegente").show();
    $("#listalicenciasproximaavencer").hide();
    $("#listalicenciasvencias").hide();
  }else if(consulta==1){
    $("#listalicenciasvegente").hide();
    $("#listalicenciasproximaavencer").show();
    $("#listalicenciasvencias").hide();
  }else if(consulta==2){
    $("#listalicenciasvegente").hide();
    $("#listalicenciasproximaavencer").hide();
    $("#listalicenciasvencias").show();
  }
     tablalicencias = [];
     $.ajax({
         type: "POST",
         url: "ajax_obtenerTablaLicencias.php",
         data:{"consulta": consulta},
         dataType: "json",
         success: function(response) {
             if (response.status == "success") {
                   for (var i = 0; i < response.data.length; i++) {
                      var record = response.data[i];
                      //console.log(record);
                      tablalicencias.push(record);
                    }  
                       loadDatatablelicencias(tablalicencias);
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

 function loadDatatablelicencias(data) {
     if (tablalicenciaactualizaciones != null) {
         tablalicenciaactualizaciones.destroy();
     }
     tablalicenciaactualizaciones = $('#tablalicenciasempleados').DataTable({
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
       { "data": "NumeroEmpleado"}
      ,{ "data": "NombreEmpleado"}
      ,{ "data": "LineaNegocio"}
      ,{ "data": "EntidadFederativa"}
      ,{ "data": "Estatusempleado"}
      ,{ "data": "NumeroLicencia"}
      ,{ "data": "FechaVigenciaLicencia"}
      ],
         // ]
         //,serverSide: true
         processing: true,
         dom: 'Bfrtip',
         buttons: ['excel',{orientation:'landscape',extend:'pdf',pageSize:'LEGAL'}]
     });
$("#divtablalicencias").show();
 }

  </script>

