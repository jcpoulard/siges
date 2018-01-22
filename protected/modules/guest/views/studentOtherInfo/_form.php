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
/* @var $this StudentOtherInfoController */
/* @var $model StudentOtherInfo */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'student-other-info-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'student'); ?>
		<?php echo $form->textField($model,'student'); ?>
		<?php echo $form->error($model,'student'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'school_date_entry'); ?>
		<?php echo $form->textField($model,'school_date_entry'); ?>
		<?php echo $form->error($model,'school_date_entry'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'leaving_date'); ?>
		<?php echo $form->textField($model,'leaving_date'); ?>
		<?php echo $form->error($model,'leaving_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'previous_school'); ?>
		<?php echo $form->textField($model,'previous_school',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'previous_school'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'previous_level'); ?>
		<?php echo $form->textField($model,'previous_level',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'previous_level'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_created'); ?>
		<?php echo $form->textField($model,'date_created'); ?>
		<?php echo $form->error($model,'date_created'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_update'); ?>
		<?php echo $form->textField($model,'date_update'); ?>
		<?php echo $form->error($model,'date_update'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'create_by'); ?>
		<?php echo $form->textField($model,'create_by',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'create_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'update_by'); ?>
		<?php echo $form->textField($model,'update_by',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'update_by'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->