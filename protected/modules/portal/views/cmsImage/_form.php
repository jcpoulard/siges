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
 *//* @var $this CmsImageController */
/* @var $model CmsImage */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cms-image-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'label_image'); ?>
		<?php echo $form->textField($model,'label_image',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'label_image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type_image'); ?>
		<?php echo $form->textField($model,'type_image',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'type_image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nom_image'); ?>
		<?php echo $form->textField($model,'nom_image',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'nom_image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_publish'); ?>
		<?php echo $form->textField($model,'is_publish'); ?>
		<?php echo $form->error($model,'is_publish'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->