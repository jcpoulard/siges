<div class="form">
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
 
 
 $acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

 
 
 $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'record-infraction-form',
	'enableAjaxValidation'=>false,
));

 ?>
<p class="note">
    
    <?php echo Yii::t('app','Fields with <span class="required">*</span> are required.'); ?>
</p>
	<?php echo $form->errorSummary($model); ?>

<div  id="resp_form_siges">

<form  id="resp_form">
        
        <div class="col-3">
            <label id="resp_form">
                <?php echo $form->labelEx($model,'student'); ?>
                
                <?php 
                  $criteria = new CDbCriteria(array('order'=>'last_name','condition'=>'is_student=1 AND active IN (1,2)'));

                 echo $form->dropDownList($model, 'student',
                            CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),
                            array('prompt'=>Yii::t('app','-- Please select student --'),'disabled'=>false)
                            );
                  ?>
            </label>
        </div>
                          
            <div class="col-3">
            <label id="resp_form">
            <?php echo $form->labelEx($model,'infraction_type'); ?>
                              <?php 
                                $criteria = new CDbCriteria(array('order'=>'name'));
                                echo $form->dropDownList($model, 'infraction_type',
                                CHtml::listData(InfractionType::model()->findAll($criteria),'id','name'),
                                array('prompt'=>Yii::t('app','-- Please select infraction --'),'disabled'=>false)
                                );
                              ?>
            </label>
            </div>
    
        
              
            <div class="col-3">
            <label id="resp_form">
    
                                 <?php echo $form->labelEx($model,'deduct_note');  ?>
                           
                                <?php  if($this->deduct_note==1)
                                         echo $form->checkBox($model,'deduct_note',array('checked'=>'checked') );
                                       elseif($this->deduct_note==0)
                                          echo $form->checkBox($model,'deduct_note');
                                       
                                   ?>
                                
                                <?php echo $form->error($model,'deduct_note');  ?>
            </label>
            </div>
            
            
            
            <div class="col-3">
            <label id="resp_form">
                                <?php echo $form->labelEx($model,'record_by'); ?>
                            
                                <?php 
                               
                                $criteria = new CDbCriteria(array('order'=>'last_name','condition'=>'is_student<>1 AND active IN (1,2)'));
                                echo $form->dropDownList($model, 'record_by',
                                CHtml::listData(Persons::model()->findAll($criteria),'fullName','fullName'),
                                array('prompt'=>Yii::t('app','-- Please select staff --'),'disabled'=>false)
                                );
                              
                                ?>
                        
            </label>
            </div>
    
            <div class="col-3">
            <label id="resp_form">
                               <?php echo $form->labelEx($model,'incident_date'); ?>
                            
                                <?php 
                             
                                $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
                                                     'model'=>'$model',
                                                     'name'=>'RecordInfraction[incident_date]',
                                                     'language' => 'fr',  
                                                     'value'=>date('Y-m-d'),
                                                     'htmlOptions'=>array('size'=>60, 'style'=>'width:100% !important'),
									 'options'=>array(
									 'showButtonPanel'=>true,
                                                                         'yearRange'=>'2012:2100',    
									 'changeYear'=>true,                                      
									 'changeYear'=>true,
                                                                        'dateFormat'=>'yy-mm-dd',   
									 ),
								 )
							 );
				?>
            </label>
            </div>
    
            <div class="col-3">
            <label id="resp_form">
                               <?php echo $form->labelEx($model,'incident_description'); ?> 
                            
                                <?php echo $form->textArea($model,'incident_description',array('rows'=>4, 'cols'=>60,'placeholder'=>Yii::t('app','Incident Description'))); ?>
            </label>
            </div>
    
            <div class="col-3">
            <label id="resp_form">
                                <?php echo $form->labelEx($model,'decision_description'); ?>
                            
                                <?php echo $form->textArea($model,'decision_description',array('rows'=>4, 'cols'=>60,'placeholder'=>Yii::t('app','Decision Description'))); ?>
            </label>
            </div>
      
    
            <div class="col-3">
            <label id="resp_form">
                                <?php echo $form->labelEx($model,'general_comment'); ?>
                            
                                <?php echo $form->textArea($model,'general_comment',array('rows'=>4, 'cols'=>60,'placeholder'=>Yii::t('app','General Comment'))); ?>
            </label>
            </div>
                        
                        <div class="col-submit">
                                
                                <?php if(!isset($_GET['id'])){
                                          if(!isAchiveMode($acad_sess))
                                              echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning'));
                                         
                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                                        }
                                         else
                                           {   if(!isAchiveMode($acad_sess))
                                                  echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
                                            
                                              echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                                              
                                             } 
                                           //back button   
                                              $url=Yii::app()->request->urlReferrer;
                                              $explode_url= explode("php",substr($url,0));
				             
                                             if(!isset($_GET['from']))
                                                echo '<a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';

                                ?>
                        </div>         
                            


<?php $this->endWidget(); ?>

</form>
</div>
                                
</div>