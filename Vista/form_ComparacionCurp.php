<?php
require_once ("../Negocio/Negocio.class.php");
$negocio = new Negocio ();
//$log = new KLogger ( "vistaConsultaAsistencia.log" , KLogger::DEBUG );
?>
<h2 style="color: blue">Comparacion De CURP y RFC zonagif</h2> <br>
<div>
	<button  type="button" class="btn btn-default" id="BotonCreacion" name="BotonCreacion" onclick="TraerConsultaEmpleados();">Mostrar Comparacion</button>
</div>
<div id="displayshowtableCurp" style="display:none">
	<table id="tablaCurpYRfc"  class="display" width="100%"  style="display:block">
  		<thead>
    		<tr>
      			<th style="text-align: center;background-color: #B0E76E">Número empleado</th>
      			<th style="text-align: center;background-color: #B0E76E">Nombre Empleado</th>
      			<th style="text-align: center;background-color: #B0E76E">Curp Ingresado</th>
      			<th style="text-align: center;background-color: #B0E76E">Curp Interno</th>
      			<th style="text-align: center;background-color: #B0E76E">Rfc Ingresado</th>
      			<th style="text-align: center;background-color: #B0E76E">Rfc Interno</th>
    		</tr>
  		</thead>
    </table>
</div>

<script type="text/javascript">

function TraerConsultaEmpleados(){
	datosEmpleadosFinal = [];
	waitingDialog.show();
	$.ajax({
        type: "POST",
        url: "ajax_ObtenerDatosPersonalesYCurp.php",
        dataType: "json",
        success: function(response) {
          	var mensaje=response.message;
            if (response.status=="success") {
            	 $('#displayshowtableCurp').css("display", "block");
                var TotalEmpleados = response.ListaDatosEmpleado.length;
                for(var i=0; i<TotalEmpleados; i++){

                  
                	var apellidoPaterno1 = response.ListaDatosEmpleado[i].apellidoPaterno;
                   	var apellidoMaterno1 = response.ListaDatosEmpleado[i].apellidoMaterno;
                   	var nombreEmpleado1 = response.ListaDatosEmpleado[i].nombreEmpleado;       
        			var apellidoPaterno = $.trim(apellidoPaterno1);
        			var apellidoMaterno = $.trim(apellidoMaterno1);
        			var nombreEmpleado = $.trim(nombreEmpleado1);
                   	var nomenclaturaGenero = response.ListaDatosEmpleado[i].nomenclaturaGenero;
                   	var fechaNacimiento = response.ListaDatosEmpleado[i].fechaNacimiento;
                   	var paisNacimientoId = response.ListaDatosEmpleado[i].paisNacimientoId;
                   	var claveEntidadF = response.ListaDatosEmpleado[i].claveEntidadF;
                    var curpEmpleadoInterno=CrearCurp(apellidoPaterno,apellidoMaterno,nombreEmpleado,nomenclaturaGenero,fechaNacimiento,paisNacimientoId,claveEntidadF,1);
                    var rfcEmpleadoInterno = curpEmpleadoInterno.substr(0,10);
              		var numeroEmpleado1 = response.ListaDatosEmpleado[i].entidadFederativaId;
               		var numeroEmpleado2 = response.ListaDatosEmpleado[i].empleadoConsecutivoId;
               		var numeroEmpleado3 = response.ListaDatosEmpleado[i].empleadoCategoriaId;
               		var numeroEmpleadoTotal = (numeroEmpleado1 + "-" + numeroEmpleado2 + "-" + numeroEmpleado3);
	
               		var nombreEmpleado1 = response.ListaDatosEmpleado[i].apellidoPaterno;
               		var nombreEmpleado2 = response.ListaDatosEmpleado[i].apellidoMaterno;
               		var nombreEmpleado3 = response.ListaDatosEmpleado[i].nombreEmpleado;
               		var nombreEmpleadoTotal = (nombreEmpleado1 + " " + nombreEmpleado2 + " " + nombreEmpleado3);

               		var curpEmpleadoIngresado = response.ListaDatosEmpleado[i].curpEmpleado;
               		var rfcEmpleadoIngresado = response.ListaDatosEmpleado[i].rfcEmpleado;
               		if(curpEmpleadoIngresado=="" || curpEmpleadoIngresado=="null" || curpEmpleadoIngresado==null || curpEmpleadoIngresado=="NULL"){
               			response.ListaDatosEmpleado[i]["curpEmpleadoIngresado"] = "Sin Curp Ingresado";
               		}else{
               			response.ListaDatosEmpleado[i]["curpEmpleadoIngresado"] = curpEmpleadoIngresado;
               		}
               		if(rfcEmpleadoIngresado=="" || rfcEmpleadoIngresado=="null" || rfcEmpleadoIngresado==null || rfcEmpleadoIngresado=="NULL"){
               			response.ListaDatosEmpleado[i]["rfcEmpleadoIngresado"] = "Sin Rfc Ingresado";
               		}else{
               			response.ListaDatosEmpleado[i]["rfcEmpleadoIngresado"] = rfcEmpleadoIngresado;
               		}
               		response.ListaDatosEmpleado[i]["numeroEmpleadoTotal"] = numeroEmpleadoTotal; 
               		response.ListaDatosEmpleado[i]["nombreEmpleadoTotal"] = nombreEmpleadoTotal;
               		response.ListaDatosEmpleado[i]["curpEmpleadoInterno"] = curpEmpleadoInterno;
               		response.ListaDatosEmpleado[i]["rfcEmpleadoInterno"] = rfcEmpleadoInterno;
                	datosEmpleadosFinal.push(response.ListaDatosEmpleado[i]);
             	}              
               loadDataInTableCURPyRFC(datosEmpleadosFinal);
                waitingDialog.hide();
            }else if (response.status=="error")
              {
              	alert("ocurrio un error al consultar el empleado"); 
              	waitingDialog.hide();
              }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
             waitingDialog.hide();
        } 
    });
}

function CrearCurp(empleadoApellidoPaterno,empleadoApellidoMaterno,nombreEmpleado,descripcionGenero,fechaNacimiento,selectPaisNacimientoEdited,claveEntidadF){
  	if(selectPaisNacimientoEdited=="46"){
  	  var claveEntidadF = claveEntidadF;
  	}else{
  	  var claveEntidadF ="NE";
  	}
  	var apellidoPCompleto = empleadoApellidoPaterno.split(" ");
  	var largoapellidoPCompleto = apellidoPCompleto.length;
  	if(largoapellidoPCompleto > "1"){
  		for(var i=0; i < largoapellidoPCompleto; i++){
  			var apellidoPat =  apellidoPCompleto[i];
  			if((apellidoPat != "DA") && (apellidoPat != "DAS") && (apellidoPat != "DE") && (apellidoPat != "DEL") && (apellidoPat != "DER") && (apellidoPat != "DI") && (apellidoPat != "DIE") && (apellidoPat != "DD") && (apellidoPat != "EL") && (apellidoPat != "LA") && (apellidoPat != "LOS") && (apellidoPat != "LAS") && (apellidoPat != "LE") && (apellidoPat != "LES") && (apellidoPat != "MAC") && (apellidoPat != "MC") && (apellidoPat != "VAN") && (apellidoPat != "VON") && (apellidoPat != "Y") && (apellidoPat != "CON")){
  				var LetraApellidoP = apellidoPat.substr(0,1);
  				var PrimeraVocalApellidoP = apellidoPat.substring(1).replace (/[^ a, e, i, o, u, A, E, I, O, U]/g,'').substring(0, 1);
  				var ConsonanteApellidoP = apellidoPat.trim().substring(1).replace(/[AEIOU]/ig, '').substring(0, 1);
  				i=largoapellidoPCompleto;
  			} 
  		}
  	}else{
  		var LetraApellidoP = empleadoApellidoPaterno.substr(0,1);
  		var PrimeraVocalApellidoP = empleadoApellidoPaterno.substring(1).replace (/[^ a, e, i, o, u, A, E, I, O, U]/g,'').substring(0, 1);
  		var ConsonanteApellidoP = empleadoApellidoPaterno.trim().substring(1).replace(/[AEIOU]/ig, '').substring(0, 1);
  	}
  	
  	if(empleadoApellidoMaterno==""){
  		var LetraApellidoM = "";
  		var ConsonanteApellidoM = "";
  	}else{
  		var apellidoMCompleto = empleadoApellidoMaterno.split(" ");
  		var largoapellidoMCompleto = apellidoMCompleto.length;
  		if(largoapellidoMCompleto > "1"){
  			for(var i=0; i < largoapellidoMCompleto; i++){
  				var apellidoMat =  apellidoMCompleto[i];
  				if((apellidoMat != "DA") && (apellidoMat != "DAS") && (apellidoMat != "DE") && (apellidoMat != "DEL") && (apellidoMat != "DER") && (apellidoMat	 != "DI") && (apellidoMat != "DIE") && (apellidoMat != "DD") && (apellidoMat != "EL") && (apellidoMat != "LA") && (apellidoMat != "LOS") &&	 (apellidoMat != "LAS") && (apellidoMat != "LE") && (apellidoMat != "LES") && (apellidoMat != "MAC") && (apellidoMat != "MC") && (	apellidoMat != "VAN") && (apellidoMat != "VON") && (apellidoMat != "Y") && (apellidoMat != "CON")){
  					var LetraApellidoM = apellidoMat.substr(0,1);
  					var ConsonanteApellidoM = apellidoMat.trim().substring(1).replace(/[AEIOU]/ig, '').substring(0, 1);
  					i=largoapellidoMCompleto;
  				} 
  			}
  		}else{
  			var LetraApellidoM = empleadoApellidoMaterno.substr(0,1);
  			var ConsonanteApellidoM = empleadoApellidoMaterno.trim().substring(1).replace(/[AEIOU]/ig, '').substring(0, 1);
  		}
  	}
// Se Obtiene Las Vocales y Consonantes de Los Nombres
  	var nombreSplit = nombreEmpleado.split(" ");
  	var LargoNombreSplit = nombreSplit.length;
  	if(LargoNombreSplit > "1"){
  		for(var i=0; i < LargoNombreSplit; i++){	
  	  		var primerNombre =  nombreSplit[i];
    		if((primerNombre != "MARIA") && (primerNombre != "MA.") && (primerNombre != "MA") && (primerNombre != "maria") && (primerNombre != "ma.") && (primerNombre != "ma") && (primerNombre != "Maria") && (primerNombre != "Ma.") && (primerNombre != "Ma") && (primerNombre != "JOSE") && (primerNombre != "J.") && (primerNombre != "J") && (primerNombre != "jose") && (primerNombre != "j.") && (primerNombre != "j") && (primerNombre != "Jose") && (primerNombre != "DA") && (primerNombre != "DAS") && (primerNombre != "DE") && (primerNombre != "DEL") && (primerNombre != "DER") && (primerNombre != "DI") && (primerNombre != "DIE") && (primerNombre != "DD") && (primerNombre != "EL") && (primerNombre != "LA") && (primerNombre != "LOS") &&	 (primerNombre != "LAS") && (primerNombre != "LE") && (primerNombre != "LES") && (primerNombre != "MAC") && (primerNombre != "MC") && (	primerNombre != "VAN") && (primerNombre != "VON") && (primerNombre != "Y")){
      			var letraNombre = primerNombre.substr(0,1);
      			var ConsonanteNombre = primerNombre.trim().substring(1).replace(/[AEIOU]/ig, '').substring(0, 1);
      			i=LargoNombreSplit;
    		}else{
    			if(i == LargoNombreSplit-1){
    				var letraNombre = primerNombre.substr(0,1);
      				var ConsonanteNombre = primerNombre.trim().substring(1).replace(/[AEIOU]/ig, '').substring(0, 1);
      			}
    		}
    	}
  	}else{
    	var primerNombre =  nombreSplit[0];
    	var letraNombre = primerNombre.substr(0,1);
    	var ConsonanteNombre = primerNombre.trim().substring(1).replace(/[AEIOU]/ig, '').substring(0, 1);
  	}    



  	if(LetraApellidoP == "Ñ" || LetraApellidoP == "ñ" || LetraApellidoP == "/" || LetraApellidoP == "-" || LetraApellidoP == "."){
    	LetraApellidoP="X";
  	}if(PrimeraVocalApellidoP == "Ñ" || PrimeraVocalApellidoP == "ñ" || PrimeraVocalApellidoP == "/" || PrimeraVocalApellidoP == "-" || PrimeraVocalApellidoP == "." || PrimeraVocalApellidoP == ""){
    	PrimeraVocalApellidoP="X";
  	}if(LetraApellidoM == "Ñ" || LetraApellidoM == "ñ" || LetraApellidoM == "/" || LetraApellidoM == "-" || LetraApellidoM == "." || LetraApellidoM == ""){
    	LetraApellidoM="X";                          
  	}if(letraNombre == "Ñ" || letraNombre == "ñ" || letraNombre == "/" || letraNombre == "-" || letraNombre == "."){
    	letraNombre="X";                          
  	}
  	if (fechaNacimiento == "" || fechaNacimiento == null || fechaNacimiento == "null" || fechaNacimiento == "NULL"){
  		var FechaMes = "00";
  		var FechaDia = "00";
  		var FechaAnio = "00";
  	}else{
  		var echa11 = fechaNacimiento.split("-");
  		var fechaAnio1 = echa11[0];
  		var FechaMes = echa11[1];
  		var FechaDia = echa11[2];
  		var FechaAnio = fechaAnio1.substr(2,3);
  	}
  	if(descripcionGenero == "M"){
    	var LetraGenero = "H";
  	}else if(descripcionGenero == "F"){
    	var LetraGenero = "M";
  	} 
  	if(ConsonanteApellidoP == "Ñ" || ConsonanteApellidoP == "ñ" || ConsonanteApellidoP == ""){
    	ConsonanteApellidoP = "X";
  	}if(ConsonanteApellidoM == "Ñ" || ConsonanteApellidoM == "ñ" || ConsonanteApellidoM == ""){
  	  ConsonanteApellidoM = "X";
  	}if(ConsonanteNombre == "Ñ" || ConsonanteNombre == "ñ" || ConsonanteNombre == ""){
  	  ConsonanteNombre = "X";
  	}

if(LetraApellidoP=="Ä"){LetraApellidoP = "A";} if(PrimeraVocalApellidoP=="Ä"){PrimeraVocalApellidoP = "A";} if(LetraApellidoM=="Ä"){LetraApellidoM = "A";}
if(LetraApellidoP=="ä"){LetraApellidoP = "a";} if(PrimeraVocalApellidoP=="ä"){PrimeraVocalApellidoP = "a";} if(LetraApellidoM=="ä"){LetraApellidoM = "a";} 
if(LetraApellidoP=="Ë"){LetraApellidoP = "E";} if(PrimeraVocalApellidoP=="Ë"){PrimeraVocalApellidoP = "E";} if(LetraApellidoM=="Ë"){LetraApellidoM = "E";} 
if(LetraApellidoP=="ë"){LetraApellidoP = "e";} if(PrimeraVocalApellidoP=="ë"){PrimeraVocalApellidoP = "e";} if(LetraApellidoM=="ë"){LetraApellidoM = "e";} 
if(LetraApellidoP=="Ï"){LetraApellidoP = "I";} if(PrimeraVocalApellidoP=="Ï"){PrimeraVocalApellidoP = "I";} if(LetraApellidoM=="Ï"){LetraApellidoM = "I";} 
if(LetraApellidoP=="ï"){LetraApellidoP = "i";} if(PrimeraVocalApellidoP=="ï"){PrimeraVocalApellidoP = "i";} if(LetraApellidoM=="ï"){LetraApellidoM = "i";} 
if(LetraApellidoP=="Ö"){LetraApellidoP = "O";} if(PrimeraVocalApellidoP=="Ö"){PrimeraVocalApellidoP = "O";} if(LetraApellidoM=="Ö"){LetraApellidoM = "O";} 
if(LetraApellidoP=="ö"){LetraApellidoP = "o";} if(PrimeraVocalApellidoP=="ö"){PrimeraVocalApellidoP = "o";} if(LetraApellidoM=="ö"){LetraApellidoM = "o";} 
if(LetraApellidoP=="Ü"){LetraApellidoP = "U";} if(PrimeraVocalApellidoP=="Ü"){PrimeraVocalApellidoP = "U";} if(LetraApellidoM=="Ü"){LetraApellidoM = "U";} 
if(LetraApellidoP=="ü"){LetraApellidoP = "u";} if(PrimeraVocalApellidoP=="ü"){PrimeraVocalApellidoP = "u";} if(LetraApellidoM=="ü"){LetraApellidoM = "u";}

if(letraNombre=="Ä"){letraNombre = "A";} if(ConsonanteApellidoP=="Ä"){ConsonanteApellidoP = "A";} if(ConsonanteApellidoM=="Ä"){ConsonanteApellidoM = "A";}
if(letraNombre=="ä"){letraNombre = "a";} if(ConsonanteApellidoP=="ä"){ConsonanteApellidoP = "a";} if(ConsonanteApellidoM=="ä"){ConsonanteApellidoM = "a";}
if(letraNombre=="Ë"){letraNombre = "E";} if(ConsonanteApellidoP=="Ë"){ConsonanteApellidoP = "E";} if(ConsonanteApellidoM=="Ë"){ConsonanteApellidoM = "E";}
if(letraNombre=="ë"){letraNombre = "e";} if(ConsonanteApellidoP=="ë"){ConsonanteApellidoP = "e";} if(ConsonanteApellidoM=="ë"){ConsonanteApellidoM = "e";}
if(letraNombre=="Ï"){letraNombre = "I";} if(ConsonanteApellidoP=="Ï"){ConsonanteApellidoP = "I";} if(ConsonanteApellidoM=="Ï"){ConsonanteApellidoM = "I";}
if(letraNombre=="ï"){letraNombre = "i";} if(ConsonanteApellidoP=="ï"){ConsonanteApellidoP = "i";} if(ConsonanteApellidoM=="ï"){ConsonanteApellidoM = "i";}
if(letraNombre=="Ö"){letraNombre = "O";} if(ConsonanteApellidoP=="Ö"){ConsonanteApellidoP = "O";} if(ConsonanteApellidoM=="Ö"){ConsonanteApellidoM = "O";}
if(letraNombre=="ö"){letraNombre = "o";} if(ConsonanteApellidoP=="ö"){ConsonanteApellidoP = "o";} if(ConsonanteApellidoM=="ö"){ConsonanteApellidoM = "o";}
if(letraNombre=="Ü"){letraNombre = "U";} if(ConsonanteApellidoP=="Ü"){ConsonanteApellidoP = "U";} if(ConsonanteApellidoM=="Ü"){ConsonanteApellidoM = "U";}
if(letraNombre=="ü"){letraNombre = "u";} if(ConsonanteApellidoP=="ü"){ConsonanteApellidoP = "u";} if(ConsonanteApellidoM=="ü"){ConsonanteApellidoM = "u";}

if(ConsonanteNombre=="Ä"){ConsonanteNombre = "A";}
if(ConsonanteNombre=="ä"){ConsonanteNombre = "a";}
if(ConsonanteNombre=="Ë"){ConsonanteNombre = "E";}
if(ConsonanteNombre=="ë"){ConsonanteNombre = "e";}
if(ConsonanteNombre=="Ï"){ConsonanteNombre = "I";}
if(ConsonanteNombre=="ï"){ConsonanteNombre = "i";}
if(ConsonanteNombre=="Ö"){ConsonanteNombre = "O";}
if(ConsonanteNombre=="ö"){ConsonanteNombre = "o";}
if(ConsonanteNombre=="Ü"){ConsonanteNombre = "U";}
if(ConsonanteNombre=="ü"){ConsonanteNombre = "u";}

  	var palabraAntisonante = LetraApellidoP+PrimeraVocalApellidoP+LetraApellidoM+letraNombre; 
  	//var palabraAntisonante ="COCA"
  	$.ajax({
  	  type: "POST",
  	  url: "ajax_ObtenerPalabrasAntisonantes.php",
  	  data: {"palabraAntisonante": palabraAntisonante},
  	  dataType: "json",
  	  async:false,
  	  success: function(response) {
  	    if (response.status == "success")
  	    {
  	      var catalogoPalabraAntison = response.CatalogoPalabraAntison.length;
  	      if(catalogoPalabraAntison == "1"){
  	        var PlabraAntisonanteSustitucion = response.CatalogoPalabraAntison[0].PalabraSustitucion;
  	        palabraAntisonante = PlabraAntisonanteSustitucion;
  	      }
  	    }
  	  },
  	  error: function(jqXHR, textStatus, errorThrown){
  	    alert(jqXHR.responseText);
  	  }
  	});
  	var CurpInternoTotal = palabraAntisonante+FechaAnio+FechaMes+FechaDia+LetraGenero+claveEntidadF+ConsonanteApellidoP+ConsonanteApellidoM+ConsonanteNombre;
  	return(CurpInternoTotal);
}

function loadDataInTableCURPyRFC(data) {
    if (datosEmpleadosFinal != null) {
        //datosEmpleadosFinal.destroy();
    }
    datosEmpleadosFinal = $('#tablaCurpYRfc').DataTable({
        "language": {
            "emptyTable": "No hay registro disponible",
            "info": "Del _START_ al _END_ de _TOTAL_",
            "infoEmpty": "Mostrando 0 registros de un total de 0.",
            "infoFiltered": "(filtrados de un total de _MAX_ registros)",
            "infoPostFix": "(actualizados)",
            "lengthMenu": "Mostrar _MENU_ registros",
            "loadingRecords": "Cargando....",
            "processing": "Procesando....",
            "search": "Buscar:",
            "searchPlaceholder": "Dato para buscar",
            "zeroRecords": "no se han encontrado coincidencias",
            "paginate": {
                "first": "Primera",
                "last": "Ultima",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": "Ordenación ascendente",
                "sortDescending": "Ordenación descendente"
            }
        },
        data: data,
        destroy: true,
        "columns": [{
            "data": "numeroEmpleadoTotal"
        }, {
            "data": "nombreEmpleadoTotal"
        }, {
            "data": "curpEmpleadoIngresado"
        }, {
            "data": "curpEmpleadoInterno"
        }, {
            "data": "rfcEmpleadoIngresado"
        }, {
            "data": "rfcEmpleadoInterno",
        }],
        "columnDefs": [{
            "targets": [],
            "orderable": false
        }],
         processing: true,
         dom: 'Bfrtip',
         buttons: ['excel']
    });
    var table = $("#tablaCurpYRfc").DataTable();
   
}

</script>



