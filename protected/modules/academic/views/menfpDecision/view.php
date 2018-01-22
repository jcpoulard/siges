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
/* @var $this MenfpDecisionController */
/* @var $model MenfpDecision */

$this->breadcrumbs=array(
	'Menfp Decisions'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List MenfpDecision', 'url'=>array('index')),
	array('label'=>'Create MenfpDecision', 'url'=>array('create')),
	array('label'=>'Update MenfpDecision', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MenfpDecision', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MenfpDecision', 'url'=>array('admin')),
);
?>

<h1>View MenfpDecision #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'student',
		'total_grade',
		'mension',
		'academic_year',
	),
)); ?>
