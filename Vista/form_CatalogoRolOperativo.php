<!DOCTYPE html>
  <html lang="en">
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
     <body>
          <div id='divMsgRolOp' name='divMsgRolOp'  align="center"></div>
           <div id="divErrorRolOp" name="divErrorRolOp" align="center"></div>
           <div class="container" align="center">
            <h1>Catálogo Roles Operativos</h1><br>
           <div class="input-prepend">
            <select id="selectTioTurno" name="selectTioTurno" onchange="CargarRolesOperativos();" class="input-medium "></select>
            <input type="hidden" name="bandera" id="bandera">
            <input type="hidden" name="bandera1" id="bandera1">
          </div>
           <div style="margin-top: 2%"></div>
           <div class="container top-buffer-submenu vertical-buffer">
             <div align="center" id="DotosRolOp"></div>
           </div>
           <input id="inpaccionRolOp" type="hidden" value="Editar">
           <div align="center" class="container top-buffer-submenu vertical-buffer">
              <button  id="btnguardarRolOp" disabled='true' class="btn btn-success" onclick="guardarRolop()">Guardar</button>
              <button  id="btnagregarRolOp" class="btn btn-default" onclick="agregarRolOp()"><span class="glyphicon glyphicon-plus"></span>Agregar</button>
           </div>
           <div tabindex="-1" role="dialog" id="ModalRolOp" name="ModalP" aria-labelledby="aaaa1" aria-hidden="true">
             <h1 align="center" id="procesandoRolOp" name="procesandoRolOp" style="display:none;" >Procesando ....</h1></div>            
           </div>  
     </body>
  </html>

<script type="text/javascript">
$(traerCatalogoTipoTurnos());  

function  traerCatalogoTipoTurnos() {
    $.ajax({
        type: "POST",
        url: "ajax_TraerCatalogoTipoTurnos.php",
        dataType: "json",
        success: function(response) {
            if (response.status == "success")
            {
                var datos = response.datos;
                TipoTurnosOptions = "<option value=0>TIPO TURNO</option>";
                for (var i = 0; i < datos.length; i++)
                {
                    TipoTurnosOptions += "<option value='" + datos[i].idTipoTurno + "'>" + datos[i].descripcionTurno + "</option>";
                }
                $("#selectTioTurno").html (TipoTurnosOptions);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
          }
    });
}

function CargarRolesOperativos(){
 $("#divErrorRolOp").html("");
 $("#btnguardarRolOp").prop("disabled", true);
 $("#btnagregarRolOp").prop('disabled', false);
 var TipoTurno = $("#selectTioTurno").val();
 $.ajax({
  type: "POST",
  url: "ajax_consultaRolesOperativos.php",
  data: {"TipoTurno": TipoTurno},
  dataType: "json",
  success: function(response) {
   if(response.status == "success") { 
       var mensaje= response.message;
       var datos  = response.datos;
       $("#DotosRolOp").empty();
       var tablaRol  = "<table id='tablaRol' class='table table-bordered'><thead><th>Rol Operativo</th></thead><tbody>";
       $(document).scrollTop(0);
       $.each(datos, function(i) {                       
        tablaRol += "<tr><td><input class='form-control' id='inpDesRolOp" + i + "' type='text' style='text-transform:uppercase;' maxlength='20' minlength='7' readonly='true' value='" + datos[i].DescripcioRolOP + "'>   <input id='inpDesRolOpHidden"   + i + "' type='hidden'  value='" + datos[i].DescripcioRolOP + "'>    </td></tr>";
       });                
       $("#DotosRolOp").append(tablaRol);
       $("#ModalRolOp").modal("hide");
       $("#procesandoRolOp").hide();
    }else{
          var mensaje = response.message;
         }
 },
 error: function(jqXHR, textStatus, errorThrown) {
     alert(jqXHR.responseText);
      }
 });
}
            
function guardarRolop() {
    $("#divMsgRolOp").html("");
    var b = $("#tablaRol tr").length;
    var c = $("#tablaRol tr:last td").length;
    var idTipoT = $("#selectTioTurno").val();
    $("#bandera").val(0);
        for(var i = b - 2; i < b - 1; i++) {
            var descContrato = $("#inpDesRolOp" + i).val();
           } 
        if (descContrato == "") {
            $('#divErrorRolOp').fadeIn();
            $("#ModalRolOp").modal("hide"); 
            $("#procesandoRolOp").hide();
            var Msgerror = "<div id='divErrorRolOp' class='alert alert-error'><strong>Ingrese la Descripcion del contrato</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#divErrorRolOp").html(Msgerror);
            $(document).scrollTop(0);
            $('#divErrorRolOp').delay(3000).fadeOut('slow');

        }else if (idTipoT !="4" && idTipoT !="5" && descContrato.length != "7") {
            $('#divErrorRolOp').fadeIn();
            $("#ModalRolOp").modal("hide"); 
            $("#procesandoRolOp").hide();
            var Msgerror = "<div id='divErrorRolOp' class='alert alert-error'><strong>Ingrese la estructura correcta para un rol operativo</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#divErrorRolOp").html(Msgerror);
            $(document).scrollTop(0);
            $('#divErrorRolOp').delay(3000).fadeOut('slow');

        } else {
            for (var i = 0; i < b-2; i++) {
                var a=$("#inpDesRolOp" + i).val();
                if(a==descContrato){
                    $('#divErrorRolOp').fadeIn();
                    $(document).scrollTop(0);
                    $("#ModalRolOp").modal("hide"); 
                    $("#procesandoRolOp").hide();
                    var Msgerror = "<div id='divErrorRolOp' class='alert alert-error'><strong>El Rol Operativo ingresado ya existe</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#divErrorRolOp").html(Msgerror);
                    $(document).scrollTop(0);
                    $('#divErrorRolOp').delay(3000).fadeOut('slow');
                    i=b-2;
                    $("#bandera").val(1);
                }else{
                    $("#inpDesRolOp" + i).prop('readonly', true);
                }
            }
            var bandera = $("#bandera").val();
        if(bandera=="0"){
            $("#divErrorRolOp").html("");
            $("#btnagregarRolOp").prop('disabled', false);
            $("#btnguardarRolOp").prop("disabled", true);
             $("#ModalRolOp").modal("show"); 
             $("#procesandoRolOp").show();
             $.ajax({
                type: "POST",
                url: 'ajax_InsertRolOperativo.php',
                data: {"idTipoT":idTipoT,"descContrato":descContrato},
                success: function() {
                $("#divMsgRolOp").html("");
                $("#procesandoRolOp").hide();
                $("#ModalRolOp").modal("hide");
                $("#divMsgRolOp").fadeIn();
                CargarRolesOperativos();
                var mensajeAgregar = "Se Agregó Correctamente"
                alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+mensajeAgregar+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#divMsgRolOp").html(alertMsg1); 
                $("#divMsgRolOp").delay('4000').fadeOut('slow');    
                 
               }
            });
        }
    }
}
function agregarRolOp() {
    var opcionTurno=$("#selectTioTurno").val();
    if(opcionTurno=="0"){
        $('#divErrorRolOp').fadeIn();
        var Msgerror = "<div id='divErrorRolOp' class='alert alert-error'><strong>Seleccione Un Tipo De Turno</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
        $("#divErrorRolOp").html(Msgerror);
        $(document).scrollTop(0);
        $('#divErrorRolOp').delay(3000).fadeOut('slow');
    }else{
        $("#divErrorRolOp").html("");
        var turno=document.getElementById("selectTioTurno").options[opcionTurno].text;
        var b       = $("#tablaRol tr").length;
        var table   = document.getElementById("tablaRol");
        var row     = table.insertRow(b);
        var cell1   = row.insertCell(0);
        for (var i = 0; i < b; i++) {
            cell1.innerHTML = "<input id='inpDesRolOp" + i + "' type='text' style='text-transform:uppercase;' maxlength='20' minlength='7'>";
        }
        $("#inpDesRolOp"+(b-1)).val(turno+"X");
        $("#btnagregarRolOp").prop('disabled', true);
        $("#inpaccionRolOp").val("Agregar");
        $("#btnguardarRolOp").prop('disabled', false);
    }
}

</script>