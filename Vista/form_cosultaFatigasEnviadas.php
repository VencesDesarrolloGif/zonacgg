<div class="container" align="center" >
<form class="form-horizontal" id="form_fatigasEnviadas" name="form_fatigasEnviadas" action="ficheroExportFatiga.php" target="_blank" method="post">
	<div>

        <select name="selectMes" id="selectMes" onchange="getPuntosServiciosAndResponsables();">
            <option value="01">ENERO</option>
            <option value="02">FEBRERO</option>
            <option value="03">MARZO</option>
            <option value="04">ABRIL</option>
            <option value="05">MAYO</option>
            <option value="06">JUNIO</option>
            <option value="07">JULIO</option>
            <option value="08">AGOSTO</option>
            <option value="09">SEPTIEMBRE</option>
            <option value="10">OCTUBRE</option>
            <option value="11">NOVIEMBRE</option>
            <option value="12">DICIEMBRE</option>
        </select>
          <select name="anio" id="anio" onchange="getPuntosServiciosAndResponsables();">
            <?php
            for($i=date('o'); $i>=2015; $i--){
                if ($i == date('o'))
                    echo '<option value="'.$i.'" selected>'.$i.'</option>';
                else
                    echo '<option value="'.$i.'">'.$i.'</option>';
            }
            ?>
        </select>
        <br>
        <br>
        <div class="input-prepend">
          <span class="add-on">Total fatigas</span>
          <input class="input-small" id="txtTotalFatigas" name="txtTotalFatigas" type="text" readonly>
        </div><br>
        <div class="input-prepend">
          <span class="add-on">Fatigas enviadas por email</span>
          <input class="input-small" id="txtFatigasCorreo" name="txtFatigasCorreo" type="text" readonly>
        </div><br>
        <div class="input-prepend">
          <span class="add-on">Fatigas recibidas físicas</span>
          <input class="input-small" id="txtFatigasFisicas" name="txtFatigasFisicas" type="text" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">Fatigas físicas pendientes</span>
          <input class="input-small" id="txtFatigasPendientes" name="txtFatigasPendientes" type="text" readonly>
        </div>



  </div>

  <table class="editinplace table table-bordered" id="tableEntregaFatigas" name="tableEntregaFatigas">
            <tr>
                <th>Id Punto</th>
                <th>Punto Servicio</th>
                <th>Cliente</th>
                <th>Supervisor</th>
                <th>1RA</th>
                <th>2DA</th>

            </tr>
  </table>

      <!-- Modal  envio comentario-->
  <div id="modalEstatusFatiga" name="modalEstatusFatiga" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" >
      <div class="modal-header">
        <h4 class="modal-title">Edición de estatus de fatiga</h4>
      <div id="msgFatiga"> 
      </div>
    </div>

    <div class="modal-body">
      <div class="input-prepend">
        <span class="add-on">Fatiga del punto de servicio:</span>
        <input id="txtPuntoServicioFatiga" name="txtPuntoServicioFatiga" type="text" class="input-xlarge" readonly ><br>
        <input id="txtPuntoServicioIdFatiga" name="txtPuntoServicioIdFatiga" type="hidden" class="input-small" maxlength="14">
      </div>
      <div class="input-prepend">
        <span class="add-on">Correspondiente a:</span>
        <input id="txtMesFatiga" name="txtMesFatiga" type="text" class="input-xlarge" readonly>
      </div>
      <div class="input-prepend">
        <span class="add-on">Cambio de estatus de:</span>
        <input id="txtEstatusFatiga" name="txtEstatusFatiga" type="text" class="input-medium" readonly><span class="add-on">a</span>
        <select class="input-large" name="selectEstatus" id="selectEstatus"><option>Nuevo estatus</option>
              <?php
                for ($i=0; $i<count($catalogoEstatusFatigas); $i++)
                {
                  if($catalogoEstatusFatigas[$i]["idEstatusFatiga"]=="1" or $catalogoEstatusFatigas[$i]["idEstatusFatiga"]=="2"  ){
                    echo "<option disabled value='". $catalogoEstatusFatigas[$i]["idEstatusFatiga"]."'>". $catalogoEstatusFatigas[$i]["descripcionEstatusFatiga"] ." </option>";

                  }else{
                    echo "<option value='". $catalogoEstatusFatigas[$i]["idEstatusFatiga"]."'>". $catalogoEstatusFatigas[$i]["descripcionEstatusFatiga"] ." </option>";
                  }

                
                }
              ?>
          </select>
      </div>
      <div class="input-prepend">
        
        <input id="txtQuincena" name="txtQuincena" type="hidden" class="input-small" readonly>
        <input id="txtMonth" name="txtMonth" type="hidden" class="input-small" readonly>
        <input id="txtYearFatiga" name="txtYearFatiga" type="hidden" class="input-small" readonly>
        <input id="txtEstatusFatiga1" name="txtEstatusFatiga1" type="hidden" class="input-small" readonly>
        
        
      </div>

        <div class="input-prepend">
          <span class="add-on">Fecha:</span>
          <input id="txtFecha" name="txtFecha" type="text" class="input-medium" >
        </div>
    </div>
      <div class="modal-footer" id="footerBajaEmpleado">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick='editarEstatusFatiga();'>Guardar</button>
      </div>
  </div>  <!-- FIN MODAL envio comentario-->
</form>
</div>

<script type="text/javascript">

$(inicioConsultaFatigasEnviadas());  

function inicioConsultaFatigasEnviadas(){
    <?php
    if ($usuario["rol"] =="Supervisor" || $usuario["rol"] =="Facturacion"  )
      {
    ?>
      var ahora = new Date();
      var ahoraDay    = ahora.getDate();
      var ahoraMonth = ahora.getMonth();
       ahoraYear   = ahora.getFullYear();
      getPuntosServiciosAndResponsables();
      setInterval("getPuntosServiciosAndResponsables()",120000);
    <?php
      }
    ?>
}

    function getPuntosServiciosAndResponsables(){
      var month=$("#selectMes").val();
      var supervisorId="";
      var year=$("#anio").val();
      var nameMonth = $("#selectMes option:selected").text();
      var fatigasRecibidasFisicamente=0;
      var totalFatigas=0;
      var fatigasPendientes=0;
      var fatigasEnviadas=0;

      //alert(month+" "+ahoraYear);
        $("#tableEntregaFatigas").find("tr:gt(0)").remove();
       $.ajax({
            type: "POST",
            url: "ajax_getPuntosServiciosAndResponsablesByRangoFecha.php",
            data: {"month":month, "year":year},
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                    
                    //var fatigasRecibidasFisicamente2=0;
                    //var totalFatigasRecibidas=0;

                    var lista = response.puntos;
                    //alert(lista);

                    for( var i = 0; i < lista.length; i++ ){

                      totalFatigas=totalFatigas+1;

                      var idPuntoServicio = lista[i].idPuntoServicio;
                      var puntoServicio = lista[i].puntoServicio;
                      var razonSocial = lista[i].razonSocial;
                      var nombreSupervisor = lista[i].nombreSupervisor;
                      
                      var fatiga1=lista[i].fatiga1;
                      var fatiga2=lista[i].fatiga2;

                      var fatigaSend1="";
                      var fechaEnvio="";
                      //var usuarioEnvio="";
                      var iconEstatusFatiga1="";
                      var iconEstatusFatiga2="";

                      var fatigaSend2="";
                      var fechaEnvio2="";
                      //var usuarioEnvio2="";
                      var actionFatiga1="Cambiar estatus de fatiga";
                      var actionFatiga2="Cambiar estatus de fatiga";
                      var estatusFatiga="";
                      var estatusFatiga2="";
                      
                      
                      if (fatiga1.length==0){

                        fatigaSend1="No enviada";
                        actionFatiga1="Marcar como recibida";
                        estatusFatiga=0;
                        iconEstatusFatiga1="<img src='img/noEnviada.png'>";
                        

                      }else{
                        //fatigaSend1="ENVIADO";

                        for(var j=0; j<fatiga1.length; j++){

                          estatusFatiga=fatiga1[j]["estatusFatiga"];
                          var fe=fatiga1[j]["fechaEnvioFatiga"];

                          if(fe!=""){

                            fatigasEnviadas=fatigasEnviadas+1;

                          }


                          if (estatusFatiga==3){

                            fatigasRecibidasFisicamente=fatigasRecibidasFisicamente+1;
                            //alert(fatigasRecibidasFisicamente);

                          }
                          var descripcionEstatusFatiga=fatiga1[j]["descripcionEstatusFatiga"];
                           
                                                                     
                          if(estatusFatiga==1){
                            fechaEnvio="Fecha envío: "+fatiga1[j]["fechaEnvioFatiga"];
                            //usuarioEnvio="Usuario envío: "+fatiga1[j]["responsableEnvio"];
                            iconEstatusFatiga1="<img src='img/enviada.png'>";
                            

                          }else if(estatusFatiga==2){

                            fechaEnvio="Fecha reenvío: "+fatiga1[j]["fechaReenvioFatiga"];
                            //usuarioEnvio="Usuario reenvío: "+fatiga1[j]["responsableReenvio"];
                            iconEstatusFatiga1="<img src='img/enviada.png'>";

                          }else if(estatusFatiga==3){

                            fechaEnvio="Fecha de recibida: "+fatiga1[j]["fechaFatigaRecibida"];
                            usuarioEnvio="Usuario envío: "+fatiga1[j]["responsableEnvio"];
                            iconEstatusFatiga1="<img src='img/recibida.png'>";


                          }else if(estatusFatiga==4){
                            
                            fechaEnvio="Fecha de facturación: "+fatiga1[j]["fechaFatigaFacturada"]+"<br>Fecha de recibida:"+fatiga1[j]["fechaFatigaRecibida"]+"<br>Fecha de envío:"+fatiga1[j]["fechaEnvioFatiga"];
                            //usuarioEnvio="Usuario envío: "+fatiga1[j]["responsableEnvio"];


                          }else if(estatusFatiga==5){
                            actionFatiga1="";
                            fechaEnvio="Fecha contrarecibo:"+fatiga1[j]["fechaContrarecibo"]+"<br>Fecha de facturación: "+fatiga1[j]["fechaFatigaFacturada"]+"<br>Fecha de recibida:"+fatiga1[j]["fechaFatigaRecibida"]+"<br>Fecha de envío:"+fatiga1[j]["fechaEnvioFatiga"];
                            iconEstatusFatiga1="<img src='img/money.png'>";
                            //usuarioEnvio="Usuario envío: "+fatiga1[j]["responsableEnvio"];


                          }
                       
                        }
                       // alert(fatiga1);
                        fatigaSend1=descripcionEstatusFatiga;

                      }

                      if (fatiga2.length==0){

                        fatigaSend2="No enviada";
                        actionFatiga2="Marcar como recibida";
                        estatusFatiga2=0;
                        iconEstatusFatiga2="<img src='img/noEnviada.png'>";

                      }else{
                        //fatigaSend1="ENVIADO";

                        for(var k=0; k<fatiga2.length; k++){

                          estatusFatiga2=fatiga2[k]["estatusFatiga"];
                          var descripcionEstatusFatiga2=fatiga2[k]["descripcionEstatusFatiga"];

                          var fe2=fatiga2[k]["fechaEnvioFatiga"];

                          if(fe2!=""){

                            fatigasEnviadas=fatigasEnviadas+1;

                          }

                          if (estatusFatiga2==3){

                            fatigasRecibidasFisicamente=fatigasRecibidasFisicamente+1;
                            //alert(fatigasRecibidasFisicamente);

                          }
                          
                          if(estatusFatiga2==1){
                            fechaEnvio2="Fecha envío: "+fatiga2[k]["fechaEnvioFatiga"];
                            //usuarioEnvio2="Usuario envío: "+fatiga2[k]["responsableEnvio"];
                            iconEstatusFatiga2="<img src='img/enviada.png'>";

                          }else if(estatusFatiga2==2){

                            fechaEnvio2="Fecha reenvío: "+fatiga2[k]["fechaReenvioFatiga"];
                            //usuarioEnvio2="Usuario reenvío: "+fatiga2[k]["responsableReenvio"];
                            iconEstatusFatiga2="<img src='img/enviada.png'>";

                          }else if(estatusFatiga2==3){

                            fechaEnvio2="Fecha de recibida: "+fatiga2[k]["fechaFatigaRecibida"];
                            //usuarioEnvio2="Usuario envío: "+fatiga2[k]["responsableEnvio"];
                            iconEstatusFatiga2="<img src='img/recibida.png'>";
                          }else if(estatusFatiga2==4){

                            
                            fechaEnvio2="Fecha de facturación: "+fatiga2[k]["fechaFatigaFacturada"]+"<br>Fecha de recibida:"+fatiga2[k]["fechaFatigaRecibida"]+"<br>Fecha de envío:"+fatiga2[k]["fechaEnvioFatiga"];
                            //usuarioEnvio2="Usuario envío: "+fatiga2[k]["responsableEnvio"];
                          }
                          else if(estatusFatiga2==5){

                            actionFatiga2="";
                            fechaEnvio2="Fecha contrarecibo:"+fatiga2[k]["fechaContrarecibo"]+"<br>Fecha de facturación: "+fatiga2[k]["fechaFatigaFacturada"]+"<br>Fecha de recibida:"+fatiga2[k]["fechaFatigaRecibida"]+"<br>Fecha de envío:"+fatiga2[k]["fechaEnvioFatiga"];
                            iconEstatusFatiga2="<img src='img/money.png'>";
                            //usuarioEnvio2="Usuario envío: "+fatiga2[k]["responsableEnvio"];
                          }
                       
                        }
                       // alert(fatiga1);
                        fatigaSend2=descripcionEstatusFatiga2;

                      }

                      var table="<tr><td class='id'>"+idPuntoServicio+"</td><td  width='200px'>"+puntoServicio+"</td>";
                      table+="<td  width='200px'>"+razonSocial+"</td>";
                      table+="<td width='200px' >"+nombreSupervisor+"</td><td>"+fatigaSend1+" "+iconEstatusFatiga1+"<a href='javascript:showModalEstatusFatiga(\"" + idPuntoServicio + "\",\"" + puntoServicio + "\",\"" + nameMonth + "\",\"LA PRIMERA DE \",\"" + year + "\",\"" + fatigaSend1 + "\","+month+","+estatusFatiga+");'> "+actionFatiga1+"</a><br> "+fechaEnvio+"<br></td>";
                      table+="<td>"+fatigaSend2+" "+iconEstatusFatiga2+" <a href='javascript:showModalEstatusFatiga(\"" + idPuntoServicio + "\",\"" + puntoServicio + "\",\"" + nameMonth + "\",\"LA SEGUNDA DE \",\"" + year + "\",\"" + fatigaSend2 + "\", "+month+","+estatusFatiga2+");'>"+actionFatiga2+"</a><br> "+fechaEnvio2+"<br></td>";
                      table+="</tr>";

                      

                      $("#txtFatigasFisicas").val(fatigasRecibidasFisicamente);
                      $("#txtFatigasPendientes").val(totalFatigas - fatigasRecibidasFisicamente);
                      $("#txtFatigasCorreo").val(fatigasEnviadas);
                      $("#txtTotalFatigas").val(totalFatigas);


                      $('#tableEntregaFatigas').append(table);


                    }
                }
            },
            error: function (response)
            {
                //console.log (response);
            }
        });
    }

    function showModalEstatusFatiga(idPuntoServicio,puntoServicio,nameMonth, quincena, year, descripcionEstatusFatiga, month,estatusFatiga){

      $("#modalEstatusFatiga").modal();
      $("#txtPuntoServicioFatiga").val(puntoServicio);
      $("#txtPuntoServicioIdFatiga").val(idPuntoServicio);
      $("#txtMesFatiga").val(quincena+" "+nameMonth+" DE "+year);
      $("#txtEstatusFatiga").val(descripcionEstatusFatiga);
      $("#txtMonth").val(month);
      $("#txtEstatusFatiga1").val(estatusFatiga);
      $("#txtYearFatiga").val(year);
      
      if(quincena=="LA PRIMERA DE "){
        $("#txtQuincena").val(1);
      }else{
        $("#txtQuincena").val(2);
      }
    }
    function editarEstatusFatiga(){
      
      var nuevoEstatusFatiga=$("#selectEstatus").val();
      var fechaCambioEstatus=$("#txtFecha").val();
      var idPuntoServicio=$("#txtPuntoServicioIdFatiga").val();
      var quincena=$("#txtQuincena").val();
      var month=$("#txtMonth").val();
      var estatusFatiga=$("#txtEstatusFatiga1").val();
      var year=$("#txtYearFatiga").val();

          $.ajax({
            type: "POST",
            url: "ajax_updateEstatusFatiga.php",
            data: {nuevoEstatusFatiga:nuevoEstatusFatiga, idPuntoServicio:idPuntoServicio, quincena:quincena, month:month, fechaCambioEstatus:fechaCambioEstatus,year:year, estatusFatiga:estatusFatiga},
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;

                if (response.status=="success") {
            
                    $("#modalEstatusFatiga").modal("hide");
                    alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Actualización de estatus de fatiga</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#alertMsg").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(3000).fadeOut('slow');

                    getPuntosServiciosAndResponsables();

                    $("#txtFecha").val(fechaFatigaFacturacion);
                    $("#selectEstatus").val("Nuevo estatus");
                  
                } else if (response.status=="error")
                {
                  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error en actualización de estatus de fatiga:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#msgFatiga").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                }
              },
            error: function(){
                  alert('error handing here');
            }
        });
    }

$('#txtFecha').datetimepicker({
  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',
});

var fechaFatigaFacturacion = $.datepicker.formatDate('yy-mm-dd', new Date());
$("#txtFecha").val(fechaFatigaFacturacion);

</script>