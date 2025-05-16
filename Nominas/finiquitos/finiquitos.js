$(inicioFiniquitos());  
function inicioFiniquitos(){
     traerroldeusuario();
     $("#hdnaccionexcel").val(0);
}

 function traerroldeusuario() {
     $.ajax({
         type: "POST",
         url: "../../zonacgg/Vista/traerroldeusuariobyfiniquito.php",
         dataType: "json",
         success: function(response) {
            //console.log(response);
             var rol = response.rol;
             var entidad = response.entidadFederativaUsuario;
             var LineaNegocio1 = response.lineaNegocioUsuario;
            //alert(entidad);
             $("#hdnentidad").val(entidad);
             $("#hdnLineanegocio").val(LineaNegocio1);
             $("#hdnrol").val(rol);
             // if (rol != "Lider Unidad" && rol != "Contrataciones" && rol != "Laborales") {
             if (rol != "Lider Unidad" && rol != "Contrataciones") {
                 consultafiniquitocalculado();
                 // accion = 1;
                 $("#btnexcel").prop('style', 'display:block');
             }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
 }

 function consultafiniquitocalculado() {
     tableempleadosbajasfiniquitoscalculados = [];
     $.ajax({
         type: "POST",
         url: "../Nominas/finiquitos/ajax_consultafiniquitos.php",
         dataType: "json",
         success: function(response) {
             if (response.status == "success") {
                 $("#muestratabladeconsultaporfechas").attr('style', 'display : none');
                 for (var i = 0; i < response.datos.length; i++) {
                     var record = response.datos[i];
                     tableempleadosbajasfiniquitoscalculados.push(record);
                 }
                 loadDataInTablebajafiniquitos(tableempleadosbajasfiniquitoscalculados);
             } else {
                 var mensaje = response.message;
                // console.log("mal");
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
             "data": "descentidadtrabajo"
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
             "data": "pension"
         }, {
             "data": "cuotaPagadaTurno"
         }, {
             "data": "diastrabenlaquincena"
         }, {
             "data": "separacion"
         }, {
             "data": "piramidar"
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
             "data": "VacacionesPendientes"
         }, {
             "data": "PpPrimaVacacionalPendiente1"
         }, {
             "data": "PrimaVacacionalPendiente"
         }, {
             "data": "diasdepago"
         }, {
             "data": "aumentoengratificacion"
         }, {
             "data": "calculobruto"
         }, {
             "data": "pagoneto"
         }, {
             "data": "propVacacionesSA"
         }, {
             "data": "primaVacacionalSA"
         }, {
             "data": "propAginaldoSA"
         }, {
             "data": "diasPagoSA"
         }, {
             "data": "pagoNetoSA"
         }, {
             "data": "diferenciaGratificacionSA"
         }, {
             "data": "ingresoAcumulableSA"
         }, {
             "data": "limiteInferiorisr"
         }, {
             "data": "excedenteLimiteSA"
         }, {
             "data": "tasaAplicable"
         }, {
             "data": "resultado"
         }, {
             "data": "cuotaFija"
         }, {
             "data": "isr"
         }, {
             "data": "netoAlPago"
         }, {
             "data": "editar"
         }, {
             "data": "comprobacion"
         },  ],
         processing: true,
         dom: 'Bfrtip',

          buttons: {
        buttons: []
    }
         
     });
     var rol = $("#hdnrol").val();
     if (rol != "Coordinador Imss" && rol != "Laborales") {
         var table = $("#tablaempleadosbajasfiniquitoscalculados").DataTable();
         table.columns([6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40]).visible(false);
     }
 }
 
 function ocultarbtnexceldattable(){
//en esta funcion se habilita el boton de descarga de excel que por defecto vien en datatable
$("#divbtnexcelfalso").hide();
var table = $('#tablaempleadosbajasfiniquitoscalculados').DataTable();
    new $.fn.dataTable.Buttons( table, {
        buttons: [{
                extend: 'excel',
                title: 'finiquitos'
            }]
    } );
 
    table.buttons( 0, null ).container().prependTo(
        table.table().container()
    );      
}

 function editar(i) {
   
     $("#hdnaccioneditsave").val("editar");
     $("#separacion" + i).prop('readonly', false);
     $("#aumentoengratificacion" + i).prop('readonly', false);
 }

 function guardar(i,salarioDiario) {
     
     var hdnnumempleado = $("#hdnnumempleado" + i).val();
     //alert(salarioDiario);
     var numeropleado = hdnnumempleado.split('-');
     var entidadempleado =numeropleado[0];// hdnnumempleado.substring(0, 2);
     var consecutivoemp = numeropleado[1];//hdnnumempleado.substring(3, 7);
     var categoriaemp = numeropleado[2];//hdnnumempleado.substring(8, 10);
     var fechaingresoimss = $("#fechainicioimss" + i).val();
     var fechabajaimss = $("#fechabajaimss" + i).val();
     var prestamo = $("#prestamo" + i).val();
     var infonavit = $("#infonavit" + i).val();
     var fonacot = $("#fonacot" + i).val();
     var cuota = $("#cuotaint" + i).val();
     var diastrabajados = $("#diastrabajadosenrangodelaultimaquincenaint" + i).val();
     var separacion = $("#separacion" + i).val();
     var piramidar = $("#piramidar" + i).val();
     var antiguedadtotal = $("#antiguedadtotal" + i).val();
     var diasparappdevacaciones = $("#diasparappdevacaciones" + i).val();
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
     var proporcionvacacionessa = $("#propvacacionessa" + i).val();
     var primavacacionalsa = $("#primavacacionalsa" + i).val();
     var propaguinaldosa = $("#propaguinaldosa" + i).val();
     var diaspagosa = $("#diaspagosa" + i).val();
     var pagonetosa = $("#pagonetosa" + i).val();
     var diferenciagratificacionsa = $("#diferenciagratificacionsa" + i).val();
     var ingresoacumulablesa = $("#ingresoacumulablesa" + i).val();
     var limiteinferiorisr = $("#limiteinferiorisr" + i).val();
     var excedenteLimitesa = $("#excedenteLimitesa" + i).val();
     var tasaaplicable = $("#tasaaplicable" + i).val();
     var resultado = $("#resultado" + i).val();
     var cuotafija = $("#cuotafija" + i).val();
     var isr = $("#isr" + i).val();
     var primavacacionespendientes = $("#netoalpago" + i).val();
     var pension = $("#pension" + i).val();
     var PpPrimaVacacionalPendiente1 = $("#PpPrimaVacacionalPendiente1" + i).val();
     var i = i;

        if(!/^(([0-9]+)?(.[0-9]+)?)$/.test(piramidar)){ // este es para que aceote numeros despues del punto we pero no limita cuanto swe va entonces 
            //alert("Solo valores numericos");
        var mensaje ="Solo valores numericos ";
         alertMsg="<div id='msgalertpiramidar' class='alert alert-error'><strong>Error:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#msgerrorinputpiramidar").html(alertMsg);
            $(document).scrollTop(0);
            $('#msgalertpiramidar').delay(6000).fadeOut('slow');

        }else{
            $.ajax({
         type: "POST",
         url: "../Nominas/finiquitos/ajax_editayrecalculafiniquitos.php",
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
             "piramidar": piramidar,
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
             "proporcionvacacionessa": proporcionvacacionessa,
             "primavacacionalsa": primavacacionalsa,
             "propaguinaldosa": propaguinaldosa,
             "diaspagosa": diaspagosa,
             "pagonetosa": pagonetosa,
             "diferenciagratificacionsa": diferenciagratificacionsa,
             "ingresoacumulablesa": ingresoacumulablesa,
             "limiteinferiorisr": limiteinferiorisr,
             "excedenteLimitesa": excedenteLimitesa,
             "tasaaplicable": tasaaplicable,
             "resultado": resultado,
             "cuotafija": cuotafija,
             "isr": isr,
             "primavacacionespendientes": primavacacionespendientes,
             "PpPrimaVacacionalPendiente1": PpPrimaVacacionalPendiente1,
             "pension": pension,
             "i": i,
             "salarioDiario": salarioDiario
         },
         dataType: "json",
         success: function(response) {
             var datos = response.datos;
             if (response.status == "success") {
                 $("#hdnaccioneditsave").val("");
                 consultafiniquitocalculado();
             } else {
                 var mensaje = response.message;
                 //console.log("mal");
             }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             //alert(jqXHR.responseText);  
             alert("Verifique valores de último finiquito editado")
             consultafiniquitocalculado();
         }
     });

        }
         
 }
 //////////////////////////////////////////////////////////////////////////////buscar finiquitos por fecha//////////////////////////////
 function consultarporfechadefiniquito() {
     var entidad = $("#hdnentidad").val();
     var LineaNegocio = $("#hdnLineanegocio").val();
     var rol = $("#hdnrol").val();
     var selperiodofiniquito = $("#selperiodofiniquito").val();
     var fechainicio = $("#fechainiciobusquedafiniquito").val();
     var fechafin = $("#fechafinbusquedafiniquito").val();
     var fechainiciobusquedafiniquito = Date.parse(fechainicio);
     var fechafinbusquedafiniquito = Date.parse(fechafin);
     if (selperiodofiniquito === "0") {
         Msgerrorfechainiciobusqueda = "<div id='msgerrorbuscadorporfechasupervisiones' class='alert alert-error'><strong>Seleccione un Periodo</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#msgerrorbuscadorporfechasupervisiones").html(Msgerrorfechainiciobusqueda);
     } else if (fechainicio == "") {
         Msgerrorfechainiciobusqueda = "<div id='msgerrorbuscadorporfechasupervisiones' class='alert alert-error'><strong>Debe introducir fecha Del:</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#msgerrorbuscadorporfechasupervisiones").html(Msgerrorfechainiciobusqueda);
     } else if (fechafin == "") {
         Msgerrorfechainiciobusqueda = "<div id='msgerrorbuscadorporfechasupervisiones' class='alert alert-error'><strong>Debe introducir fecha A:</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#msgerrorbuscadorporfechasupervisiones").html(Msgerrorfechainiciobusqueda);
     } else if (fechainiciobusquedafiniquito > fechafinbusquedafiniquito) {
         Msgerrorfechainiciobusqueda = "<div id='msgerrorbuscadorporfechasupervisiones' class='alert alert-error'><strong>La fecha A: no puede ser menor a la fecha DEL:</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#msgerrorbuscadorporfechasupervisiones").html(Msgerrorfechainiciobusqueda);
     } else {
            waitingDialog.show();
         tableempleadosbajasfiniquitoscalculados = [];
         $.ajax({
             type: "POST",
             url: "../Nominas/finiquitos/ajax_consultafiniquitosporfecha.php",
             dataType: "json",
             data: {
                 "fechainicio": fechainicio,
                 "fechafin": fechafin,
                 "selperiodofiniquito": selperiodofiniquito,
                 "entidad": entidad,
                 "LineaNegocio": LineaNegocio,
                 "rol": rol,
             },
             success: function(response) {
                 //console.log(response);
                 if (response.status == "success") {
                     $("#hdnaccionexcel").val(1);
                     $("#msgerrorbuscadorporfechasupervisiones").html("");
                     for (var i = 0; i < response.datos.length; i++) {
                         var record = response.datos[i];
                         tableempleadosbajasfiniquitoscalculados.push(record);
                     }
                         waitingDialog.hide();
                     loadDataInTablebajafiniquitos(tableempleadosbajasfiniquitoscalculados);
                     ocultarbtnexceldattable();
                 } else {
                     var mensaje = response.message;
                     //console.log("mal");
                 }
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
             }
         });
     }
 }

 function confirmarpdf(i, fechabaja, fechaingreso) {
     var accion = $("#hdnaccioneditsave").val();
     if (accion === "editar") {
         alert("NOTA: Cuando te encuentres en modo de edición asegúrate de guardar los cambios (Guardar) para después proceder a confirmar.");
     } else {
         var fechabaja = fechabaja;
         var fechaalta = fechaingreso;
         var numempleado = $("#hdnnumempleado" + i).val();
         //alert(numempleado + " " + "numempleado");
         waitingDialog.show();
         $.ajax({
             type: "POST",
             url: "../Nominas/finiquitos/updatestatusfiniquito.php",
             dataType: "json",
             data: {
                 "numempleado": numempleado
             },
             success: function(response) {
                 //console.log(response); //RESPUESTA MENSAJE SUCCES POR SI SE AGREGA UN MENSAJE DE CONFIRMADO
                 msg1error = response.msg;
                 if (msg1error == "error") {
                     alert("No se han actualizado deudores(Amortización)");
                 } else if (msg1error == "error1") {
                     alert("No se ha actualizado deudores(Pensión)");
                 } else if (msg1error == "error2") {
                     alert("No se ha actualizado deudores(Prestamo)");
                 } else if (msg1error == "error3") {
                     alert("No se ha actualizado deudores(Fonacot)");
                 } else {
                     $("#hdnaccioneditsave").val("");
                     window.open("../Nominas/finiquitos/generadordocfiniquito.php?numempleado=" + numempleado + "&" + "fechabaja=" + fechabaja + "&" + "fechaalta=" + fechaalta, 'Finiquito', 'fullscreen=no');
                     consultafiniquitocalculado();
                     eliminadeducciones(i);
                 }
                 if (response.status == "error") {
                     alert(response.message);
                 }
                 waitingDialog.hide();
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 waitingDialog.hide();
                 alert(jqXHR.responseText);
             }
         });
     }
 }

 function reimprimirpdf(numempleado, fechabaja, fechaalta) {
     window.open("../Nominas/finiquitos/generadordocfiniquito.php?numempleado=" + numempleado + "&" + "fechabaja=" + fechabaja + "&" + "fechaalta=" + fechaalta, 'Finiquito', 'fullscreen=no');
 }

 function downloadexcel() {
     var entidad = $("#hdnentidad").val();
     var option = $("#hdnaccionexcel").val();
     var fechinicio = $("#fechainiciobusquedafiniquito").val();
     var fechafin = $("#fechafinbusquedafiniquito").val();
     var tipoperiodo = $("#selperiodofiniquito").val();
     window.open("../Nominas/finiquitos/downloadexcelfiniquitos.php?option=" + option + "&" + "finicio=" + fechinicio + "&" + "ffin=" + fechafin + "&" + "periodo=" + tipoperiodo + "&" + "entidad=" + entidad, '_self');
 }

 function eliminadeducciones(i) {
     //aqui se eliminaran las deducciones de infonavit fonacot prestamo pension finiquitos
     var numempleado = $("#hdnnumempleado" + i).val();
     $.ajax({
         type: "POST",
         url: "../Nominas/finiquitos/ajax_deleteDeducciones.php",
         dataType: "json",
         data: {
             "numempleado": numempleado
         },
         success: function(response) {
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
 }

 function uploadfiniquitofirmado(numempelado,fechabaja,fechaalta,i){
    $("#mserrorsubearchivo").html(""); 
        var formData = new FormData($("#firmafiniquito"+i)[0]);         
        for (var value of formData.values()) {
        }    
        if(value.name==""){
            msgerrorbuscadorporfechasupervisiones
            Msgerrorfechainiciobusqueda = "<div style='margin-left: 124.5%;width:80%' id='mserrorsubearchivo' class='alert alert-error'><strong>Seleccione un Archivo</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#mserrorsubearchivo").html(Msgerrorfechainiciobusqueda);
         $(document).scrollTop(0);
        } else{
            formData.append('numempelado', numempelado);
            formData.append('fechabaja', fechabaja);
            formData.append('fechaalta', fechaalta);
            formData.append('i', i);
            $("#mserrorsubearchivo").html("");
       $.ajax({
            type: "POST",
            url: "../Nominas/finiquitos/upload_finiquitofirmado.php",
            data:formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,        
            success: function(response){    
              var msj=response.message; 
                    if(response.status=='success'){
                  alertMsg1="<div style='margin-left: 124.5%;width:80%' id='mserrorsubearchivo' class='alert alert-success'><strong>Archivo subido correctamente </strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                     $("#firmafiniquito"+i)[0].reset(); 
                      $("#mserrorsubearchivo").html(alertMsg1);  
                      consultarporfechadefiniquito();                  
                                   
                }else{
                    alertMsg1="<div style='margin-left: 124.5%;width:80%' id='mserrorsubearchivo' class='alert alert-error'><strong>"+msj+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                     $("#firmafiniquito"+i)[0].reset(); 
                     $("#mserrorsubearchivo").html(alertMsg1);                               
                }                              
            },
            error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText); 
            }
        });
    }
 }