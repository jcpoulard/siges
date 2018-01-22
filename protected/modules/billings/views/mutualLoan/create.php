<?php
/* @var $this MutualLoanController */
/* @var $model MutualLoan */

$this->breadcrumbs=array(
	'Mutual Loans'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MutualLoan', 'url'=>array('index')),
	array('label'=>'Manage MutualLoan', 'url'=>array('admin')),
);
?>

<h1>Create MutualLoan</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>