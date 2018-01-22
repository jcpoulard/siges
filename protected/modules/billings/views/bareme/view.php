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



/* @var $this BaremeController */
/* @var $model Bareme */

$this->breadcrumbs=array(
	'Baremes'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Bareme', 'url'=>array('index')),
	array('label'=>'Create Bareme', 'url'=>array('create')),
	array('label'=>'Update Bareme', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Bareme', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Bareme', 'url'=>array('admin')),
);
?>

<h1>View Bareme #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'min_value',
		'max_value',
		'percentage',
		'compteur',
		'old_new',
	),
)); ?>
