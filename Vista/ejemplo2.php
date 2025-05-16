<?php    
 /* CAT:Pie charts */ 
$v = isset($_GET["v"]) ? $_GET ["v"] : array (1);
$v2 = isset($_GET["v2"]) ? $_GET ["v2"] : array (2);
$valores = array ();
$valores2= array ();

for ($i = 0; $i < count($v); $i++)
{
    if (doubleval ($v[$i]) > 0)
    {
        $valores[] = $v[$i];
    }
}

for ($i = 0; $i < count($v2); $i++)
{
    
        $valores2[] = $v2[$i];
 
}

 /* pChart library inclusions */ 
 include("../libs/chart/class/pData.class.php"); 
 include("../libs/chart/class/pDraw.class.php"); 
 include("../libs/chart/class/pPie.class.php"); 
 include("../libs/chart/class/pImage.class.php"); 

 /* Create and populate the pData object */ 
 $MyData = new pData();    
 $MyData->addPoints($valores,"ScoreA");   
 $MyData->setSerieDescription("ScoreA","Application A"); 
 //$DataSet->AddPoint(array("Jan","Feb","Mar","Apr","May"),"Serie2");  


 $width = 640;
 $height = 480;

 /* Define the absissa serie */ 
 $MyData->addPoints($valores2,"Labels"); 
 //$MyData->addPoints(array("Jan","Feb","Mar","Apr","May"),"Labels"); 
 $MyData->setAbscissa("Labels"); 

 /* Create the pChart object */ 
 $myPicture = new pImage($width,$height,$MyData,TRUE); 

 /* Draw a solid background */ 
 $Settings = array("R"=>249, "G"=>252, "B"=>253, "Dash"=>1, "DashR"=>193, "DashG"=>172, "DashB"=>237); 
 $myPicture->drawFilledRectangle(0,0,$width,$height,$Settings); 

 /* Draw a gradient overlay */ 
 //$Settings = array("StartR"=>209, "StartG"=>150, "StartB"=>231, "EndR"=>111, "EndG"=>3, "EndB"=>138, "Alpha"=>50); 
 $Settings = array("StartR"=>80, "StartG"=>100, "StartB"=>200, "EndR"=>210, "EndG"=>252, "EndB"=>253, "Alpha"=>50);
 $myPicture->drawGradientArea(0,0,$width,$height,DIRECTION_VERTICAL,$Settings); 
 $myPicture->drawGradientArea(0,0,$width,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>100)); 

 /* Add a border to the picture */ 
 $myPicture->drawRectangle(0,0,$width,$height,array("R"=>0,"G"=>0,"B"=>0)); 

 /* Write the picture title */  
 $myPicture->setFontProperties(array("FontName"=>"../libs/chart/fonts/Silkscreen.ttf","FontSize"=>10)); 
 $myPicture->drawText(10,13,"INGRESOS",array("R"=>255,"G"=>255,"B"=>255)); 

 /* Set the default font properties */  
 $myPicture->setFontProperties(array("FontName"=>"../libs/chart/fonts/Forgotte.ttf","FontSize"=>15,"R"=>80,"G"=>80,"B"=>80)); 

 /* Create the pPie object */  
 $PieChart = new pPie($myPicture,$MyData); 

 

 /* Define the slice color */ 
 $PieChart->setSliceColor(0,array("R"=>170,"G"=>100,"B"=>20)); 
 $PieChart->setSliceColor(1,array("R"=>97,"G"=>77,"B"=>63)); 
 $PieChart->setSliceColor(2,array("R"=>97,"G"=>113,"B"=>63)); 

 /* Draw a simple pie chart */  
 //$PieChart->draw3DPie(120,125,array("SecondPass"=>FALSE)); 

 /* Draw an AA pie chart */  
 //$PieChart->draw3DPie(340,125,array("DrawLabels"=>TRUE,"Border"=>TRUE)); 

 /* Enable shadow computing */  
// $myPicture->setShadow(TRUE,array("X"=>3,"Y"=>3,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10)); 

 /* Draw a splitted pie chart */  
 $PieChart->draw3DPie(300,250,array("WriteValues"=>TRUE,"DataGapAngle"=>10,"DataGapRadius"=>6,"Border"=>TRUE, "Radius"=>200,"Precision"=>2)); 

 /* Write the legend */ 
 $myPicture->setFontProperties(array("FontName"=>"../libs/chart/fonts/pf_arma_five.ttf","FontSize"=>15)); 
 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>20)); 
 //$myPicture->drawText(120,200,"Single AA pass",array("DrawBox"=>TRUE,"BoxRounded"=>TRUE,"R"=>0,"G"=>0,"B"=>0,"Align"=>TEXT_ALIGN_TOPMIDDLE)); 
 //$myPicture->drawText(440,200,"Extended AA pass / Splitted",array("DrawBox"=>TRUE,"BoxRounded"=>TRUE,"R"=>0,"G"=>0,"B"=>0,"Align"=>TEXT_ALIGN_TOPMIDDLE)); 

 /* Write the legend box */  
 $myPicture->setFontProperties(array("FontName"=>"../libs/chart/fonts/Silkscreen.ttf","FontSize"=>12,"R"=>255,"G"=>255,"B"=>255)); 
 $PieChart->drawPieLegend(10,40,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_VERTICAL)); 
  

 /* Render the picture (choose the best way) */ 
 $myPicture->autoOutput("pictures/example.draw3DPie.png"); 
?>

