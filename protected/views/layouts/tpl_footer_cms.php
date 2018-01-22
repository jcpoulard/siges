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




$acad=Yii::app()->session['currentId_academic_year'];  
        $acad_name=Yii::app()->session['currentName_academic_year'];
	
	$school_name = infoGeneralConfig('school_name');
	//echo $school_name;
        // School address
    $school_address = infoGeneralConfig('school_address');
        //School Phone number 
    $school_phone_number = infoGeneralConfig('school_phone_number');
        
    $school_facebook = infoGeneralConfig('facebook_page');
        
    $school_twitter = infoGeneralConfig('twitter_page');
      
    $school_youtube = infoGeneralConfig('youtube_page');

    $school_acronym = infoGeneralConfig('school_acronym');
        
    $devise_school = infoGeneralConfig('devise_school');



?>
	
	
	
		
	<footer>

			<div class="container footerWrap">
			  <div class="row">
										
			
			   <div class="col-xs-12 col-sm-3">
					<h4>Contact</h4>
							<ul class="list-unstyled">
									<li>
                                                                            <?php 
                                                                            if($school_address!=""){
                                                                                echo $school_address;
                                                                            }else{
                                                                                echo '';
                                                                            }
                                                                            ?>
									
									</li>
                                                                        
                                                                        <li>
                                                                            <?php 
                                                                            if($school_phone_number!=""){
                                                                                echo $school_phone_number;
                                                                            }else{
                                                                                echo '';
                                                                            }
                                                                            ?>
									
									</li>
							</ul>
				</div>
			
			<div class="col-xs-12 col-sm-3">
				   <h4>Liens utiles</h4>
						<ul class="list-unstyled">
                                                 
                                   <li>
                                       <a href="<?php echo Yii::app()->baseUrl ?>/index.php/portal/default/admission">Formulaire d'admission</a>
									</li>
                                                                
                                                                                                                                
                                                                
                                        <li>
                                          <a href="<?php echo Yii::app()->baseUrl ?>/index.php/portal/default/contact">Nous contacter</a>
										</li>
																
							<li>
                              <a href="<?php echo Yii::app()->baseUrl ?>/index.php/portal/default/download">Documents &agrave; t&eacute;l&eacute;charger</a>
							</li>

						</ul>
				</div>
			
			
			   <div class="col-xs-12 col-sm-3">
					<h4>Suivez-nous</h4>
							<ul class="list-unstyled">
									<li>
									<a target="_blank" href="https://facebook.com/<?php echo $school_facebook; ?>"> <span class="fa fa-facebook"> &nbsp; Facebook  </span></a>
									</li>
									<li>
									<a target="_blank" href="https://twitter.com/<?php echo $school_twitter; ?>"><span class="fa fa-twitter"> &nbsp; Twitter </span> </a>
									</li>
									<li>
									<a target="_blank" href="<?php echo $school_youtube; ?>"><span class="fa fa-youtube"> &nbsp; YouTube </span> </a>
									</li>
							</ul>
				</div>

			<div class="col-xs-12 col-sm-3">
                                   <h4>
                                       <?php if($school_acronym != ""){
                                           echo $school_acronym; 
                                           
                                       }else{
                                           echo '';
                                       } 
                                   
                                   
                                   ?>
                                   </h4>  
						<ul class="list-unstyled">
								<li>
								<a href="<?php  echo Yii::app()->baseUrl; ?>">   
									            <div id="im_foot">
									<img src="<?php  echo Yii::app()->baseUrl.'/css/images/school_logo.png'; ?> " alt="">      
								                        </div>
														
												    </a>
												    
								</li>
								<?php
                               if($devise_school!=''){
                                    echo $devise_school;
                               }
                               
                               ?>
								<li>
						
						
						</ul>
				</div>

								
			</div>
                            <!-- Ligne pour afficher devise  -->
          </div>
		</div>
			
			
			
			
			
			
			<div class="subFooter">
				<div class="pull-center">
				
				<?php 
			     
					echo Yii::t('app','SIGES Fourni par ').'<a href="http://www.logipam.com" target="_new">LOGIPAM</a>. &copy; '.Yii::t('app','All rights reserved.');  
			    ?>
				
				
				</div>
			</div>
</footer>
	
		
	
	
		
	