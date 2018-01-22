<?php
/* @var $this MutualController */
/* @var $model Mutual */

$this->breadcrumbs=array(
	'Mutuals'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Mutual', 'url'=>array('index')),
	array('label'=>'Manage Mutual', 'url'=>array('admin')),
);
?>

<h1>Create Mutual</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>