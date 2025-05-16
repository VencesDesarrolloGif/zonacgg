$(getListaJornadasAdmin());  

function getListaJornadasAdmin(){
 $("#divErrorJornadasAdmin").html("");
 $("#btnguardarJornadasAdmin").prop("disabled", true);
 $("#btnagregarJornadasAdmin").prop('disabled', false);
 $.ajax({
  type: "POST",
  url: "Jornadas/ajax_ConsultarCatalogoJornadas.php",
  dataType: "json",
  success: function(response) {
   if(response.status == "success") {
       var mensaje= response.message;
       var datos  = response.datos;
       $("#divListaJornadas").empty();
       var tabla  = "<table id='tablaJornadas' class='table table-bordered'><thead> <th>No</th><th>Descripción</th></thead><tbody>";
       $(document).scrollTop(0);
       $.each(datos, function(i) {
        tabla += "<tr><td><input class='form-control' id='inpidJornada" + i + "' type='text' style='text-transform: uppercase;' readonly='true' value='" + datos[i].idJornada + "'>    <input id='inpidJornadaHidden" + i + "' type='hidden' value='" + datos[i].idJornada + "'></td>";                        
        tabla += "<td><input class='form-control' id='inpDescJornada" + i + "' type='text' style='text-transform: uppercase;' readonly='true' value='" + datos[i].DescripcionJornada + "'>   <input id='inpDescJornadaHidden"   + i + "' type='hidden'  value='" + datos[i].DescripcionJornada + "'>    </td>";
       });                
       $("#divListaJornadas").append(tabla);
       $("#procesandoJornadasAdmin").hide();
    }else{
          var mensaje = response.message;
         }
 },
 error: function(jqXHR, textStatus, errorThrown) {
     alert(jqXHR.responseText);
      }
 });
}
function agregarJornada() {
    $("#divErrorJornadasAdmin").html("");
    var b       = $("#tablaJornadas tr").length;
    var table   = document.getElementById("tablaJornadas");
    var row     = table.insertRow(b);
    var contfila= row.insertCell(0);
    var cell1   = row.insertCell(1);

    for (var i = 0; i < b; i++) {
        contfila.innerHTML = " <td > " + (i + 1) + " </td>";
        cell1.innerHTML = "<input id='inpDescJornada" + i + "' type='text' style='text-transform: uppercase;'>";
    }
    $("#btnagregarJornadasAdmin").prop('disabled', true);
    $("#btnguardarJornadasAdmin").prop('disabled', false);
}
            
function guardarJornada() {
    var b = $("#tablaJornadas tr").length;
    var c = $("#tablaJornadas tr:last td").length;
   
    for(var i = 0; i < b-1 ; i++) {
        var NuevaJornada = $("#inpDescJornada" + i).val();
    } 
    if (NuevaJornada == "") {
        mensajeJornadasAdmin("error","Ingresa nueva jornada para continuar");
    }else {
        $.ajax({
            type: "POST",
            url: "Jornadas/ajax_InsertNuevaJornada.php",
            data: {NuevaJornada},
            dataType: "json",
            async: false,
            success: function(response) {
                var mensaje = response.message;
                if(response.status == "success") {
                    mensajeJornadasAdmin("success",mensaje);
                    getListaJornadasAdmin();
                }else{  
                    mensajeJornadasAdmin("error",mensaje);
                }
            },error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
        });
    }
}

function mensajeJornadasAdmin(tipo,mensaje){
    $('#divErrorJornadasAdmin').fadeIn();
    $(document).scrollTop(0);
    var Msgerror = "<div id='divErrorJornadasAdmin1' class='alert alert-"+tipo+"'><strong>"+mensaje+"</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#divErrorJornadasAdmin").html(Msgerror);
    $('#divErrorJornadasAdmin').delay(4000).fadeOut('slow'); 

}




