<center><h3>Detalle de Trabajadores</h3></center>
<br>
<section>
<center>
<select id="cuatrimestreDetalleTrabajadores" name="cuatrimestreDetalleTrabajadores">
  <option value="0">Cuatrimestre</option>
  <option value="1">Enero-Abril</option>
  <option value="2">Mayo-Agosto</option>
  <option value="3">Septiembre-Diciembre</option>
</select>
<select id="anioDetalleTrabajadores" name="anioDetalleTrabajadores">
  <option value="" selected>Año</option>
  <?php $year = date("Y");
  for($i=$year; $i>=2020; $i--){
      echo '<option value="'.$i.'">'.$i.'</option>';
     }
  ?>
</select>
<img id="btnBuscarDetalleTrabajadores" src="img\botonbuscar.jpg" onclick="consultaDetalleTrabajadores();" style="width: 6.5%;" title="Buscar">
</center>
<div id="divTablaDetalleTrabajadores" style="display: none;">
<table id="tablaDetalleTrabajadores"  class="records_list table table-striped table-bordered table-hover" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th style="text-align: center;background-color: #B0E76E">No.Empleado</th>
            <th style="text-align: center;background-color: #B0E76E">Nombre</th>
            <th style="text-align: center;background-color: #B0E76E">Estatus</th>
            <th style="text-align: center;background-color: #B0E76E">Fecha de Ingreso</th>
            <th style="text-align: center;background-color: #B0E76E">Fecha de Baja</th>
            <th style="text-align: center;background-color: #B0E76E">RFC del sujeto obligado</th>
            <th style="text-align: center;background-color: #B0E76E">Número de contrato</th>
            <th style="text-align: center;background-color: #B0E76E">Registro Patronal ante el IMSS</th>
            <th style="text-align: center;background-color: #B0E76E">Número de Seguro Social del trabajador</th>
            <th style="text-align: center;background-color: #B0E76E">Punto de Servicio</th>
            <th style="text-align: center;background-color: #B0E76E">Calle(centro del trabajo)</th>
            <th style="text-align: center;background-color: #B0E76E">Número exterior(centro del trabajo)</th>
            <th style="text-align: center;background-color: #B0E76E">Número interior(centro de trabajo)</th>       
            <th style="text-align: center;background-color: #B0E76E">Colonia(centro de trabajo)</th>
            <th style="text-align: center;background-color: #B0E76E">Código Postal(centro de trabajo)</th>
            <th style="text-align: center;background-color: #B0E76E">Municipio o Alcaldía(centro de trabajo)</th>
            <th style="text-align: center;background-color: #B0E76E">Entidad federativa(centro de trabajo)</th>
            <th style="text-align: center;background-color: #B0E76E">Dias de Incapacidad</th>
           <!-- <th style="text-align: center;background-color: #B0E76E">Monto Percepciones variables</th>
            <th style="text-align: center;background-color: #B0E76E">Monto Percepciones fijas</th>
            <th style="text-align: center;background-color: #B0E76E">Percepciones no integrables al SBA</th>
            <th style="text-align: center;background-color: #B0E76E">salario no excedente (VSM)</th>-->
        </tr>
    </thead>        
</table>
</div>
</section>
<script type="text/javascript"> 

function consultaDetalleTrabajadores() { 
var cuatrimestre= $("#cuatrimestreDetalleTrabajadores").val();
var anio= $("#anioDetalleTrabajadores").val();
if(cuatrimestre==''){
alert("selecciones un cuatrimestre");
return;
}else if (anio==''){
alert("selecciones un año");
return;
}
waitingDialog.show();
tableDetTrab = [];
$.ajax({
        type: "POST",
        url: "ajax_ConsultaDetalleTrabajadores.php",
        data:{cuatrimestre,anio},
        dataType: "json", 
        success:function(response){
              if(response.status == "success"){
                waitingDialog.hide();
                $("#divTablaDetalleTrabajadores").show();
                for(var i = 0; i < response.datos.length; i++){

                    // puntoServicio = validarTextoT(response.datos[i]["puntoServicio"]);

                    if(response.datos[i]["CallePrincipaPuntoS"]!='0' || response.datos[i]["CallePrincipaPuntoS"]!=''){
                        CallePrincipaPuntoS = validarTextoT(response.datos[i]["CallePrincipaPuntoS"]);
                        response.datos[i]["CallePrincipaPuntoS"] = CallePrincipaPuntoS;
                    }

                    if(response.datos[i]["NumExteriorPuntoS"]!='0' || response.datos[i]["NumExteriorPuntoS"]!=''){
                        NumExteriorPuntoS = validarTextoT(response.datos[i]["NumExteriorPuntoS"]);
                        response.datos[i]["NumExteriorPuntoS"] = NumExteriorPuntoS;
                    }

                    if(response.datos[i]["NumInterirPuntoS"]!='0' || response.datos[i]["NumInterirPuntoS"]!=''){
                        NumInterirPuntoS = validarTextoT(response.datos[i]["NumInterirPuntoS"]);
                        response.datos[i]["NumInterirPuntoS"] = NumInterirPuntoS;
                    }

                    if(response.datos[i]["ColPuntoS"]!='0' || response.datos[i]["ColPuntoS"]!=''){
                        ColPuntoS = validarTextoT(response.datos[i]["ColPuntoS"]);
                        response.datos[i]["ColPuntoS"] = ColPuntoS;
                    }

                    if(response.datos[i]["CPpuntoS"]!='0' || response.datos[i]["CPpuntoS"]!=''){
                        CPpuntoS = validarTextoT(response.datos[i]["CPpuntoS"]);
                        response.datos[i]["CPpuntoS"] = CPpuntoS;
                    }

                    if(response.datos[i]["MunPuntoS"]!='0' || response.datos[i]["MunPuntoS"]!=''){
                        MunPuntoS = validarTextoT(response.datos[i]["MunPuntoS"]);
                        response.datos[i]["MunPuntoS"] = MunPuntoS;
                    }

                    if(response.datos[i]["EntPuntoS"]!='0' || response.datos[i]["EntPuntoS"]!=''){
                        EntPuntoS = validarTextoT(response.datos[i]["EntPuntoS"]);
                        response.datos[i]["EntPuntoS"] = EntPuntoS;
                    }

                    var record = response.datos[i];
                    tableDetTrab.push(record);
                   }
                loadDataInTableDetTrab(tableDetTrab);
               }else{
                     var mensaje = response.message;
                     console.log("mal");
                     waitingDialog.hide();
                $("#divTablaDetalleTrabajadores").hide();
                    }
          },error:function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
                  waitingDialog.hide();
                $("#divTablaDetalleTrabajadores").hide();
                 }
        });
 }

 function validarTextoT (textoOriginal){
    var textoFinal = textoOriginal;
    var specialChars = "!@#$^&%*()+=-[]\/{}|:<>?,.";
    for (var j = 0; j < specialChars.length; j++) {
        // alert(textoOriginal);
        textoFinal = textoFinal.replace(new RegExp("\\" + specialChars[j], 'gi'), '').toUpperCase();
        // alert(textoFinal);
    }
    textoFinal = textoFinal.replace(/á|ä/gi,"A");
    textoFinal = textoFinal.replace(/é|ë/gi,"E");
    textoFinal = textoFinal.replace(/í|ï/gi,"I");
    textoFinal = textoFinal.replace(/ó|ö/gi,"O");
    textoFinal = textoFinal.replace(/ú|ü/gi,"U");
    textoFinal = textoFinal.replace(/ñ/gi,"N");

    return textoFinal;
 }

 var tableDetalleTrab = null;

function loadDataInTableDetTrab(data) {

if(tableDetalleTrab != null) {
   tableDetalleTrab.destroy();
  }
    tableDetalleTrab = $('#tablaDetalleTrabajadores').DataTable({
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
             "data": "noEmpleado"
         }, 
         {   "className": "dt-body-center",
             "data": "nombre"
         }, 
         {   "className": "dt-body-center",
             "data": "estatusEmpleado"
         },
         {   "className": "dt-body-center",
             "data": "fechaIngreso"
         },
         {   "className": "dt-body-center",
             "data": "fechaBaja"
         }, 
         {   "className": "dt-body-center",
             "data": "rfc"
         }, 
         {   "className": "dt-body-center",
             "data": "numeroContrato" 
         }, 
         {   "className": "dt-body-center",
             "data": "registroPatronal"
         },
         {   "className": "dt-body-center",
             "data": "noImss"
         },
         {   "className": "dt-body-center",
             "data": "puntoServicio"
         },
         {   "className": "dt-body-center",
             "data": "CallePrincipaPuntoS"
         },
         {   "className": "dt-body-center",
             "data": "NumExteriorPuntoS"
         },
         {   "className": "dt-body-center",
             "data": "NumInterirPuntoS"
         },
         {   "className": "dt-body-center",
             "data": "ColPuntoS"
         },
         {   "className": "dt-body-center",
             "data": "CPpuntoS"
         },
         {   "className": "dt-body-center",
             "data": "MunPuntoS"
         },
         {   "className": "dt-body-center",
             "data": "EntPuntoS"
         },
         {   "className": "dt-body-center",
             "data": "incapacidadesEmp"
         },],

         processing: true,
         dom: 'Bfrtip',

          buttons: {
       buttons: ['excel','csv']
    }     
   });
 }
  
 </script>