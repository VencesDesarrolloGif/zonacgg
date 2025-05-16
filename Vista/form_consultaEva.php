<?php
    $mesActual= DATE('m');
    $aux="2011-01-01";
    $fechaI=strtotime($aux);
    $anioInicio=date('Y',$fechaI);
    $añoActual= DATE('Y');    
?>
<div class="">
    <center><h4>CONSULTA EBA</h4>
        <label class=" control-label label " for="selectRegistrosEva">REGISTRO PATRONAL:</label>
              <select id="selectRegistrosEva" name="selectRegistrosEva" class="input-large">
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
        <label class=" control-label label " for="selectAnioEv" style="margin-left: -120px;margin-right: 110px;">AÑO:</label>
        <select id="selectAnioEv" name="selectAnioEv" class="input-small" onchange="llenarBimestres()">
                <option value="">AÑO</option>
                        <?php
                            for ($i = $anioInicio; $i <= $añoActual; $i++) {                                
                                echo "<option value='" . $i. "'>" . $i. " </option>";
                                
                            }
                    ?>
        </select>    
        <br>
        <label class=" control-label label " for="selectBimestre" style="margin-right: 70px">BIMESTRE:</label>
        <select id="selectBimestre" name="selectBimestre" class="input-large">
                <option value=''>BIMESTRE</option>
        </select>    
        <br>
        <button class="btn btn-primary" onclick="generarEva()">Calcular</button></center>        
        <br>
        <br>

        <section>

            <table id="tableEva" style="border-style: solid;border-collapse: collapse;white-space: nowrap;" border="3" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2"># Empleado</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">Nombre</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">Entidad</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">Cliente</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">Punto Servicio</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">Registro Patronal</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">Curp</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">RFC</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">N° Seguro Social</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">Alta</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">Baja</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">Dias</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">S.D.I.</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">Inc.</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">Aus.</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">Retiro</th>
                        <th style="text-align: center;background-color: #B0E76E" colspan="2">Cesantía y Vejez</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">Suma</th>
                        <th style="text-align: center;background-color: #B0E76E" colspan="2">Aportación Patronal</th>                        
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">Amortización</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">Suma</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">Suma Total</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">Créd. Vivienda</th>
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">Tipo y Fecha de Movto. de Crédito</th>                        
                        <th style="text-align: center;background-color: #B0E76E" rowspan="2">Movimiento</th>



                    </tr>
                    <tr>                        
                        <th style="text-align: center;background-color: #B0E76E" >Patronal</th>
                        <th style="text-align: center;background-color: #B0E76E" >Obrera</th>

                        <th style="text-align: center;background-color: #B0E76E" >Con Crédito</th>
                        <th style="text-align: center;background-color: #B0E76E" >Sin Crédito</th>

                    </tr>
                   
                </thead>

                <tbody ></tbody>
            </table>
        </section>
</div>

<script type="text/javascript">

var mesesEva = ['01','02','03','04','05','06','07','08','09','10','11','12'];
var mesesName= ['ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE']
var bimestre = [];

    bimestre[0]= ["01","02"];
    bimestre[1]= ["03","04"];
    bimestre[2]= ["05","06"];
    bimestre[3]= ["07","08"];
    bimestre[4]= ["09","10"];
    bimestre[5]= ["11","12"];

var tableEva = null;

function generarEva(){
    //var año= <?php //echo $anioInicio; ?>;
    //alert(año);
    var regPatronal=$("#selectRegistrosEva").val();
    var anio=$("#selectAnioEv").val();
    var nBimestre=$("#selectBimestre").val();
    if(regPatronal==""){
        alert("Seleccione un Registro patronal");
        return;
    }
    if(anio==""){
        alert("Seleccione un Año");
        return;
    }
    if(nBimestre==""){
        alert("Seleccione un Bimestre");
        return;
    }

    tableCalculoEva = [];
    waitingDialog.show();
         $.ajax({
             type: "POST",
             url: "ajax_calcularEva.php",
             data: {
                 "registro": regPatronal,"anio": anio, "bimestre": bimestre[nBimestre-1] 
             },
             dataType: "json",
             success: function(response) {
                 console.log(response);
                 if (response.status == "success") {
                     //alert(response.datos.length);
                            if(regPatronal==="TODOS"){
                                 for (var i = 0; i < response.datos.lista.length; i++) {
                                for (var j = 0; j < response.datos.lista[i].length; j++) {
                                      //tableCalculoEma.push(record);
                                      var record = response.datos.lista[i][j];
                                       tableCalculoEva.push(record);
                                   //console.log(tableCalculoEva);
                                 }  
                                }
                               loadDataInTableEva(tableCalculoEva);
                                waitingDialog.hide();
                     }else{
                     for (var i = 0; i < response.datosInfo.length; i++) {
                         var record = response.datosInfo[i];
                        /* if(i==0)
                            console.log(record);*/
                         //alert(record.esatusPunto);
                         tableCalculoEva.push(record);
                     }
                     //console.log(tableempleadosbajasfiniquitos);
                     loadDataInTableEva(tableCalculoEva);
                     waitingDialog.hide();
                    }
                 } else {
                     var mensaje = response.message;
                     console.log("mal");
                     waitingDialog.hide();
                 }
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
                 waitingDialog.hide();
             }
         });
}

function loadDataInTableEva(data) {
     if (tableEva != null) {
         tableEva.destroy();
     }
     tableEva = $('#tableEva').DataTable({
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
             }, {
                 "data": "curpEmpleado"
             }, {
                 "data": "rfcEmpleado"
             }, {    
                 "data": "nss"
             }, {
                 "data": "fechaImss"
             },{
                 "data": "fechaBajaImss"
             }, {
                 "data": "diasInfonavit"
             }, {
                 "data": "sdi"
             }, {
                 "data": "incapacidades"
             }, {
                 "data": "ausentismos"
             }, {
                 "data": "retiro"
             }, {
                 "data": "cesantiaPat"
             }, {
                 "data": "cesantiaObr"
             }, {
                 "data": "suma1"
             }, {
                 "data": "aportacionConCredito"
             }, {
                 "data": "aportacionSinCredito"
             }, {
                 "data": "amortizacion"
             }, {
                 "data": "suma2"
             }, {
                 "data": "suma3"
             }, {
                 "data": "credito"
             }, {
                 "data": "movimientoCred"
             },  {
                 "data": "accion_movimiento"
             }, 

             ]

             //,serverSide: true
             ,
              rowCallback:function(row,data)
            {

                $($(row).find("td")[26]).css("background-color","#7DDEF4");
                $($(row).find("td")[28]).css("background-color","#7DDEF4");



            },
         processing: true,
         dom: 'Bfrtip',
         buttons: [
            {
                text: 'Descarga Excel',
                extend: 'excelHtml5',
                filename: 'Zonagif_eva',
                exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22],
                        search: 'applied',
                        order: 'applied'
                    },
                customize: function(xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];

                    // Loop over the cells in column `C`
                    $('row c[r^="AA"]', sheet).each( function () {
                        // Get the value
                            $(this).attr( 's', '10' );
                    });
                }

            }
        ]
     });

 }

 function llenarBimestres(){
    var sBim="<option value=''>BIMESTRE</option>";
    var mesActual= <?php echo $mesActual;?>;
    var anioSel=$("#selectAnioEv").val(); 
    var mesN=mesesEva[mesActual-1];
    var a=0;
    var b=1;
    if(anioSel!=""){
        if(anioSel!= <?php echo $añoActual;?>){     
            for(var i=1;i<=6;i++){
                sBim+="<option title='"+mesesName[a]+"->"+mesesName[b]+"' value='"+(i)+"'>"+(i)+"</option>";
                a+=2;
                b+=2;
            }
        }else{                          
            var pos=buscarBimestre(mesN);
            for(var i=1;i<=pos+1;i++){
                sBim+="<option title='"+mesesName[a]+"->"+mesesName[b]+"' value='"+(i)+"'>"+(i)+"</option>";
                a+=2;
                b+=2; 
            }
        }
        $("#selectBimestre").html(sBim);
    }else{
         $("#selectBimestre").html(sBim);
    }
 }


 function buscarBimestre(mes){
    for(var i=0;i<6;i++){
        var arreglo=bimestre[i];
        if(arreglo.includes(mes))
            return i;
    }
 }

 function nuevoMovimientoInfo(numeroEmpleado,nss,registro){
    //alert("Despite: "+numeroEmpleado+"-"+nss+"-"+registro);
 }

</script>