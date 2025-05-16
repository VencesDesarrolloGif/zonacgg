<?php
//$log = new KLogger ( "BANCOS.log" , KLogger::DEBUG );
  if ($usuario["rol"] == "Finanzas" || $usuario["rol"] == "Tesoreria") {
      $listabancosnuevacuenta   = $negocio->negocio_ListaBancos();
  //$log->LogInfo("Valor de listabancos" . var_export ($listabancos, true));
  }
?>  
<center><div id="errorMsjNvaCta" name="errorMsjNvaCta"> </div></center>
  <div id="muestratblfiniquitoscalculados" style="display :block">
    <div id="msgerrorbuscadorporfechasupervisiones" id="msgerrorbuscadorporfechasupervisiones"></div>
      <center><h3>Agregar Cuenta</h3></center><br>

          <center>
            <div>
              <select id="selbanconuevacuenta" name="selbanconuevacuenta" class="input-large ">
                <option value="0">BANCO</option>
                   <?php
                    for ($i = 0; $i < count($listabancosnuevacuenta); $i++){
                     echo "<option value='" . $listabancosnuevacuenta[$i]["idBanco"] . "'>" . $listabancosnuevacuenta[$i]["nombreBanco"] . " </option>";
                    }
                   ?>
              </select><br><br>
              <input style="display:none"  id="txtNuevaCuenta" name="txtNuevaCuenta" type="text" class="input-xlarge" placeholder="Agregar Cuenta Bancaria"><br><br>
            <button style="margin-bottom: 0.5%" type="button" class="btn btn-primary" onclick="guardarcuenta();">Agregar</button>

            <div id="muestracuentas" style="display: none">
             <center><h5>Cuentas Agregadas</h5></center>
             <div id="datoscuentasbancarias" ></div>
           </div>
          </center>
      
  </div>
   <script type="text/javascript">
      
$("#selbanconuevacuenta").change(function(){
  limpiaerrores();
var valorselector=$("#selbanconuevacuenta").val();
 $("#txtNuevaCuenta").val('');
    if(valorselector==0){
      
      $("#txtNuevaCuenta").hide();
      $("#muestracuentas").hide();
    }else{
      $("#txtNuevaCuenta").show('slow');
      $("#muestracuentas").show('slow');
      traecuentasbancarias();
      }
});
 

 function guardarcuenta(){
  var valorselector=$("#selbanconuevacuenta").val();
  var cuenta=$("#txtNuevaCuenta").val();
  if(valorselector==0){
    cargaerrores("selbanconuevacuenta","Seleccione un banco");
    return 0;
  }
 if(cuenta==""  || !/^([0-9]{8,14})*$/.test(cuenta)){
    cargaerrores("txtNuevaCuenta","Verifique el número de cuenta");
    return 0;
  }
 $.ajax({
              type: "POST",
              url: "ajax_guardacuentabancaria.php",
              data:{"accion":2,"valorselector":valorselector,"cuenta":cuenta},
              dataType: "json",
              success: function(response) {
                  //console.log(response);
                      $(document).scrollTop(0);
                if(response.mensaje!=""){
                     Msg = "<div id='errorMsjNvaCta' class='alert alert-warning'><strong>" +response.mensaje +" </strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                       $("#errorMsjNvaCta").html(Msg);
                       $('#errorMsjNvaCta').delay(3000).fadeOut('slow');
                  }else{
                      Msg = "<div id='errorMsjNvaCta' class='alert alert-success'><strong>Número de cuenta agregada correctamente</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                      traecuentasbancarias();
                       $("#errorMsjNvaCta").html(Msg);
                       $('#errorMsjNvaCta').delay(3000).fadeOut('slow');
                         $("#txtNuevaCuenta").val("");
                          $("#txtNuevaCuenta").removeAttr("style"); 
                  
                  }
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
          });
 
  

 }


  function traecuentasbancarias() {
     var valorselector=$("#selbanconuevacuenta").val();
        $("#datoscuentasbancarias").empty();
          $.ajax({
              type: "POST",
              url: "ajax_guardacuentabancaria.php",
              data:{"accion":1,"valorselector":valorselector,"cuenta":0},
              dataType: "json",
              success: function(response) {
                  //console.log(response);
                 if (response.status == "success") {
                      var mensaje = response.message;
                      var datos = response.bancos;
                      var tabla = "<table id='tablacuentasbancarias' class='table table-bordered'><thead><th>N°</th><th>Número Cuenta</th></thead><tbody>";
                      $(document).scrollTop(0);
                      $.each(datos, function(i) {
                          tabla += "<tr><td > " + (i + 1) + " </td>";
                          tabla += "<td><input id='inpcuentabancaria" + i + "' type='text' readonly='true' value='" + datos[i].numCuenta + "'></td>";
                         
                      });
                      $("#datoscuentasbancarias").append(tabla);
                  } else {
                      var mensaje = response.message;
                  }
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
          });
      }



function cargaerrores(identificador,mensaje){
 var Msgerror = "<div id='errorMsjNvaCta' class='alert alert-danger'><strong  class='text-justify'>"+mensaje+"</strong>  <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
          $("#errorMsjNvaCta").html(Msgerror);
          $("#"+identificador).css('border', '#D0021B 1px solid');
          $(document).scrollTop(0);

}


function limpiaerrores(){
  $("#selbanconuevacuenta").removeAttr("style"); 
  $("#txtNuevaCuenta").removeAttr("style"); 
  $("#errorMsjNvaCta").removeClass('alert alert-danger').html('');  
}


   </script>
 }
