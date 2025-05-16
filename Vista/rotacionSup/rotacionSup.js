$(inicioRotSup());  

function inicioRotSup(){
   CargarSelectorLineaNegocioRS();
}
function CargarSelectorLineaNegocioRS(){

$.ajax({
        type: "POST",
        url: "lineasNegocio/ajax_obtenerLineasdeNegocio.php",
        dataType: "json",
        success: function(response){
          $("#seleccionarLineNegocioRotacionSup").empty();  
          $('#seleccionarLineNegocioRotacionSup').append('<option value="0">LINEA DE NEGOCIO</option>');
            if(response.status == "success"){
              for(var i = 0; i < response.datos.length; i++){
                  $('#seleccionarLineNegocioRotacionSup').append('<option value="'+(response.datos[i].idLineaNegocio)+'">'+response.datos[i].descripcionLineaNegocio+'</option>');
                }
            }else{
              alert("Error al cargar Linea de Negocio");
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
          alert(jqXHR.responseText);
        }
  });
}

$("#seleccionarLineNegocioRotacionSup").change(function(){

  var lineaNegoElegida= $("#seleccionarLineNegocioRotacionSup").val();
  
  $("#DivGraficaRSupervisor").hide();
  $("#divTablaRotacionSup").hide();
  $("#inputFechaInicioRotacionSup").val("");
  $("#inputFechaFinRotacionSup").val("");
  $("#selectTipoBusqueda").val(0);
  $("#selectEntidad").val("");


  if(lineaNegoElegida=='0'){
    $("#DivFechaRotacionSup").hide(); 
    $("#BTNBuscarRotacion").hide();
    $("#selectTipoBusqueda").hide();
    $("#selectRegion").hide();
    $("#selectEntidad").hide();
    return;
  }
    var user= consultaUsuario();

    if(user=='Supervisor'){
          cargarInputFechasRotSup();
          $("#DivFechaRotacionSup").show();
          $("#BTNBuscarRotacion").show();
    }else{
          $("#selectTipoBusqueda").show();
          $("#selectRegion").hide();
          $("#selectEntidad").hide();
          $("#DivFechaRotacionSup").hide();
          $("#BTNBuscarRotacion").hide();
          cargarInputFechasRotSup();
    }
});

$("#selectTipoBusqueda").change(function(){
    var tipoB=$("#selectTipoBusqueda").val();  
    var lineaNegoElegida= $("#seleccionarLineNegocioRotacionSup").val();
    $("#selectEntidad").hide();
    $("#DivFechaRotacionSup").hide();
    $("#BTNBuscarRotacion").hide();
    $("#inputFechaInicioRotacionSup").val("");
    $("#inputFechaFinRotacionSup").val("");
    $("#BTNBuscarRotacion").hide();
    $("#divTablaRotacionSup").hide();
    $("#DivGraficaRSupervisor").hide();
    $("#DivGraficaRSupervisorGeneral").hide();
    $("#DivGraficaRSupervisorGeneralDG1").hide();


    if(tipoB!=0){
        $.ajax({
                type: "POST",
                url: "rotacionSup/ajax_ConsultaRegionEntidadXusuario.php",
                 data:{"lineaNegoElegida":lineaNegoElegida},
                dataType: "json",
                success: function(response){
                    if(response.status == "success"){
                        
                        if(response.tipo == "1"){//DG, contrataciones,centro de control:
    
                            $("#selectRegion").empty();  
                            $('#selectRegion').append('<option value="0">REGION</option>');
                            for(var i = 0; i < response.datos.length; i++){
                                $('#selectRegion').append('<option value="'+(response.datos[i].idregioni)+'">'+response.datos[i].DescripcionI+'</option>');
                            }
                            $("#selectRegion").show();
                        }else if(response.tipo == "2"){//supervisor

                              $("#BTNBuscarRotacion").show();

                        }else if(response.tipo == "3"){//Gerente Regional:
    
                            $("#BTNBuscarRotacion").show();
                            $("#DivFechaRotacionSup").show();
                            $("#selectRegion").empty();  
                            $('#selectRegion').append('<option value="'+(response.datos[0].idregioni)+'">REGIÓN '+response.datos[0].DescripcionI+'</option>');
                            $("#selectRegion").show();
                            $("#selectRegion").prop("disabled", true);
                            $("#selectEntidad").show();

                            $("#selectEntidad").empty();  
                            $('#selectEntidad').append('<option value="0">ENTIDAD</option>');
                            for(var i = 0; i < response.entidades.length; i++){
                                $('#selectEntidad').append('<option value="'+(response.entidades[i].idEntidadFederativa)+'">'+response.entidades[i].nombreEntidadFederativa+'</option>');
                            }
                        }
                    }else{
                      alert("Error al cargar Linea de Negocio");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
                }
        });
    }else{
        $("#selectRegion").hide();
        $("#selectEntidad").hide();
        return;
    }
});

$("#selectRegion").change(function(){

    var region=$("#selectRegion").val(); 
    var lineaNegoElegida= $("#seleccionarLineNegocioRotacionSup").val();
    $("#divTablaRotacionSup").hide();
    $("#DivGraficaRSupervisor").hide();

    if(region!=0){
            $("#BTNBuscarRotacion").show();

        $.ajax({
                type: "POST",
                url: "rotacionSup/ajax_ConsultaEntidadesXRegion.php",
                 data:{"region":region,"lineaNegoElegida":lineaNegoElegida},
                dataType: "json",
                success: function(response){
                    if(response.status == "success"){
                        
                            $("#selectEntidad").empty();  
                            $('#selectEntidad').append('<option value="0">ENTIDAD</option>');
                            for(var i = 0; i < response.datos.length; i++){
                                $('#selectEntidad').append('<option value="'+(response.datos[i].idEntidadFederativa)+'">'+response.datos[i].nombreEntidadFederativa+'</option>');
                            }
                            $("#selectEntidad").show();
                            $("#DivFechaRotacionSup").show(); 
                            $("#BTNBuscarRotacion").show();

                    }else{
                      alert("Error al cargar Linea de Negocio");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
                }
        });
    }else{
          $("#selectEntidad").hide();
          $("#DivFechaRotacionSup").hide(); 
          $("#inputFechaInicioRotacionSup").val("");
          $("#inputFechaFinRotacionSup").val("");
          $("#BTNBuscarRotacion").hide();
    }
});

$("#selectEntidad").change(function(){

  $("#divTablaRotacionSup").hide();
  $("#DivGraficaRSupervisor").hide();
  var usuario = $("#usuarioHidden").val();
  var entidad = $("#selectEntidad").val();

  

  // if(usuario=="Supervisor"){
  //   if (entidad=='0'){
  //       $("#DivFechaRotacionSup").hide();
  //       $("#BTNBuscarRotacion").hide();
  //   }else{
  //       $("#DivFechaRotacionSup").show();
  //       $("#BTNBuscarRotacion").show();
  //   }
  // }
});


$("#BTNBuscarRotacion").click(function(){
  var tipoBusqueda= $("#selectTipoBusqueda").val();
  var region= $("#selectRegion").val();
  var entidad= $("#selectEntidad").val();
  var fechai= $("#inputFechaInicioRotacionSup").val();
  var fechaf= $("#inputFechaFinRotacionSup").val();
  var lineaNeg = $("#seleccionarLineNegocioRotacionSup").val();
  var usuario = $("#usuarioHidden").val();
  var mansaje="";
  
  if (usuario!="Supervisor"){

        if(tipoBusqueda=='0'){
           mansaje ="ingrese Tipo de Busqueda";
           cargarmensajeerrorRotSup(mansaje);
           return;
        }
        if(region=='0'){
           mansaje ="ingrese Región";
           cargarmensajeerrorRotSup(mansaje);
           return;
        }
    }    
        if(((fechai!=0 && fechai!="" && fechai!=null && fechai!="null" && fechai!="NULL") && (fechaf!=0 && fechaf!="" && fechaf!=null && fechaf!="null" && fechaf!="NULL")) && fechai <= fechaf){
           //alert("1");
           waitingDialog.show();    
           consultaRotacionSup(fechai,fechaf,lineaNeg,region,entidad,tipoBusqueda);
          }
        
        if((fechaf!=0 && fechaf!="" && fechaf!=null && fechaf!="null" && fechaf!="NULL") && (fechai==0 || fechai=="" || fechai==null || fechai=="null" || fechai=="NULL")){
         //alert("2");
           mansaje ="ingrese Fecha inicial";
           cargarmensajeerrorRotSup(mansaje);
          }
        
        if((fechai!=0 && fechai!="" && fechai!=null && fechai!="null" && fechai!="NULL") && (fechaf==0 || fechaf=="" || fechaf==null || fechaf=="null" || fechaf=="NULL")){
           //alert("3");
           mansaje ="ingrese Fecha final";
           cargarmensajeerrorRotSup(mansaje);
          }
        
        if((fechai==0 || fechai=="" || fechai==null || fechai=="null" || fechai=="NULL") && (fechaf==0 || fechaf=="" || fechaf==null || fechaf=="null" || fechaf=="NULL")){
           //alert("4");
           mansaje ="Ingrese Fechas";
           cargarmensajeerrorRotSup(mansaje);
          }
        
        if((fechai > fechaf) && (fechaf!=0 && fechaf!="" && fechaf!=null && fechaf!="null" && fechaf!="NULL")){
           //alert("5");
           mansaje ="La fecha de inicio elegida no puede ser mayor a la fecha final";
           cargarmensajeerrorRotSup(mansaje);
          }
});

function consultaRotacionSup(fechai,fechaf,lineaNeg,region,entidad,tipoBusqueda){
  tablaRotSup = [];
  var sumaDiasRotSupEmp=0;
  var diasRotSupEmpleado=0;

  $.ajax({
          type: "POST",
          url: "rotacionSup/ajax_ConsultaRotacionSup.php",
          data:{"fechai":fechai,"fechaf":fechaf,"lineaNeg":lineaNeg,"region":region,"entidad":entidad,"tipoBusqueda":tipoBusqueda},
          dataType: "json", 
          success: function(response){
            if(response.status == "success"){
                var rol= response.rol;

                if(rol=="Supervisor"){

                    var dias = [];
                    var bajasXDias = [];
                    var altasXDias = [];
                    var reingresosXDias = [];
                    var elementosPorFechas= response.fechas;
                    var conteoElemXFecha=response["fechas"].length;

                    var canvasDia = "<canvas id='graficaElemetosXsupDia' name='graficaElemetosXsupDia'></canvas>";
                    $('#DivGrafRSupDias1').html(canvasDia); 

                    for(var b = 0; b < conteoElemXFecha; b++) {
                        var dia=elementosPorFechas[b]["fecha"];
                        var bajasXdia=elementosPorFechas[b]["bajas"];
                        var altasXdia=elementosPorFechas[b]["altas"];
                        var reingresosXdia=elementosPorFechas[b]["reingresos"];

                        dias.push(dia);
                        bajasXDias.push(bajasXdia);
                        altasXDias.push(altasXdia);
                        reingresosXDias.push(reingresosXdia);
                    }//for b

                    var graficaCanvasDia = document.getElementById("graficaElemetosXsupDia"); 
                    $("#DivGraficaRSupervisorDia").show();

                    // Chart.defaults.global.defaultFontFamily = "Lato";
                    // Chart.defaults.global.defaultFontSize = 12;
                    Chart.defaults.font.family = 'Lato';  // Usando el nuevo formato
                    Chart.defaults.font.size = 12;  // Establecer el tamaño de la fuente
                
                    var totalIngresosXDia = {
                        label: ' Ingresos',
                        data: altasXDias ,
                        backgroundColor: 'rgba(52, 152, 219, 1)',         
                        yAxisID: "barElementosSupXDia"
                    };
        
                    var totalinactivosXDia = {
                        label: 'Bajas',
                        data: bajasXDias,
                        backgroundColor: 'rgba(231, 76, 60, 1)',
                        yAxisID: "barElementosSupXDia"
                    }; 
    
                    var totalReingresosXDia = {
                        label: 'Reingresos',
                        data: reingresosXDias,
                        backgroundColor: 'rgba(46, 204, 113, 1)',          
                        yAxisID: "barElementosSupXDia"
                    };
    
                    
                    var datoselementosXDia = {
                        labels: dias ,
                        datasets: [totalIngresosXDia, totalinactivosXDia,totalReingresosXDia]
                        // datasets: [totalinactivos]
                    };            
                    
                    var chartOptionsXDia = {
                         scales: {                  
                            yAxes: [{id: "barElementosSupXDia"}]
                         }
                        };          
                
                    var barChartXdia = new Chart(graficaCanvasDia, {
                      type: 'bar',
                      data: datoselementosXDia,
                      options: chartOptionsXDia,
                    });  


                }//if superverisor

                ///////////////////////////
                var nombres = [];
                var numeroEmp = [];
                var elementosIng = [];
                var elementosBaja = [];
                var elementosREING = [];
                var ingresosSuma=0;
                var reingresosSuma=0;
                var bajaSuma=0;
                var datosSup= response.quince;
                var canvas = "<canvas id='graficaElemetosXsup' name='graficaElemetosXsup'></canvas>";
                var canvasPie = "<canvas id='graficaElemetosXsupPie' name='graficaElemetosXsupPie'></canvas>";
                if(rol=="Supervisor"){
                   // $('#DivGrafRSup').html(canvas); 
                   $('#DivGrafRSupPie').html(canvasPie); 
                }else {
                   $('#DivGrafRSupGeneral').html(canvas); 
                   $('#DivGrafRSupPieGeneral').html(canvasPie); 
                }

                var totalSup=response["quince"].length;

                if (totalSup>15){
                    totalSup=15;
                }

                for (var a = 0; a < totalSup; a++) {

                     var nombreSup= datosSup[a]["nombreSup"]; 
                     var numeroSup= datosSup[a]["noSup"]; 
                     var altas= datosSup[a]["empleadosA"]; 
                     var reing= datosSup[a]["empleadosR"];
                     var bajas= datosSup[a]["empleadosB"];
                     nombres.push(nombreSup);
                     numeroEmp.push(numeroSup);
                     elementosIng.push(altas);
                     elementosREING.push(reing);         
                     elementosBaja.push(bajas); 
                }

                var graficaCanvas = document.getElementById("graficaElemetosXsup"); 
                var graficaCanvasPie = document.getElementById("graficaElemetosXsupPie"); 
                
                if(rol=="Supervisor"){
                   $("#DivGraficaRSupervisor").show();
                }else{
                   $("#DivGraficaRSupervisorGeneral").show();
                }
                if (rol=="Direccion General"){
                 Chart.defaults.font.family = 'Lato';  // Usando el nuevo formato
                Chart.defaults.font.size = 12;  // Establecer el tamaño de la fuente
                // Chart.defaults.global.defaultFontFamily = "Lato";
                // Chart.defaults.global.defaultFontSize = 12;
                }
                if (rol=="Gerente Regional"){
                    Chart.defaults.font.family = 'Lato';  // Usando el nuevo formato
                    Chart.defaults.font.size = 12;  // Establecer el tamaño de la fuente
                }    
             
                var totalIngresos = {
                    label: ' Ingresos',
                    data: elementosIng ,
                    backgroundColor: 'rgba(52, 152, 219, 1)',         
                    yAxisID: "barElementosSup"
                };
    
                var totalinactivos = {
                    label: 'Bajas',
                    data: elementosBaja,
                    backgroundColor: 'rgba(231, 76, 60, 1)',
                    yAxisID: "barElementosSup"
                }; 

                var totalReingresos = {
                    label: 'Reingresos',
                    data: elementosREING,
                    backgroundColor: 'rgba(46, 204, 113, 1)',          
                    yAxisID: "barElementosSup"
                };
                
                var datoselementos = {
                    labels: nombres ,
                    datasets: [totalIngresos, totalinactivos,totalReingresos]
                    // datasets: [totalinactivos]
                };            
                
                var chartOptions = {
                     scales: {                  
                        yAxes: [{id: "barElementosSup"}]
                     }
                    };          
            
                var barChart = new Chart(graficaCanvas, {
                  type: 'bar',
                  data: datoselementos,
                  options: chartOptions,
                });  

                if(rol=="Supervisor"){

                    var myChart1 = new Chart(graficaCanvasPie, {
                    type: 'pie',
                    data:{
                          labels: ['INGRESOS','BAJAS','REINGRESOS'],
                          datasets:[{
                                     label:  ['INGRESOS','BAJAS','REINGRESOS'],
                                     data: [elementosIng,elementosBaja,elementosREING],
                                     backgroundColor:['rgba(52, 152, 219, 1)','rgba(231, 76, 60, 1)','rgba(46, 204, 113, 1)'], 
                                     borderColor:    ['rgba(52, 152, 219, 1)','rgba(231, 76, 60, 1)','rgba(46, 204, 113, 1)'],
                                     borderWidth: 1
                          }]
                        },
                    });
                }
                    ////////////////////////////////////////////////////////

                for(var i = 0; i < response.datos.length; i++){
                    var record = response.datos[i];
                    tablaRotSup.push(record);

                    var altas= record["ingresos"]; 
                    var reing= record["reingresos"];
                    var bajas= record["bajas"];
                    ingresosSuma=ingresosSuma+parseInt(altas);
                    reingresosSuma=reingresosSuma+parseInt(reing);
                    bajaSuma=bajaSuma+parseInt(bajas);
                }
                    if(rol!="Supervisor"){

                        var myChart1 = new Chart(graficaCanvasPie, {
                        type: 'pie',
                        data:{
                              labels: ['INGRESOS','BAJAS','REINGRESOS'],
                              datasets:[{
                                         label:  ['INGRESOS','BAJAS','REINGRESOS'],
                                         data: [ingresosSuma,bajaSuma,reingresosSuma],
                                         backgroundColor:['rgba(52, 152, 219, 1)','rgba(231, 76, 60, 1)','rgba(46, 204, 113, 1)'], 
                                         borderColor:    ['rgba(52, 152, 219, 1)','rgba(231, 76, 60, 1)','rgba(46, 204, 113, 1)'],
                                         borderWidth: 1
                              }]
                            },
                        });
                    }
                   $("#divTablaRotacionSup").show();
                   var tipo =$("#selectTipoBusqueda").val();
                   if (tipo==1){
                        CargarTablaRotSupMejores(tablaRotSup);
                   }else{
                        CargarTablaRotSupPeores(tablaRotSup);
                   }
                }else{
                     var mensaje = response.message;
                     }
                     waitingDialog.hide();    
                },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
 }

 var tablaRS = null;

 function CargarTablaRotSupPeores(data) {
  
  if(tablaRS != null) {
      tablaRS.destroy();
    }

   tablaRS = $('#tablaRotacionSupEmpleados').DataTable({
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
    "columns": [
        {"className": "dt-body-center", "data": "supervisorId"},
        {"data": "nombre"},
        {"data": "nombreEntidadFederativa"},
        {"className": "dt-body-center", "data": "ingresos"},
        {"className": "dt-body-center", "data": "bajas"},
        {"className": "dt-body-center", "data": "reingresos"}
    ],
    processing: true,
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'excelHtml5',
            title: function () {
                var date = new Date();
                var year = date.getFullYear();
                var month = ("0" + (date.getMonth() + 1)).slice(-2);
                var day = ("0" + date.getDate()).slice(-2);
                return (
                    "reporte" +
                    day +
                    "-" +
                    month +
                    "-" +
                    year
                );
            },
        }
    ],
    "order": [[4, 'desc']] // Esta línea ordena por la columna 4 (campo "bajas") de menor a mayor
});

}


 function CargarTablaRotSupMejores(data) {
  
  if(tablaRS != null) {
      tablaRS.destroy();
    }

   tablaRS = $('#tablaRotacionSupEmpleados').DataTable({
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
    "columns": [
        {"className": "dt-body-center", "data": "supervisorId"},
        {"data": "nombre"},
        {"data": "nombreEntidadFederativa"},
        {"className": "dt-body-center", "data": "ingresos"},
        {"className": "dt-body-center", "data": "bajas"},
        {"className": "dt-body-center", "data": "reingresos"}
    ],
    processing: true,
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'excelHtml5',
            title: function () {
                var date = new Date();
                var year = date.getFullYear();
                var month = ("0" + (date.getMonth() + 1)).slice(-2);
                var day = ("0" + date.getDate()).slice(-2);
                return (
                    "reporte" +
                    day +
                    "-" +
                    month +
                    "-" +
                    year
                );
            },
        }
    ],
    "order": [[4, 'asc']] // Esta línea ordena por la columna 4 (campo "bajas") de menor a mayor
});

}

 function cargarInputFechasRotSup(){

$('#inputFechaInicioRotacionSup').datetimepicker({   
    timepicker:false,
    format:'Y-m-d',
    formatDate:'Y-m-d',
  });

$('#inputFechaFinRotacionSup').datetimepicker({
    timepicker:false,
    format:'Y-m-d',
    formatDate:'Y-m-d',
  });
}

function cargarmensajeerrorRotSup(mensaje){
  $('#divMensajeRotacionSup').fadeIn('slow');
  mensajeErrorP="<div id='msgAlert' class='alert alert-error'><strong>Error:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
  $("#divMensajeRotacionSup").html(mensajeErrorP);
  $(document).scrollTop(0);
  $('#divMensajeRotacionSup').delay(3000).fadeOut('slow');
}

function consultaUsuario(){

    var rol ="";

    $.ajax({
            type: "POST",
            url: "rotacionSup/ajax_ConsultaUsuario.php",
            dataType: "json",
            async: false,
            success: function(response){
                if(response.status == "success"){
                        rol =response["rol"];
                        $("#usuarioHidden").val(rol);
                }else{
                  alert("Error al cargar Linea de Negocio");
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
              alert(jqXHR.responseText);
            }
        });
    return rol;
}