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
	
	$acad=Yii::app()->session['currentId_academic_year'];  
        $acad_name=Yii::app()->session['currentName_academic_year'];
	
	$school_name = GeneralConfig::model()->find('school_name');
	//echo $school_name;
        // School address
    $school_address = GeneralConfig::model()->find('school_address');
        //School Phone number 
    $school_phone_number = GeneralConfig::model()->find('school_phone_number');
      

  $school_acronym = GeneralConfig::model()->find('school_acronym');
      
      $path=null;
      
?>



    <?php
    
    $annonces_ = Announcements::model()->findAllBySql("SELECT * FROM announcements ORDER BY create_time DESC LIMIT 3");
    $carrousel_ = CmsArticle::model()->findAllBySql("SELECT * from cms_article WHERE set_position = 'carrousel' ORDER BY id DESC LIMIT 5");
    $box1_ = CmsArticle::model()->findAllBySql("SELECT * from cms_article WHERE set_position = 'box1' AND is_publish = 1 ORDER BY id ASC LIMIT 1");
    $box2_ = CmsArticle::model()->findAllBySql("SELECT * from cms_article WHERE set_position = 'box2' AND is_publish = 1 ORDER BY id ASC LIMIT 1");
    $main_ = CmsArticle::model()->findAllBySql("SELECT * from cms_article WHERE set_position = 'main' AND is_publish = 1 ORDER BY id DESC LIMIT 10");
    ?>



<!DOCTYPE html>
<html lang="en">
  
 <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
   
       <title>SIGES</title>
  

		<?php 
      $baseUrl = Yii::app()->baseUrl; 
       $cs = Yii::app()->getClientScript(); 
	   $cs->registerCssFile($baseUrl.'/css/css_cms/carousel.css');
	   $cs->registerCssFile($baseUrl.'/css/css_cms/bootstrap.min.css');
       $cs->registerCssFile($baseUrl.'/css/css_cms/style.css');
	  ?>

	
 <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->	
<?php  
  $baseUrl = Yii::app()->baseUrl; 
  $cs = Yii::app()->getClientScript();
  $cs->registerScriptFile($baseUrl.'/css/css_cms/js/bootstrap.min.js');
  $cs->registerScriptFile($baseUrl.'/css/css_cms/js/jquery-1.9.1.min.js');
?> 


 <!-- Custom jquery for this template -->
<?php
	 $cs->registerScriptFile($baseUrl.'/js/read_more.js');  
	$cs->registerScriptFile($baseUrl.'/js_cms/bootstrap.js');
	  $cs->registerScriptFile($baseUrl.'/js_cms/jquery.js');
	  $cs->registerScriptFile($baseUrl.'/js_cms/npm.js');
         
	?>
	
	
	
	<?php 
      $baseUrl = Yii::app()->baseUrl; 
       $cs = Yii::app()->getClientScript(); 
	   $cs->registerCssFile($baseUrl.'/css/css_cms/css/bootstrap.min.css');
	   $cs->registerCssFile($baseUrl.'/css/css_cms/css/style_cms.css');
	   $cs->registerCssFile($baseUrl.'/css/css_cms/css/bootstrap.css');
	   $cs->registerCssFile($baseUrl.'/css/css_cms/css/bootstrap.css.map');
	   $cs->registerCssFile($baseUrl.'/css/css_cms/css/bootstrap.min.css');
	   $cs->registerCssFile($baseUrl.'/css/css_cms/css/bootstrap.min.css.map');
	   $cs->registerCssFile($baseUrl.'/css/css_cms/css/bootstrap-theme.min.css.map');
	   $cs->registerCssFile($baseUrl.'/css/css_cms/css/bootstrap-theme.min.css');
	   $cs->registerCssFile($baseUrl.'/css/css_cms/css/bootstrap-theme.css.map');
	   $cs->registerCssFile($baseUrl.'/css/css_cms/css/bootstrap-theme.css');
	   
	   
	   
	   $cs->registerCssFile($baseUrl.'/css/css_cms/js/bootstrap.js');
	   $cs->registerCssFile($baseUrl.'/css/css_cms/js/bootstrap.min.js');
	   $cs->registerCssFile($baseUrl.'/css/css_cms/js/npm.js');
	   	  
	  
          
	  ?>



  </head>



		<ul class="topnav">
		
		<a class="navbar-brand" href="<?php echo Yii::app()->baseUrl ?>/index.php/portal"><?php echo $school_name.' '.  $school_acronym; ?></a>

		
		<div class= "top_m">
		
		
		
		
		 </a>
		  
		  
		  
		  		  
		  
		   <li><a href="<?php echo Yii::app()->baseUrl ?>/index.php/portal">Accueil</a></li>
                   <li><a href="<?php echo Yii::app()->baseUrl ?>/index.php/portal/default/about">Qui sommes-nous?</a></li> 
					<li>
					<li><a href="<?php echo Yii::app()->baseUrl ?>/index.php/portal/default/preadmission">Demande d'admission</a></li> 
					<li>
																	  
				   <li><a href="<?php echo Yii::app()->baseUrl ?>/index.php/portal/default/contact">Contact</a></li> 
					<li>
		                                                                                     <?php if(Yii::app()->user->isGuest) { ?>    
											          <a href="<?php echo Yii::app()->baseUrl;?>?log=wi" target="">  
														<?php echo Yii::t('app','Login'); ?> </a>
		                                                                                     <?php }else{ ?>
		                                                                                         <a href="<?php echo Yii::app()->baseUrl ?>"><?php echo Yii::app()->user->partname; ?></a>
		                                                                                    
					</li> 
					<li>
						<a href="<?php echo Yii::app()->baseUrl.'/index.php/site/logout'; ?>"><span class="glyphicon glyphicon-log-out"></span></a>

					</li>
													 <?php } ?>
												
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		  <li class="icon">
		    <a href="javascript:void(0);" style="font-size:25px;" onclick="myFunction()">☰</a>
		  </li>
		
		
		
		</div>
		
		
		
		
		
		
		
		
		</ul>





<script>
function myFunction() {
    document.getElementsByClassName("topnav")[0].classList.toggle("responsive");
}
</script>





        
