<center><h3>Detalle de Sujeto Obligado</h3></center>
<br>
<section>
<center>
<select id="cuatrimestreDetalleSujetoObligado" name="cuatrimestreDetalleSujetoObligado">
  <option value="0">Cuatrimestre</option>
  <option value="1">Enero-Abril</option>
  <option value="2">Mayo-Agosto</option>
  <option value="3">Septiembre-Diciembre</option>
</select>

<select id="anioDetalleSujetoObligado" name="anioDetalleSujetoObligado">
  <option value="" selected>Año</option>
  <?php $year = date("Y");
  for($i=$year; $i>=2020; $i--){
      echo '<option value="'.$i.'">'.$i.'</option>';
     }
  ?>
</select>
<img id="btnBuscarDetalleSujetoObligado" src="img\botonbuscar.jpg" onclick="consultaDetalleSujetoObligado();" style="width: 6.5%;" title="Buscar">
</center>

<table id="tablaDetalleSujetoObligado"  class="records_list table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="display: none;">
    <thead>
        <tr>
            <th style="text-align: center;background-color: #B0E76E">RFC</th>
            <th style="text-align: center;background-color: #B0E76E">Nombre, Denominación o Razón Social</th>
            <th style="text-align: center;background-color: #B0E76E">Correo Electronico</th>
            <th style="text-align: center;background-color: #B0E76E">Telefono(numero, extensión)</th>
            <th style="text-align: center;background-color: #B0E76E">Registro Patronal</th>
            <th style="text-align: center;background-color: #B0E76E">Calle</th>
            <th style="text-align: center;background-color: #B0E76E">Número exterior</th>
            <th style="text-align: center;background-color: #B0E76E">Número interior</th>      
            <th style="text-align: center;background-color: #B0E76E">Entre Calle</th>
            <th style="text-align: center;background-color: #B0E76E">Y Calle</th>
            <th style="text-align: center;background-color: #B0E76E">Colonia</th>
            <th style="text-align: center;background-color: #B0E76E">Código Postal</th>
            <th style="text-align: center;background-color: #B0E76E">Municipio o Alcaldía</th>
            <th style="text-align: center;background-color: #B0E76E">Entidad Federativa</th>
            <th style="text-align: center;background-color: #B0E76E">Representante Legal</th>
            <th style="text-align: center;background-color: #B0E76E">Administrador Único</th>
            <th style="text-align: center;background-color: #B0E76E">Número de Escritura</th>
            <th style="text-align: center;background-color: #B0E76E">Nombre del Notario Público</th>
            <th style="text-align: center;background-color: #B0E76E">Número de Notario Público</th>
            <th style="text-align: center;background-color: #B0E76E">Fecha de Escritura Pública</th>
            <th style="text-align: center;background-color: #B0E76E">Folio Mercantil</th>
            <th style="text-align: center;background-color: #B0E76E">Aportación sin crédito de los trabajadores del contrato</th>
            <th style="text-align: center;background-color: #B0E76E">Aportación con crédito de los trabajadores del contrato</th>
            <th style="text-align: center;background-color: #B0E76E">Amortización de los trabajadores del contrato</th>
            <th style="text-align: center;background-color: #B0E76E">No.de registro ante la Secretaría de Trabajo y Previsión Social</th>
        </tr>
    </thead>        
</table>
</section>
<script type="text/javascript"> 

function consultaDetalleSujetoObligado() { 
var cuatrimestre= $("#cuatrimestreDetalleSujetoObligado").val();
var anio= $("#anioDetalleSujetoObligado").val();

if(cuatrimestre==''){
alert("selecciones un cuatrimestre");
return;
}else if (anio==''){
alert("selecciones un año");
return;
}

  tableDetSujOb = [];
waitingDialog.show();
  $.ajax({
          type: "POST",
          url: "ajax_ConsultaDetalleSujetoObligado.php",
          data:{cuatrimestre,anio},
          dataType: "json", 
          success: function(response){
              if(response.status == "success"){
                waitingDialog.hide();
                $("#tablaDetalleSujetoObligado").show();
                for(var i = 0; i < response.datosSO.length; i++){



if(response.datosSO[i]["CallePrincipaCliente"]==null || response.datosSO[i]["CallePrincipaCliente"]=='null' || response.datosSO[i]["CallePrincipaCliente"]=='NULL'){
    response.datosSO[i]["CallePrincipaCliente"]='0';
}
if(response.datosSO[i]["NumeroExteriorCliente"]==null || response.datosSO[i]["NumeroExteriorCliente"]=='null' || response.datosSO[i]["NumeroExteriorCliente"]=='NULL'){
    response.datosSO[i]["NumeroExteriorCliente"]='0';
}
if(response.datosSO[i]["NumeroInterirCliente"]==null || response.datosSO[i]["NumeroInterirCliente"]=='null' || response.datosSO[i]["NumeroInterirCliente"]=='NULL'){
    response.datosSO[i]["NumeroInterirCliente"]='0';
}
if(response.datosSO[i]["PrimerCalleCliente"]==null || response.datosSO[i]["PrimerCalleCliente"]=='null' || response.datosSO[i]["PrimerCalleCliente"]=='NULL'){
    response.datosSO[i]["PrimerCalleCliente"]='0';
}
if(response.datosSO[i]["SegundaCalleCliente"]==null || response.datosSO[i]["SegundaCalleCliente"]=='null' || response.datosSO[i]["SegundaCalleCliente"]=='NULL'){
    response.datosSO[i]["SegundaCalleCliente"]='0';
}
if(response.datosSO[i]["ColoniaCliente"]==null || response.datosSO[i]["ColoniaCliente"]=='null' || response.datosSO[i]["ColoniaCliente"]=='NULL'){
    response.datosSO[i]["ColoniaCliente"]='0';
}
if(response.datosSO[i]["CodigoPostalCliente"]==null || response.datosSO[i]["CodigoPostalCliente"]=='null' || response.datosSO[i]["CodigoPostalCliente"]=='NULL'){
    response.datosSO[i]["CodigoPostalCliente"]='0';
}
if(response.datosSO[i]["MunicipioCliente"]==null || response.datosSO[i]["MunicipioCliente"]=='null' || response.datosSO[i]["MunicipioCliente"]=='NULL'){
    response.datosSO[i]["MunicipioCliente"]='0';
}
if(response.datosSO[i]["nombreEntidadFederativa"]==null || response.datosSO[i]["nombreEntidadFederativa"]=='null' || response.datosSO[i]["nombreEntidadFederativa"]=='NULL'){
    response.datosSO[i]["nombreEntidadFederativa"]='0';
}
if(response.datosSO[i]["representantelegal"]==null || response.datosSO[i]["representantelegal"]=='null' || response.datosSO[i]["representantelegal"]=='NULL'){
    response.datosSO[i]["representantelegal"]='0';
}
if(response.datosSO[i]["administradorunico"]==null || response.datosSO[i]["administradorunico"]=='null' || response.datosSO[i]["administradorunico"]=='NULL'){
    response.datosSO[i]["administradorunico"]='0';
}


//alert(response.datosSO[i]["CallePrincipaCliente"]);
//alert(response.datosSO[i]["NumeroExteriorCliente"]);
//alert(response.datosSO[i]["NumeroInterirCliente"]);
//alert(response.datosSO[i]["PrimerCalleCliente"]);
//alert(response.datosSO[i]["SegundaCalleCliente"]);
//alert(response.datosSO[i]["ColoniaCliente"]);
//alert(response.datosSO[i]["CodigoPostalCliente"]);
//alert(response.datosSO[i]["MunicipioCliente"]);
//alert(response.datosSO[i]["nombreEntidadFederativa"]);
                    telefonoFijoCliente = validarTextoSO(response.datosSO[i]["telefonoFijoCliente"]);
                    CallePrincipaCliente = validarTextoSO(response.datosSO[i]["CallePrincipaCliente"]);
                    NumeroExteriorCliente= validarTextoSO(response.datosSO[i]["NumeroExteriorCliente"]);
                    NumeroInterirCliente = validarTextoSO(response.datosSO[i]["NumeroInterirCliente"]);
                    PrimerCalleCliente   = validarTextoSO(response.datosSO[i]["PrimerCalleCliente"]);
                    SegundaCalleCliente  = validarTextoSO(response.datosSO[i]["SegundaCalleCliente"]);
                    ColoniaCliente = validarTextoSO(response.datosSO[i]["ColoniaCliente"]);
                    CodigoPostalCliente = validarTextoSO(response.datosSO[i]["CodigoPostalCliente"]);
                    MunicipioCliente= validarTextoSO(response.datosSO[i]["MunicipioCliente"]);
                    nombreEntidadFederativa = validarTextoSO(response.datosSO[i]["nombreEntidadFederativa"]);
                    representantelegal = validarTextoSO(response.datosSO[i]["representantelegal"]);
                    administradorunico = validarTextoSO(response.datosSO[i]["administradorunico"]);
                    administradorunico = validarTextoSO(response.datosSO[i]["administradorunico"]);
                    nombreDelNotarioPublico = validarTextoSO(response.datosSO[i]["nombreDelNotarioPublico"]);                   

                    response.datosSO[i]["telefonoFijoCliente"] = telefonoFijoCliente;
                    response.datosSO[i]["CallePrincipaCliente"] = CallePrincipaCliente;
                    response.datosSO[i]["NumeroExteriorCliente"]= NumeroExteriorCliente;
                    response.datosSO[i]["NumeroInterirCliente"] = NumeroInterirCliente;
                    response.datosSO[i]["PrimerCalleCliente"] = PrimerCalleCliente;
                    response.datosSO[i]["SegundaCalleCliente"]= SegundaCalleCliente;
                    response.datosSO[i]["ColoniaCliente"]= ColoniaCliente;
                    response.datosSO[i]["CodigoPostalCliente"]  = CodigoPostalCliente;
                    response.datosSO[i]["MunicipioCliente"]= MunicipioCliente;
                    response.datosSO[i]["nombreEntidadFederativa"]= nombreEntidadFederativa;
                    response.datosSO[i]["representantelegal"]= representantelegal;
                    response.datosSO[i]["administradorunico"]= administradorunico;
                    response.datosSO[i]["nombreDelNotarioPublico"]= nombreDelNotarioPublico;



                    var record = response.datosSO[i];
                    tableDetSujOb.push(record);
                   }
                loadDataInTableDetSujOb(tableDetSujOb);
               }else{
                     var mensaje = response.message;
                     console.log("mal");
                     waitingDialog.hide();
                     $("#tablaDetalleSujetoObligado").show();
                    }
          },error:function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
                  waitingDialog.hide();
                  $("#tablaDetalleSujetoObligado").show();
                 }
        });
 }

 function validarTextoSO (texto){
    var textoFinal = texto;
    var caracteresEspeciales = "!@#$^&%*()+=-[]\/{}|:<>?,.";
    for (var j = 0; j < caracteresEspeciales.length; j++) {
        textoFinal = textoFinal.replace(new RegExp("\\" + caracteresEspeciales[j], 'gi'), '').toUpperCase();
    }
    textoFinal = textoFinal.replace(/á|ä/gi,"A");
    textoFinal = textoFinal.replace(/é|ë/gi,"E");
    textoFinal = textoFinal.replace(/í|ï/gi,"I");
    textoFinal = textoFinal.replace(/ó|ö/gi,"O");
    textoFinal = textoFinal.replace(/ú|ü/gi,"U");
    textoFinal = textoFinal.replace(/ñ/gi,"N");

    return textoFinal;
 }

 var tableDetalleSujOb = null;

function loadDataInTableDetSujOb(data) {

    if(tableDetalleSujOb != null) {
       tableDetalleSujOb.destroy();
      }
    tableDetalleSujOb = $('#tablaDetalleSujetoObligado').DataTable({
    "language":{
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
         {   "className": "dt-body-center",
             "data": "rfcCliente"
         }, 
         {   
             "data": "razonSocial"
         }, 
         {   "className": "dt-body-center",
             "data": "correoCliente"
         }, 
         {   "className": "dt-body-center",
             "data": "telefonoFijoCliente"
         },
         {   "className": "dt-body-center",
             "data": "RegistroPatronal"
         },
         {   "className": "dt-body-center",
             "data": "CallePrincipaCliente" 
         }, 
         {   "className": "dt-body-center",
             "data": "NumeroExteriorCliente"
         },
         {   "className": "dt-body-center",
             "data": "NumeroInterirCliente"
         },
         {   "className": "dt-body-center",
             "data": "PrimerCalleCliente"
         },
         {   "className": "dt-body-center",
             "data": "SegundaCalleCliente"
         },
         {   "className": "dt-body-center",
             "data": "ColoniaCliente"
         },
         {   "className": "dt-body-center",
             "data": "CodigoPostalCliente"
         },
         {   "className": "dt-body-center",
             "data": "MunicipioCliente"
         },
         {   "className": "dt-body-center",
             "data": "nombreEntidadFederativa"
         },
         {   "className": "dt-body-center",
             "data": "representantelegal"
         },
         {   "className": "dt-body-center",
             "data": "administradorunico"
         },
         {   "className": "dt-body-center",
             "data": "numerodeescritura"
         },
         {   "className": "dt-body-center",
             "data": "nombreDelNotarioPublico"
         },
         {   "className": "dt-body-center",
             "data": "numeroNotarioPublico"
         },
         {   "className": "dt-body-center",
             "data": "fechaEscrituraPublica"
         },
         {   "className": "dt-body-center",
             "data": "folioMercantil"
         },
         {   "className": "dt-body-center",
             "data": "SinCredito"
         },
         {   "className": "dt-body-center",
             "data": "Credito"
         },
         {   "className": "dt-body-center",
             "data": "AmortizacionTotal"
         },
         {   "className": "dt-body-center",
             "data": "NumAcuerdo"
         }, ],

         processing: true,
         dom: 'Bfrtip',

          buttons: {
        buttons: ['excel']
    }
         
     });
 }
  
 </script>