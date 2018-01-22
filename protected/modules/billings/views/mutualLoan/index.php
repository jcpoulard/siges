<?php
/* @var $this MutualLoanController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Mutual Loans',
);

$this->menu=array(
	array('label'=>'Create MutualLoan', 'url'=>array('create')),
	array('label'=>'Manage MutualLoan', 'url'=>array('admin')),
);
?>

<h1>Mutual Loans</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
