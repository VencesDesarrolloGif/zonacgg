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

$negocio = new Negocio ();
   $catalogoLineaNegocio= $negocio -> negocio_obtenerListaLineaNegocio();
   $catalogoTipoPuestos= $negocio -> obtenerCatalogoTipoPuesto();

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

        <div id="cuadro2" class="col-sm-12 col-md-12 col-lg-12 ocultar">
            <form class="form-horizontal" action="" method="POST">
                <div class="form-group">
                    <h3 class="col-sm-8 text-center">                   
                   Linea de negocios</h3>
                </div>
                <input type="hidden" id="idpuesto" name="idproducto" value="0">
                <input type="hidden" id="opcion" name="opcion" value="registrar">
                    <div class="form-group">
                    <label for="bussines" class="col-sm-2 control-label">Linea de negocio</label>
                    <div class="col-md-5">
                        
                             <select id="selectLineaNegocio" name="selectLineaNegocio" class="form-control" onChange="">
            
              <?php
                for ($i=0; $i<count($catalogoLineaNegocio); $i++)
                {
                echo "<option value='". $catalogoLineaNegocio[$i]["idLineaNegocio"]."'>". $catalogoLineaNegocio[$i]["descripcionLineaNegocio"] ." </option>";
                }
              ?>
          
      </select>
                    </div>
              
                </div>
                  <div class="form-group">
                    <label for="nombre" class="col-md-2 control-label">Tipo de puesto </label>
                    <div class="col-md-5">
                    <select id="tipoPuesto" name="tipoPuesto" class="form-control" onChange="">
             
              <?php
              for ($i = 0; $i < count($catalogoTipoPuestos); $i++)
              {
                echo "<option value='" . $catalogoTipoPuestos [$i]["idCategoria"] . "' >" . $catalogoTipoPuestos [$i]["descripcionCategoria"] . " </option>";
              }
              ?>
            </select>
                      
                    </div>               
                </div>
                <div class="form-group">
                    <label for="nombre" class="col-sm-2 control-label">Descripcion de puesto </label>
                    <div class="col-md-5"><input id="descripcion" name="descripcion" type="text" class="form-control"  autofocus></div>               
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-8">
                        <input id="" type="submit" class="btn btn-primary" value="Guardar" onclick='listar()';>
                              <input id="btn_listar" type="button" class="btn btn-primary" value="Cancelar">
            
                    </div>
                </div>
            </form>
            <div class="col-sm-offset-2 col-sm-8">
                <p class="mensaje"></p>
            </div>
            
        </div>
    </div>
    <div class="row">
        <div id="cuadro1" class="col-sm-12 col-md-12 col-lg-12">
            <div class="col-sm-offset-2 col-sm-8">
                <h3 class="text-center"> <small class="mensaje"></small></h3>

            </div>
            <div class="table-responsive col-sm-12">        
                <table id="dt_LineaN" class="table table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>                                
                            
                             <th> DESCRIPCION PUESTO</th>
                               <th>PUESTO</th>
                            <th>LINEA DE NEGOCIO</th>
                          
                              
                            <th></th>                                           
                        </tr>
                    </thead>                    
                </table>
                 <center> <input id="btn_actualizar" type="button" class="btn btn-primary" value="Actualizar">

                <a href="usuarioLogeado.php"> <input id="" type="button" class="btn btn-primary" value="Regresar"></a> 

                 </center>
            </div>          
        </div>      
    </div>
    <div>
        <form id="frmEliminarProducto" action="" method="POST">
            <input type="hidden" id="idpuesto" name="idproducto" value="">
            <input type="hidden" id="opcion" name="opcion" value="eliminar">
            <!-- Modal -->
            <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="modalEliminarLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="modalEliminarLabel">Eliminar Producto</h4>
                        </div>
                        <div class="modal-body">                            
                            ¿Está seguro de eliminar el producto?<strong data-name=""></strong>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="eliminar-producto" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
        </form>
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
            guardar();
            eliminar();
        });

        $("#btn_actualizar").on("click", function(){
            listar();
        });

        $("#btn_listar").on("click", function(){
            listar();
        });

        var guardar = function(){
            $("form").on("submit", function(e){
                e.preventDefault();
                var frm = $(this).serialize();
                $.ajax({
                    method: "POST",
                    url: "guardar_lineaNegocio.php",
                    data: frm
                }).done( function( info ){
                    
                    var json_info = JSON.parse( info);
                    mostrar_mensaje( json_info );
                    limpiar_datos();
                    listar();
                });
            });
        }

        var eliminar = function(){
            $("#eliminar-producto").on("click", function(){
                var idpuesto= $("#frmEliminarProducto #idpuesto").val(),
                    opcion = $("#frmEliminarProducto #opcion").val();
                $.ajax({
                    method:"POST",
                    url: "guardar_lineaNegocio.php",
                    data: {"idpuesto": idpuesto, "opcion": opcion}
                }).done( function( info ){
                    var json_info = JSON.parse( info );
                    mostrar_mensaje( json_info );
                    limpiar_datos();
                    
                });
            });
        }

        var mostrar_mensaje = function( informacion ){
            var texto = "", color = "";
            if( informacion.respuesta == "BIEN" ){
                    texto = "<strong>Bien!</strong> Se han guardado los cambios correctamente.";
                    color = "#379911";
            }else if( informacion.respuesta == "ERROR"){
                    texto = "<strong>Error</strong>, no se ejecutó la consulta.";
                    color = "#C9302C";
            }else if( informacion.respuesta == "EXISTE" ){
                    texto = "<strong>Información!</strong> el productp ya existe.";
                    color = "#5b94c5";
            }else if( informacion.respuesta == "VACIO" ){
                    texto = "<strong>Advertencia!</strong> debe llenar todos los campos solicitados.";
                    color = "#ddb11d";
            }else if( informacion.respuesta == "OPCION_VACIA" ){
                    texto = "<strong>Advertencia!</strong> la opción no existe o esta vacia, recargar la página.";
                    color = "#ddb11d";
            }

            $(".mensaje").html( texto ).css({"color": color });
            $(".mensaje").fadeOut(5000, function(){
                    $(this).html("");
                    $(this).fadeIn(3000);
            });         
        }

        var limpiar_datos = function(){
            $("#opcion").val("registrar");
            $("#idproducto").val("");
            $("#descripcion").val("");
            $("#nombre").val("").focus();
            $("#modelo").val("");
            $("#des").val("");
            $("#marca").val("");
            $("#unitario").val("");
            $("#caja").val("");
        }

        var listar = function(){
                $("#cuadro2").slideUp("slow");
                $("#cuadro1").slideDown("slow");
            var table = $("#dt_LineaN").DataTable({
                "destroy":true,
                "ajax":{
                    "method":"POST",
                    "url": "listar_lineaNegocio.php"
                },
                "columns":[
                {"data":"descripcionpuesto"},
                  {"data":"descripcionCategoria"},
                {"data":"descripcionLineaNegocio"},
              

                    {"defaultContent": "<button type='button' class='editar btn btn-primary'><i class='fa fa-pencil-square-o'></i></button> <button type='button' class='eliminar btn btn-danger' data-toggle='modal' data-target='#modalEliminar' ><i class='fa fa-trash-o'></i></button>"}    
                ],
                "language": idioma_espanol,
                    "dom":"Bfrtip",
                  "buttons":[                   
                    {
                        text:      '<i class="fa fa-user-plus"></i>',
                        titleAttr: 'Agregar',
                        className: 'btn btn-success',
                        action:     function(){
                                        agregar_nuevo_producto();
                        }
                    },
                     {
                        extend:    'excelHtml5',
                        text:      '<i class="fa fa-file-excel-o"></i>',
                        titleAttr: 'Excel'
                    },
                    {
                        extend:    'csvHtml5',
                        text:      '<i class="fa fa-file-text-o"></i>',
                        titleAttr: 'CSV'
                    },
                    {
                        extend:    'pdfHtml5',
                        text:      '<i class="fa fa-file-pdf-o"></i>',
                        titleAttr: 'PDF'
                    }
                    
                ]

            });

            obtener_data_editar("#dt_LineaN tbody", table);
            obtener_id_eliminar("#dt_LineaN tbody", table);
        }

        var agregar_nuevo_producto = function(){
            limpiar_datos();
            $("#cuadro2").slideDown("slow");
            $("#cuadro1").slideUp("slow");
        }

        var obtener_data_editar = function(tbody, table){
            $(tbody).on("click", "button.editar", function(){
                var data = table.row( $(this).parents("tr") ).data();
             var idpuesto = $("#idpuesto").val( data.idPuesto),
                 descripcion=$("#descripcion").val( data.descripcionPuesto);
                   opcion = $("#opcion").val("modificar");

                        $("#cuadro2").slideDown("slow");
                        $("#cuadro1").slideUp("slow");

                 console.log(data);
             
            });
        }

        var obtener_id_eliminar = function(tbody, table){
            $(tbody).on("click", "button.eliminar", function(){
                var data = table.row( $(this).parents("tr") ).data();
                var idpuesto = $("#frmEliminarProducto #idpuesto").val( data.idPuesto );
            });
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
