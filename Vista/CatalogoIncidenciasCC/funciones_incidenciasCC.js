$(document).ready (function (){
    obtenerCatalogoIncidencias();
});//termina ready  


function obtenerCatalogoIncidencias(incidencia) {
    $("#divCatInc").empty();
    $.ajax({
        type: "POST",
        url: "CatalogoIncidenciasCC/ajax_ConsultaIncidencia.php",
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
                       tabla += "<td><input id='inpEsp" + datos1[i].idTipoIncidenciaCC + "' type='text' readonly='true' value='" + datos1[i].descripcionTipoIncidenciaCC + "'></td>";
                   });
                }else{
                   var tabla = "<h3>SIN INFORMACIÓN</h3>";
                }
                   $("#divCatInc").append(tabla);
                   $("#agregarInc").show();
            } else {
                var mensaje = response.message;
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
    });
}


// agregarIncecificacion

$("#agregarInc").click(function(){
  $("#modalAddIncCat").modal();
  $("#txtNuevaInc").val("");
});

function cancelarInc(incidencia){
  $("#modalAddIncCat").modal("hide");
}

function guardarInc(){

  var descripcion = $("#txtNuevaInc").val();

  $.ajax({
        type: "POST",
        url: "CatalogoIncidenciasCC/ajax_AgregarIncidencia.php",
        data:{descripcion},
        dataType: "json",
        success: function(response) {
            //console.log(response);
           if(response.status == "success") {
              swal("Listo","Incidencia agregada correctamente","success");
              $("#txtNuevaInc").val("");
              $("#modalAddIncCat").modal("hide");
              obtenerCatalogoIncidencias();
            } else {
                swal("Erros","Sucedió un error al guardar","warning");
                $("#txtNuevaInc").val("");
                $("#modalAddIncCat").modal("hide");
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
    });
}