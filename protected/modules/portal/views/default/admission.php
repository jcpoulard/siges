<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 
?>
<div class="container" style=" width: 100%; margin: 10px auto;" >
    
    <div class="row">
        <div class="col-md-2">
            
        </div>
        <div class="col-md-8">
   
    
      <?php 
      $form=$this->beginWidget('CActiveForm', array(
	'id'=>'products-form',
	'enableAjaxValidation'=>false,
        )); 
      ?>
        
    <div class="form-group col-md-6"> 
        <?php echo $form->labelEx($model,'last_name',array('for'=>'last_name')); ?>
        <?php echo $form->textField($model,'last_name',array('size'=>60,'maxlength'=>128,'placeholder'=>Yii::t('app','Last name'),'class'=>'form-control')); ?>
        <?php echo $form->error($model,'last_name'); ?>
    </div>
    
     <div class="form-group col-md-6"> 
        <?php echo $form->labelEx($model,'first_name',array('for'=>'first_name')); ?>
        <?php echo $form->textField($model,'first_name',array('size'=>60,'maxlength'=>128,'placeholder'=>Yii::t('app','First name'),'class'=>'form-control')); ?>
        <?php echo $form->error($model,'first_name'); ?>
    </div>
        
        
    <div class="form-group col-md-6">
        <label for="blood_group"><?php echo Yii::t('app','Blood Group');?></label>
        <?php echo $form->dropDownList($model,'blood_group',$model->getBlood_groupValue(),array('prompt'=>Yii::t('app','-- Select blood group --'),'class'=>'form-control')); ?>
        <?php echo $form->error($model,'blood_group'); ?>
    </div>
    
    <div class="form-group col-md-6">
       
        <?php echo $form->labelEx($model,'gender',array('for'=>'gender')); ?>
        <?php echo $form->dropDownList($model,'gender',$model->getGenders(),array('prompt'=>Yii::t('app','-- Select gender --'),'class'=>'form-control')); ?>
    </div>
           
    
    <div class="form-group col-md-6">
        <?php echo $form->labelEx($model,'birthday',array('for'=>'birthday')); ?>
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
                             array(
                             'model'=>'$model',
                             'name'=>'Persons[birthday]',
                             'language'=>'fr',
                             'value'=>$model->birthday,
                             'htmlOptions'=>array('size'=>60, 'style'=>'width:100% !important','placeholder'=>Yii::t('app','Birthday'),'class'=>'form-control'),
                                     'options'=>array(
                                     'showButtonPanel'=>true,
                                     'changeYear'=>true,                                      
                                     'dateFormat'=>'yy-mm-dd',
                                     'yearRange'=>'1900:2100',
                                     'changeMonth'=>true,
                                     'showButtonPane'=>true,
                                            
                                      'dateFormat'=>'yy-mm-dd',   
                                     ),
                             )
                     );
                     ?>
		<?php echo $form->error($model,'birthday'); ?>
    </div>
    
    <div class="form-group col-md-6">
        <label for="cities">
            <?php echo Yii::t('app','Birth place'); ?> 
        </label>
                        <?php 
                            $criteria = new CDbCriteria(array('order'=>'city_name'));
		
                            echo $form->dropDownList($model, 'cities',
                            CHtml::listData(Cities::model()->findAll($criteria),'id','city_name'),
                            array('prompt'=>Yii::t('app','-- Please select city --'),'class'=>'form-control')
                            );
                            ?>
    </div>
    
    <div class="form-group col-md-6">
        <?php echo $form->labelEx($model,'phone',array('for'=>'phone')); ?>
        <?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>45,'placeholder'=>Yii::t('app','Phone'),'class'=>'form-control')); ?>
        <?php echo $form->error($model,'phone'); ?>
    </div>
    
    <div class="form-group col-md-6">
        <?php echo $form->labelEx($model,'email',array('for'=>'email')); ?>

        <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>45,'placeholder'=>Yii::t('app','Email'),'class'=>'form-control')); ?>
        <?php echo $form->error($model,'email'); ?>
    </div>
            
    <div class="form-group col-md-6">
        <?php echo $form->labelEx($model,'adresse',array('for'=>'adresse')); ?>
        <?php echo $form->textField($model,'adresse',array('size'=>60,'maxlength'=>255,'placeholder'=>Yii::t('app','Adresse'),'class'=>'form-control')); ?>
        <?php echo $form->error($model,'adresse'); ?>
    </div>
            
    <div class="form-group col-md-6">
        <?php echo $form->labelEx($model,'citizenship',array('for'=>'citizenship')); ?>
        <?php echo $form->textField($model,'citizenship',array('size'=>60,'maxlength'=>45,'placeholder'=>Yii::t('app','Citizenship'),'class'=>'form-control')); 
            echo $form->error($model,'citizenship'); 
        ?>
    </div>
            
    <div class="form-group col-md-6">
            <?php echo $form->labelEx($modelStudentOtherInfo,'father_full_name',array('for'=>'father_full_name')); ?>
                        <?php 
                              echo $form->textField($modelStudentOtherInfo,'father_full_name',array('size'=>60,'maxlength'=>100,'placeholder'=>Yii::t('app','Father full name'),'class'=>'form-control')); ?>
                        <?php echo $form->error($modelStudentOtherInfo,'father_full_name'); ?>
    </div>        
    
    <div class="form-group col-md-6">
            <?php echo $form->labelEx($modelStudentOtherInfo,'mother_full_name',array('for'=>'mother_full_name')); ?>
                        <?php 
                              echo $form->textField($modelStudentOtherInfo,'mother_full_name',array('size'=>60,'maxlength'=>100,'placeholder'=>Yii::t('app','Mother full name'),'class'=>'form-control')); ?>
                        <?php echo $form->error($modelStudentOtherInfo,'mother_full_name'); ?>
    </div> 
    <div class="form-group col-md-6">
          <?php 
                echo $form->labelEx($modelStudentOtherInfo,'person_liable',array('for'=>'person_liable'));                        
                echo $form->textField($modelStudentOtherInfo,'person_liable',array('size'=>60,'maxlength'=>100,'placeholder'=>Yii::t('app','Person liable'),'class'=>'form-control'));  
                echo $form->error($modelStudentOtherInfo,'person_liable'); 
          ?>
    </div>
    
    <div class="form-group col-md-6">
        <?php echo $form->labelEx($modelStudentOtherInfo,'person_liable_phone',array('for'=>'person_liable_phone')); 
               echo $form->textField($modelStudentOtherInfo,'person_liable_phone',array('size'=>60,'maxlength'=>65,'placeholder'=>Yii::t('app','Person liable phone'),'class'=>'form-control'));
               echo $form->error($modelStudentOtherInfo,'person_liable_phone'); 
        ?>
    </div>
            
    <div class="form-group col-md-6">
        <?php  
            echo $form->labelEx($modelStudentOtherInfo,'previous_school',array('for'=>'previous_school'));
            echo $form->textField($modelStudentOtherInfo,'previous_school',array('size'=>60,'maxlength'=>255,'placeholder'=>Yii::t('app','Previous School'),'class'=>'form-control'));
            echo $form->error($modelStudentOtherInfo,'previous_school'); 
         ?>
    </div> 
            
    <div class="form-group col-md-6">
        
        <?php 
            echo $form->labelEx($model,'admission_en',array('for'=>'admission_en')); 
            echo $form->dropDownList($model,'admission_en',$this->loadLevel(),array('class'=>'form-control')); 
            echo $form->error($model,'admission_en'); 
        ?>
    </div>
            
            <div class="col-md-6">
              
                <button type='submit' name="btn_save" class="glyphicon glyphicon-save btn btn-success"> Imprimer formulaire</button> 
            </div>
            
            <div class="col-md-6">
              
                <button type="submit" name="btn_cancel" class="glyphicon glyphicon-trash btn btn-danger"> Annuler l'inscription</button> 
            </div>
            
    <?php $this->endWidget(); ?>
   
    
        </div>
    <div class="col-md-2">
        
        
    </div>
    </div>
</div>