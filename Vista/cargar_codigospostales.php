<?php
ini_set('max_execution_time', 1200);

require_once ("../Persistencia/Persistencia.class.php");


class CodigoPostalCargador extends Persistencia 
{
    function procesarArchivoCodigosPostales ()
    {
        $lines = file ("codigospostales.txt");
        
        $contador = 0;
        foreach ($lines as $line)
        {
            if (preg_match ("/^[0-9]{5}/", $line))
            {
                $datos = explode ("|", $line);
                
                
                // Insertamos el código postal
                $codigoPostal = $datos [0];
                
                $sql = "SELECT count(*) as cantidad from catalogocodigopostal where codigopostal ='" . mysqli_real_escape_string ($this -> conn, $codigoPostal) . "'";
                $res=mysqli_query($this -> conn, $sql );
                $reg=mysqli_fetch_array($res, MYSQLI_ASSOC);
                
                if ($reg ["cantidad"] == 0)
                {
                    $sql = "INSERT INTO catalogocodigopostal VALUES ('" . mysqli_real_escape_string ($this -> conn, $codigoPostal) . "')";
                    mysqli_query ($this -> conn, $sql);
                }
                
                // Insertamos el tipo de asentamiento
                $idTipoAsentamiento = $datos[10];
                $nombreTipoAsentamiento = $datos[2];
                
                $sql = "SELECT count(*) as cantidad from catalogotiposasentamientos where idTipoAsentamiento='" . mysqli_real_escape_string ($this -> conn, $idTipoAsentamiento) . "'";
                $res=mysqli_query($this -> conn, $sql );
                $reg=mysqli_fetch_array($res, MYSQLI_ASSOC);
                
                if ($reg ["cantidad"] == 0)
                {
                    $sql = "INSERT INTO catalogotiposasentamientos VALUES ('" . mysqli_real_escape_string ($this -> conn, $idTipoAsentamiento) . "', '" . mysqli_real_escape_string ($this -> conn, $nombreTipoAsentamiento) . "')";
                    mysqli_query ($this -> conn, $sql);
                }
                
                
                // Insertamos la entidad federativa
                $IdEntidadFederativa = $datos[7];
                $nombreEntidadFederativa = $datos[4];
                
                $sql = "SELECT count(*) as cantidad from entidadesfederativas where IdEntidadFederativa='" . mysqli_real_escape_string ($this -> conn, $IdEntidadFederativa) . "'";
                $res=mysqli_query($this -> conn, $sql );
                $reg=mysqli_fetch_array($res, MYSQLI_ASSOC);
                
                if ($reg ["cantidad"] == 0)
                {
                    $sql = "INSERT INTO entidadesfederativas VALUES ('" . mysqli_real_escape_string ($this -> conn, $IdEntidadFederativa) . "', '" . mysqli_real_escape_string ($this -> conn, $nombreEntidadFederativa) . "')";
                    mysqli_query ($this -> conn, $sql);
                }
                
                
                
                // Insertamos el municipio
                $nombreMunicipio = $datos[3];
                
                $sql = "SELECT idMunicipio from catalogomunicipios where nombreMunicipio = '" . mysqli_real_escape_string ($this -> conn, $nombreMunicipio) . "' AND idEstado='" . mysqli_real_escape_string ($this -> conn, $IdEntidadFederativa) . "'";
                $res=mysqli_query($this -> conn, $sql );
                $reg=mysqli_fetch_array($res, MYSQLI_ASSOC);
                
                $idMunicipio = 0;
                if ($reg != false)
                {
                    $idMunicipio = $reg["idMunicipio"];
                }
                else
                {
                    $sql = "INSERT INTO catalogomunicipios VALUES (null, '" . mysqli_real_escape_string ($this -> conn, $IdEntidadFederativa) . "', '" . mysqli_real_escape_string ($this -> conn, $nombreMunicipio) . "')";
                    mysqli_query ($this -> conn, $sql);
                    
                    $idMunicipio = mysqli_insert_id($this -> conn); 
                }
                
                // Insertamos el asentamiento
                $nombreAsentamiento = $datos[1];
                
                $sql = "INSERT INTO asentamientos VALUES (null, '" . mysqli_real_escape_string ($this -> conn, $nombreAsentamiento) . "'," .
                    "'" . mysqli_real_escape_string ($this -> conn, $codigoPostal) . "'," .
                    "'" . mysqli_real_escape_string ($this -> conn, $idTipoAsentamiento) . "'," .
                    "'" . mysqli_real_escape_string ($this -> conn, $idMunicipio) . "');";
                mysqli_query ($this -> conn, $sql);
                echo mysqli_error($this -> conn);
                
                
                if ($contador % 100 == 0)
                {
                    echo "<p>" . ($contador + 1) . ",</p>";
                }
                
                $contador++;
                /*
                echo "<pre>";
                echo $idMunicipio;
                print_r ($datos);
                echo "</pre>";
                */
                
            }
        }
    }
}


$cargador = new CodigoPostalCargador ();

$cargador -> procesarArchivoCodigosPostales ();
?>