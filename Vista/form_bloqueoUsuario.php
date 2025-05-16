 <div class="container" align="center">
 	<input type="text" name="txtSearchNameUser" id="txtSearchNameUser"class="input-xlarge" placeholder="NOMBRE" aria-describedby="basic-addon2" ><img src="img/search.png">

 	<div id="listaDeUsuarios" >  	
    

   </div>
 </div>



 <script type="text/javascript">


  $('#txtSearchNameUser').keypress(function(event){  
   var keycode = (event.keyCode ? event.keyCode : event.which);  
   if(keycode == '13'){ 
    var nombre = $("#txtSearchNameUser").val();
    getUsuariosByNombre(nombre);

   //$("#txtSearchNameUser").val("");
    
  }   
}); 

  function getUsuariosByNombre(nombre){
  var nombreUsuario = $("#txtSearchNameUser").val();

   if(nombreUsuario==""){
      alertMsg4="<div id='msgAlert' class='alert alert-error'><strong><center>Ingrese nombre del titular</center></strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";             
      $("#alertMsg").html(alertMsg4);
      $(document).scrollTop(0);
      $('#msgAlert').delay(3000).fadeOut('slow');
      $("#txtSearchNameUser").val("");
      $("#listaDeUsuarios").hide();
    }
    else if(!/^[a-zA-Z]+(\s*[a-zA-Z]*)*[a-zA-Z]$/.test(nombreUsuario)){
    alertMsg3="<div id='msgAlert' class='alert alert-error'><strong><center>Por favor ingresa solo letras</center></strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";             
      $("#alertMsg").html(alertMsg3);
      $(document).scrollTop(0);
      $('#msgAlert').delay(3000).fadeOut('slow');
      $("#txtSearchNameUser").val("");
      $("#listaDeUsuarios").hide();
    }

    else{
   $.ajax({
    type: "POST",
    url: "ajax_getUsuariosByNombre.php",
    data: {"nombre": nombre},
    dataType: "json",
    success: function(response) {
      if (response.status == "success")
      {
        var listaUsers = response.usuarios;
        var largocadena = listaUsers.length;
        if(largocadena!="0"){
          var tableUsers="<table class='table table-hover'><thead><th>Nombre titular</th><th>Rol usuario</th><th>Usuario</th></thead><tbody>";
          for (var i = 0; i < listaUsers.length; i++)
          {
            tableUsers += "<tr><td>"+listaUsers[i].nombre+"</td><td>"+listaUsers[i].descripcionRolUsuario+"</td><td>"+listaUsers[i].usuario+"</td><td><img src='img/lock.png'><a  href='javascript:bloquearUsuario("+listaUsers[i].usuarioId+",\"" + nombre + "\")';> Bloquear</a></td></tr>";   
          }
          tableUsers += "</table>";
          $("#listaDeUsuarios").html (tableUsers);
          $("#listaDeUsuarios").show();
        }else{
          alertMsg3="<div id='msgAlert' class='alert alert-error'><strong><center>No se encontrarón coincidencias favor de ingresar mas información</center></strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";             
          $("#alertMsg").html(alertMsg3);
          $(document).scrollTop(0);
          $('#msgAlert').delay(3000).fadeOut('slow');
          $("#txtSearchNameUser").val("");
          $("#listaDeUsuarios").hide();
        }

      }
    },
    error: function (response)
    {
      console.log (response);
    }
  });
}
 }

 function bloquearUsuario(usuarioId, nombre){

  $.ajax({
    type: "POST",
    url: "ajax_bloqueoUsuario.php",
    data: {usuarioId:usuarioId},
    dataType: "json",
    success: function(response) {
      var mensaje=response.message;

      if (response.status=="success") {
        

        alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Bloqueo de usuario:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
        
        $("#alertMsg").html(alertMsg1);
        $('#msgAlert').delay(3000).fadeOut('slow');
        getUsuariosByNombre(nombre);
        

      } else if (response.status=="error")
      {
        alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Bloqueo de usuario:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
        
        $("#alertMsg").html(alertMsg1);
        $('#msgAlert').delay(3000).fadeOut('slow');
      }
    },
    error: function(){
      alert('error handing here');
    }
  });

}

</script>