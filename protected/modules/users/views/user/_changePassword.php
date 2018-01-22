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

$acad=Yii::app()->session['currentId_academic_year']; 

?>

<div class="form">

	<?php
	echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p>';

	  echo $form->errorSummary($user); ?>
        
<?php

   
//error message
	   	        
	        

                				       
           
           if(($this->success))		
			      { echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-16px; ';//-20px; ';
				      echo '">';
				      	
				      	echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';			      
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
   
    
   <div class="b_mail">
	<div  id="resp_form_siges">

        <form  id="resp_form">
        
        <div class="col-2">
            <label id="resp_form">
                          <?php echo $form->labelEx($user,'password'); ?>
                          
                              <?php echo $form->passwordField($user,'password',array('size'=>60,'maxlength'=>64,'placeholder'=>Yii::t('app','Password'))); ?>
                              <?php echo $form->error($user,'password'); ?>
            </label>
        </div>
            
        <div class="col-2">
            <label id="resp_form">
                
            </label> 
        </div>
            
            <div class="col-2">
            <label id="resp_form">
                        
                        <?php echo $form->labelEx($user,'new_password'); ?>
                          
                              <?php echo $form->passwordField($user,'new_password',array('size'=>60,'maxlength'=>64,'placeholder'=>Yii::t('app','Password'))); ?>
                              <?php echo $form->error($user,'new_password'); ?>
            </label>
            </div>
            
            <div class="col-2">
            <label id="resp_form">
                          <?php echo $form->labelEx($user,'password_repeat'); ?>
                          
                              <?php echo $form->passwordField($user,'password_repeat',array('size'=>60,'maxlength'=>64,'placeholder'=>Yii::t('app','Password Repeat'))); ?>
                              <?php echo $form->error($user,'password_repeat'); ?>
            </label>
            </div>

                          
                       <div class="col-submit">
                                
                                <?php 
                                           	 //if(!isAchiveMode($acad))
                                           	     echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
                                            
                                              echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                                              
                                          
                                           //back button   
                                              $url=Yii::app()->request->urlReferrer;
                                              $explode_url= explode("php",substr($url,0));
				             
                                          

                                ?>
                       </div>
        </form>
            </div>
   </div>    

</div>	