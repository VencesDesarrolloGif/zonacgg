$(traerCatalogoRepse());  

function traerCatalogoRepse() {
 $("#divErrorRepse").html("");
 $("#btneditarREPSE").prop("disabled", false);
 $("#btnguardarREPSE").prop("disabled", true);
 $("#btnagregarREPSE").prop('disabled', false);
 $.ajax({
  type: "POST",
  url: "ajax_ConsultaREPSE.php",
  dataType: "json",
  success: function(response) {
   if(response.status == "success") {
       var mensaje= response.message;
       var datos  = response.datos;
       $("#datosRepse").empty();
       var tabla  = "<table id='tabla' class='table table-bordered'><thead> <th>No</th> <th>No. de acuerdo</th> <th>No. de folio de ingreso</th> <th>Eliminar</th></thead><tbody>";
       $(document).scrollTop(0);
       $.each(datos, function(i) {
        tabla += "<tr><td><input class='form-control' id='inpidRepse" + i + "' type='text' readonly='true' value='" + datos[i].idRepse + "'>    <input id='inpidRepseHidden" + i + "' type='hidden' value='" + datos[i].idRepse + "'></td>";                        
        tabla += "<td><input class='form-control' id='inpNoAcuerdo" + i + "' type='text' readonly='true' value='" + datos[i].NumAcuerdo + "'>   <input id='inpNoAcuerdoHidden"   + i + "' type='hidden'  value='" + datos[i].NumAcuerdo + "'>    </td>";
        tabla += "<td><input class='form-control' id='inpNoFolioIn" + i + "' type='text' readonly='true' value='" + datos[i].NumFolioIngreso+"'><input id='inpNoFolioHidden"+ i + "' type='hidden'  value='" + datos[i].NumFolioIngreso +"'></td>";
        tabla += "<td><img style='width: 20%' title='Eliminar' src='../img/eliminar.png' class='cursorImg' id='btneliminarRepse' onclick='EliminarREPSEbtn("+ i +")'></td>";
       });                
       $("#datosRepse").append(tabla);
       $("#ModalRepse").modal("hide");
       $("#procesandoRepse").hide();
    }else{
          var mensaje = response.message;
         }
 },
 error: function(jqXHR, textStatus, errorThrown) {
     alert(jqXHR.responseText);
      }
 });
}

function EliminarREPSEbtn(i){
    var idRep = $("#inpidRepseHidden" + i).val();
    $("#ModalRepse").modal("show"); 
    $("#procesandoRepse").show(); 
    $.ajax({
         type: "POST",
         url: 'ajax_EliminarRepse.php',
         data: {idRep},
         success: function(response){ 
             $("#divMSGRepse").html("");
             $("#procesandoRepse").hide();
             $("#ModalRepse").modal("hide");
             $("#divMSGRepse").fadeIn();
             traerCatalogoRepse();
             var mensajeElim = "Se Eliminó Correctamente"
             alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+mensajeElim+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
             $("#divMSGRepse").html(alertMsg1); 
             $("#divMSGRepse").delay('4000').fadeOut('slow');         
        }
     });
}
            
function editarREPSE() {
    $("#divErrorRepse").html("");
    $("#inpaccionRepse").val("Editar");
    var b = $("#tabla tr").length;
    var c = $("#tabla tr:last td").length;
    for (var i = 0; i < b - 1; i++) {
        $("#inpNoAcuerdo" + i).prop('readonly', false);
        $("#inpNoFolioIn" + i).prop('readonly', false);
        $("#btnguardarREPSE").prop("disabled", false);
        $("#btneditarREPSE").prop("disabled", true);
        $("#btnagregarREPSE").prop('disabled', true);
    }
}

function guardarREPSE() {
    $("#divMSGRepse").html("");
    var inpaccionRepse = $("#inpaccionRepse").val();
    var idRepse= '0';
    if (inpaccionRepse === "Agregar") {
        var b = $("#tabla tr").length;
        var c = $("#tabla tr:last td").length;
        
        for(var i = b - 2; i < b - 1; i++) {
            var noAcuerdo = $("#inpNoAcuerdo" + i).val();
            var noFolioIn= $("#inpNoFolioIn" + i).val();
           }
        if (noAcuerdo == "") {
            $(document).scrollTop(0);
            $("#ModalRepse").modal("hide"); 
            $("#procesandoRepse").hide();
            var Msgerror = "<div id='divErrorRepse' class='alert alert-error'><strong>Ingrese el numero de acuerdo</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#divErrorRepse").html(Msgerror);

        } else if (noFolioIn == "") {
            $(document).scrollTop(0);
            $("#ModalRepse").modal("hide"); 
            $("#procesandoRepse").hide();
            var Msgerror = "<div id='divErrorRepse' class='alert alert-error'><strong>Ingrese el numero de folio de ingreso</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#divErrorRepse").html(Msgerror);

        } else {
            $("#divErrorRepse").html("");
            $("#btneditarREPSE").prop("disabled", false);
            $("#btnagregarREPSE").prop('disabled', false);
            $("#btnguardarREPSE").prop("disabled", true);
            
            for (var i = b - 2; i < b - 1; i++) {
                $("#inpNoAcuerdo" + i).prop('readonly', true);
                $("#inpNoFolioIn" + i).prop('readonly', true);
            }
             $("#ModalRepse").modal("show"); 
             $("#procesandoRepse").show();
             $.ajax({
                type: "POST",
                url: 'ajax_InsertUpdateRepse.php',
                data: {noAcuerdo,noFolioIn,idRepse,'accion': 2},
                success: function() {
                $("#divMSGRepse").html("");
                $("#procesandoRepse").hide();
                $("#ModalRepse").modal("hide");
                $("#divMSGRepse").fadeIn();
                traerCatalogoRepse();
                var mensajeAgregar = "Se Agregó Correctamente"
                alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+mensajeAgregar+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#divMSGRepse").html(alertMsg1); 
                $("#divMSGRepse").delay('4000').fadeOut('slow');    
                 
               }
            });
        }

    } else if (inpaccionRepse === "Editar") {
        var noAcuerdo      = Array();
        var noFolioIn      = Array();
        var noAcuerdohidden= Array();
        var noFolioInhidden= Array();
        var idRepse= Array();
        var b = $("#tabla tr").length;
        var c = $("#tabla tr:last td").length;
       
        for (var i = 0; i < b - 1; i++) {
           var nA  = $("#inpNoAcuerdo" + i).val();
           var nAH = $("#inpNoAcuerdoHidden" + i).val();
           var nF  = $("#inpNoFolioIn" + i).val();
           var nFH = $("#inpNoFolioHidden" + i).val();

            if(nA != nAH || nF != nFH){
               noAcuerdo[i]      = $("#inpNoAcuerdo" + i).val();
               noFolioIn[i]      = $("#inpNoFolioIn" + i).val();
               noAcuerdohidden[i]= $("#inpNoAcuerdoHidden" + i).val();
               noFolioInhidden[i]= $("#inpNoFolioHidden" + i).val();
               idRepse[i]        = $("#inpidRepse" + i).val();
             }

            if (noAcuerdo[i] == "") {
                $(document).scrollTop(0);
                var Msgerror = "<div id='divErrorRepse' class='alert alert-error'><strong>Ingrese el numero de acuerdo en la fila :" + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#divErrorRepse").html(Msgerror);
                return 0;
            }

            if (noFolioIn[i] == "") {
                $(document).scrollTop(0);
                var Msgerror = "<div id='divErrorRepse' class='alert alert-error'><strong>Ingrese el numero de folio de ingreso en la fila:" + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#divErrorRepse").html(Msgerror);
                return 0;
            }
        }
    $("#ModalRepse").modal("show"); 
    $("#procesandoRepse").show();
            $.ajax({
            type: "POST",
            url: 'ajax_InsertUpdateRepse.php',
            data: {noAcuerdo,noFolioIn,idRepse,'accion': 1},     
            success: function() {
                $("#divMSGRepse").html("");
                $("#procesandoRepse").hide();
                $("#ModalRepse").modal("hide");
                $("#divMSGRepse").fadeIn();
                traerCatalogoRepse();
                var mensajeEdit = "Se Editó Correctamente"
                alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+mensajeEdit+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#divMSGRepse").html(alertMsg1); 
                $("#divMSGRepse").delay('4000').fadeOut('slow');  
            }
        });
    }
}

function agregarREPSE() {
    $("#divErrorRepse").html("");
    $("#btneditarREPSE").prop("disabled", true);
    var b       = $("#tabla tr").length;
    var table   = document.getElementById("tabla");
    var row     = table.insertRow(b);
    var contfila= row.insertCell(0);
    var cell1   = row.insertCell(1);
    var cell2   = row.insertCell(2);

    for (var i = 0; i < b; i++) {
        contfila.innerHTML = " <td > " + (i + 1) + " </td>";
        cell1.innerHTML = "<input id='inpNoAcuerdo" + i + "' type='text'>";
        cell2.innerHTML = "<input id='inpNoFolioIn" + i + "' type='text' >";;
    }
    $("#btnagregarREPSE").prop('disabled', true);
    $("#inpaccionRepse").val("Agregar");
    $("#btnguardarREPSE").prop('disabled', false);
}