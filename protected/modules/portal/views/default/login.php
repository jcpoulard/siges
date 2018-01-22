</br></br>

<div>
									                
									                
									                
									                
<?php echo $form->textField($model,'username',array('class'=>'radius2','id'=>'username', 'placeholder'=>Yii::t('app','Username'))); ?>
                                              <span class="alert-error"> <?php echo $form->error($model,'username'); ?></span>
									                   
                                                                                        </div>
                                                                                        
                                                                                        <div>
                                                                                     </br>   
                                                                                        
							<!-- 'class'=>'radius2', -->
                                                      <!--  <input type="password" class="radius" id="password" name="password" placeholder="Password"/> -->
              <?php 
              
                echo $form->passwordField($model,'password',array('class'=>'input','id'=>'password', 'placeholder'=>Yii::t('app','Password')));
              
              ?>
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
								            
