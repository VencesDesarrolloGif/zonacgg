 $(document).ready(function() {
     //traetodoslosempdadosbaja();
     llenaselectoresperiodo();
 });

 function llenaselectoresperiodo() {
     $.ajax({
         type: "POST",
         url: "ajax_llenaselectorperiodos.php",
         data: {
             "idperiodo": 0,
         },
         dataType: "json",
         success: function(response) {
             console.log(response);
             datos = response.datos;
             $('#seldescripcionperiodo').empty().append('<option value="0" selected="selected">- Seleccione -</option>');
             $.each(datos, function(i) {
                 $('#seldescripcionperiodo').append('<option value="' + response.datos[i].IdPeriodo + '">' + response.datos[i].Descripcion + '</option>');
             });
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
 }
 $("#seldescripcionperiodo").change(function() {
     $("#datos").empty();
     var descripcionperiodo = $('#seldescripcionperiodo').val();
     if (descripcionperiodo != 0) {
         $.ajax({
             type: "POST",
             url: "ajax_llenaselectorperiodos.php",
             data: {
                 "idperiodo": descripcionperiodo,
             },
             dataType: "json",
             success: function(response) {
                 //console.log(response);
                 $(document).scrollTop(0);
                 datos = response.datos;
                 $('#selanioperiodo').empty().append('<option value="0" selected="selected">- Seleccione -</option>');
                 $.each(datos, function(i) {
                     $('#selanioperiodo').append('<option value="' + response.datos[i].IdAnio + '">' + ' días de pago: ' + response.datos[i].DiasPago + ' de: ' + response.datos[i].DescAnio + '</option>');
                 });
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
             }
         });
     } else {
         $('#selanioperiodo').empty();
         $("#datos").empty();
     }
 });

 function buscarporrangofechasfiniquitos() {
     var iniciodeconsulta = $("#iniciodeconsultafiniquitos").val();
     var findeconsulta = $("#finconsultafiniquitos").val();
     if (iniciodeconsulta == "") {
         var Msgerrorfiniquitos = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Verifique fecha inicio: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#msgerrorfiniquitos").html(Msgerrorfiniquitos);
     } else if (findeconsulta == "") {
         var Msgerrorfiniquitos = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Verifique fecha fin: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#msgerrorfiniquitos").html(Msgerrorfiniquitos);
     } else if (iniciodeconsulta > findeconsulta) { //esto es cosa del diablo 
         var Msgerrorfiniquitos = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>La fecha de fin no puede ser menor a la fecha inicio: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#msgerrorfiniquitos").html(Msgerrorfiniquitos);
     } else {
         tableempleadosbajasfiniquitos = [];
         $.ajax({
             type: "POST",
             url: "ajax_consultaempfechaparafiniquitos.php",
             data: {
                 "iniciodeconsulta": iniciodeconsulta,
                 "findeconsulta": findeconsulta
             },
             dataType: "json",
             success: function(response) {
                 console.log(response);
                 if (response.status == "success") {
                     //console.log(response.datos.length);
                     $("#muestratabladeconsultaporfechas").attr('style', 'display : block');
                     for (var i = 0; i < response.datos.length; i++) {
                         var record = response.datos[i];
                         //console.log(record);
                         //alert(record.esatusPunto);
                         tableempleadosbajasfiniquitos.push(record);
                     }
                     //console.log(tableempleadosbajasfiniquitos);
                     loadDataInTableAsignacionessuper(tableempleadosbajasfiniquitos);
                 } else {
                     var mensaje = response.message;
                     console.log("mal");
                 }
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
             }
         });
     }
 }
 var tableempleadosbajasfin = null;

 function loadDataInTableAsignacionessuper(data) {
     if (tableempleadosbajasfin != null) {
         tableempleadosbajasfin.destroy();
     }
     tableempleadosbajasfin = $('#tablaempleadosbajasfiniquitos').DataTable({
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
         destroy: true,
         "columns": [{
                 "data": "numempleado"
             }, {
                 "data": "nombreempleado"
             }, {
                 "data": "descripcionPuesto"
             }, {
                 "data": "fechaImss"
             }, {
                 "data": "fechaBajaImss"
             }, ]
             //,serverSide: true
             ,
         processing: true,
         dom: 'Bfrtip',
         buttons: ['excel']
     });
 }

 function calcularfiniquito() {
     var iniciodeconsulta = $("#iniciodeconsultafiniquitos").val();
     var findeconsulta = $("#finconsultafiniquitos").val();
     var seldescripcionperiodo = $("#seldescripcionperiodo").val();
     var selanioperiodo = $("#selanioperiodo").val();
     //alert(selanioperiodo);
     tableempleadosbajasfiniquitoscalculados = [];
     $.ajax({
         type: "POST",
         url: "ajax_finiquitos.php",
         data: {
             "iniciodeconsulta": iniciodeconsulta,
             "findeconsulta": findeconsulta,
             "seldescripcionperiodo": seldescripcionperiodo,
             "selanioperiodo": selanioperiodo,
         },
         dataType: "json",
         success: function(response) {
             console.log(response);
             if (response.status == "success") {
                 //console.log(response.datos.length);
                 $("#muestratabladeconsultaporfechas").attr('style', 'display : none');
                 for (var i = 0; i < response.datos.length; i++) {
                     var record = response.datos[i];
                     //console.log(record);
                     //alert(record.esatusPunto);
                     tableempleadosbajasfiniquitoscalculados.push(record);
                 }
                 //console.log(tableempleadosbajasfiniquitoscalculados);
                 loadDataInTablebajafiniquitos(tableempleadosbajasfiniquitoscalculados);
             } else {
                 var mensaje = response.message;
                 console.log("mal");
             }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
 }
 var tableempleadosbajasfiniquitoscalcu = null;

 function loadDataInTablebajafiniquitos(data) {
     if (tableempleadosbajasfiniquitoscalcu != null) {
         tableempleadosbajasfiniquitoscalcu.destroy();
     }
     tableempleadosbajasfiniquitoscalcu = $('#tablaempleadosbajasfiniquitoscalculados').DataTable({
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
         destroy: true,
         "columns": [{
                 "data": "numempleado"
             }, {
                 "data": "nombreempleado"
             }, {
                 "data": "descripcionPuesto"
             }, {
                 "data": "fechaImss"
             }, {
                 "data": "fechaBajaImss"
             }, {
                 "data": "prestamo"
             }, {
                 "data": "infonavit"
             }, {
                 "data": "fonacot"
             }, {
                 "data": "cuotaPagadaTurno"
             }, {
                 "data": "diastrabenlaquincena"
             }, {
                 "data": "separacion"
             }, {
                 "data": "antiguedadtotal"
             }, {
                 "data": "diastrabajados"
             }, {
                 "data": "DiasVacConf"
             }, {
                 "data": "proporcion_de_vacaciones"
             }, {
                 "data": "CALCULO DIAS AGUINALDO"
             }, {
                 "data": "DIAS AGUINALDO"
             }, {
                 "data": "propdevacaciones"
             }, {
                 "data": "PRIMAVACACAIONALNETA"
             }, {
                 "data": "PROPORCION NETA DE AGUINALDO"
             }, {
                 "data": "diasdepago"
             }, {
                 "data": "aumentoengratificacion"
             }, {
                 "data": "calculobruto"
             }, {
                 "data": "pagoneto"
             }, {
                 "data": "editar"
             }, ]
             // ]
             //,serverSide: true
             ,
         processing: true,
         dom: 'Bfrtip',
         buttons: ['excel']
     });
 }

 function editar(i) {
     ///esta funcion lo unico que hara sera deshabilitar los inputs////
     $("#prestamo" + i).prop('readonly', false);
     $("#infonavit" + i).prop('readonly', false);
     $("#fonacot" + i).prop('readonly', false);
     $("#diastrabajadosenrangodelaultimaquincenaint" + i).prop('readonly', false);
     $("#separacion" + i).prop('readonly', false);
     $("#aumentoengratificacion" + i).prop('readonly', false);
     /////////////////
 }

 function guardar(i) {
     //////////todo esto sera a la hora de guardar los cambios//////////////
     var numempleado = $("#numempleado" + i).val();
     var entidadempleado = numempleado.substring(0, 2);
     var consecutivoemp = numempleado.substring(3, 7);
     var categoriaemp = numempleado.substring(8, 10);
     var fechaingresoimss = $("#fechainicioimss" + i).val();
     var fechabajaimss = $("#fechabajaimss" + i).val();
     var prestamo = $("#prestamo" + i).val();
     var infonavit = $("#infonavit" + i).val();
     var fonacot = $("#fonacot" + i).val();
     var cuota = $("#cuotaint" + i).val();
     var diastrabajados = $("#diastrabajadosenrangodelaultimaquincenaint" + i).val();
     var separacion = $("#separacion" + i).val();
     var antiguedadtotal = $("#antiguedadtotal" + i).val();
     var diasparappdevacaciones = $("#diastrabajados" + i).val();
     var diasdevacaciones = $("#diasdevacaciones" + i).val();
     var factorproporciondevacaciones = $("#propdevaccpnvert" + i).val();
     var calculodiasdeaguinaldo = $("#calculodiasaguinaldo" + i).val();
     var diasdeaguinaldo = $("#diasdeaguinaldo" + i).val();
     var proporciondevacaciones = $("#propvacaciones" + i).val();
     var primavacacionalneta = $("#primavacacionalnetaredondeada" + i).val();
     var proporcionnetaaguinaldo = $("#proporcionnetaaguinaldo" + i).val();
     var diasdepago = $("#diasdepago" + i).val();
     var aumentoengratificacion = $("#aumentoengratificacion" + i).val();
     var calculobruto = $("#calculobruto" + i).val();
     var pagoneto = $("#pagoneto" + i).val();
     var i = i;
     /////////////////////falta validar los inputs que no metan basura////////////////////
     // tableempleadosbajasfiniquitoscalculados = [];
     $.ajax({
         type: "POST",
         url: "ajax_calculafiniquitos.php",
         data: {
             "entidadempleado": entidadempleado,
             "consecutivoemp": consecutivoemp,
             "categoriaemp": categoriaemp,
             "fechaingresoimss": fechaingresoimss,
             "fechabajaimss": fechabajaimss,
             "prestamo": prestamo,
             "infonavit": infonavit,
             "fonacot": fonacot,
             "cuota": cuota,
             "diastrabajados": diastrabajados,
             "separacion": separacion,
             "antiguedadtotal": antiguedadtotal,
             "diasparappdevacaciones": diasparappdevacaciones,
             "diasdevacaciones": diasdevacaciones,
             "factorproporciondevacaciones": factorproporciondevacaciones,
             "calculodiasdeaguinaldo": calculodiasdeaguinaldo,
             "diasdeaguinaldo": diasdeaguinaldo,
             "proporciondevacaciones": proporciondevacaciones,
             "primavacacionalneta": primavacacionalneta,
             "proporcionnetaaguinaldo": proporcionnetaaguinaldo,
             "diasdepago": diasdepago,
             "aumentoengratificacion": aumentoengratificacion,
             "calculobruto": calculobruto,
             "pagoneto": pagoneto,
             "i": i,
         },
         dataType: "json",
         success: function(response) {
             console.log(response);
             var datos = response.datos;
             var numempleadores = (datos["datos"].numempleado);
             var fechainicioimssres = (datos["datos"].fechaImss);
             var fechabajaimssres = (datos["datos"].fechaBajaImss);
             if (response.status == "success") {
                 alert("va el cambio de variables");
                 calcularfiniquito();
                 //$("#fonacot" + i).val(CALCULODIASAGUINALDO);
             } else {
                 var mensaje = response.message;
                 console.log("mal");
             }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
 }
 //var tableempleadosbajasfiniquitoscalcu = null;