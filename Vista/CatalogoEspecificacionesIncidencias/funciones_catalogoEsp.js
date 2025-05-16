$(document).ready (function (){
    obtenerListaIncidencias();
});//termina ready  

function obtenerListaIncidencias(){ 
     $.ajax({
        type: "POST",
        url: "CatalogoEspecificacionesIncidencias/ajax_ConsultaIncidencias.php",
        dataType: "json",
        success: function(response) {
            if(response.status == "success"){
              var datos = response.datos;
              $('#selectIncidencias').empty().append('<option value="0">INCIDENCIA</option>');
              $.each(datos, function(i) {
                 $('#selectIncidencias').append('<option value="' + response.datos[i].idTipoIncidenciaCC + '">' + response.datos[i].descripcionTipoIncidenciaCC + '</option>');
              });
            }
        },error: function(jqXHR, textStatus, errorThrown){
           alert(jqXHR.responseText);
        }
    });
}

$('#selectIncidencias').change(function() {
    var incidencia = $("#selectIncidencias").val();

    if(incidencia!=0){
       consultarEspecificaciones(incidencia)
    }else{
        $("#agregarEsp").hide();
        $("#divEsp").empty();
    }
});

function consultarEspecificaciones(incidencia) {
    $("#divEsp").empty();
    $.ajax({
        type: "POST",
        url: "CatalogoEspecificacionesIncidencias/ajax_ConsultaEspXIncidencia.php",
        data:{incidencia},
        dataType: "json",
        success: function(response) {
            //console.log(response);
           if (response.status == "success") {
                var datos1 = response.datos;

                if(datos1.length!=0){
                   var tabla = "<table id='tabla' class='table table-bordered'><thead><th>Descripcion</th></thead><tbody>";
                   $(document).scrollTop(0);
                   $.each(datos1, function(i) {
                       tabla += "<tr>";
                       tabla += "<td><input id='inpEsp" + datos1[i].idEspecificacionIncidenciaCC + "' type='text' readonly='true' value='" + datos1[i].descripcionEspecificacionIncidenciaCC + "'></td>";
                   });
                }else{
                   var tabla = "<h3>SIN INFORMACIÓN</h3>";
                }
                   $("#divEsp").append(tabla);
                   $("#agregarEsp").show();
            } else {
                var mensaje = response.message;
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
    });
}

// agregarEspecificacion

$("#agregarEsp").click(function(){
  $("#modalAddEspecificacion").modal();
  $("#idIncidenciaModal").val($('select[name="selectIncidencias"] option:selected').text());
  $("#txtEspecificacion").val("");
});

function cancelarEsp(incidencia){
  $("#modalAddEspecificacion").modal("hide");
}

function guardarEsp(){

  var incidencia = $("#selectIncidencias").val();
  var especificacion = $("#txtEspecificacion").val();

  $.ajax({
        type: "POST",
        url: "CatalogoEspecificacionesIncidencias/ajax_AgregarEspecificacion.php",
        data:{incidencia,especificacion},
        dataType: "json",
        success: function(response) {
            //console.log(response);
           if(response.status == "success") {
              swal("Listo","Especificación agregada correctamente","success");
              $("#txtEspecificacion").val("");
              $("#modalAddEspecificacion").modal("hide");
              consultarEspecificaciones(incidencia);
            } else {
                swal("Erros","Sucedió un error al guardar","warning");
                $("#txtEspecificacion").val("");
                $("#modalAddEspecificacion").modal("hide");
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
    });
}