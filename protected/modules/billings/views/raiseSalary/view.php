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
/* @var $this RaiseSalaryController */
/* @var $model RaiseSalary */

$this->breadcrumbs=array(
	'Raise Salaries'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List RaiseSalary', 'url'=>array('index')),
	array('label'=>'Create RaiseSalary', 'url'=>array('create')),
	array('label'=>'Update RaiseSalary', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete RaiseSalary', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage RaiseSalary', 'url'=>array('admin')),
);
?>

<h1>View RaiseSalary #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'person_id',
		'amount',
		'rising_date',
		'academic_year',
	),
)); ?>
