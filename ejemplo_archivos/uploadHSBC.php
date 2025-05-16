<?php
$target_dir = "uploads/";
$target_file = $target_dir . date("Y-m-d_His") . "_" . sha1(basename($_FILES["fileToUpload"]["name"]));
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        
        $array = explode("\n", file_get_contents($target_file));
        
        foreach ($array as $line)
        {
            // Procesamos los datos para el archivo de hsbc
            $cuenta = substr ($line, 0, 18);
            $fecha = substr ($line, 18, 10);
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
            echo "<hr />";
            
        }
        
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?> 