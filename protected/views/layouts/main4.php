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
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
   
   
   
    <head>
        <?php 
      $baseUrl = Yii::app()->baseUrl; 
       $cs = Yii::app()->getClientScript(); 
       $theme_portal = infoGeneralConfig('theme_portail_siges'); 
       if($theme_portal!=null){
           switch ($theme_portal){
               case 'siges':
                   $cs->registerCssFile($baseUrl.'/css/css_cms/style_cms_siges.css');
                   break;
               case 'zaboka':
                   $cs->registerCssFile($baseUrl.'/css/css_cms/style_cms_zaboka.css');
                   break;
               case 'zoranj':
                   $cs->registerCssFile($baseUrl.'/css/css_cms/style_cms_zoranj.css');
                   break;
               case 'seriz':
                   $cs->registerCssFile($baseUrl.'/css/css_cms/style_cms_seriz.css');
                   break;
               case 'tamaren':
                   $cs->registerCssFile($baseUrl.'/css/css_cms/style_cms_tamaren.css');
                   break;
               default:
                   $cs->registerCssFile($baseUrl.'/css/css_cms/style_cms_siges.css');
           }
       }else{
            $cs->registerCssFile($baseUrl.'/css/css_cms/style_cms_siges.css');
       }
	  ?>

	
 
<?php  
  $baseUrl = Yii::app()->baseUrl; 
  $cs = Yii::app()->getClientScript();
  $cs->registerScriptFile($baseUrl.'css/css_cms/js/bootstrap.min.js');
  $cs->registerScriptFile($baseUrl.'css/css_cms/js/jquery-1.9.1.min.js');
?> 


 <!-- Custom jquery for this template -->
<?php
	   

	   $cs->registerScriptFile($baseUrl.'/css/css_cms/js/bootstrap.js');
	   $cs->registerScriptFile($baseUrl.'/css/css_cms/js/bootstrap.min.js');
	   $cs->registerScriptFile($baseUrl.'/css/css_cms/js/npm.js');
         
	?>
	
	
	
	<?php 
      $baseUrl = Yii::app()->baseUrl; 
       $cs = Yii::app()->getClientScript(); 
	   $cs->registerCssFile($baseUrl.'/css/css_cms/css/bootstrap.min.css');
	   $cs->registerCssFile($baseUrl.'/css/css_cms/css/bootstrap.css');
	 	   $cs->registerCssFile($baseUrl.'/css/font-awesome.min.css');
       $cs->registerCssFile($baseUrl.'/css/ionicons.min.css');
	   
	   
          
	  ?>

	  
	 
	  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/abound.css" />
       <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" />


	  
	  
	  
	  
	  
	  
	  <!-- new Css3 -->
	
	
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/normalize.css" />
	
	<?php
	  $baseUrl = Yii::app()->baseUrl; 
	  $cs = Yii::app()->getClientScript();
	  Yii::app()->clientScript->registerCoreScript('jquery');
	?>
	
	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	
<?php 
      $baseUrl = Yii::app()->baseUrl; 
       $cs = Yii::app()->getClientScript(); 
	   $cs->registerCssFile($baseUrl.'/css/bootstrap.min.css');
	   $cs->registerCssFile($baseUrl.'/css/bootstrap-responsive.min.css');
	       $cs->registerCssFile($baseUrl.'/css/font-awesome.min.css');
           $cs->registerCssFile($baseUrl.'/css/ionicons.min.css');
   
           $cs->registerCssFile($baseUrl.'/css/formstyle.css');
         
	  ?>

 
    </head>
    <body>
    
	 <?php require_once('tpl_navigation_cms.php')?>
		    
          <div class="container marketing"> <div class="site_min">  
                        <?php $this->renderPartial('//site/dialog'); ?>
		        <?php echo $content; ?>
		        
           </div>
           </div>
    
    
      <!-- Require the footer -->
			<?php require_once('tpl_footer_cms.php')?>

 </body>   
</html>



