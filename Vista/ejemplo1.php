<?php    
/* CAT:Pie charts */

$v = isset($_GET["v"]) ? $_GET ["v"] : array (1);

$valores = array ();

for ($i = 0; $i < count($v); $i++)
{
    if (doubleval ($v[$i]) > 0)
    {
        $valores[] = $v[$i];
    }
}


 /* pChart library inclusions */
 include("../libs/chart/class/pData.class.php");
 include("../libs/chart/class/pDraw.class.php");
 include("../libs/chart/class/pPie.class.php");
 include("../libs/chart/class/pImage.class.php");

 /* Create and populate the pData object */
 $MyData = new pData();   
 $MyData->addPoints($valores,"Porcentaje Ingresos");  //valores para graficar
 //$MyData->setSerieDescription("ScoreA","Application A");

 /* Define the absissa serie */
 $MyData->addPoints(array("<10","10<>20","20<>40","40<>60","60<>80",">80"),"Labels");
 $MyData->setAbscissa("Labels");

 $width = 640;
 $height = 480;
 
 /* Create the pChart object */
 $myPicture = new pImage($width,$height,$MyData); //tamaño del rectangulo del grafico

 /* Draw a solid background */
$Settings = array("R"=>173, "G"=>152, "B"=>217, "Dash"=>1, "DashR"=>193, "DashG"=>172, "DashB"=>237);
$myPicture->drawFilledRectangle(0,0,$width,$height,$Settings);

 /* Draw a gradient overlay */
$Settings = array("StartR"=>100, "StartG"=>150, "StartB"=>231, "EndR"=>111, "EndG"=>3, "EndB"=>138, "Alpha"=>50);
 $myPicture->drawGradientArea(0,0,$width,$height,DIRECTION_VERTICAL,$Settings);//rectangulo
 $myPicture->drawGradientArea(0,0,$width,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>100)); //fondo

 /* Add a border to the picture */
 $myPicture->drawRectangle(0,0,$width,$height,array("R"=>0,"G"=>0,"B"=>0));//margen del rectangulo de la imagen

 /* Write the picture title */ 
 $myPicture->setFontProperties(array("FontName"=>"../libs/chart/fonts/Silkscreen.ttf","FontSize"=>10));
 $myPicture->drawText(10,13,"pPie - Draw 2D pie charts",array("R"=>255,"G"=>255,"B"=>255));

 /* Set the default font properties */ 
 $myPicture->setFontProperties(array("FontName"=>"../libs/chart/fonts/Forgotte.ttf","FontSize"=>10,"R"=>80,"G"=>80,"B"=>80));

 /* Enable shadow computing */ 
 $myPicture->setShadow(TRUE,array("X"=>2,"Y"=>2,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>50));

 /* Create the pPie object */ 
 $PieChart = new pPie($myPicture,$MyData);

 /* Draw a simple pie chart */ 
 //$PieChart->draw2DPie(120,125,array("SecondPass"=>FALSE));

 /* Draw an AA pie chart */ 
 //$PieChart->draw2DPie(340,125,array("DrawLabels"=>TRUE,"LabelStacked"=>TRUE,"Border"=>TRUE));

 /* Draw a splitted pie chart */  
 $PieChart->draw2DPie(320,240,array("WriteValues"=>PIE_VALUE_PERCENTAGE,"DataGapAngle"=>10,"DataGapRadius"=>6,"Radius"=>200,"Precision"=>2, "Border"=>TRUE,"BorderR"=>255,"BorderG"=>255,"BorderB"=>255)); //posicion de la grafica de pastel

 /* Write the legend */
 //$myPicture->setFontProperties(array("FontName"=>"../libs/chart/fonts/pf_arma_five.ttf","FontSize"=>6));
 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>50));
 
 //$myPicture->drawText(120,200,"Single AA pass",array("DrawBox"=>TRUE,"BoxRounded"=>TRUE,"R"=>0,"G"=>0,"B"=>0,"Align"=>TEXT_ALIGN_TOPMIDDLE));
 //$myPicture->drawText(440,200,"Extended AA pass / Splitted",array("DrawBox"=>TRUE,"BoxRounded"=>TRUE,"R"=>0,"G"=>0,"B"=>0,"Align"=>TEXT_ALIGN_TOPMIDDLE));

 /* Write the legend box */ 
 $myPicture->setFontProperties(array("FontName"=>"../libs/chart/fonts/Silkscreen.ttf","FontSize"=>6,"R"=>255,"G"=>255,"B"=>255));
 $PieChart->drawPieLegend(380,8,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));

 /* Render the picture (choose the best way) */
 $myPicture->autoOutput("pictures/example.draw2DPie.png"); 
?>


 