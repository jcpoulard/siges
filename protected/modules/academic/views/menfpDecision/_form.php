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
/* @var $this MenfpDecisionController */
/* @var $model MenfpDecision */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'menfp-decision-form',
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
		<?php echo $form->labelEx($model,'total_grade'); ?>
		<?php echo $form->textField($model,'total_grade'); ?>
		<?php echo $form->error($model,'total_grade'); ?>
	</div>

		<div class="row">
		<?php echo $form->labelEx($model,'average'); ?>
		<?php echo $form->textField($model,'average'); ?>
		<?php echo $form->error($model,'average'); ?>
	</div>

		<div class="row">
		<?php echo $form->labelEx($model,'mension'); ?>
		<?php echo $form->textField($model,'mension',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'mension'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'academic_year'); ?>
		<?php echo $form->textField($model,'academic_year'); ?>
		<?php echo $form->error($model,'academic_year'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->