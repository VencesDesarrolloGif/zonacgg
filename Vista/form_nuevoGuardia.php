<?php
$catalogoEntidadesF= $negocio -> negocio_obtenerListaEntidadesFeferativas();
$catalogoTipoSangre= $negocio -> negocio_obtenerListaTipoSangre();
$catalogoGradoEstudios=$negocio -> negocio_obtenerListaGradoEstudios();
?>

<div class="container" align="center">

<form class="form-horizontal"  method="post" id="form_registroPreseleccion" name="form_registroPreseleccion" target="_blank">
	<fieldset >        
    	<center><h2>Solicitud Empleado</h2></center>
  	</fieldset>
    <div id="msginformativo"></div>        
        <input id="txtFolioSolicitud" name="txtFolioSolicitud" type="hidden" class="input-mini" >    
        <br>        
        <br>    
        <table id="tblhaslaborado">
          <tr><td ><h4><u style="color: #3b5998">¿HAS LABORADO ANTERIORMENTE CON NOSOTROS?</u>
              <span style="margin-left: 2%;">No</span>  
              <span style="margin-left:2%;">Si</span>    
              <div style="margin-right:4%;margin-bottom: 2%;margin-top: 1%" class="material-switch pull-right">
                    <input id="checklaborado" name="checklaborado" type="checkbox" />
                    <label for="checklaborado" class="label-success1"></label>
              </div> </h4>  
            </td>
            </tr>
        </table> 

<table id="tblcriteriosdebusqueda" style="display: none" >  

            <tr>
              <td><label class=" control-label label " for="busquedacurp">CURP</label><span  class="glyphicon glyphicon-info-sign" data-toggle="tooltip" title="INGRESE CURP O N° AFILIACIÓN IMSS,LUEGO PRESIONE BOTON BUSCAR"></span>
  <br>   
              <input id="busquedacurp" name="busquedacurp" type="text" class="input-large"> </td>

              <td><label class=" control-label label " for="numimss">N° AFILIACIÓN IMSS</label><span class="glyphicon glyphicon-info-sign" data-toggle="tooltip" title="INGRESE CURP O N° AFILIACIÓN IMSS,LUEGO PRESIONE BOTON BUSCAR"></span><br>   
              <input id="busquedanumimss" name="busquedanumimss" type="text" class="input-large"> </td>

<td>
           <img id="btnbuscar" style="margin-top: 100%;margin-left: 70%;cursor: pointer"src="img/search.png" title="BUSCAR">
            </td>
            </tr>
</table>

<input id="numempleadopreseleccion" name="numempleadopreseleccion" type="hidden" class="input-large">
<input id="folioempleadopreseleccion" name="folioempleadopreseleccion" type="hidden" class="input-large">
  	<table id="tablesolicitudEmpleo" class="table1" border="3">
      
  		<tr>
  			<td>
  				<table style="table-layout:fixed;" width="1600px">
  					<tr><td colspan="2"><center><h4><u style="color: #369C1C">DATOS PERSONALES</u></h4></center></td>
  					</tr>                     
  					<tr>
              <td><label class=" control-label label " for="empPuesto">PUESTO QUE SOLICITA:</label><br>   
              <input id="empPuesto" name="empPuesto" type="text" class="input-large"> </td>

  						<td><label class=" control-label label " for="empApPaterno">APELLIDO PATERNO:</label><br>   
  						<input id="empApPaterno" name="empApPaterno" type="text" class="input-large"> </td>

  						<td><label class=" control-label label " for="empApMaterno">APELLIDO MATERNO:</label><br>   
  						<input id="empApMaterno" name="empApMaterno" type="text" class="input-large"> </td>

  						<td><label class=" control-label label " for="empNombre">NOMBRE (S):</label><br>   
  						<input id="empNombre" name="empNombre" type="text" class="input-large"> </td>

  						<td><label class=" control-label label " for="empEdad">EDAD:</label><br>     
              <input style="margin-right: 120px; margin-left: 110px" id="empEdad" name="empEdad" type="text" class="input-mini"></td>
  						
  					</tr>
            <tr>

                <td><label class=" control-label label " for="empPeso">PESO:</label><br>     
              <input style="margin-right: 120px; margin-left: 110px" id="empPeso" name="empPeso" type="text" class="input-mini"></td>

              <td><label class=" control-label label " for="empEstatura">ESTATURA:</label><br>     
              <input style="margin-right: 120px; margin-left: 110px" id="empEstatura" name="empEstatura" type="text" class="input-mini"></td>

              <td><label class=" control-label label " for="empTallaCamisa">TALLA CAMISA:</label><br>     
              <input style="margin-right: 120px; margin-left: 110px" id="empTallaCamisa" name="empTallaCamisa" type="text" class="input-mini"></td>

              <td><label class=" control-label label " for="empTallaPantalon">TALLA PANTALON:</label><br>     
              <input style="margin-right: 120px; margin-left: 110px" id="empTallaPantalon" name="empTallaPantalon" type="text" class="input-mini"></td>

              <td><label class=" control-label label " for="empNumCalzado">NUM CALZADO:</label><br>     
              <input style="margin-right: 120px; margin-left: 110px" id="empNumCalzado" name="empNumCalzado" type="text" class="input-mini"></td>

            </tr>

            <tr>

              <td><label class=" control-label label " for="selectEmpCivil">ESTADO CIVIL:</label><br>   
              <select id="selectEmpCivil" name="selectEmpCivil" class="input-large"> 
                <option value="">ESTADO CIVIL</option>
                <option value="1">SOLTERO (A)</option>
                <option value="2">CASADO (A)</option>
                <option value="3">VIUDO (A)</option>
                <option value="4">DIVORCIADO (A)</option>
                <option value="5">UNION LIBRE</option>
              </select> </td>
              
              <td><label class=" control-label label " for="selectEmpSexo">GENERO:</label><br>   
              <select id="selectEmpSexo" name="selectEmpSexo" class="input-medium"> 
                <option value="">GENERO</option>
                    <option value="1">FEMENINO</option>
                    <option value="2">MASCULINO</option>
              </select> </td>

              <td><label class=" control-label label " for="selectEmpTipoSangre">TIPO SANGRE:</label><br>   
              <select id="selectEmpTipoSangre" name="selectEmpTipoSangre" class="input-medium"> 
                <option value="">TIPO SANGRE</option>
                        <?php
                      for ($i=0; $i<count($catalogoTipoSangre); $i++)
                      {
                        echo "<option value='". $catalogoTipoSangre[$i]["idTipoSangre"]."'>". $catalogoTipoSangre[$i]["tipoSangre"] ." </option>";
                      }
                      ?>
              </select> </td>

              <td><label class=" control-label label " for="empFechaNac">FECHA NACIMIENTO:</label><br>   
              <input class="input-medium" id="empFechaNac" name="empFechaNac" type="date"> </td>

              <td><label class=" control-label label " for="selectEmpEntidad">ESTADO NACIMIENTO:</label><br>   
              <select id="selectEmpEntidad" name="selectEmpEntidad" class="input-large"> 
                <option value="">ESTADO</option>
                        <?php
                      for ($i=0; $i<count($catalogoEntidadesF); $i++)
                      {
                        echo "<option value='". $catalogoEntidadesF[$i]["idEntidadFederativa"]."'>". $catalogoEntidadesF[$i]["nombreEntidadFederativa"] ." </option>";
                      }
                      ?>
              </select> </td>            

            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td>
          <table style="table-layout:fixed;" width="1600px">
            <tr ><td colspan="2"><center><h4><u style="color: #369C1C">DATOS DE DOMICILIO</u></h4></center></td>
            </tr>
            <tr>
              

              <td><label class=" control-label label " for="empCodPostal">C.P.:</label><br>     
              <input style="margin-right: 120px; margin-left: 110px" id="empCodPostal" name="empCodPostal" type="text" class="input-mini"></td>
              

              <td><label class=" control-label label " for="empCalle">CALLE:</label><br>   
              <input id="empCalle" name="empCalle" type="text" class="input-large"> </td>

              <td><label class=" control-label label " for="empNumeroC">NUMERO:</label><br>     
              <input style="margin-right: 120px; margin-left: 110px" id="empNumeroC" name="empNumeroC" type="text" class="input-mini"></td>

              <td><label class=" control-label label " for="empColonia">COLONIA:</label><br>   
              <input id="empColonia" name="empColonia" type="text" class="input-large"> </td>

              <td><label class=" control-label label " for="empMunicipio">DELEGACION O MUNICIPIO:</label><br>   
              <input id="empMunicipio" name="empMunicipio" type="text" class="input-large"> </td>

            </tr>
  					<tr>  						  						
  						  						

  						<td><label class=" control-label label " for="empCiudad">CIUDAD:</label><br>   
  						<input id="empCiudad" name="empCiudad" type="text" class="input-large"> </td>

              <td><label class=" control-label label " for="empTelFijo">TEL. FIJO:</label><br>   
              <input id="empTelFijo" name="empTelFijo" type="text" class="input-large"> </td>

              <td><label class=" control-label label " for="empTelMovil">TEL. MOVIL:</label><br>   
              <input id="empTelMovil" name="empTelMovil" type="text" class="input-large"> </td>

               <td><label class=" control-label label " for="empEmail">EMAIL:</label><br>   
              <input id="empEmail" name="empEmail" type="email"> </td>

  					</tr>
          </table>
        </td>
      </tr>
      <tr>
        <td>
          <table style="table-layout:fixed;" width="1600px">
  					<tr ><td colspan="2"><center><h4><u style="color: #369C1C">DATOS DE AFILIACIONES</u></h4></center></td>
            </tr>
  					<tr>
  						<td><label class=" control-label label " for="checkEmpInfonavit">INFONAVIT:</label><br><br>
              <div style="margin-right: 120px; margin-left: 110px" class="material-switch pull-right">
                    <input id="checkEmpInfonavit" name="checkEmpInfonavit" type="checkbox" />
                    <label for="checkEmpInfonavit" class="label-success1"></label>
              </div>            
                <br></td>	

                <td><label class=" control-label label " for="checkEmpFonacot">FONACOT:</label><br><br>
              <div style="margin-right: 120px; margin-left: 110px" class="material-switch pull-right">
                    <input id="checkEmpFonacot" name="checkEmpFonacot" type="checkbox" />
                    <label for="checkEmpFonacot" class="label-success1"></label>
              </div>            
                <br></td> 		

                 <td><label class=" control-label label " for="checkEmpCartilla">CARTILLA LIBERADA:</label><br><br>
              <div style="margin-right: 120px; margin-left: 110px" class="material-switch pull-right">
                    <input id="checkEmpCartilla" name="checkEmpCartilla" type="checkbox" />
                    <label for="checkEmpCartilla" class="label-success1"></label>
              </div>            
                <br></td> 		

                <td><label class=" control-label label " for="checkEmpLicencia">LICENCIA:</label><br><br>
              <div style="margin-right: 120px; margin-left: 110px" class="material-switch pull-right">
                    <input id="checkEmpLicencia" name="checkEmpLicencia" type="checkbox" />
                    <label for="checkEmpLicencia" class="label-success1"></label>
              </div>            
                <br></td>	 

                <td id="tdnumlicenciaprecontratapermanente" style="display: none"><label class=" control-label label " for="checkEmpLicenciaPermanente">PERMANENETE:</label><br><br>
              <div style="margin-right: 120px; margin-left: 110px" class="material-switch pull-right">
                    <input id="checkEmpLicenciaPermanente" name="checkEmpLicenciaPermanente" type="checkbox" />
                    <label for="checkEmpLicenciaPermanente" class="label-success1"></label>
              </div>            
                <br></td> 


                <td id="tdnumlicenciaprecontrata" style="display: none"><label class=" control-label label " for="numLicenciaPreseleccion">No LICENCIA:</label>  <br>  
              <input id="numLicenciaPreseleccion" name="numLicenciaPreseleccion" type="text" class="input-large" maxlength="20"> </td>
                <td id="tdfechavigencialicencia" style="display: none"><label class=" control-label label " for="fechavigencialicencia">VIGENCIA DE LICENCIA:</label> 
                  <input style="margin-left: 13.5%" id="fechavigencialicencia" name="fechavigencialicencia" type="date" class="input-medium" /> </td>
              <td><label class=" control-label label " for="empImss">No AFILIACIÓN IMSS:</label> 
              <input id="empImss" name="empImss" type="text" class="input-large" maxlength="11"> </td>

  					</tr> 
            </table>
        </td>
      </tr>
      <tr>
        <td> 
          <table style="table-layout:fixed;" width="1600px">            
            <tr ><td colspan="2"><center><h4><u style="color: #369C1C">DATOS LABORALES Y ACADEMICOS</u></h4></center></td>
            </tr>
            <tr>              

              <td><label class=" control-label label " for="empNombreUE">NOMBRE ULTIMA EMPRESA:</label><br>   
              <input id="empNombreUE" name="empNombreUE" type="text" class="input-large"> </td>

              <td><label class=" control-label label " for="empFecha1E1">DESDE:</label><br>   
              <input class="input-medium" id="empFecha1E1" name="empFecha1E1" type="date"> </td>

              <td><label class=" control-label label " for="empFecha2E1">HASTA:</label><br>   
              <input class="input-medium" id="empFecha2E1" name="empFecha2E1" type="date"> </td>

              <td><label class=" control-label label " for="empTelE1">TELEFONO:</label><br>   
              <input id="empTelE1" name="empTelE1" type="text" class="input-large"> </td>

              <td><label class=" control-label label " for="empCausaSepE1">CAUSA SEPARACION:</label><br>   
              <input id="empCausaSepE1" name="empCausaSepE1" type="text" class="input-xlarge" maxlength="20"> </td>
            </tr>
            <tr>              
              <td><label class=" control-label label " for="empNombreEA">NOMBRE EMPRESA ANTERIOR:</label><br>   
              <input id="empNombreEA" name="empNombreEA" type="text" class="input-large"> </td>

              <td><label class=" control-label label " for="empFecha1E2">DESDE:</label><br>   
              <input class="input-medium" id="empFecha1E2" name="empFecha1E2" type="date"> </td>

              <td><label class=" control-label label " for="empFecha2E2">HASTA:</label><br>   
              <input class="input-medium" id="empFecha2E2" name="empFecha2E2" type="date"> </td>

              <td><label class=" control-label label " for="empTelE2">TELEFONO:</label><br>   
              <input id="empTelE2" name="empTelE2" type="text" class="input-large"> </td>

              <td><label class=" control-label label " for="empCausaSepE2">CAUSA SEPARACION:</label><br>   
              <input id="empCausaSepE2" name="empCausaSepE2" type="text" class="input-xlarge" maxlength="20"> </td>


            </tr>
            <tr>
              <td><label class=" control-label label " for="checkEmpPersonas">HA TENIDO PERSONAS A SU CARGO?:</label><br><br> 
              <span style="margin-left: 60px;">No</span>  
              <span style="margin-left: 40px;">Si</span>    
              <div style="margin-right: 198px;margin-bottom: 20px" class="material-switch pull-right">
                    <input id="checkEmpPersonas" name="checkEmpPersonas" type="checkbox" />
                    <label for="checkEmpPersonas" class="label-success1"></label>
              </div> 
                     
                </td>   

              <td><label class=" control-label label " for="selectEmpEstudio">GRADO DE ESTUDIOS:</label><br>   
                    <select id="selectEmpEstudio" name="selectEmpEstudio" class="input-large"> 
                      <option value="">GRADO</option>
                              <?php
                            for ($i=0; $i<count($catalogoGradoEstudios); $i++)
                            {
                              echo "<option value='". $catalogoGradoEstudios[$i]["idGradoEstudios"]."'>". $catalogoGradoEstudios[$i]["descripcionGradoEstudios"] ." </option>";
                            }
                            ?>
                    </select> </td>

              <td><label class=" control-label label " for="empCursoEspecial">CURSO ESPECIAL:</label><br>   
              <input id="empCursoEspecial" name="empCursoEspecial" type="text" class="input-xlarge"> </td>
            </tr>	
            </table>
        </td>
      </tr>
      <tr>
        <td> 
          <table style="table-layout:fixed;" width="1600px">            
            <tr ><td colspan="2"><center><h4><u style="color: #369C1C">DATOS FAMILIARES Y REFERENCIAS</u></h4></center></td>
            </tr>	
            <tr>
              <td><label class=" control-label label " for="empEnfermedad">ENFERMEDAD O PADECIMIENTO</label><br>   
              <input id="empEnfermedad" name="empEnfermedad" type="text" class="input-large"> </td>

              <td><label class=" control-label label " for="empPadre">PADRE:</label><br>   
              <input id="empPadre" name="empPadre" type="text" class="input-large"> </td>

              <td><label class=" control-label label " for="empMadre">MADRE:</label><br>   
              <input id="empMadre" name="empMadre" type="text" class="input-large"> </td>

              <td><label class=" control-label label " for="empEsposa">ESPOSA (O):</label><br>   
              <input id="empEsposa" name="empEsposa" type="text" class="input-large"> </td>

              <td><label class=" control-label label " for="empHijo">HIJOS (HERMANOS):</label><br>   
              <input id="empHijo1" name="empHijo1" type="text" class="input-large" placeholder="1:">
              <input id="empHijo2" name="empHijo2" type="text" class="input-large" placeholder="2:"> 
              <input id="empHijo3" name="empHijo3" type="text" class="input-large" placeholder="3:"> 
              <input id="empHijo4" name="empHijo4" type="text" class="input-large" placeholder="4:">
              <input id="empHijo5" name="empHijo5" type="text" class="input-large" placeholder="5:"> </td>
            </tr>
            <tr>
              <td><label class=" control-label label " for="empNombreR1">NOMBRE REFERENCIA 1:</label><br>   
              <input id="empNombreR1" name="empNombreR1" type="text" class="input-large"> </td>

              <td><label class=" control-label label " for="empTelR1">TELEFONO:</label><br>   
              <input id="empTelR1" name="empTelR1" type="text" class="input-large"> </td>

              <td><label class=" control-label label " for="empNombreR2">NOMBRE REFERENCIA 2:</label><br>   
              <input id="empNombreR2" name="empNombreR2" type="text" class="input-large"> </td>

              <td><label class=" control-label label " for="empTelR2">TELEFONO:</label><br>   
              <input id="empTelR2" name="empTelR2" type="text" class="input-large"> </td>
            </tr>            
            <tr>
              <td colspan="5"><center><input style="margin-top: 20px; margin-bottom: 20px" id="btnGuardar" type="button" class="btn btn-primary"  value="Guardar" onclick="obtenerFolioPreseleccion();guardarPreseleccion();" /></center></td>
            </tr>              
  				</table>         
  			</td>
  		</tr>      
  	</table>
</form>

</div>

<script type="text/javascript">

  function mostrarFolio(){
    alertMsg1="<div id='msgAlert' class='alert alert-success'>Precontratación: <h4>FOLIO: 0000002 <h4><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
    $("#alertMsg").html(alertMsg1);                        
    $(document).scrollTop(0);
    $('#msgAlert').delay(20000).fadeOut('slow');
    
  }

  function reiniciarPre(){
      $("#form_registroPreseleccion")[0].reset(); 
      $("#numempleadopreseleccion").val("");  
      $("#folioempleadopreseleccion").val(""); 
      $('#checkEmpInfonavitRE').removeAttr('checked');
      $('#checkEmpFonacot').removeAttr('checked');
      $('#checkEmpCartilla').removeAttr('checked');
      $('#checkEmpLicencia').removeAttr('checked');
      $('#checkEmpPersonas').removeAttr('checked');
      $("#selectEmpCivil").val("");
      $("#selectEmpSexo").val("");
      $("#selectEmpTipoSangre").val("");
      $("#selectEmpSexo").val("");
      $("#selectEmpEntidad").val("");
      $("#selectEmpEstudio").val(""); 
      $("#tdnumlicenciaprecontrata").hide();

       $("#tdfechavigencialicencia").hide();

      
      $('#numLicenciaPreseleccion').val("");

      $('#fechavigencialicencia').val("");
       
  }

  function obtenerFolioPreseleccion()
  {
   // var rutalogo="img/logoGif.jpg";  


      $.ajax({
            async : false,
            type: "POST",
            url: "ajax_obtenerFolioPres.php",
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {                    
                    var folio = response.folioPre.folioPres;                      
                    $("#txtFolioSolicitud").val(folio);

                }              
            },
            error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);

            }
        });


      
  }

  function guardarPreseleccion(){
   // $('#msginformativo').html("").fadeIn();
    //$('#msgAlert').val("").fadeIn();
      var datos=$("#form_registroPreseleccion").serialize();
      var infonavit=0;
      var fonacot=0;
      var cartilla=0;
      var licencia=0;
      var licenciapermanente=0;
      var personas=0;
      if( $('#checkEmpInfonavit').is(':checked') ) {
          infonavit=1;
      }
      if( $('#checkEmpFonacot').is(':checked') ) {
          fonacot=1;
      }
      if( $('#checkEmpCartilla').is(':checked') ) {
          cartilla=1;
      }
      if( $('#checkEmpLicencia').is(':checked') ) {
          licencia=1;
      }
       if( $('#checkEmpLicenciaPermanente').is(':checked') ) {
          licenciapermanente=1;
      }
      if( $('#checkEmpPersonas').is(':checked') ) {
          personas=1;
      }
      datos += "&infonavit=" + infonavit; 
      datos += "&fonacot=" + fonacot; 
      datos += "&cartilla=" + cartilla; 
      datos += "&licencia=" + licencia; 
      datos += "&licenciapermanente=" + licenciapermanente; 
      datos += "&personas=" + personas; 
      //datos+="numLicenciaPreseleccion"+numLicenciaPreseleccion;

      


     
      //console.log(datos);

      $.ajax({
            async : false,
            type: "POST",
            url: "ajax_registrarPreseleccion.php",
            data: datos,
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;
                 if (response.status == "success")
                { 
                if($("#numempleadopreseleccion").val()=="" &&  $("#folioempleadopreseleccion").val()==""){
                          reiniciarPre();
                    var folio=$("#txtFolioSolicitud").val();
                    alertMsg1="<div id='msgAlert' class='alert alert-success'>Precontratación: "+mensaje+" <h4>FOLIO:"+folio+" <h4><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#alertMsg").html(alertMsg1); 

                  
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(10000).fadeOut('slow'); 

              } else {//if($("#numempleadopreseleccion").val()!="" &&  $("#folioempleadopreseleccion").val()=="" ){
       



alertMsg1="<div id='msginformativo' class='alert alert-warning'><strong>DATOS GUARDADOS CORRECTAMENTE</strong><h4>Tu numero de empleado es: "+$("#numempleadopreseleccion").val()+" Entrega este número al personal de contrataciones.</h4><a href='#' class='close' data-dismiss='alert'>&times;</a></div>"; 
                $("#msginformativo").html(alertMsg1);                    
                 
                    $(document).scrollTop(0);
                    $('#msginformativo').delay(10000).fadeOut('slow');
                    reiniciarPre();
                     $("#tblhaslaborado").show();

              } 



 } else{
                    alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error por favor verifique:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#alertMsg").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                }


            },
            error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);

            }
        });
  }

	$('#empFechaNac').datetimepicker({
 
	  timepicker:false,
	  format:'Y-m-d',
	  formatDate:'Y-m-d',

	});

  $('#empFecha1E1').datetimepicker({
 
    timepicker:false,
    format:'Y-m-d',
    formatDate:'Y-m-d',

  });

  $('#empFecha2E1').datetimepicker({
 
    timepicker:false,
    format:'Y-m-d',
    formatDate:'Y-m-d',

  });

 $('#checklaborado').on("click", function() {
   $("#alertMsg").html(""); 
   $("#msginformativo").html(""); 
  if($('#checklaborado').is(":checked")){

   

    $("#tablesolicitudEmpleo").hide();
    $("#tblcriteriosdebusqueda").show();
    
  }else{

    $("#tablesolicitudEmpleo").show();
    $("#tblcriteriosdebusqueda").hide();
reiniciarPre();
  }
 });
        

$("#btnbuscar").click(function(){
   $("#alertMsg").val(""); 
  var curbusquedastr=$("#busquedacurp").val();
  var numafiliacionimss=$("#busquedanumimss").val();
  var curbusqueda=curbusquedastr.toUpperCase();
   if(curbusqueda!="" && numafiliacionimss==""){
        //alert("sera buesqueda por  curp");
        if(/^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/.test(curbusqueda)){
            consultaexistiaempleado(curbusqueda,numafiliacionimss);
        }else {
            alertMsg1="<div id='msgAlert' class='alert alert-danger'>Verifica CURP<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";     
          $("#alertMsg").html(alertMsg1); 
          }
    }else if(curbusqueda=="" && numafiliacionimss!=""){
        //alert("sera buesqueda por  nu imss");
       if(/^(([0-9]{11}))$/.test(numafiliacionimss)){
         consultaexistiaempleado(curbusqueda,numafiliacionimss);
        }else{alertMsg1="<div id='msgAlert' class='alert alert-danger'>Verifica N° AFILIACIÓN IMSS<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";     
          $("#alertMsg").html(alertMsg1); }
      }else{
      alertMsg1="<div id='msgAlert' class='alert alert-danger'>Ingresa CURP o N° AFILIACIÓN IMSS<a href='#' class='close' data-dismiss='alert'>&times;</a></div>"; 
      $("#alertMsg").html(alertMsg1); }
});

function consultaexistiaempleado(curp,numafiliacionimss){$('#msginformativo').fadeIn();
  //alert("al descuque de la consulta");
  $("#numempleadopreseleccion").val("");
  $("#folioempleadopreseleccion").val("");
  $("#alertMsg").html(""); 
  $.ajax({
            async : false,
            type: "POST",
            url: "ajax_obtenerFolioPrecontraReingresoEmpleado.php",
            data:{"curp":curp,"numafiliacionimss":numafiliacionimss,"folioPreseleccion":0},
            dataType: "json",
            success: function(response) {
               //console.log(response); 
               var status=response.status;
               if(status=="sinDatos"){
                alertMsg1="<div id='msginformativo' class='alert alert-danger'><h4>No hemos encontrado información de registro intenta con otra opcion de busqueda o completa el siguiente formulario</h4><a href='#' class='close' data-dismiss='alert'>&times;</a></div>"; 
                $("#msginformativo").html(alertMsg1); 
                //alert("NO HEMOS ENCONTRADO INFORMACION DE REGISTRO INTENTA CON OTRA OPCION DE BUSQUEDA O COMPLETA EL SIGUEINTE FORMULARIO");
                reiniciarPre();
                   $("#tablesolicitudEmpleo").show();
                  $("#tblcriteriosdebusqueda").hide();
               }else{
                var numeroempleado=response.datosEmpleado[0].numempleado;
                var folioPreselecciontblempleados=response.datosEmpleado[0].foliopreseleccion;
                var folioPreselecciontblempleadospreseleccion=response.datosEmpleado[0].foliotblempleadopreseleccion;

                if(folioPreselecciontblempleados==null && folioPreselecciontblempleadospreseleccion==null){
                  alertMsg1="<div id='msginformativo' class='alert alert-warning'><h4>Tu numero de empleado es: "+numeroempleado+" Completa el siguiente formulario y entrega este número al personal de contrataciones</h4><a href='#' class='close' data-dismiss='alert'>&times;</a></div>"; 
                $("#msginformativo").html(alertMsg1); 


  //alert("TU NUMERO DE EMPLEADO ES: "+numeroempleado+" ENTREGA ESTE NUMERO AL PERSONAL DE CONTRATACIONES, POR FAVOR COMPLETA EL SIGUIENTE FORMULARIO");
                  $("#tblhaslaborado").hide();
                  reiniciarPre();
                  $("#tablesolicitudEmpleo").show();
                  $("#tblcriteriosdebusqueda").hide();
                }else{

                  foliodefinido=folioPreselecciontblempleados;
                  alertMsg1="<div id='msginformativo' class='alert alert-warning'><h4>Tu numero de empleado es: "+numeroempleado+" por favor verifica tus datos, en caso de estar correctos presiona el boton GUARDAR de lo contrario ingresa correctamente tu información y presiona el boton GUARDAR</h4><a href='#' class='close' data-dismiss='alert'>&times;</a></div>"; 
                $("#msginformativo").html(alertMsg1); 
                 // alert("TU NUMERO DE EMPLEADO ES: "+numeroempleado+" POR FAVOR VERIFICA TUS DATOS EN CASO DE ESTAR CORRECTOS PRESIONA GUARDAR DE LO CONTRARIO INGRESA CORRECTAMENTE TU INFORMACION Y PRESIONA EL BOTON GUARDAR");
                 if(folioPreselecciontblempleados==null){
                  var foliodefinido=folioPreselecciontblempleadospreseleccion;
                 }else if(folioPreselecciontblempleadospreseleccion==null){

                  foliodefinido=folioPreselecciontblempleados;
                 }
                  traerDatosPrecontratacion(foliodefinido);
                }
               }

               $("#numempleadopreseleccion").val(numeroempleado);
                $("#folioempleadopreseleccion").val(foliodefinido);

            },
            error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);

            }
        });
}
function traerDatosPrecontratacion(folioPreseleccion){
  //alert("el folio de precontartacion es: "+folioPreseleccion+" traer datos");
  $.ajax({
            async : false,
            type: "POST",
            url: "ajax_obtenerFolioPrecontraReingresoEmpleado.php",
            data:{"curp":0,"numafiliacionimss":0,"folioPreseleccion":folioPreseleccion},
            dataType: "json",
            success: function(response) {
               console.log(response); 
                $("#numLicenciaPreseleccion").val("");
                $("#fechavigencialicencia").val("");
                $("#tdnumlicenciaprecontrata").hide();
                $("#tdfechavigencialicencia").hide();
                $("#tablesolicitudEmpleo").show();
                $("#tblcriteriosdebusqueda").hide();
                $("#empPuesto").val(response.datosAspitante[0].puestoPreseleccion);
                $("#empApPaterno").val(response.datosAspitante[0].apPaternoPreseleccion);
                $("#empApMaterno").val(response.datosAspitante[0].apMaternoPreseleccion);
                $("#empNombre").val(response.datosAspitante[0].nombrePreseleccion);
                $("#empEdad").val(response.datosAspitante[0].edadPreseleccion);
                $("#empPeso").val(response.datosAspitante[0].pesoPreseleccion);
                $("#empEstatura").val(response.datosAspitante[0].estaturaPreseleccion);
                $("#empTallaCamisa").val(response.datosAspitante[0].tallaCamisaPreseleccion);
                $("#empTallaPantalon").val(response.datosAspitante[0].tallaPantalonPreseleccion);
                $("#empNumCalzado").val(response.datosAspitante[0].numCalzadoPreseleccion);
                //$("#selectEmpCivil option:contains("+response.datosAspitante[0].edoCivil+")").attr('selected', true);
                $("#selectEmpCivil").val(response.datosAspitante[0].edoCivilPreseleccion);
                //$("#selectEmpSexo option:contains("+response.datosAspitante[0].generoPre+")").attr('selected', true);
                $("#selectEmpSexo").val(response.datosAspitante[0].generoPreseleccion);
                //$("#selectEmpTipoSangre option:contains("+response.datosAspitante[0].tipoSangre+")").attr('selected', true);
                $("#selectEmpTipoSangre").val(response.datosAspitante[0].tipoSangrePreseleccion);
                $("#empFechaNac").val(response.datosAspitante[0].fechaNacPreseleccion);
                //$("#selectEmpEntidad option:contains("+response.datosAspitante[0].entidadPre+")").attr('selected', true);
                $("#selectEmpEntidad").val(response.datosAspitante[0].entidadNacPreseleccion);
                $("#empCodPostal").val(response.datosAspitante[0].cpPreseleccion);
                $("#empCalle").val(response.datosAspitante[0].callePreseleccion);
                $("#empNumeroC").val(response.datosAspitante[0].numeroPreseleccion);
                $("#empColonia").val(response.datosAspitante[0].coloniaPreseleccion);
                $("#empMunicipio").val(response.datosAspitante[0].municipioPreseleccion);
                $("#empCiudad").val(response.datosAspitante[0].ciudadPreseleccion);
                $("#empTelFijo").val(response.datosAspitante[0].telFijoPreseleccion);
                $("#empTelMovil").val(response.datosAspitante[0].telMovilPreseleccion);
                $("#empEmail").val(response.datosAspitante[0].emailPreseleccion);
                if(response.datosAspitante[0].infonavitPreseleccion==1){$("#checkEmpInfonavit").prop('checked','cheked');}
                if(response.datosAspitante[0].fonacotPreseleccion==1){$("#checkEmpFonacot").prop('checked','cheked');}
                if(response.datosAspitante[0].cartillaPreseleccion==1){$("#checkEmpCartilla").prop('checked','cheked');}
                if(response.datosAspitante[0].licenciaPreseleccion==1 && response.datosAspitante[0].licenciapermanente==0 ){
                  $("#checkEmpLicencia").prop('checked','cheked'); 
                  $("#checkEmpLicenciaPermanente").prop('checked','');
                  $("#numLicenciaPreseleccion").val(response.datosAspitante[0].numlicenciapreseleccion);
                  $("#fechavigencialicencia").val(response.datosAspitante[0].fechavigencialicencia);///////////descomentar una vez que este el datop en la bd  
                  $("#tdnumlicenciaprecontrata").show(); 
                  $("#tdfechavigencialicencia").show();
                  $("#tdnumlicenciaprecontratapermanente").show();
                } 
                if(response.datosAspitante[0].licenciaPreseleccion==1 && response.datosAspitante[0].licenciapermanente==1 ){
                   $("#checkEmpLicencia").prop('checked','cheked'); 
                   $("#checkEmpLicenciaPermanente").prop('checked','cheked'); 
                  $("#numLicenciaPreseleccion").val("");
                  $("#fechavigencialicencia").val("");///////////descomentar una vez que este el datop en la bd  
                  $("#tdnumlicenciaprecontrata").hide(); 
                  $("#tdfechavigencialicencia").hide();
                  $("#tdnumlicenciaprecontratapermanente").show();


                }
                $("#empImss").val(response.datosAspitante[0].nImssPreseleccion);
                $("#empNombreUE").val(response.datosAspitante[0].nombreE1Preseleccion);
                $("#empFecha1E1").val(response.datosAspitante[0].fecha1E1Preseleccion);
                $("#empFecha2E1").val(response.datosAspitante[0].fecha2E1Preseleccion);
                $("#empTelE1").val(response.datosAspitante[0].telefonoE1Preseleccion);
                $("#empCausaSepE1").val(response.datosAspitante[0].causaE1Preseleccion);
                $("#empNombreEA").val(response.datosAspitante[0].nombreE2Preseleccion);
                $("#empFecha1E2").val(response.datosAspitante[0].fecha1E2Preseleccion);
                $("#empFecha2E2").val(response.datosAspitante[0].fecha2E2Preseleccion);
                $("#empTelE2").val(response.datosAspitante[0].telefonoE2Preseleccion);
                $("#empCausaSepE2").val(response.datosAspitante[0].causaE2Preseleccion);
                if(response.datosAspitante[0].personasACargoPreseleccion==1){$("#checkEmpPersonas").prop('checked','cheked');}
                $("#selectEmpEstudio").val(response.datosAspitante[0].gradoEPreseleccion);
                $("#empCursoEspecial").val(response.datosAspitante[0].cursoEspecialPreseleccion);
                $("#empEnfermedad").val(response.datosAspitante[0].enfermedadPreseleccion);
                $("#empPadre").val(response.datosAspitante[0].padrePreseleccion);
                $("#empMadre").val(response.datosAspitante[0].madrePreseleccion);
                $("#empEsposa").val(response.datosAspitante[0].esposaPreseleccion);
                $("#empHijo1").val(response.datosAspitante[0].ben1Preseleccion);
                $("#empHijo2").val(response.datosAspitante[0].ben2Preseleccion);
                $("#empHijo3").val(response.datosAspitante[0].ben3Preseleccion);
                $("#empHijo4").val(response.datosAspitante[0].ben4Preseleccion);
                $("#empHijo5").val(response.datosAspitante[0].ben5Preseleccion);
                $("#empNombreR1").val(response.datosAspitante[0].nombreR1Preseleccion);
                $("#empTelR1").val(response.datosAspitante[0].telefonoR1);
                $("#empNombreR2").val(response.datosAspitante[0].nombreR2);
                $("#empTelR2").val(response.datosAspitante[0].telefonoR2);
            },
            error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);

            }
        });
}

$("#busquedacurp").focus(function(){
  $("#busquedanumimss").val("");
});
$("#busquedanumimss").focus(function(){
  $("#busquedacurp").val("");
});

 //<td id="tdnumlicenciaprecontratapermanente" style="display: none"><label class=" control-label label " for="checkEmpLicenciaPermanente"


$("#checkEmpLicencia").click(function(){ 
 if( $('#checkEmpLicencia').is(':checked') ) {
         $("#tdnumlicenciaprecontrata").show('slow');
        $("#tdfechavigencialicencia").show('slow');
         $("#tdnumlicenciaprecontratapermanente").show('slow');
         $("#checkEmpLicenciaPermanente").prop('checked','');
      }else{
$("#tdnumlicenciaprecontrata").hide();
$("#tdfechavigencialicencia").hide();
 $("#tdnumlicenciaprecontratapermanente").hide();
 $("#checkEmpLicenciaPermanente").prop('checked','checked');
      }

$('#numLicenciaPreseleccion').val("");
$('#fechavigencialicencia').val("");
});

$("#checkEmpLicenciaPermanente").click(function(){ 
 if( $('#checkEmpLicenciaPermanente').is(':checked') ) {      
$("#tdnumlicenciaprecontrata").show();
$("#tdfechavigencialicencia").hide();    
      }else{
 $("#tdnumlicenciaprecontrata").show('slow');
         $("#tdfechavigencialicencia").show('slow');
      }
$('#numLicenciaPreseleccion').val("");
$('#fechavigencialicencia').val("");
});


</script>