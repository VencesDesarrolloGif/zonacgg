	
	
<!--<script type="text/javascript" src="js/js2.js"></script> -->
	<style>
		.editable span{display:block;}
		.editable span:hover {background:url(img/edit.png) 90% 50% no-repeat;cursor:pointer}
		td input{height:24px;width:200px;border:1px solid #ddd;padding:0 5px;margin:0;border-radius:6px;vertical-align:middle}
		a.enlace{display:inline-block;width:24px;height:24px;margin:0 0 0 5px;overflow:hidden;text-indent:-999em;vertical-align:middle}
		.guardar{background:url(img/save.png) 0 0 no-repeat}
		.cancelar{background:url(img/cancel.png) 0 0 no-repeat}
	
		.mensaje{display:block;text-align:center;margin:0 0 20px 0}
		.ok{display:block;padding:10px;text-align:center;background:green;color:#fff}
		.ko{display:block;padding:10px;text-align:center;background:red;color:#fff}
	</style>
	<div >
		<h2>Confirmacion de datos para Imss</h2><br>
		 <img title='Consulta/Cargar/Actualizar Pagina' src='img/ActualizarEjecutar.jpg' class='cursorImg' onclick="ConsultaImssInicial();" width="50px"><br>
		<select id="selectRegistroPatronal" name="selectRegistroPatronal" onchange="opcionTabla();" >
            <option value='0'>REGISTRO PATRONAL</option>
                <?php
              for ($i=0; $i<count($catalogoRegistrosPatronales); $i++)
              {
                echo "<option value='". $catalogoRegistrosPatronales[$i]["idcatalogoRegistrosPatronales"]."'>". $catalogoRegistrosPatronales[$i]["idcatalogoRegistrosPatronales"] ." (". $catalogoRegistrosPatronales[$i]["nombreEntidadFederativa"].") </option>";
              }
              ?>
        </select> <button class="btn btn-primary" type="button" onclick="generartxt();"> Generar txt</button>
		<div class="mensaje"></div>
		<table class="editinplace table table-hover" id="editinplace" name="editinplace">
			<tr>
				<th>#Empleado</th>
				<th>Ap. Paterno</th>
				<th>Ap. Materno</th>
				<th>Nombre</th>
				<th>Id Punto</th>
				<th>Punto De Servicio</th>
				<th>Origen</th>
				<th>Tipo Puesto</th>
				<th>Num. IMSS</th>
				<th>Fecha IMSS</th>
        <th>Entidad A Laborar</th>
				<th>Registro Patronal</th>
				<th>Tipo trabajador</th>
				<th>Salario Diario</th>
				<th>Salario Base Cotización</th>
				<th>Generación txt</th>
				<th><center><img src="img/warningMenu.png">Alerta</center></th>
			</tr>
		</table>


		    <!--  fin modal firma -->

    <div class="modal fade" tabindex="-1" role="dialog" name="modalConfirmacionCancelacionEnvioAlta" id="modalConfirmacionCancelacionEnvioAlta" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      	<div id="alertMsgDefinitivo" name="alertMsgDefinitivo"> 
  		</div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><img src="img/alert.png">NO PROCESAR ALTA IMSS</h4>
      </div>
      <div class="modal-body">
        <p><strong>¿Desea indicar que el empleado <input type="text" class="input-long" name="txtEmpleadoSinImssDefinitivo" id="txtEmpleadoSinImssDefinitivo" readonly> no será procesado definitivamente para alta de Imss?</strong></p> 
        <br>
        <input type="hidden" id="txtNumEmpleadoDefinitivo" name="txtNumEmpleadoDefinitivo">
        <strong>Comentario:</strong><br>
        <textarea id="comentarioDefinitivo" name="comentarioDefinitivo" rows="5" ></textarea>

      </div>
      <div class="modal-footer">
      	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      	<button type="button" class="btn btn-primary" onClick="actualizarEstatusImssDefinitivo();">Sí</button>
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
	</div>

	<script type="text/javascript">
$(document).ready (function ()
{
	ConsultaImssInicial();
});

function ConsultaImssInicial(){

	tabla();
	var td,campo,valor,id;
	$("#selectRegistroPatronal").val(0);
}
$(document).on("click","td.editable span",function(e)
		{
			campo=$(this).closest("td").data("campo");
			td=$(this).closest("td");
			valor=$(this).text();
			id=$(this).closest("tr").find(".id").text();
			numeroEmpleado=$(this).closest("tr").find(".id").text();
			e.preventDefault();
			$("td:not(.id)").removeClass("editable");
			if (campo!='registroPatronal')
			{
				td.text("").html("<input type='text' name='"+campo+"' value='"+valor+"'><a class='enlace guardar' href='#'>Guardar</a><a class='enlace cancelar' href='#'>Cancelar</a>");
			}else{
				select="<select id='campo' name='campo'>";
				optionSelect="";
				<?php
        if (isset ($catalogoRegistrosPatronales))
        {
					for ($i=0; $i<count($catalogoRegistrosPatronales); $i++){
						$value=$catalogoRegistrosPatronales[$i]["idcatalogoRegistrosPatronales"];		
						$entidad=$catalogoRegistrosPatronales[$i]["nombreEntidadFederativa"];
				?>
						var valorp="<?php echo $value; ?>";
						var entidad="<?php echo $entidad; ?>";
						optionSelect +="<option value='"+valorp+"'>"+valorp+" ("+entidad+")</option>";
				<?php
					} // for
        } // if
				?>	
				select +=""+optionSelect+"</select><a class='enlace guardar' href='#'>Guardar</a><a class='enlace cancelar' href='#'>Cancelar</a>";
				td.text("").html(select);
			}
			if(campo=="tipoTrabajador"){
				select="<select id='"+campo+"' name='"+campo+"'>";
				optionSelect="";
				<?php
        if (isset($catalogoTiposTrabajadorImss))
        {
					for ($i=0; $i<count($catalogoTiposTrabajadorImss); $i++){
						$value=$catalogoTiposTrabajadorImss[$i]["idTipoTrabajadorImss"];
						$mostrar=$catalogoTiposTrabajadorImss[$i]["descripcionTipoTrabajadorImss"];		
				?>
						var valort="<?php echo $value; ?>";
						var mostrart="<?php echo $mostrar; ?>";
						optionSelect +="<option value='"+valort+"'>"+mostrart+"</option>";
				<?php
					} // for
        } // if
				?>	
				select +=""+optionSelect+"</select><a class='enlace guardar' href='#'>Guardar</a><a class='enlace cancelar' href='#'>Cancelar</a>";
				td.text("").html(select);
			} 
		});
$(document).on("click",".cancelar",function(e)
{
	e.preventDefault();
	td.html("<span>"+valor+"</span>");
	$("td:not(.id)").addClass("editable");
});


$(document).on("click",".guardar",function(e)
{

	$(".mensaje").html("<img src='img/loading.gif'>");
	e.preventDefault();
	if (campo!="registroPatronal" && campo!="tipoTrabajador"){
		nuevovalor=$(this).closest("td").find("input").val();
	}else{
		nuevovalor=$(this).closest("td").find("select").val();
	}
	if(nuevovalor.trim()!="")
	{
		
		$.ajax({
			type: "POST",
			url: "ajax_actualizaDatosImssTable.php",
			data: { campo: campo, valor: nuevovalor, "numeroEmpleado":numeroEmpleado}, 
			dataType: "json",
			success: function(response) {
				var mensaje=response.message;
          if (response.status == "success")
          {
          	$(".mensaje").html("<p class='ok'>"+mensaje+"</p>")
          	td.html("<span>"+nuevovalor+"</span>");
					$("td:not(.id)").addClass("editable");
					setTimeout(function() {$('.ok,.ko').fadeOut('fast');}, 3000);
					$(".mensaje").html("<p class='ok'>"+mensaje+"</p>")
					$("#editinplace").find("tr:gt(0)").remove();
					opcionTabla();
          } else if(response.status=="error"){
          	$(".mensaje").html(mensaje);
					$("td:not(.id)").addClass("editable");
					setTimeout(function() {$('.ok,.ko').fadeOut('fast');}, 3000);
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
       	}
		});
	}else $(".mensaje").html("<p class='ko'>Debes ingresar un valor</p>");
});  

	function tabla(){
		$("#editinplace").find("tr:gt(0)").remove();

		$.ajax({
            
            type: "POST",
            url: "ajax_obtenerEmpleadosSinImss.php",
            dataType: "json",
             success: function(response) {
                if (response.status == "success")
                {
                 
                    var empleadoEncontrado = response.listaEmpleados;
                                     
                    for ( var i = 0; i < empleadoEncontrado.length; i++ ){
                      var numeroEmpleado = empleadoEncontrado[i].numeroEmpleado;
                      var apellidoPaterno = empleadoEncontrado[i].apellidoPaterno;
                      var apellidoMaterno = empleadoEncontrado[i].apellidoMaterno;
                      var nombreEmpleado=empleadoEncontrado[i].nombreEmpleado;
                      var fechaImss=empleadoEncontrado[i].fechaImss;
                      var numeroImss=empleadoEncontrado[i].empleadoNumeroSeguroSocial;
                      var registroPatronal=empleadoEncontrado[i].registroPatronal;
                      var EntidadALaborar=empleadoEncontrado[i].EntidadALaborar;
                      var idPinto=empleadoEncontrado[i].idPinto;
                      var PuntoServ=empleadoEncontrado[i].PuntoServ;
                      var descripcionCategoria=empleadoEncontrado[i].descripcionCategoria;
                      var Origen=empleadoEncontrado[i].Origen;
                      //var curp=empleadoEncontrado[i].curpEmpleado;
                      var descripcionTipoTrabajadorImss=empleadoEncontrado[i].descripcionTipoTrabajadorImss;

                      var salarioDiario=empleadoEncontrado[i].salarioDiario;
                      var diasTranscurridos=empleadoEncontrado[i].diasTranscurridos;
                      var primaVacacional=0;
                      var unidad=1;
                      var aguinaldo=15/365;

                      if (diasTranscurridos <= 365) {
        			      primaVacacional = 3;
        			  
        			  } else if (diasTranscurridos >= 366 && diasTranscurridos <= 730) {
        			  
        			      primaVacacional = 3.5;
        			  
        			  } else if (diasTranscurridos >= 731 && diasTranscurridos <= 1095) {
        			  
        			      primaVacacional = 4;
        			  } else if (diasTranscurridos >= 1096 && diasTranscurridos <= 1460) {
        			  
        			      primaVacacional = 4.5; 
        			  
        			  } else if (diasTranscurridos >= 1461 && diasTranscurridos <= 1825) {
        			  
        			      primaVacacional = 5;
        			  
        			  } else if (diasTranscurridos >= 1826 && diasTranscurridos <= 3650) {
        			  
        			      primaVacacional = 5.5;
        			  
        			  } else if (diasTranscurridos >= 3651 && diasTranscurridos <= 5475) {
        			  
        			      primaVacacional = 6;
        			  
        			  } else if (diasTranscurridos >= 5476 && diasTranscurridos <= 7300) {
        			  
        			      primaVacacional = 6.5;
        			  
        			  } else if (diasTranscurridos >= 7301 && diasTranscurridos <= 9125) {
        			  
        			      primaVacacional = 7;
        			  
        			  } else if (diasTranscurridos >= 9126 && diasTranscurridos <= 10950) {
        			  
        			      primaVacacional = 7.5;
        			  
        			  } else if (diasTranscurridos >= 10951 && diasTranscurridos <= 12775) {
        			  
        			      primaVacacional = 8;
        			  
        			  }

            			var factorIntegracion=unidad+(primaVacacional/365)+aguinaldo;
            			var salarioBaseCotizacion=factorIntegracion*salarioDiario;


                    $('#editinplace').append(
					"<tr><td class='id'>"+numeroEmpleado+"</td><td>"+apellidoPaterno+"</td><td>"+apellidoMaterno+
					"</td><td>"+nombreEmpleado+"</td><td>"+idPinto+"</td><td>"+PuntoServ+"</td><td>"+Origen+"</td><td>"+descripcionCategoria+"</td><td>"+numeroImss
					+"</td><td class='editable' data-campo='fechaImss'><span>"+fechaImss+"</span></td><td class='editable' data-campo='EntidadALaborar'><span>"+EntidadALaborar
					+"</span></td><td class='editable' data-campo='registroPatronal'><span>"+registroPatronal
          +"</span></td><td class='editable' data-campo='tipoTrabajador'><span>"+descripcionTipoTrabajadorImss+"</td><td class='editable' data-campo='salarioDiario'><span>"+salarioDiario+
					"</span></td><td>"+salarioBaseCotizacion+
					"</td></tr>");
                    }                    
                    //$('#editinplace').html(listaPersonalActivoTable); 
                                  }
                else if (response.status == "error" && response.message == "No autorizado")
                {
                    //window.location = "login.php";
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
        });

	}

	function tablaPorRegistroPatronal(){

		var registroPatronal=$("#selectRegistroPatronal").val();
		$("#editinplace").find("tr:gt(0)").remove();

		$.ajax({
            
            type: "POST",
            url: "ajax_obtenerEmpleadosPorRegistroPatronal.php",
            data: {"registroPatronal": registroPatronal},
            dataType: "json",
            async: false,
            success: function(response) {
                if (response.status == "success")
                {
                 
                    var empleadoEncontrado = response.listaEmpleados;
                    for ( var i = 0; i < empleadoEncontrado.length; i++ ){
                      var numeroEmpleado = empleadoEncontrado[i].numeroEmpleado;
                      var apellidoPaterno = empleadoEncontrado[i].apellidoPaterno;
                      var apellidoMaterno = empleadoEncontrado[i].apellidoMaterno;
                      var nombreEmpleado=empleadoEncontrado[i].nombreEmpleado;
                      var fechaImss=empleadoEncontrado[i].fechaImss;
                      var numeroImss=empleadoEncontrado[i].empleadoNumeroSeguroSocial;
                      var registroPatronal=empleadoEncontrado[i].registroPatronal;
                      var curp=empleadoEncontrado[i].curpEmpleado;
                      var descripcionTipoTrabajadorImss=empleadoEncontrado[i].descripcionTipoTrabajadorImss;
                      var emisionAltaImssConfirmada=empleadoEncontrado[i].emisionAltaImssConfirmada;
                      var EntidadALaborar=empleadoEncontrado[i].EntidadALaborar;
                      var idPinto=empleadoEncontrado[i].idPinto;
                      var PuntoServ=empleadoEncontrado[i].PuntoServ;
                      var descripcionCategoria=empleadoEncontrado[i].descripcionCategoria;
                      var Origen=empleadoEncontrado[i].Origen;

                      var nombreCompletoEmpleado=apellidoPaterno+" "+apellidoMaterno+" "+nombreEmpleado;

                      var salarioDiario=empleadoEncontrado[i].salarioDiario;
                      var diasTranscurridos=empleadoEncontrado[i].diasTranscurridos;
                      var primaVacacional=0;
                      var unidad=1;
                      var aguinaldo=15/365;
                      if (diasTranscurridos <= 365) {
        			      primaVacacional = 3;
        			  
        			  } else if (diasTranscurridos >= 366 && diasTranscurridos <= 730) {
        			  
        			      primaVacacional = 3.5;
        			  
        			  } else if (diasTranscurridos >= 731 && diasTranscurridos <= 1095) {
        			  
        			      primaVacacional = 4;
        			  } else if (diasTranscurridos >= 1096 && diasTranscurridos <= 1460) {
        			  
        			      primaVacacional = 4.5; 
        			  
        			  } else if (diasTranscurridos >= 1461 && diasTranscurridos <= 1825) {
        			  
        			      primaVacacional = 5;
        			  
        			  } else if (diasTranscurridos >= 1826 && diasTranscurridos <= 3650) {
        			  
        			      primaVacacional = 5.5;
        			  
        			  } else if (diasTranscurridos >= 3651 && diasTranscurridos <= 5475) {
        			  
        			      primaVacacional = 6;
        			  
        			  } else if (diasTranscurridos >= 5476 && diasTranscurridos <= 7300) {
        			  
        			      primaVacacional = 6.5;
        			  
        			  } else if (diasTranscurridos >= 7301 && diasTranscurridos <= 9125) {
        			  
        			      primaVacacional = 7;
        			  
        			  } else if (diasTranscurridos >= 9126 && diasTranscurridos <= 10950) {
        			  
        			      primaVacacional = 7.5;
        			  
        			  } else if (diasTranscurridos >= 10951 && diasTranscurridos <= 12775) {
        			  
        			      primaVacacional = 8;
        			  
        			  }

            			var factorIntegracion=unidad+(primaVacacional/365)+aguinaldo;
            			var salarioBaseCotizacion=factorIntegracion*salarioDiario;

            			if(emisionAltaImssConfirmada==1){
            				var iconImss="img/Ok-icon1.png";

            			}else{
            				var iconImss="img/cancel.png";
            			}
                    $('#editinplace').append(
					"<tr><td class='id'>"+numeroEmpleado+"</td><td>"+apellidoPaterno+"</td><td>"+apellidoMaterno+
					"</td><td>"+nombreEmpleado+"</td><td>"+idPinto+"</td><td>"+PuntoServ+"</td><td>"+Origen+"</td><td>"+descripcionCategoria+"</td><td>"+numeroImss
					+"</td><td class='editable' data-campo='fechaImss'><span>"+fechaImss+"</span></td><td class='editable' data-campo='EntidadALaborar'><span>"+EntidadALaborar
					+"</span></td><td class='editable' data-campo='registroPatronal'><span>"+registroPatronal
          +"</span></td><td class='editable' data-campo='tipoTrabajador'><span>"+descripcionTipoTrabajadorImss+"</td><td class='editable' data-campo='salarioDiario'><span>"+salarioDiario+
					"</span></td><td>"+salarioBaseCotizacion+
					"</td><td><img src='"+iconImss+"' class='cursorImg'  onclick='cambiarEstatusParaGenerarTxt(\"" + numeroEmpleado + "\","+emisionAltaImssConfirmada+");'></td><td><a  href='javascript:cancelarDefinitivamenteEnvioAltaImss(\"" + numeroEmpleado + "\",\"" + nombreCompletoEmpleado + "\");' class='cursorImg'>No emitir alta definitivamente</a></td></tr>");
                    }                    
                    //$('#editinplace').html(listaPersonalActivoTable); 
                                  }
                else if (response.status == "error" && response.message == "No autorizado")
                {
                    //window.location = "login.php";
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
        });

	}

	function opcionTabla(){

		var registroPatronal=$("#selectRegistroPatronal").val();
		if(registroPatronal=="REGISTRO PATRONAL" || registroPatronal=="0"){
			tabla();
		} else{
			tablaPorRegistroPatronal();
		}

	}

function generartxt(){
	var registroPatronal=$("#selectRegistroPatronal").val();
	if (registroPatronal=="REGISTRO PATRONAL" || registroPatronal=="0"){
		alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Generacion de archivo</strong>Seleccione un registro patronal <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
		$("#alertMsg").html(alertMsg1);
        $('#msgAlert').delay(3000).fadeOut('slow');
	}else{
      	var win = window.open("archivo2.php?registroPatronal="+registroPatronal+"", 'Archivo Imss',"width=600,height=600,scrollbars=no");   
	    var timer = setInterval(function() {   
   			if(win.closed) {  
       			clearInterval(timer);  
       			opcionTabla();
  				//styleTableImss();
   			}  
		},1000);
  	}
}

		function cambiarEstatusParaGenerarTxt(numeroEmpleado,emisionAltaImssConfirmada){ 
		var newEstatusEmisionAlta="";

		if (emisionAltaImssConfirmada==1){

			newEstatusEmisionAlta=0;

		}else{
			newEstatusEmisionAlta=1;
		}

		$.ajax({
            type: "POST",
            url: "ajax_actualizaEstatusEmisionAltaImss.php",
            data: {"numeroEmpleado":numeroEmpleado,"newEstatusEmisionAlta":newEstatusEmisionAlta},
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;

                if (response.status=="success") {
            

					opcionTabla();

                } else if (response.status=="error")
                {
       				alert(mensaje);                    
                }
              },
            error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
        });
	}

	function cancelarDefinitivamenteEnvioAltaImss(numeroEmpleado, nombreCompletoEmpleado){

		$("#modalConfirmacionCancelacionEnvioAlta").modal();
		$("#txtEmpleadoSinImssDefinitivo").val(nombreCompletoEmpleado);
		$("#txtNumEmpleadoDefinitivo").val(numeroEmpleado);
	}

	function actualizarEstatusImssDefinitivo(){

		var numeroEmpleado=$("#txtNumEmpleadoDefinitivo").val();
		var comentario=$("#comentarioDefinitivo").val();
		var estatusImss=8;


		$.ajax({
            type: "POST",
            url: "ajax_actualizarEstatusDefinitivo.php",
            data: {"numeroEmpleado":numeroEmpleado,"estatusImss":estatusImss, comentario:comentario},
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;

                if (response.status=="success") {
            		//alert(mensaje);

            		$("#txtNumEmpleadoDefinitivo").val("");
            		$("#comentarioDefinitivo").val("");

            		$('#modalConfirmacionCancelacionEnvioAlta').modal('hide');


					opcionTabla();

                } else if (response.status=="error")
                {
       				 
       				var alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error: </strong>"+mensaje+"<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#alertMsgDefinitivo").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');                
                }
              },
            error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
        });
	}

	


	</script>

		<script type="text/javascript">
		var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
		document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
	</script>
	<script type="text/javascript">
	try {
		var pageTracker = _gat._getTracker("UA-266167-20");
		pageTracker._setDomainName(".martiniglesias.eu");
		pageTracker._trackPageview();
	} catch(err) {}</script>
