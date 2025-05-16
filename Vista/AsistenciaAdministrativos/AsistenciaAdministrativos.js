 // $(document).ready(function() {
 //     var obj = rolUsuario;
 //     if (obj == "Analista Asistencia") { //si no esta definida es que no es supervisor y queire decir que es superadmin  y se consultan los supervisores asi como los puntos de servicio
 //         consultarasistenciasadministrativosS();
 //     } else if (obj == "Supervisor") { //de lo contrario quiere decir que si es supervisor y solo se consultan los puntos de servicio asi como sus guardias de los mismos.
 //         //traetodoslospuntosdeserviciosupervisor();
 //     }
 // });
 //////////////////////////////////////**********************PARA CASO CUANDO USUUARIO SE ANALISTA********************/////////////////////////////////////////////////////////////////////////////
 var tableAsistenciasAdministrativos = null;

 function consultarasistenciasadministrativosS() {
    var obj = rolUsuario;
    if(obj == "Analista Asistencia"){
        waitingDialog.show();
        var fechainiciobusqueda = 0;
        var fechafinbusqueda = 0;
        var dataTableAsistenciasAdministrativos = [];
        $.ajax({
            type: "POST",
            url: "/zonacgg/Vista/AsistenciaAdministrativos/ajax_consultaasisadministrativos.php",
            data: {"accion": 1,"fechainiciobusqueda": fechainiciobusqueda,"fechafinbusqueda": fechafinbusqueda},
            dataType: "json",
            async: false,
            success: function(response) {
                //console.log(response);
                for (var i = 0; i < response.datos.length; i++) {
                    var record = response.datos[i];
                    dataTableAsistenciasAdministrativos.push(record);
                }
                loadDataInTablaAsistenciaAdministrativos(dataTableAsistenciasAdministrativos);
                $("#tablaasistenciasadministrativos").show();
                waitingDialog.hide();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
                waitingDialog.hide();
            }  
        }); 
    }else{
        swal("Alto", "NO TIENES LOS PERMISOS NECESARIOS PARA REALIZAR ESTA CONSULTA GENERAL","error");
    } 
 }

 function mostrarModalAsistenciaadministrativos(numeroempleado,fecha) {
     $("#fotoOficina").empty();
     var numSup = numeroempleado.split('-');
     var entidad =numSup[0];
     var consecutivo =numSup[1];
     var categoria =numSup[2];
     var splitFecha = fecha.split('-');
     var anio =splitFecha[0];
     var mes =splitFecha[1];
     var dia =splitFecha[2];
     var unionFecha = anio+mes+dia; 
     var rutaimg = entidad + consecutivo + categoria +"_"+unionFecha+'.png';
     $('#modalFotoOficina').modal();
     var img = "<img style='width:50%; height:50%; border-radius: 25px; ' src='../../Gif_App_Asistencia/FotosEmpleados/"+numeroempleado+"/" + rutaimg + "'>";
     $("#fotoOficina").append(img);
 }
 ////////////////////////////////////////////////////////////////**************************************************************************************************///////////////////////////////////////////////////////////////////////////////
 ////////////////////////////////////////////////////////////////////////////////////////PARA BUSCAR EMPLEADOS ADMINISTRATIVOS POR FECHA/////////////////////////
 function muestraasistenciaadministrativosporfecha() {
     var dataTableSupervisiones = [];
     var fechafinbusqueda = $("#fechafinbusquedaadministradores").val();
     var fechainiciobusqueda = $("#fechainiciobusquedaadministradores").val();
     var fechainiciobusquedaadmin = Date.parse(fechainiciobusqueda);
     var fechafinbusquedaadmin = Date.parse(fechafinbusqueda);
     //-----------------------------------VALIDACIONES----------------------------------------
     if (fechainiciobusqueda === "") {
         Msgerrorfechainiciobusqueda = "<div id='msgerrorbuscadorporfechaadministradores' class='alert alert-error'><strong>Debe introducir fecha Del:</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#msgerrorbuscadorporfechaadministrativos").html(Msgerrorfechainiciobusqueda);
     } else if (fechafinbusqueda === "") {
         Msgerrorfechafinbusqueda = "<div id='msgerrorbuscadorporfechaadministradores' class='alert alert-error'><strong>Debe introducir fecha A:</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#msgerrorbuscadorporfechaadministrativos").html(Msgerrorfechafinbusqueda);
     } else if (fechainiciobusquedaadmin > fechafinbusquedaadmin) {
         Msgerrorfechamenorque = "<div id='msgerrorbuscadorporfechaadministradores' class='alert alert-error'><strong>  No puede seleccionar en 'A:' una fecha menor a 'Del:':</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#msgerrorbuscadorporfechaadministrativos").html(Msgerrorfechamenorque);
     } else //EJECUCION DEL QUERY QUE HARA LA CONSULTA PARA MOSTRAR LA TABLA POR FECHAS
     {
         $("#msgerrorbuscadorporfechaadministrativos").html("");
         waitingDialog.show();
         $.ajax({
             type: "POST",
             url: "/zonacgg/Vista/AsistenciaAdministrativos/ajax_consultaasisadministrativos.php",
             data: {
                 "accion": 2,
                 "fechainiciobusqueda": fechainiciobusqueda,
                 "fechafinbusqueda": fechafinbusqueda,
             },
             dataType: "json",
             success: function(response) {
                 //console.log(response);
                 for (var i = 0; i < response.datos.length; i++) {
                     var record = response.datos[i];
                     dataTableSupervisiones.push(record);
                 }
                 loadDataInTablaAsistenciaAdministrativos(dataTableSupervisiones);
                 $("#tablaasistenciasadministrativos").show();
                 waitingDialog.hide();

             },
             error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
             waitingDialog.hide();
         }
         });
     }
 }
 ////////////////////////////////////////////////////////////////////////////////////********************************////////////////////////////
 //////////////////////////////////////////////////////TABLA GENERAL PARA AMBOS CASOS/////////////////////////////////////////////////////////////////////////////////
 //var tableAsistenciasAdministrativos = null;
 function loadDataInTablaAsistenciaAdministrativos(data) {
     if (tableAsistenciasAdministrativos != null) {
         tableAsistenciasAdministrativos.destroy();
     }
     tableAsistenciasAdministrativos = $('#tablaasistenciasadministrativos').DataTable({
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
                 "data": "numeroempleado"
             }, {
                 "data": "nombreempleado"
             }, {
                 "data": "descripcionPuesto"
             }, {
                 "data": "puntoServicio"
             }, {
                 "data": "horaEntrada"
             }, {
                 "data": "salidaComer"
             }, {
                 "data": "regresoComer"
             }, {
                 "data": "salidaTurno"
             }, {
                 "data": "fechaAsistencia"
             }, {
                 "data": "CalifOficinas"
             }, {
                 "data": "detallemodal"
             }, ]
             //,serverSide: true
             ,
         processing: true,
         dom: 'Bfrtip',
         buttons: ['excel']
     });
 }
 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////