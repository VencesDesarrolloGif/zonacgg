<?php
//$log = new KLogger ( "BANCOS.log" , KLogger::DEBUG );
  if ($usuario["rol"] == "Finanzas" || $usuario["rol"] == "Tesoreria") {
      $listabancosnuevacuenta   = $negocio->negocio_ListaBancos();
  //$log->LogInfo("Valor de listabancos" . var_export ($listabancos, true));
  }
?> 
<div id="msg"></div>
<form class="form-inline"  method="post" name='form_abonocaja' id="form_abonocaja" enctype="multipart/form-data">
  <div align="center">
    <div class="card border-primary mb-3" style="max-width: 100rem;border-style: double;"> <br>  
      
      <div class="row">
        <label class="control-label label " for="numeroEmpleado">N° Empleado</label> 
        <input type="text" name="txtBusqueda" id="txtBusqueda"class="search-query" placeholder="Buscar  (00-0000-00)" aria-describedby="basic-addon2" onkeyup="verificaEmpleado();" ><img src="img/search.png">
      </div><br><br>
      <div class="row">
              <label class="control-label label " for="numeroEmpleado">N° Empleado</label> 
              <input id="entidadEmpleado" name="entidadEmpleado" type="text" placeholder="00" class="input-mini-mini" maxlength="2" readonly>-
              <input id="ConsecutivoEmpleado" name="ConsecutivoEmpleado" type="text" placeholder="0000" class="input-small-mini" maxlength="4" readonly>
              <input id="CategoriaEmpleado" name="CategoriaEmpleado" type="text" placeholder="00" class="input-mini-mini" maxlength="2" readonly>  
      </div><br>
      <div class="row">
        <label class="control-label label" >Nombre</label>
        <input class="span5"  id="nombreEmp" name="nombreEmp" type="text"  readonly> 
        <label class="control-label label" >Apellido Paterno</label>
        <input class="span5"  id="apellidopaternoempleado" name="apellidopaternoempleado" type="text" readonly> 
        <label class="control-label label">Apellido Materno</label>
        <input  class="span5" id="apellidomaternoempleado" name="apellidomaternoempleado" type="text" readonly>   
      </div><br>
        <div class="row">
          <label class="control-label label" >Puesto</label>
        <input class="span4"  id="puesto" name="puesto" type="text"  readonly> 
          <label class="control-label label" >Unidad de negocio</label>
        <input class="span3"  id="unidadnegocio" name="unidadnegocio" type="text"  readonly> 
        <label class="control-label label" >Banco</label>
        <input class="span3"  id="banco" name="banco" type="text"  readonly> 
        <label class="control-label label" >Cuenta</label>
        <input class="span3"  id="cuenta" name="cuenta" type="text" readonly>   
      </div><br><br>      
      <div id="descargaarchivos" style="margin-left: 64%;cursor: pointer;display: none"> <a id="descragaDocumentos">Descargar Formatos.</a></div><br>
      <div class="row">
        <label class="control-label label" for="docuaAbono[]">Selecciona archivo: </label>
            <span class="btn btn-success btn-file" >Examinar
              <input type='file' class='btn-success' id='docuaAbono' name='docuaAbono[]' multiple="" accept=".pdf" /> 
            </span>
            <button type="button" class="btn btn-primary" onclick="guardarAbonoCaja()">Cargar</button> 
      </div><br>
    </div>
  </div>   
</form>

<!--
   <div class="row-fluid">
  <div class="span4"> 
    <label class="control-label label">Apellido Materno</label> 

    <input  id="apellidomaternoempleado" name="apellidomaternoempleado" type="text" readonly>   
  </div>
  <div class="span4">
    <label class="control-label label">Apellido Materno</label> 
    <input  class="span5" id="apellidomaternoempleado" name="apellidomaternoempleado" type="text" readonly>   
  </div>
   <div class="span4">
    <label class="control-label label span3">Apellido Materretetwtwweweeqeeeee</label> 
    <input  class="span5" id="apellidomaternoempleado" name="apellidomaternoempleado" type="text" readonly>   
  </div>
</div>

-->
<script type="text/javascript">
    function verificaEmpleado(){
      var txtSearch = $("#txtBusqueda").val ();
      var expreg = /^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/;
      if (txtSearch.length != 10)
        {return;}
      if(expreg.test(txtSearch))
      {
        var numeroEmpleado = $("#txtBusqueda").val();
        consultaTraeEmpleado(numeroEmpleado);
         $("#msg").html("");
      }/*else{
       alertMsg1="<div class='alert alert-block' id='msg'>No existe número de empleado<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#msg").html(alertMsg1);
            $("#form_abonocaja")[0].reset();
            $("#descargaarchivos").hide();
      }*/
    }
    function consultaTraeEmpleado (numeroEmpleado){
        var numeroEmpleado1 = numeroEmpleado;
     $.ajax({   
                type: "POST",
                url: "ajax_obtenerEmpleadoPorId.php",
                data:{"numeroEmpleado":numeroEmpleado1},
                dataType: "json",
                 success: function(response) {
                    //console.log(response);
                if(response.empleado[0]==null ){
                    alertMsg1="<div class='alert alert-error' id='msg'>No existe número de empleado<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#msg").html(alertMsg1);
                    $("#form_abonocaja")[0].reset();
                    $("#descargaarchivos").hide();
                }else{
                    $("#entidadEmpleado").val(response.empleado[0].entidadFederativaId);
                    $("#ConsecutivoEmpleado").val(response.empleado[0].empleadoConsecutivoId);
                    $("#CategoriaEmpleado").val(response.empleado[0].idTipoPuesto);
                    $("#nombreEmp").val(response.empleado[0].nombreEmpleado);
                    $("#apellidopaternoempleado").val(response.empleado[0].apellidoPaterno);
                    $("#apellidomaternoempleado").val(response.empleado[0].apellidoMaterno);
                    $("#cuenta").val(response.empleado[0].numeroCta);
                    $("#puesto").val(response.empleado[0].descripcionPuesto);
                    $("#banco").val(response.empleado[0].nombreBanco);
                    $("#unidadnegocio").val(response.empleado[0].descripcionLineaNegocio);
                    var cuentaclabe=response.empleado[0].numeroCtaClabe;  
                    var lineanegocio= response.empleado[0].empleadoLineaNegocioId; 
                    $("#descargaarchivos").show();    
                    // consultabancoporctaclave(cuentaclabe,lineanegocio); 
                  }              
                  },
                //si ha ocurrido un error
                error: function(jqXHR, textStatus, errorThrown){
                      alert(jqXHR.responseText); 
                }
            });
    }


    function consultabancoporctaclave(cuentaclabe,lineanegocio){
      $.ajax({  
                  type: "POST",
                  url: "ajax_obtenerLineanegocioybanco.php",
                  data:{"cuentaclabe":cuentaclabe,"lineanegocio":lineanegocio},
                  dataType: "json",
                   success: function(response) {
                      //console.log(response);
                      
                     var  a=count(response.datos);
                     // alert(a);
                      
                     var banco=response.datos.bancos.nombreBanco;

                      var lineanegocio=response.datos.lineanegocio.descripcionLineaNegocio;

                      //console.log(banco);
                      $("#unidadnegocio").val(lineanegocio);         
                      $("#banco").val(banco);
                    },
                  //si ha ocurrido un error
                  error: function(jqXHR, textStatus, errorThrown){
                        alert(jqXHR.responseText); 

                  }
              });
    }


  function guardarAbonoCaja(){

      //alert("entidad: "+entidad+" CLIENTE: "+cliente);
      var entidademp=$("#entidadEmpleado").val();
      var consecutivo=$("#ConsecutivoEmpleado").val();
      var categoriaemp=$("#CategoriaEmpleado").val();
      var inpfile=$("#docuaAbono").val();
      if(entidademp=="" || consecutivo=="" ){
          alertMsg1="<div class='alert alert-error' id='msg'>Por favor ingrese un número de empleado<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#msg").html(alertMsg1);
        $("#form_abonocaja")[0].reset();
        return ;
      }
      if(inpfile==""){
          alertMsg1="<div class='alert alert-error' id='msg'>Por favor selecciona un archivo<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#msg").html(alertMsg1);
             return ;
      }       
      //información del formulario
        var formData = new FormData($("#form_abonocaja")[0]); 
        formData.append('entidademp', entidademp);                          
         formData.append('consecutivo', consecutivo);
          formData.append('categoriaemp', categoriaemp);
        //var message = ""; 
        //hacemos la petición ajax  
        for (var value of formData.values()) {
              //console.log(value); 
        }     
        alert("1");  
        $.ajax({
            type: "POST",
            url: "upload_ResponsivaCaja.php",
            data:formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,        
            //una vez finalizado correctamente
            success: function(response){   
            console.log(response); 
              var msj=response.message; 
                    if(response.status=='success'){
                  alertMsg1="<div id='msg' class='alert alert-success'><strong>Archivo subido correctamente </strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                     $("#form_abonocaja")[0].reset(); 
                      $("#msg").html(alertMsg1); 
                      $("#descargaarchivos").hide();                   
                      //$('#msg').delay(2000).fadeOut('slow');                
                }else{
                    alertMsg1="<div id='msg' class='alert alert-error'><strong>"+msj+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                     $("#form_abonocaja")[0].reset(); 
                      $("#msg").html(alertMsg1); 
                      $("#descargaarchivos").hide();                   
                      //$('#msg').delay(2000).fadeOut('slow');         
                }                              
            },
            //si ha ocurrido un error
            error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText); 
            }
        });   
  }
  $("#descragaDocumentos").click(function(){
        var nombreemp=$("#nombreEmp").val();
        var ape1=$("#apellidopaternoempleado").val();
        var ape2=$("#apellidomaternoempleado").val();
        var nombreempleado=(nombreemp+" "+ape1+" "+ape2);
        var puesto=$("#puesto").val();
        var numcuenta=$("#cuenta").val();
        var banco= $("#banco").val();   
        var lineanegocio= $("#unidadnegocio").val();   
        window.open("generadordoccobranza.php?nombreempleado=" + nombreempleado + "&" + "puesto=" + puesto + "&" + "numcuenta=" + numcuenta  + "&" + "banco=" + banco+ "&" + "lineanegocio=" + lineanegocio , 'Responsiva', 'fullscreen=no');
  });
</script>
 
