<?php
/* @var $this CmsMenuController */
/* @var $model CmsMenu */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cms-menu-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'menu_label'); ?>
		<?php echo $form->textField($model,'menu_label',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'menu_label'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'menu_position'); ?>
		<?php echo $form->textField($model,'menu_position'); ?>
		<?php echo $form->error($model,'menu_position'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_publish'); ?>
		<?php echo $form->textField($model,'is_publish'); ?>
		<?php echo $form->error($model,'is_publish'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_create'); ?>
		<?php echo $form->textField($model,'date_create'); ?>
		<?php echo $form->error($model,'date_create'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_update'); ?>
		<?php echo $form->textField($model,'date_update'); ?>
		<?php echo $form->error($model,'date_update'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'create_by'); ?>
		<?php echo $form->textField($model,'create_by',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'create_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'update_by'); ?>
		<?php echo $form->textField($model,'update_by',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'update_by'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->