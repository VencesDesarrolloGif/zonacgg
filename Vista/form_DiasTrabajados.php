<?php
    require_once ("../Negocio/Negocio.class.php");
    $negocio = new Negocio ();
?>
<form class="form-horizontal" id="form_DiasTrabajados" name="form_DiasTrabajados">
    <center>
        <h3>Días Separacion Laboral</h3><br>
        <img title='Obtener Los Dias De Sepeación Laboral' src='img/ActualizarEjecutar.jpg' class='cursorImg' id='btnguardar' onclick="consultaDiasTrabajados();" width="50px"></center>
    </center><br>
    <div id="divDiasTrabajados" align="center"></div>  
</form>
<script type="text/javascript"> //empieza lo de js

// $(consultaDiasTrabajados());  

 function consultaDiasTrabajados() { 
    waitingDialog.show();
    $.ajax({
        type: "POST",
        url: "ajax_consultaDiasTrabajados.php",
        dataType: "json", 
        async: false,
        success: function(response) {
            if (response.status == "success") {
                var datosDiasTrabajados = response.datos;
                $('#divDiasTrabajados').html(""); 
                var listaDiasTrabajados="<form id='checkEmpleadosDiasTrabajados'>";
                listaDiasTrabajados="<table class='table table-hover' id='tablaDiasTrabajados'><thead><th>Número Empleado</th><th>Nombre Empleado</th><th>Fecha Baja</th><th>Puesto Empleado</th><th>Entidad </th><th>Dias Trabajados</th><th>Seleccionados</th><th>Vacaciones Futuras</th></thead><tbody>";
                if (datosDiasTrabajados.length > 0)
                {
                    listaDiasTrabajados+="<br/>";
                    listaDiasTrabajados+="<a href='javascript:seleccionar_DiasTrabajados()'>Marcar todos</a>";
                    listaDiasTrabajados+="<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
                    listaDiasTrabajados+="<a href='javascript:deseleccionar_DiasTrabajados()'>Marcar ninguno</a>";
                    listaDiasTrabajados+="<br/>";
                    for ( var i = 0; i < datosDiasTrabajados.length; i++ )
                    {
                        var DiasCargados = response.datos[i]["DiasCargados"];
                        if(DiasCargados=="0"){

                            var  numempleado= datosDiasTrabajados[i].numempleado;
                            var  entidadFederativaId= datosDiasTrabajados[i].entidadFederativaId;
                            var  empleadoConsecutivoId= datosDiasTrabajados[i].empleadoConsecutivoId;
                            var  empleadoCategoriaId= datosDiasTrabajados[i].empleadoCategoriaId;
                            var  nombreempleado= datosDiasTrabajados[i].nombreempleado;
                            var  descripcionPuesto= datosDiasTrabajados[i].descripcionPuesto;
                            var  nombreEntidadFederativa= datosDiasTrabajados[i].nombreEntidadFederativa;
                            var  fechaImss= datosDiasTrabajados[i].fechaImss;
                            var  fechaBajaImss= datosDiasTrabajados[i].fechaBajaImss;
                            var  fechaAlta= datosDiasTrabajados[i].fechaAlta;
                            var  fechaBaja= datosDiasTrabajados[i].fechaBaja;
                            var  prestamoFiniquito= datosDiasTrabajados[i].prestamoFiniquito;
                            var  infonavitFiniquito= datosDiasTrabajados[i].infonavitFiniquito;
                            var  fonacotFiniquito= datosDiasTrabajados[i].fonacotFiniquito;
                            var  pensionFiniquito= datosDiasTrabajados[i].pensionFiniquito;
                            var  cuotaDiariaEmpleado= datosDiasTrabajados[i].cuotaDiariaEmpleado;
                            var  diasTrabajados= datosDiasTrabajados[i].diasTrabajados;
                            var  separacion= datosDiasTrabajados[i].separacion;
                            var  piramidar= datosDiasTrabajados[i].piramidar;
                            var  antiguedadTotal= datosDiasTrabajados[i].antiguedadTotal;
                            var  diasParaPPVacaciones= datosDiasTrabajados[i].diasParaPPVacaciones;
                            var  diasDeVacaciones= datosDiasTrabajados[i].diasDeVacaciones;
                            var  factorPropVacaciones= datosDiasTrabajados[i].factorPropVacaciones;
                            var  calculoDiasAguinaldo= datosDiasTrabajados[i].calculoDiasAguinaldo;
                            var  factorDiasAguinaldo= datosDiasTrabajados[i].factorDiasAguinaldo;
                            var  propVacaciones= datosDiasTrabajados[i].propVacaciones;
                            var  primaVacacionalNeta= datosDiasTrabajados[i].primaVacacionalNeta;
                            var  proporcionNetaAguinaldo= datosDiasTrabajados[i].proporcionNetaAguinaldo;
                            var  diasDePago= datosDiasTrabajados[i].diasDePago;
                            var  aumentoGratificacion= datosDiasTrabajados[i].aumentoGratificacion;
                            var  calculoBruto= datosDiasTrabajados[i].calculoBruto;
                            var  pagoNeto= datosDiasTrabajados[i].pagoNeto;
                            var  propVacacionesSA= datosDiasTrabajados[i].propVacacionesSA;
                            var  primaVacacionalSA= datosDiasTrabajados[i].primaVacacionalSA;
                            var  propAginaldoSA= datosDiasTrabajados[i].propAginaldoSA;
                            var  diasPagoSA= datosDiasTrabajados[i].diasPagoSA;
                            var  pagoNetoSA= datosDiasTrabajados[i].pagoNetoSA;
                            var  diferenciaGratificacionSA= datosDiasTrabajados[i].diferenciaGratificacionSA;
                            var  ingresoAcumulableSA= datosDiasTrabajados[i].ingresoAcumulableSA;
                            var  limiteInferiorisr= datosDiasTrabajados[i].limiteInferiorisr;
                            var  excedenteLimiteSA= datosDiasTrabajados[i].excedenteLimiteSA;
                            var  tasaAplicable= datosDiasTrabajados[i].tasaAplicable;
                            var  resultado= datosDiasTrabajados[i].resultado;
                            var  cuotaFija= datosDiasTrabajados[i].cuotaFija; 
                            var  isr= datosDiasTrabajados[i].isr;
                            var  netoAlPago= datosDiasTrabajados[i].netoAlPago;
                            var  VacacionesPendientes= datosDiasTrabajados[i].VacacionesPendientes;
                            var  PrimaVacacionalPendiente= datosDiasTrabajados[i].PrimaVacacionalPendiente;
                            var  PpPrimaVacacionalPendiente= datosDiasTrabajados[i].PpPrimaVacacionalPendiente;
                            var  salarioDiario= datosDiasTrabajados[i].salarioDiario;
                            var  vacacionesAceptadasFuturo= datosDiasTrabajados[i].vacAceptadasFuturo;//vacaciones que acepto el supervisor, pero eran posteriores a la baja del emp.
                            var  InputDias="inpDiasTrbajados";
                           
                            listaDiasTrabajados += "<tr><td>"+numempleado+"</td><td>"+nombreempleado+"</td><td>"+fechaBajaImss+"</td><td>"+descripcionPuesto+"</td><td>"+nombreEntidadFederativa+"</td>";

                            listaDiasTrabajados += "<td><input type='input-small' id="+InputDias+'_'+numempleado+"  name="+InputDias+'_'+numempleado+" value='"+diasTrabajados+"'></td>";

                            listaDiasTrabajados += "<td><input type='checkbox' style='width: 25px; height: 25px' id="+numempleado+"  name="+numempleado+" value='"+numempleado+"' ";
                            listaDiasTrabajados += " numempleado='"+numempleado+"' diasTrabajados='"+diasTrabajados+"' cuotaDiariaEmpleado='"+cuotaDiariaEmpleado+"'";
                            listaDiasTrabajados += " calculoBruto='"+calculoBruto+"' pagoNetoSA='"+pagoNetoSA+"' ingresoAcumulableSA='"+ingresoAcumulableSA+"' salarioDiario='"+salarioDiario+"' fechaBaja='"+fechaBaja+"'></td>";
                            listaDiasTrabajados += "<td>"+vacacionesAceptadasFuturo+"</td><tr>";
                        }
                    }
                    listaDiasTrabajados += "</tbody></table>";
                    listaDiasTrabajados+="<button id='btnGardarDiasTrabajados' type='button' class='btn btn-secondary' onclick='aplicarDiasTrabajados();'><span class='glyphicon glyphicon-ok'></span>Cargar Dias Trabajados</button></form>";
                    $('#divDiasTrabajados').html(listaDiasTrabajados); 
                    waitingDialog.hide();    
                }else{
                $('#divDiasTrabajados').html("<div><h1>No se encontraron empleados con dia trabajados</h1></div>"); 
                waitingDialog.hide();
                } 
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
            waitingDialog.hide();
        }
    });
 }


 function seleccionar_DiasTrabajados(){ 
   for (i=0;i<document.form_DiasTrabajados.elements.length;i++) 
      if(document.form_DiasTrabajados.elements[i].type == "checkbox")  
         document.form_DiasTrabajados.elements[i].checked=1 
} 
  function deseleccionar_DiasTrabajados(){ 
   for (i=0;i<document.form_DiasTrabajados.elements.length;i++) 
      if(document.form_DiasTrabajados.elements[i].type == "checkbox")  
         document.form_DiasTrabajados.elements[i].checked=0 
}

function aplicarDiasTrabajados(){

    var diasTrabajadosSeleccionados = $( "input[type=checkbox]:checked");
    var DiasTexto ="inpDiasTrbajados_";
    if(diasTrabajadosSeleccionados.length<"1" || diasTrabajadosSeleccionados.length=="1"){
        alert("No Se Ha Seleccionado Ningun Empleado Favor De Marcar Los Empleados A Aplicar");
    }else{
        for (var i = 0; i < diasTrabajadosSeleccionados.length; i++)
        {
            waitingDialog.show();
            if (diasTrabajadosSeleccionados[i].checked == true && diasTrabajadosSeleccionados[i].value.match (/[0-9]{2}\-[0-9]{5}\-[0-9]{2}/g) || diasTrabajadosSeleccionados[i].checked == true && diasTrabajadosSeleccionados[i].value.match (/[0-9]{2}\-[0-9]{4}\-[0-9]{2}/g))
            {
                var numempleado = $("#"+diasTrabajadosSeleccionados[i].value).attr("numempleado");
                var diastrabajados = $("#"+diasTrabajadosSeleccionados[i].value).attr("diasTrabajados");
                var cuota = $("#"+diasTrabajadosSeleccionados[i].value).attr("cuotaDiariaEmpleado");
                var salarioDiario = $("#"+diasTrabajadosSeleccionados[i].value).attr("salarioDiario");
                var calculoBruto = $("#"+diasTrabajadosSeleccionados[i].value).attr("calculoBruto");
                var pagoNetoSA = $("#"+diasTrabajadosSeleccionados[i].value).attr("pagoNetoSA");
                var ingresoAcumulableSA = $("#"+diasTrabajadosSeleccionados[i].value).attr("ingresoAcumulableSA");
                var fechaBaja = $("#"+diasTrabajadosSeleccionados[i].value).attr("fechaBaja");

                var idinput = DiasTexto+numempleado;
                var DiasTrabajados1 = $("#"+idinput).val();
                var empleadosplit = numempleado.split("-");
                var entidadempleado = empleadosplit[0];
                var consecutivoemp = empleadosplit[1];
                var categoriaemp = empleadosplit[2];
                var operacion = (DiasTrabajados1*2)/2;

                if(entidadempleado=="1" || entidadempleado=="2" ||entidadempleado=="3" ||entidadempleado=="4" ||entidadempleado=="5" ||entidadempleado=="6" ||entidadempleado=="7" ||entidadempleado=="8" ||entidadempleado=="9"){
                    entidadempleado= "0"+entidadempleado;
                }
                if(categoriaemp=="1" || categoriaemp=="2" ||categoriaemp=="3" ||categoriaemp=="4" ||categoriaemp=="5" ||categoriaemp=="6" ||categoriaemp=="7" ||categoriaemp=="8" ||categoriaemp=="9"){
                    categoriaemp= "0"+categoriaemp;
                }

                if(!/^([0-9])*$/.test(DiasTrabajados1)){
                    waitingDialog.hide();
                    alert(" Los Dias Trabajados del Empleado "+numempleado+" No Deben Llevar Signos Solo Números Favor De Corregir");
                    i=diasTrabajadosSeleccionados.length;
                }else if(DiasTrabajados1==""){
                    waitingDialog.hide();
                    alert(" Los Dias Trabajados del Empleado "+numempleado+" No Puede Ser Vacio Favor De Ingresar Un Número");
                    i=diasTrabajadosSeleccionados.length;
                }else if( operacion>"15"){
                    waitingDialog.hide();
                    alert(" Los Dias Trabajados del Empleado "+numempleado+" No Puede ser mayor De Una Quincena (15) Favor De Corregir");
                    i=diasTrabajadosSeleccionados.length;
                }else{
                    $.ajax({
                        type: "POST",
                        url: "ajax_actualizarDiasTrabajados.php",
                        data:{"entidadempleado":entidadempleado,"consecutivoemp":consecutivoemp,"categoriaemp":categoriaemp,"DiasTrabajados1":DiasTrabajados1,"fechaBaja":fechaBaja},
                        dataType: "json",
                        async: false,
                        success: function(response) {
                            if (response.status == "success") {
                                if(DiasTrabajados1!=diastrabajados){
                                    //RecalcularFiniquitoDiasIngresados(entidadempleado,consecutivoemp,categoriaemp,DiasTrabajados1,cuota,salarioDiario,calculoBruto,pagoNetoSA,ingresoAcumulableSA,diastrabajados);
                                }
                                              
                            } else {
                                var mensaje = response.message;
                                alert("malllll");
                                waitingDialog.hide();
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert(jqXHR.responseText);
                        }
                    });
                }
            }
        }
        calculoFiniquito(0);
        consultaDiasTrabajados(); 
        waitingDialog.hide();
    }
        
}

 function RecalcularFiniquitoDiasIngresados(entidadempleado,consecutivoemp,categoriaemp,diastrabajados,cuota,salarioDiario,calculoBruto,pagoNetoSA,ingresoAcumulableSA){
    $.ajax({
         type: "POST",
         url: "ajax_editayrecalculafiniquitosDiasTrabajados.php",
         data: {
             "entidadempleado": entidadempleado,
             "consecutivoemp": consecutivoemp,
             "categoriaemp": categoriaemp,
             "cuota": cuota,
             "diastrabajados": diastrabajados,
             "calculoBruto": calculoBruto,
             "pagoNetoSA": pagoNetoSA,
             "ingresoAcumulableSA": ingresoAcumulableSA,
             "salarioDiario": salarioDiario,
         },
         dataType: "json",
         async: false,
         success: function(response) {
             if (response.status == "success") {
                console.log(response);
                alert("Dias Trabajados Registrados Correctamente");
             } else {
                 var mensaje = response.message;
                 alert("mal");
             }
         },
         error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
            alert("Verifique valores de último finiquito editado")
         }
     });
 }
 </script>