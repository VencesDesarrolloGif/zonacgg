$(document).ready(function() 
{
$.ajax({
          type: "POST",
          url: "ajax_obtenerLineasdeNegocio.php",
          dataType: "json",
          success: function(response) {
            $("#lineaNegocioDetalleCobertura").empty();  
            $('#lineaNegocioDetalleCobertura').append('<option value="0">LINEA DE NEGOCIO</option>');
              if(response.status == "success"){
                for (var i = 0; i < response.valor.length; i++){
                    $('#lineaNegocioDetalleCobertura').append('<option value="'+(response.valor[i].idLineaNegocio)+'">'+response.valor[i].descripcionLineaNegocio+'</option>');
                  }
              }else{
                alert("Error al cargar Linea de Negocio");
              }
          },
            error: function(jqXHR, textStatus, errorThrown){
              alert(jqXHR.responseText);
            }
  });
});//termina ready

$("#btnCalcularTurnos").click(function(){

    var lineaNegocio= $("#lineaNegocioDetalleCobertura").val();
    var anio= $("#selectAnioDetalleCobertura").val();
    var mes = $("#selectMesDetalleCobertura").val();

    if(lineaNegocio=='0'){
        $("#tablaDetalleCobertura").hide();
          var mensaje="SELECCIONE UNA LINEA DE NEGOCIO";
          cargarmensajeDetalleCobertura(mensaje, "error");
    }else if(anio=='0'){
        $("#tablaDetalleCobertura").hide();
       var mensaje="SELECCIONE UN EJERCICIO";
       cargarmensajeDetalleCobertura(mensaje, "error");
    }else if(mes=='0'){
        $("#tablaDetalleCobertura").hide();
          var mensaje="SELECCIONE UN MES";
          cargarmensajeDetalleCobertura(mensaje, "error");
    }else{
      ConsultaCoberturaXEntidades(lineaNegocio,anio,mes); 
    }
});

 function ConsultaCoberturaXEntidades(lineaNegocio,anio,mes){ 
    waitingDialog.show();
    tablaDetCob = [];
    $.ajax({
        type: "POST",
        url: "DetalleCobertura/ajax_ConsultaDetalleCobertura.php",
        data:{lineaNegocio,anio,mes},
        dataType: "json",
        success: function(response) {
            console.log(response);
            if(response.status == "success") {
                waitingDialog.hide();
                $("#tablaDetalleCobertura").show();
                var largo = response.datos.length;
                var turnoSolicitadosDeDiaTotales = 0;
                var turnosCubiertosDiaTotales = 0;
                var porcentajeGeneralDiaCubiertoTotales = 0;
                var turnosSolicitadosDeNocheTotales = 0;
                var turnosCubiertosNocheTotales = 0;
                var porcentajeGeneralNocheCubiertoTotales = 0;
                var turnosSolicitadosPorDiaTotales = 0;
                var turnosCubiertosTotales = 0;
                var porcentajeGeneralCubiertoTotales = 0;
                for(var i = 0; i < largo; i++){

                    if(i == largo-1){
                        var entidadTotal1 = "°Total Suma";
                        var entidadTotal = entidadTotal1.fontcolor('green');

                        var porcentajeGeneralDiaCubiertoTotales2 =(turnosCubiertosDiaTotales/turnoSolicitadosDeDiaTotales)*100;
                        var porcentajeGeneralDiaCubiertoTotales1= porcentajeGeneralDiaCubiertoTotales2.toFixed(0);

                        var porcentajeGeneralNocheCubiertoTotales2 =(turnosCubiertosNocheTotales/turnosSolicitadosDeNocheTotales)*100;
                        var porcentajeGeneralNocheCubiertoTotales1= porcentajeGeneralNocheCubiertoTotales2.toFixed(0);

                        var porcentajeGeneralCubiertoTotales2 =(turnosCubiertosTotales/turnosSolicitadosPorDiaTotales)*100;
                        var porcentajeGeneralCubiertoTotales1= porcentajeGeneralCubiertoTotales2.toFixed(0);

                        porcentajeGeneralDiaCubiertoTotales11 = porcentajeGeneralDiaCubiertoTotales1+"%";
                        porcentajeGeneralNocheCubiertoTotales11 = porcentajeGeneralNocheCubiertoTotales1+"%";
                        porcentajeGeneralCubiertoTotales11 = porcentajeGeneralCubiertoTotales1+"%";

                        porcentajeGeneralDiaCubiertoTotales = porcentajeGeneralDiaCubiertoTotales11.fontcolor('green');
                        porcentajeGeneralNocheCubiertoTotales = porcentajeGeneralNocheCubiertoTotales11.fontcolor('green');
                        porcentajeGeneralCubiertoTotales = porcentajeGeneralCubiertoTotales11.fontcolor('green');


                        response.datos[i]["Entidad"] = entidadTotal;
                        response.datos[i]["turnoSolicitadosDeDia"] = turnoSolicitadosDeDiaTotales;
                        response.datos[i]["turnosCubiertosDia"] = turnosCubiertosDiaTotales;
                        response.datos[i].porcentajeGeneralDiaCubierto = porcentajeGeneralDiaCubiertoTotales;
                        response.datos[i]["turnosSolicitadosDeNoche"] = turnosSolicitadosDeNocheTotales;
                        response.datos[i]["turnosCubiertosNoche"] = turnosCubiertosNocheTotales;
                        response.datos[i].porcentajeGeneralNocheCubierto = porcentajeGeneralNocheCubiertoTotales;
                        response.datos[i]["turnosSolicitadosPorDia"] = turnosSolicitadosPorDiaTotales;
                        response.datos[i]["turnosCubiertos"] = turnosCubiertosTotales;
                        response.datos[i].porcentajeGeneralCubierto = porcentajeGeneralCubiertoTotales;
                    }else{
                        var turnosCubiertosDeDia  = response.datos[i]["turnosCubiertosDia"];
                        var turnosSolicitadosDeDia= response.datos[i]["turnoSolicitadosDeDia"];
    
                        var turnosCubiertosDeNoche  = response.datos[i]["turnosCubiertosNoche"];
                        var turnosSolicitadosDeNoche= response.datos[i]["turnosSolicitadosDeNoche"];
    
                        var turnosCubiertosTOTAL  = response.datos[i]["turnosCubiertos"];
                        var turnosSolicitadosTOTAL= response.datos[i]["turnosSolicitadosPorDia"];
    
                        if (turnosSolicitadosTOTAL!='0'){
                            if(turnosSolicitadosDeDia!='0'){
                                var porcentajeDia =(turnosCubiertosDeDia/turnosSolicitadosDeDia)*100;
                                var porcentajeGeneralDiaCubierto= porcentajeDia.toFixed(0);
                            }else{
                                var porcentajeGeneralDiaCubierto ='0';
                            }
                            if(turnosSolicitadosDeNoche!='0'){
                                var porcentajeNoche =(turnosCubiertosDeNoche/turnosSolicitadosDeNoche)*100;
                                var porcentajeGeneralNocheCubierto= porcentajeNoche.toFixed(0);
                            }else{
                                var porcentajeGeneralNocheCubierto ='0';
                            }
                            if(turnosSolicitadosTOTAL!='0'){
                                var porcentajeGeneral =(turnosCubiertosTOTAL/turnosSolicitadosTOTAL)*100;
                                var porcentajeGeneralCubierto= porcentajeGeneral.toFixed(0);
                            }else{
                                var porcentajeGeneralCubierto ='0';
                            }
                        }else{
                            var porcentajeGeneralDiaCubierto  = '0';
                            var porcentajeGeneralNocheCubierto= '0';
                            var porcentajeGeneralCubierto     = '0';
    
                             //response.datos[i]["Entidad"] = '0';
                             response.datos[i]["turnoSolicitadosDeDia"] = '0';
                             response.datos[i]["turnosCubiertosDia"] = '0';
                             response.datos[i]["turnosSolicitadosDeNoche"] = '0';
                             response.datos[i]["turnosCubiertosNoche"] = '0';
                             response.datos[i]["turnosSolicitadosPorDia"] = '0';
                             response.datos[i]["turnosCubiertos"] = '0';
                             turnosSolicitadosDeDia = 0;
                             turnosSolicitadosDeNoche = 0;
                             turnosSolicitadosTOTAL = 0;
                             turnosCubiertosDeDia =0;
                             turnosCubiertosDeNoche =0;
                             turnosCubiertosTOTAL =0;
                        }
                        ///////////////// Total De Totales /////////////////
    
                        turnoSolicitadosDeDiaTotales = turnoSolicitadosDeDiaTotales + turnosSolicitadosDeDia ;
                        turnosCubiertosDiaTotales = turnosCubiertosDiaTotales + turnosCubiertosDeDia ;
                        turnosSolicitadosDeNocheTotales = turnosSolicitadosDeNocheTotales + turnosSolicitadosDeNoche ;
                        turnosCubiertosNocheTotales = turnosCubiertosNocheTotales + turnosCubiertosDeNoche ;
                        turnosSolicitadosPorDiaTotales = turnosSolicitadosPorDiaTotales + turnosSolicitadosTOTAL ;
                        turnosCubiertosTotales = turnosCubiertosTotales + turnosCubiertosTOTAL ;
    
                       
                        ///////////////////////////////////////////////////
    
    
                        var porcentajeGeneralDiaCubiertoporcentajeGeneralDiaCubierto1 = porcentajeGeneralDiaCubierto+"%";
                        var porcentajeGeneralNocheCubiertoporcentajeGeneralNocheCubierto1 = porcentajeGeneralNocheCubierto+"%";
                        var porcentajeGeneralCubiertoporcentajeGeneralCubierto1 = porcentajeGeneralCubierto+"%";
                        var porcentajeGeneralDiaCubiertoporcentajeGeneralDiaCubierto = porcentajeGeneralDiaCubiertoporcentajeGeneralDiaCubierto1.fontcolor('blue');
                        var porcentajeGeneralNocheCubiertoporcentajeGeneralNocheCubierto = porcentajeGeneralNocheCubiertoporcentajeGeneralNocheCubierto1.fontcolor('blue');
                        var porcentajeGeneralCubiertoporcentajeGeneralCubierto = porcentajeGeneralCubiertoporcentajeGeneralCubierto1.fontcolor('blue');
                        response.datos[i].porcentajeGeneralDiaCubierto=porcentajeGeneralDiaCubiertoporcentajeGeneralDiaCubierto; 
                        response.datos[i].porcentajeGeneralNocheCubierto=porcentajeGeneralNocheCubiertoporcentajeGeneralNocheCubierto; 
                        response.datos[i].porcentajeGeneralCubierto= porcentajeGeneralCubiertoporcentajeGeneralCubierto;
                    }                    
                    var record = response.datos[i];
                    tablaDetCob.push(record);
                }
                loadDataIntableDetalleCobertura(tablaDetCob);
            }else{
                waitingDialog.hide();
                var mensaje = response.message;
                cargarmensajeDetalleCobertura(mensaje, "error");
                $("#tablaDetalleCobertura").hide();
            }
         },
         error: function(jqXHR, textStatus, errorThrown) {
                waitingDialog.hide();
                alert(jqXHR.responseText);
                $("#tablaDetalleCobertura").hide();
         }
     });
 }
 var tablaDeDetalleCobertura = null;

 function loadDataIntableDetalleCobertura(data) {
    if(tablaDeDetalleCobertura != null) {
        tablaDeDetalleCobertura.destroy();
    }

    var hoy = new Date();
    var diaHoy = hoy.getDate();
    if(diaHoy <= "9"){
        diaHoy = "0"+diaHoy;
    }
    var mesHoy = (hoy.getMonth() + 1 );
    if(mesHoy <= "9"){
        mesHoy = "0"+mesHoy;
    }
    var fecha = diaHoy + '-' + mesHoy + '-' + hoy.getFullYear();
    var hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();
    var fechaYHora = fecha + ' ' + hora;
    var titulo = "Zona Gif Seguridad "+fechaYHora;
    tablaDeDetalleCobertura = $('#tablaDetalleCobertura').DataTable({
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
         {  
             "data": "Entidad"
         }, 
         {   
             "data": "turnoSolicitadosDeDia"
         }, 
         {   
             "data": "turnosCubiertosDia"
         }, 
         {   
             "data": "porcentajeGeneralDiaCubierto"
         }, 
         {   
             "data": "turnosSolicitadosDeNoche"
         },
         {   
             "data": "turnosCubiertosNoche"
         },  
         {   
             "data": "porcentajeGeneralNocheCubierto"
         },
         {   
             "data": "turnosSolicitadosPorDia"
         },
         {   
             "data": "turnosCubiertos"
         },
         {  
             "data": "porcentajeGeneralCubierto"
         },
          ],
         processing: true,
         dom: 'Bfrtip',
         buttons: ['excel',{orientation:'landscape',extend:'pdf',title: titulo ,pageSize:'LEGAL'}]
        });
 }

 function cargarmensajeDetalleCobertura(mensaje,status){
    $('#msgDetalleCobertura').fadeIn('slow');
    mensajeAmostrar="<div id='msgAlert' class='alert alert-"+status+"'>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#msgDetalleCobertura").html(mensajeAmostrar);
    $(document).scrollTop(0);
    $('#msgDetalleCobertura').delay(3000).fadeOut('slow');
}