
<div id=datostblLineaNegocioByUser style=" position: absolute;left:72%;top: 19%;"></div> 
<img id='imgQutLineaNegocio' title='ELIMINAR LINEA NEGOCIO' style='cursor:pointer; position: absolute;left:83.3%;top: 19.8%;width:1.2%;display: none' src='img/cancelar.png' />
<div id=datostblEntidadByUser style=" position: absolute;left:15%;top: 19%;"></div> 
<div class="container" align="center">
<img id='imgQuitEntidad' title='ELIMINAR ENTIDAD' style='cursor:pointer; position: absolute;left:26.3%;top: 19.8%;width:1.2%;display: none' src='img/cancelar.png' /> 
<form class="form-horizontal"  method="post" name='form_crearUsuario' id="form_crearUsuario" enctype="multipart/form-data">
<input type="text" name="txtSearchEmpleadoId" id="txtSearchEmpleadoId"class="search-query" placeholder="Numero Empleado" aria-describedby="basic-addon2" onblur=""><img src="img/search.png">
<br><br>
  <table class="table1"  >
        <tr >
          <td><label class="control-label label " for="numeroEmpleado">N. Empleado</label> </td>
          <td> <input id="numeroEmpleadoEntidadUser" name="numeroEmpleadoEntidadUser" type="text" placeholder="00" class="input-mini-mini" maxlength="2" readonly>-
              <input id="numeroEmpleadoConsecutivoUser" name="numeroEmpleadoConsecutivoUser" type="text" placeholder="0000" class="input-small-mini" maxlength="4" readonly> -
              <input id="numeroEmpleadoTipoUser" name="numeroEmpleadoTipoUser" type="text" placeholder="00" class="input-mini-mini" maxlength="2" readonly>
          </td>
         </tr>
        <tr>
          <td><label class="control-label label " for="apellidoPaternoEmpleado">Apellido Paterno</label></label> </td>
          <td><input id="apellidoPaternoEmpleadoUser" name="apellidoPaternoEmpleadoUser" type="text" placeholder="Solo Letras" class="input-large" readonly></td>
        </tr>
        <tr >
          <td ><label class="control-label label" for="apellidoMaternoEmpleado">Apellido Materno</label></td>
          <td><input id="apellidoMaternoEmpleadoUser" name="apellidoMaternoEmpleadoUser" type="text" placeholder="Solo letras" class="input-large" readonly></td>
        </tr>
        <tr >
          <td ><label class="control-label label" for="apellidoMaternoEmpleado">Nombre</label></td>
          <td><input id="nombreEmpleadoUser" name="nombreEmpleadoUser" type="text" placeholder="Solo letras" class="input-large" readonly></td>
        </tr>
        <tr>
        <td ><label class="control-label label" for="apellidoMaternoEmpleado">Entidad Federativa</label></td>
        <td><select id="idEndidadFederativaUser" name="idEndidadFederativaUser" class="input-large ">
             <option>Entidad</option>
              <?php
                for ($i=0; $i<count($catalogoEntidadesFederativas); $i++)
                {
                echo "<option value='". $catalogoEntidadesFederativas[$i]["idEntidadFederativa"]."'>". $catalogoEntidadesFederativas[$i]["nombreEntidadFederativa"] ." </option>";
                }
              ?>
              </select><button style="margin-bottom: 0.8%" title="Agregar Entidad" type="button" class="btn btn-primary" onclick="agregarentidad();">Agregar</button>
          </td>
        </tr>
        <tr>
        <td ><label class="control-label label" for="apellidoMaternoEmpleado">Linea Negocio</label></td>
        <td><select id="sellineanegocio" name="sellineanegocio" class="input-large ">
             <option>Linea negocio</option>
              <?php
                for ($i=0; $i<count($catalogoLineaNegocio); $i++)
                {
                echo "<option value='". $catalogoLineaNegocio[$i]["idLineaNegocio"]."'>". $catalogoLineaNegocio[$i]["descripcionLineaNegocio"] ." </option>";
                }
              ?>
              </select><button style="margin-bottom: 0.8%" title="Agregar Linea Negocio" type="button" class="btn btn-primary" onclick="agregarlineanegocio();">Agregar</button>
          </td>
        </tr>
        <tr>
        <td ><label class="control-label label" for="apellidoMaternoEmpleado">Rol</label></td>
        <td><select id="idRolUser" name="idRolUser" class="input-large ">
             <option>Rol</option>
              <?php
                for ($i=0; $i<count($getRolesUsuario); $i++)
                {
                echo "<option value='". $getRolesUsuario[$i]["idRolUsuario"]."'>". $getRolesUsuario[$i]["descripcionRolUsuario"] ." </option>";
                }
              ?>
              </select>
          </td>
        </tr>
        <tr >
          <td ><label class="control-label label" for="apellidoMaternoEmpleado">Correo corporativo</label></td>
          <td><input type="text" id="correoUser" name="correoUser"/> </td>
        </tr>

        <tr >
          <td ><label class="control-label label" for="apellidoMaternoEmpleado">Usuario</label></td>
          <td><input type="text" id="usuarioEmpleado" name="usuarioEmpleado" maxlength="10" placeholder="User name" required/> </td>
        </tr>

        <tr >
          <td ><label class="control-label label" for="apellidoMaternoEmpleado">Contraseña</label></td>
          <td><input type="password" id="contrasenaUser1" name="contrasenaUser1" placeholder="Password" maxlength="10" required/> </td>
        </tr>
        <tr >
          <td ><label class="control-label label" for="apellidoMaternoEmpleado">Contraseña</label></td>
          <td><input type="password" id="contrasenaUser2" name="contrasenaUser2" placeholder="Password" maxlength="10" required/> </td>
        </tr>              
   </table>
   <button type='button' class='btn btn-success' id='btnCrearUsuario' name='btnCrearUsuario' onclick='crearUsuario();'>Crear usuario</button>
</form>
</div>

<script type="text/javascript">
	
 var bandera=0;
 var banderalineanegocio=0;
	function consultaEmpleadoForUser ()
{
    var numeroEmpleado1 = $("#txtSearchEmpleadoId").val(); 

    if(numeroEmpleado1==""){
      limpiarFormNuevoUsuario();

      }else if((!/^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/.test(numeroEmpleado1)) && (!/^[0-9]{2}\-[0-9]{5}\-[0-9]{2}/.test(numeroEmpleado1))){
       limpiarFormNuevoUsuario();
 
      }else{
 $.ajax({            
            type: "POST",
            url: "ajax_obtenerEmpleadoPorId.php",
            data:{"numeroEmpleado":numeroEmpleado1},
            dataType: "json",
             success: function(response) {
                if (response.status == "success")
                {             
                   var empleadoEncontrado = response.empleado;
                    if (empleadoEncontrado.length == 0){                  
                     limpiarFormNuevoUsuario();
                   }else {
                      
                    listaPersonalActivoTable="<table class='table table-hover' id='Exportar_a_Excel'><thead><th>Estatus</th><th># Empleado</th><th>Nombre</th><th>Fecha Ingreso</th><th>#Cta</th><th>Cta Clabe</th><th>Puesto</th><th>Tipo Puesto</th><th>D.P.</th><th>Dir</th><th>D.F</th></thead><tbody>";

                    for ( var i = 0; i < empleadoEncontrado.length; i++ ){
                      var empleadoEntidad = empleadoEncontrado[i].entidadFederativaId;
                      var empleadoConsecutivo = empleadoEncontrado[i].empleadoConsecutivoId;
                      var empleadoCategoria = empleadoEncontrado[i].empleadoCategoriaId;
                      var empleadoApellidoPaterno= empleadoEncontrado[i].apellidoPaterno;
                      var empleadoApellidoMaterno= empleadoEncontrado[i].apellidoMaterno;
                      var nombreEmpleado= empleadoEncontrado[i].nombreEmpleado;

                    $("#numeroEmpleadoEntidadUser").val(empleadoEntidad);
                    $("#numeroEmpleadoConsecutivoUser").val(empleadoConsecutivo);
                    $("#numeroEmpleadoTipoUser").val(empleadoCategoria);
                    $("#apellidoPaternoEmpleadoUser").val(empleadoApellidoPaterno);
                    $("#apellidoMaternoEmpleadoUser").val(empleadoApellidoMaterno);
                    $("#nombreEmpleadoUser").val(nombreEmpleado);

                    var inicial = nombreEmpleado.substring(0, 1);
                    var user = empleadoApellidoPaterno + inicial;

                    $("#usuarioEmpleado").val(user.replace(/\s/g,''));
                    }
                }

                }else if (response.status == "error" && response.message == "No autorizado")
                {
                    window.location = "login.php";
                }
            },
            error: function (response)
            {
                console.log (response);

            }
        });
}
}
      $('#txtSearchEmpleadoId').keypress(function(event){  
      var keycode = (event.keyCode ? event.keyCode : event.which);  
      if(keycode == '13'){  
           //alert('Se ha presionado Enter!');  
           //tableEmpleadosByPeriodoSupervisorName();
           consultaEmpleadoForUser();
           $('#txtSearchEmpleadoId').val("");
          
      }   
 });

function crearUsuario(){

   var largotblnuevo = $("#tblEntidadesByUser tr").length;

   var largotblnuevolineanegocio = $("#tbllineasnegocioByUser tr").length;
   //var datostbl=$("#form_datostbl").serialize();
        var datastring = $("#form_crearUsuario").serialize();
        var idsEntidades=Array();
        var idslineasnegocio=Array();
        datastring += "&largotbl=" + largotblnuevo;
        datastring += "&largotbllineanegocio=" + largotblnuevolineanegocio;
if(largotblnuevo!=0){
        for (var i = 0; i < (largotblnuevo-1); i++) {
        var idEntidad= $("#idEntidadByUser"+i).val(); 
        //alert(idEntidad);
        idsEntidades[i]=idEntidad;
        //datastring += "&idEntidad=" + largotblnuevo;
      } 
      datastring += "&idsEntidades=" + idsEntidades;
      //console.log(idsEntidades);
  }

  if(largotblnuevolineanegocio!=0){
        for (var i = 0; i < (largotblnuevolineanegocio-1); i++) {
        var idlinenanegocio= $("#idLineaNegocioByUser"+i).val(); 
        //alert(idEntidad);
        idslineasnegocio[i]=idlinenanegocio;
        //datastring += "&idEntidad=" + largotblnuevo;
      }
      datastring += "&idslineasnegocio=" + idslineasnegocio;
      //console.log(idsEntidades);
  }
        //alert(datastring);
        $.ajax({
            type: "POST",
            url: "ajax_newUser.php",
            data: datastring,
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;

                if (response.status=="success") {
            

                    alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Creación de usuario: </strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#alertMsg").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(6000).fadeOut('slow');
                    limpiarFormNuevoUsuario();


                } else if (response.status=="error")
                {
                  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Creación de usuario:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#alertMsg").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(4000).fadeOut('slow');
                }


             } ,error : function (jqXHR, textStatus, errorThrown)
            {
                alert(jqXHR.responseText);
            }
        });  
      }

      function limpiarFormNuevoUsuario(){
        $("#imgQuitEntidad").hide();
        $("#imgQutLineaNegocio").hide();
        $("#tblEntidadesByUser").empty();
        $("#tbllineasnegocioByUser").empty();
          bandera=0;
          banderalineanegocio=0;
        $("#usuarioEmpleado").val("");
        $("#contrasenaUser1").val("");
        $("#contrasenaUser2").val("");
        $("#contrasenaUser2").val("");
        $("#apellidoPaternoEmpleadoUser").val("");
        $("#apellidoMaternoEmpleadoUser").val("");
        $("#nombreEmpleadoUser").val("");
        $("#correoUser").val("");
        $("#numeroEmpleadoEntidadUser").val("");
        $("#numeroEmpleadoConsecutivoUser").val("");
        $("#numeroEmpleadoTipoUser").val("");
        $("#idRolUser").prop('selectedIndex', 0);
        $("#idEndidadFederativaUser").prop('selectedIndex', 0);
        $("#sellineanegocio").prop('selectedIndex', 0);
      }
function agregarentidad(){
   var descripcionEntidadSelector=$('select[id="idEndidadFederativaUser"] option:selected').text();
   var idEntidad=$("#idEndidadFederativaUser").val();

  if(idEntidad!="Entidad"){
    if(bandera==0){
     var tabla = "<table id='tblEntidadesByUser' class='table table-bordered'><thead><th>No</th><th>Entidad</th></thead><tbody>";
      $("#datostblEntidadByUser").html(tabla);
     $("#imgQuitEntidad").show();
      bandera=1;
    }
    var largotbl = $("#tblEntidadesByUser tr").length;
    var table = document.getElementById("tblEntidadesByUser");
    var row = table.insertRow(largotbl);
    var contfila = row.insertCell(0);
    var cell1 = row.insertCell(1);
   // var cell2 = row.insertCell(2);
      for (var i = 0; i < largotbl; i++) {
        contfila.innerHTML = "<td> " + (i + 1) + " </td>";
        cell1.innerHTML = "<input id='idEntidadByUser" + i + "' type='hidden'>  <input id='descEntidadByUser" + i + "' type='text' readonly>";   
        //cell2.innerHTML = "<img id='imgQuitEntidad' title='ELIMINAR ENTIDAD' style='margin-left:21%;cursor:pointer;width:50%' src='img/cancelar.png' onclick='functionAppendEntidadSelec(\""+idEntidad+ "\", \""+descripcionEntidadSelector+ "\")'>";   
      }  
    $("#descEntidadByUser"+(largotbl-1)).val(descripcionEntidadSelector);
    $("#idEntidadByUser"+(largotbl-1)).val(idEntidad);
    $("#idEndidadFederativaUser").val("Entidad");
     $("#idEndidadFederativaUser option[value='" + idEntidad + "']").remove();
  }
}

function quitarentidnuevousuario(){
  var myTable = document.getElementById("tblEntidadesByUser"); 
  var rowCount = myTable.rows.length; 
  if(rowCount!=1){
    var identidad=$("#idEntidadByUser"+(rowCount-2)).val();
    var descentidad=$("#descEntidadByUser"+(rowCount-2)).val();
    $('#idEndidadFederativaUser').append('<option value="' + identidad + '">' + descentidad + '</option>');
      myTable.deleteRow((rowCount-1)); 
      if((rowCount-1)==1){
        $("#imgQuitEntidad").hide();
        $("#tblEntidadesByUser").empty();
        bandera=0;
      }

  }
       
}

$("#imgQuitEntidad").click(function(){
    quitarentidnuevousuario();
});

function agregarlineanegocio(){
   var descripcionlienanegocioSelector=$('select[id="sellineanegocio"] option:selected').text();
   var idLineaNegocio=$("#sellineanegocio").val();

  if(idLineaNegocio!="Linea negocio"){
    if(banderalineanegocio==0){
     var tablasss = "<table id='tbllineasnegocioByUser' class='table table-bordered'><thead><th>No</th><th>Linea Negocio</th></thead><tbody>";
      $("#datostblLineaNegocioByUser").html(tablasss);
     $("#imgQutLineaNegocio").show();
      banderalineanegocio=1;
    }
    var largotblineanegocio = $("#tbllineasnegocioByUser tr").length;
    var tablelineanegocio = document.getElementById("tbllineasnegocioByUser");
    var rowlineanegocio = tablelineanegocio.insertRow(largotblineanegocio);
    var contfilalineanegocio = rowlineanegocio.insertCell(0);
    var cell1lineanegocio = rowlineanegocio.insertCell(1);
   // var cell2 = row.insertCell(2);
      for (var i = 0; i < largotblineanegocio; i++) {
        contfilalineanegocio.innerHTML = "<td> " + (i + 1) + " </td>";
        cell1lineanegocio.innerHTML = "<input id='idLineaNegocioByUser" + i + "' type='hidden'>  <input id='descLineaNegocioByUser" + i + "' type='text' readonly>";   
        //cell2.innerHTML = "<img id='imgQuitEntidad' title='ELIMINAR ENTIDAD' style='margin-left:21%;cursor:pointer;width:50%' src='img/cancelar.png' onclick='functionAppendEntidadSelec(\""+idEntidad+ "\", \""+descripcionEntidadSelector+ "\")'>";   
      }  
    $("#descLineaNegocioByUser"+(largotblineanegocio-1)).val(descripcionlienanegocioSelector);
    $("#idLineaNegocioByUser"+(largotblineanegocio-1)).val(idLineaNegocio);
    $("#sellineanegocio").val("Linea negocio");
     $("#sellineanegocio option[value='" + idLineaNegocio + "']").remove();
  }
}
$("#imgQutLineaNegocio").click(function(){
    quitarlineanegocionuevousuario();
});

function quitarlineanegocionuevousuario(){
  var myTable = document.getElementById("tbllineasnegocioByUser"); 
  var rowCount = myTable.rows.length; 
  if(rowCount!=1){
    var idlineanegociouser=$("#idLineaNegocioByUser"+(rowCount-2)).val();
    var desclineanegocio=$("#descLineaNegocioByUser"+(rowCount-2)).val();
    $('#sellineanegocio').append('<option value="' + idlineanegociouser + '">' + desclineanegocio + '</option>');
      myTable.deleteRow((rowCount-1)); 
      if((rowCount-1)==1){
        $("#imgQutLineaNegocio").hide();
        $("#tbllineasnegocioByUser").empty();
         banderalineanegocio=0;
      }
  }      
}
</script>