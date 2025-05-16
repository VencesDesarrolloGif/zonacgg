<?php
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");

$negocio = new Negocio ();


$target_dir = "uploads/";
$target_file = $target_dir . date("Y-m-d_His") . "_" . sha1(basename($_FILES["fileToUpload"]["name"]));
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
//if(isset($_POST["submit"])) {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.<br>";
        
        
        // Obtiene un fragmento del archivo
        $fd = fopen ($target_file, "rb");
        $content = fread($fd, 25    );
        fclose ($fd);
        
        //echo "'" . $content . "'";
        
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
            //echo "<p>El archivo proporcionado no es válido</p>";
            echo json_encode (array ("status" => "error", "message" => "El archivo proporcionado no es valido"));
            exit (0);
        }
        
        $usuario = $negocio -> obtenerUsuarioLoggeado ();
        
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

        $log = new KLogger ( "ajaxRegistroMovimientosBanco.log" , KLogger::DEBUG );
        

        if ($findBancoAzteca !== false) {
            //echo "Banco: Banco Azteca";

            foreach ($array as $line)
            {
            
                $clabe = substr ($line, 0, 18);
                $fecha1 = substr ($line, 18, 10);
                $fecha2 = substr ($line, 28, 10);
                $clave = substr($line, 38,4);
                $consecutivo = substr($line, 42, 9);
                $saldoInicial = substr($line, 51, 21);
                $cantidad = ltrim(substr ($line, 73, 17),2);
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
                    "monto" => ltrim($cantidad,0),
                    "usuario" => $usuario ["usuario"],
                    "idTipoMovimiento" =>$tipoMovimiento
                );
                
                if ($negocio -> negocio_insertarMovimientoArchivoBanco($movimiento) == false)
                {
                    echo "Error Banco Azteca";
                }
                
            }

        } else if($findhsbc !== false){
            //echo "Banco: HSBC";


            foreach ($array as $line)
            {
                    $valid = false;
                    if ( preg_match ("/.*CUENTA.*FECHA.*/", $line ) )  // HSBC
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

                $cargo1=ltrim(substr($line, 87, 11),0);
                $cargo2=substr($line, 98,2);

                $log->LogInfo("Valor de la variable \$cargo1: " . var_export ($cargo1, true));
                $log->LogInfo("Valor de la variable \$cargo2: " . var_export ($cargo2, true));

                $abono1=ltrim(substr($line, 100,11),0);
                $abono2=substr($line, 111,2);

                $log->LogInfo("Valor de la variable \$abono1: " . var_export ($abono1, true));
                $log->LogInfo("Valor de la variable \$abono2: " . var_export ($abono2, true));
             
                $saldo = substr($line, 113, 13);
                $signo = substr($line, 126, 5);
                $log->LogInfo("Valor de la variable \$signo: " . var_export ($signo, true));
                $clave = substr($line, 131, 5);
                $folio = substr($line, 136, 10);
                $operador = substr($line, 146, 8);
                $referencia = substr($line, 154, 10);
                $sucursal = substr($line, 194, 8);

                $cargo=$cargo1.".".$cargo2;
                $abono=$abono1.".".$abono2;

                $log->LogInfo("Valor de la variable \$cargo: " . var_export ($cargo, true));
                $log->LogInfo("Valor de la variable \$abono: " . var_export ($abono, true));

                if($cargo =='.00'){

                    $montoHsbc= $abono;
                    $tipoMovimiento=2;
                    
                    
                

                }else if($abono =='.00'){

                    $montoHsbc=$cargo;
                    $tipoMovimiento=1;
                    
                    
                    
                }
                          
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

                $log->LogInfo("Valor de la variable \$movimiento: " . var_export ($movimiento, true));

                
                
                if ($negocio -> negocio_insertarMovimientoArchivoBanco($movimiento) == false)
                {
                    echo "Error HSBC";
                }
                
                }
            }
        } else if($findBancomerConcepto !== false and $findBancomerCargo !== false and $findBancomerAbono !== false and $findBancomerSaldo !== false){

            foreach( $array as $registro ) 
            {
                    $fields = explode( "\t", $registro );
                    
                    if (count ($fields) != 5)
                    {
                        continue;
                    }
                    
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


                    // verifica si concepto contiene "referencia" "REF:"

                    

                    if ( preg_match ("/^.*REF:/", $concepto)) 
                    {

                        $findmeRef   = 'REF:';
                        $posRef = strpos($concepto, $findmeRef) + 4;
                        $referencia=ltrim(substr($concepto, $posRef,20),0);
                    
                    }else if( preg_match ("/^.*CH-/", $concepto)) //verifica si es cheque
                    {

                        $findmeCheque   = 'CH-';
                        $posCheque = strpos($concepto, $findmeCheque) + 3;
                        $referencia=substr($concepto, $posCheque,7);
                    
                    }else if( preg_match("/^.*REFBNTC/" , $concepto)){ // verifica si es deposito de tercero
                        $findmeDepositoTercero   = 'REFBNTC';
                        $posDepositoTercero= strpos($concepto, $findmeDepositoTercero) + 7;
                        $referencia=ltrim(substr($concepto, $posDepositoTercero,8),0);

                    }elseif ( preg_match("/^.*DEPOSITO EN EFECTIVO/" , $concepto)) { //DEPOSITO EN EFECTIVO

                        $findmeDepositoEfectivo   = 'DEPOSITO EN EFECTIVO/';
                        $posDepositoEfectivo= strpos($concepto, $findmeDepositoEfectivo) + 21;
                        $referencia=substr($concepto, $posDepositoEfectivo,7);
                        
                    }else if(preg_match("/^.*DEPOSITO EFECTIVO PRACTIC/" , $concepto)){

                        $findmeFolio   = 'FOLIO:';
                        $posFolio= strpos($concepto, $findmeFolio) +6;
                        $referencia=ltrim(substr($concepto, $posFolio,4),0);

                    }else if(preg_match("/^.*CREDITO LIQUIDO     DISP./" , $concepto)){
                        $findmeDisposicion  = 'DISP./';
                        $posDisposicion= strpos($concepto, $findmeDisposicion) +6;
                        $referencia=ltrim(substr($concepto, $posDisposicion,10),0);

                    }else if(preg_match("/^.*CREDITO LIQUIDO     LINEA/" , $concepto)){
                        $findmeDisposicion  = 'DISPOSICION NO';
                        $posDisposicion= strpos($concepto, $findmeDisposicion) + 14;
                        $referencia=ltrim(substr($concepto, $posDisposicion,10),0);

                    }else if(preg_match("/^.*PAGO CUENTA DE TERCERO/" , $concepto)){
                        $findmeCuenta  = 'PAGO CUENTA DE TERCERO/';
                        $posCuenta= strpos($concepto, $findmeCuenta) + 24;
                        $referencia=substr($concepto, $posCuenta,10);

                    }else if(preg_match("/^.*SPEI/" , $concepto)){
                        $findmeCuenta  = '/0';
                        $posCuenta= strpos($concepto, $findmeCuenta)+1;
                        $referencia=substr($concepto, $posCuenta,10);

                    }
                    else if(preg_match("/^.*COMISION CERTIFICACION/" , $concepto)){
                        $findmecheque  = 'COMISION CERTIFICACION/';
                        $poscheque= strpos($concepto, $findmecheque) + 23;
                        $referencia=ltrim(substr($concepto, $poscheque,7),0);

                    }
                    else if(preg_match("/^.*IVA COM. CERTIFICACION/" , $concepto)){
                        $findmecheque  = 'IVA COM. CERTIFICACION/';
                        $poscheque= strpos($concepto, $findmecheque) + 23;
                        $referencia=ltrim(substr($concepto, $poscheque,7),0);

                    }
                    else if(preg_match("/^.*DEP.CHEQUES DE OTRO BANCO/" , $concepto)){
                        $findmecheque  = 'DEP.CHEQUES DE OTRO BANCO/';
                        $poscheque= strpos($concepto, $findmecheque) + 26;
                        $referencia=substr($concepto, $poscheque,7);

                    }


                    

                    else{
                        $referencia="";
                    }



                    //echo "<p>linea:<strong>" . $registro . "</strong></p>";       
                    //echo "<p>fecha:<strong>" . $fecha . "</strong></p>";
                    //echo "<p>fecha:<strong>" . $fechaFormat . "</strong></p>";
                    //echo "<p>concepto:<strong>" . $concepto . "</strong></p>";
                    if($cargo==""){

                    //echo "<p>abono:<strong>" . $abono . "</strong></p>";
                    $tipoMovimiento=2;
                    $montoBancomer=str_replace(',','',$abono) ;

                    } else if ($abono=="") {
                    //echo "<p>cargo:<strong>" . $cargo . "</strong></p>";
                    $tipoMovimiento=1;
                    $montoBancomer=str_replace(',','',$cargo);
                    }
                    
                    
                   // echo "<p>saldo:<strong>" . $saldo . "</strong></p>";
                    //echo "<hr />";


                    $movimiento = array (
                    "fechaMovimiento" => $fechaFormat,
                    "idBanco" => 1,
                    "concepto" => $concepto,
                    "referencia" => $referencia,
                    "idEmpresa" => 1,
                    "monto" => $montoBancomer,
                    "usuario" => $usuario ["usuario"],
                    "idTipoMovimiento" =>$tipoMovimiento
                );

                
                    if ($negocio -> negocio_insertarMovimientoArchivoBanco($movimiento)== false)
                {
                    echo "Error Bancomer";
                }
                
                
                }
            }
    //    } else {
    //        echo "Sorry, there was an error uploading your file.";
    //    }
            }
        }

        echo json_encode (array ("status" => "success", "message" => "Se realizó la conciliación del archivo proporcionado"));
?> 