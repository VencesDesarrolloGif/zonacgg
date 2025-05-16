<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");
require_once ("../libs/Classes/PHPExcel.php");

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="01simple.xls"');
header('Cache-Control: max-age=0');
?>
<html>
<head>
  <title>Mi primera página con estilo</title>
  <style type="text/css">
    .text{
  mso-number-format:"\@";/*force text*/
    }
  </style>
</head>
<body>

<table border='1' class='table table-bordered' id='reporteGeneralExport' name='reporteGeneralExport'><thead><th>#Empleado</th><th>apellidoPaterno</th><th>apellidoMaterno</th><th>Nombre</th><th>fechaIngreso</th><th>fechaBaja</th><th>RFC</th><th>CURP</th>
<th>NumeroIMSS</th><th>numeroCta</th><th>numeroCtaClabe</th><th>Periodo</th><th>Puesto</th><th>TipoPuesto</th><th>TipoTurno</th><th>Entidad Laboral</th><th>Punto Servicio</th><th>Cliente</th><th>Sexo</th><th>EstatusEmpleado</th><th>EdoCivil</th>
<th>fechaNacimiento</th><th>paisNacimiento</th><th>nacionalidad</th><th>EntidadNacimiento</th><th>municipioNacimiento</th><th>GradoEstudios</th><th>estatusCartilla</th><th>numeroCartilla</th><th>oficio</th><th>tipoSangre</th><th>Tes</th><th>Estatura</th><th>TallaCamisa</th><th>TallaPantalon</th><th>NumeroCalzado</th><th>Peso</th>
<th>calle</th><th>numeroExterior</th><th>numeroInterior</th><th>Colonia</th><th>Municipio</th><th>entidadFederativa</th><th>telefonoFijo</th>
<th>Tel Movil</th><th>Correo</th><th>Umf</th><th><?php echo utf8_decode("Medio información");?></th><th>Tipo Baja</th><th>Motivo Baja</th><th>Comentario Baja</th><th>Reclutador</th><th>Codigo Postal</th><th>Codigo Postal Fiscal</th><th>Entidad Fiscal</th><th>Colonia Fiscal</th><th>Vialidad Fiscal</th><th>Numero Ext Fiscal</th><th>Numero Int Fiscal</th></thead><tbody>

<?php

$negocio = new Negocio();
verificarInicioSesion ($negocio);

$empleados= $negocio -> consultaGeneral();


        for ($i = 0; $i < count($empleados); $i++)
        {   
            $numeroEmpleado = $empleados[$i] ["numeroEmpleado"];
            $apellidoPaterno= utf8_decode($empleados[$i] ["apellidoPaterno"]);
            $apellidoMaterno= utf8_decode($empleados[$i] ["apellidoMaterno"]);
            $nombreEmpleado = utf8_decode($empleados[$i] ["nombreEmpleado"]);
            $fechaIngreso = $empleados[$i] ["fechaIngreso"];
            $fechaBaja = $empleados[$i] ["fechaBaja"];
            $Rfc = $empleados[$i] ["Rfc"];
            $Curp = $empleados[$i] ["Curp"];
            $NumeroIMSS = $empleados[$i] ["NumeroIMSS"];
            $numeroCta = $empleados[$i] ["numeroCta"];
            $numeroCtaClabe = $empleados[$i] ["numeroCtaClabe"];
            $tipoPeriodo = $empleados[$i] ["tipoPeriodo"];
            $Puesto = $empleados[$i] ["Puesto"];
            $TipoPuesto= $empleados[$i]["TipoPuesto"];
            $TipoTurno = $empleados[$i] ["TipoTurno"];
            $puntoServicio = utf8_decode($empleados[$i] ["puntoServicio"]);
            $nombreCliente = utf8_decode($empleados[$i] ["cliente"]);
            $Sexo = $empleados[$i] ["Sexo"];
            $EstatusEmpleado = $empleados[$i] ["EstatusEmpleado"];            
            $fechaNacimiento = $empleados[$i] ["fechaNacimiento"];
            $nombrePais = utf8_decode($empleados[$i] ["nombrePais"]);
            $nacionalidad = utf8_decode($empleados[$i] ["nacionalidad"]);
            $entidadFederativaNac = utf8_decode($empleados[$i] ["entidadFederativaNac"]);
            $municipioNacimiento = utf8_decode($empleados[$i] ["municipioNacimiento"]);
            $GradoEstudios = utf8_decode($empleados[$i] ["GradoEstudios"]);
            $estatusCartilla = utf8_decode($empleados[$i] ["estatusCartilla"]);
            $numeroCartilla = utf8_decode($empleados[$i] ["numeroCartilla"]);
            $oficio = utf8_decode($empleados[$i] ["oficio"]);
            $tipoSangre = utf8_decode($empleados[$i] ["tipoSangre"]);
            $tesEmpleado = utf8_decode($empleados[$i] ["tesEmpleado"]);
            $estaturaEmpleado = utf8_decode($empleados[$i] ["estaturaEmpleado"]);
            $tallaCEmpleado = utf8_decode($empleados[$i] ["tallaCEmpleado"]);
            $tallaPEmpleado = utf8_decode($empleados[$i] ["tallaPEmpleado"]);
            $numCalzadoEmpleado = utf8_decode($empleados[$i] ["numCalzadoEmpleado"]);
            $pesoEmpleado = utf8_decode($empleados[$i] ["pesoEmpleado"]);
            $cpvivienda=$empleados[$i] ["CP"];
            $calle=  strtoupper (utf8_decode($empleados[$i] ["calle"]));
            $numeroExterior = utf8_decode($empleados[$i] ["numeroExterior"]);
            $numeroInterior = utf8_decode($empleados[$i] ["numeroInterior"]);
            $Colonia =strtoupper ( utf8_decode($empleados[$i] ["Colonia"]));
            $nombreMunicipio =strtoupper ( utf8_decode($empleados[$i] ["nombreMunicipio"]));
            $entidadFederativa = strtoupper (utf8_decode($empleados[$i] ["entidadFederativa"]));
            $telefonoFijoEmpleado = utf8_decode($empleados[$i] ["telefonoFijoEmpleado"]);
            $telefonoMovilEmpleado = utf8_decode($empleados[$i] ["telefonoMovilEmpleado"]);
            $correoEmpleado = utf8_decode($empleados[$i] ["correoEmpleado"]);
            $nombreUnidad = strtoupper (utf8_decode($empleados[$i] ["nombreUnidad"]));
            $EdoCivil = utf8_decode($empleados[$i] ["EdoCivil"]);
            $entidadLaboral=utf8_decode(strtoupper($empleados[$i]["entidadLaboral"]));
            $nombreMedio=utf8_decode(strtoupper($empleados[$i]["nombreMedio"]));
            $nombreReclutador=utf8_decode(strtoupper($empleados[$i]["nombreReclutador"]));
            
            $motivoBaja=utf8_decode(strtoupper($empleados[$i]["motivoBaja"]));
            $comentarioBaja=utf8_decode(strtoupper($empleados[$i]["comentarioBaja"]));
            $tipoBaja=utf8_decode(strtoupper($empleados[$i]["tipoBaja"]));
            $CodigoPostalDF=utf8_decode(strtoupper($empleados[$i]["CodigoPostalDF"]));
            $ColoniaDF=utf8_decode(strtoupper($empleados[$i]["ColoniaDF"]));
            $VialidadDF=utf8_decode(strtoupper($empleados[$i]["VialidadDF"]));
            $NumeroExternoDF=utf8_decode(strtoupper($empleados[$i]["NumeroExternoDF"]));
            $NumeroInternoDF=utf8_decode(strtoupper($empleados[$i]["NumeroInternoDF"]));
            $EntidadFiscal=utf8_decode(strtoupper($empleados[$i]["EntidadFiscal"]));
            

            if($tesEmpleado == 1)
                $tesEmpleado="CLARA";
            if($tesEmpleado==2)
                $tesEmpleado="MORENA";

            echo("<tr><td>".$numeroEmpleado."</td><td>".$apellidoPaterno."</td><td>".$apellidoMaterno."</td><td>".$nombreEmpleado."</td><td>".$fechaIngreso."</td><td>".$fechaBaja."</td><td>".$Rfc."</td><td>".$Curp."</td>");
            echo("<td class='text'>".$NumeroIMSS."</td><td class='text'>".$numeroCta."</td><td class='text'>".$numeroCtaClabe."</td><td class='text'>".$tipoPeriodo."</td><td>".$Puesto."</td><td>".$TipoPuesto."</td><td>".$TipoTurno."</td><td>".$entidadLaboral."</td><td>".$puntoServicio."</td><td>".$nombreCliente."</td><td>".$Sexo."</td>");
            echo("<td>".$EstatusEmpleado."</td><td>".$EdoCivil."</td><td>".$fechaNacimiento."</td><td>".$nombrePais."</td><td>".$nacionalidad."</td><td>".$entidadFederativaNac."</td><td>".$municipioNacimiento."</td>");
            echo("<td>".$GradoEstudios."</td><td>".$estatusCartilla."</td><td>".$numeroCartilla."</td><td>".$oficio."</td><td>".$tipoSangre."</td><td>".$tesEmpleado."</td><td>".$estaturaEmpleado."</td><td>".$tallaCEmpleado."</td><td>".$tallaPEmpleado."</td><td>".$numCalzadoEmpleado."</td><td>".$pesoEmpleado."</td><td>".$calle."</td><td>".$numeroExterior."</td>");
            echo("<td>".$numeroInterior."</td><td>".$Colonia."</td><td>".$nombreMunicipio."</td><td>".$entidadFederativa."</td><td class='text'>".$telefonoFijoEmpleado."</td><td class='text'>".$telefonoMovilEmpleado."</td><td>".$correoEmpleado."</td>");
            echo("<td>".$nombreUnidad."</td><td>".$nombreMedio."</td><td>".$tipoBaja."</td><td>".$motivoBaja."</td><td>".$comentarioBaja."</td><td>".$nombreReclutador."</td><td class='text'>".$cpvivienda."</td><td class='text'>".$CodigoPostalDF."</td><td class='text'>".$EntidadFiscal."</td><td class='text'>".$ColoniaDF."</td><td class='text'>".$VialidadDF."</td><td class='text'>".$NumeroExternoDF."</td><td class='text'>".$NumeroInternoDF."</td></tr>");
            
            //$lista[$i]["diferencia"]=abs($elementosContratados-$numeroElementos);

        }
        

?>

</tbody></table>
</body>
</html>