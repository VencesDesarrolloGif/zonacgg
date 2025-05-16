 $(document).ready(function() {
 });

function CargarEntidadesParaMatriz(){
    //waitingDialog.show();
    $.ajax({
        type: "POST",
        url: "NuevaMatriz/ajax_ListaEntidadesParaMatriz.php",
        dataType: "json",
        success: function(response) {
         // console.log(response);
            var datos = response.datos;
            $('#selectNuevaMatriz').empty().append('<option value="0" selected="selected">Entidad/Matriz</option>');
            $.each(datos, function(i) {
                if(response.datos[i].estatus != "1"){
                    $('#selectNuevaMatriz').append('<option value="' + response.datos[i].idEntidadFederativa+ '">' + response.datos[i].nombreEntidadFederativa + '</option>');
                }
            });
            $("#InpNuevaMatriz").val("");     
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
    });  
 }

 
$("#selectNuevaMatriz").change(function()
  {
    var entidad= $('select[name="selectNuevaMatriz"] option:selected').text(); 
    $("#InpNuevaMatriz").val(entidad);
    CargarEntidadesParaAsignarALaMatriz(0);
    var b = $("#tablaMatriz tr").length;
    if(b != "1"){
        for (var j = b; j > 1; j--) {
            var tableDelete =  document.getElementById("tablaMatriz").deleteRow(1);
        }
    }
});

function CargarEntidadesParaAsignarALaMatriz(opcion){
    waitingDialog.show();
    $.ajax({
        type: "POST",
        url: "NuevaMatriz/ajax_ListaEntidadesParaAsignarALaMatriz.php",
        dataType: "json",
        success: function(response) {
            var datos = response.datos;
            $('#SelectEnidadParaMatriz').empty().append('<option value="0" selected="selected">Entidades</option>');
            $.each(datos, function(i) {
                $('#SelectEnidadParaMatriz').append('<option value="' + response.datos[i].idEntidadFederativa+ '">' + response.datos[i].nombreEntidadFederativa + '</option>');

                if(opcion=="1"){
                    var b = $("#tablaMatriz tr").length;
                    for (var j = 1; j < b; j++) {
                        var k=j-1;
                        var IdentidadA = $("#intEntidad"+ k +"").val();
                        if(response.datos[i].idEntidadFederativa == IdentidadA){
                            $("#SelectEnidadParaMatriz option[value='" + response.datos[i].idEntidadFederativa + "']").remove();
                        }
                    }
                }
            });
            waitingDialog.hide();     
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
            waitingDialog.hide();
        }
    });  

}

function cargaerroresmatrices(mensaje){
  alertMsj1="<div class='alert alert-error' id='Mensaje'>"+mensaje+"<data-dismiss='alert'>";
  $("#MensajeNuevaMatriz").html(alertMsj1);
  $(document).scrollTop(0);
  $('#Mensaje').delay(4000).fadeOut('slow');
}

$("#AgregarNuevaEntidadMatriz").click(function () {
    var entidad= $('select[name="SelectEnidadParaMatriz"] option:selected').text();   //$("#selectEntidades").val(); // cambiar por el texto
    var SelectEnidadParaMatriz=$("#SelectEnidadParaMatriz").val();
    if(SelectEnidadParaMatriz=="0" || SelectEnidadParaMatriz=="Entidades"){
        cargaerroresmatrices('Seleccione Una Entidad Para Agregar A La Matriz');
    }else{
        var b = $("#tablaMatriz tr").length;
        var table = document.getElementById("tablaMatriz");
        var row = table.insertRow(b);
        var contfila = row.insertCell(0);
        var cell1 = row.insertCell(1);
        var cell2 = row.insertCell(2);
        for (var i = 0; i < b; i++) {
            contfila.innerHTML = " <td > " + (i + 1) + " </td>";
            cell1.innerHTML = "<input class='span2' id='intEntidad" + i + "' type='text'readonly>";
            cell2.innerHTML = "<input class='span2' id='intEntidadNombre" + i + "' type='text'readonly>";
          //  cell2.innerHTML = "<img style='width: 24%' title='Eliminar' src='img/eliminar.png' class='cursorImg' id='btnEliminarEntidad" + i + "' onclick=EliminarRegistroEntidad()>";
        }
        $("#intEntidad"+(b-1)).val(SelectEnidadParaMatriz);
        $("#intEntidadNombre"+(b-1)).val(entidad);
        CargarEntidadesParaAsignarALaMatriz(1);
    }
});


$("#GuardarNuevaEntidadMatriz").click(function () {
    var tabla = $("#tablaMatriz tr").length;
    var idEntidadMat       = Array();
    var nombreEntidadMat   = Array();
    var inpNuevaMatriz = $("#InpNuevaMatriz").val();
    var selectNuevaMatriz = $("#selectNuevaMatriz").val();
    var bandera ="0";
    if(selectNuevaMatriz =="" || selectNuevaMatriz =="0" || selectNuevaMatriz== "Entidad/Matriz"){
        cargaerroresmatrices('Seleccione Una Entidad Que Será La Nueva Matriz');
    }else if(tabla <= "1"){
        cargaerroresmatrices('Ingrese Las Entidades Que Estarán A cargo De Esta Matriz');
    }else{
        waitingDialog.show();
        for (var i=0; i<tabla-1;i++) 
        {
            idEntidadMat[i]     = $("#intEntidad" + i).val();
            nombreEntidadMat[i] = $("#intEntidadNombre" + i).val();
            if(idEntidadMat[i] == selectNuevaMatriz){
                bandera ="1";
            }
        }
        if(bandera =="0"){
            cargaerroresmatrices("Seleccione La Entidad "+ inpNuevaMatriz+" Como Dependencia De Esta Matriz Para Continuar");
            waitingDialog.hide();
        }else{
            $.ajax({
                type: "POST",
                url: "NuevaMatriz/ajax_RegistrarMatrisYEntidades.php",
                 data:{'idEntidadMat': idEntidadMat,'nombreEntidadMat': nombreEntidadMat,'inpNuevaMatriz': inpNuevaMatriz,'selectNuevaMatriz': selectNuevaMatriz},
                dataType: "json",
                success: function(response) {
                    if(response.status == "success"){
                        var mensajeSucces = response.message
                        alertMsj1="<div class='alert alert-success' id='Mensaje1'>"+mensajeSucces+"<data-dismiss='alert'>";
                        $("#MensajeNuevaMatriz").html(alertMsj1);
                        $(document).scrollTop(0);
                        $('#Mensaje1').delay(4000).fadeOut('slow');
                        var b = $("#tablaMatriz tr").length;
                        for (var j = b; j > 1; j--) {
                            var tableDelete =  document.getElementById("tablaMatriz").deleteRow(1);
                        }
                        $("#SelectEnidadParaMatriz").empty();
                        CargarEntidadesParaMatriz();
                     }
                     waitingDialog.hide();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                     alert(jqXHR.responseText);
                     waitingDialog.hide();
                 }
            });
        }
        

    }
        

});
