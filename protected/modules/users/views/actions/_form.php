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

$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

?> 
<div class="b_m">

<?php
	echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p>';

	  echo $form->errorSummary($model); ?>

</br>
<div  id="resp_form_siges">

        <form  id="resp_form">
        
        <div class="col-4">
            <label id="resp_form"> 
                    
                  <?php echo $form->labelEx($model,'action_id'); ?>
                   
                              <?php echo $form->textField($model,'action_id',array('size'=>32,'maxlength'=>64)); ?>
                              <?php echo $form->error($model,'action_id'); ?>
                        
            </label>
        </div>
        
        
        <div class="col-4">
            <label id="resp_form"> 
            
                           
                   <?php echo $form->labelEx($model,'action_name'); ?>
                      
                              <?php echo $form->textField($model,'action_name',array('size'=>32,'maxlength'=>64)); ?>
                              <?php echo $form->error($model,'action_name'); ?>
                   
            </label>
        </div>
        
        
        <div class="col-4">
            <label id="resp_form"> 
            
                           
                    <?php echo $form->labelEx($model,'controller'); ?>
                          
                              <?php if(isset($this->controller))
							      echo $form->dropDownList($model,'controller',$this->loadAllControllers(), array('options' => array($this->controller=>array('selected'=>true)))); 
							  else  
								   echo $form->dropDownList($model,'controller',$this->loadAllControllers()); ?>
                              <?php echo $form->error($model,'controller'); ?>
                        
            </label>
        </div>
        
        
        <div class="col-4">
            <label id="resp_form"> 
            
                           
                      <?php echo $form->labelEx($model,'module_id'); ?>
                        
                              <?php echo $form->dropDownList($model, 'module_id',
		CHtml::listData(Modules::model()->findAll(),'id','module_name'),
		array('prompt'=>Yii::t('app','-- Please select module --'))
		); ?>
                              <?php echo $form->error($model,'module_id'); ?>
            </label>
        </div>
        
        
        <div class="col-submit">         
                                
                                <?php if(!isset($_GET['id'])){
                                         if(!isAchiveMode($acad_sess))
                                            echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
                                         
                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary')); //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
                                        }
                                         else
                                           {  if(!isAchiveMode($acad_sess))
                                                 echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
                                            
                                              echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                                              
                                             } 
                                           //back button   
                                              $url=Yii::app()->request->urlReferrer;
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                          

                                ?>
                                
                  </div>         
                      
                </form>
              </div>


  
    
 
			