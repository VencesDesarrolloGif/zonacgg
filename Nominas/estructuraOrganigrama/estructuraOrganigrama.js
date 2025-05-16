$(document).ready(function() {
  cargarLineasNegociocatalogoDepa();   
  traerCatalogoDependencias();
});

function cargarLineasNegociocatalogoDepa(){
    $.ajax({
     type: "POST",
     url: "ajax_ConsultaLineasNegocio.php",
     dataType: "json",
     success: function(response){
     if(response.status == "success"){
        $("#selLineaNegocioCatDep").empty(); 
        $('#selLineaNegocioCatDep').append('<option value="0">LINEA DE NEGOCIO</option>');
        for(var i = 0; i < response.datos.length; i++){
            $('#selLineaNegocioCatDep').append('<option value="' + (response.datos[i].idLineaNegocio) + '">' + response.datos[i].descripcionLineaNegocio + '</option>');
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

$('#selCategoriaEmpleadosCatDep').change(function(){
  var categoria=$("#selCategoriaEmpleadosCatDep").val();
  $("#selLineaNegocioCatDep").empty();
  $('#selLineaNegocioCatDep').append('<option value="0">LINEA DE NEGOCIO</option>');
  $("#btneditarCatDepartamento").hide();
  $("#btnguardarCatDepartamento").hide();
  $("#btnagregarCatDepartamento").hide();
  $("#datosDepartamento").hide();


  if(categoria!='0'){
     cargarLineasNegociocatalogoDepa();
  }
});

$('#selLineaNegocioCatDep').change(function(){
  var lineaNegocio=$("#selLineaNegocioCatDep").val();
  var categoria=$("#selCategoriaEmpleadosCatDep").val();

  if(lineaNegocio!='0'){
     $("#btneditarCatDepartamento").show();
     $("#btnguardarCatDepartamento").show();
     $("#btnagregarCatDepartamento").show();
     traerCatalogoDepartamentosS(lineaNegocio,categoria);
  }else{
     $("#btneditarCatDepartamento").hide();
     $("#btnguardarCatDepartamento").hide();
     $("#btnagregarCatDepartamento").hide();
     $("#datosDepartamento").hide();
  }
});

function traerCatalogoDepartamentosS(lineaNegocio,categoria) {

 $("#divErrorOrganigrama").html("");
 $("#btneditarCatDepartamento").prop("disabled", false);
 $("#btnguardarCatDepartamento").prop("disabled", true);
 $("#btnagregarCatDepartamento").prop('disabled', false);

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
       var tablaDepa  = "<table id='tablaDepa' class='table table-bordered'><thead><th>ID</th><th>Departamento</th></thead><tbody>";
       // $(document).scrollTop(0);
       $.each(datos, function(i) {
        tablaDepa += "<tr><td><input class='form-control' id='inpidDepartamento" + i + "' type='text' readonly='true' value='" + datos[i].idDepartamentoOrg + "'> <input id='inpidDepartamentoHidden" + i + "' type='hidden' value='" + datos[i].idDepartamentoOrg + "'></td>";                        
        tablaDepa += "<td><input  id='inpDescripcion" + i + "' type='text' readonly='true' value='" + datos[i].descripcionDepartamento + "' class='soloLetras'>  <input id='inpDescripcionHidden"   + i + "' type='hidden'  value='" + datos[i].descripcionDepartamento + "'></td>";                 
       });  
       
       $("#datosDepartamento").append(tablaDepa);
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

function agregarCatDepartamento() {
    $("#divErrorOrganigrama").html("");
    $("#btneditarCatDepartamento").prop("disabled", true);
    var b       = $("#tablaDepa tr").length;
    var table   = document.getElementById("tablaDepa");
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

    $("#btnagregarCatDepartamento").prop('disabled', true);
    $("#inpaccionCatDepartamento").val("Agregar");
    $("#btnguardarCatDepartamento").prop('disabled', false);
}

function guardarCatDepartamento() {
    $("#divMSGOrganigrama").html("");
    var inpaccionCatDepartamento = $("#inpaccionCatDepartamento").val();
    var idDepartamento= '0';
    var lineaNegocio=$("#selLineaNegocioCatDep").val();
    var categoria=$("#selCategoriaEmpleadosCatDep").val();

    if (inpaccionCatDepartamento === "Agregar") {
        var b = $("#tablaDepa tr").length;
        var c = $("#tablaDepa tr:last td").length;
        
        for(var i = b - 2; i < b - 1; i++) {
            var descripcionOriginal= $("#inpDescripcion" + i).val();
           }
        
        if (descripcionOriginal == "") {
            $(document).scrollTop(0);
            $("#ModalDepartamento").modal("hide"); 
            $("#procesandoDepartamento").hide();
            var Msgerror = "<div id='divErrorOrganigrama' class='alert alert-error'><strong>Ingrese el nombre del Departamento</strong>" + "<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#divErrorOrganigrama").html(Msgerror);
        }else{
              $("#divErrorOrganigrama").html("");
              $("#btneditarCatDepartamento").prop("disabled", false);
              $("#btnagregarCatDepartamento").prop('disabled', false);
              $("#btnguardarCatDepartamento").prop("disabled", true);
            
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
                    $("#divMSGOrganigrama").html("");
                    $("#procesandoDepartamento").hide();
                    $("#ModalDepartamento").modal("hide");
                    $("#divMSGOrganigrama").fadeIn();
                    traerCatalogoDepartamentosS(lineaNegocio,categoria);
                    var mensajeAgregar = "Se Agregó Correctamente"
                    alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+mensajeAgregar+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#divMSGOrganigrama").html(alertMsg1); 
                    $("#divMSGOrganigrama").delay('4000').fadeOut('slow');    
               }
            });
        }

    }else if (inpaccionCatDepartamento === "Editar") {
        var descripcion      = Array();
        var descripcionhidden= Array();
        var idDepartamento= Array();
        var b = $("#tablaDepa tr").length;
        var c = $("#tablaDepa tr:last td").length;
       
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
                var Msgerror = "<div id='divErrorOrganigrama' class='alert alert-error'><strong>Ingrese el nombre del Departamento</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#divErrorOrganigrama").html(Msgerror);
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
                $("#divMSGOrganigrama").html("");
                $("#procesandoDepartamento").hide();
                $("#ModalDepartamento").modal("hide");
                $("#divMSGOrganigrama").fadeIn();
                traerCatalogoDepartamentosS(lineaNegocio,categoria);
                var mensajeEdit = "Se Editó Correctamente"
                alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+mensajeEdit+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#divMSGOrganigrama").html(alertMsg1); 
                $("#divMSGOrganigrama").delay('4000').fadeOut('slow');  
            }
        });
    }
}

function editarCatDepartamento() {
    $("#divErrorOrganigrama").html("");
    $("#inpaccionCatDepartamento").val("Editar");
    var b = $("#tablaDepa tr").length;
    var c = $("#tablaDepa tr:last td").length;
    for (var i = 0; i < b - 1; i++) {
        // $("#inpidDepartamento" + i).prop('readonly', false);
        $("#inpDescripcion" + i).prop('readonly', false);
        $("#btneditarCatDepartamento").prop("disabled", true);
        $("#btnguardarCatDepartamento").prop("disabled", false);
        $("#btnagregarCatDepartamento").prop('disabled', true);
    }
}

//////////////////////TERMINA CATALOGO DEPARTAMENTOS///////////////////////////////////////////////////////////////////////////////////////


//////////////////////INICIA CATALOGO DEPENDENCIAS///////////////////////////////////////////////////////////////////////////////////////

function traerCatalogoDependencias() {
 $("#divErrorOrganigrama").html("");
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
       // $(document).scrollTop(0);
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
    $("#divErrorOrganigrama").html("");
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
    $("#divMSGOrganigrama").html("");
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
            var Msgerror = "<div id='divErrorOrganigrama' class='alert alert-error'><strong>Ingrese el nombre del Dependencia</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#divErrorOrganigrama").html(Msgerror);

        } else {
            $("#divErrorOrganigrama").html("");
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
                    $("#divMSGOrganigrama").html("");
                    $("#procesandoDependencia").hide();
                    $("#ModalDependencia").modal("hide");
                    $("#divMSGOrganigrama").fadeIn();
                    traerCatalogoDependencias();
                    var mensajeAgregar = "Se Agregó Correctamente"
                    alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+mensajeAgregar+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#divMSGOrganigrama").html(alertMsg1); 
                    $("#divMSGOrganigrama").delay('4000').fadeOut('slow');    
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
                var Msgerror = "<div id='divErrorOrganigrama' class='alert alert-error'><strong>Ingrese el nombre del Dependencia</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#divErrorOrganigrama").html(Msgerror);
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
                $("#divMSGOrganigrama").html("");
                $("#procesandoDependencia").hide();
                $("#ModalDependencia").modal("hide");
                $("#divMSGOrganigrama").fadeIn();
                traerCatalogoDependencias();
                var mensajeEdit = "Se Editó Correctamente"
                alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+mensajeEdit+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#divMSGOrganigrama").html(alertMsg1); 
                $("#divMSGOrganigrama").delay('4000').fadeOut('slow');  
            }
        });
    }
}

function agregarDependencia() {
    $("#divErrorOrganigrama").html("");
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

//////////////////////TERMINA CATALOGO DEPENDENCIAS///////////////////////////////////////////////////////////////////////////////////////

//////////////////////INICIA RELACION PUESTOS DEPARTAMENTOS ///////////////////////////////////////////////////////////////////////////////////////


$('#selCategoriaEmpleadosDepa').change(function(){

  var categoria=$("#selCategoriaEmpleadosDepa").val();
  $("#selLineaNegocioDepa").empty();
  $('#selLineaNegocioDepa').append('<option value="0">LINEA DE NEGOCIO</option>');
  $("#selDepartamento").empty();
  $('#selDepartamento').append('<option value="0">DEPARTAMENTO</option>');
  $("#divDatosPuestosAsignados").empty();
  $("#divDatosPuestosAsignados").hide();
  $("#divDatosPuestosSinAsignar").empty();
  $("#divDatosPuestosSinAsignar").hide();
  if(categoria!='0'){
     cargarLineasNegocioDepa();
  }
});

function cargarLineasNegocioDepa(){
    $.ajax({
     type: "POST",
     url: "ajax_ConsultaLineasNegocio.php",
     dataType: "json",
     success: function(response){
     if(response.status == "success"){
        $("#selLineaNegocioDepa").empty(); 
        $('#selLineaNegocioDepa').append('<option value="0">LINEA DE NEGOCIO</option>');
        for(var i = 0; i < response.datos.length; i++){
            $('#selLineaNegocioDepa').append('<option value="' + (response.datos[i].idLineaNegocio) + '">' + response.datos[i].descripcionLineaNegocio + '</option>');
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

$('#selLineaNegocioDepa').change(function(){
  var lineaNegocio=$("#selLineaNegocioDepa").val();
  $("#selDepartamento").empty();
  $('#selDepartamento').append('<option value="0">DEPARTAMENTO</option>');
  $("#divDatosPuestosAsignados").empty();
  $("#divDatosPuestosAsignados").hide();
  $("#divDatosPuestosSinAsignar").empty();
  $("#divDatosPuestosSinAsignar").hide();

  if(lineaNegocio!='0'){
        cargarDepartamento();
  }
});

function cargarDepartamento(){
    
    var categoria=$("#selCategoriaEmpleadosDepa").val();
    var lineaNegocio=$("#selLineaNegocioDepa").val();
    $.ajax({
     type: "POST",
     url: "ajax_ConsultaDepartamento.php",
     data:{categoria,lineaNegocio},
     dataType: "json",
     success: function(response){
     if(response.status == "success"){
        $("#selDepartamento").empty(); 
        $('#selDepartamento').append('<option value="0">DEPARTAMENTO</option>');
        for(var i = 0; i < response.datos.length; i++){
            $('#selDepartamento').append('<option value="' + (response.datos[i].idDepartamentoOrg) + '">' + response.datos[i].descripcionDepartamento + '</option>');
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

$('#selDepartamento').change(function(){
  var departamento=$("#selDepartamento").val();
  
  if(departamento=='0'){
    $("#divDatosPuestosAsignados").empty();
    $("#divDatosPuestosAsignados").hide();
    $("#divDatosPuestosSinAsignar").empty();
    $("#divDatosPuestosSinAsignar").hide();
  }else{
        cargarPuestosSinAsignar();
        cargarPuestosAsignados(departamento);
  }
});

function cargarPuestosAsignados(departamento){
    $("#divDatosPuestosAsignados").empty();
    $("#divDatosPuestosAsignados").hide();
    var categoria=$("#selCategoriaEmpleadosDepa").val();
    var lineaNegocio=$("#selLineaNegocioDepa").val();
    $.ajax({    
       type: "POST",
       url: "ajax_ConsultaPuestosAsignadosAdepartamento.php",
       data:{"categoria":categoria,"lineaNegocio":lineaNegocio,"departamento":departamento},
       dataType: "json",
       success: function(response){
            var tblPuestosSinAsignar = "<table id='tblPuestosSinAsignar' class='table table-bordered'><thead><th>Puestos Asignados</th><th>Eliminar</th></thead><tbody>";
            for(var i = 0; i < response.datos.length; i++){
                tblPuestosSinAsignar+= "<tr>";
                tblPuestosSinAsignar+= "<td>"+response.datos[i].descripcionPuesto+"</td>";   
                tblPuestosSinAsignar+= "<td><img src='../img/eliminar.png' title='AGREGAR PUESTO' style='width:27%;cursor:pointer; te' onclick='eliminarPuesto(\"" +response.datos[i].idRelacion+"\")'/></td></tr>"
            }  
            $("#divDatosPuestosAsignados").show();
            $("#divDatosPuestosAsignados").append(tblPuestosSinAsignar);
       },
       error : function (jqXHR, textStatus, errorThrown){
         alert(jqXHR.responseText);
       }
    });
}

function eliminarPuesto(idRelacion){

    var departamento=$("#selDepartamento").val();

    $.ajax({    
       type: "POST",
       url: "ajax_eliminarPuestodeDepartamento.php",
       data:{"idRelacion":idRelacion},
       dataType: "json",
       success: function(response){
            cargarPuestosAsignados(departamento);
            cargarPuestosSinAsignar();
       },
       error : function (jqXHR, textStatus, errorThrown){
         alert(jqXHR.responseText);
       }
    });
}

function cargarPuestosSinAsignar(){
    $("#divDatosPuestosSinAsignar").empty();
    $("#divDatosPuestosSinAsignar").hide();
    var categoria=$("#selCategoriaEmpleadosDepa").val();
    var lineaNegocio=$("#selLineaNegocioDepa").val();

    $.ajax({    
       type: "POST",
       url: "ajax_ConsultaPuestosSinAsignarADepartamento.php",
       data:{"categoria":categoria,"lineaNegocio":lineaNegocio},
       dataType: "json",
       success: function(response){
            var tblPuestosSinAsignar = "<table id='tblPuestosSinAsignar' class='table table-bordered'><thead><th>Puestos Disponibles</th><th>Agregar</th></thead><tbody>";
            for(var i = 0; i < response.datos.length; i++){
                tblPuestosSinAsignar += "<tr>";
                tblPuestosSinAsignar += "<td>"+response.datos[i].descripcionPuesto+"</td>";   
                tblPuestosSinAsignar += "<td><img src='../img/addMenu.png' title='AGREGAR PUESTO' style='cursor:pointer' onclick='agregarPuesto(\""+response.datos[i].idPuesto+"\")'/></td></tr>"  
            }  
            $("#divDatosPuestosSinAsignar").show();
            $("#divDatosPuestosSinAsignar").append(tblPuestosSinAsignar);
       },
       error : function (jqXHR, textStatus, errorThrown){
         alert(jqXHR.responseText);
       }
    });
}

function agregarPuesto(idPuesto){

    var departamento=$("#selDepartamento").val();

    $.ajax({    
       type: "POST",
       url: "ajax_AgregarPuestoADepartamento.php",
       data:{"idPuesto":idPuesto,"departamento":departamento},
       dataType: "json",
       success: function(response){
            cargarPuestosAsignados(departamento);
            cargarPuestosSinAsignar();
       },
       error : function (jqXHR, textStatus, errorThrown){
         alert(jqXHR.responseText);
       }
    });
}

//////////////////////TERMINA RELACION PUESTOS DEPARTAMENTOS///////////////////////////////////////////////////////////////////////////////////////

//////////////////////INICIA RELACION DEPARTAMENTOS DEPENDENCIAS///////////////////////////////////////////////////////////////////////////////////

$('#selCategoriaEmpleados').change(function(){

  var categoria=$("#selCategoriaEmpleados").val();
  $("#selLineaNegocio").empty();
  $('#selLineaNegocio').append('<option value="0">LINEA DE NEGOCIO</option>');
  $("#selNivel").empty();
  $('#selNivel').append('<option value="0">NIVEL</option>');
  $("#divDatosDepartamentosAsignados").empty();
  $("#divDatosDepartamentosAsignados").hide();
  $("#divDatosdepartamentosSinAsignar").empty();
  $("#divDatosdepartamentosSinAsignar").hide();
  if(categoria!='0'){
     cargarLineasNegocio();
  }
});

function cargarLineasNegocio(){
    $.ajax({
     type: "POST",
     url: "ajax_ConsultaLineasNegocio.php",
     dataType: "json",
     success: function(response){
     if(response.status == "success"){
        $("#selLineaNegocio").empty(); 
        $('#selLineaNegocio').append('<option value="0">LINEA DE NEGOCIO</option>');
        for(var i = 0; i < response.datos.length; i++){
            $('#selLineaNegocio').append('<option value="' + (response.datos[i].idLineaNegocio) + '">' + response.datos[i].descripcionLineaNegocio + '</option>');
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

$('#selLineaNegocio').change(function(){
  var lineaNegocio=$("#selLineaNegocio").val();
  $("#selNivel").empty();
  $('#selNivel').append('<option value="0">NIVEL</option>');
  $("#divDatosDepartamentosAsignados").empty();
  $("#divDatosDepartamentosAsignados").hide();
  $("#divDatosdepartamentosSinAsignar").empty();
  $("#divDatosdepartamentosSinAsignar").hide();

  if(lineaNegocio!='0'){
        cargarNiveles();
  }
});

function cargarNiveles(){
    $.ajax({
     type: "POST",
     url: "ajax_ConsultaNiveles.php",
     dataType: "json",
     success: function(response){
     if(response.status == "success"){
        $("#selNivel").empty(); 
        $('#selNivel').append('<option value="0">NIVEL</option>');
        for(var i = 0; i < response.datos.length; i++){
            // var noNivel=i+1;
            $('#selNivel').append('<option value="' + (response.datos[i].idNivelOrg) + '">' + response.datos[i].idNivelOrg +'-'+ response.datos[i].descripcionNivel + '</option>');
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

$('#selNivel').change(function(){
  var nivel=$("#selNivel").val();
  
  if(nivel=='0'){
    $("#divDatosDepartamentosAsignados").empty();
    $("#divDatosDepartamentosAsignados").hide();
    $("#divDatosdepartamentosSinAsignar").empty();
    $("#divDatosdepartamentosSinAsignar").hide();
  }else{
        cargarDepartamentosAsignados(nivel);
        cargarDepartamentosSinAsignar();
  }
});

function cargarDepartamentosAsignados(nivel){
    $("#divDatosDepartamentosAsignados").empty();
    $("#divDatosDepartamentosAsignados").hide();
    var categoria=$("#selCategoriaEmpleados").val();
    var lineaNegocio=$("#selLineaNegocio").val();
    $.ajax({    
       type: "POST",
       url: "ajax_ConsultaDepartamentosAsignados.php",
       data:{"categoria":categoria,"lineaNegocio":lineaNegocio,"nivel":nivel},
       dataType: "json",
       success: function(response){
            var tbldepartamentosSinAsignar = "<table id='tbldepartamentosSinAsignar' class='table table-bordered'><thead><th>Departamentos Asignados</th><th>Eliminar</th></thead><tbody>";
            for(var i = 0; i < response.datos.length; i++){
                tbldepartamentosSinAsignar+= "<tr>";
                tbldepartamentosSinAsignar+= "<td>"+response.datos[i].descripcionDepartamento+"</td>";   
                tbldepartamentosSinAsignar+= "<td><img src='../img/eliminar.png' title='AGREGAR DEPARTAMENTO' style='width:27%;cursor:pointer; te' onclick='eliminarDepartamento(\"" +response.datos[i].idRelacionDN+"\")'/></td></tr>"
            }  
            $("#divDatosDepartamentosAsignados").show();
            $("#divDatosDepartamentosAsignados").append(tbldepartamentosSinAsignar);
       },
       error : function (jqXHR, textStatus, errorThrown){
         alert(jqXHR.responseText);
       }
    });
}

function eliminarDepartamento(idRelacionDN){
    var nivel=$("#selNivel").val();
    $.ajax({    
       type: "POST",
       url: "ajax_eliminarDepartamento.php",
       data:{"idRelacionDN":idRelacionDN},
       dataType: "json",
       success: function(response){
            cargarDepartamentosAsignados(nivel);
            cargarDepartamentosSinAsignar();
       },
       error : function (jqXHR, textStatus, errorThrown){
         alert(jqXHR.responseText);
       }
    });
}

function cargarDepartamentosSinAsignar(){
    $("#divDatosdepartamentosSinAsignar").empty();
    $("#divDatosdepartamentosSinAsignar").hide();
    var categoria=$("#selCategoriaEmpleados").val();
    var lineaNegocio=$("#selLineaNegocio").val();

    $.ajax({    
       type: "POST",
       url: "ajax_ConsultaDepartamentosSinAsignar.php",
       data:{"categoria":categoria,"lineaNegocio":lineaNegocio},
       dataType: "json",
       success: function(response){
            var tbldepartamentosSinAsignar = "<table id='tbldepartamentosSinAsignar' class='table table-bordered'><thead><th>Departamentos Disponibles</th><th>Agregar</th></thead><tbody>";
            for(var i = 0; i < response.datos.length; i++){
                tbldepartamentosSinAsignar += "<tr>";
                tbldepartamentosSinAsignar += "<td>"+response.datos[i].descripcionDepartamento+"</td>";   
                tbldepartamentosSinAsignar += "<td><img src='../img/addMenu.png' title='AGREGAR PUESTO' style='cursor:pointer' onclick='agregarDepartamento(\""+response.datos[i].idDepartamentoOrg+"\")'/></td></tr>"  
            }  
            $("#divDatosdepartamentosSinAsignar").show();
            $("#divDatosdepartamentosSinAsignar").append(tbldepartamentosSinAsignar);
       },
       error : function (jqXHR, textStatus, errorThrown){
         alert(jqXHR.responseText);
       }
    });
}

function agregarDepartamento(idDepartamentoOrg){

    // var categoria=$("#selCategoriaEmpleados").val();
    // var lineaNegocio=$("#selLineaNegocio").val();
    var nivel=$("#selNivel").val();

    $.ajax({    
       type: "POST",
       url: "ajax_agregarDepartamento.php",
       data:{"idDepartamentoOrg":idDepartamentoOrg,"nivel":nivel},
       dataType: "json",
       success: function(response){
            cargarDepartamentosAsignados(nivel);
            cargarDepartamentosSinAsignar();
       },
       error : function (jqXHR, textStatus, errorThrown){
         alert(jqXHR.responseText);
       }
    });
}


//////////////////////INICIA RELACION SUBDEPENDENCIAS///////////////////////////////////////////////////////////////////////////////////

$('#selCategoriaEmpleadosSubDep').change(function(){

  var categoria=$("#selCategoriaEmpleadosSubDep").val();
  $("#selLineaNegocioSubDep").empty();
  $('#selLineaNegocioSubDep').append('<option value="0">LINEA DE NEGOCIO</option>');
  $("#selNivelSubDep").empty();
  $('#selNivelSubDep').append('<option value="0">NIVEL</option>');
  $("#selDepartamentoSubDep").empty();
  $('#selDepartamentoSubDep').append('<option value="0">DEPARTAMENTO</option>');
  $("#divSubDependenciasAsignados").empty();
  $("#divSubDependenciasAsignados").hide();
  $("#divSubDependenciasSinAsignar").empty();
  $("#divSubDependenciasSinAsignar").hide();
  if(categoria!='0'){
     cargarLineasNegocioSubDependencias();
  }
});

function cargarLineasNegocioSubDependencias(){
    $.ajax({
     type: "POST",
     url: "ajax_ConsultaLineasNegocio.php",
     dataType: "json",
     success: function(response){
     if(response.status == "success"){
        $("#selLineaNegocioSubDep").empty(); 
        $('#selLineaNegocioSubDep').append('<option value="0">LINEA DE NEGOCIO</option>');
        for(var i = 0; i < response.datos.length; i++){
            $('#selLineaNegocioSubDep').append('<option value="' + (response.datos[i].idLineaNegocio) + '">' + response.datos[i].descripcionLineaNegocio + '</option>');
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

$('#selLineaNegocioSubDep').change(function(){
  var lineaNegocio=$("#selLineaNegocioSubDep").val();
  $("#selNivelSubDep").empty();
  $('#selNivelSubDep').append('<option value="0">NIVEL</option>');
  $("#selDepartamentoSubDep").empty();
  $('#selDepartamentoSubDep').append('<option value="0">DEPARTAMENTO</option>');
  $("#divSubDependenciasAsignados").empty();
  $("#divSubDependenciasAsignados").hide();
  $("#divSubDependenciasSinAsignar").empty();
  $("#divSubDependenciasSinAsignar").hide();

  if(lineaNegocio!='0'){
        cargarNivelesSubDep();
  }
});

function cargarNivelesSubDep(){
    $.ajax({
     type: "POST",
     url: "ajax_ConsultaNiveles.php",
     dataType: "json",
     success: function(response){
     if(response.status == "success"){
        $("#selNivelSubDep").empty(); 
        $('#selNivelSubDep').append('<option value="0">NIVEL</option>');
        for(var i = 0; i < response.datos.length; i++){
            // var noNivel=i+1;
            $('#selNivelSubDep').append('<option value="' + (response.datos[i].idNivelOrg) + '">' + response.datos[i].idNivelOrg +'-'+ response.datos[i].descripcionNivel + '</option>');
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

$('#selNivelSubDep').change(function(){
  var nivel=$("#selNivelSubDep").val();

  $("#selDepartamentoSubDep").empty();
  $('#selDepartamentoSubDep').append('<option value="0">DEPARTAMENTO</option>');
  $("#divSubDependenciasAsignados").empty();
  $("#divSubDependenciasAsignados").hide();
  $("#divSubDependenciasSinAsignar").empty();
  $("#divSubDependenciasSinAsignar").hide();
  
  if(nivel!='0'){
        cargarSelectorDepartamentos(nivel);
  }
});

function cargarSelectorDepartamentos(nivel){

    var categoria=$("#selCategoriaEmpleadosSubDep").val();
    var lineaNegocio=$("#selLineaNegocioSubDep").val();
    $.ajax({    
       type: "POST",
       url: "ajax_ConsultaDepartamentosAsignados.php",
       data:{"categoria":categoria,"lineaNegocio":lineaNegocio,"nivel":nivel},
       dataType: "json",
       success: function(response){

        $("#selDepartamentoSubDep").empty(); 
        $('#selDepartamentoSubDep').append('<option value="0">DEPARTAMENTO</option>');
        for(var i = 0; i < response.datos.length; i++){
            $('#selDepartamentoSubDep').append('<option value="' + (response.datos[i].idRelacionDN) + '">' + response.datos[i].idRelacionDN +'-'+ response.datos[i].descripcionDepartamento + '</option>');
        }
       },
       error : function (jqXHR, textStatus, errorThrown){
         alert(jqXHR.responseText);
       }
    });

}


$('#selDepartamentoSubDep').change(function(){
  var depaSubDep=$("#selDepartamentoSubDep").val();
  
  if(depaSubDep=='0'){
    $("#divSubDependenciasAsignados").empty();
    $("#divSubDependenciasAsignados").hide();
    $("#divSubDependenciasSinAsignar").empty();
    $("#divSubDependenciasSinAsignar").hide();
  }else{
        cargarSubdependenciasAsignadas(depaSubDep);
        cargarSubdependenciasSinAsignar(depaSubDep);
  }
});

function cargarSubdependenciasAsignadas(depaSubDep){
    $("#divSubDependenciasAsignados").empty();
    $("#divSubDependenciasAsignados").hide();
    var nivel=$("#selNivelSubDep").val();
    var categoria=$("#selCategoriaEmpleadosSubDep").val();
    var lineaNegocio=$("#selLineaNegocioSubDep").val();

    $.ajax({    
       type: "POST",
       url: "ajax_ConsultaDepartamentosACargo.php",
       data:{depaSubDep,nivel,categoria,lineaNegocio},
       dataType: "json",
       async:false,
       success: function(response){
            var tblSubdependenciasAsignadas = "<table id='tblSubdependenciasAsignadas' class='table table-bordered'><thead><th>Departamentos Asignados</th><th>Eliminar</th></thead><tbody>";
            for(var i = 0; i < response.datos.length; i++){
                tblSubdependenciasAsignadas+= "<tr>";
                tblSubdependenciasAsignadas+= "<td>"+response.datos[i].descripcionDepartamento+"</td>";   
                tblSubdependenciasAsignadas+= "<td><img src='../img/eliminar.png' title='ELIMINAR DEPARTAMENTO' style='width:27%;cursor:pointer; te' onclick='eliminarSubDependencia(\"" +response.datos[i].idRelacionDN+"\")'/></td></tr>"
            }  
            $("#divSubDependenciasAsignados").show();
            $("#divSubDependenciasAsignados").append(tblSubdependenciasAsignadas);
       },
       error : function (jqXHR, textStatus, errorThrown){
         alert(jqXHR.responseText);
       }
    });
}

function eliminarSubDependencia(idRelacionDN){
    var nivel=$("#selNivelSubDep").val();
    var depaSubDep=$("#selDepartamentoSubDep").val();

    $.ajax({    
       type: "POST",
       url: "ajax_eliminarSubDependencia.php",
       data:{"idRelacionDN":idRelacionDN},
       dataType: "json",
       success: function(response){
            cargarSubdependenciasAsignadas(depaSubDep);
            cargarSubdependenciasSinAsignar(depaSubDep);
       },
       error : function (jqXHR, textStatus, errorThrown){
         alert(jqXHR.responseText);
       }
    });
}

function cargarSubdependenciasSinAsignar(depaSubDep){
    $("#divSubDependenciasSinAsignar").empty();
    $("#divSubDependenciasSinAsignar").hide();
    var nivel=$("#selNivelSubDep").val();
    var categoria=$("#selCategoriaEmpleadosSubDep").val();
    var lineaNegocio=$("#selLineaNegocioSubDep").val();

    $.ajax({    
       type: "POST",
       url: "ajax_ConsultaDepartamentosSinCargo.php",
       data:{depaSubDep,nivel,categoria,lineaNegocio},
       dataType: "json",
       async:false,
       success: function(response){
            var tblSubDependenciasSinAsignar = "<table id='tblSubDependenciasSinAsignar' class='table table-bordered'><thead><th>Departamentos Disponibles</th><th>Agregar</th></thead><tbody>";
            for(var i = 0; i < response.datos.length; i++){
                tblSubDependenciasSinAsignar += "<tr>";
                tblSubDependenciasSinAsignar += "<td>"+response.datos[i].descripcionDepartamento+"</td>";   
                tblSubDependenciasSinAsignar += "<td><img src='../img/addMenu.png' title='AGREGAR PUESTO' style='cursor:pointer' onclick='agregarSubDependencia(\""+response.datos[i].idRelacionDN+"\")'/></td></tr>"  
            }  
            $("#divSubDependenciasSinAsignar").show();
            $("#divSubDependenciasSinAsignar").append(tblSubDependenciasSinAsignar);
       },
       error : function (jqXHR, textStatus, errorThrown){
         alert(jqXHR.responseText);
       }
    });
}

function agregarSubDependencia(idRelacion){

    var depaAcargo=$("#selDepartamentoSubDep").val();
    var nivel=$("#selNivelSubDep").val();
    
    $.ajax({    
       type: "POST",
       url: "ajax_agregarDepartamentoACargo.php",
       data:{"idRelacion":idRelacion,"depaAcargo":depaAcargo},
       dataType: "json",
       success: function(response){
            cargarSubdependenciasAsignadas(depaAcargo);
            cargarSubdependenciasSinAsignar(depaAcargo);
       },
       error : function (jqXHR, textStatus, errorThrown){
         alert(jqXHR.responseText);
       }
    });
}