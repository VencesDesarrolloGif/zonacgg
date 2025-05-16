<div class="container" align="center">
  <form class="form-horizontal"  method="post" id="form_consultaAsignaciones" name="form_consultaAsignaciones" action="" target="_blank">
    <fieldset>
      <h1>Asignaciones de Uniformes</h1>
    </fieldset>
<br>
<br>
    <select id=selTipoAsignacion>
        <option value="0">Tipo de Asignación</option>
        <option value="1">Uso Propio</option>
        <option value="2">Para Plantilla</option>
    </select>

    <br>
    <br>
        <img title='Consulta/Cargar/Actualizar Pagina' src='img/buscarIcono.jpg' class='cursorImg' id='btnConsultarAsigXtipo' width="150px"></center>
        <br>
    <section>
      <table id="tablaAsignaciones" class="display" cellspacing="0" width="80%">
        <thead>
          <tr>
            <th>Numero Empleado</th>
            <th>Nombre Empleado</th>
            <th>Punto Servicio</th>
            <th>Cliente</th>
            <th>Entidad Trabajo</th>
            <th>Codigo</th>
            <th>Descripcion</th>
            <th>Costo Unitario</th>
            <th>Cantidad</th>
            <th>Costo Asignación</th>
            <th>Fecha Asignacion</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </section>
  </form>
</div>
<script type="text/javascript">

var tableAsignaciones = null;
// $(getAsignacionUniformes());  


$("#btnConsultarAsigXtipo").click(function(){
    waitingDialog.show();
    var tipoAsignacion= $("#selTipoAsignacion").val();
    if (tipoAsignacion==0){
        alert("por favor seleccione un tipo de asignación");
        waitingDialog.hide();
        return;
    }else{
        setTimeout(function() {
  // console.log("Esto se ejecuta después de 2 segundos");
        getAsignacionUniformes(tipoAsignacion);
        }, 1000);
    }
});

function getAsignacionUniformes(tipoAsignacion){
    var dataTableAsignaciones = [];
    $.ajax ({
        type: "POST",
        url: "consultaAsignaciones/ajax_getAsignacionesUni.php",
        data:{"tipoAsignacion":tipoAsignacion},
        dataType: "json",
        async: false,
        success: function (response){
            if (response.status == "success"){
                for (var i = 0; i < response.data.length; i++){
                    var record = response.data[i];
                    dataTableAsignaciones.push (record);
                }
                waitingDialog.hide();
                loadDataInTableAsignaciones (dataTableAsignaciones);
            }
        }
        ,error :  function(jqXHR, textStatus, errorThrown){
             alert(jqXHR.responseText); 
        }
    });
}

function loadDataInTableAsignaciones (data){
    
    if (tableAsignaciones != null){
            tableAsignaciones.destroy ();
    }

    tableAsignaciones = $('#tablaAsignaciones').DataTable( {
          "language" : {
              "emptyTable" :         "No hay asignaciones disponibles en la tabla",
              "info" :               "Del _START_ al _END_ de _TOTAL_",
              "infoEmpty" :          "Mostrando 0 registros de un total de 0.",
              "infoFiltered" :       "(filtrados de un total de _MAX_ registros)",
              "infoPostFix" :        "(actualizados)",
              "lengthMenu" :         "Mostrar _MENU_ registros",
              "loadingRecords" :     "Cargando....",
              "processing"     :     "Procesando....",
              "search" :             "Buscar:",
              "searchPlaceholder" :  "Dato para buscar",
              "zeroRecords" :        "no se han encontrado coincidencias",
              "paginate" : {
                   "first" :         "Primera",
                   "last" :          "Ultima",
                   "next" :          "Siguiente",
                   "previous" :      "Anterior"
              },
              "aria" : {
                 "sortAscending" :   "Ordenación ascendente",
                 "sortDescending" :  "Ordenación descendente"
              }
           },
        data: data,
        destroy: true,
        "columns": [
            { "data": "numeroEmpleado" }
            ,{ "data": "nombreEmpleado"}
            ,{ "data": "puntoServicio"}
            ,{ "data": "cliente"}
            ,{ "data": "entidadTrabajo"}
            ,{ "data": "codigoUniforme"}
            ,{ "data": "descripcionTipo"}
            ,{ "data": "costoUniforme", render: $.fn.dataTable.render.number(',','.', 2,'$')}
            ,{ "data": "cantidadUniforme"}
            ,{ "data": "totalAsignacion", render: $.fn.dataTable.render.number(',','.', 2,'$')}
            ,{ "data": "fechaAsignacion" }
       ]
        ,processing: true
        ,dom: 'Bfrtip'
        ,buttons: ['excel']
    });
}
</script>