<?php
/* @var $this MutualLoanController */
/* @var $model MutualLoan */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'mutual-loan-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'person_id'); ?>
		<?php echo $form->textField($model,'person_id'); ?>
		<?php echo $form->error($model,'person_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'loan_date'); ?>
		<?php echo $form->textField($model,'loan_date'); ?>
		<?php echo $form->error($model,'loan_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'amount'); ?>
		<?php echo $form->textField($model,'amount'); ?>
		<?php echo $form->error($model,'amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'interet'); ?>
		<?php echo $form->textField($model,'interet'); ?>
		<?php echo $form->error($model,'interet'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'solde'); ?>
		<?php echo $form->textField($model,'solde'); ?>
		<?php echo $form->error($model,'solde'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'paid'); ?>
		<?php echo $form->textField($model,'paid'); ?>
		<?php echo $form->error($model,'paid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_updated'); ?>
		<?php echo $form->textField($model,'date_updated'); ?>
		<?php echo $form->error($model,'date_updated'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->