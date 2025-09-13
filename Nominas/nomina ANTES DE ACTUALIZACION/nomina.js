$(inicioNomina());  
function inicioNomina(){
    cargaseltiponomina();
    cargaselPeriodoB();
    $("#hdnaccionexcel").val(0);
}

var tablenominas = null;
var datosNomina=null;

function loadDataInTablebajafiniquitos(data) {
    if (tablenominas != null) {
        tablenominas.destroy();
    }
    tablenominas = $('#tablanomina').DataTable({
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
            "data": "nombreEntidadFederativa"
        }, {
            "data": "fechaImss"
        }, {
            "data": "empleadoNumeroSeguroSocial"
        }, {
            "data": "numeroCta"
        }, {
            "data": "numeroCtaClabe"
        }, {
            "data": "banco" //aqui va ir el banco
        }, {
            "data": "infonavit"
        }, {
            "data": "fonacot"
        }, {
            "data": "pension"
        }, {
            "data": "prestamo"
        }, {
            "data": "alimentos",
        }, {
            "data": "sueldo",
        }],
        "columnDefs": [{
            "targets": [9, 10, 11, 12, 13, 14],
            "orderable": false
        }],
         processing: true,
         dom: 'Bfrtip',
         buttons: []
    });
    var table = $("#tablanomina").DataTable();
    table.columns([9, 10, 11, 12, 13, 14]).visible(false);
}
////**********************************************************************************************************//////////////
///////////////////////////FUNCIONES QUE LLENAN SELECTORES (TODOS)///////////////////////////////////////////////////
function cargaseltiponomina() {
    var meses = ["General", "Activos", "Bajas"];
    $('#seltiponomina').empty().append('<option value="0" selected="selected">-Seleccione Tipo-</option>');
    var a = 1;
    for (var i in meses) {
        //verificar que rollo con esto
        $('#seltiponomina').append('<option value="' + a + '">' + meses[i] + '</option>'); //verificar que rollo con esto
        // document.getElementById("selnuevomesiniciomodafisuc").innerHTML += "<option value='" + array[i] + "'>" + array[i] + "</option>"; //llenar con js un selector apartir de un arreglo
        a++;
    }
}

function cargaselperiodonomina() {
    var meses = ["Quincenal", "Semanal"];
    $('#selperiodonomina').empty().append('<option value="0" selected="selected">-Seleccione Periodo-</option>');    
    var a = 1;
    for (var i in meses) {
        //verificar que rollo con esto
        $('#selperiodonomina').append('<option value="' + a + '">' + meses[i] + '</option>'); //verificar que rollo con esto        
        // document.getElementById("selnuevomesiniciomodafisuc").innerHTML += "<option value='" + array[i] + "'>" + array[i] + "</option>"; //llenar con js un selector apartir de un arreglo
        a++;
    }
}

function cargaselPeriodoB() {
    var meses = ["Quincenal", "Semanal"];
    $('#selBusquedaPer').empty().append('<option value="0" selected="selected">-Seleccione Periodo-</option>');    
    var a = 1;
    for (var i in meses) {
        //verificar que rollo con esto
        $('#selBusquedaPer').append('<option value="' + a + '">' + meses[i] + '</option>'); //verificar que rollo con esto        
        // document.getElementById("selnuevomesiniciomodafisuc").innerHTML += "<option value='" + array[i] + "'>" + array[i] + "</option>"; //llenar con js un selector apartir de un arreglo
        a++;
    }
}

function cargaseltipodeduccion(a) {
    var deducciones = ["Infonavit", "Fonacot", "Pensión", "Préstamo", "Alimentos"];
    // $('#selectDeducciones').empty().append('<option value="0" selected="selected">-Seleccione Tipo-</option>');
    var a = a + 9;
    for (var i in deducciones) {
        //verificar que rollo con esto
        $('#selectDeducciones').append('<option value="' + a + '">' + deducciones[i] + '</option>'); //verificar que rollo con esto
        // document.getElementById("selnuevomesiniciomodafisuc").innerHTML += "<option value='" + array[i] + "'>" + array[i] + "</option>"; //llenar con js un selector apartir de un arreglo
        a++;
    }
}

function cargaseltipoconcepto() {
    var tipo = ["Percepciones", "Deducciones"];
    $('#seltipo').empty().append('<option value="0" selected="selected">-Seleccione Tipo-</option>');
    var a = 1;
    for (var i in tipo) {
        //verificar que rollo con esto
        $('#seltipo').append('<option value="' + a + '">' + tipo[i] + '</option>'); //verificar que rollo con esto
        // document.getElementById("selnuevomesiniciomodafisuc").innerHTML += "<option value='" + array[i] + "'>" + array[i] + "</option>"; //llenar con js un selector apartir de un arreglo
        a++;
    }
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////**********************************************************************************************************//////////////
$("#seltipo").change(function() {
    var seltipo = $("#seltipo").val();
    //1=percepciones
    //2=deducciones
    if (seltipo === "0") {
        $("#selectDeducciones").empty();
    } else {
        //cargaseltipodeduccion();
        llenarDeducciones(seltipo);
    }
});
$('#seltiponomina').change(function() {
    var tiponomina = $('#seltiponomina').val();
    $("#selperiodonomina").empty();
    $("#seltipo").empty();
    $("#selectDeducciones").empty();
    $('#displayshowtable').css("display", "none");
    $('#periodo').css("display", "none");
    if (tiponomina != 0) {
        cargaselperiodonomina();
    } else {
        $("#selperiodonomina").empty();
    }
});
//////////////////////////////////////////////////////////////////////////////////////////
$("#selperiodonomina").change(function() {

$("#hdnacciondownloadexcel").val(0);

    var tiponomina = $('#seltiponomina').val();
    $("#errorMsg").empty();
    var periodonomina = $('#selperiodonomina').val();
    if (periodonomina != 0) {
        consultaNomina(tiponomina, periodonomina);
    } else {
        $("#seltipo").empty();
        $("#selectDeducciones").empty();
        $('#displayshowtable').css("display", "none");
        $('#periodo').css("display", "none");
    }
});

function myFunction(deduccion, i) {
    var table = $("#tablanomina").DataTable();
    var valor = $("#selectDeducciones").val(i);
    if (valor != "") {
        table.columns([i]).visible(false);
        $("#selectDeducciones").append('<option value="' + i + '">' + deduccion + '</option>');
    }
}

function quitarDeduccion() {
    var table = $("#tablanomina").DataTable();
    var numDeduccion = $("#selectDeducciones").val();
    table.columns([+numDeduccion]).visible(true);
    $("#selectDeducciones option[value='" + numDeduccion + "']").remove();
}

function consultaNomina(tiponomina, periodonomina) {
    tablenomina = [];
    waitingDialog.show();
    $.ajax({
        type: "POST",
        url: "../nomina/ajax_consultaNomina.php",
        data: {
            "tiponomina": tiponomina,
            "periodonomina": periodonomina
        },
        dataType: "json",
        success: function(response) {
            //console.log(response);
            cargaseltipoconcepto();
            $('#displayshowtable').css("display", "block");
            var fechainiciorangonomina = response.fechainicio;
            var fechafinrangonomina = response.fechafin;
            var idrango = response.idrango;
            var numsemanaoquincena = response.numsemanaoquincena;
            //var mes=fechainiciorangonomina
            $("#idrango").val(idrango);
            $("#fechainicio").empty();
            $("#fechafin").empty();
            $("#numperiodoquincena").empty();
            if (response.status == "success") {
                $("#numperiodoquincena").append("(" + numsemanaoquincena + ") -> Del: ");
                $("#fechainicio").append(fechainiciorangonomina);
                $("#fechafin").append(fechafinrangonomina);
                $("#periodo").css("display", "block");
                $("#muestratabladeconsultaporfechas").attr('style', 'display : none');
                datosNomina=response.datos;
                for (var i = 0; i < response.datos.length; i++) {
                    var record = response.datos[i];
                    tablenomina.push(record);
                }
                loadDataInTablebajafiniquitos(tablenomina);
                waitingDialog.hide();
            } else {
                var mensaje = response.message;
                console.log("mal");
                waitingDialog.hide();
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
            waitingDialog.hide();
        }
    });
}

function llenarDeducciones(tipo) {
    $('#selectDeducciones').empty();
    $.ajax({
        type: "POST",
        url: "ajax_deducciones.php",
        data: {
            "tipo": tipo,
        },
        dataType: "json",
        success: function(response) {
            // console.log(response);
            datos = response.datos;
            //console.log(datos);
            var largo = datos.length;
            $('#selectDeducciones').append('<option value="0" selected="selected">- Seleccione -</option>');
            $.each(datos, function(i) {
                if (tipo == 1) {
                    a = (response.datos[i].IdTipoPercepcion);
                    aa = parseInt(a, 10);
                    aaa = aa + 13; //el 13 es por el numero de columna ultima en la tabla a mostrar
                    $('#selectDeducciones').append('<option value="' + aaa + '">' + response.datos[i].Descripcion + '</option>');
                } else if (tipo == 2) {
                    $('#selectDeducciones').append('<option value="' + (response.datos[i].IdTipoDeduccion) + '">' + response.datos[i].Descripcion + '</option>');
                }
            });
            if (tipo == 2) {
                cargaseltipodeduccion(largo);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
    });
}

function cierranomina(accion) {
    var bandera = true;
    var periodo=$("#selperiodonomina").val();
    var idrango = $("#idrango").val();

    /*if(accion==2)
        alert(periodo);¨*/
    if (accion == 1) {
        if ($("#seltiponomina").val() === "0") {
            funcmsgerror("Seleccione Tipo:");
            bandera = false;
        }
        if ($("#selperiodonomina").val() === "0") {
            funcmsgerror("Seleccione Periodo:");
            bandera = false;
        }
        if ($("#seltiponomina").val() !== "1") {
            funcmsgerror("Solo puede cerrar periodo General");
            bandera = false;
        }
    }
    if (bandera == true) {
        //console.log(datosNomina);
        if(accion==2){
            $('#modalconfirmacion').modal('hide');
            waitingDialog.show();        
        }
        $.ajax({
            type: "POST",
            url: "ajax_CierraNomina.php",
            data: {
                "idrango": idrango,
                "accion": accion,
                "periodo": periodo,
                "nomina" : datosNomina
            },
            dataType: "json",
            success: function(response) {
                $('#modalconfirmacion').modal('hide');
                //console.log(response);
                var msgerror = response.msgerror;
                if (msgerror == "error") {
                    funcmsgerror("Este periodo fue cerrado");
                    $(document).scrollTop(0);
                    waitingDialog.hide();
                    //$('#modalconfirmacion').modal();
                } else if (msgerror == "") {
                    $('#modalconfirmacion').modal();
                    $("#rangoinicio").val($("#fechainicio").html());
                    $("#rangofin").val($("#fechafin").html());
                    waitingDialog.hide();
                } else if (msgerror == "bien") {                    
                    $(document).scrollTop(0);
                    var Msgerror = "<div id='errorMsg' class='alert alert-success'><strong>Periodo cerrado satisfactoriamente</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#errorMsg").html(Msgerror);
                    waitingDialog.hide();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
                waitingDialog.hide();
            }
        });
    }
};

function funcmsgerror(menasje) {
    $(document).scrollTop(0);
    var Msgerror = "<div id='errorMsg' class='alert alert-error'><strong>" + menasje + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#errorMsg").html(Msgerror);
}

function downloadexcel() {

    if($("#hdnacciondownloadexcel").val()==="0"){
    var tiponomina = $('#seltiponomina').val();
    var periodonomina = $('#selperiodonomina').val();
    // window.open("../nomina/downloadexcelnomina.php?tiponomina=" + tiponomina + "&" + "periodonomina=" + periodonomina, '_self');
    window.open("../nomina/downloadexcelnomina.php?tiponomina=" + tiponomina + "&" + "periodonomina=" + periodonomina, 'width=600,height=600,scrollbars=no');
    }else if($("#hdnacciondownloadexcel").val()==="1"){
//alert("descargar excel historico");
    var periodo = $('#selBusquedaPer').val();    
    var idRango = $('#selBusquedaRango').val(); 
    window.open("../nomina/downloadexcelnominahistorico.php?periodo=" + periodo + "&" + "rango=" + idRango, 'width=600,height=600,scrollbars=no');
    }
}
function cargaranios() {
     $('#selBusquedaAnio').empty().append('<option value="0" selected="selected">- Seleccione año-</option>'); 
     var periodo=$("#selBusquedaPer").val();
     //alert(periodo)
     if(periodo!="0"){
         var n = (new Date()).getFullYear();
         var select = document.getElementById("selBusquedaAnio"); //llenar con js un selector de años    
         for (var i = 2015; i <= n; i++) {
             select.options.add(new Option(i, i));         
         }
    }
 }



$("#selBusquedaAnio").change(function() {
    var anio = $('#selBusquedaAnio').val();  
    var periodo=$("#selBusquedaPer").val();  
    $.ajax({
        type: "POST",
        url: "ajax_llenarListaPeriodos.php",
        data: {
            "anio": anio,
            "periodo": periodo
        },
        dataType: "json",
        success: function(response) {
            // console.log(response);
            datos = response.datos;
            //console.log(datos);
            var largo = datos.length;
            $('#selBusquedaRango').empty().append('<option value="0" selected="selected">- Seleccione Sem/Quin-</option>');
            $.each(datos, function(i) {             
                    var texto="("+response.datos[i].numero+"): "+response.datos[i].FechaInicioP+"-►"+response.datos[i].FechaFinP;        
                    $('#selBusquedaRango').append('<option value="' +response.datos[i].IdRango + '">' + texto+ '</option>');
                
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
    });
});


function buscarNomina(rango,periodo){
    var anio = $('#selBusquedaAnio').val();  
    if(anio=="0" || periodo=='0' || rango=='0'){
        funcmsgerror("Verifique Datos Para Consulta:");
    }else{
        tablenomina = [];
        waitingDialog.show();
        $.ajax({
            type: "POST",
            url: "ajax_consultaNominaHistorica.php",
            data: {
                "rango": rango,
                "periodo": periodo
            },
            dataType: "json",
            success: function(response) {
                //console.log(response);
                cargaseltipoconcepto();
                $('#displayshowtable').css("display", "block");
                                
                if (response.status == "success") {                                        
                    for (var i = 0; i < response.datos.length; i++) {
                        var record = response.datos[i];
                        tablenomina.push(record);
                    }
                    loadDataInTablebajafiniquitos(tablenomina);
                    waitingDialog.hide();
                } else {                    
                    console.log(response);
                    waitingDialog.hide();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
                waitingDialog.hide();
            }
        });
    }
}

$('#selBusquedaRango').change(function() {
    var periodo = $('#selBusquedaPer').val();    
    var idRango = $('#selBusquedaRango').val();
    $("#hdnacciondownloadexcel").val(1);
    buscarNomina(idRango,periodo);    
});

/*
function alerta() {
    bootbox.confirm({
        message: "This is a confirm with custom button text and color! Do you like it?",
        buttons: {
            confirm: {
                label: 'cuca',
                className: 'btn-success'
            },
            cancel: {
                label: 'seca',
                className: 'btn-danger'
            }
        },
        callback: function(result) {
            console.log('This was logged in the callback: ' + result);
        }
    });
}*/