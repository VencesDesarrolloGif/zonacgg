<?php
session_start ();

require_once ("../Negocio/Negocio.class.php");

$negocio = new Negocio ();

$target_dir = "uploads/";
$target_file = $target_dir . date("Y-m-d_His") . "_" . sha1(basename($_FILES["fileToUpload"]["name"]));
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
//if(isset($_POST["submit"])) {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
       // echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.<br>";
        
        
        // Obtiene un fragmento del archivo
        $fd = fopen ($target_file, "rb");
        $content = fread($fd, 25    );
        fclose ($fd);
        
       // echo "'" . $content . "'";
        
        $valid = false;
        if (preg_match ("/^.*Concepto \/ Referencia/", $content)  // Bancomer
            || preg_match ("/[0-9]{22}\-[0-9]{2}/", $content)  // Banco Azteca
            || preg_match ("/.*CUENTA.*FECHA.*/", $content))  // HSBC
        {
            $valid = true;
        }
        
        
        
        
        if ($valid == false)
        {
            unlink ($target_file);
            echo "<p>El archivo proporcionado no es válido</p>";
            exit (0);
        }
        
        $usuario = $negocio -> obtenerUsuarioLoggeado();
        
        $array = explode("\n", file_get_contents($target_file));

        $contenido = file_get_contents($target_file);
        
        $bancoAzteca='0127017201059108102015';
        $hsbc   = '000000004057356289';

        $encabezadoConcepto = 'Concepto / Referencia';
        $encabezadoDia = htmlentities('Día', ENT_QUOTES, 'UTF-8');
        $encabezadoCargo = 'cargo';
        $encabezadoAbono = 'Abono';
        $encabezadoSaldo = 'Saldo';

        

        $findBancoAzteca= strpos($contenido, $bancoAzteca);
        $findhsbc= strpos($contenido, $hsbc);

        $findBancomerConcepto = strpos($contenido, $encabezadoConcepto);
        $findBancomerDia = strpos($contenido, $encabezadoDia);
        $findBancomerCargo = strpos($contenido, $encabezadoCargo);
        $findBancomerAbono = strpos($contenido, $encabezadoAbono);
        $findBancomerSaldo = strpos($contenido, $encabezadoSaldo);

        $negocio -> negocio_crearTablaTemporal();
        

        if ($findBancoAzteca !== false) {
            echo "Banco: Banco Azteca";

            foreach ($array as $line)
            {
            
                $clabe = substr ($line, 0, 18);
                $fecha1 = substr ($line, 18, 10);
                $fecha2 = substr ($line, 28, 10);
                $clave = substr($line, 38,4);
                $consecutivo = substr($line, 42, 9);
                $saldoInicial = substr($line, 51, 21);
                $cantidad = substr ($line, 72, 18);
                $descripcion = substr($line, 90, 35);
                $saldofinal = substr ($line, 125, 18);
                $resto = substr($line, 143);

                /*
                echo "<p>Banco:<strong>Banco Azteca</strong></p>";
                echo "<p>clabe:<strong>" . $clabe . "</strong></p>";
                echo "<p>fecha1:<strong>" . $fecha1 . "</strong></p>";
                echo "<p>fecha2:<strong>" . $fecha2 . "</strong></p>";
                echo "<p>clave:<strong>" . $clave . "</strong></p>";
                echo "<p>consecutivo:<strong>" . $consecutivo . "</strong></p>";
                echo "<p>saldoInicial:<strong>" . $saldoInicial . "</strong></p>";
                echo "<p>cantidad:<strong>" . $cantidad . "</strong></p>";
                echo "<p>descripcion:<strong>" . $descripcion . "</strong></p>";
                echo "<p>saldofinal:<strong>" . $saldofinal . "</strong></p>";
                echo "<p>resto:<strong>" . $resto . "</strong></p>";
                echo "<hr />";
                */


                if($clave =='3080'){

                    
                    $tipoMovimiento=2;

                }else if($clave =='0254'){

                    
                    $tipoMovimiento=1;

                }
                
                $movimiento = array (
                    "fechaMovimiento" => $fecha1,
                    "idBanco" => 2,
                    "concepto" => $descripcion,
                    "referencia" => "",
                    "idEmpresa" => 1,
                    "monto" => $cantidad,
                    "usuario" => $usuario ["usuario"],
                    "idTipoMovimiento" =>2
                );
                
                if ($negocio -> registrarMovimientoArchivoBanco ($movimiento) == false)
                {
                    echo "Error";
                }
                
            }

        } else if($findhsbc !== false){
            echo "Banco: HSBC";


            foreach ($array as $line)
            {


                $valid = false;
                    if ( preg_match ("/.*CUENTA.*FECHA.*/", $line) )  // HSBC
                    {
                        $valid = true;
                    }
        
        
        
        
                if ($valid == false)
                {



                $cuenta = substr ($line, 0, 18);
                $day=substr($line, 18,2);
                $month=substr($line, 21,2);
                $year=substr($line, 24,4);

                $fecha = $year ."-". $month ."-". $day;
                $hora = substr ($line, 28, 8);
                $cheque = substr($line, 36,11);
                $descripcion = substr($line, 47, 40);
                $cargo = substr($line, 87, 13);
                $abono = substr($line, 100, 13);
                $saldo = substr($line, 113, 13);
                $signo = substr($line, 126, 5);
                $clave = substr($line, 131, 5);
                $folio = substr($line, 136, 10);
                $operador = substr($line, 146, 8);
                $referencia = substr($line, 154, 10);
                $sucursal = substr($line, 194, 8);

                if($signo =='CR052'){

                    $montoHsbc=$abono;
                    $tipoMovimiento=2;

                }else if($signo =='DR010'){

                    $montoHsbc=$cargo;
                    $tipoMovimiento=1;

                }
                          
                /*
                echo "<p>Linea:<strong>".$line."</strong></p>";
                echo "<p>Banco:<strong>HSBC</strong></p>";
                echo "<p>cuenta:<strong>" . $cuenta . "</strong></p>";
                echo "<p>fecha:<strong>" . $fecha . "</strong></p>";
                echo "<p>hora:<strong>" . $hora . "</strong></p>";
                echo "<p>cheque:<strong>" . $cheque . "</strong></p>";
                echo "<p>descripcion:<strong>" . $descripcion . "</strong></p>";
                echo "<p>cargo:<strong>" . $cargo . "</strong></p>";
                echo "<p>abono:<strong>" . $abono . "</strong></p>";
                echo "<p>saldo:<strong>" . $saldo . "</strong></p>";
                echo "<p>signo:<strong>" . $signo . "</strong></p>";
                echo "<p>clave:<strong>" . $clave . "</strong></p>";
                echo "<p>folio:<strong>" . $folio . "</strong></p>";
                echo "<p>operador:<strong>" . $operador . "</strong></p>";
                echo "<p>referencia:<strong>" . $referencia . "</strong></p>";
                echo "<p>sucursal:<strong>" . $sucursal . "</strong></p>";
                echo "<p>montoHsbc:<strong>" . $montoHsbc . "</strong></p>";
                echo "<p>tipoMovimiento:<strong>" . $tipoMovimiento . "</strong></p>";
                echo "<hr />";
                
                */
                
                $movimiento = array (
                    "fechaMovimiento" => $fecha,
                    "idBanco" => 3,
                    "concepto" => $descripcion,
                    "referencia" => $referencia,
                    "idEmpresa" => 1,
                    "monto" => $montoHsbc,
                    "usuario" => $usuario ["usuario"],
                    "idTipoMovimiento" =>$tipoMovimiento
                );
                
                if ($negocio -> registrarMovimientoArchivoBanco ($movimiento) == false)
                {
                    echo "Error";
                }
                
                }
            }
        } else if($findBancomerConcepto !== false and $findBancomerCargo !== false and $findBancomerAbono !== false and $findBancomerSaldo !== false){

            foreach( $array as $registro ) 
            {
                list( $fecha, $concepto, $cargo, $abono, $saldo ) = explode( "\t", $registro );


                $valid = false;
                    if ( preg_match ("/^.*Concepto \/ Referencia/", $registro))  // bancomer
                    {
                        $valid = true;
                    }

                
                if ($valid == false)
                {

                    $day=substr($fecha, 0,2);
                    $month=substr($fecha, 3,2);
                    $year=substr($fecha, 6,4);

                    $fechaFormat=$year ."-". $month ."-". $day;
                    echo "<p>linea:<strong>" . $registro . "</strong></p>";       
                    echo "<p>fecha:<strong>" . $fecha . "</strong></p>";
                    echo "<p>fecha:<strong>" . $fechaFormat . "</strong></p>";
                    echo "<p>concepto:<strong>" . $concepto . "</strong></p>";
                    if($cargo==""){

                    echo "<p>abono:<strong>" . $abono . "</strong></p>";
                    $tipoMovimiento=2;
                    $montoBancomer=$abono;

                    } else if ($abono=="") {
                    echo "<p>cargo:<strong>" . $cargo . "</strong></p>";
                    $tipoMovimiento=1;
                    $montoBancomer=$cargo;
                    }
                    
                    
                    echo "<p>saldo:<strong>" . $saldo . "</strong></p>";
                    echo "<hr />";


                    $movimiento = array (
                    "fechaMovimiento" => $fechaFormat,
                    "idBanco" => 1,
                    "concepto" => $concepto,
                    "referencia" => "",
                    "idEmpresa" => 1,
                    "monto" => $montoBancomer,
                    "usuario" => $usuario ["usuario"],
                    "idTipoMovimiento" =>$tipoMovimiento
                );

                
                    if ($negocio -> registrarMovimientoArchivoBanco ($movimiento) == false)
                {
                    echo "Error";
                }
                
                
                }
            }
    //    } else {
    //        echo "Sorry, there was an error uploading your file.";
    //    }
            }
        }
    

?> 