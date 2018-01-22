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
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name .Yii::t('app',' - Login');
/*$this->breadcrumbs=array(
	'Login',
); */
?>


<body class="login">


<div class="login_message" > <?php if($this->message)
                                                             echo Yii::t('app','Please see your the administrator to set new academic year.');
                                                                                                ?> </div>

	
				<div class="loginbox radius">
				   </br>
				    
					  <div class="loginboxinner radius">
					  
						    	<div class="loginheader">
						    
						        	<div class="logo_log">
						        	    
					                  <a href="<?php 
                                            echo Yii::app()->baseUrl.'/index.php/portal';
                                         ?>"> <div id="logo">
                                         </div> </a>
					 
								</div>
						    	
						    	</div><!--loginheader-->
						        
							        <div class="loginform">
                                                                            <?php $form=$this->beginWidget('CActiveForm', array(
                                                                                    'id'=>'login-form',
                                                                                    'enableClientValidation'=>true,
                                                                                    'clientOptions'=>array(
                                                                                            'validateOnSubmit'=>true,
                                                                                    ),
                                                                                )); 
                                                                            ?>
							        	
								        	
								            	
                                                        <div>
									                	<label for="username" class="bebas"> <?php echo Yii::t('app','Username'); ?></label>
                                                          <?php echo $form->textField($model,'username',array('class'=>'radius2','id'=>'username')); ?>
                                                                                                <span class="alert-error"> <?php echo $form->error($model,'username'); ?></span>
									                   <!-- <input type="text" id="username" name="username" value="" class="radius2" /> -->
                                                                                        </div>
                                                                                        <div>
                                                                                     </br>   
                                                                                        
									                	<label for="password" class="bebas"><?php echo Yii::t('app','Password'); ?></label>
                                                        <?php echo $form->passwordField($model,'password',array('class'=>'radius2','id'=>'password')); ?>
                                                                                                <span class="alert-error">  <?php echo $form->error($model,'password'); ?></span>
									                   <!-- <input type="password" id="password" name="password"  class="radius2" /> -->
                                                                                        </div>
                                                                    
                                                                                         </br> 
                                                                                       
                                                                                       
                                                           <div class="radius_title">
                                                            
                                                             <?php if($this->message)
                                                             echo CHtml::submitButton(Yii::t('app','Logout'),array('url'=>'/site/logout'));
                                                             else
                                                              echo CHtml::submitButton(Yii::t('app','Login'),array('name'=>'login','class'=>''));
                                                                                                ?>
                                                             <!--  <button type="submit" class="radius title" name="login">Se connecter</button> --> 
                                                             <div>
                                                                                             
                                                                                         </div>    
                                                           </div>
								            
								            
                                                                                             
                                                                    <?php $this->endWidget(); ?>
						            
						              </div><!--loginform-->
						        
				       </div><!--loginboxinner-->
				   <h2 class="version">
				   Version Kolibri </h2> 
				</div><!--loginbox-->
	
	</body>
