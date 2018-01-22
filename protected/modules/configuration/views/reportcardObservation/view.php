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




/* @var $this ReportcardObservationController */
/* @var $model ReportcardObservation */

$this->breadcrumbs=array(
	'Reportcard Observations'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ReportcardObservation', 'url'=>array('index')),
	array('label'=>'Create ReportcardObservation', 'url'=>array('create')),
	array('label'=>'Update ReportcardObservation', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ReportcardObservation', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ReportcardObservation', 'url'=>array('admin')),
);
?>

<h1>View ReportcardObservation #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'Section',
		'start_range',
		'end_range',
		'comment',
		'academic_year',
		'create_by',
		'update_by',
		'create_date',
		'update_date',
	),
)); ?>
