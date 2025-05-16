<div class="container" align="center">
  <form class="form-horizontal"  method="post" id="form_consultaUniformes" name="form_consultaUniformes" action="" target="_blank">
    <fieldset>        
      <h1>Stock Uniformes</h1>
    </fieldset>
    <br>
    <img src="img/botonbuscar.jpg" id="btnBuscarStockUniformes" width="150">
    <br>
    <br>
  
    <section>
      <table id="tablaUniformes" class="display" cellspacing="0" width="80%">
        <thead>
          <tr>
            <th>Clave Uniforme</th>
            <th>Descripcion</th>
            <th>Entidad</th>  
            <th>Sucursal</th>  
            <th>Costo Unitario</th>  
            <th>Cantidad</th>                        
            <th>Costo Total</th> 
          </tr>
        </thead>

        <tbody></tbody>
      </table>
    </section>
  </form>
</div>
<script type="text/javascript">

$("#btnBuscarStockUniformes").click(function(){
  getStockUniforme();
});
// $(getStockUniforme());  
var tableUniformes = null;

function getStockUniforme(){
    var dataTableUniformes = [];

    $.ajax ({
        type: "POST"
        ,url: "ajax_getStockUniformes.php"
        ,dataType: "json"
        ,async: false
        ,success: function (response){
            if (response.status == "success"){
                for (var i = 0; i < response.data.length; i++){
                    var record = response.data[i];
                    dataTableUniformes.push (record);                                            
                }
                loadDataInTableUnifomes (dataTableUniformes);
            }
        }
        ,error: function(jqXHR, textStatus, errorThrown){
              alert(jqXHR.responseText); 
        }
    });
}

function loadDataInTableUnifomes (data){
    
    if(tableUniformes != null){
        tableUniformes.destroy ();
    }

    tableUniformes = $('#tablaUniformes').DataTable( {
          "language" : {
              "emptyTable" :         "No hay uniformes disponibles en la tabla",
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
            { "data": "tipoUniforme" }
            ,{ "data": "descripcionUniforme"}
            ,{ "data": "entidadUniforme"}
            ,{ "data": "nombreSucursal"}
            ,{ "data": "costoUniforme", render: $.fn.dataTable.render.number(',','.', 2,'$')}
            ,{ "data": "cantidadUniformes" }
             ,{ "data": "totalCosto", render: $.fn.dataTable.render.number(',','.', 2,'$') }
       ]
        ,processing: true
        ,dom: 'Bfrtip'
        ,buttons: ['excel']
    });
}
</script>