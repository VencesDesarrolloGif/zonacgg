<!DOCTYPE html>
  <html lang="en">
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
     <body>
          <div id='divMSGTipoContrato' name='divMSGTipoContrato' ></div>
           <div class="container" align="center">
            <h1>Catálogo tipos de contratos clientes</h1>
           <div id="divErrorTiposContratos" name="divErrorTiposContratos"></div>
           <div style="margin-top: 2%"></div>
           <div class="container top-buffer-submenu vertical-buffer">
             <div align="center" id="datosContrato"></div>
           </div>
           <input id="inpaccionTipoContrato" type="hidden" value="Editar">
           <div align="center" class="container top-buffer-submenu vertical-buffer">
              <button  id="btneditarContrato"  class="btn btn-warning" onclick="editarContrato()">Editar <span class="glyphicon glyphicon-pencil"></span></button>
              <button  id="btnguardarContrato" disabled='true' class="btn btn-success" onclick="guardarContrato()">Guardar</button>
              <button  id="btnagregarContrato" class="btn btn-default" onclick="agregarContrato()"><span class="glyphicon glyphicon-plus"></span>Agregar</button>
           </div>
           <div tabindex="-1" role="dialog" id="ModalTipoContrato" name="ModalP" aria-labelledby="aaaa1" aria-hidden="true">
             <h1 align="center" id="procesandotipoc" name="procesandotipoc" style="display:none;" >Procesando ....</h1></div>            
           </div>  
     </body>
  </html>

<script type="text/javascript">
$(traerCatalogoContratos());  

function traerCatalogoContratos(){
 $("#divErrorTiposContratos").html("");
 $("#btneditarContrato").prop("disabled", false);
 $("#btnguardarContrato").prop("disabled", true);
 $("#btnagregarContrato").prop('disabled', false);
 $.ajax({
  type: "POST",
  url: "ajax_consultaTipoContratosCliente.php",
  dataType: "json",
  success: function(response) {
   if(response.status == "success") {
       var mensaje= response.message;
       var datos  = response.datos;
       $("#datosContrato").empty();
       var tabla  = "<table id='tabla' class='table table-bordered'><thead> <th>No</th> <th>Descripcion</th></thead><tbody>";
       $(document).scrollTop(0);
       $.each(datos, function(i) {
        tabla += "<tr><td><input class='form-control' id='inpidTipoC" + i + "' type='text' readonly='true' value='" + datos[i].idTipoContrato + "'>    <input id='inpidTipoCHidden" + i + "' type='hidden' value='" + datos[i].idTipoContrato + "'></td>";                        
        tabla += "<td><input class='form-control' id='inpDescContrato" + i + "' type='text' readonly='true' value='" + datos[i].Descripcion + "'>   <input id='inpDescContratoHidden"   + i + "' type='hidden'  value='" + datos[i].Descripcion + "'>    </td>";
       });                
       $("#datosContrato").append(tabla);
       $("#ModalTipoContrato").modal("hide");
       $("#procesandotipoc").hide();
    }else{
          var mensaje = response.message;
         }
 },
 error: function(jqXHR, textStatus, errorThrown) {
     alert(jqXHR.responseText);
      }
 });
}
            
function editarContrato() {
    $("#divErrorTiposContratos").html("");
    $("#inpaccionTipoContrato").val("Editar");
    var b = $("#tabla tr").length;
    var c = $("#tabla tr:last td").length;
    for (var i = 0; i < b - 1; i++) {
        $("#inpDescContrato" + i).prop('readonly', false);
        $("#btnguardarContrato").prop("disabled", false);
        $("#btneditarContrato").prop("disabled", true);
        $("#btnagregarContrato").prop('disabled', true);
    }
}

function guardarContrato() {
    $("#divMSGTipoContrato").html("");
    var inpaccionTipoContrato = $("#inpaccionTipoContrato").val();
    var idContrato= '0';
    if (inpaccionTipoContrato === "Agregar") {
        var b = $("#tabla tr").length;
        var c = $("#tabla tr:last td").length;
        
        for(var i = b - 2; i < b - 1; i++) {
            var descContrato = $("#inpDescContrato" + i).val();
           }
        if (descContrato == "") {
            $(document).scrollTop(0);
            $("#ModalTipoContrato").modal("hide"); 
            $("#procesandotipoc").hide();
            var Msgerror = "<div id='divErrorTiposContratos' class='alert alert-error'><strong>Ingrese la Descripcion del contrato</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#divErrorTiposContratos").html(Msgerror);

        } else {
            $("#divErrorTiposContratos").html("");
            $("#btneditarContrato").prop("disabled", false);
            $("#btnagregarContrato").prop('disabled', false);
            $("#btnguardarContrato").prop("disabled", true);
            
            for (var i = b - 2; i < b - 1; i++) {
                $("#inpDescContrato" + i).prop('readonly', true);
            }
             $("#ModalTipoContrato").modal("show"); 
             $("#procesandotipoc").show();
             $.ajax({
                type: "POST",
                url: 'ajax_insertUpdateTipoContratosCliente.php',
                data: {descContrato,idContrato,'accion': 2},
                success: function() {
                $("#divMSGTipoContrato").html("");
                $("#procesandotipoc").hide();
                $("#ModalTipoContrato").modal("hide");
                $("#divMSGTipoContrato").fadeIn();
                traerCatalogoContratos();
                var mensajeAgregar = "Se Agregó Correctamente"
                alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+mensajeAgregar+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#divMSGTipoContrato").html(alertMsg1); 
                $("#divMSGTipoContrato").delay('4000').fadeOut('slow');    
                 
               }
            });
        }

    } else if (inpaccionTipoContrato === "Editar") {
        var descContrato      = Array();
        var descContratohidden= Array();
        var idContrato= Array();
        var b = $("#tabla tr").length;
        var c = $("#tabla tr:last td").length;
       
        for (var i = 0; i < b - 1; i++) {
           var descContratoinp  = $("#inpDescContrato" + i).val();
           var descContratohidden = $("#inpDescContratoHidden" + i).val();

            if(descContratoinp != descContratohidden){
               descContrato[i]      = $("#inpDescContrato" + i).val();
               descContratohidden[i]= $("#inpDescContratoHidden" + i).val();
               idContrato[i]        = $("#inpidTipoC" + i).val();
               //console.log(descContrato);
             }

            if (descContrato[i] == "") {
                $(document).scrollTop(0);
                var Msgerror = "<div id='divErrorTiposContratos' class='alert alert-error'><strong>Ingrese la descripción del contrato en la fila :" + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#divErrorTiposContratos").html(Msgerror);
                return 0;
            }
        }
    $("#ModalTipoContrato").modal("show"); 
    $("#procesandotipoc").show();
            $.ajax({
            type: "POST",
            url: 'ajax_insertUpdateTipoContratosCliente.php',
            data: {descContrato,idContrato,'accion': 1},     
            success: function() {
                $("#divMSGTipoContrato").html("");
                $("#procesandotipoc").hide();
                $("#ModalTipoContrato").modal("hide");
                $("#divMSGTipoContrato").fadeIn();
                traerCatalogoContratos();
                var mensajeEdit = "Se Editó Correctamente"
                alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+mensajeEdit+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#divMSGTipoContrato").html(alertMsg1); 
                $("#divMSGTipoContrato").delay('4000').fadeOut('slow');  
            }
        });
    }
}

function agregarContrato() {
    $("#divErrorTiposContratos").html("");
    $("#btneditarContrato").prop("disabled", true);
    var b       = $("#tabla tr").length;
    var table   = document.getElementById("tabla");
    var row     = table.insertRow(b);
    var contfila= row.insertCell(0);
    var cell1   = row.insertCell(1);
    var cell2   = row.insertCell(2);

    for (var i = 0; i < b; i++) {
        contfila.innerHTML = " <td > " + (i + 1) + " </td>";
        cell1.innerHTML = "<input id='inpDescContrato" + i + "' type='text'>";
    }
    $("#btnagregarContrato").prop('disabled', true);
    $("#inpaccionTipoContrato").val("Agregar");
    $("#btnguardarContrato").prop('disabled', false);
}

</script>