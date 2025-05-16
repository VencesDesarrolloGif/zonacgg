<?php
//$log = new KLogger ( "BANCOS.log" , KLogger::DEBUG );
  if ($usuario["rol"] == "Finanzas" || $usuario["rol"] == "Tesoreria") {
      $listabancos   = $negocio->negocio_ListaBancos();
  //$log->LogInfo("Valor de listabancos" . var_export ($listabancos, true));
  }
?>  
<center><div id="errorMsj" name="errorMsj"> </div></center>
   
      <center><h3>Banco Origen</h3></center>
        <section>
          <center>
            <div>
              <select id="selbancoOrigen" name="selbancoOrigen" class="input-large ">
                <option value="0">BANCO</option>
                   <?php
                    for ($i = 0; $i < count($listabancos); $i++){
                     echo "<option value='" . $listabancos[$i]["idBanco"] . "'>" . $listabancos[$i]["nombreBanco"] . " </option>";
                    }
                   ?>
              </select>&nbsp&nbsp&nbsp&nbsp
              <select id="selnumcuentaOrigen" name="selnumcuentaOrigen" class="input-large">  
              </select>&nbsp&nbsp&nbsp&nbsp
              <input type="text" id="saldoDisponibleOrigen" name="saldoDisponibleOrigen" readonly style='text-align:right;'>
            </div><br>
             <center><h3>Banco Destino</h3></center> 
             <div>
              <select id="selBancoDestino" name="selBancoDestino" class="input-large">
              <option value="0">BANCO</option>
                   <?php
                    for ($i = 0; $i < count($listabancos); $i++){
                     echo "<option value='" . $listabancos[$i]["idBanco"] . "'>" . $listabancos[$i]["nombreBanco"] . " </option>";
                    }
                   ?> 
              </select>&nbsp&nbsp&nbsp&nbsp
              <select id="selnumCuentaDestino" name="selnumCuentaDestino" class="input-large">                   
              </select>&nbsp&nbsp&nbsp&nbsp
              <input type="text" id="saldoDestino" name="saldoDestino" style='text-align:right;'>
            </div>
            <center><h3>Folio De Transacción</h3></center> 
            <div>
                  <input class="span3" id="numeroFolio" name="numeroFolio" type="text" >           
              </div><br>
            <div><button id="guardar" name="guardar" class="btn btn-primary" type="button" onclick="guardartransferencia();"> <span class="glyphicon glyphicon-floppy-save"></span>Guardar</button></div>
          </center>
        </section>
  
<script type="text/javascript">
$("#selbancoOrigen").change(function(){
  var idbancoOrigen=$("#selbancoOrigen").val();
  if(idbancoOrigen!=0){
    llenaselectores(1,idbancoOrigen);
    $('#saldoDisponibleOrigen').val(" ");
  }else{
    $('#selnumcuentaOrigen').empty().append('<option value="0" selected="selected">Cuenta</option>');
    $('#saldoDisponibleOrigen').val(" ");

  }
});
$("#selBancoDestino").change(function(){
  var idBancoDestino=$("#selBancoDestino").val();
  if(idBancoDestino!=0){
    llenaselectores(2,idBancoDestino);
    $('#saldoDestino').val("");
  }else{
    $('#selnumCuentaDestino').empty().append('<option value="0" selected="selected">Cuenta</option>');
    $('#saldoDestino').val("");
  }
});
$("#selnumcuentaOrigen").change(function(){
  var idNumCuentaOrigen=$("#selnumcuentaOrigen").val();
  var idbancoOrigen=$("#selbancoOrigen").val();
  if(idNumCuentaOrigen!=0){
    llenarMontoDeCuentaOrigen(1,idbancoOrigen,idNumCuentaOrigen);
    $('#saldoDestino').val("");
  }else{
    $('#saldoDestino').val("");
  }
});

$("#saldoDestino").change(function(){
  var saldoDestino1=$("#saldoDestino").val();

  if(saldoDestino1 % 1 !=0){
     var saldoDestino= saldoDestino1;
     $("#saldoDestino").val(saldoDestino);
  }else{
        var saldoDestino= Number.parseFloat(saldoDestino1).toFixed(2);
        $("#saldoDestino").val(saldoDestino);
  }
});


function llenaselectores(accion,idBanco){
  $.ajax({
    type: "POST",
    url: "ajax_llenaselectoresbancoorigendestino.php",
    data:{"accion":accion,"idBanco":idBanco},
    dataType: "json",
    success: function(response) {
           console.log(response); 
        if(accion==1){
          $('#selnumcuentaOrigen').empty().append('<option value="0" selected="selected">CUENTA</option>');
          for(var i=0; i<response.datos.length;i++){
            $('#selnumcuentaOrigen').append('<option value="' + response.datos[i].cuentas.idCuentaBancaria+ '">' + response.datos[i].cuentas.numCuenta +'</option>');
          }
        }else if(accion==2){
          $('#selnumCuentaDestino').empty().append('<option value="0" selected="selected">CUENTA</option>');
          for(var i=0; i<response.datos.length;i++){
            $('#selnumCuentaDestino').append('<option value="' + response.datos[i].cuentas.idCuentaBancaria+ '">' + response.datos[i].cuentas.numCuenta +'</option>');
          }
        }
    },error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
  });
}
function llenarMontoDeCuentaOrigen(accion,idbanco,idnumcuenta){
      $.ajax({ 
            type: "POST",
            url: "ajax_obtenertotaldisponible.php",
            dataType: "json",
            data:{"idbanco":idbanco,"idnumcuenta":idnumcuenta,"accion":accion},
            success: function(response) {
              //console.log(response);
                if(response.datos.length>0){
                  var saldoDisponibleFin1 =response.datos[0].saldoDisponibleFin;

                  if(saldoDisponibleFin1 % 1 !=0){
                     var saldoDisponibleFin= saldoDisponibleFin1;
                  }else{
                        var saldoDisponibleFin= Number.parseFloat(saldoDisponibleFin1).toFixed(2);
                  }

                }else{
                  saldoDisponibleFin="0.00";
                }
                if(accion==1){
                $("#saldoDisponibleOrigen").val(saldoDisponibleFin);
               }      
            },error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
              }
      });
    }

function guardartransferencia()

{
  var selbancoOrigen = $("#selbancoOrigen").val();
  var selnumcuentaOrigen = $("#selnumcuentaOrigen").val(); 
  var saldoDisponibleOrigen = $("#saldoDisponibleOrigen").val(); 
  var selBancoDestino = $("#selBancoDestino").val(); 
  var selnumCuentaDestino = $("#selnumCuentaDestino").val(); 
  var saldoDestino = $("#saldoDestino").val();
  var numeroFolio = $("#numeroFolio").val();  
      $.ajax({
            type: "POST",
            url: "ajax_registrartransferencia.php",
            data:{"selbancoOrigen":selbancoOrigen,"selnumcuentaOrigen":selnumcuentaOrigen,"saldoDisponibleOrigen":saldoDisponibleOrigen,
            "selBancoDestino":selBancoDestino,"selnumCuentaDestino":selnumCuentaDestino,"saldoDestino":saldoDestino,"numeroFolio":numeroFolio},
            dataType: "json",
            success: function(response) { 
              var estatus=response.status;
              var mensaje=response.message;
              showMessage (mensaje, response.status);
              if(estatus!="error"){

              $("#selbancoOrigen").val("0");
              $('#selnumcuentaOrigen').empty().append('<option value="0" selected="selected">Cuenta</option>');
              $('#saldoDisponibleOrigen').val("");
              $("#selBancoDestino").val("0");
              $('#selnumCuentaDestino').empty().append('<option value="0" selected="selected">Cuenta</option>');
              $('#saldoDestino').val("");
              $('#numeroFolio').val("");
          }

            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
            }
      });
}




   </script>

