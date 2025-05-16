<div align="center">
 <form class="form-horizontal"  method="post" id="form_consultaLavanderias" name="form_consultaLavanderias" action="" target="_blank">
     <div id="modalDetalleEnvio" name="modalDetalleEnvio" class="modalFactura hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" >            
          <div class="modal-header">
            
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><img src="">Detalle Envio</h4>
          </div>

          <div class="modal-body-plantilla">
            
              <div class="hero-unit" id="listaDetalleLava" name="listaDetalleLava">
                  
              </div>

              <div class="modal-footer" align="centers">
                  <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>                  
              </div>
          </div>
    </div>     
  </form>
</div>
<div class="container" align="center">
 
    <fieldset>        
      <h1>Lista de Envios</h1>
    </fieldset>
  
    <section>
      <table id="tableEnviosLava" class="display" cellspacing="0" width="80%">
        <thead>
          <tr>
            <th>Folio Lavanderia</th>                                    
            <th>Entidad</th>
            <th>Fecha de Envio</th>                                    
            <th>Total Nota</th>
            <th>Estatus</th>
            <th>Fecha Recepcion</th>            
            <th>Detalle</th>            
            <th>Acción</th>   
          </tr>
        </thead>

        <tbody></tbody>
      </table>
    </section>  
</div>
<script type="text/javascript">
$(getEnvioslavanderia());  
var tableEnviosLava = null;

function getEnvioslavanderia(){
   
            if (tableEnviosLava != null)
                {
                    tableEnviosLava.destroy ();
                }
          



                tableEnviosLava = $('#tableEnviosLava').DataTable( {
                ajax: {
                    url: 'ajax_getEnviosLavanderia.php'
                    ,type: 'POST'                    
               }
                ,"columns": [            
                    { "data": "idEnvio" }
            ,{ "data": "entidadEnvio"}
            ,{ "data": "fechaEnvio"}
            ,{ "data": "totalEnvio", render: $.fn.dataTable.render.number(',','.', 2,'$') }
            ,{ "data": "estatus"}
            ,{ "data": "fechaReceive"}            
            ,{ "data": "accion_ver_detalle"}            
            ,{ "data": "accion_recibir" }           
                          
                ]
                //,serverSide: true
                ,processing: true
                ,dom: 'Bfrtip'
                ,buttons: [
                    'copy', 'excel'
                ]

            } );   



}

/*function getEnvioslavanderia(){
  var dataTableEnvios = [];

        $.ajax ({
            type: "POST"  
            ,url: "ajax_getEnviosLavanderia.php"
            ,dataType: "json"
            ,async: false
            ,success: function (response)
            {
                if (response.status == "success")
                {
                    for (var i =response.data.length-1; i >=0; i--)
                    {                        
                        var record = response.data[i];
                        //console.log(record);
                        //alert(record.esatusPunto);                                            
                        dataTableEnvios.push (record);                        
                        
                        
                    }

                    loadDataInTableLavanderia (dataTableEnvios);
                }
            }
            ,error : function (jqXHR, textStatus, errorThrown)
            {
                alert ("Error en consulta envios");
            }
        });
    }

    function loadDataInTableLavanderia (data)
    {
        if (tableEnviosLava != null)
        {
            tableEnviosLava.destroy ();
            //tableServiciosFacturacion = null;
        }

       

        tableEnviosLava = $('#tableEnviosLava').DataTable( {
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
                 "sortDescending" :   "Ordenación descendente",
                 "sortAscending" :  "Ordenación ascendente"                 
              }
           },
        data: data,
        destroy: true,
        "columns": [
            { "data": "idEnvio" }
            ,{ "data": "entidadEnvio"}
            ,{ "data": "fechaEnvio"}
            ,{ "data": "totalEnvio", render: $.fn.dataTable.render.number(',','.', 2,'$') }
            ,{ "data": "estatus"}
            ,{ "data": "fechaReceive"}            
            ,{ "data": "accion_ver_detalle"}            
            ,{ "data": "accion_recibir" }
            

       ]
        //,serverSide: true
        ,processing: true
        ,dom: 'Bfrtip'
        ,buttons: ['excel']

    } );

}*/


  function mostrarModalDetalleEnvio(idFactura){

      $('#modalDetalleEnvio').modal();                  

      consultaDetalleEnvio(idFactura);


  }

  function consultaDetalleEnvio(idFactura)
  {
    var facturaId=idFactura;

      $.ajax({
              
              type: "POST",
              url: "ajax_consultaDetalleLavanderia.php",
             data:{"folioEnvio":facturaId},
              dataType: "json",
               success: function(response) {
                  if (response.status == "success")
                  {
                    
                      var envios = response.lista;                      

                      document.getElementById("listaDetalleLava").innerHTML="";
                      
                      detalleEnvioTable="<table  class='table table-hover' id='"+facturaId+"'><thead  style='color:#456789;font-size:100%;'><th> Tipo Uniforme</th><th>Descripcion Uniforme</th><th>Cantidad</th></thead><tbody>";                   
                      for ( var i = 0; i < envios.length; i++ ){
                          
                          var tipoUniforme=envios[i].idUni;
                          var descripcion=envios[i].nombreUniforme;
                          var cantidadUniforme=envios[i].cantidad;                          

                          detalleEnvioTable+="<tr style='color:#456789;font-size:80%;'><td>"+tipoUniforme+"</td><td>"+descripcion+"</td><td>"+cantidadUniforme+"</td></tr>";
                                      
                      }

                      detalleEnvioTable += "</tbody></table>";
                      $('#listaDetalleLava').html(detalleEnvioTable);                       
                      
                      //obtenerNumeroRequisicion();                  
                  }  
                  else if (response.status == "error" && response.message == "No autorizado")
                  {
                      window.location = "login.php";
                  }
              },
              error: function (response)
              {
                  alert("error inesperado lavanderia");

              }
        });
    


    }

    function recibirLavanderia(idEnvio){                
        //alert(idEnvio);
        $.ajax({
              
              type: "POST",
              url: "ajax_recibirEnvioLavanderia.php",
             data:{"idEnvio": idEnvio},
              dataType: "json",
               success: function(response) {
                  if (response.status == "success")
                  {
                    var mensaje=response.message;                    

                    //limpiarFormularioRequisicionAlta();
                    //consultaRequisicionAlta();
                    //$("#modalDetalleFactura").modal('hide');
                    alert(mensaje);  
                    getStockUniforme();                  
                    getEnvioslavanderia();
                                     
                  }  
                  else if (response.status == "error")
                  {
                      alert(response.message);
                  }
              },
              error: function (response)
              {
                  alert("error de actualizacionEnvio");

              }
        });
    }
</script>