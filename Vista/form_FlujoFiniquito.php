 <div id="MsgErrorFlujoFiniquito"></div>
<center><h3>Estatus</h3></center>
        <img title='regresar' src='img/regresarverde.jpg' width="2.5%" class='cursorImg' id='btnregresar' onclick='Regresar()'>
        <br>
        <div>
        <img title='enviando' src='img/loader.gif' width="20%" class='cursorImg' id='enviando' align="center">
        </div>
<br>
<div class="input-prepend" align="center">
        <span class="add-on">buscador</span>
        <input id="bandera"                    name="bandera"                     type="hidden" class="input-large">
        <input id="inpfechaBaja"               name="inpfechaBaja"                type="hidden" class="input-large">
        <input id="inpnetoAlPago"              name="inpnetoAlPago"               type="hidden" class="input-large">
        <input id="inpdiasDeVacaciones"        name="inpdiasDeVacaciones"         type="hidden" class="input-large">
        <input id="inpPrestamo"                name="inpPrestamo"                 type="hidden" class="input-large">
        <input id="inpInfonavit"               name="inpInfonavit"                type="hidden" class="input-large">
        <input id="inpPension"                 name="inpPension"                  type="hidden" class="input-large">
        <input id="inpFonacot"                 name="inpFonacot"                  type="hidden" class="input-large">
        <input id="inpDíasTrabajados"          name="inpDíasTrabajados"           type="hidden" class="input-large">
        <input id="inpnumempleado"             name="inpnumempleado"              type="hidden" class="input-large">
        <input id="letra"                      name="letra"                       type="hidden" class="input-large">
        <input id="inpNombreUsuario"           name="inpNombreUsuario"            type="hidden" class="input-large">
        <input id="inpapellidoPaternoUsuario"  name="inpapellidoPaternoUsuario"   type="hidden" class="input-large">
        <input id="inpapellidoMaternoUsuario"  name="inpapellidoMaternoUsuario"   type="hidden" class="input-large">
        <input id="inpnomemp"                  name="inpnomemp"                   type="hidden" class="input-large">
        <input id="inpnombreEntidadFederativa" name="inpnombreEntidadFederativa"  type="hidden" class="input-large">
        <input id="inpdiasDeVacaciones"        name="inpdiasDeVacaciones"         type="hidden" class="input-large">
        <input id="inpPrestamoFechaCarga"      name="inpPrestamoFechaCarga"       type="hidden" class="input-large">
        <input id="inpInfonavitFechaCarga"     name="inpInfonavitFechaCarga"      type="hidden" class="input-large">
        <input id="inpPensionFechaCarga"       name="inpPensionFechaCarga"        type="hidden" class="input-large">
        <input id="inpFonacotFechaCarga"       name="inpFonacotFechaCarga"        type="hidden" class="input-large">
        <input id="inpDíasTrabajadosFechaCarga"name="inpDíasTrabajadosFechaCarga" type="hidden" class="input-large">
        <input id="inpentidad"                 name="inpentidad"                  type="hidden" class="input-large">
        <input id="inpconsecutivo"             name="inpconsecutivo"              type="hidden" class="input-large">
        <input id="inpcategoria"               name="inpcategoria"                type="hidden" class="input-large">

        <input id="inpUniformesentregados"     name="inpUniformesentregados"      type="hidden" class="input-large">
        <input id="inpUniformesFechaHoraCarga" name="inpUniformesFechaHoraCarga"  type="hidden" class="input-large">
        

        <input id="inpBusqueda" name="inpBusqueda" title="El numero consecutivo puede ser de 5 caracteres" type="text" class="input-large" onkeypress="enviarcorreo(event)" placeholder="00-0000-00"><span class="add-on">Ingrese El Número Del empleado Completo</span>
</div><br>

<section>
     <table id="tablaflujo"   class="records_list table table-striped table-bordered table-hover" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th style="text-align: center;background-color: #B0E76E">Número empleado</th>
                <th style="text-align: center;background-color: #B0E76E">Nombre</th>
                <th style="text-align: center;background-color: #B0E76E">Puesto</th>
                <th style="text-align: center;background-color: #B0E76E">Entidad</th> 
                <th style="text-align: center;background-color: #B0E76E">Linea de Negocio</th>             
                <th style="text-align: center;background-color: #B0E76E">Prestamo</th>
                <th style="text-align: center;background-color: #B0E76E">Fecha de carga información Prestamo</th>
                <th style="text-align: center;background-color: #B0E76E">Amortizaciones</th>
                <th style="text-align: center;background-color: #B0E76E">Fecha de carga información Amortizaciones</th>
                <th style="text-align: center;background-color: #B0E76E">Fonacot</th>
                <th style="text-align: center;background-color: #B0E76E">Fecha de carga información Fonacot</th>
                <th style="text-align: center;background-color: #B0E76E">Pensión Alimenticia</th>
                <th style="text-align: center;background-color: #B0E76E">Fecha de carga información Pensión Alimenticia</th>
                <th style="text-align: center;background-color: #B0E76E">Días Trabajados</th>
                <th style="text-align: center;background-color: #B0E76E">Fecha de carga información Días trabajados</th>
                <th style="text-align: center;background-color: #B0E76E">Uniformes Entregados</th>
                <th style="text-align: center;background-color: #B0E76E">Fecha de carga información Uniformes Entregados</th>
                <th style="text-align: center;background-color: #B0E76E">Negociación de finiquito</th>
                <th style="text-align: center;background-color: #B0E76E">Estatus Negociación Finiquitos</th>
                <th style="text-align: center;background-color: #B0E76E">Días Vacaciones</th> 
                <!--  <th style="text-align: center;background-color: #B0E76E">Fecha de carga Dias vacaciones</th>-->
                <!-- <th style="text-align: center;background-color: #B0E76E">Enviar Correo</th>  -->
            </tr>  
        </thead>
    </table>
</section>
    
<script type="text/javascript"> 

$(inicioFlujoFiniquito());  

function inicioFlujoFiniquito(){
  consultaflujo();
}

function consultaflujo() { 
    $('#btnregresar').hide();
    $('#enviando').hide();
    tableflujo = [];
    $.ajax({
     type: "POST",
     url: "ajax_consultaflujo.php",
     dataType: "json",
     success: function(response) {
        if (response.status == "success") {
             for(var i = 0; i < response.datos.length; i++) {
                 var prestamo       = response.datos[i]["prestamo"];
                 var infonavit      = response.datos[i]["infonavit"];
                 var fonacot        = response.datos[i]["fonacot"];
                 var pension        = response.datos[i]["pension"];
                 var netoAlPago     = response.datos[i]["netoAlPago"];
                 var diastrabajados = response.datos[i]["diastrabajados"];
                 var Uniformesentregados = response.datos[i]["Uniformesentregados"];
        
                if(prestamo!="0" && infonavit!="0" && fonacot!="0" && pension!="0" && netoAlPago>"0" && diastrabajados!="0" && Uniformesentregados!="0"){
                         var numempleado    = response.datos[i]["numempleado"];
                         var fechaBaja      = response.datos[i]["fechaBaja"];
                         var fechaAlta      = response.datos[i]["fechaAlta"];
                         ConfirmarYCrearPdfFiniquitoAutomatico(numempleado,fechaBaja,fechaAlta);        
                }else{
                      var record = response.datos[i];
                     tableflujo.push(record);
                     }                     
            }
             loadDataInTableflujo(tableflujo);
        } else {
          var mensaje = response.message;
          //console.log("mal");
         }
    },
     error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
     }
     });
 }
 var tableflujofiniquitos = null;

 function loadDataInTableflujo(data) {
     if (tableflujofiniquitos != null) {
         tableflujofiniquitos.destroy();
     }
     tableflujofiniquitos = $('#tablaflujo').DataTable({
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
         "columns": [
         {   
             "data": "numempleado"
         }, 
         {   
             "data": "nombreempleado"
         }, 
         {   
             "data": "descripcionPuesto"
         }, 
         {   
             "data": "nombreEntidadFederativa"
         },
         {   
             "data": "descripcionLineaNegocio"
         }, 
         {   "className": "dt-body-center",
             "data": "prestamoFiniquito"
         }, 
         {   
             "data": "prestamoFecha"
         }, 
         {   "className": "dt-body-center",
             "data": "infonavitFiniquito"
         }, 
         {   
             "data": "infonavitFecha"
         }, 
         {   "className": "dt-body-center",
             "data": "fonacotFiniquito"
         }, 
         {   
             "data": "fonacotFecha"
         }, 
         {   "className": "dt-body-center",
             "data": "pensionFiniquito"
         }, 
         {   
             "data": "pensioFecha"
         }, 
         {   "className": "dt-body-center",
             "data": "diastrabFiniquito"
         }, 
         {   
             "data": "diastrabFecha"
         },
         {   "className": "dt-body-center",
             "data": "UniformesFiniquito"
         }, 
         {   
             "data": "UniformesFecha"
         },
         {   "className": "dt-body-center",
             "data": "netoalpagoflujo"
         },  
         {   
             "data": "EstatusNegociacion"
         }, 
         {   "className": "dt-body-center",
             "data": "diasDeVacaciones"
         }, 
       /*  {   "className": "dt-body-center",
             "data": "EnviarCorreo"
         },*/
        
         /*{   
             "data": "DiasVacacionesFecha"
         }, */ ],
         processing: true,
         dom: 'Bfrtip',

         sDom: 't',
         sDom: 'p',


          buttons: {
        buttons: ['excel']
        }   
     });

}

function Regresar(){
    $("#inpBusqueda").val("");
    consultaflujo();
$('#btnregresar').hide();

}
function enviarcorreo(event){
    
    
    var bandera = $("#bandera").val();
    //var inpestatusFiniquito = $("#inpestatusFiniquito").val();
    //var inpempleadoEstatusImss= $("#inpempleadoEstatusImss").val();
    var inpfechaBaja          = $("#inpfechaBaja").val();
    var netoAlPago            = $("#inpnetoAlPago").val();
    var diasDeVacaciones      = $("#inpdiasDeVacaciones").val();
    var prestamo              = $("#inpPrestamo").val();
    var infonavit             = $("#inpInfonavit").val();
    var pension               = $("#inpPension").val();
    var fonacot               = $("#inpFonacot").val();
    var diastrabajados        = $("#inpDíasTrabajados").val();    
    var NombreUsuario         = $("#inpNombreUsuario").val();
    var apellidoPaternoUsuario= $("#inpapellidoPaternoUsuario").val();
    var apellidoMaternoUsuario= $("#inpapellidoMaternoUsuario").val();
    var numempleado           = $("#inpnumempleado   ").val();

    var nomemp= $("#inpnomemp").val();
    var nombreEntidadFederativa= $("#inpnombreEntidadFederativa").val();
    var diasDeVacaciones= $("#inpdiasDeVacaciones").val();
    var PrestamoFechaCarga= $("#inpPrestamoFechaCarga").val();
    var InfonavitFechaCarga= $("#inpInfonavitFechaCarga").val();
    var PensionFechaCarga= $("#inpPensionFechaCarga").val();
    var FonacotFechaCarga= $("#inpFonacotFechaCarga").val();
    var DíasTrabajadosFechaCarga= $("#inpDíasTrabajadosFechaCarga").val();

    var entidad= $("#inpentidad").val();
    var consecutivo= $("#inpconsecutivo").val();
    var categoria= $("#inpcategoria").val();

    var Uniformesentregados= $("#inpUniformesentregados").val();
    var UniformesFechaHoraCarga= $("#inpUniformesFechaHoraCarga").val();

    var letra = event.which;
    $("#letra").val(letra);
    
    if(bandera==1 && letra==13){
    //$('#enviando').show();
    waitingDialog.show();
    $.ajax({
        type: "POST",
        url: "ajax_EnviarCorreo.php",
        dataType: "json",
        data: {"prestamo": prestamo, "infonavit": infonavit, "fonacot": fonacot, "pension": pension, "diastrabajados": diastrabajados, "numempleado": numempleado,"NombreUsuario": NombreUsuario,"apellidoPaternoUsuario": apellidoPaternoUsuario,"apellidoMaternoUsuario": apellidoMaternoUsuario, "diasDeVacaciones": diasDeVacaciones, "netoAlPago": netoAlPago, "nomemp": nomemp,"nombreEntidadFederativa": nombreEntidadFederativa,"diasDeVacaciones": diasDeVacaciones,"PrestamoFechaCarga": PrestamoFechaCarga,"InfonavitFechaCarga": InfonavitFechaCarga,"PensionFechaCarga": PensionFechaCarga,"FonacotFechaCarga": FonacotFechaCarga,"DíasTrabajadosFechaCarga": DíasTrabajadosFechaCarga, "entidad": entidad, "consecutivo": consecutivo, "categoria": categoria, "Uniformesentregados": Uniformesentregados, "UniformesFechaHoraCarga": UniformesFechaHoraCarga},

        success: function(response){
           //alert("si1");

            waitingDialog.hide();
            var mensajePegar = "Se envio correo correctamente a las areas correspondientes"
            alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+mensajePegar+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#MsgErrorFlujoFiniquito").html(alertMsg1);
            $(document).scrollTop(0);
            $('#msgAlert').delay(3000).fadeOut('slow');
            $('#btnregresar').show();
       },
       error: function(jqXHR, textStatus, errorThrown) {
           alert(jqXHR.responseText);
       }
    });
        
    }
}

$("#inpBusqueda").on("keyup search input paste cut", function() { 
    var letraa = $("#letra").val();
    var tablaEstatus = $("#tablaflujo").DataTable();
    var bandera = $("#bandera").val();
    if(bandera=="1" && letraa=="13"){
        tablaEstatus.search(this.value).draw();   
    }
});  

$("#inpBusqueda").on("keyup search input paste cut", function() { 

    var inpBusqueda   = $("#inpBusqueda").val();
    var empleadoSplit = inpBusqueda.split("-");
    var largosplit    = empleadoSplit.length;
 if(largosplit=='3'){
        var entidad         = empleadoSplit['0'];
        var consecutivo     = empleadoSplit['1'];
        var categoria       = empleadoSplit['2'];    
        var entidadLargo    = entidad.length;
        var consecutivoLargo= consecutivo.length;
        var categoriaLargo  = categoria.length;   
    if((entidadLargo ==2) && ((consecutivoLargo =='4' || consecutivoLargo =='5')) && ((categoriaLargo =='2'))){
            $.ajax({
                type: "POST",
                url: "ajax_ConsultaBusqueda.php",
                dataType: "json",
                data: {"entidad": entidad, "consecutivo": consecutivo, "categoria": categoria},
                success: function(response){
                    //console.log(response);
                    if (response.status == "success") {
                            
                            var estatusFiniquito        = response.datos[0]['estatusFiniquito'];
                            var empleadoEstatusImss     = response.datos[0]["empleadoEstatusImss"];
                            var fechaBaja               = response.datos[0]["fechaBaja"];
                            var netoAlPago              = response.datos[0]["netoAlPago"];
                            var diasDeVacaciones        = response.datos[0]["diasDeVacaciones"];
                            var Prestamo                = response.datos[0]["Prestamo"];
                            var Infonavit               = response.datos[0]["Infonavit"];
                            var Pension                 = response.datos[0]["Pension"];
                            var Fonacot                 = response.datos[0]["Fonacot"];
                            var DíasTrabajados          = response.datos[0]["DíasTrabajados"];
                            var numempleado             = response.datos[0]["numempleado"];
                            var nomemp                  = response.datos[0]["nomemp"];
                            var nombreEntidadFederativa = response.datos[0]["nombreEntidadFederativa"];
                            var diasDeVacaciones        = response.datos[0]["diasDeVacaciones"]; 
                            var PrestamoFechaCarga      = response.datos[0]["PrestamoFechaCarga"];
                            var InfonavitFechaCarga     = response.datos[0]["InfonavitFechaCarga"];
                            var PensionFechaCarga       = response.datos[0]["PensionFechaCarga"];
                            var FonacotFechaCarga       = response.datos[0]["FonacotFechaCarga"];
                            var DíasTrabajadosFechaCarga= response.datos[0]["DíasTrabajadosFechaCarga"];
                            var NombreUsuario           = response.datos[0]["NombreUsuario"];
                            var apellidoPaternoUsuario  = response.datos[0]["apellidoPaternoUsuario"];
                            var apellidoMaternoUsuario  = response.datos[0]["apellidoMaternoUsuario"];                            
                            var entidademp              = response.datos[0]["entidad"];              
                            var consecutivoemp          = response.datos[0]["consecutivo"];                
                            var categoriaemp            = response.datos[0]["categoria"];    

                            var Uniformesentregados = response.datos[0]["Uniformesentregados"];
                            var UniformesFechaHoraCarga = response.datos[0]["UniformesFechaHoraCarga"];  

                        if ((estatusFiniquito == 0 || estatusFiniquito == 3 || estatusFiniquito == 4 || estatusFiniquito == 2 || estatusFiniquito == 6) && empleadoEstatusImss == 7) {

                             $("#bandera").val(1);
                             $("#inpestatusFiniquito").val(estatusFiniquito);
                             $("#inpempleadoEstatusImss").val(empleadoEstatusImss);
                             $("#inpfechaBaja").val(fechaBaja);
                             $("#inpnetoAlPago").val(netoAlPago);
                             $("#inpdiasDeVacaciones").val(diasDeVacaciones);
                             $("#inpPrestamo").val(Prestamo);
                             $("#inpInfonavit").val(Infonavit);
                             $("#inpPension").val(Pension);
                             $("#inpFonacot").val(Fonacot);
                             $("#inpDíasTrabajados").val(DíasTrabajados);
                             $("#inpnumempleado").val(numempleado); 
                             $("#inpnomemp").val(nomemp);  
                             $("#inpnombreEntidadFederativa").val(nombreEntidadFederativa);  
                             $("#inpdiasDeVacaciones").val(diasDeVacaciones);  
                             $("#inpPrestamoFechaCarga").val(PrestamoFechaCarga);  
                             $("#inpInfonavitFechaCarga").val(InfonavitFechaCarga);  
                             $("#inpPensionFechaCarga").val(PensionFechaCarga);  
                             $("#inpFonacotFechaCarga").val(FonacotFechaCarga);  
                             $("#inpDíasTrabajadosFechaCarga").val(DíasTrabajadosFechaCarga);  
                             $("#inpentidad").val(entidademp);
                             $("#inpconsecutivo").val(consecutivoemp);
                             $("#inpcategoria").val(categoriaemp);
                             $("#inpNombreUsuario").val(NombreUsuario);
                             $("#inpapellidoPaternoUsuario").val(apellidoPaternoUsuario);
                             $("#inpapellidoMaternoUsuario").val(apellidoMaternoUsuario); 
                             
                             $("#inpUniformesentregados").val(Uniformesentregados); 
                             $("#inpUniformesFechaHoraCarga").val(UniformesFechaHoraCarga); 
                        }
                    }
                    else if(response.status == "errorempleado"){
                           alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+response.menssaje+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                           $("#MsgErrorFlujoFiniquito").html(alertMsg1);
                           $(document).scrollTop(0);
                           $('#msgAlert').delay(3000).fadeOut('slow');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                }
            });
    }else{
         $("#bandera").val(0);
         }
    }       
}); 

 function ConfirmarYCrearPdfFiniquitoAutomatico(numempleado,fechabaja,fechaalta){
     
         waitingDialog.show();
         $.ajax({
             type: "POST",
             url: "ajax_ActualizarFiniquitoAutomatico.php",
             dataType: "json",
             data: {"numempleado": numempleado},
             success: function(response) {
                 msg1error = response.status;
                 if (msg1error != "success") {
                     alert("Error Al Crear El Finiquito Automaticamente");
                 }else {
                     eliminadeduccionesFiniquitosAutomaticos(numempleado);
                 }
                 if (response.status == "error"){
                     alert(response.message);
                 }
                  waitingDialog.hide();
                 },
                  error: function(jqXHR, textStatus, errorThrown) {
                  waitingDialog.hide();
                  alert(jqXHR.responseText);
             }
         });
     }

function eliminadeduccionesFiniquitosAutomaticos(numempleado){
     $.ajax({
         type: "POST",
         url: "../Nominas/finiquitos/ajax_deleteDeducciones.php",
         dataType: "json",
         data: {"numempleado": numempleado},
         success: function(response){
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
}

/*function EnviarCorreos(prestamo,infonavit,fonacot,pension,diastrabajados,numempleado,NombreUsuario,apellidoPaternoUsuario,apellidoMaternoUsuario,diasDeVacaciones, netoAlPago){
    alert(numempleado);
    $.ajax({
        type: "POST",
        url: "ajax_EnviarCorreo.php",
        dataType: "json",
        data: {"prestamo": prestamo, "infonavit": infonavit, "fonacot": fonacot, "pension": pension, "diastrabajados": diastrabajados, "numempleado": numempleado,"NombreUsuario": NombreUsuario,"apellidoPaternoUsuario": apellidoPaternoUsuario,"apellidoMaternoUsuario": apellidoMaternoUsuario, "diasDeVacaciones": diasDeVacaciones, "netoAlPago": netoAlPago},
        success: function(response){
        },
       error: function(jqXHR, textStatus, errorThrown) {
           alert(jqXHR.responseText);
       }
    });
}*/
</script>