<?php
$target_dir = "uploads/";
$target_file = $target_dir . date("Y-m-d_His") . "_" . sha1(basename($_FILES["fileToUpload"]["name"]));
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
     {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        
        $array = explode("\n", file_get_contents($target_file));


        foreach( $array as $registro ) {
       list( $fecha, $concepto, $cargo, $abono, $saldo ) = explode( "\t", $registro );

       echo "<p>fecha:<strong>" . $fecha . "</strong></p>";
       echo "<p>concepto:<strong>" . $concepto . "</strong></p>";
       echo "<p>cargo:<strong>" . $cargo . "</strong></p>";
       echo "<p>abono:<strong>" . $abono . "</strong></p>";
       echo "<p>saldo:<strong>" . $saldo . "</strong></p>";
       echo "<hr />";
       
} 
    
       
        }

        
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

?> 