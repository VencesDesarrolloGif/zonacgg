$("#selectTipoBusquedaRI").change(function(event) {
  var tipoConsulta = $("#selectTipoBusquedaRI").val();
  $("#selectQuincenaRI").empty(); 
  $("#selectQuincenaRI").append('<option value="0">QUINCENA</option>');
  $("#selectMesRI").val(0);

  if(tipoConsulta=='0' || tipoConsulta=='2'){
    $("#divSelectQuincenaRI").hide();
  }if(tipoConsulta=='1'){
      $("#divSelectQuincenaRI").show();
  }
});

$("#selectMesRI").change(function(event) {

  var tipoConsulta = $("#selectTipoBusquedaRI").val();
  var ejercicio = $("#selectEjercicioRI").val();
  var mes = $("#selectMesRI").val();
  
  var ultimoDia = new Date(ejercicio,mes, 0).getDate();
  
  if(ejercicio=='0'){
    var mensaje="SELECCIONE UN EJERCICIO";
    cargarmensajeConsultaInc(mensaje, "error");
    $("#selectMesRI").val(0); 
  }else{
    if(tipoConsulta=='1'){
      $("#selectQuincenaRI").empty(); 
      $("#selectQuincenaRI").append('<option value="0">QUINCENA</option>');
      $("#selectQuincenaRI").append('<option value="1">01-15</option>');
      $('#selectQuincenaRI').append('<option value="2">16-'+ultimoDia+'</option>');
    }
  }
});


$("#selectTipoBusquedaInc").click(function(){

    var tipo = $("#selectTipoBusquedaInc").val();
    var lineaNegocio= $("#lineaNegocioInc").val();

    if(tipo=='2'){//cliente
        consultasPorTipo(tipo,lineaNegocio);
        $("#selectXTipo").show(); 
    }else if(tipo=='3'){//entidad
        consultasPorTipo(tipo,lineaNegocio);
        $("#selectXTipo").show(); 
    }else{
        $("#selectXTipo").hide(); 
    }
    /*if(tipo=='4'){//supervisor
        if (lineaNegocio=='4'){
            llenar el selector que no hay supervisores
        }else{
              consultasPorTipo(tipo,lineaNegocio);
        }
    }*/
});

 function consultasPorTipo(tipo,lineaNegocio){

    $.ajax({
        type: "POST",
        url: "IncidenciaReporte/ajax_ConsultasXTipo.php",
        data:{"tipo":tipo,"lineaNegocio":lineaNegocio},
        dataType: "json",
        async: false,
        success: function(response){

            $("#selectXTipo").empty(); 
            if(tipo==2){//cliente
               $('#selectXTipo').append('<option value="0">SELECCIONAR CLIENTE</option>');
            }
            if(tipo==3){//entidad
               $('#selectXTipo').append('<option value="0">SELECCIONAR ENTIDAD FEDERATIVA</option>');
            }
            /*if(tipo==4){//supervisor
               $('#selectXTipo').append('<option value="0">SUPERVISOR</option>');
            }*/
            if(response.status == "success"){
               for(var i = 0; i < response.datos.length; i++){
                   $('#selectXTipo').append('<option value="' + (response.datos[i].idTipo) + '">' + response.datos[i].descTipo + '</option>');
                  }
            }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
}

$("#btnConsultarInc").click(function(){

    var tipo = $("#selectTipoBusquedaInc").val();
    var lineaNegocio= $("#lineaNegocioInc").val();
    var entOclientElegido = $("#selectXTipo").val();

    var tipoConsultaFechas= $("#selectTipoBusquedaRI").val();
    var ejercicio = $("#selectEjercicioRI").val();
    var mes = $("#selectMesRI").val();

    if(tipoConsultaFechas=='1'){//quincena

        var select15na = $("#selectQuincenaRI").val();

        if(select15na=='0'){
           var mensaje="SELECCIONE UNA QUINCENA";
           cargarmensajeConsultaInc(mensaje, "error");
           return;
        }else{
              var quincenaTxt= $('select[name="selectQuincenaRI"] option:selected').text();
              var splitUltimoDia15na= quincenaTxt.split("-");
              var DiaUno15na=splitUltimoDia15na[0];
              var ultimoDia15na=splitUltimoDia15na[1];
              fechaInicio= ejercicio+"-"+mes+"-"+DiaUno15na;
              fechaFin= ejercicio+"-"+mes+"-"+ultimoDia15na;
        }
    }else if(tipoConsultaFechas=='2'){
        var ultimoDiaMes = new Date(ejercicio,mes, 0).getDate();
        fechaInicio= ejercicio+"-"+mes+"-01";
        fechaFin= ejercicio+"-"+mes+"-"+ultimoDiaMes;
    }

    if(lineaNegocio=='0'){
        $('#tablaDinamicaInc').html(""); 
        var mensaje="SELECCIONE UNA LINEA DE NEGOCIO";
        cargarmensajeConsultaInc(mensaje, "error");
    }else if(tipo=='0'){
        $('#tablaDinamicaInc').html(""); 
        var mensaje="SELECCIONE UN TIPO DE BUSQUEDA";
        cargarmensajeConsultaInc(mensaje, "error");
    }else if(fechaInicio==''){
        $('#tablaDinamicaInc').html(""); 
     var mensaje="SELECCIONE FECHA DE INICIO";
     cargarmensajeConsultaInc(mensaje, "error");
    }else if(fechaFin==''){
        $('#tablaDinamicaInc').html(""); 
        var mensaje="SELECCIONE FECHA FINAL";
        cargarmensajeConsultaInc(mensaje, "error");
    }else if((tipo=='2' || tipo=='3') && entOclientElegido=='0'){
            $('#tablaDinamicaInc').html(""); 
            if(tipo=='2'){
                var mensaje="SELECCIONE UN CLIENTE";
            }if(tipo=='3'){
                var mensaje="SELECCIONE UNA ENTIDAD FEDERATIVA";
            }
            cargarmensajeConsultaInc(mensaje, "error");
    }else{
       consultaIncidenciasXFechasDirGif(tipo,lineaNegocio,fechaInicio,fechaFin,entOclientElegido);
    }
});

 function consultaIncidenciasXFechasDirGif(tipo,lineaNegocio,fechaInicio,fechaFin,entOclientElegido){ 
    waitingDialog.show();
    $.ajax({
        type: "POST",
        url: "IncidenciaReporte/ajax_ConsultaIncidencias.php",
        data:{tipo,lineaNegocio,fechaInicio,fechaFin,entOclientElegido},
        dataType: "json",
        success: function(response){
            if(response.status == "success") {
                waitingDialog.hide();
                $("#descargaTablaInc").show();
                $('#tablaDinamicaInc').html(""); 
                $('#tablaDinamicaIncEsp').html(""); 
                $('#tablaDinamicaTurnosP').html(""); 
                var resultIncidencias = response.datosIncidencias;
                var resultIncidenciasEspeciales= response.datosIncidenciasEsp;
                var resultTurnosPresupuestados = response.datosTurnosPresupuestados;

                var listaInc = response.listaIncidencias;
                var listaIncEsp = response.listaIncidenciasEspeciales;
                var tablaTurnosPresupuestados= "<table id='tablaTurnosPresupuestados' class='table table-bordered'><caption>TURNOS PRESUPUESTADOS</caption><thead>";//inicio titulo tabla
                var tablaReporteIncidencias = "<table id='tablaReporteIncidencias' class='table table-bordered'><caption>INCIDENCIAS</caption><thead><th></th>";//inicio titulo tabla
                var tablaReporteIncidenciasEsp= "<table id='tablaReporteIncidenciasEsp' class='table table-bordered'><caption>INCIDENCIAS ESPECIALES</caption><thead><th></th>";//inicio titulo tabla

                
                for(var x = 0; x < resultIncidencias.length; x++){
                        tablaTurnosPresupuestados   += "<th scope='row' colspan='2'>" + resultIncidencias[x].fecha + "</th>"; //fechas de consulta
                }

                for(var i = 0; i < resultIncidencias.length; i++){
                        tablaReporteIncidencias   += "<th scope='row' colspan='2'>" + resultIncidencias[i].fecha + "</th>"; //fechas de consulta
                }

                for(var m = 0; m < resultIncidenciasEspeciales.length; m++){
                        tablaReporteIncidenciasEsp   += "<th scope='row' colspan='2'>" + resultIncidenciasEspeciales[m].fecha + "</th>"; //fechas de consulta
                }

                tablaTurnosPresupuestados += "</thead>"// termina titulo
                tablaReporteIncidencias += "</thead>"// termina titulo
                tablaReporteIncidenciasEsp += "</thead>"// termina titulo

                var dnincidencias=resultIncidencias.length*2;
                
                tablaTurnosPresupuestados+="<tr>";

                tablaReporteIncidencias+="<tr>";
                tablaReporteIncidencias+="<td></td>";

                tablaReporteIncidenciasEsp+="<tr>";
                tablaReporteIncidenciasEsp+="<td></td>";


                for(var w = 0; w < resultIncidencias.length; w++){
                        tablaTurnosPresupuestados+="<td scope='row' style='text-align:center'>Dia</td><td scope='row'>Noche</td>";
                }

                for(var z = 0; z < resultIncidencias.length; z++){
                        tablaReporteIncidencias+="<td scope='row' style='text-align:center'>Dia</td><td scope='row'>Noche</td>";
                }

                for(var y = 0; y < resultIncidenciasEspeciales.length; y++){
                        tablaReporteIncidenciasEsp+="<td scope='row' style='text-align:center'>Dia</td><td scope='row'>Noche</td>";
                }
                
                tablaTurnosPresupuestados+="</tr>";
                tablaReporteIncidencias+="</tr>";
                tablaReporteIncidenciasEsp+="</tr>";

                tablaTurnosPresupuestados+="<tr>";
                // alert(resultTurnosPresupuestados.length);
                for(var c = 0; c < resultIncidencias.length; c++){
                    var fechaTP=resultIncidencias[c].fecha;
                    tablaTurnosPresupuestados+="<td style='text-align:center'>"+resultTurnosPresupuestados[fechaTP]["turnoDiaTotales"]+"</td>";
                    tablaTurnosPresupuestados+="<td style='text-align:center'>"+resultTurnosPresupuestados[fechaTP]["turnosNocheTotales"]+"</td>";
                }//for c
                        tablaTurnosPresupuestados+="</tr>";

                var l='0';
                for(var k = 1; k <= listaInc.length; k++){

                    tablaReporteIncidencias+="<tr>";
                    tablaReporteIncidencias+="<td>"+listaInc[l]["descripcionIncidencia"]+"</td>";
                    for(var j = 0; j < resultIncidencias.length; j++){
                        if(k=='10' || k=='11' || k=='12' || k=='13' || k=='14') {
                            tablaReporteIncidencias+="<td colspan='2' style='text-align:center'>"+resultIncidencias[j][k]["diaTurnos"]+"</td>";
                        }else{
                            tablaReporteIncidencias+="<td style='text-align:center'>"+resultIncidencias[j][k]["diaTurnos"]+"</td>";
                            tablaReporteIncidencias+="<td style='text-align:center'>"+resultIncidencias[j][k]["nocheTurnos"]+"</td>";
                        }

                    }//for j
                        tablaReporteIncidencias+="</tr>";
                    l++;
                }//for k


                var n='0';
                for(var o = 1; o <= listaIncEsp.length; o++){

                    tablaReporteIncidenciasEsp+="<tr>";
                    tablaReporteIncidenciasEsp+="<td>"+listaIncEsp[n]["descripcionIncidenciaEspecial"]+"</td>";
                    for(var p = 0; p < resultIncidenciasEspeciales.length; p++){
                        if(o=='3' || o=='4' || o=='5'){
                            tablaReporteIncidenciasEsp+="<td colspan='2' style='text-align:center'>"+resultIncidenciasEspeciales[p][o]["diaTurnosIE"]+"</td>";

                        }else{
                            tablaReporteIncidenciasEsp+="<td style='text-align:center'>"+resultIncidenciasEspeciales[p][o]["diaTurnosIE"]+"</td>";
                            tablaReporteIncidenciasEsp+="<td style='text-align:center'>"+resultIncidenciasEspeciales[p][o]["nocheTurnosIE"]+"</td>";
                        }
                    }//for p
                        tablaReporteIncidenciasEsp+="</tr>";
                    n++;
                }//for o

                $("#tablaDinamicaTurnosP").append(tablaTurnosPresupuestados);
                $("#tablaDinamicaInc").append(tablaReporteIncidencias);
                $("#tablaDinamicaIncEsp").append(tablaReporteIncidenciasEsp);

            }else{
                waitingDialog.hide();
                var mensaje = response.message;
                cargarmensajeDetalleCobertura(mensaje, "error");
                $('#tablaDinamicaInc').html(""); 
                $('#tablaDinamicaIncEsp').html(""); 
                $('#tablaDinamicaTurnosP').html(""); 
            }
         },
         error: function(jqXHR, textStatus, errorThrown) {
                waitingDialog.hide();
                alert(jqXHR.responseText);
                $("#tablaDetalleCobertura").hide();
         }
     });
 }

 function cargarmensajeConsultaInc(mensaje,status){
    $('#msgInc').fadeIn('slow');
    mensajeAmostrar="<div id='msgAlert' class='alert alert-"+status+"'>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#msgInc").html(mensajeAmostrar);
    $(document).scrollTop(0);
    $('#msgInc').delay(3000).fadeOut('slow');
}

$("#descargaTablaInc").click(function(event) {
  $("#datos_TablaInc").val( $("<div>").append( $("#tablaDinamicaInc").eq(0).clone()).html() + $("<div>").append( $("#tablaDinamicaIncEsp").eq(0).clone()).html());
  $("#form_tablasDinamicasInc").submit();
});