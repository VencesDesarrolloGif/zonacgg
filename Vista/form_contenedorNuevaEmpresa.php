 
<center><div id="errorMsjNvaEmp" name="errorMsjNvaEmp"> </div></center>
      <center><h3>Agregar Nueva Empresa</h3></center><br>
          <center>
              <div style="" id="divAgregaEmpresa">  
                <label class="control-label label" id= "lblNvaEmpresa" for="lblNvaEmpresa">NUEVA EMPRESA </label>
                <input class="input-xlarge" id="impNvaEmpresa" name="impNvaEmpresa" type="text">
                  <button style="margin-bottom: 0.5%" type="button" class="btn btn-primary" onclick="guardarempresa();">Agregar</button>
              </div>
              <br>
             
            <div id="muestratablaempresa" ></div>
          </center>
      
   <script type="text/javascript">

var rolUsuario="<?php echo $usuario['rol']; ?>";

$(Mostrarempresas());  

function guardarempresa(){
  var empresa=$("#impNvaEmpresa").val();
  if(empresa==""){
                  Msg = "<div id='errorMsjNvaCta' class='alert alert-danger'><strong>Verifique Nueva Empresa</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#errorMsjNvaEmp").html(Msg);
                    $("#impNvaEmpresa").css('border', '#D0021B 1px solid');
                    $(document).scrollTop(0);
  }else{
        $.ajax({
          type: "POST",
          url: "ajax_guardaempresa.php",
          data:{"empresa":empresa},
          dataType: "json",
          success: function(response) {
              //console.log(response);
            $(document).scrollTop(0);
             if(response.status!="error"){
                Msg = "<div id='errorMsjNvaCta' class='alert alert-success'><strong>Empresa agregada correctamente</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                  $("#errorMsjNvaEmp").html(Msg);
                  $("#impNvaEmpresa").val("");
                  $("#impNvaEmpresa").removeAttr("style"); 
                  $(document).scrollTop(0);
                  Mostrarempresas();
              }
              
          },error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
            }
        });
    }
}

function Mostrarempresas(){
  $("#muestratablaempresa").empty();
           $.ajax({
               type: "POST",
               url: "ajax_mostrarempresas.php",
               data:{"accion":0,"idempresa":"","valorupdate":""},
               dataType: "json",
               success: function(response) {
                var datos = response.datos;
                  //console.log(datos);
                var tabla = "<table id='muestratablaempresa' class='table table-bordered'><thead><th>N°</th><th>Nombre Empresa</th></thead><tbody>";
                      $(document).scrollTop(0);
                      $.each(datos, function(i) {
                          tabla += "<tr><td > " +  datos[i].idEmpresa + " </td>";
                          tabla += "<td> "+ datos[i].nombreEmpresa +"</td>";
                      if(datos[i].visiblerh==1){
                           tabla += "<td><img src='img/Ok-icon1.png' title='Desactivar' class='cursorImg' onclick='activarDesactivar("+datos[i].idEmpresa+",0)'></td>";
                         }else{
                          tabla += "<td><img src='img/cancelar.png' title='Activar' class='cursorImg' onclick='activarDesactivar("+datos[i].idEmpresa+",1)'></td>";
                         }
                         
                      });
                      $("#muestratablaempresa").append(tabla);

               },
               error: function(jqXHR, textStatus, errorThrown) {
                   alert(jqXHR.responseText);
               }
           });
  }
function activarDesactivar(idempresa,valor){
  $.ajax({
   type: "POST",
    url: "ajax_mostrarempresas.php",
   data:{"accion":1,"idempresa":idempresa,"valorupdate":valor},
   dataType: "json",
   success: function(response) {
    Mostrarempresas();

   },error: function(jqXHR, textStatus, errorThrown) {
       alert(jqXHR.responseText);
   }
  });
}
   </script>
 }
