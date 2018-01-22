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
/* @var $this AccountingController */
/* @var $model Accounting */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'accounting-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php
	echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p>';

	  echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'old_balance'); ?>
		<?php echo $form->textField($model,'old_balance'); ?>
		<?php echo $form->error($model,'old_balance'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'outgoings'); ?>
		<?php echo $form->textField($model,'outgoings'); ?>
		<?php echo $form->error($model,'outgoings'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'incomings'); ?>
		<?php echo $form->textField($model,'incomings'); ?>
		<?php echo $form->error($model,'incomings'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'new_balance'); ?>
		<?php echo $form->textField($model,'new_balance'); ?>
		<?php echo $form->error($model,'new_balance'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'month'); ?>
		<?php echo $form->textField($model,'month'); ?>
		<?php echo $form->error($model,'month'); ?>
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