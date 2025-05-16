$(document).ready(function() {
    ConsultarUsuarioLogeadoPAraSelector()
});
var SupervisorAConsultar = "";
function ConsultarUsuarioLogeadoPAraSelector(){
    $.ajax({
        type: "POST",
        url: "PorcentajeAsistencia/ajax_ConsultarUsuarioLogeadoParaSelector.php",
        dataType: "json",
        async: false,
        success: function(response){
            if(response.status == "success"){
                if(response.NumeroSup == "0" || response.NumeroSup == 0){
                    $("#selectXTipo").empty(); 
                    $('#selectSupervisorPAsis').append('<option value="0">Selecciona Al Supervisor</option>');
                    for(var i = 0; i < response.datos.length; i++){
                        $('#selectSupervisorPAsis').append('<option value="' + (response.datos[i].NumSupervisor) + '">' + response.datos[i].NombreSupervisor + '</option>');
                    }
                    $("#selectSupervisorPAsis").show();
                    SupervisorAConsultar = 0;
                }else{
                    SupervisorAConsultar = response.NumeroSup;
                    $("#selectSupervisorPAsis").hide();
                }
            }else{
                cargarmensajeConsultaInc(response.error,response.status);
            }
        },error: function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText);
        }
    });
}


$("#selectTipoBusquedaPAsis").change(function(event) {
  var tipoConsulta = $("#selectTipoBusquedaPAsis").val();
  $("#selectQuincenaPAsis").empty(); 
  $("#selectQuincenaPAsis").append('<option value="0">QUINCENA</option>');
  $("#selectMesPAsis").val(0);

  if(tipoConsulta=='0' || tipoConsulta=='2'){
    $("#divSelectQuincenaPAsis").hide();
  }if(tipoConsulta=='1'){
      $("#divSelectQuincenaPAsis").show();
  }
});

$("#selectMesPAsis").change(function(event) {

  var tipoConsulta = $("#selectTipoBusquedaPAsis").val();
  var ejercicio = $("#selectEjercicioPAsis").val();
  var mes = $("#selectMesPAsis").val();
  
  var ultimoDia = new Date(ejercicio,mes, 0).getDate();
  
  if(ejercicio=='0'){
    var mensaje="SELECCIONE UN EJERCICIO";
    cargarmensajeConsultaInc(mensaje, "error");
    $("#selectMesPAsis").val(0); 
  }else{
    if(tipoConsulta=='1'){
      $("#selectQuincenaPAsis").empty(); 
      $("#selectQuincenaPAsis").append('<option value="0">QUINCENA</option>');
      $("#selectQuincenaPAsis").append('<option value="1">01-15</option>');
      $('#selectQuincenaPAsis').append('<option value="2">16-'+ultimoDia+'</option>');
    }
  }
});


$("#btnConsultarPAsis").click(function(){
    var tipoConsultaFechas= $("#selectTipoBusquedaPAsis").val();
    var ejercicio = $("#selectEjercicioPAsis").val();
    var mes = $("#selectMesPAsis").val();

    if(tipoConsultaFechas == "0"){
        cargarMensajePorcentajeAsistencia("Seleccione el rango de fechas para continuar", "error");
    }else if(ejercicio == "0"){
        cargarMensajePorcentajeAsistencia("Seleccione el ejercicio para continuar", "error");
    }else if(mes == "0"){
        cargarMensajePorcentajeAsistencia("Seleccione el mes para continuar", "error");
    }else if(tipoConsultaFechas=='1' &&  $("#selectQuincenaPAsis").val() == "0"){
        cargarMensajePorcentajeAsistencia("Seleccione la quincena para continuar", "error");
    }else if((SupervisorAConsultar == "0" || SupervisorAConsultar ==0) && $("#selectSupervisorPAsis").val() == "0"){
        cargarMensajePorcentajeAsistencia("Seleccione al supervisor para continuar", "error");
    }else{
        if(SupervisorAConsultar == "0" || SupervisorAConsultar ==0){
            var NumSup = $("#selectSupervisorPAsis").val();
        }else{
            var NumSup = SupervisorAConsultar;
        }
        if(NumSup == "0" || NumSup == 0 || NumSup == null|| NumSup == "null"|| NumSup == "NULL"|| NumSup == ""|| NumSup == undefined|| NumSup == "undefined"){
            cargarMensajePorcentajeAsistencia("Error al obtener ",response.status);
        }else{
            if(tipoConsultaFechas=='1'){
                var quincenaTxt= $('select[name="selectQuincenaPAsis"] option:selected').text();
                var splitUltimoDia15na= quincenaTxt.split("-");
                var DiaUno15na=splitUltimoDia15na[0];
                var ultimoDia15na=splitUltimoDia15na[1];
                fechaInicio= ejercicio+"-"+mes+"-"+DiaUno15na;
                fechaFin= ejercicio+"-"+mes+"-"+ultimoDia15na;
            }else{
                var ultimoDiaMes = new Date(ejercicio,mes, 0).getDate();
                fechaInicio= ejercicio+"-"+mes+"-01";
                fechaFin= ejercicio+"-"+mes+"-"+ultimoDiaMes;
            }
            consultaIncidenciasXFechas(fechaInicio,fechaFin,NumSup);
        }// else de validacion del supervisor 
    }// else de las validaciones primarias

});

 function consultaIncidenciasXFechas(fechaInicio,fechaFin,NumSup){ 
    waitingDialog.show();
    $.ajax({
        type: "POST",
        url: "PorcentajeAsistencia/ajax_ConsultaIncidenciasPorcentajeAsistencia.php",
        data:{fechaInicio,fechaFin,NumSup},
        dataType: "json",
        success: function(response){
            if(response.status == "success") {
                waitingDialog.hide();
                $("#descargaTablaPorcentajeAsistencia").show();
                ////////////////////////////////////////////////////////////  llenado de la tabla Turnos Presupuestados ////////////////////////////////////////////////////////
                // Borramos La Tabla Turnos Presupuestados Para Llenarla De nuevo
                $('#tablaTurnosPresaupuestadosPorcentajASistencia').html(""); 
                var listaFechas = response.ListaFechas;// Recibimos las fechas que se consultan
                var datosTurnosPresupuestados = response.DatosTurnosPresupuestados;// recibimos lo sdatos por fecha
                var tablaTurnosPresupuestados= "<table id='tablaTurnosPresupuestados' class='table table-bordered'><caption>TURNOS PRESUPUESTADOS</caption><thead>";//inicio titulo tabla
                for(var i = 0; i < listaFechas.length; i++){
                        tablaTurnosPresupuestados   += "<th scope='row' colspan='2'>" + listaFechas[i] + "</th>"; //fechas de consulta
                }// hacemos el titulo que son las fechas consultadas
                tablaTurnosPresupuestados += "</thead>"// termina titulo

                tablaTurnosPresupuestados+="<tr>";//COmienza el ante titulo
                for(var j = 0; j < listaFechas.length; j++){
                    tablaTurnosPresupuestados+="<td scope='row' style='text-align:center'>Dia</td><td scope='row'>Noche</td>";
                }// ponemos el ante titulo que son de dia y noche lo cual asi viene desde la cosnulta
                tablaTurnosPresupuestados+="</tr>";// Termina el ante titulo 
                tablaTurnosPresupuestados+="<tr>";//comienza el llenado de los datos
                for(var k = 0; k < listaFechas.length; k++){
                    tablaTurnosPresupuestados+="<td style='text-align:center'>"+datosTurnosPresupuestados[listaFechas[k]].dia+"</td>";
                    tablaTurnosPresupuestados+="<td style='text-align:center'>"+datosTurnosPresupuestados[listaFechas[k]].noche+"</td>";
                   
                }//for k
                tablaTurnosPresupuestados+="</tr>";// termina el llenado d elos datos 
                $("#tablaTurnosPresaupuestadosPorcentajASistencia").append(tablaTurnosPresupuestados); // Se pega la tabla creada en el espacuio reservado 
                ////////////////////////////////////////////////////////////  Termina el llenado de la tabla Turnos Presupuestados ////////////////////////////////////////////////////
                ////////////////////////////////////////////////////////////  Inicia el llenado de la tabla Porcentaje Asistencia//////////////////////////////////////////////////////
                $('#tablaPorcentajeAsistencia').html(""); //
                var listageneral24horas = response.listageneral24horas;// recibimos lo sdatos por fecha
                var fechas = [];
                var turnosPresupuestadosDia = [];
                var turnosPresupuestadosNoche = [];
                var turnosIngresadosDia = [];
                var turnosIngresadosNoche = [];


                var tablaPorcentajeTurnos= "<table id='tablaPorcentajeTurnos' class='table table-bordered'><caption>PORCENTAJE INCIDENCIAS INGRESADAS</caption><thead>";//inicio titulo tabla
                for(var x = 0; x < listaFechas.length; x++){
                        tablaPorcentajeTurnos   += "<th scope='row' colspan='2'>" + listaFechas[x] + "</th>"; //fechas de consulta
                }// hacemos el titulo que son las fechas consultadas
                tablaPorcentajeTurnos += "</thead>"// termina titulo

                tablaPorcentajeTurnos+="<tr>";//COmienza el ante titulo
                for(var y = 0; y < listaFechas.length; y++){
                    tablaPorcentajeTurnos+="<td scope='row' style='text-align:center'>Dia</td><td scope='row'>Noche</td>";
                }// ponemos el ante titulo que son de dia y noche lo cual asi viene desde la cosnulta
                tablaPorcentajeTurnos+="</tr>";// Termina el ante titulo 
                for(var h = 0; h < 2; h++){
                    tablaPorcentajeTurnos+="<tr>";//comienza el llenado de los datos
                    for(var z = 0; z < listaFechas.length; z++){
                        if(h=="0"){
                            tablaPorcentajeTurnos+="<td style='text-align:center'>"+listageneral24horas[listaFechas[z]].dia+"</td>";
                            tablaPorcentajeTurnos+="<td style='text-align:center'>"+listageneral24horas[listaFechas[z]].noche+"</td>"; 
                        }else{

                            var cien = 100;
                            var porcentajeTurnosPDia = cien / datosTurnosPresupuestados[listaFechas[z]].dia;
                            var porcentajeTotalDia1 = porcentajeTurnosPDia * listageneral24horas[listaFechas[z]].dia;

                            var porcentajeTurnosPNoche = cien / datosTurnosPresupuestados[listaFechas[z]].noche;
                            var porcentajeTotalNoche1 = porcentajeTurnosPNoche * listageneral24horas[listaFechas[z]].noche;

                            
                            var porcentajeTotalDia = Math.round(porcentajeTotalDia1);
                            var porcentajeTotalNoche = Math.round(porcentajeTotalNoche1);

                            // var porcentajeTotalDia = porcentajeTotalDia2[0];
                            // var porcentajeTotalNoche = porcentajeTotalNoche2[0];
                            if(porcentajeTotalDia > cien){
                                var colorDia = "red";
                            }else if (porcentajeTotalDia < 85){
                                var colorDia = "orange";
                            }else{
                                var colorDia = "green";
                            }
                            if(porcentajeTotalNoche > cien){
                                var colorNoche = "red";
                            }else if (porcentajeTotalNoche < 85){
                                var colorNoche = "orange";
                            }else{
                                var colorNoche = "green";
                            }
                            tablaPorcentajeTurnos+="<td style='text-align:center;color:"+colorDia+"'>"+porcentajeTotalDia+" %</td>";
                            tablaPorcentajeTurnos+="<td style='text-align:center;color:"+colorNoche+"'>"+porcentajeTotalNoche+" %</td>";

                            fechas.push(listaFechas[z]);
                            turnosPresupuestadosDia.push(datosTurnosPresupuestados[listaFechas[z]].dia);
                            turnosPresupuestadosNoche.push(datosTurnosPresupuestados[listaFechas[z]].noche);
                            turnosIngresadosDia.push(listageneral24horas[listaFechas[z]].dia);
                            turnosIngresadosNoche.push(listageneral24horas[listaFechas[z]].noche);
                        
                        }//else
                    }//for 
                    
                    tablaPorcentajeTurnos+="</tr>";// termina el llenado d elos datos 
                }
                $("#tablaPorcentajeAsistencia").append(tablaPorcentajeTurnos); // Se pega la tabla creada en el espacuio reservado 
                ////////////////////////////////////////////////////////////  Termina el llenado de la tabla Porcentaje Asistencia//////////////////////////////////////////////////////

                // Creas el camvas para almacenar la grafica que se creara en la ultima iteracion del for del porcentaje ///////////////////
                var canvas = "<canvas id='GraficaPorcentajeASistencia1' name='GraficaPorcentajeASistencia1'></canvas>";
                $('#GraficaPorcentajeASistencia').html(canvas);

                 var graficaCanvas = document.getElementById("GraficaPorcentajeASistencia1"); 
                            Chart.defaults.global.defaultFontFamily = "Lato";
                            Chart.defaults.global.defaultFontSize = 18;
                            var totalTurnosPresupuestadosDia = {
                                label: 'Turnos Presupuestados Dia',
                                data: turnosPresupuestadosDia,
                                backgroundColor: 'rgba(33, 97, 140, 1)',         
                                yAxisID: "barTotalesGraficas"
                            };

                            var totalTurnosIngresadosDia = {
                                label: 'Turnos Ingresados Dia',
                                data: turnosIngresadosDia,
                                backgroundColor: 'rgba(133, 193, 233, 1)',          
                                yAxisID: "barTotalesGraficas"
                            };

                            var totalTurnosPresupuestadosNoche = {
                                label: 'Turnos Presupuestados Noche',
                                data: turnosPresupuestadosNoche,
                                backgroundColor: 'rgba(212, 172, 13, 1)',         
                                yAxisID: "barTotalesGraficas"
                            };

                            var totalTurnosIngresadosNoche = {
                                label: 'Turnos Ingresados Noche',
                                data: turnosIngresadosNoche,
                                backgroundColor: 'rgba(247, 220, 111, 1)',          
                                yAxisID: "barTotalesGraficas"
                            };
             
                            var datosTotalTurnos = {
                                labels: fechas,
                                datasets: [totalTurnosPresupuestadosDia, totalTurnosIngresadosDia, totalTurnosPresupuestadosNoche, totalTurnosIngresadosNoche]
                            };   
                            var chartOptions = {
                                scales: {                  
                                    yAxes: [{id: "barTotalesGraficas"},
                                            {id: "barTotalesGraficas"},
                                            {id: "barTotalesGraficas"}]
                                }
                            };          

                            var barChart = new Chart(graficaCanvas, {
                                type: 'bar',
                                data: datosTotalTurnos,
                                options: chartOptions
                            });         

                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                ////////////////////////////////////////////////////////////  llenado de la tabla incidencias (asistencia) ////////////////////////////////////////////////////////
                $('#tablaIncidenciasPorcentajeAsistencia').html(""); 

                var tablaIncidenciasPorcAsis = "<table id='tablaIncidenciasPorcAsis' class='table table-bordered'><caption>INCIDENCIAS</caption><thead><th></th>";//inicio titulo tabla
                for(var l = 0; l < listaFechas.length; l++){
                        tablaIncidenciasPorcAsis   += "<th scope='row' colspan='2'>" + listaFechas[l] + "</th>"; //fechas de consulta
                }// hacemos el titulo que son las fechas consultadas
                tablaIncidenciasPorcAsis += "</thead>"// termina titulo
                tablaIncidenciasPorcAsis+="<tr>";
                tablaIncidenciasPorcAsis+="<td></td>";
                for(var m = 0; m < listaFechas.length; m++){
                        tablaIncidenciasPorcAsis+="<td scope='row' style='text-align:center'>Dia</td><td scope='row'>Noche</td>";
                }
                tablaIncidenciasPorcAsis+="</tr>";
                var catalogoIncidencias = response.catalogoIncidencias;// Recibimos las fechas que se consultan
                var datosIncidencias = response.datosIncidencias;// Recibimos las fechas que se consultan
                for(var n = 0; n < catalogoIncidencias.length; n++){
                    tablaIncidenciasPorcAsis+="<tr>";
                    var turnoInc = catalogoIncidencias[n].descripcionIncidencia;
                    tablaIncidenciasPorcAsis+="<td>"+turnoInc+"</td>";
                    for(var o = 0; o < listaFechas.length; o++){             
                        if(turnoInc=="BAJA" || turnoInc=="INGRESO" || turnoInc=="VACACIONES PAGADAS 24X24" || turnoInc=="VACACIONES DISFRUTADAS 24X24" || turnoInc=="CAPACITACION"){
                            tablaIncidenciasPorcAsis+="<td colspan='2' style='text-align:center'>"+datosIncidencias[listaFechas[o]][turnoInc]["dia"]+"</td>";
                        }else{
                            tablaIncidenciasPorcAsis+="<td style='text-align:center'>"+datosIncidencias[listaFechas[o]][turnoInc]["dia"]+"</td>";
                            tablaIncidenciasPorcAsis+="<td style='text-align:center'>"+datosIncidencias[listaFechas[o]][turnoInc]["noche"]+"</td>";
                        }
                    }
                    tablaIncidenciasPorcAsis+="</tr>";
                }
                $("#tablaIncidenciasPorcentajeAsistencia").append(tablaIncidenciasPorcAsis);
                ////////////////////////////////////////////////////////////  Termina el llenado de la tabla incidencias (asistencia) ////////////////////////////////////////////////////////
                ////////////////////////////////////////////////////////////  inicia el llenado de la tabla incidencias especiales ///////////////////////////////////////////////////////////
                $('#tablaIncEspPorcentajeAsis').html(""); 
                var tablaReporteIncidenciasEsp= "<table id='tablaReporteIncidenciasEsp' class='table table-bordered'><caption>INCIDENCIAS ESPECIALES</caption><thead><th></th>";//inicio titulo tabla
                for(var p = 0; p < listaFechas.length; p++){
                        tablaReporteIncidenciasEsp   += "<th scope='row' colspan='2'>" + listaFechas[p] + "</th>"; //fechas de consulta
                }// hacemos el titulo que son las fechas consultadas
                tablaReporteIncidenciasEsp += "</thead>"// termina titulo
                tablaReporteIncidenciasEsp+="<tr>";
                tablaReporteIncidenciasEsp+="<td></td>";

                for(var q = 0; q < listaFechas.length; q++){
                        tablaReporteIncidenciasEsp+="<td scope='row' style='text-align:center'>Dia</td><td scope='row'>Noche</td>";
                }
                tablaReporteIncidenciasEsp+="</tr>";
                var catalogoIncidenciasEspeciales = response.catalogoIncidenciasEspeciales;// Recibimos las fechas que se consultan
                var listaincidenciasEspeciales = response.listaincidenciasEspeciales;// Recibimos las fechas que se consultan

                for(var r = 0; r < catalogoIncidenciasEspeciales.length; r++){
                    tablaReporteIncidenciasEsp+="<tr>";
                    var descripcionIncidenciaEspecial = catalogoIncidenciasEspeciales[r].descripcionIncidenciaEspecial;
                    var incidenciaEspecialId = catalogoIncidenciasEspeciales[r].incidenciaEspecialId;
                    tablaReporteIncidenciasEsp+="<td>"+descripcionIncidenciaEspecial+"</td>";
                    for(var s = 0; s < listaFechas.length; s++){             
                        if(incidenciaEspecialId=="1" || incidenciaEspecialId=="2"){
                            tablaReporteIncidenciasEsp+="<td style='text-align:center'>"+listaincidenciasEspeciales[listaFechas[s]][descripcionIncidenciaEspecial]["dia"]+"</td>";
                            tablaReporteIncidenciasEsp+="<td style='text-align:center'>"+listaincidenciasEspeciales[listaFechas[s]][descripcionIncidenciaEspecial]["noche"]+"</td>";
                        }else{
                            tablaReporteIncidenciasEsp+="<td colspan='2' style='text-align:center'>"+listaincidenciasEspeciales[listaFechas[s]][descripcionIncidenciaEspecial]["dia"]+"</td>";
                            
                        }
                    }
                    tablaReporteIncidenciasEsp+="</tr>";
                }
                $("#tablaIncEspPorcentajeAsis").append(tablaReporteIncidenciasEsp);
                ////////////////////////////////////////////////////////////  Termina el llenado de la tabla incidencias especiales ///////////////////////////////////////////////////////////

                ////////////////////////////////////////////////////////////  Inicia el llenado de la tabla Turnos Por Hora ////////////////////////////////////////////////////////
                // Borramos La Tabla Turnos Presupuestados Para Llenarla De nuevo
                $('#tablaIncPorHoraPorcentajeAsis').html(""); 
                var tablaTurnosPorHora= "<table id='tablaTurnosPorHora' class='table table-bordered'><caption>INCIDENCIAS INGRESADAS POR DIA Y POR HORA</caption><thead><th></th>";//inicio titulo tabla
                 for(var t = 0; t < listaFechas.length; t++){
                        tablaTurnosPorHora   += "<th scope='row' colspan='2'>" + listaFechas[t] + "</th>"; //fechas de consulta
                }// hacemos el titulo que son las fechas consultadas
                tablaTurnosPorHora += "</thead>"// termina titulo
                tablaTurnosPorHora+="<tr>";
                tablaTurnosPorHora+="<td></td>";
                // var RR=0;
                for(var u = 0; u < listaFechas.length; u++){
                        // var R = RR+10;
                        tablaTurnosPorHora+="<td scope='row' style='text-align:center;background-color: rgb(0, 233, 240);'>Dia</td><td scope='row' style='background-color: rgb(133, 193, 233);'>Noche</td>";
                }
                tablaTurnosPorHora+="</tr>";
                var listaincidencias24Horas = response.listaincidencias24Horas;// Recibimos las fechas que se consultan
                for(var v = 0; v < 24; v++){
                    tablaTurnosPorHora+="<tr>";
                    if(v<10){
                        var iteracion24 = "0"+v; 
                    }else{
                        var iteracion24 = v;
                    }
                    tablaTurnosPorHora+="<td>"+iteracion24+":00:00</td>";
                    for(var w = 0; w < listaFechas.length; w++){             
                        tablaTurnosPorHora+="<td style='text-align:center;background-color: rgb(0, 233, 240);'>"+listaincidencias24Horas[listaFechas[w]][iteracion24]["dia"]+"</td>";
                        tablaTurnosPorHora+="<td style='text-align:center;background-color: rgb(133, 193, 233);'>"+listaincidencias24Horas[listaFechas[w]][iteracion24]["noche"]+"</td>";
                        
                    }
                    tablaTurnosPorHora+="</tr>";
                }
               
                $("#tablaIncPorHoraPorcentajeAsis").append(tablaTurnosPorHora); // Se pega la tabla creada en el espacuio reservado 
                 ////////////////////////////////////////////////////////////  Termina el llenado de la tabla Turnos Por Hora ////////////////////////////////////////////////////////
            }else{
                waitingDialog.hide();
                var mensaje = response.message;
                cargarMensajePorcentajeAsistencia(mensaje, "error");
                $('#tablaIncidenciasPorcentajeAsistencia').html(""); 
                $('#tablaIncEspPorcentajeAsis').html(""); 
                $('#tablaTurnosPresaupuestadosPorcentajASistencia').html(""); 
                $('#tablaIncPorHoraPorcentajeAsis').html(""); 
            }
         },
         error: function(jqXHR, textStatus, errorThrown) {
                waitingDialog.hide();
                alert(jqXHR.responseText);
                $("#tablaDetalleCobertura").hide();
         }
     });
 }

 function cargarMensajePorcentajeAsistencia(mensaje,status){
    $('#msgPorcentajeAsistencia').fadeIn('slow');
    mensajeAmostrar="<div id='msgAlert' class='alert alert-"+status+"'>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#msgPorcentajeAsistencia").html(mensajeAmostrar);
    $(document).scrollTop(0);
    $('#msgPorcentajeAsistencia').delay(3000).fadeOut('slow');
}

$("#descargaTablaPorcentajeAsistencia").click(function(event) {
  $("#datos_TablaHiddenPorcentajeAsis").val( $("<div>").append( $("#tablaTurnosPresaupuestadosPorcentajASistencia").eq(0).clone()).html() + $("<div>").append( $("#tablaPorcentajeAsistencia").eq(0).clone()).html() + $("<div>").append( $("#GraficaPorcentajeASistencia").eq(0).clone()).html() + $("<div>").append( $("#tablaIncidenciasPorcentajeAsistencia").eq(0).clone()).html() + $("<div>").append( $("#tablaIncEspPorcentajeAsis").eq(0).clone()).html() + $("<div>").append( $("#tablaIncPorHoraPorcentajeAsis").eq(0).clone()).html());
  $("#form_tablasDinamicasPorcentajeAsis").submit();
});




