<?php
/* @var $this CmsMenuController */
/* @var $data CmsMenu */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('menu_label')); ?>:</b>
	<?php echo CHtml::encode($data->menu_label); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('menu_position')); ?>:</b>
	<?php echo CHtml::encode($data->menu_position); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_publish')); ?>:</b>
	<?php echo CHtml::encode($data->is_publish); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_create')); ?>:</b>
	<?php echo CHtml::encode($data->date_create); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_update')); ?>:</b>
	<?php echo CHtml::encode($data->date_update); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_by')); ?>:</b>
	<?php echo CHtml::encode($data->create_by); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('update_by')); ?>:</b>
	<?php echo CHtml::encode($data->update_by); ?>
	<br />

	*/ ?>

</div>