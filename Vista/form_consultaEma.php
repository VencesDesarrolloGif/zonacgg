<?php
    $mesActual= DATE('m');
    $aux="2011-01-01";
    $fechaI=strtotime($aux);
    $anioInicio=date('Y',$fechaI);
    $añoActual= DATE('Y');    
?>
<div class="">
    <center><h4>CONSULTA EMA</h4>
        <label class=" control-label label " for="selectRegistros">REGISTRO PATRONAL:</label>
              <select id="selectRegistros" name="selectRegistros" class="input-large">
                <option value="">REGISTRO PATRONAL</option>
                <option value="TODOS">TODOS</option>
                        <?php
for ($i = 0; $i < count($catalogoRegistrosPatronales); $i++) {
    if ($catalogoRegistrosPatronales[$i]["idcatalogoRegistrosPatronales"] != 'R1438682103') {
        echo "<option value='" . $catalogoRegistrosPatronales[$i]["idcatalogoRegistrosPatronales"] . "'>" . $catalogoRegistrosPatronales[$i]["idcatalogoRegistrosPatronales"] . " </option>";
    }
}
?>
              </select>
              <br>
        <label class=" control-label label " for="selectAnio" style="margin-left: -120px;margin-right: 110px;">AÑO:</label>
        <select id="selectAnio" name="selectAnio" class="input-small" onchange="llenarMeses()">
                <option value="">AÑO</option>
                        <?php
                            for ($i = $anioInicio; $i <= $añoActual; $i++) {                                
                                echo "<option value='" . $i. "'>" . $i. " </option>";
                                
                            }
                    ?>
        </select>    
        <br>
        <label class=" control-label label " for="selectMes" style="margin-right: 110px">MES:</label>
        <select id="selectMes" name="selectMes" class="input-large">
                <option value=''>MES</option>
        </select>    
        <br>
        <button class="btn btn-primary" onclick="generarEma()">Calcular</button></center>        
        <br>
        <br>

        <section>

            <table id="tableEma" style="border-style: solid;border-collapse: collapse;white-space: nowrap;" border="3" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2"># Empleado</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">Nombre</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">Entidad</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">Cliente</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">Punto Servicio</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">Registro Patronal</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">Curp</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">N° Seguro Social</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">Alta</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">Baja</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">Dias</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">S.D.I.</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">Inc.</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">Aus.</th>
                        <th style="text-align: center;background-color: #B0E76E" colspan="7">ENFERMEDADES Y MATERNIDAD</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">R.T.</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">I.V. Pat.</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">I.V. Obr.</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">G.P.S.</th>
                        <th style="text-align: center;background-color: #B0E76E" style="text-align: center;" colspan="2">SUMA</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">SubTotal</th>


                    </tr>
                    <tr>
                        <th style="text-align: center;background-color: #B0E76E" >Cuota Fija</th>
                        <th style="text-align: center;background-color: #B0E76E" >Exc. Pat.</th>
                        <th style="text-align: center;background-color: #B0E76E" >Exc. Obr.</th>
                        <th style="text-align: center;background-color: #B0E76E" >P.D. Pat.</th>
                        <th style="text-align: center;background-color: #B0E76E" >P.D. Obr.</th>
                        <th style="text-align: center;background-color: #B0E76E" >G.M.P. Pat.</th>
                        <th style="text-align: center;background-color: #B0E76E" >G.M.P. Obr.</th>
                        <th style="text-align: center;background-color: #B0E76E" >Patronal</th>
                        <th style="text-align: center;background-color: #B0E76E" >Obrera</th>

                    </tr>
                </thead>

                <tbody ></tbody>
            </table>
        </section>
</div>

<script type="text/javascript">
var meses = ['ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE'];
var tableEma = null;

function generarEma(){
    //var año= <?php //echo $anioInicio; ?>;
    //alert(año);
    var regPatronal=$("#selectRegistros").val();
    var anio=$("#selectAnio").val();
    var mes=$("#selectMes").val();
    if(regPatronal==""){
        alert("Seleccione un registro patronal");
        return;
    }
    if(anio==""){
        alert("Seleccione un Año");
        return;
    }
    if(mes==""){
        alert("Seleccione un Mes");
        return;
    }

    tableCalculoEma = [];
         $.ajax({
             type: "POST",
             url: "ajax_calcularEma.php",
             data: {
                 "registro": regPatronal,"anio": anio, "mes": mes 
             },
             dataType: "json",
             success: function(response) {
                 console.log(response);
                 if (response.status == "success") {
                     //console.log(response.datos.length);
                     if(regPatronal==="TODOS"){
                                 for (var i = 0; i < response.datos.lista.length; i++) {
                                for (var j = 0; j < response.datos.lista[i].length; j++) {
                                      //tableCalculoEma.push(record);
                                      var record = response.datos.lista[i][j];
                                       tableCalculoEma.push(record);
                                   //console.log(tableCalculoEma);
                                 }  
                                }
                               loadDataInTableEma(tableCalculoEma);
                     }else{
                     for (var i = 0; i < response.datos.length; i++) {
                         var record = response.datos[i];
                        // if(i==0)
                            //console.log(record);
                         //alert(record.esatusPunto);
                         tableCalculoEma.push(record);
                     }
                     //console.log(tableempleadosbajasfiniquitos);
                     loadDataInTableEma(tableCalculoEma);

                    }
                 } else {
                     var mensaje = response.message;
                     console.log("mal");
                 }
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
             }
         });
}

function loadDataInTableEma(data) {
     if (tableEma != null) {
         tableEma.destroy();
     }
     tableEma = $('#tableEma').DataTable({
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
                 "data": "numeroEmpleado"
             }, {
                 "data": "nombreCompleto"
             },{
                 "data": "nombreEntidadFederativa"
             }, {
                 "data": "razonSocial"
             }, {
                 "data": "puntoServicio"
             }, {
                 "data": "registroPatronal"
             },{
                 "data": "curpEmpleado"
             }, {
                 "data": "nss"
             },  {
                 "data": "fechaImss"
             },{
                 "data": "fechaBajaImss"
             }, {
                 "data": "diasImss"
             }, {
                 "data": "sdi"
             }, {
                 "data": "incapacidades"
             }, {
                 "data": "ausentismos"
             }, {
                 "data": "cuotaFija"
             }, {
                 "data": "excPatron"
             }, {
                 "data": "excObrero"
             }, {
                 "data": "prestDinPatron"
             }, {
                 "data": "prestDinObrero"
             }, {
                 "data": "gastosMedicosPatron"
             }, {
                 "data": "gastosMedicosObrero"
             }, {
                 "data": "riesgoTrabajo"
             }, {
                 "data": "invYvPatron"
             }, {
                 "data": "invYvObrero"
             }, {
                 "data": "guarderiasYPen"
             }, {
                 "data": "sumaPatron"
             }, {
                 "data": "sumaObrero"
             }, {
                 "data": "subtotal"
             }, ]
             //,serverSide: true
             ,
              rowCallback:function(row,data)
            {

                $($(row).find("td")[26]).css("background-color","#7DDEF4");
            },
         processing: true,
         dom: 'Bfrtip',
         buttons: [
            {
                text: 'Descarga Excel',
                extend: 'excelHtml5',
                filename: 'Grupogif_ema',
                exportOptions: {
                        columns: ':visible',
                        search: 'applied',
                        order: 'applied'
                    },
                customize: function(xlsx) {
                    var hoja = xlsx.xl.worksheets['Consulta_EMA.xml'];

                    // Loop over the cells in column `C`
                    $('row c[r^="AA"]', hoja).each( function () {
                        // Get the value
                            $(this).attr( 's', '22' );
                    });
                }

            }
        ]
     });

 }

 function llenarMeses(){
    var sMeses="<option value=''>MES</option>";
    var mesActual= <?php echo $mesActual;?>;
    var anioSel=$("#selectAnio").val(); 
    if(anioSel!=""){
        if(anioSel!= <?php echo $añoActual;?>){            
            for(var i=0;i<meses.length;i++){
                sMeses+="<option value='"+(i+1)+"'>"+meses[i]+"</option>";
            }
        }else{            
            for(var i=0;i<mesActual;i++){
                sMeses+="<option value='"+(i+1)+"'>"+meses[i]+"</option>";
            }
        }
        $("#selectMes").html(sMeses);
    }else{
         $("#selectMes").html(sMeses);
    }
 }

</script>