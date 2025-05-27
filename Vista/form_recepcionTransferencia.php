
<div class="container" align="center">
    <form class="form-horizontal"  method="post" id="form_recepTransferencias" name="form_recepTransferencias" action="" target="_blank">
     <div id="modalDetalleTransRe" name="modalDetalleTransRe" class="modalFactura hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" >            
          <div class="modal-header">
            
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><img src="">Detalle</h4>
          </div>

          <div class="modal-body-plantilla">
            
              <div class="hero-unit" id="detalleTransfer" name="detalleTransfer">
                  
              </div>

              <div class="modal-footer" align="centers">
                  <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>                  
              </div>
          </div>
    </div>     
  </form>
    <fieldset>        
      <h1>Transferencias</h1>
    </fieldset>

    <div id="divselecentidades">
      <span >Seleccione La Entidad De Recepción</span>
      <select id="selEntidadesTrans" name="selEntidadesTrans" ></select>
    </div>
  
    <section>
      <table id="tableTransfer" class="display" cellspacing="0" width="80%">
        <thead>
          <tr>
            <th>Fecha Envio</th>                                    
            <th>Fecha Recepcion</th>
            <th>Usuario Envio</th>                                    
            <th>Numero Guia</th>
            <th>Paqueteria</th>
            <th>Observaciones</th>            
            <th>Detalle</th>            
            <th>Entidad a Recibir</th>            
            <th>Estatus</th>   
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </section>  
</div>
<script type="text/javascript">

var tableTransferencias1 = null;


function getEnviosTransfer(){
  var dataTableTransfers = [];
  //$("#selEntidadesTrans").val("0");
        $.ajax ({
            type: "POST"  
            ,url: "ajax_getEnviosTransferencia.php"
            ,dataType: "json"
            ,async: false
            ,success: function (response)
            {
                if (response.status == "success")
                {
                    for (var i = 0; i < response.data.length; i++)
                    {                        
                        var record = response.data[i];
                        //console.log(record);
                        //alert(record.esatusPunto);                                            
                        dataTableTransfers.push (record);                        
                        
                        
                    }

                    loadDataInTableLavanderia (dataTableTransfers);
                    cargarSelectorEntidadesTransfer();
                }
            }
            ,error : function (jqXHR, textStatus, errorThrown)
            {
                alert ("Error en consulta Transfers");
            }
        });
    }

    function cargarSelectorEntidadesTransfer(){
    $.ajax({
      type: "POST",
      url: "ajax_getEntidadesUsuario.php",
      dataType: "json",
      success: function(response) {
        //console.log(response.datos);
        $("#selEntidadesTrans").empty(); 
        $('#selEntidadesTrans').append('<option value="0">Entidad Federativa</option>');
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#selEntidadesTrans').append('<option value="' + (response.datos[i].idEntidadFederativa) + '">' + response.datos[i].nombreEntidadFederativa + '</option>');
          }
        }else{
          alert("Error Al Cargar Las Entidades");
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }

    function loadDataInTableLavanderia (data)
    {
        if (tableTransferencias1 != null)
        {
            tableTransferencias1.destroy ();
            //tableServiciosFacturacion = null;
        }

       

        tableTransferencias1 = $('#tableTransfer').DataTable( {
          "language" : {
              "emptyTable" :         "No hay envios disponibles en la tabla",
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
            { "data": "fechaTransferenciaEnvio" }
            ,{ "data": "fechaTransferenciaRecepcion"}
            ,{ "data": "usuarioTransferencia"}
            ,{ "data": "nGuiaTransferencia"}
            ,{ "data": "proveedorPaqueteria"}
            ,{ "data": "observacionesTransferencia"}            
            ,{ "data": "ver_detalle"}
            ,{ "data": "entidadDestino"}            
            ,{ "data": "estatusTransfer" }
            

       ]
        //,serverSide: true
        ,processing: true
        ,dom: 'Bfrtip'
        ,buttons: ['excel']

    } );

}


  function mostrarDetalleTransfer(idTransf){      
      $('#modalDetalleTransRe').modal();                        
      consultaDetalleRecep(idTransf);


  }

  function consultaDetalleRecep(idTransfer)
  {
    var facturaId=idTransfer;    

      $.ajax({
              
              type: "POST",
              url: "ajax_consultaDetalleTransferencia.php",
             data:{"idTransferencia":facturaId},
              dataType: "json",
               success: function(response) {
                  if (response.status == "success")
                  {
                    
                      var envios = response.lista;                      

                      document.getElementById("detalleTransfer").innerHTML="";
                      
                      detalleTransferTable="<table  class='table table-hover' id='transfer"+facturaId+"'><thead  style='color:#456789;font-size:100%;'><th> Tipo Uniforme</th><th>Descripcion Uniforme</th><th>Cantidad</th></thead><tbody>";                   
                      for ( var i = 0; i < envios.length; i++ ){
                          
                          var tipoUniforme=envios[i].idUni;
                          var descripcion=envios[i].nombreUniforme;
                          var cantidadUniforme=envios[i].cantidad;                          

                          detalleTransferTable+="<tr style='color:#456789;font-size:80%;'><td>"+tipoUniforme+"</td><td>"+descripcion+"</td><td>"+cantidadUniforme+"</td></tr>";
                                      
                      }

                      detalleTransferTable += "</tbody></table>";
                      $('#detalleTransfer').html(detalleTransferTable);                      
                      
                      //obtenerNumeroRequisicion();                  
                  }  
                  else if (response.status == "error" && response.message == "No autorizado")
                  {
                      window.location = "login.php";
                  }
              },
              error: function (response)
              {
                  alert("error inesperado Transferencias");

              }
        });
    


    }

    function recibirTransferencia(idTransfer,entidadDestino){                

      var entidadRecepcion = $("#selEntidadesTrans").val();
      if(entidadRecepcion=="" ||entidadRecepcion=="null" || entidadRecepcion=="NULL" || entidadRecepcion==null || entidadRecepcion=="0"){
          alert("Selecciona La Entidad De Recepción Para Continuar ...");
      }else if (entidadRecepcion !=entidadDestino) {
          alert("La Entidad De Recepción seleccionada es diferente a la entidad a recibir por favor verifique la entidad a recibir sea correcta");
      }

      else{
        $.ajax({  
          type: "POST",
          url: "ajax_recibirTransferencia.php",
          data:{"idTransferencia": idTransfer,"entidadRecepcion":entidadRecepcion},
          dataType: "json",
          success: function(response) {
            if (response.status == "success")
            {
              var mensaje=response.message;                    
              alert(mensaje);  
              // getStockUniforme(); 
              getEnviosTransfer();                                                       
            }  
            else if (response.status == "error")
            {
                alert(response.message);
            }
          },
          error: function (response)
          {
              alert("error de actualizacionTransfer");
          }
        });
      }
    }
   

    $(document).ready (function ()
          {
             
             getEnviosTransfer();
    });    

  

  </script>
