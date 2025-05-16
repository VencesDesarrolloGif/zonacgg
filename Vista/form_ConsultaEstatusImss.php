<div class="container" align="center">


	 <span class="label">Número Empleado</span><input type="text" name="txtNumeroEmpleadoImss" id="txtNumeroEmpleadoImss" onkeyup="verificaConsultaEmpleadoImss();"><img src="img/search.png">

	<div >
        <table class="table table-bordered" id="tableEmpleadoEstatusImss" name="tableEmpleadoEstatusImss">
            <tr>
                <th>#Empleado</th>
                <th>Nombre</th>
                <th>Estatus RH</th>
                <th>Estatus Imss</th>
                <th>Fecha Ingreso RH</th>
                <th>Fecha Ingreso Imss</th>
                <th>Fecha Baja RH</th>
                <th>Fecha Baja Imss</th>
            </tr>

        </table>
    </div>

</div>


<script type="text/javascript">
function verificaConsultaEmpleadoImss() 
{
  var txtNumeroEmpleadoImss = $("#txtNumeroEmpleadoImss").val ();
  var expreg = /^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/;
  var expreg1 = /^[0-9]{2}\-[0-9]{5}\-[0-9]{2}/;
  

  if (txtNumeroEmpleadoImss.length != 10 && txtNumeroEmpleadoImss.length != 11)
    {
      return;
    }

  if(expreg.test(txtNumeroEmpleadoImss) || expreg1.test(txtNumeroEmpleadoImss))
  {
     var numeroEmpleado = $("#txtNumeroEmpleadoImss").val();
      consultaEstatusImssEmpleado(numeroEmpleado);
  }
}

	function consultaEstatusImssEmpleado(numeroEmpleado){
    //$('#tableEmpleadoEstatusImss').empty();
		$("#tableEmpleadoEstatusImss").find("tr:gt(0)").remove();
		    $.ajax({
            
            type: "POST",
            url: "ajax_obtenerEmpleadoPorId.php",
            data: {"numeroEmpleado": numeroEmpleado},
            dataType: "json",
             success: function(response) {
                if (response.status == "success")
                {                    
                    var empleadoEncontrado = response.empleado;

                    if(empleadoEncontrado.length<1){

                      $('#tableEmpleadoEstatusImss').append("<tr><td colspan='8' style='color:red;'><center><strong>No se encontró empleado</strong></center></td></tr>");
                      $("#txtNumeroEmpleadoImss").val("");


                    }else{                      
                      for ( var i = 0; i < empleadoEncontrado.length; i++ ){
                      var empleadoEntidad = empleadoEncontrado[i].entidadFederativaId;
                      var empleadoConsecutivo = empleadoEncontrado[i].empleadoConsecutivoId;
                      var empleadoCategoria = empleadoEncontrado[i].empleadoCategoriaId;
                      var empleadoApellidoPaterno= empleadoEncontrado[i].apellidoPaterno;
                      var empleadoApellidoMaterno= empleadoEncontrado[i].apellidoMaterno;
                      var nombreEmpleado= empleadoEncontrado[i].nombreEmpleado;
                      var estatusEmpleado=empleadoEncontrado[i].empleadoEstatusId;
                      var descripcionEstatusEmpleado=empleadoEncontrado[i].descripcionEstatusEmpleado;
                      var empleadoEstatusImss=empleadoEncontrado[i].empleadoEstatusImss;

                       var idTxtImssDatosImss=empleadoEncontrado[i].idTxtImssDatosImss;

                      if (idTxtImssDatosImss=='7' && (empleadoEstatusImss=='1' || empleadoEstatusImss=='2')) {
                        var descripcionEstatusImss="ACTIVO";
                      }else{
                          var descripcionEstatusImss=empleadoEncontrado[i].descripcionEstatusImss;
                      }

                      var fechaIngresoEmpleado = empleadoEncontrado[i].fechaIngresoEmpleado;
                      var empleadoFechaBaja=empleadoEncontrado[i].fechaBajaEmpleado;
                      var numeroEmpleadoCompleto=empleadoEncontrado[i].entidadFederativaId +"-"+ empleadoEncontrado[i].empleadoConsecutivoId+"-"+empleadoEncontrado[i].empleadoCategoriaId;
                      var nombreCompleto=empleadoApellidoPaterno+" "+empleadoApellidoMaterno+" "+nombreEmpleado;
                      var fechaImss=empleadoEncontrado[i].fechaImss;
                      var fechaBajaImss=empleadoEncontrado[i].fechaBajaImss;

                      if(estatusEmpleado==1 || estatusEmpleado==2){
                        fechaBajaImss="";
                        empleadoFechaBaja="";
                      }
                      if(empleadoEstatusImss == 3 || empleadoEstatusImss == "3" || empleadoEstatusImss == 7 || empleadoEstatusImss == "7"){
                        $('#tableEmpleadoEstatusImss').append(
                      "<tr><td>"+numeroEmpleadoCompleto+"</td><td>"+nombreCompleto+"</td><td>"+descripcionEstatusEmpleado+"</td><td>"+descripcionEstatusImss+
                      "</td><td>"+fechaIngresoEmpleado+"</td><td>"+fechaImss+"</td><td>"+empleadoFechaBaja+"</td><td>"+fechaBajaImss+"</td></tr>");
                      $("#txtNumeroEmpleadoImss").val("");
                      }else{
                        $('#tableEmpleadoEstatusImss').append(
                      "<tr><td>"+numeroEmpleadoCompleto+"</td><td>"+nombreCompleto+"</td><td>"+descripcionEstatusEmpleado+"</td><td>"+descripcionEstatusImss+
                      "</td><td>"+fechaIngresoEmpleado+"</td><td  style='color: red;'>"+fechaImss+"</td><td>"+empleadoFechaBaja+"</td><td>"+fechaBajaImss+"</td></tr>");
                      $("#txtNumeroEmpleadoImss").val("");
                      }
                      
                      } 

                    }
                                     
                                       
                    
                }else if (response.status == "error" && response.message == "No autorizado")
                {
                    window.location = "login.php";
                }
            },
            error: function (response)
            {
                console.log (response);

            }
        });

	}
</script>