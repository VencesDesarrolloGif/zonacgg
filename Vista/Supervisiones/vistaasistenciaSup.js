// $(readyVistaAsistencia());  
function readyVistaAsistencia(){
    var obj = rolUsuario;
    if (obj == "Analista Asistencia") { //si no esta definida es que no es supervisor y queire decir que es superadmin  y se consultan los supervisores asi como los puntos de servicio
        traetodoslospuntosdeservicioanalista();
    } else if (obj == "Supervisor") { //de lo contrario quiere decir que si es supervisor y solo se consultan los puntos de servicio asi como sus guardias de los mismos.
        traetodoslospuntosdeserviciosupervisor();
    }
}
 //////////////////////////////////////**********************PARA CASO CUANDO USUUARIO SE ANALISTA********************/////////////////////////////////////////////////////////////////////////////
 var tableSupervisiones = null;

 function traetodoslospuntosdeservicioanalista() {
    waitingDialog.show();
     var fechainiciobusqueda = 0;
     var fechafinbusqueda = 0;
     var dataTableSupervisiones = [];
     $.ajax({
         type: "POST",
         url: "/zonacgg/Vista/Supervisiones/ajax_vistaasistenciasup.php",
         data: {"accion": 1,"fechainicio": fechainiciobusqueda,"fechafin": fechafinbusqueda},
         dataType: "json",
         async: false,
         success: function(response) {
             for (var i = 0; i < response.datos.length; i++) {
                 var record = response.datos[i];
                 //console.log(record);
                 //alert(record.esatusPunto);
                 dataTableSupervisiones.push(record);
             }
             loadDataInTableAsignacionessuper(dataTableSupervisiones);
             $("#tablasupervisiones").show();
             waitingDialog.hide();
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
             waitingDialog.hide();
         }
     });
 } 
 
 function mostrarModalSupervision(idsupervision, fechaasistencia, numeroempleadosupervisor, idpuntoservicio) {
     $('#modalSupervision').modal();
     $('#btnDesgargaExcelAsisSup').hide();
     consultaSupervisiones(idsupervision, fechaasistencia, numeroempleadosupervisor, idpuntoservicio);
 }

 function consultaSupervisiones(idsupervision, fechaasistencia, numeroempleadosupervisor, idpuntoservicio) {
    var numSup = numeroempleadosupervisor.split('-');
    var entidad =numSup[0];
    var consecutivo =numSup[1];
    var categoria =numSup[2];
    var fechaSup = fechaasistencia.split('-');
    var anio =fechaSup[0];
    var mes =fechaSup[1];
    var dia =fechaSup[2];
     var rutaimg = entidad + consecutivo + categoria + '_' + anio + mes + dia + '.png';
     $("#listaSupervisiones").empty();
     $("#foto").empty();
     $.ajax({
         type: "POST",
         url: "/zonacgg/Vista/Supervisiones/modalsupervisiones.php",
         data: {
             "idsupervision": idsupervision
         },
         dataType: "json",
         success: function(response) {
             var lista = response.datos;
             //15110903 _20181011_1004_0.jpeg
             var img = "<img style='width:100%; height:100%; border-radius: 25px;' src='../../Gif_App_Asistencia/FotosEmpleados/"+numeroempleadosupervisor+"/" + rutaimg + "'>"
             $("#foto").append(img);
             var tab = "<table class='table tablaRH'><tbody><thead ><th class='active'>Número de empleado</th><th class='active'>Nombre</th><th class='active'>Actitud de Servicio</th><th class='active'>Cumplimiento de consignas</th><th class='active'>Imagen</th><th class='active'>Uniforme completo</th><th class='active'>Observaciones</th><th class='active'>Punto De Servicio</th><th class='active'>Horario</th>";
             if (response.datos.length > 0) {
                 $.each(lista, function(i) {
                     tab += "<tr><td class='success'>" + response.datos[i].numerodeempleadoguardia + "</td>" + "<td>" + response.datos[i].nombreguardia + "</td>" + "<td>" + response.datos[i].CalifActitudServicio + '%' + "</td>" + "<td>" + response.datos[i].CalifCumplimientoConsignias + "%" + "</td>" + "<td>" + response.datos[i].CalifImagen + '%' + "</td>" + "<td>" + response.datos[i].CalifUniformeCompleto + '%' + "</td>" + "<td>" + response.datos[i].Observaciones + "</td>" + "<td>" + response.datos[i].puntoServicio + "</td>" + "<td>" + response.datos[i].FechaHoraRegistro + "</td>" + "</tr>";
                 });
                 $("#listaSupervisiones").append(tab);
                    $('#btnDesgargaExcelAsisSup').show();

             } else {
                    $('#btnDesgargaExcelAsisSup').hide();
                    $("#listaSupervisiones").append("No se registraron supervisiones"); 
                    }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
     //FUNCION PARA CONSULTAR POR AJAX LAS SUPERVISIONES
 }

 function listaSupervisionesanalistaporfecha() {
     var dataTableSupervisiones = [];
     var fechafinbusqueda = $("#fechafinbusquedasupervision").val();
     var fechainiciobusqueda = $("#fechainiciobusquedasupervision").val();
     //-----------------------------------VALIDACIONES----------------------------------------
     if (fechainiciobusqueda === "") {
         Msgerrorfechainiciobusqueda = "<div id='msgerrorbuscadorporfechasupervisiones' class='alert alert-error'><strong>Debe introducir fecha Del:</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#msgerrorbuscadorporfechasupervisiones").html(Msgerrorfechainiciobusqueda);
     } else if (fechafinbusqueda === "") {
         Msgerrorfechafinbusqueda = "<div id='msgerrorbuscadorporfechasupervisiones' class='alert alert-error'><strong>Debe introducir fecha A:</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#msgerrorbuscadorporfechasupervisiones").html(Msgerrorfechafinbusqueda);
     } else if (fechainiciobusqueda > fechafinbusqueda) {
         Msgerrorfechamenorque = "<div id='msgerrorbuscadorporfechasupervisiones' class='alert alert-error'><strong>  No puede seleccionar en 'A:' una fecha menor a 'Del:':</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#msgerrorbuscadorporfechasupervisiones").html(Msgerrorfechamenorque);
     } else //EJECUCION DEL QUERY QUE HARA LA CONSULTA PARA MOSTRAR LA TABLA POR FECHAS
     {
         $("#msgerrorbuscadorporfechasupervisiones").html("");
         $.ajax({
             type: "POST",
             url: "/zonacgg/Vista/Supervisiones/ajax_vistaasistenciasup.php",
             data: {
                 "accion": 2,
                 "fechainicio": fechainiciobusqueda,
                 "fechafin": fechafinbusqueda
             },
             dataType: "json",
             success: function(response) {
                 //console.log(response);
                 for (var i = 0; i < response.datos.length; i++) {
                     var record = response.datos[i];
                     //console.log(record);
                     //alert(record.esatusPunto);
                     dataTableSupervisiones.push(record);
                 }
                 //console.log(dataTableAsignaciones);
                 loadDataInTableAsignacionessuper(dataTableSupervisiones);
             },
             error: function(jqXHR, textStatus, errorThrown) {}
         });
     }
 }
 ////////////////////////////////////////////////////////////////**************************************************************************************************///////////////////////////////////////////////////////////////////////////////
 ////////////////////////////////////////////////////////////////////////////////////////PARA EL CASO QUE SEA SUPERVISOR/////////////////////////
 function listaSupervisionessupervisorporfecha() {
     var dataTableSupervisiones = [];
     var fechafinbusqueda = $("#fechafinbusquedasupervision").val();
     var fechainiciobusqueda = $("#fechainiciobusquedasupervision").val();
     //-----------------------------------VALIDACIONES----------------------------------------
     if (fechainiciobusqueda === "") {
         Msgerrorfechainiciobusqueda = "<div id='msgerrorbuscadorporfechasupervisiones' class='alert alert-error'><strong>Debe introducir fecha Del:</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#msgerrorbuscadorporfechasupervisiones").html(Msgerrorfechainiciobusqueda);
     } else if (fechafinbusqueda === "") {
         Msgerrorfechafinbusqueda = "<div id='msgerrorbuscadorporfechasupervisiones' class='alert alert-error'><strong>Debe introducir fecha Al:</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#msgerrorbuscadorporfechasupervisiones").html(Msgerrorfechafinbusqueda);
     } else if (fechainiciobusqueda > fechafinbusqueda) {
         Msgerrorfechamenorque = "<div id='msgerrorbuscadorporfechasupervisiones' class='alert alert-error'><strong>  No puede seleccionar en 'A:' una fecha menor a 'Del:':</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#msgerrorbuscadorporfechasupervisiones").html(Msgerrorfechamenorque);
     } else //EJECUCION DEL QUERY QUE HARA LA CONSULTA PARA MOSTRAR LA TABLA POR FECHAS
     {
         $("#msgerrorbuscadorporfechasupervisiones").html("");
         $.ajax({
             type: "POST",
             url: "/zonacgg/Vista/Supervisiones/ajax_vistaasistenciasup.php",
             data: {
                 "accion": 4,
                 "fechainicio": fechainiciobusqueda,
                 "fechafin": fechafinbusqueda
             },
             dataType: "json",
             success: function(response) {
                 //console.log(response);
                 for (var i = 0; i < response.datos.length; i++) {
                     var record = response.datos[i];
                     //console.log(record);
                     //alert(record.esatusPunto);
                     dataTableSupervisiones.push(record);
                 }
                 //console.log(dataTableAsignaciones);
                 loadDataInTableAsignacionessuper(dataTableSupervisiones);
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 //alert("error");
             }
         });
     }
 }
 var tableSupervisiones = null;

 function traetodoslospuntosdeserviciosupervisor() {
    waitingDialog.show();
     var fechainiciobusqueda = 0;
     var fechafinbusqueda = 0;
     var dataTableSupervisiones = [];
     $.ajax({
         type: "POST",
         url: "/zonacgg/Vista/Supervisiones/ajax_vistaasistenciasup.php",
         data: {"accion": 3,"fechainicio": fechainiciobusqueda,"fechafin": fechafinbusqueda},
         dataType: "json",
         async: false,
         success: function(response) {
             for (var i = 0; i < response.datos.length; i++) {
                 var record = response.datos[i];
                 dataTableSupervisiones.push(record);
             }
             loadDataInTableAsignacionessuper(dataTableSupervisiones);
             $("#tablasupervisiones").show();
             waitingDialog.hide();
         },
         error: function(response) {
             alert("ocurrio un error aak");
             waitingDialog.hide();
         }
     });
 }
 ////////////////////////////////////////////////////////////////////////////////////********************************////////////////////////////
 //////////////////////////////////////////////////////TABLA GENERAL PARA AMBOS CASOS/////////////////////////////////////////////////////////////////////////////////
 function loadDataInTableAsignacionessuper(data) {
     if (tableSupervisiones != null) {
         tableSupervisiones.destroy();
     }
     tableSupervisiones = $('#tablasupervisiones').DataTable({
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
                 "data": "puntoServicio"
             }, {
                 "data": "numeroempleadosupervisor"
             }, {
                 "data": "nombresupervisor"
             }, {
                 "data": "descripcionPuesto"
             }, {
                 "data": "horaEntradasupervision"
             }, {
                 "data": "salidasupervision"
             }, {
                 "data": "fechaasistenciasupervision"
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


$("#btnDesgargaExcelAsisSup").click(function(event) {
     $("#DatosExcelSup").val( $("<div>").append( $("#listaSupervisiones").eq(0).clone()).html());
     $("#form_vistaAsistenciaSup").submit();
     //NOTA :  se utiliza el fichero de asistencia general supervisor de otro modulo (consulta asistencia) para realizar la descarga en excel 
    });
 
 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////