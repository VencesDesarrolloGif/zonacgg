<div class="container" align="center">
  <form class="form-horizontal"  method="post" id="form_catalogoProveedores" name="form_catalogoProveedores" action="" target="_blank">
    <fieldset>        
      <h1>Lista de Proveedores</h1>
    </fieldset>
  
    <section>
      <table id="tableProveedores" class="display" cellspacing="0" width="80%">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>RFC</th>
            <th>Numero Contable</th>
            <th>Contacto</th>
            <th>Telefono</th>
            <th>Banco</th>
            <th>No Cuenta</th>
            <th>CTA CLABE</th>
            <th>Email</th>
            <th>Dirección Fiscal</th>                        
          </tr>
        </thead>

        <tbody></tbody>
      </table>
    </section>
  </form>
</div>
<script type="text/javascript">
$(getProveedores());  

var tableProveedores = null;

function getProveedores(){
  var dataTableProveedores = [];

        $.ajax ({
            type: "POST"
            ,url: "ajax_getProveedores.php"
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
                        dataTableProveedores.push (record);                        
                        
                        
                    }

                    loadDataInTableProveedores (dataTableProveedores);
                }
            }
            ,error : function (response)
            {
                alert ("ocurrio un error");
            }
        });
    }

    function loadDataInTableProveedores (data)
    {
        if (tableProveedores != null)
        {
            tableProveedores.destroy ();
            //tableServiciosFacturacion = null;
        }

       

        tableProveedores = $('#tableProveedores').DataTable( {
          "language" : {
              "emptyTable" :         "No hay proveedores disponibles en la tabla",
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
            { "data": "nombreProveedor" }
            ,{ "data": "rfcProveedor"}
            ,{ "data": "numeroContableProv"}
            ,{ "data": "nombreContactoProv"}
            ,{ "data": "telefonoProveedor"}
            ,{ "data": "nombreBanco"}
            ,{ "data": "nCuentaProveedor"}
            ,{ "data": "ctaClabeProveedor"}
            ,{ "data": "correoProveedor"}
            ,{ "data": "domicilioProveedor" }
            

       ]
        //,serverSide: true
        ,processing: true
        ,dom: 'Bfrtip'
        ,buttons: ['excel']

    } );

}
</script>