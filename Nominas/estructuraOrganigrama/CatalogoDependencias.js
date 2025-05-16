$(document).ready(function() {
    traerCatalogoDependencias();   
});
function traerCatalogoDependencias() {
 $("#divErrorDependencia").html("");
 $("#btneditarDependencia").prop("disabled", false);
 $("#btnguardarDependencia").prop("disabled", true);
 $("#btnagregarDependencia").prop('disabled', false);
 $.ajax({
  type: "POST",
  url: "ajax_ConsultaDependencias.php",
  dataType: "json",
  success: function(response) {
   if(response.status == "success") {
       var mensaje= response.message;
       var datos  = response.datos;
       $("#datosDependencia").empty();
       var tabla  = "<table id='tabla' class='table table-bordered'><thead><th>ID</th><th>Dependencia</th></thead><tbody>";
       $(document).scrollTop(0);
       $.each(datos, function(i) {
        tabla += "<tr><td><input class='form-control' id='inpNivelOrg"+ i + "' type='text' readonly='true' value='" + datos[i].idNivelOrg + "'><input id='inpNivelOrgHidden" + i + "' type='hidden' value='" + datos[i].idNivelOrg + "'></td>";
        tabla += "<td><input class='soloLetras' id='inpdescripcionNivel" +i+ "' type='text' readonly='true' value='" + datos[i].descripcionNivel + "'><input id='inpdescripcionNivelHidden"+i+"' type='hidden' value='"+datos[i].descripcionNivel+"'></td>";
       });                
       $("#datosDependencia").append(tabla);
       jQuery('.soloLetras').keypress(function (tecla) {
            if ((tecla.charCode < 65 || tecla.charCode > 90) && tecla.charCode != 32){return false;} 
        });
       $("#ModalDependencia").modal("hide");
       $("#procesandoDependencia").hide();
    }else{
          var mensaje = response.message;
         }
 },
 error: function(jqXHR, textStatus, errorThrown) {
     alert(jqXHR.responseText);
      }
 });
}

function editarDependencia() {
    $("#divErrorDependencia").html("");
    $("#inpaccionDependencia").val("Editar");
    var b = $("#tabla tr").length;
    var c = $("#tabla tr:last td").length;
    for (var i = 0; i < b - 1; i++) {
        $("#inpdescripcionNivel" + i).prop('readonly', false);
        $("#btneditarDependencia").prop("disabled", true);
        $("#btnguardarDependencia").prop("disabled", false);
        $("#btnagregarDependencia").prop('disabled', true);
    }
}

function guardarDependencia() {
    $("#divMSGDependencia").html("");
    var inpaccionDependencia = $("#inpaccionDependencia").val();
    var NivelOrg= '0';
    if (inpaccionDependencia === "Agregar") {
        var b = $("#tabla tr").length;
        var c = $("#tabla tr:last td").length;
        
        for(var i = b - 2; i < b - 1; i++) {
            var descripcionNivelOriginal= $("#inpdescripcionNivel" + i).val();
           }
        
        if (descripcionNivelOriginal == "") {
            $(document).scrollTop(0);
            $("#ModalDependencia").modal("hide"); 
            $("#procesandoDependencia").hide();
            var Msgerror = "<div id='divErrorDependencia' class='alert alert-error'><strong>Ingrese el nombre del Dependencia</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#divErrorDependencia").html(Msgerror);

        } else {
            $("#divErrorDependencia").html("");
            $("#btneditarDependencia").prop("disabled", false);
            $("#btnagregarDependencia").prop('disabled', false);
            $("#btnguardarDependencia").prop("disabled", true);
            
            for (var i = b - 2; i < b - 1; i++) {
                $("#inpdescripcionNivel" + i).prop('readonly', true);
            }

             $("#ModalDependencia").modal("show"); 
             $("#procesandoDependencia").show();
             var descripcionNivel=descripcionNivelOriginal.trim();
             $.ajax({
                type: "POST",
                url: 'ajax_InsertUpdateDependencias.php',
                data: {descripcionNivel,NivelOrg,'accion': 2},//insert
                success: function() {
                    $("#divMSGDependencia").html("");
                    $("#procesandoDependencia").hide();
                    $("#ModalDependencia").modal("hide");
                    $("#divMSGDependencia").fadeIn();
                    traerCatalogoDependencias();
                    var mensajeAgregar = "Se Agregó Correctamente"
                    alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+mensajeAgregar+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#divMSGDependencia").html(alertMsg1); 
                    $("#divMSGDependencia").delay('4000').fadeOut('slow');    
               }
            });
        }

    }else if (inpaccionDependencia === "Editar") {
        var descripcionNivel      = Array();
        var descripcionNivelhidden= Array();
        var NivelOrg= Array();
        var b = $("#tabla tr").length;
        var c = $("#tabla tr:last td").length;
       
        for (var i = 0; i < b - 1; i++) {
           var des  = $("#inpdescripcionNivel" + i).val();
           var desH = $("#inpdescripcionNivelHidden" + i).val();

            if(des != desH){
               descripcionOriginal      = $("#inpdescripcionNivel" + i).val();
               descripcionNivel[i]      = descripcionOriginal.trim();
               descripcionNivelhidden[i]= $("#inpdescripcionNivelHidden" + i).val();
               NivelOrg[i]   = $("#inpNivelOrg" + i).val();
             }

            if (descripcionNivel[i] == "") {
                $(document).scrollTop(0);
                var Msgerror = "<div id='divErrorDependencia' class='alert alert-error'><strong>Ingrese el nombre del Dependencia</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#divErrorDependencia").html(Msgerror);
                return 0;
            }
        }
            $("#ModalDependencia").modal("show"); 
            $("#procesandoDependencia").show();

            $.ajax({
            type: "POST",
            url: 'ajax_InsertUpdateDependencias.php',
            data: {descripcionNivel,NivelOrg,'accion': 1},//insert     
            success: function() {
                $("#divMSGDependencia").html("");
                $("#procesandoDependencia").hide();
                $("#ModalDependencia").modal("hide");
                $("#divMSGDependencia").fadeIn();
                traerCatalogoDependencias();
                var mensajeEdit = "Se Editó Correctamente"
                alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+mensajeEdit+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#divMSGDependencia").html(alertMsg1); 
                $("#divMSGDependencia").delay('4000').fadeOut('slow');  
            }
        });
    }
}

function agregarDependencia() {
    $("#divErrorDependencia").html("");
    $("#btneditarDependencia").prop("disabled", true);
    var b       = $("#tabla tr").length;
    var table   = document.getElementById("tabla");
    var row     = table.insertRow(b);
    var contfila= row.insertCell(0);
    var cell1   = row.insertCell(1);

    for (var i = 0; i < b; i++) {
        cell1.innerHTML = "<input id='inpdescripcionNivel" + i + "' type='text' placeholder='SOLO MAYUSCULAS' class='soloLetras'>>";
    }
    jQuery('.soloLetras').keypress(function (tecla) {
        if ((tecla.charCode < 65 || tecla.charCode > 90) && tecla.charCode != 32) return false;
        // if (tecla.charCode != 32) return false;
    });
    $("#btnagregarDependencia").prop('disabled', true);
    $("#inpaccionDependencia").val("Agregar");
    $("#btnguardarDependencia").prop('disabled', false);
}