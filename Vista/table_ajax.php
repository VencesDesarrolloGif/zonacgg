 <table id="example2" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Apellido Paterno</th>
            <th>Apellido Materno</th>
            <th>Nombre(s)</th>
        </tr>
    </thead>

    <tbody></tbody>

    <tfoot>
        <tr>
            <th>Apellido Paterno</th>
            <th>Apellido Materno</th>
            <th>Nombre(s)</th>
        </tr>
    </tfoot>
</table>

<script type="text/javascript">
	
$(inicioTable_ajax());  
function inicioTable_ajax(){
    var table = $('#example2').DataTable( {
        ajax: {
            url: 'ajax_obtenerEmpleadosPorEstatus.php'
            ,type: 'POST'
            ,data : {"estatusEmpleado":2}
        }
        ,"columns": [
            { "data": "apellidoPaterno" }
            ,{ "data": "apellidoMaterno" }
            ,{ "data": "nombreEmpleado" }
        ]
        //,serverSide: true
        ,processing: true
        ,initComplete: function () {
            new $.fn.dataTable.KeyTable( table );
        }
    } );
}
</script>