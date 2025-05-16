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