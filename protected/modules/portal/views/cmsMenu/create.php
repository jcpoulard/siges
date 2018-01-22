<?php
/* @var $this CmsMenuController */
/* @var $model CmsMenu */

$this->breadcrumbs=array(
	'Cms Menus'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CmsMenu', 'url'=>array('index')),
	array('label'=>'Manage CmsMenu', 'url'=>array('admin')),
);
?>

<h1>Create CmsMenu</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>