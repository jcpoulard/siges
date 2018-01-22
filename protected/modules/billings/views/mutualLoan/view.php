<?php
/* @var $this MutualLoanController */
/* @var $model MutualLoan */

$this->breadcrumbs=array(
	'Mutual Loans'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List MutualLoan', 'url'=>array('index')),
	array('label'=>'Create MutualLoan', 'url'=>array('create')),
	array('label'=>'Update MutualLoan', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MutualLoan', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MutualLoan', 'url'=>array('admin')),
);
?>

<h1>View MutualLoan #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'person_id',
		'loan_date',
		'amount',
		'interet',
		'solde',
		'paid',
		'date_updated',
	),
)); ?>
