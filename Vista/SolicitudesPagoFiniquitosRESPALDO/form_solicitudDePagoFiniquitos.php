<div>
    <center>
        <h2 align="center">Solicitudes de pago finiquitos</h2><br>
        <button class="botonNormal azulTransparente" type="button" onclick="consultaSolicitudesDePagoFiniquitos();"> Reconsultar Empleados</button>
        <button class="botonNormal verdeTransparente" type="button" onclick="generarFolioPagoFiniquito();">Generar Folio</button>
        <br><br><br>

        <section>
            <table id="tablaSPF" style="display:none;"  class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead class="thead-dark">
                    <tr>
                        <th style="text-align: center;background-color: #B0E76E">#Empleado</th>
                        <th style="text-align: center;background-color: #B0E76E">Nombre</th>
                        <th style="text-align: center;background-color: #B0E76E">Entidad</th>
                        <th style="text-align: center;background-color: #B0E76E">Puesto</th>
                        <th style="text-align: center;background-color: #B0E76E">Tipo Puesto</th>
                        <th style="text-align: center;background-color: #B0E76E">Fecha Baja</th>
                        <th style="text-align: center;background-color: #B0E76E">Total</th>
                        <th style="text-align: center;background-color: #B0E76E">PDF Finiquito</th>
                        <th style="text-align: center;background-color: #B0E76E">Generar Folio</th>
                    </tr>
                </thead>
            </table>
        </section>
    </center>
    <input type="hidden" id="inpTotalEmp" values="0">
</div>
<script type="text/javascript">

$(consultaSolicitudesDePagoFiniquitos());  

function generarFolioPagoFiniquito(){//generar folios
    var totalEmpleado = $("#inpTotalEmp").val();
    var listaAgregados= [];
    for(var i = 0; i < totalEmpleado; i++){       
        if($("#checkSPF"+i).is(":checked")) {
            // alert(i);
           var idFiniquitoSel=$("#checkSPF"+i).val();
           listaAgregados.push(idFiniquitoSel);
        }
    }
console.log(listaAgregados);
    if(listaAgregados==""){
        alert("SELECCIONE EMPLEADOS");
    }else{
        $.ajax({
            type: "POST",
            url: "SolicitudesPagoFiniquitos/ajax_generarFolioSPF.php",
            data: {"listaAgregados": listaAgregados},
            dataType: "json",
            async:false,
            success: function(response) {
                if(response.status == "success"){
                    swal("Listo","Folio generado correctamente","success");
                    consultaSolicitudesDePagoFiniquitos();
                }else if(response.status == "error"){
                    alert("ERROR AL ACTUALIZAR SOLICITUDES");
                }
            },error: function (response){
                console.log (response);
            }
        });
    }

}

function consultaSolicitudesDePagoFiniquitos(){ 
    cargarTablaSPF();
    var td,campo,valor,id;
}

function cargarTablaSPF(){
    tablaspf = [];
    $.ajax({
        type: "POST",
        url: "SolicitudesPagoFiniquitos/ajax_obtenerEmpleadosSPF.php",
        dataType: "json",
        async: false,
        success: function(response) {
            if(response.status == "success") {
                var totalEmpleados= response.listaEmpleadosSPF.length;
                $("#inpTotalEmp").val(totalEmpleados);
               for (var i = 0; i < response.listaEmpleadosSPF.length; i++) {
                    var record = response.listaEmpleadosSPF[i];
                    tablaspf.push(record);
                }
                loadTablaSPF(tablaspf);
                $("#tablaSPF").show();
            }else{
                var mensaje = response.message;
            }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
    });
}

var tableloadSPF = null;
function loadTablaSPF(data){
    if(tableloadSPF != null) {
        tableloadSPF.destroy();
    }
    tableloadSPF = $('#tablaSPF').DataTable({
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
             "data": "numeroEmpleado"
         }, 
         {   
             "data": "nombreEmpleado"
         },
         {   
             "data": "nombreEntidadFederativa"
         },
         {   
             "data": "descripcionPuesto"
         },
         {   
             "data": "descripcionCategoria"
         },
         {   
             "data": "fechaBaja"
         },
         {   
             "className": "dt-body-right","data": "netoAlPago"
         },
         {   
             "className": "dt-body-center","data": "abrirPdf"
         },
         {   
             "className": "dt-body-center","data": "cehcaCreado"
         },

          ],
         processing: true,
         dom: 'Bfrtip',
         buttons: {
            buttons: []
         }
        });
 } 
    

function abrirPdfFiniquitoFinanzas(finiquitofirmado) {
     window.open("uploads/finiquitosFirmadosParaPago/"+finiquitofirmado);
 }
</script>