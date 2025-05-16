
<?php
require_once ("../Negocio/Negocio.class.php");
$negocio = new negocio ();
//$listaBancos= $negocio -> negocio_ListaBancos();
$fechaActual= $negocio -> negocio_consultaFecha();
//$log = new KLogger ( "vistaFechaActual.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de fechaActual " . var_export ($fechaActual, true));
?>

<form id='form_RegistroSaldosIniciales' class="form-horizontal">
<fieldset>
<!-- Form Name -->
<legend>REGISTRO DE SALDOS INICALES 
	<input id="txtFechaActual" name="txtFechaActual" type="text"  class="input-medium" readonly value= <?php echo $fechaActual['0']["fechaActual"]; ?>>
</legend>
<!-- Text input-->
<div  id="bancos" class="control-group">
</div>


<div  id="detallecuentas" style='display: none'>
</div>
</fieldset>
</form>


<script type="text/javascript">

var rolUsuario="<?php echo $usuario['rol']; ?>";

$(inicioRegSueldoIni());  

function inicioRegSueldoIni(){
    if (rolUsuario=="Tesoreria" || rolUsuario=="Finanzas"){
        obtenerListaBancos();
    }
}

function  detallecuentasporbanco(idbanco){
$("#detallecuentas").show();
$.ajax({ 
            type: "POST",
            url: "ajax_ObtenerListaBancos.php",
            dataType: "json",
            data:{"accion":1,"idbanco":idbanco},
            success: function(response) {
               // console.log(response);
                if (response.status == "success")
                {
                    var listacuentasbancarias = response.listacuentasbancarias;
                    listacuentastable="<table class='table table-hover'><thead><th>N° Cuenta</th><th>Saldo</th></thead><tbody>";
                    for ( var i = 0; i < listacuentasbancarias.length; i++ ){

                        var cuenta = listacuentasbancarias[i].cuenta;

                        var saldo1 = listacuentasbancarias[i].saldo; 
                        if(saldo1 % 1 !=0){
                           var saldo= saldo1;
                        }else{
                              var saldo= Number.parseFloat(saldo1).toFixed(2);
                        }

                        listacuentastable += "<tr><td>"+cuenta+" </td><td style='text-align:right;'>"+saldo+"</td></tr>";   
                    }
                    listacuentastable += "</tbody></table>";
                    $('#detallecuentas').html(listacuentastable); 
                    obtenerListaBancos();
                }
                else if (response.status == "error" && response.message == "No autorizado")
                {
                    window.location = "login.php";
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
            }
        });
}


function obtenerSaldosInicialesCargo(listabancos)
    {
        //console.log("ddd",listabancos)
      $.ajax({
            
            type: "POST",
            url: "ajax_obtieneSaldosIniciales.php",
            dataType: "json",
            data:{"listabancos":listabancos},
            success: function(response) {
               // console.log(response);
                var listacargos=response.listaSaldosIniciales;
                for(var i=0; i<listacargos.length;i++){


                    var cargo1= listacargos[i].cargo;
                    if(cargo1 % 1 !=0){
                       var cargo= cargo1;
                       $("#cargoinicial"+(i+1)).val(cargo);
                    }else{
                          var cargo= Number.parseFloat(cargo1).toFixed(2);
                          $("#cargoinicial"+(i+1)).val(cargo);
                    }

                    var abono1= listacargos[i].abono;
                    if(abono1 % 1 !=0){
                       var abono= abono1;
                       $("#abono"+(i+1)).val(abono);
                    }else{
                          var abono= Number.parseFloat(abono1).toFixed(2);
                          $("#abono"+(i+1)).val(abono);
                    }

                    var saldo1= listacargos[i].saldo;
                    if(saldo1 % 1 !=0){
                       var saldo= saldo1;
                       $("#saldo"+(i+1)).val(saldo);
                    }else{
                          var saldo= Number.parseFloat(saldo1).toFixed(2);
                          $("#saldo"+(i+1)).val(saldo);
                    }

                    // $("#abono"+(i+1)).val(listacargos[i].abono);
                    // $("#saldo"+(i+1)).val(listacargos[i].saldo);
                }
               
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
            }
        });
    }
    function obtenerListaBancos()
    {
      $.ajax({  
            type: "POST",
            url: "ajax_ObtenerListaBancos.php",
            dataType: "json",
            data:{"accion":0,"idbanco":0},
            success: function(response) {
                if (response.status == "success")
                {
                    var listaBancos = response.listaBancos;
                    listaBancosTable="<table class='table table-hover'><thead><th>#</th><th>Banco</th><th>Cargo</th><th>Abono</th><th>Saldo</th></thead><tbody>";
                    for ( var i = 0; i < listaBancos.length; i++ ){
                        var idBanco = listaBancos[i].idBanco;
                        var nombreBanco = listaBancos[i].nombreBanco; 
                        listaBancosTable += "<tr><td>"+idBanco+" </td><td>"+nombreBanco+"</td><td><input id='cargoinicial" + idBanco + "' type='text' readonly='true' class='input-medium'style='text-align:right;'></td><td><input id='abono" + idBanco + "' type='text' readonly='true' class='input-medium'style='text-align:right;'></td><td><input id='saldo" + idBanco + "' type='text' readonly='true' class='input-medium'style='text-align:right;'></td><td><button id='btnregistrarSalida' name='guardar'  type='button' title='Detalle Saldos por cuentas' onclick='detallecuentasporbanco(\""+idBanco+"\");'><span class='glyphicon glyphicon-list-alt'></span></button></td></tr>";
                       
                    }
 
                    listaBancosTable += "</tbody></table>";
                    $('#bancos').html(listaBancosTable); 
                   obtenerSaldosInicialesCargo(listaBancos);//funcion que se encuentra en usuario logeado                    
                }
                else if (response.status == "error" && response.message == "No autorizado")
                {
                    window.location = "login.php";
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
            }
        });
    }  
</script>




