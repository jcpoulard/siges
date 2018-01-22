<?php 
/*
 * © 2015 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
 * 
 * This file is part of SIGES.

    SIGES is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License.

    SIGES is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with SIGES.  If not, see <http://www.gnu.org/licenses/>.
 * 
 */

?>
<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
                    
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />


<!-- new Css3 -->
	
	
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	
		
		
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/normalize.css" />
	
	<?php
	  $baseUrl = Yii::app()->baseUrl; 
	  $cs = Yii::app()->getClientScript();
	  Yii::app()->clientScript->registerCoreScript('jquery');
	?>
	
	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/responsive.css" />
	

		<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->


	

<?php 
      $baseUrl = Yii::app()->baseUrl; 
       $cs = Yii::app()->getClientScript(); 
	   $cs->registerCssFile($baseUrl.'/css/bootstrap.min.css');
	   $cs->registerCssFile($baseUrl.'/css/bootstrap-responsive.min.css');
	   $cs->registerCssFile($baseUrl.'/css/abound.css');
           $cs->registerCssFile($baseUrl.'/css/font-awesome.min.css');
           $cs->registerCssFile($baseUrl.'/css/ionicons.min.css');
           $cs->registerCssFile($baseUrl.'/css/raport.css');
           $cs->registerCssFile($baseUrl.'/css/formstyle.css');
           $cs->registerCssFile($baseUrl.'/css/log.css');
            $cs->registerCssFile($baseUrl.'/css/dashboard.css');
           // $cs->registerCssFile($baseUrl.'/js/simple_chart/main.css');
           //$cs->registerCssFile($baseUrl.'/css/AdminLTE.min.css');
          // AdminLTE.min.css
	  //$cs->registerCssFile($baseUrl.'/css/style-blue.css');
	  ?>

	
	
<?php  
  $baseUrl = Yii::app()->baseUrl; 
  $cs = Yii::app()->getClientScript();
  $cs->registerScriptFile($baseUrl.'css/js/html5.js');
?> 


<?php
	  $cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js');
	 $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.sparkline.js');
	  $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.flot.min.js');
	  $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.flot.pie.min.js');
	  $cs->registerScriptFile($baseUrl.'/js/charts.js');
	  $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.knob.js');
	  $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.masonry.min.js');
	  $cs->registerScriptFile($baseUrl.'/js/styleswitcher.js');
          $cs->registerScriptFile($baseUrl.'/js/ckeditor/ckeditor.js');
          $cs->registerScriptFile($baseUrl.'/js/jscolor/jscolor.js');
          $cs->registerScriptFile($baseUrl.'/js/simple_chart/jchart.js');
          $cs->registerScriptFile($baseUrl.'/js/chartjs/Chart.js');
          $cs->registerScriptFile($baseUrl.'/js/amchart/amcharts.js');
          $cs->registerScriptFile($baseUrl.'/js/amchart/pie.js');
          $cs->registerScriptFile($baseUrl.'/js/highcharts.js');
          $cs->registerScriptFile($baseUrl.'/js/drilldown.js');
         // $cs->registerScriptFile($baseUrl.'/js/data.js');
         // 
           //moris chart 
           $cs->registerScriptFile($baseUrl.'/js/morris-0.5.1.min.js');
           $cs->registerScriptFile($baseUrl.'/js/raphael-min.js');
           $cs->registerScriptFile($baseUrl.'/filetree/jquery.easing.js');
           $cs->registerScriptFile($baseUrl.'/filetree/jqueryFileTree.js');
           
           //$cs->registerScriptFile($baseUrl.'/filetree/jquery.js');
                      
            
              
           
      
      
	?>

   
    
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/slide_side.css" />


	

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	


</head>

 <?php echo Yii::app()->bootstrap->init();
  
        
           	   
           	     
 ?>
	
	
<body>
    

			<section id="navigation-main">   
			<!-- Require the navigation -->
			<?php require_once('tpl_navigation.php')?>
			</section>
			
			<!-- /#navigation-main -->
			    
			<section class="main-body">
                            
			    <div class="container-fluid">
			            <!-- Include content pages -->
                                    <?php $this->renderPartial('//site/dialog'); ?>
			            <?php echo $content; ?>
			    </div>
			    
			</section>
			
			<!-- Require the footer -->
			<?php require_once('tpl_footer.php')?>

</body>
</html>	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	