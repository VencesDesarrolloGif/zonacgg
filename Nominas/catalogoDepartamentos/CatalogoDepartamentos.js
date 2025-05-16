$(document).ready(function() {
    cargarLineasNegocio();   
});

function cargarLineasNegocio(){
    $.ajax({
     type: "POST",
     url: "ajax_ConsultaLineasNegocio.php",
     dataType: "json",
     success: function(response){
     if(response.status == "success"){
        $("#selLineaNegocioDep").empty(); 
        $('#selLineaNegocioDep').append('<option value="0">LINEA DE NEGOCIO</option>');
        for(var i = 0; i < response.datos.length; i++){
            $('#selLineaNegocioDep').append('<option value="' + (response.datos[i].idLineaNegocio) + '">' + response.datos[i].descripcionLineaNegocio + '</option>');
        }
    }else{
          alert("Error Al Cargar Las Entidades");
         }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
         }
    });
}

$('#selCategoriaEmpleadosDep').change(function(){
  var categoria=$("#selCategoriaEmpleadosDep").val();
  $("#selLineaNegocioDep").empty();
  $('#selLineaNegocioDep').append('<option value="0">LINEA DE NEGOCIO</option>');
  $("#btneditarDepartamento").hide();
  $("#btnguardarDepartamento").hide();
  $("#btnagregarDepartamento").hide();
  $("#datosDepartamento").hide();


  if(categoria!='0'){
     cargarLineasNegocio();
  }
});

$('#selLineaNegocioDep').change(function(){
  var lineaNegocio=$("#selLineaNegocioDep").val();
  var categoria=$("#selCategoriaEmpleadosDep").val();

  if(lineaNegocio!='0'){
     $("#btneditarDepartamento").show();
     $("#btnguardarDepartamento").show();
     $("#btnagregarDepartamento").show();
     traerCatalogoDepartamentosS(lineaNegocio,categoria);
  }else{
     $("#btneditarDepartamento").hide();
     $("#btnguardarDepartamento").hide();
     $("#btnagregarDepartamento").hide();
     $("#datosDepartamento").hide();
  }
});

function traerCatalogoDepartamentosS(lineaNegocio,categoria) {

 $("#divErrorDepartamento").html("");
 $("#btneditarDepartamento").prop("disabled", false);
 $("#btnguardarDepartamento").prop("disabled", true);
 $("#btnagregarDepartamento").prop('disabled', false);

 $.ajax({
  type: "POST",
  url: "ajax_ConsultaDepartamentos.php",
  data:{"categoria":categoria,"lineaNegocio":lineaNegocio},
  dataType: "json",
  success: function(response) {
   if(response.status == "success") {
       var mensaje= response.message;
       var datos  = response.datos;
       $("#datosDepartamento").empty();
       var tabla  = "<table id='tabla' class='table table-bordered'><thead><th>ID</th><th>Departamento</th></thead><tbody>";
       $(document).scrollTop(0);
       $.each(datos, function(i) {
        tabla += "<tr><td><input class='form-control' id='inpidDepartamento" + i + "' type='text' readonly='true' value='" + datos[i].idDepartamentoOrg + "'> <input id='inpidDepartamentoHidden" + i + "' type='hidden' value='" + datos[i].idDepartamentoOrg + "'></td>";                        
        tabla += "<td><input  id='inpDescripcion" + i + "' type='text' readonly='true' value='" + datos[i].descripcionDepartamento + "' class='soloLetras'>  <input id='inpDescripcionHidden"   + i + "' type='hidden'  value='" + datos[i].descripcionDepartamento + "'></td>";                 
       });  
       
       $("#datosDepartamento").append(tabla);
       jQuery('.soloLetras').keypress(function (tecla) {
            if ((tecla.charCode < 65 || tecla.charCode > 90) && tecla.charCode != 32){return false;} 
        });
       $("#datosDepartamento").show();
       $("#ModalDepartamento").modal("hide");
       $("#procesandoDepartamento").hide();
    }else{
          var mensaje = response.message;
         }
 },
 error: function(jqXHR, textStatus, errorThrown) {
     alert(jqXHR.responseText);
      }
 });

  
}

function agregarDepartamento() {
    $("#divErrorDepartamento").html("");
    $("#btneditarDepartamento").prop("disabled", true);
    var b       = $("#tabla tr").length;
    var table   = document.getElementById("tabla");
    var row     = table.insertRow(b);
    var contfila= row.insertCell(0);
    var cell1   = row.insertCell(1);

    for (var i = 0; i < b; i++) {
        cell1.innerHTML = "<input id='inpDescripcion" + i + "' type='text' placeholder='SOLO MAYUSCULAS' class='soloLetras'>";
    }
    
    jQuery('.soloLetras').keypress(function (tecla) {
        if ((tecla.charCode < 65 || tecla.charCode > 90) && tecla.charCode != 32) return false;
        // if (tecla.charCode != 32) return false;
    });

    $("#btnagregarDepartamento").prop('disabled', true);
    $("#inpaccionDepartamento").val("Agregar");
    $("#btnguardarDepartamento").prop('disabled', false);
}

function guardarDepartamento() {
    $("#divMSGDepartamento").html("");
    var inpaccionDepartamento = $("#inpaccionDepartamento").val();
    var idDepartamento= '0';
    var lineaNegocio=$("#selLineaNegocioDep").val();
    var categoria=$("#selCategoriaEmpleadosDep").val();

    if (inpaccionDepartamento === "Agregar") {
        var b = $("#tabla tr").length;
        var c = $("#tabla tr:last td").length;
        
        for(var i = b - 2; i < b - 1; i++) {
            var descripcionOriginal= $("#inpDescripcion" + i).val();
           }
        
        if (descripcionOriginal == "") {
            $(document).scrollTop(0);
            $("#ModalDepartamento").modal("hide"); 
            $("#procesandoDepartamento").hide();
            var Msgerror = "<div id='divErrorDepartamento' class='alert alert-error'><strong>Ingrese el nombre del Departamento</strong>" + "<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#divErrorDepartamento").html(Msgerror);
        }else{
              $("#divErrorDepartamento").html("");
              $("#btneditarDepartamento").prop("disabled", false);
              $("#btnagregarDepartamento").prop('disabled', false);
              $("#btnguardarDepartamento").prop("disabled", true);
            
            for (var i = b - 2; i < b - 1; i++) {
                $("#inpDescripcion" + i).prop('readonly', true);
            }

             $("#ModalDepartamento").modal("show"); 
             $("#procesandoDepartamento").show();
             var descripcion=descripcionOriginal.trim();
             $.ajax({
                type: "POST",
                url: 'ajax_InsertUpdateDepartamento.php',
                data: {descripcion,idDepartamento,'accion': 2,lineaNegocio,categoria},//insert
                success: function() {
                    $("#divMSGDepartamento").html("");
                    $("#procesandoDepartamento").hide();
                    $("#ModalDepartamento").modal("hide");
                    $("#divMSGDepartamento").fadeIn();
                    traerCatalogoDepartamentosS(lineaNegocio,categoria);
                    var mensajeAgregar = "Se Agregó Correctamente"
                    alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+mensajeAgregar+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#divMSGDepartamento").html(alertMsg1); 
                    $("#divMSGDepartamento").delay('4000').fadeOut('slow');    
               }
            });
        }

    }else if (inpaccionDepartamento === "Editar") {
        var descripcion      = Array();
        var descripcionhidden= Array();
        var idDepartamento= Array();
        var b = $("#tabla tr").length;
        var c = $("#tabla tr:last td").length;
       
        for (var i = 0; i < b - 1; i++) {
           var des  = $("#inpDescripcion" + i).val();
           var desH = $("#inpDescripcionHidden" + i).val();

            if(des != desH){
               var descripcionOriginal = $("#inpDescripcion" + i).val();
               descripcion[i]      = descripcionOriginal.trim();
               descripcionhidden[i]= $("#inpDescripcionHidden" + i).val();
               idDepartamento[i]   = $("#inpidDepartamento" + i).val();
             }

            if (descripcion[i] == "") {
                $(document).scrollTop(0);
                var Msgerror = "<div id='divErrorDepartamento' class='alert alert-error'><strong>Ingrese el nombre del Departamento</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#divErrorDepartamento").html(Msgerror);
                return 0;
            }
        }
            $("#ModalDepartamento").modal("show"); 
            $("#procesandoDepartamento").show();

            $.ajax({
            type: "POST",
            url: 'ajax_InsertUpdateDepartamento.php',
            data: {descripcion,idDepartamento,'accion': 1},//insert     
            success: function() {
                $("#divMSGDepartamento").html("");
                $("#procesandoDepartamento").hide();
                $("#ModalDepartamento").modal("hide");
                $("#divMSGDepartamento").fadeIn();
                traerCatalogoDepartamentosS(lineaNegocio,categoria);
                var mensajeEdit = "Se Editó Correctamente"
                alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+mensajeEdit+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#divMSGDepartamento").html(alertMsg1); 
                $("#divMSGDepartamento").delay('4000').fadeOut('slow');  
            }
        });
    }
}

function editarDepartamento() {
    $("#divErrorDepartamento").html("");
    $("#inpaccionDepartamento").val("Editar");
    var b = $("#tabla tr").length;
    var c = $("#tabla tr:last td").length;
    for (var i = 0; i < b - 1; i++) {
        // $("#inpidDepartamento" + i).prop('readonly', false);
        $("#inpDescripcion" + i).prop('readonly', false);
        $("#btneditarDepartamento").prop("disabled", true);
        $("#btnguardarDepartamento").prop("disabled", false);
        $("#btnagregarDepartamento").prop('disabled', true);
    }
}