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
            // Procesamos los datos para el archivo de banco azteca
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
        }
        
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?> 