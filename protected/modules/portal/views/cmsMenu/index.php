<?php
/* @var $this CmsMenuController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Cms Menus',
);

$this->menu=array(
	array('label'=>'Create CmsMenu', 'url'=>array('create')),
	array('label'=>'Manage CmsMenu', 'url'=>array('admin')),
);
?>

<h1>Cms Menus</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
