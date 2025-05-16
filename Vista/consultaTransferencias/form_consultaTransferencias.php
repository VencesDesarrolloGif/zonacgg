<div class="container" align="center" >
    <form class="form-horizontal"  method="post" id="form_consultaTransferencias" name="form_consultaTransferencias" action="" target="_blank">
     <div id="modalDetalleTransfer" name="modalDetalleTransfer" class="modalFactura hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" >            
          <div class="modal-header">            
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><img src="">Detalle Envio</h4>
          </div>
          <div class="modal-body-plantilla">
              <div class="hero-unit" id="listaDetalleTransfer" name="listaDetalleTransfer">
              </div>
              <div class="modal-footer" align="centers">
                  <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>                  
              </div>
          </div>
    </div>     
  </form>
    <h3>CONSULTAR TRANSFERENCIAS</h3>
    <br>    
        ENTIDAD: <select id="selectEntidadTransfer" name="selectEntidadTransfer" ><option value="00">TODAS</option>
            <?php
                for ($i=0; $i<count($catalogoEntidadesFederativasparaalmacen); $i++)
                {
                    if($i!=8)
                        echo "<option value='". $catalogoEntidadesFederativasparaalmacen[$i]["idEntidadFederativa"]."'>". $catalogoEntidadesFederativasparaalmacen[$i]["nombreEntidadFederativa"] ." </option>";
                }
              ?>
            </select>
            <br>
            <br>
     Del  <input type="text" id="fechaConsultaTransfer1" name="fechaConsultaTransfer1" class="input-medium">
        al
        <input type="text" id="fechaConsultaTransfer2" name="fechaConsultaTransfer2" class="input-medium">
        <button type="button" class="btn btn-success" data-dismiss="modal" onclick="consultaTransfer();">Consultar</button>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <section>
            <table id="listaTransferencias" cellspacing="0" width="100%">
                <thead>
                    <tr>                        
                        <th>Entidad Destino</th>                        
                        <th>Sucursal Destino</th>                        
                        <th>Fecha Envio</th>
                        <th>Fecha Recepcion</th>
                        <th>Usuario Captura</th>
                        <th>Numero Guia</th>
                        <th>Paqueteria</th>
                        <th>Observacion Transferencias</th> 
                        <th>Detalle</th>                         
                        <th>Estatus</th>
                        <th>Motivo Rechazo</th> 
                        <th>Observacion Rechazo</th> 
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                        <th>Entidad Destino</th>                        
                        <th>Sucursal Destino</th>                        
                        <th>Fecha Envio</th>
                        <th>Fecha Recepcion</th>
                        <th>Usuario Captura</th>
                        <th>Numero Guia</th>
                        <th>Paqueteria</th>
                        <th>Observacion Transferencias</th>   
                        <th>Detalle</th>                      
                        <th>Estatus</th>
                        <th>Motivo Rechazo</th> 
                        <th>Observacion Rechazo</th> 
                    </tr>
                </tfoot>
            </table>
        </section>
</div>
<script type="text/javascript">

var tableConsultaTransfer = null;

function consultaTransfer(){

    var fechaConsulta1=$("#fechaConsultaTransfer1").val();
    var fechaConsulta2=$("#fechaConsultaTransfer2").val();
    var entidad=$("#selectEntidadTransfer").val();
    
    var dataTableFacturas = [];
        $.ajax ({
            type: "POST"  
            ,url: "consultaTransferencias/ajax_getTransferenciasByFechaEntidad.php"
            ,data : {"fechaConsulta1":fechaConsulta1, "fechaConsulta2":fechaConsulta2, "entidadConsulta":entidad }
            ,dataType: "json"
            ,async: false
            ,success: function (response)
            {
                if (response.status == "success"){
                    for (var i = 0; i < response.data.length; i++){                        
                        var record = response.data[i];                                       
                        dataTableFacturas.push (record);                        
                    }
                    loadDataInTableTransferenciasConsulta(dataTableFacturas);
                }
            }
            ,error : function (jqXHR, textStatus, errorThrown){
                alert (jqXHR.responseText);
            }
        });
    }

    function loadDataInTableTransferenciasConsulta(data){
        if (tableConsultaTransfer != null){
           tableConsultaTransfer.destroy ();
    }

       

        tableConsultaTransfer = $('#listaTransferencias').DataTable( {
          "language" : {
              "emptyTable" :         "No hay facturas disponibles en la tabla",
              "info" :               "Del _START_ al _END_ de _TOTAL_",
              "infoEmpty" :          "Mostrando 0 registros de un total de 0.",
              "infoFiltered" :       "(filtrados de un total de _MAX_ registros)",
              "infoPostFix" :        "(actualizados)",
              "lengthMenu" :         "Mostrar _MENU_ registros",
              "loadingRecords" :     "Cargando....",
              "processing"     :     "Procesando....",
              "search" :             "Buscar:",
              "searchPlaceholder" :  "Dato para buscar",
              "zeroRecords" :        "no se han encontrado coincidencias",
              "paginate" : {
                   "first" :         "Primera",
                   "last" :          "Ultima",
                   "next" :          "Siguiente",
                   "previous" :      "Anterior"
              },
              "aria" : {
                 "sortAscending" :   "Ordenación ascendente",
                 "sortDescending" :  "Ordenación descendente"
              }
           },
        data: data,
        destroy: true,
        "columns": [
             { "className": "dt-body-center","data": "entidadDestino" }
            ,{ "className": "dt-body-center","data": "nombreSucursal"}
            ,{ "className": "dt-body-center","data": "fechaTransferenciaEnvio"}
            ,{ "className": "dt-body-center","data": "fechaTransferenciaRecepcion"}
            ,{ "className": "dt-body-center","data": "usuarioTransferencia"}
            ,{ "className": "dt-body-center","data": "nGuiaTransferencia"}
            ,{ "className": "dt-body-center","data": "proveedorPaqueteria"}
            ,{ "className": "dt-body-center","data": "observacionesTransferencia"}
            ,{ "className": "dt-body-center","data": "ver_detalle"}
            ,{ "className": "dt-body-center","data": "estatusTransfer"}
            ,{ "className": "dt-body-center","data": "motivoRechazoTransferencia"}
            ,{ "className": "dt-body-center","data": "observacionRechazoTransferencia"}
       ]
        ,processing: true
        ,dom: 'Bfrtip'
        ,buttons: ['excel']

    } );

}

/*function consultaTransfer(){

    var fechaConsulta1=$("#fechaConsultaTransfer1").val();
    var fechaConsulta2=$("#fechaConsultaTransfer2").val();
    var entidad=$("#selectEntidadTransfer").val();

    if (tableConsultaTransfer != null){
           tableConsultaTransfer.destroy ();
    }
  
    tableConsultaTransfer = $('#listaTransferencias').DataTable( {
    ajax: {
        url: 'ajax_getTransferenciasByFechaEntidad.php'
        ,type: 'POST'
        ,data : {"fechaConsulta1":fechaConsulta1, "fechaConsulta2":fechaConsulta2, "entidadConsulta":entidad }
    }
        ,"columns": [            
            { "data": "entidadDestino" }    
            ,{ "data": "nombreSucursal" }
            ,{ "data": "fechaTransferenciaEnvio" }
            ,{ "data": "fechaTransferenciaRecepcion" }
            ,{ "data": "usuarioTransferencia" }
            ,{ "data": "nGuiaTransferencia" }
            ,{ "data": "proveedorPaqueteria" }
            ,{ "data": "observacionesTransferencia" }
            ,{ "data": "ver_detalle" }
            ,{ "data": "estatusTransfer" }  
        ]
        ,processing: true
        ,dom: 'Bfrtip'
        ,buttons: [
            'copy', 'excel'
        ]
    });
}*/


function mostrarModalDetalleTransfer(idTransfer){
      $('#modalDetalleTransfer').modal();                  
      consultaDetalleTransferencia(idTransfer);
}

function consultaDetalleTransferencia(idTransfer){
    var transferId=idTransfer;
    $.ajax({
        type: "POST",
        url: "ajax_consultaDetalleTransferencia.php",
        data:{"idTransferencia":transferId},
        dataType: "json",
        success: function(response) {
            if (response.status == "success"){                    
                var envios = response.lista;                      
                document.getElementById("listaDetalleTransfer").innerHTML="";
                detalleTransferTable="<table  class='table table-hover' id='transfer"+transferId+"'><thead  style='color:#456789;font-size:100%;'><th> Tipo Uniforme</th><th>Descripcion Uniforme</th><th>Cantidad</th></thead><tbody>";                   
                for(var i = 0; i < envios.length; i++ ){
                    var tipoUniforme=envios[i].idUni;
                    var descripcion=envios[i].nombreUniforme;
                    var cantidadUniforme=envios[i].cantidad;                          
                    detalleTransferTable+="<tr style='color:#456789;font-size:80%;'><td>"+tipoUniforme+"</td><td>"+descripcion+"</td><td>"+cantidadUniforme+"</td></tr>";
                }
                detalleTransferTable += "</tbody></table>";
                $('#listaDetalleTransfer').html(detalleTransferTable);                       
            }else if (response.status == "error" && response.message == "No autorizado"){
                window.location = "login.php";
            }
        },error: function (response){
            alert("error inesperado transferencias");
        }
    });
}

$('#fechaConsultaTransfer1').datetimepicker({
  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',
});

$('#fechaConsultaTransfer2').datetimepicker({
  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',
});
</script>