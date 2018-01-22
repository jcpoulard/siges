<?php
/* @var $this MutualLoanController */
/* @var $model MutualLoan */

$this->breadcrumbs=array(
	'Mutual Loans'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List MutualLoan', 'url'=>array('index')),
	array('label'=>'Create MutualLoan', 'url'=>array('create')),
	array('label'=>'View MutualLoan', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage MutualLoan', 'url'=>array('admin')),
);
?>

<h1>Update MutualLoan <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>