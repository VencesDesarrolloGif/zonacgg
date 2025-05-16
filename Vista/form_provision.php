<?php
 $mes= DATE('m');
 $fechaMinima="2011-01-01";
 $fechaInicio=strtotime($fechaMinima);
 $anioConsultaInicio=date('Y',$fechaInicio);
 $anioActual= DATE('Y');    
?>
<div class="">
<center>
    <h4>PROVISIÓN</h4>
        <label class=" control-label label " for="selectRegistroProvision">REGISTRO PATRONAL:</label>
            <select id="selectRegistroProvision" name="selectRegistroProvision" class="input-large">
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
    <label class=" control-label label " for="selectAnioProvision" style="margin-left: -120px;margin-right: 110px;">AÑO:</label>
        <select id="selectAnioProvision" name="selectAnioProvision" class="input-small" onchange="llenarMesesProvision()">
            <option value="">AÑO</option>
                <?php
                    for ($i = $anioConsultaInicio; $i <= $anioActual; $i++) {                                
                        echo "<option value='" . $i. "'>" . $i. " </option>";
                    }
                ?>
        </select>    
<br>
    <label class=" control-label label " for="selectMesProvision" style="margin-right: 110px">MES:</label>
        <select id="selectMesProvision" name="selectMesProvision" class="input-large">
                <option value=''>MES</option>
        </select>     
<br>
    <button class="btn btn-primary" onclick="generarCalculo()">Calcular</button>
</center>        
<br>
<br>
<input type="hidden" id="diasImssHidden">
<input type="hidden" id="sdiHidden">
<input type="hidden" id="incapacidadesHidden">
<input type="hidden" id="ausentismosHidden">
<input type="hidden" id="cuotaFijaHidden">
<input type="hidden" id="excPatronHidden">
<input type="hidden" id="excObreroHidden">
<input type="hidden" id="prestDinPatronHidden">
<input type="hidden" id="prestDinObreroHidden">
<input type="hidden" id="gastosMedicosPatronHidden">
<input type="hidden" id="gastosMedicosObreroHidden">
<input type="hidden" id="riesgoTrabajoHidden">
<input type="hidden" id="invYvPatronHidden">
<input type="hidden" id="invYvObreroHidden">
<input type="hidden" id="guarderiasYPenHidden">
<input type="hidden" id="sumaPatronalHidden">
<input type="hidden" id="sumaObreraHidden">
<input type="hidden" id="subTotalHidden">

<section>
    <table id="tableProvision" style="border-style: solid;border-collapse: collapse;white-space: nowrap;" border="3" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th style="text-align: center;background-color: #B0E76E" rowspan="2">Registro Patronal</th>
                <th style="text-align: center;background-color: #B0E76E" rowspan="2">Dias EMA</th>
                <th style="text-align: center;background-color: #B0E76E" rowspan="2">S.D.I. EMA</th>
                <th style="text-align: center;background-color: #B0E76E" rowspan="2">Inc. EMA</th>
                <th style="text-align: center;background-color: #B0E76E" rowspan="2">Aus. EMA</th>
                <th style="text-align: center;background-color: #B0E76E" colspan="7">ENFERMEDADES Y MATERNIDAD EMA</th>
                <th style="text-align: center;background-color: #B0E76E" rowspan="2">R.T. EMA</th>
                <th style="text-align: center;background-color: #B0E76E" rowspan="2">I.V. Pat. EMA</th>
                <th style="text-align: center;background-color: #B0E76E" rowspan="2">I.V. Obr. EMA</th>
                <th style="text-align: center;background-color: #B0E76E" rowspan="2">G.P.S. EMA</th>
                <th style="text-align: center;background-color: #B0E76E" style="text-align: center;" colspan="2">SUMA EMA</th>
                <th style="text-align: center;background-color: #B0E76E" rowspan="2">SubTotal EMA</th>
                <th style="text-align: center;background-color: #B0E76E" rowspan="2">Dias EBA</th>
                <th style="text-align: center;background-color: #B0E76E" rowspan="2">S.D.I. EBA</th>
                <th style="text-align: center;background-color: #B0E76E" rowspan="2">Inc. EBA</th>
                <th style="text-align: center;background-color: #B0E76E" rowspan="2">Aus. EBA</th>
                <th style="text-align: center;background-color: #B0E76E" rowspan="2">Retiro EBA</th>
                <th style="text-align: center;background-color: #B0E76E" colspan="2">Cesantía y Vejez EBA</th>
                <th style="text-align: center;background-color: #B0E76E" rowspan="2">Suma EBA</th>
                <th style="text-align: center;background-color: #B0E76E" colspan="2">Aportación Patronal EBA</th>                        
                <th style="text-align: center;background-color: #B0E76E" rowspan="2">Amortización EBA</th>
                <th style="text-align: center;background-color: #B0E76E" rowspan="2">Suma EBA</th>
                <th style="text-align: center;background-color: #B0E76E" rowspan="2">Suma Total EBA</th>
                <th style="text-align: center;background-color: #B0E76E" rowspan="2">Neto</th>
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
                    <th style="text-align: center;background-color: #B0E76E" >Patronal</th>
                    <th style="text-align: center;background-color: #B0E76E" >Obrera</th>
                    <th style="text-align: center;background-color: #B0E76E" >Con Crédito</th>
                    <th style="text-align: center;background-color: #B0E76E" >Sin Crédito</th>
                </tr>
        </thead>
        <tbody></tbody>
    </table>
</section>
</div>

<script type="text/javascript">

var mesesProvision = ['01','02','03','04','05','06','07','08','09','10','11','12'];
var descripcionMes = ['ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE'];
var bimestre = [];

    bimestre[0]= ["01","02"];
    bimestre[1]= ["03","04"];
    bimestre[2]= ["05","06"];
    bimestre[3]= ["07","08"];
    bimestre[4]= ["09","10"];
    bimestre[5]= ["11","12"];

var tableProvision = null;

function generarCalculo(){

    var registroPatronal =$("#selectRegistroProvision").val();
    var anio      = $("#selectAnioProvision").val();
    var mes =$("#selectMesProvision").val();

    if(registroPatronal==""){
       alert("Seleccione un Registro patronal");
       return;
    }
    if(anio==""){
       alert("Seleccione un Año");
       return;
    }
    if(mes==""){
       alert("Seleccione un mes");
       return;
    }
    diasImssTotalSuma = [];
    sdiTotalSuma = [];
    incapacidadesTotalSuma = [];
    ausentismosTotalSuma = [];
    cuotaFijaTotalSuma = [];
    excPatronTotalSuma = [];
    excObreroTotalSuma = [];
    prestDinPatronTotalSuma = [];
    prestDinObreroTotalSuma = [];
    gastosMedicosPatronTotalSuma = [];
    gastosMedicosObreroTotalSuma = [];
    riesgoTrabajoTotalSuma = [];
    invYvPatronTotalSuma = [];
    invYvObreroTotalSuma = [];
    guarderiasYPenTotalSuma = [];
    sumaPatronalTotalSuma = [];
    sumaObreraTotalSuma = [];
    subTotalTotalSuma = [];
    listaregistroP = [];
        $.ajax({
                type: "POST",
                url: "ajax_calcularProvisionEMA.php",
                data: {"registro": registroPatronal,"anio": anio, "mes": mes },
                dataType: "json",
                async:false,
                success: function(response) {
                    if(response.status == "success") {
                      if (registroPatronal=="TODOS") {
                        var listaregistroP=response.datosRegistroP;
                        for(var i = 0; i < response.datosRegistroP.length; i++) {

                            var registroP = response.datosRegistroP[i]["idcatalogoRegistrosPatronales"];
                            diasImssTotalSuma[i]= response.datosProvision[registroP]["diasImssTotal"];
                            sdiTotalSuma[i] = response.datosProvision[registroP]["sdiTotal"];                    
                            incapacidadesTotalSuma[i]=response.datosProvision[registroP]["incapacidadesTotal"];
                            ausentismosTotalSuma[i] = response.datosProvision[registroP]["ausentismosTotal"];
                            cuotaFijaTotalSuma[i] = response.datosProvision[registroP]["cuotaFijaTotal"];                    
                            excPatronTotalSuma[i] = response.datosProvision[registroP]["excPatronTotal"];                    
                            excObreroTotalSuma[i] = response.datosProvision[registroP]["excObreroTotal"];                    
                            prestDinPatronTotalSuma[i] = response.datosProvision[registroP]["prestDinPatronTotal"];
                            prestDinObreroTotalSuma[i] = response.datosProvision[registroP]["prestDinObreroTotal"];
                            gastosMedicosPatronTotalSuma[i] = response.datosProvision[registroP]["gastosMedicosPatronTotal"];
                            gastosMedicosObreroTotalSuma[i] = response.datosProvision[registroP]["gastosMedicosObreroTotal"];
                            riesgoTrabajoTotalSuma[i]=response.datosProvision[registroP]["riesgoTrabajoTotal"];
                            invYvPatronTotalSuma[i] = response.datosProvision[registroP]["invYvPatronTotal"];
                            invYvObreroTotalSuma[i] = response.datosProvision[registroP]["invYvObreroTotal"];
                            guarderiasYPenTotalSuma[i]= response.datosProvision[registroP]["guarderiasYPenTotal"];
                            sumaPatronalTotalSuma[i]  = response.datosProvision[registroP]["sumaPatronalTotal"];
                            sumaObreraTotalSuma[i] = response.datosProvision[registroP]["sumaObreraTotal"];                    
                            subTotalTotalSuma[i] = response.datosProvision[registroP]["subTotalTotal"];    
                        }
                            generarProvision(listaregistroP,diasImssTotalSuma,sdiTotalSuma,incapacidadesTotalSuma,ausentismosTotalSuma,cuotaFijaTotalSuma,excPatronTotalSuma,excObreroTotalSuma,prestDinPatronTotalSuma,prestDinObreroTotalSuma,gastosMedicosPatronTotalSuma,gastosMedicosObreroTotalSuma,riesgoTrabajoTotalSuma,invYvPatronTotalSuma,invYvObreroTotalSuma,guarderiasYPenTotalSuma,sumaPatronalTotalSuma,sumaObreraTotalSuma,subTotalTotalSuma);
                      }//IF TODOS
                      else{
                            var diasImssTotal = response.datos["diasImssTotal"];
                            var sdiTotal = response.datos["sdiTotal"].toFixed(2);
                            var incapacidadesTotal = response.datos["incapacidadesTotal"].toFixed(2);
                            var ausentismosTotal = response.datos["ausentismosTotal"].toFixed(2);
                            var cuotaFijaTotal = response.datos["cuotaFijaTotal"].toFixed(2);
                            var excPatronTotal = response.datos["excPatronTotal"].toFixed(2);
                            var excObreroTotal = response.datos["excObreroTotal"].toFixed(2);
                            var prestDinPatronTotal = response.datos["prestDinPatronTotal"].toFixed(2);
                            var prestDinObreroTotal = response.datos["prestDinObreroTotal"].toFixed(2);
                            var gastosMedicosPatronTotal = response.datos["gastosMedicosPatronTotal"].toFixed(2);
                            var gastosMedicosObreroTotal = response.datos["gastosMedicosObreroTotal"].toFixed(2);
                            var riesgoTrabajoTotal = response.datos["riesgoTrabajoTotal"].toFixed(2);
                            var invYvPatronTotal = response.datos["invYvPatronTotal"].toFixed(2);
                            var invYvObreroTotal = response.datos["invYvObreroTotal"].toFixed(2);
                            var guarderiasYPenTotal = response.datos["guarderiasYPenTotal"].toFixed(2);
                            var sumaPatronalTotal = response.datos["sumaPatronalTotal"].toFixed(2);
                            var sumaObreraTotal = response.datos["sumaObreraTotal"].toFixed(2);
                            var subTotalTotal = response.datos["subTotalTotal"].toFixed(2);

                            $("#diasImssHidden").val(diasImssTotal);
                            $("#sdiHidden").val(sdiTotal);
                            $("#incapacidadesHidden").val(incapacidadesTotal);
                            $("#ausentismosHidden").val(ausentismosTotal);
                            $("#cuotaFijaHidden").val(cuotaFijaTotal);
                            $("#excPatronHidden").val(excPatronTotal);
                            $("#excObreroHidden").val(excObreroTotal);
                            $("#prestDinPatronHidden").val(prestDinPatronTotal);
                            $("#prestDinObreroHidden").val(prestDinObreroTotal);
                            $("#gastosMedicosPatronHidden").val(gastosMedicosPatronTotal);
                            $("#gastosMedicosObreroHidden").val(gastosMedicosObreroTotal);
                            $("#riesgoTrabajoHidden").val(riesgoTrabajoTotal);
                            $("#invYvPatronHidden").val(invYvPatronTotal);
                            $("#invYvObreroHidden").val(invYvObreroTotal);
                            $("#guarderiasYPenHidden").val(guarderiasYPenTotal);
                            $("#sumaPatronalHidden").val(sumaPatronalTotal);
                            $("#sumaObreraHidden").val(sumaObreraTotal);
                            $("#subTotalHidden").val(subTotalTotal);

                            generarProvision(diasImssTotal,diasImssTotal,sdiTotal,incapacidadesTotal,ausentismosTotal,cuotaFijaTotal,excPatronTotal,excObreroTotal,prestDinPatronTotal,prestDinObreroTotal,gastosMedicosPatronTotal,gastosMedicosObreroTotal,riesgoTrabajoTotal,invYvPatronTotal,invYvObreroTotal,guarderiasYPenTotal,sumaPatronalTotal,sumaObreraTotal,subTotalTotal);//solo se mandan estos datos para igual los daots que se reciben
                      }
                    }else{
                          var mensaje = response.message;
                          console.log("mal");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                }
        });
}


function generarProvision(listaregistroP,diasImssTotalSuma,sdiTotalSuma,incapacidadesTotalSuma,ausentismosTotalSuma,cuotaFijaTotalSuma,excPatronTotalSuma,excObreroTotalSuma,prestDinPatronTotalSuma,prestDinObreroTotalSuma,gastosMedicosPatronTotalSuma,gastosMedicosObreroTotalSuma,riesgoTrabajoTotalSuma,invYvPatronTotalSuma,invYvObreroTotalSuma,guarderiasYPenTotalSuma,sumaPatronalTotalSuma,sumaObreraTotalSuma,subTotalTotalSuma){

    var registroPatronal= $("#selectRegistroProvision").val();
    var anio=$("#selectAnioProvision").val();
    var mes =$("#selectMesProvision").val();

    if (mes==1) {
            var nBimestre ='1';
    }if (mes==2) {
            var nBimestre ='1';
    }if (mes==3) {
            var nBimestre ='2';
    }if (mes==4) {
            var nBimestre ='2';
    }if (mes==5) {
            var nBimestre ='3';
    }if (mes==6) {
            var nBimestre ='3';
    }if (mes==7) {
            var nBimestre ='4';
    }if (mes==8) {
            var nBimestre ='4';
    }if (mes==9) {
            var nBimestre ='5';
    }if (mes==10) {
            var nBimestre ='5';
    }if (mes==11) {
            var nBimestre ='6';
    }if (mes==12) {
            var nBimestre ='6';
    }

    var diasImss= $("#diasImssHidden").val();
    var sdi = $("#sdiHidden").val();
    var incapacidades = $("#incapacidadesHidden").val();
    var ausentismos= $("#ausentismosHidden").val();
    var cuotaFija  = $("#cuotaFijaHidden").val();
    var excPatron  = $("#excPatronHidden").val();
    var excObrero  = $("#excObreroHidden").val();
    var prestDinPatron = $("#prestDinPatronHidden").val();
    var prestDinObrero = $("#prestDinObreroHidden").val();
    var gastosMedicosPatron = $("#gastosMedicosPatronHidden").val();
    var gastosMedicosObrero = $("#gastosMedicosObreroHidden").val();
    var riesgoTrabajo = $("#riesgoTrabajoHidden").val();
    var invYvPatron   = $("#invYvPatronHidden").val();
    var invYvObrero   = $("#invYvObreroHidden").val();
    var guarderiasYPen= $("#guarderiasYPenHidden").val();
    var sumaPatronal= $("#sumaPatronalHidden").val();
    var sumaObrera  = $("#sumaObreraHidden").val();
    var subTotal    = $("#subTotalHidden").val();

    tableCalculoProvision = [];
    waitingDialog.show();
    $.ajax({
        type: "POST",
        url: "ajax_calcularProvisionEBA.php",
        data:{"registro": registroPatronal,"anio": anio, "bimestre": bimestre[nBimestre-1]},
        dataType: "json",
        async:false,
        success: function(response){
        if (response.status == "success") {
            var record = response.datosInfo;
            if(registroPatronal==="TODOS"){

                var diasImssTotalSumaT_Total = 0;
                var sdiTotalSumaT_Total = 0;
                var incapacidadesTotalSumaT_Total = 0;
                var ausentismosTotalSumaT_Total = 0;
                var cuotaFijaTotalSumaT_Total = 0;
                var excPatronTotalSumaT_Total = 0;
                var excObreroTotalSumaT_Total = 0;
                var prestDinPatronTotalSumaT_Total = 0;
                var prestDinObreroTotalSumaT_Total = 0;
                var gastosMedicosPatronTotalSumaT_Total = 0;
                var gastosMedicosObreroTotalSumaT_Total = 0;
                var riesgoTrabajoTotalSumaT_Total = 0;
                var invYvPatronTotalSumaT_Total = 0;
                var invYvObreroTotalSumaT_Total = 0;
                var guarderiasYPenTotalSumaT_Total = 0;
                var sumaPatronalTotalSumaT_Total = 0;
                var sumaObreraTotalSumaT_Total = 0;
                var subTotalTotalSumaT_Total = 0;
                var diasInfonavitTotalEBA_Total = 0;
                var sdiTotalEBA_Total = 0;
                var incapacidadesTotalEBA_Total = 0;
                var ausentismosTotalEBA_Total = 0;
                var retiroTotalEBA_Total = 0;
                var cesantiaPatTotalEBA_Total = 0;
                var cesantiaObrTotalEBA_Total = 0;
                var suma1TotalEBA_Total = 0;
                var aportacionConCreditoTotalEBA_Total = 0;
                var aportacionSinCreditoTotalEBA_Total = 0;
                var amortizacionTotalEBA_Total = 0;
                var suma2TotalEBA_Total = 0;
                var sumaTotalAmbasEbas_Total = 0;
                var netoTotal = 0;
                var largo= listaregistroP.length;
                for(var i = 0; i < largo+1; i++) {
                    if(i != largo){

                        var registroPatronalActual= listaregistroP[i]["idcatalogoRegistrosPatronales"];
                        record[i]["registrosP"]= listaregistroP[i]["idcatalogoRegistrosPatronales"];
                        record[i]["diasInfonavitTotalEBA"] = response.datosProvisionEBA[registroPatronalActual]["diasInfonavitTotal"];
                        record[i]["diasImssTotalSumaT"]= diasImssTotalSuma[i];



                        record[i]["sdiTotalSumaT"]= sdiTotalSuma[i].toFixed(2);
                        record[i]["incapacidadesTotalSumaT"]= incapacidadesTotalSuma[i].toFixed(2);
                        record[i]["ausentismosTotalSumaT"]= ausentismosTotalSuma[i].toFixed(2);
                        record[i]["cuotaFijaTotalSumaT"]= cuotaFijaTotalSuma[i].toFixed(2);
                        record[i]["excPatronTotalSumaT"]= excPatronTotalSuma[i].toFixed(2);
                        record[i]["excObreroTotalSumaT"]= excObreroTotalSuma[i].toFixed(2);
                        record[i]["prestDinPatronTotalSumaT"]= prestDinPatronTotalSuma[i].toFixed(2);
                        record[i]["prestDinObreroTotalSumaT"]= prestDinObreroTotalSuma[i].toFixed(2);
                        record[i]["gastosMedicosPatronTotalSumaT"]= gastosMedicosPatronTotalSuma[i].toFixed(2);
                        record[i]["gastosMedicosObreroTotalSumaT"]= gastosMedicosObreroTotalSuma[i].toFixed(2);
                        record[i]["riesgoTrabajoTotalSumaT"]= riesgoTrabajoTotalSuma[i].toFixed(2);
                        record[i]["invYvPatronTotalSumaT"]= invYvPatronTotalSuma[i].toFixed(2);
                        record[i]["invYvObreroTotalSumaT"]= invYvObreroTotalSuma[i].toFixed(2);
                        record[i]["guarderiasYPenTotalSumaT"]= guarderiasYPenTotalSuma[i].toFixed(2);
                        record[i]["sumaPatronalTotalSumaT"]= sumaPatronalTotalSuma[i].toFixed(2);
                        record[i]["sumaObreraTotalSumaT"]= sumaObreraTotalSuma[i].toFixed(2);
                        record[i]["subTotalTotalSumaT"]= subTotalTotalSuma[i].toFixed(2);
                        //datos de eba
                        record[i]["sdiTotalEBA"] = response.datosProvisionEBA[registroPatronalActual]["sdiTotal"].toFixed(2);                    
                        record[i]["incapacidadesTotalEBA"] = response.datosProvisionEBA[registroPatronalActual]["incapacidadesTotal"].toFixed(2);
                        record[i]["ausentismosTotalEBA"] = response.datosProvisionEBA[registroPatronalActual]["ausentismosTotal"].toFixed(2);
                        record[i]["retiroTotalEBA"] = response.datosProvisionEBA[registroPatronalActual]["retiroTotal"].toFixed(2);                    
                        record[i]["cesantiaPatTotalEBA"] = response.datosProvisionEBA[registroPatronalActual]["cesantiaPatTotal"].toFixed(2);                    
                        record[i]["cesantiaObrTotalEBA"] = response.datosProvisionEBA[registroPatronalActual]["cesantiaObrTotal"].toFixed(2);                    
                        record[i]["aportacionConCreditoTotalEBA"] = response.datosProvisionEBA[registroPatronalActual]["aportacionConCreditoTotal"].toFixed(2);
                        record[i]["aportacionSinCreditoTotalEBA"] = response.datosProvisionEBA[registroPatronalActual]["aportacionSinCreditoTotal"].toFixed(2);
                        record[i]["suma1TotalEBA"] = response.datosProvisionEBA[registroPatronalActual]["suma1Total"].toFixed(2);
                        record[i]["suma2TotalEBA"] = response.datosProvisionEBA[registroPatronalActual]["suma2Total"].toFixed(2);
                        record[i]["amortizacionTotalEBA"] = response.datosProvisionEBA[registroPatronalActual]["amortizacionTotal"].toFixed(2);
                        record[i]["sumaTotalAmbasEbas"] = response.datosProvisionEBA[registroPatronalActual]["sumaTotalAmbasEbas"].toFixed(2);
                        record[i]["neto"] = (response.datosProvisionEBA[registroPatronalActual]["sumaTotalAmbasEbas"] + subTotalTotalSuma[i]).toFixed(2);

                        record[i]["sdiTotalSumaT111"]= sdiTotalSuma[i];
                        record[i]["incapacidadesTotalSumaT111"]= incapacidadesTotalSuma[i];
                        record[i]["ausentismosTotalSumaT111"]= ausentismosTotalSuma[i];
                        record[i]["cuotaFijaTotalSumaT111"]= cuotaFijaTotalSuma[i];
                        record[i]["excPatronTotalSumaT111"]= excPatronTotalSuma[i];
                        record[i]["excObreroTotalSumaT111"]= excObreroTotalSuma[i];
                        record[i]["prestDinPatronTotalSumaT111"]= prestDinPatronTotalSuma[i];
                        record[i]["prestDinObreroTotalSumaT111"]= prestDinObreroTotalSuma[i];
                        record[i]["gastosMedicosPatronTotalSumaT111"]= gastosMedicosPatronTotalSuma[i];
                        record[i]["gastosMedicosObreroTotalSumaT111"]= gastosMedicosObreroTotalSuma[i];
                        record[i]["riesgoTrabajoTotalSumaT111"]= riesgoTrabajoTotalSuma[i];
                        record[i]["invYvPatronTotalSumaT111"]= invYvPatronTotalSuma[i];
                        record[i]["invYvObreroTotalSumaT111"]= invYvObreroTotalSuma[i];
                        record[i]["guarderiasYPenTotalSumaT111"]= guarderiasYPenTotalSuma[i];
                        record[i]["sumaPatronalTotalSumaT111"]= sumaPatronalTotalSuma[i];
                        record[i]["sumaObreraTotalSumaT111"]= sumaObreraTotalSuma[i];
                        record[i]["subTotalTotalSumaT111"]= subTotalTotalSuma[i];
                        //datos de eba
                        record[i]["sdiTotalEBA111"] = response.datosProvisionEBA[registroPatronalActual]["sdiTotal"];                    
                        record[i]["incapacidadesTotalEBA111"] = response.datosProvisionEBA[registroPatronalActual]["incapacidadesTotal"];
                        record[i]["ausentismosTotalEBA111"] = response.datosProvisionEBA[registroPatronalActual]["ausentismosTotal"];
                        record[i]["retiroTotalEBA111"] = response.datosProvisionEBA[registroPatronalActual]["retiroTotal"];                    
                        record[i]["cesantiaPatTotalEBA111"] = response.datosProvisionEBA[registroPatronalActual]["cesantiaPatTotal"];                    
                        record[i]["cesantiaObrTotalEBA111"] = response.datosProvisionEBA[registroPatronalActual]["cesantiaObrTotal"];                    
                        record[i]["suma1TotalEBA111"] = response.datosProvisionEBA[registroPatronalActual]["suma1Total"];
                        record[i]["aportacionConCreditoTotalEBA111"] = response.datosProvisionEBA[registroPatronalActual]["aportacionConCreditoTotal"];
                        record[i]["aportacionSinCreditoTotalEBA111"] = response.datosProvisionEBA[registroPatronalActual]["aportacionSinCreditoTotal"];
                        record[i]["amortizacionTotalEBA111"] = response.datosProvisionEBA[registroPatronalActual]["amortizacionTotal"];
                        record[i]["suma2TotalEBA111"] = response.datosProvisionEBA[registroPatronalActual]["suma2Total"];
                        record[i]["sumaTotalAmbasEbas111"] = response.datosProvisionEBA[registroPatronalActual]["sumaTotalAmbasEbas"];
                        record[i]["neto11"] = response.datosProvisionEBA[registroPatronalActual]["sumaTotalAmbasEbas"];
                        record[i]["neto111"] = subTotalTotalSuma[i];
                        
                        //Totales      
                        diasInfonavitTotalEBA_Total += record[i]["diasInfonavitTotalEBA"];
                        diasImssTotalSumaT_Total += record[i]["diasImssTotalSumaT"];

                        sdiTotalSumaT_Total += record[i]["sdiTotalSumaT111"];
                        incapacidadesTotalSumaT_Total += record[i]["incapacidadesTotalSumaT111"];
                        ausentismosTotalSumaT_Total += record[i]["ausentismosTotalSumaT111"];
                        cuotaFijaTotalSumaT_Total += record[i]["cuotaFijaTotalSumaT111"];
                        excPatronTotalSumaT_Total += record[i]["excPatronTotalSumaT111"];
                        excObreroTotalSumaT_Total += record[i]["excObreroTotalSumaT111"];
                        prestDinPatronTotalSumaT_Total += record[i]["prestDinPatronTotalSumaT111"];
                        prestDinObreroTotalSumaT_Total += record[i]["prestDinObreroTotalSumaT111"];
                        gastosMedicosPatronTotalSumaT_Total += record[i]["gastosMedicosPatronTotalSumaT111"];
                        gastosMedicosObreroTotalSumaT_Total += record[i]["gastosMedicosObreroTotalSumaT111"];
                        riesgoTrabajoTotalSumaT_Total += record[i]["riesgoTrabajoTotalSumaT111"];
                        invYvPatronTotalSumaT_Total += record[i]["invYvPatronTotalSumaT111"];
                        invYvObreroTotalSumaT_Total += record[i]["invYvObreroTotalSumaT111"];
                        guarderiasYPenTotalSumaT_Total += record[i]["guarderiasYPenTotalSumaT111"];
                        sumaPatronalTotalSumaT_Total += record[i]["sumaPatronalTotalSumaT111"];
                        sumaObreraTotalSumaT_Total += record[i]["sumaObreraTotalSumaT111"];
                        subTotalTotalSumaT_Total += record[i]["subTotalTotalSumaT111"];
                        sdiTotalEBA_Total += record[i]["sdiTotalEBA111"];
                        incapacidadesTotalEBA_Total += record[i]["incapacidadesTotalEBA111"];
                        ausentismosTotalEBA_Total += record[i]["ausentismosTotalEBA111"];
                        retiroTotalEBA_Total += record[i]["retiroTotalEBA111"];
                        cesantiaPatTotalEBA_Total += record[i]["cesantiaPatTotalEBA111"];
                        cesantiaObrTotalEBA_Total += record[i]["cesantiaObrTotalEBA111"];
                        suma1TotalEBA_Total += record[i]["suma1TotalEBA111"];
                        aportacionConCreditoTotalEBA_Total += record[i]["aportacionConCreditoTotalEBA111"];
                        aportacionSinCreditoTotalEBA_Total += record[i]["aportacionSinCreditoTotalEBA111"];
                        amortizacionTotalEBA_Total += record[i]["amortizacionTotalEBA111"];
                        suma2TotalEBA_Total += record[i]["suma2TotalEBA111"];
                        sumaTotalAmbasEbas_Total += record[i]["sumaTotalAmbasEbas111"];
                        netoTotal +=  record[i]["neto11"];
                        netoTotal +=  record[i]["neto111"];
                         ////////////////////////////// 
                    }else{
                        record[i]["registrosP"]= "´TOTALES";
                        record[i]["diasImssTotalSumaT"] = diasImssTotalSumaT_Total;
                        record[i]["diasInfonavitTotalEBA"] = diasInfonavitTotalEBA_Total;
                        record[i]["sdiTotalSumaT"] = sdiTotalSumaT_Total.toFixed(2);
                        record[i]["incapacidadesTotalSumaT"] = incapacidadesTotalSumaT_Total.toFixed(2);
                        record[i]["ausentismosTotalSumaT"] = ausentismosTotalSumaT_Total.toFixed(2);
                        record[i]["cuotaFijaTotalSumaT"] = cuotaFijaTotalSumaT_Total.toFixed(2);
                        record[i]["excPatronTotalSumaT"] = excPatronTotalSumaT_Total.toFixed(2);
                        record[i]["excObreroTotalSumaT"] = excObreroTotalSumaT_Total.toFixed(2);
                        record[i]["prestDinPatronTotalSumaT"] = prestDinPatronTotalSumaT_Total.toFixed(2);
                        record[i]["prestDinObreroTotalSumaT"] = prestDinObreroTotalSumaT_Total.toFixed(2);
                        record[i]["gastosMedicosPatronTotalSumaT"] = gastosMedicosPatronTotalSumaT_Total.toFixed(2);
                        record[i]["gastosMedicosObreroTotalSumaT"] = gastosMedicosObreroTotalSumaT_Total.toFixed(2);
                        record[i]["riesgoTrabajoTotalSumaT"] = riesgoTrabajoTotalSumaT_Total.toFixed(2);
                        record[i]["invYvPatronTotalSumaT"] = invYvPatronTotalSumaT_Total.toFixed(2);
                        record[i]["invYvObreroTotalSumaT"] = invYvObreroTotalSumaT_Total.toFixed(2);
                        record[i]["guarderiasYPenTotalSumaT"] = guarderiasYPenTotalSumaT_Total.toFixed(2);
                        record[i]["sumaPatronalTotalSumaT"] = sumaPatronalTotalSumaT_Total.toFixed(2);
                        record[i]["sumaObreraTotalSumaT"] = sumaObreraTotalSumaT_Total.toFixed(2);
                        record[i]["subTotalTotalSumaT"] = subTotalTotalSumaT_Total.toFixed(2);
                        record[i]["sdiTotalEBA"] = sdiTotalEBA_Total.toFixed(2);
                        record[i]["incapacidadesTotalEBA"] = incapacidadesTotalEBA_Total.toFixed(2);
                        record[i]["ausentismosTotalEBA"] = ausentismosTotalEBA_Total.toFixed(2);
                        record[i]["retiroTotalEBA"] = retiroTotalEBA_Total.toFixed(2);
                        record[i]["cesantiaPatTotalEBA"] = cesantiaPatTotalEBA_Total.toFixed(2);
                        record[i]["cesantiaObrTotalEBA"] = cesantiaObrTotalEBA_Total.toFixed(2);
                        record[i]["suma1TotalEBA"] = suma1TotalEBA_Total.toFixed(2);
                        record[i]["aportacionConCreditoTotalEBA"] = aportacionConCreditoTotalEBA_Total.toFixed(2);
                        record[i]["aportacionSinCreditoTotalEBA"] = aportacionSinCreditoTotalEBA_Total.toFixed(2);
                        record[i]["amortizacionTotalEBA"] = amortizacionTotalEBA_Total.toFixed(2);
                        record[i]["suma2TotalEBA"] = suma2TotalEBA_Total.toFixed(2);
                        record[i]["sumaTotalAmbasEbas"] = sumaTotalAmbasEbas_Total.toFixed(2);
                        record[i]["neto"] = netoTotal.toFixed(2);
                    }
                    tableCalculoProvision.push(record[i]);
                    waitingDialog.hide();
                }
                loadDataInTableProvisionTODOS(tableCalculoProvision);
            }else{
                record["registrosP"]= registroPatronal;
                record["diasImssTotalSumaT"]= diasImss;
                record["sdiTotalSumaT"] = sdi;
                record["incapacidadesTotalSumaT"] = incapacidades;
                record["ausentismosTotalSumaT"] = ausentismos;
                record["cuotaFijaTotalSumaT"]  = cuotaFija;
                record["excPatronTotalSumaT"]  = excPatron;
                record["excObreroTotalSumaT"]  = excObrero;
                record["prestDinPatronTotalSumaT"]= prestDinPatron;
                record["prestDinObreroTotalSumaT"]= prestDinObrero;
                record["gastosMedicosPatronTotalSumaT"]= gastosMedicosPatron;
                record["gastosMedicosObreroTotalSumaT"]= gastosMedicosObrero;
                record["riesgoTrabajoTotalSumaT"]= riesgoTrabajo;
                record["invYvPatronTotalSumaT"]= invYvPatron;
                record["invYvObreroTotalSumaT"]= invYvObrero;
                record["guarderiasYPenTotalSumaT"]= guarderiasYPen;
                record["sumaPatronalTotalSumaT"]= sumaPatronal;
                record["sumaObreraTotalSumaT"]= sumaObrera;
                record["subTotalTotalSumaT"]= subTotal;
                record["diasInfonavitTotalEBA"]= record["diasInfonavitTotalEBA"].toFixed(2);
                record["sdiTotalEBA"]= record["sdiTotalEBA"].toFixed(2);
                record["incapacidadesTotalEBA"]= record["incapacidadesTotalEBA"].toFixed(2);
                record["ausentismosTotalEBA"]= record["ausentismosTotalEBA"].toFixed(2);
                record["retiroTotalEBA"]= record["retiroTotalEBA"].toFixed(2);
                record["cesantiaPatTotalEBA"]= record["cesantiaPatTotalEBA"].toFixed(2);
                record["cesantiaObrTotalEBA"]= record["cesantiaObrTotalEBA"].toFixed(2);
                record["suma1TotalEBA"]= record["suma1TotalEBA"].toFixed(2);
                record["aportacionConCreditoTotalEBA"]= record["aportacionConCreditoTotalEBA"].toFixed(2);
                record["aportacionSinCreditoTotalEBA"]= record["aportacionSinCreditoTotalEBA"].toFixed(2);
                record["amortizacionTotalEBA"]= record["amortizacionTotalEBA"].toFixed(2);
                record["suma2TotalEBA"]= record["suma2TotalEBA"].toFixed(2);
                var neto = parseFloat(record["sumaTotalAmbasEbas"]) + parseFloat(subTotal);
                record["neto"]= neto.toFixed(2);

                tableCalculoProvision.push(record);
                loadDataInTableProvisionTODOS(tableCalculoProvision);
                waitingDialog.hide();
            }
        }else{
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

function loadDataInTableProvisionTODOS(data) {
    if(tableProvision != null) {
       tableProvision.destroy();
    }
    tableProvision = $('#tableProvision').DataTable({
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
                     "paginate":{
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
                 "data": "registrosP"
             },{
                 "data": "diasImssTotalSumaT"
             },{
                 "data": "sdiTotalSumaT"
             },{
                 "data": "incapacidadesTotalSumaT"
             },{
                 "data": "ausentismosTotalSumaT"
             },{
                 "data": "cuotaFijaTotalSumaT"
             },{
                 "data": "excPatronTotalSumaT"
             },{
                 "data": "excObreroTotalSumaT"
             },{
                 "data": "prestDinPatronTotalSumaT"
             },{
                 "data": "prestDinObreroTotalSumaT"
             },{
                 "data": "gastosMedicosPatronTotalSumaT"
             },{
                 "data": "gastosMedicosObreroTotalSumaT"
             },{
                 "data": "riesgoTrabajoTotalSumaT"
             },{
                 "data": "invYvPatronTotalSumaT"
             },{
                 "data": "invYvObreroTotalSumaT"
             },{
                 "data": "guarderiasYPenTotalSumaT"
             },{
                 "data": "sumaPatronalTotalSumaT"
             },{
                 "data": "sumaObreraTotalSumaT"
             },{
                 "data": "subTotalTotalSumaT"
             },{
                 "data": "diasInfonavitTotalEBA"//aqui va eba
             },{
                 "data": "sdiTotalEBA"//sba
             },{
                 "data": "incapacidadesTotalEBA"//eba
             },{
                 "data": "ausentismosTotalEBA"//eba
             },{
                 "data": "retiroTotalEBA"
             },{
                 "data": "cesantiaPatTotalEBA"
             },{
                 "data": "cesantiaObrTotalEBA"
             },{
                 "data": "suma1TotalEBA"
             },{
                 "data": "aportacionConCreditoTotalEBA"
             },{
                 "data": "aportacionSinCreditoTotalEBA"
             },{
                 "data": "amortizacionTotalEBA"
             },{
                 "data": "suma2TotalEBA"
             },{
                 "data": "sumaTotalAmbasEbas"
             },{
                 "data": "neto"
             },],
              rowCallback:function(row,data)
            {
             $($(row).find("td")[17]).css("background-color","#7DDEF4");
             $($(row).find("td")[16]).css("background-color","#7DDEF4");
            },
         processing: true,
         dom: 'Bfrtip',
         buttons: [
            {
             text: 'Descarga Excel',
             extend: 'excelHtml5',
             filename: 'Zonagif_Provision',
             exportOptions:{
                            columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32],
                            search: 'applied',
                            order: 'applied'
                           },
             customize:function(xlsx) {
                       var sheet = xlsx.xl.worksheets['sheet1.xml'];
                       $('row c[r^="AA"]', sheet).each( function () {
                         $(this).attr( 's', '10' );
                       });
             }
           }
        ]
     });
}

function llenarMesesProvision(){
   // alert("entre");
    var sMeses="<option value=''>MES</option>";
    var mesActual= <?php echo $mesActual;?>;
    var anioSel=$("#selectAnioProvision").val(); 
    if(anioSel!=""){
        if(anioSel!= <?php echo $anioActual;?>){            
            for(var i=0;i<meses.length;i++){
                sMeses+="<option value='"+(i+1)+"'>"+meses[i]+"</option>";
            }
        }else{            
            for(var i=0;i<mesActual;i++){
                sMeses+="<option value='"+(i+1)+"'>"+meses[i]+"</option>";
            }
        }
        $("#selectMesProvision").html(sMeses);
    }else{
         $("#selectMesProvision").html(sMeses);
    }
 }


</script>