<?php
/* @var $this MutualController */
/* @var $model Mutual */

$this->breadcrumbs=array(
	'Mutuals'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Mutual', 'url'=>array('index')),
	array('label'=>'Create Mutual', 'url'=>array('create')),
	array('label'=>'Update Mutual', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Mutual', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Mutual', 'url'=>array('admin')),
);
?>

<h1>View Mutual #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'person_id',
		'amount',
		'deposit_date',
	),
)); ?>
