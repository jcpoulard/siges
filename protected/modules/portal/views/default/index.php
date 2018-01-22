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
      
      $path=null;
      
?>

<?php $this->beginWidget(
    'bootstrap.widgets.TbModal',
    array('id' => 'myModal')
); ?>
 
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4 id="myModalHeader">Modal header</h4>
    </div>
 
    <div class="modal-body" id="myModalBody">
        <p>One fine body...</p>
    </div>
 
    <div class="modal-footer">
        <?php $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'label' => Yii::t('app','Close'),
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            )
        ); ?>
    </div>
 
<?php $this->endWidget(); ?>

    <?php
    
    $annonces_ = Announcements::model()->findAllBySql("SELECT * FROM announcements ORDER BY create_time DESC LIMIT 3");
    $carrousel_ = CmsArticle::model()->findAllBySql("SELECT * from cms_article WHERE set_position = 'carrousel' ORDER BY id DESC LIMIT 3");
    $box1_ = CmsArticle::model()->findAllBySql("SELECT * from cms_article WHERE set_position = 'box1' AND is_publish = 1 ORDER BY id DESC LIMIT 1");
    $box2_ = CmsArticle::model()->findAllBySql("SELECT * from cms_article WHERE set_position = 'box2' AND is_publish = 1 ORDER BY id DESC LIMIT 1");
    
    
    if(infoGeneralConfig('number_article_per_page')!=null){
        $messagesParPage = infoGeneralConfig('number_article_per_page');
    }else{
        $messagesParPage = 5;
    }

if(infoGeneralConfig('number_article_archive')!=null){
    $archive_value = infoGeneralConfig('number_article_archive');
    }else{
        $archive_value = 50;
    }
    
    $total = 0;
    $menu = 0;
    
    
    $main_1 = CmsArticle::model()->findAllBySql("SELECT ca.id, ca.article_title, ca.article_description, ca.article_menu, ca.date_create, ca.is_publish FROM cms_article ca INNER JOIN cms_menu cm ON (ca.article_menu = cm.id) WHERE (ca.set_position = 'main' AND ca.is_publish = 1)  AND cm.is_home = 1 ORDER BY ca.id DESC");
    
    // On fait le total d'article affiche dans cette categorie
    foreach($main_1 as $m){
        $total++;
        $menu = $m->article_menu;
        
    }
    //Compare avec la valeur avant archivage 
    if($total > $archive_value ){    
        $nombreDePages=ceil($archive_value/$messagesParPage);
    }else{
        $nombreDePages=ceil($total/$messagesParPage);
    }
 
     if(isset($_GET['page'])) // Si la variable $_GET['page'] existe...
    {
         $pageActuelle=intval($_GET['page']);

         if($pageActuelle>$nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
         {
              $pageActuelle=$nombreDePages;
         }
    }
    else // Sinon
    {
         $pageActuelle=1; // La page actuelle est la n°1    
    }
 
    $premiereEntree=($pageActuelle-1)*$messagesParPage; // On calcul la première entrée à lire
    
    $main_ = CmsArticle::model()->findAllBySql("SELECT ca.id, ca.article_title, ca.article_description, ca.article_menu, ca.date_create, ca.is_publish FROM cms_article ca INNER JOIN cms_menu cm ON (ca.article_menu = cm.id) WHERE (ca.set_position = 'main' AND ca.is_publish = 1)  AND cm.is_home = 1 ORDER BY ca.rank_article ASC,  ca.id DESC LIMIT $premiereEntree, $messagesParPage");
    
    
    ?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
   
       <title>SIGES</title>
  


  </head>
<!-- NAVBAR
================================================== -->
<body>
    <!-- NAVBAR
    ================================================== -->
   


    


    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

         <div class="row featurette" id="slid_head" style=" margin: 10px 0; ">
           
		       <div class="col-md-7">
		       
		       
		       
		       
		        <?php 
	                                                    // Gestion du carrousel 
	                                                     $i=0;
	                                                     //$j=0;
	                                                     $carou_title = array();
	                                                    foreach($carrousel_ as $c) {
	                                                       $carou_title[$i] = $c->article_title; 
	                                                        
	                                                        $i++; 
	                                                        
	                                                    }
	                                                    
	                                                    
	                                                    ?> 
	                                      
	                                      
	                                     
	                                                        <?php
	                                                  
	                                                  
	                                                
	                                                        
	                                                   
	                                                        ?>
	                                                        
	                                                        
		            	
		            	<div class='csslider1 autoplay '>
        
							<input name="cs_anchor1" id='cs_slide1_0' type="radio" class='cs_anchor slide' >
					    
							<input name="cs_anchor1" id='cs_slide1_1' type="radio" class='cs_anchor slide' >
					    
							<input name="cs_anchor1" id='cs_slide1_2' type="radio" class='cs_anchor slide' >
					    
							<input name="cs_anchor1" id='cs_play1' type="radio" class='cs_anchor' checked>
					    
							<input name="cs_anchor1" id='cs_pause1' type="radio" class='cs_anchor' >
		
		
				<ul>
		      		<div style="width: 100%; visibility: hidden; font-size: 0px; line-height: 0;">
		                	<img src="<?php echo Yii::app()->baseUrl ?>/cms_files/images/banners/image1.jpg"  style="width: 100%;">
		            </div>
		 
		      
					<li class='num0 img'>
						 <a><img src="<?php echo Yii::app()->baseUrl ?>/cms_files/images/banners/image1.jpg" alt=""> </a> 
					</li>
					<li class='num1 img'>
						 <a><img src="<?php echo Yii::app()->baseUrl ?>/cms_files/images/banners/image2.jpg" alt=""> </a>
					</li>
					<li class='num2 img'>
						 <a><img src="<?php echo Yii::app()->baseUrl ?>/cms_files/images/banners/image3.jpg" alt=""> </a> 
					</li>
				
				</ul>
		
	
		
		<div class='cs_arrowprev'>
			<label class='num0' for='cs_slide1_0'></label>
			<label class='num1' for='cs_slide1_1'></label>
			<label class='num2' for='cs_slide1_2'></label>
		</div>
		<div class='cs_arrownext'>
			<label class='num0' for='cs_slide1_0'></label>
			<label class='num1' for='cs_slide1_1'></label>
			<label class='num2' for='cs_slide1_2'></label>
		</div>
		
		<div class='cs_bullets'>
			<label class='num0' for='cs_slide1_0'>
				<span class='cs_point'></span>
				<span class='cs_thumb'><img  style="width:100px; height: auto;" src="<?php echo Yii::app()->baseUrl ?>/cms_files/images/banners/image1.jpg" alt=""></span>
			</label>
			<label class='num1' for='cs_slide1_1'>
				<span class='cs_point'></span>
				<span class='cs_thumb'><img style="width:100px; height: auto;"  src="<?php echo Yii::app()->baseUrl ?>/cms_files/images/banners/image2.jpg" alt=""></span>
			</label>
			<label class='num2' for='cs_slide1_2'>
				<span class='cs_point'></span>
				<span class='cs_thumb'><img style="width:100px; height: auto;"  src="<?php echo Yii::app()->baseUrl ?>/cms_files/images/banners/image3.jpg" alt=""></span>
			</label>
		</div>
		</div>
            
            
            
                
		            		
	  			</div>
		            
             <div class="col-md-5">
            
            
               <div  id="box1" class="box_lat" style="margin-top: -20px;" >
				
	                    <?php 
	                    $i = 0;
	                    foreach($box1_ as $b) {
	                       $box_title1 = $b->article_title; 
	                       $box_text1 = $b->article_description;
	                       
	                       $i++;
	                    }
	                    ?>
	                    
			          <h2 class="featurette-heading"> <?php if($i!=0) echo $box_title1; else echo 'Heading 1'; ?></h2>
			          <p><?php if($i!=0) echo $box_text1; else echo 'Text 1 '; ?>  </p>    
	
		         </div>
		         
		<hr/>
		<div id="box2" class="box_lat"  style="margin-top: -45px;" >
		<?php 
                    $i = 0;
                    foreach($box2_ as $b2) {
                       $box_title2 = $b2->article_title; 
                       $box_text2 = $b2->article_description;
                       
                       $i++;
                    }
                    ?>
		   
		          <h2 class="featurette-heading"><?php if($i!=0) echo $box_title2; else echo ''; ?></h2>
		          <p>
                              <?php if($i!=0) echo $box_text2; else echo ''; ?>
                          </p>
		
		</div>	 
                
                
                
                
                
            </div>
        </div>

        

        <div class="row featurette">
        
             <?php foreach($main_ as $m) { ?>
		      
		        <div class="col-md-12">
		        
				          <h2 class="featurette-heading"><?php echo $m->article_title; ?></h2>
		
		     				
				         	<!--  <p class="lead"> -->
				             
				              <div class="comment more">
					              <?php echo $m->article_description; ?>
					            <!-- </p>  -->
		 					  </div>
				            
				            
						       <div style="text-align: right;  margin-top: 10px;  margin-bottom: 2px">
						         <h9><?php echo Yii::t('app','Publish at: ').$m->datePublish; ?></h9>
						       </div>
                                          <hr class="featurette-divider">
				         				</div>
				             <?php }?>
	<?php if($nombreDePages>1) { ?>
            
            <nav>  
            <ul class="paj">
                <li>
                    <a href="<?php
                      if($pageActuelle>1){
                          $previous = $pageActuelle-1;
                          echo Yii::app()->baseUrl."/index.php/portal/default/index?page=$previous";
                          }else{
                              $previous = $pageActuelle;
                              echo Yii::app()->baseUrl."/index.php/portal/default/index?page=$previous";
                          }   

                      ?>" aria-label="Previous">
                     <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                
                <?php
                        //Pour l'affichage, on centre la liste des pages
                    for($i=1; $i<=$nombreDePages; $i++) //On fait notre boucle
                    {
                         //On va faire notre condition
                         if($i==$pageActuelle) //Si il s'agit de la page actuelle...
                         {
                             echo '<li class="active"><a> '.$i.' </a></li>'; 
                         }	
                         else //Sinon...
                         {
                              echo '<li><a href="'.Yii::app()->baseUrl.'/index.php/portal/default/index?page='.$i.'"> '.$i.' </a></li> ';
                         }
                    }


                    ?> 
                <li>
                  <a href="<?php
                        if($pageActuelle == $nombreDePages){
                            $next = $pageActuelle; 
                            echo Yii::app()->baseUrl."/index.php/portal/default/index?page=$next";
                        }else{
                            $next = $pageActuelle+1; 
                            echo Yii::app()->baseUrl."/index.php/portal/default/index?page=$next";
                        }
                  ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                  </a>
                </li>
    
    <?php
    if($total > $archive_value){
        echo '<li><a href="'.Yii::app()->baseUrl.'/index.php/portal/default/archives?menu='.$menu.'&archi='.$archive_value.'&tot='.$total.'" >Archives</a></li>';
    }
    
?>
        </ul>
        
        <?php } ?>    
				             
				             

			<p class="pull-right" ><a href="#"> Retour <i class="fa fa-chevron-up"> </i> </a></p>
	   	

		  </div>
		       
   
        <!-- /END THE FEATURETTES -->
        <!-- FOOTER -->
    <!-- /.container -->

       
</body>
</html>