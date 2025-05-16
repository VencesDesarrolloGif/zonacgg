<?php

?>
<div class="container" align="center">

  <form name="form_renovacionCredenciales" id="form_renovacionCredenciales">
<span class="label">Entidad</span>

<select id="idEndidadFederativaCredencial" name="idEndidadFederativaCredencial" class="input-large " onchange="consultaEmpleadosPorEntidad();" >
             <option>ENTIDAD FEDERATIVA</option>
              <?php
                for ($i=0; $i<count($catalogoEntidadesFederativas); $i++)
                {
                echo "<option value='". $catalogoEntidadesFederativas[$i]["idEntidadFederativa"]."'>". $catalogoEntidadesFederativas[$i]["nombreEntidadFederativa"] ." </option>";
                }
              ?>
</select>

<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>

<div id="listaEmpleadosEntidad" ></div>
  </form>

</div>

<script type="text/javascript">

function seleccionar_todo(){ 
   for (i=0;i<document.form_renovacionCredenciales.elements.length;i++) 
      if(document.form_renovacionCredenciales.elements[i].type == "checkbox")  
         document.form_renovacionCredenciales.elements[i].checked=1 
} 
function deseleccionar_todo(){ 
   for (i=0;i<document.form_renovacionCredenciales.elements.length;i++) 
      if(document.form_renovacionCredenciales.elements[i].type == "checkbox")  
         document.form_renovacionCredenciales.elements[i].checked=0 
}

function generarCredencialesNuevas()
    {
      var entidadCredenciales=$("#idEndidadFederativaCredencial").val();
      
      var empleadosSeleccionados = $( "input[type=checkbox]:checked");
      
      var empleadosConfirmadosParaCredencial = [];
      
        for (var i = 0; i < empleadosSeleccionados.length; i++)
        {
            if (empleadosSeleccionados[i].checked == true && (empleadosSeleccionados[i].value.match (/[0-9]{2}\-[0-9]{4}\-[0-9]{2}/g) || empleadosSeleccionados[i].value.match (/[0-9]{2}\-[0-9]{5}\-[0-9]{2}/g)))
            {
                empleadosConfirmadosParaCredencial.push (empleadosSeleccionados[i].value);
            }
        }
       
        if (empleadosConfirmadosParaCredencial.length > 0)
        {
           // window.open("generarCredencialesNuevas.php?entidadCredenciales=" +
           //     entidadCredenciales + 
           //     "&empleados=" + JSON.stringify (empleadosConfirmadosParaCredencial),
            //    '_blank','fullscreen=no');

            window.open("generadorNuevaCredencialMasiva.php?entidadCredenciales=" +
                entidadCredenciales + 
                "&empleados=" + JSON.stringify (empleadosConfirmadosParaCredencial),
                '_blank','fullscreen=no');
        }
        else
        {
            alert ("Seleccione los empleados para los que quiere generar una nueva credencial");
        }
    }


    function consultaEmpleadosPorEntidad()
{
    var enditad = $("#idEndidadFederativaCredencial").val();
    

 $.ajax({
            
            type: "POST",
            url: "ajax_consultaEmpleadosPorEntidad.php",
            data:{"enditad":enditad},
            dataType: "json",
             success: function(response) {
                if (response.status == "success")
                {
                  
                    var empleado = response.empleado;

                    
                    listaPersonalActivoTable="<form id='checkEmpleadosForm'><table class='table table-hover' id='Exportar_a_Excel'><thead><th># Empleado</th><th>Nombre</th><th>Fecha Ingreso</th><th>Generar Credencial</th></thead><tbody>";

                    if (empleado.length > 0)
                    {
                        listaPersonalActivoTable+="<br/>";
                        listaPersonalActivoTable+="<a href='javascript:seleccionar_todo()'>Marcar todos</a>";
                        listaPersonalActivoTable+="<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
                        listaPersonalActivoTable+="<a href='javascript:deseleccionar_todo()'>Marcar ninguno</a>";
                        listaPersonalActivoTable+="<br/>";
                        listaPersonalActivoTable+="<button type='button' class='btn btn-secondary' onclick='generarCredencialesNuevas();'>Generar Credenciales <span class='glyphicon glyphicon-download-alt' aria-hidden='true'></span></button>"
                    }
                    
                    for ( var i = 0; i < empleado.length; i++ ){
                      var apellidoPaterno = empleado[i].apellidoPaterno;
                      var apellidoMaterno = empleado[i].apellidoMaterno;
                      var nombreEmpleado = empleado[i].nombreEmpleado;
                      var empleadoNumeroSeguroSocial= empleado[i].empleadoNumeroSeguroSocial;
                      var rfcEmpleado= empleado[i].rfcEmpleado;
                      var calle= empleado[i].calle;
                      var numeroExterior = empleado[i].numeroExterior;
                      var numeroInterior =empleado[i].numeroInterior;
                      var fechaIngreso =empleado[i].fechaIngresoEmpleado;
                      var curp =empleado[i].curp;
                      var puesto= empleado[i].puesto;
                      var fotoEmpleado=empleado[i].fotoEmpleado;
                      var numeroEmpleado=empleado[i].entidadFederativaId+"-"+empleado[i].empleadoConsecutivoId+"-"+empleado[i].empleadoCategoriaId;
                      var nombreCompletoEmpleado= apellidoPaterno+" "+apellidoMaterno+" "+nombreEmpleado;

                      listaPersonalActivoTable += "<tr></td><td>"+numeroEmpleado+"</td><td>"
                      +nombreCompletoEmpleado+"</td><td>"+fechaIngreso+"</td><td><input type='checkbox' value='"+numeroEmpleado+"'></td><tr>";
                    }

                    listaPersonalActivoTable += "</tbody></table></form>";
                    $('#listaEmpleadosEntidad').html(listaPersonalActivoTable); 
                  
                }
                else if (response.status == "error" && response.message == "No autorizado")
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
