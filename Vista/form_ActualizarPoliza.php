<meta charset="utf-8"/>

<legend>ACTUALIZACIONES DE PÓLIZAS DE SEGUROS</legend>
<div>
    <button id="btnConsultarActPolizas" style="width: 150px;height: 40px;border-radius: 20px;background-color: rgba(159, 209, 13, .8);color: blue;">Consultar</button>
</div><br>

<a id="PolizaconVigencia"onclick="MostrarTablaVigenciaPoliza(0)"style="cursor: pointer;display: none;" data-toggle="tab">LISTA DE PÓLIZAS VIGENTES</a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
<a id="PolizaProximasAvencer"onclick="MostrarTablaVigenciaPoliza(1)"style="cursor: pointer;display: none;" data-toggle="tab">LISTA DE PÓLIZAS PROXIMAS A VENCER</a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
<a id="PolizaVencidas" onclick="MostrarTablaVigenciaPoliza(2);" style="cursor: pointer;display: none;" data-toggle="tab">LISTA DE PÓLIZAS VENCIDAS</a><br><br>

<h3 id="listaPolizavegente" style="display: none;">LISTA DE PÓLIZAS VIGENTES</h3>
<h3 id="listaPolizaproximaavencer" style="display: none;">LISTA DE PÓLIZAS PROXIMAS A VENCER</h3>
<h3 id="listaPolizavencias" style="display: none;">LISTA DE PÓLIZAS VENCIDAS</h3>

<div align="center" id="divtablaPoliza" style="display: none;">
        <section>
          <table id="tablaPoliza" align="center" border="1" cellspacing="0" width="90%">
            <thead>
              <tr>
                <th>N° ECONOMICO</th>
                <th>LINEA DE NEGOCIO</th>
                <th>ENTIDAD FEDERATIVA</th>
                <th>PLACAS</th>
                <th>MARCA</th>
                <th>MODELO</th>
                <th>ASEGURADORA</th>
                <th>N° PÓLIZA</th>
                <th>FECHA DE VENCIMIENTO</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </section>
      </div>

<script type="text/javascript">

var tablaPoliza1 = null;
var rolUsuario="<?php echo $usuario['rol']; ?>";

$("#btnConsultarActPolizas").click(function(){
    MostrarTalbaActualizacionDePoliza();
});

function MostrarTalbaActualizacionDePoliza() {
  $("#divtablaPoliza").hide();
  $("#PolizaconVigencia").show();
  $("#PolizaProximasAvencer").show();
  $("#PolizaVencidas").show();
 }

function MostrarTablaVigenciaPoliza(consulta) {

  if(consulta==0){
    $("#listaPolizavegente").show();
    $("#listaPolizaproximaavencer").hide();
    $("#listaPolizavencias").hide();
  }else if(consulta==1){
    $("#listaPolizavegente").hide();
    $("#listaPolizaproximaavencer").show();
    $("#listaPolizavencias").hide();
  }else if(consulta==2){
    $("#listaPolizavegente").hide();
    $("#listaPolizaproximaavencer").hide();
    $("#listaPolizavencias").show();
  }
     tablaPoliza = [];
     $.ajax({
         type: "POST",
         url: "ajax_obtenerTablaPoliza.php",
         data:{"consulta": consulta},
         dataType: "json",
         success: function(response) {
             if (response.status == "success") {
                   for (var i = 0; i < response.data.length; i++) {
                      var record = response.data[i];
                     // console.log(record);
                      tablaPoliza.push(record);
                    }  
                       loadDatatablePoliza(tablaPoliza);
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

 function loadDatatablePoliza(data) {
     if (tablaPoliza1 != null) {
         tablaPoliza1.destroy();
     }
     tablaPoliza1 = $('#tablaPoliza').DataTable({
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
      ,{ "data": "LineaNegocio"}
      ,{ "data": "EntidadFederativa"}
      ,{ "data": "Placas"}
      ,{ "data": "Marca"}
      ,{ "data": "Modelo"}
      ,{ "data": "Aseguradora"}
      ,{ "data": "NumeroPoliza"}
      ,{ "data": "FechaPoliza"}
      ],
         processing: true,
         dom: 'Bfrtip',
         buttons: [{
      extend: 'excel',
      title: 'Poliza de seguro',
      messageTop: '',
      messageBottom: '',
      orientation: 'landscape',
      customizeData: function(data) {//esto se hizo para cambiar el tipo de dato de entero a texto para evitar que el excel 
        for(var i = 0; i < data.body.length; i++) {
          for(var j = 0; j < data.body[i].length; j++) {
            data.body[i][j] = '\u200C' + data.body[i][j];
          }
        }
      }
    },{orientation:'landscape',extend:'pdf',pageSize:'LEGAL'}]
     });
$("#divtablaPoliza").show();
 }
/*
$(document).ready(function() {
    $('#example').DataTable({
        dom: 'Bfrtip',
        buttons: [{
            extend: 'excelHtml5',
            customize: function(xlsx) {
                var sheet = xlsx.xl.worksheets['sheet1.xml'];
 
                // Loop over the cells in column `C`
                $('row c[r^="C"]', sheet).each( function () {
                    // Get the value
                    if ( $('is t', this).text() == 'New York' ) {
                        $(this).attr( 's', '20' );
                    }
                });
            }
        }]
    });
});*/
  </script>
