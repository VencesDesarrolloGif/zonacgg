<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();


require_once "../Negocio/Negocio.class.php";
//require_once ("../libs/PHPExcel.php");
$usuario = isset($_SESSION["userLog"]) ? $_SESSION["userLog"] : null;

if ($usuario == null) {
    header("Location:LoginSuperUsuario/form_LoginSuperUsuario.php");
    exit;
}

$negocio    = new Negocio();
$tipoPuesto = 0;


if ($usuario["rol"] == "Contrataciones" || $usuario["rol"] == "Socioeconomico" || $usuario["rol"] == "Lider Unidad" || $usuario["rol"] == "Consulta Rh" || $usuario["rol"] == "Laborales" || $usuario["rol"] == "Direccion General" || $usuario["rol"] == "Centro De Control" || $usuario["rol"] == "Tramites o Gestion") {
    //$catalogoPuestos = $negocio -> obtenerCatalogoPuestoPorTipoPuesto ($tipoPuesto);
    $catalogoTipoPuestos          = $negocio->obtenerCatalogoTipoPuesto();
    $catalogoEntidadesFederativas = $negocio->negocio_obtenerListaEntidadesFeferativas();
    $catalogoSucursalesInternas = $negocio->negocio_obtenerListaSucursalesinternas();
    $catalogoEntidadesFederativasALaborar = $negocio->negocio_obtenerListaEntidadesFeferativasaLaborar();
    $catalogoGeneros              = $negocio->negocio_obtenerCatalogoGeneros();
    $catalogoOficios              = $negocio->negocio_obtenerListaOficios();
    $catalogoTipoSangre           = $negocio->negocio_obtenerListaTipoSangre();
    $catalogoTurnos               = $negocio->negocio_obtenerListaTurnos();
    $catalogoDocumentos           = $negocio->negocio_traerListaDocumentos();
    $catalogoEstatusCartilla      = $negocio->negocio_obtenerListaEstatusCartilla();
    $catalogoGradoEstudios        = $negocio->negocio_obtenerListaGradoEstudios();
    $catalogoEstadoCivil          = $negocio->negocio_obtenerListaEstadoCivil();
    $catalogosPaises              = $negocio->negocio_obtenerListaPaises();
    $catalogoParentescos          = $negocio->negocio_obtenerListaParentescos();
    $catalogoLineaNegocio         = $negocio->negocio_obtenerListaLineaNegocio();
    $catalogoTipoBaja             = $negocio->negocio_obtenerListaTipoBaja();
    $catalogoPeriodos             = $negocio->getTiposPeriodos();
    $catatoloClientes             = $negocio->negocio_obtenerListaClientes();
    


    //METODOS PARA OBTENER FATIGAS GENERALES

    //$catalogomedioinformacion= $negocio -> getCatalogoMediosInformacion();
    //$reclutadoresSeguridadFisica= $negocio -> obtenerReclutadoresSeguridadFisica();
    //$log->LogInfo("Valor de catalogomedioinformacion en vista (catalogomedioinformacion)" . var_export ($catalogomedioinformacion, true));
    //$log->LogInfo("Valor de Entidades en vista (catalogo)" . var_export ($catalogoEntidadesFederativas, true));
    //$log->LogInfo("Valor de catalogoGeneros en vista (catalogo)" . var_export ($catalogoGeneros, true));
    //$log->LogInfo("Valor de catalogoOficios en vista (catalogo)" . var_export ($catalogoOficios, true));
    //$log->LogInfo("Valor de catalogoTipoSangre en vista (catalogo)" . var_export ($catalogoTipoSangre, true));
    //$log->LogInfo("Valor de catalogoTurnos en vista (catalogo)" . var_export ($catalogoTurnos, true));
    //$log->LogInfo("Valor de catalogoDocumentos en vista (catalogo)" . var_export ($catalogoDocumentos, true));
    //$log->LogInfo("Valor de catalogoLineaNegocio en vista (catalogo)" . var_export ($catalogoLineaNegocio, true));
} elseif ($usuario["rol"] == "Recepcion") {
    $catalogoIdentificaciones = $negocio->negocio_obtenerListaIdentificaciones();
    $catalogoDepartamentos    = $negocio->negocio_obtenerListaDepartamentos();

    //$log->LogInfo("Valor de catalogoDepartamentos en vista (catalogo)" . var_export ($catalogoDepartamentos, true));
    //$log->LogInfo("Valor de catalogoIdentificaciones en vista (catalogo)" . var_export ($catalogoIdentificaciones, true));

} elseif ($usuario["rol"] == "Coordinador Imss") {

    $catalogoRegistrosPatronales = $negocio->negocio_traeCatalogoRegistrosPatronales();
    $catalogoTiposTrabajadorImss = $negocio->negocio_traeCatalogorTipoTrabajadorImss();
    $catalogoMotivoBajaImss      = $negocio->traeCatalogorMotivoBajaImss();
    $catalogoPeriodos            = $negocio->getTiposPeriodos();
    $catatoloClientes            = $negocio->negocio_obtenerListaClientes();
    //$log->LogInfo("Valor de catalogoRegistrosPatronales en vista (catalogo)" . var_export ($catalogoRegistrosPatronales, true));
    //$log->LogInfo("Valor de catalogoTiposTrabajadorImss en vista (catalogo)" . var_export ($catalogoTiposTrabajadorImss, true));

} elseif ($usuario["rol"] == "Supervisor" || $usuario["rol"] == "Analista Asistencia" || $usuario["rol"] == "Consulta Supervisor" || $usuario["rol"] == "Facturacion" || $usuario["rol"] == "Ventas" || $usuario["rol"] == "Finanzas" || $usuario["rol"] == "Administracion Seguridad Electronica") {

    $catalogoIncidencias            = $negocio->getCatalogoIncidencias();
    $catalogoMotivoIncidenciasEspeciales  = $negocio->getcatalogoMotivoIncidenciasEspeciales();
    $catalogoPeriodos               = $negocio->getTiposPeriodos();
    $catalogoIncidenciasEspeciales  = $negocio->getCatalogoIncidenciasEspeciales();
    $catalogoSupervisoresOperativos = $negocio->negocio_obtenerSupervisoresOperativos();
    $catatoloClientes               = $negocio->negocio_obtenerListaClientes();
    $catalogoEntidadesFederativas   = $negocio->negocio_obtenerListaEntidadesFeferativas();
    $catalogoEstatusFatigas         = $negocio->getEstatusFatiga();
    $catalogomunicipios             = $negocio->getcatalogomunicipios();

    $catalogoPuestosOperativos = $negocio->obtenerCatalogoPuestoPorTipoPuesto('03', 1);

} elseif ($usuario["rol"] == "Asistencia Administrativo") {

    $catalogoIncidencias           = $negocio->negocio_getIncidenciasAdmin();
    $catalogoMotivoIncidenciasEspeciales  = $negocio->getcatalogoMotivoIncidenciasEspeciales();
    $catalogoPeriodos              = $negocio->getTiposPeriodos();
    $catalogoIncidenciasEspeciales = $negocio->getCatalogoIncidenciasEspeciales();
    $catatoloClientes              = $negocio->negocio_obtenerListaClientes();
    $catalogoEntidadesFederativas  = $negocio->negocio_obtenerListaEntidadesFeferativas();

} elseif ($usuario["rol"] == "Asistencia Administrativa SES") {

    $catalogoIncidencias           = $negocio->negocio_getIncidenciasAdmin();
    $catalogoMotivoIncidenciasEspeciales  = $negocio->getcatalogoMotivoIncidenciasEspeciales();
    $catalogoPeriodos              = $negocio->getTiposPeriodos();
    $catalogoIncidenciasEspeciales = $negocio->getCatalogoIncidenciasEspeciales();
    $catatoloClientes              = $negocio->negocio_obtenerListaClientes();
    $catalogoEntidadesFederativas  = $negocio->negocio_obtenerListaEntidadesFeferativas();

} elseif ($usuario["rol"] == "Asistencia Administrativa ST") {

    $catalogoIncidencias           = $negocio->negocio_getIncidenciasAdmin();
    $catalogoMotivoIncidenciasEspeciales  = $negocio->getcatalogoMotivoIncidenciasEspeciales();
    $catalogoPeriodos              = $negocio->getTiposPeriodos();
    $catalogoIncidenciasEspeciales = $negocio->getCatalogoIncidenciasEspeciales();
    $catatoloClientes              = $negocio->negocio_obtenerListaClientes();
    $catalogoEntidadesFederativas  = $negocio->negocio_obtenerListaEntidadesFeferativas();

} elseif ($usuario["rol"] == "Administrador") {

    $catalogoEntidadesFederativas = $negocio->negocio_obtenerListaEntidadesFeferativas();
    $getRolesUsuario              = $negocio->getRolesUsuario();
    $catalogoLineaNegocio         = $negocio->negocio_obtenerListaLineaNegocio();
    //$log->LogInfo("Valor de catalogoRegistrosPatronales en vista (catalogo)" . var_export ($catalogoRegistrosPatronales, true));
    //$log->LogInfo("Valor de catalogoTiposTrabajadorImss en vista (catalogo)" . var_export ($catalogoTiposTrabajadorImss, true));

} elseif ($usuario["rol"] == "Almacen") {

    $catalogoProveedores          = $negocio->obtenerProveedores();
    $catalogoBancos               = $negocio->obtenerBancosEmpresa();
    $catalogoTipoUniforme         = $negocio->getTipoUniformes();
    $catalogoLineaNegocio         = $negocio->negocio_obtenerListaLineaNegocio();
    $catalogoEntidadesFederativasparaalmacen = $negocio->negocio_obtenerListaEntidadesFeferativasParaAlmacen();
    $catalogoTiposMercancia       = $negocio->getTiposMercancia();
} elseif ($usuario["rol"] == "Contabilidad") {

    $catalogoPeriodos = $negocio->getTiposPeriodos();

} elseif ($usuario["rol"] == "Cliente") {

    if ($usuario["usuario"] == 'gif_at') {
        $cliente = 98;
    }else if ($usuario["usuario"] == 'grupo_gif') {
        $cliente = 2;
    }else if ($usuario["usuario"] == 'gif_sonicp') {
        $cliente = 8;
    }else if ($usuario["usuario"] == 'gif_medsur') {
        $cliente = 3;
    }else if ($usuario["usuario"] == 'gif_hosmig') {
        $cliente = 1;
    }else if ($usuario["usuario"] == 'gif_globus') {
        $cliente = 17;
    }else if ($usuario["usuario"] == 'gif_culina') {
        $cliente = 11;
    }else if ($usuario["usuario"] == 'gif_panacc') {
        $cliente = 10;
    }else if ($usuario["usuario"] == 'gif_rescom') {
        $cliente = 5;
    }
    $entidadesCliente = $negocio->negocio_traerEntidadesCliente($cliente);
}

?>
<!doctype html>
<html lang="es">
    <head>

        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
        <title>Grupo Gif Seguridad</title>
            <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-checkbox.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrapv3.css">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css">
    <link href="css/fileinput.css" media="all" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="css/dataTables.keyTable.css">
    <link rel="stylesheet" type="text/css" href="css/shCore.css">
    <link rel="stylesheet" type="text/css" href="css/tooltipster.bundle.min.css">
    <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
    <!--  <link rel="stylesheet" type="text/css" href="css/estiloCheck.css"/> -->
    <!--  <link rel="stylesheet" type="text/css" href="css/example.css">  -->

    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/buttons.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/bootstrap-select.css"/>
    



    <link rel="stylesheet" type="text/css" href="jquery.confirm/jquery.confirm.css" />

    <!--<link rel="stylesheet" type="text/css" href="css/demo.css">-->

    <link rel="icon" type="image/jpg" href="img/logoGif.jpg" />
    <!-- Llamada al nuevo bootrap 4 para actulizar la base a carpetas ---------------------------------------------------->
    <!-- <link rel="stylesheet" type="text/css" href="css-Bootstrap-V4.1.3/css/bootstrap.min.css"/> -->
    <link  href="css-Bootstrap-V4.1.3/css/bootstrap.min.css" >
    <script type="text/javascript" language="javascript" src="css-Bootstrap-V4.1.3/popper.min.js"></script>
    <script type="text/javascript" language="javascript" src="css-Bootstrap-V4.1.3/js/bootstrap.min.js"></script>
    <!-- <link rel="stylesheet" href="css-Bootstrap-V4.1.3/popper.min.js"> -->
    <!-- <link rel="stylesheet" href="css-Bootstrap-V4.1.3/js/bootstrap.min.js"> -->
    <!-------------------------------------------------------------------------------------------------------------------->
    <link rel="stylesheet" type="text/css" href="css/botonesConEstilo.css">
    <!--<script type="text/javascript" src="js/jquery-2.1.3.js"></script> -->
    <script type="text/javascript" src="js/jquery-2.1.1.js"></script>
    <!--<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>-->
    <script type="text/javascript" src="js/bootstrap-checkbox.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>
    <script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
    <script type="text/javascript" language="javascript" src="js/dataTables.keyTable.js"></script>
    <script type="text/javascript" language="javascript" src="js/shCore.js"></script>
    <script type="text/javascript" language="javascript" src="js/sketch.js"></script>

    <script type="text/javascript" language="javascript" src="js/sketch.min.js"></script>
    <script type="text/javascript" language="javascript" src="js/jquery.contextmenu.r2.packed.js"></script>
    <script type="text/javascript" language="javascript" src="js/jquery.contextmenu.r2.js"></script>
    <script type="text/javascript" language="javascript" src="js/tooltipster.bundle.min.js"></script>
    <script src="js/jquery.datetimepicker.full.js"></script>

    <script src="jquery.confirm/jquery.confirm.js"></script>

    <!--<script type="text/javascript" language="javascript" src="js/demo.js"></script>-->

    <!--<script type="text/javascript" src="js/jquery-ui11.js"></script> -->
    <script src="js/fileinput.min.js" type="text/javascript"></script>

    <script src="js/notify.min.js" type="text/javascript"></script>
    <script src="js/bootstrap-waitingfor.js" type="text/javascript"></script>

    <!-- <script type="text/javascript" language="javascript" src="js/jquery-1.12.3.js"></script> -->
    <script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="css/css/font-awesome.min.css">
    <script type="text/javascript" language="javascript" src="js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="js/buttons.flash.min.js"></script>
    <script type="text/javascript" language="javascript" src="js/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="js/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="js/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript" src="js/buttons.print.min.js"></script>
    <script type="text/javascript" language="javascript" src="js/bootstrap-select.js"></script>

    <script type="text/javascript" language="javascript" src="js/geo.js" ></script>
    <script type="text/javascript" language="javascript" src="js/moments.js" ></script>
    <script type="text/javascript" language="javascript" src="js/moment-with-locales.js" ></script>
    <!--------------------------------- Llamadas al nuevo boostrap 4 que se utilizaran en las carpetas separadas  --------------------------------------------->
    <script type="text/javascript" language="javascript" src="css-Bootstrap-V4.1.3/js/sweetalert.min.js"></script>
    <!--------------------------------------------------------------------------------------------------------------------------------------------------------->

    <!-- <script type="text/javascript" language="javascript" src="js/jquery-ui-personalized-1.6rc6.min.js"></script> -->

    <script type="application/dart" src="js/example.dart"></script>


</head>
<body>
    <div id="alertMsg"></div>

    <?php
        $currentTimestamp = time();
        $currentDiaSemana = date("w", $currentTimestamp);
        if($currentDiaSemana =="1" || $currentDiaSemana =="3"){
         $DiaSemana="#AED6F1";
         $DiaSemana1="#D6EAF8";
        }else if($currentDiaSemana =="2" ||$currentDiaSemana =="4"){
         $DiaSemana="#D2B4DE";
         $DiaSemana1="#E8DAEF";
        }else if($currentDiaSemana =="5"){
         $DiaSemana="#FDEBD0";
         $DiaSemana1="#FEF5E7";
        }else if($currentDiaSemana =="6" || $currentDiaSemana =="7"){
         $DiaSemana="#CEF1CA";
         $DiaSemana1="#D4EFDF";
        }
    ?>


    <div class="tabbable " >
        <ul class="nav nav-tabs" style="background-color:<?php echo $DiaSemana;?>;">
            <li class="active" ><a href="#contenedorUno"  data-toggle="tab" ><img src="img/logoGif.jpg" width="20">Bienvenido(a) <strong ><u><em><?php echo $usuario['nombre']; ?></em></u></strong><img src="img/user.png"></a></li>
            <?php
            if ($usuario["rol"] == "Contrataciones" ) {
                ?>
                <li ><a href="#contenedor" data-toggle="tab">Registro<img src="img/addVisitante.png"> </a></li>
            <!--    <li ><a href="#contenedorCurp" data-toggle="tab">Comparación Curp<img src="img/addVisitante.png"> </a></li>  -->
                <li ><a href="#contenedorConsultaEmpleado" data-toggle="tab">Consulta Empleado <img src="img/searchEmpleado.png"> </a></li>
                <li ><a href="#contenedorhistoricoedicion" data-toggle="tab">Historico ediciones<img src="img/icon-cv.png" style="width: 14%" > </a></li>
                <li ><a href="#contenedorSolicitudBaja" data-toggle="tab">Solicitud de bajas <img src="img/bajaEmpleado.png"> </a></li>

                <li class="dropdown">
                       <a class="dropdown-toggle" data-toggle="dropdown" href="#">Finiquitos<img src="img/icon-finiquito.png" style="width: 25%">
                           <span class="caret"></span></a>
                               <ul class="dropdown-menu">
                                <li ><a href="#FlujoFiniquito" data-toggle="tab">Estatus Finiquito</a></li>
                                <li ><a href="#contenedorFiniquitosentidad" data-toggle="tab">Consulta Finiquitos</a></li>
                            </ul>
                    </li>

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Reportes  <img src="img/Bulleted-List-icon.png">
                        <span class="caret"></span></a>

                        <ul class="dropdown-menu">
                            <li><a href="#reportePersonalActivo" data-toggle="tab">Consulta General</a></li>
                            <li><a href="#reportePersonalCapturado" data-toggle="tab">Consultar por Fecha de Captura</a></li>
                            <li><a href="#reporteBajasPersonal" data-toggle="tab">Consultar Bajas por Fecha Captura</a></li>
                            <li><a href="#reporteRequisiciones" data-toggle="tab">Requisiciones solicitadas por ventas</a></li>
                            <li ><a href="#permanenciaContrataciones" data-toggle="tab">Permanencia</a></li>
                            <li ><a href="#contenedorRotacionSupC" data-toggle="tab">Rotacion por supervisor</a></li>
                            <li><a href='#consultaAsistencia' data-toggle='tab'>Consulta Asistencia</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Indicadores<img src="img/Bulleted-List-icon.png">
                            <span class="caret"></span></a>

                            <ul class="dropdown-menu">
                                <li><a href="#reporteReclutadores" data-toggle="tab">Índice de rotacion x reclutador</a></li>
                                <li><a href="#indiceRotacionGeneral" data-toggle="tab">Índice de rotacion x mes</a></li>
                                <li><a href="#indiceRotacionEntidad" data-toggle="tab">Índice de rotacion entidades</a></li>
                                <li><a href="#reporteProductividadReclutadores" data-toggle="tab">Productividad</a></li>

                            </ul>
                        </li>

                        <li ><a href="#renovacionCredenciales" data-toggle="tab">Renovacion de credencial <img src="img/id-card-icon.png"> </a></li>
                        <!--<li ><a href="#contenedorRequisicionesPersonal" data-toggle="tab">Requisiciones de personal <img src="img/Groups-icon.png"> </a></li>-->
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Plantillas<img src="img/Bulleted-List-icon.png">
                            <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li ><a href="#contenedorPlantillas" data-toggle="tab">Plantillas(General)</a></li>
                                <li ><a href="#contenedorVacantes" data-toggle="tab">Vacantes(Plantillas)</a></li>
                                <li ><a href="#plantillaSupervisorContrataciones" data-toggle="tab">Plantilla Supervisor</a></li>
                                <li ><a href="#contenedordocumentoEmpelados" data-toggle="tab">Reporte Documentos</a></li>
                                <li ><a href="#reporteDocumentosXContratante" data-toggle="tab">Detalle de Pendientes Administrativos</a></li>
                            </ul>
                        </li>
                        <li ><a href="#consultaEstatusImss" data-toggle="tab">Consulta estatus Imss <img src="img/iconEstatusRHIMSS.png"> </a></li>

                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Control Incidencias <img src="img/Bulleted-List-icon.png">
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li ><a href="#contenedorArchivosIncapacidad" data-toggle="tab">Archivos Incapacidad </a></li>
                                <li ><a href="#contenedorArchivosVacaciones" data-toggle="tab">Reporte Vacaciones </a></li>
                                <li ><a href="#contenedorArchivoBajaEmpleado" data-toggle="tab">Reporte Bajas </a></li>
                                <li ><a href="#HistoricoVetoElementos" data-toggle="tab">Historico Veto De Elementos </a></li>
                            </ul>
                        </li>
                         <li ><a href="#contenedorRegistroVacacionesPendientesAdmin" data-toggle="tab">Vacaciones Pendientes <img src="img/icon-cv.png" style="width: 14%"> </a></li>
                         <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Tarjetas Despensa<img src="img/Bulleted-List-icon.png">
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li ><a href="#recibirtarjetas" data-toggle="tab">Recibir tarjetas</a></li>
                                <li><a href="#contenedorDistribucionTarjetas" data-toggle="tab">Stock Tarjetas</a></li>
                                <li><a href="#contenedorAsignacionTarjetaAEmpleado" data-toggle="tab">Reporte Entrega Tarjetas</a></li>
                            </ul>
                        </li>

                        <?php
                    }
                    ?>

                    <?php
                    if ($usuario["rol"] == "Lider Unidad") {
                        ?>
                        <li ><a href="#contenedor" data-toggle="tab">Registro<img src="img/addVisitante.png"> </a></li>
                        <li ><a href="#contenedorConsultaEmpleado" data-toggle="tab">Consulta Empleado <img src="img/searchEmpleado.png"> </a></li>
                        <li ><a href="#contenedorSolicitudBaja" data-toggle="tab">Solicitud de bajas <img src="img/bajaEmpleado.png"> </a></li>
                        
                         <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Finiquitos <img src="img/icon-finiquito.png" width="23px">
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">


                        <li ><a href="#contenedorFiniquitosentidad" data-toggle="tab">Consulta Finiquitos</a></li>
                        <li ><a href="#FlujoFiniquito" data-toggle="tab">Estatus Finiquito</a></li>
                        <li ><a href="#ProcesoDeFirmaDelFiniquito5" data-toggle="tab">Proceso De Firma Del Finiquito</a></li>
                        <li ><a href="#HistoricoMovimientosFiniquitosPago1" data-toggle="tab">Historico De Movimientos Del Finiquito</a></li>

                               </ul>
                        </li>
                        <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Indicadores<img src="img/Bulleted-List-icon.png">
                            <span class="caret"></span></a>

                            <ul class="dropdown-menu">
                                <li><a href="#reporteReclutadores" data-toggle="tab">Índice de rotacion x reclutador</a></li>
                                <li><a href="#indiceRotacionGeneral" data-toggle="tab">Índice de rotacion x mes</a></li>
                                <li><a href="#indiceRotacionEntidad" data-toggle="tab">Índice de rotacion entidades</a></li>
                                <li><a href="#reporteProductividadReclutadores" data-toggle="tab">Productividad</a></li>

                            </ul>
                        </li>

                        <!--<li ><a href="#contenedorRequisicionesPersonal" data-toggle="tab">Requisiciones de personal<img src="img/Groups-icon.png"> </a></li>-->
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Plantillas<img src="img/Bulleted-List-icon.png">
                            <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li ><a href="#contenedorPlantillas" data-toggle="tab">Plantillas(General)</a></li>
                                <li ><a href="#contenedorVacantes" data-toggle="tab">Vacantes(Plantillas)</a></li>
                                <li ><a href="#plantillaSupervisorLiderU" data-toggle="tab">Plantilla Supervisor</a></li>
                                <li ><a href="#contenedordocumentoEmpeladosLU" data-toggle="tab">Reporte Documentos</a></li>
                                <li ><a href="#reporteDocumentosXContratanteLU" data-toggle="tab">Detalle de Pendientes Administrativos</a></li>
                            </ul>
                        </li>
                        <li><a href='#contenedorverpdf' data-toggle='tab'>Visualizar Archivos<img src="img/pdf.png" width="28px"></a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Control Incidencias <img src="img/Bulleted-List-icon.png">
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li ><a href="#contenedorArchivosIncapacidad" data-toggle="tab">Archivos Incapacidad </a></li>
                                <li ><a href="#contenedorArchivosVacaciones" data-toggle="tab">Reporte Vacaciones </a></li>
                                <li ><a href="#contenedorArchivoBajaEmpleado" data-toggle="tab">Reporte Bajas </a></li>
                                <li ><a href="#HistoricoVetoElementos" data-toggle="tab">Historico Veto De Elementos </a></li>
                            </ul>
                        </li>
                        <li><a href='#EstatusPeticionAsistenciaMermaLU' data-toggle='tab'>Estatus Peticiones Merma<img src="img/plantilla.png"></a></li>
                        <li ><a href="#permanenciaLU" data-toggle="tab">Permanencia</a></li>

                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Tarjetas Despensa<img src="img/Bulleted-List-icon.png">
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li ><a href="#recibirtarjetas" data-toggle="tab">Recibir tarjetas</a></li>
                                <li><a href="#contenedorDistribucionTarjetas" data-toggle="tab">Stock Tarjetas</a></li> 
                            </ul>
                        </li>

                        <?php
                    }
                    if ($usuario["rol"] == "Comprobacion Regional") {
                        ?>
                        <li ><a href="#contenedorComprobacionRegional" data-toggle="tab">Solicitud De Pago<img src="img/contratos.png" width="23px"> </a></li>
                        <li><a href='#contenedorsolicitudrecursos' data-toggle='tab'>Solicitar Recurso</a></li>
                        <li><a href='#contenedorcomprobacion' data-toggle='tab'>Comprobaciónes</a></li>
                        <?php
                    }
                    ?>
                    <?php
                    if ($usuario["rol"] == "Recepcion") {
                        ?>
                        <li id="spanLibroVisitas"><a id="spanVisitantes" href="#contenedorVisitante" data-toggle="tab">Libro De Visitas </a></li>
                        <li><a href="#contenedorConsulta" data-toggle="tab">Reporte de Visitantes</a></li>
                        <?php
                    }
                    ?>

                    <?php
                    if ($usuario["rol"] == "Tesoreria" or $usuario["rol"] == "Finanzas") {
                        ?>
                        <li><a id="contenedorRegistroMovimientos" href="#contenedorFinanzas" data-toggle="tab" onclick="cerrarpestaña();">Registro de Movimientos <img src="img/add.png"></a></li>
                        <li><a id="contenedorRegistroSaldosIniciales" href="#contenedorSaldosIniciales" data-toggle="tab">Saldos Iniciales <img src="img/money.png"></a></li>
                        <li><a id="contentenedorTranseferenciasBancarias" href="#TranseferenciasBancarias" data-toggle="tab">Transferencias Bancarias<img src="img/bank.png" style="width: 12%"></a></li>
                        
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Reportes<img src="img/Bulleted-List-icon.png"><span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a id="contentenedorTablacomprobacioesPagoFinanza" href="#TablacomprobacioesPagoFinanza" data-toggle="tab">Comprobaciones De Abonos<img src="img/bank.png" style="width: 12%"></a></li>
                                <li><a id="contentenedorTablaTipoGastoCosto" href="#TablaTipoGastoCosto" data-toggle="tab">Tipo Gasto-Costo<img src="img/bank.png" style="width: 12%"></a></li>
                                <!--<li><a href="#reporteTurnos" data-toggle="tab">Turnos Presupuestados vs Turnos Pagados</a></li>-->
                                <!--<li><a href="#reporteFacturacion" data-toggle="tab">Reporte Facturacion</a></li>-->
                                <li><a href="#reporteDetalleFacturacion" data-toggle="tab">Reporte Detalle Facturacion</a></li>
                                <!--<li><a href="#reporteConsultaFatigasEnviadas" data-toggle="tab">Reporte Fatigas Recibidas</a></li>-->
                                <!--<li><a href="#reporteCoberturaUtilidad" data-toggle="tab">Cobertura utilidad</a></li>-->
                            </ul>
                        </li>
                        <li><a id="contenedorAbonoCajas" href="#contenedorAbonoCaja" data-toggle="tab">Abono Caja <img src="img/add.png"></a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Nuevo<img src="img/Bulleted-List-icon.png">
                                <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#contenedorNuevoBanco" data-toggle="tab">Banco</a></li>
                                    <li><a href="#contenedorNuevaCuenta" data-toggle="tab">Cuenta Bancaria</a></li>
                                    <li><a href="#contenedorNuevaEmpresa" data-toggle="tab">Empresa</a></li>
                                </ul>
                            </li>

                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Solicitudes De Pagos<img src="img/Bulleted-List-icon.png">
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a id="contentenedorTablaSolicitudesDePagoFinanza" href="#TablaSolicitudesDePagoFinanza" data-toggle="tab">Solicitud De Recurso<img src="img/bank.png" style="width: 12%"></a></li>
                                <li><a id="contentenedorTablaSolicitudesDePagoFiniquito" href="#TablaSolicitudesDePagoFiniquito" data-toggle="tab">Solicitudes De Pago Finiquitos</a></li>
                                <li><a id="generarPago" href="#contGenerarPago" data-toggle="tab">Generar Pago</a></li>
                                <li ><a href="#HistoricoMovimientosFiniquitosPago11" data-toggle="tab">Historico De Movimientos Del Finiquito</a></li>
                            </ul>
                        </li>

                            <!--<li><a id="contenedorMenuReportes" href="#menuReportes" data-toggle="tab">Reportes <img src="img/chart.png"></a></li>-->
                            <!--<li><a id="contenedorMenuReportes" href="#menuReportes" data-toggle="tab">Reportes <img src="img/chart.png"></a></li>-->
                            <?php
                        }
                        ?>

                         <?php
                        if ($usuario["rol"] == "Finanzas") {
                            ?>
                            <li><a id="reporteFiniFaltante1" href="#reporteFiniFaltante" data-toggle="tab">Pasivo laboral</a></li>

                            <?php
                        }
                        ?>


                        <?php
                        if ($usuario["rol"] == "Tesoreria") {
                            ?>
                            <li><a id="contenerdorCargarArchivos1" href="#contenedorCargarArchivos" data-toggle="tab">Conciliacion <img src="img/upload.png"></a></li>

                            <?php
                        }
                        ?>

                        <?php
                        if ($usuario["rol"] == "Ventas") {
                            $catalogoTurnos       = $negocio->negocio_obtenerListaTurnos();
                            $catalogoLineaNegocio = $negocio->negocio_obtenerListaLineaNegocio();
                        ?>
                            <li><a id="contenerdorRegistroCliente1" href="#contenerdorRegistroCliente" data-toggle="tab">Registro Cliente  <img src="img/iconAddCliente.png"></a></li>
                            <li><a id="contenedorRegistroPunto1" href="#contenedorRegistroPunto" data-toggle="tab">Registro Punto Servicio <img src="img/iconLocalizacion.png"></a></li>
                            <li><a id="contenedorCatalogoClientes1" href="#contenedorCatalogoClientes" data-toggle="tab">Catalogo Clientes <img src="img/clients.png"></a></li>
                            <li><a id="contenedorCatalogoPuntosServicios1" href="#contenedorCatalogoPuntosServicios" data-toggle="tab">Catalogo Punto Servicio <img src="img/points.png"></a></li>
                            <li><a id="contenedorSueldos1" href="#contenedorSueldos" data-toggle="tab">Sueldos<img src="img/sueldoIcon.png"></a></li>

                            <li class="dropdown">
                               <a class="dropdown-toggle" data-toggle="dropdown" href="#">Plantillas<img src="img/Bulleted-List-icon.png">
                               <span class="caret"></span></a>
                               <ul class="dropdown-menu">
                                   <li ><a href="#contenedorPlantillas" data-toggle="tab">Plantillas(General)</a></li>
                                   <li ><a href="#contenedorVacantes" data-toggle="tab">Vacantes(Plantillas)</a></li>
                                   <li ><a href="#plantillaSupervisorVentas" data-toggle="tab">Plantilla Supervisor</a></li>

                               </ul>
                            </li>

                            <li ><a href="#servEventuales" data-toggle="tab">Servicios Eventuales<img src="img/icon-trabajo.png"> </a></li>

                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Reportes  <img src="img/Bulleted-List-icon.png">
                                <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#reporteDetalleFacturacion" data-toggle="tab">Reporte Detalle Facturacion</a></li>
                                    </ul>
                            </li>

                                <!--<li><a id="contenedorPlantillasExcedidasVentas1" href="#contenedorRequisicionesPersonal" data-toggle="tab">Plantillas Excedidas<img src="img/warningbw.png"></a></li>-->
                                <li><a href="#reporteRequisiciones" data-toggle="tab">Requisiciones solicitadas por ventas</a></li>
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Actualicaciones<img src="img/Bulleted-List-icon.png">
                                    <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#actualizacionFechaServicio" data-toggle="tab">Renovación de puntos</a></li>
                                            <li><a href="#actualizacionFechaRequisicion" data-toggle="tab">Renovación de requisiciones</a></li>
                                            <li><a href="#ActualizacionTiposContratos" data-toggle="tab">Edicion Tipos De Contratos</a></li>
                                            <li><a href="#ActualizacionRolOperativo" data-toggle="tab">Edicion Roles Operativos</a></li>
                                            <li><a href="#CatalogoJornadasAdmin" data-toggle="tab">Catalogo Jornadas</a></li>
                                            <li><a href="#CatalogoHorariosAdmin" data-toggle="tab">Catalogo Horarios</a></li>
                                        </ul>
                                </li>
                                <li><a href="#reportePersonalPorFecha" data-toggle="tab">Consulta General Por Fechas</a></li>

                                    <?php
                                }
                                ?>

                                <?php
                                if ($usuario["rol"] == "Coordinador Imss") {
                                    ?>
                                    <!-- <li><a id="contenerdorConfirmacionImss1" href="#contenerdorConfirmacionImss" data-toggle="tab">Confirmacion Alta Imss<img src="img/okUser.png"></a></li> -->
                                    <!--<li><a id="contenerdorConfirmacionImss1" href="#contenerdorConfirmacionImss" data-toggle="tab">Confirmación Alta Imss<img src="img/okUser.png"></a></li> -->
                                    <?php 
                                    if($usuario["usuario"] == "imssgif"  || $usuario["usuario"] == "vanessa" || $usuario["usuario"] == "monse*3"){
                                       ?>

                                       <li><a id="contenerdorPrueba1" href="#contenerdorPrueba" data-toggle="tab">Generar TXT Altas<img src="img/cuadroA.png"></a></li>
                                       <li><a id="contenerdorConfirmacionImss1" href="#contenerdorConfirmacionImss" data-toggle="tab">Confirmación de alta Imss<img src="img/cuadroA.png"></a></li>
                                       <li><a id="contenerdorEmpleadosSinBajaImss1" href="#contenerdorEmpleadosSinBajaImss" data-toggle="tab">Generar txt baja Imss<img src="img/xUser.png" width="23px"></a></li>
                                       <li><a id="contenerdorConfirmacionBaja1" href="#contenerdorConfirmacionBaja" data-toggle="tab">Confirmación de baja Imss<img src="img/xUser.png" width="23px"></a></li>
                                       <li class="dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Modificación De Salario<img src="img/icon-billete.png" width="23px">
                                            <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a id="contenerdorCuadroAntig1" href="#contenerdorCuadroAntig" data-toggle="tab">Cuadro Antigüedad </a></li>
                                            <li><a id="contenerdorActualizarSueldosGeneral1" href="#contenerdorActualizarSueldosGeneral" data-toggle="tab">Actualización SBC</a></li>
                                            <li><a id="pendientesCambioRP1" href="#pendientesCambioRP" data-toggle="tab">Cambios RP</a></li>
                                        </ul>
                                    </li>

                                       <?php
                                   }
                                   ?>
                                   <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Deducciones  <img src="img/icon-billete.png" width="23px">
                                        <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#contenedorFonacotF" data-toggle="tab">Fonacot_Finiquito</a></li>
                                            <li><a href="#contenedorPensionF" data-toggle="tab">Pensión_Finiquito</a></li>
                                            <li><a href="#contenedorInfonavitF" data-toggle="tab">Amortización (Infonavit)</a></li>
                                            <li><a href="#contenedorInfonavitN" data-toggle="tab">Amortización_Nomina</a></li>
                                            <li><a href="#contenedorFonacotN" data-toggle="tab">Fonacot_Nomina</a></li>
                                            <li><a href="#contenedorPensionN" data-toggle="tab">Pensión_Nomina</a></li>            
                                            <!-- <li><a href="#contenedorDescargaConta" data-toggle="tab">Descarga de Archivos</a></li> -->
                                        </ul>
                                    </li>

                                    <?php 
                                    if($usuario["usuario"] == "imssgif" || $usuario["usuario"] == "vanessa" || $usuario["usuario"] == "monse*3"){
                                        ?>
                                        <li ><a href="#contentAfill" data-toggle="tab">Documento AFIL-06<img src="img/icon_folder.png" width="23px"> </a></li>
                                        
                                        <li class="dropdown">
                                             <a class="dropdown-toggle" data-toggle="dropdown" href="#">Finiquitos<img src="img/icon-finiquito.png" style="width: 25%">
                                                 <span class="caret"></span></a>
                                                     <ul class="dropdown-menu">
   
                                                <li ><a href="#FlujoFiniquito" data-toggle="tab">Estatus Finiquito</a></li>
                                                <li ><a href="#contenedorFiniquito" data-toggle="tab">Consulta Finiquitos</a></li>                                                
                                                <li ><a href="#HistoricoAcuerdosLaborales" data-toggle="tab">Historico Acuerdos Laborales</a></li>

                                                  </ul>
                                          </li>

                                    <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Carga de informacion
                                        <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                        <li ><a href="#contentPagoSua" data-toggle="tab">Pago SUA<img src="img/icon-imss.png" width="23px"> </a></li>
                                        <li><a href="#opinionCumplimientosInfonavit" data-toggle="tab">Opinion de cumplimientos INFONAVIT</a></li>
                                        <li><a href="#opinionCumplimientosIMSS" data-toggle="tab">Opinion de cumplimientos IMSS</a></li>
                                        <li ><a href="#cargaIDSE" data-toggle="tab">Carga IDSE</a></li>
                                            <li><a href="#formularioICSOE" data-toggle="tab">ICSOE</a></li>
                                            <li><a href="#formularioSISUB" data-toggle="tab">SISUB</a></li>
                                            <li><a href="#formularioXML" data-toggle="tab">XML</a></li>
                                            <li ><a href="#edicionPSEMAEBA" data-toggle="tab">Edición</a></li>
                                            <li ><a href="#movimientosImss" data-toggle="tab">Movimientos</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">IMSS
                                        <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                        <li ><a href="#contenedorEma" data-toggle="tab">Consulta EMA<img src="img/icon-imss.png" width="23px"> </a></li>
                                        <li ><a href="#contenedorEva" data-toggle="tab">Consulta EBA<img src="img/icon-casa.png" width="23px"> </a></li>
                                        <li ><a href="#provision" data-toggle="tab">Provision</a></li>
                                        </ul>
                                    </li>


                                        <li ><a href="#consultaEstatusImss" data-toggle="tab">Consulta estatus Imss <img src="img/iconEstatusRHIMSS.png"> </a></li>
                                        <li ><a href="#permanenciaIMSS" data-toggle="tab">Permanencia</a></li>

                                        <li class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Cumplimiento Fiscal Laboral
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      <li ><a href="#detalleContrato" data-toggle="tab">Detalle de contrato</a></li>
                      <li ><a href="#detalleTrabajadores" data-toggle="tab">Detalle de trabajadores</a></li>
                      <li ><a href="#detalleSujetoObligado" data-toggle="tab">Detalle de sujeto obligado</a></li>
                      <li ><a href="#documentoEscrituraConstitutivaIMSS" data-toggle="tab">Escritura Constitutiva</a></li>
                      <li ><a href="#documentoREPSEimss" data-toggle="tab">REPSE</a></li>
                    </ul>
                </li>




                <!--<li><a id="contenedorRegistroServicio1" href="#contenedorRegistroServicio" data-toggle="tab">Registro Servicio<img src="img/cuadroA.png"></a></li>
                    <li><a id="contenerdorTable111" href="#contenerdorTable11" data-toggle="tab">ejercicio2<img src="img/okUser.png"></a></li> agregarAqui -->
                    <?php
                }
                ?>

                <?php 
                    if($usuario["usuario"] != "rauz*1"){
                ?>
                <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Control Incidencias <img src="img/Bulleted-List-icon.png">
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li ><a href="#contenedorArchivosIncapacidad" data-toggle="tab">Archivos Incapacidad </a></li>
                                <li ><a href="#contenedorArchivosVacaciones" data-toggle="tab">Reporte Vacaciones </a></li>
                                <li ><a href="#contenedorArchivoBajaEmpleado" data-toggle="tab">Reporte Bajas </a></li>
                            </ul>
                        </li>

                <li ><a href="#semaforoImss" data-toggle="tab">Semaforo imss</a></li>
                
                <?php
                }
                ?>
                
                <?php
            }
            ?>



            <?php
            if ($usuario["rol"] == "Administrador") {
                ?>

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Administración de usuarios <img src="img/Bulleted-List-icon.png">
                        <span class="caret"></span></a>

                        <ul class="dropdown-menu">
                            <li><a href="#contenedorNuevoUsuario" data-toggle="tab">Nuevo usuario</a></li>
                            <li><a href="#contenedorNuevoSuperUsuario" data-toggle="tab">Super usuario</a></li>
                            <li><a href="#contenedorEdicionUsuario" data-toggle="tab">Edición usuario</a></li> 
                            <li><a href="#contenedorBloqueoUsuario" data-toggle="tab">Bloqueo de usuario</a></li>
                            <!-- <li><a href='#ModificacionRegiones' data-toggle='tab'>Matriz De Regiones</a></li> -->
                            <!-- <li><a href='#relacionUsuarioRegión' data-toggle='tab'>Asignación de matriz</li> -->
                        </ul>
                    </li>

                    <li class="dropdown">
                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">Regiones<img src="img/Bulleted-List-icon.png">
                        <span class="caret"></span>
                    </a>
                      <ul class="dropdown-menu">
                        <li><a href='#ModificacionRegiones' data-toggle='tab'>Matriz De Regiones</a></li>
                        <li><a href='#relacionUsuarioRegión' data-toggle='tab'>Asignación de matriz</li>
                      </ul>
                    </li>
                    <?php
                }
                ?>

                <?php
    if ($usuario["rol"] == "Gestion Administrativa") { 
        ?>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Administración de matrices <img src="img/Bulleted-List-icon.png">
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="#contenedorNuevaMatriz" data-toggle="tab">Nueva Matriz</a></li>
                <li><a href="#contenedorEdicionMatriz" data-toggle="tab">Edición Matriz</a></li> 
                <li><a href="#contenedorAsignacionMatriz" data-toggle="tab">Asignar Matriz</a></li> 
                <li><a href="#contenedorSucursales" data-toggle="tab">Sucursales</a></li> 
            </ul>
        </li>
<?php
}
?>

                <?php
                if ($usuario["rol"] == "Socioeconomico" || $usuario["rol"] == "Consulta Rh") {
                    ?>
                    <li ><a href="#contenedorConsultaEmpleado" data-toggle="tab">Consulta Empleado <img src="img/searchEmpleado.png"> </a></li>
                    <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Plantillas<img src="img/Bulleted-List-icon.png">
                            <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li ><a href="#contenedorPlantillas" data-toggle="tab">Plantillas(General)</a></li>
                                <li ><a href="#contenedorVacantes" data-toggle="tab">Vacantes(Plantillas)</a></li>
                                <li ><a href="#plantillaSupervisorEconomicoyConsultaRH" data-toggle="tab">Plantilla Supervisor</a></li>
                            </ul>
                        </li>
                    <li ><a href="#contentCapacitacion" data-toggle="tab">Formato Capacitación <img src="img/icon-protesta.png" width="25"> </a></li>
                    <li ><a href="#contentPermiso" data-toggle="tab">Permiso Federal <img src="img/icon-guardia.png" width="25"> </a></li>
                    <li ><a href="#contentPermisoLocal" data-toggle="tab">Permiso Local <img src="img/icon-guardia.png" width="25"> </a></li>
                    <li ><a href="#contentC3" data-toggle="tab">Documento DC-3 <img src="img/hojaDatos.png" width="25"> </a></li>

                    <?php
                }
                ?>
                <?php
                if ($usuario["rol"] == "Reclutador") {
                    ?>

                      <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Uniformes<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li> <a href='#asignacionUniformeReclutador' data-toggle='tab'>Asignacion Uniformes</a></li>
                                <li><a href='#historicoAsigReclu' data-toggle='tab'>Historico Asignacion Uniformes</a></li>
                            </ul>
                        </li>

                    <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Plantillas<img src="img/Bulleted-List-icon.png">
                            <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li ><a href="#contenedorPlantillas" data-toggle="tab">Plantillas(General)</a></li>
                                <li ><a href="#contenedorVacantes" data-toggle="tab">Vacantes(Plantillas)</a></li>
                                <li ><a href="#plantillaSupervisorReclutador" data-toggle="tab">Plantilla Supervisor</a></li>
                            </ul>
                        </li>
                    <li ><a href="#contenedorNuevoGuardia" data-toggle="tab">Registro Aspirante <img src="img/icon-cv.png" width="25"> </a></li>
                    <li ><a href="#contenedorPreseleccion" data-toggle="tab">Consulta Preselección <img src="img/icon-tarea.png" width="25"> </a></li>
                    <?php
                }
                ?>


                <?php
                if ($usuario["rol"] == "Supervisor") {
                    ?>
                    <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Uniformes<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href='#asignacionUniformeSupervisor' data-toggle='tab'>Asignacion Uniformes</a></li>
                                <li><a href='#historicoAsigSup' data-toggle='tab'>Historico Asignacion Uniformes</a></li>
                            </ul>
                        </li>
                    <li><a href='#asistenciaPeriodo1' data-toggle='tab'>Registro Asistencia <img src="img/checkAsistencia.png"></a></li>
                    <li><a href='#consultaAsistencia' data-toggle='tab'>Consulta Asistencia</a></li>
                    <li ><a href="#contenedorSolicitudBaja" data-toggle="tab">Solicitudes de bajas <img src="img/bajaEmpleado.png"> </a></li>
                    <li ><a href="#contenedorFatiga" data-toggle="tab">Fatiga <img src="img/download.png"></a></li>
                    <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Plantillas<img src="img/Bulleted-List-icon.png">
                            <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li ><a href="#contenedorPlantillas" data-toggle="tab">Plantillas(General)</a></li>
                                <li ><a href="#contenedorVacantes" data-toggle="tab">Vacantes(Plantillas)</a></li>
                                <li ><a href="#plantillaSupervisorSup" data-toggle="tab">Plantilla Supervisor</a></li>
                            </ul>
                        </li>
                    <li ><a href="#servEventuales" data-toggle="tab">Servicios Eventuales<img src="img/icon-trabajo.png"> </a></li>
                    <li ><a href="#contenedorAsistenciaAP" data-toggle="tab">Guardias <img src="img/icon-guardia.png" width="30"> </a></li>
                    <li ><a href="#contenedorSupervisiones" data-toggle="tab">Supervisiones <img src="img/icon-supervisor.png" width="30"> </a></li>
                    <li><a href='#conteoincidenciasDia' data-toggle='tab'>Porcentaje Cobertura<img src="img/download.png"></a></li>
                    <li><a href='#contenedorverpdf' data-toggle='tab'>Visualizar Archivos<img src="img/pdf.png" width="28px"></a></li>
                    <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Control Incidencias <img src="img/Bulleted-List-icon.png">
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li ><a href="#contenedorArchivosIncapacidad" data-toggle="tab">Archivos Incapacidad </a></li>
                                <li ><a href="#contenedorArchivosVacaciones" data-toggle="tab">Reporte Vacaciones </a></li>
                                <li ><a href="#contenedorArchivoBajaEmpleado" data-toggle="tab">Reporte Bajas </a></li>
                            </ul>
                        </li>
                    <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Reportes  <img src="img/Bulleted-List-icon.png">
                                <span class="caret"></span></a>

                                <ul class="dropdown-menu">
                                    <li><a href="#reporteAsistencia" data-toggle="tab">Detalle de asistencia</a></li>
                                    <li><a href="#reporteIE" data-toggle="tab">Incidencias Especiales</a></li>
                                    <li ><a href="#contenedorRotacionSupS" data-toggle="tab">Rotacion por supervisor</a></li>
                                </ul>
                            </li>
                    <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Finiquitos <img src="img/icon-finiquito.png" width="23px">
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">

                        <li ><a href="#FlujoFiniquito" data-toggle="tab">Estatus Finiquito</a></li>
                               </ul>
                        </li>

                     <li><a href='#EstatusPeticionAsistenciaMermaS' data-toggle='tab'>Estatus Peticiones Merma<img src="img/plantilla.png"></a></li>
                     <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Reporte Incidencias <img src="img/Bulleted-List-icon.png">
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li ><a href="#RevisionReporteIncidenciaCentroControl" data-toggle="tab">Revisión Reporte Incidencia</a></li>
                            <li ><a href="#HistoricoReporteIncidenciaCentroControl" data-toggle="tab">Historico Reporte Incidencia</a></li>
                        </ul>
                    </li>

                    <li><a href="#contenedorKpiSupervisor" data-toggle="tab">KPI Supervisor<img src="img/kpi.png" width="23px"></a></li>

                    <?php
                }
                ?>

                <?php
                if ($usuario["rol"] == "Analista Asistencia") {
                    ?>
                    <li ><a href="#contenedorhistoricoedicion" data-toggle="tab">Historico ediciones<img src="img/icon-cv.png" style="width: 14%" > </a></li>
                    <li><a href='#asistenciaPeriodo1' data-toggle='tab'>Registro Asistencia <img src="img/checkAsistencia.png"></a></li>
                    <li><a href='#consultaAsistencia' data-toggle='tab'>Consulta Asistencia <img src="img/searchMenu.png"></a></li>
                    <li ><a href="#contenedorSolicitudBaja" data-toggle="tab">Solicitudes de bajas <img src="img/bajaEmpleado.png"> </a></li>
                    <li ><a href="#contenedorFatiga" data-toggle="tab">Fatiga <img src="img/download.png"></a></li>
                    <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Plantillas<img src="img/Bulleted-List-icon.png">
                            <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li ><a href="#contenedorPlantillas" data-toggle="tab">Plantillas(General)</a></li>
                                <li ><a href="#contenedorVacantes" data-toggle="tab">Vacantes(Plantillas)</a></li>
                                <li ><a href="#plantillaSupervisorAnalistaAsistencia" data-toggle="tab">Plantilla Supervisor</a></li>
                                <li ><a href="#GeoPuntos" data-toggle="tab">Geolocalización De Puntos</a></li>
                            </ul>
                        </li>
                    <li ><a href="#servEventuales" data-toggle="tab">Servicios Eventuales<img src="img/icon-trabajo.png"> </a></li>
                    <li ><a href="#contenedorAsistenciaAP" data-toggle="tab">Guardias <img src="img/icon-guardia.png" width="30"> </a></li>
                    <li ><a href="#contenedorSupervisiones" data-toggle="tab">Supervisiones <img src="img/icon-supervisor.png" width="30"> </a></li>
                    <li ><a href="#contenedorAsistenciaAdministrativos" data-toggle="tab">Asistencia Administrativos <img src="img/icon-supervisor.png" width="30"> </a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Asignaciones <img src="img/Bulleted-List-icon.png">
                            <span class="caret"></span></a>

                            <ul class="dropdown-menu">
                                <li ><a href="#contenedorAsignacionSupervisorPunto" data-toggle="tab">Asignacion de puntos</a></li>
                                <li><a href="#contenedorTransferencias" data-toggle="tab">Transferencias</a></li>
                            </ul>
                        </li>


                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Reportes  <img src="img/Bulleted-List-icon.png">
                                <span class="caret"></span></a>

                                <ul class="dropdown-menu">
                                    <li><a href="#reporteAsistencia" data-toggle="tab">Detalle de asistencia</a></li>
                                    <li><a href="#reporteIE" data-toggle="tab">Incidencias Especiales</a></li>
                                </ul>
                            </li>

                            <li><a href='#nominasGif' data-toggle='tab'>Comprobantes Nomina <img src="img/factura.png" width="20"></a></li>
                            <li><a href='#procesoNomina' data-toggle='tab'>Procesar <img src="img/lockMenu.png"></a></li>
                            <li><a href='#diferencias' data-toggle='tab'>Diferencias<img src="img/diferencias.png"></a></li>
                            <li><a href='#comentariosGuardias' data-toggle='tab'>Comentarios Guardias <img src="img/message.png"></a></li>
                            <li><a href='#conteoincidenciasDia' data-toggle='tab'>Porcentaje Cobertura<img src="img/download.png"></a></li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Control Incidencias <img src="img/Bulleted-List-icon.png">
                                    <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li ><a href="#contenedorArchivosIncapacidad" data-toggle="tab">Archivos Incapacidad </a></li>
                                    <li ><a href="#contenedorArchivosVacaciones" data-toggle="tab">Reporte Vacaciones </a></li>
                                    <li ><a href="#contenedorArchivoBajaEmpleado" data-toggle="tab">Reporte Bajas </a></li>

                                </ul>
                            </li>

                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Seperación Laboral <img src="img/Bulleted-List-icon.png">
                                    <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href='#DiasTrabajados' data-toggle='tab'>Dias Separación Laboral</a></li>
                                    <li><a href='#ConfirmacionPagoComplemento' data-toggle='tab'>Confirmacion Pago Complemento</a></li>
                                    <li><a href='#HistoricoComplementos' data-toggle='tab'>Historico Complementos</a></li>
                                </ul>
                            </li>
                            <li><a href='#PeticionesAsistenciaMerma' data-toggle='tab'>Peticiones Merma<img src="img/plantilla.png"></a></li>
                            <li><a href='#EstatusPeticionAsistenciaMerma' data-toggle='tab'>Estatus Peticiones Merma<img src="img/plantilla.png"></a></li>
                            <li><a href="#HistoricopeticionesTurnoCapacitacion" data-toggle="tab">Historico turno capacitacion</a></li>
                            <li><a id="ContenedorEstatusMovimientoTarjetaDespensa1" href="#ContenedorEstatusMovimientoTarjetaDespensa" data-toggle="tab">Reporte Tarjeta Si Vale<img src="img/cuadroA.png"></a></li>

                            <?php
                        }
                        ?>

                        <?php
                        if (strtolower($usuario["rol"]) == "facturacion"):
                            ?>


                            <li><a href='#consultaAsistencia' data-toggle='tab'>Consulta Asistencia</a></li>
                            <li ><a href="#contenedorFatiga" data-toggle="tab">Fatiga <img src="img/download.png"></a></li>
                            <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Plantillas<img src="img/Bulleted-List-icon.png">
                            <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li ><a href="#contenedorPlantillas" data-toggle="tab">Plantillas(General)</a></li>
                                <li ><a href="#contenedorVacantes" data-toggle="tab">Vacantes(Plantillas)</a></li>
                                <li ><a href="#plantillaSupervisorFacturacion" data-toggle="tab">Plantilla Supervisor</a></li>
                            </ul>
                        </li>
                            <li ><a href="#servEventuales" data-toggle="tab">Servicios Eventuales<img src="img/icon-trabajo.png"> </a></li>
                            <li><a href="#reporteRequisiciones" data-toggle="tab">Requisiciones solicitadas por ventas</a></li>


                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Reportes<img src="img/Bulleted-List-icon.png">
                                    <span class="caret"></span></a>

                                    <ul class="dropdown-menu">
                                        <!--<li><a href="#reporteTurnos" data-toggle="tab">Turnos Presupuestados vs Turnos Pagados</a></li>-->

                                        <!--<li><a href="#reporteFacturacion" data-toggle="tab">Reporte Facturacion</a></li>-->
                                        <li><a href="#reporteDetalleFacturacion" data-toggle="tab">Reporte Detalle Facturacion</a></li>
                                        <!--<li><a href="#reporteConsultaFatigasEnviadas" data-toggle="tab">Reporte Fatigas Recibidas</a></li>-->
                                        <!--<li><a href="#reporteCoberturaUtilidad" data-toggle="tab">Cobertura utilidad</a></li>-->
                                        <li><a href="#GraficaConteoTurnoFacutacion" data-toggle="tab">Cobertura</a></li>
                                    </ul>
                                </li>
                                <li><a href="#catalogoPuntosServiciosFacturacion" data-toggle="tab">Puntos de servicios</a></li>
                                <li><a href='#conteoincidenciasDia' data-toggle='tab'>Porcentaje Cobertura<img src="img/download.png"></a></li>


                                <?php
                            endif;
                            ?>

                            <?php
                            if ($usuario["rol"] == "Nomina") {
                                ?>
                                <li><a id="contenerdorSueldoEmpleados1" href="#contenerdorSueldoEmpleados" data-toggle="tab">Sueldos<img src="img/sueldoIcon.png"></a></li>
                                <li><a id="contenerdorActualizacionSueldoByPuntoServicio1" href="#contenerdorActualizacionSueldoByPuntoServicio" data-toggle="tab">Actualización sueldos<img src="img/sueldoIcon.png"></a></li>

                                <?php
                            }
                            ?>

                <!--NUEVO MENU PARA LA CATEGORIA DE ALMACEN  ****************************************************************
                ****************************************************************************************************************
                ****************************************************************************************************************
                ****************************************************************************************************************
                *  -->

                <?php
                if ($usuario["rol"] == "Almacen") {
                    if ($usuario["usuario"] == 'trejo*0' || $usuario["usuario"] == 'yaz*2') {
                        ?>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Proveedores  <img src="img/proveedor.png" width="20px">
                                <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#registroProveedor" data-toggle="tab">Registro</a></li>
                                    <li><a href="#consultaProveedores" data-toggle="tab">Consultas</a></li>
                                </ul>

                            </li>

                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Facturas  <img src="img/factura.png" width="23px">
                                    <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#generacionFactura" data-toggle="tab">Generación</a></li>
                                        <li><a href="#consultasFactura" data-toggle="tab">Consultas</a></li>
                                    </ul>
                                </li>


                            <?php
                        }
                        ?>

                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Uniformes  <img src="img/JustoLeal.png" width="13px">
                                <span class="caret"></span></a>

                                <ul class="dropdown-menu">

                                    <?php
                                    if ($usuario["usuario"] == 'trejo*0' || $usuario["usuario"] == 'yaz*2') {
                                        ?>
                                        <li><a href="#nuevoTipoUni" data-toggle="tab">Nuevo</a></li>
                                        <li><a href="#asignacionUniforme" data-toggle="tab">Asignacion</a></li>
                                        <li><a href="#consultasUniformes" data-toggle="tab">Consulta Stock</a></li>
                                        <li><a href="#historicoAlmacen" data-toggle="tab">Consulta Historicos</a></li>
                                        <li><a href="#consultaAsignaciones" data-toggle="tab">Consulta Asignaciones</a></li>
                                        <li><a href="#transferenciaUniforme" data-toggle="tab">Transferir</a></li>
                                        <li><a href="#consultaTransferencias" data-toggle="tab">Consulta Transferencias</a></li>
                                        <li><a href="#recepcionUniformes" data-toggle="tab">Recibir Uniformes</a></li>
                                        <li><a href="#consultarRecibidos" data-toggle="tab">Consulta Recepciones</a></li>
                                        <li><a href="#envioLavanderia" data-toggle="tab">Enviar a Lavanderia</a></li>
                                        <li><a href="#SolicitudesUniformes" data-toggle="tab">Solicitud De Uniformes</a></li>
                                        <!-- <li><a href="#consultaEnviosL" data-toggle="tab">Consultar Envios Lavanderia</a></li>-->
                                        <?php
                                    } else {
                                        ?>
                                        <li><a href="#asignacionUniforme" data-toggle="tab">Asignacion</a></li>
                                        <li><a href="#consultasUniformes" data-toggle="tab">Consulta Stock</a></li>
                                        <li><a href="#recepcionTransfer" data-toggle="tab">Transferencias</a></li>
                                        <li><a href="#recepcionUniformes" data-toggle="tab">Recibir Uniformes</a></li>
                                        <li><a href="#consultarRecibidos" data-toggle="tab">Consulta Recepciones</a></li>
                                        <li><a href="#envioLavanderia" data-toggle="tab">Enviar a Lavanderia</a></li>
                                        <li><a href="#consultaAsignaciones" data-toggle="tab">Consulta Asignaciones</a></li>
                                        <!-- <li><a href="#consultaEnviosL" data-toggle="tab">Consultar Envios Lavanderia</a></li>-->
                                        <?php
                                    }
                                    ?>
                                </ul>

                            </li>
                    <?php
                }
                ?>

                <?php
                if ($usuario["rol"] == "Contabilidad") {
                    ?>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Deducciones  <img src="img/icon-billete.png" width="23px">
                            <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                
                                <li><a href="#contenedorPrestamosF" data-toggle="tab">Prestamos_finiquitos</a></li>
                                <li><a href="#contenedorPrestamosN" data-toggle="tab">Prestamos_nomina</a></li>
                                <li><a href="#contenedorAlimentosN" data-toggle="tab">Alimentos_nomina</a></li>
                                <li><a href="#contenedorPagosN" data-toggle="tab">Otros Pagos_nomina</a></li>
                            </ul>
                            <li class="dropdown">
                     <a class="dropdown-toggle" data-toggle="dropdown" href="#">Historicos<img src="img/checkDocumentos.png" width="23px">
                      <span class="caret"></span></a>
                      <ul class="dropdown-menu">
                        <li ><a href="#HistoricoAcuerdosLaborales" data-toggle="tab">Acuerdos Laborales</a></li>
                        <li ><a href="#HistoricoAdeudosEmpleadosRevisadas" data-toggle="tab">Cuentas Deudores Revisadas</a></li>
                        <li><a href="#historicoDeudaUniformesContabilidad" data-toggle="tab">Deudas de Uniformes</a></li>
                      </ul>
                     </li>

                     <li class="dropdown">
                     <a class="dropdown-toggle" data-toggle="dropdown" href="#">Deudores<img src="img/checkDocumentos.png" width="23px">
                      <span class="caret"></span></a>
                      <ul class="dropdown-menu">
                          <li><a href="#HistoricoAdeudosEmpleados" data-toggle="tab">Listas Cuentas Deudores</a></li>
                          <li><a href="#DeudoresUnif" data-toggle="tab">Uniformes</a></li>
                      </ul>
                     </li>
                         <!--  <li ><a href="#geolocalizacion" data-toggle="tab">geolocalizacion<img src="img/checkDocumentos.png" width="23px"> </a></li> -->
                         <li ><a href="#contenedorSAT" data-toggle="tab">SAT</a></li>
                        </li>


                        <?php
                    }
                    ?>

                    <?php
                    if ($usuario["rol"] == "Cliente") {
                        ?>
                        <li ><a href="#guardiasCliente" data-toggle="tab">Guardias<img src="img/clients.png"> </a></li>
                        <li ><a href="#contentSuaPDF" data-toggle="tab">Descarga Documentos<img src="img/icon-billete.png" width="23px"> </a></li>

                        <?php
                    }
                    ?>

                    <?php
                    if ($usuario["rol"] == "Tabulador Administrativo") {
                        ?>
                        <li ><a href="#tabuladoradministrativo" data-toggle="tab">Sueldos<img src="img/sueldoIcon.png"> </a></li>
                        <?php
                    }
                    ?>


                    <?php
                    if ($usuario["rol"] == "Direccion General") {
                        ?>
                        
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Reportes<img src="img/Bulleted-List-icon.png">
                                <span class="caret"></span></a>

                                <ul class="dropdown-menu">
                                    <li ><a href="#contenedorDirectorio" data-toggle="tab">Directorio</a></li>
                                    <li ><a href="#contenedorOrganigramaDG" data-toggle="tab">Organigrama</a></li>
                                    <li ><a href="#contenedorRotacionSupDG" data-toggle="tab">Rotacion por supervisor</a></li>
                                  <center>
                                    <a style="color:black; font-weight: bold;">Reportes Finiquitos</a>
                                  </center>
                                        <li><a href="#estatusfiniquitosdg" data-toggle="tab">Estatus Finiquito</a></li>
                                        <li><a href="#HistoricosFiniquitosDG" data-toggle="tab">Historico Acuerdos Separaciones Laborales DG</a></li>
                                        <li><a href="#HistoricosConsultasEstatus" data-toggle="tab">Historico Consultas de Estatus Finiquito</a></li>

                                  <center>
                                    <a style="color:black; font-weight: bold;">Reportes Graficas</a>
                                  </center>
                                        <li><a href="#GraficaRotacionXreclutador" data-toggle="tab">Índice de rotación por reclutador <img src="img/GraficaPie.png" width="17px"></a></li>
                                        <li><a href="#GraficaConteoTurno" data-toggle="tab">Cobertura</a></li>
                                        <li><a href="#CoberturaPorRegiones" data-toggle="tab">Cobertura Por Regiones</a></li>
                                        <li><a href="#permanenciaDG" data-toggle="tab">Permanencia</a></li>
                                        <li><a href="#detalleCobertura" data-toggle="tab">Detalle Cobertura</a></li>
                                  <center>
                                    <a style="color:black; font-weight: bold;">Reportes Por Fecha Regional</a>
                                  </center>
                                        <li><a href="#reportePersonalPorFecha" data-toggle="tab">Consulta General Por Fechas</a></li>
                                        <li><a href="#reporteIncidenciaPorFecha" data-toggle="tab">Incidencia</a></li>
                                </ul>
                        </li>

                        <li ><a href="#confirmacionsueldodirgeneral" data-toggle="tab">Petición de Sueldos<img src="img/sueldoIcon.png"> </a></li>
                        <li ><a href="#consultahistoricosueldos" data-toggle="tab">Historial Sueldos<img src="img/Bulleted-List-icon.png"> </a></li>
                        <li ><a href="#PeticionIncidenciasespeciales" data-toggle="tab">Incidencias Especiales<img src="img/Bulleted-List-icon.png"> </a>
                        </li>
                        <li ><a href="#HistorialIncidenciasEspeciales" data-toggle="tab">Historial de Peticiones Especiales<img src="img/Bulleted-List-icon.png"> </a></li>
                        
                        
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Separación Laboral<img src="img/Bulleted-List-icon.png">
                                <span class="caret"></span></a>

                                <ul class="dropdown-menu">
                                    <li ><a href="#PeticionesdefiniquitoDG" data-toggle="tab">Acuerdos Separaciones Laborales</a></li>
                                    <li ><a href="#PeticionesComplementosF" data-toggle="tab">Complementos Finiquitos</a></li>
                                <!-- <li><a href='#HistoricoComplementosDG' data-toggle='tab'>Historico Complementos<img src="img/icon-cv.png" style="width: 14%"></a></li> -->
                                </ul>
                        </li>

                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Plantillas<img src="img/Bulleted-List-icon.png">
                            <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li ><a href="#contenedorPlantillas" data-toggle="tab">Plantillas(General)</a></li>
                                <li ><a href="#contenedorVacantes" data-toggle="tab">Vacantes(Plantillas)</a></li>
                                <li ><a href="#plantillaSupervisorContrataciones" data-toggle="tab">Plantilla Supervisor</a></li>

                            </ul>
                        </li>

                        <?php
                    } 
                    ?>

                    <?php
                    if ($usuario["rol"] == "Asistencia Administrativo") {
                        ?>
                        <li><a href='#contentAdministrativo' data-toggle='tab'>Asistencia Administrativa<img src="img/checkAsistencia.png"></a></li>
                        <li><a href='#contentGetAsistenciaA' data-toggle='tab'>Consulta Asistencia <img src="img/searchMenu.png"></a></li>
                        <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Control Incidencias <img src="img/Bulleted-List-icon.png">
                                    <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li ><a href="#contenedorArchivosIncapacidadAA" data-toggle="tab">Archivos Incapacidad </a></li>
                                    <li ><a href="#contenedorArchivosVacacionesAA" data-toggle="tab">Reporte Vacaciones </a></li>
                                </ul>
                            </li>
                        <?php
                    }
                    ?>

                    <?php
                    if ($usuario["rol"] == "Asistencia Administrativa SES") {
                        ?>
                        <li><a href='#contentAdministrativo' data-toggle='tab'>Asistencia Administrativa<img src="img/checkAsistencia.png"></a></li>
                        <li><a href='#contentGetAsistenciaA' data-toggle='tab'>Consulta Asistencia <img src="img/searchMenu.png"></a></li>
                        <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Control Incidencias <img src="img/Bulleted-List-icon.png">
                                    <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li ><a href="#contenedorArchivosIncapacidadAASE" data-toggle="tab">Archivos Incapacidad </a></li>
                                    <li ><a href="#contenedorArchivosVacacionesAASE" data-toggle="tab">Reporte Vacaciones </a></li>
                                </ul>
                            </li>
                        <?php
                    }
                    ?>

                    <?php
                    if ($usuario["rol"] == "Asistencia Administrativa ST") {
                        ?>
                        <li><a href='#contentAdministrativo' data-toggle='tab'>Asistencia Administrativa<img src="img/checkAsistencia.png"></a></li>
                        <li><a href='#contentGetAsistenciaA' data-toggle='tab'>Consulta Asistencia <img src="img/searchMenu.png"></a></li>
                        <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Control Incidencias <img src="img/Bulleted-List-icon.png">
                                    <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li ><a href="#contenedorArchivosIncapacidadAAST" data-toggle="tab">Archivos Incapacidad </a></li>
                                    <li ><a href="#contenedorArchivosVacacionesAAST" data-toggle="tab">Reporte Vacaciones </a></li>
                                </ul>
                            </li>
                        <?php
                    }
                    ?>



                    <?php
                    if ($usuario["rol"] == "Consulta Supervisor") {
                        ?>
                        <!--<li><a href='#asistenciaPeriodo1' data-toggle='tab'>Registro Asistencia <img src="img/checkAsistencia.png"></a></li>-->

                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Uniformes<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href='#asignacionUniformeConsultaSupervisor' data-toggle='tab'>Asignacion Uniformes</a></li>
                                <li><a href='#historicoAsigCS' data-toggle='tab'>Historico Asignacion Uniformes</a></li>
                            </ul>
                        </li>

                        <li><a href='#consultaAsistencia' data-toggle='tab'>Consulta Asistencia</a></li>
                        <li ><a href="#contenedorSolicitudBaja" data-toggle="tab">Solicitudes de bajas <img src="img/bajaEmpleado.png"> </a></li>
                        <li ><a href="#contenedorFatiga" data-toggle="tab">Fatiga <img src="img/download.png"></a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Plantillas<img src="img/Bulleted-List-icon.png">
                            <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li ><a href="#contenedorPlantillas" data-toggle="tab">Plantillas(General)</a></li>
                                <li ><a href="#contenedorVacantes" data-toggle="tab">Vacantes(Plantillas)</a></li>
                                <li ><a href="#plantillaSupervisorConsultaSup" data-toggle="tab">Plantilla Supervisor</a></li>
                            </ul>
                        </li>
                        <li ><a href="#servEventuales" data-toggle="tab">Servicios Eventuales<img src="img/icon-trabajo.png"> </a></li>
                        <li ><a href="#contenedorAsistenciaAP" data-toggle="tab">Guardias <img src="img/icon-guardia.png" width="30"> </a></li>
                        <li ><a href="#contenedorSupervisiones" data-toggle="tab">Supervisiones <img src="img/icon-supervisor.png" width="30"> </a></li>
                        <li><a href='#contenedorverpdf' data-toggle='tab'>Visualizar Archivos<img src="img/pdf.png" width="28px"></a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Reportes  <img src="img/Bulleted-List-icon.png">
                                <span class="caret"></span></a>

                                <ul class="dropdown-menu">
                                    <li><a href="#reporteAsistencia" data-toggle="tab">Detalle de asistencia</a></li>
                                    <li><a href="#reporteIE" data-toggle="tab">Incidencias Especiales</a></li>
                                </ul>
                            </li>
                       <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Finiquitos <img src="img/icon-finiquito.png" width="23px">
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                            <li ><a href="#FlujoFiniquito" data-toggle="tab">Estatus Finiquito</a></li>

                               </ul>
                        </li>

                        <li><a href='#EstatusPeticionAsistenciaMermaCS' data-toggle='tab'>Estatus Peticiones Merma<img src="img/plantilla.png"></a></li>

                        <?php
                    }
                    ?>

                    <?php
                    if ($usuario["rol"] == "Cobranza") {
                        ?>
                        <li><a href='#contenedorcobranza' data-toggle='tab'>Cobranza</a></li>

                        <li><a href='#contenedortblcobroEntidades' data-toggle='tab'>Flujo de Negocios</a></li>

                        <?php
                    }
                    ?>

                    <?php
                    if ($usuario["rol"] == "Comprobaciones de flujo") {
                        ?>
                        <li><a href='#contenedorsolicitudrecursos' data-toggle='tab'>Solicitar Recurso</a></li>
                        <li><a href='#contenedorcomprobacion' data-toggle='tab'>Comprobaciónes</a></li>
                        
                        <?php
                    }
                    ?>


                    <?php
                    if ($usuario["rol"] == "Control Vehicular") {
                        ?>
                        <li><a href='#contenedorregistrarvehiculo' data-toggle='tab' onclick='banderavehicular(1);' >Registrar Vehiculo <img src="img/carrito.png" width="32px"></a></li>
                        <li><a href='#contenedorregistrarvehiculo' data-toggle='tab' onclick='banderavehicular(2);'>Consultar Vehiculo <img src="img/carritoconsulta.png" width="28px"></a></li>
                        <li><a href='#contenedorasignacionesvehiculos' data-toggle='tab'>Asignar Vehiculo <img src="img/asignacionvehicular.png" width="28px"></a></li>
                        <li><a href='#contenedoraverificacionvehicular' data-toggle='tab'>Verificacion Vehicular<img src="img/carroverificacion.png" width="28px"></a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Actualizacion De Documentos<img src="img/Bulleted-List-icon.png">
                                <span class="caret"></span></a>

                                <ul class="dropdown-menu">
                                    <li><a href="#contenedoractualizarlicencia" data-toggle="tab">Licencia</a></li>
                                    <li><a href="#contenedoractualizartarjetac" data-toggle="tab">Tarjeta De Circulación</a></li>
                                    <li><a href="#contenedoractualizar" data-toggle="tab">Póliza De Seguros</a></li>
                                    
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Historicos<img src="img/Bulleted-List-icon.png">
                                    <span class="caret"></span></a>

                                    <ul class="dropdown-menu">
                                        <li><a href="#contenedoredicionvehiculos" data-toggle="tab">Edición De Vehículos</a></li>
                                        <li><a href="#contenedorhistoricoasignaciones" data-toggle="tab">Asignación De Vehículos</a></li>
                                        <li><a href="#contenedorhistoricoverificacionvehiculos" data-toggle="tab">Verificación De Vehículos</a></li>
                                        
                                    </ul>
                                </li>
                        <li><a href='#FotosVehicularApp' data-toggle='tab'>Revista Vehicular</a></li>
                        <li><a href='#reporteTotalVehiculos' data-toggle='tab'>Reporte Total Vehiculos</a></li>

                                <?php
}//
//                           
?>

<?php
if ($usuario["rol"] == "Gerente Vehicular") {
    ?>
    <!-- <li><a href='#contenedoravehiculosasignados' data-toggle='tab'>Vehiculos Asignados<img src="img/VehiculoAsignado.png" width="28px"></a></li>
    <li><a href='#contenedoraverificacionvehicular' data-toggle='tab'>Verificacion Vehicular<img src="img/carroverificacion.png" width="28px"></a></li>
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Actualizacion De Documentos<img src="img/Bulleted-List-icon.png">
            <span class="caret"></span></a>

            <ul class="dropdown-menu">
                <li><a href="#contenedoractualizarlicencia" data-toggle="tab">Licencia</a></li>
                <li><a href="#contenedoractualizartarjetac" data-toggle="tab">Tarjeta De Circulación</a></li>
                <li><a href="#contenedoractualizar" data-toggle="tab">Póliza De Seguros</a></li>
                
            </ul>
        </li>
    <li><a href='#FotosVehicularApp' data-toggle='tab'>Revista Vehicular</a></li>
    <li><a href='#reporteTotalVehiculosGV' data-toggle='tab'>Reporte Total Vehiculos</a></li> -->


        <?php
    }
    ?>

    <?php
    if ($usuario["rol"] == "Consulta Rh") {
        ?>
        <li><a href='#contenedorpdfcapacitacion' data-toggle='tab'>Cargar Archivos<img src="img/pdf.png" width="28px"></a></li>
        <li><a href='#contenedorverpdf' data-toggle='tab'>Visualizar Archivos<img src="img/pdf.png" width="28px"></a></li>
        
        <?php
    }
    ?>



    <?php
    if ($usuario["rol"] == "Telefonia") {
        ?>
        <li><a href='#contenedorregistrotelefono' data-toggle='tab'>Registrar Teléfono<img src="img/AltaTelefono.jpg" width="22px"></a></li>
        <?php
    }
    ?>

<?php
    if ($usuario["rol"] == "Radio Operador") {
        ?>
        <li><a href='#consultaAsistencia' data-toggle='tab'>Consulta Asistencia</a></li>
        <?php
    }
    ?>



    <?php
    if ($usuario["rol"] == "Administracion Seguridad Electronica") {
        $catalogoTurnos       = $negocio->negocio_obtenerListaTurnos();
        $catalogoLineaNegocio = $negocio->negocio_obtenerListaLineaNegocio();
    // $catalogoTipoRequisicion=$negocio ->selectTipoRequisicion();
        ?>
        <li><a id="contenerdorRegistroCliente1" href="#contenerdorRegistroCliente" data-toggle="tab">Registro Cliente <img src="img/iconAddCliente.png"></a></li>
        <li><a id="contenedorRegistroEmpresa1" href="#contenedorRegistroEmpresa" data-toggle="tab">Registro Nueva Sucursal<img src="img/iconLocalizacion.png"></a></li>
        <li><a id="contenedorCatalogoClientes1" href="#contenedorCatalogoClientes" data-toggle="tab">Catalogo Clientes <img src="img/clients.png"></a></li>
        <li><a id="contenedorCatalogoPuntosServicios1" href="#contenedorCatalogoPuntosServicios" data-toggle="tab">Catalogo Sucursales <img src="img/points.png"></a></li>
        <li><a id="contenedorSueldos1" href="#contenedorSueldos" data-toggle="tab">Sueldos<img src="img/sueldoIcon.png"></a></li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Actualicaciones<img src="img/Bulleted-List-icon.png">
                <span class="caret"></span></a>

                <ul class="dropdown-menu">
                    <li><a href="#actualizacionFechaServicio" data-toggle="tab">Renovación de puntos</a></li>
                    <li><a href="#actualizacionFechaRequisicion" data-toggle="tab">Renovación de requisiciones</a></li>
                </ul>
            </li>
            <?php
        }
        ?>




        <?php
        if ($usuario["rol"] == "Prenomina Administrativa") {
            ?>
            <li><a href='#contentGetAsistenciaA' data-toggle='tab'>Consulta Asistencia <img src="img/searchMenu.png"></a></li>
            <!--<li><a href='#procesoNomina' data-toggle='tab'>Procesar <img src="img/lockMenu.png"></a></li> -->

            <?php
        }
        ?>

         <?php
        if ($usuario["rol"] == "Asistencia") {
            ?>

           
            <?php
        }
        ?>

        <?php
        if ($usuario["rol"] == "Laborales") {
            ?>


                <li ><a href="#contenedor" data-toggle="tab">Registro<img src="img/addVisitante.png"> </a></li>
                <!-- <li ><a href="#contenedorCurp" data-toggle="tab">Comparación Curp<img src="img/addVisitante.png"> </a></li> -->
                <li ><a href="#contenedorConsultaEmpleado" data-toggle="tab">Consulta Empleado <img src="img/searchEmpleado.png"> </a></li>
                <li ><a href="#contenedorhistoricoedicion" data-toggle="tab">Historico ediciones<img src="img/icon-cv.png" style="width: 14%" > </a></li>
                <li ><a href="#contenedorSolicitudBaja" data-toggle="tab">Solicitud de bajas <img src="img/bajaEmpleado.png"> </a></li>
                
                   <li class="dropdown">
                       <a class="dropdown-toggle" data-toggle="dropdown" href="#">Finiquitos<img src="img/icon-finiquito.png" style="width: 25%">
                           <span class="caret"></span></a>
                               <ul class="dropdown-menu">
                                <li ><a href="#ConfirmacionDiasVacacionesFiniquitos" data-toggle='tab'>Confirmacion Dias Vacaciones Finiquitos</a></li>
                                <li ><a href="#FlujoFiniquito" data-toggle="tab">Estatus Finiquito</a></li>
                                <li><a href='#Finiquitosenesperacontrata' data-toggle='tab'>Negociación de Finiquitos</a></li>                                 
                                <li ><a href="#contenedorFiniquitosentidad" data-toggle="tab">Consulta Finiquitos</a></li>
                                <li ><a href="#contenedorComplementoFiniquito" data-toggle="tab">Complemento Finiquitos</a></li>
                                <li ><a href="#contenedorUniformesParaFiniquitoP" data-toggle="tab">Uniformes Recibidos Para Finiquito</a></li>
                                <li ><a href="#BetoDeElementos" data-toggle="tab">Veto De Elementos </a></li>
                                <li ><a href="#HistoricoVetoElementos" data-toggle="tab">Historico Veto De Elementos </a></li>
                            </ul>
                    </li>

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Reportes  <img src="img/Bulleted-List-icon.png">
                        <span class="caret"></span></a>

                        <ul class="dropdown-menu">
                            <li><a href="#reportePersonalActivo" data-toggle="tab">Consulta General</a></li>
                            <li><a href="#reportePersonalCapturado" data-toggle="tab">Consultar por Fecha de Captura</a></li>
                            <li><a href="#reporteBajasPersonal" data-toggle="tab">Consultar Bajas por Fecha Captura</a></li>
                            <li><a href="#reporteRequisiciones" data-toggle="tab">Requisiciones solicitadas por ventas</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Indicadores<img src="img/Bulleted-List-icon.png">
                            <span class="caret"></span></a>

                            <ul class="dropdown-menu">
                                <li><a href="#reporteReclutadores" data-toggle="tab">Índice de rotacion x reclutador</a></li>
                                <li><a href="#indiceRotacionGeneral" data-toggle="tab">Índice de rotacion x mes</a></li>
                                <li><a href="#indiceRotacionEntidad" data-toggle="tab">Índice de rotacion entidades</a></li>
                                <li><a href="#reporteProductividadReclutadores" data-toggle="tab">Productividad</a></li>

                            </ul>
                        </li>

                        <li ><a href="#renovacionCredenciales" data-toggle="tab">Renovacion de credencial <img src="img/id-card-icon.png"> </a></li>
                        <!--<li ><a href="#contenedorRequisicionesPersonal" data-toggle="tab">Requisiciones de personal <img src="img/Groups-icon.png"> </a></li>-->
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Plantillas<img src="img/Bulleted-List-icon.png">
                            <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li ><a href="#contenedorPlantillas" data-toggle="tab">Plantillas(General)</a></li>
                                <li ><a href="#contenedorVacantes" data-toggle="tab">Vacantes(Plantillas)</a></li>
                                <li ><a href="#plantillaSupervisorLaborales" data-toggle="tab">Plantilla Supervisor</a></li>
                            </ul>
                        </li>
                        <li ><a href="#consultaEstatusImss" data-toggle="tab">Consulta estatus Imss <img src="img/iconEstatusRHIMSS.png"> </a></li>


                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Control Incidencias <img src="img/Bulleted-List-icon.png">
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li ><a href="#contenedorArchivosIncapacidad" data-toggle="tab">Archivos Incapacidad </a></li>
                                <li ><a href="#contenedorConfirmacionVacaciones" data-toggle="tab">Confirmacion Vacaciones </a></li>
                                <li ><a href="#contenedorArchivosVacaciones" data-toggle="tab">Reporte Vacaciones </a></li>
                            </ul>
                        </li>
                                    
                        
         
            <?php
        }
        ?>


<?php
    if ($usuario["rol"] == "Tramites o Gestion") { //Tramites o Gestion
        ?>

    <li ><a href="#escrituraPublica" data-toggle="tab">Escritura Constitutiva<img src="img/iconEstatusRHIMSS.png"> </a></li>
    <li ><a href="#repse" data-toggle="tab">Catalogo Repse</a></li>

    <li ><a href="#contenedorConsultaEmpleadoTG" data-toggle="tab">Consulta Empleado <img src="img/searchEmpleado.png"> </a></li>
    <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Plantillas<img src="img/Bulleted-List-icon.png">
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li ><a href="#contenedorPlantillas" data-toggle="tab">Plantillas(General)</a></li>
                <li ><a href="#contenedorVacantes" data-toggle="tab">Vacantes(Plantillas)</a></li>
                <li ><a href="#plantillaSupervisorEconomicoyConsultaRH" data-toggle="tab">Plantilla Supervisor</a></li>
                <li ><a href="#contenedordocumentoEmpelados" data-toggle="tab">Reporte Documentos</a></li>
            </ul>
        </li>
    <li ><a href="#contentCapacitacion" data-toggle="tab">Formato Capacitación <img src="img/icon-protesta.png" width="25"> </a></li>
    <li ><a href="#contentPermiso" data-toggle="tab">Permiso Federal <img src="img/icon-guardia.png" width="25"> </a></li>
    <li ><a href="#contentPermisoLocal" data-toggle="tab">Permiso Local <img src="img/icon-guardia.png" width="25"> </a></li>
    <li ><a href="#contentC3" data-toggle="tab">Documento DC-3 <img src="img/hojaDatos.png" width="25"> </a></li>

            <?php
        }
?>

<?php
    if ($usuario["rol"] == "Gerente Regional") { 
        ?>
        <li><a href="#plantillaSupervisorGerenteRegional" data-toggle="tab">Plantilla Supervisor</a></li>
        <li><a href="#graficaConteoTurnoGerenteRegional"  data-toggle="tab">Cobertura</a></li>
        <li ><a href="#contenedorRotacionSupGR" data-toggle="tab">Rotacion por supervisor</a></li>

        <!-- agregado en el cambio de gerente vehicular a regional: -->

        <li><a href='#consultaAsistencia' data-toggle='tab'>Consulta Asistencia</a></li>
        <li><a href='#PorcentajeAsistencia' data-toggle='tab'>Porcentaje Asistencia</a></li>
        <li ><a href="#contenedorSupervisiones" data-toggle="tab">Supervisiones <img src="img/icon-supervisor.png" width="30"> </a></li>
        <li><a href="#contenedorKpi" data-toggle="tab">KPI<img src="img/kpi.png" width="23px"> </a></li>

        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Vehiculos<img src="img/Bulleted-List-icon.png">
            <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href='#contenedoravehiculosasignados' data-toggle='tab'>Vehiculos Asignados<img src="img/VehiculoAsignado.png" width="28px"></a></li>
                    <li><a href='#contenedoraverificacionvehicular' data-toggle='tab'>Verificacion Vehicular<img src="img/carroverificacion.png" width="28px"></a></li>
                    <li><a href='#FotosVehicularApp' data-toggle='tab'>Revista Vehicular</a></li>
                    <li><a href='#reporteTotalVehiculosGV' data-toggle='tab'>Reporte Total Vehiculos</a></li>
                    
                    <center>
                        <a style="color:black; font-weight: bold;">Actualizacion De Documentos</a>
                    </center>
                    
                        <li><a href="#contenedoractualizarlicencia" data-toggle="tab">Licencia</a></li>
                        <li><a href="#contenedoractualizartarjetac" data-toggle="tab">Tarjeta De Circulación</a></li>
                        <li><a href="#contenedoractualizar" data-toggle="tab">Póliza De Seguros</a></li>                                  
                </ul>
        </li>

        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Finanzas<img src="img/Bulleted-List-icon.png">
            <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="#contenedorComprobacionRegional" data-toggle="tab">Solicitud De Pago<img src="img/contratos.png" width="23px"> </a></li>
                    <li><a href='#contenedorsolicitudrecursos' data-toggle='tab'>Solicitar Recurso</a></li>
                    <li><a href='#contenedorcomprobacion' data-toggle='tab'>Comprobaciónes</a></li>
                </ul>
        </li>
        <?php
        }
        ?>

<?php
    if ($usuario["rol"] == "Capacitacion") { 
        ?>
        <li><a href="#peticionesTurnoCapacitacion" data-toggle="tab">Peticiones turno capacitacion</a></li>
        <li><a href="#HistoricopeticionesTurnoCapacitacion" data-toggle="tab">Historico turno capacitacion</a></li>
<?php
}
?>

<?php
    if ($usuario["rol"] == "Centro De Control") { 
?>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Reportes Graficas<img src="img/Grafica.png" width="23px">
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="#GraficaRotacionXreclutador" data-toggle="tab">Índice de rotación por reclutador <img src="img/GraficaPie.png" width="17px"></a></li>
                <li><a href="#GraficaConteoTurno" data-toggle="tab">Cobertura</a></li>
                <li ><a href="#CoberturaPorRegiones" data-toggle="tab">Cobertura Por Regiones</a></li>
                <li ><a href="#permanenciaDG" data-toggle="tab">Permanencia</a></li>
                <li ><a href="#detalleCobertura" data-toggle="tab">Detalle Cobertura</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Reporte Incidencias <img src="img/Bulleted-List-icon.png">
                <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li ><a href="#ReporteIncidenciaCentroControl" data-toggle="tab">Generar Reporte Incidencia</a></li>
                <li ><a href="#HistoricoReporteIncidenciaCentroControl" data-toggle="tab">Historico Reporte Incidencia</a></li>
                <li ><a href="#HistoricoEditReporteIncidenciaCentroControl" data-toggle="tab">Historico Ediciones Reporte Incidencia</a></li>
            </ul>
        </li>

        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Reportes Por Fecha<img src="img/Bulleted-List-icon.png">
            <span class="caret"></span>
        </a>
          <ul class="dropdown-menu">
            <li><a href="#reportePersonalPorFecha" data-toggle="tab">Consulta General Por Fechas</a></li>
            <li><a href="#reporteIncidenciaPorFecha" data-toggle="tab">Incidencia</a></li>
            <li ><a href="#contenedorRotacionSupCC" data-toggle="tab">Rotacion por supervisor</a></li>
          </ul>
        </li>
        <li ><a href="#contenedorDirectorioCC" data-toggle="tab">Directorio</a></li>
        <li><a href='#FotosVehicularApp' data-toggle='tab'>Revista Vehicular</a></li>




        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Regiones<img src="img/Bulleted-List-icon.png">
            <span class="caret"></span>
        </a>
          <ul class="dropdown-menu">
            <li><a href='#ModificacionRegiones' data-toggle='tab'>Matriz De Regiones</a></li>
            <li><a href='#relacionUsuarioRegión' data-toggle='tab'>Asignación de matriz</li>
          </ul>
        </li>

        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Utileria<img src="img/Bulleted-List-icon.png">
            <span class="caret"></span>
        </a>
          <ul class="dropdown-menu">
            <li ><a href="#contenedorCatalogoInc" data-toggle="tab">Catalogo Incidencias</a></li>
            <li ><a href="#contenedorCatalogoEsp" data-toggle="tab">Catalogo Especificaciones</a></li>
          </ul>
        </li>

       
<?php
    }
?>

        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Cerrar Sesion <img src="img/out.png"><span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li ><a href="#contenedorFirmaElectronicaInterna" data-toggle="tab">Firma Electronica Interna</a></li>
                <li><a id="UsuariosParaApp1" href="#UsuariosParaApp" data-toggle="tab">Generar Usuarios App</a></li>

                <li><a href="logout.php">Cerrar sesión</a></li>
            </ul>
        </li>
        
</div>






<div class="tab-content">
    <div class="tab-pane fade fade active in " id="contenedorUno">

        <div class="container">

            <?php
            if ($usuario["rol"] == "Guardia") {
                include "form_envioLocalizacion.php";
                ?>


                <?php
            } else {
                ?>

                <div class="hero-unit">
                        <h3>GRUPO GIF SEGURIDAD PRIVADA</h3>
                        <p>En GRUPO GIF tenemos muy claros nuestros objetivos, ya que sabemos perfectamente lo que buscan nuestros clientes, honestidad, trato humano y un servicio de primer nivel para su patrimonio y seres queridos.</br>
                        Nos esforzamos continuamente en trasmitir de forma adecuada nuestra filosofía ya que esta basada en la calidad, ética y factor humano, lo cual nos posiciona como una empresa profesional con bases sólidas.</br>
                        Nuestras soluciones.
                        </p>
                        <img src="img/engranes.png">
                    </div>

                        <!-- Example row of columns -->
                    <footer><p>&copy; GRUPO GIF</p></footer>
                </div> <!-- /container -->
            </div>
             <?php
}
?>

<div class="tab-pane fade " id="contenedorFirmaElectronicaInterna">
                <div >

                    <?php

                    include "form_RegistroFirmaElectronicaInterna.php";
                    ?>
                </div>
            </div>
<div class="tab-pane fade " id="UsuariosParaApp">
    <div >

        <?php
        include "UsuariosApp/crearUsuariosParaApp.html";
        ?>
    </div>
</div>

<?php
if ($usuario["rol"] == "Lider Unidad" || $usuario["rol"] == "Contrataciones" ) {
    ?>
    <div class="tab-pane  " id="contenedor" align="center">
                   <!-- <div class="tab-pane" id="cajonleft">

                   </div>-->

                   <?php
                   include "formRegistroEmpleado.php";

                   ?>
               </div>

               <!----------------------------------------------------------------->
               <div class="tab-pane  " id="contenedorCurp" align="center">
                   <!-- <div class="tab-pane" id="cajonleft">

                   </div>-->

                   <?php
                   include "form_ComparacionCurp.php";

                   ?>
               </div>

               <!----------------------------------------------------------------->



               <div class="tab-pane  " id="contenedorFiniquitosentidad" align="center">
                   <!-- <div class="tab-pane" id="cajonleft">

                   </div>-->

                   <?php
                   include "../Nominas/finiquitos/finiquitos.php";

                   ?>

               </div>

               <div class="tab-pane fade " id="contenedorArchivosIncapacidad">
                <div >

                    <?php
                    include "form_visualizArchivosIncapacidad.php";

                    ?>
                </div>
            </div>

             <div class="tab-pane fade " id="contenedorArchivosVacaciones">
                <div >

                    <?php
                    include "form_ReporteVacaciones.php";

                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedorArchivoBajaEmpleado">
                <div >

                    <?php
                    include "form_ReporteBajasEmpleados.php";

                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="recibirtarjetas">
                <div >
                    <?php
                    include "recepcionTarjetas/form_RecepcionTarjetas.php";
                    ?>
                 </div>
            </div>

            <div class="tab-pane fade " id="contenedorDistribucionTarjetas">
                <div >
                    <?php
                    include "DistribucionTarjetas/DistribucionTarjetas.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedorAsignacionTarjetaAEmpleado">
                <div >
                    <?php
                    include "AsignacionTarjetaAEmpleado/AsignacionTarjetaEmpledo.php";
                    ?>
                </div>
            </div>

    <div class="tab-pane fade " id="HistoricoVetoElementos">
        <div >
            <?php
                include "HistoricoVetoElementos/HistoricoVetoElementos.php";
            ?>
        </div>
    </div>



               <?php
           }
           ?>

           <?php
           if ($usuario["rol"] == "Lider Unidad" || $usuario["rol"] == "Contrataciones" || $usuario["rol"] == "Socioeconomico" || $usuario["rol"] == "Consulta Rh" ) {
            ?>
            <div class="tab-pane  " id="contenedorConsultaEmpleado" align="center">

                <div >
                    <?php
                    include "form_ConsultaPersonal.php";
                    ?>
                </div>

            </div>

            <div class="tab-pane fade " id="contenedorPlantillas">
                <div >

                    <?php

                    include "form_consultaPlantillas.php";
                    ?>
                </div>
            </div>
            <div class="tab-pane fade " id="contenedorVacantes">
                <div >
                 
                    <?php

                    include ("form_consultaVacantesPlantillas.php");
                    ?>
                </div>
            </div> 
            <?php
        }
        ?>

        <?php
        if ($usuario["rol"] == "Recepcion") {
            ?>
            <div class="tab-pane fade " id="contenedorConsulta">
                <div >
                    <?php
                    include "form_ReporteVisitantes.php";
                    ?>
                </div>


            </div>

            <div align="center" class="tab-pane" id="contenedorVisitante" >
                <div >
                    <?php
                    include "form_RegistrarVisitante.php";
                    ?>
                </div>
            </div>

            <?php
        }
        if ($usuario["rol"] == "Comprobacion Regional") {
            ?>
            <div class="tab-pane fade " id="contenedorComprobacionRegional">
                <?php
                include "form_SolicitudPago.php";
                ?>
            </div>
            <div class="tab-pane  " id="contenedorsolicitudrecursos" align="center">
                <?php
                include "form_SolicitudRecurso.php";
                ?>
            </div>
            
            <div class="tab-pane  " id="contenedorcomprobacion" align="center">
                <?php
                include "form_Comprobaciones.php";
                ?>
            </div>
            <?php

        }


        ?>

        <?php

        if ($usuario["rol"] == "Finanzas" || $usuario["rol"] == "Tesoreria") {
            ?>
            <div class="tab-pane fade " id="contenedorFinanzas">
                <div >
                    <?php
                    include "form_RegistroMovimientos.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedorSaldosIniciales">
                <div >
                    <?php
                    include "form_RegistroSaldosIniciales.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedorCargarArchivos">
                <div >
                    <?php
                    include "form_Conciliacion.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedorAbonoCaja">
                <div >
                    <?php
                    include "form_contenedorAbonoCaja.php";
                    ?>
                </div>
            </div>


            <div class="tab-pane fade " id="contenedorNuevoBanco">
                <div >
                    <?php
                    include "form_contenedorNuevoBanco.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedorNuevaCuenta">
                <div >
                    <?php
                    include "form_contenedorNuevaCuenta.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedorNuevaEmpresa">
                <div >
                    <?php
                    include "form_contenedorNuevaEmpresa.php";
                    ?>
                </div>
            </div>


            <div class="tab-pane fade " id="TranseferenciasBancarias">
                <div >
                    <?php
                    include "form_TransferenciasBancarias.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="TablaTipoGastoCosto">
                <div >
                    <?php
                    include "form_tbl_costo_gasto.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="TablaSolicitudesDePagoFinanza">
                <div >
                    <?php
                    include "form_SolicitudPago.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="TablacomprobacioesPagoFinanza">
                <div >
                    <?php
                    include "form_ComprobacionesdeAbonos.php";
                    ?>
                </div>
            </div>  
            <div class="tab-pane fade " id="reporteDetalleFacturacion">
                <div >
                 
                    <?php

                    include ("form_reporteDetalleFacturacion.php");
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="TablaSolicitudesDePagoFiniquito">
                <div >
                    <?php
                    include ("SolicitudesPagoFiniquitos/form_solicitudDePagoFiniquitos.php");
                    ?>
                </div>
            </div>            
            
            <div class="tab-pane fade " id="contGenerarPago">
                <div >
                    <?php
                    include ("GenerarPago/form_GenerarPago.php");
                    ?>
                </div>
            </div> 

            <div class="tab-pane fade " id="HistoricoMovimientosFiniquitosPago11">
                <div >
                    <?php
                    include ("HistoricoMovimientosFiniquitosPago/HistoricoMovimientosFiniquitosPago.html");
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="reporteFiniFaltante">
                <div >
                    <?php
                    include ("ReporteFiniquitosFaltantesFinanzas/ReporteFiniquitosFaltantesFinanzas.html");
                    ?>
                </div>
            </div> 


            
            <?php
        }
        ?>


        <?php
        if ($usuario["rol"] == "Ventas") {
            ?>

            <div class="tab-pane fade " id="contenerdorRegistroCliente">
                <div >
                    <?php
                    include ("form_RegistrarCliente.php");
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedorRegistroPunto">
                <div >
                    <?php
                    include ("form_RegistroPuntoServicio.php");
                    ?>
                </div>
            </div>

             <div class="tab-pane fade " id="contenedorCatalogoClientes">
                <div >
                    <?php
                        include ("form_ConsultaClientes.php");
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedorCatalogoPuntosServicios">
                <div >
                    <?php
                        include ("form_ConsultaPuntosServicios.php");
                    ?>
                </div>
            </div>           

            <div class="tab-pane fade " id="contenedorSueldos">
                <div >
                    <?php
                    include ("form_registroSueldo.php");
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedorPlantillas">
                <div >
                    <?php
                    include ("form_consultaPlantillas.php");
                    ?>
                </div>
            </div>

             <div class="tab-pane fade " id="contenedorVacantes">
                <div >
                    <?php
                    include ("form_consultaVacantesPlantillas.php");
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="servEventuales">
                <div >
                    <?php
                        include "form_serviciosEventuales.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="reporteDetalleFacturacion">
                <div >
                    <?php
                    include ("form_reporteDetalleFacturacion.php");
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="reporteRequisiciones">
                <div >
                    <?php
                        include ("reporteRequisiciones.php");
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="actualizacionFechaServicio">
                <div >
                    <?php
                    include ("form_actualizacionFechaTerminoServicio.php");
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="actualizacionFechaRequisicion">
                <div >
                    <?php
                    include ("form_actualizacionFechaTerminoRequisiciones.php");
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="ActualizacionTiposContratos">
                <div >
                    <?php
                    include ("form_catalogoTipoContratosClientes.php");
                    ?>
                </div>
            </div>

             <div class="tab-pane fade " id="ActualizacionRolOperativo">
                <div >
                    <?php
                    include ("form_CatalogoRolOperativo.php");
                    ?>
                </div>
            </div>
            <!--<div class="tab-pane fade " id="incrementoPlantilla">
                <div >

                    
                  //  include "form_requisicionIncrementoPlantilla.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="reduccionPlantilla">
                <div >

                    
                    //include "form_reduccionPlantilla.php";
                    ?>
                </div>
            </div>
        -->   
        <div class="tab-pane fade " id="plantillaSupervisorVentas">
                <div >
                    <?php
                    include "form_PlantillaSupervisor.php";
                    ?>
                </div>
            </div>

        <div class="tab-pane fade " id="reportePersonalPorFecha">
            <div >
                <?php
                    include "reporteGeneralPorFecha/reporteGeneralPorFecha.php";
                ?>
            </div>
        </div>

        <div class="tab-pane fade " id="CatalogoHorariosAdmin">
            <div >
                <?php
                    include "HorariosAdmin/Form_HorariosAdmin.html";
                ?>
            </div>
        </div>

        <div class="tab-pane fade " id="CatalogoJornadasAdmin">
            <div >
                <?php
                    include "Jornadas/form_Jornadas.html";
                ?>
            </div>
        </div>

        <?php
        }
        ?>

        <?php
        if ($usuario["rol"] == "Administracion Seguridad Electronica") {
            ?>
            <div class="tab-pane fade " id="contenerdorRegistroCliente">
                <div >
                    <?php
                    include ("form_RegistrarCliente.php");
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedorRegistroEmpresa">
                <div >
                    <?php
                    include ("form_RegistroNuevaEmpresa.php");
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedorCatalogoClientes">
                <div >
                    <?php
                    include ("form_ConsultaClientes.php");
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedorCatalogoPuntosServicios">
                <div >
                    <?php
                    include ("form_ConsultaSucursal.php");
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedorSueldos">
                <div >
                    <?php
                    include ("form_registroSueldo.php");
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="actualizacionFechaServicio">
                <div >
                    <?php
                    include "form_actualizacionFechaTerminoServicio.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="actualizacionFechaRequisicion">
                <div >
                    <?php
                    include "form_actualizacionFechaTerminoRequisiciones.php";
                    ?>
                </div>
            </div>
            <?php
        }
        ?>



        <?php
        if ($usuario["rol"] == "Coordinador Imss") {
            ?>

            <div class="tab-pane fade " id="menuReportes">
                <div >

                    <!--<img src="ejemplo1.php" alt="graficas" /> -->
                    <?php
                    include "form_MenuReportesFin.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade" id="consultaEstatusImss">
                <div >

                    <?php

                    include "form_ConsultaEstatusImss.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade" id="contentPagoSua">
                <div >

                    <?php

                    include "form_subirPagoSua.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade" id="contentAfill">
                <div >

                    <?php

                    include "form_subirAfil06.php";
                    ?>
                </div>
            </div>


            <div class="tab-pane fade" id="contenedorFiniquito">
                <div >

                    <?php

                    include "../Nominas/finiquitos/finiquitos.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedorEma">
                <div >

                    <?php

                    include "form_consultaEma.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedorEva">
                <div >

                    <?php

                    include "form_consultaEva.php";
                    ?>
                </div>
            </div>



            <div class="tab-pane fade " id="contenerdorConfirmacionImss">
                <div >

                    <?php

                    include "form_consultaEmpleadosSinImss.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenerdorCuadroAntig">
                <div >

                    <?php

                    include ("form_consultaCuadroAntigImss.php");
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenerdorPrueba">
                <div >

                    <?php

                    include "consultaImss.php";
                    ?>
                </div>
            </div>


            <div class="tab-pane fade " id="contenedorFonacotF">
                <div >

                    <?php

                    include "form_actualizaFonacotF.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenerdorFonacotF">
                <div >

                    <?php

                    include "form_actualizaFonacotF.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedorPensionF">
                <div >

                    <?php

                    include "form_actualizaPensionF.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedorInfonavitN">
                <div >

                    <?php

                    include "form_actualizaInfonavitN.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedorFonacotN">
                <div >

                    <?php

                    include "form_actualizaFonacotN.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedorPensionN">
                <div >

                    <?php

                    include "form_actualizaPensionN.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenerdorEmpleadosSinBajaImss">
                <div >

                    <?php

                    include "form_consultaEmpleadosSinBajaImss.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenerdorConfirmacionBaja">
                <div >

                    <?php

                    include "form_confirmaBajasImss.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedorDescargaConta">
                <div >

                    <?php

                    include "form_descargaArhivosConta.php";
                    ?>
                </div>
            </div>
            <div class="tab-pane fade " id="contenedorArchivosIncapacidad">
                <div >

                    <?php
                    include "form_visualizArchivosIncapacidad.php";

                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedorArchivosVacaciones">
                <div >

                    <?php
                    include "form_ReporteVacaciones.php";

                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedorArchivoBajaEmpleado">
                <div >

                    <?php
                    include "form_ReporteBajasEmpleados.php";

                    ?>
                </div>
            </div>


            <div class="tab-pane fade " id="FlujoFiniquito">
                        <div >
                            <?php
                            include "form_FlujoFiniquito.php";
                            ?>
                        </div>
                    </div>

            <div class="tab-pane fade " id="HistoricoAcuerdosLaborales">
                        <div >
                            <?php
                            include "form_HistoricoAcuerdosLaborales.php";
                            ?>
                        </div>
                    </div>

            <div class="tab-pane fade " id="permanenciaIMSS">
                        <div >
                            <?php
                            include "form_Permanencia.php";
                            ?>
                        </div>
                    </div>       

            <div class="tab-pane fade " id="opinionCumplimientosInfonavit">
                        <div >
                            <?php
                            include "form_OpinionDeCumplimientosINFONAVIT.php";
                            ?>
                        </div>
                    </div>        

             <div class="tab-pane fade " id="opinionCumplimientosIMSS">
                        <div >
                            <?php
                            include "form_OpinionDeCumplimientosIMSS.php";
                            ?>
                        </div>
                    </div>       

            <div class="tab-pane fade " id="provision">
                <div>
                    <?php
                    include "form_provision.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="formularioICSOE">
                <div>
                    <?php
                    include "ICSOE/form_ICSOE.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="formularioSISUB">
                <div>
                    <?php
                    include "SISUB/form_SISUB.php";
                    ?>
                </div>
            </div>


            <div class="tab-pane fade " id="edicionPSEMAEBA">
            <div >

                <?php
                include "EdicionPSEMAEBA/form_edicionPSEMAEBA.php";
                ?>
            </div>
        </div>

        <div class="tab-pane fade " id="cargaIDSE">
            <div >

                <?php
                include "IDSE/form_IDSE.php";
                ?>
            </div>
        </div>

        <div class="tab-pane fade " id="formularioXML">
                <div>
                    <?php
                    include "XML/form_XML.php";
                    ?>
                </div>
            </div>

        <div class="tab-pane fade " id="contenerdorActualizarSueldosGeneral">
                <div >
                    <?php
                        include "ActualizarSueldosGeneralAnual/form_ActualizarSueldosAnual.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="pendientesCambioRP">
            <div >
                <?php
                    include "pendientesCambioRP/form_cambiosRPxPS.php";
                ?>
            </div>
        </div>

         <div class="tab-pane fade " id="movimientosImss">
            <div >
                <?php
                    include "movimientos/form_movimientos.php";
                ?>
            </div>
        </div>

        <div class="tab-pane fade " id="semaforoImss">
            <div >
                <?php
                    include "semaforoImss/semaforoImss.php";
                ?>
            </div>
        </div>

            <?php
        }
        ?>

        <?php
        if ($usuario["rol"] == "monitorsta") {
            ?>

            <div class="tab-pane fade " id="contenedorRegistroServicio">
                <div >

                    <?php

                    include "form_registroServicioCustodia.php";
                    ?>
                </div>
            </div>

            <?php
        }
        ?>

        <?php
        if ($usuario["rol"] == "Contrataciones" ) {
            ?>

            <div class="tab-pane fade " id="contenedorhistoricoedicion">
                <div >

                    <?php

                    include "form_HistoricoEdicion.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedordocumentoEmpelados">
                <div >

                    <?php

                    include "ReporteDocumentos/form_ReporteDocumetos.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="reporteDocumentosXContratante">
                <div >

                    <?php

                    include "ReporteDocumentosPorContratante/form_ReporteDocumentosPorContratante.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="reportePersonalActivo">
                <div >

                    <?php

                    include "reportePersonalActivo.php";
                    ?>
                </div>
            </div>


            <div class="tab-pane fade" id="consultaEstatusImss">
                <div >

                    <?php

                    include "form_ConsultaEstatusImss.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="reportePersonalCapturado">
                <div >

                    <?php

                    include "form_consultaPersonalFechaCaptura.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="reporteBajasPersonal">
                <div >

                    <?php

                    include "form_consultaBajas.php";
                    ?>
                </div>
            </div>
            <div class="tab-pane fade " id="reporteReclutadores">
                <div >

                    <?php

                    include "form_reporteReclutadores.php";
                    ?>
                </div>
            </div>
            <div class="tab-pane fade " id="reporteProductividadReclutadores">
                <div >

                    <?php

                    include "form_productividadReclutador.php";
                    ?>
                </div>
            </div>
            
            <div class="tab-pane fade " id="indiceRotacionGeneral">
                <div >

                    <?php

                    include "form_reporteIndiceRotacionGeneral.php";
                    ?>
                </div>
            </div>
            <div class="tab-pane fade " id="indiceRotacionEntidad">
                <div >

                    <?php

                    include "form_reporteIndiceRotacionEntidades.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="renovacionCredenciales">
                <div >

                    <?php

                    include "form_renovacionCredenciales.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedorRegistroVacacionesPendientesAdmin">
                <div >

                    <?php

                    include "form_RegistroVacacionesPendientes.php";
                    ?>
                </div>
            </div>

             <div class="tab-pane fade " id="FlujoFiniquito">
                        <div >
                            <?php
                            include "form_FlujoFiniquito.php";
                            ?>
                        </div>
                    </div>
     
            <div class="tab-pane fade " id="permanenciaContrataciones">
                        <div >
                            <?php
                            include "form_Permanencia.php";
                            ?>
                        </div>
                    </div>

            <div class="tab-pane fade " id="plantillaSupervisorContrataciones">
                <div >
                    <?php
                    include "form_PlantillaSupervisor.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedorRotacionSupC">
                        <div >
                            <?php
                                include "rotacionSup/form_rotacionSup.html";
                            ?>
                        </div>
                    </div>

            <div class="tab-pane fade " id="consultaAsistencia">
                <div >
                    <?php
                        include "form_consultaAsistencia.php";
                    ?>
                </div>
            </div>

            <?php
        }
        ?>


        <?php
        if ($usuario["rol"] == "Supervisor" || $usuario["rol"] == "Analista Asistencia" || $usuario["rol"] == "Facturacion") {
            ?>
            <div class="tab-pane fade " id="contenedorRegistroAsistencia">
                <div >

                    <?php

                    include "form_registroAsistencia.php";
                    ?>
                </div>
            </div>

            <?php
        }
        ?>

        <?php
        if ($usuario["rol"] == "Administrador") {
            ?>



            <div class="tab-pane fade " id="contenedorNuevoUsuario">
                <div >
                    <?php

                    include "form_nuevoUsuario.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedorBloqueoUsuario">
                <div >
                    <?php

                    include "form_bloqueoUsuario.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedorEdicionUsuario">
                <div >
                    <?php

                    include "form_edicionUsuario.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedorNuevoSuperUsuario">
                <div >
                    <?php

                    include "SuperUsuario/SuperUsuario.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane  " id="ModificacionRegiones" align="center">
        <?php
            include "ModificacionRegiones/form_ModificacionRegiones.html";
        ?>
    </div>

    <div class="tab-pane  " id="relacionUsuarioRegión" align="center">
                <?php
                include "RelacionUsuarioRegion/relacionUsrRegion.php";
                ?>
            </div>


            <?php
        }
        ?>


         <?php
        if ($usuario["rol"] == "Gestion Administrativa") {
            ?>

            <div class="tab-pane fade " id="contenedorNuevaMatriz">
                <div >
                    <?php
                    include "NuevaMatriz/NuevaMatriz.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedorEdicionMatriz">
                <div >
                    <?php
                    include "EdicionMatriz/EdicionMatriz.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedorAsignacionMatriz">
                <div >
                    <?php
                    include "AsignacionMatriz/AsignacionMatriz.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedorSucursales">
                <div >
                    <?php
                    include "sucursalesInternas/form_Sucursales.php";
                    ?>
                </div>
            </div>

            <?php
        }
        ?>
                <!--
                    CONTENEDOR PARA EL ALMACENISTA
                    ************************************************************
                    ************************************************************

                -->


                <?php
                if ($usuario["rol"] == "Almacen") 
                {
                    ?>



                    <div class="tab-pane fade " id="registroProveedor">
                        <div >
                            <?php

                            include "form_nuevoProveedor.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="consultaProveedores">
                        <div >
                            <?php
                            include "form_consultaProveedores.php";
                            ?>
                        </div>
                    </div>


                    <div class="tab-pane fade " id="generacionFactura">
                        <div >
                            <?php
                            include "GenerarFactura/form_generacionFactura.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="consultasFactura">
                        <div >
                            <?php

                            include "form_consultaFacturas.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="nuevoTipoUni">
                        <div >
                            <?php

                            include "form_nuevoTipoUniforme.php";
                            ?>
                        </div>
                    </div>


                    <div class="tab-pane fade " id="asignacionUniforme">
                        <div >
                            <?php

                            include "form_asignacionUniforme.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="consultasUniformes">
                        <div >
                            <?php

                            include "form_consultaUniformes.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="historicoAlmacen">
                        <div >
                            <?php

                            include "form_HistoricoAlmacen.php";
                            ?>
                        </div>
                    </div>


                    <div class="tab-pane fade " id="consultaAsignaciones">
                        <div >
                            <?php

                            include "consultaAsignaciones/form_consultaAsignaciones.php";
                            ?>
                        </div>
                    </div>


                    <div class="tab-pane fade " id="transferenciaUniforme">
                        <div >
                            <?php

                            include "form_transferenciasUniforme.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="recepcionTransfer">
                        <div >
                            <?php

                            include "form_recepcionTransferencia.php";
                            ?>
                        </div>
                    </div>


                    <div class="tab-pane fade " id="consultaTransferencias">
                        <div >
                            <?php

                            include "ConsultaTransferencias/form_consultaTransferencias.php";
                            ?>
                        </div>
                    </div>


                    <div class="tab-pane fade " id="recepcionUniformes">
                        <div >
                            <?php

                            include "form_bajasEmpleadoUniformes.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="consultarRecibidos">
                        <div >
                            <?php

                            include "form_consultasUniRecibidos.php";
                            ?>
                        </div>
                    </div>


                    <div class="tab-pane fade " id="envioLavanderia">
                        <div >
                            <?php

                            include "form_envioLavanderia.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="consultaEnviosL">
                        <div >
                            <?php

                            include "form_consultaEnviosLava.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="SolicitudesUniformes">
                        <div >
                            <?php

                            include "form_SolicitudUniforme.php";
                            ?>
                        </div>
                    </div>


                    <?php
                }
                ?>

                <!--<div class="tab-pane fade " id="contenedorRequisicionesPersonal">
                    <div >

                        <?php

//include ("form_consultaRequisiciones.php");
?>
                    </div>
                </div>-->

                <div class="tab-pane fade " id="contenedorPlantillas">
                    <div >

                        <?php

                        include "form_consultaPlantillas.php";
                        ?>
                    </div>
                </div>
                <div class="tab-pane fade " id="contenedorVacantes">
                <div >
                 
                    <?php

                    include ("form_consultaVacantesPlantillas.php");
                    ?>
                </div>
            </div>

                <?php
                if ($usuario["rol"] == "Supervisor" || $usuario["rol"] == "Analista Asistencia" || $usuario["rol"] == "Facturacion") {
                    ?>

                    <div class="tab-pane fade " id="asistenciaPeriodo1">
                        <div >

                            <?php

                            include "form_asistenciaPeriodo1.php";
                            ?>
                        </div>
                    </div>
                    <div class="tab-pane fade " id="asistenciaPeriodo2">
                        <div >

                            <?php

                            include "form_asistenciaPeriodo2.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="asistenciaPeriodo3">
                        <div >

                            <?php

                            include "form_asistenciaPeriodo2.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="consultaAsistencia">
                        <div >
                            <?php

                            include "form_consultaAsistencia.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="contenedorFatiga">
                        <div >
                            <?php

                            include "form_consultaFatiga.php";
                            ?>
                        </div>
                    </div>



                    <div class="tab-pane fade " id="comentariosGuardias">
                        <div >

                            <?php
                            include "form_consultaComentariosGuardias.php";

                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="conteoincidenciasDia">
                        <div >

                            <?php
                            include "form_conteoIncidenciasPorDia.php";

                            ?>
                        </div>
                    </div>

                    





                    <?php
                }
                ?>

                <?php
                if ($usuario["rol"] == "Supervisor" || $usuario["rol"] == "Analista Asistencia" || $usuario["rol"] == "Facturacion") {
                    ?>

                    <div class="tab-pane fade " id="servEventuales">
                        <div >

                            <?php
                            include "form_serviciosEventuales.php";

                            ?>
                        </div>
                    </div>

                    <?php
                }
                ?>

                <?php
                if ($usuario["rol"] == "Supervisor" || $usuario["rol"] == "Analista Asistencia") {
                    ?>

                    

                    <div class="tab-pane fade " id="contenedorAsistenciaAP">
                        <div >
                            <?php

                            include "vistaasistencia.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="contenedorSupervisiones">
                        <div >
                            <?php

                            include "Supervisiones/vistaasistenciaSup.php";
                            ?>
                        </div>
                    </div>
                    <div class="tab-pane fade " id="contenedorArchivosIncapacidad">
                        <div >

                            <?php
                            include "form_visualizArchivosIncapacidad.php";

                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="contenedorArchivosVacaciones">
                        <div >

                            <?php
                                include "form_ReporteVacaciones.php";

                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="contenedorArchivoBajaEmpleado">
                <div >

                    <?php
                    include "form_ReporteBajasEmpleados.php";

                    ?>
                </div>
            </div>

                     <div class="tab-pane fade " id="contenedorArchivoBajaEmpleado">
                <div >

                    <?php
                    include "form_ReporteBajasEmpleados.php";

                    ?>
                </div>
            </div>

                    <?php
                }
                ?>

                <?php
                if ($usuario["rol"] == "Supervisor" || $usuario["rol"] == "Analista Asistencia" || $usuario["rol"] == "Lider Unidad" || $usuario["rol"] == "Contrataciones" ) {
                    ?>

                    <div class="tab-pane fade " id="contenedorSolicitudBaja">
                        <div >
                            <?php

                            include "form_consultaBajasSolicitadas.php";
                            ?>
                        </div>
                    </div>




                    <?php
                }
                ?>

                <?php
                if ($usuario["rol"] == "Analista Asistencia") {
                    ?>

                    <div class="tab-pane fade " id="contenedorhistoricoedicion">
                        <div >

                            <?php

                            include "form_HistoricoEdicion.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="contenedorAsignacionSupervisorPunto">
                        <div >
                            <?php

                            include "form_asignacionSupervisorPunto.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="contenedorAsistenciaAdministrativos">
                        <div >
                            <?php

                            include "AsistenciaAdministrativos/AsistenciaAdministrativos.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="reporteAsistencia">
                        <div >
                            <?php

                            include "form_reporteAsistencia.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="contenedorAsistenciaAP">
                        <div >
                            <?php

                            include "vistaasistencia.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="reporteIE">
                        <div >
                            <?php

                            include "form_reporteIncidenciasEspeciales.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="contenedorTransferencias">
                        <div >
                            <?php

                            include "form_tranferenciaDeSupervisor.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="diferencias">
                        <div >
                            <?php

                            include "form_diferencias.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="nominasGif">
                        <div >

                            <?php

                            include "form_nominasPDF.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="procesoNomina">
                        <div >

                            <?php

                            include "form_procesoNomina.php";
                            ?>
                        </div>
                    </div>
                    <div class="tab-pane fade " id="DiasTrabajados">
                        <div >

                            <?php

                            include "form_DiasTrabajados.php";
                            ?>
                        </div>
                    </div>
                    <div class="tab-pane fade " id="ConfirmacionPagoComplemento">
                        <div >

                            <?php

                            include "form_ConfirmacionPagoComplemento.php";
                            ?>
                        </div>
                    </div>
                    <div class="tab-pane fade " id="HistoricoComplementos">
                        <div >

                            <?php

                            include "form_HistoricoComplementos.php";
                            ?>
                        </div>
                    </div>
                    <div class="tab-pane fade " id="PeticionesAsistenciaMerma">
                        <div >

                            <?php
                            include "form_PeticionesAsistenciaMerma.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="EstatusPeticionAsistenciaMerma">
                        <div >

                            <?php
                            include "form_EstatusPeticionesAsistenciaMerma.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="plantillaSupervisorAnalistaAsistencia">
                        <div >
                            <?php
                            include "form_PlantillaSupervisor.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="GeoPuntos">
                        <div >
                            <?php
                            include "GeoPorPuntos/GeoPorPuntos.php";
                            ?>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade " id="HistoricopeticionesTurnoCapacitacion">
                        <div >
                            <?php
                            include "HistoricopeticionesTurnoCapacitacion/HistoricopeticionesTurnoCapacitacion.php";
                            ?>
                         </div>
                    </div>

                    <div class="tab-pane fade " id="ContenedorEstatusMovimientoTarjetaDespensa">
                        <div >
                            <?php
                                include "EstatusMovimientoTarjetaDespensa/EstatusMovimientoTarjetaDespensa.php";
                            ?>
                        </div>
                    </div>



                    <?php
                }
                ?>


                <?php
                if ($usuario["rol"] == "Facturacion" || $usuario["rol"] == "Contrataciones" ) {
                    ?>
                    <div class="tab-pane fade " id="reporteRequisiciones">
                        <div >

                            <?php

                            include "reporteRequisiciones.php";
                            ?>
                        </div>
                    </div>

                    <?php
                }
                ?>

                <?php
                if ($usuario["rol"] == "Facturacion") {
                    ?>
                    <div class="tab-pane fade " id="reporteFacturacion">
                        <div >

                            <?php

                            include "form_reporteFacturacion.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="reporteTurnos">
                        <div >

                            <?php

                            include "form_reporteTurnos.php";
                            ?>
                        </div>
                    </div>
                    <div class="tab-pane fade " id="reporteCoberturaUtilidad">
                        <div >

                            <?php

                            include "form_reporteCoberturaUtilidad.php";
                            ?>
                        </div>
                    </div>
                    <div class="tab-pane fade " id="catalogoPuntosServiciosFacturacion">
                        <div >

                            <?php

                            include "form_actualizacionPuntosServiciosFacturacion.php";
                            ?>
                        </div>
                    </div>


                    <div class="tab-pane fade " id="reporteConsultaFatigasEnviadas">
                        <div >

                            <?php

                            include "form_cosultaFatigasEnviadas.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="reporteDetalleFacturacion">
                        <div >

                            <?php

                            include "form_reporteDetalleFacturacion.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="GraficaConteoTurnoFacutacion">
                        <div >

                            <?php
                            include "form_Cobertura.php";
                            ?>
                         </div>
                    </div>

                    <div class="tab-pane fade " id="plantillaSupervisorFacturacion">
                        <div >
                            <?php
                            include "form_PlantillaSupervisor.php";
                            ?>
                        </div>
                    </div>

                    <?php
                }
                ?>

                <?php

                if ($usuario["rol"] == "Nomina") {
                    ?>
                    <div class="tab-pane fade " id="contenerdorSueldoEmpleados">
                        <div >

                            <?php
                            include "form_consultaSueldosEmpleados.php";
                            ?>
                        </div>
                    </div>
                    <div class="tab-pane fade " id="contenerdorActualizacionSueldoByPuntoServicio">
                        <div >

                            <?php
                            include "form_actualizacionSueldoByPuntoServicio.php";
                            ?>
                        </div>
                    </div>
                    <?php
                }
                ?>



                <?php

                if ($usuario["rol"] == "Reclutador") {
                    ?>


                    <div class="tab-pane fade " id="contenedorNuevoGuardia">
                        <div >

                            <?php
                            include "form_nuevoGuardia.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="contenedorPreseleccion">
                        <div >

                            <?php
                            include "form_consultaPreseleccion.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="asignacionUniformeReclutador">
                        <?php
                         include "form_asignacionUniformeSupervisor.php";        
                        ?>
                    </div>

                    <div class="tab-pane fade " id="historicoAsigReclu">
                        <?php
                         include "form_historicoAsignacionesSupervisor.php";        
                        ?>
                    </div>
                    
                    <div class="tab-pane fade " id="plantillaSupervisorReclutador">
                        <div >
                            <?php
                            include "form_PlantillaSupervisor.php";
                            ?>
                        </div>
                    </div>

                    <?php
                }
                ?>


                <?php

                if ($usuario["rol"] == "Contabilidad") {
                    ?>

                    


                    <div class="tab-pane fade " id="contenedorPrestamosF">
                        <div >

                            <?php
                            include "form_actualizaPrestamosF.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="contenedorPrestamosN">
                        <div >

                            <?php
                            include "form_actualizaPrestamosN.php";
                            ?>
                        </div>
                    </div>


                    <div class="tab-pane fade " id="contenedorAlimentosN">
                        <div >

                            <?php
                            include "form_actualizaAlimentosF.php";
                            ?>
                        </div>
                    </div>


                    <div class="tab-pane fade " id="contenedorPagosN">
                        <div >

                            <?php
                            include "form_actualizaPagosN.php";
                            ?>
                        </div>
                     </div>

                    <div class="tab-pane fade " id="HistoricoAcuerdosLaborales">
                        <div >

                            <?php
                            include "form_HistoricoAcuerdosLaborales.php";
                            ?>
                        </div>

                    </div>

                    <div class="tab-pane fade " id="HistoricoAdeudosEmpleados">
                        <div >

                            <?php
                            include "form_HistoricoAdeudosEmpleados.php";
                            ?>
                        </div>

                    </div>

                    <div class="tab-pane fade " id="HistoricoAdeudosEmpleadosRevisadas">
                        <div >

                            <?php
                            include "form_HistoricoAdeudosEmpleadosRevisadas.php";
                            ?>
                        </div>

                    </div>
                    <div class="tab-pane fade " id="geolocalizacion">
                        <div >

                            <?php
                            include "pruebageolocalizacion1.php";
                            ?>
                        </div>

                    </div>

                    <div class="tab-pane fade " id="DeudoresUnif">
                        <div >
                            <?php
                            include "form_DeudoresUniforme.php";
                            ?>
                        </div>

                    </div>

                    <div class="tab-pane fade " id="historicoDeudaUniformesContabilidad">
                        <div >
                            <?php
                            include "form_historicoDeudasUniformeContabilidad.php";
                            ?>
                        </div>

                    </div>

                     <div class="tab-pane fade " id="contenedorSAT">
                        <div >
                            <?php
                            include "SAT/form_SAT.php";
                            ?>
                        </div>

                    </div>
                     

                    <?php
                }
                ?>



                <?php

                if ($usuario["rol"] == "Cliente") {
                    ?>
                    <div class="tab-pane fade " id="guardiasCliente">
                        <div >

                            <?php
                            include "form_consultaEmpleadosDeCliente.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="consultaCoberturaClientes">
                        <div >

                            <?php
                            include "form_consultaCoberturaDeCliente.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="contentSuaPDF">
                        <div >

                            <?php
                            include "form_descargaDocumentosCliente.php";
                            ?>
                        </div>
                    </div>

                    <?php
                }
                ?>

                <?php
                if ($usuario["rol"] == "Socioeconomico" || $usuario["rol"] == "Consulta Rh") {
                    ?>
                    <div class="tab-pane fade " id="contentCapacitacion">
                        <div >

                            <?php

                            include "form_subirCapacitacion.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="contentPermiso">
                        <div >

                            <?php

                            include "form_subirPermiso.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="contentPermisoLocal">
                        <div >

                            <?php

                            include "form_subirPermisoLocal.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="contentC3">
                        <div >

                            <?php

                            include "form_subirDocumentC3.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="plantillaSupervisorEconomicoyConsultaRH">
                        <div >
                            <?php
                            include "form_PlantillaSupervisor.php";
                            ?>
                        </div>
                    </div>

                    <?php
                }
                ?>

                <!--NUEVO ROL CONSULTA SUPERVISOR-->

                <?php
                if ($usuario["rol"] == "Consulta Supervisor") {
                    ?>
                    <div class="tab-pane fade " id="consultaAsistencia">
                        <div >
                            <?php

                            include "form_consultaAsistencia.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="contenedorSolicitudBaja">
                        <div >
                            <?php

                            include "form_consultaBajasSolicitadas.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="contenedorFatiga">
                        <div >
                            <?php

                            include "form_consultaFatiga.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="servEventuales">
                        <div >

                            <?php
                            include "form_serviciosEventuales.php";

                            ?>
                        </div>
                    </div>


                    <div class="tab-pane fade " id="contenedorAsistenciaAP">
                        <div >
                            <?php

                            include "vistaasistencia.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="contenedorSupervisiones">
                        <div >
                            <?php

                            include "Supervisiones/vistaasistenciaSup.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane  " id="contenedorverpdf" align="center">
                        <?php
                        include "form_VerPdfCapacitacion.php";
                        ?>
                    </div>
                    <div class="tab-pane fade " id="reporteAsistencia">
                        <div >
                            <?php

                            include "form_reporteAsistencia.php";
                            ?>
                        </div>
                    </div>
                    <div class="tab-pane fade " id="reporteIE">
                        <div >
                            <?php

                            include "form_reporteIncidenciasEspeciales.php";
                            ?>
                        </div>
                    </div>
                    <div class="tab-pane fade " id="EstatusPeticionAsistenciaMermaCS">
                        <div>

                            <?php
                            include "form_EstatusPeticionesAsistenciaMerma.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="asignacionUniformeConsultaSupervisor">
                        <?php
                         include "form_asignacionUniformeSupervisor.php";        
                        ?>
                    </div>

                    <div class="tab-pane fade " id="historicoAsigCS">
                        <?php
                         include "form_historicoAsignacionesSupervisor.php";        
                        ?>
                    </div>

                    <div class="tab-pane fade " id="plantillaSupervisorConsultaSup">
                         <div >
                             <?php
                             include "form_PlantillaSupervisor.php";
                             ?>
                         </div>
                     </div>
                    <?php
                }
                ?>

                <?php
                if ($usuario["rol"] == "Tabulador Administrativo") {
                    ?>
                    <div class="tab-pane fade " id="tabuladoradministrativo">
                        <div >

                            <?php
//include "contenerdorSueldoEmpleados1.php";

                            include "form_sueldosAdministrativos.php";
                            ?>
                        </div>
                    </div>
                    <?php
                }
                ?>



                <?php

                if ($usuario["rol"] == "Direccion General") {
                    ?>
                    <div class="tab-pane fade " id="confirmacionsueldodirgeneral">
                        <div >

                            <?php
                            include "form_confirmarsueldodirgeneral.php";
                            ?>
                        </div>
                    </div>


                 <div class="tab-pane fade " id="consultahistoricosueldos">
                        <div >
                            <?php
                            include "form_consultahistoricosueldos.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="PeticionIncidenciasespeciales">
                        <div >

                            <?php
                            include "form_PeticionIncidenciasEspecialesDirGen.php";
                            ?>
                        </div>

                    </div>

                    <div class="tab-pane fade " id="HistorialIncidenciasEspeciales">
                        <div >

                            <?php
                            include "form_historialincidenciasespeciales.php";
                            ?>
                         </div>
                    </div>

                     <div class="tab-pane fade " id="PeticionesdefiniquitoDG">
                        <div >

                            <?php
                            include "form_piramidardirecciongeneral.php";
                            ?>
                         </div>
                    </div>

                    <div class="tab-pane fade " id="estatusfiniquitosdg">
                        <div >

                            <?php
                            include "form_FlujoFiniquito.php";
                            ?>
                         </div>
                    </div>

                    <div class="tab-pane fade " id="HistoricosFiniquitosDG">
                        <div >

                            <?php
                            include "form_HistoricoFiniquitosDG.php";
                            ?>
                         </div>
                    </div>

                     <div class="tab-pane fade " id="HistoricosConsultasEstatus">
                        <div >

                            <?php
                            include "form_HistoricoConsultaEstatusFiniquito.php";
                            ?>
                         </div>
                    </div>

                     <div class="tab-pane fade " id="GraficaRotacionXreclutador">
                        <div >

                            <?php
                            include "Form_ReportesGraficos.php";
                            ?>
                         </div>
                    </div>


                    <div class="tab-pane fade " id="PeticionesComplementosF">
                        <div >

                            <?php
                            include "form_PeticionesComplementosF.php";
                            ?>
                         </div>
                    </div>

                    <div class="tab-pane fade " id="GraficaConteoTurno">
                        <div >

                            <?php
                            include "form_Cobertura.php";
                            ?>
                         </div>
                    </div>
                    <div class="tab-pane fade " id="HistoricoComplementosDG">
                        <div >

                            <?php

                            include "form_HistoricoComplementos.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="CoberturaPorRegiones">
                        <div >

                            <?php

                            include "form_CoberturaPorRegiones.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="permanenciaDG">
                        <div >
                            <?php
                            include "form_Permanencia.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="detalleCobertura">
                        <div >
                            <?php
                            include "DetalleCobertura/form_detalleCobertura.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="contenedorPlantillas">
                        <div >
                            <?php
                                include "form_consultaPlantillas.php";
                            ?>
                        </div>
                    </div>
                    <div class="tab-pane fade " id="contenedorVacantes">
                        <div >
                            <?php
                                include ("form_consultaVacantesPlantillas.php");
                            ?>
                        </div>
                    </div> 

                    <div class="tab-pane fade " id="plantillaSupervisorContrataciones">
                        <div >
                            <?php
                                include "form_PlantillaSupervisor.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="reportePersonalPorFecha">
                        <div >
                            <?php
                                include "reporteGeneralPorFecha/reporteGeneralPorFecha.php";
                            ?>
                        </div>
                    </div>


                    <div class="tab-pane fade " id="reporteIncidenciaPorFecha">
                        <div >
                            <?php
                                include "IncidenciaReporte/form_ConsultaIncidencias.php";
                            ?>
                        </div>
                    </div>

                     <div class="tab-pane fade " id="contenedorOrganigramaDG">
                        <div >
                            <?php
                                include "organigrama/organigramaDG.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="contenedorDirectorio">
                        <div >
                            <?php
                                include "directorio/directorio.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="contenedorRotacionSupDG">
                        <div >
                            <?php
                                include "rotacionSup/form_rotacionSup.html";
                            ?>
                        </div>
                    </div>
                   

                    <?php
                }
                ?>




                <?php

                if ($usuario["rol"] == "Asistencia Administrativo") {
                    ?>
                    <div class="tab-pane fade " id="contentAdministrativo">
                        <div >

                            <?php
                            include "form_asistenciaAdministrativa.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="contentGetAsistenciaA">
                        <div >

                            <?php
                            include "form_consultaAsistenciaAdmin.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="contenedorArchivosIncapacidadAA">
                     <div >

                        <?php
                            include "form_visualizArchivosIncapacidad.php";

                        ?>
                    </div>
                </div>

                <div class="tab-pane fade " id="contenedorArchivosVacacionesAA">
                    <div >

                        <?php
                        include "form_ReporteVacaciones.php";

                        ?>
                    </div>
                </div>

                 <?php
                }
                ?>




                <?php

                if ($usuario["rol"] == "Asistencia Administrativa SES") {
                    ?>
                    <div class="tab-pane fade " id="contentAdministrativo">
                        <div >

                            <?php
                            include "form_asistenciaAdministrativa.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="contentGetAsistenciaA">
                        <div >

                            <?php
                            include "form_consultaAsistenciaAdmin.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="contenedorArchivosIncapacidadAASE">
                     <div >

                        <?php
                            include "form_visualizArchivosIncapacidad.php";

                        ?>
                    </div>
                </div>

                <div class="tab-pane fade " id="contenedorArchivosVacacionesAASE">
                    <div >

                        <?php
                        include "form_ReporteVacaciones.php";

                        ?>
                    </div>
                </div>

                    <?php
                }
                ?>


                <?php

                if ($usuario["rol"] == "Asistencia Administrativa ST") {
                    ?>
                    <div class="tab-pane fade " id="contentAdministrativo">
                        <div >

                            <?php
                            include "form_asistenciaAdministrativa.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="contentGetAsistenciaA">
                        <div >

                            <?php
                            include "form_consultaAsistenciaAdmin.php";
                            ?>
                        </div>
                    </div>
                    <div class="tab-pane fade " id="contenedorArchivosIncapacidadAAST">
                     <div >

                        <?php
                            include "form_visualizArchivosIncapacidad.php";

                        ?>
                    </div>
                </div>

                <div class="tab-pane fade " id="contenedorArchivosVacacionesAAST">
                    <div >

                        <?php
                        include "form_ReporteVacaciones.php";

                        ?>
                    </div>
                </div>

                    <?php
                }
                ?>




                <?php
                if ($usuario["rol"] == "Cobranza") 
                {
                    ?>
                    <div class="tab-pane  " id="contenedorcobranza" align="center">
                        <?php
                        include "form_Cobranzas.php";
                        ?>
                    </div>
                    <div class="tab-pane  " id="contenedortblcobroEntidades" align="center">
                        <?php
                        include "form_tblcobroEntidades.php";
                        ?>
                    </div>
                    <?php
                }
                ?>


                <?php
                if ($usuario["rol"] == "Comprobaciones de flujo") 
                {
                    ?>

                    <div class="tab-pane  " id="contenedorsolicitudrecursos" align="center">
                        <?php
                        include "form_SolicitudRecurso.php";
                        ?>
                    </div>
                    
                    <div class="tab-pane  " id="contenedorcomprobacion" align="center">
                        <?php
                        include "form_Comprobaciones.php";
                        ?>
                    </div>
                    
                    
                    
                    <?php
                }
                ?>



                <?php
                if ($usuario["rol"] == "Control Vehicular") 
                {
                    ?>

                    <div class="tab-pane  " id="contenedorregistrarvehiculo" align="center">
                        <?php

                        include "form_RegistrarVehiculo.php";
                        ?>
                    </div>

                    <div class="tab-pane  " id="contenedorregistrarvehiculo" align="center">
                        <?php
                        include "form_RegistrarVehiculo.php";
                        ?>
                    </div>

                    <div class="tab-pane  " id="contenedorasignacionesvehiculos" align="center">
                        <?php

                        include "form_AsiganrVehiculo.php";
                        ?>
                    </div>

                    <div class="tab-pane  " id="contenedoraverificacionvehicular" align="center">
                        <?php
                        include "form_VerificacionVehicular.php";
                        ?>
                    </div>

                    <div class="tab-pane  " id="contenedoractualizarlicencia" align="center">
                        <?php
                        include "form_ActualizarLicencia.php";
                        ?>
                    </div>

                    <div class="tab-pane  " id="contenedoractualizartarjetac" align="center">
                        <?php
                        include "form_ActualizarTarjetaDeCirculacion.php";
                        ?>
                    </div>

                    <div class="tab-pane  " id="contenedoractualizar" align="center">
                        <?php
                        include "form_ActualizarPoliza.php";
                        ?>
                    </div>

                    <div class="tab-pane  " id="contenedoredicionvehiculos" align="center">
                        <?php
                        include "form_HistoricoEdicionVehiculo.php";
                        ?>
                    </div>

                    <div class="tab-pane  " id="contenedorhistoricoasignaciones" align="center">
                        <?php
                        include "form_HistoricoAsignacionesVehiculares.php";
                        ?>
                    </div>

                    <div class="tab-pane  " id="contenedorhistoricoverificacionvehiculos" align="center">
                        <?php
                        include "form_HistoricoverificacionesVehiculares.php";
                        ?>
                    </div>

                    <div class="tab-pane  " id="reporteTotalVehiculos" align="center">
                        <?php
                        include "ReporteTotalVehicular/reporteTotalVehicular.php";
                        ?>
                    </div>
                    <div class="tab-pane  " id="FotosVehicularApp" align="center">
                        <?php
                            include "RevistaFotosVehiculosApp/form_RevistaFotosVehiculosApp.html";
                        ?>
                    </div>

                    <?php
                }
                ?>





                <?php
                if ($usuario["rol"] == "Gerente Vehicular") 
                {
                    ?>

                    <div class="tab-pane  " id="contenedoravehiculosasignados" align="center">
                        <?php
                        include "form_VehiculosAsignados.php";
                        ?>
                    </div>

                    <div class="tab-pane  " id="contenedoraverificacionvehicular" align="center">
                        <?php
                        include "form_VerificacionVehicular.php";
                        ?>
                    </div>

                    <div class="tab-pane  " id="contenedoractualizarlicencia" align="center">
                        <?php
                        include "form_ActualizarLicencia.php";
                        ?>
                    </div>

                    <div class="tab-pane  " id="contenedoractualizartarjetac" align="center">
                        <?php
                        include "form_ActualizarTarjetaDeCirculacion.php";
                        ?>
                    </div>

                    <div class="tab-pane  " id="contenedoractualizar" align="center">
                        <?php
                        include "form_ActualizarPoliza.php";
                        ?>
                    </div>

                    <div class="tab-pane  " id="reporteTotalVehiculosGV" align="center">
                        <?php
                            include "ReporteTotalVehicular/reporteTotalVehicular.php";
                        ?>
                    </div>
                    <div class="tab-pane  " id="FotosVehicularApp" align="center">
                        <?php
                            include "RevistaFotosVehiculosApp/form_RevistaFotosVehiculosApp.html";
                        ?>
                    </div>
                    
                    
                    <?php
                }
                ?>

                <?php
                if ($usuario["rol"] == "Consulta Rh") 
                {
                    ?>

                    <div class="tab-pane  " id="contenedorpdfcapacitacion" align="center">
                        <?php
                        include "form_PdfCapacitacion.php";
                        ?>
                    </div>

                    <div class="tab-pane  " id="contenedorverpdf" align="center">
                        <?php
                        include "form_VerPdfCapacitacion.php";
                        ?>
                    </div>

                    <?php
                }
                ?>

                <?php
                if ($usuario["rol"] == "Lider Unidad") 
                {
                    ?>

                    <div class="tab-pane  " id="contenedorverpdf" align="center">
                        <?php
                        include "form_VerPdfCapacitacion.php";
                        ?>
                    </div>

                    
                    <div class="tab-pane fade " id="FlujoFiniquito">
                     <?php
                      include "form_FlujoFiniquito.php";        
                     ?>
                    </div>

                    <div class="tab-pane fade " id="EstatusPeticionAsistenciaMermaLU">
                        <div>

                            <?php
                            include "form_EstatusPeticionesAsistenciaMerma.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="permanenciaLU">
                        <div>

                            <?php
                            include "form_Permanencia.php";
                            ?>
                        </div>
                    </div>
                    

            <div class="tab-pane fade " id="reporteReclutadores">
                <div >

                    <?php

                    include "form_reporteReclutadores.php";
                    ?>
                </div>
            </div>
            <div class="tab-pane fade " id="reporteProductividadReclutadores">
                <div >

                    <?php

                    include "form_productividadReclutador.php";
                    ?>
                </div>
            </div>
            
            <div class="tab-pane fade " id="indiceRotacionGeneral">
                <div >

                    <?php

                    include "form_reporteIndiceRotacionGeneral.php";
                    ?>
                </div>
            </div>
            <div class="tab-pane fade " id="indiceRotacionEntidad">
                <div >

                    <?php

                    include "form_reporteIndiceRotacionEntidades.php";
                    ?>
                </div>
            </div>
                    
            <div class="tab-pane fade " id="plantillaSupervisorLiderU">
                <div >
                    <?php
                    include "form_PlantillaSupervisor.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedordocumentoEmpeladosLU">
                <div >
                    <?php
                    include "ReporteDocumentos/form_ReporteDocumetos.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="reporteDocumentosXContratanteLU">
                <div >
                    <?php
                    include "ReporteDocumentosPorContratante/form_ReporteDocumentosPorContratante.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="ProcesoDeFirmaDelFiniquito5">
                <div >
                    <?php
                        include "EstatusDePagoFiniquito/gestionFiniquito.html";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="HistoricoMovimientosFiniquitosPago1">
                <div >
                    <?php
                        include "HistoricoMovimientosFiniquitosPago/HistoricoMovimientosFiniquitosPago.html";
                    ?>
                </div>
            </div>




                    <?php
                }
                ?>



                <?php
                if ($usuario["rol"] == "Supervisor") 
                {
                    ?>
                    <div class="tab-pane  " id="contenedorverpdf" align="center">
                        <?php
                        include "form_VerPdfCapacitacion.php";
                        ?>
                    </div>
                    <div class="tab-pane fade " id="reporteAsistencia">
                        <div >
                            <?php

                            include "form_reporteAsistencia.php";
                            ?>
                        </div>
                    </div>
                    <div class="tab-pane fade " id="reporteIE">
                        <div >
                            <?php

                            include "form_reporteIncidenciasEspeciales.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="EstatusPeticionAsistenciaMermaS">
                        <div>

                            <?php
                            include "form_EstatusPeticionesAsistenciaMerma.php";
                            ?>
                        </div>
                    </div>


                    <div class="tab-pane fade " id="FlujoFiniquito">
                        <?php
                         include "form_FlujoFiniquito.php";        
                        ?>
                    </div>

                    <div class="tab-pane fade " id="asignacionUniformeSupervisor">
                        <?php
                         include "form_asignacionUniformeSupervisor.php";        
                        ?>
                    </div>

                    <div class="tab-pane fade " id="historicoAsigSup">
                        <?php
                         include "form_historicoAsignacionesSupervisor.php";        
                        ?>
                    </div>


                    <div class="tab-pane fade " id="plantillaSupervisorSup">
                        <div >
                            <?php
                            include "form_PlantillaSupervisor.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="HistoricoReporteIncidenciaCentroControl">
                        <div >
                            <?php
                                include "HistoricoReporteIncidenciasCentroDeControl/HistoricoReporteIncidenciaCC.php";
                            ?>
                        </div>
                    </div>
                    <div class="tab-pane fade " id="RevisionReporteIncidenciaCentroControl">
                        <div >
                            <?php
                                include "RevisionReporteIncidenciaCentroControl/RevisionReporteIncidenciaCentroControl.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="contenedorRotacionSupS">
                        <div >
                            <?php
                                include "rotacionSup/form_rotacionSup.html";
                            ?>
                        </div>
                    </div>

                     <div class="tab-pane fade " id="contenedorKpiSupervisor">
                        <?php
                            include "kpiSupervisores/kpiSupervisores.html";
                        ?>
                    </div>
                    <?php
                }
                ?>



                <?php
                if ($usuario["rol"] == "Prenomina Administrativa") 
                {
                    ?>
                    <div class="tab-pane fade " id="contentGetAsistenciaA">
                        <div >

                            <?php
                            include "form_consultaAsistenciaAdmin.php";
                            ?>
                        </div>
                    </div>

    <!--<div class="tab-pane fade " id="procesoNomina">
        <div >

            <?php

                //include "form_procesoNomina.php";
            ?>
        </div>
    </div>  -->
    
    
    <?php
}
?>


<?php
if ($usuario["rol"] == "Telefonia") 
{
    ?>
    <div class="tab-pane  " id="contenedorregistrotelefono" align="center">
        <?php
        include "form_RegistrarTelefono.php";
        ?>
    </div>          
    
    <?php
}
?>

 <?php

    if ($usuario["rol"] == "Laborales") 
        {
 ?>
     <div class="tab-pane  " id="contenedor" align="center">
                  
        <?php
            include "formRegistroEmpleado.php";

        ?>
    </div>

    <div class="tab-pane  " id="contenedorCurp" align="center">

        <?php
            include "form_ComparacionCurp.php";

        ?>
    </div>

    <div class="tab-pane  " id="contenedorFiniquitosentidad" align="center">
               
        <?php
            include "../Nominas/finiquitos/finiquitos.php";

        ?>

    </div>
    <div class="tab-pane fade " id="contenedorArchivosIncapacidad">
    
        <?php
            include "form_visualizArchivosIncapacidad.php";
        ?>
    </div>

    <div class="tab-pane fade " id="contenedorArchivosVacaciones">
        <div>

            <?php
                include "form_ReporteVacaciones.php";

            ?>
        </div>
    </div>

    <div class="tab-pane  " id="contenedorConsultaEmpleado" align="center">

        <?php
            include "form_ConsultaPersonal.php";
        ?>
    </div>

   <div class="tab-pane fade " id="contenedorPlantillas">

        <?php
            include "form_consultaPlantillas.php";
        ?>
    </div> 
    <div class="tab-pane fade " id="contenedorVacantes">
                 
            <?php

                include ("form_consultaVacantesPlantillas.php");
            ?>
    </div>

    <div class="tab-pane fade " id="contenedorhistoricoedicion">

        <?php

            include "form_HistoricoEdicion.php";
        ?>

    </div>

    <div class="tab-pane fade " id="reportePersonalActivo">

        <?php
            include "reportePersonalActivo.php";
       ?>
    </div>

    <div class="tab-pane fade" id="consultaEstatusImss">

        <?php

            include "form_ConsultaEstatusImss.php";
        ?>
    </div>

    <div class="tab-pane fade " id="reportePersonalCapturado">

        <?php

            include "form_consultaPersonalFechaCaptura.php";
        ?>
    </div>

    <div class="tab-pane fade " id="reporteBajasPersonal">

        <?php

            include "form_consultaBajas.php";
        ?>
    </div>
    
    <div class="tab-pane fade " id="reporteReclutadores">

         <?php

            include "form_reporteReclutadores.php";
         ?>
    </div>
    
    <div class="tab-pane fade " id="reporteProductividadReclutadores">

        <?php

            include "form_productividadReclutador.php";
         ?>
    </div>
    
     <div class="tab-pane fade " id="indiceRotacionGeneral">

        <?php

            include "form_reporteIndiceRotacionGeneral.php";
         ?>
    </div>
    
    <div class="tab-pane fade " id="indiceRotacionEntidad">

        <?php

            include "form_reporteIndiceRotacionEntidades.php";
         ?>
    </div>
    
    <div class="tab-pane fade " id="renovacionCredenciales">

        <?php

            include "form_renovacionCredenciales.php";
         ?>
    </div>
    
     <div class="tab-pane fade " id="contenedorSolicitudBaja">
    
        <?php

            include "form_consultaBajasSolicitadas.php";

        ?>
 
    </div>

    <div class="tab-pane fade " id="reporteRequisiciones">

         <?php

            include "reporteRequisiciones.php";

         ?>
 
    </div>

    <div class="tab-pane fade " id="Finiquitosenesperacontrata">

         <?php

             include "form_FiniquitosEnNegociacion.php";

         ?>
 
    </div>

    <div class="tab-pane fade " id="contenedorUniformesParaFiniquitoP">

         <?php

             include "form_UniformesParaFiniquitosL.php";

         ?>
 
    </div>

    <div class="tab-pane fade " id="FlujoFiniquito">

       <?php
        
        include "form_FlujoFiniquito.php";        
        
        ?>
  
    </div>

    <div class="tab-pane fade " id="contenedorConfirmacionVacaciones">

       <?php
        
        include "form_ConfirmacionVacaciones.php";        
        
        ?>
  
    </div>

    <div class="tab-pane fade " id="ConfirmacionDiasVacacionesFiniquitos">

       <?php
        
        include "form_ConfirmacionDiasVacacionesFiniquito.php";        
        
        ?>
  
    </div>

    <div class="tab-pane fade " id="contenedorComplementoFiniquito">

       <?php
        
        include "form_ComplementosFiniquito.php";        
        
        ?>
  
    </div>

    <div class="tab-pane fade " id="plantillaSupervisorLaborales">
                <div >
                    <?php
                    include "form_PlantillaSupervisor.php";
                    ?>
                </div>
            </div>

    <div class="tab-pane fade " id="BetoDeElementos">
        <div >
            <?php
                include "BetoDeEmpleados/BetoDeElementos.php";
            ?>
        </div>
    </div>

    <div class="tab-pane fade " id="HistoricoVetoElementos">
        <div >
            <?php
                include "HistoricoVetoElementos/HistoricoVetoElementos.php";
            ?>
        </div>
    </div>

    <?php
        }
    ?>

<?php
if ($usuario["rol"] == "Coordinador Imss") {
?>
<div class="tab-pane fade " id="detalleContrato">
    <div >

        <?php
        include "form_DetalleContrato.php";
        ?>
    </div>
</div>

<div class="tab-pane fade " id="detalleTrabajadores">
    <div >

        <?php
        include "form_DetalleTrabajadores.php";
        ?>
    </div>
</div>


<div class="tab-pane fade " id="detalleSujetoObligado">
    <div >

        <?php
        include "form_DetalleSujetoObligado.php";
        ?>
    </div>
</div>

<div class="tab-pane fade " id="documentoEscrituraConstitutivaIMSS">
    <div >

        <?php
        include "form_DocumentoEscrituraConstitutiva.php";
        ?>
    </div>
</div>

<div class="tab-pane fade " id="documentoREPSEimss">
    <div >

        <?php
        include "form_DocumentoREPSE.php";
        ?>
    </div>
</div>

<div class="tab-pane fade " id="contenedorInfonavitF">
    <div >

        <?php

        include "form_actualizaInfonavitF.php";
        ?>
    </div>
</div>

    
    <?php
}
?>


<?php
if ($usuario["rol"] == "Tramites o Gestion") {
?>
<div class="tab-pane fade " id="escrituraPublica">
    <div >

        <?php
        include "form_escrituraPublica.php";
        ?>
    </div>
</div>

<div class="tab-pane fade " id="repse">
    <div >

        <?php
        include "form_CatalogoRepse.php";
        ?>
    </div>
</div>

<div class="tab-pane  " id="contenedorConsultaEmpleadoTG" align="center">
    <div >
        <?php
        include "form_ConsultaPersonal.php";
        ?>
    </div>
</div>

<div class="tab-pane  " id="contenedorpdfcapacitacion" align="center">
                        <?php
                        include "form_PdfCapacitacion.php";
                        ?>
                    </div>

                    <div class="tab-pane  " id="contenedorverpdf" align="center">
                        <?php
                        include "form_VerPdfCapacitacion.php";
                        ?>
                    </div>

<div class="tab-pane fade " id="contentCapacitacion">
                        <div >

                            <?php

                            include "form_subirCapacitacion.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="contentPermiso">
                        <div >

                            <?php

                            include "form_subirPermiso.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="contentPermisoLocal">
                        <div >

                            <?php

                            include "form_subirPermisoLocal.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="contentC3">
                        <div >

                            <?php

                            include "form_subirDocumentC3.php";
                            ?>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="plantillaSupervisorEconomicoyConsultaRH">
                        <div >
                            <?php
                            include "form_PlantillaSupervisor.php";
                            ?>
                        </div>
                    </div>




            <div class="tab-pane fade " id="contenedorPlantillas">
                <div >

                    <?php

                    include "form_consultaPlantillas.php";
                    ?>
                </div>
            </div>

            <div class="tab-pane fade " id="contenedorVacantes">
                <div >
                 
                    <?php

                    include ("form_consultaVacantesPlantillas.php");
                    ?>
                </div>
            </div> 

            <div class="tab-pane fade " id="contenedordocumentoEmpelados">
                <div >

                    <?php

                    include "ReporteDocumentos/form_ReporteDocumetos.php";
                    ?>
                </div>
            </div>
    
    <?php
}
?>

<?php
if ($usuario["rol"] == "Gerente Regional") {
?>
    
<div class="tab-pane fade " id="graficaConteoTurnoGerenteRegional">
    <div >
        <?php
        include "form_Cobertura.php";
        ?>
     </div>
</div>

<div class="tab-pane fade" id="plantillaSupervisorGerenteRegional">
    <div >

        <?php
        include "form_PlantillaSupervisor.php";
        ?>
    </div>
</div>

<div class="tab-pane fade " id="contenedorRotacionSupGR">
    <div >
        <?php
            include "rotacionSup/form_rotacionSup.html";
        ?>
    </div>
</div>

<div class="tab-pane fade " id="consultaAsistencia">
    <div >
        <?php
            include "form_consultaAsistencia.php";
        ?>
    </div>
</div>

<div class="tab-pane fade " id="PorcentajeAsistencia">
    <div >
        <?php
            include "PorcentajeAsistencia/form_PorcentajeAsistencia.html";
        ?>
    </div>
</div>

 <div class="tab-pane  " id="contenedorKpi" align="center">
     <?php
     include "KpiGerenteRegional/kpiGerenteRegional.html";
     ?>
 </div>

 <div class="tab-pane fade " id="contenedorSupervisiones">
    <div >
        <?php
        include "Supervisiones/vistaasistenciaSup.php";
        ?>
    </div>
</div>

<div class="tab-pane  " id="contenedoravehiculosasignados" align="center">
    <?php
        include "form_VehiculosAsignados.php";
    ?>
</div>

<div class="tab-pane  " id="contenedoraverificacionvehicular" align="center">
    <?php
        include "form_VerificacionVehicular.php";
    ?>
</div>

<div class="tab-pane  " id="FotosVehicularApp" align="center">
    <?php
        include "RevistaFotosVehiculosApp/form_RevistaFotosVehiculosApp.html";
    ?>
</div>

<div class="tab-pane  " id="reporteTotalVehiculosGV" align="center">
    <?php
        include "ReporteTotalVehicular/reporteTotalVehicular.php";
    ?>
</div>
                    
<div class="tab-pane  " id="contenedoractualizarlicencia" align="center">
    <?php
    include "form_ActualizarLicencia.php";

    ?>
</div>

<div class="tab-pane  " id="contenedoractualizartarjetac" align="center">
    <?php
    include "form_ActualizarTarjetaDeCirculacion.php";
    ?>
</div>

<div class="tab-pane  " id="contenedoractualizar" align="center">
    <?php
    include "form_ActualizarPoliza.php";
    ?>
</div>

<div class="tab-pane fade " id="contenedorComprobacionRegional">
     <?php
     include "form_SolicitudPago.php";
     ?>
 </div>
 <div class="tab-pane  " id="contenedorsolicitudrecursos" align="center">
     <?php
     include "form_SolicitudRecurso.php";
     ?>
 </div>
 
 <div class="tab-pane  " id="contenedorcomprobacion" align="center">
     <?php
     include "form_Comprobaciones.php";
     ?>
 </div>
    <?php
}
?>

<?php
if ($usuario["rol"] == "Capacitacion") {
?>
    
<div class="tab-pane fade " id="peticionesTurnoCapacitacion">
    <div >
        <?php
        include "PeticionesTurnoCapacitacion/form_PeticionesTurnosCapacitacion.php";
        ?>
     </div>
</div>

<div class="tab-pane fade " id="HistoricopeticionesTurnoCapacitacion">
    <div >
        <?php
        include "HistoricopeticionesTurnoCapacitacion/HistoricopeticionesTurnoCapacitacion.php";
        ?>
     </div>
</div>


    <?php
}
?>

<?php
    if ($usuario["rol"] == "Centro De Control") {
?>
        <div class="tab-pane fade " id="GraficaRotacionXreclutador">
            <div >
                <?php
                    include "Form_ReportesGraficos.php";
                ?>
            </div>
        </div>
        <div class="tab-pane fade " id="GraficaConteoTurno">
            <div >
                <?php
                    include "form_Cobertura.php";
                ?>
            </div>
        </div>
         <div class="tab-pane fade " id="CoberturaPorRegiones">
            <div >
                <?php
                    include "form_CoberturaPorRegiones.php";
                ?>
            </div>
        </div>
        <div class="tab-pane fade " id="permanenciaDG">
            <div >
                <?php
                    include "form_Permanencia.php";
                ?>
            </div>
        </div>
        <div class="tab-pane fade " id="detalleCobertura">
            <div >
                <?php
                    include "DetalleCobertura/form_detalleCobertura.php";
                ?>
            </div>
        </div>
        <div class="tab-pane fade " id="ReporteIncidenciaCentroControl">
            <div >
                <?php
                    include "IncidenciaCentroControl/GenerarIncidenciaCC.php";
                ?>
            </div>
        </div>
        <div class="tab-pane fade " id="HistoricoReporteIncidenciaCentroControl">
            <div >
                <?php
                    include "HistoricoReporteIncidenciasCentroDeControl/HistoricoReporteIncidenciaCC.php";
                ?>
            </div>
        </div>

        <div class="tab-pane fade " id="reportePersonalPorFecha">
            <div >
                <?php
                    include "reporteGeneralPorFecha/reporteGeneralPorFecha.php";
                ?>
            </div>
        </div>

        <div class="tab-pane fade " id="reporteIncidenciaPorFecha">
            <div >
                <?php
                    include "IncidenciaReporte/form_ConsultaIncidencias.php";
                ?>
            </div>
        </div>

        <div class="tab-pane fade " id="contenedorDirectorioCC">
             <div >
                 <?php
                     include "directorio/directorio.php";
                 ?>
             </div>
        </div>

        <div class="tab-pane fade " id="contenedorRotacionSupCC">
            <div >
                <?php
                    include "rotacionSup/form_rotacionSup.html";
                ?>
            </div>
        </div>
        <div class="tab-pane  " id="FotosVehicularApp" align="center">
            <?php
                include "RevistaFotosVehiculosApp/form_RevistaFotosVehiculosApp.html";
            ?>
        </div>

        <div class="tab-pane  " id="ModificacionRegiones" align="center">
        <?php
            include "ModificacionRegiones/form_ModificacionRegiones.html";
        ?>
    </div>

    <div class="tab-pane  " id="relacionUsuarioRegión" align="center">
                <?php
                include "RelacionUsuarioRegion/relacionUsrRegion.php";
                ?>
            </div>

            <div class="tab-pane  " id="HistoricoEditReporteIncidenciaCentroControl" align="center">
        <?php
            include "HistoricoReporteIncidenciasCentroDeControl/HistoricoEdicionesReporteIncidenciaCC.html";
        ?>
    </div>

    <div class="tab-pane  " id="contenedorCatalogoEsp" align="center">
        <?php
            include "CatalogoEspecificacionesIncidencias/form_Especificaciones.php";
        ?>
    </div>

    <div class="tab-pane  " id="contenedorCatalogoInc" align="center">
        <?php
            include "CatalogoIncidenciasCC/form_Incidenciascc.php";
        ?>
    </div>
<?php
    }
?>
    
<?php
        if ($usuario["rol"] == "Radio Operador") {
            ?>
            <div class="tab-pane fade " id="consultaAsistencia">
                <div >
                    <?php
                        include "form_consultaAsistencia.php";
                    ?>
                </div>
            </div>

            <?php
        }
        ?>

</div>
</body>


<script type="text/javascript">
//Funcion que se ejecuta cada 3 minutos para actualizar la lista de visitantes automaticaente
// Se ejecuta cuando el documento completa su carga y esta listo para
// que el usuario haga uso de él.
// http://api.jquery.com/ready/


var rolUsuario="<?php echo $usuario['rol']; ?>";
//alert(rolUsuario);

$(document).ready (function ()
{
    // borrarRegistrodeIngreso1(0);
   // setInterval("swal('ATENCIÓN', 'GRUPO GIF estará en mantenimiento el dia Martes 16/05/2023 a partir de las 16:00pm', 'warning');",1000000);//EL DIA 08/07/2021 

   // swal('ATENCIÓN', 'GRUPO GIF estará en mantenimiento el dia Martes 16/05/2023 a partir de las 16:00pm', 'warning');
<?php
 if ($usuario["rol"] == "Recepcion" or $usuario["rol"] == "Contrataciones" or $usuario["rol"] == "Laborales") {
    ?>

    var currentDate1 = $.datepicker.formatDate('yy-mm-dd', new Date());
    $("#txtFechaCapturaBaja").val(currentDate1);

    // obtenerListaVisitantesDelDia(0,10);
    // obtenerNumeroPaginas();
    // generarReporteFechaCaptura();
    // generarReporteFechaCapturaBaja();

    // setInterval("obtenerListaVisitantesDelDiaParaDeptoRH()",120000);
    // setInterval("obtenerListaVisitantesDelDia(0,10)",120000);
    // setInterval("obtenerNumeroPaginas()",120000);
    // setInterval("generarReporteFechaCapturaBaja()",120000);
    // setInterval("generarReporteFechaCaptura()",120000);
    <?php
}
?>
});//termina ready

function borrarRegistrodeIngreso1(IpABorrar){
    $.ajax({
        type: "POST",
        url: "LoginSuperUsuario/ajax_borrarRegistrodeIngresoSU.php",
        data:{"IpABorrar":IpABorrar},
        dataType: "json",
        async: false,
        success: function(response) {
            if(response.status == "success") {
                  //  funcionInicialDeLogeo();
            }else{
                var mensaje = response.message;
                swal("Alto",mensaje, "error");   
            }
        },error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
    });
}


<?php
if ($usuario["rol"] == "Contabilidad" or $usuario["rol"] == "Coordinador Imss" or $usuario["rol"] == "Laborales" or $usuario["rol"] == "Direccion General" or $usuario["rol"] == "Analista Asistencia") {
    ?>
        //FUNCION PARA CALCULAR FINIQUITOS CUANDO ESTEN LOS DEUDORES ACTUALIZADOS
        function calculoFiniquito(folioTxtBaja){
          $.ajax({
            async: false,
            type: "POST",
            url: "ajax_calculoFiniquito.php",
            data: {'folioTxtBaja': folioTxtBaja},
            dataType: "json",
            success: function(response) {
                var mensaje=response.mensaje;
                //console.log(response);
                if (response.status=="error")
                {
                    alert("Error al calcular finiquitos: "+mensaje);
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
              alert(jqXHR.responseText);
          }
      });
      }
 

      function verificarCierrePeriodo(periodo){
        var valor='';
        $.ajax({
            async: false,
            type: "POST",
            url: "ajax_verificaCierreNomina.php",
            data: {'periodo': periodo},
            dataType: "json",
            success: function(response) {
                var mensaje=response.mensaje;
                //console.log(response);
                if (response.status=="error")
                {
                    valor=mensaje;
                }else{
                    valor='correcto';
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
              alert(jqXHR.responseText);
          }
      });

        return valor;
    }

    <?php
}
?>

<?php
if  ($usuario["rol"] == "Comprobacion Regional" || $usuario["rol"] == "Finanzas") {
    ?>

    function cerrarpestaña(){
        $("#movimientoPanelActivator1").show("swing");
        $("#movimientoPanelActivator2").show("swing");
        $("#movimientoPanelActivator3").show("swing");
        $("#movimientoPanel2").hide("");
        $("#movimientoPanel1").hide("");

//    $("#ocultarbtn").css("display","block");
//    $("#btnTipoMovimientos").css("display","block");
//    $("#movimientoPanel2").hide();

}
function obtenerclaveclasificacion(valorClaves,check,CaseNegocioAbono){
  var valorClaves = valorClaves
  var check = check;
  var CaseNegocioAbono = 0;
  if (valorClaves != 0) {
      $.ajax({
          type: "POST",
          url: "ajax_obtenerListaClavesPorTipoMovimiento.php",
          data: {
              "valorClaves": valorClaves,
              "check": check,
              "case": CaseNegocioAbono
          },
          dataType: "json",
          async:false,  
          success: function(response) {
              var datos = response.listaClavesPorTipoMovimiento;
              $('#claveClasificacion').empty().append('<option value="0" selected="selected">CLAVES</option>');
              $.each(datos, function(i) {
                  $('#claveClasificacion').append('<option value="' + datos[i].claveClasificacion + '">' + datos[i].claveClasificacion + ":  " + datos[i].descripcionClasificacion + '</option>');
              });
          },
          error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
          }
      });
  } else {
      $('#claveClasificacion').empty().append('<option value="0" selected="selected">CLAVES</option>');
  }
}
function verificarCapturaSaldosIniciales()
{
  $.ajax({
    type: "POST",
    url: "ajax_obtieneSaldosIniciales.php",
    dataType: "json",
    success: function (response) {


        if (response.status == "success")
        {
            var listaSaldosIniciales = response.listaSaldosIniciales;
            var mensaje = "";

            for ( var i = 0; i < listaSaldosIniciales.length; i++ )
            {
                var bancoNombre = listaSaldosIniciales[i].nombreBanco;
                var saldoInicial = listaSaldosIniciales[i].saldoInicial;

                console.log (saldoInicial);

                if (saldoInicial == null || saldoInicial <= 0)
                {
                    mensaje += "No se ha capturado el saldo inicial del banco: " + bancoNombre + "\n";
                }
            }

            if (mensaje != "")
            {
                $.notify(mensaje, {autoHideDelay: 60000, className: 'warn'});
            }
        }
        else
        {
            console.log (response);
        }
    },
    error: function (response) {
        console.log (response);
    }
});
}
function datochecadoSolicituddepago(idsolicitudpago,accion,beneficiario,concepto,idempresa,idtipotransaccion,idlineanegocio,idclaveclasi,identidad,total,descripcionclaveclasi,banco,cuenta,cuentaclave){
  $.ajax({
      type: "POST",
      url: "ajax_updatetablasolicituddepagos.php",
      data:{"idsolicitudpago":idsolicitudpago,"accion":accion},
      dataType: "json",
      success: function(response) {
       if (response.status == "success")
       {   
        if(accion==="0"){
            cargardatosalform(idsolicitudpago,beneficiario,concepto,idempresa,idtipotransaccion,idlineanegocio,idclaveclasi,identidad,total,descripcionclaveclasi,banco,cuenta,cuentaclave);    
        }
        buscarSolicitudesDePagos();
    }
    else
    {
        var mensaje = response.message;
        console.log("mal");
    }
},
error: function(jqXHR, textStatus, errorThrown) {
 alert(jqXHR.responseText);
}
});
}

function cargardatosalform(idsolicitudpago,beneficiario,concepto,idempresa,idtipotransaccion,idlineanegocio,idclaveclasi,identidad,total,descripcionclaveclasi,banco,cuenta,cuentaclave){
    obtenerclaveclasificacion(idlineanegocio,0,0);
    //$("#movimientoPanelActivator1").toggle("");
    //$("#movimientoPanelActivator").css("display","none");

    $("#estatus").val(idsolicitudpago);
    $("#selectLineaNegocio").val(idlineanegocio);
    $("#tipoTransaccion").val(idtipotransaccion);
    $("#txtbeneficiario").val(beneficiario);
    $("#empresa").val(idempresa);
    $("#selectEntidades").val(identidad);
    $("#txtConcepto").val(concepto);
    $("#monto").val(total);
    $("#claveClasificacion").val(idclaveclasi);
    $("#impBancoDestinoAbono").val(banco);
    $("#impCuentaDestinoAbono").val(cuenta);
    $("#impCtaClaveDestinoAbono").val(cuentaclave);

    $("#txtDescuento").val(0);
    $("#txtIvaRetenido").val(0);
    $("#hdnbandera").val(1);
    $('#Reembolso').prop("checked",false);
    $('#Reembolso').val(0);

    $('#lblCLienteCaja').hide();
    $('#lblCLienteCaja1').hide();
    $('#guardarSolicitud').show("swing");
    $('#guardar').hide("swing");
    $('#btncancelar').hide("swing");
    $('#btncancelarSolicitud').show("swing");
    $('#lblBancoDestinoAbono').show("swing");
    $('#impBancoDestinoAbono').show("swing");
    $('#lblCuentaDestinoAbono').show("swing");
    $('#impCuentaDestinoAbono').show("swing");
    $('#lblCtaClaveDestinoAbono').show("swing");
    $('#impCtaClaveDestinoAbono').show("swing");

    $('#impBancoDestinoAbono').prop('readonly', true);
    $('#impCuentaDestinoAbono').prop('readonly', true);
    $('#impCtaClaveDestinoAbono').prop('readonly', true);
    $('#txtDescuento').prop('readonly', true);
    $('#txtIvaRetenido').prop('readonly', true);
    $('#txtSubTotal').prop('readonly', true);
    $('#txtConcepto').prop('readonly', true);
    $('#txtbeneficiario').prop('readonly', true);
    $('#selectLineaNegocio').prop('disabled', true);
    $('#empresa').prop('disabled', true);
    $('#selectEntidades').prop('disabled', true);
    $("#ocultarbtn").hide("swing");
    $("#movimientoPanel2").hide("swing");
    $("#movimientoPanel1").hide("swing");
    $("#movimientoPanelActivator1").hide("swing");
    $("#movimientoPanelActivator2").hide("swing");
    $("#movimientoPanelActivator3").hide("swing");
    $("#movimientoPanel2").toggle("slide");

}    <?php
}
?>
<?php
if ($usuario["rol"] == "Control Vehicular" ) {
    ?>

    function banderavehicular(banderavehicular){
        $("#banderaRegistroVehicular").val(banderavehicular);

        var banderaVehicular=$("#banderaRegistroVehicular").val();

        if(banderaVehicular=="1")
        {
            resetearformulariovehicular();
            bloquearylimpiarcamposdeinicio();
            getcatplacastipodeservicio();
            getcattarjetacirculacion();
            gettipodevehiculo();
            getcatnummotor();
            getcatestadovehiculo();
            getcatestadocilindadavehiculo();
            getcataseguradoras();
            getDestinoVehicular();
            CargarCatPaises();
            cargarLineaDeNegocio(); 
        }
        else if(banderaVehicular=="2"){
         resetearformulariovehicular();
         cargarOpcionesDeConsulta();
         BloquearYocultarCamposConsulta();
     }

 } 
 <?php
}
?>

</script>



</html>