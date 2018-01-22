<?php
/* @var $this MutualController */
/* @var $model Mutual */

$this->breadcrumbs=array(
	'Mutuals'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Mutual', 'url'=>array('index')),
	array('label'=>'Create Mutual', 'url'=>array('create')),
	array('label'=>'View Mutual', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Mutual', 'url'=>array('admin')),
);
?>

<h1>Update Mutual <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>