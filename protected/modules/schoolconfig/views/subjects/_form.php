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
<?php $this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); ?>

<?php
	echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p>';

	  echo $form->errorSummary($model); ?>

		
   
<div  id="resp_form_siges">

<form  id="resp_form">



	  <div class="col-4">
			    <label id="resp_form">

<?php echo $form->labelEx($model,'subject_name'); ?>
                              <?php echo $form->textField($model,'subject_name',array('size'=>60,'maxlength'=>45,'placeholder'=>Yii::t('app','Subject Name'))); ?>
                              <?php echo $form->error($model,'subject_name'); ?>
              </label>
</div>
	
	
<div class="col-4">
			    <label id="resp_form">

<?php echo $form->labelEx($model,'short_subject_name'); ?>
                              <?php echo $form->textField($model,'short_subject_name',array('size'=>60,'maxlength'=>5,'placeholder'=>Yii::t('app','Short Subject Name'))); ?>
                              <?php echo $form->error($model,'short_subject_name'); ?>
              </label>
</div>	
	
<div class="col-4">
	<label id="resp_form">

<?php echo $form->labelEx($model,'is_subject_parent'); ?>
                              <?php 
                              if($this->is_subject_parent==1)
								{
									echo $form->checkBox($model,'is_subject_parent',array('onchange'=> 'submit()','checked'=>'checked') ); 
								
								}
						      elseif($this->is_subject_parent==0)
						        {
						        	echo $form->checkBox($model,'is_subject_parent',array('onchange'=> 'submit()') );
						          }
									
									
									?>
                              <?php echo $form->error($model,'is_subject_parent'); ?>
   </label>
</div>
	
	
<?php
    if($this->is_subject_parent==0)
		{

?>
<div class="col-4">
	<label id="resp_form">

<?php echo Yii::t('app','Parent Subjects'); ?>
                         <div> <?php 
			
								$criteria = new CDbCriteria(array('order'=>'subject_name','condition'=>'is_subject_parent=1'));
								
								echo $form->dropDownList($model, 'subject_parent',
								CHtml::listData(Subjects::model()->findAll($criteria),'id','subject_name'),
								array('prompt'=>Yii::t('app','-- Please select subject --'))
								);
								 ?></div>
					      </label>
</div>
	
<?php
    
		}

?>	
		

                           <div class="col-submit">
                                
                                <?php if(!isset($_GET['id'])){
                                          if(!isAchiveMode($acad_sess))
                                              echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
                                         
                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary')); //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
                                        }
                                         else
                                           {   if(!isAchiveMode($acad_sess))
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

</div><!-- END OF TEST -->
   
   
   
   
   
   
   
   
   