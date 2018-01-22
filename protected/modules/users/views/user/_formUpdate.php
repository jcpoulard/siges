<?php

/*
 * © 2015 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
 * 
 * This file is part of SIGES.

    SIGES is a free software: you can redistribute it and/or modify
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


/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */


$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

?>
<div class="from">

	<?php
	echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p>';

	  echo $form->errorSummary($user); ?>     
<?php

   
//error message
	   	        
	        

                				       
           
           if(($this->message_default_user_u)||($this->warning_message_for_master)||($this->success))		
			      { echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-16px; ';//-20px; ';
				      echo '">';
				      	
				      	echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';			      
			       }			      
				 
				  if($this->message_default_user_u)
				     { echo '<span style="color:red;" >'.Yii::t('app','- _developer_ - cannot be either updated nor deleted.').'</span>';
				       $this->message_default_user_u=false;
				       echo'</td>
					    </tr>
						</table>';
					
			           echo '</div>
			           <div style="clear:both;"></div>';
				     }
				     			     	
				  if($this->warning_message_for_master)
				     { 
				     	echo '<span style="color:red;" >'.Yii::t('app','Please do not update this group, until you really sure of what you do!').'</span><br/>';
				        echo'</td>
					    </tr>
						</table>';
					
			           echo '</div>
			           <div style="clear:both;"></div>';
			           $this->warning_message_for_developer=false;
				     }
				     
				  if($this->success)
				     { 
				     	echo '<span style="color:green;" >'.Yii::t('app','Operation terminated successfully.').'</span>'.'<br/>';
				     	
				        echo'</td>
					    </tr>
						</table>';
					
			           echo '</div>
			           <div style="clear:both;"></div>';
			           $this->warning_message_for_master=false;
				     }
			
				
	     
?>
   
      
   <div  id="resp_form_siges">

        <form  id="resp_form">
        
        <div class="col-2">
            <label id="resp_form">
                          
					<?php echo $form->labelEx($user,'username'); ?>
                         
                              <?php echo $form->textField($user,'username',array('size'=>60,'maxlength'=>20,'placeholder'=>Yii::t('app','Username'))); ?>
                              <?php echo $form->error($user,'username'); ?>
            </label>
        </div>

           
 <div class="col-2">
            <label id="resp_form">    
                   
                   <span style="color:red;">            <?php echo $form->labelEx($user,'group_id'); ?>      </span>
                        
                              <?php 
                               
                              if(isset($this->group_id))
							      echo $form->dropDownList($user,'group_id',$this->loadGroups(), array('onchange'=> 'submit()','options' => array($this->group_id=>array('selected'=>true)))); 
					 else
                       echo $form->dropDownList($user, 'group_id',$this->loadGroups(),array('onchange'=> 'submit()','prompt'=>Yii::t('app','-- Please select group --')));

 ?>
                              <?php echo $form->error($user,'group_id'); ?>
            </label>
        </div>
                         

                        
        <div class="col-2">
            <label id="resp_form">
                  
                         <?php echo $form->labelEx($user,'password'); ?>
                          
                              <?php echo $form->passwordField($user,'new_password',array('size'=>60,'maxlength'=>128,'placeholder'=>Yii::t('app','Password'))); ?>
                              <?php echo $form->error($user,'new_password'); ?>
            </label>
        </div>
            
        <div class="col-2">
            <label id="resp_form">    
                          
                   <span style="">       <?php echo $form->labelEx($user,'password_repeat'); ?>     </span>
                          
                              <?php echo $form->passwordField($user, 'password_repeat',array('size'=>60,'maxlength'=>128,'placeholder'=>Yii::t('app','Repeat Password'))); ?>
                              <?php echo $form->error($user,'password_repeat'); ?>
            </label>
        </div>
                          
        
                   
        <div class="col-2">
            <label id="resp_form">    
                          
                          <?php echo $form->labelEx($user,'profil'); ?>
                          
                              <?php echo $form->dropDownList($user,'profil', $this->searchProfilByGroupID($this->group_id)); ?>
                              <?php echo $form->error($user,'profil'); ?>
                          
                          
            </label>
        </div>
            
 

              
                <div class="col-submit">
                                
                                <?php 
                                           if(!isAchiveMode($acad_sess))
                                               echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
                                            
                                              echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                                              
                                         
                                           //back button   
                                              $url=Yii::app()->request->urlReferrer;
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo '<a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';

                                ?>
                                
                </div>
        </form>
   </div>
<!-- END OF TEST -->     
        

</div>	
