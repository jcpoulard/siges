<?php 
/*
 * © 2015 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
 * 
 * This file is part of SIGES.

    SIGES is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License.

    SIGES is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with SIGES.  If not, see <http://www.gnu.org/licenses/>.
 * 
 */

?>
<?php
/* @var $this HomeworkSubmissionController */
/* @var $model HomeworkSubmission */

$this->breadcrumbs=array(
	'Homework Submissions'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List HomeworkSubmission', 'url'=>array('index')),
	array('label'=>'Create HomeworkSubmission', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#homework-submission-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Homework Submissions</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'homework-submission-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'student',
		'homework_id',
		'date_submission',
		'comment',
		'attachment_ref',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
