<?php
/* @var $this MutualLoanController */
/* @var $model MutualLoan */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'person_id'); ?>
		<?php echo $form->textField($model,'person_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'loan_date'); ?>
		<?php echo $form->textField($model,'loan_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'amount'); ?>
		<?php echo $form->textField($model,'amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'interet'); ?>
		<?php echo $form->textField($model,'interet'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'solde'); ?>
		<?php echo $form->textField($model,'solde'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'paid'); ?>
		<?php echo $form->textField($model,'paid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_updated'); ?>
		<?php echo $form->textField($model,'date_updated'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->