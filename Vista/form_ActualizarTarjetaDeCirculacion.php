<meta charset="utf-8"/>
<legend>ACTUALIZACIONES DE TARJETAS DE CIRCULACIÓN</legend>

<div>
    <button id="btnConsultarActTarjetas" style="width: 150px;height: 40px;border-radius: 20px;background-color: rgba(159, 209, 13, .8);color: blue;">Consultar</button>
</div><br>

<a id="TarjetaconVigencia"onclick="MostrarTablaVigenciaTarjeta(0)"style="cursor: pointer;display: none;" data-toggle="tab">LISTA DE TARJETAS DE CIRCULACIÓN VIGENTES</a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
<a id="TarjetaProximasAvencer"onclick="MostrarTablaVigenciaTarjeta(1)"style="cursor: pointer;display: none;" data-toggle="tab">LISTA DE TARJETAS DE CIRCULACIÓN PROXIMAS A VENCER</a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
<a id="TarjetaVencidas" onclick="MostrarTablaVigenciaTarjeta(2);" style="cursor: pointer;display: none;" data-toggle="tab">LISTA DE TARJETAS DE CIRCULACIÓN VENCIDAS</a><br><br>

<h3 id="listaTarjetasvegente" style="display: none;">LISTA DE TARJETAS DE CIRCULACIÓN VIGENTES</h3>
<h3 id="listaTarjetasproximaavencer" style="display: none;">LISTA DE TARJETAS DE CIRCULACIÓN PROXIMAS A VENCER</h3>
<h3 id="listaTarjetasvencias" style="display: none;">LISTA DE TARJETAS DE CIRCULACIÓN VENCIDAS</h3>

<div align="center" id="divtablaTarjeta" style="display: none;">
        <section>
          <table id="tablaTarjetaCirculacion" align="center" border="1" cellspacing="0" width="90%">
            <thead>
              <tr>
                <th>N° ECONOMICO</th>
                <th>LINEA DE NEGOCIO</th>
                <th>ENTIDAD FEDERATIVA</th>
                <th>PLACAS</th>
                <th>COLOR DEL ENGOMADO</th>
                <th>TIPO DE TARJETA</th>
                <th>FECHA DE VENCIMIENTO</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </section>
      </div>

<script type="text/javascript">

var tablaTarjetaactualizaciones = null;
var rolUsuario="<?php echo $usuario['rol']; ?>";

$("#btnConsultarActTarjetas").click(function(){
    MostrarTalbaActualizacionDeTarjetas();
});

function MostrarTalbaActualizacionDeTarjetas() {
  $("#divtablaTarjeta").hide();
  $("#TarjetaconVigencia").show();
  $("#TarjetaProximasAvencer").show();
  $("#TarjetaVencidas").show();
 }

function MostrarTablaVigenciaTarjeta(consulta) {

  if(consulta==0){
    $("#listaTarjetasvegente").show();
    $("#listaTarjetasproximaavencer").hide();
    $("#listaTarjetasvencias").hide();
  }else if(consulta==1){
    $("#listaTarjetasvegente").hide();
    $("#listaTarjetasproximaavencer").show();
    $("#listaTarjetasvencias").hide();
  }else if(consulta==2){
    $("#listaTarjetasvegente").hide();
    $("#listaTarjetasproximaavencer").hide();
    $("#listaTarjetasvencias").show();
  }
     tablaTarjeta = [];
     $.ajax({
         type: "POST",
         url: "ajax_obtenerTablaTarjetaC.php",
         data:{"consulta": consulta},
         dataType: "json",
         success: function(response) {
             if (response.status == "success") {
                   for (var i = 0; i < response.data.length; i++) {
                      var record = response.data[i];
                      //console.log(record);
                      tablaTarjeta.push(record);
                    }  
                       loadDatatableTarjeta(tablaTarjeta);
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

 function loadDatatableTarjeta(data) {
     if (tablaTarjetaactualizaciones != null) {
         tablaTarjetaactualizaciones.destroy();
     }
     tablaTarjetaactualizaciones = $('#tablaTarjetaCirculacion').DataTable({
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
      ,{ "data": "ColorEngomado"}
      ,{ "data": "TipoTarjeta"}
      ,{ "data": "FechaVigenciaTarjeta"}
      ],
         // ]
         //,serverSide: true
         processing: true,
         dom: 'Bfrtip',
         buttons: ['excel',{orientation:'landscape',extend:'pdf',pageSize:'LEGAL'}]
     });
$("#divtablaTarjeta").show();
 }

  </script>

