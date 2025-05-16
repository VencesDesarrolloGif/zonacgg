<?php
ini_set('max_execution_time', 1560000);

require_once ("../Persistencia/Persistencia.class.php");


class UnidadesMedicasCargador extends Persistencia 
{
    function procesarArchivoUmf ()
    {
        $lines = file ("empleados.txt");
        
        $contador = 0;
        foreach ($lines as $line)
        {
            
                $datos = explode ("|", $line);
                $valor="";
                
                // Insertamos el código postal
                $entidadFederativaId =$valor.$datos[0];
                $empleadoConsecutivoId = $datos [1];
                $empleadoCategoriaId = $datos [2];
                $apellidoPaterno = $datos [3];
                $apellidoMaterno = $datos [4];
                $nombreEmpleado = $datos [5];
                $fechaIngreso = $datos [6];
                $empleadoLocalizacion = $datos [7];
                $empleadoIdPuesto = $datos [8];
                $empleadoIdPuntoServicio = $datos [9];
                $empleadoIdTurno = $datos [10];
                $empleadoIdGenero = $datos [11];
                $empleadoNumeroSeguroSocial = $datos [12];
                $empleadoFechaCaptura = "2015-09-21";
                $numeroCta = $datos [14];
                $numeroCtaClabe = $datos [15];
                $empleadoEstatusId = $datos [16];
                $idTipoPuesto = $datos [17];
                $idEntidadTrabajo = $datos [18];
                $empleadoLineaNegocioId = $datos [19];
                $usuarioCapturaEmpleado = "vanessa";

                //print_r ($fechaIngresoEmpleado);

                $dia = substr ($fechaIngreso, 0, 2);
                $mes = substr ($fechaIngreso, 3, 2);
                $anio = substr ($fechaIngreso, 6, 4);

                $fechaIngresoEmpleado=$anio."-".$mes."-".$dia;
               
               /*
               echo "<p>" . $dia. "</p>";
               echo "<p>" . $mes . "</p>";
               echo "<p>" . $anio . "</p>";
               echo "<p>" . $fechaIngresoEmpleado . "</p>";

                */

               

                $sql = "insert into empleados (entidadFederativaId, empleadoConsecutivoId, empleadoCategoriaId,
                        apellidoPaterno,apellidoMaterno,nombreEmpleado, fechaIngresoEmpleado, empleadoLocalizacion, 
                        empleadoIdPuesto, empleadoIdPuntoServicio,empleadoIdTurno,empleadoIdGenero,empleadoNumeroSeguroSocial,
                        empleadoFechaCaptura, numeroCta,numeroCtaClabe, empleadoEstatusId, idTipoPuesto, idEntidadTrabajo,
                        empleadoLineaNegocioId,usuarioCapturaEmpleado) values ('" . mysqli_real_escape_string ($this -> conn, $entidadFederativaId) . "'," .
                    "'" . mysqli_real_escape_string ($this -> conn, $empleadoConsecutivoId) . "'," .
                    "'" . mysqli_real_escape_string ($this -> conn, $empleadoCategoriaId) . "'," .
                    "'" . mysqli_real_escape_string ($this -> conn, $apellidoPaterno) . "'," .
                    "'" . mysqli_real_escape_string ($this -> conn, $apellidoMaterno) . "'," .
                    "'" . mysqli_real_escape_string ($this -> conn, $nombreEmpleado) . "'," .
                    "'" . mysqli_real_escape_string ($this -> conn, $fechaIngresoEmpleado) . "'," .
                    "'" . mysqli_real_escape_string ($this -> conn, $empleadoLocalizacion) . "'," .
                    "'" . mysqli_real_escape_string ($this -> conn, $empleadoIdPuesto) . "'," .
                    "'" . mysqli_real_escape_string ($this -> conn, $empleadoIdPuntoServicio) . "'," .
                    "'" . mysqli_real_escape_string ($this -> conn, $empleadoIdTurno) . "'," .
                    "'" . mysqli_real_escape_string ($this -> conn, $empleadoIdGenero) . "'," .
                    "'" . mysqli_real_escape_string ($this -> conn, $empleadoNumeroSeguroSocial) . "'," .
                    "'" . mysqli_real_escape_string ($this -> conn, $empleadoFechaCaptura) . "'," .
                    "'" . mysqli_real_escape_string ($this -> conn, $numeroCta) . "'," .
                    "'" . mysqli_real_escape_string ($this -> conn, $numeroCtaClabe) . "'," .
                    "'" . mysqli_real_escape_string ($this -> conn, $empleadoEstatusId) . "'," .
                    "'" . mysqli_real_escape_string ($this -> conn, $idTipoPuesto) . "'," .
                    "'" . mysqli_real_escape_string ($this -> conn, $idEntidadTrabajo) . "'," .
                    "'" . mysqli_real_escape_string ($this -> conn, $empleadoLineaNegocioId) . "'," .
                    "'" . mysqli_real_escape_string ($this -> conn, $usuarioCapturaEmpleado) . "');";
                    
                    mysqli_query ($this -> conn, $sql);
                    echo mysqli_error($this -> conn);


                    print_r ($sql);
                
                
                if ($contador % 100 == 0)
                {
                    echo "<p>" . ($contador + 1) . ",</p>";
                }
                
                $contador++;
                
                echo "<pre>";
              
                print_r ($datos);
                //print_r ($codigoPostal);
                echo "</pre>";

        }
    }
}


$cargador = new UnidadesMedicasCargador ();

$cargador -> procesarArchivoUmf ();
?>