<div id="alertMsgConsulta"> 
  </div>
<label class="control-label2 label" for="numeroCta">Cliente</label> 
        <select id='selectClienteConsulta' name='selectClienteConsulta' class='input-large' onchange='consultaPlanillaCliente(); consultaPlantillasPuntosServiciosByCliente();'><option>Cliente</option></select>
        <br>

    <div class="span12" >
      <a href="consultaPlantillaGeneral.php">Mostrar general</a>
        
        <div   id='consultaPlantillaCliente' name='consultaPlantillaCliente'></div>
        <br>
        <div><input type="text" name="txtSearchPS" id="txtSearchPS"class="input-xlarge" placeholder="NOMBRE PUNTO SERVICIO" aria-describedby="basic-addon2" ><img src="img/search.png"></div>
        <div id='consultaPuntosByCliente' name='consultaPuntosByCliente'></div>
    </div>

    <div class="span9">
 
        <div class="borderDiv">
        
        <div align="center">
            <fieldset ><legend>DETALLES<div id="namePoint2" name="namePoint2"></div></legend></fieldset>
        </div>
        <div id="divRequisiciones" name='divRequisiciones'> </div>
        </div>
        <br>
        <div id="divClass" >
            <div id="detallesAsignacion" align="center"></div>      
            <div id="divAsignacion" name='divAsignacion'> </div>
        </div>

     </div>

    <div class="span10 borderDiv" >
            <div align="center">
                <fieldset ><legend>DETALLES<div id="namePoint" name="namePoint"></div></legend></fieldset>
            </div>
            
            <div id="detallesConsulta"></div>

    </div>

<script type="text/javascript">
    

    function obtenerListaClientesConsultaRH()
    {
       $.ajax({
            type: "POST",
            url: "ajax_obtenerListaClientes.php",
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                    var cliente = response.listaClientes;
                    
                    clienteOptions = "<option>CLIENTES</option>";
                    for (var i = 0; i < cliente.length; i++)
                    {
                        clienteOptions += "<option value='" + cliente[i].idCliente + "'>" + cliente[i].razonSocial + "</option>";
                    }
                    
                    $("#selectClienteConsulta").html (clienteOptions);
                }
            },
            error: function (response)
            {
                console.log (response);
            }
        });
    }

    function consultaPlanillaCliente()
    {
        var idCliente=$("#selectClienteConsulta").val();


        //$('#consultaPlantillaCliente').html("");
      
 
      $.ajax({
            
            type: "POST",
            url: "ajax_consultaPlantillaGeneralByCliente.php",
            data: {"idCliente": idCliente},
            dataType: "json",
            
            success: function(response) {
                if (response.status == "success")
                {
                     
                    var lista = response.lista;
                                    
                    listaTable="<table class='table tablaRH' id='table2'><thead><th>idCliente</th><th>Cliente</th><th>Total Puntos</th><th>Elementos Solicitados</th><th>Elementos contratados</th><th>Asignados</th><th>Diferencia</th></thead><tbody>";

                    for ( var i = 0; i < lista.length; i++ ){
                        var idCliente = lista[i].idCliente;
                        var razonSocial = lista[i].razonSocial;
                        var totalPuntosServicios = lista[i].totalPuntosServicios;
                        var elementosSolicitados = lista[i].elementosSolicitados;
                        var elementosContratados = lista[i].elementosContratados;
                        var elementosAsignados = lista[i].elementosAsignados;
                        var direfencia= Math.abs(elementosSolicitados-elementosContratados);
                        
                                                                 
                  listaTable += "<tr class='modo2'><td>"+idCliente+" </td><td>"+razonSocial+" </td><td>"+totalPuntosServicios+"</td><td>"+elementosSolicitados+"</td><td>"+elementosContratados+"</td><td>"+elementosAsignados+"</td><td>"+direfencia+"</td><tr>";
 
                }
                     
                  listaTable += "</tbody></table>";
                  $('#consultaPlantillaCliente').html(listaTable);     
                   
                   
                 }
            },           

            error : function (jqXHR, textStatus, errorThrown)
            {
                alert (jqXHR.responseText);
            }
        });


    }

    function consultaPlantillasPuntosServiciosByCliente()
    {
        var idCliente=$("#selectClienteConsulta").val();

        //$('#consultaPlantillaCliente').html("");
      
 
      $.ajax({
            
            type: "POST",
            url: "ajax_consultaPlantillasPuntoServicioByCliente.php",
            data: {"idCliente": idCliente},
            dataType: "json",
            
            success: function(response) {
                if (response.status == "success")
                {
                     
                    var lista = response.lista;
                                    
                    listaTable="<table class='table tablaRH table-hover table-bordered'><thead><th>Id Punto</th><th>Punto Servicio</th><th>Centro Costo</th><th>Entidad</th><th>Elementos Solicitados</th><th>Elementos contratados</th><th>Asignados</th><th>Diferencia</th></thead><tbody>";

                    for ( var i = 0; i < lista.length; i++ ){
                        
                        var idPuntoServicio = lista[i].idPuntoServicio;
                        var puntoServicio = lista[i].puntoServicio;
                        var numeroCentroCosto = lista[i].numeroCentroCosto;
                        var idEntidadPunto = lista[i].idEntidadPunto;
                        var nombreEntidadFederativa = lista[i].nombreEntidadFederativa;
                        var nombreEntidadFederativa1 = lista[i].nombreEntidadFederativa1;
                        var elementosSolicitados = lista[i].elementosSolicitados;
                        var elementosContratados = lista[i].elementosContratados;
                        var elementosAsignados = lista[i].elementosAsignados;
                        var diferencia=  Math.abs(elementosSolicitados-elementosContratados);
                        
                                                                 
                  listaTable += "<tr><td>"+idPuntoServicio+" </td><td>"+puntoServicio+" </td><td>"+numeroCentroCosto+"</td><td>"+nombreEntidadFederativa1.toUpperCase()+"</td>";
                  listaTable += "<td>"+elementosSolicitados+" <a href='javascript:mostrarElementosSolicitados("+idPuntoServicio+", \"" +puntoServicio+ "\")' > Ver</a></td>"
                  listaTable += "<td>"+elementosContratados+"&nbsp &nbsp &nbsp<a href='javascript:mostrarElementosContratados("+idPuntoServicio+", \"" +puntoServicio+ "\");'>Detalles</a></td>";
                  listaTable += "<td>"+elementosAsignados+"&nbsp &nbsp &nbsp<a href='javascript:mostrarElementosAsignados("+idPuntoServicio+", \"" +puntoServicio+ "\");'>Ver</a></td><td>"+diferencia+"</td><tr>";
 
                }
                     
                  listaTable += "</tbody></table>";
                  $('#consultaPuntosByCliente').html(listaTable);     
                   
                   
                 }
            },           

            error : function (jqXHR, textStatus, errorThrown)
            {
                alert (jqXHR.responseText);
            }
        });


    }


    function consultaPlantillasPuntosServiciosByClientePuntoServicio()
    {
        var idCliente=$("#selectClienteConsulta").val();
        var puntoServicio=$("#txtSearchPS").val();

        //$('#consultaPlantillaCliente').html("");
    
       
      $.ajax({
            
            type: "POST",
            url: "ajax_consultaPlantillasPuntoServicioByClientePuntoServicio.php",
            data: {"idCliente": idCliente, "puntoServicio":puntoServicio},
            dataType: "json",
            
            success: function(response) {                
                var mensaje=response.message;


                if (response.status == "success")
                {
                     
                    var lista = response.lista;
                                    
                    listaTable="<table class='table tablaRH table-hover table-bordered'><thead><th>Id Punto</th><th>Punto Servicio</th><th>Centro Costo</th><th>Entidad</th><th>Elementos Solicitados</th><th>Elementos contratados</th><th>Asignados</th><th>Diferencia</th></thead><tbody>";

                    for ( var i = 0; i < lista.length; i++ ){
                        
                        var idPuntoServicio = lista[i].idPuntoServicio;
                        var puntoServicio = lista[i].puntoServicio;
                        var numeroCentroCosto = lista[i].numeroCentroCosto;
                        var idEntidadPunto = lista[i].idEntidadPunto;
                        var nombreEntidadFederativa = lista[i].nombreEntidadFederativa;
                        var nombreEntidadFederativa1 = lista[i].nombreEntidadFederativa1;
                        var elementosSolicitados = lista[i].elementosSolicitados;
                        var elementosContratados = lista[i].elementosContratados;
                        var elementosAsignados = lista[i].elementosAsignados;
                        var diferencia=  Math.abs(elementosSolicitados-elementosContratados);
                        
                                                                 
                  listaTable += "<tr><td>"+idPuntoServicio+" </td><td>"+puntoServicio+" </td><td>"+numeroCentroCosto+"</td><td>"+nombreEntidadFederativa1.toUpperCase()+"</td>";
                  listaTable += "<td>"+elementosSolicitados+" <a href='javascript:mostrarElementosSolicitados("+idPuntoServicio+", \"" +puntoServicio+ "\")' > Ver</a></td>"
                  listaTable += "<td>"+elementosContratados+"&nbsp &nbsp &nbsp<a href='javascript:mostrarElementosContratados("+idPuntoServicio+", \"" +puntoServicio+ "\");'>Detalles</a></td>";
                  listaTable += "<td>"+elementosAsignados+"&nbsp &nbsp &nbsp<a href='javascript:mostrarElementosAsignados("+idPuntoServicio+", \"" +puntoServicio+ "\");'>Ver</a></td><td>"+diferencia+"</td><tr>";
 
                }
                     
                  listaTable += "</tbody></table>";
                  $('#consultaPuntosByCliente').html(listaTable);     
                   
                   
                 }else if (response.status=="error")
                {
                  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error de consulta:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#alertMsgConsulta").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                }
            },           

            error : function (jqXHR, textStatus, errorThrown)
            {
                alert (jqXHR.responseText);
            }
        });


    }

     $('#txtSearchPS').keyup(function(event){  
       var keycode = (event.keyCode ? event.keyCode : event.which);  
      if(keycode == '13'){  
           //alert('Se ha presionado Enter!');  
           consultaPlantillasPuntosServiciosByClientePuntoServicio();
           //$("#txtSearchPS").val("");
      }   
 }); 

    function mostrarElementosContratados(idPuntoServicio, puntoServicio){
       // alert(idPuntoServicio);
        name="Elementos <u>contratados</u> en:<h2>"+puntoServicio+"</h2>";


        $('#namePoint').html(name);     

     
 
      $.ajax({
            
            type: "POST",
            url: "ajax_getEmpleadosByPuntoServicioId.php",
            data: {"puntoServicioId": idPuntoServicio},
            dataType: "json",
            
            success: function(response) {
                console.log(response);
                if (response.status == "success")
                {
                     
                    var lista = response.lista;
                                    
                    listaTable="<table class='table tablaRH2 table-hover table-bordered'><thead><th>No. Empleado</th><th>Nombre Empleado</th><th>Puesto</th><th>Turno</th><th>Rol</th><th>Plantilla</th><th>Supervisor</th><th>Estatus</th></thead><tbody>";

                    for ( var i = 0; i < lista.length; i++ ){
                        
                        var numeroEmpleado = lista[i].numeroEmpleado;
                        var nombreEmpleado = lista[i].nombreEmpleado;
                        var descripcionPuesto = lista[i].descripcionPuesto;
                        var descripcionTurno = lista[i].descripcionTurno;
                        var supervisor= lista[i].supervisor;
                        var estatusOperacionesId =lista[i].estatusOperacionesId; 
                        var descripcionEstatusOperaciones=lista[i].descripcionEstatusOperaciones; 
                        var roloperativo=lista[i].roloperativo; 
                        var requisicionId=lista[i].requisicionId; 


                        if(estatusOperacionesId==4){

                            descripcionEstatusOperaciones="ACTIVO";
                        }

                         
                                                                 
                  listaTable += "<tr><td>"+numeroEmpleado+" </td><td>"+nombreEmpleado+" </td><td>"+descripcionPuesto+"</td><td>"+descripcionTurno+"</td><td>"+roloperativo+"</td><td>"+requisicionId+"</td><td>"+supervisor+"</td><td>"+descripcionEstatusOperaciones+"</td><tr>";
 
                }
                     
                  listaTable += "</tbody></table>";
                  $('#detallesConsulta').html(listaTable);     
                   
                   
                 }
            },           

           error : function (jqXHR, textStatus, errorThrown)
            {
                alert (jqXHR.responseText);
            }
        });
    }

    function mostrarElementosSolicitados(idPuntoServicio, puntoServicio){
       // alert(idPuntoServicio);
        name="Requisiciones <u>solicitadas</u> para el punto:<h2>"+puntoServicio+"</h2>";

        var formatter = new Intl.NumberFormat('en-US', {
          style: 'currency',
          currency: 'USD',
          minimumFractionDigits: 2,
        });
        //alert(idPuntoServicio+" "+puntoServicio);

        $('#namePoint2').html(name);     
     
       $.ajax({
            
            type: "POST",
            url: "ajax_getDetalleRequisicionesByPuntoServicioId.php",
            data: {"puntoServicioId": idPuntoServicio},
            dataType: "json",
            
            success: function(response) {
                if (response.status == "success")
                {
                     
                    var lista = response.lista;
                                    
                    listaTable="<table class='table tablaRH3 table-hover table-bordered'><thead><th>#Elementos</th><th>Puesto</th><th>Turno</th><th>Rol</th><th>Plantilla</th><th>Fecha Inicio</th><th>Cuota</th></thead><tbody>";

                    for ( var i = 0; i < lista.length; i++ ){
                        
                        var numeroElementos = lista[i].numeroElementos;
                        var descripcionPuesto = lista[i].descripcionPuesto;
                        var descripcionTurno = lista[i].descripcionTurno;                        
                        var fechaInicio=lista[i].fechaInicio
                        var cuotaDiaria=lista[i].cuotaDiaria;
                        var rolOperativoPlantilla=lista[i].rolOperativoPlantilla;
                        var servicioPlantillaId=lista[i].servicioPlantillaId;

                        

                        if (cuotaDiaria==""){
                            cuotaDiaria=0;

                        }else{
                            cuotaDiaria=lista[i].cuotaDiaria.cuotaDiaria;
                        }
                                                                 
                  listaTable += "<tr><td>"+numeroElementos+" </td><td>"+descripcionPuesto+" </td><td>"+descripcionTurno+"</td><td>"+rolOperativoPlantilla+"</td><td>"+servicioPlantillaId+"</td><td>"+ fechaInicio+"</td>";
                  
                  <?php
                  if ($usuario["rol"] =="Contrataciones" || $usuario["rol"] =="Lider Unidad" || $usuario["rol"] =="Reclutador" || $usuario["rol"] =="Laborales" || $usuario["rol"] =="Direccion General" ){
                
                    ?>
                    listaTable +="<td>"+ formatter.format(cuotaDiaria)+"</td>";

                <?php
                }
                ?>
                  listaTable +="</tr>";
 
                }
                     
                  listaTable += "</tbody></table>";
                  $('#divRequisiciones').html(listaTable);     
                   
                   
                 }
            },           

            error : function (jqXHR, textStatus, errorThrown)
            {
                alert (jqXHR.responseText);
            }
        });
    }
        function mostrarElementosAsignados(idPuntoServicio, puntoServicio){
       // alert(idPuntoServicio);
        name="Elementos <u>asignados</u> para el punto:<h2>"+puntoServicio+"</h2>";
        detallesAsignacion=" <fieldset ><legend>DETALLES<div id='namePoint3' name='namePoint3'></div></legend></fieldset>";
        //alert(idPuntoServicio+" "+puntoServicio);
               
       $.ajax({
            
            type: "POST",
            url: "ajax_getElementosAsignadosPlantillaByPuntoServicioId.php",
            data: {"puntoServicioId": idPuntoServicio},
            dataType: "json",
            
            success: function(response) {
                if (response.status == "success")
                {
                     
                    var lista = response.lista;
                                    
                    listaTable="<table class='table tablaRH4 table-hover table-bordered'><thead><th>No. Empleado</th><th>Nombre</th><th>Sexo</th><th>Puesto</th><th>Turno</th><th>Rol</th><th>Plantilla</th></thead><tbody>";

                    for ( var i = 0; i < lista.length; i++ ){
                        
                        var numeroEmpleado = lista[i].numeroEmpleado;
                        var nombreEmpleado = lista[i].nombreEmpleado;
                        var descripcionPuesto = lista[i].descripcionPuesto;
                        var descripcionTurno = lista[i].descripcionTurno;
                        var nomenclaturaGenero = lista[i].nomenclaturaGenero;
                        var requisicionId = lista[i].requisicionId;
                        var rolOperativoPlantilla = lista[i].rolOperativoPlantilla;


                                                                                          
                  listaTable += "<tr><td>"+numeroEmpleado+" </td><td>"+nombreEmpleado+" </td><td>"+nomenclaturaGenero+"</td><td>"+descripcionPuesto+"</td><td>"+descripcionTurno+"</td><td>"+rolOperativoPlantilla+"</td><td>"+requisicionId+"</td><tr>";
 
                }
                     
                  listaTable += "</tbody></table>";
                  $("#detallesAsignacion").html(detallesAsignacion);
                  $('#namePoint3').html(name); 
                  $('#divAsignacion').html(listaTable);     
                  
                  $("#divClass").addClass("borderDiv");
                                      
                 }
            },           

           error : function (jqXHR, textStatus, errorThrown)
            {
                alert (jqXHR.responseText);
            }
        });
    }

var rolUsuario="<?php echo $usuario['rol']; ?>";

$(inicioConsultaPlantillas());  

function inicioConsultaPlantillas(){
if (rolUsuario=="Contrataciones"  || rolUsuario=="Lider Unidad" || rolUsuario=="Consulta Rh" || rolUsuario=="Supervisor" || rolUsuario=="Consulta Supervisor" || rolUsuario=="Analista Asistencia" || rolUsuario=="Facturacion"  ||  rolUsuario=="Reclutador" ||  rolUsuario=="Ventas" || rolUsuario =="Laborales" || rolUsuario =="Direccion General"){
            obtenerListaClientesConsultaRH();
        }
}

</script>