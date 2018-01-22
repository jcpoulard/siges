<?php
/* @var $this CmsMenuController */
/* @var $model CmsMenu */

$this->breadcrumbs=array(
	'Cms Menus'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CmsMenu', 'url'=>array('index')),
	array('label'=>'Create CmsMenu', 'url'=>array('create')),
	array('label'=>'Update CmsMenu', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CmsMenu', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CmsMenu', 'url'=>array('admin')),
);
?>

<h1>View CmsMenu #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'menu_label',
		'menu_position',
		'is_publish',
		'date_create',
		'date_update',
		'create_by',
		'update_by',
	),
)); ?>
