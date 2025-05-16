<div id="msgerrorvacantes"> </div>
<h2 align="center" style="color:blue;">VACANTES DE PLANTILLAS</h2>
<div align="center">
    <select id='selecClienteVacante' name='selecClienteVacante' class='input-large' onchange='consultaPlantillasPuntosServiciosByClienteVacantes(1);'></select>
    <button type='button' id='limpiarTabla' name='limpiarTabla' class='btn btn-success' type='button' onclick='LimpiarTablaVacantes();'>Limpiar</button>
    <select id='selecEntidadesVacantes' name='selecEntidadesVacantes' class='input-large' onchange='consultaPlantillasPuntosServiciosByClienteVacantes(2);'></select>
    <input id="banderaVacantes" name="banderaVacantes" type="hidden" class="input-large">
</div>
<br>
<div align="center">
<button type='button' id='GenerarPDF' name='GenerarPDF' class='btn btn-primary' type='button'>GenerarPdf</button>
</div>
<br>
<div id="divGeneralVacantes" align="center"></div>

<script src="js/jspdf.min.js"></script>
<script src="js/jspdf.plugin.autotable.min.js"></script>
<script type="text/javascript">

var clientes = [];
var entidades = [];
var lista1 = [];
var lista2 = [];
$(inicioConsultaVacantesPlantillas());  

function inicioConsultaVacantesPlantillas(){
    obtenerListaClientesVacantes(); 
    obtenerEntidadesVacantes(); 
}


    function obtenerListaClientesVacantes()
    {
        $.ajax({
            type: "POST",
            url: "ajax_obtenerListaClientes.php",
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                    var cliente = response.listaClientes;
                    clienteOptions = "<option value='0'>CLIENTES</option>";
                    for (var i = 0; i < cliente.length; i++)
                    {
                        clienteOptions += "<option value='" + cliente[i].idCliente + "'>" + cliente[i].razonSocial + "</option>";
                    }
                    $("#selecClienteVacante").html (clienteOptions);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
        });
    }

    function obtenerEntidadesVacantes()
    {
        $.ajax({
            type: "POST",
            url: "ajax_ObtenerEntidadesFirmaElectronica.php",
            dataType: "json", 
            success: function(response) {
                if (response.status == "success")
                {
                    var entidadesVacantes = response.datos;
                    EntidadesOption = "<option value='0'>ENTIDADES</option>";
                    for (var i = 0; i < entidadesVacantes.length; i++)
                    {
                        EntidadesOption += "<option value='" + entidadesVacantes[i].idEntidadFederativa + "'>" + entidadesVacantes[i].nombreEntidadFederativa + "</option>";
                    }
                    $("#selecEntidadesVacantes").html (EntidadesOption);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
        });
    }

    function LimpiarTablaVacantes()
    {
        $("#divGeneralVacantes").html("");
        $("#selecClienteVacante").val(0);
        $("#selecEntidadesVacantes").val(0);

        clientes = [];
        entidades = [];
        lista1 = [];
        lista2 = [];
    }
    $("#GenerarPDF").click(function(){
        var hoy = new Date();
        var fecha = hoy.getDate() + '/' + ( hoy.getMonth() + 1 ) + '/' + hoy.getFullYear();
        var hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();
        var fechaYHora = fecha + ' ' + hora;
        var pdf = new jsPDF();
        pdf.text(20,20,"TABLA DE VACANTES PARA PLANTILLAS      "+fechaYHora);
        var columns = ["CLIENTE","ID PUNTO", "PUNTO SERVICIO", "CENTRO COSTO","ENTIDAD","VACANTES"];
        /*var data = [
            [1, "Carlos", "009@gmail.com", "Mexico"],
            [2, "Miguel",  "888@hotmail.com", "Brasil"],
            [3, "Jorge", "jorge@yandex.com", "Ecuador"],
            [3, "mario", "mario@yandex.com", "Colombia"],
        ];*/
        pdf.autoTable(columns,lista1,
          { margin:{ top: 25  }}
        );
        pdf.save('TablaVacantes.pdf');
    
    });

    function consultaPlantillasPuntosServiciosByClienteVacantes(peticion)
    {
        lista2 = [];
        lista1 = [];
        var ClienteNombre = $("#selecClienteVacante option:selected" ).text();
        var idEntirades =$("#selecEntidadesVacantes").val();
        var idCliente=$("#selecClienteVacante").val();
        var banderaCLienteRepetido = "0";
        var ValidacionueNoTiene = "0";
        var largoCliente = clientes.length;
        var largoEntidades = entidades.length;
        for ( var i = 0; i < largoCliente; i++ )
        { 
            if(clientes[i]==idCliente){
                banderaCLienteRepetido="1";
            }  
        }
        for ( var i = 0; i < largoEntidades; i++ )
        { 
            if(entidades[i]==idEntirades){
                banderaCLienteRepetido="3";
            }  
        }
        if(largoCliente=="0" && largoEntidades!="0"){
            banderaCLienteRepetido="2";
        } 
        if(clientes.length=="0" && entidades.length=="0" && idEntirades!="0"){
            banderaCLienteRepetido="2";
        } 
        if(clientes.length=="0" && entidades.length=="0" && idEntirades=="0"){
            banderaCLienteRepetido="0";
        }       
        if(banderaCLienteRepetido=="1" && peticion=="1"){
            alertMsg1="<div id='msgAlert' class='alert alert-error'><strong><center>El Cliente "+ClienteNombre+" Ya Fue Seleccionado Anteriormente</center></strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#msgerrorvacantes").html(alertMsg1);
            $(document).scrollTop(0);
            $('#msgAlert').delay(3000).fadeOut('slow');
        }else if(banderaCLienteRepetido=="3" && peticion=="2"){
            alertMsg1="<div id='msgAlert' class='alert alert-error'><strong><center>La Entidad "+idEntirades+" Ya Fue Seleccionada Anteriormente</center></strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#msgerrorvacantes").html(alertMsg1);
            $(document).scrollTop(0);
            $('#msgAlert').delay(3000).fadeOut('slow');
        }else if(banderaCLienteRepetido=="2"){
            alertMsg1="<div id='msgAlert' class='alert alert-error'><strong><center> Debe seleccionar un cliente antes de seleccionar una entidad </center></strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#msgerrorvacantes").html(alertMsg1);
            $(document).scrollTop(0);
            $('#msgAlert').delay(3000).fadeOut('slow');
            $("#selecClienteVacante").val(0);
            $("#selecEntidadesVacantes").val(0);
            clientes = [];
        }else if(idCliente=="0" && peticion=="1"){
            alertMsg1="<div id='msgAlert' class='alert alert-error'><strong><center>Debe seleccionar un cliente</center></strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#msgerrorvacantes").html(alertMsg1);
            $(document).scrollTop(0);
            $('#msgAlert').delay(3000).fadeOut('slow');
        }else{
            if(peticion=="1"){
                clientes[largoCliente]=idCliente;
            }else{
                entidades[largoEntidades]=idEntirades;
            }
            if(idEntirades=="0" && peticion=="2"){
                entidades=[];
            }
            //alert(clientes);
            $.ajax({
                type: "POST",
                url: "ajax_consultaPlantillasPuntoServicioByEntidades.php",
                data: {"clientes": clientes,"entidades": entidades},
                dataType: "json",
                success: function(response) {
                    if (response.status == "success")
                    {
                        $("#divGeneralVacantes").html("");
                        var lista = response.lista;
                        $("#banderaVacantes").val(0);
                        if(lista.length!="0"){
                            listaTable="<table class='table tablaRH table-hover table-bordered'>";
                            var idClientePunto2 = "0";
                            var totalDiferencia = 0;
                            for ( var i = 0; i < lista.length; i++ )
                            {   
                                var idPuntoServicio = lista[i].idPuntoServicio;
                                var puntoServicio = lista[i].puntoServicio;
                                var numeroCentroCosto = lista[i].numeroCentroCosto;
                                var idEntidadPunto = lista[i].idEntidadPunto;
                                var nombreEntidadFederativa = lista[i].nombreEntidadFederativa;
                                var elementosSolicitados = lista[i].elementosSolicitados;
                                var elementosContratados = lista[i].elementosContratados;
                                var elementosAsignados = lista[i].elementosAsignados;
                                var diferencia=  Math.abs(elementosSolicitados-elementosContratados);
                                var idClientePunto1  = lista[i].idClientePunto;
                                var razonsocial  = lista[i].razonsocial;
                                if(diferencia !="0"){
                                    //lista1 = lista1[];
                                    //lista1.push(lista[i]);
                                    totalDiferencia = totalDiferencia+diferencia;
                                    if(idClientePunto1 != idClientePunto2){
                                       listaTable += "<thead><tr><th colspan='8'>Cliente : "+razonsocial+"</th></tr></thead><tbody><tr><th>Id Punto</th><th>Punto Servicio</th><th>Centro Costo</th><th>Entidad</th><th>Vacantes</th></tr>";
                                       //<th>Elementos   Solicitados</th><th>Elementos contratados</th><th>Asignados</th>
                                       idClientePunto2 = idClientePunto1;
                                    }
                                    listaTable += "<tr><td>"+idPuntoServicio+" </td><td>"+puntoServicio+" </td><td>"+numeroCentroCosto+"</td><td>"+nombreEntidadFederativa.toUpperCase()+"</td>";
                                    //listaTable += "<td>"+elementosSolicitados+"</td>"
                                    //listaTable += "<td>"+elementosContratados+"</td>";
                                    listaTable += "<td>"+diferencia+"</td><tr>";//<td>"+elementosAsignados+"</td>
                                    $("#banderaVacantes").val(1);
                                    if(idClientePunto1==idCliente){
                                        ValidacionueNoTiene = "1";
                                    }
                                    var largolista2 =lista2.length;
                                    lista2[largolista2] = [razonsocial,idPuntoServicio,puntoServicio,numeroCentroCosto,nombreEntidadFederativa.toUpperCase(),diferencia];
                                   lista1.push(lista2[largolista2]);
                                }
                            }
                            var largolista2 =lista2.length;
                            lista2[largolista2] = ["TOTAL VACANTES :"+totalDiferencia," "," "," "," "," "];
                            lista1.push(lista2[largolista2]);
                            listaTable += "<thead><tr><th colspan='8'>TOTAL VACANTES : "+totalDiferencia+"</th></tr>";
                            listaTable += "</tbody></table>";
                            var banderaVacantes = $("#banderaVacantes").val();
                            if(banderaVacantes == "0" ){
                                alertMsg1="<div id='msgAlert' class='alert alert-error'><strong><center>El Cliente "+ClienteNombre+" No Tiene Vacantes</center></strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                                $("#msgerrorvacantes").html(alertMsg1);
                                $(document).scrollTop(0);
                                $('#msgAlert').delay(3000).fadeOut('slow');
                                clientes.pop();
                            }else{
                                $("#divGeneralVacantes").append(listaTable);
                              if(ValidacionueNoTiene=="0"){
                                alertMsg1="<div id='msgAlert' class='alert alert-error'><strong><center>El Cliente "+ClienteNombre+" No Tiene Vacantes</center></strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                                $("#msgerrorvacantes").html(alertMsg1);
                                $(document).scrollTop(0);
                                $('#msgAlert').delay(3000).fadeOut('slow');
                                clientes.pop();
                              }
                            }
                        }else{
                            alertMsg1="<div id='msgAlert' class='alert alert-error'><strong><center>El Cliente "+ClienteNombre+" No Tiene Vacantes</center></strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                            $("#msgerrorvacantes").html(alertMsg1);
                            $(document).scrollTop(0);
                            $('#msgAlert').delay(3000).fadeOut('slow');
                            clientes.pop();
                        }    
                    }
                },           
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                }
            });
        }
    }       

</script>