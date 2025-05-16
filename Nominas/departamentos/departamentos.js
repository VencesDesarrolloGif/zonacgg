$('#selCategoriaEmpleados').change(function(){

  var categoria=$("#selCategoriaEmpleados").val();
  $("#selLineaNegocio").empty();
  $('#selLineaNegocio').append('<option value="0">LINEA DE NEGOCIO</option>');
  $("#selDepartamento").empty();
  $('#selDepartamento').append('<option value="0">DEPARTAMENTO</option>');
  $("#divDatosPuestosAsignados").empty();
  $("#divDatosPuestosAsignados").hide();
  $("#divDatosPuestosSinAsignar").empty();
  $("#divDatosPuestosSinAsignar").hide();
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
    
    var categoria=$("#selCategoriaEmpleados").val();
    var lineaNegocio=$("#selLineaNegocio").val();
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
    var categoria=$("#selCategoriaEmpleados").val();
    var lineaNegocio=$("#selLineaNegocio").val();
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
    var categoria=$("#selCategoriaEmpleados").val();
    var lineaNegocio=$("#selLineaNegocio").val();

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