<?php
/* @var $this MutualController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Mutuals',
);

$this->menu=array(
	array('label'=>'Create Mutual', 'url'=>array('create')),
	array('label'=>'Manage Mutual', 'url'=>array('admin')),
);
?>

<h1>Mutuals</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
