<div class="container" align="center">
	<div id="msjerrOsucces"></div>
    <input type="text" name="txtSearchEmpleadoIdedituser" id="txtSearchEmpleadoIdedituser"class="search-query" placeholder="Numero Empleado" aria-describedby="basic-addon2" onblur=""><img src="img/search.png">
    <br><br><br>
    <div id="datosUserByEmpleado"></div>
    <div style="display: none;position: absolute;left:47%;top:16%;" id="datosEntidadesByUser"></div> 
    <div style="display: none;position: absolute;right:19%;top: 16%;" id="datosLineanegocioByUser"></div>
    <div style="display: none;position: absolute;left:5%;top: 16%;" id="datosEntidadesFederativas"></div>
    <div style="display: none;position: absolute;left:25%;top: 16%;" id="datosLineaNegocio"></div>
    <input type="hidden" id="hdnidusuario" name="hdnidusuario" /></div>

    <script type="text/javascript">


$(inicioEdicionUSR());  

function inicioEdicionUSR(){
    cargartblEntidades();
    cargartblLineasNegocio();
}

        function cargartblEntidades(){
         $.ajax({    
            type: "POST",
            url: "ajax_entidadesEdicionUsuario.php",
            data:{"accion":0},
            dataType: "json",
            success: function(response) {
             	//console.log(response);
               var tblEntidadesFederativas = "<table id='tblEntidadesFederativas' class='table table-bordered'><thead><th>No</th><th>Entidad Federativa</th><th>Agregar Entidad</th></thead><tbody>";
               for (var i = 0; i < response.entidadesFederativas.length; i++) {
                tblEntidadesFederativas += "<tr> <td> " + (i + 1) + " </td>";

                tblEntidadesFederativas += "<td>"+response.entidadesFederativas[i].nombreEntidadFederativa+"</td>";   

                tblEntidadesFederativas += "<td><img src='img/addMenu.png' title='AGREGAR ENTIDAD' style='cursor:pointer' onclick='addEntidadFederativa(\"" + response.entidadesFederativas[i].idEntidadFederativa+ "\")'/></td></tr>";   
            }  
            $("#datosEntidadesFederativas").append(tblEntidadesFederativas);


        },error : function (jqXHR, textStatus, errorThrown)
        {
            alert(jqXHR.responseText);
        }
    });
     }
     function cargartblLineasNegocio(){
         $.ajax({    
            type: "POST",
            url: "ajax_entidadesEdicionUsuario.php",
            data:{"accion":6},
            dataType: "json",
            success: function(response) {
                console.log(response);
                var tbllineanegocio = "<table id='tblLineasNegocio' class='table table-bordered'><thead><th>No</th><th>Linea negocio</th><th>Agregar Linea negocio</th></thead><tbody>";
                for (var i = 0; i < response.lineasnegocio.length; i++) {
                    tbllineanegocio += "<tr> <td> " + (i + 1) + " </td>";

                    tbllineanegocio += "<td>"+response.lineasnegocio[i].descripcionLineaNegocio+"</td>";   

                    tbllineanegocio += "<td><img src='img/addMenu.png' title='AGREGAR LINEA NEGOCIO' style='cursor:pointer' onclick='addLineaNegocio(\"" + response.lineasnegocio[i].idLineaNegocio+ "\")'/></td></tr>";   
                }  
                $("#datosLineaNegocio").append(tbllineanegocio);


            },error : function (jqXHR, textStatus, errorThrown)
            {
                alert(jqXHR.responseText);
            }
        });
     }
     function consultaEmpleadoForUsersfsf ()
     {
      var numeroEmpleado1 = $("#txtSearchEmpleadoIdedituser").val();   
      $("#msjerrOsucces").html(""); 
      if(numeroEmpleado1==""){
        pintamensaje("Por favor ingresa Número de empleado","error");
                    $("#datosUserByEmpleado").empty(); 
                    $("#txtSearchEmpleadoIdedituser").val("");  
                       

        }else if((!/^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/.test(numeroEmpleado1)) && (!/^[0-9]{2}\-[0-9]{5}\-[0-9]{2}/.test(numeroEmpleado1))){
        pintamensaje("Por favor ingresa Número de empleado correcto con estructura (00-0000-00 o 00-00000-00),Solo números","error");
                    $("#datosUserByEmpleado").empty();
                    $("#txtSearchEmpleadoIdedituser").val("");  

      }else
      {
     $.ajax({    
        type: "POST",
        url: "ajax_entidadesEdicionUsuario.php",
        data:{"numeroEmpleado":numeroEmpleado1,"accion":1},
        dataType: "json",
        success: function(response) {
             	//console.log(response);
                if (response.status == "success")
                {
                	$("#datosUserByEmpleado").show("slow");
                	$("#datosEntidadesByUser").hide("slow");
                	$("#datosEntidadesFederativas").hide();
                  $("#datosUserByEmpleado").empty();
                  var tbl = "<table id='tbldatos' class='table table-bordered'><thead><th>No</th><th>Nombre Titular</th><th>Rol Usuario</th><th>Usuario</th><th>Editar</th></thead><tbody>";
                  for (var i = 0; i < response.empleado.length; i++) {
                    tbl += "<tr> <td> " + (i + 1) + " </td>";
                    tbl += "<td>"+response.empleado[i].nombre+" "+ response.empleado[i].apellidoPaterno+ " " +  response.empleado[i].apellidoMaterno+"</td>";   
                    tbl += "<td>"+response.empleado[i].descripcionRolUsuario+"</td>";   
                    tbl += "<td>"+response.empleado[i].usuario+"</td>";   
                    tbl += "<td><a href='javascript:EditarUsuario(" + response.empleado[i].usuarioId + ")'> Editar Entidad</a><img src='img/edit.png'> </td></tr>";   
                }  
                $("#datosUserByEmpleado").append(tbl);
            }else if (response.status == "error")
            {
              pintamensaje(response.error,"error");
                    $("#datosUserByEmpleado").empty();  
                    $("#txtSearchEmpleadoIdedituser").val("");  

              //  alert(response.error);
            }
        },error : function (jqXHR, textStatus, errorThrown)
        {
            alert(jqXHR.responseText);
        }
    });
 }
}
$('#txtSearchEmpleadoIdedituser').keypress(function(event){  
  var keycode = (event.keyCode ? event.keyCode : event.which);  
  if(keycode == '13'){  
   consultaEmpleadoForUsersfsf();   
       }   
   });
function EditarUsuario(idusuario){
	//alert(idusuario);
	 //$("#msjerrOsucces").html(""); 
   $.ajax({    
    type: "POST",
    url: "ajax_entidadesEdicionUsuario.php",
    data:{"idusuario":idusuario,"accion":2},
    dataType: "json",
    success: function(response) {
      //console.log(response);
      $("#datosEntidadesByUser").empty();
      $("#datosLineanegocioByUser").empty();
      if(response.entidades.length==0 && response.lineasnegocio.length==0){
        pintamensaje("El usuario no tiene linea de negocio y entidades asignadas ","warning");
    }else if(response.entidades.length==0 && response.lineasnegocio.length!=0){
       pintamensaje("El usuario no tiene entidades asignadas","warning");
             		//alert("el usuario no tiene entidades asignadas agregar una entidad");
             	}else if(response.entidades.length!=0 && response.lineasnegocio.length==0){
                    pintamensaje("El usuario no tiene linea de negocio asignadas","warning");
                    //alert("el usuario no tiene entidades asignadas agregar una entidad");
                }	
                $("#datosUserByEmpleado").hide("slow");
                var tblEtidades = "<table id='tbldatosEntidadByuser' class='table table-bordered'><thead><th>No</th><th>Entidad</th><th>Eliminar</th></thead><tbody>";
                for(var i=0;i<response.entidades.length;i++){
                    tblEtidades += "<tr> <td> " + (i + 1) + " </td>";
                    tblEtidades += "<td>"+response.entidades[i].nombreEntidadFederativa+"</td>"; 
                    tblEtidades += "<td><img src='img/cancel.png' title='ELIMINAR ENTIDAD' style='cursor:pointer' onclick='quitarentidad(\"" + response.entidades[i].idUsuarioEnt + "\",  \"" + response.entidades[i].idEntidadEnt + "\" )'></tr></td>"; 
                }
                $("#datosEntidadesByUser").append(tblEtidades);

                var tbllineasnegocio = "<table id='tbllineanegocioByuser' class='table table-bordered'><thead><th>No</th><th>Linea negocio</th><th>Eliminar</th></thead><tbody>";
                for(var i=0;i<response.lineasnegocio.length;i++){
                    tbllineasnegocio += "<tr> <td> " + (i + 1) + " </td>";
                    tbllineasnegocio += "<td>"+response.lineasnegocio[i].descripcionLineaNegocio+"</td>"; 
                    tbllineasnegocio += "<td><img src='img/cancel.png' title='ELIMINAR LINEA NEGOCIO' style='cursor:pointer' onclick='quitarlineanegocio(\"" + response.lineasnegocio[i].idUsuariolineaneg + "\",  \"" + response.lineasnegocio[i].idlineaNegocio + "\" )'></tr></td>"; 
                }
                $("#datosLineanegocioByUser").append(tbllineasnegocio);
                $("#datosEntidadesByUser").show("slow");
                $("#datosEntidadesFederativas").show("slow");
                $("#datosLineaNegocio").show("slow");   
                $("#datosLineanegocioByUser").show("slow");
                $("#hdnidusuario").val(idusuario);
                $("#datosEntidadesByUser").append("<a href='javascript:regresarvistaUsuarios()';>Anterior</a>");
             	//}else{
             		//alert("el usuario no tiene entidades asignadas agregar una entidad");
             	//}

             },error : function (jqXHR, textStatus, errorThrown)
             {
                alert(jqXHR.responseText);
            }
        });
}
function quitarentidad  (idusuario,identidad){
	//alert("quitar entidad "+idusuario+"-->"+identidad);
    $.ajax({    
        type: "POST",
        url: "ajax_entidadesEdicionUsuario.php",
        data:{"idusuario":idusuario,"identidad":identidad,"accion":3},
        dataType: "json",
        success: function(response) {
          console.log(response);
          if(response.status=="success"){
             		//alert("edicion finalizada con exito");
             		pintamensaje("Se eliminó entidad con éxito","success");
             		EditarUsuario(idusuario);
             	}else{
             		alert("algo ha salido mal intenta nuevamente mas tarde");
             	}   
             },error : function (jqXHR, textStatus, errorThrown)
             {
                alert(jqXHR.responseText);
            }
        });
}
function quitarlineanegocio  (idusuario,idlineanegocio){
    //alert("quitar entidad "+idusuario+"-->"+identidad);
    $.ajax({    
        type: "POST",
        url: "ajax_entidadesEdicionUsuario.php",
        data:{"idusuario":idusuario,"idlineanegocio":idlineanegocio,"accion":5},
        dataType: "json",
        success: function(response) {
            console.log(response);
            if(response.status=="success"){
                    //alert("edicion finalizada con exito");
                    pintamensaje("Se eliminó Linea negoocio con éxito","success");
                    EditarUsuario(idusuario);
                }else{
                    alert("algo ha salido mal intenta nuevamente mas tarde");
                }   
            },error : function (jqXHR, textStatus, errorThrown)
            {
                alert(jqXHR.responseText);
            }
        });
}
function addEntidadFederativa(identidad){
	var idusuario=$("#hdnidusuario").val();
  $.ajax({    
      type: "POST",
      url: "ajax_entidadesEdicionUsuario.php",
      data:{"idusuario":idusuario,"identidad":identidad,"accion":4},
      dataType: "json",
      success: function(response) {
		             	//console.log(response);
		             	if(response.status=="existe"){
		             		//alert("La entidad ya fue asignada a este usuario");
		             		pintamensaje("La entidad ya fue asignada a este usuario","error");
		             		//EditarUsuario(idusuario);
		             	}else{
		             		//alert("Entidad asignada correctamente");
		             		pintamensaje("Entidad asignada correctamente","success");
		             		EditarUsuario(idusuario);
		             	}		               
                  },error : function (jqXHR, textStatus, errorThrown)
                  {
                      alert(jqXHR.responseText);
                  }
              });
}
function addLineaNegocio(idlineanegocio){
    var idusuario=$("#hdnidusuario").val();  
    $.ajax({    
      type: "POST",
      url: "ajax_entidadesEdicionUsuario.php",
      data:{"idusuario":idusuario,"idlineanegocio":idlineanegocio,"accion":7},
      dataType: "json",
      success: function(response) {
                        //console.log(response);
                        if(response.status=="existe"){
                            //alert("La entidad ya fue asignada a este usuario");
                            pintamensaje("La Linea de negocio ya fue asignada a este usuario","error");
                            //EditarUsuario(idusuario);
                        }else{
                            //alert("Entidad asignada correctamente");
                            pintamensaje("Entidad asignada correctamente","success");
                            EditarUsuario(idusuario);
                        }                      
                    },error : function (jqXHR, textStatus, errorThrown)
                    {
                      alert(jqXHR.responseText);
                  }
              });

}
function pintamensaje(mensaje,clase){
    $('#msjerrOsucces').fadeIn();
	var msjerrOsucces="<div id='msjerrOsucces' class='alert alert-"+clase+"'><strong><center>"+mensaje+"</center></strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#msjerrOsucces").html(msjerrOsucces);
    $('#msjerrOsucces').delay(3000).fadeOut('slow');
    $(document).scrollTop(0);
}
function regresarvistaUsuarios(){
	$("#msjerrOsucces").html(""); 
	$("#datosUserByEmpleado").show("slow");
    $("#datosEntidadesByUser").hide("slow");
    $("#datosEntidadesFederativas").hide();
    $("#datosLineaNegocio").hide();
    $("#datosUserByEmpleado").empty();
    $("#datosLineanegocioByUser").hide("slow");
    consultaEmpleadoForUsersfsf();
}
</script>