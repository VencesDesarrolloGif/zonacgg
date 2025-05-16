var tablaGeoDePuntos = null;
$("#BuscarGeo").click(function() {
    datatablaGeoDePuntos = [];
    $.ajax({
        type: "POST",
        url: "GeoPorPuntos/ajax_ObtneerGeoDePuntos.php",
        dataType: "json",
        async: false,
        success: function(response) {
            for (var i = 0; i < response.datos.length; i++) {
                var record = response.datos[i];
                datatablaGeoDePuntos.push(record);
            }
            loadDataInTablaGeoPuntos(datatablaGeoDePuntos);
            $("#tablaGeoPorPuntos").show();
        },error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
            $("#tablaGeoPorPuntos").hide();
        }
    });
});

function loadDataInTablaGeoPuntos(data) {
    if (tablaGeoDePuntos != null) {
        tablaGeoDePuntos.destroy();
    }
    tablaGeoDePuntos = $('#tablaGeoPorPuntos').DataTable({
        "language": {
            "emptyTable": "No hay registro de asistencia disponible",
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
        "columns": [{
                "data": "idPuntoServicio"
            }, {
                "data": "puntoServicio"
            }, {
                "data": "Estatus"
            }, {
                "data": "fechaInicioServicio"
            }, {
                "data": "fechaTerminoServicio"
            }, {
                "data": "usuarioCapturaPunto"
            }, {
                "data": "latitudPunto"
            }, {
                "data": "longitudPunto"
            }, ],
        processing: true,
        dom: 'Bfrtip',
        buttons: ['excel']
    });
}
 