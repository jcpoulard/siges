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
	
	$school_name = infoGeneralConfig('school_name');
	//echo $school_name;
        // School address
    $school_address = infoGeneralConfig('school_address');
        //School Phone number 
    $school_phone_number = infoGeneralConfig('school_phone_number');
      
    $school_acronym = infoGeneralConfig('school_acronym');
     
    $devise_school = infoGeneralConfig('devise_school');
	
	
     
      
      $path=null;
      
      
      // Pour activer les liens lorsqu'on est dans une categorie
      if(isset($_GET['menu'])){
        $menu = $_GET['menu'];
        $menu_label;
      $menu_ = CmsMenu::model()->findAllBySql("SELECT * FROM cms_menu WHERE id = $menu");
        foreach($menu_ as $m_){
           $menu_label = $m_->menu_label; 
        }
      }
      
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
 
 </head>



				 
		 
		 <div class= "content_h">
		 
						                		
		
		
			<div class="row">
				
				<div class="col-xs-12 col-sm-2">
				
				<div id="im_top"> <a href="<?php echo Yii::app()->baseUrl ?>/index.php/portal">
				<img src="<?php  echo Yii::app()->baseUrl.'/css/images/school_logo.png'; ?> " alt="logo">   </a> 
			    </div>
			    
			    </div>
	
				<div class="col-xs-12 col-sm-8" id="l_center">	
				    <p>			                        
					<h2> <?php echo $school_name.' '.  $school_acronym; ?> <h2>  
					 <!-- Ligne pour afficher devise  -->
					<h4> <?php if(infoGeneralConfig('slogan')!=null){ echo infoGeneralConfig('slogan') ; } ?> </h4>
					</p>					                  
				</div>
	
	           <div class="col-xs-12 col-sm-8" id="l_right">  </div>
		  								    
	
	        </div>
		
		</div>
		
		
		
		
		<ul class="topnav nav nav-tabs nav-justified">

		
		
		<div class= "top_m">
		
		
		   <?php if($this->portal_position == "index"){ ?>
		   <li class="souliye"><a href="<?php echo Yii::app()->baseUrl ?>/index.php/portal">Accueil</a></li>
                <?php } else {?>
                   <li><a href="<?php echo Yii::app()->baseUrl ?>/index.php/portal">Accueil</a></li>
                <?php } ?>
                   
                   <!-- Prendre les menus de la base de donnees --> 
                   <?php
                      $menu_ = CmsMenu::model()->findAllBySql("SELECT * from cms_menu WHERE is_home IS NULL AND is_publish = 1 ORDER BY menu_position LIMIT 10");  
                      foreach($menu_ as $m){
                      	if(isset($menu)){
                          if($menu == $m->id){
                              $class_ = "souliye";
                          }else{
                              $class_="";
                          }
                          }else{
                              $class_="";
                          }
                      	
                          ?>
                   
                   <li class="<?php echo $class_ ?>">
                       <a href="<?php echo Yii::app()->baseUrl."/index.php/portal/default/article?menu=$m->id"; ?>"><?php  echo $m->menu_label?></a>
                   </li>
                   <?php 
                      }
                   ?>
                   <!-- Fin des menus de la base de donnees --> 
                   
                  
																			  
				   <?php if($this->portal_position == "contact")  {?>															  
				   <li class="souliye"><a href="<?php echo Yii::app()->baseUrl ?>/index.php/portal/default/contact">Contact</a></li> 
                                <?php } else { ?>
                                   <li><a href="<?php echo Yii::app()->baseUrl ?>/index.php/portal/default/contact">Contact</a></li> 
                                <?php  } ?>    
					
				
				
				
				
				
<!-- ============================================================================= -->
				
	
			
			
					
				<li id="login">
				
		                <?php if(Yii::app()->user->isGuest) { ?>
                                    <a id="login-trigger" href="#?log=wi"><?php echo Yii::t('app','Login'); ?><span>&nbsp; &#x25BC;</span></a>
						
						
						
						 <div id="login-content">
                   
                    
                  				  <div class="login_message" > <?php $model=new LoginForm;
                   					      if($this->message)
                 				           echo Yii::t('app','Please see your the administrator to set new academic year.');
                                                                                                ?> 
                                  </div></br>
				    
				
                                   <div id="logo"></div> 
					 
                                       <?php $form=$this->beginWidget('CActiveForm', array(
                                               'id'=>'login-form',
                                                'action'=>Yii::app()->baseUrl.'/index.php/site/index/',
                                                  )); 
                                                                           
                                                   echo $this->renderPartial('/default/login',array(
                                                      'model'=>new loginForm,
                                                                                                //'controller'=>'siteController',
                                                                                                'form'=>$form,
                                                                                       ));
                                                                           
                                                                           
                                                                            ?>
							        	
                                                        								            
                                                                                             
                                                                    <?php $this->endWidget(); ?>
						            
						      
						       
						</div><!--loginbox-->                    
		                    
		         								
		                                                                                     <?php }else{ ?>
		                <a href="<?php echo Yii::app()->baseUrl ?>"><?php echo Yii::app()->user->partname; ?></a>
		                                                                                    
					</li> 
					
					
					
					
					
					
					<!-- ============================================================================= -->
				
					
					
					
				
					
					
					
					<li>
						<a href="<?php echo Yii::app()->baseUrl.'/index.php/site/logout'; ?>"<span class="glyphicon glyphicon-log-out"></span></a>

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

$(document).ready(function(){
    $('#login-trigger').click(function() {
        $(this).next('#login-content').slideToggle();
        $(this).toggleClass('active');                    
        
        if ($(this).hasClass('active')) {$(this).find('span').html('&nbsp; &#x25B2;')}
            else {
                $(this).find('span').html('&nbsp; &#x25BC;'); 
               // $(this).next('#login-content').slideToggle();
        }
        })
});


</script>






        
