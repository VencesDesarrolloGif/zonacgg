<?php
//$log = new KLogger ( "BANCOS.log" , KLogger::DEBUG );
  if ($usuario["rol"] == "Finanzas" || $usuario["rol"] == "Tesoreria") {
      $listabancos   = $negocio->getcatbancos();
  //$log->LogInfo("Valor de listabancos" . var_export ($listabancos, true));
  }
?>  
<center><div id="errorMsj" name="errorMsj"> </div></center>
  <div id="muestratblfiniquitoscalculados" style="display :block">
    <div id="msgerrorbuscadorporfechasupervisiones" id="msgerrorbuscadorporfechasupervisiones"></div>
      <center><h3>Agregar Banco</h3></center><br>

        <section>
          <center>
            <div>
              <select id="selbanco" name="selbanco" class="input-large ">
                <option>BANCO</option>
                   <?php
                    for ($i = 0; $i < count($listabancos); $i++){
                     echo "<option value='" . $listabancos[$i]["idCuentaBanco"] . "'>" . $listabancos[$i]["nombreBanco"] . " </option>";
                    }
                   ?>
              </select>
              <button style="margin-bottom: 0.5%" type="button" class="btn btn-primary" onclick="agregarbanco();">Agregar</button>
            </div><br>
             <center><h5>Bancos Agregados</h5></center>
             <div id="datos" ></div>
          </center>
        </section>
  </div>
   <script type="text/javascript">

$(traebancos());  

  function agregarbanco(){
    var selbanco=$("#selbanco").val();
    var descbanco= $('select[name="selbanco"] option:selected').text();
      if(selbanco=="BANCO"){
          var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong  class='text-justify'>Seleccione Banco</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
          $("#errorMsj").html(Msgerror);
          $("#selbanco").css('border', '#D0021B 1px solid');
          $(document).scrollTop(0);
      }else{
          $("#errorMsj").html("");
          $("#selbanco").removeAttr("style");
          insertabanco(selbanco,descbanco);
        }
  }
      function traebancos() {
        $("#datos").empty();
          $.ajax({
              type: "POST",
              url: "ajax_getbancosagregadostesoreria.php",
              data:{"accion":1,"idbanco":0,"descbanco":0},
              dataType: "json",
              success: function(response) {
                  //console.log(response);
                 if (response.status == "success") {
                      var mensaje = response.message;
                      var datos = response.bancos;
                      var tabla = "<table id='tabla' class='table table-bordered'><thead><th>No</th><th>Nombre Banco</th></thead><tbody>";
                      $(document).scrollTop(0);
                      $.each(datos, function(i) {
                          tabla += "<tr><td > " + (i + 1) + " </td>";
                          tabla += "<td><input id='inpbanco" + i + "' type='text' readonly='true' value='" + datos[i].nombreBanco + "'></td>";
                         
                      });
                      $("#datos").append(tabla);
                  } else {
                      var mensaje = response.message;
                  }
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
          });
      }
      function insertabanco(idbanco,descbanco){
              $.ajax({
              type: "POST",
              url: "ajax_getbancosagregadostesoreria.php",
              data:{"accion":2,"idbanco":idbanco,"descbanco":descbanco},
              dataType: "json",
              success: function(response) {
                  if(response.mensaje!=""){
                     Msg = "<div id='errorMsj' class='alert alert-warning'><strong>" +response.mensaje +" </strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                       $("#errorMsj").html(Msg);
                       $(document).scrollTop(0);
                       $('#errorMsj').delay(3000).fadeOut('slow');
                  }else{
                      Msg = "<div id='errorMsj' class='alert alert-success'><strong>Banco agregado correctamente</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                       $("#errorMsj").html(Msg);
                       $(document).scrollTop(0);
                       $('#errorMsj').delay(3000).fadeOut('slow');
                    traebancos();
                  }
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
          });
      }
      $("#selbanco").change(function(){
        $("#errorMsj").html("");
      });
   </script>
