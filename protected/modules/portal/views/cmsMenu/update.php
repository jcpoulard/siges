<?php
/* @var $this CmsMenuController */
/* @var $model CmsMenu */

$this->breadcrumbs=array(
	'Cms Menus'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CmsMenu', 'url'=>array('index')),
	array('label'=>'Create CmsMenu', 'url'=>array('create')),
	array('label'=>'View CmsMenu', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CmsMenu', 'url'=>array('admin')),
);
?>

<h1>Update CmsMenu <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>