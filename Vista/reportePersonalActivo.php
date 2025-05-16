<form class="form-horizontal"  method="post" id="form_consultaGeneral" name='form_consultaGeneral' action="ficheroExportGeneral.php" target="_blank">

	  	<fieldset >        
            <legend>REPORTE GENERAL</legend>
        </fieldset>

<button type='button' class='btn btn-info' id='btnGenerarReportePersonalActivo' name='btnGenerarReportePersonalActivo' onclick='generarReporteGeneral3();'>Generar Reporte <span class='glyphicon glyphicon-refresh' ></span></button> 
 <!-- <button type='button' class='btn btn-info' id='btnGenerarReportePersonalActivo' name='btnGenerarReportePersonalActivo' onclick='generarReporteGeneral2();'>Generar Reporte <span class='glyphicon glyphicon-refresh' ></span></button>-->
<!-- <button type='button' class='btn btn-info' id='btnDescargarReporte' name='btnDescargarReporte' onclick='generarReporteGeneral3();'>Descargar <span class='glyphicon glyphicon-refresh' ></span></button> -->
<input type="hidden" id="datos_a_enviarReporte" name="datos_a_enviarReporte" />
<div id='consultaEmpleados' name='consultaEmpleados'>
	
</div>


</form>
<script type="text/javascript">
function generarReporteGeneral()
    {

      
 
      $.ajax({
            
            type: "POST",
            url: "ajax_obtenerConsultaGeneral.php",
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                     
                    var listaEmpleados = response.listaEmpleados;
                                    
                    listaEmpleadosTable="<table class='table table-bordered' id='reporteGeneralExport' name='reporteGeneralExport'><thead><th>#Empleado</th><th>apellidoPaterno</th><th>apellidoMaterno</th><th>Nombre</th><th>fechaIngreso</th><th>RFC</th><th>CURP</th>";
                    listaEmpleadosTable +="<th>NumeroIMSS</th><th>numeroCta</th><th>numeroCtaClabe</th><th>Puesto</th><th>TipoPuesto</th><th>TipoTurno</th><th>Sexo</th><th>EstatusEmpleado</th><th>fechaBaja</th><th>EdoCivil</th>";
                    listaEmpleadosTable +="<th>fechaNacimiento</th><th>paisNacimiento</th><th>nacionalidad</th><th>EntidadNacimiento</th><th>municipioNacimiento</th><th>GradoEstudios</th><th>estatusCartilla</th><th>numeroCartilla</th><th>oficio</th><th>tipoSangre</th>";
                    listaEmpleadosTable +="<th>calle</th><th>numeroExterior</th><th>numeroInterior</th><th>Colonia</th><th>Municipio</th><th>entidadFederativa</th><th>telefonoFijo</th>";
                    listaEmpleadosTable +="<th>Tel Movil</th><th>Correo</th><th>Umf</th></thead><tbody>";

                    for ( var i = 0; i < listaEmpleados.length; i++ ){
                    	var numeroEmpleado = listaEmpleados[i].numeroEmpleado;
                        var apellidoPaterno = listaEmpleados[i].apellidoPaterno;
                        var apellidoMaterno = listaEmpleados[i].apellidoMaterno;
                        var nombreEmpleado = listaEmpleados[i].nombreEmpleado;
                        var fechaIngreso = listaEmpleados[i].fechaIngreso;
                        var Rfc =listaEmpleados[i].Rfc;
                        var Curp= listaEmpleados[i].Curp;
                        var NumeroIMSS = listaEmpleados[i].NumeroIMSS;
                        var numeroCta = listaEmpleados[i].numeroCta;
                        var numeroCtaClabe=listaEmpleados[i].numeroCtaClabe;
                        var Puesto=listaEmpleados[i].Puesto;
                        var TipoPuesto=listaEmpleados[i].TipoPuesto;
                        var TipoTurno=listaEmpleados[i].TipoTurno;
                        var Sexo=listaEmpleados[i].Sexo;
                        var EstatusEmpleado=listaEmpleados[i].EstatusEmpleado;
                        var fechaBajaEmpleado=listaEmpleados[i].fechaBajaEmpleado;
                        var EdoCivil=listaEmpleados[i].EdoCivil;
                        var fechaNacimiento=listaEmpleados[i].fechaNacimiento;
                        var nombrePais=listaEmpleados[i].nombrePais;
                        var nacionalidad=listaEmpleados[i].nacionalidad;
                        var entidadFederativaNac=listaEmpleados[i].entidadFederativaNac;
                        var municipioNacimiento=listaEmpleados[i].municipioNacimiento;
                        var GradoEstudios=listaEmpleados[i].GradoEstudios;

                        var estatusCartilla=listaEmpleados[i].estatusCartilla;
                        var numeroCartilla=listaEmpleados[i].numeroCartilla;
                        var oficio=listaEmpleados[i].oficio;
                        var tipoSangre=listaEmpleados[i].tipoSangre;
                        var calle=listaEmpleados[i].calle;
                        var numeroExterior=listaEmpleados[i].numeroExterior;
                        var numeroInterior=listaEmpleados[i].numeroInterior;
                        var Colonia=listaEmpleados[i].Colonia;
                        var nombreMunicipio=listaEmpleados[i].nombreMunicipio;
                        var entidadFederativa=listaEmpleados[i].entidadFederativa;
                        var telefonoFijoEmpleado=listaEmpleados[i].telefonoFijoEmpleado;
                        var telefonoMovilEmpleado=listaEmpleados[i].telefonoMovilEmpleado;
                        var correoEmpleado=listaEmpleados[i].correoEmpleado;
                        var nombreUnidad=listaEmpleados[i].nombreUnidad;
                        //var domicilioUnidad=listaEmpleados[i].domicilioUnidad;
                        //var codigoPostalUnidad=listaEmpleados[i].codigoPostalUnidad;
                                                                 
                  listaEmpleadosTable += "<tr><td>"+numeroEmpleado+" </td><td>"+apellidoPaterno+" </td><td>"+apellidoMaterno+"</td><td>"+nombreEmpleado+"</td><td>"+fechaIngreso+"</td><td>"+Rfc+"</td><td>"+Curp+"</td>";
                  listaEmpleadosTable += "<td>"+NumeroIMSS+"</td><td style='mso-number-format:'@';'>"+numeroCta+"</td><td>"+numeroCtaClabe+"</td><td>"+Puesto+"</td><td>"+TipoPuesto+"</td><td>"+TipoTurno+"</td>";
                  listaEmpleadosTable += "<td>"+Sexo+" </td><td>"+EstatusEmpleado+"</td><td>"+fechaBajaEmpleado+"</td><td>"+EdoCivil+"</td><td>"+fechaNacimiento+"</td>";
                  listaEmpleadosTable += "<td>"+nombrePais+" </td><td>"+nacionalidad+"</td><td>"+entidadFederativaNac+"</td><td>"+municipioNacimiento+"</td><td>"+GradoEstudios+"</td>";
                  listaEmpleadosTable += "<td>"+estatusCartilla+" </td><td>"+numeroCartilla+"</td><td>"+oficio+"</td><td>"+tipoSangre+"</td><td>"+calle+"</td>";
                  listaEmpleadosTable += "<td>"+numeroExterior+" </td><td>"+numeroInterior+"</td><td>"+Colonia+"</td><td>"+nombreMunicipio+"</td><td>"+entidadFederativa+"</td>";
                  listaEmpleadosTable += "<td>"+telefonoFijoEmpleado+" </td><td>"+telefonoMovilEmpleado+"</td><td>"+correoEmpleado+"</td><td>"+nombreUnidad+"</td><tr>";
 
                }
                     
                  listaEmpleadosTable += "</tbody></table>";
                  $('#consultaEmpleados').html(listaEmpleadosTable);     
                   
                   
                 }
            },           

            error: function (response)
            {
                console.log (response);

            }
        });


    }

    function generarReporteGeneral2()
    {
        window.open('exportConsultaGeneral.php',"width=600,height=600,scrollbars=no");
    }

    function generarReporteGeneral3()
    {
        window.open('consultaGeneralOp.php',"width=600,height=600,scrollbars=no");
    }
    

    function descargarReporte(){
    	
     $("#datos_a_enviarReporte").val( $("<div>").append( $("#reporteGeneralExport").eq(0).clone()).html());
     $("#form_consultaGeneral").submit();
    

    }

</script>