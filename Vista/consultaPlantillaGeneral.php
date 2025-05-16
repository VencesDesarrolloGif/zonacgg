<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();

require_once ("../Negocio/Negocio.class.php");
//require_once ("../libs/PHPExcel.php");
$usuario = isset ($_SESSION ["userLog"]) ? $_SESSION ["userLog"] : null;

if ($usuario == null)
{
    header("Location:login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Linea de Negocios gif</title>
    <link rel="stylesheet" href="css/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/css/estilos.css">
    <!-- Buttons DataTables -->
    <link rel="stylesheet" href="css/css/buttons.bootstrap.min.css">
    <link rel="stylesheet" href="css/css/font-awesome.min.css">

</head>
<body>

    
   
    <div class="row">
        <div id="cuadro1" class="col-sm-12 col-md-12 col-lg-12">
            <div class="col-sm-offset-2 col-sm-8">
                <h3 class="text-center"> <small class="mensaje"></small></h3>

            </div>
            <div class="table-responsive col-sm-12">        
                <table id="dt_LineaN" class="table table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>                                
                            
                             <th>Id Cliente</th>
                             <th>Cliente</th>
                             <th>Id Punto</th>
                             <th>Punto Servicio</th>
                             <th>Entidad</th>
                             <th> Linea Negocio</th>
                              <th> Region</th>
                             <th>Latitud</th>
                             <th>Longitud</th>
                             <th>Direccion</th>
                             <th>Elementos Solicitados</th>
                             <th>Elementos Contratados</th>
                             <th> Diferencia</th>                                        
                        </tr>
                    </thead>                    
                </table>

                <a href="usuarioLogeado.php"> <input id="" type="button" class="btn btn-primary" value="Regresar"></a> 
                 </center>
            </div>          
        </div>      
    </div>
    <div>
 
    </div>
    
    <script src="js/js/jquery-1.12.3.js"></script>
    <script src="js/js/bootstrap.min.js"></script>
    <script src="js/js/jquery.dataTables.min.js"></script>
    <script src="js/js/dataTables.bootstrap.js"></script>
    <!--botones DataTables-->   
    <script src="js/js/dataTables.buttons.min.js"></script>
    <script src="js/js/buttons.bootstrap.min.js"></script>
    <!--Libreria para exportar Excel-->
    <script src="js/js/jszip.min.js"></script>
    <!--Librerias para exportar PDF-->
    <script src="js/js/pdfmake.min.js"></script>
    <script src="js/js/vfs_fonts.js"></script>    <!--Librerias para botones de exportación-->
    <script src="js/js/buttons.html5.min.js"></script>

    <script>        
        $(document).on("ready", function(){
            listar();
           
        });

        

      
        

       

        var listar = function(){
         
            var table = $("#dt_LineaN").DataTable({
                "destroy":true,
                "ajax":{
                    "method":"POST",
                    "url": "listar_plantilla_general.php"
                },
                "columns":[
                {"data":"idClientePunto"},
                 {"data":"razonsocial"},
                  {"data":"idPuntoServicio"},
                   {"data":"puntoServicio"},
                    {"data":"nombreEntidadFederativa"},

                    {"data":"descripcionLineaNegocio"},
                    


                       {"data":"DescripcionI"},
                    {"data":"latitudPunto"},
                    {"data":"longitudPunto"},
                    {"data":"direccionPuntoServicio"},
                       {"data":"elementosSolicitados"},
                        {"data":"elementosContratados"},
                            {"data":"diferencia"},
                ],
                "language": idioma_espanol,
                    "dom":"Bfrtip",
                  "buttons": ['excel',{orientation:'landscape',extend:'pdf',pageSize:'LEGAL'}]

            });

            obtener_data_editar("#dt_LineaN tbody", table);
            obtener_id_eliminar("#dt_LineaN tbody", table);
        }


        var idioma_espanol = {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
        

    </script>
</body>
</html>
