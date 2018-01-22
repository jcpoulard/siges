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
 *//* @var $this CustomFieldController */
/* @var $model CustomField */
/* @var $form CActiveForm */

$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'custom-field-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('app','Fields with <span class="required">*</span> are required.'); ?></p>

	<?php echo $form->errorSummary($model); ?>


<div  id="resp_form_siges">

<form  id="resp_form">
        
        <div class="col-2">
            <label id="resp_form">
		<?php echo $form->labelEx($model,'field_name'); ?>
		<?php echo $form->textField($model,'field_name',array('size'=>60,'maxlength'=>64,'placeholder'=>Yii::t('app','Field name'))); ?>
		<?php echo $form->error($model,'field_name'); ?>
            </label>                  
	</div>

	 <div class="col-2">
            <label id="resp_form">
		<?php echo $form->labelEx($model,'field_label'); ?>
		<?php echo $form->textField($model,'field_label',array('size'=>45,'maxlength'=>45,'placeholder'=>Yii::t('app','Field label'))); ?>
		<?php echo $form->error($model,'field_label'); ?>
            </label>
	</div>

	<div class="col-2">
            <label id="resp_form">
		<?php echo $form->labelEx($model,'field_type'); ?>
            <?php echo $form->dropDownList($model, 'field_type',$model->getFieldType(),array('onchange'=> 'submit()','options' => array($this->field_type=>array('selected'=>true)))); ?>
		<?php // echo $form->textField($model,'field_type',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'field_type'); ?>
            </label>
	</div>
        
        <?php
        if(isset($_GET['id'])){
            $this->field_type = $model->field_type;
        }
        if($this->field_type === "combo") { ?>
       <div class="col-2">
            <label id="resp_form">
		<?php echo $form->labelEx($model,'field_option'); ?>
		<?php echo $form->textArea($model,'field_option',array('size'=>60,'maxlength'=>1024,'placeholder'=>Yii::t('app','Type each element of the list separate by a comma'))); ?>
		<?php echo $form->error($model,'field_option'); ?>
            </label>
	</div>
        <?php } ?>
        
        
      
    
	<div class="col-2">
            <label id="resp_form">
		<?php echo $form->labelEx($model,'field_related_to'); ?>
             <?php echo $form->dropDownList($model, 'field_related_to',$model->getPersonType(),array('options' => array($this->field_related_to=>array('selected'=>true)) )); ?>
		<?php // echo $form->textField($model,'field_related_to',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'field_related_to'); ?>
            </label>
	</div>
    

      <?php 
               if(!isAchiveMode($acad_sess))
                 {     $template ='';    
        ?>
   
	<div class="col-submit">
		<?php echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning')); ?>
	</div>
	               
      <?php
                 }
      
      ?>       


<?php $this->endWidget(); ?>
    
</form>
</div>

</div><!-- form -->